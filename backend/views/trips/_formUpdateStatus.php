<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
use backend\models\Trips;

/* @var $this yii\web\View */
/* @var $model backend\models\Positions */
/* @var $form yii\widgets\ActiveForm */

if ($model->status == Trips::TRIP_STATUS_DONE) {
    $displayDoneForm = '';
    $displayDemurrageForm = 'none';
    $displayFoulTripForm = 'none';
} else if ($model->status == Trips::TRIP_STATUS_DEMURRAGE) {
    $displayDoneForm = '';
    $displayDemurrageForm = '';
    $displayFoulTripForm = 'none';
} else if ($model->status == Trips::TRIP_STATUS_FOUL_TRIP) {
    $displayDoneForm = 'none';
    $displayDemurrageForm = 'none';
    $displayFoulTripForm = '';
} else {
    $displayDoneForm = 'none';
    $displayDemurrageForm = 'none';
    $displayFoulTripForm = 'none';
}
?>

<?php $form = ActiveForm::begin(); ?>
<div class="box-body">
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'status')->widget(Select2::classname(), [
                'data' => Trips::get_ActiveStatus(),
                'language' => 'en',
                'options' => ['onchange' => 'hideDisplayByStatus(this.value);', 'placeholder' => 'Choose One'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
        <div id="divDoneID" class="col-md-6" style="display: <?= $displayDoneForm ?>">
            <?= $form->field($model, 'date_delivered')->widget(
                DatePicker::className(), [
                    'inline' => false, 
                    'clientOptions' => [
                        'autoclose' => true,
                        'todayHighlight' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
            ]);?>
        </div>
        <div id="divDemurrageID" class="col-md-12" style="display: <?= $displayDemurrageForm ?>">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($modelDemurrages, 'date_from')->widget(
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
                            <?= $form->field($modelDemurrages, 'date_to')->widget(
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
                        <div class="col-md-6">
                            <?= $form->field($modelDemurrages, 'percentage')->textInput(['id' => 'percentageDemurrageID', 'oninput' => 'computeDemurrageGrossAmount()']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($modelDemurrages, 'days')->textInput(['id' => 'daysDemurrageID', 'oninput' => 'computeDemurrageGrossAmount()']) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($modelDemurrages, 'trip_amount')->textInput(['id' => 'tripAmountDemurrageID', 'class' => 'form-control text-right', 'oninput' => 'computeDemurrageGrossAmount()', 'readonly' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($modelDemurrages, 'gross_amount')->textInput(['id' => 'grossAmountDemurrageID', 'class' => 'form-control text-right', 'placeholder' => '0.00', 'readonly' => true]) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <?= $form->field($modelDemurrages, 'remarks')->textarea(['rows' => 5]) ?>
                </div>
            </div>
        </div>
        <div id="divFoulTripID" class="col-md-12" style="display: <?= $displayFoulTripForm ?>">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($modelFoulTrips, 'date')->widget(
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
                            <?= $form->field($modelFoulTrips, 'percentage')->textInput(['id' => 'percentageFoulTripID', 'oninput' => 'computeFoulTripGrossAmount()']) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($modelFoulTrips, 'trip_amount')->textInput(['id' => 'tripAmountFoulTripID', 'class' => 'form-control text-right', 'oninput' => 'computeFoulTripGrossAmount()', 'readonly' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($modelFoulTrips, 'gross_amount')->textInput(['id' => 'grossAmountFoulTripID', 'class' => 'form-control text-right', 'placeholder' => '0.00', 'readonly' => true]) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <?= $form->field($modelFoulTrips, 'remarks')->textarea(['rows' => 5]) ?>
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

<script>
    function numberWithCommas(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function removeCommas(value) {
        var str = value.split(',').join('');

        return str;
    }

    function formatNumberWithCommas(fieldID, value) {
        var num = numberWithCommas(removeCommas(value));
        
        $('#' + fieldID).val(num);
    }

    function hideDisplayByStatus(value) {
        var done = <?= Trips::TRIP_STATUS_DONE ?>;
        var demurrage = <?= Trips::TRIP_STATUS_DEMURRAGE ?>;
        var foulTrip = <?= Trips::TRIP_STATUS_FOUL_TRIP ?>;

        if (value == done) {
            $('#divDoneID').show();
            $('#divDemurrageID').hide();
            $('#divFoulTripID').hide();
        } else if (value == demurrage) {
            $('#divDoneID').show();
            $('#divDemurrageID').show();
            $('#divFoulTripID').hide();
        } else if (value == foulTrip) {
            $('#divDoneID').hide();
            $('#divDemurrageID').hide();
            $('#divFoulTripID').show();
        } else {
            $('#divDoneID').hide();
            $('#divDemurrageID').hide();
            $('#divFoulTripID').hide();
        }
    }

    function computeDemurrageGrossAmount() {
        var percentage = $('#percentageDemurrageID').val();
        var days = $('#daysDemurrageID').val();
        var tripAmount = parseFloat(removeCommas($('#tripAmountDemurrageID').val()));
        var grossAmount = numberWithCommas(((tripAmount * (percentage * days)) / 100).toFixed(2));

        $('#grossAmountDemurrageID').val(grossAmount)
    }

    function computeFoulTripGrossAmount() {
        var percentage = $('#percentageFoulTripID').val();
        var tripAmount = parseFloat(removeCommas($('#tripAmountFoulTripID').val()));
        var grossAmount = numberWithCommas(((tripAmount * percentage) / 100).toFixed(2));

        $('#grossAmountFoulTripID').val(grossAmount)
    }
</script>