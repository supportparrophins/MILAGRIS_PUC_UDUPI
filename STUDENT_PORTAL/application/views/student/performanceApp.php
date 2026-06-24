<?php require APPPATH . 'views/includes/db.php'; 
$base_url = 'https://sjpuc.schoolphins.com/student/'; ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $pageTitle; ?></title>
    <link rel="icon" href="<?php echo $base_url; ?>assets/dist/img/dolphin_logo.png">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/material-components-web/6.0.0/material-components-web.min.css" />
    <link rel="stylesheet"
        href="<?php echo $base_url; ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" />
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- <link rel="stylesheet" id="main-stylesheet" data-version="1.0.0"
        href="<?php echo $base_url; ?>assets/dist/styles/shards-dashboards.1.0.0.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/dist/styles/extras.1.0.0.min.css"> -->

    <link href="<?php echo $base_url; ?>assets/dist/css/style.css" rel="stylesheet" type="text/css" />
    <meta name="apple-mobile-web-app-title" content="">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">


    <!-- FontAwesome 4.3.0 -->
    <link href="<?php echo $base_url; ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet"
        type="text/css" />


    <style>
    .error {
        color: red;
        font-weight: normal;
    }

    .blink_me {
        animation: blinker 1s linear infinite;
        color: red;
        font-weight: bold;
        float: right;
        padding-left: 10px;
    }

    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }
    </style>
    <!-- <script src="<?php echo $base_url; ?>assets/bower_components/jquery/dist/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/material-components-web/6.0.0/material-components-web.min.js">
    </script>
    <script type="text/javascript">
    var baseURL = "<?php echo $base_url; ?>";
    </script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-messaging.js"></script>
    <!-- Initializing Firebase -->
    <script src="<?php echo $base_url;?>assets/notification/initialize_firebase.js"></script>
    <!-- Receiving token from FCM server -->
    <script src="<?php echo $base_url;?>assets/notification/fcm-push-notification.js"></script>
    <!-- Handle incoming messages -->
    <script src="<?php echo $base_url;?>assets/notification/handle_message.js"></script>
    <!-- Setting notification count -->
    <script src="<?php echo $base_url;?>assets/notification/notification-counter.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Loader Script -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/jquery/jquery.cookie.js"></script>
    <script src="<?=base_url()?>assets/plugins/sweetalert/sweetalert2.0.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script>
    function showLoader() {
        $(".custom_loader").addClass('active');
        $("#custom_loader_text").css('display', 'block');
    }

    function hideLoader() {
        $(".custom_loader").removeClass('active');
        $("#custom_loader_text").css('display', 'none');
    }
    $(document).ready(() => {
        $(".btn-backtrack").click((evt) => {
            showLoader();
            if (document.referrer != "" && window.history.length > 1) {
                window.history.go(-1);
            } else {
                location.href = "<?=$base_url?>dashboard";
            }
        });

        $("form").on('submit', (evt) => {
            if ($(evt.target).data('download_form')) {
                $.cookie('isDownloading', '1');
                showLoader();
                const intervalID = setInterval(() => {
                    if ($.cookie('isDownloading') == 0) {
                        hideLoader();
                        clearInterval(intervalID);
                    }
                }, 2000);
            } else {
                showLoader();
            }
        });

        $("li.nav-item > .nav-link[href*='<?=$base_url?>']").on('click', function() {
            showLoader();
        });
    });
    </script>
    <!-- End of Loader Script -->

    <!-- Loader Style -->
    <style>
    /* Absolute Center Spinner */
    .custom_loader {
        position: fixed;
        z-index: 99999;
        height: 2em;
        width: 2em;
        overflow: visible;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
    }

    /* Transparent Overlay */
    .custom_loader.active:before {
        content: '';
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.3);
    }

    /* :not(:required) hides these rules from IE9 and below
        .custom_loader.active:not(:required) {
            font: 0/0 a;
            color: transparent;
            text-shadow: none;
            background-color: transparent;
            border: 0;
        } */

    .custom_loader.active:not(:required):after {
        content: '';
        display: block;
        font-size: 40px;
        width: 0.4em;
        height: 0.4em;
        margin-top: -0.5em;
        -webkit-animation: spinner 1500ms infinite linear;
        -moz-animation: spinner 1500ms infinite linear;
        -ms-animation: spinner 1500ms infinite linear;
        -o-animation: spinner 1500ms infinite linear;
        animation: spinner 1500ms infinite linear;
        border-radius: 0.5em;
        -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
        box-shadow: rgba(26, 26, 255, 1) 1.5em 0 0 0, rgba(85, 255, 0, 1) 1.1em 1.1em 0 0, rgba(26, 26, 255, 1) 0 1.5em 0 0, rgba(85, 255, 0, 1) -1.1em 1.1em 0 0, rgba(26, 26, 255, 1) -1.5em 0 0 0, rgba(85, 255, 0, 1) -1.1em -1.1em 0 0, rgba(26, 26, 255, 1) 0 -1.5em 0 0, rgba(0, 255, 0, 1) 1.1em -1.1em 0 0;
    }

    /* Animation */

    @-webkit-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @-moz-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @-o-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    </style>
    <!-- End of Loader Style -->




</head>

