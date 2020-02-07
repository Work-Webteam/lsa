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
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        $_SERVER['HTTP_SM_USER'] = 'rkuyvenh';
        $_SERVER['HTTP_SMGOV_USEREMAIL'] = 'Raymond.Kuyvenhoven@gov.bc.ca';
        $_SERVER['HTTP_SMGOV_USERDISPLAYNAME'] = 'Kuyvenhoven, Raymond PSA:EX';
        $_SERVER['HTTP_SMGOV_USERGUID'] = '60DCD2AF73FB44AE9345F11B71CD3495';

        $session = $this->getRequest()->getSession();
        $session->write('user.idir', $_SERVER['HTTP_SM_USER']);
        $session->write('user.guid', $_SERVER['HTTP_SMGOV_USERGUID']);
        $session->write('user.name', $_SERVER['HTTP_SMGOV_USERDISPLAYNAME']);
        $session->write('user.email', $_SERVER['HTTP_SMGOV_USEREMAIL']);
        $session->write('user.role', 1);
        $session->write('user.ministry', 2);


        $this->loadModel('Userroles');
        $user_role = $this->Userroles->find('all', ['condition' => ['userrole.id' => 2]])->first();
debug($user_role);
//        $user_role = $this->Userroles->find('all', [
//            'conditions' => array(
//                'Userrole.idir' => 'xxxxxxxxxx'
//            )
//        ])->first();

        debug("we here");
        if ($user_role) {
            debug('we have a user role');
//            debug($user_role->)
            $session->write('user.role', 1);
            $session->write('user.ministry', 2);
        }
        else {
            debug("we don't have a user role");
            $session->write('user.role', 0);
            $session->write('user.ministry', 0);
        }

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/4/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }


    public function checkAuthorization($roles = 1) {
        if (!is_array($roles)) {
            $roles = array($roles);
        }
        $session = $this->getRequest()->getSession();
        if (in_array($session->read('user.role'), $roles)) {
            return true;
        }
        return false;
    }
}
