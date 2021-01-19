<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Ceremony extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
