<?php

use yii\helpers\Html;
use yii\grid\GridView;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EmployeeContractsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employee Contracts';
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['employees/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-xs-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-table"></i>
            <h3 class="box-title">Manage</h3>

            <div class="pull-right box-tools">
                <?= Html::a('<i class="fa fa-arrow-left"></i>', ['employees/index'], ['class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip', 'title' => 'Back']) ?>
                <?= Html::a('<i class="fa fa-plus"></i>', ['create', 'empId' => $_GET['empId']], ['class' => 'btn btn-success btn-xs', 'data-toggle' => 'tooltip', 'title' => 'Create']) ?>
            </div>
        </div>
        <div class="box-body">
            <div class="row" style="padding-bottom: 20px">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Employee No:</label><span> <?= $modelEmployees->employee_no ?></span>
                                </div>
                                <div class="col-md-12">
                                    <label>Name:</label><span> <?= $modelEmployees->fullname ?></span>
                                </div>
                                <div class="col-md-12">
                                    <label>Status:</label><span> <?= $modelEmployees->coloredStatus ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Department:</label><span> <?= $modelEmployees->employeeDepartment->name ?></span>
                                </div>
                                <div class="col-md-12">
                                    <label>Occupation:</label><span> <?= $modelEmployees->occupation->name ?></span>
                                </div>
                                <div class="col-md-12">
                                    <label>Position:</label><span> <?= $modelEmployees->position->name ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?= DataTables::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style' => 'width:3%;']
                    ],

                    [
                        'attribute' => 'date_start',
                        'format' => ['date', 'php:M j, Y'],
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['style' => 'width:10%;', 'class' => 'text-center']
                    ],
                    [
                        'attribute' => 'date_end',
                        'format' => ['date', 'php:M j, Y'],
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['style' => 'width:10%;', 'class' => 'text-center']
                    ],
                    [
                        'attribute' => 'employee_contract_type_id',
                        'value' => 'employeeContractType.name',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['style' => 'width:15%;', 'class' => 'text-center']
                    ],
                    [
                        'attribute' => 'employee_contract_status_id',
                        'value' => 'employeeContractStatus.name',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['style' => 'width:25%;']
                    ],
                    [
                        'attribute' => 'salary',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['style' => 'width:10%;', 'class' => 'text-center']
                    ],
                    [
                        'attribute' => 'status',
                        'value' => 'coloredStatuses',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['style' => 'width:10%;', 'class' => 'text-center'],
                        'format' => 'raw'
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'File',
                        'template' => '{download}',
                        'buttons' => [
                            'download' => function ($url, $model, $key) {
                                return Html::a ('<span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> ', ['download', 'filePath' => $model->file_path, 'fileName' => $model->file_name]);
                            },
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['style' => 'width:10%;', 'class' => 'text-center']
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a ('<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> ', ['view', 'id' => $model->id, 'empId' => $_GET['empId']]);
                            },
                            'update' => function ($url, $model, $key) {
                                return Html::a ('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ', ['update', 'id' => $model->id, 'empId' => $_GET['empId']]);
                            },
                        ],
                        'contentOptions' => ['style' => 'width:7%;', 'class' => 'text-center']
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
