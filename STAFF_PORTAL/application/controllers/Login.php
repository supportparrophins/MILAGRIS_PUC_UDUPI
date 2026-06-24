<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model','login');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
      
        $this->isLoggedIn();
    }
    
    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn(){
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        $role = $this->session->userdata('role');
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('login');
        }else{
            // redirect('dashboard');
            if($role == ROLE_SUPER_ADMIN){
                redirect('adminDashboard');
            }else{
                redirect('dashboard');
            }
        }
    }
    
    public function loginFaculty(){
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('login');
        }
        else
        {
            redirect('dashboard');
        }
    }
    /**
     * This function used to logged in user
     */
    public function loginMe(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required|max_length[10]|trim');
        if($this->form_validation->run() == FALSE){
            $this->index();
        } else {
            $this->session->unset_userdata('error');
            $username = $_SESSION['staff_id'] = strtolower($this->security->xss_clean($this->input->post('username')));
            $isExist = $this->login->isStaffUsernameExists($username);
            if($isExist > 0){
                // if($isExist->role == ROLE_PRIMARY_ADMINISTRATOR && $isExist->staff_id != '123456'){
                //     $principal_role = ROLE_PRINCIPAL;
                //     $staffInfo = $this->login->getStaffInfoByRoleId($principal_role);
                //     $mobile_one = $staffInfo->mobile_one;
                // }else{
                    $mobile_one = $username;
                // }
            $this->session->unset_userdata('error');
                // if($username=='8660535841'){
                //     $otp = OTP; // Generate a 4-digit OTP code
                //     $result_sms = 'success';
                // }else{
                    $otp = rand(1000, 9999); // Generate a 4-digit OTP code
                    $message = "Your OTP is: $otp . Use it to verify your identity. Do not share this code with anyone. Regards, Parrophins.";
                    $result_sms = $this->sendOtpmsg($mobile_one, $message);
                // }
                    $parts = explode(' ', $result_sms);
                    if (count($parts) > 0) {
                        $result_sms = $parts[0];
                    } 
                    // $result_sms ='success';
                    if($result_sms=='success'){
                        $_SESSION['otpInfo'] = $otp;
                        $_SESSION['mobile_one'] = $mobile_one;
                        $otpUpdate = array(
                            'last_otp'=>$otp,
                        );
                        $update = $this->login->updateStaffInfo($isExist->row_id,$otpUpdate);
                        $lastLogin = $this->login->lastLoginInfo($isExist->staff_id);
                        $otp_timestamp = time();
                        $this->session->set_userdata('otp_timestamp', $otp_timestamp);
                    }else{
                        $this->session->set_flashdata('error', 'Mobile No. is Invalid');
                        $this->index();
                    }
                    $isLoggedIn = $this->session->userdata('isLoggedIn');
                    $this->session->set_userdata('mobile_number', $username);
                        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
                        {
                            $data["username"] = $mobile_one;
                            $data["username_entered"] = $username;
                            $this->load->view('users/verifyOtp',$data);
                        }
                        else
                        {
                            redirect('users/login');
                        }
                    // redirect('dashboard');
                
                // else {
                //     $this->session->set_flashdata('error', 'Username or Password Mismatch');
                //     $this->index();
                // }
            }else{
                $this->session->set_flashdata('error', 'Mobile No. is not Registered');
                $this->index();
            }
        }
    }

    public function getOtp(){
        $this->load->library('form_validation');
        // if($this->isAdmin() == TRUE){
        //     $this->loadThis();
        // }else{
            
        $mbl_number = strtolower($this->security->xss_clean($this->input->post('username')));
        $isExist = $this->login->isStaffUsernameExists($mbl_number);
        // if($isExist->role == ROLE_PRIMARY_ADMINISTRATOR && $isExist->staff_id != '123456'){
        //     $principal_role = ROLE_PRINCIPAL;
        //     $staffInfo = $this->login->getStaffInfoByRoleId($principal_role);
        //     $mobile_one = $staffInfo->mobile_one;
        // }else{
            $mobile_one = $mbl_number;
        // }
        $otp = rand(1000, 9999); // Generate a 4-digit OTP code

        $message = "Your OTP is: $otp . Use it to verify your identity. Do not share this code with anyone. Regards, Parrophins.";
       $result_sms = $this->sendOtpmsg($mobile_one, $message);
        $parts = explode(' ', $result_sms);
        if (count($parts) > 0) {
            $result_sms = $parts[0];
        } 

        //  $result_sms ='success';
           if($mbl_number!='1234567891' && $mbl_number!='1231231231' && $mbl_number!='1212121212'  && $mbl_number!='1313131313'){
                if($result_sms == 'success'){
                    $otpUpdate = array(
                        'last_otp'=>$otp,
                        "is_deleted"=>0
                    );  
                    
                    if($isExist > 0) { 
                        $update = $this->login->updateStaffInfo($isExist->row_id,$otpUpdate);

                    }                                
                }
           }
           header('Content-type: text/plain'); 
           header('Content-type: application/json'); 
           echo json_encode($return_id);
           exit(0);                
        // }          
    }
        function checkStaffOtp(){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('otp_value','OTP value','required|max_length[6]');      
            if($this->form_validation->run() == FALSE) {
                $this->index();
            }
            else {
             $this->session->unset_userdata('error');
                $otp_value = $this->input->post('otp_value');
                $data["username"] = $mobile_number = $this->session->userdata('mobile_number');
                
                $result = $this->login->checkOtpIsExist($mobile_number, $otp_value);
                if(!empty($result))
                {
                    $sessionArray = array('staff_id'=>$result->staff_id,                    
                                            'role'=>$result->roleId,
                                            'roleText'=>$result->role,
                                            'mobile'=>$result->mobile_one,
                                            'email'=>$result->email,
                                            'name'=>$result->name,
                                            'type'=>$result->type,
                                            'photo_url'=>$result->photo_url,
                                            'lastLogin'=> $lastLogin->createdDtm,
                                            'dept_id'=>$result->department_id,
                                            'leave_approved_status'=>$result->leave_approved_status,
                                            'isLoggedIn' => TRUE
                                    );
                                    // log_message('debug','$sessionArray'.print_r($sessionArray,true));
                    $_SESSION['roleInfo'] = $this->login->getAllRoleInfoByStaffID($result->staff_id);
                    $this->session->set_userdata($sessionArray);
                    unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);
                    $loginInfo = array("userId"=>$result->staff_id, "sessionData" => json_encode($sessionArray), "machineIp"=>$_SERVER['REMOTE_ADDR'], "userAgent"=>getBrowserAgent(), "agentString"=>$this->agent->agent_string(), "platform"=>$this->agent->platform());
                    $s_id = $this->session->session_id;
                    $last_login = $this->login->lastLogin($loginInfo);
                    $ci_session_array = array(
                        'staff_id'=>$result->staff_id,                    
                        'last_login_row_id'=>$last_login);
                    $this->login->updatelastSession($s_id,$ci_session_array);
                   

                    if($result->roleId == ROLE_SUPER_ADMIN){
                        redirect('adminDashboard');
                        }else{
                        redirect('dashboard');
                        }
                }else {
                   $this->session->set_flashdata('error', 'Invalid OTP - Please try again');
                    $this->load->view('users/verifyOtp',$data);
                    
                }
               
            }
        }

     
       

        // public function sendOtpmsg($mobile, $msg){
        //     $message = rawurlencode($msg);
        //     $data = "username=" . USERNAME_TEXTLOCAL . "&hash=" . HASH_TEXTLOCAL . "&message=" . $message . "&sender=" . SENDERID_TEXTLOCAL . "&numbers=" . $mobile;
        //     $ch = curl_init('https://api.textlocal.in/send/?');
        //     curl_setopt($ch, CURLOPT_POST, true);
        //     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     $result_sms = curl_exec($ch); // This is the result from the API
    
        //     $json = json_decode($result_sms, true);
        //     $status = $json['status'];
    
        //     curl_close($ch);
        //     return $status;
        // }
    public function sendOtpmsg($mobile, $msg){
        $request =""; //initialise the request variable
        $param['method']= "sendMessage";
        $param['send_to'] = $mobile;
        $param['msg'] = $msg;
        $param['userid'] = GUPSHUP_USERNAME;
        $param['password'] = GUPSHUP_PASSWORD;
        $param['v'] = "1.1";
        $param['msg_type'] = "TEXT"; //Can be "FLASH”/"UNICODE_TEXT"/”BINARY”
        $param['auth_scheme'] = "PLAIN";
        //Have to URL encode the values
        foreach($param as $key=>$val) {
        $request.= $key."=".urlencode($val);
        //we have to urlencode the values
        $request.= "&";
        //append the ampersand (&) sign after each parameter/value pair
        }
        $request = substr($request, 0, strlen($request)-1);
        //remove final (&) sign from the request
        $url = "https://enterprise.smsgupshup.com/GatewayAPI/rest?".$request;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        log_message('debug','$response '.print_r($response ,true));
        curl_close($ch);
        return $response;
    }
    /**
     * This function used to load forgot password view
     */
    public function forgotPassword(){
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('users/forgotPassword');
        }
        else
        {
            redirect('users/login');
        }
    }
    
    /**
     * This function used to generate reset password request link
     */
    function resetPasswordUser(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_name','Email Or Mobile Number','required');
        if($this->form_validation->run() == FALSE)
        {
            $this->forgotPassword();
        }
        else 
        {
            $user_name = $this->input->post('user_name');
            // $dob = $this->input->post('dob');
            $isExist = $this->login->isStaffUsernameExists($user_name);
            if($isExist > 0){
                $result = $this->login->resetPasswordUser($user_name);
                if(!empty($result)){
                    $data["user_name"] = $user_name;
                    $this->load->view('users/changePassword',$data);
                }else{
                    $this->session->set_flashdata('error','Email or Mobile Number is Invalid');
                    $this->load->view('users/forgotPassword');
                    //$this->load->view('users/forgotPassword');
                }
            }else{
                $this->session->set_flashdata('error', 'Username is Invalid');
                $this->load->view('users/forgotPassword');
            }
        }
    }

    /**
     * This function used to reset the password 
     */
    function resetPasswordConfirmUser(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password','Password','required|min_length[6]');
        $this->form_validation->set_rules('cpassword','Confirm Password','required|matches[password]|min_length[6]');
        
        if($this->form_validation->run() == FALSE) {
            $this->forgotPassword();
        }
        else {
            $user_name = $this->input->post('user_name');
            $password = $this->input->post('password');
            $staffInfo = array('password'=>getHashedPassword($password),
            'updated_by'=>$user_name);
           
            $result = $this->login->resetPasswordConfirmUser($staffInfo,$user_name);
            if($result > 0)
            {
                $this->session->set_flashdata('success', 'Password updated successfully');
                $this->load->view('login');
            }
            else
            {
                $this->session->set_flashdata('error', 'Password Mismatch');
            }
        }
    }

    public function generateOTP(){
        // Generate OTP code (you can use any OTP generation library)
        $otp_code = rand(1000, 9999); // Generate a 4-digit OTP code
        log_message('debug','rand'.$otp_code);
        // Save the OTP code in session for verification
        $this->session->set_userdata('otp_code', $otp_code);
        $user_mobile = $this->input->post('username');
        $studentInfo = array('last_opt' => $otp_code,'updated_by'=>$this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
        $result = $this->login->updateStaffInfo($studentInfo, $user_mobile);
        // Send the OTP to the user via SMS or any preferred method
        // Example: SendOTP::send($user_mobile, $otp_code); // Assuming you have a SendOTP class/method
    }




public function directLogin($staff_id,$type){
    $result = $this->login->loginMe($staff_id, PASSWORD);
    if(!empty($result)){
        $lastLogin = $this->login->lastLoginInfo($result->staff_id);
        $sessionArray = array('staff_id'=>$result->staff_id,                    
        'role'=>$result->roleId,
        'roleText'=>$result->role,
        'mobile'=>$result->mobile_one,
        'email'=>$result->email,
        'name'=>$result->name,
        'type'=>$result->type,
        'photo_url'=>$result->photo_url,
        'lastLogin'=> $lastLogin->createdDtm,
        'dept_id'=>$result->department_id,
        'isLoggedIn' => TRUE
       );
        $this->session->set_userdata($sessionArray);
        unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);
        $loginInfo = array("userId"=>$result->staff_id, "sessionData" => json_encode($sessionArray), "machineIp"=>$_SERVER['REMOTE_ADDR'], "userAgent"=>getBrowserAgent(), "agentString"=>$this->agent->agent_string(), "platform"=>$this->agent->platform());
        $this->login->lastLogin($loginInfo); 

        $redirectUrl = $this->login->getRedirectionUrl($type);

        // Redirect to the retrieved URL
        redirect($redirectUrl);
        
    } else {
        $this->session->set_flashdata('error', 'Username or Password Mismatch');
        $this->index();
    }
}


