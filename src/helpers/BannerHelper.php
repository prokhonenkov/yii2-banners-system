<?php
/**
 * Created by PhpStorm.
 * User: prokhonenkov
 * Date: 17.03.19
 * Time: 17:22
 */

namespace prokhonenkov\bannerssystem\helpers;


use prokhonenkov\bannerssystem\exceptions\InvalidConfigException;
use prokhonenkov\bannerssystem\interfaces\BannerInterface;
use prokhonenkov\bannerssystem\models\Banner;
use prokhonenkov\bannerssystem\models\Zone;
use prokhonenkov\bannerssystem\sources\Html5;
use prokhonenkov\bannerssystem\sources\Image;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class BannerHelper
{
	const HTML_INDEX_FILE = 'index.html';
	const PREFIX_BANNER_ZONE = 'banner_zone_';
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 0;

	public static function getStatuses()
	{
		return [
			self::STATUS_ACTIVE => \Yii::t('banners-system', 'Active'),
			self::STATUS_INACTIVE => \Yii::t('banners-system', 'Inactive')
		];
	}

	/**
	 * @param string $url
	 * @param int $width
	 * @param int $height
	 * @return string
	 * @throws InvalidConfigException
	 */
	private static function getUploadHtml(string $url, int $width = null, int $height = null): string
	{
		$fileInfo = pathinfo($url);

		if($fileInfo['extension'] == 'zip') {
			$path = self::getUploadDir() . DIRECTORY_SEPARATOR . $url;
			$tmpPath = dirname($path) . DIRECTORY_SEPARATOR . 'tmp';

			$extract = self::extractZip($path, $tmpPath);

			if(!$extract) {
				throw new \Exception(\Yii::t('banners-system', 'Unable to unpack archive'));
			}

			if(!file_exists($tmpPath . DIRECTORY_SEPARATOR . self::HTML_INDEX_FILE)) {
				throw new InvalidConfigException(\Yii::t('banners-system', 'The archive is missing index.html'));
			}

			$banner = new Html5(
				self::getUploadUrl()
				. DIRECTORY_SEPARATOR
				. dirname($url)
				. DIRECTORY_SEPARATOR
				. self::HTML_INDEX_FILE
			);
		} else {
			$banner = new Image(
				self::getUploadUrl()
				. DIRECTORY_SEPARATOR
				. $url
			);
		}

		return $banner->getHtml($width, $height);
	}

	/**
	 * @param string $path
	 * @param string $tmpPath
	 * @return bool
	 * @throws \yii\base\ErrorException
	 */
	private static function extractZip(string $path, string $tmpPath)
	{
		$zip = new \ZipArchive();
		if ($zip->open($path) === true) {
			FileHelper::removeDirectory($tmpPath);
			$zip->extractTo(dirname($path));
			$zip->extractTo($tmpPath);
			$zip->close();
			return true;
		}
		return false;

	}

	/**
	 * @return bool|mixed|string
	 * @throws InvalidConfigException
	 * @throws \yii\base\Exception
	 */
	public static function getUploadDir()
	{
		$uploadDir = \Yii::$app->getModule('bannersSystem')->uploadDir;

		if(!$uploadDir) {
			throw new InvalidConfigException('uploadDir is required');
		}

		$uploadDir = \Yii::getAlias($uploadDir);
		FileHelper::createDirectory($uploadDir);

		return $uploadDir;
	}

	/**
	 * @return bool|string
	 * @throws InvalidConfigException
	 */
	public static function getUploadUrl()
	{
		$uploadUrl = \Yii::$app->getModule('bannersSystem')->uploadUrl;

		if(!$uploadUrl) {
			throw new InvalidConfigException('uploadUrl is required');
		}

		return \Yii::getAlias($uploadUrl);
	}

	/**
	 * @param int $zoneId
	 * @param string $uniqKey
	 * @return string
	 * @throws InvalidConfigException
	 * @throws \yii\base\Exception
	 */
	public static function upload(int $zoneId, string $uniqKey): string
	{
		$fileInstance = current(UploadedFile::getInstancesByName('file'));
		if (!$fileInstance instanceof UploadedFile) {
			throw new \Exception(\Yii::t('banners-system', 'Failed to upload file.'));
		}

		$path  = self::uplodFile($fileInstance, $uniqKey);

		$bannerZone = Zone::findOne($zoneId);
		if(!$bannerZone) {
			throw new Exception(\Yii::t('banners-system', 'Banner area not found.'));
		}

		return self::getUploadHtml(
			$path,
			$bannerZone->width,
			$bannerZone->height
		);
	}

	/**
	 * @param $fileInstance
	 * @param $uniqKey
	 * @return string|null
	 * @throws InvalidConfigException
	 * @throws \yii\base\Exception
	 */
	private static function uplodFile($fileInstance, $uniqKey): ?string
	{
		$dir = self::getUploadDir();
		FileHelper::createDirectory($dir . DIRECTORY_SEPARATOR . $uniqKey);
		$name = 'source.' . $fileInstance->getExtension();

		if(!$fileInstance->saveAs($dir . DIRECTORY_SEPARATOR . $uniqKey . DIRECTORY_SEPARATOR . $name )) {
			return null;
		}

		return $uniqKey . DIRECTORY_SEPARATOR . $name;
	}

	/**
	 * @param Banner ...$banners
	 * @return array
	 */
	public static function setupBunners(BannerInterface ...$banners)
	{
		$ids = $data = [];

		$currentUrl = trim(\Yii::$app->request->absoluteUrl, '/');
		foreach ($banners as $banner) {
			foreach($banner->getUrls() as $url) {
				if($url->getUrl() === $currentUrl || $url->isThrough() && strpos($currentUrl, $url->getUrl()) !== false) {
					$ids[] = $banner->getId();

					$data[self::PREFIX_BANNER_ZONE . $banner->getZoneId()] = [
						'id' => $banner->getId(),
						'html' => str_replace(['<', '>'], ['&lt;', '&gt;'], $banner->getHtml()),
						'width' => $banner->getZoneWidth(),
						'height' => $banner->getZoneHeight(),
						'redirectUrl' => $banner->getRedirectUrl(),
					];
					break;
				}
			}
		}

		return $data;
	}
}