<?php
/**
 * Created by PhpStorm.
 * User: prokhonenkov
 * Date: 25.02.19
 * Time: 9:08
 */

namespace prokhonenkov\bannerssystem\sources;

use yii\helpers\Html;

/**
 * Class Image
 * @package prokhonenkov\bannerssystem\sources
 */
class Image extends SourceAbstract
{
	/**
	 * @param int|null $width
	 * @param int|null $height
	 * @return string
	 */
	public function getHtml(int $width = null, int $height = null): string
	{
		return Html::img($this->url, [
			'width' => $width ? ($width . 'px') : null,
			'height' => $height ? ($height . 'px') : null,
			'class' => self::CSS_CLASS
		]);
	}
}