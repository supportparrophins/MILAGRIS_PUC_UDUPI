<?php require APPPATH . 'views/includes/db.php'; ?>
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
                            <div class="col-lg-4 col-12 col-md-4 box-tools">
                                <span class="page-title">
                                    <i class="fa fa-trash"></i> Deleted Students
                                </span>
                            </div>
                            <div class="col-lg-4 col-12 col-md-6 col-sm-6">
                                <b class="text-dark" style="font-size: 20px;">Total: <?php echo $totalCount; ?></b>
                            </div>
                            <div class="col-lg-4 col-md-3 col-12">
                                <a onclick="window.history.back();" class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                <div class="dropdown mobile-btn float-right">
                                    <!-- <button type="button" class="btn btn-primary dropdown-toggle border_right_radius" data-toggle="dropdown">
                                        Action
                                    </button> -->
                                    <div class="dropdown-menu p-0">
                                        <a class="dropdown-item" onclick="showLoader();" href="<?php echo base_url(); ?>addNewStudent"><i class="fa fa-plus"></i> Add New</a>
                                            <div class="dropdown-divider m-0"></div>
                                        <!-- <a class="dropdown-item disabled" href="#"><i class="fa fa-mobile"></i> Send SMS</a>
                                        <div class="dropdown-divider m-0"></div> -->
                                        <!-- <a class="dropdown-item" href="#" id="study_certificate"><i class="fa fa-file"></i> Study Certificate</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="dropdown-item" href="#" id="conduct_certificate"><i class="fa fa-file"></i> Conduct Certificate</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="dropdown-item" href="#" id="mark_card_print"><i class="fa fa-file"></i> Mark Card</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="dropdown-item" href="#" id="excellencia_cetificate"><i class="fa fa-file"></i>Excellencia Certificate</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="dropdown-item" href="#" id="first_year_hall_ticket"><i class="fa fa-file"></i> Hall ticket</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="dropdown-item" href="#" id="second_year_hall_ticket"><i class="fa fa-file"></i> Lab Hall ticket</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="dropdown-item" href="#" id="biodata_student"><i class="fa fa-file"></i> Bio-Data</a>
                                        <div class="dropdown-divider m-0"></div> -->
                                        
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#downloadReport" class="btn btn-md btn-primary">
                                        <i class="fa fa-download"></i> Export</a>
                                        <!-- <a class="dropdown-item" href="#" id="study_certificate"><i class="fa fa-file"></i> Study Certificate</a> -->
                                        <!-- <a id="studentBatchModel" class="dropdown-item " href="#"><i class="fa fa-user"></i> Add Batch</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="dropdown-item" href="#" id="unit_test_mark_card"><i class="fa fa-file"></i> Unit Test Mark Card</a>
                                        <div class="dropdown-divider m-0"></div> -->
                                        
                                        <a class="dropdown-item" href="#" id="assign_feedback"><i class="fa fa-file"></i> Assign Student For Feedback</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <!-- <a class="dropdown-item" href="#" id="promoteStudent"><i class="fa fa-file"></i>Promote Student</a>
                                        <div class="dropdown-divider m-0"></div> -->
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
                            <form action="<?php echo base_url(); ?>viewDeletedStudents" method="POST" id="byFilterMethod"  enctype="multipart/form-data">
                                <tr class="filter_row" class="text-center">
                                    <td></td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $student_id; ?>" name="student_id" id="student_id" class="form-control input-sm" placeholder="By Student ID" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $application_no; ?>" name="application_no" id="application_no" class="form-control input-sm" placeholder="By Application Number" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $by_name; ?>" name="by_name" id="by_name" class="form-control input-sm" placeholder="Name" autocomplete="off">
                                        </div>
                                    </td>
                                    <td width="180">
                                        <div class="form-group mb-0">
                                            <select class="form-control" name="by_term" id="by_term">
                                                <?php if(!empty($by_term)){ ?>
                                                    <option value="<?php echo $by_term; ?>" selected><b>Selected: <?php echo $by_term; ?></b></option>
                                                <?php } ?>
                                                <option value="">Search Term</option>
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
                                                <option value="J">J</option>
                                                <option value="K">K</option>
                                                <option value="L">L</option>
                                                <option value="M">M</option>
                                                <option value="N">N</option>
                                                <option value="O">O</option>
                                                <option value="P">P</option>
                                                <option value="Q">Q</option>
                                                <option value="R">R</option>
                                                <option value="S">S</option> -->
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
                                    <th width="140">Appln. No.</th>
                                    <th width="160">Student Name</th>
                                    <th width="50">Term</th>
                                    <th width="110">Stream</th>
                                    <th width="90">Section</th>
                                    <!-- <th>Fee Status</th> -->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($studentInfo)){
                                    foreach($studentInfo as $std){ 
                                        if($std->term_name == 'I PUC'){
                                            $stdFee = getFirstYearFeeInfo($con,$std->student_id);
                                            if(empty($stdFee)){
                                                $fee_status = '<span class="text-success">Paid</span>';
                                            }else if($stdFee['balance'] == 0){
                                                $fee_status = '<span class="text-success">Paid</span>';
                                            }else{
                                                $fee_status = '<span class="text-danger">'.$stdFee['balance'].'</span>';
                                            }
                                        }else{
                                            $std_status = getSecondYearFeeInfo($con,$std->student_id);
                                            if(empty($std_status)){
                                                $fee_status = '<span class="text-success">Paid</span>';
                                            }else if($std_status['balance'] == 0){
                                                $fee_status = '<span class="text-success">Paid</span>';
                                            }else{
                                                $fee_status = '<span class="text-danger">'.$std_status['balance'].'</span>';
                                            }
                                        }
                                    ?>
                                    <tr>
                                        <th><input type="checkbox" class="singleSelect" value="<?php echo $std->student_id; ?>" /></th>
                                        <th class="text-center"><?php echo $std->student_id; ?></th>
                                        <th class="text-center"><?php echo $std->application_no; ?></th>
                                        <th><?php echo strtoupper($std->student_name); ?></th>
                                        <th class="text-center"><?php echo $std->term_name; ?></th>
                                        <th class="text-center"><?php echo $std->stream_name; ?></th>
                                        <th class="text-center"><?php echo $std->section_name; ?></th>
                                        <!-- <th class="text-center"><?php echo $fee_status; ?></th> -->
                                        <th class="text-center" width="140">
                                            <a class="btn btn-xs btn-primary mb-1" target="_blank"
                                            href="<?php echo base_url(); ?>viewStudentInfoById/<?php echo $std->row_id; ?>"
                                            title="View More"><i class="fa fa-eye"></i></a>
                                            <?php //if($role == ROLE_ADMIN || $role == ROLE_SUPER_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE){ ?>
                                                <?php if($accessInfo->edit_student == '1'){ ?>
                                                <a class="btn btn-xs btn-info mb-1" target="_blank"
                                                href="<?php echo base_url(); ?>editStudent/<?php echo $std->row_id; ?>" title="Edit Student"><i
                                                    class="fas fa-pencil-alt"></i></a>
                                                 <!-- <a class="btn btn-xs btn-danger inactiveStudent mb-1" href="#" data-row_id="<?php echo $std->row_id; ?>" title="Inactive"><i class="fa fa-times"></i></a> -->
                                             <?php } ?>
                                            <!-- <?php if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR){ ?>
                                                <a class="btn btn-xs btn-danger deleteStudent mb-1"
                                                data-row_id="<?php echo $std->application_no; ?>" href="#" title="Delete">
                                                <i class="fas fa-trash"></i></a>
                                            <?php } ?> -->
                                            <!-- <?php if($role != ROLE_TEACHING_STAFF) { ?>
                                                <a onclick="openModel('<?php echo $std->student_id; ?>')" class="btn btn-xs btn-warning" style="color: white;" 
                                                title="Give Transfer Certificate"><i class="fa fa-file"></i> Give TC</a>
                                            <?php } ?> -->
                                                                
                                           
                                        </th>
                                    </tr>
                                <?php } }else{  ?>
                                <tr>
                                    <th colspan="8" class="text-center">Student Record Not Found</th>
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





<script src="<?php echo base_url(); ?>assets/js/student.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
 var students = [];
 var loader = '<img height="70" src="<?php echo base_url(); ?>assets/images/loader.gif"/>';
    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "viewDeletedStudents/" + value);
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

    $('#excellencia_cetificate').click(function(){
      var students = [];
      if ($('.singleSelect:checkbox:checked').length == 0) {
        alert("Select atleast one Student for Print Excellence Certificate!"); 
        return;
     }
     $('.singleSelect:checked').each(function(i){
          students.push($(this).val());
        });
        var students = JSON.stringify(students);
        
        window.open('<?php echo base_url(); ?>generateExcellenciaCertificate?student_id='+btoa(students));
    });
    
    $('#study_certificate').click(function(){
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for Print Study Certificate!"); 
            return;
        }
        $('.singleSelect:checked').each(function(i){
            students.push($(this).val());
        });
        var students = JSON.stringify(students);
        window.open('<?php echo base_url(); ?>generateStudyCertificate?student_id='+btoa(students));
    });
    
    //conduct certificate
    $('#conduct_certificate').click(function(){
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for Print Conduct Certificate!"); 
            return;
        }
        $('.singleSelect:checked').each(function(i){
            students.push($(this).val());
        });
        var students = JSON.stringify(students);
        window.open('<?php echo base_url(); ?>generateConductCertificate?student_id='+btoa(students));
    }); 
    
    // student batch 
    $('#studentBatchModel').click(function() {
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student!");
            return;
        } else {
            $('#studentBatchModelView').modal('show');
        }
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        $('#countStudents').html($('.singleSelect:checkbox:checked').length);
    });

    
    $('#updateStudentBatchInfo').click(function() {
        var class_batch = $("#batch_selected").val();
        var students = [];
        
        //$('#alertMsg').html('<span>' + loader + '</span>');
        //$('#shortListModelView').modal('show');
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        $.ajax({
            url: baseURL + '/updateStudentBatch',
            type: 'POST',
            data: {
                student_id : JSON.stringify(students),
                class_batch : class_batch,
            },
            success: function(data) {
                if (data > 0) {
                   
                    $('#alertMsg').html(`<div class="alert alert-success" role="alert">
                  Selected Students Batch updated successfully!
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>`);
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

//print mark card for students
    $('#mark_card_print').click(function() {
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for print Mark Card!");
            return;
        } else {
            $('#printMarkCardOption').modal('show');
        }
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        $('#countStudentsForMarkCard').html($('.singleSelect:checkbox:checked').length);
    });


    $('#printMarkSheet').click(function(){
        var students = [];
        var exam_year = $('#exam_year').val();
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for Print Mark Card!"); 
            return;
        }
        $('.singleSelect:checked').each(function(i){
            students.push($(this).val());
        });
        var students = JSON.stringify(students);
        if (exam_year == "") {
            $(".errorMessage").html(`<div class="alert alert-danger" role="alert">
                  Please Select Examination Year!
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </div>`);
            return;
        }else if(exam_year == 'FEBRUARY - 2022_D'){
          window.open('<?php echo base_url(); ?>getAnnualMarkCardToPrint?student_id='+btoa(students) + '&exam_year=' + exam_year);
        }else if(exam_year == 'annual_exam'){
          window.open('<?php echo base_url(); ?>getAnnualMarkCardToPrint2022?student_id='+btoa(students) + '&exam_year=' + exam_year);
         }else if(exam_year == 'supplementary_exam'){
          window.open('<?php echo base_url(); ?>getSupplementaryMarkPrint2022?student_id='+btoa(students) + '&exam_year=' + exam_year);
        }else{
          window.open('<?php echo base_url(); ?>getMarkCardToPrint?student_id='+btoa(students) + '&exam_year=' + exam_year);
        }
    });

    //hall ticket 
    $('#first_year_hall_ticket').click(function() {
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for print Hall Ticket!");
            return;
        }
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        var students = JSON.stringify(students);
        window.open('<?php echo base_url(); ?>getFirstYearStudentHallTicket?student_id=' + btoa(students));
    });

    $('#second_year_hall_ticket').click(function() {
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for print Hall Ticket!");
            return;
        }
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        var students = JSON.stringify(students);

        window.open('<?php echo base_url(); ?>getSecondYearStudentHallTicket?student_id=' + btoa(students));
    });

    $('#biodata_student').click(function() {
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for Print Bio-Data!");
            return;
        }
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        var students = JSON.stringify(students);

        window.open('<?php echo base_url(); ?>getStudentBiodata?student_id=' + btoa(students));
    });

    // // unit test mark card
    // $('#unit_test_mark_card').click(function(){
    //     var students = [];
    //     if ($('.singleSelect:checkbox:checked').length == 0) {
    //         alert("Select atleast one Student for Print Mark Card!"); 
    //         return;
    //     }
    //     $('.singleSelect:checked').each(function(i){
    //         students.push($(this).val());
    //     });
    //     var students = JSON.stringify(students);
    // }); 
    
    $('#unit_test_mark_card').click(function() {
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for print Mark Card!");
            return;
        } else {
            $('#printReportCardByName').modal('show');
        }
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        $('#countStudentsForMarksCard').html($('.singleSelect:checkbox:checked').length);
    });


    $('#printUnitTestMarkCard').click(function(){
        var students = [];
        var exam_type = $('#exam_type').val();
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for Print Mark Card!"); 
            return;
        }
        $('.singleSelect:checked').each(function(i){
            students.push($(this).val());
        });
        var students = JSON.stringify(students);
        if (exam_type == "") {
            $(".errorMessage").html(`<div class="alert alert-danger" role="alert">
                  Please Select Examination Name!
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </div>`);
            return;
        }else if(exam_type == "MID_TERM") {
          window.open('<?php echo base_url(); ?>generateMidTermExamReportCard?student_id='+btoa(students) + '&exam_type=' + exam_type);
         }else if(exam_type == "I_PREPARATORY") {
          window.open('<?php echo base_url(); ?>generatePreparatoryExamReportCard?student_id='+btoa(students) + '&exam_type=' + exam_type);
        }
        else{
          window.open('<?php echo base_url(); ?>generateUnitTestExamReportCard?student_id='+btoa(students) + '&exam_type=' + exam_type);
        }
    });

     $('#promoteStudent').click(function() {
        
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student to Promote!");
            return;
        } else {
            
            // alert(students.length);
            $('#promoteStudents').modal('show');
              $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
          
             // students = JSON.stringify(students);

        });
            $('#students').val(JSON.stringify(students));
            // alert($('#students').val());
        }
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
           
            //  students = JSON.stringify(students);

        });
        $('#studentPromoteCount').html($('.singleSelect:checkbox:checked').length);
    });


     $('#promoteStudent').click(function() {

         students = [];
         
        if (msg.length == 0) {
            $('#alertMsg').html(`<div class="alert alert-danger" role="alert">
                Sorry! Confirmation SMS Empty!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>`);
        } else {
            $('#alertMsg').html('<span>' + loader + '</span>');
            //$('#shortListModelView').modal('show');
            $('.singleSelect:checked').each(function(i) {
                studentList.push($(this).val());

                 
            });
               
            $.ajax({
                url: baseURL + '/promoteStudent',
                type: 'POST',
                data: {

                    student_id: JSON.stringify(students),
                },
                success: function(data) {
                    $('#alertMsg').html(`<div class="alert alert-success" role="alert">
                    Promoted Successfully!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                  </div>`);
                },
                error: function(result) {
                    alert("Retry Again! Something Went Wrong");
                },
                fail: (function(status) {
                    alert("Retry Again! Something Went Wrong");
                }),
                beforeSend: function(d) {
                    $('#alertMsg').html('<span>' + loader + '</span>');
                }
            });
        }
    });
    
    // assign student for feedback
    $('#assign_feedback').click(function() {
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student for print Mark Card!");
            return;
        } else {
            $('#assignStudentForFeedback').modal('show');
        }
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        $('#countStdFeedback').html($('.singleSelect:checkbox:checked').length);
    });
    
    $('#assignStudentDataForFeedback').click(function() {
        var feedback_type = $('#feedback_type').val();
        var students = [];
        
        //$('#alertMsg').html('<span>' + loader + '</span>');
        //$('#shortListModelView').modal('show');
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        $.ajax({
            url: baseURL + '/addMultipleStudentForFeedback',
            type: 'POST',
            data: {
                student_id : JSON.stringify(students),
                feedback_type : feedback_type,
            },
            success: function(data) {
                if (data > 0) {
                   
                    $('.errorMessageFeedback').html(`<div class="alert alert-success" role="alert">
                  Selected Students assigned successfully!
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>`);
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
    
 
    

    $("#saveTcInfo").click(function(){
          
        var qualified_status = $('#qualified_status :selected').val();
        var reason_unqualified = $('#reason_unqualified_val :selected').val();
        var belong_sc_st = $('#belong_sc_st :selected').val();
        /// var college_due_status = $('#college_due_status :selected').val();
        var character = $('#character :selected').val();
        var leaving_date = $('#leaving_date').val();
        var last_studied = $('#last_studied').val();
        var admission_date = $('#date_of_admission').val();
        var student_id = $('#student_id').val();
        var caste = $('#caste').val();
        if(leaving_date == ""){ 
            $(".alertMessage").html('<div class="alert alert-warning alert-dismissable">Sorry! Leaving date Empty!</div>');
            $(".alertMessage").show();
        }else{
            $.ajax({
                url: '<?php echo base_url(); ?>/addNewTcInfo',
                type: 'POST',
                data: {
                    qualified_status: qualified_status,
                    reason_unqualified: reason_unqualified,
                    belong_sc_st: belong_sc_st,
                    last_studied : last_studied,
                    character: character,
                    leaving_date: leaving_date,
                    student_id : student_id,
                    admission_date : admission_date,
                    caste : caste,
                },

                success: function(data) {
                    $(".alertMessage").html('<div class="alert alert-success alert-dismissable">'+data+
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>');
                    $(".alertMessage").show();
                },
                error: function(result){
                    $(".alertMessage").html('<div class="alert alert-danger alert-dismissable">Error! Something Went Wrong</div>');
                    $(".alertMessage").show();
                },
                fail:(function(status) {
                    $(".alertMessage").html('<div class="alert alert-danger alert-dismissable">Error! Something Went Wrong</div>');
                    $(".alertMessage").show();
                }),
                beforeSend:function(d){
                    // $('.modal-title').html('<center> Loading..</center>');
                }
            });
        }
    });

    $('#leaving_date, .datepicker').datepicker({
        autoclose: true,
        format : "dd-mm-yyyy"
    });
});

function openModel(student_id){
    $(".alertMessage").hide();
    $('.modal-title').html('Transfer Certificate <span style="float:right;">Student ID: '+ student_id + '</span>');
    $.ajax({
        url: '<?php echo base_url(); ?>/getStudentTcInfo',
        type: 'POST',
        data: {
            student_id : student_id,
        },

        success: function(data) {
            var studentTcInfo = JSON.parse(data);
            
            if(studentTcInfo != null){
            var leavingDate = studentTcInfo.leaving_date
            $('#leaving_date').val(appendLeadingZeroes(new Date(leavingDate).getDate()) 
            + "-" + appendLeadingZeroes(new Date(leavingDate).getMonth() + 1) 
            + "-" + appendLeadingZeroes(new Date(leavingDate).getFullYear()));
            // $('#leaving_date').val(studentTcInfo.leaving_date);
            $('#qualified_status').val(studentTcInfo.is_promoted);
            $('#belong_sc_st').val(studentTcInfo.is_belongs_sc_st);
            $('#last_studied').val(studentTcInfo.last_studied);
            $('#character').val(studentTcInfo.character_conduct);
            if(studentTcInfo.reason_unqualified != ""){
                $('#reason_unqualified_val').val(studentTcInfo.reason_unqualified);
                $(".reason_unqualified").show();
            }else{
                $('#reason_unqualified_val').val(studentTcInfo.reason_unqualified);
                $(".reason_unqualified").hide();
            }
            $("#saveTcInfo").text("Update");
            }else{
            $("#saveTcInfo").text("Save");
            $(".reason_unqualified").hide();
            $('#addTcList')[0].reset();
            }
        },
        error: function(result)
            {
                $(".modal-title").html("Error");
            },
            fail:(function(status) {
                $(".modal-title").html("Fail");
            }),
            beforeSend:function(d){
                // $('.modal-title').html('<center> Loading..</center>');
            }
    });
    $.ajax({
        url: '<?php echo base_url(); ?>/getStudentById',
        type: 'POST',

        data: {
            student_id : student_id,
        },

        success: function(data) {
            var studentInfo = JSON.parse(data);
            var admissionDate = studentInfo.date_of_admission;
            $('#student_id').val(student_id);
            $('#stdName').html(studentInfo.student_name);
            $('#studentName').html(studentInfo.student_name);
            $('#dob').html(studentInfo.dob);
            $('#section').html(studentInfo.section_name);
            $('#nationality').html(studentInfo.nationality);
            $('#father_name').html(studentInfo.father_name);
            $('#mother_name').html(studentInfo.mother_name);

            $('#religion').html(studentInfo.religion);
            $('#caste').val(studentInfo.caste);
            $('#languages').html(studentInfo.elective_sub);

            $('#admission_date').html(appendLeadingZeroes(new Date(admissionDate).getDate()) 
            + "-" + appendLeadingZeroes(new Date(admissionDate).getMonth() + 1) 
            + "-" + appendLeadingZeroes(new Date(admissionDate).getFullYear()));
            // $('#admission_date').html(studentInfo.date_of_admission);


            var admission = appendLeadingZeroes(new Date(admissionDate).getDate()) 
            + "-" + appendLeadingZeroes(new Date(admissionDate).getMonth() + 1) 
            + "-" + appendLeadingZeroes(new Date(admissionDate).getFullYear());

            if(admissionDate != ''){
                $('#date_of_admission').val(admission);
            }

            $('#instruction_medium').html("English");
            $('#optionals').html(studentInfo.stream_name);
            // if(studentInfo.date_of_admission == ""){
            // alert("Please Upadte Admission Date!");
            // return;
            // }
            $('#tcModel').modal('show');
        },
        error: function(result)
            {
                $(".modal-title").html("Error");
            },
            fail:(function(status) {
                $(".modal-title").html("Fail");
            }),
            beforeSend:function(d){
                // $('.modal-title').html('<center> Loading..</center>');
            }
    });
    
}   
    
function appendLeadingZeroes(n) {
    if (n <= 9) {
        return "0" + n;
    }
    return n;
}
</script>


<?php
    function getFirstYearFeeInfo($con,$student_id){
        $query = "SELECT * FROM tbl_fee_pending_info_2021 as fee 
        WHERE fee.student_id = '$student_id'";
        $pdo_statement = $con->prepare($query);
        $pdo_statement->execute();
        return $pdo_statement->fetch();
    }

    
    function getSecondYearFeeInfo($con,$student_id){
        $query = "SELECT * FROM tbl_fee_pending_ii_2021 as fee 
        WHERE fee.student_id = '$student_id'";
        $pdo_statement = $con->prepare($query);
        $pdo_statement->execute();
        return $pdo_statement->fetch();
    }
?>