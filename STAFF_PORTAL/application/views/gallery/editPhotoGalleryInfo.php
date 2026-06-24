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
                            <i class="fas fa-images"></i> Edit Gallery
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
                        <form role="form"  onsubmit="return checkForTheCondition();"  action="<?php echo base_url() ?>updatePhotoGalleryDetails" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <input  type="hidden" class="form-control required" value="<?php echo $photoGalleryInfo->row_id; ?>" id="photo_row_id" name="photo_row_id">
                                <div class="col-md-6">                                
                                    <div class="form-group has-feedback">
                                        <label for="date">Date</label>
                                        <input placeholder="Date" type="text" class="form-control required datepicker" value="<?php echo date('d-m-Y', strtotime($photoGalleryInfo->date)); ?>" id="date" name="date" maxlength="128" autocomplete="off" required>
                                        <i class="glyphicon glyphicon-calendar form-control-feedback"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="location">Event Name</label>
                                        <input placeholder="Event Name" type="text" class="form-control required" value="<?php echo $photoGalleryInfo->event_name; ?>" id="event_name" name="event_name" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                          
                              <!-- Display existing images with delete button -->
                                <div class="mb-3">
                                    <label for="existing_images" class="form-label">Existing Images</label>
                                    <div class="row">
                                        <?php foreach ($photoGalleryList as $image): 
                                        ?>
                                            <div class="col-md-2 mb-4">
                                                <div class="card">
                                                    <img src="<?php echo base_url() . $image->image_path; ?>" class="card-img-top" alt="...">
                                                    <button type="button" class="btn btn-danger mt-2 delete-image-button" data-image-id="<?php echo $image->row_id; ?>">Delete</button>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- File input for adding new images -->
                                <div class="mb-3">
                                    <label for="userfile" class="form-label">Add New Images</label>
                                    <input type="file" class="form-control" id="new_images" name="userfile[]" accept=".png,.jpg,.jpeg" multiple>
                                </div>
                                <div id="preview"></div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description"><?php echo $photoGalleryInfo->description; ?></textarea>
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

        $('.delete-image-button').click(function() {
            var image_id = $(this).data('image-id');
            // console.log(image_id);
            // alert(image_id);
            deleteImage(image_id);
        });

        // JavaScript function to delete an image
        function deleteImage(image_id) {
            // Display a confirmation dialog
            var confirmed = confirm("Are you sure you want to delete this image?");
            
            // If user confirms, proceed with deletion
            if (confirmed) {
                console.log("Deleting image with ID: " + image_id);
                
                // Perform AJAX request to delete the image
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() ?>deleteImage',
                    data: { image_id: image_id },
                    success: function(response) {
                        console.log("Image deleted successfully:", response);
                        // Reload the page or update the image list dynamically
                        location.reload(); // For simplicity, we reload the page
                    },
                    error: function(xhr, status, error) {
                        console.error("Error deleting image:", error);
                        // Handle error appropriately
                    }
                });
            }
        }

        document.getElementById('new_images').addEventListener('change', function() {
            var preview = document.getElementById('preview');
            preview.innerHTML = ''; // Clear previous preview

            var files = this.files;
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                if (file.type.match('image.*')) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '100px'; // Adjust as needed
                        img.style.maxHeight = '100px'; // Adjust as needed
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

    });
</script>