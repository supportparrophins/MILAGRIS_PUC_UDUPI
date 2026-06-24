<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class StaffFeedback_model extends CI_Model {

    public function getStudentFeedbackCount($filter) {
        $this->db->from('tbl_feedback_enabled_student_info as feedback');
        // $this->db->join('tbl_student_academic_info as academic', 'std.student_id = feedback.student_id','left');
        $this->db->join('tbl_students_info as std', 'std.application_no = std.application_no','left');
    
        if(!empty($filter['by_name'])) {
            $like = "(std.student_name  LIKE '%".$filter['student_name']."%')";
            $this->db->where($like);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('std.student_id', $filter['student_id']);
        }
        if(!empty($filter['by_term'])){
            $this->db->where('std.term_name', $filter['by_term']);
        }
        if(!empty($filter['by_stream'])){
            $this->db->where('std.stream_name', $filter['by_stream']);
        }
        if(!empty($filter['by_Section'])){
            $this->db->where('std.section_name', $filter['by_Section']);
        }

        $this->db->where('std.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $this->db->where('feedback.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    //get refund fee info
    public function getStudentFeedbackDetails($filter='') {
        $this->db->select('std.student_id,feedback.row_id,feedback.student_id,std.student_name,std.term_name,
        std.stream_name,std.section_name');
        $this->db->from('tbl_feedback_enabled_student_info as feedback');
        // $this->db->join('tbl_student_academic_info as academic', 'std.student_id = feedback.student_id','left');
        $this->db->join('tbl_students_info as std', 'std.application_no = std.application_no','left');
    
        if(!empty($filter['by_name'])) {
            $like = "(std.student_name  LIKE '%".$filter['student_name']."%')";
            $this->db->where($like);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('std.student_id', $filter['student_id']);
        }
        if(!empty($filter['by_term'])){
            $this->db->where('std.term_name', $filter['by_term']);
        }
        if(!empty($filter['by_stream'])){
            $this->db->where('std.stream_name', $filter['by_stream']);
        }
        if(!empty($filter['by_Section'])){
            $this->db->where('std.section_name', $filter['by_Section']);
        }
        
        $this->db->where('std.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $this->db->where('feedback.is_deleted', 0);
        $this->db->order_by('feedback.row_id', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    
    public function addStudentDetailsForFeedback($feedbackInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_feedback_enabled_student_info', $feedbackInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    
    function updateStudentEnabledInfo($feedbackInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_feedback_enabled_student_info', $feedbackInfo);
        return TRUE;
    }

    public function getStudentEnabledInfo($student_id, $feedback_type){
        $this->db->from('tbl_feedback_enabled_student_info');
        $this->db->where('student_id', $student_id);
        $this->db->where('feedback_type', $feedback_type);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }


    public function getStudentFeedbackCountNotAdded($filter) {
        $this->db->from('tbl_feedback_enabled_student_info as feedback');
        // $this->db->join('tbl_student_academic_info as academic', 'std.student_id = feedback.student_id','left');
        $this->db->join('tbl_students_info as std', 'std.application_no = std.application_no','left');
    
        if(!empty($filter['by_name'])) {
            $like = "(std.student_name  LIKE '%".$filter['student_name']."%')";
            $this->db->where($like);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('std.student_id', $filter['student_id']);
        }
        if(!empty($filter['by_term'])){
            $this->db->where('std.term_name', $filter['by_term']);
        }
        if(!empty($filter['by_stream'])){
            $this->db->where('std.stream_name', $filter['by_stream']);
        }
        if(!empty($filter['by_Section'])){
            $this->db->where('std.section_name', $filter['by_Section']);
        }
        $this->where_not_in('feedback.student_id');
        $this->db->where('std.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        // $this->db->where('feedback.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    //get refund fee info
    public function getStudentFeedbackNotAddedDetails($filter='') {
        $this->db->select('std.student_id,feedback.row_id,feedback.student_id,std.student_name,std.term_name,
        std.stream_name,std.section_name');
        $this->db->from('tbl_feedback_enabled_student_info as feedback');
        // $this->db->join('tbl_student_academic_info as academic', 'std.student_id = feedback.student_id','left');
        $this->db->join('tbl_students_info as std', 'std.application_no = std.application_no','left');
    
        if(!empty($filter['by_name'])) {
            $like = "(std.student_name  LIKE '%".$filter['student_name']."%')";
            $this->db->where($like);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('std.student_id', $filter['student_id']);
        }
        if(!empty($filter['by_term'])){
            $this->db->where('std.term_name', $filter['by_term']);
        }
        if(!empty($filter['by_stream'])){
            $this->db->where('std.stream_name', $filter['by_stream']);
        }
        if(!empty($filter['by_Section'])){
            $this->db->where('std.section_name', $filter['by_Section']);
        }
        $this->where_not_in('feedback.student_id');
        $this->db->where('std.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        // $this->db->where('feedback.is_deleted', 0);
        $this->db->order_by('feedback.row_id', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }


    //analytics
     public function getCountOfTotalFeedback($staff_id){
        $this->db->from('tbl_student_feedback_teaching_staff as q'); 
        $this->db->where('q.staff_id', $staff_id); 
        $this->db->where('q.feedback_year', '2023');
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function getFeedbackGivenInfo($StaffRow_id){
        $this->db->select('feed.student_id');
        $this->db->from('tbl_student_feedback_teaching_staff as feed');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = feed.staff_id','left');
        $this->db->where('feed.feedback_year', FEEDBACK_YEAR);
        $this->db->where('feed.is_deleted', 0);
        $this->db->where('staff.staff_id', $StaffRow_id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getStudentInfoCountBySectionId($term_name,$section_name,$stream_name){

        $this->db->from('tbl_students_info as student'); 
        // $this->db->join('tbl_student_academic_info as academic', 'std.application_no = student.application_no');
        $this->db->where('student.term_name', $term_name);
        if($section_name!='ALL'){
        $this->db->where('student.section_name', $section_name);
        }else{
            $this->db->where('student.section_name', "");
        }
        $this->db->where('student.stream_name', $stream_name);
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $this->db->where('student.is_deleted', 0);
        // $this->db->where('student.intake_year', '2022-23');
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function getFeedbackGivenCount($term_name,$section_name,$stream_name,$staff_id){
        $this->db->from('tbl_students_info as student'); 
        // $this->db->join('tbl_student_academic_info as academic', 'student.application_no = academic.application_no');
        $this->db->join('tbl_student_feedback_teaching_staff as feedback', 'feedback.student_id = student.student_id');
        $this->db->where('student.term_name', $term_name);
        if($section_name!='ALL'){
        $this->db->where('student.section_name', $section_name);
        }else{
            $this->db->where('student.section_name', "");   
        }
        $this->db->where('student.stream_name', $stream_name);
        $this->db->where('feedback.staff_id', $staff_id);

        $this->db->where('feedback.feedback_year', FEEDBACK_YEAR);
        $this->db->where('feedback.is_deleted', 0);
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

       public function getfeedbackPendingInfo($term_name,$section_name,$stream_name,$studentIds){

        $this->db->select('student.student_name,student.student_id,student.term_name,student.section_name,student.stream_name');
        $this->db->from('tbl_students_info as student'); 
        // $this->db->join('tbl_student_academic_info as academic', 'student.application_no = academic.application_no');
        $this->db->where('student.term_name', $term_name);
        if($section_name!='ALL'){
        $this->db->where('student.section_name', $section_name);
        }else{
            $this->db->where('student.section_name', "");   
        }
        $this->db->where('student.stream_name', $stream_name);
        $this->db->where_not_in('student.student_id', $studentIds);
        $this->db->order_by('student.term_name');
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        //  $this->db->where('student.intake_year', '2022-23');
        $query = $this->db->get();
        return $query->result();
    }

        public function getStudentInfoCountBySectionIdIntg($term_name,$section_name){

        $this->db->from('tbl_students_info as student'); 
        // $this->db->join('tbl_student_academic_info as academic', 'student.application_no = academic.application_no');
        $this->db->where('student.term_name', $term_name);
        $this->db->where('student.section_name', $section_name);
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $this->db->where('student.is_deleted', 0);
        $this->db->where('student.intake_year', '2022-23');
        $query = $this->db->get();
        return $query->num_rows();
    }

     public function getFeedbackGivenCountIntg($term_name,$section_name,$staff_id){
        $this->db->from('tbl_students_info as student'); 
        // $this->db->join('tbl_student_academic_info as academic', 'student.application_no = academic.application_no');
        $this->db->join('tbl_student_feedback_teaching_staff as feedback', 'feedback.student_id = student.student_id');
        $this->db->where('student.term_name', $term_name);
        $this->db->where('student.section_name', $section_name);
        $this->db->where('feedback.staff_id', $staff_id);
        $this->db->where('feedback.feedback_year', '2024');
        $this->db->where('feedback.is_deleted', 0);
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

       public function getfeedbackPendingInfoIntg($term_name,$section_name,$studentIds){

        $this->db->select('student.student_name,std.student_id,std.term_name,std.section_name,std.stream_name');
        $this->db->from('tbl_students_info as student'); 
        // $this->db->join('tbl_student_academic_info as academic', 'student.application_no = academic.application_no');
        $this->db->where('student.term_name', $term_name);
        $this->db->where('student.section_name', $section_name);
        $this->db->where_not_in('student.student_id', $studentIds);
        $this->db->order_by('student.term_name');
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $this->db->where('student.intake_year', '2022-23');
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

}
?>