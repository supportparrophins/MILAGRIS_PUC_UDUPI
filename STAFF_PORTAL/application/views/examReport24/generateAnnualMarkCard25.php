<?php require APPPATH . 'views/includes/db.php'; ?>
<?php 
ini_set('memory_limit', '1024M');
ini_set("pcre.backtrack_limit", "5000000");
ini_set('max_execution_time', -1); ?>
<style>
    .break {
        page-break-before: always;
    }

    .break_after {
        page-break-before: none;
    }

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

    .text-center {
        text-align: center !important;
    }

    .title {
        font-size: 26px;
        margin-left: -25px;
    }

    .title_2 {
        font-size: 18px;
        margin-left: -25px;
    }

    .stm_work {
        font-size: 24px;
        font-weight: bold;
    }

    .heading {
        font-size: 22px;
        /* font-weight: bold;*/
    }

    table {
        width: 100% !important;
    }

    .table_bordered {
        border-collapse: collapse;
        width: 100% !important;
        margin: 8px 20px 1px 20px;
        ;
        align: center;
        font-size: 13px;
    }

    .table_bordered tr th,
    .table_bordered tr td {
        border: 1px solid black;
        padding: 4px !important;
        border-spacing: 0;
    }

    .stdtable_bordered {
        border-collapse: collapse;
        width: 100% !important;
        margin: 8px 20px 1px 20px;
        ;
        align: center;
        font-size: 12px;
    }

    .stdtable_bordered tr th,
    .stdtable_bordered tr td {
        border: 1px solid black;
        padding: 2px !important;
        border-spacing: 0;
    }

    .table_borderedNone {
        border-collapse: collapse;
        width: 100% !important;
        margin: 8px 0px 1px 20px;
        ;
        align: center;
        font-size: 14px;
    }

    .table_borderedNone tr th,
    .table_borderedNone tr td {
        border: none;
        padding: 0px !important;
        border-spacing: 0;
    }

    .table_college_header {
        border-collapse: collapse;
        width: 100% !important;
        margin: 8px 20px 1px 20px;
        ;
        align: center;
        font-size: 11px;
    }

    .table_college_header tr th,
    .table_college_header tr td {
        border: 1px solid black;
        padding: 2px !important;
        border-spacing: 0;
    }

    .border_full {
        border: 7px solid black !important;
        border-style: double !important;
        
    }

    .container {
        color: black !important;
    }

    .hrstyle {
        border: 1px solid black !important;
    }

    hr {
        display: block;
        border-style: inset;
        border-width: 1px solid black;
    }

    .dotted {
        border: 1px dotted black !important;
    }

    .table_photo_frame {
        border-collapse: collapse;
        width: 100px !important;
        margin: 8px 30px 1px 20px;
        ;
        align: left !important;
        font-size: 11px;
    }

    .table_photo_frame tr th,
    .table_photo_frame tr td {
        border: 2px solid black;
        padding: 2px !important;
        border-spacing: 0;
    }
    .heading_new {
        font-size: 16px;
        /* font-weight: bold;*/
    }
