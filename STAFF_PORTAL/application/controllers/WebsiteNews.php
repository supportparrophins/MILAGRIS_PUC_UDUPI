<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class WebsiteNews extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('websiteNews_model');
        $this->isLoggedIn();
    }
    public function newsListing(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {        
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
            $count = $this->websiteNews_model->newsCountListing($filter);
			$returns = $this->paginationCompress ( "newsListing/", $count, 50);
            $data['count_news'] = $count;
            $data['newsInfo'] = $this->websiteNews_model->newsListing($filter, $returns["page"], $returns["segment"]);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : News & Event Details';
            $this->loadViews("website_news/news", $this->global, $data , NULL);
        }
    }
    public function addNews(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Add News & Event';
            $this->loadViews("website_news/addNews", $this->global, $data, NULL);
        }
    }

    public function addNewToDb() {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $this->load->library('form_validation');
            $this->form_validation->set_rules('date','Date','trim|required');
            $this->form_validation->set_rules('subject', 'Title', 'required|max_length[100]');
            $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[140]');
            $this->form_validation->set_rules('location', 'Location', 'trim|required');
            
            if($this->form_validation->run() == FALSE){
                $this->addNews();
            } else {
                $files = $_FILES;
                $config=['upload_path' => './assets/sjpuch_site/images/news/',
                'allowed_types' => 'gif|jpg|png|jpeg','max_size' => '10240','overwrite' => TRUE,
                'file_ext_tolower' => TRUE];   
                $newsInfo = array();
                $this->load->library('upload', $config);
                $image = array();
                $ImageCount = count($_FILES['userfile']['name']);
                if($ImageCount < 2){
                    $this->session->set_flashdata('warning', 'Upload Minimum Two Images');
                }else{
                 
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
                                $newsInfo['image_path'] = 'sjpuch_site/images/news/' . $imageData['file_name'];
                            }else if($i != 5){
                                $newsInfo['image_sub'.$i] = 'sjpuch_site/images/news/' . $imageData['file_name'];
                            }
                        }
                    }
                $date = $this->input->post('date');
                $subject = $this->input->post('subject');
                $description = $this->input->post('description');
                $location = $this->input->post('location');
                $newsInfo['date'] = date('Y-m-d', strtotime($date));
                $newsInfo['subject'] = $subject;
                $newsInfo['description'] = $description;
                $newsInfo['location'] = $location;
                $newsInfo['created_by'] = $this->staff_id;
                $newsInfo['created_date_time'] = date('Y-m-d H:i:s');
                
                $result = $this->websiteNews_model->addNews($newsInfo);
                
                if($result > 0) {
                    $this->session->set_flashdata('success', 'News Added successfully');
                }else{
                    $this->session->set_flashdata('error', 'Failed To Add');
                }
            }
                redirect('newsListing');  
            }
        }
    }
    public function editNews($row_id = null)
    {
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            if ($row_id == null) {
                redirect('newsListing');
            }
            $data['newsInfo'] = $this->websiteNews_model->getNewsInfo($row_id);
           
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit News & Event';
            $this->loadViews("website_news/editNews", $this->global, $data, null);
        }
    }
    public function updateNews(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{
            $row_id = $this->input->post('row_id');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('date','Date','trim|required');
            $this->form_validation->set_rules('subject', 'Title', 'required|max_length[100]');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            $this->form_validation->set_rules('location', 'Location', 'trim|required');
         
            if($this->form_validation->run() == FALSE)
            {
                redirect('editNews/'.$row_id);  
            }else{
                $files = $_FILES;
                $config=['upload_path' => './assets/sjpuch_site/images/news/',
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
                                // log_message('debug','deede'.print_r($imageData,true));
                                if($i==0){
                                    $newsInfo['image_path'] = "sjpuch_site/images/news/".$imageData['file_name'];
                                }else if($i != 5){
                                    $newsInfo['image_sub'.$i] = "sjpuch_site/images/news/".$imageData['file_name'];
                                }
                            }
                        }
                    }
                    $date = $this->input->post('date');
                    $location = $this->input->post('location');
                    $description = $this->input->post('description');
                    $subject = $this->input->post('subject');

                    $newsInfo['date'] = date('Y-m-d', strtotime($date));
                    $newsInfo['subject'] = $subject;
                    $newsInfo['description'] = $description;
                    $newsInfo['location'] = $location;
                    $newsInfo['created_by'] = $this->staff_id;
                    $newsInfo['created_date_time'] = date('Y-m-d H:i:s');
                    
                    $result = $this->websiteNews_model->updateNews($newsInfo, $row_id);
                    
                    if($result == true)
                    {
                        $this->session->set_flashdata('success', 'News Info Modified successfully');
                    }else{
                        $this->session->set_flashdata('error', 'Failed to modify');
                    }
                redirect('editNews/'.$row_id);  
            }
        }
    }

    public function disableNews(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $newsAndEventInfo = array('status' => 1, 'updated_by' => $this->staff_id, 'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->websiteNews_model->disableNews($newsAndEventInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
    public function enableNews(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $newsAndEventInfo = array('status' => 0, 'updated_by' => $this->staff_id, 'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->websiteNews_model->disableNews($newsAndEventInfo, $row_id);
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
}