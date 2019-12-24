<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Ceremonies extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
