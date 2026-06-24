<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Enquiry extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Enquiry_model','enquiry');
        $this->isLoggedIn();
    }
    function enquiryListing() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {        
            $filter = array();
            $searchText = $this->security->xss_clean($this->input->post('searchTextCust'));
            $by_name = $this->security->xss_clean($this->input->post('by_name'));
            $by_email = $this->security->xss_clean($this->input->post('by_email'));
            $by_term_name = $this->security->xss_clean($this->input->post('by_term_name'));
            $by_stream_name = $this->security->xss_clean($this->input->post('by_stream_name'));
            $by_elective_sub = $this->security->xss_clean($this->input->post('by_elective_sub'));
            $by_phone_no = $this->security->xss_clean($this->input->post('by_phone_no'));
            $hostel_facility = $this->security->xss_clean($this->input->post('hostel_facility'));
            
            $data['searchTextCust'] = $searchText;
            $filter['searchTextCust'] = $searchText;

            $data['by_name'] = $by_name;
            $filter['by_name'] = $by_name;

            $data['by_email'] = $by_email;
            $filter['by_email'] = $by_email;

            $data['by_term_name'] = $by_term_name;
            $filter['by_term_name'] = $by_term_name;

            $data['by_stream_name'] = $by_stream_name;
            $filter['by_stream_name'] = $by_stream_name;

            $data['by_elective_sub'] = $by_elective_sub;
            $filter['by_elective_sub'] = $by_elective_sub;

            $data['by_phone_no'] = $by_phone_no;
            $filter['by_phone_no'] = $by_phone_no;

            $data['hostel_facility'] = $hostel_facility;
            $filter['hostel_facility'] = $hostel_facility;
            
            $count = $this->enquiry->enquiryListingCount($filter);
            $returns = $this->paginationCompress("enquiryListing/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['enquiryInfo'] = $this->enquiry->enquiryListing($filter);
            $data['streamInfo'] = $this->enquiry->getAllStreamName();
            $this->global['pageTitle'] = ''.TAB_TITLE.': Staffs Details';
            $this->loadViews("admissionEnquiry/enquiry", $this->global, $data , NULL);
        }
    }

    public function deleteEnquiry(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $enquiryInfo = array('is_deleted' => 1,'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->enquiry->updateEnquiryInfo($enquiryInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    function addNewAdmission() {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {
            $data['streamInfo'] = $this->enquiry->getAllStreamName();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Add New Student';
            $this->loadViews("admissionEnquiry/addNewAdmission", $this->global,$data, NULL);
        }
    }

    public function addAdmissionInfoToDB(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name','Name','trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->form_validation->set_rules('term_name', 'Term Name', 'trim|required');
            $this->form_validation->set_rules('stream_name', 'Stream Name', 'trim|required');
            $this->form_validation->set_rules('elective_sub', 'Language', 'trim|required');
            $this->form_validation->set_rules('current_institution_name', 'Institution Name', 'trim|required');
            $this->form_validation->set_rules('exam_coaching', 'Exam Coaching', 'trim|required');
            $this->form_validation->set_rules('phone_no','Phone Number','required|numeric|min_length[10]');
            $this->form_validation->set_rules('hostel_facility', 'Hostel facility', 'trim|required');
            
            if($this->form_validation->run() == FALSE) {
                $this->enquiryListing();
            } else {
                   
                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('name'))));
                $email = $this->security->xss_clean($this->input->post('email'));
                $term_name = $this->security->xss_clean($this->input->post('term_name'));
                $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
                $term_name = $this->security->xss_clean($this->input->post('term_name'));
                $elective_sub = $this->security->xss_clean($this->input->post('elective_sub'));
                $current_institution_name = $this->security->xss_clean($this->input->post('current_institution_name'));
                $exam_coaching = $this->security->xss_clean($this->input->post('exam_coaching'));
                $comment = $this->security->xss_clean($this->input->post('comment'));
                $phone_no = $this->security->xss_clean($this->input->post('phone_no'));
                $program_name = $this->security->xss_clean($this->input->post('program_name'));
                $hostel_facility = $this->security->xss_clean($this->input->post('hostel_facility'));
                $isExist = $this->enquiry->checkMobileNumberOrEmailExists($phone_no,$email);
                $admissionInfo = array(
                        'name'=>$name,
                        'email'=>$email,
                        'phone_no'=>$phone_no,
                        'term_name'=>$term_name,
                        'program_name'=>$program_name,
                        'stream_name'=>$stream_name,
                        'elective_sub'=>$elective_sub,
                        'hostel_facility'=>$hostel_facility,
                        'current_institution_name'=>$current_institution_name,
                        'exam_coaching'=>$exam_coaching,
                        'comment'=>$comment,
                        'created_by'=>$this->staff_id,
                        'created_date_time'=>date('Y-m-d H:i:s'));
                        
                if($isExist > 0){
                    $this->session->set_flashdata('warning', 'EmailId Already Exists');
                    redirect('addNewAdmission');
                }else{
                    $result = $this->enquiry->addAdmissionInfo($admissionInfo);
                   
                }
                if($result > 0){

                    $this->session->set_flashdata('success', 'Admission Info Added Successfully');
                } else {
                    $this->session->set_flashdata('error', 'Admission Adding  failed');
                } 
                redirect('enquiryListing');  
        
          }
        }
    }

    public function editAdmission($row_id = null)
    {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            if ($row_id == null) {
                redirect('enquiryListing');
            }
            $data['admissionInfo'] = $this->enquiry->getAdmissionInfoById($row_id);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Admission Enquiry Details';
            $this->loadViews("admissionEnquiry/editAdmission", $this->global, $data, null);
        }
    }

    public function updateAdmission()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $row_id = $this->input->post('row_id');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name','Name','trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->form_validation->set_rules('term_name', 'Term Name', 'trim|required');
            $this->form_validation->set_rules('stream_name', 'Stream Name', 'trim|required');
            $this->form_validation->set_rules('phone_no','Phone Number','required|numeric|min_length[10]');
            $this->form_validation->set_rules('hostel_facility', 'Hostel facility', 'trim|required');

            if ($this->form_validation->run() == false) {
                $this->editAdmission();
            } else {
                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('name'))));
                $email = $this->security->xss_clean($this->input->post('email'));
                $term_name = $this->security->xss_clean($this->input->post('term_name'));
                $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
                $term_name = $this->security->xss_clean($this->input->post('term_name'));
                $elective_sub = $this->security->xss_clean($this->input->post('elective_sub'));
                $current_institution_name = $this->security->xss_clean($this->input->post('current_institution_name'));
                $exam_coaching = $this->security->xss_clean($this->input->post('exam_coaching'));
                $comment = $this->security->xss_clean($this->input->post('comment'));
                $phone_no = $this->security->xss_clean($this->input->post('phone_no'));
                $program_name = $this->security->xss_clean($this->input->post('program_name'));
                $hostel_facility = $this->security->xss_clean($this->input->post('hostel_facility'));
               
                $admissionInfo = array(
                        'name'=>$name,
                        'email'=>$email,
                        'phone_no'=>$phone_no,
                        'term_name'=>$term_name,
                        'program_name'=>$program_name,
                        'stream_name'=>$stream_name,
                        'elective_sub'=>$elective_sub,
                        'hostel_facility'=>$hostel_facility,
                        'current_institution_name'=>$current_institution_name,
                        'exam_coaching'=>$exam_coaching,
                        'comment'=>$comment,
                        'updated_by'=>$this->staff_id,
                        'updated_date_time'=>date('Y-m-d H:i:s'));
               
                $result = $this->enquiry->updateAdmissionEnquiryInfo($admissionInfo, $row_id);

                if ($result > 0) {
                    $this->session->set_flashdata('success', 'Enquiry Updated successfully');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update');
                }

                redirect('editAdmission/' . $row_id);
            }
        }
    }


}