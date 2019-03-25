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
							<?= \Yii::t('banners-system', 'Show on specified pages only')?>
                        </div>
                        <br>
                            <div class="row">
                                <div class="col-md-12">
									<?php echo \prokhonenkov\bannerssystem\widgets\Repeater::widget([
										'modelView' => '/banner/_url',
										'appendAction' => \yii\helpers\Url::to(['add-url']),
										'removeAction' => \yii\helpers\Url::to(['remove-url']),
										'form' => $form,
										'models' => $model->urlsList, //The existing sub models
									]) ?>
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

						<?= Html::button(\Yii::t('banners-system', 'Apply'), ['id' => 'upload', 'class' => 'btn btn-block btn-primary'])?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
