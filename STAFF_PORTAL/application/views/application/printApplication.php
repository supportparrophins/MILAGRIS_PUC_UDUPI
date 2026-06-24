<?php
//============================================================+
// File name   : example_020.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 020 for TCPDF class
//               Two columns composed by MultiCell of different
//               heights
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
* Creates an example PDF TEST document using TCPDF
* @package com.tecnick.tcpdf
* @abstract TCPDF - Example: Two columns composed by MultiCell of different heights
* @author Nicola Asuni
* @since 2008-03-04
*/

// Include the main TCPDF library (search for installation path).


// extend TCPF with custom functions
class MYPDF extends TCPDF {
    public function Header() {
        
        
    }

	
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set auto page breaks
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->SetAutoPageBreak(TRUE, 0);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 14);
// add a page
$pdf->SetTitle('View/Print Application');
$pdf->AddPage();
$education_qualification= "";
$sl=1;
$date_of_birth = date('d/m/Y',strtotime($studentApplicationInfo->dob));
$student_email = strtolower($studentApplicationInfo->email);
$parent_email = strtolower($studentApplicationInfo->family_email);
$current_date = date('d-m-Y');
$table= "";

foreach($studentMarkInfo as $mark){
    if($mark->subject_name == 'EXEMPTED'){
        $max_mark = 'EX';
        $obtained_mark = 'EX';

    }else{
        $max_mark = $mark->max_mark;
        $obtained_mark = $mark->obtnd_mark;

    }
    $table .= '<tr>
    <td style="vertical-align:middle;font-size: 12px;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"><b>' .$mark->subject_name.'</b></td>
    <td style="text-align: center;font-size: 12px;border-top: 1px solid black;border-right: 1px solid black;"><b>' .$max_mark.'</b></td>
    <td style="vertical-align:middle;text-align: center;font-size: 12px;border-top: 1px solid black;border-right: 1px solid black;"><b>' .$obtained_mark.'</b></td>
    </tr>';

    
} 

    if($boardInfo->board_name == "KARNATAKA STATE BOARD"){
        $board_name = "SSLC";
    }else{
        $board_name = $boardInfo->board_name;
    }
    $total_max_mark = 0;
    $total_mark = 0;
    $totalPercentage = 0; 
    if($boardInfo->board_name == "CBSE"){
        foreach($studentMarkInfo as $mark){
            $total_max_mark += $mark->max_mark;  
            $total_mark += $mark->obtnd_mark;
            $totalPercentage = ($total_mark / $total_max_mark) * 100;
        }
    } else if($boardInfo->board_name == "ICSE"){
        $markInfo = array_slice($studentMarkInfo, 0, 5, true);
        foreach($markInfo as $mark){
            $total_max_mark += $mark->max_mark;  
            $total_mark += $mark->obtnd_mark;
            $totalPercentage = ($total_mark / $total_max_mark) * 100;
        }
    } else {
        foreach($studentMarkInfo as $mark){
            if($mark->subject_name == 'EXEMPTED'){
                $max_mark = 0;  
            }else{
                $max_mark = $mark->max_mark;  
            }
            $total_max_mark += $max_mark;  
            $total_mark += $mark->obtnd_mark;
            $totalPercentage = ($total_mark / $total_max_mark) * 100;
        }
    }
    $total_percentage = round($totalPercentage,2);


$set_html=<<<EOD
<tr nobr="true">
    <td style="font-size: 15px;">Application No.: <b style="color: red;">$studentApplicationInfo->application_number</b></td>
