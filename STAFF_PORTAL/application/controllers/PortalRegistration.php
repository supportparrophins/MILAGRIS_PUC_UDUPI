<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require APPPATH . '/libraries/BaseControllerFaculty.php';

class PortalRegistration extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('portalRegistration_model','register');
        $this->isLoggedIn();
    }

    public function studentRegisterListing(){
        $student_id =$this->security->xss_clean($this->input->post('student_id')); 
        $by_dob =$this->security->xss_clean($this->input->post('by_dob')); 
        $by_date =$this->security->xss_clean($this->input->post('by_date')); 

        $data['student_id'] = $student_id;

        $filter['student_id'] = $student_id;

        if(!empty($by_dob)){
            $data['by_dob'] = date('d-m-Y', strtotime($by_dob));
            $filter['by_dob'] = date('Y-m-d', strtotime($by_dob));
        }else{
            $data['by_dob'] = '';
        }
        if(!empty($by_date)){
            $data['by_date'] = date('d-m-Y', strtotime($by_date));
            $filter['by_date'] = date('Y-m-d', strtotime($by_date));
        }else{
            $data['by_date'] = '';
        }
        $this->load->library('pagination');
        $count = $this->register->registeredStudentsCount($filter);
        $returns = $this->paginationCompress("studentRegisterListing/", $count, 100);
        $data['totalStudentCount'] = $count;
        $filter['page'] = $returns["page"];
        $filter['segment'] = $returns["segment"];
        $data['registrationData'] = $this->register->registeredStudents($filter);
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Student Portal Registration';
        $this->loadViews("students/portalRegistration", $this->global, $data , NULL);
    }

    
    public function updateStudentPassword(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('password','Password','trim|required|min_length[6]');
         
            if($this->form_validation->run() == FALSE) {
                $this->studentRegisterListing();  
            } else {
                $row_id = $this->security->xss_clean($this->input->post('row_id'));
                $password =  $this->security->xss_clean($this->input->post('password'));
                $registerInfo = array(
                    'password' => getHashedPassword($password), 
                    'password_text' => base64_encode($password), 
                    'updated_by' => $this->staff_id, 
                    'updatedDtm' => date('Y-m-d H:i:s'));
                $result = $this->register->updatePassword($registerInfo, $row_id);
                
                if($result > 0) {
                    $this->session->set_flashdata('success', 'Password Updated successfully');
                } else {
                    $this->session->set_flashdata('error', 'Failed To Update');
                }
                redirect('studentRegisterListing');  
             
            }
        }
    }
    public function deleteRegisteredStudent(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $registerInfo = array('is_deleted' => 1,'updated_by' => $this->staff_id,'updatedDtm' => date('Y-m-d H:i:s'));
            $result = $this->register->updatePassword($registerInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

   

}
?>