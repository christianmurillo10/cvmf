<?php

use yii\helpers\Html;

?>

<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-phone"></i>
        <h3 class="box-title">Contact Information:</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    
    <div class="box-body">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'contact_no')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'primary_address')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'secondary_address')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
            </div>
        </div>
    </div>
</div>