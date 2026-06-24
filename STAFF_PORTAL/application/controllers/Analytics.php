<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Analytics extends BaseController {
    public function __construct() {
        parent::__construct();
        $this->load->model('staff_model','staff');
        $this->load->model('studentAttendance_model','attendance');
        $this->load->model('students_model','student');
        $this->load->model('subjects_model','subjects');
        $this->load->model('exam_model','exams');
        $this->load->library('excel');
        $this->isLoggedIn();
    }
 

    public function viewExamAnalyticalBySection(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {

            // $data['staffInfo'] = $this->staff_model->getTeachinStaffInfo();
            $data['streamInfo'] = $this->student->getAllStreamName(); 
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Analytics Section';
            $this->loadViews("analytics/sectionWiseAnalytics", $this->global, $data , NULL);
        } 

    }



    public function getSectionPeformanceAnalytics(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            
            $term_name = $this->input->post("term_name");
            $section_row_id = $this->input->post("section_row_id");
            $exam_type = $this->input->post("exam_type");
            $filter['section_row_id'] = $section_row_id;
            $sectionInfo = $this->attendance->getSectionInfoByRowId($filter);


            $data['term_name'] = $term_name;
            $data['stream_name'] = $sectionInfo->stream_name;
            $data['exam_type'] = $exam_type;
            $data['section_name'] = $sectionInfo->section_name; 
            $data['section_row_id'] = $section_row_id;
            $data['subject'] = $subjectInfo; 

            $section_name = $sectionInfo->section_name;
            // if($sectionName == "ALL"){
            //     $filter['section_name'] = '';
            // }else{
            //     $filter['section_name'] = $sectionName;
            // }
            $filter['stream_name'] = $sectionInfo->stream_name;
            $filter['term_name'] = $term_name;
            $stream_name = $sectionInfo->stream_name;
            
            if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
            }
            $data['streamInfo'] = $this->staff->getSectionById($filter);

            $subjects_code = array();
            $data['studentInfo'] = $this->student->getStudentInfoBySectionTerm($term_name,$section_name);
            // log_message('debug','cdncdj'.print_r($data['studentInfo'],true));
            // $stream = $this->students_model->getStreamNameBySectionAndTerm($term_name,$section_name);

            $sub_code = $this->getSubjectCodes($stream_name);

            array_push($subjects_code, '02');
            $subjects_code = array_merge($subjects_code,$sub_code);
            $data['subjects_code'] = $subjects_code;              
            $data['subInfo'] = $this->subjects->getStudentSubjectInfo($subjects_code);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : View Analytics Section';
            $this->loadViews("analytics/sectionWiseAnalytics", $this->global, $data , NULL);
        }
    }


     public function getSectionPeformanceAnalyticsPdf(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $term_name = $this->input->post("term_name");
            $section_name = $this->input->post("section_name");
            $stream_name = $this->input->post("stream_name");
            $exam_type = $this->input->post("exam_type");
            $subject_code = $this->input->post("subject_code");
            
            $data['term_name'] = $term_name;
            $data['stream_name'] = $stream_name;
            $data['exam_type'] =   $exam_type;
            $data['section_name'] = $section_name; 
            $data['subject'] = $subject_code; 

            $filter['section_name'] = $section_name;
            
            if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
            }
            $data['streamInfo'] = $this->staff->getSectionById($filter);
            $data['subInfo'] = $this->subjects->getSubjectInfo($subject_code);
            if($data['subInfo']->sub_name =='Kannada'){
                $filter['subject_name'] = $data['subInfo']->sub_name;
            }else if($data['subInfo']->sub_name =='Hindi'){
                $filter['subject_name'] = $data['subInfo']->sub_name;
            }else if($data['subInfo']->sub_name =='French'){
                $filter['subject_name'] = $data['subInfo']->sub_name;
            }else{
                $filter['subject_name'] = ""; 
            }
            $subjects_code = array();
            $data['studentInfo'] = $this->student->getStudentInfoForAnalytics($term_name,$stream_name,$filter);

            $this->global['pageTitle'] = ''.TAB_TITLE.' : '.$title;
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman']);
            $mpdf->AddPage('P','','','','',10,10,10,10,8,8);
            $mpdf->SetTitle($title);
            $html = $this->load->view('analytics/subjectwiseWiseAnalytics',$data,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('Analytic_Info.pdf', 'I');
               }
        }

    

    public function getSubjectCodes($stream_name){
        //science
        $PCMB = array("33", "34", "35", '36');
        $PCMC = array("33", "34", "35", '41');
        $PCME = array("33", "34", "35", '40');
        $PCMS = array("33", "34", "35", '31');
        //commarce
        $BEBA = array("75", "22", "27", '30');
        $BSBA = array("75", "31", "27", '30');
        $CSBA = array("41", "31", "27", '30');
        $SEBA = array("31", "22", "27", '30');
        $CEBA = array("41", "22", "27", '30');
        $PEBA = array("29", "22", "27", '30');
        //art
        $HEPP = array("21", "22", "32", '29');
        $MEBA = array("75", "22", "27", '30');
        $MSBA = array("75", "31", "27", '30');
        $HEPS = array("21", "22", "29", '28');

        switch ($stream_name) {
            case "PCMB":
                return  $PCMB;
                break;
            case "PCMC":
                return $PCMC;
                break;
            case "PCME":
                return $PCME;
                break;
            case "PCMS":
                return $PCMS;
                break;
            case "PEBA":
                return $PEBA;
                break;
            case "BEBA":
                return $BEBA;
                break;
            case "BSBA":
                return $BSBA;
                break;
            case "CSBA":
                return $CSBA;
                break;
            case "SEBA":
                return $SEBA;
                break;
            case "CEBA":
                return $CEBA;
                break;
            case "HEPP":
                return $HEPP;
                break;
            case "HEPS":
                return $HEPS;
                break;
            case "MEBA":
                return $MEBA;
                break;
            case "MSBA":
                return $MSBA;
                break;
        }
    }


}