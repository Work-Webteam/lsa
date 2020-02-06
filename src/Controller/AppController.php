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

//        $user_role = $this->Userroles->find('all', [
//            'conditions' => ['Userrole.idir =' => 'rkuyvenhoven'],
//        ]);

        $session = $this->getRequest()->getSession();
        $session->write('user.idir', $_SERVER['HTTP_SM_USER']);
        $session->write('user.role', 1);
        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/4/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }
}
