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

    'Test' => [
        'mode' => true,
        'email' => 'raymond.kuyvenhoven@gov.bc.ca',
    ],

    'LSA' => [
        'lsa_site_name' => 'Long Service Awards',
        'lsa_site_slogan' => 'Celebrating Your Loyal Service',
        'lsa_contact_name' => 'LSA Admin Person',
        'lsa_contact_email' => 'lsa.admin@gov.bc.ca',
        'lsa_contact_phone' => '250-555-1111',
    ],

    'Role' => [
        'authenticated' => 0,
        'admin' => 1,
        'lsa_admin' => 2,
        'protocol' => 3,
        'procurement' => 4,
        'ministry_contact' => 5,
        'supervisor' => 6
    ],

    'Donation' => [
        'id' => 0,
        'name' => 'PECSF Donation',
        'description' => "Instead of choosing an award from the catalogue, you can opt to make a charitable donation via the Provincial Employees Community Services Fund. A framed certificate of service, signed by the Premier of British Columbia, will be presented to you noting your charitable contribution.",
        'image' => "25_pecsf.jpg",
    ],


];
