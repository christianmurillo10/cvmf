<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;

?>

<div class="box-body table-responsive">
    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-direct-company',
        'widgetItem' => '.direct-company',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-direct-company',
        'deleteButton' => '.remove-direct-company',
        'model' => $modelClientDirectCompanies[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'name',
            'email',
            'contact_no',
        ],
    ]); ?>

    <div class="container-direct-company">
    <?php foreach ($modelClientDirectCompanies as $i => $modelClientDirectCompany): ?>
        <div class="direct-company box box-default">
            <div class="box-header with-border">
                <i class="fa fa-user"></i>
                <h3 class="box-title">Client Direct Company</h3>
                <div class="pull-right">
                    <button type="button" class="add-direct-company btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                    <button type="button" class="remove-direct-company btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="box-body">
                <?php
                    // necessary for update action.
                    if (! $modelClientDirectCompany->isNewRecord) {
                        echo Html::activeHiddenInput($modelClientDirectCompany, "[{$i}]id");
                    }
                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($modelClientDirectCompany, "[{$i}]name")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($modelClientDirectCompany, "[{$i}]contact_no")->textInput(['maxlength' => true]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <?= $form->field($modelClientDirectCompany, "[{$i}]email")->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
                
    <?php DynamicFormWidget::end(); ?>
</div>
