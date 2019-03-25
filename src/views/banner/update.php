<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \prokhonenkov\bannerssystem\models\Banner */

$this->title = $this->title = \Yii::t('banners-system', 'Update Banner') . ': ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('banners-system', 'Banners System'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = \Yii::t('banners-system', 'Update');
?>
<div class="banner-update">

	<?php $this->beginContent('@prokhonenkov/bannerssystem/views/common/layout.php') ?>
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
	<?php $this->endContent() ?>

</div>
