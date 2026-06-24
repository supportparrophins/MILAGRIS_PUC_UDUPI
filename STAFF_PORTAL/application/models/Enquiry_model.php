<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Enquiry_model extends CI_Model
{

    function enquiryListing($filter)  {
        $this->db->from('tbl_admission_enquiry as enquiry'); 
        if(!empty($filter['searchTextCust'])) {
            $likeCriteria = "(enquiry.message  LIKE '%".$filter['searchTextCust']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_name'])) {
            $likeCriteria = "(enquiry.name  LIKE '%".$filter['by_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_email'])) {
            $this->db->where('enquiry.email', $filter['by_email']);
        }
        if(!empty($filter['by_term_name'])) {
            $this->db->where('enquiry.term_name', $filter['by_term_name']);
        }
        if(!empty($filter['by_stream_name'])) {
            $this->db->where('enquiry.stream_name', $filter['by_stream_name']);
        }
        if(!empty($filter['by_elective_sub'])) {
            $this->db->where('enquiry.elective_sub', $filter['by_elective_sub']);
        }
        
        if(!empty($filter['by_phone_no'])) {
            $this->db->where('enquiry.phone_no', $filter['by_phone_no']);
        }
        
        if(!empty($filter['hostel_facility'])) {
            $this->db->where('enquiry.hostel_facility', $filter['hostel_facility']);
        }
        
        $this->db->where('enquiry.is_deleted', 0);
        $this->db->order_by('enquiry.created_date_time', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }

    function enquiryListingCount($filter) {
        $this->db->from('tbl_admission_enquiry as enquiry'); 
        if(!empty($filter['searchTextCust'])) {
            $likeCriteria = "(enquiry.message  LIKE '%".$filter['searchTextCust']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_name'])) {
            $likeCriteria = "(enquiry.name  LIKE '%".$filter['by_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_email'])) {
            $this->db->where('enquiry.email', $filter['by_email']);
        }
        if(!empty($filter['by_term_name'])) {
            $this->db->where('enquiry.term_name', $filter['by_term_name']);
        }
        if(!empty($filter['by_stream_name'])) {
            $this->db->where('enquiry.stream_name', $filter['by_stream_name']);
        }
        if(!empty($filter['by_elective_sub'])) {
            $this->db->where('enquiry.elective_sub', $filter['by_elective_sub']);
        }

        if(!empty($filter['by_phone_no'])) {
            $this->db->where('enquiry.phone_no', $filter['by_phone_no']);
        }
        
        if(!empty($filter['hostel_facility'])) {
            $this->db->where('enquiry.hostel_facility', $filter['hostel_facility']);
        }
        
        $this->db->where('enquiry.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function updateEnquiryInfo($enquiryInfo,$row_id) {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_admission_enquiry', $enquiryInfo);
        return TRUE;
    }
    public function getAllStreamName() {
        $this->db->from('tbl_stream_info as stream'); 
        $this->db->group_by('stream_name');
        $this->db->where('stream.is_deleted', 0);
        $this->db->order_by('stream.row_id');
        $query = $this->db->get();
        return $query->result();
    }
    public function addAdmissionInfo($admissionInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_admission_enquiry', $admissionInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function getAdmissionInfoById($row_id)
    {
        $this->db->from('tbl_admission_enquiry as admission'); 
        $this->db->where('admission.row_id', $row_id);
        $this->db->where('admission.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    function checkMobileNumberOrEmailExists($phone_no,$email){
        $this->db->from('tbl_admission_enquiry as enquiry');
        $this->db->or_where('enquiry.phone_no', $phone_no);
        $this->db->or_where('enquiry.email', $email);
        $this->db->where('enquiry.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
}
    
    function updateAdmissionEnquiryInfo($admissionEnquiryInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_admission_enquiry', $admissionEnquiryInfo);
        return TRUE;
    }


    
}
