<?php
// src/Controller/MilestonesController.php

namespace App\Controller;

class MinistriesController extends AppController
{
    public function index()
    {
        $this->loadComponent('Paginator');
        $ministries = $this->Paginator->paginate($this->Ministries->find());
        $this->set(compact('ministries'));
    }

    public function view($id = null)
    {
        $ministry = $this->Ministries->findById($id)->firstOrFail();
        $this->set(compact('ministry'));
    }

    public function add()
    {
        $ministry = $this->Ministries->newEmptyEntity();
        if ($this->request->is('post')) {
            $ministry = $this->Ministries->patchEntity($ministry, $this->request->getData());

            if ($this->Ministries->save($ministry)) {
                $this->Flash->success(__('Your milestone has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your milestone.'));
        }
        $this->set('ministry', $ministry);
    }

    public function edit($id)
    {
        $ministry = $this->Ministries->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Ministries->patchEntity($ministry, $this->request->getData());
            if ($this->Ministries->save($ministry)) {
                $this->Flash->success(__('Milestone has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update milestone.'));
        }

        $this->set('ministry', $ministry);
    }


    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $ministry = $this->Ministries->findById($id)->firstOrFail();
        if ($this->Ministries->delete($ministry)) {
            $this->Flash->success(__('{0} has been deleted.', $ministry->name));
            return $this->redirect(['action' => 'index']);
        }
    }

}

