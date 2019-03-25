<?php

namespace prokhonenkov\bannerssystem\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "banners_statistics".
 *
 * @property int $id
 * @property int $banner_id
 * @property int $action
 * @property string $created_at
 *
 * @property Banner $banner
 */
class Statistics extends \yii\db\ActiveRecord
{
	const VIEW = 1;
	const CLICK = 2;

	public $views;
	public $clicks;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banners_statistics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
			[['banner_id'], 'required'],
			[['banner_id', 'action'], 'integer'],
            [['created_at'], 'safe'],
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
            'action' => \Yii::t('banners-system', 'Action'),
            'created_at' => \Yii::t('banners-system', 'Created At'),
            'views' => \Yii::t('banners-system', 'Views'),
            'clicks' => \Yii::t('banners-system', 'Clicks'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBanner()
    {
        return $this->hasOne(Banners::className(), ['id' => 'banner_id']);
    }

	public function behaviors()
	{
		return [
			'timestamp' => [
				'class' => TimestampBehavior::class,
				'attributes' => [
					self::EVENT_BEFORE_INSERT => ['created_at'],
				],
				'value' => new Expression('NOW()'),
			],
		];
	}
}
