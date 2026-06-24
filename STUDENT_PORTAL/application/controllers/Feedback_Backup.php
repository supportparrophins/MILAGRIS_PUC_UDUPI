<?php if(!defined('BASEPATH')) exit('No direct script access allowed');



require APPPATH . '/libraries/BaseController.php';



class Feedback extends BaseController

{

    /* This is default constructor of the class */

    public function __construct()

    {

        parent::__construct();

        $this->load->model('feedback_model');

        $this->load->model('student_model');

        $this->isLoggedIn();   

    }

    public function viewStaffForFeedback(){

        $data['feedbackStaffInfo'] = $this->feedback_model->getMyTeachingStaffInfo($this->term_name,$this->section_name);

        $data['feedbacQuestions'] = $this->feedback_model->getStudentFeedbackQuestions();

        $teachingFeedbackEnabled = $this->feedback_model->checkStudentFeedbackIsEnabled($this->student_id,'TEACHING');

        if(!empty($teachingFeedbackEnabled)){

        if($teachingFeedbackEnabled->feedback_type == 'TEACHING'){

            $data['isExist'] = $this->feedback_model->getGivenFeedbackInfoByStudent($this->student_id);

            $this->global['pageTitle'] = 'Schoolphins - SJPUC : Staff Feedback' ;

            $this->loadViews("feedback/student_feedback_teaching_staff", $this->global, $data, NULL);    

        }else{

            $this->loadThis();

        }

      }else{

        $this->loadThis();

      }

    }

    

    public function viewSadhanaStaffForFeedback(){

        $teachingFeedbackEnabled = $this->feedback_model->checkStudentFeedbackIsEnabled($this->student_id,'COUNSELLOR');

        if(!empty($teachingFeedbackEnabled)){

        if($teachingFeedbackEnabled->feedback_type == 'COUNSELLOR'){

            $data['feedbackStaffInfo'] = $this->feedback_model->getMyCounsellorStaffInfo();

            $data['feedbacQuestions'] = $this->feedback_model->getStudentCounsellorFeedbackQuestions();

            $data['feedbackCounsellorStatus'] = $teachingFeedbackEnabled;

            $this->global['pageTitle'] = 'Schoolphins - SJPUC : Sadhana Staff Feedback' ;

            $this->loadViews("feedback/student_feedback_sadhana", $this->global, $data, NULL);

        }else{

             $this->loadThis();

        }

    }else{

        $this->loadThis();

    }

    

    }





    public function saveMyFeedback(){

        $staff_id = $this->security->xss_clean($this->input->post('staff_id'));



        $impression = $this->security->xss_clean($this->input->post('impression'));

        $suggestions = $this->security->xss_clean($this->input->post('suggestions'));

        $feedbackInfo = array(

            'student_id' =>$this->student_id,

            'staff_id' => $staff_id,

            'feedback_year' => 2023,

            'comments_impression' => $impression,

            'suggestion' => $suggestions,

            'created_by' => $this->student_id,

            'created_date_time' => date('Y-m-d h:m:s')

        );



        $feedbacQuestions = $this->feedback_model->getStudentFeedbackQuestions();

        foreach($feedbacQuestions as $q){

            $ans = $this->security->xss_clean($this->input->post('answer_'.$q->qid));

            $answer = array(

                'student_id' => $this->student_id,

                'staff_id' => $staff_id,

                'qid' => $q->qid,

                'answer' => $ans,

                'feedback_year' => 2023,

                'created_by' => $this->student_id,

                'created_date_time' => date('Y-m-d h:m:s')

            );

            $this->feedback_model->addQuestionAnswerStaffFeedback($answer);

        }

        



        $result = $this->feedback_model->addFeedbackToStaff($feedbackInfo);

        if($result > 0) { 

            $this->session->set_flashdata('success', 'Feedback Sent Successfully'); 

        }else { 

            $this->session->set_flashdata('error', 'Feedback failed'); 

        }

        redirect('viewStaffForFeedback');

    }





    public function saveMyCounsellorFeedback(){

        $staff_id = $this->security->xss_clean($this->input->post('staff_id'));

        $feedbackInfo = array(

            'student_id' =>$this->student_id,

            'staff_id' => $staff_id,

            'feedback_year' => 2023,

            'comments_impression' => '',

            'suggestion' => '',

            'created_by' => $this->student_id,

            'created_date_time' => date('Y-m-d h:m:s')

        );

        $feedbacQuestions = $this->feedback_model->getStudentCounsellorFeedbackQuestions();

        foreach($feedbacQuestions as $q){

            $ans = $this->security->xss_clean($this->input->post('answer_'.$q->qid));

            $answer = array(

                'student_id' => $this->student_id,

                'staff_id' => $staff_id,

                'qid' => $q->qid,

                'answer' => $ans,

                'feedback_year' => 2023,

                'created_by' => $this->student_id,

                'created_date_time' => date('Y-m-d h:m:s')

            );

            $this->feedback_model->addQuestionAnswerCounsellorFeedback($answer);

        }

        



        $result = $this->feedback_model->addFeedbackToStaff($feedbackInfo);

        if($result > 0) { 

            $this->session->set_flashdata('success', 'Feedback Sent Successfully'); 

        }else { 

            $this->session->set_flashdata('error', 'Feedback failed'); 

        }

        redirect('viewSadhanaStaffForFeedback');

    }

}

