<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Holiday extends BaseController {
    public function __construct()
    {
        parent::__construct();
        //$this->load->library('excel');
        $this->load->model('staff_model','staff');
        $this->load->model('leave_model','leave');
        $this->load->model('holiday_model','holiday');
        $this->isLoggedIn();
    }
    function viewHolidayList()

    {

        if($this->isAdmin() == TRUE)

        {

            $this->loadThis();

        }

        else

        {        

            $filter = array();

            $reason = $this->input->post('reason'); 

            $by_date =$this->security->xss_clean($this->input->post('by_date')); 



            $data['reason'] = $reason;

            $data['by_date'] = $by_date;



            $filter['reason'] = $reason;

            $filter['by_date'] = $by_date;

            $role = $this->role;

            $this->load->library('pagination');

            $count = $this->holiday->getHolidayCount($filter,$role);
            $data['designation'] = $this->holiday->getStaffRolesForStaff($this->staff_id);

			$returns = $this->paginationCompress ( "viewHolidayList/", $count, 100);

            $data['count_holiday'] = $count;
            $data['holiday_model'] = $this->holiday;

            $data['holidayRecords'] = $this->holiday->getHolidayListing($filter, $returns["page"], $returns["segment"],$role);
            
            $data['accessInfo'] = $this->getCurrentAccess();

            $this->global['pageTitle'] = ''.TAB_TITLE.' : Holiday Details';

            $this->loadViews("holiday/viewHoliday", $this->global, $data , NULL);

        }

    }

    public function addNewHoliday() {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('fromDateFrom', 'Holiday Date', 'trim|required');
            $this->form_validation->set_rules('reason', 'Reason', 'trim|required');
    
            if ($this->form_validation->run() == FALSE) {
                $this->viewHolidayList();
            } else {
                $date_from = $this->security->xss_clean($this->input->post('fromDateFrom'));
                $date_to = $this->security->xss_clean($this->input->post('fromDateTo'));
                $reason = $this->security->xss_clean($this->input->post('reason'));
                $all = $this->input->post('all');
                $only_students = $this->input->post('only_students');
                $role_ids = $this->input->post('role_ids');
    
                // Check if "ALL" is selected for all roles
                if ($all == '1' || (is_array($role_ids) && in_array('ALL', $role_ids))) {
                    $only_students = 1;
                    $role_ids = array_column($this->holiday->getStaffRolesForStaff($this->staff_id), 'roleId');
                }
    
                // Convert role IDs array to a comma-separated string, or set to 'all'
                $role_status = is_array($role_ids) ? implode(',', $role_ids) : 'all';
    
                $holidayInfo = array(
                    'holiday_date' => date('Y-m-d', strtotime($date_from)),
                    'holiday_date_to' => date('Y-m-d', strtotime($date_to)),
                    'reason' => $reason,
                    'students_status' => $only_students ? 1 : 0,
                    'role_status' => $role_status,
                    'created_by' => $this->staff_id,
                    'created_date_time' => date('Y-m-d H:i:s')
                );
    
                $return_id = $this->holiday->addNewHoliday($holidayInfo);
    
                if ($return_id > 0) {
                    $this->session->set_flashdata('success', 'New Holiday Added Successfully');
                } else {
                    $this->session->set_flashdata('error', 'New Holiday Add failed');
                }
    
                redirect('viewHolidayList');
            }
        }
    }

    public function editHoliday($row_id = null)

    {

        if ($this->isAdmin() == true ) {

            $this->loadThis();

        } else {

            if ($row_id == null) {

                redirect('viewHolidayList');

            }

            $data['holidayInfo'] = $this->holiday->getHolidayInfoById($row_id);

            $data['designation'] = $this->holiday->getStaffRolesForStaff($this->staff_id);

            $data['roles'] = $this->holiday->getRolesByHolidayId($row_id); // Assuming this method returns roles with their status



            $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit Holiday Info';

            $this->loadViews("holiday/editHolidayInfo", $this->global, $data, null);

        }

    }
//update holiday info
public function updateHoliday() {
    if ($this->isAdmin() == true) {
        $this->loadThis();
    } else {
        $row_id = $this->input->post('row_id');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('fromDateFrom', 'Holiday Date From', 'trim|required');
        $this->form_validation->set_rules('reason', 'Reason', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            // Redirect back to the edit holiday page with the row ID if validation fails
            redirect('editHoliday/' . $row_id);
        } else {
            $date_from = $this->security->xss_clean($this->input->post('fromDateFrom'));
            $date_to = $this->security->xss_clean($this->input->post('fromDateTo'));
            $reason = $this->security->xss_clean($this->input->post('reason'));
            $only_students = $this->input->post('only_student');
            $role_ids = $this->input->post('role_ids');

            // If "ALL" is selected, treat it as leave for everyone
            // if ($this->input->post('all') == '1') {
            //     $only_students = 1;
            //     $role_ids = array_column($this->holiday->getStaffRolesForStaff($this->staff_id), 'roleId');
            // }

            // Prepare role_status as a comma-separated string of role IDs
            $role_status = is_array($role_ids) && !in_array('all', $role_ids) ? implode(',', $role_ids) : 'all';

            $holidayInfo = array(
                'holiday_date' => date('Y-m-d', strtotime($date_from)),
                'holiday_date_to' => date('Y-m-d', strtotime($date_to)),
                'reason' => $reason,
                'students_status' => $only_students ? 1 : 0,
                'role_status' => $role_status,
                'updated_by' => $this->staff_id,
                'updated_date_time' => date('Y-m-d H:i:s')
            );

            $return_id = $this->holiday->updateHoliday($holidayInfo, $row_id);

            if ($return_id) {
                $this->session->set_flashdata('success', 'Holiday Updated Successfully');
            } else {
                $this->session->set_flashdata('error', 'Holiday Update failed');
            }

            redirect('editHoliday/' . $row_id);
        }
    }
}
    public function deleteHoliday(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $holidayInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->holiday->updateHoliday($holidayInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }


}
