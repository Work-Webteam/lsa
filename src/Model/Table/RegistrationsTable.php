<?php

namespace App\Model\Table;


use Cake\ORM\Table;
use Cake\Validation\Validator;
use phpDocumentor\Reflection\Types\Void_;

class RegistrationsTable extends Table
{
    public function initialize(array $config) : Void
    {
        $this->hasOne('Milestones');
        $this->hasOne('Awards');
        $this->hasOne('Diet');
        $this->hasOne('Ministries');
        $this->hasOne('Cities');
    }

    public function validationDefault(Validator $validator) : Validator
    {
//        // add the provider to the validator
//        $validator->setProvider('en', 'Localized\Validation\EnValidation');
//        $validator->add('home_phone', 'myCustomRuleNameForPhone', [
//            'rule' => 'phone',
//            'provider' => 'en'
//        ]);
//        $validator->add('home_phone', 'phone');


        $validator->requirePresence('preferred_email');
        $validator->add('preferred_email', 'validFormat', [
            'rule' => 'email',
            'message' => 'E-mail must be valid'
        ]);

        $validator->allowEmptyString('alternate_email');
        $validator->add('alternate_email', 'validFormat', [
            'rule' => 'email',
            'message' => 'E-mail must be valid'
        ]);

        $validator->requirePresence('milestone_id');
        $validator->add('milestone_id', 'not-blank', [
            'rule' => 'notBlank',
            'message' => 'Please select a milestone.'
        ]);

        $validator->requirePresence('award_id');
        $validator->add('award_id', 'not-blank', [
            'rule' => 'notBlank',
            'message' => 'Please select an award.'
        ]);

        $validator->requirePresence('employee_id');
        $validator->add('employee_id', 'not-blank', [
            'rule' => 'notBlank',
            'message' => 'Please enter your employee id.'
        ]);

        $validator->requirePresence('first_name');
        $validator->add('first_name', 'not-blank', [
            'rule' => 'notBlank',
            'message' => 'Please enter your first name.'
        ]);

        $validator->requirePresence('last_name');
        $validator->add('last_name', 'not-blank', [
            'rule' => 'notBlank',
            'message' => 'Please enter you last name.'
        ]);

        $validator->requirePresence('ministry_id');
        $validator->add('ministry_id', 'not-blank', [
            'rule' => 'notBlank',
            'message' => 'Please select a ministry.'
        ]);

        $validator->requirePresence('department');
        $validator->add('department', 'not-blank', [
            'rule' => 'notBlank',
            'message' => 'Please enter department.'
        ]);


        $validator->requirePresence('office_city_id');
        $validator->add('office_city_id', 'not-blank', [
            'rule' => 'notBlank',
            'message' => 'Please select a city.'
        ]);

        $validator->requirePresence('office_address');
        $validator->add('office_address', 'not-blank', [
            'rule' => 'notBlank',
            'message' => 'Please enter office street address.'
        ]);

        $validator->requirePresence('office_postal_code');
        $validator->add('office_postal_code', 'not-blank', [
            'rule' => 'notBlank',
            'message' => 'Please enter office postal code.'
        ]);

        $validator->requirePresence('work_phone');
        $validator->add('work_phone', 'not-blank', [
            'rule' => 'notBlank',
            'message' => 'Please enter office phone number.'
        ]);



        $validator->requirePresence('home_city_id');
        $validator->add('home_city_id', 'not-blank', [
            'rule' => 'notBlank',
            'message' => 'Please select a city.'
        ]);

        $validator->requirePresence('home_address');
        $validator->add('home_address', 'not-blank', [
            'rule' => 'notBlank',
            'message' => 'Please enter home street address.'
        ]);

        $validator->requirePresence('home_postal_code');
        $validator->add('home_postal_code', 'not-blank', [
            'rule' => 'notBlank',
            'message' => 'Please enter home postal code.'
        ]);

        $validator->requirePresence('work_phone');
        $validator->add('work_phone', 'not-blank', [
            'rule' => 'notBlank',
            'message' => 'Please enter office phone.'
        ]);


        $validator->requirePresence('supervisor_city_id');
        $validator->add('supervisor_city_id', 'not-blank', [
            'rule' => 'notBlank',
            'message' => 'Please select a city.'
        ]);

        $validator->requirePresence('supervisor_first_name');
        $validator->add('supervisor_first_name', 'not-blank', [
            'rule' => 'notBlank',
            'message' => 'Please enter your supervisor first name.'
        ]);

        $validator->requirePresence('supervisor_last_name');
        $validator->add('supervisor_last_name', 'not-blank', [
            'rule' => 'notBlank',
            'message' => 'Please enter your supervisor last name.'
        ]);

        $validator->requirePresence('supervisor_address');
        $validator->add('supervisor_address', 'not-blank', [
            'rule' => 'notBlank',
            'message' => 'Please enter supervisor street address.'
        ]);

        $validator->requirePresence('supervisor_postal_code');
        $validator->add('supervisor_postal_code', 'not-blank', [
            'rule' => 'notBlank',
            'message' => 'Please enter supervisor postal code.'
        ]);

        $validator->requirePresence('supervisor_email');
        $validator->add('supervisor_email', 'validFormat', [
            'rule' => 'email',
            'message' => 'E-mail must be valid'
        ]);


        return $validator;
    }
}
