<?php
// src/Model/entity/Awards.php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Files extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
