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
        var_dump($_SERVER);

        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
       //$_SERVER['HTTP_SM_USER'] = 'rkuyvenh';
       //$_SERVER['HTTP_SMGOV_USEREMAIL'] = 'Raymond.Kuyvenhoven@gov.bc.ca';
       //$_SERVER['HTTP_SMGOV_USERDISPLAYNAME'] = 'Kuyvenhoven, Raymond PSA:EX';
       //$_SERVER['HTTP_SMGOV_USERGUID'] = '60DCD2AF73FB44AE9345F11B71CD3495';   // admin

//        $_SERVER['HTTP_SMGOV_USERGUID'] = '9ECC7D7FD8EE840932B9D21721251737';   // lsa admin

//        $_SERVER['HTTP_SMGOV_USERGUID'] = '8A5BD27856273A99C6D5AF1FCDDBCB99';   // award procurement

//        $_SERVER['HTTP_SM_USER'] = 'jadams';
//        $_SERVER['HTTP_SMGOV_USERGUID'] = '26B243BA60AE8F60B4BB3C81E1450423';   // ministry contact

//        $_SERVER['HTTP_SM_USER'] = 'kblack';
//        $_SERVER['HTTP_SMGOV_USERGUID'] = '5F4CF1B88565FCA2E8D17AD85B57CE0A';   // supervisor
//
//        $_SERVER['HTTP_SM_USER'] = 'asmith';
//        $_SERVER['HTTP_SMGOV_USERGUID'] = 'C68FF67FB334907A25DB8B07767CC1FC';   // protocol
//
//        $_SERVER['HTTP_SM_USER'] = 'rsharples';
//        $_SERVER['HTTP_SMGOV_USERGUID'] = '3BC010F8C876571F3D29DB46012A326B';   // recipient
//
        // check if user has administrative privileges
        $this->loadModel('UserRoles');
        $users = $this->UserRoles->find('all', [
            'conditions' => ['UserRoles.guid =' => $_SERVER['HTTP_SMGOV_USERGUID']],
            'limit' => 1,
        ]);
        $user = $users->first();
        if (!$user) {
            // we check for record with matching IDIR and empty GUID. We need to check empty GUID in case there is an existing
            // matching IDIR with a different GUID.
            $users = $this->UserRoles->find('all', [
                'conditions' => [
                    'UserRoles.idir =' => $_SERVER['HTTP_SM_USER'],
                    'UserRoles.guid =' => '',
                    ],
                'limit' => 1,
            ]);
            $user = $users->first();
            if ($user) {
                $user->guid = $_SERVER['HTTP_SMGOV_USERGUID'];
                $this->UserRoles->save($user);
            }
        }

        $session = $this->getRequest()->getSession();
        $session->write('user.idir', $_SERVER['HTTP_SM_USER']);
        $session->write('user.guid', $_SERVER['HTTP_SMGOV_USERGUID']);
        $session->write('user.name', $_SERVER['HTTP_SMGOV_USERDISPLAYNAME']);
        $session->write('user.email', $_SERVER['HTTP_SMGOV_USEREMAIL']);

        if ($user) {
            $session->write('user.role', $user->role_id);
            $session->write('user.ministry', $user->ministry_id);
        }
        else {
            $session->write('user.role', 0);
            $session->write('user.ministry', 0);
        }

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/4/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
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

}
