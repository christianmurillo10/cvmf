<?php

use yii\helpers\Html;
use backend\models\TripPartitions;


/* @var $this yii\web\View */
/* @var $model backend\models\TripPartitions */

$this->title = 'Trip Partitions';
$this->params['breadcrumbs'][] = ['label' => 'Trips', 'url' => ['trips/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-plus-square"></i>
            <h3 class="box-title">Create</h3>

            <div class="pull-right box-tools">
                <?= Html::a('<i class="fa fa-arrow-left"></i>', ['trips/index'], ['class' => 'btn btn-danger btn-xs', 'data-toggle' => 'tooltip', 'title' => 'Back']) ?>
            </div>
        </div>

        <?= $this->render('_form', [
            'model' => $model,
            'modelPersonnels' => $modelPersonnels,
        ]) ?>
    </div>
</div>

<script>
    function numberWithCommas(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function removeCommas(value) {
        var str = value.split(',').join('');

        return str;
    }

    function formatNumberWithCommas(fieldID, value) {
        var num = numberWithCommas(removeCommas(value));
        
        $('#' + fieldID).val(num);
    }

    function computeVatAmount() {
        var taxPercentage = $('#taxPercentageID option:selected').text();
        var grossAmount = removeCommas($('#grossAmountID').val());

        if (taxPercentage == 'Choose One') {
            $('#vatAmountID').val(0);
        } else {
            var vatAmount = parseFloat((grossAmount * taxPercentage) / 100).toFixed(2);

            $('#vatAmountID').val(numberWithCommas(vatAmount));
        }
    }
    
    function computeNetAmount() {
        computeVatAmount();
        var grossAmount = removeCommas($('#grossAmountID').val());
        var totalExpenseAmount = removeCommas($('#totalExpenseAmountID').val());
        var vatAmount = removeCommas($('#vatAmountID').val());
        var maintenanceAmount = removeCommas($('#maintenanceAmountID').val());

        var netAmount = parseFloat(grossAmount - totalExpenseAmount - vatAmount - maintenanceAmount).toFixed(2);

        $('#netAmountID').val(numberWithCommas(netAmount));
    }

    function computeAllPersonnelProfitAmount() {
        var percentage = <?= TripPartitions::PERSONNEL_COMMISSION_TYPE_PERCENTAGE ?>;
        var personnelCommissionType = $('input[name="TripPartitions[personnel_commission_type]"]:checked').val();
        var netAmount =  removeCommas($('#netAmountID').val());

        if (personnelCommissionType == percentage) {
            $(".percentage").each(function(){
                var fieldID = $(this).attr("id");
                var id = fieldID.replace("percentageID", "");
                var percentage = $('#' + fieldID).val();
                var personnelProfitAmount = parseFloat((netAmount * percentage) / 100).toFixed(2);

                $('#profitAmountID' + id).val(numberWithCommas(personnelProfitAmount));
            });
        }
    }

    function computeTotalPersonnelProfitAmount() {
        computeAllPersonnelProfitAmount();
        var totalPersonnelProfitAmount = 0;

        $(".personnel-profit-amount").each(function(){
            var fieldID = $(this).attr("id");
            var personnelProfitAmount = removeCommas($('#' + fieldID).val());

            totalPersonnelProfitAmount = totalPersonnelProfitAmount + parseFloat(personnelProfitAmount);
        });

        $('#totalPersonnelProfitAmountID').val(numberWithCommas(totalPersonnelProfitAmount.toFixed(2)));
    }

    function computeNetProfitAmount() {
        computeNetAmount();
        computeTotalPersonnelProfitAmount();

        var netAmount = removeCommas($('#netAmountID').val());
        var totalPersonnelProfitAmountID = removeCommas($('#totalPersonnelProfitAmountID').val());
        var netProfitAmount = parseFloat(netAmount - totalPersonnelProfitAmountID).toFixed(2);

        $('#netProfitAmountID').val(numberWithCommas(netProfitAmount));
    }

    function disablePercentageProfit(value) {
        var percentage = <?= TripPartitions::PERSONNEL_COMMISSION_TYPE_PERCENTAGE ?>;

        if (value == percentage) {
            $('.percentage').attr('readonly', false);
            $('.personnel-profit-amount').attr('readonly', true);
        } else {
            $('.percentage').attr('readonly', true);
            $('.personnel-profit-amount').attr('readonly', false);
        }

        $('.percentage').val(null);
        $('.personnel-profit-amount').val(formatNumberWithCommas(0));
        computeNetProfitAmount();
    }
</script>