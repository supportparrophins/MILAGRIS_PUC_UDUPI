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
<div class="row column_padding_card">
        <div class="col-md-12">
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
        </div>
    </div>
<div class="main-content-container px-3 pt-1 overall_content">
    <div class="content-wrapper">
        <div class="row p-0 column_padding_card">
                <div class="col column_padding_card">
                    <div class="card card-small card_heading_title p-0 m-b-1">
                        <div class="card-body p-2">
                            <div class="row c-m-b">
                                <div class="col-12">
                                            <span class="page-title">
                                                <i class="fa fa-bell"></i> Add Annoucements
                                            </span > 
                                            <a onclick="window.history.back();" class="btn primary_color mobile-btn float-right text-white"
                                            value="Back"><i class="fa fa-arrow-circle-left" ></i> Back </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="card card-small mb-2 pt-1 column_padding_card">
                    <div class="row ">
                        <div class="col-12 column_padding_card">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addUser" action="<?php echo base_url(); ?>addNewMessageToDb" method="post"  enctype="multipart/form-data">
                            <div class="box-body col-12">
                                <div class="row">
                                    <div class="col-md-6">                                
                                        <div class="form-group has-feedback">
                                            <label for="date">Date</label>
                                            <input placeholder="Event Date" type="text" class="form-control required datepicker" value="<?php echo set_value('date'); ?>" id="date" name="date" maxlength="128" autocomplete="off" required>
                                            <i class="glyphicon glyphicon-calendar form-control-feedback"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="link">Link</label>
                                            <input placeholder="Enter Link" type="text" class="form-control required" value="<?php echo set_value('link'); ?>" id="link" name="link" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="message">Message</label>
                                            <textarea placeholder="Enter Message" type="text" class="form-control required" id="message" name="message" autocomplete="off" required><?php echo set_value('message'); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
        
                            <div class="box-footer col-12 ">
                                <input style="float:right;margin-bottom:10px" type="submit" class="btn btn-success" value="Submit" />
                            </div>
                        </form>
                    </div>
              </div>
          </div> 
     </div>
</div>  
    
  
<script>
// function readURL(input) 

// if (input.files && input.files[0]) {
//   var reader = new FileReader();

//   reader.onload = function(e) {
//     $('#uploadedImage').attr('src', e.target.result);
//   }

//   reader.readAsDataURL(input.files[0]);
// }
// }

// $("#vImg").change(function() {
// readURL(this);
// });

jQuery(document).ready(function(){
  jQuery('.datepicker').datepicker({
    autoclose: true,
    format : "dd-mm-yyyy",
    startDate : "today"
  });
});
</script>
