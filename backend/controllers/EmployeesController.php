<?php

namespace backend\controllers;

use Yii;
use common\models\utilities\Utilities;
use backend\models\Employees;
use backend\models\EmployeesSearch;
use backend\models\EmployeeGovernmentDetails;
use backend\models\EmployeeImages;
use backend\models\EmployeeEducationalBackgrounds;
use backend\models\EmployeeContacts;
use backend\models\EmployeeRelatives;
use backend\models\EmployeeReferences;
use backend\models\Suffixes;
use backend\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * EmployeesController implements the CRUD actions for Employees model.
 */
class EmployeesController extends Controller
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
     * Lists all Employees models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployeesSearch();
        $searchModel->is_deleted = Utilities::NO;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Employees model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $modelEmployeeGovernmentDetails = EmployeeGovernmentDetails::find()->where(['employee_id' => $model->id, 'is_deleted' => Utilities::NO])->orderBy('id DESC')->limit(1)->one();
        $modelEmployeeImages = EmployeeImages::find()->where(['employee_id' => $model->id, 'is_deleted' => Utilities::NO])->orderBy('id DESC')->limit(1)->one();
        $modelEmployeeEducationalBackgrounds = EmployeeEducationalBackgrounds::find()->where(['employee_id' => $model->id, 'is_deleted' => Utilities::NO])->all();
        $modelEmployeeContacts = EmployeeContacts::find()->where(['employee_id' => $model->id, 'is_deleted' => Utilities::NO])->all();
        $modelEmployeeRelatives = EmployeeRelatives::find()->where(['employee_id' => $model->id, 'is_deleted' => Utilities::NO])->all();
        $modelEmployeeReferences = EmployeeReferences::find()->where(['employee_id' => $model->id, 'is_deleted' => Utilities::NO])->all();

        return $this->render('view', [
            'model' => $model,
            'modelEmployeeGovernmentDetails' => $modelEmployeeGovernmentDetails,
            'modelEmployeeImages' => $modelEmployeeImages,
            'modelEmployeeEducationalBackgrounds' => $modelEmployeeEducationalBackgrounds,
            'modelEmployeeContacts' => $modelEmployeeContacts,
            'modelEmployeeRelatives' => $modelEmployeeRelatives,
            'modelEmployeeReferences' => $modelEmployeeReferences,
        ]);
    }

    /**
     * Creates a new Employees model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Employees();
        $modelEmployeeGovernmentDetails = new EmployeeGovernmentDetails();
        $modelEmployeeImages = new EmployeeImages();
        $modelEmployeeEducationalBackgrounds = [new EmployeeEducationalBackgrounds];
        $modelEmployeeContacts = [new EmployeeContacts];
        $modelEmployeeRelatives = [new EmployeeRelatives];
        $modelEmployeeReferences = [new EmployeeReferences];

        // set employee active status to yes
        $model->is_active = Utilities::YES;
        
        if ($model->load(Yii::$app->request->post()) && $modelEmployeeGovernmentDetails->load(Yii::$app->request->post())) {
            $model->created_at = Utilities::get_DateTime();
            $model->user_id = Utilities::get_UserID();

            // educational backgrounds
            $modelEmployeeEducationalBackgrounds = Model::createMultiple(EmployeeEducationalBackgrounds::classname());
            Model::loadMultiple($modelEmployeeEducationalBackgrounds, Yii::$app->request->post());

            // contacts
            $modelEmployeeContacts = Model::createMultiple(EmployeeContacts::classname());
            Model::loadMultiple($modelEmployeeContacts, Yii::$app->request->post());

            // relatives
            $modelEmployeeRelatives = Model::createMultiple(EmployeeRelatives::classname());
            Model::loadMultiple($modelEmployeeRelatives, Yii::$app->request->post());

            // references
            $modelEmployeeReferences = Model::createMultiple(EmployeeReferences::classname());
            Model::loadMultiple($modelEmployeeReferences, Yii::$app->request->post());

            // validate all models
            $valid = $model->validate();

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        // government details
                        $modelEmployeeGovernmentDetails->created_at = Utilities::get_DateTime();
                        $modelEmployeeGovernmentDetails->employee_id = $model->id;
                        $modelEmployeeGovernmentDetails->user_id = Utilities::get_UserID();

                        if (!($flag = $modelEmployeeGovernmentDetails->save(false))) {
                            $transaction->rollBack();
                        }

                        // images
                        //get the instance of the uploaded file
                        $modelEmployeeImages->image_upload = UploadedFile::getInstance($modelEmployeeImages, 'image_upload');

                        if ($modelEmployeeImages->image_upload != '' || $modelEmployeeImages->image_upload != null) {
                            $modelSuffixName = empty($model->suffix_id) ? '' : Suffixes::findOne($model->suffix_id)->name;
                            $imageName = $model->employee_no . '_' . $model->firstname . '_' . $model->middlename . '_' . $model->lastname . '_' . $modelSuffixName;
                            $modelEmployeeImages->image_upload->saveAs('uploads/images/employees/' . $imageName . '.' . $modelEmployeeImages->image_upload->extension);
    
                            //save the path in db column
                            $modelEmployeeImages->file_path = 'uploads/images/employees/';
                            $modelEmployeeImages->file_name = $imageName . '.' . $modelEmployeeImages->image_upload->extension;
    
                            $modelEmployeeImages->created_at = Utilities::get_DateTime();
                            $modelEmployeeImages->employee_id = $model->id;
                            $modelEmployeeImages->user_id = Utilities::get_UserID();
    
                            if (!($flag = $modelEmployeeImages->save(false))) {
                                $transaction->rollBack();
                            }
                        }

                        // educational backgrounds
                        if ($model->educational_level_id != '' || $model->educational_level_id != null) {
                            foreach ($modelEmployeeEducationalBackgrounds as $modelEmployeeEducationalBackground) {
                                $modelEmployeeEducationalBackground->created_at = Utilities::get_DateTime();
                                $modelEmployeeEducationalBackground->employee_id = $model->id;
                                $modelEmployeeEducationalBackground->user_id = Utilities::get_UserID();
    
                                if (!($flag = $modelEmployeeEducationalBackground->save(false))) {
                                    break;
                                }
                            }
                        }

                        // contacts
                        if ($modelEmployeeContacts[0]->name != '' || $modelEmployeeContacts[0]->name != null) {
                            foreach ($modelEmployeeContacts as $modelEmployeeContact) {
                                if ($modelEmployeeContact->name != '' || $modelEmployeeContact->name != null) {
                                    $modelEmployeeContact->created_at = Utilities::get_DateTime();
                                    $modelEmployeeContact->employee_id = $model->id;
                                    $modelEmployeeContact->user_id = Utilities::get_UserID();
        
                                    if (!($flag = $modelEmployeeContact->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }

                        // relatives
                        if ($modelEmployeeRelatives[0]->name != '' || $modelEmployeeRelatives[0]->name != null) {
                            foreach ($modelEmployeeRelatives as $modelEmployeeRelative) {
                                if ($modelEmployeeRelative->name != '' || $modelEmployeeRelative->name != null) {
                                    $modelEmployeeRelative->created_at = Utilities::get_DateTime();
                                    $modelEmployeeRelative->employee_id = $model->id;
                                    $modelEmployeeRelative->user_id = Utilities::get_UserID();

                                    if (!($flag = $modelEmployeeRelative->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }

                        // references
                        if ($modelEmployeeReferences[0]->name != '' || $modelEmployeeReferences[0]->name != null) {
                            foreach ($modelEmployeeReferences as $modelEmployeeReference) {
                                if ($modelEmployeeReference->name != '' || $modelEmployeeReference->name != null) {
                                    $modelEmployeeReference->created_at = Utilities::get_DateTime();
                                    $modelEmployeeReference->employee_id = $model->id;
                                    $modelEmployeeReference->user_id = Utilities::get_UserID();

                                    if (!($flag = $modelEmployeeReference->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();

                        Yii::$app->getSession()->setFlash('success', 'Employee successfully added');
                        return $this->redirect(['view', 'id' => $model->id]);
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
            'modelEmployeeGovernmentDetails' => $modelEmployeeGovernmentDetails,
            'modelEmployeeImages' => $modelEmployeeImages,
            'modelEmployeeEducationalBackgrounds' => (empty($modelEmployeeEducationalBackgrounds)) ? [new EmployeeEducationalBackgrounds] : $modelEmployeeEducationalBackgrounds,
            'modelEmployeeContacts' => (empty($modelEmployeeContacts)) ? [new EmployeeContacts] : $modelEmployeeContacts,
            'modelEmployeeRelatives' => (empty($modelEmployeeRelatives)) ? [new EmployeeRelatives] : $modelEmployeeRelatives,
            'modelEmployeeReferences' => (empty($modelEmployeeReferences)) ? [new EmployeeReferences] : $modelEmployeeReferences,
        ]);
    }

    /**
     * Updates an existing Employees model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelEmployeeGovernmentDetails = EmployeeGovernmentDetails::find()->where(['employee_id' => $model->id, 'is_deleted' => Utilities::NO])->orderBy('id DESC')->limit(1)->one();
        $modelEmployeeImages = EmployeeImages::find()->where(['employee_id' => $model->id, 'is_deleted' => Utilities::NO])->orderBy('id DESC')->limit(1)->one();
        $modelEmployeeImages = (empty($modelEmployeeImages)) ? new EmployeeImages() : $modelEmployeeImages;
        $modelEmployeeEducationalBackgrounds = EmployeeEducationalBackgrounds::find()->where(['employee_id' => $model->id, 'is_deleted' => Utilities::NO])->all();
        $modelEmployeeContacts = EmployeeContacts::find()->where(['employee_id' => $model->id, 'is_deleted' => Utilities::NO])->all();
        $modelEmployeeRelatives = EmployeeRelatives::find()->where(['employee_id' => $model->id, 'is_deleted' => Utilities::NO])->all();
        $modelEmployeeReferences = EmployeeReferences::find()->where(['employee_id' => $model->id, 'is_deleted' => Utilities::NO])->all();

        if ($model->load(Yii::$app->request->post()) && $modelEmployeeGovernmentDetails->load(Yii::$app->request->post())) {
            $model->updated_at = Utilities::get_DateTime();

            // educational backgrounds
            $oldEducationalBackgroundIDs = ArrayHelper::map($modelEmployeeEducationalBackgrounds, 'id', 'id');
            $modelEmployeeEducationalBackgrounds = Model::createMultiple(EmployeeEducationalBackgrounds::classname(), $modelEmployeeEducationalBackgrounds);
            Model::loadMultiple($modelEmployeeEducationalBackgrounds, Yii::$app->request->post());
            $deletedEducationalBackgroundIDs = array_diff($oldEducationalBackgroundIDs, array_filter(ArrayHelper::map($modelEmployeeEducationalBackgrounds, 'id', 'id')));

            // contacts
            $oldContactIDs = ArrayHelper::map($modelEmployeeContacts, 'id', 'id');
            $modelEmployeeContacts = Model::createMultiple(EmployeeContacts::classname(), $modelEmployeeContacts);
            Model::loadMultiple($modelEmployeeContacts, Yii::$app->request->post());
            $deletedContactIDs = array_diff($oldContactIDs, array_filter(ArrayHelper::map($modelEmployeeContacts, 'id', 'id')));

            // relatives
            $oldRelativeIDs = ArrayHelper::map($modelEmployeeRelatives, 'id', 'id');
            $modelEmployeeRelatives = Model::createMultiple(EmployeeRelatives::classname(), $modelEmployeeRelatives);
            Model::loadMultiple($modelEmployeeRelatives, Yii::$app->request->post());
            $deletedRelativeIDs = array_diff($oldRelativeIDs, array_filter(ArrayHelper::map($modelEmployeeRelatives, 'id', 'id')));

            // references
            $oldReferenceIDs = ArrayHelper::map($modelEmployeeReferences, 'id', 'id');
            $modelEmployeeReferences = Model::createMultiple(EmployeeReferences::classname(), $modelEmployeeReferences);
            Model::loadMultiple($modelEmployeeReferences, Yii::$app->request->post());
            $deletedReferenceIDs = array_diff($oldReferenceIDs, array_filter(ArrayHelper::map($modelEmployeeReferences, 'id', 'id')));

            // validate all models
            $valid = $model->validate();

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        // government details
                        $modelEmployeeGovernmentDetails->updated_at = Utilities::get_DateTime();

                        if (!($flag = $modelEmployeeGovernmentDetails->save(false))) {
                            $transaction->rollBack();
                        }

                        // images
                        //get the instance of the uploaded file
                        if ($modelEmployeeImages != '' || $modelEmployeeImages != null) {
                            $modelEmployeeImages->image_upload = UploadedFile::getInstance($modelEmployeeImages, 'image_upload');

                            if ($modelEmployeeImages->image_upload != '' || $modelEmployeeImages->image_upload != null) {
                                $modelSuffixName = empty($model->suffix_id) ? '' : Suffixes::findOne($model->suffix_id)->name;
                                $imageName = $model->employee_no . '_' . $model->firstname . '_' . $model->middlename . '_' . $model->lastname . '_' . $modelSuffixName;
                                $modelEmployeeImages->image_upload->saveAs('uploads/images/employees/' . $imageName . '.' . $modelEmployeeImages->image_upload->extension);
        
                                //save the path in db column
                                $modelEmployeeImages->file_name = $imageName . '.' . $modelEmployeeImages->image_upload->extension;
        
                                if ($modelEmployeeImages->id != '') {
                                    $modelEmployeeImages->updated_at = Utilities::get_DateTime();
                                } else {
                                    $modelEmployeeImages->created_at = Utilities::get_DateTime();
                                    $modelEmployeeImages->file_path = 'uploads/images/employees/';
                                    $modelEmployeeImages->employee_id = $model->id;
                                    $modelEmployeeImages->user_id = Utilities::get_UserID();
                                }
        
                                if (!($flag = $modelEmployeeImages->save(false))) {
                                    $transaction->rollBack();
                                }
                            }
                        }

                        // educational backgrounds
                        if ($model->educational_level_id != '' || $model->educational_level_id != null) {
                            if (! empty($deletedEducationalBackgroundIDs)) {
                                foreach ($deletedEducationalBackgroundIDs as $deletedEducationalBackgroundID) {
                                    $modelEducationalBackgroundDeleted = EmployeeEducationalBackgrounds::findOne($deletedEducationalBackgroundID);
                                    $modelEducationalBackgroundDeleted->updated_at = Utilities::get_DateTime();
                                    $modelEducationalBackgroundDeleted->user_id = Utilities::get_UserID();
                                    $modelEducationalBackgroundDeleted->is_deleted = Utilities::YES;
        
                                    if (!($flag = $modelEducationalBackgroundDeleted->save(false))) {
                                        break;
                                    }
                                }
                            }

                            foreach ($modelEmployeeEducationalBackgrounds as $modelEmployeeEducationalBackground) {
                                if ($modelEmployeeEducationalBackground->created_at == null) {
                                    $modelEmployeeEducationalBackground->created_at = Utilities::get_DateTime();
                                } else {
                                    $modelEmployeeEducationalBackground->updated_at = Utilities::get_DateTime();
                                }
                                $modelEmployeeEducationalBackground->created_at = Utilities::get_DateTime();
                                $modelEmployeeEducationalBackground->user_id = Utilities::get_UserID();
                                $modelEmployeeEducationalBackground->employee_id = $model->id;

                                if (!($flag = $modelEmployeeEducationalBackground->save(false))) {
                                    break;
                                }
                            }
                        }

                        // contacts
                        if ($modelEmployeeContacts[0]->name != '' || $modelEmployeeContacts[0]->name != null) {
                            if (! empty($deletedContactIDs)) {
                                foreach ($deletedContactIDs as $deletedContactID) {
                                    $modelEmployeeContactDeleted = EmployeeContacts::findOne($deletedContactID);
                                    $modelEmployeeContactDeleted->updated_at = Utilities::get_DateTime();
                                    $modelEmployeeContactDeleted->user_id = Utilities::get_UserID();
                                    $modelEmployeeContactDeleted->is_deleted = Utilities::YES;
        
                                    if (!($flag = $modelEmployeeContactDeleted->save(false))) {
                                        break;
                                    }
                                }
                            }

                            foreach ($modelEmployeeContacts as $modelEmployeeContact) {
                                if ($modelEmployeeContact->created_at == null) {
                                    $modelEmployeeContact->created_at = Utilities::get_DateTime();
                                } else {
                                    $modelEmployeeContact->updated_at = Utilities::get_DateTime();
                                }
                                $modelEmployeeContact->created_at = Utilities::get_DateTime();
                                $modelEmployeeContact->user_id = Utilities::get_UserID();
                                $modelEmployeeContact->employee_id = $model->id;

                                if (!($flag = $modelEmployeeContact->save(false))) {
                                    break;
                                }
                            }
                        }

                        // relatives
                        if ($modelEmployeeRelatives[0]->name != '' || $modelEmployeeRelatives[0]->name != null) {
                            if (! empty($deletedReferenceIDs)) {
                                foreach ($deletedReferenceIDs as $deletedReferenceID) {
                                    $modelEmployeeRelativeDeleted = EmployeeRelatives::findOne($deletedReferenceID);
                                    $modelEmployeeRelativeDeleted->updated_at = Utilities::get_DateTime();
                                    $modelEmployeeRelativeDeleted->user_id = Utilities::get_UserID();
                                    $modelEmployeeRelativeDeleted->is_deleted = Utilities::YES;
        
                                    if (!($flag = $modelEmployeeRelativeDeleted->save(false))) {
                                        break;
                                    }
                                }
                            }

                            foreach ($modelEmployeeRelatives as $modelEmployeeRelative) {
                                if ($modelEmployeeRelative->created_at == null) {
                                    $modelEmployeeRelative->created_at = Utilities::get_DateTime();
                                } else {
                                    $modelEmployeeRelative->updated_at = Utilities::get_DateTime();
                                }
                                $modelEmployeeRelative->created_at = Utilities::get_DateTime();
                                $modelEmployeeRelative->user_id = Utilities::get_UserID();
                                $modelEmployeeRelative->employee_id = $model->id;

                                if (!($flag = $modelEmployeeRelative->save(false))) {
                                    break;
                                }
                            }
                        }

                        // references
                        if ($modelEmployeeReferences[0]->name != '' || $modelEmployeeReferences[0]->name != null) {
                            if (! empty($deletedRelativeIDs)) {
                                foreach ($deletedRelativeIDs as $deletedRelativeID) {
                                    $modelEmployeeReferenceDeleted = EmployeeRelatives::findOne($deletedRelativeID);
                                    $modelEmployeeReferenceDeleted->updated_at = Utilities::get_DateTime();
                                    $modelEmployeeReferenceDeleted->user_id = Utilities::get_UserID();
                                    $modelEmployeeReferenceDeleted->is_deleted = Utilities::YES;
        
                                    if (!($flag = $modelEmployeeReferenceDeleted->save(false))) {
                                        break;
                                    }
                                }
                            }

                            foreach ($modelEmployeeReferences as $modelEmployeeReference) {
                                if ($modelEmployeeReference->created_at == null) {
                                    $modelEmployeeReference->created_at = Utilities::get_DateTime();
                                } else {
                                    $modelEmployeeReference->updated_at = Utilities::get_DateTime();
                                }
                                $modelEmployeeReference->created_at = Utilities::get_DateTime();
                                $modelEmployeeReference->user_id = Utilities::get_UserID();
                                $modelEmployeeReference->employee_id = $model->id;

                                if (!($flag = $modelEmployeeReference->save(false))) {
                                    break;
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();

                        Yii::$app->getSession()->setFlash('success', 'Employee successfully updated');
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
            'modelEmployeeGovernmentDetails' => (empty($modelEmployeeGovernmentDetails)) ? new EmployeeGovernmentDetails : $modelEmployeeGovernmentDetails,
            'modelEmployeeImages' => (empty($modelEmployeeImages)) ? new EmployeeImages : $modelEmployeeImages,
            'modelEmployeeEducationalBackgrounds' => (empty($modelEmployeeEducationalBackgrounds)) ? [new EmployeeEducationalBackgrounds] : $modelEmployeeEducationalBackgrounds,
            'modelEmployeeContacts' => (empty($modelEmployeeContacts)) ? [new EmployeeContacts] : $modelEmployeeContacts,
            'modelEmployeeRelatives' => (empty($modelEmployeeRelatives)) ? [new EmployeeRelatives] : $modelEmployeeRelatives,
            'modelEmployeeReferences' => (empty($modelEmployeeReferences)) ? [new EmployeeReferences] : $modelEmployeeReferences,
        ]);
    }

    /**
     * Deletes an existing Employees model.
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
     * Finds the Employees model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employees the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employees::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
