<?php

namespace prokhonenkov\bannerssystem\controllers;

use dosamigos\grid\actions\ToggleAction;
use prokhonenkov\bannerssystem\helpers\BannerHelper;
use prokhonenkov\bannerssystem\models\PageUrl;
use Yii;
use prokhonenkov\bannerssystem\models\Banner;
use prokhonenkov\bannerssystem\models\search\BannerSearch;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * BannerController implements the CRUD actions for Banner model.
 */
class BannerController extends BannersSystemController
{
	public function actions()
	{
		return [
			'add-url' => [
				'class' => 'relbraun\yii2repeater\actions\AppendAction',
				'model' => PageUrl::class,
				'contentPath' => '/banner/_url', //related to current controller
			],
			'remove-url' => [
				'class' => 'relbraun\yii2repeater\actions\DeleteAction',
				'model' => PageUrl::class,
			],
			'toggle' => [
				'class' => ToggleAction::class,
				'modelClass' =>  Banner::class,
				'onValue' => 1,
				'offValue' => 0,
				'scenario' => Banner::SCENARIO_TOGGLE
			],
		];
	}

	/**
	 * Lists all Banner models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new BannerSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render(\Yii::$app->getModule('bannersSystem')->views['banner']['index'], [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Banner model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		return $this->render(\Yii::$app->getModule('bannersSystem')->views['banner']['view'], [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new Banner model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Banner();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		}

		return $this->render(\Yii::$app->getModule('bannersSystem')->views['banner']['create'], [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing Banner model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		}

		return $this->render(\Yii::$app->getModule('bannersSystem')->views['banner']['update'], [
			'model' => $model,
		]);
	}

	/**
	 * Finds the Banner model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Banner the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Banner::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	public function actionUpload($zoneId, $uniqKey)
	{
		\Yii::$app->response->format = Response::FORMAT_JSON;
		try {
			return [
				'success' => true,
				'html' => BannerHelper::upload((int)$zoneId, $uniqKey)
			];

		} catch (\Exception $e) {
			return [
				'sucess' => false,
				'message' => $e->getMessage()
			];
		}
	}

	public function actionSetClick()
	{
		Banner::setClick(\Yii::$app->request->post('id'));
	}
}