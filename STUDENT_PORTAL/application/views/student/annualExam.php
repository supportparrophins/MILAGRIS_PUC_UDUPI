<?php require APPPATH . 'views/includes/db.php'; ?>
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
<div class="main-content-container container-fluid px-4">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mt-1 mb-2">
            <div class="col padding_left_right_null">
                <div class="card card-small p-0 card_head_dashboard">
                    <div class="card-body p-2 ml-2">
                        <span class="page-title">
                            <i class="material-icons">description</i> Annual Exam Result
                        </span>
                        <a onclick="window.history.back(); return false;"
                            class="btn btn-primary float-right text-white pt-2" value="Back">Back </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="row form-employee">
        <div class="col-12 padding_left_right_null">
            <div class="card card-small c-border mb-4">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col profile-head">
                                <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile"
                                            role="tab" aria-controls="profile" aria-selected="false">Annual Exam</a>
                                    </li>
                                </ul>
                                <div class="tab-content profile-tab" id="myTabContent">
                                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab"> -->
                                        <h6 class="text-center text-dark mb-1"></h6>
                                        <?php
                                        $query = "SELECT DISTINCT mark.subject_code,sub.subject_code,sub.name,sub.lab_status,sub.sub_type,mark.obt_theory_mark,mark.obt_lab_mark
                                            FROM tbl_student_exams_marks as mark, tbl_subjects as sub
                                            WHERE sub.subject_code =  mark.subject_code AND student_id = '$studentMarkInfo->student_id'";
                                            $pdo_statement = $con->prepare($query);
                                            $pdo_statement->execute();
                                            $result = $pdo_statement->fetchAll();
                                            $subjects_code = getSubjectCodes($studentMarkInfo->stream_name);
                                            if(!empty($result)) { 
                                            $student_mark_info = '<div class="table-responsive-sm">
                                            <table class="table table-bordered table_info mb-0">
                                            <tr class="card_head_dashboard">
                                                <th colspan="7" class="table_title text-center">Annual Exam Result 2019-20</th>
                                            </tr>
                                            <tr class="text-center table_row_backgrond">
                                                <th width="180" class="text-center">SUBJECT NAME</th>
                                                <th width="100" class="text-center">MAX. MARKS</th>
                                                <th width="100" class="text-center">MIN. MARKS</th>
                                                <th width="100" class="text-center">OBT. MARK</th>
                                                <th width="100" class="text-center">TOTAL</th>
                                                <th width="150" class="text-center">RESULT</th>
                                            </tr>';
                                            $subject_total_mark = getSubjectTotal($result,$subjects_code);
                                            $theory_total_mark = getTheoryTotal($result,$subjects_code);
                                            $lab_total_mark = getLabTotal($result,$subjects_code);
                                            $total_subjects = 6;
                                            $skipped_lang_I = "false";
                                            $skipped_lang_II = "false";
                                            $elective_count = 1;
                                            if($studentMarkInfo->elective_sub == 'EXEMPTED' ){
                                                $elective_count++;
                                                $student_mark_info .='
                                                <tr>
                                                    <td>EXEMPTED</td>
                                                    <td class="text-center">EX</td>
                                                    <td class="text-center">EX</td>
                                                    <td>EXEMPTED</td>
                                                    </tr>';
                                            }
                                            foreach($result as $row) { 
                                                if($studentMarkInfo->elective_sub == 'EXEMPTED'){
                                                    $total_subjects = 5;
                                                    $first_lag_result = "EXEMPTED";
                                                    $skipped_lang_I = "true";
                                                
                                                } 

                                    if($row["subject_code"] == '1' || $row["subject_code"] == '3' || $row["subject_code"] == '12'){
                                        if($row["subject_code"] == '12'){
                                            $theory_mark_lang_I = (int)$row["obt_theory_mark"];
                                            $lab_mark_lang_I = (int)$row["obt_lab_mark"];
                                            $total_mark_lang_I = (int)$row["obt_theory_mark"] + (int)$row["obt_lab_mark"];
                                            if($row["obt_theory_mark"] == 'EX' || $row["obt_lab_mark"] == 'EX'){
                                                $total_subjects = 5;
                                                $first_lag_result = "EXEMPTED";
                                                $skipped_lang_I = "true";
                                            } else if(!is_numeric($row["obt_theory_mark"]) && !is_numeric($row["obt_lab_mark"])) {
                                                $total_mark_lang_I = $row["obt_theory_mark"];
                                                $first_lag_result = "FAIL";
                                            }else if(!is_numeric($row["obt_theory_mark"])) {
                                                $total_mark_lang_I = $row["obt_lab_mark"];
                                                $first_lag_result = "FAIL";
                                                }else if(!is_numeric($row["obt_lab_mark"])) {
                                                    $total_mark_lang_I = $row["obt_theory_mark"];
                                                    $first_lag_result = "FAIL";
                                                }else if($row["obt_theory_mark"] < 24){
                                                $first_lag_result = "FAIL";
                                            } else if($total_mark_lang_I >= 35){
                                                $first_lag_result = "PASS";
                                            }else if($total_mark_lang_I >= 30){
                                                $second_lang_mark = getMarksBySecondLang($result);
                                                $lang_total = $second_lang_mark + $total_mark_lang_I;
                                                if($lang_total >= 70){
                                                    $first_lag_result = "EXEMPTED";
                                                }else{
                                                    $first_lag_result = "FAIL";
                                                }
                                            }else{
                                                $first_lag_result = "FAIL";
                                            }
                                        }else{
                                        $theory_mark_lang_I = (int)$row["obt_theory_mark"];
                                        $lab_mark_lang_I = '';
                                            $total_mark_lang_I = $row["obt_theory_mark"];
                                            if($studentMarkInfo->elective_sub == 'EXEMPTED'){
                                                $total_subjects = 5;
                                                $first_lag_result = "EXEMPTED";
                                                $skipped_lang_I = "true";
                                            } else if(!is_numeric($row["obt_theory_mark"])) {
                                                $total_mark_lang_I = $row["obt_theory_mark"];
                                                $first_lag_result = "FAIL";
                                                }else if($total_mark_lang_I >= 35){
                                                    $first_lag_result = "PASS";
                                                }else if($total_mark_lang_I >= 30){
                                                $second_lang_mark = getMarksBySecondLang($result);
                                                $lang_total = $second_lang_mark + $total_mark_lang_I;
                                                if($lang_total >= 70){
                                                    $first_lag_result = "EXEMPTED";
                                                }else{
                                                    $first_lag_result = "FAIL";
                                                }
                                            }	else {
                                                $first_lag_result = "FAIL";
                                            }
                                        }
                                    if($studentMarkInfo->elective_sub == 'EXEMPTED'){
                                        $elective_count++;
                                        $convert_number_word = "EXEMPTED";
                                        $max_marks = 'EX';
                                        $sub_name = "EXEMPTED";
                                        }else{
                                            $sub_name = $row["name"];
                                            $max_marks = '100';
                                            // $convert_number_word = convert_number($total_mark_lang_I).' Only';
                                        }
                                        $student_mark_info .='
                                        <tr>
                                        <th>'.strtoupper($sub_name).'</th>
                                        <th class="text-center">'.$max_marks.'</th>
                                        <th class="text-center">35</th>
                                        <th class="text-center">'.$total_mark_lang_I.'</th>
                                        
                                        <th class="text-center">'.$total_mark_lang_I.'</th>
                                        <th class="text-center">'.$first_lag_result.'</th>
                                        </tr>';
                                    } 
                                } 
                        
                                foreach($result as $row) { 
                                    if($row["subject_code"] == '02'){
                                        $total_mark_lang_II = $row["obt_theory_mark"]; 
                                        $lab_mark_lang_II = ''; 
                                        if($row["obt_theory_mark"] == 'EX'){
                                            $total_subjects = 5;
                                            $second_lag_result = "EXEMPTED";
                                            $skipped_lang_II = "true";
                                        } else if(!is_numeric($row["obt_theory_mark"])) {
                                            $total_mark_lang_II = $row["obt_theory_mark"];
                                            $second_lag_result = "FAIL";
                                            }else if($total_mark_lang_II >= 35){
                                            $second_lag_result = "PASS";
                                        }else if($total_mark_lang_II >= 30){
                                            $total_language_mark = $total_mark_lang_II + $total_mark_lang_I;
                                            if($total_language_mark >= 70){
                                                $second_lag_result = "EXEMPTED";
                                            }else{
                                                $second_lag_result = "FAIL";
                                            }
                                        }else {
                                            $second_lag_result = "FAIL";
                                        }
                                        if($skipped_lang_II == "true"){
                                            $convert_number_word = "EXEMPTED";
                                            $max_marks = 'EX';
                                            }else{
                                                $max_marks = '100';
                                                // $convert_number_word = convert_number($total_mark_lang_II).' Only';
                                            }
                                        $student_mark_info .='
                                        <tr>
                                        <th>'.strtoupper($row["name"]).'</th>
                                        <th class="text-center">'.$max_marks.'</th>
                                        <th class="text-center">35</th>
                                        <th class="text-center">'.$total_mark_lang_II.'</th>
                                     
                                        <th class="text-center">'.$total_mark_lang_II.'</th>
                                        <th class="text-center">'.$second_lag_result.'</th>
                                        </tr>';
                                    }
                                } 
                                    //subjects optionals
                                    foreach($result as $row) { 
                                        if($row["subject_code"] == $subjects_code[0]){
                                            if($row["lab_status"] == 'true'){
                                              $theory_mark = (int)$row["obt_theory_mark"];
                                              $lab_mark = (int)$row["obt_lab_mark"];
                                                $subject_total = (int)$row["obt_theory_mark"] + (int)$row["obt_lab_mark"];
                                                if(!is_numeric($row["obt_theory_mark"]) && !is_numeric($row["obt_lab_mark"])) {
                                                    $subject_total = $row["obt_theory_mark"];
                                                    $subject_result = "FAIL";
                                                }else if(!is_numeric($row["obt_theory_mark"])) {
                                                    $subject_total = $row["obt_lab_mark"];
                                                    $subject_result = "FAIL";
                                                    }else if(!is_numeric($row["obt_lab_mark"])) {
                                                        $subject_total = $row["obt_theory_mark"];
                                                        $subject_result = "FAIL";
                                                    }else if($row["obt_theory_mark"] < 21){
                                                    $subject_result = "FAIL";
                                                } else if($subject_total >= 35){
                                                    $subject_result = "PASS";
                                                }else if($subject_total >= 30){
                                                    if($subject_total_mark >= 140){
                                                        $subject_result = "EXEMPTED";
                                                    }else{
                                                        $subject_result = "FAIL";
                                                    }
                                                }else{
                                                    $subject_result = "FAIL";
                                                }
                                            }else{
                                              $theory_mark = (int)$row["obt_theory_mark"];
                                              $lab_mark = '';
                                                $subject_total = $row["obt_theory_mark"];
                                                if(!is_numeric($row["obt_theory_mark"])) {
                                                    $subject_total = $row["obt_theory_mark"];
                                                    $subject_result = "FAIL";
                                                    }else if($subject_total >= 35){
                                                        $subject_result = "PASS";
                                                    }else if($subject_total >= 30){
                                                    if($subject_total_mark >= 140){
                                                        $subject_result = "EXEMPTED";
                                                    }else{
                                                        $subject_result = "FAIL";
                                                    }
                                                }else{
                                                    $subject_result = "FAIL";
                                                }
                                            }
                                            $subject_1_result = $subject_result;
                                            $student_mark_info .='
                                            <tr>
                                            <th>'.strtoupper($row["name"]).'</th>
                                            <th class="text-center">100</th>
                                            <th class="text-center">35</th>
                                            <th class="text-center">'.$subject_total.'</th>
                                           
                                            <th class="text-center">'.$subject_total.'</th>
                                            <th class="text-center">'.$subject_1_result.'</th>
                                            </tr>';
                                             } 
                                            } 
                    
                                            foreach($result as $row) {                                      
                                                if($row["subject_code"] == $subjects_code[1]){
                                                    if($row["lab_status"] == 'true'){
                                                      $theory_mark = (int)$row["obt_theory_mark"];
                                                      $lab_mark = (int)$row["obt_lab_mark"];
                                                        $subject_total = (int)$row["obt_theory_mark"] + (int)$row["obt_lab_mark"];
                                                        if(!is_numeric($row["obt_theory_mark"]) && !is_numeric($row["obt_lab_mark"])) {
                                                            $subject_total = $row["obt_theory_mark"];
                                                            $subject_result = "FAIL";
                                                        }else if(!is_numeric($row["obt_theory_mark"])) {
                                                            $subject_total = $row["obt_lab_mark"];
                                                            $subject_result = "FAIL";
                                                            }else if(!is_numeric($row["obt_lab_mark"])) {
                                                                $subject_total = $row["obt_theory_mark"];
                                                                $subject_result = "FAIL";
                                                            }else if($row["obt_theory_mark"] < 21){
                                                            $subject_result = "FAIL";
                                                        } else if($subject_total >= 35){
                                                            $subject_result = "PASS";
                                                        }else if($subject_total >= 30){
                                                            if($subject_total_mark >= 140){
                                                                $subject_result = "EXEMPTED";
                                                            }else{
                                                                $subject_result = "FAIL";
                                                            }
                                                        }else{
                                                            $subject_result = "FAIL";
                                                        }
                                                    }else{
                                                      $theory_mark = (int)$row["obt_theory_mark"];
                                                      $lab_mark = '';
                                                        $subject_total = $row["obt_theory_mark"];
                                                        if(!is_numeric($row["obt_theory_mark"])) {
                                                            $subject_total = $row["obt_theory_mark"];
                                                            $subject_result = "FAIL";
                                                            }else if($subject_total >= 35){
                                                                $subject_result = "PASS";
                                                            }else if($subject_total >= 30){
                                                            if($subject_total_mark >= 140){
                                                                $subject_result = "EXEMPTED";
                                                            }else{
                                                                $subject_result = "FAIL";
                                                            }
                                                        }else{
                                                            $subject_result = "FAIL";
                                                        }
                                                    }
                                                    $subject_2_result = $subject_result;
                                                    $student_mark_info .='
                                                    <tr>
                                                    <th>'.strtoupper($row["name"]).'</th>
                                                    <th class="text-center">100</th>
                                                    <th class="text-center">35</th>
                                                    <th class="text-center">'.$subject_total.'</th>
                                                  
                                                    <th class="text-center">'.$subject_total.'</th>
                                                    <th class="text-center">'.$subject_2_result.'</th>
                                                    </tr>';
                                                  } } 
                    
                                            foreach($result as $row) { 
                                                                                            
                                                if($row["subject_code"] == $subjects_code[2]){
                                                    if($row["lab_status"] == 'true'){
                                                      $theory_mark = (int)$row["obt_theory_mark"];
                                                      $lab_mark = (int)$row["obt_lab_mark"];
                                                        $subject_total = (int)$row["obt_theory_mark"] + (int)$row["obt_lab_mark"];
                                                        if(!is_numeric($row["obt_theory_mark"]) && !is_numeric($row["obt_lab_mark"])) {
                                                            $subject_total = $row["obt_theory_mark"];
                                                            $subject_result = "FAIL";
                                                        }else if(!is_numeric($row["obt_theory_mark"])) {
                                                            $subject_total = $row["obt_lab_mark"];
                                                            $subject_result = "FAIL";
                                                            }else if(!is_numeric($row["obt_lab_mark"])) {
                                                                $subject_total = $row["obt_theory_mark"];
                                                                $subject_result = "FAIL";
                                                            }else if($row["obt_theory_mark"] < 21){
                                                            $subject_result = "FAIL";
                                                        } else if($subject_total >= 35){
                                                            $subject_result = "PASS";
                                                        }else if($subject_total >= 30){
                                                            if($subject_total_mark >= 140){
                                                                $subject_result = "EXEMPTED";
                                                            }else{
                                                                $subject_result = "FAIL";
                                                            }
                                                        }else{
                                                            $subject_result = "FAIL";
                                                        }
                                                    }else{
                                                      $theory_mark = (int)$row["obt_theory_mark"];
                                                      $lab_mark = '';
                                                        $subject_total = $row["obt_theory_mark"];
                                                        if(!is_numeric($row["obt_theory_mark"])) {
                                                            $subject_total = $row["obt_theory_mark"];
                                                            $subject_result = "FAIL";
                                                            }else if($subject_total >= 35){
                                                                $subject_result = "PASS";
                                                            }else if($subject_total >= 30){
                                                            if($subject_total_mark >= 140){
                                                                $subject_result = "EXEMPTED";
                                                            }else{
                                                                $subject_result = "FAIL";
                                                            }
                                                        }else{
                                                            $subject_result = "FAIL";
                                                        }
                                                    }
                                                    $subject_3_result = $subject_result;
                                                    $student_mark_info .='
                                                    <tr>
                                                    <th>'.strtoupper($row["name"]).'</th>
                                                    <th class="text-center">100</th>
                                                    <th class="text-center">35</th>
                                                    <th class="text-center">'.$subject_total.'</th>
                                                  
                                                    <th class="text-center">'.$subject_total.'</th>
                                                    <th class="text-center">'.$subject_3_result.'</th>
                                                    </tr>';
                                                    } } 
                    
                                            foreach($result as $row) {                               
                                                if($row["subject_code"] == $subjects_code[3]){
                                                    if($row["lab_status"] == 'true'){
                                                      $theory_mark = (int)$row["obt_theory_mark"];
                                                      $lab_mark = (int)$row["obt_lab_mark"];
                                                        $subject_total = (int)$row["obt_theory_mark"] + (int)$row["obt_lab_mark"];
                                                        if($student_id === "18P3128"){
                                                            $subject_result = "EXEMPTED";
                                                        }else if(!is_numeric($row["obt_theory_mark"]) && !is_numeric($row["obt_lab_mark"])) {
                                                            $subject_total = $row["obt_theory_mark"];
                                                            $subject_result = "FAIL";
                                                        }else if(!is_numeric($row["obt_theory_mark"])) {
                                                            $subject_total = $row["obt_lab_mark"];
                                                            $subject_result = "FAIL";
                                                            }else if(!is_numeric($row["obt_lab_mark"])) {
                                                                $subject_total = $row["obt_theory_mark"];
                                                                $subject_result = "FAIL";
                                                            }else if($row["obt_theory_mark"] < 21){
                                                            $subject_result = "FAIL";
                                                        } else if($subject_total >= 35){
                                                            $subject_result = "PASS";
                                                        }else if($subject_total >= 30){
                                                            if($subject_total_mark >= 140){
                                                                $subject_result = "EXEMPTED";
                                                            }else{
                                                                $subject_result = "FAIL";
                                                            }
                                                        }else{
                                                            $subject_result = "FAIL";
                                                        }
                                                    }else{
                                                      $theory_mark = (int)$row["obt_theory_mark"];
                                                      $lab_mark = '';
                                                        $subject_total = $row["obt_theory_mark"];
                                                        if(!is_numeric($row["obt_theory_mark"])) {
                                                            $subject_total = $row["obt_theory_mark"];
                                                            $subject_result = "FAIL";
                                                            }else if($subject_total >= 35){
                                                                $subject_result = "PASS";
                                                            }else if($subject_total >= 30){
                                                            if($subject_total_mark >= 140){
                                                                $subject_result = "EXEMPTED";
                                                            }else{
                                                                $subject_result = "FAIL";
                                                            }
                                                        }else{
                                                            $subject_result = "FAIL";
                                                        }
                                                    }
                                                    $subject_4_result = $subject_result;
                                                    $student_mark_info .='
                                                    <tr>
                                                    <th>'.strtoupper($row["name"]).'</th>
                                                    <th class="text-center">100</th>
                                                    <th class="text-center">35</th>
                                                    <th class="text-center">'.$subject_total.'</th>
                                                   
                                                    <th class="text-center">'.$subject_total.'</th>
                                                    <th class="text-center">'.$subject_4_result.'</>
                                                    </tr>';
                                                      } } 
                                                    
                                                        $total_theory_mark = (int)$theory_total_mark + (int)$theory_mark_lang_I + (int)$total_mark_lang_II;
                                                        $total_lab_mark = (int)$lab_total_mark + (int)$lab_mark_lang_I + (int)$lab_mark_lang_II;
                                                        $total_marks_all_subjects = (int)$subject_total_mark + (int)$total_mark_lang_I + (int)$total_mark_lang_II ; 
                    
                                                        if($subject_4_result == "FAIL" ||$subject_3_result == "FAIL" ||$subject_2_result == "FAIL" ||$subject_1_result == "FAIL" || $first_lag_result == "FAIL" || $second_lag_result == "FAIL"){
                                                            $final_result =  '<span class="text_fail">FAIL</span>';
                                                        }else{
                                                            $final_result = '<span class="text_pass">'.calculateResultAll($total_marks_all_subjects,$total_subjects,$elective_count).'</span>';
                                                        }
                                                    // $total_marks_words = convert_number($total_marks_all_subjects);
                                                    if($skipped_lang_I == "true"){
                                                        $max_total_marks = '500';
                                                        $min_total_marks = '175';
                                                        $totalPercentage = ($total_marks_all_subjects / $max_total_marks) * 100;
                                                    }else{
                                                        $max_total_marks = '600';
                                                        $min_total_marks = '210';
                                                        $totalPercentage = ($total_marks_all_subjects / $max_total_marks) * 100;
                                                    }
                                                    $student_mark_info .='
                                                    <tr class="card_head_dashboard">
                                                        <th>GRAND TOTAL</th>
                                                        <th class="text-center">'.$max_total_marks.'</th>
                                                        <th class="text-center">'.$min_total_marks.'</th>
                                                        <th class="text-center"></th>
                                                       
                                                        <th class="text-center">'.$total_marks_all_subjects.'</th>
                                                        <th class="text-center"></th>
                                                    </tr>
                                                    <tr>
                                                        <th class="total_row" colspan="3">Percentage: '.round($totalPercentage,2).'%'.'</th>
                                                        <th class="total_row" colspan="4">Final Result: '.strtoupper($final_result).'</th>
                                                    </tr>
                                                    </table>';
                                                    ?>
                                                    <div class="row" >
                                                    <div class="col-lg-12">
                                                    <?php echo $student_mark_info; ?>
                                                    </div>
                                                    </div>
                                                    
                                                <?php } ?>
                                            </table>
                                        </div>
                                    <!-- </div>
                                </div> -->
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php 
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

