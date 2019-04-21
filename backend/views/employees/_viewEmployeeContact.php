<?php

use yii\helpers\Html;
use common\models\utilities\Utilities;

?>

<div class="box box-default collapsed-box">
    <div class="box-header with-border">
        <i class="fa fa-phone-square"></i>
        <h3 class="box-title">Employee Contacts:</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    
    <div class="box-body">
        <div class="col-md-12">
            <div class="row">
                <?php foreach($modelEmployeeContacts as $modelEmployeeContact): ?>
                    <div class="educational-background box box-default">
                        <div class="box-header with-border">
                            <i class="fa fa-user"></i>
                            <h3 class="box-title">Contact</h3>
                            <div class="clearfix"></div>
                        </div>
                        <div class="box-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Relationship:</label><span> <?= $modelEmployeeContact->relationship->name ?></span>
                                            </div>
                                            <div class="col-md-12">
                                                <label>Name:</label><span> <?= $modelEmployeeContact->name ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Contact No:</label><span> <?= $modelEmployeeContact->contact_no ?></span>
                                            </div>
                                            <div class="col-md-12">
                                                <label>Address:</label><span> <?= $modelEmployeeContact->address ?></span>
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