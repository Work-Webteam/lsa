<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use phpDocumentor\Reflection\Types\Void_;

class PecsfcharitiesTable extends Table
{
    public function initialize(array $config) : Void
    {
        $this->hasOne('Pecsfregions')
        ->setForeignKey('id')
        ->setBindingKey('pecsf_region_id');
    }
}
