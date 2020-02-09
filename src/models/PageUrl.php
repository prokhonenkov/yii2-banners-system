<?php

namespace prokhonenkov\bannerssystem\models;

use prokhonenkov\bannerssystem\interfaces\BannerUrlInterface;
use Yii;

/**
 * This is the model class for table "banners_pages_urls".
 *
 * @property int $id
 * @property int $banner_id
 * @property string $url
 * @property int $is_through
 *
 * @property Banner $banner
 */
class PageUrl extends \yii\db\ActiveRecord implements BannerUrlInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banners_pages_urls';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['banner_id', 'is_through'], 'integer'],
            [['url'], 'string', 'max' => 255],
            [['banner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Banner::className(), 'targetAttribute' => ['banner_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'banner_id' => 'Banner ID',
            'url' => \Yii::t('banners-system', 'Url'),
            'is_through' => \Yii::t('banners-system', 'Show on internal pages'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBanner()
    {
        return $this->hasOne(Banner::className(), ['id' => 'banner_id']);
    }

	/**
	 * @param int $id
	 * @param array $data
	 * @return bool
	 * @throws \yii\db\Exception
	 */
    public static function batchUpdate(int $id, array $data): bool
	{
		$transaction = \Yii::$app->db->beginTransaction();

		self::deleteAll(['banner_id' => $id]);

		if(!$data) {
			$transaction->commit();
			return true;
		}

		$insert = [];
		foreach ($data as $item) {
			$insert[] = [
				$id,
				rtrim($item['url'], '/'),
				$item['is_through']
			];
		}

		try {
			\Yii::$app->db->createCommand()
				->batchInsert(self::tableName(),
					['banner_id', 'url', 'is_through'],
					$insert
				)->execute();
		} catch (\Exception $e) {
			$transaction->rollBack();
			return false;
		}

		$transaction->commit();
		return true;
	}

	/**
	 * @return string
	 */
	public function getUrl(): string
	{
		return $this->url;
	}

	/**
	 * @return int
	 */
	public function isThrough(): bool
	{
		return $this->is_through;
	}
}
