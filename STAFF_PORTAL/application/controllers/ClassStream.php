<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerFaculty.php';

class ClassStream extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('staff_model','staff');
        $this->load->model('settings_model','settings');
        $this->load->model('classStream_model','stream');
        
        $this->isLoggedIn();   
    }

    function classStreamDetails()
    {
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE)
        {
            $this->loadThis();
        } else {
            $filter = array();
            $by_term = $this->security->xss_clean($this->input->post('by_term'));
            $by_stream = $this->security->xss_clean($this->input->post('by_stream'));
            $by_section = $this->security->xss_clean($this->input->post('by_section'));
            $by_class_type = $this->security->xss_clean($this->input->post('by_class_type'));
            $by_class_teacher = $this->security->xss_clean($this->input->post('by_class_teacher'));
            if(!empty($by_term)){
                $filter['by_term'] = $by_term;
                $data['searchTerm'] = $by_term;
            }else{
                $data['searchTerm'] = '';
            }
            if(!empty($by_stream)){
                $filter['by_stream'] = $by_stream;
                $data['searchStream'] = $by_stream;
            }else{
                $data['searchStream'] = '';
            }
            if(!empty($by_section)){
                $filter['by_section'] = $by_section;
                $data['searchSection'] = $by_section;
            }else{
                $data['searchSection'] = '';
            }
            if(!empty($by_class_type)){
                $filter['by_class_type'] = $by_class_type;
                $data['by_class_type'] = $by_class_type;
            }else{
                $data['by_class_type'] = '';
            }
            if(!empty($by_class_teacher)){
                $filter['by_class_teacher'] = $by_class_teacher;
                $data['by_class_teacher'] = $by_class_teacher;
            }else{
                $data['by_class_teacher'] = '';
            }

            $data['staffInfo'] = $this->staff->getAllTeachingStaff();
            $data['streamInfo'] = $this->settings->getStreamInfo();
            $data['sectionInfo'] = $this->settings->getSectionInfo($filter);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Class & Stream Details';
            $this->loadViews("stream/stream", $this->global, $data, NULL);
        }
    }

    
}
?>