<?php

namespace App\Controller;

use Cake\Core\Configure;

class LogController extends AppController
{
    public function index()
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to view logs.'));
            $this->redirect('/');
        }
        $this->loadComponent('Paginator');
        $logs = $this->Paginator->paginate($this->Log->find());

        $isadmin = $this->checkAuthorization(Configure::read('Role.admin'));
        $this->set(compact('isadmin'));
        $this->set(compact('logs'));
    }

    public function view($id = null)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to view logs.'));
            $this->redirect('/');
        }
        $log = $this->Log->findById($id)->firstOrFail();

        $isadmin = $this->checkAuthorization(Configure::read('Role.admin'));
        $this->set(compact('isadmin'));
        $this->set(compact('log'));
    }

    public function delete($id)
    {
        if (!$this->checkAuthorization(array(Configure::read('Role.admin'), Configure::read('Role.lsa_admin')))) {
            $this->Flash->error(__('You are not authorized to administer logs.'));
            $this->redirect('/');
        }
        $this->request->allowMethod(['post', 'delete']);

        $log = $this->Log->findById($id)->firstOrFail();
        if ($this->Log->delete($log)) {
            $this->Flash->success(__('{0} log has been deleted.', $log->id));
            return $this->redirect(['action' => 'index']);
        }
    }

}

