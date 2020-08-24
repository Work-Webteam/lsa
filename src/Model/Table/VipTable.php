<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use phpDocumentor\Reflection\Types\Void_;

class VipTable extends Table
{
    public function initialize(array $config) : Void
    {
        $this->hasOne('Cities');
        $this->hasOne('City', ['className' => 'Cities'])
            ->setForeignKey('id')
            ->setBindingKey('city_id');
        $this->hasOne('Ministries')
            ->setForeignKey('id')
            ->setBindingKey('ministry_id');
        $this->hasOne('Ceremonies')
            ->setForeignKey('id')
            ->setBindingKey('ceremony_id');
        $this->hasOne('Categories')
            ->setForeignKey('id')
            ->setBindingKey('category_id');
    }
}
