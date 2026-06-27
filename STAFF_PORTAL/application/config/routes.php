<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = "login";


/*********** USER DEFINED ROUTES *******************/

$route['loginMe'] = 'login/loginMe';
$route['dashboard'] = 'student';
$route['logout'] = 'user/logout';

$route['login-history'] = "user/loginHistoy";
$route['login-history/(:num)'] = "user/loginHistoy/$1";
$route['login-history/(:num)/(:num)'] = "user/loginHistoy/$1/$2";

//this route for forgot password
$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";

//this route for user registration
$route['userRegistration'] = 'registration/userRegistration';
$route['userRegisterDB'] = 'registration/userRegisterDB';

//this route for user profile
$route['profile'] = "student/profile";
$route['profile/(:any)'] = "student/profile/$1";
$route['changePassword'] = "student/changePassword";
$route['changePassword/(:any)'] = "student/changePassword/$1";

$route['sendFeedbackToManagement'] = "student/sendFeedbackToManagement";
$route['studentPerformance'] = "student/studentPerformance";
$route['viewTimeTable'] = "timetable/viewTimeTable";
$route['viewstudyMaterials'] = "studymaterial/viewstudyMaterials";
$route['viewbankDeposit'] = "bankDeposit/viewbankDeposit";
$route['download/(:any)'] = "studymaterial/download/$1";


//faculty routes
$route['loginFaculty'] = "login/loginFaculty";


$route['loginMe'] = "login/loginMe";
$route['generateOTP'] = "login/generateOTP";
$route['checkStaffOtp'] = 'login/checkStaffOtp';
$route['getOtp'] = 'login/getOtp';
$route['dashboard'] = 'user';
$route['staffDetails'] = 'staffs/staffDetails';
$route['staffDetails/(:any)'] = 'staffs/staffDetails/$1';
$route['addNewStaff'] = 'staffs/addNewStaff';
$route['addNewStaffToSjbhs'] = 'staffs/addNewStaffToSjbhs';

$route['viewStaffInfoById/(:any)'] = "staffs/viewStaffInfoById/$1";


$route['changePasswordAdmin/(:any)'] = "user/changePasswordAdmin/$1";

$route['deleteStaff'] = "staffs/deleteStaff";

$route['editStaff/(:any)'] = "staffs/editStaff/$1";
$route['updateStaff'] = "staffs/updateStaff";

$route['checkStaffDExists'] = "staffs/checkStaffDExists";
$route['get_staffs'] = "staffs/get_staffs";

//deleted staff
$route['deletedStaffDetails'] = "staffs/deletedStaffDetails";
$route['get_deleted_staffs'] = "staffs/get_deleted_staffs";
$route['restoreStaff'] = "staffs/restoreStaff";


//leave routes
$route['updateLeaveInfo'] = "staffs/updateLeaveInfo";
$route['staffLeaveInfo'] = "leave/staffLeaveInfo";
$route['viewApplyLeave'] = "leave/viewApplyLeave";

$route['applyLeaveByStaff'] = "leave/applyLeaveByStaff";
$route['get_applied_leave_info'] = "leave/get_applied_leave_info";

$route['getStaffLeaveInfoById'] = "leave/getStaffLeaveInfoById";
$route['updateStaffLeaveInfo'] = "leave/updateStaffLeaveInfo";
$route['deleteAppliedLeave'] = "leave/deleteAppliedLeave";
$route['editStaffLeaveInfo/(:any)'] = "leave/editStaffLeaveInfo/$1";
$route['updateStaffLeaveInfoByAdmin'] = "leave/updateStaffLeaveInfoByAdmin";
$route['updateResignationInfo'] = "staffs/updateResignationInfo";
$route['staffDetailsResigned'] = "staffs/staffDetailsResigned";
$route['get_staffs_resigned'] = "staffs/get_staffs_resigned";
$route['updateResignedDate'] = "staffs/updateResignedDate";

$route['staffDetailsRetired'] = "staffs/staffDetailsRetired";
$route['get_staffs_retired'] = "staffs/get_staffs_retired";


$route['get_single_staff_applied_leave_info'] = "leave/get_single_staff_applied_leave_info";

$route['viewAdminApplyLeavePage'] = "leave/viewAdminApplyLeavePage";
$route['applyStaffLeaveByAdmin'] = "leave/applyStaffLeaveByAdmin";

$route['updateLeaveInfo'] = "staffs/updateLeaveInfo";

$route['viewWorkAssigned'] = "leave/viewWorkAssigned";
$route['deleteWorkAssigned'] = "leave/deleteWorkAssigned";


//holiday routes

$route['viewHolidayList'] = "holiday/viewHolidayList";
$route['addNewHoliday'] = "holiday/addNewHoliday";
$route['editHoliday/(:any)'] = "holiday/editHoliday/$1";
$route['updateHoliday'] = "holiday/updateHoliday";
$route['deleteHoliday'] = "holiday/deleteHoliday";

$route['staffHomeWorkInfo']='apistaff/staffHomeWorkInfo';

//faculty settings routes
$route['viewSettings'] = "settings/viewSettings";

$route['addStaffRemarkName'] = 'settings/addStaffRemarkName';

$route['deleteStaffRemarkName'] = "settings/deleteStaffRemarkName"; 

//staff profile
$route['viewMyProfile'] = "user/viewMyProfile";
$route['viewMyProfile/(:any)'] = "user/viewMyProfile/$1";
$route['changePassword'] = "user/changePassword";
$route['updateProfileImage'] = "user/updateProfileImage";


$route['api/v1/simple'] = 'api/simple_api';
$route['api/v1/limit'] = 'api/api_limit';
$route['api/v1/key'] = 'api/api_key';


$route['api/v1/user/login'] = 'api/login';
$route['api/v1/user/view'] = 'api/view';

//attendance info staff
$route['getStaffAttendanceInfo'] = "attendance/getStaffAttendanceInfo";
$route['get_attendance'] = "attendance/get_attendance";

$route['get_my_attendance_info'] = "attendance/get_my_attendance_info";

$route['getMyAttendanceInfoPage'] = "attendance/getMyAttendanceInfoPage";
$route['downloadStaffAttendanceReport'] = "attendance/downloadStaffAttendanceReport";


//delete staff Attendance
$route['deleteStaffAttendance'] = "attendance/deleteStaffAttendance";

//add new staff Attendance
$route['addNewStaffAttendance'] = "attendance/addNewStaffAttendance";
$route['getStaffAttendanceInfoByDate_Staff_Id'] = "attendance/getStaffAttendanceInfoByDate_Staff_Id";
$route['updateStaffAttendance'] = "attendance/updateStaffAttendance";

//permisssion routes
$route['viewPermissions'] = "permission/viewPermissions";
$route['get_applied_permission_info'] = "permission/get_applied_permission_info";
$route['applyNewPermission'] = "permission/applyNewPermission";
$route['getPermissionInfoByRowId'] = "permission/getPermissionInfoByRowId";
$route['updateStaffPermissionInfo'] = "permission/updateStaffPermissionInfo";
$route['updatePermissionInfoByStaff'] = "permission/updatePermissionInfoByStaff";
$route['applyNewPermissionByAdmin'] = "permission/applyNewPermissionByAdmin";

//changes - 5/11/2019

//faculty settings routes
$route['addDepartment'] = "settings/addDepartment";
$route['deleteDepartment'] = "settings/deleteDepartment";
$route['addReligion'] = "settings/addReligion";
$route['deleteReligion'] = "settings/deleteReligion";
$route['adddeposittype'] = "settings/adddeposittype";
$route['deletedeposittype'] = "settings/deletedeposittype"; 
$route['adddepositaccount'] = "settings/adddepositaccount";
$route['deletedepositaccount'] = "settings/deletedepositaccount"; 
$route['addCaste'] = "settings/addCaste";
$route['deleteCaste'] = "settings/deleteCaste";
$route['addNationality'] = "settings/addNationality";
$route['deleteNationality'] = "settings/deleteNationality";
$route['addCategory'] = "settings/addCategory";
$route['deleteCategory'] = "settings/deleteCategory";
$route['addStream'] = "settings/addStream";
$route['deleteStream'] = "settings/deleteStream";
$route['getNewAdmittedStudentsImport'] = "settings/getNewAdmittedStudentsImport";
$route['addStudentMissingData'] = "settings/addStudentMissingData";
$route['getStaffDetailsForImport'] = "settings/getStaffDetailsForImport";
// routes for student 
$route['studentDetails'] = "students/studentDetails";
$route['studentDetails/(:any)'] = "students/studentDetails/$1";
$route['addNewStudent'] = "students/addNewStudent";
$route['get_students'] = "students/get_students";
$route['viewStudentInfoById/(:any)'] = "students/viewStudentInfoById/$1";
$route['editStudent/(:any)'] = "students/editStudent/$1";
$route['updateStudent'] = "students/updateStudent";
$route['updateStudentAcademicInfo'] = "students/updateStudentAcademicInfo";
$route['updateStudentFamilyInfo'] = "students/updateStudentFamilyInfo";
$route['deleteStudent'] = "students/deleteStudent";
$route['restoreStudent'] = "students/restoreStudent";
$route['getFamilyInfoByExcel'] = "students/getFamilyInfoByExcel";
$route['downloadStudentExcelReport'] = 'students/downloadStudentExcelReport';
$route['promoteStudent'] = "students/promoteStudent";

//alumin student
$route['studentAlumniInfo'] = "students/studentAlumniInfo";
$route['studentAlumniInfo/(:any)'] = "students/studentAlumniInfo/$1";

// student Tc
$route['getStudentById'] = 'students/getStudentById';
$route['addNewTcInfo'] = 'students/addNewTcInfo';
$route['getStudentAppliedForTc'] = "students/getStudentAppliedForTc";
$route['getStudentAppliedForTc/(:any)'] = "students/getStudentAppliedForTc/$1";
$route['getStudentsTcInfoById'] = "students/getStudentsTcInfoById";

$route['getAlumniStudentTc'] = "students/getAlumniStudentTc";
$route['getAlumniStudentTc/(:any)'] = "students/getAlumniStudentTc/$1";
$route['addAlumniStudentTCInfo'] = "students/addAlumniStudentTCInfo";
$route['getAlumniStudentsTcInfoById'] = "students/getAlumniStudentsTcInfoById";
$route['getAlumniStudentTcInfo'] = "students/getAlumniStudentTcInfo";

