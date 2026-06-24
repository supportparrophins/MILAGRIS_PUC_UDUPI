<style>
    .break {
        page-break-before: always;
    }

    .break_after {
        page-break-before: none;
    }

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

        .main-footer,
        .floating-button {
            display: none !important;
        }

        .main-sidebar,
        .navbar {
            display: none !important;
        }
    }

    @page {
        size: A4;
        margin: 0;

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
    /* ---------------- */

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
        font-size: 25px;
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
        font-size: 22px !important;
    }

    .table_exam td {
        font-size: 18px !important;
        padding: 9px !important;
        font-family: serif;
    }

    .table_exam th {
        font-size: 18px !important;
        padding: 4px !important;
        font-family: serif;
    }

    .certificate_content{
        margin-top: 400px;
        margin-bottom: 0;
    
        font-size: 20px;
        font-family: 'Source Sans Pro' !important;
    }

    .border_bottom{
        border-bottom: 1px dotted black;
        border-width: thin;
        margin-left: 70px;
        margin-right: 70px;
        font-weight: bold;
        font-size: 20px !important;
    }
    .border_bottom_two{
        border-bottom: 1px dotted black;
        border-width: thin;
        margin-left: 90px;
        margin-right: 90px;
        margin-bottom: 20px;
        font-weight: bold;
        font-size: 20px !important;
    }

    .sign_part{
        margin-top: 130px;
    }

    .sign_text_rector{
        font-family: serif;
        margin-left: 30px;
    }

    .sign_text{
        font-family: serif;
        margin-left: -35px !important;
    }
</style>

<div class="main-content-container container-fluid px-4 pt-1 content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header noprint">
        <div class="row mt-1">
            <div class="col-12">
                <div class="card card-small p-0 card_heading_title">
                    <div class="card-body p-2 ml-2">
                        <span class="page-title absent_table_title_mobile">
                            <i class="fa fa-print"></i> Excellencia Certificate - <?php echo date('Y'); ?>
                            <button style="float:right;" class="btn btn-primary mt-0 mr-0" type="button" title="Print or Save the Mark Card" onClick="window.print()"><i class="fa fa-download"></i> Print/Save</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <?php if (!empty($studentsRecords)) {
            foreach ($studentsRecords as $record) { ?>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-small c-border mb-4 p-2">
                            <div class="A4 enable-print">
                                <div style="font-weight: 500">
                                    <div class="row text-center certificate_content">
                                        <div class="col-12">
                                            <p style="font-size:23px">This certificate is awarded to</p>
                                            <p class="border_bottom"> <span><?php echo $record->student_name; ?></span> </p>
                                            <p style="font-size:23px" class="mt_20">of</p>
                                            <p class="border_bottom_two"> <?php echo $record->term_name; ?> <?php echo $record->stream_name; ?> </p>
                                            <p style="font-size:23px">in appreciation for securing Distinction in the Examination conducted by the</p>
                                            <p style="font-size:23px">Department of Pre-University Education, Karnataka</p>
                                            <p style="font-size:23px">In March – April 20<?php echo date('y') - 1; ?></p>
                                        </div>
                                    </div>


                                    <div class="row sign_part">
                                        <div class="col-6 pull-left">
                                            <img style="margin-left:5px;" height="80" src="<?php echo base_url(); ?>assets/images/rector_sign.png" alt="Sign">
                                        </div>
                                        <div class="col-4">
                                        </div>
                                        <div class="col-2">

                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-6 pull-left" style="margin-top:-20px;">
                                            <h4 style="font-size:22px !important" class="sign_text_rector" style="font-family: 'Source Sans Pro' !important;">RECTOR</h4>
                                        </div>
                                        <div class="col-4">
                                        </div>
                                        <div class="col-2" style="margin-top:-20px;">
                                            <h4 style="font-size:22px !important; margin-left:-15px;" class="sign_text" style="font-family: 'Source Sans Pro' !important;">PRINCIPAL</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br />
                <?php }
        } ?>
                    </div>
                </div>
</div>
</section>
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