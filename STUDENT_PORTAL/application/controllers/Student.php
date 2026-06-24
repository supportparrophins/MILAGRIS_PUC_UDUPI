<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

require APPPATH . '/third_party/encdec_paytm.php';
date_default_timezone_set('Asia/Kolkata');
class Student extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('student_model');
        $this->load->model('performance_model');
        $this->load->model('admission_model');
        $this->load->model('feedback_model');
        $this->isLoggedIn();   
    }

    public function index(){
        $data['studentInfo'] = $this->student_model->getStudentInfoById($this->student_id,$this->term_name);
        $subjects_code = array();
        $elective_sub = strtoupper( $data['studentInfo']->elective_sub);
        if($elective_sub == "KANNADA"){
            array_push($subjects_code, '01');
        }else if($elective_sub == 'HINDI'){
            array_push($subjects_code, '03');
        } else if($elective_sub == 'FRENCH'){
            array_push($subjects_code, '12');
        }
        array_push($subjects_code, '02');
        $exam_mark_first_test = array();
        $exam_mark_mid_term = array();
        $exam_mark_second_test = array();
        $exam_mark_first_preparatory = array();
        $assignment_exam_marks = array();
        $exam_mark_assignment_one = array();
        $exam_mark_assignment_two = array();
        $subjects = $this->getSubjectCodes($data['studentInfo']->stream_name);
        $subjects_code = array_merge($subjects_code,$subjects);

          
        // if($data['studentInfo']->term_name == 'I PUC'){
            $exam_year = '2021-22';
        // }else{
        //     $exam_year = '2020';
        // }
        
        for($i=0;$i < count($subjects_code);$i++){
            $getMarkOfFirstUnitTest = $this->performance_model->getFirstInternaltMark($this->student_id,$subjects_code[$i],$exam_year);
            $exam_mark_first_test[$i] = $getMarkOfFirstUnitTest;

            $getMarkOfMidTerm = $this->performance_model->getMidTermExamMark($this->student_id,$subjects_code[$i],$exam_year);
            $exam_mark_mid_term[$i] = $getMarkOfMidTerm;

            $getMarkOfSecondUnitTest = $this->performance_model->getSecondInternalMark($this->student_id,$subjects_code[$i],$exam_year);
            $exam_mark_second_test[$i] = $getMarkOfSecondUnitTest;

            $getMarkOfFirstPreparatory = $this->performance_model->getFirstPreparatoryMark($this->student_id,$subjects_code[$i],$exam_year);
            $exam_mark_first_preparatory[$i] = $getMarkOfFirstPreparatory;

            $exam_types = 'ASSIGNMENT_I';
            $getAssignmentOneMarks = $this->performance_model->getStudentAssignmentExamMarks($this->student_id,$subjects_code[$i],$exam_types);
            $exam_mark_assignment_one[$i] = $getAssignmentOneMarks;
            $examType = 'ASSIGNMENT_II';
            $getAssignmenttwowMarks = $this->performance_model->getStudentAssignmentExamMarks($this->student_id,$subjects_code[$i],$examType);
            $exam_mark_assignment_two[$i] = $getAssignmenttwowMarks;

            $getFirstPreparatoryMark = $this->performance_model->getFirstAnnualMark($this->student_id,$subjects_code[$i],$exam_year);
            $exam_mark_first_annual[$i] = $getFirstPreparatoryMark;
           
        }

        $assignment_exam_marks = array_merge($exam_mark_assignment_one,$exam_mark_assignment_two);

        
        $total_assignment_mark = array();
        foreach($assignment_exam_marks as $assignmentMarks){

            if(!empty($assignmentMarks->subject_code)){

                // $total_assignment_mark[$assignmentMarks->subject_code] = 0;
                $sub_marks = 0;
                $mark_obt = 0;
                
                if($assignmentMarks->subject_code == 12){
                    $labStatus = 'true';
                }else{
                    $labStatus = $assignmentMarks->lab_status;
                }
                if($assignmentMarks->exam_type == 'ASSIGNMENT_I' || $assignmentMarks->exam_type == 'ASSIGNMENT_II'){
                    if($assignmentMarks->obt_theory_mark == 'AB' || $assignmentMarks->obt_theory_mark == 'EXEM' || $assignmentMarks->obt_theory_mark == 'MP' || $assignmentMarks->obt_theory_mark ==  'ASGN'){
                        $mark_obt = 0;
                    }else{
                        $sub_marks = $this->getAssessmentMark($assignmentMarks->obt_theory_mark,$assignmentMarks->exam_type,$labStatus,$assignmentMarks->subject_code);
                        $mark_obt = $sub_marks;
                    }
                }
                $total_assignment_mark[$assignmentMarks->subject_code] += $mark_obt;
            }
        }

        $data['firstPreparatoryMark'] = $exam_mark_first_annual;
        $data['record'] = $this->student_model->getStudentMarksSheetByStudentId($this->student_id);
        $data['firstUnitTestMarkInfo'] = $exam_mark_first_test;
        $data['midTermExamMarkInfo'] = $exam_mark_mid_term;
        $data['SecondUnitTestMarkInfo'] = $exam_mark_second_test;
        $data['subjectsCode'] = $subjects_code;
        $data['firstPreparatoryMarkInfo'] = $exam_mark_first_preparatory;
        $data['assignmentExamMarks'] = $total_assignment_mark;
        $data['onlineClassInfo'] = $this->student_model->getOnlineClassCredentialsInfo($this->student_id);
        $date = date('Y-m-d');
        $data['studentMarkInfo'] = $this->performance_model->getStudentFinalExamMarkInfo($this->student_id);
        $this->global['notificationMsg'] = $this->student_model->getStudentNotification($this->student_id,$date);
        $this->global['studentStatusInfo'] = $this->student_model->getStudentAppInfoById($this->student_id,$this->term_name);
       // $data['paidStatus'] = $this->student_model->getWorldlinePaymentLogByStudentId($this->student_id);
       

        if($this->term_name == 'I PUC'){
            $feeInfo = $this->admission_model->getFeePaidInfo_I_PUC($data['studentInfo']->application_no);
        }else{
            $feeInfo = $this->admission_model->getFeePaidInfo($data['studentInfo']->application_no);
        }
        $data['pending_fee_amt'] = 'NOT_PAID';       
        if(!empty($feeInfo)){ 
            foreach($feeInfo as $fee){ 
                $data['pending_fee_amt'] =  $fee->pending_balance;
            } 
        } 
        $munRegistration =  $this->student_model->getInfoMUN_Register($data['studentInfo']->student_id);
       if(!empty($munRegistration)){
        $data['mun_payment_status'] = true;
       }
       //    $paymentLog =  $this->student_model->getAllFeeMunPaymentLogByApplicationNo($data['studentInfo']->student_id);
        // $data['mun_payment_status'] = false;
        // if(!empty($paymentLog)){
        //     foreach($paymentLog as $pay){
        //      $ORDER_ID = $pay->order_id;
        //      $requestParamList = array("MID" => PAYTM_MERCHANT_MID , "ORDERID" => $ORDER_ID);  
     
        //      $StatusCheckSum = getChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY);
             
        //      $requestParamList['CHECKSUMHASH'] = $StatusCheckSum;
     
        //      // Call the PG's getTxnStatusNew() function for verifying the transaction status.
        //      $responseParamList = getTxnStatusNew($requestParamList);
            
        //         if($responseParamList['STATUS'] == 'TXN_SUCCESS'){
                    // $data['mun_payment_status'] = true;
        //            $status = "SUCCESS";
        //            $stdMunInfo = array(
        //             'paytm_order_id' => $responseParamList['ORDERID'],
        //             'payment_status' => 1
        //         );
        //         $payInfo = array(
        //             'payment_mode' => $responseParamList['PAYMENTMODE'],
        //             'reference_number'=>$responseParamList['TXNID'],
        //             'payment_status' =>$status,
        //             'fee_amount' => $responseParamList['TXNAMOUNT'],
        //             'updated_by' => $data['studentInfo']->student_id,
        //             'updated_date_time' => date('Y-m-d H:i:s')
        //         );

        //         }else{
        //             $status = "FAILED";
        //             $payInfo = array(
        //               //  'payment_mode' => $responseParamList['PAYMENTMODE'],
        //               //  'reference_number'=>$responseParamList['TXNID'],
        //                 'payment_status' =>$status,
        //                 'fee_amount' => $responseParamList['TXNAMOUNT'],
        //                 'updated_by' => $data['studentInfo']->student_id,
        //                 'updated_date_time' => date('Y-m-d H:i:s')
        //             );
        //             $stdMunInfo = array(
        //                 'paytm_order_id' => $responseParamList['ORDERID'],
        //                 'payment_status' => 0
        //             );
                   
        //         }
               
        //     $this->student_model->updateMunRegister($stdMunInfo,$this->student_id);
        //     $this->student_model->updateMunPaymentLogByOrderId($payInfo,$responseParamList['ORDERID']);
        //     }
        // } 


     // Course Register Re-Process

        $paymentLog =  $this->student_model->getAllFeeCoursePaymentLogByStudentId($data['studentInfo']->student_id);
        $data['course_payment_status'] = false;
        if(!empty($paymentLog)){
            foreach($paymentLog as $pay){
             $ORDER_ID = $pay->order_id;
             $course_name = $pay->course_name;
             $requestParamList = array("MID" => PAYTM_MERCHANT_MID , "ORDERID" => $ORDER_ID);  
     
             $StatusCheckSum = getChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY);
             
             $requestParamList['CHECKSUMHASH'] = $StatusCheckSum;
     
             // Call the PG's getTxnStatusNew() function for verifying the transaction status.
             $responseParamList = getTxnStatusNew($requestParamList);
            
                if($responseParamList['STATUS'] == 'TXN_SUCCESS'){
                    $data['course_payment_status'] = true;
                   $status = "SUCCESS";
                   $stdCourseInfo = array(
                    'paytm_order_id' => $responseParamList['ORDERID'],
                    'payment_status' => 1
                );
                $payInfo = array(
                    'payment_mode' => $responseParamList['PAYMENTMODE'],
                    'reference_number'=>$responseParamList['TXNID'],
                    'payment_status' =>$status,
                    'fee_amount' => $responseParamList['TXNAMOUNT'],
                    'updated_by' => $data['studentInfo']->student_id,
                    'updated_date_time' => date('Y-m-d H:i:s')
                );

                }else{
                    $status = "FAILED";
                    $payInfo = array(
                      //  'payment_mode' => $responseParamList['PAYMENTMODE'],
                      //  'reference_number'=>$responseParamList['TXNID'],
                        'payment_status' =>$status,
                        'fee_amount' => $responseParamList['TXNAMOUNT'],
                        'updated_by' => $data['studentInfo']->student_id,
                        'updated_date_time' => date('Y-m-d H:i:s')
                    );
                    $stdCourseInfo = array(
                        'paytm_order_id' => $responseParamList['ORDERID'],
                        'payment_status' => 0
                    );
                   
                }
               
            $this->student_model->updateCourseRegister($stdCourseInfo,$this->student_id,$course_name);
            $this->student_model->updateCoursePaymentLogByOrderId($payInfo,$responseParamList['ORDERID']);
            }
        } 

    //end

        
        $paymentLogRGD =  $this->student_model->getAllFeeRGDPaymentLogByApplicationNo($data['studentInfo']->student_id);
        $data['rgd_payment_status'] = false;
        if(!empty($paymentLogRGD)){
            foreach($paymentLogRGD as $pay){
             $ORDER_ID = $pay->order_id;
             $requestParamList = array("MID" => PAYTM_MERCHANT_MID , "ORDERID" => $ORDER_ID);  
     
             $StatusCheckSum = getChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY);
             
             $requestParamList['CHECKSUMHASH'] = $StatusCheckSum;
     
             // Call the PG's getTxnStatusNew() function for verifying the transaction status.
             $responseParamList = getTxnStatusNew($requestParamList);
            
                if($responseParamList['STATUS'] == 'TXN_SUCCESS'){
                    $data['rgd_payment_status'] = true;
                   $status = "SUCCESS";
                   $stdMunInfo = array(
                    'paytm_order_id' => $responseParamList['ORDERID'],
                    'payment_status' => 1
                );
                $payInfo = array(
                    'payment_mode' => $responseParamList['PAYMENTMODE'],
                    'reference_number'=>$responseParamList['TXNID'],
                    'payment_status' =>$status,
                    'fee_amount' => $responseParamList['TXNAMOUNT'],
                    'updated_by' => $data['studentInfo']->student_id,
                    'updated_date_time' => date('Y-m-d H:i:s')
                );
                }else{
                    $status = "FAILED";
                    $payInfo = array(
                      //  'payment_mode' => $responseParamList['PAYMENTMODE'],
                      //  'reference_number'=>$responseParamList['TXNID'],
                        'payment_status' =>$status,
                        'fee_amount' => $responseParamList['TXNAMOUNT'],
                        'updated_by' => $data['studentInfo']->student_id,
                        'updated_date_time' => date('Y-m-d H:i:s')
                    );
                    $stdMunInfo = array(
                        'paytm_order_id' => $responseParamList['ORDERID'],
                        'payment_status' => 0
                    );
                   
                }
           
            $this->student_model->updateRGDRegister($stdMunInfo,$this->student_id);
            $this->student_model->updateRGDPaymentLogByOrderId($payInfo,$responseParamList['ORDERID']);
            }
        } 
        // $this->global['feedbackStatus'] = $this->feedback_model->checkStudentFeedbackIsEnabled($this->student_id,'TEACHING');
        // $this->global['feedbackCounsellorStatus'] = $this->feedback_model->checkStudentFeedbackIsEnabled($this->student_id,'COUNSELLOR');
        // $data['feedbackCounsellorStatus'] = $this->feedback_model->checkStudentFeedbackIsEnabled($this->student_id,'COUNSELLOR');
       
        $data['regCourseInfo'] = $this->student_model->getAllCourseRegisterInfo($this->student_id);
  //  $newsCount = $this->student_model->getNewsFeedCount($filter);
  $returns = $this->paginationCompress("studentDashboard/", $newsCount, 4);
  $filter['page'] = $returns["page"];
  $filter['segment'] = $returns["segment"];
  $data['newsInfo'] = $this->student_model->getNewsFeed($filter);
  // foreach($data['newsInfo'] as $news){
  //     $news->isLiked=$this->student_model->isLiked($news->row_id,$this->session->userdata('userId'));
  //     $news->totalLikes=$this->student_model->totalLikes($news->row_id);
  // }
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Dashboard';
        $this->loadViews("dashboard", $this->global, $data , NULL);
    }
 
    /**
     * This function is used to show users profile
     */
    function profile($active = "details"){
        $data['studentInfo'] = $this->student_model->getStudentInfoById($this->student_id,$this->term_name);
        log_message('debug','photoo--'.$data['studentInfo']->photo_url);
        log_message('debug','photoo--'.$data['studentInfo']->is_physically_challenged);
        $data["active"] = $active;
        $this->global['pageTitle'] = ''.TAB_TITLE.' : My Profile' ;
        $this->loadViews("users/profile", $this->global, $data, NULL);
    }

    /**
     * This function is used to change the password of the user
     * @param text $active : This is flag to set the active tab
     */
    function changePassword($active = "changepass"){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('password','New password','required|min_length[6]');
        $this->form_validation->set_rules('cpassword','Confirm new password','required|matches[password]|min_length[6]');
        
        if($this->form_validation->run() == FALSE) {
            $this->profile($active);
        }else {
            $oldPassword = $this->input->post('oldPassword');
            $password = $this->input->post('password');
            $resultPas = $this->student_model->matchOldPassword($this->student_row_id, $oldPassword);
            if(empty($resultPas)) {
                $this->session->set_flashdata('nomatch', 'Your old password is not correct');
                redirect('profile/'.$active);
            }
            else{
                $usersData = array('password'=>getHashedPassword($password), 'updated_by'=>$this->student_row_id,
                                'updatedDtm'=>date('Y-m-d H:i:s'));
                $result = $this->student_model->changePassword($this->student_row_id, $usersData);
                if($result > 0) { 
                    $this->session->set_flashdata('success', 'Password updation successful'); 
                }else { 
                    $this->session->set_flashdata('error', 'Password updation failed'); 
                }
                redirect('profile/'.$active);
            }
        }
    }

    public function sendFeedbackToManagement(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('subject','Subject','required');
        $this->form_validation->set_rules('message','Message','required');
        if($this->form_validation->run() == FALSE) {
            $this->dashboard;
        }else{
            $subject = $this->input->post('subject');
            $message = $this->input->post('message');
            $feedbackMessage = array('msg_from'=>$subject,'message'=>$message,'student_id'=>$this->student_id, 'date'=> date('Y-m-d H:i:s'), 'created_by'=>$this->student_row_id, 'created_date_time'=>date('Y-m-d H:i:s'));
            $result = $this->student_model->sendFeedbackMessage($feedbackMessage);
            if($result > 0){
                echo "Suggestion Sent Successfully";
            }else{
                echo "Suggestion Not Sent.";
            }
        }

    }
    
    /* This function is used for overall student attendance*/
    public function overallStudentAttendance(){
        $subjects_code = array();
        $filter = array();
        $date = $this->security->xss_clean($this->input->post('by_date'));
        $sub_code = $this->security->xss_clean($this->input->post('subject_code'));
        $time_id = $this->security->xss_clean($this->input->post('time_id'));
        if(!empty($date)){
            $filter['date'] = date('Y-m-d',strtotime($date));
            $data['searchDate'] = date('d-m-Y',strtotime($date));
        }else{
            $data['searchDate'] = '';
        }
        if(!empty($sub_code)){
            $filter['sub_code'] = $sub_code;
            $data['searchSubject'] = $sub_code;
        }else{
            $data['searchSubject'] = '';
        }
        if(!empty($time_id)){
            $filter['time_id'] = $time_id;
            $data['searchTime'] = $time_id;
        }else{
            $data['searchTime'] = '';
        }
        $filter['student_id'] = $this->student_id;
      
        $studentInfo = $this->student_model->getStudentInfoById($this->student_id,$this->term_name);
        $elective_sub = strtoupper( $studentInfo->elective_sub);
        if($elective_sub == "KANNADA"){
            array_push($subjects_code, '01');
        }else if($elective_sub == 'HINDI'){
            array_push($subjects_code, '03');
        } else if($elective_sub == 'FRENCH'){
            array_push($subjects_code, '12');
        }
        array_push($subjects_code, '02');
        $subjects = $this->getSubjectCodes($studentInfo->stream_name);
        $subjects_code = array_merge($subjects_code,$subjects);
        $data['subInfo'] = $this->student_model->getStudentSubjectInfo($subjects_code);
        // $data['timeInfo'] = $this->student_model->getAllTimeInfo();
        $data['subjectInfo'] = $this->student_model->getStudentSubject();
        $data['timeInfo'] = $this->student_model->getAllClassTimingsInfo();
        $this->load->library('pagination');
        $count = $this->student_model->getAttendanceReportCount($filter);
        $returns = $this->paginationCompress ( "overallStudentAttendance/", $count, 10 );
        $filter['page'] = $returns["page"];
        $filter['segment'] = $returns["segment"];
        $data['totalAbsent'] = $count;
        $data['attendanceInfo'] = $this->student_model->getAttendanceReport($filter);
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Attendance Report' ;
        $this->loadViews("report/attendanceReport", $this->global, $data, NULL);
    }


    /* This function is used for Student late comer*/
    public function studentLaterComer(){
        $filter = array();
        $date = $this->security->xss_clean($this->input->post('by_date'));
        if(!empty($date)){
            $filter['date'] = date('Y-m-d',strtotime($date));
            $data['searchDate'] = date('d-m-Y',strtotime($date));
        }else{
            $data['searchDate'] = "";
        }
        $filter['student_id'] = $this->student_id;
        $this->load->library('pagination');
        $count = $this->student_model->getLateComerReportCount($filter);
        $returns = $this->paginationCompress ( "studentLaterComer/", $count, 10 );
        $filter['page'] = $returns["page"];
        $filter['segment'] = $returns["segment"];
        $data['totalLate'] = $count;
        $data['lateComerInfo'] = $this->student_model->getLateComerReport($filter);
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Latercomer ' ;
        $this->loadViews("report/laterComer", $this->global, $data, NULL);
    }

    /* This function is used for Student late comer*/
    public function studentNotificationReport(){
        $filter = array();
        $date = $this->security->xss_clean($this->input->post('by_date'));
        if(!empty($date)){
            $filter['date'] = date('Y-m-d',strtotime($date));
            $data['dateSearch'] = date('d-m-Y',strtotime($date));
        }else{
            $data['dateSearch'] = '';
        }
        $filter['student_id'] = $this->student_id;
        $this->load->library('pagination');
        $count = $this->student_model->getNotificationReportCount($filter);
        $returns = $this->paginationCompress ( "studentNotificationReport/", $count, 10 );
        $filter['page'] = $returns["page"];
        $filter['segment'] = $returns["segment"];
        $data['totalNotification'] = $count;
        $data['studentNotification'] = $this->student_model->getNotificationReport($filter);

        
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Latercomer ' ;
        $this->loadViews("report/notification", $this->global, $data, NULL);
    }
    
    
    public function myAttendance(){
        $data['studentInfo'] = $this->student_model->getStudentInfoById($this->student_id,$this->term_name);
        $this->global['pageTitle'] = ''.TAB_TITLE.' : My Attendance' ;
        $this->loadViews("student/myAttendance", $this->global, $data, NULL);
    }

    // view suggestion page
    public function mySuggestion(){
        $data['suggestionInfo'] = $this->student_model->getSuggestionInfoById($this->student_id);
        $data['studentInfo'] = $this->student_model->getStudentInfoById($this->student_id,$this->term_name);
        $this->global['pageTitle'] = ''.TAB_TITLE.' : My Suggestion ' ;
        $this->loadViews("student/mySuggestion", $this->global, $data, NULL);
    }

    function suggestionToDB()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('select_from','From','trim|required');
        $this->form_validation->set_rules('submit_message', 'Message', 'trim|required');
        
        if($this->form_validation->run() == FALSE){
            $this->mySuggestion();
        }
        else
        {
            $from = $this->input->post('select_from');
            $message = $this->input->post('submit_message');
            
            $suggestionInfo = array('student_id'=>$this->student_id, 'msg_from'=>$from, 'message' => $message, 'date'=> date('Y-m-d H:i:s'), 'created_by' => $this->student_row_id, 'created_date_time' => date('Y-m-d H:i:s'));
            
            $result = $this->student_model->suggestionToDB($suggestionInfo);
            
            if($result > 0)
            {
                $this->session->set_flashdata('success', 'New Message Added Successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Failed To Add Suggestion');
            }
            redirect('mySuggestion');  
        }
    }

    // update student family info
    public function updateFamilyInfo(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('fatherAnnualIncome','Father Annual Income','trim|required');
        if($this->form_validation->run() == FALSE) {
            $this->dashboard;
        }else{

            $fatherAnnualIncome = $this->input->post('fatherAnnualIncome');
            $motherAnnualIncome = $this->input->post('motherAnnualIncome');
            $siblingName = $this->input->post('siblingName');
            $siblingRel = $this->input->post('siblingRel');
            $siblingAge = $this->input->post('siblingAge');
            $siblingIncome = $this->input->post('siblingIncome');
            $familyInfo = array('father_annual_income'=>$fatherAnnualIncome,'mother_annual_income'=>$motherAnnualIncome,
            'student_id' =>$this->student_id,'term_name' => $this->term_name,'updated_by' => $this->student_row_id, 'updated_date_time' => date('Y-m-d H:i:s'));
            
            $result = $this->student_model->addFamilyInfo($familyInfo);
            if($result > 0)
            {
                for($i=0; $i<count($siblingName); $i++){
                    if(!empty($siblingName[$i])){
                        $sibInfo = array(
                            'student_id' => $this->student_id,
                            'sibling_name' => $siblingName[$i],
                            'relation_type' => $siblingRel[$i],
                            'age' => $siblingAge[$i],
                            'annual_income' => $siblingIncome[$i],
                        );
                    }
                    $this->student_model->addSiblingInfo($sibInfo);
                   
                }
                $data_info = array(
                    'profile_update_status' => 1,
                );
                $this->student_model->updateStudentInfoStatus($this->student_id, $data_info);
                $this->session->set_flashdata('success', 'Family Information Updated successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Failed to Update');
            }
            redirect('dashboard');  
        }
    }

    //get fee payment Info of the student

    public function getFeePaymentInfo()
    {
        $data['studentInfo'] = $this->student_model->getStudentInfoById($this->student_id,$this->term_name);
       
        if($this->term_name == 'I PUC'){
            $data['feeInfo'] = $this->admission_model->getFeePaidInfo_I_PUC($data['studentInfo']->application_no);
            $data['pendingAmt'] = $this->admission_model->getFeePendingAmount($data['studentInfo']->application_no);
            $data['feeInfoPending'] = $this->admission_model->feePendingOld_getFeePaidInfo($data['studentInfo']->application_no);
        }else{
            $data['feeInfo'] = $this->admission_model->getFeePendingAmount($data['studentInfo']->application_no);
            $data['pendingAmt'] = "";
        }
        
        $filter = array();
        $filter['student_id'] = $this->student_id;
        //$data['supplyPayment'] = $this->student_model->getSupplyStudentInfoByStatus($filter);
        $this->global['pageTitle'] = ''.TAB_TITLE.' : View Fee Payment Details';
        $this->loadViews("fee_management/feePaidInfo", $this->global, $data, null);
    }
    
    public function munRegistrationFeeProcess(){
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0");
        $checkSum = "";
        $paramList = array();
        $remarks = 'SJPUC Internal MUN registration FEE 2020';
        $fee_amount = '150';
        $studentInfo = $this->student_model->getStudentInfoById($this->student_id,$this->term_name);;
        $mobile = $this->input->post('mobile');
        $committee = $this->input->post('committee');
        $paymentLog = array(
            'mid'=>PAYTM_MERCHANT_MID,
            'student_id' =>$studentInfo->student_id,
            'remarks' =>$remarks,
            'fee_amount' => $fee_amount,
            'payment_status' =>'PENDING',
            'payment_date' => date('Y-m-d'),
            'payment_time' => date('h:i:s'),
            'created_by' => $studentInfo->student_id,
            'created_date_time' => date('Y-m-d H:i:s')
        );
        $response = $this->student_model->addMunFeePaymentLog($paymentLog);

        $CUST_ID = "MUNNEW".$studentInfo->application_no;
        $INDUSTRY_TYPE_ID = "Retail";
        $CHANNEL_ID = "WEB";
        $TXN_AMOUNT = $fee_amount;
        if($response > 0){
            $ORDER_ID = 'MUNFEEREG'.$response;
            $payInfo = array('order_id' =>$ORDER_ID);
            $this->student_model->updateMunPaymentLog($payInfo, $response);
            $_SESSION['order_id'] = $ORDER_ID;
        }
        $stdMunInfo = array(
            'student_id' => $studentInfo->student_id,
            'whatsapp_no' => $mobile,
            'committee' => $committee,
            'year'      =>2022,
            // 'paytm_order_id' => $ORDER_ID,
            // 'paid_amount' => '150'
        );
        $isExistMun = $this->student_model->getInfoMUN_Register($studentInfo->student_id);
        if(empty($isExistMun)){
            $this->student_model->addMunRegister($stdMunInfo);
        }
    //     // Create an array having all required parameters for creating checksum.
        $paramList["MID"] = PAYTM_MERCHANT_MID;
        $paramList["ORDER_ID"] = $ORDER_ID;
        $paramList["CUST_ID"] = $CUST_ID;
        $paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
        $paramList["CHANNEL_ID"] = $CHANNEL_ID;
        $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
        $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;


        $paramList["CALLBACK_URL"] = base_url()."payTmMunRegFeePaymentResponse";
        /*$paramList["MSISDN"] = $MSISDN; //Mobile number of customer
        $paramList["EMAIL"] = $EMAIL; //Email ID of customer
        $paramList["VERIFIED_BY"] = "EMAIL"; //
        $paramList["IS_USER_VERIFIED"] = "YES"; //
        */

        //Here checksum string will return by getChecksumFromArray() function.
        $checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);
        $data['checkSum'] = $checkSum;
        $data['paramList'] = $paramList;
        $this->global['pageTitle'] = ''.TAB_TITLE.' : MUN Reg Payment';
        $this->loadViews("mun_event/paytm_payment_process", $this->global , $data ,NULL);
       
        redirect("dashboard");
      
    }
    


    

    function payTmMunRegFeePaymentResponse(){
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0");

        $paytmChecksum = "";
        $paramList = array();
        $isValidChecksum = "FALSE";
        
        $paramList = $_POST;
        $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
        $data['application_applied_status'] = false;
        //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
        $isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.
        if($isValidChecksum == true){ 
            if($_POST['STATUS'] == 'TXN_SUCCESS'){
                $stdMunInfo = array(
                    'paytm_order_id' => $_POST['ORDERID'],
                    'payment_status' => 1
                ); 
                    $payInfo = array(
                        'payment_mode' => $_POST['PAYMENTMODE'],
                        'reference_number'=>$_POST['TXNID'],
                        'payment_status' =>'SUCCESS',
                        'fee_amount' => $_POST['TXNAMOUNT']);
                        $this->session->set_flashdata('success', 'Thank You! MUN registration payment paid');
            } else {
                $stdMunInfo = array(
                    'paytm_order_id' => $_POST['ORDERID'],
                    'payment_status' => 0
                );
                $payInfo = array(
                    'payment_mode' => $_POST['PAYMENTMODE'],
                    'reference_number'=>$_POST['TXNID'],
                    'payment_status' =>'FAILED',
                    'fee_amount' => $_POST['TXNAMOUNT']);
                    $this->session->set_flashdata('error', 'MUN registration payment failed! Try Again');
            }
           
        }

        $this->student_model->updateMunRegister($stdMunInfo,$this->student_id);
        $this->student_model->updateMunPaymentLogByOrderId($payInfo,$_POST['ORDERID']);
      
        redirect("dashboard");

    }






    public function realisticDrawRegistrationFeeProcess(){
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0");
        $checkSum = "";
        $paramList = array();
        $remarks = 'SJPUC RGD registration FEE 2020';
        $fee_amount = '300';
        $studentInfo = $this->student_model->getStudentInfoById($this->student_id,$this->term_name);;
       
        $paymentLog = array(
            'mid'=>PAYTM_MERCHANT_MID,
            'student_id' =>$studentInfo->student_id,
            'remarks' =>$remarks,
            'fee_amount' => $fee_amount,
            'payment_status' =>'PENDING',
            'payment_date' => date('Y-m-d'),
            'payment_time' => date('h:i:s'),
            'created_by' => $studentInfo->student_id,
            'created_date_time' => date('Y-m-d H:i:s')
        );
        $response = $this->student_model->addRGDFeePaymentLog($paymentLog);

        $CUST_ID = "RGD".$studentInfo->application_no;
        $INDUSTRY_TYPE_ID = "Retail";
        $CHANNEL_ID = "WEB";
        $TXN_AMOUNT = $fee_amount;
        if($response > 0){
            $ORDER_ID = 'RGD'.$response;
            $payInfo = array('order_id' =>$ORDER_ID);
            $this->student_model->updateRGDPaymentLog($payInfo, $response);
            $_SESSION['order_id'] = $ORDER_ID;
        }
        $stdMunInfo = array(
            'student_id' => $studentInfo->student_id,
           
            'paytm_order_id' => $ORDER_ID,
            'paid_amount' => '150');
        $isExistMun = $this->student_model->getInfoRGD_Register($studentInfo->student_id);
        if(empty($isExistMun)){
            $this->student_model->addRGDRegister($stdMunInfo);
        }
        // Create an array having all required parameters for creating checksum.
        $paramList["MID"] = PAYTM_MERCHANT_MID;
        $paramList["ORDER_ID"] = $ORDER_ID;
        $paramList["CUST_ID"] = $CUST_ID;
        $paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
        $paramList["CHANNEL_ID"] = $CHANNEL_ID;
        $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
        $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;


        $paramList["CALLBACK_URL"] = base_url()."payTmRGDRegFeePaymentResponse";
        /*$paramList["MSISDN"] = $MSISDN; //Mobile number of customer
        $paramList["EMAIL"] = $EMAIL; //Email ID of customer
        $paramList["VERIFIED_BY"] = "EMAIL"; //
        $paramList["IS_USER_VERIFIED"] = "YES"; //
        */

        //Here checksum string will return by getChecksumFromArray() function.
        $checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);
        $data['checkSum'] = $checkSum;
        $data['paramList'] = $paramList;
        $this->global['pageTitle'] = ''.TAB_TITLE.' : MUN Reg Payment';
        $this->loadViews("mun_event/paytm_payment_process", $this->global , $data ,NULL);
       
      
    }
    


    

    function payTmRGDRegFeePaymentResponse(){
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0");

        $paytmChecksum = "";
        $paramList = array();
        $isValidChecksum = "FALSE";
        
        $paramList = $_POST;
        $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
        $data['application_applied_status'] = false;
        //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
        $isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.
        if($isValidChecksum == true){ 
            if($_POST['STATUS'] == 'TXN_SUCCESS'){
                $stdMunInfo = array(
                    'paytm_order_id' => $_POST['ORDERID'],
                    'payment_status' => 1
                ); 
                    $payInfo = array(
                        'payment_mode' => $_POST['PAYMENTMODE'],
                        'reference_number'=>$_POST['TXNID'],
                        'payment_status' =>'SUCCESS',
                        'fee_amount' => $_POST['TXNAMOUNT']);
                        $this->session->set_flashdata('success', 'Thank You! Realistic Graphite Drawing registration payment paid');
            } else {
                $stdMunInfo = array(
                    'paytm_order_id' => $_POST['ORDERID'],
                    'payment_status' => 0
                );
                $payInfo = array(
                    'payment_mode' => $_POST['PAYMENTMODE'],
                    'reference_number'=>$_POST['TXNID'],
                    'payment_status' =>'FAILED',
                    'fee_amount' => $_POST['TXNAMOUNT']);
                    $this->session->set_flashdata('error', 'Realistic Graphite Drawing registration payment failed! Try Again');
            }
           
        }

        $this->student_model->updateRGDRegister($stdMunInfo,$this->student_id);
        $this->student_model->updateRGDPaymentLogByOrderId($payInfo,$_POST['ORDERID']);
      
        redirect("dashboard");

    }
    function getSubjectCodes($stream_name) {
        //science
        $PCMB = array("33", "34", "35", '36');
        $PCMC = array("33", "34", "35", '41');
        $PCME = array("33", "34", "35", '40');
        //commarce
        $PEBA = array("29", "22", "27", '30');
        $MEBA = array("75", "22", "27", '30');
        $MSBA = array("75", "31", "27", '30');
        $CSBA = array("41", "31", "27", '30');
        $SEBA = array("31", "22", "27", '30');
        $CEBA = array("41", "22", "27", '30');
        //art
        $HEPS = array("21", "22", "29", '28');
        switch ($stream_name) {
                case "PCMB":
                        return  $PCMB;
                        break;
                case "PCMC":
                        return $PCMC;
                        break;
                case "PEBA":
                        return $PEBA;
                        break;
                case "PCME":
                        return $PCME;
                        break;
                case "MEBA":
                        return $MEBA;
                        break;
                case "MSBA":
                        return $MSBA;
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
                case "HEPS":
                        return $HEPS;
                        break;
        }
    }

    
    function getAssessmentMark($totalMark,$exam_type,$labStatus,$subject_code){
        if(is_numeric($totalMark) && !empty($totalMark)){
            if($labStatus == 'false'){ 
                if($exam_type == 'ASSIGNMENT_I' || $exam_type == 'ASSIGNMENT_II'){
                    if($totalMark >= 81 && $totalMark <= 100){
                            return '30';
                    }else if($totalMark >= 71 && $totalMark <= 80){
                            return '25';
                    }else if($totalMark >= 61 && $totalMark <= 70){
                            return '20';
                    }else if($totalMark >= 51 && $totalMark <= 60){
                            return '15';
                    }else if($totalMark >= 41 && $totalMark <= 50){
                            return '10';
                    }else{
                            return '5';
                    }
                }
            }else{
                if($exam_type == 'ASSIGNMENT_I' && $subject_code == '12' || $exam_type == 'ASSIGNMENT_II' && $subject_code == '12'){
                    if($totalMark >= 26 && $totalMark <= 35){
                            return '4';
                    }else if($totalMark >= 36 && $totalMark <= 45){
                            return '8';
                    }else if($totalMark >= 46 && $totalMark <= 55){
                            return '12';
                    }else if($totalMark >= 56 && $totalMark <= 65){
                            return '16';
                    }else if($totalMark >= 66 && $totalMark <= 75){
                            return '20';
                    }else{
                            return '25';
                    }
                    }else if($exam_type == 'ASSIGNMENT_I' || $exam_type == 'ASSIGNMENT_II'){
                    if($totalMark >= 1 && $totalMark <= 28){
                            return '4';
                    }else if($totalMark >= 29 && $totalMark <= 35){
                            return '8';
                    }else if($totalMark >= 36 && $totalMark <= 42){
                            return '12';
                    }else if($totalMark >= 43 && $totalMark <= 49){
                            return '16';
                    }else if($totalMark >= 50 && $totalMark <= 56){
                            return '19';
                    }else{
                            return '22';
                    }
                }
            }
        }else{
                return '';
        }
    }
}
?>