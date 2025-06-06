<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\EducationalLevels */

$this->title = 'Educational Levels';
$this->params['breadcrumbs'][] = ['label' => 'Educational Levels', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create';
?>
<div class="col-md-6">
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-plus-square"></i>
            <h3 class="box-title">Create</h3>
        </div>

        <?= $this->render('_form', [
        'model' => $model,
        ]) ?>
    </div>
</div>