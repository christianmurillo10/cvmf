<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Employees */

$this->title = 'Employees';
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'View: ' . $model->employee_no;
?>

<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-list-alt"></i>
            <h3 class="box-title">View: <?= $model->employee_no ?></h3>

            <div class="pull-right box-tools">
                <?= Html::a('<i class="fa fa-arrow-left"></i>', ['index'], ['class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip', 'title' => 'Back']) ?>
            </div>
        </div>

        <?= $this->render('_view', [
            'model' => $model,
            'modelEmployeeGovernmentDetails' => $modelEmployeeGovernmentDetails,
            'modelEmployeeImages' => $modelEmployeeImages,
            'modelEmployeeEducationalBackgrounds' => $modelEmployeeEducationalBackgrounds,
            'modelEmployeeContacts' => $modelEmployeeContacts,
            'modelEmployeeRelatives' => $modelEmployeeRelatives,
            'modelEmployeeReferences' => $modelEmployeeReferences,
        ]) ?>
    </div>
</div>
