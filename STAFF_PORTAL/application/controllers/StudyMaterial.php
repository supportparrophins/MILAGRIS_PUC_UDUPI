<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerFaculty.php';

class StudyMaterial extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('studyMaterial_model','study');
        $this->load->model('subjects_model','subject');
        $this->isLoggedIn();   
    }
    public function viewStudyMaterials(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else { 
            $filter = array();
            $searchTextCust = $this->security->xss_clean($this->input->post('searchTextCust'));
            $by_term = $this->security->xss_clean($this->input->post('by_term'));
            $by_stream_name = $this->security->xss_clean($this->input->post('by_stream_name'));
            $type = $this->security->xss_clean($this->input->post('type'));
            $doc_name = $this->security->xss_clean($this->input->post('doc_name'));
            $section_name = $this->security->xss_clean($this->input->post('section_name'));
            $by_subject = $this->security->xss_clean($this->input->post('by_subject'));
            $by_date = $this->security->xss_clean($this->input->post('by_date'));
    
    
            $data['searchTextCust'] = $searchTextCust;
            $data['section_name'] = $section_name;
            $data['by_term'] = $by_term;
            $data['doc_name'] = $doc_name;
            $data['by_stream_name'] = $by_stream_name;
            $data['by_subject'] = $by_subject;
            $data['type'] = $type;
    
            $filter['by_term']= $by_term;
            $filter['searchText'] = $searchTextCust;
            $filter['section_name']= $section_name;
            $filter['by_stream_name']= $by_stream_name;
            $filter['doc_name']= $doc_name;
            $filter['by_subject'] = $by_subject;

            if(!empty($by_date)){
                $filter['by_date'] = date('Y-m-d',strtotime($by_date));
                $data['by_date'] = date('d-m-Y',strtotime($by_date));;
            }else{
                $filter['by_date'] = '';
                $data['by_date'] = '';
            }
            
            $filter['type']= $type;
    
            if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
            }
    
            $this->load->library('pagination');
            $count = $this->study->getStudyMaterialsCount($filter);
            $returns = $this->paginationCompress("viewLatecomerInfo/", $count, 100);
            $data['studyRecordsCount'] = $count;
            $data['studyRecords'] = $this->study->getStudyMaterialsInfo($filter, $returns["page"], $returns["segment"]);
            $data['subjectInfo'] = $this->subject->getStaffSubjectName($filter);
            $data['streamInfo'] = $this->study->getStreamInfo();
            $data['accessInfo'] = $this->getCurrentAccess();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Latecomer Details';
            $this->loadViews("studyMaterial/viewStudyMaterials", $this->global, $data, null);
        }
    }
    
   public function addNewStudyMaterials(){
        if ($this->isAdmin() == true) {
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
                $subject_name = $this->security->xss_clean($this->input->post('subject_name'));
                $uploadPath = './upload/study_materials/';
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
            //     $config=['upload_path' => $uploadPath,
            // 'allowed_types' => 'pdf|doc|docx|xlsx|csv|xls|ppt|pptx','max_size' => '1000240','overwrite' => TRUE,
            // ];//'file_name' => $customer_id
    
            // $this->load->library('upload', $config);
            // if (!$this->upload->do_upload('doc_path')) {
            //     $error = array('error' => $this->upload->display_errors());
            // } else { 
            //     $data = array('upload_data' => $this->upload->data());
            // }
            // if (!empty($data['upload_data']['file_name'])) {
            //     $upload_file = $data['upload_data']['file_name'];
            // } else {
            //     // $upload_file = 0;
            //     $this->session->set_flashdata('error', 'File Type Not Allowed and Maximum size of 10MB');
            //     redirect('viewStudyMaterials');
            // }
            //     $importFileName = $uploadPath. $upload_file;
            $config = [
                'upload_path' => $uploadPath,
                'allowed_types' => 'pdf|doc|docx|xlsx|csv|xls|ppt|pptx',
                'max_size' => 1000240,
                'overwrite' => TRUE,
                'file_ext_tolower' => TRUE
            ];

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('doc_path')) {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('viewStudyMaterials');
            }

            $data = $this->upload->data();

            // Generate renamed file name → filename_20250119_211455.pdf
            $timestamp = date('Ymd_His');
            $newFileName = $data['raw_name'] . '_' . $timestamp . $data['file_ext'];
            $newFullPath = $uploadPath . $newFileName;

            // Rename uploaded file
            rename($data['full_path'], $newFullPath);

            // Compress file
            $compressed = $this->compressViaAPI($newFullPath);
            if ($compressed !== false) {
                file_put_contents($newFullPath, $compressed);
            }

            $upload_file = $newFileName;
            $importFileName = $newFullPath;

                for($i=0;$i<count($stream_name);$i++){
                    $streamName = $stream_name[$i];
                    $metriInfo= array(
                        'term_name' =>$term_name,
                        'section_name' =>$section_name,
                        'stream_name' => $streamName,
                        'subject_name' => $subject_name,
                        'document_name_url' =>$importFileName,
                        'type'=>$doc_type,
                        'description' => $description,
                        'name' => $upload_file,
                        'created_by' => $this->staff_id,
                        'created_date_time' => date('Y-m-d H:i:s'));
                    $return_id = $this->study->addNewStudyMaterials($metriInfo);
                }
            
                if($return_id > 0){
                    $this->session->set_flashdata('success', 'New Study Material Added Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Add New Study Material Failed');
                }
            }
            redirect('viewStudyMaterials');
            
        }
    }
    
    //delete a class completed info
    public function deleteStudyMaterials(){
        if ($this->isAdmin() == true) {
            echo (json_encode(array('status' => 'access')));
        } else {
            $row_id = $this->input->post('row_id');
            $studyInfo = array('is_deleted' => 1);
            $result = $this->study->updateStudyMaterials($row_id, $studyInfo);
            if ($result > 0) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        }
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
            $count = $this->study->getAllClassCount($filter);
            $returns = $this->paginationCompress("viewOnlineClass/", $count, 100);
            $data['classRecordsCount'] = $count;
            $data['classRecords'] = $this->study->getAllClassInfo($filter, $returns["page"], $returns["segment"]);
            $data['subjectInfo'] = $this->subject->getStaffSubjectName($filter);

            $this->global['pageTitle'] = ''.TAB_TITLE.' : Online Class Details';
            $this->loadViews("studyMaterial/class", $this->global, $data, null);
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
                
                // $start_time_hh =$this->security->xss_clean($this->input->post('start_time_hh'));
                // $start_time_mm =$this->security->xss_clean($this->input->post('start_time_mm'));
                // $start_am_pm =$this->security->xss_clean($this->input->post('start_am_pm'));
                // $end_time_hh =$this->security->xss_clean($this->input->post('end_time_hh'));
                // $end_time_mm =$this->security->xss_clean($this->input->post('end_time_mm'));
                // $end_am_pm =$this->security->xss_clean($this->input->post('end_am_pm'));
                
                // $start_time = $start_time_hh.':'.$start_time_mm.' '.$start_am_pm;
                // $end_time = $end_time_hh.':'.$end_time_mm.' '.$end_am_pm;
                $classDate = date('Y-m-d',strtotime($class_date));
        
                for($i=0;$i<count($stream_name);$i++){
                    $streamName = $stream_name[$i];
                    $classInfo= array(
                        'term_name' =>$term_name,
                        'section_name' =>$section_name,
                        'stream_name' => $streamName,
                        'subject_name' =>$subject_name,
                        'date' =>$classDate,
                        // 'from_time' =>$start_time,
                        // 'to_time' =>$end_time,
                        'class_link' =>$link_url,
                        'application_type' =>$app_type,
                        'description' => $description,
                        'created_by' => $this->staff_id,
                        'created_date_time' => date('Y-m-d h:i:s'),
            
                    );
                    $return_id = $this->study->addOnlineClass($classInfo);
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
            $filter = array();
            if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
            }
            $data['classInfo'] = $this->study->getAllClassInfoById($row_id);
            $data['subjectInfo'] = $this->subject->getStaffSubjectName($filter);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Online Class Details';
            $this->loadViews("studyMaterial/editOnlineClass", $this->global,$data, NULL);
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
                
                // $start_time_hh =$this->security->xss_clean($this->input->post('start_time_hh'));
                // $start_time_mm =$this->security->xss_clean($this->input->post('start_time_mm'));
                // $start_am_pm =$this->security->xss_clean($this->input->post('start_am_pm'));
                // $end_time_hh =$this->security->xss_clean($this->input->post('end_time_hh'));
                // $end_time_mm =$this->security->xss_clean($this->input->post('end_time_mm'));
                // $end_am_pm =$this->security->xss_clean($this->input->post('end_am_pm'));
                
                // $start_time = $start_time_hh.':'.$start_time_mm.' '.$start_am_pm;
                // $end_time = $end_time_hh.':'.$end_time_mm.' '.$end_am_pm;
                $classDate = date('Y-m-d',strtotime($class_date));
                    
                    $classInfo = array(
                        'term_name' =>$term_name,
                        'section_name' =>$section_name,
                        'stream_name' => $stream_name,
                        'subject_name' =>$subject_name,
                        'date' =>$classDate,
                        // 'from_time' =>$start_time,
                        // 'to_time' =>$end_time,
                        'class_link' =>$link_url,
                        'application_type' =>$app_type,
                        'description' => $description,
                        'updated_by'=>$this->staff_id,
                        'updated_date_time'=>date('Y-m-d H:i:s'));
                $return = $this->study->updateOnlineClassInfo($classInfo,$row_id);
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
            $result = $this->study->updateOnlineClassInfo($classInfo,$row_id);
            if ($result > 0) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        }
    }  
    

    // youtube video 
    public function viewYoutube(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        }else {
            $filter = array();
            $term_name = $this->input->post('term_name');
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
            $video_name = $this->security->xss_clean($this->input->post('video_name'));
            $by_date = $this->security->xss_clean($this->input->post('by_date'));
            $subject_name = $this->security->xss_clean($this->input->post('subject_name'));
    
            $data['subject_name'] = $subject_name;
            $data['term_name'] = $term_name;
            $data['stream_name'] = $stream_name;
            $data['video_name'] = $video_name;
            $data['by_date'] = date('d-m-Y',strtotime($by_date));
    
            $filter['term_name']= $term_name;
            $filter['stream_name']= $stream_name;
            $filter['subject_name']= $subject_name;
            $filter['video_name']= $video_name;
            $filter['by_date']= date('Y-m-d',strtotime($by_date));
            
            if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
            }

            $this->load->library('pagination');
            $count = $this->study->getAllYoutubeCount($filter);
            $returns = $this->paginationCompress("viewYoutube/", $count, 100);
            $data['videoRecordsCount'] = $count;
            $data['videoInfo'] = $this->study->getAllYoutubeInfo($filter, $returns["page"], $returns["segment"]);
            $data['subjectInfo'] = $this->subject->getStaffSubjectName($filter);
            $data['streamInfo'] = $this->study->getStreamInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Youtube';
            $this->loadViews("studyMaterial/youtube", $this->global, $data, null);
        }
    }

    public function addYoutubeToDB(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('term_name','Term Name','trim|required');
            $this->form_validation->set_rules('subject_name','Subject','trim|required');
            //$this->form_validation->set_rules('stream_name','Stream Name','trim|required');
            $this->form_validation->set_rules('video_name','Name','trim|required');
            $this->form_validation->set_rules('link','Link ','trim|required');
            if($this->form_validation->run() == FALSE){
                $this->viewYoutube();
            } else {
                $video_name = $this->security->xss_clean($this->input->post('video_name'));
                $term_name = $this->security->xss_clean($this->input->post('term_name'));
                $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
                $subject_name = $this->security->xss_clean($this->input->post('subject_name'));
                $date = $this->security->xss_clean($this->input->post('date'));
                $section_name = $this->security->xss_clean($this->input->post('section_name'));
                $link =$this->security->xss_clean($this->input->post('link'));
                $description =$this->security->xss_clean($this->input->post('description'));

                for($i=0;$i<count($stream_name);$i++){
                    $streamName = $stream_name[$i];
                    $youtubeInfo= array(
                        'video_name'=>$video_name,
                        'term_name' =>$term_name,
                        'section_name' =>$section_name,
                        'stream_name' => $streamName,
                        'subject_name' =>$subject_name,
                        'date' => date('Y-m-d',strtotime($date)),
                        'link' =>$link,
                        'description' => $description,
                        'created_by' => $this->staff_id,
                        'created_date_time' => date('Y-m-d h:i:s'),
            
                    );
                    $return_id = $this->study->addYoutube($youtubeInfo);
                }
            
                if($return_id > 0){
                    $this->session->set_flashdata('success', 'New Video Link Added Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Failed to Add New Link');
                }
            }
            redirect('viewYoutube');
            
        }
    }

    public function editYoutube($row_id = null) {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {
            if($row_id == null) {
                redirect('viewYoutube');
            }
            $filter = array();
            if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
            }
            $data['youtubeInfo'] = $this->study->getAllYoutubeInfoById($row_id);
            $data['subjectInfo'] = $this->subject->getStaffSubjectName($filter);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Youtube';
            $this->loadViews("studyMaterial/editYoutube", $this->global,$data, NULL);
        }
    }

    public function updateYoutube(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
            $this->form_validation->set_rules('term_name','Term Name','trim|required');
            $this->form_validation->set_rules('subject_name','Subject','trim|required');
            $this->form_validation->set_rules('stream_name','Stream Name','trim|required');
            $this->form_validation->set_rules('video_name','Name','trim|required');
            $this->form_validation->set_rules('link','Link ','required');
           
            if($this->form_validation->run() == FALSE){
                redirect('editYoutube/'.$row_id);  
            } else {
                $video_name =$this->security->xss_clean($this->input->post('video_name'));
                $subject_name=$this->security->xss_clean($this->input->post('subject_name'));
                $term_name =$this->security->xss_clean($this->input->post('term_name'));
                $section_name =$this->security->xss_clean($this->input->post('section_name'));
                $stream_name =$this->security->xss_clean($this->input->post('stream_name'));
                $link =$this->security->xss_clean($this->input->post('link'));
                $description =$this->security->xss_clean($this->input->post('description'));
                $date = $this->input->post('date');
                    
                    $youtubeInfo = array(
                        'video_name'=>$video_name,
                        'term_name' =>$term_name,
                        'section_name' =>$section_name,
                        'stream_name' => $stream_name,
                        'subject_name' =>$subject_name,
                        'date' => date('Y-m-d',strtotime($date)),
                        'link' =>$link,
                        'description' => $description,
                        'updated_by'=>$this->staff_id,
                        'updated_date_time'=>date('Y-m-d H:i:s'));
                $return = $this->study->updateYoutubeInfo($youtubeInfo,$row_id);
                if($return > 0) {
                    $this->session->set_flashdata('success', 'Youtube Updated Successfully');
                } else {
                    $this->session->set_flashdata('error', 'Youtube Details Update failed');
                }
                redirect('editYoutube/'.$row_id);
            }
        }
    }

    public function deleteYoutube(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $youtubeInfo = array('is_deleted' => 1,'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->study->updateYoutubeInfo($youtubeInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    
    public function getStreamNameByTermName(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $term_name = $this->input->post("term_name");
            $filter['term_name'] = $term_name;
            $data['result'] = $this->study->getStreamInfo($filter);
            header('Content-type: text/plain'); 
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        }
    }

    private function compressViaAPI($filePath)
    {
        $pythonUrl = "https://ai.parrophins.in/compress_same";
        // $pythonUrl = "http://192.168.1.198:8000/compress_same";

        $params = [
            'target_kb' => 200,
            'max_w' => 1600,
            'max_h' => 1600,
            'allow_png_quantize' => 'true',
        ];
        $query = http_build_query($params);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $pythonUrl . "?" . $query,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'file' => new CURLFile($filePath, mime_content_type($filePath), basename($filePath)),
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_TIMEOUT => 120,
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            // log_message('error', 'Compression API error: ' . curl_error($ch));
            curl_close($ch);
            return false;
        }

        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $body = substr($response, $headerSize);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            // log_message('error', 'Compression API returned HTTP ' . $httpCode);
            return false;
        }

        return $body; // compressed binary data
    }
}
?>