/*subjects routing */
$route['subjectDetails'] = "subjects/subjectDetails";
$route['get_subjects'] = 'subjects/get_subjects';
$route['addNewSubject'] = "subjects/addNewSubject";
$route['addNewSubjectToDB'] = "subjects/addNewSubjectToDB";
$route['editSubjectsById/(:any)'] = "subjects/editSubjectsById/$1";
$route['updateSubject'] = "subjects/updateSubject";
$route['checkSubjectCodeExists'] = 'subjects/checkSubjectCodeExists';
$route['deleteSubject'] = "subjects/deleteSubject";

// assign faculty subject and sections
$route['updateStaffSubjects'] = "staffs/updateStaffSubjects";
$route['updateStaffSection'] = "staffs/updateStaffSection";
$route['deleteStaffSubject'] = "staffs/deleteStaffSubject";
$route['deleteStaffSection'] = "staffs/deleteStaffSection";

// dashboard quick info
$route['facultyDashboard'] = "user/facultyDashboard";
$route['facultyDashboard/(:any)'] = "user/facultyDashboard/$1";
$route['getAllCurrentStudents'] = "students/getAllCurrentStudents";

// time table
$route['timeTableDetails'] = "timetable/timeTableDetails";
$route['addNewClass'] = "timetable/addNewClass";
$route['get_class'] = "timetable/get_class";
$route['addTimeTable/(:any)'] = "timetable/addTimeTable/$1";
$route['addTimeTableToDB'] = "timetable/addTimeTableToDB";

// class timings for time table
$route['addClassTimings'] = "settings/addClassTimings";
$route['deleteClassTimings'] = "settings/deleteClassTimings";

$route['getAssignedSubjects'] = "timetable/getAssignedSubjects";
$route['deleteClassInfo'] = "timetable/deleteClassInfo";

// add stream and section
$route['classStreamDetails'] = "timetable/classStreamDetails";
$route['classStreamDetails/(:any)'] = "timetable/classStreamDetails/$1";
$route['addSection'] = "timetable/addSection";
$route['deleteSection'] = "timetable/deleteSection";
$route['enableFeedback']="timeTable/enableFeedback";
$route['disableFeedback']="timeTable/disableFeedback";

$route['sendSMSToSingleNumber'] = "SMS/sendSMSToSingleNumber";
$route['sendSMSToStudentGroup'] = "SMS/sendSMSToStudentGroup";
$route['sendSMSToStaffGroup'] = "SMS/sendSMSToStaffGroup";
$route['sendSMSToNumberList'] = "SMS/sendSMSToNumberList"; 
$route['sendSMSByStudentList'] = "SMS/sendSMSByStudentList";

$route['get_sms_report'] = "SMS/get_sms_report";
$route['openSMSSentReport'] = "SMS/openSMSSentReport";
$route['get_sms_response'] = "SMS/get_sms_response";

$route['viewSMSPortal'] = "SMS/viewSMSPortal";
$route['sendBulkSMS'] = "SMS/sendBulkSMS";
$route['sendSMS_to_SingleNumber'] = "SMS/sendSMS_to_SingleNumber";
$route['sendSMSToStaff'] = "SMS/sendSMSToStaff";
$route['sendSMSAbsentedStudents'] = 'SMS/sendSMSAbsentedStudents';
$route['getSMSTemplateByID'] = "SMS/getSMSTemplateByID";
$route['getSMSResponse'] = "SMS/getSMSResponse";

// online class route
$route['viewOnlineClass'] = "studyMaterial/viewOnlineClass";
$route['viewOnlineClass/(:num)'] = "studyMaterial/viewOnlineClass/$1";
$route['addNewOnlineClass'] = "studyMaterial/addNewOnlineClass";
$route['editOnlineClass'] = "studyMaterial/editOnlineClass";
$route['editOnlineClass/(:any)'] = "studyMaterial/editOnlineClass/$1";
$route['updateOnlineClass'] = "studyMaterial/updateOnlineClass";
$route['deleteOnlineClass'] = "studyMaterial/deleteOnlineClass";

// youtube video
$route['viewYoutube'] = 'studyMaterial/viewYoutube';
$route['viewYoutube/(:num)'] = 'studyMaterial/viewYoutube/$1';
$route['addYoutubeToDB'] = "studyMaterial/addYoutubeToDB";
$route['editYoutube/(:any)'] = "studyMaterial/editYoutube/$1";
$route['updateYoutube'] = "studyMaterial/updateYoutube";
$route['deleteYoutube'] = "studyMaterial/deleteYoutube";
$route['getYoutubeInfoById'] = "studyMaterial/getYoutubeInfoById";

//study metrials update
$route['viewStudyMaterials'] = "studyMaterial/viewStudyMaterials";
$route['viewStudyMaterials/(:any)'] = "studyMaterial/viewStudyMaterials/$1";
$route['addNewStudyMaterials'] = "studyMaterial/addNewStudyMaterials";
$route['deleteStudyMaterials'] = "studyMaterial/deleteStudyMaterials";
$route['getStreamNameByTermName'] = "studyMaterial/getStreamNameByTermName";

//study metrials update
$route['viewBankDeposit'] = "bankDeposit/viewBankDeposit";
$route['viewBankDeposit/(:any)'] = "bankDeposit/viewBankDeposit/$1";
$route['addNewBankDeposit'] = "bankDeposit/addNewBankDeposit";
$route['deleteBankDeposit'] = "bankDeposit/deleteBankDeposit";
$route['getStreamNameByTermName'] = "bankDeposit/getStreamNameByTermName";



// time table
$route['timeTableDetails'] = "timetable/timeTableDetails";
$route['addNewClass'] = "timetable/addNewClass";
$route['get_class'] = "timetable/get_class";
$route['addTimeTable/(:any)'] = "timetable/addTimeTable/$1";
$route['addTimeTableToDB'] = "timetable/addTimeTableToDB";

// class timings for time table
$route['addClassTimings'] = "settings/addClassTimings";
$route['deleteClassTimings'] = "settings/deleteClassTimings";

$route['getAssignedSubjects'] = "timetable/getAssignedSubjects";
$route['deleteClassInfo'] = "timetable/deleteClassInfo";



$route['getStaffSubjectInfo'] = "timetable/getStaffSubjectInfo";
$route['addMultipleTimeTable'] = "timetable/addMultipleTimeTable";
$route['addMultipleTimeTableToDB'] = "timetable/addMultipleTimeTableToDB";
$route['getClassTimimgsByWeekId'] = "timetable/getClassTimimgsByWeekId";

// dashboard staff info
$route['getAllStaffInfo'] = "staffs/getAllStaffInfo";

// student suggestion
$route['suggestionListing'] = 'portalSuggestion/suggestionListing';
$route['suggestionListing/(:num)'] = 'portalSuggestion/suggestionListing/$1';
$route['updateManagementMsg'] = 'portalSuggestion/updateManagementMsg';
$route['getSuggestionById'] = 'portalSuggestion/getSuggestionById';
$route['getStudentMessageById'] = 'portalSuggestion/getStudentMessageById';
$route['enableSuggestion'] = 'portalSuggestion/enableSuggestion';
$route['disableSuggestion'] = 'portalSuggestion/disableSuggestion';
$route['sendMsgByStudentId'] = 'portalSuggestion/sendMsgByStudentId';

// student portal registration
$route['studentRegisterListing'] = 'portalRegistration/studentRegisterListing';
$route['studentRegisterListing/(:any)'] = 'portalRegistration/studentRegisterListing/$1';
$route['updateStudentPassword'] = 'portalRegistration/updateStudentPassword';
$route['deleteRegisteredStudent'] = 'portalRegistration/deleteRegisteredStudent';

// dashboard news feed 
$route['addNewsFeed'] = "user/addNewsFeed";
$route['deleteNewsFeed'] = "user/deleteNewsFeed";
$route['likeNewsFeed'] = "user/likeNewsFeed";
$route['disLikeNewsFeed'] = "user/disLikeNewsFeed";

// internal exam
$route['addInternalMark'] = "exam/addInternalMark";
$route['getStreamSectionByTerm'] = "exam/getStreamSectionByTerm";
$route['getStudentForInternalMark'] = "exam/getStudentForInternalMark";
$route['addStudentInternalMarkByStaff'] = "exam/addStudentInternalMarkByStaff";
$route['getInternalMarkSheet'] = "exam/getInternalMarkSheet";

// route for attendance
$route['getAttendanceDetails'] = "studentAttendance/getAttendanceDetails";
$route['getAttendanceDetails/(:any)'] = "studentAttendance/getAttendanceDetails/$1";
$route['getStudentInfoForAttendance'] = "studentAttendance/getStudentInfoForAttendance";
$route['addSingleSubjectAttendanceByStaff'] = "studentAttendance/addSingleSubjectAttendanceByStaff";

// route for time table shifting
$route['addTimetableDayShifting'] = "settings/addTimetableDayShifting";
$route['deleteDayShifting'] = "settings/deleteDayShifting";
$route['addFeesName'] = "settings/addFeesName";
$route['deleteFeeName'] = "settings/deleteFeeName";

// route for attendance absent list
$route['viewAttendanceInfo'] = "studentAttendance/viewAttendanceInfo";
$route['viewAttendanceInfo/(:any)'] = "studentAttendance/viewAttendanceInfo/$1";
$route['deleteStudentAttendance'] = "studentAttendance/deleteStudentAttendance";
$route['downloadStudentsAttendanceReport'] = "studentAttendance/downloadStudentsAttendanceReport";

// attendance class completed 
$route['viewClassCompletedInfo'] = "studentAttendance/viewClassCompletedInfo";
$route['viewClassCompletedInfo/(:any)'] = "studentAttendance/viewClassCompletedInfo/$1";
$route['deleteClassCompleted'] = "studentAttendance/deleteClassCompleted";

// student attendance report
$route['downloadAbsentedStudentInfo'] = "studentAttendance/downloadAbsentedStudentInfo";
$route['downloadClassCompletedReport'] = "studentAttendance/downloadClassCompletedReport";


