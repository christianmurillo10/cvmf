<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use backend\models\EmployeeBenefitTypes;
?>

<div id="benefitFormID" class="box-body" style="display: <?= $displayBenefitForm ?>">
    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-benefit',
        'widgetItem' => '.employee-benefit',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-benefit',
        'deleteButton' => '.remove-benefit',
        'model' => $modelEmployeeBenefits[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'employee_benefit_type_id',
        ],
    ]); ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th class="text-center" style="width: 80%;">Benfits</th>
                <th class="text-center" style="width: 20%;">
                    <button type="button" class="add-benefit btn btn-success btn-xs"><span class="fa fa-plus"></span></button>
                </th>
            </tr>
        </thead>
        <tbody class="container-benefit">
        <?php foreach ($modelEmployeeBenefits as $i => $modelEmployeeBenefit): ?>
            <tr class="employee-benefit">
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $modelEmployeeBenefit->isNewRecord) {
                            echo Html::activeHiddenInput($modelEmployeeBenefit, "[{$i}]id");
                        }
                    ?>
                    <?= $form->field($modelEmployeeBenefit, "[{$i}]employee_benefit_type_id")->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(EmployeeBenefitTypes::find()->all(), 'id', 'name'),
                        'language' => 'en',
                        'options' => ['placeholder' => 'Choose One'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </td>
                <td class="text-center vcenter">
                    <button type="button" class="remove-benefit btn btn-danger btn-xs"><span class="fa fa-minus"></span></button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php DynamicFormWidget::end(); ?>
</div>