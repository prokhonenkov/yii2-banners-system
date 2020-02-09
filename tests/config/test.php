<?php

return [
    'id' => 'yii2-user-tests',
    'basePath' => dirname(__DIR__),
    'language' => 'en-US',
    'aliases' => [
        '@tests' => dirname(dirname(__DIR__)),
        '@vendor' => VENDOR_DIR,
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'bootstrap' => ['bannersSystem'],
    'modules' => [
		'bannersSystem' => [
			'class' => \prokhonenkov\bannerssystem\BannersSystem::class,
			'administratorPermissionName' => 'admin',
			'uploadDir' => dirname(__DIR__) . '/_data',
			'uploadUrl' => '/upload',
		],
    ],
    'components' => [
		'user' => [
			'identityClass' => 'app\models\User',
		],
        'assetManager' => [
            'basePath' => __DIR__ . '/../assets',
        ],
        'db' => require __DIR__ . '/db.php',
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
        ],
		'i18n' => [
			'translations' => [
				'banners-system' => [
					'class' => \yii\i18n\PhpMessageSource::class,
					'sourceLanguage' => 'ru-RU',
					'basePath' => dirname(dirname(__DIR__)) . '/src/i18n',
				]
			]
		],
    ],
    'params' => [],
];
