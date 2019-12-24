<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class UserRoles extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
