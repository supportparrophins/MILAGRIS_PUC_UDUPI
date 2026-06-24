<?php require APPPATH . 'views/includes/db.php'; ?>
<style>
.break { page-break-before: always; } 
.break_after { page-break-before: none; } 

.row {
    padding: 2px !important;
    margin: 5px !important; 
    text-align: center;
}

/* .row > div {
    margin: 0px !important;
    padding: 0px !important;
    text-align: center;
}  */

.col-12 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100% !important;
} 
.text-center{
    text-align: center !important;
}

.title{
    font-size: 26px;
    margin-left: -25px;
}
.stm_work{
    font-size: 24px;
    font-weight: bold;
}

table{
    width: 100% !important;
}
.table_bordered{
    border-collapse: collapse;
    width: 100% !important;
    margin: 8px 20px 1px 20px;;
    align: center;
    font-size: 14px;
}

.table_bordered tr th, .table_bordered tr td{
    border: 1px solid black;
    padding: 4px !important;
    border-spacing: 0;
}

.table_borderedNone{
    border-collapse: collapse;
    width: 100% !important;
    margin: 8px 0px 1px 20px;;
    align: center;
    font-size: 14px;
}

.table_borderedNone tr th, .table_borderedNone tr td{
    border: none;
    padding: 0px !important;
    border-spacing: 0;
}

