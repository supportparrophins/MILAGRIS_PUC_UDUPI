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
<?php
    $warning = $this->session->flashdata('warning');
    if ($warning) {
?>
<div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <i class="fa fa-check mx-2"></i>
    <strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
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
                            <div class="col-lg-5 col-6 col-md-4 col-sm-4 box-tools">
                                <span class="page-title">
                                    <i class="fas fa-rupee-sign"></i> Scholarship
                                </span>
                            </div>
                            <div class="col-lg-3 col-6 col-md-4 col-sm-4">
                                <b class="text-dark" style="font-size: 20px;">Total:
                                    <?php echo $totalCount; ?></b>
                            </div>
                            <div class="col-lg-4 col-12 col-md-4 col-sm-4">
                                <a onclick="window.history.back();"
                                    class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                    <?php 
                                   // if($role == ROLE_DIRECTOR || $role == ROLE_SUPER_ADMIN || $this->staff_id == '123456' || $staffID == '2001' || $role == ROLE_PRINCIPAL || $role == ROLE_ACCOUNT || $this->staff_id == '2034'){ ?>
                                 <?php if($accessInfo->can_add == 1){ ?>
                                <a class="btn btn-primary pull-right mobile-btn border_right_radius" href="#"
                                    data-toggle="modal" data-target="#concessionModal">
                                    <i class="fa fa-plus"></i> Add New</a>
                                    <?php }  ?>
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
                            <form action="<?php echo base_url(); ?>viewFeeConcession" method="POST" id="byFilterMethod">
                                <tr class="filter_row" class="text-center">
                                    <td>
                                        <div class="form-group mb-0">
                                            <select class="form-control" name="con_year"
                                                id="con_year" required autocomplete="off">
                                                <?php if (!empty($con_year)) { 
                                                    $displayYear = $con_year . '-' . substr($con_year + 1, -2);
                                                ?>
                                                <option value="<?php echo $con_year; ?>"><?php echo $displayYear; ?></option>
                                                <?php } ?>
                                                <?php if(!empty($feeYearInfo)) {
                                                    foreach($feeYearInfo as $year){ ?>
                                                        <option value="<?php echo $year->year; ?>">
                                                            <?php echo $year->display_year; ?>
                                                        </option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $student_id; ?>" name="student_id"
                                                id="by_name" class="form-control input-sm" placeholder="Application No"
                                                autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $by_name; ?>" name="by_name" id="by_name"
                                                class="form-control input-sm" placeholder="Student Name" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $amount; ?>" name="amount" id="amount"
                                                class="form-control input-sm" placeholder="Amount" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $by_date; ?>" name="by_date"
                                                id="by_date" class="form-control input-sm datepicker" placeholder="Date"
                                                autocomplete="off">
                                        </div>
                                    </td>
                                    <td></td>
                                    <td>
                                        <button type="submit" class="btn btn-success btn-block mobile-width"><i
                                                class="fa fa-filter"></i> Filter</button>
                                    </td>
                                </tr>
                            </form>
                            <thead>
                                <tr class="text-center table_row_background">
                                    <th>Year</th>
                                    <th>Application No.</th>
                                    <th>Student Name</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($concessionInfo)){
                                    foreach($concessionInfo as $fee){ ?>
                                <tr>
                                    <?php 
                                        $year = (int)$fee->year;
                                        $fee_year = $year . '-' . substr($year + 1, -2);
                                    ?>
                                    <th class="text-center" width="100"><?php echo $fee_year; ?></th>
                                    <th class="text-center" width="120"><?php echo $fee->application_no; ?></th>
                                    <th width="270"><?php echo strtoupper($fee->student_name); ?></th>
                                    <th class="text-center" width="110"><?php echo $fee->fee_amt; ?></th>
                                    <th class="text-center" width="120">
                                        <?php echo date('d-m-Y',strtotime($fee->date)); ?></th>
                                    <th  width="250"><?php echo $fee->description; ?></th>
                                    <th width="180" class="text-center">
                                        <a href="#" class="btn btn-xs btn-primary" title="<b>Remarks:</b>" data-toggle="popover" data-placement="left" data-trigger="focus" data-content="<b><?php echo $fee->description; ?></b>"><i class="fa fa-info"></i></a>
                                            <?php  if($fee->approved_status != 1){ ?>
                                                <a class="btn btn-xs btn-info" href="<?php echo base_url(); ?>editConcession/<?php echo $fee->row_id; ?>" title="Edit Student"><i class="fas fa-pencil-alt"></i></a>
                                            <?php }
                                            if($fee->payment_status == 0){?>           
                                                <?php  if($fee->approved_status == 2){ ?>
                                                    <span class="text-danger">REJECTED</span>
                                                    <?php }else{ ?>
                                                <?php  //if($role == ROLE_SUPER_ADMIN || $this->staff_id == '123456'){ ?>
                                                <?php if($accessInfo->can_edit == 1){ ?>
                                                    <a class="btn btn-xs btn-danger rejectConcession p-2"
                                                        href="#" data-row_id="<?php echo $fee->row_id; ?>"> Reject</a>
                                                <?php } } if($fee->approved_status == 1){ ?>
                                                        <span class="text-success">APPROVED</span>
                                                <?php } if($fee->approved_status != 1){  
                                                // if($role == ROLE_SUPER_ADMIN || $this->staff_id == '123456'){ ?>
                                                <?php if($accessInfo->can_edit == 1){ ?>
                                                    <a class="btn btn-xs btn-success approveConcession p-2" href="#" data-row_id="<?php echo $fee->row_id; ?>"> Approve</a>
                                                <?php }} //if($role == ROLE_PRINCIPAL  || $role == ROLE_SUPER_ADMIN || $this->staff_id == '123456' || $this->staff_id == '2034'){
                                                if($accessInfo->can_delete == 1) { ?>
                                                <?php if($fee->approved_status == 0 ){  ?>
                                                    <a class="btn btn-xs btn-danger deleteConcession" href="#" data-row_id="<?php echo $fee->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                                <?php }} 
                                            }else{
                                                echo "<span class='text-success'>PAID</span>";
                                            }?>   
                                    </th>
                                </tr>
                                <?php } }else{  ?>
                                <tr>
                                    <th colspan="8" class="text-center">Scholarship  Record Not Found</th>
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
                    <h4 class="modal-title">Add New Scholarship</h4>
                    <button type="button" class="close float-right" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body p-2">
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addConcessionInfo" action="<?php echo base_url() ?>addConcession"
                        method="post" role="form">
                        <div class="row form-contents">
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label>Select Scholarship Year <span class="text-danger">*</span></label>
                                    <select class="form-control selectpicker" data-live-search="true" name="con_year" id= "con_year1"
                                        required autocomplete="off">
                                        <option value="">Select Year</option>
                                        <?php if(!empty($feeYearInfo)) {
                                            foreach($feeYearInfo as $year){ ?>
                                                <option value="<?php echo $year->year; ?>">
                                                    <?php echo $year->display_year; ?>
                                                </option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label>Select Student <span class="text-danger">*</span></label>
                                    <select class="form-control selectpicker" data-live-search="true"
                                        name="application_no" id="student_row_id" required autocomplete="off">
                                        <option value="">Select Student</option>
                                        <!-- <?php //if(!empty($studentInfoSelection)){
                                            //foreach($studentInfoSelection as $std){  ?>
                                        <option value="<?php //echo $std->row_id; ?>">
                                            <b><?php //echo $std->student_id.' - '.strtoupper($std->student_name) . ' - '.$std->term_name; ?></b>
                                        </option>
                                        <?php //} } ?>
                                        <?php //if(!empty($firstYearStudentInfo)){
                                            //foreach($firstYearStudentInfo as $std){  ?>
                                        <option value="<?php //echo $std->row_id; ?>">
                                            <b><?php //echo $std->application_no.' - '.strtoupper($std->student_name). '- I PU'; ?></b>
                                        </option>
                                        <?php //} } ?> -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label>Enter Scholarship Amount <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " id="fee_amount" name="fee_amount"
                                        placeholder="Enter Scholarship Amount" onkeypress="return isNumberKey(event)"
                                        required autocomplete="off">
                                    <small class="text-danger"><b>Note: Amount must not be greater than Course Fee.</b></small>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-0">
                                    <label>Enter Description <span class="text-danger">*</span></label>
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
<script src="<?php echo base_url(); ?>assets/js/fee.js" type="text/javascript"></script>
<script type="text/javascript">
let concessionRemainingAmount = 0;
function validateConcessionAmountInput(){
    const amount = parseFloat($('#fee_amount').val() || 0);
    if(amount > concessionRemainingAmount){
        $('#fee_amount')[0].setCustomValidity('Amount exceeds allowed limit');
        alert('Entered amount is greater than allowed limit.');
        $('#fee_amount').val('');
        $('#fee_amount').focus();
    } else {
        $('#fee_amount')[0].setCustomValidity('');
    }
}

function fetchConcessionLimit(){
    const studentRowId = $('#student_row_id').val();
    const conYear = $('#con_year1').val();
    concessionRemainingAmount = 0;
    if(!studentRowId || !conYear){
        return;
    }
    $.ajax({
        url: '<?php echo base_url(); ?>getConcessionFeeLimit',
        type: 'POST',
        dataType: 'json',
        data: {
            student_row_id: studentRowId,
            con_year: conYear
        },
        success: function(resp){
            console.log('[Concession] getConcessionFeeLimit response', resp);
            if(resp.status){
                concessionRemainingAmount = parseFloat(resp.remaining || 0);
                const courseFee = parseFloat(resp.course_fee || 0);
                const hasPending = resp.pending_balance !== null && resp.pending_balance !== undefined;
                const pendingBalance = hasPending ? parseFloat(resp.pending_balance) : 0;
                const effectiveLimit = parseFloat(resp.effective_limit || 0);
                $('#concessionLimitInfo').text('Course Fee: ' + courseFee.toFixed(2) + ' | Pending Balance: ' + (hasPending ? pendingBalance.toFixed(2) : 'N/A') + ' | Limit Used: ' + effectiveLimit.toFixed(2) + ' | Already Assigned: ' + parseFloat(resp.current_total || 0).toFixed(2) + ' | Remaining: ' + concessionRemainingAmount.toFixed(2));
                validateConcessionAmountInput();
            }
        },
        error: function(xhr){
            console.log('[Concession] getConcessionFeeLimit error', xhr);
        }
    });
}

jQuery(document).ready(function() {
    // Use delegated events so handlers keep working even after selectpicker destroy/re-init.
    $(document).on('change', '#con_year1, #student_row_id', function() {
        fetchConcessionLimit();
    });
    $(document).on('changed.bs.select', '#con_year1, #student_row_id', function() {
        fetchConcessionLimit();
    });
    $('#con_year1').change(function() {
        var selectedYear = $(this).val();
        $.ajax({
            url: '<?php echo base_url(); ?>/getStudentByClassYear',
            type: 'POST',
            dataType: 'json',
            data: { year : selectedYear},
            success: function(data) {
                console.log('[Concession] getStudentByClassYear response', data);
                $('#student_row_id').selectpicker('destroy');
                $('#student_row_id').prop('readonly', false).empty().append('<option value="">Select Student</option>');
                if (data.studentInfo && data.studentInfo.length > 0) {
                    $.each(data.studentInfo, function (i, student) {
                        $('#student_row_id').append(
                            $('<option>', {
                                value: student.row_id,
                                text: student.application_no + ' - ' + student.student_name.toUpperCase() + ' - ' + student.class + ' - ' + student.stream
                            })
                        );
                    });
                }
                $('#student_row_id').selectpicker({liveSearch: true,size: 5 });
                fetchConcessionLimit();
            },
            error: function(){
                alert("Retry Again! Something Went Wrong");
            },
            fail:(function(status) {
                alert("Retry Again! Something Went Wrong");  
            }),
        });
    });
    $('#fee_amount').on('input', function(){
        validateConcessionAmountInput();
    });
});

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
        startDate: "01-11-2020",
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
});

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>