<?php
$servername = "192.168.0.100";
$username = "root";
$password = "";
$db = 'schoolphins_boys';//"schoolphins";//
// $servername = "localhost";
// $username = "root";
// $password = "";
// $db = 'sjpuc_schoolphins_v2';//"schoolphins";//
 try {
   $con = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
   // set the PDO error mode to exception
   $this->global ['con'] = $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 //  echo "Connected successfully"; 
   }
 catch(PDOException $e)
   {
  echo "Connection failed: " . $e->getMessage();
   }
?>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<div class="main-content-container container-fluid px-4">
    <div class="col-md-12">
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
    </div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mt-1 mb-2">
            <div class="col padding_left_right_null">
            <div class="card card-small p-0">
                <div class="card-body p-2 ml-2">
                <span class="page-title">
                    <i class="material-icons">mode_edit</i> My Attendance
                </span>
                <a onclick="window.history.back(); return false;" class="btn btn-primary float-right text-white pt-2" value="Back" >Back </a>
                </div>
            </div>
            </div>
        </div>
    </section>
    <div class="row form-employee">
        <?php //if($studentInfo->term_name == "I PUC"){ 
            $absent_date_from = date("Y-m-d", strtotime($studentInfo->doj));
            // } else { 
            // $absent_date_from = '2022-07-01';
            // } 
            
            $dataPoints = array();
            $attendance_date_to = date("Y-m-d");
            $subject_names = array();
            $subject_mark = array();
            $subject_mark_chart = array();
            $elective_sub = strtoupper($studentInfo->elective_sub);
            ?>
        <div class="col-12 padding_left_right_null">
            <div class="card card-small c-border mb-4">
                <?php $subjects_code = array();
                    if($elective_sub == "KANNADA"){
                        array_push($subjects_code, '01');
                    }else if($elective_sub == 'HINDI'){
                        array_push($subjects_code, '03');
                    } else if($elective_sub == 'FRENCH'){
                        array_push($subjects_code, '12');
                    }else{
                        array_push($subject_mark_chart,0);
                ?>
                <?php array_push($subject_names, 'EXM');
                    }
                    array_push($subjects_code, '02');
                    
                    $subjects = getSubjectCodes($studentInfo->stream_name);
                    $subjects_code = array_merge($subjects_code,$subjects);
                    $total_class_held_all = 0;
                    $total_class_attended_all = 0;
                    for($i=0; $i < count($subjects_code); $i++)
                    {
                        $absent_count = 0;
                        $absent_count_lab = 0;
                        $absent_count_theory = 0;
                        $batch_name = '';
                        $subject_info = getSubjectInfo($con,$subjects_code[$i]); 
                            
                            if($subject_info['lab_status'] == 'true'){
                                // $batchInfo = getBatchInfo($con,$studentInfo->section_name,$studentInfo->term_name,$student_id,$subjects_code[$i]);
                                // if(!empty($batchInfo)){
                                // $batch_name = $batchInfo['batch_name'];
                                // } else if($subjects_code[$i] == '40' && $subjects_code[$i] == '34' && $student_id = '17P2109'){
                                // $batch_name = 'II Batch';
                                // }
                                $batch_name = $studentInfo->batch;
                            }

                            // $absent_count += getStudentAbsentCount($con,$subjects_code[$i],$student_id,$absent_date_from,'THEORY');
                            
                            $subject_class_held_theory = getTotalClassHeld($con,$subjects_code[$i],$studentInfo->term_name,$studentInfo->section_name,'THEORY','',$absent_date_from,$attendance_date_to);
                            $total_dates_held_theory = getTotalClassCompletedDates($con,$subjects_code[$i],$studentInfo->term_name,$studentInfo->section_name,'THEORY','',$absent_date_from,$attendance_date_to);
                            // foreach($total_dates_held_theory as $date){
                            //     $absent_count_theory = getStudentAbsentCount($con,$subjects_code[$i],$student_id,$date['date'],'THEORY');
                            //     if($absent_count_theory != NULL){
                            //     $absent_count += 1;
                            //     }
                            // }
                            
                            $absent_count_theory = getStudentAbsentCount($con,$subjects_code[$i],$student_id,$absent_date_from,$attendance_date_to,'THEORY');
                            $absent_count += $absent_count_theory;

                            $subject_class_held_lab = getTotalClassHeld($con,$subjects_code[$i],$studentInfo->term_name,$studentInfo->section_name,'LAB',$batch_name,$absent_date_from,$attendance_date_to);
                            $total_dates_held_lab = getTotalClassCompletedDates($con,$subjects_code[$i],$studentInfo->term_name,$studentInfo->section_name,'LAB',$batch_name,$absent_date_from,$attendance_date_to);
                            $total_class_held = $subject_class_held_theory + ($subject_class_held_lab*2);
                            // foreach($total_dates_held_lab as $date_lab){
                            //     $absent_count_theory = getStudentAbsentCount($con,$subjects_code[$i],$student_id,$date_lab['date'],'LAB');
                            //     if($absent_count_theory != NULL){
                            //     $absent_count += 2;
                            //     }
                            // }
                            $absent_count_lab = getStudentAbsentCount($con,$subjects_code[$i],$student_id,$absent_date_from,$attendance_date_to,'LAB');
                            if($absent_count_lab != 0){
                              $absent_count += ($absent_count_lab * 2);
                            }
                            
                        
                            $total_class_presnts = $total_class_held-$absent_count;
                            $attendance_percentage = ($total_class_presnts/$total_class_held)*100;
                            
                            array_push($dataPoints, array("label"=> $subject_info['name'], "y"=> (int)$attendance_percentage));
                } ?>
                <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                    <script>
                    function loadGraph() {
                        var chart = new CanvasJS.Chart("chartContainer", {
                            animationEnabled: true,
                        exportEnabled: true,
                        theme: "light1", 
                        title:{
                            text: ""
                        },
                        data: [{
                            type: "column", 
                            color: "#47d647",
                            dataPoints: <?php echo json_encode($dataPoints); ?>
                        }]
                        });
                        setColor(chart);
                        chart.render();
                        }
                        <?php
                            echo "loadGraph();";
                        ?>
                        function setColor(chart){
                            for(var i = 0; i < chart.options.data.length; i++) {
                            dataSeries = chart.options.data[i];
                            for(var j = 0; j < dataSeries.dataPoints.length; j++){
                                if(dataSeries.dataPoints[j].y < 85)
                                dataSeries.dataPoints[j].color = '#e82626';
                                }
                            }
                        }
                    </script>
                <div class="table-responsive">
                    <table class="table table-bordered table_info">
                        <thead>
                            <tr>
                                <th colspan="3" class="table_title text-center">Attendance Upto Today</th>
                            </tr>
                            <tr class="table_row_backgrond">
                                <th class="text-center" width="250">SUBJECTS</th>
                                <th class="text-center" width="250">Classes Held/Present</th>
                                <th class="text-center" width="250">Percentage</th>
                            </tr>
                        </thead>
                        <?php $subjects_code = array();
                            if($elective_sub == "KANNADA"){
                                array_push($subjects_code, '01');
                            }else if($elective_sub == 'HINDI'){
                                array_push($subjects_code, '03');
                            } else if($elective_sub == 'FRENCH'){
                                array_push($subjects_code, '12');
                            }else{
                                array_push($subject_mark_chart,0);
                        ?>
                                <th class="text-center">EXEMPTED</th>
                                <th class="text-center">EX</th>
                                <th class="text-center">EX</th>
                        <?php array_push($subject_names, 'EXM');
                            }
                            array_push($subjects_code, '02');
                            
                            $subjects = getSubjectCodes($studentInfo->stream_name);
                            $subjects_code = array_merge($subjects_code,$subjects);
                            $total_class_held_all = 0;
                            $total_class_attended_all = 0;
                            for($i=0; $i < count($subjects_code); $i++)
                            {
                                $absent_count = 0;
                                $absent_count_lab = 0;
                                $batch_name = '';
                                $subject_info = getSubjectInfo($con,$subjects_code[$i]); ?>
                                <tr>
                                    <?php
                                    
                                    if($subject_info['lab_status'] == 'true'){
                                        // $batchInfo = getBatchInfo($con,$studentInfo->section_name,$studentInfo->term_name,$student_id,$subjects_code[$i]);
                                        // if(!empty($batchInfo)){
                                        // $batch_name = $batchInfo['batch_name'];
                                        // } else if($subjects_code[$i] == '40' && $subjects_code[$i] == '34' && $student_id = '17P2109'){
                                        // $batch_name = 'II Batch';
                                        // }
                                        // $batch_name = $studentInfo->batch;
                                        $batch_name = $studentInfo->batch;
                                    }

                                    // $absent_count += getStudentAbsentCount($con,$subjects_code[$i],$student_id,$absent_date_from,'THEORY');
                                    
                                    $subject_class_held_theory = getTotalClassHeld($con,$subjects_code[$i],$studentInfo->term_name,$studentInfo->section_name,'THEORY','',$absent_date_from,$attendance_date_to);
                                    $total_dates_held_theory = getTotalClassCompletedDates($con,$subjects_code[$i],$studentInfo->term_name,$studentInfo->section_name,'THEORY','',$absent_date_from,$attendance_date_to);
                                    // foreach($total_dates_held_theory as $date){
                                    //     $absent_count_theory = getStudentAbsentCount($con,$subjects_code[$i],$student_id,$date['date'],'THEORY');
                                    //     if($absent_count_theory != NULL){
                                    //     $absent_count += 1;
                                    //     }
                                    // }
                            
                                    $absent_count_theory = getStudentAbsentCount($con,$subjects_code[$i],$student_id,$absent_date_from,$attendance_date_to,'THEORY');
                                    $absent_count += $absent_count_theory;

                                    $subject_class_held_lab = getTotalClassHeld($con,$subjects_code[$i],$studentInfo->term_name,$studentInfo->section_name,'LAB',$batch_name,$absent_date_from,$attendance_date_to);
                                    $total_dates_held_lab = getTotalClassCompletedDates($con,$subjects_code[$i],$studentInfo->term_name,$studentInfo->section_name,'LAB',$batch_name,$absent_date_from,$attendance_date_to);
                                    $total_class_held = $subject_class_held_theory + ($subject_class_held_lab*2);
                                    // foreach($total_dates_held_lab as $date_lab){
                                    //     $absent_count_theory = getStudentAbsentCount($con,$subjects_code[$i],$student_id,$date_lab['date'],'LAB');
                                    //     if($absent_count_theory != NULL){
                                    //     $absent_count += 2;
                                    //     }
                                    // }
                                    $absent_count_lab = getStudentAbsentCount($con,$subjects_code[$i],$student_id,$absent_date_from,$attendance_date_to,'LAB');
                                    if($absent_count_lab != 0){
                                      $absent_count += ($absent_count_lab * 2);
                                    }
                                
                                    $total_class_presnts = $total_class_held-$absent_count;
                                    $attendance_percentage = ($total_class_presnts/$total_class_held)*100;
                                    
                                    $total_class_held_all += $total_class_held;
                                    $total_class_attended_all += $total_class_presnts;
                                    ?>

                                    <th class="text-center"><?php echo strtoupper($subject_info['name']); ?></th>
                                    <th width="300" class="text-center"><?php echo $total_class_held .'/'.$total_class_presnts; ?></th>
                                    <?php if(round($attendance_percentage,2) < 85.00){ ?>
                                        <th width="300" style="background:#f76a7ebf" class="text-center"><?php echo round($attendance_percentage,2);?></th>
                                    <?php }else{ ?>
                                        <th width="300" class="text-center"><?php echo round($attendance_percentage,2);?></th>
                                    <?php  } ?>
                                </tr>
                                
                                <?php
                            }
                            $total_attendance_percentage = ($total_class_attended_all/$total_class_held_all)*100;
                        ?>
                        <tr>
                            <th colspan="3" class="total_row">Total Percentage: 
                                <?php if(round($total_attendance_percentage,2) < 85.00){ ?>
                                    <span colspan="3" class="total_row text_fail"><?php echo round($total_attendance_percentage,2).'%'; ?></span>
                                <?php }else{ ?>
                                    <span colspan="3" class="total_row"><?php echo round($total_attendance_percentage,2).'%'; ?></span>
                                <?php  } ?>
                            </th>
                        </tr>
                    </table>  
                </div>
            </div>
        </div>
    </div>
    
