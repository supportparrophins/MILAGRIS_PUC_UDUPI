<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class StudentAttendance_model extends CI_Model{

    public function getClassForAttendance($filter, $page, $segment) {
        $this->db->select('class.row_id,section.section_name,section.term_name,stream.stream_name,week.week_name,time.start_time,
        time.end_time,sub.subject_type,subject.name as sub_name,subject.lab_status,class.section_info_row_id,class.week_name_row_id,
        class.time_row_id,class.staff_subjects_row_id,sub.subject_code');
        $this->db->from('tbl_time_table_info as class'); 
        $this->db->join('tbl_section_info as section', 'section.row_id = class.section_info_row_id','left');
        $this->db->join('tbl_stream_info as stream', 'stream.row_id = section.stream_id','left');
        $this->db->join('tbl_weekname as week', 'week.row_id = class.week_name_row_id','left');
        $this->db->join('tbl_class_timings as time', 'time.row_id = class.time_row_id','left');
        $this->db->join('tbl_staff_teaching_subjects as sub', 'sub.row_id = class.staff_subjects_row_id','left');
        $this->db->join('tbl_subjects as subject', 'subject.subject_code = sub.subject_code','left');
        if(!empty($filter['staff_id'])){
            $this->db->where('sub.staff_id', $filter['staff_id']);
        }
        if(!empty($filter['attendance_date'])){
            $this->db->where('week.week_name', $filter['attendance_date']);
        }
        if(!empty($filter['weekName'])){
            $this->db->where('week.week_name', $filter['weekName']);
        }
        $this->db->where('class.is_deleted', 0);
        $this->db->order_by('stream.row_id', 'ASC');
        $this->db->order_by('section.term_name', 'ASC');
        $this->db->order_by('section.section_name', 'ASC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }
    
    public function getClassForAttendanceCount($filter) {
        $this->db->select('class.row_id,section.section_name,section.term_name,stream.stream_name,week.week_name,time.start_time,
        time.end_time,sub.subject_type,subject.sub_name,subject.lab_status,class.section_info_row_id,class.week_name_row_id,
        class.time_row_id,class.staff_subjects_row_id,sub.subject_code');
        $this->db->from('tbl_time_table_info as class'); 
        $this->db->join('tbl_section_info as section', 'section.row_id = class.section_info_row_id','left');
        $this->db->join('tbl_stream_info as stream', 'stream.row_id = section.stream_id','left');
        $this->db->join('tbl_weekname as week', 'week.row_id = class.week_name_row_id','left');
        $this->db->join('tbl_class_timings as time', 'time.row_id = class.time_row_id','left');
        $this->db->join('tbl_staff_teaching_subjects as sub', 'sub.row_id = class.staff_subjects_row_id','left');
        $this->db->join('tbl_subjects as subject', 'subject.subject_code = sub.subject_code','left');
        if(!empty($filter['staff_id'])){
            $this->db->where('sub.staff_id', $filter['staff_id']);
        }
        if(!empty($filter['attendance_date'])){
            $this->db->where('week.week_name', $filter['attendance_date']);
        }
        if(!empty($filter['weekName'])){
            $this->db->where('week.week_name', $filter['weekName']);
        }
        $this->db->where('class.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->num_rows();        
        return $result;
    }

    // get section info
    public function getSectionInfoByRowId($filter=''){
        $this->db->select('section.row_id,section.stream_id,stream.stream_name,section.section_name,section.class_type,
        section.class_teacher,section.term_name');
        $this->db->from('tbl_section_info as section');
        $this->db->join('tbl_stream_info as stream', 'stream.row_id = section.stream_id','left');
        if(!empty( $filter['section_row_id'])){
            $this->db->where('section.row_id',  $filter['section_row_id']);
        }
        $this->db->where('section.is_deleted', 0);
        $this->db->where('stream.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    // get subject info
    public function getSubjectByRowId($filter=''){
        $this->db->select('staff_sub.row_id,staff_sub.subject_type,sub.name as sub_name,sub.lab_status,sub.subject_code,staff.name as staff_name');
        $this->db->from('tbl_staff_teaching_subjects as staff_sub');
        $this->db->join('tbl_subjects as sub', 'sub.subject_code = staff_sub.subject_code');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = staff_sub.staff_id');
        if(!empty( $filter['staff_subject_row_id'])){
            $this->db->where('staff_sub.row_id',  $filter['staff_subject_row_id']);
        }
        $this->db->where('staff_sub.is_deleted', 0);
        $this->db->where('sub.is_deleted', 0);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    
    // check class completed info
    public function getclassCompletedInfo($date,$ubject_code,$time_id,$term_name,$section_name,$stream_name,$subject_type,$student_batch){
        $this->db->from('tbl_class_completed_by_staff as substaff');
        $this->db->where('substaff.date', $date);
        // $this->db->where('substaff.staff_id', $staff_id);
        $this->db->where('substaff.subject_code', $ubject_code);
        $this->db->where('substaff.time_id', $time_id);
        $this->db->where('substaff.term_name', $term_name);
        $this->db->where('substaff.section_name', $section_name);
        $this->db->where('substaff.stream_name', $stream_name);
        $this->db->where('substaff.subject_type', $subject_type);
        $this->db->where('substaff.batch', $student_batch);
        $this->db->where('substaff.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    // add class completed info
    function addStaffTeachedSubjectInfo($subInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_class_completed_by_staff', $subInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    // update class completed info
    public function updateStaffTeachedSubjectInfo($sub_id,$date,$time_id,$subInfo,$term_name,$section_name,$stream_name,$subject_type,$student_batch) {
        // $this->db->where('staff_id', $staff_id);
        $this->db->where('subject_code', $sub_id);
        $this->db->where('time_id', $time_id);
        $this->db->where('date', $date);
        $this->db->where('section_name', $section_name);
        $this->db->where('term_name', $term_name);
        $this->db->where('stream_name', $stream_name);
        $this->db->where('subject_type', $subject_type);
        $this->db->where('batch', $student_batch);
        $this->db->update('tbl_class_completed_by_staff', $subInfo);
        return $this->db->affected_rows();
    }

    //delete all student data 
    function deleteAllStudents($subject_code,$attendanceDate,$time_row_id,$section_row_id,$student_batch){
        $this->db->where('subject_code', $subject_code);
        $this->db->where('absent_date', $attendanceDate);
        $this->db->where('time_row_id', $time_row_id);
        // $this->db->where('staff_subject_row_id ', $staff_subject_row_id); 
        $this->db->where('class_section_row_id', $section_row_id);
        $this->db->where('student_batch', $student_batch);
        $this->db->delete('tbl_student_attendance_details');
        return $this->db->affected_rows();
    }

    // add student absent info
    function addAbsentStudentInfo($studentInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_student_attendance_details', $studentInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }   


    // update attendance
    public function updateAttendanceInfo($id, $attendanceInfo) {
        $this->db->where('row_id', $id);
        $this->db->update('tbl_student_attendance_details', $attendanceInfo);
        return $this->db->affected_rows();
    }

    // check class completed 
    public function checkClassCompletedInfo($date,$ubject_code,$time_id,$term_name,$section_name,$stream_name){
        $this->db->from('tbl_class_completed_by_staff as substaff');
        $this->db->where_in('substaff.date', $date);
        $this->db->where_in('substaff.subject_code', $ubject_code);
        $this->db->where_in('substaff.time_id', $time_id);
        $this->db->where_in('substaff.term_name', $term_name);
        $this->db->where_in('substaff.section_name', $section_name);
        $this->db->where_in('substaff.stream_name', $stream_name);
        $this->db->where('substaff.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    // get class completed info
    public function getAttendanceClassCompletedInfo(){;
        $this->db->from('tbl_class_completed_by_staff as class');
        $this->db->where('class.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    // get class completed count
    public function getStaffClassCompletenfoById(){
        $this->db->from('tbl_class_completed_by_staff as staff');
        // if(!empty($staff_id)){ 
        //     $this->db->where('staff.staff_id', $staff_id);
        // }
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }


    public function CheckTimetableDayShiftExists($filter){
        $this->db->from('tbl_timetable_day_shifting as shift');
        $this->db->join('tbl_weekname as week', 'week.row_id = shift.week_id','left');
        if(!empty($filter['search_date'])){
            $this->db->where('shift.date', $filter['search_date']);
        }
        $this->db->where('shift.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    
    public function getShiftTimetableInfo($filter, $page, $segment) {
        $this->db->select('class.row_id,section.section_name,section.term_name,stream.stream_name,week.week_name,time.start_time,
        time.end_time,sub.subject_type,subject.sub_name,subject.lab_status,class.section_info_row_id,class.week_name_row_id,
        class.time_row_id,class.staff_subjects_row_id,sub.subject_code');
        $this->db->from('tbl_time_table_info as class'); 
        $this->db->join('tbl_section_info as section', 'section.row_id = class.section_info_row_id','left');
        $this->db->join('tbl_stream_info as stream', 'stream.row_id = section.stream_id','left');
        $this->db->join('tbl_weekname as week', 'week.row_id = class.week_name_row_id','left');
        $this->db->join('tbl_class_timings as time', 'time.row_id = class.time_row_id','left');
        $this->db->join('tbl_staff_teaching_subjects as sub', 'sub.row_id = class.staff_subjects_row_id','left');
        $this->db->join('tbl_subjects as subject', 'subject.subject_code = sub.subject_code','left');
        if(!empty($filter['staff_id'])){
            $this->db->where('sub.staff_id', $filter['staff_id']);
        }
        if(!empty($filter['attendance_date'])){
            $this->db->where('week.week_name', $filter['attendance_date']);
        }
        if(!empty($filter['week'])){
            $this->db->where('week.week_name', $filter['week']);
        }
        $this->db->where('class.is_deleted', 0);
        $this->db->order_by('section.term_name', 'ASC');
        $this->db->order_by('section.section_name', 'ASC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }
    
    public function getShiftTimetableInfoCount($filter) {
        $this->db->select('class.row_id,section.section_name,section.term_name,stream.stream_name,week.week_name,time.start_time,
        time.end_time,sub.subject_type,subject.sub_name,subject.lab_status,class.section_info_row_id,class.week_name_row_id,
        class.time_row_id,class.staff_subjects_row_id,sub.subject_code');
        $this->db->from('tbl_time_table_info as class'); 
        $this->db->join('tbl_section_info as section', 'section.row_id = class.section_info_row_id','left');
        $this->db->join('tbl_stream_info as stream', 'stream.row_id = section.stream_id','left');
        $this->db->join('tbl_weekname as week', 'week.row_id = class.week_name_row_id','left');
        $this->db->join('tbl_class_timings as time', 'time.row_id = class.time_row_id','left');
        $this->db->join('tbl_staff_teaching_subjects as sub', 'sub.row_id = class.staff_subjects_row_id','left');
        $this->db->join('tbl_subjects as subject', 'subject.subject_code = sub.subject_code','left');
        if(!empty($filter['staff_id'])){
            $this->db->where('sub.staff_id', $filter['staff_id']);
        }
        if(!empty($filter['attendance_date'])){
            $this->db->where('week.week_name', $filter['attendance_date']);
        }
        if(!empty($filter['week'])){
            $this->db->where('week.week_name', $filter['week']);
        }
        $this->db->where('class.is_deleted', 0);
        $this->db->where('class.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->num_rows();        
        return $result;
    }
    

    // get attendance absent details
    public function getViewAttendanceInfo($filter,$page,$segment) {
        $this->db->select('attendance.row_id,attendance.student_id,attendance.absent_date,student.batch,
        student.student_name,student.section_name,
        student.program_name,student.term_name,student.stream_name,sub.name as sub_name,staff_sub.subject_type,time.start_time,staff.name as staff_name,
        time.end_time');
        $this->db->from('tbl_student_attendance_details as attendance');
        $this->db->join('tbl_subjects as sub', 'sub.subject_code = attendance.subject_code','left');
        $this->db->join('tbl_staff_teaching_subjects as staff_sub', 'staff_sub.row_id = attendance.staff_subject_row_id','left');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = staff_sub.staff_id','left');
        $this->db->join('tbl_class_timings as time', 'time.row_id = attendance.time_row_id','left');
      //  $this->db->join('tbl_student_academic_info as std', 'std.student_id = attendance.student_id','right');
        $this->db->join('tbl_students_info as student', 'student.student_id = attendance.student_id','right');
        
        if(!empty($filter['absentDate'])){
            $this->db->where('attendance.absent_date',$filter['absentDate']); 
        }
        if(!empty($filter['student_id'])){
            $this->db->where('attendance.student_id',$filter['student_id']); 
        }
        if(!empty($filter['student_name'])){
            $this->db->where('student.student_name',$filter['student_name']); 
        }
        if(!empty($filter['staff_id'])){
            $this->db->where('staff_sub.staff_id',$filter['staff_id']); 
        }
        if(!empty($filter['staff_name'])){
            $this->db->where('staff.name',$filter['staff_name']); 
        }
        if(!empty($filter['subject_id'])){
            $this->db->where('attendance.subject_code',$filter['subject_id']); 
        }
        if(!empty($filter['subject_type'])){
            $this->db->where('staff_sub.subject_type',$filter['subject_type']); 
        }
        if(!empty($filter['time'])){
            $this->db->where('time.row_id',$filter['time']); 
        }
        if(!empty($filter['by_term'])){
            $this->db->where('student.term_name',$filter['by_term']); 
        }
        if(!empty($filter['stream_name'])){
            $this->db->where('student.stream_name',$filter['stream_name']); 
        }
        if(!empty($filter['by_Batch'])){
            $this->db->where('student.batch',$filter['by_Batch']); 
        }

        $this->db->where('attendance.year', CURRENT_YEAR);
        $this->db->where('attendance.is_deleted', 0);
        $this->db->where('student.std_status',0);
        $this->db->order_by('student.term_name', 'ASC');
        $this->db->order_by('student.section_name', 'ASC');
        $this->db->order_by('attendance.absent_date', 'DESC');
        $this->db->group_by('attendance.row_id');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    
    public function viewAttendanceInfoCount($filter) {
        $this->db->select('attendance.row_id,attendance.student_id,attendance.absent_date,
        student.student_name,student.section_name,
        student.program_name,student.term_name,student.stream_name,sub.name as sub_name,staff_sub.subject_type,
        time.start_time,staff.name as staff_name,
        time.end_time');
        $this->db->from('tbl_student_attendance_details as attendance');
        $this->db->join('tbl_subjects as sub', 'sub.subject_code = attendance.subject_code','left');
        $this->db->join('tbl_staff_teaching_subjects as staff_sub', 'staff_sub.row_id = attendance.staff_subject_row_id','left');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = staff_sub.staff_id','left');
        $this->db->join('tbl_class_timings as time', 'time.row_id = attendance.time_row_id','left');
       // $this->db->join('tbl_student_academic_info as std', 'std.student_id = attendance.student_id','right');
        $this->db->join('tbl_students_info as student', 'student.student_id = attendance.student_id','right');
        
        if(!empty($filter['absentDate'])){
            $this->db->where('attendance.absent_date',$filter['absentDate']); 
        }
        if(!empty($filter['student_id'])){
            $this->db->where('attendance.student_id',$filter['student_id']); 
        }
        if(!empty($filter['student_name'])){
            $this->db->where('student.student_name',$filter['student_name']); 
        }
        if(!empty($filter['staff_id'])){
            $this->db->where('staff_sub.staff_id',$filter['staff_id']); 
        }
        if(!empty($filter['staff_name'])){
            $this->db->where('staff.name',$filter['staff_name']); 
        }
        if(!empty($filter['subject_id'])){
            $this->db->where('attendance.subject_code',$filter['subject_id']); 
        }
        if(!empty($filter['subject_type'])){
            $this->db->where('staff_sub.subject_type',$filter['subject_type']); 
        }
        if(!empty($filter['time'])){
            $this->db->where('time.row_id',$filter['time']); 
        }
        if(!empty($filter['by_term'])){
            $this->db->where('student.term_name',$filter['by_term']); 
        }
        if(!empty($filter['stream_name'])){
            $this->db->where('student.stream_name',$filter['stream_name']); 
        }
        if(!empty($filter['by_Batch'])){
            $this->db->where('student.batch',$filter['by_Batch']); 
        }

        $this->db->where('attendance.year', CURRENT_YEAR);
        $this->db->where('attendance.is_deleted', 0);
        $this->db->where('student.std_status',0);
        $this->db->group_by('attendance.row_id');
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    }

    
    // get attendance absent details
    public function getAllClassCompletedInfo($filter,$page, $segment) {
        $this->db->select('class.row_id,class.staff_id,class.date,class.section_name,class.term_name,
        class.stream_name,sub.name as sub_name,time.start_time,staff.name as staff_name,class.subject_type,
        time.end_time');
        $this->db->from('tbl_class_completed_by_staff as class');
        $this->db->join('tbl_subjects as sub', 'sub.subject_code = class.subject_code','left');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = class.staff_id','left');
        $this->db->join('tbl_class_timings as time', 'time.row_id = class.time_id','left');
        
        if(!empty($filter['classDate'])){
            $this->db->where('class.date',$filter['classDate']); 
        }
        if(!empty($filter['staffId'])){
            $this->db->where('class.staff_id',$filter['staffId']); 
        }
        if(!empty($filter['subject_code'])){
            $this->db->where_in('class.subject_code',$filter['subject_code']); 
        }
        if(!empty($filter['subject_type'])){
            $this->db->where('class.subject_type',$filter['subject_type']); 
        }
        if(!empty($filter['time'])){
            $this->db->where('time.row_id',$filter['time']); 
        }
        if(!empty($filter['by_term'])){
            $this->db->where('class.term_name',$filter['by_term']); 
        }
        if(!empty($filter['stream_name'])){
            $this->db->where('class.stream_name',$filter['stream_name']); 
        }
        if(!empty($filter['section_name'])){
            $this->db->where('class.section_name',$filter['section_name']); 
        }
        if(!empty($filter['staff_id'])){
            $this->db->where('class.staff_id',$filter['staff_id']); 
        }

        $this->db->where('class.class_year', CURRENT_YEAR);
        $this->db->where('class.is_deleted', 0);
        $this->db->order_by('class.term_name', 'ASC');
        $this->db->order_by('class.section_name', 'ASC');
        $this->db->order_by('class.date', 'DESC');
        $this->db->group_by('class.row_id');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getAllClassCompletedInfoCount($filter) {
        $this->db->select('class.row_id,class.staff_id,class.date,class.section_name,class.term_name,
        class.stream_name,sub.name as sub_name,time.start_time,staff.name as staff_name,class.subject_type,
        time.end_time');
        $this->db->from('tbl_class_completed_by_staff as class');
        $this->db->join('tbl_subjects as sub', 'sub.subject_code = class.subject_code','left');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = class.staff_id','left');
        $this->db->join('tbl_class_timings as time', 'time.row_id = class.time_id','left');
        
        if(!empty($filter['classDate'])){
            $this->db->where('class.date',$filter['classDate']); 
        }
        if(!empty($filter['staffId'])){
            $this->db->where('class.staff_id',$filter['staffId']); 
        }
        if(!empty($filter['subject_code'])){
            $this->db->where_in('class.subject_code',$filter['subject_code']); 
        }
        if(!empty($filter['subject_type'])){
            $this->db->where('class.subject_type',$filter['subject_type']); 
        }
        if(!empty($filter['time'])){
            $this->db->where('time.row_id',$filter['time']); 
        }
        if(!empty($filter['by_term'])){
            $this->db->where('class.term_name',$filter['by_term']); 
        }
        if(!empty($filter['stream_name'])){
            $this->db->where('class.stream_name',$filter['stream_name']); 
        }
        if(!empty($filter['section_name'])){
            $this->db->where('class.section_name',$filter['section_name']); 
        }
        if(!empty($filter['staff_id'])){
            $this->db->where('class.staff_id',$filter['staff_id']); 
        }

        $this->db->where('class.class_year', CURRENT_YEAR);
        $this->db->where('class.is_deleted', 0);
        $this->db->group_by('class.row_id');
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    }
    
    // update class Completed Info
    public function updateClassCompletedInfo($row_id, $classCompletedInfo) {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_class_completed_by_staff', $classCompletedInfo);
        return $this->db->affected_rows();
    }

  

    public function getAbsentedStudentInfo($filter) {
        $this->db->select('attendance.row_id,attendance.student_id,attendance.absent_date,student.student_name,student.section_name,
        student.program_name,student.term_name,student.stream_name,sub.name as sub_name,staff_sub.subject_type,time.start_time,staff.name as staff_name,
        time.end_time');
        $this->db->from('tbl_student_attendance_details as attendance');
        $this->db->join('tbl_subjects as sub', 'sub.subject_code = attendance.subject_code','left');
        $this->db->join('tbl_staff_teaching_subjects as staff_sub', 'staff_sub.row_id = attendance.staff_subject_row_id','left');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = staff_sub.staff_id','left');
        $this->db->join('tbl_class_timings as time', 'time.row_id = attendance.time_row_id','left');
       // $this->db->join('tbl_student_academic_info as std', 'std.student_id = attendance.student_id','right');
        $this->db->join('tbl_students_info as student', 'student.student_id = attendance.student_id','right');
        
        if(!empty($filter['student_id'])){
            $this->db->where('attendance.student_id',$filter['student_id']); 
        }
        if(!empty($filter['staff_id'])){
            $this->db->where('staff_sub.staff_id',$filter['staff_id']); 
        }
        if(!empty($filter['absentDateFrom']) && !empty($filter['absentDateTo'])){
            $this->db->where('attendance.absent_date >=',$filter['absentDateFrom']);
            $this->db->where('attendance.absent_date <=',$filter['absentDateTo']); 
        }
        if(!empty($filter['absentDateFrom'])){
            $this->db->where('attendance.absent_date >=',$filter['absentDateFrom']);
        }
        if(!empty($filter['by_term'])){
            $this->db->where('student.term_name',$filter['by_term']); 
        }
        if(!empty($filter['stream_name'])){
            $this->db->where('student.stream_name',$filter['stream_name']); 
        }
        if(!empty($filter['section_name'])){
            $this->db->where('student.section_name',$filter['section_name']); 
        }

        $this->db->where('attendance.year', CURRENT_YEAR);
        $this->db->where('student.std_status', 0);
        $this->db->where('attendance.is_deleted', 0);
        $this->db->order_by('attendance.absent_date', 'DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

        
    //get class teached subject info for attendance report
    public function getClassInfoAttendanceReportStudent($subject_code,$filter,$type){
        $this->db->from('tbl_class_completed_by_staff as class');
        $this->db->where('class.subject_code', $subject_code);
        // $this->db->where('class.term_name', $term_name);
        // $this->db->where('class.section_name', $section_name);
        
        // if(!empty($filter['date_from']) && !empty($filter['date_to'])){
        //     $this->db->where('class.date >=',$filter['date_from']);
        //     $this->db->where('class.date <=',$filter['date_to']); 
        // }else{

        // }
        // if(!empty($filter['date_from'])){

        //     $this->db->where('class.date >=',$filter['date_from']);
        // }
        if(!empty($filter['doj'])){
            $this->db->where('class.date >=',$filter['doj']);
        }else{
            $this->db->where('class.date >=',$filter['date_from']);

        }
        if(!empty($filter['date_to'])){
            $this->db->where('class.date <=',$filter['date_to']);
        }
        if(!empty($filter['term'])){
            $this->db->where('class.term_name',$filter['term']); 
        }
        if(!empty($filter['preference'])){
            $this->db->where('class.stream_name',$filter['preference']); 
        }
        // if(!empty($filter['section'])){
        //     $this->db->where('class.section_name',$filter['section']); 
        // }
        if (!empty($filter['section'])) {
            $this->db->group_start();
            $this->db->where('class.section_name', $filter['section']);
            $this->db->or_where('class.section_name', 'ALL');
            $this->db->group_end();
        }
        if(!empty($filter['std_batch'])){
            $this->db->where('class.batch',$filter['std_batch']); 
        }
        $this->db->where('class.class_year', CURRENT_YEAR);
        $this->db->where('class.is_deleted', 0);
        $this->db->where('class.subject_type', $type);
        $query = $this->db->get();
        return $query->num_rows();
    }

    //get student is absent or not
    public function isStudentIsAbsentForClass($student_id, $subject_code, $filter,$type){
        $this->db->from('tbl_student_attendance_details as abclass');
        $this->db->join('tbl_staff_teaching_subjects as staff_sub', 'staff_sub.row_id = abclass.staff_subject_row_id','left');
        $this->db->join('tbl_class_completed_by_staff as class', 'class.row_id = abclass.class_row_id', 'left');
        if(!empty($filter['date_from']) && !empty($filter['date_to'])){
            $this->db->where('abclass.absent_date >=',$filter['date_from']);
            $this->db->where('abclass.absent_date <=',$filter['date_to']); 
        }
        if(!empty($filter['date_from'])){
            $this->db->where('abclass.absent_date >=',$filter['date_from']);
        }
        if(!empty($filter['date_to'])){
            $this->db->where('abclass.absent_date <=',$filter['date_to']);
        }
        if (!empty($filter['section'])) {
            $this->db->group_start();
            $this->db->where('class.section_name', $filter['section']);
            $this->db->or_where('class.section_name', 'ALL');
            $this->db->group_end();
        }
        $this->db->where('staff_sub.subject_type',$type);
        $this->db->where('abclass.student_id', $student_id);
        $this->db->where('abclass.subject_code', $subject_code);
        // $this->db->where('abclass.absent_date', date("Y-m-d", strtotime($date)));
        // $this->db->where('abclass.office_verified_status', 0);
        $this->db->where('abclass.year', CURRENT_YEAR);
        $this->db->where('abclass.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();  
    }

    //get total class of attendance added of already class added in attendance
    public function getTotalClassHeldByStaff($subject_code,$filter,$type){
        $this->db->select('class.date');
        $this->db->from('tbl_class_completed_by_staff as class');
        $this->db->where('class.subject_code', $subject_code);
        
        if(!empty($filter['date_from']) && !empty($filter['date_to'])){
            $this->db->where('class.date >=',$filter['date_from']);
            $this->db->where('class.date <=',$filter['date_to']); 
        }
        if(!empty($filter['date_from'])){
            $this->db->where('class.date >=',$filter['date_from']);
        }
        if(!empty($filter['term'])){
            $this->db->where('class.term_name',$filter['term']); 
        }
        if(!empty($filter['preference'])){
            $this->db->where('class.stream_name',$filter['preference']); 
        }
        if(!empty($filter['section'])){
            $this->db->where('class.section_name',$filter['section']); 
        }
        $this->db->where('class.subject_type', $type);
        $this->db->where('class.is_deleted', 0);
    
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    // verify attendance
    public function getClassSectionInfoForAttendance($term,$section,$attendanceDate){
        $this->db->select('class.row_id,class.date,class.subject_code,class.staff_id,class.time_id,class.section_name,class.batch,
        class.term_name,class.subject_type,class.stream_name,class.class_year,sub.name as sub_name,time.start_time,
        time.end_time,staff.name as staff_name');
        $this->db->from('tbl_class_completed_by_staff as class');
        $this->db->join('tbl_subjects as sub', 'sub.subject_code = class.subject_code','left');
        $this->db->join('tbl_class_timings as time', 'time.row_id = class.time_id','left');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = class.staff_id','left');
        $this->db->where('class.section_name', $section);
        $this->db->where('class.term_name', $term);
        $this->db->where('class.date', $attendanceDate);
        $this->db->where('class.class_year', CURRENT_YEAR);
        $this->db->where('class.is_deleted', 0);
        // $this->db->group_by('class.batch');
        $query = $this->db->get();
        return $query->result();

    } 
    
    public function getStaffSubjectRowId($staff_id,$subject_code,$subject_type) {
        $this->db->from('tbl_staff_teaching_subjects as staff_sub');
        $this->db->where('staff_sub.staff_id', $staff_id);
        $this->db->where('staff_sub.subject_code', $subject_code);
        $this->db->where('staff_sub.subject_type', $subject_type);
        // $this->db->where('staff_sub.intake_year', CURRENT_YEAR);
        $this->db->where('staff_sub.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    
    public function checkStudentAttendanceAlreadyExist($student_id,$class_section_row_id,$absentDate,$time_row_id,$staff_subjects_row_id,$subject_code){
        $this->db->from('tbl_student_attendance_details as attendance');
        $this->db->where('attendance.student_id', $student_id);
        $this->db->where('attendance.class_section_row_id', $class_section_row_id);
        $this->db->where('attendance.absent_date', $absentDate);
        $this->db->where('attendance.time_row_id', $time_row_id);
        $this->db->where('attendance.staff_subject_row_id', $staff_subjects_row_id);
        $this->db->where('attendance.subject_code', $subject_code);
        $this->db->where('attendance.year', CURRENT_YEAR);
        $this->db->where('attendance.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }


    public function getAbsenteesInfoDashboard($date) {
        $this->db->select('attendance.row_id,attendance.student_id,attendance.absent_date,
        student.student_name,student.section_name,
        student.program_name,student.term_name,student.stream_name,sub.name as sub_name,staff_sub.subject_type,time.start_time,staff.name as staff_name,
        time.end_time');
        $this->db->from('tbl_student_attendance_details as attendance');
        $this->db->join('tbl_subjects as sub', 'sub.subject_code = attendance.subject_code','left');
        $this->db->join('tbl_staff_teaching_subjects as staff_sub', 'staff_sub.row_id = attendance.staff_subject_row_id','left');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = staff_sub.staff_id','left');
        $this->db->join('tbl_class_timings as time', 'time.row_id = attendance.time_row_id','left');
      //  $this->db->join('tbl_student_academic_info as std', 'std.student_id = attendance.student_id','right');
        $this->db->join('tbl_students_info as student', 'student.student_id = attendance.student_id','right');
               
        $this->db->where('attendance.absent_date',$date); 
           
        $this->db->where('attendance.year', CURRENT_YEAR);
        $this->db->where('attendance.is_deleted', 0);
        $this->db->where('student.std_status', 0);
        $this->db->order_by('student.term_name', 'ASC');
        $this->db->order_by('student.section_name', 'ASC');
        $this->db->order_by('attendance.absent_date', 'DESC');
        $this->db->group_by('attendance.row_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getStaffMonthlyAttendanceInfo($staff_id, $year, $month) {
        $month_pattern = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '%'; // e.g., "2024-08%";
        
        $this->db->select('sa.punch_time as in_time, sa.punch_out_time as out_time, 
                           sa.punch_date, staff.staff_id, staff.type, staff.row_id, 
                           staff.name, dept.name as department, staff.mobile_one, 
                           role_.role, role_.roleId, shift.start_time, shift.end_time, 
                           shift.name as shift_name, shift.shift_code');
        $this->db->from('tbl_staff_attendance_info as sa');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = sa.staff_id');
        $this->db->join('tbl_roles as role_', 'role_.roleId = staff.role');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id');
        $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code');
        $this->db->where('staff.staff_id', $staff_id);
        $this->db->where('sa.punch_date LIKE', $month_pattern);
        $this->db->where('staff.is_deleted', 0);

        $query = $this->db->get();
        return $query->result();
    }

    public function getStaffInfoById($staff_id)
    {
        $this->db->select('staff.user_name, staff.doj, staff.gender, staff.dob, staff.type, staff.row_id, staff.resignation_date,staff.esi_code,
        staff.staff_id, staff.email, staff.name,dept.name as department, staff.mobile_one,staff.mobile_two, staff.tax_regime, staff.uan_no,staff.salary_designation,desig.designation,
        Role.role, staff.role as role_id, staff.staff_type_id, staff.photo_url, staff.address, staff.department_id,staff.leave_approved_status,
        shift.name as shift_name, shift.start_time, shift.end_time, shift.shift_code,
        staff.aadhar_no,staff.voter_no,staff.employee_id,staff.retirement_date,staff.retired_date,staff.pf_number,
        staff.pan_no,staff.qualification,staff.blood_group, leave.casual_leave_earned,leave.sick_leave_earned,leave.marriage_leave_earned,leave.paternity_leave_earned,leave.maternity_leave_earned, leave.lop_leave,leave.casual_leave_used, leave.sick_leave_used, leave.marriage_leave_used,leave.paternity_leave_used, leave.maternity_leave_used,leave.earned_leave');
        $this->db->from('tbl_staff as staff');
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role', 'left');
        $this->db->join('tbl_staff_sections as sec', 'staff.staff_id = sec.staff_id', 'left');
        $this->db->join('tbl_department as dept', 'staff.department_id = dept.dept_id', 'left');
        $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code', 'left');
        $this->db->join(' tbl_staff_leave_management as leave', 'staff.staff_id = leave.staff_id', 'left');
        $this->db->join('tbl_salary_designation_details as desig', 'desig.row_id = staff.salary_designation','left');
        // $this->db->join('tbl_institution_type_info as inst', 'staff.staff_type_id = inst.institutionId','left');
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('dept.is_deleted', 0);
        $this->db->where('staff.resignation_status', 0);
        $this->db->where('staff.retirement_status', 0);
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('Role.roleId !=', '50');
        $this->db->where('Role.roleId !=', '51');
        $this->db->group_by('staff.row_id');
        if($staff_id != 'ALL'){
            $this->db->where('staff.staff_id', $staff_id);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function getAttendanceYearInfo()
    {
        $this->db->from('tbl_year_info as year');
        $this->db->where('year.is_deleted', 0);
        $this->db->where('year.attendance_status', 1);
        $this->db->order_by('year.year','desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function getClassTeacherClasses($staff_id)
    {
        $this->db->select('section.row_id,section.term_name, stream.stream_name, section.section_name');
        $this->db->from('tbl_section_info as section');
        $this->db->join('tbl_stream_info as stream', 'stream.row_id = section.stream_id');
        $this->db->where('section.class_teacher', $staff_id);
        $this->db->where('section.is_deleted', 0);
        $this->db->where('stream.is_deleted', 0);

        return $this->db->get()->result();
    }

    public function getAllClassTeacherClasses()
    {
        $this->db->select('section.row_id,section.term_name, stream.stream_name, section.section_name');
        $this->db->from('tbl_section_info as section');
        $this->db->join('tbl_stream_info as stream', 'stream.row_id = section.stream_id');
        $this->db->where('section.is_deleted', 0);
        $this->db->where('stream.is_deleted', 0);
        return $this->db->get()->result();
    }

    public function checkClassCompletedInfoBasedOnSession($date,$term_name,$section_name,$stream_name,$session){

        $this->db->from('tbl_class_completed_by_class_teacher as substaff');

        $this->db->where_in('substaff.date', $date);

        $this->db->where_in('substaff.term_name', $term_name);

        $this->db->where_in('substaff.section_name', $section_name);

        $this->db->where_in('substaff.stream_name', $stream_name);

        $this->db->where_in('substaff.session', $session);

        $this->db->where('substaff.is_deleted', 0);

        $query = $this->db->get();

        return $query->row();

    }

    public function getTermDetailsBySection($row_id)
    {
        $this->db->select('section.row_id,section.term_name, stream.stream_name, section.section_name');
        $this->db->from('tbl_section_info as section');
        $this->db->join('tbl_stream_info as stream', 'stream.row_id = section.stream_id');
        $this->db->where('section.row_id', $row_id);
        $this->db->where('section.is_deleted', 0);
        $this->db->where('stream.is_deleted', 0);

        return $this->db->get()->row();
    }

    public function getClassTeacherClassCompletedInfo($date,$staff_id,$term_name,$section_name,$stream_name,$session){

        $this->db->from('tbl_class_completed_by_class_teacher as substaff');

        $this->db->where('substaff.date', $date);

        $this->db->where('substaff.term_name', $term_name);

        $this->db->where('substaff.section_name', $section_name);

        $this->db->where('substaff.stream_name', $stream_name);

        $this->db->where('substaff.session', $session);

        $this->db->where('substaff.is_deleted', 0);

        $query = $this->db->get();

        return $query->row();

    }

    function addClassTeacherAttendanceInfo($subInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_class_completed_by_class_teacher', $subInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function updateClassTeacherAttendanceInfo($staff_id,$date,$subInfo,$term_name,$section_name,$stream_name,$session) {

        $this->db->where('date', $date);

        $this->db->where('section_name', $section_name);

        $this->db->where('term_name', $term_name);

        $this->db->where('session', $session);

        $this->db->where('stream_name', $stream_name);

        $this->db->update('tbl_class_completed_by_class_teacher', $subInfo);

        return $this->db->affected_rows();

    }

    function deleteAttendanceStudents($attendanceDate,$term_name,$section_name,$stream_name,$session){

        $this->db->where('absent_date', $attendanceDate);

        $this->db->where('term_name', $term_name);

        $this->db->where('section_name', $section_name);

        $this->db->where('session', $session);
        
        $this->db->where('stream_name', $stream_name);

        $this->db->delete('tbl_class_teacher_attendance_details');

        return $this->db->affected_rows();

    }

    function addAbsentAttendanceInfo($studentInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_class_teacher_attendance_details', $studentInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }   


    public function getClassTeacherAttendanceInfo($filter,$page,$segment) {

        $this->db->select('attendance.row_id,attendance.session,student.student_id,student.admission_no,attendance.absent_date,student.student_name,attendance.section_name,attendance.term_name,attendance.stream_name');

        $this->db->from('tbl_class_teacher_attendance_details as attendance');

        $this->db->join('tbl_students_info as student', 'student.row_id = attendance.student_id','right');


        if(!empty($filter['absentDate'])){

            $this->db->where('attendance.absent_date',$filter['absentDate']); 

        }

        if(!empty($filter['student_id'])){

            $this->db->where('student.student_id',$filter['student_id']); 

        }

        if(!empty($filter['by_term'])){

            $this->db->where('attendance.term_name',$filter['by_term']); 

        }

        if(!empty($filter['session_name'])){

            $this->db->where('attendance.session',$filter['session_name']); 

        }

        if(!empty($filter['staff_id'])){

            $this->db->where('attendance.created_by',$filter['staff_id']); 

        }

        if(!empty($filter['section_name'])){

            $this->db->where('attendance.section_name',$filter['section_name']); 

        }

        if(!empty($filter['stream_name'])){

            $this->db->where('attendance.stream_name',$filter['stream_name']); 

        }

        if(!empty($filter['by_name'])){
            $likeCriteria = "(student.student_name  LIKE '%" . $filter['by_name'] . "%')";
            $this->db->where($likeCriteria);
        }

        if(!empty($filter['date_from']) && !empty($filter['date_to'])){
            $this->db->where('attendance.absent_date >=', $filter['date_from']);
            $this->db->where('attendance.absent_date <=', $filter['date_to']);
        }
        if(!empty($filter['date_from']) ){
            $this->db->where('attendance.absent_date >=', $filter['date_from']);
        }
        if(!empty($filter['date_to'])){
            $this->db->where('attendance.absent_date <=', $filter['date_to']);
        }

          if (!empty($filter['class'])) {
            $this->db->where_in('attendance.term_name', $filter['class']);
        }
        if (!empty($filter['section'])) {
            $this->db->where_in('attendance.section_name', $filter['section']);
        }


        $this->db->where('attendance.is_deleted', 0);
      
        $this->db->where('student.is_deleted', 0);

        // $this->db->where('student.is_active', 1);
        
        $this->db->order_by('attendance.term_name', 'ASC');

        $this->db->order_by('attendance.section_name', 'ASC');

        $this->db->order_by('attendance.absent_date', 'DESC');

        $this->db->limit($page, $segment);

        $query = $this->db->get();

        $result = $query->result();

        return $result;

    }



    

    public function getClassTeacherAttendanceInfoCount($filter) {

        $this->db->select('attendance.row_id,student.student_id,attendance.absent_date,attendance.stream_name,student.student_name,attendance.section_name,attendance.term_name');

         $this->db->from('tbl_class_teacher_attendance_details as attendance');

         $this->db->join('tbl_students_info as student', 'student.row_id = attendance.student_id','right');

        if(!empty($filter['absentDate'])){

            $this->db->where('attendance.absent_date',$filter['absentDate']); 

        }

        if(!empty($filter['student_id'])){

            $this->db->where('student.student_id',$filter['student_id']); 

        }

        if(!empty($filter['by_term'])){

            $this->db->where('attendance.term_name',$filter['by_term']); 

        }

        if(!empty($filter['session_name'])){

            $this->db->where('attendance.session',$filter['session_name']); 

        }

        if(!empty($filter['staff_id'])){

            $this->db->where('attendance.created_by',$filter['staff_id']); 

        }

        if(!empty($filter['section_name'])){

            $this->db->where('attendance.section_name',$filter['section_name']); 

        }

        if(!empty($filter['stream_name'])){

            $this->db->where('attendance.stream_name',$filter['stream_name']); 

        }


        if(!empty($filter['by_name'])){
            $likeCriteria = "(student.student_name  LIKE '%" . $filter['by_name'] . "%')";
            $this->db->where($likeCriteria);
        }

        if(!empty($filter['date_from']) && !empty($filter['date_to'])){
            $this->db->where('attendance.absent_date >=', $filter['date_from']);
            $this->db->where('attendance.absent_date <=', $filter['date_to']);
        }
        if(!empty($filter['date_from']) ){
            $this->db->where('attendance.absent_date >=', $filter['date_from']);
        }
        if(!empty($filter['date_to'])){
            $this->db->where('attendance.absent_date <=', $filter['date_to']);
        }

        $this->db->where('attendance.is_deleted', 0);
        $this->db->where('student.is_deleted', 0);
        $this->db->where('student.is_active', 1);
        $query = $this->db->get();

        $result = $query->num_rows();

        return $result;

    }

    public function updateAbsentAttendanceInfo($id, $attendanceInfo) {
        $this->db->where('row_id', $id);
        $this->db->update('tbl_class_teacher_attendance_details', $attendanceInfo);
        return $this->db->affected_rows();
    }

    public function getTeacherClassCompletedInfo($filter,$page, $segment) {

        $this->db->select('class.row_id,class.session,class.staff_id,class.date,class.section_name,class.term_name,class.stream_name');

        $this->db->from('tbl_class_completed_by_class_teacher as class');

        // $this->db->join('tbl_subjects as sub', 'sub.subject_code = class.subject_code','left');

        // $this->db->join('tbl_staff as staff', 'staff.staff_id = class.staff_id','left');

        // $this->db->join('tbl_class_timings as time', 'time.row_id = class.time_id','left');

        

        if(!empty($filter['classDate'])){

            $this->db->where('class.date',$filter['classDate']); 

        }

        if(!empty($filter['staffId'])){

            $this->db->where('class.staff_id',$filter['staffId']); 

        }

        // if(!empty($filter['subject_code'])){

        //     $this->db->where_in('sub.subject_code',$filter['subject_code']); 

        // }
        if(!empty($filter['staff_id'])){

            $this->db->where('class.staff_id',$filter['staff_id']); 

        }

        if(!empty($filter['stream_name'])){

            $this->db->where('class.stream_name',$filter['stream_name']); 

        }


        if(!empty($filter['by_term'])){

            $this->db->where('class.term_name',$filter['by_term']); 

        }

        if(!empty($filter['section_name'])){

            $this->db->where('class.section_name',$filter['section_name']); 

        }

        if(!empty($filter['session_name'])){
            $this->db->where('class.session',$filter['session_name']); 
        }

        if(!empty($filter['date_from']) && !empty($filter['date_to'])){
            $this->db->where('class.date >=', $filter['date_from']);
            $this->db->where('class.date <=', $filter['date_to']);
        }
        if(!empty($filter['date_from']) ){
            $this->db->where('class.date >=', $filter['date_from']);
        }
        if(!empty($filter['date_to'])){
            $this->db->where('class.date <=', $filter['date_to']);
        }

        $this->db->where('class.is_deleted', 0);

        $this->db->order_by('class.term_name', 'ASC');

        $this->db->order_by('class.section_name', 'ASC');

        $this->db->order_by('class.date', 'DESC');

        $this->db->limit($page, $segment);

        $query = $this->db->get();

        $result = $query->result();

        return $result;

    }



    public function getTeacherClassCompletedInfoCount($filter) {

        $this->db->select('class.row_id,class.staff_id,class.date,class.section_name,class.term_name,class.stream_name');

        $this->db->from('tbl_class_completed_by_class_teacher as class');

        // $this->db->join('tbl_subjects as sub', 'sub.subject_code = class.subject_code','left');

        // $this->db->join('tbl_staff as staff', 'staff.staff_id = class.staff_id','left');

        // $this->db->join('tbl_class_timings as time', 'time.row_id = class.time_id','left');

        

        if(!empty($filter['classDate'])){

            $this->db->where('class.date',$filter['classDate']); 

        }

        if(!empty($filter['staffId'])){

            $this->db->where('class.staff_id',$filter['staffId']); 

        }

        // if(!empty($filter['subject_code'])){

        //     $this->db->where_in('sub.subject_code',$filter['subject_code']); 

        // }
        if(!empty($filter['staff_id'])){

            $this->db->where('class.staff_id',$filter['staff_id']); 

        }

        if(!empty($filter['stream_name'])){

            $this->db->where('class.stream_name',$filter['stream_name']); 

        }


        if(!empty($filter['by_term'])){

            $this->db->where('class.term_name',$filter['by_term']); 

        }

        if(!empty($filter['section_name'])){

            $this->db->where('class.section_name',$filter['section_name']); 

        }

        if(!empty($filter['session_name'])){
            $this->db->where('class.session',$filter['session_name']); 
        }

        if(!empty($filter['date_from']) && !empty($filter['date_to'])){
            $this->db->where('class.date >=', $filter['date_from']);
            $this->db->where('class.date <=', $filter['date_to']);
        }
        if(!empty($filter['date_from']) ){
            $this->db->where('class.date >=', $filter['date_from']);
        }
        if(!empty($filter['date_to'])){
            $this->db->where('class.date <=', $filter['date_to']);
        }


        $this->db->where('class.is_deleted', 0);

        $query = $this->db->get();

        $result = $query->num_rows();

        return $result;

    }

    public function deleteAbsentClassCompleted($row_id, $classCompletedInfo) {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_class_completed_by_class_teacher', $classCompletedInfo);
        return $this->db->affected_rows();
    }

    public function getClassCompletedByTermSectionDateWise($term_name, $section_name, $stream_name, $date_from, $date_to) {
        $date_from = new DateTime($date_from);
        $date_to = new DateTime($date_to);
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($date_from, $interval, $date_to->modify('+1 day'));
    
        $total_count = 0;
        $dates_with_counts = [];
    
        foreach ($period as $date) {
            $dayOfWeek = $date->format('N'); // 1 (for Monday) through 7 (for Sunday)
            $dateStr = $date->format('Y-m-d');
    
            $sql = "SELECT COUNT(*) as count 
                    FROM tbl_class_completed_by_class_teacher 
                    WHERE term_name = ?
                    AND stream_name = ?
                    AND section_name = ?
                    AND date = ?
                    -- AND created_date_time >= '2026-04-11'
                    AND is_deleted = 0";
    
            $params = [$term_name, $stream_name, $section_name, $dateStr];
            $query = $this->db->query($sql, $params);
            $result = $query->row();

                if ($result->count > 0) {
                    $total_count += 1;
                } 
                
                if ($result->count > 1) {
                    $dates_with_counts[] = $dateStr;
                }  

        }
    
        return [
            'total_count' => $total_count,
            'dates' => $dates_with_counts
        ];
    }

    public function getTotalAbsentByRegNoDate($student_id,$term_name,$section_name,$stream_name,$date_from,$date_to,$date_array){
        $date_from = new DateTime($date_from);
        $date_to = new DateTime($date_to);
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($date_from, $interval, $date_to->modify('+1 day'));
    
        $total_count = 0;
    
        foreach ($period as $date) {
            $dayOfWeek = $date->format('N'); // 1 (for Monday) through 7 (for Sunday)
            $dateStr = $date->format('Y-m-d');
    
            $sql = "SELECT COUNT(*) as count 
                    FROM tbl_class_teacher_attendance_details 
                    WHERE term_name = ?
                    AND section_name = ?
                    AND stream_name = ?
                    AND absent_date = ?
                    AND student_id = ?
                    -- AND created_date_time >= '2025-04-11'
                    AND is_deleted = 0";
    
            $params = [$term_name, $section_name, $stream_name, $dateStr,$student_id];
            $query = $this->db->query($sql, $params);
            $result = $query->row();
                if ($result->count > 0) {
                  if(in_array($dateStr,$date_array)){
                    if ($result->count == 1) {
                        $total_count += 0.5;
                    }else if ($result->count == 2) {
                        $total_count += 1;
                    }
                  }else{
                    $total_count += 1;
                  }
                }  
        }
    
        return $total_count; 
    }

    public function getClassTeacherAbsentedStudentInfo($filter) {

        $this->db->select('
            attendance.row_id,
            attendance.session,
            attendance.absent_date,
            student.student_id,
            student.student_name,
            student.admission_no,
            attendance.section_name,
            attendance.term_name,
            attendance.stream_name,
            student.gender,
            attendance.created_by,
            attendance.created_date_time,
            staff.name as staff_name
        ');

        $this->db->from('tbl_class_teacher_attendance_details as attendance');

        $this->db->join('tbl_staff as staff', 'staff.staff_id = attendance.created_by', 'left');

        $this->db->join('tbl_students_info as student', 'student.row_id = attendance.student_id', 'left');

        if(!empty($filter['absentDateFrom']) && !empty($filter['absentDateTo'])){
            $this->db->where('attendance.absent_date >=', $filter['absentDateFrom']);
            $this->db->where('attendance.absent_date <=', $filter['absentDateTo']);
        } elseif(!empty($filter['absentDateFrom'])){
            $this->db->where('attendance.absent_date >=', $filter['absentDateFrom']);
        }

        if(!empty($filter['by_term'])){
            $this->db->where('attendance.term_name', $filter['by_term']);
        }

        if(!empty($filter['stream_name']) && $filter['stream_name'] != 'ALL'){
            $this->db->where('attendance.stream_name', $filter['stream_name']);
        }

        if(!empty($filter['section_name']) && $filter['section_name'] != 'ALL'){
            $this->db->where('attendance.section_name', $filter['section_name']);
        }

        $this->db->where('attendance.is_deleted', 0);
        $this->db->where('student.is_deleted', 0);
        $this->db->order_by('attendance.absent_date', 'DESC');
        $this->db->order_by('student.term_name', 'ASC');
        $this->db->order_by('student.section_name', 'ASC');
        $this->db->order_by('student.student_name', 'ASC');

        $query = $this->db->get();

        return $query->result();
    }

    public function getSubjectNameByCode($sub_code){
        $this->db->select('sub.name');
        $this->db->from('tbl_subjects as sub');
        $this->db->where('sub.subject_code', $sub_code);
        $this->db->where('sub.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function addAbsentSmsLogMessage($whatsappLog){
        $this->db->trans_start();
        $this->db->insert('tbl_absent_sms_info', $whatsappLog);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }
    
}
?>