.container{
    color: black !important;
}
.hrstyle{
    border: 1px solid black !important;
}
.dotted {
  border: 1px dotted black !important;
}
</style>
<?php 
    $totalStudentCount = count($studentsRecords);
    foreach($studentsRecords as $record){
    
        $totalStudentCount--;
?>
    <div class="container">
        <table>
            <tr>
                
                <td  class="text-center">
                    <b class="title">ST. JOSEPH'S PRE-UNIVERSITY COLLEGE</b>
                    <p style="margin-top:-45px;">College Addres</p>
                   <!--  <p style="margin-top: 10px;" class="text-center mb-2">Recognised by the Department of Pre University Education, Government of Karnataka</p> -->
                </td>
            </tr>
        </table>
        <div class="row ">
            <div class="col-12">
                <div class="text-center stm_work"><img  src="<?php echo base_url(); ?>assets/dist/img/logo_sjpuch.jpg" height="80" alt="SJPUC Logo" class="sjpuch_logo" /></div>
            </div>
        </div>
        <br>
        <div class="row ">
            <div class="col-12">
                <div class="text-center stm_work">STATEMENT OF MARKS</div>
            </div>
        </div>

        <div class="row ">
            <div class="col-12">
                <div class="text-center" style="font-size: 20px;">I PUC ANNUAL EXAMINATION HELD IN MARCH/ APRIL - 2022
            </div>
        </div>
        <br>
        <br>

       <!--  <div class="row ">
            <div class="col-12 text-center">
                <p style="font-size: 14px;" class="mb-3">ಈ ಕೆಳಗೆ ನಮೂದಿಸಿದ ಅಭ್ಯರ್ಥಿಯು ಪದವಿ ಪೂರ್ವ ಶಿಕ್ಷಣದ ಪ್ರಥಮ ಪಿಯುಸಿ ಕೋರ್ಸನ್ನು ಈ ಕೆಳಗಿನ ವಿವರಗಳೊಂದಿಗೆ ಉತ್ತೀರ್ಣರಾಗಿರುತ್ತಾರೆಂದು ಪ್ರಮಾಣೀಕರಿಸಲಾಗಿದೆ.
                </p> 
            </div>
        </div> -->

       <!--  <div class="row mb-0">
            <div class="col-12 text-center">
                <p style="font-size: 15px; margin-top: -10px;" class="mb-3">This is to certify that the Candidate mentioned below has completed the First Year Pre-University Course with following details.</p>
            </div>
        </div> -->
        
        <?php
            $student_id = $record->student_id;
            $profile_image_url = base_url().'assets/images/PHOTOS_20_21_ALL/'.strtoupper($student_id).'.jpg';
            $check_file_exist = file_exists_case($profile_image_url);
        ?>

         
        
        <div class="row">
            <div class="col-12">
                 <table class="table table_borderedNone" style="margin-bottom: 10px;">>
                    <tr>
                        <td width="300">Name: <b><?php echo strtoupper($record->student_name); ?></b></td>
                        <td width="100"></td> 
                        <td width="300">Reg. No:<b><?php echo strtoupper($record->student_id); ?></b></td>
                    </tr>
                </table>
                <table class="table table_bordered" style="margin-bottom: 20px;">>
                    <tr>
                        <td width="180">Name of the Candidate</td>
                        <td width="265"><b><?php echo strtoupper($record->student_name); ?></b></td> 
                        <th width="145" rowspan="6" class="text-center">
                        <img  src="<?php echo $profile_image_url; ?>" width="135" height="170" alt="PHOTO" class="sjpuch_logo" />
                        </th>
                    </tr>
                    <tr>
                        <td>Name of the Father</td>
                        <td><b><?php echo strtoupper($record->father_name); ?></b></td>
                    </tr>
                    <tr>
                        <td>Name of the Mother</td>
                        <td><b><?php echo strtoupper($record->mother_name); ?></b></td>
                    </tr>
                    <tr>
                        <td>College Code</td>
                        <td><b>CODE</b></td>
                    </tr>
                    <tr>
                        <td>College Register No.</td>
                        <td><b><?php echo strtoupper($record->student_id)?></b></td>
                    </tr>
                    <tr>
                        <td>SATS Number</td>
                        <td><b><?php echo strtoupper($record->pu_board_number) ?></b></td>
                    </tr>
                </table>
            </div>
            
            <?php 
            $exam_status = false;
                $overall_total = 0;
                $max_mark = 600;
                $subjects_code = array();
                $elective_sub = strtoupper($record->elective_sub);
                if($elective_sub == "KANNADA"){
                    array_push($subjects_code, '01');
                }else if($elective_sub == 'HINDI'){
                    array_push($subjects_code, '03');
                } else if($elective_sub == 'FRENCH'){
                    array_push($subjects_code, '12');
                }else{
                    $exam_status = true;
                }
                array_push($subjects_code, '02');
                $subjects = getSubjectCodes($record->stream_name);
                $subjects_code = array_merge($subjects_code,$subjects);
            ?>
            <table class="table table_bordered">
                <tr class="text-center" >
                    <th width="160" rowspan="2" class="text-center">SUBJECT NAME</th>
                    <th width="50" rowspan="2" class="text-center">MAX. MARKS</th>
                    <th width="285" colspan="2" class="text-center">MARKS OBTAINED</th>
                </tr>
                <tr class="text-center">
                    <th  width="80" class="text-center">IN FIGURES</th>
                    <th width="260" class="text-center">IN WORDS</th>
                </tr>
                <tr>
                    <th class="text-center" colspan="4">PART-I Languages</th>
                </tr>
                <?php 
                 $fail_flag = false;
                foreach($subjects_code as $subject){ 
                    $subjectInfo = getSubjectInfo($con,$subject);
                    if($subject == 12){
                        $labStatus = 'true';
                    }else{
                        $labStatus = 'false';
                    }
                    $exam_type = array('ANNUAL_EXAMINATION');
                    if($exam_status == false){
                    if($subject == '01' || $subject == '03' || $subject == '12'){
                        $total_mark = 0;
                        foreach($exam_type as $exam){
                            $stdMarkInfo = getStudentFinalMarks($con,$record->student_id,$subject,$exam);
                            $sub_marks = 0;
                            $mark_obt = 0;
                            if($stdMarkInfo['obt_theory_mark'] == 'AB' || $stdMarkInfo['obt_theory_mark'] == 'EXEM' || $stdMarkInfo['obt_theory_mark'] == 'MP' ){
                                $mark_obt = $stdMarkInfo['obt_theory_mark'];
                            }else{
                                $mark_obt = $stdMarkInfo['obt_theory_mark'] + $stdMarkInfo['obt_lab_mark'];
                            }
                            $total_mark += $mark_obt;
                        }
                        if($labStatus == 'true'){
                            if ($stdMarkInfo['obt_theory_mark'] < 24) {
                                $fail_flag = true;
                            }
                        }
                        if ($mark_obt < 35) {
                            $fail_flag = true;
                        }
                    ?>
                    <tr>
                        <td><?php echo $subjectInfo["name"]; ?></td>
                        <td class="text-center">100</td>
                        <td class="text-center"><?php echo $mark_obt; ?></td>
                        <td><?php echo convert_number($mark_obt).' Only'; ?></td>
                    </tr>
                <?php 
                    $overall_total += $mark_obt;
                }
            }else{
                $max_mark = 500;
            }
                    if($subject == '02'){
                    $total_mark=0;
                    foreach($exam_type as $exam){
                        $stdMarkInfo = getStudentFinalMarks($con,$record->student_id,$subject,$exam);
                        $sub_marks = 0;
                        $mark_obt = 0;
                        if($stdMarkInfo['obt_theory_mark'] == 'AB' || $stdMarkInfo['obt_theory_mark'] == 'EXEM' || $stdMarkInfo['obt_theory_mark'] == 'MP' || $stdMarkInfo['obt_theory_mark'] ==  'ASGN'){
                            $mark_obt = $stdMarkInfo['obt_theory_mark'];
                        }else{
                            $mark_obt = $stdMarkInfo['obt_theory_mark'];
                        }
                        $total_mark += $mark_obt;
                    }
                    if ($mark_obt < 35) {
                        $fail_flag = true;
                    }
                    ?>
                    <tr>
                        <td><?php echo $subjectInfo["name"]; ?></td>
                        <td class="text-center">100</td>
                        <td class="text-center"><?php echo $mark_obt; ?></td>
                        <td><?php echo convert_number($mark_obt).' Only'; ?></td>
                    </tr>
                <?php 
                    $overall_total += $mark_obt; 
                } 
                    } ?>
                <tr>
                    <th class="text-center" colspan="4">PART-II Optionals</th>
                </tr>
                <?php foreach($subjects as $sub_code){ 
                    $subjectInfo = getSubjectInfo($con,$sub_code);
                    $exam_type = array('ANNUAL_EXAMINATION');
                    $total_mark = 0;
                    $labStatus = $subjectInfo['lab_status'];
                    $mark_display = "";
                    foreach($exam_type as $exam){
                        $stdMarkInfo = getStudentFinalMarks($con,$record->student_id,$sub_code,$exam);
                        $mark_obt_lab = 0;
                        $sub_marks = 0;
                        $mark_obt = 0;
                        if($stdMarkInfo['obt_theory_mark'] == 'AB' || $stdMarkInfo['obt_theory_mark'] == 'EXEM' || $stdMarkInfo['obt_theory_mark'] == 'MP' || $stdMarkInfo['obt_theory_mark'] ==  'ASGN'){
                            $mark_obt = $stdMarkInfo['obt_theory_mark'];
                            $mark_display =  $stdMarkInfo['obt_theory_mark'];
                        }else{
                            $mark_obt = $stdMarkInfo['obt_theory_mark'];
                        }
                        if ($mark_obt < 21) {
                            $fail_flag = true;
                        }
                        if($stdMarkInfo['obt_lab_mark'] == 'AB' || $stdMarkInfo['obt_lab_mark'] == 'EXEM' || $stdMarkInfo['obt_lab_mark'] == 'MP' || $stdMarkInfo['obt_lab_mark'] ==  'ASGN'){
                            $mark_obt_lab = $stdMarkInfo['obt_theory_mark'];
                           
                        }else{
                            $mark_obt_lab = $stdMarkInfo['obt_lab_mark'];
                        }
                        $total_mark_sub = $mark_obt_lab + $mark_obt;
                        if ($total_mark_sub < 35) {
                            $fail_flag = true;
                        }
                        $total_mark += $mark_obt_lab + $mark_obt;
                    }
                   
                ?>
                    <tr>
                        <td><?php echo $subjectInfo["name"]; ?></td>
                        <td class="text-center">100</td>
                        <td class="text-center"><?php 
                        if($mark_display == 'AB'){
                            echo $mark_display;
                        }else{
                            echo $total_mark_sub;
                        }
                        ?></td>
                        <td><?php  
                         if($mark_display == 'AB'){
                            echo 'AB';
                         }else{
                            echo convert_number($total_mark_sub).' Only';
                         }
                        ?></td>
                    </tr>
                <?php
                    $overall_total += $total_mark; } 
                    if($fail_flag == true){
                        $final_result = "Detained"; 
                       
                    }else{
                        $final_result = calculateResult($overall_total); 
                    }
                    
                    $total_marks_words = convert_number($overall_total); ?>
                <tr>
                    <th>TOTAL</th>
                    <th class="text-center"><?php echo $max_mark; ?></th>
                    <th class="text-center"><?php echo $overall_total; ?></th>
                    <td><?php echo $total_marks_words.' Only'; ?></td>
                </tr>
                <!-- <tr class="text-center" style="font-size: 16px;">
                    <th style="padding:12px !important"  class="text-center"><b>RESULT</b></th>
                    <td colspan="3" class="text-center"><b><?php echo strtoupper($final_result); ?></b></td> -->
                    <!-- <td></td> -->
                <!-- </tr> -->
            </table>
            <br>
             <table class="table table_borderedNone" style="margin-bottom: 20px;">
                    <tr>
                        <td width="450">Total Marks in words: <b><?php echo $total_marks_words.' Only'; ?></b></td>
                        <td width="85"></td> 
                        <td>Result:<b><?php echo strtoupper($final_result); ?></b></td>
                    </tr>
                </table>
                
                <div class="hrstyle" style="font-size: 14px;text-align:left"></div>
        </div>
            <?php $issue_date ='Date: '.date("d/m/Y").'';  ?>

        </div>


        <div class="row " style="margin-top: 70px;">
            <div class="col-6">
                 <div class="dotted"  style="width:23%;text-align:left;margin-left:0;"></div>
                <div class="text-left" style="font-size: 14px;text-align:left">Signature of the Student
            </div>
        </div>
            
           <table style="margin-top: 90px;">
            <tr>
                <td width="210"><?php echo $issue_date; ?></td>
                <td class="text-center" width="280">College Seal</t>
                <td width="210" style="text-align: center;">Principal</td>
            </tr>
        </table>
    
   </div>

<?php 
 if($totalStudentCount != 0){
    echo '<div class="break"></div>';
}else{
    echo '<div class="break_after"></div>';
}

} ?>


