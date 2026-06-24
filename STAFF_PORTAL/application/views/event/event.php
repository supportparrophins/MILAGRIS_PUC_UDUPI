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
                        <i class="fas fa-newspaper"></i> Event Register
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
                        <a href="<?php echo base_url(); ?>addEvents" class="btn btn-primary mobile-btn float-right pt-2 border_right_radius"><i class="fa fa-plus"></i> Add</a>
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
                    <form action="<?php echo base_url() ?>eventListing" method="POST" id="searchList">
                        <tr class="filter_row">
                            <th>
                                <div class="form-group"> 
                                    <input type="text" name="by_date" value="<?php echo $by_date; ?>" class="form-control form-control-md  datepicker pull-right" placeholder="Search by Date" autocomplete="off"/>
                                </div>
                            </th>
                            <th></th>
                            <th></th>
                            <th> 
                                <div class="form-group"> 
                                    <input type="text" name="location" value="<?php echo $location; ?>" class="form-control form-control-md  pull-right" placeholder="Search by Location" autocomplete="off"/>
                                </div>
                            </th>
                            <th>
                                <button class="btn btn-block btn-success searchList"><i class="fa fa-filter"></i>Filter</button>
                            </th>
                        </tr>
                    </form>
                        <thead class="text-center">
                            <tr class="table_row_background">
                                <th width="150">Date</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th width="180">Location</th>
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
                                <td class="text-left"><?php echo htmlspecialchars_decode(substr($news->description, 0, 50)) ?></td>
                                <td class="text-center"><?php echo $news->location ?></td>

                                <td class="text-center">
                                    <a class="btn btn-xs btn-primary " href="<?php echo base_url().'viewEvent/'.$news->row_id; ?>" title="View"><i class="fa fa-eye"></i></a>
                                    <a class="btn btn-xs btn-info" href="<?php echo base_url().'editEvent/'.$news->row_id; ?>" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a class="btn btn-xs btn-danger deleteEventregister" href="#" data-row_id="<?php echo $news->row_id; ?>" title="Delete Event"><i class="fa fa-trash"></i></a>
                                    <!-- <?php if($news->status == 1){ ?>
                                        <a class="btn btn-xs btn-danger disableNews" href="#" data-row_id="<?php echo $news->row_id; ?>" title="Disabled"><i class="fa fa-ban"></i></a>
                                    <?php }else{ ?>
                                        <a class="btn btn-xs btn-success enableNews" href="#" data-row_id="<?php echo $news->row_id; ?>" title="Enabled"><i class="fa fa-check"></i></a>
                                    <?php } ?> -->
                                    <a class="btn btn-xs btn-primary" target="_blank"
                                                href="<?php echo base_url() ?>getEventPDFPrint/<?php echo $news->row_id; ?>"
                                                title="Print"><i class="fa fa-print"></i></a> 
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

<script>
	// Websiite News
	jQuery(document).on("click", ".disableNews", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "enableNews",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to enable this News ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
				 
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("News successfully Enabled"); 
				window.location.reload();
			}
				else if(data.status = false) { alert("Failed to Enabled"); }
				else { alert("Access denied..!"); }
			});
		}
	});
    jQuery(document).on("click", ".deleteEventregister", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "deleteEventregister",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Event ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
				 
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Event successfully Deleted"); 
				window.location.reload();
			}
				else if(data.status = false) { alert("Failed to Delete"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	jQuery(document).on("click", ".enableNews", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "disableNews",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to disable this News ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
				 
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("News successfully Disabled"); 
				window.location.reload();
			}
				else if(data.status = false) { alert("Failed to Disable"); }
				else { alert("Access denied..!"); }
			});
		}
	});
jQuery(document).ready(function(){

    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#searchList").attr("action", baseURL + "eventListing/" + value);
        jQuery("#searchList").submit();
    });
    
    jQuery('.datepicker').datepicker({
        autoclose: true,
        format : "dd-mm-yyyy",
        startDate : "01-01-2020"
    });
});
</script>

  