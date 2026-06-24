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
        page-break-before: always !important;
    }
    .enable-print { display: block !important; }
    
    /* min-height: auto */
}

.A4 {
    overflow: hidden;
    background: white;
    width: 21cm;
    height: 37.05cm; 
    display: block;
    margin: 0 auto;
    padding: 10px 20px;
    margin-bottom: 0.2cm;
    box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
    color: black !important;
}
.stm_work{
    font-size: 27px;
    font-weight: bold;
    font-family: monospace;
    margin-bottom: 10px;
}
.title{
    font-size: 30px;
    font-weight: 550;
    font-family: initial;
}

.space_above{
    margin-top: 250px !important;
}
.sub_title{
    font-size: 19px;
    font-weight: 550;
}
table>tbody>tr>th{ 
    border: 1px solid transparent !important;
    padding: 3px;
    font-size: 20px;
}
table>tbody>tr>td {
    border: 1px solid transparent !important;
    padding: 3px;
    font-size: 20px;
}

.table td, .table th{
    border-top: 1px solid transparent !important;
}

#signature_part {
    float: right;
    /* line-height: 18px; */
    padding-left: 125px;
    text-align: center;
    font-family: monospace;
    /* margin-top: 10px; */
}

.description{
    font-size: 26px;
    font-family: ui-monospace;
    font-style: italic;
    font-weight: 550;
}

.footer_text{
    font-size: 16px;
    font-weight: 550;
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
                                <i class="fa fa-file"></i> Conduct Certificate
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
                        foreach($studentsRecords as $record) {  
                            $subject = getSubjectsName($record->stream_name); 
                            $total_students_selected--;
                    ?>
                        <div class="A4" id="border">
                            <div class="enable-print">
                                <div style="margin-top:20px" class="row ">
                                    <div class="col-12 text-center">
                                        <div class="title"><?php echo TITLE?></div> 
                                            <!-- <p class="text-center sub_title text-uppercase">F. M. Cariappa (Residency) Road, Bengaluru – 560025, INDIA</p> -->
                                        <div style="font-family: serif;" class="text-center stm_work"><u class="font-weight-bold">CONDUCT CERTIFICATE</u></div>
                                    </div>
                                    <div class="col-12">
                                        <table class="table" style="margin-left:5px">
                                            <tr>
                                                <td width="470">1. Name of the Student <span class="pull-right">:</span></td>
                                                <td style="font-weight: 700;"><?php echo strtoupper($record->student_name); ?></td>
                                            </tr>
                                            <tr>
                                                <td>2. Class Register Number <span class="pull-right">:</span></td>
                                                <td><?php echo $record->student_id; ?></td>
                                            </tr>
                                            <tr>
                                                <td>3. Subjects <span class="pull-right">:</span></td>
                                                <td class="" width="700"><?php echo $record->stream_name; echo ' <span style="font-size:19px">( '.ucfirst($subject).')</span>'; ?></td>
                                            </tr>
                                            <tr>
                                                <td>4. Year of academic study <span class="pull-right">:</span></td>
                                                <td contenteditable="true">2019-2021</td>
                                            </tr>
                                        </table>
                                        <p class="text-center description">During his period of study at our college his character & conduct have been good and his diligence satisfactory</p>
                                    </div>
                                </div>
                                

                                <div class="row" style="margin-top: 40px;">
                                    <div class="col-6 ">
                                        <p class="footer_text">Date : <?php echo date('d-m-Y'); ?></p>
                                        <p class="footer_text">Hassan</p>
                                    </div>
                                    <div id="signature_part"  class="col-6 ">
                                        <!-- <br/><br/> -->
                                        <!-- <p class="footer_text">PRINCIPAL</p> -->
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


<?php 
function getSubjectsName($stream_name){
    //science
    $PCMB = 'Physics,Chemistry,Mathematics,Biology';
    $PCMC = 'Physics,Chemistry,Mathematics,Comp. Science';
    $PCME = 'Physics,Chemistry,Mathematics,Electronics';
    //commarce
    $PEBA = 'Pol. Science,Economics,Business Studies,Accountancy';
    $MEBA = 'Basic Maths,Economics,Business Studies,Accountancy';
    $MSBA = 'Basic Maths,Statistics,Business Studies,Accountancy';
    $CSBA = 'Comp. Science,Statistics,Business Studies,Accountancy';
    $SEBA = 'Statistics,Economics,Business Studies,Accountancy';
    $CEBA = 'Comp. Science,Economics,Business Studies,Accountancy';
    //art
    $HEPS ='History,Economics,Pol. Science,Sociology';
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