<?php

namespace App\Controller;

use Cake\I18n\FrozenDate;

class CeremoniesController extends AppController
{
    public function index()
    {
        if (!$this->checkAuthorization(array(1,2))) {
            $this->Flash->error(__('You are not authorized to administer Ceremonies.'));
            $this->redirect('/');
        }
        $this->loadComponent('Paginator');
        $ceremonies = $this->Paginator->paginate($this->Ceremonies->find('all', [
            'conditions' => ['Ceremonies.award_year =' => date('Y')],
        ]));

        $this->set(compact('ceremonies'));
    }

    public function view($id = null)
    {
        if (!$this->checkAuthorization(array(1,2))) {
            $this->Flash->error(__('You are not authorized to administer Ceremonies.'));
            $this->redirect('/');
        }
        $ceremony = $this->Ceremonies->findById($id)->firstOrFail();
        $this->set(compact('ceremony'));
    }

    public function add()
    {
        if (!$this->checkAuthorization(array(1,2))) {
            $this->Flash->error(__('You are not authorized to administer Ceremonies.'));
            $this->redirect('/');
        }
        $ceremony = $this->Ceremonies->newEmptyEntity();
        if ($this->request->is('post')) {
            $ceremony = $this->Ceremonies->patchEntity($ceremony, $this->request->getData());
            $ceremony->award_year = date("Y");
            $ceremony->date = $this->request->getData('ceremony_date') . " " . $this->request->getData('ceremony_time');
            if ($this->Ceremonies->save($ceremony)) {
                $this->Flash->success(__('Your ceremony has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your ceremony.'));
        }
        $ceremony->award_year = date("Y");
        $this->set('ceremony', $ceremony);
    }

    public function edit($id)
    {
        if (!$this->checkAuthorization(array(1,2))) {
            $this->Flash->error(__('You are not authorized to administer Ceremonies.'));
            $this->redirect('/');
        }
        $ceremony = $this->Ceremonies->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Ceremonies->patchEntity($ceremony, $this->request->getData());
            $ceremony->date = $this->request->getData('ceremony_date') . " " . $this->request->getData('ceremony_time');
            if ($this->Ceremonies->save($ceremony)) {
                $this->Flash->success(__('Ceremony has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update ceremony.'));
        }

        $this->set('ceremony', $ceremony);
    }


    public function delete($id)
    {
        if (!$this->checkAuthorization(array(1,2))) {
            $this->Flash->error(__('You are not authorized to administer Ceremonies.'));
            $this->redirect('/');
        }
        $this->request->allowMethod(['post', 'delete']);

        $ceremony = $this->Ceremonies->findById($id)->firstOrFail();
        if ($this->Ceremonies->delete($ceremony)) {
            $this->Flash->success(__('Ceremony night {0} has been deleted.', $ceremony->night));
            return $this->redirect(['action' => 'index']);
        }
    }

}

