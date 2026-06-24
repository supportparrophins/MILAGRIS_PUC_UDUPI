<?php

class Custom_email_model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->library('email');
    }

    public function getAllStaffsEmail(){
        $this->db->select('email');
        $this->db->from('tbl_staff as staff');
        $this->db->where('staff.email !=','');
        $query = $this->db->get();
        $all_users_email = $query->result_array();
        $sorted_email_ids = array();
        foreach ($all_users_email as $value) {
            array_push($sorted_email_ids,$value['email']);
        }
        return $sorted_email_ids;
    }

    public function getAllStudentsEmail(){
        $this->db->select('email');
        $this->db->from('tbl_students_info as student');
        $this->db->where('student.email !=','');
        $query = $this->db->get();
        $all_users_email = $query->result_array();
        $sorted_email_ids = array();
        foreach ($all_users_email as $value) {
            array_push($sorted_email_ids,$value['email']);
        }
        return $sorted_email_ids;
    }
    
    public function sendEmail($subject,$message,$to=array()){
        if(empty($subject) OR empty($message) OR empty($to)){
            return 0;
        }else{
            return $this->send($subject,$message,$to);
        }
    }
    
    private function send($subject="",$message="",$to=array()){ 
        $this->load->config('email');
        $this->email->set_newline("\r\n");
        $from = $this->config->item('smtp_user');
        $this->email->set_newline("\r\n");
        $this->email->from($from, $this->config->item('sender_name'));
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        if ($this->email->send()) 
        {
            return 1;
        } 
        else 
        {
            return 0;
        }   
    }
}