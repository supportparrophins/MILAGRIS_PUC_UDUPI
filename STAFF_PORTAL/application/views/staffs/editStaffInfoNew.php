<style>
    .custom-col-3-5 {
    flex: 0 0 29%;
    max-width: 29%;
}

    .profile-section {
        border: 1px solid #dee2e6;
        /* Soft border */
        border-radius: 8px;
        /* Rounded corners */
        padding: 16px;
        /* margin-bottom: 20px; */
        /* Add some space between sections */
    }


    /* Checkbox Input */
    .checkbox-btn span {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        /* reduced size */
        height: 30px;
        /* reduced size */
        background-color: #ddd;
        transition: 0.3s;
    }

    .checkbox-btn span::before {
        content: '';
        display: inline-block;
        width: 12px;
        /* reduced size */
        height: 6px;
        /* reduced size */
        border-bottom: 2px solid #fff;
        /* reduced size */
        border-left: 2px solid #fff;
        /* reduced size */
        transform: scale(0) rotate(-45deg);
        position: relative;
        bottom: 2px;
        /* adjusted position */
        transition: 0.6s;
    }

    .checkbox-btn input {
        display: none;
    }

    .checkbox-btn input:checked~span {
        background-color: #02bcf0;
    }

    .checkbox-btn input:checked~span::before {
        transform: scale(1) rotate(-45deg);
    }


    /* Switch Button */
    .switch-btn span {
        display: flex;
        align-items: center;
        width: 80px;
        height: 44px;
        border-radius: 30px;
        background-color: #ddd;
        transition: 0.3s;
        padding: 0 3px;
        position: relative;
    }

    .switch-btn span::before {
        content: '';
        display: inline-block;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #fff;
        position: absolute;
        left: 5px;
        transition: 0.6s;
    }

    .switch-btn input {
        display: none;
    }

    .switch-btn input:checked~span {
        background-color: #02bcf0;
    }

    .switch-btn input:checked~span::before {
        left: 45px;
    }

    .custom-checkbox .form-check-input {
        width: 30px;
        height: 30px;
        cursor: pointer;
    }

    .custom-checkbox .form-check-label {
        font-size: 20px;
        cursor: pointer;
    }


    .profile-section {
        margin-bottom: 0;
        /* Remove bottom margin */
    }

    .profile-section+ul.nav {
        margin-top: 0;
        /* Remove top margin of the navigation */
    }

    .profile-head+ul.nav {
        margin-top: 0;
        /* Remove top margin of the navigation */
    }

    .profile-section #myTab1 {
        margin-top: 0 !important;
    }

    .profile-img {
        max-width: 250px;
        /* Limit the maximum width of the profile image */
        /* margin-right: 10px; Add some space between the image and details */
    }

    .profile-sidebar {
        padding: 10px;
    }

    .profile-details {
        margin-top: 10px;
    }

    .profile-details .p-1 {
        margin-bottom: 5px;
        /* Add some space between details */
    }

    .profile-details hr {
        margin: 5px 0;
        /* Adjust margin for horizontal rule */
    }

    /*
.ui-datepicker-calendar {
display: none;
} */
    /* Only apply styles to the datepicker when it has the year-only class */
    #ui-datepicker-div.year-only .ui-datepicker-calendar,
#ui-datepicker-div.year-only .ui-datepicker-month {
    display: none;
}
.modal-lg {
        max-width: 70%;
    }
    .modal-dialog {
       
       right: auto; 
       margin-right: 140px; 
    
   }
    .section {
        /* min-height: 400px;  */
        border: 1px solid #ddd;
        padding: 15px;
    }
    .vertical-line {
        border-left: 5px solid #ddd;
        height: 100%;
        position: absolute;
        left: 50%;
    }
    .row-container {
        position: relative;
    }

.section-title {
    border-bottom: 2px solid #000;
    padding-bottom: 5px;
}
</style>

<?php
if (!empty($staffInfo)) {
    $row_id = $staffInfo->row_id;
    $staff_id = $staffInfo->staff_id;
    $staff_name = $staffInfo->name;
    $date_of_birth = $staffInfo->dob;
    $email = $staffInfo->email;
    $profileImg = $staffInfo->photo_url;
} else {
    $staff_name = "Not Found! ";
}
if (!empty($date_of_birth)) {
    $date_of_birth = date('d-m-Y', strtotime($date_of_birth));
}
?>


<?php
$this->load->helper('form');
$error = $this->session->flashdata('error');
if ($error) {
?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $this->session->flashdata('error'); ?>
    </div>
<?php } ?>
<?php
$success = $this->session->flashdata('success');
if ($success) {
?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php } ?>

