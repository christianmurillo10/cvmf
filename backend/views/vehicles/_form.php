<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Vehicles */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="box-body table-responsive">

    <?= $form->field($model, 'plate_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'temporary_plate_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year_model')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'global_brand_id')->textInput() ?>

    <?= $form->field($model, 'vehicle_type_id')->textInput() ?>

    <?= $form->field($model, 'vehicle_owner_id')->textInput() ?>

    <?= $form->field($model, 'owned_type')->textInput() ?>

    <?= $form->field($model, 'is_with_plate')->textInput() ?>

    <?= $form->field($model, 'is_brand_new')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'is_deleted')->textInput() ?>

    <div class="box-footer">
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success pull-right']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
