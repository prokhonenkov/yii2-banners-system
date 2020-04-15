<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \prokhonenkov\bannerssystem\helpers\BannerHelper;

/* @var $this yii\web\View */
/* @var $model \prokhonenkov\bannerssystem\models\Banner */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="banner-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-9">
        <div class="widget">
            <div class="widget-content padding">

				<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'html')->widget(\dosamigos\ckeditor\CKEditor::className(), [
					'options' => ['rows' => 6],
					'preset' => 'full',
					'clientOptions' => [
						'allowedContent' => true,
					],
				]) ?>

				<?= Html::activeHiddenInput($model, 'banner_dir')?>

                <div class="panel">
                    <div class="panel panel-default">
                        <div class="panel-heading">
							<?= \Yii::t('banners-system', 'Pages to show banner')?>
                        </div>
                        <br>
                            <div class="row">
                                <div class="col-md-12">
									<?= \prokhonenkov\repeater\widgets\RepeaterWidget::widget([
										'className' => \prokhonenkov\bannerssystem\models\PageUrl::class,
										'modelView' => '@app/vendor/prokhonenkov/yii2-banners-system/src/views/banner/_url.php',
										'models' => $model->urlsList,
									]);?>
                               </div>
                            </div>
                    </div>
                </div>

                <div class="form-group add-banner-btn">
					<?= Html::submitButton(Yii::t('banners-system', 'Save'), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">

        <div class="panel padding10">
            <div class="panel panel-default">
                <div class="panel-heading">
					<?= \Yii::t('banners-system', 'Settings')?>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
						<?= $form->field($model, 'zone_id')->dropDownList(
							\prokhonenkov\bannerssystem\models\Zone::getForDropDown()
						) ?>

						<?= $form->field($model, 'link')->textInput() ?>

						<?= $form->field($model, 'is_active')->dropDownList(BannerHelper::getStatuses()) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel padding10">
            <div class="panel panel-default">
                <div class="panel-heading">
					<?= \Yii::t('banners-system', 'Upload file')?>
                </div>
                <div class="row">
                    <div class="col-md-12">
						<?= $form->field($model, 'file', ['template' => '{input}{error}'])->fileInput() ?>

						<?= Html::button(\Yii::t('banners-system', 'Apply'), [
							'id' => 'upload',
							'class' => 'btn btn-block btn-primary',
							'data-url' => \yii\helpers\Url::to(['/bannerssystem/banner/upload'])
						])?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
