<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Feedback extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
        $this->load->model('user_model');
        $this->load->model('students_model');
        $this->load->model('staff_model');
        $this->load->model('feedback_model');
        $this->isLoggedIn();
    }

    public function addStudentToFeedbackTable()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $type_feedback = $this->security->xss_clean($this->input->post('type_feedback'));
            $students = json_decode(stripslashes($this->input->post('students')));

            foreach ($students as $std_id) {
                $std = $this->students_model->getSingleStudentInfoById($std_id, $term_name);
                $stdInfo = array(
                    'student_name' => $std->student_name,
                    'student_id' => $std->student_id,
                    'term_name' => $std->term_name,
                    'section_name' => $std->section_name,
                    'stream_name' => $std->stream_name,
                    'feedback_type' => $type_feedback,
                );
                $result = $this->feedback_model->addNewStudentForFeedback($stdInfo);
            }

            if ($result > 1) {
                $data = "true";
            } else {
                $data = "false";
            }
            header('Content-type: text/plain');
            // set json non IE
            header('Content-type: application/json');
            echo json_encode($data);
            exit(0);
        }
    }



    public function getFeedbackStudentInfo()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $filter = array();
            $student_name = $this->security->xss_clean($this->input->post('student_name'));
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $feedback_type =  $this->security->xss_clean($this->input->post('feedback_type'));
            $by_stream_name =  $this->security->xss_clean($this->input->post('by_stream_name'));
            $section_name =  $this->security->xss_clean($this->input->post('section_name'));
            $term_name =  $this->security->xss_clean($this->input->post('term_name'));

            $data['student_name'] = $student_name;
            $data['by_preference'] = $by_stream_name;
            $data['student_id'] = $student_id;
            $data['section_name'] = $section_name;
            $data['feedback_type'] = $feedback_type;

            $filter['section_name'] = $section_name;
            $filter['student_id'] = $student_id;
            $filter['student_name'] = $student_name;
            $filter['term_name'] = $term_name;
            $filter['by_preference'] = $by_stream_name;
            $filter['feedback_type'] = $feedback_type;

            $this->load->library('pagination');
            $count = $this->feedback_model->getEnabledFeedbackStudentsCount($filter);
            $returns = $this->paginationCompress("getFeedbackStudentInfo/", $count, 100);
            $data['count_students'] = $count;
            $data['studentInfoSelection'] = $this->feedback_model->getAllStudent();
            $data['disableStudent'] = $this->feedback_model;
            $data['streamInfo'] = $this->students_model->getAllStreamName();
            $data['studentRecords'] = $this->feedback_model->getEnabledFeedbackStudentsDetails($returns["page"], $returns["segment"], $filter);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Enable Feedback Students Details';
            //$data['smsBalance'] = $this->getSMS_balance();
            $this->loadViews("feedback/feedbackStudentInfo", $this->global, $data, NULL);
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
                redirect('getFeedbackStudentInfo');
            } else {
                $student_id = $this->security->xss_clean($this->input->post('student_id'));
                $feedback_type = $this->security->xss_clean($this->input->post('feedback_type'));
                $student_info = $this->feedback_model->getStudentInfo($student_id);
                
                $feedbackInfo = array(
                    'student_id' => $student_id,
                    'feedback_type' => $feedback_type,
                    'term_name' => $student_info->term_name,
                    'section_name' => $student_info->section_name,
                    'stream_name' => $student_info->stream_name,
                    'student_name' => $student_info->student_name,
                    'created_by'=> $this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));
                $result = $this->feedback_model->addStudentDetailsForFeedback($feedbackInfo);
               
                if($result > 0){
                    $this->session->set_flashdata('success', 'Student Details added successfully');
                } else{
                    $this->session->set_flashdata('error', 'Failed to add student details');
                }
                redirect('getFeedbackStudentInfo');
            }
        }
    }

    public function deleteStudentEnabled(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $feedbackInfo = array('is_deleted' => 1,'updated_by'=>$this->staff_id);
            $result = $this->feedback_model->updateStudentEnabledInfo($feedbackInfo, $row_id);
            if ($result == true) {
                echo (json_encode(array('status' => true)));
            } else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function viewStudentFeedbackByStaff($staff_id)
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            if ($staff_id == NULL) {
                $this->loadThis();
            } else {

                $qCountYes = array();
                $qCountNO = array();

                $this->global['pageTitle'] = ''.TAB_TITLE.' : Feedback Students Details';
                $data['staffInfo'] = $this->staff_model->getStaffInfoById($staff_id);

                if ($data['staffInfo']->role_id == ROLE_COUNSELOR) {
                    $data['questions'] =  $this->feedback_model->getCounsellorFeedbackQuestionsAndAnswer($data['staffInfo']->staff_id);
                } else {
                    $data['commentsInfo'] = $this->feedback_model->getStudentCommentsAndSug($data['staffInfo']->staff_id);
                    $data['stdCommentInfo'] = $this->feedback_model->getStudentCommentsAndSug21($data['staffInfo']->staff_id);
                    $data['stdCommentInfo22'] = $this->feedback_model->getStudentCommentsAndSug22($data['staffInfo']->staff_id);
                    $data['stdCommentInfo23'] = $this->feedback_model->getStudentCommentsAndSug23($data['staffInfo']->staff_id);
                    $data['questions'] =  $this->feedback_model->getTeachingStaffFeedbackQuestions();

                    foreach ($data['questions'] as $q) {
                        $qCountYes[$q->qid] = $this->feedback_model->getCountOfAnswersYES_NO($data['staffInfo']->staff_id, $q->qid, 1);
                        $qCountNO[$q->qid] = $this->feedback_model->getCountOfAnswersYES_NO($data['staffInfo']->staff_id, $q->qid, 0);

                        $stdAnsCountYes_21[$q->qid] = $this->feedback_model->getCountOfStdAnswersYES_NO_21($data['staffInfo']->staff_id, $q->qid, 1);
                        $stdAnsCountNo_21[$q->qid] = $this->feedback_model->getCountOfStdAnswersYES_NO_21($data['staffInfo']->staff_id, $q->qid, 0);

                        $stdAnsCountYes_22[$q->qid] = $this->feedback_model->getCountOfStdAnswersYES_NO_22($data['staffInfo']->staff_id, $q->qid, 1);
                        $stdAnsCountNo_22[$q->qid] = $this->feedback_model->getCountOfStdAnswersYES_NO_22($data['staffInfo']->staff_id, $q->qid, 0);

                        
                        $stdAnsCountYes_23[$q->qid] = $this->feedback_model->getCountOfStdAnswersYES_NO_23($data['staffInfo']->staff_id, $q->qid, 1);
                        $stdAnsCountNo_23[$q->qid] = $this->feedback_model->getCountOfStdAnswersYES_NO_23($data['staffInfo']->staff_id, $q->qid, 0);
                    }
                    $data['qCountYes'] = $qCountYes;
                    $data['qCountNO'] = $qCountNO;

                    $data['qStdCountYes'] = $stdAnsCountYes_21;
                    $data['qStdCountNo'] = $stdAnsCountNo_21;
                    
                    $data['qStdCountYes22'] = $stdAnsCountYes_22;
                    $data['qStdCountNo22'] = $stdAnsCountNo_22;

                    $data['qStdCountYes23'] = $stdAnsCountYes_23;
                    $data['qStdCountNo23'] = $stdAnsCountNo_23;
                }
                $data['mgmtComment'] = $this->feedback_model->getStaffManagementFeedback($staff_id);
                $data['princiComment'] = $this->feedback_model->getCouncellorManagementFeedback($staff_id);
                $data['staffMgtComment'] = $this->feedback_model->getStaffManagementFeedback_21($staff_id);
                $data['staffMgtComment22'] = $this->feedback_model->getStaffManagementFeedback_22($staff_id);
                $data['staffMgtComment23'] = $this->feedback_model->getStaffManagementFeedback_23($staff_id);
                $this->loadViews("staffs/viewStudentFeedbackByStaff", $this->global, $data, NULL);
            }
        }
    }

    //delete a class completed info
    public function addCommentToFeedbackByPrincipal($staff_id)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if ($staff_id == NULL) {
                $this->loadThis();
            } else {
                $comment = $this->input->post('comment');
                $suggestion = $this->input->post('suggestion');
                $year = $this->input->post('year');

                $commentInfo = array(
                    'staff_row_id' => $staff_id,
                    'response' => $comment,
                    'suggestion' =>$suggestion,
                    'year' => $year,
                    'created_by' => $this->staff_id
                );

                $mgmtComment = $this->feedback_model->getAllStaffManagementFeedback($staff_id, $year);
                if (!empty($mgmtComment)) {
                    $return_id = $this->feedback_model->updateCommentToStaffFeedback($staff_id, $year, $commentInfo);
                } else {
                    $return_id = $this->feedback_model->addCommentToStaffFeedback($commentInfo);
                }
                
                if ($return_id == true) {
                    $this->session->set_flashdata('success', 'Comment updated Successfully');
                } else {
                    $this->session->set_flashdata('error', 'Comment update Failed');
                }
                redirect('viewStudentFeedbackByStaff/' . $staff_id);
            }
        }
    }

    public function pintStudentFeedbackResponse($staff_id)
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            if ($staff_id == NULL) {
                $this->loadThis();
            } else {
                $qCountYes = array();
                $qCountNO = array();

                $this->global['pageTitle'] = ''.TAB_TITLE.' : Print Student Feedback';
                $data['staffInfo'] = $this->staff_model->getStaffInfoById($staff_id);
                if ($data['staffInfo']->role_id == ROLE_COUNSELOR) {
                    $data['questions'] =  $this->feedback_model->getCounsellorFeedbackQuestionsAndAnswer($data['staffInfo']->staff_id);
                } else {
                    $data['commentsInfo'] = $this->feedback_model->getStudentCommentsAndSug($data['staffInfo']->staff_id);
                    $data['questions'] =  $this->feedback_model->getTeachingStaffFeedbackQuestions();
                    foreach ($data['questions'] as $q) {
                        $qCountYes[$q->qid] = $this->feedback_model->getCountOfAnswersYES_NO($data['staffInfo']->staff_id, $q->qid, 1);
                        $qCountNO[$q->qid] = $this->feedback_model->getCountOfAnswersYES_NO($data['staffInfo']->staff_id, $q->qid, 0);
                    }
                    $data['qCountYes'] = $qCountYes;
                    $data['qCountNO'] = $qCountNO;
                }

                $data['mgmtComment'] = $this->feedback_model->getStaffManagementFeedback($staff_id);
                $this->loadViews("staffs/printStudentFeedbackResponse", $this->global, $data, NULL);
            }
        }
    }

    public function pintStudentFeedbackResponse_21($staff_id)
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            if ($staff_id == NULL) {
                $this->loadThis();
            } else {
                $qCountYes = array();
                $qCountNO = array();

                $this->global['pageTitle'] = ''.TAB_TITLE.' : Print Student Feedback';
                $data['staffInfo'] = $this->staff_model->getStaffInfoById($staff_id);
                if ($data['staffInfo']->role_id == ROLE_COUNSELOR) {
                    $data['questions'] =  $this->feedback_model->getCounsellorFeedbackQuestionsAndAnswer($data['staffInfo']->staff_id);
                } else {
                    $data['commentsInfo'] = $this->feedback_model->getStudentCommentsAndSug21($data['staffInfo']->staff_id);
                    $data['questions'] =  $this->feedback_model->getTeachingStaffFeedbackQuestions();
                    foreach ($data['questions'] as $q) {

                        $stdAnsCountYes_21[$q->qid] = $this->feedback_model->getCountOfStdAnswersYES_NO_21($data['staffInfo']->staff_id, $q->qid, 1);
                        $stdAnsCountNo_21[$q->qid] = $this->feedback_model->getCountOfStdAnswersYES_NO_21($data['staffInfo']->staff_id, $q->qid, 0);
                    }
                    $data['qCountYes'] = $stdAnsCountYes_21;
                    $data['qCountNO'] = $stdAnsCountNo_21;
                }

                $data['mgmtComment'] = $this->feedback_model->getStaffManagementFeedback_21($staff_id);
                $this->loadViews("staffs/printStudentFeedbackResponse_21", $this->global, $data, NULL);
            }
        }
    }

    
    public function pintStudentFeedbackResponse_22($staff_id)
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            if ($staff_id == NULL) {
                $this->loadThis();
            } else {
                $qCountYes = array();
                $qCountNO = array();

                $this->global['pageTitle'] = ''.TAB_TITLE.' : Print Student Feedback';
                $data['staffInfo'] = $this->staff_model->getStaffInfoById($staff_id);
                if ($data['staffInfo']->role_id == ROLE_COUNSELOR) {
                    $data['questions'] =  $this->feedback_model->getCounsellorFeedbackQuestionsAndAnswer($data['staffInfo']->staff_id);
                } else {
                    $data['stdCommentInfo22'] = $this->feedback_model->getStudentCommentsAndSug22($data['staffInfo']->staff_id);
                    $data['questions'] =  $this->feedback_model->getTeachingStaffFeedbackQuestions();
                    foreach ($data['questions'] as $q) {

                        $stdAnsCountYes_22[$q->qid] = $this->feedback_model->getCountOfStdAnswersYES_NO_22($data['staffInfo']->staff_id, $q->qid, 1);
                        $stdAnsCountNo_22[$q->qid] = $this->feedback_model->getCountOfStdAnswersYES_NO_22($data['staffInfo']->staff_id, $q->qid, 0);
                    }
                    $data['qCountYes'] = $stdAnsCountYes_22;
                    $data['qCountNO'] = $stdAnsCountNo_22;
                }

                $data['mgmtComment'] = $this->feedback_model->getStaffManagementFeedback_22($staff_id);
                $this->loadViews("staffs/printStudentFeedbackResponse_22", $this->global, $data, NULL);
            }
        }
    }

    public function pintStudentFeedbackResponse_23($staff_id)
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            if ($staff_id == NULL) {
                $this->loadThis();
            } else {
                $qCountYes = array();
                $qCountNO = array();

                $this->global['pageTitle'] = ''.TAB_TITLE.' : Print Student Feedback';
                $data['staffInfo'] = $this->staff_model->getStaffInfoById($staff_id);
                if ($data['staffInfo']->role_id == ROLE_COUNSELOR) {
                    $data['questions'] =  $this->feedback_model->getCounsellorFeedbackQuestionsAndAnswer($data['staffInfo']->staff_id);
                } else {
                    $data['stdCommentInfo23'] = $this->feedback_model->getStudentCommentsAndSug23($data['staffInfo']->staff_id);
                    $data['questions'] =  $this->feedback_model->getTeachingStaffFeedbackQuestions();
                    foreach ($data['questions'] as $q) {

                        $stdAnsCountYes_23[$q->qid] = $this->feedback_model->getCountOfStdAnswersYES_NO_23($data['staffInfo']->staff_id, $q->qid, 1);
                        $stdAnsCountNo_23[$q->qid] = $this->feedback_model->getCountOfStdAnswersYES_NO_23($data['staffInfo']->staff_id, $q->qid, 0);
                    }
                    $data['qCountYes'] = $stdAnsCountYes_23;
                    $data['qCountNO'] = $stdAnsCountNo_23;
                }

                $data['mgmtComment'] = $this->feedback_model->getStaffManagementFeedback_23($staff_id);
                $this->loadViews("staffs/printStudentFeedbackResponse_23", $this->global, $data, NULL);
            }
        }
    }

    public function pintStudentCouncellorFeedbackResponse($staff_id)
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            if ($staff_id == NULL) {
                $this->loadThis();
            } else {

                $this->global['pageTitle'] = ''.TAB_TITLE.' : Print Student Feedback';
                $data['staffInfo'] = $this->staff_model->getStaffInfoById($staff_id);
                $data['questions'] =  $this->feedback_model->getCounsellorFeedbackQuestionsAndAnswer($data['staffInfo']->staff_id);
                $data['mgmtComment'] = $this->feedback_model->getStaffManagementFeedback_22($staff_id);
                $this->loadViews("staffs/printStudentCouncellorFeedback", $this->global, $data, NULL);
            }
        }
    }

    

    public function addMultipleStudentForFeedback() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $student_id = json_decode(stripslashes($this->input->post('student_id')));
            $feedback_type = $this->input->post('feedback_type');
            foreach($student_id as $std){
                $student_info = $this->feedback_model->getStudentInfo($std);
                $feedbackInfo = array(
                    'student_id' => $student_info->student_id,
                    'feedback_type' => $feedback_type,
                    'term_name' => $student_info->term_name,
                    'section_name' => $student_info->section_name,
                    'stream_name' => $student_info->stream_name,
                    'student_name' => $student_info->student_name,
                    'created_by'=> $this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));
                    $isExists =  $this->feedback_model->getStudentEnabledInfo($student_info->student_id,$feedback_type);
                    if(empty($isExists)){
                        $result = $this->feedback_model->addStudentDetailsForFeedback($feedbackInfo);
                    }
            }
            header('Content-type: text/plain'); 
            header('Content-type: application/json'); 
            echo json_encode($result);
            exit(0); 
        }
    }

    public function deleteMultipleStudent() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $row_id = json_decode(stripslashes($this->input->post('row_id')));
            foreach($row_id as $id){
                $feedbackInfo = array('is_deleted' => 1,'updated_by'=>$this->staff_id);
                $result = $this->feedback_model->updateStudentEnabledInfo($feedbackInfo, $id);
            }
            header('Content-type: text/plain'); 
            header('Content-type: application/json'); 
            echo json_encode($result);
            exit(0); 
        }
    }
}
