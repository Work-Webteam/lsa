<?php
// src/Controller/MilestonesController.php

namespace App\Controller;

class MilestonesController extends AppController
{
    public function index()
    {
        $this->loadComponent('Paginator');
        $milestones = $this->Paginator->paginate($this->Milestones->find());
        $this->set(compact('milestones'));
    }

    public function view($id = null)
    {
        $milestone = $this->Milestones->findById($id)->firstOrFail();
        $this->set(compact('milestone'));
    }

    public function add()
    {
        $milestone = $this->Milestones->newEmptyEntity();
        if ($this->request->is('post')) {
            $milestone = $this->Milestones->patchEntity($milestone, $this->request->getData());

            // Hardcoding the user_id is temporary, and will be removed later
            // when we build authentication out.
            $milestone->user_id = 1;

            if ($this->Milestones->save($milestone)) {
                $this->Flash->success(__('Your milestone has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your milestone.'))MilestonesController.php;
        }
        $this->set('milestone', $milestone);
    }

    public function edit($id)
    {
        $milestone = $this->Milestones->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Milestones->patchEntity($milestone, $this->request->getData());
            if ($this->Milestones->save($milestone)) {
                $this->Flash->success(__('Milestone has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update milestone.'));
        }

        $this->set('milestone', $milestone);
    }


    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $milestone = $this->Milestones->findBySlug($id)->firstOrFail();
        if ($this->Milestones->delete($milestone)) {
            $this->Flash->success(__('The {0} article has been deleted.', $milestone->title));
            return $this->redirect(['action' => 'index']);
        }
    }
}