// add bank account details
$route['viewAccount'] = "account/viewAccount";
$route['get_account'] = "account/get_account";
$route['addNewAccount'] = "account/addNewAccount";
$route['addAccountDetails'] = "account/addAccountDetails";
$route['editAccount/(:any)'] = "account/editAccount/$1";
$route['updateAccount'] = "account/updateAccount";
$route['deleteAccount'] = "account/deleteAccount";

// add admission fees structure
$route['viewFeeStructure'] = "feeStructure/viewFeeStructure";
$route['viewFeeStructure/(:any)'] = "feeStructure/viewFeeStructure/$1";
$route['addNewFeeStructure'] = "feeStructure/addNewFeeStructure";
$route['addFeeStructure'] = "feeStructure/addFeeStructure";
$route['editFeeStructure/(:any)'] = "feeStructure/editFeeStructure/$1";
$route['updateFeeStructure'] = "feeStructure/updateFeeStructure";
$route['deleteFeeStrtucture'] = "feeStructure/deleteFeeStrtucture";
$route['getStreamByTerm'] = "feeStructure/getStreamByTerm";

// fee concession
$route['viewFeeConcession'] = "fee/viewFeeConcession";
$route['viewFeeConcession/(:any)'] = "fee/viewFeeConcession/$1";
$route['getStudentByClassYear'] = "fee/getStudentByClassYear";
$route['getConcessionFeeLimit'] = "fee/getConcessionFeeLimit";
$route['addConcession'] = "fee/addConcession";
$route['editConcession/(:any)'] = "fee/editConcession/$1";
$route['updateConcession'] = "fee/updateConcession";
$route['approveConcession'] = "fee/approveConcession";
$route['rejectConcession'] = "fee/rejectConcession";
$route['deleteConcession'] = "fee/deleteConcession";


//fee Installment Info
$route['feeInstallmentListing'] = "fee/feeInstallmentListing";
$route['feeInstallmentListing/(:any)'] = "fee/feeInstallmentListing/$1";
$route['addFeeInstallment'] = "fee/addFeeInstallment";
$route['editFeeInstallment/(:any)'] = "fee/editFeeInstallment/$1";
$route['updateFeeInstallment'] = "fee/updateFeeInstallment";
$route['deleteFeeInstallment'] = "fee/deleteFeeInstallment";

$route['feePayNow'] = "fee/feePayNow";
$route['addFeePaymentInfo'] = "fee/addFeePaymentInfo";
$route['getStudentFeePaymentInfo'] = "fee/getStudentFeePaymentInfo";
$route['govtFeePaymentReceiptPrint/(:any)'] = "fee/govtFeePaymentReceiptPrint/$1";
$route['nongovtFeePaymentReceiptPrint/(:any)'] = "fee/nongovtFeePaymentReceiptPrint/$1";
$route['managementFeePaymentReceiptPrint/(:any)'] = "fee/managementFeePaymentReceiptPrint/$1";
$route['updateFeeReceipt'] = "fee/updateFeeReceipt";
$route['updateDeptFeeReceipt'] = "fee/updateDeptFeeReceipt";
$route['refundFeeReceipt'] = "fee/refundFeeReceipt";
$route['refundReceiptPrint/(:any)'] = "fee/refundReceiptPrint/$1";
$route['deleteRefund'] = 'fee/deleteRefund';

$route['addMiscellneousBankSettlementSubmit'] = "fee/addMiscellneousBankSettlementSubmit";


$route['addMiscellaneousType'] = "settings/addMiscellaneousType";
$route['deleteMiscellaneousType'] = "settings/deleteMiscellaneousType";

//Miscellaneous Fee

$route['miscellaneousFeeListing'] = "fee/miscellaneousFeeListing";
$route['miscellaneousFeeListing/(:any)'] = "fee/miscellaneousFeeListing/$1";
$route['addMiscellaneousPayment'] = "fee/addMiscellaneousPayment";
$route['getMiscellaneousFeeAmount'] = "fee/getMiscellaneousFeeAmount";
$route['getMiscellaneousFeeInfo'] = "fee/getMiscellaneousFeeInfo";
$route['miscellaneousReceiptPrint/(:any)'] = "fee/miscellaneousReceiptPrint/$1";
$route['deleteMiscellaneousFee'] = "fee/deleteMiscellaneousFee";
$route['updateMiscFeeReceipt'] = 'fee/updateMiscFeeReceipt';

//  overall report
$route['downloadMiscellaneousFeePaidReport'] = "reports/downloadMiscellaneousFeePaidReport";


//get online fee paid info
$route['onlineFeePaidInfo'] = "fee/onlineFeePaidInfo";
$route['onlineFeePaidInfo/(:any)'] = "fee/onlineFeePaidInfo/$1";
// bank settlement
$route['addBankSettlementSubmit'] = "account/addBankSettlementSubmit";

//fee report
$route['download_II_PUC_StudentFeePaidReport'] = "fee/download_II_PUC_StudentFeePaidReport";

// this routes for Push Notification
$route['pushNotification'] = 'push_Notification';
$route['push_notification/sendNotification'] = "push_Notification/validateForm"; 
$route['push_notification/blocked_user'] = 'push_Notification/addBlockedUser';
$route['push_notification/register_token'] = 'push_Notification/addFcmToken';
$route['staffNotifications'] = 'push_Notification/getStaffNotifications';
// $route['studentNotifications'] = 'push_Notification/getStudentNotifications';
$route['studentNotifications'] = "push_Notification/studentNotifications";
$route['studentNotifications/(:any)'] = "push_Notification/studentNotifications/$1";
$route['deleteStudentNotification'] = 'push_Notification/deleteStudentNotification';

$route['sendStaffIndividualNotification'] = 'push_Notification/sendStaffIndividualNotification';


//Admission Enquiry
$route['enquiryListing'] = "enquiry/enquiryListing";
$route['enquiryListing/(:any)'] = "enquiry/enquiryListing/$1";
$route['deleteEnquiry'] = "enquiry/deleteEnquiry";
$route['addNewAdmission'] = "enquiry/addNewAdmission";
$route['admissionEnquiryDetails'] = "enquiry/admissionEnquiryDetails";
$route['addAdmissionInfoToDB'] = "enquiry/addAdmissionInfoToDB";
$route['editAdmission/(:any)'] = "enquiry/editAdmission/$1";
$route['updateAdmission'] = "enquiry/updateAdmission";
$route['checkMobileNumberOrEmailExists'] = "enquiry/checkMobileNumberOrEmailExists";



// reports
$route['reportDashboard'] = "reports/reportDashboard";
$route['downloadAdmissionEnquiryExcelReport'] = "reports/downloadAdmissionEnquiryExcelReport";
$route['download_fee_structure_excel'] = "reports/download_fee_structure_excel";
$route['downloadApplicationStack'] = "reports/downloadApplicationStack";
$route['downloadAdmissionRegisteredStudent'] = "reports/downloadAdmissionRegisteredStudent";
$route['downloadFeePaidReport'] = "reports/downloadFeePaidReport";

$route['downloadStaffLeaveReport'] = 'reports/downloadStaffLeaveReport';
$route['downloadStaffLeavePendingReport'] = "reports/downloadStaffLeavePendingReport";

$route['shorlitedStudentPDF_PRINT'] = "reports/shorlitedStudentPDF_PRINT";


$route['downloadAdmittedStudentInfo'] = "reports/downloadAdmittedStudentInfo";

$route['downloadDayWiseFeeReport'] = "reports/downloadDayWiseFeeReport";
$route['downloadBriefFeeReport'] = "reports/downloadBriefFeeReport";
$route['downloadDateWiseFeeReport'] = "reports/downloadDateWiseFeeReport";
$route['downloadByDateReport'] = "reports/downloadByDateReport";
$route['downloadFeePendingReport'] = "reports/downloadFeePendingReport";
$route['downloadGeneralReceiptsReport'] = "reports/downloadGeneralReceiptsReport";

//student Election routes
$route['electionDetails'] = "election/electionDetails";
$route['electionDetails/(:any)'] = "election/electionDetails/$1";
$route['addNewStudentElection'] = "election/addNewStudentElection";
$route['editStudentElection/(:any)'] = "election/editStudentElection/$1";
$route['updateStudentElection'] = "election/updateStudentElection";
$route['deleteStudentElection'] = "election/deleteStudentElection";

// election settings
$route['addPost'] = "settings/addPost";
$route['deletePost'] = "settings/deletePost";

// sms
$route['sendSingleSMS'] = 'sMS/sendSingleSMS';


//Admission 2021
$route['admissionDashboard'] = "application/admissionDashboard";
$route['getAllApplicationInfo'] = "application/getAllApplicationInfo";
$route['getAllApplicationInfo/(:any)'] = "application/getAllApplicationInfo/$1";
$route['updateStudentAdmissionDocument'] = "application/updateStudentAdmissionDocument";
$route['updateSchoolData'] = "application/updateSchoolData";
$route['updateStudentPersonalData'] = "application/updateStudentPersonalData";
$route['updateStudentPersonalData/(:any)'] = "application/updateStudentPersonalData/$1";
$route['updateStudentCombination'] = "application/updateStudentCombination";
$route['getStudentInfoByApplicationNumber'] = "application/getStudentInfoByApplicationNumber";

$route['admissionGrievance'] = "application/admissionGrievance";
$route['admissionGrievance/(:any)'] = "application/admissionGrievance/$1";

$route['sendSMSForNewAdm'] = "application/sendSMSForNewAdm";



// new admission routes 
$route['getAdmissionPaymentPeningApplication'] = "application/getAdmissionPaymentPeningApplication";
$route['getAdmissionPaymentPeningApplication/(:any)'] = "application/getAdmissionPaymentPeningApplication/$1";
$route['applicationPaymentComplete'] = "application/applicationPaymentComplete";

$route['newAdmission'] = "application/newAdmission";
$route['newAdmission/(:any)'] = "application/newAdmission/$1";
$route['getRejectedApplicationInfo'] = "application/getRejectedApplicationInfo";
$route['getRejectedApplicationInfo/(:any)'] = "application/getRejectedApplicationInfo/$1";

