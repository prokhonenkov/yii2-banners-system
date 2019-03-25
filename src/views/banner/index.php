<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel \prokhonenkov\bannerssystem\models\search\BannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::t('banners-system', 'Banners System');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-index">

	<?php $this->beginContent('@prokhonenkov/bannerssystem/views/common/layout.php', ['isMenu' => true]) ?>

        <?php Pjax::begin() ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'title',
                    [
                        'attribute' => 'zone_id',
                        'value' => function($model){
                            return $model->zone->title;
                        },
                        'filter' => \prokhonenkov\bannerssystem\models\Zone::getForDropDown()
                    ],
                    'link',
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
