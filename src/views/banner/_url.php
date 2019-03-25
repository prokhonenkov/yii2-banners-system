<?php
	use yii\helpers\Html;

/**
 * @var $model \prokhonenkov\bannerssystem\models\PageUrl
 */
?>
<div class="repeater-content">

    <table>
        <tr>
            <td style="width: 60%;">
                <div class="form-group">

                    <div class="form-group">
                        <label class="control-label"><?=\Yii::t('banners-system', 'Link')?></label>
						<?= Html::activeTextInput($model, "[$k]url", ['class' => 'form-control']) ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <label class="control-label"><?= $model->getAttributeLabel('is_through');?></label>
					<?= Html::activeDropDownList(
						$model,
						"[$k]is_through",
						[\Yii::t('banners-system', 'No'), \Yii::t('banners-system', 'Yes')],
						['class' => 'form-control']
					)?>
                </div>

            </td>
        </tr>
    </table>
</div>