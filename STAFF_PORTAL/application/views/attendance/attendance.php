

<?php
$this->load->helper('form');
$error = $this->session->flashdata('error');
if ($error) { ?>
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
if ($success) {  ?>
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
    <?php if($_SESSION['loggedIn_type']!='Mobile'){ ?>
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class="col-lg-4 col-12 col-md-4 col-sm-4 box-tools">
                                <span class="page-title">
                                    <i class="material-icons">format_list_bulleted</i> Attendance
                                </span>
                            </div>
                            <div class="col-lg-4 col-6 col-md-4 col-sm-4">
                                <!-- <form action="<?php //echo base_url() ?>getAttendanceDetails" method="POST" id="byFilterMethod">
                                    <div class="input-group">
                                        <input type="text" name="attendance_date" value="<?php //echo $attendance_date ?>"
                                            class="form-control input-md py-1" id="dateSearch" style="text-transform: uppercase"
                                            placeholder="Search by Attendance Date" autocomplete="off" />
                                        <div class="input-group-btn">
                                            <button class="btn btn-md btn-primary searchList"><i
                                                    class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form> -->
                            </div>
                            <div class="col-lg-4 col-md-4 col-6 col-sm-4">
                                <a onclick="window.history.back();" class="btn primary_color mobile-btn float-right text-white"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2">
                        <div class="card text-dark mb-3" style="background-color: #7bd78fa8;">
                            <b class="mb-0 text-dark px-2" style="font-size: 18px;">Custom Attendance</b>
                            <hr class="my-0 mx-2">
                            <form method="POST" role="form" action="<?php echo base_url(); ?>getStudentInfoForAttendance">
                                <div class="card-body p-2">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                    <div class="form-group mb-0">
                                                        <label>Subject</label>
                                                        <select class="form-control" id="staff_subject_row_id" name="staff_subject_row_id" required>
                                                            <option value="">Select Subject</option>
                                                                <?php if(!empty($staffSubjectInfo)){
                                                                foreach($staffSubjectInfo as $staff){ 
                                                                    if($staff_id == $staff->staff_id){  ?>
                                                                        <option value="<?php echo $staff->row_id ?>">
                                                                            <?php echo $staff->sub_name.' - '.$staff->subject_type ?>
                                                                        </option>
                                                                    <?php } else { ?>
                                                                        <option value="<?php echo $staff->row_id ?>">
                                                                            <?php echo $staff->sub_name.' - '.$staff->subject_type.' - '.$staff->staff_name; ?>
                                                                        </option>
                                                            <?php } }  } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                    <div class="form-group mb-0">
                                                        <label>Term & Stream</label>
                                                        <select class="form-control form-control-sm" id="section_row_id" name="section_row_id" required>
                                                            <option value="">Select Term & Stream</option>
                                                                <?php if(!empty($streamSectionInfo)){
                                                                foreach($streamSectionInfo as $stream){ ?>
                                                                <option value="<?php echo $stream->row_id; ?>">
                                                                    <?php echo $stream->term_name.' - '.$stream->stream_name.' - '.$stream->section_name ?>
                                                                </option>
                                                            <?php }  } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                    <div class="form-group mb-0">
                                                        <label>Date</label>
                                                        <input id="attendance_date" type="text" value="<?php echo date('d-m-Y') ?>" name="attendance_date" class="form-control form-control-sm datepicker"
                                                        placeholder="Attendance Date" autocomplete="off" required readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="m-1" style="border-top: 1px solid #3c8dbc;">
                                            <div class="row">
                                                <div class="col-lg-4 col-sm-4 col-md-4 col-12">
                                                    <div class="form-group mb-0">
                                                        <label>Class Time</label>
                                                        <select class="form-control form-control-sm" id="time_row_id" name="time_row_id" required>
                                                            <option value="">Select Class Timings</option>
                                                            <?php if(!empty($timingsInfo)){
                                                                foreach($timingsInfo as $time){ ?>
                                                                <option value="<?php echo $time->row_id; ?>">
                                                                    <?php echo $time->start_time.'-'.$time->end_time; ?>
                                                                </option>
                                                            <?php }  } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-sm-4 col-md-4 col-12">
                                                    <div class="form-group mb-0" id="student_batch">
                                                        <label>Batch</label>
                                                        <select class="form-control form-control-sm" id="class_batch" name="class_batch">
                                                            <option value="">Select Batch</option>
                                                            <option value="B1">B1</option>
                                                            <option value="B2">B2</option>
                                                            <option value="B3">B3</option>
                                                            <option value="B4">B4</option>
                                                            <option value="C1">C1</option>
                                                            <option value="C2">C2</option>
                                                            <option value="C3">C3</option>
                                                            <option value="C4">C4</option>
                                                            <option value="C5">C5</option>
                                                            <option value="C6">C6</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-sm-4 col-md-4 col-12">
                                                </div>
                                                <div class="col-lg-2 col-sm-4 col-md-4 col-12">
                                                    <?php if($role == ROLE_PRINCIPAL || $role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_TEACHING_STAFF || $role == ROLE_OFFICE || $role == ROLE_VICE_PRINCIPAL || $role == ROLE_SUPER_ADMIN) { ?>
                                                        <button type="submit" class="btn btn-block btn-sm btn-primary btn_send pull-right"> Take Attendance</button>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body p-1 pb-2">
                        <?php if(!empty($attendanceInfo)){
                            // foreach($attendanceInfo as $record){ 
                            //     $classAddedStatus = 0;
                            //     if(!empty($classCompletedInfo)){
                            //         foreach($classCompletedInfo as $class) {
                            //             $absent_date = date('d-m-Y',strtotime($class->date));
                            //             if($class->stream_name == $record->stream_name && $class->section_name == $record->section_name && $class->term_name == $record->term_name && $class->time_id == $record->time_row_id && $class->subject_code == $record->subject_code && $absent_date == $attendanceDate){
                            //                 $classAddedStatus = 1;
                            //                 break;
                            //             }
                            //         }
                            //     } ?>
                            <!-- <div class="card text-dark mb-3" style="background-color: #7bd78fa8;">
                                <form method="POST" role="form" action="<?php echo base_url(); ?>getStudentInfoForAttendance">
                                    <input type="hidden" name="term_name" value="<?php echo $record->term_name; ?>" />
                                    <input type="hidden" name="stream_name" value="<?php echo $record->stream_name; ?>" />
                                    <input type="hidden" name="subject_name" value="<?php echo $record->sub_name; ?>" />
                                    <input type="hidden" name="attendance_date" value="<?php echo $attendanceDate; ?>" />
                                    <input type="hidden" name="section_name" value="<?php echo $record->section_name; ?>" />
                                    <input type="hidden" name="time_row_id" value="<?php echo $record->time_row_id; ?>" />
                                    <input type="hidden" name="section_row_id" value="<?php echo $record->section_info_row_id; ?>" />
                                    <input type="hidden" name="staff_subject_row_id" value="<?php echo $record->staff_subjects_row_id; ?>" />
                                    <input type="hidden" name="subject_code" value="<?php echo $record->subject_code; ?>" />
                                    <div class="card-body p-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                                                        <label>Subject : <span style="color: #14069b;"><?php echo $record->sub_name; ?></span></label>
                                                    </div>
                                                    <div class="col-lg-4 col-md-3 col-sm-6 col-6">
                                                        <label>Term & Stream : <span style="color: #14069b;"><?php echo $record->term_name.' '.$record->stream_name; ?></span></label>
                                                    </div>
                                                    <div class="col-lg-2 col-md-3 col-sm-6 col-6">
                                                        <label>Section : <span style="color: #14069b;"><?php echo $record->section_name; ?></span></label>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                                                        <label>Date : <span style="color: #14069b;"><?php echo $attendanceDate; ?></span></label>
                                                    </div>
                                                </div>
                                                <hr class="m-1" style="border-top: 1px solid #3c8dbc;">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-4 col-6">
                                                        <label>Subject Type : <span style="color: #14069b;"><?php echo $record->subject_type; ?></span></label>
                                                    </div>
                                                    <div class="col-lg-7 col-sm-4 col-6">
                                                        <label>Class Time : <span style="color: #14069b;"><?php echo $record->start_time.' - '.$record->end_time; ?></span></label>
                                                    </div>
                                                    <div class="col-lg-2 col-sm-4 col-xs-3"> -->
                                                        <?php 
                                                        // if($role == ROLE_PRINCIPAL || $role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_TEACHING_STAFF) { 
                                                        //     if($classAddedStatus == 1){ ?>
                                                                <!-- <button type="submit" class="btn btn-block btn-sm primary_color"  title="Take Attendance"> Update Attendance</button> -->
                                                            <?php 
                                                        // }else{
                                                             ?>
                                                                <!-- <button type="submit" class="btn btn-block btn-sm btn-primary btn_send pull-right"> Take Attendance</button> -->
                                                        <!-- <?php 
                                                    // } } 
                                                    ?> -->
                                                    <!-- </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div> -->
                        <?php 
                    // } }else{ ?>
                            <!-- <div class="card" style="background-color: #e3cfff;">
                                <div class="card-body text-dark" style="padding: 8px;">
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <label>Class Not Found.</label>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        <?php } ?>
                    </div>
                    <div class="card-footer p-1">
                        <span class="float-right"><?php echo $this->pagination->create_links(); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>

<script type="text/javascript">
jQuery(document).ready(function() {
    $("#student_batch").hide();

    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "getAttendanceDetails/" + value);
        jQuery("#byFilterMethod").submit();
    });

    $("#staff_subject_row_id").change(function(){
        var staff_subject_row_id = $("#staff_subject_row_id").val();
        // alert(staff_subject_row_id);
        $.ajax({
            url: '<?php echo base_url(); ?>/getAssignedSubjectAttendance',
            type: 'POST',
            dataType: "json",
            data: { staff_subject_row_id : staff_subject_row_id },

            success: function(data) {
                //var examObject = JSON.parse(data);
                var examObject = JSON.stringify(data)
                var count = data.result.length;
                if(data.result.subject_type == 'LAB'){
                    $("#student_batch").show();
                    $("#class_batch").prop('required',true);
                }else{
                    $("#student_batch").hide();
                    $("#class_batch").prop('required',false);
                }
            }
        });
    });

    var endYear = new Date(new Date().getFullYear('Y')+1, 11, 31);
    jQuery('.datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        dateFormat: "dd-mm-yy",
        maxDate : 0,
        startDate : "01-03-2020",

    });
    jQuery('#dateSearch').datepicker({
        autoclose: true,
        orientation: "bottom",
        dateFormat: "dd-mm-yy",
        maxDate : 0,
        startDate : "01-03-2020",
    });

});
</script>
