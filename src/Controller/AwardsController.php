<?php

namespace App\Controller;

use Cake\Core\Configure;

class AwardsController extends AppController
{
    public function index()
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Awards.'));
            $this->redirect('/');
        }
        $this->loadComponent('Paginator');
        $awards = $this->Paginator->paginate($this->Awards->find('all', [
            'conditions' => ['Awards.active =' => 1],
            'contain' => ['Milestones'],
            'order' => ['Milestones.name' => 'ASC', 'Awards.name' => 'ASC'],
        ]));


        $isadmin = $this->checkAuthorization(Configure::read('Role.admin'));
        $this->set(compact('isadmin'));
        $this->set(compact('awards'));
    }

    public function view($id = null)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Awards.'));
            $this->redirect('/');
        }
        $award = $this->Awards->findById($id)->firstOrFail();
        $this->set(compact('award'));

        $options = json_decode($award->options, true);
        $this->set(compact('options'));

        $milestone = $this->Awards->Milestones->findById($award->milestone_id)->firstOrFail();
        $this->set(compact('milestone'));
    }

    public function add()
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Awards.'));
            $this->redirect('/');
        }
        $award = $this->Awards->newEmptyEntity();
        if ($this->request->is('post')) {
            $file = $this->request->getData('upload');
            $award = $this->Awards->patchEntity($award, $this->request->getData());
            if($file->getSize() > 0){
                $fileName = $file->getClientFilename();
                $uploadPath = 'img/awards/';
                $uploadFile = $uploadPath . $fileName;
                $file->moveTo($uploadFile);
                $award->image = $fileName;
            }
            $award->active = true;
            $award->options = json_encode(array());
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
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Awards.'));
            $this->redirect('/');
        }
        $award = $this->Awards->findById($id)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $file = $this->request->getData('upload');
            $award = $this->Awards->patchEntity($award, $this->request->getData());
            if($file->getSize() > 0)
            {
                $fileName = $file->getClientFilename();
                $uploadPath = 'img/awards/';
                $uploadFile = $uploadPath . $fileName;
                $file->moveTo($uploadFile);
                $award->image = $fileName;
            }
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
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Awards.'));
            $this->redirect('/');
        }
        $this->request->allowMethod(['post', 'delete']);

        $award = $this->Awards->findById($id)->firstOrFail();
        if ($this->Awards->delete($award)) {
            $this->Flash->success(__('Award {0} has been deleted.', $award->name));
            return $this->redirect(['action' => 'index']);
        }
    }


    public function addoption($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Awards.'));
            $this->redirect('/');
        }
        $award = $this->Awards->findById($id)->firstOrFail();
        if ($this->request->is('post')) {
            $name = $this->request->getData('name');
            $type = $this->request->getData('type');
            $max = $this->request->getData('maxlength');
            if (!empty($name)) {

                $new = array(
                    'name' => $name,
                    'type' => empty($type) ? 'choice' : $type,
                    'values' => array(),
                );
                if ($type == "text") {
                    $new['maxlength'] = $max;
                }
               $options = json_decode($award->options, true);
               $options[] = $new;
               $award->options = json_encode($options);
            }
            if ($this->Awards->save($award)) {
                $this->Flash->success(__('Option has been saved.'));
                return $this->redirect(['action' => 'view/'.$award->id]);
            }
            $this->Flash->error(__('Unable to add option.'));
        }

        $this->set('award', $award);
    }

    public function editoption($id, $option_id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Awards.'));
            $this->redirect('/');
        }
        $award = $this->Awards->findById($id)->firstOrFail();
        $options = json_decode($award->options, true);

        if ($this->request->is('post')) {
            $options[$option_id]['name'] = $this->request->getData('name');
            if ($options[$option_id]['type'] == "text") {
                $options[$option_id]['maxlength'] = $this->request->getData('maxlength');
            }
            $award->options = json_encode($options);

            if ($this->Awards->save($award)) {
                $this->Flash->success(__('Option has been saved.'));
                return $this->redirect(['action' => 'view/' . $award->id]);
            }
            $this->Flash->error(__('Unable to add option.'));
        }
        $name = $options[$option_id]['name'];
        $type = $options[$option_id]['type'];
        $maxlength = 0;
        if ($type == "text") {
            $maxlength = $options[$option_id]['maxlength'];
        }
        $this->set('name', $name);
        $this->set('type', $type);
        $this->set('maxlength', $maxlength);
        $this->set('award', $award);
    }

    public function deleteoption($id, $option_id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Awards.'));
            $this->redirect('/');
        }
        $this->request->allowMethod(['post', 'delete']);

        $award = $this->Awards->findById($id)->firstOrFail();
        $options = json_decode($award->options, true);
        $name = $options[$option_id]['name'];
        unset($options[$option_id]);
        $award->options = json_encode($options);
        if ($this->Awards->save($award)) {
            $this->Flash->success(__('Award Option {0} has been deleted.', $name));
            return $this->redirect(['action' => 'view/'.$award->id]);
        }
    }


    public function addvalue($id, $option_id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Awards.'));
            $this->redirect('/');
        }
        $award = $this->Awards->findById($id)->firstOrFail();
        if ($this->request->is('post')) {
            $name = $this->request->getData('name');
            if (!empty($name)) {
                $options = json_decode($award->options, true);
                $options[$option_id]['values'][] = $name;
                $award->options = json_encode($options);
            }
            if ($this->Awards->save($award)) {
                $this->Flash->success(__('Option has been saved.'));
                return $this->redirect(['action' => 'view/'.$award->id]);
            }
            $this->Flash->error(__('Unable to add option.'));
        }

        $this->set('award', $award);
    }


    public function editvalue($id, $option_id, $value_id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Awards.'));
            $this->redirect('/');
        }
        $award = $this->Awards->findById($id)->firstOrFail();
        $options = json_decode($award->options, true);
        if ($this->request->is('post')) {
            $options[$option_id]['values'][$value_id] = $this->request->getData('name');
            $award->options = json_encode($options);

            if ($this->Awards->save($award)) {
                $this->Flash->success(__('Option has been saved.'));
                return $this->redirect(['action' => 'view/'.$award->id]);
            }
            $this->Flash->error(__('Unable to add option.'));
        }

        $this->set('name', $options[$option_id]['values'][$value_id]);
        $this->set('award', $award);
    }

    public function deletevalue($id, $option_id, $value_id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer Awards.'));
            $this->redirect('/');
        }
        $this->request->allowMethod(['post', 'delete']);

        $award = $this->Awards->findById($id)->firstOrFail();
        $options = json_decode($award->options, true);
        $name = $options[$option_id]['values'][$value_id];
        unset($options[$option_id]['values'][$value_id]);
        $award->options = json_encode($options);

        if ($this->Awards->save($award)) {
            $this->Flash->success(__('Award Option Value {0} has been deleted.', $name));
            return $this->redirect(['action' => 'view/'.$award->id]);
        }
    }


}
