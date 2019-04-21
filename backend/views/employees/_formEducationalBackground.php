<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use backend\models\EducationalLevels;
use backend\models\EducationalTypes;

?>

<div class="box box-default collapsed-box">
    <div class="box-header with-border">
        <i class="fa fa-building"></i>
        <h3 class="box-title">Educational Background:</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    
    <div class="box-body">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'educational_level_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(EducationalLevels::find()->all(), 'id', 'name'),
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
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper',
                    'widgetBody' => '.container-educational-background',
                    'widgetItem' => '.educational-background',
                    'limit' => 3,
                    'min' => 1,
                    'insertButton' => '.add-educational-background',
                    'deleteButton' => '.remove-educational-background',
                    'model' => $modelEmployeeEducationalBackgrounds[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'year_from',
                        'year_to',
                        'course',
                        'school_name',
                        'school_address',
                        'educational_type_id',
                    ],
                ]); ?>

                <div class="container-educational-background">
                <?php foreach ($modelEmployeeEducationalBackgrounds as $i => $modelEmployeeEducationalBackground): ?>
                    <div class="educational-background box box-default">
                        <div class="box-header with-border">
                            <i class="fa fa-user"></i>
                            <h3 class="box-title">Educational Background</h3>
                            <div class="pull-right">
                                <button type="button" class="add-educational-background btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                <button type="button" class="remove-educational-background btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="box-body">
                            <?php
                                // necessary for update action.
                                if (! $modelEmployeeEducationalBackground->isNewRecord) {
                                    echo Html::activeHiddenInput($modelEmployeeEducationalBackground, "[{$i}]id");
                                }
                            ?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <?= $form->field($modelEmployeeEducationalBackground, "[{$i}]year_from")->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <?= $form->field($modelEmployeeEducationalBackground, "[{$i}]year_to")->textInput(['maxlength' => true]) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= $form->field($modelEmployeeEducationalBackground, "[{$i}]educational_type_id")->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(EducationalTypes::find()->all(), 'id', 'name'),
                                                'language' => 'en',
                                                'options' => ['placeholder' => 'Choose One'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ]); ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($modelEmployeeEducationalBackground, "[{$i}]course")->textInput(['maxlength' => true]) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= $form->field($modelEmployeeEducationalBackground, "[{$i}]school_name")->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($modelEmployeeEducationalBackground, "[{$i}]school_address")->textInput(['maxlength' => true]) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
                
                <?php DynamicFormWidget::end(); ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
            </div>
        </div>
    </div>
</div>