<style>
    .break { page-break-before: always; } 
    .break_after { page-break-before: none; } 
    @media print {
        .page-break {
            display: block;
            page-break-before: always;
        }

    }

    @media print {
        .noprint {
            display: none;
        }

        ::-webkit-scrollbar {
            display: none;
        }

        .enable-print {
            display: block !important;

        }
        @page {
            size: A4;
            margin: 10px; 
        
        }
        .main-footer,.floating-button{
            display: none !important;
        }
        .main-sidebar, .navbar{
            display: none !important;
        }
    }

    .A4 {
        /* overflow-x: scroll; */
        background: white;
        width: 26cm;
        height: 34.7cm;
        display: block;
        margin: 0 auto;
        padding: 25px;
        margin-bottom: 0.5cm;
        color: #000;
        box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
    }

    #border {
        border-radius: 1px;
        border: 2px solid black;
        width: 18.5cm;
        height: 26.7cm;

    }

    .stm_work {
        font-size: 25px;
        font-weight: bold;
    }

    .title {
        font-size: 30px;
        margin-left: -25px;
    }

    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;

        padding: 3px;
    }

    /* ------------------ */
    /* new added changes */
    /* ----------------- */

    .photo1 {
        margin-top: 0px !important;
    }

    .picture-box {
        margin-top: 15px;
    }

    .footer-sign {
        margin-top: 60px;
        text-transform: uppercase;
        font-size: 14px;
    }

    .boredr-only-top {
        border-top: solid;
        border-color: black;
        border-width: 1px;
        margin-top: 15px;
    }

    .box-address {
        margin-top: 40px;
    }

    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        line-height: 1.5 !important;
        vertical-align: inherit !important;
        border-top: 1px solid #ddd;
        border: 1px solid black !important;
        font-size: 14px;
    }

    tr {
        height: 21px !important;
    }

    .border_full {
        border-style: solid;
        padding: 7px;
        border-color: black;
        border-width: 1px;
    }

    .boredr_left {
        border-left: solid;
        padding: 7px;
        border-color: black;
        border-width: 1px;
    }

    .boredr_right {
        border-right: solid;
        padding: 7px;
        border-color: black;
        border-width: 1px;
    }

    .boredr_left_right {
        border-right: solid;
        border-left: solid;
        padding: 7px;
        border-color: black;
        border-width: 1px;
    }

    .boredr_only_bottom {
        border-bottom: solid;
        /* padding: 7px; */
        border-color: black;
        border-width: 1px;
    }

    .boredr_only_top {
        border-top: solid;
        padding: 7px;
        border-color: black;
        border-width: 1px;
    }

    .text_style_2 {
        margin-left: -12px;
        font-weight: bold;
        float: left;
        margin-top: -8px;
    }

    .photo_style {
        border: 1px solid;
        height: 165px;
        width: 155px;
        text-align: center;
        margin-left: 20px;
        margin-top: -15px !important;
    }

    .heading_three {
        margin-top: -12px;
        font-size: 24px;
        margin-bottom: -12px;
        text-transform: uppercase;
        text-decoration: underline;
    }

    .header-heading {
        margin-left: -80px;
    }

    .pb-5 {
        padding-bottom: 5px !important;
    }

    .headings {
        font-size: 20px !important;
    }

    .table_exam td {
        font-size: 20px !important;
        padding: 9px !important;
    }

    .table_exam th {
        font-size: 18px !important;
        padding: 4px !important;
    }
