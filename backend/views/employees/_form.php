<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use common\models\utilities\Utilities;

if ($model->is_active == Utilities::NO) {
    $visibility = 'visible';
} else {
    $visibility = 'hidden';
}

/* @var $this yii\web\View */
/* @var $model backend\models\Employees */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<div class="box-body">
    <div class="row">
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12">
                    <?= $this->render('_formImageUpload', [
                    'modelEmployeeImages' => $modelEmployeeImages,
                    'form' => $form
                    ]) ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'is_active')->widget(Select2::classname(), [
                        'data' => Utilities::get_ActiveSelect(),
                        'language' => 'en',
                        'options' => ['onchange' => 'displayDateEndo(this.value);', 'placeholder' => 'Choose One'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'date_start')->widget(
                        DatePicker::className(), [
                            'inline' => false, 
                            'clientOptions' => [
                                'autoclose' => true,
                                'todayHighlight' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                    ]);?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'date_endo', ['options' => ['id' => 'dateEndoID', 'style' => "visibility: {$visibility}"]])->widget(
                        DatePicker::className(), [
                            'inline' => false, 
                            'clientOptions' => [
                                'autoclose' => true,
                                'todayHighlight' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                    ]);?>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <?= $this->render('_formPersonalInformation', [
                    'model' => $model,
                    'form' => $form
                    ]) ?>
                </div>
                <div class="col-md-12">
                    <?= $this->render('_formContactInformation', [
                    'model' => $model,
                    'form' => $form
                    ]) ?>
                </div>
                <div class="col-md-12">
                    <?= $this->render('_formEmploymentInformation', [
                    'model' => $model,
                    'modelEmployeeGovernmentDetails' => $modelEmployeeGovernmentDetails,
                    'form' => $form
                    ]) ?>
                </div>
                <div class="col-md-12">
                    <?= $this->render('_formEducationalBackground', [
                    'model' => $model,
                    'modelEmployeeEducationalBackgrounds' => $modelEmployeeEducationalBackgrounds,
                    'form' => $form
                    ]) ?>
                </div>
                <div class="col-md-12">
                    <?= $this->render('_formEmployeeContact', [
                    'model' => $model,
                    'modelEmployeeContacts' => $modelEmployeeContacts,
                    'form' => $form
                    ]) ?>
                </div>
                <div class="col-md-12">
                    <?= $this->render('_formRelativesInformation', [
                    'model' => $model,
                    'modelEmployeeRelatives' => $modelEmployeeRelatives,
                    'form' => $form
                    ]) ?>
                </div>
                <div class="col-md-12">
                    <?= $this->render('_formReferences', [
                    'model' => $model,
                    'modelEmployeeReferences' => $modelEmployeeReferences,
                    'form' => $form
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="box-footer">
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success pull-right']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<script>
    function displayDateEndo(value) {
        if (value == 0) {
            $("#dateEndoID").css("visibility", "visible");
        } else {
            $("#dateEndoID").css("visibility", "hidden");
        }
    }
</script>