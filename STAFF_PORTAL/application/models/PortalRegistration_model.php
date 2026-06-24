<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class PortalRegistration_model extends CI_Model
{
    public function registeredStudents($filter='') {
        $this->db->select('register.row_id,register.student_id,register.dob,register.created_date');
        $this->db->from('tbl_student_app_registration as register'); 
        // $this->db->join('tbl_student_academic_info as academic','academic.student_id = register.student_id');
        // $this->db->join('tbl_students_info as std','std.application_no = academic.application_no');
        
        if(!empty($filter['student_id'])) {
            $this->db->where('register.student_id', $filter['student_id']);
        }
        if(!empty($filter['by_dob'])) {
            $likeCriteria = "(register.dob LIKE '%".$filter['by_dob']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_date'])) {
            $likeCriteria = "(register.created_date LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        }

        $this->db->where('register.is_deleted', 0);
        // $this->db->where('academic.is_deleted', 0);
        // $this->db->where('std.is_deleted', 0);
        $this->db->order_by('register.created_date','DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }
    public function registeredStudentsCount($filter) {
        $this->db->select('register.row_id,register.student_id,register.dob,register.created_date');
        $this->db->from('tbl_student_app_registration as register'); 
        
        if(!empty($filter['student_id'])) {
            $this->db->where('register.student_id', $filter['student_id']);
        }
        if(!empty($filter['by_dob'])) {
            $likeCriteria = "(register.dob LIKE '%".$filter['by_dob']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_date'])) {
            $likeCriteria = "(register.created_date LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        }

        $this->db->where('register.is_deleted', 0);
        $this->db->order_by('register.created_date','DESC');
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function updatePassword($registerInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_student_app_registration', $registerInfo);
        return TRUE;
    } 
}
?>