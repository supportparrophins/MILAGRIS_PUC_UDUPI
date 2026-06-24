<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseController.php';

class WebsiteTestimonials extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('websiteTestimonials_model');
        $this->isLoggedIn();
    }
    function feedbackListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {        
            $filter = array();
            $searchText = $this->security->xss_clean($this->input->post('searchTextCust'));
            $data['searchTextCust'] = $searchText;
            $filter['searchTextCust'] = $searchText;

            $this->load->library('pagination');
            $count = $this->websiteTestimonials_model->feedbackCountListing($filter);
			$returns = $this->paginationCompress ( "feedbackListing/", $count, 50);
            $data['count_testimonials'] = $count;
            $data['feedbackInfo'] = $this->websiteTestimonials_model->feedbackListing($filter, $returns["page"], $returns["segment"]);
            $this->global['pageTitle'] = 'SchholPhins-SJPUC : Alumni Testimonials';
            $this->loadViews("website_testimonials/testimonial", $this->global, $data , NULL);
        }
    }

    public function addTestimonials()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->global['pageTitle'] = 'SchholPhins : Add Testimonials';
            $this->loadViews("website_testimonials/addTestimonials", $this->global, $data, NULL);
        }
    }
    public function addTestimonialsToDb()
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name','Name','trim|required');
            $this->form_validation->set_rules('message', 'Message', 'required');
            
            if($this->form_validation->run() == FALSE){
                $this->addTestimonials();
            }
            else
            {
                $image_path="";
                $config=['upload_path' => './upload/testimonial/',
                'allowed_types' => 'gif|jpg|png','overwrite' => TRUE,];
                $this->load->library('upload', $config);
                if($this->upload->do_upload())
                {
                    $post=$this->input->post();
                    $data=$this->upload->data();
                    $image_path=base_url("upload/testimonial/".$data['raw_name'].$data['file_ext']);
                    $post['image_path']=$image_path;
                }
                $name = $this->input->post('name');
                $message = $this->input->post('message');
                
                    $feedbackInfo = array('image_url'=>$image_path, 'name' => $name,'message'=>$message, 
                    'created_by' => $this->vendorId, 'created_date_time' => date('Y-m-d H:i:s'));
                   
                    $result = $this->websiteTestimonials_model->addTestimonials($feedbackInfo);
                   
                    if($result > 0)
                    {
                        $this->session->set_flashdata('success', 'Testimonials Added successfully');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Failed To Add');
                    }
                    redirect('addTestimonials');  
            }
        }
    }

    public function editTestimonials($row_id = null)
    {
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            if ($row_id == null) {
                redirect('feedbackListing');
            }
            $data['feedbackInfo'] = $this->websiteTestimonials_model->getFeedbackInfo($row_id);
           
            $this->global['pageTitle'] = 'SchoolPhins-SJPUC : Edit Testimonials';
            $this->loadViews("website_testimonials/editTestimonials", $this->global, $data, null);
        }
    }

    public function updateTestimonials(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $row_id = $this->input->post('row_id');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name','Name','trim|required');
            $this->form_validation->set_rules('message', 'Message', 'required');
         
            if($this->form_validation->run() == FALSE)
            {
                redirect('editTestimonials/'.$row_id);  
            }
            else
            {
                $image_path="";
                $config=['upload_path' => './upload/testimonial/',
                'allowed_types' => 'gif|jpg|png','overwrite' => TRUE,];
                $this->load->library('upload', $config);
                if($this->upload->do_upload())
                {
                    $post=$this->input->post();
                    $data=$this->upload->data();
                    $image_path=base_url("upload/testimonial/".$data['raw_name'].$data['file_ext']);
                    $post['image_path']=$image_path;
                }
               
                $name = $this->input->post('name');
                $message = $this->input->post('message');
                    if(empty($image_path)){
                        $feedbackInfo = array('name' => $name,'message'=>$message,
                        'updated_by' => $this->vendorId, 'updated_date_time' => date('Y-m-d H:i:s'));
                    }else{
                        $feedbackInfo = array('image_path'=>$image_path, 'name' => $name,'message'=>$message,
                        'updated_by' => $this->vendorId, 'updated_date_time' => date('Y-m-d H:i:s'));
                    }
                  
                    $result = $this->websiteTestimonials_model->updateTestimonials($feedbackInfo, $row_id);
                   
                    if($result == true)
                    {
                        $this->session->set_flashdata('success', 'Testimonials Modified successfully');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Failed to modify');
                    }
                    redirect('editTestimonials/'.$row_id);  
            }
        }
    }

    public function disableTestimonial(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $testimonialInfo = array('status' => 1, 'updated_by' => $this->vendorId, 'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->websiteTestimonials_model->deleteTestimonial($testimonialInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
    public function enableTestimonial(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $testimonialInfo = array('status' => 0, 'updated_by' => $this->vendorId, 'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->websiteTestimonials_model->deleteTestimonial($testimonialInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
}