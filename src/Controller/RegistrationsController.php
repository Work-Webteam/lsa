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
        $conditions['Registrations.registration_year ='] = date('Y');

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


    public function archive()
    {
        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to view this page.'));
            $this->redirect('/');
        }

        $conditions = array();

        $edit = false;
        $toolbar = true;

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

        $list = explode(",", $registrationperiods->qualifying_years);
        $award_years = [];
        foreach ($list as $year) {
            $award_years[$year] = $year;
        }
        $this->set('award_years', $award_years);

        // customized layout excluding top nav, etc.
        $this->viewBuilder()->setLayout('clean');

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

        $awards = $this->Registrations->Awards->find('list', [
            'conditions' => ['Awards.active =' => 1],
        ]);
        $this->set('awards', $awards);

        $awardInfo = $this->Registrations->Awards->find('all', [
            'conditions' => ['Awards.active =' => 1],
        ]);
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

        $awards = $this->Registrations->Awards->find('list', [
            'conditions' => ['Awards.active =' => 1],
        ]);
        $this->set('awards', $awards);

        $awardInfo = $this->Registrations->Awards->find('all', [
            'conditions' => ['Awards.active =' => 1],
        ]);
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
        // customized layout excluding top nav, etc.
        $this->viewBuilder()->setLayout('clean');

        $query = $this->Registrations->RegistrationPeriods->find('all')
            ->where([
                'RegistrationPeriods.registration_year =' => date('Y')
            ]);
        $regperiod = $query->first();

        if (date('Y-m-d', strtotime($regperiod->close_rsvp)) < date('Y-m-d H:i:s')) {
            $this->Flash->error(__('The deadline to RSVP has passed.'));
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
                'SupervisorCity',
                'Ceremonies'
            ],
        ])->first();
        if (!$registration) {
            $this->Flash->error(__('Registration not found.'));
            $this->redirect('/');
        }

        if ($this->request->is(['post', 'put'])) {
            $oldAttending = $registration->attending;
            $oldGuest = $registration->guest;
            $oldRecipientAccess = $registration->accessibility_recipient;
            $oldGuestAccess = $registration->accessbility_guest;
            $oldRecipientDiet = $registration->recipient_diet;
            $oldGuestDiet = $registration->guest_diet;

            $registration = $this->Registrations->patchEntity($registration, $this->request->getData());

            if (!$registration->responded) {
                $operation = "NEW";
            }
            else {
                $operation = "CHANGE";
            }

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
            $registration->responded = true;

            if ($this->Registrations->save($registration)) {

                if ($operation == "NEW" || $oldAttending <> $registration->attending) {
                    $log = $this->Registrations->Log->newEmptyEntity();
                    $session = $this->getRequest()->getSession();
                    $log->user_idir = $session->read('user.idir');
                    $log->user_guid = $session->read('user.guid');
                    $log->timestamp = time();
                    $log->registration_id = $registration->id;
                    $log->type = "RSVP";
                    $log->operation = $operation;
                    $log->description = $registration->attending ? "Attending YES" : "Attending NO";
                    if ($this->Registrations->Log->save($log)) {
                    }
                }
                if ($operation == "NEW" || $oldGuest <> $registration->guest) {
                    $log = $this->Registrations->Log->newEmptyEntity();
                    $session = $this->getRequest()->getSession();
                    $log->user_idir = $session->read('user.idir');
                    $log->user_guid = $session->read('user.guid');
                    $log->timestamp = time();
                    $log->registration_id = $registration->id;
                    $log->type = "RSVP";
                    $log->operation = $operation;
                    $log->description = $registration->guest ? "Guest YES" : "Guest NO";
                    if ($this->Registrations->Log->save($log)) {
                    }
                }
                if ($operation == "NEW" || $oldRecipientAccess <> $registration->accessibility_recipient || $oldGuestAccess <> $registration->accessibility_guest) {
                    $log = $this->Registrations->Log->newEmptyEntity();
                    $session = $this->getRequest()->getSession();
                    $log->user_idir = $session->read('user.idir');
                    $log->user_guid = $session->read('user.guid');
                    $log->timestamp = time();
                    $log->registration_id = $registration->id;
                    $log->type = "RSVP";
                    $log->operation = $operation;
                    $log->description = ($registration->accessibility_recipient || $registration->accessibility_guest) ? "Accessibility YES" : "Accessibility NO";
                    if ($this->Registrations->Log->save($log)) {
                    }
                }
                if ($operation == "NEW" || $oldRecipientDiet <> $registration->recipient_diet || $oldGuestDiet <> $registration->guest_diet) {
                    $log = $this->Registrations->Log->newEmptyEntity();
                    $session = $this->getRequest()->getSession();
                    $log->user_idir = $session->read('user.idir');
                    $log->user_guid = $session->read('user.guid');
                    $log->timestamp = time();
                    $log->registration_id = $registration->id;
                    $log->type = "RSVP";
                    $log->operation = $operation;
                    $log->description = ($registration->recipient_diet || $registration->guest_diet) ? "Diet YES" : "Diet NO";
                    if ($this->Registrations->Log->save($log)) {
                    }
                }
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

        $this->set('regperiod', $regperiod);

        $this->set('registration', $registration);

        $isadmin = true;

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
        $conditions['Registrations.attending ='] = true;

        $recipients = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'order' => ['Registrations.last_name' => 'ASC'],
        ]);


        $records = $this->Registrations->Accessibility->find('all');
        $accessibility = [];
        foreach ($records as $value) {
            $accessibility[$value->id] = $value;
        }

        $temp = [];
        foreach ($recipients as $key => $value) {
            $requirements = json_decode($value->accessibility_requirements_recipient, true);
            $value->recipient_reqs = "";
            foreach ($requirements as $requirement) {
                if (!empty($value->recipient_reqs)) {
                    $value->recipient_reqs .= ", ";
                }
                $value->recipient_reqs .= $accessibility[$requirement]->name;
            }

            $requirements = json_decode($value->accessibility_requirements_guest, true);
            $value->guest_reqs = "";
            foreach ($requirements as $requirement) {
                if (!empty($value->guest_reqs)) {
                    $value->guest_reqs .= ", ";
                }
                $value->guest_reqs .= $accessibility[$requirement]->name;
            }
            $temp[$key] = $value;
        }

        $recipients = $temp;

        $this->set(compact('recipients'));


        $this->set('ceremony_id', $id);

        $ceremony = $this->Registrations->Ceremonies->findById($id)->firstOrFail();
        $this->set('ceremony', $ceremony);


    }


    public function ceremonydiet($id)
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
        $conditions['Registrations.attending ='] = true;

        $recipients = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'order' => ['Registrations.last_name' => 'ASC'],
        ]);


        $records = $this->Registrations->Diet->find('all');
        $diet = [];
        foreach ($records as $value) {
            $diet[$value->id] = $value;
        }


        $temp = [];
        foreach ($recipients as $key => $value) {
            $requirements = json_decode($value->dietary_requirements_recipient, true);
            $value->recipient_reqs = "";
            foreach ($requirements as $requirement) {
                if (!empty($value->recipient_reqs)) {
                    $value->recipient_reqs .= ", ";
                }
                $value->recipient_reqs .= $diet[$requirement]->name;
            }

            $requirements = json_decode($value->dietary_requirements_guest, true);
            $value->guest_reqs = "";
            foreach ($requirements as $requirement) {
                if (!empty($value->guest_reqs)) {
                    $value->guest_reqs .= ", ";
                }
                $value->guest_reqs .= $diet[$requirement]->name;
            }
            $temp[$key] = $value;
//            debug($value);
        }

