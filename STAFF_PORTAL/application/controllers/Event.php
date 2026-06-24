<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';
require_once 'vendor/autoload.php';
class Event extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('event_model');
        $this->isLoggedIn();
    }
    public function eventListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {        
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

            $location = $this->security->xss_clean($this->input->post('location'));
            $data['searchTextCust'] = $searchText;
            $filter['searchTextCust'] = $searchText;
            if(!empty($location)){
                $data['location'] = $location;
                $filter['location'] = $location;
            }else{
                $data['location'] = '';
            }
        

            $this->load->library('pagination');
            $count = $this->event_model->newsCountListing($filter);
			$returns = $this->paginationCompress ( "eventListing/", $count, 100);
            $data['count_news'] = $count;
            $data['newsInfo'] = $this->event_model->newsListing($filter, $returns["page"], $returns["segment"]);
            $this->global['pageTitle'] = ''.TAB_TITLE.'  : News & Event Details';
            $this->loadViews("event/event", $this->global, $data , NULL);
        }
    }
    public function addEvents()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Add News & Event';
            $this->loadViews("event/addEvents", $this->global, NULL, NULL);
        }
    }

    public function addEventToDb()
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('date','Date','trim|required');
            // $this->form_validation->set_rules('subject', 'Title', 'required|max_length[100]');
            // $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[140]');
            $this->form_validation->set_rules('location', 'Location', 'trim|required');
            
            if($this->form_validation->run() == FALSE){
                $this->addEvents();
            }
            else
            {
                $uploadPath = 'sjihs_site/events/';
                $files = $_FILES;
                $config=['upload_path' => './assets/sjihs_site/events/',
                'allowed_types' => 'gif|jpg|png|jpeg','max_size' => '10240','overwrite' => TRUE,
                'file_ext_tolower' => TRUE];   
                $newsInfo = array();
                $this->load->library('upload', $config);
                $image = array();
                $ImageCount = count($_FILES['userfile']['name']);
                // if($ImageCount < 2){
                //     $this->session->set_flashdata('warning', 'Upload Minimum Two Images');
                //     redirect('addNews');
                // }else{
                    for($i = 0; $i < $ImageCount; $i++){
                        $_FILES['file']['name']       = $_FILES['userfile']['name'][$i];
                        $_FILES['file']['type']       = $_FILES['userfile']['type'][$i];
                        $_FILES['file']['tmp_name']   = $_FILES['userfile']['tmp_name'][$i];
                        $_FILES['file']['error']      = $_FILES['userfile']['error'][$i];
                        $_FILES['file']['size']       = $_FILES['userfile']['size'][$i];
                        // Upload file to server
                        if($this->upload->do_upload('file')){
                            $imageData = $this->upload->data();

                            if($i==0){
                                $newsInfo['image_path'] = $uploadPath.$imageData['file_name'];
                            }else if($i != 5){
                                $newsInfo['image_sub'.$i] = $uploadPath.$imageData['file_name'];
                            }
                        }
                    }

                    
                    $date = $this->input->post('date');
                    $subject = $this->input->post('subject');
                    $description = htmlspecialchars($this->input->post('editor1'),ENT_QUOTES);
                    $location = $this->input->post('location');
                    $newsInfo['date'] = date('Y-m-d', strtotime($date));
                    $newsInfo['subject'] = $subject;
                    $newsInfo['description'] = $description;
                    $newsInfo['location'] = $location;
                    $newsInfo['created_by'] = $this->staff_id;
                    $newsInfo['created_date_time'] = date('Y-m-d H:i:s');
                    
                    $result = $this->event_model->addNews($newsInfo);
                
                    if($result > 0)
                    {
                        $this->session->set_flashdata('success', 'News Added successfully');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Failed To Add');
                    }
                // }
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
            $data['newsInfo'] = $this->event_model->getNewsInfo($row_id);
           
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit News & Event';
            $this->loadViews("event/editEvent", $this->global, $data, null);
        }
    }
    public function viewEvent($row_id = null)
    {
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            if ($row_id == null) {
                redirect('eventListing');
            }
            $data['newsInfo'] = $this->event_model->getNewsInfo($row_id);
           
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit News & Event';
            $this->loadViews("event/viewEvent", $this->global, $data, null);
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
            $this->form_validation->set_rules('subject', 'Title', 'required|max_length[100]');
            // $this->form_validation->set_rules('description', 'Description', 'trim|required');
            $this->form_validation->set_rules('location', 'Location', 'trim|required');
         
            if($this->form_validation->run() == FALSE)
            {
                redirect('editEvent/'.$row_id);  
            }
            else
            {
                $uploadPath='sjihs_site/events/';
                $files = $_FILES;
                $config=['upload_path' => './assets/sjihs_site/events/',
                'allowed_types' => 'gif|jpg|png|jpeg','max_size' => '10240','overwrite' => TRUE,
                'file_ext_tolower' => TRUE];   
                $newsInfo = array();
                $ImgCount = count($_FILES['userfile']['name']);
                    if(!empty($_FILES['userfile']['name'])){
                        for($i = 0; $i < $ImgCount; $i++){
                            $_FILES['file']['name']       = $files['userfile']['name'][$i];
                            $_FILES['file']['type']       = $files['userfile']['type'][$i];
                            $_FILES['file']['tmp_name']   = $files['userfile']['tmp_name'][$i];
                            $_FILES['file']['error']      = $files['userfile']['error'][$i];
                            $_FILES['file']['size']       = $files['userfile']['size'][$i];
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if($this->upload->do_upload('file')){
                                $imageData = $this->upload->data();
                                
                                if($i==0){
                                    $newsInfo['image_path'] = $uploadPath.$imageData['file_name'];
                                }else if($i != 5){
                                    $newsInfo['image_sub'.$i] = $uploadPath.$imageData['file_name'];
                                }
                            }
                        }
                    }
                    $date = $this->input->post('date');
                    $location = $this->input->post('location');
                    $description = htmlspecialchars($this->input->post('editor2'),ENT_QUOTES);
                    $subject = $this->input->post('subject');

                    $newsInfo['date'] = date('Y-m-d', strtotime($date));
                    $newsInfo['subject'] = $subject;
                    $newsInfo['description'] = $description;
                    $newsInfo['location'] = $location;
                    $newsInfo['updated_by'] = $this->staff_id;
                    $newsInfo['updated_date_time'] = date('Y-m-d H:i:s');
                    
                    $result = $this->event_model->updateNews($newsInfo, $row_id);
                    
                    if($result == true)
                    {
                        $this->session->set_flashdata('success', 'News Info Modified successfully');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Failed to modify');
                    }
                redirect('eventListing');  
            }
        }
    }

    public function disableNews(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $newsAndEventInfo = array('status' => 1, 'updated_by' => $this->staff_id, 'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->event_model->disableNews($newsAndEventInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
    public function enableNews(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $newsAndEventInfo = array('status' => 0, 'updated_by' => $this->staff_id, 'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->event_model->disableNews($newsAndEventInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function compressImage($source, $destination, $quality) {

        $info = getimagesize($source);
      
        if ($info['mime'] == 'image/jpeg'){
            $image = imagecreatefromjpeg($source);
        } elseif ($info['mime'] == 'image/gif') {
            $image = imagecreatefromgif($source);
        }elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($source);
        }
        imagejpeg($image, $destination, $quality);
      
    }

    public function deleteEventregister(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $newsAndEventInfo = array('is_deleted' => 1, 'updated_by' => $this->staff_id, 'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->event_model->disableNews($newsAndEventInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
    public function getEventPDFPrint($row_id = null){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            error_reporting(0);
            $filter = array();
             $this->global['pageTitle'] = ''.TAB_TITLE.' : Event';
            $data['EventInfo'] = $this->event_model->getNewsInfo($row_id);
            define('_MPDF_TTFONTPATH', __DIR__ . '/fonts');
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','format' => 'A4']);
            $mpdf->AddPage('P','','','','',10,10,10,8,8,8);
            $mpdf->SetTitle('Event');
            $html = $this->load->view('event/eventPDF',$data,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('Event.pdf', 'I');
        }
    }
}