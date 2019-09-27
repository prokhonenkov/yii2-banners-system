<?php

namespace prokhonenkov\bannerssystem\models;

use Yii;

/**
 * This is the model class for table "banners_zones".
 *
 * @property int $id
 * @property string $title
 * @property int $width
 * @property int $height
 * @property int $is_active
 * @property int $type
 *
 * @property Banners[] $banners
 */
class Zone extends \yii\db\ActiveRecord
{
	const TYPE_ROTATE = 1;
	const TYPE_LIST = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banners_zones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
			[['title'], 'required'],
            [['width', 'height', 'is_active', 'type'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => \Yii::t('banners-system', 'Title'),
            'width' => \Yii::t('banners-system', 'Width'),
            'height' => \Yii::t('banners-system', 'Height'),
            'is_active' => \Yii::t('banners-system', 'Status'),
            'type' => \Yii::t('banners-system', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBanners()
    {
        return $this->hasMany(Banners::className(), ['zone_id' => 'id']);
    }

    public static function getForDropDown()
	{
		return self::find()
			->select('title')
			->indexBy('id')
			->column();
	}

	public static function getTypes()
	{
		return [
			self::TYPE_ROTATE => \Yii::t('banners-system', 'Rotate'),
			self::TYPE_LIST => \Yii::t('banners-system', 'List')
		];
	}

	public function isRotate()
	{
		return (int)$this->type === self::TYPE_ROTATE;
	}
}
