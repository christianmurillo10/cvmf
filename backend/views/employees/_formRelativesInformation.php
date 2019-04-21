<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use backend\models\Relationships;
use backend\models\EducationalLevels;

?>

<div class="box box-default collapsed-box">
    <div class="box-header with-border">
        <i class="fa fa-users"></i>
        <h3 class="box-title">Relatives Information:</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    
    <div class="box-body">
        <div class="col-md-12">
            <div class="row">
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper',
                    'widgetBody' => '.container-relative-information',
                    'widgetItem' => '.relative-information',
                    'limit' => 3,
                    'min' => 1,
                    'insertButton' => '.add-relative-information',
                    'deleteButton' => '.remove-relative-information',
                    'model' => $modelEmployeeRelatives[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'name',
                        'work',
                        'company_name',
                        'company_address',
                        'email',
                        'contact_no',
                        'educational_level_id',
                        'relationship_id',
                    ],
                ]); ?>

                <div class="container-relative-information">
                <?php foreach ($modelEmployeeRelatives as $i => $modelEmployeeRelative): ?>
                    <div class="relative-information box box-default">
                        <div class="box-header with-border">
                            <i class="fa fa-user"></i>
                            <h3 class="box-title">Relative</h3>
                            <div class="pull-right">
                                <button type="button" class="add-relative-information btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                <button type="button" class="remove-relative-information btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="box-body">
                            <?php
                                // necessary for update action.
                                if (! $modelEmployeeRelative->isNewRecord) {
                                    echo Html::activeHiddenInput($modelEmployeeRelative, "[{$i}]id");
                                }
                            ?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= $form->field($modelEmployeeRelative, "[{$i}]name")->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($modelEmployeeRelative, "[{$i}]work")->textInput(['maxlength' => true]) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= $form->field($modelEmployeeRelative, "[{$i}]company_name")->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($modelEmployeeRelative, "[{$i}]company_address")->textInput(['maxlength' => true]) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= $form->field($modelEmployeeRelative, "[{$i}]email")->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($modelEmployeeRelative, "[{$i}]contact_no")->textInput(['maxlength' => true]) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= $form->field($modelEmployeeRelative, "[{$i}]relationship_id")->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(Relationships::find()->all(), 'id', 'name'),
                                                'language' => 'en',
                                                'options' => ['placeholder' => 'Choose One'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ]); ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($modelEmployeeRelative, "[{$i}]educational_level_id")->widget(Select2::classname(), [
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
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
                
                <?php DynamicFormWidget::end(); ?>
            </div>
        </div>
    </div>
</div>