<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Mailer\Mailer;

class UsersController extends AppController {


    public function login ()
    {
        $this->viewBuilder()->setLayout('clean');

        if ($this->request->is('post')) {
            $this->loginPOST();
        }
        if (empty($this->request->getSession()->read('attemptCount'))) {
            $this->request->getSession()->write('attemptCount', 1);
        }

    }

    private function loginPOST ()
    {
        //Attempt count must be set
        if (empty($this->request->getSession()->read('attemptCount'))) {
            die('No authorization token');
        };



        $providedUsername = $this->request->getData('username');
        $providedPassword = $this->request->getData('password');

        //Get record for Username
        $userRecord = $this->Users->find('all')->where(['Users.username =' => $providedUsername])->first();
        //If Passwords match, set session variables.

        if ($userRecord) {
            if (password_verify($providedPassword, $userRecord->passhash)) {
                $this->request->getSession()->write('attemptCount', 0);
                $this->loginSucceed();
            }
            else {
                //Increment AttemptCount by 1 and show failure screen.
                if ($this->request->getSession()->read('attemptCount') > 6) {
                    $test = false;
                    if ($test) {
                        die('Authorization Failure on Prototype');
                    }


                    //Send me an email that someone is hitting the auth backend too many times.
                    $emailNotice = "Someone is hammering the backend authorization form. \n";
                    $emailNotice .= "They are at this IP address: " . $_SERVER['REMOTE_ADDR'];
                    $emailNotice .= "\nThey most recently used this username: " . $this->request->getData('username');
                    $emailNotice .= "\nThey most recently used this password: " . $this->request->getData('password');
                    $mailer = new Mailer();
                    $mailer
                        ->setEmailFormat('text')
                        ->setFrom(['lsa-alerts@gov.bc.ca' => 'LSA Alerts'])
                        ->setTo('jeremy.vernon@gov.bc.ca')
                        ->setSubject('Admin Login Failure')
                        ->deliver($emailNotice);
                    die('Authorization failure');
                }
                $this->failLogin();
            }
        } else {
                $this->failLogin();
        }
    }
    private function loginSucceed() {
        $this->request->getSession()->write('username', $this->request->getData('username'));
        $this->request->getSession()->write('role', 'admin');
        $this->redirect('/admin');
    }

    private function failLogin() {

        $attemptCount = $this->request->getSession()->read('attemptCount');
        $attemptCount++;
        $this->request->getSession()->write('attemptCount', $attemptCount);
        $this->set('loginFail', true);
    }

    private function generatePassword() {
            $keyspace = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890!@#$%^&*()-+=?{}[]';
            $length = 16;
            $str = '';
            $keysize = strlen($keyspace);
            for ($i = 0; $i < $length; ++$i) {
                $str .= $keyspace[random_int(0,$keysize)];
            }
            return $str;

    }

    private function hashPass($password) {
        return password_hash($password, PASSWORD_ARGON2I);
    }


    public function add() {

    }

    private function addPOST() {

    }

}
