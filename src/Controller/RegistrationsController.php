<?php

namespace App\Controller;

use App\Model\Entity\Award;
use App\Model\Entity\PecsfCharity;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Mailer\Mailer;



class RegistrationsController extends AppController
{
    //Displays a list of registrations based on user role's permissions
    public function index()
    {
        $this->set('username', $this->request->getSession()->read('User.username'));

        /*
        if ($this->checkAuthorization(array(Configure::read('Role.authenticated')))) {

            $this->Flash->error(__('You are not authorized to administer Registrations.'));
            die('You are not authorized to ');
        }
        */
        $query = $this->Registrations->RegistrationPeriods->find('all')
            ->where([
                'RegistrationPeriods.open_registration <= ' => date('Y-m-d H:i:s'),
                'RegistrationPeriods.close_registration >= ' => date('Y-m-d H:i:s')
            ]);
        $registration_periods = $query->first();

        $conditions = array();
        $conditions['Registrations.registration_year ='] = date('Y');

        $edit = true;
        $toolbar = true;

        // if Ministry Contact, only list registrations from their ministry
        if ($this->checkAuthorization(Configure::read('Role.ministry_contact'))) {
            $session = $this->getRequest()->getSession();
            $conditions['Registrations.ministry_id ='] = $session->read("user.ministry");
            $edit = !empty($registration_periods);
            $toolbar = false;
        }

        // if Supervisor role, or authenticated user role, only list registrations they created.
        if ($this->checkAuthorization(Configure::read('Role.supervisor')) || $this->checkAuthorization(Configure::read('Role.authenticated_user'))) {
            $session = $this->getRequest()->getSession();
            $conditions['Registrations.user_guid ='] = $session->read("user.guid");
            $edit = !empty($registration_periods);
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

        if ($this->checkAuthorization(Configure::read('Role.authenticated_user'))){
            $has_reg = $registrations->first();
            if($has_reg === NULL) {
                $this->redirect('/register');
            }
        }

        $this->set(compact('registrations'));
        $this->set(compact('edit'));
        $this->set(compact('toolbar'));

    }

    //Displays a table of registrants for export to CSV
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

    //Displays a single registration based on ID
    public function view($id = null)
    {
        if ($this->checkAuthorization(Configure::read('Role.anonymous'))) {
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

            $query = $this->Registrations->RegistrationPeriods->find('all')
                ->where([
                    'Registration_Periods.open_registration <=' => date('Y-m-d H:i:s'),
                    'Registration_Periods.close_registration >=' => date('Y-m-d H:i:s')
                ]);
            $registration_periods = $query->first();

            if ($this->checkAuthorization(array(
                Configure::read('Role.ministry_contact'),
                Configure::read('Role.supervisor'),
                Configure::read('Role.authenticated_user')
            ))) {
                if ($this->checkAuthorization(Configure::read('Role.supervisor')) || $this->checkAuthorization(Configure::read('Role.authenticated_user'))) {
                    if (!$this->checkGUID($registration->user_guid)) {
                        $this->Flash->error(__('You are not authorized to edit this Registration.'));
                        $this->redirect('/registrations');
                    }
                    if (!$registration_periods) {
                        $this->Flash->error(__('You may no longer edit this Registration.'));
                        $this->redirect('/');
                    }
                } else if ($this->checkAuthorization(Configure::read('Role.ministry_contact'))) {
                    if (!$this->checkAuthorization(Configure::read('Role.ministry_contact'), $registration->ministry_id)) {
                        $this->Flash->error(__('You are not authorized to edit this Registration.'));
                        $this->redirect('/registrations');
                    }
                    if (!$registration_periods) {
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

    //Allows an unauthenticated user to create a registration
    public function register()
    {
       //$this->checkForEdit();

        $this->viewBuilder()->setLayout('clean');

        //First, make sure registrations are open, flash an error if they're not.
        $query = $this->Registrations->RegistrationPeriods->find('all')
            ->where([
                'RegistrationPeriods.open_registration <=' => date('Y-m-d H:i:s'),
                'RegistrationPeriods.close_registration >=' => date('Y-m-d H:i:s')
            ]);
        $registration_periods = $query->first();

        if (empty($registration_periods)) {
            $this->Flash->error(__('Long Service Awards are not currently open for registration.'));
            return $this->redirect('/');
        }
        /*
        //  Non-priv'd users should not reach /register page a second time.
        // Lets redirect them home, where they will only see their prev applications.
        if ($this->checkAuthorization(Configure::read('Role.authenticated_user'))) {
            $session = $this->getRequest()->getSession();
            $conditions['Registrations.user_guid ='] = $session->read("user.guid");
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
            $has_reg = $registrations->first();
            if(isset($has_reg)) {
                $this->redirect('/');
            }
        }
        */
        //Initialize new registration object
        $registration = $this->Registrations->newEmptyEntity();

        //Handle post requests
        if ($this->request->is('post')) {
            $registration = $this->Registrations->patchEntity($registration, $this->request->getData());
            //$session = $this->getRequest()->getSession();
            //$registration->user_idir = $session->read('user.idir');
            //$registration->user_guid = $session->read('user.guid');

            $registration->created = time();
            $registration->modified = time();

            $registration->registration_year = date("Y");
            $registration->office_province = "BC";
            $registration->home_province = "BC";
            $registration->supervisor_province = "BC";
            $registration->retirement_date = $this->request->getData('date');
            $registration->retroactive = 0;

            $registration->award_options = $this->getAwardOptionsJSON();

            $registration = $this->handlePECSFDonation($registration);

            $registration->accessibility_requirements_recipient = "[]";
            $registration->accessibility_requirements_guest = "[]";
            $registration->dietary_requirements_recipient = "[]";
            $registration->dietary_requirements_guest = "[]";

            // Make sure user has an award. If they do not this comes through as -1,
            // this means it is likely an application for a previous year, so we assign it the NA award.
            if ($registration->award_id < 0 ){
                if (empty($registration->award_options)) {
                    $registration->award_options = '[]';
                }
                // For any retroactive registrations.
                // This seems to get passed through as -1.
                $award = new AwardsController();
                $award_retro = $award->getByName('N/A')->toArray();
                // If we don't get an id, try by abbreviation
                if(empty($award_retro)) {
                    $award_retro = $award->getByAbbreviation('NA')->toArray();
                }
                // If our id is still empty, we should make one - we will require it.
                // An empty variable at this point indicates our previous retro choice was deleted.
                if(empty($award_retro)){
                    $awardTables = $this->getTableLocator()->get('Awards');
                    $newRetro = $awardTables->newEmptyEntity();
                    $newRetro->name = 'N/A';
                    $newRetro->abbreviation = 'NA';
                    $newRetro->milestone_id = '6';
                    $newRetro->description = 'For all users who had an LSA application from a previous year.';
                    $newRetro->image = 'lsa_logo.png';
                    $newRetro->options = "[]";
                    $newRetro->personalized = 0;
                    $newRetro->active = 0;
                    // Returns retro award object, or false if there is an issue.
                    if($awardTables->save($newRetro)) {
                        $id = $newRetro->id;
                    }
                } else {
                    $id = $award_retro[0]->id;
                }
                // TODO: We should always have an id now - but if we do not throw an error.
                $registration->award_id = $id;
            }
            if ($this->Registrations->save($registration)) {
                /**** Application success email sends start ***/
                // RECIPIENT EMAIL:
                // Get the milestone year for email.
                $milestone = $this->getTableLocator()->get('Milestones');
                $milestone_year = $milestone->get($registration->milestone_id);
                // Get user info for email:
                $recipient_info = [
                    'milestone' => $milestone_year->years
                ];
                // Build mailer object.
                $mailer = new Mailer('default');

                // Set our templates
                $mailer
                    ->viewBuilder()
                        // Can be found in templates/email/html
                        ->setTemplate('recipient_confirmation_email')
                        // Can be found in templates/layout/html - not sure what exactly it does if anything - but it looks to set headers.
                        ->setLayout('recipient_confirmation_layout');
                $mailer
                    // We want html emails.
                    ->setEmailFormat('html')
                    ->setFrom(['longserviceaward@gov.bc.ca' => 'Long Service Awards'])
                    ->setTo($registration->preferred_email)
                    ->setSubject('Long Service Award Registration Successful')
                    // Vars accessible in template. Sent as array, but accessed directly.
                    ->setViewVars($recipient_info)
                    ->deliver();

                // SUPERVISOR EMAIL
                // We need to pull out recipients first, last and their milestone year #.
                $supervisor_info = [
                    'first_name' => $registration->first_name,
                    'last_name' => $registration->last_name,
                    'milestone' => $milestone_year->years
                ];
                // Build mailer object.
                $sup_mailer = new Mailer('default');
                // Set our templates
                $sup_mailer
                    ->viewBuilder()
                          // Can be found in templates/email/html
                        ->setTemplate('supervisor_confirmation_email')
                        // Can be found in templates/layout/html - not sure what exactly it does if anything - but it looks to set headers.
                        ->setLayout('recipient_confirmation_layout');
                $sup_mailer
                    // We want html emails.
                    ->setEmailFormat('html')
                    ->setFrom(['longserviceaward@gov.bc.ca' => 'Long Service Awards'])
                    ->setTo($registration->supervisor_email)
                    ->setSubject('Your employee has registered for a Long Service Award')
                    // Vars accessible in template. Sent as array, but accessed directly.
                    ->setViewVars($supervisor_info)
                    ->deliver();

                /**** Application success email sends end ***/


                // Get the registration for this page

                $this->set(compact('registration'));
                // We also need to dynamically set the years of service for this registration.
                $milestone = $this->getTableLocator()->get('Milestones');
                $milestone_year = $milestone->get($registration->milestone_id);
                $this->set('year', $milestone_year->years);

                $this->set('lsa_name' , Configure::read('LSA.lsa_contact_name'));
                $this->set('lsa_email' , Configure::read('LSA.lsa_contact_email'));
                $this->set('lsa_phone' , Configure::read('LSA.lsa_contact_phone'));

                $this->viewBuilder()->setLayout('clean');
                $this->render('completed');

                //return this->completed$registration->id()
                //return $this->redirect(['controller'=>'Registrations', 'action' => 'completed', $registration->id]);
            }
            // Error handling.
            //$this->Flash->error(__('Unable to add registration.'));
        }

        //Initialize Arrays for Awards options, Select Menus and validation
        $list = explode(",", $registration_periods->qualifying_years);
        $award_years = [];
        foreach ($list as $year) {
            $award_years[$year] = $year;
        }
        $this->set('award_years', $award_years);

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
        /* TODO: Check to verify this can be removed
        $ministries = $this->Registrations->Ministries->find('list', [
            'order' => ['Ministries.name' => 'ASC']
        ]);
        $this->set('ministries', $ministries);
        $ministryInfo = $this->Registrations->Ministries->find('all');
        */
        $this->set('ministries', $this->Registrations->Ministries->find('all'));

        /* TODO : Check to verify this can be removed
        $diet = $this->Registrations->Diet->find('list');
        $this->set('diet', $diet);
        */
        $this->set('cities', $this->Registrations->Cities->find('all'));
        $regions = $this->Registrations->PecsfRegions->find('all', [
            'order' => ['PecsfRegions.name' => 'ASC']
        ]);
        $this->set('regions', $regions);
        $charities = $this->Registrations->PecsfCharities->find('all', [
            'order' => ['PecsfCharities.name' => 'ASC']
        ]);
        $this->set('charities', $charities);
        $this->set('registration', $registration);


    }
    /*
    private function checkForSessionBasedEdit() {
        //Check if there's any session variables for this user
        $guid = $this->request->getSession()->read('user.guid');

        $registration = $this->Registrations->find()->where(['user_guid' => $guid])->first();

        if ($registration) {
           $this->redirect('https://lsaapp.gww.gov.bc.ca/registrations/edit/' . $registration->id);
        }


    }
    */
    /* =======================
    *  This section is a make-do solution for registrants to edit their own records that requires neither
    *  sessions nor passwords or accounts:
    *   1) When the user goes to register they're asked either to start a new registration or enter the govt email
    *   email address associated with that registration.
    *  2) If a registration exists with that email, the system will attach an edit code to the registration row.
    *  3) The system will then send an email to that address with a message containing a link with the edit code.
    *  4) Clicking the edit code will link to the edit page. The code will be check against the db. IKf a match is found
     * the system will display the edit page for that record otherwise the link fails. If a match is found, the code is
     * deleted from the row and the user is presented with an end-user edit form.
    *  5) They can then submit the form (or not), but refreshing or returning to the form later will fail.
    *
    ========================= */
    public function registerSplashPage() {
        $this->viewBuilder()->setLayout('clean');
    }


    public function editmyregistration() {
        //If the request is GET, handle incoming link with code
        $this->viewBuilder()->setLayout('clean');

        if ($this->request->is('get')) :
                /* //For testing loads a predetermined form
                $registration = $this->Registrations->find('all')->where(['id' => 18])->first();
                $this->loadFormPrerequisites();
                $this->set('registration', $registration);
                */

            $submittedCode = $this->getAndValidateCodeFromQuery();
            if (!empty($submittedCode)) :
                $registration = $this->getRecordForCode($submittedCode);
                if ($registration) :
                     $this->set('registration', $registration);
                     $this->set('edit_code', $submittedCode);
                     $this->set('editFormDisplay', true);
                     $this->loadFormPrerequisites();
                else :
                    die('Edit code is invalid');
                endif;
            else :
                die('Edit code is invalid');
            endif;

        endif; //end GET handling logic


        //If the request contains a submittedEmail , treat it as a request to generate email
        //Send the email (if applicable) and show confirmation screen regardless.
        if ($this->request->getData('submittedEmail')) :
            $registration = $this->getRecordForEmail($this->request->getData('submittedEmail'));
            if (!empty($registration->id)) :
                $code = $this->generateEditCode();
                //Only send the email if the code insertion is successful.
                if ($this->addEditCodeToRecord($code, $registration)) :
                    $this->sendEmailWithCode($code, $registration->preferred_email);
                endif;
            endif;
            $this->set('submittedEmail', $this->request->getData('submittedEmail'));
            $this->set('emailConfirmation', true);
        endif;

        //If the request contains an edit_code, treat it as an edit submission
        //Process the submission and show confirmation screen.
        //Then expire the edit code.
        if ($this->request->getData('edit_code')) :
            $registrationByCode      = $this->getRecordForCode($this->request->getData('edit_code'));
            $registrationByFormEmail = $this->getRecordForEmail($this->request->getData('preferred_email'));
            if ($registrationByCode->id != $registrationByFormEmail->id) {
                die ('Trying to edit an invalid form or update your email address. Please contact the Long Service Awards to update your email address.');
            }
            $this->set('editSuccessMessage', true);
            $this->editPOST($registrationByCode);
            $this->expireCode($this->request->getData('edit_code'));
        endif;

    }


    private function generateEditCode(string $email = '233409@e4309284320984.com') : string {
        //Seed should be a unique string even if for the same email address.
        $seed = $email . time();
        //Security of the hash is mostly irrelevant given the single-use - simply needs to have
        //extremely low probability of collision (unique seeds practically guarantee it)
        return substr(hash('haval192,3', $seed), 0,32);
    }
    private function addEditCodeToRecord(string $code, object $registration) {
        $registration->edit_code = $code;
       return $this->Registrations->save($registration);
    }
    private function getRecordForCode(string $code = null) {
        if (empty($code)) {
            return false;
        }
        return $this->Registrations->find('all')->where(['Registrations.edit_code =' => $code])->limit(1)->first();

    }
    private function getRecordForEmail(string $email = null) {
        if (empty($email)) {
            return false;
        }
        return $this->Registrations->find('all')->where(['Registrations.preferred_email =' => $email])->limit(1)->first();

    }
    private function getAndValidateCodeFromQuery() {

       $code = $_GET['editcode'];
       return $code;
    }
    private function expireCode(string $code = null){
        if (empty($code)) {
            return true;
        }
        $record = $this->Registrations->find('all')->where(['Registrations.edit_code' => $code])->limit(1)->first();
        $record->edit_code = '';
       return $this->Registrations->save($record);
    }
    private function sendEmailWithCode(string $code, $email){
        $testing = false;

        if ($testing) :
            echo "This email address: " . $email . '<br>';
            echo "Would receive this code: " . $code . "<br>";
            echo "In this link <a href=\"editmyregistration/?editcode=" . $code . "\">Click Here to Edit Your Registration</a>";
            exit;
        else :
            //Prep email string

            $this->set('code', $code);
            $mailer = new Mailer();
            $mailer
                ->setEmailFormat('html')
                ->setFrom(['longserviceawards@gov.bc.ca' => 'Long Service Awards'])
                ->setTo($email)
                ->setSubject('Registration Edit Link')
                ->setViewVars(['code' => $code])
                ->viewBuilder()
                    ->setTemplate('registration_edit_link');
            //Send email
                $mailer->deliver();

        endif;
    }

    private function userEdit ($id, $code) {


      if ($this->request->is('post')) :
            //First make sure the record being posted to matches the record for the code

            $registration = $this->Registrations->find('all')->where(['Registrations.id' => $this->request->getData('')]);



          $this->viewBuilder()->setLayout('clean');

          //$this->edit();


         $this->set('editSuccessMessage', true);

          $this->expireCode($code);
      endif; //end POST logic.
      if ($this->request->is('get')) :
          $this->viewBuilder()->setLayout('clean');


      endif; //end GET logic, other methods should fail.



    }


    //This should be dynamic based on the options encoded in the award options JSON in
    //the awards table
    private function getAwardOptionsJSON() {
        //Magic Numbers!
        $bulova_watch_id = 9;
        $bracelet_35_id = 12;
        $bracelet_45_id = 29;
        $bracelet_50_id = 48;
        $options        = array();

        switch($this->request->getData('award_id')) {
            case $bulova_watch_id:
                $options['watch_size']      = $this->request->getData('watch_size');
                $options['watch_colour']    = $this->request->getData('watch_colour');
                $options['strap_type']      = $this->request->getData('strap_type');
                $options['watch_engraving'] = $this->request->getData('watch_engraving');
                break;
            case $bracelet_35_id:
            case $bracelet_45_id:
                $options['bracelet_size']   = $this->request->getData('braceletSize');
                break;
            case $bracelet_50_id:
                $options['bracelet_size']   = $this->request->getData('braceletSize');
                break;
            default:
                $options = array();
                break;
        }
        return json_encode($options);

    }
    private function handlePECSFDonation($registration) {
        $pecsf_25_id    = 49;
        $pecsf_30_id    = 50;
        $pecsf_35_id    = 51;
        $pecsf_40_id    = 52;
        $pecsf_45_id    = 53;
        $pecsf_50_id    = 54;
        $award_id       = $this->request->getData('award_id');

        switch ($award_id) {
            case $pecsf_25_id:
                $donationTotal = 75;
                break;
            case $pecsf_30_id:
                $donationTotal = 150;
                break;
            case $pecsf_35_id:
                $donationTotal = 300;
                break;
            case $pecsf_40_id:
                $donationTotal = 400;
                break;
            case $pecsf_45_id:
                $donationTotal = 450;
                break;
            case $pecsf_50_id:
                $donationTotal = 500;
                break;
            default:
                $registration->pecsf_donation = 0;
                return $registration;
        }

        // First grab our name.
        $registration->pecsf_name           = $this->request->getData('pecsf_name');
        $registration->pecsf_region_id      = $this->request->getData('pecsf_region');
        //if Pool is select save region
        if ($this->request->getData('donation_type') == 'pool') :
            $registration->pecsf_donation       = 1;
            $registration->pecsf_amount1        = $donationTotal;
        else:
            //If a 2nd charity is defined, split the total between them.
            if (is_numeric($this->request->getData('pecsf_charity_2'))) :
                $registration->pecsf_donation     = 1;
                $registration->pecsf_charity1_id  = $this->request->getData('pecsf_charity_1');
                $registration->pecsf_amount1      = $donationTotal / 2;
                $registration->pecsf_charity2_id  = $this->request->getData('pecsf_charity_2');
                $registration->pecsf_amount2      = $donationTotal / 2;
            else:
                $registration->pecsf_donation   = 1;
                $registration->pecsf_charity1_id = $this->request->getData('pecsf_charity_1');
                $registration->pecsf_amount1    = $donationTotal;
            endif;
        endif;
        return $registration;

    }


    public function completed ($id = null) {


        /*
        if (!$this->checkGUID($registration->user_guid)) {
            $this->Flash->error(__('You do not have access to this page.'));
            $this->redirect('/');
        }
        */
    }

    public function edit($id)
    {

        /*
        //If the referer is the special requirements export, put the user back in awards report
        if ($this->request->referer() == "/registrations/exportspecialrequirements" ||
            $this->request->referer() == "/registrations/reportawards") {
            $return_path = $this->request->referer();
        }
        //Default redirect
        else {
            $return_path = "/registrations";
        }
        */
        $return_path = "/admin";

        //Get registration and all its attached tables
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
            $this->redirect($return_path);
        }

        //On form submit...
        if ($this->request->is(['post', 'put'])) {
            $this->editPOST($registration);
            return $this->redirect($registration->return_path);
        };

        //Load variables for form
        $this->loadFormPrerequisites();
        $registration->return_path = $return_path;
        $this->set('registration', $registration);

        /*
        $query = $this->Registrations->RegistrationPeriods->find('all')
            ->where([
                'RegistrationPeriods.open_registration <=' => date('Y-m-d H:i:s'),
                'RegistrationPeriods.close_registration >=' => date('Y-m-d H:i:s')
            ]);
        $registration_periods = $query->first();
        */

        //Authorization check
        //TODO: Check to see if we can hoist this to the top of the method - JV
        //TODO: We probably want to do authorization at the routing level where possible - JV

        /*
        if ($this->checkAuthorization(array(
            Configure::read('Role.anonymous'),
            Configure::read('Role.authenticated_user'),
            Configure::read('Role.ministry_contact'),
            Configure::read('Role.supervisor')))) {
            if ($this->checkAuthorization(Configure::read('Role.anonymous'))) {
                $this->Flash->error(__('You are not authorized to edit this Registration.'));
                $this->redirect('/');
            }
            elseif ($this->checkAuthorization(Configure::read('Role.authenticated_user'))) {
                if (!$this->checkGUID($registration->user_guid)) {
                    $this->Flash->error(__('You are not authorized to edit this Registration.'));
                    $this->redirect('/registrations');
                }
                if (!$registration_periods) {
                    $this->Flash->error(__('You may no longer edit this Registration.'));
                    $this->redirect('/');
                }
            }
            elseif ($this->checkAuthorization(Configure::read('Role.supervisor'))) {
                if (!$this->checkGUID($registration->user_guid)) {
                    $this->Flash->error(__('You are not authorized to edit this Registration.'));
                    $this->redirect('/registrations');
                }
                if (!$registration_periods) {
                    $this->Flash->error(__('You may no longer edit this Registration.'));
                    $this->redirect('/');
                }
            }
            else if ($this->checkAuthorization(Configure::read('Role.ministry_contact'))) {
                if (!$this->checkAuthorization(Configure::read('Role.ministry_contact'), $registration->ministry_id)) {
                    $this->Flash->error(__('You are not authorized to edit this Registration.'));
                    $this->redirect('/registrations');
                }
                if (!$registration_periods) {
                    $this->Flash->error(__('You may no longer edit this Registration.'));
                    $this->redirect('/');
                }
            }
            $isadmin = false;
        }
        */

        //$this->set('isadmin', false);


    }
    private function loadFormPrerequisites() {
        //TODO: I suspect many of these are redundant and/or could be optimized - JV
        $milestones = $this->Registrations->Milestones->find('list');
        $this->set('milestones', $milestones);
        $milestoneInfo = $this->Registrations->Milestones->find('all');
        $this->set('milestoneinfo', $milestoneInfo);

        $awards = $this->Registrations->Awards->find('all');
        $this->set('awards', $awards);

        $cities = $this->Registrations->Cities->find('list', [
            'order' => ['Cities.name' => 'ASC']
        ]);
        $this->set('cities', $cities);

        $ministries = $this->Registrations->Ministries->find('list', [
            'order' => ['Ministries.name' => 'ASC']
        ]);
        $this->set('ministries', $ministries);

        $regions = $this->Registrations->PecsfRegions->find('all');
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


        $diet = $this->Registrations->Diet->find('all');
        $this->set('diet', $diet);

        $accessibility = $this->Registrations->AccessibilityOptions->find('all');
        $this->set('accessibility', $accessibility);




    }





    //TODO: Check to see if this method should be public, I suspect not - JV
    protected function logChanges($id, $type, $operation, $description, $old = NULL, $new = NULL) {
        $log = $this->Registrations->Log->newEmptyEntity();
        $session = $this->getRequest()->getSession();
        $log->user_idir = $session->read('user.idir');
        $log->user_guid = $session->read('user.guid');
        $log->timestamp = time();
        $log->registration_id = $id;
        $log->type = $type;
        $log->operation = $operation;
        $log->description = $description;
        if ($operation <> "NEW") {
            $log->old_value = $old;
        }
        $log->new_value = $new;
        // TODO:  Should this be a Try/Catch?
        if ($this->Registrations->Log->save($log)) {
        }
    }

    private function editPOST($registration) {
        $old = clone($registration);

        //Push data to fields
        $registration = $this->Registrations->patchEntity($registration, $this->request->getData());

        //Handle Award Options
        $registration->award_options = $this->getAwardOptionsJSON();
        $registration = $this->handlePECSFDonation($registration);

        //Update registration modified date
        $registration->modified = time();

        //Set invite_sent to null if the request data is empty
        if (empty($registration->invite_sent)) {
            $registration->invite_sent = NULL;
        }

        //Set photo_sent to null if the request data is empty
        //(this seems weird and possibly unnecessary)
        $registration->photo_sent = $this->request->getData('photo_sent');
        if (empty($registration->photo_sent)) {
            $registration->photo_sent = NULL;
        }

        if ($this->Registrations->save($registration)) {
            $this->processAdminDetails($registration, $old);
        } else {
            ddie('unable to update record');
        }
        //$this->Flash->error(__('Unable to update registration.'));
    }


    private function processAdminDetails($registration, $old) {
        //If the save goes through without error, check and log the changes.
        //TODO: There has to be a generic logging service that could replicate this w/o maintenance headache - JV

        if ($registration->milestone_id <> $old->milestone_id) {
            $milestone = $this->Registrations->Milestones->findById($registration->milestone_id)->firstOrFail();
            $description = "Milestone changed to " . $milestone->name;
            $this->logChanges($registration->id, "MILESTONE", "CHANGE", $description, $old->milestone_id, $registration->milestone_id);
        }

        if ($registration->award_id <> $old->award_id) {
            if ($registration->award_id == 0) {
                $name = "PECSF Donation";
            }
            else {
                $award = $this->Registrations->Awards->findById($registration->award_id)->firstOrFail();
                $name = $award->name;
            }
            $description = "Award changed to " . $name;
            $this->logChanges($registration->id, "AWARD", "CHANGE", $description, $old->award_id, $registration->award_id);
        }

        // if attending flag changed
        if ($registration->attending <> $old->attending) {
            $description = $registration->attending ? "Attending YES" : "Attending NO";
            $this->logChanges($registration->id, "ATTENDING", "CHANGE", $description, $old->attending, $registration->attending);
        }

        // if guest flag changed
        if ($registration->guest <> $old->guest) {
            $description = $registration->guest ? "Guest YES" : "Guest NO";
            $this->logChanges($registration->id, "GUEST", "CHANGE", $description, $old->guest, $registration->guest);
        }

        // if accessibility flag changed
        if ($registration->accessibility_recipient <> $old->accessibility_recipient || $registration->accessibility_guest <> $old->accessibility_guest ) {
            $description = ($registration->accessibility_recipient || $registration->accessibility_guest) ? "Accessibility YES" : "Accessibility NO";
            $old = ($old->accessibility_recipient || $old->accessibility_guest) ? 1 : 0;
            $new = ($registration->accessibility_recipient || $registration->accessibility_guest) ? 1 : 0;
            $this->logChanges($registration->id, "ACCESSIBILITY", "CHANGE", $description, $old, $new);
        }

        // if diet flag changed
        if ($registration->recipient_diet <> $old->recipient_diet || $registration->guest_diet <> $old->guest_diet ) {
            $description = ($registration->recipient_diet || $registration->guest_diet) ? "Diet YES" : "Diet NO";
            $old = ($old->recipient_diet || $registration->$old) ? 1 : 0;
            $new = ($registration->recipient_diet || $registration->guest_diet) ? 1 : 0;
            $this->logChanges($registration->id, "DIET", "CHANGE", $description, $old, $new);
        }

        //$this->Flash->success(__('Registration has been updated.'));

    }




    public function rsvp($id)
    {
        // customized layout excluding top nav, etc.
        $this->viewBuilder()->setLayout('clean');

        $query = $this->Registrations->RegistrationPeriods->find('all')
            ->where([
                'RegistrationPeriods.registration_year =' => date('Y')
            ]);
        $reg_period = $query->first();

        if (date('Y-m-d', strtotime($reg_period->close_rsvp)) < date('Y-m-d H:i:s')) {
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
            $registration->responded = 1;

            if ($this->Registrations->save($registration)) {

                if ($operation == "NEW" || $oldAttending <> $registration->attending) {
                    $description = $registration->attending ? "Attending YES" : "Attending NO";
                    $this->logChanges($registration->id, "ATTENDING", $operation, $description, $oldAttending, $registration->attending);
                }
                if ($operation == "NEW" || $oldGuest <> $registration->guest) {
                    $description = $registration->guest ? "Guest YES" : "Guest NO";
                    $this->logChanges($registration->id, "GUEST", $operation, $description, $oldGuest, $registration->guest);
                }
                if ($operation == "NEW" || $oldRecipientAccess <> $registration->accessibility_recipient || $oldGuestAccess <> $registration->accessibility_guest) {
                    $description = ($registration->accessibility_recipient || $registration->accessibility_guest) ? "Accessibility YES" : "Accessibility NO";
                    $old = ($oldRecipientAccess || $oldGuestAccess) ? 1 : 0;
                    $new = ($registration->accessibility_recipient || $registration->accessibility_guest) ? 1 : 0;
                    $this->logChanges($registration->id, "ACCESSIBILITY", $operation, $description, $old, $new);
                }
                if ($operation == "NEW" || $oldRecipientDiet <> $registration->recipient_diet || $oldGuestDiet <> $registration->guest_diet) {
                    $description = ($registration->recipient_diet || $registration->guest_diet) ? "Diet YES" : "Diet NO";
                    $old = ($oldRecipientDiet || $oldGuestDiet) ? 1 : 0;
                    $new = ($registration->recipient_diet || $registration->guest_diet) ? 1 : 0;
                    $this->logChanges($registration->id, "DIET", $operation, $description, $old, $new);
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

        $accessibility = $this->Registrations->AccessibilityOptions->find('all', [
            'order' => ['Accessibility.sortorder' => 'ASC',
                        'Accessibility.name' => 'ASC']
        ]);

        $this->set('accessibility', $accessibility);

        $this->set('regperiod', $reg_period);

        $this->set('registration', $registration);

        $isadmin = true;

        if (!$this->checkGUID($registration->user_guid)) {
            $this->Flash->error(__('You are not authorized to complete this RSVP.'));
            $this->redirect('/');
        }

        //
        $this->set('isadmin', $isadmin);


    }

    private function processEditData() {

    }


    public function delete($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin')))) {
            $this->Flash->error(__('You are not authorized to delete Registrations.'));
            $this->redirect('/');
        }
        $this->request->allowMethod(['post', 'delete']);

        $registration = $this->Registrations->findById($id)->firstOrFail();
        if ($this->Registrations->delete($registration)) {
            $this->Flash->success(__('The {0} registration has been deleted.', $registration->name));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function reportawardtotalstype() {
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
                'Awards',
                'Milestones',
                'Log' => function(\Cake\ORM\Query $q) {
                    return $q->where(["or" => ["type =" => "AWARD"]])
                        ->order(["timestamp" => "DESC"]);
                }
            ]
        ]);



        // load all Awards
        $info = [];
        $records = $this->Registrations->Awards->find('all');
        foreach ($records as $record) {
            $record->options = json_decode($record->options, true);
            $info[$record->id] = $record;
        }

        // load all Milestones
        $milestones = [];
        $records = $this->Registrations->Milestones->find('all');
        foreach ($records as $record) {
            $milestones[$record->id] = $record;
        }

        $awards = [];
        foreach ($registrations as $registration) {
            // generate key
            if ($registration->award_id > 0) {
                $name = $info[$registration->award_id]->name;
                $type = $this->awardOptionKey(json_decode($registration->award_options, true), $info[$registration->award_id]->options);
            }
            else {
                $name = "PECSF Donation";
                $type = $milestones[$registration->milestone_id]->name;
            }

            // search list
            $key = $this->findAward($awards, $name, $type);
            if ($key == -1) {
                $award = new \stdClass();
                $award->award = $name;
                $award->type = $type;
                $award->milestone = $milestones[$registration->milestone_id]->name;
                $award->count = 0;
                $award->lastupdate = $registration->created;
                $awards[] = $award;
                $key = $this->findAward($awards, $name, $type);
            }
            $awards[$key]->count++;
            if ($registration->created > $awards[$key]->lastupdate) {
                $awards[$key]->lastupdate = $registration->created;
            }
            if (isset($registration->log[0]->timestamp) && $registration->log[0]->timestamp > $awards[$key]->lastupdate) {
                $awards[$key]->lastupdate = $registration->log[0]->timestamp;
            }

        }
        $this->set(compact('awards'));

        $year = date('Y');
        $this->set(compact('year'));

        $today = date("M d, Y");
        $this->set(compact('today'));

    }

    public function findAward($awards, $name, $type) {

        foreach ($awards as $key => $award) {
            if ($award->award == $name && $award->type == $type) {
                return $key;
            }
        }
        return -1;
    }


    public function awardOptionKey($values, $options) {

        $key = "";
        foreach ($values as $value) {
            $pos = strpos($value, ":");
            $name = substr($value, 0, $pos);
            $type = "";
            foreach ($options as $option) {
                if ($option['name'] == $name) {
                    $type = $option['type'];
                    continue;
                }
            }
            if ($type == "choice") {
                if ($pos > 0) {
                    $value = substr($value, $pos+2);
                }
                if (!empty($key)) {
                    $key .= " - ";
                }
                $key .= $value;
            }
        }
        return $key;
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



    public function reportmilestonesummary() {
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
            'group' => ['Registrations.milestone_id']
        ]);
        $registrations->select([
            'milestone_id',
            'count' => $registrations->func()->count('*')]);


        $list = $this->Registrations->Milestones->find('all');

        $milestones = [];
        foreach ($list as $key => $record) {
            $record->count = 0;
            $milestones[] = $record;
        }
        foreach ($registrations as $record) {
            $key = $this->findInArray($milestones, $record->milestone_id);
            $milestones[$key]->count = $record->count;
        }
        $this->set('milestones', $milestones);

//        $this->set(compact('milestones'));

    }

    public function reportministrysummary() {
        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to view this page.'));
            $this->redirect('/');
        }

        $conditions = array();
        $conditions['Registrations.registration_year ='] = date('Y');

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


        $list = $this->Registrations->Milestones->find('all');

        $milestones = [];
        foreach ($list as $key => $record) {
            $milestones[] = $record;
        }
        $this->set('milestones', $milestones);

        $list = $this->Registrations->Ministries->find('all', [
            'order' => ['Ministries.name' => 'ASC']
        ]);

        $ministries = [];
        foreach ($list as $key => $record) {
            $ministry = new \stdClass();
            $ministry->id = $record->id;
            $ministry->name = $record->name;
            $ministry->name_shortform = $record->name_shortform;
            $ministry->milestone25 = 0;
            $ministry->milestone30 = 0;
            $ministry->milestone35 = 0;
            $ministry->milestone40 = 0;
            $ministry->milestone45 = 0;
            $ministry->milestone50 = 0;
            $ministry->total = 0;
            $ministries[] = $ministry;
        }

        foreach ($registrations as $registration) {
            $ministry_key = $this->findInArray($ministries, $registration->ministry_id);
            $milestone_key = $this->findInArray($milestones, $registration->milestone_id);
            switch($milestones[$milestone_key]->years) {
                case "25":
                    $ministries[$ministry_key]->milestone25++;
                    break;
                case "30":
                    $ministries[$ministry_key]->milestone30++;
                    break;
                case "35":
                    $ministries[$ministry_key]->milestone35++;
                    break;
                case "40":
                    $ministries[$ministry_key]->milestone40++;
                    break;
                case "45":
                    $ministries[$ministry_key]->milestone45++;
                    break;
                case "50":
                    $ministries[$ministry_key]->milestone50++;
                    break;
            }
            $ministries[$ministry_key]->total++;
        }
        $this->set('ministries', $ministries);
    }


    public function findInArray($array, $id) {
        $i = -1;
        foreach ($array as $key => $item) {
            if ($item->id == $id) {
                $i = $key;
            }
        }
        return $i;
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
                $empty = empty($recipient->presentation_number);
                $recipient->presentation_number = $this->request->getData('Registrations.'.$key. '.presentation_number');

                // if a presentation number is assigned and was previously empty set award received to true
                if (!empty($recipient->presentation_number) && $empty) {
                    $recipient->award_received = 1;
                }
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
        $conditions['Registrations.waitinglist ='] = 0;

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
        return $this->redirect(['action' => 'attendingrecipients', $id]);
    }



    public function emailinvites($id) {

        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to administer Ceremonies.'));
            $this->redirect('/');
        }

        $ceremony = $this->Registrations->Ceremonies->findById($id)->firstOrFail();

        $conditions = array();
        $conditions['Registrations.registration_year ='] = date('Y');
        $conditions['Registrations.ceremony_id ='] = $id;
        $conditions['Registrations.waitinglist = '] = 0;
        $conditions[] = 'Registrations.invite_sent IS NULL';

        $registrations = $this->Registrations->find('all', [
            'conditions' => $conditions,
        ]);

        $ctr = 0;
        foreach ($registrations as $registration) {
            $name = $registration->first_name . " "  . $registration->last_name;
            $date = date("F d, Y", strtotime($ceremony->date));

            $pdf_file = $this->createPDF($registration->id, $name, $date);
            $email = $registration->preferred_email;
            if (Configure::read('Test.mode')) {
                $email = Configure::read('Test.email');
            }
            $this->sendEmail($registration->id, $email, $name, $date, $pdf_file);
            if (!empty($registration->alternate_email)) {
                if (Configure::read('Test.mode')) {
                    $email = Configure::read('Test.email');
                }
                $this->sendEmail($registration->id, $email, $name, $date, $pdf_file);
            }
            // update invite sent date here
            $registration->invite_sent = time();
            $this->Registrations->save($registration);

            $ctr++;
        }

        $this->Flash->success(__('Invites Sent (' . $ctr . ')'));

        return $this->redirect(['action' => 'attendingrecipients', $id]);
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
        $conditions['Registrations.waitinglist ='] = 0;

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

        $accessibility = $this->Registrations->AccessibilityOptions->find('all');
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
            foreach ($requirements as $req_id) {
                $totals->access_requirements[$req_id]->total++;
            }
            $requirements = json_decode($recipient->accessibility_requirements_guest, true);
            foreach ($requirements as $req_id) {
                $totals->access_requirements[$req_id]->total++;
            }

            $requirements = json_decode($recipient->dietary_requirements_recipient, true);
            foreach ($requirements as $req_id) {
                $totals->diet_requirements[$req_id]->total++;
            }

            $requirements = json_decode($recipient->dietary_requirements_guest, true);
            foreach ($requirements as $req_id) {
                $totals->diet_requirements[$req_id]->total++;
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
        $conditions['Registrations.waitinglist ='] = 0;

        $recipients = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'order' => ['Registrations.last_name' => 'ASC'],
        ]);

        $records = $this->Registrations->AccessibilityOptions->find('all');
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
        $conditions['Registrations.waitinglist ='] = 0;

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
        }

        $recipients = $temp;

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
            // TODO: Not sure what the purpose of this was - commenting out top line.
            //$conditions['Registrations.attending ='] = true;
            $conditions['Registrations.attending ='] = false;
        }
        $conditions['Registrations.waitinglist ='] = 0;

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
        $conditions['Registrations.waitinglist ='] = 0;

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
        if ($this->checkAuthorization(array(Configure::read('Role.anonymous')))) {
            $this->Flash->error(__('You are not authorized to administer Registrations.'));
            $this->redirect('/');
        }

        $conditions = array();
        $conditions['Registrations.registration_year ='] = date('Y');
        $conditions['Registrations.waitinglist ='] = 0;

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


    /**
     * For route /registrations/reportawards
     * Works with reportawards.php template
     *      sets 'recipients' and 'year'
     * Dependent on RegistrationsTable.
     */
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
                'PecsfCharities1',
                'PecsfCharities2',
                'PecsfRegions'
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
                'Log' => function(\Cake\ORM\Query $q) {
                    return $q->where(["or" => ["type =" => "ATTENDING", "type =" => "AWARD"]])
                        ->order(["timestamp" => "DESC"]);
                }
            ],
        ]);

        $year = date('Y');
        $this->set(compact('year'));

        $today = date("M d, Y");
        $this->set(compact('today'));

        $list = [];
        foreach ($recipients as $recipient) {
            if (isset($recipient->log[0]->timestamp)) {
                $recipient->lastupdate = $recipient->log[0]->timestamp;
            }
            else {
                $recipient->lastupdate = $recipient->created;
            }
            $list[] = $recipient;
        }
        $recipients = $list;
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
                'Log' => function(\Cake\ORM\Query $q) {
                    return $q->where(["or" => ["type =" => "ATTENDING", "type" => "MILESTONE"]])
                             ->order(["timestamp" => "DESC"]);
                }
            ],
        ]);

        $year = date('Y');
        $this->set(compact('year'));

        $today = date("M d, Y");
        $this->set(compact('today'));

        $list = [];
        foreach ($recipients as $recipient) {
            if (isset($recipient->log[0]->timestamp)) {
                $recipient->lastupdate = $recipient->log[0]->timestamp;
            }
            else {
                $recipient->lastupdate = $recipient->created;
            }
            $list[] = $recipient;
        }
        $recipients = $list;
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
                'Log' => function(\Cake\ORM\Query $q) {
                    return $q->where(["or" => ["type =" => "ATTENDING", "type" => "AWARD"]])
                             ->order(["timestamp" => "DESC"]);
                }
            ],
        ]);

        $year = date('Y');
        $this->set(compact('year'));

        $today = date("M d, Y");
        $this->set(compact('today'));

        $list = [];
        foreach ($recipients as $recipient) {
            if (isset($recipient->log[0]->timestamp)) {
                $recipient->lastupdate = $recipient->log[0]->timestamp;
            }
            else {
                $recipient->lastupdate = $recipient->created;
            }
            $list[] = $recipient;
        }
        $recipients = $list;
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
        $conditions['Registrations.waitinglist ='] = 0;

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

        if ($this->checkAuthorization(array(Configure::read('Role.anonymous')))) {
            $this->Flash->error(__('You are not authorized to administer Registrations.'));
            $this->redirect('/');
        }

        $conditions = array();
        $conditions['Registrations.registration_year ='] = date('Y');
        $conditions['Registrations.ceremony_id >'] = 0;
        $conditions['Registrations.waitinglist ='] = 0;

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
                    return $q->where(["or" => ["type =" => "ATTENDING"]])
                             ->order(["timestamp" => "DESC"]);
                }
            ],
        ]);

        $year = date('Y');
        $this->set(compact('year'));

        $today = date("M d, Y");
        $this->set(compact('today'));

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
                $info->milestone = $recipient->milestone->name;
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

        if ($this->checkAuthorization(array(Configure::read('Role.anonymous')))) {
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
                'Log' => function(\Cake\ORM\Query $q) {
                    return $q->where(["or" => ["type =" => "ATTENDING", "type =" => "AWARD"]])
                        ->order(["timestamp" => "DESC"]);
                }
            ],
        ]);

        $year = date('Y');
        $this->set(compact('year'));

        $today = date("M d, Y");
        $this->set(compact('today'));

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
                $info->total = 0;
                $info->attending = 0;
                $info->notattending = 0;
                $info->lastupdate = $recipient->created;
                $totals[] = $info;
                $i = $this->findInTotalsMilestone($totals, $recipient->milestone_id, $recipient->award_id);
            }

            $totals[$i]->total++;
            if ($recipient->attending) {
               $totals[$i]->attending++;
            }
            else {
               $totals[$i]->notattending++;
            }
            if ($recipient->created > $totals[$i]->lastupdate) {
                $totals[$i]->lastupdate = $recipient->created;
            }
            if (isset($recipient->log[0]->timestamp) && $recipient->log[0]->timestamp > $totals[$i]->lastupdate) {
                $totals[$i]->lastupdate = $recipient->log[0]->timestamp;
            }

        }
        $recipients = $totals;
        $this->set(compact('recipients'));

    }


    public function exportbadges($id, $attending = true)
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
        $conditions['Registrations.waitinglist ='] = 0;
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
        $conditions['Registrations.ceremony_id >'] = 0;
        $conditions['Registrations.waitinglist ='] = 0;

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
        $conditions['Registrations.waitinglist ='] = 0;
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

        $milestones = $this->Registrations->Milestones->find('all');

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

        $results = [];
        foreach ($recipients as $recipient) {
            $i = $this->findCeremonyMinistry($results, $recipient->ceremony_id, $recipient->ministry_id);
            if ($i == -1) {
                $info = new \stdClass();
                $info->ceremony_id = $recipient->ceremony_id;
                $info->ministry_id = $recipient->ministry_id;
                $info->ceremony = $recipient->ceremony;
                $info->ministry = $recipient->ministry;
                $info->total_attending = 0;

                $info->years = array();
                foreach ($milestones as $milestone) {
                   $info->years[$milestone->years]['attending'] = 0;
                }
                $info->years['executives']['attending'] = 0;
                $info->years['total']['attending'] = 0;

                $results[] = $info;
                $i = $this->findCeremonyMinistry($results, $recipient->ceremony_id, $recipient->ministry_id);
            }

            if ($recipient->responded) {
                if ($recipient->attending) {
                    $results[$i]->years[$recipient->milestone->years]['attending']++;
                    $results[$i]->years['total']['attending']++;
                    $results[$i]->total_attending++;
                    if ($recipient->guest) {
                        $results[$i]->years[$recipient->milestone->years]['attending']++;
                        $results[$i]->years['total']['attending']++;
                        $results[$i]->total_attending++;
                    }
                }
            }
        }

        // load VIP model so we add VIP numbers to report. Not ideal, but this is the simplest way to accomplish this.
        $this->loadModel('Vip');

        $conditions = array();
        $conditions['Vip.year ='] = date('Y');
        $conditions['Vip.ceremony_id >'] = 0;
        $conditions['Vip.attending ='] = 1;

        $executives = $this->Vip->find('all', [
            'conditions' => $conditions,
            'contain' => [
                'Ministries',
                'Ceremonies',
            ],
        ]);

        foreach ($executives as $executive) {
            $i = $this->findCeremonyMinistry($results, $executive->ceremony_id, $executive->ministry_id);
            if ($i == -1) {
                $info = new \stdClass();
                $info->ceremony_id = $executive->ceremony_id;
                $info->ministry_id = $executive->ministry_id;
                $info->ceremony = $executive->ceremony;
                $info->ministry = $executive->ministry;
                $info->total_attending = 0;

                $info->years = array();
                foreach ($milestones as $milestone) {
                    $info->years[$milestone->years]['attending'] = 0;
                }
                $info->years['executives']['attending'] = 0;
                $info->years['total']['attending'] = 0;

                $results[] = $info;
                $i = $this->findCeremonyMinistry($results, $executive->ceremony_id, $executive->ministry_id);
            }

            if ($executive->attending) {
                    $results[$i]->years['executives']['attending'] += $executive->total_attending;
                    $results[$i]->years['total']['attending'] += $executive->total_attending;
                    $results[$i]->total_attending += $executive->total_attending;

            }
        }

        $this->loadModel('Registrations');

        $this->set(compact('milestones'));

        $this->set(compact('results'));
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

        $edit = true;

        $conditions = array();
        $conditions['Registrations.attending ='] = 1;
        $conditions['Registrations.waitinglist ='] = 0;
        $conditions["or"] = ["Registrations.accessibility_recipient =" => 1, "Registrations.accessibility_guest =" => 1, "Registrations.recipient_diet =" => 1, "Registrations.guest_diet =" => 1];

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


        $records = $this->Registrations->AccessibilityOptions->find('all');
        $accessibility = [];
        foreach ($records as $value) {
            $accessibility[$value->id] = $value;
        }

        $records = $this->Registrations->Diet->find('all');
        $diet = [];
        foreach ($records as $value) {
            $diet[$value->id] = $value;
        }

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
        $this->set(compact('edit'));
    }


    public function reportministryrecipients()
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
        $conditions['Registrations.waitinglist ='] = 0;

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

    /**
     * Creates a dashboard for protocol to see which registrants are on a waiting list for any ceremony.
     * Accepts post requests to add registrants to the waiting list for a ceremony
     */

    public function reportwaitinglist()
    {
        if ($this->checkAuthorization(array(Configure::read('Role.anonymous')))) {
            $this->Flash->error(__('You are not authorized to administer Registrations.'));
            $this->redirect('/');
        }

        if ($this->request->is('post')):
            //Retrieve registrant by ID
            $registrant = $this->Registrations->get($this->request->getData('registrant_id'));
            $registrant->ceremony_id = $this->request->getData('ceremony_id');
            $registrant->waitinglist = 1;
            $registrationsTable = $this->getTableLocator()->get('Registrations');
            if (!($registrationsTable->save($registrant))) {
                //throw an exception
            }
        endif;


        $conditions = array();
        $conditions['Registrations.registration_year ='] = date('Y');
        $conditions['Registrations.waitinglist ='] = 1;

        $waiting = $this->Registrations->find('all', [
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

        $conditions = array();
        $conditions['Registrations.registration_year ='] = date('Y');
        $conditions['Registrations.waitinglist ='] = 0;

        $this->set('ceremonies', $this->getTableLocator()->get('Ceremonies')->find('all'));

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

        $this->set('registrants', $this->Registrations->find('all'));

        $waiturl = Router::url(array('controller'=>'Registrations','action'=>'wait'));
        $this->set(compact('waiturl'));

        $this->set(compact('waiting'));
        $this->set(compact('recipients'));
    }


    public function wait(){
        if( $this->request->is('ajax') ) {
            $id = $this->request->getData('id');

            $recipient = $this->Registrations->findById($id)->firstOrFail();
            $recipient->waitinglist = 1;
            $this->Registrations->save($recipient);

            return;
        }

    }


    public function reportpivot($attending = 0)
    {

        if (!$this->checkAuthorization(array(
            Configure::read('Role.admin'),
            Configure::read('Role.lsa_admin'),
            Configure::read('Role.protocol')))) {
            $this->Flash->error(__('You are not authorized to view this page.'));
            $this->redirect('/');
        }

        $query = $this->Registrations->RegistrationPeriods->find('all')
            ->where([
                'RegistrationPeriods.open_registration <= ' => date('Y-m-d H:i:s'),
                'RegistrationPeriods.close_registration >= ' => date('Y-m-d H:i:s')
            ]);
        $registration_period = $query->first();

        $years = explode(",", $registration_period->qualifying_years);

        $milestones = $this->Registrations->Milestones->find('all');


        $conditions = array();
        $conditions['Registrations.registration_year ='] = date('Y');
        $conditions['Registrations.ceremony_id >'] = 0;
        $conditions['Registrations.waitinglist ='] = 0;
        if ($attending == 1) {
            $conditions['Registrations.attending'] = 1;
            $title = "Attendees Only";
        }
        else {
            $title = "All Recipients";
        }

        $recipients = $this->Registrations->find('all', [
            'conditions' => $conditions,
            'order' => ['Registrations.last_name' => 'ASC'],
            'contain' => [
                'Ceremonies',
                'Milestones',
                'Ministries',
                'Awards',
                'OfficeCity',
                'HomeCity',
                'SupervisorCity'
            ],
        ]);

        $results = [];
        foreach ($recipients as $recipient) {
            $i = $this->findCeremonyMinistry($results, $recipient->ceremony_id, $recipient->ministry_id);
            if ($i == -1) {
                $info = new \stdClass();
                $info->ceremony_id = $recipient->ceremony_id;
                $info->ministry_id = $recipient->ministry_id;
                $info->ceremony = $recipient->ceremony;
                $info->ministry = $recipient->ministry;
                $info->milestone = $recipient->milestone;
                $info->total = 0;

                $info->years = array();
                foreach ($years as $year) {
                    foreach ($milestones as $milestone) {
                        $info->years[$year][$milestone->years] = 0;
                    }
                    $info->years[$year]['Total'] = 0;
                }

                $results[] = $info;
                $i = $this->findCeremonyMinistry($results, $recipient->ceremony_id, $recipient->ministry_id);
            }
            $results[$i]->years[$recipient->qualifying_year][$recipient->milestone->years]++;
            $results[$i]->years[$recipient->qualifying_year]['Total']++;
            $results[$i]->total++;
        }

        $this->set(compact('results'));

        $this->set(compact('title'));

        $this->set(compact('years'));
        $this->set(compact('milestones'));
        $this->set(compact('registration_period'));

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

    public function findCeremonyMinistry($array, $ceremony_id, $ministry_id) {
        $x = -1;
        foreach ($array as $key => $item) {
            if ($item->ministry_id == $ministry_id && $item->ceremony_id == $ceremony_id) {
                $x = $key;
            }
        }
        return $x;
    }

    public function createPDF($reg_id, $name, $date) {

        require_once(ROOT . DS . 'vendor' . DS . 'fpdf' . DS . 'fpdf.php');

        // Create handle for new PDF document
        $pdf = new \FPDF('P', 'pt', array(610,675));

        // Will save pdfs here
        $filepath = ROOT . DS . 'webroot' . DS . 'invites' . DS . 'Printable_Keepsake_Invitation_' . $reg_id . '.pdf';

        // Make sure this doesn't already exist - if it does delete it.
        if(file_exists($filepath)){
            unlink($filepath);
            // Rebuild php cache to show file is gone.
            clearstatcache();
        }

        // Add our first page The origin is at the upper-left corner and the current position is by default set at 1 cm from the borders; the margins can be changed with SetMargins().
        $pdf->AddPage();

        // Get font ready, include in file, We could have specified italics with I, underlined with U or a regular font with an empty string (or any combination). font size specified by points
        $pdf->SetFont("Times", 'IB', 20);

        // Grab our invitation image
        $invitation = ROOT . DS . 'webroot' . DS . 'img' . DS . 'lsa_invite.jpg';
        // Add the image
        $pdf->Image($invitation, 15,15, 580,0,'JPG');

        // Set our mark in the proper place for the name
        $pdf->SetY(300);

        // Add name Text(float x, float y, string txt)
        $pdf->Cell(0,0,$name,0,1,'C');
        //$pdf->Text(250, 100, $username);

        // Now set our marker to the date field5pudGr@vy1
        $pdf->SetY(375);
        // Add date
        $pdf->Cell(0,0,$date,0,1,'C');
        //$pdf->Text(60,300, $date);
        // Save to file string Output([string dest [, string name [, boolean isUTF8]]])
        $pdf->Output('F', $filepath);
        // Should be destroyed in output, but we can crush it here just in case
        $pdf->Close();

        return $filepath;
    }

    public function sendEmail($id, $email, $full_name, $ceremony_date, $pdf_file) {

        $invite_sized = $_SERVER['HTTP_HOST'] . DS . 'webroot' . DS . 'img' . DS . 'lsa_invite.jpg';;

        $rsvp_url = "/rsvp/" . $id;

        // Send email here
        $mailer = new Mailer('default');
        // TODO: This template should be separated out as per instructions here: https://book.cakephp.org/4/en/core-libraries/email.html
        $message = <<<EOT
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
    /* Your Outlook-specific CSS goes here. */
  .ExternalClass{
    width:100%;
  }

  .ExternalClass,
  .ExternalClass p,
  .ExternalClass span,
  .ExternalClass font,
  .ExternalClass td,
  .ExternalClass div{
    line-height: 100%;
    padding: 0px !important;
  }

  #outlook a{
      display: block;
      padding:0;
  }

  table{
      mso-table-lspace:0pt;
      mso-table-rspace:0pt;
  }

   img{
        -ms-interpolation-mode:bicubic;
    }


    </style>

</head>

<body id="mimemail-body" class="atwork-mail-default" style="padding:0;">
<p> To RSVP for your Long Service Awards ceremony, <strong>click on the invitation below.</strong></p>

<p> Note: If you are unable to view the invitation below, follow the Outlook prompts to download pictures. If you still cannot access the invitation and RSVP form, or if you are retired from the public service, please email the <a href="mailto:longserviceawards@gov.bc.ca">Long Service Awards team</a> for assistance.  </p>

<p> If you would like to print your invitation as a keepsake, the attached PDF version has been provided. </p>

<table width="750" border="0" cellpadding="0" cellspacing="0" style = "page-break-before:always; padding:0;" >
  <tbody>
    <tr  style="width:720px !important; height:100% !important; max-height:100% !important; background-size:100%; padding:0 !important; vertical-align:top; float: left;">
     <td BACKGROUND="$invite_sized" width="750" style="width:720px !important;height:100% !important; max-height:886px !important; min-height:800px !important;background-size:100%; padding:0 !important; vertical-align:top; float: left;"><a href="$rsvp_url">

  <div id="main" style="padding:0 !important">
          <table width="750" border="0" cellpadding="0" cellspacing="0" border-spacing="0">
            <tbody>
              <tr style="max-height:315px; padding:0 !important; vertical-align:top;float:left;">
                <td class="outlook-box" width="750" height="315" style="max-height:315px !important; padding:0 !important; vertical-align:top;"><span style="padding:0 !important vertical-align:top; float:left;">&nbsp;</span></td>
              </tr>
              <tr style="max-height:60px; padding:0 !important; vertical-align:top;float:left;">
                <td class="initial-height-box" width="750" height="60"style="max-height:60px !important;font-size: 19pt; color: #333333; text-align: center; font-family: Times, 'Times New Roman', 'serif'; font-weight: 900; padding:0 !important; vertical-align:top;float:left;"><span style="padding:0 !important"><i><b>$full_name</b></i></span></td>
              </tr>
              <tr style="max-height:60px; padding:0 !important; vertical-align:top;float:left;">
                <td width="750" height="40" style="max-height:30px; padding:0 !important; vertical-align:top;float:left;"><span style="padding:0 !important">&nbsp;</span></td>
              </tr>
              <tr style="max-height:60px !important; font-size: 19pt; color: #333333; text-align: center; font-family: Times; font-weight: 900; padding:0 !important; vertical-align:top;float:left;">
                <td width="750" height="60" style="max-height:60px !important; font-size: 19pt; color: #333333; text-align: center; font-family: Times, 'Times New Roman', 'serif'; font-weight: 900; padding:0 !important; vertical-align:top;float:left;"><i><b>$ceremony_date</b></i></span></td>
              </tr>
              <tr style="max-height:20px !important; padding:0 !important; vertical-align:top;float:left;"><span style="padding:0 !important vertical-align:top;">
                <td width="750" height="20" style="max-height:20px !important; padding:0 !important; vertical-align:top;float:left;"><span style="padding:0 !important vertical-align:top;">&nbsp;</span></td>
              </tr>
            </tbody>
          </table>
        </div>
  </a>
  </td>
    </tr>
  </tbody>
</table>
</body>
<br />
</html>
EOT;

        // send to primary and secondary email (if provided)
        $mailer->setFrom(['longserviceaward@gov.bc.ca' => 'Long Service Awards'])
            ->setTo($email)
            ->setSubject('Your Long Service Awards Invitation')
            ->setAttachments([
                basename($pdf_file) => [
                    'file' => $pdf_file,
                    'mimetype' => 'application/pdf',
                    'contentId' => 'my-unique-id'
                ]
            ])
            ->deliver($message);
    }
}
