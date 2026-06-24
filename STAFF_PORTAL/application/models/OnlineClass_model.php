<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class OnlineClass_model extends CI_Model
{
    
    public function getAllClassCount($filter){
        $this->db->from('tbl_student_online_class as class');
        if(!empty($filter['term_name'])){
            $this->db->where('class.term_name', $filter['term_name']);
        }
        if(!empty($filter['stream_name'])){
            $this->db->where('class.stream_name', $filter['stream_name']);
        } 
        if(!empty($filter['section_name'])){
            $this->db->where('class.section_name', $filter['section_name']);
        } 
        if(!empty($filter['subject_name'])){
            $this->db->where('class.subject_name', $filter['subject_name']);
        } 
        if($filter['by_date'] != "1970-01-01"){
            $this->db->where('class.date', $filter['by_date']);
        } 
        if(!empty($filter['start_time'])){
            $this->db->where('class.from_time', $filter['start_time']);
        } 
        if(!empty($filter['end_time'])){
            $this->db->where('class.to_time', $filter['end_time']);
        }  
        if(!empty($filter['app_type'])){
            $this->db->where('class.application_type', $filter['app_type']);
        } 
        if(!empty($filter['description'])){
            $this->db->where('class.description', $filter['description']);
        } 
        if(!empty($filter['staff_id'])){
            $this->db->where('class.created_by', $filter['staff_id']);
        } 
        $this->db->where('class.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getAllClassInfo($filter, $page, $segment){
        $this->db->from('tbl_student_online_class as class');
        
        if(!empty($filter['term_name'])){
            $this->db->where('class.term_name', $filter['term_name']);
        }
        if(!empty($filter['stream_name'])){
            $this->db->where('class.stream_name', $filter['stream_name']);
        } 
        if(!empty($filter['section_name'])){
            $this->db->where('class.section_name', $filter['section_name']);
        } 
        if(!empty($filter['subject_name'])){
            $this->db->where('class.subject_name', $filter['subject_name']);
        } 
        if($filter['by_date'] != "1970-01-01"){
            $this->db->where('class.date', $filter['by_date']);
        } 
        if(!empty($filter['start_time'])){
            $this->db->where('class.from_time', $filter['start_time']);
        } 
        if(!empty($filter['end_time'])){
            $this->db->where('class.to_time', $filter['end_time']);
        }  
        if(!empty($filter['app_type'])){
            $this->db->where('class.application_type', $filter['app_type']);
        } 
        if(!empty($filter['description'])){
            $this->db->where('class.description', $filter['description']);
        } 
        if(!empty($filter['staff_id'])){
            $this->db->where('class.created_by', $filter['staff_id']);
        } 
        $this->db->where('class.is_deleted', 0);
        $this->db->order_by('class.row_id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        return $query->result();
    }

    public function addOnlineClass($classInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_student_online_class', $classInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getAllClassInfoById($row_id){
        $this->db->from('tbl_student_online_class as class');
        $this->db->where('class.row_id', $row_id);
        $this->db->where('class.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
        
    }

    public function updateOnlineClassInfo($classInfo,$row_id) {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_student_online_class', $classInfo);
        return TRUE;
    }
}
?>