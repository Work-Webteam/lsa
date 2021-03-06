<?php
/*
 * Local configuration file to provide any overrides to your app.php configuration.
 * Copy and save this file as app_local.php and make changes as required.
 * Note: It is not recommended to commit files with credentials such as app_local.php
 * into source code version control.
 */



if (getenv('OPENSHIFT_BUILD_NAME')) {

    $config = [
        /*
         * Debug Level:
         *
         * Production Mode:
         * false: No error messages, errors, or warnings shown.
         *
         * Development Mode:
         * true: Errors and warnings shown.
         */
        'debug' => filter_var(env('DEBUG', false), FILTER_VALIDATE_BOOLEAN),

        /*
         * Security and encryption configuration
         *
         * - salt - A random string used in security hashing methods.
         *   The salt value is also used as the encryption key.
         *   You should treat it as extremely sensitive data.
         */
        'Security' => [
            'salt' => env('SECURITY_SALT', '59355a968ed7ec0694dd31343254af82cbe1370ad00aacb554ea5885a069da92'),
        ],

        /*
         * Connection information used by the ORM to connect
         * to your application's datastores.
         *
         * See app.php for more configuration options.
         */
        'Datasources' => [
            'default' => [
                'host' => getenv('LSA_DB_HOST'),
                /*
                 * CakePHP will use the default DB port based on the driver selected
                 * MySQL on MAMP uses port 8889, MAMP users will want to uncomment
                 * the following line and set the port accordingly
                 */
                'port' => getenv('LSA_DB_PORT'),

                'username' => getenv('LSA_DB_USER'),
                'password' => getenv('LSA_DB_PASSWORD'),

                'database' => getenv('LSA_DB_NAME'),
                /**
                 * If not using the default 'public' schema with the PostgreSQL driver
                 * set it here.
                 */
                //'schema' => 'myapp',

                /**
                 * You can use a DSN string to set the entire configuration
                 */
                'url' => env('DATABASE_URL', null),
            ],

            /*
             * The test connection is used during the test suite.
             */
            'test' => [
                'host' => 'localhost',
                //'port' => 'non_standard_port_number',
                'username' => 'my_app',
                'password' => 'secret',
                'database' => 'test_myapp',
                //'schema' => 'myapp',
            ],
        ],

        /*
         * Email configuration.
         *
         * Host and credential configuration in case you are using SmtpTransport
         *
         * See app.php for more configuration options.
         */
        'EmailTransport' => [
            'default' => [
                'host' => getenv('LSA_EMAIL_HOST'),
                'port' => getenv('LSA_EMAIL_PORT'),
                'username' => null,
                'password' => null,
                'client' => null,
                'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
            ],
        ],
    ];

}

else {

    $config = [
        /*
         * Debug Level:
         *
         * Production Mode:
         * false: No error messages, errors, or warnings shown.
         *
         * Development Mode:
         * true: Errors and warnings shown.
         */
        'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),

        /*
         * Security and encryption configuration
         *
         * - salt - A random string used in security hashing methods.
         *   The salt value is also used as the encryption key.
         *   You should treat it as extremely sensitive data.
         */
        'Security' => [
            'salt' => env('SECURITY_SALT', '59355a968ed7ec0694dd31343254af82cbe1370ad00aacb554ea5885a069da92'),
        ],

        /*
         * Connection information used by the ORM to connect
         * to your application's datastores.
         *
         * See app.php for more configuration options.
         */
        'Datasources' => [
          'default' => [
              'host' => env('LSA_DB_HOST', 'localhost'),
              /*
               * CakePHP will use the default DB port based on the driver selected
               * MySQL on MAMP uses port 8889, MAMP users will want to uncomment
               * the following line and set the port accordingly
               */
              'port' => env('LSA_DB_PORT'), //'3306',

              'username' => env('LSA_DB_USER'),
              'password' => env('LSA_DB_PASSWORD'),
              'database' => env('LSA_DB_NAME'),

              /**
               * If not using the default 'public' schema with the PostgreSQL driver
               * set it here.
               */
              //'schema' => 'myapp',

              /**
               * You can use a DSN string to set the entire configuration
               */
              'url' => env('DATABASE_URL', null),
          ],


            /*
             * The test connection is used during the test suite.
             */
            'test' => [
                'host' => 'localhost',
                //'port' => 'non_standard_port_number',
                'username' => 'my_app',
                'password' => 'secret',
                'database' => 'test_myapp',
                //'schema' => 'myapp',
            ],
        ],

        /*
         * Email configuration.
         *
         * Host and credential configuration in case you are using SmtpTransport
         *
         * See app.php for more configuration options.
         */
        'EmailTransport' => [
            'default' => [
                'host' => env('LSA_EMAIL_HOST', 'localhost'),
                'port' => env('LSA_EMAIL_PORT', 25),
                'username' => null,
                'password' => null,
                'client' => null,
                'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
            ],
        ],
        'Session' => [
        'defaults' => 'database',
        ]
    ];

}

// echo "<pre>" . print_r($config, true) . "</pre>";

return $config;
