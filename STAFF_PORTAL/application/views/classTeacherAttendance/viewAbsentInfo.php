<style>

input[type=checkbox] {

    cursor: pointer;

    font-size: 10px;

    -moz-appearance: initial;

    visibility: hidden;

    position: relative;

    top: 0;

    left: 0;

    transform: scale(1.1);

}



input[type=checkbox]:after {

    content: " ";

    background-color: #fff;

    display: inline-block;

    color: red;

    width: 10px;

    height: 10px;

    visibility: visible;

    border: 1px solid #3c8dbc;

    padding: 2px;

    margin: 1px 0;

    border-radius: 1px;

    box-shadow: 0 0 15px 0 rgba(0, 0, 0, 0.08), 0 0 2px 0 rgba(0, 0, 0, 0.16);

}



input[type=checkbox]:checked:after {

    content: "\2714";

    display: unset;

    font-weight: bold;

    width: 10px;

    height: 10px;

    padding: 2px

}

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

.margin10{
    margin-right:150px;
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

                            <div class="col-7 col-md-5 col-lg-4 col-sm-5 box-tools">

                                <span class="page-title">

                                    <i class="material-icons">description</i> Attendance Management

                                </span>

                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-3 col-4">

                                <div class="count_heading text-dark" style="font-size: 20px;">Total: <?php echo $count_attendance; ?></div>

                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-4 col-12">
                                <form action="<?=base_url() ?>getClassTeacherAbsentDetails" method="POST" id="byFilterMethod">
                                    <div class="d-flex">
                                        <input class="form-control datepicker" type="text" name="date_from" value="<?php if(!empty($date_from)) echo date('d-m-Y', strtotime($date_from)); ?>" style="text-transform: uppercase" placeholder="Date From" autocomplete="off">
                                        <input class="form-control datepicker ml-1" type="text" name="date_to" value="<?php if(!empty($date_to)) echo date('d-m-Y', strtotime($date_to)); ?>" style="text-transform: uppercase" placeholder="Date To" autocomplete="off">
                                        <button type="submit" class="btn btn-success ml-1">Search</button>
                                    </div>
                                <!-- </form> -->
                            </div>

                            <div class="col-lg-3 col-md-12 col-12">
                            <a onclick="window.history.back();"
                                    class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                    <?php if($role == ROLE_ADMIN || $role == ROLE_DIRECTOR || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_TEACHING_STAFF || $role == ROLE_SUPER_ADMIN || !empty($isStaffClassTeacher) || $role == ROLE_ACADEMIC_INCHARGE || $staffID == 'LCS100' || $staffID == 'LCS87' || $staffID == 'LCS101'){ ?>
                                        <div class="dropdown mobile-btn float-right ml-4">
                                            <button type="button" class="btn btn-primary dropdown-toggle border_right_radius" data-toggle="dropdown">
                                                Action
                                            </button>
                                            <div class="dropdown-menu margin10">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#downloadAttReport">
                                                <i class="fa fa-download"></i> Absent Report</a>
                                                <div class="dropdown-divider m-0"></div>
                                                <a class="dropdown-item" data-toggle="modal" data-target="#downloadClassReport" href="#">
                                                <i class="fa fa-download"></i> Class Completed Report</a>
                                                <div class="dropdown-divider m-0"></div>
                                                <!-- <a class="dropdown-item" data-toggle="modal" data-target="#downloadMonthWiseReport" href="#">
                                                <i class="fa fa-download"></i> Month Wise Report</a>
                                                <a class="dropdown-item" data-toggle="modal" data-target="#downloadNewAttendanceStudentReport" href="#">
                                                <i class="fa fa-download"></i> Student Consolidate Attendance Report</a>
                                                <a class="dropdown-item" data-toggle="modal" data-target="#downloadShortageReport" href="#">
                                                <i class="fa fa-download"></i> Attendance Shortage Report</a> -->
                                            </div>
                                        </div>
                                    <?php } ?>
                                    
                                </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
       <!-- <div class="card-header card-flex-container p-1">
            <div class="row c-m-b">
                <div class="col-4 col-md-5 col-lg-6 col-sm-5 box-tools">
            </div>
                <div class="col-8 col-md-5 col-lg-6 col-sm-5 box-tools">
                    <form action="<? //=base_url() ?>getClassTeacherAbsentDetails" method="POST" id="byFilterMethod">
                        <div class="d-flex">
                            <input class="form-control datepicker" type="text" name="date_from" value="<?php //if(!empty($date_from)) echo date('d-m-Y', strtotime($date_from)); ?>" style="text-transform: uppercase" placeholder="Date From" autocomplete="off">
                            <input class="form-control datepicker ml-1" type="text" name="date_to" value="<?php //if(!empty($date_to)) echo date('d-m-Y', strtotime($date_to)); ?>" style="text-transform: uppercase" placeholder="Date To" autocomplete="off">
                            <button type="submit" class="btn btn-success ml-1">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> -->

        <div class="row p-0 column_padding_card">

            <div class="col-12 column_padding_card">

                <div class="card card-small mb-4">

                    <div class="card-body p-1 pb-2 table-responsive">

                        <table style="width:100%" class="display table  table-bordered table-striped table-hover">

                            <thead>

                                <tr class="table_row_backgrond text-center">

                                    <!-- <th width="25"><input type="checkbox" id="selectAll" /></th> -->

                                    <th>Date</th>

                                    <th>Student ID</th>

                                    <th>Name</th>

                                    <th>Term</th>

                                    <th>Stream</th>

                                    <th>Section</th>

                                    <th>Session</th>

                                    <th>Action</th>

                                </tr>

                                <tr class="row_filter">

                                    <form action="<?php echo base_url() ?>getClassTeacherAbsentDetails" method="POST" id="byFilterMethod">

                                        <!-- <th></th> -->

                                        <th style="padding: 1px;"> 

                                            <input type="text" name="absentDate"

                                            id="absentDate" value="<?php echo $absentDate; ?>"

                                            class="form-control input-sm pull-right datepicker"

                                            style="text-transform: uppercase" placeholder="By Date"

                                            autocomplete="off" />

                                        </th>

                                        <th style="padding: 1px;"> 

                                            <input type="text" name="student_id" id="student_id"

                                            value="<?php echo $student_id; ?>"

                                            class="form-control input-sm pull-right"

                                            style="text-transform: uppercase" placeholder="By Student ID"

                                            autocomplete="off" />

                                        </th>


                                          <th style="padding: 1px;"> 

                                            <input type="text" name="by_name" id="by_name"

                                            value="<?php echo $by_name; ?>"

                                            class="form-control input-sm pull-right"

                                            style="text-transform: uppercase" placeholder="By Name"

                                            autocomplete="off" />

                                        </th>

            

                                        <th>

                                            <select class="form-control input-sm" id="by_term" name="by_term">

                                                <?php if($by_term != ""){ ?>

                                                    <option value="<?php echo $by_term; ?>" selected><b>Sorted: <?php echo $by_term; ?></b></option>

                                                <?php } ?>

                                                <option value="">BY TERM</option>
                                                <option value="I PUC">I PUC</option>
                                                <option value="II PUC">II PUC</option>
                                            </select>

                                        </th>

                                        <th>

                                            <select class="form-control input-sm" id="" name="stream_name">

                                                <?php if($stream_name != ""){ ?>

                                                    <option value="<?php echo $stream_name; ?>" selected><b>Sorted: <?php echo $stream_name; ?></b></option>

                                                <?php } ?>

                                                <option value="">BY STREAM</option>
                                                <?php if(!empty($streamInfo)){
                                                    foreach($streamInfo as $stream){ ?>
                                                <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                                <?php } } ?>

                                            </select>

                                        </th>

                                        <th>

                                            <select class="form-control input-sm" id="" name="section_name">

                                                <?php if($section_name != ""){ ?>

                                                    <option value="<?php echo $section_name; ?>" selected><b>Sorted: <?php echo $section_name; ?></b></option>

                                                <?php } ?>

                                                <option value="">BY SECTION</option>
                                                <option value="ALL">ALL</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>

                                            </select>

                                        </th>

                                        <th>
                                         <select class="form-control input-sm" id="session_name" name="session_name">
                                            <?php if($session_name != ""){ ?>
                                                <option value="<?php echo $session_name; ?>" selected><b>Sorted: <?php echo $session_name; ?></b></option>
                                            <?php } ?>
                                            <option value="">BY SESSION</option>
                                            <option value="Morning Session">Morning Session</option>
                                            <option value="Afternoon Session">Afternoon Session</option>
                                         </select>
                                        </th>

                                        <th style="padding: 1px;" class="text-center">

                                            <button type="submit" class="btn btn-success btn-md btn-block"><i class="fa fa-filter"></i> Filter</button>

                                        </th>

                                    </form>

                                </tr>

                            </thead>

                            <tbody>

                                <?php if(!empty($attendanceRecords)) {

                                    foreach($attendanceRecords as $record) { ?> 

                                    <tr>

                                       <!--  <th><input type="checkbox" class="singleSelect"

                                                value="<?php //echo $record->student_id; ?>" /></th>
 -->
                                        <th width="100" class="text-center"><?php echo date('d-m-Y',strtotime($record->absent_date)) ?></th>

                                        <th width="100"  class="text-center"><?php echo $record->student_id ?></th>

                                        <th width="140"><?php echo strtoupper($record->student_name); ?></th>
 
                                        <th width="90" class="text-center"><?php echo $record->term_name; ?></th>

                                        <th width="90" class="text-center"><?php echo $record->stream_name; ?></th>

                                         <th width="90" class="text-center"><?php echo $record->section_name; ?></th>

                                         <th width="90" class="text-center"><?php echo $record->session; ?></th>

                                        <th width="100" class="text-center">

                                            <span class="text-danger">Absent</span>

                                            <?php if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN || $staffID == 'LCS100' || $staffID == 'LCS87' || $staffID == 'LCS101'){ ?>

                                                <a class="btn btn-xs btn-danger deleteAbsentAttendance" href="#" data-row_id="<?php echo $record->row_id; ?>"

                                                title="Delete"><i class="fa fa-trash"></i></a>

                                            <?php } ?>

                                        </th>

                                    </tr>

                                <?php } }else{ ?>

                                    <tr>

                                        <th class="text-center" colspan="11">Attendance record not found</th>

                                    </tr>

                                <?php } ?>

                            </tbody>

                            <tfoot>

                                <tr class="table_row_backgrond text-center">

                                    <!-- <th width="25"><input type="checkbox" id="selectAll" /></th> -->

                                    <th>Date</th>

                                    <th>Student ID</th>

                                    <th>Name</th>

                                    <th>Term</th>

                                    <th>Stream</th>

                                    <th>Section</th>

                                    <th>Session</th>

                                    <th>Action</th>

                                </tr>

                            </tfoot>

                        </table>



                    </div>

                    <div class="card-footer">

                        <span class="float-right"><?php echo $this->pagination->create_links(); ?></span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>






