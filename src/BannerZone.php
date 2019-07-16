<?php
/**
 * Created by PhpStorm.
 * User: prokhonenkov
 * Date: 15.03.19
 * Time: 12:53
 */

namespace prokhonenkov\bannerssystem;

use prokhonenkov\bannerssystem\helpers\BannerHelper;
use prokhonenkov\bannerssystem\interfaces\BannerZoneInterface;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class BannerZone implements BannerZoneInterface
{
	private static $instance = null;

	private $zoneIds = [];

	private function __clone() {}
	private function __construct() {}

	public static function getInstance(): self
	{
		if(self::$instance === null) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function setZoneById(int $id, array $options = []): string
	{
		$this->zoneIds[] = $id;

		return Html::tag(
			'div',
			Html::tag('div', '', [
				'class' => 'veil'
			]),
			ArrayHelper::merge($options, [
				'id' => BannerHelper::PREFIX_BANNER_ZONE . $id,
				'class' => 'banner-system hidden ' . ($options['class'] ?? null)
			]));
	}

	public function getZoneIds(): array
	{
		return $this->zoneIds;
	}
}