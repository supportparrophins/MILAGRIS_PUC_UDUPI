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
                            <i class="fas fa-newspaper"></i> Add Event
                            </span>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-6 box-tools">
                            <a onclick="window.history.back();"class="btn primary_color  mobile-btn float-right text-white pt-2"
                                value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                         </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- left column -->
<div class="row form-employee">
    <div class="col-12 column_padding_card">
        <div class="card card-small c-border p-1">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <!-- <h3 class="box-title">Enter Event Details</h3> -->
                </div><!-- /.box-header -->
                <!-- form start -->
                <?php $this->load->helper("form"); ?>
                <form role="form" id="addUser" action="<?php echo base_url() ?>addEventToDb" method="post"  enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">                                
                                <div class="form-group has-feedback">
                                    <label for="date">Date</label>
                                    <input placeholder="Date" type="text" class="form-control required datepicker" value="<?php echo set_value('date'); ?>" id="date" name="date" maxlength="128" autocomplete="off" required>
                                    <i class="glyphicon glyphicon-calendar form-control-feedback"></i>
                                </div>
                            </div>
                            <div class="col-md-6">                                
                                <div class="form-group">
                                    <label for="location">Event Location</label>
                                    <input placeholder="Event Location" type="text" class="form-control required" value="<?php echo set_value('location'); ?>" id="location" name="location" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subject">Title <span style="color: #d23431;">(Minimum 80 characters)</span></label>
                                    <input placeholder="News Title" type="text" class="form-control required" value="<?php echo set_value('subject'); ?>" id="subject" name="subject" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Select Event Image <span style="color: #d23431;"></span></label>
                                    <input type="file" class="form-control" id="vImg" name="userfile[]" multiple="multiple" required>
                                </div>
                            </div> 
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description <span style="color: #d23431;"></span></label>
                                    <textarea rows="4"  type="text" class="form-control required" id="edi" name="editor1"  autocomplete="off" required></textarea>
                                    <script>
                                        CKEDITOR.replace('edi',{
                                            filebrowserBrowseUrl: './ckfinder/ckfinder.html',
                                            filebrowserUploadUrl: './ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
                                        });
                                    </script> 
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="image">Image Peview</label>
                            </div> 
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="gallery_news">
                                </div>
                            </div>
                        </div> 
                    </div>
            </div><!-- /.box-body -->
    
            <div class="box-footer" >
                <input style="float:right"  type="submit" class="btn btn-primary" value="Submit" />
            </div>
        </form>
    </div>
</div>
</div>    
</section>
</div>


<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery('.datepicker').datepicker({
        autoclose: true,
        format : "dd-mm-yyyy",
        startDate : "01-01-2019"
    });

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
</script>