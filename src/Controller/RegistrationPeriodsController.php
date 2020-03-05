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
        $registrationperiods = $this->Paginator->paginate($this->Registrationperiods->find('all', [
            'order' => ['Registrationperiods.open_registration' => 'DESC']
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
        $period = $this->Registrationperiods->findById($id)->firstOrFail();

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
        $registrationperiod = $this->Registrationperiods->newEmptyEntity();
        if ($this->request->is('post')) {
            $registrationperiod = $this->Registrationperiods->patchEntity($registrationperiod, $this->request->getData());
            $registrationperiod->award_year = $this->request->getData('award_year');
            $registrationperiod->open_registration = $this->request->getData('open_date') . " " . $this->request->getData('open_time');
            $registrationperiod->close_registration = $this->request->getData('close_date') . " " . $this->request->getData('close_time');
            if ($this->Registrationperiods->save($registrationperiod)) {
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
        $registrationperiod = $this->Registrationperiods->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Registrationperiods->patchEntity($registrationperiod, $this->request->getData());
            $registrationperiod->award_year = $this->request->getData('award_year');
            $registrationperiod->open_registration = $this->request->getData('open_date') . " " . $this->request->getData('open_time');
            $registrationperiod->close_registration = $this->request->getData('close_date') . " " . $this->request->getData('close_time');
            if ($this->Registrationperiods->save($registrationperiod)) {
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

        $registrationperiod = $this->Registrationperiods->findById($id)->firstOrFail();
        if ($this->Registrationperiods->delete($registrationperiod)) {
            $this->Flash->success(__('Registration period {0} has been deleted.', $registrationperiod->award_year));
            return $this->redirect(['action' => 'index']);
        }
    }

}

