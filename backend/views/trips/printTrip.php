<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Trips;
use backend\models\TripExpenses;
use backend\models\TripPersonnels;
use common\models\utilities\Utilities;
?>
<?= $this->render('_header', [
    'model' => $model,
    'modelPersonnels' => $modelPersonnels,
    'modelExpenses' => $modelExpenses,
]) ?>

<table class="table">
    <tr>
        <td style="width: 25%"><b>DR:</b> #<?= $model->trip_no ?></td>
        <td style="width: 25%"><b>Date Issued:</b> <?= $model->date_issued ? Utilities::setDateStandard($model->date_issued) : $model->date_issued ?></td>
        <td style="width: 25%"><b>Amount:</b> <?= Utilities::setNumberFormatWithPeso($model->amount, 2); ?></td>
        <?php if ($countPersonnel >= 1):?>
            <td style="width: 25%"><b><?= TripPersonnels::get_ActiveRoleType($modelPersonnels[0]->role_type) ?>:</b> <?= $modelPersonnels[0]->employee->fullname ?></td>
        <?php endif ?>
    </tr>
    <tr>
        <td style="width: 25%"><b>Client:</b> <?= $model->client->name ?></td>
        <td style="width: 25%"><b>Date Delivered:</b> <?= $model->date_delivered ? Utilities::setDateStandard($model->date_delivered) : $model->date_delivered ?></td>
        <td style="width: 25%" rowspan="3"><b>Remarks:</b> <?= $model->remarks ?></td>
        <?php if ($countPersonnel >= 2):?>
            <td style="width: 25%"><b><?= TripPersonnels::get_ActiveRoleType($modelPersonnels[1]->role_type) ?>:</b> <?= $modelPersonnels[1]->employee->fullname ?></td>
        <?php endif ?>
    </tr>
    <tr>
        <td style="width: 25%"><b>Vehicle:</b> <?= $model->vehicle->plate_no ?></td>
        <td style="width: 25%"><b>Destination From:</b> <?= $model->destinationFrom->name ?></td>
        <?php if ($countPersonnel >= 3):?>
            <td style="width: 25%"><b><?= TripPersonnels::get_ActiveRoleType($modelPersonnels[1]->role_type) ?>:</b> <?= $modelPersonnels[1]->employee->fullname ?></td>
        <?php endif ?>
    </tr>
    <tr>
        <td><b>Status:</b> <?= Trips::get_ActiveStatus($model->status) ?></td>
        <td><b>Destination To:</b> <?= $model->destinationTo->name ?></td>
    </tr>
</table>

<table class="table table-bordered">
    <thead>
        <tr>
            <th class="text-center" style="width: 20%">Type</th>
            <th class="text-center" style="width: 20%">Expense</th>
            <th class="text-center" style="width: 20%">Amount</th>
            <th class="text-center" style="width: 40%">Remarks</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($modelExpenses as $expense): ?>
        <tr>
            <td><?= TripExpenses::get_ActiveExpenseType($expense->expense_type) ?></td>
            <td><?= $expense->expenseList->name ?></td>
            <td class="text-right"><?= Utilities::setNumberFormatWithPeso($expense->amount, 2); ?></td>
            <td><?= $expense->remarks ?></td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>

<!-- Partition -->
<table class="table">
    <tr>
        <th style="width:35%"></th>
        <th style="width:35%"></th>
        <th style="width:25%">Total Gross:</th>
        <td class="text-right"><?= Utilities::setNumberFormatWithPeso($modelPartitions->gross_amount, 2); ?></td>
    </tr>
    <tr>
        <th style="width:35%"></th>
        <th style="width:35%"></th>
        <th style="width:25%">Total Expenses:</th>
        <td class="text-right">(<?= Utilities::setNumberFormatWithPeso($modelPartitions->total_expense_amount, 2); ?>)</td>
    </tr>
    <tr>
        <th style="width:35%"></th>
        <th style="width:35%"></th>
        <th>Tax (<?= $modelPartitions->taxPercentage->value; ?>%)</th>
        <td class="text-right">(<?= Utilities::setNumberFormatWithPeso($modelPartitions->vat_amount, 2); ?>)</td>
    </tr>
    <tr>
        <th style="width:35%"></th>
        <th style="width:35%"></th>
        <th>Maintenance:</th>
        <td class="text-right">(<?= Utilities::setNumberFormatWithPeso($modelPartitions->maintenance_amount, 2); ?>)</td>
    </tr>
    <tr>
        <th style="width:35%"></th>
        <th style="width:35%"></th>
        <th></th>
        <th><hr style="margin-top: 5px;"/></th>
    </tr>
    <tr>
        <th style="width:35%"></th>
        <th style="width:35%"></th>
        <th>Total Net:</th>
        <td class="text-right"><?= Utilities::setNumberFormatWithPeso($modelPartitions->net_amount, 2); ?></td>
    </tr>
    <tr>
        <th style="width:35%"></th>
        <th style="width:35%"></th>
        <th>Total Personnel Profit:</th>
        <td class="text-right">(<?= Utilities::setNumberFormatWithPeso($modelPartitions->total_personnel_profit_amount, 2); ?>)</td>
    </tr>
    <tr>
        <th style="width:35%"></th>
        <th style="width:35%"></th>
        <th></th>
        <th><hr style="margin-top: 5px;"/></th>
    </tr>
    <tr>
        <th style="width:35%"></th>
        <th style="width:35%"></th>
        <th style="width:25%">Total:</th>
        <td class="text-right"><?= Utilities::setNumberFormatWithPeso($modelPartitions->net_profit_amount, 2); ?></td>
    </tr>
</table>