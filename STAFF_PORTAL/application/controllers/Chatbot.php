<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Chatbot extends BaseController {
    public function __construct(){
        parent::__construct();
        $this->load->model('Chatbot_model','chatbot');
    }
    function index(){
        echo "hello";
    }
    function chat(){
        $this->load->view('chatbot/index');
    }
    function getNotifications(){
        if($this->input->server('REQUEST_METHOD') == "POST"){
            $notifs = $this->chatbot->getNotifications();
            if(!empty($notifs)){
                $msgCards = "";
                foreach($notifs as $msg){
                    $msgCards .= '<a draggable="false" class="chat-msg-text response-table">
                                    <span class="title">'.$msg->subject.'</span>
                                    <span class="body">'.$msg->message.'</span>
                                </a>';
                }
                echo $msgCards;
            }
        }else echo "ERROR_404";
    }
    function getHolidays(){
        if($this->input->server('REQUEST_METHOD') == "POST"){
            $holidays = $this->chatbot->getHolidays();
            if(!empty($holidays)){
                $msgCards = "";
                foreach($holidays as $msg){
                    $msgCards .= '<a draggable="false" class="chat-msg-text response-table">
                                    <span class="title">'.$msg->holiday_date.' to '.$msg->holiday_date_to.'</span>
                                    <span class="body">'.$msg->reason.'</span>
                                </a>';
                }
                echo $msgCards;
            }
        }else echo "ERROR_404";
    }
    function getExams(){
        if($this->input->server('REQUEST_METHOD') == "POST"){
            $exams = $this->chatbot->getExams();            
            if(!empty($exams)){
                $msgCards = "";
                foreach($exams as $msg){
                    $msgCards .= '<a draggable="false" class="chat-msg-text response-table">
                                    <span class="title">Date: '.$msg->exam_date.' Time: '.$msg->time.'</span>
                                    <span class="body"><span class="title">Class</span>: '.$msg->class.'<span class="title"> Name</span>: '.$msg->exam_name.'<span class="title"> Sujbect</span>: '.$msg->sub_name.'</span>
                                </a>';
                }
                echo $msgCards;
            }
        }else echo "ERROR_404";
    }
}