</div>
<?php
function getSubjectInfo($con,$subject_id){
    $query = "SELECT * FROM tbl_subjects as sub
    WHERE sub.subject_code = '$subject_id'";
    $pdo_statement = $con->prepare($query);
    $pdo_statement->execute();
    return $pdo_statement->fetch();
  }

function getTotalClassHeld($con,$subject_id,$term_name,$section_name,$type,$batch_name,$absent_date_from,$attendance_date_to){
    if(!empty($batch_name)){
        $query = "SELECT * FROM tbl_class_completed_by_staff as class
        WHERE class.subject_code = '$subject_id' AND class.class_year = '2022' AND class.term_name = '$term_name' AND class.section_name = '$section_name' AND class.subject_type = '$type' AND class.batch = '$batch_name' AND class.is_deleted = 0 AND
        class.date between '$absent_date_from' AND '$attendance_date_to' ";
    }else{
        $query = "SELECT * FROM tbl_class_completed_by_staff as class
        WHERE class.subject_code = '$subject_id' AND class.class_year = '2022' AND class.term_name = '$term_name' AND class.section_name = '$section_name' AND class.subject_type = '$type' AND class.is_deleted = 0 AND
        class.date between '$absent_date_from' AND '$attendance_date_to' ";
    }
    $result = $con->prepare($query); 
    $result->execute(); 
    return $result->rowCount();
}