function calculateResultAll($percentage,$total_subjects,$elective){
    if($elective > 1){
        $percentage = floor(($percentage / 500) * 100);
    }else{
        $percentage = floor(($percentage / 600) * 100);
    }
    
    if($percentage >= 85){
            return "Distinction";
    } else if($percentage >= 60 && $percentage <= 84){
            return "First Class";
    } else if($percentage >= 50 && $percentage <= 59){
            return "Second Class";
    } else if($percentage >= 35 && $percentage <= 49){
            return "Third Class";
    }
}


function getMarksBySecondLang($result){
    foreach($result as $row) { 
        if($row["subject_code"] == '02'){
            return $total_mark_lang_II = $row["obt_theory_mark"];
        }
     } 
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
function getTheoryTotal($result,$subjects){
    $theory_total = 0;
    foreach($result as $row) { 
    for($i=0; $i<4; $i++){
        if($row["subject_code"] == $subjects[$i]){
            $theory_total += (int)$row["obt_theory_mark"];
        }
    }
}
return $theory_total;
}

function getLabTotal($result,$subjects){
  $lab_total = 0;
  foreach($result as $row) { 
  for($i=0; $i<4; $i++){
      if($row["subject_code"] == $subjects[$i]){
          $lab_total += (int)$row["obt_lab_mark"];
      }
  }
}
return $lab_total;
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
?>
