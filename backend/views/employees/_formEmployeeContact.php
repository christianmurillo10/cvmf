<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use backend\models\Relationships;

?>

<div class="box box-default collapsed-box">
    <div class="box-header with-border">
        <i class="fa fa-phone-square"></i>
        <h3 class="box-title">Employee Contacts:</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    
    <div class="box-body">
        <div class="col-md-12">
            <div class="row">
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper',
                    'widgetBody' => '.container-employee-contact',
                    'widgetItem' => '.employee-contact',
                    'limit' => 3,
                    'min' => 1,
                    'insertButton' => '.add-employee-contact',
                    'deleteButton' => '.remove-employee-contact',
                    'model' => $modelEmployeeContacts[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'name',
                        'address',
                        'contact_no',
                        'relationship_id',
                    ],
                ]); ?>

                <div class="container-employee-contact">
                <?php foreach ($modelEmployeeContacts as $i => $modelEmployeeContact): ?>
                    <div class="employee-contact box box-default">
                        <div class="box-header with-border">
                            <i class="fa fa-user"></i>
                            <h3 class="box-title">Contact</h3>
                            <div class="pull-right">
                                <button type="button" class="add-employee-contact btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                <button type="button" class="remove-employee-contact btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="box-body">
                            <?php
                                // necessary for update action.
                                if (! $modelEmployeeContact->isNewRecord) {
                                    echo Html::activeHiddenInput($modelEmployeeContact, "[{$i}]id");
                                }
                            ?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= $form->field($modelEmployeeContact, "[{$i}]relationship_id")->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(Relationships::find()->all(), 'id', 'name'),
                                                'language' => 'en',
                                                'options' => ['placeholder' => 'Choose One'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ]); ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($modelEmployeeContact, "[{$i}]name")->textInput(['maxlength' => true]) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= $form->field($modelEmployeeContact, "[{$i}]contact_no")->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($modelEmployeeContact, "[{$i}]address")->textInput(['maxlength' => true]) ?>
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