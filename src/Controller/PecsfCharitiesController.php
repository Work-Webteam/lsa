<?php

namespace App\Controller;

class PecsfCharitiesController extends AppController
{
    public function index()
    {
        $this->loadComponent('Paginator');
        $charities = $this->Paginator->paginate($this->Pecsfcharities->find());
        $this->set(compact('charities'));
    }

    public function view($id = null)
    {
        $charity = $this->Pecsfcharities->findById($id)->firstOrFail();
        $this->set(compact('charity'));
    }

    public function add()
    {
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
        $this->request->allowMethod(['post', 'delete']);

        $charity = $this->Pecsfcharities->findById($id)->firstOrFail();
        if ($this->Pecsfcharities->delete($charity)) {
            $this->Flash->success(__('{0} PECSF charity has been deleted.', $charity->name));
            return $this->redirect(['action' => 'index']);
        }
    }

}

