<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
use Hyperf\Contract\StdoutLoggerInterface;
use Psr\Log\LogLevel;

return [
    'app_name' => env('APP_NAME', 'MoChat'),
    'app_env' => env('APP_ENV', 'dev'),
    'scan_cacheable' => env('SCAN_CACHEABLE', false),
    'debug' => [
        'event' => env('DEBUG_EVENT', false),
        'database' => env('DEBUG_DATABASE', false),
        'queue' => env('DEBUG_QUEUE', false),
        'crontab' => env('DEBUG_CRONTAB', false),
    ],
    StdoutLoggerInterface::class => [
        'log_level' => [
            LogLevel::ALERT,
            LogLevel::CRITICAL,
            LogLevel::DEBUG,
            LogLevel::EMERGENCY,
            LogLevel::ERROR,
            LogLevel::INFO,
            LogLevel::NOTICE,
            LogLevel::WARNING,
        ],
    ],
];
