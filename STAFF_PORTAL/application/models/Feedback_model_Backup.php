<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Feedback_model extends CI_Model
{

    function addNewStudentForFeedback($student_info)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_feedback_enabled_student_info', $student_info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }


    //get students fetails lates update
    public function getEnabledFeedbackStudentsCount( $filter = '')
    {
        $this->db->from('tbl_feedback_enabled_student_info as first');
        if (!empty($filter['student_id'])) {
            $this->db->where('first.student_id', $filter['student_id']);
        }

        if (!empty($filter['student_name'])) {
            $likeCriteria = "(first.student_name  LIKE '%" . $filter['student_name'] . "%')";
            $this->db->where($likeCriteria);
        }

        if (!empty($filter['by_preference'])) {
            $this->db->where('first.stream_name', $filter['by_preference']);
        }

        if (!empty($filter['feedback_type'])) {
            $this->db->where('first.feedback_type', $filter['feedback_type']);
        }

        if (!empty($filter['section_name'])) {
            $this->db->where('first.section_name', $filter['section_name']);
        }

        if (!empty($filter['term_name'])) {
            $this->db->where('first.term_name', $filter['term_name']);
        }

        $this->db->where('first.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }



    public function getEnabledFeedbackStudentsDetails( $page, $segment, $filter)
    {
        $this->db->from('tbl_feedback_enabled_student_info as first');
        if (!empty($filter['student_id'])) {
            $this->db->where('first.student_id', $filter['student_id']);
        }

        if (!empty($filter['term_name'])) {
            $this->db->where('first.term_name', $filter['term_name']);
        }

        if (!empty($filter['student_name'])) {
            $likeCriteria = "(first.student_name  LIKE '%" . $filter['student_name'] . "%')";
            $this->db->where($likeCriteria);
        }

        if (!empty($filter['by_preference'])) {
            $this->db->where('first.stream_name', $filter['by_preference']);
        }

        if (!empty($filter['feedback_type'])) {
            $this->db->where('first.feedback_type', $filter['feedback_type']);
        }

        if (!empty($filter['section_name'])) {
            $this->db->where('first.section_name', $filter['section_name']);
        }


        $this->db->where('first.is_deleted', 0);
        $this->db->order_by('first.student_id', 'ASC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }



    public function updateFeedbackStudentsInfo($row_id, $stdInfo)
    {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_feedback_enabled_student_info', $stdInfo);
        return TRUE;
    }


    public function getStudentCommentsAndSug($staff_id)
    {
        $this->db->distinct();
        $this->db->from('tbl_student_feedback_teaching_staff as feed');
        //$this->db->join('tbl_second_puc_students_info as std', 'std.student_id = supply.student_id','left');
        $this->db->where('feed.feedback_year', '2023');
        $this->db->where('feed.is_deleted', 0);
        $this->db->where('feed.staff_id', $staff_id);
        $this->db->order_by('feed.student_id', 'ASC');
        $this->db->group_by('feed.student_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    // comments year 2021
    public function getStudentCommentsAndSug21($staff_id)
    {
        $this->db->distinct();
        $this->db->from('tbl_student_feedback_teaching_staff as feed');
        //$this->db->join('tbl_second_puc_students_info as std', 'std.student_id = supply.student_id','left');
        $this->db->where('feed.feedback_year', '2021');
        $this->db->where('feed.is_deleted', 0);
        $this->db->where('feed.staff_id', $staff_id);
        $this->db->order_by('feed.student_id', 'ASC');
        $this->db->group_by('feed.student_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }


    public function getTeachingStaffFeedbackQuestions()
    {
        $this->db->from('tbl_student_feedback_questions_latest as q');
        //$this->db->join('tbl_second_puc_students_info as std', 'std.student_id = supply.student_id','left');
        $this->db->where('q.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getCounsellorFeedbackQuestionsAndAnswer($staff_id)
    {
        $this->db->from('tbl_counsellor_feedback_answers as a');
        $this->db->join('tbl_counsollor_feedback_questions as q', 'a.qid = q.qid', 'left');
        $this->db->where('a.feedback_year', 2023);
        $this->db->where('a.staff_id', $staff_id);
        $this->db->where('q.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }


    public function getCountOfAnswersYES_NO($staff_id, $qid, $type)
    {
        $this->db->from('tbl_student_feedback_answers as q');
        $this->db->where('q.answer', $type);
        $this->db->where('q.qid', $qid);
        $this->db->where('q.staff_id', $staff_id);
        $this->db->where('q.feedback_year', '2019');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getCountOfStdAnswersYES_NO_21($staff_id, $qid, $type)
    {
        $this->db->from('tbl_student_feedback_answers as q');
        $this->db->where('q.answer', $type);
        $this->db->where('q.qid', $qid);
        $this->db->where('q.staff_id', $staff_id);
        $this->db->where('q.feedback_year', '2021');
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function getStaffManagementFeedback($staff_id)
    {
        $this->db->from('tbl_staff_feedback_response_management as r');
        $this->db->where('r.staff_row_id', $staff_id);
        $this->db->where('r.year', '2019');
        $query = $this->db->get();
        return $query->row();
    }

    public function getCouncellorManagementFeedback($staff_id)
    {
        $this->db->from('tbl_staff_feedback_response_management as r');
        $this->db->where('r.staff_row_id', $staff_id);
        $this->db->where('r.year', '2023');
        $query = $this->db->get();
        return $query->row();
    }


    public function getStaffManagementFeedback_21($staff_id)
    {
        $this->db->from('tbl_staff_feedback_response_management as r');
        $this->db->where('r.staff_row_id', $staff_id);
        $this->db->where('r.year', '2021');
        $query = $this->db->get();
        return $query->row();
    }


    public function getAllStaffManagementFeedback($staff_id, $year)
    {
        $this->db->from('tbl_staff_feedback_response_management as r');
        $this->db->where('r.staff_row_id', $staff_id);
        $this->db->where('r.year', $year);
        $query = $this->db->get();
        return $query->row();
    }


    public function addCommentToStaffFeedback($comment)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_staff_feedback_response_management', $comment);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }



    public function updateCommentToStaffFeedback($staff_id, $year, $comment)
    {
        $this->db->where('staff_row_id', $staff_id);
        $this->db->where('year', $year);
        $this->db->update('tbl_staff_feedback_response_management', $comment);
        return TRUE;
    }

    public function getAllStudent(){
        $this->db->select('student.row_id, student.student_name, student.application_no,
        student.term_name,student.section_name,student.elective_sub,student.student_id');
        $this->db->from('tbl_students_info as student'); 
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getStudentEnabledInfo($student_id, $feedback_type, $term_name, $section_name, $stream_name){
        $this->db->from('tbl_feedback_enabled_student_info');
        $this->db->where('student_id', $student_id);
        $this->db->where('term_name', $term_name);
        $this->db->where('section_name', $section_name);
        $this->db->where('stream_name', $stream_name);
        $this->db->where('feedback_type', $feedback_type);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function addStudentDetailsForFeedback($feedbackInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_feedback_enabled_student_info', $feedbackInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getStudentInfo($student_id){
        $this->db->from('tbl_students_info');
        $this->db->where('student_id', $student_id);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    
    function updateStudentEnabledInfo($feedbackInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_feedback_enabled_student_info', $feedbackInfo);
        return TRUE;
    }

    public function getStudentFeedbackCount($StaffRow_id){
        $this->db->from('tbl_student_feedback_teaching_staff as feed');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = feed.staff_id','left');
        $this->db->where('feed.feedback_year', '2023');
        $this->db->where('feed.is_deleted', 0);
        $this->db->where('staff.row_id', $StaffRow_id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getCounselorFeedbackCount($StaffRow_id){
        $this->db->from('tbl_counsellor_feedback_answers as ans');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = ans.staff_id','left');
        $this->db->where('ans.is_deleted', 0);
        $this->db->where('staff.row_id', $StaffRow_id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getCountOfStdAnswersYES_NO_22($staff_id, $qid, $type)
    {
        $this->db->from('tbl_student_feedback_answers as q');
        $this->db->where('q.answer', $type);
        $this->db->where('q.qid', $qid);
        $this->db->where('q.staff_id', $staff_id);
        $this->db->where('q.feedback_year', '2022');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getCountOfStdAnswersYES_NO_23($staff_id, $qid, $type)
    {
        $this->db->from('tbl_student_feedback_answers as q');
        $this->db->where('q.answer', $type);
        $this->db->where('q.qid', $qid);
        $this->db->where('q.staff_id', $staff_id);
        $this->db->where('q.feedback_year', '2023');
        $query = $this->db->get();
        return $query->num_rows();
    }

    // comments year 2022
    public function getStudentCommentsAndSug22($staff_id)
    {
        $this->db->distinct();
        $this->db->from('tbl_student_feedback_teaching_staff as feed');
        //$this->db->join('tbl_second_puc_students_info as std', 'std.student_id = supply.student_id','left');
        $this->db->where('feed.feedback_year', '2022');
        $this->db->where('feed.is_deleted', 0);
        $this->db->where('feed.staff_id', $staff_id);
        $this->db->order_by('feed.student_id', 'ASC');
        $this->db->group_by('feed.student_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

     // comments year 2023
     public function getStudentCommentsAndSug23($staff_id)
     {
         $this->db->distinct();
         $this->db->from('tbl_student_feedback_teaching_staff as feed');
         //$this->db->join('tbl_second_puc_students_info as std', 'std.student_id = supply.student_id','left');
         $this->db->where('feed.feedback_year', '2023');
         $this->db->where('feed.is_deleted', 0);
         $this->db->where('feed.staff_id', $staff_id);
         $this->db->order_by('feed.student_id', 'ASC');
         $this->db->group_by('feed.student_id');
         $query = $this->db->get();
         $result = $query->result();
         return $result;
     }
 


    public function getStaffManagementFeedback_22($staff_id)
    {
        $this->db->from('tbl_staff_feedback_response_management as r');
        $this->db->where('r.staff_row_id', $staff_id);
        $this->db->where('r.year', '2023');
        $query = $this->db->get();
        return $query->row();
    }


    
    public function getStaffManagementFeedback_23($staff_id)
    {
        $this->db->from('tbl_staff_feedback_response_management as r');
        $this->db->where('r.staff_row_id', $staff_id);
        $this->db->where('r.year', '2023');
        $query = $this->db->get();
        return $query->row();
    }

    public function getStudentFeedbackCount_22($StaffRow_id){
        $this->db->from('tbl_student_feedback_teaching_staff as feed');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = feed.staff_id','left');
        $this->db->where('feed.feedback_year', '2023');
        $this->db->where('feed.is_deleted', 0);
        $this->db->where('staff.row_id', $StaffRow_id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

}
