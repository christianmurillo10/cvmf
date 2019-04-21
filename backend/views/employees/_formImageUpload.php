<?php

use yii\helpers\Html;

if ($modelEmployeeImages->file_name != '' || $modelEmployeeImages->file_name != null) {
    $imageSrc = $modelEmployeeImages->file_path . $modelEmployeeImages->file_name;
} else {
    $imageSrc = 'images/no-image.png';
}
?>

<style>
    .employee-image-upload img {
        /* max-height: 180px;
        max-width: 180px; */
        height: 200px !important;
        width: 200px !important;
        margin-bottom: 10px;
    }
</style>

<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-picture-o"></i>
        <h3 class="box-title">Image Upload:</h3>
    </div>
    
    <div class="box-body">
        <div class="col-md-12">
            <div class="row text-center employee-image-upload">
                <img id="employee-image" src=<?= $imageSrc; ?> alt="Employee Image" />
                <?= $form->field($modelEmployeeImages, 'image_upload')->fileInput(['onchange' => 'displayImage(this)'])->label(false) ?>
            </div>
        </div>
    </div>
</div>

<script>
    function displayImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#employee-image')
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>