// get all class completed dates
function getTotalClassCompletedDates($con,$subject_id,$term_name,$section_name,$type,$batch_name,$absent_date_from,$attendance_date_to){
    if(!empty($batch_name)){
        $query = "SELECT * FROM tbl_class_completed_by_staff as class
        WHERE class.subject_code = '$subject_id' AND class.class_year = '2022' AND class.term_name = '$term_name' AND class.section_name = '$section_name' AND class.subject_type = '$type' AND class.batch = '$batch_name' AND class.is_deleted = 0 AND
        date between '$absent_date_from' AND '$attendance_date_to' ";
    }else{
        $query = "SELECT * FROM tbl_class_completed_by_staff as class
        WHERE class.subject_code = '$subject_id' AND class.class_year = '2022' AND class.term_name = '$term_name' AND class.section_name = '$section_name' AND class.subject_type = '$type' AND class.is_deleted = 0 AND
        date between '$absent_date_from' AND '$attendance_date_to' ";
    }
    $result = $con->prepare($query); 
    $result->execute(); 
    return $result->fetchAll();
}

// function getStudentAbsentCount($con,$subject_id,$student_id,$absent_date,$type){
//     $query = "SELECT * FROM tbl_student_attendance_details as ab WHERE ab.student_id = '$student_id' AND absent_date = '$absent_date' 
//     AND ab.office_verified_status = 0 AND ab.is_deleted = 0 AND 
//     ab.staff_subject_row_id IN(SELECT sub.row_id FROM tbl_staff_teaching_subjects as sub WHERE sub.subject_id='$subject_id' AND sub.subject_type='$type')";
//     $result = $con->prepare($query); 
//     $result->execute(); 
//     return $result->fetch();
// }


