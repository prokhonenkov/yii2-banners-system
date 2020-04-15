<?php
/**
 * Created by PhpStorm.
 * User: prokhonenkov
 * Date: 19.03.19
 * Time: 17:19
 */

namespace prokhonenkov\bannerssystem\assets;


class AssetBundle extends \yii\web\AssetBundle
{
	public $sourcePath = '@vendor/prokhonenkov/yii2-banners-system/assets';

	public $depends = [
		'yii\web\YiiAsset',
	];
}