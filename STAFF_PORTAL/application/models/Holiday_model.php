<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
    class Holiday_model extends CI_Model
    {
        function getHolidayCount($filter,$role)
        {
           $this->db->from('tbl_college_holiday_info as holiday'); 
         
           if(!empty($filter['reason'])) {
                $likeCriteria = "(holiday.reason  LIKE '%".$filter['reason']."%')";
                $this->db->where($likeCriteria);
            }
            if(!empty($filter['by_date'])) {
                $this->db->where('holiday.holiday_date', date('Y-m-d',strtotime($filter['by_date'])));
            }
            if($role != ROLE_ADMIN && $role != ROLE_PRINCIPAL && $role != ROLE_PRIMARY_ADMINISTRATOR){
                $this->db->like('holiday.role_status', $role);
            }
          
            $this->db->where('holiday.is_deleted', 0);
            $query = $this->db->get();
            return $query->num_rows();
        }
        
        function getHolidayListing($filter, $page, $segment,$role)
        {
            $this->db->from('tbl_college_holiday_info as holiday'); 
           
            if(!empty($filter['reason'])) {
                $likeCriteria = "(holiday.reason  LIKE '%".$filter['reason']."%')";
                $this->db->where($likeCriteria);
            }
            if(!empty($filter['by_date'])) {
                $this->db->where('holiday.holiday_date', date('Y-m-d',strtotime($filter['by_date'])));
            }
            if($role != ROLE_ADMIN && $role != ROLE_PRINCIPAL && $role != ROLE_PRIMARY_ADMINISTRATOR){
                $this->db->like('holiday.role_status', $role);
            }
            $this->db->where('holiday.is_deleted', 0);
            $this->db->order_by('holiday.holiday_date', 'ASC');
            $this->db->limit($page, $segment);
            $query = $this->db->get();
            return $query->result();        
        }


        function addNewHoliday($holidayInfo){
            $this->db->trans_start();
            $this->db->insert('tbl_college_holiday_info', $holidayInfo);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            return $insert_id;
        }

        function updateHoliday($holidayInfo, $row_id)
        {
            $this->db->where('row_id', $row_id);
            $this->db->update('tbl_college_holiday_info', $holidayInfo);
            return TRUE;
        }
        public function getHolidayInfoById($row_id)
        {
            $this->db->from('tbl_college_holiday_info as holiday');
            $this->db->where('holiday.row_id', $row_id);
            $query = $this->db->get();
            return $query->row();
        }
        public function getHolidayInfoByRole($role){
            $this->db->from('tbl_college_holiday_info as holiday');
            if($role != ROLE_PRIMARY_ADMINISTRATOR){
                $this->db->like('holiday.role_status', $role);
            }
            $this->db->like('holiday.role_status', $role);
            $this->db->where('holiday.is_deleted', 0);
            $query = $this->db->get();
            return $query->result();          
        }

        public function getHolidayInfoByRoleByDay($role,$date_from,$date_to){
            $this->db->from('tbl_college_holiday_info as holiday');
            if($role != ROLE_PRIMARY_ADMINISTRATOR){
                $this->db->like('holiday.role_status', $role);
            }
            // $this->db->where('holiday.holiday_date >=', $date_from);
            // $this->db->where('holiday.holiday_date <=', $date_to);
            $this->db->where("(
                (holiday.holiday_date >= '$date_from' AND holiday.holiday_date <= '$date_to') OR
                (holiday.holiday_date_to >= '$date_from' AND holiday.holiday_date_to <= '$date_to') OR
                (holiday.holiday_date <= '$date_from' AND holiday.holiday_date_to >= '$date_to')
            )", NULL, FALSE);
            $this->db->where('holiday.is_deleted', 0);
            $query = $this->db->get();
            return $query->result();          
        }

        function getStaffRolesForStaff($staff_id)
        {
            $this->db->select('roleId, role');
            $this->db->from('tbl_roles');
            if($staff_id != '123456'){
            $this->db->where('roleId !=', 15);
            $this->db->where('roleId !=', 50);
            $this->db->where('roleId !=', 51);
            }
            $query = $this->db->get();
            return $query->result();
        }

        public function getRoleNameById($roleId) {
            $this->db->select('role');
            $this->db->from('tbl_roles');
            $this->db->where('roleId', $roleId);
            $query = $this->db->get();
    
            if ($query->num_rows() > 0) {
                return $query->row()->role;
            } else {
                return 'Unknown Role';
            }
        }

        public function getRolesByHolidayId($row_id)
        {
            $holiday = $this->getHolidayInfoById($row_id);
            if ($holiday && !empty($holiday->role_status)) {
                $roleIds = explode(',', $holiday->role_status);
                $this->db->select('roleId, role');
                $this->db->from('tbl_roles');
                $this->db->where_in('roleId', $roleIds);
                $query = $this->db->get();
                return $query->result();
            }
            return [];
        }
    }