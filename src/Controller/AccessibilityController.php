<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Routing\Router;

class AccessibilityController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }


    public function index()
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Accessibility Requirements.'));
            $this->redirect('/');
        }
        $this->loadComponent('Paginator');
        $accessibility = $this->Paginator->paginate($this->Accessibility->find('all', [
               'order' => ['sortorder' => 'ASC',
                           'name' => 'ASC'],
        ]));

        $isadmin = $this->checkAuthorization(Configure::read('Role.admin'));

        $saveurl = Router::url(array('controller'=>'Accessibility','action'=>'saveorder'));
        $this->set(compact('saveurl'));
        $this->set(compact('isadmin'));
        $this->set(compact('accessibility'));
    }

    public function view($id = null)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Accessibility Requirements.'));
            $this->redirect('/');
        }
        $accessibility = $this->Accessibility->findById($id)->firstOrFail();

        $isadmin = $this->checkAuthorization(Configure::read('Role.admin'));
        $this->set(compact('isadmin'));
        $this->set(compact('accessibility'));
    }

    public function add()
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Accessibility Requirements.'));
            $this->redirect('/');
        }
        $accessibility = $this->Accessibility->newEmptyEntity();
        if ($this->request->is('post')) {
            $accessibility = $this->Accessibility->patchEntity($accessibility, $this->request->getData());
            $accessibility->sortorder = 999;
            if ($this->Accessibility->save($accessibility)) {
                $this->Flash->success(__('Accessibility Requirements has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your accessibility requirement.'));
        }
        $this->set('accessibility', $accessibility);
    }

    public function edit($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Accessibility Requirements.'));
            $this->redirect('/');
        }
        $accessibility = $this->Accessibility->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Accessibility->patchEntity($accessibility, $this->request->getData());
            if ($this->Accessibility->save($accessibility)) {
                $this->Flash->success(__('Accessibility Requirement has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update accessibility requirement.'));
        }

        $this->set('accessibility', $accessibility);
    }


    public function delete($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Accessibility Requirements.'));
            $this->redirect('/');
        }
        $this->request->allowMethod(['post', 'delete']);

        $accessibility = $this->Accessibility->findById($id)->firstOrFail();
        if ($this->Accessibility->delete($accessibility)) {
            $this->Flash->success(__('{0} accessibility requirement has been deleted.', $accessibility->name));
            return $this->redirect(['action' => 'index']);
        }
    }


    public function saveorder(){
        if( $this->request->is('ajax') ) {
            $order = $this->request->getData('order');

            $i = 1;
            foreach ($order as $id) {
                $accessibility = $this->Accessibility->findById($id)->firstOrFail();
                $accessibility->sortorder = $i++;
                $this->Accessibility->save($accessibility);
            }
            return;
        }

    }

}