// shortlisted
$route['getShortlistedApplication'] = "application/getShortlistedApplication";
$route['getShortlistedApplication/(:any)'] = "application/getShortlistedApplication/$1";
$route['updateShortListedStudents'] = 'application/updateShortListedStudents';
$route['updateShortListedStudents/(:any)'] = 'application/updateShortListedStudents/$1';

// edit single admission application 
$route['editSingleStudentApplications/(:any)'] = "application/editSingleStudentApplications/$1";

// interview status
$route['updatedInterviewCompletedStudents'] = 'application/updatedInterviewCompletedStudents';
// $route['updatedInterviewCompletedStudents/(:any)'] = "application/updatedInterviewCompletedStudents/$1";

// admission registered students
$route['getAdmissionRegisteredStudent'] = "application/getAdmissionRegisteredStudent";
$route['getAdmissionRegisteredStudent/(:any)'] = "application/getAdmissionRegisteredStudent/$1";

//paytm_payment
$route['payTmPaymentProcess'] = "fee/payTmPaymentProcess";
$route['payTmPaymentResponse'] = "fee/payTmPaymentResponse";

// add fee type
$route['addFeeType'] = "settings/addFeeType";
$route['deleteFeeType'] = "settings/deleteFeeType";

$route['getStreamNamesByProgram'] = "application/getStreamNamesByProgram";
$route['updateApplicationStatus'] = "application/updateApplicationStatus"; 
$route['viewSingleStudentAppliactions/(:any)'] = "application/viewSingleStudentAppliactions/$1";
$route['viewPrintApplication/(:any)'] = "application/viewPrintApplication/$1";
$route['getCasteInfoById'] = "application/getCasteInfoById";  
$route['getAllApplicationFeePaidInfo'] = "application/getAllApplicationFeePaidInfo"; 
$route['getAllApplicationFeePaidInfo/(:any)'] = "application/getAllApplicationFeePaidInfo/$1";


//leave routes
$route['updateLeaveInfo'] = "staffs/updateLeaveInfo";
$route['staffLeaveInfo'] = "leave/staffLeaveInfo";
$route['viewApplyLeave'] = "leave/viewApplyLeave";

$route['applyLeaveByStaff'] = "leave/applyLeaveByStaff";
$route['get_applied_leave_info'] = "leave/get_applied_leave_info";

$route['getStaffLeaveInfoById'] = "leave/getStaffLeaveInfoById";
$route['updateStaffLeaveInfo'] = "leave/updateStaffLeaveInfo";
$route['deleteAppliedLeave'] = "leave/deleteAppliedLeave";
$route['editStaffLeaveInfo/(:any)'] = "leave/editStaffLeaveInfo/$1";
$route['updateStaffLeaveInfoByAdmin'] = "leave/updateStaffLeaveInfoByAdmin";

$route['get_single_staff_applied_leave_info'] = "leave/get_single_staff_applied_leave_info";

$route['viewAdminApplyLeavePage'] = "leave/viewAdminApplyLeavePage";
$route['applyStaffLeaveByAdmin'] = "leave/applyStaffLeaveByAdmin";
//ajax call leave info 
$route['getStaffLeaveInfoByStaffId'] = "leave/getStaffLeaveInfoByStaffId";

$route['calendar'] = "calendar";
$route['api/calendar/addEvent'] = "calendar/addEvent";
$route['api/calendar/getCalendarEvents'] = "calendar/getCalendarEvents";
$route['api/calendar/deleteEvent'] = "calendar/deleteEvent";
$route['api/calendar/updateEvent'] = "calendar/updateEvent";


// management fees
$route['viewManagementFeeInfo'] = "fee/viewManagementFeeInfo";
$route['viewManagementFeeInfo/(:any)'] = "fee/viewManagementFeeInfo/$1";
$route['addManagementFeeInfo'] = "fee/addManagementFeeInfo"; 
$route['editMngtFee/(:any)'] = "fee/editMngtFee/$1";
$route['updateMngtFee'] = "fee/updateMngtFee"; 
$route['deleteMngtFee'] = "fee/deleteMngtFee";
$route['printMngtFeeReceipt/(:any)'] = "fee/printMngtFeeReceipt/$1";

//get student info for fee payment
$route['getStudentInfoByTerm'] = "fee/getStudentInfoByTerm";


$route['dayWiseStructureFeePayment'] = "reports/dayWiseStructureFeePayment";

//this routes for ChatBot
$route['chatBot'] = "chatbot";
$route['chatBot/chat'] = "chatbot/chat";
$route['chatBot/GET_NOTIFICATIONS'] = "chatbot/getNotifications";
$route['chatBot/GET_HOLIDAYS'] = "chatbot/getHolidays";
$route['chatBot/GET_EXAMS'] = "chatbot/getExams";



$route['getAllFeePaymentInfo'] = "fee/getAllFeePaymentInfo";

$route['getAllFeePaymentInfo/(:any)'] = "fee/getAllFeePaymentInfo/$1";



// download consolidated mark report - assignment
$route['downloadExamMarkSheet'] = "reports/downloadExamMarkSheet";

$route['processTheFeePayment'] = "fee/processTheFeePayment";


// download consolidated mark report - assignment
$route['downloadAssignmentExamMarkReport'] = "reports/downloadAssignmentExamMarkReport";

// study certificate
$route['generateStudyCertificate'] = "students/generateStudyCertificate";

// conduct certificate
$route['generateConductCertificate'] = "students/generateConductCertificate";



  
// route for website announcements
$route['announcementListing'] = 'websiteAnnouncement/announcementListing';
$route['announcementListing/(:num)'] = "websiteAnnouncement/announcementListing/$1";
$route['addNewMessage'] = 'websiteAnnouncement/addNewMessage';
$route['addNewMessageToDb'] = 'websiteAnnouncement/addNewMessageToDb';
$route['editMessage/(:num)'] = "websiteAnnouncement/editMessage/$1";
$route['updateMessage'] = 'websiteAnnouncement/updateMessage';
$route['disableAnnouncement'] = 'websiteAnnouncement/disableAnnouncement';
$route['enableAnnouncement'] = 'websiteAnnouncement/enableAnnouncement';

// route for website Event List 
$route['eventListing'] = 'websiteEvent/eventListing';
$route['eventListing/(:num)'] = "websiteEvent/eventListing/$1";
$route['addNewEvent'] = 'websiteEvent/addNewEvent';
$route['addNewEventToDb'] = 'websiteEvent/addNewEventToDb';
$route['editEvent/(:num)'] = "websiteEvent/editEvent/$1";
$route['updateEvent'] = 'websiteEvent/updateEvent';
$route['enableEvent'] = 'websiteEvent/enableEvent';
$route['disableEvent'] = 'websiteEvent/disableEvent';

// route for website News & Event
$route['newsListing'] = 'websiteNews/newsListing';
$route['newsListing/(:num)'] = "websiteNews/newsListing/$1";
$route['addNews'] = 'websiteNews/addNews';
$route['addNewToDb'] = 'websiteNews/addNewToDb';
$route['editNews/(:num)'] = "websiteNews/editNews/$1";
$route['updateNews'] = 'websiteNews/updateNews';
$route['disableNews'] = 'websiteNews/disableNews';
$route['enableNews'] = 'websiteNews/enableNews';

// route for website Testimonials
$route['feedbackListing'] = 'websiteTestimonials/feedbackListing';
$route['feedbackListing/(:num)'] = "websiteTestimonials/feedbackListing/$1";
$route['addTestimonials'] = 'websiteTestimonials/addTestimonials';
$route['addTestimonialsToDb'] = 'websiteTestimonials/addTestimonialsToDb';
$route['editTestimonials/(:num)'] = "websiteTestimonials/editTestimonials/$1";
$route['updateTestimonials'] = 'websiteTestimonials/updateTestimonials';
$route['disableTestimonial'] = 'websiteTestimonials/disableTestimonial';
$route['enableTestimonial'] = 'websiteTestimonials/enableTestimonial';


// admission report
$route['getAllMeritListByApproved'] = "reports/getAllMeritListByApproved";
$route['getAllMeritList'] = "reports/getAllMeritList";


$route['getAllShortlistedList'] = "reports/getAllShortlistedList";

// staff report
$route['downloadStaffExcelReport'] = "reports/downloadStaffExcelReport";


// I PUC 2021
$route['newAdm_feePayNow'] = "fee/newAdm_feePayNow";

$route['getNewAdm_StudentFeePaymentInfo'] = "fee/getNewAdm_StudentFeePaymentInfo";



$route['newAdm_AddFeePaymentInfo'] = "fee/newAdm_AddFeePaymentInfo";


$route['getAllFeePaymentInfoNewAdm'] = "fee/getAllFeePaymentInfoNewAdm";
$route['getAllFeePaymentInfoNewAdm/(:any)'] = "fee/getAllFeePaymentInfoNewAdm/$1";



$route['addBankSettlementSubmitNewAdm'] = "fee/addBankSettlementSubmitNewAdm";

$route['feePaymentReceiptPrintNewAdmIPUC/(:any)'] = "fee/feePaymentReceiptPrintNewAdmIPUC/$1";



// print marks card assignment exam 
$route['getMarkCardToPrint/(:any)'] = "students/getMarkCardToPrint/$1";
$route['getMarkCardToPrint'] = "students/getMarkCardToPrint";

//print annual report
$route['getAnnualMarkCardToPrint/(:any)'] = "students/getAnnualMarkCardToPrint/$1";
$route['getAnnualMarkCardToPrint'] = "students/getAnnualMarkCardToPrint";
$route['getAnnualMarkCardToPrint2022/(:any)'] = "students/getAnnualMarkCardToPrint2022/$1";
$route['getAnnualMarkCardToPrint2022'] = "students/getAnnualMarkCardToPrint2022";

// Job portal routes
// $route['jobPortal'] = "jobPortal";
$route['jobPortalListing'] = "jobPortal/jobPortalListing";
$route['jobPortalListing/(:any)'] = "jobPortal/jobPortalListing/$1"; 
$route['jobPortal/viewApplicant'] = "jobPortal/viewApplicant";
$route['jobPortal/viewApplicant/$1'] = "jobPortal/viewApplicant/$1";
$route['jobPortal/deleteApplicant'] = "jobPortal/deleteApplicant";

// staff subject attendance
$route['getAssignedSubjectAttendance'] = "studentAttendance/getAssignedSubjectAttendance";

