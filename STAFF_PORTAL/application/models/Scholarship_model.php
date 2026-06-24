<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Scholarship_model extends CI_Model

{

    function scholarshipListing($filter='', $page, $segment)
    {
        $this->db->select('BaseTbl.*,type.scholarship_type');
        $this->db->from('tbl_scholarship_info as BaseTbl');
        $this->db->join('tbl_scholarship_type as type','type.row_id = BaseTbl.scholarship_id','left');

        if(!empty($filter['scholarship_society'])){
            $this->db->where('BaseTbl.scholarship_society', $filter['scholarship_society']);
        }
        if(!empty($filter['max_amount'])){
            $this->db->where('BaseTbl.max_amount', $filter['max_amount']);
        }

        if(!empty($filter['scholarship_type'])){
            $this->db->where('type.scholarship_type', $filter['scholarship_type']);
        }
        if(!empty($filter['application_no_prefix'])){
            $this->db->where('BaseTbl.application_no_prefix', $filter['application_no_prefix']);
        }
        if(!empty($filter['scholarship_date'])){
            $this->db->where('BaseTbl.scholarship_end_date', $filter['scholarship_date']);
        }
   
        $this->db->where('BaseTbl.is_deleted', 0);
        $this->db->where('type.is_deleted', 0);
        $this->db->order_by('BaseTbl.row_id', 'desc');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    function scholarshipListingCount($filter='')
    {
        $this->db->from('tbl_scholarship_info as BaseTbl');
        $this->db->join('tbl_scholarship_type as type','type.row_id = BaseTbl.scholarship_id','left');

        if(!empty($filter['scholarship_society'])){
            $this->db->where('BaseTbl.scholarship_society', $filter['scholarship_society']);
        }
        if(!empty($filter['max_amount'])){
            $this->db->where('BaseTbl.max_amount', $filter['max_amount']);
        }

        if(!empty($filter['scholarship_type'])){
            $this->db->where('type.scholarship_type', $filter['scholarship_type']);
        }
        if(!empty($filter['application_no_prefix'])){
            $this->db->where('BaseTbl.application_no_prefix', $filter['application_no_prefix']);
        }
        if(!empty($filter['scholarship_date'])){
            $this->db->where('BaseTbl.scholarship_end_date', $filter['scholarship_date']);
        }
   
        $this->db->where('BaseTbl.is_deleted', 0);
        $this->db->where('type.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getScholarshipInfoByType($scholarship_id) {
        $this->db->from('tbl_scholarship_info');
        $this->db->where('scholarship_id', $scholarship_id);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();        
        return $result;
        
    }

    

    function addScholarshipInfoToDB($scholarshipInfos)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_scholarship_info', $scholarshipInfos);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getScholarshipInfoByEmpId($row_id) {
        $this->db->select('scholarship.*,type.scholarship_type');
        $this->db->from('tbl_scholarship_info as scholarship');
        $this->db->join('tbl_scholarship_type as type','type.row_id = scholarship.scholarship_id','left');
        $this->db->where('scholarship.row_id', $row_id);
        $this->db->where('scholarship.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();        
        return $result;
        
    }

    function studentSholarshipListing($row_id,$filter)
    {
        $this->db->select('BaseTbl.* , scholarship.scholarship_end_date,scholarship.scholarship_society,type.scholarship_type');
        $this->db->from('tbl_scholarship_student_list as BaseTbl');
        $this->db->join('tbl_scholarship_info as scholarship','scholarship.row_id = BaseTbl.scholarship_row_id','left');
        $this->db->join('tbl_scholarship_type as type','type.row_id = scholarship.scholarship_id','left');
        // $this->db->join('tbl_student_info as student','student.row_id = BaseTbl.student_row_id','left');
        


        if(!empty($filter['application_no'])){
            $this->db->where('BaseTbl.application_number', $filter['application_no']);
        }
     
        if(!empty($filter['student_name'])){
            $likeCriteria = "(BaseTbl.student_row_id  LIKE '%" . $filter['student_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['debit_ac_no_list'])){
            $likeCriteria = "(BaseTbl.debit_ac_no  LIKE '%" . $filter['debit_ac_no_list'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['credit_ac_no_list'])){
            $likeCriteria = "(BaseTbl.credit_ac_no  LIKE '%" . $filter['credit_ac_no_list'] . "%')";
            $this->db->where($likeCriteria);
        }

        if(!empty($filter['application_date'])){
            $this->db->where('BaseTbl.application_date', $filter['application_date']);
        }
        $this->db->where('BaseTbl.scholarship_row_id',$row_id);
        $this->db->where('BaseTbl.is_deleted', 0);
        $this->db->where('scholarship.is_deleted', 0);
        $this->db->where('type.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    public function getLastApplicationNumberScholarship($scholarship_row_id) {
        $this->db->select('application_number');
        $this->db->from('tbl_scholarship_student_list');
        $this->db->where('scholarship_row_id',$scholarship_row_id);
        $this->db->order_by('row_id', 'DESC');
        $this->db->where('is_deleted', 0);
        $this->db->limit(1);
        $query = $this->db->get();
        $result = $query->row();
        return $result ? $result->application_number : null;
    }

    function addScholarshipStudentInfoToDB($sevaInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_scholarship_student_list', $sevaInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function updateScholarshipStudentDetail($sevaInfo, $row_id) {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_scholarship_student_list', $sevaInfo);
        return TRUE;
    }

    function getScholarshipStudentInformationByID($row_id)
    {
        $this->db->select('BaseTbl.* , scholarship.scholarship_end_date,scholarship.scholarship_society,type.scholarship_type');
        $this->db->from('tbl_scholarship_student_list as BaseTbl');
        $this->db->join('tbl_scholarship_info as scholarship','scholarship.row_id = BaseTbl.scholarship_row_id','left');
        $this->db->join('tbl_scholarship_type as type','type.row_id = scholarship.scholarship_id','left');
        // $this->db->join('tbl_student_info as student','student.row_id = BaseTbl.student_row_id','left');
        
        $this->db->where('BaseTbl.row_id',$row_id);
        $this->db->where('BaseTbl.is_deleted', 0);
        // $this->db->where('student.is_deleted', 0);
        $this->db->where('scholarship.is_deleted', 0);
        $this->db->where('type.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();        
        return $result;
    }

    function updateScholarshipInfo($scholarshipInfo, $row_id)
    {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_scholarship_info', $scholarshipInfo);
        return TRUE;
    }  

    function getScholarshipInfoForReportDownload($scholarship_type){
        $this->db->select('BaseTbl.* , scholarship.scholarship_end_date,scholarship.scholarship_society,type.scholarship_type');
        $this->db->from('tbl_scholarship_student_list as BaseTbl');
        $this->db->join('tbl_scholarship_info as scholarship','scholarship.row_id = BaseTbl.scholarship_row_id','left');
        $this->db->join('tbl_scholarship_type as type','type.row_id = scholarship.scholarship_id','left');
        // $this->db->join('tbl_student_info as student','student.row_id = BaseTbl.student_row_id','left');
        if (!in_array('ALL', $scholarship_type)) {
            $this->db->where_in('type.scholarship_type', $scholarship_type);
        }
        $this->db->where('BaseTbl.is_deleted', 0);
        // $this->db->where('student.is_deleted', 0);
        $this->db->where('scholarship.is_deleted', 0);
        $this->db->where('type.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    } 

    function getStudentSholarship($row_id)
    {
        $this->db->select('BaseTbl.* , scholarship.scholarship_end_date,type.scholarship_type');
        $this->db->from('tbl_scholarship_student_list as BaseTbl');
        $this->db->join('tbl_scholarship_info as scholarship','scholarship.row_id = BaseTbl.scholarship_row_id','left');
        $this->db->join('tbl_scholarship_type as type','type.row_id = scholarship.scholarship_id','left');
        // $this->db->join('tbl_student_info as student','student.row_id = BaseTbl.student_row_id','left');
     
        $this->db->where('BaseTbl.row_id',$row_id);
        $this->db->where('BaseTbl.is_deleted', 0);
        // $this->db->where('student.is_deleted', 0);
        $this->db->where('scholarship.is_deleted', 0);
        $this->db->where('type.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();        
        return $result;
    }

    function getTotalStudentCount($row_id)
    {
        $this->db->from('tbl_scholarship_student_list');
        $this->db->where('is_deleted', 0);
        $this->db->where('scholarship_row_id', $row_id);
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    
    }

    function getTotalStudentSanctionedAmount($row_id)
    {
        $this->db->select('SUM(scholarship.scholarship_amount) as total_san');
        $this->db->from('tbl_scholarship_student_list as scholarship');
        $this->db->where('scholarship.is_deleted', 0);
        $this->db->where('scholarship.scholarship_row_id', $row_id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    
    }
    public function isScholarshipTypeAlreadyExist($scholarship_type){
        $this->db->from('tbl_scholarship_type as scholarship'); 
        $this->db->where('scholarship.scholarship_type', $scholarship_type); 
        $this->db->where('scholarship.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    function addScholarshipType($religionInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_scholarship_type', $religionInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getAllScholarshipTypeInfo(){
        $this->db->from('tbl_scholarship_type as scholarship');
        $this->db->where('scholarship.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    function updateScholarshipType($religionInfo, $row_id)
    {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_scholarship_type', $religionInfo);
        return TRUE;
    }

    public function isScholarshipRecommendedAlreadyExist($name){
        $this->db->from('tbl_scholarship_recommended_by as scholarship'); 
        $this->db->where('scholarship.name', $name); 
        $this->db->where('scholarship.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    function addRecommendedBy($religionInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_scholarship_recommended_by', $religionInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getAllScholarshipRecommendedInfo(){
        $this->db->from('tbl_scholarship_recommended_by as scholarship');
        $this->db->where('scholarship.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    function updateScholarshipRecommendedBy($religionInfo, $row_id)
    {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_scholarship_recommended_by', $religionInfo);
        return TRUE;
    }
}

?>