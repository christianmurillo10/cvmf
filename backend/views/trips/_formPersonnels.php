<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use backend\models\Employees;
use backend\models\TripPersonnels;
?>

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

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50%;">Employee</th>
                    <th class="text-center" style="width: 40%;">Role Type</th>
                    <th class="text-center" style="width: 10%;">
                        <button type="button" class="add-personnel btn btn-success btn-xs"><span class="fa fa-plus"></span></button>
                    </th>
                </tr>
            </thead>
            <tbody class="container-personnel">
            <?php foreach ($modelPersonnels as $i => $modelPersonnel): ?>
                <tr class="personnel">
                    <td class="vcenter">
                        <?php
                            // necessary for update action.
                            if (! $modelPersonnel->isNewRecord) {
                                echo Html::activeHiddenInput($modelPersonnel, "[{$i}]id");
                            }
                        ?>
                        <?= $form->field($modelPersonnel, "[{$i}]employee_id")->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Employees::find()->all(), 'id', 'fullname'),
                            'language' => 'en',
                            'options' => ['placeholder' => 'Choose One'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($modelPersonnel, "[{$i}]role_type")->label(false)->widget(Select2::classname(), [
                            'data' => TripPersonnels::get_ActiveRoleType(),
                            'language' => 'en',
                            'options' => ['placeholder' => 'Choose One'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </td>
                    <td class="text-center vcenter" style="width: 90px; verti">
                        <button type="button" class="remove-personnel btn btn-danger btn-xs"><span class="fa fa-minus"></span></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php DynamicFormWidget::end(); ?>
    </div>
</div>