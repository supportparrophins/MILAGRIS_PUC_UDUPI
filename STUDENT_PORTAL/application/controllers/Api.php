<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/third_party/Paytmchecksum.php';
require_once 'vendor/autoload.php';
require APPPATH . '/libraries/BaseController.php';
require APPPATH . '/third_party/easebuzz-lib/easebuzz_payment_gateway.php';


class Api extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('registration_model');
        $this->load->model('student_model');
        $this->load->model('push_notification_model');
        $this->load->model('studymaterial_model');   
        // $this->load->model('remarks_model');   
        $this->load->model('performance_model');
        $this->load->model('attendance_model');
        $this->load->model('fee_model', 'fee');
        // $this->load->model('wallet_model','wallet');
        $this->load->model('admission_model','admission');
        $this->load->model('timetable_model');
        $this->load->model('feedback_model');
        // $this->load->model('Transport_model','transport');
        // $this->load->model('Hostel_model','hostel');
    }
   

    //----------------------LOGIN-----------------------
    /**
     * This function used to login
     */
    public function loginMe()
    {
       
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        $username = $obj['mbl_number'];
        //log_message('debug', 'username--->' . print_r($username, true));


        $result = $this->login_model->loginMe($username);
        //log_message('debug', 'result--->' . print_r($result, true));

        if (!empty($result)) {

            if ($username != '1234567891' && $username != '1231231231' && $username != '1212121212'  && $username != '1313131313') {

                $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $message = "Your OTP is: $otp . Use it to verify your identity. Do not share this code with anyone. Regards, Parrophins.";

                $result_sms = $this->sendOtpmsg($username, $message);
              //  log_message('debug', 'result_sms--->' . print_r($result_sms, true));


                $response = json_decode($result_sms, true);
                // log_message('debug','response obj--->'.print_r($response,true));
                if (isset($response['success']) && $response['success'] == true) {

                    $otpUpdate = array(
                        'last_otp' => $otp,
                    );

                    $update = $this->student_model->updateOtp($username, $otpUpdate);

                    $lastLogin = $this->login_model->lastLoginInfo($result->row_id);
                    // $loginInfo = array("userId"=>$result->row_id, "sessionData" => json_encode($sessionArray), "machineIp"=>$_SERVER['REMOTE_ADDR'], "userAgent"=>getBrowserAgent(), "agentString"=>$this->agent->agent_string(), "platform"=>$this->agent->platform());  
                    // $this->login_model->lastLogin($loginInfo);


                    $onLoginSuccess = 'Login Matched';
                    $SuccessMSG = json_encode($onLoginSuccess);
                    echo $SuccessMSG;
                } else {

                    $InvalidMSG = 'Invalid Mobile Number Please Try Again';
                    $InvalidMSGJSon = json_encode($InvalidMSG);
                    echo $InvalidMSGJSon;
                }
            } else {

                $onLoginSuccess = 'Login Matched';
                $SuccessMSG = json_encode($onLoginSuccess);
                echo $SuccessMSG;
            }
        } else {
            $InvalidMSG = 'Invalid Mobile Number Please Try Again';
            $InvalidMSGJSon = json_encode($InvalidMSG);
            echo $InvalidMSGJSon;
        }
    }
     public function sendOtpmsg($mobile, $msg){

        $url = "https://sms.parrophins.in/airtel/sms";

        $data = [
            "destinationAddress" => [$mobile], // must be array
            "dltTemplateId"      => "1007066642398645953",
            "entityId"           => "1201159168552977034",
            "message"            => $msg,
            "messageType"        => "SERVICE_IMPLICIT",
            "sourceAddress"      => "PARROP"
        ];

        $payload = json_encode($data);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload)
        ]);

        $response = curl_exec($ch);
        if(curl_errno($ch)){
            return curl_error($ch);
        }

        curl_close($ch);

        return $response;
    }
    // public function sendOtpmsg($mobile, $msg){
    //     $request =""; //initialise the request variable
    //     $param['method']= "sendMessage";
    //     $param['send_to'] = $mobile;
    //     $param['msg'] = $msg;
    //     $param['userid'] = GUPSHUP_USERNAME;
    //     $param['password'] = GUPSHUP_PASSWORD;
    //     $param['v'] = "1.1";
    //     $param['msg_type'] = "TEXT"; //Can be "FLASH”/"UNICODE_TEXT"/”BINARY”
    //     $param['auth_scheme'] = "PLAIN";
    //     //Have to URL encode the values
    //     foreach($param as $key=>$val) {
    //     $request.= $key."=".urlencode($val);
    //     //we have to urlencode the values
    //     $request.= "&";
    //     //append the ampersand (&) sign after each parameter/value pair
    //     }
    //     $request = substr($request, 0, strlen($request)-1);
    //     //remove final (&) sign from the request
    //     $url = "https://enterprise.smsgupshup.com/GatewayAPI/rest?".$request;
    //     $ch = curl_init($url);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $response = curl_exec($ch);
    //     curl_close($ch);
    //     $parts = explode(' ', $response);
    //     $result_sms = $parts[0];
    //     return $result_sms;
    // }

    public function checkOtp()
    {
  
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        // log_message('debug','otp obj--->'.print_r($obj,true));

        $mbl_number = $obj['mbl_number'];
        $otp = $obj['otp'];

        $isExist = $this->student_model->checkOtpIsExist($mbl_number, $otp);
        //  log_message('debug','isExist-->'.print_r($isExist,true));

        $result = null;
        $msg = 'OTP is not matching';

        if (!empty($isExist)) {
            $result = $this->login_model->loginMe($mbl_number);
            $msg = 'success';
        }

        $response = [
            'msg' => $msg,
            'result' => $result
        ];

        echo json_encode($response);
    }

    public function appsharedprefsReset(){
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);
        $row_id = $obj['row_id'];
        $studentInfo = $this->student_model->getStudentInfoByRowId($row_id);
        $data = new stdClass(); 
        $data->term = $studentInfo->term_name;
        $data->section = $studentInfo->section_name;
        $data->stream = $studentInfo->stream_name;
        echo json_encode($data);
    }
    
    
    /**
     * This function used to generate reset password request link
     */
    function resetPasswordUser(){
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);

        $student_id = $obj['studentid'];
        $dob = $obj['dob'];

           
                $dob_from_db = str_replace('/', '-', $dob);
                if((date('Y-m-d',strtotime($dob_from_db))) == (date('Y-m-d',strtotime($dob)))){
                    $result = $this->login_model->resetPasswordUser($student_id,date('Y-m-d',strtotime($dob)));
                     if(!empty($result)){
                        $msg = "success";
                    }else{
                        $msg = 'Date of Birth or Student ID is Invalid';
                    }
                }else{
                    $msg = 'Date of Birth is Invalid';
                }
            
            $jsonmsg = json_encode($msg);
            echo $jsonmsg ;
    }

    /**
     * This function used to reset the password 
     */
    function resetPasswordConfirmUser(){
        $json = file_get_contents('php://input'); 
            $obj = json_decode($json,true);
 
            $student_id = $obj['studentid'];
            $password = $obj['password'];
            $studentInfo = array(
                'password'=>getHashedPassword($password),
                'password_text' => base64_encode($password),
                );
           
            $result = $this->login_model->resetPasswordConfirmUser($studentInfo,$student_id);
            if($result > 0)
            {
                $msg="success";
            }
            else
            {
                $msg="failed";
            }
        $jsonmsg = json_encode($msg);
        echo $jsonmsg ;
    }

    /**
     * This function used to add fb token to database 
     */
    function tokenToDB(){
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);

        $student_id = $obj['row_id'];
        $token = $obj['token'];
        $student_name = $obj['student_name'];
        $term = $obj['term'];
        $section = $obj['section'];
        $device_id= $obj['id'];
        // log_message("debug","err=".print_r($device_id,true));
        if($student_id !='' && $device_id != '' ){
            $check_device = $this->login_model->checkDeviceExists($student_id,$device_id);
            if($check_device>0){
                $info = array(
                    'token'=>$token,
                    'updated_by'=>$student_id,
                    'updated_date_time'=>date('Y-m-d H:i:s')
                );
                $result = $this->login_model->updateToken($device_id,$info,$student_id);
            }else{
                $info = array(
                    'student_id'=>$student_id,
                    'student_name'=>$student_name,
                    'stream' => '',
                    'section' => '', 
                    'token'=> $token,
                    'device_model'=>$obj['model'],
                    'device_sdk'=>$obj['sdk'],
                    'device_id'=>$device_id,
                    'created_by'=>$student_id,
                    'created_date_time'=>date('Y-m-d H:i:s')
                );
                $result = $this->login_model->addToken($info);    
            }
        }
        if($result > 0){
            $msg = "token success";
        }else{
            $msg ="token failed";
        }
        $jsonmsg = json_encode($msg);
        echo $jsonmsg;
    }

    
    /**
     * This function used to get dashboard menu 
     */
    function dashboardMenu(){
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);

        $student_id = $obj['user_id'];
        $row_id = $obj['row_id'];
        // log_message('debug','obj'.print_r($obj,true));
        $studentInfo = $this->student_model->getStudentInfoByRowIdApp($row_id);
        $dashboardInfo = $this->login_model->dashboardInfo();

         if(!empty($studentInfo)){
        $db_data = array();
        foreach($dashboardInfo as $info){
            if($info->title =="ANNUAL RESULT" && ($studentInfo->term_name == 'II PUC')){
                continue;
            }else{
                $db_data[] = $info;

            }
        }
    }else{

        $db_data = "logout";
    }
        $data = json_encode($db_data);
        echo $data;
    }

    /**
     * This function used to get dashboard sub menu 
     */
    function dashboardSubMenu(){
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);

        $student_id = $obj['user_id'];
        $menu_id = $obj['user_id'];
        $dashboardInfo = $this->login_model->subMenuInfo($menu_id);
        
        $db_data = array();
        foreach($dashboardInfo as $info){
            $db_data[] = $info;
        }
        $data = json_encode($db_data);
        echo $data;
    }

    //---------------------------REGISTER-------------------------------
    /**
     * This function used to insert registeration details  
     */
    function userRegisterDB()
    {
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);

        $student_id = $obj['studentid'];
        $dob = $obj['dob'];
        $password = $obj['password'];
        $isExist = $this->registration_model->isStudentAlreadyRegisterd($student_id);
            
        if($isExist > 0){
            $msg = $student_id .' is Already Registered.';
        }else{
            $isValid = $this->registration_model->checkStuentIdAndDobIsValid($student_id,'');
            if($isValid == NULL){
                $msg = 'Student ID is Invalid.';
            }else if($isValid != NULL){
                    $dob_from_db = str_replace('/', '-', $isValid->dob);
                    if(date('Y-m-d',strtotime($dob_from_db)) == date('Y-m-d',strtotime($dob))){
                        $studentInfo = array(
                            'student_id'=>$student_id, 
                            'dob'=> date('Y-m-d',strtotime($dob)), 
                            'password'=>getHashedPassword($password), 
                            'password_text' => base64_encode($password),
                            'createdBy' => $student_id,
                            'created_date'=>date('Y-m-d H:i:s'));
                        $result = $this->registration_model->userRegisterDB($studentInfo);

                        if($result > 0){
                            $msg = "success";
                        }else{
                            $msg ='Failed To Register';
                        }
                    }else{
                        $msg = 'Entered Date of Birth is Invalid.';
                    }
                }else{
                    $msg = 'Entered Date of Birth is Invalid.';
                }
            } 
            $jsonmsg = json_encode($msg);
            echo $jsonmsg;
    }

    //--------------STUDENT------------------------------
    /**
     * This function is used to show users profile
     */
    function profile(){
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);
        $student_id = $obj['row_id'];
        $studentInfo = $this->student_model->getStudentInfoByStudentId($student_id);
        $data["active"] = $active;
        $data = json_encode($studentInfo);
        echo $data; 
    }

    /**
     * This function is used to change the password of the user
     * @param text $active : This is flag to set the active tab
     */
    function changePassword(){
        $json = file_get_contents('php://input'); 
            $obj = json_decode($json,true);

            $oldPassword = $obj['old_password'];
            $password = $obj['password'];
            $student_id=$obj['student_id'];
            $resultPas = $this->student_model->matchOldPassword($student_id, $oldPassword);
            if(empty($resultPas)) {
                $msg= 'Your old password is not correct';
            }
            else{
                $usersData = array('password'=>getHashedPassword($password));
                $result = $this->student_model->changePassword($student_id, $usersData);
                if($result > 0) { 
                    $msg='success'; 
                }else { 
                    $msg= 'Password updation failed'; 
                }
            }
            echo json_encode($msg);
    }

    
    //-----------------SUGGESTION--------------    
    // view suggestion
    // public function mySuggestion(){
    //     $json = file_get_contents('php://input'); 
    //     $obj = json_decode($json,true);
    //     $student_id = $obj['user_id'];
    //     $row_id = $obj['row_id'];
    //     // log_message('debug','ee='.print_r($student_id,true));
    //     $data['suggestionInfo'] = $this->student_model->getSuggestionInfoById($row_id);
    //     $db_data = array();
    //     foreach($data['suggestionInfo'] as $suggestion){
    //         if($suggestion->is_viewed == 0 && !(is_null($suggestion->management_reply))){
    //             $tempData = array(
    //                 'is_viewed' => 1,
    //                 'viewed_date_time' => date('Y-m-d H:i:s')
    //             );
    //             $this->student_model->updateSuggestionInfoById($suggestion->row_id,$tempData);
    //         }
    //         $suggestion->date = date('d-m-Y h:i A',strtotime($suggestion->date));
    //         $suggestion->updatedTime = date('d-m-Y h:i A', strtotime($suggestion->updated_date_time));
    //         $db_data[] = $suggestion;
    //     }
    //     // log_message('debug','ee='.print_r($data['suggestionInfo'],true));
    //     $data = json_encode($db_data);
    //     echo $data;
    // }

    // //Save suggestion to db
    // function suggestionToDB()
    // {
    //     $json = file_get_contents('php://input'); 
    //     $obj = json_decode($json,true);

    //     $from = $obj['msg_frm'];
    //     $message = $obj['msg'];
    //         // $this->sendPushNotificationToStaffs('A new message from student: '.$obj['studentid'],$message);  
    //         $suggestionInfo = array(
    //             'student_id'=> $obj['row_id'], 
    //             'msg_from'=>$from, 
    //             'message' => $message, 
    //             'date'=> date('Y-m-d H:i:s'), 
    //             'created_by' => $obj['row_id'], 
    //             'created_date_time' => date('Y-m-d H:i:s'));
            
    //         $result = $this->student_model->suggestionToDB($suggestionInfo);
    //         log_message('debug','result'.print_r($result,true));
            
    //         if($result > 0)
    //         {
    //             $msg="success";
    //         }
    //         else
    //         {
    //             $msg="failed";
    //         }
    //         $data = json_encode($msg);
    //         echo $data;
    // }

     public function mySuggestion()
    {
       
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        $student_id = $obj['row_id'];
        // log_message('debug','ee='.print_r($student_id,true));
        $data['suggestionInfo'] = $this->student_model->getSuggestionInfoById($student_id);
        $db_data = array();
        foreach ($data['suggestionInfo'] as $suggestion) {
            if ($suggestion->is_viewed == 0 && !(is_null($suggestion->management_reply))) {
                $tempData = array(
                    'is_viewed' => 1,
                    'viewed_date_time' => date('Y-m-d H:i:s A')
                );
                $this->student_model->updateSuggestionInfoById($suggestion->row_id, $tempData);
            }
            $suggestion->date = $suggestion->date;
            $suggestion->updatedTime = $suggestion->updated_date_time;
            $db_data[] = $suggestion;
        }
        // log_message('debug','ee='.print_r($data['suggestionInfo'],true));
        $data = json_encode($db_data);
        echo $data;
    }
    //Save suggestion to db
    function suggestionToDB()
    {
      
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        $from = $obj['msg_frm'];
        $message = $obj['msg'];
        $this->sendPushNotificationToStaffs('A new message from student: ' . $obj['row_id'], $message);
        $suggestionInfo = array(
            'student_id' => $obj['row_id'],
            'msg_from' => $from,
            'message' => $message,
            'date' => date('Y-m-d H:i:s'),
            'created_by' => $obj['row_id'],
            'created_date_time' => date('Y-m-d H:i:s')
        );

        $result = $this->student_model->suggestionToDB($suggestionInfo);

        if ($result > 0) {
            $msg = "success";
        } else {
            $msg = "failed";
        }
        $data = json_encode($msg);
        echo $data;
    }

    private function sendPushNotificationToStaffs($title,$body){ 
        $title = substr($title,0,35);
        $body = substr($body,0,40);         
        $fields = array(
            'app_id' => ONE_SIGNAL_APP_ID,
            'contents' => array(
                "en" => $body
            ),
            'headings' => array(
                "en" => $title
            ),
            'web_url' => URL_TO_BE_OPENED_ON_CLICK,                
            'app_url' => URL_TO_BE_OPENED_ON_CLICK,
            'chrome_web_badge' => NOTIFICATION_BADGE,
            'ios_badgeType' => "Increase",
            "ios_badgeCount" => 1,                
        );
        
        $fields['filters'] = array(
                                    array(
                                        "field" => "tag", "key" => "role", "relation" => "=", "value" => "1"
                                    ),
                                    array("operator" => "OR"),
                                    array(
                                        "field" => "tag", "key" => "role", "relation" => "=", "value" => "3"
                                    ),
                                    array("operator" => "OR"),
                                    array(
                                        "field" => "tag", "key" => "role", "relation" => "=", "value" => "5"
                                    )
                                );
        return $this->oneSignalSendNotification($fields);           
    }

    private function oneSignalSendNotification($fields){
        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, ONE_SIGNAL_NOTIFICATION_URL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            ONE_SIGNAL_AUTHORIZATION
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);        
        $response = curl_exec($ch);
        curl_close($ch);
        $responseArr = json_decode($response);
        if(!empty($responseArr->errors)) return 0;
        else return 1;
    }

    //-----------------------ATTENDANCE---------------
    public function myAttendance(){
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);
        $student_id = $obj['row_id'];
        $studentInfo = $this->student_model->getStudentInfoByStudentId($student_id);

        // if($studentInfo->term_name == "I PUC"){ 
            $absent_date_from = date("Y-m-d", strtotime($studentInfo->doj));
        // } else { 
        //     $absent_date_from = '2022-07-01';
        // } 
        //    log_message('debug','studentInfo-->'.print_r($studentInfo,true));
        $attendance_date_to = date("Y-m-d");
        $elective_sub = strtoupper($studentInfo->elective_sub);
        $subjects_code = array();
        $subject_name = array();
        $classes = array();
        $percentages = array();
        if($elective_sub == "KANNADA"){
            array_push($subjects_code, '1');
        }else if($elective_sub == 'HINDI'){
            array_push($subjects_code, '3');
        } else if($elective_sub == 'FRENCH'){
            array_push($subjects_code, '12');
        }else{
            // array_push($subject_mark_chart,0);
            // array_push($subject_names, 'EXM');
        }
        array_push($subjects_code, '2');
        $subjects = $this->getSubjectCodes($studentInfo->stream_name);
        $subjects_code = array_merge($subjects_code,$subjects);
        //    log_message('debug','subjects_code-->'.print_r($subjects_code,true));

        $total_class_held_all = 0;
        $total_class_attended_all = 0;
        for($i=0; $i < count($subjects_code); $i++){
            $absent_count = 0;
            $absent_count_lab = 0;
            $batch_name = '';
            $subject_info = $this->attendance_model->getSubjectInfo($subjects_code[$i]);
            if($subject_info->lab_status == 'true'){
                $batch_name = $studentInfo->batch;
            }                    
            $subject_class_held_theory = $this->attendance_model->getTotalClassHeld($subjects_code[$i],$studentInfo->term_name,$studentInfo->stream_name,$studentInfo->section_name,'THEORY','',$absent_date_from,$attendance_date_to);
            $total_dates_held_theory = $this->attendance_model->getTotalClassCompletedDates($subjects_code[$i],$studentInfo->term_name,$studentInfo->stream_name,$studentInfo->section_name,'THEORY','',$absent_date_from,$attendance_date_to);
           // log_message('debug','total_dates_held_theory-->'.print_r($total_dates_held_theory,true));
            $absent_count_theory = $this->attendance_model->getStudentAbsentCount($subjects_code[$i],$studentInfo->student_id,$absent_date_from,$attendance_date_to,'THEORY');
            $absent_count += $absent_count_theory;
            $subject_class_held_lab = $this->attendance_model->getTotalClassHeld($subjects_code[$i],$studentInfo->term_name,$studentInfo->stream_name,$studentInfo->section_name,'LAB',$batch_name,$absent_date_from,$attendance_date_to);
            $total_dates_held_lab = $this->attendance_model->getTotalClassCompletedDates($subjects_code[$i],$studentInfo->term_name,$studentInfo->stream_name,$studentInfo->section_name,'LAB',$batch_name,$absent_date_from,$attendance_date_to);
            $total_class_held = $subject_class_held_theory + ($subject_class_held_lab*1);               
            $absent_count_lab = $this->attendance_model->getStudentAbsentCount($subjects_code[$i],$studentInfo->student_id,$absent_date_from,$attendance_date_to,'LAB');
            if($absent_count_lab != 0){
                $absent_count += ($absent_count_lab * 1);
            }
            $total_class_presnts = $total_class_held-$absent_count;
            if($total_class_held>0){
                $attendance_percentage = ($total_class_presnts/$total_class_held)*100;
            }else{
                $attendance_percentage=0;
            }
            $total_class_held_all += $total_class_held;
            $total_class_attended_all += $total_class_presnts;
            array_push($subject_name,$subject_info->name); 
            array_push($classes,$total_class_held.'/'.$total_class_presnts); 
            array_push($percentages,round($attendance_percentage,2));                   
        }
        $i=0;
        foreach($subject_name as $sub){
            $data[$i] = array('subject_name'=>$subject_name[$i],'classes'=>$classes[$i],'percentages'=>$percentages[$i]);
            $i++;
        }
        $data = json_encode($data);                 
        echo $data;
    }

    public function getSubjectNames(){
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);
        $student_id = $obj['row_id'];
        $filter = array();
        $studentInfo = $this->student_model->getStudentInfoByStudentId($student_id);
        $elective_sub = strtoupper($studentInfo->elective_sub);
        $subjects_code = array();
        $subject_name = array();
        $classes = array();
        $percentages = array();
        if($elective_sub == "KANNADA"){
            array_push($subjects_code, '1');
        }else if($elective_sub == 'HINDI'){
            array_push($subjects_code, '3');
        } else if($elective_sub == 'FRENCH'){
            array_push($subjects_code, '12');
        }else{
            // array_push($subject_mark_chart,0);
            // array_push($subject_names, 'EXM');
        }
        array_push($subjects_code, '2');
        $subjects = $this->getSubjectCodes($studentInfo->stream_name);
        $subjects_code = array_merge($subjects_code,$subjects);
        $total_class_held_all = 0;
        $total_class_attended_all = 0;
        $subject_info_list = array();
        
        for ($i = 0; $i < count($subjects_code); $i++) {
            $absent_count = 0;
            $absent_count_lab = 0;
            $batch_name = '';
            $subject_info = $this->student_model->getSubjectInfo($subjects_code[$i]);
            // Add the subject info to the list
            $subject_info_list[] = $subject_info;
        }
        // log_message('debug', 'subject_info_list-->' . print_r($subject_info_list, true));
        $data = json_encode($subject_info_list);
        echo $data;
    }

      //----------------NOTIFICATION----------------
      public function generalNotificationsApi(){
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);
        $student_id = $obj['student_id'];
        $row_id = $obj['row_id'];
        
        $student = $this->student_model->getStudentInfoByRowId($row_id);
      
        $notifications = $this->student_model->getStudentNotifications($student->term_name,$student->section_name,$student->stream_name);
    
      
        $db_data = array();
           
            foreach($notifications as $info){
                if($info->date_time!=null){
                    $info->date_time =$info->date_time;
                    $info->type = "By College";
                }
                $db_data[] = $info;
            }
            
            $data = json_encode($db_data);
        echo $data;
    }

    //----------------NOTIFICATION----------------
    public function myNotificationsApi(){
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);
        $term_name=$obj['term_name'];
        $section_name=$obj['section_name'];
        $stream_name = $obj['stream_name'];
        $student_id = $obj['student_id'];
        $row_id = $obj['row_id'];

        // $term_name='KG II';
        // $section_name='C';
        // $student_id = '565464';
        // $row_id = '2';
        $student = $this->student_model->getStudentInfoByRowId($row_id);

       
        $notifications = $this->student_model->getStudentNotifications($student->term_name,$student->section_name,$student->stream_name);


    
        ////
        // $date = date('Y-m-d');
        // $notificationMsg = $this->student_model->getStudentNotification($student_id,$date);

         $bulkNotifications = $this->push_notification_model->getStudentBulkNotificationsApi($student->student_id);        
         
        $db_data = array();
            foreach($bulkNotifications as $info){
                if($info->active_date!=null){
                    $info->date_time =$info->updated_date_time;
                    $info->subject = "Class Notification";
                $info->type = "By Teacher";

                }
                $db_data[] = $info;
            }
            foreach($notifications as $info){
                if($info->date_time!=null){
                    $info->date_time =$info->date_time;
                    $info->type = "By College";

                }
                $db_data[] = $info;
            }
            // foreach($notificationMsg as $info){
            //     if($info->date_time!=null){
            //         $info->date_time =date('d-m-Y H:i',strtotime($info->date_time));
            //         $info->subject = "Notification";
            //         $info->filepath = "";
            //     }
            //     $db_data[] = $info;
            // }
            // log_message('debug', 'db_data-->' . print_r($db_data, true));
            
            $data = json_encode($db_data);
        echo $data;
    }

    public function viewNotificationFeed(){
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);
        $term_name=$obj['term_name'];
        $section_name=$obj['section_name'];
        $student_id = $obj['user_id'];
        $stream_name = $obj['stream_name'];
        $row_id = $obj['row_id'];

        
        
        $studentInfo = $this->student_model->getStudentInfoByRowId($row_id);

        $absentInfo= $this->student_model->getabsentfeedDetails($studentInfo->student_id);
        $notifications = $this->student_model->getStudentfeedNotifications($studentInfo->term_name,$studentInfo->section_name,$studentInfo->stream_name);
        $homeworkInfo = $this->push_notification_model->getStudentHomeworkfeedApi($studentInfo->term_name,$studentInfo->stream_name,$studentInfo->section_name);
        
        
        $bulkNotifications = $this->push_notification_model->getStudentfeedBulkNotificationsApi($studentInfo->student_id);        
        $db_data = $data1= $data2 = $data3 = $data4 =array();
        foreach($notifications as $info){
                $info->date_time =$info->date_time;
                $info->view='school';               
                $data1[] = $info;
            }
        foreach($absentInfo as $info){
        $info->subject = 'Absent';    
        $info->message = 'Your ward '.$info->student_name. ' is absent for ' .$info->name. ' class on ' .date('d-m-Y');
        $info->view='';
        $info->date_time='';
        $data2[] = $info;
         }
         foreach($bulkNotifications as $info){
            $info->subject = 'Class notification';    
            $info->date_time =$info->updated_date_time;
            $info->view='bulk';               
            $data3[] = $info;
        }
        foreach($homeworkInfo as $info){
            // $info->subject = 'Homework';    
             //$info->message = $info->homework_discription;
             $info->message = 'New homework added for '. $info->subject;
             $info->date_time =$info->date_time;
             $info->view='homework';
           //  $info->date_time='';
             $data4[] = $info;
         }
         $db_data = array_merge($data1,$data2,$data3,$data4);
         usort($db_data,function ($element1,$element2) {
         $datetime1 = strtotime($element1->date_time);
         $datetime2 = strtotime($element2->date_time);
         return $datetime2 - $datetime1;
        });
      
         $data = json_encode($db_data);
        // log_message('debug','ff'.print_r($data,true));
         echo $data;
    
        }




        

    public function personalNotificationsApi(){
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);
        $student_id = $obj['student_id'];
        $row_id = $obj['row_id'];
        $studentInfo = $this->student_model->getStudentInfoByRowId($row_id);

        $bulkNotifications = $this->push_notification_model->getStudentBulkNotificationsApi($studentInfo->student_id); 
       
        $db_data = array();
        
    
            foreach($bulkNotifications as $info){
                if($info->active_date!=null){
                    $info->date_time =$info->updated_date_time;
                    $info->subject = "Class Notification";
                $info->type = "By Teacher";

                }
                $db_data[] = $info;
            } 
            
            $data = json_encode($db_data);
            
    
        echo $data;
    }
    



    
    //---------------STUDY MATERIAL--------------------
    public function viewstudyMaterials(){
        // $this->cors();
        $filter = array();
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);
        // $student = $this->student_model->getStudentInfoById($student_id,$term_name);

        $row_id = $obj['row_id'];
       // log_message('debug','student_id==>'.$row_id);
       
        $date = $obj['filter_date'];
        $filter_type = $obj['filter_type'];
        $filter_subject= $obj['filter_subject'];
        $formattedDate = date('Y-m-d', strtotime($date));

        if($filter_type=='All'){
            $formattedDate='';
        }
    

        if($formattedDate=='1970-01-01'){
            $formattedDate='';
        }
        $student = $this->student_model->getStudentInfoByRowId($row_id);
      //  log_message('debug','studyMaterials student ==>'.print_r($student,true));

        $filter['term_name'] = $student->term_name;
        $filter['section_name'] = $student->section_name;
        $filter['stream_name'] = $student->stream_name;
        log_message('debug','filter info==>'.print_r($filter,true));

        $studyMaterialInfo = $this->studymaterial_model->getStudyMaterial($filter,$formattedDate,$filter_type,$filter_subject);
        log_message('debug','studyMaterials info==>'.print_r($studyMaterialInfo,true));
        $db_data = array();
        // foreach($studyMaterialInfo as $info){
        //     if($info->created_date_time!=null){
        //         $info->created_date_time =date('d-m-Y h:i A',strtotime($info->created_date_time));
        //     }
        //     $db_data[] = $info;
        // }
        $data = json_encode($studyMaterialInfo);
       // log_message('debug','studyMaterials data==>'.print_r($data,true));
        echo $data;
    }



    public function viewYoutubeVideos(){

        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);
        $student_id = $obj['student_id'];
        $term_name = $obj['term_name'];
        $stream_name = $obj['stream_name'];
        $filter['stream_name'] = $stream_name;
        $filter['stream_name1'] = 'ALL';

        $filter['term_name'] = $term_name;

        $videoInfo = $this->studymaterial_model->getYoutubeLink($filter);
        $data = json_encode($videoInfo);
        echo $data;
    }

    //----------NEWS FEED---------
    public function viewNewsFeed(){
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);
        $term_name = $obj['term_name'];
        $userId = $obj['user_id'];
        $filter = array();
        $filter['role'] = 'Student';
        $filter['role_one'] = 'ALL';
        $filter['term_name'] = $term_name;
        $newsInfo = '';//$this->student_model->getNewsFeed($filter);
        // foreach($newsInfo as $news){
        //     if($news->date!=null){
        //         $news->date=date('d-m-Y h:i A',strtotime($news->date));
        //     }
        //     $news->isLiked=$this->student_model->isLiked($news->row_id,$userId);
        //     $news->totalLikes=$this->student_model->totalLikes($news->row_id);
        // }
        $data = json_encode($newsInfo);
        echo $data;
    }

    //----------EXAM----------
    public function examPerformance(){
        // $json = file_get_contents('php://input'); 
        // $obj = json_decode($json,true);
        // $termName = $obj['term_name'];
        // $student_id = $obj['user_id'];
        //$app = $_GET['app_name'];
        $row_id =$_GET['id'];
        $student= $this->student_model->getStudentInfoByRowId($row_id);
        $term_name = $student->term_name;
        $exam_mark_first_test = array();
        $exam_mark_second_test = array();
        $exam_mark_first_term = array();
        $exam_mark_mid_term = array();
        $exam_mark_first_preparatory = array();
        $subject_names = array();
        $filter['stream_name'] = $student->stream_name;
        if($student->section_name != ''){
            $filter['section_name'] = $student->section_name;
        }else{
            $filter['section_name'] = 'ALL';
        }
        $filter['subject_type'] = 'THEORY';

        $filter['term_name'] = $student->term_name; 
        $filter['fee_year'] = CURRENT_YEAR;
        $subjects_code = array();
        $elective_sub = strtoupper($student->elective_sub);
        if($elective_sub == "KANNADA"){
            array_push($subjects_code, '1');
        }else if($elective_sub == 'HINDI'){
            array_push($subjects_code, '3');
        } else if($elective_sub == 'FRENCH'){
            array_push($subjects_code, '12');
        }else if($elective_sub == 'URDU'){
            array_push($subjects_code, '08');
        }else{
            array_push($subject_mark_chart,0);
            array_push($subject_names, 'EXM');
        }
        array_push($subjects_code, '2');
                $subjects = $this->getSubjectCodes($student->stream_name);
                $subjects_code = array_merge($subjects_code,$subjects);
                for($i=0;$i<count($subjects_code);$i++){
                    $getMarkOfFirstUnitTest = $this->student_model->getFirstInternaltMark($student->student_id,$subjects_code[$i]);
                    // log_message('debug','mark'.print_r($getMarkOfFirstUnitTest,true));
                    $exam_mark_first_test[$i] = $getMarkOfFirstUnitTest;

                    $getMarkOfFirstClassTest = $this->student_model->getFirstClassTesttMark($student->student_id,$subjects_code[$i]);
                    $exam_mark_first_class_test[$i] = $getMarkOfFirstClassTest;
    
                    // $getMarkOfFirstTermExam = $this->student->getFirstTermMark($student->student_id,$subjects_code[$i]);
                    // $exam_mark_first_term[$i] = $getMarkOfFirstTermExam;
    
                    $getMarkOfmidTermExam = $this->student_model->getMidTermMark($student->student_id,$subjects_code[$i]); 
                    // log_message('debug','FFF'.print_r($getMarkOfmidTermExam,true));
                    $exam_mark_mid_term[$i] = $getMarkOfmidTermExam;
                 
                    $getMarkOfSecondUnitTest = $this->student_model->getSecondInternalMark($student->student_id,$subjects_code[$i]);
                    $exam_mark_second_test[$i] = $getMarkOfSecondUnitTest;
                    
                    $getFirstPreparatoryMark = $this->student_model->getFirstPreparatoryMark($student->student_id,$subjects_code[$i]); 
                    $exam_mark_first_preparatory[$i] = $getFirstPreparatoryMark;
    
                    $getAnnuakMark = $this->student_model->getAnnualExamMark($student->student_id,$subjects_code[$i]); 
                    $exam_mark_annual[$i] = $getAnnuakMark;
                    
                    $subject_name[$i] =  $this->student_model->getExamSubjectInfo($subjects_code[$i]);
                }
                $exam_type = 'Final Exam';
            $data['studentsMarks'] = $this->student_model->getFullMarksOfStudentInternal($student->student_id, $exam_type);  
             $data['firstUnitTestMarkInfo'] = $exam_mark_first_test;
            // $data['firstTermMarkInfo'] = $exam_mark_first_term;
            $data['firstClassTestMarkInfo'] = $exam_mark_first_class_test;
             $data['midTermMarkInfo'] = $exam_mark_mid_term;
             $data['secondUnitTestMarkInfo'] = $exam_mark_second_test;
             $data['firstPreparatoryMarkInfo'] = $exam_mark_first_preparatory;
             $data['annualMarkInfo'] = $exam_mark_annual;
             $data['subject_code'] = $subjects_code;
            $data['subject_name'] = $subject_names;
             $data['studentInfo'] = $student;
             $this->global['pageTitle'] = ''.TAB_TITLE.' : My Performance' ;
             $this->load->view("student/performanceApp",$data);

    }

    public function testPerformance(){
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);
        $rel_stud_id = $obj['row_id'];
        $data = $this->performance_model->getTestMarkInfo($rel_stud_id);
        echo json_encode($data);
    }

    //--------FEE PAYMENT---------
    //Paytm Token
    

   
    


    //FEE payment Info
    function overAllFeePaidInfo(){
        // $this->cors();
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);
        $studentRowId = $obj['row_id'];
        $stud = $this->student_model->getStudentInfoByRowId($studentRowId);

        $student_year=FEE_YEAR;

        $feeoverall = $this->fee->getFeePaidInfo($studentRowId,$student_year);

       

        // $govtFeePaid = $this->fee_model->getoverallGovtFeePaidInfo($studentRowId,$student_year);

       

        // $db_data = $data1 = $data2 = array();
    
        // foreach ($feeoverall as $fee) {
        //     $info = new stdClass(); // Create a new instance of stdClass
        //     $info->receipt_number = $fee->receipt_number;
        //     $info->payment_date = $fee->payment_date;
        //     $info->payment_type = $fee->payment_type;
        //     $info->paid_amount = $fee->paid_amount;
        //     $data1[] = $info;
        // }
    
        // foreach ($govtFeePaid as $fee) {
        //     $info = new stdClass(); // Create a new instance of stdClass
        //     $info->receipt_number = $fee->receipt_number;
        //     $info->payment_date = $fee->payment_date;
        //     $info->payment_type = $fee->payment_type;
        //     $info->paid_amount = $fee->paid_amount;
        //     $data2[] = $info;
        // }
    
        // $db_data = array_merge($data1, $data2);
    
        // usort($db_data, function ($element1, $element2) {
        //     $datetime1 = strtotime($element1->payment_date);
        //     $datetime2 = strtotime($element2->payment_date); // Change this to payment_date
        //     return $datetime2 - $datetime1;
        // });
        
        echo json_encode($feeoverall);       
    }
    public function feePaymentReceiptPrint() {
        $row_id = $_GET['row_id'];
        $filter = [];
        $data['feeInfo']  = $this->fee->getFeeInfoByReceiptNum($row_id);
        $studentInfo      = $this->student_model->getStudentInfoByRowId($data['feeInfo']->application_no);
        $filter['fee_year']    = $data['feeInfo']->payment_year;
        $filter['stream_name'] = $studentInfo->stream_name;
        $filter['term_name']   = $data['feeInfo']->term_name;
        $filter['gender'] = $studentInfo->gender;
        /* ── Government fees ──────────────────────────────────────────── */
        $allGovFees      = $this->fee->getGovrnmentFeeStructureInfo($filter);
        $govTotal        = 0.0;
        $govPaidAmount   = 0.0;
        $govFeesWithPaid = [];          // only fees that were actually paid
        
        $data['fee_model'] = $this->fee;
        
        $data['row_id']         = $row_id;
        $data['studentInfo']    = $studentInfo;
        $data['concession_amount'] = $this->fee->getFeeConcessionByAppNo(
            $data['feeInfo']->application_no,
            $filter['fee_year']
        );
        $data['paidFeeSum'] = $this->fee->getSumOfFeesPaid(
            $data['feeInfo']->application_no,
            $data['feeInfo']->payment_year
        );
        $data['staffName'] = $this->fee->getStaffNameById($data['feeInfo']->created_by);
        $data['paid_amount_words'] = $this->getIndianCurrency($data['feeInfo']->paid_amount);
        $data['previousFeePaidInfo'] = $this->fee->getPreviousFeesPaidInfo(
            $row_id,
            $data['feeInfo']->application_no,
            $data['feeInfo']->payment_year
        );
        /* ── Generate PDF ─────────────────────────────────────────────── */
        $this->global['pageTitle'] = TAB_TITLE . ' : Fee Receipt';
        $mpdf = new \Mpdf\Mpdf([
            'default_font' => 'timesnewroman',
            'format'       => 'A5',
        ]);
        $mpdf->AddPage('P', '', '', '', '', 4, 4, 4, 4, 6, 6);
        $mpdf->SetTitle('Fee Receipt');
        $html = $this->load->view('fee_management/feeReceiptPrint', $data, true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Fee_Receipt.pdf', 'I');
    }
    
    //FEE payment display
    public function viewFeePaymentInfo(){	
        // $this->cors();
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);
        $application_no = $obj['row_id'];
        

	    $requestParamList = array();
	    $responseParamList = array();
        $studentInfo = $this->student_model->getStudentInfoByRowId($application_no);
       

        $dt = array();
        $data = (object)$dt;
        $filter = array(); 
        $filter['fee_year'] = trim($studentInfo->intake_year_id);
        $term_name = $studentInfo->term_name;
        $filter['stream_name'] = $studentInfo->stream_name;
        $filter['gender'] = $studentInfo->gender;
        $filter['student_fee_type'] = 'REG';
        if($term_name == 'I PUC'){

            $filter['term_name'] = $term_name;
            $filter['fee_year'] = $studentInfo->intake_year_id;
            $total_fee_obj = $this->fee->getTotalFeeAmount($filter);
            $govt_fee = $this->fee->getGovtFeeAmount($filter);
            $category_fee = 0;
            $total_fee_amount = $total_fee_obj->total_fee + $govt_fee + $category_fee;
            $data->total_fee_amount = ($total_fee_obj->total_fee + $govt_fee + $category_fee);
            $concession_amt = $this->fee->getFeeConcessionByAppNo($application_no,$filter['fee_year']);
            $data->concession = $concession_amt;
            $paidFee = $this->fee->getTotalFeePaidInfo($application_no,$filter['fee_year']);
            $data->paid_amount = $paidFee;
            $total_fee_amount -= $paidFee;
            $data->pending_amount = $total_fee_amount - $concession_amt;
            
        }else{                
            $filter['stream_name'] = $studentInfo->stream_name;
            $filter['term_name'] = 'II PUC';
            if($studentInfo->intake_year_id == FEE_YEAR){
                    $filter['student_fee_type'] = 'NEW';
                    $filter['fee_year'] = trim($studentInfo->intake_year_id);
            }else{
                $filter['student_fee_type'] = 'REG';
                $filter['fee_year'] = trim($studentInfo->intake_year_id)+1;
            }
            $total_fee_obj = $this->fee->getTotalFeeAmount($filter);
            $govt_fee = $this->fee->getGovtFeeAmount($filter);
            $total_fee_amount = $total_fee_obj->total_fee + $govt_fee;
            $data->total_fee_amount =  $total_fee_obj->total_fee + $govt_fee;

            $concession_amt = $this->fee->getFeeConcessionByAppNo($application_no,$filter['fee_year']);
            $data->concession = $concession_amt;
            $paidFee = $this->fee->getTotalFeePaidInfo($application_no,$filter['fee_year']);
            $total_fee_amount -= $paidFee;
            $data->paid_amount = $paidFee;
            $data->pending_amount = $total_fee_amount - $concession_amt;
        }
            $installment_info = $this->fee->checkInstalmentExists($application_no);
        // if(!empty($installment_info)){
        //     $data->instalment_amt = $installment_info->amount;
        //     $data->instalment_status = true;
        // }else{
        //     $data->instalment_amt = '';
        //     $data->instalment_status = false;
        // }
        $totalAmount = $data->total_fee_amount;
        $paidAmount = $data->paid_amount;

        $firstInstallment = $totalAmount * 0.5;
        $secondInstallment = $firstInstallment * 0.5;
        $feeoverall = $this->fee->getFeePaidInfo($application_no, $filter['fee_year']);

        $isStaffPayment = false;

        if (!empty($feeoverall)) {
            foreach ($feeoverall as $row) {
                if (isset($row->staff_payment) && $row->staff_payment == 1) {
                    $isStaffPayment = true;
                    break;
                }
            }
        }

        if ($isStaffPayment) {
            $data->instalment_amt = 0;
            // $data->instalment_type = 'COMPLETED';
            $data->instalment_status = false;

        } else {
            if(!empty($installment_info)){
                $data->instalment_amt = $installment_info->amount;
                $data->instalment_status = true;

            }
            else if ($paidAmount <= 0) {
                $data->instalment_amt = $firstInstallment;
                // $data->instalment_type = 'FIRST';
                $data->instalment_status = true;

            } else if ($paidAmount < $firstInstallment) {

                $data->instalment_amt = $firstInstallment - $paidAmount;
                // $data->instalment_type = 'FIRST_PENDING';
                $data->instalment_status = true;

            } else if ($paidAmount >= $firstInstallment && $paidAmount < ($firstInstallment + $secondInstallment)) {

                $remainingSecond = ($firstInstallment + $secondInstallment) - $paidAmount;

                $data->instalment_amt = $remainingSecond;
                // $data->instalment_type = 'SECOND';
                $data->instalment_status = true;

            } else {

                $data->instalment_amt = 0;
                // $data->instalment_type = 'COMPLETED';
                $data->instalment_status = false;
            }
        }
        $data->app_eb_mode = APP_EB_MODE;
        $data->pay_button = '1';
        $data->studentInfo = $studentInfo;
        echo json_encode($data);
   }
   function ebToken(){
        // $this->cors();
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);
        $studentRowId = $obj['row_id'];
        $application_no =  $obj['row_id'];
        $fee_pay_type = $obj['pay_type'];
        $installment_amount = $obj['amount'];

        $studentInfo = $this->student_model->getStudentInfoByRowId($application_no);
        $dt = array();
        $data = (object)$dt;
        $filter = array(); 
         $filter['fee_year'] = trim($studentInfo->intake_year_id);
                $term_name = $studentInfo->term_name;

               $filter['stream_name'] = $studentInfo->stream_name;
                $filter['gender'] = $studentInfo->gender;
            $filter['student_fee_type'] = 'REG';
               
               

                if($term_name == 'I PUC'){

                    $filter['term_name'] = $term_name;
                    $filter['fee_year'] = $studentInfo->intake_year_id;
                    //  if(empty($studentInfo->student_category)){
                    //     $filter['student_category'] = 'Regular';
                    // } else {
                    //     $filter['student_category'] = $studentInfo->student_category;
                    // }
                    $total_fee_obj = $this->fee->getTotalFeeAmount($filter);
                    $govt_fee = $this->fee->getGovtFeeAmount($filter);
                    $category_fee = 0;

                    // if($filter['student_category'] != 'Regular'){
                    //     $category_fee = $this->fee->getCategoryFeeAmount($filter);
                    // }
                    $total_fee_amount = $total_fee_obj->total_fee + $govt_fee + $category_fee;
                    $concession_amt = $this->fee->getFeeConcessionByAppNo($application_no,$filter['fee_year']);
                    $paidFee = $this->fee->getTotalFeePaidInfo($application_no,$filter['fee_year']);
                    $total_fee_amount -= $paidFee;
                    $total_fee = $total_fee_amount - $concession_amt;

                  
                }else{                
                         
                    $filter['stream_name'] = $studentInfo->stream_name;
                    $filter['term_name'] = 'II PUC';
                    if($studentInfo->intake_year_id == FEE_YEAR){
                        $filter['student_fee_type'] = 'NEW';
                         $filter['fee_year'] = trim($studentInfo->intake_year_id);
                    }else{
                        $filter['student_fee_type'] = 'REG';
                        $filter['fee_year'] = trim($studentInfo->intake_year_id)+1;
                    }
                    $total_fee_obj = $this->fee->getTotalFeeAmount($filter);
                    $govt_fee = $this->fee->getGovtFeeAmount($filter);
                    $total_fee_amount = $total_fee_obj->total_fee + $govt_fee;

                    $concession_amt = $this->fee->getFeeConcessionByAppNo($application_no,$filter['fee_year']);
                   $paidFee = $this->fee->getTotalFeePaidInfo($application_no,$filter['fee_year']);
                   $total_fee_amount -= $paidFee;
                   $total_fee = $total_fee_amount - $concession_amt;

                }
                 
                
        if($fee_pay_type == 'INSTALMENT_PAYMENT'){
            //    $installment_info = $this->fee->checkInstalmentExists($application_no);
                $total_fee_amount_pending = $installment_amount;
        }else{
            $total_fee_amount_pending = $total_fee;
        }
        
     //log_message('debug','studentInfo--->'.print_r($studentInfo,true));
        $fee_amount = $total_fee_amount_pending;

        $paramList = array();
        $TXN_AMOUNT = $fee_amount;
        $CONTRIBUTION_FEE = 0;
        $SCHOOL_AMOUNT = 0;
        $feeStructInfo = $this->fee->getTotalFeeAccountAmount($filter);
        // log_message('debug', 'feeStructInfo: ' . print_r($feeStructInfo, true));
            $remaining_fee_amt = $TXN_AMOUNT;
            $fee_names = [];
            foreach($feeStructInfo as $fee){
                        $db_save_status = false;
                        $fee_structure_amt = $fee->fee_amount_state_board;

                        $structure_total = (float)$fee->fee_amount_state_board;
                        if($structure_total < 0){
                            $structure_total = 0;
                        }
                        // initialize values
                        $paid_amt = 0;
                        $pending_amt = 0;
                        $fee_pending_status = 1;
                        $db_save_status = false;
                        // already paid info
                        $AlreadyPaidInfo = $this->fee->checkFeeTypeTotalPaid($application_no, $fee->fee_division_id);
                        if(!empty($AlreadyPaidInfo->total_paid)){
                            $already_paid_total =  (float)$AlreadyPaidInfo->total_paid; 
                        }else{
                            $already_paid_total =  0; 
                        }
                        // calculate actual pending
                        $pending_balance = $structure_total - $already_paid_total;

                        if($pending_balance < 0){
                            $pending_balance = 0;
                        }
                        if($remaining_fee_amt > 0 && $pending_balance > 0){
                            // amount to pay now
                            $paid_amt = min($remaining_fee_amt, $pending_balance);
                            // remaining pending after this payment
                            $pending_amt = $pending_balance - $paid_amt;
                            // pending status
                            if(!empty($pending_amt > 0)){
                                $fee_pending_status =  1; 
                            }else{
                                $fee_pending_status =  0; 
                            }
                            // reduce remaining amount
                            $remaining_fee_amt -= $paid_amt;
                            $db_save_status = true;
                        }

                // if (!in_array($fee->fee_name, $fee_names)) {
                //     $fee_names[] = $fee->fee_name;
                // }

                if (trim($fee->fee_type_name) == 'Contribution Fees') {
                    // log_message('debug', 'Annual Day Charges: ' . $paid_amt);
                    $CONTRIBUTION_FEE += $paid_amt;
                    // $SCHOOL_AMOUNT += $paid_amt;
                } else {
                    $SCHOOL_AMOUNT += $paid_amt;
                }
            }
        
        $payInfo = array(
            'm_id' => EB_MERCHANT_KEY,
            'registered_tbl_row_id' => $studentRowId,
            'payment_status' =>'PENDING',
            'amount' => $TXN_AMOUNT,
            'application_no' => $studentRowId,
            'created_by' => $studentRowId,
            'year' => $filter['fee_year'],
            'created_date_time' => date('Y-m-d H:i:s'));
        $response = $this->fee->addFeePaymentLog($payInfo);
        

        $microtime = microtime(true);
        $currentDate = date('Ymd'); // Format current date as YYYYMMDD
 
        // Extract minutes, seconds, and milliseconds
        $minutes = (int)date('i', $microtime);
        $seconds = (int)date('s', $microtime);
        $milliseconds = (int)(($microtime - floor($microtime)) * 1000);
 
        // Combine current date, minutes, seconds, and milliseconds into a single string
        $timeString = sprintf('%s%02d%02d%03d', $currentDate, $minutes, $seconds, $milliseconds);

        if($response > 0){
            $ORDER_ID = '26FEE_'.$timeString.$response;
            $payInfo = array(
                'order_id' =>$ORDER_ID);
            $this->fee->updateFeePaymentLog($response,$payInfo);
            $_SESSION['order_id'] = $ORDER_ID;
        }

        $paytmParams = array();
        $TXN_AMOUNT = $fee_amount;

        $key = EB_MERCHANT_KEY;
        $txnId = $ORDER_ID;
        $amount = $fee_amount.'.00';
        $productInfo = 'FEE PAYMENT';
        $firstName = $studentInfo->student_name;
        $firstName = preg_replace("/[^a-zA-Z0-9\s]/", "", $firstName);
        $firstName = str_replace(' ', '', $firstName);  // Remove spaces
        //$email = $studentInfo->email;
        $salt = EB_SALT;

        if (!empty($studentInfo->father_mobile)) {
            $phone = $studentInfo->father_mobile;
        } else if(!empty($studentInfo->mother_mobile)) {
            $phone = $studentInfo->mother_mobile;
        }else{
            $phone = '9999999999';
        }

        // if(!empty($studentInfo->email)){
        //     $email=$studentInfo->email;
        // }else{
            $cleaned_student_name = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($studentInfo->student_name));
            // Create email using the cleaned student name
            
            $email = $cleaned_student_name . '@parrophins.com';
            //$email=$studentInfo->student_name.'@parrophins.com';
      //  }
        
        if($response > 0){
            $loginfophonEmail = array(
                'phone' => $phone,
                'email' => $email
            );
            $this->fee->updateFeePaymentLog($response,$loginfophonEmail);

        }

        $data = "$key|$txnId|$amount|$productInfo|$firstName|$email|||||||||||$salt";

        //  log_message('debug','data'.print_r($data,true));

        // Generate the hash using SHA-512 algorithm
        $hash = hash('sha512', $data);
        // log_message('debug','hash'.print_r($hash,true));
        log_message('debug', 'CONTRIBUTION_FEE: ' . $CONTRIBUTION_FEE);
        log_message('debug', 'SCHOOL_AMOUNT: ' . $SCHOOL_AMOUNT);
        $splitPayments = [
            'SOCIETY ACCOUNT'=> $CONTRIBUTION_FEE,
            'COLLEGE ACCOUNT'=> $SCHOOL_AMOUNT];
        $split_payments_json = json_encode($splitPayments);
        if(APP_EB_MODE == 'test'){
            $requestData = [
                'key' => $key,
                'txnid' => $txnId,
                'amount' => $amount,
                'productinfo' => $productInfo,
                'firstname' => $firstName,
                'phone' => $phone,
                'email' => $email,
                'surl' => 'http://localhost/php-kit/response.php',
                'furl' => 'http://localhost/php-kit/response.php',
                'hash' => $hash,
                // 'split_payments' => $split_payments_json,
            ];

        }else{
            $requestData = [
                'key' => $key,
                'txnid' => $txnId,
                'amount' => $amount,
                'productinfo' => $productInfo,
                'firstname' => $firstName,
                'phone' => $phone,
                'email' => $email,
                'surl' => 'http://localhost/php-kit/response.php',
                'furl' => 'http://localhost/php-kit/response.php',
                'hash' => $hash,
                'split_payments' => $split_payments_json,
            ];
        }



        // Convert request data to URL-encoded query string
        $postData = http_build_query($requestData);

        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt(
            $ch,
            CURLOPT_URL,
            EB_LINK
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);

        // Execute cURL request
        $response = curl_exec($ch);
        // log_message('debug','response-->'.print_r($response,true));
        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        } else {
            // Decode and print response
            $responseData = json_decode($response, true);
            
        //    log_message('debug','responseData'.print_r($responseData,true));

            print_r($responseData);
        }
        // Close cURL session
        curl_close($ch);

        echo json_encode($responseData);

        
      
    }
     function convertUTCtoIST($utcDate) {
        // Create a DateTime object with the UTC date
        $date = new DateTime($utcDate, new DateTimeZone('UTC'));
        
        // Convert it to IST timezone
        $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
        
        // Format it to Y-m-d and return
        return $date->format('Y-m-d');
    }

    //FEE payment Response
    public function feePaymentResponse(){
        // $this->cors();
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);
        // $term_name = $obj['term_name'];
        $studentRowId = $obj['row_id'];
        $student_row_id = $obj['row_id'];
        $application_no = $obj['row_id'];
        // $amount = $obj['amount'];
        $response = $obj['payment_response'];
        // log_message('debug','response-->'.print_r($response,true));
        $studentInfo = $this->student_model->getStudentInfoByRowId($application_no);

        $filter = array();
        
                // log_message('debug','filter---->'.print_r($filter,true));

        if($response['status'] == "success"){ 
            $isExistOrderID = $this->fee->checkOrderIdExistsInFeePayment($response['txnid']);
            if(empty($isExistOrderID)){ 
                $paid_fee_amount = $response['amount'];
                
                 $filter['fee_year'] = $studentInfo->intake_year_id;
                $filter['student_fee_type'] = 'REG';
                $term_name = $studentInfo->term_name;
           

            if($term_name == 'II PUC'){
                if($studentInfo->intake_year_id == FEE_YEAR){
                    $filter['student_fee_type'] = 'NEW';
                    $filter['fee_year'] = trim($studentInfo->intake_year_id);
                }else{
                    $filter['student_fee_type'] = 'REG';
                    $filter['fee_year'] = trim($studentInfo->intake_year_id)+1;
                }
            }
            $filter['term_name'] = $term_name;
            $filter['stream_name'] = $studentInfo->stream_name;
            $filter['gender'] = $studentInfo->gender;
            // if(empty($studentInfo->student_category)){
            //         $filter['student_category'] = 'Regular';
            //     } else {
            //         $filter['student_category'] = $studentInfo->student_category;
            //     }

            
                
            //     $filter['term_name'] = $term_name;
            //     $filter['stream_name'] = $studentInfo->stream_name;
            
               
                // log_message('debug','filter='.print_r($filter,true));
                $total_fee = $this->fee->getTotalFeeAmount($filter);
                $depart_fee = $this->fee->getGovtFeeAmount($filter);
                $category_fee = 0;

                // if($filter['student_category'] != 'Regular'){
                //     $category_fee = $this->fee->getCategoryFeeAmount($filter);
                //     // $data['category_fee'] = $category_fee;
                // }
                // $feeStructureInfo = $this->fee->getFeeStructureInfo($filter);
                $total_fee_to_pay = $total_fee->total_fee + $depart_fee + $category_fee; //- $depart_fee;
                // log_message('debug','total_fee_to_pay='.print_r($total_fee_to_pay,true));
                $data['feePaidInfo'] = $this->fee->getFeePaidInfo($application_no,$filter['fee_year']);
                if(!empty($data['feePaidInfo'])){
                    foreach($data['feePaidInfo'] as $fee){
                        $total_fee_to_pay = $total_fee_to_pay - $fee->paid_amount;
                    }
                }
                $concession = 0; 
                $concession_amt = $this->fee->getFeeConcessionByAppNo($application_no,$filter['fee_year']);
                if($concession_amt>0){
                    $concession = $concession_amt;
                    $total_fee_to_pay -= $concession;
                }

                $remaining_fee_amt = $paid_fee_amount;
                $feePaymentInfo = $this->fee->getStdLastPaidDetailsByApplicationNo($application_no,$filter['fee_year']);
                if(empty($feePaymentInfo)){
                    $paid_count = 1;
                    //$paid_fee_amount -= $depart_fee;
                }else{
                    $paid_count = $feePaymentInfo->payment_count+1;
                }

                $pending_fee_balance = $total_fee_to_pay - $paid_fee_amount;
                if($pending_fee_balance <= 0){
                    $fee_excess_amount = abs($pending_fee_balance);
                    $fee_pending_status = 0;
                    $pending_fee_balance = 0;
                }else if($pending_fee_balance > 0){
                    $fee_excess_amount = 0;
                    $fee_pending_status = 1;
                }

                $lastReceiptInfo = $this->fee->getLastReceiptNo($filter['fee_year']);
                if(!empty($lastReceiptInfo->receipt_number)){
                    $receipt_no_new = $lastReceiptInfo->receipt_number + 1;
                }else{
                    $receipt_no_new = 1;
                }
                $receipt_no_new = sprintf('%04d',$receipt_no_new);
                $receipt_no = substr((string)$filter['fee_year'], -2) . 'T' . $receipt_no_new;

                $overallFee = array(
                    'application_no' => $application_no,
                    'receipt_number' => $receipt_no_new,
                    'payment_type' => 'ONLINE',
                    'payment_date' =>  $this->convertUTCtoIST($response['addedon']),
                    'total_amount' => $total_fee_to_pay,
                    'paid_amount' => $paid_fee_amount,
                    'excess_amount' => $fee_excess_amount,
                    'fee_concession' => $concession,
                    'pending_balance' => abs($pending_fee_balance),
                    'fee_pending_status' => $fee_pending_status,
                    'payment_count' => $paid_count,
                    'payment_year' => $filter['fee_year'],
                    'term_name' => $term_name,

                    'order_id' => $response['txnid'],

                    'created_by' => 'schoolphins-app',
                    'created_date_time' => date('Y-m-d H:i:s'));
                    $fee_year= $filter['fee_year'];
                    $overall_row_id = $this->fee->addFeeDetailsNewAdmission($overallFee);

                    $remaining_fee_amt = $paid_fee_amount;

                    $feeStructureInfo = $this->fee->getAllFeeStructureInfoForReceipt($filter);
                    foreach($feeStructureInfo as $fee){
                        $db_save_status = false;
                        $fee_structure_amt = $fee->fee_amount_state_board;
                        //     $isAlreadyPaid = $this->fee->checkFeeTypeIsAlreadyPaid($application_no,$fee->row_id);
                        //     if($remaining_fee_amt >= 0){
                        //         if(!empty($isAlreadyPaid)){
                        //             if($isAlreadyPaid->pending_status == 1){
                        //                 $remaining_fee_amt -= $isAlreadyPaid->pending_amt;
                        //                 if($remaining_fee_amt >= 0){
                        //                     //$pending_amount = 0;
                        //                     $paid_amt = $isAlreadyPaid->pending_amt;
                        //                     $pending_amt = 0;
                        //                     $fee_pending_status = 0;
                        //                 } else {
                        //                     //$dd_amount = 0; 
                        //                     $paid_amt = $isAlreadyPaid->pending_amt - abs($remaining_fee_amt);
                        //                     $pending_amt = $isAlreadyPaid->pending_amt - $paid_amt;
                        //                     $fee_pending_status = 1;
                        //                 } 
                        //                 $db_save_status = true;
                        //             }
                        //         }else{
                        //             $remaining_fee_amt -= $fee_structure_amt;
                        //             if($remaining_fee_amt >= 0){
                        //                 //$pending_amount = 0;
                        //                 $paid_amt = $fee_structure_amt;
                        //                 $pending_amt = 0;
                        //                 $fee_pending_status = 0;
                        //             } else {
                        //                 //$dd_amount = 0; 
                        //                 $paid_amt = $fee_structure_amt - abs($remaining_fee_amt);
                        //                 $pending_amt = $fee_structure_amt - $paid_amt;
                        //                 $fee_pending_status = 1;
                        //             } 
                        //             $db_save_status = true;
                        //         }
                        //     }else{
                        //         if(empty($isAlreadyPaid)){
                        //         $pending_amt = $fee_structure_amt;
                        //         $paid_amt = 0;
                        //         $fee_pending_status = 1;
                        //         $db_save_status = true;
                        //         }
                        //     }

                        $structure_total = (float)$fee->fee_amount_state_board;
                        if($structure_total < 0){
                            $structure_total = 0;
                        }
                        // initialize values
                        $paid_amt = 0;
                        $pending_amt = 0;
                        $fee_pending_status = 1;
                        $db_save_status = false;
                        // already paid info
                        $AlreadyPaidInfo = $this->fee->checkFeeTypeTotalPaid($application_no, $fee->fee_division_id);
                        if(!empty($AlreadyPaidInfo->total_paid)){
                            $already_paid_total =  (float)$AlreadyPaidInfo->total_paid; 
                        }else{
                            $already_paid_total =  0; 
                        }
                        // calculate actual pending
                        $pending_balance = $structure_total - $already_paid_total;

                        if($pending_balance < 0){
                            $pending_balance = 0;
                        }
                        if($remaining_fee_amt > 0 && $pending_balance > 0){
                            // amount to pay now
                            $paid_amt = min($remaining_fee_amt, $pending_balance);
                            // remaining pending after this payment
                            $pending_amt = $pending_balance - $paid_amt;
                            // pending status
                            if(!empty($pending_amt > 0)){
                                $fee_pending_status =  1; 
                            }else{
                                $fee_pending_status =  0; 
                            }
                            // reduce remaining amount
                            $remaining_fee_amt -= $paid_amt;
                            $db_save_status = true;
                        }
                        if($db_save_status){
                            $receipt_number_for_fee = $receipt_no;
                            if((int)$fee->fee_division_id === 1){
                                $receipt_number_for_fee = $this->fee->getLastReceiptNoByFeeType($filter['fee_year'], $fee->fee_division_id);
                                // log_message('debug','receipt_number_for_fee='.print_r($receipt_number_for_fee,true));

                            }

                            $feeReceiptPayment = array(
                                'application_no' => $application_no,
                                'receipt_number' => $overall_row_id,
                                'receipt_no' => $receipt_number_for_fee, 
                                'payment_date' => $this->convertUTCtoIST($response['addedon']), 
                                'fee_type_id' => $fee->fee_division_id,
                                'fee_structure_id' => $fee->row_id,
                                'paid_amount' => $paid_amt,
                                'pending_amt' => $pending_amt,
                                'payment_year' => $filter['fee_year'],
                                'pending_status' => $fee_pending_status,
                                'school_account_id' => $fee->account_row_id,
                                'created_by' => 'schoolphins',
                                'fee_amount' => $fee_structure_amt,
                                'created_date_time' => date('Y-m-d H:i:s'));
                            $receipt_return_feeType = $this->fee->addReceiptFeeType($feeReceiptPayment);
                        }
                    }  

                    if(!empty($overall_row_id)){
                        $concessionAmt =  $this->fee->checkConsessionExists($application_no,$fee_year);
                        if(!empty($concessionAmt)){
                            $concessionInfo = array(
                                'payment_status'=>1,
                                // 'instalment_status'=>1,
                                'updated_by'=>$application_no,
                                'updated_date_time'=>date('Y-m-d H:i:s'));
                            $this->fee->updateConcessionById($concessionInfo, $concessionAmt->row_id);
                        }
                    
                    
                        $installmentAmt =  $this->fee->checkInstalmentExists($application_no);
                        log_message('debug','inst='.print_r($installmentAmt,true));
                        if(!empty($installmentAmt)){
                            $instllInfo = array(
                                'payment_status'=>1,
                                'receipt_number' => $receipt_no,
                                'updated_by'=>$application_no,
                                'updated_date_time'=>date('Y-m-d H:i:s'));
                            $this->fee->updateInstalmentById($instllInfo, $installmentAmt->row_id);
                        }
                        //  $studInfo = array(
                        //     'new_admission_status' => 1,
                        //     'updated_by' => $application_no,
                        //     'updated_date_time' => date('Y-m-d H:i:s'));
                        //     $return_stud = $this->fee->updateStudentInfoByID($studInfo,$application_no);
                        // if($term_name == 'I PUC'){
                        //    $url = 'http://192.168.1.206/LOURDES_SCHOOL/STAFF_PORTAL/mountcarmelEmail';

                        //     $postData = [
                        //         'student_name' => $studentInfo->student_name,
                        //         'email'        => $studentInfo->email,
                        //         'stream_name'  => $studentInfo->stream_name,
                        //         'father_name'  => $studentInfo->father_name,
                        //         'paid_amount'  => $paid_fee_amount
                        //     ];

                        //     $ch = curl_init($url);
                        //     curl_setopt($ch, CURLOPT_POST, true);
                        //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
                        //     curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']); 
                        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        //     $response = curl_exec($ch);
                        //     curl_close($ch);
                        // }


                }
                
                $payInfo = array(
                    'tran_id' =>$response['txnid'],
                    'tran_date' =>  $this->convertUTCtoIST($response['addedon']),
                    'amount' => $response['amount'],
                    'payment_mode'=>'ONLINE',
                    'payment_status'=>'SUCCESS',
                    'receipt_number' => $overall_row_id,
                    'pay_status' => 1);
                
                $msg = "success"; 

            }else{

                $payInfo = array(
                    'tran_id' =>$response['txnid'],
                    'tran_date' => $this->convertUTCtoIST($response['addedon']),
                    // 'amount' => $response['amount'],
                    'payment_mode'=>'ONLINE',
                    'payment_status'=>'PENDING',
                    'receipt_number' => $isExistOrderID->receipt_number,
                    'pay_status' => 1);

                // $data['payment_status'] = true;
                // $data['payment_done_now'] = true;
                $msg = "Transaction Failed";
            }
        } else {
            // $data['payment_status'] = false;
            // $data['payment_done_now'] = false;

            $payInfo = array(
                'tran_id' =>$response['txnid'],
                'tran_date' =>  $this->convertUTCtoIST($response['addedon']),
                // 'amount' => $response['amount'],
                'payment_mode'=>'ONLINE',
                'payment_status'=>'PENDING'
            );  
            $msg = "Transaction Failed";
        }
        // }
        $this->fee->updateFeePaymentLogOrderID($response['txnid'],$payInfo);
        echo json_encode($msg);
    }  
    public function bulkReprocess(){
        // $this->cors();
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);
        $msg ='success';
        $application_no = $obj['row_id'];
        $studentRowId = $obj['row_id'];
        $student_row_id = $obj['row_id'];

        $logInfo= $this->fee->getLogDetails($application_no);
        log_message('debug','logInfo->'.print_r($logInfo,true));


        foreach($logInfo as $info){

            $amount = $info->amount;
            $ORDER_ID = $info->order_id;
            // $feeType = $info->fee_type;
            $studentInfo = $this->student_model->getStudentInfoByRowId($application_no);

            $easebuzzObj = new Easebuzz(EB_MERCHANT_KEY, EB_SALT, EB_ENV);

            $email = $info->email;
            $phone = $info->phone;

          
    
                    
            $concatenated_string = EB_MERCHANT_KEY . "|" . $ORDER_ID. "|" . $amount. "|" . $email . "|" . $phone . "|" . EB_SALT;
                
            $hashed_value = hash('sha512', $concatenated_string);
                  
    
       
            $postData = array ( 
                "txnid" => $ORDER_ID,
                "amount" => $amount,
                "email" => $email,
                "phone" => $phone,
                "hash" => $hashed_value,
            );
            
            $responseParamList = $easebuzzObj->transactionAPI($postData);
                
            // Decode JSON string
            $response_array = json_decode($responseParamList, true);
            
            $response = $response_array['msg'];
         

            if($response['status'] == "success"){ 
                $isExistOrderID = $this->fee->checkOrderIdExistsInFeePayment($response['txnid']);
                if(empty($isExistOrderID)){ 
                $filter = array();
                $paid_fee_amount = $response['amount'];
                
                $filter['fee_year'] = $studentInfo->intake_year_id;
                $filter['student_fee_type'] = 'REG';
                $term_name = $studentInfo->term_name;
           

                if($term_name == 'II PUC'){
                    if($studentInfo->intake_year_id == FEE_YEAR){
                        $filter['student_fee_type'] = 'NEW';
                        $filter['fee_year'] = trim($studentInfo->intake_year_id);
                    }else{
                        $filter['student_fee_type'] = 'REG';
                        $filter['fee_year'] = trim($studentInfo->intake_year_id)+1;
                    }
                }
                $filter['term_name'] = $term_name;
                $filter['stream_name'] = $studentInfo->stream_name;
                $filter['gender'] = $studentInfo->gender;
            
               
                // log_message('debug','filter='.print_r($filter,true));
                $total_fee = $this->fee->getTotalFeeAmount($filter);
                $depart_fee = $this->fee->getGovtFeeAmount($filter);
                $category_fee = 0;

                // if($filter['student_category'] != 'Regular'){
                //     $category_fee = $this->fee->getCategoryFeeAmount($filter);
                //     // $data['category_fee'] = $category_fee;
                // }
                // $feeStructureInfo = $this->fee->getFeeStructureInfo($filter);
                $total_fee_to_pay = $total_fee->total_fee + $depart_fee + $category_fee; //- $depart_fee;
                // log_message('debug','total_fee_to_pay='.print_r($total_fee_to_pay,true));
                $data['feePaidInfo'] = $this->fee->getFeePaidInfo($application_no,$filter['fee_year']);
                if(!empty($data['feePaidInfo'])){
                    foreach($data['feePaidInfo'] as $fee){
                        $total_fee_to_pay = $total_fee_to_pay - $fee->paid_amount;
                    }
                }
                $concession = 0; 
                $concession_amt = $this->fee->getFeeConcessionByAppNo($application_no,$filter['fee_year']);
                if($concession_amt>0){
                    $concession = $concession_amt;
                    $total_fee_to_pay -= $concession;
                }

                $remaining_fee_amt = $paid_fee_amount;
                $feePaymentInfo = $this->fee->getStdLastPaidDetailsByApplicationNo($application_no,$filter['fee_year']);
                if(empty($feePaymentInfo)){
                    $paid_count = 1;
                    //$paid_fee_amount -= $depart_fee;
                }else{
                    $paid_count = $feePaymentInfo->payment_count+1;
                }

                $pending_fee_balance = $total_fee_to_pay - $paid_fee_amount;
                if($pending_fee_balance <= 0){
                    $fee_excess_amount = abs($pending_fee_balance);
                    $fee_pending_status = 0;
                    $pending_fee_balance = 0;
                }else if($pending_fee_balance > 0){
                    $fee_excess_amount = 0;
                    $fee_pending_status = 1;
                }

                $lastReceiptInfo = $this->fee->getLastReceiptNo($filter['fee_year']);
                if(!empty($lastReceiptInfo->receipt_number)){
                    $receipt_no_new = $lastReceiptInfo->receipt_number + 1;
                }else{
                    $receipt_no_new = 1;
                }
                $receipt_no_new = sprintf('%04d',$receipt_no_new);
                $receipt_no = substr((string)$filter['fee_year'], -2) . 'T' . $receipt_no_new;

                $overallFee = array(
                    'application_no' => $application_no,
                    'receipt_number' => $receipt_no_new,
                    'payment_type' => 'ONLINE',
                    'payment_date' =>  $this->convertUTCtoIST($response['addedon']),
                    'total_amount' => $total_fee_to_pay,
                    'paid_amount' => $paid_fee_amount,
                    'excess_amount' => $fee_excess_amount,
                    'fee_concession' => $concession,
                    'pending_balance' => abs($pending_fee_balance),
                    'fee_pending_status' => $fee_pending_status,
                    'payment_count' => $paid_count,
                    'payment_year' => $filter['fee_year'],
                    'term_name' => $term_name,

                    'order_id' => $response['txnid'],

                    'created_by' => 'schoolphins-app',
                    'created_date_time' => date('Y-m-d H:i:s'));
                    $fee_year= $filter['fee_year'];
                    $overall_row_id = $this->fee->addFeeDetailsNewAdmission($overallFee);

                    $remaining_fee_amt = $paid_fee_amount;

                    $feeStructureInfo = $this->fee->getAllFeeStructureInfoForReceipt($filter);
                    foreach($feeStructureInfo as $fee){
                        $db_save_status = false;
                        $fee_structure_amt = $fee->fee_amount_state_board;
                        //     $isAlreadyPaid = $this->fee->checkFeeTypeIsAlreadyPaid($application_no,$fee->row_id);
                        //     if($remaining_fee_amt >= 0){
                        //         if(!empty($isAlreadyPaid)){
                        //             if($isAlreadyPaid->pending_status == 1){
                        //                 $remaining_fee_amt -= $isAlreadyPaid->pending_amt;
                        //                 if($remaining_fee_amt >= 0){
                        //                     //$pending_amount = 0;
                        //                     $paid_amt = $isAlreadyPaid->pending_amt;
                        //                     $pending_amt = 0;
                        //                     $fee_pending_status = 0;
                        //                 } else {
                        //                     //$dd_amount = 0; 
                        //                     $paid_amt = $isAlreadyPaid->pending_amt - abs($remaining_fee_amt);
                        //                     $pending_amt = $isAlreadyPaid->pending_amt - $paid_amt;
                        //                     $fee_pending_status = 1;
                        //                 } 
                        //                 $db_save_status = true;
                        //             }
                        //         }else{
                        //             $remaining_fee_amt -= $fee_structure_amt;
                        //             if($remaining_fee_amt >= 0){
                        //                 //$pending_amount = 0;
                        //                 $paid_amt = $fee_structure_amt;
                        //                 $pending_amt = 0;
                        //                 $fee_pending_status = 0;
                        //             } else {
                        //                 //$dd_amount = 0; 
                        //                 $paid_amt = $fee_structure_amt - abs($remaining_fee_amt);
                        //                 $pending_amt = $fee_structure_amt - $paid_amt;
                        //                 $fee_pending_status = 1;
                        //             } 
                        //             $db_save_status = true;
                        //         }
                        //     }else{
                        //         if(empty($isAlreadyPaid)){
                        //         $pending_amt = $fee_structure_amt;
                        //         $paid_amt = 0;
                        //         $fee_pending_status = 1;
                        //         $db_save_status = true;
                        //         }
                        //     }

                        $structure_total = (float)$fee->fee_amount_state_board;
                        if($structure_total < 0){
                            $structure_total = 0;
                        }
                        // initialize values
                        $paid_amt = 0;
                        $pending_amt = 0;
                        $fee_pending_status = 1;
                        $db_save_status = false;
                        // already paid info
                        $AlreadyPaidInfo = $this->fee->checkFeeTypeTotalPaid($application_no, $fee->fee_division_id);
                        if(!empty($AlreadyPaidInfo->total_paid)){
                            $already_paid_total =  (float)$AlreadyPaidInfo->total_paid; 
                        }else{
                            $already_paid_total =  0; 
                        }
                        // calculate actual pending
                        $pending_balance = $structure_total - $already_paid_total;

                        if($pending_balance < 0){
                            $pending_balance = 0;
                        }
                        if($remaining_fee_amt > 0 && $pending_balance > 0){
                            // amount to pay now
                            $paid_amt = min($remaining_fee_amt, $pending_balance);
                            // remaining pending after this payment
                            $pending_amt = $pending_balance - $paid_amt;
                            // pending status
                            if(!empty($pending_amt > 0)){
                                $fee_pending_status =  1; 
                            }else{
                                $fee_pending_status =  0; 
                            }
                            // reduce remaining amount
                            $remaining_fee_amt -= $paid_amt;
                            $db_save_status = true;
                        }
                        if($db_save_status){
                            $receipt_number_for_fee = $receipt_no;
                            if((int)$fee->fee_division_id === 1){
                                $receipt_number_for_fee = $this->fee->getLastReceiptNoByFeeType($filter['fee_year'], $fee->fee_division_id);
                                // log_message('debug','receipt_number_for_fee='.print_r($receipt_number_for_fee,true));

                            }

                            $feeReceiptPayment = array(
                                'application_no' => $application_no,
                                'receipt_number' => $overall_row_id,
                                'receipt_no' => $receipt_number_for_fee, 
                                'payment_date' => $this->convertUTCtoIST($response['addedon']), 
                                'fee_type_id' => $fee->fee_division_id,
                                'fee_structure_id' => $fee->row_id,
                                'paid_amount' => $paid_amt,
                                'pending_amt' => $pending_amt,
                                'payment_year' => $filter['fee_year'],
                                'pending_status' => $fee_pending_status,
                                'school_account_id' => $fee->account_row_id,
                                'created_by' => 'schoolphins',
                                'fee_amount' => $fee_structure_amt,
                                'created_date_time' => date('Y-m-d H:i:s'));
                            $receipt_return_feeType = $this->fee->addReceiptFeeType($feeReceiptPayment);
                        }
                    }  


                    if(!empty($overall_row_id)){
                        $concessionAmt =  $this->fee->checkConsessionExists($application_no,$fee_year);
                        if(!empty($concessionAmt)){
                            $concessionInfo = array(
                                'payment_status'=>1,
                                // 'instalment_status'=>1,
                                'updated_by'=>$application_no,
                                'updated_date_time'=>date('Y-m-d H:i:s'));
                            $this->fee->updateConcessionById($concessionInfo, $concessionAmt->row_id);
                        }
                    
                    
                        $installmentAmt =  $this->fee->checkInstalmentExists($application_no);
                        //log_message('debug','inst='.print_r($installmentAmt,true));
                        if(!empty($installmentAmt)){
                            $instllInfo = array(
                                'payment_status'=>1,
                                'receipt_number' => $receipt_no,
                                'updated_by'=>$application_no,
                                'updated_date_time'=>date('Y-m-d H:i:s'));
                            $this->fee->updateInstalmentById($instllInfo, $installmentAmt->row_id);
                        }
                        // $studInfo = array(
                        //     'new_admission_status' => 1,
                        //     'updated_by' => $application_no,
                        //     'updated_date_time' => date('Y-m-d H:i:s'));
                        //     $return_stud = $this->fee->updateStudentInfoByID($studInfo,$application_no);
                        // if($term_name == 'I PUC'){
                        //    $url = 'http://192.168.1.206/LOURDES_SCHOOL/STAFF_PORTAL/mountcarmelEmail';

                        //     $postData = [
                        //         'student_name' => $studentInfo->student_name,
                        //         'email'        => $studentInfo->email,
                        //         'stream_name'  => $studentInfo->stream_name,
                        //         'father_name'  => $studentInfo->father_name,
                        //         'paid_amount'  => $paid_fee_amount
                        //     ];

                        //     $ch = curl_init($url);
                        //     curl_setopt($ch, CURLOPT_POST, true);
                        //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
                        //     curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']); 
                        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        //     $response = curl_exec($ch);
                        //     curl_close($ch);
                        // }
                }
                
                
                
                $payInfo = array(
                    'tran_id' =>$response['txnid'],
                    'tran_date' =>  $this->convertUTCtoIST($response['addedon']),
                    'amount' => $response['amount'],
                    'payment_mode'=>'ONLINE',
                    'payment_status'=>'SUCCESS',
                    'receipt_number' => $receipt_number,
                    'pay_status' => 1);
                
                $msg = "success"; 

            }else{
                    // $payInfo = array(
                    //      'tran_id' =>$response['txnid'],
                    //     'tran_date' => $this->convertUTCtoIST($response['addedon']),
                    //     // 'amount' => $response['amount'],
                    //     'payment_mode'=>'ONLINE',
                    //     'payment_status'=>'FAILED',
                    //     'receipt_number' => $isExistOrderID->receipt_number,
                    //     'pay_status' => 1);

                    // $data['payment_status'] = true;
                    // $data['payment_done_now'] = true;
                    $msg = "Transaction Already Proceesed";
                }
            }else{

                $payInfo = array(
                    'tran_id' =>$response['txnid'],
                    'tran_date' =>  $this->convertUTCtoIST($response['addedon']),
                    // 'amount' => $response['amount'],
                    'payment_mode'=>'ONLINE',
                    'payment_status'=>'FAILED'
                );  
                $msg = "Transaction Failed";
            }
             $this->fee->updateFeePaymentLogOrderID($response['txnid'],$payInfo);

            // log_message('debug','coming hurre--->'.print_r($msg,true));           
        }
        echo json_encode($msg);
    } 

    public function bulkReprocessCronJob(){
        // $this->cors();
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);
        $msg ='success';
        // $application_no = $obj['row_id'];
        // $studentRowId = $obj['row_id'];
        // $student_row_id = $obj['row_id'];

        $logInfo= $this->fee->getLogDetailsCronJob();
        // log_message('debug','logInfo->'.print_r($logInfo,true));


        foreach($logInfo as $info){

            $amount = $info->amount;
            $ORDER_ID = $info->order_id;
            $application_no = $info->registered_tbl_row_id;
            $studentRowId = $info->registered_tbl_row_id;
            $student_row_id = $info->registered_tbl_row_id;
                // $feeType = $info->fee_type;
            $studentInfo = $this->student_model->getStudentInfoByRowId($application_no);

            $easebuzzObj = new Easebuzz(EB_MERCHANT_KEY, EB_SALT, EB_ENV);

            $email = $info->email;
            $phone = $info->phone;

          
    
                    
            $concatenated_string = EB_MERCHANT_KEY . "|" . $ORDER_ID. "|" . $amount. "|" . $email . "|" . $phone . "|" . EB_SALT;
                
            $hashed_value = hash('sha512', $concatenated_string);
                  
    
       
            $postData = array ( 
                "txnid" => $ORDER_ID,
                "amount" => $amount,
                "email" => $email,
                "phone" => $phone,
                "hash" => $hashed_value,
            );
            
            $responseParamList = $easebuzzObj->transactionAPI($postData);
                
            // Decode JSON string
            $response_array = json_decode($responseParamList, true);
            
            $response = $response_array['msg'];
         

            if($response['status'] == "success"){ 
                $isExistOrderID = $this->fee->checkOrderIdExistsInFeePayment($response['txnid']);
                if(empty($isExistOrderID)){ 
                $filter = array();
                $paid_fee_amount = $response['amount'];
                
                $filter['fee_year'] = $studentInfo->intake_year_id;
                $filter['student_fee_type'] = 'REG';
                $term_name = $studentInfo->term_name;
           

                if($term_name == 'II PUC'){
                    if($studentInfo->intake_year_id == FEE_YEAR){
                        $filter['student_fee_type'] = 'NEW';
                        $filter['fee_year'] = trim($studentInfo->intake_year_id);
                    }else{
                        $filter['student_fee_type'] = 'REG';
                        $filter['fee_year'] = trim($studentInfo->intake_year_id)+1;
                    }
                }
                $filter['term_name'] = $term_name;
                $filter['stream_name'] = $studentInfo->stream_name;
                $filter['gender'] = $studentInfo->gender;
            
               
                // log_message('debug','filter='.print_r($filter,true));
                $total_fee = $this->fee->getTotalFeeAmount($filter);
                $depart_fee = $this->fee->getGovtFeeAmount($filter);
                $category_fee = 0;

                // if($filter['student_category'] != 'Regular'){
                //     $category_fee = $this->fee->getCategoryFeeAmount($filter);
                //     // $data['category_fee'] = $category_fee;
                // }
                // $feeStructureInfo = $this->fee->getFeeStructureInfo($filter);
                $total_fee_to_pay = $total_fee->total_fee + $depart_fee + $category_fee; //- $depart_fee;
                // log_message('debug','total_fee_to_pay='.print_r($total_fee_to_pay,true));
                $data['feePaidInfo'] = $this->fee->getFeePaidInfo($application_no,$filter['fee_year']);
                if(!empty($data['feePaidInfo'])){
                    foreach($data['feePaidInfo'] as $fee){
                        $total_fee_to_pay = $total_fee_to_pay - $fee->paid_amount;
                    }
                }
                $concession = 0; 
                $concession_amt = $this->fee->getFeeConcessionByAppNo($application_no,$filter['fee_year']);
                if($concession_amt>0){
                    $concession = $concession_amt;
                    $total_fee_to_pay -= $concession;
                }

                $remaining_fee_amt = $paid_fee_amount;
                $feePaymentInfo = $this->fee->getStdLastPaidDetailsByApplicationNo($application_no,$filter['fee_year']);
                if(empty($feePaymentInfo)){
                    $paid_count = 1;
                    //$paid_fee_amount -= $depart_fee;
                }else{
                    $paid_count = $feePaymentInfo->payment_count+1;
                }

                $pending_fee_balance = $total_fee_to_pay - $paid_fee_amount;
                if($pending_fee_balance <= 0){
                    $fee_excess_amount = abs($pending_fee_balance);
                    $fee_pending_status = 0;
                    $pending_fee_balance = 0;
                }else if($pending_fee_balance > 0){
                    $fee_excess_amount = 0;
                    $fee_pending_status = 1;
                }

                $lastReceiptInfo = $this->fee->getLastReceiptNo($filter['fee_year']);
                if(!empty($lastReceiptInfo->receipt_number)){
                    $receipt_no_new = $lastReceiptInfo->receipt_number + 1;
                }else{
                    $receipt_no_new = 1;
                }
                $receipt_no_new = sprintf('%04d',$receipt_no_new);
                $receipt_no = substr((string)$filter['fee_year'], -2) . 'T' . $receipt_no_new;

                $overallFee = array(
                    'application_no' => $application_no,
                    'receipt_number' => $receipt_no_new,
                    'payment_type' => 'ONLINE',
                    'payment_date' =>  $this->convertUTCtoIST($response['addedon']),
                    'total_amount' => $total_fee_to_pay,
                    'paid_amount' => $paid_fee_amount,
                    'excess_amount' => $fee_excess_amount,
                    'fee_concession' => $concession,
                    'pending_balance' => abs($pending_fee_balance),
                    'fee_pending_status' => $fee_pending_status,
                    'payment_count' => $paid_count,
                    'payment_year' => $filter['fee_year'],
                    'term_name' => $term_name,

                    'order_id' => $response['txnid'],

                    'created_by' => 'schoolphins-app',
                    'created_date_time' => date('Y-m-d H:i:s'));
                    $fee_year= $filter['fee_year'];
                    $overall_row_id = $this->fee->addFeeDetailsNewAdmission($overallFee);

                    $remaining_fee_amt = $paid_fee_amount;

                    $feeStructureInfo = $this->fee->getAllFeeStructureInfoForReceipt($filter);
                    foreach($feeStructureInfo as $fee){
                        $db_save_status = false;
                        $fee_structure_amt = $fee->fee_amount_state_board;
                        //     $isAlreadyPaid = $this->fee->checkFeeTypeIsAlreadyPaid($application_no,$fee->row_id);
                        //     if($remaining_fee_amt >= 0){
                        //         if(!empty($isAlreadyPaid)){
                        //             if($isAlreadyPaid->pending_status == 1){
                        //                 $remaining_fee_amt -= $isAlreadyPaid->pending_amt;
                        //                 if($remaining_fee_amt >= 0){
                        //                     //$pending_amount = 0;
                        //                     $paid_amt = $isAlreadyPaid->pending_amt;
                        //                     $pending_amt = 0;
                        //                     $fee_pending_status = 0;
                        //                 } else {
                        //                     //$dd_amount = 0; 
                        //                     $paid_amt = $isAlreadyPaid->pending_amt - abs($remaining_fee_amt);
                        //                     $pending_amt = $isAlreadyPaid->pending_amt - $paid_amt;
                        //                     $fee_pending_status = 1;
                        //                 } 
                        //                 $db_save_status = true;
                        //             }
                        //         }else{
                        //             $remaining_fee_amt -= $fee_structure_amt;
                        //             if($remaining_fee_amt >= 0){
                        //                 //$pending_amount = 0;
                        //                 $paid_amt = $fee_structure_amt;
                        //                 $pending_amt = 0;
                        //                 $fee_pending_status = 0;
                        //             } else {
                        //                 //$dd_amount = 0; 
                        //                 $paid_amt = $fee_structure_amt - abs($remaining_fee_amt);
                        //                 $pending_amt = $fee_structure_amt - $paid_amt;
                        //                 $fee_pending_status = 1;
                        //             } 
                        //             $db_save_status = true;
                        //         }
                        //     }else{
                        //         if(empty($isAlreadyPaid)){
                        //         $pending_amt = $fee_structure_amt;
                        //         $paid_amt = 0;
                        //         $fee_pending_status = 1;
                        //         $db_save_status = true;
                        //         }
                        //     }

                        $structure_total = (float)$fee->fee_amount_state_board;
                        if($structure_total < 0){
                            $structure_total = 0;
                        }
                        // initialize values
                        $paid_amt = 0;
                        $pending_amt = 0;
                        $fee_pending_status = 1;
                        $db_save_status = false;
                        // already paid info
                        $AlreadyPaidInfo = $this->fee->checkFeeTypeTotalPaid($application_no, $fee->fee_division_id);
                        if(!empty($AlreadyPaidInfo->total_paid)){
                            $already_paid_total =  (float)$AlreadyPaidInfo->total_paid; 
                        }else{
                            $already_paid_total =  0; 
                        }
                        // calculate actual pending
                        $pending_balance = $structure_total - $already_paid_total;

                        if($pending_balance < 0){
                            $pending_balance = 0;
                        }
                        if($remaining_fee_amt > 0 && $pending_balance > 0){
                            // amount to pay now
                            $paid_amt = min($remaining_fee_amt, $pending_balance);
                            // remaining pending after this payment
                            $pending_amt = $pending_balance - $paid_amt;
                            // pending status
                            if(!empty($pending_amt > 0)){
                                $fee_pending_status =  1; 
                            }else{
                                $fee_pending_status =  0; 
                            }
                            // reduce remaining amount
                            $remaining_fee_amt -= $paid_amt;
                            $db_save_status = true;
                        }
                        if($db_save_status){
                            $receipt_number_for_fee = $receipt_no;
                            if((int)$fee->fee_division_id === 1){
                                $receipt_number_for_fee = $this->fee->getLastReceiptNoByFeeType($filter['fee_year'], $fee->fee_division_id);
                                // log_message('debug','receipt_number_for_fee='.print_r($receipt_number_for_fee,true));

                            }

                            $feeReceiptPayment = array(
                                'application_no' => $application_no,
                                'receipt_number' => $overall_row_id,
                                'receipt_no' => $receipt_number_for_fee, 
                                'payment_date' => $this->convertUTCtoIST($response['addedon']), 
                                'fee_type_id' => $fee->fee_division_id,
                                'fee_structure_id' => $fee->row_id,
                                'paid_amount' => $paid_amt,
                                'pending_amt' => $pending_amt,
                                'payment_year' => $filter['fee_year'],
                                'pending_status' => $fee_pending_status,
                                'school_account_id' => $fee->account_row_id,
                                'created_by' => 'schoolphins',
                                'fee_amount' => $fee_structure_amt,
                                'created_date_time' => date('Y-m-d H:i:s'));
                            $receipt_return_feeType = $this->fee->addReceiptFeeType($feeReceiptPayment);
                        }
                    }  


                    if(!empty($overall_row_id)){
                        $concessionAmt =  $this->fee->checkConsessionExists($application_no,$fee_year);
                        if(!empty($concessionAmt)){
                            $concessionInfo = array(
                                'payment_status'=>1,
                                // 'instalment_status'=>1,
                                'updated_by'=>$application_no,
                                'updated_date_time'=>date('Y-m-d H:i:s'));
                            $this->fee->updateConcessionById($concessionInfo, $concessionAmt->row_id);
                        }
                    
                    
                        $installmentAmt =  $this->fee->checkInstalmentExists($application_no);
                        //log_message('debug','inst='.print_r($installmentAmt,true));
                        if(!empty($installmentAmt)){
                            $instllInfo = array(
                                'payment_status'=>1,
                                'receipt_number' => $receipt_no,
                                'updated_by'=>$application_no,
                                'updated_date_time'=>date('Y-m-d H:i:s'));
                            $this->fee->updateInstalmentById($instllInfo, $installmentAmt->row_id);
                        }
                        // $studInfo = array(
                        //     'new_admission_status' => 1,
                        //     'updated_by' => $application_no,
                        //     'updated_date_time' => date('Y-m-d H:i:s'));
                        //     $return_stud = $this->fee->updateStudentInfoByID($studInfo,$application_no);
                        // if($term_name == 'I PUC'){
                        //    $url = 'http://192.168.1.206/LOURDES_SCHOOL/STAFF_PORTAL/mountcarmelEmail';

                        //     $postData = [
                        //         'student_name' => $studentInfo->student_name,
                        //         'email'        => $studentInfo->email,
                        //         'stream_name'  => $studentInfo->stream_name,
                        //         'father_name'  => $studentInfo->father_name,
                        //         'paid_amount'  => $paid_fee_amount
                        //     ];

                        //     $ch = curl_init($url);
                        //     curl_setopt($ch, CURLOPT_POST, true);
                        //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
                        //     curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']); 
                        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        //     $response = curl_exec($ch);
                        //     curl_close($ch);
                        // }
                }
                
                
                
                $payInfo = array(
                    'tran_id' =>$response['txnid'],
                    'tran_date' =>  $this->convertUTCtoIST($response['addedon']),
                    'amount' => $response['amount'],
                    'payment_mode'=>'ONLINE',
                    'payment_status'=>'SUCCESS',
                    'receipt_number' => $receipt_number,
                    'pay_status' => 1);
                
                $msg = "success"; 

            }else{
                    // $payInfo = array(
                    //      'tran_id' =>$response['txnid'],
                    //     'tran_date' => $this->convertUTCtoIST($response['addedon']),
                    //     // 'amount' => $response['amount'],
                    //     'payment_mode'=>'ONLINE',
                    //     'payment_status'=>'FAILED',
                    //     'receipt_number' => $isExistOrderID->receipt_number,
                    //     'pay_status' => 1);

                    // $data['payment_status'] = true;
                    // $data['payment_done_now'] = true;
                    $msg = "Transaction Already Proceesed";
                }
            }else{

                $payInfo = array(
                    'tran_id' =>$response['txnid'],
                    'tran_date' =>  $this->convertUTCtoIST($response['addedon']),
                    // 'amount' => $response['amount'],
                    'payment_mode'=>'ONLINE',
                    'payment_status'=>'FAILED'
                );  
                $msg = "Transaction Failed";
            }
             $this->fee->updateFeePaymentLogOrderID($response['txnid'],$payInfo);

            // log_message('debug','coming hurre--->'.print_r($msg,true));           
        }
        echo json_encode($msg);
    } 
        //REMARK
     public function myRemarks(){
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);
        $studentRowId = $obj['row_id'];
        $data = $this->student_model->getRemarkInfoApi($studentRowId);
        $db_data = array();
        foreach($data as $info){
            if($info->created_date_time!=null){
                $info->date =date('d-m-Y h:i A',strtotime($info->created_date_time));
            }
            $db_data[] = $info;
        }
        echo json_encode($db_data);
       
    }


    //Late Arrival
    public function lateToClassListing(){
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);
        $student_id = $obj['student_id'];
        $latecomerInfo = $this->student_model->getStudentLateInfo($student_id);
        $db_data = array();
        foreach($latecomerInfo as $info){
            $db_data[] = $info;
        }
        $data = json_encode($db_data);               
        echo $data;

    }

    public function deleteAccount(){
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);
        $student_id = $obj['student_id'];
        $info = array('is_deleted' => 1);
        $return = $this->student_model->updateRegistration($student_id,$info);
        $data = json_encode($return);
        echo $data;
    }

    public function deleteToken(){
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);
        $student_id = $obj['student_id'];
        $token = $obj['token'];
        $id = $obj['id'];
        $return = $this->student_model->deleteToken($id);
        $data = json_encode($return);
        echo $data;
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
        //log_message('error', 'JSON='.print_r($json));
        curl_close($ch);
        return $status;
    }
        
    function getTermID($term_name) {
        $KGI = 1;
        $KGII = 2;
        $I = 3;
        $II = 4;
        $III = 5;
        $IV = 6;
        $V = 7;
        $VI = 8;
        $VII = 9;
        $VIII = 10;
        $IX = 11;
        $X = 12;
        switch ($term_name) {
            case "KG I":
                    return $KGI;
                    break;
            case "KG II":
                    return $KGII;
                    break;
            case "I":
                    return  $I;
                    break;
            case "II":
                    return $II;
                    break;
            case "III":
                    return $III;
                    break;
            case "IV":
                    return $IV;
                    break;
            case "V":
                    return $V;
                    break;
            case "VI":
                    return $VI;
                    break;
            case "VII":
                    return $VII;
                    break;
            case "VIII":
                    return $VIII;
                    break;
            case "IX":
                    return $IX;
                    break;
            case "X":
                    return $X;
                    break;
        }
    }

    
	
    public function getSubjectCodes($stream_name){
        //science
        $PCMB = array("33", "34", "35", '36');
        $PCMC = array("33", "34", "35", '41');
        $PCME = array("33", "34", "35", '40');
        $PCMS = array("33", "34", "35", '31');
        //commarce
        $BEBA = array("75", "22", "27", '30');
        $BSBA = array("75", "31", "27", '30');
        $CSBA = array("41", "31", "27", '30');
        $SEBA = array("31", "22", "27", '30');
        $CEBA = array("41", "22", "27", '30');
        $PEBA = array("29", "22", "27", '30');
        //art
        $HEPP = array("21", "22", "32", '29');
        $MEBA = array("75", "22", "27", '30');
        $MSBA = array("75", "31", "27", '30');
        $HEPS = array("21", "22", "29", '28');
        $EBAC = array("22", "27", "30", '41');
        $HEBA = array("21", "22", "27", '30');

        switch ($stream_name) {
            case "PCMB":
                return  $PCMB;
                break;
            case "PCMC":
                return $PCMC;
                break;
            case "PCME":
                return $PCME;
                break;
            case "PCMS":
                return $PCMS;
                break;
            case "PEBA":
                return $PEBA;
                break;
            case "BEBA":
                return $BEBA;
                break;
            case "BSBA":
                return $BSBA;
                break;
            case "CSBA":
                return $CSBA;
                break;
            case "SEBA":
                return $SEBA;
                break;
            case "CEBA":
                return $CEBA;
                break;
            case "HEPP":
                return $HEPP;
                break;
            case "HEPS":
                return $HEPS;
                break;
            case "MEBA":
                return $MEBA;
                break;
            case "MSBA":
                return $MSBA;
                break;
            case "EBAC":
                return $EBAC;
                break;
            case "HEBA":
                return $HEBA;
                break;
        }
    }






