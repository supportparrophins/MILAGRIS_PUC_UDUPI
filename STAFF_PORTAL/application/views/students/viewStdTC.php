<style>

.break { page-break-before: always; } 
.break_after { page-break-before: none; } 

table{
    width: 100% !important;
}

/*.border{
    border: 2px solid black;
}*/
.border_full{
    border: 1px solid black;
    /* height: 90% !important; */
}
.border_bottom{
    border-bottom: 1px solid black;
}
.hr_line{
    margin: 0px;
    color: black;
}

.table_bordered{
    border-collapse: collapse;
}
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  padding: 5px;
}
.table_bordered th,.table_bordered td{
    border-top: 1px solid black;
    border-right: 1px solid black;
    padding: 3px;
}

/* .table_bordered th .border_right_none,.table_bordered td .border_right_none{
    border-right: 1px solid transparent !important; */

    .table_data>tbody>tr>td, .table_data>tfoot>tr>td, .table_data>tfoot>tr>td, 
.table_data>thead>tr>td, .table_data>thead>tr>td {
    padding: 3px 4px !important;
    font-size: 17px;
}

.table_declaration>tbody>tr>th, .table_declaration>tfoot>tr>td, .table_declaration>tfoot>tr>th, 
.table_declaration>thead>tr>td, .table_declaration>thead>tr>th {
    padding: 3px 4px !important;
    line-height: 1.0 !important;
    vertical-align: middle !important;
    border-top: 1px solid #ddd;
    border: 1px solid transparent !important;
    font-size: 17px;
}



</style>
  
