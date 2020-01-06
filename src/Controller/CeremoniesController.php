<?php

namespace App\Controller;

use Cake\I18n\FrozenDate;

class CeremoniesController extends AppController
{
    public function index()
    {
        $this->loadComponent('Paginator');
        $ceremonies = $this->Paginator->paginate(
            $this->Ceremonies->find('all')
                ->where(['Ceremonies.date >' => strtotime('first day of January ' . date('Y'))])
        );
        $this->set(compact('ceremonies'));
    }

    public function view($id = null)
    {
        $ceremony = $this->Ceremonies->findById($id)->firstOrFail();
        $this->set(compact('ceremony'));
    }

    public function add()
    {
        $ceremony = $this->Ceremonies->newEmptyEntity();
        if ($this->request->is('post')) {
            $ceremony = $this->Ceremonies->patchEntity($ceremony, $this->request->getData());
            $ceremony->date = $this->request->getData('ceremony_date') . " " . $this->request->getData('ceremony_time');
            if ($this->Ceremonies->save($ceremony)) {
                $this->Flash->success(__('Your milestone has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your ceremony.'));
        }
        $this->set('ceremony', $ceremony);
    }

    public function edit($id)
    {
        $ceremony = $this->Ceremonies->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Ceremonies->patchEntity($ceremony, $this->request->getData());
            $ceremony->date = $this->request->getData('ceremony_date') . " " . $this->request->getData('ceremony_time');
            if ($this->Ceremonies->save($ceremony)) {
                $this->Flash->success(__('Milestone has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update milestone.'));
        }

        $this->set('ceremony', $ceremony);
    }


    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $ceremony = $this->Ceremonies->findById($id)->firstOrFail();
        if ($this->Ceremonies->delete($ceremony)) {
            $this->Flash->success(__('Ceremony night {0} has been deleted.', $ceremony->night));
            return $this->redirect(['action' => 'index']);
        }
    }

}

