<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class RolesUser extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
