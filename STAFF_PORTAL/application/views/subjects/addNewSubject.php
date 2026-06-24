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
<div class="row">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container container-fluid px-4 pt-1">
    <div class="content-wrapper">
        <section class="content-header">
            <div class="row mt-1">
                <div class="col">
                    <div class="card card-small p-0 card_heading_title">
                        <div class="card-body p-2 ml-2">
                            <span class="page-title absent_table_title_mobile">
                                <i class="material-icons">book</i> Add New Subject
                            </span>
                            <a onclick="showLoader();window.history.back();" class="btn primary_color mobile-btn float-right text-white"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- form start -->
        <form role="form" id="addSubject" action="<?php echo base_url() ?>addNewSubjectToDB" method="post" role="form"
            enctype="multipart/form-data">
            <!-- Default Light Table -->
            <div class="row form-employee">
                <div class="col-12">
                    <div class="card card-small c-border mb-4 ">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item p-2">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label  for="email ">Subject Name</label>
                                                <input type="text" class="form-control required" id="sub_name"
                                                    value="<?php echo set_value('sub_name'); ?>" name="sub_name"
                                                    maxlength="228" placeholder="Subject Name"
                                                    autocomplete="off" required/>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="mobile">Subject Code</label>
                                                <input type="text" class="form-control required"
                                                    id="sub_code" value="<?php echo set_value('sub_code'); ?>" name="sub_code"
                                                    placeholder="Subject Code" required autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="lab">Subject Lab Status</label>
                                                <select required class="form-control required selectpicker" id="lab_status" name="lab_status" required>
                                                    <option value="">Select Lab Status</option>
                                                    <option value="true">Yes</option>
                                                    <option value="false">No</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="role">Subject Type</label>
                                                <select required class="form-control required selectpicker" id="subject_type" name="subject_type" required>
                                                    <option value="">Select Subject Type</option>
                                                    <option value="LANGUAGE">LANGUAGE</option>
                                                    <option value="SCIENCE">SCIENCE</option>
                                                    <option value="COMMERCE">COMMERCE</option>
                                                    <option value="ARTS">ARTS</option>
                                                </select>
                                            </div>
                                        </div>
                                       
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="team_id">Select Department</label>
                                                <select required name="department" id="department" class="form-control required selectpicker" required data-live-search="true">
                                                    <option value="">Select Department</option>
                                                    <?php
                                                        if(!empty($departments))
                                                        {
                                                            foreach ($departments as $rl)
                                                            {
                                                                ?>
                                                                <option value="<?php echo $rl->dept_id ?>" <?php if($rl->id == set_value('role')) {echo "selected=selected";} ?>><?php echo $rl->name; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success"> Submit </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </form> <!-- form end -->
        <!-- End Default Light Table -->
    </div>
</div>
<!-- <script src="assets/js/subject/addNewSubject.js" type="text/javascript"></script> -->
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
    jQuery('.datepicker , .datepicker_doj').datepicker({
        autoclose: true,
        format : "dd-mm-yyyy",
        endDate : "today"
    });

  
});

</script>