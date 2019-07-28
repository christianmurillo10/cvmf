<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use common\models\utilities\Utilities;
use backend\models\Clients;
use backend\models\PaymentTerms;
use backend\models\Employees;
use backend\models\TripBillingHeaders;

/* @var $this yii\web\View */
/* @var $model backend\models\TripBillingHeaders */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<div class="box-body">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <?= $form->field($model, 'billing_no')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-3 col-md-offset-6">
                            <?= $form->field($model, 'date')->widget(
                                DatePicker::className(), [
                                    'inline' => false, 
                                    'clientOptions' => [
                                        'autoclose' => true,
                                        'todayHighlight' => true,
                                        'format' => 'yyyy-mm-dd'
                                    ]
                            ]);?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <?= $form->field($model, 'client_id')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Clients::find()->all(), 'id', 'name'),
                                'language' => 'en',
                                'options' => ['id' => 'clientID', 'onchange' => 'getClientDetails(); getClientTransactions();', 'placeholder' => 'Choose One'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 'payment_term_id')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(PaymentTerms::find()->all(), 'id', 'name'),
                                'language' => 'en',
                                'options' => ['id' => 'paymentTermID', 'placeholder' => 'Choose One'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 'status')->widget(Select2::classname(), [
                                'data' => TripBillingHeaders::get_ActiveBillingStatus(),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Choose One'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 'total_amount')->textInput(['class' => 'form-control text-right']) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <?= $form->field($model, 'prepared_by')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Employees::find()->all(), 'id', 'fullname'),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Choose One'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 'noted_by')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Employees::find()->all(), 'id', 'fullname'),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Choose One'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <?= $this->render('_formDetails', [
                        'form' => $form,
                        'model' => $model,
                        'modelDetails' => $modelDetails,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="box-footer">
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success pull-right']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>