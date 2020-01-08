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

        $options = unserialize($award->options);
        $this->set(compact('options'));

        $milestone = $this->Awards->Milestones->findById($award->milestone_id)->firstOrFail();
        $this->set(compact('milestone'));
    }

    public function add()
    {
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
            $award->options = serialize(array());
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
        $this->request->allowMethod(['post', 'delete']);

        $award = $this->Awards->findById($id)->firstOrFail();
        if ($this->Awards->delete($award)) {
            $this->Flash->success(__('Award {0} has been deleted.', $award->name));
            return $this->redirect(['action' => 'index']);
        }
    }


    public function addoption($id)
    {
        $award = $this->Awards->findById($id)->firstOrFail();
        if ($this->request->is('post')) {
            $name = $this->request->getData('name');
            $type = $this->request->getData('type');
            if (!empty($name)) {
                $new = array(
                    'name' => $name,
                    'type' => empty($type) ? 'choice' : $type,
                    'values' => array()
                );
               $options = unserialize($award->options);
               $options[] = $new;
               $award->options = serialize($options);
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
        $award = $this->Awards->findById($id)->firstOrFail();
        $options = unserialize($award->options);

        if ($this->request->is('post')) {
            $options[$option_id]['name'] = $this->request->getData('name');
            $award->options = serialize($options);

            if ($this->Awards->save($award)) {
                $this->Flash->success(__('Option has been saved.'));
                return $this->redirect(['action' => 'view/'.$award->id]);
            }
            $this->Flash->error(__('Unable to add option.'));
        }
        $name = $options[$option_id]['name'];
        $type = $options[$option_id]['type'];
        $this->set('name', $name);
        $this->set('type', $type);
        $this->set('award', $award);
    }

    public function deleteoption($id, $option_id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $award = $this->Awards->findById($id)->firstOrFail();
        $options = unserialize($award->options);
        $name = $options[$option_id]['name'];
        unset($options[$option_id]);
        $award->options = serialize($options);
        if ($this->Awards->save($award)) {
            $this->Flash->success(__('Award Option {0} has been deleted.', $name));
            return $this->redirect(['action' => 'view/'.$award->id]);
        }
    }


    public function addvalue($id, $option_id)
    {
        $award = $this->Awards->findById($id)->firstOrFail();
        if ($this->request->is('post')) {
            $name = $this->request->getData('name');
            if (!empty($name)) {
                $options = unserialize($award->options);
                $options[$option_id]['values'][] = $name;
                $award->options = serialize($options);
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
        $award = $this->Awards->findById($id)->firstOrFail();
        $options = unserialize($award->options);
        if ($this->request->is('post')) {
            $options[$option_id]['values'][$value_id] = $this->request->getData('name');
            $award->options = serialize($options);

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
        $this->request->allowMethod(['post', 'delete']);

        $award = $this->Awards->findById($id)->firstOrFail();
        $options = unserialize($award->options);
        $name = $options[$option_id]['values'][$value_id];
        unset($options[$option_id]['values'][$value_id]);
        $award->options = serialize($options);

        if ($this->Awards->save($award)) {
            $this->Flash->success(__('Award Option Value {0} has been deleted.', $name));
            return $this->redirect(['action' => 'view/'.$award->id]);
        }
    }


}
