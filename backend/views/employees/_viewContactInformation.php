<?php

use yii\helpers\Html;
use common\models\utilities\Utilities;

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
                    <div class="row">
                        <div class="col-md-12">
                            <label>Contact No:</label><span> <?= $model->contact_no ?></span>
                        </div>
                        <div class="col-md-12">
                            <label>Email:</label><span> <?= $model->email ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Primary Address:</label><span> <?= $model->primary_address ?></span>
                        </div>
                        <div class="col-md-12">
                            <label>Secondary Address:</label><span> <?= $model->secondary_address ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>