<?php 
    require APPPATH . 'views/includes/db.php';
    $totalStudentCount = count($studentInfo);
    foreach($studentInfo as $std){

        $totalStudentCount--;

        $subjects = getSubjectsName($std->stream_name);
        // $date_in_words = convert_number(date('d',strtotime($std->dob))); 
        // $year_in_words = convert_number(date('Y',strtotime($std->dob))); 
        // $dob = $date_in_words.' of '.date('F',strtotime($std->dob)).' '.$year_in_words;
        if((date('Y',strtotime($std->dob))) >= 2000)
        {
            $date_suffix = getDayOfMonthSuffix(date('d',strtotime($std->dob))); 
            $year_in_words = convert_number(date('Y',strtotime($std->dob))); 
            if($date_suffix == 'Twenty'){
                $dob = 'Twentieth '.date('F',strtotime($std->dob)).' '.$year_in_words;
            }else if($date_suffix == 'Thirty'){
                $dob = 'Thirtieth '.date('F',strtotime($std->dob)).' '.$year_in_words;
            }else{
                $dob = $date_suffix.' '.date('F',strtotime($std->dob)).' '.$year_in_words;
            }
        }
        else{
        $date_suffix = getDayOfMonthSuffix(date('d',strtotime($std->dob))); 
        $year = str_split(date('Y',strtotime($std->dob)));
        $year_in_words = convert_number($year[0].$year[1]); 
        $year_in_words_2 = convert_number($year[2].$year[3]);
         $year_in_words_con=$year_in_words.' '.$year_in_words_2;
        
        if($date_suffix == 'Twenty'){
            $dob = 'Twentieth '.date('F',strtotime($std->dob)).' '.$year_in_words_con;
        }else if($date_suffix == 'Thirty'){
            $dob = 'Thirtieth '.date('F',strtotime($std->dob)).' '.$year_in_words_con;
        }else{
            $dob = $date_suffix.' '.date('F',strtotime($std->dob)).' '.$year_in_words_con;
        }
    }
        
        if(!empty($std->exam_month_year)){
            $tc_month = strtoupper($std->exam_month_year);
        }else{ 
            if($std->term_name == 'I PUC'){
                $tc_month = 'FEBRUARY '.date('Y');
            }else{
                $tc_month = 'MARCH '.date('Y');
            }
    
        }
        if($std->dob=='0000-00-00'){
            
                $dob1='';
                $dob='';
            
        }else if(!empty($std->dob)){
            if($std->dob != '1970-01-01'){
                $dob1=date('d-m-Y',strtotime($std->dob));
            }
        }
        if($std->received_date=='1970-01-01'){
            $received_date='';
        }else if(!empty($std->received_date)){
            if($std->received_date!=''|| $std->received_date!='0000-00-00'||$std->received_date!=NULL){
                $received_date=date('d-m-Y',strtotime($std->received_date));
            }
        }

        if($std->date_of_admission=='1970-01-01'){
            $date_of_admission='';
        }else if(!empty($std->date_of_admission)){
            if($std->date_of_admission!=''|| $std->date_of_admission!='0000-00-00'||$std->date_of_admission!=NULL){
                $date_of_admission=date('d-m-Y',strtotime($std->date_of_admission));
            }
        }

        if($std->issue_date=='0000-00-00'){
            
           
            $issue_date='';
        
    }else if(!empty($std->issue_date)){
        if($std->issue_date != '1970-01-01'){
            $issue_date=date('d-m-Y',strtotime($std->issue_date));
        }
    }

    if($std->leaving_date=='0000-00-00'){
            
           
        $leaving_date='';
    
}else if(!empty($std->leaving_date)){
    if($std->leaving_date != '1970-01-01'){
        $leaving_date=date('d-m-Y',strtotime($std->leaving_date));
    }
}

    
        // if(!empty($std->issue_date)){
        //     if($std->issue_date != '1970-01-01'||$std->issue_date!=''|| $std->issue_date!='0000-00-00'){
        //         $issue_date=date('d-m-Y',strtotime($std->issue_date));
        //     }
        // }
        
    
        $qualified_status = ($std->is_promoted == 'YES')  ? "QUALIFIED" :  "DISQUALIFIED";
  
?>

<div class="container-fluid">

                    &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<img  class="mt-1" width="50" height="50" src="assets/dist/img/images (1).png" alt="logo">
    <div class="row">
        <div>
                <tr>
                    <td width="80%" style="text-align:left;padding:12pt;">
                        <span style="font-size: 10pt;margin-bottom: 1px;text-align:center;">&emsp;&emsp;&ensp;&emsp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;Government of Karnataka</span><br/>
                        <span style="font-size: 14pt;margin-bottom: 2px;">&emsp;&ensp;&emsp;&ensp;&ensp;&ensp;&ensp;&ensp;&emsp;&ensp;&emsp;&ensp;&emsp;&ensp;&emsp;  
                        Department of Pre-University Education</span><br/>
                        <b  style=" font-size: 16pt;margin-bottom: 4px;padding-top:4px;">&emsp;&ensp;&ensp;&ensp;&ensp;&ensp;&emsp; &emsp;&ensp;&emsp;&ensp;&ensp;&ensp;&ensp;&ensp;&emsp; 
                        TRANSFER CERTIFICATE</b><br/>
                        <span  style=" font-size: 12pt;margin-bottom: 2px;padding-top:2px;"><br/>
                         TC No.: <b> <?php echo strtoupper($std->tc_number) ?></b> </span>
                    </td>
                </tr>
        </div >
          
            <br/>
        <table class="table table_data">
        <tr>
            <td width="50%" style="">1. &nbsp;&nbsp;&nbsp;Name of the College:</td>
            <td width="50%"style="" cellpadding=""> <?php echo TITLE ?></td>
        
        </tr>
        <tr>
            <td width="50%" style="">2. &nbsp;&nbsp;&nbsp;Admission Number:
            </td>
            <td width="50%"style="" cellpadding=""><?php echo strtoupper($std->admission_no) ?></td>
        
        </tr>
        <tr>
            <td width="50%" style="">3. &nbsp;&nbsp;&nbsp;Name of the Student<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(as in the admission register)
            </td>
            <td width="50%" style="" cellpadding="5"> <?php echo strtoupper($std->student_name) ?></td>
        </tr>
        <tr>
            <td width="50%" style="">4. &nbsp;&nbsp;&nbsp;Date of Birth&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; In Figures:<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;In Words:
            </td>
            <td width="50%" style="list-style-type:upper-roman;">
                    <span> <?php echo $dob1; ?></span>
                    <span><br/> <?php echo ($dob) ?></span>
            </td>
        </tr>
        <tr>
            <td width="50%" style="border-bottom:white;">5. &nbsp;&nbsp;&nbsp;Gender :</td>
            <td width="50%" style="" cellpadding="5"><?php echo strtoupper($std->gender) ?></td>
        </tr>
        
        <tr>
            <td width="50%" style="">6. &nbsp;&nbsp;&nbsp;Father's Name:
            </td>
            <td width="50%" style="" cellpadding="5"><?php echo strtoupper($std->father_name) ?></td>
        </tr>

        <tr>
            <td width="50%" style="">7. &nbsp;&nbsp;&nbsp;Mother's Name:
            </td>
            <td width="50%" style="" cellpadding="5"><?php echo strtoupper($std->mother_name) ?></td>
        </tr>
            
        
        <tr>
            <td width="50%" style="border-bottom:1px solid white;">8. &nbsp;&nbsp;&nbsp;Nationality:</td>
            <td width="50%" style="border-bottom:1px solid white;"> <?php echo strtoupper($std->nationality) ?></td>
        </tr>
        <tr>
            <td width="50%" style="border-bottom:1px solid white;">9. &nbsp;&nbsp;&nbsp;Religion: 
            </td>
            <td width="50%" style="border-bottom:1px solid white;"><?php echo strtoupper($std->religion) ?> </td>
        </tr>
        <tr>
            <td width="50%" style="border-bottom:1px solid white;">10. &nbsp;&nbsp;Caste:
            </td>
            <td width="50%" style="border-bottom:1px solid white;"> <?php echo strtoupper($std->caste) ?>
            </td>
        </tr>
        <tr>
            <td width="50%" style="">11. &nbsp;Whether the student belong to scheduled <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Caste of Scheduled Tribe: </td>
        
            <td width="50%" style=""><?php echo strtoupper($std->is_belongs_sc_st) ?></td> 
        </tr>
        <tr>   
            </td>
            <td width="50%" style="border-bottom:1px solid white;">12. a) &nbsp;Date of Admission to the College:</td>
            <td width="50%" style="border-bottom:1px solid white;"><?php echo ($std->date_of_admission)?></td>
        </tr>
        <tr>
            <td width="50%" style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b) &nbsp;Date of Leaving the College:<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="50%" style=""><?php echo ($std->leaving_date)?></td>
        </tr>

        <tr>
            <td width="50%" style="">13.&nbsp;Class at the time of leaving:</td>
            <td width="50%" style=""><?php echo ($std->term_name)?></td>
        </tr>

        <tr>
            <td width="50%" style="">14.&nbsp;Medium of Instruction:</td>
            <td width="50%" style="">ENGLISH</td>
        </tr>
        <tr>
            <td width="50%" style="border-bottom:1px solid white;">15. &nbsp;Subjects studied in class  </td>
            <tr>
                <td width="50%" style="list-style-type:  upper-roman;">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Part I: Languages:<br/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Part II: Optional Subjects:
                </td>
            </tr>
            <td width="50%" style="border-top:1px solid white;">
                <span style="list-style-type:  upper-roman;">
                 I)ENGLISH II)<?php echo strtoupper($std->elective_sub) ?></li>
                <?php echo strtoupper($subjects) ?></li>
                </span>
            </td>
        </tr>
       
        <tr>
            <td width="50%" style="">16. &nbsp;Whether the student is qualified for<br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;promotion for the next higher class:</td>
            <td width="50%" style=""><?php echo strtoupper($std->is_promoted) ?></td>
        </tr>
        <!-- <tr>
            <td width="50%" style="">17. &nbsp;Name of the college last studied:
            </td>
            <td width="50%" style=""><?php  echo ($std->last_studied) ?></td>
        </tr> -->
       
        <tr>
            <td width="50%" style="">17. &nbsp;Conduct and Character of the student: </td> 
            <td width="50%" style=""><?php echo ($std->character_conduct) ?></td> 
        </tr>
      
        
        <!-- <tr>
            <td width="50%" style="">17. &nbsp;Total Number of working days</td>
            <td width="50%" style="">: <?php echo strtoupper($std->working_days) ?></td>
        </tr>
       
        
        <tr>
            <td width="50%" style="">19. &nbsp;Date of application for Transfer Certificate</td>
            <td width="50%" style="">: <?php echo date('d-m-Y',strtotime($std->last_date_admission)) ?></td>
        </tr>
        <tr>
            <td width="50%" style="">20. &nbsp;Date of issue for Transfer Certificate: </td>
        </tr>-->
        
        </table>
        <div style="">
        <tr >
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <td style="font-size:14px;text-align:left;">College Seal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature of Principal </td>
        </tr>
    </div>
        
        </div>
