<?php
 require APPPATH . 'views/includes/db.php'; 

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
<link href="<?php echo base_url(); ?>assets/dist/css/exam.css" rel="stylesheet" type="text/css" />
<style>
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0; 
}

.loaderScreen {
    display: block;
    visibility: visible;
    position: absolute;
    z-index: 999;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
    background-color: #0a0a0a94;
    vertical-align: bottom;
    padding-top: 20%;
    filter: alpha(opacity=75);
    opacity: 0.75;
    font-size: large;
    color: blue;
    font-style: italic;
    font-weight: 400;

    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
}
</style>
<!-- Content Header (Page header) -->
<div class="main-content-container px-3 pt-1">
<?php if($_SESSION['loggedIn_type']!='Mobile'){ ?>
    <div class="row p-0">
        <div class="col column_padding_card">
            <div class="card card-small card_heading_title p-0 m-b-1">
                <div class="card-body p-2">
                    <div class="row c-m-b">
                        <div class="col-6">
                            <span class="page-title count_heading">
                                <i class="material-icons">mode_edit</i> Add Internal Mark
                            </span>
                        </div>
                        <div class="col-6">
                            <a onclick="window.history.back();"
                                class="btn primary_color mobile-btn float-right border_left_radius text-white pt-2"
                                value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                            <?php if($role == EXAM_COMMITTEE || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE || $role == ROLE_ADMIN) { ?>
                                <!-- <button style="float:right" type="button" data-toggle="modal" data-target="#myDownloadModal"
                                class="btn btn-md btn-primary border_right_radius"> Download Marks Sheet</button> -->
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="row form-employee">
        <div class="col-12 column_padding_card">
            <div class="card card-small c-border p-2">
            <form role="form" action="<?php echo base_url(); ?>getStudentForInternalMark" method="POST" id="byFilterMethod">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 col-12">
                            <select required name="term_name" id="term_name" class="form-control" data-live-search="true">
                                <?php if(!empty($term_name)){ ?>
                                    <option value="<?php echo $term_name; ?>">Selected: <?php echo $term_name; ?></option>
                                <?php } ?>
                                <option value="">Select Term</option>
                                <option value="I PUC">I PUC</option>
                                <option value="II PUC">II PUC</option>
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-3 col-12">
                            <select required name="section_row_id" id="streamName" class="form-control stream_name" data-live-search="true">
                                <?php if(!empty($section_row_id)){ ?>
                                    <option value="<?php echo $section_row_id; ?>">Selected: <?php echo $stream_name.' - '.$section_name; ?></option>
                                <?php } ?>
                                <option value="">Select Stream & Section</option>
                            </select>
                        </div>
                        
                        <div class="col-lg-3 col-md-3 col-12">
                            <select id="staff_subject_row_id" name="staff_subject_row_id" class="form-control selectpicker" data-live-search="true" required>
                                <?php if(!empty($sub_name)){ ?>
                                <?php } ?>
                                <option value="">Select Subject</option>
                                <?php foreach($staffSubjectInfo as $sub){
                                    if($sub->subject_type == 'THEORY'){
                                        if($subject_row_id == $sub->row_id){ ?>
                                            <option value="<?php echo $sub->row_id; ?>" selected> Selected:
                                                <?php echo $sub_name.'->'.$staff_name; ?>
                                            </option>
                                        <?php }  ?>
                                        <option value="<?php echo $sub->row_id; ?>">
                                            <?php echo strtoupper($sub->sub_name.'->'.(string)$sub->staff_name); ?>
                                        </option>
                                <?php } } ?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-3 col-12">
                            <select id="exam_type" name="exam_type" class="form-control" data-live-search="true" required>
                                <?php if(!empty($examInfo)){ ?>
                                    <option value="<?php echo $examInfo->row_id; ?>" selected> Selected:
                                        <?php echo str_replace('_',' ',$examInfo->exam_type); ?>
                                    </option>
                                <?php } ?>
                                <option value="">Select Exam</option>
                                                            
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-3 col-12">
                            <button type="submit" id="searchButton" class="btn btn-success btn-block">
                                Search</button>
                        </div>
                    </div>
                </form>
                <hr class="mt-1 mb-1">
                <div class="table-responsive-sm">
                  <?php if(!empty($subject->subject_code)){ ?>
                    <div class="row pb-2">
                        <div class="col-lg-3 col-md-3 col-6 mb-1">
                            <span class="badge badge-pill badge-info" style="font-size: 16px;">Stream:
                                <b><?php echo $stream_name; ?></b></span>
                        </div>
                        <div class="col-lg-3 col-md-3 col-6 mb-1">
                            <span class="badge badge-pill badge-info" style="font-size: 16px;">Section:
                                <b><?php echo $section_name; ?></b></span>
                        </div>
                        <div class="col-lg-3 col-md-3 col-6 mb-1">
                            <span class="badge badge-pill badge-info" style="font-size: 16px;">Subject: <b><?php echo $subject->sub_name; ?></b></span>
                        </div>
                        <div class="col-lg-3 col-md-3 col-6 mb-1">
                            <span class="badge badge-pill badge-info" style="font-size: 16px;">Total Students:
                                <b><?php echo count($studentsInfo); ?><b></b></span>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <style>
        .form-submit-btn{
            display: block;
            width: 200px;
        }
        @media only screen and (max-width: 766px) {
            .form-submit-btn{
                display: block;
                width: 100%;
            }
        }
    </style>
    <div class="row mt-1">
        <div class="col-12 column_padding_card">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="viewList" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tabularView" role="tab" aria-controls="tabularView" aria-selected="true">Tabular View</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"  href="#cardView" role="tab" aria-controls="cardView" aria-selected="false">Card View</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body" style="margin-bottom: 4rem;">
                 
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabularView" role="tabpanel">
                            <div class="table-responsive">
                            <form action="<?php echo base_url(); ?>addStudentInternalMarkByStaff" method="POST" id="addInternalMarK">
                        <?php 
                            $labStatus = 'false';
                            $pass_count = 0;
                            $fail_count = 0;
                            $absent_count = 0;
                            $exampted_count = 0;

                            if($examInfo->lab_status == "YES"){
                                $labStatus = true;
                                $max_lab_mark = $examInfo->max_marks_lab;
                                $min_mark_pass = $examInfo->min_marks;
                                $max_mark_theory = $examInfo->max_marks;
                                $lab_pass_mark = $examInfo->min_marks_lab;
                            }else{
                                $min_mark_pass = $examInfo->min_marks;
                                $max_mark_theory = $examInfo->max_marks;
                                $labStatus = false;  
                            }
                            $exam_type = $examInfo->exam_type;

                            // $pass_class_min = 35;
                            // $pass_class_max = 49;
                            // $second_class_min_mark = 50;
                            // $second_class_max_mark = 59;
                            // $first_class_min_mark = 60;
                            // $first_class_max_mark = 84;
                            // $dest_min_mark = 85;
                            // $dest_max_mark = 100;
                            $pass_class_min = 35;
                            $pass_class_max = 49;
                            $second_class_min_mark = 50;
                            $second_class_max_mark = 59;
                            $first_class_min_mark = 60;
                            $first_class_max_mark = 84;
                            $dest_min_mark = 85;
                            $dest_max_mark = 100;
                        ?>
                        <table class="table table-bordered text-dark tblnavigate">
                            <thead class="text-center">
                                <tr class="table_row_background">
                                    <!-- <th width="130">Register No.</th> -->
                                    <th width="100">Student ID</th>
                                    <th>Name</th>
                                    <th width="200">Obt Theory Mark</th>
                                    <?php
                                     if($labStatus == true){
                                      ?>
                                    <th width="200">Obt Lab Mark</th>
                                    <?php 
                                     } 
                                     ?>
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
                                <input type="hidden" value="<?php echo $term_name; ?>" name="term_name" />
                                <input type="hidden" value="<?php echo $section_name; ?>" name="section_name" />
                                <input type="hidden" value="<?php echo $labStatus; ?>" id="lab_status" />
                                <input type="hidden" value="<?php echo $subject_code; ?>" name="subject_id" />
                                <input type="hidden" value="<?php echo $stream_name; ?>" name="stream_name" />
                                <input type="hidden" value="<?php echo $section_row_id; ?>" name="section_row_id" />
                                <input type="hidden" value="<?php echo $examInfo->row_id; ?>" name="exam_type" />


                                <input type="hidden" value="<?php echo $staff_subject_row_id; ?>" name="staff_subject_row_id" />
                                <input type="hidden" value="<?php echo $max_mark_theory; ?>" id="max_theory_mark" />
                                <input type="hidden" value="<?php echo $max_lab_mark; ?>" id="max_mark_lab" />
                                <input type="hidden" value="<?php echo $min_mark_pass; ?>" id="min_mark_pass" />
                                <input type="hidden" value="<?php echo $lab_pass_mark; ?>" id="lab_pass_mark" />
                                
                                <?php foreach($studentsInfo as $record) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $record->student_id; ?></td>
                                    <td><?php echo strtoupper($record->student_name); ?></td>
                                    <?php
                                            $mark_status = false;
                                            $update_mark_status = false;
                                            $total_mark = 0;
                                            if(!empty($studentMarkInfo)){ 
                                                foreach($studentMarkInfo as $mark){
                                                    $student_id = trim($mark->student_id);
                                                        $mark_obt_theory = trim($mark->obt_theory_mark);
                                                        $lab_mark_obt = trim($mark->obt_lab_mark);?>

                                      <td>
                                           <input value="<?php echo $mark_obt_theory;  ?>"
                                            style="font-size: 15px;font-weight: 700 !important;" maxlength="5"
                                            onkeyup="getTotalMarks('<?php echo $student_id; ?>')"
                                            onkeypress="return isNumberKey(event)"
                                            id="obt_theory_mark_<?php echo $student_id; ?>"
                                            class="form-control input-sm numberonly mark_col_width"
                                            placeholder="Enter Theory Mark" type="text"
                                            name="obt_theory_mark_<?php echo $student_id; ?>" autocomplete="off" required />
                                    </td>

                                    <?php 
                                    if($labStatus == true){ 
                                            if(is_numeric($lab_mark_obt) && !empty($lab_mark_obt)) {
                                                $total_mark = $lab_mark_obt + $mark_obt_theory;
                                            }else{
                                                $total_mark = $mark_obt_theory;
                                            } 
                                          
                                            ?>
                                    <td>
                                        <input value="<?php echo $lab_mark_obt; ?>"
                                            style="font-size: 15px;font-weight: 700 !important;" maxlength="4"
                                            onkeyup="getTotalMarks('<?php echo $student_id; ?>')"
                                            onkeypress="return isNumberKey(event)"
                                            id="lab_obt_mark_<?php echo $student_id; ?>"
                                            class="form-control input-sm numberonly mark_col_width"
                                            placeholder="Enter Lab Mark" type="text"
                                            name="lab_obt_mark_<?php echo $student_id; ?>" autocomplete="off" />
                                    </td>
                                    <?php 
                                 } else{
                                                $total_mark = $mark_obt_theory;
                                            } 
                                            ?>

                                    <td> <select onchange="actionTaken('<?php echo $student_id; ?>')"
                                            class="form-control input-sm mark_col_width"
                                            id="other_action_<?php echo $student_id; ?>" name="other_action">
                                            <option value="">No Action</option>
                                        <option value="AB">Absent</option>
                                        <option value="AB-LAB">Absent lab</option>
                                        <option value="EXEM">Exemption</option>
                                        <option value="EXEM-LAB">Exemption Lab</option>
                                        <option value="MP">Malpractice</option>
                                        <option value="MP-LAB">Malpractice Lab</option>
                                        <option value="SAT">Shortage of Attendance</option>
                                        <option value="SAT-LAB">Shortage of Attendance Lab</option>
                                        <!-- <option value="ASGN">Assignment</option>
                                        <option value="ASGN-LAB">Assignment Lab</option> -->
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
                                                }else if($labStatus == true && $lab_mark_obt < $lab_pass_mark){
                                                    $count_fail_students++;
                                                    echo '<b style="color:red">FAIL</b>';
                                                } else if($mark_obt_theory < $min_mark_pass ){
                                                    $count_fail_students++;
                                                    echo '<b style="color:red">FAIL</b>';
                                                } 
                                                // else if($total_mark < 35) {
                                                //     $count_fail_students++;
                                                //     echo '<b style="color:red">FAIL</b>';
                                                // } 
                                                else {
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
                                   
                                    }
                                    } else { 
                                       
                                    $mark_status = true;
                                    $student_id = trim($record->student_id);

                                    $markExist = isMarkAlreadyAdded($con,$student_id,$subject_code,$exam_type,EXAM_YEAR);
                                    if(!empty($markExist)){
                                        $mark_obt_theory = trim($markExist['obt_theory_mark']);
                                        $lab_mark_obt = trim($markExist['obt_lab_mark']);
                                        $total_mark = $mark_obt_theory + $lab_mark_obt;
                                    }else{
                                        $mark_obt_theory = "";
                                        $lab_mark_obt = "";
                                        $total_mark = "";
                                    }
                                    ?><td>
                                    <input style="font-size: 15px;font-weight: 700 !important;" 
                                        onkeyup="getTotalMarks('<?php echo $student_id; ?>')"
                                        value="<?php echo $mark_obt_theory; ?>" onkeypress="return isNumberKey(event)"
                                        id="obt_theory_mark_<?php echo $student_id; ?>" data-student_id="<?=$student_id?>"
                                        class="form-control input-sm numberonly mark_col_width table_view_obtained_mark_new"
                                        placeholder="Enter Theory Mark" type="text" maxlength="5" 
                                        name="obt_theory_mark_<?php echo $student_id; ?>" autocomplete="off" />
                                </td>
                                <?php
                                 if($labStatus == 'true'){
                                       if(is_numeric($lab_mark_obt) && !empty($lab_mark_obt)) {
                                                $total_mark = $lab_mark_obt + $mark_obt_theory;
                                            }else{
                                                $total_mark = $mark_obt_theory;
                                            } 
                                            ?>  
                                    <td>
                                        <input value="<?php echo $lab_mark_obt; ?>"
                                            style="font-size: 15px;font-weight: 700 !important;" maxlength="4"
                                            onkeyup="getTotalMarks('<?php echo $student_id; ?>')"
                                            onkeypress="return isNumberKey(event)"
                                            id="lab_obt_mark_<?php echo $student_id; ?>"
                                            class="form-control input-sm numberonly mark_col_width"
                                            placeholder="Enter Lab Mark" type="text"
                                            name="lab_obt_mark_<?php echo $student_id; ?>" autocomplete="off" />
                                    </td>
                                    <?php 
                                } else{
                                               $total_mark = $mark_obt_theory;
                                            }
                                             ?>
                              
                                <td>
                                    <select onchange="actionTaken('<?php echo $student_id; ?>')"
                                        class="form-control input-sm mark_col_width"
                                        id="other_action_<?php echo $student_id; ?>" name="other_action">
                                        <option value="">No Action</option>
                                        <option value="AB">Absent</option>
                                        <option value="AB-LAB">Absent lab</option>
                                        <option value="EXEM">Exemption</option>
                                        <option value="EXEM-LAB">Exemption Lab</option>
                                        <option value="MP">Malpractice</option>
                                        <option value="MP-LAB">Malpractice Lab</option>
                                        <option value="SAT">Shortage of Attendance</option>
                                        <option value="SAT-LAB">Shortage of Attendance Lab</option>
                                        <!-- <option value="ASGN">Assignment</option>
                                        <option value="ASGN-LAB">Assignment Lab</option> -->
                                    </select>
                                </td>
                                <?php //log_message('debug','HGHGHG'.$total_mark); ?>
                                <td id="get_total_mark_<?php echo $student_id; ?>"><?php echo $total_mark; ?> </td>
                                <td id="result_<?php echo $student_id; ?>">
                                    <span style="color:red;">
                                    <?php //if($exam_type == 'MID_TERM'){ 
                                        if($labStatus == true) {?>
                                    <?php if((int)$mark_obt_theory >= $min_mark_pass && (int)$lab_mark_obt >= $lab_pass_mark){
                                        $pass_count++;
                                        echo "<b style='color:green'>PASS</b>";
                                    } else{
                                        if($mark_obt_theory == "AB" && $lab_mark_obt == "AB"){
                                            $absent_count++;
                                            echo "<b style='color:orange'>AB</b>"; 
                                          }else if($mark_obt_theory == "SAT" && $lab_mark_obt == "SAT"){
                                            echo "<b style='color:orange'>SAT</b>"; 
                                          }else if($mark_obt_theory == "MP" && $lab_mark_obt == "MP"){
                                            echo "<b style='color:orange'>MP</b>"; 
                                          }else if($mark_obt_theory == "EXEM" && $lab_mark_obt == "EXEM"){
                                            $exampted_count++;
                                            echo "<b style='color:orange'>EXEM</b>"; 
                                        //   } else if($mark_obt_theory < $min_mark_pass && $lab_mark_obt < $lab_pass_mark ){
                                        //     echo "<b style='color:red'>FAIL</b>"; 
                                        //     $fail_count++;
                                          } else if($mark_obt_theory != "" && $lab_mark_obt != ""){
                                            echo "<b style='color:red'>FAIL</b>"; 
                                            $fail_count++;
                                        }else {
                                            echo "<b style='color:orange'>Pending</b>"; 
                                        }
                                      
                                    } 
                                }else{
                                    if((int)$mark_obt_theory >= $min_mark_pass){

                                        $pass_count++;
                                        echo "<b style='color:green'>PASS</b>";
                                    }
                                    else{
                                        if($mark_obt_theory == "AB"){
                                            $absent_count++;
                                            echo "<b style='color:orange'>AB</b>"; 
                                          }else if($mark_obt_theory == "SAT"){
                                            echo "<b style='color:orange'>SAT</b>"; 
                                          }else if($mark_obt_theory == "MP"){
                                            echo "<b style='color:orange'>MP</b>"; 
                                          }else if($mark_obt_theory == "EXEM"){
                                            $exampted_count++;
                                            echo "<b style='color:orange'>EXEM</b>"; 
                                        //   } else if($mark_obt_theory < $min_mark_pass){
                                        //     echo "<b style='color:red'>FAIL</b>"; 
                                        //     $fail_count++;
                                          } else if($mark_obt_theory != ""){
                                            echo "<b style='color:red'>FAIL</b>"; 
                                            $fail_count++;
                                        }else {
                                            echo "<b style='color:orange'>Pending</b>"; 
                                        }
                                      
                                    } 
                                } 
                                 
                                //  }else{

                                //      if($mark_obt_theory >= $min_mark_pass){
                                //         $pass_count++;
                                //         echo "<b style='color:green'>PASS</b>";
                                //     }
                                   
                                //     else{
                                //         if($mark_obt_theory == "AB"){
                                //             $absent_count++;
                                //             echo "<b style='color:orange'>AB</b>"; 
                                //           }else if($mark_obt_theory == "SAT"){
                                //             echo "<b style='color:orange'>SAT</b>"; 
                                //           }else if($mark_obt_theory == "MP"){
                                //             echo "<b style='color:orange'>MP</b>"; 
                                //           }else if($mark_obt_theory == "EXEM"){
                                //             $exampted_count++;
                                //             echo "<b style='color:orange'>EXEM</b>"; 
                                //           } else if($mark_obt_theory != ""){
                                //             echo "<b style='color:red'>FAIL</b>"; 
                                //             $fail_count++;
                                //         }else {
                                //             echo "<b style='color:orange'>Pending</b>"; 
                                //         }
                                      
                                //     } 

                                //  } ?>
                                    </span>
                                </td>
                                <?php } ?>
                                </tr>
                                <?php } } else { ?>
                                <td colspan="7" class="alert  text-center card_heading_title">
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
                                <button data-toggle="modal" data-target="#analyzeModal"
                                    type="button" class="btn btn-md btn-primary float-left">Analyze Section</button>
                            </div>
                            <div class="col-lg-6 ">
                                <button class="btn btn-success btn-md float-right" id="submitMark"
                                    type="submit">Update</button>
                            </div>
                            <?php if($update_mark_status == true){ ?>
                            <?php } ?>
                        </div>
                        <?php } 
                    
                            if(!empty($studentsInfo)){
                                ?>
                        <div class="row text-center mt-2" style="font-size: 20px;">
                            <div class="col-lg-3 col-sm-6 col-md-4 mb-2">
                                Total: <b><?php echo count($studentsInfo); ?></b>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-md-4 mb-2">
                                PASS: <b style="color:green;"><?php echo $pass_count; ?></b>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-md-4 mb-2">
                                FAIL: <b style="color:red;"><?php echo $fail_count; ?></b>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-md-4 mb-2">
                                ABSENT: <b style="color:red;"><?php echo $absent_count; ?></b>
                            </div>
                            
                        </div>
                        <?php } ?>
                    </form>
                            </div>
                        </div>                        
                        <div class="tab-pane" id="cardView" role="tabpanel" aria-labelledby="cardView-tab"> 
                            <div class="card_view card">
                                <?php
                                    if(!empty($studentsInfo)){ ?>
                                        <div class="card_view_student_list">
                                            <?php
                                                $colorCodes = ['#212529', '#09631e', '#5a26a5', '#0f9eb5', '#d26e06'];
                                                if(!empty($studentsInfo)){
                                                    // $key = 0;
                                                     foreach($studentsInfo as $key=>$record) { 
                                                        $student_id = trim($record->student_id);
                                                
                                                        $stdInfo = isMarkAlreadyAdded($con,$student_id,$subject_code,$exam_type,EXAM_YEAR);
                                                        if(!empty($stdInfo)){
                                                            $mark_obt_theory = trim($stdInfo['obt_theory_mark']);
                                                            $lab_mark_obt = trim($stdInfo['obt_lab_mark']);
                                                            $total_mark = $mark_obt_theory + $lab_mark_obt;
                                                        }else{
                                                            $mark_obt_theory = "";
                                                            $lab_mark_obt = "";
                                                            $total_mark = "";
                                                        }
                                                        $tempInputValue = "";
                                                        $tempInputValue_Lab = "";
                                                        $tempResultStatus = "PENDING";
                                                        $tempResultClass = "";
                                                        $temptActionValue = "";
                                                        $temptActionValueLab = "";
                                                        if(in_array($stdInfo['obt_theory_mark'], $actionsList)){
                                                            $temptActionValue = $stdInfo['obt_theory_mark'];
                                                            $tempResultStatus =  $temptActionValue;
                                                            $tempResultClass = $stdInfo['obt_theory_mark'];
                                                        }else{
                                                            $tempInputValue = $stdInfo['obt_theory_mark'];
                                                            $tempInputValue_Lab = $stdInfo['obt_theory_lab'];
                                                            if(!empty($tempInputValue)){
                                                                if($tempInputValue >= $min_marks){
                                                                    $tempResultStatus =  $stdInfo['obt_theory_mark'];
                                                                    $tempResultClass = $stdInfo['obt_theory_mark'];
                                                                }else{
                                                                    $tempResultStatus =  $stdInfo['obt_theory_mark'];
                                                                    $tempResultClass = $stdInfo['obt_theory_mark'];
                                                                }
                                                            }
                                                        }
                                                        if(in_array($stdInfo['obt_lab_mark'], $actionsList)){
                                                            $temptActionValueLab = $stdInfo['obt_lab_mark'];
                                                            // $tempResultStatus =  $temptActionValue;
                                                            // $tempResultClass = $stdInfo['obt_theory_mark'];
                                                        }else{
                                                            // $tempInputValue = $stdInfo['obt_theory_mark'];
                                                            // $tempInputValue_Lab = $stdInfo['obt_theory_lab'];
                                                            // if(!empty($tempInputValue)){
                                                            //     if($tempInputValue >= $min_marks){
                                                            //         $tempResultStatus =  $stdInfo['obt_theory_mark'];
                                                            //         $tempResultClass = $stdInfo['obt_theory_mark'];
                                                            //     }else{
                                                            //         $tempResultStatus =  $stdInfo['obt_theory_mark'];
                                                            //         $tempResultClass = $stdInfo['obt_theory_mark'];
                                                            //     }
                                                            // }
                                                        }
                                                        $tempABCls = "";
                                                        $tempEXEMls = "";
                                                        $tempMPCls = "";
                                                        $tempSATCls = "";

                                                        $tempABCls_lab = "";
                                                        $tempEXEMls_lab = "";
                                                        $tempMPCls_lab = "";
                                                        $tempSATCls_lab = "";
                                                        if($temptActionValue == "AB") $tempABCls = "active";
                                                        else if($temptActionValue == "EXEM") $tempEXEMls = "active";
                                                        else if($temptActionValue == "MP") $tempMPCls = "active";
                                                        else if($temptActionValue == "SAT") $tempSATCls = "active";

                                                        if($temptActionValueLab == "AB") $tempABCls_lab = "active";
                                                        else if($temptActionValueLab == "EXEM") $tempEXEMls_lab = "active";
                                                        else if($temptActionValueLab == "MP") $tempMPCls_lab = "active";
                                                        else if($temptActionValueLab == "SAT") $tempSATCls_lab = "active";
                                                        $colorCodeKey = fmod($key, 5);

                                                        if($key === 0){?>
                                                           <div class="student active" student-id="<?=$student_id?>" data-student_id="<?=$student_id?>" student-color="<?=$colorCodes[$colorCodeKey]?>">
                                                                <div class="card_view_head">
                                                                    <h5 class="dynamic_color"><?=$student_id?></h5>
                                                                    <h5 class="dynamic_color"><?=$record->student_name ?></h5>
                                                                </div>
                                                                <div class="mt-2">
                                                                    <h6 style="color: rgb(84, 47, 19);">Actions</h6>
                                                                    <div class="action-badges" data-student_id="<?=$student_id?>">
                                                                        <span class="badge card_view_student_exam_action <?='student_'.$student_id?> <?=$tempABCls?>" data-action_id="AB" data-student_id="<?=$student_id?>">
                                                                            Absent
                                                                            <span><i class="far fa-check-circle"></i></span>
                                                                        </span>
                                                                        <span class="badge card_view_student_exam_action <?='student_'.$student_id?> <?=$tempEXEMls?>" data-action_id="EXEM" data-student_id="<?=$student_id?>">
                                                                            Exemption
                                                                            <span><i class="far fa-check-circle"></i></span>
                                                                        </span>
                                                                        <span class="badge card_view_student_exam_action <?='student_'.$student_id?> <?=$tempMPCls?>" data-action_id="MP" data-student_id="<?=$student_id?>">
                                                                            Malpractice
                                                                            <span><i class="far fa-check-circle"></i></span>
                                                                        </span>
                                                                        <span class="badge card_view_student_exam_action <?='student_'.$student_id?> <?=$tempSATCls?>" data-action_id="SAT" data-student_id="<?=$student_id?>">
                                                                            Shortage of Attendance
                                                                            <span><i class="far fa-check-circle"></i></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-3">
                                                                    <h6 style="color: rgb(84, 47, 19);">Obtained Mark</h6>                                            
                                                                    <input class="card_view_obtained_mark" type="number" 
                                                                        id="<?='card_view_obtained_mark_'.$student_id?>"
                                                                        data-student_id="<?=$student_id?>"
                                                                        value="<?=$tempInputValue?>"
                                                                        placeholder="Enter obtained mark"
                                                                        <?php
                                                                            if(!empty($temptActionValue)){
                                                                                echo 'disabled';
                                                                            }
                                                                        ?>
                                                                    >
                                                                    <h6 class="error-hint display-none">Please enter valid mark.</h6>
                                                                    <span class="focus-border">
                                                                        <i></i>
                                                                    </span>
                                                                </div>
                                                                <?php if($labStatus == true){ ?>

                                                                <div class="mt-2">
                                                                    <h6 style="color: rgb(84, 47, 19);">Actions</h6>
                                                                    <div class="action-badges" data-student_id="<?=$student_id?>">
                                                                        <span class="badge card_view_student_exam_action_lab <?='student_'.$student_id?> <?=$tempABCls_lab?>" data-action_id="AB" data-student_id="<?=$student_id?>">
                                                                            Absent
                                                                            <span><i class="far fa-check-circle"></i></span>
                                                                        </span>
                                                                        <span class="badge card_view_student_exam_action_lab <?='student_'.$student_id?> <?=$tempEXEMls_lab?>" data-action_id="EXEM" data-student_id="<?=$student_id?>">
                                                                            Exemption
                                                                            <span><i class="far fa-check-circle"></i></span>
                                                                        </span>
                                                                        <span class="badge card_view_student_exam_action_lab <?='student_'.$student_id?> <?=$tempMPCls_lab?>" data-action_id="MP" data-student_id="<?=$student_id?>">
                                                                            Malpractice
                                                                            <span><i class="far fa-check-circle"></i></span>
                                                                        </span>
                                                                        <span class="badge card_view_student_exam_action_lab <?='student_'.$student_id?> <?=$tempSATCls_lab?>" data-action_id="SAT" data-student_id="<?=$student_id?>">
                                                                            Shortage of Attendance
                                                                            <span><i class="far fa-check-circle"></i></span>
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <div class="mt-3">
                                                                    <h6 style="color: rgb(84, 47, 19);">Obtained Lab Mark</h6>                                            
                                                                    <input class="card_view_obtained_mark_lab" type="number" 
                                                                        id="<?='card_view_obtained_mark_lab_'.$student_id?>"
                                                                        data-student_id="<?=$student_id?>"
                                                                        value="<?=$tempInputValue_Lab?>"
                                                                        placeholder="Enter obtained mark"
                                                                        <?php
                                                                            if(!empty($temptActionValueLab)){
                                                                                echo 'disabled';
                                                                            }
                                                                        ?>
                                                                    >
                                                                    <h6 class="error-hint display-none">Please enter valid mark.</h6>
                                                                    <span class="focus-border">
                                                                        <i></i>
                                                                    </span>                                                            
                                                                </div>
                                                                <?php } ?>

                                                                <div class="mt-1">
                                                                    <h6 class="dynamic_color"
                                                                            style="
                                                                                    display: flex;
                                                                                    justify-content: center;
                                                                                "
                                                                    >
                                                                        Result:
                                                                        <span class="exam_result ml-1 <?=$tempResultClass?>"
                                                                            id="<?='card_view_exam_result_'.$student_id?>"
                                                                        >
                                                                            <?=strtoupper($tempResultStatus);?>
                                                                        </span>
                                                                    </h6>
                                                                </div>
                                                            </div>  
                                                        <?php }else{ ?>
                                                            <div class="student" student-id="<?=$student_id?>" data-student_id="<?=$student_id?>" student-color="<?=$colorCodes[$colorCodeKey]?>">
                                                                <div class="card_view_head">
                                                                    <h5 class="dynamic_color"><?=$student_id?></h5>
                                                                    <h5 class="dynamic_color"><?=$record->student_name ?></h5>
                                                                </div>
                                                                <div class="mt-2">
                                                                    <h6 style="color: rgb(84, 47, 19);">Actions</h6>
                                                                    <div class="action-badges" data-student_id="<?=$student_id?>">
                                                                        <span class="badge card_view_student_exam_action <?='student_'.$student_id?> <?=$tempABCls?>" data-action_id="AB" data-student_id="<?=$student_id?>">
                                                                            Absent
                                                                            <span><i class="far fa-check-circle"></i></span>
                                                                        </span>
                                                                        <span class="badge card_view_student_exam_action <?='student_'.$student_id?> <?=$tempEXEMls?>" data-action_id="EXEM" data-student_id="<?=$student_id?>">
                                                                            Exemption
                                                                            <span><i class="far fa-check-circle"></i></span>
                                                                        </span>
                                                                        <span class="badge card_view_student_exam_action <?='student_'.$student_id?> <?=$tempMPCls?>" data-action_id="MP" data-student_id="<?=$student_id?>">
                                                                            Malpractice
                                                                            <span><i class="far fa-check-circle"></i></span>
                                                                        </span>
                                                                        <span class="badge card_view_student_exam_action <?='student_'.$student_id?> <?=$tempSATCls?>" data-action_id="SAT" data-student_id="<?=$student_id?>">
                                                                            Shortage of Attendance
                                                                            <span><i class="far fa-check-circle"></i></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-3">
                                                                    <h6 style="color: rgb(84, 47, 19);">Obtained Mark</h6>                                            
                                                                    <input class="card_view_obtained_mark" type="number" 
                                                                        id="<?='card_view_obtained_mark_'.$student_id?>"
                                                                        data-student_id="<?=$student_id?>"
                                                                        value="<?=$tempInputValue?>"
                                                                        placeholder="Enter obtained mark"
                                                                        <?php
                                                                            if(!empty($temptActionValue)){
                                                                                echo 'disabled';
                                                                            }
                                                                        ?>
                                                                    >
                                                                    <h6 class="error-hint display-none">Please enter valid mark.</h6>
                                                                    <span class="focus-border">
                                                                        <i></i>
                                                                    </span>
                                                                </div>
                                                                <?php if($labStatus == true){ ?>

                                                                <div class="mt-2">
                                                                    <h6 style="color: rgb(84, 47, 19);">Actions</h6>
                                                                    <div class="action-badges" data-student_id="<?=$student_id?>">
                                                                        <span class="badge card_view_student_exam_action_lab <?='student_'.$student_id?> <?=$tempABCls_lab?>" data-action_id="AB" data-student_id="<?=$student_id?>">
                                                                            Absent
                                                                            <span><i class="far fa-check-circle"></i></span>
                                                                        </span>
                                                                        <span class="badge card_view_student_exam_action_lab <?='student_'.$student_id?> <?=$tempEXEMls_lab?>" data-action_id="EXEM" data-student_id="<?=$student_id?>">
                                                                            Exemption
                                                                            <span><i class="far fa-check-circle"></i></span>
                                                                        </span>
                                                                        <span class="badge card_view_student_exam_action_lab <?='student_'.$student_id?> <?=$tempMPCls_lab?>" data-action_id="MP" data-student_id="<?=$student_id?>">
                                                                            Malpractice
                                                                            <span><i class="far fa-check-circle"></i></span>
                                                                        </span>
                                                                        <span class="badge card_view_student_exam_action_lab <?='student_'.$student_id?> <?=$tempSATCls_lab?>" data-action_id="SAT" data-student_id="<?=$student_id?>">
                                                                            Shortage of Attendance
                                                                            <span><i class="far fa-check-circle"></i></span>
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <div class="mt-3">
                                                                    <h6 style="color: rgb(84, 47, 19);">Obtained Lab Mark</h6>                                            
                                                                    <input class="card_view_obtained_mark_lab" type="number" 
                                                                        id="<?='card_view_obtained_mark_lab_'.$student_id?>"
                                                                        data-student_id="<?=$student_id?>"
                                                                        value="<?=$tempInputValue_Lab?>"
                                                                        placeholder="Enter obtained mark"
                                                                        <?php
                                                                            if(!empty($temptActionValueLab)){
                                                                                echo 'disabled';
                                                                            }
                                                                        ?>
                                                                    >
                                                                    <h6 class="error-hint display-none">Please enter valid mark.</h6>
                                                                    <span class="focus-border">
                                                                        <i></i>
                                                                    </span>                                                            
                                                                </div>
                                                                <?php } ?>

                                                                <div class="mt-1">
                                                                    <h6 class="dynamic_color"
                                                                            style="
                                                                                    display: flex;
                                                                                    justify-content: center;
                                                                                "
                                                                    >
                                                                        Result:
                                                                        <span class="exam_result ml-1 <?=$tempResultClass?>"
                                                                            id="<?='card_view_exam_result_'.$student_id?>"
                                                                        >
                                                                            <?=strtoupper($tempResultStatus);?>
                                                                        </span>
                                                                    </h6>
                                                                </div>
                                                            </div>  
                                                        <?php }
                                                    }
                                                }
                                            ?>
                                        </div>
                                        <div class="footer mt-3">
                                            <button class="btn navigation_btn" id="prev" href="#" ripple="" ripple-color="#666666">Prev</button>
                                            <span class="student_stats">
                                                <span class="dynamic_color" id="currentCardIndex">1</span>
                                                <span>/</span>
                                                <span class="dynamic_color" id="maxCardIndex"><?=count($studentsInfo);?></span>
                                            </span>
                                            <button class="btn navigation_btn" id="next" href="#" ripple="" ripple-color="#666666">Next</button>
                                        </div>
                                    <?php }else{?>
                                        <h6 class="mt-1">Details Not Found..!</h6>
                                    <?php }                                
                                ?>
                            </div>
                        </div>

                    </div>
                    <?php 
                        if(!empty($studentsInfo)){ 
                            ?>
                            <div class="row mt-2">
                                <!-- <div class="col-6">
                                    <button class="btn btn-danger form-submit-btn mb-1 mt-2">Final Submit</button>
                                </div> -->
                                <!-- <div class="col-6">
                                    <button class="btn btn-success form-save-btn mb-1 btn-block">SAVE</button>
                                </div> -->
                        </div>
                      <?php }
                    ?>
                </div>
                
            </div>
        </div>
    </div>
    <!-- Modal -->
    <style>
        .modal-content.dynamic_width{
            width: 600px;
        }
        @media only screen and (max-width: 900px) {
            .modal-content.dynamic_width{
                width: 450px;
            }
        }
        @media only screen and (max-width: 500px) {
            .modal-content.dynamic_width{
                width: 350px;
            }
        }
    </style>
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable " role="document">
            <div class="modal-content dynamic_width">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0 text-center"
                    style="
                        height: 450px;
                        overflow: auto;
                    "
                >
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Admission No</th>
                                <th>Name</th>
                                <th>Obt. Mark</th>
                            </tr>
                        </thead>
                        <tbody id="confirmationTblBody">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="confirmationBtn">Confirm</button>
                </div>
            </div>
        </div>
    </div>
<!-- </div> -->
<?php
function isMarkAlreadyAdded($con,$student_id,$subject_id,$exam_type,$exam_year){
    $query = "SELECT * FROM tbl_college_internal_exam_marks as mark 
    WHERE mark.student_id = '$student_id' AND mark.subject_code = '$subject_id' 
    AND mark.exam_type = '$exam_type' AND mark.is_deleted = 0 AND mark.exam_year = '$exam_year'";
    $pdo_statement = $con->prepare($query);
    $pdo_statement->execute();
    return $pdo_statement->fetch();
}
?>
<script>
    document.addEventListener('keydown', function(e) {
        if(e.target, $(e.target).hasClass('marks-entry-input')){
            const tdPosition = $(e.target).parent('td').index();
            if(e.keyCode === 40){
                const nextInput = $(e.target).closest('tr').next('tr').find(`td:eq(${tdPosition})`).find('input.marks-entry-input');
                nextInput.focus();
            }
            else if(e.keyCode === 38){
                const prevInput = $(e.target).closest('tr').prev('tr').find(`td:eq(${tdPosition})`).find('input.marks-entry-input');
                prevInput.focus();
            }else return;
        }else return;
    });
    $("#confirmationBtn").click(()=>{
        $('#staff_updated_status').val('1');
        $("#addInternalMarK").submit();
    });

    $(".form-save-btn").click(()=>{
        $("#addInternalMarK").submit();
         $(".table_view_student_list > tr").each((tind,  ele)=>{
            let tempAdmissionNo = $(ele).find('td.admission_no_td').html(); 
            let tempStdName = $(ele).find('td.student_name_td').html();
            // let tempMark = $(ele).find('td.obt_theory_mark_td > input').val();
            let tempAction = $(ele).find('td.action_td > select').val();
               var resultTypes = $("#result_type").val();
            if(resultTypes == 'MARKS'){
                  let tempMarkVal = $(ele).find('td.obt_theory_mark_td > input').val();
                  var tempMark = tempMarkVal;
            }else{
                  let tempMarkVal = $(ele).find('td.obt_theory_grade_mark_td > select').val();
                 var tempMark = tempMarkVal;
            }
        
            tempMark = (tempAction != "") ?  tempAction : tempMark;
            tempMark = tempMark || "PENDING";
    });
   });      
    $(".form-submit-btn").on('click', ()=>{
        let confirmTrs = "";
        $(".table_view_student_list > tr").each((tind,  ele)=>{
            let tempAdmissionNo = $(ele).find('td.admission_no_td').html();
            let tempStdName = $(ele).find('td.student_name_td').html();
            // let tempMark = $(ele).find('td.obt_theory_mark_td > input').val();
            let tempAction = $(ele).find('td.action_td > select').val();
               var resultTypes = $("#result_type").val();
            if(resultTypes == 'MARKS'){
                  let tempMarkVal = $(ele).find('td.obt_theory_mark_td > input').val();
                  var tempMark = tempMarkVal;
            }else{
                  let tempMarkVal = $(ele).find('td.obt_theory_grade_mark_td > select').val();
                 var tempMark = tempMarkVal;
            }
        
            tempMark = (tempAction != "") ?  tempAction : tempMark;
           
            tempMark = tempMark || "PENDING";
            confirmTrs += `<tr><td>${tempAdmissionNo}</td><td>${tempStdName}</td><td>${tempMark}</td></tr>`;
        });
        $("#confirmationTblBody").html(confirmTrs);
        $("#confirmationModal").modal('show');
    });
    const setExamResult = (studentID, mark="") =>{
        const elementSelector1 = "#obt_theory_mark_"+studentID;
        const elementSelector2 = "#card_view_exam_result_"+studentID;
        
        let minMark = "<?=$min_mark_pass;?>";
        minMark = Number(minMark);
        if(mark != ""){
        //    if(markType == 'MARKS'){
                if(mark >= minMark){
                    $(elementSelector1).val(mark);
                    $(elementSelector1).removeClass('fail');
                    $(elementSelector1).addClass('pass');
                    $(elementSelector2).html(mark);
                    $(elementSelector2).removeClass('fail');
                    $(elementSelector2).addClass('pass');
                }else{
                    $(elementSelector1).val(mark);
                    $(elementSelector1).removeClass('pass');
                    $(elementSelector1).addClass('fail');
                    $(elementSelector2).html(mark);
                    $(elementSelector2).removeClass('pass');
                    $(elementSelector2).addClass('fail');
                }
        }else{
            $(elementSelector1).val('');
            $(elementSelector1).removeClass('pass');
            $(elementSelector1).removeClass('fail');
            $(elementSelector2).html('PENDING');
            $(elementSelector2).removeClass('pass');
            $(elementSelector2).removeClass('fail');
        }              
    }


    const setExamResultLab = (studentID, mark="") =>{
        const elementSelector1 = "#lab_obt_mark_"+studentID;
        const elementSelector2 = "#card_view_exam_result_"+studentID;
        
        let minMark = "<?=$lab_pass_mark;?>";
        minMark = Number(minMark);
        if(mark != ""){
        //    if(markType == 'MARKS'){
                if(mark >= minMark){
                    $(elementSelector1).val(mark);
                    $(elementSelector1).removeClass('fail');
                    $(elementSelector1).addClass('pass');
                    $(elementSelector2).html(mark);
                    $(elementSelector2).removeClass('fail');
                    $(elementSelector2).addClass('pass');
                }else{
                    $(elementSelector1).val(mark);
                    $(elementSelector1).removeClass('pass');
                    $(elementSelector1).addClass('fail');
                    $(elementSelector2).html(mark);
                    $(elementSelector2).removeClass('pass');
                    $(elementSelector2).addClass('fail');
                }
        }else{
            $(elementSelector1).val('');
            $(elementSelector1).removeClass('pass');
            $(elementSelector1).removeClass('fail');
            $(elementSelector2).html('PENDING');
            $(elementSelector2).removeClass('pass');
            $(elementSelector2).removeClass('fail');
        }              
    }


    const setExamActionResult = (studentID, actionVal) =>{
        const elementSelector1 = "#obt_theory_mark_"+studentID;
        const elementSelector2 = "#card_view_exam_result_"+studentID;
        $(elementSelector1).val(actionVal);
        $(elementSelector1).removeClass('pass');
        $(elementSelector1).addClass('fail');
        $(elementSelector2).html(actionVal);
        $(elementSelector2).removeClass('pass');
        $(elementSelector2).addClass('fail');
    }

    const setExamActionResultLab = (studentID, actionVal) =>{
        const elementSelector1 = "#lab_obt_mark_"+studentID;
        const elementSelector2 = "#card_view_exam_result_"+studentID;
        $(elementSelector1).val(actionVal);
        $(elementSelector1).removeClass('pass');
        $(elementSelector1).addClass('fail');
        $(elementSelector2).html(actionVal);
        $(elementSelector2).removeClass('pass');
        $(elementSelector2).addClass('fail');
    }
    const updateCardViewInput = (studentID, inputVal) =>{
        const inputElementSelector = "#card_view_obtained_mark_"+studentID;
        const actionElementsSelector = ".card_view_student_exam_action.student_"+studentID;
        $(inputElementSelector).prop('disabled', false);
        $(inputElementSelector).val(inputVal)
        $(actionElementsSelector).removeClass('active');
    }
    const updateCardViewAction = (studentID, actionVal) =>{
        const actionElementsSelector = ".card_view_student_exam_action.student_"+studentID;
        const inputElementSelector = "#card_view_obtained_mark_"+studentID;
        $(actionElementsSelector).removeClass('active');
        $(inputElementSelector).val('');
        if(actionVal == ""){
            $(inputElementSelector).prop('disabled', false);
        }else{
            $(actionElementsSelector).each((ind, element)=>{
                if($(element).data('action_id') === actionVal){
                    $(element).addClass('active');
                    $(inputElementSelector).prop('disabled', true);
                }
            });
        }
    }
    const updateCardViewActionLab = (studentID, actionVal) =>{
        const actionElementsSelector = ".card_view_student_exam_action_lab.student_"+studentID;
        const inputElementSelector = "#card_view_obtained_mark_lab_"+studentID;
        $(actionElementsSelector).removeClass('active');
        $(inputElementSelector).val('');
        if(actionVal == ""){
            $(inputElementSelector).prop('disabled', false);
        }else{
            $(actionElementsSelector).each((ind, element)=>{
                if($(element).data('action_id') === actionVal){
                    $(element).addClass('active');
                    $(inputElementSelector).prop('disabled', true);
                }
            });
        }
    }
    const updateTableViewInput = (studentID, inputVal) =>{
        const inputElementSelector = "#table_view_obtained_mark_"+studentID;
        $(inputElementSelector).prop('disabled', false);
        $(inputElementSelector).val(inputVal);
    }
    const updateTableViewAction = (studentID, actionVal) =>{
        const actionElementSelector = "#table_view_student_exam_action_"+studentID;
        const inputElementSelector = "#table_view_obtained_mark_"+studentID;
        $(actionElementSelector).val(actionVal);
        $(inputElementSelector).val('');
        if(actionVal == ""){
            $(inputElementSelector).prop('disabled', false);
        }else{
            $(inputElementSelector).prop('disabled', true);            
        }
    }
    $('.table_view_obtained_mark, .card_view_obtained_mark').on('keyup', function(evt){
        let maxMark = "<?=$max_mark_theory;?>" || 100;
        maxMark = Number(maxMark) || 100;
        let enteredMark = $(this).val() || "";
        $(this).siblings('.error-hint').removeClass('display-block');
        if(enteredMark != ""){
            enteredMark = Number(enteredMark) || (maxMark + 1);
            if(enteredMark > maxMark){
                $(this).siblings('.error-hint').addClass('display-block');
            }
        }
    });
    $('.card_view_obtained_mark_lab').on('keyup', function(evt){
        let maxMark = "<?=$max_lab_mark;?>" || 100;
        maxMark = Number(maxMark) || 100;
        let enteredMark = $(this).val() || "";
        $(this).siblings('.error-hint').removeClass('display-block');
        if(enteredMark != ""){
            enteredMark = Number(enteredMark) || (maxMark + 1);
            if(enteredMark > maxMark){
                $(this).siblings('.error-hint').addClass('display-block');
            }
        }
    });
    $('.table_view_obtained_mark, .card_view_obtained_mark').on('keypress', function(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    });
    $('.table_view_obtained_mark_new').on('change', function(){
        let enteredMark = $(this).val();
        const stdID = $(this).data('student_id');
        // setExamResult(stdID, enteredMark);
        updateCardViewInput(stdID, $(this).val());
    });
    $('.card_view_obtained_mark').on('change', function(){
        let maxMark = "<?=$max_mark_theory;?>" || 100;
        maxMark = Number(maxMark) || 100;
        let enteredMark = $(this).val();
        let gradeType = $("#result_type").val();
        const stdID = $(this).data('student_id');
        enteredMark = Number(enteredMark) || "";
        if(enteredMark != ""){
            if(enteredMark > maxMark){
                $(this).val("");
                $(this).focus();
            }
          }
       
        
          setExamResult(stdID, enteredMark);
        updateTableViewInput(stdID, $(this).val());
    });

    $('.card_view_obtained_mark_lab').on('change', function(){
        let maxMark = "<?=$max_lab_mark;?>" || 100;
        maxMark = Number(maxMark) || 100;
        let enteredMark = $(this).val();
        let gradeType = $("#result_type").val();
        const stdID = $(this).data('student_id');
        enteredMark = Number(enteredMark) || "";
        if(enteredMark != ""){
            if(enteredMark > maxMark){
                $(this).val("");
                $(this).focus();
            }
          }
       
        
        setExamResultLab(stdID, enteredMark);
        updateTableViewInput(stdID, $(this).val());
    });

    $('.table_view_student_exam_action').on('change', function(){
        const actionVal = $(this).val();
        const stdID = $(this).data('student_id');
        const inputElementSelector = "#table_view_obtained_mark_"+stdID;
        if(actionVal != ""){
            $(inputElementSelector).val(""); 
            $(inputElementSelector).prop('disabled', true);
        }else{
            $(inputElementSelector).prop('disabled', false);
        }
        if(actionVal == ""){
            setExamResult(stdID, "");
        }else{
            setExamActionResult(stdID, actionVal);
        }
        updateCardViewAction(stdID, actionVal);
    });
    $(".card_view_student_exam_action").on('click', function(){ 
        const stdID = $(this).data('student_id');
        const inputElementSelector = "#card_view_obtained_mark_"+stdID;
        let actionVal = "";
        $(inputElementSelector).val('');
        if($(this).hasClass('active')){            
            $(inputElementSelector).prop('disabled', false);
            $(this).removeClass('active');
        }else{
            actionVal = $(this).data('action_id');
            $(inputElementSelector).prop('disabled', true);
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
        }
        if(actionVal == ""){
            setExamResult(stdID, "");
        }else{
            setExamActionResult(stdID, actionVal);
        }
        updateTableViewAction(stdID, actionVal);
    });

    $(".card_view_student_exam_action_lab").on('click', function(){
        const stdID = $(this).data('student_id');
        const inputElementSelector = "#card_view_obtained_mark_lab_"+stdID;
        let actionVal = "";
        $(inputElementSelector).val('');
        if($(this).hasClass('active')){            
            $(inputElementSelector).prop('disabled', false);
            $(this).removeClass('active');
        }else{
            actionVal = $(this).data('action_id');
            $(inputElementSelector).prop('disabled', true);
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
        }
        if(actionVal == ""){
            setExamResultLab(stdID, "");
        }else{
            setExamActionResultLab(stdID, actionVal);
        }
        updateTableViewAction(stdID, actionVal);
    });

    $("#viewList a").on("click", function (e) {
        e.preventDefault();
        $(this).tab("show");
    });
    $(document).ready(function () {
        function calcStudentHeight() {
            let getStudentHeight = $(".student.active").height();
            $("card_view_student_list").css({
                height: getStudentHeight
            });
        }
        function animateContentColor() {
            var getStudentColor = $(".student.active").attr("student-color");
            $(".dynamic_color").css({
                color: getStudentColor
            });

            $(".navigation_btn").css({
                color: getStudentColor
            });
        }
        animateContentColor();

        var studentItem = $(".student"),
        studentCurrentItem = studentItem.filter(".active");

        $("#next").on("click", function (e) {
            let currentCardIndex = $("#currentCardIndex").html();
            currentCardIndex = Number(currentCardIndex) || 0;
            e.preventDefault();
            var nextItem = studentCurrentItem.next();
            studentCurrentItem.removeClass("active");

            if (nextItem.length) {
                studentCurrentItem = nextItem.addClass("active");
                currentCardIndex++;
                $("#currentCardIndex").html(currentCardIndex);
            } else {
                studentCurrentItem = studentItem.first().addClass("active");
                $("#currentCardIndex").html(1);
            }

            // calcStudentHeight();
            animateContentColor();
        });

        $("#prev").on("click", function (e) {
            let currentCardIndex = $("#currentCardIndex").html();
            let maxCardIndex = $("#maxCardIndex").html();
            currentCardIndex = Number(currentCardIndex) || 0;
            e.preventDefault();
            var prevItem = studentCurrentItem.prev();

            studentCurrentItem.removeClass("active");

            if (prevItem.length) {
                studentCurrentItem = prevItem.addClass("active");
                currentCardIndex--;
                $("#currentCardIndex").html(currentCardIndex);
            } else {
                studentCurrentItem = studentItem.last().addClass("active");
                $("#currentCardIndex").html(maxCardIndex);
            }

            // calcStudentHeight();
            animateContentColor();
        });

        // Ripple
        $("[ripple]").on("click", function (e) {
            var rippleDiv = $('<div class="ripple" />'),
            rippleSize = 60,
            rippleOffset = $(this).offset(),
            rippleY = e.pageY - rippleOffset.top,
            rippleX = e.pageX - rippleOffset.left,
            ripple = $(".ripple");

            rippleDiv
            .css({
                top: rippleY - rippleSize / 2,
                left: rippleX - rippleSize / 2,
                background: $(this).attr("ripple-color")
            })
            .appendTo($(this));

            window.setTimeout(function () {
            rippleDiv.remove();
            }, 1900);
        });
    });
</script>

<script type="text/javascript">
var loader = '<img height="70" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';
var term_name = 'I';


jQuery(document).ready(function() {
    var term = $("#term_name").val();
    var stream = $(".stream_name").val();
    var staf_rowId = $("#staff_subject_row_id").val();
    var examType = $("#exam_type").val();

    $('#streamName').prop('disabled', 'disabled');
    if(stream != ''){
        $('#streamName').prop('required', true); 
        $('#streamName').prop('disabled', false);
        $('.loaderScreen').hide();
    }

    $('.loaderScreen').hide();
    // $('select').selectpicker();
    $(".numberonly").focus(function() {
        $(this).attr("type", "number")
    });
    $(".numberonly").blur(function() {
        $(this).attr("type", "text")
    });

    $("#submitMark").submit(function(e) {
        e.preventDefault();
    });
    
    $("#submitMark,#searchButton").click(function() {
        $('.loaderScreen').show();
    });
    $("#submitMark,#searchButton").click(function() {
        if(term == ''){
            $('.loaderScreen').hide();
        } else if(examType == ''){
            $('.loaderScreen').hide();
        } else if(stream == ''){
            $('.loaderScreen').hide();
        } else if(staf_rowId == ''){
            $('.loaderScreen').hide();
        } else if ($('#streamName').prop("disabled") == true) {
        } else{
            $('.loaderScreen').show();
        }
    });
    
    // $("#submitMark").click(function() {
    //     var isValid = true;
    //     $('#addInternalMarK input[type=text]').each(function(i,e) {
    //         if(e.value == '') {
    //             $('.loaderScreen').hide();
    //         }else{
    //             $('.loaderScreen').show();
    //         }
    //     });
    // });
    
    $(function() {
        $('#attendanceDate').datepicker({
            autoclose: true,
            endDate: "today",
            format: 'dd-mm-yyyy',
        });
    });

    $("#term_name,#streamName, #staff_subject_row_id").change(function(){
        var term_name = $("#term_name").val();
        var stream_name = $("#streamName").val();
        var staffSubjectRowId = $("#staff_subject_row_id").val(); 
        if(this.value != 0 && term_name != 0  && stream_name != 0){
            $('#exam_type').prop('disabled', false);
            $('#exam_type option:not(:first)').remove();
            $.ajax({
                url: '<?php echo base_url(); ?>/getExamType',
                type: 'POST',
                dataType: "json",
                data: { 
                    term_name : term_name,
                    stream_name : stream_name,
                    staffSubjectRowId : staffSubjectRowId
                },
                success: function(data) {
                    console.log(data);
                    //var examObject = JSON.parse(data);
                    var examObject = JSON.stringify(data)
                    var count = data.result.length;
                    if(count != 0){
                        for(var i=0; i<=count; i++){
                          if(data.result[i].exam_type != ''){
                                $("#exam_type").append(new Option(data.result[i].exam_type, data.result[i].row_id));
                            }else{
                                $("#exam_type").append(new Option(data.result[i].exam_name, data.result[i].row_id)); 
                            }
                        }
                    }else{
                        $('#exam_type').prop('disabled', 'disabled');
                    }
                }
            });
        }else{
            $('#exam_type').prop('disabled', 'disabled');
            $('#exam_type option:not(:first)').remove();
        } 
    });


    $("#term_name").change(function(){
        var term_name = $("#term_name").val()
        $('#streamName').prop('disabled', false);
        $('#streamName option:not(:first)').remove();
        $('#streamName option:selected').remove();
        $('#streamName').append('<option value="">Select Stream & Section</option>');
        // $('#exam_type option:selected').remove();
        if(term_name == 'II PUC'){
            $('#exam_type_two').show();
        }else{
            $('#exam_type_two').hide();
        }
        if(this.value != 0){
            $('#streamName').prop('disabled', false);
            $('#streamName option:not(:first)').remove();
            $.ajax({
            url: '<?php echo base_url(); ?>/getStreamSectionByTerm',
            type: 'POST',
            dataType: "json",
            data: { term_name : term_name },

            success: function(data) {
                //var examObject = JSON.parse(data);
                var examObject = JSON.stringify(data)
                var count = data.result.length;
                if(count != 0){
                    for(var i=0; i<=count; i++){
                        $("#streamName").append(new Option(data.result[i].stream_name +' - '+ data.result[i].section_name, data.result[i].row_id));
                    }
                }else{
                    $('#streamName').prop('disabled', 'disabled');
                }
            }
        });
        }else{
            $('#streamName').prop('disabled', 'disabled');
            $('#streamName option:not(:first)').remove();
            $('#streamName option:selected').remove();
            $('#streamName').append('<option value="">Select Stream & Section</option>');
            // $('#exam_type option:selected').remove();
        }
    });
});

function isNumberKey(evt) {
    //alert(mark_ent)
    
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode > 64 && charCode < 91 ) && (charCode < 48 || charCode > 57  || charCode.length < 4))
        return false;
    return true;
}

