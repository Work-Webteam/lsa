<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class RegistrationPeriods extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
