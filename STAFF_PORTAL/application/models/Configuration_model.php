<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Configuration_model extends CI_Model{
    
    public function getAllConfigInfo(){
        $this->db->where('is_deleted', 0);
        $this->db->from('tbl_configuration');
        $query = $this->db->get();
        return $query->result();
    }

    public function getConfigById($rowId){
        $this->db->where('row_id', $rowId);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get('tbl_configuration');
        return $query->row();
    }

    public function getConfigByKey($configKey){
        $this->db->where('LOWER(config_key)', strtolower($configKey));
        $this->db->where('is_deleted', 0);
        $query = $this->db->get('tbl_configuration');
        return $query->row();
    }

    public function getConfigByKeyIncludingDeleted($configKey){
        $this->db->where('LOWER(config_key)', strtolower($configKey));
        $query = $this->db->get('tbl_configuration');
        return $query->row();
    }

    public function addConfig($insertData){
        $insertData['is_deleted'] = 0;
        $this->db->insert('tbl_configuration', $insertData);
        return $this->db->insert_id();
    }

    public function updateConfig($rowId, $updateData){
        $this->db->where('row_id', $rowId);
        $this->db->where('is_deleted', 0);
        return $this->db->update('tbl_configuration', $updateData);
    }

    public function softDeleteConfig($rowId, $deleteData){
        $this->db->where('row_id', $rowId);
        $this->db->where('is_deleted', 0);
        return $this->db->update('tbl_configuration', $deleteData);
    }

    public function restoreConfig($rowId, $updateData){
        $this->db->where('row_id', $rowId);
        return $this->db->update('tbl_configuration', $updateData);
    }
}