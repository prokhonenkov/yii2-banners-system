<?php
/**
 * Created by PhpStorm.
 * User: Arielb
 * Date: 11/24/2016
 * Time: 4:02 PM
 */

namespace prokhonenkov\bannerssystem\widgets;


use relbraun\yii2repeater\RepeaterAsset;
use yii\helpers\Json;

class Repeater extends \relbraun\yii2repeater\Repeater
{
    public function run()
    {
        $view = $this->getView();
        RepeaterAsset::register($view);
        $data = Json::encode(['append' => $this->appendAction, 'remove' => $this->removeAction]);
        echo "<div class='ab-repeater'>";
        echo "<div class='list-area'>";
        foreach($this->models as $k => $model){
            $content = $this->render($this->modelView, array_merge(['model' => $model, 'form' => $this->form, 'k' => $k], $this->additionalData));
            echo $this->render('@app/vendor/relbraun/yii2repeater/views/repeater', ['content' => $content, 'model' => $model, 'k' => $k]);
        }
        echo "</div>
				<a class='btn btn-primary new-repeater' href='javascript:;'>" . \Yii::t('banners-system', 'Add new') . "</a>
			</div>";
        $js = "new window.repeater($data)";
        $this->view->registerJs($js);
    }
}
