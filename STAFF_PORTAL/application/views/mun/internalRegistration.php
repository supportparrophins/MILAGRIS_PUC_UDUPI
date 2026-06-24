
<style>
.select2-container .select2-selection--single {
    height: 38px !important;
    width: 360px !important;
}


.form-control {
    border: 1px solid #000000 !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow b {
    margin-top: 3px !important;
    color: black !important;

}

@media screen and (max-width: 480px) {
    .select2-container--default .select2-selection--single .select2-selection__arrow {

        margin-right: 20px !important;
    }

    .select2-container .select2-selection--single {
        width: 270px !important;
    }
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
                            <div class="col-lg-8 col-12 col-md-4 box-tools">
                                <span class="page-title">
                                    <i class="material-icons">event</i> MUN INTERNAL REGISTRATION
                                </span>
                            </div>
                            <div class="col-lg-4 col-12 col-md-6 col-sm-6">
                                <b class="text-dark" style="font-size: 20px;">Total: <?php echo $totalCount; ?></b>
                            </div>
                            <!-- <div class="col-lg-4 col-md-3 col-12"> -->
                                <!-- <a href="#" onclick="GoBackWithRefresh();return false;" class="btn text-white primary_color btn-bck float-right mobile-bck ">
                                <i class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Back </a> -->
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2 table-responsive">
                        <table class="display table table-bordered table-striped table-hover w-100">
                            <form action="<?php echo base_url(); ?>getInternalRegistration" method="POST" id="byFilterMethod"  enctype="multipart/form-data">
                                <tr class="filter_row" class="text-center">
                                    <!-- <td></td> -->
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $student_id; ?>" name="student_id" id="student_id" class="form-control input-sm" placeholder="By Student ID" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $name; ?>" name="name" id="name" class="form-control input-sm" placeholder="By Name" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $mobile_no; ?>" name="mobile_no" id="mobile_no" class="form-control input-sm" placeholder="By Mobile" autocomplete="off" maxlength="10">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <select class="form-control" name="term" id="term">
                                                <?php if(!empty($term)){ ?>
                                                    <option value="<?php echo $term; ?>" selected><b>Selected: <?php echo $term; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Term</option>
                                                <option value="I PUC">I PUC</option>
                                                <option value="II PUC">II PUC</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $stream; ?>" name="stream" id="stream" class="form-control input-sm" placeholder="By Stream" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <select class="form-control" name="committee" id="committee">
                                                <?php if(!empty($committee)){ ?>
                                                    <option value="<?php echo $committee; ?>" selected><b>Selected: <?php echo $committee; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Preferred Allotments</option>
                                                <option value="UNSC">UNSC</option>
                                                <option value="UNHRC">UNHRC</option>
                                                <option value="ECOSOC">ECOSOC</option>
                                                <option value="AIPPM">AIPPM</option>
                                                <option value="CCC">CCC</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="submit"class="btn btn-success btn-block mobile-width"><i class="fa fa-filter"></i> Filter</button>
                                    </td>
                                </tr>
                            </form>
                            <thead>
                                <tr class="table_row_background text-center">
                                    <!-- <th width="25"><input type="checkbox" id="selectAll" /></th> -->
                                    <th width="150">Student ID</th>
                                    <th width="350">Name</th>
                                    <th width="350">Mobile No.</th>
                                    <th width="110">Term</th>
                                    <th width="140">Stream</th>
                                    <th width="140">Allotment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($studentInfo)){
                                    foreach($studentInfo as $std){ 
                                       
                                        
                                    ?>
                                    <tr>
                                        <!-- <th><input type="checkbox" class="singleSelect" value="<?php echo $std->student_id; ?>" /></th> -->
                                        <th class="text-center"><?php echo $std->student_id; ?></th>
                                        <th><?php echo $std->student_name; ?></th>
                                        <th class="text-center"><?php echo $std->whatsapp_no; ?></th>
                                        <th class="text-center"><?php echo $std->term_name; ?></th>
                                        <th class="text-center"><?php echo $std->stream_name; ?></th>
                                        <th class="text-center"><?php echo $std->committee; ?></th>
                                        <th class="text-center" width="140">
                                           
                                            <?php if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR){ ?>
                                                <a class="btn btn-xs btn-danger deleteInternalEvent mb-1"
                                                data-row_id="<?php echo $std->row_id; ?>" href="#" title="Delete">
                                                <i class="fas fa-trash"></i></a>
                                            <?php } ?>
                                                                
                                           
                                        </th>
                                    </tr>
                                <?php } }else{  ?>
                                <tr>
                                    <th colspan="9" class="text-center">Record Not Found</th>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="float-right">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "getInternalRegistration/" + value);
        jQuery("#byFilterMethod").submit();
    });
   
    
    $(".custom_loader").hide();
    $("#custom_loader_text").css('display','none');

    jQuery('.datepicker, .dateSearch').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });

    //checkbox select
    $('#selectAll').click(function() {
        if ($('#selectAll').is(':checked')) {
            $('.singleSelect').prop('checked', true);
        } else {
            $('.singleSelect').prop('checked', false);
        }
    });
    
	jQuery(document).on("click", ".deleteInternalEvent", function(){
        var row_id = $(this).data("row_id"),
            hitURL = baseURL + "deleteInternalEvent",
            currentRow = $(this);
        var confirmation = confirm("Are you sure to delete this record ?");
        if(confirmation){
            jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : { row_id : row_id } 
            }).done(function(data){
                currentRow.parents('tr').remove();
                if(data.status = true) { alert("record successfully deleted"); }
                else if(data.status = false) { alert("record deletion failed"); }
                else { alert("Access denied..!"); }

            });
        }
    });
});
</script>