</style>
<?php
$totalStudentCount = count($studentsRecords);
foreach ($studentsRecords as $record) {

    $totalStudentCount--;
?>
    <div class="border_full" style="" >
        <div class="container">
            <div class="row ">
                <div class="col-12">
                    <div class="text-center ">&nbsp;</div>

                    <div class="text-center heading"><b><?php echo ANNUAL_TITLE; ?></b></div>
                    <div class="text-center heading_new"><b><?php echo ANNUAL_ADDRESS; ?></b></div>
                    <br>
                    <table width="100%">
                        <tr>
                            <td align="left"><b>College Code No :- EE0272</b></td>
                            <td align="right"><b>UDISE Code :- 29031401417</b></td>
                        </tr>
                    </table>

                </div>
                <?php
                $profile_image_url = $record->photo_url;
                $std_id = substr($record->student_id, 0, 2);
             
                    $student_id = strtoupper($record->student_id);
                    $base_url = base_url();
                    $profile_image_url = '';
        
                    $file_path_jpg = 'assets/images/students/' . $student_id . '.JPG';
                    if (file_exists($file_path_jpg)) {
                        $profile_image_url = $base_url . $file_path_jpg;
                    }else{
                        $file_path_jpg = 'assets/images/students/' . $student_id . '.jpg';
                        $profile_image_url = $base_url . $file_path_jpg;
                    }
                ?>
                <!-- <div class="col-12">
                    <div class="text-left" style="margin-top:-40px;margin-left: 600px;margin-bottom:5px">
                         <table class="table table_photo_frame" style="">
                        <tr>
                            <th height="105px" class="text-center" style=";"> <img src="<?php echo $profile_image_url; ?>" width="90" height="120" alt="PHOTO" class="sjpuc_logo" /></th>
                        </tr>
                    </table>
                    </div>
                </div> -->
            </div>


            <br>

            <div class="row ">
                <div class = "row" style="padding-top: -30px;">
            <div class="text-center" style = "font-size:17px;border: 1px solid black;width:300px;margin-left:200px;border-radius:25px;padding-top: 5px;"><b>ಪ್ರಮಾಣ ಪತ್ರ &nbsp;CERTIFICATE</b></div><br/>
            <b style="font-size: 14px" class="">I PUC ANNUAL EXAMINATION FEBRUARY/MARCH - 2025</b>
            </div>
            <div class="col-12 text-left" style="padding-top: -14px;">
                    <p style="font-size: 14px;text-align: center;margin-left: 30px;margin-right: 25px;" class="">ಈ ಕೆಳಗೆ ನಮೂದಿಸಿದ ಅಭ್ಯರ್ಥಿಯು ಪದವಿ ಪೂರ್ವ ಶಿಕ್ಷಣದ ಪ್ರಥಮ ವರ್ಷದ ಪರೀಕ್ಷೆಯಲ್ಲಿ ಕೆಳಗಿನ ವಿವರಗಳೊಂದಿಗೆ ತೇರ್ಗಡೆಯಾಗಿರುತ್ತಾರೆ ಎಂದು ಪ್ರಮಾಣೀಕರಿಸಲಾಗಿದೆ.
                    <br><i><span style="font-weight:bold;font-size: 14px;">This is to certify that the candidate mentioned below has passed the First Year Pre-University Examination with the following details</span></i>
                    </p>
                    <table class="" style="font-size: 12px; margin: 8px 20px 1px 20px;">
                        <tr>
                            <td style="width:60px;font-size: 12.5px;">
                                <p> ಅಭ್ಯರ್ಥಿಯ ಹೆಸರು </p>Candidate's Name 
                            </td>
                            <td style="width:50px;">
                            <img src="<?php echo base_url(); ?>assets/dist/img/feature.png" width="30" height="50" style="padding-left:-76px" alt="PHOTO" class="sjpuc_logo" /> 
                            </td>                   
                                             
                            <td style="padding-left:-104px;width:180px">
                        <b>&nbsp;<?php echo strtoupper($record->student_name); ?></b></td>
                        <!-- <td style="padding-left:70px;font-size: 12.5px;">
                                <p> ನೋಂದಣಿ ಸಂಖ್ಯೆ </p>Register Number
                            </td>
                            <td style="width:50px;">
                            <img src="<?php echo base_url(); ?>assets/dist/img/feature.png" width="30" height="50" style="padding-left:-3px" alt="PHOTO" class="sjpuc_logo" /> 
                            </td> 
                            <td style="width:100px;padding-left:-28px">
                        <b>&nbsp;<?php echo strtoupper($record->student_id); ?></b></td> -->
                        <td style="padding-left:70px;padding-top:-10px;font-size: 12.5px;">
                                <p> ಸ್ಯಾಟ್ಸ್ ಸಂಖ್ಯೆ </p>SATS Number &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
                            </td>
                            <td style="width:50px;padding-top:-10px">
                            <img src="<?php echo base_url(); ?>assets/dist/img/feature.png" width="30" height="50" style="padding-left:-2px" alt="PHOTO" class="sjpuc_logo" /> 
                            </td>  
                            <td style="width:100px;padding-left:-26px">
                        <b>&nbsp;<?php $satNumber = $record->sat_number;
                            // Check the length of sat_number and adjust accordingly
                            if (strlen($satNumber) == 9) {
                                echo strtoupper($satNumber);
                            } elseif (strlen($satNumber) == 8) {
                                echo strtoupper('0' . $satNumber);
                            } elseif (strlen($satNumber) == 7) {
                                echo strtoupper('00' . $satNumber);
                            } elseif (strlen($satNumber) == 6) {
                                echo strtoupper('000' . $satNumber);
                            }elseif (strlen($satNumber) == 5) {
                                echo strtoupper('0000' . $satNumber);
                            }elseif (strlen($satNumber) == 4) {
                                echo strtoupper('00000' . $satNumber);
                            }elseif (strlen($satNumber) == 3) {
                                echo strtoupper('000000' . $satNumber);
                            }  else {
                                // Handle other cases as needed
                                echo '';
                            } ?></b></td>
                           
                        </tr>
                        <tr>
                            <td style="padding-top:-10px;font-size: 12.5px;">
                                <p> ತಾಯಿಯ ಹೆಸರು </p>Mother's Name
                            </td>
                            <td style="width:50px;padding-top:-10px">
                            <img src="<?php echo base_url(); ?>assets/dist/img/feature.png" width="30" height="50" style="padding-left:-76px" alt="PHOTO" class="sjpuc_logo" /> 
                            </td>
                            <td style="padding-left:-104px;padding-top:-10px;width:180px"><b>&nbsp;<?php echo strtoupper($record->mother_name); ?></b></td>
                            <td width="185" style="padding-left:70px;padding-top:-10px;font-size: 12.5px;">
                                <p> ಪರೀಕ್ಷಾ ವರ್ಷ/ ತಿಂಗಳು </p>Exam Year /Month  
                            </td>
                            <td style="width:50px;padding-top:-10px">
                            <img src="<?php echo base_url(); ?>assets/dist/img/feature.png" width="30" height="50" style="padding-left:-1px" alt="PHOTO" class="sjpuc_logo" /> 
                            </td>  
                            <td style="width:100px;padding-left:-24px;padding-top:-10px">
                        <b> February/March 2025</b></td>
                        </tr>
                        <tr>
                            <td width="180" style="padding-top:-10px;font-size: 12.5px;">
                                <p> ತಂದೆಯ ಹೆಸರು </p>Father's Name
                            </td>
                            <td style="width:50px;padding-top:-10px">
                            <img src="<?php echo base_url(); ?>assets/dist/img/feature.png" width="30" height="50" style="padding-left:-76px" alt="PHOTO" class="sjpuc_logo" /> 
                            <td style="padding-left:-104px;padding-top:-10px;width:180px"><b>&nbsp;<?php echo strtoupper($record->father_name); ?></b></td>
                            
                        </tr>
                    </table>
                </div>

                <?php
                $exam_status = false;
                $overall_total = 0;
                $overall_theory_total = 0;
                $overall_practical_total = 0;
                $max_mark = 600;
                $subjects_code = array();
                array_push($subjects_code, '2');
                $elective_sub = strtoupper($record->elective_sub);
                if ($elective_sub == "KANNADA") {
                    array_push($subjects_code, '1');
                } else if ($elective_sub == 'HINDI') {
                    array_push($subjects_code, '3');
                } else if ($elective_sub == 'FRENCH') {
                    array_push($subjects_code, '12');
                } else {
                    $exam_status = true;
                }
                $subjects = getSubjectCodes($record->stream_name);
                $subjects_code = array_merge($subjects_code, $subjects);
                ?>
                <table class="table table_bordered" style = "line-height:1.25">
                <tr class="text-center">
                        <td width="240"  class="text-center">ವಿಷಯಗಳು &nbsp;Subjects</td>
                        <td width="95" rowspan="3" class="text-center">ವಿಷಯದ ಸಂಕೇತ<br>Subject Code</td>
                        <td width="80" rowspan="3" class="text-center">ಗರಿಷ್ಠಾಂಕ<br>Max. Marks</td>
                        <td width="285" colspan="4" class="text-center">ಪಡೆದ ಅಂಕಗಳು<br>Marks Obtained</td>
                    </tr>
                    <tr class="text-center">
                        <td class="text-center" rowspan="2">ಭಾಗ 1 - ಭಾಷೆಗಳು<br>&nbsp;&nbsp;&nbsp;Part I - Languages</td>
                        <td width="225" colspan="3" class="text-center">ಅಂಕಿಗಳಲ್ಲಿ<br>In Figures</td>
                        <td width="200" rowspan="2" class="text-center">ಅಕ್ಷರಗಳಲ್ಲಿ<br>In Words</td>
                    </tr>
                    <tr class="text-center">
                        <td width="75"  class="text-center">Theory</td>
                        <td width="75" class="text-center">Practical/Internals</td>
                        <td width="75" class="text-center">Total</td>
                    </tr>
                    <!-- <tr>
                        <td class="text-center" colspan="4">ಭಾಗ - 1 ಭಾಷೆಗಳು<br>PART-I Languages</td>
                    </tr> -->
                    <?php
                    $fail_flag = false;
                    $fail_main = false;
                    $main_fail = false;
                    $lang_total = 0;
                    $first_lang_mark = 0;
                    foreach ($subjects_code as $subject) {
                        $subjectInfo = getSubjectInfo($con, $subject);
                        if ($subject == 12) {
                            $labStatus = 'true';
                        } else {
                            $labStatus = 'false';
                        }
                        $exam_type = array('Final Exam');
                        if ($exam_status == false) {
                            if ($subject == '1' || $subject == '3' || $subject == '12') {
                                $total_mark = 0;
                                $total_theory_obtained = 0;
                                $total_lab_obtained = 0;
                                foreach ($exam_type as $exam) {
                                    $stdMarkInfo = getStudentFinalMarks($con, $record->student_id, $subject, $exam,EXAM_YEAR);
                                    $sub_marks = 0;
                                    $mark_obt = 0;
                                    if ($stdMarkInfo['obt_theory_mark'] == 'AB' || $stdMarkInfo['obt_theory_mark'] == 'EXEM' || $stdMarkInfo['obt_theory_mark'] == 'MP') {
                                        $theory_obtained = $stdMarkInfo['obt_theory_mark'];
                                    } else {
                                        $theory_obtained = $stdMarkInfo['obt_theory_mark'];
                                    }
                                    if ($stdMarkInfo['obt_lab_mark'] == 'AB' || $stdMarkInfo['obt_lab_mark'] == 'EXEM' || $stdMarkInfo['obt_lab_mark'] == 'MP') {
                                        $lab_obtained = $stdMarkInfo['obt_lab_mark'];  
                                    } else {
                                        $lab_obtained = $stdMarkInfo['obt_lab_mark'];
                                    }
                                    $mark_obt = $theory_obtained + $lab_obtained;

                                    $total_mark += $mark_obt;
                                    $total_theory_obtained += $theory_obtained;
                                    $total_lab_obtained += $lab_obtained;
                                    $lang_total += $mark_obt;
                                    $first_lang_mark = $mark_obt;
                                }
                                // if ($labStatus == 'true') {
                                //     if ($stdMarkInfo['obt_theory_mark'] < 24) {
                                //         $fail_flag = true;
                                //         $main_fail = true;
                                //     }
                                // }
                                if ($stdMarkInfo['obt_theory_mark'] < 24) {
                                    $fail_flag = true;
                                    $main_fail = true;
                                }
                                if ($mark_obt < 35) {
                                    $fail_flag = true;
                                }
                    ?>
                                <tr>
                                    <td style="padding:7px;border-top:none;border-bottom:none;font-size: 14px;"> <?php echo $subjectInfo["name"]; ?></td>
                                    <td class="text-center" style="border-top:none;border-bottom:none;font-size: 14px;"><?php echo $subject ?></td>
                                    <td class="text-center" style="border-top:none;border-bottom:none;font-size: 14px;">100</td>
                                    <td class="text-center" style="border-top:none;border-bottom:none;font-size: 14px;"><?php echo $theory_obtained; ?></td>
                                    <td class="text-center" style="border-top:none;border-bottom:none;font-size: 14px;"><?php echo $lab_obtained; ?></td>
                                    <td class="text-center" style="border-top:none;border-bottom:none;font-size: 14px;"><?php echo $mark_obt; ?></td>
                                    <td style="border-top:none;border-bottom:none;font-size: 14px;"><?php echo convert_number($mark_obt) . ' Only'; ?></td>
                                </tr>
                            <?php
                                $overall_total += $mark_obt;
                                $overall_theory_total += $theory_obtained;
                                $overall_practical_total += $lab_obtained;

                            }
                        } else {
                            $max_mark = 500;
                        }
                        if ($subject == '2') {
                            $total_mark = 0;
                            foreach ($exam_type as $exam) {
                                $stdMarkInfo = getStudentFinalMarks($con, $record->student_id, $subject, $exam,EXAM_YEAR);
                                $sub_marks = 0;
                                $mark_obt = 0;
                                if ($stdMarkInfo['obt_theory_mark'] == 'AB' || $stdMarkInfo['obt_theory_mark'] == 'EXEM' || $stdMarkInfo['obt_theory_mark'] == 'MP' || $stdMarkInfo['obt_theory_mark'] ==  'ASGN') {
                                    $theory_obtained = $stdMarkInfo['obt_theory_mark'];
                                } else {
                                    $theory_obtained = $stdMarkInfo['obt_theory_mark'];
                                }
                                if ($stdMarkInfo['obt_lab_mark'] == 'AB' || $stdMarkInfo['obt_lab_mark'] == 'EXEM' || $stdMarkInfo['obt_lab_mark'] == 'MP') {
                                    $lab_obtained = $stdMarkInfo['obt_lab_mark'];  
                                } else {
                                    $lab_obtained = $stdMarkInfo['obt_lab_mark'];
                                }
                                $mark_obt = $theory_obtained + $lab_obtained;
                                $second_lang_mark = $mark_obt;
                                $total_mark += $mark_obt;
                                $lang_total += $mark_obt;
                                $total_theory_obtained += $theory_obtained;
                                $total_lab_obtained += $lab_obtained;
                            }
                            if ($stdMarkInfo['obt_theory_mark'] < 24) {
                                $fail_flag = true;
                                $main_fail = true;
                            }
                            if ($mark_obt < 35) {
                                $fail_flag = true;
                            }
                            ?>
                            <tr>
                                <td style="padding:7px;border-top:none;border-bottom:none;font-size: 14px;"><?php echo $subjectInfo["name"]; ?></td>
                                <td class="text-center" style="border-bottom:none;border-top:none;font-size: 14px;"><?php echo $subject ?></td>
                                <td class="text-center" style="border-top:none;border-bottom:none;font-size: 14px;">100</td>
                                <td class="text-center" style="border-top:none;border-bottom:none;font-size: 14px;"><?php echo $theory_obtained; ?></td>
                                <td class="text-center" style="border-top:none;border-bottom:none;font-size: 14px;"><?php echo $lab_obtained; ?></td>
                                <td class="text-center" style="border-top:none;border-bottom:none;font-size: 14px;"><?php echo $mark_obt; ?></td>
                                <td style="border-top:none;border-bottom:none;font-size: 14px;"><?php echo convert_number($mark_obt) . ' Only'; ?></td>
                            </tr>
                    <?php
                            $overall_total += $mark_obt;
                            $overall_theory_total += $theory_obtained;
                            $overall_practical_total += $lab_obtained;
                        }
                    } ?>
                     <tr>
                        <td class="text-center">ಭಾಗ 2 - ಐಚ್ಛಿಕ ವಿಷಯಗಳು<br>Part II - Optionals</td>
                        <td class="text-center" colspan="6"></td>
                    </tr>
                    <?php
                    $subject_total = array();
                    $i = 0;
                    $total_mark = 0;
                    $total_theroy_mark = 0;
                    $total_lab_mark = 0;
                    foreach ($subjects as $sub_code) {
                        $subjectInfo = getSubjectInfo($con, $sub_code);
                        $exam_type = array('Final Exam');
                        $labStatus = $subjectInfo['lab_status'];
                        $mark_display = "";
                        foreach ($exam_type as $exam) {
                            $stdMarkInfo = getStudentFinalMarks($con, $record->student_id, $sub_code, $exam,EXAM_YEAR);
                            $mark_obt_lab = 0;
                            $sub_marks = 0;
                            $mark_obt = 0;
                            $theory_obtained = 0;
                            $lab_obtained = 0;
                            if ($stdMarkInfo['obt_theory_mark'] == 'AB' || $stdMarkInfo['obt_theory_mark'] == 'EXEM' || $stdMarkInfo['obt_theory_mark'] == 'MP' || $stdMarkInfo['obt_theory_mark'] ==  'ASGN') {
                                $mark_obt = $stdMarkInfo['obt_theory_mark'];
                                $mark_display =  $stdMarkInfo['obt_theory_mark'];
                                $theory_obtained = $stdMarkInfo['obt_theory_mark'];
                            } else {
                                $mark_obt = $stdMarkInfo['obt_theory_mark'];
                                $theory_obtained = $stdMarkInfo['obt_theory_mark'];
                            }
                        if ($labStatus == "true") {
                            if ($mark_obt < 21) {
                                $fail_flag = true;
                                $main_fail = true;
                            }
                        }else{
                            if ($mark_obt < 24) {
                                $fail_flag = true;
                                $main_fail = true;
                            }
                        }
                            if ($stdMarkInfo['obt_lab_mark'] == 'AB' || $stdMarkInfo['obt_lab_mark'] == 'EXEM' || $stdMarkInfo['obt_lab_mark'] == 'MP' || $stdMarkInfo['obt_lab_mark'] ==  'ASGN') {
                                $mark_obt_lab = 0;
                                $lab_obtained = $stdMarkInfo['obt_lab_mark'];  
                            } else {
                                $mark_obt_lab = $stdMarkInfo['obt_lab_mark'];
                                $lab_obtained = $stdMarkInfo['obt_lab_mark'];  
                            }
                            $total_mark_sub = $mark_obt_lab + $mark_obt;
                            $total_mark_sub_display = $theory_obtained + $lab_obtained;
                            if ($total_mark_sub < 35) {
                                $fail_flag = true;
                            }
                            $total_mark += $mark_obt_lab + $mark_obt;
                            $total_theroy_mark += $theory_obtained;
                            $total_lab_mark += $lab_obtained;
                            $subject_total[$i] = $total_mark_sub;
                            $i++;
                        }
                    ?>
                        <tr>
                            <td style="padding:7px;border-top:none;border-bottom:none;font-size: 14px;"><?php echo $subjectInfo["name"]; ?></td>
                            <td class="text-center" style="border-bottom:none;border-top:none;font-size: 14px;"><?php echo $sub_code ?></td>
                            <td class="text-center" style="border-top:none;border-bottom:none;font-size: 14px;">100</td>
                            <td class="text-center" style="border-top:none;border-bottom:none;font-size: 14px;"><?php
                                                  
                                                        echo $theory_obtained;
                                                  
                                                    ?></td>
                            <td class="text-center" style="border-top:none;border-bottom:none;font-size: 14px;"><?php
                                                    
                                                        echo $lab_obtained;
                                                  
                                                    ?></td>
                            <td class="text-center" style="border-top:none;border-bottom:none;font-size: 14px;"><?php
                            
                                                    echo $total_mark_sub_display;
                                              
                                                ?></td>
                            <td style="border-top:none;border-bottom:none;font-size: 14px;"><?php
                                //if ($mark_display == 'AB') {
                                    //echo 'AB';
                                //} else {
                                    echo convert_number($total_mark_sub_display) . ' Only';
                                //}
                                ?></td>
                                
                        </tr>
                    <?php
                    }
                    $overall_total += $total_mark;
                    $overall_theory_total += $total_theroy_mark;
                    $overall_practical_total += $total_lab_mark;
                    if($main_fail == true){
                        $final_result = "FAILED";
                    }else{
                    if ($fail_flag == true) {
                        if ($total_mark >= 140) {
                            $max_mark_sub  = 400;
                            if ($subject_total[0] >= 30 && $subject_total[1] >= 30 && $subject_total[2] >= 30 && $subject_total[3] >= 30) {
                                $final_result =  calculateResult($overall_total, $max_mark_sub);

                                if($exam_status == false){
                                    if ($lang_total >= 70) {
                                        if ($first_lang_mark >= 30 && $second_lang_mark >= 30) {
                                            $final_result =  calculateResult($overall_total, $max_mark);
                                        }else {
                                            $final_result = "FAILED";
                                        }
                                    }
                                    else {
                                        $final_result = "FAILED";
                                    } 
                                }else{
                                    if ($lang_total >= 35) {
                                        $final_result =  calculateResult($overall_total, $max_mark);
                                    }else{
                                        $final_result = "FAILED";
                                    }
                                }
                                

                            } else {
                                $final_result = "FAILED";
                            }
                        }else{
                            $final_result = "FAILED";
                        }
                    } else {
                        $final_result =  calculateResult($overall_total, $max_mark);
                    }
                }
                    $total_marks_words = convert_number($overall_total);
                    $percentage = ($overall_total / $max_mark) * 100; ?>
                   <tr>
                        <td colspan="2" class="" style="text-align:right">ಒಟ್ಟು ಅಂಕಗಳು<br>Total Marks</td>
                        <th class="text-center;font-size: 15px;"><?php echo $max_mark; ?></th>
                        <th class="text-center;font-size: 15px;"><?php echo $overall_theory_total; ?></th>
                        <th class="text-center;font-size: 15px;"><?php echo $overall_practical_total; ?></th>
                        <th class="text-center;font-size: 15px;"><?php echo $overall_total; ?></th>
                        <td>ಪ್ರತಿಶತ<br>Percentage  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 15px;"><?php echo number_format($percentage, 2).'%'; ?></span></td>
                        <!-- <td><?php echo $total_marks_words . ' Only'; ?></td> -->
                    </tr>
                    <tr class="text-left" style="font-size: 16px;">
                        <td colspan="6" style="padding:7px !important;text-align: left!important;" class="text-left">&nbsp;ಅಂಕಗಳು ಅಕ್ಷರಗಳಲ್ಲಿ<br>&nbsp;Marks in words<b>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $total_marks_words . ' Only'; ?> </b></td>
                        <td colspan="4" style="">
                            ಪಡೆದ ದರ್ಜೆ<br>Class Obtained &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b class="text-center"><?php echo $final_result; ?></b></td>
                        <!-- <td></td> -->
                    </tr>
                    <tr class="text-left" style="font-size: 16px;">
                        <!-- <td  style="padding:7px !important;text-align: left!important;" class="text-left">&nbsp;ಕಾಲೇಜು ಸಂಕೇತ ಸಂಖ್ಯೆ<br>&nbsp;College Code No.<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EE0272 </b></td> -->
                        <td colspan="7" style="font-size:16px"> &nbsp;ಕಾಲೇಜು &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>LOYOLA PRE-UNIVERSITY COLLEGE</b><br>&nbsp;College &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:10px"><b>NEAR SHIVAGIRI, UKKALI ROAD, VIJAYAPUR - 586104</b></span></td>
                        <!-- <td></td> -->
                    </tr>
                </table>
                <br>
                <table style="font-size: 12px; margin: 8px 20px 5px 20px;">
                        <tr>
                            <!-- <td style="width:155px">
                                <p> ವಿದ್ಯಾರ್ಥಿ ವಿಧ </p>Student Type 
                            </td>
                            <td style="width:50px;">
                            <img src="<?php echo base_url(); ?>assets/dist/img/feature.png" width="30" height="50" style="padding-left:-80px" alt="PHOTO" class="sjpuc_logo" /> 
                            </td> 
                            <td style="width:50px;padding-left:-100px">
                        <b>&nbsp;<?php if($record->repeater_status == 1){echo "REPEATER";}else{echo "FRESHER";} ?></b></td> -->
                            <td style="width:130px">
                                <p> ಮಾಧ್ಯಮ </p>Medium 
                            </td>
                            <td style="width:50px;">
                            <img src="<?php echo base_url(); ?>assets/dist/img/feature.png" width="30" height="50" style="padding-left:-80px" alt="PHOTO" class="sjpuc_logo" /> 
                            </td> 
                                             
                            <td style="width:50px;padding-left:-170px">
                        <b>&nbsp;ENGLISH</b></td>
                        <td style="width:90px">
                                <p> ಫಲಿತಾಂಶ ದಿನಾಂಕ </p>Date of Result
                            </td>
                            <td style="width:50px;">
                            <img src="<?php echo base_url(); ?>assets/dist/img/feature.png" width="30" height="50" style="padding-left:-4px" alt="PHOTO" class="sjpuc_logo" /> 
                            </td> 
                            <td style="width:50px;padding-left:-18px">
                        <b>&nbsp;29-03-2025</b></td>
                           
                        </tr>
                </table>

            </div>
            <?php $issue_date = 'Date: ' . date("d/m/Y") . '';  ?>

        </div>
        <br>
        <br>
        <br>
        <table style="">
            <tr class="m-0">
                <td>
                    <div class="m-0">
                        <hr style="width:80%;">
                    </div>
                </td>
                <td>
                    <div class="m-0">
                        <!-- <hr style="width:65%;"> -->
                    </div>
                </td>
                <td>
                    <div class="m-0">
                        <hr style="width:80%;">
                    </div>
                </td>
            </tr>
            <tr>
                <td width="260" style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ಅಭ್ಯರ್ಥಿಯ ಸಹಿ<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature of the Candidate</td>
                <td class="text-center" width="300" style=""></td>
                <td width="320" style="text-align: center;" style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ಪ್ರಾಚಾರ್ಯರ ಸಹಿ ಮತ್ತು ಮೊಹರು<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature of the Principal and Seal</td>
            </tr>
            <!-- <tr> -->
                <!-- <td width="210">&nbsp;&nbsp;&nbsp;&nbsp;Signature of the Candidate</td> -->
                <!-- <td class="text-center" width="200"></td>
                <td width="250" style="text-align: center;">Signature of the Principal and Seal</td> -->
            <!-- </tr> -->
        </table>
    </div>
<?php
    if ($totalStudentCount != 0) {
        echo '<div class="break"></div>';
    } else {
        echo '<div class="break_after"></div>';
    }
} ?>


