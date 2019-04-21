<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use backend\models\Suffixes;
use common\models\utilities\Utilities;

?>

<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-user"></i>
        <h3 class="box-title">Personal Information:</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    
    <div class="box-body">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'employee_no')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'birthdate')->widget(
                        DatePicker::className(), [
                            'inline' => false, 
                            'clientOptions' => [
                                'autoclose' => true,
                                'todayHighlight' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                    ]);?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'gender_type')->widget(Select2::classname(), [
                        'data' => Utilities::get_ActiveGenderType(),
                        'language' => 'en',
                        'options' => ['placeholder' => 'Choose One'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'civil_status_type')->widget(Select2::classname(), [
                        'data' => Utilities::get_ActiveCivilStatusType(),
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
                    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'middlename')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'suffix_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Suffixes::find()->all(), 'id', 'name'),
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