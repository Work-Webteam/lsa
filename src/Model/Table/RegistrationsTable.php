<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use phpDocumentor\Reflection\Types\Void_;

class RegistrationsTable extends Table
{
    public function initialize(array $config) : Void
    {
        $this->hasOne('Milestones');
        $this->hasOne('Awards');
        $this->hasOne('Diet');
    }
}
