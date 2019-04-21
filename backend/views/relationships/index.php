<?php

use yii\helpers\Html;
use yii\grid\GridView;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\RelationshipsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Relationships';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-xs-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-table"></i>
            <h3 class="box-title">Manage</h3>

            <div class="pull-right box-tools">
                <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success btn-xs', 'data-toggle' => 'tooltip', 'title' => 'Create']) ?>
            </div>
        </div>
        <div class="box-body">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= DataTables::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'name',
                'created_at',
                'updated_at',
                'is_deleted',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'width:10%;', 'class' => 'text-center']
                ],
            ],
        ]); ?>
        </div>
    </div>
</div>
