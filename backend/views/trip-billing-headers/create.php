<?php

use yii\helpers\Html;
use common\models\utilities\Utilities;


/* @var $this yii\web\View */
/* @var $model backend\models\TripBillingHeaders */

$this->title = 'Trip Billing';
$this->params['breadcrumbs'][] = ['label' => 'Trip Billing', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create';
?>
<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-plus-square"></i>
            <h3 class="box-title">Create</h3>

            <div class="pull-right box-tools">
                <?= Html::a('<i class="fa fa-arrow-left"></i>', ['index'], ['class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip', 'title' => 'Back']) ?>
            </div>
        </div>

        <?= $this->render('_form', [
        'model' => $model,
        'modelDetails' => $modelDetails,
        ]) ?>
    </div>
</div>

<script>
    $(function() {
        displayOtherDetails();
    });

    function getClientDetails() {
        $("select.trip-transaction").html('');
        let value = $('#clientID').val();

        $.ajax({
            url: "?r=clients/ajax-find-one-by-id",
            type: 'GET',
            dataType: 'JSON',
            data: {"id" : value},
            success: function(data) {
                $("#paymentTermID").val(data.payment_term_id).change();
            }
        });
    }

    function getClientTransactions() {
        let value = $('#clientID').val();

        $.ajax({
            url: "?r=trip-transactions/drop-down-client-trip-transaction-list",
            type: 'GET',
            data: {"clientId" : value},
            success: function(data) {
                $("select.trip-transaction").last().html(data);
            }
        });
    }

    function displayOtherDetails() {
        var YES = <?= Utilities::YES ?>;
        var isWithOthers = $('input[name="TripBillingHeaders[is_with_others]"]:checked').val();
        
        if (isWithOthers == YES) {
            $('.others').show();
        } else {
            $('.others').hide();
            // $('.others').('');
        }
    }
</script>