<?php

 function getSubjectCodes($stream_name){
    //science
    $PCMB = array("33", "34", "35", '36');
    $PCMC = array("33", "34", "35", '41');
    $PCME = array("33", "34", "35", '40');
    $PCMS = array('31', "33", "34", "35");
    //commarce
    $BEBA = array("75", "22", "27", '30');
    $BSBA = array("75", "31", "27", '30');
    $CSBA = array( "27", '30',"31","41");
    $SEBA = array("22", "27", '30',"31");       
    $CEBA = array("22", "27", '30',"41");
    $PEBA = array( "22", "27","29", '30');
    //art
    $HEPP = array("21", "22", "32", '29');
    $MEBA = array("22","27","30", '75');
    $MSBA = array("27","30",'31',"75");

    $HEPS = array("21", "22", '28',"29");
    $HEBA = array("21", "22", "27", "30");

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
        case "HEBA":
            return $HEBA;
            break;
    }
}


function calculateResultSubjectOne($percentage)
{
    if ($percentage >= 85) {
        return "Distinction";
    } else if ($percentage >= 60 && $percentage <= 84) {
        return "I Class";
    } else if ($percentage >= 50 && $percentage <= 59) {
        return "II Class";
    } else if ($percentage >= 35 && $percentage <= 49) {
        return "III Class";
    } else {
        return "Detained";
    }
}

