<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class WebsiteTestimonials_model extends CI_Model
{

    function feedbackListing($filter, $page, $segment)
    {
        if(!empty($filter['searchTextCust'])) {
            $likeCriteria = "(feedback.name  LIKE '%".$filter['searchTextCust']."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->from('tbl_website_alumni_testimonials as feedback'); 
        $this->db->where('feedback.is_deleted', 0);
        $this->db->order_by('feedback.created_date_time','DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        return $query->result();
    }
    function feedbackCountListing($filter)
    {
        if(!empty($filter['searchTextCust'])) {
            $likeCriteria = "(feedback.name  LIKE '%".$filter['searchTextCust']."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->from('tbl_website_alumni_testimonials as feedback'); 
        $this->db->where('feedback.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function addTestimonials($feedbackInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_website_alumni_testimonials', $feedbackInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getFeedbackInfo($row_id)
    {
        $this->db->from('tbl_website_alumni_testimonials as feedback');
        $this->db->where('feedback.row_id', $row_id);
        $this->db->where('feedback.is_deleted', 0);
        $this->db->where('feedback.status', 0);
        $query = $this->db->get();
        return $query->row();
    }
    function updateTestimonials($feedbackInfo, $row_id)
    {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_website_alumni_testimonials', $feedbackInfo);
        return TRUE;
    } 

    function deleteTestimonial($testimonialInfo, $row_id)
    {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_website_alumni_testimonials', $testimonialInfo);
        return TRUE;
    }
}