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
            $this->Flash->error(__('Unable to add your milestone.'));
        }
        $this->set('milestone', $milestone);
    }


}

