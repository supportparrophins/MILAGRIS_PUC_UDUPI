<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Calendar_model extends CI_Model {
    function getCalendarEvents(){
        $this->db->select('event.row_id as id, event.title, event.start');
        $this->db->select('event.end , event.all_day as allDay');
        $this->db->from('tbl_calendar_event_manager as event');
        $this->db->where('event.is_deleted',0);
        return $this->db->get()->result_array();
    }
    function addEvent($details){
        $this->db->insert('tbl_calendar_event_manager',$details);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function updateEventByID($evtID,$details){
        $this->db->where('event.row_id',$evtID);
        $this->db->where('event.is_deleted',0);
        $this->db->update('tbl_calendar_event_manager as event',$details);
        return $this->db->affected_rows();
    }

    public function getHolidayInfoByRoleCalendar($role){
        $this->db->from('tbl_college_holiday_info as holiday');
        if($role != ROLE_PRIMARY_ADMINISTRATOR){
            $this->db->like('holiday.role_status', $role);
        }
        $this->db->where('holiday.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();          
    }
}