<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TripTransactions */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="box-body table-responsive">

        <?= $form->field($model, 'ref_no')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'trip_no')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'trip_id')->textInput() ?>

        <?= $form->field($model, 'trip_demurrage_id')->textInput() ?>

        <?= $form->field($model, 'trip_foul_trip_id')->textInput() ?>

        <?= $form->field($model, 'client_id')->textInput() ?>

        <?= $form->field($model, 'user_id')->textInput() ?>

        <?= $form->field($model, 'date')->textInput() ?>

        <?= $form->field($model, 'created_at')->textInput() ?>

        <?= $form->field($model, 'updated_at')->textInput() ?>

        <?= $form->field($model, 'trip_status')->textInput() ?>

        <?= $form->field($model, 'is_billed')->textInput() ?>

        <?= $form->field($model, 'is_fully_paid')->textInput() ?>

        <?= $form->field($model, 'is_deleted')->textInput() ?>

    <div class="box-footer">
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success pull-right']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
