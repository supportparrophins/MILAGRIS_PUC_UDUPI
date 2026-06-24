<?php if (!defined('BASEPATH')) {

exit('No direct script access allowed');

}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class SalaryDashboard extends BaseController {

public function __construct()

{
    parent::__construct();
    $this->load->model('user_model');
    $this->load->model('salaryDashboard_model','salary');
    $this->load->model('staff_model','staff');
    $this->isLoggedIn();

}

public function viewSalaryDashboard()
{
    $month = $this->security->xss_clean($this->input->post('month'));
    if($month == '') {
        $month = strtoupper(date('F', strtotime('first day of last month')));
    }else {
        $month  = $month;
    }
    $todayDate = date('Y-m-d');
    $filter = array();
    $by_class = array();
    $studentCount = array();
    $totalStudent = 0;

    $deptInfo = $this->staff->getStaffDepartment();
    $data = [];
    $data['staff_counts'] = [];
    foreach($deptInfo as $dept){
        $filter['by_role'] = '';
        $filter['by_dept'] = $dept->dept_id;
        $countStaff = $this->staff->staffListingCount($filter);
        $data['staff_counts'][$dept->name] = $countStaff;

    }
    $filter['by_role'] = '';
    $data['total_staffs']= $this->staff->staffListingCount($filter);
    $data['staffCount'] = $staffCount;
    // $data['deptInfo'] =   $deptInfo;
    $data['staffModel'] =  $this->staff;
    $data['month'] =  $month;    
    $data['salaryModel'] =  $this->salary;
    $data['basicInfo'] = $this->salary->getEarningInfo('BASIC');
    $data['conInfo'] = $this->salary->getEarningInfo('CON');
    $data['daInfo'] = $this->salary->getEarningInfo('DA');
    $data['hraInfo'] = $this->salary->getEarningInfo('HRA');
    $data['othersInfo'] = $this->salary->getEarningInfo('OTHERS');
    
    $data['pfInfo'] = $this->salary->getdeductionInfo('PF');
    $data['esiInfo'] = $this->salary->getdeductionInfo('ESI');
    $data['ptInfo'] = $this->salary->getdeductionInfo('PT');
    $data['otherInfo'] = $this->salary->getdeductionInfo('OTHERS');
    $data['itInfo'] = $this->salary->getdeductionInfo('IT');
    $data['getSalarySlipInfo'] = $this->salary->getStaffSalarySlipInfo($month);
    $data['display_type_c'] = "feeDashboard";
    $this->global['pageTitle'] = ''.TAB_TITLE.' : Salary Dashboard';
    $this->loadViews("salaryDashboard", $this->global, $data, null);
}

}?>