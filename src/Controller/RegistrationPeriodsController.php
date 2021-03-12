<?php

namespace App\Controller;

use Cake\I18n\FrozenDate;
use Cake\Core\Configure;

class RegistrationPeriodsController extends AppController
{
    public function index()
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Registration Periods.'));
            $this->redirect('/');
        }
        $this->loadComponent('Paginator');
        $registrationperiods = $this->Paginator->paginate($this->RegistrationPeriods->find('all', [
            'order' => ['RegistrationPeriods.open_registration' => 'DESC']
        ]));

        $isadmin = $this->checkAuthorization(Configure::read('Role.admin'));
        $this->set(compact('isadmin'));
        $this->set(compact('registrationperiods'));
    }

    public function view($id = null)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Registration Periods.'));
            $this->redirect('/');
        }
        $period = $this->RegistrationPeriods->findById($id)->firstOrFail();

        $isadmin = $this->checkAuthorization(Configure::read('Role.admin'));
        $this->set(compact('isadmin'));
        $this->set(compact('period'));
    }

    public function add()
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Registration Periods.'));
            $this->redirect('/');
        }
        $registration_period = $this->RegistrationPeriods->newEmptyEntity();
        if ($this->request->is('post')) {
            $registration_period = $this->RegistrationPeriods->patchEntity($registration_period, $this->request->getData());
            $registration_period->registration_year = $this->request->getData('registration_year');
            $registration_period->open_registration = $this->request->getData('open_date') . " " . $this->request->getData('open_time');
            $registration_period->close_registration = $this->request->getData('close_date') . " " . $this->request->getData('close_time');
            $registration_period->open_rsvp = $this->request->getData('rsvp_open_date') . " " . $this->request->getData('rsvp_open_time');
            $registration_period->close_rsvp = $this->request->getData('rsvp_close_date') . " " . $this->request->getData('rsvp_close_time');
            if ($this->RegistrationPeriods->save($registration_period)) {
                $this->Flash->success(__('Your registration period has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your registration period.'));
        }
        $this->set('registrationperiod', $registration_period);
    }

    public function edit($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Registration Periods.'));
            $this->redirect('/');
        }
        $registration_period = $this->RegistrationPeriods->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->RegistrationPeriods->patchEntity($registration_period, $this->request->getData());
            $registration_period->registration_year = $this->request->getData('registration_year');
            $registration_period->open_registration = $this->request->getData('open_date') . " " . $this->request->getData('open_time');
            $registration_period->close_registration = $this->request->getData('close_date') . " " . $this->request->getData('close_time');
            $registration_period->open_rsvp = $this->request->getData('rsvp_open_date') . " " . $this->request->getData('rsvp_open_time');
            $registration_period->close_rsvp = $this->request->getData('rsvp_close_date') . " " . $this->request->getData('rsvp_close_time');
            if ($this->RegistrationPeriods->save($registration_period)) {
                $this->Flash->success(__('Registration Period has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update registration period.'));
        }

        $this->set('registrationperiod', $registration_period);
    }


    public function delete($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Registration Periods.'));
            $this->redirect('/');
        }
        $this->request->allowMethod(['post', 'delete']);

        $registration_period = $this->RegistrationPeriods->findById($id)->firstOrFail();
        if ($this->RegistrationPeriods->delete($registration_period)) {
            $this->Flash->success(__('Registration period {0} has been deleted.', $registration_period->registration_year));
            return $this->redirect(['action' => 'index']);
        }
    }

}