function getAssessmentMark($totalMark,$exam_type,$labStatus,$subject_code){

    if(is_numeric($totalMark) && !empty($totalMark)){

            if($labStatus == 'false'){ 

                    if($exam_type == 'ASSIGNMENT_I' || $exam_type == 'ASSIGNMENT_II'){

                    if($totalMark >= 81 && $totalMark <= 100){

                            return '30';

                    }else if($totalMark >= 71 && $totalMark <= 80){

                            return '25';

                    }else if($totalMark >= 61 && $totalMark <= 70){

                            return '20';

                    }else if($totalMark >= 51 && $totalMark <= 60){

                            return '15';

                    }else if($totalMark >= 41 && $totalMark <= 50){

                            return '10';

                    }else{

                            return '5';

                    }

                    }

            }else{

                    if($exam_type == 'ASSIGNMENT_I' && $subject_code == '12' || $exam_type == 'ASSIGNMENT_II' && $subject_code == '12'){

                            if($totalMark >= 26 && $totalMark <= 35){

                                    return '4';

                            }else if($totalMark >= 36 && $totalMark <= 45){

                                    return '8';

                            }else if($totalMark >= 46 && $totalMark <= 55){

                                    return '12';

                            }else if($totalMark >= 56 && $totalMark <= 65){

                                    return '16';

                            }else if($totalMark >= 66 && $totalMark <= 75){

                                    return '20';

                            }else{

                                    return '25';

                            }

                            }else if($exam_type == 'ASSIGNMENT_I' || $exam_type == 'ASSIGNMENT_II'){

                            if($totalMark >= 1 && $totalMark <= 28){

                                    return '4';

                            }else if($totalMark >= 29 && $totalMark <= 35){

                                    return '8';

                            }else if($totalMark >= 36 && $totalMark <= 42){

                                    return '12';

                            }else if($totalMark >= 43 && $totalMark <= 49){

                                    return '16';

                            }else if($totalMark >= 50 && $totalMark <= 56){

                                    return '19';

                            }else{

                                    return '22';

                            }

                    }

            }

    }else{

            return '';

    }

}


