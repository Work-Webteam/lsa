<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Error\Debugger;
use Cake\Mailer\Mailer;
use DateTime;

class RegistrationsController extends AppController
{
    public function index()
    {
        if ($this->checkAuthorization(array(Configure::read('Role.authenticated')))) {
            $this->Flash->error(__('You are not authorized to administer Registrations.'));
            $this->redirect('/');
        }

        $query = $this->Registrations->RegistrationPeriods->find('all')
            ->where([
                'RegistrationPeriods.open_registration <= ' => date('Y-m-d H:i:s'),
                'RegistrationPeriods.close_registration >= ' => date('Y-m-d H:i:s')
            ]);
        $registrationperiods = $query->first();

        $conditions = array();
//        $conditions['Registrations.registration_year ='] = date('Y');
        $conditions['Registrations.created >='] = date('Y-01-01 00:00:00');
        $conditions['Registrations.created <='] = date('Y-12-31 23:59:59');

        $edit = true;
        $toolbar = true;

        // if Ministry Contact only list registrations from their ministry
        if ($this->checkAuthorization(Configure::read('Role.ministry_contact'))) {
            $session = $this->getRequest()->getSession();
            $conditions['Registrations.ministry_id ='] = $session->read("user.ministry");
            $edit = !empty($registrationperiods);
            $toolbar = false;
        }

        // if Supervisor role only list registrations they created
        if ($this->checkAuthorization(Configure::read('Role.supervisor'))) {
            $session = $this->getRequest()->getSession();
            $conditions['Registrations.user_guid ='] = $session->read("user.guid");
            $edit = !empty($registrationperiods);
            $toolbar = false;
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
        $this->set(compact('edit'));
        $this->set(compact('toolbar'));
    }

    public function view($id = null)
    {
//        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
        if ($this->checkAuthorization(array(Configure::read('Role.authenticated')))) {
                $this->Flash->error(__('You are not authorized to view this page.'));
                $this->redirect('/');
            }
//        }
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

            $query = $this->Registrations->RegistrationPeriods->find('all')
                ->where([
                    'RegistrationPeriods.open_registration <=' => date('Y-m-d H:i:s'),
                    'RegistrationPeriods.close_registration >=' => date('Y-m-d H:i:s')
                ]);
            $registrationperiods = $query->first();

            if ($this->checkAuthorization(array(
                Configure::read('Role.ministry_contact'),
                Configure::read('Role.supervisor')))) {
                if ($this->checkAuthorization(Configure::read('Role.supervisor'))) {
                    if (!$this->checkGUID($registration->user_guid)) {
                        $this->Flash->error(__('You are not authorized to edit this Registration.'));
                        $this->redirect('/registrations');
                    }
                    if (!$registrationperiods) {
                        $this->Flash->error(__('You may no longer edit this Registration.'));
                        $this->redirect('/');
                    }
                } else if ($this->checkAuthorization(Configure::read('Role.ministry_contact'))) {
                    if (!$this->checkAuthorization(Configure::read('Role.ministry_contact'), $registration->ministry_id)) {
                        $this->Flash->error(__('You are not authorized to edit this Registration.'));
                        $this->redirect('/registrations');
                    }
                    if (!$registrationperiods) {
                        $this->Flash->error(__('You may no longer edit this Registration.'));
                        $this->redirect('/');
                    }
                }
            }

            $this->set(compact('registration'));
        }
        else {
            $this->Flash->error(__('Registration not found.'));
            $this->redirect(['action' => 'index']);
        }
    }


