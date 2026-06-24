<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
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
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('users/login');
        } else {
            redirect('/dashboard');
        }
    }
    
    
    /**
     * This function used to logged in user
     */
    public function loginMe(){
        $this->load->library('form_validation');
        
        
        $this->form_validation->set_rules('username', 'Username', 'required|max_length[128]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
            $username = strtolower($this->security->xss_clean($this->input->post('username')));
            $password = $this->input->post('password');
            $check = substr($username, 0, 2);
            if ($check == '19') {
                $term_name = 'IPUC';
            }else{
                $term_name = 'IIPUC'; 
            }
            $result = $this->login_model->loginMe($username, $password,$term_name);
            if(!empty($result))
            {
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
                redirect('/dashboard');
            }
            else
            {
                $this->session->set_flashdata('error', 'Student ID or password mismatch');
                $this->index();
            }
       }
    }

    /**
     * This function used to load forgot password view
     */
    public function forgotPassword(){
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('users/forgotPassword');
        } else {
            redirect('users/login');
        }
    }
    
    /**
     * This function used to generate reset password request link
     */
    function resetPasswordUser(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('student_id','Student ID','required|max_length[30]');
        $this->form_validation->set_rules('dob','Date of Birth','trim|required');
        if($this->form_validation->run() == FALSE)
        {
            $this->forgotPassword();
        }
        else 
        {
            $student_id = $this->input->post('student_id');
            $dob = $this->input->post('dob');
            $isExist = $this->login_model->isStudentAlreadyRegisterd($student_id);
            if($isExist > 0){
                $dob_from_db = str_replace('/', '-', $dob);
                if((date('Y-m-d',strtotime($dob_from_db))) == (date('Y-m-d',strtotime($dob)))){
                    $result = $this->login_model->resetPasswordUser($student_id,date('Y-m-d',strtotime($dob)));
                    if(!empty($result)){
                        $data["student_id"] = $student_id;
                        $this->load->view('users/changePassword',$data);
                    }else{
                        $this->session->set_flashdata('error','Date of Birth or Student Id is Invalid');
                        $this->load->view('users/forgotPassword');
                        //$this->load->view('users/forgotPassword');
                    }
                }else{
                    $this->session->set_flashdata('error','Date of Birth is Invalid');
                    $this->load->view('users/forgotPassword');
                }
            }else{
                $this->session->set_flashdata('error', $student_id .' is Not Registered.');
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
            $student_id = $this->input->post('student_id');
            $password = $this->input->post('password');
            $studentInfo = array('password'=>getHashedPassword($password),
            'password_text' => base64_encode($password),
            'updated_by'=>$student_id,'updatedDtm'=>date('Y-m-d H:i:s'));
           
            $result = $this->login_model->resetPasswordConfirmUser($studentInfo,$student_id);
            if($result > 0)
            {
                $this->session->set_flashdata('success', 'Password updated successfully');
                $this->load->view('users/login');
            }
            else
            {
                $this->session->set_flashdata('error', 'Password Mismatch');
            }
        }
    }
}
    
?>