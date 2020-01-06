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
        $validator->requirePresence('supervisor_email');
        $validator->add('supervisor_email', 'validFormat', [
                'rule' => 'email',
                'message' => 'E-mail must be valid'
            ]);
//        $validator->add('retiring_this_year', 'not-blank', [
//            'rule' => 'notBlank',
//            'message' => 'Must select Yes or No'
//        ]);
//        $validator->notEmpty('retiring_this_year', 'enter something eh');
        return $validator;
    }
}