<?php 



// function getSubjectCodes($stream_name) {

//     //science
//     $PCMB = array("33", "34", "35", '36');
//     $PCMC = array("33", "34", "35", '41');
//     $PCME = array("33", "34", "35", '40');
//     $PCMS = array("33", "34", "35", '31');
//     //commarce
//     $PEBA = array("29", "22", "27", '30');
//     $MEBA = array("75", "22", "27", '30');
//     $MSBA = array("75", "31", "27", '30');
//     $CSBA = array("41", "31", "27", '30');
//     $SEBA = array("31", "22", "27", '30');
//     $CEBA = array("41", "22", "27", '30');

//     //art
//     $HEPS = array("21", "22", "29", '28');

//     switch ($stream_name) {
//         case "PCMB":
//             return  $PCMB;
//             break;
//         case "PCMC":
//             return $PCMC;
//             break;
//         case "PEBA":
//             return $PEBA;
//             break;
//         case "PCME":
//             return $PCME;
//             break;
//         case "PCMS":
//                 return $PCMS;
//                 break;
//         case "MEBA":
//             return $MEBA;
//             break;
//         case "MSBA":
//             return $MSBA;
//             break;
//         case "CSBA":
//             return $CSBA;
//             break;
//         case "SEBA":
//             return $SEBA;
//             break;
//         case "CEBA":
//             return $CEBA;
//             break;
//         case "HEPS":
//             return $HEPS;
//             break;
//     }

