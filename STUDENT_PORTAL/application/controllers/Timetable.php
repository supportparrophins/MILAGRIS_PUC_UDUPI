<?php if(!defined('BASEPATH')) exit('No direct script access allowed');



require APPPATH . '/libraries/BaseController.php';



class Timetable extends BaseController

{

    /**

     * This is default constructor of the class

     */

    public function __construct()

    {

        parent::__construct();

        $this->load->model('timetable_model');

        $this->isLoggedIn();   

    }



    public function viewTimeTable(){

        $class = $this->timetable_model->getClassById($this->section_name,$this->term_name);

        $data['classTimings'] = $this->timetable_model->getClassTimings();

        // $data['weekname'] = $this->timetable_model->getAllWeekName();

        //  log_message('debug','HII'.print_r($data['classTimings'],true));


        $data['timetableInfo'] = $this->timetable_model->getTimeTableInfoByClassID($class->row_id);

        $data['timingsInfo'] = $this->timetable_model->getClassTimingsforWeekend();
        
       


        //  log_message('debug','DDD'.print_r($data['timetableInfo'],true));

        $this->global['pageTitle'] = ''.TAB_TITLE.' : Time Table' ;

        $this->loadViews("student/timeTable1", $this->global, $data, null);

    }

    // public function viewTimeTable(){

    //     $class = $this->timetable_model->getClassById($this->section_name,$this->term_name);
    //     // $data['classTimings'] = $this->timetable_model->getClassTimings();
    //     // $data['timetableInfo'] = $this->timetable_model->getTimeTableInfoByClassID($class->row_id);




    //     // $data['streamData'] = $this->timetable_model->getAssignedSectionInfo($this->term_name,$this->section_name);
    //     // log_message('debug','streamData'.print_r($data['streamData'],true));
    //     $data['staffInfo'] = $this->timetable_model->getAllSchoolStaffInfo();
    //     // $data['streamInfo'] = $this->time->getDistinctStreamInfo();
    //     $data['allWeekName'] = $this->timetable_model->getAllWeekName();

    //     // if($this->term_name == 'PRE KG' || $this->term_name == 'KG I' || $this->term_name == 'KG II' || $this->term_name == 'I' || $this->term_name == 'II' || $this->term_name == 'III' || $this->term_name == 'IV' || $this->term_name == 'V'){
    //     //     $filter['class_status'] = 1;
    //     //  }else{
    //     //      $filter['class_status'] = 6; 
    //     //  }

    //     $data['classTimingsInfo'] = $this->timetable_model->getClassTimingsforWeekDays1($filter); 
    //     $data['weekName'] = $this->timetable_model->getWeekDayNames();
    //     $data['timingsInfo'] = $this->timetable_model->getClassTimingsforWeekend1($filter); 
    //     $data['weekInfo'] = $this->timetable_model->getWeekendNames();
      
    //     $this->global['pageTitle'] = ''.TAB_TITLE.' : Time Table';
    //     $this->loadViews("student/timeTable1", $this->global, $data, null);
    // }






}



?>