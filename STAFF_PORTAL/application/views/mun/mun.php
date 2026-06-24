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
                            <div class="col-lg-4 col-12 col-md-4 box-tools">
                                <span class="page-title">
                                    <i class="material-icons">event</i> MUN EXTERNAL REGISTRATION
                                </span>
                            </div>
                            <div class="col-lg-4 col-12 col-md-6 col-sm-6">
                                <b class="text-dark" style="font-size: 20px;">Total: <?php echo $totalCount; ?></b>
                            </div>
                            <div class="col-lg-4 col-md-3 col-12">
                                <!-- <a href="#" onclick="GoBackWithRefresh();return false;" class="btn text-white primary_color btn-bck float-right mobile-bck ">
                                <i class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Back </a> -->
                            </div>
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
                            <form action="<?php echo base_url(); ?>getMunEventInfo" method="POST" id="byFilterMethod"  enctype="multipart/form-data">
                                <tr class="filter_row" class="text-center">
                                    <!-- <td></td> -->
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $name; ?>" name="name" id="name" class="form-control input-sm" placeholder="By College" autocomplete="off">
                                        </div>
                                    </td>
                                    <td width="180">
                                        <div class="form-group mb-0">
                                            <select class="form-control" name="registeration_type" id="registeration_type">
                                                <?php if(!empty($registeration_type)){ ?>
                                                    <option value="<?php echo $registeration_type; ?>" selected><b>Selected: <?php echo $registeration_type; ?></b></option>
                                                <?php } ?>
                                                <option value="">Search By Type</option>
                                                <option value="PRIVATE Delegation">PRIVATE Delegation</option>
                                                <option value="INSTITUTION Delegation">INSTITUTION Delegation</option>
                                                <option value="INDIVIDUAL Delegation">INDIVIDUAL Delegation</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $mobile_no; ?>" name="mobile_no" id="mobile_no" class="form-control input-sm" placeholder="By Mobile" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <select class="form-control" name="status" id="status">
                                                <?php if(!empty($status)){ ?>
                                                    <option value="<?php echo $status; ?>" selected><b>Selected: <?php echo $status; ?></b></option>
                                                <?php } ?>
                                                <option value="">By status</option>
                                                <option value="Paid">Paid</option>
                                                <option value="Not Paid">Not Paid</option>
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
                                    <th width="350">College</th>
                                    <th width="350">Registration Type</th>
                                    <th width="140">Mobile</th>
                                    <th width="110">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($studentInfo)){
                                    foreach($studentInfo as $std){ 
                                       
                                        
                                    ?>
                                    <tr>
                                        <!-- <th><input type="checkbox" class="singleSelect" value="<?php echo $std->student_id; ?>" /></th> -->
                                        <th><?php echo $std->college_name; ?></th>
                                        <th><?php echo $std->registeration_type; ?></th>
                                        <th class="text-center"><?php echo $std->mobile; ?></th>
                                        <th class="text-center"><?php  if($std->payment_status==1){
                                            echo '<span class="text-success">Paid</span>';
                                        }else{
                                            echo '<span class="text-danger">Not Paid</span>';
                                        } ?></th>
                                        <th class="text-center" width="140">
                                            <a class="btn btn-xs btn-primary mb-1" target="_blank"
                                            href="<?php echo base_url(); ?>viewEventParticipantInfo/<?php echo $std->row_id; ?>"
                                            title="View More"><i class="fa fa-eye"></i></a>
                                            <?php if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR){ ?>
                                                <a class="btn btn-xs btn-danger deleteEvent mb-1"
                                                data-row_id="<?php echo $std->row_id; ?>" href="#" title="Delete">
                                                <i class="fas fa-trash"></i></a>
                                            <?php } ?>
                                                                
                                           
                                        </th>
                                    </tr>
                                <?php } }else{  ?>
                                <tr>
                                    <th colspan="8" class="text-center">Record Not Found</th>
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
        jQuery("#byFilterMethod").attr("action", baseURL + "getMunEventInfo/" + value);
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
    
	jQuery(document).on("click", ".deleteEvent", function(){
        var row_id = $(this).data("row_id"),
            hitURL = baseURL + "deleteEvent",
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