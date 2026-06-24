<?php if(!defined('BASEPATH')) exit('No direct script access allowed');



class Feedback_model extends CI_Model {

    function addNewStudentForFeedback($student_info){
        $this->db->trans_start();
        $this->db->insert('tbl_feedback_enabled_student_info', $student_info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }


    //get students fetails lates update
    public function getEnabledFeedbackStudentsCount($searchText = '',$filter=''){
        $this->db->from('tbl_feedback_enabled_student_info as first');
        if(!empty($filter['student_id'])){
            $this->db->where('first.student_id', $filter['student_id']);
        }

        if(!empty($filter['student_name'])){
            $likeCriteria = "(first.student_name  LIKE '%".$filter['student_name']."%')";
            $this->db->where($likeCriteria);
        }

        if(!empty($filter['by_preference'])){
            $this->db->where('first.stream_name', $filter['by_preference']);
        }

        if(!empty($filter['feedback_type'])){
            $this->db->where('first.feedback_type', $filter['feedback_type']);
        }

        if(!empty($filter['section_name'])){
            $this->db->where('first.section_name', $filter['section_name']);
        }

        if(!empty($filter['term_name'])){
            $this->db->where('first.term_name', $filter['term_name']);
        }

        if(!empty($searchText)){
            $this->db->where('first.student_id', $searchText);
        }

    
        $this->db->where('first.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

  

    public function getEnabledFeedbackStudentsDetails($searchText = '', $page, $segment,$filter){
        $this->db->from('tbl_feedback_enabled_student_info as first');
        if(!empty($filter['student_id'])){
            $this->db->where('first.student_id', $filter['student_id']);
        }

        if(!empty($filter['term_name'])){
            $this->db->where('first.term_name', $filter['term_name']);
        }

        if(!empty($filter['student_name'])){
            $likeCriteria = "(first.student_name  LIKE '%".$filter['student_name']."%')";
            $this->db->where($likeCriteria);
        }

        if(!empty($filter['by_preference'])){
            $this->db->where('first.stream_name', $filter['by_preference']);
        }

        if(!empty($filter['feedback_type'])){
            $this->db->where('first.feedback_type', $filter['feedback_type']);
        }

        if(!empty($filter['section_name'])){
            $this->db->where('first.section_name', $filter['section_name']);
        }

        if(!empty($searchText)){
            $this->db->where('first.student_id', $searchText);
        }

        $this->db->where('first.is_deleted', 0);
        $this->db->order_by('first.student_id', 'ASC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    } 

    

    public function updateFeedbackStudentsInfo($row_id,$stdInfo){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_feedback_enabled_student_info', $stdInfo);
        return TRUE;
    }


    public function getStudentCommentsAndSug($staff_id){
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

    // comments year 2021
    public function getStudentCommentsAndSug22($staff_id){
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

       public function getStudentCommentsAndSug23($staff_id){
        $this->db->distinct();
        $this->db->from('tbl_student_feedback_teaching_staff as feed');
        //$this->db->join('tbl_second_puc_students_info as std', 'std.student_id = supply.student_id','left');
        $this->db->where('feed.feedback_year', '2025');
        $this->db->where('feed.is_deleted', 0);
        $this->db->where('feed.staff_id', $staff_id);
        $this->db->order_by('feed.student_id', 'ASC');
        $this->db->group_by('feed.student_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getStudentCommentsAndSug25($staff_id){
                $this->db->distinct();
        $this->db->from('tbl_student_feedback_teaching_staff as feed');
        //$this->db->join('tbl_second_puc_students_info as std', 'std.student_id = supply.student_id','left');
        $this->db->where('feed.feedback_year', '2025');
        $this->db->where('feed.is_deleted', 0);
        $this->db->where('feed.staff_id', $staff_id);
        $this->db->order_by('feed.student_id', 'ASC');
        $this->db->group_by('feed.student_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }


    public function getStudentCommentsAndSug24($staff_id){
        $this->db->distinct();
        $this->db->from('tbl_student_feedback_teaching_staff as feed');
        //$this->db->join('tbl_second_puc_students_info as std', 'std.student_id = supply.student_id','left');
        $this->db->where('feed.feedback_year', '2024');
        $this->db->where('feed.is_deleted', 0);
        $this->db->where('feed.staff_id', $staff_id);
        $this->db->order_by('feed.student_id', 'ASC');
        $this->db->group_by('feed.student_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }




    public function getTeachingStaffFeedbackQuestions(){
        $this->db->from('tbl_student_feedback_questions_latest as q');
        //$this->db->join('tbl_second_puc_students_info as std', 'std.student_id = supply.student_id','left');
        $this->db->where('q.is_deleted', 0);
        $this->db->where('q.year', '2023');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getTeachingStaffFeedbackQuestions23(){
        $this->db->from('tbl_student_feedback_questions_latest as q');
        //$this->db->join('tbl_second_puc_students_info as std', 'std.student_id = supply.student_id','left');
        $this->db->where('q.is_deleted', 0);
        $this->db->where('q.year', '2025');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getTeachingStaffFeedbackQuestions25(){
        $this->db->from('tbl_student_feedback_questions_latest as q');
        //$this->db->join('tbl_second_puc_students_info as std', 'std.student_id = supply.student_id','left');
        $this->db->where('q.is_deleted', 0);
        $this->db->where('q.year', '2025');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getCounsellorFeedbackQuestionsAndAnswer($staff_id){
        $this->db->from('tbl_counsellor_feedback_answers as a');
        $this->db->join('tbl_counsollor_feedback_questions as q', 'a.qid = q.qid','left');
        $this->db->where('a.staff_id', $staff_id);
        $this->db->where('q.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }


    public function getCountOfAnswersYES_NO($staff_id, $qid, $type){
        $this->db->from('tbl_student_feedback_answers as q');
        $this->db->where('q.answer', $type); 
        $this->db->where('q.qid', $qid); 
        $this->db->where('q.staff_id', $staff_id); 
        $this->db->where('q.feedback_year', '2022');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getCountOfStdAnswersYES_NO_22($staff_id, $qid, $type){
        $this->db->from('tbl_student_feedback_answers as q');
        $this->db->where('q.answer', $type); 
        $this->db->where('q.qid', $qid); 
        $this->db->where('q.staff_id', $staff_id); 
        $this->db->where('q.feedback_year', '2022');
        $query = $this->db->get();
        return $query->num_rows();
    }

     public function getCountOfAnswersYES_NO23($staff_id, $qid, $type){
        $this->db->from('tbl_student_feedback_answers as q');
        $this->db->where('q.answer', $type); 
        $this->db->where('q.qid', $qid); 
        $this->db->where('q.staff_id', $staff_id); 
        $this->db->where('q.feedback_year', '2023');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getCountOfAnswersYES_NO25($staff_id, $qid, $type){
        $this->db->from('tbl_student_feedback_answers as q');
        $this->db->where('q.answer', $type); 
        $this->db->where('q.qid', $qid); 
        $this->db->where('q.staff_id', $staff_id); 
        $this->db->where('q.feedback_year', '2025');
        $query = $this->db->get();
        return $query->num_rows();
    }
    

    public function getCountOfStdAnswersExcellent_Good_22($staff_id, $qid, $type){
        $this->db->from('tbl_student_feedback_answers as q');
        $this->db->where('q.answer', $type); 
        $this->db->where('q.qid', $qid); 
        $this->db->where('q.staff_id', $staff_id); 
        $this->db->where('q.feedback_year', '2023');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getCountOfStdAnswersExcellent_Good_23($staff_id, $qid, $type){
        $this->db->from('tbl_student_feedback_answers as q');
        $this->db->where('q.answer', $type); 
        $this->db->where('q.qid', $qid); 
        $this->db->where('q.staff_id', $staff_id); 
        $this->db->where('q.feedback_year', '2024');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getCountOfStdAnswersExcellent_Good_25($staff_id, $qid, $type){
        $this->db->from('tbl_student_feedback_answers as q');
        $this->db->where('q.answer', $type); 
        $this->db->where('q.qid', $qid); 
        $this->db->where('q.staff_id', $staff_id); 
        $this->db->where('q.feedback_year', '2025');
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function getStaffManagementFeedback($staff_id){
        $this->db->from('tbl_staff_feedback_response_management as r');
        $this->db->where('r.staff_row_id', $staff_id); 
        $this->db->where('r.year', '2022'); 
        $query = $this->db->get();
        return $query->row();
    }


    public function getStaffManagementFeedback_22($staff_id){
        $this->db->from('tbl_staff_feedback_response_management as r');
        $this->db->where('r.staff_row_id', $staff_id); 
        $this->db->where('r.year', '2023'); 
        $query = $this->db->get();
        return $query->row();
    }

    public function getStaffManagementFeedback_23($staff_id){
        $this->db->from('tbl_staff_feedback_response_management as r');
        $this->db->where('r.staff_row_id', $staff_id); 
        $this->db->where('r.year', '2024'); 
        $query = $this->db->get();
        return $query->row();
    }

    
    public function getStaffManagementFeedback_25($staff_id){
        $this->db->from('tbl_staff_feedback_response_management as r');
        $this->db->where('r.staff_row_id', $staff_id); 
        $this->db->where('r.year', '2025'); 
        $query = $this->db->get();
        return $query->row();
    }

    public function getAllStaffManagementFeedback($staff_id,$year){
        $this->db->from('tbl_staff_feedback_response_management as r');
        $this->db->where('r.staff_row_id', $staff_id); 
        $this->db->where('r.year', $year); 
        $query = $this->db->get();
        return $query->row();
    }


    public function addCommentToStaffFeedback($comment){
        $this->db->trans_start();
        $this->db->insert('tbl_staff_feedback_response_management', $comment);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }



    public function updateCommentToStaffFeedback($staff_id,$year,$comment){
        $this->db->where('staff_row_id', $staff_id);
        $this->db->where('year', $year);
        $this->db->update('tbl_staff_feedback_response_management', $comment);
        return TRUE;
    }

    public function getStudentFeedbackCount($StaffRow_id){
        $this->db->from('tbl_student_feedback_teaching_staff as feed');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = feed.staff_id','left');
        $this->db->where('feed.feedback_year', '2025');
        $this->db->where('feed.is_deleted', 0);
        $this->db->where('staff.row_id', $StaffRow_id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }


    public function getCountOfStaffAnswersExcellent_Good($staff_id, $qid, $type,$feedbacker_id){
        $this->db->from('tbl_staff_feedback_answers as q');
        $this->db->where('q.answer', $type); 
        $this->db->where('q.qid', $qid); 
        $this->db->where('q.staff_id', $staff_id); 
        $this->db->where('q.feedbacker_id', $feedbacker_id); 
        $this->db->where('q.feedback_year', '2023');
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function getCommentsOfStaffAns($staff_id, $qid,$feedbacker_id){
        $this->db->from('tbl_staff_feedback_answers as q');
        $this->db->where('q.qid', $qid); 
        $this->db->where('q.staff_id', $staff_id); 
        $this->db->where('q.feedbacker_id', $feedbacker_id); 
        $this->db->where('q.feedback_year', '2023');
        $query = $this->db->get();
        return $query->row()->comments;
    }


    public function getStaffComments($staff_id,$feedbacker_id){
        $this->db->distinct();
        $this->db->from('tbl_staff_feedback_teaching_staff as feed');
        //$this->db->join('tbl_second_puc_students_info as std', 'std.student_id = supply.student_id','left');
        $this->db->where('feed.feedback_year', '2023');
        $this->db->where('feed.is_deleted', 0);
        $this->db->where('feed.staff_id', $staff_id);
        $this->db->where('feed.feedbacker_id', $feedbacker_id);
        $this->db->order_by('feed.feedbacker_id', 'ASC');
        $this->db->group_by('feed.feedbacker_id');
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }


    public function getStaffCommentsTwo($staff_id,$feedbacker_id){
        $this->db->distinct();
        $this->db->from('tbl_staff_feedback_teaching_staff as feed');
        //$this->db->join('tbl_second_puc_students_info as std', 'std.student_id = supply.student_id','left');
        $this->db->where('feed.feedback_year', '2023');
        $this->db->where('feed.is_deleted', 0);
        $this->db->where('feed.staff_id', $staff_id);
        $this->db->where('feed.feedbacker_id', $feedbacker_id);
        $this->db->order_by('feed.feedbacker_id', 'ASC');
        $this->db->group_by('feed.feedbacker_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getAllSchoolStaffInfo($filter='')
    {
        $this->db->select('staff.user_name, shift.name as shift_name, shift.shift_code, shift.start_time, shift.end_time, 
        staff.type, staff.row_id, staff.staff_id, staff.email,staff.staff_type_id, staff.name,dept.name as department, 
        staff.mobile_one, Role.role, staff.address,staff.dob');
        $this->db->from('tbl_staff as staff'); 
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
       
       if(!empty($filter['staff_id'])){
            $this->db->where('staff.staff_id', $filter['staff_id']); 
        }
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('Role.roleId !=', '50');
        $this->db->where('Role.roleId !=', '51');
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('staff.resignation_status', 0);
        //  $this->db->where('staff.staff_type_id', 1);
        $query = $this->db->get();
        return $query->result();
    }

    public function getSectionByStaffIdFeedback($staff_id,$filter){
        $this->db->from('tbl_staff_sections as staff_section');
        $this->db->join('tbl_section_info as section','section.row_id = staff_section.section_id');
        $this->db->join('tbl_stream_info as stream','stream.row_id = section.stream_id');
        $this->db->join('tbl_staff as staff','staff.staff_id = staff_section.staff_id');
        $this->db->where('staff.staff_id', $staff_id);
        $this->db->where('staff.staff_id', $staff_id);
        if(!empty($filter['class_name'])){
            $this->db->where('section.term_name', $filter['class_name']); 
        }
        if(!empty($filter['stream_name'])){
            $this->db->where('stream.stream_name', $filter['stream_name']); 
        }
        if(!empty($filter['section_name'])){
            $this->db->where('section.section_name', $filter['section_name']); 
        }else{
             $this->db->where('section.section_name',"ALL");
        }
        $this->db->where('section.is_deleted', 0);
        $this->db->where('staff.resignation_status', 0);
        $this->db->where('stream.is_deleted', 0);
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('staff_section.is_deleted', 0);
        // $this->db->group_by("staff.staff_id");
        $query = $this->db->get();
        return $query->result();
    }

    public function getStudentCommentsAndSug22Report($staff_id,$filter){
         $this->db->select('student.student_name,student.sat_number,student.row_id,feed.comments_impression,feed.student_id');

        $this->db->from('tbl_student_feedback_teaching_staff as feed');
        $this->db->join('tbl_students_info as student', 'student.student_id = feed.student_id');
        $this->db->join('tbl_student_class_year_wise as yearwise',  'yearwise.stud_row_id = student.row_id');
       if(!empty($filter['class_name'])){
            $this->db->where('yearwise.class', $filter['class_name']); 
        }

            if(!empty($filter['section_name'])){
               $this->db->where('yearwise.section', $filter['section_name']); 
            }else{
                 $this->db->where("(yearwise.section IS NULL OR yearwise.section = '')", NULL, FALSE);
            }
            if(!empty($filter['stream_name'])){
               $this->db->where('yearwise.stream', $filter['stream_name']); 
            }else{
                 $this->db->where("(yearwise.stream IS NULL OR yearwise.stream = '')", NULL, FALSE);
            }
        $this->db->where('feed.feedback_year',FEEDBACK_YEAR);
        $this->db->where('feed.is_deleted', 0);
        $this->db->where('feed.staff_id', $staff_id);
        $this->db->order_by('feed.student_id', 'ASC');
        $this->db->where('yearwise.is_deleted', 0);
        $this->db->where('yearwise.intake_year', FEEDBACK_YEAR);
        // $this->db->group_by('feed.student_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getAllSchoolSubjectByStaffIdNew($staff_id, $term_name = null, $section_name = null, $stream_name = null) {
       $this->db->select('staff.staff_id, staff.name, dept.name as dept_name, staff.staff_id,section.term_name,stream.stream_name,section.section_name');

        $this->db->from('tbl_staff_sections as staff_section');

        $this->db->join('tbl_section_info as section','section.row_id = staff_section.section_id');

        $this->db->join('tbl_stream_info as stream','stream.row_id = section.stream_id');

        $this->db->join('tbl_staff as staff','staff.staff_id = staff_section.staff_id');

        $this->db->join('tbl_department as dept','staff.department_id = dept.dept_id');
        $this->db->where("section.term_name", $term_name);
        $this->db->where("stream.stream_name", $stream_name);
         if(!empty($section_name ) && $section_name != 'ALL'){
            $this->db->where('section.section_name', $section_name); 
        }else{
            $this->db->group_start();
            $this->db->where('section.section_name', 'ALL');
            $this->db->or_where('section.section_name', '');
            $this->db->group_end();
        }
        // $this->db->where('term.term_name', $term_name);
        $no_staff_id = array('SJI0059','SJI0029');

        $this->db->where_not_in('staff.staff_id',$no_staff_id);
        $this->db->where('staff.staff_id', $staff_id);
        $this->db->where('staff_section.is_deleted', 0);
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('section.is_deleted', 0);
        // $this->db->where('staff_section.year', FEEDBACK_YEAR);
        // $this->db->where('staff_section.is_deleted', 0);
        $this->db->group_by('staff.row_id');
        $query = $this->db->get();
        return $query->result();
    }
    

    public function getStudentInfoByTerm($term_name,$section_name,$stream_name){

        $this->db->select('student.student_name,student.application_no,student.term_name,student.section_name,student.row_id,student.student_id');
        $this->db->from('tbl_students_info as student'); 
        $this->db->where('student.term_name', $term_name);
        if($section_name!='ALL' && !empty($section_name)){
            $this->db->like('student.section_name', $section_name);
        }else{
            $this->db->where('student.section_name', '');
        }
        $this->db->where('student.stream_name', $stream_name);
        // $this->db->where_not_in('student.row_id', $studentIds);
        $this->db->order_by('student.term_name');
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
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

    public function getIsStudentAddedFeedback($staff_id,$row_id){
        $this->db->from('tbl_student_feedback_teaching_staff as feed');
        $this->db->where('feed.feedback_year', FEEDBACK_YEAR);
        $this->db->where('feed.is_deleted', 0);
        $this->db->where('feed.staff_id', $staff_id);
        $this->db->where('feed.student_id', $row_id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function getfeedbackPendingInfo($term_name, $section_name, $stream_name, $studentIds) {
        $this->db->select('student.student_name, student.student_id, student.term_name, student.section_name, student.stream_name');
        $this->db->from('tbl_students_info as student');
        $this->db->where('student.term_name', $term_name);
        if($section_name != 'ALL') {
            $this->db->where('student.section_name', $section_name);
        }
        $this->db->where('student.stream_name', $stream_name);
        if (!empty($studentIds)) {
            $this->db->where_not_in('student.student_id', $studentIds);
        } else {
            // If studentIds is empty, ensure no records match by adding a dummy condition
            $this->db->where('student.student_id !=', ''); // Matches all records
        }
        $this->db->order_by('student.term_name');
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
     public function getCountOfStdAnswersExcellent_Good_25_report($staff_id, $qid, $type,$filter){
        $this->db->from('tbl_student_feedback_answers as q');
        $this->db->join('tbl_students_info as stud', 'stud.student_id = q.student_id','left');
        $this->db->join('tbl_student_class_year_wise as yearwise',  'yearwise.stud_row_id = stud.row_id');
        if(!empty($filter['class_name'])){
            $this->db->where('yearwise.class', $filter['class_name']); 
        }

            if(!empty($filter['section_name'])){
               $this->db->where('yearwise.section', $filter['section_name']); 
            }else{
                 $this->db->where("(yearwise.section IS NULL OR yearwise.section = '')", NULL, FALSE);
            }
            if(!empty($filter['stream_name'])){
               $this->db->where('yearwise.stream', $filter['stream_name']); 
            }else{
                 $this->db->where("(yearwise.stream IS NULL OR yearwise.stream = '')", NULL, FALSE);
            }
        $this->db->where('q.answer', $type); 
        $this->db->where('q.qid', $qid); 
        $this->db->where('q.staff_id', $staff_id); 
        $this->db->where('q.feedback_year', FEEDBACK_YEAR);
        $this->db->where('yearwise.is_deleted', 0);
        $this->db->where('yearwise.intake_year', FEEDBACK_YEAR);
        $query = $this->db->get();
        // return $query->row()->mark;
        $result = $query->result();
        return $result;
    }
}