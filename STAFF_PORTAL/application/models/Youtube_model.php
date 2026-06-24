<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Youtube_model extends CI_Model
{
    
    public function getAllYoutubeCount($filter){
        $this->db->from('tbl_youtube_video_details as youtube');
        if(!empty($filter['term_name'])){
            $this->db->where('youtube.term_name', $filter['term_name']);
        }
        if(!empty($filter['stream_name'])){
            $this->db->where('youtube.stream_name', $filter['stream_name']);
        } 
        if(!empty($filter['subject_name'])){
            $this->db->where('youtube.subject_name', $filter['subject_name']);
        } 
        if(!empty($filter['video_name'])){
            $this->db->where('youtube.video_name', $filter['video_name']);
        } 
        if($filter['by_date'] != "1970-01-01"){
            $this->db->where('youtube.date', $filter['by_date']);
        } 
        if(!empty($filter['staff_id'])){
            $this->db->where('youtube.created_by', $filter['staff_id']);
        } 
        $this->db->where('youtube.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getAllYoutubeInfo($filter, $page, $segment){
        $this->db->from('tbl_youtube_video_details as youtube');
        if(!empty($filter['term_name'])){
            $this->db->where('youtube.term_name', $filter['term_name']);
        }
        if(!empty($filter['stream_name'])){
            $this->db->where('youtube.stream_name', $filter['stream_name']);
        } 
        if(!empty($filter['subject_name'])){
            $this->db->where('youtube.subject_name', $filter['subject_name']);
        } 
        if(!empty($filter['video_name'])){
            $this->db->where('youtube.video_name', $filter['video_name']);
        } 
        if($filter['by_date'] != "1970-01-01"){
            $this->db->where('youtube.date', $filter['by_date']);
        } 
        if(!empty($filter['staff_id'])){
            $this->db->where('youtube.created_by', $filter['staff_id']);
        } 
        $this->db->where('youtube.is_deleted', 0);
        $this->db->order_by('youtube.row_id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        return $query->result();
    }

    public function addYoutube($youtubeInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_youtube_video_details', $youtubeInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getAllYoutubeInfoById($row_id){
        $this->db->from('tbl_youtube_video_details as youtube');
        $this->db->where('youtube.row_id', $row_id);
        $this->db->where('youtube.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
        
    }

    public function updateYoutubeInfo($youtubeInfo,$row_id) {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_youtube_video_details', $youtubeInfo);
        return TRUE;
    }
}
?>