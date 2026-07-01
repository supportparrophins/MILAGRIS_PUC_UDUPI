<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Observation_model extends CI_Model{

    // add Observation 
    function addObserve($observeInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_student_observation_info', $observeInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    
    public function getObservationCount($filter){
        $this->db->select('student.student_name,student.row_id as stdrowid,Observation.row_id,Observation.student_row_id,Observation.date,
        Observation.type_id,Observation.file_path,Observation.year,Observation.description,academic.term_name,academic.section_name,
        academic.student_id,type.row_id as typRowid,type.observation_name');
        
        $this->db->from('tbl_student_observation_info as Observation'); 
        $this->db->join('tbl_students_info as student', 'student.row_id = Observation.student_row_id','left');
        $this->db->join('tbl_student_academic_info as academic', 'academic.rel_student_row_id = student.row_id','left');
        $this->db->join('tbl_student_observation_type as type','type.row_id = Observation.type_id','left');

        if(!empty($filter['student_rowId'])){
            $this->db->where('Observation.student_row_id', $filter['student_rowId']);
        }
        if(!empty($filter['observe_type'])){
            $this->db->where('Observation.type_id', $filter['observe_type']);
        } 
        if(!empty($filter['file_path'])){
            $this->db->where('Observation.file_path', $filter['file_path']);
        } 
        if(!empty($filter['year'])){
            $this->db->where('Observation.year', $filter['year']);
        } 
        if(!empty($filter['description'])){
            $this->db->where('Observation.description', $filter['description']);
        }
        if(!empty($filter['date'])){
            $this->db->where('Observation.date', $filter['date']);
        }
        if(!empty($filter['term_name'])){
            $this->db->where('academic.term_name', $filter['term_name']);
        }
        if(!empty($filter['section_name'])){
            $this->db->where('academic.section_name', $filter['section_name']);
        }
        if(!empty($filter['by_stream'])){
            $this->db->where('academic.stream_name', $filter['by_stream']);
        }
        
        $this->db->order_by('Observation.date', 'DESC');
        $this->db->where('Observation.is_deleted', 0);
        $this->db->where('student.is_deleted', 0);
        $this->db->where('academic.is_current', 1);
        $this->db->where('academic.is_active', 1);

        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getObservationInfo($filter, $page, $segment){
        $this->db->select('student.student_name,student.row_id as stdrowid,Observation.row_id,Observation.remarks,
        Observation.student_row_id,Observation.date,Observation.type_id,Observation.file_path,
        Observation.year,Observation.description,academic.term_name,academic.section_name,academic.stream_name,
        academic.student_id,type.row_id as typRowid,type.observation_name');
        
        $this->db->from('tbl_student_observation_info as Observation'); 
        $this->db->join('tbl_students_info as student', 'student.row_id = Observation.student_row_id','left');
        $this->db->join('tbl_student_academic_info as academic', 'academic.rel_student_row_id = student.row_id','left');
        $this->db->join('tbl_student_observation_type as type','type.row_id = Observation.type_id','left');

        if(!empty($filter['student_rowId'])){
            $this->db->where('Observation.student_row_id', $filter['student_rowId']);
        }
        if(!empty($filter['observe_type'])){
            $this->db->where('Observation.remarks', $filter['observe_type']);
        } 
        if(!empty($filter['file_path'])){
            $this->db->where('Observation.file_path', $filter['file_path']);
        } 
        if(!empty($filter['year'])){
            $this->db->where('Observation.year', $filter['year']);
        } 
        if(!empty($filter['description'])){
            $this->db->where('Observation.description', $filter['description']);
        }
        if(!empty($filter['date'])){
            $this->db->where('Observation.date', $filter['date']);
        }
        if(!empty($filter['term_name'])){
            $this->db->where('academic.term_name', $filter['term_name']);
        }
        if(!empty($filter['section_name'])){
            $this->db->where('academic.section_name', $filter['section_name']);
        }
        if(!empty($filter['by_stream'])){
            $this->db->where('academic.stream_name', $filter['by_stream']);
        }
        
        $this->db->order_by('Observation.date', 'DESC');
        $this->db->where('Observation.is_deleted', 0);
        $this->db->where('student.is_deleted', 0);
        $this->db->where('academic.is_current', 1);
        $this->db->where('academic.is_active', 1);
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    public function getStudentInfo(){
        $this->db->select('student.row_id,student.sat_number, student.student_name, student.dob, student.gender, student.blood_group,academic.stream_name,
        student.application_no,student.intake_year,academic.term_name,academic.section_name,student.intake_year,academic.student_id,student.admission_no');
        $this->db->from('tbl_students_info as student'); 
        $this->db->join('tbl_student_academic_info as academic', 'academic.rel_student_row_id = student.row_id');
        $this->db->where('academic.is_current', 1);
        $this->db->where('academic.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $this->db->where('academic.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    public function getStudentVal($filter){
        $this->db->from('tbl_students_info as student');
        $this->db->where('student.is_deleted', 0);
        // $this->db->where('student.is_active', 1);
        $this->db->where('student.row_id', $filter['student_rowId']);
        $query = $this->db->get();
        $result = $query->row();        
        return $result;
    }

    public function getObservationVal($filter){
        $this->db->from('tbl_student_observation_type as type');
        $this->db->where('type.is_deleted', 0);
        $this->db->where('type.row_id', $filter['observe_type']);
        
        $query = $this->db->get();
        $result = $query->row();        
        return $result;
    }
    public function getObservationId(){
        $this->db->from('tbl_student_observation_type as type');
        $this->db->where('type.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    public function getObservationInfoById($row_id){
        $this->db->select('student.student_name,student.sat_number,info.row_id,info.student_row_id,
        info.description,info.date,student.admission_no,info.file_path,info.type_id,type.observation_name,
        academic.term_name,academic.section_name,info.remarks');
        $this->db->from('tbl_student_observation_info as info');
        $this->db->join('tbl_students_info as student', 'student.row_id = info.student_row_id','left');
        $this->db->join('tbl_student_academic_info as academic','academic.rel_student_row_id= student.row_id','left');
        $this->db->join('tbl_student_observation_type as type','type.row_id = info.type_id','left');
        $this->db->where('info.row_id', $row_id);
        $this->db->where('info.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();        
        return $result;
    }

    public function getObservation(){
        $this->db->select('student.student_name,student.row_id as stdrowid,Observation.student_row_id,Observation.date,
        Observation.type_id,Observation.file_path,Observation.year,Observation.description,
        type.row_id as typRowid,type.observation_name');
        $this->db->from('tbl_student_observation_info as Observation'); 
        $this->db->join('tbl_students_info as student', 'student.row_id = Observation.student_row_id','left');
        $this->db->join('tbl_student_observation_type as type','type.row_id = Observation.type_id','left');
        $this->db->order_by('Observation.date', 'DESC');
        $this->db->where('Observation.is_deleted', 0);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    //Delete observation
    function updatedStudentObservation($row_id,$observeInfo){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_student_observation_info', $observeInfo);
        return $this->db->affected_rows();
    }
}
?>