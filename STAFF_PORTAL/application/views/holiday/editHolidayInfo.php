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



<div class="main-content-container px-3 pt-1">

    <div class="content-wrapper">

        <section class="content-header">

            <div class="row p-0 column_padding_card">

                <div class="col column_padding_card">

                    <div class="card card-small p-0 card_heading_title">

                        <div class="card-body p-2">

                            <span class="page-title absent_table_title_mobile">

                                <i class="material-icons">event</i> Edit Holiday Info

                            </span>



                            <a onclick="window.history.back();" class="btn btn-secondary float-right text-white pt-2"

                                value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>

                        </div>

                    </div>

                </div>

            </div>

        </section>

        <!-- form start -->

        <div class="row form-employee p-0 column_padding_card">
            <div class="col column_padding_card">
                <form role="form" id="editHoliday" action="<?php echo base_url() ?>updateHoliday" method="post">
                    <input type="hidden" value="<?php echo $holidayInfo->row_id; ?>" name="row_id" />

                    <div class="card card-small c-border mb-4 p-2">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="fromDateFrom">Holiday Date From</label>
                                    <input name="fromDateFrom" type="text" class="holidayDateFrom form-control" id="fromDateFrom"
                                        value="<?php echo date('d-m-Y', strtotime($holidayInfo->holiday_date)); ?>"
                                        placeholder="Select Holiday Date From" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="fromDateTo">Holiday Date To</label>
                                    <input name="fromDateTo" type="text" class="holidayDateTo form-control" id="fromDateTo"
                                        value="<?php if(!empty($holidayInfo->holiday_date_to)){ echo date('d-m-Y', strtotime($holidayInfo->holiday_date_to)); } ?>"
                                        placeholder="Select Holiday Date To" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            
                    
                            <div class="col-lg-6">
                                <label>Holiday For:</label>
                                <hr class="mt-1 mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" value="1" class="custom-control-input" id="only_student" name="only_student" 
                                        <?php if($holidayInfo->students_status == 1) echo 'checked'; ?>>
                                    <label class="custom-control-label" for="only_student">Only Students</label>
                                </div>
                                <?php 
                                // Decode the role_status into an array of role IDs
                                $assignedRoles = explode(',', $holidayInfo->role_status);
                                ?>

                                <?php foreach($designation as $role): ?>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="role_<?php echo $role->roleId; ?>"
                                            name="role_ids[]" value="<?php echo $role->roleId; ?>" 
                                            <?php if(in_array($role->roleId, $assignedRoles)) echo 'checked'; ?>>
                                        <label class="custom-control-label" for="role_<?php echo $role->roleId; ?>"><?php echo $role->role; ?></label>
                                    </div>
                                <?php endforeach; ?>
                                
                                
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="reason">Reason</label>
                                    <textarea name="reason" class="form-control" id="reason" rows="3" required><?php echo $holidayInfo->reason; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <hr class="mt-1 mb-1">

                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button style="float:right" type="submit" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </div>
                </form> <!-- form end -->
            </div>
        </div> <!-- container end -->





</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/staff.js" charset="utf-8"></script>

<script type="text/javascript">

function GoBackWithRefresh(event) {

    if ('referrer' in document) {

        window.location = document.referrer;

        /* OR */

        //location.replace(document.referrer);

    } else {

        window.history.back();

    }

}



function isNumberKey(evt) {

    var charCode = (evt.which) ? evt.which : evt.keyCode;

    if (charCode != 46 && charCode > 31 &&

        (charCode < 48 || charCode > 57))

        return false;

    return true;

}



jQuery(document).ready(function() {





    $('select').selectpicker();

    jQuery('ul.pagination li a').click(function(e) {

        e.preventDefault();

        var link = jQuery(this).get(0).href;

        jQuery("#searchList").attr("action", link);

        jQuery("#searchList").submit();

    });



    jQuery('.resetFilters').click(function() {

        $(this).closest('form').find("input[type=text]").val("");

    })



    // Prepare the preview for profile picture

    $("#wizard-picture").change(function() {

        readURL(this);

    });



    jQuery('.holidayDateFrom,.holidayDateTo,.dateBy').datepicker({

        autoclose: true,

        format: "dd-mm-yyyy",



    });







});



function readURL(input) {

    if (input.files && input.files[0]) {

        var reader = new FileReader();

        reader.onload = function(e) {

            $('#uploadedImage').attr('src', e.target.result);

        }

        reader.readAsDataURL(input.files[0]);

    }

}

$("#vImg").change(function() {

    readURL(this);

});

</script>