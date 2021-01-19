<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Milestone extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
