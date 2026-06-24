<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class PortalSuggestion_model extends CI_Model
{
    function feedbackCountListing($filter)
    {
        // $this->db->select('DISTINCT `msg.student_id`');
        $this->db->select('msg.row_id,msg.subject,msg.message,msg.msg_from,msg.reply_from,msg.date,msg.management_reply,std.student_name,
        std.term_name,std.section_name,std.program_name');
        $this->db->select_max('msg.date');
        // $this->db->select_max('msg.message');
        // $this->db->select_max('msg.row_id');
        // $this->db->distinct('msg.student_id');
        $this->db->from('tbl_student_feedback_for_management as msg'); 
        // $this->db->join('tbl_student_academic_info as academic', 'academic.student_id = msg.student_id','left');
        $this->db->join('tbl_students_info as std','std.student_id = msg.student_id','left'); 
        
        if(!empty($filter['searchTextCust'])) {
            $likeCriteria = "(msg.student_id LIKE '%".$filter['searchTextCust']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_term'])) {
            $this->db->where('std.term_name', $filter['by_term']);
        }
        if(!empty($filter['by_section'])) {
            $this->db->where('std.section_name', $filter['by_section']);
        }
        if(!empty($filter['by_date'])) {
            $likeCriteria = "(msg.date LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('msg.is_deleted', 0);
        // $this->db->order_by('msg.date','DESC');
        $this->db->group_by('msg.student_id');
        $query = $this->db->get();
        return $query->num_rows();
    }
    function feedbackListing($filter, $page, $segment)
    {
        $this->db->select('msg.row_id,msg.subject,msg.message,msg.msg_from,msg.reply_from,msg.date,msg.management_reply,std.student_name,
        std.term_name,std.section_name,std.program_name,std.student_id');
        $this->db->select_max('msg.date');
        // $this->db->select_max('msg.row_id');
        // $this->db->select_max('msg.message');
        // $this->db->distinct();
        $this->db->from('tbl_student_feedback_for_management as msg'); 
        $this->db->join('tbl_students_info as std','std.student_id = msg.student_id','left'); 
        
        if(!empty($filter['searchTextCust'])) {
            $likeCriteria = "(msg.student_id LIKE '%".$filter['searchTextCust']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_term'])) {
            $this->db->where('std.term_name', $filter['by_term']);
        }
        if(!empty($filter['by_section'])) {
            $this->db->where('std.section_name', $filter['by_section']);
        }
        if(!empty($filter['by_date'])) {
            $likeCriteria = "(msg.date LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('msg.is_deleted', 0);
        $this->db->order_by('max(msg.date)','DESC');
        $this->db->group_by('std.student_id');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        return $query->result();
    }
    
    function updateReplyMessage($messageInfo, $row_id)
    {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_student_feedback_for_management', $messageInfo);
        return TRUE;
    } 
    function getStudentMessageById($student_id)
    {
        $this->db->from('tbl_student_feedback_for_management as msg');
        $this->db->where('msg.student_id', $student_id);
        $this->db->order_by('msg.date','ASC');
        $query = $this->db->get();
        return $query->result();
    }
    function disableSuggestion($portalSuggestionInfo, $row_id)
    {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_student_feedback_for_management', $portalSuggestionInfo);
        return TRUE;
    }

    function getSuggestionByStudentId($student_id)
    {
        $this->db->select('*');
        // $this->db->select_max('msg.row_id');
        $this->db->from('tbl_student_feedback_for_management as msg');
        $this->db->where('msg.student_id', $student_id);
        $this->db->order_by('msg.row_id','DESC');
        $query = $this->db->get();
        return $query->row();
    }

    function sendMessage($messageInfo) {
         $this->db->trans_start();
        $this->db->insert('tbl_student_feedback_for_management', $messageInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
}