function getStudentAbsentCount($con,$subject_id,$student_id,$absent_date_from,$attendance_date_to,$type){
 
    $query = "SELECT * FROM tbl_student_attendance_details as ab WHERE ab.student_id = '$student_id' AND ab.year = '2022' AND
    ab.absent_date BETWEEN '$absent_date_from' AND '$attendance_date_to' 
    AND ab.is_deleted = 0 AND 
    ab.staff_subject_row_id IN(SELECT sub.row_id FROM tbl_staff_teaching_subjects as sub WHERE sub.subject_code='$subject_id' AND sub.subject_type='$type' AND sub.is_deleted = 0)";
    $result = $con->prepare($query); 
    $result->execute(); 
    return $result->rowCount();
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
    $PCMB = array("33", "34", "35", '36');
    $PCMC = array("33", "34", "35", '41');
    $PCME = array("33", "34", "35", '40');
    $PCMS = array("33", "34", "35", '31');
    //commarce
    $BEBA = array("75", "22", "27", '30');
    $BSBA = array("75", "31", "27", '30');
    $CSBA = array("41", "31", "27", '30');
    $SEBA = array("31", "22", "27", '30');
    $CEBA = array("41", "22", "27", '30');
    $PEBA = array("29", "22", "27", '30');
    //art
    $HEPP = array("21", "22", "32", '29');
    $MEBA = array("75", "22", "27", '30');
    $MSBA = array("75", "31", "27", '30');
    $HEPS = array("21", "22", "29", '28');

    switch ($stream_name) {
        case "PCMB":
            return  $PCMB;
            break;
        case "PCMC":
            return $PCMC;
            break;
        case "PCME":
            return $PCME;
            break;
        case "PCMS":
            return $PCMS;
            break;
        case "PEBA":
            return $PEBA;
            break;
        case "BEBA":
            return $BEBA;
            break;
        case "BSBA":
            return $BSBA;
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
        case "HEPP":
            return $HEPP;
            break;
        case "HEPS":
            return $HEPS;
            break;
        case "MEBA":
            return $MEBA;
            break;
        case "MSBA":
            return $MSBA;
            break;
    }
}
?>
<script>
</script>