// add student batch for lab
$route['updateStudentBatch'] = "students/updateStudentBatch";


// print marks card assignment exam 
$route['generateUnitTestExamReportCard/(:any)'] = "students/generateUnitTestExamReportCard/$1";
$route['generateUnitTestExamReportCard'] = "students/generateUnitTestExamReportCard";

// readmission & new admission order id process
$route['reAdmissionOrderIdProcess'] = "fee/reAdmissionOrderIdProcess";
$route['newAdmissionOrderIdProcess'] = "fee/newAdmissionOrderIdProcess";

// mun event info
$route['getMunEventInfo/(:any)'] = "mun/getMunEventInfo/$1";
$route['getMunEventInfo'] = "mun/getMunEventInfo";
$route['deleteEvent'] = "mun/deleteEvent";
$route['viewEventParticipantInfo/(:any)'] = "mun/viewEventParticipantInfo/$1";

$route['getInternalRegistration'] = "mun/getInternalRegistration";
$route['getInternalRegistration/(:any)'] = "mun/getInternalRegistration/$1";
$route['deleteInternalEvent'] = "mun/deleteInternalEvent";

// MUN REPORT
$route['downloadMunExternalReport'] = "reports/downloadMunExternalReport";
$route['downloadMunInternalReport'] = "reports/downloadMunInternalReport";

//late comer info
$route['viewLatecomerInfo'] = "latecomer/viewLatecomerInfo";
$route['viewLatecomerInfo/(:any)'] = "latecomer/viewLatecomerInfo/$1";
$route['deleteLatecomer'] = "latecomer/deleteLatecomer";
$route['latecomerInfoDownload'] = "latecomer/latecomerInfoDownload";
//single student latecomer info
$route['getLatecomerByStudentId'] = "latecomer/getLatecomerByStudentId";
$route['confirmLatecomerInfo'] = "latecomer/confirmLatecomerInfo";


// exam analytics
$route['viewExamAnalyticalBySection'] = "analytics/viewExamAnalyticalBySection";
$route['getSectionPeformanceAnalytics'] = "analytics/getSectionPeformanceAnalytics";
$route['getSectionPeformanceAnalyticsPdf'] = "analytics/getSectionPeformanceAnalyticsPdf";

// verify student attendance
$route['verifyStudentAttendance'] = "studentAttendance/verifyStudentAttendance";
$route['getStudentInfoToVerifyAttendance'] = "studentAttendance/getStudentInfoToVerifyAttendance";
$route['confirmStudentVerifyAttendance'] = "studentAttendance/confirmStudentVerifyAttendance";

//report for 2020 fee pending 
$route['download_fee_structure_excel_2020'] = "reports/download_fee_structure_excel_2020";

//student feedback enabled
$route['getFeedbackStudentInfo'] = "feedback/getFeedbackStudentInfo";
$route['getFeedbackStudentInfo/(:any)'] = "feedback/getFeedbackStudentInfo/$1";
$route['addStudentForFeedback'] = "feedback/addStudentForFeedback";
$route['deleteStudentEnabled'] = "feedback/deleteStudentEnabled";

$route['viewStudentFeedbackByStaff/(:any)'] = 'feedback/viewStudentFeedbackByStaff/$1';
$route['pintStudentFeedbackResponse_21/(:any)'] = "feedback/pintStudentFeedbackResponse_21/$1";
$route['addCommentToFeedbackByPrincipal/(:any)'] = "feedback/addCommentToFeedbackByPrincipal/$1";
$route['pintStudentFeedbackResponse_22/(:any)'] = "feedback/pintStudentFeedbackResponse_22/$1";
$route['pintStudentFeedbackResponse_23/(:any)'] = "feedback/pintStudentFeedbackResponse_23/$1";

// route for printing Hall ticket
$route['getFirstYearStudentHallTicket'] = 'students/getFirstYearStudentHallTicket';
$route['getSecondYearStudentHallTicket'] = 'students/getSecondYearStudentHallTicket';

// assign multiple student
$route['addMultipleStudentForFeedback/(:any)'] = "feedback/addMultipleStudentForFeedback/$1";
$route['addMultipleStudentForFeedback'] = "feedback/addMultipleStudentForFeedback";
$route['deleteMultipleStudent/(:any)'] = "feedback/deleteMultipleStudent/$1";
$route['deleteMultipleStudent'] = "feedback/deleteMultipleStudent";

//hall ticket details
$route['examListing'] = 'exam/examListing';
$route['examListing/(:any)'] = 'exam/examListing/$1';
$route['addExam'] = 'exam/addExam';
$route['deleteExam'] = 'exam/deleteExam';
$route['inactiveExam'] = 'exam/inactiveExam';
$route['activeExam'] = 'exam/activeExam';

//Annual I PU Marks sheet
$route['getFullMarksOfStudent'] = 'reports/getFullMarksOfStudent';

$route['generateExcellenciaCertificate'] = "students/generateExcellenciaCertificate";


//new fee
$route['newFeePayNow'] = "fee/newFeePayNow";
$route['getNewStudentFeePaymentInfo'] = "fee/getNewStudentFeePaymentInfo";
$route['newAddFeePaymentInfo'] = "fee/newAddFeePaymentInfo";
$route['payNowRedirect/(:any)'] = "fee/payNowRedirect/$1";

//Bio Data
$route['getStudentBiodata'] = "students/getStudentBiodata";

$route['addAllApprovedStudent'] = "settings/addAllApprovedStudent";
$route['createExamRowIdUpdate'] = "settings/createExamRowIdUpdate";

// routes for Stock Management
$route['viewStockSettings'] = "stock/viewStockSettings";
$route['addStockName'] = "stock/addStockName";
$route['deleteStockName'] = "stock/deleteStockName";
$route['addStockType'] = "stock/addStockType";
$route['deleteStockType'] = "stock/deleteStockType";
$route['addStockDepartment'] = "stock/addStockDepartment";
$route['deleteStockDepartment'] = "stock/deleteStockDepartment";
$route['addStockProduct'] = "stock/addStockProduct";
$route['deleteStockProduct'] = "stock/deleteStockProduct";
$route['viewStockInListing'] = "stock/viewStockInListing";
$route['viewStockInListing/(:any)'] = "stock/viewStockInListing/$1";
$route['addStockIn'] = "stock/addStockIn";
$route['editStockInView/(:any)'] = "stock/editStockInView/$1";
$route['updateStockIn'] = "stock/updateStockIn";
$route['deleteStockIn'] = "stock/deleteStockIn";
$route['addStockOut'] = "stock/addStockOut";
$route['viewStockOutListing'] = "stock/viewStockOutListing";
$route['viewStockOutListing/(:any)'] = "stock/viewStockOutListing/$1";
$route['editStockOutView/(:any)'] = "stock/editStockOutView/$1";
$route['updateStockOut'] = "stock/updateStockOut";
$route['deleteStockOut'] = "stock/deleteStockOut";

$route['viewStockSales'] = "stock/viewStockSales";
$route['viewStockSales/(:any)'] = "stock/viewStockSales/$1";
$route['addSalesToDB'] = "stock/addSalesToDB";


$route['getSupplementaryMarkPrint2022/(:any)'] = "students/getSupplementaryMarkPrint2022/$1";
$route['getSupplementaryMarkPrint2022'] = "students/getSupplementaryMarkPrint2022";

//Print councellor feedback
$route['pintStudentCouncellorFeedbackResponse/(:any)'] = "feedback/pintStudentCouncellorFeedbackResponse/$1"; 


$route['getAllCourseRegisterInfo'] = "students/getAllCourseRegisterInfo";
$route['getAllCourseRegisterInfo/(:any)'] = "students/getAllCourseRegisterInfo/$1";




$route['downloadCourseRegistrationReport'] = "reports/downloadCourseRegistrationReport";


// print marks card assignment exam 
$route['generateMidTermExamReportCard/(:any)'] = "students/generateMidTermExamReportCard/$1";
$route['generateMidTermExamReportCard'] = "students/generateMidTermExamReportCard";

// print marks card preparatory
$route['generatePreparatoryExamReportCard/(:any)'] = "students/generatePreparatoryExamReportCard/$1";
$route['generatePreparatoryExamReportCard'] = "students/generatePreparatoryExamReportCard";

// study certificate
$route['getCertificate'] = "students/getCertificate";
$route['addStudentRequestForm'] = "students/addStudentRequestForm";
$route['checkCertificateName'] = "students/checkCertificateName";

$route['addStudentInfoToDB'] = "students/addStudentInfoToDB";


//inactive students

$route['inactiveStudent'] = "students/inactiveStudent";
$route['activeStudent'] = "students/activeStudent";

$route['deleteStudentRequestDetails'] = "students/deleteStudentRequestDetails";

//deleted students
$route['viewDeletedStudents'] = "students/viewDeletedStudents";
$route['viewDeletedStudents/(:any)'] = "students/viewDeletedStudents/$1";


$route['getNameByStudentNumber'] = "students/getNameByStudentNumber";
$route['getSatNumberByRowId'] = "students/getSatNumberByRowId";
$route['getStudentNameById'] = "students/getStudentNameById";

$route['sendStudentNotification'] = 'push_Notification/sendStudentNotification';
$route['studentIndividualNotifications'] = 'push_Notification/studentIndividualNotifications';
$route['deleteStudentIndividualNotification'] = 'push_Notification/deleteStudentIndividualNotification';
$route['editStudentIndividualNotification'] = 'push_Notification/editStudentIndividualNotification';
$route['StudentIndividualNotificationEdit'] = 'push_Notification/StudentIndividualNotificationEdit';


$route['staffIndividualNotifications'] = 'push_Notification/staffIndividualNotifications';
$route['deleteStaffIndividualNotification'] = 'push_Notification/deleteStaffIndividualNotification';
$route['editStaffIndividualNotification'] = 'push_Notification/editStaffIndividualNotification';
$route['StaffIndividualNotificationEdit'] = 'push_Notification/StaffIndividualNotificationEdit';
//Tc orginal or duplicate
$route['orginalTC'] = "students/orginalTC";
$route['redirectStudentView'] = "students/redirectStudentView";


//app staff

$route['checkIsExist'] = 'apistaff/checkIsExist';

