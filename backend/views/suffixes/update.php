<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Suffixes */

$this->title = 'Suffixes';
$this->params['breadcrumbs'][] = ['label' => 'Suffixes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-md-6">
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-edit"></i>
            <h3 class="box-title">Update: <?= $model->name ?></h3>
        </div>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
