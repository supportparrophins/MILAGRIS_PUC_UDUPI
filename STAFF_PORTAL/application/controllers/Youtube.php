<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Youtube extends BaseController
{
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('youtube_model');
        $this->load->model('subjects_model');
        $this->isLoggedIn();   
    }

    public function viewYoutube(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        }else {
            $filter = array();
            $term_name = $this->input->post('term_name');
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
            $video_name = $this->security->xss_clean($this->input->post('video_name'));
            $by_date = $this->security->xss_clean($this->input->post('by_date'));
            $subject_name = $this->security->xss_clean($this->input->post('subject_name'));
    
            $data['subject_name'] = $subject_name;
            $data['term_name'] = $term_name;
            $data['stream_name'] = $stream_name;
            $data['video_name'] = $video_name;
            $data['by_date'] = date('d-m-Y',strtotime($by_date));
    
            $filter['term_name']= $term_name;
            $filter['stream_name']= $stream_name;
            $filter['subject_name']= $subject_name;
            $filter['video_name']= $video_name;
            $filter['by_date']= date('Y-m-d',strtotime($by_date));
            
            if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
            }

            $this->load->library('pagination');
            $count = $this->youtube_model->getAllYoutubeCount($filter);
            $returns = $this->paginationCompress("viewYoutube/", $count, 100);
            $data['videoRecordsCount'] = $count;
            $data['videoInfo'] = $this->youtube_model->getAllYoutubeInfo($filter, $returns["page"], $returns["segment"]);
            $data['subjectInfo'] = $this->subjects_model->getAllSubjectInfo();
            $this->global['pageTitle'] = 'SchoolPhins-AGNES : Youtube';
            $this->loadViews("youtube/youtube", $this->global, $data, null);
        }
    }

    public function addYoutubeToDB(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('term_name','Term Name','trim|required');
            $this->form_validation->set_rules('subject_name','Subject','trim|required');
            //$this->form_validation->set_rules('stream_name','Stream Name','trim|required');
            $this->form_validation->set_rules('video_name','Name','trim|required');
            $this->form_validation->set_rules('link','Link ','trim|required');
            if($this->form_validation->run() == FALSE){
                $this->viewYoutube();
            } else {
                $video_name = $this->security->xss_clean($this->input->post('video_name'));
                $term_name = $this->security->xss_clean($this->input->post('term_name'));
                $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
                $subject_name = $this->security->xss_clean($this->input->post('subject_name'));
                $date = $this->security->xss_clean($this->input->post('date'));
                $section_name = $this->security->xss_clean($this->input->post('section_name'));
                $link =$this->security->xss_clean($this->input->post('link'));
                $description =$this->security->xss_clean($this->input->post('description'));

                for($i=0;$i<count($stream_name);$i++){
                    $streamName = $stream_name[$i];
                    $youtubeInfo= array(
                        'video_name'=>$video_name,
                        'term_name' =>$term_name,
                        'section_name' =>$section_name,
                        'stream_name' => $streamName,
                        'subject_name' =>$subject_name,
                        'date' => date('Y-m-d',strtotime($date)),
                        'link' =>$link,
                        'description' => $description,
                        'created_by' => $this->staff_id,
                        'created_date_time' => date('Y-m-d h:i:s'),
            
                    );
                    $return_id = $this->youtube_model->addYoutube($youtubeInfo);
                }
            
                if($return_id > 0){
                    $this->session->set_flashdata('success', 'New Video Link Added Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Failed to Add New Link');
                }
            }
            redirect('viewYoutube');
            
        }
    }

    public function editYoutube($row_id = null) {
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {
            if($row_id == null) {
                redirect('viewYoutube');
            }
            $data['youtubeInfo'] = $this->youtube_model->getAllYoutubeInfoById($row_id);
            $data['subjectInfo'] = $this->subjects_model->getAllSubjectInfo();
            $this->global['pageTitle'] = 'SchoolPhins-AGNES : Youtube';
            $this->loadViews("youtube/editYoutube", $this->global,$data, NULL);
        }
    }

    public function updateYoutube(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
            $this->form_validation->set_rules('term_name','Term Name','trim|required');
            $this->form_validation->set_rules('subject_name','Subject','trim|required');
            $this->form_validation->set_rules('stream_name','Stream Name','trim|required');
            $this->form_validation->set_rules('video_name','Name','trim|required');
            $this->form_validation->set_rules('link','Link ','required');
           
            if($this->form_validation->run() == FALSE){
                redirect('editYoutube/'.$row_id);  
            } else {
                $video_name =$this->security->xss_clean($this->input->post('video_name'));
                $subject_name=$this->security->xss_clean($this->input->post('subject_name'));
                $term_name =$this->security->xss_clean($this->input->post('term_name'));
                $section_name =$this->security->xss_clean($this->input->post('section_name'));
                $stream_name =$this->security->xss_clean($this->input->post('stream_name'));
                $link =$this->security->xss_clean($this->input->post('link'));
                $description =$this->security->xss_clean($this->input->post('description'));
                $date = $this->input->post('date');
                    
                    $youtubeInfo = array(
                        'video_name'=>$video_name,
                        'term_name' =>$term_name,
                        'section_name' =>$section_name,
                        'stream_name' => $stream_name,
                        'subject_name' =>$subject_name,
                        'date' => date('Y-m-d',strtotime($date)),
                        'link' =>$link,
                        'description' => $description,
                        'updated_by'=>$this->staff_id,
                        'updated_date_time'=>date('Y-m-d H:i:s'));
                $return = $this->youtube_model->updateYoutubeInfo($youtubeInfo,$row_id);
                if($return > 0) {
                    $this->session->set_flashdata('success', 'Youtube Updated Successfully');
                } else {
                    $this->session->set_flashdata('error', 'Youtube Details Update failed');
                }
                redirect('editYoutube/'.$row_id);
            }
        }
    }

    public function deleteYoutube(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $youtubeInfo = array('is_deleted' => 1,'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->youtube_model->updateYoutubeInfo($youtubeInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
}
?>