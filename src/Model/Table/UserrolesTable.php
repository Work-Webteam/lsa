<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use phpDocumentor\Reflection\Types\Void_;

class UserrolesTable extends Table
{
    public function initialize(array $config) : Void
    {
        $this->hasOne('Roles')
            ->setForeignKey('id')
            ->setBindingKey('role_id');
        $this->hasOne('Ministries')
            ->setForeignKey('id')
            ->setBindingKey('ministry_id');

    }
}
