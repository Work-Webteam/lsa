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
        $registrationperiod = $this->RegistrationPeriods->newEmptyEntity();
        if ($this->request->is('post')) {
            $registrationperiod = $this->RegistrationPeriods->patchEntity($registrationperiod, $this->request->getData());
            $registrationperiod->registration_year = $this->request->getData('registration_year');
            $registrationperiod->open_registration = $this->request->getData('open_date') . " " . $this->request->getData('open_time');
            $registrationperiod->close_registration = $this->request->getData('close_date') . " " . $this->request->getData('close_time');
            $registrationperiod->open_rsvp = $this->request->getData('rsvp_open_date') . " " . $this->request->getData('rsvp_open_time');
            $registrationperiod->close_rsvp = $this->request->getData('rsvp_close_date') . " " . $this->request->getData('rsvp_close_time');
            if ($this->RegistrationPeriods->save($registrationperiod)) {
                $this->Flash->success(__('Your registration period has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your registration period.'));
        }
        $this->set('registrationperiod', $registrationperiod);
    }

    public function edit($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Registration Periods.'));
            $this->redirect('/');
        }
        $registrationperiod = $this->RegistrationPeriods->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->RegistrationPeriods->patchEntity($registrationperiod, $this->request->getData());
            $registrationperiod->registration_year = $this->request->getData('registration_year');
            $registrationperiod->open_registration = $this->request->getData('open_date') . " " . $this->request->getData('open_time');
            $registrationperiod->close_registration = $this->request->getData('close_date') . " " . $this->request->getData('close_time');
            $registrationperiod->open_rsvp = $this->request->getData('rsvp_open_date') . " " . $this->request->getData('rsvp_open_time');
            $registrationperiod->close_rsvp = $this->request->getData('rsvp_close_date') . " " . $this->request->getData('rsvp_close_time');
            if ($this->RegistrationPeriods->save($registrationperiod)) {
                $this->Flash->success(__('Registration Period has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update registration period.'));
        }

        $this->set('registrationperiod', $registrationperiod);
    }


    public function delete($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Registration Periods.'));
            $this->redirect('/');
        }
        $this->request->allowMethod(['post', 'delete']);

        $registrationperiod = $this->RegistrationPeriods->findById($id)->firstOrFail();
        if ($this->RegistrationPeriods->delete($registrationperiod)) {
            $this->Flash->success(__('Registration period {0} has been deleted.', $registrationperiod->registration_year));
            return $this->redirect(['action' => 'index']);
        }
    }

}

