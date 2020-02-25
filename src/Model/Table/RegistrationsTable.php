<?php

namespace App\Model\Table;


use Cake\ORM\Table;
use Cake\Validation\Validator;
use phpDocumentor\Reflection\Types\Void_;

class RegistrationsTable extends Table
{
    public function initialize(array $config) : Void
    {
        $this->hasOne('Milestones')
            ->setForeignKey('id')
            ->setBindingKey('milestone_id');
        $this->hasOne('Awards')
            ->setForeignKey('id')
            ->setBindingKey('award_id');
        $this->hasOne('Diet');
        $this->hasOne('Ministries')
            ->setForeignKey('id')
            ->setBindingKey('ministry_id');
        $this->hasOne('Cities');
        $this->hasOne('OfficeCity', ['className' => 'Cities'])
            ->setForeignKey('id')
            ->setBindingKey('office_city_id');
        $this->hasOne('HomeCity', ['className' => 'Cities'])
            ->setForeignKey('id')
            ->setBindingKey('home_city_id');
        $this->hasOne('SupervisorCity', ['className' => 'Cities'])
            ->setForeignKey('id')
            ->setBindingKey('supervisor_city_id');
        $this->hasOne('PecsfRegions');
        $this->hasOne('PecsfCharities');
        $this->hasOne('Ceremonies')
            ->setForeignKey('id')
            ->setBindingKey('ceremony_id');
        $this->hasOne('RegistrationPeriods');
    }


}
