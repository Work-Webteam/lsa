<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use phpDocumentor\Reflection\Types\Void_;

class PecsfRegionsTable extends Table
{
    public function initialize(array $config) : Void
    {
        $this->belongsTo('PecsfCharities');
    }
}
