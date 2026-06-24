<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class Latecomer_model extends CI_Model
{
    protected $_table_name = 'tbl_latecomer_info';
    public function getLatecomerInfoCount($filter)
    {
        $this->db->from($this->_table_name. ' as late');
        $this->db->join('tbl_students_info as std', 'std.student_id = late.student_id');

        if(!empty($filter['by_term'])){
            $this->db->where('std.term_name', $filter['by_term']);  
        }
        if(!empty($filter['by_date'])){
            $this->db->where('late.date', $filter['by_date']);  
        }
        if(!empty($filter['by_intime'])){
            $this->db->where('late.intime', $filter['by_intime']);  
        }
        if(!empty($filter['section_name'])){
            $this->db->where('std.section_name', $filter['section_name']);  
        }
        if (!empty($filter['student_name'])) {
            $likeCriteria = "(std.student_name  LIKE '%" . $filter['student_name'] . "%')";
            $this->db->where($likeCriteria);
        }


        if(!empty($filter['student_id'])){
            $this->db->where('std.student_id', $filter['student_id']);  
        }
        
        $this->db->where('late.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getLatecomerInfo($filter)
    {
        $this->db->from($this->_table_name. ' as late');
        $this->db->join('tbl_students_info as std', 'std.student_id = late.student_id');

        if(!empty($filter['by_term'])){
            $this->db->where('std.term_name', $filter['by_term']);  
        }
        if(!empty($filter['by_date'])){
            $this->db->where('late.date', $filter['by_date']);  
        }
        if(!empty($filter['by_intime'])){
            $this->db->where('late.intime', $filter['by_intime']);  
        }
        if(!empty($filter['section_name'])){
            $this->db->where('std.section_name', $filter['section_name']);  
        }
        if (!empty($filter['student_name'])) {
            $likeCriteria = "(std.student_name  LIKE '%" . $filter['student_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('std.student_id', $filter['student_id']);  
        }

        $this->db->where('late.is_deleted', 0);
        // $this->db->where('std.is_active', 1);
        $this->db->order_by('late.student_id', 'ASC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function deleteLatecomer($lateId, $lateInfo)
    {
        $this->db->where('id', $lateId);
        $this->db->update($this->_table_name, $lateInfo);
        return $this->db->affected_rows();
    }

    public function countLatecomerByDate($term,$date)
    {
        $this->db->from($this->_table_name. ' as late');
        if($term == 'I PUC'){
            $this->db->join('tbl_first_puc_students_info as std', 'std.student_id = late.student_id');
        }else{
            $this->db->join('tbl_second_puc_students_info as std', 'std.student_id = late.student_id');
        }
        $this->db->where('late.date', $date);  
        $this->db->where('late.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

  public function getLatecomerInfoForDownload($term,$section_name,$late_count,$date_from,$date_to){
    $date_from = date("Y-m-d", strtotime($date_from));
    $date_to = date("Y-m-d", strtotime($date_to));
    $this->db->select('
    std.student_name,
    late.date,
    late.intime,
    std.section_name,
    std.term_name,
    std.student_id');
    $this->db->from($this->_table_name. ' as late');
    if($term == 'I PUC'){
        $this->db->join('tbl_first_puc_students_info as std', 'std.student_id = late.student_id');
    }else{
        $this->db->join('tbl_second_puc_students_info as std', 'std.student_id = late.student_id');
    }
    $this->db->where('std.section_name', $section_name);
    $this->db->where('late.date>=', $date_from);
    $this->db->where('late.date<=', $date_to);
    $this->db->where('late.is_deleted', 0);
    $this->db->where_in('late.student_id', "SELECT student_id FROM tbl_latecomer_info
    WHERE date >= '$date_from' AND date <= '$date_to'
    group by student_id having count(student_id) >= $late_count",false);
    //$this->db->having('count(late.student_id) >=',$late_count);
    $this->db->order_by('late.student_id', 'ASC');
    $query = $this->db->get();
    $result = $query->result();
    return $result;
  }  

  public function getTotalNumberOfLateComerMonth($student_id,$date_from,$date_to)
  {
      $this->db->from($this->_table_name. ' as late');
      $this->db->where('late.student_id', $student_id);
      $this->db->where('late.date>=', $date_from);
      $this->db->where('late.date<=', $date_to);
      $this->db->where('late.is_deleted', 0);
      $query = $this->db->get();
      return $query->num_rows();
  }

  public function checkLatecomerExist($student_id,$date){
    $this->db->from($this->_table_name.' as late');
    $this->db->where('late.student_id', $student_id);
    $this->db->where('late.date', $date);
    $this->db->where('late.is_deleted', 0);
    $query = $this->db->get();
    return $query->num_rows();
  }

  function addLatecomerStudentInfo($studentInfo){
    $this->db->trans_start();
    $this->db->insert($this->_table_name, $studentInfo);
    $insert_id = $this->db->insert_id();
    $this->db->trans_complete();
    return $insert_id;
}   
}