<?php

use app\components\TestService;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'language' => 'ru',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '54kh8okl745',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                // 9) Создать в конфиге у компонента log дополнительную цель (target) для записи в лог факта авторизации
                // пользователя. Уровень (level) сделать info, категорию и файл назвать, например login.
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['login'],
                    'logFile' => '@runtime/logs/login.log'
                ]
            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            // Урл страниц просмотра для всех контроллеров д.б. вида /task/1
            'rules' => [
                '<controller:[\w-]+>s' => '<controller>/index',
                '<controller:[\w-]+>/<id:\d+>' => '<controller>/view',
            ],
        ],
        // Настроить в web.php компонент test с ключом class равным \app\components\TestService::class,
        // Задать в описании компонента test (web.php) другое значение для его свойстваи убедиться, что во вьюхе теперь выводится оно.
        'test' => [
            'class' => TestService::class,
            'prop' => 'Задаем свой props в описании компонента test, которое выводится во views.',
        ],

    ],
    'params' => $params,
];

// в web.php сделать доступ к GII и Debug вставив свой локальный айпишник (127.0.0.1) или '*'.
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];
}

return $config;
