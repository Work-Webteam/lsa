<?php

namespace App\Controller;

use Cake\Core\Configure;

class PecsfRegionsController extends AppController
{
    public function index()
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin')))) {
            $this->Flash->error(__('You are not authorized to administer PECSF Regions.'));
            $this->redirect('/');
        }
        $this->loadComponent('Paginator');
        $pecsfregions = $this->Paginator->paginate($this->PecsfRegions->find());

        $isadmin = $this->checkAuthorization(Configure::read('Role.admin'));
        $this->set(compact('isadmin'));
        $this->set(compact('pecsfregions'));
    }

    public function view($id = null)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin')))) {
            $this->Flash->error(__('You are not authorized to administer PECSF Regions.'));
            $this->redirect('/');
        }
        $region = $this->PecsfRegions->findById($id)->firstOrFail();

        $isadmin = $this->checkAuthorization(Configure::read('Role.admin'));
        $this->set(compact('isadmin'));
        $this->set(compact('region'));
    }

    public function add()
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin')))) {
            $this->Flash->error(__('You are not authorized to administer PECSF Regions.'));
            $this->redirect('/');
        }
        $region = $this->PecsfRegions->newEmptyEntity();
        if ($this->request->is('post')) {
            $region = $this->PecsfRegions->patchEntity($region, $this->request->getData());

            if ($this->PecsfRegions->save($region)) {
                $this->Flash->success(__('PECSF region has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add PECSF region.'));
        }
        $this->set('region', $region);
    }

    public function edit($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin')))) {
            $this->Flash->error(__('You are not authorized to administer PECSF Regions.'));
            $this->redirect('/');
        }
        $region = $this->PecsfRegions->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->PecsfRegions->patchEntity($region, $this->request->getData());
            if ($this->PecsfRegions->save($region)) {
                $this->Flash->success(__('PECSF region has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update PECSF region.'));
        }

        $this->set('region', $region);
    }


    public function delete($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin')))) {
            $this->Flash->error(__('You are not authorized to administer PECSF Regions.'));
            $this->redirect('/');
        }
        $this->request->allowMethod(['post', 'delete']);

        $region = $this->PecsfRegions->findById($id)->firstOrFail();
        if ($this->PecsfRegions->delete($region)) {
            $this->Flash->success(__('{0} PECSF region has been deleted.', $region->name));
            return $this->redirect(['action' => 'index']);
        }
    }

}

