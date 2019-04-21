<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Clients;

if ($model->client_type == Clients::CLIENT_TYPE_SUB_CONTRACTOR) {
    $display = '';
} else {
    $display = 'none';
}

/* @var $this yii\web\View */
/* @var $model backend\models\Clients */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Clients';
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<div class="col-md-6">
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-edit"></i>
            <h3 class="box-title">Update: <?= $model->name ?></h3>
        </div>

        <?= $this->render('_form', [
        'form' => $form,
        'model' => $model,
        ]) ?>
    </div>
</div>

<div id="divClientDirectCompanies" class="col-md-6" style="display: <?= $display ?>">
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-edit"></i>
            <h3 class="box-title">Update</h3>
        </div>

        <?= $this->render('_formClientDirectCompanies', [
        'form' => $form,
        'modelClientDirectCompanies' => $modelClientDirectCompanies,
        ]) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<script>
    function displayClientDirectCompanies(value) {
        var subContractor = <?= Clients::CLIENT_TYPE_SUB_CONTRACTOR ?>

        if (value == subContractor) {
            $('#divClientDirectCompanies').show();
        } else {
            $('#divClientDirectCompanies').hide();
        }
    }
</script>