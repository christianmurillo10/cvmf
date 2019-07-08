<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use backend\models\ExpenseLists;
use backend\models\TripExpenses;
use common\models\utilities\Utilities;
?>

<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-list-alt"></i>
        <h3 class="box-title">Expenses</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    
    <div class="box-body table-responsive">
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper',
            'widgetBody' => '.container-expense',
            'widgetItem' => '.trip-expense',
            'limit' => 10,
            'min' => 1,
            'insertButton' => '.add-expense',
            'deleteButton' => '.remove-expense',
            'model' => $modelExpenses[0],
            'formId' => 'dynamic-form',
            'formFields' => [
                'expense_type',
                'expense_list_id',
                'amount',
                'remarks',
                'is_refundable',
                'is_claimed',
            ],
        ]); ?>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center" style="width: 10%;">Type</th>
                    <th class="text-center" style="width: 22%;">List</th>
                    <th class="text-center" style="width: 10%;">Amount</th>
                    <th class="text-center" style="width: 28%;">Remarks</th>
                    <th class="text-center" style="width: 10%;">Refundable?</th>
                    <th class="text-center" style="width: 10%;">Claimed?</th>
                    <th class="text-center" style="width: 10%;">
                        <button type="button" class="add-expense btn btn-success btn-xs"><span class="fa fa-plus"></span></button>
                    </th>
                </tr>
            </thead>
            <tbody class="container-expense">
            <?php foreach ($modelExpenses as $i => $modelExpense): ?>
                <tr class="trip-expense">
                    <td class="vcenter">
                        <?php
                            // necessary for update action.
                            if (! $modelExpense->isNewRecord) {
                                echo Html::activeHiddenInput($modelExpense, "[{$i}]id");
                            }
                        ?>
                        <?= $form->field($modelExpense, "[{$i}]expense_type")->label(false)->widget(Select2::classname(), [
                            'data' => TripExpenses::get_ActiveExpenseType(),
                            'language' => 'en',
                            'options' => ['placeholder' => 'Choose One'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($modelExpense, "[{$i}]expense_list_id")->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(ExpenseLists::find()->all(), 'id', 'name'),
                            'language' => 'en',
                            'options' => ['placeholder' => 'Choose One'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($modelExpense, "[{$i}]amount")->label(false)->textInput(['maxlength' => true]) ?>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($modelExpense, "[{$i}]remarks")->label(false)->textInput(['maxlength' => true]) ?>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($modelExpense, "[{$i}]is_refundable")->label(false)->widget(Select2::classname(), [
                            'data' => Utilities::get_ActiveSelect(),
                            'language' => 'en',
                            'options' => ['placeholder' => 'Choose One'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($modelExpense, "[{$i}]is_claimed")->label(false)->widget(Select2::classname(), [
                            'data' => Utilities::get_ActiveSelect(),
                            'language' => 'en',
                            'options' => ['placeholder' => 'Choose One'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </td>
                    <td class="text-center vcenter" style="width: 90px; verti">
                        <button type="button" class="remove-expense btn btn-danger btn-xs"><span class="fa fa-minus"></span></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php DynamicFormWidget::end(); ?>
    </div>
</div>