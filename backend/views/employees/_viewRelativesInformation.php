<?php

use yii\helpers\Html;
use common\models\utilities\Utilities;

?>

<div class="box box-default collapsed-box">
    <div class="box-header with-border">
        <i class="fa fa-users"></i>
        <h3 class="box-title">Employee Relatives:</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    
    <div class="box-body">
        <div class="col-md-12">
            <div class="row">
                <?php foreach($modelEmployeeRelatives as $modelEmployeeRelative): ?>
                    <div class="educational-background box box-default">
                        <div class="box-header with-border">
                            <i class="fa fa-user"></i>
                            <h3 class="box-title">Relative</h3>
                            <div class="clearfix"></div>
                        </div>
                        <div class="box-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Name:</label><span> <?= $modelEmployeeRelative->name ?></span>
                                            </div>
                                            <div class="col-md-12">
                                                <label>Work:</label><span> <?= $modelEmployeeRelative->work ?></span>
                                            </div>
                                            <div class="col-md-12">
                                                <label>Company Name:</label><span> <?= $modelEmployeeRelative->company_name ?></span>
                                            </div>
                                            <div class="col-md-12">
                                                <label>Company Address:</label><span> <?= $modelEmployeeRelative->company_address ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Email:</label><span> <?= $modelEmployeeRelative->email ?></span>
                                            </div>
                                            <div class="col-md-12">
                                                <label>Contact No:</label><span> <?= $modelEmployeeRelative->contact_no ?></span>
                                            </div>
                                            <div class="col-md-12">
                                                <label>Relationship:</label><span> <?= $modelEmployeeRelative->relationship->name ?></span>
                                            </div>
                                            <div class="col-md-12">
                                                <label>Educational Level:</label><span> <?= $modelEmployeeRelative->educationalLevel->name ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>