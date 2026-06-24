<?php

class Chatbot_model extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    function getNotifications(){
        $dept = $this->session->userdata('dept_id');
        $this->db->select('dept.name as dept_name');
        $this->db->select('notification.department,notification.subject,notification.message,notification.filepath,notification.sent_by,notification.date_time');
        $this->db->from('tbl_staff_notifications as notification');
        $this->db->join('tbl_department as dept','dept.dept_id = notification.department','left');
        if($dept != 4){
            $this->db->where_in('notification.department',array('ALL',$dept));
        }
        $this->db->where('notification.is_deleted', 0);
        $this->db->order_by("date_time", "DESC");
        $this->db->limit(5);
        $query = $this->db->get();
        return $query->result();
    }
    function getHolidays(){
        $role = $this->session->userdata('role');
        $this->db->select('holiday.holiday_date, holiday.holiday_date_to, holiday.reason');
        $this->db->from('tbl_college_holiday_info as holiday');            
        if($role == ROLE_TEACHING_STAFF)
            $this->db->where('holiday.teaching_staff_status',1);
        else if($role == ROLE_NON_TEACHING_STAFF)
            $this->db->where('holiday.non_teaching_staff_status',1);
        else if($role == ROLE_SUPPORT_STAFF)
            $this->db->where('holiday.support_staff_status',1);
        $this->db->where('holiday.holiday_date >=',date('Y-m-d'));
        $this->db->where('holiday.is_deleted',0);
        $this->db->limit(5);
        $query = $this->db->get();
        return $query->result();
    }
    function getExams(){
        $this->db->select('exam.exam_date, exam.time, exam.exam_name, exam.class, subject.sub_name');
        $this->db->from('tbl_exam_info as exam');
        $this->db->join('tbl_subjects as subject','subject.subject_code = exam.subject_code');
        $this->db->where('exam.exam_date >=',date('Y-m-d'));
        $this->db->where('exam.is_deleted',0);
        $this->db->limit(7);
        $query = $this->db->get();
        return $query->result();
    }
}