function calculateResult($total_marks, $max_mak)
{
    $percentage = floor(($total_marks / $max_mak) * 100);
    if ($percentage >= 85) {
        return "Distinction";
    } else if ($percentage >= 60 && $percentage <= 84) {
        return "I Class";
    } else if ($percentage >= 50 && $percentage <= 59) {
        return "II Class";
    } else if ($percentage >= 35 && $percentage <= 49) {
        return "III Class";
    } else {
        return "PROMOTED";
    }
}

function getAssignmentExamTheoryTotalMark($student_id, $subject_code, $lab_status)
{

    if ($subject_code == 12) {
        $labStatus = 'true';
    } else {
        $labStatus = $lab_status;
    }
    if ($labStatus == 'true') {
        if ($subject_code == 12) {
            $pass_mark_theory = 25;
            $pass_mark_lab = 10;
            $lab_assessment = 10;
        } else {
            $pass_mark_theory = 21;
            $pass_mark_lab = 14;
            $lab_assessment = 16;
        }
    } else {
        $pass_mark_theory = 35;
        $pass_mark_lab = 0;
        $lab_assessment = 0;
    }

    if ($student_id == '20P5965' || $student_id == '20P4140' || $student_id == '20P1754') {
        $internal_assessment = 1;
    } else {
        $internal_assessment = 5;
    }
    $exam_type = array('ANNUAL_EXAMINATION');
    $total_mark = 0;
    if ($sub_code == 12) {
        $labStatus = 'true';
    } else {
        $labStatus = $subjectInfo['lab_status'];
    }
    // ,'INTERNAL_ASSESSMENT','LAB_ASSESSMENT'$total_mark + 



    $totalMark = $pass_mark_theory + $internal_assessment + $pass_mark_lab + $lab_assessment;
    return $totalMark;
}



