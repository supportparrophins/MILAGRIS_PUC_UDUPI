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
                                    <i class="fas fa-rupee-sign"></i> Edit Fee Instalment
                                </span>
                            </div>
                            <div class="col-lg-5 col-md-5 col-6">
                                    <a onclick="showLoader();window.history.back();" class="btn primary_color mobile-btn float-right text-white"
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
                            <form role="form" action="<?php echo base_url() ?>updateFeeInstallment" method="post"
                                role="form">
                                <input type="hidden" name="row_id" id="row_id" value="<?php echo $installmentInfo->row_id; ?>" />
                                <div class="row p-0 column_padding_card">
                                    <div class="col column_padding_card">
                                        <div class="form-row">
                                            <div class="form-group col-lg-6">
                                                <label>Select Student<span class="text-danger">*</span></label>
                                                <select class="form-control selectpicker" name="application_no" id="application_no" autocomplete="off" data-live-search="true" required>
                                                    <?php if(!empty($installmentInfo->application_no)){ ?>
                                                        <option value="<?php echo $installmentInfo->application_no; ?>"><b>Selected: <?php echo $installmentInfo->student_id.' - '.$installmentInfo->student_name; ?></b></option>
                                                    <?php } ?>
                                                    <option value="">Select Student</option>
                                                    <?php if(!empty($studentInfo)){
                                                        foreach($studentInfo as $std){  ?>
                                                        <option value="<?php echo $std->application_no; ?>"><b><?php echo $std->student_id.' - '.$std->student_name; ?></b></option>
                                                    <?php } } ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>Amount<span class="text-danger">*</span></label>
                                                <div class="form-group mb-2">
                                                    <input type="text" class="form-control" value="<?php echo $installmentInfo->amount	; ?>" onkeypress="return isNumberKey(event)"
                                                    id="amount" name="amount" placeholder="Enter Amount" autocomplete="off" required>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <label>Last Date For Payment<span class="text-danger">*</span></label>
                                                <div class="form-group mb-0">
                                                     <input type="text" class="form-control required last_date" id="last_date"  name="last_date" value="<?php echo date('d-m-Y',strtotime($installmentInfo->last_date)); ?>" placeholder="Last Date For Payment" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-2">
                                                    <label>Year<span class="text-danger">*</span></label>
                                                    <select class="form-control selectpicker" name="year" id="year" required autocomplete="off">
                                                    <?php if(!empty($installmentInfo->year)){ ?>
                                                        <option value="<?php echo $installmentInfo->year; ?>"><b>Selected: <?php echo $installmentInfo->year; ?></b></option>
                                                    <?php } ?>
                                                        <option value="2022">2022</option>
                                                        <option value="2021">2021</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <label>Remarks(optional)</label>
                                                <div class="form-group mb-0">
                                                    <textarea type="text" class="form-control" id="remarks" name="remarks" rows="5" 
                                                    placeholder="Enter Remarks"  autocomplete="off" maxlength="1500"><?php echo $installmentInfo->remarks; ?></textarea>
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
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;
    return true;
}

jQuery(document).ready(function() {
   
    jQuery('.last_date').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        startDate: 
    });
});
</script>