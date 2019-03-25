<?php
/**
 * Created by PhpStorm.
 * User: prokhonenkov
 * Date: 15.03.19
 * Time: 17:24
 */

namespace prokhonenkov\bannerssystem\interfaces;


interface BannerUrlInterface
{
	public function getUrl(): string ;

	public function isThrough(): bool ;
}