//        debug($temp);
        $recipients = $temp;

//        $this->set($recipients);
        $this->set(compact('recipients'));


        $this->set('ceremony_id', $id);

        $ceremony = $this->Registrations->Ceremonies->findById($id)->firstOrFail();
        $this->set('ceremony', $ceremony);


    }


    public function ceremonyawards($id, $attending = false)
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
        if ($attending) {
            $conditions['Registrations.attending ='] = true;
        }
        else {
            $conditions['Registrations.attending ='] = true;
            $conditions['Registrations.attending ='] = false;
        }

        $recipients = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'order' => ['Registrations.last_name' => 'ASC'],
            'contain' => [
                'Milestones',
                'Ministries',
                'Awards',
                'OfficeCity',
                'HomeCity',
                'SupervisorCity'
            ],
        ]);


//        $this->set($recipients);
        $this->set(compact('recipients'));

        $this->set('attending', $attending);

//        $awards = $this->Registrations->Awards->find('list');
//        $this->set('awards', $awards);


        $this->set('ceremony_id', $id);

        $ceremony = $this->Registrations->Ceremonies->findById($id)->firstOrFail();
        $this->set('ceremony', $ceremony);


    }



    public function ceremonyawardssummary($id, $attending = false)
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
            'contain' => [
                'Milestones',
                'Ministries',
                'Awards',
                'OfficeCity',
                'HomeCity',
                'SupervisorCity'
            ],
        ]);

        $recipients->select([
            'count' => $recipients->func()->count('Registrations.award_id'),
            'award_id' => 'Registrations.award_id',
            'award_name' => 'Awards.name',
            'award_personalized' => 'IF(Awards.id <> 0, IF(Awards.personalized, "true", "false"), "true")',
        ])
        ->group('award_id')
        ->order('Awards.name ASC');


        $this->set(compact('recipients'));

        $this->set('attending', $attending);

        $this->set('ceremony_id', $id);

        $ceremony = $this->Registrations->Ceremonies->findById($id)->firstOrFail();
        $this->set('ceremony', $ceremony);


    }


    public function ceremonytotals()
    {
        if ($this->checkAuthorization(array(Configure::read('Role.authenticated')))) {
            $this->Flash->error(__('You are not authorized to administer Registrations.'));
            $this->redirect('/');
        }

        $conditions = array();
        $conditions['Registrations.registration_year ='] = date('Y');

        $recipients = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'order' => [
              'Registrations.ceremony_id ASC',
              'Ministries.name ASC',

            ],
            'contain' => [
                'Milestones',
                'Ministries',
                'Awards',
                'OfficeCity',
                'HomeCity',
                'SupervisorCity',
                'Ceremonies',
            ],
        ]);


        $totals = [];
        $first = true;
        foreach ($recipients as $recipient) {
            if ($first) {
                $first = false;
            }
            if (!isset($totals[$recipient->ceremony_id][$recipient->ministry_id])) {
                $info = new \stdClass();
                $info->ceremony = $recipient->ceremony->night;
                $info->ministry = $recipient->ministry->name;
                $info->total = 0;
                $totals[$recipient->ceremony_id][$recipient->ministry_id] = $info;
            }
            if ($recipient->attending) {
                $totals[$recipient->ceremony_id][$recipient->ministry_id]->total++;
            }
            if ($recipient->guest) {
                $totals[$recipient->ceremony_id][$recipient->ministry_id]->total++;
            }
        }

        $this->set(compact('totals'));
    }




    public function reportawards()
    {

        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to view this page.'));
            $this->redirect('/');
        }

        $conditions = array();
        $conditions['Registrations.registration_year ='] = date('Y');
        $conditions['Registrations.ceremony_id >'] = 0;

        $recipients = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'contain' => [
                'Milestones',
                'Ministries',
                'Awards',
                'OfficeCity',
                'HomeCity',
                'SupervisorCity',
                'Ceremonies',
            ],
        ]);

        $year = date('Y');
        $this->set(compact('year'));

        $this->set(compact('recipients'));

    }


    public function reportwatches()
    {

        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to view this page.'));
            $this->redirect('/');
        }


        $award_id = 9;

        $conditions = array();
        $conditions['Registrations.registration_year ='] = date('Y');
        $conditions['Registrations.award_id ='] = $award_id;

        $recipients = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'contain' => [
                'Milestones',
                'Ministries',
                'Awards',
                'OfficeCity',
                'HomeCity',
                'SupervisorCity',
                'Ceremonies',
            ],
        ]);

        $year = date('Y');
        $this->set(compact('year'));

        $this->set(compact('recipients'));

    }

    public function reportcertificatesmilestone()
    {

        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to view this page.'));
            $this->redirect('/');
        }


        // TODO pull personalized milestone ids
        $milestones = $this->Registrations->Milestones->find('list', [
            'conditions' => [
                'Milestones.personalized =' => 1,
            ],
        ]);

        $milestone_id = [];
        foreach ($milestones as $key => $milestone) {
            $milestone_id[] = $key;
        }

        $conditions = array();
        $conditions['Registrations.registration_year ='] = date('Y');
        $conditions['Registrations.milestone_id IN '] = $milestone_id;


        $recipients = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'contain' => [
                'Milestones',
                'Ministries',
                'Awards',
                'OfficeCity',
                'HomeCity',
                'SupervisorCity',
                'Ceremonies',
            ],
        ]);

        $year = date('Y');
        $this->set(compact('year'));

        $this->set(compact('recipients'));

    }


    public function reportcertificatespecsf()
    {

        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to view this page.'));
            $this->redirect('/');
        }


        $award_id = 0;
        $milestone_id = 1;

        $conditions = array();
        $conditions['Registrations.registration_year ='] = date('Y');
        $conditions['Registrations.award_id ='] = $award_id;

        $recipients = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'contain' => [
                'Milestones',
                'Ministries',
                'Awards',
                'OfficeCity',
                'HomeCity',
                'SupervisorCity',
                'Ceremonies',
            ],
        ]);

        $year = date('Y');
        $this->set(compact('year'));

        $this->set(compact('recipients'));

    }


    public function reportlsaprogram()
    {

        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to view this page.'));
            $this->redirect('/');
        }

        $conditions = array();
        $conditions['Registrations.registration_year ='] = date('Y');
        $conditions['Registrations.ceremony_id >'] = 0;

        $recipients = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'contain' => [
                'Milestones',
                'Ministries',
                'Awards',
                'OfficeCity',
                'HomeCity',
                'SupervisorCity',
                'Ceremonies',
            ],
        ]);

        $year = date('Y');
        $this->set(compact('year'));

        $this->set(compact('recipients'));

    }


    public function reportawardtotalsceremony()
    {

        if ($this->checkAuthorization(array(Configure::read('Role.authenticated')))) {
            $this->Flash->error(__('You are not authorized to administer Registrations.'));
            $this->redirect('/');
        }

        $conditions = array();
        $conditions['Registrations.registration_year ='] = date('Y');
        $conditions['Registrations.ceremony_id >'] = 0;

        $recipients = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'contain' => [
                'Milestones',
                'Ministries',
                'Awards',
                'OfficeCity',
                'HomeCity',
                'SupervisorCity',
                'Ceremonies',
                'Log' => function(\Cake\ORM\Query $q) {
                    return $q->where(["or" => ["description =" => "Attending YES","description =" => "Attending NO"]])
                             ->limit(1)
                             ->order(["timestamp" => "DESC"]);
                }
            ],
        ]);


        $year = date('Y');
        $this->set(compact('year'));


        $totals = [];
        foreach ($recipients as $recipient) {
            $i = $this->findInTotalsCeremony($totals, $recipient->ceremony_id, $recipient->award_id);
            if ($i == -1) {

                $info = new \stdClass();
                $info->ceremony_id = $recipient->ceremony_id;
                $info->ceremony_night = $recipient->ceremony->night;
                $info->ceremony_date = $recipient->ceremony->date;
                $info->award_id = $recipient->award_id;

                if ($recipient->award_id > 0) {
                    $info->award = $recipient->award->name;
                    $info->award_options = $recipient->award_options;
                }
                else {
                    $info->award = "PECSF Donation";
                    $info->award_options = "[]";
                }
                $info->total = 1;
                $info->attending = 0;
                $info->notattending = 0;
                if ($recipient->attending) {
                    $info->attending++;
                }
                else {
                    $info->notattending++;
                }
                if (isset($recipient->log[0]->timestamp)) {
                    $info->lastupdate = $recipient->log[0]->timestamp;
                }
                else {
                    $info->lastupdate = $recipient->created;
                }
                $totals[] = $info;
            }
            else {
                $totals[$i]->total++;
                if ($recipient->attending) {
                    $totals[$i]->attending++;
                }
                else {
                    $totals[$i]->notattending++;
                }
                if (isset($recipient->log[0]->timestamp) && $recipient->log[0]->timestamp > $totals[$i]->lastupdate) {
                    $totals[$i]->lastupdate = $recipient->log[0]->timestamp;
                }
            }
        }
        $recipients = $totals;
        $this->set(compact('recipients'));
    }


    public function findInTotalsCeremony($array, $ceremony_id, $award_id) {
        $i = -1;
        foreach ($array as $key => $item) {
            if ($item->ceremony_id == $ceremony_id && $item->award_id == $award_id) {
                $i = $key;
            }
        }
        return $i;
    }


    public function reportawardtotalsmilestone()
    {

        if ($this->checkAuthorization(array(Configure::read('Role.authenticated')))) {
            $this->Flash->error(__('You are not authorized to administer Registrations.'));
            $this->redirect('/');
        }

        $conditions = array();
        $conditions['Registrations.registration_year ='] = date('Y');


        $recipients = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'contain' => [
                'Milestones',
                'Ministries',
                'Awards',
                'OfficeCity',
                'HomeCity',
                'SupervisorCity',
                'Ceremonies',
            ],
        ]);

        $year = date('Y');
        $this->set(compact('year'));


        $totals = [];
        foreach ($recipients as $recipient) {
            $i = $this->findInTotalsMilestone($totals, $recipient->milestone_id, $recipient->award_id);
            if ($i == -1) {
                $info = new \stdClass();
                $info->milestone_id = $recipient->milestone_id;
                $info->milestone = $recipient->milestone->name;
                $info->award_id = $recipient->award_id;

                if ($recipient->award_id > 0) {
                    $info->award = $recipient->award->name;
                    $info->award_options = $recipient->award_options;
                }
                else {
                    $info->award = "PECSF Donation";
                    $info->award_options = "[]";
                }
                $info->total = 1;
                $info->attending = 0;
                $info->notattending = 0;
                if ($recipient->attending) {
                    $info->attending++;
                }
                else {
                    $info->notattending++;
                }
                $totals[] = $info;
            }
            else {
                $totals[$i]->total++;
                if ($recipient->attending) {
                    $totals[$i]->attending++;
                }
                else {
                    $totals[$i]->notattending++;
                }
            }
        }
        $recipients = $totals;
        $this->set(compact('recipients'));

    }


    public function exportnametags($id, $attending = true)
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
        if ($attending) {
            $conditions['Registrations.attending ='] = true;
        }
        else {
            $conditions['Registrations.responded ='] = true;
            $conditions['Registrations.attending ='] = false;
        }

        $recipients = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'order' => ['Registrations.last_name' => 'ASC'],
            'contain' => [
                'Milestones',
                'Ministries',
                'Awards',
                'OfficeCity',
                'HomeCity',
                'SupervisorCity'
            ],
        ]);


        $this->set(compact('recipients'));

        $this->set('attending', $attending);

        $this->set('ceremony_id', $id);

        $ceremony = $this->Registrations->Ceremonies->findById($id)->firstOrFail();
        $this->set('ceremony', $ceremony);


    }


    public function exportrecipients()
    {

        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to view this page.'));
            $this->redirect('/');
        }

        $conditions = array();
        $conditions['Registrations.registration_year ='] = date('Y');

        $recipients = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'order' => ['Registrations.last_name' => 'ASC'],
            'contain' => [
                'Milestones',
                'Ministries',
                'Awards',
                'OfficeCity',
                'HomeCity',
                'SupervisorCity',
                'Ceremonies',
            ],
        ]);


        $this->set(compact('recipients'));

    }


    public function reportrecipientsbyceremony($id, $attending = true)
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
        if ($attending) {
            $conditions['Registrations.attending ='] = true;
        }
        else {
            $conditions['Registrations.responded ='] = true;
            $conditions['Registrations.attending ='] = false;
        }

        $recipients = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'order' => ['Registrations.last_name' => 'ASC'],
            'contain' => [
                'Milestones',
                'Ministries',
                'Awards',
                'OfficeCity',
                'HomeCity',
                'SupervisorCity'
            ],
        ]);

        $this->set(compact('recipients'));

        $this->set('ceremony_id', $id);

        $ceremony = $this->Registrations->Ceremonies->findById($id)->firstOrFail();
        $this->set('ceremony', $ceremony);

    }

    public function reportministryrsvp()
    {

        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to view this page.'));
            $this->redirect('/');
        }

        $conditions = array();
        $conditions['Registrations.registration_year ='] = date('Y');
        $conditions['Registrations.ceremony_id >'] = 0;
