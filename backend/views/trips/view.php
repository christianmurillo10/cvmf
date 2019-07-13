<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Trips;
use backend\models\TripExpenses;
use backend\models\TripPersonnels;
use backend\models\TripPartitions;
use common\models\utilities\Utilities;

/* @var $this yii\web\View */
/* @var $model backend\models\Trips */

$this->title = 'Trips';
$this->params['breadcrumbs'][] = ['label' => 'Trips', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'View: ' . $model->trip_no;
?>

<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-list-alt"></i>
            <h3 class="box-title">View: DR#<?= $model->trip_no ?></h3>

            <div class="pull-right box-tools">
                <?= Html::a('<i class="fa fa-arrow-left"></i>', ['index'], ['class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip', 'title' => 'Back']) ?>
            </div>
        </div>

        <div class="box-body">
            <div class="col-md-12 well well-sm no-shadow">
                <div class="row">
                    <div class="col-sm-3">
                        <b>DR:</b> #<?= $model->trip_no ?><br>
                        <b>Client:</b> <?= $model->client->name ?><br>
                        <b>Vehicle:</b> <?= $model->vehicle->plate_no ?><br>
                        <b>Status:</b> <?= $model->coloredStatus ?>
                    </div>
                    <div class="col-sm-3">
                        <b>Date Issued:</b> <?= $model->date_issued ? Utilities::setDateStandard($model->date_issued) : $model->date_issued ?><br>
                        <b>Date Delivered:</b> <?= $model->date_delivered ? Utilities::setDateStandard($model->date_delivered) : $model->date_delivered ?><br>
                        <b>Destination From:</b> <?= $model->destinationFrom->name ?><br>
                        <b>Destination To:</b> <?= $model->destinationTo->name ?><br>
                    </div>
                    <div class="col-sm-3">
                        <b>Amount:</b> <?= Utilities::setNumberFormatWithPeso($model->amount, 2); ?><br>
                        <b>Remarks:</b> <?= $model->remarks ?><br>
                    </div>
                    <div class="col-sm-3">
                        <?php foreach($modelPersonnels as $personnel): ?>
                        <b><?= TripPersonnels::get_ActiveRoleType($personnel->role_type) ?>: </b> <?= $personnel->employee->fullname ?>
                        <br>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>

            <br>
            <div class="col-md-12 table-responsive">
                <div class="row">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 15%">Type</th>
                                <th style="width: 15%">Expense</th>
                                <th style="width: 15%">Amount</th>
                                <th class="text-center" style="width: 10%">Refundable?</th>
                                <th class="text-center" style="width: 10%">Claimed?</th>
                                <th style="width: 35%">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($modelExpenses as $expense): ?>
                            <tr>
                                <td><?= TripExpenses::get_ActiveExpenseType($expense->expense_type) ?></td>
                                <td><?= $expense->expenseList->name ?></td>
                                <td><?= Utilities::setNumberFormatWithPeso($expense->amount, 2); ?></td>
                                <td class="text-center"><?= Utilities::get_ActiveSelect($expense->is_refundable) ?></td>
                                <td class="text-center"><?= Utilities::get_ActiveSelect($expense->is_claimed) ?></td>
                                <td><?= $expense->remarks ?></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 col-md-push-8">
                    <div class="table-responsive">
                        <table class="table">
                            <!-- Partition -->
                            <tr>
                                <th style="width:50%">Total Gross:</th>
                                <td class="text-right"><?= Utilities::setNumberFormatWithPeso($modelPartitions->gross_amount, 2); ?></td>
                            </tr>
                            <tr>
                                <th>VAT/Tax (<?= $modelPartitions->tax_percentage_id == null ? 0 : $modelPartitions->taxPercentage->value; ?>%)</th>
                                <td class="text-right">(<?= Utilities::setNumberFormatWithPeso($modelPartitions->vat_amount, 2); ?>)</td>
                            </tr>
                            <tr>
                                <th>Maintenance:</th>
                                <td class="text-right">(<?= Utilities::setNumberFormatWithPeso($modelPartitions->maintenance_amount, 2); ?>)</td>
                            </tr>
                            <?php if ($modelPartitions->computation_type == TripPartitions::COMPUTATION_TYPE_2): ?>
                            <tr>
                                <th style="width:50%">Total Expenses:</th>
                                <td class="text-right">(<?= Utilities::setNumberFormatWithPeso($modelPartitions->total_expense_amount, 2); ?>)</td>
                            </tr>
                            <?php endif; ?>

                            <tr>
                                <th></th>
                                <th><hr style="margin-top: 5px; border-top: 1px solid #333;"/></th>
                            </tr>
                            <!-- Total -->
                            <tr>
                                <th>Total Net:</th>
                                <td class="text-right"><?= Utilities::setNumberFormatWithPeso($modelPartitions->net_amount, 2); ?></td>
                            </tr>
                            <tr>
                                <th>Total Personnel Profit:</th>
                                <td class="text-right">(<?= Utilities::setNumberFormatWithPeso($modelPartitions->total_personnel_profit_amount, 2); ?>)</td>
                            </tr>
                            <?php if ($modelPartitions->computation_type == TripPartitions::COMPUTATION_TYPE_1): ?>
                            <tr>
                                <th style="width:50%">Total Expenses:</th>
                                <td class="text-right">(<?= Utilities::setNumberFormatWithPeso($modelPartitions->total_expense_amount, 2); ?>)</td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <th></th>
                                <th><hr style="margin-top: 5px; border-top: 1px solid #333;"/></th>
                            </tr>
                            <tr>
                                <th style="width:50%">Total:</th>
                                <td class="text-right"><?= Utilities::setNumberFormatWithPeso($modelPartitions->net_profit_amount, 2); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- this row will not appear when printing -->
            <div class="row no-print">
                <div class="col-xs-12">
                    <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-default']) ?>
                    <?= Html::a('<i class="fa fa-print"></i> Print', ['print-trip', 'id' => $model->id], ['class' => 'btn btn-success pull-right', 'target' => '_blank']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
