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

    public function edit($id)
    {
        $registration = $this->Registrations->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Registrations->patchEntity($registration, $this->request->getData());
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
}

