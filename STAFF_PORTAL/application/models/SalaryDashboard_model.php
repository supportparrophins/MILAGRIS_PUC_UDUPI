<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class SalaryDashboard_model extends CI_Model {

    public function getStaffSalarySlipInfo($month){
        $this->db->select('staff.staff_id,staff.name,staff.pan_no,staff.aadhar_no,staff.uan_no,staff.esi_code,staff.pf_number,staff.gender,staff.salary_designation,
        staff.employee_id,staff.mobile_one,staff.dob,staff.doj,Role.role,dept.name as dept_name,salary.*,desig.designation');
        $this->db->from('tbl_staff_salary_slip as salary');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = salary.staff_id','left');
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        $this->db->join('tbl_salary_designation_details as desig', 'desig.row_id = salary.salary_designation_id','left');
        $this->db->where('salary.month', $month);
        $this->db->where('salary.is_deleted', 0);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    } 

    public function getLeaveUsedSum($type,$date_from,$date_to)
    {
        $this->db->select_sum('leave.total_days_leave');
        $this->db->from('tbl_staff_applied_leave as leave');
        $this->db->where('leave.leave_type', $type);
        $this->db->where('leave.is_deleted', 0);
        $this->db->where('leave.approved_status', 1);
        $this->db->where('leave.date_from >=', $date_from);
        $this->db->where('leave.date_to <=', $date_to);
        $query = $this->db->get();
        return $query->row();
    }
    public function getEarningInfo($type){
        $this->db->from('tbl_staff_earning_details as earning');
        $this->db->where('earning.year', '2024');
        $this->db->where('earning.salary_type', $type);
        $this->db->where('earning.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getdeductionInfo($type){
        $this->db->from('tbl_staff_deduction_details as deduction');
        $this->db->where('deduction.salary_type', $type);
        $this->db->where('deduction.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
}?>