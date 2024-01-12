<?php
/**
 * @var $env array
 */

use yii\log\FileTarget;
use yii\web\JsonParser;
use yii\web\Response;
use yii\web\UrlManager;

$env = require(ENV_PATH);
$config = require(COMMON_CONFIG_PATH);

$config['components']['request'] = [
    'baseUrl' => '',
    'cookieValidationKey' => $env['cookie.validation.key'],
    'parsers' => [
        'application/json' => JsonParser::class,
    ]
];
$config['components']['response'] = [
    'class' => Response::class,
    'format' => Response::FORMAT_JSON,
    'on beforeSend' => function ($event) {
        /**@var $response Response */
        $response = $event->sender;
        if ($response->data !== null && Yii::$app->request->get('suppress_response_code')) {
            $response->data = [
                'success' => $response->isSuccessful,
                'data' => $response->data
            ];
            $response->statusCode = 200;
        }
    }
];
$config['components']['urlManager'] = [
    'class' => UrlManager::class,
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '' => 'updates/get-version'
    ]
];
$config['components']['log'] = [
    'traceLevel' => YII_DEBUG ? 3 : 0,
    'targets' => [
        [
            'class' => FileTarget::class,
            'levels' => ['error', 'warning'],
            'logFile' => RUNTIME_PATH . '/logs/api.log'
        ],
    ]
];

return $config;