function getAssessmentMark($totalMark, $exam_type, $labStatus, $subject_code)
{
    if (is_numeric($totalMark) && !empty($totalMark)) {
        if ($labStatus == 'false') {
            if ($exam_type == 'ASSIGNMENT_I' || $exam_type == 'ASSIGNMENT_II') {
                if ($totalMark >= 81 && $totalMark <= 100) {
                    return '30';
                } else if ($totalMark >= 71 && $totalMark <= 80) {
                    return '25';
                } else if ($totalMark >= 61 && $totalMark <= 70) {
                    return '20';
                } else if ($totalMark >= 51 && $totalMark <= 60) {
                    return '15';
                } else if ($totalMark >= 41 && $totalMark <= 50) {
                    return '10';
                } else {
                    return '5';
                }
            }
        } else {
            if ($exam_type == 'ASSIGNMENT_I' && $subject_code == '12' || $exam_type == 'ASSIGNMENT_II' && $subject_code == '12') {
                if ($totalMark >= 26 && $totalMark <= 35) {
                    return '4';
                } else if ($totalMark >= 36 && $totalMark <= 45) {
                    return '8';
                } else if ($totalMark >= 46 && $totalMark <= 55) {
                    return '12';
                } else if ($totalMark >= 56 && $totalMark <= 65) {
                    return '16';
                } else if ($totalMark >= 66 && $totalMark <= 75) {
                    return '20';
                } else {
                    return '25';
                }
            } else if ($exam_type == 'ASSIGNMENT_I' || $exam_type == 'ASSIGNMENT_II') {
                if ($totalMark >= 1 && $totalMark <= 28) {
                    return '4';
                } else if ($totalMark >= 29 && $totalMark <= 35) {
                    return '8';
                } else if ($totalMark >= 36 && $totalMark <= 42) {
                    return '12';
                } else if ($totalMark >= 43 && $totalMark <= 49) {
                    return '16';
                } else if ($totalMark >= 50 && $totalMark <= 56) {
                    return '19';
                } else {
                    return '22';
                }
            }
        }
    } else {
        return '';
    }
}