$route['fetchstaffDetails'] = 'apistaff/fetchstaffDetails';

$route['leaveType'] = 'apistaff/leaveType';

$route['listLeaveInfo'] = 'apistaff/listLeaveInfo';

$route['applyLeaveWithoutDoc'] = 'apistaff/applyLeaveWithoutDoc';

$route['listLeaveHistory'] = 'apistaff/listLeaveHistory';

$route['cancellLeave'] = 'apistaff/cancellLeave';

$route['applyLeaveWithDoc'] = 'apistaff/applyLeaveWithDoc';

$route['dashboardMenu'] = 'apistaff/dashboardMenu';

$route['staffAppStudentDetails'] = 'apistaff/staffAppStudentDetails';

$route['staffAppStaffDetails'] = 'apistaff/staffAppStaffDetails';

$route['staffAppTakeAttendance'] = 'apistaff/staffAppTakeAttendance';

$route['staffAppAbsentInfo'] = 'apistaff/staffAppAbsentInfo';

$route['staffAppClassComplete'] = 'apistaff/staffAppClassComplete';

$route['staffAppExamMark'] = 'apistaff/staffAppExamMark';

$route['staffAppStudyMaterial'] = 'apistaff/staffAppStudyMaterial';

$route['approveLeaveList']='apistaff/approveLeaveList';

$route['approveLeave']='apistaff/approveLeave';

$route['rejectLeave']='apistaff/rejectLeave';

$route['tokenToDB']='apistaff/tokenToDB';

$route['attendance']='apistaff/attendance';

$route['attendanceList']='apistaff/attendanceList';

// KJES ROUTES 
$route['leaveType']='apistaff/leaveType';

$route['subjectList']='apistaff/subjectList';

$route['deleteToken']='apistaff/deleteToken';

$route['checkStaffValid']='apistaff/checkStaffValid';

$route['checkOtp']='apistaff/checkOtp'; 

$route['approveAllLeaveList']='apistaff/approveAllLeaveList'; 

$route['superAdminFeesDashboard']='apistaff/superAdminFeesDashboard';

$route['listallStaff']='apistaff/listallStaff';

$route['fetchNotifiationData']='apistaff/fetchNotifiationData';

$route['listAllNotification']='apistaff/listAllNotification';

$route['staffSendNotification']='apistaff/staffSendNotification';


$route['staffViewHoliday']='apistaff/staffViewHoliday';

$route['staffDocumentInfo']='apistaff/staffDocumentInfo';

$route['staffCalendar']='apistaff/staffCalendar';

$route['staffAppStudentSuggetion']='apistaff/staffAppStudentSuggetion';

$route['staffDashboard']='apistaff/staffDashboard';

$route['pucSubjectList']='apistaff/pucSubjectList';

$route['sectionList']='apistaff/sectionList';

$route['staffAppStaffAttendance']='apistaff/staffAppStaffAttendance';

$route['salarySlip']='apistaff/salarySlip';

$route['mySalaryPrint'] = "apistaff/mySalaryPrint";

$route['getStaffSwitchProfile'] = 'apistaff/getStaffSwitchProfile';

$route['resetStaffSwitchProfile'] = 'apistaff/resetStaffSwitchProfile';
$route['dynamicRedirect'] = 'apistaff/dynamicRedirect';


//fees
//govt fee
$route['addGovtFeePaymentInfo'] = "fee/addGovtFeePaymentInfo";
$route['govtfeePaymentReceiptPrint/(:any)'] = "fee/govtfeePaymentReceiptPrint/$1";
$route['feePaymentReceiptPrint/(:any)'] = "fee/feePaymentReceiptPrint/$1";

$route['deleteMgmtFeeReceipt'] = "fee/deleteMgmtFeeReceipt";
$route['deleteFeesReceipt'] = "fee/deleteFeesReceipt";
$route['getCancelReceiptReport'] = "reports/getCancelReceiptReport";
$route['downloadConcessionFeeReport'] = "reports/downloadConcessionFeeReport";

// Department fee report 
$route['downloadGovtFeeReport'] = "reports/downloadGovtFeeReport";
$route['downloadBankDepositReport'] = "reports/downloadBankDepositReport";
$route['downloadManagementFeeReport'] = "reports/downloadManagementFeeReport";
// bank settlement
$route['addBankSettlementSubmit'] = "fee/addBankSettlementSubmit";
$route['govtfeePaidInfo'] = "fee/govtfeePaidInfo";
$route['govtfeePaidInfo/(:any)'] = "fee/govtfeePaidInfo/$1";
$route['addGovtBankSettlementSubmit'] = "fee/addGovtBankSettlementSubmit";
//ADMIN DASHBOARD
$route['adminDashboard'] = 'user/adminDashboard';
$route['directLogin/(:any)/(:any)'] = "login/directLogin/$1/$2";

 // Job portal routes
//  $route['jobPortal'] = "jobPortal";
$route['jobPortalListing'] = "jobPortal/jobPortalListing";
$route['jobPortalListing/(:any)'] = "jobPortal/jobPortalListing/$1"; 
 $route['jobPortal/viewApplicant'] = "jobPortal/viewApplicant";
 $route['jobPortal/viewApplicant/$1'] = "jobPortal/viewApplicant/$1";
 $route['jobPortal/deleteApplicant'] = "jobPortal/deleteApplicant";
 
 $route['updateApprovedStatus'] = "jobPortal/updateApprovedStatus";
 $route['updateJobApplicationStatus'] = "jobPortal/updateJobApplicationStatus";
 $route['updateStudentJobStatus'] = "jobPortal/updateStudentJobStatus";
 
 $route['approvedJobApplication'] = "jobPortal/approvedJobApplication";
 $route['approvedJobApplication/(:any)'] = "jobPortal/approvedJobApplication/$1";
 $route['rejectedJobApplication'] = "jobPortal/rejectedJobApplication";
 $route['rejectedJobApplication/(:any)'] = "jobPortal/rejectedJobApplication/$1";
 $route['updateShortlistApplication'] = "jobPortal/updateShortlistApplication";
 $route['shorlistedJobApplication'] = "jobPortal/shorlistedJobApplication";
 $route['shorlistedJobApplication/(:any)'] = "jobPortal/shorlistedJobApplication/$1"; 
 $route['jobDashboard'] = "jobPortal/jobDashboard";

 $route['addJobPost'] = "jobPortal/addJobPost";
$route['activeJobPost'] = "jobPortal/activeJobPost";
$route['inactiveJobPost'] = "jobPortal/inactiveJobPost";
$route['deleteJobPost'] = "jobPortal/deleteJobPost";

// Documnet Info
$route['viewDocumentInfo'] = "staffs/viewDocumentInfo";
$route['viewDocumentInfo/(:any)'] = "staffs/viewDocumentInfo/$1";
$route['addNewDocumentDetails'] = "staffs/addNewDocumentDetails";
$route['deleteDocument'] = "staffs/deleteDocument";
$route['addDocName'] = "settings/addDocName";
$route['deleteDocumentType'] = "settings/deleteDocumentType";


//Purchase Order
$route['PurchaseOrderListing'] = 'PurchaseOrder/PurchaseOrderListing';
$route['PartyDetails'] = 'PurchaseOrder/PartyDetails';
$route['addParty'] = 'PurchaseOrder/addParty';
$route['deleteParty'] = 'PurchaseOrder/deleteParty';
$route['editParty/(:num)'] = 'PurchaseOrder/editParty/$1';
$route['updateParty'] = 'PurchaseOrder/updateParty';
$route['addNewPurchaseOrder'] = 'PurchaseOrder/addNewPurchaseOrder';
$route['addPurchaseOrderToDB'] = 'PurchaseOrder/addPurchaseOrderToDB';
$route['addBillPayment'] = 'PurchaseOrder/addBillPayment';
$route['viewPrintPurchaseOrder/(:any)'] = 'PurchaseOrder/viewPrintPurchaseOrder/$1';
$route['deletePurchaseOrder'] = 'PurchaseOrder/deletePurchaseOrder';
$route['editPurchaseOrder/(:num)'] = 'PurchaseOrder/editPurchaseOrder/$1';
$route['updatePurchaseOrder'] = 'PurchaseOrder/updatePurchaseOrder';
$route['addUnitInfo'] = 'PurchaseOrder/addUnitInfo';
$route['EditUnitInfo'] = 'PurchaseOrder/EditUnitInfo';
$route['lock'] = 'PurchaseOrder/lock';
$route['unlock'] = 'PurchaseOrder/unlock';

$route['downloadStaffAttendanceMonthlyReportPdf'] = "attendance/downloadStaffAttendanceMonthlyReportPdf";
$route['downloadStaffAttendanceMonthlyReportPdfNew'] = "attendance/downloadStaffAttendanceMonthlyReportPdfNew";

//Fee Dashboard
$route["viewFeeDashboard"] = "feeDashboard/viewFeeDashboard";

$route['updateLeaveInfoByStaffId'] = 'staffs/updateLeaveInfoByStaffId';

$route['updateSalaryInfo'] = "staffs/updateSalaryInfo";
$route['addSalaryDetails'] = 'staffs/addSalaryDetails';
$route['updateSalaryInfoByID'] = "staffs/updateSalaryInfoByID";
$route['updateStaffDocuments'] = "staffs/updateStaffDocuments";

$route['updateStaffEducationInfo'] = "staffs/updateStaffEducationInfo";

$route['updateStaffWorkExperience'] = 'staffs/updateStaffWorkExperience';

$route['addRemarksToStaff'] = 'staffs/addRemarksToStaff';
$route['updateStaffRemarks'] = "staffs/updateStaffRemarks";
$route['deleteStaffRemarkDetails'] = 'staffs/deleteStaffRemarkDetails';

//salary Slip Listing
$route['salarySlipListing'] = 'salary/salarySlipListing';
$route['salarySlipListing/(:any)'] = 'salary/salarySlipListing/$1';
$route['addWorkingDaysToSalarySlip'] = 'salary/addWorkingDaysToSalarySlip';
$route['addSalarySlip'] = 'salary/addSalarySlip';

$route['getStaffSalaryPrint'] = "salary/getStaffSalaryPrint";

$route['employeeIdUpdate'] = "settings/employeeIdUpdate";

$route['getStaffIdCode'] = "staffs/getStaffIdCode";

