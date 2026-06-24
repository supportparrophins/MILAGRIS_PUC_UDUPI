<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Push_Notification extends BaseController {

    public function __construct() {
        parent:: __construct();   
        $this->load->model('push_notification_model');  
        $this->load->model('custom_email_model'); 
        $this->load->model('students_model');
        $this->load->model('staff_model','staff');
        $this->load->library('pagination');  

        $this->isLoggedIn();  
    }

	public function index()
	{
        if ($this->isAdmin() == TRUE ) {
            $this->loadThis();
        } else {
            $data['streams'] = $this->students_model->getAllStreamName();
            $data['sections'] = $this->students_model->getAllSectionName();
            $data['designation'] = $this->staff->getStaffRolesForStaff($this->staff_id);
            $data['departments'] = $this->staff->getStaffDepartment();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Push Notification ';
            $this->loadViews("push_notification/pushNotification", $this->global, $data, NULL);
        }
    }

    public function addBlockedUser(){
        if($this->input->server("REQUEST_METHOD")=="POST"){
            echo $this->push_notification_model->addBlockedUser();
        } 
    }

    public function addFcmToken(){
        if($this->input->server("REQUEST_METHOD")=="POST"){
            $res=$this->push_notification_model->addFcmToken($this->input->post('token'));
            echo $res;
        }        
    }

    public function getStaffNotifications(){
        $data['notifications'] = $this->push_notification_model->getStaffNotifications($this->role,$this->department_id);
        $data['accessInfo'] = $this->getCurrentAccess();
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Staff Notification ';
        $this->loadViews("push_notification/staffNotification", $this->global, $data, NULL);
    }

    // public function getStudentNotifications(){
    //     $data['notifications'] = $this->push_notification_model->getStudentNotifications();
    //     $this->global['pageTitle'] = ''.TAB_TITLE.' : Student Notification ';
    //     $this->loadViews("push_notification/studentNotification", $this->global, $data, NULL);
    // }

    public function validateForm(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('msg_subject','Subject','required');
            $this->form_validation->set_rules('message','Message','required');
            if($this->form_validation->run() == FALSE)
            {
                $this->index();
            }else{
                $uploadedFilePath = '';
                if($_FILES['msg_file']['name'] != ""){
                    $destinationPath = 'upload/notifications/';
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    $config['upload_path'] = $destinationPath;
                    $config['allowed_types'] = 'pdf|doc|docx|png|jpg|jpeg';
                    $config['max_size'] = 2000;
                    // $uniquFileName = uniqid("JNPUC-",true).$_FILES['msg_file']['name'];
                    // $config['file_name'] = $uniquFileName;
                    $this->load->library('upload', $config);
                    if($this->upload->do_upload('msg_file')){
                        $data = array('upload_data' => $this->upload->data());
                        $uploadedFilePath = "upload/notifications/".$data['upload_data']['orig_name'];
                        log_message('debug','dd'.$uploadedFilePath);
                    }else{                        
                        $this->session->set_flashdata('error', $this->upload->display_errors());
                        redirect('pushNotification');
                    }
                }
                $title = $this->input->post('msg_subject');
                $body = $this->input->post('message');
                $role = $this->input->post('role');
                $department = $this->input->post('department');
                $filter['role'] = $role;
                $filter['department'] = $department;
                if($this->input->post("user_name") === "staff"){
                    $this->sendPushNotificationToAllStaffs($title,$body,$uploadedFilePath,$filter);
                    $this->push_notification_model->saveStaffNotification($title,$body,$uploadedFilePath,$filter);
                    // $email_option = $this->input->post('send_email_option');
                    // if(isset($email_option)){
                    //     $this->sendEmailToAllStaff($title,$body);
                    // }
                }else if($this->input->post("user_name") === "student"){
                    $filter['term_name'] = $this->input->post("term_name");
                    $filter['stream_name'] = $this->input->post("stream_name");
                    $filter['section_name'] = $this->input->post("section_name");
                    $this->sendPushNotificationToStudents($title,$body,$uploadedFilePath,$filter);
                    // $email_option = $this->input->post('send_email_option');
                    // if(isset($email_option)){
                    //     $this->sendEmailToAllStudent($title,$body);
                    // }

                    $this->push_notification_model->saveStudentNotification($filter['term_name'],$filter['stream_name'],$filter['section_name'],$title,$body,$uploadedFilePath);    
                }
                $this->index(); 
            }
        }
    }
    
    private function sendPushNotificationToAllStaffs($title,$body,$uploadedFilePath,$filters=array()){
        $all_users_token = $this->push_notification_model->getAllStaffsToken($filters);
        $tokenBatch = array_chunk($all_users_token,500);
        for($itr = 0; $itr < count($tokenBatch); $itr++){
            $this->pushNotification($tokenBatch[$itr],$title,$body,STAFF_KEY_NAME);
        }
        $this->session->set_flashdata('success','Notification sent..!');            
    }

    private function sendPushNotificationToStudents($title,$body,$uploadedFilePath,$filters=array()){
        $all_users_token = $this->push_notification_model->getStudentsToken($filters);
        $tokenBatch = array_chunk($all_users_token,500);
        for($itr = 0; $itr < count($tokenBatch); $itr++){
            $this->pushNotification($tokenBatch[$itr],$title,$body,STUDENT_KEY_NAME);
        }
        $this->session->set_flashdata('success','Notification sent..!'); 
    }

    private function sendEmailToAllStaff($title,$body){
        $users_email_address = $this->custom_email_model->getAllStaffsEmail();
        $users_email_address = array_filter($users_email_address);
        if(! empty($users_email_address !== 0)){
            $this->custom_email_model->sendEmail($title,$body,$users_email_address);
        }                        
    }

    private function sendEmailToAllStudent($title,$body){
        $users_email_address = $this->custom_email_model->getAllStudentsEmail();
        $users_email_address = array_filter($users_email_address);
        if(! empty($users_email_address !== 0)){
            $this->custom_email_model->sendEmail($title,$body,$users_email_address);
        }                       
    }

 // Student Notification Listing
    // function studentNotifications() {
    //     if($this->isAdmin() == TRUE ){
    //         $this->loadThis();
    //     } else {
    //         $filter = array();
    //         $by_date = $this->security->xss_clean($this->input->post('by_date'));
    //         $by_term = $this->security->xss_clean($this->input->post('by_term'));
    //         $by_stream = $this->security->xss_clean($this->input->post('by_stream'));
    //         $by_Section = $this->security->xss_clean($this->input->post('by_Section'));
    //         $by_subject = $this->security->xss_clean($this->input->post('by_subject'));
    //         $by_message = $this->security->xss_clean($this->input->post('by_message'));
    //         $sent_by = $this->security->xss_clean($this->input->post('sent_by'));

    //         $data['by_subject'] = $by_subject;
    //         $data['by_term'] = $by_term;
    //         $data['by_stream'] = $by_stream;
    //         $data['by_Section'] = $by_Section;
    //         $data['sent_by'] = $sent_by;
    //         $data['by_message'] = $by_message;

    //         $filter['by_subject'] = $by_subject;
    //         $filter['by_term'] = $by_term;
    //         $filter['by_stream'] = $by_stream;
    //         $filter['by_Section'] = $by_Section;
    //         $filter['by_message'] = $by_message;
    //         $filter['sent_by'] = $sent_by;

    //         if(!empty($by_date)){
    //             $filter['by_date'] = date('Y-m-d',strtotime($by_date));
    //             $data['by_date'] = date('d-m-Y',strtotime($by_date));
    //         }else{
    //             $data['by_date'] = '';
    //             $filter['by_date'] = '';
    //         }

    //         $data['streamInfo'] = $this->students_model->getAllStreamName();
    //         $count = $this->push_notification_model->getAllstudentNotificationCount($filter);
    //         $returns = $this->paginationCompress("studentNotifications/", $count, 100);
    //         $data['totalCount'] = $count;
    //         $filter['page'] = $returns["page"];
    //         $filter['segment'] = $returns["segment"];
    //         $data['notifications'] = $this->push_notification_model->getAllstudentNotification($filter);
    //         $this->global['pageTitle'] = ''.TAB_TITLE.' : Student Details';
    //         $this->loadViews("push_notification/studentNotification", $this->global,$data, NULL);

    //     }
    // }

         //delete an Notification info
    //  public function deleteStudentNotification(){
    //     if ($this->isAdmin() == true) {
    //         echo (json_encode(array('status' => 'access')));
    //     } else {
    //         $row_id = $this->input->post('row_id');
    //         $notifications = array('is_deleted' => 1,
    //         'updated_by' => $this->staff_id,
    //         'updated_date_time' => date('Y-m-d h:i:s'));
    //         $result = $this->push_notification_model->updateNotification($row_id, $notifications);
    //         if ($result > 0) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
    //     }
    // } 

    public function studentNotifications(){
        $date_to = $this->input->post('date_to');
        $date_from = $this->input->post('date_from');

        if (empty($date_from))
        {
            $filter['date_from'] = date('Y-m-01');
            $data['date_from'] = date('Y-m-01');
        }else {
            $filter['date_from'] = date('Y-m-d', strtotime($date_from));
            $data['date_from'] = date('d-m-Y', strtotime($date_from));
        }
        if (!empty($date_to)) {
            $filter['date_to'] = date('Y-m-d', strtotime($date_to .' +1 day'));
            $data['date_to'] = date('d-m-Y', strtotime($date_to));
        }else{
            $filter['date_to'] = date('Y-m-t');
            $data['date_to'] = date('Y-m-t');
        }
        // if (empty($date_from))
        // {
        //     $filter['date_from'] = date('Y-m-d', strtotime('2024-06-01'));
        //     $data['date_from'] = date('d-m-Y', strtotime('01-06-2024'));
        // }else {
        //     $filter['date_from'] = date('Y-m-d', strtotime($date_from));
        //     $data['date_from'] = date('d-m-Y', strtotime($date_from));
        // }
        // if (!empty($date_to)) {
        // //     $filter['date_to'] = date('Y-m-d');
        // //     $data['date_to'] = date('d-m-Y');
        // // }else{
        //     $filter['date_to'] = date('Y-m-d', strtotime($date_to . ' +1 day'));
        //     $data['date_to'] = date('d-m-Y', strtotime($date_to));
        // }
        $data['notifications'] = $this->push_notification_model->getStudentNotifications($filter);
        $data['accessInfo'] = $this->getCurrentAccess();
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Student Notification ';
        $this->loadViews("push_notification/studentNotification", $this->global, $data, NULL);
    }

    public function deleteStudentNotification() {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            if($this->input->server("REQUEST_METHOD") == "POST"){
                $rowID = trim($this->input->post('rowID'));
                $stdNotification = array('is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
                );
                echo $this->push_notification_model->updateNotification($rowID,$stdNotification);
            }else echo 0;
        } 
    } 
    
                       //send Notification to selected students 
                       public function sendStudentNotification(){
                        if($this->input->server("REQUEST_METHOD") == "POST"){
                            $filter = array();
                            $to = $this->input->post('to_msg');
                            $students = json_decode(stripslashes($this->input->post('student_id')));
                            $title = $this->input->post('msg_subject');
                            $title = 'Notification';
                            $body = $this->input->post('message');
                            $date = $this->input->post('date');
                            $sent_by = $this->session->userdata('name');
                            $sent_by_id = $this->session->userdata('staff_id');         
                            $uploadedFilePath = '';
                            if($_FILES['msg_file']['name'] != ""){
                                $destinationPath = 'upload/notifications/';
                                if (!file_exists($destinationPath)) {
                                    mkdir($destinationPath, 0777, true);
                                }
                                $config['upload_path'] = $destinationPath;
                                $config['allowed_types'] = 'pdf|doc|docx|png|jpg|jpeg';
                                $config['max_size'] = 1000;
                                $this->load->library('upload', $config);
                                if($this->upload->do_upload('msg_file')){
                                    $data = array('upload_data' => $this->upload->data());
                                    $uploadedFilePath = "upload/notifications/".$data['upload_data']['orig_name'];
                                }
                            }
                            foreach($students as $student_id){  
                                $data_students = $this->push_notification_model->getStudentInfoForNotificationById($student_id);
                                $studentId = $data_students->student_id;
                                $filter['row_id'] = $data_students->student_id;                       
                                $data = array(
                                    'active_date' => date('Y-m-d',strtotime($date)),
                                    'userId' => $studentId,
                                    'message' => $body,
                                    'filepath' => $uploadedFilePath,
                                    'updated_by' => $sent_by_id,
                                    'sent_by'=>$sent_by,
                                    'updated_date_time' => date('Y-m-d H:i:s'));
                                $attachmentURL = "";
                                if($uploadedFilePath != ""){
                                    $attachmentURL = base_url().$uploadedFilePath;
                                }
                                $return_id = $this->push_notification_model->saveBulkStudentNotification($data);
                                
                                //FCM////////////
                                    $all_users_token = $this->push_notification_model->getSingleStudentsToken($data_students->row_id);
                                    $tokenBatch = array_chunk($all_users_token,500);
                                    for($itr = 0; $itr < count($tokenBatch); $itr++){
                                        $this->pushNotification($tokenBatch[$itr],$title,$body,STUDENT_KEY_NAME);
                                    }
                                //FCM///////////
                
                            }
                            if ($return_id > 0) {
                                $this->session->set_flashdata('success', 'Notification Sent successfully');
                            } else {
                                $this->session->set_flashdata('error', 'Sending Notification failed');
                            }
                            redirect('studentDetails');        
                        }
                    }
        
                    public function studentIndividualNotifications(){
                        $date_to = $this->input->post('date_to');
                        $date_from = $this->input->post('date_from');
                        $Student_Name = $this->input->post('Student_Name');
                        $term = array();
                        $stream = array();
                        $section = array();
                        $studentData = array();
                        // $filter = array('ALL');
                        if($this->role == ROLE_TEACHING_STAFF){
                            $staff_id= $this->session->userdata('staff_id'); 
                            $staffClassInfo = $this->staff->getDistinctStaffClassInfo($staff_id);
                           
                            foreach($staffClassInfo as $class){
                                if($class->section_name == 'ALL'){
                                    $sectionName = '';
                                    }else{
                                    $sectionName = $class->section_name;  
                                 }
                                 $filter['term'] = $class->term_name;
                                 $filter['stream'] = $class->stream_name;
                                 $filter['section'] = $sectionName;
                                 $filter['staff_id'] = $staff_id;
                                 
                                $studentInfo = $this->push_notification_model->getAllstudentInfoRowId($filter); 
                                array_push($studentData,$studentInfo);
                                array_push($term,$class->term_name);
                                array_push($section,$sectionName);
                                array_push($stream,$class->stream_name);
                            }
                            $filter['term'] = $term;
                            $filter['section'] = $section;
                            $filter['stream'] = $stream;
                            $filter['staff_id'] = $staff_id;
                
                            $studentData=array_merge(...$studentData);
                            $j=0;
                             foreach($studentData as $std){
                              $student_row_id[$j] = $std->row_id;
                              $j++;
                             }
                        }
                        if (empty($date_from))
                        {
                            $filter['date_from'] = date('Y-m-01');
                            $data['date_from'] = date('Y-m-01');
                        }else {
                            $filter['date_from'] = date('Y-m-d', strtotime($date_from));
                            $data['date_from'] = date('d-m-Y', strtotime($date_from));
                        }
                        if (!empty($date_to)) {
                            $filter['date_to'] = date('Y-m-d', strtotime($date_to .' +1 day'));
                            $data['date_to'] = date('d-m-Y', strtotime($date_to));
                        }else{
                            $filter['date_to'] = date('Y-m-t');
                            $data['date_to'] = date('Y-m-t');
                        }
                        // if (empty($date_from))
                        // {
                        //     $filter['date_from'] = date('Y-m-d', strtotime('2023-06-01'));
                        //     $data['date_from'] = date('d-m-Y', strtotime('01-06-2023'));
                        // }else {
                        //     $filter['date_from'] = date('Y-m-d', strtotime($date_from));
                        //     $data['date_from'] = date('d-m-Y', strtotime($date_from));
                        // }
                        // if (!empty($date_to)) {
                        //     $filter['date_to'] = date('Y-m-d', strtotime($date_to .' +1 day'));
                        //     $data['date_to'] = date('d-m-Y', strtotime($date_to));
                        // }
                        $filter['Student_Name'] = $Student_Name;
                        $data['Student_Name'] = $Student_Name;
                        $data['accessInfo'] = $this->getCurrentAccess();
                        $data['notifications'] = $this->push_notification_model->getStudentIndividualNotifications($filter,$student);
                        $this->global['pageTitle'] = ''.TAB_TITLE.' : Student Notification ';
                        $this->loadViews("push_notification/studentIndividualNotification", $this->global, $data, NULL);
                    }
                
                    function deleteStudentIndividualNotification(){
                        if($this->input->server("REQUEST_METHOD") == "POST"){
                            $rowID = trim($this->input->post('rowID'));
                            $StudnetInfo = array('is_deleted' => 1,'updated_by' => $this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
                            echo $this->push_notification_model->updateStudentIndividualNotification($StudnetInfo,$rowID);
                            
                        }else echo 0;
                    }
                    function editStudentIndividualNotification(){
                        if($this->input->server("REQUEST_METHOD") == "POST"){
                            $rowID = trim($this->input->post('rowID'));
                            
                            $result = $this->push_notification_model->getStudentIndividualNotificationByID($rowID);
                            if(empty($result)) echo 0;
                            else echo json_encode($result);
                            
                        }else echo 0;
                    }
                    
                    function StudentIndividualNotificationEdit(){
                        if($this->input->server("REQUEST_METHOD") == "POST"){
                            $rowID = trim($this->input->post('modal_input_row_id'));
                            $message = trim($this->input->post('modal_input_message'));
                
                            $uploadedFilePath = '';
                            if($_FILES['modal_input_msg_file']['name'] != ""){
                                $destinationPath = 'upload/notifications/';
                                if (!file_exists($destinationPath)) {
                                    mkdir($destinationPath, 0777, true);
                                }
                                $config['upload_path'] = $destinationPath;
                                $config['allowed_types'] = 'pdf|doc|docx|png|jpg|jpeg';
                                $config['max_size'] = 1000;
                                $this->load->library('upload', $config);
                                if($this->upload->do_upload('modal_input_msg_file')){
                                    $data = array('upload_data' => $this->upload->data());
                                    $uploadedFilePath = "upload/notifications/".$data['upload_data']['orig_name'];
                                }
                            }
                
                            $uploadedFilePathTwo = '';
                            if($_FILES['modal_input_msg_file']['name'] != ""){
                                $destinationPath = 'upload/notifications/';
                                if (!file_exists($destinationPath)) {
                                    mkdir($destinationPath, 0777, true);
                                }
                                $config['upload_path'] = $destinationPath;
                                $config['allowed_types'] = 'pdf|doc|docx|png|jpg|jpeg';
                                $config['max_size'] = 1000;
                                $this->load->library('upload', $config);
                                if($this->upload->do_upload('modal_input_msg_file_two')){
                                    $data = array('upload_data' => $this->upload->data());
                                    $uploadedFilePathTwo = "upload/notifications/".$data['upload_data']['orig_name'];
                                }
                            }
                                $data = [
                                    'message' => $message,
                                    'updated_by' => $this->staff_id,
                                    'updated_date_time' => date('Y-m-d h:i:s')
                                ];
                                
                                if($uploadedFilePath != ''){
                                    $data['filepath'] = $uploadedFilePath;
                                }
                                $this->push_notification_model->updateStudentIndividualNotification($data, $rowID);
                                $this->session->set_flashdata('success', 'Notification updated successfully');
                            
                        }else $this->session->set_flashdata('error', 'Notification updation failed, Please try again..!');
                        redirect('studentIndividualNotifications');
                    }

        //send Notification to selected students 
        public function sendStaffIndividualNotification(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $filter = array();
            $to = $this->input->post('to_msg');
            $staffs = json_decode(stripslashes($this->input->post('staff_id')));
            $title = $this->input->post('msg_subject');
            $body = $this->input->post('message');
            $date = $this->input->post('date');
            $sent_by = $this->session->userdata('name');
            $sent_by_id = $this->session->userdata('staff_id');         
            $uploadedFilePath = '';
            if($_FILES['msg_file']['name'] != ""){
                $destinationPath = 'upload/notifications/';
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $config['upload_path'] = $destinationPath;
                $config['allowed_types'] = 'pdf|doc|docx|png|jpg|jpeg';
                $config['max_size'] = 1000;
                $this->load->library('upload', $config);
                if($this->upload->do_upload('msg_file')){
                    $data = array('upload_data' => $this->upload->data());
                    $uploadedFilePath = "upload/notifications/".$data['upload_data']['orig_name'];
                }
            }
            // log_message('debug','dataa'.print_r($students,true));
            foreach($staffs as $staff_id){  
                $data_staffs = $this->push_notification_model->getStafInfoForNotificationById($staff_id);
                // $studentId = $data_students->sat_number;
                $staff_row_id= $data_staffs->row_id;
                // $filter['row_id'] = $data_students->sat_number;                       
                $data = array(
                    'active_date' => date('Y-m-d H:i:s',strtotime($date)),
                    //  'userId' => $studentId,
                    'staffId' => $staff_row_id,
                    'message' => $body,
                    'subject' => $title,
                    'filepath' => $uploadedFilePath,
                    'updated_by' => $sent_by_id,
                    'sent_by'=>$sent_by,
                    'updated_date_time' => date('Y-m-d H:i:s'));
                $attachmentURL = "";
                if($uploadedFilePath != ""){
                    $attachmentURL = base_url().$uploadedFilePath;
                }
                $return_id = $this->push_notification_model->saveBulkStaffNotification($data);
                
                //FCM////////////
                    $all_users_token = $this->push_notification_model->getStaffTokenforApprove($data_staffs->staff_id);
                    $tokenBatch = array_chunk($all_users_token,500);
                    for($itr = 0; $itr < count($tokenBatch); $itr++){
                        $this->pushNotification($tokenBatch[$itr],$title,$body,STAFF_KEY_NAME);
                    }
                //FCM///////////

            }
            if ($return_id > 0) {
                $this->session->set_flashdata('success', 'Notification Sent successfully');
            } else {
                $this->session->set_flashdata('error', 'Sending Notification failed');
            }
            redirect('staffDetails');        
        }
    }

    public function staffIndividualNotifications(){
        $date_to = $this->input->post('date_to');
        $date_from = $this->input->post('date_from');
        $Staff_Name = $this->input->post('Staff_Name');
        $term = array();
        $stream = array();
        $section = array();
        $studentData = array();
        // $filter = array('ALL');
      
        if (empty($date_from))
        {
            $filter['date_from'] = date('Y-m-01');
            $data['date_from'] = date('Y-m-01');
        }else {
            $filter['date_from'] = date('Y-m-d', strtotime($date_from));
            $data['date_from'] = date('d-m-Y', strtotime($date_from));
        }
        if (!empty($date_to)) {
            $filter['date_to'] = date('Y-m-d', strtotime($date_to .' +1 day'));
            $data['date_to'] = date('d-m-Y', strtotime($date_to));
        }else{
            $filter['date_to'] = date('Y-m-t');
            $data['date_to'] = date('Y-m-t');
        }
        $filter['Staff_Name'] = $Staff_Name;
        $data['Staff_Name'] = $Staff_Name;
        $data['notifications'] = $this->push_notification_model->getStaffIndividualNotifications($filter);
        $data['accessInfo'] = $this->getCurrentAccess();
        
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Student Notification ';
        $this->loadViews("push_notification/staffIndividualNotification", $this->global, $data, NULL);
    }

    function deleteStaffIndividualNotification(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $rowID = trim($this->input->post('rowID'));
            $StaffInfo = array('is_deleted' => 1,'updated_by' => $this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
            echo $this->push_notification_model->updateStafftIndividualNotification($StaffInfo,$rowID);
            
        }else echo 0;
    }

    function editStaffIndividualNotification(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $rowID = trim($this->input->post('rowID'));
            
            $result = $this->push_notification_model->getStaffIndividualNotificationByID($rowID);
            if(empty($result)) echo 0;
            else echo json_encode($result);
            
        }else echo 0;
    }

    function StaffIndividualNotificationEdit(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $rowID = trim($this->input->post('modal_input_row_id'));
            $message = trim($this->input->post('modal_input_message'));
            $subject = trim($this->input->post('modal_input_msg_subject'));

            $uploadedFilePath = '';
            if($_FILES['modal_input_msg_file']['name'] != ""){
                $destinationPath = 'upload/notifications/';
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $config['upload_path'] = $destinationPath;
                $config['allowed_types'] = 'pdf|doc|docx|png|jpg|jpeg';
                $config['max_size'] = 1000;
                $this->load->library('upload', $config);
                if($this->upload->do_upload('modal_input_msg_file')){
                    $data = array('upload_data' => $this->upload->data());
                    $uploadedFilePath = "upload/notifications/".$data['upload_data']['orig_name'];
                }
            }

                $data = [
                    'message' => $message,
                    'subject' => $subject,
                    'updated_by' => $this->staff_id,
                    'updated_date_time' => date('Y-m-d H:i:s')
                ];
                
                if($uploadedFilePath != ''){
                    $data['filepath'] = $uploadedFilePath;
                }
                $this->push_notification_model->updateStafftIndividualNotification($data, $rowID);
                $this->session->set_flashdata('success', 'Notification updated successfully');
            
        }else $this->session->set_flashdata('error', 'Notification updation failed, Please try again..!');
        redirect('staffIndividualNotifications');
    }

    public function getStudentHomework(){

        $filter = array();
        $date = $this->security->xss_clean($this->input->post('date'));
        $term = $this->security->xss_clean($this->input->post('term'));
        $stream_name = $this->security->xss_clean($this->input->post('stream_names'));
        $section_name = $this->security->xss_clean($this->input->post('section_names'));
        $subject = $this->security->xss_clean($this->input->post('subject'));
        $satff = $this->security->xss_clean($this->input->post('satff'));
        $date_to = $this->input->post('date_to');
        $date_from = $this->input->post('date_from');
     
        $data['term'] = $term;
        $data['stream_name'] = $stream_name;
        $data['section_name'] = $section_name;
        $data['subject'] = $subject;
        $data['satff'] = $satff;
  
        $filter['term'] = $term;
        $filter['stream_name'] = $stream_name;
        $filter['section_name'] = $section_name;
        $filter['subject'] = $subject;
        $filter['satff'] = $satff;
     
         if($section_name == "ALL")
        {
            $filter['section_name'] = "";
        }else{
            $filter['section_name'] = $section_name;
        }
        
        if(!empty($date)){
            $filter['date'] = date('Y-m-d',strtotime($date));
            $data['date'] = date('d-m-Y',strtotime($date));
        }else{
            $data['date'] = '';
        }
        if($this->role == ROLE_TEACHING_STAFF){
            $filter['staff_id']= $this->session->userdata('name'); 
            $filter['staff_name']= $this->session->userdata('staff_id');
        }
        if (empty($date_from))
        {
            $filter['date_from'] = date('Y-m-d', strtotime('2024-04-11'));
            $data['date_from'] = date('d-m-Y', strtotime('11-04-2024'));
        }else {
            $filter['date_from'] = date('Y-m-d', strtotime($date_from));
            $data['date_from'] = date('d-m-Y', strtotime($date_from));
        }
        if (!empty($date_to)) {
            $filter['date_to'] = date('Y-m-d', strtotime($date_to . ' +1 day'));
            $data['date_to'] = date('d-m-Y', strtotime($date_to));
        }

        $data['streams'] = $this->push_notification_model->getAllStreamInfoInfoByID($filter);
        $data['staffSubjectInfo'] = $this->push_notification_model->getAllSubjectInfo($filter);
        $data['SectionInfo'] = $this->push_notification_model->getAllSectionInfoInfoByID($filter);
        $data['homeworkInfo'] = $this->push_notification_model->getStudentHomework($filter);
        $data['homeworkInfoCount'] = $this->push_notification_model->getStudentHomeworkCount($filter);
        $data['accessInfo'] = $this->getCurrentAccess();

        $this->global['pageTitle'] = ''.TAB_TITLE.' : Homework';
        $this->loadViews("push_notification/studentHomework", $this->global, $data, NULL);
    }

    public function sendHomework(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('date','Date','required');
            if($this->form_validation->run() == FALSE)
            {
                redirect('getStudentHomework');
            }else{   
                    $destinationPath = 'upload/notifications/';
                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0777, true);
                        }
                    $config=['upload_path' => $destinationPath,
                    'allowed_types' => 'pdf|doc|docx|png|jpg|jpeg','max_size' => '1000','overwrite' => TRUE,'file_ext_tolower' => TRUE];
                    $this->load->library('upload', $config);
                    $files = $_FILES;
                    $ImgCount = count($_FILES['msg_file']['name']);
                    for($i = 0; $i < $ImgCount; $i++){
                    if($_FILES['msg_file']['name'] != ""){
                           $uniquFileName = uniqid("LPUC-",true).$_FILES['msg_file']['name'][$i];
                           $config['file_name'] = $uniquFileName; 
                            $_FILES['file']['name']       = $files['msg_file']['name'][$i];
                            $_FILES['file']['type']       = $files['msg_file']['type'][$i];
                            $_FILES['file']['tmp_name']   = $files['msg_file']['tmp_name'][$i];
                            $_FILES['file']['error']      = $files['msg_file']['error'][$i];
                            $_FILES['file']['size']       = $files['msg_file']['size'][$i];
                         
                                $this->upload->initialize($config);
                                if($this->upload->do_upload('file')){
                                    $imageData = $this->upload->data();
                                    $uploadedFilePath[$i] = $destinationPath.$imageData['file_name'];
                                    // log_message('debug','uploadedFilePath'.print_r($uploadedFilePath,true));
                            }
                        }
                    }

                $subject = $this->input->post('subject[]');
                $body = $this->input->post('message[]');;
                $date = $this->input->post('date');
             
                    $filter['term_name'] = $this->input->post("term_name");
                    $stream_name = $this->input->post("stream_name[]");
                    if(empty($stream_name)){
                        $filter['stream_name'] = '';
                    }
                    $filter['section_name'] = $this->input->post("section_name");
                    $tempTerm = strtoupper($this->input->post("term_name"));
                    
                     for($j=0;$j<count($body);$j++){
                        for($i=0; $i<count($stream_name); $i++){
                            $filter['stream_name'] = $stream_name[$i];
                            if($subject[$j] != ''){
                            $bodys =  $body[$j]; 
                            $uploadedFilePaths =  $uploadedFilePath[$j];          
                                    $this->sendHomeworkToStudents($bodys,$uploadedFilePaths,$filter);
                                    $sent_by = $this->session->userdata('name');
                                    $format = "%Y-%m-%d %h:%i:%s";
                                    $cdate = mdate($format);
                                    $data = [
                                        'submission_date' => date('Y-m-d',strtotime($date)),
                                        'term_name' =>  $filter['term_name'],
                                        'stream_name' => $stream_name[$i],
                                        'section_name' => $filter['section_name'],
                                        'subject' => $subject[$j],
                                        'homework_discription' => $body[$j],
                                        'sent_by'=> $sent_by,
                                        'date_time' => date('Y-m-d H:i:s'),
                                    ];
                                    if(!empty($uploadedFilePath[$j])){
                                            $data['filepath'] = $uploadedFilePath[$j];

                                        }  
                                    $result = $this->push_notification_model->saveStudentHomework($data);
                                    if($result > 0){
                                        $this->session->set_flashdata('success','Homework sent..!'); 
                                    }else{
                                        $this->session->set_flashdata('error','Unable to send Homework..!');
                                    }
                        }
            
                    } 
                    }
                redirect('getStudentHomework');
              }
        }
    }

           
    private function sendHomeworkToStudents($bodys,$uploadedFilePaths,$filters){
        $body = $bodys;
        $attachmentURL = "";
        $title= "HOMEWORK";
        if($uploadedFilePaths !=""){
            $attachmentURL = base_url().$uploadedFilePaths;
        }
        // $this->push_notification_model->sendHomeworkToStudents($attachmentURL,$filters,$body);

        //FCM////////////
        $all_users_token = $this->push_notification_model->getStudentsToken($filters);
        $tokenBatch = array_chunk($all_users_token,500);
        for($itr = 0; $itr < count($tokenBatch); $itr++){
            $this->pushNotification($tokenBatch[$itr],$title,$body,STUDENT_KEY_NAME);
        }
    }

    public function deleteStudentHomework() {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $homeworkInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->push_notification_model->updateStudentHomework($homeworkInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
    public function getStreamSectionByTermforNotification(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $filter = array();
            $term_name = $this->input->post("term_name");
            log_message("debug","term_name".$term_name);
            if(!empty($term_name) && $term_name != 'ALL'){
                $filter['term_name'] = $term_name;
            }
            if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
            }
            if($this->role == ROLE_TEACHING_STAFF){
                $data['result'] = $this->staff->getSectionById($filter);
                $data['section'] = $this->staff->getSectionById($filter);
            }else{
                $data['result'] = $this->students_model->getAllStreamName();
                $data['section'] = $this->students_model->getAllSectionName();
            }
            header('Content-type: text/plain'); 
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        }
    }
    public function getSectionByTermforNotification(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $filter = array();
            $term_name = $this->input->post("term_name");
            $stream_name = $this->input->post("stream_name");
            if(!empty($term_name) && $term_name != 'ALL'){
                $filter['term_name'] = $term_name;
            }
            if(!empty($stream_name) && $stream_name != 'ALL'){
                $filter['stream_name'] = $stream_name;
            }
            if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
            }
            if($this->role == ROLE_TEACHING_STAFF){
                $data['section'] = $this->staff->getStreamSectionById($filter);
            }else{
                $data['section'] = $this->students_model->getAllSectionName();
            }
            header('Content-type: text/plain'); 
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        }
    }

}
