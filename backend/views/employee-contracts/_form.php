<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use backend\models\Employees;
use backend\models\Occupations;
use backend\models\Positions;
use backend\models\EmployeeContracts;
use backend\models\EmployeeContractMonths;
use backend\models\EmployeeContractTypes;
use backend\models\EmployeeContractStatuses;

if ($model->employee_contract_type_id == 3) {
    $display = 'none';
    $displayBenefitForm = '';
} else {
    $display = '';
    $displayBenefitForm = 'none';
}

if ($model->status == 2) {
    $displayDateEnd = '';
} else {
    $displayDateEnd = 'none';
}

/* @var $this yii\web\View */
/* @var $model backend\models\EmployeeContracts */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<div class="box-body">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'employee_id')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(Employees::find()->all(), 'id', 'fullname'),
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Choose One', 'disabled' => true],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]); ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'status')->widget(Select2::classname(), [
                                    'data' => EmployeeContracts::get_Statuses(),
                                    'language' => 'en',
                                    'options' => ['onchange' => 'displayDateEnd(this.value)', 'placeholder' => 'Choose One'],
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
                                <?= $form->field($model, 'date_start')->widget(
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
                                <?= $form->field($model, 'date_end', ['options' => ['id' => 'dateEndID', 'style' => "display: {$displayDateEnd}"]])->widget(
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
                                <?= $form->field($model, 'salary')->textInput(['id' => 'salaryID', 'class' => 'form-control text-right', 'oninput' => 'formatNumberWithCommas(this.id, this.value)', 'maxlength' => true]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'occupation_id')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(Occupations::find()->all(), 'id', 'name'),
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Choose One'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]); ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'position_id')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(Positions::find()->all(), 'id', 'name'),
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
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'employee_contract_type_id')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(EmployeeContractTypes::find()->all(), 'id', 'name'),
                                    'language' => 'en',
                                    'options' => ['onchange' => 'displayBenfits(this.value);', 'placeholder' => 'Choose One'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]); ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'employee_contract_month_id', ['options' => ['id' => 'contractMonthID', 'style' => "display: {$display}"]])->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(EmployeeContractMonths::find()->all(), 'id', 'name'),
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
                        <div class="row">
                            <div class="col-md-12">
                                <?= $form->field($model, 'employee_contract_status_id')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(EmployeeContractStatuses::find()->all(), 'id', 'name'),
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Choose One'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <?= $form->field($model, 'file_upload')->fileInput() ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <?= $this->render('_formBenefits', [
                        'modelEmployeeBenefits' => $modelEmployeeBenefits,
                        'displayBenefitForm' => $displayBenefitForm,
                        'form' => $form
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="row">
        <div class="box-footer">
            <?= Html::a('Cancel', ['employee-contracts/index', 'empId' => $_GET['empId']], ['class' => 'btn btn-default']) ?>
            <?= Html::submitButton('Save', ['class' => 'btn btn-success pull-right']) ?>
        </div>
        </div>
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

    function displayBenfits(value) {
        if (value == 3) {
            $("#contractMonthID").hide();
            $("#benefitFormID").show();
        } else {
            $("#contractMonthID").show();
            $("#benefitFormID").hide();
        }
    }

    function displayDateEnd(value) {
        if (value == 2) {
            $("#dateEndID").show();
        } else {
            $("#dateEndID").hide();
        }
    }
</script>