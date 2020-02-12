<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Error\Debugger;

class RegistrationsController extends AppController
{
    public function index()
    {
        if ($this->checkAuthorization(array(Configure::read('Role.authenticated')))) {
            $this->Flash->error(__('You are not authorized to administer Registrations.'));
            $this->redirect('/');
        }

        $conditions = array();
//        $conditions['Registrations.created >='] = date('Y');
        $conditions['Registrations.award_year ='] = date('Y');

        // if Ministry Contact only list registrations from their ministry
        if ($this->checkAuthorization(Configure::read('Role.ministry_contact'))) {
            $session = $this->getRequest()->getSession();
            $conditions['Registrations.ministry_id ='] = $session->read("user.ministry");
        }

        // if Supervisor role only list registrations they created
        if ($this->checkAuthorization(Configure::read('Role.supervisor'))) {
            $session = $this->getRequest()->getSession();
            $conditions['Registrations.user_guid ='] = $session->read("user.guid");
        }
        $registrations = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'contain' => [
                'Milestones',
                'Ministries',
                'Awards',
                'OfficeCity',
                'HomeCity',
                'SupervisorCity'
            ],
        ]);

        $this->set(compact('registrations'));
    }

    public function view($id = null)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to view this page.'));
            $this->redirect('/');
        }
        $registration = $this->Registrations->find('all', [
            'conditions' => array(
                'Registrations.id' => $id
            ),
            'contain' => [
                'Milestones',
                'Ministries',
                'Awards',
                'OfficeCity',
                'HomeCity',
                'SupervisorCity'
            ],
        ])->first();
        if ($registration) {
            $this->set(compact('registration'));
        }
        else {
            $this->Flash->error(__('Registration not found.'));
            $this->redirect(['action' => 'index']);
        }
    }


    public function register()
    {
        $registration = $this->Registrations->newEmptyEntity();
        if ($this->request->is('post')) {
            $registration = $this->Registrations->patchEntity($registration, $this->request->getData());

            // Hardcoding the user_id is temporary, and will be removed later
            // when we build authentication out.

            $session = $this->getRequest()->getSession();
            $registration->user_idir = $session->read('user.idir');
            $registration->user_guid = $session->read('user.guid');

            $registration->created = time();
            $registration->modified = time();
            $registration->award_year = date("Y");
            $registration->office_province = "BC";
            $registration->home_province = "BC";
            $registration->supervisor_province = "BC";
            $registration->retirement_date = $this->request->getData('date');
            $registration->retroactive = false;
            if ($this->Registrations->save($registration)) {
                $this->Flash->success(__('Registration has been saved.'));
                return $this->redirect(['action' => 'completed', $registration->id]);
            }
            $this->Flash->error(__('Unable to add registration.'));
            debug($entity->errors());
        }

        if ($this->request->is('get')) {
            $registration->office_province = "BC";
            $registration->home_province = "BC";
            $registration->supervisor_province = "BC";
        }

        $milestones = $this->Registrations->Milestones->find('list');
        $this->set('milestones', $milestones);

        $milestoneInfo = $this->Registrations->Milestones->find('all');
        $this->set('milestoneinfo', $milestoneInfo);

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


        $regions = $this->Registrations->PecsfRegions->find('list', [
            'order' => ['PecsfRegions.name' => 'ASC']
        ]);
        $this->set('regions', $regions);

        $charities = $this->Registrations->PecsfCharities->find('all', [
            'order' => ['PecsfCharities.name' => 'ASC']
        ]);
        $this->set('charities', $charities);

        $this->set('registration', $registration);
    }


    public function completed ($id = null) {
        $registration = $this->Registrations->findById($id)->firstOrFail();
        $this->set(compact('registration'));

        $this->set('lsa_name' , Configure::read('LSA.lsa_contact_name'));
        $this->set('lsa_email' , Configure::read('LSA.lsa_contact_email'));
        $this->set('lsa_phone' , Configure::read('LSA.lsa_contact_phone'));
    }

    public function edit($id)
    {
        $registration = $this->Registrations->find('all', [
            'conditions' => array(
                'Registrations.id' => $id
            ),
            'contain' => [
                'Milestones',
                'Ministries',
                'Awards',
                'OfficeCity',
                'HomeCity',
                'SupervisorCity',
                'Ceremonies'
            ],
        ])->first();
        if (!$registration) {
            $this->Flash->error(__('Registration not found.'));
            $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['post', 'put'])) {
            $registration = $this->Registrations->patchEntity($registration, $this->request->getData());

            $registration->modified = time();
            $registration->invite_sent = $this->request->getData('invite_sent');
            if (empty($registration->invite_sent)) {
                $registration->invite_sent = NULL;
            }
            $registration->photo_sent = $this->request->getData('photo_sent');
            if (empty($registration->photo_sent)) {
                $registration->photo_sent = NULL;
            }
            if ($this->Registrations->save($registration)) {
                $this->Flash->success(__('Registration has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add registration.'));

        }


        $milestones = $this->Registrations->Milestones->find('list');
        $this->set('milestones', $milestones);

        $milestoneInfo = $this->Registrations->Milestones->find('all');
        $this->set('milestoneinfo', $milestoneInfo);

        $awards = $this->Registrations->Awards->find('list');
        $this->set('awards', $awards);

        $awardInfo = $this->Registrations->Awards->find('all');
        $this->set('awardinfo', $awardInfo);

        $diet = $this->Registrations->Diet->find('list');
        $this->set('diet', $diet);

        $cities = $this->Registrations->Cities->find('list', [
            'order' => ['Cities.name' => 'ASC']
        ]);
        $this->set('cities', $cities);

        $ministries = $this->Registrations->Ministries->find('list', [
            'order' => ['Ministries.name' => 'ASC']
        ]);
        $this->set('ministries', $ministries);

        $regions = $this->Registrations->PecsfRegions->find('list', [
            'order' => ['PecsfRegions.name' => 'ASC']
        ]);
        $this->set('regions', $regions);

        $charities = $this->Registrations->PecsfCharities->find('all', [
            'order' => ['PecsfCharities.name' => 'ASC']
        ]);
        $this->set('charities', $charities);

        $records = $this->Registrations->Ceremonies->find('all', [
            'conditions' => ['Ceremonies.award_year >=' => date('Y')],
            'order' => ['Ceremonies.night' => 'ASC']
        ]);
        $ceremonies = array();
        foreach ($records as $record) {
            $ceremonies[$record->id] = "Night " . $record->night . " - " . date("M d, Y", strtotime($record->date));
        }
        $this->set('ceremonies', $ceremonies);

        $donation = [
            'id' => Configure::read('Donation.id'),
            'name' => Configure::read('Donation.name'),
            'description' => Configure::read('Donation.description'),
            'image' => Configure::read('Donation.image'),
        ];
        $this->set('donation', $donation);

        $this->set('registration', $registration);

        $isadmin = true;
        if ($this->checkAuthorization(array(
            Configure::read('Role.authenticated'),
            Configure::read('Role.ministry_contact'),
            Configure::read('Role.supervisor')))) {
            if ($this->checkAuthorization(Configure::read('Role.authenticated'))) {
                if (!$this->checkGUID($registration->user_guid)) {
                    $this->Flash->error(__('You are not authorized to edit this Registration.'));
                    $this->redirect('/');
                }
            }
            else if ($this->checkAuthorization(Configure::read('Role.supervisor'))) {
                if (!$this->checkGUID($registration->user_guid)) {
                    $this->Flash->error(__('You are not authorized to edit this Registration.'));
                    $this->redirect('/registrations');
                }
            }
            else if ($this->checkAuthorization(Configure::read('Role.ministry_contact'))) {
                if (!$this->checkAuthorization(Configure::read('Role.ministry_contact'), $registration->ministry_id)) {
                    $this->Flash->error(__('You are not authorized to edit this Registration.'));
                    $this->redirect('/registrations');
                }
            }
            $isadmin = false;
        }

        //
        $this->set('isadmin', $isadmin);


    }


    public function delete($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin')))) {
            $this->Flash->error(__('You are not authorized to delete Registrations.'));
            $this->redirect('/');
        }
        $this->request->allowMethod(['post', 'delete']);

        $registration = $this->Registrations->findBySlug($id)->firstOrFail();
        if ($this->Registrations->delete($registration)) {
            $this->Flash->success(__('The {0} registration has been deleted.', $registration->name));
            return $this->redirect(['action' => 'index']);
        }
    }





}


