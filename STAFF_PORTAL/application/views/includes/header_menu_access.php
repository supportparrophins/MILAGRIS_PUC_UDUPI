<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#317EFB" />
    <title><?php echo $pageTitle; ?></title>
    <link rel="manifest" href="manifest.webmanifest?version=1.1">
    <!-- <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script> -->
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
    <script src="<?= base_url() ?>assets/plugins/sweetalert/sweetalert2.0.js"></script>


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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" />
    <link href="https://unpkg.com/material-components-web@6.0.0/dist/material-components-web.min.css" rel="stylesheet">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
       <style>
    .switch-button {
        background-color: #007bff;
        color: #ffffff;
        border: none;
        padding: 8px 16px 10px;
        /* Adjusted padding (top, right, bottom) */
        margin: 8px 8px 8px;
        /* Adjusted padding (top, right, bottom) */
        border-radius: 4px;
        /* Adjusted border radius */
        cursor: pointer;
        font-size: 14px;
        /* Adjusted font size */
        transition: background-color 0.3s ease;
    }

    .switch-button:hover {
        background-color: #0056b3;
    }
    </style>
    <style>
    .round-image {
        width: 40px;
        /* Adjust as needed */
        height: 40px;
        /* Adjust as needed */
        border-radius: 50%;
    }

    /* CSS to enable scrolling in the dropdown menu */
    .styleClass {
        max-height: 500px;
        /* Adjust the height as needed */
        overflow-y: auto;
    }
    </style>
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="https://unpkg.com/material-components-web@6.0.0/dist/material-components-web.min.js"></script>
    <script src="<?= base_url() ?>assets/js/helper.js"></script>
    <script type="text/javascript">
    var baseURL = "<?php echo base_url(); ?>";

    function showLoader() {
        $(".custom_loader").addClass('active');
        $("#custom_loader_text").css('display', 'block');
    }

    function hideLoader() {
        $(".custom_loader").removeClass('active');
        $("#custom_loader_text").css('display', 'none');
    }
    </script>
    <script>
    $(document).ready(() => {
        $("form").submit(() => {
            showLoader();
        });
        $("li.nav-item > .nav-link[href*='<?= base_url() ?>']").on('click', function() {
            showLoader();
        });
    });
    </script>
        <script>
    $(document).ready(() => {
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
            } else if ($(evt.target).data('no_loader')) {

            } else {
                showLoader();
            }
        });

        $("li.nav-item > .nav-link[href*='<?=base_url()?>']").on('click', function() { 
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

    <!-- OneSignal Script -->
    <script>
    // window.OneSignal = window.OneSignal || [];
    // OneSignal.push(function() {
    //     OneSignal.init({
    //         appId: "<?= ONE_SIGNAL_APP_ID ?>"
    //     });
    // });
    </script>
    <script>
    const staffID = "<?= $this->session->userdata('staff_id') ?>";
    const department = "<?= $this->session->userdata('dept_id') ?>";
    const role = "<?= $this->session->userdata('role') ?>";

    // OneSignal.push(function() {
    //     OneSignal.on('subscriptionChange', function(isSubscribed) {
    //         if (isSubscribed) {
    //             OneSignal.sendTags({
    //                 user_type: 'staff',
    //                 user_id: staffID,
    //                 department: department,
    //                 role: role
    //             }, function(tagsSent) {
    //                 console.log("tagsSent:", tagsSent);
    //             });
    //             OneSignal.getUserId().then(function(userId) {
    //                 console.log("OneSignal User ID:", userId);
    //             });
    //         }
    //     });
    // });
    </script>
    <!-- End of OneSignal Script -->
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>


<body class="hold-transition skin-blue sidebar-mini" style="overflow-x: hidden;">



    <div class="custom_loader"><span id="custom_loader_text"
            style="color:blue;font-weight:bold;margin-left: -100%;font-size: 17px;display:none;">Loading...</span></div>
    <?php if($_SESSION['loggedIn_type']!='Mobile'){ ?>
    <!-- Main Sidebar -->
    <aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
        <div class="main-navbar">
            <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
                <a class="navbar-brand w-100 mr-0 pt-1" href="#" style="line-height: 25px;">
                    <div class="d-table m-auto mobile_display_none">
                        <img id="main-logo" class="d-inline-block mr-1" style="max-width: 50px;"
                            src="<?php echo base_url(); ?>assets/dist/img/dolphin_logo.png" alt="logo">
                        <h5 class="d-none d-md-inline title_sidenav"><span class="title_green">School</span><span
                                class="title_blue">phins</span>
                        </h5>
                        <!-- mobile view -->
                    </div>
                    <div class="sidebar_mobile_view mx-auto">
                        <img id="main-logo" class="d-inline-block logo_mobile_view mr-0 rounded"
                            style="max-width: 50px;" src="<?php echo base_url(); ?><?php echo INSTITUTION_LOGO; ?>"
                            alt="logo">
                        <h4 class="d-md-inline title_mobile_view"><?php echo SUB_TITLE; ?></h4>
                    </div>
                </a>
                <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                    <i class="material-icons">&#xE5C4;</i>
                </a>
            </nav>
        </div>
       
        <div class="nav-wrapper">
            <ul class="nav flex-column">
                 <?php if($staffID == 'MILP1004'){ ?>
            <li class="nav-item">
                    <a href="#staff_link" data-toggle="collapse" aria-expanded="false"
                        class="nav-link  dropdown-toggle">
                        <i class="fas fa-chalkboard-teacher header_icons"></i>
                        <span>Staff</span>
                    </a>
                    <ul class="collapse list-unstyled ml-3" id="staff_link">
                        <li class="nav-item">
                            <a class="nav-link " href="<?php echo base_url(); ?>staffDetails">
                                <i class="fas fa-chalkboard-teacher header_icons"></i>
                                <span>View All</span>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
                  
        <?php if(!empty($ModuleInfo)){   
            foreach($ModuleInfo as $module){ 

            //    $SubMenuModule = $staffModel->getAllSubModules($module->row_id,$role); 
            $roleModules = $staffModel->getAllSubModules($module->row_id, $role);
                $staffModules = $staffModel->getAllSubModulesByStaffID($module->row_id, $staffID);

                $SubMenuModule = array_merge(
                    $roleModules ?? [],
                    $staffModules ?? []
                );

                $uniqueModules = [];
                foreach ($SubMenuModule as $item) {
                    $uniqueModules[$item->row_id] = $item;
                }

                $SubMenuModule = array_values($uniqueModules);

               $total_count = count($SubMenuModule);
                if($total_count == 1){ ?>
                <?php if(!empty($SubMenuModule)){   
                        foreach($SubMenuModule as $sub){ ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url(); ?><?php echo $sub->redirect_url; ?>" onclick="setModuleSession(<?php echo $sub->row_id; ?>)">
                                <?php echo $sub->icon; ?>
                                    <span class="pl-2"><?php echo $sub->menu_name; ?></span>
                                </a>
                            </li>
                <?php }} ?>
        <?php }else if($total_count > 1){ ?>
            <li class="nav-item">
                <a href="#<?php echo $module->menu_name; ?>" data-toggle="collapse" aria-expanded="false" class="nav-link  dropdown-toggle">
                <?php echo $module->icon; ?>
                        <span><?php echo $module->menu_name; ?></span>
                </a>
                <ul class="collapse list-unstyled ml-3" id="<?php echo $module->menu_name; ?>">
                    <?php if(!empty($SubMenuModule)){   
                        foreach($SubMenuModule as $sub){ ?>
                            <li class="nav-item">
                                <a class="nav-link " href="<?php echo base_url(); ?><?php echo $sub->redirect_url; ?>" onclick="setModuleSession(<?php echo $sub->row_id; ?>)">
                                <?php echo $module->icon; ?>
                                    <span class="pl-2"><?php echo $sub->menu_name; ?></span>
                                </a>
                            </li>
                    <?php }} ?>
                </ul>
            </li>
        <?php } ?>
        
        <?php }} ?>
            <?php if($staffID == '123456'){ ?>
            <li class="nav-item">
                <a class="nav-link " href="<?php echo base_url(); ?>configureMenuAccess">
                    <i class="material-icons">settings</i>
                    <span>Configuration</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="<?php echo base_url(); ?>menuAccess">
                    <i class="material-icons">settings</i>
                    <span>Access Control</span>
                </a>
            </li>
             <li class="nav-item">
                    <a class="nav-link " href="<?php echo base_url(); ?>menuAccessStaffId">
                        <i class="material-icons">settings</i>
                        <span>Access Staff ID</span>
                    </a>
                </li>
            <?php } ?>
            </ul>
        </div>
    </aside>
    <!-- End Main Sidebar -->
    <main class="main-content col-12 col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
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
                                    <p><?= empty($last_login) ? "First Time Login" : date('d-m-Y h:m:s A', strtotime($last_login)); ?>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </li>
                    <?php if ($role == ROLE_SUPER_ADMIN || $role == ROLE_AUDITOR) { ?>

                    <li class="nav-item border-right dropdown notifications">
                        <a class="nav-link nav-link-icon text-center" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="nav-link-icon__wrapper">
                                <button type="button" class="switch-button" title="Switch">Switch</button>
                            </div>
                        </a>
                       <div class="dropdown-menu dropdown-menu-small styleClass" aria-labelledby="dropdownMenuLink">
                       <?php if(!empty($institutionList)){   
                                    foreach($institutionList as $inst){ ?>
                                <a class="dropdown-item"
                                    href="<?php echo $inst->staff_api; ?>directLogin/<?php echo $this->staff_id; ?>/<?php echo uri_string(); ?>">
                                    <div class="notification__icon-wrapper">
                                        <div class="notification__icon">
                                            <img src="<?php echo $inst->institution_logo; ?>"
                                                class="round-image" alt="Image">
                                        </div>
                                    </div>
                                    <div class="notification__content">
                                        <p style="color: #000000; font-weight: bold;"><?php echo $inst->institution_name; ?></p>
                                    </div>
                                </a>  
                        <?php }} ?>
                       </div>
                   </li>

                    <?php } ?>




                    <li class="nav-item border-right dropdown notifications">
                        <a class="nav-link nav-link-icon text-center" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="nav-link-icon__wrapper">
                                <i class="material-icons">notifications</i>
                                <?php
                                $i = 1;
                                if (!empty($notificationMsg)) {
                                    foreach ($notificationMsg as $notification) {
                                ?>
                                <span class="badge badge-pill badge-danger"><?php echo $i++; ?></span>
                                <?php  }
                                } ?>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-small" aria-labelledby="dropdownMenuLink">
                            <?php
                            if (!empty($notificationMsg)) {
                                foreach ($notificationMsg as $notification) { ?>
                            <a class="dropdown-item" href="#">
                                <div class="notification__icon-wrapper">
                                    <div class="notification__icon">
                                        <i class="material-icons">notifications_active</i>
                                    </div>
                                </div>
                                <div class="notification__content mt-1">
                                    <b><?php echo $notification->message; ?></b>
                                </div>
                            </a>
                            <?php }
                            } else { ?>
                            <a class="dropdown-item" href="#">
                                <div class="notification__icon-wrapper">
                                    <div class="notification__icon">
                                        <i class="material-icons">notifications_none</i>
                                    </div>
                                </div>
                                <div class="notification__content mt-2">
                                    <b class="">Today No Announcement</b>
                                </div>
                            </a>
                            <?php } ?>
                        </div>
                    </li>
                    <li class="nav-item dropdown nav-profile">
                        <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#"
                            role="button" aria-haspopup="true" aria-expanded="false">
                            <?php

                            if (!empty($profileImg)) { ?>
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
                                    <?php if (!empty($profileImg)) { ?>
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
                                        class="btn  btn-danger signout-btn  pull-right"><i
                                            class="fas fa-sign-out-alt"></i>
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

        <?php } ?>

<script>
function setModuleSession(moduleId) {
    fetch('<?php echo base_url("staffs/setCurrentModule"); ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'module_id=' + moduleId
    });
}
</script>