<?php if(!defined('BASEPATH')) exit('No direct script access allowed');



class Feedback_model extends CI_Model

{

    public function getMyTeachingStaffInfo($term_name, $section_name){

        $this->db->select('staff.staff_id, staff.name, dept.name as dept_name, staff.staff_id');

        ;

        $this->db->from('tbl_staff_sections as staff_section');

        $this->db->join('tbl_section_info as section','section.row_id = staff_section.section_id');

        // $this->db->join('tbl_stream_info as stream','stream.row_id = section.stream_id');

        $this->db->join('tbl_staff as staff','staff.staff_id = staff_section.staff_id');

        $this->db->join('tbl_department as dept','staff.department_id = dept.dept_id');



        // $this->db->from('tbl_staff_sections as staff_section');

        // $this->db->join('tbl_staff as staff','staff.staff_id = staff_section.staff_id');

        // $this->db->join('tbl_department as dept','staff.department_id = dept.dept_id');

       // $this->db->join('tbl_student_feedback_teaching_staff as feedback','feedback.staff_id = staff.staff_id','left');

        // if($term_name == 'I PUC'){
            $this->db->where('section.term_name', $term_name);
            $this->db->where("section.section_name LIKE '%".$section_name."%'");

        // }else{

            // $this->db->where("staff_section.second_year_section LIKE '%".$section_name."%'");

        // }

        $no_staff_id = array('18','20','19');
        $this->db->where('section.is_deleted',0);
        $this->db->where('staff.is_deleted',0);
        $this->db->where('staff_section.is_deleted',0);
        $this->db->where('staff_section.is_deleted',0);
        $this->db->group_by('staff.staff_id');
        $this->db->where_not_in('dept.dept_id',$no_staff_id);

        $query = $this->db->get();

        return $query->result();

    }



    public function getStudentFeedbackQuestions(){

        $this->db->from('tbl_student_feedback_questions_latest as questions');

        $this->db->where('questions.is_deleted',0);

        $query = $this->db->get();

        return $query->result();

    }



    public function getStudentCounsellorFeedbackQuestions(){

        $this->db->from('tbl_counsollor_feedback_questions as questions');

        $this->db->where('questions.is_deleted',0);

        $query = $this->db->get();

        return $query->result();

    }



    public function getMyCounsellorStaffInfo(){

        $this->db->select(' staff.name, dept.name as dept_name, staff.staff_id');

        $this->db->from('tbl_staff as staff');

        //$this->db->join('tbl_staff as staff','staff.staff_id = staff_section.staff_id');

        $this->db->join('tbl_department as dept','staff.department_id = dept.dept_id');

       // $this->db->join('tbl_student_feedback_teaching_staff as feedback','feedback.staff_id = staff.staff_id','left');

       

       // $no_staff_id = array('18','20','19');

        $this->db->where('dept.dept_id','18');

        $query = $this->db->get();

        return $query->result();

    }



    public function checkStudentFeedbackIsEnabled($student_id,$type){

        $this->db->from('tbl_feedback_enabled_student_info as feed');

        $this->db->where('feed.student_id',$student_id);

       $this->db->where('feed.feedback_type',$type);

        $this->db->where('feed.is_deleted',0);

        $query = $this->db->get();

        return $query->row();

    }



       // feedback staff page  

       function addFeedbackToStaff($feedbackInfo)

       {

           $this->db->trans_start();

           $this->db->insert('tbl_student_feedback_teaching_staff', $feedbackInfo);

           $insert_id = $this->db->insert_id();

           $this->db->trans_complete();

           return $insert_id;

       }





       function addQuestionAnswerStaffFeedback($answers)

       {

           $this->db->trans_start();

           $this->db->insert('tbl_student_feedback_answers', $answers);

           $insert_id = $this->db->insert_id();

           $this->db->trans_complete();

           return $insert_id;

       }

        

       function getGivenFeedbackInfoByStudent($student_id){

            $this->db->from('tbl_student_feedback_teaching_staff as feed');

            $this->db->where('feed.feedback_year','2023');

            $this->db->where('feed.student_id',$student_id);

            $this->db->where('feed.is_deleted',0);

            $query = $this->db->get();

            return $query->result();

       }





       

       function addQuestionAnswerCounsellorFeedback($answers)

       {

           $this->db->trans_start();

           $this->db->insert('tbl_counsellor_feedback_answers', $answers);

           $insert_id = $this->db->insert_id();

           $this->db->trans_complete();

           return $insert_id;

       }

        

       

       

}