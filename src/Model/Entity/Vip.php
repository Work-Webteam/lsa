<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Vip extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
