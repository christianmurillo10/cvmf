<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TripTransactionsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trip-transactions-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ref_no') ?>

    <?= $form->field($model, 'trip_no') ?>

    <?= $form->field($model, 'amount') ?>

    <?= $form->field($model, 'trip_id') ?>

    <?php // echo $form->field($model, 'trip_demurrage_id') ?>

    <?php // echo $form->field($model, 'trip_foul_trip_id') ?>

    <?php // echo $form->field($model, 'client_id') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'trip_status') ?>

    <?php // echo $form->field($model, 'is_billed') ?>

    <?php // echo $form->field($model, 'is_fully_paid') ?>

    <?php // echo $form->field($model, 'is_deleted') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
