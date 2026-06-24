<!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->
<style>
    .dash-icons {
        margin-right: 0px!important;
    }
    .admission_card{
        background-color: #05598a !important;
    }
    .academic_card{
        background-color: #217f7f !important;
    }
    .fee_card{
        background-color: #952b70 !important
    }
    .main_card{
        background-color: #fff !important;
        border: 2px solid #065989 !important;
    }
    .main_card h6{
        color: #000 !important;
    }
    .card_icon{
        font-size: 16px !important;
    }
</style>
<?php
    $this->load->helper('form');
    ?>
<div class="main-content-container px-3">
    <!-- Page Header -->
    <div class="row mt-1 mb-1 ">
        <div class="col padding_left_right_null">
            <div class="card card_heading_title card-small p-0">
                <div class="card-body p-2 ml-2">
                    <span class="page-title">
                        <i class="material-icons">description</i> Report
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row ">
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadAdmissionEnquiryReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Admission Enquiry</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
        <?php //if($role != EXAM_COMMITTEE){ ?>
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadFeeStructure" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Fee Paid Consolidated</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadDateWiseFeeReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Student Datewise Paid</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadFeeReportByDate" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Fee Paid By Date</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadBriefFeeReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Fee Brief Report</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadFeePendingReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Fee Pending Report</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadGeneralReceiptsReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">General Receipts</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadMiscellaneousFeePaidReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Miscellaneous Fee Paid</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#IpucMarkSheetSubjectWise" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Exam Mark Sheet - 21</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#assignmentConsolidatedMarkReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Exam Mark Report </h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
         <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#andlyticReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Subjectwise Analytics Report </h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
        <?php //} if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_PRINCIPAL){ ?>
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#applicationApprovedReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Approved Application</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadMerit" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Merit List</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#applicationRejectedReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Rejected Application</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
        <?php //} ?>
        <?php //if($role == ROLE_OFFICE || $role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_PRINCIPAL){ ?>
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadShortlistedMerit" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: green;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Shortlisted Application</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
        <?php //} ?>
        <?php if($role != EXAM_COMMITTEE){ ?>
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#admissionRegisteredStudent" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Admitted Students</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
         <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadStaffReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Staff</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadStaffAttendanceMonthlyReportPdf" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Staff Monthly Attendance - PDF</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#studentReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Student</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
        <div class="col-12 mb-1 column_padding_card">
            <div class="card p-2 main_card">
                <h6 class="font-weight-bold mb-2">Academic Report</h6>
                <div class="row">
                <?php if($role != ROLE_AUDITOR){ ?>
                    <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
                        <a data-toggle="modal" data-target="#andlyticReport" class="more-info text-white" href="#">
                            <div class="card card-small dash-card academic_card">
                                <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white"><i class="fa fa-book card_icon"></i>
                                    Subjectwise Analytics Report</h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-0">
                                    <span class="text-center">Download Report</span>
                                </div>
                            </div>
                        </a>
                    </div> -->
                    <div class="col-lg-3 col-6 mb-2 column_padding_card">
                        <a data-toggle="modal" data-target="#studentReport" class="more-info text-white" href="#">
                            <div class="card card-small dash-card academic_card">
                                <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white"><i class="fa fa-book card_icon"></i>
                                    Student</h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-0">
                                    <span class="text-center">Download Report</span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
                <?php //if($role != ROLE_AUDITOR){ ?>
                    <!-- <div class="col-lg-3 col-6 mb-1 column_padding_card">
                        <a data-toggle="modal" data-target="#downloadSiblingReport" class="more-info text-white" href="#">
                            <div class="card card-small dash-card academic_card">
                                <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white">
                                        <i class="fa fa-book card_icon"></i> Sibling Report
                                    </h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-0">
                                    <span class="text-center">Download</span>
                                </div>
                            </div>
                        </a>
                     </div> -->
                <?php //} ?>
                </div>
            </div> 
        </div> 
        <div class="col-12 mb-1 column_padding_card">
            <div class="card p-2 main_card">
                <h6 class="font-weight-bold mb-2">HR Report</h6>
                <div class="row">
                <?php if(isset($accessInfo) && $accessInfo->super_access == 1) {
                    $examInfo = $accessModel->getRoleAccessForReport($role, 'addInternalMark');
                    $staffInfo = $accessModel->getRoleAccessForReport($role, 'staffDetails');
                    $staffAttendanceInfo = $accessModel->getRoleAccessForReport($role, 'getStaffAttendanceInfo');
                    $studentInfo = $accessModel->getRoleAccessForReport($role, 'studentDetails');
                    $staffSalaryInfo = $accessModel->getRoleAccessForReport($role, 'salarySlipListing');
                    $leaveInfo = $accessModel->getRoleAccessForReport($role, 'staffLeaveInfo');
                    $feeInfo = $accessModel->getRoleAccessForReport($role, 'newFeePayNow');
                    $transportInfo = $accessModel->getRoleAccessForReport($role, 'transFeePayNow');
                    $registrationInfo = $accessModel->getRoleAccessForReport($role, 'getRegisteredStudentInfo');
                    $admissionInfo = $accessModel->getRoleAccessForReport($role, 'getAllApplicationInfo');
                    $scholarshipInfo = $accessModel->getRoleAccessForReport($role, 'scholarshipListing');
                ?>
                <?php if($role != ROLE_AUDITOR){ ?>
                    <?php if(isset($staffInfo) && $staffInfo->report == 1) { ?>
                    <div class="col-lg-3 col-6 mb-2 column_padding_card">
                        <a data-toggle="modal" data-target="#downloadStaffReport" class="more-info text-white" href="#">
                            <div class="card card-small dash-card academic_card">
                                <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white"><i class="fa fa-book card_icon"></i>
                                    Staff</h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-1">
                                    <span class="text-center">Download Report</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                    <?php if(isset($staffAttendanceInfo) && $staffAttendanceInfo->report == 1) { ?>
                    <div class="col-lg-3 col-6 mb-1 column_padding_card">
                        <a data-toggle="modal" data-target="#downloadStaffAttendanceMonthlyReportPdf" class="more-info text-white" href="#">
                            <div class="card card-small dash-card academic_card">
                                <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white">
                                        <i class="fa fa-book card_icon"></i> Staff Monthly Attendance - PDF
                                    </h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-1">
                                    <span class="text-center">Download</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php } } ?>
                    <?php //if($staffID == '123456' || $role == ROLE_ACCOUNT || $role == ROLE_SUPER_ADMIN || $staffID == '12345' || $role == ROLE_AUDITOR || $role == ROLE_PRIMARY_ADMINISTRATOR){ ?>
                    <?php if(isset($staffSalaryInfo) && $staffSalaryInfo->report == 1) { ?>
                    <div class="col-lg-3 col-6 mb-1 column_padding_card">
                        <a data-toggle="modal" data-target="#staffSalaryReportMonthly" class="more-info text-white" href="#">
                            <div class="card card-small dash-card academic_card">
                            <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white">
                                        <i class="fa fa-book card_icon"></i> Staff Salary Month Wise Report
                                    </h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-1">
                                    <span class="text-center">Download</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6 mb-1 column_padding_card">
                        <a data-toggle="modal" data-target="#staffSalaryReportYearly" class="more-info text-white" href="#">
                            <div class="card card-small dash-card academic_card">
                                <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white">
                                        <i class="fa fa-book card_icon"></i> Staff Salary Year Wise Report
                                    </h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-1">
                                    <span class="text-center">Download</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6 mb-1 column_padding_card">
                        <a data-toggle="modal" data-target="#staffSalaryStatementReportMonthly" class="more-info text-white" href="#">
                            <div class="card card-small dash-card academic_card">
                            <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white">
                                        <i class="fa fa-book card_icon"></i> Salary Statement Report - PDF
                                    </h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-1">
                                    <span class="text-center">Download</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6 mb-1 column_padding_card">
                        <a data-toggle="modal" data-target="#staffSalaryStatementReportMonthlyExcel" class="more-info text-white" href="#">
                            <div class="card card-small dash-card academic_card">
                            <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white">
                                        <i class="fa fa-book card_icon"></i> Salary Statement Report - EXCEL
                                    </h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-1">
                                    <span class="text-center">Download</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6 mb-1 column_padding_card">
                        <a data-toggle="modal" data-target="#staffEsiDeductionReportMonthly" class="more-info text-white" href="#">
                            <div class="card card-small dash-card academic_card">
                            <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white">
                                        <i class="fa fa-book card_icon"></i> ESI Deduction Report
                                    </h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-1">
                                    <span class="text-center">Download</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6 mb-1 column_padding_card">
                        <a data-toggle="modal" data-target="#staffSalarynewReportMonthly" class="more-info text-white" href="#">
                            <div class="card card-small dash-card academic_card">
                            <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white">
                                        <i class="fa fa-book card_icon"></i> PF Deduction Report
                                    </h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-1">
                                    <span class="text-center">Download</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                    <?php if(isset($accessInfo) && $accessInfo->super_access == 1) { ?>
                    <?php if(isset($leaveInfo) && $leaveInfo->report == 1) { ?>
                        <?php if($role != ROLE_AUDITOR){ ?>
                    <div class="col-lg-3 col-6 mb-1 column_padding_card">
                        <a data-toggle="modal" data-target="#downloadStaffLeaveReport" class="more-info text-white" href="#">
                            <div class="card card-small dash-card academic_card">
                                <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white">
                                        <i class="fa fa-book card_icon"></i> Leave
                                    </h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-1">
                                    <span class="text-center">Download</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6 mb-1 column_padding_card">
                        <a data-toggle="modal" data-target="#downloadStaffLeavePendingReport" class="more-info text-white" href="#">
                            <div class="card card-small dash-card academic_card">
                                <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white">
                                        <i class="fa fa-book card_icon"></i> Leave Count Report
                                    </h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-1">
                                    <span class="text-center">Download</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php } } } ?>
                </div>
            </div> 
        </div> 
        <?php } ?>
        <?php if(isset($accessInfo) && $accessInfo->super_access==1) { ?>
            <?php if(isset($feeInfo) && $feeInfo->report == 1) { ?>
            <div class="col-12 mb-1 column_padding_card">
                <div class="card p-2 main_card">
                    <h6 class="font-weight-bold mb-2">Fee Report</h6>
                    <div class="row">
                        <div class="col-lg-3 col-6 mb-2 column_padding_card">
                            <a data-toggle="modal" data-target="#mangementFeeReport" class="more-info text-white" href="#">
                                <div class="card card-small dash-card fee_card">
                                    <div class="card-body pt-2 pb-2">
                                        <h6 class="stats-small__value count text-white"><i class="fa fa-book card_icon"></i>
                                        Datewise Fee Report</h6>
                                    </div>
                                    <div class="card-footer text-center dash-footer p-0">
                                        <span class="text-center">Download Report</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-6 mb-2 column_padding_card">
                            <a data-toggle="modal" data-target="#specialFeePaymentReport" class="more-info text-white" href="#">
                                <div class="card card-small dash-card fee_card">
                                    <div class="card-body pt-2 pb-2">
                                        <h6 class="stats-small__value count text-white">
                                            <i class="fa fa-book card_icon"></i> <span class="cardFont" >Special Fee Payment Receipt</span>
                                        </h6>
                                    </div>
                                    <div class="card-footer text-center dash-footer p-0">
                                        <span class="text-center">Click Here</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-6 mb-2 column_padding_card">
                            <a data-toggle="modal" data-target="#bankSettlementReport" class="more-info text-white" href="#">
                                <div class="card card-small dash-card fee_card">
                                    <div class="card-body pt-2 pb-2">
                                        <h6 class="stats-small__value count text-white"><i class="fa fa-book card_icon"></i>
                                        Bank Settlement</h6>
                                    </div>
                                    <div class="card-footer text-center dash-footer p-0">
                                        <span class="text-center">Download Report</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-6 mb-2 column_padding_card">
                            <a data-toggle="modal" data-target="#downloadFeeDueReport" class="more-info text-white" href="#">
                                <div class="card card-small dash-card fee_card">
                                    <div class="card-body pt-2 pb-2">
                                        <h6 class="stats-small__value count text-white"><i class="fa fa-book card_icon"></i>
                                        Fee Due</h6>
                                    </div>
                                    <div class="card-footer text-center dash-footer p-0">
                                        <span class="text-center">Download Report</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-6 mb-2 column_padding_card">
                            <a data-toggle="modal" data-target="#concessionFeeReport" class="more-info text-white" href="#">
                                <div class="card card-small dash-card fee_card">
                                    <div class="card-body pt-2 pb-2">
                                        <h6 class="stats-small__value count text-white"><i class="fa fa-book card_icon"></i>
                                        Scholarship Fee Report</h6>
                                    </div>
                                    <div class="card-footer text-center dash-footer p-0">
                                        <span class="text-center">Download Report</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-6 mb-2 column_padding_card">
                            <a data-toggle="modal" data-target="#downloadMiscellaneousFeePaidReport" class="more-info text-white" href="#">
                                <div class="card card-small dash-card fee_card">
                                    <div class="card-body pt-2 pb-2">
                                        <h6 class="stats-small__value count text-white"><i class="fa fa-book card_icon"></i>
                                        Miscellaneous Fee Paid</h6>
                                    </div>
                                    <div class="card-footer text-center dash-footer p-0">
                                        <span class="text-center">Download Report</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-6 mb-2 column_padding_card">
                            <a data-toggle="modal" data-target="#downloadBifurcationReport" class="more-info text-white" href="#">
                                <div class="card card-small dash-card fee_card">
                                    <div class="card-body pt-2 pb-2">
                                        <h6 class="stats-small__value count text-white"><i class="fa fa-book card_icon"></i>
                                        Bifurcation Report</h6>
                                    </div>
                                    <div class="card-footer text-center dash-footer p-0">
                                        <span class="text-center">Download Report</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
                            <a data-toggle="modal" data-target="#governmentFeeReport" class="more-info text-white" href="#">
                                <div class="card card-small dash-card fee_card">
                                    <div class="card-body pt-2 pb-2">
                                        <h6 class="stats-small__value count text-white"><i class="fa fa-book card_icon"></i>
                                        Government Fee Report</h6>
                                    </div>
                                    <div class="card-footer text-center dash-footer p-0">
                                        <span class="text-center">Download Report</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-6 mb-1 column_padding_card">
                            <a data-toggle="modal" data-target="#downloadFeePaidReport" class="more-info text-white" href="#">
                                <div class="card card-small dash-card fee_card">
                                    <div class="card-body pt-2 pb-2">
                                        <h6 class="stats-small__value count text-white">
                                            <i class="fa fa-book card_icon"></i> Fee Paid Report
                                        </h6>
                                    </div>
                                    <div class="card-footer text-center dash-footer p-0">
                                        <span class="text-center">Download</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-6 mb-2 column_padding_card">
                            <a data-toggle="modal" data-target="#cancelReceiptReport" class="more-info text-white" href="#">
                                <div class="card card-small dash-card fee_card">
                                    <div class="card-body pt-2 pb-2">
                                        <h6 class="stats-small__value count text-white"><i class="fa fa-book card_icon"></i>
                                        Credit Note Report</h6>
                                    </div>
                                    <div class="card-footer text-center dash-footer p-0">
                                        <span class="text-center">Download Report</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-6 mb-2 column_padding_card">
                            <a data-toggle="modal" data-target="#bankDepositReport" class="more-info text-white" href="#">
                                <div class="card card-small dash-card fee_card">
                                    <div class="card-body pt-2 pb-2">
                                        <h6 class="stats-small__value count text-white"><i class="fa fa-book card_icon"></i>
                                        Bank Deposit Report</h6>
                                    </div>
                                    <div class="card-footer text-center dash-footer p-0">
                                        <span class="text-center">Download Report</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>  -->
            </div>
            <?php } ?>
        <?php } ?> 
        <?php if($role != ROLE_AUDITOR){ ?>
        <?php if ($role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_PRINCIPAL || $role == ROLE_SUPER_ADMIN || $role == ROLE_OFFICE) { ?>
        <div class="col-12 mb-1 column_padding_card">
            <!-- <div class="card p-2 main_card">
                <h6 class="font-weight-bold mb-2">Exam Report</h6> -->
                <!-- <div class="row">
                    <div class="col-lg-3 col-6 mb-2 column_padding_card">
                        <a data-toggle="modal" data-target="#markSheetReport" class="more-info text-white" href="#">
                            <div class="card card-small dash-card admission_card">
                                <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white"><i class="fa fa-book card_icon"></i>
                                    Download Marks Sheet</h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-0">
                                    <span class="text-center">Download Report</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6 mb-2 column_padding_card">
                        <a data-toggle="modal" data-target="#downloadIPuReport" class="more-info text-white" href="#">
                            <div class="card card-small dash-card admission_card">
                                <div class="card-body pt-1 pb-1">
                                    <h6 class="stats-small__value count text-white"><i class="fa fa-book card_icon"></i>Annual IPU Report</h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-0">
                                    <span class="text-center">Download Report</span>
                                </div>
                            </div>
                        </a>
                    </div> -->
                    <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
                        <a data-toggle="modal" data-target="#downloadStaffReport" class="more-info text-white" href="#">
                            <div class="card card-small dash-card academic_card">
                                <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white"><i class="fa fa-book card_icon"></i>
                                    Staff</h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-0">
                                    <span class="text-center">Download Report</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6 mb-1 column_padding_card">
                        <a data-toggle="modal" data-target="#downloadStaffAttendanceMonthlyReportPdf" class="more-info text-white" href="#">
                            <div class="card card-small dash-card academic_card">
                                <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white">
                                        <i class="fa fa-book card_icon"></i> Staff Monthly Attendance - PDF
                                    </h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-0">
                                    <span class="text-center">Download</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6 mb-2 column_padding_card">
                        <a data-toggle="modal" data-target="#studentReport" class="more-info text-white" href="#">
                            <div class="card card-small dash-card academic_card">
                                <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white"><i class="fa fa-book card_icon"></i>
                                    Student</h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-0">
                                    <span class="text-center">Download Report</span>
                                </div>
                            </div>
                        </a>
                    </div> -->
                <!-- </div>
            </div>  -->
        </div> 
        <?php } ?>
        <?php } ?>
        <?php if ($role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN || $role == ROLE_OFFICE || $role == ROLE_ACCOUNT) { ?>
            <div class="col-12 mb-1 column_padding_card">
                <!-- <div class="card p-2 main_card" >
                    <h6 class="font-weight-bold mb-2">Scholarship Report</h6>
                    <div class="row">
                        <div class="col-lg-3 col-6 mb-2 column_padding_card" >
                            <a data-toggle="modal" data-target="#downloadScholarshipReport" class="more-info text-white" href="#">
                            <div class="card card-small dash-card academic_card">
                                    <div class="card-body pt-2 pb-2">
                                        <h6 class="stats-small__value count text-white" style="font-size: 18px;">
                                        <i class="fa fa-book card_icon text-white"></i> <span class="text-white">Scholarship Report</span>
                                    </h6>
                                    </div>
                                    <div class="card-footer text-center dash-footer p-0">
                                        <span class="text-center">Download Report</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div> 
                </div> -->
            </div>
        <?php } ?>
        <?php if ($role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_PRINCIPAL || $role == ROLE_SUPER_ADMIN || $role == ROLE_OFFICE) { ?>
        <div class="col-12 mb-1 column_padding_card">
            <!-- <div class="card p-2 main_card">
                <h6 class="font-weight-bold mb-2">Transport Fee Report</h6>
                <div class="row">
                    <div class="col-lg-3 col-6 mb-2 column_padding_card">
                        <a data-toggle="modal" data-target="#datewiseTransportFeeReport" class="more-info text-white" href="#">
                            <div class="card card-small dash-card admission_card">
                                <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white"><i class="fa fa-book card_icon"></i>
                                    Datewise Fee Report</h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-0">
                                    <span class="text-center">Download Report</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6 mb-2 column_padding_card">
                        <a data-toggle="modal" data-target="#transportFeePaidReport" class="more-info text-white" href="#">
                            <div class="card card-small dash-card admission_card">
                                <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white"><i class="fa fa-book card_icon"></i>
                                    Transport Fee Paid Report</h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-0">
                                    <span class="text-center">Download Report</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6 mb-2 column_padding_card">
                        <a data-toggle="modal" data-target="#transportFeeDueReport" class="more-info text-white" href="#">
                            <div class="card card-small dash-card admission_card">
                                <div class="card-body pt-1 pb-1">
                                    <h6 class="stats-small__value count text-white"><i class="fa fa-book card_icon"></i>Overall Transport Fee Paid Report</h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-0">
                                    <span class="text-center">Download Report</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6 mb-2 column_padding_card">
                        <a data-toggle="modal" data-target="#transportOnlyFeeDue" class="more-info text-white" href="#">
                            <div class="card card-small dash-card admission_card">
                                <div class="card-body pt-1 pb-1">
                                    <h6 class="stats-small__value count text-white"><i class="fa fa-book card_icon"></i>Transport Fee Due Report</h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-0">
                                    <span class="text-center">Download Report</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>  -->
        </div> 
        <?php } ?>
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#governmentFeeReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Government Fee Report</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadFeePaidReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Fee Paid Report</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#concessionFeeReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Concession Fee Report</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#cancelReceiptReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Cancel Receipt</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadMiscellaneousFeePaidReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">Miscellaneous Fee Paid</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
         <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadMunExternalReport" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">MUN External</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
         <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a class="more-info text-white dashboard_link" href="<?php //echo base_url() ?>downloadMunInternalReport">
            <div class="card card-small dash-card" style="background: #3e50b3;">
                <div class="card-body pt-1 pb-1">
                    <h6 class="stats-small__value text-uppercase text-white">MUN INTERNAL</h6>
                    <div class="icon pull-right mt-4">
                        <i class="fas fa-file dash-icons"></i></i>
                    </div>
                </div>
                <div class="card-footer text-center dash-footer p-1">
                    <div class="more-info text-white"></div>
                    <span class="text-center">Download</span>
                </div>
            </div>
        </a>
        </div> -->
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a data-toggle="modal" data-target="#downloadFeeStructure2020" class="more-info text-white dashboard_link" href="#">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">2020 Fee Paid</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
            </a>
        </div> -->
        <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
            <a class="more-info text-white dashboard_link" href="<?php //echo base_url() ?>downloadCourseRegistrationReport">
                <div class="card card-small dash-card" style="background: #3e50b3;">
                    <div class="card-body pt-1 pb-1">
                        <h6 class="stats-small__value text-uppercase text-white">COURSE REGISTRATION</h6>
                        <div class="icon pull-right mt-4">
                            <i class="fas fa-file dash-icons"></i></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <div class="more-info text-white"></div>
                        <span class="text-center">Download</span>
                    </div>
                </div>
        </a>
        </div> -->
        <?php } ?>
        <?php if($role == EXAM_COMMITTEE){ ?>
        <?php } ?>
  </div>
</div>
<!-- Admission Enquiry export modal -->
<div class="modal fade" id="downloadAdmissionEnquiryReport">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Admission Enquiry</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadAdmissionEnquiryForm" action="<?php echo base_url() ?>downloadAdmissionEnquiryExcelReport" method="POST">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mt-1">
                                <select class="form-control input-sm" id="term_name" name="term_name" required>
                                <option value="">Select Term</option>
                                <option value="PU1">PU1</option>
                                <option value="PU2">PU2</option>
                                </select>
                            </div>
                        </div>
                    </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button id="downloadReportExcel" type="submit" class="btn btn-md btn-primary float-right"><i
                        class="fa fa-download"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- fee structure -->
<div class="modal" id="downloadFeeStructure">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header p-2">
                <h6 class="modal-title">Download Fee Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadFeeStructureForm" method="POST" action="<?php echo base_url().'download_fee_structure_excel'?>">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Select Term</label>
                                <select class="form-control" name="term_name_select" id="term_name_select" required>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Select Year</label>
                                <select class="form-control" name="year" id="year" required>
                                    <option value="<?php echo CURRENT_YEAR ?>"><?php echo CURRENT_YEAR ?></option>
                                    <option value="<?php echo CURRENT_YEAR-1 ?>"><?php echo CURRENT_YEAR-1 ?></option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-download"
                                        aria-hidden="true"></i> Download</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<!-- fee structure -->
<div class="modal" id="downloadFeeStructure2020">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header p-2">
                <h6 class="modal-title">Download Fee Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadFeeStructureForm" method="POST" action="<?php echo base_url().'download_fee_structure_excel_2020'?>">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Select Term</label>
                                <select class="form-control" name="term_name_select" id="term_name_select" required>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-download"
                                        aria-hidden="true"></i> Download</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- fee structure -->
<div class="modal" id="downloadDayWiseFeeReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header p-2">
                <h6 class="modal-title">Download Fee Paid Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadDayWiseFeeReport" method="POST" action="<?php echo base_url().'downloadDayWiseFeeReport'?>">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Select Fee Type</label>
                                <select class="form-control" name="fee_type_select" id="fee_type_select">
                                    <option value="">ALL</option>
                                    <option value="GOVT">GOVT</option>
                                    <option value="NON-GOVT">NON-GOVT</option>
                                    <option value="MANAGEMENT">MANAGEMENT</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Select Term</label>
                                <select class="form-control" name="term_select" id="term_select">
                                    <option value="">ALL</option>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Select Stream</label>
                                <select class="form-control" name="stream_select" id="stream_select">
                                    <option value="">ALL</option>
                                    <?php if(!empty($streamInfo)){
                                    foreach($streamInfo as $stream){ ?>
                                    <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date From</label>
                                <input type="text" class="form-control" id="date_from_fee" name="date_from"
                                    placeholder="Select Date From" autocomplete="off"  >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date To</label>
                                <input type="text" class="form-control" id="date_to_fee" name="date_to"
                                    placeholder="Select Date To" autocomplete="off" >
                            </div>
                        </div>


                        </div>
                        <div class="row">
                        <!-- <div class="col-lg-12">
                            <label>By Stream</label>
                            <select class="form-control input-md required" id="" name="preference">
                                <option value="">ALL</option>
                                <option value="">Select One Preference</option>
                                <option value="PCMB">PCMB</option>
                                <option value="PCMC">PCMC</option>
                                <option value="PCME">PCME</option>
                                <option value="PCMS" >PCMS</option>
                                <option value="CEBA">CEBA</option>
                                <option value="CSBA">CSBA</option>
                                <option value="MEBA">MEBA</option>
                                <option value="MSBA">MSBA</option>
                                <option value="PEBA">PEBA</option>
                                <option value="SEBA">SEBA</option>
                                <option value="HEPS">HEPS</option>
                            </select>
                        </div> -->
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-4">
                                <select class="form-control text-dark" id="reportFormat" name="reportFormat" required>
                                    <option value="VIEW">VIEW</option>
                                    <option value="DOWNLOAD">DOWNLOAD</option>
                                </select>
                            </div>
                            <div class="col-8">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-download"
                                        aria-hidden="true"></i> Download</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- fee structure -->
<div class="modal" id="downloadGeneralReceiptsReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header p-2">
                <h6 class="modal-title">Download General Receipts Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadGeneralReceiptsReport" method="POST" action="<?php echo base_url().'downloadGeneralReceiptsReport'?>">

                    
                    <div class="row">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date From</label>
                                <input type="text" class="form-control dateSearch" name="date_from"
                                    placeholder="Select Date From" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date To</label>
                                <input type="text" class="form-control dateSearch" name="date_to"
                                    placeholder="Select Date To" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-4">
                                <select class="form-control text-dark" id="reportFormat" name="reportFormat" required>
                                    <option value="VIEW">VIEW</option>
                                    <option value="DOWNLOAD">DOWNLOAD</option>
                                </select>
                            </div>
                            <div class="col-8">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-download"
                                        aria-hidden="true"></i> Download</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- fee structure -->
<div class="modal" id="downloadDateWiseFeeReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header p-2">
                <h6 class="modal-title">Download Student Datewise Fee Paid Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadDateWiseFeeReport" method="POST" action="<?php echo base_url().'downloadDateWiseFeeReport'?>">
                    <!-- <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Select Term</label>
                                <select class="form-control" name="term_select" id="term_select">
                                    <option value="">ALL</option>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Select Stream</label>
                                <select class="form-control" name="stream_select" id="stream_select">
                                    <option value="">ALL</option>
                                    <?php if(!empty($streamInfo)){
                                    foreach($streamInfo as $stream){ ?>
                                    <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                    </div> -->
                    <div class="row mt-2">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date From</label>
                                <input type="text" class="form-control dateSearch" name="date_from"
                                    placeholder="Select Date From" autocomplete="off"  >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date To</label>
                                <input type="text" class="form-control dateSearch" name="date_to"
                                    placeholder="Select Date To" autocomplete="off" >
                            </div>
                        </div>


                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-4">
                                <select class="form-control text-dark" id="reportFormat" name="reportFormat" required>
                                    <option value="VIEW">VIEW</option>
                                    <option value="DOWNLOAD">DOWNLOAD</option>
                                </select>
                            </div>
                            <div class="col-8">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-download"
                                        aria-hidden="true"></i> Download</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="downloadFeeReportByDate">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header p-2">
                <h6 class="modal-title">Download Fee Paid Report By Date</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadFeeReportByDate" method="POST" action="<?php echo base_url().'downloadByDateReport'?>">
                    <div class="row mt-2">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date From</label>
                                <input type="text" class="form-control dateSearch" name="date_from"
                                    placeholder="Select Date From" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date To</label>
                                <input type="text" class="form-control dateSearch" name="date_to"
                                    placeholder="Select Date To" autocomplete="off" required>
                            </div>
                        </div>


                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-4">
                                <select class="form-control text-dark" id="reportFormat" name="reportFormat" required>
                                    <option value="VIEW">VIEW</option>
                                    <option value="DOWNLOAD">DOWNLOAD</option>
                                </select>
                            </div>
                            <div class="col-8">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-download"
                                        aria-hidden="true"></i> Download</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="downloadFeePendingReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header p-2">
                <h6 class="modal-title">Download Fee Pending/Paid Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadFeePendingReport" method="POST" action="<?php echo base_url().'downloadFeePendingReport'?>">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Select Year</label>
                                <select class="form-control" name="year" id="">
                                    <option value="<?php echo CURRENT_YEAR; ?>"><?php echo CURRENT_YEAR; ?></option>
                                    <!-- <option value="II PUC">II PUC</option> -->
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Select Type</label>
                                <select class="form-control" name="type">
                                    <option value="PENDING">PENDING</option>
                                    <option value="PAID">PAID</option>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="col-lg-6">
                            <div class="form-group">
                                <label>Select Stream</label>
                                <select class="form-control" name="stream_select" id="stream_select">
                                    <option value="">ALL</option>
                                    <?php if(!empty($streamInfo)){
                                    foreach($streamInfo as $stream){ ?>
                                    <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div> -->
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-4">
                                <select class="form-control text-dark" id="reportFormat" name="reportFormat" required>
                                    <option value="VIEW">VIEW</option>
                                    <option value="DOWNLOAD">DOWNLOAD</option>
                                </select>
                            </div>
                            <div class="col-8">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-download"
                                        aria-hidden="true"></i> Download</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- fee structure -->
<div class="modal" id="downloadBriefFeeReport">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header p-2">
                <h6 class="modal-title">Download Fee Brief Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadBriefFeeReport" method="POST" action="<?php echo base_url().'downloadBriefFeeReport'?>">
                    <!-- <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Select Fee Type</label>
                                <select class="form-control" name="fee_type_select" id="fee_type_select">
                                    <option value="">ALL</option>
                                    <option value="GOVT">GOVT</option>
                                    <option value="NON-GOVT">NON-GOVT</option>
                                    <option value="MANAGEMENT">MANAGEMENT</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Select Term</label>
                                <select class="form-control" name="term_select" id="term_select">
                                    <option value="">ALL</option>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Select Stream</label>
                                <select class="form-control" name="stream_select" id="stream_select">
                                    <option value="">ALL</option>
                                    <?php //if(!empty($streamInfo)){
                                    //foreach($streamInfo as $stream){ ?>
                                    <option value="<?php //echo $stream->stream_name; ?>"><?php //echo $stream->stream_name; ?></option>
                                    <?php //} } ?>
                                </select>
                            </div>
                        </div>
                    </div> -->
                    <div class="row mt-2">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date From</label>
                                <input type="text" class="form-control" id="brf_date_from_fee" name="date_from"
                                    placeholder="Select Date From" autocomplete="off"  >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date To</label>
                                <input type="text" class="form-control" id="brf_date_to_fee" name="date_to"
                                    placeholder="Select Date To" autocomplete="off" >
                            </div>
                        </div>
                        </div>
                        <div class="row">
                        <!-- <div class="col-lg-12">
                            <label>By Stream</label>
                            <select class="form-control input-md required" id="" name="preference">
                                <option value="">ALL</option>
                                <option value="">Select One Preference</option>
                                <option value="PCMB">PCMB</option>
                                <option value="PCMC">PCMC</option>
                                <option value="PCME">PCME</option>
                                <option value="PCMS" >PCMS</option>
                                <option value="CEBA">CEBA</option>
                                <option value="CSBA">CSBA</option>
                                <option value="MEBA">MEBA</option>
                                <option value="MSBA">MSBA</option>
                                <option value="PEBA">PEBA</option>
                                <option value="SEBA">SEBA</option>
                                <option value="HEPS">HEPS</option>
                            </select>
                        </div> -->
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-4">
                                <select class="form-control text-dark" id="reportFormat" name="reportFormat" required>
                                    <option value="VIEW">VIEW</option>
                                    <option value="DOWNLOAD">DOWNLOAD</option>
                                </select>
                            </div>
                            <div class="col-8">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-download"
                                        aria-hidden="true"></i> Download</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="downloadMiscellaneousFeePaidReport">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Miscellaneous Fee Paid</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body p-2">
                <form action="<?php echo base_url() ?>downloadMiscellaneousFeePaidReport"  data-download_form="true" method="POST">
                    <div class="row">
                        <div class="col-6 mb-2">
                            <label for="role">Date From</label>
                            <input type="text" name="date_from" id="date_from" class="form-control datepicker" style="text-transform: uppercase" placeholder="Date From" autocomplete="off" />
                        </div>
                        <div class="col-6 mb-2">
                            <label for="role">Date To</label>
                            <input type="text" name="date_to" id="date_to" class="form-control datepicker" style="text-transform: uppercase" placeholder="Date To" autocomplete="off" />
                        </div>
                        <div class="col-6 mb-2">
                            <label>Miscellaneous type</label>
                            <select class="form-control text-dark selectpicker" id="miscellaneous_type" name="miscellaneous_type[]" multiple>
                                <option value="ALL">All</option>
                                <?php if (!empty($miscellaneousTypeInfo)) {
                                    foreach ($miscellaneousTypeInfo as $type) { ?>
                                        <option value="<?php echo $type->row_id ?>"><?php echo $type->miscellaneous_type ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                        <div class="col-6 mb-2">
                            <label>Payment type</label>
                            <select class="form-control selectpicker text-dark" id="payment_type" name="payment_type[]" multiple>
                                <option value="ALL">All</option>
                                <option value="CASH">CASH</option>
                                <option value="UPI">UPI</option>
                                <option value="NEFT">NEFT</option>
                            </select>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <label>Fee Year</label>
                            <select class="form-control input-md required" name="misc_year" id="misc_year">
                            <?php if (!empty($studentYearInfo)) {
                                foreach ($studentYearInfo as $record) { ?>
                                    <option value="<?php echo $record->year; ?>"><?php echo $record->display_year; ?></option>
                            <?php }} ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success" id="reportFormat" name="reportFormat" value="VIEW" onclick="selectOption('VIEW')" formtarget="_blank"/>
                    <button type="submit" value="Download" name="buttonName" class="btn btn-md btn-primary float-right"><i class="fa fa-download"></i> Download</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- The Modal for bank settlement-->
<div class="modal" id="applicationStackReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Application Report Filter</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" id="addBankSettlementSubmit" action="<?php echo base_url(); ?>downloadApplicationStack">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Percentage FROM</label>
                            <input maxlength="5" onkeypress="return isNumberKey(event)" type="text" class="form-control"
                                id="inputEmail4" name="percentage_from" placeholder="SSLC Percentage From">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Percentage TO</label>
                            <input maxlength="5" onkeypress="return isNumberKey(event)" name="percentage_to" type="text"
                                class="form-control" id="inputPassword4" placeholder="SSLC Percentage To">
                        </div>
                    </div>
                    <input type="hidden" value="APPLICATION_STACK" name="report_type" />
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By SSLC Board</label>
                            <select class="form-control input-md required" id="" name="by_board">
                                <option value="">ALL</option>
                                <option value="CBSE">CBSE</option>
                                <option value="ICSE">ICSE</option>
                                <option value="KARNATAKA STATE BOARD">KARNATAKA STATE BOARD</option>
                            </select>
                        </div>
                    </div>
                   

                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Elective Language</label>
                            <select class="form-control input-md required" id="" name="elective_sub">
                                <option value="">ALL</option>
                                <option value="KANNADA">KANNADA</option>
                                <option value="HINDI">HINDI</option>
                                <option value="FRENCH">FRENCH</option>
                            </select>
                        </div>
                    </div>
 
 
 
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="addBankSettlementSubmit"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="downloadSiblingReport">
        <div class="modal-dialog ">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header exportModel">
                    <h4 class="modal-title">Download Sibling Info</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body p-2">
                    <form data-download_form="true" action="<?php echo base_url() ?>downloadStudentSiblingExcelReport" method="POST">
                        <div class="row">
                            <div class="col-lg-6 col-6">
                              <label>Select Term</label>
                                <select class="form-control input-sm selectpicker" id="term" name="term" required>
                                    <option value="">Select Term</option>
                                    <option value="">ALL</option>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-6">
                                <div class="form-group">
                                    <label>Select Section</label>
                                    <select name="section_namee" class="form-control input-sm selectpicker" placeholder="Search Section">
                                        <option value="">By Section</option>
                                        <option value="">ALL</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="form-group stream_name_filter">
                                    <label>Select Stream</label>
                                    <select class="form-control input-sm selectpicker"  name="stream_name">
                                        <option value="">Select Stream</option>
                                        <option value="">ALL</option>
                                        <?php if (!empty($streamInfo)) {
                                            foreach ($streamInfo as $stream) { ?>
                                                <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button id="downloadReportExcel2" type="submit" class="btn btn-md btn-primary float-right"><i class="fa fa-download"></i> Download</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<!-- The leave view Modal -->
<div class="modal" id="staffSalaryReportMonthly">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header ">
                <h4 class="modal-title">Staff Salary Info Month Wise</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding:0px;">
                <div class="card-body contents-body">
                    <form id="downloadStaffSalaryReportMonthlyForm" method="POST" action="">
                        <div class="row">
                            
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Select Year</label>
                                    <select class="form-control"  id="Montly_year" name="year" required>
                                    <!-- <option value="">Select Year</option> -->
                                    <!-- <option value="2023">2023</option> -->
                                    <?php if (!empty($salaryYearInfo)) {
                                                        foreach ($salaryYearInfo as $record) { ?>
                                                            <option value="<?php echo $record->year; ?>"><?php echo $record->year; ?></option>
                                                        <?php }
                                                    } ?>
                                </select> 
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Select Month</label>
                                    <select class="form-control"  id="salary_monthly" name="salary_monthly" required>
                                    <option value="">Select Month</option>
                                    <option value='January'>January</option>
                                    <option value='February'>February</option>
                                    <option value='March'>March</option>
                                    <option value='April'>April</option>
                                    <option value='May'>May</option>
                                    <option value='June'>June</option>
                                    <option value='July'>July</option>
                                    <option value='August'>August</option>
                                    <option value='September'>September</option>
                                    <option value='October'>October</option>
                                    <option value='November'>November</option>
                                    <option value='December'>December</option>
                                </select> 
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Role </label>
                                    <select class="form-control input-sm selectpicker" id="staff_role_salary" name="staff_role_salary" required>
                                     <option value="">Select Role</option>
                                     <option value="ALL">ALL</option>
                                            <?php   if(!empty($designation))
                                        {
                                            foreach ($designation as $rl)
                                            {
                                                ?>
                                                <option value="<?php echo $rl->roleId ?>"><?php echo $rl->role ?></option>
                                                <?php
                                            }
                                        } ?>
                                </select>
                                </div>
                            </div>
                            
                        </div>

                      
                        <hr class="mt-1 mb-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <button type="submit" class="btn pull-right btn-primary text-white"
                                    id="downloadStaffSalaryMonthlyReportButton" name="add">Download</button>
                                <button type="button" class="btn btn-danger pull-left"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>

                    <!-- Modal footer -->

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="staffSalaryReportYearly">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Staff Salary Info Year Wise</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="downloadStaffSalaryReportYearlyForm" action="<?php echo base_url(); ?>getStaffSalaryYearlyPrint" method="POST" target="_blank">

                    <div class="form-group">
                        <label>Select Financial Year</label>
                        <select class="form-control" id="salary_yearly" name="salary_year" required>
                            <?php foreach ($salaryYearInfo as $yr) { ?>
                                <option value="<?php echo $yr->year; ?>">
                                    <?php echo $yr->year; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select class="form-control" id="staff_role_yearly" name="salary_role" required>
                            <option value="ALL">ALL</option>
                            <?php foreach ($designation as $rl) { ?>
                                <option value="<?php echo $rl->roleId; ?>">
                                    <?php echo $rl->role; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <hr>

                    <button type="submit" class="btn btn-primary pull-right">
                        Download PDF
                    </button>
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                        Close
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="staffSalaryStatementReportMonthly">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header ">
                <h4 class="modal-title">Salary Statement Month Wise</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding:0px;">
                <div class="card-body contents-body">
                    <form id="downloadStaffSalaryStatementReportMonthlyForm" data-download_form="true" method="POST" action="<?php echo base_url(); ?>downloadStaffSalaryStatementMonthly" target="_blank">
                        <div class="row">
                            
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="statement_year">Select Year</label>
                                    <select class="form-control"  id="statement_year" name="year" required>
                                    <!-- <option value="">Select Year</option> -->
                                    <!-- <option value="2023">2023</option> -->
                                    <?php if (!empty($salaryYearInfo)) {
                                                        foreach ($salaryYearInfo as $record) { ?>
                                                            <option value="<?php echo $record->year; ?>"><?php echo $record->year; ?></option>
                                                        <?php }
                                                    } ?>
                                </select> 
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="statement_month">Select Month</label>
                                    <select class="form-control"  id="statement_month" name="salary_monthly" required>
                                    <option value="">Select Month</option>
                                    <option value='January'>January</option>
                                    <option value='February'>February</option>
                                    <option value='March'>March</option>
                                    <option value='April'>April</option>
                                    <option value='May'>May</option>
                                    <option value='June'>June</option>
                                    <option value='July'>July</option>
                                    <option value='August'>August</option>
                                    <option value='September'>September</option>
                                    <option value='October'>October</option>
                                    <option value='November'>November</option>
                                    <option value='December'>December</option>
                                </select> 
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="statement_role">Role </label>
                                    <select class="form-control input-sm selectpicker" id="statement_role" name="staff_role_salary[]" multiple data-live-search="true" required>
                                     <option value="">Select Role</option>
                                     <option value="ALL">ALL</option>
                                            <?php   if(!empty($designation))
                                        {
                                            foreach ($designation as $rl)
                                            {
                                                ?>
                                                <option value="<?php echo $rl->roleId ?>"><?php echo $rl->role ?></option>
                                                <?php
                                            }
                                        } ?>
                                </select>
                                </div>
                            </div>
                            
                        </div>

                      
                        <hr class="mt-1 mb-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <button type="submit" class="btn pull-right btn-primary text-white"
                                    id="downloadStaffSalaryStatementButton" name="add">Download PDF</button>
                                <button type="button" class="btn btn-danger pull-left"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>

                    <!-- Modal footer -->

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="staffSalaryStatementReportMonthlyExcel">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header ">
                <h4 class="modal-title">Salary Statement Month Wise - Excel</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding:0px;">
                <div class="card-body contents-body">
                    <form id="downloadStaffSalaryStatementReportExcelForm" method="POST" action="">
                        <div class="row">
                            
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="statement_year_excel">Select Year</label>
                                    <select class="form-control"  id="statement_year_excel" name="year" required>
                                    <!-- <option value="">Select Year</option> -->
                                    <!-- <option value="2023">2023</option> -->
                                    <?php if (!empty($salaryYearInfo)) {
                                                        foreach ($salaryYearInfo as $record) { ?>
                                                            <option value="<?php echo $record->year; ?>"><?php echo $record->year; ?></option>
                                                        <?php }
                                                    } ?>
                                </select> 
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="statement_month_excel">Select Month</label>
                                    <select class="form-control"  id="statement_month_excel" name="salary_monthly" required>
                                    <option value="">Select Month</option>
                                    <option value='January'>January</option>
                                    <option value='February'>February</option>
                                    <option value='March'>March</option>
                                    <option value='April'>April</option>
                                    <option value='May'>May</option>
                                    <option value='June'>June</option>
                                    <option value='July'>July</option>
                                    <option value='August'>August</option>
                                    <option value='September'>September</option>
                                    <option value='October'>October</option>
                                    <option value='November'>November</option>
                                    <option value='December'>December</option>
                                </select> 
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="statement_role_excel">Role </label>
                                    <select class="form-control input-sm selectpicker" id="statement_role_excel" name="staff_role_salary[]" multiple data-live-search="true" required>
                                     <option value="">Select Role</option>
                                     <option value="ALL">ALL</option>
                                            <?php   if(!empty($designation))
                                        {
                                            foreach ($designation as $rl)
                                            {
                                                ?>
                                                <option value="<?php echo $rl->roleId ?>"><?php echo $rl->role ?></option>
                                                <?php
                                            }
                                        } ?>
                                </select>
                                </div>
                            </div>
                            
                        </div>

                      
                        <hr class="mt-1 mb-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <button type="submit" class="btn pull-right btn-primary text-white"
                                    id="downloadStaffSalaryStatementExcelButton" name="add">Download Excel</button>
                                <button type="button" class="btn btn-danger pull-left"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>

                    <!-- Modal footer -->

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="staffEsiDeductionReportMonthly">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header ">
                <h4 class="modal-title">ESI Deduction Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding:0px;">
                <div class="card-body contents-body">
                    <form id="staffEsiDeductionReportMonthlyForm" method="POST" action="">
                        <div class="row">
                            
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Select Year</label>
                                    <select class="form-control"  id="esi_year" name="year" required>
                                    <!-- <option value="">Select Year</option> -->
                                    <!-- <option value="2023">2023</option> -->
                                    <?php if (!empty($salaryYearInfo)) {
                                                        foreach ($salaryYearInfo as $record) { ?>
                                                            <option value="<?php echo $record->year; ?>"><?php echo $record->year; ?></option>
                                                        <?php }
                                                    } ?>
                                </select> 
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Select Month</label>
                                    <select class="form-control"  id="esi_monthly" name="esi_monthly" required>
                                    <option value="">Select Month</option>
                                    <option value='January'>January</option>
                                    <option value='February'>February</option>
                                    <option value='March'>March</option>
                                    <option value='April'>April</option>
                                    <option value='May'>May</option>
                                    <option value='June'>June</option>
                                    <option value='July'>July</option>
                                    <option value='August'>August</option>
                                    <option value='September'>September</option>
                                    <option value='October'>October</option>
                                    <option value='November'>November</option>
                                    <option value='December'>December</option>
                                </select> 
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Role </label>
                                    <select class="form-control input-sm selectpicker" id="esi_role" name="esi_role[]" multiple data-live-search="true" required>
                                     <option value="">Select Role</option>
                                     <option value="ALL">ALL</option>
                                            <?php   if(!empty($designation))
                                        {
                                            foreach ($designation as $rl)
                                            {
                                                ?>
                                                <option value="<?php echo $rl->roleId ?>"><?php echo $rl->role ?></option>
                                                <?php
                                            }
                                        } ?>
                                </select>
                                </div>
                            </div>
                            
                        </div>

                      
                        <hr class="mt-1 mb-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <button type="submit" class="btn pull-right btn-primary text-white"
                                    id="downloadStaffEsiReportButton" name="add">Download</button>
                                <button type="button" class="btn btn-danger pull-left"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>

                    <!-- Modal footer -->

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="staffSalarynewReportMonthly">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header ">
                <h4 class="modal-title">PF Deduction Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding:0px;">
                <div class="card-body contents-body">
                    <form id="staffSalarynewReportMonthlyForm" method="POST" action="">
                        <div class="row">
                            
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Select Year</label>
                                    <select class="form-control"  id="salary_report_year" name="year" required>
                                    <!-- <option value="">Select Year</option> -->
                                    <!-- <option value="2023">2023</option> -->
                                    <?php if (!empty($salaryYearInfo)) {
                                                        foreach ($salaryYearInfo as $record) { ?>
                                                            <option value="<?php echo $record->year; ?>"><?php echo $record->year; ?></option>
                                                        <?php }
                                                    } ?>
                                </select> 
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Select Month</label>
                                    <select class="form-control"  id="salary_report_month" name="esi_monthly" required>
                                    <option value="">Select Month</option>
                                    <option value='January'>January</option>
                                    <option value='February'>February</option>
                                    <option value='March'>March</option>
                                    <option value='April'>April</option>
                                    <option value='May'>May</option>
                                    <option value='June'>June</option>
                                    <option value='July'>July</option>
                                    <option value='August'>August</option>
                                    <option value='September'>September</option>
                                    <option value='October'>October</option>
                                    <option value='November'>November</option>
                                    <option value='December'>December</option>
                                </select> 
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Role </label>
                                    <select class="form-control input-sm selectpicker" id="salary_report_role" name="esi_role" required>
                                     <option value="">Select Role</option>
                                     <option value="ALL">ALL</option>
                                            <?php   if(!empty($designation))
                                        {
                                            foreach ($designation as $rl)
                                            {
                                                ?>
                                                <option value="<?php echo $rl->roleId ?>"><?php echo $rl->role ?></option>
                                                <?php
                                            }
                                        } ?>
                                </select>
                                </div>
                            </div>
                            
                        </div>

                      
                        <hr class="mt-1 mb-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <button type="submit" class="btn pull-right btn-primary text-white"
                                    id="downloadSalaryReportButton" name="add">Download</button>
                                <button type="button" class="btn btn-danger pull-left"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>

                    <!-- Modal footer -->

                </div>
            </div>
        </div>
    </div>
</div>
<!-- The Modal for  applicationApprovedReport-->
<div class="modal" id="applicationApprovedReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Application Approved Report Filter</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" id="applicationApprovedReport" action="<?php echo base_url(); ?>downloadApplicationStack">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Percentage FROM</label>
                            <input maxlength="5" onkeypress="return isNumberKey(event)" type="text" class="form-control"
                                id="inputEmail4" name="percentage_from" placeholder="SSLC Percentage From">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Percentage TO</label>
                            <input maxlength="5" onkeypress="return isNumberKey(event)" name="percentage_to" type="text"
                                class="form-control" id="inputPassword4" placeholder="SSLC Percentage To">
                        </div>
                        <div class="form-group col-md-6">
                                     <label>By Admission Year</label>

                                        <select class="form-control input-md" name="admission_year" id="admission_year">
                                         <option value="<?php echo CURRENT_YEAR?>"><?php echo CURRENT_YEAR?></option>
                                        <option value="2021">2021</option>
                                            
                                        </select>
                                       
                            </div>
                            <div class="form-group col-md-6">
                                     <label>By Integrated Batch</label>

                                        <select class="form-control input-md" name="integrated_batch" id="integrated_batch">
                                        <option value="">ALL</option>
                                        <option value="JEE">JEE</option>
                                        <option value="NEET">NEET</option>
                                        <option value="CPT">CPT</option>
                                        <option value="CLAT">CLAT</option>
                                        <option value="NONE">NONE</option>
                                            
                                        </select>
                                       
                            </div>
                    </div>
                    <input type="hidden" value="APPLICATION_APPROVED" name="report_type" />
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By SSLC Board</label>
                            <select class="form-control input-md required" id="" name="by_board">
                                <option value="">ALL</option>
                               
                                <option value="CBSE">CBSE</option>
                                <option value="ICSE">ICSE</option>
                                <option value="KARNATAKA STATE BOARD">KARNATAKA STATE BOARD</option>
                                <option value="OTHER">OTHER</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Stream</label>
                            <select class="form-control input-md required" id="" name="preference">
                                <option value="">ALL</option>
                                <option value="">Select One Preference</option>
                                <option value="PCMB">PCMB</option>
                                <option value="PCMC">PCMC</option>
                                <option value="PCME">PCME</option>
                                <option value="PCMS" >PCMS</option>
                                <option value="CEBA">CEBA</option>
                                <option value="CSBA">CSBA</option>
                                <option value="MEBA">MEBA</option>
                                <option value="MSBA">MSBA</option>
                                <option value="PEBA">PEBA</option>
                                <option value="SEBA">SEBA</option>
                                <option value="HEPS">HEPS</option>
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="applicationApprovedReport"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal" id="applicationRejectedReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Application Rejected Report Filter</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" id="applicationRejectedReport" action="<?php echo base_url(); ?>downloadApplicationStack">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Percentage FROM</label>
                            <input maxlength="5" onkeypress="return isNumberKey(event)" type="text" class="form-control"
                                id="inputEmail4" name="percentage_from" placeholder="SSLC Percentage From">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Percentage TO</label>
                            <input maxlength="5" onkeypress="return isNumberKey(event)" name="percentage_to" type="text"
                                class="form-control" id="inputPassword4" placeholder="SSLC Percentage To">
                        </div>
                        <div class="form-group col-md-6">
                                     <label>By Admission Year</label>

                                        <select class="form-control input-md" name="admission_year" id="admission_year">
                                         <option value="<?php echo CURRENT_YEAR?>"><?php echo CURRENT_YEAR?></option>
                                        <option value="2021">2021</option>
                                            
                                        </select>
                                       
                            </div>
                            <div class="form-group col-md-6">
                                     <label>By Integrated Batch</label>

                                        <select class="form-control input-md" name="integrated_batch" id="integrated_batch">
                                        <option value="">ALL</option>
                                        <option value="JEE">JEE</option>
                                        <option value="NEET">NEET</option>
                                        <option value="CPT">CPT</option>
                                        <option value="CLAT">CLAT</option>
                                        <option value="NONE">NONE</option>
                                            
                                        </select>
                                       
                            </div>
                    </div>
                    <input type="hidden" value="APPLICATION_REJECTED" name="report_type" />
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By SSLC Board</label>
                            <select class="form-control input-md required" id="" name="by_board">
                                <option value="">ALL</option>
                                <option value="CBSE">CBSE</option>
                                <option value="ICSE">ICSE</option>
                                <option value="KARNATAKA STATE BOARD">KARNATAKA STATE BOARD</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Elective Language</label>
                            <select class="form-control input-md required" id="" name="elective_sub">
                                <option value="">ALL</option>
                                <option value="KANNADA">KANNADA</option>
                                <option value="HINDI">HINDI</option>
                                <option value="FRENCH">FRENCH</option>
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="applicationApprovedReport"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<!-- Admission Enquiry export modal -->
<div class="modal fade" id="admissionApplicationFeePayment">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Application Fee Payment</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadAdmissionEnquiryForm" action="<?php echo base_url() ?>downloadApplicationFee" method="POST">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mt-1">
                           
                                <select class="form-control input-sm" id="paid_status" name="paid_status" required>
                                <option value="PAID">PAID</option>
                                </select>
                            </div>
                        </div>
                    </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button id="downloadReportExcel" type="submit" class="btn btn-md btn-primary float-right"><i
                        class="fa fa-download"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>


<div class="modal" id="admissionRegisteredStudent">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">ADMITTED Student Report Filter</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" id="admissionRegisteredStudent" action="<?php echo base_url(); ?>downloadAdmittedStudentInfo">
                    <!-- <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Percentage FROM</label>
                            <input maxlength="5" onkeypress="return isNumberKey(event)" type="text" class="form-control"
                                id="inputEmail4" name="percentage_from" placeholder="SSLC Percentage From">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Percentage TO</label>
                            <input maxlength="5" onkeypress="return isNumberKey(event)" name="percentage_to" type="text"
                                class="form-control" id="inputPassword4" placeholder="SSLC Percentage To">
                        </div>
                    </div> -->
                    <input type="hidden" value="ADMISSION_COMPLETED" name="report_type" />
                    <!-- <div class="row">
                        <div class="col-lg-12">
                            <label>By SSLC Board</label>
                            <select class="form-control input-md required" id="" name="by_board">
                                <option value="">ALL</option>
                                <option value="CBSE">CBSE</option>
                                <option value="ICSE">ICSE</option>
                                <option value="KARNATAKA STATE BOARD">KARNATAKA STATE BOARD</option>
                            </select>
                        </div>
                    </div> -->
                    <div class = "row">
                    <div class="col-6">
                            <label for="role">Stream</label>
                            <select class="form-control input-sm" id="stream" name="stream_name" required>
                                <option value="">By Stream</option>
                                <?php if(!empty($streamInfo)){
                                    foreach($streamInfo as $stream){ ?>
                                        <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                                     <label>By Admission Year</label>

                                        <select class="form-control input-md" name="admission_year" id="admission_year">
                                         <option value="<?php echo CURRENT_YEAR?>"><?php echo CURRENT_YEAR?></option>
                                        <option value="2021">2021</option>
                                            
                                        </select>
                                       
                            </div>
                            <div class="form-group col-md-6">
                                     <label>By Integrated Batch</label>

                                        <select class="form-control input-md" name="integrated_batch" id="integrated_batch">
                                        <option value="">ALL</option>
                                        <option value="JEE">JEE</option>
                                        <option value="NEET">NEET</option>
                                        <option value="CPT">CPT</option>
                                        <option value="CLAT">CLAT</option>
                                        <option value="NONE">NONE</option>
                                            
                                        </select>
                                       
                            </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="applicationApprovedReport"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<!-- donload fee Structure report filter modal -->
<div class="modal" id="dayWiseStructureFeePayment">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Download Detailed Fee Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">

                <form role="form" data-download_form="true" id="downloadReportStructure" action="<?php echo base_url() ?>dayWiseStructureFeePayment"
                    method="post" role="form">

                    <div class="row form-contents">
                        <!-- <div class="col-4">
                            <div class="form-group mb-0">
                                <label for="term_name_select">Term Name</label>
                                <select class="form-control" name="term_name" id="term_name_select" required>
                                     <option value="">Select Term</option>
                                    <option value="I PUC">I PUC</option> 
                                    <option value="II PUC" selected>II PUC</option>
                                </select>
                            </div>
                        </div> -->
                        <!-- <div class="col-4">
                            <div class="form-group">
                                <label for="account_type">By Student</label>
                                <select class="form-control selectpicker" name="by_student" id="by_student"
                                    data-live-search="true" required>
                                    <option value="ALL" selected>ALL</option>
                                    <?php if(!empty($feePaidStdInfo)){ 
                                    foreach($feePaidStdInfo as $std){ ?>
                                    <option value="<?php echo $std->application_no; ?>">
                                        <?php echo $std->student_name; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div> -->

                        <!-- <div class="col-4">
                            <div class="form-group">
                                <label for="account_type">By Bank Account</label>
                                <select class="form-control selectpicker" name="bank_account" id="bank_account"
                                    data-live-search="true" required>
                                    <option value="">Select Fee Account Type</option>
                                 
                                    <?php if(!empty($bankAccInfo)){ 
                                    foreach($bankAccInfo as $acc){ ?>
                                    <option value="<?php echo $acc->row_id; ?>">
                                        <?php echo $acc->account_no; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div> -->
                        <!-- <div class="col-4">
                            <div class="form-group">
                                <label for="account_type">Report Type</label>
                                <select class="form-control selectpicker" name="report_type" id="report_type_structure"
                                    data-live-search="true" required>
                                    <option value="">Select Report Type</option>
                                     <option value="BYSTUDENT">By Day Wise</option>
                                    <option value="MONTHWISE">By Year Wise</option>
                                    <option value="DATEWISE">By Date Wise</option>
                                   
                                </select>
                            </div>
                        </div> -->
                        <!-- <div class="col-4">
                            <div class="form-group">
                                <label for="account_type">Report Format</label><br/>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="reportFormat" value="PDF" checked>PDF
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="reportFormat" value="EXCEL">EXCEL
                                    </label>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="row mt-3">

                    
                        
                        <!-- <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Bank Settlement</label>
                                <select class="form-control" name="bank_settlement" id="bank_settlement"
                                    data-live-search="true" required>
                                    <option value="ALL">ALL</option>
                                   
                                    <option value="SETTLED">Only Settled</option> 
                                    <option value="NOT_SETTLED">Not Settled</option> 
                                </select>
                            </div>
                        </div> -->
                    </div>
                    <div class="row mt-3 dateSearchShowStructure">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date From</label>
                                <input type="text" class="form-control" id="date_from" name="date_from"
                                    placeholder="Select Date From" autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date To</label>
                                <input type="text" class="form-control" id="date_to" name="date_to"
                                    placeholder="Select Date To" autocomplete="off" >
                            </div>
                        </div>


                    </div>
                    <!-- <div class="row mt-3 dayWiseDate">

                    <div class="col-6">
                        <div class="form-group">
                            <label for="account_type">Date</label>
                            <input type="text" class="form-control" id="date_day" name="date_day"
                                placeholder="Select Date From" autocomplete="off" >
                        </div>
                    </div>
                    

                    </div> -->
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <input type="submit"  form="downloadReportStructure" class="btn btn-success float-right" value="Download" />
            </div>

        </div>
    </div>
</div>


<!-- I PUC MARK SHEET -->
<div class="modal" id="IpucMarkSheetSubjectWise">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Exam Mark Sheet - Subject</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" data-download_form="true" id="" action="<?php echo base_url(); ?>downloadExamMarkSheet">
                  
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="role">Term</label>
                                <select class="form-control input-sm" id="term" name="term_name" required>
                                    <!-- <option value="" >Select Term</option> -->
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="role">Stream</label>
                            <select class="form-control input-sm" id="stream" name="stream_name" required>
                                <option value="">By Stream</option>
                                <?php if(!empty($streamInfo)){
                                    foreach($streamInfo as $stream){ ?>
                                        <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                        <div class="col-6 mb-2">
                            <label for="role">Section</label>
                            <select class="form-control input-sm" id="section" name="section_name" autocomplete="off">
                                <!-- <option value="">Select Section</option> -->
                                <option value="">ALL</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <!-- <option value="E">E</option>
                                <option value="F">F</option>
                                <option value="G">G</option>
                                <option value="H">H</option>
                                <option value="I">I</option>
                                <option value="J">J</option>
                                <option value="K">K</option>
                                <option value="L">L</option>
                                <option value="M">M</option>
                                <option value="N">N</option>
                                <option value="O">O</option>
                                <option value="P">P</option>
                                <option value="Q">Q</option>
                                <option value="R">R</option>
                                <option value="S">S</option> -->
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="role">Subject</label>
                            <select class="form-control input-sm" id="subject" name="subject_code" required>
                                <option value="">By Subject</option>
                                <?php if(!empty($subjectInfo)){
                                    foreach($subjectInfo as $sub){ ?>
                                        <option value="<?php echo $sub->subject_code; ?>"><?php echo $sub->sub_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                       
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id=subjectWiseAttendanceReport
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<!-- Assignment Mark Report - all subject -->
<div class="modal" id="assignmentConsolidatedMarkReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Exam Mark Sheet</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" data-download_form="true" id="" action="<?php echo base_url(); ?>downloadAssignmentExamMarkReport">
                  
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="role">Term</label>
                                <select class="form-control input-sm" id="term" name="term_name" required>
                                    <option value="" >Select Term</option>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="role">Stream</label>
                            <select class="form-control input-sm" id="stream" name="stream_name">
                                <option value="">By Stream</option>
                                <?php if(!empty($streamInfo)){
                                    foreach($streamInfo as $stream){ ?>
                                        <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                        <!-- <div class="col-6 mb-2">
                            <label for="role">Section</label>
                            <select class="form-control input-sm" id="section" name="section_name" autocomplete="off">
                                <option value="">ALL</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                                <option value="G">G</option>
                                <option value="H">H</option>
                                <option value="I">I</option>
                            </select>
                        </div> -->
                       
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id=subjectWiseAttendanceReport
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- The leave view Modal -->
<div class="modal" id="downloadStaffLeaveReport">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header ">
                <h4 class="modal-title">Download Leave Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="padding:0px;">
                <div class="card-body contents-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date From</label>
                                    <input type="text" class="dateFrom form-control" name="fromDate" id="fromDate_report"
                                        value="" placeholder="Date From" required autocomplete="off">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date To</label>
                                    <input type="text" class="dateTo form-control" name="toDate" id="toDate_report"
                                        value="" placeholder="Date To" required autocomplete="off">
                                </div>
                            </div>
                       
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group ">
                                <label for="leave_type_report">Leave Type</label>
                                <select id="leave_type_report" name="leave_type_report" class="form-control"
                                    id="exampleFormControlSelect1" required>
                                    <option value="ALL">ALL</option>
                                     <option value="CL">Casual Leave(CL)</option>
                                     <option value="ML">Medical Leave(ML)</option>
                                     <option value="MARL">Marriage Leave(ML)</option>
                                     <option value="PL">Paternity Leave(PL)</option>
                                     <option value="MATL">Maternity Leave(ML)</option>
                                     <option value="EL">Earned Leave(EL)</option>
                                     <option value="OD">Offical Duty(OD)</option>
                                     <option value='LOP'>Loss Of Pay(LOP)</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group ">
                                    <label for="team_id">By Staff</label>
                                    <select class="form-control input-sm selectpicker" id="applied_staff_id_report"
                                    name="applied_staff_id_report" data-live-search="true" required>
                                    <option value="ALL">ALL</option>
                                    <?php
                                        if(!empty($currentStaffInfo))
                                        {
                                            foreach ($currentStaffInfo as $rl)
                                            {
                                                ?>
                                                <option value="<?php echo $rl->staff_id ?>">
                                                    <?php echo strtoupper($rl->name) ?></option>
                                                <?php
                                                }
                                            }
                                        ?>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group ">
                                <label for="leave_status_report">Leave Status</label>
                                <select id="leave_status_report" name="leave_status_report" class="form-control"
                                    id="exampleFormControlSelect1" required>
                                    <option value="ALL">ALL</option>
                                    <option value="PENDING">PENDING</option>
                                     <option value="APPROVED">APPROVED</option>
                                     <option value="REJECTED">REJECTED</option>
                                   
                                </select>
                                </div>
                            </div>
                        </div>
                       
                        <hr class="mt-1 mb-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <div id="loader"></div>
                                <button type="button" class="btn pull-right btn-primary text-white"
                                    onclick="downloadLeaveReport()" name="add">Download</button>
                                <button type="button" class="btn btn-danger pull-left"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </div>
                   
                    <!-- Modal footer -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="downloadStaffLeavePendingReport">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header ">
                <h4 class="modal-title">Download Pending Leave Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="padding:0px;">
                <div class="card-body contents-body">
                    <form data-download_form="true" action="<?php echo base_url() ?>downloadStaffLeavePendingReport" method="POST">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group ">
                                    <label for="team_id">By Staff</label>
                                    <select class="form-control input-sm selectpicker" id="applied_staff_id_report" name="applied_staff_id" data-live-search="true" required>
                                        <option value="ALL">ALL</option>
                                        <?php
                                        if (!empty($currentStaffInfo)) {
                                            foreach ($currentStaffInfo as $rl) {
                                        ?>
                                                <option value="<?php echo $rl->staff_id ?>">
                                                    <?php echo strtoupper($rl->name) ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group ">
                                    <label for="leave_type">Year</label>
                                    <select id="year" name="year" class="form-control" id="exampleFormControlSelect1" required>
                                    <?php if (!empty($leaveYearInfo)) {
                                                    foreach ($leaveYearInfo as $record) { 
                                                ?>
                                                        <option value="<?php echo $record->year; ?>">
                                                            <?php echo $record->year; ?>
                                                        </option>
                                                <?php 
                                                    }
                                    } ?>
                                        <!-- <option value="2025">2025</option>
                                        <option value="2024">2024</option> -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr class="mt-1 mb-1">
                        <div class="modal-footer row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <!-- <div id="loader"></div> -->
                                <button type="submit" class="btn pull-right btn-primary text-white" name="Download">Download</button>
                                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                    <!-- Modal footer -->
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Assignment Mark Report - all subject -->
<div class="modal" id="andlyticReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Anaytic Reports</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" data-download_form="true" id="" action="<?php echo base_url(); ?>getSectionPeformanceAnalyticsPdf">
                  
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="role">Term</label>
                                <select class="form-control input-sm" id="term" name="term_name" required>
                                    <option value="" >Select Term</option>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="role">Stream</label>
                            <select class="form-control input-sm" id="stream" name="stream_name" required>
                                <option value="">By Stream</option>
                                <?php if(!empty($streamInfo)){
                                    foreach($streamInfo as $stream){ ?>
                                        <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                     <div class="col-6 mb-2">
                            <label for="role">Section</label>
                            <select class="form-control input-sm" id="section" name="section_name" autocomplete="off">
                                <option value="">ALL</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <!-- <option value="E">E</option>
                                <option value="F">F</option>
                                <option value="G">G</option>
                                <option value="H">H</option>
                                <option value="I">I</option> -->
                            </select>
                        </div> 
                        <div class="col-6">
                                <label for="role">Subject</label>
                                <select class="form-control input-sm" id="subject" name="subject_code" required>
                                    <option value="">By Subject</option>
                                    <?php if(!empty($subjectInfo)){
                                        foreach($subjectInfo as $sub){ ?>
                                            <option value="<?php echo $sub->subject_code; ?>"><?php echo $sub->sub_name; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>

                            <div class="col-6">
                            <select id="" name="exam_type" class="form-control" required>
                                <option value="">Select Exam</option>
                                <?php if (!empty($examTypeInfo)) {
                                            foreach ($examTypeInfo as $examm) { ?>
                                                <option value="<?php echo $examm->exam_type; ?>"><?php echo $examm->exam_type; ?></option>
                                        <?php }
                                        } ?>
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <div class="modal-footer">
                                <button id="downloadstaffReportExcel" type="submit" class="btn btn-md btn-primary float-right"><i
                                        class="fa fa-download"></i> Download</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>



<!-- The Modal -->
<div class="modal" id="downloadMerit">
    <div class="modal-dialog ">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header bg-blue ">
                <h4 class="modal-title">Download Admission Merit List</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Select Preference</label>
                            <select class="form-control input-sm" id="preference" name="preference">
                                <?php if($by_first_preference != ""){ ?>
                                <option value="<?php echo $by_first_preference; ?>" selected><b>Sorted:
                                        <?php echo $by_first_preference; ?></b></option>
                                <option value="">Select One Preference</option>
                                <option value="PCMB">PCMB</option>
                                <option value="PCMC">PCMC</option>
                                <option value="PCME">PCME</option>
                                <option value="PCMS" >PCMS</option>
                                <option value="CEBA">CEBA</option>
                                <option value="CSBA">CSBA</option>
                                <option value="MEBA">MEBA</option>
                                <option value="MSBA">MSBA</option>
                                <option value="PEBA">PEBA</option>
                                <option value="SEBA">SEBA</option>
                                <option value="HEPS">HEPS</option>
                                <?php } else  { ?>
                                <option value="">Select One Preference</option>
                                <option value="PCMB">PCMB</option>
                                <option value="PCMC">PCMC</option>
                                <option value="PCME">PCME</option>
                                <option value="PCMS" >PCMS</option>
                                <option value="CEBA">CEBA</option>
                                <option value="CSBA">CSBA</option>
                                <option value="MEBA">MEBA</option>
                                <option value="MSBA">MSBA</option>
                                <option value="PEBA">PEBA</option>
                                <option value="SEBA">SEBA</option>
                                <option value="HEPS">HEPS</option>
                                <?php
                    } ?>

                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Filter SSLC Board Name</label>
                            <select class="form-control input-md required" id="by_board_name_download"
                                name="by_board_name_download">
                                <option value="" selected>Filter By SSLC Board Name</option>
                                <option value="">ALL</option>
                                <option value="KARNATAKA STATE BOARD">KARNATAKA STATE BOARD</option>
                                <option value="CBSE">CBSE</option>
                                <option value="ICSE">ICSE</option>
                                <option value="OTHER">OTHER</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-6">
                        <label>By Student Type</label>

                        <select class="form-control input-md required" id="student_type" name="student_type">
                         
                            <option value="">ALL</option>
                            <option value="PH">Physically Challenged</option>
                            <option value="DYC">Dyslexia Challenged</option>
                            <option value="SPORTS">SPORTS Quota</option>
                            <option value="NCC">NCC Quota</option>
                        </select>

                    </div>


                </div>
                <div class="row">
                    <div class="col-12">
                        <label>Percentage Filter</label>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <span class="form-group-addon"><b>FROM</b></span>
                            <input maxlength="5" onkeypress="return isNumberKey(event)" id="percentage_from_downlaod"
                                type="text" class="form-control" name="percentage_from_downlaod"
                                placeholder="Percentage From(%)">
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <span class="form-group-addon"><b>TO</b></span>
                            <input maxlength="5" onkeypress="return isNumberKey(event)" id="percentage_to_downlaod"
                                type="text" class="form-control" name="percentage_to_downlaod"
                                placeholder="Percentage To(%)">
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button style="float:right;" id="downloadMeritList" type="button" class="btn btn-md btn-primary"><i
                        class="fa fa-download"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- The Modal -->
<div class="modal" id="downloadIPuReport">
    <div class="modal-dialog ">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-blue ">
                <h4 class="modal-title">Download Mark List</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="role">Select Download Type</label>
                            <select class="form-control required" id="type" name="type">
                                <option value="All" >All Students</option>
                                <option value="Failed" >Only Failed Students</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                            <label for="role">Stream</label>
                            <select class="form-control input-sm" id="streamName" name="streamName">
                                <option value="All">ALL</option>
                                <?php if(!empty($streamInfo)){
                                    foreach($streamInfo as $stream){ ?>
                                        <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="role">Section</label>
                            <select class="form-control input-sm" id="sectionName" name="">
                                        <option value="ALL">ALL</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                            </select>
                        </div>
                </div>
            </div>

            <div class="modal-footer">
                <span id="loader"></span>
                <button type="submit" onclick="downloadExcelSheet();" id="downloadAllMarks" class="btn btn-primary">Download</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Management Fee export modal -->
<div class="modal fade" id="mangementFeeReport">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Datewise Fee Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadManagementFeeReport" action="<?php echo base_url() ?>downloadDateWiseFeeReportInfo" method="POST">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="role">Select Term</label>
                                <select class="form-control required" name="term_name" required>
                                    <option value="">Select Term</option>
                                    <option value="">ALL</option>
                                    <option value="I PUC">I PUC</option>
                                    <option  value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>By Stream</label>
                                <select class="form-control input-md required" id="" name="preference" required>
                                    <option value="">Select Stream</option>
                                    <option value="">ALL</option> 
                                    <?php if(!empty($streamInfo)){
                                        foreach($streamInfo as $stream){ ?>
                                            <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Year</label>
                                <select class="form-control input-md required" id="" name="year" required>
                                <option value="">Select Year</option>
                                <?php if (!empty($studentYearInfo)) {
                                    foreach ($studentYearInfo as $record) { ?>
                                        <option value="<?php echo $record->year; ?>"><?php echo $record->year; ?></option>
                                <?php }} ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date From</label>
                                <input type="date" class="form-control" name="date_from"
                                    placeholder="Select Date From" autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date To</label>
                                <input type="date" class="form-control"  name="date_to"
                                    placeholder="Select Date To" autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-6">
                            <label>By Payment Type</label>
                            <select class="form-control selectpicker input-md required" name="payment_type[]" multiple>
                                <option value="ALL">ALL</option>
                                <option value="CASH">CASH</option>
                                <option value="ONLINE">ONLINE</option>
                                <option value="DD">DD</option>
                                <option value="CARD">CARD</option>
                                <option value="BANK">BANK</option>
                                <option value="UPI">UPI</option>
                                <option value="NEFT">NEFT</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success" id="reportFormat" name="reportFormat" value="VIEW" onclick="selectOption('VIEW')" formtarget="_blank"/>
                    <button type="submit" name="reportFormat" value="download" class="btn btn-md btn-primary float-right"><i class="fa fa-download"></i> Download</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- donload fee Structure report filter modal -->
<div class="modal" id="specialFeePaymentReport">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Download Detailed Special Fee Receipt Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">

                <form role="form" data-download_form="true" id="downloadReportStructureSpecialFee" action="<?php echo base_url() ?>specialFeePaymentReport"
                    method="post" role="form">

                    <div class="row mt-3 dateSearchShowStructure">
                        <div class="col-4" id="termName_select">
                            <div class="form-group mb-0">
                                <label for="term_name_select">Term Name</label>
                                <select class="form-control" name="term_name" id="term_name_select" required>
                                     <!-- <option value="">Select Term</option> -->
                                    <option value="I PUC" selected>I PUC</option> 
                                    <option value="II PUC" >II PUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>By Stream</label>
                                <select class="form-control input-md required" id="" name="preference" required>
                                    <option value="">Select Stream</option>
                                    <option value="">ALL</option> 
                                    <?php if(!empty($streamInfo)){
                                        foreach($streamInfo as $stream){ ?>
                                            <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="account_type">Year</label>
                                <select class="form-control" name="fee_year" id="fee_year">
                                    <?php if (!empty($studentYearInfo)) {
                                        foreach ($studentYearInfo as $record) {  ?>
                                            <option value="<?php echo $record->year; ?>">
                                                <?php echo $record->year; ?>
                                            </option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="account_type">Date From</label>
                                <input type="text" class="form-control datepicker" id="date_fromm" name="date_from"
                                    placeholder="Select Date From" autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="account_type">Date To</label>
                                <input type="text" class="form-control datepicker" id="date_too" name="date_to"
                                    placeholder="Select Date To" autocomplete="off" >
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="account_type">Report Type</label>
                                <select class="form-control" name="report_type" id="report_type_group" data-live-search="true">
                                    <!-- <option value="CONSOLIDATED_PAID">CONSOLIDATED PAID</option> -->
                                    <!-- <option value="DATE_WISE">Date Wise Group</option> 
                                    <option value="CATEGORY_WISE">Date Wise Consolidated</option>  -->
                                    <option value="SPECIAL_FEE_REPORT">Special Fee Consolidated</option>
                                    <!-- <option value="SPECIAL_FEE_DATE_WISE_REPORT">Special Fee Date Wise</option> -->
                                    <!-- <option value="FEE_PAID">Overall Fee Paid</option> -->
                                </select>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="account_type">Payment Mode</label>
                                <select class="form-control" name="payment_type" id="payment_type" data-live-search="true">
                                   
                                    <option value="ALL">ALL</option> 
                                    <option value="CASH">CASH</option>
                                    <option value="ONLINE">ONLINE</option>
                                    <option value="DD">DD</option>
                                    <option value="CARD">CARD</option>
                                    <option value="BANK">BANK</option>
                                    <option value="UPI">UPI</option>
                                    <option value="NEFT">NEFT</option>
                                </select>
                            </div>
                        </div>

                        
                        
                    </div>
                   
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <input type="submit"  form="downloadReportStructureSpecialFee" class="btn btn-success float-right" value="Download" />
            </div>

        </div>
    </div>
</div>

<!-- Bank Settlement Fee export report -->
<div class="modal fade" id="bankSettlementReport">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Bank Settlement Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div> 
            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadBankSplit" action="<?php echo base_url() ?>downloadBankSettlementReport" method="POST">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="role">Select Term</label>
                                <select class="form-control required" name="term_name" required>
                                    <option value="">Select Term</option>
                                    <option value="">ALL</option>
                                    <option value="I PUC">I PUC</option>
                                    <option  value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Year</label>
                                <select class="form-control input-md required" id="" name="year" required>
                                <option value="">Select Year</option>
                                <?php if (!empty($studentYearInfo)) {
                                    foreach ($studentYearInfo as $record) { ?>
                                        <option value="<?php echo $record->year; ?>"><?php echo $record->year; ?></option>
                                <?php }} ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date From</label>
                                <input type="date" class="form-control" id="" name="date_from" required
                                    placeholder="Select Date From" autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date To</label>
                                <input type="date" class="form-control" id="" name="date_to" required
                                    placeholder="Select Date To" autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-6">
                            <label>By Payment Type</label>
                            <select class="form-control selectpicker input-md required" name="payment_type[]" multiple>
                                <option value="ALL">ALL</option>
                                <option value="CASH">CASH</option>
                                <option value="ONLINE">ONLINE</option>
                                <option value="DD">DD</option>
                                <option value="CARD">CARD</option>
                                <option value="BANK">BANK</option>
                                <option value="UPI">UPI</option>
                                <option value="NEFT">NEFT</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success" id="reportFormat" name="reportFormat" value="VIEW" onclick="selectOption('VIEW')" formtarget="_blank"/>
                    <button type="submit" name="reportFormat" value="download" class="btn btn-md btn-primary float-right"><i class="fa fa-download"></i> Download</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bifurcation Fee export modal -->
<div class="modal fade" id="downloadBifurcationReport">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Bifurcation Fee Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadBifurcationReportForm" action="<?php echo base_url() ?>downloadBifurcationReport" method="POST">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="role">Select Term</label>
                                <select class="form-control required" name="term_name" required>
                                    <option value="ALL" selected>ALL</option>
                                    <option value="I PUC">I PUC</option>
                                    <option  value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Year</label>
                                <select class="form-control input-md required" id="" name="year" required>
                                    <option value="">Select Year</option>
                                    <?php if (!empty($studentYearInfo)) {
                                        foreach ($studentYearInfo as $record) { ?>
                                            <option value="<?php echo $record->year; ?>"><?php echo $record->year; ?></option>
                                    <?php }} ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date From</label>
                                <input type="date" class="form-control" name="date_from"
                                    placeholder="Select Date From" autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date To</label>
                                <input type="date" class="form-control"  name="date_to"
                                    placeholder="Select Date To" autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-6">
                            <label>Payment Type</label>
                            <select class="form-control selectpicker text-dark" name="payment_type[]" multiple>
                                <option value="ALL">ALL</option>
                                <option value="CASH">CASH</option>
                                <option value="ONLINE">ONLINE</option>
                                <option value="DD">DD</option>
                                <option value="CARD">CARD</option>
                                <option value="BANK">BANK</option>
                                <option value="UPI">UPI</option>
                                <option value="NEFT">NEFT</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="role">Select Type</label>
                                <select class="form-control required" name="fee_type" required>
                                    <option value="">Select Type</option>
                                    <option value="CONTRIBUTION FEE">CONTRIBUTION FEE</option>
                                    <option value="MANAGEMENT FEE">MANAGEMENT FEE</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success" id="reportFormat" name="reportFormat" value="VIEW" onclick="selectOption('VIEW')" formtarget="_blank"/>
                    <button type="submit" name="reportFormat" value="download" class="btn btn-md btn-primary float-right"><i class="fa fa-download"></i> Download</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="downloadFeeDueReport">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header p-2">
                <h6 class="modal-title">Download Fee Due Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadFeeDueReport" method="POST" action="<?php echo base_url().'downloadFeeDueReport'?>">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Select Term</label>
                                <select class="form-control" name="term_name_select"  required>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Stream</label>
                            <select class="form-control input-md required" id="" name="preference" required>
                                <option value="">Select Stream</option>
                                <option value="">ALL</option> 
                                <?php if(!empty($streamInfo)){
                                    foreach($streamInfo as $stream){ ?>
                                        <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mt-2">
                            <label>Year</label>
                            <select class="form-control input-md required" name="year" required>
                                <option value="">Select Year</option>
                                <?php if(!empty($studentYearInfo)) {
                                    foreach($studentYearInfo as $record){ ?>
                                        <option value="<?php echo $record->year; ?>"><?php echo $record->year; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" id="reportFormat" name="reportFormat" value="VIEW" onclick="selectOption('VIEW')" formtarget="_blank"/>
                        <button type="submit" name="reportFormat" value="download" class="btn btn-md btn-primary float-right"><i class="fa fa-download"></i> Download</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Government Fee export modal -->
<div class="modal fade" id="governmentFeeReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Government Fee</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadAdmissionEnquiryForm" action="<?php echo base_url() ?>downloadGovtFeeReport" method="POST">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="role">Select Term</label>
                                <select class="form-control required" name="term_name" required>
                                    <option value="">Select Term</option>
                                    <option value="">ALL</option>
                                    <option value="I PUC">I PUC</option>
                                    <option  value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                        <div class="form-group">
                            <label>Year</label>
                            <select class="form-control input-md required" id="" name="year" required>
                            <option value="">Select Year</option>
                            <option value="2025">2025-26</option>
                            <option value="2024">2024-25</option>
                            
                            </select>
                        </div>
                    </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date From</label>
                                <input type="text" class="form-control datepicker"  name="date_from"
                                    placeholder="Select Date From" autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date To</label>
                                <input type="text" class="form-control datepicker" name="date_to"
                                    placeholder="Select Date To" autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-6">
                            <label>By Payment Type</label>
                            <select class="form-control selectpicker input-md required" name="payment_type[]" multiple>
                                <option value="ALL">ALL</option>
                                <option value="CASH">CASH</option>
                                <option value="DD">DD</option>
                                <option value="BANK">BANK</option>
                                <option value="UPI">UPI</option>
                                <option value="CARD">CARD</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label>By Student Type</label>
                            <select class="form-control selectpicker input-md required" name="student_type">
                                <option value="ALL">ALL</option>
                                <option value="ACTIVE">ACTIVE</option>
                                <option value="INACTIVE">INACTIVE</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label>By Settlement Status</label>
                            <select class="form-control selectpicker input-md required" name="settlement_type">
                                <option value="ALL">ALL</option>
                                <option value="SETTLED">SETTLED</option>
                                <option value="PENDING">PENDING</option>
                            </select>
                        </div>
                    </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <input type="submit" class="btn btn-success" id="reportFormat" name="reportFormat" value="VIEW" onclick="selectOption('VIEW')" formtarget="_blank"/>
                <button type="submit" name="reportFormat" value="download" class="btn btn-md btn-primary float-right"><i class="fa fa-download"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="downloadFeePaidReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header p-2">
                <h6 class="modal-title">Download Fee Paid Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadFeePaidReport" method="POST" action="<?php echo base_url().'downloadFeePaidReport'?>">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Select Term</label>
                                <select class="form-control" name="term_name_select"  required>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                    </div>
               
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Stream</label>
                            <select class="form-control input-md required" id="" name="preference">
                              
                                <option value="">Select One Preference</option>
                                <option value="">ALL</option> 
                                <?php if(!empty($streamInfo)){
                                    foreach($streamInfo as $stream){ ?>
                                    <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                  
                    <div class="row">
                        <div class="col-lg-12 mt-2">
                            <label>Year</label>
                            <select class="form-control input-md required" name="year">
                            <option value="2025">2025-26</option>
                                <option value="2024">2024-25</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-lg-12 mt-2">
                            <label>By Payment Type</label>
                            <select class="form-control input-md required" name="payment_type">
                                <option value="ALL">ALL</option>
                                <option value="FULL_PAYMENT">Full Payment</option>
                                <option value="HALF_PAYMENT">Half Payment</option>
                                <option value="NOT_PAID">Not Paid</option>
                                <option value="PENDING">Overall Due</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mt-2">
                            <label>By Student Type</label>
                            <select class="form-control selectpicker input-md required" name="student_type">
                                <option value="ALL">ALL</option>
                                <option value="ACTIVE">ACTIVE</option>
                                <option value="INACTIVE">INACTIVE</option>
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" id="reportFormat" name="reportFormat" value="VIEW" onclick="selectOption('VIEW')" formtarget="_blank"/>
                        <button type="submit" name="reportFormat" value="download" class="btn btn-md btn-primary float-right"><i class="fa fa-download"></i> Download</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bank Deposit export modal -->
<div class="modal fade" id="bankDepositReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Bank Deposit Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form id="downloadAdmissionEnquiryForm" action="<?php echo base_url() ?>downloadBankDepositReport" method="POST"> 
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date From</label>
                                <input type="text" class="form-control datepicker"  name="date_from"
                                    placeholder="Select Date From" autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date To</label>
                                <input type="text" class="form-control datepicker" name="date_to"
                                    placeholder="Select Date To" autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-6">
                        <label for="deposit_type">Deposite Type</label>
                            <select class="form-control input-sm" id="deposit_type" name="deposit_type" required>
                                <?php if(!empty($deposit_type)){ ?>
                                <option value="<?php echo $deposit_type; ?>">Selected: <?php echo $deposit_type; ?></option>
                                <?php } ?>
                                <option value="">Select Deposit Type</option>
                                <option value="ALL">ALL</option>
                                <?php if(!empty($deposittypeInfo)){  
                                    foreach($deposittypeInfo as $record){ ?>
                                <option value="<?php echo $record->deposit_type; ?>"><?php echo $record->deposit_type; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <!-- <input type="submit" class="btn btn-success" id="reportFormat" name="reportFormat" value="VIEW" onclick="selectOption('VIEW')" formtarget="_blank"/> -->
                <button type="submit" name="reportFormat" value="download" class="btn btn-md btn-primary float-right"><i class="fa fa-download"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="concessionFeeReport">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Scholarship Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" id="concessionFeeReport" action="<?php echo base_url(); ?>downloadConcessionFeeReport">
                    <input type="hidden" value="Concession_Report" name="report_type" />
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Term</label>
                            <select class="form-control input-md required" id="" name="term_name">
                                <option value="I PUC">I PUC</option>
                                <option value="II PUC">II PUC</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label>Select Status</label>
                            <select class="form-control selectpicker input-md required" name="concession_status">
                                <option value="APPROVED">APPROVED</option>
                                <option value="REJECTED">REJECTED</option>
                                <option value="PENDING">PENDING</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label>Scholarship Year</label>
                            <select class="form-control input-md required" id="" name="year">
                                <?php if (!empty($studentYearInfo)) {
                                    foreach ($studentYearInfo as $record) { ?>
                                        <option value="<?php echo $record->year; ?>">
                                            <?php echo $record->display_year; ?>
                                        </option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" id="reportFormat" name="reportFormat" value="VIEW" onclick="selectOption('VIEW')" formtarget="_blank"/>
                        <button type="submit" name="reportFormat" value="download" class="btn btn-md btn-primary float-right"><i class="fa fa-download"></i> Download</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="cancelReceiptReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"> Credit Note Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body p-2">

                <!-- <form role="form" id="getCancelReceipt" action="<?php echo base_url() ?>getCancelReceiptReport"
                    method="post" role="form"> -->
                    <form action="<?php echo base_url() ?>getCancelReceiptReport" method="POST" data-download_form="true">

                   
                    <div class="row">
                        <div class="col-6">
                                <label>Payment Year</label>
                                <select class="form-control input-md"  name="year" >
                                    <!-- <option value="">ALL</option> -->
                                    <option value="2025">2025-26</option>
                                    <option value="2024"><?php echo '2024-25'; ?></option>
                                   
                            </select>
                        </div>
                    
                        <div class="col-6">
                                <label>Fee Type</label>
                                <select class="form-control input-md"  name="type" >
                                    <!-- <option value="">ALL</option> -->
                                    <option value="Dept"><?php echo "Government Fee"; ?></option>
                                    <option value="Mgmt"><?php echo "Management Fee"; ?></option>
                                   
                            </select>
                        </div>
                    </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <input type="submit" class="btn btn-success" id="reportFormat" name="reportFormat" value="VIEW" onclick="selectOption('VIEW')" formtarget="_blank"/>
                <button type="submit"  name="reportFormat" value="download" class="btn btn-md btn-primary float-right"><i class="fa fa-download"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                <!-- <input type="submit" form="getCancelReceipt" class="btn btn-success float-right" value="Download" /> -->
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="studentReport">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header table-primary">
        <h4 class="modal-title">Download Student Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body p-2">
        <form action="<?php echo base_url() ?>downloadStudentExcelReport" method="POST">
       
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Select Term</label>
                        <select class="form-control input-sm selectpicker" id="term" name="term" required>
                            <option value="">Select Term</option>
                            <option value="I PUC">I PUC</option>
                            <option value="II PUC">II PUC</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Select Preference</label>
                        <select class="form-control input-sm selectpicker" id="preference" name="preference" required>
                            <option value="">Select One Preference</option>
                            <option value="ALL">ALL</option>
                            <?php foreach($streamInfo as $stream){ ?>
                                <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                            <?php } ?>
                         
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Select Intake Year</label>

                        <select class="form-control input-sm selectpicker" id="academic_year" name="academic_year" required>
                            <option value="">Select Intake year</option>

                            <?php if (!empty($yearInfo)) {
                                foreach ($yearInfo as $row) {

                                    // Format year (handles both 2026 OR 2026-27)
                                    $start = $row->year;
                                    if (strpos($start, '-') === false) {
                                        $end = substr($start + 1, -2);
                                        $year = $start . '-' . $end;
                                    } else {
                                        $year = $start;
                                    }
                            ?>
                                    <option value="<?php echo $year; ?>"
                                        <?php if (!empty($academic_year) && $academic_year == $year) echo 'selected'; ?>>
                                        
                                        <?php echo $year; ?>
                                    </option>

                            <?php } } ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                            <div class="form-group">
                                <label>Select Gender</label>
                                <select class="form-control input-sm selectpicker" id="gender" name="gender" >
                                    <option value="">Select Gender</option>
                                    <option value="ALL">ALL</option>
                                    <option value="MALE">MALE</option>
                                    <option value="FEMALE">FEMALE</option>
                                   
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="form-group">
                                <label>Select Religion</label>
                                <select class="form-control input-sm selectpicker" id="religion" name="religion" >
                                    <option value="">Select Religion</option>
                                    <option value="ALL">ALL</option>
                                    <option value="HINDU">HINDU</option>
                                    <option value="ISLAM">ISLAM</option>
                                    <option value="BUDDHIST">BUDDHIST</option>
                                    <option value="CHRISTIAN">CHRISTIAN</option>  
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="form-group">
                                <label>Select Student Status</label>
                                <select class="form-control input-sm selectpicker" id="status" name="status" >
                                    <option value="">Select Status</option>
                                    <option value="1">ACTIVE</option>
                                    <option value="0">ALUMNI</option>
                                    <option value="INACTIVE">INACTIVE</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="form-group">
                                <label>Report Type</label>
                                <select class="form-control selectpicker input-md required" name="report_type" required>
                                    <option value="VIEW">VIEW</option>
                                    <option value="EXCEL">EXCEL</option>
                                </select>
                            </div>
                        </div>
            </div>
            <h5>Select Required Fields</h5>
            <div class="row">

            <div class="col-lg-4">
                <input type="hidden" name="fields[]" class="studentId" value="student_id"
                        checked/><span style="font-size: 18px;"> </span>

                    <input type="checkbox" class="studentId disabled" value=""
                        checked disabled/><span style="font-size: 18px;"> &nbsp;&nbsp;Student ID </span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="studentId "  value="application_no" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Application Number</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="admission_no"  value="admission_no" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Admission No.</span>
                </div>
                
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother"  value="student_name" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Student Name</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother" 
                        value="permanent_address" /><span style="font-size: 18px;"> &nbsp;&nbsp;Permanent Address</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="studentId "  value="present_address" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Present Address </span>
                </div>
            </div>

            <div class="row">
                <!-- <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="email" checked value="email" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Student email</span>
                </div> -->
                <!-- <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother" checked value="blood_group" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Blood Group</span>
                </div> -->
            

                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother"  value="dob" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Date Of Birth</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="nationality_name"  value="nationality_name" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Nationality</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="studentId "  value="father_name" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Father Name</span>
                </div>
            </div>

            <div class="row">
                <!-- <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother" checked value="dob" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Date Of Birth</span>
                </div> -->
                
                <!-- <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="birth_place" checked value="birth_place" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Place of Birth</span>
                </div> -->
                <!-- <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="taluk" checked value="taluk" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Taluk</span>
                </div> -->
               
                <!-- <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="district" checked value="district" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;District</span>
                </div> -->
                <!-- <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="state" checked value="state" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;State</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="religion " checked value="religion"/><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Religion</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="caste" checked value="caste" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Caste</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="category" checked value="category_name" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Category</span>
                </div> -->
                <!-- <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="mother_tongue" checked value="mother_tongue" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Mother Tongue</span>
                </div> -->
              
                <!-- <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="aadhar_no" checked value="aadhar_no" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Aadhaar No.</span>
                </div> -->
               
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother"  value="mother_name" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Mother Name</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="term_name"  value="term_name" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Term name</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="section_name"  value="section_name" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Section</span>
                </div>
              
                <!-- <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="father_occupation" checked value="father_occupation" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Father Occupation</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="mother_occupation" checked value="mother_occupation" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Mother Occupation</span>
                </div> -->
            </div>

            <div class="row">
             <!-- <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="annual_income" checked value="annual_income" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Annual Income</span>
                </div> -->
                
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="stream_name"  value="stream_name" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Stream Name</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother"  value="father_mobile" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Father Mobile</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="onlyMother"  value="mother_mobile" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Mother Mobile</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="elective_sub"  value="elective_sub" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Elective Language</span>
                </div>
                <!-- <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="guardian_address" checked value="guardian_address" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Guardian Address</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="mobile_one" checked value="mobile_one" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Student Mobile</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="primary_mobile " checked value="primary_mobile"/><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Primary Contact</span>
                </div> -->
                <!-- <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="institution_name" checked value="institution_name" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;School Name</span>
                </div>  -->
                <!-- <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="class" checked value="class" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Class</span>
                </div> -->
                <!-- <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="sslc_register_no" checked value="sslc_register_no" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Exam Register No.</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="last_board_name" checked value="last_board_name" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Board name</span>
                </div>
                
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="medium_of_instruction" checked value="medium_of_instruction" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Medium of Instruction</span>
                </div>
                
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="passing_month" checked value="passing_month" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Month of Passing</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="passing_year" checked value="passing_year" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Passing Year</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="school_address" checked value="school_address" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;School Address</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="tc_no" checked value="tc_no" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;TC No.</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="tc_date" checked value="tc_date" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;TC Date</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="term_name" checked value="term_name" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Term name</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="section_name" checked value="section_name" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Section</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="stream_name" checked value="stream_name" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Stream Name</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="elective_sub " checked value="elective_sub" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Elective Subject</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="date_of_admission" checked
                        value="date_of_admission" /><span style="font-size: 18px;"> &nbsp;&nbsp;Date Of Admission</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="student_belongs_to_sc_st" checked value="student_belongs_to_sc_st" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Belongs to SC/ST</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="other_state_status" checked value="other_state_status" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Other State</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="nri_status" checked value="nri_status" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;NRI</span>
                </div> -->
            </div>

            <!-- <div class="row">
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="studentId " checked value="pu_board_number" /><span
                        style="font-size: 18px;"> &nbsp;&nbsp;Register Number</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="is_handicapped" checked value="is_handicapped" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Physically Challenged</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="hostel_facility" checked value="hostel_facility" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Hostel Facility</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="coaching_required" checked value="coaching_required" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Coaching Required</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="coaching_combination" checked value="coaching_combination" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Coaching Combination</span>
                </div>
                <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="pincode" checked value="pincode" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Pincode</span>
                </div>
            </div> -->
            <hr class="m-1">
            <!-- <div class="text-center text-dark">School Details</div>
            <hr class="m-1">
            <div class="row">-->
                
                <!-- <div class="col-lg-4">
                    <input type="checkbox" name="fields[]" class="last_board_name" value="last_board_name" />
                    <span style="font-size: 18px;"> &nbsp;&nbsp;Board Name</span>
                </div> -->
                
                
            <!-- </div>  -->
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button id="downloadReportExcel" type="submit" class="btn btn-md btn-primary float-right"><i
                class="fa fa-download"></i> Download</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
        </form>
    </div>
  </div>
</div>

<!-- excel Download Modal -->
<div id="markSheetReport" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Download Marks Sheet</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-2">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="role">Select Term</label>
                            <select class="form-control required" id="termName" name="term_name">
                                <option value="">Select Term</option>
                                <option value="I PUC">I PUC</option>
                                <option value="II PUC">II PUC</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="role">Select Stream</label>
                            <select class="form-control required" id="stream_name_id" required>
                                            <?php foreach($streamInfo as $stream){ ?>
                                <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                            <?php } ?>
                                               
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="role">Select Section</label>
                            <select class="form-control required" id="typeSection" name="type">
                                <option value="ALL">ALL (No Section)</option>
                                <!-- <option value="ALL">ALL</option> -->
                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                                <!-- <option value="E">E</option>
                                                <option value="F">F</option>
                                                <option value="G">G</option>
                                                <option value="H">H</option>
                                                <option value="I">I</option>
                                                <option value="J">J</option>
                                                <option value="K">K</option>
                                                <option value="L">L</option>
                                                <option value="M">M</option>
                                                <option value="N">N</option>
                                                <option value="O">O</option>
                                                <option value="P">P</option>
                                                <option value="Q">Q</option>
                                                <option value="R">R</option>
                                                <option value="S">S</option> -->
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="role">Select Exam</label>
                            <select class="form-control required" id="examType" name="examType">
                                <option value="">Select Exam</option>
                                <?php if (!empty($examTypeInfo)) {
                                            foreach ($examTypeInfo as $examm) { ?>
                                                <option value="<?php echo $examm->exam_type; ?>"><?php echo $examm->exam_type; ?></option>
                                        <?php }
                                        } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="role">Select Report Type</label>
                            <select class="form-control required" id="report_type" name="report_type">
                                <!-- <option value="">Select Report Type</option> -->
                                <option value="ALL">ALL</option>
                                <option value="only_failed">Only Failed</option>
                                <!-- <option value="only_distinction">Only Distinction</option> -->
                            </select>
                        </div>
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label for="role">Select Download Type</label>
                    <select class="form-control required" id="type" name="type">
                        <option value="All">All Students</option>
                    </select>
                </div> -->

            </div>
            <div class="modal-footer">
                <span id="loaderNew"></span>
                <button type="submit" onclick="downloadExcelSheetPuc();" id="downloadAllMarksNew"
                    class="btn btn-primary">Download</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="downloadScholarshipReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header exportModel">
                <h4 class="modal-title">Download Scholarship Reports</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form data-download_form="true" action="<?php echo base_url() ?>downloadScholarshipExcelReport" method="POST">

                <div class="col-lg-12 col-12">
                    <div class="form-group">
                        <label for="scholarship_type"> Scholarship Type<span
                            class="text-danger required_star">*</span></label>
                            <select id="scholarship_type" name="scholarship_type[]" data-live-search="true" class="form-control selectpicker" multiple
                                        autocomplete="off" required>
                                        <option value="">Select Scholarship Type</option>
                                        <option value="ALL">ALL</option>
                                        <?php if(!empty($scholarshipTypeInfo)){
                                            foreach($scholarshipTypeInfo as $scholarship){ ?>
                                                <option value="<?php echo $scholarship->scholarship_type ?>"><?php echo $scholarship->scholarship_type?></option>
                                        <?php  } } ?>

                                    </select>
                                </div>
                            </div>
                                    </div>
            <!-- Modal footer -->
            <div class="modal-footer">
            <input type="submit" class="btn btn-success" id="reportFormat" name="reportFormat" value="VIEW" onclick="selectOption('VIEW')" formtarget="_blank"/>
                <button id="downloadReportExcel" type="submit" class="btn btn-md btn-primary float-right"><i class="fa fa-download"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- The Modal -->
<div class="modal" id="downloadShortlistedMerit">
    <div class="modal-dialog ">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header bg-blue ">
                <h4 class="modal-title">Download Shortlisted List</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Select Preference</label>
                            <select class="form-control input-sm" id="stream_name_shortlisted" name="preference">
                                <?php if($by_first_preference != ""){ ?>
                                <option value="<?php echo $by_first_preference; ?>" selected><b>Sorted: <?php echo $by_first_preference; ?></b></option>
                                <option value="ALL" >ALL</option>
                                <option value="PCMB" >PCMB</option>
                                <option value="PCMC" >PCMC</option>
                                <option value="PCME" >PCME</option>
                                <option value="PCMS" >PCMS</option>
                                <option value="CEBA" >CEBA</option>
                                <option value="CSBA" >CSBA</option>
                                <option value="MEBA" >MEBA</option>
                                <option value="MSBA" >MSBA</option>
                                <option value="PEBA" >PEBA</option>
                                <option value="SEBA" >SEBA</option>
                                <option value="HEPS" >HEPS</option>
                                <?php } else  { ?>
                                <option value="ALL" >ALL</option>
                                <option value="PCMB" >PCMB</option>
                                <option value="PCMC" >PCMC</option>
                                <option value="PCME" >PCME</option>
                                <option value="CEBA" >CEBA</option>
                                <option value="PCMS" >PCMS</option>
                                <option value="CSBA" >CSBA</option>
                                <option value="MEBA" >MEBA</option>
                                <option value="MSBA" >MSBA</option>
                                <option value="PEBA" >PEBA</option>
                                <option value="SEBA" >SEBA</option>
                                <option value="HEPS" >HEPS</option>
                                <?php
                                } ?>
                            
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label>Filter SSLC Board Name</label>
                            <select class="form-control input-md required" id="by_board_name_shortlisted" name="by_board_name_shortlisted">
                            <option value="" selected>Filter By SSLC Board Name</option>
                            <option value="" >ALL</option>
                            <option value="KARNATAKA STATE BOARD">KARNATAKA STATE BOARD</option>
                                <option value="CBSE">CBSE</option>
                                <option value="ICSE">ICSE</option>
                                <option value="OTHER">OTHER</option>
                            </select>
                        </div> 
                    </div>
                    <div class="form-group col-md-6">
                                     <label>By Admission Year</label>

                                        <select class="form-control input-md" name="admission_year" id="admission_year">
                                         <option value="<?php echo CURRENT_YEAR?>"><?php echo CURRENT_YEAR?></option>
                                        <option value="2021">2021</option>
                                            
                                        </select>
                                       
                            </div>
                            <div class="form-group col-md-6">
                                     <label>By Integrated Batch</label>

                                        <select class="form-control input-md" name="integrated_batch" id="integrated_batch1">
                                        <option value="">ALL</option>
                                        <option value="JEE">JEE</option>
                                        <option value="NEET">NEET</option>
                                        <option value="CPT">CPT</option>
                                        <option value="CLAT">CLAT</option>
                                        <option value="NONE">NONE</option>
                                            
                                        </select>
                                       
                            </div>
                            <div class="form-group col-md-6">
                            <label>By Shortlist Number</label>
                            <select class="form-control input-sm" id="shortlist_number" name="shortlist_number" autocomplete="off">    
                            <option value="">Select</option>
                            <option value="" >ALL</option>
                             <option value="1" >I</option>
                            <option value="2" >II</option>
                             <option value="3" >III</option>
                            <option value="4" >IV</option>
                        </select>
                            </div>

                </div>
                <div class="row">
                    <div class="col-12">
                        <label>Percentage Filter</label>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <span class="form-group-addon"><b>FROM</b></span>
                            <input maxlength="5" onkeypress="return isNumberKey(event)"  id="percentage_from_downlaod"  type="text" class="form-control" name="percentage_from_downlaod" placeholder="Percentage From(%)">
                        </div>
                    </div>
                    
                    <div class="col-6">
                        <div class="form-group">
                            <span class="form-group-addon"><b>TO</b></span>
                            <input maxlength="5" onkeypress="return isNumberKey(event)"  id="percentage_to_downlaod" type="text" class="form-control" name="percentage_to_downlaod" placeholder="Percentage To(%)">
                        </div>
                    </div>
                </div>
            </div>
                
            <div class="modal-footer">
                <button style="float:right;" id="downloadShortlistedMeritList" type="button" class="btn btn-md btn-primary" ><i class="fa fa-download"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- end of the student report modal -->
<div class="modal fade" id="downloadStaffReport">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header exportModel">
                <h4 class="modal-title">Download Staff Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form action="<?php echo base_url() ?>downloadStaffExcelReport" method="POST">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label>Select Role</label>
                                <select class="form-control input-sm selectpicker" id="staff_role" name="staff_role" required>
                                     <option value="">Select Role</option>
                                     <option value="ALL">ALL</option>
                                            <?php   if(!empty($designation))
                                        {
                                            foreach ($designation as $rl)
                                            {
                                                ?>
                                                <option value="<?php echo $rl->roleId ?>" <?php if($rl->roleId == set_value('role')) {echo "selected=selected";} ?>><?php echo $rl->role ?></option>
                                                <?php
                                            }
                                        } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label>Select Department</label>
                                <select class="form-control input-sm selectpicker" id="staff_department" name="staff_department" required>
                                      <option value="">Select Department</option>
                                      <option value="ALL">ALL</option>
                                        <?php
                                            if(!empty($departments))
                                            {
                                                foreach ($departments as $rl)
                                                {
                                                    ?>

                                            <option value="<?php echo $rl->dept_id ?>" <?php if($rl->id == set_value('role')) {echo "selected=selected";} ?>><?php echo $rl->name; ?></option>
                                            <?php } } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <h5>Select Required Fields</h5>
                    <div class="row">
                        <div class="col-lg-4">
                            <input type="hidden" name="fields[]" class="staff_id" value="staff_id" checked /><span style="font-size: 18px;"> </span>

                            <input type="checkbox" class="staff_id disabled" value="" checked disabled /><span style="font-size: 18px;"> &nbsp;&nbsp;Staff Id</span>
                        </div>
                        <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="name" value="name" /><span style="font-size: 18px;"> &nbsp;&nbsp;Staff Name</span>
                        </div>
                           <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="dob" value="dob" /><span style="font-size: 18px;"> &nbsp;&nbsp;Date Of Birth</span>
                        </div>
                    </div>
                    <div class="row">
                          <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="doj" value="doj" /><span style="font-size: 18px;"> &nbsp;&nbsp;Date of Join</span>
                        </div>
                        <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="gender" value="gender" /><span style="font-size: 18px;"> &nbsp;&nbsp;Gender</span>
                        </div> 
                        <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="present_address" value="present_address" /><span style="font-size: 18px;"> &nbsp;&nbsp;Present Address </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="aadhar_no " value="aadhar_no" /><span style="font-size: 18px;"> &nbsp;&nbsp;Aadhar No.</span>
                        </div>
                        <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="voter_no" value="voter_no" /><span style="font-size: 18px;"> &nbsp;&nbsp;Voter No.</span>
                        </div>
                        <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="pan_no" value="pan_no" /><span style="font-size: 18px;"> &nbsp;&nbsp;Pan No.</span>
                        </div>
                    </div>
                   <div class="row">
                      <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="mobile" value="mobile" /><span style="font-size: 18px;"> &nbsp;&nbsp;Contact Number</span>
                      </div>
                      <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="email" value="email" /><span style="font-size: 18px;"> &nbsp;&nbsp;Email</span>
                     </div>
                      <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="role" value="role" /><span style="font-size: 18px;"> &nbsp;&nbsp;Role</span>
                        </div>
                    </div>
                    <div class="row">
                       
                        <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="department" value="department" /><span style="font-size: 18px;"> &nbsp;&nbsp;Department</span>
                        </div>
                        <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="blood_group" value="blood_group" /><span style="font-size: 18px;"> &nbsp;&nbsp;Blood Group</span>
                        </div>
                        <!-- <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="religion" value="religion" /><span style="font-size: 18px;"> &nbsp;&nbsp;Blood Group</span>
                        </div>
                        <div class="col-lg-4">
                            <input type="checkbox" name="fields[]" class="blood_group" value="blood_group" /><span style="font-size: 18px;"> &nbsp;&nbsp;Blood Group</span>
                        </div> -->
                    </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button id="downloadstaffReportExcel" type="submit" class="btn btn-md btn-primary float-right"><i
                        class="fa fa-download"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>




<!-- The Modal for  applicationApprovedReport-->
<div class="modal" id="downloadMunExternalReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">MUN External</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" id="munExternalreport" action="<?php echo base_url(); ?>downloadMunExternalReport">
                
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Type</label>
                            <select class="form-control input-md required" id="" name="register_type" required>
                                <!-- <option value="">By Type</option> -->
                                <option value="ALL">ALL</option>
                                <option value="PRIVATE Delegation">PRIVATE Delegation</option>
                                <option value="INSTITUTION Delegation">INSTITUTION Delegation</option>
                                <option value="INDIVIDUAL Delegation">INDIVIDUAL Delegation</option>
                            </select>
                        </div>

                        <div class="col-lg-12 mt-2">
                            <label>By Payment Status</label>
                            <select class="form-control input-md required" id="" name="status">
                                <!-- <option value="">ALL</option> -->
                                <option value="Paid">Paid</option>
                                <option value="Not_paid">Not Paid</option>
                            </select>
                        </div>


                        
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="munExternalreport"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
    <!-- The leave view Modal -->
    <div class="modal" id="downloadStaffAttendanceMonthlyReportPdf">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header ">
                <h4 class="modal-title">Staff Attendance Monthly Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding:0px;">
                <div class="card-body contents-body">
                
                    <form id="" method="POST" data-download_form="true" action="<?php echo base_url(); ?>downloadStaffAttendanceMonthlyReportPdfNew" target="_blank">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-12">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Select Month</label>
                                    <select class="form-control"  id="attendance_month" name="attendance_month" required>
                                        <option value="">Select Month</option>
                                        <option value='January'>January</option>
                                        <option value='February'>February</option>
                                        <option value='March'>March</option>
                                        <option value='April'>April</option>
                                        <option value='May'>May</option>
                                        <option value='June'>June</option>
                                        <option value='July'>July</option>
                                        <option value='August'>August</option>
                                        <option value='September'>September</option>
                                        <option value='October'>October</option>
                                        <option value='November'>November</option>
                                        <option value='December'>December</option>
                                    </select> 
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Select Year</label>
                                    <select class="form-control"  id="attendance_year" name="attendance_year" required>
                                    <?php if (!empty($attendanceYearInfo)) {  
                                            foreach ($attendanceYearInfo as $record) { ?>
                                                <option value="<?php echo $record->year; ?>">
                                                    <?php echo htmlspecialchars($record->year); ?>
                                                </option>
                                        <?php }  
                                        } ?>
                                </select> 
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group ">
                                    <label for="team_id">By Staff</label>
                                    <select class="form-control input-sm selectpicker" id="staffIdd"
                                        name="by_staff_id_report" data-live-search="true">
                                        <option value="ALL">ALL</option>
                                        <?php if(!empty($currentStaffInfo)) {
                                            foreach ($currentStaffInfo as $rl) {  ?>
                                        <option value="<?php echo $rl->staff_id ?>">
                                            <?php echo $rl->name ?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="row Department_Select">
                            <div class="col-lg-12">
                                <div class="form-group ">
                                    <label for="team_id">Department Sort</label>
                                    <select required name="department" id="departmentStaffId"
                                        class="form-control required selectpicker" data-live-search="true">
                                        <option value="">Select One Dept.</option>
                                        <option value="ALL">ALL</option>
                                        <?php //if(!empty($departments)) {
                                               // foreach ($departments as $rl) { ?>
                                                <option value="<?php //echo $rl->dept_id ?>"
                                            <?php //if($rl->id == set_value('role')) {echo "selected=selected";} ?>>
                                            <?php //echo $rl->name; ?></option>
                                        <?php //} } ?>
                                    </select>
                                </div>
                            </div>
                        </div> -->
                        <hr class="mt-1 mb-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                            <button type="submit" class="btn pull-right btn-primary text-white" id="downloadMonthlyReportStaff">Download</button>
                            <button type="button" class="btn btn-danger pull-left"  data-dismiss="modal">Close</button>
                            </div>
                        </div>
                                    </form>
                    <!-- Modal footer -->

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="transportFeePaidReport">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Transport Fee Paid Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" data-download_form="true"
                    action="<?php echo base_url(); ?>downloadTransportFeeInfoReport">

                    <div class="row">
                        <div class="col-lg-12">
                            <label for="term_name">Term</label>
                            <select class="form-control input-md required" name="term_name" id="term_name" required>
                                <option value="">Select Term</option>
                                <option value="I PUC">I PUC</option>
                                <option value="II PUC">II PUC</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <label for="preference">By Stream</label>
                            <select class="form-control input-md required" name="preference" required> >
                                <option value="">Select One Preference</option>
                                <option value="">ALL</option>
                                <?php if (!empty($streamInfo)) {
                                    foreach ($streamInfo as $stream) { ?>
                                        <option value="<?php echo $stream->stream_name; ?>">
                                            <?php echo $stream->stream_name; ?>
                                        </option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>

                    

                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <label for="month">Month</label>
                            <select class="form-control text-dark" name="month" id="month" required>
                                <option value="">Select Month</option>
                                <option value="ALL">All</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <label for="year">Year</label>
                            <select class="form-control input-md required" name="year">
                                <?php if (!empty($studentYearInfo)) {
                                    foreach ($studentYearInfo as $record) { ?>
                                        <option value="<?php echo $record->year; ?>">
                                            <?php echo $record->year; ?>
                                        </option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <label for="payment_type">By Payment Type</label>
                            <select class="form-control input-md required" name="payment_type">
                                <option value="ALL">ALL</option>
                                <option value="FULL_PAYMENT">Full Payment</option>
                                <option value="HALF_PAYMENT">Half Payment</option>
                                <option value="NOT_PAID">Not Paid</option>
                                <option value="PENDING">Overall Due</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <label for="student_type">By Student Type</label>
                            <select class="form-control input-md required" name="student_type" >
                                <option value="ALL">ALL</option>
                                <option value="ACTIVE">ACTIVE</option>
                                <option value="INACTIVE">INACTIVE</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer" style="padding:5px;">
                        <div class="row w-100 m-0">
                            <div class="col-lg-12 col-12 text-right">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" value="VIEW" name="reportFormat" formtarget="_blank" class="btn btn-primary">View</button>
                                <button type="submit" id="applicationRejectedReport" class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal" id="transportFeeDueReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Transport Fee Due Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" data-download_form="true"
                    action="<?php echo base_url(); ?>downloadTransportDueInfoReport">

                    <div class="row">
                        <div class="col-lg-12">
                            <label for="inputEmail4">Term</label>
                            <select class="form-control input-md required" name="term_name_select" required>
                                <option value="">Select Term</option>
                                <option value="I PUC">I PUC</option>
                                <option value="II PUC">II PUC</option>
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <label for="inputEmail4">Bus No.</label>
                            <select class="form-control text-dark"  name="bus_no" >
                                <option value="">Select Bus No.</option>
                                <?php if (!empty($busNoInfo)) {
                                    foreach ($busNoInfo as $busno) { ?>
                                        <option value="<?php echo $busno->name; ?>"><?php echo $busno->name ?></option>
                                <?php }
                                } ?>
                            </select>
                            
                        </div>

                       
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Select Year</label>
                                <select class="form-control" name="year" id="year" required>
                                     <?php if (!empty($studentYearInfo)) { ?>
                                    <?php foreach ($studentYearInfo as $record) { ?>
                                        <option value="<?php echo $record->year; ?>"><?php echo $record->year; ?></option>
                                    <?php } ?>
                                    <?php } ?>               
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                 <button type="submit" value="VIEW" name="reportFormat" formtarget="_blank" class="btn btn-primary">View</button>
                                <button type="submit" id="applicationRejectedReport"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal" id="transportOnlyFeeDue">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Transport Fee Due Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" data-download_form="true"
                    action="<?php echo base_url(); ?>downloadTransportOnlyDueInfoReport">

                    <div class="row">
                        <div class="col-lg-12">
                            <label for="inputEmail4">Term</label>
                            <select class="form-control input-md required" name="term_name_select" required>
                                <option value="">Select Term</option>
                                <option value="I PUC">I PUC</option>
                                <option value="II PUC">II PUC</option>
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <label for="inputEmail4">Bus No.</label>
                            <select class="form-control text-dark"  name="bus_no" >
                                <option value="">Select Bus No.</option>
                                <?php if (!empty($busNoInfo)) {
                                    foreach ($busNoInfo as $busno) { ?>
                                        <option value="<?php echo $busno->name; ?>"><?php echo $busno->name ?></option>
                                <?php }
                                } ?>
                            </select>                        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Select Year</label>
                                <select class="form-control" name="year" id="year" required>
                                     <?php if (!empty($studentYearInfo)) { ?>
                                    <?php foreach ($studentYearInfo as $record) { ?>
                                        <option value="<?php echo $record->year; ?>"><?php echo $record->year; ?></option>
                                    <?php } ?>
                                    <?php } ?>               
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" value="VIEW" name="reportFormat" formtarget="_blank" class="btn btn-primary">View</button>
                                <button type="submit" id="applicationRejectedReport"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Management Fee export modal -->
<div class="modal fade" id="datewiseTransportFeeReport">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Datewise Transport Fee</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-2">
                <form id="datewiseTransportFeeReport" action="<?php echo base_url() ?>downloadDatewiseTransportFeeReport" method="POST">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="role">Select Term</label>
                                <select class="form-control required" name="term_name" required>
                                    <option value="">Select Term</option>
                                    <option value="" selected>ALL</option>
                                    <option value="I PUC">I PUC</option>
                                    <option  value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                         <div class="col-6">
                            <div class="form-group">
                            <label>By Stream</label>
                            <select class="form-control input-sm"  name="stream_name" required>
                                <option value="">By Stream</option>
                                <option value="ALL">ALL</option>
                                <?php if(!empty($streamInfo)){
                                    foreach($streamInfo as $stream){ ?>
                                        <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                <?php } } ?>
                            </select>
                            </div>
                        </div>
                       
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date From</label>
                                <input type="text" class="form-control datepicker" name="date_from"
                                    placeholder="Select Date From" autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date To</label>
                                <input type="text" class="form-control datepicker"  name="date_to"
                                    placeholder="Select Date To" autocomplete="off" >
                            </div>
                        </div>
                         <div class="col-lg-6">
                            <div class="form-group">
                            <label>Year</label>
                            <select class="form-control input-md required" id="" name="year" required>
                            <option value="">Select Year</option>
                            <option value="2025" selected>2025-26</option>
                            <option value="2024">2024-25</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <label>By Payment Type</label>
                            <select class="form-control selectpicker input-md required" name="payment_type[]" multiple>
                                <option value="ALL">ALL</option>
                                <option value="CASH">CASH</option>
                                <option value="DD">DD</option>
                                <option value="UPI">UPI</option>
                                <option value="CARD">CARD</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label>By Settlement Status</label>
                            <select class="form-control selectpicker input-md required" name="settlement_type">
                                <option value="ALL">ALL</option>
                                <option value="SETTLED">SETTLED</option>
                                <option value="PENDING">PENDING</option>
                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success" id="reportFormat" name="reportFormat" value="VIEW" onclick="selectOption('VIEW')" formtarget="_blank"/>
                <button type="submit" name="reportFormat" value="download" class="btn btn-md btn-primary float-right"><i class="fa fa-download"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
const checkDownloadStatus = ()=>{
    const downloadIntervalID = setInterval(() => {
        if( $.cookie('isDownLoaded')==1 ){
            hideLoader();
            clearInterval(downloadIntervalID);
        }
    }, 1000);
}

var $downloadStaffSalaryReportMonthlyForm = $('#downloadStaffSalaryReportMonthlyForm');

$downloadStaffSalaryReportMonthlyForm.on('submit', function(ev) {
    ev.preventDefault();

    $.ajax({
        url: '<?php echo base_url(); ?>/downloadStaffSalaryReportMonthlyWise',
        type: 'POST',
        dataType: 'json',
        data: {
            salary_month: $("#salary_monthly").val(), 
            salary_year: $("#Montly_year").val(),
            salary_role: $("#staff_role_salary").val(),
        },
        success: function(data) {
            hideLoader();
            $("#downloadStaffSalaryMonthlyReportButton").prop('disabled', false);
            var $a = $("<a>");
            $a.attr("href", data.file);
            $("body").append($a);
            $a.attr("download", "STAFF_SALARY_REPORT " + $(
                    "#salary_monthly").val() + " " + $(
                    "#Montly_year").val() + ".xls");
            $a[0].click();
            $a.remove();
        },
        error: function(result) {
            hideLoader();
            $("#downloadStaffSalaryMonthlyReportButton").prop('disabled', false);
            alert("Server Error!!  Failed");
        },
        fail: (function(status) {
            hideLoader();
            $("#downloadStaffSalaryMonthlyReportButton").prop('disabled', false);
            alert("Internal Server Error!!  Failed");
        }),
        beforeSend: function(d) {
            showLoader();
            $("#downloadStaffSalaryMonthlyReportButton").prop('disabled', true);
        }
    });
});

/* Staff ESI Report */
var $staffEsiDeductionReportMonthlyForm = $('#staffEsiDeductionReportMonthlyForm');

$staffEsiDeductionReportMonthlyForm.on('submit', function(ev) {
    ev.preventDefault();

    var role = $("#esi_role").val();
    if($("#esi_year").val() == "" || $("#esi_monthly").val() == "" || role == null || role == ""){
        return;
    }
    showLoader();
    $("#downloadStaffEsiReportButton").prop('disabled', true);
    $.ajax({
        url: '<?php echo base_url(); ?>/downloadStaffEsiReport',
        type: 'POST',
        dataType: 'json',
        data: {
            esi_year: $("#esi_year").val(),
            esi_month: $("#esi_monthly").val(), 
            esi_role: $("#esi_role").val(),
        },
        success: function(data) {
            hideLoader();
            $("#downloadStaffEsiReportButton").prop('disabled', false);
            var $a = $("<a>");
            $a.attr("href", data.file);
            $("body").append($a);
            $a.attr("download", "STAFF_ESI_REPORT_" + $(
                    "#esi_monthly").val() + "_" + $(
                    "#esi_year").val() + ".xls");
            $a[0].click();
            $a.remove();
        },
        error: function(result) {
            hideLoader();
            $("#downloadStaffEsiReportButton").prop('disabled', false);
            alert("Server Error!!  Failed");
        },
        fail: (function(status) {
            hideLoader();
            $("#downloadStaffEsiReportButton").prop('disabled', false);
            alert("Internal Server Error!!  Failed");
        }),
        beforeSend: function(d) {
            showLoader();
            $("#downloadStaffEsiReportButton").prop('disabled', true);
        }
    });
});

var $staffSalarynewReportMonthlyForm = $('#staffSalarynewReportMonthlyForm');
$staffSalarynewReportMonthlyForm.on('submit', function(ev) {
    ev.preventDefault();
    if($("#salary_report_year").val() == "" || $("#salary_report_month").val() == "" || $("#salary_report_role").val() == ""){
        return;
    }
    showLoader();
    $("#downloadSalaryReportButton").prop('disabled', true);
    $.ajax({
        url: '<?php echo base_url(); ?>/downloadSalaryReport',
        type: 'POST',
        dataType: 'json',
        data: {
            esi_year: $("#salary_report_year").val(),
            esi_month: $("#salary_report_month").val(), 
            esi_role: $("#salary_report_role").val(),
        },
        success: function(data) {
            hideLoader();
            $("#downloadSalaryReportButton").prop('disabled', false);
            var $a = $("<a>");
            $a.attr("href", data.file);
            $("body").append($a);
            $a.attr("download", "PF_DEDUCTION_REPORT_" + $(
                    "#salary_report_month").val() + "_" + $(
                    "#salary_report_year").val() + ".xls");
            $a[0].click();
            $a.remove();
        },
        error: function(result) {
            hideLoader();
            $("#downloadSalaryReportButton").prop('disabled', false);
            alert("Server Error!!  Failed");
        },
        fail: (function(status) {
            hideLoader();
            $("#downloadSalaryReportButton").prop('disabled', false);
            alert("Internal Server Error!!  Failed");
        }),
        beforeSend: function(d) {
            showLoader();
            $("#downloadSalaryReportButton").prop('disabled', true);
        }
    });
});

//after load student details update student marks entered or not
function downloadExcelSheetPuc() { 
    var loader = '<img height="30" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';
    var right_mark = '<img src="<?php echo base_url(); ?>/assets/images/right_symbol.png"/>';
    var type = $('#typeSection :selected').val();
    var term_name = $('#termName :selected').val();
    var exam_type = $('#examType :selected').val();
    var stream_name_id = $('#stream_name_id :selected').val();
    var report_type = $('#report_type :selected').val();
    //  var section_name = $('#section_name :selected').val();
    $.ajax({
        url: '<?php echo base_url(); ?>/getInternalMarkSheet',
        type: 'POST',
        dataType: 'json',
        data: {
            type: type,
            term_name: term_name,
            exam_type: exam_type,
            stream_name_id : stream_name_id,
            report_type: report_type,
        },

        success: function(data) {
            $("#downloadAllMarksNew").prop('disabled', false);
            $("#loaderNew").html(right_mark + "<span style='color:green'><b>Downloaded</b></span>");
            // var studentObj = JSON.parse(data)
            var $a = $("<a>");
            $a.attr("href", data.file);
            $("body").append($a);
            $a.attr("download", "Examination_Result_file.xls");
            $a[0].click();
            $a.remove();
        },
        error: function(result) {
            $("#downloadAllMarksNew").prop('disabled', false);
            alert("Mark is not added selected section");
            $("#loaderNew").html(
                "<span style='color:red'>Selected class section not found in mark list!!</span>");
        },
        fail: (function(status) {
            $("#downloadAllMarksNew").prop('disabled', false);
            alert("Server Error!!  Failed");
        }),
        beforeSend: function(d) {
            $("#downloadAllMarksNew").prop('disabled', true);
            $("#loaderNew").html(loader);
        }
    });
}

function downloadLeaveReport() {
    var from_date = $('#fromDate_report').val();
    var to_date = $('#toDate_report').val();
    var leave_type = $('#leave_type_report').val();
    var applied_staff_id = $('#applied_staff_id_report').val();
    var leave_status = $('#leave_status_report').val();
    if (from_date == "") {
        alert("Please enter From Date!");
    } else if (to_date == "") {
        alert("Please enter To Date!");
    } else {
        $.ajax({
            url: '<?php echo base_url(); ?>/downloadStaffLeaveReport',
            type: 'POST',
            dataType: 'json',
            data: {
                from_date: from_date,
                to_date: to_date,
                leave_type: leave_type,
                applied_staff_id: applied_staff_id,
                leave_status: leave_status
            },

            success: function(data) {
                hideLoader();
                var $a = $("<a>");
                $a.attr("href", data.file);
                $("body").append($a);
                $a.attr("download", leave_type+"_Leave_Report_" + from_date + "_to_" + to_date +
                "_Report_file.xls");
                $a[0].click();
                $a.remove();
            },
            error: function(result) {
                hideLoader();
                alert("Search Error!!  Failed");
            },
            fail: (function(status) {
                hideLoader();
                alert("Server Error!!  Failed");
            }),
            beforeSend: function(d) {
                showLoader();
                // $("#loader").html(loader);
            }
        });
    }
}
 //after load student details update student marks entered or not
 function downloadExcelSheet(){
        var loader = '<img height="30" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';
        var right_mark = '<img src="<?php echo base_url(); ?>/assets/images/right_symbol.png"/>';
        var type = $('#type :selected').val();
        var streamName = $('#streamName :selected').val();
        var sectionName = $('#sectionName').val();
      //  var section_name = $('#section_name :selected').val();
        
   $.ajax({
           url: '<?php echo base_url(); ?>/getFullMarksOfStudent',
           type: 'POST',
           dataType:'json',
           data: {
            type : type,
            streamName : streamName,
            sectionName : sectionName,
           },

           success: function(data) {
            $("#downloadAllMarks").prop('disabled', false);
            $("#loader").html(right_mark + "<span style='color:green'><b>Downloded</b></span>");
              // var studentObj = JSON.parse(data)
              var $a = $("<a>");
                $a.attr("href",data.file);
                $("body").append($a);
                $a.attr("download","Annual_Result_I_PUC__file.xls");
                $a[0].click();
                $a.remove();
           },
           error: function(result)
               {
                $("#downloadAllMarks").prop('disabled', false);
                  alert("Mark is not added selected section");
                  $("#loader").html("<span style='color:red'>Selected class section not found in mark list!!</span>");
               },
               fail:(function(status) {
                $("#downloadAllMarks").prop('disabled', false);
                alert("Server Error!!  Failed");
               }),
               beforeSend:function(d){
                $("#downloadAllMarks").prop('disabled', true);
                $("#loader").html(loader);
               }
       });
}
jQuery(document).ready(function() {
    $("form").on('submit',()=>{
        $.cookie('isDownLoaded',0);
        checkDownloadStatus();
    });
    $('.pending_future_date').hide();
 //oncahnge active status
    $("#pendingStatus").on('change',function(){
        if(this.value == "Pending"){

            $('.pending_future_date').show();

        }else{

            $('.pending_future_date').hide();
            $('#pendingFutureDate').val('');  
        }
    });

      jQuery('#toDate_report, #fromDate_report, .datepicker, .dateSearch').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd-mm-yy"
    });

    jQuery('#date_select, #date_day, .dateSearch, #date_from, #date_to, #settle_date_bank, .bank_date_search, #date_from_fee, #date_to_fee, #brf_date_from_fee, #brf_date_to_fee').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });
       $('#downloadAttendanceReport').click(function(){
        var term_name = $('.termValue').val();
        var section_name = $('#section_name').val();
        var date_from = $('#date_from').val();
        var date_to = $('#date_to').val();
        var percentage_sort = $('#percentage_sort').val();
        if(section_name == ''){
            var section = 'ALL';
        }else{
            var section = section_name;
        }
        if(term_name == ""){
            alert("Term is Empty!!");
        // }else if(stream_name == ""){
        //     alert("Stream is Empty!!");
        }else{
            
            $.ajax({
                url: '<?php echo base_url(); ?>/downloadAbsentedStudentInfo',
                type: 'POST',
                dataType:'json',
                data: {
                    date_from : date_from,
                    date_to : date_to,
                    term_name : term_name,
                    section_name : section_name
                },
                success: function(data) {
                    $('#loader').html('');
                    $("#downloadAttendanceReport").prop('disabled', false);
                    // $("#downloadAttReport").hide();
                    var $a = $("<a>");
                    $a.attr("href",data.file);
                    $("body").append($a);
                    $a.attr("download",term_name+"_"+section+"_ATTENDANCE_REPORT.xls");
                    $a[0].click();
                    $a.remove();
                },
                error: function(result) { 
                    $('#loader').html('');
                    $("#downloadAttendanceReport").prop('disabled', false);
                    alert("Network Server Error!!  Failed");
                },
                fail:(function(status) {
                    $('#loader').html('');
                    $("#downloadAttendanceReport").prop('disabled', false);
                    alert("Server Error!!  Failed");
                }),
                beforeSend:function(d){
                    $('#loader').html(loader);
                    $("#downloadAttendanceReport").prop('disabled', true);
                }
            });
        }
    });


    
    $('#downloadMeritList').click(function() {

        //  var by_category = $("#by_category_name_download").val();
        var preference = $("#preference").val();
        var board_name = $("#by_board_name_download").val();
        var percentage_from = $("#percentage_from_downlaod").val();
        var percentage_to = $("#percentage_to_downlaod").val();
        var student_type = $("#student_type").val();
        if (preference == "") {
            alert("Sorry! Select atlest one preference");
        } else {
            $.ajax({
                url: '<?php echo base_url(); ?>/getAllMeritListByApproved',
                type: 'POST',
                dataType: 'json',
                data: {
                    student_type : student_type,
                    preference: preference,
                    board_name: board_name,
                    percentage_from: percentage_from,
                    percentage_to: percentage_to,
                    type: 'ALL',
                },

                success: function(data) {
                    $("#downloadMeritList").prop('disabled', false);
                    // $("#loader").html(right_mark + "<span style='color:green'><b>Downloded</b></span>");
                    // var studentObj = JSON.parse(data)
                    var $a = $("<a>");
                    $a.attr("href", data.file);
                    $("body").append($a);
                    $a.attr("download", preference + "_MERIT-LIST_2019.xls");
                    $a[0].click();
                    $a.remove();
                },
                error: function(result) {
                    alert("Server Error!!  Failed");
                    // $("#downloadAllMarks").prop('disabled', false);
                    //   alert("Mark is not added selected section");
                    //   $("#loader").html("<span style='color:red'>Selected class section not found in mark list!!</span>");
                },
                fail: (function(status) {
                    // $("#downloadAllMarks").prop('disabled', false);
                    alert("Server Error!!  Failed");
                }),
                beforeSend: function(d) {
                    //$("#loaderDiv").html(loader);
                    $("#downloadMeritList").prop('disabled', true);
                    // $("#loader").html(loader);
                }
            });
        }
    });

    
    $('#downloadShortlistedMeritList').click(function(){
        var preference = $("#stream_name_shortlisted").val();
        var board_name = $("#by_board_name_shortlisted").val();
        var percentage_from = $("#percentage_from_downlaod").val();
        var percentage_to = $("#percentage_to_downlaod").val();
        var admission_year = $("#admission_year").val();
        var shortlist_number = $("#shortlist_number").val();
        var integrated_batch = $("#integrated_batch1").val();



        if(preference == ""){
            alert("Sorry! Select atlest one preference");
        }else{
            $.ajax({
            url: '<?php echo base_url(); ?>/getAllShortlistedList',
            type: 'POST',
            dataType:'json',
            data: {
                preference : preference,
                board_name : board_name,
                percentage_from : percentage_from,
                percentage_to : percentage_to,
                admission_year : admission_year,
                shortlist_number:shortlist_number,
                integrated_batch:integrated_batch,
                type : 'NOT',
            },

            success: function(data) {
                $("#downloadMeritList").prop('disabled', false);
                // $("#loader").html(right_mark + "<span style='color:green'><b>Downloded</b></span>");
                // var studentObj = JSON.parse(data)
                var $a = $("<a>");
                    $a.attr("href",data.file);
                    $("body").append($a);
                    $a.attr("download",preference+"_SHORTLISTED-LIST_2021.xls");
                    $a[0].click();
                    $a.remove();
            },
            error: function(result)
                {
                    alert("Server Error!!  Failed");
                    // $("#downloadAllMarks").prop('disabled', false);
                    //   alert("Mark is not added selected section");
                    //   $("#loader").html("<span style='color:red'>Selected class section not found in mark list!!</span>");
                },
                fail:(function(status) {
                    // $("#downloadAllMarks").prop('disabled', false);
                    alert("Server Error!!  Failed");
                }),
                beforeSend:function(d){
                    //$("#loaderDiv").html(loader);
                    $("#downloadMeritList").prop('disabled', true);
                    // $("#loader").html(loader);
                }
        });
        }
 
      });


    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 
        && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    function toggleDepartmentSelect() {
        if ($('#staffIdd').val() === 'ALL') {
            $('.Department_Select').show();
            $('#departmentStaffId').attr('required', true);
        } else {
            $('.Department_Select').hide();
            $('#departmentStaffId').attr('required', false);
        }
    }

    // Initial check
    toggleDepartmentSelect();

    // Handle change event
    $('#staffIdd').on('change', function() {
        toggleDepartmentSelect();
    });


    /* Staff Salary Statement Excel Report */
    var $downloadStaffSalaryStatementReportExcelForm = $('#downloadStaffSalaryStatementReportExcelForm');

    $downloadStaffSalaryStatementReportExcelForm.on('submit', function(ev) {
        ev.preventDefault();
        
        var role = $("#statement_role_excel").val();
        if($("#statement_year_excel").val() == "" || $("#statement_month_excel").val() == "" || role == null || role == ""){
            return;
        }

        showLoader();
        $("#downloadStaffSalaryStatementExcelButton").prop('disabled', true);
        $.ajax({
            url: '<?php echo base_url(); ?>/downloadStaffSalaryStatementExcel',
            type: 'POST',
            dataType: 'json',
            data: {
                year: $("#statement_year_excel").val(),
                salary_monthly: $("#statement_month_excel").val(), 
                staff_role_salary: $("#statement_role_excel").val(),
            },
            success: function(data) {
                hideLoader();
                $("#downloadStaffSalaryStatementExcelButton").prop('disabled', false);
                var $a = $("<a>");
                $a.attr("href", data.file);
                $("body").append($a);
                $a.attr("download", "SALARY_STATEMENT_" + $(
                        "#statement_month_excel").val() + "_" + $(
                        "#statement_year_excel").val() + ".xls");
                $a[0].click();
                $a.remove();
            },
            error: function(result) {
                hideLoader();
                $("#downloadStaffSalaryStatementExcelButton").prop('disabled', false);
                alert("Server Error!!  Failed");
            },
            fail: (function(status) {
                hideLoader();
                $("#downloadStaffSalaryStatementExcelButton").prop('disabled', false);
                alert("Internal Server Error!!  Failed");
            }),
            beforeSend: function(d) {
                showLoader();
                $("#downloadStaffSalaryStatementExcelButton").prop('disabled', true);
            }
        });
    });

});
</script>