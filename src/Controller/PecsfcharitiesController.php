<?php

namespace App\Controller;

use Cake\Core\Configure;

class PecsfcharitiesController extends AppController
{
    public function index()
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin')))) {
            $this->Flash->error(__('You are not authorized to administer PECSF Charities.'));
            $this->redirect('/');
        }
        $this->loadComponent('Paginator');
        $charities = $this->Paginator->paginate($this->Pecsfcharities->find('all', [
                'contain' => ['Pecsfregions']
            ]));

        $isadmin = $this->checkAuthorization(Configure::read('Role.admin'));
        $this->set(compact('isadmin'));
        $this->set(compact('charities'));
    }

    public function view($id = null)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin')))) {
            $this->Flash->error(__('You are not authorized to administer PECSF Charities.'));
            $this->redirect('/');
        }
        $charity = $this->Pecsfcharities->find('all', [
            'conditions' => ['Pecsfcharities.id' => $id],
            'contain' => ['Pecsfregions']
        ])->firstOrFail();

        $isadmin = $this->checkAuthorization(Configure::read('Role.admin'));
        $this->set(compact('isadmin'));
        $this->set(compact('charity'));
    }

    public function add()
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin')))) {
            $this->Flash->error(__('You are not authorized to administer PECSF Charities.'));
            $this->redirect('/');
        }
        $charity = $this->Pecsfcharities->newEmptyEntity();
        if ($this->request->is('post')) {
            $charity = $this->Pecsfcharities->patchEntity($charity, $this->request->getData());

            if ($this->Pecsfcharities->save($charity)) {
                $this->Flash->success(__('PECSF charity has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add PECSF charity.'));
        }

        // Get a list of pecsf regions.
        $regions = $this->Pecsfcharities->Pecsfregions->find('list');
        // Set pecsf regions to the view context
        $this->set('regions', $regions);

        $this->set('charity', $charity);
    }

    public function edit($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin')))) {
            $this->Flash->error(__('You are not authorized to administer PECSF Charities.'));
            $this->redirect('/');
        }
        $charity = $this->Pecsfcharities->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Pecsfcharities->patchEntity($charity, $this->request->getData());
            if ($this->Pecsfcharities->save($charity)) {
                $this->Flash->success(__('PECSF charity has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update PECSF charity.'));
        }

        // Get a list of pecsf regions.
        $regions = $this->Pecsfcharities->Pecsfregions->find('list');
        // Set pecsf regions to the view context
        $this->set('regions', $regions);

        $this->set('charity', $charity);
    }


    public function delete($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin')))) {
            $this->Flash->error(__('You are not authorized to administer PECSF Charities.'));
            $this->redirect('/');
        }
        $this->request->allowMethod(['post', 'delete']);

        $charity = $this->Pecsfcharities->findById($id)->firstOrFail();
        if ($this->Pecsfcharities->delete($charity)) {
            $this->Flash->success(__('{0} PECSF charity has been deleted.', $charity->name));
            return $this->redirect(['action' => 'index']);
        }
    }

}

