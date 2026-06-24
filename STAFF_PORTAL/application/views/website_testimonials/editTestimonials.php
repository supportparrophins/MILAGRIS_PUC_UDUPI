<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Alumni Testimonials
        <small>Edit Testimonials</small>
        <input class="btn btn-primary pull-right" type="button" value="Back" onclick="window.history.back()" /> 
      </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-md-12">
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
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit Testimonials</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addUser" action="<?php echo base_url() ?>updateTestimonials" method="post"  enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                            <input  type="hidden" class="form-control required" value="<?php echo $feedbackInfo->row_id; ?>" id="row_id" name="row_id">
                            <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input placeholder="Name" type="text" class="form-control required" value="<?php echo $feedbackInfo->name; ?>" id="name" name="name" maxlength="128" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">Select Student Image</label>
                                        <input type="file" value="<?php echo $feedbackInfo->image_url; ?>" class="form-control" id="vImg" name="userfile">
                                        <img height="200" alt="Please Choose Student Image" width="250" src="<?php echo $feedbackInfo->image_url; ?>" id="uploadedImage" name="userfile" >     
                                    </div>
                                </div> 
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="message">Feedback Message</label>
                                        <textarea rows="6" placeholder="Feedback Message" type="text" class="form-control required" id="message" name="message"  autocomplete="off" required><?php echo $feedbackInfo->message; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer" >
                            <input style="float:right" type="submit" class="btn btn-primary" value="Submit" />
                            <input style="float:left" type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
          
        </div>    
    </section>
    
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

$("#vImg").change(function() {
readURL(this);
});

</script>