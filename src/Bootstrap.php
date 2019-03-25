<?php

namespace prokhonenkov\bannerssystem;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\i18n\PhpMessageSource;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
		$this->initTranslations($app);
        $app->getUrlManager()->addRules([
        ], true);
        $app->setModule('bannerssystem', 'prokhonenkov\bannerssystem\BannersSystem');
    }

	protected function initTranslations(Application $app)
	{
		if (!isset($app->get('i18n')->translations['banners-system*'])) {
			$app->get('i18n')->translations['banners-system*'] = [
				'class' => PhpMessageSource::class,
				'basePath' => __DIR__ . '/i18n',
			//	'sourceLanguage' => 'en-US',
			];
		}
	}
}
