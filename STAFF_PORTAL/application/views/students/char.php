
<!DOCTYPE html>
<html>
<?php
    // ini_set("pcre.backtrack_limit", "100000000");
    // ini_set('memory_limit', '750M')
ini_set('MAX_EXECUTION_TIME', '-1');
date_default_timezone_set("Asia/Kolkata"); 

require APPPATH . 'views/includes/db.php'; 
?>

<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  
<script src="<?php echo base_url(); ?>assets/dist/js/chart.js"></script>
  <style>
    .canvasjs-chart-credit{
      display:none !important;
    }
    .text_center{
      text-align: center;
    }
  

    .container{
      color: black !important;
    }
        
    #border {
      border-radius: 1px;
      border: 2px solid black;
      width: 18.5cm;
      height: 26.7cm;

    }
    .stm_work{
        font-size: 25px;
        font-weight: bold;
    }
    .title{
        font-size: 30px;
        margin-left: -25px;
    }
    table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
      line-height: 1.5 !important;
      padding: 1px !important;
    }



  
    .photo1{  
      margin-top: -70px !important;
    }
    .picture-box{
      margin-top: 15px;
    }


    .footer-sign{
      margin-top: 90px;
      margin-bottom: 40px;
    }

    .boredr-only-top{
      border-top: solid;
      border-color: black;
      border-width: 1px;
      margin-top: 15px;
    }

    .box-address{
      margin-top: 40px;
    }

    .box-address>thead>tr>th{
      text-align: center;
      padding-top: 0px !important;
      padding-bottom: 120px !important;
    }


    .modal-header {
      color: white !important;
      padding: 15px !important;
      background: #0d528b !important;
      border-bottom: 1px solid #0d5ea2 !important;
    }

    .border_full{
      border-style: solid;
      padding: 7px;
      border-color: black;
      border-width: 1px;
    }
    .boredr_left{
      border-left: solid;
      padding: 7px;
      border-color: black;
      border-width: 1px;
    }
    .boredr_right{
      border-right: solid;
      padding: 7px;
      border-color: black;
      border-width: 1px;
    }
    .boredr_left_right{
      border-right: solid;
      border-left: solid;
      padding: 7px;
      border-color: black;
      border-width: 1px;
    }
    .boredr_only_bottom{
      border-bottom: solid;
      /* padding: 7px; */
      border-color: black;
      border-width: 1px;
    }
    .text_style_2{
      margin-left: -12px;
      font-weight: bold;
      float: left;
      margin-top: -8px;
    }

    .photo_style{
      border: 1px solid;
      height: 175px;
      width: 165px;
      text-align: center;
      margin-left: 20px;
    }

    canvas{
      margin-left: 100px;
      width:700px !important;
      height:400px !important;

    }

    .page_break { 
      page-break-before: always;
    }

    .table_bordered_none tr td, .table_bordered_none tr th{
      border: none !important;
      padding: 1px !important;
    }

    .table_bordered_none{
      border: none !important;
      padding: 1px !important;
    }

    .table_content > tbody > tr>td, .table_content > tbody > tr>th{
      border: 1px solid black !important;
    }

    .table-bordered tr th, .table-bordered tr td{
      border: 1px solid black !important;
      padding: 5px !important;
    }
  </style>
</head>


<body>

<div>

