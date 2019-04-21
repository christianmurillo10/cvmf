<?php

namespace backend\controllers;

use Yii;
use common\models\utilities\Utilities;
use backend\models\Trips;
use backend\models\TripsSearch;
use backend\models\TripPersonnels;
use backend\models\TripExpenses;
use backend\models\TripPartitions;
use backend\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;
// use yii\helpers\Json;

/**
 * TripsController implements the CRUD actions for Trips model.
 */
class TripsController extends Controller
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
     * Lists all Trips models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TripsSearch();
        $searchModel->is_deleted = Utilities::NO;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Trips model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $modelPersonnels = TripPersonnels::find()->where(['trip_id' => $model->id, 'is_deleted' => Utilities::NO])->all();
        $modelExpenses = TripExpenses::find()->where(['trip_id' => $model->id, 'is_deleted' => Utilities::NO])->all();
        $modelPartitions = TripPartitions::find()->where(['trip_id' => $model->id, 'is_deleted' => Utilities::NO])->orderBy('id DESC')->limit(1)->one();

        return $this->render('view', [
            'model' => $model,
            'modelPersonnels' => $modelPersonnels,
            'modelExpenses' => $modelExpenses,
            'modelPartitions' => $modelPartitions,
        ]);
    }

    /**
     * Creates a new Trips model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Trips();
        $modelPersonnels = [new TripPersonnels];
        $modelExpenses = [new TripExpenses];

        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = Utilities::get_DateTime();
            $model->user_id = Utilities::get_UserID();
            $model->status = Trips::TRIP_STATUS_NEW;

            // pesonnels
            $modelPersonnels = Model::createMultiple(TripPersonnels::classname());
            Model::loadMultiple($modelPersonnels, Yii::$app->request->post());

            // expenses
            $modelExpenses = Model::createMultiple(TripExpenses::classname());
            Model::loadMultiple($modelExpenses, Yii::$app->request->post());

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelPersonnels) && $valid;
            $valid = Model::validateMultiple($modelExpenses) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        // personnels
                        foreach ($modelPersonnels as $modelPersonnel) {
                            $modelPersonnel->created_at = Utilities::get_DateTime();
                            $modelPersonnel->user_id = Utilities::get_UserID();
                            $modelPersonnel->trip_id = $model->id;

                            if (!($flag = $modelPersonnel->save(false))) {
                                break;
                            }
                        }

                        // expenses
                        foreach ($modelExpenses as $modelExpenses) {
                            $modelExpenses->created_at = Utilities::get_DateTime();
                            $modelExpenses->user_id = Utilities::get_UserID();
                            $modelExpenses->trip_id = $model->id;
                            
                            if (!($flag = $modelExpenses->save(false))) {
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();

                        Yii::$app->getSession()->setFlash('success', 'Trip successfully added');
                        return $this->redirect(['trip-partitions/create', 'tripId' => $model->id]);
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
            'modelPersonnels' => (empty($modelPersonnels)) ? [new TripPersonnels] : $modelPersonnels,
            'modelExpenses' => (empty($modelExpenses)) ? [new TripExpenses] : $modelExpenses,
        ]);
    }

    /**
     * Updates an existing Trips model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelPersonnels = TripPersonnels::find()->where(['trip_id' => $model->id, 'is_deleted' => Utilities::NO])->all();
        $modelExpenses = TripExpenses::find()->where(['trip_id' => $model->id, 'is_deleted' => Utilities::NO])->all();
        $modelPartitions = TripPartitions::find()->where(['trip_id' => $model->id, 'is_deleted' => Utilities::NO])->orderBy('id DESC')->limit(1)->one();

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_at = Utilities::get_DateTime();

            // personnels
            $oldPersonnelIDs = ArrayHelper::map($modelPersonnels, 'id', 'id');
            $modelPersonnels = Model::createMultiple(TripPersonnels::classname(), $modelPersonnels);
            Model::loadMultiple($modelPersonnels, Yii::$app->request->post());
            $deletedPersonnelIDs = array_diff($oldPersonnelIDs, array_filter(ArrayHelper::map($modelPersonnels, 'id', 'id')));

            // expenses
            $oldExpenseIDs = ArrayHelper::map($modelExpenses, 'id', 'id');
            $modelExpenses = Model::createMultiple(TripExpenses::classname(), $modelExpenses);
            Model::loadMultiple($modelExpenses, Yii::$app->request->post());
            $deletedExpenseIDs = array_diff($oldExpenseIDs, array_filter(ArrayHelper::map($modelExpenses, 'id', 'id')));

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelPersonnels) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        // personnel
                        if (! empty($deletedPersonnelIDs)) {
                            foreach ($deletedPersonnelIDs as $deletedPersonnelID) {
                                $modelPersonnelDeleted = TripPersonnels::findOne($deletedPersonnelID);
                                $modelPersonnelDeleted->updated_at = Utilities::get_DateTime();
                                $modelPersonnelDeleted->user_id = Utilities::get_UserID();
                                $modelPersonnelDeleted->is_deleted = Utilities::YES;
    
                                if (!($flag = $modelPersonnelDeleted->save(false))) {
                                    break;
                                }
                            }
                        }

                        foreach ($modelPersonnels as $modelPersonnel) {
                            if ($modelPersonnel->created_at == null) {
                                $modelPersonnel->created_at = Utilities::get_DateTime();
                            } else {
                                $modelPersonnel->updated_at = Utilities::get_DateTime();
                            }
                            $modelPersonnel->created_at = Utilities::get_DateTime();
                            $modelPersonnel->user_id = Utilities::get_UserID();
                            $modelPersonnel->trip_id = $model->id;

                            if (!($flag = $modelPersonnel->save(false))) {
                                break;
                            }
                        }

                        // expense
                        if (! empty($deletedExpenseIDs)) {
                            foreach ($deletedExpenseIDs as $deletedExpenseID) {
                                $modelExpenseDeleted = TripExpenses::findOne($deletedExpenseID);
                                $modelExpenseDeleted->updated_at = Utilities::get_DateTime();
                                $modelExpenseDeleted->user_id = Utilities::get_UserID();
                                $modelExpenseDeleted->is_deleted = Utilities::YES;
    
                                if (!($flag = $modelExpenseDeleted->save(false))) {
                                    break;
                                }
                            }
                        }

                        foreach ($modelExpenses as $modelExpense) {
                            if ($modelExpense->created_at == null) {
                                $modelExpense->created_at = Utilities::get_DateTime();
                            } else {
                                $modelExpense->updated_at = Utilities::get_DateTime();
                            }
                            $modelExpense->user_id = Utilities::get_UserID();
                            $modelExpense->trip_id = $model->id;

                            if (!($flag = $modelExpense->save(false))) {
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();

                        // update personnel, expenses and partitions computations
                        if ($modelPartitions != null || $modelPartitions != '') {
                            $this->updatePersonnelExpensesPartitionsComputations($modelPersonnels, $modelExpenses, $modelPartitions);
                        }

                        Yii::$app->getSession()->setFlash('success', 'Trip successfully updated');
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelPersonnels' => (empty($modelPersonnels)) ? [new TripPersonnels] : $modelPersonnels,
            'modelExpenses' => (empty($modelPersonnels)) ? [new TripExpenses] : $modelExpenses
        ]);
    }

    /**
     * Deletes an existing Trips model.
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
     * Print Trips Details.
     * If printing is successful, the browser will be redirected to the 'print' page.
     * @param integer $id
     * @return mixed
     */
    public function actionPrintTrip($id)
    {
        $model = $this->findModel($id);
        $modelPersonnels = TripPersonnels::find()->where(['trip_id' => $model->id, 'is_deleted' => Utilities::NO])->all();
        $modelExpenses = TripExpenses::find()->where(['trip_id' => $model->id, 'is_deleted' => Utilities::NO])->all();
        $modelPartitions = TripPartitions::find()->where(['trip_id' => $model->id, 'is_deleted' => Utilities::NO])->orderBy('id DESC')->limit(1)->one();
        $countPersonnel = count($modelPersonnels);

        $content = $this->renderPartial('printTrip', [
            'model' => $model,
            'modelPersonnels' => $modelPersonnels,
            'modelExpenses' => $modelExpenses,
            'modelPartitions' => $modelPartitions,
            'countPersonnel' => $countPersonnel,
        ]);

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:18px}',
            'defaultFontSize' => 3,
            'options' => ['title' => 'Trip Report'],
            'methods' => [
                'SetTitle' => 'CVM Transport Services - Trip Report',
                'SetHeader' => ['CVM Transport Services - Trip Report||Generated On: ' . date("M d, Y H:i:s")],
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);

        return $pdf->render();
    }

    /**
     * Finds the Trips model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Trips the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Trips::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function updatePersonnelExpensesPartitionsComputations($modelPersonnels, $modelExpenses, $modelPartitions)
    {
        // personnels computation
        $totalPersonnelProfit = 0;
        foreach ($modelPersonnels as $modelPersonnel) {
            $percentage = TripPersonnels::get_DefaultPercentage($modelPersonnel->role_type);
            $profitAmount = ($modelPartitions->net_amount * $percentage) / 100;
            $totalPersonnelProfit += $profitAmount;

            $modelPersonnel->profit_amount = $profitAmount;
            $modelPersonnel->save();
        }

        // expenses computation
        $totalExpenses = 0;
        foreach($modelExpenses as $modelExpense) {
            $totalExpenses += $modelExpense->amount;
        }

        // partitions computation
        $netAmount = $modelPartitions->gross_amount - $totalExpenses - $modelPartitions->vat_amount - $modelPartitions->maintenance_amount;

        $modelPartitions->total_expense_amount = $totalExpenses;
        $modelPartitions->net_amount = $netAmount;
        $modelPartitions->total_personnel_profit_amount = $totalPersonnelProfit;
        $modelPartitions->net_profit_amount = $netAmount - $totalPersonnelProfit;
        $modelPartitions->save();
    }
}
