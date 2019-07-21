<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use backend\models\Employees;
use backend\models\TripPersonnels;
use backend\models\TaxPercentageLists;
use backend\models\TripPartitions;

/* @var $this yii\web\View */
/* @var $model backend\models\TripPartitions */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="box-body">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="panel box box-default">
                                <div class="box-header with-border">
                                    <i class="fa fa-users"></i>
                                    <h4 class="box-title">Personnel</h4>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?= $form->field($model, 'personnel_commission_type')->radioList(TripPartitions::get_PersonnelCommissionType(), ['itemOptions' => ['id' => 'personnel-commission-type', 'onchange' => 'disablePercentageProfit();']]); ?>
                                        </div>

                                        <?php foreach ($modelPersonnels as $i => $modelPersonnel): ?>
                                            <?php
                                                // necessary for update action.
                                                if (! $modelPersonnel->isNewRecord) {
                                                    echo Html::activeHiddenInput($modelPersonnel, "[{$i}]id");
                                                }
                                            ?>
                                            <div class="col-md-5">
                                                <?= $form->field($modelPersonnel, "[{$i}]employee_id")->widget(Select2::classname(), [
                                                    'data' => ArrayHelper::map(Employees::find()->all(), 'id', 'fullname'),
                                                    'language' => 'en',
                                                    'options' => ['placeholder' => 'Choose One', 'disabled' => true],
                                                    'pluginOptions' => [
                                                        'allowClear' => true
                                                    ],
                                                ]); ?>
                                            </div>
                                            <div class="col-md-3">
                                                <?= $form->field($modelPersonnel, "[{$i}]role_type")->widget(Select2::classname(), [
                                                    'data' => TripPersonnels::get_ActiveRoleType(),
                                                    'language' => 'en',
                                                    'options' => ['placeholder' => 'Choose One', 'disabled' => true],
                                                    'pluginOptions' => [
                                                        'allowClear' => true
                                                    ],
                                                ]); ?>
                                            </div>
                                            <div class="col-md-2">
                                                <?= $form->field($modelPersonnel, "[{$i}]percentage")->textInput(['id' => "percentageID{$i}", 'class' => 'form-control percentage', 'onkeyup' => "computeNetProfitAmount();"]) ?>
                                            </div>
                                            <div class="col-md-2">
                                                <?= $form->field($modelPersonnel, "[{$i}]profit_amount")->textInput(['id' => "profitAmountID{$i}", 'class' => 'form-control text-right personnel-profit-amount', 'oninput' => 'formatNumberWithCommas(this.id, this.value), computeNetProfitAmount();']) ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="panel box box-default">
                                <div class="box-header with-border">
                                    <i class="fa fa-pie-chart"></i>
                                    <h4 class="box-title">Partition</h4>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <?= $form->field($model, 'computation_type')->radioList(TripPartitions::get_ComputationType(), ['itemOptions' => ['id' => 'computation-type', 'onchange' => 'changeComputationNote(); computeNetProfitAmount();']]); ?>
                                        </div>
                                        <div class="col-md-7">
                                            <div>
                                                <span><b>NOTE:</b></span>
                                                <span style="padding-left: 3px; color: red;">Net</span> = <span id="note-net">Gross - (Maintenance + VAT)</span><br/>
                                                <span style="padding-left: 50px; color: red;">Net Profit</span> = <span id="note-net-profit">Net - (Personnel Profit + Expenses)</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <?= $form->field($model, "tax_percentage_id")->widget(Select2::classname(), [
                                                        'data' => ArrayHelper::map(TaxPercentageLists::find()->all(), 'id', 'value'),
                                                        'language' => 'en',
                                                        'options' => ['id' => 'taxPercentageID', 'onchange' => 'computeNetProfitAmount();', 'placeholder' => 'Choose One'],
                                                        'pluginOptions' => [
                                                            'allowClear' => true
                                                        ],
                                                    ]); ?>

                                                    <?= $form->field($model, 'maintenance_type')->radioList(TripPartitions::get_MaintenanceType(), ['itemOptions' => ['id' => 'maintenance-type', 'onchange' => 'displayMaintenancePercentage();']]); ?>

                                                    <?= $form->field($model, 'maintenance_percentage')->textInput(['id' => 'maintenancePercentageID', 'class' => 'form-control text-right', 'oninput' => 'computeMaintenanceAmount()', 'maxlength' => true]) ?>

                                                    <?= $form->field($model, 'maintenance_amount')->textInput(['id' => 'maintenanceAmountID', 'class' => 'form-control text-right', 'oninput' => 'formatNumberWithCommas(this.id, this.value), computeNetProfitAmount();', 'maxlength' => true]) ?>
                                                </div>
                                                <div class="col-md-4">
                                                    <?= $form->field($model, 'gross_amount')->textInput(['id' => 'grossAmountID', 'class' => 'form-control text-right', 'readonly' => true, 'maxlength' => true]) ?>

                                                    <?= $form->field($model, 'vat_amount')->textInput(['id' => 'vatAmountID', 'class' => 'form-control text-right', 'readonly' => true, 'maxlength' => true]) ?>

                                                    <?= $form->field($model, 'total_expense_amount')->textInput(['id' => 'totalExpenseAmountID', 'class' => 'form-control text-right', 'readonly' => true, 'maxlength' => true]) ?>

                                                    <?= $form->field($model, 'total_personnel_profit_amount')->textInput(['id' => 'totalPersonnelProfitAmountID', 'class' => 'form-control text-right', 'readonly' => true, 'maxlength' => true]) ?>
                                                </div>
                                                <div class="col-md-4">
                                                    <?= $form->field($model, 'net_amount')->textInput(['id' => 'netAmountID', 'class' => 'form-control text-right', 'readonly' => true, 'maxlength' => true]) ?>

                                                    <?= $form->field($model, 'net_profit_amount')->textInput(['id' => 'netProfitAmountID', 'class' => 'form-control text-right', 'readonly' => true, 'maxlength' => true]) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box-footer">
        <?= Html::a('Cancel', ['trips/index'], ['class' => 'btn btn-default']) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success pull-right']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
