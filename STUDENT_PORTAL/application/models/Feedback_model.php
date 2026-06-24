<?php if(!defined('BASEPATH')) exit('No direct script access allowed');



class Feedback_model extends CI_Model

{

     public function getAllSchoolSubjectByStaffId($staff_id,$term_name,$section_name,$stream_name){
        $this->db->select('staff.row_id,sub.subject_code,sub.department_id,sub.sub_name,sub.sub_type,sub.lab_status,
        staff.subject_type,staff.staff_id');
        $this->db->from('tbl_subjects as sub');
        $this->db->join('tbl_staff_teaching_subjects as staff', 'staff.subject_code = sub.subject_code','left'); 
        $this->db->join('tbl_department as dept', 'sub.department_id = dept.dept_id','left');
        $this->db->join('tbl_staff_sections as staff_section', 'staff_section.staff_id = staff.staff_id','left'); 
        $this->db->join('tbl_section_info as section','section.row_id = staff_section.section_id');
        $this->db->join('tbl_stream_info as stream', 'stream.row_id = section.stream_id','left');
        $this->db->where("section.term_name", $term_name);
        $this->db->where("stream.stream_name", $stream_name);
        $this->db->where("section.section_name LIKE '%".$section_name."%'");
        // $this->db->where('term.term_name', $term_name);
        $this->db->where('staff.staff_id', $staff_id);
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('sub.is_deleted', 0);
        $this->db->where('dept.is_deleted', 0);
         $this->db->where('stream.is_deleted', 0);

         $this->db->where('staff.is_deleted', 0);
        $this->db->where('staff_section.is_deleted', 0);
         $this->db->where('section.is_deleted', 0);
        // $this->db->where('staff_section.is_deleted', 0);
        $this->db->group_by('staff.row_id');
        $query = $this->db->get();
        return $query->result();
    }
    public function getMyTeachingStaffInfo($term_name, $section_name, $stream_name){

        $this->db->select('staff.staff_id, staff.name, dept.name as dept_name, staff.staff_id,section.term_name,stream.stream_name,section.section_name');

        $this->db->from('tbl_staff_sections as staff_section');

        $this->db->join('tbl_section_info as section','section.row_id = staff_section.section_id');

        $this->db->join('tbl_stream_info as stream','stream.row_id = section.stream_id');

        $this->db->join('tbl_staff as staff','staff.staff_id = staff_section.staff_id');

        $this->db->join('tbl_department as dept','staff.department_id = dept.dept_id');

        // if($term_name == 'I PUC'){

        //     $this->db->where("section.term_name",'I PUC');

        //     $this->db->where("section.section_name LIKE '%".$section_name."%'");

        // }else{

            $this->db->where("section.term_name", $term_name);

            $this->db->where("stream.stream_name", $stream_name);

            if(!empty($section_name) && $section_name != 'ALL') {
                $this->db->where("section.section_name",$section_name);
            }else{
                $this->db->where("section.section_name", 'ALL');
            }

        // }

        $no_staff_id = array('SJI0059','SJI0029');

        $this->db->where_not_in('staff.staff_id',$no_staff_id);

            $this->db->where("staff_section.is_deleted", 0);
            $this->db->where("staff.resignation_status", 0);
            $this->db->where("staff.is_deleted", 0);
            $this->db->where("section.is_deleted", 0);
            $this->db->group_by("staff.staff_id");


        $query = $this->db->get();

        return $query->result();

    }



    public function getStudentFeedbackQuestions(){

        $this->db->from('tbl_student_feedback_questions_latest as questions');

        $this->db->where('questions.is_deleted',0);

        $this->db->where('questions.year',FEEDBACK_YEAR);

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

        $this->db->join('tbl_department as dept','staff.department_id = dept.dept_id');

       

        $this->db->where('dept.dept_id','18');

        $query = $this->db->get();

        return $query->result();

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

            $this->db->where('feed.feedback_year',FEEDBACK_YEAR);

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