</div>
<div class="container">
<?php 
    if(!empty($studentsRecords)) {
  $total_students_selected = count((array)$studentsRecords);
  foreach($studentsRecords as $student) {  
    $total_students_selected--;
    
?>
    <?php if($student->term_name == "I PUC"){ 
      $absent_date_from = date("Y-m-d", strtotime($student->date_of_admission));
        } else { 
    $absent_date_from = '2021-07-01';
      } ?>
    <div class="A4 enable-print" >
                                        <div class="row border_full">
                                        <table class="table table_bordered_none" >
                                          <tbody>
                                            <tr>
                                                <td class="text-center" width="100">
                                                    <img  src="<?php echo base_url(); ?><?php echo INSTITUTION_LOGO; ?>" height="110" width="110" alt="SJPUC" class="sjpuch_logo" />
                                                </td>
                                                <td class="text-center">
                                                    <b style="font-size: 25px;">ST. JOSEPH'S PRE-UNIVERSITY COLLEGE</b>
                                                    <p style="font-size: 16px;">Address</p>
                                                    <p style="font-size: 16px;">Address</p>
                                                    <p style="font-size: 20px;margin-bottom: 0px;" class="text-center mb-2">I UNIT TEST NOV-<?php echo date('Y'); ?></p>
                                                </td>
                                                <td class="text-center" width="100">
                                                    <img  src="<?php echo base_url(); ?>assets/images/PHOTOS_20_21_ALL/<?php echo $student->student_id; ?>.jpg" height="100" width="100" alt="PHOTO" />
                                                </th>
                                            </tr>
                                          </tbody>
                                        </table>
                                            
                                        </div> 
                                   
                                        <div class="row boredr_left_right boredr_only_bottom">
                                            <div class="col-xs-12">
                                                <table class="table table-bordered table_content table-responsive">
                                                    <tbody>
                                                    <tr style="font-size: 16px;">
                                                        <th width="250">Reg No.: <?php echo $student_id = $student->student_id; ?></th>
                                                        <th  colspan="3">Name: <?php echo $student->student_name; ?></th>
                                                        <th  colspan="2">Class: <?php echo $student->term_name . ' '.$student->stream_name.' '.$student->section_name; ?></th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center">SUBJECTS</th>
                                                        <th class="text-center">Max. Marks</th>
                                                        <th class="text-center">Min. Marks</th>
                                                        <th class="text-center">Marks Scored</th>
                                                        <th width="80" class="text-center">Attendance Held/Attended</th>
                                                        <th width="80" class="text-center">Percentage of Attn.%</th>
                                                    </tr>
                                                    <?php 
                                                     $attendance_date_to = "2021-09-30";
                                                     $subjects_code = array();
                                                     $subject_names = array();
                                                     $subject_mark = array();
                                                     $subject_mark_unit_test_I = array();
                                                     $subject_mark_chart_I_TEST = array();
                                                     $subject_mark_chart = array();
                                                     $elective_sub = strtoupper($student->elective_sub);
                                                   

                                                     $subject_mark_MID_TERM = array();
                                                     $subject_mark_chart_MID_TERM = array();
                                                        if($elective_sub == "KANNADA"){
                                                            array_push($subjects_code, '01');
                                                        }else if($elective_sub == 'HINDI'){
                                                            array_push($subjects_code, '03');
                                                        } else if($elective_sub == 'FRENCH'){
                                                            array_push($subjects_code, '12');
                                                        }else{
                                                          array_push($subject_mark_chart,0);
                                                          array_push($subject_mark_chart_I_TEST,0);
                                                           ?>
                                                            <th>EXEMPTED</th>
                                                            <th class="text-center">EX</th>
                                                            <th class="text-center">EX</th>
                                                            <th class="text-center">EX</th>
                                                            <th class="text-center">EX</th>
                                                            <th  class="text-center">EX</th>
                                                         <?php
                                                        
                                                          array_push($subject_names, 'EXM');
                                                        }
                                                        array_push($subjects_code, '02');
                                                       
                                                        $subjects = getSubjectCodes($student->stream_name);
                                                        $subjects_code = array_merge($subjects_code,$subjects);
                                                        $result_fail_status = false;
                                                        $total_max_mark = 0;
                                                        $total_min_mark = 0;
                                                        $total_mark_obtained = 0;
                                                        $total_max_mark_I_TEST = 0;
                                                        $chart_percentage_unit = 0;
                                                        $chart_percentage = 0;
                                                        $total_class_held_all = 0;
                                                        $total_class_attended_all = 0;
                                                        $total_mark_obtained_I_TEST = 0;

                                                        $max_mark_MID_Term = 0;
                                                        $min_mark_pass_MID_Term = 0;
                                                        $total_max_mark_MID_Term = 0;
                                                        $total_min_mark_pass_MID_Term = 0;
                                                        $total_mark_obtained_MID_TERM = 0;
                                                        for($i=0; $i < count($subjects_code); $i++)
                                                        {
                                                          $absent_count = 0;
                                                          $absent_count_lab = 0;
                                                          $batch_name = '';
                                                          $obtainted_mark = 0;
                                                           $subject_info = getSubjectInfo($con,$subjects_code[$i]); ?>
                                                            <tr>
                                                                <?php
                                                                $exam_mark = getSubjectMarkInfo($con,$subjects_code[$i],$student_id,$exam_type);
                                                                $obtainted_mark = $exam_mark['obt_theory_mark'];
                                                               
                                                                if($subject_info['lab_status'] == 'true'){
                                                                  $batchInfo = getBatchInfo($con,$student->section_name,$student->term_name,$student_id,$subjects_code[$i]);
                                                                  if(!empty($batchInfo)){
                                                                    $batch_name = $batchInfo['batch_name'];
                                                                  } else if($subjects_code[$i] == '40' && $subjects_code[$i] == '34' && $student_id = '17P2109'){
                                                                    $batch_name = 'II Batch';
                                                                  }
                                                                    $max_mark = 35;
                                                                    $min_mark_pass = 12;
                                                                    $max_mark_MID_Term = 70;
                                                                    $min_mark_pass_MID_Term = 35;
                                                                    $max_mark_I_TEST = 35;
                                                                    $min_mark_pass_I_TEST = 12;
                                                                }else{
                                                                    $max_mark = 50;
                                                                    $min_mark_pass = 18;

                                                                    $max_mark_MID_Term = 100;
                                                                    $min_mark_pass_MID_Term = 50;
                                                                    $max_mark_I_TEST = 50;
                                                                    $min_mark_pass_I_TEST = 18;
                                                                }
                                                              //   $absent_count_theory_first= getStudentAbsentCount($con,$subjects_code[$i],$student_id,$absent_date_from,'THEORY');
                                                              // if($absent_count_theory_first != NULL){
                                                              //   $absent_count += 1;
                                                              // } 
                                                              
                                                                $total_max_mark += $max_mark;
                                                                $total_max_mark_I_TEST += $max_mark_I_TEST;
                                                                $total_min_mark += $min_mark_pass;
                                                                $total_max_mark_MID_Term += $max_mark_MID_Term;
                                                                $total_min_mark_pass_MID_Term += $min_mark_pass_MID_Term;
                                                                if($obtainted_mark == 'AB' || $obtainted_mark == 'EX' || $obtainted_mark == 'MP'){
                                                                    $result_fail_status = true;
                                                                    $result_display = $obtainted_mark;
                                                                    array_push($subject_mark_chart,0);
                                                                } else if($min_mark_pass > $obtainted_mark){
                                                                    $result_fail_status = true;
                                                                    $total_mark_obtained += $obtainted_mark;
                                                                    $result_display = $obtainted_mark.'F';
                                                                    $chart_percentage = round(($obtainted_mark/$max_mark)*100,2);
                                                                    array_push($subject_mark_chart,$chart_percentage);
                                                                }else{
                                                                  $total_mark_obtained += $obtainted_mark;
                                                                  $result_display = $obtainted_mark;
                                                                  $chart_percentage = round(($obtainted_mark/$max_mark)*100,2);
                                                                  array_push($subject_mark_chart, $chart_percentage);
                                                                }
                                                                array_push($subject_names, strtoupper($subject_info['name']));
                                                                array_push($subject_mark,$result_display);
                                                               


                                                                $exam_mark_unit_test = getSubjectMarkInfo($con,$subjects_code[$i],$student_id,'I_UNIT_TEST');
                                                                $obtainted_mark_I_test = $exam_mark_unit_test['obt_theory_mark'];
                                                                if($obtainted_mark_I_test == 'AB' || $obtainted_mark_I_test == 'EX' || $obtainted_mark_I_test == 'MP'){

                                                                    $result_display_unit_I = $obtainted_mark_I_test;
                                                                    array_push($subject_mark_chart_I_TEST,0);
                                                                } else if($min_mark_pass_I_TEST > $obtainted_mark_I_test){
                                                                    $result_display_unit_I = $obtainted_mark_I_test.'F';
                                                                    $total_mark_obtained_I_TEST += $obtainted_mark_I_test;
                                                                   
                                                                    $chart_percentage_unit = round(($obtainted_mark_I_test/$max_mark_I_TEST)*100,2);
                                                                    array_push($subject_mark_chart_I_TEST, $chart_percentage_unit);
                                                                }else{
                                                                  $total_mark_obtained_I_TEST += $obtainted_mark_I_test;
                                                                  $result_display_unit_I = $obtainted_mark_I_test;
                                                                 
                                                                  $chart_percentage_unit = round(($obtainted_mark_I_test/$max_mark_I_TEST)*100);
                                                                  array_push($subject_mark_chart_I_TEST, $chart_percentage_unit);
                                                                }
                                                                array_push($subject_mark_unit_test_I,$result_display_unit_I);


                                                                //mid term mark info
                                                                // $MID_TERM_EXAM = getSubjectMarkInfo($con,$subjects_code[$i],$student_id,'MID_TERM_EXAM');
                                                                // $obtainted_MID_TERM_EXAM = $MID_TERM_EXAM['obt_theory_mark'];
                                                                // if($obtainted_MID_TERM_EXAM == 'AB' || $obtainted_MID_TERM_EXAM == 'EX' || $obtainted_MID_TERM_EXAM == 'MP'){
                                                                //     $result_display_MID_TERM = $obtainted_MID_TERM_EXAM;
                                                                //     array_push($subject_mark_chart_MID_TERM, 0);
                                                                //     array_push($subject_mark_MID_TERM,0);
                                                                // } else if($min_mark_pass_MID_Term > $obtainted_MID_TERM_EXAM){
                                                                //     $result_display_MID_TERM = $obtainted_MID_TERM_EXAM.'F';
                                                                //     $total_mark_obtained_MID_TERM += $obtainted_MID_TERM_EXAM;
                                                                //     $max_mark_unit = $max_mark / 2; 
                                                                //     $chart_percentage_mid = round(($obtainted_MID_TERM_EXAM/$max_mark_MID_Term)*100,2);
                                                                //     array_push($subject_mark_chart_MID_TERM, $chart_percentage_mid);
                                                                // }else{
                                                                //   $total_mark_obtained_MID_TERM += $obtainted_MID_TERM_EXAM;
                                                                //   $result_display_MID_TERM = $obtainted_MID_TERM_EXAM;
                                                                //   $max_mark_unit = $max_mark / 2; 
                                                                //   $chart_percentage_mid = round(($obtainted_MID_TERM_EXAM/$max_mark_MID_Term)*100);
                                                                //   array_push($subject_mark_chart_MID_TERM, $chart_percentage_mid);
                                                                // }
                                                                // array_push($subject_mark_MID_TERM,$result_display_MID_TERM);


                                                                
                                                                $subject_class_held_theory = getTotalClassHeld($con,$subjects_code[$i],$student->term_name,$student->section_name,'THEORY','',$absent_date_from,$attendance_date_to);
                                                                $total_dates_held_theory = getTotalClassCompletedDates($con,$subjects_code[$i],$student->term_name,$student->section_name,'THEORY','',$absent_date_from,$attendance_date_to);
                                                                foreach($total_dates_held_theory as $date){
                                                                  $absent_count_theory = getStudentAbsentCount($con,$subjects_code[$i],$student_id,$date['date'],'THEORY');
                                                                  if($absent_count_theory != NULL){
                                                                    $absent_count += 1;
                                                                  }
                                                                }
                                                                $subject_class_held_lab = getTotalClassHeld($con,$subjects_code[$i],$student->term_name,$student->section_name,'LAB',$batch_name,$absent_date_from,$attendance_date_to);
                                                                $total_dates_held_lab = getTotalClassCompletedDates($con,$subjects_code[$i],$student->term_name,$student->section_name,'LAB',$batch_name,$absent_date_from,$attendance_date_to);
                                                                $total_class_held = $subject_class_held_theory + ($subject_class_held_lab*2);
                                                                foreach($total_dates_held_lab as $date_lab){
                                                                  $absent_count_theory = getStudentAbsentCount($con,$subjects_code[$i],$student_id,$date_lab['date'],'LAB');
                                                                  if($absent_count_theory != NULL){
                                                                    $absent_count += 2;
                                                                  }
                                                                }

                                                                $total_class_presnts = $total_class_held-$absent_count;
                                                                $attendance_percentage = ($total_class_presnts/$total_class_held)*100;
                                                              
                                                                $total_class_held_all += $total_class_held;
                                                                $total_class_attended_all += $total_class_presnts;
                                                                ?>

                                                                <th><?php echo strtoupper($subject_info['name']); ?></th>
                                                                <th class="text-center"><?php echo $max_mark; ?></th>
                                                                <th class="text-center"><?php echo $min_mark_pass; ?></th>
                                                                <th class="text-center"><?php echo $result_display; ?></th>
                                                                <th class="text-center"><?php echo $total_class_held .'/'.$total_class_presnts; ?></th>
                                                                <th  class="text-center"><?php echo round($attendance_percentage,2); ?></th>
                                                            </tr>
                                                            
                                                           <?php
                                                        }
                                                        $total_percentage = ($total_mark_obtained/$total_max_mark)*100;
                                                        $total_attendance_percentage = ($total_class_attended_all/$total_class_held_all)*100;
                                                    ?>
                                                    <tr>
                                                        <th>Total</th>
                                                        <th class="text-center"><?php echo $total_max_mark; ?></th>
                                                        <th class="text-center"><?php echo $total_min_mark; ?></th>
                                                        <th class="text-center"><?php echo $total_mark_obtained; ?></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                    <tr style="font-size: 18px;">
                                                        <th colspan="3">Overall Secured Percentage of Marks: <?php echo round($total_percentage,2).'%'; ?></th>
                                                        <th colspan="2">Result: <?php if($result_fail_status == true){echo 'FAIL';}else{echo 'PASS';} ?></th>
                                                        <th class="text-center" ><?php echo round($total_attendance_percentage,2).'%'; ?></th>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div style="padding:2px; " class="row text-center boredr_left_right boredr_only_bottom">
                                            <span class="" style="font-size:19px; font-weight:600">Performance Of The Year</span>
                                        </div>
                                        <div class="row boredr_left_right boredr_only_bottom">
                                        <table style="margin-bottom: 0px;" class="table table-bordered table-responsive">
                                            <tbody>
                                                <tr>
                                                    <th>Test / Exam Name</th>
                                                    <?php for($i=0; $i < count($subject_names); $i++)
                                                        { ?>
                                                         <th class="text-center"><?php echo substr($subject_names[$i], 0, 3);?></th>
                                                  <?php } ?>
                                                  <th class="text-center">%</th>
                                                </tr>
                                                <tr>
                                                    <th>I UNIT TEST JULY-2021</th>
                                                    <?php 
                                                    if($elective_sub == "EXEMPTED"){ ?>
                                                     <th class="text-center">EX</th>
                                                   <?php }
                                                    for($i=0; $i < count($subjects_code); $i++)
                                                        { ?>
                                                         <th class="text-center"><?php echo $subject_mark_unit_test_I[$i]; ?></th>
                                                  <?php } 
                                                   $total_percentage_unit_I = ($total_mark_obtained_I_TEST/$total_max_mark_I_TEST)*100;
                                                  ?>
                                                  <th class="text-center"><?php echo round($total_percentage_unit_I,2); ?></th>
                                                </tr>
                                              

                                                
                                                
                                                <!-- <tr>
                                                    <th>MID-TERM EXAM SEPT-2019</th>
                                                    <?php 
                                                    if($elective_sub == "EXEMPTED"){ ?>
                                                     <th class="text-center">EX</th>
                                                   <?php }
                                                    for($i=0; $i < count($subjects_code); $i++)
                                                        { ?>
                                                         <th class="text-center"><?php echo $subject_mark_MID_TERM[$i]; ?></th>
                                                  <?php } 
                                                   $percentage_mid_term = ($total_mark_obtained_MID_TERM/$total_max_mark_MID_Term)*100;
                                                  ?>
                                                  <th class="text-center"><?php echo round($percentage_mid_term,2); ?></th>
                                                </tr>

                                                <tr>
                                                    <th>II UNIT TEST NOV-2019</th>
                                                    
                                                    <?php 
                                                    if($elective_sub == "EXEMPTED"){ ?>
                                                     <th class="text-center">EX</th>
                                                   <?php }
                                                    for($i=0; $i < count($subject_mark); $i++)
                                                        { ?>
                                                         <th class="text-center"><?php echo $subject_mark[$i]; ?></th>
                                                  <?php } ?>
                                                  <th class="text-center"><?php echo round($total_percentage,2); ?></th>
                                                </tr> -->
                                            </tbody>
                                        </table>
                                        </div>

                                        <div style="padding:2px; " class="row text-center boredr_left_right boredr_only_bottom">
                                            <span style="font-size:20px; font-weight:600" class="">Performance in Bar Graph</span>
                                        </div>
                                        
                                       
                                        <div class="row boredr_left_right boredr_only_bottom ">
                                        <canvas class="text-center" id="markChart<?php echo $student_id; ?>"></canvas>
                                            
                                        </div>
                                        <script type="text/javascript">
                                               function loadGraph() {
                                               
                                                // var mark_MID_TERM = <?php echo json_encode($subject_mark_chart_MID_TERM); ?>;
                                                var mark_UNIT_TEST = <?php echo json_encode($subject_mark_chart_I_TEST); ?>;
                                                // var mark_UNIT_TEST_II = <?php echo json_encode($subject_mark_chart); ?>;
                                              // 
                                              var data = {
                                                        labels: [
                                                            <?php for($i=0; $i < count($subject_names); $i++)
                                                              { 
                                                              echo "'".strtoupper($subject_names[$i])."',";
                                                              } ?>
                                                            ],
                                                datasets: [
                                                    {
                                                        label: 'I UNIT TEST JULY - 2019',
                                                        borderColor: 'rgb(0, 0, 0)',
                                                        borderWidth : '1',
                                                        backgroundColor: 'rgb(213, 219, 219)',
                                                        data: mark_UNIT_TEST
                                                    },
                                                    // {
                                                    //     label: 'MID TERM SEPT - 2019',
                                                    //     borderColor: 'rgb(0, 0, 0)',
                                                    //     borderWidth : '1',
                                                    //     backgroundColor: 'rgb( 214, 234, 248)',
                                                       
                                                    //     data: mark_MID_TERM
                                                    // },
                                                    // {
                                                    //     label: 'II UNIT TEST NOV - 2019',
                                                    //     borderColor: 'rgb(0, 0, 0)',
                                                    //     borderWidth : '1',
                                                    //     backgroundColor: 'rgb(169, 223, 191)',
                                                    //     data: mark_UNIT_TEST_II
                                                    // },
                                                ]
                                            };
                                                  var ctx = document.getElementById('markChart<?php echo $student_id; ?>').getContext('2d');
                                                  var chart = new Chart(ctx, {
                                                      // The type of chart we want to create
                                                      type: 'bar',
                                                      // The data for our dataset
                                                      data: data,
                                                 
                                                      // Configuration options go here
                                                      options: {
                                                        responsive: true,
                                                        scales: {
                                                              xAxes: [{
                                                                barThickness : 43,
                                                                ticks: {
                                                                  fontColor: "black",
                                                                  fontSize: 15,
                                                                 
                                                                }
                                                              }],
                                                              yAxes: [
                                                                      {
                                                                        ticks: {
                                                                          fontColor: "black",
                                                                          fontSize: 15,
                                                                          min: 0,
                                                                          max: 100,// Your absolute max value
                                                                          callback: function (value) {
                                                                            return (value / 100 * 100).toFixed(0); // convert it to percentage
                                                                          },
                                                                        },
                                                                        scaleLabel: {
                                                                          fontSize: 20,
                                                                          display: true,
                                                                          labelString: 'Marks Obtained',
                                                                        },
                                                                      },
                                                                    ],
                                                          }
                                                      }
                                                  });
                                                }

                                            <?php
                                                echo "loadGraph();";
                                            ?>
                                        </script>
                                        <div class="row boredr_left_right boredr_only_bottom">
                                          <p width="200" class="text-center"><img height="60" src="<?php echo base_url(); ?>assets/images/principal_signature.jpg" alt="Sign"></p>
                                        <table class="table table_bordered_none" style="font-size: 17px;">
                                          <tr>
                                            <th width="200" class="text-center">Principal's Signature</th>
                                            <th width="300" class="text-center">Class Teacher's Signature</th>
                                            <th width="250" class="text-center">Parent's Signature</th>
                                          </tr>
                                        </table>
                                        
                                        </div>
                                    </div>
                                </div>
<?php if($total_students_selected > 1) { ?>
  <div class="page_break"></div>
<?php } ?>

<?php } } ?>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
</body>