</style>
<div class="main-content-container container-fluid px-4 pt-2">
    <div class="content-wrapper">
        <div class="row noprint">
            <div class="col">
                <div class="card card-small p-0 card_heading_title">
                    <div class="card-body p-1 card-content-title">
                        <div class="row ">
                            <div class="col-md-8 col-8 text-black  " style="font-size:22px;"><i
                                    class="fa fa-file"></i> Students Admission Ticket - 2024-25
                                </div>
                            <div class="col-md-4 col-4"> 
                                <button style="float:right;" class="btn btn-primary" type="button" title="Print or Save the Mark Card" onClick="window.print()"><i class="fa fa-print"></i> Print/Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row form-employee">
            <div class="col-12">
                <div class="card card-small c-border p-0 mb-4">

                <div class="A4 enable-print">

                    <?php if (!empty($studentsRecords)) {
                        $studentCount = 0;
                        $total_students_selected = count((array)$studentsRecords);
                        foreach ($studentsRecords as $record) {
                            $studentCount++;
                            $total_students_selected--;
                            
                            if ($record->term_name == 'I PUC') {    
                                $img_path = "assets/images/PHOTOS_22_23_ALL/".$record->student_id.".JPG";
                            }else{
                                $img_path = "assets/images/PHOTOS_21_22_ALL/".$record->student_id.".jpg";
                            }
                    ?>

                            <div class="row boredr_only_top boredr_left_right">
                                <div class="col-2">
                                    <img height="110" class="pull-left" width="110" src="<?php echo base_url(); ?><?php echo INSTITUTION_LOGO; ?>" alt="logo">
                                </div>
                                <div class="col-10">
                                    <div class="header-heading text-center">
                                        <b style="font-size: 28px; text-transform: uppercase;"><?php echo TITLE; ?></b>
                                        <p style="margin-top: 0px; font-size:19px; text-transform: uppercase;" class="mb-1">II PUC FINAL PRACTICAL EXAMINATION FEBRUARY - 2024-25</p>
                                        <p class="heading_three text-uppercase"><b>Admission Ticket</b></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row boredr_left_right">
                                <div class="col-9">
                                    <div class="row">

                                        <table class="table">

                                            <tbody>
                                                <tr>
                                                    <td class="headings" style="border: 1px solid white !important;"><b>COLLEGE REGISTER NO. </b></td>
                                                    <td class="headings" style="border: 1px solid white !important;"><b> : <?php echo $record->student_id; ?></b></td>

                                                </tr>
                                                <tr>
                                                    <td class="headings" style="border: 1px solid white !important;"> <b>NAME OF THE CANDIDATE</b></td>
                                                    <td class="headings" style="border: 1px solid white !important;"><b> : <?php echo $record->student_name; ?></b></td>

                                                </tr>
                                                <tr>
                                                    <td class="headings" style="border: 1px solid white !important;"> <b>P.U. BOARD STUDENT NO. </b></td>
                                                    <td class="headings" style="border: 1px solid white !important;"><b> : <?php echo $record->pu_board_number; ?></b></td>

                                                </tr>

                                            </tbody>
                                        </table>

                                    </div>



                                </div>
                                <div class="col-3" colspan="3">
                                    <div class="photo_style photo1">
                                        <p style="font-size: 14px;margin-top: 1px;">
                                            <img width="150" height="160" class="text-right" src="<?php echo $img_path; ?>" height="100" alt="profile Img">
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row boredr_left_right boredr_only_bottom">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table_exam">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" width="50">SL. NO.</th>
                                                    <th width="350" class="text-center">SUBJECTS</th>
                                                    <th class="text-center">DATE</th>
                                                    <th class="text-center">TIME</th>
                                                    <th class="text-center">BATCH</th>
                                                    <th class="text-center">LAB</th>
                                                    <th class="text-center">SIGN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $s = 1;
                                                if (!empty($labSubjects)) {
                                                    foreach ($labSubjects as $sub) { ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $s++; ?></td>
                                                            <td><?php echo strtoupper($sub->name); ?></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                <?php }
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="footer-sign">
                                        <span style="font-size: 16px;" class=""><b>Signature of the Student</b></span>
                                        <span style="font-size: 16px;" class="pull-right"><b>Signature of the Principal</b></span>
                                    </div>
                                </div>

                            </div>




                            <?php
                            $pageBreakCheck = fmod($studentCount, 2);
                            if ($pageBreakCheck == 0) {
                            ?>
                                <div class="page-break"></div>
                            <?php
                            } else {
                                echo '<br><br><br><br>';
                            } ?>
                        <?php } ?>



                    <?php  } ?>
                </div>


            </div>
        </div>

        <div class="box-footer clearfix noprint">
            <button style="float:right;" class="btn btn-primary" type="button" title="Print or Save the Mark Card" onClick="window.print()"><i class="fa fa-download"></i> Print/Save</button>
        </div>
    <!-- </section> -->
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('ul.pagination li a').click(function(e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "studentsListing/" + value);
            jQuery("#searchList").submit();
        });
        // jQuery(function() {
        //     jQuery(this).bind("contextmenu", function(event) {
        //         event.preventDefault();
        //     });
        // });
    });
</script>