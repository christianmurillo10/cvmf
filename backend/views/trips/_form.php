<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use common\models\utilities\Utilities;
use backend\models\Clients;
use backend\models\Vehicles;
use backend\models\Destinations;
use backend\models\Trips;
use backend\models\ClientDirectCompanies;

/* @var $this yii\web\View */
/* @var $model backend\models\Trips */
/* @var $form yii\widgets\ActiveForm */

if ($model->status == Trips::TRIP_STATUS_DONE) {
    $disabledDateDelivered = false;
} else {
    $disabledDateDelivered = true;
}

if ($model->client_id) {
    if (Clients::findOne($model->client_id)->client_type == Clients::CLIENT_TYPE_SUB_CONTRACTOR) {
        $diplayClientDirectCompany = '';
    } else {
        $diplayClientDirectCompany = 'none';
    }
} else {
    $diplayClientDirectCompany = 'none';
}

?>

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<div class="box-body">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'trip_no')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'date_issued')->widget(
                                DatePicker::className(), [
                                    'inline' => false, 
                                    'clientOptions' => [
                                        'autoclose' => true,
                                        'todayHighlight' => true,
                                        'format' => 'yyyy-mm-dd'
                                    ]
                            ]);?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'date_delivered')->widget(
                                DatePicker::className(), [
                                    'inline' => false, 
                                    'clientOptions' => [
                                        'autoclose' => true,
                                        'todayHighlight' => true,
                                        'format' => 'yyyy-mm-dd'
                                    ],
                                    'options' => [
                                        'id' => 'dateDeliveredID',
                                        'disabled' => $disabledDateDelivered
                                    ]
                            ]);?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <?= $form->field($model, 'destination_from_id')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Destinations::find()->all(), 'id', 'name'),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Choose One'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 'destination_to_id')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Destinations::find()->all(), 'id', 'name'),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Choose One'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'client_id')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Clients::find()->all(), 'id', 'name'),
                                'language' => 'en',
                                'options' => ['onchange' => 'getClientDirectCompany(this.value)', 'placeholder' => 'Choose One'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-3">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-md-offset-6">
                    <div class="row">
                        <div id="clientDirectCompanyID" class="col-md-6" style="display : <?= $diplayClientDirectCompany ?>">
                            <?= $form->field($model, 'client_direct_company_id')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(ClientDirectCompanies::find()->where(['client_id' => $model->client_id, 'is_deleted' => Utilities::NO])->all(), 'id', 'name'),
                                'language' => 'en',
                                'options' => ['id' => 'clientDirectCompanyValueID', 'placeholder' => 'Choose One'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'remarks')->textarea(['rows' => 5]) ?>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 'vehicle_id')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Vehicles::find()->all(), 'id', 'plate_no'),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Choose One'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 'status')->widget(Select2::classname(), [
                                'data' => Trips::get_ActiveStatus(),
                                'language' => 'en',
                                'options' => ['onchange' => 'disableEnableByStatus(this.value);', 'placeholder' => 'Choose One'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-3 col-md-offset-3">
                            <?= $form->field($model, 'amount')->textInput(['class' => 'form-control text-right']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-md-offset-3">
            <?= $this->render('_formPersonnels', [
                'form' => $form,
                'modelPersonnels' => $modelPersonnels,
            ]) ?>
        </div>

        <div class="col-md-12">
            <?= $this->render('_formExpenses', [
                'form' => $form,
                'modelExpenses' => $modelExpenses,
            ]) ?>
        </div>
    </div>
    <div class="box-footer">
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success pull-right']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<script>
    function disableEnableByStatus(value) {
        var done = <?= Trips::TRIP_STATUS_DONE ?>;

        if (value == done) {
            $('#dateDeliveredID').attr('disabled', false);
        } else {
            $('#dateDeliveredID').attr('disabled', true);
        }
    }

    function getClientDirectCompany(value) {
        $.ajax({
            url: "?r=client-direct-companies/list",
            type: 'GET',
            data: {"clientId" : value},
            success: function(data) {
                if (data != '') {
                    $("#clientDirectCompanyID").show();
                    $( "select#clientDirectCompanyValueID" ).html(data);
                } else {
                    $("#clientDirectCompanyID").hide();
                    $("#clientDirectCompanyID").val('');
                }
            }
        });
    }
</script>