//---------------Event--------------------
public function upcomingEvent(){
    $filter = array();
    $json = file_get_contents('php://input'); 
    $obj = json_decode($json,true);
   
    $eventInfo = $this->student_model->getEvents();
    foreach($eventInfo as $info){
            $info->date =date('d-m-Y',strtotime($info->date));
            $info->time =date('h:m a',strtotime($info->time));
        $db_data[] = $info;
    }
    $data = json_encode($db_data);
    echo $data;
    }

//---------------Calender----------
public function calender(){
    $filter = array();
    $json = file_get_contents('php://input'); 
    $obj = json_decode($json,true);
    $calenderInfo = $this->student_model->getCalender();
    $holidayInfo =  $this->student_model->getHolidayInfo();
    $events = array_merge($calenderInfo, $holidayInfo);
    $data = json_encode($events);
    echo $data;
}    

public function absentDetails(){
    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);
    $student_id = $obj['row_id'];
    $studentInfo = $this->student_model->getStudentInfoByRowId($student_id);
    $absentInfo= $this->student_model->getabsentDetails($studentInfo->student_id);
    foreach($absentInfo as $info){
        $info->class_period = $info->start_time.' - '.$info->end_time;
    }
    // log_message('debug','absentInfo->'.print_r($absentInfo,true));
    $data = json_encode($absentInfo);
    echo $data;
    
}

