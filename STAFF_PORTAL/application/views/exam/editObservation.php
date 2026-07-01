<style>
    .bootstrap-select > .dropdown-toggle.bs-placeholder{
        color: #000;
    }
.dropdown-menu {
        color: #000;
    }
</style>
<?php
$this->load->helper('form');
$error = $this->session->flashdata('error');
if ($error) { 
    ?>
<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <i class="fa fa-check mx-2"></i>
    <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
</div>
<?php } ?>
<?php
        $success = $this->session->flashdata('success');
        if ($success) {
        ?>
<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <i class="fa fa-check mx-2"></i>
    <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
</div>
<?php }?>
<?php
        $warning = $this->session->flashdata('warning');
        if ($warning) {
        ?>
<div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <i class="fa fa-check mx-2"></i>
    <strong>warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
</div>
<?php }?>
<div class="row">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container container-fluid px-4 pt-2">
    <div class="content-wrapper">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12 col-lg-12 padding_left_right_null">
                <div class="card ">
                    <div class="card-header text-white card-content-title p-1 card_head_dashboard">
                        <div class="row ">
                            <div class="col-md-6 col-8 text-black m-auto " style="font-size:22px;"><i class="fas fa-pencil-alt"></i> Edit Remarks </span> 
                            </div>
                            <div class="col-md-6 col-4 m-auto"> <a href="#"onclick="GoBackWithRefresh();return false;"
                                    class="btn primary_color mobile-btn float-right text-white border_left_radius"><i
                                        class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Back </a></div>
                        </div>
                    </div>
                    <div class="card-body contents-body">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" action="<?php echo base_url() ?>updateStudentObservation" method="post" role="form" enctype="multipart/form-data">
                             <input type="hidden" value="<?php echo $observationInfo->row_id; ?>" id="row_id" name="row_id">
                            <div class="row form-contents">
                                 <div class="col-lg-12">
                                    
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label>Date</label>
                                            <div class="form-group">
                                                <input type="text" value="<?php echo date('d-m-Y',strtotime($observationInfo->date)) ?>" name="date" id="date" 
                                                class="form-control observe_date input-sm " placeholder="Date" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Select Student</label>
                                                <select class="form-control input-sm selectpicker" id="student_rowId" name="student_rowId" data-live-search="true" required>
                                                    <?php if(!empty($observationInfo->student_row_id)){ ?>
                                                            <option value="<?php echo $observationInfo->student_row_id; ?>"><?php echo $observationInfo->sat_number . ' - '.$observationInfo->student_name. ' - ' .$observationInfo->term_name ?></option>
                                                    <?php } ?>
                                                    <option value="">Select Student</option>
                                                    <?php if(!empty($getStudentInfo)){ 
                                                        foreach($getStudentInfo as $stdinfo){ ?>
                                                            <option value="<?php echo $stdinfo->row_id; ?>"><?php echo $stdinfo->sat_number . ' - ' .$stdinfo->student_name . ' - ' .$stdinfo->term_name?></option>
                                                        <?php } } ?>
                                                </select>
                                            </div>
                                        </div>         
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Select Type</label>
                                                <textarea name="remarks" id="remarks" class="form-control" placeholder="Enter remarks" autocomplete="off" required><?php echo $observationInfo->remarks; ?></textarea>

                                                <!-- <select class="form-control input-sm selectpicker" id="observe_type_id" name="observe_type_id" data-live-search="true" required>
                                                    <?php if(!empty($observationInfo->type_id)){ ?>
                                                            <option value="<?php echo $observationInfo->type_id; ?>"><?php echo $observationInfo->observation_name; ?></option>
                                                    <?php } ?>
                                                    <option value="">Select Type</option>
                                                    <?php if(!empty($getObservationId)){ 
                                                        foreach($getObservationId as $obsinfo){ ?>
                                                            <option value="<?php echo $obsinfo->row_id; ?>"><?php echo $obsinfo->observation_name; ?></option>
                                                        <?php } } ?>
                                                </select> -->
                                            </div>
                                        </div>     
                                        
                                        
                                        <div class="col-lg-6">
                                            <div class="form-group text-center">
                                                <!-- <label>Upload file</label> -->
                                                <?php if(!empty($observationInfo->file_path)){ 
                                                    $ext = pathinfo($observationInfo->file_path, PATHINFO_EXTENSION); 
                                                        if($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png'){ 
                                                    ?>
                                                    
                                                    <img src="<?php echo base_url(); ?><?php echo $observationInfo->file_path; ?>"
                                                        class="avatar rounded-circle img-thumbnail" width="130" height="130" src="#"
                                                        id="uploadedImage" name="userfile" width="130" height="130" alt="avatar">
                                                <?php }else{ ?>
                                                    
                                                    <img src="<?php echo base_url(); ?>assets/dist/img/document.png"
                                                        class="avatar rounded-circle img-thumbnail" width="130" height="130" src="#"
                                                        id="uploadedImage" name="userfile" width="130" height="130" alt="avatar">
                                                <?php } } ?>
                                                <div class="profileImg">
                                                    <div class="file btn btn-sm btn-primary">
                                                        Change
                                                        <input type="file" class="form-control-sm" id="vImg" name="userfile" accept="*.jpg,*.png,*.jpeg,,*.pdf">
                                                     
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea name="description" id="description" class="form-control" placeholder="Enter Description" autocomplete="off" required><?php echo $observationInfo->description; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                  <input type="submit" class="btn btn-success m-2 float-right" value="Update" />
                          </div>
                            
                            
                         </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
function GoBackWithRefresh(event) {
    if ('referrer' in document) {
        window.location = '<?php echo base_url(); ?>observationListing';
        /* OR */
        //location.replace(document.referrer);
    } else {
        window.history.back();
    }
    
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57) )
        return false;
    return true;
}

function isNumber(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 48  && 
        (charCode < 48 || charCode > 57) )
        return false;
    return true;
}

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


jQuery(document).ready(function() {
    jQuery('.observe_date').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy",
        startDate : "01-11-2021",

    });
 
//     jQuery('.datepicker').datepicker({
//         autoclose: true,
//         orientation: "bottom",
//         format: "dd-mm-yyyy",
//         startDate : "01-11-2021"

//     });

// });

// $('.start_time').datetimepicker(
//         {

//           format: 'hh:mm A',
//           icons: {
//                     up: "fa fa-chevron-up",
//                   down: "fa fa-chevron-down"
//                  }

});




</script>