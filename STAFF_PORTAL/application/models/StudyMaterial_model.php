<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class StudyMaterial_model extends CI_Model
{
    
    public function getStudyMaterialsCount($filter)
    {
        $this->db->from('tbl_study_material as study'); 
      
        if(!empty($filter['searchText'])){
            $likeCriteria = "(study.document_name_url  LIKE '%" . $filter['searchText'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_date'])){
            $likeCriteria = "(study.created_date_time  LIKE '%" . $filter['by_date'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_term'])){
            $this->db->where('study.term_name', $filter['by_term']);
        }
        if(!empty($filter['section_name'])){
            $this->db->where('study.section_name', $filter['section_name']);
        } 
        if(!empty($filter['by_stream_name'])){
            $this->db->where('study.stream_name', $filter['by_stream_name']);
        } 
        if(!empty($filter['type'])){
            $this->db->where('study.type', $filter['type']);
        } 
        if(!empty($filter['by_subject'])){
            $this->db->where('study.subject_name', $filter['by_subject']);
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
        if(!empty($filter['by_date'])){
            $likeCriteria = "(study.created_date_time  LIKE '%" . $filter['by_date'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_term'])){
            $this->db->where('study.term_name', $filter['by_term']);
        }
        if(!empty($filter['section_name'])){
            $this->db->where('study.section_name', $filter['section_name']);
        } 
        if(!empty($filter['by_stream_name'])){
            $this->db->where('study.stream_name', $filter['by_stream_name']);
        } 
        if(!empty($filter['by_subject'])){
            $this->db->where('study.subject_name', $filter['by_subject']);
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
        $this->db->order_by('study.created_date_time', 'DESC');
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

    //update study
    function updateStudyMaterials($row_id, $studyInfo){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_study_material', $studyInfo);
        return $this->db->affected_rows();
    }

    // online class
    public function getAllClassCount($filter){
        $this->db->from('tbl_student_online_class as class');
        if(!empty($filter['term_name'])){
            $this->db->where('class.term_name', $filter['term_name']);
        }
        if(!empty($filter['stream_name'])){
            $this->db->where('class.stream_name', $filter['stream_name']);
        } 
        if(!empty($filter['section_name'])){
            $this->db->where('class.section_name', $filter['section_name']);
        } 
        if(!empty($filter['subject_name'])){
            $this->db->where('class.subject_name', $filter['subject_name']);
        } 
        if($filter['by_date'] != "1970-01-01"){
            $this->db->where('class.date', $filter['by_date']);
        } 
        if(!empty($filter['start_time'])){
            $this->db->where('class.from_time', $filter['start_time']);
        } 
        if(!empty($filter['end_time'])){
            $this->db->where('class.to_time', $filter['end_time']);
        }  
        if(!empty($filter['app_type'])){
            $this->db->where('class.application_type', $filter['app_type']);
        } 
        if(!empty($filter['description'])){
            $this->db->where('class.description', $filter['description']);
        } 
        if(!empty($filter['staff_id'])){
            $this->db->where('class.created_by', $filter['staff_id']);
        } 
        $this->db->where('class.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getAllClassInfo($filter, $page, $segment){
        $this->db->from('tbl_student_online_class as class');
        
        if(!empty($filter['term_name'])){
            $this->db->where('class.term_name', $filter['term_name']);
        }
        if(!empty($filter['stream_name'])){
            $this->db->where('class.stream_name', $filter['stream_name']);
        } 
        if(!empty($filter['section_name'])){
            $this->db->where('class.section_name', $filter['section_name']);
        } 
        if(!empty($filter['subject_name'])){
            $this->db->where('class.subject_name', $filter['subject_name']);
        } 
        if($filter['by_date'] != "1970-01-01"){
            $this->db->where('class.date', $filter['by_date']);
        } 
        if(!empty($filter['start_time'])){
            $this->db->where('class.from_time', $filter['start_time']);
        } 
        if(!empty($filter['end_time'])){
            $this->db->where('class.to_time', $filter['end_time']);
        }  
        if(!empty($filter['app_type'])){
            $this->db->where('class.application_type', $filter['app_type']);
        } 
        if(!empty($filter['description'])){
            $this->db->where('class.description', $filter['description']);
        } 
        if(!empty($filter['staff_id'])){
            $this->db->where('class.created_by', $filter['staff_id']);
        } 
        $this->db->where('class.is_deleted', 0);
        $this->db->order_by('class.row_id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        return $query->result();
    }

    public function addOnlineClass($classInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_student_online_class', $classInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getAllClassInfoById($row_id){
        $this->db->from('tbl_student_online_class as class');
        $this->db->where('class.row_id', $row_id);
        $this->db->where('class.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
        
    }

    public function updateOnlineClassInfo($classInfo,$row_id) {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_student_online_class', $classInfo);
        return TRUE;
    }

    // youtube video
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

    
    public function getStreamInfo($filter=''){
        $this->db->select('section.row_id,section.stream_id,stream.stream_name,section.section_name,
        section.class_type,section.class_teacher,section.term_name');
        $this->db->from('tbl_section_info as section');
        $this->db->join('tbl_stream_info as stream', 'stream.row_id = section.stream_id','left');
        // $this->db->join('tbl_staff as staff', 'staff.staff_id = section.class_teacher','left'); 
        if(!empty($filter['by_term'])){
            $this->db->where('section.term_name', $filter['by_term']);
        }
        $this->db->where('section.is_deleted', 0);
        $this->db->where('stream.is_deleted', 0);
        $this->db->group_by('stream.stream_name');
        $query = $this->db->get();
        return $query->result();
    }
}
?>