//        $conditions
        $recipients = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'contain' => [
                'Milestones',
                'Ministries',
                'Awards',
                'OfficeCity',
                'HomeCity',
                'SupervisorCity',
                'Ceremonies',
            ],
        ]);

        $ministries = [];
        foreach ($recipients as $recipient) {
            $i = $this->findInMinistries($ministries, $recipient->ministry_id, $recipient->ceremony_id);
            if ($i == -1) {
                $info = new \stdClass();
                $info->ceremony_id = $recipient->ceremony_id;
                $info->ministry_id = $recipient->ministry_id;
                $info->ceremony = $recipient->ceremony;
                $info->ministry = $recipient->ministry;
                $info->attending_recipients = 0;
                $info->attending_total = 0;
                $info->not_attending_recipients = 0;
                $info->not_attending_total = 0;
                $info->no_response_recipients = 0;
                $info->no_response_total = 0;
                $info->no_show_recipients = 0;
                $info->no_show_total = 0;
                $ministries[] = $info;
                $i = $this->findInMinistries($ministries, $recipient->ministry_id, $recipient->ceremony_id);
            }
            if ($recipient->responded) {
                if ($recipient->attending) {
                    $ministries[$i]->attending_recipients++;
                    $ministries[$i]->attending_total++;
                    if ($recipient->guest) {
                        $ministries[$i]->attending_total++;
                    }
                }
                else {
                    $ministries[$i]->not_attending_recipients++;
                    $ministries[$i]->not_attending_total++;
                    if ($recipient->guest) {
                        $ministries[$i]->not_attending_total++;
                    }
                }
            }
            else {
                $ministries[$i]->no_response_recipients++;
                $ministries[$i]->no_response_total++;
            }
            if ($recipient->noshow) {
                $ministries[$i]->no_show_recipient++;
                $ministries[$i]->no_show_total++;
                if ($recipeient->guest) {
                    $ministries[$i]->no_show_total++;
                }
            }
        }


        $this->set(compact('ministries'));

    }


    public function exportspecialrequirements()
    {

        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to view this page.'));
            $this->redirect('/');
        }

