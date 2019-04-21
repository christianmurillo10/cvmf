<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Trips */

$this->title = 'Trips';
$this->params['breadcrumbs'][] = ['label' => 'Trips', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create';
?>
<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-plus-square"></i>
            <h3 class="box-title">Create</h3>

            <div class="pull-right box-tools">
                <?= Html::a('<i class="fa fa-arrow-left"></i>', ['index'], ['class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip', 'title' => 'Back']) ?>
            </div>
        </div>

        <?= $this->render('_form', [
            'model' => $model,
            'modelPersonnels' => $modelPersonnels,
            'modelExpenses' => $modelExpenses,
        ]) ?>
    </div>
</div>