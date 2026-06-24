<?php



function getSubjectCodes($stream_name) {
    $map = [
        "PCMB" => ["33","34","35","36"],
        "PCMC" => ["33","34","35","41"],
        "PCME" => ["33","34","35","40"],
        "PCMS" => ["33","34","35","31"],
        "BEBA" => ["75","22","27","30"],
        "BSBA" => ["75","31","27","30"],
        "CSBA" => ["41","31","27","30"],
        "SEBA" => ["31","22","27","30"],
        "CEBA" => ["41","22","27","30"],
        "PEBA" => ["29","22","27","30"],
        "HEPP" => ["21","22","32","29"],
        "MEBA" => ["75","22","27","30"],
        "MSBA" => ["75","31","27","30"],
        "HEPS" => ["21","22","29","28"],
        "HEBA" => ["21","22","27","30"],
    ];
    return $map[$stream_name] ?? [];
}


$exam_year = date('Y');
?>
<style>
    body {
        margin: 0;
        padding: 0;
    }
    .header-table {
        border: none;
        border-collapse: collapse;
    }
    .header-table td {
        border: none !important;
        padding: 3px;
    }
 
    /* .page-border {
        border: 2px solid black; 
        padding: 10px;           
        height: 100%;
        box-sizing: border-box;
    } */


</style>
<style>
    body { font-family: timesnewroman, serif; font-size: 12px; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid black; padding: 5px; font-size: 12px; }
    th { background: #f2f2f2; }
    .ticket-header { text-align: center; margin-bottom: 10px; }
    .ticket-header h2 { font-size: 16px; margin: 2px 0; text-transform: uppercase; }
    .ticket-header h3 { font-size: 14px; margin: 2px 0; text-transform: uppercase; }
    .student-info p { margin: 3px 0; font-size: 12px; }
    .footer { margin-top: 20px; font-size: 12px; }
    .footer span { display: inline-block; width: 45%; }
</style>

<?php
$count = count($studentsRecords); 
foreach($studentsRecords as $record):
    $count--;
?>
   
    <?php
    
    // subject codes
    $subjects_code = [];
    $elective = strtoupper($record->elective_sub);
    if ($elective == "KANNADA") $subjects_code[] = "1";
    elseif ($elective == "HINDI") $subjects_code[] = "3";
    elseif ($elective == "FRENCH") $subjects_code[] = "12";
    $subjects_code[] = "2"; // English
    $subjects_code = array_merge($subjects_code, getSubjectCodes($record->stream_name));
    $student_id = strtoupper($record->student_id);
    $img_path = '';
    $file_path_jpg = $record->photo_url;
    if ($file_path_jpg) {
        $img_path = $file_path_jpg;
    }else{
    $img_path =   base_url().'assets\dist\img\user.png';
    }
    ?>

    <div class="ticket" class="page-border">

        <!-- Header with logo, title, photo -->
       <style>
        .header-table {
            border: none;
            border-collapse: collapse;
        }
        .header-table td {
            border: none !important; /* remove borders from cells */
            padding: 5px;
        }
        .student-info p {
        margin: 6px 0;       /* Adds vertical gap between lines */
        line-height: 1.2;    /* Increases line height */
        font-size: 13px;     /* Optional: adjust text size */
        }
        </style>

        <table class="header-table" width="100%">
            <tr>
                <td width="15%" align="left">
                    <img height="70" width="70"
                        src="<?php echo base_url(); ?><?php echo INSTITUTION_LOGO; ?>"
                        alt="logo">
                </td>
                <td width="80%" align="center">
                    <h2>LOYOLA PRE UNIVERSITY COLLEGE VIJAYAPUR</h2>
                    <p style="margin-top: 0px; font-size:17px; text-transform: uppercase;"><b><?php echo strtoupper($record->term_name); ?>&nbsp;<?php echo strtoupper($examType); ?> <br><u style="font-weight: bold;">Admission Ticket</u></b></p>
                </td>
                <td width="10%" align="right">
                    <img src="<?= $img_path; ?>" width="70" height="70">
                </td>
            </tr>
        </table>

        <br>  

        <div class="student-info">
            <p><b>Student ID :</b> </p>
            <p><b>Name of the Candidate :</b> <?= strtoupper($record->student_name); ?></p>
            <p><b>Class :</b> <?= $record->term_name." (".$record->stream_name.")"; ?></p>
            <p><b>Gender :</b> <?= strtoupper($record->gender); ?></p>
            <p><b>Name of Father :</b> <?= strtoupper($record->father_name); ?></p>
            <p><b>Name of Mother :</b> <?= strtoupper($record->mother_name); ?></p>
            <p><b>Medium :</b> <?= strtoupper($record->medium); ?></p>
        </div>
<br>
        <table>
            <thead>
                <tr>
                    <th>Subjects Offered</th>
                    <th>Date & Time</th>
                    <th>Invigilator Sign</th>
                </tr>
            </thead>
            <tbody>
                
                <?php log_message("debug","subjects_code".print_r($subjects_code,true)); foreach($subjects_code as $sub): ?>
                    <?php $examInfo = $examData->getExamInfo($record->term_name,$record->stream_name,$sub,$examType); ?>
                    <?php foreach($examInfo as $exam): ?>
                        <tr>
                            <td class="text-left" style="text-transform: uppercase;"><?php echo $exam->subject_code.' - '.$exam->name; ?></td>
                            <td align="center">
                                <?= date('d-m-Y',strtotime($exam->exam_date)); ?>
                                <?= ($exam->time=="Morning session") ? MORNING_EXAM : AFTERNOON_EXAM; ?>
                            </td>
                            <td></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
<br><br><br><br><br><br>
        <div class="footer">
            &nbsp;<span><b>Signature of the Candidate</b></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    
            <span style="text-align:right;"><b>Signature of the Prinicipal</b></span>
        </div>
    </div>
    <?php 
        if($count>0){ ?>
            <pagebreak />
    <?php } ?>
<?php endforeach; ?>
