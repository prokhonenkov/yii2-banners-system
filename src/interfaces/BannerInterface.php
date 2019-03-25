<?php
/**
 * Created by PhpStorm.
 * User: prokhonenkov
 * Date: 15.03.19
 * Time: 11:49
 */

namespace prokhonenkov\bannerssystem\interfaces;

/**
 * Interface BannerInterface
 * @package prokhonenkov\bannerssystem\interfaces
 */
interface BannerInterface
{
	/**
	 * @return int
	 */
	public function getId(): int ;

	/**
	 * @return int
	 */
	public function getZoneId(): int ;

	/**
	 * @return int|null
	 */
	public function getZoneWidth(): ?int ;

	/**
	 * @return int|null
	 */
	public function getZoneHeight(): ?int ;

	/**
	 * @return string
	 */
	public function getRedirectUrl(): string ;

	/**
	 * @return string
	 */

	public function getHtml(): string ;

	/**
	 * @param array $ids
	 */

	public static function setViews(array $ids): void ;

	/**
	 * @param int $id
	 */

	public static function setClick(int $id): void ;

	/**
	 * @return mixed
	 */


	public function getUrls();

}