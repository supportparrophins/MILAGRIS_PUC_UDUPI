<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class salary_model extends CI_Model
{

    public function getAllSalaryInfo($filter, $page, $segment){
        $this->db->select('staff.staff_id,staff.name,salary.*');
        $this->db->from('tbl_staff_salary_slip as salary'); 
        $this->db->join('tbl_staff as staff', 'staff.staff_id = salary.staff_id','left');
        // $this->db->join('tbl_factory_name as factory', 'factory.row_id = staff.factory_id','left');
        if(!empty($filter['name'])){
            $likeCriteria = "(staff.name  LIKE '%" . $filter['name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['date'])){
            $this->db->where('salary.date', $filter['date']);
        }
        
        if(!empty($filter['staff_id'])){
            $likeCriteria = "(staff_id.staff_id  LIKE '%" . $filter['staff_id'] . "%')";
            $this->db->where($likeCriteria);
        }
         if(!empty($filter['gross_salary'])){
            $this->db->where('salary.gross_salary', $filter['gross_salary']);
        }
          if(!empty($filter['grade_pay'])){
            $this->db->where('salary.grade_pay', $filter['grade_pay']);
        }
         if(!empty($filter['net_amount'])){
            $this->db->where('salary.net_amount', $filter['net_amount']);
        }
        if(!empty($filter['working_day'])){
            $this->db->where('salary.working_day', $filter['working_day']);
        }
        if (!empty($filter['lop_day'])) {
            // Using custom SQL condition for lop_day
            $this->db->where('(salary.total_days - salary.working_day) =', $filter['lop_day']);
        }
        if(!empty($filter['basic'])){
            $this->db->where('salary.basic', $filter['basic']);
        }
         if(!empty($filter['by_month'])){
            $this->db->where('salary.month', $filter['by_month']);
        }
         if(!empty($filter['by_year'])){
            $this->db->where('salary.year', $filter['by_year']);
        }
       
        $this->db->where('salary.is_deleted', 0);
        $this->db->order_by('salary.date', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllSalaryCount($filter=''){
        $this->db->from('tbl_staff_salary_slip as salary'); 
        $this->db->join('tbl_staff as staff', 'staff.staff_id = salary.staff_id','left');
        if(!empty($filter['name'])){
            $likeCriteria = "(staff.name  LIKE '%" . $filter['name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['date'])){
            $this->db->where('salary.date', $filter['date']);
        }
        
        if(!empty($filter['staff_id'])){
            $likeCriteria = "(staff_id.staff_id  LIKE '%" . $filter['staff_id'] . "%')";
            $this->db->where($likeCriteria);
        }
         if(!empty($filter['gross_salary'])){
            $this->db->where('salary.gross_salary', $filter['gross_salary']);
        }
         if(!empty($filter['working_day'])){
            $this->db->where('salary.working_day', $filter['working_day']);
        }
        if (!empty($filter['lop_day'])) {
            // Using custom SQL condition for lop_day
            $this->db->where('(salary.total_days - salary.working_day) =', $filter['lop_day']);
        }
          if(!empty($filter['grade_pay'])){
            $this->db->where('salary.grade_pay', $filter['grade_pay']);
        }
         if(!empty($filter['net_amount'])){
            $this->db->where('salary.net_amount', $filter['net_amount']);
        }
         if(!empty($filter['basic'])){
            $this->db->where('salary.basic', $filter['basic']);
        }
         if(!empty($filter['by_month'])){
            $this->db->where('salary.month', $filter['by_month']);
        }
         if(!empty($filter['by_year'])){
            $this->db->where('salary.year', $filter['by_year']);
        }
        $this->db->where('salary.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function addSalarySlipInfo($info){
            $this->db->trans_start();
            $this->db->insert('tbl_staff_salary_slip', $info);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            return $insert_id;
        }

    public function getSalaryInfoById($row_id)
        {
            $this->db->select('staff.staff_id,staff.name,salary.account_no,salary.basic,salary.con,salary.hr,salary.gross_salary,salary.total_salary,
            salary.total_days,salary.working_day,salary.total_allowances,salary.basic_deduction,salary.allowance_deduction,salary.salary_paid,salary.esi,
            salary.pf,salary.pt,salary.total_deduction,salary.net_amounts,salary.year,salary.monthsalary.date');
             $this->db->from('tbl_staff_salary_slip as salary'); 
             $this->db->join('tbl_staff as staff', 'staff.staff_id = salary.staff_id','left');
            $this->db->where('salary.row_id', $row_id);
            $this->db->where('salary.is_deleted', 0);
            $query = $this->db->get();
            return $query->row();
        }

    function updateSalarySlipInfo($info,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff_salary_slip', $info);
        return TRUE;
    }
    // get info for Salary Slip
    public function getStaffSalarySlipInfoById($filter=''){
        $this->db->select('staff.staff_id,staff.name,staff.pan_no,staff.aadhar_no,staff.uan_no,staff.esi_code,staff.pf_number,staff.gender,staff.salary_designation,
        staff.employee_id,staff.mobile_one,staff.dob,staff.doj,Role.role,dept.name as dept_name,salary.*,desig.designation,bank.account_no');
        $this->db->from('tbl_staff_salary_slip as salary');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = salary.staff_id','left');
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        $this->db->join('tbl_salary_designation_details as desig', 'desig.row_id = staff.salary_designation','left');
        $this->db->join('tbl_staff_bank_info as bank', 'bank.staff_id = salary.staff_id','left');
        if(!empty($filter['student_id'])){
            $this->db->where_in('salary.row_id', $filter['student_id']);
        }
        $this->db->where('salary.is_deleted', 0);
        $this->db->where('staff.is_deleted', 0);
        $this->db->group_by('salary.row_id');
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    } 

      function getStaffId($staff_id){
         // $this->db->select('stf.staff_id');
            $this->db->from('tbl_staff as stf');
            $this->db->where('stf.staff_id', $staff_id);
            $this->db->where('stf.is_deleted',0);
            $query = $this->db->get();
        return $query->row();
    }
    public function CheckSlarySlipGenerated($staff_id,$year,$month)
    {
        $this->db->from('tbl_staff_salary_slip as salary'); 
        $this->db->where('salary.staff_id', $staff_id);
        $this->db->where('salary.year', $year);
        $this->db->where('salary.month', $month);
        $this->db->where('salary.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    public function getStaffSalaryDetails($filter=''){
        $this->db->select('staff.staff_id,staff.name,shift.name as shift_name,salary.*,staff.pf_number,staff.esi_code,staff.gender,
        staff.pan_no,staff.aadhar_no,staff.uan_no,dept.name as dept_name,staff.dob,staff.doj,Role.role,bank.bank_name,staff.mobile_one,
        bank.branch_name,bank.account_no,bank.ifsc_code');
        $this->db->from('tbl_staff_salary_slip as salary');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = salary.staff_id','left');
        $this->db->join('tbl_staff_bank_info as bank', 'bank.staff_id = salary.staff_id','left');
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
        if(!empty($filter['salary_month'])){
            $this->db->where('salary.month', $filter['salary_month']);
        }
        if(!empty($filter['salary_year'])){
            $this->db->where('salary.year', $filter['salary_year']);
        }
        if(!empty($filter['salary_role'])){
            if(is_array($filter['salary_role'])){
                if(!in_array("ALL", $filter['salary_role'])){
                    $this->db->where_in('staff.role', $filter['salary_role']);
                }
            }else{
                if($filter['salary_role'] != 'ALL'){
                    $this->db->where('staff.role', $filter['salary_role']); 
                }
            }
        }
        $this->db->where('salary.is_deleted', 0);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    public function getStaffSalaryYearlyDetails($filter) {
        $year = $filter['salary_year'];
        // $next_year = $year + 1;
        $role = $filter['salary_role'];

        $this->db->select('salary.*, staff.name as staff_name, staff.staff_id');
        $this->db->from('tbl_staff_salary_slip as salary');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = salary.staff_id', 'left');

        $this->db->group_start();
            $this->db->group_start();
                $this->db->where('salary.year', $year);
                $this->db->where_in('salary.month', array('January', 'February', 'March','April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'));
            $this->db->group_end();
            
            // $this->db->or_group_start();
            //     $this->db->where('salary.year', $next_year);
            //     $this->db->where_in('salary.month', array('January', 'February', 'March'));
            // $this->db->group_end();
        $this->db->group_end();

        if ($role != 'ALL' && !empty($role)) {
            $this->db->where('staff.role', $role);
        }

        $this->db->where('salary.is_deleted', 0);
        $this->db->where('staff.is_deleted', 0);

        $this->db->order_by('salary.staff_id', 'ASC');
        $this->db->order_by('salary.year', 'ASC');
        // Sort by month order for financial year
        $this->db->order_by("FIELD(salary.month, 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'January', 'February', 'March', 'January', 'February', 'March')");

        $query = $this->db->get();
        return $query->result();
    }

    public function getStaffAdvanceSalaryInfo($staff_id)
    {
        $this->db->from('tbl_staff_advance_payment_info as staff'); 
        $this->db->where('staff.staff_id ', $staff_id);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    } 
    function addAdvanceSalaryInstallmentInfo($info){
        $this->db->trans_start();
        $this->db->insert('tbl_advance_salary_installment_info', $info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function getAdvanceSalaryPaidInfo($staff_id, $row_id)
    {
        $this->db->select('SUM(staff.installment_amount) as installment_amount');
        $this->db->from('tbl_advance_salary_installment_info as staff');
        $this->db->where('staff.staff_id', $staff_id);
        $this->db->where('staff.advance_id', $row_id);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->row()->installment_amount;
    }
    public function getAdvanceInstallmentInfoByStaffId($staff_id){
        $this->db->from('tbl_advance_salary_installment_info as staff');
        $this->db->where('staff.staff_id', $staff_id);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAdvanceAmountInfo($filter = '')
    {
        $this->db->from('tbl_staff_advance_payment_info as section');
        if (!empty($filter['row_id '])) {
            $this->db->where('section.row_id ', $filter['row_id ']);
        }
        $this->db->where('section.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    function updateAdvancePaymentDetails($info,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff_advance_payment_info', $info);
        return TRUE;
    }
    public function getAdvanceSalaryInstallmentInfo($staff_id, $row_id){
        $this->db->from('tbl_advance_salary_installment_info as staff');
        $this->db->where('staff.staff_id', $staff_id);
        $this->db->where('staff.advance_id', $row_id);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllStaffAdvanceSalaryInfo($filter)
    {
        $this->db->select('staff.user_name, shift.name as shift_name, shift.shift_code, shift.start_time, factory.factory_name,
        shift.end_time, staff.type, staff.row_id, staff.staff_id, staff.email, staff.name,dept.name as department, advance.advance_amount,
        staff.mobile, Role.role, staff.address, staff.dob,advance.date,advance.row_id as advance_id');
        $this->db->from('tbl_staff as staff'); 
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
        $this->db->join('tbl_staff_advance_payment_info as advance', 'advance.staff_id = staff.staff_id','left');
        $this->db->join('tbl_factory_name as factory', 'factory.row_id = staff.factory_id','left');
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('Role.roleId !=', '50');
        $this->db->where('Role.roleId !=', '51');
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('staff.resignation_status', 0);
        $this->db->where('advance.is_deleted', 0);
        if($filter['factory_name']!='ALL')
        {
            $this->db->where('factory.factory_name', $filter['factory_name']);
        }
        if(!empty($filter['date_from']) && !empty($filter['date_to'])){
            $this->db->where('DATE(advance.date) >=', $filter['date_from']);
            $this->db->where('DATE(advance.date) <=', $filter['date_to']);
        }
        if(!empty($filter['date_from']) ){
            $this->db->where('DATE(advance.date) >=', $filter['date_from']);
        }
        if(!empty($filter['date_to'])){
            $this->db->where('DATE(advance.date) <=', $filter['date_to']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    function updateSalaryInfoByID($info,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff_salary_info', $info);
        return TRUE;
    }
    public function getStaffOtInfo($staff_id,$date_from,$date_to)
    {
        $this->db->select('SUM(staff.total_ot_amount) as total_ot_amount');
        $this->db->from('tbl_staff_ot_info as staff');
        $this->db->where('staff.date>=', $date_from);
        $this->db->where('staff.date<=', $date_to);
        $this->db->where('staff.staff_id', $staff_id);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->row()->total_ot_amount;
    }
    public function getSingleStaffAttendanceInfoAB($staff_id, $date_from, $date_to){
        // Generate an array of dates between date_from and date_to
        $dates = [];
        $current_date = strtotime($date_from);
        $end_date = strtotime($date_to);
    
        while ($current_date <= $end_date) {
            $dates[] = date("Y-m-d", $current_date);
            $current_date = strtotime("+1 day", $current_date);
        }
    
        // Convert the dates array to a comma-separated string for SQL
        $dates_str = "'" . implode("','", $dates) . "'";
    
        // Your original query
        $query = $this->db->query("SELECT staff.staff_id,sa.punch_time,sa.punch_out_time,
        sa.punch_date, staff.type, staff.row_id, staff.name, dept.name as department, staff.mobile, role_.role, role_.roleId,
        shift.start_time, shift.end_time, shift.name, shift.shift_code FROM 
        tbl_staff_attendance_info as sa
        JOIN tbl_staff as staff ON staff.staff_id = sa.staff_id
        JOIN tbl_roles as role_ ON role_.roleId = staff.role
        JOIN tbl_department as dept ON dept.dept_id = staff.department_id
        JOIN tbl_staff_shift_info as shift ON staff.shift_code = shift.shift_code
        WHERE
        staff.is_deleted = 0 AND staff.resignation_status = 0 AND
        sa.staff_id = '$staff_id'
        AND sa.punch_date >= '$date_from' AND sa.punch_date <= '$date_to' 
        GROUP BY sa.punch_date");
    
        // Fetch the result
        $result = $query->result();
    
        // Create an associative array with dates as keys
        $attendance_info = [];
        foreach ($result as $row) {
            $attendance_info[$row->punch_date] = $row;
        }
    
        // Fill in missing dates with null values
        foreach ($dates as $date) {
            if (!isset($attendance_info[$date])) {
                $attendance_info[$date]['punch_date'] = '';
                $attendance_info[$date]['test_date'] = $date;
                $attendance_info[$date]['in_time'] =  '';
                $attendance_info[$date]['out_time'] =  '';
                $attendance_info[$date]['punch_time'] =  '';
                $attendance_info[$date]['start_time'] =  '';
            }
        }
    
        // Sort the array by date
        ksort($attendance_info);

        $attendance_info = json_decode(json_encode($attendance_info));
    
        return $attendance_info;
    }
    // public function getAllStaffInfoSalarySlipGenartion($filter)
    // {
    //     $this->db->select('staff.user_name, shift.name as shift_name, shift.shift_code, shift.start_time,bank.account_no,
    //     shift.end_time, staff.type, staff.row_id, staff.staff_id, staff.email, staff.name,dept.name as department');
    //     $this->db->distinct();
    //     $this->db->from('tbl_staff as staff'); 
    //     $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
    //     $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
    //     $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
    //     $this->db->join('tbl_staff_bank_info as bank', 'bank.staff_id  = staff.staff_id','left');
    //     $this->db->where('staff.staff_id !=', '123456');
    //     $this->db->where('Role.roleId !=', '50');
    //     $this->db->where('staff.is_deleted', 0);
    //     $this->db->where('staff.resignation_status', 0);
    //     $this->db->where('staff.retirement_status', 0);
    //     $query = $this->db->get();
    //     return $query->result();
    // }
    function checkInstitutionNameByID($institution_name) {
        $this->db->from('tbl_factory_name as Factory');
        $this->db->where('Factory.row_id', $institution_name);
        $this->db->where('Factory.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    function deleteAdanceInstallmentInfo($salary_slip_id, $info){
        $this->db->where('salary_slip_id', $salary_slip_id);
        $this->db->update('tbl_advance_salary_installment_info', $info);
        return TRUE;
    }

    function addOtherAmountDetails($OtherInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_staff_other_amount_info', $OtherInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getAllOtherAmountInfo($staff_id){
        $this->db->from('tbl_staff_other_amount_info as amount');
        $this->db->where('amount.staff_id', $staff_id);
        $this->db->where('amount.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    
    function updateOtherAmountInfoByID($info, $row_id)
    {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff_other_amount_info', $info);
        return TRUE;
    }

    public function getStaffOtherAmountInfo($staff_id,$year,$month)
    {
        $this->db->from('tbl_staff_other_amount_info as amount');
        $this->db->where('amount.year', $year);
        $this->db->where('amount.month', $month);
        $this->db->where('amount.staff_id', $staff_id);
        $this->db->where('amount.is_deleted', 0);
        $query = $this->db->get();
        return $query->row()->other_amount;
    }

    public function getLopLeaveOfStaff($staff_id,$startDate,$endDate)
    {
        $this->db->select_sum('leave.total_days_leave');
        $this->db->from('tbl_staff_applied_leave as leave');
        $this->db->where('leave.staff_id', $staff_id);
        $this->db->where('leave.date_from >=', $startDate);
        $this->db->where('leave.date_to <=', $endDate);
        $this->db->where('leave.leave_type', 'LOP');
        $this->db->where('leave.is_deleted', 0);
        $this->db->where('leave.approved_status', 1);
        $query = $this->db->get();
        return $query->row();
    }

    function addEarning($earning_data){
        $this->db->trans_start();
        $this->db->insert('tbl_staff_earning_details', $earning_data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function addDeduction($deduction_data){
        $this->db->trans_start();
        $this->db->insert('tbl_staff_deduction_details', $deduction_data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    // In your Salary model
public function checkEarningExists($data) {
    $this->db->where('staff_id', $data['staff_id']);
    $this->db->where('year', $data['year']);
    $this->db->where('salary_type', $data['salary_type']);
    $this->db->where('calculate_type', $data['calculate_type']);
    $this->db->where('is_deleted', 0);
    $query = $this->db->get('tbl_staff_earning_details'); // Assuming 'earnings' is your table name

    return $query->num_rows() > 0;
}

public function checkDeductionExists($data) {
    $this->db->where('staff_id', $data['staff_id']);
    $this->db->where('year', $data['year']);
    $this->db->where('salary_type', $data['salary_type']);
    $this->db->where('calculate_type', $data['calculate_type']);
    $this->db->where('is_deleted', 0);
    $query = $this->db->get('tbl_staff_deduction_details'); // Assuming 'deductions' is your table name

    return $query->num_rows() > 0;
}

public function getAllStaffEarningInfo($staff_id){
    $this->db->from('tbl_staff_earning_details as earning');
    $this->db->where('earning.staff_id', $staff_id);
    $this->db->where('earning.is_deleted', 0);
    $this->db->order_by('earning.year','DESC');
    $query = $this->db->get();
    return $query->result();
}

public function getAllStaffDeductionInfo($staff_id){
    $this->db->from('tbl_staff_deduction_details as deduction');
    $this->db->where('deduction.staff_id', $staff_id);
    $this->db->where('deduction.is_deleted', 0);
    $this->db->order_by('deduction.year','DESC');
    $query = $this->db->get();
    return $query->result();
}

public function getAllStaffInfoSalarySlipGenartion($filter)
    {
        $this->db->select('staff.user_name, shift.name as shift_name, shift.shift_code, shift.start_time,staff.employee_id,desig.row_id as salary_id,
        shift.end_time, staff.type, staff.row_id, staff.staff_id, staff.email, staff.name,dept.name as department, staff.tax_regime,
        staff.mobile_one, Role.role, staff.address, staff.dob,bank.account_no');
        $this->db->distinct();
        $this->db->from('tbl_staff as staff'); 
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
        $this->db->join('tbl_staff_bank_info as bank', 'bank.staff_id = staff.staff_id','left');
        $this->db->join('tbl_salary_designation_details as desig', 'desig.row_id = staff.salary_designation','left');
        if($filter['role_id'] != 'ALL') {
            $this->db->where('staff.role', $filter['role_id']); 
        }
        if($filter['staff_id'] != 'ALL') {
            $this->db->where('staff.staff_id', $filter['staff_id']); 
        }
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('Role.roleId !=', '50');
        $this->db->where('Role.roleId !=', '51');
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('staff.resignation_status', 0);
        $this->db->where('staff.retirement_status',0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getOtherAmountStaff($staff_id,$year){
        $this->db->from('tbl_staff_earning_details as earning');
        $this->db->where('earning.staff_id', $staff_id);
        $this->db->where('earning.year', $year);
        $this->db->where('earning.salary_type', 'OTHERS');
        $this->db->where('earning.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getEarningInfo($staff_id,$year,$type){
        $this->db->from('tbl_staff_earning_details as earning');
        $this->db->where('earning.staff_id', $staff_id);
        $this->db->where('earning.year', $year);
        $this->db->where('earning.salary_type', $type);
        $this->db->where('earning.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getdeductionInfo($staff_id,$year,$type){
        $this->db->from('tbl_staff_deduction_details as deduction');
        $this->db->where('deduction.staff_id', $staff_id);
        $this->db->where('deduction.year', $year);
        $this->db->where('deduction.salary_type', $type);
        $this->db->where('deduction.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getDesignationInfo($designation){
        $this->db->from('tbl_salary_designation_details as designation');
        $this->db->where('designation.designation', $designation);
        $this->db->where('designation.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getSalaryDesignationInfoById($staff_id){
        $this->db->select('designation.*');
        $this->db->from('tbl_staff as staff');
        $this->db->join('tbl_salary_designation_details as designation', 'designation.row_id = staff.salary_designation','left');
        $this->db->where('staff.staff_id ', $staff_id);
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('designation.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    public function getSalaryDesignationInfoByRowId($row_id){
        $this->db->select('designation.*');
        $this->db->from('tbl_staff as staff');
        $this->db->join('tbl_salary_designation_details as designation', 'designation.row_id = staff.salary_designation','left');
        $this->db->where('staff.row_id ', $row_id);
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('designation.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getEarningDetailsByStaffID($staff_id){
        $this->db->from('tbl_staff_earning_details as earning');
        $this->db->where('earning.staff_id', $staff_id);
        $this->db->where('earning.year', DESIGNATION_YEAR);
        $this->db->where('earning.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getDeductionDetailsByStaffID($staff_id){
        $this->db->from('tbl_staff_deduction_details as deduction');
        $this->db->where('deduction.staff_id', $staff_id);
        $this->db->where('deduction.year', DESIGNATION_YEAR);
        $this->db->where('deduction.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function updateSalaryDesignationEarnings($salaryTypeInfo, $staff_id) {   
        $this->db->where('staff_id', $staff_id);
        $this->db->where('year', DESIGNATION_YEAR);
        $this->db->update('tbl_staff_earning_details', $salaryTypeInfo);
        return TRUE;

    }

    public function updateSalaryDesignationDeduction($salaryTypeInfo, $staff_id) {   
        $this->db->where('staff_id', $staff_id);
        $this->db->where('year', DESIGNATION_YEAR);
        $this->db->update('tbl_staff_deduction_details', $salaryTypeInfo);
        return TRUE;

    }

    function addAdvancePaymentDetails($StaffInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_staff_advance_payment_info', $StaffInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function getAdvanceInfoByStaffId($staff_id){
        $this->db->from('tbl_staff_advance_payment_info as staff');
        $this->db->where('staff.staff_id', $staff_id);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllmySalaryCount($filter=''){
        $this->db->select('staff.staff_id,staff.name,salary.*');
       $this->db->from('tbl_staff_salary_slip as salary'); 
       $this->db->join('tbl_staff as staff', 'staff.staff_id = salary.staff_id','left');
       if(!empty($filter['name'])){
           $likeCriteria = "(staff.name  LIKE '%" . $filter['name'] . "%')";
           $this->db->where($likeCriteria);
       }
       if(!empty($filter['date'])){
           $this->db->where('salary.date', $filter['date']);
       }
        if(!empty($filter['by_month'])){
           $this->db->where('salary.month', $filter['by_month']);
       }
        if(!empty($filter['by_year'])){
           $this->db->where('salary.year', $filter['by_year']);
       }
       if(!empty($filter['staff_id'])){
           $this->db->where('staff.staff_id', $filter['staff_id']);
       }
       $this->db->where('salary.is_deleted', 0);
       $query = $this->db->get();
       return $query->num_rows();
   }
   public function getAllmySalaryInfo($filter, $page, $segment){
    $this->db->select('staff.staff_id,staff.name,salary.*');
       $this->db->from('tbl_staff_salary_slip as salary'); 
       $this->db->join('tbl_staff as staff', 'staff.staff_id = salary.staff_id','left');
       if(!empty($filter['name'])){
           $likeCriteria = "(staff.name  LIKE '%" . $filter['name'] . "%')";
           $this->db->where($likeCriteria);
       }
       if(!empty($filter['date'])){
           $this->db->where('salary.date', $filter['date']);
       }
        if(!empty($filter['by_month'])){
           $this->db->where('salary.month', $filter['by_month']);
       }
        if(!empty($filter['by_year'])){
           $this->db->where('salary.year', $filter['by_year']);
       }
       if(!empty($filter['staff_id'])){
           $this->db->where('staff.staff_id', $filter['staff_id']);
       }
       $this->db->where('salary.is_deleted', 0);
       $this->db->limit($filter['page'], $filter['segment']);
       $this->db->order_by('salary.date', 'DESC');
       $this->db->order_by('salary.year', 'DESC');
       $query = $this->db->get();
       return $query->result();
   }

   public function getStaffSalaryYearInfo()
   {
       $this->db->from('tbl_year_info as year');
       $this->db->where('year.is_deleted', 0);
       $this->db->where('year.salary_status', 1);
     $this->db->order_by('year.year','desc');
       $query = $this->db->get();
       return $query->result();
   }

   public function getAllStaffInfoSalaryLogic($filter)
   {
       $this->db->select('staff.user_name, shift.name as shift_name, shift.shift_code, shift.start_time,bank.account_no,
       shift.end_time, staff.type, staff.row_id, staff.staff_id, staff.email, staff.name,dept.name as department');
       $this->db->distinct();
       $this->db->from('tbl_staff as staff'); 
       $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
       $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
       $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
       $this->db->join('tbl_staff_bank_info as bank', 'bank.staff_id  = staff.staff_id','left');
       if($filter['role_id'] != 'ALL') {
            $this->db->where('staff.role', $filter['role_id']); 
        }
        if($filter['staff_id'] != 'ALL') {
            $this->db->where('staff.staff_id', $filter['staff_id']); 
        }
       $this->db->where('staff.staff_id !=', '123456');
       $this->db->where('Role.roleId !=', '50');
       $this->db->where('Role.roleId !=', '51');
       $this->db->where('staff.is_deleted', 0);
       $this->db->where('staff.resignation_status', 0);
       $this->db->where('staff.retirement_status',0);
       $query = $this->db->get();
       return $query->result();
   }

   public function CheckLeaveLogicExecuted($staff_id,$year,$month)
    {
        $this->db->from('tbl_leave_logic_execution as info'); 
        $this->db->where('info.year', $year);
        $this->db->where('info.month', $month);
        $this->db->where('info.staff_id', $staff_id);
        $this->db->where('info.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function addLeaveLogicExecution($leaveInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_leave_logic_execution', $leaveInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;   
    }

    public function getHolidayInfoByRole($role,$formattedDate){
        $this->db->from('tbl_college_holiday_info as holiday');
        if($role != ROLE_PRIMARY_ADMINISTRATOR){
            $this->db->like('holiday.role_status', $role);
        }
        $this->db->where('holiday.is_deleted', 0);
        $this->db->where('holiday.holiday_date <=',  $formattedDate);
        $this->db->where('holiday.holiday_date_to >=',  $formattedDate);
        $query = $this->db->get();
        return $query->result();          
    }

    public function checkLeaveAppliedAlready($staff_id,$formattedDate)
    {
        $this->db->from('tbl_staff_applied_leave as leave'); 
        $this->db->where('leave.staff_id', $staff_id);
        $this->db->where('leave.approved_status !=', 2);
        $this->db->where('leave.date_from <=',  $formattedDate);
        $this->db->where('leave.date_to >=',  $formattedDate);
        $this->db->where('leave.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function checkAttendanceExtraTime($formattedDate)
    {
        $this->db->from('tbl_staff_attendance_time_info as time'); 
        $this->db->where('time.date',  $formattedDate);
        $this->db->where('time.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }


}
?>