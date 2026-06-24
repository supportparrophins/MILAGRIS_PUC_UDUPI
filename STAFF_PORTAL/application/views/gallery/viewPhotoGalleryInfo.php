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
                            <i class="fas fa-images"></i> View Photo Gallery
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
                        <div class="row">
                        <?php foreach ($photoGalleryList as $photo): ?>
                            <div class="col-md-2 mb-4">
                                <div class="card">
                                    <a href="<?php echo base_url() . $photo->image_path; ?>" target="_blank">
                                        <img src="<?php echo base_url() . $photo->image_path; ?>" class="card-img-top" alt="...">
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
          
        </div>    
 </div>   
</div>

<script>
$("#search_party").change(function() {
    var row_id = $("#search_party").val();
    if (row_id != '') {
        window.open('<?php echo base_url() ?>partyView/' + row_id, "_self");
    }
});


    $(document).ready(function () {
        $('#vImg').change(function () {
            readURL(this);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#uploadedImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    });


</script>