$route['changeRoleByAdmin'] = "login/changeRoleByAdmin";

$route['addOTAmount'] = "settings/addOTAmount";
$route['deleteOTAmount'] = "settings/deleteOTAmount"; 
$route['addOTDetails'] = 'staffs/addOTDetails';
$route['updateOTInfoByID'] = 'staffs/updateOTInfoByID';

$route['redirectStaffView'] = "staffs/redirectStaffView";

$route['createExam'] = 'exam/createExam';
$route['createExam/(:any)'] = 'exam/createExam/$1';

$route['createNewExam'] = 'exam/createNewExam';

$route['deleteCreatedExam'] = 'exam/deleteCreatedExam';

$route['inactiveCreatedExam'] = 'exam/inactiveCreatedExam';
$route['activeCreatedExam'] = 'exam/activeCreatedExam';

$route['getExamType'] = 'exam/getExamType';

$route['addExamType'] = 'settings/addExamType';

$route['deleteExamType'] = "settings/deleteExamType"; 

$route['editExam/(:any)'] = "exam/editExam/$1";

$route['updateExamInfo'] = 'exam/updateExamInfo';

//Salary Dashboard
$route["viewSalaryDashboard"] = "salaryDashboard/viewSalaryDashboard";

// homework
$route['pushNotification/sendHomework'] = "push_Notification/sendHomework"; 
$route['getStudentHomework'] = 'push_Notification/getStudentHomework';
$route['deleteStudentHomework'] = 'push_Notification/deleteStudentHomework';

$route['404_override'] = 'custom404';

$route['importSalaryInfo'] = "settings/importSalaryInfo";

$route['addSalaryType'] = "settings/addSalaryType";
$route['deleteSalaryType'] = "settings/deleteSalaryType";
$route['getCalculationType'] = "settings/getCalculationType";

$route['addOtherAmountDetails'] = 'salary/addOtherAmountDetails';
$route['updateOtherAmountInfoByID'] = 'salary/updateOtherAmountInfoByID';
$route['deleteSalarySlip'] = 'salary/deleteSalarySlip';

$route['downloadStaffSalaryReportMonthlyWise'] = "salary/downloadStaffSalaryReportMonthlyWise";
$route['downloadStaffEsiReport'] = "salary/downloadStaffEsiReport";
$route['downloadSalaryReport'] = "salary/downloadSalaryReport";
$route['downloadStaffSalaryStatementMonthly'] = "salary/downloadStaffSalaryStatementMonthly";
$route['getStaffSalaryYearlyPrint'] = "salary/getStaffSalaryYearlyPrint";

$route['addSalaryDetailsNew'] = 'salary/addSalaryDetailsNew';

$route['addSalaryDesignation'] = "settings/addSalaryDesignation";
$route['deleteSalaryDesignation'] = "settings/deleteSalaryDesignation";

$route['deleteSalaryEarningInfo'] = "salary/deleteSalaryEarningInfo";
$route['deleteSalaryDeductionInfo'] = "salary/deleteSalaryDeductionInfo";
$route['updateEarningInfo'] = "salary/updateEarningInfo";
$route['updateDeductionInfo'] = "salary/updateDeductionInfo";

$route['addTaxRegime'] = "settings/addTaxRegime";
$route['deleteTaxRegime'] = "settings/deleteTaxRegime";

$route['addAdvancePaymentDetails'] = 'salary/addAdvancePaymentDetails';
$route['updateSalaryAdvanceInfo'] = "salary/updateSalaryAdvanceInfo";

//my salary Slip Listing
$route['mysalarySlipListing'] = 'salary/mysalarySlipListing';
$route['mysalarySlipListing/(:any)'] = 'salary/mysalarySlipListing/$1';
$route['getmySalaryPrint'] = "salary/getmySalaryPrint";
$route['getmySalaryPrint/(:any)'] = 'salary/getmySalaryPrint/$1';

$route['addYearWise'] = "settings/addYearWise";

$route['discontinueStudent'] = "students/discontinueStudent";

$route['continueStudent'] = "students/continueStudent";

$route['downloadStudentSiblingExcelReport'] = "reports/downloadStudentSiblingExcelReport";


// Library routes
$route['viewLibraryDashboard'] = "libraryManagement/viewLibraryDashboard";
$route['libraryManagementSystem'] = "libraryManagement/libraryManagementSystem";
$route['libraryManagementSystem/(:any)'] = "libraryManagement/libraryManagementSystem/$1";
$route['addLibraryInfo'] = "libraryManagement/addLibraryInfo";
$route['addLibraryBookToDB'] = "libraryManagement/addLibraryBookToDB";
$route['getAccessCode'] = "libraryManagement/getAccessCode";
$route['generateBarcodeForBook'] = "libraryManagement/generateBarcodeForBook";

$route['viewIssuedBooks'] = "libraryManagement/viewIssuedBooks";
$route['editIssuedInfo/(:any)'] = "libraryManagement/editIssuedInfo/$1";
$route['updateIssuedInfo'] = "libraryManagement/updateIssuedInfo";
$route['updateRenewalDate'] = "libraryManagement/updateRenewalDate";

$route['viewLibrarySettings'] = "libraryManagement/viewLibrarySettings";
$route['viewBarCodeGenerater'] = "libraryManagement/viewBarCodeGenerater";
$route['generateBarcode'] = "libraryManagement/generateBarcode";
$route['viewIssueBook'] = "libraryManagement/viewIssueBook";

$route['deleteLibraryDetails'] = "libraryManagement/deleteLibraryDetails";
$route['getIsbnData'] = "libraryManagement/getIsbnData";
$route['getAccessData'] = "libraryManagement/getAccessData";
$route['deleteBarcode'] = "libraryManagement/deleteBarcode";
$route['viewprintBarcode'] = "libraryManagement/viewprintBarcode";

$route['addBookCategory'] = "libraryManagement/addBookCategory";
$route['deleteBookCategory'] = "libraryManagement/deleteBookCategory";
$route['addBookAuthor'] = "libraryManagement/addBookAuthor";
$route['deleteBookauthor'] = "libraryManagement/deleteBookauthor";
$route['addBookPublisher'] = "libraryManagement/addBookPublisher";
$route['deleteBookPublisher'] = "libraryManagement/deleteBookPublisher";
$route['addBookShelf'] = "libraryManagement/addBookShelf";
$route['deleteBookShelf'] = "libraryManagement/deleteBookShelf";
$route['addBookFine'] = "libraryManagement/addBookFine";
$route['deleteBookFine'] = "libraryManagement/deleteBookFine";
$route['addLibraryIssueInfo'] = "libraryManagement/addLibraryIssueInfo";
$route['updateLibrary'] = "libraryManagement/updateLibrary";
$route['editLibrary/(:any)'] = "libraryManagement/editLibrary/$1";

//annual marks entry
$route['addAnnualMark'] = "exam/addAnnualMark";
$route['getStudentForAnnualMark'] = "exam/getStudentForAnnualMark";
$route['addStudentAnnualMarkByStaff'] = "exam/addStudentAnnualMarkByStaff";

$route['getAnnualMarkCardToPrint25/(:any)'] = "students/getAnnualMarkCardToPrint25/$1";
$route['getAnnualMarkCardToPrint25'] = "students/getAnnualMarkCardToPrint25";

//scholarship 

$route['addScholarshipType'] = "scholarship/addScholarshipType";
$route['deleteScholarshipType'] = "scholarship/deleteScholarshipType";

$route['addScholarshipRecommendedBy'] = "scholarship/addScholarshipRecommendedBy";
$route['deleteScholarshipRecommendedBy'] = "scholarship/deleteScholarshipRecommendedBy";

$route['scholarshipListing'] = "scholarship/scholarshipListing";  
$route['addScholarshipDetails'] = "scholarship/addScholarshipDetails";
$route['deleteScholarshipInfo'] = "scholarship/deleteScholarshipInfo";

$route['editScholarshipDetailsPageView'] = "scholarship/editScholarshipDetailsPageView";  
$route['editScholarshipDetailsPageView/(:any)'] = "scholarship/editScholarshipDetailsPageView/$1"; 
$route['addScholarshipStudentDetails'] = "scholarship/addScholarshipStudentDetails";

$route['deleteScholarshipDetail'] = 'scholarship/deleteScholarshipDetail';

$route['scholarshipStudentPrint/(:any)'] = "scholarship/scholarshipStudentPrint/$1";
$route['downloadScholarshipExcelReport'] = 'scholarship/downloadScholarshipExcelReport';

$route['editScholarshipInfo/(:any)'] = "scholarship/editScholarshipInfo/$1";
$route['updateScholarshipStudentDetails'] = "scholarship/updateScholarshipStudentDetails";

$route['editScholarship/(:any)'] = "scholarship/editScholarship/$1";
$route['updateScholarship'] = "scholarship/updateScholarship";
$route['addStaffShiftinfo'] = 'settings/addStaffShiftinfo';
$route['deleteShiftInfo'] = "settings/deleteShiftInfo";
$route['updateTimingsInfo'] = "settings/updateTimingsInfo";


//register event
$route['eventListing'] = 'event/eventListing';
$route['eventListing/(:num)'] = "event/eventListing/$1";
$route['addEvents'] = 'event/addEvents';
$route['addEventToDb'] = 'event/addEventToDb';
$route['viewEvent/(:num)'] = "event/viewEvent/$1";
$route['editEvent/(:num)'] = "event/editEvent/$1";
$route['updateEvent'] = 'event/updateEvent';
$route['deleteEventregister'] = "event/deleteEventregister";
$route['getEventPDFPrint/(:any)'] = "event/getEventPDFPrint/$1";

//route for gallery
$route['viewGalleryInfo'] = 'gallery/viewGalleryInfo';
$route['viewGalleryInfo/(:num)'] = "gallery/viewGalleryInfo/$1";
$route['addNewPhotoGallery'] = 'gallery/addNewPhotoGallery';
$route['addPhoto'] = 'gallery/addPhoto';
$route['editPhotoGalleryDetails/(:num)'] = "gallery/editPhotoGalleryDetails/$1";
$route['updatePhotoGalleryDetails'] = 'gallery/updatePhotoGalleryDetails';
$route['deleteImage'] = 'gallery/deleteImage';
$route['viewPhotoGalleryDetails/(:any)'] = "gallery/viewPhotoGalleryDetails/$1";
$route['deletePhotoGallery'] = 'gallery/deletePhotoGallery';



