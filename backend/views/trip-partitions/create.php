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
    $(function() {
        disablePercentageProfit();
        changeComputationNote();
    });

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

    // Net Amount Computation
    function netAmountComputation1() {
        var grossAmount = parseFloat(removeCommas($('#grossAmountID').val()));
        var vatAmount = parseFloat(removeCommas($('#vatAmountID').val()));
        var maintenanceAmount = parseFloat(removeCommas($('#maintenanceAmountID').val()));

        var netAmount = parseFloat(grossAmount - (vatAmount + maintenanceAmount)).toFixed(2);

        $('#netAmountID').val(numberWithCommas(netAmount));
    }

    function netAmountComputation2() {
        var grossAmount = parseFloat(removeCommas($('#grossAmountID').val()));
        var totalExpenseAmount = parseFloat(removeCommas($('#totalExpenseAmountID').val()));
        var vatAmount = parseFloat(removeCommas($('#vatAmountID').val()));
        var maintenanceAmount = parseFloat(removeCommas($('#maintenanceAmountID').val()));

        var netAmount = parseFloat(grossAmount - (vatAmount + maintenanceAmount + totalExpenseAmount)).toFixed(2);

        $('#netAmountID').val(numberWithCommas(netAmount));
    }
    
    function computeNetAmount() {
        computeVatAmount();
        var computation1 = <?= TripPartitions::COMPUTATION_TYPE_1 ?>;
        var computation2 = <?= TripPartitions::COMPUTATION_TYPE_2 ?>;
        var computationType = $('input[name="TripPartitions[computation_type]"]:checked').val();

        if (computationType == computation1) {
            netAmountComputation1();
        } else if (computationType == computation2) {
            netAmountComputation2();
        }
    }
    // End of Net Amount Computation

    // Personnel Profit Computation
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
    // End Personnel Profit Computation

    // Net Profit Computation
    function netProfitAmountComputation1() {
        var netAmount = parseFloat(removeCommas($('#netAmountID').val()));
        var totalPersonnelProfitAmountID = parseFloat(removeCommas($('#totalPersonnelProfitAmountID').val()));
        var totalExpenseAmount = parseFloat(removeCommas($('#totalExpenseAmountID').val()));

        var netProfitAmount = parseFloat(netAmount - (totalPersonnelProfitAmountID + totalExpenseAmount)).toFixed(2);

        $('#netProfitAmountID').val(numberWithCommas(netProfitAmount));
    }

    function netProfitAmountComputation2() {
        var netAmount = removeCommas($('#netAmountID').val());
        var totalPersonnelProfitAmountID = removeCommas($('#totalPersonnelProfitAmountID').val());
        var netProfitAmount = parseFloat(netAmount - totalPersonnelProfitAmountID).toFixed(2);

        $('#netProfitAmountID').val(numberWithCommas(netProfitAmount));
    }

    function computeNetProfitAmount() {
        computeNetAmount();
        computeTotalPersonnelProfitAmount();
        var computation1 = <?= TripPartitions::COMPUTATION_TYPE_1 ?>;
        var computation2 = <?= TripPartitions::COMPUTATION_TYPE_2 ?>;
        var computationType = $('input[name="TripPartitions[computation_type]"]:checked').val();

        if (computationType == computation1) {
            netProfitAmountComputation1();
        } else if (computationType == computation2) {
            netProfitAmountComputation2();
        }

    }
    // End of Net Profit Computation

    function disablePercentageProfit() {
        var percentage = <?= TripPartitions::PERSONNEL_COMMISSION_TYPE_PERCENTAGE ?>;
        var personnelCommissionType = $('input[name="TripPartitions[personnel_commission_type]"]:checked').val();

        if (personnelCommissionType == percentage) {
            $('.percentage').attr('readonly', false);
            $('.personnel-profit-amount').attr('readonly', true);
        } else {
            $('.percentage').attr('readonly', true);
            $('.personnel-profit-amount').attr('readonly', false);
            $('.percentage').val(null);
        }

        computeNetProfitAmount();
    }

    function displayMaintenancePercentage() {
        var percentage = <?= TripPartitions::MAINTENANCE_TYPE_PERCENTAGE ?>;
        var maintenanceType = $('input[name="TripPartitions[maintenance_type]"]:checked').val();

        if (maintenanceType == percentage) {
            $('.field-maintenancePercentageID').show();
            $('#maintenanceAmountID').attr('readonly', true);
            $('#maintenanceAmountID').val(0);
        } else {
            $('.field-maintenancePercentageID').hide();
            $('#maintenanceAmountID').attr('readonly', false);
            $('#maintenanceAmountID').val(0);
        }
    }

    function computeMaintenanceAmount() {
        var maintenancePercentage = $('#maintenancePercentageID').val();
        var grossAmount = removeCommas($('#grossAmountID').val());

        var maintenanceAmount = parseFloat((grossAmount * maintenancePercentage) / 100).toFixed(2);

        $('#maintenanceAmountID').val(numberWithCommas(maintenanceAmount));
    }

    function changeComputationNote() {
        var noteNet, noteNetProfit;
        var computation1 = <?= TripPartitions::COMPUTATION_TYPE_1 ?>;
        var computation2 = <?= TripPartitions::COMPUTATION_TYPE_2 ?>;
        var computationType = $('input[name="TripPartitions[computation_type]"]:checked').val();

        if (computationType == computation1) {
            noteNet = 'Gross - (VAT + Maintenance)';
            noteNetProfit = 'Net - (Personnel Profit + Expenses)';
        } else if (computationType == computation2) {
            noteNet = 'Gross - (VAT + Maintenance + Expenses)';
            noteNetProfit = 'Net - Personnel Profit';
        }

        $('#note-net').text(noteNet);
        $('#note-net-profit').text(noteNetProfit);
    }
</script>