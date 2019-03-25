<?php
/**
 * Created by PhpStorm.
 * User: prokhonenkov
 * Date: 25.02.19
 * Time: 9:10
 */

namespace prokhonenkov\bannerssystem\sources;

/**
 * Class BannerFile
 * @package app\modules\banners\models
 */
abstract class SourceAbstract
{
	protected const CSS_CLASS = 'with-veil';
	/**
	 * @var string
	 */
	protected $url;

	/**
	 * SourceAbstract constructor.
	 * @param $url
	 */
	public function __construct($url)
	{
		$this->url = $url . $this->getHash();
	}

	/**
	 * @param int|null $width
	 * @param int|null $height
	 * @return string
	 */
	abstract public function getHtml(int $width = null, int $height = null): string ;

	/**
	 * @return string
	 */
	private function getHash()
	{
		return '?' . time();
	}


}