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
                            <i class="material-icons">web</i> Edit Website News
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
                        <form role="form" action="<?php echo base_url() ?>addNewToDb" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <input  type="hidden" class="form-control required" value="<?php echo $newsInfo->row_id; ?>" id="row_id" name="row_id">
                                <div class="col-md-6">                                
                                    <div class="form-group has-feedback">
                                        <label for="date">Date</label>
                                        <input placeholder="Date" type="text" class="form-control required datepicker" value="" id="date" name="date" maxlength="128" autocomplete="off" required>
                                        <i class="glyphicon glyphicon-calendar form-control-feedback"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="location">Event Location</label>
                                        <input placeholder="Event Location" type="text" class="form-control required" value="<?php echo $newsInfo->location; ?>" id="location" name="location" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="subject">Title</label>
                                        <input placeholder="News Title" type="text" class="form-control required" value="<?php echo $newsInfo->subject; ?>" id="subject" name="subject" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">Select News & Event Image <span style="color: #d23431;">(Upload Minimum Two Images)</span></label>
                                        <input type="file" class="form-control" id="vImg" name="userfile[]"  multiple="multiple"/>
                                        <img height="200" alt="Please Choose News & Event Image" width="250" src="<?php echo base_url() ?>/assets/<?php echo $newsInfo->image_path; ?>" id="uploadedImage" name="userImage" >     
                                    </div>
                                </div> 
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea rows="8" placeholder="Event Description" type="text" class="form-control required" id="description" name="description"  autocomplete="off" required><?php echo $newsInfo->description; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="image">Image Peview</label>
                                </div> 
                                <?php if(!empty($newsInfo->image_sub1)){ ?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <img height="200" alt="News & Events" width="250" src="<?php echo base_url() ?>/assets/<?php echo $newsInfo->image_sub1; ?>" id="uploadedImageOne" name="userImageOne">     
                                    </div>
                                </div> 
                                <?php } 
                                 if(!empty($newsInfo->image_sub2)){ ?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <img height="200" alt="News & Events" width="250" src="<?php echo base_url() ?>/assets/<?php echo $newsInfo->image_sub2; ?>" id="uploadedImageTwo" name="userImageTwo" >     
                                    </div>
                                </div> 
                                <?php } 
                                 if(!empty($newsInfo->image_sub3)){ ?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <img height="200" alt="News & Events" width="250" src="<?php echo base_url() ?>/assets/<?php echo $newsInfo->image_sub3; ?>" id="uploadedImageThree" name="userImageThree" >     
                                    </div>
                                </div> 
                                <?php } 
                                 if(!empty($newsInfo->image_sub4)){ ?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <img height="200" alt="News & Events" width="250" src="<?php echo base_url() ?>/assets/<?php echo $newsInfo->image_sub4; ?>" id="uploadedImageFour" name="userImageFour" >     
                                    </div>
                                </div> 
                                <?php } ?>
                            </div>

                        </div><!-- /.box-body -->
    
                        <div class="box-footer" >
                            <input style="float:right" type="submit" class="btn btn-success" value="UPDATE" />

                        </div>
                    </form>
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