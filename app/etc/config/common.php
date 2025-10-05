<?php
/**
 * @var $env array
 */

use yii\queue\db\Queue;
use yii\mutex\MysqlMutex;
use yii\db\Connection;
use yii\symfonymailer\Mailer;
use yii\caching\FileCache;

$env = require(ENV_PATH);

$config = [
    'id' => 'http-rest-api-service',
    'name' => 'Http Rest API Service',
    'basePath' => ROOT_PATH,
    'runtimePath' => RUNTIME_PATH,
    'vendorPath' => VENDOR_PATH,
    'bootstrap' => ['log', 'queue'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'timezone' => $env['timezone'] ?? 'Europe/London',
    'language' => $env['language'] ?? 'en-US',
    'components' => [
        'queue' => [
            'class' => Queue::class,
            'db' => 'db',
            'tableName' => '{{%queue}}',
            'channel' => 'default',
            'mutex' => MysqlMutex::class,
            'ttr' => 300, // Time to reserve
            'attempts' => 3,
        ],
        'cache' => [
            'class' => FileCache::class,
            'cachePath' => RUNTIME_PATH . '/cache',
            'defaultDuration' => 3600,
        ],
        'mailer' => [
            'class' => Mailer::class,
            'viewPath' => '@Middleware/Framework/Mail',
            'useFileTransport' => $env['mailer.file.transport'],
            'transport' => [
                'scheme' => 'smtps',
                'host' => $env['mailer.host'],
                'username' => $env['mailer.username'],
                'password' => $env['mailer.password'],
                'port' => 465,
                'dsn' => 'native://default'
            ]
        ],
        'db' => [
            'class' => Connection::class,
            'charset' => 'utf8mb4',
            'dsn' => $env['db.dsn'],
            'username' => $env['db.username'],
            'password' => $env['db.password'],
            'enableSchemaCache' => !YII_DEBUG,
            'schemaCacheDuration' => 3600,
            'schemaCache' => 'cache',
            'enableQueryCache' => true,
            'queryCacheDuration' => 3600,
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:Y-m-d',
            'datetimeFormat' => 'php:Y-m-d H:i:s',
            'timeFormat' => 'php:H:i:s',
            'defaultTimeZone' => $env['timezone'] ?? 'Europe/London',
        ],
    ],
    'params' => array_merge([
        'apiVersion' => '1.0',
        'allowedOrigins' => ['*'],
    ], $env['params'] ?? []),
];

return $config;
