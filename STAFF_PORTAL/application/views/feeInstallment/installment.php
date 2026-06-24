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
    <form action="<?php echo base_url(); ?>feeInstallmentListing" method="POST" id="byFilterMethod">

        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class="col-lg-5 col-6 col-md-4 col-sm-4 box-tools">
                                <span class="page-title">
                                    <i class="fas fa-rupee-sign"></i> Instalment
                                </span>
                            </div>
                            <div class="col-lg-2 col-6 col-md-4 col-sm-4">
                                <b class="text-dark" style="font-size: 20px;">Total:
                                    <?php echo $totalCount; ?></b>
                            </div>
                            <div class="col-3">
                            <div class="input-group float-right">
                                <select class="form-control" name="year" id="year">
                                    <?php if(!empty($year)){ ?>
                                                    <option value="<?php echo $year; ?>" selected><b><?php echo $year; ?></b></option>
                                    <?php } ?>
                                    <option value="2022">2022</option>
                                    <option value="2021">2021</option>
                                </select>
                                <div class="form-group">
                                    <button class="btn btn-success" type="submit">Search</button>
                                </div>
                            </div>
                            </div>
                            <div class="col-lg-2 col-12 col-md-4 col-sm-4">
                                
                                <a onclick="showLoader();window.history.back();"
                                    class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                <a class="btn btn-primary pull-right mobile-btn border_right_radius" href="#"
                                    data-toggle="modal" data-target="#concessionModal">
                                    <i class="fa fa-plus"></i> Add</a>

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
                                <tr class="filter_row" class="text-center">
                                <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $last_date; ?>" name="last_date" id="last_date" 
                                            class="form-control input-sm datepicker" placeholder="Search Date" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $student_id; ?>" name="student_id" id="student_id" 
                                            class="form-control input-sm" placeholder="Student ID" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $student_name; ?>" name="student_name" id="student_name" 
                                            class="form-control input-sm" placeholder="Name" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $amount; ?>" name="amount" id="amount" 
                                            class="form-control input-sm" placeholder="Amount" autocomplete="off">
                                        </div>
                                    </td>
                                     <td></td>
                                    <td>
                                        <button type="submit"class="btn btn-success btn-block mobile-width"><i class="fa fa-filter"></i> Filter</button>
                                    </td>
                                </tr>
                            </form>
                            <thead>
                                <tr class="text-center table_row_background">
                                    <th>Payment Last Date</th>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th width="140">Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($installmentInfo)){
                                    foreach($installmentInfo as $fee){ ?>
                                <tr>
                                    <th class="text-center" width="130"><?php echo date('d-m-Y',strtotime($fee->last_date)); ?></th>
                                    <th class="text-center" width="160"><?php echo $fee->student_id; ?></th>
                                    <th width="300"><?php echo $fee->student_name; ?></th>
                                    <th class="text-center" width="130"><?php echo $fee->amount; ?></th>
                                    <th><?php echo $fee->remarks; ?></th>
                                    <th width="160" class="text-center">

                                        <?php if($fee->payment_status == 0){  ?>
                                            <a class="btn btn-xs btn-info"
                                            href="<?php echo base_url(); ?>editFeeInstallment/<?php echo $fee->row_id; ?>" title="Edit"><i
                                            class="fas fa-pencil-alt"></i></a>
                                            <?php if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_PRINCIPAL){ ?>
                                                <a class="btn btn-xs btn-danger deleteFeeInstallment" href="#" data-row_id="<?php echo $fee->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                        <?php } } else { ?>
                                            <span class="text-success">PAID</span>
                                        <?php }  ?>
                                        
                                    </th>
                                </tr>
                                <?php } }else{  ?>
                                <tr>
                                    <th colspan="8" class="text-center">Fee Installment Record Not Found</th>
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
                    <h4 class="modal-title">Add Instalment Details</h4>
                    <button type="button" class="close float-right" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body p-2">
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addFeeInstallment" action="<?php echo base_url() ?>addFeeInstallment" method="post" role="form">
                        <div class="row form-contents">
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label>Select Student<span class="text-danger">*</span></label>
                                    <select class="form-control selectpicker" name="application_no" id="application_no" data-live-search="true" required autocomplete="off">
                                        <option value="">Select Student</option>
                                        <?php if(!empty($studentInfo)){
                                            foreach($studentInfo as $std){  ?>
                                            <option value="<?php echo $std->application_no; ?>">
                                                <?php echo $std->student_id; ?>-<?php echo $std->student_name; ?>
                                            </option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label>Amount<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="instalment_amount" name="amount" placeholder="Enter Amount" 
                                    onkeypress="return isNumberKey(event)" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label>Last Date For Payment<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control required" id="last_date_add"  name="last_date" placeholder="Last Date For Payment" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label>Year<span class="text-danger">*</span></label>
                                    <select class="form-control selectpicker" name="year" id="year" required autocomplete="off">
                                        <option value="2022">2022</option>
                                        <option value="2021">2021</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-0">
                                    <label>Remarks(optional)</label>
                                    <textarea type="text" class="form-control" id="remarks" name="remarks" rows="5" placeholder="Enter Remarks"  autocomplete="off" maxlength="1500"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer" style="padding: 7px 15px;">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" form="addFeeInstallment" class="btn btn-success pull-right" value="Save" />
                </div>

            </div>
        </div>
    </div>


</div>

<script src="<?php echo base_url(); ?>assets/js/fee.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "feeInstallmentListing/" + value);
        jQuery("#byFilterMethod").submit();
    });

    jQuery('.datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        
        dateFormat: 'dd-mm-yy',
       
    });
    jQuery('#last_date_add').datepicker({
        autoclose: true,
        orientation: "bottom",
       
        dateFormat: 'dd-mm-yy',
       
    });
    
    // $amt = $('#instalment_amount').val();
    // if($amt < 5000){
    //     alert('Please add instalment amount more than 5000');
    // }
    //checkbox select
    $('#selectAll').click(function() {
        if ($('#selectAll').is(':checked')) {
            $('.singleSelect').prop('checked', true);
        } else {
            $('.singleSelect').prop('checked', false);
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