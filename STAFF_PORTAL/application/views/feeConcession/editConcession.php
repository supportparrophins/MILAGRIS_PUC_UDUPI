<style>
label {
    font-weight: 500 !important;
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
    <div class="col-12">
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
                            <div class="col-lg-7 col-6 col-md-7 box-tools">
                                <span class="page-title">
                                    <i class="fas fa-rupee-sign"></i> Edit Scholarship
                                </span>
                            </div>
                            <div class="col-lg-5 col-md-5 col-6">
                                <a onclick="window.history.back();" class="btn primary_color mobile-btn float-right text-white"
                                value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small c-border mb-4 p-2">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-2">
                            <form role="form" action="<?php echo base_url() ?>updateConcession" method="post"
                                role="form">
                                <input type="hidden" name="row_id" id="row_id" value="<?php echo $feeInfo->row_id; ?>" />
                                <div class="row p-0 column_padding_card">
                                    <div class="col column_padding_card">
                                        <div class="form-row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-2">
                                                    <label>Select Scholarship Year <span class="text-danger">*</span></label>
                                                    <select class="form-control selectpicker" data-live-search="true" name="con_year"
                                                        id="con_year" required autocomplete="off">
                                                        <?php 
                                                            $year = (int)$feeInfo->year;
                                                            $fee_year = $year . '-' . substr($year + 1, -2);
                                                        ?>
                                                        <option value="<?php echo $feeInfo->year; ?>"><?php echo $fee_year; ?></option>
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
                                            <div class="form-group col-lg-6">
                                                <label>Select Student <span class="text-danger">*</span></label>
                                                <select class="form-control selectpicker" name="application_no" data-live-search="true" id="student_row_id" autocomplete="off">
                                                    <?php if(!empty($feeInfo->application_no)){ ?>
                                                        <option value="<?php echo $feeInfo->application_no; ?>"><b>Selected: <?php echo strtoupper($feeInfo->student_name); ?></b></option>
                                                    <?php } ?>
                                                    <option value="">Select Student</option>
                                                    <!-- <?php //if(!empty($studentInfo)){
                                                        //foreach($studentInfo as $std){  ?>
                                                        <option value="<?php //echo $std->row_id; ?>"><b><?php //echo $std->student_id.' - '.strtoupper($std->student_name); ?></b></option>
                                                    <?php //} } ?> -->
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>Amount <span class="text-danger">*</span></label>
                                                <div class="form-group mb-2">
                                                    <input type="text" class="form-control" value="<?php echo $feeInfo->fee_amt	; ?>" onkeypress="return isNumberKey(event)"
                                                    id="fee_amount" name="fee_amount" placeholder="Enter Amount" autocomplete="off">
                                                </div>
                                                <small class="text-danger"><b>Note: Amount must not be greater than Course Fee.</b></small>
                                            </div>
                                            <div class="form-group col-12">
                                                <label>Description <span class="text-danger">*</span></label>
                                                <div class="form-group mb-0">
                                                    <textarea type="text" class="form-control" id="description" name="description" rows="5" 
                                                    placeholder="Enter Description"  autocomplete="off" maxlength="1500"><?php echo $feeInfo->description; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success float-right"> Update </button>
                                    </div>
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
let concessionRemainingAmount = 0;
let selectedStudentId = '<?php echo !empty($feeInfo->application_no) ? $feeInfo->application_no : ''; ?>';
function validateConcessionAmountInput(){
    var amount = parseFloat($('#fee_amount').val() || 0);
    if(amount > concessionRemainingAmount){
        $('#fee_amount')[0].setCustomValidity('Amount exceeds allowed limit');
        alert('Entered amount is greater than allowed limit.');
        $('#fee_amount').val('');
        $('#fee_amount').focus();
    }else{
        $('#fee_amount')[0].setCustomValidity('');
    }
}

function fetchConcessionLimit(){
    var studentRowId = $('#student_row_id').val();
    var conYear = $('#con_year').val();
    var rowId = $('#row_id').val();
    if(!studentRowId || !conYear){
        return;
    }
    $.ajax({
        url: '<?php echo base_url(); ?>getConcessionFeeLimit',
        type: 'POST',
        dataType: 'json',
        data: {
            student_row_id: studentRowId,
            con_year: conYear,
            row_id: rowId
        },
        success: function(resp){
            console.log('[Concession] getConcessionFeeLimit response', resp);
            if(resp.status){
                concessionRemainingAmount = parseFloat(resp.remaining || 0);
                var courseFee = parseFloat(resp.course_fee || 0);
                var hasPending = resp.pending_balance !== null && resp.pending_balance !== undefined;
                var pendingBalance = hasPending ? parseFloat(resp.pending_balance) : 0;
                var effectiveLimit = parseFloat(resp.effective_limit || 0);
                $('#concessionLimitInfo').text('Course Fee: ' + courseFee.toFixed(2) + ' | Pending Balance: ' + (hasPending ? pendingBalance.toFixed(2) : 'N/A') + ' | Limit Used: ' + effectiveLimit.toFixed(2) + ' | Other Assigned: ' + parseFloat(resp.current_total || 0).toFixed(2) + ' | Remaining: ' + concessionRemainingAmount.toFixed(2));
                validateConcessionAmountInput();
            }
        },
        error: function(xhr){
            console.log('[Concession] getConcessionFeeLimit error', xhr);
        }
    });
}

function loadStudentsByYear(selectedYear){
    if(!selectedYear){
        $('#student_row_id').selectpicker('destroy');
        $('#student_row_id').prop('readonly', false).empty().append('<option value="">Select Student</option>');
        $('#student_row_id').selectpicker({liveSearch: true,size: 5 });
        return;
    }
    $.ajax({
        url: '<?php echo base_url(); ?>/getStudentByClassYear',
        type: 'POST',
        dataType: 'json',
        data: { year : selectedYear },
        success: function(data) {
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
            if (selectedStudentId) {
                $('#student_row_id').selectpicker('val', selectedStudentId);
            }
            fetchConcessionLimit();
        },
        error: function(){
            alert('Retry Again! Something Went Wrong');
        },
        fail: (function(status) {
            alert('Retry Again! Something Went Wrong');
        })
    });
}

jQuery(document).ready(function(){
    loadStudentsByYear($('#con_year').val());
    fetchConcessionLimit();
    $('#student_row_id').on('changed.bs.select', function() {
        fetchConcessionLimit();
    });
    $('#con_year').on('changed.bs.select', function() {
        selectedStudentId = '';
        loadStudentsByYear($(this).val());
        fetchConcessionLimit();
    });
    $('#con_year').change(function() {
        selectedStudentId = '';
        loadStudentsByYear($(this).val());
    });
    $('#fee_amount').on('input', function(){
        validateConcessionAmountInput();
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