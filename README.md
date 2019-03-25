Banners System
==============
This extension helps to place banners on pages of a site and manage them.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require prokhonenkov/yii2-banners-system
```

or add

```
"prokhonenkov/yii2-banners-system": "*"
```

to the require section of your `composer.json` file.


Migrations
----------

Run the following command

```
php yii migrate --migrationPath=@prokhonenkov/bannerssystem/migrations --interactive=0
```


Configuration
-------------

Add module declaration to your config file for web config:
```php
<?php

return [
    // ... your config
    'modules' => [
        'bannersSystem' => [
            'class' => \prokhonenkov\bannerssystem\BannersSystem::class,
            'administratorPermissionName' => 'admin', //admin role
            'uploadDir' => '@webroot/media/banners-system',
            'uploadUrl' => '@web/media/banners-system',
        ],
    ],
    'bootstrap' => [        
        'bannersSystem' // add module id to bootstrap for proper aliases and url routes binding
    ]
];

```

Also, you can override layout and view files:
```php
<?php

return [
    // ... your config
    'modules' => [
        'bannersSystem' => [
            'class' => \prokhonenkov\bannerssystem\BannersSystem::class,
            'administratorPermissionName' => 'admin', //admin role
            'uploadDir' => '@webroot/media/banners-system',
            'uploadUrl' => '@web/media/banners-system',
            
            'layout' => '@alias/views/layouts/main',
            'views' => [
                 [
                    'banner' => [
                        'index' => '@path/index',
                        'update' => '@path/update',
                        'create' => '@path/create',
                        'view' => '@path/view',
                    ],
                    'area' => [
                        'index' => '@path/index',
                        'update' => '@path/update',
                        'create' => '@path/create',
                        'view' => '@path/view',
                    ]
                ]
            ],
        ],
    ],
];

```


Usage
-----

Put this code in your desired controller: 
```php
public function behaviors()
{
    return [
        'banner-system' => [
            'class' => \prokhonenkov\bannerssystem\behaviors\BannerSystemBehavior::class
        ]
    ];
}
```

Then, create a banner zone and banner in the admin panel. 

Put this code in your desired view file in the desired place:
```php
<?= \prokhonenkov\bannerssystem\BannerZone::getInstance()->setZoneById(BANNER_ZONE_ID);?>
```