</html>

<?php 

function getSubjectInfo($con,$subject_id){
  $query = "SELECT * FROM tbl_subjects as sub
  WHERE sub.subject_code = '$subject_id'";
  $pdo_statement = $con->prepare($query);
  $pdo_statement->execute();
  return $pdo_statement->fetch();
}
function getSubjectMarkInfo($con,$subject_id,$student_id,$exam_type){
  $query = "SELECT * FROM tbl_college_internal_exam_marks as exam
  WHERE exam.subject_code = '$subject_id' AND exam.student_id = '$student_id' AND exam.exam_type = '$exam_type' AND exam.office_validation_status = 1";
  $pdo_statement = $con->prepare($query);
  $pdo_statement->execute();
  return $pdo_statement->fetch();
}

function getTotalClassHeld($con,$subject_id,$term_name,$section_name,$type,$batch_name = '',$absent_date_from,$attendance_date_to){

if(!empty($batch_name)){
  $query = "SELECT * FROM tbl_subjected_teached_by_staff as class
  WHERE class.subject_id = '$subject_id' AND class.term_name = '$term_name' AND class.section_name = '$section_name' AND 	subject_type = '$type' AND class.batch_name = '$batch_name' AND
  date between '$absent_date_from' AND '$attendance_date_to' ";
}else{
  $query = "SELECT * FROM tbl_subjected_teached_by_staff as class
  WHERE class.subject_id = '$subject_id' AND class.term_name = '$term_name' AND class.section_name = '$section_name' AND 	subject_type = '$type' AND is_deleted = 0 AND
  date between '$absent_date_from' AND '$attendance_date_to' ";
}
$result = $con->prepare($query); 
$result->execute(); 
return $result->rowCount();
}