//bus fee
$route['addTransportName'] = "transport/addTransportName";
$route['editTransportInfo'] = "transport/editTransportInfo";

// routes for Transport Management- Bus
$route['viewBusListing'] = "transport/viewBusListing";
$route['viewBusListing/(:any)'] = "transport/viewBusListing/$1";
$route['deleteBus'] = "transport/deleteBus";
$route['addNewBus'] = "transport/addNewBus";
$route['editBus/(:any)'] = "transport/editBus/$1";
$route['updateBus'] = "transport/updateBus";
$route['addTyreInfo'] = "transport/addTyreInfo";
$route['addSpareInfo'] = "transport/addSpareInfo";
$route['addServiceInfo'] = "transport/addServiceInfo";
$route['addFuelInfo'] = "transport/addFuelInfo";
$route['deleteTyre'] = "transport/deleteTyre";
$route['deleteSpare'] = "transport/deleteSpare";
$route['deleteService'] = "transport/deleteService";
$route['deleteFuel'] = "transport/deleteFuel";
$route['addTripInfo'] = "transport/addTripInfo";
$route['deleteTrip'] = "transport/deleteTrip";
$route['viewTransportDashboard'] = "transport/viewTransportDashboard";


//transport fee
$route['transFeePayNow'] = "transport/transFeePayNow";
$route['getStudentTransFeePaymentInfo'] = "transport/getStudentTransFeePaymentInfo";
$route['addTransFeePaymentInfo'] = "transport/addTransFeePaymentInfo";
$route['deleteFeeReceipt'] = "transport/deleteFeeReceipt";
$route['addTransportName'] = "transport/addTransportName";
$route['deleteTransportName'] = "transport/deleteTransportName"; 
$route['printStudentTransportBill/(:any)'] = "transport/printStudentTransportBill/$1";
$route['getReceipt'] = "transport/getReceipt";


// routes for Transport Management- Student Bus
$route['viewStudentTransportListing'] = "transport/viewStudentTransportListing";
$route['viewStudentTransportListing/(:any)'] = "transport/viewStudentTransportListing/$1";


$route['viewBusFeeConcession'] = "transport/viewBusFeeConcession";
$route['viewBusFeeConcession/(:any)'] = "transport/viewBusFeeConcession/$1";
$route['addBusConcession'] = "transport/addBusConcession";
$route['editBusConcession/(:any)'] = "transport/editBusConcession/$1";
$route['updateBusConcession'] = "transport/u``pdateBusConcession";
$route['approveBusConcession'] = "transport/approveBusConcession";
$route['rejectBusConcession'] = "transport/rejectBusConcession";
$route['deleteBusConcession'] = "transport/deleteBusConcession";


$route['downloadTransportFeeInfoReport'] = "transport/downloadTransportFeeInfoReport";
$route['downloadArrearTransportFeeInfoReport'] = "reports/downloadArrearTransportFeeInfoReport";
$route['downloadTransportDueInfoReport'] = "transport/downloadTransportDueInfoReport";
$route['downloadTransportOnlyDueInfoReport'] = "transport/downloadTransportOnlyDueInfoReport";


$route['downloadBulkFeeReport'] = "reports/downloadBulkFeeReport";
$route['downloadArrearFeeInfoReport'] = "reports/downloadArrearFeeInfoReport";
$route['downloadTransportBulkFeeReport'] = "reports/downloadTransportBulkFeeReport";

//cancel bus
$route['cancelBusListing'] = "transport/cancelBusListing";
$route['cancelBusListing/(:any)'] = "transport/cancelBusListing/$1";
$route['updateCancelBus'] = "transport/updateCancelBus";
$route['deleteCancelBus'] = "transport/deleteCancelBus";

$route['viewManagementFeeCancelledInfo'] = "fee/viewManagementFeeCancelledInfo";
$route['viewManagementFeeCancelledInfo/(:num)'] = "fee/viewManagementFeeCancelledInfo/$1";

$route['viewDepartmentFeeCancelledInfo'] = "fee/viewDepartmentFeeCancelledInfo";
$route['viewDepartmentFeeCancelledInfo/(:num)'] = "fee/viewDepartmentFeeCancelledInfo/$1";

$route['generateBusPassPDF/(:any)'] = "students/generateBusPassPDF/$1";
$route['generateBusPassPDF'] = "students/generateBusPassPDF";
$route['downloadStudentExcelReport_instudentlisting'] = "reports/downloadStudentExcelReport_instudentlisting";

$route['downloadDatewiseTransportFeeReport'] = "transport/downloadDatewiseTransportFeeReport";
$route['addTransportBankSettlementSubmit'] = "transport/addTransportBankSettlementSubmit";

//show staff feedback by students
$route['viewStudentFeedbackOfStaff/(:any)'] = 'staffFeedback/viewStudentFeedbackOfStaff/$1';
$route['addCommentToFeedbackByPrincipal/(:any)'] = "staffFeedback/addCommentToFeedbackByPrincipal/$1";
$route['pintStudentFeedbackResponse_22/(:any)'] = "staffFeedback/pintStudentFeedbackResponse_22/$1";
$route['pintStudentFeedbackResponse_23/(:any)'] = "staffFeedback/pintStudentFeedbackResponse_23/$1";

$route['viewStaffFeedbackOfPrincipal'] = 'staffFeedback/viewStaffFeedbackOfPrincipal';
$route['viewStaffFeedbackOfVicePrincipal'] = 'staffFeedback/viewStaffFeedbackOfVicePrincipal';

$route['printAttendanceShortageReportSAT3/(:any)'] = "students/printAttendanceShortageReportSAT3/$1";
$route['printAttendanceShortageReportSAT3'] = "students/printAttendanceShortageReportSAT3";

$route['printAttendanceShortageReportSATFINAL/(:any)'] = "students/printAttendanceShortageReportSATFINAL/$1";
$route['printAttendanceShortageReportSATFINAL'] = "students/printAttendanceShortageReportSATFINAL";

// Inactive Student

$route['studentInactiveInfo'] = "students/studentInactiveInfo";

$route['addRemarksInfo'] = 'students/addRemarksInfo';
$route['updateRemarkInfo'] = "students/updateRemarkInfo";

$route['deleteStudentRemarks'] = "students/deleteStudentRemarks";

$route['addRemarkName'] = "settings/addRemarkName";

$route['deleteRemarkName'] = "settings/deleteRemarkName";

$route['downloadFeedBackPendingExcelReport'] ='reports/downloadFeedBackPendingExcelReport';
$route['downloadFeedBackExcelReport'] ='reports/downloadFeedBackExcelReport';
$route['downloadFeedBackCommentsExcelReport'] ='reports/downloadFeedBackCommentsExcelReport';

$route['menuAccess'] = "staffs/menuAccess";
$route['menuAccess/(:any)'] = "staffs/menuAccess/$1";
$route['getMenuAccess'] = "staffs/getMenuAccess";
$route['updateAccess'] = "staffs/updateAccess";

//settings module management
$route['addModule'] = "settings/addModule"; 
$route['updateModule'] = "settings/updateModule"; 
$route['deleteModule'] = "settings/deleteModule";
$route['addSubModule'] = "settings/addSubModule";
$route['updateSubModule'] = "settings/updateSubModule";
$route['deleteSubModule'] = "settings/deleteSubModule";

$route['configureMenuAccess'] = "configuration/configureMenuAccess";
$route['downloadStaffSalaryStatementExcel'] = "salary/downloadStaffSalaryStatementExcel";

$route['downloadDateWiseFeeReportInfo'] = "reports/downloadDateWiseFeeReportInfo";
$route['downloadBifurcationReport'] = "reports/downloadBifurcationReport";
$route['downloadBankSettlementReport'] = "reports/downloadBankSettlementReport";
$route['downloadFeeDueReport'] = "reports/downloadFeeDueReport";

//Special fee receipt
$route['newSpecialFeePaymentReceiptPrint/(:any)'] = "fee/newSpecialFeePaymentReceiptPrint/$1";
$route['specialFeePaymentReport'] = "reports/specialFeePaymentReport";

$route['annualFeesPayment'] = "fee/annualFeesPayment";
$route['annualFeeResponse'] = "fee/annualFeeResponse";

//Inactive student import
$route['getInactiveStudentsImport'] = "settings/getInactiveStudentsImport";

//class teacher attendance
$route['getClassAttendanceDetails'] = "studentAttendance/getClassAttendanceDetails";
$route['getClassAttendanceDetails/(:any)'] = "studentAttendance/getClassAttendanceDetails/$1";
$route['getClassTeacherStudentsForAttendance'] = "studentAttendance/getClassTeacherStudentsForAttendance";
$route['addClassTeacherAttendanceByStaff'] = "studentAttendance/addClassTeacherAttendanceByStaff";
$route['editClassSection/(:any)'] = "timetable/editClassSection/$1";
$route['updateClassAndSection'] = "timetable/updateClassAndSection";
$route['getClassTeacherAbsentDetails'] = "studentAttendance/getClassTeacherAbsentDetails";
$route['getClassTeacherAbsentDetails/(:any)'] = "studentAttendance/getClassTeacherAbsentDetails/$1";
$route['deleteAbsentAttendance'] = "studentAttendance/deleteAbsentAttendance";
$route['viewClassTeacherClassCompletedInfo'] = "studentAttendance/viewClassTeacherClassCompletedInfo";
$route['viewClassTeacherClassCompletedInfo/(:any)'] = "studentAttendance/viewClassTeacherClassCompletedInfo/$1";
$route['deleteAbsentClassCompleted'] = "studentAttendance/deleteAbsentClassCompleted";
$route['getStreamSectionByTermforNotification'] = "push_Notification/getStreamSectionByTermforNotification";
$route['getSectionByTermforNotification'] = "push_Notification/getSectionByTermforNotification";
$route['downloadClassAbsentedStudentInfo'] = "studentAttendance/downloadClassAbsentedStudentInfo";
$route['downloadClassTeacherClassCompleted'] = "studentAttendance/downloadClassTeacherClassCompleted";
