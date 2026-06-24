<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class App_staff_login extends CI_Model
{
    function checkMobNo($mblNumber)
    {
        log_message('debug', 'model_mbl_number' . print_r($mblNumber, true));
        $this->db->from('tbl_staff');
        $this->db->where('is_deleted', 0);
        $this->db->group_start();
        $this->db->where('mobile_one', $mblNumber);
        $this->db->or_where('mobile_two', $mblNumber);
        $this->db->group_end();
        $query = $this->db->get();
        $user = $query->row();
        return $user;
    }

    function fetchStaffDetails($mblNumber)
    {
        // log_message('debug','model_mbl_number'.print_r($mblNumber,true));
        $this->db->select(
            'staff.name,staff.staff_id,staff.row_id,staff.user_name,staff.type,staff.mobile_one,staff.mobile_two,staff.email,staff.address,staff.photo_url,staff.dob,staff.doj,staff.aadhar_no,staff.pan_no,staff.voter_no,staff.gender,staff.qualification,staff.blood_group,dept.name as department_name,Roles.role'
        );
        $this->db->from('tbl_staff as staff');
        $this->db->join('tbl_roles as Roles', 'Roles.roleId = staff.role');
        $this->db->join(
            'tbl_department as dept',
            'dept.dept_id = staff.department_id'
        );
        $this->db->where('staff.is_deleted', 0);
        $this->db->group_start();
        $this->db->where('staff.mobile_one', $mblNumber);
        $this->db->or_where('staff.mobile_two', $mblNumber);
        $this->db->group_end();
        $query = $this->db->get();
        return $query->result();
    }

   

    function getStaffName($staff_id)
    {
        // log_message('debug','model_mbl_number'.print_r($mblNumber,true));
        $this->db->select('staff.name');
        $this->db->from('tbl_staff as staff');

        $this->db->where('staff.is_deleted', 0);

        $this->db->where('staff.staff_id', $staff_id);

        $query = $this->db->get();
        return $query->result();
    }

    function fetchLeaveMangementInfo($staffID)
    {
        $this->db->from('tbl_staff_leave_management');
        $this->db->where('is_deleted', 0);
        $this->db->where('staff_id', $staffID);
        $this->db->where('year', LEAVE_YEAR);
        $query = $this->db->get();
        return $query->result();
    }

    public function applyLeaveInsert($info)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_staff_applied_leave', $info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function getLeaveHistory($staff_id)
    {
        // Select fields from tbl_staff_applied_leave and join tbl_staff twice for approved_by and rejected_by
        $this->db->select('leave.row_id, leave.staff_id, leave.applied_date_time, leave.date_from, leave.date_to, leave.approved_status, leave.total_days_leave, leave.leave_reason, leave.leave_type, leave.medical_certificate, leave.remark, leave.leave_name,
            approved_staff.name as approved_by, 
            rejected_staff.name as rejected_by');
    
        // From tbl_staff_applied_leave
        $this->db->from('tbl_staff_applied_leave as leave');
    
        // Join tbl_staff for approved_by
        $this->db->join('tbl_staff as approved_staff', 'leave.approved_by = approved_staff.staff_id', 'left');
        
        // Join tbl_staff for rejected_by
        $this->db->join('tbl_staff as rejected_staff', 'leave.rejected_by = rejected_staff.staff_id', 'left');
    
        // Where conditions
        $this->db->where('leave.staff_id', $staff_id);
        $this->db->where('leave.is_deleted', 0);
        $this->db->where('leave.year', LEAVE_YEAR);
        
        // Order by created_date_time in descending order
        $this->db->order_by('leave.created_date_time', 'desc');
        
        // Execute query
        $query = $this->db->get();
        
        // Return the result
        return $query->result();
    }

     function getApproveLeaveList($staff_id)
    {
        $this->db->select('leave.row_id, leave.staff_id, leave.applied_date_time, leave.date_from, leave.date_to, leave.approved_status, leave.total_days_leave, leave.leave_reason, leave.leave_type, leave.medical_certificate, leave.remark, leave.leave_name,
        approved_staff.name as approved_by, 
        rejected_staff.name as rejected_by');

        // From tbl_staff_applied_leave
        $this->db->from('tbl_staff_applied_leave as leave');

        // Join tbl_staff for approved_by
        $this->db->join('tbl_staff as approved_staff', 'leave.approved_by = approved_staff.staff_id', 'left');
        
        // Join tbl_staff for rejected_by
        $this->db->join('tbl_staff as rejected_staff', 'leave.rejected_by = rejected_staff.staff_id', 'left');
    
        $this->db->where('leave.year',LEAVE_YEAR);
        $this->db->where('leave.staff_id !=', $staff_id); // Modified line
        $this->db->order_by('leave.created_date_time', 'desc');
        //$this->db->where('date_from >=', LEAVE_YEAR.'-08-01');  // Sort by created_date_time in descending order
        $this->db->where('leave.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    function cancellLeave($leaveRowId, $info)
    {
        $this->db->where('row_id', $leaveRowId);
        $this->db->update('tbl_staff_applied_leave', $info);
        return 1;
    }

    function dashboardInfo()
    {
        // $this->db->select('menu.row_id,menu.title,menu.route,menu.icon,menu.primary_color,menu.secondary_color,menu.sub_menu,menu.is_weburl');
        $this->db->from('tbl_staff_dashboard_menu as menu');
        // $this->db->join('app_menu_restrict as rest','rest.menu_id=menu.row_id','left');
        $this->db->where('menu.is_deleted', 0);
        $this->db->order_by('menu.priority', 'ASC');
        // $this->db->where('rest.student_id',$student_id);
        $query = $this->db->get();
        return $query->result();
    }

    // public function getSUmOFUsedLeave($application_no){
    //     $this->db->select('SUM(leave.paid_amount) as paid_amount');
    //     $this->db->from('tbl_staff_applied_leave as leave');
    //     $this->db->where('fee.is_deleted', 0);
    //     $this->db->where('fee.application_no', $application_no);
    //     $query = $this->db->get();
    //     return $query->row();
    // }

    public function getLeaveUsedSum($staff_id, $type)
    {
        $this->db->select_sum('leave.total_days_leave');
        $this->db->from('tbl_staff_applied_leave as leave');
        $this->db->where('leave.staff_id', $staff_id);
        $this->db->where('leave.leave_type', $type);
        $this->db->where('leave.year',LEAVE_YEAR );
        $this->db->where('leave.is_deleted', 0);
        $this->db->where('leave.approved_status',[0, 1]);
        // $this->db->where('leave.date_from >=', LEAVE_DATE_FROM);
        // $this->db->where('leave.date_to <=', LEAVE_DATE_TO);
        $query = $this->db->get();
        return $query->row();
    }

    public function getSumLeaveInfo($staff_id, $type)
    {
        $this->db->select_sum('leave.total_days_leave');
        $this->db->from('tbl_staff_applied_leave as leave');
        $this->db->where('leave.staff_id', $staff_id);
        $this->db->where('leave.year',LEAVE_YEAR);
        $this->db->where('leave.leave_type', $type);
        $this->db->where('leave.is_deleted', 0);
        $this->db->where_in('leave.approved_status', [0, 1]); // Include both approved statuses
        // $this->db->where('leave.date_from >=', LEAVE_DATE_FROM);
        // $this->db->where('leave.date_to <=', LEAVE_DATE_TO);
        $query = $this->db->get();
        return $query->row();
    }

    function approveLeaveUpdate($leaveRowId, $info)
    {
        $this->db->where('row_id', $leaveRowId);
        $this->db->update('tbl_staff_applied_leave', $info);
        return 1;
    }

    public function checkDeviceExists($staffID, $device_id)
    {
        $this->db->from('tbl_staff_token');
        $this->db->where('staff_id', $staffID);
        $this->db->where('device_id', $device_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function updateToken($device_id, $info, $staffID)
    {
        $this->db->where('device_id', $device_id);
        $this->db->where('staff_id', $staffID);
        $this->db->update('tbl_staff_token', $info);
        return 1;
    }

    function addToken($info)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_staff_token', $info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function getAttendance($staff_id)
    {
        // Get current date in 'YYYY-MM-DD' format
        $current_date = date('Y-m-d');
        $this->db->from('tbl_staff_attendance_info as attendance');
        $this->db->where('attendance.is_deleted', 0);
        $this->db->where('attendance.staff_id', $staff_id);
        // Add condition to check for the current date
        $this->db->where('DATE(attendance.punch_date)', $current_date);
        $query = $this->db->get();
        return $query->result();
    }


  
     function getAttendanceList($staff_id)
    {
        // Get current year
        $current_year = date('Y');
    
        $this->db->from('tbl_staff_attendance_info as attendance');
        $this->db->where('attendance.is_deleted', 0);
        $this->db->where('attendance.staff_id', $staff_id);
        // Add condition to check that punch_date's year is the current year
        $this->db->where('YEAR(attendance.punch_date)', $current_year);
        $this->db->order_by('attendance.created_date_time', 'DESC'); // Sort by created_date_time in descending order
        
        $query = $this->db->get();
        return $query->result();
    }

    function fetchGivenLeave($leaveId)
    {
        // Get current date in 'YYYY-MM-DD' format
      
        $this->db->from('tbl_staff_applied_leave');
        $this->db->where('is_deleted', 0);
        $this->db->where('row_id', $leaveId);
        // Add condition to check for the current date
        $query = $this->db->get();
        return $query->result();
    }


    function getToken($staffId)
    {
        // Get current date in 'YYYY-MM-DD' format
        $this->db->select(
            'token'
        );
        $this->db->from('tbl_staff_token');
        $this->db->where('staff_id', $staffId);
        // Add condition to check for the current date
        $query = $this->db->get();
        return $query->result();
    }

    function fetchApproverList()
    {
        // Get current date in 'YYYY-MM-DD' format
      
        $this->db->from('tbl_staff');
        $this->db->where('is_deleted', 0);
        $this->db->where('leave_approved_status', 1);
        // Add condition to check for the current date
        $query = $this->db->get();
        return $query->result();
    }


    public function sendMessage($title,$body,$user_tokens,$user_type){

        if(count($user_tokens) > 0){
            $fcm_data=array(
                'title' => $title,
                'body'=> $body,
                'image'=> STAFF_NOTIFICATION_LOGO, 
                'user_type'=>$user_type         
            );

            log_message('debug','fcm_data -->'.print_r($fcm_data,true));
           log_message('debug','user_tokens -->'.print_r($user_tokens,true));
            $fcm_fields= array(
                'registration_ids' => $user_tokens,
                'notification' => $fcm_data,
            );

           // log_message('debug','fcm_fields -->'.print_r($fcm_fields,true));
            $fcm_result_array=$this->fcmPushNotification($fcm_fields);

            log_message('debug','fcm_result_array -->'.print_r($fcm_result_array,true));

            return 1;
        }else{
            return 0;
        }
        
        
    }    

    private static function fcmPushNotification($fields=array()){
        $headers = array(
            'Authorization: key=' . STAFF_FCM_SERVER_KEY,
            'Content-Type: application/json'
        );

        $fields['registration_ids'] = (array) $fields['registration_ids'];
       // log_message('debug','headers -->'.print_r($headers,true));

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, STAFF_FCM_URL);
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch);
     log_message('debug','result -->'.print_r($result,true));

        curl_close( $ch );
        return json_decode($result,true);
    }


    function getStaffRoleId($staffId)
    {
        // log_message('debug','model_mbl_number'.print_r($mblNumber,true));
        $this->db->select(
            'Roles.roleId,staff.leave_approved_status'
        );
        $this->db->from('tbl_staff as staff');
        $this->db->join('tbl_roles as Roles', 'Roles.roleId = staff.role');
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('staff.staff_id', $staffId);
        $query = $this->db->get();
        return $query->result();
    }


    function fetchSubjectList($staffId)
    {
        // log_message('debug','model_mbl_number'.print_r($mblNumber,true));
        $this->db->distinct();
        $this->db->select('teaching.subject_code, section.section_name, subjects.sub_name, term.term_name');
        $this->db->from('tbl_staff_teaching_subjects as teaching');
        $this->db->join('tbl_section_info as section', 'section.row_id = teaching.section_id');
        $this->db->join('tbl_subjects as subjects', 'subjects.subject_code = teaching.subject_code');
        $this->db->join('tbl_term_name as term', 'term.row_id = section.term_id');
        $this->db->where('teaching.staff_id', $staffId);
        $this->db->where('teaching.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
        
    }


    public function deleteToken($id){
        $this->db->where('device_id', $id);
        $this->db->delete('tbl_staff_token');
        return true;
    }


    function fecthStaffAllDetails($row_id)
    {
        // log_message('debug','model_mbl_number'.print_r($mblNumber,true));
        $this->db->select(
            'staff.name,staff.retirement_status,staff.resignation_status,staff.is_deleted,staff.staff_id,staff.row_id,staff.user_name,staff.type,staff.mobile_one,staff.mobile_two,staff.email,staff.address,staff.photo_url,staff.dob,staff.doj,staff.aadhar_no,staff.pan_no,staff.voter_no,staff.gender,staff.qualification,staff.blood_group,dept.name as department_name,Roles.role'
        );
        $this->db->from('tbl_staff as staff');
        $this->db->join('tbl_roles as Roles', 'Roles.roleId = staff.role');
        $this->db->join(
            'tbl_department as dept',
            'dept.dept_id = staff.department_id'
        );
        $this->db->where('staff.row_id', $row_id);
       
        $query = $this->db->get();
        return $query->result();
    }

    function getManagmentStatus($staff_id)
    {
        $this->db->select('management_view_status');
        $this->db->from('tbl_staff');
        $this->db->where('staff_id', $staff_id); // Modified line
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

   

    function updateOtp($info, $mblNumber)
    {
        $this->db->group_start();
        $this->db->where('mobile_one', $mblNumber);
        $this->db->or_where('mobile_two', $mblNumber);
        $this->db->group_end();
        $this->db->update('tbl_staff', $info);
        return true;
    }

    function checkOtp($mblNumber, $otp)
    {
        $this->db->from('tbl_staff');
        $this->db->where('is_deleted', 0);
        $this->db->group_start();
        $this->db->where('mobile_one', $mblNumber);
        $this->db->or_where('mobile_two', $mblNumber);
        $this->db->group_end();
        $this->db->where('last_otp', $otp);
        $query = $this->db->get();
        $user = $query->row();
        return $user;
    }

    function getAllApproveLeaveList($staff_id)
    {
        $this->db->select(
            'leave.row_id, leave.staff_id, leave.applied_date_time, leave.date_from, leave.date_to, leave.approved_status, leave.total_days_leave, leave.leave_reason, leave.remark, leave.leave_type, leave.leave_name, leave.approved_by, leave.rejected_by, leave.created_by, leave.created_date_time, leave.updated_date_time, leave.updated_by, leave.is_deleted, leave.medical_certificate'
        );
        $this->db->from('tbl_staff_applied_leave as leave');
        $this->db->join(
            'tbl_staff as staff',
            'staff.staff_id = leave.staff_id'
        );
        $this->db->where('leave.staff_id !=', $staff_id); // Modified line
        $this->db->order_by('leave.created_date_time', 'desc'); // Sort by created_date_time in descending order
        $this->db->where('leave.is_deleted', 0);
        $this->db->where('leave.year',LEAVE_YEAR );
        $this->db->where('staff.management_view_status', 1);
        $query = $this->db->get();
        return $query->result();
    }

    function getAllStaffList()
    {
        $this->db->select(
            'staff.name,staff.staff_id,staff.row_id,staff.user_name,staff.mobile_one,staff.mobile_two,dept.name as department_name,Roles.role'
        );
        $this->db->from('tbl_staff as staff');
        $this->db->join('tbl_roles as Roles', 'Roles.roleId = staff.role');
        $this->db->join(
            'tbl_department as dept',
            'dept.dept_id = staff.department_id'
        );
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    function addStaffNotification($info)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_staff_notifications', $info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function fetchStaffById($staffId)
    {
        // log_message('debug','model_mbl_number'.print_r($mblNumber,true));
        $this->db->select(
            'staff.name,staff.staff_id,staff.row_id,staff.user_name,staff.type,staff.mobile_one,staff.mobile_two,staff.email,staff.address,staff.photo_url,staff.dob,staff.doj,staff.aadhar_no,staff.pan_no,staff.voter_no,staff.gender,staff.qualification,staff.blood_group,dept.name as department_name,dept.dept_id,Roles.role'
        );
        $this->db->from('tbl_staff as staff');
        $this->db->join('tbl_roles as Roles', 'Roles.roleId = staff.role');
        $this->db->join(
            'tbl_department as dept',
            'dept.dept_id = staff.department_id'
        );
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('staff.staff_id', $staffId);
        $query = $this->db->get();
        return $query->result();
    }


    function getAllNotification($dept_id)
    {
        $this->db->from('tbl_staff_notifications');
        $this->db->where('is_deleted', 0);

        $this->db->group_start(); // Start grouping conditions
        $this->db->where('department', $dept_id);
        $this->db->or_where('department', 'ALL');
        $this->db->group_end(); // End grouping conditions

        $this->db->order_by('date_time', 'DESC'); // Sort by date_time in descending order
        $query = $this->db->get();
        return $query->result();
    }

    
    function getSingleNotification($row_id)
    {
        $this->db->from('tbl_staff_bulk_notification');
        $this->db->where('is_deleted', 0);
        $this->db->where('staffId', $row_id);
        $this->db->order_by('updated_date_time', 'DESC'); // Sort by date_time in descending order
        $query = $this->db->get();
        return $query->result();
    }


    function fetchPucSubjectList($staffId)
    {
        // log_message('debug','model_mbl_number'.print_r($mblNumber,true));
        $this->db->distinct();
        $this->db->select('teaching.subject_type,subject.name as subject_name,subject.subject_code,department.name as department');
        $this->db->from('tbl_staff_teaching_subjects as teaching');
        $this->db->join('tbl_subjects as subject', 'subject.subject_code = teaching.subject_code');
        $this->db->join('tbl_department as department', 'department.dept_id = subject.department_id');
        $this->db->where('teaching.staff_id', $staffId);
        $this->db->where('teaching.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
        
    }


    function fetchSectionList($staffId)
    {
        // log_message('debug','model_mbl_number'.print_r($mblNumber,true));
        $this->db->distinct();
        $this->db->select('info.term_name,info.section_name,stream.stream_name');
        $this->db->from('tbl_staff_sections as sections');
        $this->db->join('tbl_section_info as info', 'info.row_id = sections.section_id');
        $this->db->join('tbl_stream_info as stream', 'stream.row_id = info.stream_id');
        $this->db->where('sections.staff_id', $staffId);
        $this->db->where('sections.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
        
    }
public function getSalarySlip($row_id, $year, $month) {
    // log_message('debug', 'row_id -->' . print_r($row_id, true));
    // log_message('debug', 'year -->' . print_r($year, true));
    // log_message('debug', 'month -->' . print_r($month, true));
    $this->db->select('salary.*, staff.esi_code, staff.uan_no, staff.doj');  
    $this->db->from('tbl_staff_salary_slip as salary');
    $this->db->join('tbl_staff as staff', 'staff.staff_id = salary.staff_id');
    $this->db->where('salary.staff_id', $row_id);
     $this->db->where('salary.year', $year);
    $this->db->where('salary.month', $month);
    $this->db->where('salary.is_deleted', 0);
    $query = $this->db->get();
    $salarySlip = $query->row(); 

    return $salarySlip;
}
public function getEarnings($staff_id){
    $this->db->select('earning.salary_type, earning.value');
    $this->db->from('tbl_staff_earning_details as earning');
    $this->db->where('earning.staff_id', $staff_id);
    $earningsQuery = $this->db->get();
    $earnings = $earningsQuery->result(); 
    return $earnings;
}
public function getDeductions($staff_id){
    $this->db->select('deduction.salary_type, deduction.value');
    $this->db->from('tbl_staff_deduction_details as deduction');
    $this->db->where('deduction.staff_id', $staff_id);
    $deductionsQuery = $this->db->get();
    $deductions = $deductionsQuery->result(); 
    return $deductions;
}

 public function getStaffSalarySlipInfoById($filter=''){
        $this->db->select('staff.staff_id,staff.name,staff.pan_no,staff.aadhar_no,staff.uan_no,staff.esi_code,staff.pf_number,staff.gender,staff.salary_designation,
        staff.employee_id,staff.mobile_one,staff.dob,staff.doj,Role.role,dept.name as dept_name,salary.*,desig.designation');
        $this->db->from('tbl_staff_salary_slip as salary');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = salary.staff_id','left');
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        $this->db->join('tbl_salary_designation_details as desig', 'desig.row_id = salary.salary_designation_id','left');
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
    public function getSwitchProfile($mblNumber){
        // log_message('debug', '==   cbse switch staff_id ===>' . print_r($staff_id, true));
        $this->db->from('tbl_staff');
        $this->db->where('is_deleted', 0);
        $this->db->where('resignation_status', 0);
        $this->db->group_start();
        $this->db->where('mobile_one', $mblNumber);
        $this->db->or_where('mobile_two', $mblNumber);
        $this->db->group_end();
        $query = $this->db->get();
        return $query->result();
        
    }
    function fecthStaffswitchProfileAllDetails($staff_id)
    {
        // log_message('debug','model_mbl_number'.print_r($mblNumber,true));
        $this->db->select(
            'staff.name,staff.staff_id,staff.row_id,staff.user_name,staff.type,staff.mobile_one,staff.mobile_two,staff.email,staff.address,staff.photo_url,staff.dob,staff.doj,staff.aadhar_no,staff.pan_no,staff.voter_no,staff.gender,staff.qualification,staff.blood_group,dept.name as department_name,Roles.role'
        );
        $this->db->from('tbl_staff as staff');
        $this->db->join('tbl_roles as Roles', 'Roles.roleId = staff.role');
        $this->db->join(
            'tbl_department as dept',
            'dept.dept_id = staff.department_id'
        );
        $this->db->where('staff.staff_id', $staff_id);
       
        $query = $this->db->get();
        return $query->result();
    }

    
}

?>
