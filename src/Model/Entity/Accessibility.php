<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Accessibility extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
