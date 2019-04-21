<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use backend\models\Employees;
use backend\models\TripPersonnels;
?>

<style>
    .box-body {
        padding-bottom: 0px;
    }
</style>

<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-users"></i>
        <h3 class="box-title">Personnels</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    
    <div class="box-body">
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper',
            'widgetBody' => '.container-personnel',
            'widgetItem' => '.personnel',
            'limit' => 3,
            'min' => 1,
            'insertButton' => '.add-personnel',
            'deleteButton' => '.remove-personnel',
            'model' => $modelPersonnels[0],
            'formId' => 'dynamic-form',
            'formFields' => [
                'employee_id',
                'role_type',
            ],
        ]); ?>

        <div class="container-personnel">
        <?php foreach ($modelPersonnels as $i => $modelPersonnel): ?>
            <div class="personnel box box-default">
                <div class="box-header with-border">
                    <i class="fa fa-user"></i>
                    <h3 class="box-title">Personnel</h3>
                    <div class="pull-right">
                        <button type="button" class="add-personnel btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                        <button type="button" class="remove-personnel btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="box-body">
                    <?php
                        // necessary for update action.
                        if (! $modelPersonnel->isNewRecord) {
                            echo Html::activeHiddenInput($modelPersonnel, "[{$i}]id");
                        }
                    ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <?= $form->field($modelPersonnel, "[{$i}]employee_id")->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Employees::find()->all(), 'id', 'fullname'),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Choose One'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($modelPersonnel, "[{$i}]role_type")->widget(Select2::classname(), [
                                'data' => TripPersonnels::get_ActiveRoleType(),
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
        <?php endforeach; ?>
        </div>
        <?php DynamicFormWidget::end(); ?>
    </div>
</div>