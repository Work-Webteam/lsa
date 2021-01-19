<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class City extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