function actionTaken(student_id) {
    var value = $('#other_action_' + student_id).val();
    
   
     if(value == "AB-LAB") {
        // $("#result_" + student_id).html("<b style='color:red'>" + value + "</b>");
        // $("#get_total_mark_" + student_id).html("<b style='color:red'>" + value + "</b>");
        // $("#obt_theory_mark_" + student_id).val(value);
        // $("#obt_theory_mark_" + student_id).prop('readonly', false);
        $("#lab_obt_mark_" + student_id).val('AB');
        $("#lab_obt_mark_" + student_id).prop('readonly', false);
        updateCardViewActionLab(student_id, "AB");
    }   else if(value == "AB") {
        // $("#result_" + student_id).html("<b style='color:red'>" + value + "</b>");
        // $("#get_total_mark_" + student_id).html("<b style='color:red'>" + value + "</b>");
        $("#obt_theory_mark_" + student_id).val(value);
        $("#obt_theory_mark_" + student_id).prop('readonly', false);
        updateCardViewAction(student_id, "AB");
        // $("#lab_obt_mark_" + student_id).val('AB');
        // $("#lab_obt_mark_" + student_id).prop('readonly', false);
    } else if(value == "EXEM-LAB") {
        // $("#result_" + student_id).html("<b style='color:red'>" + value + "</b>");
        // $("#get_total_mark_" + student_id).html("<b style='color:red'>" + value + "</b>");
        // $("#obt_theory_mark_" + student_id).val(value);
        // $("#obt_theory_mark_" + student_id).prop('readonly', false);
        $("#lab_obt_mark_" + student_id).val('EXEM');
        $("#lab_obt_mark_" + student_id).prop('readonly', false);
        updateCardViewActionLab(student_id, "EXEM");
    }   else if(value == "EXEM") {
        // $("#result_" + student_id).html("<b style='color:red'>" + value + "</b>");
        // $("#get_total_mark_" + student_id).html("<b style='color:red'>" + value + "</b>");
        $("#obt_theory_mark_" + student_id).val(value);
        $("#obt_theory_mark_" + student_id).prop('readonly', false);
        updateCardViewAction(student_id, "EXEM");
        // $("#lab_obt_mark_" + student_id).val('AB');
        // $("#lab_obt_mark_" + student_id).prop('readonly', false);
    } else if(value == "MP-LAB") {
        // $("#result_" + student_id).html("<b style='color:red'>" + value + "</b>");
        // $("#get_total_mark_" + student_id).html("<b style='color:red'>" + value + "</b>");
        // $("#obt_theory_mark_" + student_id).val(value);
        // $("#obt_theory_mark_" + student_id).prop('readonly', false);
        $("#lab_obt_mark_" + student_id).val('MP');
        $("#lab_obt_mark_" + student_id).prop('readonly', false);
        updateCardViewActionLab(student_id, "MP");
    }   else if(value == "MP") {
        // $("#result_" + student_id).html("<b style='color:red'>" + value + "</b>");
        // $("#get_total_mark_" + student_id).html("<b style='color:red'>" + value + "</b>");
        $("#obt_theory_mark_" + student_id).val(value);
        $("#obt_theory_mark_" + student_id).prop('readonly', false);
        updateCardViewAction(student_id, "MP");
        // $("#lab_obt_mark_" + student_id).val('AB');
        // $("#lab_obt_mark_" + student_id).prop('readonly', false);
    }else if(value == "SAT-LAB") {
        // $("#result_" + student_id).html("<b style='color:red'>" + value + "</b>");
        // $("#get_total_mark_" + student_id).html("<b style='color:red'>" + value + "</b>");
        // $("#obt_theory_mark_" + student_id).val(value);
        // $("#obt_theory_mark_" + student_id).prop('readonly', false);
        $("#lab_obt_mark_" + student_id).val('SAT');
        $("#lab_obt_mark_" + student_id).prop('readonly', false);
        updateCardViewActionLab(student_id, "SAT");
    }   else if(value == "SAT") {
        // $("#result_" + student_id).html("<b style='color:red'>" + value + "</b>");
        // $("#get_total_mark_" + student_id).html("<b style='color:red'>" + value + "</b>");
        $("#obt_theory_mark_" + student_id).val(value);
        $("#obt_theory_mark_" + student_id).prop('readonly', false);
        updateCardViewAction(student_id, "SAT");
        // $("#lab_obt_mark_" + student_id).val('AB');
        // $("#lab_obt_mark_" + student_id).prop('readonly', false);
    }else if(value == "ASGN-LAB") {
        // $("#result_" + student_id).html("<b style='color:red'>" + value + "</b>");
        // $("#get_total_mark_" + student_id).html("<b style='color:red'>" + value + "</b>");
        // $("#obt_theory_mark_" + student_id).val(value);
        // $("#obt_theory_mark_" + student_id).prop('readonly', false);
        $("#lab_obt_mark_" + student_id).val('ASGN');
        $("#lab_obt_mark_" + student_id).prop('readonly', false);
    }   else if(value == "ASGN") {
        // $("#result_" + student_id).html("<b style='color:red'>" + value + "</b>");
        // $("#get_total_mark_" + student_id).html("<b style='color:red'>" + value + "</b>");
        $("#obt_theory_mark_" + student_id).val(value);
        $("#obt_theory_mark_" + student_id).prop('readonly', false);
        // $("#lab_obt_mark_" + student_id).val('AB');
        // $("#lab_obt_mark_" + student_id).prop('readonly', false);
    }else if (value != "") {
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

function getTotalMarks(student_id) { term_name
    var fail_flag = 0;
    // var exam_type = $('#exam_type').val();
    var lab_status = $('#lab_status').val();
    var term_name = $('#term_name').val(); 
    var max_theory_mark = $('#max_theory_mark').val();
    var min_mark_pass = $('#min_mark_pass').val();
    var lab_pass_mark = $('#lab_pass_mark').val();
    var max_mark_lab = $('#max_mark_lab').val();
    var theory_mark = $("#obt_theory_mark_" + student_id).val();
    var lab_mark = $("#lab_obt_mark_" + student_id).val();
    lab_mark = Number(lab_mark);
    theory_mark = Number(theory_mark);
    var total_mark = 0;
    // if(exam_type == 'I_UNIT_TEST' || exam_type == 'II_UNIT_TEST' ){
    //     var min_mark_pass = min_mark_pass;
    //     var total_pass_mark = max_theory_mark;
    // }else{
        var min_mark_pass = min_mark_pass;
        var total_pass_mark = max_theory_mark;
        // var max_lab_mark1 = max_mark_lab;
    // }
    if (isNaN(theory_mark) && isNaN(lab_mark)) {
        total_mark = 0;
    } else if (isNaN(theory_mark)) {
        total_mark = lab_mark;
    } else if (isNaN(lab_mark)) {
        total_mark = theory_mark;
    } else {
        total_mark = theory_mark + lab_mark;
        // alert(total_mark);
    }
    if(theory_mark > total_pass_mark){
        alert("Please enter valid Theory mark");
        $("#obt_theory_mark_" + student_id).val("");
        exit;
    }
    if(lab_status == true){
        // alert('ddd');
        if(lab_mark > max_mark_lab){
        alert("Please enter valid Lab mark");
        $("#lab_obt_mark_" + student_id).val("");
        exit;
    }
    }
    // if (total_mark < min_mark_pass ) {
    // fail_flag = 1;
    // } else {
    // fail_flag = 0;
    // }

    if(lab_status == true){
            if(theory_mark >= min_mark_pass && lab_mark >= lab_pass_mark) {
                fail_flag = 0;
            }else{
                fail_flag = 1;
            }
        }else{
            if (theory_mark < min_mark_pass) {
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
    var term_name = $('#termName :selected').val();
    var exam_type = $('#examType :selected').val();
    var stream_name_id = $('#stream_name_id :selected').val();
    var report_type = $('#report_type :selected').val();
    //  var section_name = $('#section_name :selected').val();
    $.ajax({
        url: '<?php echo base_url(); ?>/getInternalMarkSheet',
        type: 'POST',
        dataType: 'json',
        data: {
            type: type,
            term_name: term_name,
            exam_type: exam_type,
            stream_name_id : stream_name_id,
            report_type: report_type,
        },

        success: function(data) {
            $("#downloadAllMarks").prop('disabled', false);
            $("#loader").html(right_mark + "<span style='color:green'><b>Downloaded</b></span>");
            // var studentObj = JSON.parse(data)
            var $a = $("<a>");
            $a.attr("href", data.file);
            $("body").append($a);
            $a.attr("download", "Examination_Result_file.xls");
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


