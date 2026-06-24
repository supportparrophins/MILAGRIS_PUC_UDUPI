<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require APPPATH . '/libraries/BaseControllerFaculty.php';

class PortalSuggestion extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('portalSuggestion_model','suggestion');
        $this->load->model('push_notification_model');
        $this->load->model('students_model','student');
        $this->isLoggedIn();
    }
    public function suggestionListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else 
        {         
            $filter = array();
            $studentMessageInfo = array();
            $searchText = $this->security->xss_clean($this->input->post('searchTextCust'));
            $by_date = $this->security->xss_clean($this->input->post('by_date'));
            $by_term = $this->security->xss_clean($this->input->post('by_term'));
            $by_section = $this->security->xss_clean($this->input->post('by_section'));
            $data['searchTextCust'] = $searchText;
            $data['by_term'] = $by_term;
            $data['by_section'] = $by_section;
            $filter['searchTextCust'] = $searchText;
            $filter['by_term'] = $by_term;
            $filter['by_section'] = $by_section;
            if(!empty($by_date)){
                $data['by_date'] = date('d-m-Y', strtotime($by_date));
                $filter['by_date'] = date('Y-m-d',strtotime($by_date));
            }else{
                $data['by_date'] = '';
            }
            $this->load->library('pagination');
            $count = $this->suggestion->feedbackCountListing($filter);
			$returns = $this->paginationCompress ( "suggestionListing/", $count, 100);
            $data['count_msg'] = $count;
            $suggestionInfo = $this->suggestion->feedbackListing($filter, $returns["page"], $returns["segment"]);

            foreach($suggestionInfo as $std){
                $stdInfo = $this->suggestion->getSuggestionByStudentId($std->student_id);
                $studentMessageInfo[$std->student_id]['row_id'] = $stdInfo->row_id;
                $studentMessageInfo[$std->student_id]['date'] = $stdInfo->date;
                $studentMessageInfo[$std->student_id]['msg'] = $stdInfo->message;
            }
            $data['studentMessageInfo'] = $studentMessageInfo;
            $data['suggestionInfo'] = $suggestionInfo;
            $data['studentInfo'] = $this->student->getAllStudentsInfo();
            $data['accessInfo'] = $this->getCurrentAccess();
            // log_message('debug','jdiejh'.print_r($data['count_msg'],true));
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Student Portal Suggestion';
            $this->loadViews("feedback/student_portal_feedback", $this->global, $data , NULL);
        }
    }

    public function updateManagementMsg(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $row_id = $this->input->post('row_id');
         
            $this->load->library('form_validation');
            $this->form_validation->set_rules('submit_message','Reply','trim|required'); 
            if($this->form_validation->run() == FALSE)
            {
                $this->suggestionListing();  
            }
            else
            {
                $submit_message = $this->input->post('submit_message');
                $messageInfo = array('management_reply' => $submit_message,'reply_from' => 'Principal', 'updated_by' => $this->vendorId, 'updated_date_time' => date('Y-m-d H:i:s'));
                // $tokens=$this->push_notification_model->getTokenForReplyMessage($row_id);
                // $this->push_notification_model->sendMessage('A new message from the Admin',$submit_message,$tokens,USER_TYPE_STUDENT);                
                $result = $this->suggestion->updateReplyMessage($messageInfo, $row_id);
                if($result)
                {
                    $this->session->set_flashdata('success', 'Replied Successfully');
                    echo "TRUE";
                    exit(0); 
                }
                else
                {
                    echo "FALSE";
                    exit(0);
                }
             
            }
        }
    }

    public function getStudentMessageById(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }
        else{        
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $studentInfo = $this->suggestion->getStudentMessageById($student_id);
            echo json_encode($studentInfo);
            exit(0);
        }
    }

    public function disableSuggestion(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $portalSuggestionInfo = array('status' => 1, 'updated_by' => $this->vendorId, 'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->suggestion->disableSuggestion($portalSuggestionInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
    public function enableSuggestion(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $portalSuggestionInfo = array('status' => 0, 'updated_by' => $this->vendorId, 'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->suggestion->disableSuggestion($portalSuggestionInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function sendMsgByStudentId(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $row_id = $this->input->post('row_id');
         
            $this->load->library('form_validation');
            $this->form_validation->set_rules('send_message','Message','trim|required');
            $this->form_validation->set_rules('student_id','Student ID','trim|required');
            if($this->form_validation->run() == FALSE) {
                $this->suggestionListing();  
            } else {
                $send_message = $this->input->post('send_message');
                $student_id = $this->input->post('student_id');
                $messageInfo = array(
                    'student_id' => $student_id,
                    'management_reply' => $send_message,
                    'reply_from' => 'Principal', 
                    'updated_by' => $this->vendorId, 
                    'updated_date_time' => date('Y-m-d H:i:s'));
            
                $result = $this->suggestion->sendMessage($messageInfo);
                
                if($result > 0 ){
                 $this->session->set_flashdata('success', 'Message Successfully Sent');
                
                }else{
                    $this->session->set_flashdata('error', 'Failed to Send 
                        Message');
                }
                redirect('suggestionListing');
             
            }
        }
    }

}