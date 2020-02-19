<?php
/**
 * Created by PhpStorm.
 * User: prokhonenkov
 * Date: 17.03.19
 * Time: 11:31
 */

namespace prokhonenkov\bannerssystem\controllers;


use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use \prokhonenkov\bannerssystem\assets\BackendAssetBundle;

class BannersSystemController extends Controller
{
	public $layout;

	public function init()
	{
		parent::init(); // TODO: Change the autogenerated stub

		if(!\Yii::$app->request->isAjax) {
			BackendAssetBundle::register($this->view);
			$this->layout = \Yii::$app->getModule('bannersSystem')->layout;
		}
	}

	public function beforeAction($action)
	{
		if(\Yii::$app->controller->action->id != 'set-click' && !\Yii::$app->getModule('bannersSystem')->checkAccess()) {
			throw new ForbiddenHttpException();
		}

		return parent::beforeAction($action); // TODO: Change the autogenerated stub
	}

	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
					'set-click' => ['POST'],
				],
			],
		];
	}

	/**
	 * Deletes an existing Banner model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}
}