<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Timetable_model extends CI_Model
{
    public function getAllWeekName()
    {
        $this->db->from('tbl_weekname as week');
        $this->db->where('week.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    public function addClassSection($classInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_class_section_info', $classInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function getSectionInfoById($row_id)
    {
        $this->db->select('section.row_id,section.stream_id,stream.stream_name,section.term_name,section.section_name');
        $this->db->from('tbl_section_info as section');
        $this->db->join('tbl_stream_info as stream', 'stream.row_id = section.stream_id');
        $this->db->where('section.row_id', $row_id);
        // $this->db->order_by('stream.section_name','asc');
        // $this->db->where('section.year', 2021);
        $this->db->where('section.is_deleted', 0);
        $this->db->where('stream.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    public function addTimeTable($timeTableInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_time_table_info', $timeTableInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function checkClassExists($time_id, $week_name_id)
    {
        $this->db->from('tbl_time_table_info as time');
        $this->db->where('time.week_name', $week_name_id);
        $this->db->where('time.time_row_id', $time_id);
        $this->db->where('time.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function updateClassSubject($classInfo, $row_id)
    {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_time_table_info', $classInfo);
        return TRUE;
    }
    // download report
    public function getTimeTableInfoForReportDownload($filter)
    {
        // $this->db->select('');
        $this->db->from('tbl_time_table_info as timeTable');
        $this->db->join('tbl_staff_teaching_subjects as staffSubject', 'timeTable.staff_subjects_row_id = staffSubject.row_id', 'left');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = staffSubject.staff_id', 'left');
        $this->db->join('tbl_subjects as sub', 'sub.subject_code = staffSubject.subject_code', 'left');
        $this->db->join('tbl_class_timings as time', 'time.row_id = timeTable.time_row_id', 'left');
        $this->db->join('tbl_weekname as week', 'week.row_id = timeTable.week_name', 'left');
        $this->db->join('tbl_section_info as section', 'section.row_id = timeTable.class_section_row_id', 'left');
        $this->db->join('tbl_stream_info as stream', 'stream.row_id = section.stream_id', 'left');
        if (!empty($filter['preference'])) {
            $this->db->where('stream.stream_name', $filter['preference']);
        }
        if (!empty($filter['term'])) {
            $this->db->where('section.term_name', $filter['term']);
        }
        if (!empty($filter['section_name'])) {
            $this->db->where_in('section.section_name', $filter['section_name']);
        }
        // $this->db->where('section.year', 2021);
        $this->db->where('time.is_deleted', 0);
        $this->db->where('section.is_deleted', 0);
        $this->db->where('stream.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    // get staff subject information
    public function getAllStaffSubjectInfo($staff_id)
    {
        $this->db->select('timeTable.row_id,week.row_id as week_id,time.start_time,time.end_time,week.week_name,sub.name as sub_name,subject_type,
        section.term_name,stream.stream_name,section.section_name,staff.name,staff.staff_id');
        $this->db->from('tbl_time_table_info as timeTable');
        $this->db->join('tbl_staff_teaching_subjects as staffSubject', 'timeTable.staff_subjects_row_id = staffSubject.row_id', 'left');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = staffSubject.staff_id', 'left');
        $this->db->join('tbl_subjects as sub', 'sub.subject_code = staffSubject.subject_code', 'left');
        $this->db->join('tbl_class_timings as time', 'time.row_id = timeTable.time_row_id', 'left');
        $this->db->join('tbl_weekname as week', 'week.row_id = timeTable.week_name', 'left');
        $this->db->join('tbl_section_info as section', 'section.row_id = timeTable.class_section_row_id', 'left');
        $this->db->join('tbl_stream_info as stream', 'stream.row_id = section.stream_id', 'left');
        $this->db->where('staffSubject.staff_id', $staff_id);
        // $this->db->where('section.year', 2021);
        $this->db->where('staffSubject.is_deleted', 0);
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('sub.is_deleted', 0);
        $this->db->where('timeTable.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    public function getAssignedStreamInfo($filter = '')
    {
        $this->db->select('section.row_id,section.stream_id,stream.stream_name,section.term_name,section.section_name');
        $this->db->from('tbl_section_info as section');
        $this->db->join('tbl_stream_info as stream', 'stream.row_id = section.stream_id');

        if (!empty($filter['term'])) {
            $this->db->where('section.term_name', $filter['term']);
        }
        // $this->db->where('section.year', 2021);
        $this->db->where('section.is_deleted', 0);
        $this->db->where('stream.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    public function getTimeByRowID($week_id)
    {
        $this->db->select('class.row_id,week.row_id as week_id,class.start_time,class.end_time,week.week_name');
        $this->db->from('tbl_class_timings as class');
        $this->db->join('tbl_weekname as week', 'week.row_id = class.week_row_id', 'left');
        $this->db->where('class.week_row_id', $week_id);
        $this->db->where('class.is_deleted', 0);
        $this->db->where('week.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }


    public function getClassTimingsforWeekDays()
    {
        $this->db->select('class.row_id,week.row_id as week_id,class.start_time,class.end_time,week.week_name');
        $this->db->from('tbl_class_timings as class');
        $this->db->join('tbl_weekname as week', 'week.row_id = class.week_row_id', 'left');
        $this->db->where('week.week_name !=', 'saturday');
        // $this->db->group_by('class.start_time');
        // $this->db->order_by('class.start_time','asc');
        $this->db->where('class.is_deleted', 0);
        $this->db->where('week.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getWeekDayNames()
    {
        $this->db->from('tbl_weekname as week');
        $this->db->where('week.week_name !=', 'saturday');
        $this->db->where('week.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getClassTimingsforWeekend()
    {
        $this->db->select('class.row_id,week.row_id as week_id,class.start_time,class.end_time,week.week_name');
        $this->db->from('tbl_class_timings as class');
        $this->db->join('tbl_weekname as week', 'week.row_id = class.week_row_id', 'left');
        $this->db->where('week.week_name', 'saturday');
        // $this->db->group_by('class.start_time,class.end_time');
        $this->db->order_by('class.start_time', 'asc');
        $this->db->where('class.is_deleted', 0);
        $this->db->where('week.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getWeekendNames()
    {
        $this->db->from('tbl_weekname as week');
        $this->db->where('week.week_name', 'saturday');
        $this->db->where('week.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    public function getStudentAbsentDetails($absentDate, $studentId, $term_name)
    {
        $this->db->select('
        std.student_name,
        std.father_mobile,
        std.mother_mobile,
        attendance.absent_date,
        sub.name as sub_name');
        $this->db->from('tbl_student_attendance_details as attendance');
        $this->db->join('tbl_students_info as std', 'std.student_id = attendance.student_id', 'left');
        $this->db->join('tbl_subjects as sub', 'sub.subject_code = attendance.subject_code', 'left');
        $this->db->where('attendance.student_id', $studentId);
        // $this->db->where('std.term_name', $term_name);
        $this->db->where('attendance.absent_date', $absentDate);
        $this->db->where('attendance.sms_sent_status', 0);
        $this->db->where('attendance.office_verified_status', 1);
        $this->db->where('attendance.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function updateAttendanceSMSStatus($student_id, $date_absent, $attendanceInfo)
    {
        $this->db->where('student_id', $student_id);
        $this->db->where('absent_date', $date_absent);
        $this->db->update('tbl_student_attendance_details', $attendanceInfo);
        return $this->db->affected_rows();
    }
    public function getTimeInfoByRowID($row_id) {
        $this->db->from('tbl_class_timings as t');
        $this->db->where('t.row_id', $row_id);
        $this->db->where('t.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function updateSection($sectionInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_section_info', $sectionInfo);
        return TRUE;
    }

    public function getSectionDetailsById($row_id)
    {
        $this->db->select('section.row_id,section.stream_id,stream.stream_name,section.term_name,section.section_name,section.class_teacher,staff.name');
        $this->db->from('tbl_section_info as section');
        $this->db->join('tbl_stream_info as stream', 'stream.row_id = section.stream_id','left');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = section.class_teacher','left');
        $this->db->where('section.row_id', $row_id);
        // $this->db->order_by('stream.section_name','asc');
        // $this->db->where('section.year', 2021);
        $this->db->where('section.is_deleted', 0);
        $this->db->where('stream.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    
}
