<?php

namespace backend\controllers;

use Yii;
use common\models\utilities\Utilities;
use backend\models\EmployeeContracts;
use backend\models\EmployeeContractsSearch;
use backend\models\Employees;
use backend\models\EmployeeSalaries;
use backend\models\EmployeeBenefits;
use backend\models\Suffixes;
use backend\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * EmployeeContractsController implements the CRUD actions for EmployeeContracts model.
 */
class EmployeeContractsController extends Controller
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
     * Lists all EmployeeContracts models.
     * @return mixed
     */
    public function actionIndex($empId)
    {
        $searchModel = new EmployeeContractsSearch();
        $searchModel->is_deleted = Utilities::NO;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $modelEmployees = $model = Employees::findOne($empId);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelEmployees' => $modelEmployees,
        ]);
    }

    /**
     * Displays a single EmployeeContracts model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $empId)
    {
        $model = $this->findModel($id);
        $modelEmployeeBenefits = EmployeeBenefits::find()->where(['employee_contract_id' => $model->id, 'is_deleted' => Utilities::NO])->all();

        return $this->render('view', [
            'model' => $model,
            'modelEmployeeBenefits' => $modelEmployeeBenefits,
        ]);
    }

    /**
     * Creates a new EmployeeContracts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($empId)
    {
        $model = new EmployeeContracts();
        $modelEmployees = Employees::findOne($empId);
        $modelEmployeeSalaries = new EmployeeSalaries();
        $modelEmployeeBenefits = [new EmployeeBenefits];

        $model->employee_id = $empId;
        $model->occupation_id = $modelEmployees->occupation_id;
        $model->position_id = $modelEmployees->position_id;
        $model->status = EmployeeContracts::STATUS_ON_GOING;

        if ($model->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post();

            $model->created_at = Utilities::get_DateTime();
            $model->user_id = Utilities::get_UserID();
            $model->salary = Utilities::setAdvanceNumberFormat($data['EmployeeContracts']['salary']);

            if ($model->employee_contract_type_id == 3) {
                $model->employee_contract_month_id = null;
            }
            
            //get the instance of the uploaded file
            $model->file_upload = UploadedFile::getInstance($model, 'file_upload');
            
            if ($model->file_upload != '' || $model->file_upload != null) {
                $modelSuffixName = empty($modelEmployees->suffix_id) ? '' : Suffixes::findOne($modelEmployees->suffix_id)->name;
                $fileName = $modelEmployees->employee_no . '_' . $modelEmployees->firstname . '_' . $modelEmployees->middlename . '_' . $modelEmployees->lastname . '_' . $modelSuffixName . $model->date_start;

                $model->file_upload->saveAs('uploads/files/employee-contracts/' . $fileName  . '.' . $model->file_upload->extension);
                $model->file_path = 'uploads/files/employee-contracts/';
                $model->file_name = $fileName . '.' . $model->file_upload->extension;
            }

            // educational backgrounds
            $modelEmployeeBenefits = Model::createMultiple(EmployeeBenefits::classname());
            Model::loadMultiple($modelEmployeeBenefits, Yii::$app->request->post());

            // validate all models
            $valid = $model->validate();
            
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        // salaries
                        $modelEmployeeSalaries->created_at = Utilities::get_DateTime();
                        $modelEmployeeSalaries->employee_id = $empId;
                        $modelEmployeeSalaries->employee_contract_id = $model->id;
                        $modelEmployeeSalaries->user_id = Utilities::get_UserID();
                        $modelEmployeeSalaries->date_issued = $model->date_start;
                        $modelEmployeeSalaries->amount = $model->salary;
                        $modelEmployeeSalaries->is_current = Utilities::YES;

                        if (!($flag = $modelEmployeeSalaries->save(false))) {
                            $transaction->rollBack();
                        }

                        // benefits
                        if ($model->employee_contract_type_id == 3) {
                            foreach ($modelEmployeeBenefits as $modelEmployeeBenefit) {
                                $modelEmployeeBenefit->created_at = Utilities::get_DateTime();
                                $modelEmployeeBenefit->employee_id = $empId;
                                $modelEmployeeBenefit->employee_contract_id = $model->id;
                                $modelEmployeeBenefit->user_id = Utilities::get_UserID();
                                $modelEmployeeBenefit->date_issued = $model->date_start;
    
                                if (!($flag = $modelEmployeeBenefit->save(false))) {
                                    break;
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();

                        Yii::$app->getSession()->setFlash('success', 'Employee contract successfully added');
                        return $this->redirect(['employee-contracts/index', 'empId' => $empId]);
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
            'modelEmployees' => $modelEmployees,
            'modelEmployeeBenefits' => (empty($modelEmployeeBenefits)) ? [new EmployeeBenefits] : $modelEmployeeBenefits,
        ]);
    }

    /**
     * Updates an existing EmployeeContracts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $empId)
    {
        $model = $this->findModel($id);
        $modelEmployees = Employees::findOne($empId);
        $modelEmployeeSalaries = EmployeeSalaries::find()->where(['employee_contract_id' => $model->id, 'is_deleted' => Utilities::NO])->orderBy('id DESC')->limit(1)->one();
        $modelEmployeeBenefits = EmployeeBenefits::find()->where(['employee_contract_id' => $model->id, 'is_deleted' => Utilities::NO])->all();

        if ($model->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post();

            $model->updated_at = Utilities::get_DateTime();
            $model->salary = Utilities::setAdvanceNumberFormat($data['EmployeeContracts']['salary']);

            if ($model->employee_contract_type_id == 3) {
                $model->employee_contract_month_id = null;
            }
            
            //get the instance of the uploaded file
            $model->file_upload = UploadedFile::getInstance($model, 'file_upload');
            
            if ($model->file_upload != '' || $model->file_upload != null) {
                $modelSuffixName = empty($modelEmployees->suffix_id) ? '' : Suffixes::findOne($modelEmployees->suffix_id)->name;
                $fileName = $modelEmployees->employee_no . '_' . $modelEmployees->firstname . '_' . $modelEmployees->middlename . '_' . $modelEmployees->lastname . '_' . $modelSuffixName . $model->date_start;

                $model->file_upload->saveAs('uploads/files/employee-contracts/' . $fileName  . '.' . $model->file_upload->extension);
                $model->file_path = 'uploads/files/employee-contracts/';
                $model->file_name = $fileName . '.' . $model->file_upload->extension;
            }

            // benefits
            $oldEmployeeBenefitIDs = ArrayHelper::map($modelEmployeeBenefits, 'id', 'id');
            $modelEmployeeBenefits = Model::createMultiple(EmployeeBenefits::classname(), $modelEmployeeBenefits);
            Model::loadMultiple($modelEmployeeBenefits, Yii::$app->request->post());
            $deletedEmployeeBenefitIDs = array_diff($oldEmployeeBenefitIDs, array_filter(ArrayHelper::map($modelEmployeeBenefits, 'id', 'id')));

            // validate all models
            $valid = $model->validate();
            
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        // salaries
                        $modelEmployeeSalaries->updated_at = Utilities::get_DateTime();
                        $modelEmployeeSalaries->date_issued = $model->date_start;
                        $modelEmployeeSalaries->amount = $model->salary;

                        if (!($flag = $modelEmployeeSalaries->save(false))) {
                            $transaction->rollBack();
                        }
                        
                        // benefits
                        if ($model->employee_contract_type_id == 3) {
                            if (! empty($deletedEmployeeBenefitIDs)) {
                                foreach ($deletedEmployeeBenefitIDs as $deletedEmployeeBenefitID) {
                                    $modelEmployeeBenefitDeleted = EmployeeBenefits::findOne($deletedEmployeeBenefitID);
                                    $modelEmployeeBenefitDeleted->updated_at = Utilities::get_DateTime();
                                    $modelEmployeeBenefitDeleted->user_id = Utilities::get_UserID();
                                    $modelEmployeeBenefitDeleted->is_deleted = Utilities::YES;
        
                                    if (!($flag = $modelEmployeeBenefitDeleted->save(false))) {
                                        break;
                                    }
                                }
                            }

                            foreach ($modelEmployeeBenefits as $modelEmployeeBenefit) {
                                if ($modelEmployeeBenefit->created_at == null) {
                                    $modelEmployeeBenefit->created_at = Utilities::get_DateTime();
                                } else {
                                    $modelEmployeeBenefit->updated_at = Utilities::get_DateTime();
                                }
                                
                                $modelEmployeeBenefit->created_at = Utilities::get_DateTime();
                                $modelEmployeeBenefit->date_issued = $model->date_start;
                                $modelEmployeeBenefit->employee_id = $empId;
                                $modelEmployeeBenefit->employee_contract_id = $model->id;
                                $modelEmployeeBenefit->user_id = Utilities::get_UserID();

                                if (!($flag = $modelEmployeeBenefit->save(false))) {
                                    break;
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();

                        Yii::$app->getSession()->setFlash('success', 'Employee contract successfully updated');
                        return $this->redirect(['view', 'id' => $model->id, 'empId' => $empId]);
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
            'modelEmployees' => $modelEmployees,
            'modelEmployeeBenefits' => (empty($modelEmployeeBenefits)) ? [new EmployeeBenefits] : $modelEmployeeBenefits,
        ]);
    }

    /**
     * Deletes an existing EmployeeContracts model.
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
     * Finds the EmployeeContracts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmployeeContracts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmployeeContracts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDownload($filePath, $fileName)
    {
        $path = Yii::getAlias('@webroot') . '/' . $filePath;
        $file = $path . $fileName;

        if (file_exists($file)) {
            Yii::$app->response->sendFile($file);
        }

    }
}
