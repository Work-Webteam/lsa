<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Diet extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
