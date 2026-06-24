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
                            <div class="col-lg-5 col-12 col-md-12 box-tools">
                                <span class="page-title">
                                    <i class="fa fa-users"></i> Portal Registrations
                                </span>
                            </div>
                            <div class="col-lg-3 col-md-6 col-6">
                                <b class="text-dark" style="font-size: 20px;">Total Students: <?php echo $totalStudentCount; ?></b>
                            </div>
                            <div class="col-lg-4 col-md-6 col-6">
                                <a onclick="showLoader();window.history.back();" class="btn primary_color mobile-btn float-right text-white "
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
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
                        <table class="display table table-bordered table-striped table-hover portalStudent_table mb-2 w-100">
                        <form action="<?php echo base_url(); ?>studentRegisterListing" method="POST" id="byFilterMethod">
                                <tr class="filter_row" class="text-center">
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $student_id; ?>" name="student_id" id="student_id" class="form-control form-control-sm" placeholder="Student ID" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $by_dob; ?>" name="by_dob" id="by_dob" class="form-control form-control-sm datepicker" placeholder="DOB" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $by_date; ?>" name="by_date" id="by_date" class="form-control form-control-sm datepicker" placeholder="Registered Date" autocomplete="off">
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <button type="submit"class="btn btn-success btn-block mobile-width"><i class="fa fa-filter"></i> Filter</button>
                                    </td>
                                </tr>
                            </form>
                            <thead>
                                <tr class="table_row_background text-center">
                                    <th>Student ID</th>
                                    <!-- <th>Name</th> -->
                                    <th>DOB</th>
                                    <th>Reg. Date</th>
                                    <th>Password</th>
                                    <th>Re-Type Password</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($registrationData)){
                                    foreach($registrationData as $record){ ?>
                                    <form role="form" method="post" action="<?php echo base_url() ?>updateStudentPassword">
                                        <input type="hidden" name="row_id" id="row_id" value="<?php echo $record->row_id; ?>" />
                                        <tr class="filter_row">
                                            <td class="text-center"><?php echo $record->student_id; ?></td>
                                            <td class="text-center"><?php echo date('d-m-Y',strtotime($record->dob)); ?></td>
                                            <td class="text-center"><?php echo date('d-m-Y',strtotime($record->created_date)); ?></td>
                                            <td width="180">
                                                <div class="form-group mb-0">
                                                    <input type="password" placeholder="Type Password" class="form-control form-control-sm" name="password" id="password" autocomplete="off" required>
                                                </div>
                                            </td>
                                            <td width="180">
                                                <div class="form-group mb-0">
                                                    <input type="password" placeholder="Type Password" class="form-control form-control-sm" name="cPassword" id="cPassword" autocomplete="off" required>
                                                </div>
                                            </td>
                                            <td width="150" class="text-center">
                                                <?php if($role == ROLE_OFFICE || $role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR) { ?>
                                                    <button type="submit" class="btn btn-sm btn-info px-2 py-1"> Update</button>

                                                    <a class="btn btn-sm btn-danger deleteRegisteredStudent px-2 py-1" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                                <?php }  ?>
                                            </td>
                                        </tr>
                                    </form>
                                <?php } }else{ ?>
                                    <tr>
                                        <td class="text-center" colspan="8">
                                            Student Record Not Found!.
                                        </td>
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


<script src="<?php echo base_url(); ?>assets/js/forgotPassword.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
   
    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "studentRegisterListing/" + value);
        jQuery("#byFilterMethod").submit();
    });


    jQuery('.datepicker').datepicker({
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

    
});
</script>