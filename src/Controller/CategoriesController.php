<?php

namespace App\Controller;

use Cake\Core\Configure;

class CategoriesController extends AppController
{

    public function index()
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Categories.'));
            $this->redirect('/');
        }
        $this->loadComponent('Paginator');

        $categories = $this->Paginator->paginate($this->Categories->find());

        $isadmin = $this->checkAuthorization(Configure::read('Role.admin'));
        $this->set(compact('isadmin'));
        $this->set(compact('categories'));
    }

    public function view($id = null)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Categories.'));
            $this->redirect('/');
        }
        $categories = $this->Categories->findById($id)->firstOrFail();

        $isadmin = $this->checkAuthorization(Configure::read('Role.admin'));
        $this->set(compact('isadmin'));
        $this->set(compact('categories'));
    }

    public function add()
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Categories.'));
            $this->redirect('/');
        }
        $category = $this->Categories->newEmptyEntity();
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());

            if ($this->Categories->save($category)) {
                $this->Flash->success(__('Your category has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your category.'));
        }
        $this->set('category', $category);
    }

    public function edit($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Categories.'));
            $this->redirect('/');
        }
        $category = $this->Categories->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('Category has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update category.'));
        }

        $this->set('category', $category);
    }

    public function delete($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Categories.'));
            $this->redirect('/');
        }
        $this->request->allowMethod(['post', 'delete']);

        $category = $this->Categories->findById($id)->firstOrFail();
        if ($this->Category->delete($category)) {
            $this->Flash->success(__('{0} has been deleted.', $category->name));
            return $this->redirect(['action' => 'index']);
        }
    }

}

