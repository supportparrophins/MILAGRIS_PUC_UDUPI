<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Announcement_model extends CI_Model
{

    function announcementListing($filter)
    {
        if(!empty($filter['searchTextCust'])) {
            $likeCriteria = "(msg.message  LIKE '%".$filter['searchTextCust']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_date'])) {
            $likeCriteria = "(msg.date  LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        }

        $this->db->from('tbl_website_announcement as msg'); 
        $this->db->where('msg.is_deleted', 0);
        $this->db->order_by('msg.date', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }
    function announcementCountListing($filter='')
    {
        if(!empty($filter['searchTextCust'])) {
            $likeCriteria = "(msg.message LIKE '%".$filter['searchTextCust']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_date'])) {
            $likeCriteria = "(msg.date  LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->from('tbl_website_announcement as msg'); 
        $this->db->where('msg.is_deleted', 0);
        $this->db->order_by('msg.date', 'DESC');
        $query = $this->db->get();
        return $query->num_rows();
    }
    function addNewMessage($MessageInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_website_announcement', $MessageInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function getAnnouncementMessage($row_id)
    {
        $this->db->from('tbl_website_announcement as message');
        $this->db->where('message.row_id', $row_id);
        $this->db->where('message.is_deleted', 0);
        // $this->db->where('message.status', 0);
        $query = $this->db->get();
        return $query->row();
    }
    function updateMessage($MessageInfo, $row_id)
    {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_website_announcement', $MessageInfo);
        return TRUE;
    } 

    function disableAnnouncement($AnnouncementInfo, $row_id)
    {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_website_announcement', $AnnouncementInfo);
        return TRUE;
    }
}