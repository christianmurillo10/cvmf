<?php

namespace backend\controllers;

use Yii;
use common\models\utilities\Utilities;
use backend\models\Destinations;
use backend\models\DestinationsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DestinationsController implements the CRUD actions for Destinations model.
 */
class DestinationsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Destinations models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DestinationsSearch();
        $searchModel->is_deleted = Utilities::NO;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Destinations model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Destinations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Destinations();

        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = Utilities::get_DateTime();

            if ($model->validate()) {
                $model->save();

                Yii::$app->getSession()->setFlash('success', 'Destinations successfully added');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $errors = [];

                foreach($model->errors as $error) {
                    array_push($errors, $error[0]);
                }

                Yii::$app->getSession()->setFlash('error', $errors);
            }
        }
            
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Destinations model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_at = Utilities::get_DateTime();
            
            if ($model->validate()) {
                $model->save();

                Yii::$app->getSession()->setFlash('success', 'Destinations successfully updated');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $errors = [];

                foreach($model->errors as $error) {
                    array_push($errors, $error[0]);
                }

                Yii::$app->getSession()->setFlash('error', $errors);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Destinations model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->is_deleted = Utilities::YES;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Destinations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Destinations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Destinations::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
