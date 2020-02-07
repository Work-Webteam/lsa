<?php

namespace App\Controller;

class MilestonesController extends AppController
{
    public function index()
    {
        if (!$this->checkAuthorization(array(1,2))) {
            $this->Flash->error(__('You are not authorized to administer Milestones.'));
            $this->redirect('/');
        }
        $this->loadComponent('Paginator');
        $milestones = $this->Paginator->paginate($this->Milestones->find());
        $this->set(compact('milestones'));
    }

    public function view($id = null)
    {
        if (!$this->checkAuthorization(array(1,2))) {
            $this->Flash->error(__('You are not authorized to administer Milestones.'));
            $this->redirect('/');
        }
        $milestone = $this->Milestones->findById($id)->firstOrFail();
        $this->set(compact('milestone'));
    }

    public function add()
    {
        if (!$this->checkAuthorization(array(1,2))) {
            $this->Flash->error(__('You are not authorized to administer Milestones.'));
            $this->redirect('/');
        }
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
        if (!$this->checkAuthorization(array(1,2))) {
            $this->Flash->error(__('You are not authorized to administer Milestones.'));
            $this->redirect('/');
        }
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
        if (!$this->checkAuthorization(array(1,2))) {
            $this->Flash->error(__('You are not authorized to administer Milestones.'));
            $this->redirect('/');
        }
        $this->request->allowMethod(['post', 'delete']);

        $milestone = $this->Milestones->findById($id)->firstOrFail();
        if ($this->Milestones->delete($milestone)) {
            $this->Flash->success(__('{0} milestone has been deleted.', $milestone->name));
            return $this->redirect(['action' => 'index']);
        }
    }

}

