<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\VehiclesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vehicles-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'plate_no') ?>

    <?= $form->field($model, 'temporary_plate_no') ?>

    <?= $form->field($model, 'model') ?>

    <?= $form->field($model, 'year_model') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'global_brand_id') ?>

    <?php // echo $form->field($model, 'vehicle_type_id') ?>

    <?php // echo $form->field($model, 'vehicle_owner_id') ?>

    <?php // echo $form->field($model, 'owned_type') ?>

    <?php // echo $form->field($model, 'is_with_plate') ?>

    <?php // echo $form->field($model, 'is_brand_new') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'is_deleted') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
