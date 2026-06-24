<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerFaculty.php';

class StudentAttendance extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('studentAttendance_model','attendance');
        $this->load->model('settings_model','settings');
        $this->load->model('students_model','student');
        $this->load->model('subjects_model','subject');
        $this->load->model('staff_model','staff');
        $this->load->model('timetable_model','timetable');
        $this->load->model('sms_model','sms');
        $this->load->model('push_notification_model');
        $this->load->library('pagination');
        $this->load->library('excel');
        $this->isLoggedIn();   
    }

    public function getAttendanceDetails(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $filter = array();
            $attendance_date = $this->security->xss_clean($this->input->post('attendance_date'));
            $todayDate = date('Y-m-d');
            $weekname = date('l', strtotime($todayDate));
            if(!empty($attendance_date)){
                $data['attendance_date'] = date('d-m-Y',strtotime($attendance_date));
                $filter['attendance_date'] = date('l',strtotime($attendance_date));
                $data['attendanceDate']= date('d-m-Y', strtotime($attendance_date));
                $filter['search_date'] = date('Y-m-d',strtotime($attendance_date));
            }else{
                $data['attendance_date'] = '';
                $data['attendanceDate']= date('d-m-Y', strtotime($todayDate));
                $filter['weekName'] = $weekname;
                $filter['search_date'] = date('Y-m-d');
            }
            
            if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
                $data['staff_id'] = $this->staff_id;
            }else{
                $data['staff_id'] = '';
            }

            $data['streamSectionInfo'] = $this->staff->getSectionById($filter);
            $data['timingsInfo'] = $this->settings->getAllClassTimingsInfo();
            $data['staffSubjectInfo'] = $this->staff->getAllSubjectInfo($filter);
            $data['classCompletedInfo'] = $this->attendance->getAttendanceClassCompletedInfo();
            // log_message('debug','hiiiiiiiiiiii');

            // $isExists = $this->attendance->CheckTimetableDayShiftExists($filter);
            // if(!empty($isExists)){
            //     $filter['week'] = $isExists->week_name;
            //     $filter['attendance_date'] = $isExists->week_name;
            //     $count = $this->attendance->getShiftTimetableInfoCount($filter);
            //     $returns = $this->paginationCompress("getAttendanceDetails/", $count, 100);
            //     $data['attendanceInfo'] = $this->attendance->getShiftTimetableInfo($filter,$returns["page"], $returns["segment"]);
            // }else{
            //     $count = $this->attendance->getClassForAttendanceCount($filter);
            //     $returns = $this->paginationCompress("getAttendanceDetails/", $count, 100);
            //     $data['attendanceInfo'] = $this->attendance->getClassForAttendance($filter,$returns["page"], $returns["segment"]);
            // }
            
            // log_message('debug','dmkme='.print_r($data['attendanceInfo'],true));
            // $data['attendanceCount'] = $count;
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Attendance Details';
            $this->loadViews("attendance/attendance", $this->global, $data, NULL);
        }
    }
    
    public function getStudentInfoForAttendance(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $filter = array();
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
            $subject_name = $this->security->xss_clean($this->input->post('subject_name'));
            $section_name = $this->security->xss_clean($this->input->post('section_name'));
            $subject_code = $this->security->xss_clean($this->input->post('subject_code'));
            $attendance_date = $this->security->xss_clean($this->input->post('attendance_date'));
            $time_row_id = $this->security->xss_clean($this->input->post('time_row_id'));
            $section_row_id = $this->security->xss_clean($this->input->post('section_row_id'));
            $staff_subject_row_id = $this->security->xss_clean($this->input->post('staff_subject_row_id'));
            $class_batch = $this->security->xss_clean($this->input->post('class_batch'));

            $filter['time_row_id'] = $time_row_id;
            $filter['section_row_id'] = $section_row_id;
            $filter['staff_subject_row_id'] = $staff_subject_row_id;
            $sectionInfo = $this->attendance->getSectionInfoByRowId($filter);
            $subjectInfo = $this->attendance->getSubjectByRowId($filter);
            $sectionName = $sectionInfo->section_name;

            $filter['term_name'] = $sectionInfo->term_name;
            $filter['stream_name'] = $sectionInfo->stream_name;
            $filter['subject_name'] = $subjectInfo->sub_name;
            if($sectionName == "ALL"){
                $filter['section_name'] = '';
            }else{
                $filter['section_name'] = $sectionName;
            }

            if(empty($class_batch)){
                $filter['class_batch'] = '';
                $data['class_batch'] = '';
            }else{
                $filter['class_batch'] = $class_batch;
                $data['class_batch'] = $class_batch;
            }
            
            $data['attendance_date'] = $attendance_date;
            $data['term_name'] = $sectionInfo->term_name;
            $data['stream_name'] = $sectionInfo->stream_name;
            $data['subject_name'] = $subjectInfo->sub_name;
            $data['section_name'] = $sectionName;
            $data['subject_code'] = $subjectInfo->subject_code;
            $data['subject_type'] = $subjectInfo->subject_type;
            $data['time_row_id'] = $time_row_id;
            $data['section_row_id'] = $section_row_id;
            $data['staff_subject_row_id'] = $staff_subject_row_id;
            $data['staff_id'] = $this->staff_id;
            
            $data['studentRecord'] = $this->student->getStudentInfoForInternal($filter);
            $data['classCompletedInfo'] = $this->attendance->checkClassCompletedInfo(date('Y-m-d',strtotime($attendance_date)),$subjectInfo->subject_code,$time_row_id,$sectionInfo->term_name,$sectionName,$sectionInfo->stream_name);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Attendance Details';
            $this->loadViews("attendance/takeAttendance", $this->global, $data, NULL);
        }
    }

    public function addSingleSubjectAttendanceByStaff(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $filter = array();
            $attInfo = json_decode(stripslashes($this->input->post('attInfo')));
            $students = array();
            $title = 'Absent Info';
            $today_date = date('Y-m-d');

            foreach($attInfo as $info){
                if($info->name == 'staff_subject_row_id'){
                    $staff_subject_row_id = $info->value;
                }
                if($info->name == 'attendance_date'){
                    $attendance_date = $info->value;
                }
                if($info->name == 'time_row_id'){
                    $time_row_id = $info->value;
                }
                if($info->name == 'section_row_id'){
                    $section_row_id = $info->value;
                }
                if($info->name == 'subject_code'){
                    $subject_code = $info->value;
                }
                if($info->name == 'term_name'){
                    $term_name = $info->value;
                }
                if($info->name == 'stream_name'){
                    $stream_name = $info->value;
                }
                if($info->name == 'section_name'){
                    $section_name = $info->value;
                }
                if($info->name == 'subject_name'){
                    $subject_name = $info->value;
                }
                if($info->name == 'subject_type'){
                    $subject_type = $info->value;
                }
                if($info->name == 'student_batch'){
                    $student_batch = $info->value;
                }
                if($info->value == true){
                    $students[$info->name] = $info->name;
                }
                
            }

            $attendanceDate = date("Y-m-d", strtotime($attendance_date));
            $filter['term_name'] = $term_name;
            $filter['stream_name'] = $stream_name;
            $filter['subject_name'] = $subject_name;
            $filter['student_id'] = $students;
            $sectionName = $section_name; 
            if($section_name == "ALL"){
                $filter['section_name'] = '';
            }else{
                $filter['section_name'] = $sectionName;
            }
            
            if(empty($student_batch)){
                $filter['class_batch'] = '';
                $student_batch = '';
            }else{
                $filter['class_batch'] = $student_batch;
                $student_batch = $student_batch;
            }
            $subjectInfo = $this->attendance->getSubjectNameByCode($subject_code);
            // ,$this->staff_id
            $isExistsClass = $this->attendance->getclassCompletedInfo($attendanceDate,$subject_code,$time_row_id,$term_name,$section_name,$stream_name,$subject_type,$student_batch);
            if($isExistsClass == NULL){
                $sendSmsStatus = true;
                $subInfo = array(
                    'date' => $attendanceDate,
                    'subject_code' => $subject_code,
                    'staff_id' => $this->staff_id,
                    'term_name' => $term_name,
                    'section_name' => $section_name,
                    'stream_name' => $stream_name,
                    'time_id' => $time_row_id,
                    'subject_type' => $subject_type,
                    'batch' => $student_batch,
                    'class_year' => CURRENT_YEAR,
                    'created_date_time' => date('Y-m-d H:i:s'),
                    'created_by' => $this->staff_id);
                $result = $this->attendance->addStaffTeachedSubjectInfo($subInfo);
                $class_row_id = $result;
            }else{
                $sendSmsStatus = false;
                $subInfo = array(
                    'term_name' =>$term_name,
                    'section_name' =>$section_name,
                    'stream_name' => $stream_name,
                    'subject_type' => $subject_type,
                    'batch' => $student_batch,
                    'class_year' => CURRENT_YEAR,
                    'updated_date_time' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->staff_id);
                    // $this->staff_id, 
                $result = $this->attendance->updateStaffTeachedSubjectInfo($subject_code,$attendanceDate,$time_row_id,$subInfo,$term_name,$section_name,$stream_name,$subject_type,$student_batch);
                $class_row_id = $isExistsClass->row_id;
            }
            

            $this->attendance->deleteAllStudents($subject_code,$attendanceDate,$time_row_id,$section_row_id,$student_batch);
            //,$staff_subject_row_id       
            $data['studentRecords'] = $this->student->getStudentInfoForInternal($filter);
            //$this->attendance->getStudentInfoForAttendance($filter);
            foreach($data['studentRecords'] as $student){
                if($students[$student->student_id] == $student->student_id){
                    $stdInfo = $this->student->getStudentDetailsInfo($student->student_id);
                    $attendanceInfo = array (
                        'class_section_row_id' => $section_row_id,
                        'staff_subject_row_id' => $staff_subject_row_id,
                        'class_row_id' => $class_row_id,
                        'student_id' => $student->student_id,
                        'subject_code' => $subject_code,
                        'absent_date' => $attendanceDate,
                        'time_row_id' => $time_row_id,
                        'student_batch' => $student_batch,
                        'year' => CURRENT_YEAR,
                        'sms_sent_status' => 0,
                        'office_verified_status' => 0,
                        'created_by' => $this->staff_id,
                        'created_date_time' => date('Y-m-d H:i:s'));
                    $result =  $this->attendance->addAbsentStudentInfo($attendanceInfo);
                    
                    // if($result > 0) {
                    //     $numbers = [];
                    //     if (!empty($stdInfo->father_mobile)) {
                    //         $numbers[] = trim($stdInfo->father_mobile);
                    //     }
                    //     if (!empty($stdInfo->mother_mobile)) {
                    //         $numbers[] = trim($stdInfo->mother_mobile);
                    //     }

                    //     $date = date("d-m-Y", strtotime($attendance_date));
                    //     $message = "Dear Parent, your ward is absent for the ".$subjectInfo->name." on ".$date." - Regards Principal, St Anns PUC Mangalore";
                    //     $templateId = '1007704114891939561';
                    //     $result_sms = $this->AirtelSMS($numbers, $message,$templateId);
                        
                    //     if(trim(strtolower($result_sms)) == 'success'){

                    //         $smsLog = array(
                    //             'student_id'         => $student->row_id,
                    //             'subject_code'       => $subject_code,
                    //             'class_row_id'       => $class_row_id,
                    //             'mobile_no'          => implode(',', $numbers),
                    //             'message'            => $message,
                    //             'msg_type'           => 'Absent Sms',
                    //             'status'             => 'SUCCESS',
                    //             'created_date_time'  => date('Y-m-d H:i:s'),
                    //             'created_by'         => $this->staff_id
                    //         );

                    //         $insert_id = $this->attendance->addAbsentSmsLogMessage($smsLog);

                    //     }

                    // }

                    // $sub_name = $this->subject->getSubjectInfoById($subject_code);
                    // $timeID = $this->timetable->getTimeInfoByRowID($time_row_id);

                    // if($attendanceDate == $today_date){
                    //     $stdInfo = $this->student->getStudentByStudentId($student->student_id);
                    //     // $isAlreadyAdded = $this->sms->isSMSAlreadyAdded(date('Y-m-d',strtotime($attendanceDate)),$subject_code,$student->student_id,$subject_type);
                    //     $isAlreadyAdded = $this->sms->isSMSAlreadyAdded($student->student_id,$class_row_id);
                    //     if(empty($isAlreadyAdded)){
                    //          //FCM////////////
                    //         $notification_message = "Dear Parent,Your ward ".$student->student_name." was absent for the ".$subName->sub_name." class on ".date('d-m-Y',strtotime($attendanceDate))." between ".$timeID->start_time." to ".$timeID->end_time." .- ST ANNS COMPOSITE PU COLLEGE , MANGALURU";
                    //         $all_users_token = $this->push_notification_model->getSingleStudentsToken($student->student_id);
                    //         $tokenBatch = array_chunk($all_users_token,500);
                    //         for($itr = 0; $itr < count($tokenBatch); $itr++){
                    //             // $this->push_notification_model->sendMessage('Absent For Class',$notification_message,$tokenBatch[$itr],"student");
                    //             $this->pushNotification($tokenBatch[$itr],'Absent For Class',$notification_message,STUDENT_KEY_NAME);
                    //         }
                    //         //FCM///////////

                    //     // $primary_contact = $stdInfo->father_mobile;
                    //     // // $contactInfo = $this->sms->getParentContactInfo($stdInfo->application_no,$primary_contact);
                        
                    //     // if(strlen($primary_contact) == 10){
                    //     //     $parent_mobile = $primary_contact;
                    //     // }else{
                    //     //     $country_code = '91';
                    //     //     $mobileNo = preg_replace("/^\+?{$country_code}/", '',$primary_contact);
                    //     //     $parent_mobile = $mobileNo;
                    //     // }
                    //     // if ($timeID->start_time < 12 && $timeID->start_time >= 9) {
                    //     //     $time1 = "am";
                    //     // } else {
                    //     //     $time1 = "pm";
                    //     // }
                    //     // if ($timeID->end_time >= 12 || $timeID->end_time <= 9) {
                    //     //     $time2 = "pm";
                    //     // } else {
                    //     //     $time2 = "am";
                    //     // }
                    //     // $time = $timeID->start_time." ".$time1." to ".$timeID->end_time." ".$time2 ;
                    //     // $message = "Dear Parent, your ward is absent for ". $time ." Class On ".date('d-m-Y',strtotime($attendanceDate))." - Principal, Loyola Pre-University College, Vijayapura.";
                    //     // if(strlen($parent_mobile) == 10){
                    //     //     $result_sms = $this->sendAbsentSMS($parent_mobile, $message);
                    //     //     if($result_sms == 'success'){
    
                    //     //         $absentInfo = array(
                    //     //             'student_id' => $stdInfo->student_id,
                    //     //             // 'session_type' => $smsDetails->session_type,
                    //     //             'date' => date('Y-m-d',strtotime($attendanceDate)),	
                    //     //             'subject_code' => $subject_code,	
                    //     //             'subject_type' => $subject_type,
                    //     //             'class_row_id' => $class_row_id,
                    //     //             'created_by' => $this->staff_id,
                    //     //             'created_date_time' => date('Y-m-d H:i:s'),
                    //     //         );
                    //     //         $this->sms->addAbsentSMSInfo($absentInfo); 
                    //     //     }
                    //     // }
                    //  }
                    // }

                }
            }
            if($result > 0){
                echo 'true';
            }else{
                echo 'false';
            }
        }
    }

    
    public function viewAttendanceInfo() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {        
            $filter = array();
            // $searchTerm = $this->security->xss_clean($this->input->post('searchTerm'));
            $absentDate =$this->security->xss_clean($this->input->post('absentDate')); 
            $staff_name =$this->security->xss_clean($this->input->post('staff_name')); 
            $student_id =$this->security->xss_clean($this->input->post('student_id')); 
            $student_name =$this->security->xss_clean($this->input->post('student_name')); 
            $subject_id =$this->security->xss_clean($this->input->post('subject_id')); 
            $subject_type =$this->security->xss_clean($this->input->post('subject_type')); 
            $time = $this->security->xss_clean($this->input->post('time')); 
            $by_term = $this->security->xss_clean($this->input->post('by_term'));
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
            $by_Batch = $this->security->xss_clean($this->input->post('by_Batch'));
            if($this->role == ROLE_TEACHING_STAFF ){
                $filter['staff_id'] = $this->staff_id;
                $data['subjectInfo'] = $this->staff->getAllSubjectInfo($filter);
            }else{
                $data['subjectInfo'] = $this->subject->getAllSubjectInfo();
            }
            $data['timingsInfo'] = $this->settings->getAllClassTimingsInfo();
            $data['staffInfo'] = $this->staff->getDistinctSubjectInfo($filter);
            $data['streamInfo'] = $this->settings->getDistinctStreamInfo();

            if(!empty($absentDate)){
                $filter['absentDate'] = date('Y-m-d',strtotime($absentDate));
                $data['absentDate'] = date('d-m-Y',strtotime($absentDate));
            }else{
                $data['absentDate'] = '';
            }
            $data['staff_name'] = $staff_name;
            $data['student_id'] = $student_id;
            $data['student_name'] = $student_name;
            $data['by_term'] =  $by_term;
            $data['subject_id'] = $subject_id;
            $data['subject_type'] = $subject_type;
            $data['time'] = $time;
            $data['stream_name'] = $stream_name;
            $data['by_Batch'] = $by_Batch;

            $filter['staff_name'] = $staff_name;
            $filter['student_id'] = $student_id;
            $filter['student_name'] = $student_name;
            $filter['by_term']= $by_term;
            $filter['subject_id'] = $subject_id;
            $filter['subject_type'] = $subject_type;
            $filter['time'] = $time;
            $filter['stream_name'] = $stream_name;
            $filter['by_Batch'] = $by_Batch;
            $count = $this->attendance->viewAttendanceInfoCount($filter);
			$returns = $this->paginationCompress("viewAttendanceInfo/", $count, 100);
            $data['count_attendance'] = $count;
            $data['attendanceRecords'] = $this->attendance->getViewAttendanceInfo($filter, $returns["page"], $returns["segment"]);
             $data['accessInfo'] = $this->getCurrentAccess();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Attendance Management';
            $this->loadViews("attendance/viewAbsentInfo", $this->global, $data , NULL);
        }
    }

    
    public function deleteStudentAttendance(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $attendanceInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id);
            $result = $this->attendance->updateAttendanceInfo($row_id,$attendanceInfo);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    // class completed info
    public function viewClassCompletedInfo() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {        
            $filter = array();
            $classDate =$this->security->xss_clean($this->input->post('classDate')); 
            $staff_id =$this->security->xss_clean($this->input->post('staff_id')); 
            $subject_code =$this->security->xss_clean($this->input->post('subject_code')); 
            $subject_id =$this->security->xss_clean($this->input->post('subject_id')); 
            $subject_type =$this->security->xss_clean($this->input->post('subject_type')); 
            $time = $this->security->xss_clean($this->input->post('time')); 
            $by_term = $this->security->xss_clean($this->input->post('by_term'));
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
            $section_name = $this->security->xss_clean($this->input->post('section_name'));
            $filter['subject_code'] = '';
            $subjectCode = array();
            if($this->role == ROLE_TEACHING_STAFF ){
                $filter['staff_id'] = $this->staff_id;
                $staff_sub = $this->staff->getAllSubjectInfo($filter);
                $data['subjectInfo'] = $staff_sub;
                foreach($staff_sub as $sub){
                    array_push($subjectCode,$sub->subject_code);
                } 
                $filter['subjectCode'] = $subjectCode;
                $filter['subject_code'] = '';
            }else{
                $data['subjectInfo'] = $this->subject->getAllSubjectInfo();
                $subject_code = $subject_code;
                $filter['subject_code'] = $subject_code;
            }
            $data['timingsInfo'] = $this->settings->getAllClassTimingsInfo();
            $data['staffInfo'] = $this->staff->getAllSubjectInfo($filter);
            $data['streamInfo'] = $this->settings->getDistinctStreamInfo();

            if(!empty($classDate)){
                $filter['classDate'] = date('Y-m-d',strtotime($classDate));
                $data['classDate'] = date('d-m-Y',strtotime($classDate));
            }else{
                $data['classDate'] = '';
            }
            $data['staff_id'] = $staff_id;
            $data['subject_code'] = $subject_code;
            $data['by_term'] =  $by_term;
            $data['subject_id'] = $subject_id;
            $data['subject_type'] = $subject_type;
            $data['time'] = $time;
            $data['stream_name'] = $stream_name;
            $data['section_name'] = $section_name;

            $filter['by_term']= $by_term;
            $filter['subject_id'] = $subject_id;
            $filter['subject_type'] = $subject_type;
            $filter['time'] = $time;
            $filter['stream_name'] = $stream_name;
            $filter['section_name'] = $section_name;
            $filter['staffId'] = $staff_id;
            $count = $this->attendance->getAllClassCompletedInfoCount($filter);
			$returns = $this->paginationCompress("viewClassCompletedInfo/", $count, 100);
            $data['classCount'] = $count;
            $data['classRecord'] = $this->attendance->getAllClassCompletedInfo($filter, $returns["page"], $returns["segment"]);
            $data['accessInfo'] = $this->getCurrentAccess();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : My Class Completed';
            $this->loadViews("attendance/classCompleted", $this->global, $data , NULL);
        }
    }
    
    public function deleteClassCompleted(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $classCompletedInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id);
            $result = $this->attendance->updateClassCompletedInfo($row_id, $classCompletedInfo);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    
    // get staff assigned subject 
    public function getAssignedSubjectAttendance(){
        $staff_subject_row_id = $this->input->post("staff_subject_row_id");
        $filter['staff_subject_row_id'] = $staff_subject_row_id;
        $data['result'] = $this->attendance->getSubjectByRowId($filter);
        header('Content-type: text/plain'); 
        header('Content-type: application/json'); 
        echo json_encode($data);
        exit(0);
    }

    public function downloadAbsentedStudentInfo(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else
        {   
            set_time_limit(0);
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $section_name = $this->security->xss_clean($this->input->post('section_name')); 
            $date_from = $this->security->xss_clean($this->input->post('date_from'));
            $date_to = $this->security->xss_clean($this->input->post('date_to'));
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
           
            $sections = array($section_name);
            if(!empty($date_from) && !empty($date_to)){
                $date_description = $date_from .' To '. $date_to;
            }else{
                $date_description = "Upto Today Date";
            }

         
            // $stream = $this->student->getStreamNameBySectionAndTerm($term_name,$section_name);
            $filter = array();
            $filter['by_term'] = $term_name;
            $filter['stream_name'] = $stream_name;
            if(!empty($date_from)){
                $filter['absentDateFrom'] = date('Y-m-d',strtotime($date_from));
            }
            if(!empty($date_to)){
                $filter['absentDateTo'] = date('Y-m-d',strtotime($date_to));
            }
            if($section_name == 'ALL'){
                $filter['section_name'] = '';
            }else{
                $filter['section_name'] = $section_name;
            }
            // $subject_info_header = $this->getSubjectCodes($stream_name);
            $sheet = 0;
            $j=1;
            $excel_row = 6;
            $section_name = $sections[$sheet];
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle($stream_name);
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:H500');
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', $term_name.'-'.$stream_name." Attendance Report 2024-25");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:W1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->mergeCells('A1:H1');
            $this->excel->getActiveSheet()->mergeCells('A2:H2');


            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);


            

            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A4', 'SL. NO.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B4', 'Date');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C4', 'Student ID');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D4', 'Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E4', 'Section');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F4', 'Staff');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G4', 'Subject');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('H4', 'Time');

            $this->excel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setWrapText(true); 
            $this->excel->getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true); 
            $this->excel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $this->excel->getActiveSheet()->getStyle('A3:W4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
            $this->excel->getActiveSheet()->getStyle('A3:W4')->getFont()->setBold(true);
            
            $this->excel->getActiveSheet()->setCellValue('A3', "Report Date: ".$date_description);
            $this->excel->getActiveSheet()->mergeCells('A3:H3');

            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:H4')->applyFromArray($styleBorderArray);
            $this->excel->getActiveSheet()->getStyle('A5:H999')->applyFromArray($styleBorderArray);
           
            $students = $this->attendance->getAbsentedStudentInfo($filter);
            $excel_row = 5;
            foreach($students as $student){
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,date('d-m-Y',strtotime($student->absent_date)));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,$student->student_id);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,strtoupper($student->student_name));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,$student->section_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$student->staff_name);
                
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,$student->sub_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row,$student->start_time .'-'.$student->end_time);
                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':C'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('E'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('G'.$excel_row.':H'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
            }
        
            $filename='just_some_random_name.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            ob_start();
            $objWriter->save("php://output");
            $xlsData = ob_get_contents();
            ob_end_clean();

            $response =  array(
                'op' => 'ok',
                'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
            );
            die(json_encode($response));
            
        }
    }

    
    public function downloadClassCompletedReport(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {   
            set_time_limit(0);
            ini_set('memory_limit', '256M');
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $section_name = $this->security->xss_clean($this->input->post('section_name')); 
            $date_from = $this->security->xss_clean($this->input->post('date_from'));
            $date_to = $this->security->xss_clean($this->input->post('date_to'));
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
            $filter = array();
            $filter['term'] = $term_name;
            $filter['term_name'] = $term_name;
            $filter['preference'] = $stream_name;
            if(!empty($date_from)){
                $date_from = date('Y-m-d',strtotime($date_from));
            }
            if(!empty($date_to)){
                $filter['date_to'] = date('Y-m-d',strtotime($date_to));
            }
            // $stream = $this->timetable->getAssignedStreamInfo($filter)
            // if($section_name == 'ALL'){
            //     $sectionName = array('A','B','C','D','E','F','G','H','I','J');
            // }else{
                // $sectionName = $section_name;
            // }
            $filter['section_name'] = $section_name;
            
            $sections = array($section_name);
            if(!empty($date_from) && !empty($date_to)){
                $date_description = $date_from .' To '. $date_to;
            }else{
                $date_description = "Upto Today Date";
            }

            $class_held_cell_name = array("E","H","K","N","Q","T");
            $class_attended_cell_name = array("F","I","L","O","R","U");
            $class_percentage_cell_name = array("G","J","M","P","S","V");

            // $stream = $this->students_model->getStreamNameBySectionAndTerm($term_name,$section_name);
            $subject_info_header = $this->getSubjectCodes($stream_name);
            $sheet = 0;
            $j=1;
            $excel_row = 6;
            $class_section = $section_name[$sheet];
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle($stream_name);
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:W500');
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', $term_name.'-'. $stream_name.'-'.$section_name." Section Attendance Report 2024-25");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:W1');
            $this->excel->getActiveSheet()->mergeCells('A2:W2');
            $this->excel->getActiveSheet()->getStyle('A1:A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:W1')->getFont()->setBold(true);


            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(7);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(7);

            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(7);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(7);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(7);

            

            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL. NO.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Roll No');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'LAG');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('W3', 'OA.%');

            $this->excel->getActiveSheet()->getStyle('A3:G3')->getAlignment()->setWrapText(true); 
            $this->excel->getActiveSheet()->getStyle('A3:G3')->getFont()->setBold(true); 
            $this->excel->getActiveSheet()->getStyle('A3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


            $this->excel->getActiveSheet()->mergeCells('A3:A4');
            $this->excel->getActiveSheet()->mergeCells('B3:B4');
            $this->excel->getActiveSheet()->mergeCells('C3:C4');
            $this->excel->getActiveSheet()->mergeCells('D3:D4');

            $this->excel->getActiveSheet()->mergeCells('W3:W4');

            

            //first elective subject
            $this->excel->getActiveSheet()->mergeCells('E3:G3');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Language');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E4', 'CH');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F4', 'CA');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G4', 'A%');

            //english subject
            $this->excel->getActiveSheet()->mergeCells('H3:J3');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('H3', 'ENGLISH');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('H4', 'CH');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('I4', 'CA');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('J4', 'A%');
            $s=2;
            for($sub=0; $sub<count($subject_info_header); $sub++){
                $subject_name = $this->subject->getAllSubjectByID($subject_info_header[$sub]);
                $this->excel->getActiveSheet()->getColumnDimension($class_held_cell_name[$s])->setWidth(7);
                $this->excel->getActiveSheet()->getColumnDimension($class_attended_cell_name[$s])->setWidth(7);
                $this->excel->getActiveSheet()->getColumnDimension($class_percentage_cell_name[$s])->setWidth(7);
                $this->excel->getActiveSheet()->mergeCells($class_held_cell_name[$s].'3:'.$class_percentage_cell_name[$s].'3');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue($class_held_cell_name[$s].'3', $subject_name->sub_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue($class_held_cell_name[$s].'4', 'CH');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue($class_attended_cell_name[$s].'4', 'CA');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue($class_percentage_cell_name[$s].'4', 'A%');
            $s++;
            }
            $this->excel->getActiveSheet()->getStyle('A3:W4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
            $this->excel->getActiveSheet()->getStyle('A3:W4')->getFont()->setBold(true);
            
            $this->excel->getActiveSheet()->mergeCells('A5:W5');
            $this->excel->getActiveSheet()->getStyle('A5:W5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A5:W5')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->setCellValue('A5', "Report Date: ".$date_description);


            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:W4')->applyFromArray($styleBorderArray);

            // $students = $this->students_model->getStudentInfoBySectionTerm($term_name,$section_name);
            $students = $this->student->getStudentInfoForReportDownload($filter);
            // log_message('debug','dnd='.print_r($students,true));
           
            foreach($students as $student){
                $filter['doj'] = '';
                if(date('Y-m-d',strtotime($student->doj)) > date('Y-m-d',strtotime($date_from))){
                    $filter['doj'] = date('Y-m-d',strtotime($student->doj));
                } else{
                    $filter['doj'] = '';
                }
                // $filter['doj'] = $student->doj;
                // $section = $student->section_name;
                // $filter['section'] = $section;
                if(!empty($student->section_name)){
                    $filter['section'] = $student->section_name;
                }else{
                    $filter['section'] = 'ALL';
                }
                $subjects_code = array();
                $percentage_active = false;
                $elective_sub = strtoupper($student->elective_sub);
                $std_batch = $student->batch;
            
                if($elective_sub == 'KANNADA'){
                    array_push($subjects_code, '01');
                }else if($elective_sub == 'HINDI'){
                    array_push($subjects_code, '03');
                } else if($elective_sub == 'FRENCH'){
                    array_push($subjects_code, '12');
                }

                if(!empty($student->date_of_admission) || $student->date_of_admission != '0000-00-00' || $student->date_of_admission != '1970-01-01'){
                    $date_of_admission = $student->date_of_admission;
                }else{
                    $date_of_admission = $date_from;
                }
                // if($student->term_name == 'I PUC'){
                //     $filter['date_from'] = $date_of_admission;
                // }else{
                    $filter['date_from'] = $date_from;
                // }
                array_push($subjects_code, '02');
                $subjects = $this->getSubjectCodes($student->stream_name);
                $subjects_code = array_merge($subjects_code,$subjects);
                $total_class_held_per_std = 0;
                $total_attd_class_std = 0;
                $absentCount = 0;
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,$student->student_id);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,strtoupper($student->student_name));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,$elective_sub);
                for($i=0; $i < count($subjects_code); $i++)
                {
                    // if($student->term_name == 'I PUC' && $date_from == ""){
                    //     $date_from = $student->date_of_admission; 
                    // }
                    
                    $class_held = 0;
                    $class_held_lab  = 0;
                    $class_attended = 0;
                    $absent_count = 0;
                    $std_absent_count = 0;
                    $absent_count_theory = 0;
                    $absent_count_lab = 0;
                    $absent_countLab = 0;
                    $subInfo = $this->subject->getAllSubjectByID($subjects_code[$i]);
                   
                    $type="THEORY";
                    $filter['std_batch'] = '';
                    $class_held += $this->attendance->getClassInfoAttendanceReportStudent($subjects_code[$i],$filter,$type);
                    
                    $type="LAB";
                    $filter['std_batch'] = $std_batch;
                    $class_held_lab += $this->attendance->getClassInfoAttendanceReportStudent($subjects_code[$i],$filter,$type);

                    // if($class_held_lab != 0){
                        $class_held += ($class_held_lab * 2);
                    // }
                    // $data['classHeldDate'] = $this->attendance->getTotalClassHeldByStaff($subjects_code[$i],$filter,$type);
                    
                    // foreach($data['classHeldDate'] as $classdata){
                    $type="THEORY";
                    $absent_count_theory = $this->attendance->isStudentIsAbsentForClass($student->student_id,$subjects_code[$i],$filter,$type);
                    
                    // log_message('debug','absent_count_theory='.print_r($absent_count_theory,true));
                    $type="LAB";
                    $absent_count_lab = $this->attendance->isStudentIsAbsentForClass($student->student_id,$subjects_code[$i],$filter,$type);
                    $absent_countLab = $absent_count_lab * 2;

                    $std_absent_count = $absent_count_theory + $absent_countLab;
                    //     if($absent_count_theory != NULL){
                    //         $absent_count += 1;
                    //     }
                    
                    // }
                
                    
                    //no change
                    $total_class_held_per_std += $class_held;
                    $absent_count = $class_held - $std_absent_count;
                    $absentCount += $std_absent_count;
                    $total_attd_class_std = $absentCount;
                    
                    if($class_held != 0){
                        $avg = ($absent_count)/$class_held;
                        $percentage = round($avg*100, 2);
                    }else{
                        $percentage = 0;
                    }
                    if(!empty($percentage_sort)){
                        if($percentage <= $percentage_sort){
                            $percentage_active = true;
                        }
                    }
                    //writing result to excel cell
                    
                    if($percentage < 85){
                        $this->cellColor($class_held_cell_name[$i].$excel_row, 'FFEE58');
                        $this->cellColor($class_attended_cell_name[$i].$excel_row, 'FFEE58');
                        $this->cellColor($class_percentage_cell_name[$i].$excel_row, 'FFEE58');
                    }
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($class_held_cell_name[$i].$excel_row,$class_held);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($class_attended_cell_name[$i].$excel_row,$absent_count);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($class_percentage_cell_name[$i].$excel_row,$percentage);
                        
                }
                //total subject percentage
            
                if($total_class_held_per_std != 0){
                    $avg = ($total_class_held_per_std-$total_attd_class_std)/$total_class_held_per_std;
                    $percentage = round($avg*100, 2);
                }else{
                    $percentage = 0;
                }
                
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('W'.$excel_row,$percentage);
                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':W'.$excel_row)->applyFromArray($styleBorderArray);
                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':B'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('D'.$excel_row.':W'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                if(!empty($percentage_sort)){
                    if($percentage_active == true){
                        $excel_row++;
                    }else{
                        $this->excel->getActiveSheet()->removeRow($excel_row);
                    }
                }else{
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('W'.$excel_row,$percentage);
                    $excel_row++;
                }
                
                
            }
            
            $filename='just_some_random_name.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            ob_start();
            $objWriter->save("php://output");
            $xlsData = ob_get_contents();
            ob_end_clean();

            $response =  array(
                'op' => 'ok',
                'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
            );
            die(json_encode($response));
            
        }
    }

    
    public function cellColor($cells,$color){
        return $this->excel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $color
            )
        ));
    }


    
    // verify attendance
    public function verifyStudentAttendance(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $data['timingsInfo'] = $this->settings->getAllClassTimingsInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Verify Attendance';
            $this->loadViews("attendance/verifyAbsentStudent", $this->global, $data, null);
        }
    }

    public function getStudentInfoToVerifyAttendance(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $filter = array();
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $section_name = $this->security->xss_clean($this->input->post('section_name'));
            $attendance_date = $this->security->xss_clean($this->input->post('attendance_date'));
            // $weekname = date('l', strtotime($attendanceDate));

            $attendanceDate = date('Y-m-d',strtotime($attendance_date));
            if(!empty($attendance_date)){
                $filter['attendance_date'] = $attendanceDate;
                $data['attendance_date'] = date('d-m-Y',strtotime($attendance_date));
            }else{
                $data['attendance_date'] = '';
            }


            $filter['section_row_id'] = $section_name;
            $sectionInfo = $this->attendance->getSectionInfoByRowId($filter);
            $sectionName = $sectionInfo->section_name;
            $stream_name = $sectionInfo->stream_name;

            $filter['term_name'] = $term_name;
            if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
            }
            $filter['stream_name'] = $stream_name;
            if($sectionName == "ALL"){
                $filter['section_name'] = '';
            }else{
                $filter['section_name'] = $sectionName;
            }

            $data['termInfo'] = $this->staff->getSectionById($filter);
            
            $data['term_name'] = $term_name;
            $data['stream_name'] = $stream_name;
            $data['section_name'] = $sectionName;
            $data['stream_name'] = $stream_name;
            $data['staff_id'] = $this->staff_id;
            $data['section_row_id'] = $sectionInfo->row_id;
            
            $data['classInfo'] = $this->attendance->getClassSectionInfoForAttendance($term_name,$sectionName,$attendanceDate);
            // log_message('debug','cdjcd'.print_r($data['classInfo'],true));
            $data['studentRecord'] = $this->student->getStudentInfoForInternal($filter);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Attendance Details';
            $this->loadViews("attendance/verifyAbsentStudent", $this->global, $data, null);
        }   
    }

    
    public function confirmStudentVerifyAttendance(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $result = 1;
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
            $section_name = $this->security->xss_clean($this->input->post('section_name'));
            $section_row_id = $this->security->xss_clean($this->input->post('section_row_id'));
            $attendance_date = $this->security->xss_clean($this->input->post('attendance_date'));
            $data['term_name']=$term_name;
            $data['section_name']=$section_name;
            $data['stream_name']=$stream_name;
            $data['section_row_id']=$section_row_id;

            // $data['attendance_date']= $attendanceDate; 
            $attendanceDate = date('Y-m-d',strtotime($attendance_date));
            if(!empty($attendance_date)){
                $filter['attendance_date'] = $attendanceDate;
                $data['attendance_date'] = date('d-m-Y',strtotime($attendance_date));
            }else{
                $data['attendance_date'] = '';
            }
            
            $filter['term_name'] = $term_name;
            if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
            }
            $filter['stream_name'] = $stream_name;
            $filter['section_name'] = $section_name;
            $filter['section_row_id'] = $section_row_id;


            $data['studentRecord'] = $this->student->getStudentInfoForInternal($filter);
            $data['todaySectionClass'] = $this->attendance->getClassSectionInfoForAttendance($term_name,$section_name,$attendanceDate);
            // log_message('debug','cdjcd'.print_r($filter,true));
            foreach($data['studentRecord'] as $student){
                foreach($data['todaySectionClass'] as $class){
                    $staffSubjectInfo = $this->attendance->getStaffSubjectRowId($class->staff_id,$class->subject_code,$class->subject_type);
                    $absentStatus = $this->input->post($student->student_id.$section_row_id.$class->time_id.$staffSubjectInfo->row_id);
                    if($absentStatus == 'true'){
                        $attendanceInfo = array (
                            'class_section_row_id' => $section_row_id,
                            'staff_subject_row_id' => $staffSubjectInfo->row_id,
                            'class_row_id' => $class->row_id,
                            'student_id' => $student->student_id,
                            'subject_code' => $class->subject_code,
                            'absent_date' => date("Y-m-d", strtotime($attendanceDate)),
                            'time_row_id' => $class->time_id,
                            'student_batch' => $class->batch,
                            'year' => CURRENT_YEAR,
                            'sms_sent_status' => 0,
                            'office_verified_status' => 1,
                            'created_by' => $this->staff_id,
                            'created_date_time' => date('Y-m-d H:i:s'));
                        $isAttendanceExist = $this->attendance->checkStudentAttendanceAlreadyExist($student->student_id,$section_row_id,date("Y-m-d", strtotime($attendanceDate)),$class->time_id,$staffSubjectInfo->row_id,$class->subject_code);
                        if($isAttendanceExist == NULL){
                            $result =  $this->attendance->addAbsentStudentInfo($attendanceInfo);
                        }else if($isAttendanceExist->office_verified_status == 0){
                            $attendanceUpdateInfo = array (
                                'updated_by' =>$this->staff_id,
                                'sms_sent_status' => 0,
                                'office_verified_status' => 1,
                                'updated_date_time' => date('Y-m-d H:i:s')
                            );   
                            $result = $this->attendance->updateAttendanceInfo($isAttendanceExist->row_id,$attendanceUpdateInfo);
                        }
                        //FCM////////////
                        // $sub_name = $this->subject->getSubjectInfoById($class->subject_code);
                        // $message = 'Your ward is absent for '.$sub_name->name.' on '.date("Y-m-d", strtotime($attendanceDate));
                        // $all_users_token = $this->push_notification_model->getSingleStudentsToken($student->student_id);
                        // $tokenBatch = array_chunk($all_users_token,500);
                        // for($itr = 0; $itr < count($tokenBatch); $itr++){
                        //     $this->push_notification_model->sendMessage('Absent For Class',$message,$tokenBatch[$itr],"student");
                        // }
                        //FCM///////////

                    }else{
                        $isAttendanceExist = $this->attendance->checkStudentAttendanceAlreadyExist($student->student_id,$section_row_id,date("Y-m-d", strtotime($attendanceDate)),$class->time_id,$staffSubjectInfo->row_id,$class->subject_code);
                        if($isAttendanceExist != NULL){
                            $attendanceUpdateInfo = array (
                                'updated_by' =>$this->staff_id,
                                'is_deleted' => 1,
                                'updated_date_time' => date('Y-m-d H:i:s')
                            );   
                            $result = $this->attendance->updateAttendanceInfo($isAttendanceExist->row_id,$attendanceUpdateInfo);
                        
                        }
                    }

                }
            }
            if ($result > 0) {
                $this->session->set_flashdata('success', 'Attendance Added Successfully');
            } else {
                $this->session->set_flashdata('error', 'Attendance update failed');
            }
            $data['studentRecord'] = $this->student->getStudentInfoForInternal($filter);
            $data['classInfo'] = $this->attendance->getClassSectionInfoForAttendance($term_name,$section_name,$attendanceDate);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Attendance Details';
            $this->loadViews("attendance/verifyAbsentStudent", $this->global, $data, null);
        }
    }



    public function sendAbsentSMS($mobile, $msg)
    {

        $message = rawurlencode($msg);
        $data = "username=" . USERNAME_TEXTLOCAL . "&hash=" . HASH_TEXTLOCAL . "&message=" . $message . "&sender=" . SENDERID_TEXTLOCAL . "&numbers=" . $mobile;
        $ch = curl_init('https://api.textlocal.in/send/?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result_sms = curl_exec($ch); // This is the result from the API

        $json = json_decode($result_sms, true);
        // log_message('error', 'JSON=' . print_r($json, true));
        $status = $json['status'];

        // log_message('error', 'RESULT API'.$message);
        curl_close($ch);
        return $status;
    }
    
    
    
    public function getSubjectCodes($stream_name){
        //science
        $PCMB = array("33", "34", "35", '36');
        $PCMC = array("33", "34", "35", '41');
        $PCME = array("33", "34", "35", '40');
        $PCMS = array("33", "34", "35", '31');
        $PCBH = array("33", "34", "36", '67');
        //commarce
        $BEBA = array("75", "22", "27", '30');
        $BSBA = array("75", "31", "27", '30');
        $CSBA = array("41", "31", "27", '30');
        $SEBA = array("31", "22", "27", '30');
        $CEBA = array("41", "22", "27", '30');
        //art
        $HEPP = array("21", "22", "32", '29');
        $HEPS = array("21", "22", "29", '28');

        $PEBA = array("29", "22", "27", '30');
        $MEBA = array("75", "22", "27", '30');
        $MSBA = array("75", "31", "27", '30');
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
            case "PCBH":
                return $PCBH;
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
            case "HEBA":
                return $HEBA;
                break;
            case "MEBA":
                return $MEBA;
                break;
            case "MSBA":
                return $MSBA;
                break;
            case "PEBA":
                return $PEBA;
                break;
            case "EBAC":
                return $EBAC;
                break;
            case "HEBA":
                return $HEBA;
                break;
        }
    }

    public function getClassAttendanceDetails(){

        if($this->isAdmin() == TRUE) {

            $this->loadThis();

        } else {

            $filter = array();

            $attendance_date = $this->security->xss_clean($this->input->post('attendance_date'));

            $todayDate = date('Y-m-d');

            $weekname = date('l', strtotime($todayDate));

            if(!empty($attendance_date)){

                $data['attendance_date'] = date('d-m-Y',strtotime($attendance_date));

                $filter['attendance_date'] = date('l',strtotime($attendance_date));

                $data['attendanceDate']= date('d-m-Y', strtotime($attendance_date));

                $filter['search_date'] = date('Y-m-d',strtotime($attendance_date));

            }else{

                $data['attendance_date'] = '';

                $data['attendanceDate']= date('d-m-Y', strtotime($todayDate));

                $filter['weekName'] = $weekname;

                $filter['search_date'] = date('Y-m-d');

            }

            

            if($this->role == ROLE_TEACHING_STAFF){

                $filter['staff_id'] = $this->staff_id;

                $data['staff_id'] = $this->staff_id;

            }else{

                $data['staff_id'] = '';

            }


            $data['timingsInfo'] = $this->settings->getAllClassTimingsInfo();

            $data['staffSubjectInfo'] = $this->staff->getAllSubjectInfo($filter);

          

            $data['classCompletedInfo'] = $this->attendance->getAttendanceClassCompletedInfo();

            $accessInfo = $this->getCurrentAccess();
            if(isset($accessInfo) && $accessInfo->super_access==1){
                $data['termInfo'] = $this->attendance->getAllClassTeacherClasses();
            } else {
                // ONLY CLASS TEACHER CLASSES
                $data['termInfo'] = $this->attendance->getClassTeacherClasses($this->staff_id);
            }


            $this->global['pageTitle'] = ''.TAB_TITLE.' : Attendance Details';

            $this->loadViews("classTeacherAttendance/attendance", $this->global, $data, NULL);

        }

    }

    public function getClassTeacherStudentsForAttendance(){

        if($this->isAdmin() == TRUE) {

            $this->loadThis();

        } else {

            $filter = array();

            $term_name = $this->security->xss_clean($this->input->post('term_name'));

            $subject_name = $this->security->xss_clean($this->input->post('subject_name'));

            $section_name = $this->security->xss_clean($this->input->post('section_name'));

            $attendance_date = $this->security->xss_clean($this->input->post('attendance_date'));

            $session = $this->security->xss_clean($this->input->post('session'));

            $termInfo = $this->attendance->getTermDetailsBySection($term_name);

            $filter['term_name'] = $termInfo->term_name;

            $filter['stream_name'] = $termInfo->stream_name;

            $filter['section_name'] = $termInfo->section_name;

            $data['session'] = $session;

            $data['attendance_date'] = $attendance_date;

            $data['termName'] = $termInfo->term_name.' - '.$termInfo->stream_name.' - '.$termInfo->section_name;

            $data['term_name'] = $termInfo->term_name;

            $data['stream_name'] = $termInfo->stream_name;

            $data['section_name'] = $termInfo->section_name;

            $data['staff_id'] = $this->staff_id;

            $data['studentRecord'] = $this->student->getStudentInfoForAttendenceList($filter);

            $accessInfo = $this->getCurrentAccess();
            if(isset($accessInfo) && $accessInfo->super_access==1){
                $data['termInfo'] = $this->attendance->getAllClassTeacherClasses();
            } else {
                // ONLY CLASS TEACHER CLASSES
                $data['termInfo'] = $this->attendance->getClassTeacherClasses($this->staff_id);
            }

            $data['classCompletedInfo'] = $this->attendance->checkClassCompletedInfoBasedOnSession(date('Y-m-d',strtotime($attendance_date)),$termInfo->term_name,$termInfo->section_name,$termInfo->stream_name,$session);

            $this->global['pageTitle'] = ''.TAB_TITLE.' : Attendance Details';

            $this->loadViews("classTeacherAttendance/takeAttendance", $this->global, $data, NULL);

        }

    }

    public function addClassTeacherAttendanceByStaff(){

        if ($this->isAdmin() == true) {

            $this->loadThis();

        } else {

            $filter = array();

            $attInfo = json_decode(stripslashes($this->input->post('attInfo')));

            $students = array();

            foreach($attInfo as $info){

                if($info->name == 'attendance_date'){
                    $attendance_date = $info->value;
                }
              
                if($info->name == 'term_name'){
                    $term_name = $info->value;
                }

                if($info->name == 'section_name'){
                    $section_name = $info->value;
                }

                if($info->name == 'stream_name'){
                    $stream_name = $info->value;
                }

                if($info->name == 'session'){
                    $session = $info->value;
                }

                if($info->value == true){
                    $students[$info->name] = $info->name;
                }
            }

            $attendanceDate = date("Y-m-d", strtotime($attendance_date));

            $filter['term_name'] = $term_name;

            $filter['admission_no'] = $students;

            $filter['section_name'] = $section_name;

            $filter['stream_name'] = $stream_name;
            
            $filter['session'] = $session;
            
            $isExistsClass = $this->attendance->getClassTeacherClassCompletedInfo($attendanceDate,$this->staff_id,$term_name,$section_name,$stream_name,$session);

            if($isExistsClass == NULL){

                $subInfo = array(

                    'date' => $attendanceDate,

                    'staff_id' => $this->staff_id,

                    'session' => $session,

                    'term_name' => $term_name,

                    'section_name' => $section_name,

                    'stream_name' => $stream_name,

                    'staff_updated_status' => 1,

                    'created_date_time' => date('Y-m-d H:i:s'),

                    'created_by' => $this->staff_id);

                $result = $this->attendance->addClassTeacherAttendanceInfo($subInfo);

                $class_row_id = $result;

            }else{

                $subInfo = array(

                    'term_name' =>$term_name,

                    'session' => $session,

                    'section_name' =>$section_name,

                    'stream_name' => $stream_name,

                    'updated_date_time' => date('Y-m-d H:i:s'),

                    'updated_by' => $this->staff_id);

                $result = $this->attendance->updateClassTeacherAttendanceInfo($this->staff_id,$attendanceDate,$subInfo,$term_name,$section_name,$stream_name,$session);

                $class_row_id = $isExistsClass->row_id;

            }

            $this->attendance->deleteAttendanceStudents($attendanceDate,$term_name,$section_name,$stream_name,$session);       

            $data['studentRecords'] = $this->student->getStudentInfoForAttendenceList($filter);

            //$this->attendance->getStudentInfoForAttendance($filter);
            $registerNos=array();

            foreach($data['studentRecords'] as $student){

                if($students[$student->row_id] == $student->row_id){

                    $stdInfo = $this->student->getStudentDetailsInfo($student->row_id);

                    $attendanceInfo = array (

                        'class_row_id' => $class_row_id,

                        'term_name' => $term_name,

                        'section_name' => $section_name,

                        'stream_name' => $stream_name,

                        'student_id' => $student->row_id,

                        'absent_date' => $attendanceDate,

                        'office_verified_status' => 0,

                        'session' => $session,

                        'created_by' => $this->staff_id,

                        'created_date_time' => date('Y-m-d H:i:s'));

                    $result =  $this->attendance->addAbsentAttendanceInfo($attendanceInfo);
                    array_push($registerNos,$student->row_id);
                    
                    if($result > 0) {
                        $numbers = [];
                        if (!empty($stdInfo->father_mobile)) {
                            $numbers[] = trim($stdInfo->father_mobile);
                        }
                        if (!empty($stdInfo->mother_mobile)) {
                            $numbers[] = trim($stdInfo->mother_mobile);
                        }

                        $date = date("d-m-Y", strtotime($attendance_date));
                        $message = "Dear Parent, your ward is absent for the ".$session." on ".$date." - Regards Principal, St Anns PUC Mangalore";
                        $templateId = '1007704114891939561';
                        $result_sms = $this->AirtelSMS($numbers, $message,$templateId);
                        
                        if(trim(strtolower($result_sms)) == 'success'){

                            $smsLog = array(
                                'student_id'         => $student->row_id,
                                // 'subject_code'       => $subject_code,
                                'class_row_id'       => $class_row_id,
                                'mobile_no'          => implode(',', $numbers),
                                'message'            => $message,
                                'msg_type'           => 'Absent Sms',
                                'status'             => 'SUCCESS',
                                'created_date_time'  => date('Y-m-d H:i:s'),
                                'created_by'         => $this->staff_id
                            );

                            $insert_id = $this->attendance->addAbsentSmsLogMessage($smsLog);

                        }

                    }

                }

            }

            if($result > 0){
                // $this->absentStudentNotification($registerNos,$session,$attendanceDate);
                echo 'true';

            }else{

                echo 'false';

            }

        }

    }

    function absentStudentNotification($admissionNos,$session,$attendanceDate){
        $title = 'Absent For Class';
        $attachmentURL = '';
            //FCM////////////
            for($i=0;$i<count($admissionNos);$i++){
                $std  = $this->student->getStudentInfoByStudentIdAttendance($admissionNos[$i]);
                // $body = 'Your ward '.$std->student_name.' is absent for '.$session.' class on '.date('d-m-Y');
                if($attendanceDate == date('Y-m-d')){
                  $body = 'Dear Parents, Your ward '.$std->student_name.', is absent on '.date('d-m-Y').' during the '.$session.'.';
                }else{
                  $body = 'Dear Parents, Your ward '.$std->student_name.', was absent on '.date('d-m-Y',strtotime($attendanceDate)).' during the '.$session.'.';
                }
                $all_users_token = $this->push_notification_model->getSingleStudentsToken($admissionNos[$i]);
                // log_message('debug','$all_users_token -->'.print_r($all_users_token,true));
                // $this->sendNotifications($all_users_token, $title, $body, STAFF_SERVICE_ACCOUNT_PATH, STAFF_FIREBASE_APP_ID);
                $tokenBatch = array_chunk($all_users_token,500);
                for($itr = 0; $itr < count($tokenBatch); $itr++){
                    $this->pushNotification($tokenBatch[$itr],$title,$body,'/myAttendance');
                }
            }
            //FCM///////////
    }

    public function getClassTeacherAbsentDetails() {

        if($this->isAdmin() == TRUE) {

            $this->loadThis();

        } else {        

            $filter = array();

            // $searchTerm = $this->security->xss_clean($this->input->post('searchTerm'));

            $absentDate =$this->security->xss_clean($this->input->post('absentDate'));  

            $student_id =$this->security->xss_clean($this->input->post('student_id')); 

            $by_name =$this->security->xss_clean($this->input->post('by_name'));

            $by_term = $this->security->xss_clean($this->input->post('by_term'));

            $section_name = $this->security->xss_clean($this->input->post('section_name'));

            $session_name = $this->security->xss_clean($this->input->post('session_name'));

            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));

            $date_to = $this->input->post('date_to');
            $date_from = $this->input->post('date_from');

            if (empty($date_from)) {
                $filter['date_from'] = date('Y-m-01');
                $data['date_from'] = date('d-m-Y', strtotime($filter['date_from']));
            } else {
                $filter['date_from'] = date('Y-m-d', strtotime($date_from));
                $data['date_from'] = date('d-m-Y', strtotime($date_from));
            }

            if (empty($date_to)) {
                $filter['date_to'] = date('Y-m-d');
                $data['date_to'] = date('d-m-Y');
            } else {
                $filter['date_to'] = date('Y-m-d', strtotime($date_to));
                $data['date_to'] = date('d-m-Y', strtotime($date_to));
            }
            
            if(!empty($absentDate)){

                $filter['absentDate'] = date('Y-m-d',strtotime($absentDate));

                $data['absentDate'] = date('d-m-Y',strtotime($absentDate));

            }else{

                $data['absentDate'] = '';

            }

            if($this->role == ROLE_TEACHING_STAFF){

                $filter['staff_id'] = $this->staff_id;

            }

            $data['student_id'] = $student_id;

            $data['by_term'] =  $by_term;

            $data['section_name'] = $section_name;

            $data['session_name'] = $session_name;

            $data['stream_name'] = $stream_name;

            $data['by_name'] =  $by_name;

            $filter['student_id'] = $student_id;

            $filter['by_term']= $by_term;

            $filter['section_name'] = $section_name;

            $filter['session_name'] = $session_name;

            $filter['stream_name'] = $stream_name;

            $filter['by_name'] = $by_name;

            $count = $this->attendance->getClassTeacherAttendanceInfoCount($filter);

			$returns = $this->paginationCompress("getClassTeacherAbsentDetails/", $count, 100);

            $data['count_attendance'] = $count;

            $data['attendanceRecords'] = $this->attendance->getClassTeacherAttendanceInfo($filter, $returns["page"], $returns["segment"]);

            $data['streamInfo'] = $this->student->getAllStreamName();

            $this->global['pageTitle'] = ''.TAB_TITLE.' : Attendance Management';

            $this->loadViews("classTeacherAttendance/viewAbsentInfo", $this->global, $data , NULL);

        }

    }

    public function deleteAbsentAttendance(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $attendanceInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id);
            $result = $this->attendance->updateAbsentAttendanceInfo($row_id,$attendanceInfo);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function viewClassTeacherClassCompletedInfo() {

        if($this->isAdmin() == TRUE) {

            $this->loadThis();

        } else {        

            $filter = array();

            $classDate =$this->security->xss_clean($this->input->post('classDate')); 

            $staff_id =$this->security->xss_clean($this->input->post('staff_id')); 

            $subject_code =$this->security->xss_clean($this->input->post('subject_code')); 

            $subject_id =$this->security->xss_clean($this->input->post('subject_id')); 

            $subject_type =$this->security->xss_clean($this->input->post('subject_type')); 

            $time = $this->security->xss_clean($this->input->post('time')); 

            $by_term = $this->security->xss_clean($this->input->post('by_term'));

            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));

            $section_name = $this->security->xss_clean($this->input->post('section_name'));

            $session_name = $this->security->xss_clean($this->input->post('session_name'));

            $date_to = $this->input->post('date_to');
            $date_from = $this->input->post('date_from');

            if (empty($date_from)) {
                $filter['date_from'] = date('Y-m-01');
                $data['date_from'] = date('d-m-Y', strtotime($filter['date_from']));
            } else {
                $filter['date_from'] = date('Y-m-d', strtotime($date_from));
                $data['date_from'] = date('d-m-Y', strtotime($date_from));
            }

            if (empty($date_to)) {
                $filter['date_to'] = date('Y-m-d');
                $data['date_to'] = date('d-m-Y');
            } else {
                $filter['date_to'] = date('Y-m-d', strtotime($date_to));
                $data['date_to'] = date('d-m-Y', strtotime($date_to));
            }

          
            if($this->role == ROLE_TEACHING_STAFF){

                $filter['staff_id'] = $this->staff_id;

            }

            $data['timingsInfo'] = $this->settings->getAllClassTimingsInfo();

            $data['staffInfo'] = $this->staff->getAllSubjectInfo($filter);

            $data['streamInfo'] = $this->student->getAllStreamName();

            if(!empty($classDate)){

                $filter['classDate'] = date('Y-m-d',strtotime($classDate));

                $data['classDate'] = date('d-m-Y',strtotime($classDate));

            }else{

                $data['classDate'] = '';

            }

            $data['staff_id'] = $staff_id;

            $data['subject_code'] = $subject_code;

            $data['by_term'] =  $by_term;

            $data['subject_id'] = $subject_id;

            $data['subject_type'] = $subject_type;

            $data['time'] = $time;

            $data['stream_name'] = $stream_name;

            $data['section_name'] = $section_name;

            $data['session_name'] = $session_name;



            $filter['by_term']= $by_term;

            $filter['subject_id'] = $subject_id;

            $filter['subject_type'] = $subject_type;

            $filter['time'] = $time;

            $filter['stream_name'] = $stream_name;

            $filter['section_name'] = $section_name;

            $filter['session_name'] = $session_name;

            $filter['staffId'] = $staff_id;

            $count = $this->attendance->getTeacherClassCompletedInfoCount($filter);

			$returns = $this->paginationCompress("viewClassTeacherClassCompletedInfo/", $count, 100);

            $data['classCount'] = $count;

            $data['classRecord'] = $this->attendance->getTeacherClassCompletedInfo($filter, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = ''.TAB_TITLE.' : My Class Completed';

            $this->loadViews("classTeacherAttendance/classCompleted", $this->global, $data , NULL);

        }

    }

    public function deleteAbsentClassCompleted(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $classCompletedInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id);
            $result = $this->attendance->deleteAbsentClassCompleted($row_id, $classCompletedInfo);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function downloadClassAbsentedStudentInfo()
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {

            set_time_limit(0);

            $term_name    = $this->security->xss_clean($this->input->post('term_name'));
            $section_name = $this->security->xss_clean($this->input->post('section_name'));
            $date_from    = $this->security->xss_clean($this->input->post('date_from'));
            $date_to      = $this->security->xss_clean($this->input->post('date_to'));
            $stream_name  = $this->security->xss_clean($this->input->post('stream_name'));

            if(!empty($date_from) && !empty($date_to)){
                $date_description = $date_from.' To '.$date_to;
            } else {
                $date_description = "Upto Today Date";
            }

            $filter = array();
            $filter['by_term']      = $term_name;
            $filter['stream_name']  = $stream_name;
            $filter['section_name'] = $section_name;

            if(!empty($date_from)){
                $filter['absentDateFrom'] = date('Y-m-d', strtotime($date_from));
            }
            if(!empty($date_to)){
                $filter['absentDateTo'] = date('Y-m-d', strtotime($date_to));
            }

            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Absent Report');
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:H500');

            // Title rows
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', $term_name.' - '.$stream_name.' Absent Attendance Report');
            $this->excel->getActiveSheet()->setCellValue('A3', "Report Date: ".$date_description);

            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->getStyle('A1:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:H4')->getFont()->setBold(true);

            $this->excel->getActiveSheet()->mergeCells('A1:H1');
            $this->excel->getActiveSheet()->mergeCells('A2:H2');
            $this->excel->getActiveSheet()->mergeCells('A3:H3');

            // Column widths
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(29);

            // Header row
            $this->excel->getActiveSheet()->setCellValue('A4', 'SL. NO.');
            $this->excel->getActiveSheet()->setCellValue('B4', 'Date');
            $this->excel->getActiveSheet()->setCellValue('C4', 'Student ID');
            $this->excel->getActiveSheet()->setCellValue('D4', 'Name');
            $this->excel->getActiveSheet()->setCellValue('E4', 'Term');
            $this->excel->getActiveSheet()->setCellValue('F4', 'Stream');
            $this->excel->getActiveSheet()->setCellValue('G4', 'Section');
            $this->excel->getActiveSheet()->setCellValue('H4', 'Staff');

            $styleBorderArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
            $this->excel->getActiveSheet()->getStyle('A1:H999')->applyFromArray($styleBorderArray);

            // Data rows
            $students   = $this->attendance->getClassTeacherAbsentedStudentInfo($filter);
            $excel_row  = 5;
            $sl_no      = 1;

            foreach($students as $student){
                $this->excel->getActiveSheet()->setCellValue('A'.$excel_row, $sl_no++);
                $this->excel->getActiveSheet()->setCellValue('B'.$excel_row, date('d-m-Y', strtotime($student->absent_date)));
                $this->excel->getActiveSheet()->setCellValue('C'.$excel_row, $student->student_id);
                $this->excel->getActiveSheet()->setCellValue('D'.$excel_row, $student->student_name);
                $this->excel->getActiveSheet()->setCellValue('E'.$excel_row, $student->term_name);
                $this->excel->getActiveSheet()->setCellValue('F'.$excel_row, $student->stream_name);
                $this->excel->getActiveSheet()->setCellValue('G'.$excel_row, $student->section_name);
                $this->excel->getActiveSheet()->setCellValue('H'.$excel_row, $student->staff_name);

                $excel_row++;
            }

            ob_end_clean();

            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            $objWriter->save('php://output');
            $xlsData = ob_get_clean();

            $response = array(
                'op'   => 'ok',
                'file' => 'data:application/vnd.ms-excel;base64,'.base64_encode($xlsData)
            );

            die(json_encode($response));
        }
    }

        public function downloadClassTeacherClassCompleted() {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            set_time_limit(0);
    
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $section_name = $this->security->xss_clean($this->input->post('section_name')); 
            $stream_name = $this->security->xss_clean($this->input->post('stream_name')); 
            $date_from = $this->security->xss_clean($this->input->post('date_from'));
            $date_to = $this->security->xss_clean($this->input->post('date_to'));
            
            $date_description = (!empty($date_from) && !empty($date_to)) ? $date_from . ' To ' . $date_to : "Upto Today Date";
            
            $filter = array(
                'term_name' => $term_name,
                'section_name' => $section_name,
                'stream_name' => $stream_name,
            );
            
            if (!empty($date_from)) {
                $filter['absentDateFrom'] = date('Y-m-d', strtotime($date_from));
            }else{
                $filter['absentDateFrom'] = 'Y-m-01';
            }
            if (!empty($date_to)) {
                $filter['absentDateTo'] = date('Y-m-d', strtotime($date_to));
            }else{
                $filter['absentDateTo'] = date('Y-m-d');
            }
    
            $this->excel->setActiveSheetIndex(0);
            $sheet = $this->excel->getActiveSheet();
            $sheet->setTitle('Class Completed Report');
            $sheet->getPageSetup()->setPrintArea('A1:H500');
    
            $sheet->setCellValue('A1', EXCEL_TITLE)
                ->setCellValue('A2', "$term_name - Class Completed Report".EXCEL_YEAR)
                ->setCellValue('A3', "Report Date: $date_description")
                ->mergeCells('A1:G1')
                ->mergeCells('A2:G2')
                ->mergeCells('A3:G3')
                ->getStyle('A1')->getFont()->setSize(18);
            
            $sheet->getStyle('A2')->getFont()->setSize(14);
            $sheet->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:W1')->getFont()->setBold(true);
            
            $sheet->getColumnDimension('A')->setWidth(8);
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('C')->setWidth(30);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(15);
            
            $sheet->setCellValue('A4', 'SL. NO.')
                ->setCellValue('B4', 'Student ID')
                ->setCellValue('C4', 'Name')
                ->setCellValue('D4', 'Section')
                ->setCellValue('E4', 'Class Held')
                ->setCellValue('F4', 'Class Attended')
                ->setCellValue('G4', 'Percentage');
    
            $sheet->getStyle('A3:G3')->getAlignment()->setWrapText(true); 
            $sheet->getStyle('A3:G3')->getFont()->setBold(true); 
            $sheet->getStyle('A3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A3:W4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A3:W4')->getFont()->setBold(true);
    
            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $sheet->getStyle('A1:G4')->applyFromArray($styleBorderArray);
            $sheet->getStyle('A5:G999')->applyFromArray($styleBorderArray);
    
            $students = $this->student->getStudentInfoForAttendenceList($filter);
            $excel_row = 5;
            $j = 1;
    
            foreach ($students as $student) {
                $section_name = !empty($student->section_name) ? $student->section_name : 'ALL';
                $totalClass = $this->attendance->getClassCompletedByTermSectionDateWise($student->term_name, $section_name, $student->stream_name,$filter['absentDateFrom'], $filter['absentDateTo']);
                $totalAbsent = $this->attendance->getTotalAbsentByRegNoDate($student->row_id, $student->term_name, $section_name, $student->stream_name, $filter['absentDateFrom'], $filter['absentDateTo'],$totalClass['dates']);
                // }
                
                $totalClass = $totalClass['total_count'];

                $class_attended = $totalClass - $totalAbsent;

                if ($totalClass > 0) {
                    $percentage = ($class_attended / $totalClass) * 100;
                } else {
                    $percentage = 0;
                }
    
                $sheet->setCellValue('A' . $excel_row, $j++)
                    ->setCellValue('B' . $excel_row, $student->student_id)
                    ->setCellValue('C' . $excel_row, $student->student_name)
                    ->setCellValue('D' . $excel_row, $student->section_name)
                    ->setCellValue('E' . $excel_row, $totalClass)
                    ->setCellValue('F' . $excel_row, $class_attended)
                    ->setCellValue('G' . $excel_row, number_format($percentage, 2));
    
                $sheet->getStyle('A' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('D' . $excel_row . ':G' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
                $excel_row++;
            }
    
            $filename = 'class_completed_report.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
    
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            ob_start();
            $objWriter->save("php://output");
            $xlsData = ob_get_contents();
            ob_end_clean();
    
            $response = array(
                'op' => 'ok',
                'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
            );
            die(json_encode($response));
        }
    }

    function AirtelSMS($parent_mobile, $message, $dltTemplateId) {
		$destinationAddress = is_array($parent_mobile) ? $parent_mobile : [$parent_mobile];
		// log_message('debug','$destinationAddress -->'.print_r($destinationAddress,true));
		$data = [
			"destinationAddress" => $destinationAddress,
			"dltTemplateId" => $dltTemplateId,
			"entityId" => AIRTEL_SMS_ENTITY_ID,
			"message" => $message,
			"messageType" => AIRTEL_SMS_MESSAGE_TYPE,
			"sourceAddress" => AIRTEL_SMS_SOURCE_ADDRESS,
		];
		// log_message('debug','$data -->'.print_r($data,true));

		$jsonData = json_encode($data, JSON_UNESCAPED_UNICODE);
		$url = "https://sms.parrophins.in/airtel/sms";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Content-Length: ' . strlen($jsonData)
		]);
		$response = curl_exec($ch);
		// log_message('debug','$response -->'.print_r($response,true));
		if (curl_errno($ch)) {
			curl_close($ch);
			return 'failure'; // return failure on curl error
		}
		curl_close($ch);
		// Decode response to check success status
		$decoded = json_decode($response, true);
		// log_message('debug','$decoded -->'.print_r($decoded,true));
		if (isset($decoded['success']) && $decoded['success'] === true) {
			return 'success';
		} else {
			return 'failure';
		}
	}
}
?>