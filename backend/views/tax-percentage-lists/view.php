<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TaxPercentageLists */

$this->title = 'Tax Percentage Lists';
$this->params['breadcrumbs'][] = ['label' => 'Tax Percentage Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'View: ' . $model->value;
?>

<div class="col-md-6">
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-list-alt"></i>
            <h3 class="box-title">View: <?= $model->value ?></h3>

            <div class="pull-right box-tools">
                <?= Html::a('<i class="fa fa-arrow-left"></i>', ['index'], ['class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip', 'title' => 'Back']) ?>
            </div>
        </div>

        <div class="box-body table-responsive">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'value',
                    [
                        'attribute' => 'created_at',
                        'format' => ['date', 'php:M j, Y g:i:s A'],
                    ],
                    [
                        'attribute' => 'updated_at',
                        'format' => ['date', 'php:M j, Y g:i:s A'],
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
