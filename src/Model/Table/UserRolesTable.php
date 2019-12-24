<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use phpDocumentor\Reflection\Types\Void_;

class UserRolesTable extends Table
{
    public function initialize(array $config) : Void
    {
        $this->hasOne('Roles');
    }
}
