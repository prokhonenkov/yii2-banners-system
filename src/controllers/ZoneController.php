<?php

namespace prokhonenkov\bannerssystem\controllers;

use dosamigos\grid\actions\ToggleAction;
use prokhonenkov\bannerssystem\models\search\ZoneSearch;
use Yii;
use prokhonenkov\bannerssystem\models\Zone;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ZoneController implements the CRUD actions for Zone model.
 */
class ZoneController extends BannersSystemController
{
	public function actions()
	{
		return [
			'toggle' => [
				'class' => ToggleAction::class,
				'modelClass' =>  Zone::class,
				'onValue' => 1,
				'offValue' => 0
			],
		];
	}
	/**
	 * Lists all Zone models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new ZoneSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render(\Yii::$app->getModule('bannersSystem')->views['area']['index'], [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Creates a new Zone model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Zone();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		}

		return $this->render(\Yii::$app->getModule('bannersSystem')->views['area']['create'], [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing Zone model.
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

		return $this->render(\Yii::$app->getModule('bannersSystem')->views['area']['update'], [
			'model' => $model,
		]);
	}

	/**
	 * Finds the Zone model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Zone the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Zone::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	/**
	 * Displays a single Zone model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		return $this->render(\Yii::$app->getModule('bannersSystem')->views['area']['view'], [
			'model' => $this->findModel($id),
		]);
	}
}