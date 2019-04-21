<?php

namespace backend\controllers;

use Yii;
use common\models\utilities\Utilities;
use backend\models\TripPartitions;
use backend\models\TripPartitionsSearch;
use backend\models\Trips;
use backend\models\TripPersonnels;
use backend\models\TripExpenses;
use backend\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TripPartitionsController implements the CRUD actions for TripPartitions model.
 */
class TripPartitionsController extends Controller
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
     * Lists all TripPartitions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TripPartitionsSearch();
        $searchModel->is_deleted = Utilities::NO;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TripPartitions model.
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
     * Creates a new TripPartitions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($tripId)
    {
        $model = TripPartitions::find()->where(['trip_id' => $tripId, 'is_deleted' => Utilities::NO])->orderBy('id DESC')->limit(1)->one();

        // validate partitions model
        if ($model != null || $model != '') {
            $model->vat_amount = Utilities::setNumberFormat($model->vat_amount, 2);
            $model->maintenance_amount = Utilities::setNumberFormat($model->maintenance_amount, 2);
            $model->net_amount = Utilities::setNumberFormat($model->net_amount, 2);
            $model->total_personnel_profit_amount = Utilities::setNumberFormat($model->total_personnel_profit_amount, 2);
            $model->net_profit_amount = Utilities::setNumberFormat($model->net_profit_amount, 2);
        } else {
            $model = new TripPartitions();
        }

        $modelTrips = Trips::findOne($tripId);
        $modelPersonnels = TripPersonnels::find()->where(['trip_id' => $tripId, 'is_deleted' => Utilities::NO])->all();
        $modelExpenses = TripExpenses::find()->where(['trip_id' => $tripId, 'is_deleted' => Utilities::NO])->all();

        $totalExpenses = 0;

        foreach($modelExpenses as $modelExpense) {
            $totalExpenses += $modelExpense->amount;
        }

        $model->gross_amount = Utilities::setNumberFormat($modelTrips->amount, 2);
        $model->total_expense_amount = Utilities::setNumberFormat($totalExpenses, 2);

        if ($model->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post();

            // partitions
            if ($model->created_at == null) {
                $model->created_at = Utilities::get_DateTime();
            } else {
                $model->updated_at = Utilities::get_DateTime();
            }
            $model->gross_amount = Utilities::setAdvanceNumberFormat($modelTrips->amount);
            $model->total_expense_amount = Utilities::setAdvanceNumberFormat($totalExpenses);
            $model->vat_amount = Utilities::setAdvanceNumberFormat($data['TripPartitions']['vat_amount']);
            $model->maintenance_amount = Utilities::setAdvanceNumberFormat($data['TripPartitions']['maintenance_amount']);
            $model->net_amount = Utilities::setAdvanceNumberFormat($data['TripPartitions']['net_amount']);
            $model->total_personnel_profit_amount = Utilities::setAdvanceNumberFormat($data['TripPartitions']['total_personnel_profit_amount']);
            $model->net_profit_amount = Utilities::setAdvanceNumberFormat($data['TripPartitions']['net_profit_amount']);
            $model->user_id = Utilities::get_UserID();
            $model->trip_id = $tripId;

            $modelPersonnels = Model::createMultiple(TripPersonnels::classname(), $modelPersonnels);
            Model::loadMultiple($modelPersonnels, Yii::$app->request->post());
            
            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelPersonnels) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        $i = 0;

                        // personnels
                        foreach ($modelPersonnels as $modelPersonnel) {
                            $modelPersonnel->updated_at = Utilities::get_DateTime();
                            $modelPersonnel->percentage = Utilities::setAdvanceNumberFormat($data['TripPersonnels'][$i]['percentage']);
                            $modelPersonnel->profit_amount = Utilities::setAdvanceNumberFormat($data['TripPersonnels'][$i]['profit_amount']);

                            $i++;
                            if (!($flag = $modelPersonnel->save(false))) {
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['trips/view', 'id' => $model->trip_id]);
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
            'modelPersonnels' => $modelPersonnels,
        ]);
    }

    /**
     * Updates an existing TripPartitions model.
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

                Yii::$app->getSession()->setFlash('success', 'TripPartitions successfully updated');
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
     * Deletes an existing TripPartitions model.
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
     * Finds the TripPartitions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TripPartitions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TripPartitions::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
