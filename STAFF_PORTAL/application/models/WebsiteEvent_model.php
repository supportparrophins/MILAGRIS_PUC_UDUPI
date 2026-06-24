<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class WebsiteEvent_model extends CI_Model
{

    function eventListing($filter, $page, $segment)
    {
        if(!empty($filter['by_date'])) {
            $likeCriteria = "(event.date LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->from('tbl_website_event as event'); 
        $this->db->where('event.is_deleted', 0);
        $this->db->order_by('event.date', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        return $query->result();
    }
    function eventCountListing($filter)
    {
        if(!empty($filter['by_date'])) {
            $likeCriteria = "(event.date LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->from('tbl_website_event as event'); 
        $this->db->where('event.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function addNewEvent($eventInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_website_event', $eventInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function getEventInfo($row_id)
    {
        $this->db->from('tbl_website_event as evt');
        $this->db->where('evt.row_id', $row_id);
        $this->db->where('evt.is_deleted', 0);
        $this->db->where('evt.status', 0);
        $query = $this->db->get();
        return $query->row();
    }
    function updateEvent($eventInfo, $row_id)
    {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_website_event', $eventInfo);
        return TRUE;
    } 
    
    function deleteEvent($EventInfo, $row_id)
    {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_website_event', $EventInfo);
        return TRUE;
    }
}