</tr>
<table cellpadding="3" cellspacing="1">
    <tr nobr="true">
        <td width="100" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;vertical-align:middle;">
            <img width="200" height="220" src="assets/dist/img/logoSJPUC.png" alt="logo">
        </td>
        <td width="470" style="text-align:center;border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr>
                <td style="font-size:20px;"><b>ST JOSEPH'S PRE UNIVERSITY COLLEGE</b></td>
            </tr>
            <tr>
                <td style="font-size:14px;">(Department of Pre-University Education, Government of Karnataka)</td>
            </tr>
            <tr>
                <td style="font-size: 13px">F M Cariappa Road (Residency Road), Bengaluru-560025</td>
            </tr>
            <tr>
                <td style="font-size:18px;font-weight: bold;">Admission Form for I PUC 2022-23</td>
            </tr>
        </td>
        <td style="border-right: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;" width="100">
            <img style="vertical-align:middle;" height="90" width="80" src="assets/images/stjoseph.jpg" alt="LOGO">
        </td>
    </tr>
    <tr>
        <td style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;" width="672">
            <table cellpadding="1" cellspacing="1">
                <tr nobr="true">
                    <td style="text-align: center;font-size:12px;"><b>For Office Use Only</b></td>
                </tr>
                <tr>
                    <td style="width: 530px">
                        <table cellpadding="0">
                            <tr nobr="true">
                                <td style="text-align: center;font-size: 17px;width: 150px;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>$board_name</b></td>
                                <td style="text-align: center;font-size: 17px;width: 100px;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>$studentAdmissionInfo->stream_name</b></td>
                                <td style="text-align: center;font-size: 17px;width: 100px;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>$total_percentage %</b></td>
                                <td style="text-align: center;color: red;font-size: 17px;width: 150px;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>$studentApplicationInfo->application_number</b></td>
                            </tr>
                            <tr nobr="true">
                                <td style="font-size: 5px;width: 100px;"></td>
                                <td style="font-size: 5px;width: 100px;"></td>
                            </tr>
                            <tr nobr="true">
                                <td style="text-align: center;font-size: 13px;width: 200px;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>PH</b></td>
                                <td style="text-align: center;font-size: 13px;width: 70px;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>$studentApplicationInfo->physically_challenged</b></td>
                                <td style="text-align: center;font-size: 13px;width: 50px;"></td>
                                <td style="text-align: center;font-size: 13px;width: 110px;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>Dyslexic</b></td>
                                <td style="text-align: center;font-size: 13px;width: 70px;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>$studentApplicationInfo->dyslexia_challenged</b></td>
                            </tr>
                            <tr>
                                <td style="text-align: center;font-size: 13px;width: 100px;"><b>Sports Quota</b></td>
                                <td style="text-align: center;font-size: 13px;width: 100px;"><b>NCC Quota</b></td>
                            </tr>
                            <tr nobr="true">
                                <td style="text-align: center;font-size: 13px;width: 100px;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>$studentAdmissionInfo->national_level_sports_status</b></td>
                                <td style="text-align: center;font-size: 13px;width: 100px;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>$studentAdmissionInfo->ncc_certificate_status</b></td>
                                <td style="text-align: center;font-size: 13px;width: 150px;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>$studentApplicationInfo->religion</b></td>
                                <td style="text-align: center;font-size: 13px;width: 150px;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>$studentApplicationInfo->caste</b></td>
                            </tr>
                            <tr nobr="true">
                                <td style="font-size: 12px;width: 140px;"><i>Admit to:</b></td>
                                <td style="font-size: 12px;width: 150px;"><i>Date:</i></td>
                                <td style="font-size: 12px;width: 130px;"><i>Reg No:</i></td>
                            </tr>
                            <tr>
                                <td style="font-size: 2px;"></td>
                            </tr>
                            <tr nobr="true">
                                <td style="font-size: 12px;width: 60px;"><i>Language:</b></td>
                                <td style="font-size: 12px;width: 80px;"><b>$studentAdmissionInfo->second_language</b></td>
                                <td style="font-size: 12px;width: 150px;"><i>Verified by:</i></td>
                                <td style="font-size: 12px;width: 200px;"><i>Principal's Signature:</i></td>
                            </tr>
                        </table>
                    </td>
                    <td><img style="vertical-align:middle;" height="140" width="150" src="https://sjpuchassan.schoolphins.com/admission/$photoInfo->doc_path" alt="Student Image"></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;" width="672">
            <table cellpadding="1">
                <tr nobr="true">
                    <td style="font-size: 12px;width: 40px;"><i>Name:</b></td>
                    <td style="font-size: 12px;width: 320px;"><b>$studentApplicationInfo->name</b></td>
                    <td style="font-size: 12px;width: 76px;"><i>Date of Birth:</i></td>
                    <td style="font-size: 12px;"><b>$date_of_birth</b></td>
                </tr>
                <tr nobr="true">
                    <td style="font-size: 12px;width: 70px;"><i>Nationality:</b></td>
                    <td style="font-size: 12px;width: 140px;"><b>$studentApplicationInfo->nationality</b></td>
                    <td style="font-size: 12px;width: 80px;"><i>Native Place:</i></td>
                    <td style="font-size: 12px;width: 140px;"><b>$studentApplicationInfo->native_place</b></td>
                    <td style="font-size: 12px;width: 55px;"><i>Religion:</i></td>
                    <td style="font-size: 12px;width: 165px;"><b>$studentApplicationInfo->religion</b></td>
                </tr>
                <tr nobr="true">
                    <td style="font-size: 12px;width: 90px;"><i>Father's Name:</b></td>
                    <td style="font-size: 12px;width: 450px;"><b>$studentApplicationInfo->father_name</b></td>
                </tr>
                <tr nobr="true">
                    <td style="font-size: 12px;width: 80px;"><i>Qualification:</b></td>
                    <td style="font-size: 12px;width: 280px;"><b>$studentApplicationInfo->father_qualification</b></td>
                    <td style="font-size: 12px;width: 70px;"><i>Occupation:</b></td>
                    <td style="font-size: 12px;width: 250px;"><b>$studentApplicationInfo->father_profession</b></td>
                </tr>
                <tr nobr="true">
                    <td style="font-size: 12px;width: 90px;"><i>Mother's Name:</b></td>
                    <td style="font-size: 12px;width: 450px;"><b>$studentApplicationInfo->mother_name</b></td>
                </tr>
                <tr nobr="true">
                    <td style="font-size: 12px;width: 80px;"><i>Qualification:</b></td>
                    <td style="font-size: 12px;width: 280px;"><b>$studentApplicationInfo->mother_qualification</b></td>
                    <td style="font-size: 12px;width: 70px;"><i>Occupation:</b></td>
                    <td style="font-size: 12px;width: 250px;"><b>$studentApplicationInfo->mother_profession</b></td>
                </tr>
                <tr nobr="true">
                    <td style="font-size: 12px;width: 100px;"><i>Guardian's Name:</b></td>
                    <td style="font-size: 12px;width: 450px;"><b>$studentApplicationInfo->guardian_name</b></td>
                </tr>
                <tr nobr="true">
                    <td style="font-size: 12px;width: 180px;"><i>Medium of Instruction in School:</b></td>
                    <td style="font-size: 12px;width: 180px;"><b>$studentSchoolInfo->medium_instruction</b></td>
                    <td style="font-size: 12px;width: 97px;"><i>Year of Passing:</b></td>
                    <td style="font-size: 12px;"><b>$studentSchoolInfo->year_of_passed</b></td>
                </tr>
                <tr nobr="true">
                    <td style="font-size: 12px;width: 265px;"><i>Name and Address of the school Last Attended:</b></td>
                    <td style="font-size: 12px;width: 387px;"><b>$studentSchoolInfo->name_of_the_school</b></td>
                </tr>
                <tr nobr="true"><td style="font-size: 12px;width: 654px;"><b>$studentSchoolInfo->school_address</b></td>
                </tr>
            </table>
        </td>
    </tr>
    
    <tr nobr="true">
    <td style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;" width="672">
        <tr nobr="true">
            <td style="width: 400px">
                <tr nobr="true">
                    <td style="font-size: 12px;width: 250px"><b>Marks Scored in Class IX & X :</b></td>
                    <td style="font-size: 12px;"><b>$studentInfo->registration_number</b></td>
                </tr>
                <tr>
                    <td style="font-size: 2px;"></td>
                </tr>
                <table cellpadding="2" border-width="thin">
                <tr nobr="true">
                <td style="text-align: center;width: 220px;font-size: 12px;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"><b>Subjects</b></td>
                <td style="text-align: center;width: 70px;font-size: 12px;border-top: 1px solid black;border-right: 1px solid black;"><b>Max Marks</b></td>
                <td style="text-align: center;width: 90px;font-size: 12px;border-top: 1px solid black;border-right: 1px solid black;"><b>Marks Scored</b></td>

            </tr>
                    
                    $table
                    <tr nobr="true">
                        <td style="font-size: 12px;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>TOTAL</b></td>
                        <td style="text-align: center;font-size: 12px;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>$total_max_mark</b></td>
                        <td style="text-align: center;font-size: 12px;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>$total_mark</b></td>

                    </tr>
                    <tr nobr="true">
                        <td style="font-size: 12px;width: 110px"><b>10th Percentage:</b></td>
                        <td style="font-size: 12px;width: 90px"><b>$total_percentage %</b></td>
                    </tr>
                  
                </table>
            </td>
            <td style="width: 260px">
                <table cellpadding="1" cellspacing="3" border="0">
                    <tr nobr="true">
                        <td style="text-align: center;font-size: 12px;">
                            <b>Permanent Address</b>
                        </td>
                    </tr>
                    <tr nobr="true" cellpaddimg="2">
                        <td style="border:1px solid black;font-size: 12px;height: 40px"><b>$studentApplicationInfo->permanent_address_line_1<br>$studentApplicationInfo->permanent_address_line_2<br>$studentApplicationInfo->permanent_address_district<br>$studentApplicationInfo->permanent_address_state - $studentApplicationInfo->permanent_address_pincode</b></td>
                    </tr>
                    <tr nobr="true">
                        <td style="font-size: 1px;"></td>
                    </tr>
                    <tr nobr="true">
                        <td style="border:1px solid black;font-size: 12px;"><b>First Preference : $studentAdmissionInfo->stream_name</b><br/>
                            <b>Second Preference : $studentAdmissionInfo->second_stream_name</b>
                        </td>
                    </tr>
                    <tr nobr="true">
                    <td style="font-size: 1px;"></td>
                </tr>
                <tr nobr="true">
                    <td style="border:1px solid black;font-size: 12px;"><b>Integrated Batch : $studentAdmissionInfo->integrated_batch</b>
                    </td>
                </tr>
                    <tr nobr="true">
                        <td style="font-size: 12px;"><b>Name of the Receiver:</b></td>
                    </tr>
                    <tr nobr="true">
                        <td style="font-size: 12px;"><b>Signature of the Receiver:</b></td>
                    </tr>
                </table>
            </td>
        </tr>
    </td>
    </tr>
    </table>
    <tr> 
    <td style="font-size: 6px"></td>