    public function register()
    {
        $query = $this->Registrations->RegistrationPeriods->find('all')
            ->where([
                'RegistrationPeriods.open_registration <=' => date('Y-m-d H:i:s'),
                'RegistrationPeriods.close_registration >=' => date('Y-m-d H:i:s')
            ]);
        $registrationperiods = $query->first();

        if (!$registrationperiods) {
            $this->Flash->error(__('Long Service Awards are not currently open for registration.'));
            $this->redirect('/');
        }

        // customized layout excluding top nav, etc.
        $this->viewBuilder()->setLayout('register');

        $registration = $this->Registrations->newEmptyEntity();
        if ($this->request->is('post')) {
            $registration = $this->Registrations->patchEntity($registration, $this->request->getData());

            $session = $this->getRequest()->getSession();
            $registration->user_idir = $session->read('user.idir');
            $registration->user_guid = $session->read('user.guid');

            $registration->created = time();
            $registration->modified = time();
            $registration->registration_year = date("Y");
            $registration->office_province = "BC";
            $registration->home_province = "BC";
            $registration->supervisor_province = "BC";
            $registration->retirement_date = $this->request->getData('date');
            $registration->retroactive = false;

            $registration->accessibility_requirements_recipient = "[]";
            $registration->accessibility_requirements_guest = "[]";
            $registration->dietary_requirements_recipient = "[]";
            $registration->dietary_requirements_guest = "[]";

            if (empty($registration->award_options)) {
                $registration->award_options = '[]';
            }
            if ($this->Registrations->save($registration)) {
                $this->Flash->success(__('Registration has been saved.'));

                // Send email here
                $mailer = new Mailer('default');

                $message = "Congratulations, you have sucessfully registered for your Long Service Award.";
//                $mailer->setFrom(['longserviceaward@gov.bc.ca' => 'Long Service Awards'])
//                    ->setTo($registration->preferred_email)
//                    ->setSubject('Long Service Award Registration Completed')
//                    ->deliver($message);


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
//        debug($this->awardinfo)
//        foreach ($this->awardInfo as $key => $value) {
//            $this->awardInfo[$key]->description = nl2br($this->awardInfo[$key]->description);
//        }
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

        if (!$this->checkGUID($registration->user_guid)) {
            $this->Flash->error(__('You do not have access to this page.'));
            $this->redirect('/');
        }
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
            $this->Flash->error(__('Unable to update registration.'));

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
            'conditions' => ['Ceremonies.registration_year >=' => date('Y')],
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

        $query = $this->Registrations->RegistrationPeriods->find('all')
            ->where([
                'RegistrationPeriods.open_registration <=' => date('Y-m-d H:i:s'),
                'RegistrationPeriods.close_registration >=' => date('Y-m-d H:i:s')
            ]);
        $registrationperiods = $query->first();

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
                if (!$registrationperiods) {
                    $this->Flash->error(__('You may no longer edit this Registration.'));
                    $this->redirect('/');
                }
            }
            else if ($this->checkAuthorization(Configure::read('Role.ministry_contact'))) {
                if (!$this->checkAuthorization(Configure::read('Role.ministry_contact'), $registration->ministry_id)) {
                    $this->Flash->error(__('You are not authorized to edit this Registration.'));
                    $this->redirect('/registrations');
                }
                if (!$registrationperiods) {
                    $this->Flash->error(__('You may no longer edit this Registration.'));
                    $this->redirect('/');
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

    public function awardsummary() {
        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to view this page.'));
            $this->redirect('/');
        }

        $conditions = array();
        $conditions['Registrations.registration_year ='] = date('Y');

        // if Supervisor role only list registrations they created
        $registrations = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'contain' => [
                'Awards'
            ],
            'group' => ['Registrations.award_id']
        ]);
        $registrations->select([
            'Awards.name',
            'count' => $registrations->func()->count('*')]);
        $registrations->order(['count' => 'DESC']);
        $this->set(compact('registrations'));

    }

    public function ministrysummary() {
        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to view this page.'));
            $this->redirect('/');
        }

        $conditions = array();
        $conditions['Registrations.registration_year ='] = date('Y');

        // if Supervisor role only list registrations they created
        $registrations = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'contain' => [
                'Ministries',
            ],
            'group' => ['Registrations.ministry_id']
        ]);
        $registrations->select([
            'Ministries.name',
            'count' => $registrations->func()->count('*')]);
        $registrations->order(['count' => 'DESC', 'Ministries.name' => 'ASC']);
        $this->set(compact('registrations'));
    }



    public function milestonesummary() {
        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to view this page.'));
            $this->redirect('/');
        }

        $conditions = array();
        $conditions['Registrations.registration_year ='] = date('Y');

        // if Supervisor role only list registrations they created
        $milestones = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'contain' => [
                'Ministries',
                'Milestones',
            ],
            'group' => ['Registrations.milestone_id']
        ]);
        $milestones->select([
            'Milestones.name',
            'count' => $milestones->func()->count('*')]);
        $milestones->order(['Milestones.name' => 'ASC']);
        $this->set(compact('milestones'));


        // if Supervisor role only list registrations they created
        $ministries = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'contain' => [
                'Ministries',
                'Milestones',
            ],
            'group' => ['Registrations.ministry_id', 'Registrations.milestone_id']
        ]);
        $ministries->select([
            'Ministries.name',
            'Milestones.name',
            'count' => $milestones->func()->count('*')]);
        $ministries->order(['Ministries.name' => 'ASC', 'Milestones.name' => 'ASC']);
        $this->set(compact('ministries'));
    }


    public function test()
    {
        $conditions = array();
//        $conditions['Registrations.created >='] = date('Y');
        $conditions['Registrations.registration_year ='] = date('Y');

        // if Ministry Contact only list registrations from their ministry
        if ($this->checkAuthorization(Configure::read('Role.ministry_contact'))) {
            $session = $this->getRequest()->getSession();
            $conditions['Registrations.ministry_id ='] = $session->read("user.ministry");
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



    public function editpresentationids($id)
    {
        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to administer Ceremonies.'));
            $this->redirect('/');
        }

        $isadmin = $this->checkAuthorization(Configure::read('Role.admin'));
        $this->set(compact('isadmin'));


        $conditions = array();
        $conditions['Registrations.ceremony_id ='] = $id;

        $recipients = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'order' => ['Registrations.last_name' => 'ASC'],
        ]);


        if ($this->request->is(['post', 'put'])) {
            foreach ($recipients as $key => $recipient) {
                $recipient->presentation_number = $this->request->getData('Registrations.'.$key. '.presentation_number');
                $this->Registrations->save($recipient);
            }
            $this->Flash->success(__('Presentation numbers have been updated.'));
            return $this->redirect(['controller' => 'Ceremonies', 'action' => 'index']);
        }
        $this->set('recipients', $recipients);
    }


    public function attendingrecipients($id) {
        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to administer Ceremonies.'));
            $this->redirect('/');
        }

        $isadmin = $this->checkAuthorization(Configure::read('Role.admin'));
        $this->set(compact('isadmin'));

        $conditions = array();
        $conditions['Registrations.ceremony_id ='] = $id;

        $recipients = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'order' => ['Registrations.last_name' => 'ASC'],
        ]);

        $this->set('ceremony_id', $id);

        $ceremony = $this->Registrations->Ceremonies->findById($id)->firstOrFail();
        $this->set('ceremony', $ceremony);

        $this->set('recipients', $recipients);
    }

    public function assignrecipients($id) {

        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to administer Ceremonies.'));
            $this->redirect('/');
        }

        $ceremony = $this->Registrations->Ceremonies->findById($id)->firstOrFail();

        $attending = json_decode($ceremony->attending, true);
