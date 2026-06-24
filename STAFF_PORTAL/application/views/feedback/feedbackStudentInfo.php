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
    <div class="col-md-12 errorMessageDelete">
    </div>
</div>
<div class="main-content-container px-3 pt-1 overall_content">
    <div class="content-wrapper">
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class="col-lg-4 col-12 col-md-4 box-tools">
                                <span class="page-title">
                                    <i class="fa fa-users"></i> Enabled Student
                                </span>
                            </div>
                            <div class="col-lg-4 col-12 col-md-6 col-sm-6">
                                <b class="text-dark" style="font-size: 20px;">Total: <?php echo $count_students; ?></b>
                            </div>
                            <div class="col-lg-4 col-md-3 col-12">
                                <a onclick="window.history.back();" class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                <div class="dropdown mobile-btn float-right">
                                    <button type="button" class="btn btn-primary dropdown-toggle border_right_radius" data-toggle="dropdown">
                                        Action
                                    </button>
                                    <div class="dropdown-menu p-0">
                                        <a class="dropdown-item" href="#" id="multiple_delete_student"><i class="fa fa-trash"></i> Delete</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#feedbackModel"><i class="fa fa-plus"></i> Add</a>
                                        <div class="dropdown-divider m-0"></div>
                                    </div>
                                </div>
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
                            <form action="<?php echo base_url(); ?>getFeedbackStudentInfo" method="POST" id="byFilterMethod"  enctype="multipart/form-data">
                                <tr class="filter_row" class="text-center">
                                    <td></td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $student_id; ?>" name="student_id" id="student_id" class="form-control input-sm" placeholder="By Student ID" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $student_name; ?>" name="student_name" id="student_name" class="form-control input-sm" placeholder="Name" autocomplete="off">
                                        </div>
                                    </td>
                                    <td width="180">
                                        <div class="form-group mb-0">
                                            <select class="form-control" name="term_name" id="term_name">
                                                <?php if(!empty($term_name)){ ?>
                                                    <option value="<?php echo $term_name; ?>" selected><b>Selected: <?php echo $term_name; ?></b></option>
                                                <?php } ?>
                                                <option value="">Search Term</option>
                                                <option value="I PUC">I PUC</option>
                                                <option value="II PUC">II PUC</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td width="180">
                                        <div class="form-group mb-0">
                                            <select class="form-control" name="by_stream_name" id="by_stream_name">
                                                <?php if(!empty($by_stream_name)){ ?>
                                                    <option value="<?php echo $by_stream_name; ?>" selected><b>Selected: <?php echo $by_stream_name; ?></b></option>
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
                                            <select class="form-control" name="section_name" id="section_name">
                                                <?php if(!empty($section_name)){ ?>
                                                    <option value="<?php echo $section_name; ?>" selected><b>Selected: <?php echo $section_name; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Section</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                                <!-- <option value="E">E</option>
                                                <option value="F">F</option>
                                                <option value="G">G</option>
                                                <option value="H">H</option>
                                                <option value="I">I</option>
                                                <option value="K">K</option>
                                                <option value="L">L</option>
                                                <option value="M">M</option> -->
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <select class="form-control" name="feedback_type" id="feedback_type">
                                                <?php if(!empty($feedback_type)){ ?>
                                                    <option value="<?php echo $feedback_type; ?>" selected><b>Selected: <?php echo $feedback_type; ?></b></option>
                                                <?php } ?>
                                                <option value="">Search Term</option>
                                                <option value="TEACHING">TEACHING</option>
                                                <option value="COUNSELLOR">COUNSELLOR</option>
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
                                    <th width="25"><input type="checkbox" id="selectAll" /></th>
                                    <th width="140">Student ID</th>
                                    <th>Student Name</th>
                                    <th width="110">Term</th>
                                    <th width="110">Stream</th>
                                    <th width="110">Section</th>
                                    <th width="130">Feedback type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($studentRecords)){
                                    foreach($studentRecords as $std){ 
                                        $alumni_status = 0; ?>
                                    <tr>
                                        <th><input type="checkbox" class="singleSelect" value="<?php echo $std->row_id; ?>" /></th>
                                        <th class="text-center"><?php echo $std->student_id; ?></th>
                                        <th><?php echo strtoupper($std->student_name); ?></th>
                                        <th class="text-center"><?php echo $std->term_name; ?></th>
                                        <th class="text-center"><?php echo $std->stream_name; ?></th>
                                        <th class="text-center"><?php echo $std->section_name; ?></th>
                                        <th class="text-center"><?php echo $std->feedback_type; ?></th>
                                        <th class="text-center" width="140">
                                            <?php if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE){ ?>
                                                <!-- <a class="btn btn-xs btn-info" target="_blank"
                                                href="<?php echo base_url(); ?>editStudent/<?php echo $std->row_id; ?>" title="Edit Student"><i
                                                    class="fas fa-pencil-alt"></i></a> -->
                                             <?php } ?>
                                            <?php if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR){ ?>
                                                <a class="btn btn-xs btn-danger deleteStudentEnabled"
                                                data-row_id="<?php echo $std->row_id; ?>" href="#" title="Delete">
                                                <i class="fas fa-trash"></i></a>
                                            <?php } ?>
                                        </th>
                                    </tr>
                                <?php } }else{  ?>
                                <tr>
                                    <th colspan="8" class="text-center">Record Not Found</th>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="feedbackModel">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-primary" style="padding: 7px 15px;">
                <h4 class="modal-title">Enable Student For Feedback</h4>
                <button type="button" class="close float-right" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body p-2">
                <?php $this->load->helper("form"); ?>
                <form role="form" id="addStudent" action="<?php echo base_url() ?>addStudentForFeedback"
                    method="post" role="form">
                    <div class="row form-contents">
                        <div class="col-lg-12">
                            <div class="form-group mb-2">
                            <label> Select Student <span class="text-danger">*</span></label>
                            <select  class="form-control selectpicker" data-live-search="true" name="student_id" >
                                    
                                    <option value="">Select Student</option>
                                    <?php if(!empty($studentInfoSelection)){
                                        foreach($studentInfoSelection as $std){  ?>
                                        <?php $exists = $disableStudent->getStudentEnabledInfo($std->student_id,'TEACHING',$std->term_name,$std->section_name,$std->stream_name);
                                        $exist = $disableStudent->getStudentEnabledInfo($std->student_id,'COUNSELLOR',$std->student_id,'TEACHING',$std->term_name,$std->section_name,$std->stream_name);
                                        if($exists && $exist){?>
                                        <option value="<?php echo $std->student_id; ?>" disabled>
                                            <b><?php echo $std->student_id.' - '.$std->student_name.' - '.$std->term_name; ?></b></option>
                                        <?php } else{ ?>
                                            <option value="<?php echo $std->student_id; ?>" >
                                            <b><?php echo $std->student_id.' - '.$std->student_name.' - '.$std->term_name; ?></b></option>
                                        <?php }} } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-0">
                                <label>Type</label>
                                <select class="form-control text-dark" id="feedback_type" name="feedback_type">
                                    <option value="TEACHING">TEACHING</option>
                                    <option value="COUNSELLOR">COUNSELLOR</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer" style="padding: 7px 15px;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <input type="submit" form="addStudent" class="btn btn-success pull-right" value="Save" />
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "feedbackEnabledStudents/" + value);
        jQuery("#byFilterMethod").submit();
    });
   
    
    $(".custom_loader").hide();
    $("#custom_loader_text").css('display','none');

    jQuery('.datepicker, .dateSearch').datepicker({
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


    $('#multiple_delete_student').click(function() {
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student to delete!");
            return;
        } else {
            $('.singleSelect:checked').each(function(i) {
                students.push($(this).val());
            });
        }
        $.ajax({
            url: baseURL + '/deleteMultipleStudent',
            type: 'POST',
            data: {
                row_id : JSON.stringify(students),
            },
            success: function(data) {
                if (data > 0) {
                   
                    $('.errorMessageDelete').html(`<div class="alert alert-success" role="alert">
                  Selected Students Deleted successfully!
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>`);
                    location.reload();
                }
                setTimeout(function() {
                    location.reload();
                    //$('#shortListModelView').modal('hide');

                }, 2000);

            },
            error: function(result) {
                alert("Retry Again! Something Went Wrong");
            },
            fail: (function(status) {
                alert("Retry Again! Something Went Wrong");
            }),
            beforeSend: function(d) {
               // $('#alertMsg').html('<span>' + loader + '</span>');
            }
        });

    });

    jQuery(document).on("click", ".deleteStudentEnabled", function(){
        var row_id = $(this).data("row_id"),
            hitURL = baseURL + "deleteStudentEnabled",
            currentRow = $(this);

        var confirmation = confirm("Are you sure to delete this Student ?");

        if(confirmation)
        {
            jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : { row_id : row_id } 
            }).done(function(data){

                currentRow.parents('tr').remove();
                if(data.status = true) { alert("Student successfully deleted"); }
                else if(data.status = false) { alert("Student deletion failed"); }
                else { alert("Access denied..!"); }
            });
        }

    });

});
</script>