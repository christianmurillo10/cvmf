<?php

use yii\helpers\Html;
use yii\grid\GridView;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TripsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trips';
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
                    'attribute' => 'date_issued',
                    'format' => ['date', 'php:M j, Y'],
                    'contentOptions' => ['style' => 'width:9%;']
                ],
                [
                    'attribute' => 'date_delivered',
                    'format' => ['date', 'php:M j, Y'],
                    'contentOptions' => ['style' => 'width:10%;']
                ],
                [
                    'attribute' => 'trip_no',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['style' => 'width:7%;', 'class' => 'text-center']
                ],
                [
                    'attribute' => 'client_id',
                    'value' => 'client.name',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['style' => 'width:15%;']
                ],
                [
                    'attribute' => 'vehicle.plate_no',
                    'value' => 'vehicle.plate_no',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['style' => 'width:7%;', 'class' => 'text-center']
                ],
                [
                    'attribute' => 'amount',
                    'value' => 'formattedAmount',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['style' => 'width:10%;', 'class' => 'text-right']
                ],
                'remarks:ntext',
                [
                    'attribute' => 'status',
                    'value' => 'coloredStatus',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['style' => 'width:6%;', 'class' => 'text-center'],
                    'format' => 'raw'
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Partition',
                    'template' => '{partition} {updateStatus}',
                    'buttons' => [
                        'partition' => function ($url, $model, $key) {
                            return Html::a ('<span class="glyphicon glyphicon-equalizer" aria-hidden="true"></span> ', ['trip-partitions/create', 'tripId' => $model->id], ['title' => 'Partitions']);
                        },
                        'updateStatus' => function ($url, $model, $key) {
                            return Html::a ('<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> ', ['trips/update-status', 'id' => $model->id], ['title' => 'Update Status']);
                        },
                    ],
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['style' => 'width:7%;', 'class' => 'text-center']
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'width:6%;', 'class' => 'text-center']
                ],
            ],
        ]); ?>
        </div>
    </div>
</div>
