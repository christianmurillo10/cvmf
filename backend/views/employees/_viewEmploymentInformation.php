<?php

use yii\helpers\Html;
use common\models\utilities\Utilities;

?>

<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-folder"></i>
        <h3 class="box-title">Employment Information:</h3>

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
                            <label>Employment Status:</label><span> <?= $model->employmentStatus->name ?></span>
                        </div>
                        <div class="col-md-12">
                            <label>Pay Rate Type:</label><span> <?= $model->payRateType->name ?></span>
                        </div>
                        <div class="col-md-12">
                            <label>Department:</label><span> <?= $model->employeeDepartment->name ?></span>
                        </div>
                        <div class="col-md-12">
                            <label>Occupation:</label><span> <?= $model->occupation->name ?></span>
                        </div>
                        <div class="col-md-12">
                            <label>Position:</label><span> <?= $model->position->name ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <label>TIN No:</label><span> <?= $modelEmployeeGovernmentDetails->tin_no ?></span>
                        </div>
                        <div class="col-md-12">
                            <label>SSS No:</label><span> <?= $modelEmployeeGovernmentDetails->sss_no ?></span>
                        </div>
                        <div class="col-md-12">
                            <label>Pagibig No:</label><span> <?= $modelEmployeeGovernmentDetails->pagibig_no ?></span>
                        </div>
                        <div class="col-md-12">
                            <label>Philhealth No:</label><span> <?= $modelEmployeeGovernmentDetails->philhealth_no ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>