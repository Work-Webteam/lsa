<?php

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

            if ($this->Milestones->save($milestone)) {
                $this->Flash->success(__('Your milestone has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your milestone.'));
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

        $milestone = $this->Milestones->findById($id)->firstOrFail();
        if ($this->Milestones->delete($milestone)) {
            $this->Flash->success(__('{0} milestone has been deleted.', $milestone->name));
            return $this->redirect(['action' => 'index']);
        }
    }

}

