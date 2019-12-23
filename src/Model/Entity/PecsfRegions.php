<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class PecsfRegion extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
