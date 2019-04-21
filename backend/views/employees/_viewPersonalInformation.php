<?php

use yii\helpers\Html;
use common\models\utilities\Utilities;

?>

<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-user"></i>
        <h3 class="box-title">Personal Information:</h3>

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
                            <label>Employee No:</label><span> <?= $model->employee_no ?></span>
                        </div>
                        <div class="col-md-12">
                            <label>Firstname:</label><span> <?= $model->firstname ?></span>
                        </div>
                        <div class="col-md-12">
                            <label>Middlename:</label><span> <?= $model->middlename ?></span>
                        </div>
                        <div class="col-md-12">
                            <label>Lastname:</label><span> <?= $model->lastname ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Suffix:</label><span> <?= empty($model->suffix_id) ? 'N/A' : Utilities::setCapitalFirst($this->suffix->name) ?></span>
                        </div>
                        <div class="col-md-12">
                            <label>Birtdate:</label><span> <?= Utilities::setDateStandard($model->birthdate) ?></span>
                        </div>
                        <div class="col-md-12">
                            <label>Gender:</label><span> <?= Utilities::get_ActiveGenderType($model->gender_type) ?></span>
                        </div>
                        <div class="col-md-12">
                            <label>Civil Status:</label><span> <?= Utilities::get_ActiveCivilStatusType($model->civil_status_type) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>