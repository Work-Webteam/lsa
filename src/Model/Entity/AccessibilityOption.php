<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class AccessibilityOption extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
