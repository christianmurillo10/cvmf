<?php

namespace backend\controllers;

use Yii;
use common\models\utilities\Utilities;
use backend\models\ExpenseLists;
use backend\models\ExpenseListsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ExpenseListsController implements the CRUD actions for ExpenseLists model.
 */
class ExpenseListsController extends Controller
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
     * Lists all ExpenseLists models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExpenseListsSearch();
        $searchModel->is_deleted = Utilities::NO;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ExpenseLists model.
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
     * Creates a new ExpenseLists model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ExpenseLists();

        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = Utilities::get_DateTime();

            if ($model->validate()) {
                $model->save();

                Yii::$app->getSession()->setFlash('success', 'ExpenseLists successfully added');
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
     * Updates an existing ExpenseLists model.
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

                Yii::$app->getSession()->setFlash('success', 'ExpenseLists successfully updated');
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
     * Deletes an existing ExpenseLists model.
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
     * Finds the ExpenseLists model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ExpenseLists the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ExpenseLists::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
