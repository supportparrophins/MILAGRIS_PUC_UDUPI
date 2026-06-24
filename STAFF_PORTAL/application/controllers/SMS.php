<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class SMS extends BaseController {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Sms_model','sms');
        $this->load->model('students_model','student');
        $this->load->model('staff_model','staff');
        $this->load->model('Enquiry_model','enquiry');
        $this->isLoggedIn();
    }

    public function viewSMSPortal(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $data['templates'] = $this->sms->getSMSTemplates();
            $data['departments'] = $this->staff->getStaffDepartment();
            $data['streamInfo'] = $this->student->getAllStreamName();
            // $data['sms_balance'] =  $this->checkSMSBalance();
            $data['studentInfo'] = $this->student->getStudentInfo();
           // $data['studentGroupInfo'] = $this->student->getAllStdMessageGroupInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : SMS Portal';
            $this->loadViews("sms/send_bulk_sms.php", $this->global, $data, null);
        }
    }
    public function openSMSSentReport(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $this->global['pageTitle'] = ''.TAB_TITLE.' : SMS Report';
            
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $by_name = $this->security->xss_clean($this->input->post('by_name'));
            $by_stream = $this->security->xss_clean($this->input->post('by_stream'));
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $date_search = $this->security->xss_clean($this->input->post('date_search'));
            $mobile = $this->security->xss_clean($this->input->post('mobile'));
            $message = $this->security->xss_clean($this->input->post('message'));
            $sms_count = $this->security->xss_clean($this->input->post('sms_count'));
            $filter = array();
           


            $filter['mobile'] = $mobile;
            // if(empty($date_search)){
            //     $filter['date_search'] =  date('Y-m-d')
            //     $data['date_search'] = date('Y-m-d');
            // }else{
            //     $filter['date_search'] = date('Y-m-d',strtotime($date_search));
            //     $data['date_search'] = $date_search;
            // }

            if(empty($date_search)){
                $filter['date_search'] = date('Y-m-d');
                $data['date_search'] = date('d-m-Y');
            }else{
                $filter['date_search'] = date('Y-m-d',strtotime($date_search));
                $data['date_search'] = date('d-m-Y',strtotime($date_search));
            }

            if(empty($term_name)){
                $data['term_name'] ='';
            }else{
                $filter['term_name'] = $term_name;
                $data['term_name'] = $term_name;
            }
            $data['message'] = $message;
            $filter['message'] = $message;

            $data['student_id'] = $student_id;
            $filter['student_id'] = $student_id;

            $data['by_name'] = $by_name;
            $filter['by_name'] = $by_name;

            $data['by_stream'] = $by_stream;
            $filter['by_stream'] = $by_stream;

            $data['mobile'] = $mobile;
            $filter['mobile'] = $mobile;

            $data['sms_count'] = $sms_count;
            $filter['sms_count'] = $sms_count;

            $data['streamInfo'] = $this->student->getAllStreamName();
            $count = $this->sms->getSMSSentReportCount($filter);
            $returns = $this->paginationCompress("openSMSSentReport/", $count, 100);
            $data['sms_counts'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['accountDetails'] = $this->sms->getSMSSentReport($filter);
            // $data['sms_balance'] =  $this->checkSMSBalance();
            //$data['sms_count'] =  $this->sms->totalSMSSentCount();
            $this->loadViews("sms/sms_sent_report", $this->global, $data, null);
            
        }
    }

    
    public function get_sms_report(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE )
        {
            $this->loadThis();
        } else {
            $draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
           
            $date_search = $this->security->xss_clean($this->input->post('date_search'));
            $mobile = $this->security->xss_clean($this->input->post('mobile'));
            $filter = array();
           
            $filter['term_name'] = $term_name;
            $filter['date_search'] = $date_search;
            $filter['mobile'] = $mobile;
            $data_array_new = [];
            
            $accountDetails = $this->sms->getSMSSentReport($filter);
            foreach($accountDetails as $account) {
    

                $data_array_new[] = array(
                    date('d-m-Y',strtotime($account->sent_date)),
                    $account->application_no,
                    $account->student_name,
                    $account->term_name,
                    $account->stream_name,
                    $account->message,
                    $account->mobile,
                    $account->sms_count,
                    $account->status,
                );
            }
            $count = count($accountDetails);
            $result = array(
                "draw" => $draw,
                    "recordsTotal" => $count,
                    "recordsFiltered" => $count,
                    "data" => $data_array_new
            );
            echo json_encode($result);
            exit();
        }
    }

    //call from ajax /vuejs Method
    public function checkSMSBalanceVueCall(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
           // $this->global['pageTitle'] = ''.TAB_TITLE.' : SMS Portal';
            $sms_balance =  $this->checkTextSMSBalance();
            //$this->loadViews("sms/send_bulk_sms.php", $this->global, $data, null);
            header('Content-type: text/plain'); 
                // set json non IE
            header('Content-type: application/json'); 
            echo json_encode($sms_balance);
            exit(0); 
        }
    }

    /* Updated Code */
    public function getSMSTemplateByID(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            if($this->input->server('REQUEST_METHOD') == "POST"){
                $templateID = $this->input->post('template_id');
                $result = $this->sms->getSMSTemplateByID($templateID);
                if(empty($result))
                    echo 0;
                else{
                    $result->template = $this->getProcessedTemplate($result->content,$result->reg_no);
                    echo json_encode($result);
                }
            }else{
                echo 0;
            }
        }
    }

    function getProcessedTemplate($templateStr,$templateId){
        if($templateId == '1007264894789316585'){
            $searchVal = "{#vari#}";
            $replaceVal = "<span class='multipleEditableText' contenteditable='true' placeholder='".$searchVal."'></span>";
            return str_replace($searchVal, $replaceVal, $templateStr);
        }else{
            $searchVal = "{#var#}";
            $replaceVal = "<span class='editableSpan' contenteditable='true' placeholder='".$searchVal."'></span>";
            return str_replace($searchVal, $replaceVal, $templateStr);
        }
        // return $singleVar;
    }

    // send sms
    public function sendSMSToSingleNumber(){
        if($this->input->server('REQUEST_METHOD') == "POST"){
            $smsDetails = json_decode($this->input->post('data'));
            
          //  log_message('debug','test sms'.print_r($smsDetails,true));
            $result = $this->sendSMS($smsDetails->mobile, $smsDetails->message);
            if($result == 'success'){
                $smsLog = array(
                    'sent_date' => date('Y-m-d'),	
                    'sent_time' => date('H:m:s'),
                    'application_no' => '',
                    'message' => $smsDetails->message,
                    'status' => $result,
                    'sent_by' => $this->staff_id,
                    'sms_count' => $smsDetails->sms_cost,
                    'mobile_number' => $smsDetails->mobile
                );
                echo $this->sms->saveSMSLog($smsLog);   
            }else{
                echo 0; 
            }
        }else echo 0;
    }

    public function sendSMSToStudentGroup(){
        if($this->input->server('REQUEST_METHOD') == "POST"){
            $smsDetails = json_decode($this->input->post('data'));
            $studentInfo = $this->sms->getStudentInfoForSMS($smsDetails->term_name,$smsDetails->stream_name,$smsDetails->section_name);
            $number = array();

            if(!empty($studentInfo)){
                foreach($studentInfo as $std){
                   // log_message('debug','jkj'.print_r($std,true));
                    $primary_contact = $std->father_mobile;
                    if(!empty($primary_contact)){
                        $contactInfo = $std->father_mobile;
                        
                    } else {
                        $contactInfo = $std->mother_mobile;
                    }
                    // $parent_mobile = $contactInfo->mobile_no;
                    
                    if(strlen($contactInfo) == 10){
                        $parent_mobile = $contactInfo;
                    }else{
                        $country_code = '91';
                        $mobileNo = preg_replace("/^\+?{$country_code}/", '',$contactInfo->mobile_no);
                        $parent_mobile = $mobileNo;
                    }
                    if(strlen($parent_mobile) == 10){
                        $number .= $parent_mobile.',';
                    }
                }

                
                $result = $this->sendSMS($number,$smsDetails->message);
                if($result == 'success'){
                    
                    foreach($studentInfo as $std){

                        $primary_contact = $std->father_mobile;
                        if(!empty($primary_contact)){
                            $contactInfo = $std->father_mobile;
                        } else {
                            $contactInfo = $std->mother_mobile;
                        }
                        if(strlen($contactInfo) == 10){
                            $parent_mobile = $contactInfo;
                        }else{
                            $country_code = '91';
                            $mobileNo = preg_replace("/^\+?{$country_code}/", '',$contactInfo);
                            $parent_mobile = $mobileNo;
                        }
                        
                        $smsLog = array(
                            'sent_date' => date('Y-m-d'),	
                            'sent_time' => date('H:m:s'),
                            'application_no' => $std->row_id,
                            'message' => $smsDetails->message,
                            'status' => 'success',
                            'sent_by' => $this->staff_id,
                            'sms_count' => $smsDetails->sms_cost,
                            'mobile_number' => $parent_mobile);
                        $this->sms->saveSMSLog($smsLog);
                    }
                } 
                echo 1;
            }else{ echo 0; } 
        }else{ echo 0; }
    }

    public function sendSMSToStaffGroup(){
        if($this->input->server('REQUEST_METHOD') == "POST"){
            $smsDetails = json_decode($this->input->post('data'));
            $staffInfo = $this->sms->getAllStaffInfoForSMSByDepartment($smsDetails->department_id);
            $number = array();

            if(!empty($staffInfo)){
                foreach($staffInfo as $staff){
                     //log_message('debug','jkj'.print_r($staff,true));
                    if(strlen($staff->mobile) == 10){
                        $number .= $staff->mobile.',';
                    }                    
                }
               // log_message('debug','number'.print_r($number,true));
                $result = $this->sendSMS($number,$smsDetails->message);
                if($result == 'success'){
                    foreach($staffInfo as $staff){
                        if(!empty($staff->mobile)){
                            $smsLog = array(
                                'sent_date' => date('Y-m-d'),	
                                'sent_time' => date('H:m:s'),
                                'application_no' => $staff->staff_id,
                                'message' => $smsDetails->message,
                                'status' => $result,
                                'sent_by' => $this->staff_id,
                                'sms_count' => $smsDetails->sms_cost,
                                'mobile_number' => $staff->mobile
                            );
                            $this->sms->saveSMSLog($smsLog); 
                        }
                    }
                }
                echo 1;
            }else echo 0;
        }else echo 0;
    }

    public function sendSMSToGroup(){
        if($this->input->server('REQUEST_METHOD') == "POST"){
            $smsDetails = json_decode($this->input->post('data'));
            $groupInfo = $this->sms->getAllStudentInfoByGroup($smsDetails->studentID);
            $number = array();
            if(!empty($groupInfo)){
                foreach($groupInfo as $std){
                    if(strlen($std->mobile_one) == 10){
                        $number .= $std->mobile_one.',';
                    }                    
                }
                $result = $this->sendSMS($number,$smsDetails->message);
                if($result == 'success'){
                    foreach($groupInfo as $std){
                        if(!empty($std->mobile_one)){
                            $smsLog = array(
                                'sent_date' => date('Y-m-d'),	
                                'sent_time' => date('H:m:s'),
                                'application_no' => $std->application_no,
                                'message' => $smsDetails->message,
                                'status' => $result,
                                'sent_by' => $this->staff_id,
                                'sms_count' => $smsDetails->sms_cost,
                                'mobile_number' => $std->mobile_one
                            );
                            $this->sms->saveSMSLog($smsLog); 
                        }
                    }
                }
                echo 1;
            }else echo 0;
        }else echo 0;
    }

    public function sendSMSToNumberList(){
        if($this->input->server('REQUEST_METHOD') == "POST"){
            $smsDetails = json_decode($this->input->post('data'));
            $numbers = array();

            $phoneNumbers = json_decode($smsDetails->mobile);
            foreach($phoneNumbers as $number){
                if(strlen($number) == 10){
                    $numbers .= $number.',';;
                }
            }
            //log_message('debug','num'.$numbers);
            $result = $this->sendSMS($numbers,$smsDetails->message);
            if($result == 'success'){
                foreach($phoneNumbers as $number){
                    $smsLog = array(
                        'sent_date' => date('Y-m-d'),	
                        'sent_time' => date('H:m:s'),
                        'application_no' => '',
                        'message' => $smsDetails->message,
                        'status' => 'success',
                        'sent_by' => $this->staff_id,
                        'sms_count' => $smsDetails->sms_cost,
                        'mobile_number' => $number
                    );
                    $this->sms->saveSMSLog($smsLog);
                }
            }
            echo 1;
        }else echo 0;
    }

    public function sendSMSByStudentList(){
        if($this->input->server('REQUEST_METHOD') == "POST"){
            $smsDetails = json_decode($this->input->post('data'));
            $application_no = json_decode($smsDetails->application_no);
            $number = array();
            foreach($application_no as $application){
                if(!empty($application)){
                    $stdInfo = $this->sms->getStudentListForSMS($application);
                    
                    $primary_contact = $stdInfo->father_mobile;
                    if(!empty($primary_contact)){
                        $contactInfo = $stdInfo->father_mobile;
                        
                    } else {
                        $contactInfo = $stdInfo->mother_mobile;
                    }
                    // $contactInfo = $this->sms->getParentContactInfo($stdInfo->application_no,$primary_contact);
                    // log_message('debug','dcdcdc'.print_r($contactInfo,true));
                    log_message('debug','sms'.$contactInfo);
                    if(strlen($contactInfo) == 10){
                        $parent_mobile = $contactInfo;
                    }else{
                        $country_code = '91';
                        $mobileNo = preg_replace("/^\+?{$country_code}/", '',$contactInfo->mobile_no);
                        $parent_mobile = $mobileNo;
                    }
                    if(strlen($parent_mobile) == 10){
                        $number .= $parent_mobile.',';
                        
                    }
                }
            }

            $result = $this->sendSMS($number, $smsDetails->message);
            if($result == 'success'){
                foreach($application_no as $application){
                    if(!empty($application)){
                        
                        $stdInfo = $this->sms->getStudentListForSMS($application);
                        $primary_contact = $stdInfo->father_mobile;
                        if(!empty($primary_contact)){
                            $contactInfo = $stdInfo->father_mobile;
                        } else {
                            $contactInfo = $stdInfo->mother_mobile;
                        }
                        //$contactInfo = $this->sms->getParentContactInfo($stdInfo->application_no,$primary_contact);
                       
                        if(strlen($contactInfo) == 10){
                            $parent_mobile = $contactInfo;
                        }else{
                            $country_code = '91';
                            $mobileNo = preg_replace("/^\+?{$country_code}/", '',$contactInfo->mobile_no);
                            $parent_mobile = $mobileNo;
                        }
                        $smsLog = array(
                            'sent_date' => date('Y-m-d'),	
                            'sent_time' => date('H:m:s'),
                            'application_no' => $stdInfo->row_id,
                            'message' => $smsDetails->message,
                            'status' => 'success',
                            'sent_by' => $this->staff_id,
                            'sms_count' => $smsDetails->sms_cost,
                            'mobile_number' => $parent_mobile
                        );
                        $this->sms->saveSMSLog($smsLog); 
                    }
                }
            }
            echo 1;
        }else echo 0;
    }

    

    public function sendSMSToStaff(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Staffs Details';
            $this->load->library('form_validation');
            $this->form_validation->set_rules('message','Message','trim|required');
            if($this->form_validation->run() == FALSE)
            {
                $this->session->set_flashdata('error', 'Sending Staff SMS Failed!');
                $this->loadViews("staffs/staffs", $this->global, NULL , NULL);
            }
            else
            {
                $number = '';
                $message = $this->input->post('message');
                $msg_cost = $this->input->post('msg_cost');
                $staffInfo = $this->sms->getAllStaffInfoForSMS();
                foreach($staffInfo as $staff){
                    if(strlen($staff->mobile_one) == 10){
                        $number .= $staff->mobile_one.',';
                        $smsLog = array(
                            'sent_date' => date('Y-m-d'),	
                            'sent_time' => date('H:m:s'),
                            'application_no' => 'STF-'.$staff->staff_id,
                            'message' => $message,
                            'status' => 'success',
                            'sent_by' => $this->staff_id,
                            'sms_count' => $sms_cost,
                            'mobile_number' => $staff->mobile_one
                        );
                        $this->sms->saveSMSLog($smsLog); 
                    }
                }
               // $smsStatus['status'] = 'success';
                $smsStatus = $this->sendSMS($number,$message);
                if($smsStatus['status'] == 'success'){
                    $this->session->set_flashdata('success', 'SMS Sent Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Something Went wrong please contact us');
                }
                $this->loadViews("staffs/staffs", $this->global, NULL , NULL);
            }
        }
    }

    //send sms to single number
    public function sendSingleSMS(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else{
            $number = "";
            
            $smsDetails = json_decode($this->input->post('data'));
            $numbers = array();
            // $students = json_decode(stripslashes($this->input->post('application_no')));
            if(!empty($smsDetails)){ 
                $application_no = $smsDetails->application_no;
                $message = $smsDetails->message;
                $msg_cost = $smsDetails->sms_cost;
                $students = json_decode(stripslashes($application_no));

                $stdInfo = $this->student->getStudentInfoByAppNo($students);
                foreach($stdInfo as $std){
                    
                    $primary_contact = $std->primary_mobile;
                    $contactInfo = $this->sms->getParentContactInfo($std->application_no,$primary_contact);
                    
                    if(strlen($contactInfo->mobile_no) == 10){
                        $number = $contactInfo->mobile_no;
                    }else{
                        $country_code = '91';
                        $mobileNo = preg_replace("/^\+?{$country_code}/", '',$contactInfo->mobile_no);
                        $number = $mobileNo;
                    }
                    if(strlen($number) == 10){
                        $numbers .= $number.',';
                        // log_message('error', 'smsLog='.print_r($smsLog,true));
                    }
                }

                $result = $this->sendSMS($numbers, $message);
                if($result == 'success'){
                
                    foreach($stdInfo as $std){
                        
                        $primary_contact = $std->primary_mobile;
                        $contactInfo = $this->sms->getParentContactInfo($std->application_no,$primary_contact);
                        
                        if(strlen($contactInfo->mobile_no) == 10){
                            $number = $contactInfo->mobile_no;
                        }else{
                            $country_code = '91';
                            $mobileNo = preg_replace("/^\+?{$country_code}/", '',$contactInfo->mobile_no);
                            $number = $mobileNo;
                        }
                        // if(strlen($number) == 10){
                            
                        $smsLog = array(
                            'sent_date' => date('Y-m-d'),	
                            'sent_time' => date('H:m:s'),
                            'application_no' => $std->application_no,
                            'message' => $message,
                            'status' => 'success',
                            'sent_by' => $this->staff_id,
                            'sms_count' => $msg_cost,
                            'mobile_number' => $number
                        );
                        $this->sms->saveSMSLog($smsLog); 
                                
                            // log_message('error', 'smsLog='.print_r($smsLog,true));
                        // }
                    }
                }else{
                    echo 0;  
                }
                echo 1;
            }else echo 0; 
            // }
        }
            
    }
    


    public function checkTextSMSBalance(){
        $apiKey = urlencode(API_KEY);
        // Prepare data for POST request
        $data = array('apikey' => $apiKey);
        // Send the POST request with cURL
        $ch = curl_init('https://api.textlocal.in/balance/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($response, true);
        // Process your response here
        // $data['balance']= $json['balance']['sms'];
        return $json;
    }
    
    // function sendSingleNumberSMS($mobile,$message){
    //     log_message('error', 'message='.$message);
    //     $message = $message;
    //     $message = rawurlencode($message);  
    //     $data = "username=".USERNAME_TEXTLOCAL."&hash=".HASH_TEXTLOCAL."&message=".$message."&sender=".SENDERID_TEXTLOCAL."&numbers=".$mobile;
    //     $ch = curl_init('http://api.textlocal.in/send/?');
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $result_sms = curl_exec($ch); // This is the result from the API
    //     $json = json_decode($result_sms, true);
    //     //log_message('error', 'JSON=' );
    //     $status= $json['status'];
         
    //     curl_close($ch);
    //     return $status;
    // }

    function sendSMS($mobile, $message){
         log_message('error', 'message='.$message);
        $message = $message;
        $message = rawurlencode($message);  
        $data = "username=".USERNAME_TEXTLOCAL."&hash=".HASH_TEXTLOCAL."&message=".$message."&sender=".SENDERID_TEXTLOCAL."&numbers=".$mobile;
        $ch = curl_init('https://api.textlocal.in/send/?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result_sms = curl_exec($ch); // This is the result from the API
        $json = json_decode($result_sms, true);
        //log_message('error', 'JSON=' );
         log_message('error', 'JSON='.print_r($json,true));
        $status= $json['status'];
         log_message('error', 'status='.print_r($status,true));
        curl_close($ch);
        return $status;
    }
   
    function countSmsCost($len) {
        if($len <= 160){
            return 1;
        }else if($len >= 161 && $len <= 306){
            return 2;
        }else if($len >= 306 && $len <= 459){
            return 3;
        }else if($len >= 459 && $len <= 612){
            return 4;
        }else if($len >= 612 && $len <= 765){
            return 5;
        }else if($len >= 765 && $len <= 918){
            return 6;
        }else if($len >= 918 && $len <= 1071){
            return 7;
        }else if($len >= 1071 && $len <= 1224){
            return 8;
        }else if($len >= 1224 && $len <= 1377){
            return 9;
        }else if($len >= 1377 && $len <= 1530){
            return 10;
        }else{
            return 11;
        }
    }

    //sms group name
    public function viewSMSGroup(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {        
            $filter = array();

            $by_stdId = $this->security->xss_clean($this->input->post('by_stdId'));
            $by_name = $this->security->xss_clean($this->input->post('by_name'));
            $by_term = $this->security->xss_clean($this->input->post('by_term'));
            $smsGroupName = $this->security->xss_clean($this->input->post('smsGroupName'));

            $data['by_stdId'] = $by_stdId;
            $filter['by_stdId'] = $by_stdId;

            $data['by_name'] = $by_name;
            $filter['by_name'] = $by_name;

            $data['by_term'] = $by_term;
            $filter['by_term'] = $by_term;

            $data['smsGroupName'] = $smsGroupName;
            $filter['smsGroupName'] = $smsGroupName;

            $count = $this->sms->smsListingCount($filter);
            $returns = $this->paginationCompress("smsListing/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['smsGroupInfo'] = $this->sms->smsListing($filter);
            $data['allSMSInfo'] = $this->sms->getAllSMSName();
            $data['studentSMSInfo'] = $this->sms->studentSMSInfo();

            $this->global['pageTitle'] = ''.TAB_TITLE.': Sms group Details';
            $this->loadViews("sms/smsGroupName", $this->global, $data , NULL);
        }

    }

    public function addNewSmsGroup(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $row_id = $this->input->post('row_id');
         
            $this->load->library('form_validation');
            $this->form_validation->set_rules('sms_id','Sms ID','trim|required');
            $this->form_validation->set_rules('student_id','Student ID','trim|required');
            if($this->form_validation->run() == FALSE) {
                $this->viewSMSGroup();  
            } else {
                $sms_id = $this->input->post('sms_id');
                $student_id = $this->input->post('student_id');
                $smsInfo = array(
                    'student_row_id' => $student_id,
                    'sms_id' => $sms_id,
                    'created_by' => $this->staff_id,
                    'updated_by' => $this->vendorId, 
                    'updated_date_time' => date('Y-m-d H:i:s'));
            
                $result = $this->sms->addSms($smsInfo);
                
                if($result > 0 ){
                 $this->session->set_flashdata('success', 'Message Successfully Sent');
                
                }else{
                    $this->session->set_flashdata('error', 'Failed to Send Message');
                }
                redirect('viewSMSGroup');
             
            }
        }
    }

    public function deleteSmsInfo(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $smsInfo = array('is_deleted' => 1,'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->sms->updateSmsInfo($smsInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    //sms absent 
    public function viewSMSAbsentReport(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $data['templates'] = $this->sms->getSMSTemplates();
            $data['departments'] = $this->staff->getStaffDepartment();
            $data['streamInfo'] = $this->student->getAllStreamName();
            // $data['sms_balance'] =  $this->checkSMSBalance();
            $data['studentInfo'] = $this->student->getAllStudentsInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : SMS Portal';
            $this->loadViews("sms/absent_sms.php", $this->global, $data, null);
        }
    }
    
    public function sendAbsentSMS(){
        if($this->input->server('REQUEST_METHOD') == "POST"){
            $smsDetails = json_decode($this->input->post('data'));
            $application_no = json_decode($smsDetails->student_id);
            foreach($application_no as $application){
                if($application != 0){
               
                    $stdInfo = $this->sms->getStudentListForSMS($application);
                    
                    $primary_contact = $stdInfo->primary_mobile;
                    $contactInfo = $this->sms->getParentContactInfo($stdInfo->application_no,$primary_contact);
                    
                    if(strlen($contactInfo->mobile_no) == 10){
                        $parent_mobile = $contactInfo->mobile_no;
                    }else{
                        $country_code = '91';
                        $mobileNo = preg_replace("/^\+?{$country_code}/", '',$contactInfo->mobile_no);
                        $parent_mobile = $mobileNo;
                    }
                    
                    $message = 'Dear Parent, your ward is absent for the '.$smsDetails->session_type.' on '.$smsDetails->date.' - Principal Agnes PUC Mangalore.';



                    if(strlen($parent_mobile) == 10){
                        $result_sms = $this->sendSMS($parent_mobile, $message);
                        if($result_sms == 'success'){

                            $absentInfo = array(
                                'student_id' => $application,
                                'session_type' => $smsDetails->session_type,
                                'date' => date('Y-m-d',strtotime($smsDetails->date)),	
                                'created_by' => $this->staff_id,
                                'created_date_time' => date('Y-m-d H:i:s'),
                            );
                            $this->sms->addAbsentSMSInfo($absentInfo); 
                        }
                    }
                }
            }
            echo 1;
        }else echo 0;
    }

    //sms group name
    public function showAbsentSMSReport(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {        
            $filter = array();

            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $by_name = $this->security->xss_clean($this->input->post('by_name'));
            $by_term = $this->security->xss_clean($this->input->post('by_term'));
            $by_date = $this->security->xss_clean($this->input->post('by_date'));
            $by_session = $this->security->xss_clean($this->input->post('by_session'));
            $by_stream = $this->security->xss_clean($this->input->post('by_stream'));

            $data['student_id'] = $student_id;
            $filter['student_id'] = $student_id;

            $data['by_name'] = $by_name;
            $filter['by_name'] = $by_name;

            $data['by_term'] = $by_term;
            $filter['by_term'] = $by_term;

            if(!empty($by_date)){
                $filter['by_date'] = date('Y-m-d',strtotime($by_date));
                $data['by_date'] = date('d-m-Y',strtotime($by_date));
            }else{
                $data['by_date'] = '';
                $filter['by_date'] = '';
            }

            $data['by_session'] = $by_session;
            $filter['by_session'] = $by_session;

            $data['by_stream'] = $by_stream;
            $filter['by_stream'] = $by_stream;

            $count = $this->sms->smsAbsentListingCount($filter);
            $returns = $this->paginationCompress("showAbsentSMSReport/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['smsGroupInfo'] = $this->sms->smsAbsentListing($filter);
            //$data['allSMSInfo'] = $this->sms->getAllSMSName();
            $data['studentSMSInfo'] = $this->sms->studentSMSInfo();
            $data['streamInfo'] = $this->student->getAllStreamName();
            $this->global['pageTitle'] = ''.TAB_TITLE.': Sms group Details';
            $this->loadViews("sms/smsAbsentList", $this->global, $data , NULL);
        }

    }
    public function deleteabsentSMSInfo(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $absentSmsInfo = array('is_deleted' => 1,'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->sms->updateAbsentSmsInfo($absentSmsInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    // function getSMSResponse(){

    //     $apiKey = API_KEY;

    //     // Prepare data for POST request
    //     $data = array('apikey' => $apiKey,'min_time' => '1658989837','max_time' => '1659076359');
        
    //     // Send the POST request with cURL
    //     $ch = curl_init('https://api.textlocal.in/get_history_api/');
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $response = curl_exec($ch);
    //     // log_message('debug','response'.print_r($response,true));
    //     curl_close($ch);
    //     // Process your response here
    //     // echo $response;
    //     $this->global['pageTitle'] = ''.TAB_TITLE.' : SMS Sent Status';
    //     $this->loadViews("", $this->global, $data, null);
    // }

    function getSMSResponse()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
            $start_date = $this->input->post('date_from');
            $end_date = $this->input->post('date_to');
            if(empty($start_date)){
                if(empty($_SESSION['sms_start_date'])){
                    $data['start_date'] = date('d-m-Y 00:00:00'); 
                    $data['end_date'] = date('d-m-Y H:i:s');
                }else{
                    $data['start_date'] = $_SESSION['sms_start_date']; 
                    $data['end_date'] = $_SESSION['sms_end_date'];
                }
            }else{
                $data['start_date'] = $_SESSION['sms_start_date'] = $start_date;
                $data['end_date'] = $_SESSION['sms_end_date'] = $end_date;

            }
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Subject Details';
            $this->loadViews("sms/sms_status", $this->global,$data, NULL);
        }
    }

    public function get_sms_response(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
            $draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));
            $data_array_new = [];

            if(empty($_SESSION['sms_start_date'])){
                $start_date = date('d-m-Y 00:00:00'); 
                $end_date = date('d-m-Y H:i:s');
            }else{
                $start_date = date('d-m-Y 00:00:00',strtotime($_SESSION['sms_start_date'])); 
                $end_date = date('d-m-Y 24:00:00',strtotime($_SESSION['sms_end_date']));
            }
            
            $apiKey = API_KEY;
            // Prepare data for POST request
            $data = array('apikey' => $apiKey,'min_time' => strtotime($start_date),'max_time' => strtotime($end_date));
            // Send the POST request with cURL
            $ch = curl_init('https://api.textlocal.in/get_history_api/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            // Process your response here
            // echo $response;

            // log_message('debug','response'.print_r($response['messages'],true));
            $smsInfo = json_decode($response);
            $smsInfo = $smsInfo->messages;
            // log_message('debug','cc'.count($response));
            
            // foreach($smsInfo['messages'] as $subject) {
                for($i=0;$i<count($smsInfo);$i++){
                    $status = 'UnKnown';
                    switch($smsInfo[$i]->status){
                        case 'D': $status = 'Delivered'; 
                        break; 
                        case 'U': $status = 'Undelivered'; 
                        break;
                        case 'P': $status = 'Pending'; 
                        break;
                        case 'I': $status = 'Invalid'; 
                        break;
                        case 'E': $status = 'Expired'; 
                        break;
                        case '?': $status = 'Pushed'; 
                        break;
                        case 'B': $status = 'Blocked'; 
                        break;
                    }   
                $data_array_new[] = array(
                    date('d-m-Y H:i:s',strtotime($smsInfo[$i]->datetime)),
                    $smsInfo[$i]->number,
                    $smsInfo[$i]->content,
                    $status
                );
            }
            $count = count($smsInfo);
            $result = array(
                "draw" => $draw,
                    "recordsTotal" => $count,
                    "recordsFiltered" => $count,
                    "data" => $data_array_new
            );
            echo json_encode($result);
            exit();
        }
    }

}