function getStudentFinalMarks($con, $student_id, $subjects_code, $exam_type,$exam_year)
{
    $query = "SELECT * FROM tbl_college_internal_exam_marks as exam
    WHERE exam.student_id = '$student_id' AND exam.subject_code = '$subjects_code' 
    AND exam.exam_type = '$exam_type' AND exam.exam_year = '$exam_year' AND exam.is_deleted = 0";
    $pdo_statement = $con->prepare($query);
    $pdo_statement->execute();
    return $pdo_statement->fetch();
}

function getSubjectInfo($con, $subject_code)
{
    $query = "SELECT * FROM tbl_subjects as sub
    WHERE sub.subject_code = '$subject_code'";
    $pdo_statement = $con->prepare($query);
    $pdo_statement->execute();
    return $pdo_statement->fetch();
}

function getSubjectTotal($result, $subjects)
{

    $subject_total = 0;

    foreach ($result as $row) {

        for ($i = 0; $i < 4; $i++) {

            if ($row["subject_code"] == $subjects[$i]) {

                $subject_total += (int)$row["obt_theory_mark"] + (int)$row["obt_lab_mark"];
            }
        }
    }

    return $subject_total;
}





function calculatePercentage($percentage)
{

    return floor(($percentage / 600) * 100);
}






function convert_number($number)
{

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

        $res .= (empty($res) ? "" : " ") . convert_number($kn) . " Thousand";
    }

    if ($Hn) {

        $res .= (empty($res) ? "" : " ") . convert_number($Hn) . " Hundred";
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

    $realPath = str_replace('\\', '/', realpath($strUrl));



    if (file_exists($strUrl) && $realPath == $strUrl) {

        return 1;    //File exists, with correct case

    } elseif (file_exists($realPath)) {

        return 2;    //File exists, but wrong case

    } else {

        return 0;    //File does not exist

    }
}
?>