debug($attending);
        foreach ($attending as $key => $item) {

            // find registrants who match this criteria

            $conditions = array();
            $conditions['Registrations.registration_year ='] = date('Y');
            $conditions['Registrations.ministry_id ='] = $item['ministry'];
            $conditions['Registrations.milestone_id IN'] = $item['milestone'];

            if (!empty($item['city']['id'])) {
                if ($item['city']['id'] <> -1) {
                    if ($item['city']['type'] == true) {
                        $conditions['Registrations.home_city_id ='] = $item['city']['id'];
                    } else {
                        $conditions['Registrations.home_city_id <>'] = $item['city']['id'];
                    }
                }
                else {
                    $cities = $this->Registrations->Cities->find('list', [
                        'order' => ['Cities.name' => 'ASC'],
                    ])
                        ->where([
                            'Cities.name IN' => ['Vancouver', 'Victoria']
                        ]);

                    $search = array();
                    foreach($cities as $city_id => $city) {
                        $search[] = $city_id;
                    }
                    if ($item['city']['type'] == true) {
                        $conditions['Registrations.home_city_id IN'] = $search;
                    } else {
                        $conditions['Registrations.home_city_id NOT IN'] = $search;
                    }
                }
            }

            if (!empty($item['name']['start']) && !empty($item['name']['end'])) {
                $conditions['UPPER(Registrations.last_name) >='] = $item['name']['start'];
                $conditions['UPPER(Registrations.last_name) <'] = $item['name']['end'] . "ZZZZZ";
            }

            $registrations = $this->Registrations->find('all', [
                'conditions' => $conditions,
            ]);

            foreach ($registrations as $registration) {
                $registration->ceremony_id = $id;
                $this->Registrations->save($registration);
            }

            // update processed status
            $attending[$key]['processed'] = true;
        }

        // save updated ceremony
        $ceremony->attending = json_encode($attending);
        $this->Registrations->Ceremonies->save($ceremony);

        $this->Flash->success(__('Assign Recipients - ' . $id));
        return $this->redirect($this->referer());
    }




    public function rsvp($id)
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
            $this->redirect('/');
        }

        if ($this->request->is(['post', 'put'])) {
            $registration = $this->Registrations->patchEntity($registration, $this->request->getData());

            if (!$registration->guest) {
                $registration->guest_first_name = "";
                $registration->guest_last_name = "";
            }

            if (!$registration->accessibility_recipient) {
                $registration->accessibility_recipient_notes = "";
                $registration->accessibility_requirements_recipient = "[]";
            }

            if (!$registration->accessibility_guest) {
                $registration->accessibility_guest_notes = "";
                $registration->accessibility_requirements_guest = "[]";
            }

            if (!$registration->recipient_diet) {
                $registration->dietary_recipient_other = "";
                $registration->dietary_requirements_recipient = "[]";
            }
            if (!$registration->guest_diet) {
                $registration->dietary_guest_other = "";
                $registration->dietary_requirements_guest = "[]";
            }

            if ($this->Registrations->save($registration)) {
                $this->Flash->success(__('Registration has been updated.'));
                return $this->redirect('/');
            }
            $this->Flash->error(__('Unable to update registration.'));

        }


        if ($registration->ceremony_id) {
            $ceremony = $this->Registrations->Ceremonies->findById($registration->ceremony_id)->firstOrFail();
            if ($ceremony) {
                $this->set('ceremony', $ceremony);
            } else {
                $this->Flash->error(__('No ceremony date has been set for ' . $registration->first_name . " " . $registration->last_name . '.'));
                $this->redirect('/');
            }
        }
        else {
            $this->Flash->error(__('No ceremony date has been set for ' . $registration->first_name . " " . $registration->last_name . '.'));
            $this->redirect('/');
        }

        $diet = $this->Registrations->Diet->find('all');
        $this->set('diet', $diet);

        $accessibility = $this->Registrations->Accessibility->find('all');
        $this->set('accessibility', $accessibility);


        $this->set('registration', $registration);

        $isadmin = true;

        $query = $this->Registrations->RegistrationPeriods->find('all')
            ->where([
                'RegistrationPeriods.open_registration <=' => date('Y-m-d H:i:s'),
                'RegistrationPeriods.close_registration >=' => date('Y-m-d H:i:s')
            ]);
        $registrationperiods = $query->first();

        if (!$this->checkGUID($registration->user_guid)) {
           $this->Flash->error(__('You are not authorized to complete this RSVP.'));
           $this->redirect('/');
         }

        //
        $this->set('isadmin', $isadmin);


    }


    public function ceremonysummary($id) {

        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to view this page.'));
            $this->redirect('/');
        }



        $conditions = array();
        $conditions['Registrations.ceremony_id ='] = $id;

        $recipients = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'order' => ['Registrations.last_name' => 'ASC'],
        ]);

        $this->set('ceremony_id', $id);

        $ceremony = $this->Registrations->Ceremonies->findById($id)->firstOrFail();
        $this->set('ceremony', $ceremony);

        $this->set('recipients', $recipients);