<body class="hold-transition skin-blue sidebar-mini" style="overflow-x: hidden;">
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

    <?php 
    
            
    
    ?>
    <div class="row form-employee">

        <div class="col-12 padding_left_right_null">

            <div class="card card-small c-border mb-4">

                <ul class="list-group list-group-flush">

                    <li class="list-group-item">

                        <div class="row">

                            <div class="col profile-head">

                                <ul class="nav nav-tabs" id="myTab" role="tablist">

                                    <?php //if($term_name == 'I PUC'){ ?>

                                    <!-- <li class="nav-item ">
                                        <a class="nav-link" id="first_class_test-tab" data-toggle="tab"
                                            href="#first_class_test" role="tab" aria-controls="first_class_test"
                                            aria-selected="true">I Class Test
                                        </a>
                                    </li>

                                    <li class="nav-item ">
                                        <a class="nav-link" id="first_unit_test-tab" data-toggle="tab"
                                            href="#first_unit_test" role="tab" aria-controls="first_unit_test"
                                            aria-selected="true">I Unit Test
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" id="midterm-tab" data-toggle="tab"
                                            href="#midterm" role="tab" aria-controls="midterm"
                                            aria-selected="true">MID TERM
                                        </a>
                                    </li> -->

                                    <?php if($studentInfo->term_name == 'I PUC'){ ?>
                                        <li class="nav-item">
                                        <a class="nav-link active" id="annual_exam-tab" data-toggle="tab" href="#annual_exam"
                                        role="tab" aria-controls="annual_exam" aria-selected="false">ANNUAL EXAM - MARCH 2025</a>
                                        </li> 
                                    <?php } ?>
                                    <?php //} ?>

                                </ul>
                                <div class="tab-content personal-tab" id="myTabContent">
                                <div class="tab-pane fade" id="first_class_test" role="tabpanel"
                                    aria-labelledby="first_class_test-tab">
                                    <div class=" table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th colspan="5" class="table_title text-center">I CLASS TEST
                                                        2024-25</th>
                                                </tr>
                                                <tr class="table-success">
                                                    <th class="text-center">SUBJECTS</th>
                                                    <th class="text-center">Max. Marks</th>
                                                    <th class="text-center">Min. Marks</th>
                                                    <th class="text-center">Marks Scored</th>
                                                </tr>
                                            </thead>
                                            <?php 
                                               
                                                    $result_subject_fail_status = false;
                                                    $result_fail_status = false;
                                                    $max_mark = 0;
                                                    $min_mark_pass = 0;
                                                    $total_mark_obtained = 0;
                                                    $total_max_mark = 0;
                                                    $total_min_mark = 0;
                                                 
                                                    for($i=0;$i<count($subject_code);$i++){
                                                        if(strtoupper($firstClassTestMarkInfo[$i]->sub_name) != ''){ 
                                                        $result_display = "";
                                                        $result_subject_fail_status = false;
                                                        if($firstClassTestMarkInfo[$i]->lab_status == 'true'){
                                                            $max_mark = 100;
                                                            $min_mark_pass = 35;
                                                        }else{
                                                            $max_mark = 100;
                                                            $min_mark_pass = 35;
                                                        }
                                                        $total_max_mark += $max_mark;
                                                        $total_min_mark += $min_mark_pass;
                                                        $obtainedMark = $firstClassTestMarkInfo[$i]->obt_theory_mark;
                                                        // $obatained_mark = (float)$obtainedMark * 4;
                                                        $obatained_mark = $obtainedMark;

                                                        if($obtainedMark == 'AB' || $obtainedMark == 'EXEM' || $obtainedMark == 'MP' || $obtainedMark == 'SAT'){
                                                            $result_subject_fail_status = true;
                                                            $result_display = $obtainedMark;
                                                            $result_fail_status = true;
                                                        }else if($min_mark_pass > $obatained_mark){
                                                            $result_subject_fail_status = true;
                                                            $result_fail_status = true;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark .'F';
                                                        }else{
                                                            $result_subject_fail_status = false;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark;
                                                        }
                                                    ?>
                                            <tr>
                                                <th>
                                                    <?php echo strtoupper($firstClassTestMarkInfo[$i]->sub_name); ?>
                                                </th>
                                                <th class="text-center table_marks_data"><?php echo $max_mark; ?>
                                                </th>
                                                <th class="text-center table_marks_data">
                                                    <?php echo $min_mark_pass; ?></th>
                                                <?php if($result_subject_fail_status == true){ ?>
                                                <th style="background: #f76a7ebf" class="text-center table_marks_data">
                                                    <?php echo $result_display; ?></th>
                                                <?php }else{ ?>
                                                <th class="text-center table_marks_data">
                                                    <?php echo $result_display; ?></th>
                                                <?php } ?>
                                            </tr>
                                            <?php  } }
                                                       if($total_mark_obtained != 0){
                                                        $total_percentage = ($total_mark_obtained/$total_max_mark)*100; 
                                                        $exam_result = calculateResult($total_mark_obtained);
                                                        ?>
                                            <tr class="text-center table_row_backgrond">
                                                <th class="total_row">Total</th>
                                                <th><?php echo $total_max_mark; ?></th>
                                                <th><?php echo $total_min_mark; ?></th>
                                                <th><?php echo $total_mark_obtained; ?></th>
                                            </tr>

                                            <tr>
                                                <th colspan="2" class="total_row">Percentage:
                                                    <?php echo round($total_percentage,2).'%'; ?></th>
                                                <th colspan="2">Result:
                                                    <?php if($result_fail_status == true){ ?>
                                                    <span class="text_fail"><?php echo 'FAIL'; ?></span>
                                                    <?php } else { ?>
                                                    <span class="text_pass"><?php echo $exam_result; ?></span>
                                                    <?php } ?>
                                                </th>
                                            </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                </div>
                              
                                <div class="tab-pane fade show " id="midterm" role="tabpanel"
                                    aria-labelledby="midterm-tab">
                                    <div class=" table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th colspan="7" class="table_title text-center">MID TERM
                                                        2024-25</th>
                                                </tr>
                                                <tr class="table-success">
                                                    <th class="text-center">SUBJECTS</th>
                                                    <th class="text-center">Max. Marks</th>
                                                    <th class="text-center">Min. Marks</th>
                                                    <th class="text-center">Lab Min. Marks</th>
                                                    <th class="text-center">THEORY MARKS</th>
                                                    <th class="text-center">LAB MARKS</th>
                                                    <th class="text-center">Marks Scored</th>
                                                </tr>
                                            </thead>
                                            <?php 
                                                        $obtainedLabMark = 0; 

                                                    $result_subject_fail_status = false;
                                                    $result_fail_status = false;
                                                    $max_mark = 0;
                                                    $min_mark_pass = 0;
                                                    $total_mark_obtained = 0;
                                                    $total_max_mark = 0;
                                                    $total_min_mark = 0;
                                                    $total_mark_display = 0;

                                                 
                                                    for($i=0;$i<count($subject_code);$i++){
                                                        if(strtoupper($midTermMarkInfo[$i]->name) != ''){ 
                                                        // log_message('debug','JJJ'.print_r($midTermMarkInfo,true));

                                                        $result_display = "";
                                                        $result_subject_fail_status = false;
                                                        if($midTermMarkInfo[$i]->lab_status == 'true'){
                                                            $max_mark = 100;
                                                            $min_mark_pass = 21;
                                                            // $total_pass_mark = 35;
                                                            $lab_Pass_mark = 14;


                                                        }else{
                                                            $max_mark = 80;
                                                            $min_mark_pass = 24;
                                                            // $total_pass_mark = 24;

                                                        }
                                                        $total_max_mark += $max_mark;
                                                        $total_min_mark += $min_mark_pass;
                                                        $obtainedMark = $midTermMarkInfo[$i]->obt_theory_mark;
                                                        // $obatained_mark = (float)$obtainedMark * 4;
                                                        // $obatained_mark = $obtainedMark;

                                                        // if($obtainedMark == 'AB' || $obtainedMark == 'EXEM' || $obtainedMark == 'MP' || $obtainedMark == 'SAT'){
                                                        //     $result_subject_fail_status = true;
                                                        //     $result_display = $obtainedMark;
                                                        //     $result_fail_status = true;
                                                        // }else if($min_mark_pass > $obatained_mark){
                                                        //     $result_subject_fail_status = true;
                                                        //     $result_fail_status = true;
                                                        //     $total_mark_obtained += $obatained_mark;
                                                        //     $result_display = $obatained_mark .'F';
                                                        // }else{
                                                        //     $result_subject_fail_status = false;
                                                        //     $total_mark_obtained += $obatained_mark;
                                                        //     $result_display = $obatained_mark;
                                                        // }
                                                        if($obtainedMark == 'AB' || $obtainedMark == 'EXEM' || $obtainedMark == 'MP' || $obtainedMark == 'SA' || $obtainedMark == 'ASGN'){
                                                            $result_subject_fail_status = true;
                                                            $result_display = $obtainedMark;
                                                            $result_fail_status = true;
                                                            // $total_mark_display = $obtainedMark;
                                                            if($subject == 12 || $midTermMarkInfo[$i]->lab_status == "true"){
                                                                $obtainedLabMark = $midTermMarkInfo[$i]->obt_lab_mark;
                                                                }else{
                                                                    $obtainedLabMark = '-'; 
                                                                }
                                                                $total_obt_mark = $obtainedMark + $obtainedLabMark;
                                                                $total_mark_obtained += $total_obt_mark;
                                                                $total_mark_display = $total_obt_mark.'F';
                                                        } else if($subject == 12 || $midTermMarkInfo[$i]->lab_status == "true"){
                                                            $obtainedLabMark = $midTermMarkInfo[$i]->obt_lab_mark;
                                                            $total_obt_mark = $obtainedMark + $obtainedLabMark;
                                                              if($min_mark_pass > $obtainedMark || $lab_Pass_mark > $obtainedLabMark){
                                                                $result_subject_fail_status = true;
                                                                $result_fail_status = true;
                                                                $total_mark_obtained += $total_obt_mark;
                                                                $result_display = $obtainedMark.'F';
                                                                $total_mark_display = $total_obt_mark.'F';
                                                              }
                                                            //   else if($total_pass_mark > $total_obt_mark){
                                                            //     $result_subject_fail_status = true;
                                                            //     $result_fail_status = true;
                                                            //     $total_mark_obtained += $total_obt_mark;
                                                            //     $result_display = $obtainedMark;
                                                            //     $total_mark_display = $total_obt_mark.'F';
                                                            //   }
                                                              else{
                                                                $result_subject_fail_status = false;
                                                                // $result_fail_status = false;
                                                                $total_mark_obtained += $total_obt_mark;
                                                                $result_display = $obtainedMark; 
                                                                $obtainedLabMark = $midTermMarkInfo[$i]->obt_lab_mark;
                                                                $total_mark_display = $total_obt_mark;
                                                              }
                                                         } else if($total_pass_mark > $obtainedMark){
                                                            $result_subject_fail_status = true;
                                                            $result_fail_status = true;
                                                            $total_mark_obtained += $obtainedMark;
                                                            $result_display = $obtainedMark.'F';
                                                            $obtainedLabMark = '-';
                                                            $total_mark_display = $obtainedMark.'F';
                                                        }else{
                                                            $result_subject_fail_status = false;
                                                            // $result_fail_status = false;
                                                            $total_mark_obtained += $obtainedMark;
                                                            $result_display = $obtainedMark;
                                                            $obtainedLabMark = '-';
                                                            $total_mark_display = $obtainedMark;
                                                        }
                                                    ?>
                                            <tr>
                                                <th>
                                                    <?php echo strtoupper($midTermMarkInfo[$i]->name); ?>
                                                </th>
                                                <th class="text-center table_marks_data"><?php echo $max_mark; ?>
                                                </th>
                                                <th class="text-center table_marks_data">
                                                            <?php echo $min_mark_pass; ?></th>
                                                <?php if($midTermMarkInfo[$i]->lab_status == 'true'){?>
                                                        <th class="text-center table_marks_data">
                                                         <?php echo $lab_Pass_mark; ?></th>
                                                 <?php }else{ ?>
                                                         <th class="text-center table_marks_data">
                                                         <?php echo '-'; ?></th>
                                                 <?php   }  ?>
                                                        
                                                        <th 
                                                            class="text-center table_marks_data">
                                                            <?php echo $result_display; ?></th>
                                                      
                                                        <th class="text-center table_marks_data"><?php echo $obtainedLabMark; ?></th> 
                                                        <?php if($result_subject_fail_status == true){ ?>
                                                        
                                                        <th style="background: #f76a7ebf" class="text-center table_marks_data"><?php echo $total_mark_display; ?></th>
                                                        <?php }else{ ?>
                                                        <th  class="text-center table_marks_data"><?php echo $total_mark_display; ?></th>
                                                        <?php } ?>
                                            </tr>
                                            <?php  } }
                                                       if($total_mark_obtained != 0){
                                                        $total_percentage = ($total_mark_obtained/$total_max_mark)*100; 
                                                        $exam_result = calculateResult($total_mark_obtained);
                                                        ?>
                                            <tr class="text-center table_row_backgrond">
                                                <th class="total_row">Total</th>
                                                <th><?php echo $total_max_mark; ?></th>
                                                <th><?php echo $total_min_mark; ?></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th><?php echo $total_mark_obtained; ?></th>
                                            </tr>

                                            <tr>
                                                <th colspan="4" class="total_row">Percentage:
                                                    <?php echo round($total_percentage,2).'%'; ?></th>
                                                <th colspan="3">Result:
                                                    <?php if($result_fail_status == true){ ?>
                                                    <span class="text_fail"><?php echo 'FAIL'; ?></span>
                                                    <?php } else { ?>
                                                    <span class="text_pass"><?php echo 'PASS'; ?></span>
                                                    <?php } ?>
                                                </th>
                                            </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane fade show active" id="annual_exam" role="tabpanel" aria-labelledby="annual_exam-tab">
                                <h6 class="text-center text-dark mb-1"></h6>

                                <div class="row">
                                    <!-- Marks Table -->
                                    <div class="col-md-6">
                                        <div class="table-responsive-sm">
                                            <table class="table table-bordered mb-0">
                                                <thead class="text-center">
                                                    <tr class="bg-secondary text-white">
                                                        <th colspan = "4">ANNUAL EXAM - MARCH 2025</th>
                                                    </tr>
                                                    <tr class="bg-secondary text-white">
                                                        <th>SUBJECTS</th>
                                                        <th>Max. Marks</th>
                                                        <th>Min. Marks</th>
                                                        <th>Marks Scored</th>
                                                    </tr>
                                                </thead>
                                                <?php 
                                                    $dataPointsPie = array();
                                                    $first_language_total = 0;
                                                    $subject_total = array();
                                                    $subject_name = array();
                                                    $subject_mark = array();
                                                    $second_lang_mark = 0;
                                                    $first_lan_TH = 0;
                                                    $first_lan_IA = 0;
                                                    $subject_code_from_subjects = 0;
                                                    $max_mark = 100;
                                                    $total_max_mark = 0;
                                                    $total_min_mark = 0;
                                                    $all_pass_mark = 35;
                                                    $lang_total = 0;
                                                    foreach($studentsMarks as $mark){
                                                        $total_max_mark += $max_mark;
                                                        $total_min_mark += $all_pass_mark;

                                                        if ($mark->subject_code == 12) {
                                                            $pass_mark = 24;
                                                            $labStatus = false;
                                                        } else if ($mark->lab_status == true) {
                                                            $pass_mark = 21;
                                                        } else {
                                                            $pass_mark = 24;
                                                        }

                                                        $subject_true = false;
                                                        if ($mark->subject_code == '1' || $mark->subject_code == '3') {
                                                            $first_language_total = (int)$mark->obt_theory_mark + (int)$mark->obt_lab_mark;
                                                            if ($mark->obt_theory_mark < $pass_mark) {
                                                                $fail_flag = true;
                                                                $main_fail = true;
                                                            }
                                                            if ($first_language_total < 35) {
                                                                $fail_flag = true;
                                                            }
                                                            $lang_total += $first_language_total;
                                                        } else if ($mark->subject_code == '2') {
                                                            $second_lang_mark = (int)$mark->obt_theory_mark + (int)$mark->obt_lab_mark;
                                                            if ($mark->obt_theory_mark < $pass_mark ) {
                                                                $fail_flag = true;
                                                                $main_fail = true;
                                                            }
                                                            if ($second_lang_mark < 35) {
                                                                $fail_flag = true;
                                                            }
                                                            $lang_total += $second_lang_mark;
                                                        } else {
                                                            $sub_theory_mark = (int)$mark->obt_theory_mark;
                                                            $sub_lab_mark = (int)$mark->obt_lab_mark;
                                                            $sub_total_mark = $sub_theory_mark + $sub_lab_mark;
                                                            $subject_total[] = $sub_total_mark;

                                                            if ($sub_theory_mark < $pass_mark || $sub_total_mark < $all_pass_mark) {
                                                                $fail_flag = true;
                                                                $main_fail = true;
                                                            }
                                                            $total_marks_subjects += $sub_total_mark;
                                                        }
                                                        
                                                        $subject_name[$mark->subject_code] = $mark->subject_name;
                                                        $obt_mark = (int)$mark->obt_theory_mark + (int)$mark->obt_lab_mark;
                                                        $subject_mark[$mark->subject_code] = $obt_mark;
                                                        $subject_percentage = ($obt_mark/$max_mark)*100;
                                                        array_push($dataPointsPie, array("label"=> $mark->subject_name, "y"=> $subject_percentage));
                                                    }
                                                    
                                                    $total_mark = $total_marks_subjects + $first_language_total + $second_lang_mark;
                                                    $total_percentage = ($total_mark/$total_max_mark)*100;

                                                    for($i=0; $i<count($subject_code); $i++){
                                                        $sub_code = $subject_code[$i]; 
                                                        $subject_total[$i] = $subject_mark[$sub_code];
                                                        ?>
                                                        <tr>
                                                            <th><?php echo strtoupper($subject_name[$sub_code]); ?></th>
                                                            <th width="110" class="text-center"><?php echo $max_mark; ?></th>
                                                            <th width="110" class="text-center"><?php echo $all_pass_mark; ?></th>
                                                            <th class="text-center" style="background:#F4F4F4; font-size:17px">
                                                                <?php echo $subject_mark[$sub_code]; ?>
                                                            </th>
                                                        </tr>
                                                    <?php } ?>
                                                <tr class="bg-info text-white">
                                                    <th class="total_row">TOTAL</th>
                                                    <th class="text-center"><?php echo $total_max_mark; ?></th>
                                                    <th class="text-center"><?php echo $total_min_mark; ?></th>
                                                    <th class="text-center" style="font-size:17px"><?php echo $total_mark; ?></th>
                                                </tr>
                                                <?php 
                                                    if($main_fail == true){
                                                        $final_result = 'FAIL';
                                                        $result_class = 'text_fail';
                                                    }else if($fail_flag == true){
                                                        if ($total_mark >= 140) {
                                                            $max_mark_sub  = 400;
                                                            if ($subject_total[2] >= 30 && $subject_total[3] >= 30 && $subject_total[4] >= 30 && $subject_total[5] >= 30) {
                                                                $final_result =  calculateResultAnnual($total_mark, $max_mark_sub);
                                                                    if ($lang_total >= 70) {
                                                                        if ($first_language_total >= 30 && $second_lang_mark >= 30) {
                                                                            $final_result =  calculateResultAnnual($total_mark, $total_max_mark);
                                                                            $result_class = 'text_pass';
                                                                        }else {
                                                                            $final_result = "FAILED";
                                                                            $result_class = 'text_fail';
                                                                        }
                                                                    }
                                                                    else {
                                                                        $final_result = "FAILED";
                                                                        $result_class = 'text_fail';
                                                                    } 
                                
                                                            } else {
                                                                $final_result = "FAILED";
                                                                $result_class = 'text_fail';
                                                            }
                                                        }else{
                                                            $final_result = "FAILED";
                                                            $result_class = 'text_fail';
                                                        }
                                                    }else{
                                                        $final_result = calculateResultAnnual($total_mark, $total_max_mark);
                                                        $result_class = 'text_pass';
                                                    }
                                                ?>
                                                <tr style="font-size: 18px;">
                                                    <th colspan="2" class="total_row">Percentage: <?php echo round($total_percentage,2).'%'; ?></th>
                                                    <th colspan="2">Result: <span class="<?php echo $result_class; ?>"><?php echo $final_result; ?></span></th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Pie Chart -->
                                    <div class="col-md-6">
                                        <div id="chartmark" style="height: 300px; width: 100%;"></div>
                                        <script>
                                            function loadGraph() {
                                                var chart = new CanvasJS.Chart("chartmark", {
                                                    animationEnabled: true,
                                                    title: { text: "Subject Wise Performance" },
                                                    data: [{
                                                        type: "pie",
                                                        startAngle: 240,
                                                        yValueFormatString: "##0.00\"%\"",
                                                        indexLabel: "{label} {y}",
                                                        dataPoints: <?php echo json_encode($dataPointsPie); ?>
                                                    }]
                                                });
                                                chart.render();
                                            }
                                            loadGraph();
                                        </script>
                                    </div>
                                </div>
                            </div>

                                <div class="tab-pane fade " id="first_unit_test" role="tabpanel"
                                    aria-labelledby="first_unit_test-tab">
                                    <div class=" table-responsive">
                                        <table class="table table-bordered">
                                            <thead>

                                                <tr>
                                                    <th colspan="5" class="table_title text-center">I UNIT TEST
                                                        2024-25</th>
                                                </tr>

                                                <tr class="table-success">
                                                    <th class="text-center">SUBJECTS</th>
                                                    <th class="text-center">Max. Marks</th>
                                                    <th class="text-center">Min. Marks</th>
                                                    <th class="text-center">Marks Scored</th>
                                                </tr>
                                            </thead>
                                            <?php 
                                               
                                                    $result_subject_fail_status = false;
                                                    $result_fail_status = false;
                                                    $max_mark = 0;
                                                    $min_mark_pass = 0;
                                                    $total_mark_obtained = 0;
                                                    $total_max_mark = 0;
                                                    $total_min_mark = 0;
                                                 
                                                    for($i=0;$i<count($subject_code);$i++){
                                                        if(strtoupper($firstUnitTestMarkInfo[$i]->sub_name) != ''){ 
                                                        $result_display = "";
                                                        $result_subject_fail_status = false;
                                                        if($firstUnitTestMarkInfo[$i]->lab_status == 'true'){
                                                            $max_mark = 100;
                                                            $min_mark_pass = 35;
                                                        }else{
                                                            $max_mark = 100;
                                                            $min_mark_pass = 35;
                                                        }
                                                        $total_max_mark += $max_mark;
                                                        $total_min_mark += $min_mark_pass;
                                                        $obtainedMark = $firstUnitTestMarkInfo[$i]->obt_theory_mark;
                                                        // $obatained_mark = (float)$obtainedMark * 4;
                                                        $obatained_mark = $obtainedMark;

                                                        if($obtainedMark == 'AB' || $obtainedMark == 'EXEM' || $obtainedMark == 'MP' || $obtainedMark == 'SAT'){
                                                            $result_subject_fail_status = true;
                                                            $result_display = $obtainedMark;
                                                            $result_fail_status = true;
                                                        }else if($min_mark_pass > $obatained_mark){
                                                            $result_subject_fail_status = true;
                                                            $result_fail_status = true;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark .'F';
                                                        }else{
                                                            $result_subject_fail_status = false;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark;
                                                        }
                                                    ?>
                                            <tr>
                                                <th>
                                                    <?php echo strtoupper($firstUnitTestMarkInfo[$i]->sub_name); ?></th>
                                                <th class="text-center table_marks_data"><?php echo $max_mark; ?>
                                                </th>
                                                <th class="text-center table_marks_data">
                                                    <?php echo $min_mark_pass; ?></th>
                                                <?php if($result_subject_fail_status == true){ ?>
                                                <th style="background: #f76a7ebf" class="text-center table_marks_data">
                                                    <?php echo $result_display; ?></th>
                                                <?php }else{ ?>
                                                <th class="text-center table_marks_data">
                                                    <?php echo $result_display; ?></th>
                                                <?php } ?>
                                            </tr>
                                            <?php  } }
                                                       if($total_mark_obtained != 0){
                                                        $total_percentage = ($total_mark_obtained/$total_max_mark)*100; 
                                                        $exam_result = calculateResult($total_mark_obtained);
                                                        ?>
                                            <tr class="text-center table_row_backgrond">
                                                <th class="total_row">Total</th>
                                                <th><?php echo $total_max_mark; ?></th>
                                                <th><?php echo $total_min_mark; ?></th>
                                                <th><?php echo $total_mark_obtained; ?></th>
                                            </tr>

                                            <tr>
                                                <th colspan="2" class="total_row">Percentage:
                                                    <?php echo round($total_percentage,2).'%'; ?></th>
                                                <th colspan="2">Result:
                                                    <?php if($result_fail_status == true){ ?>
                                                    <span class="text_fail"><?php echo 'FAIL'; ?></span>
                                                    <?php } else { ?>
                                                    <span class="text_pass"><?php echo $exam_result; ?></span>
                                                    <?php } ?>
                                                </th>
                                            </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                </div>
                                

                                <div class="tab-pane fade" id="secondTest" role="tabpanel"
                                    aria-labelledby="secondTest-tab">

                                    <h6 class="text-center text-dark mb-1"></h6>

                                    <div class="table-responsive-sm">

                                        <table class="table table-bordered table_info">

                                            <thead class="text-center">

                                                <tr>

                                                    <th colspan="4" class="table_title text-center">II Unit Test
                                                        2019-20</th>

                                                </tr>

                                                <tr class="table_row_backgrond">

                                                    <th>SUBJECTS</th>

                                                    <th>Max. Marks</th>

                                                    <th>Min. Marks</th>

                                                    <th>Marks Scored</th>

                                                </tr>

                                            </thead>

                                            <?php 

                                            $result_subject_fail_status = false;

                                            $result_fail_status = false;

                                            $max_mark = 0;

                                            $min_mark_pass = 0;

                                            $total_mark_obtained = 0;

                                            $total_max_mark = 0;

                                            $total_min_mark = 0;

                                            $total_percentage = 0;

                                            for($i=0;$i<count($subjects_code);$i++){

                                                $result_display = "";

                                                $result_subject_fail_status = false;

                                                if(!empty($SecondUnitTestMarkInfo[$i])){

                                                    if($SecondUnitTestMarkInfo[$i]->lab_status == 'true'){

                                                        $max_mark = 35;

                                                        $min_mark_pass = 12;

                                                    }else{

                                                        $max_mark = 50;

                                                        $min_mark_pass = 18;

                                                    }

                                                    $total_max_mark += $max_mark;

                                                    $total_min_mark += $min_mark_pass;

                                                    $obtainedMark = $SecondUnitTestMarkInfo[$i]->obt_theory_mark;

                                                    if($obtainedMark == 'AB' || $obtainedMark == 'EX' || $obtainedMark == 'MP'){

                                                        $result_subject_fail_status = true;

                                                        $result_display = $obtainedMark;

                                                        $result_fail_status = true;

                                                    }else if($min_mark_pass > $obtainedMark){

                                                        $result_subject_fail_status = true;

                                                        $result_fail_status = true;

                                                        $total_mark_obtained += $obtainedMark;

                                                        $result_display = $obtainedMark .'F';

                                                    }else{

                                                        $result_subject_fail_status = false;

                                                        $total_mark_obtained += $obtainedMark;

                                                        $result_display = $obtainedMark;

                                                    }

                                                }

                                            ?>

                                            <tr>

                                                <th class="text-center">

                                                    <?php echo strtoupper($SecondUnitTestMarkInfo[$i]->name); ?>
                                                </th>

                                                <th class="text-center table_marks_data"><?php echo $max_mark; ?>

                                                </th>

                                                <th class="text-center table_marks_data">

                                                    <?php echo $min_mark_pass; ?></th>

                                                <?php if($result_subject_fail_status == true){ ?>

                                                <th style="background: #f76a7ebf" class="text-center table_marks_data">

                                                    <?php echo $result_display; ?></th>

                                                <?php }else{ ?>

                                                <th class="text-center table_marks_data">

                                                    <?php echo $result_display; ?></th>

                                                <?php } ?>

                                            </tr>

                                            <?php  }

                                               if($total_mark_obtained != 0){

                                                $total_percentage = ($total_mark_obtained/$total_max_mark)*100; ?>

                                            <tr class="text-center table_row_backgrond">

                                                <th class="total_row">Total</th>

                                                <th><?php echo $total_max_mark; ?></th>

                                                <th><?php echo $total_min_mark; ?></th>

                                                <th><?php echo $total_mark_obtained; ?></th>

                                            </tr>



                                            <tr>

                                                <th colspan="2" class="total_row">Percentage:

                                                    <?php echo round($total_percentage,2).'%'; ?></th>

                                                <th colspan="2">Result:

                                                    <?php if($result_fail_status == true){ ?>

                                                    <span class="text_fail"><?php echo 'FAIL'; ?></span>

                                                    <?php } else { ?>

                                                    <span class="text_pass"><?php echo 'PASS'; ?></span>

                                                    <?php } ?>
                                                </th>

                                            </tr>

                                            <?php } ?>

                                        </table>

                                    </div>

                                </div>

                                <?php if($term_name == 'II PUC'){ ?>

                                <!-- <div class="tab-pane fade show " id="firstPreparatory" role="tabpanel"
                                aria-labelledby="firstPreparatory-tab">

                                <div class="table-responsive">

                                    <table class="table table-bordered table_info">

                                        <thead class="text-center">

                                            <tr>

                                                <th colspan="4" class="table_title text-center">Preparatory Exam
                                                    2021</th>

                                            </tr>

                                            <tr class="table_row_backgrond">

                                                <th>SUBJECTS</th>

                                                <th>Max. Marks</th>

                                                <th>Min. Marks</th>

                                                <th>Marks Scored</th>

                                            </tr>

                                        </thead>

                                        <?php 

                                            $result_subject_fail_status = false;

                                            $result_fail_status = false;

                                            $max_mark = 0;

                                            $min_mark_pass = 0;

                                            $total_mark_obtained = 0;

                                            $total_max_mark = 0;

                                            $total_min_mark = 0;

                                            $total_percentage = 0;

                                            for($i=0;$i<count($subjects_code);$i++){

                                                $result_display = "";

                                                $result_subject_fail_status = false;

                                                if(!empty($firstPreparatoryMarkInfo[$i])){

                                                    

                                                if($firstPreparatoryMarkInfo[$i]->lab_status == 'true'){

                                                    $max_mark = 70;

                                                    $min_mark_pass = 24;

                                                }else{

                                                    $max_mark = 100;

                                                    $min_mark_pass = 35;

                                                }

                                                $total_max_mark += $max_mark;

                                                $total_min_mark += $min_mark_pass;

                                                $obtainedMark = $firstPreparatoryMarkInfo[$i]->obt_theory_mark;

                                                    if($obtainedMark == 'AB' || $obtainedMark == 'EX' || $obtainedMark == 'MP'){

                                                        $result_subject_fail_status = true;

                                                        $result_display = $obtainedMark;

                                                        $result_fail_status = true;

                                                    }else if($min_mark_pass > $obtainedMark){

                                                        $result_subject_fail_status = true;

                                                        $result_fail_status = true;

                                                        $total_mark_obtained += $obtainedMark;

                                                        $result_display = $obtainedMark.'F';

                                                    }else{

                                                        $result_subject_fail_status = false;

                                                        $total_mark_obtained += $obtainedMark;

                                                        $result_display = $obtainedMark;

                                                    }

                                            ?>

                                        <tr>

                                            <th class="text-center">

                                                <?php echo strtoupper($firstPreparatoryMarkInfo[$i]->name); ?>
                                            </th>

                                            <th class="text-center table_marks_data"><?php echo $max_mark; ?>

                                            </th>

                                            <th class="text-center table_marks_data">

                                                <?php echo $min_mark_pass; ?></th>

                                            <?php if($result_subject_fail_status == true){ ?>

                                            <th style="background: #f76a7ebf"
                                                class="text-center table_marks_data">

                                                <?php echo $result_display; ?></th>

                                            <?php }else{ ?>

                                            <th class="text-center table_marks_data">

                                                <?php echo $result_display; ?></th>

                                            <?php } ?>

                                        </tr>

                                        <?php  } }

                                        if($total_mark_obtained != 0){

                                            $total_percentage = ($total_mark_obtained/$total_max_mark)*100; ?>

                                        <tr class="text-center table_row_backgrond">

                                            <th class="total_row">Total</th>

                                            <th><?php echo $total_max_mark; ?></th>

                                            <th><?php echo $total_min_mark; ?></th>

                                            <th><?php echo $total_mark_obtained; ?></th>

                                        </tr>



                                        <tr>

                                            <th colspan="2" class="total_row">Percentage:

                                                <?php echo round($total_percentage,2).'%'; ?></th>

                                            <th colspan="2">Result:

                                                <?php if($result_fail_status == true){ ?>

                                                <span class="text_fail"><?php echo 'FAIL'; ?></span>

                                                <?php } else { ?>

                                                <span class="text_pass"><?php echo 'PASS'; ?></span>

                                                <?php } ?>
                                            </th>

                                        </tr>

                                        <?php } ?>



                                    </table>

                                </div>

                            </div> -->

                                <?php } ?>



                                <!-- <div class="tab-pane" id="final_exam" role="tabpanel"
                                aria-labelledby="final_exam-tab">

                                <div class="table-responsive">

                                    <table class="table table-bordered table_info">

                                        <thead class="text-center">

                                            <tr>

                                                <th colspan="4" class="table_title text-center">Final Exam 2021
                                                </th>

                                            </tr>

                                            <tr class="table_row_backgrond">

                                                <th>SUBJECTS</th>

                                                <th>Max. Marks</th>

                                                <th>Min. Marks</th>

                                                <th>Marks Scored</th>

                                            </tr>

                                        </thead>

                                        <?php 

                                            $result_subject_fail_status = false;

                                            $result_fail_status = false;

                                            $max_mark = 0;

                                            $min_mark_pass = 0;

                                            $total_mark_obtained = 0;

                                            $total_max_mark = 0;

                                            $total_min_mark = 0;

                                            $total_percentage = 0;

                                            $totalTheoryMark = 0;

                                            $totalLabMark = 0;

                                            for($i=0;$i<count($subjects_code);$i++){

                                                $result_display = "";

                                                $result_subject_fail_status = false;

                                                $subjectInfo = getSubjectInfo($con,$subjects_code[$i]);

                                                //if(!empty($assignmentExamMarks[$subjects_code[$i]])){

                                                    

                                                    

                                                    if($subjects_code[$i] == 12){

                                                        $labStatus = 'true';

                                                    }else{

                                                        $labStatus = $subjectInfo['lab_status'];

                                                    }

                                                    if($labStatus == 'true'){

                                                        if($subjects_code[$i] == 12){

                                                            $pass_mark_theory = 25;

                                                            $pass_mark_lab = 10;

                                                            $lab_assessment = 10;

                                                        }else{

                                                            $pass_mark_theory = 21;

                                                            $pass_mark_lab = 14;

                                                            $lab_assessment = 16;

                                                        }

                                                    }else{

                                                        $pass_mark_theory = 35;

                                                        $pass_mark_lab = 0;

                                                        $lab_assessment = 0;

                                                    }

                                                   

                                                    

                                                    if($student_id == '20P5965' || $student_id == '20P4140' || $student_id == '20P1754'){

                                                        $internal_assessment = 1;

                                                    }else{

                                                        $internal_assessment = 5;

                                                    }

                                                    $max_mark = 100;

                                                        $min_mark_pass = 35;

                                                    

                                                    $totalTheoryMark = $assignmentExamMarks[$subjects_code[$i]] + $pass_mark_theory + $internal_assessment + $lab_assessment + $pass_mark_lab; 

                                                  



                                                // if($assignmentExamMarks[$i]->lab_status == 'true'){

                                                //     $max_mark = 70;

                                                //     $min_mark_pass = 24;

                                                // }else{

                                                //     $max_mark = 100;

                                                //     $min_mark_pass = 35;

                                                // }

                                                // $total_max_mark += $max_mark;

                                                // $total_min_mark += $min_mark_pass;

                                                // $obtainedMark = $totalTheoryMark;

                                                //     $total_mark_obtained += $totalTheoryMark;

                                                    // if($obtainedMark == 'AB' || $obtainedMark == 'EX' || $obtainedMark == 'MP'){

                                                    //     $result_subject_fail_status = true;

                                                    //     $result_display = $obtainedMark;

                                                    //     $result_fail_status = true;

                                                    // }else if($min_mark_pass > $obtainedMark){

                                                    //     $result_subject_fail_status = true;

                                                    //     $result_fail_status = true;

                                                    //     $total_mark_obtained += $obtainedMark;

                                                    //     $result_display = $obtainedMark.'F';

                                                    // }else{

                                                    //     $result_subject_fail_status = false;

                                                    //     $total_mark_obtained += $obtainedMark;

                                                    //     $result_display = $obtainedMark;

                                                    // }

                                            ?>

                                        <tr>

                                            <th class="text-center">

                                                <?php echo strtoupper($subjectInfo['name']); ?></th>

                                            <th class="text-center table_marks_data"><?php echo $max_mark; ?>

                                            </th>

                                            <th class="text-center table_marks_data">

                                                <?php echo $min_mark_pass; ?></th>

                                            <?php //if($result_subject_fail_status == true){   style="background: #f76a7ebf"?>

                                            <th class="text-center table_marks_data">

                                                <?php echo $totalTheoryMark; ?></th>

                                            <?php//}else{ ?>

                                         <th class="text-center table_marks_data">

                                                <?php echo $result_display; ?></th> -->

                                <?php //} ?>

                                <!-- </tr> -->

                                <?php  //} 

                                        }

                                        if($total_mark_obtained != 0){

                                            $total_percentage = ($total_mark_obtained/$total_max_mark)*100; ?>

                                <tr class="text-center table_row_backgrond">

                                    <th class="total_row">Total</th>

                                    <th><?php echo $total_max_mark; ?></th>

                                    <th><?php echo $total_min_mark; ?></th>

                                    <th><?php echo $total_mark_obtained; ?></th>

                                </tr>



                                <tr>

                                    <th colspan="2" class="total_row">Percentage :

                                        <?php echo round($total_percentage,2).'%'; ?></th>

                                    <th colspan="2">Result:

                                        <?php if($result_fail_status == true){ ?>

                                        <span class="text_fail"><?php echo 'FAIL'; ?></span>

                                        <?php } else { ?>

                                        <span class="text_pass"><?php echo 'PASS'; ?></span>

                                        <?php } ?>
                                    </th>

                                </tr>

                                <?php } ?>



                                </table>

                            </div>

                        </div>
                        </div>
            </div>

        </div>

    </div>

    </li>

    </ul>

    </div>

    </div>

    </div>

    <?php
function getSubjectInfo($con, $subject_id)
{
  $query = "SELECT * FROM tbl_subjects as sub
    WHERE sub.subject_code = '$subject_id' AND sub.is_deleted = 0";
  $pdo_statement = $con->prepare($query);
  $pdo_statement->execute();
  return $pdo_statement->fetch();
}
function getStudentFinalMarks($con, $student_id, $subjects_code, $exam_type)
{
  $query = "SELECT * FROM tbl_college_internal_exam_marks as exam
  WHERE exam.student_id = '$student_id' AND exam.subject_code = '$subjects_code'  AND exam.exam_year = '2024-25'
  AND exam.exam_type = '$exam_type' AND exam.is_deleted = 0";
  $pdo_statement = $con->prepare($query);
  $pdo_statement->execute();
  return $pdo_statement->fetch();
}

 function getSubjectCodes($stream_name){
    //science
    $PCMB = array("33", "34", "35", '36');
    $PCMC = array("33", "34", "35", '41');
    $PCME = array("33", "34", "35", '40');
    $PCMS = array("33", "34", "35", '31');
    //commarce
    $BEBA = array("75", "22", "27", '30');
    $BSBA = array("75", "31", "27", '30');
    $CSBA = array("41", "31", "27", '30');
    $SEBA = array("31", "22", "27", '30');
    $CEBA = array("41", "22", "27", '30');
    $PEBA = array("29", "22", "27", '30');
    //art
    $HEPP = array("21", "22", "32", '29');
    $MEBA = array("75", "22", "27", '30');
    $MSBA = array("75", "31", "27", '30');
    $HEPS = array("21", "22", "29", '28');
    $EBAC = array("22", "27", "30", '41');
    $HEBA = array("21", "22", "27", '30');

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
        case "EBAC":
            return $EBAC;
            break;
        case "HEBA":
            return $HEBA;
            break;
    }
}

function calculateResultAll($percentage, $total_subjects, $elective)
{
  if ($elective > 1) {
    $percentage = floor(($percentage / 500) * 100);
  } else {
    $percentage = floor(($percentage / 600) * 100);
  }

  if ($percentage >= 85) {
    return "Distinction";
  } else if ($percentage >= 60 && $percentage <= 84) {
    return "First Class";
  } else if ($percentage >= 50 && $percentage <= 59) {
    return "Second Class";
  } else if ($percentage >= 35 && $percentage <= 49) {
    return "Third Class";
  }
}

function getMarksBySecondLang($result)
{
  foreach ($result as $row) {
    if ($row["subject_code"] == '02') {
      return $total_mark_lang_II = $row["obt_theory_mark"];
    }
  }
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
function getTheoryTotal($result, $subjects)
{
  $theory_total = 0;
  foreach ($result as $row) {
    for ($i = 0; $i < 4; $i++) {
      if ($row["subject_code"] == $subjects[$i]) {
        $theory_total += (int)$row["obt_theory_mark"];
      }
    }
  }
  return $theory_total;
}
function getLabTotal($result, $subjects)
{
  $lab_total = 0;
  foreach ($result as $row) {
    for ($i = 0; $i < 4; $i++) {
      if ($row["subject_code"] == $subjects[$i]) {
        $lab_total += (int)$row["obt_lab_mark"];
      }
    }
  }
  return $lab_total;
}


function calculateResult($total_marks){
    $percentage = floor(($total_marks / 600) * 100);
    if($percentage >= 85){
        return "Distinction";
    } else if($percentage >= 60 && $percentage <= 84){
        return "I Class";
    } else if($percentage >= 50 && $percentage <= 59){
        return "II Class";
    } else if($percentage >= 35 && $percentage <= 49){
        return "III Class";
    }
}


function calculateResultAnnual($total_marks, $max_mak)
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
    $res .= convert_number($Gn) .  "Million";
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
    $res = "Zero";
  }
  return $res;
}
?>