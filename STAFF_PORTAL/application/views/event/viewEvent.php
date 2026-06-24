<script src="<?php echo base_url(); ?>ckeditor/ckeditor.js"></script>
<?php
    $this->load->helper('form');
    $error = $this->session->flashdata('error');
    if($error)
    {
?>
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo $this->session->flashdata('error'); ?>                    
</div>
<?php } ?>
<?php  
    $success = $this->session->flashdata('success');
    if($success)
    {
?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo $this->session->flashdata('success'); ?>
</div>
<?php } ?>
<?php  
    $warning = $this->session->flashdata('warning');
    if($warning)
    {
?>
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo $this->session->flashdata('warning'); ?>
</div>
<?php } ?>
                
<div class="row">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>

 <!-- Content Header (Page header) -->
    
 <div class="main-content-container px-3 pt-1">
    <div class="row p-0">
        <div class="col column_padding_card">
            <div class="card card-small card_heading_title p-0 m-b-1">
                <div class="card-body p-2">
                    <div class="row c-m-b">
                        <div class="col-lg-6 col-sm-6 col-6">
                            <span class="page-title absent_table_title_mobile">
                            <i class="fas fa-newspaper"></i> View Event Register
                            </span>
                        </div>
                       <div class="col-lg-6 col-sm-6 col-6 box-tools">
                            <a onclick="window.history.back();" class="btn primary_color  mobile-btn float-right text-white pt-2"
                                value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- left column -->
    <div class="row">
        <div class="col-12 column_padding_card">
            <div class="card card-small c-border p-1">
                <div class="col-md-12 col-lg-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header">
                        <!-- <h3 class="box-title">Enter Event Details</h3> -->
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <?php $this->load->helper("form"); ?>
                        <div class="box-body">
                            <div class="row">
                                <input  type="hidden" class="form-control required" value="<?php echo $newsInfo->row_id; ?>" id="row_id" name="row_id">  
                                <table class="table table-bordered"> 
                                    <tr>
                                        <th class="tbl-head">Date</th>
                                        <th class="tbl-head-content">
                                            <?php echo date('d-m-Y', strtotime($newsInfo->date)); ?>
                                        </th>
                                        <th class="tbl-head">Event Location</th>
                                        <th class="tbl-head-content">
                                            <?php echo $newsInfo->location; ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-head">Title</th>
                                        <th class="tbl-head-content">
                                            <?php echo $newsInfo->subject; ?>
                                        </th>
                                        <th class="tbl-head">Description</th>
                                        <th class="tbl-head-content">
                                            <?php echo html_entity_decode($newsInfo->description); ?>
                                        </th>
                                    </tr> 
                                    <tr>
                                        <th colspan='4'>
                                        <?php if(!empty($newsInfo->image_path)){ ?>
                                        <img height="200" width="250" src="<?php echo base_url() ?>/assets/<?php echo $newsInfo->image_path; ?>"> 
                                        <?php } ?>
                                        <?php if(!empty($newsInfo->image_sub1)){ ?>
                                        <img height="200" width="250" src="<?php echo base_url() ?>/assets/<?php echo $newsInfo->image_sub1; ?>"> 
                                        <?php } ?>
                                        <?php if(!empty($newsInfo->image_sub2)){ ?>
                                        <img height="200" width="250" src="<?php echo base_url() ?>/assets/<?php echo $newsInfo->image_sub2; ?>"> 
                                        <?php } ?>
                                        <?php if(!empty($newsInfo->image_sub3)){ ?>
                                        <img height="200" width="250" src="<?php echo base_url() ?>/assets/<?php echo $newsInfo->image_sub3; ?>"> 
                                        <?php } ?>
                                        <?php if(!empty($newsInfo->image_sub4)){ ?>
                                        <img height="200" width="250" src="<?php echo base_url() ?>/assets/<?php echo $newsInfo->image_sub4; ?>"> 
                                        <?php } ?>
                                        </th> 
                                    </tr> 
                                </table> 
                        </div>    
                </div>
            </div>
          
        </div>    
 </div>   
</div>

<script>
function readURL(input) {
    if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
        $('#uploadedImage').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
    }
}
function readURL1(input) {
    if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
            $('#uploadedImageOne').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function readURL2(input) {
    if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
        $('#uploadedImageTwo').attr('src', e.target.result);
        }
    reader.readAsDataURL(input.files[0]);
    }
}
function readURL3(input) {
    if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
        $('#uploadedImageThree').attr('src', e.target.result);
        }
    reader.readAsDataURL(input.files[0]);
    }
}
function readURL4(input) {
    if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
        $('#uploadedImageFour').attr('src', e.target.result);
        }
    reader.readAsDataURL(input.files[0]);
    }
}

$("#vImg").change(function() {
readURL(this);
});
$("#vImgOne").change(function() {
readURL1(this);
});
$("#vImgTwo").change(function() {
readURL2(this);
});
$("#vImgThree").change(function() {
readURL3(this);
});
$("#vImgFour").change(function() {
readURL4(this);
});

$(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    $('#vImg').on('change', function() {
        imagesPreview(this, '.gallery_news');
    });
});

jQuery(document).ready(function(){
    jQuery('.datepicker').datepicker({
        autoclose: true,
        format : "dd-mm-yyyy",
        startDate : "01-01-2019"
    });

});
</script>