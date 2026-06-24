<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class User extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('user_model');
        $this->load->model('staff_model','staff');
        $this->load->model('leave_model','leave');
        $this->load->model('Students_model','student');
        $this->load->model('subjects_model','subject');
        $this->load->model('settings_model','settings');
        $this->load->model('studentAttendance_model','attendance');
        $this->load->model('push_notification_model');
        $this->load->model('Access_model', 'access');  
        $this->isLoggedIn();
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->facultyDashboard();
    }

    /**
     * This function is used to load the user list
     * 
     */
    public function facultyDashboard()
    {
        $todayDate = date('Y-m-d');
        $by_class = array();
        $studentCount = array();
        $data['staffInfo'] = $this->staff->getStaffInfoForProfile($this->staff_id);
        $data['AllstaffInfo'] = $this->staff->getAllStaffInfo();
        // $filter['by_role'] = ROLE_TEACHING_STAFF;
        // $data['teaching_staffs_total']= $this->staff->staffListingCount($filter);
        // $filter['by_role'] = ROLE_NON_TEACHING_STAFF;
        // $data['non_teaching_staffs_total']= $this->staff->staffListingCount($filter);
        // $filter['by_role'] = ROLE_SUPPORT_STAFF;
        // $data['support_staffs_total']= $this->staff->staffListingCount($filter);
        // $filter['by_role'] = ROLE_ADMIN;
        // $data['admin_total']= $this->staff->staffListingCount($filter);
        $deptInfo = $this->staff->getStaffDepartment();
        $data['total_staff'] = 0;
        foreach($deptInfo as $dept){
            $filter['by_dept'] = $dept->dept_id;
            $countStaff = $this->staff->staffListingCount($filter);
            $staffCount[$dept->dept_id] = $countStaff;
            $data['total_staff'] += $countStaff;
        }
        $data['staffCount'] = $staffCount;
       
        $data['deptInfo'] = $deptInfo;
        $data['studentData'] = $this->student->getstudentInfo();
        $data['streamInfo'] = $this->student->getAllStreamName();
       
        // $by_class[0] = 'CEBA';
        // $by_class[1] = 'EBAS';
        // $by_class[2] = 'HEBA';
        // $by_class[3] = 'HEPS';
        // $by_class[4] = 'PCMB';
        // $by_class[5] = 'PCMC';

        foreach ($data['streamInfo'] as $i => $stream) {
            $class = $stream->stream_name;

            $studentCountIPUC[$i] = $this->student->getCountOfTotalStudentsIPUC($class);
            $studentCountIIPUC[$i] = $this->student->getCountOfTotalStudentsIIPUC($class);
        }
        
        // $totalStudent = 0;

        // for($i=0;$i<count($by_class);$i++){
        //     $filter['by_class'] = $by_class[$i];
        //     $studentCount[$i] = $this->student->getCountOfTotalStudents($filter);
        //     $totalStudent += $studentCount[$i];
        // }
        // for($i=0;$i<count($by_class);$i++){
        //     $class = $by_class[$i];
        //     $studentCountIPUC[$i] = $this->student->getCountOfTotalStudentsIPUC($class);
        // }
        // for($i=0;$i<count($by_class);$i++){
        //     $class = $by_class[$i];
        //     $studentCountIIPUC[$i] = $this->student->getCountOfTotalStudentsIIPUC($class);   
        // }
        // // for($i=0;$i<count($by_class);$i++){
        // //     $class = $by_class[$i];
        // //     $studentCountHEPS[$i] = $this->student->getCountOfTotalStudentsHEPS($class);   
        // // }
        
        // $data['className'] = $by_class;
        $data['className'] = $data['streamInfo'];
        $data['studentCountIPUC'] = $studentCountIPUC;
        $data['studentCountIIPUC'] = $studentCountIIPUC;
      
        $data['studentCount'] = $studentCount;
        $data['totalStudentCount'] = $totalStudent;
        // $data['staffInTime']= $this->staff->getStaffAttendanceInTimeByID($todayDate,$this->staff_id);
        // $data['staffOutTime']= $this->staff->getStaffAttendanceOutTimeByID($todayDate,$this->staff_id);
        
        // $data['notificationLeave']= $this->leave->getStaffAppliedLeaveInfoByDate($todayDate, $this->staff_id);
        
        // $data['totalPresentsTeachingStaffs']= $this->staff->getCountOfTotalPresentedStaffByRole($todayDate,ROLE_TEACHING_STAFF);
        // $data['totalNonTeachingPresents']= $this->staff->getCountOfTotalPresentedStaffByRole($todayDate,ROLE_NON_TEACHING_STAFF);
        // $data['totalSupportStaffPresents']= $this->staff->getCountOfTotalPresentedStaffByRole($todayDate,ROLE_SUPPORT_STAFF);
        // $data['totalAdminStaffPresents']= $this->staff->getCountOfTotalPresentedStaffByRole($todayDate,ROLE_ADMIN);
        $filter['by_intake_year'] = ''.FIRST_YEAR.'';
        $filter['term'] = 'I PUC';
       $data['totalFirstYearStudents']= $this->student->getCountOfStudents($filter);
       $filter['term'] = 'II PUC';
        $filter['by_intake_year'] = ''.SECOND_YEAR.'';
        $staff_id = '';
       $data['totalSecondYearStudents']= $this->student->getCountOfStudents($filter);
       $data['Alumnicount']= $this->student->getAlumniStudentCount($filter);
       $data['staffSubjectInfo']= $this->staff->getAllSubjectByStaffId($this->staff_id);
        $staffClass = $this->staff->getStaffSubjectSectionByStaffId($this->staff_id);
        $subjectInfo = $this->subject->getStaffSubjectCodebyStaffId($this->staff_id);
       $data['assignedStaffsection'] = $this->staff->getSectionByStaffId($this->staff_id);
      //  $data['staffClassCompletedInfo'] = $this->attendance->getStaffClassCompletenfoById();
        $classCompletedCount = array();
        $data['assignedStaffClass'] = $staffClass;
        foreach($staffClass as $class){
            for($i=0;$i<count($subjectInfo);$i++){
                $subject_code[$i] = $subjectInfo[$i]->subject_id;
            }
            $subjectCode = $subject_code;
            $staff_id = $this->staff_id;
            $classCompletedCount[$class->row_id] = $this->staff->geStaffClassCompletetedCount($staff_id,$class->term_name,$class->section_name,$class->stream_name);
        }
        $data['classCompletedCount'] = $classCompletedCount;
     
        
        // $filter['search_date'] = $todayDate;
        // $data['classCompletedInfo'] = $this->attendance->getAttendanceClassCompletedInfo();
        // $isExists = $this->attendance->CheckTimetableDayShiftExists($filter);
        // if($this->role == ROLE_TEACHING_STAFF){
        //     $filter['staff_id'] = $this->staff_id;
        // }
        // if(!empty($isExists)){
        //     $filter['week'] = $isExists->week_name;
        //     $data['attendanceDate']= date('d-m-Y', strtotime($todayDate));
        //     $data['attendanceInfo'] = $this->attendance->getShiftTimetableInfo($filter,$returns = '',$returns = '');
        // }else{
        //     $data['attendanceDate']= date('d-m-Y', strtotime($todayDate));
        //     $filter['weekName'] = date('l',strtotime($todayDate));
        //     $data['attendanceInfo'] = $this->attendance->getClassForAttendance($filter,$returns = '',$returns = '');
        // }
        
        $student_id = $this->security->xss_clean($this->input->post('student_id'));
        if(!empty($student_id)){
            $filter['student_id'] = $student_id;
            $studentRecord = $this->student->getStudentInfoByStudentId($filter); 
            if(!empty($studentRecord)){
                $data['studentsRecords'] = $studentRecord;
            } else {
                $data['studentsRecords'] = '';
                $data['studentSearchMsg'] = '<div class="alert alert-danger p-1 mb-0" role="alert">
                Invalid Student ID
              </div>';
            }
            $data['student_id'] =  $student_id;
      
        } else {
            $data['student_id'] =  '';
            $data['studentsRecords'] = '';
            $data['studentSearchMsg'] = '<div class="alert card_head_dashboard p-1 mb-0" role="alert" style="color: #373737;">
            Search by Student ID 
          </div>';
        }
     
        $staff_id = $this->security->xss_clean($this->input->post('staff_id'));
        if(!empty($staff_id)){
            $staffRecord = $this->staff->getStaffInfoForProfile($staff_id); 
            if(!empty($staffRecord)){ 
                $data['staffSectionInfo'] = $this->staff->getSectionByStaffId($staff_id);
                $data['staffSubjectInfo'] = $this->staff->getAllSubjectByStaffId($staff_id);
                $data['staffRecord'] = $staffRecord;
            } else {
                $data['staffRecord'] = '';
                $data['staffSearchMsg'] = '<div class="alert alert-danger p-1 mb-0" role="alert">
                    Invalid Staff ID
                </div>';
            }
            $data['staff_id'] =  $staff_id;
      
        } else {
            $data['staff_id'] =  '';
            $data['staffRecord'] = '';
            $data['staffSearchMsg'] = '<div class="alert  card_head_dashboard p-1 mb-0" role="alert" style="color: #373737;">
                Search by Staff ID 
            </div>';
        }
        
        if($this->role == ROLE_TEACHING_STAFF){
            $filter['role'] = 'Staff';
            $filter['role_one'] = 'ALL';
        }
        $this->load->library('pagination');
        $newsCount = $this->staff->getNewsFeedCount($filter);
        $returns = $this->paginationCompress("facultyDashboard/", $newsCount, 4);
        $filter['page'] = $returns["page"];
        $filter['segment'] = $returns["segment"];
        $data['newsInfo'] = $this->staff->getNewsFeed($filter);
      $data['newsInfo'] = $this->staff->getNewsFeed($filter);
        // foreach($data['newsInfo'] as $news){
        //     $news->isLiked=$this->staff->isLiked($news->row_id,$this->session->userdata('staff_id'));
        //     $news->totalLikes=$this->staff->totalLikes($news->row_id);
        // }
        $returns = $this->paginationCompress("facultyDashboard/", $newsCount, 4);
        $filter['page'] = $returns["page"];
        $filter['segment'] = $returns["segment"];
       // $data['newsInfo'] = $this->staff->getNewsFeed($filter);
        // foreach($data['newsInfo'] as $news){
        //     $news->isLiked=$this->staff->isLiked($news->row_id,$this->session->userdata('staff_id'));
        //     $news->totalLikes=$this->staff->totalLikes($news->row_id);
        // }

        $absent_date =$this->security->xss_clean($this->input->post('absent_date')); 
        if(!empty($absent_date)){
            $data['attendanceRecords'] = $this->attendance->getAbsenteesInfoDashboard(date('Y-m-d',strtotime($absent_date)));
            $data['absent_date'] = $absent_date;
        }else{
            $data['attendanceRecords'] = $this->attendance->getAbsenteesInfoDashboard(date('Y-m-d'));
            $data['absent_date'] = date('d-m-Y');  
        }
        $data['staffIde'] = $this->staff_id;

        $data['documentInfo'] = $this->user_model->getAlldocumentInfoDashboard();
        $data['UserModel'] = $this->user_model;

        //GENDER COUNT
        $by_gender[0] = 'MALE';
        $by_gender[1] = 'FEMALE';
        for($c=0;$c<count($by_gender);$c++){
            $gender = $by_gender[$c];
            $GenderWiseIPUC[$gender] = $this->student->getCountOfStudentsGenderWiseIPUC($by_gender[$c]);

            $GenderWiseIIPUC[$gender] = $this->student->getCountOfStudentsGenderWiseIIPUC($by_gender[$c]);
        }
        $data['GenderInformation'] = $by_gender;
        $data['GenderWiseIPUC'] = $GenderWiseIPUC;
        $data['GenderWiseIIPUC'] = $GenderWiseIIPUC;

        $data['staffNotificationArray'] = $this->push_notification_model->getStaffNotificationsInfoDisplay($this->role,$this->department_id);
        $data['accessInfo'] = $this->getCurrentAccess();
        $data['accessModel'] = $this->access;
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Teaching Staff Dashboard';
        $this->loadViews("dashboard", $this->global, $data, null);
    }



    public function adminDashboard()
    {
        if($this->role == ROLE_AUDITOR){
            redirect('facultyDashboard');
        }
        $todayDate = date('Y-m-d');
        $by_class = array();
        $studentCount = array();
        $data['staffInfo'] = $this->staff->getStaffInfoForProfile($this->staff_id);
        $data['AllstaffInfo'] = $this->staff->getAllStaffInfo();
        // $filter['by_role'] = ROLE_TEACHING_STAFF;
        // $data['teaching_staffs_total']= $this->staff->staffListingCount($filter);
        // $filter['by_role'] = ROLE_NON_TEACHING_STAFF;
        // $data['non_teaching_staffs_total']= $this->staff->staffListingCount($filter);
        // $filter['by_role'] = ROLE_SUPPORT_STAFF;
        // $data['support_staffs_total']= $this->staff->staffListingCount($filter);
        // $filter['by_role'] = ROLE_ADMIN;
        // $data['admin_total']= $this->staff->staffListingCount($filter);
        $deptInfo = $this->staff->getStaffDepartment();
        $data['total_staff'] = 0;
        foreach($deptInfo as $dept){
            $filter['by_dept'] = $dept->dept_id;
            $countStaff = $this->staff->staffListingCount($filter);
            $staffCount[$dept->dept_id] = $countStaff;
            $data['total_staff'] += $countStaff;
        }
        $data['staffCount'] = $staffCount;
       
        $data['deptInfo'] = $deptInfo;
        $data['studentData'] = $this->student->getstudentInfo();
       
        $by_class[0] = 'EBAC';
        $by_class[1] = 'HEBA';
        $by_class[2] = 'HEPS';
        $by_class[3] = 'PCMB';
        $by_class[4] = 'PCMC';
        $by_class[5] = 'EBAS';


        
        $totalStudent = 0;

        for($i=0;$i<count($by_class);$i++){
            $filter['by_class'] = $by_class[$i];
            $studentCount[$i] = $this->student->getCountOfTotalStudents($filter);
            $totalStudent += $studentCount[$i];
        }
        for($i=0;$i<count($by_class);$i++){
            $class = $by_class[$i];
            $studentCountIPUC[$i] = $this->student->getCountOfTotalStudentsIPUC($class);
        }
        for($i=0;$i<count($by_class);$i++){
            $class = $by_class[$i];
            $studentCountIIPUC[$i] = $this->student->getCountOfTotalStudentsIIPUC($class);   
        }
        // for($i=0;$i<count($by_class);$i++){
        //     $class = $by_class[$i];
        //     $studentCountHEPS[$i] = $this->student->getCountOfTotalStudentsHEPS($class);   
        // }
        
        $data['className'] = $by_class;
        $data['studentCountIPUC'] = $studentCountIPUC;
        $data['studentCountIIPUC'] = $studentCountIIPUC;
      
        $data['studentCount'] = $studentCount;
        $data['totalStudentCount'] = $totalStudent;
        // $data['staffInTime']= $this->staff->getStaffAttendanceInTimeByID($todayDate,$this->staff_id);
        // $data['staffOutTime']= $this->staff->getStaffAttendanceOutTimeByID($todayDate,$this->staff_id);
        
        // $data['notificationLeave']= $this->leave->getStaffAppliedLeaveInfoByDate($todayDate, $this->staff_id);
        
        // $data['totalPresentsTeachingStaffs']= $this->staff->getCountOfTotalPresentedStaffByRole($todayDate,ROLE_TEACHING_STAFF);
        // $data['totalNonTeachingPresents']= $this->staff->getCountOfTotalPresentedStaffByRole($todayDate,ROLE_NON_TEACHING_STAFF);
        // $data['totalSupportStaffPresents']= $this->staff->getCountOfTotalPresentedStaffByRole($todayDate,ROLE_SUPPORT_STAFF);
        // $data['totalAdminStaffPresents']= $this->staff->getCountOfTotalPresentedStaffByRole($todayDate,ROLE_ADMIN);
        $filter['by_intake_year'] = ''.FIRST_YEAR.'';
        $filter['term'] = 'I PUC';
       $data['totalFirstYearStudents']= $this->student->getCountOfStudents($filter,);
       $filter['term'] = 'II PUC';
        $filter['by_intake_year'] = ''.SECOND_YEAR.'';
        $staff_id = '';
       $data['totalSecondYearStudents']= $this->student->getCountOfStudents($filter);
       $data['Alumnicount']= $this->student->getAlumniStudentCount($filter);
       $data['staffSubjectInfo']= $this->staff->getAllSubjectByStaffId($this->staff_id);
        $staffClass = $this->staff->getStaffSubjectSectionByStaffId($this->staff_id);
        $subjectInfo = $this->subject->getStaffSubjectCodebyStaffId($this->staff_id);
       $data['assignedStaffsection'] = $this->staff->getSectionByStaffId($this->staff_id);
      //  $data['staffClassCompletedInfo'] = $this->attendance->getStaffClassCompletenfoById();
        $classCompletedCount = array();
        $data['assignedStaffClass'] = $staffClass;
        foreach($staffClass as $class){
            for($i=0;$i<count($subjectInfo);$i++){
                $subject_code[$i] = $subjectInfo[$i]->subject_id;
            }
            $subjectCode = $subject_code;
            $staff_id = $this->staff_id;
            $classCompletedCount[$class->row_id] = $this->staff->geStaffClassCompletetedCount($staff_id,$class->term_name,$class->section_name,$class->stream_name);
        }
        $data['classCompletedCount'] = $classCompletedCount;
     
        
        // $filter['search_date'] = $todayDate;
        // $data['classCompletedInfo'] = $this->attendance->getAttendanceClassCompletedInfo();
        // $isExists = $this->attendance->CheckTimetableDayShiftExists($filter);
        // if($this->role == ROLE_TEACHING_STAFF){
        //     $filter['staff_id'] = $this->staff_id;
        // }
        // if(!empty($isExists)){
        //     $filter['week'] = $isExists->week_name;
        //     $data['attendanceDate']= date('d-m-Y', strtotime($todayDate));
        //     $data['attendanceInfo'] = $this->attendance->getShiftTimetableInfo($filter,$returns = '',$returns = '');
        // }else{
        //     $data['attendanceDate']= date('d-m-Y', strtotime($todayDate));
        //     $filter['weekName'] = date('l',strtotime($todayDate));
        //     $data['attendanceInfo'] = $this->attendance->getClassForAttendance($filter,$returns = '',$returns = '');
        // }
        
        $student_id = $this->security->xss_clean($this->input->post('student_id'));
        if(!empty($student_id)){
            $filter['student_id'] = $student_id;
            $studentRecord = $this->student->getStudentInfoByStudentId($filter); 
            if(!empty($studentRecord)){
                $data['studentsRecords'] = $studentRecord;
            } else {
                $data['studentsRecords'] = '';
                $data['studentSearchMsg'] = '<div class="alert alert-danger p-1 mb-0" role="alert">
                Invalid Student ID
              </div>';
            }
            $data['student_id'] =  $student_id;
      
        } else {
            $data['student_id'] =  '';
            $data['studentsRecords'] = '';
            $data['studentSearchMsg'] = '<div class="alert card_head_dashboard p-1 mb-0" role="alert" style="color: #373737;">
            Search by Student ID 
          </div>';
        }
     
        $staff_id = $this->security->xss_clean($this->input->post('staff_id'));
        if(!empty($staff_id)){
            $staffRecord = $this->staff->getStaffInfoForProfile($staff_id); 
            if(!empty($staffRecord)){ 
                $data['staffSectionInfo'] = $this->staff->getSectionByStaffId($staff_id);
                $data['staffSubjectInfo'] = $this->staff->getAllSubjectByStaffId($staff_id);
                $data['staffRecord'] = $staffRecord;
            } else {
                $data['staffRecord'] = '';
                $data['staffSearchMsg'] = '<div class="alert alert-danger p-1 mb-0" role="alert">
                    Invalid Staff ID
                </div>';
            }
            $data['staff_id'] =  $staff_id;
      
        } else {
            $data['staff_id'] =  '';
            $data['staffRecord'] = '';
            $data['staffSearchMsg'] = '<div class="alert  card_head_dashboard p-1 mb-0" role="alert" style="color: #373737;">
                Search by Staff ID 
            </div>';
        }
        
        if($this->role == ROLE_TEACHING_STAFF){
            $filter['role'] = 'Staff';
            $filter['role_one'] = 'ALL';
        }
        $this->load->library('pagination');
        $newsCount = $this->staff->getNewsFeedCount($filter);
        $returns = $this->paginationCompress("facultyDashboard/", $newsCount, 4);
        $filter['page'] = $returns["page"];
        $filter['segment'] = $returns["segment"];
        $data['newsInfo'] = $this->staff->getNewsFeed($filter);
      $data['newsInfo'] = $this->staff->getNewsFeed($filter);
        // foreach($data['newsInfo'] as $news){
        //     $news->isLiked=$this->staff->isLiked($news->row_id,$this->session->userdata('staff_id'));
        //     $news->totalLikes=$this->staff->totalLikes($news->row_id);
        // }
        $returns = $this->paginationCompress("facultyDashboard/", $newsCount, 4);
        $filter['page'] = $returns["page"];
        $filter['segment'] = $returns["segment"];
       // $data['newsInfo'] = $this->staff->getNewsFeed($filter);
        // foreach($data['newsInfo'] as $news){
        //     $news->isLiked=$this->staff->isLiked($news->row_id,$this->session->userdata('staff_id'));
        //     $news->totalLikes=$this->staff->totalLikes($news->row_id);
        // }

        $absent_date =$this->security->xss_clean($this->input->post('absent_date')); 
        if(!empty($absent_date)){
            $data['attendanceRecords'] = $this->attendance->getAbsenteesInfoDashboard(date('Y-m-d',strtotime($absent_date)));
            $data['absent_date'] = $absent_date;
        }else{
            $data['attendanceRecords'] = $this->attendance->getAbsenteesInfoDashboard(date('Y-m-d'));
            $data['absent_date'] = date('d-m-Y');  
        }
        $data['staffIde'] = $this->staff_id;
        //GENDER COUNT
        $by_gender[0] = 'MALE';
        $by_gender[1] = 'FEMALE';
        for($c=0;$c<count($by_gender);$c++){
            $gender = $by_gender[$c];
            $GenderWiseIPUC[$gender] = $this->student->getCountOfStudentsGenderWiseIPUC($by_gender[$c]);

            $GenderWiseIIPUC[$gender] = $this->student->getCountOfStudentsGenderWiseIIPUC($by_gender[$c]);
        }
        $data['GenderInformation'] = $by_gender;
        $data['GenderWiseIPUC'] = $GenderWiseIPUC;
        $data['GenderWiseIIPUC'] = $GenderWiseIIPUC;
        $data['staffNotificationArray'] = $this->push_notification_model->getStaffNotificationsInfoDisplay($this->role,$this->department_id);
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Teaching Staff Dashboard';
        $this->loadViews("adminDashboard", $this->global, $data, null);
    }

   

    // public function viewMyProfile($active = "details")
    // {
    //     if ($this->isAdmin() == true) {
    //         $this->loadThis();
    //     } else {
    //         $data['staffInfo'] = $this->staff->getStaffInfoForProfile($this->staff_id);
    //         $data["active"] = $active;
    //         $this->global['pageTitle'] = ''.TAB_TITLE.' : View My Profile';
    //         $this->loadViews("profile/viewProfile", $this->global, $data, null);
    //     }
    // }
    public function viewMyProfile($active = "details")
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $data['staffInfoNew'] = $this->staff->getStaffInfoForProfile($this->staff_id);
            $data["active"] = $active;

            $data['departments'] = $this->staff->getStaffDepartment();
            $data['designation'] = $this->staff->getStaffRolesForStaff($this->staff_id);
            $data['shiftsInfo'] = $this->staff->getStaffShifts();
            $staff = $this->staff->getStaffInfoById($data['staffInfoNew']->row_id);
            $data['staffInfo'] = $staff;

            $data['subjectInfo'] = $this->subject->getAllSubjectInfo();
            $data['sectionInfo'] = $this->settings->getSectionInfo();
            $data['staffSectionInfo'] = $this->staff->getSectionByStaffId($staff->staff_id);
            $data['staffSubjectInfo'] = $this->staff->getAllSubjectByStaffId($staff->staff_id);
            $data['leaveInfo'] = $this->leave->getLeaveInfoByStaffId($staff_id);

            $data['bankInfo'] = $this->staff->getStaffBankById($staff->staff_id);

            $data['SalaryInfo'] = $this->staff->getSalaryInfoByStaffId($staff->staff_id);

            $data['leaveInfoNew'] = $this->leave->getLeaveInfoByStaffIdNew($staff->staff_id);
            $data['leaveInfoNew2024'] = $this->leave->getLeaveInfoByStaffIdNew2024($staff->staff_id);

            $data['leaveModel'] = $this->leave;
            $data['AllstaffInfo'] = $this->staff->getAllStaffInfo();


            $data['staffdocumentInfo'] = $this->staff->getStaffdocumentById($staff->staff_id);
            $data['staffEducationInfo'] = $this->staff->getStaffEducationById($staff->staff_id);
            $data['previousWorkInfo'] = $this->staff->getStaffWorkExperienceInfo($staff->staff_id);

            $data['observationInfo'] = $this->staff->getStaffObservationInfo($data['staffInfo']->row_id);
            $data['OTInfo'] = $this->staff->getOTInfoByStaffId($staff->staff_id);
            $data['OTAmountInfo'] = $this->settings->getAllOTAmountInfo();

            $data['remarkNameInfo'] = $this->settings->getStaffRemarkNameInfo();
           
           
            $this->global['pageTitle'] = ''.TAB_TITLE.' : View My Profile';
            $this->loadViews("profile/viewProfileNew", $this->global, $data, null);
        }
    }

    
    public function updateProfileImage(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $row_id = $this->input->post('row_id');
                $image_path="";
                $staffInfo = array();
                $config=['upload_path' => './upload/',
                'allowed_types' => 'jpg|png|jpeg','max_size' => '2048','overwrite' => TRUE,'file_ext_tolower' => TRUE];
                $this->load->library('upload', $config);
                if($this->upload->do_upload())
                {
                    $post=$this->input->post();
                    $data=$this->upload->data();
                    $image_path=base_url("upload/".$data['raw_name'].$data['file_ext']);
                    $post['image_path']=$image_path;
                }

                if(!empty($image_path)){
                    $staffInfo['photo_url'] = $image_path;
                    $result = $this->staff->updateStaff($staffInfo, $row_id);
                }
                
                if($result > 0) {
                    $this->session->set_flashdata('success', 'Pofile Image Updated Successfully');
                } else {
                    $this->session->set_flashdata('error', 'Pofile Updation failed');
                }
                redirect('viewMyProfile/'.$active);  
            // }
        }
    }
    
    /**
     * This function is used to check whether email already exist or not
     */
    public function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if (empty($userId)) {
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if (empty($result)) {echo ("true");} else {echo ("false");}
    }
    /**
     * Page not found : error 404
     */
    public function pageNotFound()
    {
        $this->global['pageTitle'] = ''.TAB_TITLE.' : 404 - Page Not Found';

        $this->loadViews("404", $this->global, null, null);
    }

    /**
     * This function used to show login history
     * @param number $userId : This is user id
     */
    public function loginHistoy($userId = null)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $userId = ($userId == null ? 0 : $userId);

            $searchText = $this->input->post('searchText');
            $fromDate = $this->input->post('fromDate');
            $toDate = $this->input->post('toDate');
            $data["userInfo"] = $this->user_model->getUserInfoById($userId);
            $data['searchText'] = $searchText;
            $data['fromDate'] = $fromDate;
            $data['toDate'] = $toDate;
            $this->load->library('pagination');
            $count = $this->user_model->loginHistoryCount($userId, $searchText, $fromDate, $toDate);
            $returns = $this->paginationCompress("login-history/" . $userId . "/", $count, 10, 3);
            $data['userRecords'] = $this->user_model->loginHistory($userId, $searchText, $fromDate, $toDate, $returns["page"], $returns["segment"]);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : User Login History';
            $this->loadViews("loginHistory", $this->global, $data, null);
        }
    }

    /**
     * This function is used to show users profile
     */
    public function profile($active = "details")
    {
        $data["staffInfo"] = $this->user_model->getStaffInfoWithRole($this->staff_id);
        $data["active"] = $active;
        $this->global['pageTitle'] = $active == "details" ? ''.TAB_TITLE.' : My Profile' : ''.TAB_TITLE.' : Change Password';
        $this->loadViews("profile", $this->global, $data, null);
    }

    /**
     * This function is used to update the user details
     * @param text $active : This is flag to set the active tab
     */
    public function profileUpdate($active = "details")
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('fname', 'Full Name', 'trim|required|max_length[128]');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|min_length[10]');

        if ($this->form_validation->run() == false) {
            $this->profile($active);
        } else {
            $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
            $mobile = $this->security->xss_clean($this->input->post('mobile'));

            $staffInfo = array('name' => $name, 'mobile' => $mobile, 'updated_by' => $this->staff_id, 'modified_date_time' => date('Y-m-d H:i:s'));

            $result = $this->user_model->editStaff($staffInfo, $this->staff_id);

            if ($result == true) {
                $this->session->set_userdata('name', $name);
                $this->session->set_flashdata('success', 'Profile updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Profile update failed');
            }

            redirect('profile/' . $active);
        }
    }

    /**
     * This function is used to change the password of the user
     * @param text $active : This is flag to set the active tab
     */
    public function changePassword($active = "changepass")
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('oldPassword', 'Old password', 'required|max_length[20]');
        $this->form_validation->set_rules('newPassword', 'New password', 'required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword', 'Confirm new password', 'required|matches[newPassword]|max_length[20]');

        if ($this->form_validation->run() == false) {
            $this->viewMyProfile($active);
        } else {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');

            $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);

            if (empty($resultPas)) {
                $this->session->set_flashdata('nomatch', 'Your old password is not correct');
                redirect('viewMyProfile/' . $active);
            } else {
                $usersData = array('password' => getHashedPassword($newPassword), 'updated_by' => $this->vendorId,
                    'modified_date_time' => date('Y-m-d H:i:s'));
                $result = $this->user_model->changePassword($this->staff_id, $usersData);

                if ($result > 0) {$this->session->set_flashdata('success', 'Password updated successfully');} else { $this->session->set_flashdata('error', 'Password update failed');}

                redirect('viewMyProfile/' . $active);
            }
        }
    }

    public function changePasswordAdmin($row_id)
    {
        $this->load->library('form_validation');
       
        $this->form_validation->set_rules('newPassword', 'New password', 'required|max_length[30]');
        $this->form_validation->set_rules('cNewPassword', 'Confirm new password', 'required|matches[newPassword]|max_length[30]');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('success', 'Password Miss match');
        } else {
            $newPassword = $this->input->post('newPassword');          
            if (empty($newPassword)) {
                $this->session->set_flashdata('nomatch', 'Your new password is not correct');
               
            } else {
                $usersData = array('password' => getHashedPassword($newPassword), 'updated_by' => $this->staff_id,
                    'modified_date_time' => date('Y-m-d H:i:s'));
                $result = $this->user_model->changePasswordAdmin($row_id, $usersData);

                if ($result > 0) {$this->session->set_flashdata('success', 'Password Updated successfully');} else { $this->session->set_flashdata('error', 'Password update failed');
                }
                //redirect('faculty/viewStaffInfoById/' . $active);
            }
        }

        $data['active'] = "";
        $data['staffInfo'] = $this->staff->getStaffInfoById($row_id);
        $this->global['pageTitle'] = ''.TAB_TITLE.' : View Staff Details';
        $this->loadViews("staffs/staffProfile", $this->global, $data, null);
    }

    // dashboard news feed
    
    public function addNewsFeed(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('visibility_type','Visibility','trim|required');
            $this->form_validation->set_rules('subject','Subject','trim|required');
            $this->form_validation->set_rules('description','Description','trim|required');
            if($this->form_validation->run() == FALSE) {
                redirect('facultyDashboard');  
            } else {
              
                $uploadPath = 'upload/news_feed/';
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $image_path="";
                $config=['upload_path'=> $uploadPath,
                'allowed_types' => 'jpg|png|jpeg|pdf|doc|docx','overwrite' => TRUE,
                'file_ext_tolower' => TRUE,];  
                $this->load->library('upload', $config);
                if($this->upload->do_upload())
                {
                    $post=$this->input->post();
                    $data=$this->upload->data();
                    $config['image_library'] = 'gd2';
                    $config['maintain_ratio'] = TRUE;
                    $config['source_image'] = $uploadPath.$data['raw_name'].$data['file_ext'];
                    $config['new_image'] = $uploadPath.$data['raw_name'].$data['file_ext'];
                    $config['width'] = 550;
                    $config['height'] = 450;

                    //load resize library
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    //Thumbnail Image Upload - End

                        $image_path = $config['source_image'];

                }

                $visibility_type = $this->security->xss_clean($this->input->post('visibility_type'));
                $term_name = $this->security->xss_clean($this->input->post('term_name'));
                $subject = $this->security->xss_clean($this->input->post('subject'));
                $description = $this->security->xss_clean($this->input->post('description'));
            
                $newsInfo = array(
                    'term_name' => $term_name,
                    'subject' => $subject,
                    'photo_url' => $image_path,
                    'description' => $description,
                    'date' => date('Y-m-d H:i:s'), 
                    'created_by'=>$this->staff_id, 
                    'created_date_time'=>date('Y-m-d H:i:s'));
                $result = $this->staff->addNewsFeed($newsInfo);
               
                if($result > 0){
                    $roleInfo = array(
                        'rel_news_row_id ' => $result,
                        'visible_type' => $visibility_type,
                        'created_by'=>$this->staff_id, 
                        'created_date_time'=>date('Y-m-d H:i:s'));
                    $result_one = $this->staff->addNewsFeedVisibleType($roleInfo);
                }
              
                $filter['term_name'] = $this->input->post("term_name");

                $title = $subject;
                $body = $description;

                if(strtoupper($visibility_type)=="STUDENT"){
                    $this->sendPushNotificationToStudents($title,$body,$filter);
                }else if(strtoupper($visibility_type)=="STAFF"){
                    $this->sendPushNotificationToAllStaffs($title,$body);
                }else{
                    $this->sendPushNotificationToStudents($title,$body);
                    $this->sendPushNotificationToAllStaffs($title,$body);
                }
                
                if($result_one > 0) {
                    $this->session->set_flashdata('success', 'News Feed Updated Successfully');
                } else {
                    $this->session->set_flashdata('error', 'News Feed Update failed');
                }
                redirect('facultyDashboard');  
            }
        }
    }
    
    
    public function deleteNewsFeed(){
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $newsInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->staff->updateNewsInfo($newsInfo, $row_id);
            // log_message('debug','post'.print_r($postInfo));
            if ($result == true) {
                echo (json_encode(array('status' => true)));
                $roleInfo = array('is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
                );
                $this->staff->updateNewsRoleInfo($roleInfo, $row_id);
            } else {echo (json_encode(array('status' => false)));}
        } 
    }

    
    public function likeNewsFeed(){
        if($this->input->server('REQUEST_METHOD') === "POST"){
            if(is_null($this->input->post('data'))){
                echo "ERROR";
            }else{
                echo $this->staff->newsFeedLike($this->input->post('data'), $this->session->userdata('staff_id'));    
            }
        }

    }
    public function disLikeNewsFeed(){
        if($this->input->server('REQUEST_METHOD') === "POST"){
            if(is_null($this->input->post('data'))){
                echo "ERROR";
            }else{
                echo $this->staff->newsFeedDisLike($this->input->post('data'), $this->session->userdata('staff_id'));    
            }
        }
    }

    private function sendPushNotificationToAllStaffs($title,$body){
        $all_users_token = $this->push_notification_model->getAllStaffToken();
        $tokenBatch = array_chunk($all_users_token,500);
        for($itr = 0; $itr < count($tokenBatch); $itr++){
            $this->push_notification_model->sendStaffMessage($title,$body,$tokenBatch[$itr],USER_TYPE_STAFF);
        }
        $this->session->set_flashdata('success','Notification sent..!'); 
    }

    private function sendPushNotificationToStudents($title,$body,$filters=array()){
        $all_users_token = $this->push_notification_model->getStudentsToken($filters);
        $tokenBatch = array_chunk($all_users_token,500);
        for($itr = 0; $itr < count($tokenBatch); $itr++){
            $this->push_notification_model->sendMessage($title,$body,$tokenBatch[$itr],USER_TYPE_STUDENT);
        }
        $this->session->set_flashdata('success','Notification sent..!'); 
    }


}
?>