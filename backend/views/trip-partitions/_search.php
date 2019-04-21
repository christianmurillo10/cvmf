<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TripPartitionsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trip-partitions-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'gross_amount') ?>

    <?= $form->field($model, 'vat_amount') ?>

    <?= $form->field($model, 'maintenance_amount') ?>

    <?= $form->field($model, 'total_expense_amount') ?>

    <?php // echo $form->field($model, 'net_amount') ?>

    <?php // echo $form->field($model, 'total_personnel_profit_amount') ?>

    <?php // echo $form->field($model, 'net_profit_amount') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'trip_id') ?>

    <?php // echo $form->field($model, 'tax_percentage_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'is_deleted') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
