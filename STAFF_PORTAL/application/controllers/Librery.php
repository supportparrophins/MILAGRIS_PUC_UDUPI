<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Librery extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
        $this->load->model('librery_model');
        //$this->load->model('application_model');
        $this->isLoggedIn();   
    }

public function viewStudyMaterials(){
    if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
        $this->loadThis();
    } else { 
        $filter = array();
        $searchTextCust = $this->security->xss_clean($this->input->post('searchTextCust'));
        $term_name = $this->security->xss_clean($this->input->post('term_name'));
        $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
        $type = $this->security->xss_clean($this->input->post('type'));
        $doc_name = $this->security->xss_clean($this->input->post('doc_name'));
        $section_name = $this->security->xss_clean($this->input->post('section_name'));

        $data['searchTextCust'] = $searchTextCust;
        $data['section_name'] = $section_name;
        $data['term_name'] = $term_name;
        $data['doc_name'] = $doc_name;
        $data['stream_name'] = $stream_name;
        //$data['by_date'] = $by_date;
        $data['type'] = $type;

        $filter['term_name']= $term_name;
        $filter['searchText'] = $searchTextCust;
        $filter['section_name']= $section_name;
        $filter['stream_name']= $stream_name;
        $filter['doc_name']= $doc_name;
        
        $filter['type']= $type;
        //$filter['by_intime']= $by_intime;

        if($this->role == ROLE_TEACHING_STAFF){
            $filter['staff_id'] = $this->staff_id;
        }

        $this->load->library('pagination');
        $count = $this->librery_model->getStudyMaterialsCount($filter);
        $returns = $this->paginationCompress("viewLatecomerInfo/", $count, 100);
        $data['studyRecordsCount'] = $count;
        $data['studyRecords'] = $this->librery_model->getStudyMaterialsInfo($filter, $returns["page"], $returns["segment"]);

        $this->global['pageTitle'] = 'SchholPhins-SJPUC : Latecomer Details';
        $this->loadViews("liberery/viewStudyMaterials", $this->global, $data, null);
    }
}

public function addNewStudyMaterials(){
    if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
        $this->loadThis();
    } else { 
        $this->load->library('form_validation');
       
        $this->form_validation->set_rules('term_name','Term Name','trim|required');
        // $this->form_validation->set_rules('stream_name','Stream Type','trim|required');
        $this->form_validation->set_rules('doc_type','Doc Type ','required');
       
        if($this->form_validation->run() == FALSE){
            $this->viewStudyMaterials();
        } else {
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
            $doc_type = $this->security->xss_clean($this->input->post('doc_type'));
            $description = $this->security->xss_clean($this->input->post('description'));
            $section_name = $this->security->xss_clean($this->input->post('section_name'));
            $config=['upload_path' => './upload/study_materials/',
        'allowed_types' => 'pdf|doc|docx|xlsx|csv|xls|ppt|pptx','max_size' => '100240','overwrite' => TRUE,
        ];//'file_name' => $customer_id

        // log_message('debug','value '.print_r($stream_name,true));
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('doc_path')) {
            $error = array('error' => $this->upload->display_errors());
        } else { 
            $data = array('upload_data' => $this->upload->data());
        }
        if (!empty($data['upload_data']['file_name'])) {
            $upload_file = $data['upload_data']['file_name'];
        } else {
            // $upload_file = 0;
            $this->session->set_flashdata('error', 'File Type Not Allowed and Maximum size of 10MB');
            redirect('librery/viewStudyMaterials');
        }
            $importFileName = '/upload/study_materials/'. $upload_file;
            for($i=0;$i<count($stream_name);$i++){
                $streamName = $stream_name[$i];
                $metriInfo= array(
                    'term_name' =>$term_name,
                    'section_name' =>$section_name,
                    'stream_name' => $streamName,
                    'document_name_url' =>$importFileName,
                    'type'=>$doc_type,
                    'description' => $description,
                    'name' => $upload_file,
                    'created_by' => $this->staff_id,
                    'created_date_time' => date('Y-m-d h:i:s'),
        
                );
                // log_message('debug','test'.print_r($metriInfo,true));
                $return_id = $this->librery_model->addNewStudyMaterials($metriInfo);
            }
        
            if($return_id > 0){
                $this->session->set_flashdata('success', 'New Study Material Added Successfully');
            }else{
                $this->session->set_flashdata('error', 'Add New Study Material Failed');
            }
        }
        redirect('librery/viewStudyMaterials');
        
    }
}

 //delete a class completed info
 public function deleteStudyMaterials(){
    if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
        echo (json_encode(array('status' => 'access')));
    } else {
        $row_id = $this->input->post('row_id');
        $studyInfo = array('is_deleted' => 1);
        $result = $this->librery_model->updateStudyMaterials($row_id, $studyInfo);
        if ($result > 0) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
    }
 }  
}