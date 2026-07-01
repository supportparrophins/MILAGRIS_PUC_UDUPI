
<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Observation extends BaseController {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('students_model','student');
        $this->load->model('exam_model','exams');
        $this->load->model('subjects_model','subjects');
        $this->load->model('staff_model','staff');
        $this->load->model('studentAttendance_model','attendance');
        $this->load->model('settings_model','settings');
        $this->load->model('Observation_model','observation');
        $this->load->model('push_notification_model');
        // $this->load->library('excel');
        $this->load->library('pagination');
        $this->isLoggedIn();
    }
    
    //observation 
    public function observationListing(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else { 
            $filter = array();
            $date = $this->security->xss_clean($this->input->post('date'));
            $remarks = $this->security->xss_clean($this->input->post('remarks'));
            // $observe_type = $this->security->xss_clean($this->input->post('observe_type'));
            $student_rowId = $this->security->xss_clean($this->input->post('filter_id'));
            $file_path = $this->security->xss_clean($this->input->post('file_path'));
            $year = $this->security->xss_clean($this->input->post('year'));
            $description = $this->security->xss_clean($this->input->post('description'));
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $by_stream = $this->security->xss_clean($this->input->post('by_stream'));
            $section_name = $this->security->xss_clean($this->input->post('section_name'));

            // $data['observe_type'] = $observe_type;
            $data['remarks'] = $remarks;
            $data['student_rowId'] = $student_rowId;
            $data['file_path'] = $file_path;
            $data['year'] = $year;
            $data['description'] = $description;
            $data['term_name'] = $term_name;
            $data['section_name'] = $section_name;
            $data['by_stream'] = $by_stream;
            
            // $filter['observe_type']= $observe_type;
               
            $filter['remarks']= $remarks;
            $filter['student_rowId']= $student_rowId;
            $filter['file_path'] = $file_path;
            $filter['year'] = $year;
            $filter['description'] = $description;
            $filter['term_name'] = $term_name;
            $filter['section_name'] = $section_name;
            $filter['by_stream'] = $by_stream;

            if(!empty($date)){
                $filter['date'] = date('Y-m-d',strtotime($date));
                $data['date'] = date('d-m-Y',strtotime($date));
            }else{
                $data['date'] = '';
                $filter['date'] = '';
            }

           if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
            }
            $accessInfo = $this->getCurrentAccess();
            $data['streamInfo'] = $this->student->getAllStreamName();

            // log_message('debug', 'accessInfo: '.print_r($accessInfo, true));
            $observdata = $this->observation->getObservationVal($filter);
            $data['observeName'] = $observdata->observation_name;

            $observStdData = $this->observation->getStudentVal($filter);
            $data['observeStdName'] = $observStdData->student_name;

            $this->load->library('pagination');
            $count = $this->observation->getObservationCount($filter);
            $returns = $this->paginationCompress("observationListing/", $count, 100);
            $data['totalCount'] = $count;
            $data['observationInfo'] = $this->observation->getObservationInfo($filter, $returns["page"], $returns["segment"]);
            log_message('debug', 'observationInfo: '.print_r($data['observationInfo'], true));
            $data['getStudentInfo'] = $this->observation->getStudentInfo();
            $data['getObservationId'] = $this->observation->getObservationId();
            $data['termInfo'] = $this->settings->getTermInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.': Remarks Details';
            $this->loadViews("exam/observation", $this->global, $data, null);
        }
    }

    public function addObservation(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else { 
            $this->load->library('form_validation');

            $this->form_validation->set_rules('student_rowId','Student name','trim|required');            
            // $this->form_validation->set_rules('observe_type_id','Observation type','trim|required');
            $this->form_validation->set_rules('date','Date','trim|required');
            $this->form_validation->set_rules('description','Description','trim|required');
           
            if($this->form_validation->run() == FALSE){
                $this->observationListing();
            } else {
                $filter = array();
                $student_rowId = $this->security->xss_clean($this->input->post('student_rowId'));
                $remarks = $this->security->xss_clean($this->input->post('remarks'));
                // $observe_type_id = $this->security->xss_clean($this->input->post('observe_type_id'));
                $date = $this->security->xss_clean($this->input->post('date'));
                $description = $this->security->xss_clean($this->input->post('description'));
                $image_path="";
                $target_dir="upload/observation/";
                if(!file_exists($target_dir)){
                    mkdir($target_dir,0777);
                }
                $config=['upload_path' => $target_dir,
                'allowed_types' => 'pdf|jpeg|jpg|png','overwrite' => TRUE,'max_size' => '2048',
                'overwrite' => TRUE,'file_ext_tolower' => TRUE];
                $this->load->library('upload', $config);
                if($this->upload->do_upload()) {
                    $post=$this->input->post();
                    $data=$this->upload->data();
                    $image_path=$target_dir.$data['raw_name'].$data['file_ext'];
                    $post['image_path']=$image_path;
                }
                

                $observeInfo= array(
                    'student_row_id' => $student_rowId,
                    'remarks' => $remarks,
                    'date' =>date('Y-m-d',strtotime($date)),
                    'year' => date('Y'),
                    'file_path' => $image_path,
                    'description' => $description,
                    'created_by' => $this->staff_id,
                    'created_date_time' => date('Y-m-d h:i:s'));
                $return_id = $this->observation->addObserve($observeInfo);
                    
                if($return_id > 0){
                    $studInfo = $this->student->getStudentInfoById($student_rowId);
                    $this->sendNotificationForRemark($studInfo->sat_number);
                    $this->session->set_flashdata('success', 'Remarks Added Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Failed to add ');
                }
                redirect('observationListing');
            }
            
        }
    }

    //delete a Unit test info
    public function deleteObservation(){
        log_message('debug', 'deleteObservation called-->');
        if ($this->isAdmin() == true) {
            echo (json_encode(array('status' => 'access')));
        } else {
            $row_id = $this->input->post('row_id');
            $observeInfo = array('is_deleted' => 1,
            'updated_by' => $this->staff_id,
            'updated_date_time' => date('Y-m-d h:i:s'));
            $result = $this->observation->updatedStudentObservation($row_id, $observeInfo);
            if ($result > 0) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        }
    } 

    public function editObservation($row_id = null) {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            if ($row_id == null) {
                redirect('observationListing');
            }
            $data['observationInfo'] = $this->observation->getObservationInfoById($row_id);
            $data['getStudentInfo'] = $this->observation->getStudentInfo();
            $data['getObservationId'] = $this->observation->getObservationId();
           
            $data['subjectInfo'] = $this->subjects->getAllSubjectInfo();
            // $data['termInfo'] = $this->settings->getAllClassInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit Remarks';
            $this->loadViews("exam/editObservation", $this->global, $data, null);
        }
    }

    public function updateStudentObservation(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else { 
            $this->load->library('form_validation');

            $this->form_validation->set_rules('student_rowId','Student name','trim|required');   
            $this->form_validation->set_rules('remarks','Remarks','trim|required');          
            // $this->form_validation->set_rules('observe_type_id','Observation type','trim|required');
            $this->form_validation->set_rules('date','Date','trim|required');
            $this->form_validation->set_rules('description','Description','trim|required');
            $row_id = $this->input->post('row_id');
           
            if($this->form_validation->run() == FALSE){
                $this->editObservation();
            } else {
                $filter = array();
                $student_rowId = $this->security->xss_clean($this->input->post('student_rowId'));
                $remarks = $this->security->xss_clean($this->input->post('remarks'));
                // $observe_type_id = $this->security->xss_clean($this->input->post('observe_type_id'));
                $date = $this->security->xss_clean($this->input->post('date'));
                $description = $this->security->xss_clean($this->input->post('description'));
                $image_path="";
                $target_dir="upload/observation/";
                if(!file_exists($target_dir)){
                    mkdir($target_dir,0777);
                }
                $config=['upload_path' => $target_dir,
                'allowed_types' => 'pdf|gif|jpg|png','overwrite' => TRUE,'max_size' => '2048',
                'overwrite' => TRUE,'file_ext_tolower' => TRUE];
                $this->load->library('upload', $config);
                if($this->upload->do_upload()) {
                    $post=$this->input->post();
                    $data=$this->upload->data();
                    $image_path=$target_dir.$data['raw_name'].$data['file_ext'];
                    $post['image_path']=$image_path;
                }
                

                $observeInfo= array(
                    'student_row_id' => $student_rowId,
                    'remarks' => $remarks,
                    'date' =>date('Y-m-d',strtotime($date)),
                    'description' => $description,
                    'updated_by' => $this->staff_id,
                    'updated_date_time' => date('Y-m-d h:i:s'));
                if(!empty($image_path)){
                    $observeInfo['file_path'] = $image_path;
                }
                $return_id = $this->observation->updatedStudentObservation($row_id,$observeInfo);
                    
                if($return_id > 0){
                    $this->session->set_flashdata('success', 'Student Remarks Updated Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Failed to update ');
                }
                redirect('editObservation/'.$row_id);
            }
            
        }
    }

    function sendNotificationForRemark($reg_no){
        $title = 'Remark Added';
        $body = 'New Remark has been Added. Please check the remarks';
        $attachmentURL = '';
            //FCM////////////
                $all_users_token = $this->push_notification_model->getSingleStudentsToken($reg_no);
                $tokenBatch = array_chunk($all_users_token,500);
                for($itr = 0; $itr < count($tokenBatch); $itr++){
                    $this->push_notification_model->sendMessage($title,$body,$tokenBatch[$itr],"student");
                }
                // $this->push_notification_model->sendIndividualPushNotification($title,$body,$admissionNos[$i],$attachmentURL);
            //FCM///////////
    }

    


}