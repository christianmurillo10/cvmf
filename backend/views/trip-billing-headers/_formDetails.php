<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use backend\models\TripTransactions;
use common\models\utilities\Utilities;
?>

<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-list-alt"></i>
        <h3 class="box-title">Details</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'is_with_others')->radioList(Utilities::get_ActiveSelect(), ['itemOptions' => ['onchange' => 'displayOtherDetails();']]); ?>
    </div>
    
    <div class="box-body table-responsive">
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper',
            'widgetBody' => '.container-detail',
            'widgetItem' => '.trip-detail',
            'limit' => 10,
            'min' => 1,
            'insertButton' => '.add-detail',
            'deleteButton' => '.remove-detail',
            'model' => $modelDetails[0],
            'formId' => 'dynamic-form',
            'formFields' => [
                'gross_amount',
                'other_amount',
                'net_amount',
                'other_remarks',
                'trip_transaction_id',
            ],
        ]); ?>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center" style="width: 25%;">Transaction</th>
                    <th class="text-center" style="width: 15%;">Gross Amount</th>
                    <th class="text-center" style="width: 15%;">Net Amount</th>
                    <th class="text-center others" style="width: 15%;">Other Amount</th>
                    <th class="text-center others" style="width: 25%;">Other Remarks</th>
                    <th class="text-center" style="width: 10%;">
                        <button type="button" class="add-detail btn btn-success btn-xs" onclick="getClientTransactions(); displayOtherDetails()"><span class="fa fa-plus"></span></button>
                    </th>
                </tr>
            </thead>
            <tbody class="container-detail">
            <?php foreach ($modelDetails as $i => $modelDetail): ?>
                <tr class="trip-detail">
                    <td class="vcenter">
                        <?php
                            // necessary for update action.
                            if (! $modelDetail->isNewRecord) {
                                echo Html::activeHiddenInput($modelDetail, "[{$i}]id");
                            }
                        ?>
                        <?= $form->field($modelDetail, "[{$i}]trip_transaction_id")->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(TripTransactions::find()->where(['client_id' => $model->client_id, 'is_deleted' => Utilities::NO])->all(), 'id', 'ref_no'),
                            'language' => 'en',
                            'options' => ['class' => 'trip-transaction', 'placeholder' => 'Choose One'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($modelDetail, "[{$i}]gross_amount")->label(false)->textInput(['maxlength' => true]) ?>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($modelDetail, "[{$i}]net_amount")->label(false)->textInput(['maxlength' => true]) ?>
                    </td>
                    <td class="vcenter others">
                        <?= $form->field($modelDetail, "[{$i}]other_amount")->label(false)->textInput(['maxlength' => true]) ?>
                    </td>
                    <td class="vcenter others">
                        <?= $form->field($modelDetail, "[{$i}]other_remarks")->label(false)->textInput(['maxlength' => true]) ?>
                    </td>
                    <td class="text-center vcenter" style="width: 90px; verti">
                        <button type="button" class="remove-detail btn btn-danger btn-xs"><span class="fa fa-minus"></span></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php DynamicFormWidget::end(); ?>
    </div>
</div>