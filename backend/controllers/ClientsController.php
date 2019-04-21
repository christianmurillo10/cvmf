<?php

namespace backend\controllers;

use Yii;
use common\models\utilities\Utilities;
use backend\models\Clients;
use backend\models\ClientsSearch;
use backend\models\ClientDirectCompanies;
use backend\models\ClientDirectCompaniesSearch;
use backend\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ClientsController implements the CRUD actions for Clients model.
 */
class ClientsController extends Controller
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
     * Lists all Clients models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientsSearch();
        $searchModel->is_deleted = Utilities::NO;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Clients model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $searchModelClientDirectCompanies = new ClientDirectCompaniesSearch();
        $searchModelClientDirectCompanies->client_id = $model->id;
        $searchModelClientDirectCompanies->is_deleted = Utilities::NO;
        $dataProviderClientDirectCompanies = $searchModelClientDirectCompanies->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $model,
            'searchModelClientDirectCompanies' => $searchModelClientDirectCompanies,
            'dataProviderClientDirectCompanies' => $dataProviderClientDirectCompanies,
        ]);
    }

    /**
     * Creates a new Clients model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Clients();
        $modelClientDirectCompanies = [new ClientDirectCompanies];

        $model->client_type = Clients::CLIENT_TYPE_DIRECT_CONTRACTOR;
        $model->status = Utilities::YES;

        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = Utilities::get_DateTime();
            $model->user_id = Utilities::get_UserID();

            // educational backgrounds
            $modelClientDirectCompanies = Model::createMultiple(ClientDirectCompanies::classname());
            Model::loadMultiple($modelClientDirectCompanies, Yii::$app->request->post());

            $valid = $model->validate();

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if ($model->client_type == Clients::CLIENT_TYPE_SUB_CONTRACTOR) {
                            foreach ($modelClientDirectCompanies as $modelClientDirectCompany) {
                                $modelClientDirectCompany->created_at = Utilities::get_DateTime();
                                $modelClientDirectCompany->client_id = $model->id;
                                $modelClientDirectCompany->user_id = Utilities::get_UserID();
    
                                if (!($flag = $modelClientDirectCompany->save(false))) {
                                    break;
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();

                        Yii::$app->getSession()->setFlash('success', 'Client successfully added');
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
            'modelClientDirectCompanies' => (empty($modelClientDirectCompanies)) ? [new ClientDirectCompanies] : $modelClientDirectCompanies,
        ]);
    }

    /**
     * Updates an existing Clients model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelClientDirectCompanies = ClientDirectCompanies::find()->where(['client_id' => $model->id, 'is_deleted' => Utilities::NO])->all();

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_at = Utilities::get_DateTime();

            // educational backgrounds
            $oldClientDirectCompaniesIDs = ArrayHelper::map($modelClientDirectCompanies, 'id', 'id');
            $modelClientDirectCompanies = Model::createMultiple(ClientDirectCompanies::classname(), $modelClientDirectCompanies);
            Model::loadMultiple($modelClientDirectCompanies, Yii::$app->request->post());
            $deletedClientDirectCompaniesIDs = array_diff($oldClientDirectCompaniesIDs, array_filter(ArrayHelper::map($modelClientDirectCompanies, 'id', 'id')));
            
            // validate all models
            $valid = $model->validate();

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if ($model->client_type == Clients::CLIENT_TYPE_SUB_CONTRACTOR) {
                            if (! empty($deletedClientDirectCompaniesIDs)) {
                                foreach ($deletedClientDirectCompaniesIDs as $deletedClientDirectCompaniesID) {
                                    $modelClientDirectCompaniesDeleted = ClientDirectCompanies::findOne($deletedClientDirectCompaniesID);
                                    $modelClientDirectCompaniesDeleted->updated_at = Utilities::get_DateTime();
                                    $modelClientDirectCompaniesDeleted->user_id = Utilities::get_UserID();
                                    $modelClientDirectCompaniesDeleted->is_deleted = Utilities::YES;
        
                                    if (!($flag = $modelClientDirectCompaniesDeleted->save(false))) {
                                        break;
                                    }
                                }
                            }

                            foreach ($modelClientDirectCompanies as $modelClientDirectCompany) {
                                if ($modelClientDirectCompany->created_at == null) {
                                    $modelClientDirectCompany->created_at = Utilities::get_DateTime();
                                } else {
                                    $modelClientDirectCompany->updated_at = Utilities::get_DateTime();
                                }
                                $modelClientDirectCompany->created_at = Utilities::get_DateTime();
                                $modelClientDirectCompany->client_id = $model->id;
                                $modelClientDirectCompany->user_id = Utilities::get_UserID();

                                if (!($flag = $modelClientDirectCompany->save(false))) {
                                    break;
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();

                        Yii::$app->getSession()->setFlash('success', 'Client successfully updated');
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }

            // if ($model->validate()) {
            //     $model->save();

            //     Yii::$app->getSession()->setFlash('success', 'Client successfully updated');
            //     return $this->redirect(['view', 'id' => $model->id]);
            // } else {
            //     $errors = [];

            //     foreach($model->errors as $error) {
            //         array_push($errors, $error[0]);
            //     }

            //     Yii::$app->getSession()->setFlash('error', $errors);
            // }
        }

        return $this->render('update', [
            'model' => $model,
            'modelClientDirectCompanies' => (empty($modelClientDirectCompanies)) ? [new ClientDirectCompanies] : $modelClientDirectCompanies,
        ]);
    }

    /**
     * Deletes an existing Clients model.
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
     * Finds the Clients model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Clients the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clients::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
