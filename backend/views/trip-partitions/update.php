<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TripPartitions */

$this->title = 'Trip Partitions';
$this->params['breadcrumbs'][] = ['label' => 'Trip Partitions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-md-6">
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-edit"></i>
            <h3 class="box-title">Update: <?= $model->id ?></h3>
        </div>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
