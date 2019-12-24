<?php

namespace App\Controller;

class UserRolesController extends AppController
{
    public function index()
    {
        $this->loadComponent('Paginator');
        $userroles = $this->Paginator->paginate($this->Userroles->find());
        $this->set(compact('userroles'));
    }

    public function view($id = null)
    {
        $userrole = $this->Userroles->findById($id)->firstOrFail();
        $this->set(compact('userrole'));
    }

    public function add()
    {
        $userrole = $this->Userroles->newEmptyEntity();
        if ($this->request->is('post')) {
            $userrole = $this->Userroles->patchEntity($userrole, $this->request->getData());

            if ($this->Userroles->save($userrole)) {
                $this->Flash->success(__('Your role has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your role.'));
        }

        // Get a list of roles.
        $roles = $this->Userroles->Roles->find('list');
        // Set tags to the view context
        $this->set('roles', $roles);

        $this->set('userrole', $userrole);
    }

    public function edit($id)
    {
        $userrole = $this->Userroles->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Userroles->patchEntity($userrole, $this->request->getData());
            if ($this->Userroles->save($userrole)) {
                $this->Flash->success(__('Role has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update role.'));
        }

        // Get a list of roles.
        $roles = $this->Userroles->Roles->find('list');
        // Set tags to the view context
        $this->set('roles', $roles);

        $this->set('userrole', $userrole);
    }


    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $userrole = $this->Userroles->findById($id)->firstOrFail();
        if ($this->Userroles->delete($userrole)) {
            $this->Flash->success(__('{0} user role link has been deleted.', $userrole->id));
            return $this->redirect(['action' => 'index']);
        }
    }

}

