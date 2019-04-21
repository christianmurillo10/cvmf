<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Vehicles */

$this->title = 'Vehicles';
$this->params['breadcrumbs'][] = ['label' => 'Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'View: ' . $model->plate_no;
?>

<div class="col-md-6">
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-list-alt"></i>
            <h3 class="box-title">View: <?= $model->plate_no ?></h3>

            <div class="pull-right box-tools">
                <?= Html::a('<i class="fa fa-arrow-left"></i>', ['index'], ['class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip', 'title' => 'Back']) ?>
            </div>
        </div>

        <div class="box-body table-responsive">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                        'id',
                'plate_no',
                'temporary_plate_no',
                'model',
                'year_model',
                'user_id',
                'global_brand_id',
                'vehicle_type_id',
                'vehicle_owner_id',
                'owned_type',
                'is_with_plate',
                'is_brand_new',
                'status',
                'created_at:datetime',
                'updated_at:datetime',
                'is_deleted',
                ],
            ]) ?>
        </div>
    </div>
</div>
