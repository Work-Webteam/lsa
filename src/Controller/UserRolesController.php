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
        $userroles = $this->Paginator->paginate($this->Userroles->find('all',
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
        $userrole = $this->Userroles->find('all', [
            'conditions' => ['Userroles.id' => $id],
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
        $userrole = $this->Userroles->newEmptyEntity();
        if ($this->request->is('post')) {
            $userrole = $this->Userroles->patchEntity($userrole, $this->request->getData());
            $userrole->idir = strtolower($userrole->idir);
            if($userrole->role_id <> 5) {
                $userrole->ministry_id = 0;
            }

            if ($this->Userroles->save($userrole)) {
                $this->Flash->success(__('Your role has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your role.'));
        }

        $roles = $this->Userroles->Roles->find('list');
        $this->set('roles', $roles);

        $ministries = $this->Userroles->Ministries->find('list', [
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
        $userrole = $this->Userroles->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $userrole = $this->Userroles->patchEntity($userrole, $this->request->getData());
            $userrole->idir = strtolower($userrole->idir);
            if($userrole->role_id <> 5) {
                $userrole->ministry_id = 0;
            }
            if ($this->Userroles->save($userrole)) {
                $this->Flash->success(__('Role has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update role.'));
        }

        if ($this->checkAuthorization(array(Configure::read('Role.admin')))) {
            $roles = $this->Userroles->Roles->find('list');
        }
        else {
            $roles = $this->Userroles->Roles->find('list', [
                'conditions' => ['Roles.id <>' => 1]
            ]);
        }
        $this->set('roles', $roles);

        $ministries = $this->Userroles->Ministries->find('list', [
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

        $userrole = $this->Userroles->findById($id)->firstOrFail();
        if ($this->Userroles->delete($userrole)) {
            $this->Flash->success(__('{0} user role link has been deleted.', $userrole->id));
            return $this->redirect(['action' => 'index']);
        }
    }

}

