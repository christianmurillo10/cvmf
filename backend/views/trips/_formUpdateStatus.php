<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\Trips;

/* @var $this yii\web\View */
/* @var $model backend\models\Positions */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="box-body table-responsive">

    <?= $form->field($model, 'status')->widget(Select2::classname(), [
        'data' => Trips::get_ActiveStatus(),
        'language' => 'en',
        'options' => ['placeholder' => 'Choose One'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <div class="box-footer">
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success pull-right']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
