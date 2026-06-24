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

    .table-details>thead:first-child>tr:first-child>th,
    .table-details>tbody>tr>th,
    .table-details>thead>tr>th {
        border: 1px solid transparent !important;
    }

    .table-details>thead:first-child>tr:first-child>td,
    .table-details>thead>tr>td,
    .table-details>tbody>tr>td {
        border-top: 1px solid transparent !important;
        border-bottom: 2px solid black !important;
        border-right: 1px solid transparent !important;
    }

    .table-family,
    .table-personal,
    .personal-heading {
        margin-top: 20px;
    }

    .table-address {
        margin-top: 10px;
    }

    .table-name>tbody>tr>th,
    .table-name>thead>tr>th,
    .table-family>tbody>tr>th,
    .table-personal>tbody>tr>th,
    .table-address>tbody>tr>th {
        padding: 7px !important;
    }

    .table-name>tbody>tr>td,
    .table-name>thead>tr>td .table-family>tbody>tr>td,
    .table-personal>tbody>tr>td,
    .table-address>tbody>tr>td {
        padding: 7px !important;
    }

    .photo1 {
        margin-top: -70px !important;
    }

    .picture-box {
        margin-top: 15px;
    }

    input[type=checkbox] {
        cursor: pointer;
        font-size: 10px;
        visibility: hidden;
        position: unset !important;
        top: 0;
        margin-left: 0px !important;
        transform: scale(1.5);
    }

    input[type=checkbox]:after {
        content: " ";
        background-color: #fff;
        display: inline-block;
        color: black;
        width: 10px;
        height: 10px;
        visibility: visible;
        border: 1px solid black;
        padding: 2px;
        margin: 1px 0;
        border-radius: 1px;
        box-shadow: 0 0 15px 0 rgba(0, 0, 0, 0.08), 0 0 2px 0 rgba(0, 0, 0, 0.16);
    }

    input[type=checkbox]:checked:after {
        content: "\2714";
        display: unset;
        font-weight: bold;
        width: 15px;
        height: 15px;
        padding: 2px
    }

    .checkbox-inline {
        padding-left: 9px !important;
    }

    .list-checker {
        padding-left: 8px !important;
        padding-right: 3px !important;
    }

    .list-facility {
        margin-top: 10px;
        margin-left: 8px;
    }

    .footer-sign {
        margin-top: 90px;
        margin-bottom: 40px;
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

    .table-studform>thead>tr>td {
        padding: 20px !important;
    }

    .table-studform>thead>tr>th {
        padding-top: 20px !important;
    }

    .box-address>thead>tr>th {
        text-align: center;
        padding-top: 0px !important;
        padding-bottom: 120px !important;
    }


    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        padding: 3px !important;
        line-height: 1.0 !important;
        vertical-align: top !important;
        border-top: 1px solid #ddd;
        border: 1px solid black !important;

    }

    tr {
        height: 21px !important;
    }

    .modal-header {
        color: white !important;
        padding: 15px !important;
        background: #0d528b !important;
        border-bottom: 1px solid #0d5ea2 !important;
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

    .text_style_2 {
        margin-left: -12px;
        font-weight: bold;
        float: left;
        margin-top: -8px;
    }

    .photo_style {
        border: 1px solid;
        height: 175px;
        width: 165px;
        text-align: center;
        margin-left: 20px;
    }
</style>
<div class="main-content-container container-fluid px-4 pt-2">
    <div class="content-wrapper">
        <div class="row noprint">
            <div class="col">
                <div class="card card-small p-0 card_heading_title">
                    <div class="card-body p-1 card-content-title">
                        <div class="row ">
                            <div class="col-md-8 col-8 text-black  " style="font-size:22px;"><i class="fa fa-file"></i> Students Bio Data
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
                            $total_students_selected = count((array)$studentsRecords);
                            foreach ($studentsRecords as $record) {
                                $total_students_selected--;

                                 if ($record->term_name == 'II PUC') {    
                                    $img_path = "assets/images/PHOTOS_21_22_ALL/".$record->student_id.".jpg";
                                }else{
                                    $img_path = "assets/images/PHOTOS_22_23_ALL/".$record->student_id.".jpg";
                                }
                        ?>
                                <div class="row" style="overflow-x: scroll;">
                                    <div class="col-12">

                                        <div class="A4 enable-print">
                                            <div style="">
                                                <div class="row border_full">
                                                    <div class="col-2">
                                                        <img style="margin-right: -55px;" height="110" class="pull-right" width="110" src="assets/images/logo.png" alt="logo">
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="header-heading text-center">
                                                            <b style="font-size: 30px; text-transform: uppercase;">St Joseph’s Pre University
                                                                College</b>
                                                            <p style="margin-top: -10px; font-size:16px;">(Department of Pre-University Education,
                                                                Government of Karnataka)</p>
                                                            <p style="margin-top: -14px; font-size:16px;">F M Cariappa Road (Residency Road),
                                                                Bengaluru-560025</p>
                                                            <p style="margin-top:-12px; font-size: 25px; margin-bottom: -12px; "><b></b></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        <img style="margin-left: -44px;" class="text-right" width="80" src="assets/images/stjoseph.jpg" height="100" alt="logo">
                                                    </div>
                                                </div>
                                                <div class="row boredr_left_right">
                                                    <div class="col-6 personal-heading">
                                                        <b style="font-size: 18px;">A. PERSONAL RECORD</b>
                                                    </div>
                                                    <div class="col-6">
                                                        <b class="address_preference_style border_full" style="font-size: 18px; float: right;">APPLICATION No.:
                                                            <?php echo $record->application_no; ?></b>
                                                    </div>
                                                    <div class="col-9">
                                                        <table class="table table-bordered table-responsive table-personal table-name table-details">
                                                            <thead>
                                                                <tr>
                                                                    <th width="50">NAME</th>
                                                                    <td><b><?php echo $record->student_name; ?></b></td>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                        <table class="table table-bordered table-responsive table-personal table-details">
                                                            <thead>
                                                                <tr>
                                                                    <th width="120">CLASS & SECTION</th>
                                                                    <td width="120"><b><?php echo $record->term_name; ?> <?php echo $record->section_name; ?></b></td>
                                                                    <th width="70">REG No. :</th>
                                                                    <td width="110"><b><?php echo $record->student_id; ?></b></td>
                                                                    <th width="35">COMBINATION</th>
                                                                    <td width="110"><b><?php echo $record->stream_name; ?></b></td>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="row boredr_left_right">
                                                    <div class="col-9">
                                                        <table class="table table-bordered table-responsive table-address">
                                                            <tbody>
                                                                <tr>
                                                                    <th class="text-center" width="350">Residential Address</th>
                                                                    <th width="120">Date & Birth</th>
                                                                    <th><b><?php echo date('d-m-Y', strtotime($record->dob)); ?></b></th>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="4"><b><?php if ($record->present_address != "") {
                                                                                            echo $record->present_address;
                                                                                        } else {
                                                                                            echo $record->residential_address;
                                                                                        }  ?></b></td>
                                                                    <th>Blood Group</th>
                                                                    <th><b><?php echo $record->blood_group; ?></b></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Religion</th>
                                                                    <th><b><?php echo $record->religion; ?></b></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Caste</th>
                                                                    <th><b><?php echo $record->caste; ?></b></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Mother Tongue</th>
                                                                    <th><b><?php echo $record->mother_tongue; ?></b></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Residential No.: </th>
                                                                    <th>Identification Mark</th>
                                                                    <th></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Student Email: <b><?php echo $record->email; ?></b></th>
                                                                    <th colspan="2">Student Cell: <b><?php echo $record->mobile; ?></b></th>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table class="table table-bordered table-responsive table-family">
                                                            <tbody>
                                                                <tr>
                                                                    <th colspan="6" style="font-size: 18px;">B. FAMILY RECORD</th>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-center" width="30">SL No.</th>
                                                                    <th class="text-center">Name of the Member</th>
                                                                    <th class="text-center">Age</th>
                                                                    <th class="text-center">Relationship</th>
                                                                    <th class="text-center">Occupation</th>
                                                                    <th class="text-center">Annual Income</th>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-center">1</th>
                                                                    <td><b><?php echo $record->father_name; ?></b></td>
                                                                    <td><b><?php echo $record->father_age; ?></b></td>
                                                                    <td><b>Father</b></td>
                                                                    <td><b><?php echo $record->father_profession; ?></b></td>
                                                                    <td><b><?php echo $record->father_annual_income; ?></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-center">2</th>
                                                                    <td><b><?php echo $record->mother_name; ?></b></td>
                                                                    <td><b><?php echo $record->mother_age; ?></b></td>
                                                                    <td><b>Mother</b></td>
                                                                    <td><b><?php echo $record->mother_profession; ?></b></td>
                                                                    <td><b><?php echo $record->mother_annual_income; ?></b></td>
                                                                </tr>
                                                                <?php
                                                                $i = 3;
                                                                foreach ($sibInfo as $sib) {
                                                                    if ($sib->student_id == $record->student_id) {
                                                                ?>
                                                                        <tr>
                                                                            <th class="text-center"><?php echo $i++; ?></th>
                                                                            <td><?php echo $sib->sibling_name; ?></td>
                                                                            <td><?php echo $sib->age; ?></td>
                                                                            <td><?php echo $sib->relation_type; ?></td>
                                                                            <td></td>
                                                                            <td><?php echo $sib->annual_income; ?></td>
                                                                        </tr>
                                                                <?php }
                                                                } ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-3" colspan="3">
                                                        <div class="photo_style photo1">
                                                            <p style="font-size: 14px;margin-top: 10px;">
                                                                <img width="150" height="150" class="text-right" src="<?php echo $img_path; ?>" height="100" alt="profile Img">
                                                            </p>
                                                        </div>
                                                        <div class="photo_style picture-box">
                                                            <p style="font-size: 14px;margin-top: 65px;">PARENTS/GUARDIANS PHOTO</p>
                                                        </div>
                                                        <div class="photo_style  picture-box">
                                                            <p style="font-size: 14px;margin-top: 65px;">PARENTS/GUARDIANS PHOTO</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row boredr_left_right">
                                                    <div class="col-12">
                                                        <table class="table table-bordered table-responsive">
                                                            <tbody>
                                                                <tr>
                                                                    <th>Father's Email : <?php echo $record->father_email; ?>
                                                                        <br>Cell No.: <?php echo $record->father_mobile; ?></b>
                                                                    </th>
                                                                    <th>Mother's Email : <?php echo $record->mother_email; ?>
                                                                        <br>Cell No.: <?php echo $record->mother_mobile; ?></b>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Office
                                                                        <br>Contact No.:
                                                                    </th>
                                                                    <th>Office
                                                                        <br>Contact No.:
                                                                    </th>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="row boredr_left_right boredr_only_bottom">
                                                    <div class="col-12">
                                                        <table class="table table-bordered table-responsive ">
                                                            <thead>
                                                                <tr>
                                                                    <th>1. Hobbies & Interests:</th>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th width="400">2. Any Chronic Health Problem or Physical disability ? Specify</th>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th colspan="2">3. Facilities availed from the College
                                                                        <ol class="list-inline list-facility" type="a">
                                                                            <li class="list-checker">a. Mid Day Meal
                                                                                <label class="checkbox-inline" id="check" name="check"> <input name="check" type="checkbox" value=""></label>
                                                                            </li>
                                                                            <li class="list-checker">b. Scholorship
                                                                                <label class="checkbox-inline" id="check" name="check"> <input name="check" type="checkbox" value=""></label>
                                                                            </li>
                                                                            <li class="list-checker">c. Book Bank
                                                                                <label class="checkbox-inline" id="check" name="check"> <input name="check" type="checkbox" value=""></label>
                                                                            </li>
                                                                        </ol>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                        <div class="row ">
                                                            <div class="col-12">
                                                                <p style="font-size: 16px;"><b><span>DECLARATION:</span> I hereby declare that for
                                                                        foregoing information is true to the best of my knowledge and belief.</b></p>
                                                                <div class="footer-sign">
                                                                    <span style="font-size: 16px;" class=""><b>Signature of the Parent /
                                                                            Guardian</b></span>
                                                                    <span style="font-size: 16px;" class="pull-right"><b>Signature of the
                                                                            Student</b></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if ($total_students_selected != 0) {
?>
    <div class="page-break"></div>
<?php
                                } ?>

<?php } ?>



<?php  } ?>

<div class="box-footer clearfix noprint">
    <button style="float:right;" class="btn btn-primary" type="button" title="Print or Save the Mark Card" onClick="window.print()"><i class="fa fa-download"></i> Print/Save</button>
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
        jQuery(function() {
            jQuery(this).bind("contextmenu", function(event) {
                event.preventDefault();
            });
        });
    });
</script>