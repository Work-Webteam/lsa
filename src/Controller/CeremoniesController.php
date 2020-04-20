<?php

namespace App\Controller;

use Cake\I18n\FrozenDate;
use Cake\Core\Configure;
use Cake\Error\Debugger;

class CeremoniesController extends AppController
{
    public function index()
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Ceremonies.'));
            $this->redirect('/');
        }
        $this->loadComponent('Paginator');
        $ceremonies = $this->Paginator->paginate($this->Ceremonies->find('all', [
            'conditions' => ['Ceremonies.award_year =' => date('Y')],
        ]));

        $isadmin = $this->checkAuthorization(Configure::read('Role.admin'));
        $this->set(compact('isadmin'));
        $this->set(compact('ceremonies'));
    }

    public function view($id = null)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Ceremonies.'));
            $this->redirect('/');
        }
        $ceremony = $this->Ceremonies->findById($id)->firstOrFail();

        $attending = json_decode($ceremony->attending, true);
        $this->set(compact('attending'));

        $isadmin = $this->checkAuthorization(Configure::read('Role.admin'));
        $this->set(compact('isadmin'));
        $this->set(compact('ceremony'));
    }

    public function add()
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Ceremonies.'));
            $this->redirect('/');
        }
        $ceremony = $this->Ceremonies->newEmptyEntity();
        $this->Flash->success('add pre post');
        if ($this->request->is('post')) {
            $this->Flash->success(__('add post'));
            $ceremony = $this->Ceremonies->patchEntity($ceremony, $this->request->getData());
            $ceremony->award_year = date("Y");
            $ceremony->date = $this->request->getData('ceremony_date') . " " . $this->request->getData('ceremony_time');
            $ceremony->attending = json_encode(array());
            if ($this->Ceremonies->save($ceremony)) {
                $this->Flash->success(__('Your ceremony has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your ceremony.'));
        }
        $ceremony->award_year = date("Y");
        $this->set('ceremony', $ceremony);
    }

    public function edit($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Ceremonies.'));
            $this->redirect('/');
        }
        $ceremony = $this->Ceremonies->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Ceremonies->patchEntity($ceremony, $this->request->getData());
            $ceremony->date = $this->request->getData('ceremony_date') . " " . $this->request->getData('ceremony_time');
            if ($this->Ceremonies->save($ceremony)) {
                $this->Flash->success(__('Ceremony has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update ceremony.'));
        }

        $this->set('ceremony', $ceremony);
    }


    public function delete($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Ceremonies.'));
            $this->redirect('/');
        }
        $this->request->allowMethod(['post', 'delete']);

        $ceremony = $this->Ceremonies->findById($id)->firstOrFail();
        if ($this->Ceremonies->delete($ceremony)) {
            $this->Flash->success(__('Ceremony night {0} has been deleted.', $ceremony->night));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function addattending($id) {

        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to administer Ceremonies.'));
            $this->redirect('/');
        }
        $ceremony = $this->Ceremonies->findById($id)->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            $ministry_id = $this->request->getData('ministry_id');
            if (!empty($ministry_id)) {
                $new = array(
                    'ministry' => $this->request->getData('ministry_id'),
                    'milestone' => $this->request->getData('milestone_id'),
                    'city' => array('id' => $this->request->getData('city_id'), 'type' => $this->request->getData('city_type'))
                );
                $attending = json_decode($ceremony->attending, true);
                $attending[] = $new;
                $ceremony->attending = json_encode($attending);
            }
            if ($this->Ceremonies->save($ceremony)) {
                $this->Flash->success(__('Ceremony Attendee has been saved.'));
                return $this->redirect(['action' => 'view/'.$ceremony->id]);
            }
            $this->Flash->error(__('Unable to add option.'));
        }


        $ministries = $this->Ceremonies->Ministries->find('list', [
            'order' => ['Ministries.name' => 'ASC']
        ]);
        $this->set('ministries', $ministries);

        $milestones = $this->Ceremonies->Milestones->find('list');
        $this->set('milestones', $milestones);

        $cities = $this->Ceremonies->Cities->find('list', [
            'order' => ['Cities.name' => 'ASC']
        ]);
        $this->set('cities', $cities);


        $this->set('ceremony', $ceremony);
    }
}

