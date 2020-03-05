<?php

namespace App\Controller;

use Cake\Core\Configure;

class DietController extends AppController
{
    public function index()
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Diets.'));
            $this->redirect('/');
        }
        $this->loadComponent('Paginator');
        $diets = $this->Paginator->paginate($this->Diet->find());

        $isadmin = $this->checkAuthorization(Configure::read('Role.admin'));
        $this->set(compact('isadmin'));
        $this->set(compact('diets'));
    }

    public function view($id = null)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Diets.'));
            $this->redirect('/');
        }
        $diet = $this->Diet->findById($id)->firstOrFail();

        $isadmin = $this->checkAuthorization(Configure::read('Role.admin'));
        $this->set(compact('isadmin'));
        $this->set(compact('diet'));
    }

    public function add()
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Diets.'));
            $this->redirect('/');
        }
        $diet = $this->Diet->newEmptyEntity();
        if ($this->request->is('post')) {
            $diet = $this->Diet->patchEntity($diet, $this->request->getData());

            if ($this->Diet->save($diet)) {
                $this->Flash->success(__('Your diet has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your diet.'));
        }
        $this->set('diet', $diet);
    }

    public function edit($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Diets.'));
            $this->redirect('/');
        }
        $diet = $this->Diet->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Diet->patchEntity($diet, $this->request->getData());
            if ($this->Diet->save($diet)) {
                $this->Flash->success(__('Diet has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update diet.'));
        }

        $this->set('diet', $diet);
    }


    public function delete($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Diets.'));
            $this->redirect('/');
        }
        $this->request->allowMethod(['post', 'delete']);

        $diet = $this->Diet->findById($id)->firstOrFail();
        if ($this->Diet->delete($diet)) {
            $this->Flash->success(__('{0} diet has been deleted.', $diet->name));
            return $this->redirect(['action' => 'index']);
        }
    }

}