// }
 function getSubjectCodes($stream_name){
    //science
    $PCMB = array("33", "34", "35", '36');
    $PCMC = array("33", "34", "35", '41');
    $PCME = array("33", "34", "35", '40');
    $PCMS = array("33", "34", "35", '31');
    $PCBH = array("33", "34", "36", '67');
    //commarce
    $BEBA = array("75", "22", "27", '30');
    $BSBA = array("75", "31", "27", '30');
    $CSBA = array("41", "31", "27", '30');
    $SEBA = array("31", "22", "27", '30');
    $CEBA = array("41", "22", "27", '30');
    //art
    $HEPS = array("21", "22", "29", '28');
    $HEPP = array("21", "22", "32", '29');
    $MEBA = array("75", "22", "27", '30');
    $MSBA = array("75", "31", "27", '30');

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
        case "PCBH":
            return $PCBH;
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
        case "HEBA":
            return $HEBA;
            break;
        case "MEBA":
            return $MEBA;
            break;
        case "MSBA":
            return $MSBA;
            break;
    }
}
function calculateResultSubjectOne($percentage){
    if($percentage >= 85){
        return "Distinction";
    } else if($percentage >= 60 && $percentage <= 84){
        return "I Class";
    } else if($percentage >= 50 && $percentage <= 59){
        return "II Class";
    } else if($percentage >= 35 && $percentage <= 49){
        return "III Class";
    }else{
        return "Detained";
    }
}

