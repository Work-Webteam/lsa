<?php

namespace App\Controller;

class AwardsController extends AppController
{
    public function index()
    {
        $this->loadComponent('Paginator');
        $awards = $this->Paginator->paginate($this->Awards->find());
        $this->set(compact('awards'));
    }

    public function view($id = null)
    {
        $award = $this->Awards->findById($id)->firstOrFail();
        $this->set(compact('award'));
    }

    public function add()
    {
        $award = $this->Awards->newEmptyEntity();
        if ($this->request->is('post')) {
            $filename = "";
            $file = $this->request->getData('upload');
            if(!empty($file)){
                $fileName = $file->getClientFilename();
                $uploadPath = 'img/awards/';
                $uploadFile = $uploadPath . $fileName;
                $file->moveTo($uploadFile);
            }
            $award = $this->Awards->patchEntity($award, $this->request->getData());
            $award->image = $fileName;
            $award->active = true;
            if ($this->Awards->save($award)) {
                $this->Flash->success(__('Award has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add award.' . $msg . ' - ' . $file->getClientFilename()));
        }

        // Get a list of milestones.
        $milestones = $this->Awards->Milestones->find('list');
        // Set tags to the view context
        $this->set('milestones', $milestones);

        $this->set('award', $award);
    }

    public function edit($id)
    {
        $award = $this->Awards->findById($id)->firstOrFail();
        $image = $award->image;
        if ($this->request->is(['post', 'put'])) {
            $this->Awards->patchEntity($award, $this->request->getData());
            if ($this->Awards->save($award)) {
                $this->Flash->success(__('Award has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update award.'));
        }

        // Get a list of milestones.
        $milestones = $this->Awards->Milestones->find('list');

        // Set tags to the view context
        $this->set('milestones', $milestones);

        $this->set('award', $award);
    }


    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $award = $this->Awards->findById($id)->firstOrFail();
        if ($this->Awards->delete($award)) {
            $this->Flash->success(__('Award {0} has been deleted.', $award->name));
            return $this->redirect(['action' => 'index']);
        }
    }

}
