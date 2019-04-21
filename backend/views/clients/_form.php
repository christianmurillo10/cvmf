<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use backend\models\PaymentTerms;
use backend\models\Clients;
use common\models\utilities\Utilities;

/* @var $this yii\web\View */
/* @var $model backend\models\Clients */
?>

<div class="box-body table-responsive">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_term_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(PaymentTerms::find()->all(), 'id', 'name'),
        'language' => 'en',
        'options' => ['placeholder' => 'Choose One'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'client_type')->widget(Select2::classname(), [
        'data' => Clients::get_ActiveClientTypes(),
        'language' => 'en',
        'options' => ['onchange' => 'displayClientDirectCompanies(this.value);', 'placeholder' => 'Choose One'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'status')->widget(Select2::classname(), [
        'data' => Utilities::get_ActiveStatus(),
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