<div class="modal fade" id="downloadMonthWiseReport">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Download Class Monthwise Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body p-2">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="role">Term</label>
                            <select class="form-control input-sm term" id="termStream_id" name="term_name">
                                <!-- <option value="" >Select Term</option> -->
                                    <?php if(!empty($termInfo)){
                                  foreach($termInfo as $term){ ?>
                                  <option value="<?php echo $term->term_name; ?>"><?php echo $term->term_name; ?></option>
                                   <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <label for="role">Section</label>
                        <select class="form-control input-sm" id="section_id" name="section_name" autocomplete="off">
                            <!-- <option value="">Select Section</option> -->
                            <option value="ALL">ALL</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="H">H</option>
                            <option value="I">I</option>
                            <option value="J">J</option>
                            <option value="K">K</option>
                            <option value="L">L</option>
                            <option value="M">M</option>
                        </select>
                    </div>
                <div class="col-6 mb-2">
                    <label for="role">Month</label>
                    <select class="form-control input-sm" id="month_id" name="" autocomplete="off">
                        <!-- <option value="ALL">ALL</option> -->
                        <option value="JANUARY">JANUARY</option>
                        <option value="FEBRUARY">FEBRUARY</option>
                        <option value="MARCH">MARCH</option>
                        <option value="APRIL">APRIL</option>
                        <option value="MAY">MAY</option>
                        <option value="JUNE">JUNE</option>
                        <option value="JULY">JULY</option>
                        <option value="AUGUST">AUGUST</option>
                        <option value="SEPTEMBER">SEPTEMBER</option>
                        <option value="OCTOBER">OCTOBER</option>
                        <option value="NOVEMBER">NOVEMBER</option>
                        <option value="DECEMBER">DECEMBER</option>
                    </select>
                </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                 <div id="loader_class"></div>
                <button id="downloadClassMonthwiseReportBtn" type="submit" class="btn btn-md btn-primary float-right"><i
                        class="fa fa-download"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="downloadNewAttendanceStudentReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header exportModel">
                <h4 class="modal-title">Download Attendance Student Report Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form data-download_form="true" action="<?php echo base_url() ?>downloadNewAttendanceExcelReport"
                    method="POST">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mt-1">
                                <label>Select Class</label>
                                <select class="form-control input-sm selectpicker" id="Attendance_term"
                                    name="Attendance_term" required>
                                    <option value="">Select Class</option>
                                    <!-- <option value="ALL">ALL</option> -->
                                    <?php if(!empty($termInfo)){
                                    foreach($termInfo as $term){ ?>
                                    <option value="<?php echo $term->term_name ?>">
                                        <?php echo $term->term_name ?>
                                    </option>
                                    <?php }  } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <div class="form-group mt-1">
                                <label>Select Section</label>
                                <select name="attendance_section" class="form-control input-sm" id="attendance_section"
                                    placeholder="Search Section">
                                    <option value="">By Section</option>
                                    <option value="ALL">ALL(No Section)</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                </select>
                            </div>
                        </div>


                    </div>
                    
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button id="downloadReportExcel" type="submit" class="btn btn-md btn-primary float-right"><i
                        class="fa fa-download"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="downloadShortageReport">

    <div class="modal-dialog modal-md">

        <div class="modal-content">

            <!-- Modal Header -->

            <div class="modal-header">

                <h4 class="modal-title">Download Attendance Shortage Report</h4>

                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <!-- Modal body -->

            <div class="modal-body p-2">

                <div class="row">

                    <div class="col-6">

                        <div class="form-group">

                            <label for="role">Term</label>

                            <select class="form-control input-sm term" id="short_attendance_term" name="short_attendance_term">

                                <!-- <option value="" >Select Term</option> -->

                                    <?php if(!empty($termInfo)){

                                  foreach($termInfo as $term){ ?>

                                  <option value="<?php echo $term->term_name; ?>"><?php echo $term->term_name; ?></option>

                                   <?php } } ?>

                            </select>

                        </div>

                    </div>

                    <div class="col-6 mb-2">

                        <label for="role">Section</label>

                        <select class="form-control input-sm" id="short_attendance_section" name="short_attendance_section" autocomplete="off">

                            <!-- <option value="">Select Section</option> -->

                            <option value="ALL">ALL</option>

                            <option value="A">A</option>

                            <option value="B">B</option>

                            <option value="C">C</option>

                            <option value="D">D</option>

                            <option value="E">E</option>

                            <option value="F">F</option>

                            <option value="G">G</option>

                            <option value="H">H</option>

                            <option value="I">I</option>

                            <option value="J">J</option>

                            <option value="K">K</option>

                            <option value="L">L</option>

                            <option value="M">M</option>

                        </select>

                    </div>

                <!-- </div>

                <div class="row"> -->

                    <div class="col-6 mb-2">

                        <label for="role">Date From(Optional)</label>

                        <input type="text" name="date_from" id="dateFromShortage"  class="form-control from_date"  style="text-transform: uppercase" placeholder="Date From"/>

                    </div>

                    <div class="col-6 mb-2">

                        <label for="role">Date To(Optional)</label>

                        <input type="text" name="date_to" id="dateToShortage"  class="form-control to_date"  style="text-transform: uppercase" placeholder="Date To"/>

                    </div>

                </div>

            </div>



            <!-- Modal footer -->

            <div class="modal-footer">

                 <div id="loader_class"></div>

                <button id="downloadShortageAttendanceReportBtn" type="submit" class="btn btn-md btn-primary float-right"><i

                        class="fa fa-download"></i> Download</button>

                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

            </div>

        </div>

    </div>

</div>


<div class="modal fade" id="downloadClassReport">

    <div class="modal-dialog modal-md">

        <div class="modal-content">

            <!-- Modal Header -->

            <div class="modal-header">

                <h4 class="modal-title">Download Class Completed Report</h4>

                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <!-- Modal body -->

            <div class="modal-body p-2">

                <div class="row">

                    <div class="col-6">

                        <div class="form-group">

                            <label for="role">Term</label>

                            <select class="form-control input-sm term" id="termStream" name="term_name">
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                            </select>

                        </div>

                    </div>

                    <div class="col-6">
                            <div class="form-group">
                                <label for="role">Stream</label>
                                <select class="form-control input-sm" id="stream_name_1" name="stream_name">
                                    <option value="">Select Stream</option>
                                        <?php if(!empty($streamInfo)){
                                            foreach($streamInfo as $stream){ ?>
                                        <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                        <?php } } ?>
                                </select>
                            </div>
                        </div>

                    <div class="col-6 mb-2">

                        <label for="role">Section</label>

                        <select class="form-control input-sm" id="section" name="section_name" autocomplete="off">

                            <option value="">Select Section</option>
                            <option value="ALL">ALL</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>

                        </select>

                    </div>

                <!-- </div>

                <div class="row"> -->

                    <div class="col-6 mb-2">

                        <label for="role">Date From(Optional)</label>

                        <input type="text" name="date_from" id="dateFrom"  class="form-control from_date"  style="text-transform: uppercase" placeholder="Date From"/>

                    </div>

                    <div class="col-6 mb-2">

                        <label for="role">Date To(Optional)</label>

                        <input type="text" name="date_to" id="dateTo"  class="form-control to_date"  style="text-transform: uppercase" placeholder="Date To"/>

                    </div>

                </div>

            </div>



            <!-- Modal footer -->

            <div class="modal-footer">

                 <div id="loader_class"></div>

                <button id="downloadClassReportBtn" type="submit" class="btn btn-md btn-primary float-right"><i

                        class="fa fa-download"></i> Download</button>

                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

            </div>

        </div>

    </div>

</div>


<div class="modal fade" id="downloadAttReport">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Download Absent Report</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body p-2">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="role">Class</label>
                                <select class="form-control input-sm termValue" id="term_name" name="term_name">
                                    <option value="">Select Class</option>
                                        <option value="I PUC">I PUC</option>
                                        <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="role">Stream</label>
                                <select class="form-control input-sm" id="stream_name" name="stream_name">
                                    <option value="">Select Stream</option>
                                        <?php if(!empty($streamInfo)){
                                            foreach($streamInfo as $stream){ ?>
                                        <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                        <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <label for="role">Section</label>
                            <select class="form-control input-sm" id="section_name" name="section_name"
                                autocomplete="off">
                                <!-- <option value="">Select Section</option> -->
                                <option value="ALL">ALL</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>

                        <div class="col-6 mb-2">
                            <label for="role">Date From(Optional)</label>
                            <input type="text" name="date_from" id="date_from" class="form-control from_date"
                                autocomplete="off" style="text-transform: uppercase" placeholder="Date From" />
                        </div>
                        <div class="col-6 mb-2">
                            <label for="role">Date To(Optional)</label>
                            <input type="text" name="date_to" id="date_to" class="form-control to_date"
                                autocomplete="off" style="text-transform: uppercase" placeholder="Date To" />
                        </div>

                        <!-- <div class="col-6 mb-2">
                            <label for="role">Report Type</label>
                            <select class="form-control input-sm" id="reportType" name="reportType" autocomplete="off">
                                <option value="Consolidate">Consolidate Report</option>
                                <option value="Separate">Separate Report</option>
                            </select>
                        </div> -->
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <div id="loader"></div>
                        <button id="downloadAttendanceReport" type="submit"
                            class="btn btn-md btn-primary float-right"><i class="fa fa-download"></i> Download</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/attendance.js" charset="utf-8"></script>

<script type="text/javascript">

var loader = '<img height="70" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';

jQuery(document).ready(function() {

    // $('select').selectpicker();

    $('#downloadAttendanceReport').click(function() {
            var term_name = $('.termValue').val();
            var stream_name = $('#stream_name').val();
            var section_name = $('#section_name').val();
            var date_from = $('#date_from').val();
            var date_to = $('#date_to').val();

            if (term_name == "") {
                alert("Class is Empty!!");
            } else {

                $.ajax({
                    url: '<?php echo base_url(); ?>/downloadClassAbsentedStudentInfo',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        date_from: date_from,
                        date_to: date_to,
                        term_name: term_name,
                        stream_name: stream_name,
                        section_name: section_name
                    },
                    success: function(data) {
                        $('#loader').html('');
                        $("#downloadAttendanceReport").prop('disabled', false);
                        // $("#downloadAttReport").hide();
                        var $a = $("<a>");
                        $a.attr("href", data.file);
                        $("body").append($a);
                        $a.attr("download", term_name + "_" + section_name +
                            "_ATTENDANCE_REPORT.xls");
                        $a[0].click();
                        $a.remove();
                    },
                    error: function(result) {
                        $('#loader').html('');
                        $("#downloadAttendanceReport").prop('disabled', false);
                        alert("Network Server Error!!  Failed");
                    },
                    fail: (function(status) {
                        $('#loader').html('');
                        $("#downloadAttendanceReport").prop('disabled', false);
                        alert("Server Error!!  Failed");
                    }),
                    beforeSend: function(d) {
                        $('#loader').html(loader);
                        $("#downloadAttendanceReport").prop('disabled', true);
                    }
                });
            }
        });



    jQuery('ul.pagination li a').click(function(e) {

        e.preventDefault();

        var link = jQuery(this).get(0).href;

        var value = link.substring(link.lastIndexOf('/') + 1);

        jQuery("#byFilterMethod").attr("action", baseURL + "getClassTeacherAbsentDetails/" + value);

        jQuery("#byFilterMethod").submit();

    });



    jQuery('.datepicker').datepicker({

        autoclose: true,

        orientation: "bottom",

        format: "dd-mm-yyyy",

        endDate : "today",

        startDate : "01-03-2020",



    });



    jQuery('.from_date,.to_date').datepicker({

        autoclose: true,

        format : "dd-mm-yyyy",

        endDate: "today",

        startDate : "01-03-2020",

        maxDate: 2,

    });



    //checkbox select

    $('#selectAll').click(function() {

        if ($('#selectAll').is(':checked')) {

            $('.singleSelect').prop('checked', true);

        } else {

            $('.singleSelect').prop('checked', false);

        }

    });

    $('#downloadClassMonthwiseReportBtn').click(function(){
        var term_name = $('#termStream_id').val();
        var section_name = $('#section_id').val();
        var month_name = $('#month_id').val();
        if(section_name == ''){
            var section = 'ALL';
        }else{
            var section = section_name;
        }
        if(term_name == ""){
            alert("Term is Empty!!");
        }else{
            
            $.ajax({
                url: '<?php echo base_url(); ?>/downloadMonthWiseReportNew',
                type: 'POST',
                dataType:'json',
                data: {
                    month_name : month_name,
                    term_name : term_name,
                    section_name : section_name
                },
                success: function(data) {
                    $('#loader_class').html('');
                    $("#downloadClassMonthwiseReportBtn").prop('disabled', false);
                    var $a = $("<a>");
                    $a.attr("href",data.file);
                    $("body").append($a);
                    $a.attr("download",term_name+"_"+section+"_ATTENDANCE_CLASS_COMPLETED_REPORT.xls");
                    $a[0].click();
                    $a.remove();
                },
                error: function(result) { 
                    $('#loader_class').html('');
                    $("#downloadClassMonthwiseReportBtn").prop('disabled', false);
                    alert("Network Server Error!!  Failed");
                },
                fail:(function(status) {
                    $('#loader_class').html('');
                    $("#downloadClassMonthwiseReportBtn").prop('disabled', false);
                    alert("Server Error!!  Failed");
                }),
                beforeSend:function(d){
                    $('#loader_class').html(loader);
                    $("#downloadClassMonthwiseReportBtn").prop('disabled', true);
                }
            });
        }
});


    $('#downloadClassReportBtn').click(function(){ 

        var term_name = $('#termStream').val();

        var section_name = $('#section').val();

        var stream_name = $('#stream_name_1').val();

        var date_from = $('#dateFrom').val();

        var date_to = $('#dateTo').val(); 

        if(section_name == ''){

            var section = 'ALL';

        }else{

            var section = section_name;

        }

        if(term_name == ""){

            alert("Term is Empty!!");

        }else{

            

            $.ajax({

                url: '<?php echo base_url(); ?>/downloadClassTeacherClassCompleted',

                type: 'POST',

                dataType:'json',

                data: {

                    date_from : date_from,

                    date_to : date_to,

                    term_name : term_name,

                    stream_name : stream_name,

                    section_name : section_name

                },

                success: function(data) {

                    $('#loader_class').html('');

                    $("#downloadClassReportBtn").prop('disabled', false);

                    var $a = $("<a>");

                    $a.attr("href",data.file);

                    $("body").append($a);

                    $a.attr("download",term_name+"_"+section_name+"_ATTENDANCE_CLASS_COMPLETED_REPORT.xls");

                    $a[0].click();

                    $a.remove();

                },

                error: function(result) { 

                    $('#loader_class').html('');

                    $("#downloadClassReportBtn").prop('disabled', false);

                    alert("Network Server Error!!  Failed");

                },

                fail:(function(status) {

                    $('#loader_class').html('');

                    $("#downloadClassReportBtn").prop('disabled', false);

                    alert("Server Error!!  Failed");

                }),

                beforeSend:function(d){

                    $('#loader_class').html(loader);

                    $("#downloadClassReportBtn").prop('disabled', true);

                }

            });

        }

    });

    $('#downloadShortageAttendanceReportBtn').click(function(){ 

        var term_name = $('#short_attendance_term').val();

        var section_name = $('#short_attendance_section').val();

        var date_from = $('#dateFromShortage').val();

        var date_to = $('#dateToShortage').val(); 

        if(section_name == ''){

            var section = 'ALL';

        }else{

            var section = section_name;

        }

        if(term_name == ""){

            alert("Term is Empty!!");

        }else{

            

            $.ajax({

                url: '<?php echo base_url(); ?>/downloadClassCompletedReportShortage',

                type: 'POST',

                dataType:'json',

                data: {

                    date_from : date_from,

                    date_to : date_to,

                    term_name : term_name,

                    section_name : section_name

                },

                success: function(data) {

                    $('#loader_class').html('');

                    $("#downloadShortageAttendanceReportBtn").prop('disabled', false);

                    var $a = $("<a>");

                    $a.attr("href",data.file);

                    $("body").append($a);

                    $a.attr("download",term_name+"_"+section+"_SHORTAGE_OF_ATTENDANCE_REPORT.xls");

                    $a[0].click();

                    $a.remove();

                },

                error: function(result) { 

                    $('#loader_class').html('');

                    $("#downloadShortageAttendanceReportBtn").prop('disabled', false);

                    alert("Network Server Error!!  Failed");

                },

                fail:(function(status) {

                    $('#loader_class').html('');

                    $("#downloadShortageAttendanceReportBtn").prop('disabled', false);

                    alert("Server Error!!  Failed");

                }),

                beforeSend:function(d){

                    $('#loader_class').html(loader);

                    $("#downloadShortageAttendanceReportBtn").prop('disabled', true);

                }

            });

        }

    });


    jQuery(document).on("click", ".deleteAbsentAttendance", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "deleteAbsentAttendance",
			currentRow = $(this);
		var confirmation = confirm("Are you sure to delete this Attendance ?");
		if(confirmation) {
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Attendance successfully deleted"); }
				else if(data.status = false) { alert("Attendance deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});



});



</script>