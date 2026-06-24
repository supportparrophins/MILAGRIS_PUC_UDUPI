<?php
date_default_timezone_set("Asia/Kolkata"); 
?>

<style>
@media print {
    .main-footer {
        display: none !important;
    }
    .wizard-inner, .card-header, .card-footer {
        display: none;
    }
    .noprint {display:none;}
    ::-webkit-scrollbar {
        display: none;
    }

    @page {
        size: A4;
        /* margin: 0;  */
    }

    .page_break { 
        page-break-before: always;
    }
    .enable-print { display: block !important; }
    
   
}

.A4 {
    overflow: hidden;
    background: white;
    width: 25cm;
    height: 36.05cm;  
    display: block;
    margin: 0 auto;
    padding: 10px 25px;
    margin-bottom: 0.2cm;
    box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
    color: black !important;
}


.stm_work{
    font-family: serif;
    margin-top: 50px;
    font-size: 30px;
    font-family: initial;
}
.title{
    font-size: 30px;
    margin-left: -25px;
}
table {
  border: 1px solid white;
  border-collapse: collapse;
  font-family: serif;
  padding: 3px;
}
.date_today{
    font-size: 20px;
    float:right;
    margin-bottom: 20px;
}

.description{
    font-family: serif;
    text-align: justify;
    font-size: 29px;
    margin-top: 15px;
}
#circle {

height: 170px;

width: 250px;

border:1px solid;



border-radius: 50%;

-moz-border-radius: 50%;

-webkit-border-radius: 50%;

}
#signature_part {
    float: right;
    line-height: 18px;
    padding-left: 125px;
    text-align: center;
    font-family: serif;
}
</style>


<div class="main-content-container container-fluid px-4 pt-2">
    <div class="content-wrapper">
        <div class="row noprint">
            <div class="col-12">
                <div class="card card-small p-0 card_heading_title">
                    <div class="card-body p-1 card-content-title">
                        <div class="row ">
                            <div class="col-lg-8 col-md-8 col-8 text-black" style="font-size:22px;">
                                <i class="fa fa-file"></i> Study Certificate
                            </div>
                            <div class="col-lg-4 col-md-4 col-4"> 
                                <a href="#" onClick="window.print();" class="btn text-white btn-success btn-bck float-right">
                                <i class="fa fa-download"></i> Print</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php //if(empty($studentInfo)){ ?>
        <!-- <div class="row form-employee">
            <div class="col-lg-12 col-md-12 col-12 pr-0 text-center">
            <img height="270" src="<?php echo base_url(); ?>assets/images/404.png"/>
            </div>
        </div> -->
        <?php //} else {  ?>
            <div class="row form-employee">
                <div class="col-12">
                    <div class="card card-small c-border p-2 mb-4">
                    <?php if(!empty($studentsRecords)) {
                        $total_students_selected = count((array)$studentsRecords);
                        foreach($studentsRecords as $record)
                        {  
                            $total_students_selected--;
                    ?>
                        <div class="A4" id="border">
                          <div class="enable-print">
                                <div class="row">
                                    <table class="table" style="">
                                         <tr>
                                                <th class="text-center" style="border-top: 1px solid white !important;">
                                                    <img src="<?php echo INSTITUTION_LOGO ?>" width="100" height="100" alt="PHOTO" class="shcm_logo" />
                                                </th>
                                                <td style="font-size:25pt;border-top: 1px solid white !important;" class="text-center" ><b>ST. JOSEPH'S PRE-UNIVERSITY COLLEGE</b>
                                                <p style="font-size:16pt">
                                                <b>Vijapura, Karnataka 562106</b></p>
                                         </tr>
                                     </table>
                                    <!-- <div class="col-lg-12">
                                       
                                        <img src="<?php echo base_url(); ?>assets/dist/img/logo_sjpuch.jpg" width="100" height="100" alt="PHOTO" class="shcm_logo" />
                                        <p style= "text-align:center;"><b style="font-weight: 750;font-size:29px">ST. JOSEPH'S PRE-UNIVERSITY COLLEGE, HASSAN</b>  <br><b style="font-weight: 700;font-size:29px">Salgame Road,Saraswathi Puran, Hassan - 573201</b></p>
                     
                                    </div> -->
                                </div>
                    
                                <div class="row ">
                                    <div class="col-lg-12">
                                        <div style="font-family: serif;" class="text-center stm_work"><u>STUDY CERTIFICATE</u></div>
                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col-lg-12">
                                        <div class="date_today"><?php echo date('d-m-Y'); ?></div>
                                    </div>
                                </div>
                                <?php
                                $description = '<p>This is to certify that <b style="font-weight: 900;font-size:29px"> Sri. '.strtoupper($record->student_name).' </b> S/o Sri. '.$record->father_name.' has studied '.$record->college_from.' and '.$record->college_to.' in our institution from '.$record->classes_from.' to '.$record->classes_to.' academic years.</p>
                                <p>He belongs to '.$record->religion.' – '.$record->caste.' caste and the mother tongue of the candidate is '.$record->mother_tongue.' as per the Admission Register of the institution.</p>
                                <p>The above details are true and correct to the best of my knowledge.</p>';
                                ?>
                                <div class="row ">
                                    <div class="col-lg-12">
                                        <div contenteditable="true" class="description"><?php echo $description; ?></div>
                                    </div>
                                </div>

                                <div class="row"  style="margin-top: 120px;">
                                    <div id="circle" style="padding-left: 60px;" class="col-5">
                                        <!-- <div style="margin-top: 40px;"  class="description">Institution Seal</div> -->
                                    </div>
                                    <div id="signature_part"  class="col-7 description">
                                        <p>Signature of the Principal </p>
                                        <br>
                                        <p>( Principal )</p>
                                        <!-- <p>(Fr Melwin Mendonca SJ)</p> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if($total_students_selected > 1) { ?>
                            <div class="page_break"></div>
                        <?php } ?>

                        <?php } } ?>
                        <div class="card-footer p-1">
                            <a href="#" onClick="window.print();" class="btn text-white btn-success btn-bck float-left">
                            <i class="fa fa-download"></i> Print</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php //} ?>
    </div>
</div>



<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "studentsListing/" + value);
            jQuery("#searchList").submit();
        });
    //     jQuery(function() {
    //     jQuery(this).bind("contextmenu", function(event) {
    //         event.preventDefault();
    //     });
    // });
    });
</script>
<?php 

  

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


function calculatePercentage($percentage){
    return floor(($percentage / 600) * 100);
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
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
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