<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerFaculty.php';
require_once 'vendor/autoload.php';

class Salary extends BaseController
{
 public function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
        $this->load->model('salary_model','salary');
        $this->load->model('staff_model','staff');
        $this->load->model('settings_model','settings');
        $this->load->model('leave_model','leave');      
        $this->isLoggedIn();   
    }
    function salarySlipListing()
    {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $filter = array();
            $name = $this->security->xss_clean($this->input->post('name'));
            $date = $this->security->xss_clean($this->input->post('date'));
            $staff_id = $this->security->xss_clean($this->input->post('staff_id'));
            $gross_salary = $this->security->xss_clean($this->input->post('gross_salary'));
            $grade_pay = $this->security->xss_clean($this->input->post('grade_pay'));
            $net_amount = $this->security->xss_clean($this->input->post('net_amount'));
            $basic = $this->security->xss_clean($this->input->post('basic'));
            $working_day = $this->security->xss_clean($this->input->post('working_day'));
            $lop_day = $this->security->xss_clean($this->input->post('lop_day'));
            $by_month = $this->security->xss_clean($this->input->post('by_month'));
            $by_year = $this->security->xss_clean($this->input->post('by_year'));
            // $factory_name = $this->security->xss_clean($this->input->post('factory_name'));

            $data['name'] = $name;
            $data['gross_salary'] = $gross_salary;
            $data['grade_pay'] = $grade_pay;
            $data['staff_id'] = $staff_id;
            $data['net_amount'] = $net_amount;
            $data['basic'] = $basic;
            $data['working_day'] = $working_day;
            $data['lop_day'] = $lop_day;
            $data['by_month'] = $by_month;
            $data['by_year'] = $by_year;
            // $data['factory_name'] = $factory_name;
            
            
            // $filter['factory_name'] = $factory_name;
            $filter['name'] = $name;
            $filter['gross_salary'] = $gross_salary;
            $filter['staff_id'] = $staff_id;
            $filter['net_amount'] = $net_amount;
            $filter['basic'] = $basic;
            $filter['working_day'] = $working_day;
            $filter['lop_day'] = $lop_day;
            $filter['by_month'] = $by_month;
            $filter['by_year'] = $by_year;

            if(!empty($date)){
                $filter['date'] = date('Y-m-d',strtotime($date));
                $data['date'] = date('d-m-Y',strtotime($date));
            }else{
                $data['date'] = '';
                $filter['date'] = '';
            }
            $this->load->library('pagination');
            $count = $this->salary->getAllSalaryCount($filter);
            $returns = $this->paginationCompress("salarySlipListing/", $count, 100);
            $data['totalSalaryCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['staffInfo'] = $this->staff->getStaffDetails($filter);
            $data['designation'] = $this->staff->getStaffRolesForStaff($this->staff_id);
            $data['staffInfo'] = $this->staff->getAllStaffInfo();
            $data['salaryYearInfo'] = $this->salary->getStaffSalaryYearInfo();
            $data['accessInfo'] = $this->getCurrentAccess();
            // $data['factoryNameInfo'] = $this->settings->getAllFactoryNameInfo();
            $data['salaryInfo'] = $this->salary->getAllSalaryInfo($filter, $returns["page"], $returns["segment"]);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Salary Slip Details';
            $this->loadViews("salary/salary.php", $this->global, $data, NULL);

        }
    }
  

        public function addNewSalarySlipInfo() {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

             $this->form_validation->set_rules('staff_id', 'Staff', 'trim|required');
            if ($this->form_validation->run() == false) {
                $this->salarySlipListing();
            } else {
                $staff_id = $this->security->xss_clean($this->input->post('staff_id'));
                $service = $this->security->xss_clean($this->input->post('service'));
                $category = $this->security->xss_clean($this->input->post('category'));
                $account_no = $this->security->xss_clean($this->input->post('account_no'));
                $basic = $this->security->xss_clean($this->input->post('basic'));
                $da = $this->security->xss_clean($this->input->post('da'));
                $hra = $this->security->xss_clean($this->input->post('hra'));
                $ta = $this->security->xss_clean($this->input->post('ta'));
                $grade_pay = $this->security->xss_clean($this->input->post('grade_pay'));
                $mgt_cont_to_pf_1 = $this->security->xss_clean($this->input->post('mgt_cont_to_pf_1'));
                $admin_charges_1 = $this->security->xss_clean($this->input->post('admin_charges_1'));
                $gross_salary = $this->security->xss_clean($this->input->post('gross_salary'));
                $mgt_cont_to_pf_2 = $this->security->xss_clean($this->input->post('mgt_cont_to_pf_2'));
                $admin_charges_2 = $this->security->xss_clean($this->input->post('admin_charges_2'));
                $pf = $this->security->xss_clean($this->input->post('pf'));
                $pt = $this->security->xss_clean($this->input->post('pt'));
                $lic = $this->security->xss_clean($this->input->post('lic'));
                $school_loan = $this->security->xss_clean($this->input->post('school_loan'));
                $bank_guardian = $this->security->xss_clean($this->input->post('bank_guardian'));
                $sib = $this->security->xss_clean($this->input->post('sib'));
                $it = $this->security->xss_clean($this->input->post('it'));
                $lop = $this->security->xss_clean($this->input->post('lop'));
                $total_deduction = $this->security->xss_clean($this->input->post('total_deduction'));
                $net_amount = $this->security->xss_clean($this->input->post('net_amount'));
                $data['salaryYearInfo'] = $this->salary->getStaffSalaryYearInfo();
                // $isExist = $this->salary->checkVisitorExists($mobile_number);
                // if(!empty($isExist)){
                //     $this->session->set_flashdata('warning', 'Visitor  Already Exists');
                //     redirect('visitorListing');
                // }else{
                     $info = array(
                        'staff_id' => $staff_id, 
                        'service' => $service, 
                        'category' => $category, 
                        'account_no' => $account_no, 
                        'basic' => $basic, 
                        'da' => $da, 
                        'hra' => $hra, 
                        'ta' => $ta, 
                        'grade_pay' => $grade_pay, 
                        'mgt_cont_to_pf_1' => $mgt_cont_to_pf_1, 
                        'admin_charges_1' => $admin_charges_1, 
                        'gross_salary' => $gross_salary, 
                        'mgt_cont_to_pf_2' => $mgt_cont_to_pf_2, 
                        'admin_charges_2' => $admin_charges_2, 
                        'pf' => $pf, 
                        'pt' => $pt, 
                        'lic' => $lic, 
                        'school_loan' => $school_loan, 
                        'bank_guardian' => $bank_guardian, 
                        'sib' => $sib, 
                        'it' => $it, 
                        'lop' => $lop, 
                        'total_deduction' => $total_deduction, 
                        'net_amount' => $net_amount,
                        'year' => d('Y'),
                        'month' => d('m'),
                        'date' => d('Y-m-d'),
                        'created_by'=>$this->staff_id,
                        'created_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->salary->addSalarySlipInfo($info);
                    if ($result > 0) {
                        $this->session->set_flashdata('success', 'New Salary Slip Info Added successfully');
                    } else {
                        $this->session->set_flashdata('error', 'New Salary Slip Info Add failed');
                    }
                 // }
                 
                redirect('salarySlipListing');
            }
        }
    }

    
    
    public function editSalarySlip($row_id = null)
    {
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            if ($row_id == null) {
                redirect('salarySlipListing');
            }
            $data['staffInfo'] = $this->staff->getStaffDetails();
            $data['salaryInfo'] = $this->salary->getSalaryInfoById($row_id);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit Salary Slip';
            $this->loadViews("salary/editSalary", $this->global, $data, null);
        }
    }

    public function updateSalarySlip(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
             $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
            $this->form_validation->set_rules('staff_id', 'Staff', 'trim|required');
            if($this->form_validation->run() == FALSE) {
                $this->editSalarySlip();
            } else {

             $staff_id = $this->security->xss_clean($this->input->post('staff_id'));
            $service = $this->security->xss_clean($this->input->post('service'));
            $category = $this->security->xss_clean($this->input->post('category'));
            $account_no = $this->security->xss_clean($this->input->post('account_no'));
            $basic = $this->security->xss_clean($this->input->post('basic'));
            $da = $this->security->xss_clean($this->input->post('da'));
            $hra = $this->security->xss_clean($this->input->post('hra'));
            $ta = $this->security->xss_clean($this->input->post('ta'));
            $grade_pay = $this->security->xss_clean($this->input->post('grade_pay'));
            $mgt_cont_to_pf_1 = $this->security->xss_clean($this->input->post('mgt_cont_to_pf_1'));
            $admin_charges_1 = $this->security->xss_clean($this->input->post('admin_charges_1'));
            $gross_salary = $this->security->xss_clean($this->input->post('gross_salary'));
            $mgt_cont_to_pf_2 = $this->security->xss_clean($this->input->post('mgt_cont_to_pf_2'));
            $admin_charges_2 = $this->security->xss_clean($this->input->post('admin_charges_2'));
            $pf = $this->security->xss_clean($this->input->post('pf'));
            $pt = $this->security->xss_clean($this->input->post('pt'));
            $lic = $this->security->xss_clean($this->input->post('lic'));
            $school_loan = $this->security->xss_clean($this->input->post('school_loan'));
            $bank_guardian = $this->security->xss_clean($this->input->post('bank_guardian'));
            $sib = $this->security->xss_clean($this->input->post('sib'));
            $it = $this->security->xss_clean($this->input->post('it'));
            $lop = $this->security->xss_clean($this->input->post('lop'));
            $total_deduction = $this->security->xss_clean($this->input->post('total_deduction'));
            $net_amount = $this->security->xss_clean($this->input->post('net_amount'));


           
                    $info = array(
                        'staff_id' => $staff_id, 
                        'service' => $service, 
                        'category' => $category, 
                        'account_no' => $account_no, 
                        'basic' => $basic, 
                        'da' => $da, 
                        'hra' => $hra, 
                        'ta' => $ta, 
                        'grade_pay' => $grade_pay, 
                        'mgt_cont_to_pf_1' => $mgt_cont_to_pf_1, 
                        'admin_charges_1' => $admin_charges_1, 
                        'gross_salary' => $gross_salary, 
                        'mgt_cont_to_pf_2' => $mgt_cont_to_pf_2, 
                        'admin_charges_2' => $admin_charges_2, 
                        'pf' => $pf, 
                        'pt' => $pt, 
                        'lic' => $lic, 
                        'school_loan' => $school_loan, 
                        'bank_guardian' => $bank_guardian, 
                        'sib' => $sib, 
                        'it' => $it, 
                        'lop' => $lop, 
                        'total_deduction' => $total_deduction, 
                        'net_amount' => $net_amount,
                        'updated_by' => $this->staff_id,
                        'updated_date_time' =>date('Y-m-d H:i:s'));

                $return_id = $this->salary->updateSalarySlipInfo($info,$row_id);
            
                if($return_id){
                    $this->session->set_flashdata('success', 'Salary Slip Updated Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Salary Slip Update failed');
                }
                redirect('editSalarySlip/'.$row_id);
            }
        }
    }
  

    public function deleteSalarySlip(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $info = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->salary->updateSalarySlipInfo($info, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

//    public function addSalarySlip(){
        
//         $year = $this->security->xss_clean($this->input->post('year'));
//         $month = $this->security->xss_clean($this->input->post('month'));

//         // Validate year and month (optional but recommended)
//         if (is_numeric($year) && $year >= 0 && $year <= 9999 && is_string($month)) {
//             // Convert the month name to a month number (1 to 12)
//             $monthNumber = date('n', strtotime("1 $month 2000"));
//             // Get the number of days in the specified month and year
//             $numDays = cal_days_in_month(CAL_GREGORIAN, $monthNumber, $year);
//         }
//            // Find the start and end dates of the specified month and year
//         $date_from = date('Y-m-01', strtotime("$year-$monthNumber-01"));
//         $date_to = date('Y-m-t', strtotime("$year-$monthNumber-01"));
//         $filter = array();
//         if($this->role == ROLE_MANAGER){
//             $filter['staff_factory'] = $this->factory;
//         }
//         $staffInfo = $this->staff->getAllStaffInfoSalarySlipGenartion($filter);

//           foreach($staffInfo as $staff) {
//             $IsExists = $this->salary->CheckSlarySlipGenerated($staff->staff_id,$year,$month);
//             if(empty($IsExists)){
//                     $working_day = 0;
//                     $attInformation = $this->salary->getSingleStaffAttendanceInfoAB($staff->staff_id,$date_from,$date_to);
//                     foreach($attInformation as $attInfo) { 
//                             if(!empty($attInfo->punch_time)){
//                                 $working_day++;
//                             }
//                     }
//                 if($working_day!=0){
//                     if(!empty($staff->salary_id)){
//                         $total_advance_salary = 0;
//                         $AdvanceSalaryInfo = $this->salary->getStaffAdvanceSalaryInfo($staff->staff_id);
//                         $OTInfo = $this->salary->getStaffOtInfo($staff->staff_id,$date_from,$date_to);
                        
//                         $total_allowances = $staff->hr + $staff->con + $staff->da ;
//                         $total_salary = $staff->basic_salary + $total_allowances + $OTInfo;
//                         $basic_deduction = ($staff->basic_salary * $working_day)/$numDays;
//                         $allowance_deduction = ($total_allowances * $working_day)/$numDays;
//                         $salary_paid = $basic_deduction + $allowance_deduction + $OTInfo;

//                         foreach($AdvanceSalaryInfo as $advanceInfo){
//                             $installment_amount = $this->salary->getAdvanceSalaryPaidInfo($staff->staff_id,$advanceInfo->row_id);
//                             $PaidAmount = $advanceInfo->advance_amount - $installment_amount;
    
//                             if($PaidAmount > 0){
//                                 $advance_salary = $advanceInfo->installment_amount;
//                             }else{
//                                 $advance_salary = 0;
//                             }
//                             $total_advance_salary += $advance_salary;
//                         }
                        
//                         $pf = ($basic_deduction*$staff->pf)/100;
//                         $esi = ($basic_deduction*$staff->esi)/100;
//                         $pt = ($basic_deduction*$staff->pt)/100;
//                         $total_deduction = round($pf,2) + round($esi,2) + round($pt,2) + $total_advance_salary;
//                         $net_amount =  round($salary_paid,2) - round($total_deduction,2) ;

                       
//                         $info = array(
//                             'staff_id' => $staff->staff_id, 
//                             'account_no' => $staff->bank_account_no, 
//                             'basic' => $staff->basic_salary, 
//                             'hr' => $staff->hr, 
//                             'con' => $staff->con, 
//                             'da' => $staff->da, 
//                             'total_days' => $numDays, 
//                             'working_day' => $working_day, 
//                             'total_allowances' => $total_allowances, 
//                             'total_salary' => $total_salary, 
//                             'basic_deduction' => round($basic_deduction,2), 
//                             'allowance_deduction' => round($allowance_deduction,2), 
//                             'salary_paid' => round($salary_paid,2), 
//                             'pf' => round($pf,2), 
//                             'esi' => round($esi,2), 
//                             'pt' => round($pt,2),
//                             'advance_salary' => $total_advance_salary, 
//                             'total_deduction' => round($total_deduction,2), 
//                             'net_amount' => round($net_amount,2),
//                             'tax_regime' => $staff->tax_regime,
//                             'ot_amount' =>$OTInfo,
//                             'year' => $year,
//                             'month' => $month,
//                             'date' => date('Y-m-d'),
//                             'created_by'=>$this->staff_id,
//                             'created_date_time'=>date('Y-m-d H:i:s'));
//                         $result = $this->salary->addSalarySlipInfo($info);

//                         foreach($AdvanceSalaryInfo as $advanceInfo){
//                             $installment_amount = $this->salary->getAdvanceSalaryPaidInfo($staff->staff_id,$advanceInfo->row_id);
//                             $PaidAmount = $advanceInfo->advance_amount - $installment_amount;
    
//                             if($PaidAmount > 0){
//                                 $advance_salary_amount = $advanceInfo->installment_amount;
//                             }else{
//                                 $advance_salary_amount = 0;
//                             }
//                             if($PaidAmount > 0){
//                                 $info = array(
//                                     'staff_id' => $staff->staff_id, 
//                                     'total_amount' => $advanceInfo->advance_amount, 
//                                     'advance_id' => $advanceInfo->row_id, 
//                                     'salary_slip_id' => $result,
//                                     'installment_amount' => $advance_salary_amount, 
//                                     'year' => $year,
//                                     'month' => $month,
//                                     'date' => date('Y-m-d'),
//                                     'created_by'=>$this->staff_id,
//                                     'created_date_time'=>date('Y-m-d H:i:s'));
//                                 $this->salary->addAdvanceSalaryInstallmentInfo($info);
//                             }
//                         }
//                     }
//                 }
//             }
                    
//         } 
//         if($result>0){
//             $this->session->set_flashdata('success', 'Salary Slip Generated successfully');
//         } else {
//             $this->session->set_flashdata('error', 'Salary Slip Generation failed');
//         }
//         redirect('salarySlipListing');
//     } 

        // view TCpublic 
        public function getStaffSalaryPrint(){
            if($this->isAdmin() == TRUE){
                $this->loadThis();
            }else{
                error_reporting(0);
                $filter = array();
                $student_id = $this->security->xss_clean($this->input->get('student_id'));
                
                $student_id = base64_decode(urldecode($student_id));
                $student_id = json_decode(stripslashes($student_id));
                $filter['student_id'] = $student_id;
                $this->global['pageTitle'] = ''.TAB_TITLE.' : Salary Slip';
                $data['staffData'] = $this->salary->getStaffSalarySlipInfoById($filter);
                $data['salaryModel'] = $this->salary;
                define('_MPDF_TTFONTPATH', __DIR__ . '/fonts');
                $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','format' => 'A4-L']);
                $mpdf->AddPage('P','','','','',10,10,8,8,8,8);
                $mpdf->SetTitle('Staff Salary Slip');
                $html = $this->load->view('salary/printSalarySlipNew',$data,true);
                $mpdf->WriteHTML($html);
                $mpdf->Output('Salary_Slip.pdf', 'I');
            }
        }
        
        public function downloadStaffSalaryStatementMonthly() {
            if($this->isAdmin() == TRUE) {
                $this->loadThis();
            } else {
                $salary_month = $this->security->xss_clean($this->input->post('salary_monthly'));
                $salary_year = $this->security->xss_clean($this->input->post('year'));
                $salary_role = $this->security->xss_clean($this->input->post('staff_role_salary'));
                
                $filter['salary_month'] = $salary_month;
                $filter['salary_year'] = $salary_year;
                $filter['salary_role'] = $salary_role;

                // if (is_array($salary_role)) {
                //     if (in_array('ALL', $salary_role)) {
                //         $role_display = 'ALL';
                //     } else {
                //         $role_display = 'Multiple Roles';
                //     }
                // } else {
                //     $role_info = $this->staff->getRoleDetails($salary_role);
                //     $role_display = ($salary_role != 'ALL') ? $role_info->role : 'ALL';
                // }

                $teachingRoleIds = [53, 54, 55, 57, 58, 1, 69]; 
                // 53 = Lecturer
                // 54 = Lecturer/Vice Principal
                // 55 = Lecturer/Dean
                // 57 = Physical Director
                // 58 = Counsellor
                // 1  = Principal
                // 69 = Campus Minister & Lecturer

                $partTimeRoleId = 56; // Part-Time Lecturer

                if (is_array($salary_role)) {

                    if (in_array('ALL', $salary_role)) {
                        $role_display = 'ALL';
                    }
                    elseif (count(array_intersect($salary_role, $teachingRoleIds)) > 0) {
                        $role_display = 'Teaching Staff';
                    }
                    elseif (in_array($partTimeRoleId, $salary_role)) {
                        $role_display = 'Part Time Lecturer';
                    }
                    else {
                        $role_display = 'Non Teaching Staff';
                    }

                } else {

                    if ($salary_role == 'ALL') {
                        $role_display = 'ALL';
                    }
                    elseif (in_array($salary_role, $teachingRoleIds)) {
                        $role_display = 'Teaching Staff';
                    }
                    elseif ($salary_role == $partTimeRoleId) {
                        $role_display = 'Part Time Lecturer';
                    }
                    else {
                        $role_display = 'Non Teaching Staff';
                    }
                }

                
                // Get month numeric to calculate next month
                $timestamp = strtotime("01-".$salary_month."-".$salary_year);
                $nextMonthFunc = strtotime("+1 month", $timestamp);
                $depositDateText = "02 " . date("F Y", $nextMonthFunc);

                $staffInfo = $this->salary->getStaffSalaryDetails($filter);

                $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf', 'format' => 'A4', 'margin_left' => 10, 'margin_right' => 10, 'margin_top' => 10, 'margin_bottom' => 10]);
                $mpdf->SetTitle('Salary Statement');
                
                $html = '
                <style>
                    body { font-family: sans-serif; }
                    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                    th, td { border: 1px solid black; padding: 6px; font-size: 12px; }
                    th { background-color: #e0e0e0; text-align: center; font-weight: bold; }
                    .center { text-align: center; }
                    .right { text-align: right; }
                    .header { text-align: center; text-decoration: underline; font-weight: bold; font-size: 14px; margin-bottom: 5px; }
                    .sub-header { text-align: center; font-size: 11px; font-weight: bold; margin-bottom: 10px; }
                </style>
                <div class="header">SALARY STATEMENT ('.$role_display.')</div>
                <div class="sub-header" style="text-align:center;">
                    Salary for the month of '.$salary_month.' '.$salary_year.' has been deposited on <br>'.$depositDateText.'
                    in South Indian Bank, St. Aloysius College E.C. Branch
                </div>

                <table>
                    <thead>
                        <tr>
                            <th width="8%">Sl. No</th>
                            <th width="25%">Account No</th>
                            <th width="45%">Name</th>
                            <th width="22%">Amount</th>
                        </tr>
                    </thead>
                    <tbody>';
                
                $total_amount = 0;
                if(!empty($staffInfo)){
                    $i=1;
                    foreach($staffInfo as $staff){
                        $total_amount += $staff->net_amount;
                        $html .= '<tr>
                            <td class="center">'.$i++.'</td>
                            <td class="center">'.$staff->account_no.'</td>
                            <td>'.strtoupper($staff->name).'</td>
                            <td class="right">'.number_format($staff->net_amount, 0).'</td>
                        </tr>';
                    }
                    $html .= '<tr>
                            <td></td>
                            <td></td>
                            <td class="center" style="font-weight:bold;">TOTAL</td>
                            <td class="right" style="font-weight:bold;">'.number_format($total_amount, 0).'</td>
                        </tr>';
                }
                
                $html .= '</tbody></table>';

                $depositDateFormatted = "02-" . date("m-Y", $nextMonthFunc);
                $html .= '<br><br><br>
                <table style="width: 100%; border: none;">
                    <tr>
                        <td style="text-align: left; font-weight: bold; border: none; padding-left: 0px;" width="50%">
                            PRINCIPAL<br>
                            Date: '.$depositDateFormatted.'
                        </td>
                        <td style="text-align: right; font-weight: bold; border: none; padding-right: 0px;" width="50%">
                            FINANCE OFFICER
                        </td>
                    </tr>
                </table>';

               $mpdf->AddPage('P','','','','',25,25,5,4,2,2);
                $mpdf->WriteHTML($html);
                setcookie('isDownLoaded', 1);
                $mpdf->Output('Salary_Statement_'.$salary_month.'_'.$salary_year.'.pdf', 'I'); 
            }
        }
        
    public function downloadStaffSalaryStatementExcel() {

            if($this->isAdmin() == TRUE) {
                $this->loadThis();
                return;
            }

            $salary_month = $this->security->xss_clean($this->input->post('salary_monthly'));
            $salary_year  = $this->security->xss_clean($this->input->post('year'));
            $salary_role  = $this->security->xss_clean($this->input->post('staff_role_salary'));

            $filter['salary_month'] = $salary_month;
            $filter['salary_year']  = $salary_year;
            $filter['salary_role']  = $salary_role;

            // if (is_array($salary_role)) {
            //     if (in_array('ALL', $salary_role)) {
            //         $role_display = 'ALL';
            //     } else {
            //         $role_display = 'Multiple Roles';
            //     }
            // } else {
            //     $role_info = $this->staff->getRoleDetails($salary_role);
            //     $role_display = ($salary_role != 'ALL' && !empty($role_info)) ? $role_info->role : 'ALL';
            // }
            $teachingRoleIds = [53, 54, 55, 57, 58, 1, 69]; 
                // 53 = Lecturer
                // 54 = Lecturer/Vice Principal
                // 55 = Lecturer/Dean
                // 57 = Physical Director
                // 58 = Counsellor
                // 1  = Principal
                // 69 = Campus Minister & Lecturer

                $partTimeRoleId = 56; // Part-Time Lecturer

                if (is_array($salary_role)) {

                    if (in_array('ALL', $salary_role)) {
                        $role_display = 'ALL';
                    }
                    elseif (count(array_intersect($salary_role, $teachingRoleIds)) > 0) {
                        $role_display = 'Teaching Staff';
                    }
                    elseif (in_array($partTimeRoleId, $salary_role)) {
                        $role_display = 'Part Time Lecturer';
                    }
                    else {
                        $role_display = 'Non Teaching Staff';
                    }

                } else {

                    if ($salary_role == 'ALL') {
                        $role_display = 'ALL';
                    }
                    elseif (in_array($salary_role, $teachingRoleIds)) {
                        $role_display = 'Teaching Staff';
                    }
                    elseif ($salary_role == $partTimeRoleId) {
                        $role_display = 'Part Time Lecturer';
                    }
                    else {
                        $role_display = 'Non Teaching Staff';
                    }
                }

            // Calculate deposit date (2nd of next month)
            $timestamp = strtotime("01-".$salary_month."-".$salary_year);
            $nextMonth = strtotime("+1 month", $timestamp);
            $depositDateText = "02 " . date("F Y", $nextMonth);

            $staffInfo = $this->salary->getStaffSalaryDetails($filter);

            $sheet = 0;
            $this->excel->setActiveSheetIndex($sheet);
            $sheetObj = $this->excel->getActiveSheet();
            $sheetObj->setTitle('Salary Statement');

            $sheetObj->setCellValue('A1', 'SALARY STATEMENT ('.$role_display.')');
            $sheetObj->setCellValue('A2','Salary for the month of '.$salary_month.' '.$salary_year.' has been deposited on '.$depositDateText);
            $sheetObj->setCellValue('A3','in South Indian Bank, St. Aloysius College E.C. Branch');

            $sheetObj->mergeCells('A1:D1');
            $sheetObj->mergeCells('A2:D2');
            $sheetObj->mergeCells('A3:D3');

            $sheetObj->getStyle('A1:A3')->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $sheetObj->getStyle('A1')->getFont()->setSize(14)->setBold(true);
            $sheetObj->getStyle('A2:A3')->getFont()->setSize(11)->setBold(true);

            $sheetObj->getColumnDimension('A')->setWidth(10);
            $sheetObj->getColumnDimension('B')->setWidth(25);
            $sheetObj->getColumnDimension('C')->setWidth(40);
            $sheetObj->getColumnDimension('D')->setWidth(20);


            $sheetObj->setCellValue('A4', 'Sl. No');
            $sheetObj->setCellValue('B4', 'Account No');
            $sheetObj->setCellValue('C4', 'Name');
            $sheetObj->setCellValue('D4', 'Amount');

            $sheetObj->getStyle('A4:D4')->getFont()->setBold(true);
            $sheetObj->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


            $excel_row = 5;
            $total_amount = 0;
            $j = 1;

            if(!empty($staffInfo)) {

                foreach($staffInfo as $staff){

                    $total_amount += $staff->net_amount;

                    $sheetObj->setCellValue('A'.$excel_row, $j++);
                    $sheetObj->setCellValueExplicit(
                        'B'.$excel_row,
                        $staff->account_no,
                        PHPExcel_Cell_DataType::TYPE_STRING
                    );
                    $sheetObj->setCellValue('C'.$excel_row, strtoupper($staff->name));
                    $sheetObj->setCellValue('D'.$excel_row, $staff->net_amount);

                    // Alignment
                    $sheetObj->getStyle('A'.$excel_row)
                        ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $sheetObj->getStyle('B'.$excel_row)
                        ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $sheetObj->getStyle('D'.$excel_row)
                        ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    // Number Format
                    $sheetObj->getStyle('D'.$excel_row)
                        ->getNumberFormat()->setFormatCode('#,##0');

                    $excel_row++;
                }

                // TOTAL ROW
                $sheetObj->setCellValue('C'.$excel_row, 'TOTAL');
                $sheetObj->setCellValue('D'.$excel_row, $total_amount);

                $sheetObj->getStyle('C'.$excel_row.':D'.$excel_row)
                    ->getFont()->setBold(true);

                $sheetObj->getStyle('C'.$excel_row)
                    ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $sheetObj->getStyle('D'.$excel_row)
                    ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $sheetObj->getStyle('D'.$excel_row)
                    ->getNumberFormat()->setFormatCode('#,##0');
            }


            $last_row = ($excel_row > 5) ? $excel_row : 4;

            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    )
                )
            );

            $sheetObj->getStyle('A4:D'.$last_row)->applyFromArray($styleArray);

            $filename = 'Salary_Statement_'.$salary_month.'_'.$salary_year.'.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

            ob_start();
            $objWriter->save("php://output");
            $xlsData = ob_get_contents();
            ob_end_clean();

            $response = array(
                'op'   => 'ok',
                'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
            );

            die(json_encode($response));
        }

        
        public function downloadStaffEsiReport(){
            if($this->isAdmin() == TRUE)
            {
                $this->loadThis();
            } else {
                $salary_month = $this->security->xss_clean($this->input->post('esi_month'));
                $salary_year = $this->security->xss_clean($this->input->post('esi_year'));
                $salary_role = $this->security->xss_clean($this->input->post('esi_role'));
                $filter['salary_month'] = $salary_month;
                $filter['salary_year'] = $salary_year;
                $filter['salary_role'] = $salary_role;

                if (is_array($salary_role)) {
                    if (in_array('ALL', $salary_role)) {
                        $role_display = 'ALL';
                    } else {
                        $role_display = 'Multiple Roles';
                    }
                } else {
                    $role_info = $this->staff->getRoleDetails($salary_role);
                    $role_display = ($salary_role != 'ALL') ? $role_info->role : 'ALL';
                }

                $sheet = 0;
                $this->excel->setActiveSheetIndex($sheet);
                $this->excel->getActiveSheet()->setTitle('STAFF ESI REPORT');
                $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:D500');
                $this->excel->getActiveSheet()->setCellValue('A1', "ST ALOYSIUS PRE-UNIVERSITY COLLEGE, MANGALURU");
                $this->excel->getActiveSheet()->setCellValue('A2', "ESI DEDUCTION ".$salary_month.' '.$salary_year);
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->mergeCells('A1:D1');
                $this->excel->getActiveSheet()->mergeCells('A2:D2');
                // $this->excel->getActiveSheet()->mergeCells('A3:D3');
                $this->excel->getActiveSheet()->getStyle('A1:A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A2:D2')->getFont()->setBold(true);

                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);

                // $this->excel->getActiveSheet()->setCellValue('A3', "ROLE :- ".$role_display);

                // $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14);
                // $this->excel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                // $this->excel->getActiveSheet()->getStyle('A3:D3')->getFont()->setBold(true);
          
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'Sl No');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', ' Gross Salary '.$salary_month."\n(If less than 21000)");
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'amount 0.75%');

                // HEADER STYLE START
                $this->excel->getActiveSheet()->getRowDimension(3)->setRowHeight(40);

                $this->excel->getActiveSheet()->getStyle('A3:D3')->applyFromArray(['font' => ['bold' => true,'size' => 12],'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,'wrap' => true],'borders' => ['allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]]
                    // 'fill' => [
                    //     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    //     'color' => ['rgb' => 'D9D9D9']
                    // ]
                ]);
                // HEADER STYLE END

                
                $this->excel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setWrapText(true); 
                $this->excel->getActiveSheet()->getStyle('A3:D3')->getFont()->setBold(true); 
                // $this->excel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                // $this->excel->getActiveSheet()->getStyle('A1:D4')->applyFromArray($styleBorderArray);

                $staffInfo = $this->salary->getStaffSalaryDetails($filter);
                $j=1;
                $excel_row = 4;
                $total_esi_amount = 0;         
                if(!empty($staffInfo)){
                    foreach($staffInfo as $staff){
                        if($staff->gross_salary <= 21000 && $staff->gross_salary > 0 && $staff->esi > 0) {

                            // $esi_amount = round($staff->gross_salary * 0.0075);
                         
                            $esi_amount = $staff->esi;


                           




                            $total_esi_amount += $esi_amount;

                            
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,strtoupper($staff->name));
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,number_format($staff->gross_salary,0,'.',''));
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,number_format($esi_amount,0,'.',''));
                            
                            // $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':D'.$excel_row)->applyFromArray($styleBorderArray);
                            $this->excel->getActiveSheet()->getStyle('A'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $this->excel->getActiveSheet()->getStyle('B'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                            $this->excel->getActiveSheet()->getStyle('C'.$excel_row.':D'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $excel_row++;
                        }
                    }
                    // Add Total Row
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, 'Total');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, number_format($total_esi_amount, 0, '.', ','));

                    $this->excel->getActiveSheet()->getStyle('B'.$excel_row)->getFont()->setBold(true);
                    $this->excel->getActiveSheet()->getStyle('D'.$excel_row)->getFont()->setBold(true);
                    $this->excel->getActiveSheet()->getStyle('D'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    
                    // Apply borders to the whole table including headers and total row
                    $this->excel->getActiveSheet()->getStyle('A1:D'.$excel_row)->applyFromArray($styleBorderArray);
                }
              
                $this->excel->createSheet();
                $filename='STAFF_ESI_REPORT.xls';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'.$filename.'"');
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
                ob_start();
                $objWriter->save("php://output");
                $xlsData = ob_get_contents();
                ob_end_clean();
          
                $response =  array(
                    'op' => 'ok',
                    'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
                );
                die(json_encode($response));
            }
        }
        
        public function downloadStaffSalaryReportMonthlyWise(){
            if($this->isAdmin() == TRUE)
            {
                $this->loadThis();
            } else {
                $salary_month = $this->security->xss_clean($this->input->post('salary_month'));
                $salary_year = $this->security->xss_clean($this->input->post('salary_year'));
                $salary_role = $this->security->xss_clean($this->input->post('salary_role'));
                $filter['salary_month'] = $salary_month;
                $filter['salary_year'] = $salary_year;
                $filter['salary_role'] = $salary_role;

                $role_info = $this->staff->getRoleDetails($salary_role);

                if($salary_role != 'ALL'){
                    $role_display = $role_info->role;
                }else{
                    $role_display = 'ALL';
                }

                $sheet = 0;
                $this->excel->setActiveSheetIndex($sheet);
                $this->excel->getActiveSheet()->setTitle('STAFF SALARY DETAILS');
                $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');
                $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                $this->excel->getActiveSheet()->setCellValue('A2', "STAFF SALARY DETAILS ".strtoupper($salary_month).' - '.$salary_year);
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->mergeCells('A1:AG1');
                $this->excel->getActiveSheet()->mergeCells('A2:AG2');
                $this->excel->getActiveSheet()->mergeCells('A3:AG3');
                $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A1:AG1')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A2:AG2')->getFont()->setBold(true);

                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
                $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(16);
                $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(16);
                $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('W')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('X')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('AA')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('AC')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('AD')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('AE')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('AF')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('AG')->setWidth(20);
                $this->excel->getActiveSheet()->setCellValue('A3', "ROLE :- ".$role_display);
                $this->excel->getActiveSheet()->mergeCells('A3:AG3');
                $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->getStyle('A3:AG3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A3:AG3')->getFont()->setBold(true);
          
          
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A4', 'SL. NO.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B4', 'STAFF ID');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C4', 'STAFF NAME');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D4', 'DOJ');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E4', 'GENDER');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F4', 'MOBILE NO');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G4', 'ROLE');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H4', 'AADHAR NO');

                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I4', 'PAN NO');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J4', 'PF NO');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K4', 'UAN');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L4', 'ESI NO');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('M4', 'BANK NAME');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('N4', 'BRANCH NAME');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('O4', 'IFSC CODE');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('P4', 'BANK ACCOUNT NO');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('Q4', 'BASIC');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('R4', 'DA%');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('S4', 'HRA%');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('T4', 'CONVAYANCE');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('U4', 'OTHERS');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('V4', 'GROSS');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('W4', 'EMPLOYER PF');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('X4', 'EMPLOYER ESI');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('Y4', 'TOTAL SALARY');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('Z4', 'PF');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('AA4', 'ESI');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('AB4', 'PT');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('AC4', 'IT DEDUCT');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('AD4', 'OTHERS DEDUCT');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('AE4', 'LOSS OF PAY');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('AF4', 'TOTAL DEDUCTION');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('AG4', 'NET SALARY');
                
                $this->excel->getActiveSheet()->getStyle('A4:AG4')->getAlignment()->setWrapText(true); 
                $this->excel->getActiveSheet()->getStyle('A4:AG4')->getFont()->setBold(true); 
                $this->excel->getActiveSheet()->getStyle('A4:AG4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                // Set background color
                // $this->excel->getActiveSheet()->getStyle('A4:AB4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                // $this->excel->getActiveSheet()->getStyle('A4:AB4')->getFill()->getStartColor()->setARGB('D9E1F2');

                $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                $this->excel->getActiveSheet()->getStyle('A1:AG4')->applyFromArray($styleBorderArray);
                // if($this->role == ROLE_MANAGER){
                //     $filter['staff_factory'] = $this->factory;
                // }
                $staffInfo = $this->salary->getStaffSalaryDetails($filter);
                $j=1;
                $excel_row = 5;
                if(!empty($staffInfo)){
                    foreach($staffInfo as $staff){

                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,$staff->staff_id);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,strtoupper($staff->name));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,date('d-m-Y',strtotime($staff->doj)));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,$staff->gender);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$staff->mobile_one);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,$staff->role);
                     
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row,$staff->aadhar_no);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row,$staff->pan_no);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row,$staff->pf_number);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row,$staff->uan_no);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row,$staff->esi_code);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('M'.$excel_row,$staff->bank_name);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('N'.$excel_row,$staff->branch_name);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('O'.$excel_row,$staff->ifsc_code);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('P'.$excel_row,$staff->account_no);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('Q'.$excel_row,number_format($staff->basic,2));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('R'.$excel_row,number_format($staff->da,2));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('S'.$excel_row,number_format($staff->hr,2));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('T'.$excel_row,number_format($staff->con,2));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('U'.$excel_row,number_format($staff->others,2));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('V'.$excel_row,number_format($staff->gross_salary,2));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('W'.$excel_row,number_format($staff->management_pf,2));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('X'.$excel_row,number_format($staff->management_esi,2));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('Y'.$excel_row,number_format($staff->total_salary,2));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('Z'.$excel_row,number_format($staff->pf,2));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('AA'.$excel_row,number_format($staff->esi,2));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('AB'.$excel_row,number_format($staff->pt,2));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('AC'.$excel_row,number_format($staff->it_deduct,2));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('AD'.$excel_row,number_format($staff->other_deduct,2));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('AE'.$excel_row,number_format($staff->lop,2));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('AF'.$excel_row,number_format($staff->total_deduction,2));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('AG'.$excel_row,number_format($staff->net_amount,2));
                      
                        
                        $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':AG'.$excel_row)->applyFromArray($styleBorderArray);
                        $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':B'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $this->excel->getActiveSheet()->getStyle('C'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        $this->excel->getActiveSheet()->getStyle('D'.$excel_row.':AG'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $excel_row++;
                    }
                }
              
                $this->excel->createSheet();
                //}
                $filename='just_some_random_name.xls'; //save our workbook as this file name
                header('Content-Type: application/vnd.ms-excel'); //mime type
                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
                ob_start();
                $objWriter->save("php://output");
                $xlsData = ob_get_contents();
                ob_end_clean();
          
                $response =  array(
                    'op' => 'ok',
                    'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
                );
                die(json_encode($response));
            }
          }



          public function updateSalaryAdvanceInfo(){
            $staff_row_id =$this->security->xss_clean($this->input->post('staff_row_id'));
            $Advance_row_id =$this->security->xss_clean($this->input->post('Advance_row_id'));
            $advance_amount = $this->security->xss_clean($this->input->post('advance_amount'));
            $date = $this->security->xss_clean($this->input->post('date'));
            $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
            $repayment_period = $this->security->xss_clean($this->input->post('repayment_period'));
            $dd_number = $this->security->xss_clean($this->input->post('dd_number'));
            $dd_date = $this->security->xss_clean($this->input->post('dd_date'));
            $bank_name = $this->security->xss_clean($this->input->post('bank_name'));
            $bank_tran_number = $this->security->xss_clean($this->input->post('bank_tran_number'));
            $bank_tran_date = $this->security->xss_clean($this->input->post('bank_tran_date'));
            $ref_number = $this->security->xss_clean($this->input->post('ref_number'));
            $neft_date = $this->security->xss_clean($this->input->post('neft_date'));
            $upi_number = $this->security->xss_clean($this->input->post('upi_number'));
            $installment_amount = $this->security->xss_clean($this->input->post('installment_amount'));
            $StaffInfo= array(
                'payment_type' => $payment_type,
                'date' =>date('Y-m-d',strtotime($date)),
                'advance_amount' => $advance_amount,
                'dd_number' => $dd_number,
                'installment_amount' => $installment_amount,
                'dd_date' => date('Y-m-d',strtotime($dd_date)),
                'repayment_period' => $repayment_period,
                'bank_tran_number' => $bank_tran_number,
                'bank_tran_date' =>date('Y-m-d',strtotime($bank_tran_date)),
                'bank_name' => $bank_name,
                'ref_number' => $ref_number,
                'neft_date' => date('Y-m-d',strtotime($neft_date)),
                'upi_number' => $upi_number,
                'updated_by' => $this->staff_id,
                'updated_date_time' => date('Y-m-d H:i:s'));
    
                $result = $this->salary->updateAdvancePaymentDetails($StaffInfo,$Advance_row_id);
                        
                if($result > 0){
                    $this->session->set_flashdata('success', 'Advance Salary Info Updated successfully');
                } else{
                    $this->session->set_flashdata('error', 'Advance Salary Info Updation failed');
                }
                redirect('editStaff/'.$staff_row_id);  
           
        
    }
    public function downloadStaffAdvanceSalaryReport(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
            $date_from = $this->security->xss_clean($this->input->post('date_from'));
            $date_to = $this->security->xss_clean($this->input->post('date_to'));
            $factory_name = $this->security->xss_clean($this->input->post('factory_name'));
          
            $sheet = 0;
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('STAFF ADVANCE SALARY INFO');
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');
            //set Title content with some text
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', "STAFF ADVANCE SALARY INFO");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:J1');
            $this->excel->getActiveSheet()->mergeCells('A2:J2');
            $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
      
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(23);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(23);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
            // $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(18);
            if(!empty($date_from)){
                $this->excel->getActiveSheet()->setCellValue('A3', "Date From : ".$date_from." Date To : ".$date_to);
            }
            $this->excel->getActiveSheet()->mergeCells('A3:J3');
            $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14);
            // $this->excel->getActiveSheet()->setCellValue('E3', "Pass Type: ");
            // $this->excel->getActiveSheet()->mergeCells('E3:I3');
            $this->excel->getActiveSheet()->getStyle('A3:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A3:J3')->getFont()->setBold(true);
      
      
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A4', 'SL. NO.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B4', 'Staff ID');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C4', 'Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D4', 'Department');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E4', 'Role');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F4', 'Factory Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G4', 'Date');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('H4', 'Advance Salary');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('I4', 'Paid Amount');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('J4', 'Pending Amount');
            
            $this->excel->getActiveSheet()->getStyle('A4:J4')->getAlignment()->setWrapText(true); 
            $this->excel->getActiveSheet()->getStyle('A4:J4')->getFont()->setBold(true); 
            $this->excel->getActiveSheet()->getStyle('A4:J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:J4')->applyFromArray($styleBorderArray);
            
            if(!empty($date_from) || !empty($date_from)){
                $filter['date_from'] = date('Y-m-d',strtotime($date_from)); 
                $filter['date_to'] = date('Y-m-d',strtotime($date_to)); 
            }
            $filter['factory_name'] =$factory_name;
            $staffInfo = $this->salary->getAllStaffAdvanceSalaryInfo($filter);
            $j=1;
            $excel_row = 5;
            if(!empty($staffInfo)){
                foreach($staffInfo as $staff){
                    $paid_amount = $this->salary->getAdvanceSalaryPaidInfo($staff->staff_id,$staff->advance_id);
                    $pending_amount = $staff->advance_amount - $paid_amount;
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,$staff->staff_id);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,$staff->name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,$staff->department);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,$staff->role);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$staff->factory_name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,date('d-m-Y',strtotime($staff->date)));
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row,$staff->advance_amount);
                    if(!empty($paid_amount)){
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row,$paid_amount);
                    }else{
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row,0);
                    }
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row,$pending_amount);
                    
                    $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':J'.$excel_row)->applyFromArray($styleBorderArray);
                    $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':B'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('C'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $this->excel->getActiveSheet()->getStyle('D'.$excel_row.':J'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel_row++;
                }
            }
          
            $this->excel->createSheet();
            //}
            $filename='just_some_random_name.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            ob_start();
            $objWriter->save("php://output");
            $xlsData = ob_get_contents();
            ob_end_clean();
      
            $response =  array(
                'op' => 'ok',
                'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
            );
            die(json_encode($response));
        }
      }

      public function addWorkingDaysToSalarySlip(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $filter = array();
            $year = $this->security->xss_clean($this->input->post('year'));
            $month = $this->security->xss_clean($this->input->post('month'));
            $role_id = $this->security->xss_clean($this->input->post('role_id'));
            $staff_id = $this->security->xss_clean($this->input->post('staff_id'));

            $role_info = $this->staff->getRoleDetails($role_id);
            $staff_info = $this->staff->getStaffDetailsByStaffID($staff_id);

            if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
            }

           
            $data['year'] = $year;
            $data['month'] = $month;
            if($role_id != 'ALL'){
                $data['role'] = $role_info->role;
            }else{
                $data['role'] = 'ALL';
            }
            $data['role_id'] = $role_id;
            $filter['role_id'] = $role_id;

            if($staff_id != 'ALL'){
                $data['staffName'] = $staff_info->name;
            }else{
                $data['staffName'] = 'ALL';
            }

            $data['staff_id'] = $staff_id;
            $filter['staff_id'] = $staff_id;
           
            if (is_numeric($year) && $year >= 0 && $year <= 9999 && is_string($month)) {
                // Convert the month name to a month number (1 to 12)
                $monthNumber = date('n', strtotime("1 $month 2000"));
                // Get the number of days in the specified month and year
                $data['numDays'] = cal_days_in_month(CAL_GREGORIAN, $monthNumber, $year);
                $data['class_held'] = $data['numDays'];

                // Get the start date and end date of the month
                $startDate = new DateTime("$year-$monthNumber-01");
                $endDate = new DateTime($startDate->format('Y-m-t'));

                $data['startDate'] = $startDate->format('Y-m-d');
                $data['endDate'] = $endDate->format('Y-m-d');

            }
            $date_from = date('Y-m-01', strtotime("$year-$monthNumber-01"));
            $date_to = date('Y-m-t', strtotime("$year-$monthNumber-01"));

            $filter['year'] = $year;
           
            //     $staffInfo = $this->salary->getAllStaffInfoSalaryLogic($filter);
            //     foreach($staffInfo as $staff) {
            //         $late_count = 0;
            //         $late_punch_dates = [];
            //         $staff_id = trim($staff->staff_id);
            //         $isLogicExecuted =  $this->salary->CheckLeaveLogicExecuted($staff_id,$year,$month);
            //         if(empty($isLogicExecuted)){
            //             $LeaveExecutionInfo = array(
            //                 'date' => date('Y-m-d H:i:s'),
            //                 'staff_id' => $staff_id,
            //                 'year' => $year,
            //                 'month' => $month,
            //                 'created_by' => $this->staff_id,
            //                 'created_date_time' => date('Y-m-d H:i:s'),
            //             );
            //             $this->salary->addLeaveLogicExecution($LeaveExecutionInfo);

            //         $working_day = $this->input->post("working_day_".$staff_id);
            //         $numDays = $this->input->post("total_days_".$staff_id);
            //         $IsExists = $this->salary->CheckSlarySlipGenerated($staff->staff_id,$year,$month);
            //         if(empty($IsExists)){
            //             $startDate = new DateTime($date_from);
            //             $endDate = new DateTime($date_to);
            //             $endDate->add(new DateInterval('P1D'));
            //             // Loop through the dates
            //             $interval = new DateInterval('P1D'); // 1-day interval
            //             $dateRange = new DatePeriod($startDate, $interval, $endDate);
            //             foreach ($dateRange as $date) {
            //                 // Skip Sundays
            //                 if ($date->format('w') != 0) {
            //                     $formattedDate = $date->format('Y-m-d');
            //                     $holiday = $this->salary->getHolidayInfoByRole($staff->roleId, $formattedDate);
            //                     $leaveInfo = $this->salary->checkLeaveAppliedAlready($staff_id, $formattedDate);
            //                     if(empty($holiday)) {
            //                         if (empty($leaveInfo)) {
            //                             $staff_data = $this->staff->getAllStaffAttendanceFromModel($staff_id,$formattedDate);
            //                             $leaveDetails = $this->leave->getLeaveInfoByStaffIdYear($staff_id, LEAVE_YEAR);
            //                             $used_leave_cl = $this->leave->getLeaveUsedSum($staff_id, 'CL', LEAVE_YEAR);
            //                             $used_leave_el = $this->leave->getLeaveUsedSum($staff_id, 'EL', LEAVE_YEAR);
            //                             $cl_rem = $leaveDetails->casual_leave_earned - $used_leave_cl->total_days_leave;
            //                             $el_rem = $leaveDetails->earned_leave - $used_leave_el->total_days_leave;
            //                             if($cl_rem > 0){
            //                                 $leave_type = 'CL';
            //                             }else if($el_rem > 0){
            //                                     $leave_type = 'EL';
            //                             }else{
            //                                 $leave_type = 'LOP';
            //                             }
            //                             if(empty($staff_data)){
            //                                 $curr_cl_rem = $cl_rem - 1;
            //                                 $curr_el_rem = $el_rem - 1;
            //                                 if($leave_type == 'CL'){
            //                                     if($curr_cl_rem < 0){
            //                                         if($el_rem > 0){
            //                                             $leave_type = 'EL';
            //                                         }else{
            //                                             $leave_type = 'LOP';
            //                                         }
            //                                     }
            //                                 }else if($leave_type == 'EL'){
            //                                     if($curr_el_rem < 0){
            //                                         $leave_type = 'LOP';
            //                                     }
            //                                 }
            //                                 $leaveInfo = array(
            //                                     'staff_id' => $staff_id,
            //                                     'applied_date_time' => date('Y-m-d H:i:s'),
            //                                     'date_from' => $formattedDate ,
            //                                     'date_to' => $formattedDate,
            //                                     'leave_reason' => 'NO PUNCH',
            //                                     'total_days_leave' => '1',
            //                                     'leave_type' => $leave_type,
            //                                     'year' => LEAVE_YEAR,
            //                                     'attendance_status' => 1,
            //                                     'approved_status' => 1,
            //                                     'remark' => 'NO PUNCH',
            //                                     'approved_by' => 'MANAGEMENT',
            //                                     'created_by' => $this->staff_id,
            //                                     'created_date_time' => date('Y-m-d H:i:s'),
            //                                 );
            //                                 log_message('debug','Leave Info: '.print_r($leaveInfo,true));
            //                                 $return_leave_id = $this->leave->addAppliedStaffLeave($leaveInfo);
            //                                 if($return_leave_id > 0){
            //                                     $all_users_token = $this->leave->getStaffToken($staff_id);
            //                                     $title = 'Leave Deduction ';
            //                                     $body = 'One '.$leave_type.' has been deducted for not punching out on '. $date->format('d-m-Y').'.';
            //                                     // $this->sendNotifications($all_users_token, $title, $body, STAFF_SERVICE_ACCOUNT_PATH, STAFF_FIREBASE_APP_ID);
            //                                     $tokenBatch = array_chunk($all_users_token,500);
            //                                     for($itr = 0; $itr < count($tokenBatch); $itr++){
            //                                         $this->pushNotification($tokenBatch[$itr],$title,$body,STAFF_NOTIFICATION_KEY);
            //                                     }
            //                                 }
            //                             }
            //                             // else if($staff_data->out_time == '00:00:00'){
            //                             //     $leaveInfo = array(
            //                             //         'staff_id' => $staff_id,
            //                             //         'applied_date_time' => date('Y-m-d H:i:s'),
            //                             //         'date_from' => $formattedDate ,
            //                             //         'date_to' => $formattedDate,
            //                             //         'leave_reason' => 'NO PUNCH OUT',
            //                             //         'total_days_leave' => '0.5',
            //                             //         'leave_type' => $leave_type,
            //                             //         'year' => LEAVE_YEAR,
            //                             //         'attendance_status' => 1,
            //                             //         'approved_status' => 1,
            //                             //         'remark' => 'NO PUNCH OUT',
            //                             //         'approved_by' => $this->staff_id,
            //                             //         'created_by' => $this->staff_id,
            //                             //         'created_date_time' => date('Y-m-d H:i:s'),
            //                             //     );
            //                             //     $this->leave->addAppliedStaffLeave($leaveInfo);
            //                             // }
            //                             // }else if(!empty($staff_data->in_time)){
            //                             // if(!empty($staff_data->in_time)){
            //                             else{
            //                                 $ExtraTimeExists = $this->salary->checkAttendanceExtraTime($formattedDate);
            //                                 $check_in_compare_test = new DateTime($staff_data->in_time);
            //                                 if(!empty($ExtraTimeExists)){
            //                                     $actual_in_time = new DateTime($ExtraTimeExists->start_time);
            //                                 }else{
            //                                     $actual_in_time = new DateTime($staff_data->start_time);
            //                                 }

            //                                     // Calculate the difference between the two times
            //                                     $interval = $check_in_compare_test->diff($actual_in_time);
            //                                     $time_difference = $interval->format('%h hours %i minutes');
            //                                     // Check if the difference is greater than 30 minutes
            //                                     // $is_late = ($interval->h > 0 || ($interval->h == 0 && $interval->i > 30));
            //                                 if ($check_in_compare_test > $actual_in_time) {
            //                                     $is_late = ($interval->h >= 1);
            //                                     if ($is_late) {
            //                                     //The staff member is more than half an hour late.";
            //                                         $leaveInfo = array(
            //                                             'staff_id' => $staff_id,
            //                                             'applied_date_time' => date('Y-m-d H:i:s'),
            //                                             'date_from' => $formattedDate ,
            //                                             'date_to' => $formattedDate,
            //                                             'leave_reason' => 'LATE PUNCH MORE THAN 1 HOUR - '.strtoupper($time_difference),
            //                                             'total_days_leave' => '0.5',
            //                                             'leave_type' => $leave_type,
            //                                             'year' => LEAVE_YEAR,
            //                                             'attendance_status' => 1,
            //                                             'approved_status' => 1,
            //                                             'remark' => 'LATE PUNCH MORE THAN 1 HOUR - '.strtoupper($time_difference),
            //                                             'approved_by' => 'MANAGEMENT',
            //                                             'created_by' => $this->staff_id,
            //                                             'created_date_time' => date('Y-m-d H:i:s'),
            //                                         );
            //                                         $return_leave_id = $this->leave->addAppliedStaffLeave($leaveInfo);
            //                                         if($return_leave_id > 0){
            //                                             $all_users_token = $this->leave->getStaffToken($staff_id);
            //                                             $title = 'Leave Deduction ';
            //                                             $body = 'Half '.$leave_type.' has been deducted for being more than 1 hour late, with a time difference of '.$time_difference.' on '.$date->format('d-m-Y').'.';
            //                                             // $this->sendNotifications($all_users_token, $title, $body, STAFF_SERVICE_ACCOUNT_PATH, STAFF_FIREBASE_APP_ID);
            //                                             $tokenBatch = array_chunk($all_users_token,500);
            //                                             for($itr = 0; $itr < count($tokenBatch); $itr++){
            //                                                 $this->pushNotification($tokenBatch[$itr],$title,$body,STAFF_NOTIFICATION_KEY);
            //                                             }
            //                                         }
            //                                     } else {
            //                                         $grace_time = new DateTime($staff_data->grace_time);
            //                                         // // Convert the grace time to a DateInterval. Assuming grace_time is in 'H:i:s' format.
            //                                         $interval = new DateInterval('PT' . $grace_time->format('H') . 'H' . $grace_time->format('i') . 'M' . $grace_time->format('s') . 'S');
            //                                         // // Add the interval to the actual in time
            //                                         $actual_in_time->add($interval);
            //                                         if ($check_in_compare_test > $actual_in_time) {
            //                                         $is_staff_late = ($interval->h > 0 || ($interval->h == 0 && $interval->i > 0));
            //                                         if($is_staff_late){
            //                                             $late_count++;
            //                                             $late_punch_dates[] = $date->format('d-m-Y');
            //                                             if ($late_count == 3) {
            //                                                 $leaveInfo = array(
            //                                                     'staff_id' => $staff_id,
            //                                                     'applied_date_time' => date('Y-m-d H:i:s'),
            //                                                     'date_from' => $formattedDate ,
            //                                                     'date_to' => $formattedDate,
            //                                                     'leave_reason' => 'LATE PUNCH - 3 TIMES',
            //                                                     'total_days_leave' => '0.5',
            //                                                     'leave_type' => $leave_type,
            //                                                     'year' => LEAVE_YEAR,
            //                                                     'attendance_status' => 1,
            //                                                     'approved_status' => 1,
            //                                                     'remark' => 'LATE PUNCH - 3 TIMES ON '.implode(", ", $late_punch_dates),
            //                                                     'approved_by' => 'MANAGEMENT',
            //                                                     'created_by' => $this->staff_id,
            //                                                     'created_date_time' => date('Y-m-d H:i:s'),
            //                                                 );
            //                                                 $return_leave_id = $this->leave->addAppliedStaffLeave($leaveInfo);
            //                                                 if($return_leave_id > 0){
            //                                                     $all_users_token = $this->leave->getStaffToken($staff_id);
            //                                                     $title = 'Leave Deduction ';
            //                                                     $body = 'Half '.$leave_type.'  has been deducted for being 3 times late on '.implode(", ", $late_punch_dates).'.';
            //                                                     // $this->sendNotifications($all_users_token, $title, $body, STAFF_SERVICE_ACCOUNT_PATH, STAFF_FIREBASE_APP_ID);
            //                                                     $tokenBatch = array_chunk($all_users_token,500);
            //                                                     for($itr = 0; $itr < count($tokenBatch); $itr++){
            //                                                         $this->pushNotification($tokenBatch[$itr],$title,$body,STAFF_NOTIFICATION_KEY);
            //                                                     }
            //                                                 }
            //                                                 $late_count = 0;
            //                                                 $late_punch_dates = [];
            //                                             }
            //                                         }
            //                                     }
            //                                 }
            //                             }
            //                             }
            //                         }
            //                     }
            //                 }
            //             }

            //         }
            //     }
            // }
            $data['salaryModel'] = $this->salary;
           
            $data['staffInfo'] = $this->salary->getAllStaffInfoSalarySlipGenartion($filter);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Salary Slip Details';
            $this->loadViews("salary/addWorkingDays.php", $this->global, $data, NULL);
        }
    }
    public function addSalarySlip(){
        
        $year = $this->security->xss_clean($this->input->post('year'));
        $month = $this->security->xss_clean($this->input->post('month'));
        $role_id = $this->security->xss_clean($this->input->post('role_id'));
        $staff_id = $this->security->xss_clean($this->input->post('staff_id'));

        // $institution_name = $this->security->xss_clean($this->input->post('institution_name'));
        $filter = array();
        // $filter['institution_name'] = $institution_name;
            // Validate year and month (optional but recommended)
        if (is_numeric($year) && $year >= 0 && $year <= 9999 && is_string($month)) {
            // Convert the month name to a month number (1 to 12)
            $monthNumber = date('n', strtotime("1 $month 2000"));
            // Get the number of days in the specified month and year
            $numDays = cal_days_in_month(CAL_GREGORIAN, $monthNumber, $year);
        }
           // Find the start and end dates of the specified month and year
        $date_from = date('Y-m-01', strtotime("$year-$monthNumber-01"));
        $date_to = date('Y-m-t', strtotime("$year-$monthNumber-01"));

        // log_message('debug','$date_from '.$date_from);
        // log_message('debug','$date_to '.$date_to);
        $filter['role_id'] = $role_id;
        $filter['staff_id'] = $staff_id;
        $filter['year'] = $year;


        $staffInfo = $this->salary->getAllStaffInfoSalarySlipGenartion($filter);
        $staff_salary_year = STAFF_SALARY_YEAR; 

          foreach($staffInfo as $staff) {

            $staff_id = trim($staff->staff_id);
            $working_day = $this->input->post("working_day_".$staff_id);
            $numDays = $this->input->post("total_days_".$staff_id);
            $others = $this->input->post("other_amount_".$staff_id);
            $IsExists = $this->salary->CheckSlarySlipGenerated($staff->staff_id,$year,$month);
            if(empty($IsExists)){
                // if($working_day!=0){
                        $total_advance_salary = 0;
                        $AdvanceSalaryInfo = $this->salary->getStaffAdvanceSalaryInfo($staff->staff_id);
                        $OTInfo = $this->salary->getStaffOtInfo($staff->staff_id,$date_from,$date_to);

                        // $da_per = $staff->da;
                        // $hra_per = $staff->hr;

                        $basicInfo = $this->salary->getEarningInfo($staff->staff_id,$staff_salary_year,'BASIC');
                        $conInfo = $this->salary->getEarningInfo($staff->staff_id,$staff_salary_year,'CON');
                        $ccaInfo = $this->salary->getEarningInfo($staff->staff_id,$staff_salary_year,'CCA');
                        $licInfo = $this->salary->getEarningInfo($staff->staff_id,$staff_salary_year,'LIC');

                        $daInfo = $this->salary->getEarningInfo($staff->staff_id,$staff_salary_year,'DA');
                        $hraInfo = $this->salary->getEarningInfo($staff->staff_id,$staff_salary_year,'HRA');
                        $othersInfo = $this->salary->getEarningInfo($staff->staff_id,$staff_salary_year,'OTHERS');

                        
                        $pfInfo = $this->salary->getdeductionInfo($staff->staff_id,$staff_salary_year,'PF');
                        $managementPFInfo = $this->salary->getdeductionInfo($staff->staff_id,$staff_salary_year,'EMPLOYER PF');
                        $esiInfo = $this->salary->getdeductionInfo($staff->staff_id,$staff_salary_year,'ESI');
                        $managementESIInfo = $this->salary->getdeductionInfo($staff->staff_id,$staff_salary_year,'EMPLOYER ESI');
                        $ptInfo = $this->salary->getdeductionInfo($staff->staff_id,$staff_salary_year,'PROF.TAX');
                        $otherInfo = $this->salary->getdeductionInfo($staff->staff_id,$staff_salary_year,'OTHERS');
                        $licdeduction = $this->salary->getdeductionInfo($staff->staff_id,$staff_salary_year,'LIC');

                        $admchrgInfo = $this->salary->getdeductionInfo($staff->staff_id,$staff_salary_year,'ADM CHRG');
                        $itInfo = $this->salary->getdeductionInfo($staff->staff_id,$staff_salary_year,'IT');


                        // $basic_salary = round($basicInfo->value);
                        $basic_sal = round($basicInfo->value*$working_day/$numDays);
                        $basic_salary = round($basic_sal);


                        $con = round($conInfo->value);
                        if($working_day == 0){
                            $cca = 0;
                        }else{
                            $cca = round($ccaInfo->value);
                        }
                        $lic = round($licInfo->value);
                        $others = round($others);


                        if($daInfo->calculate_type == "PERCENTAGE"){
                           $da = round((($basic_salary * $daInfo->value)/100));
                        }else if($daInfo->calculate_type == "AMOUNT"){
                           $da = round($daInfo->value);
                        }else{
                           $da = 0;
                        }

                        if($hraInfo->calculate_type == "PERCENTAGE"){
                            $hr = round((($basic_salary * $hraInfo->value)/100));
                        }else if($hraInfo->calculate_type == "AMOUNT"){
                            $hr = round($hraInfo->value);
                        }else{
                            $hr = 0;
                        }

                        $Lop_days = $numDays - $working_day;

                        $gross_salary = $basic_salary + $da + $hr + round($con) + round($cca) + round($lic) + round($others);

                    
                        $total_basic_salary = $basic_salary + $da;

                        if($pfInfo->calculate_type == "PERCENTAGE"){
                            if($total_basic_salary < 15000){
                                $pf = (($total_basic_salary * $pfInfo->value)/100);
                            }else{
                                $pf = ((15000 * $pfInfo->value)/100);
                            }
                        }else if($pfInfo->calculate_type == "AMOUNT"){
                            $pf = round($pfInfo->value);
                        }else{
                            $pf = 0;
                        }

                         if($admchrgInfo->calculate_type == "PERCENTAGE"){
                            if($total_basic_salary < 15000){
                                $admchrg = (($total_basic_salary * $admchrgInfo->value)/100);
                            }else{
                                $admchrg = ((15000 * $admchrgInfo->value)/100);
                            }
                        }else if($admchrgInfo->calculate_type == "AMOUNT"){
                            $admchrg = round($admchrgInfo->value);
                        }else{
                            $admchrg = 0;
                        }

                        if($managementPFInfo->calculate_type == "PERCENTAGE"){
                            if($total_basic_salary < 15000){
                                $management_pf = (($total_basic_salary * $managementPFInfo->value)/100);
                            }else{
                                $management_pf = ((15000 * $managementPFInfo->value)/100);
                            }
                        }else if($managementPFInfo->calculate_type == "AMOUNT"){
                            $management_pf = round($managementPFInfo->value);
                        }else{
                            $management_pf = 0;
                        }

                        if($esiInfo->calculate_type == "PERCENTAGE"){
                            $esi = ceil(($gross_salary * $esiInfo->value)/100);
                        }else if($esiInfo->calculate_type == "AMOUNT"){
                            $esi = ceil($esiInfo->value);
                        }else{
                            $esi = 0;
                        }

                        if($managementESIInfo->calculate_type == "PERCENTAGE"){
                            $management_esi = round(($gross_salary * $managementESIInfo->value)/100);
                        }else if($managementESIInfo->calculate_type == "AMOUNT"){
                            $management_esi = round($managementESIInfo->value);
                        }else{
                            $management_esi = 0;
                        }

                        // if(!empty($otherInfo)){
                        //    $otherDeduct  = round($otherInfo->value);
                        // }else{
                        //    $otherDeduct  = 0;
                        // }
                        if($working_day == 0){
                            $otherDeduct = 0;
                        }else{
                            if(!empty($otherInfo)){
                                $otherDeduct = round($otherInfo->value);
                            }else{
                                $otherDeduct = 0;
                            }
                        }



                        // if(!empty($licdeduction)){
                        //    $licDeduct  = round($licdeduction->value);
                        // }else{
                        //    $licDeduct  = 0;
                        // }
                        if($working_day == 0){
                            $licDeduct = 0;
                        }else{
                            if(!empty($licdeduction)){
                                $licDeduct = round($licdeduction->value);
                            }else{
                                $licDeduct = 0;
                            }
                        }


                        if(!empty($itInfo)){
                            $itDeduct  = round($itInfo->value);
                         }else{
                            $itDeduct  = 0;
                         }
                    
                        // $Lop = (($basic_salary/$numDays)*$Lop_days);
                       
                        if($gross_salary < 25000){
                            $pt = 0;
                        }else{
                            $pt = round($ptInfo->value);
                        }

                        $total_salary =  round($gross_salary)  + round($management_pf) + round($management_esi) + $OTInfo;

                        foreach($AdvanceSalaryInfo as $advanceInfo){
                            $installment_amount = $this->salary->getAdvanceSalaryPaidInfo($staff->staff_id,$advanceInfo->row_id);
                            $PaidAmount = $advanceInfo->advance_amount - $installment_amount;
    
                            if($PaidAmount > 0){
                                $advance_salary = $advanceInfo->installment_amount;
                            }else{
                                $advance_salary = 0;
                            }
                            $total_advance_salary += $advance_salary;
                        }
                     
                        $total_deduction = round($pf) + round($esi) + round($pt) + round($management_pf) + round($management_esi) + round($admchrg) + $otherDeduct + $licDeduct + $itDeduct + $total_advance_salary;


                        $net_amount =  round($total_salary) - round($total_deduction);
                        

                        $info = array(
                            'staff_id' => $staff->staff_id, 
                            // 'account_no' => $staff->account_no, 
                            'basic' => round($basic_salary), 
                            'hr' => round($hr), 
                            'others' => round($others), 
                            'con' => round($con), 
                            'cca' => round($cca),
                            'lic' => round($lic),
                            'da' => round($da), 
                            'total_days' => $numDays, 
                            'working_day' => $working_day, 
                            'total_salary' => round($total_salary),  
                            'management_pf' => round($management_pf), 
                            'management_esi' => round($management_esi), 
                            'gross_salary' => round($gross_salary), 
                            'pf' => round($pf), 
                            'admchrg' => round($admchrg), 
                            'esi' => ceil($esi), 
                            'pt' => round($pt),
                            // 'lop' => round($Lop),
                            'other_deduct' => round($otherDeduct),
                            'lic_deduct' => round($licDeduct),
                            'it_deduct' => round($itDeduct),
                            'advance_salary' => $total_advance_salary, 
                            'total_deduction' => round($total_deduction), 
                            'net_amount' => round($net_amount),
                            'tax_regime' => $staff->tax_regime,
                            'ot_amount' =>$OTInfo,
                            'year' => $year,
                            'month' => $month,
                            'salary_designation_id' => $staff->salary_id,
                            'date' => date('Y-m-d'),
                            'created_by'=>$this->staff_id,
                            'created_date_time'=>date('Y-m-d H:i:s'));
                        if(!empty($basicInfo)){
                            $result = $this->salary->addSalarySlipInfo($info);
                        }else{
                            $result = 0;
                        }

                        foreach($AdvanceSalaryInfo as $advanceInfo){
                            $installment_amount = $this->salary->getAdvanceSalaryPaidInfo($staff->staff_id,$advanceInfo->row_id);
                            $PaidAmount = $advanceInfo->advance_amount - $installment_amount;
    
                            if($PaidAmount > 0){
                                $advance_salary_amount = $advanceInfo->installment_amount;
                            }else{
                                $advance_salary_amount = 0;
                            }
                            if($PaidAmount > 0){
                                $info = array(
                                    'staff_id' => $staff->staff_id, 
                                    'total_amount' => $advanceInfo->advance_amount, 
                                    'advance_id' => $advanceInfo->row_id, 
                                    'salary_slip_id' => $result,
                                    'installment_amount' => $advance_salary_amount, 
                                    'year' => $year,
                                    'month' => $month,
                                    'date' => date('Y-m-d'),
                                    'created_by'=>$this->staff_id,
                                    'created_date_time'=>date('Y-m-d H:i:s'));
                                $this->salary->addAdvanceSalaryInstallmentInfo($info);
                            }
                        }
                    
                // }
            }else{
                // if($working_day!=0){
                        $total_advance_salary = 0;
                        $AdvanceSalaryInfo = $this->salary->getStaffAdvanceSalaryInfo($staff->staff_id);
                        $OTInfo = $this->salary->getStaffOtInfo($staff->staff_id,$date_from,$date_to);
                        
                        $basicInfo = $this->salary->getEarningInfo($staff->staff_id,$staff_salary_year,'BASIC');
                        $conInfo = $this->salary->getEarningInfo($staff->staff_id,$staff_salary_year,'CON');
                        $ccaInfo = $this->salary->getEarningInfo($staff->staff_id,$staff_salary_year,'CCA');
                        $licInfo = $this->salary->getEarningInfo($staff->staff_id,$staff_salary_year,'LIC');
                        $othersInfo = $this->salary->getEarningInfo($staff->staff_id,$staff_salary_year,'OTHER ALLOWANCES');
                        $daInfo = $this->salary->getEarningInfo($staff->staff_id,$staff_salary_year,'DA');
                        $hraInfo = $this->salary->getEarningInfo($staff->staff_id,$staff_salary_year,'HRA');
                        
                        $pfInfo = $this->salary->getdeductionInfo($staff->staff_id,$staff_salary_year,'PF');
                        $managementPFInfo = $this->salary->getdeductionInfo($staff->staff_id,$staff_salary_year,'EMPLOYER PF');
                        $esiInfo = $this->salary->getdeductionInfo($staff->staff_id,$staff_salary_year,'ESI');
                        $managementESIInfo = $this->salary->getdeductionInfo($staff->staff_id,$staff_salary_year,'EMPLOYER ESI');
                        $ptInfo = $this->salary->getdeductionInfo($staff->staff_id,$staff_salary_year,'PROF.TAX');
                        $otherInfo = $this->salary->getdeductionInfo($staff->staff_id,$staff_salary_year,'OTHERS');
                        $licdeduction = $this->salary->getdeductionInfo($staff->staff_id,$staff_salary_year,'LIC');
                        $admchrgInfo = $this->salary->getdeductionInfo($staff->staff_id,$staff_salary_year,'ADM CHRG');
                        $itInfo = $this->salary->getdeductionInfo($staff->staff_id,$staff_salary_year,'IT');


                        // $basic_salary = round($basicInfo->value);
                        $basic_sal = round($basicInfo->value*$working_day/$numDays);
                        $basic_salary = round($basic_sal);
                        $con = round($conInfo->value);
                        if($working_day == 0){
                            $cca = 0;
                        }else{
                            $cca = round($ccaInfo->value);
                        }
                        $lic = round($licInfo->value);
                        // $others = round($othersInfo->value);
                        $others = round($others);


                        if($daInfo->calculate_type == "PERCENTAGE"){
                           $da = round((($basic_salary * $daInfo->value)/100));
                        }else if($daInfo->calculate_type == "AMOUNT"){
                           $da = round($daInfo->value);
                        }else{
                           $da = 0;
                        }

                        if($hraInfo->calculate_type == "PERCENTAGE"){
                            $hr = round((($basic_salary * $hraInfo->value)/100));
                        }else if($hraInfo->calculate_type == "AMOUNT"){
                            $hr = round($hraInfo->value);
                        }else{
                            $hr = 0;
                        }

                        $Lop_days = $numDays - $working_day;

                        $gross_salary = $basic_salary + $da + $hr + round($con) + round($cca) + round($lic) + round($others);

                    
                        $total_basic_salary = $basic_salary + $da;

                        if($pfInfo->calculate_type == "PERCENTAGE"){
                            if($total_basic_salary < 15000){
                                $pf = (($total_basic_salary * $pfInfo->value)/100);
                            }else{
                                $pf = ((15000 * $pfInfo->value)/100);
                            }
                        }else if($pfInfo->calculate_type == "AMOUNT"){
                            $pf = round($pfInfo->value);
                        }else{
                            $pf = 0;
                        }

                          if($admchrgInfo->calculate_type == "PERCENTAGE"){
                            if($total_basic_salary < 15000){
                                $admchrg = (($total_basic_salary * $admchrgInfo->value)/100);
                            }else{
                                $admchrg = ((15000 * $admchrgInfo->value)/100);
                            }
                        }else if($admchrgInfo->calculate_type == "AMOUNT"){
                            $admchrg = round($admchrgInfo->value);
                        }else{
                            $admchrg = 0;
                        }

                        if($managementPFInfo->calculate_type == "PERCENTAGE"){
                            if($total_basic_salary < 15000){
                                $management_pf = (($total_basic_salary * $managementPFInfo->value)/100);
                            }else{
                                $management_pf = ((15000 * $managementPFInfo->value)/100);
                            }
                        }else if($managementPFInfo->calculate_type == "AMOUNT"){
                            $management_pf = round($managementPFInfo->value);
                        }else{
                            $management_pf = 0;
                        }

                        if($esiInfo->calculate_type == "PERCENTAGE"){
                            $esi = ceil(($gross_salary * $esiInfo->value)/100);
                        }else if($esiInfo->calculate_type == "AMOUNT"){
                            $esi = ceil($esiInfo->value);
                        }else{
                            $esi = 0;
                        }

                        if($managementESIInfo->calculate_type == "PERCENTAGE"){
                            $management_esi = round(($gross_salary * $managementESIInfo->value)/100);
                        }else if($managementESIInfo->calculate_type == "AMOUNT"){
                            $management_esi = round($managementESIInfo->value);
                        }else{
                            $management_esi = 0;
                        }

                        // if(!empty($otherInfo)){
                        //    $otherDeduct  = round($otherInfo->value);
                        // }else{
                        //    $otherDeduct  = 0;
                        // }
                        if($working_day == 0){
                            $otherDeduct = 0;
                        }else{
                            if(!empty($otherInfo)){
                                $otherDeduct = round($otherInfo->value);
                            }else{
                                $otherDeduct = 0;
                            }
                        }

                        // if(!empty($licdeduction)){
                        //    $licDeduct  = round($licdeduction->value);
                        // }else{
                        //    $licDeduct  = 0;
                        // }
                        if($working_day == 0){
                            $licDeduct = 0;
                        }else{
                            if(!empty($licdeduction)){
                                $licDeduct = round($licdeduction->value);
                            }else{
                                $licDeduct = 0;
                            }
                        }

                        if(!empty($itInfo)){
                            $itDeduct  = round($itInfo->value);
                         }else{
                            $itDeduct  = 0;
                         }
                    
                        // $Lop = (($basic_salary/$numDays)*$Lop_days);
                       
                        if($gross_salary < 25000){
                            $pt = 0;
                        }else{
                            $pt = round($ptInfo->value);
                        }

                        $total_salary =  round($gross_salary)  + round($management_pf) + round($management_esi) + $OTInfo;
                        
                        // foreach($AdvanceSalaryInfo as $advanceInfo){
                        //     $installment_amount = $this->salary->getAdvanceSalaryPaidInfo($staff->staff_id,$advanceInfo->row_id);
                        //     $PaidAmount = $advanceInfo->advance_amount - $installment_amount;
    
                        //     if($PaidAmount > 0){
                        //         $advance_salary = $advanceInfo->installment_amount;
                        //     }else{
                        //         $advance_salary = 0;
                        //     }
                        //     $total_advance_salary += $advance_salary;
                        // }
                        
                        $total_deduction = round($pf) + round($esi) + round($pt) + round($management_pf) + round($management_esi) + round($admchrg)+ $otherDeduct + $itDeduct + $itDeduct + $IsExists->advance_salary;


                        $net_amount =  round($total_salary) - round($total_deduction);

                        $info = array(
                            'staff_id' => $staff->staff_id, 
                            // 'account_no' => $staff->account_no, 
                            'basic' => round($basic_salary), 
                            'hr' => round($hr), 
                            'others' => round($others),
                            'da_per' => $da_per, 
                            'hra_per' => $hra_per, 
                            'con' => round($con),
                            'cca' => round($cca), 
                            'lic' => round($lic),
                            'da' => round($da), 
                            'total_days' => $numDays, 
                            'working_day' => $working_day, 
                            'total_salary' => $total_salary,  
                            'management_pf' => round($management_pf), 
                            'management_esi' => round($management_esi), 
                            'gross_salary' => round($gross_salary), 
                            'pf' => round($pf), 
                            'admchrg' => round($admchrg), 
                            'esi' => ceil($esi), 
                            'pt' => round($pt),
                            // 'lop' => round($Lop),
                            'other_deduct' => round($otherDeduct),
                            'lic_deduct' => round($licDeduct),
                            'it_deduct' => round($itDeduct),
                            // 'advance_salary' => $total_advance_salary, 
                            'total_deduction' => round($total_deduction), 
                            'net_amount' => round($net_amount),
                            'tax_regime' => $staff->tax_regime,
                            'ot_amount' =>$OTInfo,
                            'year' => $year,
                            'month' => $month,
                            'salary_designation_id' => $staff->salary_id,
                            'updated_by'=>$this->staff_id,
                            'updated_date_time'=>date('Y-m-d H:i:s'));
                        if(!empty($basicInfo)){
                             $result = $this->salary->updateSalarySlipInfo($info,$IsExists->row_id);
                        }else{
                             $result = 0;
                        }
                        // $deleteAdvanceSalaryInfo = array(
                        //     'is_deleted'=>1
                        // );
                        // $this->salary->deleteAdanceInstallmentInfo($IsExists->row_id,$deleteAdvanceSalaryInfo);
                        // foreach($AdvanceSalaryInfo as $advanceInfo){
                        //     $installment_amount = $this->salary->getAdvanceSalaryPaidInfo($staff->staff_id,$advanceInfo->row_id);
                        //     $PaidAmount = $advanceInfo->advance_amount - $installment_amount;
    
                        //     if($PaidAmount > 0){
                        //         $advance_salary_amount = $advanceInfo->installment_amount;
                        //     }else{
                        //         $advance_salary_amount = 0;
                        //     }
                        //     if($PaidAmount > 0){
                        //         $info = array(
                        //             'staff_id' => $staff->staff_id, 
                        //             'total_amount' => $advanceInfo->advance_amount, 
                        //             'advance_id' => $advanceInfo->row_id, 
                        //             'salary_slip_id' => $result,
                        //             'installment_amount' => $advance_salary_amount, 
                        //             'year' => $year,
                        //             'month' => $month,
                        //             'date' => date('Y-m-d'),
                        //             'created_by'=>$this->staff_id,
                        //             'created_date_time'=>date('Y-m-d H:i:s'));
                        //         $this->salary->addAdvanceSalaryInstallmentInfo($info);
                        //     }
                        // }
                   
                // }
            }
                    
        } 
        if($result>0){
            $this->session->set_flashdata('success', 'Salary Slip Generated successfully');
        } else {
            $this->session->set_flashdata('error', 'Salary Slip Generation failed');
        }
        redirect('salarySlipListing');
    } 


    public function addOtherAmountDetails()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $filter = array();
            $row_id = $this->security->xss_clean($this->input->post('row_id'));
            $staff_id = $this->security->xss_clean($this->input->post('staff_id'));
            $year = $this->security->xss_clean($this->input->post('year'));
            $month = $this->security->xss_clean($this->input->post('month'));
            $other_amount = $this->security->xss_clean($this->input->post('other_amount'));

            $OtherInfo = array(
                'staff_id' => $staff_id,
                'year' => $year,
                'month' => $month,
                'other_amount' => $other_amount,
                'created_by' => $this->staff_id,
                'created_date_time' => date('Y-m-d h:i:s')
            );

            $return_id = $this->salary->addOtherAmountDetails($OtherInfo);

            if ($return_id > 0) {
                $this->session->set_flashdata('success', 'Other Amount Info Added Successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to add ');
            }
            redirect('editStaff/' . $row_id);
        }
    }

    public function updateOtherAmountInfoByID()
    {
        $staff_row_id = $this->security->xss_clean($this->input->post('staff_row_id'));
        $Other_row_id = $this->security->xss_clean($this->input->post('Other_row_id'));
        $year = $this->security->xss_clean($this->input->post('year'));
        $month = $this->security->xss_clean($this->input->post('month'));
        $other_amount = $this->security->xss_clean($this->input->post('other_amount'));
        $StaffInfo = array(
            'year' => $year,
            'month' => $month,
            'other_amount' => $other_amount,
            'updated_by' => $this->staff_id,
            'updated_date_time' => date('Y-m-d H:i:s')
        );

        $result = $this->salary->updateOtherAmountInfoByID($StaffInfo, $Other_row_id);

        if ($result > 0) {
            $this->session->set_flashdata('success', 'Other Amount Info Updated successfully');
        } else {
            $this->session->set_flashdata('error', 'Other Amount Info Updation failed');
        }
        redirect('editStaff/' . $staff_row_id);
    }

    public function addSalaryDetailsNew() {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $row_id = $this->security->xss_clean($this->input->post('row_id'));
            $staff_id = $this->security->xss_clean($this->input->post('staff_id'));
    
            $earnings = $this->input->post('earnings');
            $deductions = $this->input->post('deductions');

            $desigInfo = $this->salary->getSalaryDesignationInfoById($staff_id);
                if(!empty($desigInfo)){
                    $designation_type = $desigInfo->row_id;
                }else{
                    $designation_type = '';
                }
    
            if (!empty($earnings)) {
                foreach ($earnings as $earning) {
                    if (isset($earning['year'], $earning['salary_type'], $earning['calculation_type'], $earning['value'])) {
                        $earning_data = array(
                            'staff_id' => $staff_id,
                            'year' => $this->security->xss_clean($earning['year']),
                            'salary_type' => $this->security->xss_clean($earning['salary_type']),
                            'calculate_type' => $this->security->xss_clean($earning['calculation_type']),
                            'value' => $this->security->xss_clean($earning['value']),
                            'designation_id' => $designation_type,
                            'created_by' => $this->staff_id,
                            'created_date_time' => date('Y-m-d H:i:s')
                        );
    
                        // Check if the earning entry already exists
                        $exists = $this->salary->checkEarningExists($earning_data);
                        if (!$exists) {
                            $result = $this->salary->addEarning($earning_data);
                        } else {
                            $this->session->set_flashdata('nomatch', 'Earnings entry already exists');
                            redirect('editStaff/' . $row_id);
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Earnings data incomplete');
                        redirect('editStaff/' . $row_id);
                    }
                }
            }
    
            if (!empty($deductions)) {
                foreach ($deductions as $deduction) {
                    if (isset($deduction['year'], $deduction['salary_type'], $deduction['calculation_type'], $deduction['value'])) {
                        $deduction_data = array(
                            'staff_id' => $staff_id,
                            'year' => $this->security->xss_clean($deduction['year']),
                            'salary_type' => $this->security->xss_clean($deduction['salary_type']),
                            'calculate_type' => $this->security->xss_clean($deduction['calculation_type']),
                            'value' => $this->security->xss_clean($deduction['value']),
                            'designation_id' => $designation_type,
                            'created_by' => $this->staff_id,
                            'created_date_time' => date('Y-m-d H:i:s')
                        );
    
                        // Check if the deduction entry already exists
                        $exists = $this->salary->checkDeductionExists($deduction_data);
                        if (!$exists) {
                            $result = $this->salary->addDeduction($deduction_data);
                        } else {
                            $this->session->set_flashdata('nomatch', 'Deduction entry already exists');
                            redirect('editStaff/' . $row_id);
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Deduction data incomplete');
                        redirect('editStaff/' . $row_id);
                    }
                }
            }
    
            if (isset($result) && $result > 0) {
                $this->session->set_flashdata('success', 'Salary details added successfully');
            }
    
            redirect('editStaff/' . $row_id);
        }
    }
    
    public function deleteSalaryEarningInfo(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $salaryEarningsInfo = array(
                'is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateSalaryEarnings($salaryEarningsInfo, $row_id);
            // log_message('debug','post'.print_r($postInfo));
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function deleteSalaryDeductionInfo(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $salaryDeductionInfo = array(
                'is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateSalaryDeduction($salaryDeductionInfo, $row_id);
            // log_message('debug','post'.print_r($postInfo));
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function updateEarningInfo(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $Staff_row_id = $this->input->post('Staff_row_id');
            $value = $this->input->post('value');
            $desigInfo = $this->salary->getSalaryDesignationInfoByRowId($Staff_row_id);
            if(!empty($desigInfo)){
                $designation_type = $desigInfo->row_id;
            }else{
                $designation_type = '';
            }
            $salaryEarningInfo = array(
                'value' => $value,
                'designation_id' => $designation_type,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateSalaryEarnings($salaryEarningInfo, $row_id);
            // log_message('debug','post'.print_r($postInfo));
            if ($result == true) {
                $this->session->set_flashdata('success', 'Salary Earnings Updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Salary Earnings Updated failed');
            }
            redirect('editStaff/' . $Staff_row_id);
        } 
    }

    public function updateDeductionInfo(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $Staff_row_id = $this->input->post('Staff_row_id');
            $value = $this->input->post('value');
            $desigInfo = $this->salary->getSalaryDesignationInfoByRowId($Staff_row_id);
            if(!empty($desigInfo)){
                $designation_type = $desigInfo->row_id;
            }else{
                $designation_type = '';
            }
            $salaryDeductionInfo = array(
                'value' => $value,
                'designation_id' => $designation_type,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateSalaryDeduction($salaryDeductionInfo, $row_id);
            // log_message('debug','post'.print_r($postInfo));
            if ($result == true) {
                $this->session->set_flashdata('success', 'Salary Deduction Updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Salary Deduction Updated failed');
            }
            redirect('editStaff/' . $Staff_row_id);
        } 
    }

    public function addAdvancePaymentDetails(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else { 
                $filter = array();
                $row_id = $this->security->xss_clean($this->input->post('row_id'));
                $staff_id = $this->security->xss_clean($this->input->post('staff_id'));
                $advance_amount = $this->security->xss_clean($this->input->post('advance_amount'));
                $date = $this->security->xss_clean($this->input->post('date'));
                $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
                $repayment_period = $this->security->xss_clean($this->input->post('repayment_period'));
                $dd_number = $this->security->xss_clean($this->input->post('dd_number'));
                $dd_date = $this->security->xss_clean($this->input->post('dd_date'));
                $bank_name = $this->security->xss_clean($this->input->post('bank_name'));
                $bank_tran_number = $this->security->xss_clean($this->input->post('bank_tran_number'));
                $bank_tran_date = $this->security->xss_clean($this->input->post('bank_tran_date'));
                $ref_number = $this->security->xss_clean($this->input->post('ref_number'));
                $neft_date = $this->security->xss_clean($this->input->post('neft_date'));
                $upi_number = $this->security->xss_clean($this->input->post('upi_number'));
                $installment_amount = $this->security->xss_clean($this->input->post('installment_amount'));
                $StaffInfo= array(
                    'staff_id' => $staff_id,
                    'payment_type' => $payment_type,
                    'date' =>date('Y-m-d',strtotime($date)),
                    'year' => date('Y'),
                    'advance_amount' => $advance_amount,
                    'dd_number' => $dd_number,
                    'installment_amount' => $installment_amount,
                    'dd_date' => date('Y-m-d',strtotime($dd_date)),
                    'repayment_period' => $repayment_period,
                    'bank_tran_number' => $bank_tran_number,
                    'bank_tran_date' =>date('Y-m-d',strtotime($bank_tran_date)),
                    'bank_name' => $bank_name,
                    'ref_number' => $ref_number,
                    'neft_date' => date('Y-m-d',strtotime($neft_date)),
                    'upi_number' => $upi_number,
                    'created_by' => $this->staff_id,
                    'created_date_time' => date('Y-m-d h:i:s'));

                $return_id = $this->salary->addAdvancePaymentDetails($StaffInfo);
                    
                if($return_id > 0){
                    $this->session->set_flashdata('success', 'Advance Payment Added Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Failed to add ');
                }
                redirect('editStaff/'.$row_id);  
        }
    }

    function mysalarySlipListing()
    {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $filter = array();
            $name = $this->security->xss_clean($this->input->post('name'));
            $date = $this->security->xss_clean($this->input->post('date'));
            $staff_id = $this->security->xss_clean($this->input->post('staff_id'));
            $gross_salary = $this->security->xss_clean($this->input->post('gross_salary'));
            $grade_pay = $this->security->xss_clean($this->input->post('grade_pay'));
            $net_amount = $this->security->xss_clean($this->input->post('net_amount'));
            $service = $this->security->xss_clean($this->input->post('service'));
            $category = $this->security->xss_clean($this->input->post('category'));
            $by_month = $this->security->xss_clean($this->input->post('by_month'));
            $by_year = $this->security->xss_clean($this->input->post('by_year'));

          
            $data['by_month'] = $by_month;
            $data['by_year'] = $by_year;
            
            
          
            $filter['by_month'] = $by_month;
            $filter['by_year'] = $by_year;
            $filter['staff_id'] = $this->staff_id;

            if(!empty($date)){
                $filter['date'] = date('Y-m-d',strtotime($date));
                $data['date'] = date('d-m-Y',strtotime($date));
            }else{
                $data['date'] = '';
                $filter['date'] = '';
            }

            $this->load->library('pagination');
            $count = $this->salary->getAllmySalaryCount($filter);
            $returns = $this->paginationCompress("mysalarySlipListing/", $count, 100);
            $data['totalSalaryCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['staffInfo'] = $this->staff->getStaffDetails($filter);
            $data['salaryYearInfo'] = $this->salary->getStaffSalaryYearInfo();
            $data['salaryInfo'] = $this->salary->getAllmySalaryInfo($filter, $returns["page"], $returns["segment"]);
            $data['accessInfo'] = $this->getCurrentAccess();

            $this->global['pageTitle'] = ''.TAB_TITLE.' : Salary Slip Details';
            $this->loadViews("salary/mysalary.php", $this->global, $data, NULL);

        }
    }
    public function getmySalaryPrint($student_id = null){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            error_reporting(0);
            $filter = array();
            // $student_id = $this->security->xss_clean($this->input->get('student_id'));
            
            // $student_id = base64_decode(urldecode($student_id));
            // $student_id = json_decode(stripslashes($student_id));
            $filter['student_id'] = $student_id;
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Salary Slip';
            $data['staffData'] = $this->salary->getStaffSalarySlipInfoById($filter);
            $data['salaryModel'] = $this->salary;
            
            define('_MPDF_TTFONTPATH', __DIR__ . '/fonts');
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','format' => 'A4-L']);
            $mpdf->AddPage('P','','','','',10,10,8,8,8,8);
            $mpdf->SetTitle('Staff Salary Slip');
            $html = $this->load->view('salary/printSalarySlipNew',$data,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('Salary_Slip.pdf', 'I');
        }
    }

   public function getStaffSalaryYearlyPrint()
{
    if ($this->isAdmin() == TRUE) {
        $this->loadThis();
    } else {

        error_reporting(0);

        $salary_year = $this->security->xss_clean($this->input->post('salary_year'));
        $salary_role = $this->security->xss_clean($this->input->post('salary_role'));

        $filter = [];
        $filter['salary_year'] = $salary_year;
        $filter['salary_role'] = $salary_role;

        $data['salary_year'] = $salary_year;
        $data['salary_role'] = $salary_role;

        $data['staffSalaryInfo'] = $this->salary->getStaffSalaryYearlyDetails($filter);

        define('_MPDF_TTFONTPATH', __DIR__ . '/fonts');

        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf',
            'format'  => 'A4-L'
        ]);

        $mpdf->AddPage('L','','','','',20,20,8,8,8,8);
        $mpdf->SetTitle('Annual Salary Statement');

        $html = $this->load->view('salary/printStaffSalaryYearly',$data,true);
        $mpdf->WriteHTML($html);
        setcookie('isDownLoaded', 1);
        $mpdf->Output('STAFF_SALARY_YEARLY_' . $salary_year . '.pdf', 'I');
    }
}

    public function downloadSalaryReport(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
            $salary_month = $this->security->xss_clean($this->input->post('esi_month'));
            $salary_year = $this->security->xss_clean($this->input->post('esi_year'));
            $salary_role = $this->security->xss_clean($this->input->post('esi_role'));
            
            $filter['salary_month'] = $salary_month;
            $filter['salary_year'] = $salary_year;
            $filter['salary_role'] = $salary_role;

            $sheet = 0;
            $this->excel->setActiveSheetIndex($sheet);
            $this->excel->getActiveSheet()->setTitle('PF Deduction Report');
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:K500');
            $this->excel->getActiveSheet()->setCellValue('A1', "ST ALOYSIUS PRE-UNIVERSITY COLLEGE, MANGALURU");
            $this->excel->getActiveSheet()->setCellValue('A2', "PF DEDUCTION REPORT ".$salary_month.' '.$salary_year);
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:K1');
            $this->excel->getActiveSheet()->mergeCells('A2:K2');
            $this->excel->getActiveSheet()->getStyle('A1:K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:K2')->getFont()->setBold(true);

            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);

            // Headers
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'UAN');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'MEMBER NAME');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'GROSS WAGES');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'EPF WAGES');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'EPS WAGES');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'EDLI WAGES');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'EPF CONTRI REMITTED');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('H3', 'EPS CONTRI REMITTED');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('I3', 'EPF EPS DIFF REMITTED');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('J3', 'NCP DAYS');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('K3', 'REFUND OF ADVANCES');

            $this->excel->getActiveSheet()->getStyle('A3:K3')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setWrapText(true);

            $staffInfo = $this->salary->getStaffSalaryDetails($filter);
            $excel_row = 4;

            if(!empty($staffInfo)){
                foreach($staffInfo as $staff){
                    if($staff->gross_salary > 0) {
                        
                        $gross_wages = $staff->gross_salary;
                        $basic_da = $staff->basic + $staff->da;
                        
                        // EPF WAGES: min(Basic+DA, 15000)
                        // $epf_wages = ($basic_da >= 15000) ? 15000 : $basic_da;
                        if ($basic_da >= 15000) {
                            $epf_wages = 15000;
                        } else {
                            $epf_wages = round($basic_da * 0.12);
                        }

                        
                        // EPS WAGES: If age > 58 then 0 else min(Basic+DA, 15000)
                        $age = 0;
                        if(!empty($staff->dob) && $staff->dob != '0000-00-00'){
                            $dob = new DateTime($staff->dob);
                            $now = new DateTime();
                            $age = $now->diff($dob)->y;
                        }

                        // $eps_wages = ($age > 58) ? 0 : $epf_wages;
                        if ($age > 58) {
                            $eps_wages = 0;
                        } else {
                            $eps_wages = $epf_wages;
                        }

                        // EDLI WAGES: min(Basic+DA, 15000)
                        // $edli_wages = $epf_wages;
                         if ($basic_da >= 15000) {
                            $edli_wages = 15000;
                        } else {
                            $edli_wages = round($basic_da * 0.12);
                        }

                        // EPF CONTRI REMITTED: EPF WAGES * 12%
                        $epf_contri = round($epf_wages * 0.12);

                        // EPS CONTRI REMITTED: EPS WAGES * 8.33%
                        $eps_contri = round($eps_wages * 0.0833);

                        // EPF EPS DIFF REMITTED: EPF CONTRI - EPS CONTRI
                        $diff_remitted = $epf_contri - $eps_contri;

                        // NCP DAYS: If working_day == 0 then total_days else 0
                        $ncp_days = 0;
                        if(property_exists($staff, 'working_day') && property_exists($staff, 'total_days')){
                             if($staff->working_day == 0){
                                 $ncp_days = $staff->total_days;
                             }
                        }

                        $refund_advances = 0;

                        $this->excel->setActiveSheetIndex($sheet)->setCellValueExplicit('A'.$excel_row, $staff->uan_no, PHPExcel_Cell_DataType::TYPE_STRING);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, strtoupper($staff->name));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, $gross_wages);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, $epf_wages);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, $eps_wages);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, $edli_wages);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, $epf_contri);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, $eps_contri);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row, $diff_remitted);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row, $ncp_days);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row, $refund_advances);
                        
                        $excel_row++;
                    }
                }
            }

            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A3:K'.($excel_row-1))->applyFromArray($styleBorderArray);

            $this->excel->createSheet();
            $filename='PF_DEDUCTION_REPORT.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            ob_start();
            $objWriter->save("php://output");
            $xlsData = ob_get_contents();
            ob_end_clean();
      
            $response =  array(
                'op' => 'ok',
                'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
            );
            die(json_encode($response));
        }
    }
}
    
?>

