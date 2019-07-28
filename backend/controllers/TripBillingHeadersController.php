<?php

namespace backend\controllers;

use Yii;
use common\models\utilities\Utilities;
use backend\models\TripBillingHeaders;
use backend\models\TripBillingHeadersSearch;
use backend\models\TripBillingDetails;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TripBillingHeadersController implements the CRUD actions for TripBillingHeaders model.
 */
class TripBillingHeadersController extends Controller
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
     * Lists all TripBillingHeaders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TripBillingHeadersSearch();
        $searchModel->is_deleted = Utilities::NO;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TripBillingHeaders model.
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
     * Creates a new TripBillingHeaders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TripBillingHeaders();
        $modelDetails = [new TripBillingDetails];

        // default value
        $model->status = TripBillingHeaders::BILLING_STATUS_NEW;
        $model->is_with_others = Utilities::NO;

        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = Utilities::get_DateTime();
            $model->user_id = Utilities::get_UserID();

            // details
            $modelDetails = Model::createMultiple(TripBillingDetails::classname());
            Model::loadMultiple($modelDetails, Yii::$app->request->post());

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelDetails) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        // details
                        foreach ($modelDetails as $modelDetail) {
                            $modelDetail->created_at = Utilities::get_DateTime();
                            $modelDetail->header_id = $model->id;
                            $modelDetail->user_id = Utilities::get_UserID();
                            
                            if (!($flag = $modelExpenses->save(false))) {
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();

                        Yii::$app->getSession()->setFlash('success', 'Trip Billing successfully added');
                        return $this->redirect(['trip-billing-headers/view', 'id' => $model->id]);
                    } else {
                        $transaction->rollBack();
                    }

                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
            
        return $this->render('create', [
            'model' => $model,
            'modelDetails' => (empty($modelDetails)) ? [new TripBillingDetails] : $modelDetails,
        ]);
    }

    /**
     * Updates an existing TripBillingHeaders model.
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

                Yii::$app->getSession()->setFlash('success', 'TripBillingHeaders successfully updated');
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
     * Deletes an existing TripBillingHeaders model.
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
     * Finds the TripBillingHeaders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TripBillingHeaders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TripBillingHeaders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
