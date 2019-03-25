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
                'attribute' => 'is_active',
                'value' => function($model) {
                    return BannerHelper::getStatuses()[$model->is_active];
                },
                'filter' => BannerHelper::getStatuses()
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
	<?php Pjax::end() ?>

	<?php $this->endContent() ?>
</div>
