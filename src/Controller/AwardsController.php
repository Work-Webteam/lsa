<?php
// src/Controller/AwardsController.php

namespace App\Controller;

class AwardsController extends AppController
{
    public function index()
    {
        $this->loadComponent('Paginator');
        $awards = $this->Paginator->paginate($this->Awards->find());
        $this->set(compact('awards'));
    }
}
