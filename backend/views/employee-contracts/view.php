<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\EmployeeContracts */

$this->title = 'Employee Contracts';
$this->params['breadcrumbs'][] = ['label' => 'Employee Contracts', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'View: ' . $model->id;
?>

<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-list-alt"></i>
            <h3 class="box-title">View: <?= $model->employee->employee_no ?></h3>

            <div class="pull-right box-tools">
                <?= Html::a('<i class="fa fa-arrow-left"></i>', ['index', 'empId' => $_GET['empId']], ['class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip', 'title' => 'Back']) ?>
            </div>
        </div>

        <div class="box-body table-responsive">
            <div class="col-md-6">
                <div class="row">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'employee_id',
                                'value' => $model->employee->fullname
                            ],
                            [
                                'attribute' => 'date_start',
                                'format' => ['date', 'php:M j, Y']
                            ],
                            [
                                'attribute' => 'date_end',
                                'format' => ['date', 'php:M j, Y']
                            ],
                            'salary',
                            [
                                'attribute' => 'occupation_id',
                                'value' => $model->occupation->name
                            ],
                            [
                                'attribute' => 'position_id',
                                'value' => $model->position->name
                            ],
                            [
                                'attribute' => 'employee_contract_type_id',
                                'value' => $model->employeeContractType->name
                            ],
                            [
                                'attribute' => 'employee_contract_month_id',
                                'value' => empty($model->employeeContractMonth->name) ? 'N/A' : $model->employeeContractMonth->name
                            ],
                            [
                                'attribute' => 'employee_contract_status_id',
                                'value' => $model->employeeContractStatus->name
                            ],
                            'statuses',
                        ],
                    ]) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6 col-md-offset-6">
                        <div class="row">
                            <?= Html::a('Download File <i class="glyphicon glyphicon-download-alt"></i>', ['download', 'empId' => $_GET['empId']], ['class' => 'btn btn-info', 'data-toggle' => 'tooltip', 'title' => 'Download File']) ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-md-offset-4">
                        <div class="row">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Benefits</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($modelEmployeeBenefits as $modelEmployeeBenefit): ?>
                                    <tr>
                                        <td><?= $modelEmployeeBenefit->employeeBenefitType->name ?></td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