public function timeTable(){

    $row_id =$_GET['id'];
    
    $student= $this->student_model->getStudentInfoByRowId($row_id);
   // log_message('debug','timerow->'.print_r($student,true));
    $class = $this->timetable_model->getClassById($student->section_name,$student->term_name);
    //log_message('debug','timerow->'.print_r($class,true));

    $data['classTimings'] = $this->timetable_model->getClassTimings();

    $data['timetableInfo'] = $this->timetable_model->getTimeTableInfoByClassID($class->row_id);
     //log_message('debug','$datatimetableInfo->'.print_r($data['timetableInfo'],true));

    $data['timingsInfo'] = $this->timetable_model->getClassTimingsforWeekend();
    

    $this->global['pageTitle'] = ''.TAB_TITLE.' : My Performance' ;

    $this->load->view("student/timetableApp",$data);

}

public function switchprofile() {
    $json = file_get_contents('php://input'); 
    $obj = json_decode($json, true);
    $row_id = $obj['row_id'];

    $result = $this->student_model->getStudentInfoByRowId($row_id);

    // Check if both mobile numbers are empty
    $father_mobile = $result->father_mobile ?: '';
    $mother_mobile = $result->mother_mobile ?: '';

    if (empty($father_mobile) && empty($mother_mobile)) {
        // Both numbers are empty, return empty array or appropriate message
        echo json_encode([]);
        return;
    }

    $switchProfile=array();

    if(!empty($father_mobile)){
        $switchProfile = $this->student_model->getswitchMobile($row_id,$father_mobile);
    }
    // Proceed to fetch the mobile number if at least one is available
    
    if(!empty($mother_mobile) && empty($switchProfile)){
        $switchProfile = $this->student_model->getswitchMobile($row_id,$mother_mobile);
    }
     
    $data = json_encode($switchProfile);
    echo $data;
}