// get all class completed dates
function getTotalClassCompletedDates($con,$subject_id,$term_name,$section_name,$type,$batch_name = '',$absent_date_from,$attendance_date_to){

if(!empty($batch_name)){
  $query = "SELECT * FROM tbl_subjected_teached_by_staff as class
  WHERE class.subject_id = '$subject_id' AND class.term_name = '$term_name' AND class.section_name = '$section_name' AND 	subject_type = '$type' AND class.batch_name = '$batch_name' AND
  date between '$absent_date_from' AND '$attendance_date_to' ";
}else{
  $query = "SELECT * FROM tbl_subjected_teached_by_staff as class
  WHERE class.subject_id = '$subject_id' AND class.term_name = '$term_name' AND class.section_name = '$section_name' AND 	subject_type = '$type' AND is_deleted = 0 AND
  date between '$absent_date_from' AND '$attendance_date_to' ";
}
$result = $con->prepare($query); 
$result->execute(); 
return $result->fetchAll();
}

function getStudentAbsentCount($con,$subject_id,$student_id,$absent_date,$type){
$query = "SELECT * FROM tbl_student_attendance_details as ab WHERE ab.student_id = '$student_id' AND absent_date = '$absent_date' 
AND ab.office_verified_status = 1 AND ab.is_deleted = 0 AND 
ab.staff_subject_row_id IN(SELECT sub.row_id FROM tbl_staff_teaching_subjects as sub WHERE sub.subject_id='$subject_id' AND sub.subject_type='$type')";
$result = $con->prepare($query); 
$result->execute(); 
return $result->fetchAll();
}


