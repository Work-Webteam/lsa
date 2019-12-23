<?php

namespace App\Controller;

class CitiesController extends AppController
{
    public function index()
    {
        $this->loadComponent('Paginator');
        $cities = $this->Paginator->paginate($this->Cities->find());
        $this->set(compact('cities'));
    }

    public function view($id = null)
    {
        $city = $this->Cities->findById($id)->firstOrFail();
        $this->set(compact('city'));
    }

    public function add()
    {
        $city = $this->Cities->newEmptyEntity();
        if ($this->request->is('post')) {
            $milestone = $this->Cities->patchEntity($city, $this->request->getData());

            if ($this->Cities->save($city)) {
                $this->Flash->success(__('Your city has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your city.'));
        }
        $this->set('city', $city);
    }

    public function edit($id)
    {
        $city = $this->Cities->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Cities->patchEntity($city, $this->request->getData());
            if ($this->Cities->save($city)) {
                $this->Flash->success(__('Milestone has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update milestone.'));
        }

        $this->set('city', $city);
    }

    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $city = $this->Cities->findById($id)->firstOrFail();
        if ($this->Cities->delete($city)) {
            $this->Flash->success(__('{0} has been deleted.', $city->name));
            return $this->redirect(['action' => 'index']);
        }
    }

}

