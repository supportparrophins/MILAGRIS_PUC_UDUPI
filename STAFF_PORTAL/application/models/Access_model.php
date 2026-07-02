<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Access_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get role-based access info for given role and sub-module.
     */
    public function getRoleAccess($role_id, $sub_module_id)
    {
        $this->db->where('role_id', $role_id);
        $this->db->where('sub_module_id', $sub_module_id);
        $this->db->where('is_deleted', 0);
        $this->db->where('can_access', 1);
        $query = $this->db->get('tbl_user_role_access'); // your table name

        if ($query->num_rows() > 0) {
            return $query->row(); // single record with permissions
        }
        return null;
    }

    public function getRoleAccessForReport($role_id, $redirect_url, $staff_id)
    {

        $this->db->select('usa.*, sm.menu_name, sm.redirect_url, sm.icon, sm.priority');
        $this->db->from('tbl_user_role_access_by_staff as usa');
        $this->db->join('tbl_sub_modules as sm', 'sm.row_id = usa.sub_module_id');
        $this->db->where('usa.staff_id', $staff_id);
        $this->db->where('sm.redirect_url', $redirect_url);
        $this->db->where('usa.is_deleted', 0);
        $this->db->where('sm.is_deleted', 0);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        }
        $this->db->select('ura.*, sm.menu_name, sm.redirect_url, sm.icon, sm.priority');
        $this->db->from('tbl_user_role_access as ura');
        $this->db->join('tbl_sub_modules as sm', 'sm.row_id = ura.sub_module_id');
        $this->db->where('ura.role_id', $role_id);
        $this->db->where('sm.redirect_url', $redirect_url);
        $this->db->where('ura.is_deleted', 0);
        $this->db->where('sm.is_deleted', 0);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();   // returns single row with role access + sub module info
        }

        return null;
    }

     public function getRoleAccessByStaffID($staff_id, $sub_module_id)
    {
        $this->db->where('staff_id', $staff_id);
        $this->db->where('sub_module_id', $sub_module_id);
        $this->db->where('is_deleted', 0);
        $this->db->where('can_access', 1);
        $query = $this->db->get('tbl_user_role_access_by_staff'); // your table name

        if ($query->num_rows() > 0) {
            return $query->row(); // single record with permissions
        }
        return null;
    }
}
