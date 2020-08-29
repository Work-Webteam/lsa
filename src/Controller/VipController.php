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
            $ceremonies[$ceremony->id] = "Night " . $ceremony->night;
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
            $ceremonies[$ceremony->id] = "Night " . $ceremony->night;
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

}

