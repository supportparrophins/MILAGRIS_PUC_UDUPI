<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Studymaterial extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('student_model');
        $this->load->model('studymaterial_model');
        $this->isLoggedIn();   
    }

    public function viewstudyMaterials(){
        $filter = array();
        $by_name = $this->security->xss_clean($this->input->post('by_name'));
        $by_type = $this->security->xss_clean($this->input->post('by_type'));
        $by_description = $this->security->xss_clean($this->input->post('by_description'));

        if(!empty($by_name)){
            $filter['by_name'] = $by_name;
            $data['searchName'] = $by_name;
        }else{
            $data['searchName'] = '';
        }
        if(!empty($by_type)){
            $filter['by_type'] = $by_type;
            $data['searchType'] = $by_type;
        }else{
            $data['searchType'] = '';
        }
        if(!empty($by_description)){
            $filter['by_description'] = $by_description;
            $data['searchDescription'] = $by_description;
        }else{
            $data['searchDescription'] = '';
        }
        $student = $this->student_model->getStudentInfoById($this->student_id,$this->term_name);
        $filter['term_name'] = $this->term_name;
        $filter['stream_name'] = $student->stream_name;
        $filter['stream_name1'] = 'ALL';
        $this->load->library('pagination');
        $count = $this->studymaterial_model->getStudyMaterialCount($filter);
        $returns = $this->paginationCompress ( "viewstudyMaterials/", $count, 100);
        $filter['page'] = $returns["page"];
        $filter['segment'] = $returns["segment"];
        $data['totalStudyMaterial'] = $count;
        $data['studyMaterialInfo'] = $this->studymaterial_model->getStudyMaterial($filter);
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Study Material' ;
        $this->loadViews("student/studyMaterials", $this->global, $data, NULL);
    }

    public function viewYoutubeVideos(){
        $filter = array();
        $by_name = $this->security->xss_clean($this->input->post('by_name'));
        $by_date = $this->security->xss_clean($this->input->post('by_date'));
        $subject_name = $this->security->xss_clean($this->input->post('subject_name'));

        if(!empty($by_name)){
            $filter['by_name'] = $by_name;
            $data['by_name'] = $by_name;
        }else{
            $data['by_name'] = '';
        }
        if(!empty($by_date)){
            $filter['by_date'] = date('Y-m-d',strtotime($by_date));
            $data['by_date'] = date('d-m-Y',strtotime($by_date));
        }else{
            $data['by_date'] = '';
        }
        if(!empty($subject_name)){
            $filter['subject_name'] = $subject_name;
            $data['subject_name'] = $subject_name;
        }else{
            $data['subject_name'] = '';
        }
        $student = $this->student_model->getStudentInfoById($this->student_id,$this->term_name);
        $filter['term_name'] = $this->term_name;
        $filter['stream_name'] = $student->stream_name;
        $filter['stream_name1'] = 'ALL';

        $this->load->library('pagination');
        $count = $this->studymaterial_model->getYoutubeLinkCount($filter);
        $returns = $this->paginationCompress("viewYoutubeVideos/", $count, 100);
        $filter['page'] = $returns["page"];
        $filter['segment'] = $returns["segment"];
        $data['videoInfo'] = $this->studymaterial_model->getYoutubeLink($filter);

        // $data['videoInfo'] = $this->studymaterial_model->getYoutubeLink($filter);
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Youtube Video' ;
        $this->loadViews("youtube/youtube", $this->global, $data, NULL);
    }
}