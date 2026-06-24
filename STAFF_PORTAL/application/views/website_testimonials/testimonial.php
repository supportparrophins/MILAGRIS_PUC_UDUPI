<style>
hr{
  margin-bottom: 5px !important;
    margin-top: 0px !important;
    border-top: 1px solid #3c8dbc;
}
 td,th{
      /* border: 1px solid black !important; */
      font-weight: 800;
    }
.box-header {
    padding: 7px !important;
}
.form-control{
    font-weight: 600 !important;
}
input[type=checkbox] {
    cursor: pointer;
    font-size: 10px;
    visibility: hidden;
    position: relative;
    top: 0;
    left: 0;
    transform: scale(1.5);
}

input[type=checkbox]:after {
    content: " ";
    background-color: #fff;
    display: inline-block;
    color: #337ab7;
    width: 10px;
    height: 10px;
    visibility: visible;
    border: 1px solid #3c8dbc;
    padding: 2px;
    margin: 1px 0;
    border-radius: 1px;
    box-shadow: 0 0 15px 0 rgba(0,0,0,0.08), 0 0 2px 0 rgba(0,0,0,0.16);
}

input[type=checkbox]:checked:after {
    content: "\2714";
    display: unset;
    font-weight: bold;
    width: 15px;
    height: 15px;
    padding: 2px
}

.editable-wrapper {
  border: 1px #ccc solid;
}

.label,
.editable { padding: 7px; }

.label {
  float: left;
  font-weight: bold;
  padding-bottom: 0;
  pointer-events:none;
}

.editable { min-height: 100px; }
</style>
<div class="content-wrapper">
 <!-- Content Header (Page header) -->
 <section class="content-header">
    <div class="row"> 
        <div class="col-lg-6">
            <h4>
                <i class="fa fa-bell"></i> <span style="font-size: 23px;font-weight: 600;">News & Events</span>
                <small>SJPUC Website</small>
            </h4>
        </div>
        <div class="col-lg-6">
            <form action="<?php echo base_url() ?>feedbackListing" method="POST" id="searchList">
                <div class="input-group"> 
                    <input type="text" name="searchTextCust" value="<?php echo $searchTextCust ?>" class="form-control input-md pull-right"  style="text-transform: uppercase" placeholder="Search by Name" autocomplete="off"/>
                    <div class="input-group-btn">
                    <button class="btn btn-md btn-primary searchList"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <hr>
    <div class="row" style="margin-bottom: -10px;">
        <div class="col-lg-4 text-center">
            <b class="pull-left" style="font-size: 20px; color: #3c8dbc;">Total Testimonials : <?php echo $count_testimonials ?></b>
        </div>
        <div class="col-lg-6">
        </div>
        <div class="col-lg-2">
        <?php if($role == ROLE_ADMIN ) {
                ?>
        <a class="btn btn-primary pull-right" href="<?php echo base_url(); ?>addTestimonials"><i class="fa fa-plus"></i> Add New Testimonials</a>
        <?php } ?>
        </div>
    </div>
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
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-bordered">
                            <tr class="bg-primary">
                                <th class="text-center">Name</th>
                                <th class="text-center">Message</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            <?php if(!empty($feedbackInfo)) {
                                foreach($feedbackInfo as $feedback) { ?>
                            <tr>
                                <td class="text-center"><?php echo $feedback->name ?></td>
                                <td><?php echo substr($feedback->message, 0, 100) ?></td>
                                <td class="text-center">
                                    <?php if($role == ROLE_OFFICE || $role == ROLE_ADMIN) { ?>
                                    <a class="btn btn-sm btn-info" href="<?php echo base_url().'editTestimonials/'.$feedback->row_id; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                                    
                                    <?php } ?>
                                    <?php if($role == ROLE_ADMIN) {  
                                        if($feedback->status == 1){ ?>
                                        <a class="btn btn-sm btn-danger disableTestimonial" href="#" data-row_id="<?php echo $feedback->row_id; ?>" title="Disable"><i class="fa fa-ban"></i></a>
                                    <?php }else{ ?>
                                        <a class="btn btn-sm btn-success enableTestimonial" href="#" data-row_id="<?php echo $feedback->row_id; ?>" title="Enable"><i class="fa fa-check"></i></a>
                                    <?php } } ?>
                                </td>
                            </tr>
                            <?php } }else{ ?>
                            <tr class="bg-info">
                                <td class="text-center" colspan="6">
                                    No Alumni Testimonials!.
                                </td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <div class="box-footer clearfix">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/portal/websiteCommon.js" charset="utf-8"></script>
<script>
jQuery(document).ready(function(){

    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#searchList").attr("action", baseURL + "feedbackListing/" + value);
        jQuery("#searchList").submit();
    });
});
</script>