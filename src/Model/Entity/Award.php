<?php
// src/Model/entity/Awards.php
namespace App\Model\Entity;

use Cake\ORM\Entity;
class Award extends Entity
{
 protected $_accessible = [
     'id' => false,
     '*' => true
 ];
}
