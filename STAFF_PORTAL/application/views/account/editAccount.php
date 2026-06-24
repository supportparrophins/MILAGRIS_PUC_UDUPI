<style>
label{
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
                            <div class="col-lg-7 col-12 col-md-7 box-tools">
                                <span class="page-title">
                                    <i class="fas fa-landmark"></i> Edit Account Details
                                </span>
                            </div>
                            <div class="col-lg-5 col-md-5 col-12">
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
                            <form role="form" action="<?php echo base_url() ?>updateAccount" method="post" role="form">
                                <input type="hidden" name="row_id" id="row_id" value="<?php echo $accountInfo->row_id; ?>" />
                                <div class="row p-0 column_padding_card">
                                    <div class="col column_padding_card">
                                        <div class="form-row">
                                            <div class="form-group col-lg-6">
                                                <label>Bank Name</label>
                                                <input type="text" class="form-control text-capitalize" id="bank_name" name="bank_name" value="<?php echo $accountInfo->bank_name; ?>" placeholder="Enter Bank Name" autocomplete="off" required>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>Branch Name</label>
                                                <input type="text" class="form-control" id="branch_name" name="branch_name" value="<?php echo $accountInfo->branch_name; ?>" placeholder="Enter Branch Name" autocomplete="off" required>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>Account Number</label>
                                                <input type="text" class="form-control" id="account_no" name="account_no" value="<?php echo $accountInfo->account_no; ?>" placeholder="Enter Account Number" maxlength="18" onkeypress="return isNumberKey(event)" autocomplete="off" required>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>IFSC Code</label>
                                                <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" value="<?php echo $accountInfo->ifsc_code; ?>" placeholder="Enter IFSC Code" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success float-right"> Submit </button>
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

// jQuery(document).ready(function() {
//     $('select').selectpicker();
// });
</script>