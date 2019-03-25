<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \prokhonenkov\bannerssystem\models\Banner */

$this->title = \Yii::t('banners-system', 'Create Banner');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('banners-system', 'Banners System'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-create">

    <?php $this->beginContent('@prokhonenkov/bannerssystem/views/common/layout.php') ?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    <?php $this->endContent() ?>
</div>