//Gallery
public function galleryInfo(){
    $filter = array();
    $json = file_get_contents('php://input'); 
    $obj = json_decode($json,true);
    $row_id = $obj['row_id'];
    $galleryInfo = $this->student_model->getGalleryInfo();
     $db_data = array();  
    foreach($galleryInfo as $info){
            $info->date =date('d-m-Y',strtotime($info->date));
            $db_data[] = $info;
        }
    $data = json_encode($db_data);
    echo $data;
} 
public function galleryInfoImages(){
    $filter = array();
    $json = file_get_contents('php://input'); 
    $obj = json_decode($json,true);
    $row_id = $obj['row_id'];
    
    $galleryInfo = $this->student_model->galleryInfoImages($row_id);
    // log_message('debug','galleryInfo'.print_r($galleryInfo,true));
    $data = json_encode($galleryInfo);
    echo $data;
}



public function myHomework(){
    $json = file_get_contents('php://input'); 
    $obj = json_decode($json,true);
    $student_id = $obj['student_id'];
    $student = $this->student_model->getStudentInfoByRowId($student_id);
    $todayDate = date('Y-m-d');
    $active_date =  date('Y-m-d', strtotime('-15 days'));
    $startDate = date('Y-m-d', strtotime('-15 days'));
    $endDate =  date('Y-m-d', strtotime('+15 days'));
    $homeworkInfo = $this->push_notification_model->getStudentHomeworkApi($startDate,$endDate,$student->term_name,$student->stream_name,$student->section_name);
    $db_data = array();
    foreach($homeworkInfo as $hw){
        $hw->submission_date = date('d-m-Y h:i A',strtotime($hw->date_time));
        $db_data[] = $hw;
    }
    $data = json_encode($db_data);
    echo $data;
}

    public function viewTransportPaymentInfo(){	
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);
        $student_id = $obj['student_id'];
        $studentRowId = $obj['row_id'];
        
        $dt = array();
        $data = (object)$dt;



        $data->studentInfo =  $studentInfo = $this->student_model->getStudentInfoByRowId($studentRowId);

        // if($studentInfo->term_name=='I PUC'){
        //     $student_route_id = $studentInfo->route_id;
        // }else{
        //     $student_route_id = $studentInfo->route_id_II;
        // }
        //   log_message('debug','ssdss-->'.print_r($studentInfo,true));
        $year = CURRENT_YEAR; 
        // log_message('debug','ff'.print_r($year,true));
        // $student= $this->student_model->getCurrentStudentInfoForTrans(); 
        $total_fee_pending = 0.00;
        $total_fee_paid= 0.00;
        $studentData = $this->student_model->getStudentsInfoById($studentRowId,$studentInfo->term_name);
        log_message('debug','studentData-->'.print_r($studentData,true));

        $getAmount = $this->student_model->getTransportFeefromStructure($studentData->route_row_id);
        log_message('debug','getAmount-->'.print_r($getAmount,true));
        $total_fee = $total_fee= $getAmount->rate;
        
        $total_fee_amount =$getAmount->rate;
        //log_message('debug','total_fee_amount'.print_r($total_fee_amount,true));

        $feePaidInfo = $this->student_model->getTransportTotalPaidAmount($studentRowId,$year);
        if(!empty($feePaidInfo->paid_amount)){
            $total_fee_amount -= $feePaidInfo->paid_amount;
        }

        $feeConcession = $this->student_model->getFeeConcessionInfo($studentRowId,$year); 
        if(!empty($feeConcession)){
            $total_fee_amount -= $feeConcession->fee_amt;
        }

    

        $data->stdFeePaymentInfo = $this->student_model->getStudentOverallTransFeePaymentInfo($studentRowId,$year);

        $yearwiseInfo = $this->student_model->getStudentYearWise($studentRowId);

    //  log_message('debug','yearwiseInfo-->'.print_r($yearwiseInfo,true));

        if(!empty($yearwiseInfo)){
            $data->cancel_bus_status = $yearwiseInfo->cancel_bus_status;
        }
        
        $data->totalamount = $getAmount->rate;
        $data->busNo = $studentData->bus_no;
        $data->buspickuppoint = $studentData->route_name;
        $data->feePaidInfo = $feePaidInfo->paid_amount;
        $data->studentData = $studentData;
        $data->fee_amount = $total_fee_amount;
        $data->year= $year;
        $data->studentid = $studentInfo->student_id;
        $data->studentname= $studentInfo->student_name;
        $data->class= $studentInfo->term_name;
        $data->section= $studentInfo->section_name;

            if($total_fee_amount == 0 || $total_fee_amount < 0){
                $data->installment_amt = 0;
                $data->fee_pending_status = false;
            
            }else{
                $data->fee_pending_status = true;
            }
        

        echo json_encode($data);
    }
    function overAllTransportFeePaidInfo(){
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);
        $studentRowId = $obj['row_id'];
        $year = CURRENT_YEAR;
        $data = $this->student_model->getStudentOverallTransFeePaymentInfo($studentRowId,$year);
        echo json_encode($data);
    }
    public function busfeePaymentReceiptPrint(){
        $row_id = $_GET['id'];
        // log_message('debug','row_id--->'.$row_id);
        error_reporting(0);
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf', 'default_font' => 'timesnewroman', 'format' =>  'A4']);
            $mpdf->AddPage('P', '', '', '', '', 7, 7, 7, 7, 8, 8);
            $mpdf->SetTitle('Transport Receipt');
            $data['studentTransportInfo'] = $this->student_model->getStudentTransportInfoById($row_id);
            $data['transModel'] = $this->student_model;
            $data['transport_rate'] = $data['studentTransportInfo']->bus_fees;
            $data['transport_rate_words'] = $this->getIndianCurrency(floatval($data['transport_rate']));
            $this->global['pageTitle'] = '' . TAB_TITLE . ' : Print Student Transport Bill';
            // log_message('debug','data--->'.print_r($data,true));
            $html = $this->load->view('fee_management/printStudentTransportBill', $data, true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('Transport_Receipt.pdf', 'I');
    }
    function getIndianCurrency(float $number) {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred','thousand','lakh', 'crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
    }

    public function feedback(){
        $student_id =$_GET['id'];
        log_message('debug','student_id->'.print_r($student_id,true));
        $studentInfo = $this->student_model->getStudentInfoByRowId($student_id);

          $result = $studentInfo;
 
        if(!empty($result)){

                $lastLogin = $this->login_model->lastLoginInfo($result->row_id);

                $sessionArray = array('userId'=>$result->student_id,

                                    'student_id'=>$result->student_id,

                                    'student_name'=>$result->student_name,

                                    'term_name'=>$result->term_name,

                                    'section_name'=>$result->section_name,

                                    'lastLogin'=> $lastLogin->createdDtm,

                                    'isLoggedIn' => TRUE

                                ); 

                $this->session->set_userdata($sessionArray);

                unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);



                $loginInfo = array("userId"=>$result->row_id, "sessionData" => json_encode($sessionArray), "machineIp"=>$_SERVER['REMOTE_ADDR'], "userAgent"=>getBrowserAgent(), "agentString"=>$this->agent->agent_string(), "platform"=>$this->agent->platform());

                $this->login_model->lastLogin($loginInfo);
        }


        if(empty($studentInfo->section_name)){
            $section_name ='ALL';
        }else{
            $section_name = $studentInfo->section_name;
        }
        $data['feedbackStaffInfo'] = $this->feedback_model->getMyTeachingStaffInfo($studentInfo->term_name, $section_name,$studentInfo->stream_name);
        $data['feedback'] = $this->feedback_model;
        $data['feedbacQuestions'] = $this->feedback_model->getStudentFeedbackQuestions();

        $data['isExist'] = $this->feedback_model->getGivenFeedbackInfoByStudent($studentInfo->student_id);

        $this->global['pageTitle'] = 'Staff Feedback';
        $_SESSION['loggedIn_type'] = 'Mobile';
        // $this->load->view("feedback/student_feedback_teaching_staff",$data);

        $this->loadViews("feedback/student_feedback_teaching_staff", $this->global, $data, NULL);

        // $data['feedbackStaffInfo'] = $this->feedback_model->getMyTeachingStaffInfo($studentInfo->term_name,$section_name,$studentInfo->stream_name);
        // $data['feedbacQuestions'] = $this->feedback_model->getStudentFeedbackQuestions();
        // $data['isExist'] = $this->feedback_model->getGivenFeedbackInfoByStudent($studentInfo->student_id);
        // $data['student_id'] = $studentInfo->student_id;
        // //log_message('debug','isExist->'.print_r($data['isExist'],true));

        // $this->global['pageTitle'] = 'Schoolphins - SJPUC : Staff Feedback' ;
        // $_SESSION['loggedIn_type'] = 'Mobile';
        // $this->loadViews("feedback/student_feedback_teaching_staff", $this->global, $data, NULL);  
        
    }
}
 
?>