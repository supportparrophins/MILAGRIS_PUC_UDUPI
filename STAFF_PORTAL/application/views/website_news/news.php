<?php
    $this->load->helper('form');
    $error = $this->session->flashdata('error');
    if($error)
    {
?>
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    ?php echo $this->session->flashdata('error'); ?>                    
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
<div class="main-content-container px-3 pt-1">               
<div class="row">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>


 <!-- Content Header (Page header) -->
<div class="row p-0">
    <div class="col column_padding_card">
        <div class="card card-small card_heading_title p-0 m-b-1">
            <div class="card-body p-2">
                <div class="row c-m-b">
                    <div class="col-8 col-sm-4 col-md-5">
                        <span class="page-title absent_table_title_mobile">
                           <i class="material-icons">web</i> Website News
                        </span>
                    </div>
                    <div class="col-4 col-sm-4 col-md-3">
                        <div class="text-center text-dark">
                            <b class="pull-left" style="font-size: 20px;">Total : <?php echo $count_news ?></b>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 col-md-4 box-tools">
                        <a onclick="window.history.back();" class="btn primary_color border_left_radius mobile-btn float-right text-white pt-2"
                            value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                               
                        <a href="<?php echo base_url(); ?>addNews" class="btn btn-md btn-primary mobile-btn float-right mb-1 border_right_radius"><i class="fa fa-plus"></i> Add</a>
                             
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row form-employee">
    <div class="col-12 column_padding_card">
        <div class="card card-small c-border p-1">
            <div class="table-responsive-sm">
                <table class="table table-bordered text-dark">
                    <form action="<?php echo base_url() ?>newsListing" method="POST" id="searchList">
                        <tr class="filter_row">
                            <th>
                                <div class="form-group"> 
                                    <input type="text" name="by_date" value="<?php echo $by_date; ?>" class="form-control form-control-md  datepicker pull-right" placeholder="Search by Date" autocomplete="off"/>
                                </div>
                            </th>
                            <th width="300"></th>
                            <th></th>
                            <!-- <th> 
                                <div class="form-group"> 
                                    <input type="text" name="location" value="<?php echo $location; ?>" class="form-control form-control-md  pull-right" placeholder="Search by Location" autocomplete="off"/>
                                </div>
                            </th> -->
                            <th>
                                <button class="btn btn-block btn-success searchList"><i class="fa fa-filter"></i> Filter </button>
                            </th>
                        </tr>
                    </form>
                        <thead class="text-center">
                            <tr class="table_row_background">
                                <th>Date</th>
                                <th>Title</th>
                                <th>Description</th>
                                <!-- <th>Location</th> -->
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <thead class="text-center">
                            <?php if(!empty($newsInfo)) {
                                foreach($newsInfo as $news) { ?>
                            <tr>
                                <?php if($news->date == '0000-00-00'){ ?>
                                <td class="text-center">00-00-0000</td>
                                <?php }else{ ?>
                                <td class="text-center"><?php echo date('d-m-Y',strtotime($news->date)) ?></td>
                                <?php } ?>
                                <td class="text-left"><?php echo $news->subject ?></td>
                                <td class="text-left"><?php echo substr($news->description, 0, 50) ?></td>
                                <!-- <td class="text-center"><?php echo $news->location ?></td> -->

                                <td class="text-center">
                                    <!-- <a class="btn btn-sm btn-primary " href="#" data-userid="" title="View"><i class="fa fa-eye"></i></a> -->
                                    <a class="btn btn-xs btn-info" href="<?php echo base_url().'editNews/'.$news->row_id; ?>" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                    
                                    <?php if($news->status == 1){ ?>
                                        <a class="btn btn-xs btn-danger disableNews" href="#" data-row_id="<?php echo $news->row_id; ?>" title="Disable"><i class="fa fa-ban"></i></a>
                                    <?php }else{ ?>
                                        <a class="btn btn-xs btn-success enableNews" href="#" data-row_id="<?php echo $news->row_id; ?>" title="Enable"><i class="fa fa-check"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } }else{ ?>
                            <tr class="table-info">
                                <td class="text-center" colspan="6">
                                    No Events!.
                                </td>
                            </tr>
                            <?php } ?>
                            </thead>
                        </table>
                    </div>
                    <div class="box-footer clearfix">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div>
            </div>
        </div>
 

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/websiteCommon.js" charset="utf-8"></script>
<script>
jQuery(document).ready(function(){

    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#searchList").attr("action", baseURL + "newsListing/" + value);
        jQuery("#searchList").submit();
    });
    
    jQuery('.datepicker').datepicker({
        autoclose: true,
        format : "dd-mm-yyyy",
        startDate : "01-01-2020"
    });
});
</script>

  