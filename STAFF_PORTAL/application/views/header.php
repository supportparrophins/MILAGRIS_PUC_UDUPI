<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#317EFB"/>
    <title><?php echo $pageTitle; ?></title>
    <link rel="icon" href="<?php echo base_url(); ?><?php echo INSTITUTION_LOGO; ?>">    
    <link rel="apple-touch-icon" href="<?php echo base_url(); ?><?php echo INSTITUTION_LOGO; ?>">
    <link rel="stylesheet"
        href="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" />
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.0.0"
        href="<?php echo base_url(); ?>assets/dist/styles/shards-dashboards.1.0.0.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/styles/extras.1.0.0.min.css">

    <link href="<?php echo base_url(); ?>assets/dist/css/style.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet"
        type="text/css" />
    <!-- Auto select box-->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <!--data-table-->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" />
    <link href="https://unpkg.com/material-components-web@6.0.0/dist/material-components-web.min.css" rel="stylesheet">
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
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="https://unpkg.com/material-components-web@6.0.0/dist/material-components-web.min.js"></script>
    
    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-app.js"></script>

    <script src="https://www.gstatic.com/firebasejs/8.1.1/firebase-messaging.js"></script>

    <!-- Initializing Firebase -->
     <script src="<?php echo base_url();?>assets/notification/initialize_firebase.js"></script>
    
    <!-- Setting notification count -->
    <script src="<?php echo base_url();?>assets/notification/notification-counter.js"></script>

    <!-- Receiving token from FCM server -->
    <script src="<?php echo base_url();?>assets/notification/fcm-push-notification.js"></script>

    <!-- Handle incoming messages -->
    <script src="<?php echo base_url();?>assets/notification/handle_message.js"></script>
    <script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";
        function showLoader(){
            $(".custom_loader").addClass('active');
            $("#custom_loader_text").css('display','block');
        }
        function hideLoader(){
            $(".custom_loader").removeClass('active');
            $("#custom_loader_text").css('display','none');
        }
    </script>
    <script>
        $(document).ready(()=>{           
            $("form").submit(()=>{
                showLoader();
            });
            $("li.nav-item > .nav-link[href*='<?=base_url()?>']").on('click',function(){
                showLoader();
            });
        });
    </script>
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
            background-color: rgba(0,0,0,0.3);
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
    <script>
        const channel = new BroadcastChannel('sw-messages');
        navigator.serviceWorker.addEventListener('message', event => {
            incrementNotificationCounter("<?=$this->session->userdata ('staff_id')?>",event.data.notification,event.data.data["gcm.notification.user_type"],"<?=$role?>","<?=ROLE_PRINCIPAL?>");
        });

        channel.addEventListener('message', event => {
            incrementNotificationCounter("<?=$this->session->userdata ('staff_id')?>",event.data.body,event.data.user_type["gcm.notification.user_type"],"<?=$role?>","<?=ROLE_PRINCIPAL?>");
        });

        window.onload = ()=>{  
            setInitialNotificationCounter("<?=$this->session->userdata ('staff_id')?>");
        }
    </script>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue sidebar-mini" style="overflow-x: hidden;">
    <div class="custom_loader"><span id="custom_loader_text" style="color:blue;font-weight:bold;margin-left: -100%;font-size: 17px;display:none;">Loading...</span></div>

    <!-- Main Sidebar -->
    <aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
        <div class="main-navbar">
            <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
                <a class="navbar-brand w-100 mr-0 pt-1" href="#" style="line-height: 25px;">
                    <div class="d-table m-auto mobile_display_none">
                        <img id="main-logo" class="d-inline-block mr-1" style="max-width: 50px;"
                            src="<?php echo base_url(); ?>assets/dist/img/dolphin_logo.png" alt="logo">
                        <h5 class="d-none d-md-inline title_sidenav"><span class="title_green">School</span><span
                                class="title_blue">Phins</span>
                        </h5>
                        <!-- mobile view -->
                    </div>
                    <div class="m-auto sidebar_mobile_view">
                        <img id="main-logo" class="d-inline-block logo_mobile_view mr-0 rounded"
                            style="max-width: 53px;" src="<?php echo base_url(); ?><?php echo INSTITUTION_LOGO; ?>"
                            alt="logo">
                        <h4 class="d-md-inline title_mobile_view"><?php echo SUB_TITLE; ?></h4>
                    </div>
                </a>
                <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                    <i class="material-icons">&#xE5C4;</i>
                </a>
            </nav>
        </div>
        <!-- <div class="main-sidebar__search w-100 border-right d-sm-flex d-md-none d-lg-none">
            
          </div> -->
        <div class="nav-wrapper">
            <ul class="nav flex-column">

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url(); ?>dashboard">
                        <i class="fas fa-tachometer-alt header_icons"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <?php if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_VICE_PRINCIPAL || $role == ROLE_OFFICE) { ?>
                <li class="nav-item">
                    <a class="nav-link " href="<?php echo base_url(); ?>staffDetails">
                        <i class="fas fa-chalkboard-teacher header_icons"></i>
                        <span>Staff</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="#student_link" data-toggle="collapse" aria-expanded="false" class="nav-link  dropdown-toggle">
                        <i class="material-icons">group</i>
                        <span>Student</span>
                    </a>
                    <ul class="collapse list-unstyled ml-3" id="student_link">
                        <li class="nav-item">
                            <a class="nav-link " href="<?php echo base_url(); ?>studentDetails">
                                <i class="material-icons">group</i>
                                <span>Student</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>studentRegisterListing">
                                <i class="material-icons">language</i>
                                <span>Portal Registration</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <?php }
                if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE) { ?>
                
                <li class="nav-item">
                    <a href="#timeTable" data-toggle="collapse" aria-expanded="false" class="nav-link  dropdown-toggle">
                        <i class="material-icons">access_time</i>
                        <span>Time Table</span>
                    </a>
                    <ul class="collapse list-unstyled ml-3" id="timeTable">
                        <li class="nav-item">
                            <a class="nav-link " href="<?php echo base_url(); ?>timeTableDetails">
                                <i class="material-icons">access_time</i>
                                <span>Time Table</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="<?php echo base_url(); ?>classStreamDetails">
                                <i class="material-icons">book</i>
                                <span>Class And Stream</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link " href="<?php echo base_url(); ?>subjectDetails">
                        <i class="material-icons">book</i>
                        <span>Subjects</span>
                    </a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link " href="<?php echo base_url(); ?>electionDetails">
                        <i class="material-icons">poll</i>
                        <span>Election</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="<?php echo base_url(); ?>enquiryListing">
                    <i class="fas fa-phone-square-alt header_icons"></i>
                        <span>Admission Enquiry</span>
                    </a>
                </li>


                <?php }
                if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE || $role == ROLE_VICE_PRINCIPAL) { ?>
                <li class="nav-item">
                    <a href="#admission" data-toggle="collapse" aria-expanded="false" class="nav-link  dropdown-toggle">
                        <i class="material-icons">group</i>
                        <span>Admission -2021</span>
                    </a>
                    <ul class="collapse list-unstyled ml-3" id="admission">

                    <li class="nav-item">
                            <a class="nav-link " href="<?php echo base_url(); ?>admissionDashboard">
                                <i class="fas fa-tachometer-alt header_icons"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="<?php echo base_url(); ?>getAdmissionRegisteredStudent">
                            <i class="material-icons">description</i>
                                <span> Registered Student</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="<?php echo base_url(); ?>getAdmissionPaymentPeningApplication">
                            <i class="material-icons">description</i>
                                <span> Payment Pending Application Stack</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="<?php echo base_url(); ?>getAllApplicationFeePaidInfo">
                            <i class="material-icons">description</i>
                                <span>Application Fee Paid</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="<?php echo base_url(); ?>getAllApplicationInfo">
                            <i class="material-icons">description</i>
                                <span> Application Stack</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="<?php echo base_url(); ?>newAdmission">
                                <i class="material-icons">description</i>
                                <span>Approved Application</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="<?php echo base_url(); ?>getRejectedApplicationInfo">
                                <i class="material-icons">description</i>
                                <span>Rejected Application</span>
                            </a>
                        </li>
                   
                    </ul>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link " href="<?php echo base_url(); ?>reportDashboard">
                        <i class="material-icons">description</i>
                        <span>Report</span>
                    </a>
                </li>


                <?php } ?>

                <?php if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR) { ?>
                <li class="nav-item">
                    <a class="nav-link " href="<?php echo base_url(); ?>suggestionListing">
                        <i class="material-icons">chat</i>
                        <span>Student Suggestion</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#sms_items" data-toggle="collapse" aria-expanded="false" class="nav-link  dropdown-toggle">
                        <i class="material-icons">chat</i>
                        <span>SMS</span>
                    </a>
                    <ul class="collapse list-unstyled ml-3" id="sms_items">
                        <li class="nav-item">
                            <a class="nav-link " href="<?php echo base_url(); ?>viewSMSPortal">
                                <i class="material-icons">send</i>
                                <span>Send SMS</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>openSMSSentReport">
                                <i class="material-icons">insert_drive_file</i>
                                <span>Sent Report</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#notification_items" data-toggle="collapse" aria-expanded="false" class="nav-link  dropdown-toggle">
                        <i class="material-icons">chat</i>
                        <span>Notification</span>
                    </a>
                    <ul class="collapse list-unstyled ml-3" id="notification_items">
                        <li class="nav-item">
                            <a class="nav-link " href="<?php echo base_url(); ?>pushNotification">
                                <i class="material-icons">send</i>
                                <span>Send</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>staffNotifications">
                                <i class="material-icons">account_box</i>
                                <span>Staff</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>studentNotifications">
                                <i class="material-icons">supervisor_account</i>
                                <span>Student</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php } ?>
                <?php if($role == ROLE_TEACHING_STAFF){  ?>
                    <li class="nav-item">
                        <a class="nav-link " href="<?php echo base_url(); ?>timeTableDetails">
                            <i class="material-icons">access_time</i>
                            <span>Time Table</span>
                        </a>
                    </li>
                <?php } ?>

                <?php if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_MANAGER){ ?>
                    <li class="nav-item">
                        <a href="#fee" data-toggle="collapse" aria-expanded="false" class="nav-link  dropdown-toggle">
                            <i class="material-icons">description</i>
                            <span>Fee</span>
                        </a>
                        <ul class="collapse list-unstyled ml-3" id="fee">
                            <li class="nav-item">
                                <a class="nav-link " href="<?php echo base_url(); ?>feePayNow">
                                    <i class="fas fa-money-bill-alt"></i>
                                    <span>Pay Now</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="<?php echo base_url(); ?>onlineFeePaidInfo">
                                    <i class="fas fa-money-bill-alt"></i>
                                    <span>Fee Paid Info</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="<?php echo base_url(); ?>viewFeeStructure">
                                    <i class="material-icons">description</i>
                                    <span>Fee Structure</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link " href="<?php echo base_url(); ?>viewAccount">
                                    <i class="fas fa-landmark header_icons"></i>
                                    <span>Bank Account</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link " href="<?php echo base_url(); ?>viewFeeConcession">
                                    <i class="fas fa-rupee-sign header_icons"></i>
                                    <span>Concession</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="<?php echo base_url(); ?>feeInstallmentListing">
                                    <i class="fas fa-rupee-sign header_icons"></i>
                                    <span>Instalment</span>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link " href="<?php echo base_url(); ?>viewManagementFeeInfo">
                                    <i class="fas fa-rupee-sign header_icons"></i>
                                    <span>Management Fee</span>
                                </a>
                            </li> -->

                            
                        </ul>
                    </li>
                <?php } ?>

                <li class="nav-item">
                    <a href="#leave" data-toggle="collapse" aria-expanded="false"
                        class="nav-link  dropdown-toggle">
                        <i class="material-icons">watch_later</i>
                        <span>Leave</span>
                    </a>
                    <ul class="collapse list-unstyled ml-3" id="leave">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>viewApplyLeave">
                                <i class="material-icons">watch_later</i>
                                <span>Apply Leave</span>
                            </a>
                        </li>
                        <?php if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE ) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url(); ?>viewAdminApplyLeavePage">
                                    <i class="material-icons">calendar_today</i>
                                    <span>Apply Staff Leave</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if($role == ROLE_PRINCIPAL || $role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url(); ?>staffLeaveInfo">
                                    <i class="material-icons">watch_later</i>
                                    <span>Leave Info</span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <?php if($role == ROLE_TEACHING_STAFF || $role == ROLE_OFFICE || $role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR) { ?>
                    <li class="nav-item">
                        <a href="#attendance" data-toggle="collapse" aria-expanded="false" class="nav-link  dropdown-toggle">
                            <i class="material-icons">format_list_bulleted</i>
                            <span>Attendance</span>
                        </a>
                        <ul class="collapse list-unstyled ml-3" id="attendance">
                            <li class="nav-item">
                                <a class="nav-link " href="<?php echo base_url(); ?>getAttendanceDetails">
                                    <i class="material-icons">format_list_bulleted</i>
                                    <span>Take Attendance</span>
                                </a>
                                <a class="nav-link" href="<?php echo base_url(); ?>viewAttendanceInfo">
                                    <i class="material-icons">description</i>
                                    <span>Absent Info</span>
                                </a>
                                <a class="nav-link" href="<?php echo base_url(); ?>viewClassCompletedInfo">
                                    <i class="material-icons">group</i>
                                    <span>Class Completed</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#exam" data-toggle="collapse" aria-expanded="false" class="nav-link  dropdown-toggle">
                            <i class="material-icons">mode_edit</i>
                            <span>Exam</span>
                        </a>
                        <ul class="collapse list-unstyled ml-3" id="exam">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url(); ?>addInternalMark">
                                    <i class="material-icons">edit</i>
                                    <span>Add Internal Mark</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#study_items" data-toggle="collapse" aria-expanded="false" class="nav-link  dropdown-toggle">
                            <i class="material-icons">book</i>
                            <span>Study Materials</span>
                        </a>
                        <ul class="collapse list-unstyled ml-3" id="study_items">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url(); ?>viewOnlineClass">
                                    <i class="material-icons">group</i>
                                    <span>Online Class</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url(); ?>viewStudyMaterials">
                                    <i class="material-icons">book</i>
                                    <span>Materials</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url(); ?>viewYoutube">
                                    <i class="fab fa-youtube header_icons"></i>
                                    <span>Video</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link " href="<?php echo base_url(); ?>viewPermissions">
                        <i class="material-icons">alarm_off</i>
                        <span>Permission</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link " href="<?php echo base_url(); ?>viewHolidayList">
                        <i class="material-icons">event</i>
                        <span>Holiday</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link " href="<?php echo base_url(); ?>viewMyProfile">
                        <i class="material-icons">&#xE7FD;</i>
                        <span>Profile</span>
                    </a>
                </li>

                <?php if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR) { ?>
                <li class="nav-item">
                    <a class="nav-link " href="<?php echo base_url(); ?>viewSettings">
                        <i class="material-icons">settings</i>
                        <span>Settings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="<?php echo base_url(); ?>calendar">
                        <i class="material-icons">today</i>
                        <span>Calendar</span>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </aside>
    <!-- End Main Sidebar -->
    <main class="main-content col-12 col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
        <!-- <div id="coverScreen" class="loaderScreen text-center">
            <img height="90" src="assets/images/loader.gif" alt="">
        </div> -->
        <div class="main-navbar sticky-top bg-white">
            <!-- Main Navbar -->
            <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>

                <form action="#" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex">
                    <div class="input-group input-group-seamless ml-3">
                        <img class="my-auto rounded" src="<?php echo base_url(); ?><?php echo INSTITUTION_LOGO; ?>"
                            height="57px">
                        <h4 class="head_title ml-2 my-auto"><?php echo TITLE; ?></h4>
                    </div>
                </form>
                <ul class="navbar-nav border-left flex-row header-nav ">
                    <li class="nav-item border-right dropdown notifications ">
                        <a title="Click here to help guide" class="nav-link nav-link-icon text-center" href="#"
                            role="button" id="dropdownMenuLink">
                            <div class="nav-link-icon__wrapper">
                                <i class="material-icons">help</i>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item border-right dropdown notifications">
                        <a class="nav-link nav-link-icon text-center" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="nav-link-icon__wrapper">
                                <i class="material-icons">access_time</i>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-small" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#">
                                <div class="notification__icon-wrapper">
                                    <div class="notification__icon">
                                        <i class="material-icons">access_time</i>
                                    </div>
                                </div>
                                <div class="notification__content">
                                    <span class="notification__category">Last Login:</span>
                                    <p><?= empty($last_login) ? "First Time Login" : date('d-m-Y h:m:s A',strtotime($last_login)); ?>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </li> 
                    <li class="nav-item border-right dropdown notifications">
                        <a class="nav-link nav-link-icon text-center" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="nav-link-icon__wrapper" onclick="clearNotificationCounter('<?=$this->session->userdata ('staff_id')?>')">
                                <i class="material-icons">notifications</i><span class="badge badge-pill badge-danger" id="notificationCounter">0</span>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-small" aria-labelledby="dropdownMenuLink">  
                            <span id="new_notification_list">
                                
                            </span>
                            <a class="dropdown-item" href="#" id="no_new_notifications">
                                <div class="notification__icon-wrapper">
                                    <div class="notification__icon">
                                        <i class="material-icons">notifications_none</i>
                                    </div>
                                </div>
                                <div class="notification__content mt-2" >
                                    <b class="">No New Notifications</b>
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown nav-profile">
                        <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#"
                            role="button" aria-haspopup="true" aria-expanded="false">
                            <?php 
                                             
                                            if(!empty($profileImg)){ ?>
                            <img class="user-avatar rounded-circle mr-2" style="height: 45px;"
                                src="<?php echo $profileImg; ?>" alt="Profile">
                            <?php } else { ?>
                            <img class="user-avatar rounded-circle mr-2"
                                src="<?php echo base_url(); ?>assets/dist/img/user.png" alt="Profile">
                            <?php } ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-small dropdown-margin">

                            <div class="row  user-header">
                                <div class="col-12 col-lg-12 ">
                                    <?php if(!empty($profileImg)){ ?>
                                    <img class=" rounded-circle text-center " src="<?php echo $profileImg; ?>"
                                        alt="Profile Image" height="100" width="100">
                                    <?php } else { ?>
                                    <img class=" rounded-circle  text-center"
                                        src="<?php echo base_url(); ?>assets/dist/img/user.png" alt="Profile Image"
                                        height="100" width="100">
                                    <?php } ?>
                                    <p>
                                        <?php echo $name; ?>
                                        <br>
                                        <span style="font-size:12px;"><?php echo $role_text; ?></span>
                                    </p>
                                </div>
                            </div>
                            <hr class="mt-0 mb-1">
                            <!-- Menu Footer-->
                            <div class="row user-footer ">
                                <div class="col-12 col-lg-12 ">
                                    <a href="<?php echo base_url(); ?>viewMyProfile"
                                        class="btn  btn-primary profile-btn pull-left "><i
                                            class="fa fa-user-circle"></i> Profile</a>
                                    <a href="<?php echo base_url(); ?>logout"
                                        class="btn  btn-danger signout-btn  pull-right"><i class="fas fa-sign-out-alt"></i>
                                        Sign out</a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <nav class="nav">
                    <a href="#"
                        class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left"
                        data-toggle="collapse" data-target=".header-navbar" aria-expanded="false"
                        aria-controls="header-navbar">
                        <i class="material-icons">&#xE5D2;</i>
                    </a>
                </nav>
            </nav>
        </div>