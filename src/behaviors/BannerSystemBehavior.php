<?php
/**
 * Created by PhpStorm.
 * User: prokhonenkov
 * Date: 15.03.19
 * Time: 16:48
 */

namespace prokhonenkov\bannerssystem\behaviors;


use prokhonenkov\bannerssystem\assets\FrontendAssetBundle;
use prokhonenkov\bannerssystem\BannerZone;
use prokhonenkov\bannerssystem\helpers\BannerHelper;
use prokhonenkov\bannerssystem\models\Banner;
use yii\base\Behavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\View;

class BannerSystemBehavior extends Behavior
{
	public function events()
	{
		if(\Yii::$app->request->isAjax) {
			return [];
		}
		return [
			Controller::EVENT_BEFORE_ACTION => 'beforeAction',
		];
	}

	public function beforeAction()
	{
		FrontendAssetBundle::register($this->owner->getView());

		$this->owner->getView()->on(View::EVENT_END_PAGE, function () {

			if(!$zoneIds = BannerZone::getInstance()->getZoneIds()) {
				return true;
			}

			if(!$banners = Banner::getBannersByZoneIds(...$zoneIds)) {
				return true;
			}

			$banners = BannerHelper::setupBunners(...$banners);

			$json = Json::encode([
				'banners' => $banners,
				'url' => Url::to(['/bannerssystem/banner/set-click'])
			]);

			$this->owner->getView()->registerJs('var bannerSystem = new BannerSystem(' . $json . ')');

			$ids = [];
			foreach ($banners as $bannerZone) {
				if(ArrayHelper::isAssociative($bannerZone['bannerOptions'])) {
					$ids[] = $bannerZone['bannerOptions']['id'];
				} else {
					foreach ($bannerZone['bannerOptions'] as $banner) {
						$ids[] = $banner['id'];
					}
				}
			}

			Banner::setViews(...$ids);
		});
	}
}