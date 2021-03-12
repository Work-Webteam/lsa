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
        $this->hasOne('AccessibilityOptions');
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
        $this->hasOne('PecsfRegions')
            ->setForeignKey('id')
            ->setBindingKey('pecsf_region_id');
        $this->hasOne('PecsfCharities');
        $this->hasOne('PecsfCharities1', [
            'className' => 'PecsfCharities'
            ])
            ->setForeignKey('id')
            ->setBindingKey('pecsf_charity1_id');
        $this->hasOne('PecsfCharities2', [
            'className' => 'PecsfCharities'
            ])
            ->setForeignKey('id')
            ->setBindingKey('pecsf_charity2_id');
        $this->hasOne('Ceremonies')
            ->setForeignKey('id')
            ->setBindingKey('ceremony_id');
        $this->hasOne('RegistrationPeriods')
            ->setForeignKey('id')
            ->setBindingKey('registration_year');
        $this->hasMany('Log')
            ->setForeignKey('registration_id')
            ->setBindingKey('id');
    }


}
