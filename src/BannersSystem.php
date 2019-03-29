<?php

namespace prokhonenkov\bannerssystem;

use prokhonenkov\bannerssystem\exceptions\InvalidConfigException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * module module definition class
 */
class BannersSystem extends \yii\base\Module
{
	public $layout;
	public $administratorPermissionName;
	public $uploadDir = null;
	public $uploadUrl = null;
	public $views = [];

    /**
	 * .
     * {@inheritdoc}
     */
    public $controllerNamespace = 'prokhonenkov\bannerssystem\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
		parent::init();

		$this->initRepeater();
		$this->initViews();
    }

	public function initViews()
	{
		$modelViews = [
			'banner' => [
				'index' => 'index',
				'update' => 'update',
				'create' => 'create',
				'view' => 'view',
			],
			'area' => [
				'index' => 'index',
				'update' => 'update',
				'create' => 'create',
				'view' => 'view',
			]
		];

		foreach ($modelViews as $model => $views) {
			foreach ($views as $view => $value) {
				if(!isset($this->views[$model][$view])) {
					$this->views[$model][$view] = $value;
				}
			}
		}
	}

	public function initRepeater()
	{
		if (\Yii::$app instanceof \yii\web\Application) {
			\Yii::$app->getAssetManager()->bundles = [
				'relbraun\yii2repeater\RepeaterAsset' => [
					'basePath' => '/'
				]
			];
		}
	}
}
