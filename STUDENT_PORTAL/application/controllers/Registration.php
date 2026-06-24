<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Registration extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('registration_model');
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->isLoggedIn();
    }

    /**
     * This function is used to load the add new form
     */
    function userRegistration()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('register/userRegistration');
        }
        else
        {
            redirect('login');
        }
    }

    function userRegisterDB()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('student_id','Student ID','required|min_length[6]');
        $this->form_validation->set_rules('dob','Date of Birth','trim|required');
        $this->form_validation->set_rules('password','Password','required|max_length[30]');
        $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|min_length[6]');
         
        if($this->form_validation->run() == FALSE)
        {
            $this->userRegistration();
        }
        else
        {
            $student_id = trim($this->security->xss_clean($this->input->post('student_id')));
            $dob = $this->input->post('dob');
            $password = $this->input->post('password');
            $isExist = $this->registration_model->isStudentAlreadyRegisterd($student_id);
            if (substr($student_id, 0 , 2) == '21') {
                $term_name = 'IPUC';
            }else{
                $term_name = 'IIPUC'; 
            }
            if($isExist > 0){
                $this->session->set_flashdata('error', $student_id .' is Already Registered.');
                $this->load->view('register/userRegistration');
            }else{
                $isValid = $this->registration_model->checkStuentIdAndDobIsValid($student_id,$term_name);
                if($isValid == NULL){
                    $this->session->set_flashdata('error','Student ID is Invalid.');
                    $this->load->view('register/userRegistration');
                }else if($isValid != NULL){
                    $dob_from_db = str_replace('/', '-', $isValid->dob);
                    if(date('Y-m-d',strtotime($dob_from_db)) == date('Y-m-d',strtotime($dob))){
                        $studentInfo = array('student_id'=>$student_id, 'dob'=> date('Y-m-d',strtotime($dob)), 
                        'password'=>getHashedPassword($password), 'password_text' => base64_encode($password),
                        'created_date'=>date('Y-m-d H:i:s'));
                        $result = $this->registration_model->userRegisterDB($studentInfo);   
                    if($result > 0){
                        $this->load->view('register/registrationMessage');
                        }else{
                        $this->session->set_flashdata('error', 'Failed To Register');
                        $this->load->view('register/userRegistration');
                        }
                    }else{
                        $this->session->set_flashdata('warning','Entered Date of Birth is Invalid.');
                        $this->load->view('register/userRegistration'); 
                    }
                   
                }else{
                    $this->session->set_flashdata('warning','Entered Date of Birth is Invalid.');
                    $this->load->view('register/userRegistration');
                }
                
               
            }
           
        }
    }

}
    