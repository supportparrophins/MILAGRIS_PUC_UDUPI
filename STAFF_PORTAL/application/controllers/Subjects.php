<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Subjects extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('staff_model','staff');
        $this->load->model('subjects_model','subject');
        $this->isLoggedIn();   
    }

    function subjectDetails() {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
            $data['accessInfo'] = $this->getCurrentAccess();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Subject Details';
            $this->loadViews("subjects/subjects", $this->global,$data, NULL);
        }
    }

    public function get_subjects(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
            $draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));
            $data_array_new = [];
            $subjectInfo = $this->subject->getAllSubjectInfo();
            $accessInfo = $this->getCurrentAccess();
            foreach($subjectInfo as $subject) {
                $editButton = "";
                $deleteButton = "";
            
                //if($this->role == ROLE_ADMIN || $this->role == ROLE_PRIMARY_ADMINISTRATOR || $this->role == ROLE_OFFICE || $this->role == ROLE_SUPER_ADMIN){
                if($accessInfo->can_delete == 1){
                    $deleteButton = '<a class="btn btn-xs btn-danger deleteSubject" href="#"
                    data-row_id="'.$subject->row_id.'" title="Delete Subjects"><i
                        class="fa fa-trash"></i></a>';
                }
                if($accessInfo->can_edit == 1){
                    $editButton = '<a class="btn btn-xs btn-info"
                    href="'.base_url().'editSubjectsById/'.$subject->row_id.'" title="Edit Subjects"><i
                        class="fas fa-pencil-alt"></i></a>';
                    }

                if($subject->lab_status == 'true'){
                    $labStatus = 'Yes';
                } else {
                    $labStatus = 'No';
                }

                $data_array_new[] = array(
                    $subject->subject_code,
                    $subject->sub_name,
                    $subject->sub_type,
                    $subject->name,
                    $labStatus,
                    $editButton.' '.$deleteButton
                );
            }
            $count = count($subjectInfo);
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

    public function addNewSubject()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $data['departments'] = $this->staff->getStaffDepartment();
            $this->global['pageTitle'] = 'SchholPhins-JNPUC : Add New Subject';
            $this->loadViews("subjects/addNewSubject", $this->global, $data, null);
        }
    }

    public function addNewSubjectToDB()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('sub_name', 'Subject Name', 'trim|required');
            $this->form_validation->set_rules('sub_code', 'Subject Code', 'trim|required');
            $this->form_validation->set_rules('subject_type', 'Subject Type', 'trim|required');
            $this->form_validation->set_rules('lab_status', 'Lab included', 'required');
            $this->form_validation->set_rules('department', 'Department', 'trim|required');

            if ($this->form_validation->run() == false) {
                $this->addNewSubject();
            } else {
                $sub_name = ucwords(strtolower($this->security->xss_clean($this->input->post('sub_name'))));
                $sub_code = $this->input->post('sub_code');
                $subject_type = $this->input->post('subject_type');
                $lab_status = $this->security->xss_clean($this->input->post('lab_status'));
                $isExist = $this->subject->checkSubjectCodeExists($sub_code);
                if($isExist > 0) { 
                    $this->session->set_flashdata('warning', 'Subject Code Already Exists');
                } else {
                    $department = $this->input->post('department');
                    $subInfo = array(
                        'subject_code' => $sub_code, 
                        'name' => $sub_name, 
                        'sub_type' => $subject_type,
                        'lab_status' => $lab_status, 
                        'department_id' => $department, 
                        'updated_by' => $this->staff_id, 
                        'modified_date' => date('Y-m-d H:i:s'));
                    $result = $this->subject->addNewSubject($subInfo);

                    if ($result > 0) {
                        $this->session->set_flashdata('success', 'New Subject Added successfully');
                    } else {
                        $this->session->set_flashdata('error', 'New Subject Add failed');
                    }
                }

                redirect('subjectDetails');
            }
        }
    }

    public function checkSubjectCodeExists()
    {
        $id = $this->input->post("row_id");
        $sub_code = $this->input->post("sub_code");
        if (empty($sub_code)) {
            $result = $this->subject->checkSubjectCodeExists($sub_code);
        } else {
            $result = $this->subject->checkSubjectCodeExists($sub_code, $id);
        }

        if (empty($result)) {echo ("true");} else {echo ("false");}
    }

    public function editSubjectsById($row_id = null)
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {
            if($row_id == null) {
                redirect('subjectDetails');
            }
            $data['departments'] = $this->staff->getStaffDepartment();
            $data['subjectInfo'] = $this->subject->getAllSubjectInfoById($row_id);
            $data['active'] = '';
            $this->global['pageTitle'] = ''.TAB_TITLE.' : View Subject Details';
            $this->loadViews("subjects/editSubject", $this->global, $data, null);
        }
    }

    public function updateSubject()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('sub_name', 'Subject Name', 'trim|required');
            $this->form_validation->set_rules('sub_code', 'Subject Code', 'trim|required');
            $this->form_validation->set_rules('subject_type', 'Subject Type', 'trim|required');
            $this->form_validation->set_rules('lab_status', 'Lab included', 'required');
            $this->form_validation->set_rules('department', 'Department', 'trim|required');

            if ($this->form_validation->run() == false) {
                $this->editSubjectsById();
            } else {
                $sub_name = ucwords(strtolower($this->security->xss_clean($this->input->post('sub_name'))));
                $sub_code = $this->input->post('sub_code');
                $subject_type = $this->input->post('subject_type');
                $lab_status = $this->security->xss_clean($this->input->post('lab_status'));
                $department = $this->input->post('department');
                $row_id = $this->input->post('row_id');

                $isExist = $this->subject->checkSubjectCodeExists($sub_code, $row_id);
                if($isExist > 0) { 
                    $this->session->set_flashdata('warning', 'Subject Code Already Exists');
                } else {
                    $subInfo = array(
                        'subject_code' => $sub_code, 
                        'name' => $sub_name, 
                        'sub_type' => $subject_type,
                        'lab_status' => $lab_status, 
                        'department_id' => $department, 
                        'updated_by' => $this->staff_id, 
                        'modified_date' => date('Y-m-d H:i:s'));
                
                    $result = $this->subject->editSubject($subInfo, $row_id);

                    if ($result > 0) {
                        $this->session->set_flashdata('success', 'Subject Edited successfully');
                    } else {
                        $this->session->set_flashdata('error', 'Subject Edited is failed');
                    }
                }

                redirect('editSubjectsById/' . $row_id);
            }
        }
    }

    public function deleteSubject(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $subInfo = array('is_deleted' => 1,'modified_date' => date('Y-m-d H:i:s'));
            $result = $this->subject->editSubject($subInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
}