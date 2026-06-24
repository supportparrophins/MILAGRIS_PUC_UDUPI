<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class StaffFeedback extends BaseController {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('students_model','student');
        $this->load->model('staff_model','staff');
        $this->load->model('staffFeedback_model','feedback');
        $this->load->model('Settings_model','settings');
        $this->load->model('feedback_model');
        $this->isLoggedIn();
    }


    public function feedbackEnabledStudents(){
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $filter = array();
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $by_name = $this->security->xss_clean($this->input->post('by_name'));
            $by_dob = $this->security->xss_clean($this->input->post('by_dob'));
            $by_term = $this->security->xss_clean($this->input->post('by_term'));
            $by_stream = $this->security->xss_clean($this->input->post('by_stream'));
            $by_Section = $this->security->xss_clean($this->input->post('by_Section'));

            $data['student_id'] = $student_id;
            $data['by_name'] = $by_name;
            $data['by_term'] = $by_term;
            $data['by_stream'] = $by_stream;
            $data['by_Section'] = $by_Section;

            $filter['student_id'] = $student_id;
            // $filter['application_no'] = $application_no;
            $filter['by_name'] = $by_name;
            $filter['by_term'] = $by_term;
            $filter['by_stream'] = $by_stream;
            $filter['by_Section'] = $by_Section;
            // $filter['year'] = $year;

            // if(!empty($by_dob)){
            //     $filter['by_dob'] = date('Y-m-d',strtotime($by_dob));
            //     $data['by_dob'] = date('d-m-Y',strtotime($by_dob));
            // }else{
            //     $data['by_dob'] = '';
            // }
            $data['streamInfo'] = $this->student->getAllStreamName();
            $this->load->library('pagination');
            $count = $this->feedback->getStudentFeedbackCount($filter);
            $returns = $this->paginationCompress("feedbackEnabledStudents/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['studentInfo'] = $this->feedback->getStudentFeedbackDetails($filter);
            $data['studentInfoSelection'] = $this->refund->getAllStudent();
            $data['streamInfo'] = $this->student->getAllStreamName();
            $data['disableStudent'] = $this->feedback;
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Enabled Student';
            $this->loadViews("staff_feedback/student_enabled", $this->global,$data, NULL);
        }
    }

    
    public function addStudentForFeedback() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('student_id','Student ID','trim|required');
            $this->form_validation->set_rules('feedback_type','Type','trim|required');

            if($this->form_validation->run() == FALSE) {
                redirect('feedbackEnabledStudents');
            } else {
                $student_id = $this->security->xss_clean($this->input->post('student_id'));
                $feedback_type = $this->security->xss_clean($this->input->post('feedback_type'));

                $feedbackInfo = array(
                    'student_id' => $student_id,
                    'feedback_type' => $feedback_type,
                    // 'description' => $description,
                    'year' => '2021',
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));
                $result = $this->feedback->addStudentDetailsForFeedback($feedbackInfo);
               
                if($result > 0){
                    $this->session->set_flashdata('success', 'Student Details added successfully');
                } else{
                    $this->session->set_flashdata('error', 'Failed to add student details');
                }
                redirect('feedbackEnabledStudents');
            }
        }
    }

    
    public function deleteStudentEnabled(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $feedbackInfo = array('is_deleted' => 1,'updated_by'=>$this->staff_id);
            $result = $this->feedback->updateStudentEnabledInfo($feedbackInfo, $row_id);
            if ($result == true) {
                echo (json_encode(array('status' => true)));
            } else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function viewStudentFeedbackOfStaff($staff_id){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }else{
            if($staff_id == NULL){
                $this->loadThis();
            }else{
                $studentCount[] = array();
                $feedbackGivenStudentIds = array();
                $qCountYes = array();
                $qCountNO = array();
                $studentCount[] = array();
                $feedbackGivenStudentIds = array();

               
                $qCountYes23 = array();
                $qCountNO23 = array();

                $this->global['pageTitle'] = 'Feedback Students Details';
                $data['staffInfo'] = $this->staff->getStaffInfoById($staff_id);
                
                if($data['staffInfo']->role_id == ROLE_TEACHING_STAFF || $data['staffInfo']->role_id == ROLE_PRIMARY_ADMINISTRATOR || $data['staffInfo']->role_id == ROLE_DIRECTOR || $data['staffInfo']->role_id == ROLE_PRINCIPAL){
                    // 2022
                    $data['commentsInfo'] = $this->feedback_model->getStudentCommentsAndSug($data['staffInfo']->staff_id);
                    $data['stdCommentInfo'] = $this->feedback_model->getStudentCommentsAndSug22($data['staffInfo']->staff_id);
                    $data['questions'] =  $this->feedback_model->getTeachingStaffFeedbackQuestions();
                    
                    foreach($data['questions'] as $q){
                        $qCountYes[$q->qid] = $this->feedback_model->getCountOfAnswersYES_NO($data['staffInfo']->staff_id, $q->qid, 1);
                        $qCountNO[$q->qid] = $this->feedback_model->getCountOfAnswersYES_NO($data['staffInfo']->staff_id, $q->qid, 0);

                        
                        $stdAnsCountExcellent_22[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_22($data['staffInfo']->staff_id, $q->qid, 5);
                        $stdAnsCountGood_22[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_22($data['staffInfo']->staff_id, $q->qid, 4);
                        $stdAnsCountfair_average_22[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_22($data['staffInfo']->staff_id, $q->qid, 3);
                        $stdAnsCountNot_Good_22[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_22($data['staffInfo']->staff_id, $q->qid, 2);
                        $stdAnsCountNot_Satisfactory22[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_22($data['staffInfo']->staff_id, $q->qid, 1);
                        // $stdAnsCountYes_21[$q->qid] = $this->feedback_model->getCountOfStdAnswersYES_NO_22($data['staffInfo']->staff_id, $q->qid, 1);
                        // $stdAnsCountNo_21[$q->qid] = $this->feedback_model->getCountOfStdAnswersYES_NO_22($data['staffInfo']->staff_id, $q->qid, 0);
                    }
                    // $data['qCountYes'] = $qCountYes;
                    // $data['qCountNO'] = $qCountNO;
                    $data['qCountExcellent'] = $stdAnsCountExcellent_22;
                    $data['qCountGood'] = $stdAnsCountGood_22;
                    $data['qCountFairAverage'] = $stdAnsCountfair_average_22;
                    $data['qCountNotGood'] = $stdAnsCountNot_Good_22;
                    $data['qCountNotSatisfactory'] = $stdAnsCountNot_Satisfactory22;

                // 2023
                 $data['stdCommentInfo23'] = $this->feedback_model->getStudentCommentsAndSug23($data['staffInfo']->staff_id);
                 $data['stdCommentInfo24'] = $this->feedback_model->getStudentCommentsAndSug24($data['staffInfo']->staff_id);
                 $data['questions23'] =  $this->feedback_model->getTeachingStaffFeedbackQuestions23();
                  foreach($data['questions23'] as $q){
                    $qCountYes23[$q->qid] = $this->feedback_model->getCountOfAnswersYES_NO23($data['staffInfo']->staff_id, $q->qid, 1);
                    $qCountNO23[$q->qid] = $this->feedback_model->getCountOfAnswersYES_NO23($data['staffInfo']->staff_id, $q->qid, 0);

                    
                    $stdAnsCountExcellent_23[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_23($data['staffInfo']->staff_id, $q->qid, 5);
                    $stdAnsCountGood_23[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_23($data['staffInfo']->staff_id, $q->qid, 4);
                    $stdAnsCountfair_average_23[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_23($data['staffInfo']->staff_id, $q->qid, 3);
                    $stdAnsCountNot_Good_23[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_23($data['staffInfo']->staff_id, $q->qid, 2);
                    $stdAnsCountNot_Satisfactory23[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_23($data['staffInfo']->staff_id, $q->qid, 1);
                   
                }
                    $data['qCountExcellent23'] = $stdAnsCountExcellent_23;
                    $data['qCountGood23'] = $stdAnsCountGood_23;
                    $data['qCountFairAverage23'] = $stdAnsCountfair_average_23;
                    $data['qCountNotGood23'] = $stdAnsCountNot_Good_23;
                    $data['qCountNotSatisfactory23'] = $stdAnsCountNot_Satisfactory23;

                    //2025
                  
                 $data['stdCommentInfo25'] = $this->feedback_model->getStudentCommentsAndSug25($data['staffInfo']->staff_id);
                 $data['questions25'] =  $this->feedback_model->getTeachingStaffFeedbackQuestions25();
                  foreach($data['questions25'] as $q){
                    $qCountYes25[$q->qid] = $this->feedback_model->getCountOfAnswersYES_NO25($data['staffInfo']->staff_id, $q->qid, 1);
                    $qCountNO25[$q->qid] = $this->feedback_model->getCountOfAnswersYES_NO25($data['staffInfo']->staff_id, $q->qid, 0);

                    
                    $stdAnsCountExcellent_25[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_25($data['staffInfo']->staff_id, $q->qid, 5);
                    $stdAnsCountGood_25[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_25($data['staffInfo']->staff_id, $q->qid, 4);
                    $stdAnsCountfair_average_25[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_25($data['staffInfo']->staff_id, $q->qid, 3);
                    $stdAnsCountNot_Good_25[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_25($data['staffInfo']->staff_id, $q->qid, 2);
                    $stdAnsCountNot_Satisfactory25[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_25($data['staffInfo']->staff_id, $q->qid, 1);
                   
                }
                    $data['qCountExcellent25'] = $stdAnsCountExcellent_25;
                    $data['qCountGood25'] = $stdAnsCountGood_25;
                    $data['qCountFairAverage25'] = $stdAnsCountfair_average_25;
                    $data['qCountNotGood25'] = $stdAnsCountNot_Good_25;
                    $data['qCountNotSatisfactory25'] = $stdAnsCountNot_Satisfactory25;

                }else{
                    $data['questions'] =  $this->feedback_model->getCounsellorFeedbackQuestionsAndAnswer($data['staffInfo']->staff_id);
                     $data['questions23'] =  $this->feedback_model->getCounsellorFeedbackQuestionsAndAnswer23($data['staffInfo']->staff_id);
                }
                $data['mgmtComment'] = $this->feedback_model->getStaffManagementFeedback($staff_id);
                $data['staffMgtComment'] = $this->feedback_model->getStaffManagementFeedback_22($staff_id);

                  $data['staffMgtComment23'] = $this->feedback_model->getStaffManagementFeedback_23($staff_id);
                  $data['staffMgtComment25'] = $this->feedback_model->getStaffManagementFeedback_25($staff_id);

                 $data['total_Feedback'] = $this->feedback->getCountOfTotalFeedback($data['staffInfo']->staff_id);
                 $data['staffSectionInfo'] = $this->staff->getSectionByStaffIdFOrFeedback($data['staffInfo']->staff_id);
                 $staffSectionInfo = $this->staff->getSectionByStaffIdFOrFeedback($data['staffInfo']->staff_id);
                 $feedBackGivenInfo = $this->feedback->getFeedbackGivenInfo($data['staffInfo']->staff_id);
                 foreach($feedBackGivenInfo as $fee){
                    array_push($feedbackGivenStudentIds, $fee->student_id);
                 }

                foreach($staffSectionInfo as $sect){

                    if($sect->section_name == 'INT'){
                        $studentCount[$sect->row_id] =  $this->feedback->getStudentInfoCountBySectionIdIntg($sect->term_name,$sect->section_name);
                        $studentGivenCount[$sect->row_id] =  $this->feedback->getFeedbackGivenCountIntg($sect->term_name,$sect->section_name,$data['staffInfo']->staff_id);
                        $feedbackPendingInfo[$sect->row_id] =  $this->feedback->getfeedbackPendingInfoIntg($sect->term_name,$sect->section_name,$feedbackGivenStudentIds); 
                    }else{
                        $studentCount[$sect->row_id] =  $this->feedback->getStudentInfoCountBySectionId($sect->term_name,$sect->section_name,$sect->stream_name);
                        $studentGivenCount[$sect->row_id] =  $this->feedback->getFeedbackGivenCount($sect->term_name,$sect->section_name,$sect->stream_name,$data['staffInfo']->staff_id);
                        $feedbackPendingInfo[$sect->row_id] =  $this->feedback->getfeedbackPendingInfo($sect->term_name,$sect->section_name,$sect->stream_name,$feedbackGivenStudentIds);    

                    }
                    
                }

                $data['studentCount'] = $studentCount;
                $data['studentGivenCount'] = $studentGivenCount;
                $data['feedbackPendingInfo'] = $feedbackPendingInfo;
                $this->loadViews("staffs/viewStudentFeedbackOfStaff", $this->global, $data , NULL);
            }
        }      
    }


    public function viewStaffFeedbackOfPrincipal(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }else{
            // if($staff_id == NULL){
            //     $this->loadThis();
            // }else{


                $studentCount[] = array();
                $feedbackGivenStudentIds = array();
                $qCountYes = array();
                $qCountNO = array();
                $studentCount[] = array();
                $feedbackGivenStudentIds = array();

               
                $qCountYes23 = array();
                $qCountNO23 = array();

                $this->global['pageTitle'] = 'Feedback Staff Details';
                $staff_id = $this->staff_id;
                $data['staffInfo'] = $this->staff->getStaffInfoByIdTwo($staff_id);

                
                // if($data['staffInfo']->role_id == ROLE_TEACHING_STAFF || $data['staffInfo']->role_id == ROLE_PRIMARY_ADMINISTRATOR || $data['staffInfo']->role_id == ROLE_DIRECTOR || $data['staffInfo']->role_id == ROLE_PRINCIPAL){
                    // 2022
                    $data['questions'] =  $this->feedback_model->getTeachingStaffFeedbackQuestions();
                    
                

                // 2023
                //  $data['stdCommentInfo23'] = $this->feedback_model->getStudentCommentsAndSug23($data['staffInfo']->staff_id);
                //  $data['stdCommentInfo24'] = $this->feedback_model->getStudentCommentsAndSug24($data['staffInfo']->staff_id);
                 $data['questions23'] =  $this->staff->getStaffFeedbackQuestions();

                  foreach($data['questions23'] as $q){
                    $qCountYes23[$q->qid] = $this->feedback_model->getCountOfAnswersYES_NO23($data['staffInfo']->staff_id, $q->qid, 1);
                    $qCountNO23[$q->qid] = $this->feedback_model->getCountOfAnswersYES_NO23($data['staffInfo']->staff_id, $q->qid, 0);

                    $NA_22[$q->qid] = $this->feedback_model->getCountOfStaffAnswersExcellent_Good($data['staffInfo']->staff_id, $q->qid, 'NA','SJI0045'); 
                    $stdAnsCountExcellent_23[$q->qid] = $this->feedback_model->getCountOfStaffAnswersExcellent_Good($data['staffInfo']->staff_id, $q->qid, 5,'SJI0045');
                    $stdAnsCountGood_23[$q->qid] = $this->feedback_model->getCountOfStaffAnswersExcellent_Good($data['staffInfo']->staff_id, $q->qid, 4,'SJI0045');
                    $stdAnsCountfair_average_23[$q->qid] = $this->feedback_model->getCountOfStaffAnswersExcellent_Good($data['staffInfo']->staff_id, $q->qid, 3,'SJI0045');
                    $stdAnsCountNot_Good_23[$q->qid] = $this->feedback_model->getCountOfStaffAnswersExcellent_Good($data['staffInfo']->staff_id, $q->qid, 2,'SJI0045');
                    $stdAnsCountNot_Satisfactory23[$q->qid] = $this->feedback_model->getCountOfStaffAnswersExcellent_Good($data['staffInfo']->staff_id, $q->qid, 1,'SJI0045');
                    $stdAnsComments[$q->qid] = $this->feedback_model->getCommentsOfStaffAns($data['staffInfo']->staff_id, $q->qid,'SJI0045');
                  
                }
                    $data['qCountExcellent23'] = $stdAnsCountExcellent_23;
                    $data['qCountGood23'] = $stdAnsCountGood_23;
                    $data['qCountFairAverage23'] = $stdAnsCountfair_average_23;
                    $data['qCountNotGood23'] = $stdAnsCountNot_Good_23;
                    $data['qCountNotSatisfactory23'] = $stdAnsCountNot_Satisfactory23;
                    $data['qCountNA'] = $NA_22;
                    $data['stdAnsComments'] = $stdAnsComments;

                $data['mgmtComment'] = $this->feedback_model->getStaffManagementFeedback($staff_id);
                $data['staffMgtComment'] = $this->feedback_model->getStaffManagementFeedback_22($staff_id);

                  $data['staffMgtComment23'] = $this->feedback_model->getStaffComments($data['staffInfo']->staff_id,'SJI0045');

                 $data['total_Feedback'] = $this->feedback->getCountOfTotalFeedback($data['staffInfo']->staff_id);             

           

                $data['studentCount'] = $studentCount;
                $data['studentGivenCount'] = $studentGivenCount;
                $data['feedbackPendingInfo'] = $feedbackPendingInfo;

                $this->loadViews("staffs/viewStaffFeedbackOfPrincipal", $this->global, $data , NULL);
            
        }      
    }



    public function viewStaffFeedbackOfVicePrincipal(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }else{
            // if($staff_id == NULL){
            //     $this->loadThis();
            // }else{

                $studentCount[] = array();
                $feedbackGivenStudentIds = array();
                $qCountYes = array();
                $qCountNO = array();
                $studentCount[] = array();
                $feedbackGivenStudentIds = array();

               
                $qCountYes23 = array();
                $qCountNO23 = array();

                $this->global['pageTitle'] = 'Feedback Staff Details';
                $staff_id = $this->staff_id;
                $data['staffInfo'] = $this->staff->getStaffInfoByIdTwo($staff_id);

                
                // if($data['staffInfo']->role_id == ROLE_TEACHING_STAFF || $data['staffInfo']->role_id == ROLE_PRIMARY_ADMINISTRATOR || $data['staffInfo']->role_id == ROLE_DIRECTOR || $data['staffInfo']->role_id == ROLE_PRINCIPAL){
                    // 2022
                    $data['questions'] =  $this->feedback_model->getTeachingStaffFeedbackQuestions();
                    
                

                // 2023
                //  $data['stdCommentInfo23'] = $this->feedback_model->getStudentCommentsAndSug23($data['staffInfo']->staff_id);
                //  $data['stdCommentInfo24'] = $this->feedback_model->getStudentCommentsAndSug24($data['staffInfo']->staff_id);
                 $data['questions23'] =  $this->staff->getStaffFeedbackQuestions();

                  foreach($data['questions23'] as $q){
                    $qCountYes23[$q->qid] = $this->feedback_model->getCountOfAnswersYES_NO23($data['staffInfo']->staff_id, $q->qid, 1);
                    $qCountNO23[$q->qid] = $this->feedback_model->getCountOfAnswersYES_NO23($data['staffInfo']->staff_id, $q->qid, 0);

                    $NA_22[$q->qid] = $this->feedback_model->getCountOfStaffAnswersExcellent_Good($data['staffInfo']->staff_id, $q->qid, 'NA','SJI0034'); 
                    $stdAnsCountExcellent_23[$q->qid] = $this->feedback_model->getCountOfStaffAnswersExcellent_Good($data['staffInfo']->staff_id, $q->qid, 5,'SJI0034');
                    $stdAnsCountGood_23[$q->qid] = $this->feedback_model->getCountOfStaffAnswersExcellent_Good($data['staffInfo']->staff_id, $q->qid, 4,'SJI0034');
                    $stdAnsCountfair_average_23[$q->qid] = $this->feedback_model->getCountOfStaffAnswersExcellent_Good($data['staffInfo']->staff_id, $q->qid, 3,'SJI0034');
                    $stdAnsCountNot_Good_23[$q->qid] = $this->feedback_model->getCountOfStaffAnswersExcellent_Good($data['staffInfo']->staff_id, $q->qid, 2,'SJI0034');
                    $stdAnsCountNot_Satisfactory23[$q->qid] = $this->feedback_model->getCountOfStaffAnswersExcellent_Good($data['staffInfo']->staff_id, $q->qid, 1,'SJI0034');
                    $stdAnsComments[$q->qid] = $this->feedback_model->getCommentsOfStaffAns($data['staffInfo']->staff_id, $q->qid,'SJI0034');
                  
                }
                    $data['qCountExcellent23'] = $stdAnsCountExcellent_23;
                    $data['qCountGood23'] = $stdAnsCountGood_23;
                    $data['qCountFairAverage23'] = $stdAnsCountfair_average_23;
                    $data['qCountNotGood23'] = $stdAnsCountNot_Good_23;
                    $data['qCountNotSatisfactory23'] = $stdAnsCountNot_Satisfactory23;
                    $data['qCountNA'] = $NA_22;
                    $data['stdAnsComments'] = $stdAnsComments;

                $data['mgmtComment'] = $this->feedback_model->getStaffManagementFeedback($staff_id);
                $data['staffMgtComment'] = $this->feedback_model->getStaffManagementFeedback_22($staff_id);

                  $data['staffMgtComment23'] = $this->feedback_model->getStaffComments($data['staffInfo']->staff_id,'SJI0034');

                 $data['total_Feedback'] = $this->feedback->getCountOfTotalFeedback($data['staffInfo']->staff_id);             

           

                $data['studentCount'] = $studentCount;
                $data['studentGivenCount'] = $studentGivenCount;
                $data['feedbackPendingInfo'] = $feedbackPendingInfo;

                $this->loadViews("staffs/viewStaffFeedbackOfPrincipal", $this->global, $data , NULL);
            
        }      
    }



    public function addCommentToFeedbackByPrincipal($staff_id){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if($staff_id == NULL){
                $this->loadThis();
            }else{
                $comment = $this->input->post('comment');
                $year = $this->input->post('year');

                $commentInfo = array(
                    'staff_row_id' => $staff_id,
                    'response' => $comment,
                    'year' => $year,
                    'created_by' => $this->staff_id
                );

                $mgmtComment = $this->feedback_model->getAllStaffManagementFeedback($staff_id,$year);
                if(!empty($mgmtComment)){
                    $return_id = $this->feedback_model->updateCommentToStaffFeedback($staff_id,$year,$commentInfo);
                }else{
                    $return_id = $this->feedback_model->addCommentToStaffFeedback($commentInfo);
                }

                if($return_id == true){
                    $this->session->set_flashdata('success', 'Comment updated Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Comment update Failed');
                }
                redirect('viewStudentFeedbackOfStaff/'.$staff_id);
            }
        }
    }

    public function pintStudentFeedbackResponse_22($staff_id){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            if($staff_id == NULL){
                $this->loadThis();
            }else{
                $qCountYes = array();
                $qCountNO = array();

                $this->global['pageTitle'] = 'Print Student Feedback';
                $data['staffInfo'] = $this->staff->getStaffInfoById($staff_id);
                if($data['staffInfo']->role_id == ROLE_TEACHING_STAFF){
                    $data['commentsInfo'] = $this->feedback_model->getStudentCommentsAndSug22($data['staffInfo']->staff_id);
                    $data['questions'] =  $this->feedback_model->getTeachingStaffFeedbackQuestions();
                    foreach($data['questions'] as $q){
                        
                        $stdAnsCountExcellent_22[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_22($data['staffInfo']->staff_id, $q->qid, 5);
                        $stdAnsCountGood_22[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_22($data['staffInfo']->staff_id, $q->qid, 4);
                        $stdAnsCountfair_average_22[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_22($data['staffInfo']->staff_id, $q->qid, 3);
                        $stdAnsCountNot_Good_22[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_22($data['staffInfo']->staff_id, $q->qid, 2);
                        $stdAnsCountNot_Satisfactory22[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_22($data['staffInfo']->staff_id, $q->qid, 1);
                    }
                    $data['qCountExcellent'] = $stdAnsCountExcellent_22;
                    $data['qCountGood'] = $stdAnsCountGood_22;
                    $data['qCountFairAverage'] = $stdAnsCountfair_average_22;
                    $data['qCountNotGood'] = $stdAnsCountNot_Good_22;
                    $data['qCountNotSatisfactory'] = $stdAnsCountNot_Satisfactory22;
                }else{
                    $data['questions'] =  $this->feedback_model->getCounsellorFeedbackQuestionsAndAnswer($data['staffInfo']->staff_id);
                }

                $data['mgmtComment'] = $this->feedback_model->getStaffManagementFeedback_22($staff_id);
                $this->loadViews("staffs/printStudentFeedbackResponse_22", $this->global, $data , NULL);
            }
        }      
    }

          public function pintStudentFeedbackResponse_23($staff_id){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            if($staff_id == NULL){
                $this->loadThis();
            }else{
                $qCountYes = array();
                $qCountNO = array();

                $this->global['pageTitle'] = 'Print Student Feedback';
                $data['staffInfo'] = $this->staff->getStaffInfoById($staff_id);
                if($data['staffInfo']->role_id == ROLE_TEACHING_STAFF || $data['staffInfo']->role_id == ROLE_PRINCIPAL || $data['staffInfo']->role_id == ROLE_PRIMARY_ADMINISTRATOR || $data['staffInfo']->role_id == ROLE_ADMIN){
                    $data['commentsInfo'] = $this->feedback_model->getStudentCommentsAndSug23($data['staffInfo']->staff_id);
                    $data['questions'] =  $this->feedback_model->getTeachingStaffFeedbackQuestions23();
                    foreach($data['questions'] as $q){
                        
                        $stdAnsCountExcellent_22[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_25($data['staffInfo']->staff_id, $q->qid, 5);
                        $stdAnsCountGood_22[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_25($data['staffInfo']->staff_id, $q->qid, 4);
                        $stdAnsCountfair_average_22[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_25($data['staffInfo']->staff_id, $q->qid, 3);
                        $stdAnsCountNot_Good_22[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_25($data['staffInfo']->staff_id, $q->qid, 2);
                        $stdAnsCountNot_Satisfactory22[$q->qid] = $this->feedback_model->getCountOfStdAnswersExcellent_Good_25($data['staffInfo']->staff_id, $q->qid, 1);
                    }
                    $data['qCountExcellent'] = $stdAnsCountExcellent_22;
                    $data['qCountGood'] = $stdAnsCountGood_22;
                    $data['qCountFairAverage'] = $stdAnsCountfair_average_22;
                    $data['qCountNotGood'] = $stdAnsCountNot_Good_22;
                    $data['qCountNotSatisfactory'] = $stdAnsCountNot_Satisfactory22;
                }else{
                    $data['questions'] =  $this->feedback_model->getCounsellorFeedbackQuestionsAndAnswer($data['staffInfo']->staff_id);
                }

                $data['mgmtComment'] = $this->feedback_model->getStaffManagementFeedback_25($staff_id);
                $this->loadViews("staffs/printStudentFeedbackResponse_24", $this->global, $data , NULL);
            }
        }      
    }  

}
?>