<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class admissionEnquiry_model extends CI_Model
{

    public function getAllStudentAdmissionEnquiryInfo($filter, $page, $segment){
        $this->db->select('admission.row_id, admission.student_name, admission.religion, admission.admission_type, admission.mobile_one, admission.mobile_two, admission.gender, admission.category, admission.comment, admission.date, admission.next_date_enquiry');
        $this->db->from('tbl_admission_enquiry as admission'); 
      
        if(!empty($filter['by_name'])){
            $likeCriteria = "(admission.student_name  LIKE '%" . $filter['by_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        
        if(!empty($filter['mobile_one'])){
            $likeCriteria = "(admission.mobile_one  LIKE '%" . $filter['mobile_one'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['mobile_one'])){
            $likeCriteria = "(admission.mobile_one  LIKE '%" . $filter['mobile_one'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['admission_type'])){
            $this->db->where('admission.admission_type', $filter['admission_type']);
        }
        if(!empty($filter['by_date'])){
            $this->db->where('admission.date', $filter['by_date']);
        }
        if(!empty($filter['gender'])){
            $this->db->where('admission.gender', $filter['gender']);
        }
         if(!empty($filter['religion'])){
            $this->db->where('admission.religion', $filter['religion']);
        }
        if(!empty($filter['category'])){
            $this->db->where('admission.category', $filter['category']);
        }
        if(!empty($filter['comment'])){
            $likeCriteria = "(admission.comment  LIKE '%" . $filter['comment'] . "%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('admission.is_deleted', 0);
        // $this->db->order_by('admission.date', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllAdmissionEnquiryCount($filter=''){
        $this->db->select('admission.row_id, admission.student_name, admission.religion, admission.admission_type, admission.mobile_one, admission.mobile_two, admission.gender, admission.category, admission.comment, admission.date, admission.next_date_enquiry');
        $this->db->from('tbl_admission_enquiry as admission'); 
      
        if(!empty($filter['by_name'])){
            $likeCriteria = "(admission.student_name  LIKE '%" . $filter['by_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['mobile_one'])){
            $likeCriteria = "(admission.mobile_one  LIKE '%" . $filter['mobile_one'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['mobile_two'])){
            $likeCriteria = "(admission.mobile_two  LIKE '%" . $filter['mobile_two'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['admission_type'])){
            $this->db->where('admission.admission_type', $filter['admission_type']);
        }
        if(!empty($filter['by_date'])){
            $this->db->where('admission.date', $filter['by_date']);
        }
        if(!empty($filter['gender'])){
            $this->db->where('admission.gender', $filter['gender']);
        }
        if(!empty($filter['religion'])){
            $this->db->where('admission.religion', $filter['religion']);
        }
        if(!empty($filter['category'])){
            $this->db->where('admission.category', $filter['category']);
        }
        if(!empty($filter['comment'])){
            $likeCriteria = "(admission.comment  LIKE '%" . $filter['comment'] . "%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('admission.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

  
      public function getAdmissionInfoById($row_id)
    {
        $this->db->select('admission.row_id, admission.student_name, admission.email, admission.admission_type, admission.mobile_one, admission.mobile_two, admission.gender, admission.address, admission.comment, admission.date, admission.next_date_enquiry, admission.religion, admission.category');
        $this->db->from('tbl_admission_enquiry as admission'); 
        $this->db->where('admission.row_id', $row_id);
        $this->db->where('admission.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function addAdmissionInfo($admissionInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_admission_enquiry', $admissionInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

     function checkMobileNumberExists($mobile_one,$mobile_two){
            $this->db->from('tbl_admission_enquiry as admission');
            $this->db->or_where('admission.mobile_one', $mobile_one);
            $this->db->or_where('admission.mobile_two', $mobile_two);
            $this->db->where('admission.is_deleted', 0);
            $query = $this->db->get();
            return $query->num_rows();
    }

      function updateAdmissionEnquiryInfo($admissionEnquiryInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_admission_enquiry', $admissionEnquiryInfo);
        return TRUE;
    }

    function getCasteInfo(){
        $this->db->from('tbl_caste_details as caste');
        $this->db->order_by('caste.caste_name', 'ASC');
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    function getReligionInfo(){
        $this->db->from('tbl_religion_details as religion');
        $this->db->order_by('religion.name', 'ASC');
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    
    public function getAdmissionEnquiryInfoForReportDownload($filter){
        $this->db->select('admission.row_id, admission.name, admission.stream_name, admission.term_name, 
        admission.phone_no, admission.exam_coaching, admission.elective_sub, admission.current_institution_name, admission.comment');
        $this->db->from('tbl_admission_enquiry as admission'); 
        if(!empty($filter['term_name'])){
            $this->db->where_in('admission.term_name', $filter['term_name']);
        }
        $this->db->where('admission.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
 }
?>