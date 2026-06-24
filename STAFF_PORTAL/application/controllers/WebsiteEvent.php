<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class WebsiteEvent extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('WebsiteEvent_model');
        $this->isLoggedIn();
    }
    function eventListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {        
            $filter = array();
            $by_date = $this->security->xss_clean($this->input->post('by_date'));
            
            if(!empty($by_date)){
                $data['by_date'] = date('d-m-Y', strtotime($by_date));
                $filter['by_date'] = date('Y-m-d', strtotime($by_date));
            }else{
                $data['by_date'] = '';
            }
            $this->load->library('pagination');
            $count = $this->WebsiteEvent_model->eventCountListing($filter);
			$returns = $this->paginationCompress ( "eventListing/", $count, 100);
            $data['count_event'] = $count;
            $data['eventInfo'] = $this->WebsiteEvent_model->eventListing($filter, $returns["page"], $returns["segment"]);
            $this->global['pageTitle'] = 'SchholPhins-SJPUC : Event Details';
            $this->loadViews("website_event/event", $this->global, $data , NULL);
        }
    }
    function addNewEvent()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->global['pageTitle'] = 'SchholPhins : Add New Event';
            $this->loadViews("website_event/addNewEvent", $this->global, $data, NULL);
        }
    }

    function addNewEventToDb()
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('date','Date','trim|required');
            $this->form_validation->set_rules('hour', 'Hour', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            
            if($this->form_validation->run() == FALSE){
                $this->addNewEvent();
            }
            else
            {
                $date = $this->input->post('date');
                $hour = $this->input->post('hour').':'.$this->input->post('minutes').$this->input->post('select3');
                $location = $this->input->post('location');
                $description = $this->input->post('description');
                
                    $eventInfo = array('date'=>date('Y-m-d',strtotime($date)), 'time' => date('H:m:s A', strtotime($hour)), 'location' => $location, 'description'=>$description, 'created_by' => $this->vendorId, 'created_date_time' => date('Y-m-d H:i:s'));
                    $result = $this->WebsiteEvent_model->addNewEvent($eventInfo);
                   
                    if($result > 0)
                    {
                        $this->session->set_flashdata('success', 'New Event Added Successfully');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Failed To Insert Event');
                    }
                    redirect('eventListing');  
            }
        }
    }
    public function editEvent($row_id = null)
    {
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            if ($row_id == null) {
                redirect('eventListing');
            }
            $data['eventInfo'] = $this->WebsiteEvent_model->getEventInfo($row_id);
           
            $this->global['pageTitle'] = 'SchoolPhins-SJPUC : Edit Announcement Message';
            $this->loadViews("website_event/editEvent", $this->global, $data, null);
        }
    }
    public function updateEvent(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $row_id = $this->input->post('row_id');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('date','Date','trim|required');
            // $this->form_validation->set_rules('hour','Hour','trim|required');
            $this->form_validation->set_rules('description','Description','trim|required');
         
            if($this->form_validation->run() == FALSE)
            {
                redirect('editEvent/'.$row_id);  
            }
            else
            {
                $date = $this->input->post('date');
                $hour = $this->input->post('hour').':'.$this->input->post('minutes').$this->input->post('select3');
                $location = $this->input->post('location');
                $description = $this->input->post('description');
                $eventInfo = array('date'=>date('Y-m-d', strtotime($date)), 'time'=> date('H:m:s A', strtotime($hour)), 'location'=>$location, 'description'=>$description, 'updated_by' => $this->vendorId, 'updated_date_time' => date('Y-m-d H:i:s'));
                $result = $this->WebsiteEvent_model->updateEvent($eventInfo, $row_id);
                   
                if($result > 0){
                    $this->session->set_flashdata('success', 'Event Modified successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Event Modification failed');
                }
                redirect('editEvent/'.$row_id);  
            }
        }
    }

    public function disableEvent(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $EventInfo = array('status' => 1, 'updated_by' => $this->vendorId, 'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->WebsiteEvent_model->deleteEvent($EventInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
    public function enableEvent(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $EventInfo = array('status' => 0, 'updated_by' => $this->vendorId, 'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->WebsiteEvent_model->deleteEvent($EventInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
}