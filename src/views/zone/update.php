<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model prokhonenkov\bannerssystem\models\Zone */

$this->title = \Yii::t('banners-system', 'Update banners area') . ': ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('banners-system', 'Banners System'), 'url' => ['/bannerssystem/banner']];
$this->params['breadcrumbs'][] = ['label' => \Yii::t('banners-system', 'Banner areas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = \Yii::t('banners-system', 'Update');
?>
<div class="zone-update">

	<?php $this->beginContent('@prokhonenkov/bannerssystem/views/common/layout.php') ?>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
	<?php $this->endContent() ?>
</div>