//        ["or" => ["description =" => "Attending YES","description =" => "Attending NO"]]

        $conditions = array();
        $conditions['Registrations.attending ='] = true;
        $conditions["or"] = ["Registrations.accessibility_recipient =" => true, "Registrations.accessibility_guest =" => true, "Registrations.recipient_diet =" => true, "Registrations.guest_diet =" => true];

        $recipients = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'order' => ['Registrations.last_name' => 'ASC'],
            'contain' => [
                'Milestones',
                'Ministries',
                'Awards',
                'OfficeCity',
                'HomeCity',
                'SupervisorCity',
                'Ceremonies',
            ],
        ]);


        $records = $this->Registrations->Accessibility->find('all');
        $accessibility = [];
        foreach ($records as $value) {
            $accessibility[$value->id] = $value;
        }

        $records = $this->Registrations->Diet->find('all');
        $diet = [];
        foreach ($records as $value) {
            $diet[$value->id] = $value;
        }


//        $temp = [];
//        foreach ($recipients as $key => $value) {
//            $requirements = json_decode($value->dietary_requirements_recipient, true);
//            $value->recipient_reqs = "";
//            foreach ($requirements as $requirement) {
//                if (!empty($value->recipient_reqs)) {
//                    $value->recipient_reqs .= ", ";
//                }
//                $value->recipient_reqs .= $diet[$requirement]->name;
//            }
//
//            $requirements = json_decode($value->dietary_requirements_guest, true);
//            $value->guest_reqs = "";
//            foreach ($requirements as $requirement) {
//                if (!empty($value->guest_reqs)) {
//                    $value->guest_reqs .= ", ";
//                }
//                $value->guest_reqs .= $diet[$requirement]->name;
//            }
//
//        $temp = [];
//        foreach ($recipients as $key => $value) {
//            $requirements = json_decode($value->accessibility_requirements_recipient, true);
//            $value->recipient_reqs = "";
//            foreach ($requirements as $requirement) {
//                if (!empty($value->recipient_reqs)) {
//                    $value->recipient_reqs .= ", ";
//                }
//                $value->recipient_reqs .= $accessibility[$requirement]->name;
//            }
//
//            $requirements = json_decode($value->accessibility_requirements_guest, true);
//            $value->guest_reqs = "";
//            foreach ($requirements as $requirement) {
//                if (!empty($value->guest_reqs)) {
//                    $value->guest_reqs .= ", ";
//                }
//                $value->guest_reqs .= $accessibility[$requirement]->name;
//            }
//            $temp[$key] = $value;
//        }



        $list = [];
        foreach ($recipients as $key => $recipient) {
            $list[$key] = $recipient;
            $list[$key]->report_access = ($recipient->accessibility_recipient || $recipient->accessibility_guest);
            $list[$key]->report_diet = ($recipient->recipient_diet || $recipient->guest_diet);

            $requirements = json_decode($list[$key]->dietary_requirements_recipient, true);
            $list[$key]->report_recipient_diet = "";
            foreach ($requirements as $requirement) {
                if (!empty($list[$key]->report_recipient_diet)) {
                    $list[$key]->report_recipient_diet .= ", ";
                }
                $list[$key]->report_recipient_diet .= $diet[$requirement]->name;
            }

            $requirements = json_decode($list[$key]->dietary_requirements_guest, true);
            $list[$key]->report_guest_diet = "";
            foreach ($requirements as $requirement) {
                if (!empty($list[$key]->report_guest_diet)) {
                    $list[$key]->report_guest_diet .= ", ";
                }
                $list[$key]->report_guest_diet .= $diet[$requirement]->name;
            }

            $list[$key]->report_reserved_seating = false;
            $list[$key]->report_reserved_parking = false;

            $requirements = json_decode($recipient->accessibility_requirements_recipient, true);

            $list[$key]->report_recipient_access = "";
            foreach ($requirements as $requirement) {
                if (!empty($list[$key]->report_recipient_access)) {
                    $list[$key]->report_recipient_access .= ", ";
                }
                $list[$key]->report_recipient_access .= $accessibility[$requirement]->name;
                if (strtolower($accessibility[$requirement]->name) == "reserved seating") {
                    $list[$key]->report_reserved_seating = true;
                }
                if (strtolower($accessibility[$requirement]->name) == "accessible parking") {
                    $list[$key]->report_reserved_parking = true;
                }
            }

            $requirements = json_decode($list[$key]->accessibility_requirements_guest, true);
            $list[$key]->report_guest_access = "";
            foreach ($requirements as $requirement) {
                if (!empty($list[$key]->report_guest_access)) {
                    $list[$key]->report_guest_access .= ", ";
                }
                $list[$key]->report_guest_access .= $accessibility[$requirement]->name;
                if (strtolower($accessibility[$requirement]->name) == "reserved seating") {
                    $list[$key]->report_reserved_seating = true;
                }
                if (strtolower($accessibility[$requirement]->name) == "accessible parking") {
                    $list[$key]->report_reserved_parking = true;
                }
            }

        }
        $recipients = $list;

        $this->set(compact('recipients'));

    }


    public function findInTotalsMilestone($array, $milestone_id, $award_id) {
        $i = -1;
        foreach ($array as $key => $item) {
            if ($item->milestone_id == $milestone_id && $item->award_id == $award_id) {
                $i = $key;
            }
        }
        return $i;
    }

    public function findInMinistries($array, $ministry_id, $ceremony_id) {
        $x = -1;
        foreach ($array as $key => $item) {
            if ($item->ministry_id == $ministry_id && $item->ceremony_id == $ceremony_id) {
                $x = $key;
            }
        }
        return $x;
    }
}


