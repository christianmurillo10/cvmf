<?php

namespace backend\controllers;

use Yii;
use common\models\utilities\Utilities;
use backend\models\ClientDirectCompanies;
use backend\models\ClientDirectCompaniesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClientDirectCompaniesController implements the CRUD actions for ClientDirectCompanies model.
 */
class ClientDirectCompaniesController extends Controller
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
     * Lists all ClientDirectCompanies models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientDirectCompaniesSearch();
        $searchModel->is_deleted = Utilities::NO;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ClientDirectCompanies model.
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
     * Creates a new ClientDirectCompanies model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ClientDirectCompanies();

        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = Utilities::get_DateTime();

            if ($model->validate()) {
                $model->save();

                Yii::$app->getSession()->setFlash('success', 'ClientDirectCompanies successfully added');
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
     * Updates an existing ClientDirectCompanies model.
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

                Yii::$app->getSession()->setFlash('success', 'ClientDirectCompanies successfully updated');
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
     * Deletes an existing ClientDirectCompanies model.
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
     * Finds the ClientDirectCompanies model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClientDirectCompanies the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClientDirectCompanies::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDropDownClientDirectCompaniesList($clientId)
    {
        $models = ClientDirectCompanies::find()->where(['client_id' => $clientId, 'is_deleted' => Utilities::NO])->all();

        if(sizeof($models) > 0)
        {
            echo "<option value=''>Choose One</option>";
            foreach ($models as $model) {
                echo "<option value='".$model['id']."'>".$model['name']."</option>";
            }
        }
    }
}
