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

     $weekname = array('MONDAY','TUESDAY','WEDNESDAY','THURSDAY','FRIDAY','SATURDAY');

    ?>
   
   <div class="row form-employee">

        <div class="col-12 padding_left_right_null">

            <div class="card card-small c-border p-2">

                <table class="table table-responsive table-bordered table_timeTable">

                    <tr class="time_table_heading text-center">

                        <th class="pb-0">Week Name</th>

                        <?php

                    

                        foreach($classTimings as $time)

                        { 
                         if($time->week_row_id != 6) {

                        ?>

                        <th class="pb-0"><?php echo $time->start_time; ?> - <?php echo $time->end_time; ?></th>

                        <?php } }?>



                    </tr>

                    <?php for($i=0;$i<=4;$i++) {

                        

                        $subjects = array();

                        $staff_name = array();

                        $sub_type = array();

                    ?>

                    <tr>

                        <td><?php echo $weekname[$i]; ?></td>

                        <?php 

                            for($l=0;$l<=4;$l++){

                                $subjects[$l] = "";

                                $staff_name[$l] = "";

                                $sub_type[$l] = "";

                            }

                            foreach($timetableInfo as $time){

                               

                                if($weekname[$i] == strtoupper($time->week_name)){ 

                                    if($time->time_row_id == 1){

                                        // log_message('debug','VVV'.$time->time_row_id);

                                        if($time->sub_type == 'LANGUAGE'){

                                            $subjects[0] .= strtoupper($time->sub_name).',';

                                            $staff_name[0] .= $time->staff_name.',';

                                            $sub_type[0] .= $time->subject_type.',';

                                        }else{

                                            $subjects[0] .= strtoupper($time->sub_name);

                                            $staff_name[0] .= $time->staff_name;

                                            $sub_type[0] .= $time->subject_type;

                                        }

                                    }  

                                    if($time->time_row_id == 2){

                                        if($time->sub_type == 'LANGUAGE'){

                                            $subjects[1] .= strtoupper($time->sub_name).',';

                                            $staff_name[1] .= $time->staff_name.',';

                                            $sub_type[1] .= $time->subject_type.',';

                                        }else{

                                            $subjects[1] .= strtoupper($time->sub_name);

                                            $staff_name[1] .= $time->staff_name;

                                            $sub_type[1] .= $time->subject_type;

                                        }

                                    }  

                                    if($time->time_row_id == 3){

                                        if($time->sub_type == 'LANGUAGE'){

                                            $subjects[2] .= strtoupper($time->sub_name).',';

                                            $staff_name[2] .= $time->staff_name.',';

                                            $sub_type[2] .= $time->subject_type.',';

                                        }else{

                                            $subjects[2] .= strtoupper($time->sub_name);

                                            $staff_name[2] .= $time->staff_name;

                                            $sub_type[2] .= $time->subject_type;

                                        }

                                    }  

                                    if($time->time_row_id == 4){

                                        if($time->sub_type == 'LANGUAGE'){

                                            $subjects[3] .= strtoupper($time->sub_name).',';

                                            $staff_name[3] .= $time->staff_name.',';

                                            $sub_type[3] .= $time->subject_type.',';

                                        }else{

                                            $subjects[3] .= strtoupper($time->sub_name);

                                            $staff_name[3] .= $time->staff_name;

                                            $sub_type[3] .= $time->subject_type;

                                        }

                                    }  

                                    if($time->time_row_id == 5){

                                        if($time->sub_type == 'LANGUAGE'){

                                            $subjects[4] .= strtoupper($time->sub_name).',';

                                            $staff_name[4] .= $time->staff_name.',';

                                            $sub_type[4] .= $time->subject_type.',';

                                        }else{

                                            $subjects[4] .= strtoupper($time->sub_name);

                                            $staff_name[4] .= $time->staff_name;

                                            $sub_type[4] .= $time->subject_type;

                                        }

                                    }  

                                    if($time->time_row_id == 6){

                                        if($time->sub_type == 'LANGUAGE'){

                                            $subjects[5] .= strtoupper($time->sub_name).',';

                                            $staff_name[5] .= $time->staff_name.',';

                                            $sub_type[5] .= $time->subject_type.',';

                                        }else{

                                            $subjects[5] .= strtoupper($time->sub_name);

                                            $staff_name[5] .= $time->staff_name;

                                            $sub_type[5] .= $time->subject_type;

                                        }

                                    }  

                                    if($time->time_row_id == 7){

                                        if($time->sub_type == 'LANGUAGE'){

                                            $subjects[6] .= strtoupper($time->sub_name).',';

                                            $staff_name[6] .= $time->staff_name.',';

                                            $sub_type[6] .= $time->subject_type.',';

                                        }else{

                                            $subjects[6] .= strtoupper($time->sub_name);

                                            $staff_name[6] .= $time->staff_name;

                                            $sub_type[6] .= $time->subject_type;

                                        }

                                    }  

                                    if($time->time_row_id == 8){

                                        if($time->sub_type == 'LANGUAGE'){

                                            $subjects[7] .= strtoupper($time->sub_name).',';

                                            $staff_name[7] .= $time->staff_name.',';

                                            $sub_type[7] .= $time->subject_type.',';

                                        }else{

                                            $subjects[7] .= strtoupper($time->sub_name);

                                            $staff_name[7] .= $time->staff_name;

                                            $sub_type[7] .= $time->subject_type;

                                        }

                                    }  

                                } 

                                 } 

                                        for($s=0;$s<=7;$s++){

                                            echo '<td><span style="color:#115bb3;">'.$subjects[$s].'</span><br>'.$staff_name[$s].'<br><span style="color:#4db309;">'.$sub_type[$s].'</span></td>';

                                        }   

                                    ?>

                                            </tr>


                                            <?php } ?>

                                            <tr class="time_table_heading text-center">

                                                <th class="pb-0">Week Name</th>

                                                <?php



                                            foreach($timingsInfo as $time)

                                            { 
                                            //  if($time->week_row_id != 6) {

                                            ?>

                                                <th class="pb-0"><?php echo $time->start_time; ?> - <?php echo $time->end_time; ?></th>

                                                <?php } //}?>


                                            </tr>
                                            <?php for($i=0;$i<1;$i++) {

                                                

                                            $subjects1 = array();

                                            $staff_name1 = array();

                                            $sub_type1 = array();

                                        ?>

                                            <tr>
                                                <?php
                                        // foreach($timingsInfo as $time)
                                        // { 
                                            //  if($time->week_row_id != 6) {

                                            ?>

                                                <td>SATURDAY</td>
                                                <?php// } //}?>
                                                <?php 

                                                for($l=0;$l<1;$l++){

                                                    $subjects1[$l] = "";

                                                    $staff_name1[$l] = "";

                                                    $sub_type1[$l] = "";

                                                }

                                                    foreach($timingsInfo as $time1){

                                                foreach($timetableInfo as $time){
                                                

                                                    if($time1->row_id == $time->time_row_id){ 

                                                        if($time1->row_id == 9){

                                                            // log_message('debug','VVV'.$time->time_row_id);

                                                            if($time->sub_type == 'LANGUAGE'){

                                                                $subjects1[0] .= strtoupper($time->sub_name).',';

                                                                $staff_name1[0] .= $time->staff_name.',';

                                                                $sub_type1[0] .= $time->subject_type.',';

                                                            }else{

                                                                $subjects1[0] .= strtoupper($time->sub_name);

                                                                $staff_name1[0] .= $time->staff_name;

                                                                $sub_type1[0] .= $time->subject_type;

                                                            }

                                                        }  

                                                        if($time1->row_id == 10){

                                                            // log_message('debug','VVV'.$time->time_row_id);

                                                            if($time->sub_type == 'LANGUAGE'){

                                                                $subjects1[1] .= strtoupper($time->sub_name).',';

                                                                $staff_name1[1] .= $time->staff_name.',';

                                                                $sub_type1[1] .= $time->subject_type.',';

                                                            }else{

                                                                $subjects1[1] .= strtoupper($time->sub_name);

                                                                $staff_name1[1] .= $time->staff_name;

                                                                $sub_type1[1] .= $time->subject_type;

                                                            }

                                                        }  

                                                        if($time1->row_id == 11){

                                                            // log_message('debug','VVV'.$time->time_row_id);

                                                            if($time->sub_type == 'LANGUAGE'){

                                                                $subjects1[2] .= strtoupper($time->sub_name).',';

                                                                $staff_name1[2] .= $time->staff_name.',';

                                                                $sub_type1[2] .= $time->subject_type.',';

                                                            }else{

                                                                $subjects1[2] .= strtoupper($time->sub_name);

                                                                $staff_name1[2] .= $time->staff_name;

                                                                $sub_type1[2] .= $time->subject_type;

                                                            }

                                                        }  
                                            
                                                        if($time1->row_id == 12){

                                                            // log_message('debug','VVV'.$time->time_row_id);

                                                            if($time->sub_type == 'LANGUAGE'){

                                                                $subjects1[3] .= strtoupper($time->sub_name).',';

                                                                $staff_name1[3] .= $time->staff_name.',';

                                                                $sub_type1[3] .= $time->subject_type.',';

                                                            }else{

                                                                $subjects1[3] .= strtoupper($time->sub_name);

                                                                $staff_name1[3] .= $time->staff_name;

                                                                $sub_type1[3] .= $time->subject_type;

                                                            }

                                                        }  

                                                        // if($time->time_row_id == 2){

                                                        //     if($time->sub_type == 'LANGUAGE'){

                                                        //         $subjects[1] .= strtoupper($time->sub_name).',';

                                                        //         $staff_name[1] .= $time->staff_name.',';

                                                        //         $sub_type[1] .= $time->subject_type.',';

                                                        //     }else{

                                                        //         $subjects[1] .= strtoupper($time->sub_name);

                                                        //         $staff_name[1] .= $time->staff_name;

                                                        //         $sub_type[1] .= $time->subject_type;

                                                        //     }

                                                        // }  

                                                        // if($time->time_row_id == 3){

                                                        //     if($time->sub_type == 'LANGUAGE'){

                                                        //         $subjects[2] .= strtoupper($time->sub_name).',';

                                                        //         $staff_name[2] .= $time->staff_name.',';

                                                        //         $sub_type[2] .= $time->subject_type.',';

                                                        //     }else{

                                                        //         $subjects[2] .= strtoupper($time->sub_name);

                                                        //         $staff_name[2] .= $time->staff_name;

                                                        //         $sub_type[2] .= $time->subject_type;

                                                        //     }

                                                        // }  

                                                        // if($time->time_row_id == 4){

                                                        //     if($time->sub_type == 'LANGUAGE'){

                                                        //         $subjects[3] .= strtoupper($time->sub_name).',';

                                                        //         $staff_name[3] .= $time->staff_name.',';

                                                        //         $sub_type[3] .= $time->subject_type.',';

                                                        //     }else{

                                                        //         $subjects[3] .= strtoupper($time->sub_name);

                                                        //         $staff_name[3] .= $time->staff_name;

                                                        //         $sub_type[3] .= $time->subject_type;

                                                        //     }

                                                        // }  

                                                        // if($time->time_row_id == 5){

                                                        //     if($time->sub_type == 'LANGUAGE'){

                                                        //         $subjects[4] .= strtoupper($time->sub_name).',';

                                                        //         $staff_name[4] .= $time->staff_name.',';

                                                        //         $sub_type[4] .= $time->subject_type.',';

                                                        //     }else{

                                                        //         $subjects[4] .= strtoupper($time->sub_name);

                                                        //         $staff_name[4] .= $time->staff_name;

                                                        //         $sub_type[4] .= $time->subject_type;

                                                        //     }

                                                        // }  

                                                    

                                                    

                                                    

                                                    } 

                                                }

                                                } 

                                                for($s=0;$s<=3;$s++){

                                                    echo '<td><span style="color:#115bb3;">'.$subjects1[$s].'</span><br>'.$staff_name1[$s].'<br><span style="color:#4db309;">'.$sub_type1[$s].'</span></td>';

                                                }   

                                            ?>

                    </tr>


                    <?php } ?>

                </table>

            </div>

        </div>

    </div>


    </div>