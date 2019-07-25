<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TripBillingHeaders */

$this->title = 'Trip Billing Headers';
$this->params['breadcrumbs'][] = ['label' => 'Trip Billing Headers', 'url' => ['index']];
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
                'billing_no',
                'total_amount',
                'prepared_by',
                'noted_by',
                'user_id',
                'client_id',
                'created_at:datetime',
                'updated_at:datetime',
                'status',
                'is_with_others',
                'is_deleted',
                ],
            ]) ?>
        </div>
    </div>
</div>
