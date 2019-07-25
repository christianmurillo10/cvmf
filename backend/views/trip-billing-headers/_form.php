<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TripBillingHeaders */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="box-body table-responsive">

        <?= $form->field($model, 'client_id')->textInput() ?>

        <?= $form->field($model, 'billing_no')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'total_amount')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'prepared_by')->textInput() ?>

        <?= $form->field($model, 'noted_by')->textInput() ?>

        <?= $form->field($model, 'user_id')->textInput() ?>

        <?= $form->field($model, 'created_at')->textInput() ?>

        <?= $form->field($model, 'updated_at')->textInput() ?>

        <?= $form->field($model, 'status')->textInput() ?>

        <?= $form->field($model, 'is_with_others')->textInput() ?>

        <?= $form->field($model, 'is_deleted')->textInput() ?>

    <div class="box-footer">
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success pull-right']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
