<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\EmployeeContracts */

$this->title = 'Employee Contracts';
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['employees/index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['employee-contracts/index', 'empId' => $_GET['empId']]];
$this->params['breadcrumbs'][] = ['label' => $model->employee->employee_no, 'url' => ['view', 'id' => $model->id, 'empId' => $_GET['empId']]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-edit"></i>
            <h3 class="box-title">Update: <?= $model->employee->employee_no ?></h3>

            <div class="pull-right box-tools">
                <?= Html::a('<i class="fa fa-arrow-left"></i>', ['employee-contracts/index', 'empId' => $_GET['empId']], ['class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip', 'title' => 'Back']) ?>
            </div>
        </div>

        <?= $this->render('_form', [
        'model' => $model,
        'modelEmployees' => $modelEmployees,
        'modelEmployeeBenefits' => $modelEmployeeBenefits,
        ]) ?>
    </div>
</div>