<?php
$noMatch = $this->session->flashdata('nomatch');
if ($noMatch) {
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
<div class="main-content-container container-fluid px-4 pt-1">
    <section class="content-header">
        <div class="row mt-1 mb-2">
            <div class="col padding_left_right_null">
                <div class="card card-small p-0 tbl-head1">
                    <div class="card-body p-2 ml-2">
                        <div class="row">
                            <div class="col-lg-5 col-6 col-md-12 col-sm-6 box-tools">
                                <span class="page-title">
                                    <i class="fa fa-user-circle"></i> <?php echo $staff_name; ?> Profile
                                </span>
                            </div>
                            <div class="col-lg-5 col-6 col-md-12 col-sm-6 box-tools">
                                <select class="form-control selectpicker" data-live-search="true" name="search_staff" id="search_staff">
                                    <option value="<?php echo $staffInfo->row_id; ?>">Selected :
                                        <?php echo $staffInfo->name ?></option>
                                    <option value="">Select Staff</option>
                                    <?php if (!empty($AllstaffInfo)) {
                                        foreach ($AllstaffInfo as $staff) { ?>
                                            <option value="<?php echo $staff->row_id ?>"><?php echo $staff->name ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                            <div class="col-lg-2 col-6 col-md-12 col-sm-6 box-tools">
                                <a onclick="window.history.back();" class="btn btn-primary float-right text-white pt-2" value="Back">Back </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if (empty($staffInfo)) { ?>
        <div class="row form-employee">
            <div class="col-lg-12 col-md-12 col-12 pr-0 text-center">
                <img height="270" src="<?php echo base_url(); ?>assets/images/404.png" />
            </div>
        </div>
    <?php } else {  ?>
        <div class="row form-employee">
            <div class="col-lg-12 col-sm-9">
                <div class="card card-small c-border mb-4 p-1">
                    <div class="profile-section">
                        <div class="row align-items-center">

                            <table class="table table-bordered mb-0 mt-0">
                                <tr>
                                    <td style="background:white; width: 140px;" rowspan="5" class="p-0">
                                        <div class="profile-img" style="width: 100%; height: 100%; overflow: hidden;">
                                            <?php
                                            // $profileImg = $studentInfo->photo_url;
                                            // log_message('debug','$profileImg '.print_r($profileImg,true));
                                            if (!empty($profileImg)) { ?>
                                                <img src="<?php echo $profileImg; ?>" class="avatar img-thumbnail" style="width: 100%; height: auto;" alt="Profile Image" id="uploadedImage1" />
                                            <?php } else { ?>
                                                <img src="<?php echo base_url(); ?>assets/dist/img/user.png" class="avatar img-thumbnail" style="width: 100%; height: auto;" id="uploadedImage1" alt="Profile default">
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>


                                <tr>

                                    <th class="tbl-head1" width="140">Full Name</th>
                                    <th class="tbl-head-content1" width="280">
                                        <?php echo strtoupper($staff_name); ?>
                                    </th>
                                    <!-- <th class="tbl-head1" width="140">Employee ID</th>
                                    <th class="tbl-head-content1" width="200"><?php //echo $staffInfo->employee_id; ?></th> -->
                                    </th>
                                    <th class="tbl-head1">Age</th>
                                    <th class="tbl-head-content1">

                                        <?php
                                        if (empty($date_of_birth) || $date_of_birth == '1970-01-01' || $date_of_birth == '0000-00-00' || $date_of_birth == '30-11--0001') {
                                            echo "Not Updated";
                                        } else {
                                            // Calculate age
                                            $dob = new DateTime($date_of_birth);
                                            $now = new DateTime();
                                            $age = $dob->diff($now)->y;

                                            echo $age; // Output the age
                                        }
                                        ?>
                                    </th>

                                    <th class="tbl-head1" width="140">Staff Id</th>
                                    <th class="tbl-head-content1" width="200"> <?php echo $staff_id; ?>

                                    </th>
                                </tr>
                                <tr>
                                    <th class="tbl-head1">Gender</th>
                                    <th class="tbl-head-content1">
                                        <?php if (empty($staffInfo->gender)) {
                                            echo "Not Updated";
                                        } else {
                                            echo strtoupper($staffInfo->gender);
                                        } ?>
                                    </th>
                                    <th class="tbl-head1" width="140">Date of Birth</th>
                                    <th class="tbl-head-content1" width="180">
                                        <?php if (empty($date_of_birth) || $date_of_birth == '1970-01-01' || $date_of_birth == '0000-00-00' || $date_of_birth == '30-11--0001') {
                                            echo "Not Updated";
                                        } else {
                                            echo date('d-m-Y', strtotime($date_of_birth));
                                        } ?>
                                    </th>
                                    <th class="tbl-head1">Designation</th>
                                    <th class="tbl-head-content1">
                                        <?php if (empty($staffInfo->role)) {
                                            echo "Not Updated";
                                        } else {
                                            echo $staffInfo->role;
                                        } ?>
                                    </th>

                                </tr>
                                <tr>
                                    <th class="tbl-head1">Department</th>
                                    <th class="tbl-head-content1">
                                        <?php if (empty($staffInfo->department)) {
                                            echo "Not Updated";
                                        } else {
                                            echo $staffInfo->department;
                                        } ?>
                                    </th>
                                    <th class="tbl-head1">Date of Joining</th>
                                    <th class="tbl-head-content1">
                                        <?php if (empty($staffInfo->doj) || $staffInfo->doj == '1970-01-01' || $staffInfo->doj == '0000-00-00' || $staffInfo->doj == '30-11--0001') {
                                            echo "Not Updated";
                                        } else {
                                            echo date('d-m-Y', strtotime($staffInfo->doj));
                                        } ?>
                                    </th>
                                    <th class="tbl-head1">Contact No</th>
                                    <th class="tbl-head-content1">
                                        <?php if (empty($staffInfo->mobile_one)) {
                                            echo "Not Updated";
                                        } else {
                                            echo $staffInfo->mobile_one;
                                        } ?>
                                    </th>
                                    <!-- <th class="tbl-head">Email</th>
                                <th class="tbl-head-content1">
                                <?php if (empty($staffInfo->email)) {
                                    echo "Not Updated";
                                } else {
                                    echo $staffInfo->email;
                                } ?>
                                </th> -->
                                </tr>
                                <tr>
                                    <th class="tbl-head1">Email</th>
                                    <th class="tbl-head-content1">
                                        <?php if (empty($staffInfo->email)) {
                                            echo "Not Updated";
                                        } else {
                                            echo $staffInfo->email;
                                        } ?>
                                    </th>
                                    <!-- <th class="tbl-head1">Age</th>
                                    <th class="tbl-head-content1">

                                        <?php
                                        // if (empty($date_of_birth) || $date_of_birth == '1970-01-01' || $date_of_birth == '0000-00-00' || $date_of_birth == '30-11--0001') {
                                        //     echo "Not Updated";
                                        // } else {
                                            // Calculate age
                                        //     $dob = new DateTime($date_of_birth);
                                        //     $now = new DateTime();
                                        //     $age = $dob->diff($now)->y;

                                        //     echo $age; // Output the age
                                        // }
                                        ?>
                                    </th> -->


                                </tr>


                            </table>

                        </div>
                    </div>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Personal</a>
                        </li>
                        <!-- <li class="nav-item">
                        <a class="nav-link" id="bank-tab" data-toggle="tab"
                            href="#bank" role="tab" aria-controls="bank"
                            aria-selected="false">Bank</a>
                    </li> -->
                        <?php //if($staffInfo->role != "Non-Teaching Staff") { 
                        ?>
                        <!-- <li class="nav-item">
                            <a class="nav-link" id="subject-tab" data-toggle="tab"
                                href="#subject" role="tab" aria-controls="subject"
                                aria-selected="false">Subject</a>
                        </li> -->
                        <?php if ($role == ROLE_TEACHING_STAFF || $role == ROLE_OFFICE || $role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_VICE_PRINCIPAL  || $role == ROLE_RECEPTION) { ?>
                            <li class="nav-item">
                                <a class="nav-link" id="subject-tab" data-toggle="tab" href="#subject" role="tab" aria-controls="subject" aria-selected="false">Subject</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="section-tab" data-toggle="tab" href="#section" role="tab" aria-controls="section" aria-selected="false">Class</a>
                            </li>

                        <?php } ?>
                        <?php if ($role != ROLE_FINANCE_OFFICER && $role != ROLE_OFFICE && $role != ROLE_ACCOUNT) { ?>

                            <li class="nav-item">
                                <a class="nav-link" id="family-tab" data-toggle="tab" href="#family" role="tab" aria-controls="family" aria-selected="true">Leave Info</a>
                            </li>
                        <?php } ?>

                        <?php if ($staffID == '123456' || $role == ROLE_ACCOUNT || $role == ROLE_SUPER_ADMIN || $staffID == '12345' || $role == ROLE_PRIMARY_ADMINISTRATOR) { ?>
                            <li class="nav-item">
                                <a class="nav-link" id="salaryInfo-tab" data-toggle="tab" href="#salaryInfo" role="tab" aria-controls="salaryInfo" aria-selected="true">Salary Info</a>
                            </li>
                        <?php } ?>
                        <?php if ($role != ROLE_FINANCE_OFFICER && $role != ROLE_ACCOUNT) { ?>

                            <li class="nav-item">

                                <a class="nav-link" id="document-tab" data-toggle="tab" href="#document" role="tab" aria-controls="document" aria-selected="false">Document</a>

                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="previousWork-tab" data-toggle="tab" href="#previousWork" role="tab" aria-controls="previousWork" aria-selected="false">Work Experience</a>
                            </li>
                        <?php } ?>

                        <!-- <li class="nav-item">
                        <a class="nav-link" id="Academics-tab" data-toggle="tab" href="#Academics" role="tab"
                            aria-controls="Academics" aria-selected="false">Academic</a>
                    </li> -->
                        <?php if ($role == ROLE_PRINCIPAL || $staffID == '123456' || $role == ROLE_SUPER_ADMIN) { ?>

                            <li class="nav-item">
                                <a class="nav-link" id="observation-tab" data-toggle="tab" href="#observation" role="tab" aria-controls="observation" aria-selected="true">Remarks</a>
                            </li>
                        <?php } ?>
                            <?php if($role == ROLE_PRINCIPAL || $staffID == '123456'  || $role == ROLE_SUPER_ADMIN){
                        $commentsInfo = $feedback_model->getStudentFeedbackCount($staffInfo->row_id);
                        if(count($commentsInfo) > 0){
                        ?>
                    <li class="nav-item">
                        <a class="nav-link" id="feedback-tab" data-toggle="tab" href="#feedback" role="tab"
                            aria-controls="feedback" aria-selected="true">Student Feedback</a>
                    </li>
                    <?php } }?>
                        <?php if ($staffID == '123456' || $role == ROLE_ACCOUNT || $role == ROLE_SUPER_ADMIN || $staffID == '12345') { ?>

                            <li class="nav-item">
                                <a class="nav-link" id="OTInfo-tab" data-toggle="tab" href="#OTInfo" role="tab" aria-controls="OTInfo" aria-selected="true">OT Info</a>
                            </li>
                        <?php } ?>
                        <?php if ($role != ROLE_ACCOUNT) { ?>

                        <li class="nav-item">
                            <a class="nav-link" id="notification-tab" data-toggle="tab" href="#notification"
                                role="tab" aria-controls="notification" aria-selected="true">Notification</a>
                        </li>
                        <?php } ?>

                        <?php //if($role == ROLE_PRINCIPAL || $staffID == '123456'){
                        // $commentsInfo = $feedback_model->getStudentFeedbackCount($staffInfo->row_id);
                        // if(count($commentsInfo) > 0){
                        ?>
                        <?php if ($staffID == '123456' || $role == ROLE_ACCOUNT || $role == ROLE_SUPER_ADMIN || $staffID == '12345') { ?>
                        <li class="nav-item">
                            <a class="nav-link" id="AdvancePayment-tab" data-toggle="tab" href="#AdvancePayment"
                                role="tab" aria-controls="AdvancePayment" aria-selected="true">Advance Payment Info</a>
                        </li>
                        <?php } ?>
                        <!-- <li class="nav-item">
                        <a class="nav-link" id="feedback-tab" data-toggle="tab" href="#feedback" role="tab"
                            aria-controls="feedback" aria-selected="true">Student Feedback</a>
                    </li> -->
                        <?php //} }
                        ?>
                        <!-- <li class="nav-item">
                        <a class="nav-link" id="resign-tab" data-toggle="tab" href="#resign" role="tab" aria-controls="resign"
                                                aria-selected="true">Resignation Info</a>
                    </li> -->
                        <!-- <li class="nav-item">
                        <a class="nav-link" id="password-tab" data-toggle="tab"
                            href="#changePassword" role="tab" aria-controls="password"
                            aria-selected="false">Change
                            Password</a>
                    </li> -->
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active mt-2" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                            <form role="form" id="editStaff" action="<?php echo base_url() ?>updateStaff" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="shift_id" id="shift_id" value="<?php echo !empty($staffInfo->shift_code) ? $staffInfo->shift_code : ''; ?>">
                                <input type="hidden" value="<?php echo $staffInfo->row_id; ?>" id="row_id" name="row_id">
                                <input type="hidden" value="<?php echo $staffInfo->mobile_one; ?>" id="prev_mobile" name="prev_mobile">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="card card-small c-border mb-4 p-2">
                                            <div class="card-header text-center">
                                                <label for="fname">Profile Image</label>
                                                <div class="text-center">
                                                    <?php
                                                    $profileImg = $staffInfo->photo_url;
                                                    if (!empty($profileImg)) { ?>
                                                        <img src="<?php echo $profileImg; ?>" class="avatar rounded-circle img-thumbnail" width="130" height="130" alt="Profile Image" id="uploadedImage">
                                                    <?php } else { ?>
                                                        <img src="<?php echo base_url(); ?>assets/images/user.png" class="avatar rounded-circle img-thumbnail" width="130" height="130" id="uploadedImage" alt="Profile default">
                                                    <?php } ?>
                                                </div>
                                                <div class="profileImg">
                                                    <div class="file btn btn-sm btn-primary">
                                                        Change
                                                        <input type="file" class="form-control-sm" id="vImg" accept=".png,.jpg,.jpeg" name="userfile" onchange="previewImage(event)">
                                                    </div>
                                                </div>
                                                <span class="text-danger font-weight-bold">(The Image maximum size is 2MB)</span>
                                            </div>
                                            <div class="form-group">

                                                <label class="staff_id mdc-text-field mdc-text-field--filled w-100">
                                                    <span class="mdc-text-field__ripple"></span>
                                                    <input name="staff_id" id="staff_id" class="mdc-text-field__input" type="text" aria-labelledby="my-label-id" value="<?php echo $staffInfo->staff_id; ?>" autocomplete="off" required  disabled readonly>
                                                    <span class="mdc-floating-label" id="my-label-id">Staff ID</span>
                                                    <span class="mdc-line-ripple"></span>
                                                </label>
                                            </div>
                                            <!-- <div class="form-group">
                                                <label class="employee_id mdc-text-field mdc-text-field--filled w-100">
                                                    <span class="mdc-text-field__ripple"></span>
                                                    <input name="employee_id" id="employee_id" class="mdc-text-field__input" type="text" aria-labelledby="my-label-id" value="<?php //echo $staffInfo->employee_id; ?>" autocomplete="off" disabled readonly>
                                                    <span class="mdc-floating-label" id="my-label-id">Employee ID</span>
                                                    <span class="mdc-line-ripple"></span>
                                                </label>
                                            </div> -->
                                            <div class="form-group">
                                                <label class="fname mdc-text-field mdc-text-field--filled w-100">
                                                    <span class="mdc-text-field__ripple"></span>
                                                    <input name="fname" id="fname" class="mdc-text-field__input" type="text" aria-labelledby="my-label-id" value="<?php echo $staffInfo->name; ?>" autocomplete="off" onkeydown="return alphaOnly(event)" maxlength="128" required>
                                                    <span class="mdc-floating-label" id="my-label-id">Full Name</span>
                                                    <span class="mdc-line-ripple"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="dob mdc-text-field mdc-text-field--filled w-100">
                                                    <span class="mdc-text-field__ripple"></span>
                                                    <input name="dob" id="dob" class="mdc-text-field__input datepicker" type="text" aria-labelledby="my-label-id" value="<?php if (empty($staffInfo->dob) || $staffInfo->dob == '0000-00-00') {
                                                                                                                                                                                echo "";
                                                                                                                                                                            } else {
                                                                                                                                                                                echo date('d-m-Y', strtotime($staffInfo->dob));
                                                                                                                                                                            } ?>" autocomplete="off">
                                                    <span class="mdc-floating-label" id="my-label-id">Date of Birth</span>
                                                    <span class="mdc-line-ripple"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <div class="mdc-select mdc-select-gender form-group mdc-select--required mb-0">
                                                    <div class="mdc-select__anchor demo-width-class" aria-required="true">
                                                        <span class="mdc-select__ripple"></span>
                                                        <input type="text" class="mdc-select__selected-text" name="gender" id="gender" value="" required>
                                                        <i class="mdc-select__dropdown-icon"></i>
                                                        <span class="mdc-floating-label">Select Gender</span>
                                                        <span class="mdc-line-ripple"></span>
                                                    </div>
                                                    <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                        <ul class="mdc-list">
                                                            <?php if (!empty($staffInfo->gender)) { ?>
                                                                <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo strtoupper($staffInfo->gender); ?>" aria-selected="true"><?php echo strtoupper($staffInfo->gender); ?></li>
                                                            <?php } ?>
                                                            <li class="mdc-list-item" data-value="MALE">
                                                                <span class="mdc-list-item__text">
                                                                    MALE
                                                                </span>
                                                            </li>
                                                            <li class="mdc-list-item" data-value="FEMALE">
                                                                <span class="mdc-list-item__text">
                                                                    FEMALE
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-12">
                                        <div class="card card-small c-border">
                                            <div class="card-header p-2">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label class="email mdc-text-field mdc-text-field--filled">
                                                            <span class="mdc-text-field__ripple"></span>
                                                            <input name="email" id="email" class="mdc-text-field__input" type="email" aria-labelledby="my-label-id" value="<?php echo $staffInfo->email; ?>" autocomplete="off" maxlength="228">
                                                            <span class="mdc-floating-label" id="my-label-id">Email</span>
                                                            <span class="mdc-line-ripple"></span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="mobile mdc-text-field mdc-text-field--filled">
                                                            <span class="mdc-text-field__ripple"></span>
                                                            <input name="mobile" id="mobile" class="mdc-text-field__input" required type="text" aria-labelledby="my-label-id" value="<?php echo $staffInfo->mobile_one; ?>" autocomplete="off" maxlength="10" minlength="10" onkeypress="return isNumberKey(event)">
                                                            <span class="mdc-floating-label" id="my-label-id">Contact Number
                                                            </span>
                                                            <span class="mdc-line-ripple"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label class="doj mdc-text-field mdc-text-field--filled ">
                                                            <span class="mdc-text-field__ripple"></span>
                                                            <input name="date_of_join" id="date_of_join" class="mdc-text-field__input datepicker_doj" type="text" aria-labelledby="my-label-id" value="<?php if (empty($staffInfo->doj) || $staffInfo->doj == '0000-00-00') {
                                                                                                                                                                                                            echo "";
                                                                                                                                                                                                        } else {
                                                                                                                                                                                                            echo date('d-m-Y', strtotime($staffInfo->doj));
                                                                                                                                                                                                        } ?>" autocomplete="off" required>
                                                            <span class="mdc-floating-label" id="my-label-id">Date of Joining</span>
                                                            <span class="mdc-line-ripple"></span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <div class="mdc-select-role mdc-select form-group mdc-select--required mb-0">
                                                            <div class="mdc-select__anchor demo-width-class" aria-required="true">
                                                                <span class="mdc-select__ripple"></span>
                                                                <input type="text" class="mdc-select__selected-text" name="role" id="role_id" value="" required>
                                                                <i class="mdc-select__dropdown-icon"></i>
                                                                <span class="mdc-floating-label">Role (Designation)</span>
                                                                <span class="mdc-line-ripple"></span>
                                                            </div>
                                                            <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                <ul class="mdc-list">
                                                                    <?php if (!empty($staffInfo->role)) { ?>
                                                                        <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $staffInfo->role_id; ?>" aria-selected="true"><?php echo $staffInfo->role; ?>
                                                                        </li>
                                                                    <?php } ?>
                                                                    <?php if (!empty($designation)) {
                                                                        foreach ($designation as $rl) { ?>
                                                                            <li class="mdc-list-item" data-value="<?php echo $rl->roleId ?>">
                                                                                <span class="mdc-list-item__text">
                                                                                    <?php echo $rl->role ?>
                                                                                </span>
                                                                            </li>
                                                                    <?php }
                                                                    } ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <div class="mdc-select-department mdc-select form-group mdc-select--required mb-0">
                                                            <div class="mdc-select__anchor demo-width-class" aria-required="true">
                                                                <span class="mdc-select__ripple"></span>
                                                                <input type="text" class="mdc-select__selected-text" name="department" id="department" value="" required>
                                                                <i class="mdc-select__dropdown-icon"></i>
                                                                <span class="mdc-floating-label">Department</span>
                                                                <span class="mdc-line-ripple"></span>
                                                            </div>
                                                            <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                <ul class="mdc-list">
                                                                    <?php if (!empty($staffInfo->department)) { ?>
                                                                        <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $staffInfo->department_id; ?>" aria-selected="true">
                                                                            <?php echo $staffInfo->department; ?></li>
                                                                    <?php } ?>
                                                                    <?php if (!empty($departments)) {
                                                                        foreach ($departments as $rl) { ?>
                                                                            <li class="mdc-list-item" data-value="<?php echo $rl->dept_id ?>">
                                                                                <span class="mdc-list-item__text">
                                                                                    <?php echo $rl->name ?>
                                                                                </span>
                                                                            </li>
                                                                    <?php }
                                                                    } ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <div class="mdc-select-shift mdc-select form-group mdc-select--required mb-0">
                                                            <div class="mdc-select__anchor demo-width-class" aria-required="true">
                                                                <span class="mdc-select__ripple"></span>
                                                                <input type="text" class="mdc-select__selected-text" id="selected-shift" value="<?php echo !empty($staffInfo->shift_name) ? $staffInfo->shift_name . ' - ' . date('H:i', strtotime($staffInfo->start_time)) . ' To ' . date('H:i', strtotime($staffInfo->end_time)) : ''; ?>" required>
                                                                <i class="mdc-select__dropdown-icon"></i>
                                                                <span class="mdc-floating-label">Select Shift</span>
                                                                <span class="mdc-line-ripple"></span>
                                                            </div>
                                                            <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                <ul class="mdc-list">
                                                                    <?php if (!empty($shiftsInfo)) {
                                                                        foreach ($shiftsInfo as $rl) { ?>
                                                                            <li class="mdc-list-item <?php echo (!empty($staffInfo->shift_code) && $staffInfo->shift_code == $rl->shift_code) ? 'mdc-list-item--selected' : ''; ?>" data-value="<?php echo $rl->shift_code ?>" onclick="selectShift('<?php echo $rl->shift_code ?>', '<?php echo $rl->name.' - '. date('H:i',strtotime($rl->start_time)).' To '.date('H:i',strtotime($rl->end_time)); ?>')">
                                                                                <span class="mdc-list-item__text">
                                                                                    <?php echo $rl->name.' - '. date('H:i',strtotime($rl->start_time)).' To '.date('H:i',strtotime($rl->end_time)); ?>
                                                                                </span>
                                                                            </li>
                                                                    <?php }
                                                                    } ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <div class="mdc-select mdc-select-blood-group form-group mb-0">
                                                            <div class="mdc-select__anchor demo-width-class">
                                                                <span class="mdc-select__ripple"></span>
                                                                <input type="text" class="mdc-select__selected-text" name="blood_group" id="blood_group" value="">
                                                                <i class="mdc-select__dropdown-icon"></i>
                                                                <span class="mdc-floating-label">Select Blood Group</span>
                                                                <span class="mdc-line-ripple"></span>
                                                            </div>
                                                            <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                <ul class="mdc-list">
                                                                    <?php if (!empty($staffInfo->blood_group)) { ?>
                                                                        <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $staffInfo->blood_group; ?>" aria-selected="true">
                                                                            <?php echo $staffInfo->blood_group; ?>
                                                                        </li>
                                                                    <?php } ?>
                                                                    <li class="mdc-list-item" data-value="A+">
                                                                        <span class="mdc-list-item__text">A+</span>
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="A-">
                                                                        <span class="mdc-list-item__text">A-</span>
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="B+">
                                                                        <span class="mdc-list-item__text">B+</span>
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="B-">
                                                                        <span class="mdc-list-item__text">B-</span>
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="AB+">
                                                                        <span class="mdc-list-item__text">AB+</span>
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="AB-">
                                                                        <span class="mdc-list-item__text">AB-</span>
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="O+">
                                                                        <span class="mdc-list-item__text">O+</span>
                                                                    </li>
                                                                    <li class="mdc-list-item" data-value="O-">
                                                                        <span class="mdc-list-item__text">O-</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label class="aadhar_no mdc-text-field mdc-text-field--filled">
                                                            <span class="mdc-text-field__ripple"></span>
                                                            <input name="aadhar_no" id="aadhar_no" class="mdc-text-field__input digits" value="<?php echo $staffInfo->aadhar_no; ?>" type="text" pattern="[0-9]*" maxlength="12" minlength="12" onkeypress="return isNumberKey(event)" autocomplete="off">
                                                            <span class="mdc-floating-label" id="my-label-id">Aadhaar Number
                                                                (optional)</span>
                                                            <span class="mdc-line-ripple"></span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="pan_no mdc-text-field mdc-text-field--filled">
                                                            <span class="mdc-text-field__ripple"></span>
                                                            <input name="pan_no" id="pan_no"
                                                                class="mdc-text-field__input"
                                                                value="<?php echo $staffInfo->pan_no; ?>" type="text"
                                                                maxlength="10" minlength="10" autocomplete="off" 
                                                                style="text-transform: uppercase;"
                                                                onkeypress="return isPanKey(event)"
                                                                oninput="this.value = this.value.toUpperCase()">
                                                            <span class="mdc-floating-label" id="my-label-id">PAN Number
                                                                (optional)</span>
                                                            <span class="mdc-line-ripple"></span>
                                                        </label>
                                                        <span class="error_message" style="color: red;"></span>

                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label class="voter_no mdc-text-field mdc-text-field--filled">
                                                            <span class="mdc-text-field__ripple"></span>
                                                            <input name="voter_no" id="voter_no" maxlength="10" minlength="10" class="mdc-text-field__input digits" value="<?php echo $staffInfo->voter_no; ?>" type="text" autocomplete="off">
                                                            <span class="mdc-floating-label" id="my-label-id">Voter ID
                                                                No.(optional)</span>
                                                            <span class="mdc-line-ripple"></span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="qualification mdc-text-field mdc-text-field--filled">
                                                            <span class="mdc-text-field__ripple"></span>
                                                            <input name="qualification" id="qualification" class="mdc-text-field__input digits" value="<?php echo $staffInfo->qualification; ?>" type="text" autocomplete="off">
                                                            <span class="mdc-floating-label" id="my-label-id">Maximum Qualification</span>
                                                            <span class="mdc-line-ripple"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label class="address mdc-text-field mdc-text-field--filled">
                                                            <span class="mdc-text-field__ripple"></span>
                                                            <input name="address" id="address" class="mdc-text-field__input" type="text" aria-labelledby="my-label-id" value="<?php echo $staffInfo->address; ?>" autocomplete="off">
                                                            <span class="mdc-floating-label" id="my-label-id">Address
                                                                (Optional)</span>
                                                            <span class="mdc-line-ripple"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label class="date_resignation mdc-text-field mdc-text-field--filled do_resign">
                                                            <span class="mdc-text-field__ripple"></span>
                                                            <input name="resign_date" id="resign_date" class="mdc-text-field__input datepicker_doj" type="text" value="<?php if ($staffInfo->resignation_date == '' || $staffInfo->resignation_date == '0000-00-00' || $staffInfo->resignation_date == '1970-01-01') {
                                                                                                                                                                            echo '';
                                                                                                                                                                        } else {
                                                                                                                                                                            echo date('d-m-Y', strtotime($staffInfo->resignation_date));
                                                                                                                                                                        } ?>" aria-labelledby="my-label-id" autocomplete="off">
                                                            <span class="mdc-floating-label" id="my-label-id"> Resignation
                                                                Date
                                                                (Optional)</span>
                                                            <span class="mdc-line-ripple"></span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="date_retirement mdc-text-field mdc-text-field--filled ">
                                                            <span class="mdc-text-field__ripple"></span>
                                                            <input name="retirement_date" id="retirement_date" class="mdc-text-field__input datepicker_doj" type="text" value="<?php if ($staffInfo->retirement_date == '' || $staffInfo->retirement_date == '0000-00-00' || $staffInfo->retirement_date == '1970-01-01') {
                                                                                                                                                                                    echo '';
                                                                                                                                                                                } else {
                                                                                                                                                                                    echo date('d-m-Y', strtotime($staffInfo->retirement_date));
                                                                                                                                                                                } ?>" aria-labelledby="my-label-id" autocomplete="off">
                                                            <span class="mdc-floating-label" id="my-label-id"> Retirement
                                                                Date
                                                                (Optional)</span>
                                                            <span class="mdc-line-ripple"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label class="date_retired mdc-text-field mdc-text-field--filled ">
                                                            <span class="mdc-text-field__ripple"></span>
                                                            <input name="retired_date" id="retired_date" class="mdc-text-field__input datepicker_doj" type="text" value="<?php if ($staffInfo->retired_date == '' || $staffInfo->retired_date == '0000-00-00' || $staffInfo->retired_date == '1970-01-01') {
                                                                                                                                                                                echo '';
                                                                                                                                                                            } else {
                                                                                                                                                                                echo date('d-m-Y', strtotime($staffInfo->retired_date));
                                                                                                                                                                            } ?>" aria-labelledby="my-label-id" autocomplete="off">
                                                            <span class="mdc-floating-label" id="my-label-id"> Retired Date
                                                                (Optional)</span>
                                                            <span class="mdc-line-ripple"></span>
                                                        </label>
                                                    </div>

                                                    <?php if($role == ROLE_PRIMARY_ADMINISTRATOR || $staffID == '123456' || $role == ROLE_SUPER_ADMIN){ ?>
                                                        <div class="layout">
                                                            <div class="list-btn" style="margin-left:50px; margin-top:15px; display: flex; justify-content: flex-end;">
                                                                <label class="checkbox-btn">
                                                                    <input type="checkbox" id="leave_approved_status" name="leave_approved_status" value="<?php echo $staffInfo->leave_approved_status; ?>" <?php echo ($staffInfo->leave_approved_status == '1') ? 'checked' : ''; ?>>
                                                                    <span></span>
                                                                </label>
                                                                <label for="checkbox" style="margin-left: 10px;">Access for Leave Approval</label>
                                                            </div>
                                                        </div>
                                                        <script>
                                                            document.getElementById('leave_approved_status').addEventListener('change', function() {
                                                                this.value = this.checked ? '1' : '0';
                                                            });
                                                        </script>
                                                    <?php } ?>




                                                </div>
                                                <?php if ($role != ROLE_FINANCE_OFFICER) { ?>
                                                    <button type="submit" class="btn btn-success float-right"> Submit </button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form> <!-- form end -->
                        </div>

                        <div class="tab-pane fade" id="bank" role="tabpanel" aria-labelledby="bank-tab">
                            <form role="form" action="<?php echo base_url() ?>updateStaffBank" method="post">
                                <input type="hidden" value="<?php echo $staffInfo->row_id; ?>" id="row_id" name="row_id">
                                <input type="hidden" value="<?php echo $staffInfo->staff_id; ?>" id="staff_id_new" name="staff_id">
                                <input type="hidden" value="<?php echo $bankInfo->row_id; ?>" id="bank_row_id" name="bank_row_id">
                                <br>
                                <!-- <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="bank_name mdc-text-field mdc-text-field--filled">
                                    <span class="mdc-text-field__ripple"></span>
                                    <input name="bank_name"  id="bank_name" class="mdc-text-field__input" value="<?php echo $bankInfo->bank_name; ?>" placeholder="Enter Bank Name" type="text"  aria-labelledby="my-label-id" autocomplete="off">
                                    <span class="mdc-floating-label" id="my-label-id">Bank Name</span>
                                    <span class="mdc-line-ripple"></span>
                                </label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="branch_name mdc-text-field mdc-text-field--filled">
                                    <span class="mdc-text-field__ripple"></span>
                                    <input name="branch_name"  id="branch_name" class="mdc-text-field__input" value="<?php echo $bankInfo->branch_name; ?>" placeholder="Enter Branch Name" type="text"  aria-labelledby="my-label-id" autocomplete="off">
                                    <span class="mdc-floating-label" id="my-label-id">Branch Name</span>
                                    <span class="mdc-line-ripple"></span>
                                </label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="ifsc_code mdc-text-field mdc-text-field--filled">
                                        <span class="mdc-text-field__ripple"></span>
                                        <input name="ifsc_code"  id="ifsc_code" class="mdc-text-field__input" value="<?php echo $bankInfo->ifsc_code; ?>" placeholder="Enter IFSC Code" type="text"  aria-labelledby="my-label-id" autocomplete="off">
                                        <span class="mdc-floating-label" id="my-label-id">IFSC Code</span>
                                        <span class="mdc-line-ripple"></span>
                                    </label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="account_no mdc-text-field mdc-text-field--filled">
                                        <span class="mdc-text-field__ripple"></span>
                                        <input name="account_no"  id="account_no" class="mdc-text-field__input" value="<?php echo $bankInfo->account_no; ?>" placeholder="Enter Account No." type="text"  aria-labelledby="my-label-id" autocomplete="off">
                                        <span class="mdc-floating-label" id="my-label-id">Account No.</span>
                                        <span class="mdc-line-ripple"></span>
                                    </label>
                                </div>
                            </div> -->
                                <button type="submit" class="btn btn-success float-right"> Update </button>
                            </form>
                        </div>

                        <div class="<?= ($active == "changepass") ? "active" : "" ?> tab-pane fade mx-auto" id="changePassword" role="tabpanel" aria-labelledby="password-tab">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 pr-0 ">
                                    <div class="card card-small c-border mb-4 p-1">
                                        <div class="card-header text-center">
                                            <?php if (!empty($profileImg)) { ?>
                                                <img src="<?php echo $profileImg; ?>" class="avatar rounded-circle img-thumbnail" width="130" height="130" alt="Profile Image">
                                            <?php } else { ?>
                                                <img src="<?php echo base_url(); ?>assets/images/user.png" class="avatar rounded-circle img-thumbnail" width="130" height="130" name="userfile" alt="Profile default">
                                            <?php } ?>

                                        </div>
                                        <div class="card-body profile_sidebar pt-0 pl-0 pr-0 mt-1">

                                            <table class="table profile_table mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th><i class="fa fa-id-card"></i> ID <span class="float-right">:</span></th>
                                                        <td>
                                                            <?php echo $staffInfo->staff_id; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fa fa-calendar"></i> DOB <span class="float-right">:</span></th>
                                                        <td>
                                                            <?php if ($staffInfo->dob == '0000-00-00' || empty($staffInfo->dob)) {
                                                                echo '<span class="text-danger">Not Updated</span>';
                                                            } else {
                                                                echo date('d-m-Y', strtotime($staffInfo->dob));
                                                            } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-mobile-alt"></i> MOB. <span class="float-right">:</span></th>
                                                        <td>
                                                            <?php if (!empty($staffInfo->mobile_one)) {
                                                                echo $staffInfo->mobile_one;
                                                            } else {
                                                                echo '<span class="text-danger">Not Updated</span>';
                                                            } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-envelope"></i> EMAIL. <span class="float-right">:</span></th>
                                                        <td>
                                                            <?php if (!empty($staffInfo->email)) {
                                                                echo $staffInfo->email;
                                                            } else {
                                                                echo '<span class="text-danger">Not Updated</span>';
                                                            } ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr class="mt-1 mb-1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 justify-content-center align-self-center">
                                    <form role="form" method="post" action="<?php echo base_url() . 'changePasswordAdminSchool/' . $staffInfo->row_id; ?>">
                                        <!-- <div class="input-group mb-2 profile_changePassword">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text material-icons">lock</span>
                                    </div>
                                    <input type="password" class="form-control" placeholder="Old password"
                                        id="oldPassword" name="oldPassword" autocomplete="off" required />
                                </div> -->
                                        <div class="input-group mb-2 profile_changePassword">
                                            <label class="password mdc-text-field mdc-text-field--filled">
                                                <span class="mdc-text-field__ripple"></span>
                                                <input name="newPassword" id="password" class="mdc-text-field__input" type="password" aria-labelledby="my-label-id" value="" autocomplete="off" required>
                                                <span class="mdc-floating-label" id="my-label-id">New Password</span>
                                                <span class="mdc-line-ripple"></span>
                                            </label>
                                        </div>
                                        <div class="input-group mb-2 profile_changePassword">
                                            <label class="cNewPassword mdc-text-field mdc-text-field--filled">
                                                <span class="mdc-text-field__ripple"></span>
                                                <input name="cNewPassword" id="cNewPassword" class="mdc-text-field__input" type="password" aria-labelledby="my-label-id" value="" autocomplete="off" required>
                                                <span class="mdc-floating-label" id="my-label-id">Re-Type Password</span>
                                                <span class="mdc-line-ripple"></span>
                                            </label>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-success ">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="tab-pane fade mt-2" id="subject" role="tabpanel"
                        aria-labelledby="subject-tab"><div class="row">
                            <div class="col-12">
                                <button type="button" data-toggle="modal" data-target="#assignSubjects" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add Subject</button>
                                <h5 class="text-center font-weight-bold">Assigned Subjects/Class</h5>
                                <div class="form-row">
                                    <table class="table table-bordered text-dark mb-0">
                                        <thead class="text-center">
                                            <tr class="table_row_background">
                                                <th>Subject Code</th>
                                                <th>Subject Name</th>
                                                <th>Subject Type</th>
                                                <th>Class</th>
                                                <th>Section</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($staffSubjectInfo)) {
                                                foreach ($staffSubjectInfo as $staff) { ?>
                                                <tr class="text-center">
                                                    <th><?php echo $staff->subject_code; ?></th>
                                                    <th><?php echo $staff->sub_name; ?></th>
                                                    <th><?php echo $staff->subject_type; ?></th>
                                                    <th><?php echo $staff->term_name; ?></th>
                                                    <th><?php echo $staff->section_name; ?></th>
                                                    <td>
                                                        <?php if ($role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_VICE_PRINCIPAL || $role == ROLE_ADMIN) { ?>
                                                        <a class="btn btn-xs btn-danger deleteStaffSubject" href="#" data-row_id="<?php echo $staff->row_id; ?>" title="Delete Subject"><i class="fa fa-trash"></i></a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php }
                                            } else { ?>
                                                <tr class="text-center">
                                                    <th colspan="6" style="background-color: #83c8ea7d;">Subject not assigned</th>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> -->
                        <div class="tab-pane fade mt-2" id="subject" role="tabpanel" aria-labelledby="subject-tab">

                            <div class="row">

                                <div class="col-12">

                                    <button type="button" data-toggle="modal" data-target="#assignSubjects" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add Subject</button>

                                    <h5 class="text-center font-weight-bold">Assigned Subjects</h5>

                                    <div class="form-row">

                                        <table class="table table-bordered text-dark mb-0">

                                            <thead class="text-center">

                                                <tr class="table_row_background">

                                                    <th>Subject Code</th>

                                                    <th>Subject Name</th>

                                                    <th>Subject Type</th>

                                                    <th>Department</th>

                                                    <th>Actions</th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                                <?php if (!empty($staffSubjectInfo)) {

                                                    foreach ($staffSubjectInfo as $staff) { ?>

                                                        <tr class="text-center">

                                                            <th><?php echo $staff->subject_code; ?></th>

                                                            <th><?php echo $staff->sub_name; ?></th>

                                                            <th><?php echo $staff->subject_type; ?></th>

                                                            <th><?php echo $staff->name; ?></th>

                                                            <td>

                                                                <?php if ($role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_ADMIN || $role == ROLE_OFFICE || $role == ROLE_SUPER_ADMIN) { ?>

                                                                    <a class="btn btn-xs btn-danger deleteStaffSubject" href="#" data-row_id="<?php echo $staff->row_id; ?>" title="Delete Subject"><i class="fa fa-trash"></i></a>

                                                                <?php } ?>

                                                            </td>

                                                        </tr>

                                                    <?php }
                                                } else { ?>

                                                    <tr class="text-center">

                                                        <th colspan="5" style="background-color: #83c8ea7d;">Subject not
                                                            assigned</th>

                                                    </tr>

                                                <?php } ?>

                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            </div>

                        </div>



                        <div class="tab-pane fade mt-2" id="section" role="tabpanel" aria-labelledby="section-tab">

                            <div class="row">

                                <div class="col-12">

                                    <button type="button" data-toggle="modal" data-target="#assignSection" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add Class</button>

                                    <h5 class="text-center font-weight-bold">Assigned Class</h5>

                                    <div class="form-row">

                                        <table class="table table-bordered text-dark mb-0">

                                            <thead class="text-center">

                                                <tr class="table_row_background">

                                                    <th>Term Name</th>

                                                    <th>Stream Name</th>

                                                    <th>Section</th>

                                                    <th>Actions</th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                                <?php if (!empty($staffSectionInfo)) {

                                                    foreach ($staffSectionInfo as $staff) { ?>

                                                        <tr class="text-center">

                                                            <th><?php echo $staff->term_name; ?></th>

                                                            <th><?php echo $staff->stream_name; ?></th>

                                                            <th><?php echo $staff->section_name; ?></th>

                                                            <td>

                                                                <?php if ($role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_ADMIN || $role == ROLE_OFFICE || $role == ROLE_SUPER_ADMIN) { ?>

                                                                    <a class="btn btn-xs btn-danger deleteStaffSection" href="#" data-row_id="<?php echo $staff->row_id; ?>" title="Delete Class"><i class="fa fa-trash"></i></a>

                                                                <?php } ?>

                                                            </td>

                                                        </tr>

                                                    <?php }
                                                } else { ?>

                                                    <tr class="text-center">

                                                        <th colspan="4" style="background-color: #83c8ea7d;">Class not assigned
                                                        </th>

                                                    </tr>

                                                <?php } ?>

                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            </div>

                        </div>
                        <div class="tab-pane fade" id="resign" role="tabpanel" aria-labelledby="resign-tab">
                            <div class="row">
                                <div class="col-lg-12 col-md-8 col-12 mt-2">
                                    <form role="form" action="<?php echo base_url() ?>updateResignationInfo" method="post">
                                        <input type="hidden" value="<?php echo $staffInfo->row_id; ?>" id="row_id" name="row_id">
                                        <input type="hidden" value="<?php echo $staffInfo->staff_id; ?>" name="staff_id" />

                                        <div class="row mt-3 mr-3">
                                            <div class="col-12 col-lg-12 col-md-12">
                                                <button type="submit" class="btn btn-success float-right"> Update </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="feedback" role="tabpanel" aria-labelledby="feedback-tab">
                            <!-- Content for Tab 2 -->
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col profile-head">
                                            <ul class="nav nav-tabs" id="myTab1" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link btn-primary" id="feedbackInfo-tab" href="<?php echo base_url(); ?>viewStudentFeedbackOfStaff/<?php echo $staffInfo->row_id; ?>" role="tab" aria-selected="false">Feedback Info</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link btn-secondary ml-2" id="feedbackPrint-tab" href="<?php echo base_url(); ?>pintStudentFeedbackResponse_23/<?php echo $staffInfo->row_id; ?>" role="tab" aria-selected="false">Feedback Print</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="OTInfo" role="tabpanel" aria-labelledby="OTInfo-tab">
                            <input type="hidden" value="<?php echo $staffInfo->row_id; ?>" id="row_id" name="row_id">
                            <input type="hidden" value="<?php echo $staffInfo->staff_id; ?>" name="staff_id" />

                            <button class="btn btn-primary float-right mobile-btn border_right_radius mr-1" data-toggle="modal" data-target="#addOTInfoModel"><i class="fa fa-plus"></i>
                                Add OT</button>

                            <div class="table-responsive pt-1">
                                <table class="table table-bordered table_edit_student_intstallment ">
                                    <tr>
                                        <th class="tbl-head1 text-center" colspan="7" width="100">OT DETAILS</th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-head1" width="100">Date</th>
                                        <th class="tbl-head1" width="100">No of Hours</th>
                                        <th class="tbl-head1" width="100">Amount per Hour</th>
                                        <th class="tbl-head1" width="100">Total Amount</th>
                                        <th class="tbl-head1" width="100">Action</th>
                                    </tr>

                                    <?php if (!empty($OTInfo)) {
                                        foreach ($OTInfo as $record) { ?>
                                            <tr>
                                                <td style="color:black">
                                                    <b><?php echo date('d-m-Y', strtotime($record->date)); ?></b>
                                                </td>
                                                <td style="color:black">
                                                    <b><?php echo $record->no_of_hours; ?></b>
                                                </td>
                                                <td style="color:black">
                                                    <b><?php echo $record->ot_amount; ?></b>
                                                </td>
                                                <td style="color:black">
                                                    <b><?php echo $record->total_ot_amount; ?></b>
                                                </td>
                                                <td> <a class="btn btn-xs btn-secondary" href="#" onclick="openOTEditModel('<?php echo $record->row_id ?>','<?php echo date('d-m-Y', strtotime($record->date)) ?>','<?php echo $record->no_of_hours ?>','<?php echo $record->ot_amount ?>','<?php echo $record->total_ot_amount ?>')" title="Edit"><i class="fas fa-edit"></i></i></a>

                                                </td>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td class="text-center" colspan="8"><strong>OT Info not found.</strong></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="AdvancePayment" role="tabpanel"  aria-labelledby="AdvancePayment-tab">
                            <button class="btn btn-primary float-right mobile-btn border_right_radius mr-1 mt-1"
                                data-toggle="modal" data-target="#addAdvanceSalaryNewDocModel"><i
                                    class="fa fa-plus"></i>
                                Add Advance Payment</button>

                                <div class="table-responsive pt-1">
                                    <table class="table table-bordered table_edit_student ">
                                        <tr class = "text-center">
                                            <th class="tbl-head" width="100">Date</th>
                                            <th class="tbl-head" width="100">Amount</th>
                                            <th class="tbl-head" width="100">Type</th>
                                            <th class="tbl-head" width="100">Repayment Period</th>
                                            <th class="tbl-head" width="100">Installment Amount</th>
                                            <th class="tbl-head" width="100">Action</th>
                                        </tr>
                                    
                                        <?php if(!empty($AdvancePaymentInfo)){
                                            foreach($AdvancePaymentInfo as $record){ ?>
                                        <tr class = "text-center">
                                            <td style="color:black">
                                                <b><?php echo date('d-m-Y', strtotime($record->date)); ?></b>
                                            </td>
                                            <td style="color:black">
                                                <b><?php echo $record->advance_amount; ?></b></td> 
                                            <td style="color:black">
                                                <b><?php echo $record->payment_type; ?></b>
                                            </td>
                                            <td style="color:black">
                                                <b><?php echo $record->repayment_period ; ?> Months</b>
                                            </td>
                                            <td style="color:black">
                                                <b><?php echo $record->installment_amount; ?></b>
                                            </td>
                                            <td> <a class="btn btn-xs btn-secondary"  href="#" onclick="openTimeTableModel('<?php echo $record->row_id ?>','<?php echo date('d-m-Y',strtotime($record->date)) ?>','<?php echo $record->advance_amount ?>','<?php echo $record->payment_type ?>','<?php echo $record->installment_amount ?>','<?php echo $record->dd_number ?>',
                                            '<?php echo date('d-m-Y',strtotime($record->dd_date)) ?>','<?php echo $record->bank_tran_number ?>','<?php echo date('d-m-Y',strtotime($record->bank_tran_date)) ?>','<?php echo $record->bank_name ?>',
                                            '<?php echo date('d-m-Y',strtotime($record->neft_date)) ?>','<?php echo $record->ref_number ?>','<?php echo $record->upi_number ?>','<?php echo $record->repayment_period ?>')" title="Edit"><i class="fas fa-edit"></i></i></a>

                                            </td>
                                        </tr>
                                        <?php } }else{?>
                                                        <tr>
                                                            <td class="text-center" class="tbl-head" colspan="8"><strong>Advance Payment not found.</strong></td>
                                                        </tr>
                                            <?php }?>
                                    </table>
                                    <hr>
                                    <table class="table table-bordered table_edit_student ">
                                        <tr class = "text-center"><th class="tbl-head" colspan = "7">ADVANCE PAYMENT PENDING INFO</th></tr>
                                        <tr class = "text-center">
                                            <th class="tbl-head" width="100">Total Amount</th>
                                            <th class="tbl-head" width="100">Paid Amount</th>
                                            <th class="tbl-head" width="100">Pending Amount</th>
                                            <th class="tbl-head" width="100">Action</th>
                                        </tr>
                                    
                                        <?php if(!empty($AdvancePaymentInfo)){
                                            foreach($AdvancePaymentInfo as $record){ 
                                                $paid_amount = $salary_model->getAdvanceSalaryPaidInfo($record->staff_id,$record->row_id);
                                                $pending_amount = $record->advance_amount - $paid_amount;
                                                $installmentInfo = json_encode($salary_model->getAdvanceSalaryInstallmentInfo($record->staff_id, $record->row_id));
                                        ?>
                                        <tr class = "text-center">
                                            <td style="color:black">
                                                <b><?php echo $record->advance_amount; ?></b></td> 
                                            <td style="color:black">
                                            <?php if(empty($paid_amount)) {?>
                                                <b>0</b>
                                            <?php  }else{?>
                                                <b><?php echo $paid_amount; ?></b>
                                            <?php   }?></td> 
                                            <td style="color:black">
                                                <b><?php echo $pending_amount; ?></b></td>
                                            <td>
                                                <a class="btn btn-xs btn-info open-installment" data-installment='<?php echo $installmentInfo; ?>' href="#" title="Edit">
                                                    <i class="fas fa-eye"></i> view installment info</a>
                                            </td>
                                        </tr>
                                        <?php } }else{?>
                                                        <tr>
                                                            <td class="text-center" class="tbl-head" colspan="8"><strong>Advance Payment not found.</strong></td>
                                                        </tr>
                                            <?php }?>
                                    </table>
                                </div>
                        </div>
                        <div class="tab-pane fade" id="observation" role="tabpanel" aria-labelledby="observation-tab">
                            <?php if ($role == ROLE_SUPER_ADMIN || $role == ROLE_PRINCIPAL || $staffID == '123456') { ?>
                                <button class="btn btn-primary float-right mobile-btn border_right_radius mr-1" data-toggle="modal" data-target="#addNewDocModel"><i class="fa fa-plus"></i>
                                    Add Remark</button>
                            <?php } ?>

                            <div class="table-responsive pt-1">
                                <table class="table table-bordered table_edit_student ">
                                    <tr>
                                        <th class="tbl-head1" width="100">Date</th>
                                        <!-- <th class="tbl-head" width="100">Semester</th> -->
                                        <th class="tbl-head1" width="100">Remarks Type</th>
                                        <th class="tbl-head1" width="200">Remarks</th>
                                        <th class="tbl-head1" width="200">Management Reply</th>
                                        <th class="tbl-head1" width="100">Action</th>
                                    </tr>

                                    <?php foreach ($observationInfo as $record) { ?>
                                        <tr>
                                            <form role="form" id="editStaffRemarks" action="<?php echo base_url() ?>updateStaffRemarks" method="post">
                                                <input type="hidden" value="<?php echo $record->row_id; ?>" name="row_id" />
                                                <input type="hidden" value="<?php echo $staffInfo->row_id; ?>" name="row_Id" />
                                                <td style="color:black">
                                                    <!-- <b><?php //echo date('d-m-Y', strtotime($record->date)); 
                                                            ?></b> -->
                                                    <div class="form-group mb-0">
                                                        <input type="text" class="form-control datepicker" value="<?php echo date('d-m-Y', strtotime($record->date)); ?>" name="date" autocomplete="off" required />
                                                    </div>
                                                </td>
                                                <td style="color:black">
                                                    <div class="form-group mb-0">
                                                        <!-- <input type="text" class="form-control" value="<?php //echo $record->remark_name; ?>" name="type" autocomplete="off" required /> -->
                                                        <select class="form-control input-sm" name="type" required>
                                                            <?php if(!empty($record->remark_name)){?>
                                                                <option value="<?php echo $record->type; ?>"><?php echo $record->remark_name; ?></option>
                                                            <?php } ?>
                                                            <?php if (!empty($remarkNameInfo)) {
                                                                foreach ($remarkNameInfo as $obsinfo) { ?>
                                                                    <option value="<?php echo $obsinfo->row_id; ?>"><?php echo $obsinfo->remark_name; ?></option>
                                                            <?php }
                                                            } ?>
                                                        </select>

                                                    </div>
                                                </td>
                                                <td style="color:black">
                                                    <div class="form-group mb-0">
                                                        <textarea class="form-control" rows="5" name="description" required><?php echo $record->description; ?></textarea>
                                                    </div>
                                                </td>
                                                <td style="color:black">
                                                    <div class="form-group mb-0">
                                                        <textarea class="form-control" rows="5" name="management_reply" placeholder="Management Reply"><?php echo $record->management_reply; ?></textarea>
                                                    </div>
                                                </td>


                                                <td><?php if (!empty($record->file_path)) { ?>
                                                        <a href="<?php echo base_url(); ?><?php echo $record->file_path; ?>" download target="_blank" class="btn btn_download p-2"><i class="fa fa-download"></i></a>
                                                        <a href="<?php echo base_url(); ?><?php echo $record->file_path; ?>" target="_blank" class="btn btn-primary p-2"><i class="fa fa-eye"></i>
                                                            View</a>

                                                    <?php } ?>
                                                    <?php if ($staffID == '123456' || $role == ROLE_SUPER_ADMIN) { ?>

                                                        <input class="btn btn-success" type="submit" value="Update" />
                                                    <?php } ?>
                                                    <?php if ($staffID == '123456' || $role == ROLE_SUPER_ADMIN) { ?>
                                                        <a class="btn btn-xs btn-danger deleteStaffRemarkDetails" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                                    <?php } ?>

                                                </td>
                                            </form>

                                        </tr>
                                    <?php } ?>

                                </table>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="family" role="tabpanel" aria-labelledby="family-tab">
                            <!-- Content for Tab 2 -->
                            <ul class="list-group list-group-flush ">
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col profile-head">
                                            <ul class="nav nav-tabs" id="myTab1" role="tablist">
                                                <li class="nav-item ">
                                                    <a class="nav-link active" id="add_leave-tab" data-toggle="tab" href="#add_leave" role="tab" aria-controls="profile" aria-selected="false">Add Leave Info</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="used_leave-tab" data-toggle="tab" href="#used_leave" role="tab" aria-controls="profile" aria-selected="false">Used Leave Info</a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="tab-content profile-tab" id="myTab1Content">
                                <div class="tab-pane fade show active" id="add_leave" role="tabpanel" aria-labelledby="add_leave-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <?php //if(empty($leaveInfoNew)){ 
                                            ?>

                                            <?php //} 
                                            ?>

                                            <div class="form-row">
                                                <table class="table table-bordered text-dark mb-0">
                                                    <thead class="text-center">
                                                        <tr class="tbl-head1">
                                                            <th colspan="10"><span style="font-size:25px;"> Leave Info </span> <?php //if(empty($leaveInfoNew2024)){ 
                                                                                                                                ?><button type="button" data-toggle="modal" data-target="#addLeave" class="btn btn-secondary float-right"><i class="fa fa-plus"></i> Add Leave</button><?php //} 
                                                                                                                                                                                                                                                                                        ?></th>


                                                        </tr>
                                                        <tr class="tbl-head1">
                                                            <th>Year</th>
                                                            <th>Casual Leave</th>
                                                            <th>Medical Leave</th>
                                                            <th>Paternity Leave</th>
                                                            <th>Marriage Leave</th>
                                                            <th>Maternity Leave</th>
                                                            <!-- <th>Loss of Pay</th> -->
                                                            <th>Earned Leave</th>
                                                            <th>Official Duty</th>
                                                            <th>Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($leaveInfoNew)) {
                                                            for ($i = 0; $i < count($leaveInfoNew); $i++) { ?>
                                                                <tr class="text-center">
                                                                    <form role="form" action="<?php echo base_url() ?>updateLeaveInfoByStaffId" method="post" role="form">
                                                                        <input type="hidden" name="year" value="<?php echo $leaveInfoNew[$i]->year; ?>">
                                                                        <input type="hidden" value="<?php echo $staffInfo->row_id; ?>" name="row_id_leave"> <input type="hidden" value="<?php echo $staffInfo->staff_id; ?>" name="staff_id_leave" />

                                                                        <td class="text-center" style="width:100px;"><?php echo $leaveInfoNew[$i]->year; ?></td>
                                                                        <td><input class="text-center" type="text" style="width:100px;" name="casual_leave_earned" value="<?php echo $leaveInfoNew[$i]->casual_leave_earned; ?>"></td>
                                                                        <td><input class="text-center" type="text" style="width:100px;" name="sick_leave_earned" value="<?php echo $leaveInfoNew[$i]->sick_leave_earned; ?>"></td>
                                                                        <td><input class="text-center" type="text" style="width:100px;" name="paternity_leave_earned" value="<?php echo $leaveInfoNew[$i]->paternity_leave_earned; ?>"></td>
                                                                        <td><input class="text-center" type="text" style="width:100px;" name="marriage_leave_earned" value="<?php echo $leaveInfoNew[$i]->marriage_leave_earned; ?>"></td>
                                                                        <td><input class="text-center" type="text" style="width:100px;" name="maternity_leave_earned" value="<?php echo $leaveInfoNew[$i]->maternity_leave_earned; ?>"></td>
                                                                        <!-- <td><input class="text-center" type="text" style="width:100px;" name="lop_leave" value="<?php echo $leaveInfoNew[$i]->lop_leave; ?>"></td> -->
                                                                        <td><input class="text-center" type="text" style="width:100px;" name="earned_leave" value="<?php echo $leaveInfoNew[$i]->earned_leave; ?>"></td>
                                                                        <td><input class="text-center" type="text" style="width:100px;" name="official_duty_earned" value="<?php echo $leaveInfoNew[$i]->official_duty_earned; ?>"></td>
                                                                        <?php if ($leaveInfoNew[$i]->year == LEAVE_YEAR) { ?>
                                                                            <td> <input class=" text-center btn btn-success" type="submit" value="Update" /></td>

                                                                        <?php } else { ?>
                                                                            <td></td>
                                                                        <?php  }
                                                                        ?>
                                                                    </form>

                                                                </tr>
                                                            <?php }
                                                        } else { ?>
                                                            <tr class="text-center">
                                                                <th colspan="10" style="background-color: #83c8ea7d;">Leave not
                                                                    Updated</th>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="used_leave" role="tabpanel" aria-labelledby="used_leave-tab">
                                    <div class="row">
                                        <div class="col-12">

                                            <div class="form-row">
                                                <table class="table table-bordered text-dark mb-0">
                                                    <thead class="text-center">
                                                        <tr class="tbl-head1">
                                                            <th colspan="25"><span style="font-size:25px;"> Leave Info </span><br>
                                                                <span style="color:red;">(Note : T :- Total, U :- Used, P :- Pending)</span>
                                                            </th>
                                                        </tr>
                                                        <tr class="tbl-head1">
                                                            <th style="width:100px;" rowspan="2">Year</th>
                                                            <th style="width:50px;" colspan="3">Casual Leave</th>
                                                            <th style="width:100px;" colspan="3">Medical Leave</th>
                                                            <th style="width:100px;" colspan="3">Paternity Leave</th>
                                                            <th style="width:100px;" colspan="3">Marriage Leave</th>
                                                            <th style="width:100px;" colspan="3">Maternity Leave</th>
                                                            <th style="width:100px;" colspan="3">Official Duty</th>
                                                            <th style="width:100px;" colspan="3">Earned Leave</th>
                                                            <th style="width:100px;">Loss of Pay</th>



                                                        </tr>
                                                        <tr class="tbl-head1">
                                                            <th>T</th>
                                                            <th>U</th>
                                                            <th>P</th>

                                                            <th>T</th>
                                                            <th>U</th>
                                                            <th>P</th>

                                                            <th>T</th>
                                                            <th>U</th>
                                                            <th>P</th>

                                                            <th>T</th>
                                                            <th>U</th>
                                                            <th>P</th>

                                                            <th>T</th>
                                                            <th>U</th>
                                                            <th>P</th>

                                                            <th>T</th>
                                                            <th>U</th>
                                                            <th>P</th>

                                                            <th>T</th>
                                                            <th>U</th>
                                                            <th>P</th>

                                                            <th>U</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($leaveInfoNew)) {
                                                            for ($i = 0; $i < count($leaveInfoNew); $i++) { ?>
                                                                <tr class="text-center">
                                                                    <form role="form" action="<?php echo base_url() ?>updateLeaveInfoByStaffId" method="post" role="form">
                                                                        <input type="hidden" name="year" value="<?php echo $leaveInfoNew[$i]->year; ?>">
                                                                        <input type="hidden" value="<?php echo $staffInfo->row_id; ?>" name="row_id_leave"> <input type="hidden" value="<?php echo $staffInfo->staff_id; ?>" name="staff_id_leave" />
                                                                        <?php
                                                                        $used_leave_cl = $leaveModel->getLeaveUsedSum($staffInfo->staff_id, 'CL', $leaveInfoNew[$i]->year);
                                                                        $used_leave_el = $leaveModel->getLeaveUsedSum($staffInfo->staff_id, 'EL', $leaveInfoNew[$i]->year);
                                                                        $used_leave_ml = $leaveModel->getLeaveUsedSum($staffInfo->staff_id, 'ML', $leaveInfoNew[$i]->year);
                                                                        $used_leave_marl = $leaveModel->getLeaveUsedSum($staffInfo->staff_id, 'MARL', $leaveInfoNew[$i]->year);
                                                                        $used_leave_pl = $leaveModel->getLeaveUsedSum($staffInfo->staff_id, 'PL', $leaveInfoNew[$i]->year);
                                                                        $used_leave_matl = $leaveModel->getLeaveUsedSum($staffInfo->staff_id, 'MATL', $leaveInfoNew[$i]->year);
                                                                        $used_leave_lop = $leaveModel->getLeaveUsedSum($staffInfo->staff_id, 'LOP', $leaveInfoNew[$i]->year);
                                                                        $used_leave_od = $leaveModel->getLeaveUsedSum($staffInfo->staff_id, 'OD', $leaveInfoNew[$i]->year);
                                                                        $used_leave_wfh = $leaveModel->getLeaveUsedSum($staffInfo->staff_id, 'WFH', $leaveInfoNew[$i]->year);
                                                                        $used_leave_mgml = $leaveModel->getLeaveUsedSum($staffInfo->staff_id, 'MGML', $leaveInfoNew[$i]->year);
                                                                        ?>

                                                                        <td><?php echo $leaveInfoNew[$i]->year; ?></td>
                                                                        <td><?php echo $leaveInfoNew[$i]->casual_leave_earned; ?></td>
                                                                        <td><?php if (empty($used_leave_cl->total_days_leave)) {
                                                                                echo "0";
                                                                            } else {
                                                                                echo $used_leave_cl->total_days_leave;
                                                                            } ?></td>
                                                                        <td><?php if (empty($leaveInfoNew[$i]->casual_leave_earned - $used_leave_cl->total_days_leave)) {
                                                                                echo "0";
                                                                            } else {
                                                                                echo $leaveInfoNew[$i]->casual_leave_earned - $used_leave_cl->total_days_leave;
                                                                            } ?></td>
                                                                        <td><?php echo $leaveInfoNew[$i]->sick_leave_earned; ?></td>
                                                                        <td><?php if (empty($used_leave_ml->total_days_leave)) {
                                                                                echo "0";
                                                                            } else {
                                                                                echo $used_leave_ml->total_days_leave;
                                                                            } ?></td>
                                                                        <td><?php if (empty($leaveInfoNew[$i]->sick_leave_earned - $used_leave_ml->total_days_leave)) {
                                                                                echo "0";
                                                                            } else {
                                                                                echo $leaveInfoNew[$i]->sick_leave_earned - $used_leave_ml->total_days_leave;
                                                                            } ?></td>
                                                                        <td><?php echo $leaveInfoNew[$i]->paternity_leave_earned; ?></td>
                                                                        <td><?php if (empty($used_leave_pl->total_days_leave)) {
                                                                                echo "0";
                                                                            } else {
                                                                                echo $used_leave_pl->total_days_leave;
                                                                            } ?></td>
                                                                        <td><?php if (empty($leaveInfoNew[$i]->paternity_leave_earned - $used_leave_pl->total_days_leave)) {
                                                                                echo "0";
                                                                            } else {
                                                                                echo $leaveInfoNew[$i]->paternity_leave_earned - $used_leave_pl->total_days_leave;
                                                                            } ?></td>
                                                                        <td><?php echo $leaveInfoNew[$i]->marriage_leave_earned; ?></td>
                                                                        <td><?php if (empty($used_leave_marl->total_days_leave)) {
                                                                                echo "0";
                                                                            } else {
                                                                                echo $used_leave_marl->total_days_leave;
                                                                            } ?></td>
                                                                        <td><?php if (empty($leaveInfoNew[$i]->marriage_leave_earned - $used_leave_marl->total_days_leave)) {
                                                                                echo "0";
                                                                            } else {
                                                                                echo $leaveInfoNew[$i]->marriage_leave_earned - $used_leave_marl->total_days_leave;
                                                                            } ?></td>
                                                                        <td><?php echo $leaveInfoNew[$i]->maternity_leave_earned; ?></td>
                                                                        <td><?php if (empty($used_leave_matl->total_days_leave)) {
                                                                                echo "0";
                                                                            } else {
                                                                                echo $used_leave_matl->total_days_leave;
                                                                            } ?></td>
                                                                        <td><?php if (empty($leaveInfoNew[$i]->maternity_leave_earned - $used_leave_matl->total_days_leave)) {
                                                                                echo "0";
                                                                            } else {
                                                                                echo $leaveInfoNew[$i]->maternity_leave_earned - $used_leave_matl->total_days_leave;
                                                                            } ?></td>
                                                                        
                                                                        <td><?php echo $leaveInfoNew[$i]->official_duty_earned; ?></td>
                                                                        <td><?php if (empty($used_leave_od->total_days_leave)) {
                                                                                echo "0";
                                                                            } else {
                                                                                echo $used_leave_od->total_days_leave;
                                                                            } ?></td>
                                                                        <td><?php if (empty($leaveInfoNew[$i]->official_duty_earned - $used_leave_od->total_days_leave)) {
                                                                                echo "0";
                                                                            } else {
                                                                                echo $leaveInfoNew[$i]->official_duty_earned - $used_leave_od->total_days_leave;
                                                                            } ?></td>
                                                                        
                                                                        <td><?php echo $leaveInfoNew[$i]->earned_leave; ?></td>
                                                                        <td><?php if (empty($used_leave_el->total_days_leave)) {
                                                                                echo "0";
                                                                            } else {
                                                                                echo $used_leave_el->total_days_leave;
                                                                            } ?></td>
                                                                        <td><?php if (empty($leaveInfoNew[$i]->earned_leave - $used_leave_el->total_days_leave)) {
                                                                                echo "0";
                                                                            } else {
                                                                                echo $leaveInfoNew[$i]->earned_leave - $used_leave_el->total_days_leave;
                                                                            } ?></td>

                                                                        <td><?php if (empty($used_leave_lop->total_days_leave)) {
                                                                                echo "0";
                                                                            } else {
                                                                                echo $used_leave_lop->total_days_leave;
                                                                            } ?></td>
                                                                       





                                                                    </form>

                                                                </tr>
                                                            <?php }
                                                        } else { ?>
                                                            <tr class="text-center">
                                                                <th colspan="25" style="background-color: #83c8ea7d;">Leave not
                                                                    Updated</th>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="salaryInfo" role="tabpanel" aria-labelledby="salaryInfo-tab">

                            <br>
                            <div class="row mb-0">

                                <div class="col-lg-12 col-md-8 col-12 mb-0">
                                    <form role="form" action="<?php echo base_url() ?>updateSalaryInfo"
                                        method="post">
                                        <input type="hidden" value="<?php echo $bankInfo->row_id; ?>"
                                            id="bank_row_id" name="bank_row_id">
                                        <input type="hidden" value="<?php echo $staffInfo->row_id; ?>" id="row_id"
                                            name="row_id">
                                        <input type="hidden" value="<?php echo $staffInfo->staff_id; ?>"
                                            name="staff_id" />
                                        <div class="form-row">
                                            <div class="form-group col-md-4 custom-col-3-5">
                                                <label class="uan_no mdc-text-field mdc-text-field--filled">
                                                    <span class="mdc-text-field__ripple"></span>
                                                    <input name="uan_no" id="uan_no"
                                                        class="mdc-text-field__input digits"
                                                        value="<?php echo $staffInfo->uan_no; ?>" type="text"
                                                        onkeypress="return isNumberKey(event)" autocomplete="off">
                                                    <span class="mdc-floating-label" id="my-label-id">UNIVERSAL ACCOUNT NUMBER (UAN) </span>
                                                    <span class="mdc-line-ripple"></span>
                                                </label>
                                            </div>
                                            
                                            <div class="form-group col-md-3">
                                                <div
                                                    class="mdc-select-designation mdc-select form-group">
                                                    <div class="mdc-select__anchor demo-width-class"
                                                        aria-required="true">
                                                        <span class="mdc-select__ripple"></span>
                                                        <input type="text" class="mdc-select__selected-text"
                                                            name="designation" id="designation" value="">
                                                        <i class="mdc-select__dropdown-icon"></i>
                                                        <span class="mdc-floating-label">DESIGNATION</span>
                                                        <span class="mdc-line-ripple"></span>
                                                    </div>
                                                    <div
                                                        class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                        <ul class="mdc-list">
                                                            <?php if(!empty($staffInfo->designation)){ ?>
                                                            <li class="mdc-list-item mdc-list-item--selected"
                                                                data-value="<?php echo $staffInfo->designation; ?>"
                                                                aria-selected="true">
                                                                <?php echo $staffInfo->designation; ?></li>
                                                            <?php } ?>
                                                            <?php   if(!empty($salaryDesignationInfo)) {
                                                            foreach ($salaryDesignationInfo as $type) { ?>
                                                            <li class="mdc-list-item"
                                                                data-value="<?php echo $type->row_id ?>">
                                                                <span class="mdc-list-item__text">
                                                                    <?php echo $type->designation ?>
                                                                </span>
                                                            </li>
                                                            <?php } } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- <div class="form-group col-md-2">
                                                <div
                                                    class="mdc-select-tax_regime mdc-select form-group">
                                                    <div class="mdc-select__anchor demo-width-class"
                                                        aria-required="true">
                                                        <span class="mdc-select__ripple"></span>
                                                        <input type="text" class="mdc-select__selected-text"
                                                            name="tax_regime" id="tax_regime" value="">
                                                        <i class="mdc-select__dropdown-icon"></i>
                                                        <span class="mdc-floating-label">TAX REGIME</span>
                                                        <span class="mdc-line-ripple"></span>
                                                    </div>
                                                    <div
                                                        class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                        <ul class="mdc-list">
                                                            <?php if(!empty($staffInfo->tax_regime)){ ?>
                                                            <li class="mdc-list-item mdc-list-item--selected"
                                                                data-value="<?php echo $staffInfo->tax_regime; ?>"
                                                                aria-selected="true">
                                                                <?php echo $staffInfo->tax_regime; ?></li>
                                                            <?php } ?>
                                                            <?php   if(!empty($taxRegimeTypeInfo)) {
                                                            foreach ($taxRegimeTypeInfo as $type) { ?>
                                                            <li class="mdc-list-item"
                                                                data-value="<?php echo $type->type ?>">
                                                                <span class="mdc-list-item__text">
                                                                    <?php echo $type->type ?>
                                                                </span>
                                                            </li>
                                                            <?php } } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="form-group col-md-2">
                                                <label class="esi_code mdc-text-field mdc-text-field--filled">
                                                    <span class="mdc-text-field__ripple"></span>
                                                    <input name="esi_code" id="esi_code" class="mdc-text-field__input digits" value="<?php echo $staffInfo->esi_code; ?>" type="text" placeholder="Enter Esi Code" autocomplete="off" onkeypress="return isEsiCodeKey(event)" oninput="filterEsiCodeInput(this)">
                                                    <span class="mdc-floating-label" id="my-label-id">ESI CODE</span>
                                                    <span class="mdc-line-ripple"></span>
                                                </label>
                                            </div>
                                            <div class="form-group col-md-4 custom-col-3-5">
                                                <label class="pf_number mdc-text-field mdc-text-field--filled">
                                                    <span class="mdc-text-field__ripple"></span>
                                                    <input name="pf_number" id="pf_number" class="mdc-text-field__input digits" value="<?php echo $staffInfo->pf_number; ?>" type="text" placeholder="Enter Pf Account No" autocomplete="off" onkeypress="return isEsiCodeKey(event)" oninput="filterEsiCodeInput(this)">
                                                    <span class="mdc-floating-label" id="my-label-id">PF ACCOUNT NO</span>
                                                    <span class="mdc-line-ripple"></span>
                                                </label>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="bank_name mdc-text-field mdc-text-field--filled">
                                                    <span class="mdc-text-field__ripple"></span>
                                                    <input name="bank_name" id="bank_name" class="mdc-text-field__input"
                                                        value="<?php echo $bankInfo->bank_name; ?>" placeholder="Enter Bank Name"
                                                        type="text" aria-labelledby="my-label-id" autocomplete="off"
                                                        onkeypress="return isBankNameKey(event)" oninput="filterBankNameInput(this)" >
                                                    <span class="mdc-floating-label" id="my-label-id">BANK NAME</span>
                                                    <span class="mdc-line-ripple"></span>
                                                </label>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="branch_name mdc-text-field mdc-text-field--filled">
                                                    <span class="mdc-text-field__ripple"></span>
                                                    <input name="branch_name" id="branch_name" class="mdc-text-field__input"
                                                        value="<?php echo $bankInfo->branch_name; ?>"
                                                        placeholder="Enter Branch Name" type="text" aria-labelledby="my-label-id"
                                                        autocomplete="off" onkeypress="return isBankNameKey(event)" oninput="filterBankNameInput(this)">
                                                    <span class="mdc-floating-label" id="my-label-id">BRANCH NAME</span>
                                                    <span class="mdc-line-ripple"></span>
                                                </label>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="ifsc_code mdc-text-field mdc-text-field--filled">
                                                    <span class="mdc-text-field__ripple"></span>
                                                    <input name="ifsc_code" id="ifsc_code" class="mdc-text-field__input"
                                                        value="<?php echo $bankInfo->ifsc_code; ?>" placeholder="Enter IFSC Code"
                                                        type="text" aria-labelledby="my-label-id" autocomplete="off" onkeypress="return isEsiCodeKey(event)" oninput="filterEsiCodeInput(this)">
                                                    <span class="mdc-floating-label" id="my-label-id">IFSC CODE</span>
                                                    <span class="mdc-line-ripple"></span>
                                                </label>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="account_no mdc-text-field mdc-text-field--filled">
                                                    <span class="mdc-text-field__ripple"></span>
                                                    <input name="account_no" id="account_no" class="mdc-text-field__input"
                                                        value="<?php echo $bankInfo->account_no; ?>" placeholder="Enter Account No."  onkeypress="return isNumberKey(event)"
                                                        type="text" aria-labelledby="my-label-id" autocomplete="off" required>
                                                    <span class="mdc-floating-label" id="my-label-id">BANK ACCOUNT NO.</span>
                                                    <span class="mdc-line-ripple"></span>
                                                </label>
                                            </div>

                                        </div>
                                        <!-- <br> -->
                                        <div class="row">


                                            <div class="col-12 col-lg-12 col-md-6">
                                                <button type="submit" class="btn btn-success float-right  mr-3">
                                                    Update </button>
                                            </div>

                                        </div>

                                    </form>
                                </div>
                            </div>

                            <!-- <hr>
                                <button class="btn btn-primary float-right mobile-btn border_right_radius mr-2 mt-0"
                                    data-toggle="modal" data-target="#addSalaryModel"><i class="fa fa-plus"></i>
                                    Add Salary Details</button> -->

                            <div class="table-responsive pt-1 mt-1">
                                <table class="display table table-bordered table-striped table-hover w-100">
                                    <tr>
                                        <th class="tbl-head1 text-center" colspan="14" width="100"><span style="font-size:22px;">SALARY DETAILS  </span>
                                        <button class="btn btn-primary float-right mobile-btn border_right_radius mr-2 mt-0"
                                            data-toggle="modal" data-target="#addSalaryModelNew"><b><i class="fa fa-plus"></i>
                                            Add Salary Details </b></button>

                                        </th>
                                    </tr>

                                    <tr>
                                        <th class="tbl-head1 text-center" colspan="5" style="font-size:18px;">Earning Details</th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-head-content1 text-center">Year</th>
                                        <th class="tbl-head-content1 text-center">Salary Type</th>
                                        <th class="tbl-head-content1 text-center">Calculate Type</th>
                                        <th class="tbl-head-content1 text-center">Value</th>
                                        <th class="tbl-head-content1 text-center">Action</th>
                                    </tr>

                                    <tbody>
                                    <?php if(!empty($staffEarningInfo)){
                                        for($i=0;$i<count($staffEarningInfo);$i++){ ?>
                                            <tr>
                                                <form role="form" action="<?php echo base_url() ?>updateEarningInfo" method="post" role="form">
                                                    <td width="100"><?php echo $staffEarningInfo[$i]->year; ?></td>
                                                    <td width="100"><?php echo $staffEarningInfo[$i]->salary_type; ?></td>
                                                    <td width="100"><?php echo $staffEarningInfo[$i]->calculate_type; ?></td>
                                                    <td width="100">
                                                    <input type="text" class="form-control" name="value" placeholder="Enter Value" onkeypress="return isNumberKey(event)" value="<?php echo $staffEarningInfo[$i]->value; ?>">
                                                    <input type="hidden" name="row_id" value="<?php echo $staffEarningInfo[$i]->row_id; ?>">
                                                    <input type="hidden" name="Staff_row_id" value="<?php echo $staffInfo->row_id; ?>">
                                                    </td>
                                                    <td class="text-center" width="100">
                                                        <button type="submit" class="btn btn-sm btn-success"><b>Update</b></button>
                                                        <a class="btn btn-xs btn-danger deleteSalaryEarningInfo" href="#" data-row_id="<?php echo $staffEarningInfo[$i]->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </form>
                                            </tr>

                                        <?php } ?>
                                        
                                    <?php }else{  ?>
                                            <tr>
                                                <td colspan="5" class="text-center">Earning Info Not Found</td>
                                            </tr>
                                    <?php } ?>

                                    </tbody>
                                </table>
                                <table class="display table table-bordered table-striped table-hover w-100">

                                    <tr class="mt-4">
                                        <th class="tbl-head1 text-center" colspan="5" style="font-size:18px;">Deduction Details</th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-head-content1 text-center">Year</th>
                                        <th class="tbl-head-content1 text-center">Salary Type</th>
                                        <th class="tbl-head-content1 text-center">Calculate Type</th>
                                        <th class="tbl-head-content1 text-center">Value</th>
                                        <th class="tbl-head-content1 text-center">Action</th>
                                    </tr>

                                    <tbody>
                                    <?php if(!empty($staffDeductionInfo)){
                                        for($i=0;$i<count($staffDeductionInfo);$i++){ ?>
                                            <tr>
                                                <form role="form" action="<?php echo base_url() ?>updateDeductionInfo" method="post" role="form">

                                                    <td width="100"><?php echo $staffDeductionInfo[$i]->year; ?></td>
                                                    <td width="100"><?php echo $staffDeductionInfo[$i]->salary_type; ?></td>
                                                    <td width="100"><?php echo $staffDeductionInfo[$i]->calculate_type; ?></td>
                                                    <td width="100">
                                                        <input type="text" class="form-control" name="value" placeholder="Enter Value" onkeypress="return isNumberKey(event)" value="<?php echo $staffDeductionInfo[$i]->value; ?>">
                                                        <input type="hidden" name="row_id" value="<?php echo $staffDeductionInfo[$i]->row_id; ?>">
                                                        <input type="hidden" name="Staff_row_id" value="<?php echo $staffInfo->row_id; ?>">
                                                    </td>
                                                    <td width="100" class="text-center">
                                                        <button type="submit" class="btn btn-sm btn-success"><b>Update</b></button>
                                                        <a class="btn btn-xs btn-danger deleteSalaryDeductionInfo" href="#" data-row_id="<?php echo $staffDeductionInfo[$i]->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </form>

                                            </tr>

                                        <?php } ?>

                                    <?php }else{  ?>
                                            <tr>
                                                <td colspan="5" class="text-center">Deduction Info Not Found</td>
                                            </tr>
                                    <?php } ?>
                                    </tbody>
                                
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="document-tab">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col profile-head">
                                            <ul class="nav nav-tabs" id="myTab1" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="personal_document-tab" data-toggle="tab" href="#personal_document" role="tab" aria-controls="profile" aria-selected="false">Personal</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="educational_document-tab" data-toggle="tab" href="#educational_document" role="tab" aria-controls="profile" aria-selected="false">Educational</a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="tab-content profile-tab" id="myTab1Content">
                                <div class="tab-pane fade show active" id="personal_document" role="tabpanel" aria-labelledby="personal_document-tab">
                                    <form role="form" action="<?php echo base_url() ?>updateStaffDocuments" method="post" enctype="multipart/form-data">
                                        <input type="hidden" value="<?php echo $staffInfo->row_id; ?>" id="row_id" name="row_id">
                                        <input type="hidden" value="<?php echo $staffInfo->staff_id; ?>" id="staff_id" name="staff_id">
                                        <div class="row">
                                            <div class="col-12 mb-12">
                                                <div class="table-responsive">
                                                    <table class="table table2 table-bordered ">
                                                        <tr class="tbl-head1 text-center">
                                                            <th class="header">Document Name</th>
                                                            <th class="header">Document Upload</th>
                                                            <th class="header">Action</th>
                                                        </tr>
                                                        <?php
                                                        $i = 0;
                                                        $course = array('AADHAR', 'PAN', 'VOTER ID');
                                                        if (!empty($staffdocumentInfo)) {
                                                            foreach ($staffdocumentInfo as $edu) { ?>
                                                                <tr>
                                                                    <input type="hidden" value="<?php echo $edu->row_id; ?>" name="document_row_id[]" />
                                                                    <td><input value="<?php echo $edu->document_name; ?>" name="document_name[]" class="form-control" autocomplete="off" readonly /></td>
                                                                    <td>
                                                                        <input type="file" class="form-control-sm" id="" name="userfile[]" accept="image/png, image/jpeg, image/jpg , application/pdf">
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        <?php if (!empty($edu->document_path)) { ?>
                                                                            <a href="<?php echo base_url(); ?><?php echo $edu->document_path; ?>" target="_blank" class="btn btn-primary p-2"><i class="fa fa-eye"></i> View</a>
                                                                            <a href="<?php echo base_url(); ?><?php echo $edu->document_path; ?>" download target="_blank" class="btn btn-danger p-2"><i class="fa fa-download"></i> Download</a>
                                                                        <?php } ?>
                                                                    </td>
                                                                </tr>
                                                            <?php }
                                                        } else {
                                                            for ($i = 0; $i < 3; $i++) { ?>
                                                                <tr>
                                                                    <input type="hidden" value="<?php echo $course[$i]; ?>" name="document_row_id[]" />
                                                                    <td><input value="<?php echo $course[$i]; ?>" name="document_name[]" class="form-control" autocomplete="off" readonly /></td>
                                                                    <td>
                                                                        <input type="file" class="form-control-sm" id="" name="userfile[]" accept="image/png, image/jpeg, image/jpg , application/pdf">
                                                                    </td>
                                                                    <td>
                                                                        <?php if (!empty($edu->document_path)) { ?>
                                                                            <a href="<?php echo base_url(); ?><?php echo $edu->document_path; ?>" download target="_blank" class="btn btn_download p-2"><i class="fa fa-download"></i></a>
                                                                            <a href="<?php echo base_url(); ?><?php echo $edu->document_path; ?>" target="_blank" class="btn btn-primary p-2"><i class="fa fa-eye"></i> View</a>
                                                                        <?php } ?>
                                                                    </td>
                                                                </tr>
                                                        <?php }
                                                        } ?>
                                                        <!-- Additional Row Template -->
                                                        <tr id="additionalRowTemplate" style="display: none;">
                                                            <input type="hidden" value="" name="document_row_id[]" />
                                                            <td><input value="" name="document_name[]" class="form-control" autocomplete="off" placeholder="Enter Document Name" />
                                                            </td>
                                                            <td><input type="file" class="form-control-sm" name="userfile[]" accept="image/png, image/jpeg, image/jpg , application/pdf">
                                                            </td>
                                                            <td><button type="button" class="btn btn-danger removeRow">Remove</button>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success float-right ml-2">Update</button>
                                    </form>
                                    <!-- Add Row Button -->
                                    <div class="text-right">
                                        <button type="button" class="btn btn-primary" id="addRow"><i class="fa fa-plus"></i>
                                            Add Document</button>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="educational_document" role="tabpanel" aria-labelledby="educational_document-tab">
                                    <form role="form" action="<?php echo base_url() ?>updateStaffEducationInfo" method="post" enctype="multipart/form-data">
                                        <input type="hidden" value="<?php echo $staffInfo->row_id; ?>" id="row_id" name="row_id">
                                        <input type="hidden" value="<?php echo $staffInfo->staff_id; ?>" id="staff_id" name="staff_id">
                                        <div class="row">
                                            <div class="col-12 mb-12">
                                                <div class="table-responsive">
                                                    <table class="table table3 table-bordered ">
                                                        <tr class="tbl-head1 text-center">
                                                            <th class="header">Education Passed</th>
                                                            <th class="header">Board/University</th>
                                                            <th class="header">Year of Passing</th>
                                                            <th class="header">Percentage</th>
                                                            <th class="header">Document</th>
                                                            <th class="header">Action</th>
                                                        </tr>
                                                        <?php
                                                        $i = 0;
                                                        $j = 1;
                                                        $course = array('SSLC', 'PUC', 'GRADUATION', 'POST GRADUATION', 'B Ed', 'OTHER QUALIFICATION');
                                                        $courseUpdate = array();
                                                        if (!empty($staffEducationInfo)) {
                                                            foreach ($staffEducationInfo as $edu) {
                                                                $courseUpdate[] = $edu->course_name;
                                                            }
                                                        }
                                                        $differenceCourse = array_diff($course, $courseUpdate);
                                                        if (!empty($staffEducationInfo)) {
                                                            foreach ($staffEducationInfo as $edu) { ?>
                                                                <tr>
                                                                    <input type="hidden" value="<?php echo $edu->course_name; ?>" name="documentName[]" id="" />
                                                                    <input type="hidden" value="<?php echo $edu->row_id; ?>" name="course_row_id[]" />
                                                                    <td><input value="<?php echo $edu->course_name; ?>" name="course_name[]" id="course_name" class="form-control" autocomplete="off" readonly /></td>
                                                                    <td><input value="<?php echo $edu->board_name; ?>" name="board_name[]" id="board_name" class="form-control" autocomplete="off" placeholder="Board/University" />
                                                                    </td>

                                                                    <td><input value="<?php echo $edu->year_of_passing; ?>" onkeypress="return isNumberKey(event)" maxlength="4" id="year_of_passing" name="year_of_passing[]" placeholder="Year of Passing" class="form-control year-picker" autocomplete="off" /></td>



                                                                    <td><input value="<?php echo $edu->percentage; ?>" onkeypress="return isNumberKey(event)" id="percentage" name="percentage[]" class="form-control" autocomplete="off" placeholder="Percentage" /></td>
                                                                    <td>
                                                                        <input type="file" class="form-control-sm" id="" name="userfile[]" accept="image/png, image/jpeg, image/jpg, application/pdf">
                                                                    </td>
                                                            
                                                                    <td><?php if (!empty($edu->document_path)) { ?>
                                                                            <!-- <a href="<?php echo base_url(); ?><?php echo $edu->document_path; ?>"
                                                                                                download target="_blank" class="btn btn_download p-2"><i
                                                                                                    class="fa fa-download"></i></a> -->
                                                                            <a href="<?php echo base_url(); ?><?php echo $edu->document_path; ?>" target="_blank" class="btn btn-primary p-2"><i class="fa fa-eye"></i> View</a>

                                                                        <?php } ?>
                                                                    </td>
                                                                </tr>
                                                            <?php }
                                                        }
                                                        for ($i = 0; $i < 6; $i++) {
                                                            if (!empty($differenceCourse[$i])) {                 ?>
                                                                <tr>
                                                                    <input type="hidden" value="<?php echo $differenceCourse[$i]; ?>" name="documentName[]" id="" />
                                                                    <td><input value="<?php echo $differenceCourse[$i]; ?>" name="course_name[]" id="course_name" class="form-control" autocomplete="off" readonly /></td>
                                                                    <td><input name="board_name[]" id="board_name" class="form-control" autocomplete="off" placeholder="Board/University" /></td>

                                                                    <td><input onkeypress="return isNumberKey(event)" maxlength="4" id="year_of_passing" name="year_of_passing[]" placeholder="Year of Passing" class="form-control year-picker" autocomplete="off" /></td>


                                                                    <td><input onkeypress="return isNumberKey(event)" id="percentage" name="percentage[]" class="form-control" autocomplete="off" placeholder="Percentage" /></td>
                                                                    <td><input type="file" class="form-control-sm" id="" name="userfile[]" accept="image/png, image/jpeg, image/jpg, application/pdf">
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                        <?php $j++;
                                                            }
                                                        }  ?>
                                                        <!-- Additional Row Template for Education Section -->
                                                        <tr id="additionalEducationRowTemplate" style="display: none;">
                                                            <input type="hidden" value="" name="course_row_id[]" />
                                                            <td><input value="" name="course_name[]" class="form-control" autocomplete="off" placeholder="Enter Qualification Name" /></td>
                                                            <td><input value="" name="board_name[]" class="form-control" autocomplete="off" placeholder="Enter Board/University Name" />
                                                            </td>

                                                            <td><input type="text" name="year_of_passing[]" onkeypress="return isNumberKey(event)" class="form-control" placeholder="Year of Passing" maxlength="4" autocomplete="off"></td>


                                                            <td><input type="text" name="percentage[]" onkeypress="return isNumberKey(event)" class="form-control" placeholder="Percentage" autocomplete="off"></td>


                                                            <td><input type="file" class="form-control-sm" name="userfile[]" accept="image/png, image/jpeg, image/jpg, application/pdf">
                                                            </td>
                                                            <td><button type="button" class="btn btn-danger removeEducationRow">Remove</button>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-success float-right">Update </button>

                                    </form>
                                    <!-- Add Row Button -->
                                    <div class="text-right">
                                        <button type="button" class="btn btn-primary" id="addRow1"><i class="fa fa-plus"></i> Add Education</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                 
                        <div class="tab-pane fade mt-2" id="previousWork" role="tabpanel" aria-labelledby="previousWork-tab">
                            <form role="form" action="<?php echo base_url() ?>updateStaffWorkExperience" method="post" enctype="multipart/form-data">
                                <input type="hidden" value="<?php echo $staffInfo->row_id; ?>" id="row_id" name="row_id">
                                <input type="hidden" value="<?php echo $staffInfo->staff_id; ?>" id="staff_id" name="staff_id">
                                <div class="row">
                                    <div class="col-12 mb-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered ">
                                                <tr class="tbl-head1 text-center">
                                                    <!-- <th class="text-center" width="80">SL No.</th> -->
                                                    <th class="text-center">Organization</th>
                                                    <th class="text-center">Number of Years</th>
                                                    <th class="text-center">Document</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                                <?php
                                                $organisation = array('ORG1', 'ORG2', 'ORG3', 'ORG4');

                                                $j = 1;
                                                $previousWorkUpdate = array();
                                                if (!empty($previousWorkInfo)) {

                                                    foreach ($previousWorkInfo as $work) {
                                                        $previousWorkUpdate[] = $work->org_type;
                                                    }
                                                }

                                                $differenceWork = array_diff($organisation, $previousWorkUpdate);

                                                if (!empty($previousWorkInfo)) {

                                                    foreach ($previousWorkInfo as $work) { ?>
                                                        <tr>
                                                            <input type="hidden" value="<?php echo $work->org_type; ?>" name="documentName[]" id="" />
                                                            <input type="hidden" value="<?php echo $work->row_id; ?>" name="work_row_id[]" />
                                                            <!-- <th class="text-center">
                                                                            <input type="text" class="form-control required digits" value="<?php echo $j; ?>"  autocomplete="off" maxlength="6" readonly>
                                                                        </th> -->
                                                            <th>
                                                                <input placeholder="Organization" type="text" class="form-control required" value="<?php echo $work->organization_name; ?>" id="organization_name" name="organization_name[]" autocomplete="off" maxlength="128">
                                                            </th>
                                                            <th>
                                                                <input placeholder="Number of Years" type="text" class="form-control required" value="<?php echo $work->no_of_years; ?>" id="no_of_years" name="no_of_years[]" onkeypress="return isNumberKey(event)" autocomplete="off" maxlength="6">
                                                            </th>
                                                            <th>
                                                                <input type="file" class="form-control-sm" id="" name="userfile[]" accept="image/png, image/jpeg, image/jpgg, application/pdf">
                                                            </th>
                                                            <td>
                                                                <?php if (!empty($work->document_path)) { ?>
                                                                    <!-- <a href="<?php echo base_url(); ?><?php echo $edu->document_path; ?>"
                                                                                            download target="_blank" class="btn btn_download p-2"><i
                                                                                                class="fa fa-download"></i></a> -->
                                                                    <a href="<?php echo base_url(); ?><?php echo $work->document_path; ?>" target="_blank" class="btn btn-primary p-2"><i class="fa fa-eye"></i> View</a>

                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php $j++;
                                                    }
                                                }
                                                $k = 0;
                                                for ($i = 0; $i < 4; $i++) {
                                                    if (!empty($differenceWork[$i])) { ?>
                                                        <input type="hidden" value="<?php echo $differenceWork[$i]; ?>" name="documentName[]" id="" />
                                                        <tr>
                                                            <!-- <th class="text-center">
                                                                        <input type="text" class="form-control required digits" value="<?php echo $i; ?>" autocomplete="off" readonly>
                                                                    </th> -->
                                                            <th>
                                                                <input placeholder="Organization" type="text" class="form-control required" id="organization_name" name="organization_name[]" autocomplete="off" maxlength="128">
                                                            </th>
                                                            <th>
                                                                <input placeholder="Number of Years" type="text" class="form-control required" id="no_of_years" name="no_of_years[]" autocomplete="off" onkeypress="return isNumberKey(event)" maxlength="6">
                                                            </th>
                                                            <th>
                                                                <input type="file" class="form-control-sm" id="" name="userfile[]" accept="image/png, image/jpeg, image/jpg, application/pdf">
                                                            </th>
                                                            <th></th>
                                                        </tr>
                                                <?php $k++;
                                                    }
                                                }  ?>

                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success float-right">Update </button>

                            </form>
                        </div>
                        <div class="tab-pane fade p-1" id="notification" role="tabpanel" aria-labelledby="notification-tab">
                                            
                            <div class="row p-0 column_padding_card">
                                <div class="col column_padding_card">
                                    <div class="card card-small mb-4">
                                        <style>
                                            .load_more_less:hover{
                                                color : #33cc33 !important;
                                            }
                                            .card-flex-container{
                                                display: flex;
                                                justify-content: flex-end;
                                            }
                                            /* form{
                                                display: flex;               
                                            } */
                                        </style>
                                        <div class="card-header card-flex-container p-1">                    
                                            <form style="display: flex;" action="<?php echo base_url(); ?>editStaff/<?php echo $staffInfo->row_id; ?>" method="POST"
                                                id="byFilterMethod">
                                                
                                                <input class="form-control datepicker" type="text" name="date_from" 
                                                value="<?php  if(!empty($date_from)) echo date('d-m-Y', strtotime($date_from)); ?>"
                                                style="text-transform: uppercase" placeholder="Date From" autocomplete="off">
                                                    &emsp;
                                                <input class="form-control datepicker" type="text" name="date_to" 
                                                value="<?php  if(!empty($date_to)) echo date('d-m-Y', strtotime($date_to)); ?>"
                                                style="text-transform: uppercase" placeholder="Date To" autocomplete="off">

                                                <button type="submit" class="btn btn-success ml-1">Search</button>
                                            </form>
                                        </div>
                                        <style>
                                            .flex-containers{
                                            }
                                            .flex-containers{
                                                
                                            }
                                            .main-flex-container{  
                                                display: flex;
                                                flex-direction: column;
                                                background: #d7e0e2;
                                                padding: 5px 10px;
                                                border-radius: 5px;
                                                font-weight: bold;
                                                margin-bottom: 3px;
                                            }
                                            .head-container{
                                                display: flex;
                                                width: 100%;
                                            }
                                            .head-container > .title{
                                                color: #2011ef;
                                                margin-left: 10px;
                                            }
                                            .body-container{
                                                margin: 5px 0px;
                                            }
                                            .body-container > .body{
                                                color: #383535;
                                                margin-left: 23px;
                                            }
                                            .footer-container{
                                                display: flex;
                                                justify-content: space-between;
                                            }
                                            .action-buttons{
                                                align-self: flex-end;
                                            }
                                        </style>
                                        <div class="card-body p-2">
                                            <div class="flex-containers">
                                            <?php 
                                                    if(!empty($notifications)){
                                                        $segmentID = 0;
                                                        foreach($notifications as $count=>$notification){
                                                            if(fmod($count,7) == 0){ 
                                                                $segmentID++;
                                                            }?>
                                                                <div class="main-flex-container notificationSegment_<?=$segmentID;?>">
                                                                
                                                                    <div class="head-container">
                                                                        <span>
                                                                            <i class="fas fa-bell"></i>
                                                                        </span>
                                                                        <span class="title"><?=$notification->name;?></span>                   
                                                                    </div>
                                                                    <div class="body-container">
                                                                        <span class="body"><?=$notification->subject;?></span>
                                                                    </div>
                                                                    <div class="body-container">
                                                                        <span class="body"><?=$notification->message;?></span>
                                                                    </div>
                                                                    <div class="footer-container">
                                                                        <span class="date">Sent By - <?php 
                                                                            if(!empty($notification->sent_by)) echo $notification->sent_by;
                                                                        ?></span>
                                                                    </div>
                                                                    <div class="footer-container">
                                                                        <span class="date"><?php 
                                                                            if(!empty($notification->updated_date_time)) echo date('d-m-Y h:i A', strtotime($notification->updated_date_time));
                                                                        ?></span>
                                                                        <?php 
                                                                            if(!empty($notification->filepath)){?>
                                                                                <span class="attachment">
                                                                                    <a class="badge badge-success" target="_blank" href="<?= base_url().$notification->filepath ?>" onclick="">View Attachment</a>
                                                                                </span>
                                                                            <?php }
                                                                        ?>
                                                                    </div>
                                                                    <div class="action-buttons mt-1">
                                                                    <?php 
                                                                            if(!empty($notification->filepath_two)){?>
                                                                                <span class="attachment">
                                                                                    <a class="badge badge-success" target="_blank" href="<?= base_url().$notification->filepath_two ?>" onclick="">View Attachment 2</a>
                                                                                </span>
                                                                            <?php } ?>
                                                                    </div>
                                                                </div>
                                                        <?php }
                                                    }else{ ?>
                                                            <p class="text-center m-0" style="font-weight: bold;">No Notifications Found..!</p>
                                                    <?php }
                                                    ?>
                                            </div>
                                        </div>
                                        <div class="card-footer p-1">          
                                            <span onclick="loadMoreNotification();" style="user-select:none;font-size:17px;font-weight:bold;cursor:pointer;color:#007bff" class="float-left pt-2 pb-2 pl-2 load_more_less">load more<i class="fas fa-arrow-circle-down pl-1"></i></span>
                                            <span onclick="showLessNotification();" style="user-select:none;font-size:17px;font-weight:bold;cursor:pointer;color:#007bff" class="float-right pt-2 pb-2 pr-2 load_more_less">show less<i class="fas fa-arrow-circle-up pl-1"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="Academics" role="tabpanel" aria-labelledby="Academics-tab">
                            <form role="form" action="<?php echo base_url() ?>updateStaffAcademicInfo" method="post" enctype="multipart/form-data">
                                <input type="hidden" value="<?php echo $staffInfo->row_id; ?>" id="row_id" name="row_id">
                                <input type="hidden" value="<?php echo $staffInfo->staff_id; ?>" id="staff_id" name="staff_id">
                                <br>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="examiner">Have you been appointed as an examiner?</label>
                                        <select class="form-control" id="examiner" name="examiner">
                                            <?php if (!empty($staffInfo->examiner)) { ?>
                                                <option value="<?php echo $staffInfo->examiner ?>">
                                                    Selected:<?php echo $staffInfo->examiner ?></option>
                                            <?php } ?>
                                            <option value="NO">NO</option>
                                            <option value="YES">YES</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="pta_member">PTA MEMBER?</label>
                                        <select class="form-control" id="pta_member" name="pta_member">
                                            <?php if (!empty($staffInfo->pta_member)) { ?>
                                                <option value="<?php echo $staffInfo->pta_member ?>">
                                                    Selected:<?php echo $staffInfo->pta_member ?></option>
                                            <?php } ?>
                                            <option value="NO">NO</option>
                                            <option value="YES">YES</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="oba_medical">OBA MEDICAL INSURANCE - ELIGIBLE?</label>
                                        <select class="form-control selectpicker" data-live-search="true" id="oba_medical" name="oba_medical" required>
                                            <?php if (!empty($staffInfo->oba_medical)) { ?>
                                                <option value="<?php echo $staffInfo->oba_medical ?>">
                                                    Selected:<?php echo $staffInfo->oba_medical ?></option>
                                            <?php } ?>
                                            <option value=""></option>
                                            <option value="YES">YES</option>
                                            <option value="NO">NO</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="cordinator">COORDINATOR FOR THE CLASSESS?</label>
                                        <select class="form-control" id="cordinator" name="cordinator">
                                            <?php if (!empty($staffInfo->cordinator)) { ?>
                                                <option value="<?php echo $staffInfo->cordinator ?>">
                                                    Selected:<?php echo $staffInfo->cordinator ?></option>
                                            <?php } ?>
                                            <option value="NO">NO</option>
                                            <option value="YES">YES</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="subject_taught">SUBJECT BEING TAUGHT :</label>
                                        <input type="text" class="form-control" id="subject_taught" value="<?php echo $staffInfo->subject_taught; ?>" name="subject_taught" placeholder="Enter Subject Being Taught" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="class_taught">CLASSES CURRENTLY BEING TAUGHT :</label>
                                        <input type="text" class="form-control" id="class_taught" value="<?php echo $staffInfo->class_taught; ?>" name="class_taught" placeholder="Enter Classes Currently Being Taught" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="teaching_experience">NO OF YEARS OF TEACHING EXPERIENCE
                                            :</label>
                                        <input type="text" class="form-control" id="teaching_experience" value="<?php echo $staffInfo->teaching_experience; ?>" name="teaching_experience" placeholder="Enter Teaching Experience">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="previous_experience">NO OF PREVIOUS YEARS OF TEACHING EXPERIENCE
                                            :</label>
                                        <input type="text" class="form-control" id="previous_experience" value="<?php echo $staffInfo->previous_experience; ?>" name="previous_experience" placeholder="Enter Previous Teaching Experience">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="upgrade_class">UPGRADE CLASS :</label>
                                        <input type="text" class="form-control" id="upgrade_class" value="<?php echo $staffInfo->upgrade_class; ?>" name="upgrade_class" placeholder="Enter Upgrade Class">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="upgrade_subject">UPGRADE SUBJECT :</label>
                                        <input type="text" class="form-control" id="upgrade_subject" value="<?php echo $staffInfo->upgrade_subject; ?>" name="upgrade_subject" placeholder="Enter Upgrade Subject">
                                    </div>
                                    <div class="col-md-4 mb-3 pta_fields">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="pta_year">PTA MEMBER AS NO. OF YEARS:</label>
                                                <input type="text" class="form-control" id="pta_year" value="<?php echo $staffInfo->pta_year; ?>" name="pta_year" placeholder="Enter Years">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3 cordinator_fields">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="coordinator_year">COORDINATOR AS NO. OF YEARS:</label>
                                                <input type="text" class="form-control" id="coordinator_year" value="<?php echo $staffInfo->coordinator_year; ?>" name="coordinator_year" placeholder="Enter years">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-12 mb-3 examiner_fields">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="years_isc">Total number of years as an examiner ISC
                                                    (Class
                                                    XII):</label>
                                                <input type="text" class="form-control" id="years_isc" value="<?php echo $staffInfo->years_isc; ?>" name="years_isc" placeholder="Enter years">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="isc_examiner_number">ISC Examiner Number:</label>
                                                <input type="text" class="form-control" id="isc_examiner_number" value="<?php echo $staffInfo->isc_examiner_number; ?>" name="isc_examiner_number" placeholder="Enter Isc Examiner Number">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="years_icse">Total number of years as an examiner ICSE
                                                    (Class
                                                    X):</label>
                                                <input type="text" class="form-control" id="years_icse" value="<?php echo $staffInfo->years_icse; ?>" name="years_icse" placeholder="Enter years">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="icse_examiner_number">ICSE Examiner Number:</label>
                                                <input type="text" class="form-control" id="icse_examiner_number" value="<?php echo $staffInfo->icse_examiner_number; ?>" name="icse_examiner_number" placeholder="Enter ICSE Examiner Number">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Add more fields as needed -->

                                <button type="submit" class="btn btn-success float-right">Update</button>
                            </form>
                        </div>



                        <?php if ($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR) { ?>
                            <div class="<?= ($active == "changepass") ? "active" : "" ?> tab-pane fade mx-auto" id="changePassword" role="tabpanel" aria-labelledby="password-tab">
                                <form role="form" method="post" action="<?php echo base_url() . 'changePasswordAdmin/' . $staffInfo->row_id; ?>">
                                    <!-- <div class="input-group mb-2 profile_changePassword">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text material-icons">lock</span>
                                                </div>
                                                <input type="password" class="form-control" placeholder="Old password"
                                                    id="oldPassword" name="oldPassword" autocomplete="off" required />
                                            </div> -->
                                    <div class="input-group mb-2 profile_changePassword">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text material-icons">lock</span>
                                        </div>
                                        <input type="password" class="form-control" placeholder="New Password" id="password" name="newPassword" autocomplete="off" required />
                                    </div>
                                    <div class="input-group mb-2 profile_changePassword">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text material-icons">lock</span>
                                        </div>
                                        <input type="password" class="form-control equalTo" placeholder="Re-Type Password" id="cNewPassword" name="cNewPassword" autocomplete="off" required />
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary ">Update</button>
                                    </div>
                                </form>
                            </div>
                        <?php } ?>
                        <!-- Add more tab panes as needed -->
                    </div>
                </div>

            </div>
        </div>


    <?php } ?>

</div>


<div class="modal" id="addSalaryModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">ADD SALARY DETAILS</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2 m-1">
                <!--  -->
                <form action="<?php echo base_url() ?>addSalaryDetails" method="POST" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="row_id" value="<?php echo $staffInfo->row_id ?>">
                    <input type="hidden" name="staff_id" value="<?php echo $staffInfo->staff_id ?>">
                    <div class="row">
                        <div class="col-6 text-dark">
                            <label>Select Year</label>
                            <div class="form-group">
                                <select class="form-control input-sm selectpicker" id="year" name="year" data-live-search="true" required>
                                    <option value="2024">2024</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6 text-dark">
                            <label for="cl">Enter Basic Salary</label>
                            <input type="text" class="form-control required" required id="basic_salary" name="basic_salary" placeholder="Enter Basic Salary" onkeypress="return isNumberKey(event)" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 text-dark">
                            <label for="usr">Enter DA in % (eg: 30)</label>
                            <input onkeypress="return isNumberKey(event)" type="text" name="da" class="form-control" value="30" Placeholder="Enter DA" id="da" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 text-dark">
                            <label for="usr">Enter HRA in % (eg: 20)</label>
                            <input onkeypress="return isNumberKey(event)" type="text" name="hr" value="20" class="form-control" Placeholder="Enter HRA" id="hr" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 text-dark">
                            <label for="usr">Enter Other Amount(if not applicable, please enter 0)</label>
                            <input onkeypress="return isNumberKey(event)" type="text" name="others" class="form-control" Placeholder="Enter Others" id="others" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 text-dark">
                            <label for="usr">Employer PF in %(if not applicable, please enter 0)</label>
                            <input onkeypress="return isNumberKey(event)" type="text" name="management_pf" value="13"
                                class="form-control" Placeholder="Enter Management PF" id="hr" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 text-dark">
                            <label for="usr">Employee PF in %(if PF is not applicable, please enter 0)</label>
                            <input onkeypress="return isNumberKey(event)" type="text" name="pf" value="12" class="form-control" Placeholder="Enter PF" id="pf" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 text-dark">
                            <label for="usr">Employer ESI in %(if not applicable, please enter 0)</label>
                            <input onkeypress="return isNumberKey(event)" type="text" name="management_esi" value="3.25"
                                class="form-control" Placeholder="Enter Management ESI" id="hr" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 text-dark">
                            <label for="usr">Enter ESI in %(if ESI is not applicable, please enter 0)</label>
                            <input onkeypress="return isNumberKey(event)" type="text" name="esi" class="form-control" value="0.75" Placeholder="Enter ESI" id="esi" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 text-dark">
                            <label for="usr">Enter PT (if PT is not applicable, please enter 0)</label>
                            <input onkeypress="return isNumberKey(event)" type="text" name="pt" value="0" class="form-control" Placeholder="Enter PT" id="pt" autocomplete="off">
                        </div>
                    </div>
            </div>
            <div class="modal-footer pt-2 pb-0 mb-2">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button id="staffInfoDownload" type="submit" class="btn btn-md btn-success"> SAVE</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="addAdvanceSalaryNewDocModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title">ADD ADVANCE PAYMENT DETAILS</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-2 m-1">
                <form action="<?php echo base_url() ?>addAdvancePaymentDetails" method="POST" role="form"
                    enctype="multipart/form-data">
                    <input type="hidden" name="row_id" value="<?php echo $staffInfo->row_id ?>">
                    <input type="hidden" name="staff_id" value="<?php echo $staffInfo->staff_id ?>">
                    <div class="row">
                        <div class="col-6 text-dark">
                            <label>Select Date</label>
                            <div class="form-group">
                                <input type="text" value="<?php echo date('d-m-Y') ?>" name="date"
                                    class="form-control datepicker input-sm" placeholder="Date" autocomplete="off"
                                    required>
                            </div>
                        </div>
                        <div class="form-group col-md-6 text-dark">
                            <label for="cl">Enter Advance Amount</label>
                                <input type="text" class="form-control required " required id="advance_amount" name="advance_amount" placeholder="Enter Advance Amount" onkeypress="return isNumberKey(event)" autocomplete="off">
                        </div>
                        <div class="col-6">
                            <div class="form-group text-dark">
                                <label>Select Payment Type </label>
                                <select class="form-control input-sm selectpicker" id="payment_type" name="payment_type" data-live-search="true" required>
                                    <option value="">Select Payment Type</option>
                                    <option value="CASH">CASH</option>
                                    <option value="DD">DD</option>
                                    <option value="NEFT">NEFT</option>
                                    <option value="UPI">UPI</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6 text-dark dd_info">
                            <label for="usr">DD Number</label>
                            <input onkeypress="return isNumberKey(event)" type="text" name="dd_number"  class="form-control" Placeholder="Enter DD Number" id="dd_number" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 text-dark dd_info">
                            <label for="usr">DD Date</label>
                            <input type="text" name="dd_date" class="form-control datepicker"  Placeholder="Enter DD Date" autocomplete="off">
                        </div>

                        <div class="form-group col-md-6 text-dark dd_bank_name">
                            <label for="usr">Bank Name</label>
                            <input type="text" name="bank_name" class="form-control"  Placeholder="Enter Bank Name" id="dd_bank_name" autocomplete="off">
                        </div> 

                                    <div class="col-lg-6 form-group text-dark bank_info">
                                            <label for="usr">Transaction Number</label>
                                            <input onkeypress="return isNumberKey(event)" type="text" name="bank_tran_number"  class="form-control" Placeholder="Bank Transaction Number" id="tran_number" autocomplete="off">
                                    </div>
                                    <div class="col-lg-6 form-group text-dark bank_info">
                                            <label for="usr">Transaction Date</label>
                                            <input type="text" name="bank_tran_date" class="form-control"  Placeholder="Enter Transaction Date" id="transaction_date_bank" autocomplete="off">
                                    </div>

                                    <!-- <div class="col-lg-6 form-group text-dark bank_info">
                                            <label for="usr">Bank Name:</label>
                                            <input type="text" name="bank_name" class="form-control"  Placeholder="Enter Bank Name" id="tran_bank_name" autocomplete="off">
                                    </div> -->

                                    <div class="col-lg-6 form-group text-dark neft_info">
                                            <label for="usr">Reference Number</label>
                                            <input type="text" name="ref_number"  class="form-control" Placeholder="Payment Ref Number" id="dd_number" autocomplete="off">
                                    </div>
                                    <div class="col-lg-6 form-group text-dark neft_info">
                                            <label for="usr">NEFT Date</label>
                                            <input type="text" name="neft_date" class="form-control datepicker"  Placeholder="Enter NEFT Date" autocomplete="off">
                                    </div>
                                    <div class="col-lg-6 form-group text-dark upi_info">
                                            <label for="usr">UPI Reference Number</label>
                                            <input  type="text" name="upi_number"  class="form-control" Placeholder="UPI Ref Number" id="upi_number" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-6 text-dark">
                                        <label for="usr">Enter Repayment Period (Please Enter in Months)</label>
                                        <input onkeypress="return isNumberKey(event)" type="text" name="repayment_period"  class="form-control" required Placeholder="Enter Repayment Period (Please Enter in Months)" id="repayment_period" autocomplete="off">
                                    </div> 
                                    <div class="form-group col-md-6 text-dark">
                                        <label for="usr">Installment Amount</label>
                                        <input readonly type="text" name="installment_amount"  class="form-control" Placeholder="Installment Amount" id="installment_amount" autocomplete="off">
                                    </div>    
                    </div>
                </div>
                    <div class="modal-footer pt-2 pb-0 mb-2">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button id="staffInfoDownload" type="submit" class="btn btn-md btn-success"> SAVE</button>
                    </div>
                </form>
        </div>
    </div>
</div>

<div id="triplModel" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header modal-call-report p-2">
                <div class=" col-md-10 col-10">
                    <span class="mobile-title" style="font-size : 20px;color:white">Edit Advance Amount</span>
                </div>
                <div class=" col-md-2 col-2">
                    <button type="button" class="text-white close" data-dismiss="modal">&times;</button>
                </div>
            </div>
            <!-- Modal body -->
            <div class="modal-body m-0">
                <?php $this->load->helper("form"); ?>
                <form role="form" id="" action="<?php echo base_url() ?>updateSalaryAdvanceInfo"
                    method="post" role="form">
                    <input type="hidden" name="Advance_row_id" id="Advance_row_id" value="" />
                    <input type="hidden" name="staff_row_id" value="<?php echo $staffInfo->row_id ?>">

                    <div class="row">
                    <div class="col-6 text-dark">
                        <label>Select Date</label>
                        <div class="form-group">
                            <input type="text" value="<?php echo date('d-m-Y') ?>" name="date" id="date1"
                                class="form-control datepicker input-sm" placeholder="Date" autocomplete="off"
                                required>
                        </div>
                    </div>
                    <div class="form-group col-md-6 text-dark">
                        <label for="cl">Enter Advance Amount</label>
                            <input type="text" class="form-control required " required id="advance_amount1" name="advance_amount" placeholder="Enter Advance Amount" onkeypress="return isNumberKey(event)" autocomplete="off">
                    </div>
                    <div class="col-6">
                        <div class="form-group text-dark">
                            <label>Select Payment Type </label>
                            <select class="form-control input-sm selectpicker" id="payment_type1" name="payment_type" data-live-search="true" required>
                                <option value="">Select Payment Type</option>
                                <option value="CASH">CASH</option>
                                <option value="DD">DD</option>
                                <option value="NEFT">NEFT</option>
                                <option value="UPI">UPI</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6 text-dark dd_info1">
                        <label for="usr">DD Number</label>
                        <input onkeypress="return isNumberKey(event)" type="text" name="dd_number"  class="form-control" Placeholder="Enter DD Number" id="dd_number1" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6 text-dark dd_info1">
                        <label for="usr">DD Date</label>
                        <input type="text" name="dd_date" id="dd_date1"  class="form-control datepicker"  Placeholder="Enter DD Date" autocomplete="off">
                    </div>

                    <div class="form-group col-md-6 text-dark dd_bank_name1">
                        <label for="usr">Bank Name</label>
                        <input type="text" name="bank_name" class="form-control"  Placeholder="Enter Bank Name" id="dd_bank_name1" autocomplete="off">
                    </div> 

                                <div class="col-lg-6 form-group text-dark bank_info1">
                                        <label for="usr">Transaction Number</label>
                                        <input onkeypress="return isNumberKey(event)" type="text" name="bank_tran_number"  class="form-control" Placeholder="Bank Transaction Number" id="tran_number1" autocomplete="off">
                                </div>
                                <div class="col-lg-6 form-group text-dark bank_info1">
                                        <label for="usr">Transaction Date</label>
                                        <input type="text" name="bank_tran_date" class="form-control"  Placeholder="Enter Transaction Date" id="transaction_date_bank1" autocomplete="off">
                                </div>
                                <div class="col-lg-6 form-group text-dark neft_info1">
                                        <label for="usr">Reference Number</label>
                                        <input type="text" name="ref_number"  class="form-control" Placeholder="Payment Ref Number" id="ref_number1" autocomplete="off">
                                </div>
                                <div class="col-lg-6 form-group text-dark neft_info1">
                                        <label for="usr">NEFT Date</label>
                                        <input type="text" name="neft_date" id="neft_date1" class="form-control datepicker"  Placeholder="Enter NEFT Date" autocomplete="off">
                                </div>
                                <div class="col-lg-6 form-group text-dark upi_info1">
                                        <label for="usr">UPI Reference Number</label>
                                        <input  type="text" name="upi_number"  class="form-control" Placeholder="UPI Ref Number" id="upi_number1" autocomplete="off">
                                </div>
                                <div class="form-group col-md-6 text-dark">
                                    <label for="usr">Enter Repayment Period (Please Enter in Months)</label>
                                    <input onkeypress="return isNumberKey(event)" type="text" name="repayment_period"  class="form-control" required Placeholder="Enter Repayment Period (Please Enter in Months)" id="repayment_period1" autocomplete="off">
                                </div> 
                                <div class="form-group col-md-6 text-dark">
                                    <label for="usr">Installment Amount</label>
                                    <input readonly type="text" name="installment_amount"  class="form-control" Placeholder="Installment Amount" id="installment_amount1" autocomplete="off">
                                </div>  
                        
                    </div>
                    <div class="form-group">
                        <input style="float:right;" type="submit" class="btn btn-primary" value="Update" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="InstallmentModel" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header modal-call-report p-2">
                <div class=" col-md-10 col-10">
                    <span class="mobile-title" style="font-size : 20px;color:white">ADVANCE SALARY INSTALLMENT DETAILS</span>
                </div>
                <div class=" col-md-2 col-2">
                    <button type="button" class="text-white close" data-dismiss="modal">&times;</button>
                </div>
            </div>
            <!-- Modal body -->
            <div class="modal-body m-0">
                <?php $this->load->helper("form"); ?>
                    <input type="hidden" name="Advance_row_id" id="Advance_row_id" value="" />
                    <input type="hidden" name="staff_row_id" value="<?php echo $staffInfo->row_id ?>">

                    <div class="row">
                        <table class="table table-bordered table_edit_student ">
                                                    <tr class = "text-center"><th class="tbl-head" colspan = "7">INSTALLMENT DETAILS</th></tr>
                                                    <tr class = "text-center">
                                                        <th class="tbl-head" width="100">Date</th>
                                                        <th class="tbl-head" width="100">Installment Amount</th>
                                                        <th class="tbl-head" width="100">Pending Amount</th>
                                                        <th class="tbl-head" width="100">Year</th>
                                                        <th class="tbl-head" width="100">Month</th>
                                                    </tr>
                                                
                                                    <tr class = "text-center">
                                                        <td style="color:black">
                                                            <b></b>
                                                        </td>
                                                        <td style="color:black">
                                                            <b></b>
                                                        </td>
                                                        <td style="color:black">
                                                            <b></b></td> 
                                                        <td style="color:black">
                                                            <b></b>
                                                        </td>
                                                        <td style="color:black">
                                                            <b> </b>
                                                        </td>
                                                    </tr>
                                                </table>
                    </div>
                    <div class="row">
                        <div class=" col-md-5 col-5">
                            <span class="mobile-title" style="font-size : 15px;color:black">TOTAL AMOUNT : <span id="total_advance_amount"></span> </span>
                        </div>
                        <div class=" col-md-5 col-5">
                            <span class="mobile-title" style="font-size : 15px;color:black">TOTAL PAID AMOUNT :<span id="total_paid_amount"></span> </span>
                        </div>
                    </div>
                    <div class="modal-footer pt-2 pb-0 mb-2">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
            </div>
        </div>
    </div>
</div>
<div id="EditSalaryModel" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header modal-call-report p-2">
                <div class=" col-md-10 col-10">
                    <span class="mobile-title" style="font-size : 20px;color:black">EDIT SALARY DETAILS</span>
                </div>
                <div class=" col-md-2 col-2">
                    <button type="button" class="text-white close" data-dismiss="modal">&times;</button>
                </div>
            </div>
            <!-- Modal body -->
            <div class="modal-body m-0">
                <?php $this->load->helper("form"); ?>
                <form role="form" id="" action="<?php echo base_url() ?>updateSalaryInfoByID" method="post" role="form">
                    <input type="hidden" name="salary_row_id" id="edit_row_id" value="" />
                    <input type="hidden" name="staff_row_id" value="<?php echo $staffInfo->row_id ?>">

                    <div class="row">
                        <div class="col-6 text-dark">
                            <label>Select Year</label>
                            <div class="form-group">
                                <select class="form-control input-sm selectpicker" id="edit_year" name="year" data-live-search="true" required>
                                    <!-- <option value="2023">2023</option> -->
                                    <option value="2024">2024</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6 text-dark">
                            <label for="cl">Enter Basic Salary</label>
                            <input type="text" class="form-control required" required id="edit_basic_salary" name="basic_salary" placeholder="Enter Advance Amount" onkeypress="return isNumberKey(event)" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 text-dark">
                            <label for="usr">Enter DA in % (eg: 30)</label>
                            <input onkeypress="return isNumberKey(event)" type="text" name="da" class="form-control" Placeholder="Enter DA" id="edit_da" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 text-dark">
                            <label for="usr">Enter HRA in % (eg: 20)</label>
                            <input onkeypress="return isNumberKey(event)" type="text" name="hr" class="form-control" Placeholder="Enter HR-1" id="edit_hr" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 text-dark">
                            <label for="usr">Enter Others</label>
                            <input onkeypress="return isNumberKey(event)" type="text" name="others" class="form-control" Placeholder="Enter Others" id="edit_others" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 text-dark">
                            <label for="usr">Employer PF(if not applicable, please enter 0)</label>
                            <input onkeypress="return isNumberKey(event)" type="text" name="management_pf"
                                class="form-control" Placeholder="Enter Management PF" id="edit_management_pf" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 text-dark">
                            <label for="usr">Employee PF (if PF is not applicable, please enter 0)</label>
                            <input onkeypress="return isNumberKey(event)" type="text" name="pf" class="form-control" Placeholder="Enter PF" id="edit_pf" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 text-dark">
                            <label for="usr">Employer ESI in %(if not applicable, please enter 0)</label>
                            <input onkeypress="return isNumberKey(event)" type="text" name="management_esi"
                                class="form-control" Placeholder="Enter Management ESI" id="edit_management_esi" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 text-dark">
                            <label for="usr">Enter ESI in %(if ESI is not applicable, please enter 0)</label>
                            <input onkeypress="return isNumberKey(event)" type="text" name="esi" class="form-control" Placeholder="Enter ESI" id="edit_esi" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6 text-dark">
                            <label for="usr">Enter PT (if PT is not applicable, please enter 0)</label>
                            <input onkeypress="return isNumberKey(event)" type="text" name="pt" class="form-control" Placeholder="Enter PT" id="edit_pt" autocomplete="off">
                        </div>

                    </div>
                    <div class="form-group">
                        <input style="float:right;" type="submit" class="btn btn-primary" value="Update" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="addOTInfoModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">ADD OT DETAILS</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2 m-1">
                <!--  -->
                <form action="<?php echo base_url() ?>addOTDetails" method="POST" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="row_id" value="<?php echo $staffInfo->row_id ?>">
                    <input type="hidden" name="staff_id" value="<?php echo $staffInfo->staff_id ?>">
                    <div class="row">
                        <div class="col-6 text-dark">
                            <label>Select Date</label>
                            <div class="form-group">
                                <input type="text" value="<?php echo date('d-m-Y') ?>" name="date" class="form-control datepicker input-sm" placeholder="Date" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group col-md-6 text-dark">
                            <label for="hours_minutes">Enter Hours and Minutes (e.g., 1.30)</label>
                            <input oninput="calculateOT(); validateInput();" onkeypress="return isNumberKey(event)" maxlength="5" type="text" name="hours_minutes" class="form-control" required placeholder="Enter Hours and Minutes" id="hours_minutes" autocomplete="off">
                        </div>

                        <!-- <div class="form-group col-md-6 text-dark">
                                    <label for="hours">Enter Hours</label>
                                    <input oninput="calculateOT()" type="number" name="hours" class="form-control" required placeholder="Enter Hours" id="hours" autocomplete="off">
                                </div>

                                <div class="form-group col-md-6 text-dark">
                                    <label for="minutes">Enter Minutes</label>
                                    <input oninput="calculateOT()" type="number" name="minutes" class="form-control" required placeholder="Enter Minutes" id="minutes" autocomplete="off">
                                </div> -->
                        <div class="col-6 text-dark">
                            <label>Select Amount Per Hour</label>
                            <div class="form-group">
                                <select onchange="calculateOT()" class="form-control input-sm selectpicker" id="ot_amount" name="ot_amount" data-live-search="true" required>
                                    <?php foreach ($OTAmountInfo as $info) { ?>
                                        <option value="<?php echo $info->ot_amount ?>"><?php echo $info->ot_amount ?></option>
                                    <?php  } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6 text-dark">
                            <label for="usr">Total Amount</label>
                            <input readonly type="text" name="total_ot_amount" class="form-control" Placeholder="Total Amount" id="total_ot_amount" autocomplete="off">
                        </div>
                    </div>
            </div>
            <div class="modal-footer pt-2 pb-0 mb-2">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button id="staffInfoDownload" type="submit" class="btn btn-md btn-success"> SAVE</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div id="EditOTModel" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header modal-call-report p-2">
                <div class=" col-md-10 col-10">
                    <span class="mobile-title" style="font-size : 20px;color:white">EDIT OT DETAILS</span>
                </div>
                <div class=" col-md-2 col-2">
                    <button type="button" class="text-white close" data-dismiss="modal">&times;</button>
                </div>
            </div>
            <!-- Modal body -->
            <div class="modal-body m-0">
                <?php $this->load->helper("form"); ?>
                <form role="form" id="" action="<?php echo base_url() ?>updateOTInfoByID" method="post" role="form">
                    <input type="hidden" name="OT_row_id" id="edit_ot_row_id" value="" />
                    <input type="hidden" name="staff_row_id" value="<?php echo $staffInfo->row_id ?>">

                    <div class="row">
                        <div class="col-6 text-dark">
                            <label>Select Date</label>
                            <div class="form-group">
                                <input type="text" value="<?php echo date('d-m-Y') ?>" name="date" id="edit_date" class="form-control datepicker input-sm" placeholder="Date" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group col-md-6 text-dark">
                            <label for="hours_minutes">Enter Hours and Minutes (e.g., 1.30)</label>
                            <input oninput="calculateOTedit(); validateInputedit();" onkeypress="return isNumberKey(event)" maxlength="5" type="text" name="hours_minutes" class="form-control" required placeholder="Enter Hours and Minutes" id="edit_no_of_hours" autocomplete="off">
                        </div>
                        <div class="col-6 text-dark">
                            <label>Select Amount Per Hour</label>
                            <div class="form-group">
                                <select onchange="calculateOTedit()" class="form-control input-sm selectpicker" id="edit_ot_amount" name="ot_amount" data-live-search="true" required>
                                    <?php foreach ($OTAmountInfo as $info) { ?>
                                        <option value="<?php echo $info->ot_amount ?>"><?php echo $info->ot_amount ?></option>
                                    <?php  } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6 text-dark">
                            <label for="usr">Total Amount</label>
                            <input readonly type="text" name="total_ot_amount" class="form-control" Placeholder="Total Amount" id="edit_total_amount" autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer pt-2 pb-0 mb-2 mr-6">
                        <input style="float:right;" type="submit" class="btn btn-primary" value="Update" />
                    </div>
                </div>
           
                </form>
            </div>
        </div>
    </div>
</div>
<!-- The Modal
<div class="modal fade" id="assignSubjects">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

        <div class="modal-header exportModel">
            <h4 class="modal-title">Assign Subjects</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body px-1 pt-1 pb-3">
            <div class="">
                <table class="table table-bordered text-dark mb-0 table_info">
                    <thead class="text-center">
                        <tr class="table_row_background">
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                            <th>Subject Type</th>
                            <th>Class & Section</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($subjectInfo)) {
                        foreach ($subjectInfo as $sub) { ?>
                    
                        <form method="post" role="form" action="<?php echo base_url() ?>updateSchoolStaffSubjects" id="assignSubject">
                            <input type="hidden" value="<?php echo $staffInfo->row_id; ?>" id="row_id" name="row_id">
                            <input type="hidden" value="<?php echo $staffInfo->staff_id; ?>" id="staff_id" name="staff_id">
                            <input type="hidden" value="<?php echo $sub->row_id; ?>" id="sub_id" name="sub_id">
                            <input type="hidden" value="<?php echo $sub->subject_code; ?>" id="subject_code" name="subject_code">
                            <tr class="text-center">
                                <td class="text-center"><?php echo $sub->subject_code; ?></td>
                                <td><?php echo $sub->sub_name; ?></td>
                                <td class="text-center">
                                    <div class="form-group m-0">
                                        <select class="form-control"  name="subjectType" id="subject_type" required>
                                            <option value="">Select Type</option>
                                             <option value="THEORY">THEORY</option> 
                                            <?php if ($sub->lab_status == 'true') { ?>
                                             <option value="LAB">LAB</option> 
                                            <?php } ?>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group m-0">
                                        <select class="form-control"  name="section_id" id="" required>
                                            <option value="">Select</option>
                                            <?php if (!empty($sectionInfo)) {
                                                foreach ($sectionInfo as $section) { ?>
                                            <option value="<?php echo $section->row_id ?>"><?php echo $section->term_name ?> - <?php echo $section->section_name ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </td>
                                <td >
                                    <button type="submit"  class="btn btn-info"><i class="fa fa-plus"></i> Add</button>
                                </td>
                            </tr>
                        </form>
                        <?php }
                    } else { ?>
                        <tr class="text-center">
                            <th colspan="5" style="background-color: #83c8ea7d;">Staff subject is not available</th>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div> -->

<div class="modal" id="addNewDocModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Remarks Details</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2 m-1">

                <form action="<?php echo base_url() ?>addRemarksToStaff" method="POST" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="row_id" value="<?php echo $staffInfo->row_id ?>">
                    <!-- <div class="text-center" id="alertMsg"></div> -->

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="text" value="<?php echo date('d-m-Y') ?>" name="date" class="form-control datepicker input-sm remarks_date" placeholder="Date" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">

                                <label>Remarks Type</label>
                                <!-- <input type="text" name="remarks_type" class="form-control input-sm" placeholder="Remarks Type" autocomplete="off" required> -->
                                <select class="form-control input-sm selectpicker" id="remarks_type"
                                    name="remarks_type" data-live-search="true" required>
                                    <option value="">Select Remarks</option>
                                    <?php if (!empty($remarkNameInfo)) {
                                        foreach ($remarkNameInfo as $obsinfo) { ?>
                                    <option value="<?php echo $obsinfo->row_id; ?>">
                                        <?php echo $obsinfo->remark_name; ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">

                                <img src="<?php echo base_url(); ?>assets/dist/img/file_upload.png" class="avatar rounded-circle img-thumbnail" width="100" height="100" src="#" id="uploadedImage3" name="userfile" width="100" height="100" alt="File">
                                <div class="observeFile">
                                    <div class="file btn btn-sm">
                                        <input type="file" class="form-control-sm" id="oFile" name="userfile" accept="*.jpg,*.png,*.jpeg,,*.pdf">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-6">
                            <div class="form-group">
                                <label>Remarks</label>
                                <textarea name="description" id="description" rows="4" class="form-control" placeholder="Enter Remarks" autocomplete="off" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-2 pb-0">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button id="staffInfoDownload" type="submit" class="btn btn-md btn-success">
                            SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="addSalaryModelNew">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><b>ADD SALARY DETAILS</b></h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" style="padding: 25px; max-height: 600px; overflow-y: scroll;">
                <form action="<?php echo base_url() ?>addSalaryDetailsNew" method="POST" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="row_id" value="<?php echo $staffInfo->row_id ?>">
                    <input type="hidden" name="staff_id" value="<?php echo $staffInfo->staff_id ?>">

                    <div class="row row-container">
                        <!-- Earnings Section -->
                        <div class="col-6">
                            <div class="section">
                                <h5 class="text-center section-title">Earnings</h5>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label>Select Year</label>
                                        <select class="form-control input-sm selectpicker" name="earnings_year" data-live-search="true">
                                        <?php if (!empty($salaryYearInfo)) {
                                                        foreach ($salaryYearInfo as $record) { ?>
                                                            <option value="<?php echo $record->year; ?>"><?php echo $record->year; ?></option>
                                                        <?php }
                                                    } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Salary Type</label>
                                        <select class="form-control input-sm selectpicker" name="earnings_salary_type" data-live-search="true">
                                            <option value="">Select Salary Type</option>
                                            <?php if (!empty($earningSalaryTypeInfo)) {
                                                foreach ($earningSalaryTypeInfo as $record) { ?>
                                                    <option value="<?php echo $record->salary_type; ?>"><?php echo $record->salary_type; ?></option>
                                                <?php }
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Calculation Type</label>
                                        <input class="form-control input-sm" name="earnings_calculation_type" placeholder="Calculation Type" readonly />
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Value</label>
                                        <input type="text" onkeypress="return isNumberKey(event)" class="form-control" name="earnings_value" placeholder="Enter Value">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12 text-right">
                                        <button type="button" class="btn btn-primary" id="addEarnings"><i class="fa fa-plus"></i> <b>Add Earnings</b></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Center Line -->
                        <div class="vertical-line"></div>

                        <!-- Deductions Section -->
                        <div class="col-6">
                            <div class="section">
                                <h5 class="text-center section-title">Deductions</h5>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label>Select Year</label>
                                        <select class="form-control input-sm selectpicker" name="deductions_year" data-live-search="true">
                                        <?php if (!empty($salaryYearInfo)) {
                                                        foreach ($salaryYearInfo as $record) { ?>
                                                            <option value="<?php echo $record->year; ?>"><?php echo $record->year; ?></option>
                                                        <?php }
                                                    } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Salary Type</label>
                                        <select class="form-control input-sm selectpicker" name="deductions_salary_type" data-live-search="true">
                                            <!-- Populate with salary types from the database -->
                                            <option value="">Select Salary Type</option>
                                            <?php if (!empty($deductionSalaryTypeInfo)) {
                                                foreach ($deductionSalaryTypeInfo as $record) { ?>
                                                    <option value="<?php echo $record->salary_type; ?>"><?php echo $record->salary_type; ?></option>
                                                <?php }
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Calculation Type</label>
                                        <input class="form-control input-sm" name="deductions_calculation_type" placeholder="Calculation Type" readonly />
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Value</label>
                                        <input type="text" onkeypress="return isNumberKey(event)" class="form-control" name="deductions_value" placeholder="Enter Value">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12 text-right">
                                        <button type="button" class="btn btn-primary" id="addDeductions"><i class="fa fa-plus"></i> <b>Add Deduct</b></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings Table -->
                    <div class="section mt-4">
                        <!-- <h5 class="text-center section-title">Earnings</h5> -->
                        <table class="table table-bordered" id="earningsTable">
                            <thead>
                                 <tr>
                                    <th colspan="5" class="text-center tbl-head-content1" style="font-size:18px;">Earnings</th>
                                </tr>
                                <tr>
                                    <th class="tbl-head1">Year</th>
                                    <th class="tbl-head1">Salary Type</th>
                                    <th class="tbl-head1">Calculation Type</th>
                                    <th class="tbl-head1">Value</th>
                                    <th class="tbl-head1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Earnings items will be appended here -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Deductions Table -->
                    <div class="section mt-4">
                        <table class="table table-bordered" id="deductionsTable">
                            <thead>
                                <tr>
                                    <th colspan="5" class="text-center tbl-head-content1" style="font-size:18px;">Deduction</th>
                                </tr>
                                <tr>
                                    <th class="tbl-head1">Year</th>
                                    <th class="tbl-head1">Salary Type</th>
                                    <th class="tbl-head1">Calculation Type</th>
                                    <th class="tbl-head1">Value</th>
                                    <th class="tbl-head1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Deductions items will be appended here -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Submit Button -->
                    <div class="modal-footer pt-2 pb-0 mb-2">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button id="staffInfoDownload" type="submit" class="btn btn-md btn-success">SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- The Modal -->

<div class="modal fade" id="assignSubjects">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">



            <!-- Modal Header -->

            <div class="modal-header exportModel">

                <h4 class="modal-title">Assign Subjects</h4>

                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>



            <!-- Modal body -->

            <div class="modal-body px-1 pt-1 pb-3">

                <div class="">

                    <table class="table table-bordered text-dark mb-0 table_info">

                        <thead class="text-center">

                            <tr class="table_row_background">

                                <th>Subject Code</th>

                                <th>Subject Name</th>

                                <th>Subject Type</th>

                                <th>Department</th>

                                <th>Actions</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php if (!empty($subjectInfo)) {

                                foreach ($subjectInfo as $sub) { ?>

                                    <form method="post" role="form" action="<?php echo base_url() ?>updateStaffSubjects">

                                        <input type="hidden" value="<?php echo $staffInfo->row_id; ?>" id="row_id" name="row_id">

                                        <input type="hidden" value="<?php echo $staffInfo->staff_id; ?>" id="staff_id" name="staff_id">

                                        <input type="hidden" value="<?php echo $sub->row_id; ?>" id="sub_id" name="sub_id">

                                        <input type="hidden" value="<?php echo $sub->subject_code; ?>" id="subject_code" name="subject_code">

                                        <tr class="text-center">

                                            <td class="text-center"><?php echo $sub->subject_code; ?></td>

                                            <td><?php echo $sub->sub_name; ?></td>

                                            <td>

                                                <div class="form-group m-0">

                                                    <select class="form-control" name="subjectType" id="subjectType" required>

                                                        <option value="">Select Type</option>

                                                        <option value="THEORY">THEORY</option>

                                                        <?php if ($sub->lab_status == 'true') { ?>

                                                            <option value="LAB">LAB</option>

                                                        <?php } ?>

                                                    </select>

                                                </div>

                                            </td>

                                            <td class="text-center"><?php echo $sub->name ?></td>

                                            <td class="text-center">

                                                <button type="submit" class="btn btn-info"><i class="fa fa-plus"></i>
                                                    Add</button>

                                            </td>

                                        </tr>

                                    </form>

                                <?php }
                            } else { ?>

                                <tr class="text-center">

                                    <th colspan="5" style="background-color: #83c8ea7d;">Staff subject is not
                                        available</th>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>



            <!-- Modal footer -->

            <div class="modal-footer">

                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

            </div>

        </div>

    </div>

</div>



<!-- The Modal -->

<div class="modal fade" id="assignSection">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">



            <!-- Modal Header -->

            <div class="modal-header exportModel">

                <h4 class="modal-title">Assign Class</h4>

                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>



            <!-- Modal body -->

            <div class="modal-body px-1 pt-1 pb-1">

                <div class="">

                    <table class="table table-bordered text-dark mb-0 table_info">

                        <thead class="text-center">

                            <tr class="table_row_background">

                                <th>Term Name</th>

                                <th>Stream Name</th>

                                <th>Section</th>

                                <th>Actions</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php if (!empty($sectionInfo)) {

                                foreach ($sectionInfo as $section) { ?>

                                    <tr class="text-center">

                                        <form method="POST" role="form" action="<?php echo base_url(); ?>updateStaffSection">

                                            <input type="hidden" value="<?php echo $staffInfo->row_id; ?>" id="row_id" name="row_id">

                                            <input type="hidden" value="<?php echo $staffInfo->staff_id; ?>" id="staff_id" name="staff_id">

                                            <input type="hidden" value="<?php echo $section->row_id; ?>" id="section_id" name="section_id">

                                            <td><?php echo $section->term_name; ?></td>

                                            <td><?php echo $section->stream_name; ?></td>

                                            <td><?php echo $section->section_name ?></td>

                                            <td class="text-center">

                                                <button type="submit" class="btn btn-info"><i class="fa fa-plus"></i>
                                                    Add</button>

                                            </td>

                                        </form>

                                    </tr>

                                <?php }
                            } else { ?>

                                <tr class="text-center">

                                    <th colspan="5" style="background-color: #83c8ea7d;">Staff class is not
                                        available</th>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>



            <!-- Modal footer -->

            <div class="modal-footer">

                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

            </div>

        </div>

    </div>

</div>

<!-- The Modal -->
<div class="modal fade" id="addLeave">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header exportModel">
                <h4 class="modal-title">Leave Info</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body px-1 pt-1 pb-3">
                <div class="col-lg-12 col-md-8 col-12">
                    <form role="form" action="<?php echo base_url() ?>updateLeaveInfo" method="post">

                        <input type="hidden" value="<?php echo $staffInfo->row_id; ?>" id="row_id_leave" name="row_id_leave">
                        <input type="hidden" value="<?php echo $staffInfo->staff_id; ?>" name="staff_id_leave" />
                        <div class="row">
                            <div class="col-12 col-lg-6 col-md-6">
                                <label for="cl">Year</label>
                                <select class="form-control input-sm selectpicker" id="leave_year" name="leave_year" required data-live-search="true" required>
                                <?php if (!empty($leaveYearInfo)) {
                                    foreach ($leaveYearInfo as $record) { ?>
                                        <option value="<?php echo $record->year; ?>"><?php echo $record->year; ?></option>
                                    <?php }
                                     } ?>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6 col-md-6">
                                <label for="cl">Casual Leave</label>
                                <input type="text" class="form-control required digits" id="casual_leave" value="0" name="casual_leave" maxlength="5" placeholder="Add Casual Leave" onkeypress="return isNumberKey(event)" required autocomplete="off">
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <label for="cl">Medical Leave</label>
                                <input type="text" class="form-control required digits" id="sick_leave" value="0" name="sick_leave" maxlength="5" placeholder="Add Medical Leave" onkeypress="return isNumberKey(event)" autocomplete="off">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-lg-6 col-md-6">
                                <label for="pl">Paternity Leave</label>
                                <input type="text" class="form-control required digits" id="paternity_leave" value="0" name="paternity_leave" maxlength="5" placeholder="Add Paternity Leave" onkeypress="return isNumberKey(event)" autocomplete="off">
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <label for="marriage_leave">Marriage Leave</label>
                                <input type="text" class="form-control required digits" id="marriage_leave" value="0" name="marriage_leave" maxlength="5" placeholder="Add Marriage Leave" onkeypress="return isNumberKey(event)" autocomplete="off">
                            </div>
                        </div>
                        <?php $active; ?>
                        <div class="row">
                            <div class="col-12 col-lg-6 col-md-6">
                                <label for="cl">Maternity Leave</label>
                                <input type="text" class="form-control required digits" id="maternity_leave" value="0" name="maternity_leave" maxlength="5" placeholder="Add Maternity Leave" onkeypress="return isNumberKey(event)" autocomplete="off">
                            </div>
                            <!-- <div class="col-12 col-lg-6 col-md-6">
                                        <label for="cl">Loss of Pay</label>
                                        <input type="text" class="form-control required digits" id="lop" value="0"
                                            name="lop" maxlength="5" placeholder="Add Loss of Pay"
                                            onkeypress="return isNumberKey(event)" autocomplete="off">
                                    </div> -->
                            <div class="col-12 col-lg-6 col-md-6">
                                <label for="el">Earned Leave</label>
                                <input type="text" class="form-control required digits" id="earned_leave_earned" value="0" name="earned_leave_earned" maxlength="5" placeholder="Add Earned Leave" onkeypress="return isNumberKey(event)" autocomplete="off">
                            </div>
                            <div class="col-12 col-lg-6 col-md-6">
                                <label for="el">Official Duty</label>
                                <input type="text" class="form-control required digits"
                                    id="official_duty"
                                    value="0"
                                    name="official_duty" maxlength="5"
                                    placeholder="Add Official Duty"
                                    onkeypress="return isNumberKey(event)" autocomplete="off">
                            </div>
                        </div>
                        

                        <div class="row mt-2">
                            <div class="col-12 col-lg-12 col-md-12">
                                <button type="submit" class="btn btn-secondary float-right">
                                    Add </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery UI library -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/staff.js" charset="utf-8"></script>
<script>
    // document.getElementById('leave_approved_status').addEventListener('change', function() {
    //     this.value = this.checked ? '1' : '0';
    // });
    $("#search_staff").change(function() {
        var row_id = $("#search_staff").val();
        if (row_id != '') {

            window.open('<?php echo base_url() ?>editStaff/' + row_id, "_self");
        }
    });

    function showLessNotification(){
        if(localStorage.getItem("NSEGID") !=null){
        let curSegmentID = parseInt(localStorage.getItem("NSEGID"));
            if(curSegmentID != 1){
                $(".notificationSegment_"+curSegmentID).hide();
                localStorage.setItem("NSEGID",curSegmentID-1);
            }
        }
    }
    function loadMoreNotification(){
        let nextSegmentID = 1;
        if(localStorage.getItem("NSEGID") !=null){
            nextSegmentID = parseInt(localStorage.getItem("NSEGID")) + 1;
        }
        if($(".notificationSegment_"+nextSegmentID).length == 0){
            alert("There is no more notifications to load..");
        }else{
            localStorage.setItem("NSEGID",nextSegmentID);
            $(".notificationSegment_"+nextSegmentID).show();
        }
    }

    $(document).ready(function() {
        // Add Row Button Click Event

        var activeTabId = localStorage.getItem('activeTabId');

        // If the ID is not null or undefined, activate the corresponding tab
        if (activeTabId) {
            $('#myTab a[href="#' + activeTabId + '"]').tab('show');
        }

        // Store the ID of the clicked tab in local storage
        $('#myTab a').on('click', function() {
            var tabId = $(this).attr('href').substring(1);
            localStorage.setItem('activeTabId', tabId);
        });



        // $(".year-picker").datepicker({
        //     changeYear: true,
        //     showButtonPanel: true,
        //     dateFormat: 'yy',
        //     yearRange: '1980:2025',
        //     onClose: function(dateText, inst) {
        //         var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
        //         $(this).datepicker('setDate', new Date(year, 1));
        //     }
        // });

        // // Ensure the datepicker shows only the year
        // $(".year-picker").focus(function () {
        //     $(".ui-datepicker-month").hide();
        //     $(".ui-datepicker-calendar").hide();
        // });

        $(".examiner_fields").hide();
        $(".pta_fields").hide();
        $(".cordinator_fields").hide();

        $('#addRow').click(function() {
            var newRow = $('#additionalRowTemplate').clone().removeAttr('id').show();
            $('.table2 tbody').append(newRow);
        });
        // Add Row Button Click Event
        // $('#addRow1').click(function() {
        //     var newRow = $('#additionalEducationRowTemplate').clone().removeAttr('id').show();
        //     $('.table3 tbody tr:last').after(newRow); // Append the new row after the last row
        // });
        initializeYearPicker(".year-picker");

        $("#addRow1").click(function() {
            var newRow = $("#additionalEducationRowTemplate").clone().removeAttr('id').show();
            newRow.find("input[name='year_of_passing[]']").addClass("year-picker");
            $(newRow).insertBefore("#additionalEducationRowTemplate");

            // Initialize year-picker for the new row
            initializeYearPicker(newRow.find(".year-picker"));
        });

        // Remove Row Button Click Event
        $(document).on("click", ".removeEducationRow", function() {
            $(this).closest('tr').remove();
        });

        mdc.textField.MDCTextField.attachTo(document.querySelector('.staff_id'));
        // mdc.textField.MDCTextField.attachTo(document.querySelector('.employee_id'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.fname'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.dob'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.email'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.mobile'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.doj'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.address'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.date_resignation'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.date_retirement'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.date_retired'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.aadhar_no'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.pan_no'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.voter_no'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.pf_number'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.qualification'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.esi_code'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.bank_name'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.branch_name'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.account_no'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.ifsc_code'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.password'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.cNewPassword'));
        // mdc.textField.MDCTextField.attachTo(document.querySelector('.stfname'));

        mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-gender'));
        mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-role'));
        mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-department'));
        mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-blood-group'));
        // mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-tax_regime'));
        mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-designation'));
        mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-shift'));
        // mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-staffType'));s
        // const role = new mdc.select.MDCSelect(document.querySelector('.role'));

        mdc.textField.MDCTextField.attachTo(document.querySelector('.uan_no'));
        // mdc.textField.MDCTextField.attachTo(document.querySelector('.tax_regime'));
        //   mdc.textField.MDCTextField.attachTo(document.querySelector('.monthly_income'));

        // mdc.textField.MDCTextField.attachTo(document.querySelector('.casual_leave'));
        // mdc.textField.MDCTextField.attachTo(document.querySelector('.sick_leave'));
        // mdc.textField.MDCTextField.attachTo(document.querySelector('.paternity_leave'));
        // mdc.textField.MDCTextField.attachTo(document.querySelector('.marriage_leave'));
        // mdc.textField.MDCTextField.attachTo(document.querySelector('.maternity_leave'));
        // mdc.textField.MDCTextField.attachTo(document.querySelector('.earned_leave'));
        // mdc.textField.MDCTextField.attachTo(document.querySelector('.lop'));
        // Remove Row Button Click Event
        $(document).on('click', '.removeRow', function() {
            $(this).closest('tr').remove();
        });


        var examiner = $("#examiner").val();
        // alert(examiner);
        if (examiner == 'NO') {
            $(".examiner_fields").hide();
        } else if (examiner == 'YES') {
            $(".examiner_fields").show();
        }

        var pta_member = $("#pta_member").val();
        // alert(examiner);
        if (pta_member == 'NO') {
            $(".pta_fields").hide();
            $('#pta_year').prop('required', false);
        } else if (pta_member == 'YES') {
            $(".pta_fields").show();
            $('#pta_year').prop('required', true);
        }

        var cordinator = $("#cordinator").val();
        // alert(examiner);
        if (cordinator == 'NO') {
            $(".cordinator_fields").hide();
            $('#coordinator_year').prop('required', false);
        } else if (cordinator == 'YES') {
            $(".cordinator_fields").show();
            $('#coordinator_year').prop('required', true);
        }


        // jQuery('.datepicker , .datepicker_doj').datepicker({
        //     autoclose: true,
        //     format: "dd-mm-yyyy",
        //     changeYear: true,
        //     yearRange: "-100:+10",
        //     endDate: "today"
        // });
        jQuery('.datepicker, .datepicker_doj').datepicker({
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+10",
            maxDate: 0 // Prevent selection of future dates 
        });


        function handleDateChange(datepickerClass, textFieldClass) {
            jQuery(datepickerClass).change(function() {
                const mdcFloatingLabel = new mdc.textField.MDCTextField(document.querySelector(textFieldClass));
                mdcFloatingLabel.label_.float(true);
            });
        }

        handleDateChange('.datepicker', '.dob');
        handleDateChange('.datepicker_doj', '.doj');
        handleDateChange('#resign_date', '.do_resign');
        handleDateChange('#retirement_date', '.date_retirement');
        handleDateChange('#retired_date', '.date_retired');





        jQuery('.datepicker_resign').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            startDate: "01-01-2021",
            changeYear: true,
            yearRange: "-100:+0",
            // endDate: "today"
        });

        $("#examiner").change(function() {
            var examiner = $("#examiner").val();
            // alert(examiner);
            if (examiner == 'NO') {
                $(".examiner_fields").hide();
            } else if (examiner == 'YES') {
                $(".examiner_fields").show();
            }

        });

        $("#pta_member").change(function() {
            var pta_member = $("#pta_member").val();
            // alert(examiner);
            if (pta_member == 'NO') {
                $(".pta_fields").hide();
                $('#pta_year').prop('required', false);
            } else if (pta_member == 'YES') {
                $(".pta_fields").show();
                $('#pta_year').prop('required', true);
            }

        });

        $("#cordinator").change(function() {
            var cordinator = $("#cordinator").val();
            // alert(examiner);
            if (cordinator == 'NO') {
                $(".cordinator_fields").hide();
                $('#coordinator_year').prop('required', false);
            } else if (cordinator == 'YES') {
                $(".cordinator_fields").show();
                $('#coordinator_year').prop('required', true);
            }

        });

        let earningsIndex = 0;
        let deductionsIndex = 0;

        $('#addEarnings').click(function() {
            let year = $('select[name="earnings_year"]').val();
            let salaryType = $('select[name="earnings_salary_type"]').val();
            let calculationType = $('input[name="earnings_calculation_type"]').val();
            let value = $('input[name="earnings_value"]').val();

            if (year && salaryType && calculationType && value) {
                var row = `<tr>
                    <td><input type="hidden" name="earnings[${earningsIndex}][year]" value="${year}">${year}</td>
                    <td><input type="hidden" name="earnings[${earningsIndex}][salary_type]" value="${salaryType}">${salaryType}</td>
                    <td><input type="hidden" name="earnings[${earningsIndex}][calculation_type]" value="${calculationType}">${calculationType}</td>
                    <td><input type="hidden" name="earnings[${earningsIndex}][value]" value="${value}">${value}</td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
                </tr>`;
                $('#earningsTable tbody').append(row);
                
                // Increment the index for the next row
                earningsIndex++;

                // Clear form fields
            
                $('input[name="earnings_calculation_type"]').val('');
                $('input[name="earnings_value"]').val('');
            }
        });

        $('#addDeductions').click(function() {
            let year = $('select[name="deductions_year"]').val();
            let salaryType = $('select[name="deductions_salary_type"]').val();
            let calculationType = $('input[name="deductions_calculation_type"]').val();
            let value = $('input[name="deductions_value"]').val();

            if (year && salaryType && calculationType && value) {
                var row = `<tr>
                    <td><input type="hidden" name="deductions[${deductionsIndex}][year]" value="${year}">${year}</td>
                    <td><input type="hidden" name="deductions[${deductionsIndex}][salary_type]" value="${salaryType}">${salaryType}</td>
                    <td><input type="hidden" name="deductions[${deductionsIndex}][calculation_type]" value="${calculationType}">${calculationType}</td>
                    <td><input type="hidden" name="deductions[${deductionsIndex}][value]" value="${value}">${value}</td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
                </tr>`;
                $('#deductionsTable tbody').append(row);

                // Increment the index for the next row
                deductionsIndex++;

                // Clear form fields
            
                $('input[name="deductions_calculation_type"]').val('');
                $('input[name="deductions_value"]').val('');
            }
        });

        // Remove row functionality
        // $('#earningsTable, #deductionsTable').on('click', '.remove-row', function() {
        //     $(this).closest('tr').remove();
        // });



        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
        });

        $(document).on('click', '.remove-row1', function() {
            $(this).closest('tr').remove();
        });


        $('select[name="earnings_salary_type"]').change(function() {
            var salaryType = $(this).val();

            $.ajax({
                url: '<?php echo base_url(); ?>/getCalculationType',
                type: 'POST',
                data: { salary_type: salaryType },
                dataType: 'json',
                success: function(response) {
                    $('input[name="earnings_calculation_type"]').val(response.calculate_type);
                }
            });
        });

        $('select[name="deductions_salary_type"]').change(function() {
            var salaryType = $(this).val();

            $.ajax({
                url: '<?php echo base_url(); ?>/getCalculationType',
                type: 'POST',
                data: { salary_type: salaryType },
                dataType: 'json',
                success: function(response) {
                    $('input[name="deductions_calculation_type"]').val(response.calculate_type);
                }
            });
        });

        $('.dd_bank_name').hide();
        $('.dd_info').hide();
        $('.card_info').hide();
        $('.bank_info').hide();
        $('.neft_info').hide();
        $('.upi_info').hide();

        $('.dd_bank_name1').hide();
        $('.dd_info1').hide();
        $('.card_info1').hide();
        $('.bank_info1').hide();
        $('.neft_info1').hide();
        $('.upi_info1').hide();
    $("#payment_type").on('change', function() {
            var semester = [];
            var payment_type = $("#payment_type").val();
            if (payment_type == "DD") {
                $('.dd_bank_name').show();
                $('.dd_info').show();
                $('.card_info').hide();
                $('.bank_info').hide();
                $('.neft_info').hide();
                $('.upi_info').hide();
            } else if (payment_type == "BANK") {
                $('.dd_bank_name').show();
                $('.dd_info').hide();
                $('.card_info').hide();
                $('.bank_info').show();
                $('.neft_info').hide();
                $('.upi_info').hide();
            } else if (payment_type == "CASH") { 
                $('.dd_bank_name').hide();
                $('.dd_info').hide();
                $('.neft_info').hide();
                $('.bank_info').hide();
                $('.upi_info').hide();
            } else if (payment_type == "CARD") {
                $('.dd_bank_name').hide();
                $('.dd_info').hide();
                $('.card_info').show();
                $('.bank_info').hide();
                $('.neft_info').hide();
                $('.upi_info').hide();
            } else if (payment_type == "NEFT") {
                $('.dd_bank_name').hide();
                $('.dd_info').hide();
                $('.upi_info').hide();
                // $('.card_info').hide();
                $('.neft_info').show();
            } else if (payment_type == "UPI") {
                $('.dd_bank_name').hide();
                $('.upi_info').show();
                $('.bank_info').hide();
                // $('.card_info').hide();
                $('.dd_info').hide();
                $('.neft_info').hide();
            } else {
                $('.dd_bank_name').hide();
                $('.dd_info').hide();
                // $('.card_info').hide();
                $('.bank_info').hide();
                $('.neft_info').hide();
            }
        });

        $("#repayment_period, #advance_amount").on('input', function() {
            var repayment_period = Number($('#repayment_period').val());
            var advance_amount = Number($('#advance_amount').val());

            if (!isNaN(repayment_period) && !isNaN(advance_amount) && repayment_period > 0) {
                var installment_amount = advance_amount / repayment_period;
                var rounded_installment_amount = Math.ceil(installment_amount);
                $('#installment_amount').val(rounded_installment_amount);
            } else {
                $('#installment_amount').val('');
            }
        });



    });

    function openTimeTableModel(row_id,date,advance_amount, payment_type,installment_amount,dd_number,dd_date,bank_tran_number, bank_tran_date,
bank_name,neft_date,ref_number,upi_number, repayment_period) {
    $('#subject_name_u option').remove();

    $('#Advance_row_id').val(row_id);
    $('#advance_amount1').val(advance_amount);
    $('#payment_type1').val(payment_type);
    $('#payment_type1').selectpicker('refresh');
    $('#installment_amount1').val(installment_amount);
    $('#dd_number1').val(dd_number);

    if (dd_date == ' ' || dd_date == '00-00-0000' || dd_date == '01-01-1970') {
        $('#bank_tran_date1').val(' ');
    }else{
        $('#dd_date1').val(dd_date);
    }
    $('#bank_tran_number1').val(bank_tran_number);
    if (bank_tran_date == ' ' || bank_tran_date == '00-00-0000' || bank_tran_date == '01-01-1970') {
        $('#bank_tran_date1').val(' ');
    }else{
        $('#bank_tran_date1').val(bank_tran_date);
    }
    $('#dd_bank_name1').val(bank_name);
     if (neft_date == ' ' || neft_date == '00-00-0000' || neft_date == '01-01-1970') {
        $('#neft_date1').val(' ');
     }else{
        $('#neft_date1').val(neft_date);
     }
    $('#ref_number1').val(ref_number);
    $('#upi_number1').val(upi_number);
    $('#repayment_period1').val(repayment_period);

    $('#triplModel').modal('show');

    var payment_type1 = $("#payment_type1").val();
            if (payment_type1 == "DD") {
                $('.dd_bank_name1').show();
                $('.dd_info1').show();
                $('.card_info1').hide();
                $('.bank_info1').hide();
                $('.neft_inf1o').hide();
                $('.upi_info1').hide();
            } else if (payment_type1 == "BANK") {
                $('.dd_bank_name1').show();
                $('.dd_info1').hide();
                $('.card_info1').hide();
                $('.bank_info1').show();
                $('.neft_info1').hide();
                $('.upi_info1').hide();
            } else if (payment_type1 == "CASH") { 
                $('.dd_bank_name1').hide();
                $('.dd_info1').hide();
                $('.neft_info1').hide();
                $('.bank_info1').hide();
                $('.upi_info1').hide();
            } else if (payment_type1 == "CARD") {
                $('.dd_bank_name1').hide();
                $('.dd_info1').hide();
                $('.card_info1').show();
                $('.bank_info1').hide();
                $('.neft_info1').hide();
                $('.upi_info1').hide();
            } else if (payment_type1 == "NEFT") {
                $('.dd_bank_name1').hide();
                $('.dd_info1').hide();
                $('.upi_info1').hide();
                $('.neft_info1').show();
            } else if (payment_type1 == "UPI") {
                $('.dd_bank_name1').hide();
                $('.upi_info1').show();
                $('.bank_info1').hide();
                $('.dd_info1').hide();
                $('.neft_info1').hide();
            } else {
                $('.dd_bank_name1').hide();
                $('.dd_info1').hide();
                $('.bank_info1').hide();
                $('.neft_info1').hide();
            }
            $("#payment_type1").on('change', function() {
                var payment_type1 = $("#payment_type1").val();
            if (payment_type1 == "DD") {
                $('.dd_bank_name1').show();
                $('.dd_info1').show();
                $('.card_info1').hide();
                $('.bank_info1').hide();
                $('.neft_inf1o').hide();
                $('.upi_info1').hide();
            } else if (payment_type1 == "BANK") {
                $('.dd_bank_name1').show();
                $('.dd_info1').hide();
                $('.card_info1').hide();
                $('.bank_info1').show();
                $('.neft_info1').hide();
                $('.upi_info1').hide();
            } else if (payment_type1 == "CASH") { 
                $('.dd_bank_name1').hide();
                $('.dd_info1').hide();
                $('.neft_info1').hide();
                $('.bank_info1').hide();
                $('.upi_info1').hide();
            } else if (payment_type1 == "CARD") {
                $('.dd_bank_name1').hide();
                $('.dd_info1').hide();
                $('.card_info1').show();
                $('.bank_info1').hide();
                $('.neft_info1').hide();
                $('.upi_info1').hide();
            } else if (payment_type1 == "NEFT") {
                $('.dd_bank_name1').hide();
                $('.dd_info1').hide();
                $('.upi_info1').hide();
                $('.neft_info1').show();
            } else if (payment_type1 == "UPI") {
                $('.dd_bank_name1').hide();
                $('.upi_info1').show();
                $('.bank_info1').hide();
                $('.dd_info1').hide();
                $('.neft_info1').hide();
            } else {
                $('.dd_bank_name1').hide();
                $('.dd_info1').hide();
                $('.bank_info1').hide();
                $('.neft_info1').hide();
            }
        });
        
    $(document).ready(function() {
        $("#repayment_period1, #advance_amount1").on('input', function() {
            var repayment_period = Number($('#repayment_period1').val());
            var advance_amount = Number($('#advance_amount1').val());

            if (!isNaN(repayment_period) && !isNaN(advance_amount) && repayment_period > 0) {
                var installment_amount = advance_amount / repayment_period;
                var rounded_installment_amount = Math.ceil(installment_amount);
                $('#installment_amount1').val(rounded_installment_amount);
            } else {
                $('#installment_amount1').val('');
            }
        });
    });

}

   
    
    function initializeYearPicker(element) {
            $(element).datepicker({
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'yy',
                yearRange: '1980:2025',
                beforeShow: function(input, inst) {
                    var rect = input.getBoundingClientRect();
                    setTimeout(function() {
                        inst.dpDiv.css({ top: rect.top + 80, left: rect.left + 0 });
                        $("#ui-datepicker-div").addClass("year-only");
                    }, 1);
                },
                onClose: function(dateText, inst) {
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    if (!year) {
                        return;
                    }
                    $(this).datepicker('setDate', new Date(year, 1));
                    setTimeout(function() {
                        $("#ui-datepicker-div").removeClass("year-only");
                    }, 1);
                }
            });
        }



    function openOTEditModel(row_id, date, no_of_hours, ot_amount, total_amount) {
        $('#edit_ot_row_id').val(row_id);
        $('#edit_date').val(date);
        $('#edit_no_of_hours').val(no_of_hours);
        $('#edit_ot_amount').val(ot_amount);
        $('#edit_ot_amount').selectpicker('refresh');
        $('#edit_total_amount').val(total_amount);
        $('#EditOTModel').modal('show');
    }

    function calculateOT() {
        var input = document.getElementById('hours_minutes').value;
        var otRate = parseFloat(document.getElementById('ot_amount').value);

        // Split the input into hours and minutes using a dot as the separator
        var parts = input.split('.');

        if (parts.length === 1) {
            // If no decimal point is present, treat it as "0 minutes" by appending ".00"
            input = input + '.00';
            parts = input.split('.');
        }

        if (parts.length === 2) {
            var hours = parseFloat(parts[0]);
            var minutes = parseFloat(parts[1]);

            if (!isNaN(hours) && !isNaN(minutes) && !isNaN(otRate) && hours >= 0 && minutes >= 0 && minutes < 60) {
                var totalAmount = (hours + minutes / 60) * otRate;
                document.getElementById('total_ot_amount').value = totalAmount.toFixed(2);
            } else {
                document.getElementById('total_ot_amount').value = '';
            }
        } else {
            document.getElementById('total_ot_amount').value = '';
        }
    }

    function validateInput() {
        const input = document.getElementById("hours_minutes");
        const pattern = /^\d+(\.\d{1,2})?$/;

        if (!pattern.test(input.value)) {
            input.setCustomValidity("Enter a valid format (e.g., 1.30)");
        } else {
            input.setCustomValidity("");
        }
    }

    function calculateOTedit() {
        var input = document.getElementById('edit_no_of_hours').value;
        var otRate = parseFloat(document.getElementById('edit_ot_amount').value);

        // Split the input into hours and minutes using a dot as the separator
        var parts = input.split('.');

        if (parts.length === 1) {
            // If no decimal point is present, treat it as "0 minutes" by appending ".00"
            input = input + '.00';
            parts = input.split('.');
        }

        if (parts.length === 2) {
            var hours = parseFloat(parts[0]);
            var minutes = parseFloat(parts[1]);

            if (!isNaN(hours) && !isNaN(minutes) && !isNaN(otRate) && hours >= 0 && minutes >= 0 && minutes < 60) {
                var totalAmount = (hours + minutes / 60) * otRate;
                document.getElementById('edit_total_amount').value = totalAmount.toFixed(2);
            } else {
                document.getElementById('edit_total_amount').value = '';
            }
        } else {
            document.getElementById('edit_total_amount').value = '';
        }
    }

    function validateInputedit() {
        const input = document.getElementById("edit_no_of_hours");
        const pattern = /^\d+(\.\d{1,2})?$/;

        if (!pattern.test(input.value)) {
            input.setCustomValidity("Enter a valid format (e.g., 1.30)");
        } else {
            input.setCustomValidity("");
        }
    }

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    function isPanKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        var input = evt.target;
        var value = input.value;

        // Allow backspace, delete, tab, escape, and enter
        if (charCode === 8 || charCode === 46 || charCode === 9 || charCode === 27 || charCode === 13 ||
            // Allow Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
            (charCode === 65 && evt.ctrlKey === true) ||
            (charCode === 67 && evt.ctrlKey === true) ||
            (charCode === 86 && evt.ctrlKey === true) ||
            (charCode === 88 && evt.ctrlKey === true) ||
            // Allow home, end, left, right
            (charCode >= 35 && charCode <= 39)) {
            return true;
        }

        // Validate character position
        var position = value.length;
        if (position < 5) {
            // First 5 characters must be letters (uppercase or lowercase)
             if (!((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122))) {
                return false;
            }
        } else if (position < 9) {
            // Next 4 characters must be digits
            if (charCode < 48 || charCode > 57) {
                return false;
            }
        } else if (position === 9) {
            // Last character must be a letter (uppercase or lowercase)
            if (!((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122))) {
                return false;
            }
        } else {
            // Prevent input if length exceeds 10 characters
            return false;
        }

        return true;
    }

function isEsiCodeKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    // Allow backspace, delete, tab, escape, and enter
    if (charCode === 8 || charCode === 46 || charCode === 9 || charCode === 27 || charCode === 13 ||
        // Allow Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
        (charCode === 65 && evt.ctrlKey === true) ||
        (charCode === 67 && evt.ctrlKey === true) ||
        (charCode === 86 && evt.ctrlKey === true) ||
        (charCode === 88 && evt.ctrlKey === true) ||
        // Allow home, end, left, right
        (charCode >= 35 && charCode <= 39)) {
        return true;
    }

    // Allow only alphanumeric characters
    if ((charCode >= 48 && charCode <= 57) || // numeric (0-9)
        (charCode >= 65 && charCode <= 90) || // upper alpha (A-Z)
        (charCode >= 97 && charCode <= 122)) { // lower alpha (a-z)
        return true;
    }
    
    return false;
}
function filterEsiCodeInput(input) {
    // Replace any non-alphanumeric characters with an empty string
    input.value = input.value.replace(/[^a-zA-Z0-9]/g, '');
}

function isBankNameKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    // Allow backspace, delete, tab, escape, and enter
    if (charCode === 8 || charCode === 46 || charCode === 9 || charCode === 27 || charCode === 13 ||
        // Allow Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
        (charCode === 65 && evt.ctrlKey === true) ||
        (charCode === 67 && evt.ctrlKey === true) ||
        (charCode === 86 && evt.ctrlKey === true) ||
        (charCode === 88 && evt.ctrlKey === true) ||
        // Allow home, end, left, right
        (charCode >= 35 && charCode <= 39)) {
        return true;
    }

    // Allow alphabetic characters and space
    if ((charCode >= 65 && charCode <= 90) || // uppercase (A-Z)
        (charCode >= 97 && charCode <= 122) || // lowercase (a-z)
        charCode === 32) { // space
        return true;
    }

    return false;
}

function filterBankNameInput(input) {
    // Remove any character that is not a letter or space
    input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
}

function selectShift(shiftCode, shiftText) {
    // Set the selected shift text
    document.getElementById('selected-shift').value = shiftText;
    // Set the hidden input value with shift code
    document.getElementById('shift_id').value = shiftCode;
}

    // Pre-select the shift in the dropdown if available
    document.addEventListener('DOMContentLoaded', (event) => {
        const selectedShift = document.getElementById('shift_id').value;
        if (selectedShift) {
            const selectedItem = document.querySelector(`.mdc-list-item[data-value='${selectedShift}']`);
            if (selectedItem) {
                selectedItem.classList.add('mdc-list-item--selected');
            }
        }
    });
    function openSalaryEditModel(row_id, year, basic, hr, others, pf, esi, da, pt, management_pf, management_esi) {

        $('#edit_row_id').val(row_id);
        $('#edit_basic_salary').val(basic);
        $('#edit_year').val(year);
        $('#edit_year').selectpicker('refresh');
        $('#edit_hr').val(hr);
        $('#edit_others').val(others);
        $('#edit_pf').val(pf);
        $('#edit_pt').val(pt);
        $('#edit_da').val(da);
        $('#edit_esi').val(esi);
        $('#edit_management_pf').val(management_pf);
        $('#edit_management_esi').val(management_esi);

        $('#EditSalaryModel').modal('show');


    }

    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('uploadedImage');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    function alphaOnly(event) {
        var key = event.keyCode;
        return ((key >= 65 && key <= 90) || key == 8 || key == 32);
    };
</script>
<script>
    function openSalaryInstallmentModel(installmentInfo) {
        try {
            $('#InstallmentModel').modal('show');
            var tableBody = $('#InstallmentModel table tbody');

            // Remove any rows starting from the third row
            tableBody.find('tr:gt(1)').remove();
            var pendingAmount = 0;
            // Loop through the installmentInfo array and create table rows for each installment
            installmentInfo.forEach(function (item) {
                // var pending_amount = item.total_amount - item.installment_amount ;
                pendingAmount += parseInt(item.installment_amount);
                pending_amount = item.total_amount - pendingAmount;
                $('#total_paid_amount').text(pendingAmount);
                $('#total_advance_amount').text(item.total_amount);
                var row = $('<tr>');
                row.append($('<td>').text(formatDate(item.date)).addClass('text-center'));
                row.append($('<td>').text(item.installment_amount).addClass('text-center'));
                row.append($('<td>').text(pending_amount).addClass('text-center'));
                row.append($('<td>').text(item.year).addClass('text-center'));
                row.append($('<td>').text(item.month).addClass('text-center'));
                tableBody.append(row);
            });
        } catch (e) {
            console.error('Error parsing JSON:', e);
        }
    }

    document.querySelectorAll('.open-installment').forEach(function (element) {
        element.addEventListener('click', function () {
            var installmentInfo = JSON.parse(this.getAttribute('data-installment'));
            openSalaryInstallmentModel(installmentInfo);
        });
    });
    function formatDate(date) {
        var d = new Date(date);
        var day = d.getDate();
        var month = d.getMonth() + 1; // Months are zero-based, so add 1
        var year = d.getFullYear();

        // Add leading zeros if needed
        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }

        return day + '-' + month + '-' + year;
    }
</script>