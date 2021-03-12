<?php

namespace App\Controller;

use Cake\Core\Configure;

use Onelogin\SAML\Authenticator;

class SamlController extends AppController
{
    private $auth = null;

    public function index() {

    }
    private function initSAML() {
        $this->loadSettings();
        $this->loadToolkit();
    }

    public function sso() {
        $this->initSAML();
        $auth = new \OneLogin_Saml2_Auth($this->settings);
        $auth->login();
    }

    public function acs() {
        $this->initSAML();
        $auth = new \OneLogin_Saml2_Auth($this->settings);

        $auth->processResponse();

        //If there are errors, display them then exit.
        $errors = $auth->getErrors();
        if (!empty($errors)) {
            echo '<p>',implode(', ', $errors),'</p>';
            if ($auth->getSettings()->isDebugActive()) {
                echo '<p>'.$auth->getLastErrorReason().'</p>';
            }
            exit();
        }
        //If the person is not authenticated push them back to the
        //login form.
        if (!$auth->isAuthenticated()) {
            $auth->redirectTo(('https://lsapp.gww.gov.bc.ca'));
            exit();
        };

        $session = $this->request->getSession();
        $session->write('samlUserdata', $this->auth->getAttributes());
        $session->write('samlNameId', $this->auth->getNameId());
        $session->write('samlNameIdFormat', $this->auth->getNameIdFormat());
        $session->write('samlNameIdNameQualifier', $this->auth->getNameIdNameQualifier());
        $session->write('samlNameIdSPNameQualifier', $this->auth->getNameIdSPNameQualifier());
        $session->write('samlSessionIndex', $this->auth->getSessionIndex());

        return $this->redirect('/register');
    }

    public function slo() {
        $this->initSAML();
        $auth = new \OneLogin_Saml2_Auth($this->settings);
        $auth->logout();
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
                'baseurl' =>'',

                // Service Provider Data that we are deploying
                'sp' => array (
                    // Identifier of the SP entity  (must be a URI)
                    'entityId' => 'urn:ca:bc:gww:lsaapp',
                    // Specifies info about where and how the <AuthnResponse> message MUST be
                    // returned to the requester, in this case our SP.
                    'assertionConsumerService' => array (
                        // URL Location where the <Response> from the IdP will be returned
                        'url' => 'https://lsaapp.gww.gov.bc.ca/saml/acs',
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
