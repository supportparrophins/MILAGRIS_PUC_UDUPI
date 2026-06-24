<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Gallery extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('gallery_model');
        $this->isLoggedIn();
    }

    public function viewGalleryInfo()
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

            $event_name = $this->security->xss_clean($this->input->post('event_name'));
            $data['searchTextCust'] = $searchText;
            $filter['searchTextCust'] = $searchText;
            if(!empty($event_name)){
                $data['event_name'] = $event_name;
                $filter['event_name'] = $event_name;
            }else{
                $data['event_name'] = '';
            }
        

            $this->load->library('pagination');
            $count = $this->gallery_model->galleryCountListing($filter);
			$returns = $this->paginationCompress ( "viewGalleryInfo/", $count, 100);
            $data['count_gallery'] = $count;
            $data['newsInfo'] = $this->gallery_model->galleryListing($filter, $returns["page"], $returns["segment"]);
            $this->global['pageTitle'] = ''.TAB_TITLE.'  : Gallery Details';
            $this->loadViews("gallery/galleryListing", $this->global, $data , NULL);
        }
    }

    
    public function addNewPhotoGallery()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('reason', 'Description', 'trim|required');
        $this->form_validation->set_rules('event_name', 'Event Name', 'trim|required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Please fill all the mandatory fields');
            redirect('viewGalleryInfo');
        } else {
            $description = $this->input->post('reason');
            $date = $this->input->post('date');
            $event_name = $this->input->post('event_name');
            $event_year = EVENT_YEAR;
            
            // Prepare data to insert into the first table
            $photoGalleryInfo = array(
                'event_name' => $event_name,
                'date' => date('Y-m-d',strtotime($date)),
                'description' => $description,
                'event_year' => $event_year,
                'is_deleted' => 0,
                'created_by' => $this->staff_id,
                'created_date_time' => date('Y-m-d H:i:s')
            );
            
            // Add photo gallery info to the first table and get the inserted ID
            $photoGalleryId = $this->gallery_model->addNewPhotoGalleryInfo($photoGalleryInfo);

            
            if ($photoGalleryId > 0) {

                $photoObjectId = $photoGalleryId;

                $uploadPath = '/upload/photo_gallery/';
                $files = $_FILES;
        
                // Count uploaded images
                $imageCount = count($_FILES['userfile']['tmp_name']);

                // if ($imageCount < 2) {
                //     $this->session->set_flashdata('warning', 'Upload Minimum Two Images');
                //     redirect('viewGalleryInfo');
                // } else {
                    // Process each uploaded image
                    for ($i = 0; $i < $imageCount; $i++) {
                        $_FILES['file']['name']     = $_FILES['userfile']['name'][$i];
                        $_FILES['file']['type']     = $_FILES['userfile']['type'][$i];
                        $_FILES['file']['tmp_name'] = $_FILES['userfile']['tmp_name'][$i];
                        $_FILES['file']['error']    = $_FILES['userfile']['error'][$i];
                        $_FILES['file']['size']     = $_FILES['userfile']['size'][$i];
        
                        // Upload file to server
                        $config = array(
                            'upload_path'   => './upload/photo_gallery/',
                            'allowed_types' => '*',
                            // 'max_size'      => 10240, // 10 MB
                            'overwrite'     => TRUE,
                            'file_ext_tolower' => TRUE
                        );
                        $this->load->library('upload', $config);
        
                        if ($this->upload->do_upload('file')) {

                            $imageData = $this->upload->data();
        
                            // Store image path along with photo_id in the second table
                            $photoData = array(
                                'photo_id' => $photoObjectId,
                                'is_deleted' => 0,
                                'image_path' => $uploadPath . $imageData['file_name']
                            );
                            
                            // Add photo data to the second table
                            $this->gallery_model->addPhoto($photoData);
                        } else {
                            $this->session->set_flashdata('error', 'Failed to upload one or more images: ' . $this->upload->display_errors());
                            redirect('viewGalleryInfo');
                        }
                    }
        
                    $this->session->set_flashdata('success', 'New Photo Gallery Added Successfully');
                    redirect('viewGalleryInfo');
                // }
            } else {
                $this->session->set_flashdata('error', 'Failed to add new Photo Gallery');
                redirect('viewGalleryInfo');
            }
        }
    }

    
    function editPhotoGalleryDetails($row_id = null) {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {
           // $staff_id = $this->input->get('row_id');
           if ($row_id == null) {
            redirect('viewGalleryInfo');
            }
          
            $data['photoGalleryInfo'] = $this->gallery_model->getPhotoGalleryInfoById($row_id);
            $data['photoGalleryList'] = $this->gallery_model->getPhotoGalleryListById($row_id);
          
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit Photo Gallery';

            $this->loadViews("gallery/editPhotoGalleryInfo.php", $this->global, $data, NULL);

        }

    }

    public function updatePhotoGalleryDetails() {
        $row_id = $this->input->post('photo_row_id');
    
        $description = $this->security->xss_clean($this->input->post('description'));
        $event_name = $this->security->xss_clean($this->input->post('event_name'));
        $date = $this->security->xss_clean($this->input->post('date'));
        $event_year = EVENT_YEAR;
    
        $uploadPath = '/upload/photo_gallery/';
        $files = $_FILES;

        // Count uploaded images
        $imageCount = count($_FILES['userfile']['tmp_name']);
        // if ($imageCount < 2) {
        //     $this->session->set_flashdata('warning', 'Upload Minimum Two Images');
        //     redirect('photoGalleryList');
        // } else {
            // Process each uploaded image
            for ($i = 0; $i < $imageCount; $i++) {
                $_FILES['file']['name']     = $_FILES['userfile']['name'][$i];
                $_FILES['file']['type']     = $_FILES['userfile']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['userfile']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['userfile']['error'][$i];
                $_FILES['file']['size']     = $_FILES['userfile']['size'][$i];

                // Upload file to server
                $config = array(
                    'upload_path'   => './upload/photo_gallery/',
                    'allowed_types' => '*',
                    // 'max_size'      => 10240, // 10 MB
                    'overwrite'     => TRUE,
                    'file_ext_tolower' => TRUE
                );
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $imageData = $this->upload->data();

                    // Store image path along with photo_id in the second table
                    $photoData = array(
                        'photo_id' => $row_id,
                        'is_deleted' => 0,
                        'image_path' => $uploadPath . $imageData['file_name']
                    );
                    
                    // Add photo data to the second table
                    $this->gallery_model->addPhoto($photoData);
                } else {
                    // $this->session->set_flashdata('error', 'Failed to upload one or more images: ' . $this->upload->display_errors());
                    // redirect('photoGalleryList');
                }
            }

            // $this->session->set_flashdata('success', 'New Photo Gallery Added Successfully');
            // redirect('photoGalleryList');
        // }
        $staffInfo = array(
            'event_name' => $event_name,
            'date' => date('Y-m-d',strtotime($date)),
            'event_year' => $event_year,
            'description' => $description,
            'updated_by' => $this->staff_id,
            'updated_date_time' => date('Y-m-d H:i:s')
        );
     
    
        $result = $this->gallery_model->updatePhotoGallery($row_id, $staffInfo);
    
        if ($result == true) {
            $this->session->set_flashdata('success', 'Photo Gallery Updated Successfully');
        } else {
            $this->session->set_flashdata('error', 'Photo Gallery Modified failed');
        }
    
        redirect('viewGalleryInfo');
    }

    public function deleteImage() {
        // if($this->isAdmin() == TRUE){
        //     $this->loadThis();
        // } else {   
            if($this->input->server("REQUEST_METHOD") == "POST"){
                $rowID = trim($this->input->post('image_id'));
                $stdNotable = array('is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
                );
                echo $this->gallery_model->updatePhotoGalleryList($rowID,$stdNotable);
            }else echo 0;
        // } 
    } 

    function viewPhotoGalleryDetails($row_id = null) {
        if($this->isAdmin() == TRUE){

            $this->loadThis();

        } else {
           // $staff_id = $this->input->get('row_id');
           if ($row_id == null) {
            redirect('viewGalleryInfo');
            }
          
            $data['photoGalleryList'] = $this->gallery_model->getPhotoGalleryListById($row_id);
            // log_message('debug','photoGalleryList '.print_r($data['photoGalleryList'],true));
          
            $this->global['pageTitle'] = ''.TAB_TITLE.' : View Photo Gallery';

            $this->loadViews("gallery/viewPhotoGalleryInfo.php", $this->global, $data, NULL);

        }

    }

    public function deletePhotoGallery() {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            if($this->input->server("REQUEST_METHOD") == "POST"){
                $rowID = trim($this->input->post('row_id'));
                $stdNotable = array('is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
                );
                echo $this->gallery_model->updatePhotoGallery($rowID,$stdNotable);
            }else echo 0;
        } 
    } 


}
?>