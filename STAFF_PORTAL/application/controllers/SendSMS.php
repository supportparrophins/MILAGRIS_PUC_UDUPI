<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

class SendSMS extends BaseController{
    public function __construct(){
        parent::__construct();
        $this->load->model('students_model');
        $this->load->model('sms_model');
        $this->load->model('timetable_model');
        $this->load->model('push_notification_model');

       // $this->load->library('setupfile');
        $this->isLoggedIn();   
    }

   
    public function send_sms_view(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $this->global['pageTitle'] = 'SchholPhins-SJPUC : Send SMS';
            $apiKey = urlencode('8fBwmQ+2Qnk-dfqmVSklqm7NnZIAx41qIzmPaeqkCt');
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
            $data['balance']= $json['balance']['sms'];
            $this->loadViews("sms/send_sms_view", $this->global, $data , NULL);
        }
    }

    public function send_sms(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $this->load->library('form_validation');
            $this->form_validation->set_rules('message','Message','trim|required');
            if($this->form_validation->run() == FALSE){
               echo "error";
            }else{
                $mobile_numbers="";
                $term = $this->security->xss_clean($this->input->post('term'));
                $parentsMobile = $this->security->xss_clean($this->input->post('parentsMobile'));
                $onlyStudents = $this->security->xss_clean($this->input->post('onlyStudents'));
                $number_single = $this->security->xss_clean($this->input->post('number'));
                $message = $this->security->xss_clean($this->input->post('message'));
                $numbers = $this->sms_model->getNumbersByTerm($term);
                if(!empty($parentsMobile)){
                    foreach ($numbers as $number) {
                        if($number->father_mobile == ""){
                            $mobile_numbers .= $number->mother_mobile.',';
                            $smsLog = array(
                                'date_time' => date('Y-m-d H:i:s'),
                                'student_id' => $number->student_id,
                                'message' => $message,
                                'status' => 'success',
                                'sent_by' => $this->vendorId,
                                'sms_count' => 1,
                                'mobile_number' => $number->father_mobile
                            );
                        }else{
                            $mobile_numbers .= $number->father_mobile.',';
                            $smsLog = array(
                                'date_time' => date('Y-m-d H:i:s'),
                                'student_id' => $number->student_id,
                                'message' => $message,
                                'status' => 'success',
                                'sent_by' => $this->vendorId,
                                'sms_count' => 1,
                                'mobile_number' => $number->father_mobile
                            );
                        }
                        $this->sms_model->addNewSMS_Log($smsLog); 
                    }
                }
              

                if(!empty($onlyStudents)){
                    foreach ($numbers as $number) {
                        if($number->mobile != ""){
                            $mobile_numbers .= $number->mobile.',';
                            $smsLog = array(
                                'date_time' => date('Y-m-d H:i:s'),
                                'student_id' => $number->student_id,
                                'message' => $message,
                                'status' => 'success',
                                'sent_by' => $this->vendorId,
                                'sms_count' => 1,
                                'mobile_number' => $number->mobile
                            );
                            $this->sms_model->addNewSMS_Log($smsLog); 
                        }
                    }
                }

               if($number_single != ""){
                $mobile_numbers .= $number_single;
                $smsLog = array(
                    'date_time' => date('Y-m-d H:i:s'),
                    'student_id' => 1,
                    'message' => $message,
                    'status' => 'success',
                    'sent_by' => $this->vendorId,
                    'sms_count' => 1,
                    'mobile_number' => $number_single
                );
                $this->sms_model->addNewSMS_Log($smsLog);
               }

         

               $status = $this->sendSMSToNumber($mobile_numbers,$message);
               header('Content-type: text/plain'); 
               // set json non IE
               header('Content-type: application/json'); 
               echo json_encode($status);
               exit(0); 
            }
        }
    }





        //send mesaage to selected students first and second puc students only

    public function sendSingleSMS(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $to = $this->input->post('to_msg');
            $students = json_decode(stripslashes($this->input->post('students_appliction_number')));
            $onlyParents = $this->input->post('onlyParents');
            $onlyStudent = $this->input->post('onlyStudent');
            $message = $this->input->post('message');
            // $term = $this->input->post('term');
            $message = "$to %n $message -Principal, SJPUCB";
            foreach($students as $student_id){  
                $mobile = "";         
                $data_students = $this->sms_model->getStudentMobileNumberById($student_id);
                $student_mobile = $data_students->mobile;
                $father_mobile = $data_students->father_mobile;
                $mother_mobile = $data_students->mother_mobile;

                
                if($onlyParents == 1 && $onlyStudent == 1){
                    if($father_mobile == ""){
                        $mobile = $mother_mobile;
                    }else{
                        $mobile = $father_mobile;
                    }
                    if($student_mobile != ""){
                        $mobile .= ','.$student_mobile;
                    }

                    // $this->setupfile->send($mobile, "$to %n $message -Principal %n SJPUCB");
                    $status = $this->sendSingleNumberSMS($mobile,$message);
                    $smsLog = array(
                        'date_time' => date('Y-m-d H:i:s'),
                        'student_id' => $student_id,
                        'message' => $message,
                        'status' => $status,
                        'sent_by' => $this->vendorId,
                        'sms_count' => 1,
                        'mobile_number' => $mobile
                    );
                    $return_id = $this->sms_model->addNewSMS_Log($smsLog);
                } else if($onlyParents == 1){
                    if($father_mobile == ""){
                        $mobile = $mother_mobile;
                    }else{
                        $mobile = $father_mobile;
                    }

                    $status = $this->sendSingleNumberSMS($mobile,$message);
                    $smsLog = array(
                        'date_time' => date('Y-m-d H:i:s'),
                        'student_id' => $student_id,
                        'message' => $message,
                        'status' => $status,
                        'sent_by' => $this->vendorId,
                        'sms_count' => 1,
                        'mobile_number' => $mobile
                    );
                    $return_id = $this->sms_model->addNewSMS_Log($smsLog);
                } else if($onlyStudent == 1){
                    if($student_mobile != ""){
                        $status = $this->sendSingleNumberSMS($student_mobile,$message);
                        $smsLog = array(
                            'date_time' => date('Y-m-d H:i:s'),
                            'student_id' => $student_id,
                            'message' => $message,
                            'status' => $status,
                            'sent_by' => $this->vendorId,
                            'sms_count' => 1,
                            'mobile_number' => $student_mobile
                        );
                        $return_id = $this->sms_model->addNewSMS_Log($smsLog);
                    }
                }
            }
        echo "success";
        exit;
        }
    }



    public function sendSMSAbsentedStudents(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $students = $this->sms_model->getNumbersByTerm($term_name);

            foreach ($students as $student) {
                $absentedStudentInfo = $this->timetable_model->getStudentAbsentDetails(date("Y-m-d"),$student->student_id,$term_name);
                $count = 0;
                
                foreach($absentedStudentInfo as $infoAb){
                    if($count == 0){
                    // if($infoAb->father_mobile != ""){
                    // $mobile = $infoAb->father_mobile;
                    // }else{
                    // $mobile = $infoAb->father_mobile.','.$infoAb->mother_mobile;
                    // }
                    
                    $mobile = $infoAb->father_mobile.','.$infoAb->mother_mobile;
                    $student_name = strtoupper($infoAb->student_name);
                    // $student_name = explode(" ", $student_name);
                    // $student_name = $student_name[0].' '.$student_name[1];
                    $absent_date = date("d-m-Y");
                    $subject_name = strtoupper($infoAb->sub_name);
                    } else {

                        if(!(preg_match("/{$infoAb->sub_name}/i", $subject_name))) {
                            $subject_name .= ','.strtoupper($infoAb->sub_name);
                        }
                    }
                    $count++;
                }
                
                if($absentedStudentInfo != NULL){
                    // $finalMessage = 'Your ward '.$student_name.' is absent for the subject '.$subject_name.' on '.$absent_date.'.Kindly contact the office to confirm.-Principal, SJPUC';
                    $finalMessage = 'Your ward '.$student_name.' is absent for the subject '.$subject_name.' on '.$absent_date.'.Kindly contact the office to confirm.-Principal, SJPUC';
                    $smsStatus = $this->sendAbsentSMS($mobile, $finalMessage);
                if($smsStatus == 'success'){
                        $attendanceUpdateInfo = array(
                            'sms_sent_status' => 1,
                            'updated_date_time' => date('Y-m-d H:i:s')
                        );

                        $smsLog = array(
                            'date_time' => date('Y-m-d H:i:s'),
                            'student_id' => $student->student_id,
                            'message' => $finalMessage,
                            'status' => $smsStatus,
                            'sent_by' => $this->vendorId,
                            'sms_count' => 1,
                            'mobile_number' => $mobile
                        );

                        $this->sms_model->addNewSMS_Log($smsLog);
                        $this->timetable_model->updateAttendanceSMSStatus($student->student_id,date("Y-m-d"),$attendanceUpdateInfo);

                    }

                    //FCM////////////
                    $all_users_token = $this->push_notification_model->getSingleStudentsToken($student->student_id);
                    $tokenBatch = array_chunk($all_users_token,500);
                    for($itr = 0; $itr < count($tokenBatch); $itr++){
                        $this->push_notification_model->sendMessage('Absent For Class',$finalMessage,$tokenBatch[$itr],"student");
                    }
                    //FCM///////////
                }
            }
            echo "success";
            exit;
        }
    }

    //getting sms report

    public function getSmsReport(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $filter = array();
            $student_id =$this->security->xss_clean($this->input->post('student_id'));
            $by_date =  $this->security->xss_clean($this->input->post('by_date')); 
            $mobile =  $this->security->xss_clean($this->input->post('mobile')); 
            $student_name =  $this->security->xss_clean($this->input->post('student_name'));
            $by_term = $this->security->xss_clean($this->input->post('by_term'));
            $searchTerm = $this->security->xss_clean($this->input->post('searchTerm'));
            if($searchTerm == ""){
                $searchTerm = "II PUC";
            }

            if($by_term == ""){
                $data['by_term'] =  $searchTerm;
                $filter['by_term']=  $searchTerm;
            }else{
                $data['by_term'] = $by_term;
                $filter['by_term']= $by_term;
            }

            

            $data['student_name'] = $student_name;
            $data['mobile'] = $mobile;
            $data['student_id'] = $student_id;
            $data['by_date'] = $by_date;

            $filter['application_number'] = $application_number;
            $filter['student_id'] = $student_id;
            $filter['student_name'] = $student_name;
            $filter['mobile'] = $mobile;

            if($by_date != ""){
                $filter['by_date'] = date("Y-m-d", strtotime($by_date));
            }

            
            $this->load->library('pagination');
            $count = $this->sms_model->getSMS_ReportCount($filter);
            $returns = $this->paginationCompress("getSmsReport/", $count, 100 );
            $data['count_sms'] = $count;
            $data['smsRecords'] = $this->sms_model->getSMS_ReportDetails($returns["page"], $returns["segment"], $filter);
            $this->global['pageTitle'] = 'Schoolphins : SMS Details';
            $this->loadViews("sms/smsReport", $this->global, $data , NULL);     

        }

    }





    function sendSMSToNumber($mobile,$msg){
        $message = "Dear Parents, %n$msg%n -Principal SJPUCB";
        $message = rawurlencode($message);  
        $data = "username=".USERNAME_TEXTLOCAL."&hash=".HASH_TEXTLOCAL."&message=".$message."&sender=".SENDERID_TEXTLOCAL."&numbers=".$mobile;
        $ch = curl_init('http://api.textlocal.in/send/?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result_sms = curl_exec($ch); // This is the result from the API
        $json = json_decode($result_sms, true);
        //log_message('error', 'JSON=' );
        // log_message('error', 'JSON='.print_r($json));
        $status= $json['status'];
        curl_close($ch);
        return $status;

    }



    function sendSingleNumberSMS($mobile,$msg){
        $message = $msg;
        $message = rawurlencode($message);  
        $data = "username=".USERNAME_TEXTLOCAL."&hash=".HASH_TEXTLOCAL."&message=".$message."&sender=".SENDERID_TEXTLOCAL."&numbers=".$mobile;
        $ch = curl_init('http://api.textlocal.in/send/?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result_sms = curl_exec($ch); // This is the result from the API
        $json = json_decode($result_sms, true);
        //log_message('error', 'JSON=' );
        $status= $json['status'];
        // log_message('error', 'JSON='.print_r($json));
        curl_close($ch);
        return $status;

    }

    public function sendAbsentSMS($mobile,$msg){
        $message = $msg;
        $message = rawurlencode($message);  
        $data = "username=".USERNAME_TEXTLOCAL."&hash=".HASH_TEXTLOCAL."&message=".$message."&sender=".SENDERID_TEXTLOCAL."&numbers=".$mobile;
        $ch = curl_init('http://api.textlocal.in/send/?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result_sms = curl_exec($ch); // This is the result from the API
        $json = json_decode($result_sms, true);
        //log_message('error', 'JSON=' );
        $status= $json['status'];
         log_message('error', 'JSON='.print_r($json,true));
        curl_close($ch);
        return $status;
    }
    


}



?>