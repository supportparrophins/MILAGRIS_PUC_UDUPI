<?php if(!defined('BASEPATH')) exit('No direct script access allowed');





class Timetable_model extends CI_Model

{

    public function getClassTimings(){

        $this->db->from('tbl_class_timings as time');

        $this->db->order_by('time.row_id', 'ASC');

        $query = $this->db->get();

        $result = $query->result();

        return $result;


    }

    public function getAllWeekName()
    {
        $this->db->from('tbl_weekname as week');
        $this->db->where('week.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }



    public function getTimeTableInfoByClassID($class_id){

        $this->db->select('

        time.time_row_id,

        week.week_name,

        tstaff.subject_type  as subject_type,

        sub.sub_type as sub_type,

        sub.name as sub_name,

        staff.name as staff_name');

        $this->db->from('tbl_time_table_info as time');

        $this->db->join('tbl_staff_teaching_subjects as tstaff', 'tstaff.row_id = time.staff_subjects_row_id','left');

        $this->db->join('tbl_staff as staff', 'staff.staff_id = tstaff.staff_id','left');

        $this->db->join('tbl_subjects as sub', 'sub.subject_code = tstaff.subject_code','left');

        $this->db->join('tbl_weekname as week', 'week.row_id = time.week_name', 'left');

        $this->db->where('time.class_section_row_id', $class_id);

        $this->db->where('time.is_deleted', 0);

        $query = $this->db->get();

        $result = $query->result();

        return $result;

    }

    

    public function getClassById($section_name,$term_name){

        $this->db->from('tbl_section_info as class');

        $this->db->where('class.term_name', $term_name);

        $this->db->where('class.section_name', $section_name);

        $this->db->where('class.is_deleted', 0);

        $query = $this->db->get();

        return $query->row();

    }

    // public function getClassById($section_name,$term_name){
    //     $this->db->from('tbl_class_section_info_new as class');
    //     $this->db->where('class.term_name', $term_name);
    //     $this->db->where('class.section_name', $section_name);
    //     $this->db->where('class.is_deleted', 0);
    //     $query = $this->db->get();
    //     return $query->row();
    // }

    // public function getAssignedSectionInfo($term_name,$section_name){
    //     $this->db->select('section.row_id,section.term_id,section.section_name,term.term_name');
    //     $this->db->from('tbl_section_info as section');
    //      $this->db->join('tbl_term_name as term', 'term.row_id = section.term_id','left');
        
    //     $this->db->where('term.term_name', $term_name);
    //     $this->db->where('section.section_name', $section_name);
   
    //     $this->db->where('section.is_deleted', 0);
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    // public function getClassTimingsforWeekDays1($filter){
    //     $this->db->select('class.row_id,week.row_id as week_id,class.start_time,class.end_time,week.week_name');
    //     $this->db->from('tbl_class_timings as class');
    //     $this->db->join('tbl_weekname as week', 'week.row_id = class.week_row_id','left');
    //     $this->db->where('week.week_name !=', 'saturday');
    //     $this->db->where('class.class_status', $filter['class_status']);
    //     // $this->db->group_by('class.start_time');
    //     // $this->db->order_by('class.start_time','asc');
    //     $this->db->where('class.is_deleted', 0);
    //     $this->db->where('week.is_deleted', 0);
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    // public function getWeekDayNames() {
    //     $this->db->from('tbl_weekname as week');
    //     $this->db->where('week.week_name !=', 'saturday');
    //     $this->db->where('week.is_deleted', 0);
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    // public function getClassTimingsforWeekend1($filter){
    //     $this->db->select('class.row_id,week.row_id as week_id,class.start_time,class.end_time,week.week_name');
    //     $this->db->from('tbl_class_timings as class');
    //     $this->db->join('tbl_weekname as week', 'week.row_id = class.week_row_id','left');
    //     $this->db->where('week.week_name', 'saturday');
    //     // $this->db->group_by('class.start_time,class.end_time');
    //     $this->db->where('class.class_status', $filter['class_status']);
    //     $this->db->order_by('class.start_time','asc');
    //     $this->db->where('class.is_deleted', 0);
    //     $this->db->where('week.is_deleted', 0);
    //     $query = $this->db->get();
    //     return $query->result();
    // }

   
    public function getClassTimingsforWeekend()
    {
        $this->db->select('class.row_id,week.row_id as week_id,class.start_time,class.end_time,week.week_name');
        $this->db->from('tbl_class_timings as class');
        $this->db->join('tbl_weekname as week', 'week.row_id = class.week_row_id', 'left');
        // $this->db->join('tbl_time_table_info as time' , );
        $this->db->where('week.week_name', 'saturday');
        // $this->db->group_by('class.start_time,class.end_time');
        $this->db->order_by('class.start_time', 'asc');
        $this->db->where('class.is_deleted', 0);
        $this->db->where('week.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }



}