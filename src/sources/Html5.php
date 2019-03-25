<?php
/**
 * Created by PhpStorm.
 * User: prokhonenkov
 * Date: 25.02.19
 * Time: 10:13
 */

namespace prokhonenkov\bannerssystem\sources;


use yii\bootstrap\Html;

/**
 * Class Html5
 * @package prokhonenkov\bannerssystem\sources
 */
class Html5 extends SourceAbstract
{
	/**
	 * @param int|null $width
	 * @param int|null $height
	 * @return string
	 */
	public function getHtml(int $width = null, int $height = null): string
	{
		return Html::tag(
			'iframe',
			'', [
				'frameborder' => 0,
				'scrolling' => 'no',
				'width' => $width ? ($width . 'pz') : null,
				'height' => $height ? ($height . 'pz') : null,
				'src' => $this->url,
				'class' => self::CSS_CLASS
		]);
	}
}