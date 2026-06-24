<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Mun extends BaseController {
    public function __construct()
    {
        parent::__construct();
        //$this->load->library('excel');
        $this->load->model('mun_model','mun');
        $this->isLoggedIn();
    }

    function getMunEventInfo(){
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $filter = array();
            $name = $this->security->xss_clean($this->input->post('name'));
            $registeration_type = $this->security->xss_clean($this->input->post('registeration_type'));
            $status = $this->security->xss_clean($this->input->post('status'));
            $amount = $this->security->xss_clean($this->input->post('amount'));
            $order_id = $this->security->xss_clean($this->input->post('order_id'));
            $mobile_no = $this->security->xss_clean($this->input->post('mobile_no'));

            $data['name'] = $name;
            $data['registeration_type'] = $registeration_type;
            $data['status'] = $status;
            $data['amount'] = $amount;
            $data['order_id'] = $order_id;
            $data['mobile_no'] = $mobile_no;

            $filter['name'] = $name;
            $filter['registeration_type'] = $registeration_type;
            $filter['status'] = $status;
            $filter['amount'] = $amount;
            $filter['order_id'] = $order_id;
            $filter['mobile_no'] = $mobile_no;

            // if(!empty($by_dob)){
            //     $filter['by_dob'] = date('Y-m-d',strtotime($by_dob));
            //     $data['by_dob'] = date('d-m-Y',strtotime($by_dob));
            // }else{
            //     $data['by_dob'] = '';
            // }
            
            $count = $this->mun->getMunRegisteredInfoCount($filter);
            $returns = $this->paginationCompress("getMunEventInfo/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['studentInfo'] = $this->mun->getMunRegisteredInfo($filter);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : MUN';
            $this->loadViews("mun/mun", $this->global,$data, NULL);

        }
    }

    
    public function deleteEvent(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $eventInfo = array('is_deleted' => 1,'updated_by'=>$this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->mun->updateEventInfo($eventInfo, $row_id);
            if ($result == true) {
                echo (json_encode(array('status' => true)));
            } else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function viewEventParticipantInfo($row_id) {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            if($row_id == null) {
                redirect('getMunEventInfo');
            }
            
            $data['registerInfo'] = $this->mun->getRegistrationInfo($row_id);
            $data['eventReg'] = $this->mun->getEventRegistrationInfo($row_id);
            $data['participantInfo'] = $this->mun->getParticipantInfo($data['eventReg']->row_id);
            $data['inchargeInfo'] = $this->mun->getInchargeInfo($row_id);
           
            $data['active'] = '';
            $this->global['pageTitle'] = ''.TAB_TITLE.' : View Event Details';
            $this->loadViews("mun/viewEvent", $this->global, $data, null);
        }
    }

    
    function getInternalRegistration(){
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $filter = array();
            $name = $this->security->xss_clean($this->input->post('name'));
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $term = $this->security->xss_clean($this->input->post('term'));
            $stream = $this->security->xss_clean($this->input->post('stream'));
            $order_id = $this->security->xss_clean($this->input->post('order_id'));
            $mobile_no = $this->security->xss_clean($this->input->post('mobile_no'));
            $committee = $this->security->xss_clean($this->input->post('committee'));

            $data['name'] = $name;
            $data['student_id'] = $student_id;
            $data['term'] = $term;
            $data['stream'] = $stream;
            $data['order_id'] = $order_id;
            $data['mobile_no'] = $mobile_no;
            $data['committee'] = $committee;

            $filter['name'] = $name;
            $filter['student_id'] = $student_id;
            $filter['term'] = $term;
            $filter['stream'] = $stream;
            $filter['order_id'] = $order_id;
            $filter['mobile_no'] = $mobile_no;
            $filter['committee'] = $committee;

            // if(!empty($by_dob)){
            //     $filter['by_dob'] = date('Y-m-d',strtotime($by_dob));
            //     $data['by_dob'] = date('d-m-Y',strtotime($by_dob));
            // }else{
            //     $data['by_dob'] = '';
            // }
            
            $count = $this->mun->getInternalRegistrationCount($filter);
            $returns = $this->paginationCompress("getInternalRegistration/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['studentInfo'] = $this->mun->getInternalRegistrationInfo($filter);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : MUN';
            $this->loadViews("mun/internalRegistration", $this->global,$data, NULL);

        }
    }

    
    public function deleteInternalEvent(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $eventInfo = array('is_deleted' => 1);
            $result = $this->mun->updateInternalRegistrationEventInfo($eventInfo, $row_id);
            if ($result == true) {
                echo (json_encode(array('status' => true)));
            } else {echo (json_encode(array('status' => false)));}
        } 
    }
}
?>