//        debug('count: ' . count($recipients));

        $diet = $this->Registrations->Diet->find('all');
        $this->set('diet', $diet);

        $accessibility = $this->Registrations->Accessibility->find('all');
        $this->set('accessibility', $accessibility);

        // now we gonna figure out the totals.
        $totals = new \stdClass();
        $totals->recipients = 0;
        $totals->guests = 0;
        $totals->access = 0;
        $totals->diet = 0;
        $totals->access_notes = [];
        $totals->diet_notes = [];
        $totals->diet_requirements = [];

        foreach ($accessibility as $key => $value) {
            $totals->access_requirements[$value->id] = $value;
            $totals->access_requirements[$value->id]-> total = 0;
        }

        foreach ($diet as $key => $value) {
          $totals->diet_requirements[$value->id] = $value;
          $totals->diet_requirements[$value->id]-> total = 0;
        }

//        debug($totals->diet_requirements);

        foreach ($recipients as $key => $recipient) {
            if ($recipient->attending) {
                $totals->recipients++;
            }
            if ($recipient->guest) {
                $totals->guests++;
            }
            if ($recipient->accessibility_recipient) {
                $totals->access++;
            }
            if ($recipient->accessibility_guest) {
                $totals->access++;
            }
            if ($recipient->recipient_diet) {
                $totals->diet++;
            }
            if ($recipient->guest_diet) {
                $totals->diet++;
            }

            $requirements = json_decode($recipient->accessibility_requirements_recipient, true);
            foreach ($requirements as $id) {
                $totals->access_requirements[$id]->total++;
            }
            $requirements = json_decode($recipient->accessibility_requirements_guest, true);
            foreach ($requirements as $id) {
                $totals->access_requirements[$id]->total++;
            }

            $requirements = json_decode($recipient->dietary_requirements_recipient, true);
            foreach ($requirements as $id) {
                $totals->diet_requirements[$id]->total++;
            }

            $requirements = json_decode($recipient->dietary_requirements_guest, true);
            foreach ($requirements as $id) {
                $totals->diet_requirements[$id]->total++;
            }


            if (isset($recipient->accessibility_recipient_notes) && !empty($recipient->accessibility_recipient_notes)) {
                $totals->access_notes[] = $recipient->accessibility_recipient_notes;
            }
            if (isset($recipient->accessibility_guest_notes) && !empty($recipient->accessibility_guest_notes)) {
                $totals->access_notes[] = $recipient->accessibility_guest_notes;
            }
            if (isset($recipient->dietary_recipient_other) && !empty($recipient->dietary_recipient_other)) {
                $totals->diet_notes[] = $recipient->dietary_recipient_other;
            }
            if (isset($recipient->dietary_guest_other) && !empty($recipient->dietary_guest_other)) {
                $totals->diet_notes[] = $recipient->dietary_guest_other;
            }

        }

        $this->set('totals', $totals);

        // if Supervisor role only list registrations they created
        $milestones = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'contain' => [
                'Ministries',
                'Milestones',
            ],
        ]);
        $milestones->select([
            'Milestones.name',
            'count' => $milestones->func()->count('*')]);
        $milestones->order(['Milestones.name' => 'ASC']);
        $this->set(compact('milestones'));


