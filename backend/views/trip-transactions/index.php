<?php

use yii\helpers\Html;
use yii\grid\GridView;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TripTransactionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trip Transactions';
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
                    'attribute' => 'date',
                    'format' => ['date', 'php:M j, Y'],
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['style' => 'width:9%;', 'class' => 'text-center']
                ],
                [
                    'attribute' => 'ref_no',
                    'contentOptions' => ['style' => 'width:8%;']
                ],
                [
                    'attribute' => 'trip_no',
                    'contentOptions' => ['style' => 'width:8%;']
                ],
                [
                    'attribute' => 'client_id',
                    'value' => 'client.name',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['style' => 'width:33%;']
                ],
                [
                    'attribute' => 'amount',
                    'value' => 'formattedAmount',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['style' => 'width:12%;', 'class' => 'text-right']
                ],
                [
                    'attribute' => 'trip_status',
                    'value' => 'coloredTripStatus',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['style' => 'width:9%;', 'class' => 'text-center'],
                    'format' => 'raw'
                ],
                [
                    'attribute' => 'is_billed',
                    'value' => 'isBilled',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['style' => 'width:6%;', 'class' => 'text-center'],
                    'format' => 'raw'
                ],
                [
                    'attribute' => 'is_fully_paid',
                    'value' => 'isFullyPaid',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['style' => 'width:7%;', 'class' => 'text-center'],
                    'format' => 'raw'
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'contentOptions' => ['style' => 'width:5%;', 'class' => 'text-center']
                ],
            ],
        ]); ?>
        </div>
    </div>
</div>
