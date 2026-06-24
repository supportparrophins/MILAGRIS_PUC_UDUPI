<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Registration_model extends CI_Model
{
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function userRegisterDB($studentInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_student_app_registration', $studentInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function isStudentAlreadyRegisterd($student_id){
        $this->db->from('tbl_student_app_registration as student');
        $this->db->where('student.student_id', $student_id);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function checkStuentIdAndDobIsValid($student_id,$term_name){
        $this->db->from('tbl_students_info as std');
        $this->db->where('std.is_active', 1);
        $this->db->where('std.student_id', $student_id);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
        
    }

}