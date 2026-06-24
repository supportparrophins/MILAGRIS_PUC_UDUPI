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
                            <div class="col-lg-4 col-6 col-md-6 col-sm-6 box-tools">
                                <span class="page-title">
                                    <i class="fas fa-rupee-sign"></i> Management Fee
                                </span>
                            </div>
                            <div class="col-lg-2 col-6 col-md-6 col-sm-6">
                                <b class="text-dark count_heading">Total: <?php echo $totalCount; ?></b>
                            </div>
                            <div class="col-lg-3 col-6 col-md-6 col-sm-6">
                                <b class="text-dark count_heading">Total Amount: <?php echo $mngtfeeSum->total_amount; ?></b>
                            </div>
                            <div class="col-lg-3 col-6 col-md-6 col-sm-6">
                                <a onclick="showLoader();window.history.back();"
                                    class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                <a class="btn btn-primary pull-right mobile-btn border_right_radius" href="#"
                                    data-toggle="modal" data-target="#mngtFeeModel">
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
                            <form action="<?php echo base_url(); ?>viewManagementFeeInfo" method="POST" id="byFilterMethod">
                                <tr class="filter_row" class="text-center">
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $by_date; ?>" name="by_date" id="by_date"
                                                class="form-control input-sm datepicker" placeholder="Date"
                                                autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $student_id; ?>" name="student_id" id="by_name"
                                                class="form-control input-sm" placeholder="Student ID" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $by_name; ?>" name="by_name" id="by_name"
                                                class="form-control input-sm" placeholder="Name" autocomplete="off">
                                        </div>
                                    </td>
                                    <td> 
                                        <div class="form-group mb-0">
                                            <select class="form-control" name="stream_name" id="stream_name">
                                                <?php if(!empty($stream_name)){ ?>
                                                    <option value="<?php echo $stream_name; ?>" selected><b>Selected: <?php echo $stream_name; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Stream</option>
                                                <?php if(!empty($streamInfo)){
                                                    foreach($streamInfo as $stream){ ?>
                                                <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $order_id; ?>" name="order_id" id="order_id"
                                                class="form-control input-sm" placeholder="Order ID" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $amount; ?>" name="amount" id="amount"
                                                class="form-control input-sm" placeholder="Amount" autocomplete="off">
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
                                    <th>Date</th>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Stream</th>
                                    <th>Order ID</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($mngtFeeInfo)){
                                    foreach($mngtFeeInfo as $fee){ ?>
                                <tr>
                                    <th class="text-center" width="150"><?php echo date('d-m-Y',strtotime($fee->date)); ?></th>
                                    <th class="text-center" width="180"><?php echo $fee->application_no; ?></th>
                                    <th width="330"><?php echo $fee->name; ?></th>
                                    <th class="text-center" width="100"><?php echo $fee->stream_name; ?></th>
                                    <th class="text-center" width="150"><?php echo $fee->order_id; ?></th> 
                                    <th class="text-center" width="150"><?php echo $fee->amount; ?></th> 
                                    <th width="180" class="text-center">
                                        <?php if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN){   ?>
                                            <a class="btn btn-xs btn-info"
                                                href="<?php echo base_url(); ?>editMngtFee/<?php echo $fee->row_id; ?>"
                                                title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                            <!-- <a class="btn btn-xs btn-danger deleteMngtFee" data-row_id="<?php echo $fee->row_id; ?>"
                                                href="#" title="Delete"><i class="fas fa-trash"></i></a> -->
                                        <?php } ?>
                                        <a class="btn btn-xs btn-primary"
                                            href="<?php echo base_url(); ?>printMngtFeeReceipt/<?php echo $fee->row_id; ?>" target="_blank" title="Print"><i class="fas fa-print"></i></a>
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

    <div class="modal" id="mngtFeeModel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="padding: 7px 15px;">
                    <h4 class="modal-title">Add Management Fee</h4>
                    <button type="button" class="close float-right" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body p-2">
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addConcessionInfo" action="<?php echo base_url() ?>addManagementFeeInfo"
                        method="post" role="form">
                        <div class="row form-contents">
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label>Enter Date <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control datepicker" id="feeDate" name="feeDate"
                                        placeholder="Enter Date" readonly
                                        required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label>Select Student <span class="text-danger">*</span></label>
                                    <select class="form-control selectpicker" data-live-search="true"
                                        name="application_no" required autocomplete="off">
                                        <option value="">Select Student</option>
                                        <?php if(!empty($studentInfo)){
                                            foreach($studentInfo as $std){  ?>
                                        <option value="<?php echo $std->application_no; ?>">
                                            <b><?php echo $std->student_id.' - '.$std->student_name; ?></b></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label>Enter Amount <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " id="fee_amount" name="fee_amount"
                                        placeholder="Enter Amount" onkeypress="return isNumberKey(event)"
                                        required autocomplete="off">
                                </div>
                            </div>
                            <!-- <div class="col-12">
                                <div class="form-group mb-0">
                                    <label>Enter Description</label>
                                    <textarea type="text" class="form-control" id="description" name="description"
                                        rows="5" placeholder="Enter Description" autocomplete="off"
                                        maxlength="1500"></textarea>
                                </div>
                            </div> -->
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
jQuery(document).ready(function() {

    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "viewManagementFeeInfo/" + value);
        jQuery("#byFilterMethod").submit();
    });

    jQuery('.datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy",
        startDate: "01-03-2021",
        // endDate: "today"
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