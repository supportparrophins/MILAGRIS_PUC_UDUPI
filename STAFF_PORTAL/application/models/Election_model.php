<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Election_model extends CI_Model{
    
    function getAllStudentElectionInfoCount($filter){
        $this->db->from('tbl_student_election_candidate_info as election'); 
        $this->db->join('tbl_student_academic_info as academic', 'academic.student_id = election.application_no','left');
        $this->db->join('tbl_students_info as std', 'std.application_no = academic.application_no','left');
        $this->db->join('tbl_student_election_post_info as post', 'post.post_id = election.post_name','left');
        if(!empty($filter['post_name'])) {
        $likeCriteria = "(post.post_name  LIKE '%".$filter['post_name']."%')";
        $this->db->where($likeCriteria);
        }
        if(!empty($filter['application_no'])){
        $likeCriteria = "(election.application_no  LIKE '%".$filter['application_no']."%')";
        $this->db->where($likeCriteria);
        }
        if(!empty($filter['election_date'])) {
            $this->db->where('election.election_date', date('Y-m-d',strtotime($filter['election_date'])));
        }
        if(!empty($filter['program_name'])) {
            $this->db->where('election.program_name', $filter['program_name']);
        }

        $this->db->where('election.is_deleted', 0);
            $this->db->where('post.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    } 
    
    function getAllStudentElectionInfo($filter, $page, $segment){
        $this->db->select('election.election_date, election.row_id,std.student_name, election.application_no,
        post.post_name,election.photo_url,election.program_name');
        $this->db->from('tbl_student_election_candidate_info as election'); 
        $this->db->join('tbl_student_election_post_info as post', 'post.post_id = election.post_name','left');
        $this->db->join('tbl_student_academic_info as academic', 'academic.student_id = election.application_no','left');
        $this->db->join('tbl_students_info as std', 'std.application_no = academic.application_no','left');
        if(!empty($filter['post_name'])) {
            $likeCriteria = "(post.post_name  LIKE '%".$filter['post_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['application_no'])){
            $likeCriteria = "(election.application_no  LIKE '%".$filter['application_no']."%')";
            $this->db->where($likeCriteria);
        }

        if(!empty($filter['election_date'])) {
            $this->db->where('election.election_date', date('Y-m-d',strtotime($filter['election_date'])));
        }
        if(!empty($filter['program_name'])) {
            $this->db->where('election.program_name', $filter['program_name']);
        }

        $this->db->where('election.is_deleted', 0);
        $this->db->group_by('election.row_id', 0);
        $this->db->where('post.is_deleted', 0);
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        return $query->result();        
    }


    function addNewStudentElection($electionInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_student_election_candidate_info', $electionInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function updateStudentElection($electionInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_student_election_candidate_info', $electionInfo);
        return TRUE;
    }

    public function getStudentElectionInfoById($row_id) {
        $this->db->select('election.row_id,election.application_no,election.photo_url,election.election_date,
        election.program_name,post.post_name,post.post_id');
        $this->db->from('tbl_student_election_candidate_info as election');
        $this->db->join('tbl_student_election_post_info as post', 'post.post_id = election.post_name','left');
        $this->db->where('election.row_id', $row_id);
        $query = $this->db->get();
        return $query->row();
    }

    function getTotalVotesGain($row_id){
        $this->db->from('tbl_student_election_polling_info as poll'); 
        $this->db->where('poll.is_deleted', 0);
            $this->db->where('poll.election_candiate_row_id', $row_id);
        $query = $this->db->get();
        return $query->num_rows();
    } 
}