</div>
<?php
        if($totalStudentCount != 0){
            echo '<div class="break"></div>';
        }else{
            echo '<div class="break_after"></div>';
        }

 } ?>
<?php 

function getDayOfMonthSuffix($number) {
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
   
    $ones = array("", "First", "Second", "Third", "Fourth", "Fifth", "Sixth", "Seventh", "Eighth", "Ninth", "Tenth", "Eleventh", "Twelfth", "Thirteenth", "Fourteenth", "Fifteenth", "Sixteenth", "Seventeenth", "Eighteenth", "Nineteenth");
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
                $res .= " " . $ones[$n];
            }
        }
    }
    if (empty($res)) {
        $res = "zero";
    }
    return $res;
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
        $res .= convert_number($Gn) .  "Million";
    }
    if ($kn) {
        $res .= (empty($res) ? "" :  " ") .convert_number($kn) . " Thousand";
    }
    if ($Hn) {
        $res .= (empty($res) ? "" :  " ") .convert_number($Hn) . " Hundred";
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


function getSubjectsName($stream_name){
    //science
    $PCMB = 'i)Physics ii)Chemistry <br>iii)Mathematics iv)Biology';
    $PCMC = 'i)Physics ii)Chemistry <br>iii)Mathematics iv)Computer Science';
    //$PCME = 'i)Physics ii)Chemistry <br>iii)Mathematics iv)Electronics';
    //$PCMS = 'i)Physics ii)Chemistry <br>iii)Mathematics iv)Statistics';

    $EBAC = 'i)Economics ii)Business Studies <br>iii)Accountancy iv)Computer Science';
    $HEBA = 'iii)History iv)Economics <br>v)Business Studies vi)Accountancy';
    $SEBA = 'i)Statistics ii)Economics <br>iii)Business Studies iv)Accountancy';
    //commarce
    $HEPS = 'i)Histroy ii)Economics <br>iii)Psychology iv)Sociology';
   // $MSBA = 'i)Mathematics ii)Statistics <br>iii)Business Studies iv)Accountancy';
    //$CSBA = 'i)Computer Science ii)Statistics <br>iii)Business Studies iv)Accountancy';
   
   // $CEBA = 'i)Computer Science ii)Economics <br>iii)Business Studies iv)Accountancy';

    
  
    $HEPP ='iii)History iv)Economics <br>v)Political Science iv)Psychology';
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
        case "EBAC": 
            return $EBAC;
            break;
        case "SEBA": 
            return $SEBA;
            break;
        case "BSBA": 
            return $BSBA;
            break;
        case "CSBA": 
            return $CSBA;
            break;
        case "MSBA": 
            return $MSBA;
            break;
        case "CEBA": 
            return $CEBA;
            break;
        case "HEPS": 
            return $HEPS;
            break;
        case "HEBA": 
            return $HEBA;
            break;
    }
}


function getFamilyInfo($con,$application_no){
    $query = "SELECT family.relation_type,family.name,family.application_no FROM tbl_student_family_info as family
    WHERE family.application_no = '$application_no' AND family.is_deleted = 0";
    $result = $con->prepare($query); 
    $result->execute(); 
    return $result->fetchAll();
}

?>