function calculateResult($total_marks){
    $percentage = floor(($total_marks / 600) * 100);
    if($percentage >= 85){
        return "Distinction";
    } else if($percentage >= 60 && $percentage <= 84){
        return "I Class";
    } else if($percentage >= 50 && $percentage <= 59){
        return "II Class";
    } else if($percentage >= 35 && $percentage <= 49){
        return "III Class";
    }else{
        return "Detained";
    }
}

function getAssignmentExamTheoryTotalMark($student_id,$subject_code,$lab_status){
        
    if($subject_code == 12){
        $labStatus = 'true';
    }else{
        $labStatus = $lab_status;
    }
    if($labStatus == 'true'){
        if($subject_code == 12){
            $pass_mark_theory = 25;
            $pass_mark_lab = 10;
            $lab_assessment = 10;
        }else{
            $pass_mark_theory = 21;
            $pass_mark_lab = 14;
            $lab_assessment = 16;
        }
    }else{
        $pass_mark_theory = 35;
        $pass_mark_lab = 0;
        $lab_assessment = 0;
    }
   
    if($student_id == '20P5965' || $student_id == '20P4140' || $student_id == '20P1754'){
        $internal_assessment = 1;
    }else{
        $internal_assessment = 5;
    }
    $exam_type = array('ANNUAL_EXAMINATION');
    $total_mark=0;
    if($sub_code == 12){
        $labStatus = 'true';
    }else{
        $labStatus = $subjectInfo['lab_status'];
    }
    // ,'INTERNAL_ASSESSMENT','LAB_ASSESSMENT'$total_mark + 
        
    
    
    $totalMark = $pass_mark_theory + $internal_assessment + $pass_mark_lab + $lab_assessment;
    return $totalMark;
}


   
function getAssessmentMark($totalMark,$exam_type,$labStatus,$subject_code){
    if(is_numeric($totalMark) && !empty($totalMark)){
        if($labStatus == 'false'){ 
            if($exam_type == 'ASSIGNMENT_I' || $exam_type == 'ASSIGNMENT_II'){
                if($totalMark >= 81 && $totalMark <= 100){
                    return '30';
                }else if($totalMark >= 71 && $totalMark <= 80){
                    return '25';
                }else if($totalMark >= 61 && $totalMark <= 70){
                    return '20';
                }else if($totalMark >= 51 && $totalMark <= 60){
                    return '15';
                }else if($totalMark >= 41 && $totalMark <= 50){
                    return '10';
                }else{
                    return '5';
                }
            }
        }else{
            if($exam_type == 'ASSIGNMENT_I' && $subject_code == '12' || $exam_type == 'ASSIGNMENT_II' && $subject_code == '12'){
                if($totalMark >= 26 && $totalMark <= 35){
                    return '4';
                }else if($totalMark >= 36 && $totalMark <= 45){
                    return '8';
                }else if($totalMark >= 46 && $totalMark <= 55){
                    return '12';
                }else if($totalMark >= 56 && $totalMark <= 65){
                    return '16';
                }else if($totalMark >= 66 && $totalMark <= 75){
                    return '20';
                }else{
                    return '25';
                }
            }else if($exam_type == 'ASSIGNMENT_I' || $exam_type == 'ASSIGNMENT_II'){
                if($totalMark >= 1 && $totalMark <= 28){
                    return '4';
                }else if($totalMark >= 29 && $totalMark <= 35){
                    return '8';
                }else if($totalMark >= 36 && $totalMark <= 42){
                    return '12';
                }else if($totalMark >= 43 && $totalMark <= 49){
                    return '16';
                }else if($totalMark >= 50 && $totalMark <= 56){
                    return '19';
                }else{
                    return '22';
                }
            }
        }
    }else{
        return '';
    }
}

