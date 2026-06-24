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
    <strong>Error!</strong>
    <?php echo $this->session->flashdata('error'); ?>
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

<div class="main-content-container px-3 pt-1 overall_content">
    <div class="row column_padding_card">
        <div class="col-md-12">
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class="col-lg-5 col-12 col-md-5 box-tools">
                                <span class="page-title">
                                    <i class="fas fa-rupee-sign"></i> Fee Concession New Admission
                                </span>
                            </div>
                            <div class="col-lg-3 col-12 col-md-6 col-sm-6">
                                <b class="text-dark" style="font-size: 20px;">Total Students:
                                    <?php echo $totalCount; ?></b>
                            </div>
                            <div class="col-lg-4 col-12 col-md-6 col-sm-6">
                                <a onclick="showLoader();window.history.back();"
                                    class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                <a class="btn btn-primary pull-right mobile-btn border_right_radius" href="#"
                                    data-toggle="modal" data-target="#concessionModal">
                                    <i class="fa fa-plus"></i> Add New</a>

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
                            <form action="<?php echo base_url(); ?>viewFeeConcessionNewAdmission" method="POST" id="byFilterMethod">
                                <tr class="filter_row" class="text-center">
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $application_no; ?>" name="application_no" id="by_name"
                                                class="form-control input-sm" placeholder="App No" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="" name="by_name" id="by_name"
                                                class="form-control input-sm" placeholder="Name" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="" name="amount" id="amount"
                                                class="form-control input-sm" placeholder="Amount" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="" name="by_date" id="by_date"
                                                class="form-control input-sm datepicker" placeholder="Date"
                                                autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-success btn-block mobile-width"><i
                                                class="fa fa-filter"></i> Filter</button>
                                    </td>
                                </tr>
                            </form>
                            <thead>
                                <tr class="text-center table_row_background">
                                    <!-- <th><input type="checkbox" id="selectAll" /></th> -->
                                    <th>Application No</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($concessionInfo)){
                                    foreach($concessionInfo as $fee){ ?>
                                <tr>
                                    <th><?php echo $fee->application_no; ?></th>
                                    <th><?php echo $fee->student_name; ?></th>
                                    <th class="text-center"><?php echo $fee->fee_amt; ?></th>
                                    <th class="text-center"><?php echo date('d-m-Y',strtotime($fee->date)); ?></th>
                                    <th class="text-center">

                                        <?php 
                                        if($fee->payment_status == 0){
                                        if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR){ ?>
                                            <a class="btn btn-sm btn-danger deleteConcession px-2 py-1" href="#"
                                            data-row_id="<?php echo $fee->row_id; ?>" title="Delete Staff"><i
                                                class="fa fa-trash"></i></a>
                                       <?php  } 
                                    }else{
                                        echo "<b style='color:green'>Paid</b>";
                                    }

                                        ?>
                                         <!-- <a href="<?php echo base_url(); ?>feePaymentReceiptPrintForConcession/<?php echo $fee->student_id; ?>"
                                            target="_blank">Receipt</a> -->
                                        
                                    </th>
                                </tr>
                                <?php } }else{  ?>
                                <tr>
                                    <th colspan="8" class="text-center">Fee Concession Record Not Found</th>
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

    <div class="modal" id="concessionModal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="padding: 7px 15px;">
                    <h4 class="modal-title">Add New Concession</h4>
                    <button type="button" class="close float-right" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body p-2">
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addConcessionInfo" action="<?php echo base_url() ?>addNewAdmFeeConcession"
                        method="post" role="form">
                        <div class="row form-contents">
                            <div class="col-lg-6">
                            <div class="form-group mb-2">
                                    <select class="form-control selectpicker" data-live-search="true"
                                        name="application_no" id="student_row_id" required autocomplete="off">
                                        <option value="">Select Student</option>
                                        <?php if(!empty($studentInfo)){
                                            foreach($studentInfo as $std){  ?>
                                        <option value="<?php echo $std->application_number; ?>">
                                            <b><?php echo $std->application_number; ?></b></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <input type="text" class="form-control " id="fee_amount" name="fee_amount"
                                        placeholder="Enter Concession Amount" onkeypress="return isNumberKey(event)"
                                        required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-0">
                                    <textarea type="text" class="form-control" id="description" name="description"
                                        rows="5" placeholder="Enter Description" required autocomplete="off"
                                        maxlength="1500"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer" style="padding: 7px 15px;">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" form="addConcessionInfo" class="btn btn-success pull-right" value="Save" />
                </div>

            </div>
        </div>
    </div>


</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/fee.js" charset="utf-8"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "viewFeeConcession/" + value);
        jQuery("#byFilterMethod").submit();
    });

    jQuery('.datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy",
        endDate: "today"
    });

    //checkbox select
    $('#selectAll').click(function() {
        if ($('#selectAll').is(':checked')) {
            $('.singleSelect').prop('checked', true);
        } else {
            $('.singleSelect').prop('checked', false);
        }
    });









    	//delete fees structure
	jQuery(document).on("click", ".deleteConcession", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "deleteAdmFeeConcession",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Concession?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
					
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Fee Concession successfully deleted"); }
				else if(data.status = false) { alert("Fee Concession deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
    });
});

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>