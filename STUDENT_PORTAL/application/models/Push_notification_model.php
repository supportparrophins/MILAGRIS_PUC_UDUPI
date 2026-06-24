<?php

class Push_notification_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->library(array('user_agent'));
        $this->load->helper('date');
    }

    public function getStudentNotifications($limit=75,$filter){  
        $term_name = $this->session->userdata('term_name'); 
        // $course_name = $this->session->userdata('stream_name');
        log_message('debug','dataa='.$term_name);
        log_message('debug','dataa='.print_r($filter,true));
        $this->db->from('tbl_student_notifications as notification');
        if(!empty($term_name)){
            $this->db->where_in('notification.term_name',array($term_name,"ALL"));
        }else{
            $this->db->where('notification.term_name',"ALL");
        }
        if(!empty($filter['stream_name'])){
            $this->db->where_in('notification.stream_name',array($filter['stream_name'],"ALL"));
        }else{
            $this->db->where('notification.stream_name',"ALL");
        }
        if(!empty($filter['section_name'])){
            $this->db->where_in('notification.section_name',array($filter['section_name'],"ALL"));
        }else{
            $this->db->where('notification.section_name',"ALL");
        }
        $this->db->order_by("date_time","DESC");
        $this->db->limit($limit);
        $query = $this->db->get(); 
        return $query->result();
    }

    public function getStudentNotificationsApi($semester,$course_name){  
        $this->db->from('tbl_student_notifications as notification');
        $this->db->where_in('notification.semester',array($semester,"ALL"));
        $this->db->where_in('notification.course_name',array($course_name,"ALL"));
        $this->db->order_by("date_time","DESC");
        $this->db->limit(50);
        $query = $this->db->get(); 
        return $query->result();
    }

    public function StudentNotifications($limit=75){ 
        $course_name = $this->session->userdata('stream_name'); 
        $semester = $this->session->userdata('semester');
        //$stream_name = $this->session->userdata('stream_name');  
       // $section_name = $this->session->userdata('section_name');
        $this->db->distinct();
        $this->db->select('notification.row_id,notification.message,notification.date_time');
        $this->db->from('tbl_student_notifications as notification');
        if(!empty($semester)){
            $this->db->where_in('notification.semester',array($semester,"ALL"));
        }else{
            $this->db->where('notification.semester',"ALL");
        }
        if(!empty($course_name)){
            $this->db->where_in('notification.course_name',array($course_name,"ALL"));
        }else{
            $this->db->where('notification.course_name',"ALL");
        }
        /*if(!empty($stream_name)){
            $this->db->where_in('notification.stream_name',array($stream_name,"ALL"));
        }else{
            $this->db->where('notification.stream_name',"ALL");
        }*/
        // if(!empty($section_name)){
        //     $this->db->where_in('notification.section_name',array($section_name,"ALL"));
        // }else{
        //     $this->db->where('notification.section_name',"ALL");
        // }
        $this->db->order_by("notification.row_id","DESC");
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }
    public function getStudentNotificationsCount($limit=75){  
        $course_name = $this->session->userdata('stream_name'); 
        $semester = $this->session->userdata('semester');
        //$stream_name = $this->session->userdata('stream_name');  
       // $section_name = $this->session->userdata('section_name');
        $this->db->distinct();
        $this->db->select('notification.row_id,notification.message,notification.date_time');
        $this->db->from('tbl_student_notifications as notification');
        if(!empty($semester)){
            $this->db->where_in('notification.semester',array($semester,"ALL"));
        }else{
            $this->db->where('notification.semester',"ALL");
        }
        if(!empty($course_name)){
            $this->db->where_in('notification.course_name',array($course_name,"ALL"));
        }else{
            $this->db->where('notification.course_name',"ALL");
        }
        /*if(!empty($stream_name)){
            $this->db->where_in('notification.stream_name',array($stream_name,"ALL"));
        }else{
            $this->db->where('notification.stream_name',"ALL");
        }*/
        // if(!empty($section_name)){
        //     $this->db->where_in('notification.section_name',array($section_name,"ALL"));
        // }else{
        //     $this->db->where('notification.section_name',"ALL");
        // }
        $this->db->order_by("notification.row_id","DESC");
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function getTodaysNotification(){   
        $term_name = $this->session->userdata('term_name'); 
        $stream_name = $this->session->userdata('stream_name');  
        $section_name = $this->session->userdata('section_name'); 
        date_default_timezone_set('Asia/Kolkata');
        $format = "%Y-%m-%d";
        $cdate = mdate($format);
        $sql = "SELECT * FROM `tbl_student_notifications` WHERE       
                                                        (
                                                            (term_name = ? OR term_name = 'ALL')
                                                            AND
                                                            (stream_name = ? OR stream_name = 'ALL')
                                                            AND
                                                            (section_name =? OR section_name = 'ALL')
                                                        )                                    
                                                        AND
                                                        (
                                                            CAST(date_time AS DATE)= ?
                                                        )
                                                        ORDER BY date_time DESC ;"
                                                        ;
        $this->db->from('tbl_student_notifications');
        $datas=[$term_name,$stream_name,$section_name,$cdate];
        $query=$this->db->query($sql,$datas);
        return $query->result();
    }

     public function getStudentBulkNotifications($todayDate){  
        $studentRowId = $this->session->userdata('studentRowId');
        
        $this->db->from('tbl_student_bulk_notification as notification');
        if(!empty($studentRowId)){
            $this->db->where_in('notification.userId',array($studentRowId,"ALL"));
        }else{
            $this->db->where('notification.userId',"ALL");
        }
       $this->db->where('notification.active_date >=', date('Y-m-d',strtotime($todayDate)));
        $this->db->order_by("updated_date_time","asc");
        $this->db->limit($limit);
        $query = $this->db->get(); 
        return($query->result());
    }

    public function getStudentBulkNotificationsApi($studentRowId){  
        
        $this->db->from('tbl_student_bulk_notification as notification');
        if(!empty($studentRowId)){
            $this->db->where_in('notification.userId',array($studentRowId,"ALL"));
        }else{
            $this->db->where('notification.userId',"ALL");
        }
        //$this->db->where('notification.active_date >=', date('Y-m-d',strtotime($todayDate)));
        $this->db->where('notification.is_deleted',0);
        $this->db->order_by("updated_date_time","asc");
        $query = $this->db->get(); 
        return($query->result());
    }

    public function getStudentfeedBulkNotificationsApi($studentRowId){  
        
        $this->db->from('tbl_student_bulk_notification as notification');
        if(!empty($studentRowId)){
            $this->db->where_in('notification.userId',array($studentRowId,"ALL"));
        }else{
            $this->db->where('notification.userId',"ALL");
        }
        //$this->db->where('notification.active_date >=', date('Y-m-d',strtotime($todayDate)));
        $this->db->where('DATE(notification.updated_date_time)',date('Y-m-d'));
        $this->db->where('notification.is_deleted',0);
        $this->db->order_by("updated_date_time","asc");
        $this->db->limit($limit);
        $query = $this->db->get(); 
        return($query->result());
    }

    public function getStudentAbsentNotifications($todayDate){  
        $studentRowId = $this->session->userdata('studentRowId');
        
        $this->db->from('tbl_absent_sent_sms as notification');
        if(!empty($studentRowId)){
            $this->db->where_in('notification.student_id',array($studentRowId,"ALL"));
        }else{
            $this->db->where('notification.student_id',"ALL");
        }
        $this->db->where('notification.date', date('Y-m-d',strtotime($todayDate)));
        $this->db->where('notification.is_deleted', 0);
        $this->db->order_by("created_date_time","asc");
        $this->db->limit($limit);
        $query = $this->db->get(); 
        return($query->result());
    }

    public function getStudentHomeworkApi($startDate,$endDate,$term_name,$stream_name,$section_name){  
        $this->db->from('tbl_homework_info as homework');
        if(!empty($term_name)){
            $this->db->where_in('homework.term_name',array($term_name,'ALL'));
        }else{
            $this->db->where('homework.term_name',"");
        }
        if($stream_name == " "){
            $this->db->where_in('homework.stream_name',array($stream_name,'ALL'));
        }else if(!empty($stream_name)){
            $this->db->where_in('homework.stream_name',array($stream_name,'ALL'));
        }else{
            $this->db->where_in('homework.stream_name',["",'ALL']); 
        }
        if(!empty($section_name)){
            $this->db->where_in('homework.section_name',array($section_name,'ALL'));
        }else{
            $this->db->where('homework.section_name',"");
        }  
        // $this->db->where('homework.submission_date >=', $active_date);
        $this->db->where("homework.submission_date BETWEEN '{$startDate}' AND '{$endDate}'");
        $this->db->where('homework.is_deleted',0);
        $this->db->where('homework.date_time>=',CURRENT_YEAR.'-04-11');
        $this->db->order_by('homework.date_time', 'DESC');
        $query = $this->db->get(); 
        return $query->result();
    }

    public function getStudentHomeworkfeedApi($term_name,$stream_name,$section_name){  
        $this->db->from('tbl_homework_info as homework');
        if(!empty($term_name)){
            $this->db->where_in('homework.term_name',array($term_name,'ALL'));
        }else{
            $this->db->where('homework.term_name',"");
        }
        if($stream_name == " "){
            $this->db->where_in('homework.stream_name',array($stream_name,'ALL'));
        }else if(!empty($stream_name)){
            $this->db->where_in('homework.stream_name',array($stream_name,'ALL'));
        }else{
            $this->db->where_in('homework.stream_name',["",'ALL']); 
        }
        if(!empty($section_name)){
            $this->db->where_in('homework.section_name',array($section_name,'ALL'));
        }else{
            $this->db->where('homework.section_name',"");
        }  
        $this->db->where('homework.is_deleted',0);
        $this->db->where('DATE(homework.date_time)',date('Y-m-d'));
        $this->db->order_by('homework.submission_date', 'DESC');
        $query = $this->db->get(); 
        return $query->result();
    }


}
