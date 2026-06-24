<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class Librery_model extends CI_Model
{
    public function getStudyMaterialsCount($filter)
    {
        $this->db->from('tbl_study_material as study'); 
      
        if(!empty($filter['searchText'])){
            $likeCriteria = "(study.document_name_url  LIKE '%" . $filter['searchText'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['term_name'])){
            $this->db->where('study.term_name', $filter['term_name']);
        }
        if(!empty($filter['section_name'])){
            $this->db->where('study.section_name', $filter['section_name']);
        } 
        if(!empty($filter['stream_name'])){
            $this->db->where('study.stream_name', $filter['stream_name']);
        } 
        if(!empty($filter['type'])){
            $this->db->where('study.type', $filter['type']);
        } 

        if(!empty($filter['doc_name'])){
            $likeCriteria = "(study.document_name_url  LIKE '%" . $filter['doc_name'] . "%')";
            $this->db->where($likeCriteria);
        }

        if(!empty($filter['staff_id'])){
            $this->db->where('study.created_by', $filter['staff_id']);
        } 

        $this->db->where('study.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getStudyMaterialsInfo($filter, $page, $segment)
    {
        $this->db->from('tbl_study_material as study'); 
      
        if(!empty($filter['searchText'])){
            $likeCriteria = "(study.document_name_url  LIKE '%" . $filter['searchText'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['term_name'])){
            $this->db->where('study.term_name', $filter['term_name']);
        }
        if(!empty($filter['section_name'])){
            $this->db->where('study.section_name', $filter['section_name']);
        } 
        if(!empty($filter['stream_name'])){
            $this->db->where('study.stream_name', $filter['stream_name']);
        } 
        if(!empty($filter['type'])){
            $this->db->where('study.type', $filter['type']);
        } 
        if(!empty($filter['doc_name'])){
            $likeCriteria = "(study.document_name_url  LIKE '%" . $filter['doc_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        
        if(!empty($filter['staff_id'])){
            $this->db->where('study.created_by', $filter['staff_id']);
        } 
        $this->db->where('study.is_deleted', 0);
        $this->db->order_by('study.section_name', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }
//ADD NEW study
function addNewStudyMaterials($metInfo){
    $this->db->trans_start();
    $this->db->insert('tbl_study_material', $metInfo);
    $insert_id = $this->db->insert_id();
    $this->db->trans_complete();
    return $insert_id;
}

//ADD NEW study
function updateStudyMaterials($row_id, $studyInfo){
    $this->db->where('row_id', $row_id);
    $this->db->update('tbl_study_material', $studyInfo);
    return $this->db->affected_rows();
}
}