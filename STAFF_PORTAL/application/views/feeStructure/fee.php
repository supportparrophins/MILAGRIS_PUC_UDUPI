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
<?php
        $warning = $this->session->flashdata('warning');
        if ($warning) {
        ?>
<div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <i class="fa fa-check mx-2"></i>
    <strong>warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
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
                            <div class="col-lg-4 col-6 col-md-4 col-sm-4 box-tools">
                                <span class="page-title">
                                    <i class="material-icons">description</i> Fee Structure
                                </span>
                            </div>
                            <div class="col-lg-3 col-6 col-md-4 col-sm-3">
                                <div class="count_heading">Total: <?php echo $totalCount; ?></div>
                            </div>
                            <div class="col-lg-5 col-md-4 col-12 col-sm-5">

                                <a onclick="window.history.back();"
                                    class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                <a class="btn btn-primary mobile-btn float-right border_right_radius"
                                    href="<?php echo base_url(); ?>addNewFeeStructure"><i class="fa fa-plus"></i>
                                    Add</a>
                                <!-- <button data-toggle="modal" data-target="#downloadFeeStructure"
                                    class="btn btn-info mobile-btn float-right text-white border_right_radius" value="Download"><i
                                        class="fa fa-download" aria-hidden="true"></i> Download </button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2">
                        <div class="table-responsive">
                            <table class="display table table-bordered table-striped table-hover w-100">
                                <form action="<?php echo base_url(); ?>viewFeeStructure" method="POST" id="byFilterMethod"">
                                    <tr class="filter_row" class="text-center">
                                        <td>
                                            <div class="form-group mb-0">
                                                <!-- <input type="text" value="" name="fee_name" id="fee_name" class="form-control input-sm" placeholder="By Fee Name" autocomplete="off"> -->
                                            
                                                <select class="form-control" name="fee_name" id="fee_name">
                                                    <?php if(!empty($fee_name)){ ?>
                                                        <option value="<?php echo $fee_name; ?>">selected: <?php echo $fee_name; ?></option>
                                                    <?php } ?>
                                                    <option value="">By Fee Name</option>
                                                    <?php if(!empty($feeNameInfo)){
                                                        foreach($feeNameInfo as $fee){  ?>
                                                            <option value="<?php echo $fee->fee_name; ?>"><?php echo $fee->fee_name; ?></option>
                                                    <?php } } ?>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group mb-0">
                                                <input type="text" value="<?php echo $sslc_board_amt; ?>" name="sslc_board_amt" id="sslc_board_amt" class="form-control input-sm" placeholder="By SSLC Board Amount" autocomplete="off">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group mb-0">
                                                <input type="text" value="<?php echo $cbse_board_amt; ?>" name="cbse_board_amt" id="cbse_board_amt" class="form-control input-sm" placeholder="By ICSE/CBSE Board Amount" autocomplete="off">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group mb-0">
                                                <input type="text" value="<?php echo $nri_fee_amt; ?>" name="nri_fee_amt" id="nri_fee_amt" class="form-control input-sm" placeholder="By NRI Board Amount" autocomplete="off">
                                            </div>
                                        </td>
                                        <td width="180">
                                            <div class="form-group mb-0">
                                                <select class="form-control" name="by_term" id="by_term">
                                                    <?php if(!empty($by_term)){ ?>
                                                        <option value="<?php echo $by_term; ?>" selected><b>Selected: <?php echo $by_term; ?></b></option>
                                                    <?php } ?>
                                                    <option value="">By Term</option>
                                                    <option value="I PUC">I PUC</option>
                                                    <option value="II PUC">II PUC</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td width="180">
                                            <div class="form-group mb-0">
                                                <select class="form-control" name="by_stream" id="by_stream">
                                                    <?php if(!empty($by_stream)){ ?>
                                                        <option value="<?php echo $by_stream; ?>" selected><b>Selected: <?php echo $by_stream; ?></b></option>
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
                                                <select class="form-control" name="by_Section" id="by_Section">
                                                    <?php if(!empty($by_Section)){ ?>
                                                        <option value="<?php echo $by_Section; ?>" selected><b>Selected: <?php echo $by_Section; ?></b></option>
                                                    <?php } ?>
                                                    <option value="">By Account</option>
                                                    <?php if(!empty($accountDetails)){
                                                        foreach($accountDetails as $bank){ ?>
                                                    <option value="<?php echo $bank->account_no; ?>"><?php echo $bank->account_no; ?></option>
                                                    <?php } } ?>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group mb-0">
                                                <select class="form-control" name="by_fee_type" id="by_fee_type">
                                                    <?php if(!empty($by_fee_type)){ ?>
                                                        <option value="<?php echo $by_fee_type; ?>" selected><b>Selected: <?php echo $by_fee_type; ?></b></option>
                                                    <?php } ?>
                                                    <option value="">By Fee Type</option>
                                                    <?php if(!empty($feeTypeInfo)){
                                                        foreach($feeTypeInfo as $fee){ ?>
                                                            <option value="<?php echo $fee->row_id; ?>"><?php echo $fee->feeType; ?></option>
                                                    <?php } } ?>
                                                </select>
                                            </div>
                                        </td>
                                        <td>         
                                            <div class="form-group">
                                                <select class="form-control" name="fee_student_type"
                                                    id="fee_student_type">
                                                    <?php if(!empty($fee_student_type)){ ?>
                                                    <option value="<?php echo $fee_student_type; ?>">
                                                        Selected: <?php echo $fee_student_type; ?> </option>
                                                    <?php } ?>
                                                    <option value="">Select Fee Student Type</option>
                                                    <option value="Aided">Aided</option>
                                                    <option value="Unaided">Unaided</option>
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
                                        <th>Fee Name</th>
                                        <th>SSLC Board Amt</th>
                                        <th>ISCE/CBSE Board Amt</th>
                                        <th>NRI Board Amt</th>
                                        <th>Term</th>
                                        <th>Stream</th>
                                        <th>Account</th>
                                        <th>Fee Type</th>
                                        <th>Fee Student Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($feeInfo)){
                                        foreach($feeInfo as $fee){ ?>
                                        <tr>
                                            <th class="text-capitalize"><?php echo $fee->fee_name; ?></th>
                                            <th class="text-center"><?php echo $fee->fee_amount_state_board; ?></th>
                                            <th class="text-center"><?php echo $fee->fee_amount_icse_cbse; ?></th>
                                            <th class="text-center"><?php echo $fee->fee_amount_nri; ?></th>
                                            <th class="text-center"><?php echo $fee->term_name; ?></th>
                                            <th class="text-center"><?php echo $fee->stream_name; ?></th>
                                            <th class="text-center"><?php echo $fee->account_no; ?></th>
                                            <th><?php echo $fee->feeType; ?></th>
                                            <th><?php echo $fee->fee_student_type; ?></th>
                                            <th class="text-center" width="140">
                                                <a class="btn btn-xs btn-primary" href="<?php echo base_url(); ?>editFeeStructure/<?php echo $fee->row_id; ?>" title="Edit"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                                <?php if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR){ ?>
                                                    <a class="btn btn-xs btn-danger deleteFeeStrtucture"
                                                    data-row_id="<?php echo $fee->row_id; ?>" href="#" title="Delete">
                                                    <i class="fas fa-trash"></i></a>
                                                <?php } ?>
                                                
                                            
                                            </th>
                                        </tr>
                                    <?php } }else{  ?>
                                    <tr>
                                        <th colspan="9" class="text-center">Fee Record Not Found</th>
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
</div>

<!-- The Modal -->
<div class="modal" id="downloadFeeStructure">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header p-2">
                <h6 class="modal-title">Download Fee Structure</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form method="POST" action="<?php echo base_url().'download_fee_structure_excel'?>">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Select Term</label>
                                <select class="form-control" name="term_name_select" id="term_name_select" required>
                                    <option value="I">I PUC</option>
                                    <option value="II">II PUC</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-download"
                                        aria-hidden="true"></i> Download</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/fee.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "viewFeeStructure/" + value);
        jQuery("#byFilterMethod").submit();
    });
   
    
    jQuery('.datepicker, .dateSearch').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });
});
</script>