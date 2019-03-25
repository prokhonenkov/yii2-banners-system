<?php

use yii\bootstrap\Nav;

?>

<?= Nav::widget(
    [
        'options' => [
            'class' => 'nav-tabs',
            'style' => 'margin-bottom: 15px',
        ],
        'items' => [
            [
                'label' => Yii::t('banners-system', 'Banners'),
                'url' => ['/bannerssystem/banner/index'],
            ],
            [
                'label' => Yii::t('banners-system', 'Banner areas'),
                'url' => ['/bannerssystem/zone/index'],
            ],
            [
                'label' => Yii::t('banners-system', 'Create'),
                'items' => [
                    [
                        'label' => Yii::t('banners-system', 'New banner'),
                        'url' => ['/bannerssystem/banner/create'],
                    ],
                    [
                        'label' => Yii::t('banners-system', 'New area'),
                        'url' => ['/bannerssystem/zone/create'],
                    ],
                ],
            ],
        ],
    ]
) ?>
