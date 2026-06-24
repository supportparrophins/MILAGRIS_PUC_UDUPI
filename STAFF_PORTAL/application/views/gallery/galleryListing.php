<style>
     .thumbnail-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .thumbnail-preview img {
        max-width: 100px;
        height: auto;
    }
</style>
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
                        <i class="fas fa-images"></i> Gallery
                        </span>
                    </div>
                    <div class="col-4 col-sm-4 col-md-3">
                        <div class="text-center text-dark">
                            <b class="pull-left" style="font-size: 20px;">Total : <?php echo $count_gallery ?></b>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 col-md-4 box-tools">
                        <a onclick="window.history.back();" class="btn primary_color border_left_radius mobile-btn float-right text-white pt-2"
                            value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                            <button class="btn btn-md btn-primary mobile-btn float-right mb-1 border_right_radius" data-toggle="modal"
                            data-target="#addPhotoGallery"><i class="fa fa-plus"></i> Add New</a>
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
                    <form action="<?php echo base_url() ?>viewGalleryInfo" method="POST" id="searchList">
                        <tr class="filter_row">
                            <th>
                                <div class="form-group"> 
                                    <input type="text" name="by_date" value="<?php echo $by_date; ?>" class="form-control form-control-md  datepicker pull-right" placeholder="Search by Date" autocomplete="off"/>
                                </div>
                            </th>
                            <th> 
                                <div class="form-group"> 
                                    <input type="text" name="event_name" value="<?php echo $event_name; ?>" class="form-control form-control-md  pull-right" placeholder="Search by Event Name" autocomplete="off"/>
                                </div>
                            </th>
                            <th></th>
                            <th>
                                <button class="btn btn-block btn-success searchList"><i class="fa fa-filter"></i>Filter</button>
                            </th>
                        </tr>
                    </form>
                        <thead class="text-center">
                            <tr class="table_row_background">
                                <th width="150">Date</th>
                                <th width="180">Event Name</th>
                                <th>Description</th>
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
                                <td class="text-left"><?php echo $news->event_name ?></td>
                                <td class="text-left"><?php echo htmlspecialchars_decode(substr($news->description, 0, 50)) ?></td>

                                <td class="text-center">
                                    <!-- <a class="btn btn-sm btn-primary " href="#" data-userid="" title="View"><i class="fa fa-eye"></i></a> -->
                                    <a class="btn btn-xs btn-secondary" href="<?php echo base_url().'editPhotoGalleryDetails/'.$news->row_id; ?>" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a class="btn btn-xs btn-info" href="<?php echo base_url().'viewPhotoGalleryDetails/'.$news->row_id; ?>" title="View"><i class="fa fa-eye"></i></a>
                                    <a class="btn btn-xs btn-danger deleteGallery" href="#" data-row_id="<?php echo $news->row_id; ?>" title="Delete"><i class="fa fa-trash"></i> Delete</a>
                                  
                                </td>
                            </tr>
                            <?php } }else{ ?>
                            <tr class="table-info">
                                <td class="text-center" colspan="6">
                                    No Gallery!.
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

<div class="modal" id="addPhotoGallery">
    <div class="modal-dialog modal-xl"  style="max-width:800px">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Add Photo Gallery</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" action="<?php echo base_url().'addNewPhotoGallery'?>"  enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input placeholder="Date" type="text" class="form-control required datepicker" value="<?php echo set_value('date'); ?>" id="date" name="date" maxlength="128" autocomplete="off" required>
                                <i class="glyphicon glyphicon-calendar form-control-feedback"></i>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="subject">Event Name </label>
                                <input placeholder="Event Name" type="text" class="form-control required" value="<?php echo set_value('subject'); ?>" id="event_name" name="event_name" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="vImg" class="form-label">Upload Image</label>
                        <input class="form-control" type="file" accept=".png,.jpg,.jpeg" name="userfile[]" id="vImg" multiple="multiple" onchange="displayImages(event)"> 
                    </div> 
                    <div id="imagePreview" class="thumbnail-preview"></div>
                    <div id="fileCount" class="mb-3">Selected files: 0</div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="reason">Description</label>
                                <textarea name="reason" class="form-control" id="reason" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
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
    jQuery(document).on("click", ".deleteGallery", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "deletePhotoGallery",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Gallery?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
					
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Gallery successfully deleted"); }
				else if(data.status = false) { alert("Gallery deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
jQuery(document).ready(function(){

    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#searchList").attr("action", baseURL + "viewGalleryInfo/" + value);
        jQuery("#searchList").submit();
    });
    
    jQuery('.datepicker').datepicker({
        autoclose: true,
        format : "dd-mm-yyyy",
        startDate : "01-01-2020"
    });
});

function displayImages(event) {
    const files = event.target.files;
    const imagePreview = document.getElementById('imagePreview');

    imagePreview.innerHTML = ''; // Clear previous images

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();

        reader.onload = function (e) {
            const img = document.createElement('img');
            img.src = e.target.result;

            const thumbnailContainer = document.createElement('div');
            thumbnailContainer.className = 'thumbnail-container';
            thumbnailContainer.appendChild(img);

            imagePreview.appendChild(thumbnailContainer);

            updateFileCount(); // Update the count of selected files
        };

        reader.readAsDataURL(file);
    }
}

function updateFileCount() {
    const fileCount = document.querySelectorAll('.thumbnail-container').length;
    document.getElementById('fileCount').textContent = 'Selected files: ' + fileCount;
}
</script>

  