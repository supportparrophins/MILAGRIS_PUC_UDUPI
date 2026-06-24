<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class PushNotification extends BaseController {
    public function __construct() {
        parent:: __construct();   
        $this->load->model('push_notification_model');   
        $this->load->model('student_model');
        $this->isLoggedIn();  
    }
    
    public function myNotifications(){
        $data['studentInfo'] = $this->student_model->getStudentInfoById($this->student_id,$this->term_name);
        $filter['stream_name']= $data['studentInfo']->stream_name;
        $filter['section_name']= $data['studentInfo']->section_name;
        $data['notifications'] = $this->push_notification_model->getStudentNotifications($limit=75,$filter);
      
        $this->global['pageTitle'] = ''.TAB_TITLE.' : My Notifications';
        $this->loadViews("student/myNotifications", $this->global, $data , NULL);
    } 

}
