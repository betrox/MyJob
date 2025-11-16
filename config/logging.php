<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

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
    | Deprecations Log Channel
    |--------------------------------------------------------------------------
    |
    | This option controls the log channel that should be used to log warnings
    | regarding deprecated PHP and library features. This allows you to get
    | your application ready for upcoming major versions of dependencies.
    |
    */

    'deprecations' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),

    /*
    |--------------------------------------------------------------------------
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
            'channels' => ['null'], // 修改为 null，彻底禁用日志
            'ignore_exceptions' => true, // 忽略写日志异常
        ],

        'single' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class, // 改为 NullHandler
        ],

        'daily' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class, // 改为 NullHandler
        ],

        'slack' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'stderr' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'syslog' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'errorlog' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class, // 修改 emergency logger
        ],
    ],

];