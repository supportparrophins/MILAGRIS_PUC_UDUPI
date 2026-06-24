<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



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

    

    public function viewStaffForFeedback()

    {

        // $teachingFeedbackEnabled = $this->feedback_model->checkStudentFeedbackIsEnabled($this->student_id);

        // if (!empty($teachingFeedbackEnabled)) {

            // if ($teachingFeedbackEnabled->feedback_type == 'TEACHING') {

            $student = $this->student_model->getStudentInfoById($this->student_id,$this->term_name);
                $section_name= $this->section_name ? $this->section_name : "ALL";
                $data['feedbackStaffInfo'] = $this->feedback_model->getMyTeachingStaffInfo($this->term_name, $section_name,$student->stream_name);
                $data['feedback'] = $this->feedback_model;
                $data['feedbacQuestions'] = $this->feedback_model->getStudentFeedbackQuestions();

                $data['isExist'] = $this->feedback_model->getGivenFeedbackInfoByStudent($this->student_id);

                $this->global['pageTitle'] = 'Staff Feedback';

                $this->loadViews("feedback/student_feedback_teaching_staff", $this->global, $data, NULL);

            // } else  if ($teachingFeedbackEnabled->feedback_type == 'COUNSELLOR') {

            //     $data['feedbackStaffInfo'] = $this->feedback_model->getMyCounsellorStaffInfo();

            //     $data['feedbacQuestions'] = $this->feedback_model->getStudentCounsellorFeedbackQuestions();

            //     $this->global['pageTitle'] = 'Sadhana Staff Feedback';

            //     $this->loadViews("feedback/student_feedback_sadhana", $this->global, $data, NULL);

            // } else {

            //     $this->loadThis();

            // }

        // } else {

        //     $this->loadThis();

        // }

    }



    public function saveMyFeedback()

    {

        $staff_id = $this->security->xss_clean($this->input->post('staff_id'));



        $impression = $this->security->xss_clean($this->input->post('impression'));

        $suggestions = $this->security->xss_clean($this->input->post('suggestions'));

        $opinion = $this->security->xss_clean($this->input->post('opinion'));

        $like_about = $this->security->xss_clean($this->input->post('like_about'));

        $happy = $this->security->xss_clean($this->input->post('happy'));

        $college_improvement = $this->security->xss_clean($this->input->post('college_improvement'));



        $feedbackInfo = array(

            'student_id' => $this->student_id,

            'staff_id' => $staff_id,

            'feedback_year' => FEEDBACK_YEAR,

            'comments_impression' => $impression,

            'suggestion' => $suggestions,

            'opinion' => $opinion,

            'like_about' => $like_about,

            'happy' => $happy,

            'college_improvement' => $college_improvement,

            'created_by' => $this->student_id,

            'created_date_time' => date('Y-m-d h:m:s')

        );



        $feedbacQuestions = $this->feedback_model->getStudentFeedbackQuestions();

        foreach ($feedbacQuestions as $q) {

            $ans = $this->security->xss_clean($this->input->post('answer_'.$q->qid));
           

            $answer = array(

                'student_id' => $this->student_id,

                'staff_id' => $staff_id,

                'qid' => $q->qid,

                'answer' => $ans,

                'feedback_year' => FEEDBACK_YEAR,

                'created_by' => $this->student_id,

                'created_date_time' => date('Y-m-d h:m:s')

            );

            $this->feedback_model->addQuestionAnswerStaffFeedback($answer);

        }




        $result = $this->feedback_model->addFeedbackToStaff($feedbackInfo);

        if ($result > 0) {

            $this->session->set_flashdata('success', 'Feedback Sent Successfully');

        } else {

            $this->session->set_flashdata('error', 'Feedback failed');

        }

        redirect('viewStaffForFeedback');

    }





    public function saveMyCounsellorFeedback()

    {

        $staff_id = $this->security->xss_clean($this->input->post('staff_id'));

        $feedbackInfo = array(

            'student_id' => $this->student_id,

            'staff_id' => $staff_id,

            'feedback_year' => 2024,

            'comments_impression' => '',

            'suggestion' => '',

            'created_by' => $this->student_id,

            'created_date_time' => date('Y-m-d h:m:s')

        );

        $feedbacQuestions = $this->feedback_model->getStudentCounsellorFeedbackQuestions();

        foreach ($feedbacQuestions as $q) {

            $ans = $this->security->xss_clean($this->input->post('answer_'.$q->qid));

            $answer = array(

                'student_id' => $this->student_id,

                'staff_id' => $staff_id,

                'qid' => $q->qid,

                'answer' => $ans,

                'feedback_year' => 2024,

                'created_by' => $this->student_id,

                'created_date_time' => date('Y-m-d h:m:s')

            );

            $this->feedback_model->addQuestionAnswerCounsellorFeedback($answer);

        }





        $result = $this->feedback_model->addFeedbackToStaff($feedbackInfo);

        if ($result > 0) {

            $this->session->set_flashdata('success', 'Feedback Sent Successfully');

        } else {

            $this->session->set_flashdata('error', 'Feedback failed');

        }

        redirect('viewStaffForFeedback');

    }

}

