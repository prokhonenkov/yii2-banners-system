<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use \prokhonenkov\bannerssystem\helpers\BannerHelper;

/* @var $this yii\web\View */
/* @var $model prokhonenkov\bannerssystem\models\Zone */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('banners-system', 'Banners System'), 'url' => ['/bannerssystem/banner']];
$this->params['breadcrumbs'][] = ['label' => \Yii::t('banners-system', 'Banner areas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="zone-view">
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
            'width',
            'height',
			[
				'attribute' => 'is_active',
				'value' => BannerHelper::getStatuses()[$model->is_active]
			],
        ],
    ]) ?>

	<?php $this->endContent() ?>
</div>
