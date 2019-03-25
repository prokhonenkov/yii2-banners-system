<?php
/**
 * Created by PhpStorm.
 * User: prokhonenkov
 * Date: 15.03.19
 * Time: 12:47
 */

namespace prokhonenkov\bannerssystem\interfaces;


interface BannerZoneInterface
{
	public function setZoneById(int $id): string ;

	public function getZoneIds(): array ;
}