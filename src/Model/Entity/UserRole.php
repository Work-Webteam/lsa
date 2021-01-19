<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class UserRole extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
