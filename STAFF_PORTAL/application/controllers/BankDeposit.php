<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerFaculty.php';

class BankDeposit extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('bankDeposit_model','bank');
        $this->load->model('subjects_model','subject');
        $this->isLoggedIn();   
    }
    public function viewBankDeposit(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else { 
            $filter = array();
            $searchTextCust = $this->security->xss_clean($this->input->post('searchTextCust'));
            $by_name = $this->security->xss_clean($this->input->post('by_name'));
            $deposit_type = $this->security->xss_clean($this->input->post('deposit_type'));
            $deposit_account = $this->security->xss_clean($this->input->post('deposit_account'));
            $by_amount = $this->security->xss_clean($this->input->post('by_amount'));
            $doc_name = $this->security->xss_clean($this->input->post('doc_name'));
            $by_date = $this->security->xss_clean($this->input->post('by_date'));
    
    
            $data['searchTextCust'] = $searchTextCust;
            $data['by_name'] = $by_name;
            $data['deposit_type'] = $deposit_type;
            $data['deposit_account'] = $deposit_account;
            $data['by_amount'] = $by_amount;
            $data['doc_name'] = $doc_name;

            $filter['by_name']= $by_name;
            $filter['deposit_type'] = $deposit_type;
            $filter['deposit_account'] = $deposit_account;
            $filter['by_amount']= $by_amount;
            $filter['searchText'] = $searchTextCust;
            $filter['doc_name']= $doc_name;

            if(!empty($by_date)){
                $filter['by_date'] = date('Y-m-d',strtotime($by_date));
                $data['by_date'] = date('d-m-Y',strtotime($by_date));;
            }else{
                $filter['by_date'] = '';
                $data['by_date'] = '';
            }
            
    
            if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
            }
    
            $this->load->library('pagination');
            $count = $this->bank->getBankDepositCount($filter);
            $returns = $this->paginationCompress("viewLatecomerInfo/", $count, 100);
            $data['bankRecordsCount'] = $count;
            $data['bankRecords'] = $this->bank->getBankDepositInfo($filter, $returns["page"], $returns["segment"]);
            $data['deposittypeInfo'] = $this->bank->getAlldeposittypeInfo();
            $data['depositaccountInfo'] = $this->bank->getAlldepositaccountInfo();
            // $data['streamInfo'] = $this->bank->getStreamInfo();
            $data['accessInfo'] = $this->getCurrentAccess();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Latecomer Details';
            $this->loadViews("bankDeposit/viewBankDeposit", $this->global, $data, null);
        }
    }
    
    public function addNewBankDeposit(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else { 
            $this->load->library('form_validation');
           
            $this->form_validation->set_rules('depositer_name','Depositer Name','trim|required');
            $this->form_validation->set_rules('deposit_type','Deposit Type','trim|required');
            $this->form_validation->set_rules('deposit_account','Deposit Account','trim|required');
            $this->form_validation->set_rules('amount','Deposit Amount','trim|required');
            $this->form_validation->set_rules('date','Date','trim|required');
            // $this->form_validation->set_rules('stream_name','Stream Type','trim|required');
            // $this->form_validation->set_rules('doc_type','Doc Type ','required');
           
            if($this->form_validation->run() == FALSE){
                $this->viewBankDeposit();
            } else {
                $date  = $this->security->xss_clean($this->input->post('date'));
                
                $depositer_name = $this->security->xss_clean($this->input->post('depositer_name'));
                $deposit_type = $this->security->xss_clean($this->input->post('deposit_type'));
                $deposit_account = $this->security->xss_clean($this->input->post('deposit_account'));
                $amount = $this->security->xss_clean($this->input->post('amount'));
                $description = $this->security->xss_clean($this->input->post('description'));

                // $uploadPath = './upload/bank_materials/';
                // if (!file_exists($uploadPath)) {
                //     mkdir($uploadPath, 0777, true);
                // }
                $upload_path = './upload/bank_deposit/';
                $uploadPath_url = '/upload/bank_deposit/';
                $config=['upload_path' => $upload_path,
            'allowed_types' => 'pdf|doc|docx|xlsx|csv|xls|ppt|pptx','max_size' => '150000','overwrite' => TRUE,
            ];//'file_name' => $customer_id
    
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('doc_path')) {
                $error = array('error' => $this->upload->display_errors());
            } else { 
                $data = array('upload_data' => $this->upload->data());
            }
            // log_message('debug','wsdb'.print_r($data,true));
            if (!empty($data['upload_data']['file_name'])) {
                $upload_file = $data['upload_data']['file_name'];
            } else {
                // $upload_file = 0;
                $this->session->set_flashdata('error', 'File Type Not Allowed and Maximum size of 10MB');
                redirect('viewBankDeposit');
            }
            $date = date('Y-m-d',strtotime($date));
                $importFileName = $uploadPath_url. $upload_file;
                // for($i=0;$i<count($stream_name);$i++){
                    // $streamName = $stream_name[$i];
                    $metriInfo= array(
                        'date' =>$date,
                        
                        'depositer_name' =>$depositer_name,
                        'deposit_type' =>$deposit_type,
                        'deposit_account' =>$deposit_account,
                        'amount' =>$amount,
                        'document_name_url' =>$importFileName,
                        'description' => $description,
                        // 'name' => $upload_file,
                        'created_by' => $this->staff_id,
                        'created_date_time' => date('Y-m-d H:i:s'));
                        // log_message('debug','$dateInfo '.print_r($date,true));
                    $return_id = $this->bank->addNewBankDeposit($metriInfo);
                // }
            
                if($return_id > 0){
                    $this->session->set_flashdata('success', 'New Bank Deposit Added Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Add New Bank Deposit Failed');
                }
            }
            redirect('viewBankDeposit');
            
        }
    }
    
    //delete a class completed info
    public function deleteBankDeposit(){
        if ($this->isAdmin() == true) {
            echo (json_encode(array('status' => 'access')));
        } else {
            $row_id = $this->input->post('row_id');
            $bankInfo = array('is_deleted' => 1);
            $result = $this->bank->updateBankDeposit($row_id, $bankInfo);
            if ($result > 0) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        }
    }  

    public function viewOnlineClass(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $filter = array();
            $depositer_name = $this->security->xss_clean($this->input->post('depositer_name'));
            $amount = $this->security->xss_clean($this->input->post('amount'));
            $by_date = $this->security->xss_clean($this->input->post('by_date'));
            $start_time = $this->security->xss_clean($this->input->post('start_time'));
            $end_time = $this->security->xss_clean($this->input->post('end_time'));
            $app_type = $this->security->xss_clean($this->input->post('app_type'));
            $description = $this->security->xss_clean($this->input->post('description'));
            $byDate = date('Y-m-d',strtotime($by_date));

            $data['depositer_name'] = $depositer_name;
            $data['amount'] = $amount;
            $data['by_date'] = $by_date;
            $data['start_time'] = $start_time;
            $data['end_time'] = $end_time;
            $data['app_type'] = $app_type;
            $data['description'] = $description;

            $filter['depositer_name']= $depositer_name;
            $filter['amount']= $amount;
            $filter['start_time']= $start_time;
            $filter['end_time'] = $end_time;
            $filter['by_date']= $byDate;
            $filter['app_type']= $app_type;
            $filter['description']= $description;

            if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
            }

            $this->load->library('pagination');
            $count = $this->bank->getAllClassCount($filter);
            $returns = $this->paginationCompress("viewOnlineClass/", $count, 100);
            $data['classRecordsCount'] = $count;
            $data['classRecords'] = $this->bank->getAllClassInfo($filter, $returns["page"], $returns["segment"]);
            $data['subjectInfo'] = $this->subject->getStaffSubjectName($filter);

            $this->global['pageTitle'] = ''.TAB_TITLE.' : Online Class Details';
            $this->loadViews("bankDeposit/class", $this->global, $data, null);
        }
    }

    public function addNewOnlineClass(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            
            $this->load->library('form_validation');
        
            $this->form_validation->set_rules('depositer_name','Depositer Name','trim|required');
            $this->form_validation->set_rules('class_date','Date ','required');
            $this->form_validation->set_rules('class_date','Date ','required');
            $this->form_validation->set_rules('app_type','Application Type ','required');
            $this->form_validation->set_rules('subject_name','Subject Name ','required');
            $this->form_validation->set_rules('link_url','Link','required');
        
            if($this->form_validation->run() == FALSE){
                $this->viewOnlineClass();
            } else {
                $depositer_name = $this->security->xss_clean($this->input->post('depositer_name'));
                $description = $this->security->xss_clean($this->input->post('description'));
                $class_date = $this->security->xss_clean($this->input->post('class_date'));
                $app_type = $this->security->xss_clean($this->input->post('app_type'));
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
                        'depositer_name' =>$depositer_name,
                        'date' =>$classDate,
                        // 'from_time' =>$start_time,
                        // 'to_time' =>$end_time,
                        'class_link' =>$link_url,
                        'application_type' =>$app_type,
                        'description' => $description,
                        'created_by' => $this->staff_id,
                        'created_date_time' => date('Y-m-d h:i:s'),
            
                    );
                    $return_id = $this->bank->addOnlineClass($classInfo);
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
            $data['classInfo'] = $this->bank->getAllClassInfoById($row_id);
            $data['subjectInfo'] = $this->subject->getStaffSubjectName($filter);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Online Class Details';
            $this->loadViews("bankDeposit/editOnlineClass", $this->global,$data, NULL);
        }
    }

    public function updateOnlineClass(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
            $this->form_validation->set_rules('depositer_name','Depositer Name','trim|required');
            $this->form_validation->set_rules('class_date','Date ','required');
            $this->form_validation->set_rules('class_date','Date ','required');
            $this->form_validation->set_rules('app_type','Application Type ','required');
            $this->form_validation->set_rules('link_url','Link','required');
           
            if($this->form_validation->run() == FALSE){
                redirect('editOnlineClass/'.$row_id);  
            } else {
                $depositer_name = $this->security->xss_clean($this->input->post('depositer_name'));
                $description = $this->security->xss_clean($this->input->post('description'));
                $class_date = $this->security->xss_clean($this->input->post('class_date'));
                $app_type = $this->security->xss_clean($this->input->post('app_type'));
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
                        'depositer_name' =>$depositer_name,
                        'date' =>$classDate,
                        // 'from_time' =>$start_time,
                        // 'to_time' =>$end_time,
                        'class_link' =>$link_url,
                        'application_type' =>$app_type,
                        'description' => $description,
                        'updated_by'=>$this->staff_id,
                        'updated_date_time'=>date('Y-m-d H:i:s'));
                $return = $this->bank->updateOnlineClassInfo($classInfo,$row_id);
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
            $result = $this->bank->updateOnlineClassInfo($classInfo,$row_id);
            if ($result > 0) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        }
    }  
    

    // youtube video 
    public function viewYoutube(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        }else {
            $filter = array();
            $depositer_name = $this->input->post('depositer_name');
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
            $video_name = $this->security->xss_clean($this->input->post('video_name'));
            $by_date = $this->security->xss_clean($this->input->post('by_date'));
            $subject_name = $this->security->xss_clean($this->input->post('subject_name'));
    
            $data['subject_name'] = $subject_name;
            $data['depositer_name'] = $depositer_name;
            $data['video_name'] = $video_name;
            $data['by_date'] = date('d-m-Y',strtotime($by_date));
    
            $filter['depositer_name']= $depositer_name;
            $filter['video_name']= $video_name;
            $filter['by_date']= date('Y-m-d',strtotime($by_date));
            
            if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
            }

            $this->load->library('pagination');
            $count = $this->bank->getAllYoutubeCount($filter);
            $returns = $this->paginationCompress("viewYoutube/", $count, 100);
            $data['videoRecordsCount'] = $count;
            $data['videoInfo'] = $this->bank->getAllYoutubeInfo($filter, $returns["page"], $returns["segment"]);
            $data['subjectInfo'] = $this->subject->getStaffSubjectName($filter);
            // $data['streamInfo'] = $this->bank->getStreamInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Youtube';
            $this->loadViews("bankDeposit/youtube", $this->global, $data, null);
        }
    }

    public function addYoutubeToDB(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('depositer_name','Depositer Name','trim|required');
            //$this->form_validation->set_rules('stream_name','Stream Name','trim|required');
            $this->form_validation->set_rules('video_name','Name','trim|required');
            $this->form_validation->set_rules('link','Link ','trim|required');
            if($this->form_validation->run() == FALSE){
                $this->viewYoutube();
            } else {
                $video_name = $this->security->xss_clean($this->input->post('video_name'));
                $term_name = $this->security->xss_clean($this->input->post('depositer_name'));
                $link =$this->security->xss_clean($this->input->post('link'));
                $description =$this->security->xss_clean($this->input->post('description'));

                for($i=0;$i<count($stream_name);$i++){
                    $streamName = $stream_name[$i];
                    $youtubeInfo= array(
                        'video_name'=>$video_name,
                        'depositer_name' =>$depositer_name,
                        'date' => date('Y-m-d',strtotime($date)),
                        'link' =>$link,
                        'description' => $description,
                        'created_by' => $this->staff_id,
                        'created_date_time' => date('Y-m-d h:i:s'),
            
                    );
                    $return_id = $this->bank->addYoutube($youtubeInfo);
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
            $data['youtubeInfo'] = $this->bank->getAllYoutubeInfoById($row_id);
            $data['subjectInfo'] = $this->subject->getStaffSubjectName($filter);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Youtube';
            $this->loadViews("bankDeposit/editYoutube", $this->global,$data, NULL);
        }
    }
    

    public function updateYoutube(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
            $this->form_validation->set_rules('depositer_name','Depositer Name','trim|required');
            $this->form_validation->set_rules('video_name','Name','trim|required');
            $this->form_validation->set_rules('link','Link ','required');
           
            if($this->form_validation->run() == FALSE){
                redirect('editYoutube/'.$row_id);  
            } else {
                $video_name =$this->security->xss_clean($this->input->post('video_name'));
                $depositer_name =$this->security->xss_clean($this->input->post('depositer_name'));
                $link =$this->security->xss_clean($this->input->post('link'));
                $description =$this->security->xss_clean($this->input->post('description'));
                $date = $this->input->post('date');
                    
                    $youtubeInfo = array( 
                        'video_name'=>$video_name,
                        'depositer_name' =>$depositer_name,
                        'date' => date('Y-m-d',strtotime($date)),
                        'link' =>$link,
                        'description' => $description,
                        'updated_by'=>$this->staff_id,
                        'updated_date_time'=>date('Y-m-d H:i:s'));
                $return = $this->bank->updateYoutubeInfo($youtubeInfo,$row_id);
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
            $result = $this->bank->updateYoutubeInfo($youtubeInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    
    // public function getStreamNameByTermName(){
    //     if($this->isAdmin() == TRUE){
    //         $this->loadThis();
    //     } else {   
    //         $depositer_name = $this->input->post("depositer_name");
    //         $filter['depositer_name'] = $depositer_name;
    //         $data['result'] = $this->bank->getStreamInfo($filter);
    //         header('Content-type: text/plain'); 
    //         header('Content-type: application/json'); 
    //         echo json_encode($data);
    //         exit(0);
    //     }
    // }
}
?>