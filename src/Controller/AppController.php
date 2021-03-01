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
        // check if user has administrative privileges
        $this->loadModel('UserRoles');
        $users = $this->UserRoles->find('all', [
            'conditions' => ['UserRoles.guid =' => $_SERVER['HTTP_SMGOV_USERGUID']],
            'limit' => 1,
        ]);
        $user = $users->first();
        if (!$user) {
            // We check for record with matching IDIR and empty GUID. We need to check empty GUID in case there is an existing
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
            // This is not a known user.
            $session->write('user.role', 0);
            $session->write('user.ministry', 0);
            // Prepare a new user entity.
            $new_user = $this->UserRoles->newEmptyEntity();
            // Populate new user record.
            $new_user->idir = $_SERVER['HTTP_SM_USER'];
            $new_user->guid = $_SERVER['HTTP_SMGOV_USERGUID'];
            // Role 7 is the authenticated role.
            $new_user->role_id = 7;
            // For now we will save this as 1 - but in the future we should check the record
            // vs. the list we have for a match.
            $new_user->ministry_id = 1;
            // Save new user to db.
            $this->UserRoles->save($new_user);
            // This user should be redirected to register, it is the only place for reg auth users.
            $this->redirect("/register");
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
