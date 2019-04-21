<?php

use yii\helpers\Html;
use yii\grid\GridView;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EmployeesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-xs-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-table"></i>
            <h3 class="box-title">Manage</h3>

            <div class="pull-right box-tools">
                <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success btn-xs', 'data-toggle' => 'tooltip', 'title' => 'Create']) ?>
            </div>
        </div>
        <div class="box-body">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
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
                    'contentOptions' => ['style' => 'width:10%;']
                ],
                [
                    'attribute' => 'date_endo',
                    'format' => ['date', 'php:M j, Y'],
                    'contentOptions' => ['style' => 'width:10%;']
                ],
                [
                    'attribute' => 'employee_no',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['style' => 'width:10%;', 'class' => 'text-center']
                ],
                [
                    'header' => 'Name',
                    'attribute' => 'fullname',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['style' => 'width:40%;']
                ],
                [
                    'attribute' => 'status',
                    'value' => 'coloredStatus',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['style' => 'width:10%;', 'class' => 'text-center'],
                    'format' => 'raw'
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Contract',
                    'template' => '{contract}',
                    'buttons' => [
                        'contract' => function ($url, $model, $key) {
                            return Html::a ('<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> ', ['employee-contracts/index', 'empId' => $model->id]);
                        },
                    ],
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['style' => 'width:8%;', 'class' => 'text-center']
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'width:9%;', 'class' => 'text-center']
                ],
            ],
        ]); ?>
        </div>
    </div>
</div>
