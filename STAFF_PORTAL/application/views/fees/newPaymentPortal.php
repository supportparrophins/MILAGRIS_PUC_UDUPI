<!-- Add this to <head> -->
<!-- Load required Bootstrap and BootstrapVue CSS -->
<link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap/dist/css/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.css" />
<!-- Load polyfills to support older browsers -->
<script src="//polyfill.io/v3/polyfill.min.js?features=es2015%2CIntersectionObserver" crossorigin="anonymous"></script>
<!-- Load Vue followed by BootstrapVue -->
<script src="//unpkg.com/vue@latest/dist/vue.min.js"></script>
<script src="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.js"></script>
<!-- Load the following for BootstrapVueIcons support -->
<script src="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue-icons.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
.body{
    --bs-body-font-size: .7rem !important;
}
.table th {
    padding: 1px !important;
}
.table_search_th {
    padding: .1rem !important;
    vertical-align: top !important;
    border-top: 1px solid #c2c6c7 !important;
}
.select2-container .select2-selection--single {
    height: 38px !important;
    width: 360px !important;
}
.loaderScreen {
    display: block;
    visibility: visible;
    position: absolute;
    z-index: 999;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
    background-color: #0a0a0a94;
    vertical-align: bottom;
    padding-top: 20%;
    filter: alpha(opacity=75);
    opacity: 0.75;
    font-size: large;
    color: blue;
    font-style: italic;
    font-weight: 400;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
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
.table tr.bg-primary > th,
.table tr.bg-primary > td {
    background-color: #007bff !important;
}
.table tr.bg-success > th,
.table tr.bg-success > td {
    background-color: #28a745 !important;
}
.table tr.bg-warning > th,
.table tr.bg-warning > td {
    background-color: #ffc107 !important;
}
.table tr.bg-secondary > th,
.table tr.bg-secondary > td {
    background-color: #6c757d !important;
}
.table tr.bg-danger > th,
.table tr.bg-danger > td {
    background-color: #dc3545 !important;
}
.table tr.bg-info > th,
.table tr.bg-info > td {
    background-color: #17a2b8 !important;
}
.table tr.bg-pending > th,
.table tr.bg-pending > td {
    background-color: #fd7e14 !important;
}
.table tr.text-white > th,
.table tr.text-white > td,
.table tr.text-white > th a,
.table tr.text-white > td a {
    color: #fff !important;
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
<?php } ?>
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
                    <div class="card-body p-0" style="padding-bottom: 0px !important;">
                        <div class="row c-m-b">
                            <div class="col-lg-12 col-12 col-md-12 box-tools">
                                <span class="page-title">
                                    <i class="fa fa-file"></i> 
                                    <span style="font-size: 23px;font-weight: 600;">Fee Payment Portal - </span>
                                    <small><?php $nextYear = CURRENT_YEAR + 1; echo CURRENT_YEAR . '-' . substr($nextYear, -2); ?></small>
                                </span>
                            </div>
                            <!-- <div class="col-lg-2 col-12 col-md-12 box-tools">
                                <a class="btn btn-danger mobile-btn float-right border_right_radius" href="#" data-toggle="modal" data-target="#orderIDProcesse" id="orderID"><i class="fas fa-university"></i>Order ID Process</a>
                            </div> -->
                            <!-- <div class="col-lg-2 col-12 col-md-12 box-tools">
                                <a class="btn btn-secondary mobile-btn float-right border_right_radius" href="<?php //echo base_url().'bulkOrderIdProcess'; ?>" ><i class="fas fa-university"></i>Bulk Order ID Process</a>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2 ">
                        <form action="<?php echo base_url() ?>getStudentFeePaymentInfo" method="POST">
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-group mb-1">
                                        <select class="form-control selectpicker" data-live-search="true" name="application_no" required>
                                            <?php if (!empty($row_id)) { ?>
                                                <option value="<?php echo $row_id; ?>" selected>
                                                    <?php echo $student_name; ?></option>
                                            <?php }   ?>
                                            <option value="">Select Student</option>
                                            <?php if (!empty($newStdInfo)) {
                                                foreach ($newStdInfo as $std) {  ?>
                                                    <option value="<?php echo $std->application_no; ?>">
                                                        <b><?php echo $std->application_no . ' - ' . strtoupper($std->student_name) . ' - I PUC'; ?></b>
                                                    </option>
                                            <?php }
                                            } ?>
                                            <?php if (!empty($allStudentInfo)) {
                                                foreach ($allStudentInfo as $std) {  ?>
                                                    <option value="<?php echo $std->row_id; ?>">
                                                        <b><?php echo $std->student_id . ' - ' . $std->application_no . ' - ' . strtoupper($std->student_name) . ' - ' . $std->term_name; ?></b>
                                                    </option>
                                            <?php }
                                            } ?>
                                        </select>
                                        <div class="input-group-append">
                                            <button type="submit" style="width:170px" class="btn btn-success" type="button">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 ">
                            <?php
                            if (!empty($total_fee)) {
                                $total_fee_to_pay = $total_fee;
                            } else {
                                $total_fee_to_pay = $feeInfo->total_fee;
                            }
                            if (!empty($studentInfo)) { ?>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <div class="card border-success mb-1">
                                        <div class="card-header bg-transparent border-success"><?php echo $text_display_view; ?></div>
                                            <div style=" padding: 0rem 0rem;" class="card-body ">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr class="table-success">
                                                            <th class="text-left" scope="col" width="280">Name</th>
                                                            <th class="text-left" scope="col">
                                                                <?php echo  strtoupper($studentInfo->student_name); ?></th>
                                                        </tr>
                                                        <tr class="table-primary">
                                                            <th class="text-left" scope="col">App No./Stud ID</th>
                                                            <th class="text-left" scope="col">
                                                                <?php echo $application_no . '/' . $studentInfo->student_id; ?></th>
                                                        </tr>
                                                        <tr class="table-success">
                                                            <th class="text-left" scope="col">Gender</th>
                                                            <th class="text-left" scope="col"><?php echo $studentInfo->gender; ?></th>
                                                        </tr>
                                                        <tr class="table-primary">
                                                            <th class="text-left" scope="col">Term</th>
                                                            <th class="text-left" scope="col"><?php echo $term_name; ?></th>
                                                        </tr>
                                                        <tr class="table-success">
                                                            <th class="text-left" scope="col">Stream </th>
                                                            <th class="text-left" scope="col">
                                                                <?php echo $studentInfo->stream_name; ?>
                                                            </th>
                                                        </tr>
                                                        <!-- <tr class="table-primary">
                                                            <th class="text-left" scope="col">Category</th>
                                                            <th class="text-left" scope="col">
                                                                <?php //echo $studentInfo->category; ?>
                                                            </th>
                                                        </tr> -->
                                                        <!-- <tr class="table-info text-white">
                                                            <th class="text-left" scope="col">Board</th>
                                                            <th class="text-left" scope="col">
                                                                <?php //echo $board_name; ?>
                                                            </th>
                                                        </tr>
                                                        <tr class="table-primary text-white">
                                                            <th class="text-left" scope="col">Elective Sub</th>
                                                            <th class="text-left" scope="col">
                                                                <?php //echo $studentInfo->elective_sub; ?>
                                                            </th>
                                                        </tr> -->
                                                        <?php if(!empty($govt_fee) && $govt_fee > 0){ ?>
                                                        <tr class="bg-info text-white">
                                                            <th class="text-left" scope="col">Contribution Fee</th>
                                                            <th class="text-left" scope="col">
                                                                <?php echo number_format($govt_fee, 2); ?>
                                                            </th>
                                                        </tr>
                                                        <?php } ?>
                                                        <tr class="bg-info text-white">
                                                            <th class="text-left" scope="col">Tution Fee</th>
                                                            <th class="text-left" scope="col">
                                                                <?php echo number_format($management_fee->total_fee, 2); ?>
                                                            </th>
                                                        </tr>
                                                        <tr class="bg-primary text-white">
                                                            <th class="text-left" scope="col">Total Amount</th>
                                                            <th class="text-left" scope="col">
                                                                <?php echo number_format($total_fee_mgmt, 2); ?>
                                                            </th>
                                                        </tr>
                                                        <?php if(!empty($concession_amount)){ ?>
                                                        <tr class="bg-warning text-white">
                                                            <th class="text-left" scope="col">Scholarship Amount(-)</th>
                                                            <th class="text-left" scope="col">
                                                                <?php echo number_format($concession_amount, 2); ?>
                                                            </th>
                                                        </tr>
                                                        <?php } ?>
                                                        <tr class="bg-success text-white">
                                                            <th class="text-left" scope="col">Paid Amount</th>
                                                            <th class="text-left" scope="col">
                                                                <?php echo number_format($paid_amount, 2); ?>
                                                            </th>
                                                        </tr>
                                                        <!-- <tr class="bg-danger text-white">
                                                            <th class="text-left" scope="col">Contribution Fee Pending Amt</th>
                                                            <th class="text-left" scope="col">
                                                                <?php //echo number_format($govt_fee-$govtFeePaid, 2); ?>
                                                            </th>
                                                        </tr> -->
                                                        <!-- <tr class="bg-danger text-white">
                                                            <th class="text-left" scope="col">Tution Fee Pending Amt</th>
                                                            <th class="text-left" scope="col">
                                                                <?php //$management_pending_amount = $total_fee_mgmt -  $management_fee_paid - $concession_amount;
                                                                //echo number_format($total_fee_mgmt -  $management_fee_paid - $concession_amount, 2); ?>
                                                            </th>
                                                        </tr> -->
                                                        <tr class="bg-danger text-white">
                                                            <th class="text-left" scope="col">Total Pending Fee Amt</th>
                                                            <th class="text-left" scope="col">
                                                                <?php echo number_format($pending_amount - $concession_amount, 2); ?>
                                                                <?php if($pending_amount - $concession_amount > 0){ ?>
                                                                <button type="button"
                                                                    class="btn btn-success mobile-btn float-right text-white mr-2"
                                                                    data-toggle="modal"
                                                                    data-target="#payNowModal">
                                                                    <i class="fa fa-credit-card"></i> Pay Now
                                                                </button>
                                                                <?php } ?>
                                                            </th>
                                                        </tr>
                                                        <?php if(!empty($fee_installment)){ ?>
                                                        <tr class="bg-secondary text-white">
                                                            <th class="text-left" scope="col">Installment</th>
                                                            <th class="text-left" scope="col">
                                                                <?php echo $fee_installment->amount; ?>
                                                            </th>
                                                        </tr>
                                                        <?php } ?>
                                                        <?php if ($term_name == "II PUC") { ?>
                                                            <!-- <tr class="bg-danger text-white">
                                                                <th class="text-left" scope="col">I PUC Balance</th>
                                                                <th class="text-left" scope="col">
                                                                    <?php //if ($previousBal < 0) {
                                                                        //echo 0;
                                                                    //} else {
                                                                        //echo number_format($previousBal, 2);
                                                                    //} ?>
                                                                </th>
                                                            </tr> -->
                                                        <?php } ?>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <?php if ($studentInfo->term_name == 'II PUC') { ?>
                                            <input type="hidden" id="term_name_of_std" value="II PUC" />
                                            <div class="card border-success mb-3">
                                                <div class="card-header bg-primary border-success p-1 text-white"> II PUC Fee Info</div>
                                                <div class="card-body">
                                                    <?php if ($previousBal <= 0) {
                                                        if ($ii_management_fee_pending > 0) { ?>
                                                            <h6 class="text-center">Fee Payment</h6>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <input type="text" name="transaction_date" value="<?php echo date('d-m-Y'); ?>" class="form-control card_date" Placeholder="Transaction Date" id="transaction_date" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group ">
                                                                        <input type="text" class="form-control " id="paid_amount" name="paid_amount" placeholder="Paid Amount" onkeypress="return isNumberKey(event)" oninput="checkAmount()" required autocomplete="off">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <div class="form-group ">
                                                                        <select class="form-control text-dark" id="payment_type" name="payment_type">
                                                                            <option value="">Select Payment Type</option>
                                                                            <option value="CASH" selected>CASH</option>
                                                                            <option value="DD">DD</option>
                                                                            <option value="CARD">CARD</option>
                                                                            <option value="BANK">BANK</option>
                                                                            <option value="UPI">UPI</option>
                                                                            <option value="NEFT">NEFT</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <?php if($role!=ROLE_AUDITOR){ ?>
                                                                <div class="col-7">
                                                                    <button id="paymentInfoSubmit" style="margin-top: 1px; float:right" class="btn btn-success btn-block mb-1">Submit</button>
                                                                </div>
                                                                <?php } ?>
                                                            </div>
                                                        <?php } else { ?>
                                                            <h5 style="color:green">II PUC Fee cleared</h5>
                                                        <?php }
                                                    } else { ?>
                                                        <h5 style="color:red">I PUC Fee Pending</h5>
                                                    <?php }  ?>
                                                    <table style="margin-top: 2px;" class="table table-hover">
                                                        <thead>
                                                            <tr class="table_row_background" style="font-size: 15px;">
                                                                <th>Date</th>
                                                                <!-- <th>Receipt No.</th> -->
                                                                <th>Amt.</th>
                                                                <th>Type</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <?php if (!empty($II_feePaidInfo)) {
                                                            $length = count($II_feePaidInfo);
                                                            $i=1;
                                                            foreach ($II_feePaidInfo as $fee) { ?>
                                                                <tr class="text-dark" style="font-size: 15px;">
                                                                    <td><?php echo date('d-m-Y', strtotime($fee->payment_date)); ?></td>
                                                                    <!-- <td class="text-center"><?php //echo $fee->receipt_number; ?></td> -->
                                                                    <td><?php echo number_format($fee->paid_amount, 2); ?></td>
                                                                    <td><?php echo $fee->payment_type; ?></td>
                                                                    <td>
                                                                    <?php if ($i == 1) { ?>
                                                                        <div style="display:flex; gap:6px; align-items:center; flex-wrap:wrap;">
                                                                                <a href="<?php echo base_url(); ?>newSpecialFeePaymentReceiptPrint/<?php echo $fee->row_id; ?>"
                                                                                    target="_blank"
                                                                                    class="btn btn-sm btn-primary"
                                                                                    style="border-radius:6px; font-weight:600; letter-spacing:0.3px; padding: 4px 10px;"
                                                                                    title="Print Special Fee Receipt">
                                                                                    <i class="fas fa-print"></i> Special Fee Receipt
                                                                                </a>

                                                                                <a href="<?php echo base_url(); ?>feePaymentReceiptPrint/<?php echo $fee->row_id; ?>"
                                                                                    target="_blank"
                                                                                    class="btn btn-sm btn-success"
                                                                                    style="border-radius:6px; font-weight:600; letter-spacing:0.3px; padding: 4px 10px;"
                                                                                    title="Print Receipt">
                                                                                    <i class="fas fa-file-alt"></i> Receipt
                                                                                </a>
                                                                            </div>
                                                                    <?php } else {?>
                                                                            <a href="<?php echo base_url(); ?>feePaymentReceiptPrint/<?php echo $fee->row_id; ?>"
                                                                                target="_blank"
                                                                                class="btn btn-sm btn-success"
                                                                                style="border-radius:6px; font-weight:600; letter-spacing:0.3px; padding: 4px 10px;"
                                                                                title="Print Receipt">
                                                                                <i class="fas fa-file-alt"></i> Receipt
                                                                            </a>
    
                                                                    <?php } ?>
                                                                    <?php if( $role == ROLE_PRIMARY_ADMINISTRATOR || $this->staff_id == '123456' || $role == ROLE_SUPER_ADMIN ||  $role ==  ROLE_ACCOUNT){ ?>
                                                                        <!-- <a class="btn btn-xs btn-secondary-xs" onclick="openModel(<?php //echo $fee->row_id; ?>,/<?php //echo date('d-m-Y', strtotime($fee->payment_date)); ?>/)" title="Edit" href='#'><i class="fas fa-edit"></i>Edit</a> -->
                                                                    <?php if ($length == $i && $fee->payment_type != 'ONLINE') { ?>
                                                                        <a class="btn btn-xs btn-danger deleteMgmtFeeReceipt px-1 py-1" style="font-size:12px;" href="#" data-row_id="<?php echo $fee->row_id; ?>" title="Delete">Credit Note</a>
                                                                    <?php }} ?>
                                                                    </td>   
                                                                </tr>
                                                        <?php $i++; }
                                                        } else { ?>
                                                            <tr class="text-dark">
                                                                <td colspan="4">Fee info not found</td>
                                                            </tr>
                                                        <?php   } ?>
                                                    </table>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <input type="hidden" id="term_name_of_std" value="I PUC" />
                                        <?php } ?>
                                        <?php if ($studentInfo->term_name == 'I PUC') { ?>
                                            <div class="card border-success mb-1">
                                                <div class="card-header bg-primary border-success p-1 text-white">I PUC Fee Info
                                                </div>
                                                <div class="card-body">
                                                    <?php if ($i_management_fee_pending > 0) { ?>
                                                        <h6 class="text-center">Fee Payment</h6>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <input type="text" name="transaction_date" value="<?php echo date('d-m-Y'); ?>" class="form-control card_date" Placeholder="Transaction Date" id="transaction_date" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group mb-2">
                                                                    <input type="text" class="form-control " id="paid_amount" name="paid_amount" placeholder="Paid Amount" onkeypress="return isNumberKey(event)" oninput="checkIPUCAmount()" required autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-5">
                                                                <div class="form-group ">
                                                                    <select class="form-control text-dark" id="payment_type" name="payment_type">
                                                                        <option value="">Select Payment Type</option>
                                                                        <option value="CASH">CASH</option>
                                                                        <option value="DD">DD</option>
                                                                        <option value="CARD">CARD</option>
                                                                        <option value="BANK">BANK</option>
                                                                        <option value="UPI">UPI</option>
                                                                        <option value="NEFT">NEFT</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <?php if($role !=ROLE_AUDITOR){ ?>
                                                            <div class="col-7">
                                                                <button id="firstPaymentInfoSubmit" style="margin-top: 5px; float:right" class="btn btn-success btn-block mb-2">Submit</button>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                    <?php } else { ?>
                                                        <h5 style="color:green">I PUC Fee Cleared</h5>
                                                    <?php } ?>
                                                    <table style="margin-top: 5px;" class="table table-hover">
                                                        <thead>
                                                            <tr class="table_row_background" style="font-size: 15px;">
                                                                <th>Date</th>
                                                                <!-- <th>Receipt No.</th> -->
                                                                <th>Amt.</th>
                                                                <th>Type</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <?php if (!empty($feePaidInfo)) {
                                                            $length = count($feePaidInfo);
                                                            $i = 1;
                                                            foreach ($feePaidInfo as $fee) { ?>
                                                                <tr class="text-dark" style="font-size: 15px;">
                                                                    <td><?php echo date('d-m-Y', strtotime($fee->payment_date)); ?></td>
                                                                    <!-- <td class="text-center"><?php //echo $fee->receipt_number; ?></td> -->
                                                                    <td><?php echo number_format($fee->paid_amount, 2); ?></td>
                                                                    <td><?php echo $fee->payment_type; ?></td>
                                                                    <td>
                                                                        <?php if ($i == 1) { ?>
                                                                           <div style="display:flex; gap:6px; align-items:center; flex-wrap:wrap;">
                                                                                    <a href="<?php echo base_url(); ?>newSpecialFeePaymentReceiptPrint/<?php echo $fee->row_id; ?>"
                                                                                        target="_blank"
                                                                                        class="btn btn-sm btn-primary"
                                                                                        style="border-radius:6px; font-weight:600; letter-spacing:0.3px; padding: 4px 10px;"
                                                                                        title="Print Special Fee Receipt">
                                                                                        <i class="fas fa-print"></i> Special Fee Receipt
                                                                                    </a>

                                                                                    <a href="<?php echo base_url(); ?>feePaymentReceiptPrint/<?php echo $fee->row_id; ?>"
                                                                                        target="_blank"
                                                                                        class="btn btn-sm btn-success"
                                                                                        style="border-radius:6px; font-weight:600; letter-spacing:0.3px; padding: 4px 10px;"
                                                                                        title="Print Receipt">
                                                                                        <i class="fas fa-file-alt"></i> Receipt
                                                                                    </a>
                                                                                </div>
                                                                        <?php } else {?>
                                                                                <a href="<?php echo base_url(); ?>feePaymentReceiptPrint/<?php echo $fee->row_id; ?>"
                                                                                    target="_blank"
                                                                                    class="btn btn-sm btn-success"
                                                                                    style="border-radius:6px; font-weight:600; letter-spacing:0.3px; padding: 4px 10px;"
                                                                                    title="Print Receipt">
                                                                                    <i class="fas fa-file-alt"></i> Receipt
                                                                                </a>
        
                                                                        <?php } ?>
                                                                        <!-- <a href="<?php //echo base_url(); ?>feePaymentReceiptPrint/<?php //echo $fee->row_id; ?>" target="_blank">Receipt</a> -->
                                                                    <?php  if( $role == ROLE_PRIMARY_ADMINISTRATOR || $this->staff_id == '123456' || $role == ROLE_SUPER_ADMIN || $role == ROLE_ACCOUNT){ ?>
                                                                        <!-- <a class="btn btn-xs btn-secondary-xs" onclick="openModel(<?php //echo $fee->row_id; ?>,/<?php //echo date('d-m-Y', strtotime($fee->payment_date)); ?>/)" title="Edit" href='#'><i class="fas fa-edit"></i>Edit</a> -->
                                                                    <?php   if ($length == $i && $fee->payment_type != 'ONLINE') { ?>                                          
                                                                        <a class="btn btn-xs btn-danger deleteMgmtFeeReceipt px-1 py-1" style="font-size:12px;" href="#" data-row_id="<?php echo $fee->row_id; ?>" title="Delete">Credit Note</a>
                                                                    <?php } }?>
                                                                    </td>  
                                                                </tr> 
                                                            <?php $i++;
                                                            }
                                                        } else { ?>
                                                            <tr class="text-dark">
                                                                <td colspan="4">Fee info not found</td>
                                                            </tr>
                                                        <?php   } ?>
                                                    </table>
                                                </div>
                                            </div>
                                        <?php }else{ ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } else {
                                echo "<h5 class='text-center'>Select Student for payment</h5>";
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="payNowModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?php echo base_url(); ?>annualFeesPayment" method="post">

        <div class="modal-header bg-success">
          <h5 class="modal-title text-white">
            <i class="fa fa-credit-card"></i> Pay Fee
          </h5>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

            <!-- Hidden Data -->
            <input type="hidden" name="student_id" value="<?php echo $studentInfo->row_id; ?>">
            <input type="hidden" name="pending_amount" value="<?php echo $pending_amount - $concession_amount; ?>">

            <!-- Pending Amount -->
            <div class="form-group">
                <label>Pending Amount</label>
                <input type="text" class="form-control" 
                       value="₹ <?php echo $pending_amount - $concession_amount; ?>" readonly>
            </div>

            <!-- Enter Amount -->
            <div class="form-group">
                <label>Enter Amount to Pay</label>
                <input type="number" 
                       name="pay_amount" 
                       class="form-control"
                       max="<?php echo $pending_amount - $concession_amount; ?>"
                       min="1"
                       placeholder="Enter amount"
                       required>
            </div>

        </div>

        <div class="modal-footer">

            <button type="submit" class="btn btn-success">
                <i class="fa fa-lock"></i> Proceed to Pay
            </button>

            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                Cancel
            </button>

        </div>

      </form>

    </div>
  </div>
</div>
<!-- confirm modal -->
<div class="modal" id="myReportModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Confirm Fee Payment</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body p-2">
                <form role="form" id="addFeePaymentInfo" action="<?php echo base_url() ?>addFeePaymentInfo" method="post" role="form">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th scope="row">Fee Amount</th>
                                        <td id="fee_amount_display"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Paid Amount</th>
                                        <td id="paid_amount_display"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Pending Fee</th>
                                        <td id="pending_fee_display"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Excess Fee / Card Charges</th>
                                        <td id="excess_fee_display"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Payment Type</th>
                                        <td id="payment_type_display"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="card_info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Transaction Number:</label>
                                            <input onkeypress="return isNumberKey(event)" type="text" name="tran_number" required class="form-control" Placeholder="Transaction Number" id="tran_number" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Transaction Date:</label>
                                            <input type="text" name="tran_date" class="form-control card_date" required Placeholder="Transaction Date" id="tran_date" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Bank Name:</label>
                                            <input type="text" name="tran_bank_name" Value="" required class="form-control" Placeholder="Enter Bank Name" id="tran_bank_name" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dd_info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">DD Number:</label>
                                            <input onkeypress="return isNumberKey(event)" type="text" name="dd_number" required class="form-control" Placeholder="Enter DD Number" id="dd_number" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">DD Date:</label>
                                            <input type="text" name="dd_date" class="form-control" required Placeholder="Enter DD Date" id="dd_date" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Bank Name:</label>
                                            <input type="text" name="bank_name" class="form-control" required Placeholder="Enter Bank Name" id="dd_bank_name" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bank_info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Transaction Number:</label>
                                            <input onkeypress="return isNumberKey(event)" type="text" name="bank_tran_number" required class="form-control" Placeholder="Transaction Number" id="bank_tran_number" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Transaction Date:</label>
                                            <input type="text" name="bank_tran_date" class="form-control card_date" required Placeholder="Transaction Date" id="bank_tran_date" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Bank Name:</label>
                                            <input type="text" name="bank_tran_name" Value="" required class="form-control" Placeholder="Enter Bank Name" id="bank_tran_bank_name" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="upi_info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">UPI/R.R Number:</label>
                                            <input onkeypress="return isNumberKey(event)" type="text" name="upi_tran_number" required class="form-control" Placeholder="Transaction Number" id="upi_tran_number" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Payment Date:</label>
                                            <input type="text" name="upi_tran_date" class="form-control card_date" required Placeholder="Transaction Date" id="upi_tran_date" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="neft_info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Reference Number:</label>
                                            <input  type="text" name="ref_number" required
                                                class="form-control" Placeholder="Payment Ref Number" id="ref_number"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">NEFT Date:</label>
                                            <input type="text" name="neft_date" class="form-control" required
                                                Placeholder="Enter NEFT Date" id="neft_date" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="transaction_date_text" name="transaction_date" value="" required />
                    <input type="hidden" name="application_no" value="<?php echo $studentInfo->row_id; ?>" required />
                    <input type="hidden" id="term_name_selected" name="term_name_selected" value="" required />
                    <input type="hidden" name="student_id" value="<?php echo $studentInfo->student_id; ?>" required />
                    <input type="hidden" id="paid_fee_amount" name="paid_fee_amount" value="" required />
                    <input type="hidden" id="payment_type_input" name="payment_type" value="" required />
                    <input type="hidden" id="excess_amount_input" name="excess_amount" value="" required />
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <input type="submit" form="addFeePaymentInfo" class="btn btn-success float-right proceedFeePaymentInfoButton" value="Proceed" />
            </div>
        </div>
    </div>
</div>

<!--dept fee confirm modal -->
<div class="modal" id="deptComfirmModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Confirm Government Fee Payment</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body p-2">
                <form role="form" id="addGovtFeePaymentInfo" action="<?php echo base_url() ?>addGovtFeePaymentInfo" method="post" novalidate>
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th scope="row">Fee Amount</th>
                                        <td id="deptfee_amount_display"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Paid Amount</th>
                                        <td id="deptpaid_amount_display"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Pending Fee</th>
                                        <td id="deptpending_fee_display"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Excess Fee / Card Charges</th>
                                        <td id="deptexcess_fee_display"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Payment Type</th>
                                        <td id="deptpayment_type_display"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="deptcard_info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Transaction Number:</label>
                                            <input onkeypress="return isNumberKey(event)" type="text" name="govttran_number" required class="form-control" Placeholder="Transaction Number" id="govttran_number" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Transaction Date:</label>
                                            <input type="text" name="govttran_date" class="form-control card_date" required Placeholder="Transaction Date" id="govttran_date" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Bank Name:</label>
                                            <input type="text" name="govttran_bank_name" Value="" required class="form-control" Placeholder="Enter Bank Name" id="govttran_bank_name" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="deptdd_info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">DD Number:</label>
                                            <input onkeypress="return isNumberKey(event)" type="text" name="govtdd_number" required class="form-control" Placeholder="Enter DD Number" id="govtdd_number" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">DD Date:</label>
                                            <input type="text" name="govtdd_date" class="form-control" required Placeholder="Enter DD Date" id="govtdd_date" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Bank Name:</label>
                                            <input type="text" name="govtbank_name" class="form-control" required Placeholder="Enter Bank Name" id="govtbank_name" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="deptbank_info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Transaction Number:</label>
                                            <input onkeypress="return isNumberKey(event)" type="text" name="govtbank_tran_number" required class="form-control" Placeholder="Transaction Number" id="govtbank_tran_number" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Transaction Date:</label>
                                            <input type="text" name="govtbank_tran_date" class="form-control card_date" required Placeholder="Transaction Date" id="govtbank_tran_date" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Bank Name:</label>
                                            <input type="text" name="govtbank_tran_name" Value="" required class="form-control" Placeholder="Enter Bank Name" id="govtbank_tran_name" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="deptupi_info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">UPI/R.R Number:</label>
                                            <input onkeypress="return isNumberKey(event)" type="text" name="govtupi_tran_number" required class="form-control" Placeholder="Transaction Number" id="govtupi_tran_number" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group text-dark">
                                            <label for="usr">Payment Date:</label>
                                            <input type="text" name="govtupi_tran_date" class="form-control card_date" required Placeholder="Transaction Date" id="govtupi_tran_date" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="govttransaction_date_text" name="govttransaction_date" value="" required />
                    <input type="hidden" name="govtapplication_no" value="<?php echo $studentInfo->row_id; ?>" required />
                    <input type="hidden" id="govtterm_name_selected" name="govtterm_name_selected" value="" required />
                    <input type="hidden" name="deptstudent_id" value="<?php echo $studentInfo->student_id; ?>" required />
                    <input type="hidden" id="govtpaid_fee_amount" name="govtpaid_fee_amount" value="" required />
                    <input type="hidden" id="deptpayment_type_input" name="govtpayment_type" value="" required />
                    <input type="hidden" id="deptexcess_amount_input" name="govtexcess_amount" value="" required />
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <input type="submit" form="addGovtFeePaymentInfo" class="btn btn-success float-right proceedGovtFeePaymentInfoButton" value="Proceed" />
            </div>
        </div>
    </div>
</div>

<!--Edit Receipt Model--->
<div id="receiptEdit" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header modal-call-report">
                <div class=" col-md-10 col-10">
                    <span class="text-white mobile-title m-1" style="font-size : 20px">Edit Receipt</span>
                </div>
                <div class=" col-md-2 col-2">
                    <button type="button" class="text-white close" data-dismiss="modal">&times;</button>
                </div>
            </div>
            <!-- Modal body -->
            <div class="modal-body m-0 p-1">
                <?php $this->load->helper("form"); ?>
                <form role="form" id="updateFeeReceipt" action="<?php echo base_url() ?>updateFeeReceipt" method="post" role="form">
                    <input type="hidden" name="row_id" id="row_id" value="" />
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Payment Date</label>
                                <input type="text" class="form-control " id="pay_date" name="pay_date" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input style="float:right;" type="submit" class="btn btn-primary" value="Update" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!----End Edit Receipt Model-->

<!--Edit Dept Receipt Model--->
<div id="receiptDeptEdit" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header modal-call-report">
                <div class=" col-md-10 col-10">
                    <span class="text-white mobile-title m-1" style="font-size : 20px">Edit Receipt</span>
                </div>
                <div class=" col-md-2 col-2">
                    <button type="button" class="text-white close" data-dismiss="modal">&times;</button>
                </div>
            </div>
            <!-- Modal body -->
            <div class="modal-body m-0 p-1">
                <?php $this->load->helper("form"); ?>
                <form role="form" id="updateDeptFeeReceipt" action="<?php echo base_url() ?>updateDeptFeeReceipt" method="post" role="form">
                    <input type="hidden" name="dept_row_id" id="dept_row_id" value="" />
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Payment Date</label>
                                <input type="text" class="form-control " id="pay_dept_date" name="pay_dept_date" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input style="float:right;" type="submit" class="btn btn-primary" value="Update" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!----End Dept Edit Receipt Model-->

<!-- The Modal for order ID process-->
<div class="modal" id="orderIDProcesse">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Order Id status check</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" action="<?php echo base_url() ?>orderIdProcess">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Enter Order ID</label>
                                <!-- <input type="text" style="text-transform:uppercase" placeholder="Enter Order ID"
                                    id="order_id" name="order_id" class="form-control" value="" required></input> -->
                                <select class="form-control selectpicker" data-live-search="true" name="order_id" required>
                                    <option value="">Select Order ID to process</option>
                                    <?php if (!empty($orderIDInfo)) {
                                        foreach ($orderIDInfo as $oid) {  ?>
                                            <option value="<?php echo $oid->order_id; ?>">
                                                <b><?php echo $oid->order_id; ?></b>
                                            </option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="orderIDProcess" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    function openModel(row_id, pay_date) {
        $('#row_id').val(row_id);
        var yourString = String(pay_date);
        var result = yourString.substring(1, yourString.length - 1);
        $('#pay_date').val(result);
        $('#receiptEdit').modal('show');
    }
    function openDeptModel(row_id, pay_date) {
        $('#dept_row_id').val(row_id);
        var yourString = String(pay_date);
        var result = yourString.substring(1, yourString.length - 1);
        $('#pay_dept_date').val(result);
        $('#receiptDeptEdit').modal('show');
    }
    jQuery(document).ready(function() {
        jQuery('#transaction_date, .dateSearch, #tran_date, #dd_date, #govttran_date, #govtdd_date, #pay_dept_date, #pay_date,#govttransaction_date,#bank_tran_date,#upi_tran_date,#govtbank_tran_date,#govtupi_tran_date, #neft_date').datepicker({
            autoclose: true,
            orientation: "up",
            format: "dd-mm-yyyy"
        });
        $('.dd_info').hide();
        $('.card_info').hide();
        $('.bank_info').hide();
        $('.upi_info').hide();
        $('.deptdd_info').hide();
        $('.deptcard_info').hide();
        $('.deptbank_info').hide();
        $('.deptupi_info').hide();
        $('.neft_info').hide();
        //   $('.loaderScreen').hide();
        $("#searchStudentFeeInfo").click(function() {
            $('.loaderScreen').show();
        });
        jQuery(document).on("click", ".deleteFeesReceipt", function(){
            var row_id = $(this).data("row_id"),
                hitURL = baseURL + "deleteFeesReceipt",
                currentRow = $(this);
            var confirmation = confirm("Are you sure you want to delete this Receipt?");
            if (confirmation) {
                var remark;
                do {
                    // Prompt the user to enter a remark
                    remark = prompt("Enter remark:");
                    // Check if the user clicked "Cancel"
                    if (remark === null) {
                        // Exit the function if the user cancels
                        return;
                    }
                    // Check if the user entered a remark
                    if (remark.trim() === "") {
                        alert("Remark is mandatory. Please enter a remark.");
                    }
                } while (remark.trim() === "");
                // Continue with the deletion process
                jQuery.ajax({
                    type: "POST",
                    dataType: "json",
                    url: hitURL,
                    data: {
                        row_id: row_id,
                        remark: remark  // Include the remark in the data sent to the server
                    }
                }).done(function(data) {
                    currentRow.parents('tr').remove();
                    if (data.status === true) {
                        alert("Fee Receipt successfully Deleted");
                    } else if (data.status === false) {
                        alert("Failed to delete Receipt");
                    } else {
                        alert("Access denied..!");
                    }
                    location.reload();
                });
            }
        });
        jQuery(document).on("click", ".deleteMgmtFeeReceipt", function(){
            var row_id = $(this).data("row_id"),
                hitURL = baseURL + "deleteMgmtFeeReceipt",
                currentRow = $(this);
            var confirmation = confirm("Are you sure you want to delete this Receipt?");
            if (confirmation) {
                var remark;
                do {
                    // Prompt the user to enter a remark
                    remark = prompt("Enter remark:");
                    // Check if the user clicked "Cancel"
                    if (remark === null) {
                        // Exit the function if the user cancels
                        return;
                    }
                    // Check if the user entered a remark
                    if (remark.trim() === "") {
                        alert("Remark is mandatory. Please enter a remark.");
                    }
                } while (remark.trim() === "");
                // Continue with the deletion process
                jQuery.ajax({
                    type: "POST",
                    dataType: "json",
                    url: hitURL,
                    data: {
                        row_id: row_id,
                        remark: remark  // Include the remark in the data sent to the server
                    }
                }).done(function(data) {
                    currentRow.parents('tr').remove();
                    if (data.status === true) {
                        alert("Fee Receipt successfully Deleted");
                    } else if (data.status === false) {
                        alert("Failed to delete Receipt");
                    } else {
                        alert("Access denied..!");
                    }
                    location.reload();
                });
            }
        });

        //slect payment method option change
        $("#paymentInfoSubmit").on('click', function() {
            var payment_type = $('#payment_type').val();
            var fee_amount = <?php echo $balance; ?>;
            var excess_amount = 0;
            var card_charges = 0;
            var paid_amount_display = $('#paid_amount').val();
            //alert(paid_amount_display);
            if (paid_amount_display == "") {
                alert("Please Enter Paid Amount");
                return;
            }
            var transaction_date = $('#transaction_date').val();
            if (transaction_date == "") {
                alert("Please Select Transaction Date");
                return;
            }
            if (payment_type == "") {
                alert("Please Select Payment Type");
                return;
            }
            var pending_fee_amount = fee_amount - paid_amount_display;
            if (payment_type == "DD") {
                $('.dd_info').show();
                $('.card_info').hide();
                $('.bank_info').hide();
                $('.upi_info').hide();
            } else if (payment_type == "CARD") {
                card_charges = (2.0 / 100) * paid_amount_display;
                $('.dd_info').hide();
                $('.card_info').show();
                $('.bank_info').hide();
                $('.upi_info').hide();
            } else if (payment_type == "CASH") {
                $('.dd_info').hide();
                $('.card_info').hide();
                $('.bank_info').hide();
                $('.upi_info').hide();
            } else if (payment_type == "UPI") {
                $('.dd_info').hide();
                $('.card_info').hide();
                $('.bank_info').hide();
                $('.upi_info').show();
            } else if (payment_type == "BANK") {
                $('.dd_info').hide();
                $('.card_info').hide();
                $('.bank_info').show();
                $('.upi_info').hide();
            } else if (payment_type == "NEFT") {
                $('.dd_info').hide();
                $('.card_info').hide();
                $('.neft_info').show();
                $('.upi_info').hide();
                $('.bank_info').hide();
            } else {
                $('.dd_info').hide();
                $('.card_info').hide();
                $('.bank_info').hide();
                $('.upi_info').hide();
            }
            if (pending_fee_amount < 0) {
                excess_amount = pending_fee_amount;
            } else {
                excess_amount = 0;
            }
            excess_amount = excess_amount + card_charges;
            excess_amount = Number(excess_amount).toFixed(2);
            $('#paid_amount_display').html(paid_amount_display);
            $('#fee_amount_display').html(fee_amount);
            $('#pending_fee_display').html(pending_fee_amount);
            $('#excess_fee_display').html(excess_amount);
            $('#payment_type_display').html(payment_type);
            $('#paid_fee_amount').val(paid_amount_display);
            $('#payment_type_input').val(payment_type);
            $('#transaction_date_text').val(transaction_date);
            $('#excess_amount_input').val(excess_amount);
            $('#term_name_selected').val('II PUC');
            $('#myReportModal').modal('show');
        });

        $("#deptPaymentInfoSubmit").on('click', function() {
            var payment_type = $('#govtpayment_type').val();
            var fee_amount = <?php echo $govt_fee; ?>;
            var excess_amount = 0;
            var card_charges = 0;
            var term_name = $('#term_name_of_std').val();
            var paid_amount_display = $('#deptpaid_amount').val();
            if (paid_amount_display == "") {
                alert("Please Enter Govt Paid Amount");
                return;
            }
            var transaction_date = $('#govttransaction_date').val();
            if (transaction_date == "") {
                alert("Please Select Govt Transaction Date");
                return;
            }
            if (payment_type == "") {
                alert("Please Select Govt Payment Type");
                return;
            }
            var pending_fee_amount = fee_amount - paid_amount_display;
            // alert(payment_type);
            if (payment_type == "DD") {
                $('.deptdd_info').show();
                $('.deptcard_info').hide();
                $('.deptbank_info').hide();
                $('.deptupi_info').hide();
            } else if (payment_type == "CARD") {
                card_charges = (2.0 / 100) * paid_amount_display;
                $('.deptdd_info').hide();
                $('.deptcard_info').show();
                $('.deptbank_info').hide();
                $('.deptupi_info').hide();
            } else if (payment_type == "CASH") {
                $('.deptdd_info').hide();
                $('.deptcard_info').hide();
                $('.deptbank_info').hide();
                $('.deptupi_info').hide();
            } else if (payment_type == "BANK") {
                $('.deptdd_info').hide();
                $('.deptcard_info').hide();
                $('.deptbank_info').show();
                $('.deptupi_info').hide();
            } else if (payment_type == "UPI") {
                $('.deptdd_info').hide();
                $('.deptcard_info').hide();
                $('.deptbank_info').hide();
                $('.deptupi_info').show();
            } else {
                $('.deptdd_info').hide();
                $('.deptcard_info').hide();
                $('.deptbank_info').hide();
                $('.deptupi_info').hide();
            }
            if (pending_fee_amount < 0) {
                excess_amount = pending_fee_amount;
            } else {
                excess_amount = 0;
            }
            excess_amount = excess_amount + card_charges;
            excess_amount = Number(excess_amount).toFixed(2);
            $('#deptpaid_amount_display').html(paid_amount_display);
            $('#deptfee_amount_display').html(fee_amount);
            $('#deptpending_fee_display').html(pending_fee_amount);
            $('#deptexcess_fee_display').html(excess_amount);
            $('#deptpayment_type_display').html(payment_type);
            $('#govtpaid_fee_amount').val(paid_amount_display);
            $('#deptpayment_type_input').val(payment_type);
            $('#govttransaction_date_text').val(transaction_date);
            $('#deptexcess_amount_input').val(excess_amount);
            $('#govtterm_name_selected').val(term_name);
            $('#deptComfirmModal').modal('show');
        });

        $("#firstPaymentInfoSubmit").on('click', function() {
            var payment_type = $('#payment_type').val();
            var fee_amount = <?php echo $I_balance; ?>;
            var excess_amount = 0;
            var card_charges = 0;
            var paid_amount_display = $('#paid_amount').val();
            if (paid_amount_display == "") {
                alert("Please Enter Paid Amount");
                return;
            }
            var transaction_date = $('#transaction_date').val();
            if (transaction_date == "") {
                alert("Please Select Transaction Date");
                return;
            }
            if (payment_type == "") {
                alert("Please Select Payment Type");
                return;
            }
            var pending_fee_amount = fee_amount - paid_amount_display;
            // alert(payment_type);
            if (payment_type == "DD") {
                $('.dd_info').show();
                $('.card_info').hide();
                $('.bank_info').hide();
                $('.upi_info').hide();
            } else if (payment_type == "CARD") {
                card_charges = (2.0 / 100) * paid_amount_display;
                $('.dd_info').hide();
                $('.card_info').show();
                $('.bank_info').hide();
                $('.upi_info').hide();
            } else if (payment_type == "CASH") {
                $('.dd_info').hide();
                $('.card_info').hide();
                $('.bank_info').hide();
                $('.upi_info').hide();
            } else if (payment_type == "UPI") {
                $('.dd_info').hide();
                $('.card_info').hide();
                $('.bank_info').hide();
                $('.upi_info').show();
            } else if (payment_type == "BANK") {
                $('.dd_info').hide();
                $('.card_info').hide();
                $('.bank_info').show();
                $('.upi_info').hide();
            } else if (payment_type == "NEFT") {
                $('.dd_info').hide();
                $('.card_info').hide();
                $('.neft_info').show();
                $('.upi_info').hide();
                $('.bank_info').hide();
            } else {
                $('.dd_info').hide();
                $('.card_info').hide();
                $('.bank_info').hide();
                $('.upi_info').hide();
            }
            if (pending_fee_amount < 0) {
                excess_amount = pending_fee_amount;
            } else {
                excess_amount = 0;
            }
            excess_amount = excess_amount + card_charges;
            excess_amount = Number(excess_amount).toFixed(2);
            $('#paid_amount_display').html(paid_amount_display);
            $('#fee_amount_display').html(fee_amount);
            $('#pending_fee_display').html(pending_fee_amount);
            $('#excess_fee_display').html(excess_amount);
            $('#payment_type_display').html(payment_type);
            $('#paid_fee_amount').val(paid_amount_display);
            $('#payment_type_input').val(payment_type);
            $('#transaction_date_text').val(transaction_date);
            $('#excess_amount_input').val(excess_amount);
            $('#term_name_selected').val('I PUC');
            $('#myReportModal').modal('show');
        });

        $(".proceedFeePaymentInfoButton").click(function() {
            var payment_type = $('#payment_type').val();
            if (payment_type == "DD") {
                if (!$('#dd_number').val()) {
                    alert("DD Number is required");
                    event.preventDefault();
                    return;
                }
                if (!$('#dd_date').val()) {
                    alert("DD Date is required");
                    event.preventDefault();
                    return;
                }
                if (!$('#dd_bank_name').val()) {
                    alert("DD Bank Name is required");
                    event.preventDefault();
                    return;
                }
            }else if (payment_type == "CARD"){
                if (!$('#tran_number').val()) {
                    alert("Transaction Number is required");
                    event.preventDefault();
                    return;
                }
                if (!$('#tran_date').val()) {
                    alert("Transaction Date is required");
                    event.preventDefault();
                    return;
                }
                if (!$('#tran_bank_name').val()) {
                    alert("Bank Name is required");
                    event.preventDefault();
                    return;
                }
            }else if (payment_type == "UPI"){
                if (!$('#upi_tran_number').val()) {
                    alert("UPI Reference No. is required");
                    event.preventDefault();
                    return;
                }
                if (!$('#upi_tran_date').val()) {
                    alert("Transaction Date is required");
                    event.preventDefault();
                    return;
                }
            }else if (payment_type == "BANK"){
                if (!$('#bank_tran_number').val()) {
                    alert("Transaction Number is required");
                    event.preventDefault();
                    return;
                }
                if (!$('#bank_tran_date').val()) {
                    alert("Bank Date is required");
                    event.preventDefault();
                    return;
                }
                if (!$('#bank_tran_bank_name').val()) {
                    alert("Bank Name is required");
                    event.preventDefault();
                    return;
                }
            }else if (payment_type == "NEFT"){
                if (!$('#ref_number').val()) {
                    alert("Reference Number is required");
                    event.preventDefault();
                    return;
                }

                if (!$('#neft_date').val()) {
                    alert("NEFT Date is required");
                    event.preventDefault();
                    return;
                }
            }
            if ($("#addFeePaymentInfo").valid()) {
                $('.loaderScreen').show();
                $('#myReportModal').modal('hide')
            }
        });

        $(".proceedGovtFeePaymentInfoButton").click(function() {
            var payment_type = $('#govtpayment_type').val();
            if (payment_type == "DD") {
                if (!$('#govtdd_number').val()) {
                    alert("DD Number is required");
                    event.preventDefault();
                    return;
                }
                if (!$('#govtdd_date').val()) {
                    alert("DD Date is required");
                    event.preventDefault();
                    return;
                }
                if (!$('#deptdd_bank_name').val()) {
                    alert("DD Bank Name is required");
                    event.preventDefault();
                    return;
                }
            }else if (payment_type == "CARD"){
                if (!$('#govttran_number').val()) {
                    alert("Transaction Number is required");
                    event.preventDefault();
                    return;
                }
                if (!$('#govttran_date').val()) {
                    alert("Transaction Date is required");
                    event.preventDefault();
                    return;
                }
                if (!$('#govttran_bank_name').val()) {
                    alert("Bank Name is required");
                    event.preventDefault();
                    return;
                }
            }else if (payment_type == "UPI"){
                if (!$('#govtupi_tran_number').val()) {
                    alert("UPI Reference No. is required");
                    event.preventDefault();
                    return;
                }
                if (!$('#govtupi_tran_date').val()) {
                    alert("Transaction Date is required");
                    event.preventDefault();
                    return;
                }
            }else if (payment_type == "BANK"){
                if (!$('#govtbank_tran_number').val()) {
                    alert("Transaction Number is required");
                    event.preventDefault();
                    return;
                }
                if (!$('#govtbank_tran_date').val()) {
                    alert("Bank Date is required");
                    event.preventDefault();
                    return;
                }
                if (!$('#govtbank_tran_name').val()) {
                    alert("Bank Name is required");
                    event.preventDefault();
                    return;
                }
            }
            if ($("#addFeePaymentInfo").valid()) {
                $('.loaderScreen').show();
                $('#myReportModal').modal('hide')
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
    function checkAmount() {
        var amount = document.getElementById("paid_amount").value;
        var pending = '<?php echo $ii_management_fee_pending; ?>';
        // Convert the amount and the pending to numbers
        amount = Number(amount);
        pending = Number(pending);
        // Compare the amount and the pending using numeric comparison
        if (amount > pending) {
            alert("The paid amount cannot be greater than the pending amount");
            // Clear the value of the amount element
            document.getElementById("paid_amount").value = '';
        }
    }
    function checkIPUCAmount() {
        var amount = document.getElementById("paid_amount").value;
        var pending = '<?php echo $previousBal; ?>';
        // Convert the amount and the pending to numbers
        amount = Number(amount);
        pending = Number(pending);
        // Compare the amount and the pending using numeric comparison
        if (amount > pending) {
            alert("The paid amount cannot be greater than the pending amount");
            // Clear the value of the amount element
            document.getElementById("paid_amount").value = '';
        }
    }
</script>