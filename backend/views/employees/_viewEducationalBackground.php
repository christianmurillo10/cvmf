<?php

use yii\helpers\Html;
use common\models\utilities\Utilities;

?>

<div class="box box-default collapsed-box">
    <div class="box-header with-border">
        <i class="fa fa-building"></i>
        <h3 class="box-title">Educational Background:</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    
    <div class="box-body">
        <div class="col-md-12">
            <div class="row">
                <label>Educational Level:</label><span> <?= empty($model->educational_level_id) ? 'N/A' : $model->educationalLevel->name ?></span>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <?php foreach($modelEmployeeEducationalBackgrounds as $modelEmployeeEducationalBackground): ?>
                    <div class="educational-background box box-default">
                        <div class="box-header with-border">
                            <i class="fa fa-university"></i>
                            <h3 class="box-title"><?= $modelEmployeeEducationalBackground->educationalType->name ?></h3>
                            <div class="clearfix"></div>
                        </div>
                        <div class="box-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Year From:</label><span> <?= $modelEmployeeEducationalBackground->year_from ?></span>
                                            </div>
                                            <div class="col-md-12">
                                                <label>Year To:</label><span> <?= $modelEmployeeEducationalBackground->year_to ?></span>
                                            </div>
                                            <div class="col-md-12">
                                                <label>Course:</label><span> <?= $modelEmployeeEducationalBackground->course ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>School Name:</label><span> <?= $modelEmployeeEducationalBackground->school_name ?></span>
                                            </div>
                                            <div class="col-md-12">
                                                <label>School Address:</label><span> <?= $modelEmployeeEducationalBackground->school_address ?></span>
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