public function changeRoleByAdmin(){
      
    // $mobile_number = '8660535841';'7760416528'
    $role_id = $this->input->post('role_id');
    $mobile_number = $_SESSION['mobile_one'];
    $otp = $_SESSION['otpInfo'];
    if($mobile_number == '8660535841' || $mobile_number == '7760416528' ){
        $result = $this->login->checkOtpIsExist($mobile_number, OTP);
		$staffRoleInfo = $this->login->getStaffRoleName($role_id);

        if(!empty($result))
        {
            $lastLogin = $this->login->lastLoginInfo($result->staff_id);
            $sessionArray = array('staff_id'=>$result->staff_id,                    
                                        'role'=>$role_id,
                                        'roleText'=>$staffRoleInfo->role,
                                        'mobile'=>$result->mobile_one,
                                        'email'=>$result->email,
                                        'name'=>$result->name,
                                        'type'=>$result->type,
                                        'photo_url'=>$result->photo_url,
                                        'lastLogin'=> $lastLogin->createdDtm,
                                        'dept_id'=>$result->department_id,
                                        'isLoggedIn' => TRUE
                                );

            $this->session->set_userdata($sessionArray);
            unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);
            
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Username or Password Mismatch');
            $this->index();
        }
    }else {
        $this->session->set_flashdata('error', 'Username or Password Mismatch');
        $this->index();
    }
}
}



    
?>