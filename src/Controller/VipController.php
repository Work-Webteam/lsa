<?php

namespace App\Controller;

use Cake\Core\Configure;

class VipController extends AppController
{

    public function index()
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer VIPs.'));
            $this->redirect('/');
        }
        $this->loadComponent('Paginator');

        $vips = $this->Paginator->paginate($this->Vip->find());

        $isadmin = $this->checkAuthorization(Configure::read('Role.admin'));
        $this->set(compact('isadmin'));
        $this->set(compact('vips'));
    }

    public function view($id = null)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer VIPs.'));
            $this->redirect('/');
        }
        $vip = $this->Vip->findById($id)->firstOrFail();

        $isadmin = $this->checkAuthorization(Configure::read('Role.admin'));
        $this->set(compact('isadmin'));
        $this->set(compact('vip'));
    }

    public function add()
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer VIPs.'));
            $this->redirect('/');
        }
        $vip = $this->Vip->newEmptyEntity();
        if ($this->request->is('post')) {
            $vip = $this->Vip->patchEntity($vip, $this->request->getData());

            $session = $this->getRequest()->getSession();
            $vip->user_idir = $session->read('user.idir');
            $vip->user_guid = $session->read('user.guid');

            $vip->created = time();
            $vip->modified = time();

            $vip->year = date("Y");
            $vip->province = "BC";

            if ($this->Vip->save($vip)) {
                $this->Flash->success(__('Your VIP has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your VIP.'));
        }

        $this->set('vip', $vip);

        $cities = $this->Vip->Cities->find('list', [
            'order' => ['Cities.name' => 'ASC'],
        ]);
        $this->set('cities', $cities);


        $ministries = $this->Vip->Ministries->find('list', [
            'order' => ['Ministries.name' => 'ASC']
        ]);
        $this->set('ministries', $ministries);

        $list = $this->Vip->Ceremonies->find('all', [
            'order' => ['Ceremonies.night' => 'ASC'],
            'conditions' => ['Ceremonies.registration_year =' => date('Y')],
        ]);

        $ceremonies = [];
        foreach ($list as $ceremony) {
            $ceremonies[$ceremony->id] = "Night " . $ceremony->night . " - " . date("l, M j, Y", strtotime($ceremony->date));
        }
        $this->set('ceremonies', $ceremonies);

        $categories = $this->Vip->Categories->find('list', [
            'order' => ['Categories.name' => 'ASC']
        ]);
        $this->set('categories', $categories);

        $attending = [-1 => 'No Response', 0 => 'Not Attending', 1 => 'Attending'];
        $this->set('attending', $attending);
    }

    public function edit($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer VIPs.'));
            $this->redirect('/');
        }
        $vip = $this->Vip->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Vip->patchEntity($vip, $this->request->getData());

            $vip->modified = time();

            if ($this->Vip->save($vip)) {
                $this->Flash->success(__('VIP has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update VIP.'));
        }

        $this->set('vip', $vip);

        $cities = $this->Vip->Cities->find('list', [
            'order' => ['Cities.name' => 'ASC'],
        ]);
        $this->set('cities', $cities);

        $ministries = $this->Vip->Ministries->find('list', [
            'order' => ['Ministries.name' => 'ASC']
        ]);
        $this->set('ministries', $ministries);

        $list = $this->Vip->Ceremonies->find('all', [
            'order' => ['Ceremonies.night' => 'ASC'],
            'conditions' => ['Ceremonies.registration_year =' => date('Y')],
        ]);

        $ceremonies = [];
        foreach ($list as $ceremony) {
            $ceremonies[$ceremony->id] = "Night " . $ceremony->night . " - " . date("l, M j, Y", strtotime($ceremony->date));
        }
        $this->set('ceremonies', $ceremonies);

        $categories = $this->Vip->Categories->find('list', [
            'order' => ['Categories.name' => 'ASC']
        ]);
        $this->set('categories', $categories);

        $attending = [-1 => 'No Response', 0 => 'Not Attending', 1 => 'Attending'];
        $this->set('attending', $attending);
    }

    public function delete($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer VIPs.'));
            $this->redirect('/');
        }
        $this->request->allowMethod(['post', 'delete']);

        $vip = $this->Vip->findById($id)->firstOrFail();
        if ($this->Vip->delete($vip)) {
            $this->Flash->success(__('{0} has been deleted.', $vip->first_name . " " . $vip->last_name));
            return $this->redirect(['action' => 'index']);
        }
    }


    public function reportceremony($id) {

        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to view this page.'));
            $this->redirect('/');
        }

        $conditions = array();
        $conditions['Vip.year ='] = date('Y');
        $conditions['Vip.ceremony_id ='] = $id;
        $conditions['Vip.attending ='] = 1;

        $vips = $this->Vip->find('all', [
            'conditions' => $conditions,
            'contain' => [
                'Ministries',
                'City',
                'Ceremonies',
                'Categories',
            ],
        ]);

        $total_guests = 0;
        $results = [];
        foreach ($vips as $key => $vip) {
            $results[$key] = $vip;
            $results[$key]['vip_name'] = $vip['first_name'] . " " . $vip['last_name'];
            $results[$key]['guest_name'] = trim($vip['guest_first_name'] . " " . $vip['guest_last_name']);
            $total_guests++;
            if (!empty($results[$key]['guest_name'])) {
                $total_guests++;
            }
        }

        $this->set(compact('results'));

        $ceremony = $this->Vip->Ceremonies->findById($id)->firstOrFail();
        $this->set('ceremony', $ceremony);

        $this->set(compact('total_guests'));
    }



    public function exportbadges($id, $attending = true)
    {

        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to view this page.'));
            $this->redirect('/');
        }

        $conditions = array();
        $conditions['Vip.ceremony_id ='] = $id;
        $conditions['Vip.attending ='] = 1;

        $results = $this->Vip->find('all', [
            'conditions' => $conditions,
            'order' => ['Vip.last_name' => 'ASC'],
            'contain' => [
                'Ministries',
                'City',
                'Ceremonies',
                'Categories',
            ],
        ]);

        $attendees = [];
        foreach ($results as $vip) {
            $person = new \stdClass();
            $person->first_name = $vip->first_name;
            $person->last_name = $vip->last_name;
            $person->nametag_pre = $vip->prefix;
            $person->nametag_post = $vip->title;
            $attendees[] = $person;
            if (!empty($vip->guest_first_name) || !empty($vip->guest_last_name)) {
                $person = new \stdClass();
                $person->first_name = $vip->guest_first_name;
                $person->last_name = $vip->guest_last_name;
                $person->nametag_pre = $vip->guest_prefix;
                $person->nametag_post = $vip->guest_title;
                $attendees[] = $person;
            }
        }
        $this->set(compact('attendees'));

        $this->set('ceremony_id', $id);

        $ceremony = $this->Vip->Ceremonies->findById($id)->firstOrFail();
        $this->set('ceremony', $ceremony);


    }


    public function exportplacecards($id)
    {

        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to view this page.'));
            $this->redirect('/');
        }

        $conditions = array();
        $conditions['Vip.ceremony_id ='] = $id;
        $conditions['Vip.attending ='] = 1;

        $results = $this->Vip->find('all', [
            'conditions' => $conditions,
            'order' => ['Vip.last_name' => 'ASC'],
            'contain' => [
                'Ministries',
                'City',
                'Ceremonies',
                'Categories',
            ],
        ]);


        $attendees = [];
        foreach ($results as $vip) {
            $person = new \stdClass();
            $person->first_name = $vip->first_name;
            $person->last_name = $vip->last_name;
            $person->nametag_pre = $vip->prefix;
            $person->nametag_post = $vip->title;
            $attendees[] = $person;
            if (!empty($vip->guest_first_name) || !empty($vip->guest_last_name)) {
                $person = new \stdClass();
                $person->first_name = $vip->guest_first_name;
                $person->last_name = $vip->guest_last_name;
                $person->nametag_pre = $vip->guest_prefix;
                $person->nametag_post = $vip->guest_title;
                $attendees[] = $person;
            }
        }
        $this->set(compact('attendees'));

        $this->set('ceremony_id', $id);

        $ceremony = $this->Vip->Ceremonies->findById($id)->firstOrFail();
        $this->set('ceremony', $ceremony);

    }


}

