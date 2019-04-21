<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use fedemotta\datatables\DataTables;
use backend\models\Clients;

/* @var $this yii\web\View */
/* @var $model backend\models\Clients */

$this->title = 'Clients';
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'View: ' . $model->name;
?>

<div class="col-md-6">
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-list-alt"></i>
            <h3 class="box-title">View: <?= $model->name ?></h3>

            <div class="pull-right box-tools">
                <?= Html::a('<i class="fa fa-arrow-left"></i>', ['index'], ['class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip', 'title' => 'Back']) ?>
            </div>
        </div>

        <div class="box-body table-responsive">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'email:email',
                    'contact_no',
                    [
                        'attribute' => 'payment_term',
                        'value' => $model->paymentTerm->name,
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'client_type',
                        'value' => $model->clientType,
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'status',
                        'value' => $model->coloredStatus,
                        'format' => 'raw'
                    ],
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

<?php if ($model->client_type == Clients::CLIENT_TYPE_SUB_CONTRACTOR): ?>
<div class="col-xs-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-table"></i>
            <h3 class="box-title">Client Direct Companies</h3>
        </div>
        <div class="box-body">

        <?= DataTables::widget([
            'dataProvider' => $dataProviderClientDirectCompanies,
            'filterModel' => $searchModelClientDirectCompanies,
            'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:M j, Y'],
                    'contentOptions' => ['style' => 'width:15%;']
                ],
                [
                    'attribute' => 'name',
                    'value' => 'name',
                    'contentOptions' => ['style' => 'width:30%;']
                ],
                [
                    'attribute' => 'contact_no',
                    'value' => 'contact_no',
                    'contentOptions' => ['style' => 'width:15%;']
                ],
                [
                    'attribute' => 'email',
                    'value' => 'email',
                    'format' => 'email',
                    'contentOptions' => ['style' => 'width:35%;']
                ]
            ],
        ]); ?>
        </div>
    </div>
</div>
<?php endif ?>