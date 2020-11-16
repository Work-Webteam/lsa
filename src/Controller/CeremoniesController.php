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
            'conditions' => ['Ceremonies.registration_year =' => date('Y')],
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

        $list = $this->Ceremonies->Milestones->find('all');
        $milestones = array();
        foreach ($list as $value) {
            $milestones[$value->id] = $value->name;
        }
//dump($milestones);
        $attending = json_decode($ceremony->attending, true);

        foreach ($attending as $key => $item) {
            $ministry = $this->Ceremonies->Ministries->findById($item['ministry'])->firstOrFail();

            $attending[$key]['city_name'] = '';
            if (!empty($item['city']['id'])) {
                if ($item['city']['id'] <> -1) {
                    $city = $this->Ceremonies->Cities->findById($item['city']['id'])->firstOrFail();
                    $attending[$key]['city_name'] = $city->name;
                }
                else {
                    $attending[$key]['city_name'] = "Vancouver/Victoria";
                }
            }
            $attending[$key]['ministry_name'] = $ministry->name;


            $attending[$key]['milestones'] = "";
            if (isset($item['milestone'])) {
                foreach($item['milestone'] as $milestone) {
                    if ($milestone) {
                        if (!empty($attending[$key]['milestones'])) {
                            $attending[$key]['milestones'] .= ",";
                        }
                        $attending[$key]['milestones'] .= str_replace(' Years', '', $milestones[$milestone]);
                    }
                }
            }
        }

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
        if ($this->request->is('post')) {
            $ceremony = $this->Ceremonies->patchEntity($ceremony, $this->request->getData());
            $ceremony->registration_year = date("Y");
            $ceremony->date = $this->request->getData('ceremony_date') . " " . $this->request->getData('ceremony_time');
            $ceremony->attending = json_encode(array());
            if ($this->Ceremonies->save($ceremony)) {
                $this->Flash->success(__('Your ceremony has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your ceremony.'));
        }
        $ceremony->registration_year = date("Y");
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

        $milestones = $this->Ceremonies->Milestones->find('all');

        if ($this->request->is(['post', 'put'])) {
            $ministry_id = $this->request->getData('ministry_id');
            if (!empty($ministry_id)) {
                $type = "";
                if ($this->request->getData('city_id')) {
                    $type = $this->request->getData('city_type');
                }
                $list = array();

                foreach ($milestones as $milestone) {
                    $test = $this->request->getData('milestone-' . $milestone->id);
                    if ($test) {
                        $list[] = $milestone->id;
                    }
                }
                $names = array();
                if ($this->request->getData('name_filter')) {
                    $names = array('start' => strtoupper($this->request->getData('name_start')), 'end' => strtoupper($this->request->getData('name_end')));
                }

                $new = array(
                    'ministry' => $this->request->getData('ministry_id'),
                    'milestone' => $list,
                    'city' => array('id' => $this->request->getData('city_id'), 'type' => $type),
                    'name' => $names,
                    'processed' => false,
                );
                $attending = json_decode($ceremony->attending, true);
                $attending[] = $new;
                debug($attending);
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


        $this->set('milestones', $milestones);

        $cities = $this->Ceremonies->Cities->find('list', [
            'order' => ['Cities.name' => 'ASC'],
        ])
            ->where([
                'Cities.name IN' => ['Vancouver', 'Victoria']
            ]);

        $temp = array();
        foreach($cities as $key => $city) {
            $temp[$key] = $city;
        }
        $temp[-1] = "Vancouver/Victoria";
        $this->set('cities', $temp);


        $this->set('ceremony', $ceremony);
    }



    public function editattending($id, $key)
    {

        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to administer Ceremonies.'));
            $this->redirect('/');
        }
        $ceremony = $this->Ceremonies->findById($id)->firstOrFail();

        $milestones = $this->Ceremonies->Milestones->find('all');


        if ($this->request->is(['post', 'put'])) {
            $ministry_id = $this->request->getData('ministry_id');
            if (!empty($ministry_id)) {
                $type = "";
                if ($this->request->getData('city_id')) {
                    $type = $this->request->getData('city_type');
                }
                $list = array();

                foreach ($milestones as $milestone) {
                    $test = $this->request->getData('milestone-' . $milestone->id);
                    if ($test) {
                        $list[] = $milestone->id;
                    }
                }
                $names = array();
                if ($this->request->getData('name_filter')) {
                   $names = array('start' => strtoupper($this->request->getData('name_start')), 'end' => strtoupper($this->request->getData('name_end')));
                }

                $attending = json_decode($ceremony->attending, true);
                $update = array(
                    'ministry' => $this->request->getData('ministry_id'),
                    'milestone' => $list,
                    'city' => array('id' => $this->request->getData('city_id'), 'type' => $type),
                    'name' => $names,
                    'processed' => isset($attending[$key]['processed']) ? $attending[$key]['processed'] : false,
                );

                $attending[$key] = $update;
                $ceremony->attending = json_encode($attending);
            }
            if ($this->Ceremonies->save($ceremony)) {
                $this->Flash->success(__('Ceremony Attendee has been saved.'));
                return $this->redirect(['action' => 'view/' . $ceremony->id]);
            }
            $this->Flash->error(__('Unable to add option.'));
        }


        $attending = json_decode($ceremony->attending, true);
        $this->set('attending', $attending[$key]);


        $ministries = $this->Ceremonies->Ministries->find('list', [
            'order' => ['Ministries.name' => 'ASC']
        ]);
        $this->set('ministries', $ministries);


        $this->set('milestones', $milestones);

        $cities = $this->Ceremonies->Cities->find('list', [
            'order' => ['Cities.name' => 'ASC'],
        ])
            ->where([
                'Cities.name IN' => ['Vancouver', 'Victoria']
            ]);

        $temp = array();
        foreach($cities as $key => $city) {
            $temp[$key] = $city;
        }
        $temp[-1] = "Vancouver/Victoria";

        $this->set('cities', $temp);


        $this->set('ceremony', $ceremony);
    }



        public function deleteattending($id, $key)
    {
        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to administer Ceremonies.'));
            $this->redirect('/');
        }
        $this->request->allowMethod(['post', 'delete']);

        $ceremony = $this->Ceremonies->findById($id)->firstOrFail();

        $attending = json_decode($ceremony->attending, true);
        unset($attending[$key]);
        $ceremony->attending = json_encode($attending);

        if ($this->Ceremonies->save($ceremony)) {
            $this->Flash->success(__('Ceremony Attendee has been saved.'));
        }

        return $this->redirect(['action' => 'view', $ceremony->id]);
    }

}