function getBatchInfo($con,$section_name,$term_name,$student_id,$subject_id){
$query = "SELECT * FROM  tbl_class_batch_details as batch,  tbl_staff_teaching_subjects as sub
WHERE sub.row_id = batch.staff_teaching_subject_id AND sub.subject_id = '$subject_id' AND
 batch.section_name = '$section_name' AND batch.term_name = '$term_name' AND
 '$student_id' between batch.student_id_from AND batch.student_id_to AND batch.is_deleted = 0";
$pdo_statement = $con->prepare($query);
$pdo_statement->execute();
return $pdo_statement->fetch();
}
function getSubjectCodes($stream_name) {
  //science
  $PCMB = array("33", "34", "35", '36');
  $PCMC = array("33", "34", "35", '41');
  $PCME = array("33", "34", "35", '40');
  //commarce
  $PEBA = array("29", "22", "27", '30');
  $MEBA = array("75", "22", "27", '30');
  $MSBA = array("75", "31", "27", '30');
  $CSBA = array("41", "31", "27", '30');
  $SEBA = array("31", "22", "27", '30');
  $CEBA = array("41", "22", "27", '30');
  //art
  $HEPS = array("21", "22", "29", '28');
  switch ($stream_name) {
          case "PCMB":
                  return  $PCMB;
                  break;
          case "PCMC":
                  return $PCMC;
                  break;
          case "PEBA":
                  return $PEBA;
                  break;
          case "PCME":
                  return $PCME;
                  break;
          case "MEBA":
                  return $MEBA;
                  break;
          case "MSBA":
                  return $MSBA;
                  break;
          case "CSBA":
                  return $CSBA;
                  break;
          case "SEBA":
                  return $SEBA;
                  break;
          case "CEBA":
                  return $CEBA;
                  break;
          case "HEPS":
                  return $HEPS;
                  break;
  }
}
?>