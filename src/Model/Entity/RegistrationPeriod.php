<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class RegistrationPeriod extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
