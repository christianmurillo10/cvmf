<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;

?>

<div class="box box-default collapsed-box">
    <div class="box-header with-border">
        <i class="fa fa-briefcase"></i>
        <h3 class="box-title">References:</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    
    <div class="box-body">
        <div class="col-md-12">
            <div class="row">
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper',
                    'widgetBody' => '.container-references',
                    'widgetItem' => '.references',
                    'limit' => 3,
                    'min' => 1,
                    'insertButton' => '.add-references',
                    'deleteButton' => '.remove-references',
                    'model' => $modelEmployeeReferences[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'name',
                        'work',
                        'company_name',
                        'company_address',
                        'email',
                        'contact_no',
                    ],
                ]); ?>

                <div class="container-references">
                <?php foreach ($modelEmployeeReferences as $i => $modelEmployeeReference): ?>
                    <div class="references box box-default">
                        <div class="box-header with-border">
                            <i class="fa fa-user"></i>
                            <h3 class="box-title">Reference</h3>
                            <div class="pull-right">
                                <button type="button" class="add-references btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                <button type="button" class="remove-references btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="box-body">
                            <?php
                                // necessary for update action.
                                if (! $modelEmployeeReference->isNewRecord) {
                                    echo Html::activeHiddenInput($modelEmployeeReference, "[{$i}]id");
                                }
                            ?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= $form->field($modelEmployeeReference, "[{$i}]name")->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($modelEmployeeReference, "[{$i}]work")->textInput(['maxlength' => true]) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= $form->field($modelEmployeeReference, "[{$i}]company_name")->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($modelEmployeeReference, "[{$i}]company_address")->textInput(['maxlength' => true]) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= $form->field($modelEmployeeReference, "[{$i}]contact_no")->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($modelEmployeeReference, "[{$i}]email")->textInput(['maxlength' => true]) ?>
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