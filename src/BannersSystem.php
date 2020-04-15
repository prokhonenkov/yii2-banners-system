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
	/**
	 * @var string
	 */
	public $layout;
	/**
	 * @var array
	 */
	public $administratorPermissionName;
	/**
	 * @var null|string
	 */
	public $uploadDir = null;
	/**
	 * @var null|string
	 */
	public $uploadUrl = null;
	/**
	 * @var array
	 */
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

		if(!is_null($this->administratorPermissionName) && !is_array($this->administratorPermissionName)) {
			throw new \InvalidArgumentException('administratorPermissionName mast be array');
		}

		$this->initViews();
	}

	public function initViews(): void
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

	/**
	 * @return bool
	 */
	public function checkAccess(): bool
	{
		if(is_null($this->administratorPermissionName)) {
			return true;
		}

		$perms = 0;
		foreach ($this->administratorPermissionName as $role) {
			$perms += (int)\Yii::$app->getUser()->can($role);
		}

		return  $perms > 0;
	}
}