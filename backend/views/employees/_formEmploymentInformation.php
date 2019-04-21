<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use backend\models\Occupations;
use backend\models\Positions;
use backend\models\EmployeeDepartments;
use backend\models\PayRateTypes;
use backend\models\EmploymentStatuses;
use backend\models\EmployeeGovernmentDetails;

?>

<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-folder"></i>
        <h3 class="box-title">Employment Information:</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    
    <div class="box-body">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'employment_status_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(EmploymentStatuses::find()->all(), 'id', 'name'),
                        'language' => 'en',
                        'options' => ['placeholder' => 'Choose One'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'pay_rate_type_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(PayRateTypes::find()->all(), 'id', 'name'),
                        'language' => 'en',
                        'options' => ['placeholder' => 'Choose One'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'employee_department_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(EmployeeDepartments::find()->all(), 'id', 'name'),
                        'language' => 'en',
                        'options' => ['placeholder' => 'Choose One'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'occupation_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Occupations::find()->all(), 'id', 'name'),
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
                <div class="col-md-3">
                    <?= $form->field($model, 'position_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Positions::find()->all(), 'id', 'name'),
                        'language' => 'en',
                        'options' => ['placeholder' => 'Choose One'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($modelEmployeeGovernmentDetails, 'tin_no')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($modelEmployeeGovernmentDetails, 'sss_no')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($modelEmployeeGovernmentDetails, 'pagibig_no')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($modelEmployeeGovernmentDetails, 'philhealth_no')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>
</div>