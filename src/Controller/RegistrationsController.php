<?php

namespace App\Controller;

class RegistrationsController extends AppController
{
    public function index()
    {
        $this->loadComponent('Paginator');
        $registrations = $this->Paginator->paginate($this->Registrations->find());
        $this->set(compact('registrations'));
    }

    public function view($id = null)
    {
        $registration = $this->Registrations->findById($id)->firstOrFail();
        $this->set(compact('registration'));
    }

    public function add()
    {
        $registration = $this->Registrations->newEmptyEntity();
        if ($this->request->is('post')) {
            $registration = $this->Registrations->patchEntity($registration, $this->request->getData());

            // Hardcoding the user_id is temporary, and will be removed later
            // when we build authentication out.
            $registration->user_id = 1;
            $registration->created = time();
            $registration->modified = time();

            if ($this->Registrations->save($registration)) {
                $this->Flash->success(__('Registration has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add registration.'));
        }

        // Get a list of milestones.
        $milestones = $this->Registrations->Milestones->find('list');
        // Set milestones to the view context
        $this->set('milestones', $milestones);
        // Get a list of awards.
        $awards = $this->Registrations->Awards->find('list');
        // Set milestones to the view context
        $this->set('awards', $awards);
        // Get a list of awards.
        $diet = $this->Registrations->Diet->find('list');
        // Set milestones to the view context
        $this->set('diet', $diet);

        $this->set('registration', $registration);
    }

    public function register()
    {
        $registration = $this->Registrations->newEmptyEntity();
        if ($this->request->is('post')) {
            $registration = $this->Registrations->patchEntity($registration, $this->request->getData());

            // Hardcoding the user_id is temporary, and will be removed later
            // when we build authentication out.
            $registration->user_id = 1;
            $registration->created = time();
            $registration->modified = time();
            $registration->office_province = "BC";
            $registration->home_province = "BC";
            $registration->supervisor_province = "BC";
            $registration->retirement_date = $this->request->getData('date');
//            if (!$registration->retiring_this_year) {
//                $registration->retirement_date = "";
//            }
            if ($this->Registrations->save($registration)) {
                $this->Flash->success(__('Registration has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add registration.'));
        }

        if ($this->request->is('get')) {
            $registration->office_province = "BC";
            $registration->home_province = "BC";
            $registration->supervisor_province = "BC";
        }
        $milestones = $this->Registrations->Milestones->find('list');
        $this->set('milestones', $milestones);

        $awards = $this->Registrations->Awards->find('list');
        $this->set('awards', $awards);

        $awardInfo = $this->Registrations->Awards->find('all');
        $this->set('awardinfo', $awardInfo);

        $ministries = $this->Registrations->Ministries->find('list', [
            'order' => ['Ministries.name' => 'ASC']
        ]);
        $this->set('ministries', $ministries);

        $diet = $this->Registrations->Diet->find('list');
        $this->set('diet', $diet);

        $cities = $this->Registrations->Cities->find('list', [
            'order' => ['Cities.name' => 'ASC']
        ]);
        $this->set('cities', $cities);

        $this->set('registration', $registration);
    }


    public function getAwards() {
//        $milestone = $this->Registration->
    }



    public function edit($id)
    {
        $registration = $this->Registrations->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Registrations->patchEntity($registration, $this->request->getData());

            $registration->modified = time();

            if ($this->Registrations->save($registration)) {
                $this->Flash->success(__('Registration has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update registration.'));
        }

        // Get a list of milestones.
        $milestones = $this->Registrations->Milestones->find('list');
        // Set milestones to the view context
        $this->set('milestones', $milestones);
        // Get a list of awards.
        $awards = $this->Registrations->Awards->find('list');
        // Set milestones to the view context
        $this->set('awards', $awards);
        // Get a list of awards.
        $diet = $this->Registrations->Diet->find('list');
        // Set milestones to the view context
        $this->set('diet', $diet);

        $this->set('registration', $registration);
    }


    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $registration = $this->Registrations->findBySlug($id)->firstOrFail();
        if ($this->Registrations->delete($registration)) {
            $this->Flash->success(__('The {0} registration has been deleted.', $registration->name));
            return $this->redirect(['action' => 'index']);
        }
    }



    public function test()
    {
        $registration = $this->Registrations->newEmptyEntity();
        if ($this->request->is('post')) {
            $registration = $this->Registrations->patchEntity($registration, $this->request->getData());

            // Hardcoding the user_id is temporary, and will be removed later
            // when we build authentication out.
            $registration->user_id = 1;
            $registration->created = time();
            $registration->modified = time();
            $registration->office_province = "BC";
            $registration->home_province = "BC";
            $registration->supervisor_province = "BC";
            $registration->retirement_date = $this->request->getData('date');
//            if (!$registration->retiring_this_year) {
//                $registration->retirement_date = "";
//            }
//            if ($this->Registrations->save($registration)) {
//                $this->Flash->success(__('Registration has been saved.'));
//                return $this->redirect(['action' => 'index']);
//            }
            $this->Flash->error(__('Did not add registration.'));
        }

        if ($this->request->is('get')) {
            $registration->office_province = "BC";
            $registration->home_province = "BC";
            $registration->supervisor_province = "BC";
        }
        $milestones = $this->Registrations->Milestones->find('list');
        $this->set('milestones', $milestones);

        $awards = $this->Registrations->Awards->find('list');
        $this->set('awards', $awards);

        $ministries = $this->Registrations->Ministries->find('list', [
            'order' => ['Ministries.name' => 'ASC']
        ]);
        $this->set('ministries', $ministries);

        $diet = $this->Registrations->Diet->find('list');
        $this->set('diet', $diet);

        $cities = $this->Registrations->Cities->find('list', [
            'order' => ['Cities.name' => 'ASC']
        ]);
        $this->set('cities', $cities);

        $this->set('registration', $registration);
    }




}


