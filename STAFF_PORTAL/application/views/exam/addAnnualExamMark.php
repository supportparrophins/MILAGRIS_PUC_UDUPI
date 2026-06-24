<?php
            $this->load->helper('form');
            $error = $this->session->flashdata('error');
            if($error)
            {
        ?>
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo $this->session->flashdata('error'); ?>
</div>
<?php } ?>
<?php  
            $success = $this->session->flashdata('success');
            if($success)
            {
        ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo $this->session->flashdata('success'); ?>
</div>
<?php } ?>

<?php  
            $noMatch = $this->session->flashdata('nomatch');
            if($noMatch)
            {
        ?>
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo $this->session->flashdata('nomatch'); ?>
</div>
<?php } ?>
<div class="row">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>

<!-- Content Header (Page header) -->
<div class="main-content-container px-3 pt-1">
    <div class="row p-0">
        <div class="col column_padding_card">
            <div class="card card-small card_heading_title p-0 m-b-1">
                <div class="card-body p-2">
                    <div class="row c-m-b">
                        <div class="col-6">
                            <span class="page-title absent_table_title_mobile">
                                <i class="material-icons">mode_edit</i> Add Annual Exam Mark
                            </span>
                        </div>

                        <div class="col-6">
                            <a onclick="window.history.back();"
                                class="btn primary_color mobile-btn float-right text-white pt-2 border_left_radius"
                                value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                            <button class="btn btn-success mobile-btn border_right_radius" type="button"
                                style="float:right" data-toggle="modal" data-target="#helpModel"> <i
                                    class="fa fa-info"></i> Help</button>

                                    <div class="col-lg-2">
                    <button style="float:right" type="button" data-toggle="modal" data-target="#myDownloadModal"
                        class="btn btn-md btn-primary"> Download Marks Sheet</button>
                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row form-employee">
        <div class="col-12 column_padding_card">
            <div class="card card-small c-border p-2">
                <form role="form" action="<?php echo base_url(); ?>getStudentsInfoForAnnualExam" method="POST"
                    id="byFilterMethod">
                    <div class="row">
                        <input type="hidden" value="I" name="term_name" id="term_name" />
                        <div class="col-lg-4 col-md-4 col-12">
                            <select required name="stream_name" id="stream_name selectpicker" class="form-control"
                                data-live-search="true">
                                <?php if(!empty($stream_name)){ ?>
                                <option value="<?php echo $stream_name; ?>" selected> Selected:
                                    <?php echo $stream_name; ?>
                                </option>
                                <?php } ?>
                                <option value="">Select Stream</option>
                                <?php foreach($streamInfo as $stream){ ?>
                                <option value="<?php echo $stream->stream_name; ?>">
                                    <?php echo strtoupper($stream->stream_name); ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <select id="subject_name" name="subject_name" class="form-control selectpicker"
                                data-live-search="true" required>
                                <?php if(!empty($sub_name)){ ?>
                                <option value="<?php echo $sub_name; ?>" selected> Selected:
                                    <?php echo $sub_name; ?>
                                </option>
                                <?php } ?>
                                <option value="">Select Subject</option>
                                <?php foreach($subjectInfo as $sub){ ?>
                                <option value="<?php echo $sub->subject_code; ?>">
                                    <?php echo strtoupper($sub->sub_name); ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <button type="submit" class="btn btn-success btn-block">
                                Search</button>
                        </div>
                    </div>
                </form>
                <hr class="mt-1 mb-1">
                <div class="table-responsive-sm">
                    <?php if(!empty($subject->subject_code)){ ?>
                    <div class="row" style="padding-bottom: 5px;">
                        <div class="col-lg-4 col-md-4 col-12">
                            <span style="font-size: 16px;">Stream Name:
                                <b><?php echo $stream_name; ?></b></span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <span style="font-size: 16px;">Subject: <b><?php echo $subject->sub_name; ?></b></span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <span style="font-size: 16px;">Total Students:
                                <b><?php echo count($studentsInfo); ?><b></b></span>
                        </div>
                    </div>
                    <?php } ?>
                    <form action="<?php echo base_url(); ?>addStudentAnnualMarkByStaff" method="POST">
                        <?php 
                            $labStatus = 'false';
                            if(!empty($subject->subject_code)){ 
                            if($subject->subject_code == 12){
                                $max_lab_mark = 20;
                                $min_mark_pass = 24;
                                $max_mark_theory = 80;
                                $labStatus = 'true';
                            } else if($subject->lab_status == true){
                                $max_lab_mark = 30;
                                $min_mark_pass = 21;
                                $max_mark_theory = 70;
                                $labStatus = $subject->lab_status;
                            } else {
                                $min_mark_pass = 35;
                                $max_mark_theory = 100;
                                $labStatus = $subject->lab_status;
                            } 
                           
                            $pass_class_min = 35;
                            $pass_class_max = 49;
                            $second_class_min_mark = 50;
                            $second_class_max_mark = 59;
                            $first_class_min_mark = 60;
                            $first_class_max_mark = 84;
                            $dest_min_mark = 85;
                            $dest_max_mark = 100;
                            }
                        ?>
                        <table class="table table-bordered text-dark">
                            <thead class="text-center">
                                <tr class="table_row_background">
                                    <th width="130">Register No.</th>
                                    <th width="100">Student ID</th>
                                    <th>Name</th>
                                    <th width="200">Obt Theory Mark</th>
                                    <?php if($labStatus == 'true'){ ?>
                                    <th width="200">Obt Lab Mark</th>
                                    <?php } ?>
                                    <th width="200">Actions</th>
                                    <th>Total</th>
                                    <th>Result</th>
                            </thead>
                            <tbody>
                                <?php
                                    $update_byutton_active = false;
                                    if(!empty($studentsInfo)){
                                        $count_pass_students = 0;
                                        $count_fail_students = 0;
                                        $count_malparactice_students = 0;
                                        $count_absent_students = 0;
                                        $count_examption_students = 0;
                                        $second_class_count = 0;
                                        $distinction_count = 0;
                                        $first_class_count = 0;
                                        $third_class_count = 0;
                                        $pass_class_count = 0;
                                        $count_attendance_shortage = 0;
                                        $update_byutton_active = false;
                                        ?>
                                <input type="hidden" value="I PUC" name="term_name" />
                                <input type="hidden" value="<?php echo $labStatus; ?>" id="lab_status" />
                                <input type="hidden" value="<?php echo $subject->subject_code; ?>" name="subject_id" />
                                <input type="hidden" value="<?php echo $stream_name; ?>" name="stream_name" />

                                <input type="hidden" value="<?php echo $max_mark_theory; ?>" id="max_theory_mark" />
                                <input type="hidden" value="<?php echo $max_lab_mark; ?>" id="max_lab_mark" />

                                <?php foreach($studentsInfo as $record) { ?>
                                <tr>
                                    <td><?php echo $record->pu_board_number; ?></td>
                                    <td><?php echo $record->student_id; ?></td>
                                    <td><?php echo $record->student_name; ?></td>
                                    <?php
                                            $mark_status = false;
                                            $update_mark_status = false;
                                            $total_mark = 0;
                                            if(!empty($studentMarkInfo)){ 
                                                foreach($studentMarkInfo as $mark){
                                                    $student_id = trim($mark->student_id);
                                                    if($student_id == trim($record->student_id)){
                                                        $mark_obt_theory = trim($mark->obt_theory_mark);
                                                        $lab_mark_obt = trim($mark->obt_lab_mark);?>

                                    <td>
                                        <input value="<?php echo $mark_obt_theory;  ?>"
                                            style="font-size: 15px;font-weight: 700 !important;" maxlength="3"
                                            onkeyup="getTotalMarks('<?php echo $student_id; ?>')"
                                            onkeypress="return isNumberKey(event,'<?php echo $student_id; ?>')"
                                            id="obt_theory_mark_<?php echo $student_id; ?>"
                                            class="form-control input-sm numberonly mark_col_width"
                                            placeholder="Enter Theory Mark" type="text"
                                            name="obt_theory_mark_<?php echo $student_id; ?>" autocomplete="off" />


                                    </td>

                                    <?php if($labStatus == 'true'){ 
                                                    if(is_numeric($lab_mark_obt) && !empty($lab_mark_obt)) {
                                                        $total_mark = $lab_mark_obt + $mark_obt_theory;
                                                    }else{
                                                        $total_mark = $mark_obt_theory;
                                                    } ?>
                                    <td>
                                        <input value="<?php echo $lab_mark_obt; ?>"
                                            style="font-size: 15px;font-weight: 700 !important;" maxlength="2"
                                            onkeyup="getTotalMarks('<?php echo $student_id; ?>')"
                                            onkeypress="return isNumberKey(event,'<?php echo $student_id; ?>')"
                                            id="lab_obt_mark_<?php echo $student_id; ?>"
                                            class="form-control input-sm numberonly mark_col_width"
                                            placeholder="Enter Lab Mark" type="text"
                                            name="lab_obt_mark_<?php echo $student_id; ?>" autocomplete="off" />
                                    </td>
                                    <?php } else{
                                                $total_mark = $mark_obt_theory;
                                            } ?>

                                    <td> <select onchange="actionTaken('<?php echo $student_id; ?>')"
                                            class="form-control input-sm mark_col_width"
                                            id="other_action_<?php echo $student_id; ?>" name="other_action">
                                            <option value="">No Action</option>
                                            <option value="AB">Absent</option>
                                            <option value="EXEM">Exemption</option>
                                            <option value="MP">Malpractice</option>
                                            <option value="SAT">Shortage of Attendance</option>
                                        </select></td>

                                    <td id="get_total_mark_<?php echo $student_id; ?>"><b
                                            style="color:black"><?php echo $total_mark; ?></b> </td>
                                    <td id="result_<?php echo $student_id; ?>">
                                        <?php 
                                                if($mark_obt_theory == 'AB' || $mark_obt_theory == 'EXEM' || $mark_obt_theory == 'MP' || $mark_obt_theory == 'SAT'){
                                                    echo '<b style="color:red">'.$mark_obt_theory.'</b>';
                                                    if($mark_obt_theory == 'AB'){
                                                        $count_absent_students++;
                                                    } else if ($mark_obt_theory == 'EXEM'){
                                                        $count_examption_students++;
                                                    } else if($mark_obt_theory == 'MP'){
                                                        $count_malparactice_students++;
                                                    }else if($mark_obt_theory == 'SAT'){
                                                        $count_attendance_shortage++;
                                                    }
                                                } else if($mark_obt_theory == ""){
                                                    echo '<b style="color:red">Pending</b>';
                                                } else if($mark_obt_theory < $min_mark_pass){
                                                    $count_fail_students++;
                                                    echo '<b style="color:red">FAIL</b>';
                                                } else if($total_mark < 35) {
                                                    $count_fail_students++;
                                                    echo '<b style="color:red">FAIL</b>';
                                                } else {
                                                    if($total_mark >= $dest_min_mark){
                                                        $distinction_count++;
                                                    } else if($total_mark >= $first_class_min_mark && $total_mark <= $first_class_max_mark){
                                                        $first_class_count++;
                                                    }else  if($total_mark >= $second_class_min_mark && $total_mark <= $second_class_max_mark){
                                                        $second_class_count++;
                                                    } else {
                                                        $pass_class_count++;
                                                    }
                                                    $count_pass_students++;
                                                    echo '<b style="color:green">PASS</b>';
                                                } ?>
                                    </td>
                                </tr>
                                <?php $update_byutton_active = true;
                                        break;
                                    }else{



                                        
                                    }
                                    }
                                    } else { 
                                    $mark_status = true;
                                    $student_id = trim($record->student_id);
                                    ?><td>
                                    <input style="font-size: 15px;font-weight: 700 !important;" maxlength="3"
                                        onkeyup="getTotalMarks('<?php echo $student_id; ?>')"
                                        onkeypress="return isNumberKey(event,'<?php echo $student_id; ?>')"
                                        id="obt_theory_mark_<?php echo $student_id; ?>"
                                        class="form-control input-sm numberonly mark_col_width"
                                        placeholder="Enter Theory Mark" type="text"
                                        name="obt_theory_mark_<?php echo $student_id; ?>" autocomplete="off" />
                                </td>
                                <?php if($labStatus == 'true'){ ?>
                                <td>
                                    <input style="font-size: 15px;font-weight: 700 !important;" maxlength="3"
                                        onkeyup="getTotalMarks('<?php echo $student_id; ?>')"
                                        onkeypress="return isNumberKey(event,'<?php echo $student_id; ?>')"
                                        id="lab_obt_mark_<?php echo $student_id; ?>"
                                        class="form-control input-sm numberonly mark_col_width"
                                        placeholder="Enter Lab Mark" type="text"
                                        name="lab_obt_mark_<?php echo $student_id; ?>" autocomplete="off" />
                                </td>
                                <?php } ?>
                                <td>
                                    <select onchange="actionTaken('<?php echo $student_id; ?>')"
                                        class="form-control input-sm mark_col_width"
                                        id="other_action_<?php echo $student_id; ?>" name="other_action">
                                        <option value="">No Action</option>
                                        <option value="AB">Absent</option>
                                        <option value="EXEM">Exemption</option>
                                        <option value="MP">Malpractice</option>
                                        <option value="SAT">Shortage of Attendance</option>
                                    </select>
                                </td>
                                <td id="get_total_mark_<?php echo $student_id; ?>"> </td>
                                <td id="result_<?php echo $student_id; ?>">
                                    <span style="color:red;">Pending</span>
                                </td>
                                <?php } ?>
                                </tr>
                                <?php } } else { ?>
                                <td colspan="7" class="alert alert-info text-center">
                                    <strong>To Enter mark, Search through above options!</strong>
                                </td>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php if(!empty($studentsInfo) && $mark_status == true){ ?>
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <button class="btn btn-primary btn-md" id="submitMark" type="submit">Submit</button>
                            </div>
                        </div>
                        <?php } else if($update_byutton_active == true) { ?>
                        <div class="row">
                            <div class="col-lg-6">
                                <button style="float:left;" data-toggle="modal" data-target="#analyzeModal"
                                    type="button" class="btn btn-md btn-primary">Analyze Section</button>
                            </div>
                            <div class="col-lg-6 ">
                                <button style="float:right;" class="btn btn-success btn-md" id="submitMark"
                                    type="submit">Update</button>
                            </div>
                            <?php if($update_mark_status == true){ ?>
                            <?php } ?>
                        </div>
                        <?php } 
                    
                            if(!empty($studentsInfo)){
                                ?>
                        <div class="row text-center" style="font-size: 20px;">
                            <div class="col-lg-4">
                                Total Students: <b><?php echo count($studentsInfo); ?></b>
                            </div>
                            <div class="col-lg-4">
                                PASS: <b style="color:green;"><?php echo $count_pass_students; ?></b>
                            </div>
                            <div class="col-lg-4">
                                FAIL: <b style="color:red;"><?php echo $count_fail_students; ?></b>
                            </div>
                        </div>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- analyze Modal -->
    <div id="analyzeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="background: #58c64c;">
                    <h4 class="modal-title">Overall Analyze</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body p-2">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr class="danger">
                                    <td>Total Students</td>
                                    <td><b><?php echo count($studentsInfo); ?></b></td>
                                </tr>
                                <tr class="warning">
                                    <td>Exemption</td>
                                    <td id="exemption"><b
                                            style="color:red;"><?php echo $count_examption_students; ?></b>
                                    </td>
                                </tr>
                                <tr class="warning">
                                    <td>Absent</td>
                                    <td id="absent"><b style="color:red;"><?php echo $count_absent_students; ?></b></td>
                                </tr>
                                <tr class="warning">
                                    <td>Malpractice</td>
                                    <td id="malpractice"><b
                                            style="color:red;"><?php echo $count_malparactice_students; ?></b></td>
                                </tr>
                                <tr class="warning">
                                    <td>Attendance Shortage</td>
                                    <td id="attendance"><b
                                            style="color:red;"><?php echo $count_attendance_shortage; ?></b></td>
                                </tr>
                                <tr class="success">
                                    <td>Distinction</td>
                                    <td id="distinction"><?php echo $distinction_count; ?></td>
                                </tr>
                                <tr class="success">
                                    <td>I Class</td>
                                    <td id="first_class"><?php echo $first_class_count; ?></td>
                                </tr>
                                <tr class="success">
                                    <td>II Class</td>
                                    <td id="second_class"><?php echo $second_class_count; ?></td>
                                </tr>
                                <tr class="success">
                                    <td>Pass Class</td>
                                    <td id="third_class"><?php echo $pass_class_count; ?></td>
                                </tr>
                                <tr class="danger">
                                    <td>Total Pass</td>
                                    <td id="pass_students"><b
                                            style="color:green;"><?php echo $count_pass_students; ?></b>
                                    </td>
                                </tr>
                                <tr class="danger">
                                    <td>Total Fail</td>
                                    <td id="failed_students"><b
                                            style="color:red;"><?php echo $count_fail_students; ?></b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="helpModel" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#3c8dbc">
                    <h4 class="modal-title">Instruction Guide</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body p-2">
                    <ul><b>
                            <li>Before Student marks entry, Select the following </li>
                            a) Stream<br>
                            b) Subject <br>
                            <li>Do not make any mistakes in the Student marks entry. </li>
                            <li>If a Student is Absent or Indulged In any Malpractice, click *Action* and choose 1
                                option
                                from the following.</li>
                            <li>After Student marks entry , click *Submit* button</li>
                            <li>Abbreviations:</li>
                            <b>AB</b> : Absent<br>
                            <b>SAT</b> : Shortage of Attendance<br>
                            <b>MP</b> : Malpractice<br>
                            <b>EXEM</b> : Exemption<br>
                        </b></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

</div>


<!-- excel Download Modal -->
<div id="myDownloadModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Download Marks Sheet</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-2">
                <div class="form-group">
                    <label for="role">Select Download Type</label>
                    <select class="form-control required" id="type" name="type">
                        <option value="All">All Students</option>
                        <option value="Failed">Only Failed Students</option>
                    </select>
                </div>

            </div>
            <div class="modal-footer">
                <span id="loader"></span>
                <button type="submit" onclick="downloadExcelSheet();" id="downloadAllMarks"
                    class="btn btn-primary">Download</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
var loader = '<img height="70" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';
var term_name = 'I';


jQuery(document).ready(function() {

    $('select').selectpicker();
    $(".numberonly").focus(function() {
        $(this).attr("type", "number")
    });
    $(".numberonly").blur(function() {
        $(this).attr("type", "text")
    });

    $("#submitMark").submit(function(e) {
        e.preventDefault();
    });


    $(function() {
        $('#attendanceDate').datepicker({
            autoclose: true,
            endDate: "today",
            format: 'dd-mm-yyyy',
        });
    });
});

function isNumberKey(evt, student_id) {
    //alert(mark_ent)

    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function actionTaken(student_id) {
    var value = $('#other_action_' + student_id).val();
    if (value != "") {
        $("#result_" + student_id).html("<b style='color:red'>" + value + "</b>");
        $("#get_total_mark_" + student_id).html("<b style='color:red'>" + value + "</b>");
        $("#obt_theory_mark_" + student_id).val(value);
        $("#obt_theory_mark_" + student_id).prop('readonly', false);
        $("#lab_obt_mark_" + student_id).val(value);
        $("#lab_obt_mark_" + student_id).prop('readonly', false);
    } else {
        $("#result_" + student_id).html("<b style='color:red'>Pending</b>");
        $("#get_total_mark_" + student_id).html("<b style='color:red'>Pending</b>");
        $("#obt_theory_mark_" + student_id).val("");
        $("#obt_theory_mark_" + student_id).prop('readonly', false);
        $("#lab_obt_mark_" + student_id).val("");
        $("#lab_obt_mark_" + student_id).prop('readonly', false);
    }
}

function getTotalMarks(student_id) {
    var fail_flag = 0;
    var lab_status = $('#lab_status').val();
    var max_theory_mark = $('#max_theory_mark').val();
    var max_lab_mark = $('#max_lab_mark').val();
    var theory_mark = $("#obt_theory_mark_" + student_id).val();
    var lab_mark = $("#lab_obt_mark_" + student_id).val();
    lab_mark = Number(lab_mark);
    theory_mark = Number(theory_mark);
    var total_mark = 0;
    if (isNaN(theory_mark) && isNaN(lab_mark)) {
        total_mark = 0;
    } else if (isNaN(theory_mark)) {
        total_mark = lab_mark;
    } else if (isNaN(lab_mark)) {
        total_mark = theory_mark;
    } else {
        total_mark = theory_mark + lab_mark;
    }


    if (lab_status == 'true') {

        if (Number(max_theory_mark) == 70 && Number(max_lab_mark) == 30) {
            if (theory_mark < 21) {
                fail_flag = 1;
            } else if (total_mark < 35) {
                fail_flag = 1;
            } else {
                fail_flag = 0;
            }
        } else {
            if (theory_mark < 24) {
                fail_flag = 1;
            } else if (total_mark < 35) {
                fail_flag = 1;
            } else {
                fail_flag = 0;

            }
        }
    } else {
        if (total_mark < 35) {

            fail_flag = 1;
        } else {
            fail_flag = 0;
        }
    }


    if (fail_flag == 1) {
        $("#get_total_mark_" + student_id).html("<b style='color:red'>" + total_mark + "</b>");
        $("#result_" + student_id).html("<b style='color:red'>FAIL</b>");
    } else {
        $("#get_total_mark_" + student_id).html("<b style='color:green'>" + total_mark + "</b>");
        $("#result_" + student_id).html("<b style='color:green'>PASS</b>");
    }
}


//after load student details update student marks entered or not
function downloadExcelSheet() {
    var loader = '<img height="30" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';
    var right_mark = '<img src="<?php echo base_url(); ?>/assets/images/right_symbol.png"/>';
    var type = $('#type :selected').val();
    //  var section_name = $('#section_name :selected').val();
    $.ajax({
        url: '<?php echo base_url(); ?>/getFullMarksOfStudentLatest',
        type: 'POST',
        dataType: 'json',
        data: {
            type: type,
        },

        success: function(data) {
            $("#downloadAllMarks").prop('disabled', false);
            $("#loader").html(right_mark + "<span style='color:green'><b>Downloaded</b></span>");
            // var studentObj = JSON.parse(data)
            var $a = $("<a>");
            $a.attr("href", data.file);
            $("body").append($a);
            $a.attr("download", "Annual_Result_I_PUC__file.xls");
            $a[0].click();
            $a.remove();
        },
        error: function(result) {
            $("#downloadAllMarks").prop('disabled', false);
            alert("Mark is not added selected section");
            $("#loader").html(
                "<span style='color:red'>Selected class section not found in mark list!!</span>");
        },
        fail: (function(status) {
            $("#downloadAllMarks").prop('disabled', false);
            alert("Server Error!!  Failed");
        }),
        beforeSend: function(d) {
            $("#downloadAllMarks").prop('disabled', true);
            $("#loader").html(loader);
        }
    });
}
</script>