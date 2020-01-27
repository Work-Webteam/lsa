<?php

use Cake\Cache\Engine\FileEngine;
use Cake\Database\Connection;
use Cake\Database\Driver\Mysql;
use Cake\Error\ExceptionRenderer;
use Cake\Log\Engine\FileLog;
use Cake\Mailer\Transport\MailTransport;

return [

    /*
     * Configure basic LSA information.
     *
     * - lsa_contact_email - email address for lsa admin contact.
     * - lsa_contact_phone - phone number for lsa admin contact.
     */

    'LSA' => [
        'lsa_contact_name' => 'LSA Admin Person',
        'lsa_contact_email' => 'lsa.admin@gov.bc.ca',
        'lsa_contact_phone' => '250-555-1111',
    ],


];
