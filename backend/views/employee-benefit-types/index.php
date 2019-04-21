<?php

use yii\helpers\Html;
use yii\grid\GridView;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EmployeeBenefitTypesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employee Benefit Types';
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
                    'contentOptions' => ['style' => 'width:5%;']
                ],

                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:M j, Y'],
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['style' => 'width:10%;', 'class' => 'text-center']
                ],
                [
                    'attribute' => 'name',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['style' => 'width:25%;', 'class' => 'text-center']
                ],
                [
                    'attribute' => 'description',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['style' => 'width:50%;', 'class' => 'text-center']
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'width:10%;', 'class' => 'text-center']
                ],
            ],
        ]); ?>
        </div>
    </div>
</div>
