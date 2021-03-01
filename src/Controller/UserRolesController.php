<?php

namespace App\Controller;

use Cake\Core\Configure;

class UserRolesController extends AppController
{

    public function index()
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer User Roles.'));
            $this->redirect('/');
        }
        $this->loadComponent('Paginator');
        $userroles = $this->Paginator->paginate($this->UserRoles->find('all',
            ['contain' => [
                'Roles',
                'Ministries',
            ]]));

        $isadmin = $this->checkAuthorization(Configure::read('Role.admin'));
        $this->set(compact('isadmin'));
        $this->set(compact('userroles'));
    }

    public function view($id = null)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer User Roles.'));
            $this->redirect('/');
        }
        $userrole = $this->UserRoles->find('all', [
            'conditions' => ['UserRoles.id' => $id],
            'contain' => [
                'Roles',
                'Ministries',
            ]
        ])->firstOrFail();

        $isadmin = $this->checkAuthorization(Configure::read('Role.admin'));
        $this->set(compact('isadmin'));
        $this->set(compact('userrole'));
    }

    public function add()
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer User Roles.'));
            $this->redirect('/');
        }
        $userrole = $this->UserRoles->newEmptyEntity();
        if ($this->request->is('post')) {
            $userrole = $this->UserRoles->patchEntity($userrole, $this->request->getData());
            $userrole->idir = strtolower($userrole->idir);
            if($userrole->role_id <> 5) {
                $userrole->ministry_id = 0;
            }

            if ($this->UserRoles->save($userrole)) {
                $this->Flash->success(__('Your role has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your role.'));
        }

        $roles = $this->UserRoles->Roles->find('list');
        $this->set('roles', $roles);

        $ministries = $this->UserRoles->Ministries->find('list', [
            'order' => ['Ministries.name' => 'ASC']
        ]);
        $this->set('ministries', $ministries);

        $this->set('userrole', $userrole);
    }

    public function edit($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer User Roles.'));
            $this->redirect('/');
        }
        $userrole = $this->UserRoles->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $userrole = $this->UserRoles->patchEntity($userrole, $this->request->getData());
            $userrole->idir = strtolower($userrole->idir);
            if($userrole->role_id <> 5) {
                $userrole->ministry_id = 0;
            }
            if ($this->UserRoles->save($userrole)) {
                $this->Flash->success(__('Role has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update role.'));
        }

        if ($this->checkAuthorization(array(Configure::read('Role.admin')))) {
            $roles = $this->UserRoles->Roles->find('list');
        }
        else {
            $roles = $this->UserRoles->Roles->find('list', [
                'conditions' => ['Roles.id <>' => 1]
            ]);
        }
        $this->set('roles', $roles);

        $ministries = $this->UserRoles->Ministries->find('list', [
            'order' => ['Ministries.name' => 'ASC']
        ]);
        $this->set('ministries', $ministries);

        $this->set('userrole', $userrole);
    }


    public function info() {

    }

    public function delete($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer User Roles.'));
            $this->redirect('/');
        }
        $this->request->allowMethod(['post', 'delete']);

        $userrole = $this->UserRoles->findById($id)->firstOrFail();
        if ($this->UserRoles->delete($userrole)) {
            $this->Flash->success(__('{0} user role link has been deleted.', $userrole->id));
            return $this->redirect(['action' => 'index']);
        }
    }

}

