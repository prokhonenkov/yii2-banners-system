<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \prokhonenkov\bannerssystem\helpers\BannerHelper;

/* @var $this yii\web\View */
/* @var $model prokhonenkov\bannerssystem\models\Zone */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zone-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'width')->textInput() ?>

    <?= $form->field($model, 'height')->textInput() ?>

	<?= $form->field($model, 'is_active')->dropDownList(BannerHelper::getStatuses()) ?>

    <div class="form-group">
		<?= Html::submitButton(Yii::t('banners-system', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