//        // if Supervisor role only list registrations they created
//        $ministries = $this->Registrations->find('all', [
//            'conditions' => $conditions,
//            'contain' => [
//                'Ministries',
//                'Milestones',
//            ],
//            'group' => ['Registrations.ministry_id', 'Registrations.milestone_id']
//        ]);
//        $ministries->select([
//            'Ministries.name',
//            'Milestones.name',
//            'count' => $milestones->func()->count('*')]);
//        $ministries->order(['Ministries.name' => 'ASC', 'Milestones.name' => 'ASC']);
//        $this->set(compact('ministries'));
    }



    public function ceremonyaccessibility($id)
    {

        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to view this page.'));
            $this->redirect('/');
        }


        $conditions = array();
        $conditions['Registrations.ceremony_id ='] = $id;

        $recipients = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'order' => ['Registrations.last_name' => 'ASC'],
        ]);

//        $registrations = $this->Registrations->find('all', [
//            'conditions' => $conditions,
//            'contain' => [
//                'Milestones',
//                'Ministries',
//                'Awards',
//                'OfficeCity',
//                'HomeCity',
//                'SupervisorCity'
//            ],
//        ]);

        $this->set(compact('recipients'));


        $this->set('ceremony_id', $id);

        $ceremony = $this->Registrations->Ceremonies->findById($id)->firstOrFail();
        $this->set('ceremony', $ceremony);


    }

}


