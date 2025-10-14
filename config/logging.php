<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;
<<<<<<< HEAD
=======
use Monolog\Processor\PsrLogMessageProcessor;
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
<<<<<<< HEAD
=======
    | Deprecations Log Channel
    |--------------------------------------------------------------------------
    |
    | This option controls the log channel that should be used to log warnings
    | regarding deprecated PHP and library features. This allows you to get
    | your application ready for upcoming major versions of dependencies.
    |
    */

    'deprecations' => [
        'channel' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),
        'trace' => false,
    ],

    /*
    |--------------------------------------------------------------------------
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
<<<<<<< HEAD
            'level' => 'debug',
=======
            'level' => env('LOG_LEVEL', 'debug'),
            'replace_placeholders' => true,
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
<<<<<<< HEAD
            'level' => 'debug',
            'days' => 14,
=======
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14,
            'replace_placeholders' => true,
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
<<<<<<< HEAD
            'level' => 'critical',
=======
            'level' => env('LOG_LEVEL', 'critical'),
            'replace_placeholders' => true,
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67
        ],

        'papertrail' => [
            'driver' => 'monolog',
<<<<<<< HEAD
            'level' => 'debug',
            'handler' => SyslogUdpHandler::class,
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
=======
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => env('LOG_PAPERTRAIL_HANDLER', SyslogUdpHandler::class),
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
                'connectionString' => 'tls://'.env('PAPERTRAIL_URL').':'.env('PAPERTRAIL_PORT'),
            ],
            'processors' => [PsrLogMessageProcessor::class],
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67
        ],

        'stderr' => [
            'driver' => 'monolog',
<<<<<<< HEAD
=======
            'level' => env('LOG_LEVEL', 'debug'),
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
<<<<<<< HEAD
=======
            'processors' => [PsrLogMessageProcessor::class],
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67
        ],

        'syslog' => [
            'driver' => 'syslog',
<<<<<<< HEAD
            'level' => 'debug',
=======
            'level' => env('LOG_LEVEL', 'debug'),
            'facility' => LOG_USER,
            'replace_placeholders' => true,
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67
        ],

        'errorlog' => [
            'driver' => 'errorlog',
<<<<<<< HEAD
            'level' => 'debug',
=======
            'level' => env('LOG_LEVEL', 'debug'),
            'replace_placeholders' => true,
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],
    ],

];
