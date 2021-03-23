<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Database\Type;
use Cake\Http\Cookie\CookieCollection;
use Cake\Http\Cookie\Cookie;



Type::build('datetime')->useLocaleParser();

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */


    public function initialize(): void
    {


        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        $session = $this->request->getAttribute('session');
        //var_dump($session->read());
        $user = $session->read('User');
        //If request is NOT a zero-authorization action
        //check for session details
        //If no session details work, push users to login

        if (!$this->isZeroAuthAction()) {

            if ($user['role'] != 'admin') {
                var_dump($this->request->getParam('controller'));
                var_dump($this->request->getParam('action'));
                die('You must login first');
            }
        }





    /*
        $this->checkSAML();

            $guid =  $this->request->getSession()->read('user.guid');
            $idir =  $this->request->getSession()->read('user.idir');


        if (empty($guid) || empty($idir)) {
            die('Missing context variables');
            $this->checkSAML();
        }
      // check if user has administrative privileges
        $this->loadModel('UserRoles');
        $users = $this->UserRoles->find('all', [
            'conditions' => ['UserRoles.guid =' => $guid],
            'limit' => 1,
        ]);
        $user = $users->first();


        if (!$user) {

            // We check for record with matching IDIR and empty GUID. We need to check empty GUID in case there is an existing
            // matching IDIR with a different GUID.
            $users = $this->UserRoles->find('all', [
                'conditions' => [
                    'UserRoles.idir =' => $idir,
                    'UserRoles.guid =' => $guid,
                    ],
                'limit' => 1,
            ]);
            $user = $users->first();
            if ($user) {
                $user->guid = $guid;
                $this->UserRoles->save($user);
            }
        }


        if ($user) {
            $this->request->getSession()->write('user.role', $user->role_id);
            $this->request->getSession()->write('user.ministry', $user->ministry_id);
        }

    */
        /*
               else {

                   /*
                   // This is not a known user.
                   // Prepare a new user entity.
                   $new_user = $this->UserRoles->newEmptyEntity();
                   // Populate new user record.
                   $new_user->idir = $idir;
                   $new_user->guid = $guid;
                   // Role 7 is the authenticated role.
                   $new_user->role_id = 7;
                   // For now we will save this as Unassigned ministry - but in the future we should check the record
                   // vs. the list we have for a match.
                   $this->loadModel('Ministries');
                   // Get the ministry id
                   $placeholderMinistryId = $this->Ministries->findByName('Unassigned')->First();
                   if(isset($placeholderMinistryId->id)) {
                       $ministryId = $placeholderMinistryId->id;
                   } else {
                       // If placeholder ministry does not exist create it.
                       $newMinistry  = $this->Ministries->newEmptyEntity();
                       $newMinistry->set(array(
                           "name=>Unassigned",
                           "name_shortform=>Unassigned"
                       ));
                       // Save the entity.
                       $savedMinistry = $this->Ministries->save($newMinistry);
                       // If our save fails, set to 0 which will get caught as an error.
                       $ministryId = $savedMinistry->id ?? 0;
                   }
                   $new_user->set('ministry_id',  $ministryId);
                   // Save new user to db.
                   $this->UserRoles->save($new_user);
                   // Now we can set them as an authenticated user.
                   $this->request->getSession()->write('user.role', 7);
                   $this->request->getSession()->write('user.ministry', $ministryId);
                   // This user should be redirected to register, it is the only place for reg auth users.
                   */
        //}

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/4/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }
    public function checkSAML() {

        if ($this->request->getSession()->read('user.guid')) {
        return;
        }
        /*
        if ($_POST['SAMLResponse'] && empty($this->request->getSession()->read('user.guid'))) {


            header ('Location: https://lsaapp.gww.gov.bc.ca/saml/acs');


        }
        */
        header ('Location: https://lsaapp.gww.gov.bc.ca/saml/sso');
    }

    public function isZeroAuthAction() {
        if ($this->request->getParam('controller') != 'Registrations') {
            if ($this->request->getParam('controller') != 'Users') {
                return false;
            }
        }

        $zeroAuthActions = array    ('register',
                                    'editmyregistration',
                                    'registerSplashPage',
                                    'completed',
                                    'login');

        foreach ($zeroAuthActions as $zeroAuthAction) :
            if ($this->request->getParam('action') == $zeroAuthAction) {
                return true;
            }
        endforeach;

        return false;
    }

    public function acs () {
        $this->initSAML();
        $auth = new \OneLogin_Saml2_Auth($this->settings);

        $auth->processResponse();

     if ($this->request->getSession()->read('AuthNRequestID') != $auth->getLastAssertionId()) :

        $this->request->getSession()->write('AuthNRequestID', $auth->getLastAssertionId());
        //If there are errors, display them then exit.
        $errors = $auth->getErrors();
        if (!empty($errors)) {
            echo "There were errors";
            echo '<p>',implode(', ', $errors),'</p>';
            if ($auth->getSettings()->isDebugActive()) {
                echo '<p>'.$auth->getLastErrorReason().'</p>';
            }
            exit();
        }
        if (!$auth->isAuthenticated()) {
            echo "<p>Sorry, you could not be authenticated.</p>";
            exit();
        };

        $this->request->getSession()->write('user.guid', $auth->getAttributes()['SMGOV_GUID'][0]);
        $this->request->getSession()->write('user.idir', $auth->getAttributes()['username'][0]);
        endif;
    }


    public function checkAuthorization($roles = 1, $ministry = 0) {

        if (!is_array($roles)) {
            $roles = array($roles);
        }
        $session = $this->getRequest()->getSession();
        if (in_array($session->read('user.role'), $roles)) {
            if ($ministry > 0) {
                if ($session->read('user.ministry') == $ministry) {
                    return true;
                }
            }
            else {
                return true;
            }
        }
        return false;
    }


    public function checkGUID($guid) {
        $session = $this->getRequest()->getSession();
        return $session->read("user.guid") == $guid;
    }


    private function initSAML() {
        $this->loadSettings();
        $this->loadToolkit();
    }

    private function loadToolkit() {
        define('TOOLKIT_PATH', __DIR__ . '/../../vendor/onelogin/SAML/src/');

        // Create an __autoload function
        // (can conflicts other autoloaders)
        // http://php.net/manual/en/language.oop5.autoload.php

        //TODO: use proper class loading to access libs

        $libDir = __DIR__ . '/../../vendor/onelogin/SAML/src/lib/Saml2/';
        $extlibDir = __DIR__ . '/../../vendor/onelogin/SAML/src/extlib/';

        // Load composer
        if (file_exists(__DIR__ .'/vendor/autoload.php')) {
            require __DIR__ . '/vendor/autoload.php';
        }

        // Load now external libs
        require_once $extlibDir . 'xmlseclibs/xmlseclibs.php';

        $folderInfo = scandir($libDir);

        foreach ($folderInfo as $element) {
            if (is_file($libDir.$element) && (substr($element, -4) === '.php')) {
                include_once $libDir.$element;
                //break;
            }
        }
    }

    private function loadSettings() {


        if (empty($_ENV['saml-SP-x509'])) {
            //die('Authentication parameters are not properly set - please contact administrator (jeremy.vernon@gov.bc.ca)');

            $_ENV['saml-SP-x509'] = 'x509CertGoes Here';
            $_ENV['saml-pk'] = 'saml-pk goes here';
            $_ENV['saml-IdP-x509'] = 'x509CertGoes Here';
        }
        $this->settings = array (
            // If 'strict' is True, then the PHP Toolkit will reject unsigned
            // or unencrypted messages if it expects them signed or encrypted
            // Also will reject the messages if not strictly follow the SAML
            // standard: Destination, NameId, Conditions ... are validated too.
            'strict' => false,

            // Enable debug mode (to print errors)
            'debug' => true,

            // Set a BaseURL to be used instead of try to guess
            // the BaseURL of the view that process the SAML Message.
            // Ex. http://sp.example.com/
            //     http://example.com/sp/
            'baseurl' =>'https://lsaapp.gww.gov.bc.ca/',
            'security' => array (
                'requestedAuthnContext' => false,
            ),
            // Service Provider Data that we are deploying
            'sp' => array (
                // Identifier of the SP entity  (must be a URI)
                'entityId' => 'urn:ca:bc:gww:lsaapp',
                // Specifies info about where and how the <AuthnResponse> message MUST be
                // returned to the requester, in this case our SP.
                'assertionConsumerService' => array (
                    // URL Location where the <Response> from the IdP will be returned
                    'url' => 'https://lsaapp.gww.gov.bc.ca/',
                    // SAML protocol binding to be used when returning the <Response>
                    // message.  Onelogin Toolkit supports for this endpoint the
                    // HTTP-POST binding only
                    'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
                ),
                // If you need to specify requested attributes, set a
                // attributeConsumingService. nameFormat, attributeValue and
                // friendlyName can be omitted. Otherwise remove this section.
                /*
                "attributeConsumingService"=> array(
                        "serviceName" => "LSA App",
                        "serviceDescription" => "Long Service Awards Registration App",
                        "requestedAttributes" => array(
                            array(
                                "name" => "",
                                "isRequired" => false,
                                "nameFormat" => "",
                                "friendlyName" => "",
                                "attributeValue" => ""
                            )
                        )
                ), */
                // Specifies info about where and how the <Logout Response> message MUST be
                // returned to the requester, in this case our SP.
                'singleLogoutService' => array (
                    // URL Location where the <Response> from the IdP will be returned
                    'url' => 'https://lsaapp.gww.gov.bc.ca/saml/slo',
                    // SAML protocol binding to be used when returning the <Response>
                    // message.  Onelogin Toolkit supports for this endpoint the
                    // HTTP-Redirect binding only
                    'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
                ),
                // Specifies constraints on the name identifier to be used to
                // represent the requested subject.
                // Take a look on lib/Saml2/Constants.php to see the NameIdFormat supported
                'NameIDFormat' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified',

                // Usually x509cert and privateKey of the SP are provided by files placed at
                // the certs folder. But we can also provide them with the following parameters
                'x509cert' => $_ENV['saml-SP-x509'],
                'privateKey' => $_ENV['saml-pk'],

                /*
                 * Key rollover
                 * If you plan to update the SP x509cert and privateKey
                 * you can define here the new x509cert and it will be
                 * published on the SP metadata so Identity Providers can
                 * read them and get ready for rollover.
                 */
                // 'x509certNew' => '',
            ),

            // Identity Provider Data that we want connect with our SP
            'idp' => array (
                // Identifier of the IdP entity  (must be a URI)
                'entityId' => 'urn:ca:bc:gww:lsaapp:sm',
                // SSO endpoint info of the IdP. (Authentication Request protocol)
                'singleSignOnService' => array (
                    // URL Target of the IdP where the SP will send the Authentication Request Message
                    'url' => 'https://sfs7.gov.bc.ca/affwebservices/public/saml2sso?SPID=urn:ca:bc:gww:lsaapp:sm',
                    // SAML protocol binding to be used when returning the <Response>
                    // message.  Onelogin Toolkit supports for this endpoint the
                    // HTTP-Redirect binding only
                    'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
                ),
                // SLO endpoint info of the IdP.
                'singleLogoutService' => array (
                    // URL Location of the IdP where the SP will send the SLO Request
                    'url' => 'https://sfs7.gov.bc.ca/affwebservices/public/saml2sso?SPID=urn:ca:bc:gww:lsaapp:sm',
                    // URL location of the IdP where the SP will send the SLO Response (ResponseLocation)
                    // if not set, url for the SLO Request will be used
                    'responseUrl' => '',
                    // SAML protocol binding to be used when returning the <Response>
                    // message.  Onelogin Toolkit supports for this endpoint the
                    // HTTP-Redirect binding only
                    'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
                ),
                // Public x509 certificate of the IdP
                'x509cert' => $_ENV['saml-IdP-x509'],
                /*
                 *  Instead of use the whole x509cert you can use a fingerprint in
                 *  order to validate the SAMLResponse, but we don't recommend to use
                 *  that method on production since is exploitable by a collision
                 *  attack.
                 *  (openssl x509 -noout -fingerprint -in "idp.crt" to generate it,
                 *   or add for example the -sha256 , -sha384 or -sha512 parameter)
                 *
                 *  If a fingerprint is provided, then the certFingerprintAlgorithm is required in order to
                 *  let the toolkit know which Algorithm was used. Possible values: sha1, sha256, sha384 or sha512
                 *  'sha1' is the default value.
                 */
                // 'certFingerprint' => '',
                // 'certFingerprintAlgorithm' => 'sha1',

                /* In some scenarios the IdP uses different certificates for
                 * signing/encryption, or is under key rollover phase and more
                 * than one certificate is published on IdP metadata.
                 * In order to handle that the toolkit offers that parameter.
                 * (when used, 'x509cert' and 'certFingerprint' values are
                 * ignored).
                 */
                // 'x509certMulti' => array(
                //      'signing' => array(
                //          0 => '<cert1-string>',
                //      ),
                //      'encryption' => array(
                //          0 => '<cert2-string>',
                //      )
                // ),
            ),
        );
    }



}
