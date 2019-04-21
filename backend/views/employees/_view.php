<?php

use yii\helpers\Html;
use common\models\utilities\Utilities;

if ($model->is_active == Utilities::NO) {
    $visibility = 'visible';
} else {
    $visibility = 'hidden';
}

?>

<div class="box-body">
    <div class="row">
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12">
                    <?= $this->render('_viewImageUpload', [
                    'modelEmployeeImages' => $modelEmployeeImages
                    ]) ?>
                </div>
                <div class="col-md-12">
                    <label>Status:</label>
                    <span> <?= $model->coloredStatus ?></span>
                </div>
                <div class="col-md-12">
                    <label>Date Start:</label><span> <?= Utilities::setDateStandard($model->date_start) ?></span>
                </div>
                <div class="col-md-12" style="visibility: <?= $visibility ?>">
                    <label>Date Endo:</label><span> <?= Utilities::setDateStandard($model->date_endo) ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <?= $this->render('_viewPersonalInformation', [
                    'model' => $model,
                    ]) ?>
                </div>
                <div class="col-md-12">
                    <?= $this->render('_viewContactInformation', [
                    'model' => $model,
                    ]) ?>
                </div>
                <div class="col-md-12">
                    <?= $this->render('_viewEmploymentInformation', [
                    'model' => $model,
                    'modelEmployeeGovernmentDetails' => $modelEmployeeGovernmentDetails,
                    ]) ?>
                </div>
                <div class="col-md-12">
                    <?= $this->render('_viewEducationalBackground', [
                    'model' => $model,
                    'modelEmployeeEducationalBackgrounds' => $modelEmployeeEducationalBackgrounds,
                    ]) ?>
                </div>
                <div class="col-md-12">
                    <?= $this->render('_viewEmployeeContact', [
                    'modelEmployeeContacts' => $modelEmployeeContacts,
                    ]) ?>
                </div>
                <div class="col-md-12">
                    <?= $this->render('_viewRelativesInformation', [
                    'modelEmployeeRelatives' => $modelEmployeeRelatives,
                    ]) ?>
                </div>
                <div class="col-md-12">
                    <?= $this->render('_viewReferences', [
                    'modelEmployeeReferences' => $modelEmployeeReferences,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>