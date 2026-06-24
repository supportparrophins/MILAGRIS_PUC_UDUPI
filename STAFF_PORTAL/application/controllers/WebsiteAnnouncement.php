<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class WebsiteAnnouncement extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('announcement_model','announcement');
        $this->isLoggedIn();
    }

    function announcementListing(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{        
            $filter = array();
            $searchText = $this->security->xss_clean($this->input->post('searchTextCust'));
            $by_date = $this->security->xss_clean($this->input->post('by_date'));

            $data['searchTextCust'] = $searchText;
            $filter['searchTextCust'] = $searchText;
            if(!empty($by_date)){
                $data['by_date'] = date('d-m-Y', strtotime($by_date));
                $filter['by_date'] = date('Y-m-d', strtotime($by_date));
            }else{
                $data['by_date'] = '';
            }
            $this->load->library('pagination');
            $count = $this->announcement->announcementCountListing($filter);
            $data['count_announcement'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['announcementInfo'] = $this->announcement->announcementListing($filter);
            $returns = $this->paginationCompress("announcementListing/", $count, 100);

            $this->global['pageTitle'] = ''.TAB_TITLE.' : Website Announcement';
            $this->loadViews("websiteAnnouncement/announcements", $this->global, $data , NULL);
        }
    }
    function addNewMessage()
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Add Announcement';
            $this->loadViews("websiteAnnouncement/addNewAnnouncements", $this->global, $data, NULL);
        }
    }

    function addNewMessageToDb()
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $this->load->library('form_validation');
            $this->form_validation->set_rules('date','Date','trim|required');
            $this->form_validation->set_rules('message', 'Message', 'trim|required');
            
            if($this->form_validation->run() == FALSE){
                $this->addNewMessage();
            }else{
                $date = $this->input->post('date');
                $image_path = $this->input->post('link');
                $message = $this->input->post('message'); 
                // $image_path="";
                $uploadPath = 'assets/announcements/';
                $config=['upload_path' => WEBSITE_PATH.$uploadPath,
                'allowed_types' => 'jpg|png|jpeg|pdf|doc|ppt|pptx|docx','upload_max_filesize' => '10240','overwrite' => TRUE,
                'file_ext_tolower' => TRUE]; 
                $this->load->library('upload', $config);
                if($this->upload->do_upload())
                {
                    $data=$this->upload->data();
                    if($data['file_size'] > $config['upload_max_filesize']){
                        $this->session->set_flashdata('error', 'File Size is greater than 10MB'); 
                        redirect('addNewMessage');  
                    }else{ 
                        $image_path = WEBSITE_PATH.$uploadPath.$data['raw_name'].$data['file_ext'];
                        $post['image_path'] = $image_path;
                    }
        
                }
                
                    $messageInfo = array(
                        'date'=>date('Y-m-d',strtotime($date)), 
                        'message' => $message,
                        'link'=> $image_path, 
                        'created_by' => $this->staff_id, 
                        'created_date_time' => date('Y-m-d H:i:s'));
                   
                    $result = $this->announcement->addNewMessage($messageInfo);
                   
                    if($result > 0){
                        $this->session->set_flashdata('success', 'New Message Added Successfully');
                    }else{
                        $this->session->set_flashdata('error', 'New Message Add failed');
                    }
                    redirect('announcementListing');  
            }
        }
    }
    public function editMessage($row_id = null)
    {
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            if ($row_id == null) {
                redirect('announcementListing');
            }
            $data['messageInfo'] = $this->announcement->getAnnouncementMessage($row_id);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit Announcement Message';
            $this->loadViews("websiteAnnouncement/editAnnouncements", $this->global, $data, null);
        }
    }
    public function updateMessage(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
            $row_id = $this->input->post('row_id');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('date','Date','trim|required');
            $this->form_validation->set_rules('message','Message','trim|required');
         
            if($this->form_validation->run() == FALSE)
            {
                redirect('editMessage/'.$row_id);  
            }
            else
            {
                $date = $this->input->post('date');
                $image_path = $this->input->post('link');
                $message = $this->input->post('message');
                // $image_path="";
                $uploadPath = 'assets/announcements/';
                $config=['upload_path' => WEBSITE_PATH.$uploadPath,
                'allowed_types' => 'jpg|png|jpeg|pdf|doc|ppt|pptx|docx','upload_max_filesize' => '10240','overwrite' => TRUE,
                'file_ext_tolower' => TRUE]; 
                $this->load->library('upload', $config);
                if($this->upload->do_upload())
                {
                    $data=$this->upload->data();
                    if($data['file_size'] > $config['upload_max_filesize']){
                        $this->session->set_flashdata('error', 'File Size is greater than 10MB'); 
                        redirect('editMessage/'.$row_id);  
                    }else{ 
                        $image_path = WEBSITE_PATH.$uploadPath.$data['raw_name'].$data['file_ext'];
                        $post['image_path'] = $image_path;
                    }
        
                }

                    $MessageInfo = array(
                        'date'=>date('Y-m-d', strtotime($date)), 
                        'link' => $image_path,
                        'message'=>$message, 
                        'updated_by' => $this->staff_id, 
                        'updated_date_time' => date('Y-m-d H:i:s'));
                    $result = $this->announcement->updateMessage($MessageInfo, $row_id);
                   
                if($result > 0){
                    $this->session->set_flashdata('success', 'Message Modified successfully');
                }else{
                    $this->session->set_flashdata('error', 'Message Modified failed');
                }
                redirect('editMessage/'.$row_id);  
            }
        }
    }
    public function disableAnnouncement(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $AnnouncementInfo = array('status' => 1, 'updated_by' => $this->staff_id, 'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->announcement->disableAnnouncement($AnnouncementInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
    public function enableAnnouncement(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $AnnouncementInfo = array('status' => 0, 'updated_by' => $this->staff_id, 'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->announcement->disableAnnouncement($AnnouncementInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
}