</tr>

<table width="675" border="1" cellpadding="4" cellspacin="1">
    <tr nobr="true">
        <td width="130" style="font-size:5px;">
        </td>
        <td width="400" style="text-align:center;border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr>
                <td style="font-size:18px;text-transform: uppercase;"><b>St Joseph’s Pre University College</b></td>
            </tr>
            <tr>
                <td style="font-size:12px;"><span>(Department of Pre-University Education, Government of Karnataka)</span></td>
            </tr>
            <tr>
                <td style="font-size: 10px"><span>F M Cariappa Road (Residency Road), Bengaluru-560025</span></td>
            </tr>
        </td>
        <td width="140">
            <span style="font-size: 12px;text-align: right;">Acknowledgement (For Office use only</span>
        </td>
    </tr>
    <tr border="1">
        <td style="font-size: 12px;width: 180px"><i>Physically Handicapped: </i> <b>$studentApplicationInfo->physically_challenged</b></td>
        <td style="font-size: 12px;width: 180px"><i>Dyslexic: </i> <b>$studentApplicationInfo->dyslexia_challenged</b></td>
        <td style="font-size: 12px;width: 150px"><i>Sports Quota: </i> <b>$studentAdmissionInfo->national_level_sports_status</b></td>
        <td style="font-size: 12px;width: 200px"><i>NCC Quota: </i> <b>$studentAdmissionInfo->ncc_certificate_status</b></td>
    </tr>
    <tr>
        <table cellpadding="1">  
            <tr nobr="true">
                <td style="font-size: 12px;text-align:center;width: 90px;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>$board_name</b></td>
                <td style="font-size: 12px;text-align:center;width: 125px;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>$studentApplicationInfo->religion</b></td>
                <td style="font-size: 12px;text-align:center;width: 200px;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>$studentApplicationInfo->caste</b></td>
                <td style="font-size: 12px;text-align:center;width: 70px;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>$studentAdmissionInfo->stream_name</b></td>
                <td style="font-size: 12px;text-align:center;width: 80px;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>$total_percentage %</b></td>
                <td style="font-size: 12px;text-align:center;width: 90px;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;"><b>Pending</b></td>
            </tr>
        </table>
    </tr>
    <tr>
        <td style="width: 500px;font-size: 12px;"><b><i>Name of the student: </i> $studentApplicationInfo->name</b></td>
    </tr>
    <tr>
        <td width="675"><p style="font-size: 12px;"><i>Place: HASSAN</i></p>
            <p style="font-size: 12px;"><i><b>Date: $current_date</b> &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;</i> 
            <i>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; Signature of the Receiver</i></p>
        </td>
    </tr>
    </br>
  
    



<br pagebreak="true" />

<table style="border: 1px solid black;" cellpadding="8" cellspacing="1">

    <tr nobr="true">
        <td class="box" width="672" style="text-align: center;">
            <b style="font-size: 18px">STUDENT/PARENT’S or GUARDIAN’S UNDERTAKING</b>
        </td>
    </tr>
    <tr>
        <td style="text-align: justify;font-size: 14px;"><span>1. I here by accept that I will abide by the Administrative/Academic/Examination rules of the Department during my son’s/ward’s study in the College.</span><br/><br/>
            <span>2. I here by accept that, I will ascertain the Academic/Attendance progress of my son/ward from time to time from the College and also pay the damages if any caused by the student.</span><br/><br/>
            <span>3. I Understand, that minimum of 85% attendance in each subject is mandatory to make me/my son/ward eligible to take the board examinations.</span><br/><br/>
        </td>
    </tr>
    <tr>
        <td><p style="text-align:justify;font-size: 14px;font-weight: bold; line-height: 20px;"><i>I give the assurance that my son/ward will observe the rules and regulation of the college and of the
        PU department faithfully. I will monitor my son’s / Ward’s conduct, attendance and academic
        progress. I will ensure that my son/ward will strictly follow the dress code and attendance regulation
        and take full responsibility for his behaviour.</i></p></td><br/>
    </tr>
  
    <tr>
    <td></td>
</tr>
<tr>
    <td></td>
</tr>
<tr>
    <td></td>
</tr>
   
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td><p style="font-size: 14px;"><i>Place: HASSAN</i></p>
            <p style="font-size: 14px;"><i>Date: $current_date</i> 
            <i>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; Signature of the Applicant</i>  
            <i>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; Signature of Parent / Guardian</i></p>
        </td>
    </tr>
</table>
<table border="1" cellpadding="8" cellspacing="1">
    <tr nobr="true">
        <td style="text-align:center;font-size: 17px;">
            <b>For office use only</b>
        </td>
    </tr>
    <tr nobr="true">
        <td style="text-align:justify;font-size: 13px;line-height: 26px;"><b><i>Admission No : ________________Fee Paid____________________ Receipt No Date_________________ Reservation
            Category ________________________</i></b>
        </td>
    </tr>
    <tr>
        <td><p style="font-size: 14px;"><i>Place: HASSAN</i></p>
            <p style="font-size: 14px;"><i>Date: $current_date &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;</i> 
            <i>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; Signature of the Selection Committee Member</i></p>
        </td>
    </tr>
    </br>
</table>





 
 








                     
EOD;
//$pdf->writeHTML($set_html, true, false, true, false, '');
// small box
//$pdf->Cell(6, 6,'', 1, 0, 'R', 0, '', 0); 

$pdf->SetFont('helvetica', '', 18);
$pdf->writeHTML($set_html, true, false, false, false, '');

$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
ob_clean();
ob_flush();
$pdf->Output('Application.pdf', 'I');
ob_end_flush();
// end_ob_clean();

//============================================================+
// END OF FILE
//============================================================+

?>