function getStudentFinalMarks($con,$student_id,$subjects_code,$exam_type){
    $query = "SELECT * FROM tbl_college_internal_exam_marks as exam
    WHERE exam.student_id = '$student_id' AND exam.subject_code = '$subjects_code' 
    AND exam.exam_type = '$exam_type' AND exam.is_deleted = 0";
    $pdo_statement = $con->prepare($query);
    $pdo_statement->execute();
    return $pdo_statement->fetch();
}

function getSubjectInfo($con,$subject_code){
    $query = "SELECT * FROM tbl_subjects as sub
    WHERE sub.subject_code = '$subject_code'";
    $pdo_statement = $con->prepare($query);
    $pdo_statement->execute();
    return $pdo_statement->fetch();
}

function getSubjectTotal($result,$subjects){

    $subject_total = 0;

    foreach($result as $row) { 

    for($i=0; $i<4; $i++){

        if($row["subject_code"] == $subjects[$i]){

            $subject_total += (int)$row["obt_theory_mark"] + (int)$row["obt_lab_mark"];

        }

    }

}

return $subject_total;

}





function calculatePercentage($percentage){

    return floor(($percentage / 600) * 100);

}






function convert_number($number) {

    if (($number < 0) || ($number > 999999999)) {

        throw new Exception("Number is out of range");

    }

    $Gn = floor($number / 1000000);

    /* Millions (giga) */

    $number -= $Gn * 1000000;

    $kn = floor($number / 1000);

    /* Thousands (kilo) */

    $number -= $kn * 1000;

    $Hn = floor($number / 100);

    /* Hundreds (hecto) */

    $number -= $Hn * 100;

    $Dn = floor($number / 10);

    /* Tens (deca) */

    $n = $number % 10;

    /* Ones */

    $res = "";

    if ($Gn) {

        $res .= $this->convert_number($Gn) .  "Million";

    }

    if ($kn) {

        $res .= (empty($res) ? "" : " ") .convert_number($kn) . " Thousand";

    }

    if ($Hn) {

        $res .= (empty($res) ? "" : " ") .convert_number($Hn) . " Hundred";

    }

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");

    $tens = array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety");

    if ($Dn || $n) {

        if (!empty($res)) {

            $res .= " ";

        }

        if ($Dn < 2) {

            $res .= $ones[$Dn * 10 + $n];

        } else {

            $res .= $tens[$Dn];

            if ($n) {

                $res .= "-" . $ones[$n];

            }

        }

    }

    if (empty($res)) {

        $res = "zero";

    }

    return $res;

}





function file_exists_case($strUrl)

{

$realPath = str_replace('\\','/',realpath($strUrl));



if(file_exists($strUrl) && $realPath == $strUrl)

{

    return 1;    //File exists, with correct case

}

elseif(file_exists($realPath))

{

    return 2;    //File exists, but wrong case

}

else

{

    return 0;    //File does not exist

}

}
?>