<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class PecsfRegions extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
