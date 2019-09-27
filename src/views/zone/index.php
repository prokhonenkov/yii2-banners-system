<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use \prokhonenkov\bannerssystem\helpers\BannerHelper;

/* @var $this yii\web\View */
/* @var $searchModel \prokhonenkov\bannerssystem\models\search\ZoneSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::t('banners-system', 'Banner areas');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('banners-system', 'Banners System'), 'url' => ['/bannerssystem/banner']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zone-index">

	<?php $this->beginContent('@prokhonenkov/bannerssystem/views/common/layout.php', ['isMenu' => true]) ?>

	<?php Pjax::begin() ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'width',
            'height',
            [
                'attribute' => 'type',
                'value' => function(\prokhonenkov\bannerssystem\models\Zone $model) {
                    return \yii\helpers\ArrayHelper::getValue($model::getTypes(), $model->type);
                },
                'filter' => \prokhonenkov\bannerssystem\models\Zone::getTypes()
            ],
			[
				'class' => 'dosamigos\grid\columns\ToggleColumn',
				'attribute' => 'is_active',
				'onValue' => 1,
				'onLabel' => Yii::t('banners-system', 'Active'),
				'offLabel' => Yii::t('banners-system', 'Inactive'),
				'contentOptions' => ['class' => 'text-center'],
				'filter' => ['1' => Yii::t('banners-system', 'Active'), '0' => Yii::t('banners-system', 'Inactive')],
			],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
	<?php Pjax::end() ?>

	<?php $this->endContent() ?>
</div>
