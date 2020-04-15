<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use \prokhonenkov\bannerssystem\models\Statistics;
use \prokhonenkov\bannerssystem\helpers\BannerHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\bannerssystem\models\Banner */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('banners-system', 'Banners System'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="banner-view">
	<?php $this->beginContent('@prokhonenkov/bannerssystem/views/common/layout.php') ?>
    <p>
		<?= Html::a(\Yii::t('banners-system', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a(\Yii::t('banners-system', 'Delete'), ['delete', 'id' => $model->id], [
			'class' => 'btn btn-danger',
			'data' => [
				'confirm' => \Yii::t('banners-system', 'Are you sure you want to delete this item?'),
				'method' => 'post',
			],
		]) ?>
    </p>

	<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
			'id',
			'title',
			[
				'attribute' => 'html',
				'value' => $model->html,
				'format' => 'raw'
			],
			'link:ntext',
			[
				'attribute' => 'is_active',
				'value' => BannerHelper::getStatuses()[$model->is_active]
			],
			[
				'attribute' => 'zone_id',
				'value' => $model->zone->title
			],
			'created_at',
			'updated_at',
		],
	]) ?>

	<?php
	$provider = new \yii\data\ActiveDataProvider([
		'query' => \prokhonenkov\bannerssystem\models\PageUrl::find()->where([
			'banner_id' => $model->id,
		]),
		'pagination' => [
			'pageSize' => 30,
		],
	]);
	?>

    <div class="panel padding10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
					<?= \Yii::t('banners-system', 'Pages to show banner')?>
                </h3>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
					<?php \yii\widgets\Pjax::begin(); ?>
					<?= \yii\grid\GridView::widget([
						'dataProvider' => $provider,
						'columns' => [
							'url',
							[
								'attribute' => 'is_through',
								'value' => function($model){
									return Yii::t('banners-system', $model->is_through ? 'Yes' : 'No');
								}
							],
						]
					]); ?>
					<?php \yii\widgets\Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>

	<?php
	$provider = new \yii\data\ActiveDataProvider([
		'query' => Statistics::find()
			->where([
				'banner_id' => $model->id,
			])
			->select([
				'clicks' => new \yii\db\Expression('SUM(IF(action = ' . Statistics::CLICK. ', 1, 0))'),
				'views' => new \yii\db\Expression('SUM(IF(action = ' . Statistics::VIEW. ', 1, 0))'),
				'created_at' => new \yii\db\Expression('DATE(created_at)')
			])
			->groupBy(new \yii\db\Expression('DATE(created_at)')),
		'sort' => [
			'defaultOrder' => [
				'created_at' => SORT_DESC
			]
		],
		'pagination' => [
			'pageSize' => 30,
		],
	]);
	?>
    <div class="panel padding10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= \Yii::t('banners-system', 'Statistics')?></h3>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
					<?php \yii\widgets\Pjax::begin(); ?>
					<?= \yii\grid\GridView::widget([
						'dataProvider' => $provider,
						'columns' => [
							'created_at',
							'views',
							'clicks',
						]
					]); ?>
					<?php \yii\widgets\Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>

	<?php $this->endContent() ?>


</div>
