<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class OnlineClass extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
        // $this->load->model('librery_model');
        $this->load->model('onlineClass_model');
        $this->load->model('subjects_model');
        $this->isLoggedIn();   
    }

    public function viewOnlineClass(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $filter = array();
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
            $section_name = $this->security->xss_clean($this->input->post('section_name'));
            $by_date = $this->security->xss_clean($this->input->post('by_date'));
            $start_time = $this->security->xss_clean($this->input->post('start_time'));
            $end_time = $this->security->xss_clean($this->input->post('end_time'));
            $subject_name = $this->security->xss_clean($this->input->post('subject_name'));
            $app_type = $this->security->xss_clean($this->input->post('app_type'));
            $description = $this->security->xss_clean($this->input->post('description'));
            $byDate = date('Y-m-d',strtotime($by_date));

            $data['section_name'] = $section_name;
            $data['term_name'] = $term_name;
            $data['stream_name'] = $stream_name;
            $data['by_date'] = $by_date;
            $data['start_time'] = $start_time;
            $data['end_time'] = $end_time;
            $data['subject_name'] = $subject_name;
            $data['app_type'] = $app_type;
            $data['description'] = $description;

            $filter['term_name']= $term_name;
            $filter['section_name']= $section_name;
            $filter['stream_name']= $stream_name;
            $filter['start_time']= $start_time;
            $filter['end_time'] = $end_time;
            $filter['by_date']= $byDate;
            $filter['subject_name']= $subject_name;
            $filter['app_type']= $app_type;
            $filter['description']= $description;

            if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
            }

            $this->load->library('pagination');
            $count = $this->onlineClass_model->getAllClassCount($filter);
            $returns = $this->paginationCompress("viewOnlineClass/", $count, 100);
            $data['classRecordsCount'] = $count;
            $data['classRecords'] = $this->onlineClass_model->getAllClassInfo($filter, $returns["page"], $returns["segment"]);
            $data['subjectInfo'] = $this->subjects_model->getAllSubjects();

            $this->global['pageTitle'] = 'SchholPhins-SJPUC : Online Class Details';
            $this->loadViews("onlineClass/class", $this->global, $data, null);
        }
    }

    public function addNewOnlineClass(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            
            $this->load->library('form_validation');
        
            $this->form_validation->set_rules('term_name','Term Name','trim|required');
            $this->form_validation->set_rules('class_date','Date ','required');
            $this->form_validation->set_rules('class_date','Date ','required');
            $this->form_validation->set_rules('app_type','Application Type ','required');
            $this->form_validation->set_rules('subject_name','Subject Name ','required');
            $this->form_validation->set_rules('link_url','Link','required');
        
            if($this->form_validation->run() == FALSE){
                $this->viewOnlineClass();
            } else {
                $term_name = $this->security->xss_clean($this->input->post('term_name'));
                $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
                $description = $this->security->xss_clean($this->input->post('description'));
                $section_name = $this->security->xss_clean($this->input->post('section_name'));
                $class_date = $this->security->xss_clean($this->input->post('class_date'));
                $app_type = $this->security->xss_clean($this->input->post('app_type'));
                $subject_name = $this->security->xss_clean($this->input->post('subject_name'));
                $link_url = $this->security->xss_clean($this->input->post('link_url'));
                
                $start_time_hh =$this->security->xss_clean($this->input->post('start_time_hh'));
                $start_time_mm =$this->security->xss_clean($this->input->post('start_time_mm'));
                $start_am_pm =$this->security->xss_clean($this->input->post('start_am_pm'));
                $end_time_hh =$this->security->xss_clean($this->input->post('end_time_hh'));
                $end_time_mm =$this->security->xss_clean($this->input->post('end_time_mm'));
                $end_am_pm =$this->security->xss_clean($this->input->post('end_am_pm'));
                
                $start_time = $start_time_hh.':'.$start_time_mm.' '.$start_am_pm;
                $end_time = $end_time_hh.':'.$end_time_mm.' '.$end_am_pm;
                $classDate = date('Y-m-d',strtotime($class_date));
        
                for($i=0;$i<count($stream_name);$i++){
                    $streamName = $stream_name[$i];
                    $classInfo= array(
                        'term_name' =>$term_name,
                        'section_name' =>$section_name,
                        'stream_name' => $streamName,
                        'subject_name' =>$subject_name,
                        'date' =>$classDate,
                        'from_time' =>$start_time,
                        'to_time' =>$end_time,
                        'class_link' =>$link_url,
                        'application_type' =>$app_type,
                        'description' => $description,
                        'created_by' => $this->staff_id,
                        'created_date_time' => date('Y-m-d h:i:s'),
            
                    );
                    $return_id = $this->onlineClass_model->addOnlineClass($classInfo);
                }
            
                if($return_id > 0){
                    $this->session->set_flashdata('success', 'Class Info Added Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Failed To Add Class Info');
                }
            }
            redirect('viewOnlineClass');
            
        }
    }

    
    public function editOnlineClass($row_id = null) {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if($row_id == null) {
                redirect('viewOnlineClass');
            }
            $data['classInfo'] = $this->onlineClass_model->getAllClassInfoById($row_id);
            $data['subjectInfo'] = $this->subjects_model->getAllSubjects();
            $this->global['pageTitle'] = 'SchoolPhins-SJPUC : Online Class Details';
            $this->loadViews("onlineClass/editOnlineClass", $this->global,$data, NULL);
        }
    }

    public function updateOnlineClass(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
            $this->form_validation->set_rules('term_name','Term Name','trim|required');
            $this->form_validation->set_rules('class_date','Date ','required');
            $this->form_validation->set_rules('class_date','Date ','required');
            $this->form_validation->set_rules('app_type','Application Type ','required');
            $this->form_validation->set_rules('subject_name','Subject Name ','required');
            $this->form_validation->set_rules('link_url','Link','required');
           
            if($this->form_validation->run() == FALSE){
                redirect('editOnlineClass/'.$row_id);  
            } else {
                $term_name = $this->security->xss_clean($this->input->post('term_name'));
                $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
                $description = $this->security->xss_clean($this->input->post('description'));
                $section_name = $this->security->xss_clean($this->input->post('section_name'));
                $class_date = $this->security->xss_clean($this->input->post('class_date'));
                $app_type = $this->security->xss_clean($this->input->post('app_type'));
                $subject_name = $this->security->xss_clean($this->input->post('subject_name'));
                $link_url = $this->security->xss_clean($this->input->post('link_url'));
                
                $start_time_hh =$this->security->xss_clean($this->input->post('start_time_hh'));
                $start_time_mm =$this->security->xss_clean($this->input->post('start_time_mm'));
                $start_am_pm =$this->security->xss_clean($this->input->post('start_am_pm'));
                $end_time_hh =$this->security->xss_clean($this->input->post('end_time_hh'));
                $end_time_mm =$this->security->xss_clean($this->input->post('end_time_mm'));
                $end_am_pm =$this->security->xss_clean($this->input->post('end_am_pm'));
                
                $start_time = $start_time_hh.':'.$start_time_mm.' '.$start_am_pm;
                $end_time = $end_time_hh.':'.$end_time_mm.' '.$end_am_pm;
                $classDate = date('Y-m-d',strtotime($class_date));
                    
                    $classInfo = array(
                        'term_name' =>$term_name,
                        'section_name' =>$section_name,
                        'stream_name' => $stream_name,
                        'subject_name' =>$subject_name,
                        'date' =>$classDate,
                        'from_time' =>$start_time,
                        'to_time' =>$end_time,
                        'class_link' =>$link_url,
                        'application_type' =>$app_type,
                        'description' => $description,
                        'updated_by'=>$this->staff_id,
                        'updated_date_time'=>date('Y-m-d H:i:s'));
                $return = $this->onlineClass_model->updateOnlineClassInfo($classInfo,$row_id);
                if($return > 0) {
                    $this->session->set_flashdata('success', 'Class Info Updated Successfully');
                } else {
                    $this->session->set_flashdata('error', 'Class Info Update failed');
                }
                redirect('editOnlineClass/'.$row_id);
            }
        }
    }

    //delete a class info
    public function deleteOnlineClass(){
        if ($this->isAdmin() == true) {
            echo (json_encode(array('status' => 'access')));
        } else {
            $row_id = $this->input->post('row_id');
            $classInfo = array('is_deleted' => 1,
            'updated_by'=>$this->staff_id,
            'updated_date_time'=>date('Y-m-d H:i:s'));
            $result = $this->onlineClass_model->updateOnlineClassInfo($classInfo,$row_id);
            if ($result > 0) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        }
    }  
}