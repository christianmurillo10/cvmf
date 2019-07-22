<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TripTransactions */

$this->title = 'Trip Transactions';
$this->params['breadcrumbs'][] = ['label' => 'Trip Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'View: ' . $model->id;
?>

<div class="col-md-6">
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-list-alt"></i>
            <h3 class="box-title">View: <?= $model->id ?></h3>

            <div class="pull-right box-tools">
                <?= Html::a('<i class="fa fa-arrow-left"></i>', ['index'], ['class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip', 'title' => 'Back']) ?>
            </div>
        </div>

        <div class="box-body table-responsive">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                            'id',
                'ref_no',
                'trip_no',
                'amount',
                'trip_id',
                'trip_demurrage_id',
                'trip_foul_trip_id',
                'client_id',
                'user_id',
                'date',
                'created_at:datetime',
                'updated_at:datetime',
                'trip_status',
                'is_billed',
                'is_fully_paid',
                'is_deleted',
                ],
            ]) ?>
        </div>
    </div>
</div>
