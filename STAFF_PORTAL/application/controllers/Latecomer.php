<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Latecomer extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
        $this->load->model('user_model');
        $this->load->model('students_model');
        $this->load->model('staff_model');
        $this->load->model('timetable_model');
        $this->load->model('latecomer_model');
        $this->load->model('SMS_model','sms');
        $this->load->model('push_notification_model');
        $this->isLoggedIn();
    }
    public function viewLatecomerInfo()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $filter = array();
            $searchTextCust = $this->security->xss_clean($this->input->post('searchTextCust'));
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $by_date = $this->security->xss_clean($this->input->post('by_date'));
            $student_name = $this->security->xss_clean($this->input->post('student_name'));
            $by_intime = $this->security->xss_clean($this->input->post('by_intime'));

            $section_name = $this->security->xss_clean($this->input->post('section_name'));
            $by_term = $this->security->xss_clean($this->input->post('by_term'));

            $data['searchTextCust'] = $searchTextCust;
            $data['section_name'] = $section_name;
           
            if($by_term == ""){
                $data['by_term'] = 'II PUC';
                $filter['by_term']= 'II PUC';
            }else{
                $data['by_term'] = $by_term;
                $filter['by_term']= $by_term;
            }
            
            $data['student_id'] = $student_id;
            $data['by_date'] = $by_date;
            $data['student_name'] = $student_name;
            $data['by_intime'] = $by_intime;
 
            $filter['searchText'] = $searchTextCust;
            $filter['section_name']= $section_name;
            $filter['student_id']= $student_id;
            if($by_date != ""){
                $filter['by_date']= date("Y-m-d", strtotime($by_date));
            }else{
                $filter['by_date']= '';
            }
            
            $filter['student_name']= $student_name;
            $filter['by_intime']= $by_intime;

            $this->load->library('pagination');
            $count = $this->latecomer_model->getLatecomerInfoCount($filter);
            $returns = $this->paginationCompress("viewLatecomerInfo/", $count, 100);
            $data['lateComerCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['lateComerRecords'] = $this->latecomer_model->getLatecomerInfo($filter);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Latecomer Details';
            $this->loadViews("latecomer/viewLateComer", $this->global, $data, null);
        }
    }

    public function deleteLatecomer()
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $late_id = $this->input->post('row_id');
            $lateInfo = array('is_deleted' => 1);
            $result = $this->latecomer_model->deleteLatecomer($late_id, $lateInfo);

            if ($result > 0) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        }
    }


    public function latecomerInfoDownload(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $date_from = $this->security->xss_clean($this->input->post('date_from'));
            $date_to = $this->security->xss_clean($this->input->post('date_to'));
            $late_count = $this->security->xss_clean($this->input->post('late_count'));
            
           
            $section_obj = $this->students_model->getDistinctSectionNames($term_name);
            //$sections =  (array) $section_obj;

            $sheet = 0;
            foreach($section_obj as $section){
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle($section->section_name);
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');
            //set Title content with some text
            $this->excel->getActiveSheet()->setCellValue('A1', "ST JOSEPH'S PRE-UNIVERSITY COLLEGE HASSAN");
            $this->excel->getActiveSheet()->setCellValue('A2', $term_name.' - '.$section->section_name." SECTION LATECOMER INFO 2019-2020");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:G1');
            $this->excel->getActiveSheet()->mergeCells('A2:G2');
            $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:G2')->getFont()->setBold(true);
           
          
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(11);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(8);
    
            $excel_row=3;
            $cell = 1;
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL No.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Date');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Student ID');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Term');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Section');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'In Time');
          
             $this->excel->getActiveSheet()->getStyle('A3:G3')->getAlignment()->setWrapText(true); 
            $this->excel->getActiveSheet()->getStyle('A3:G3')->getFont()->setBold(true); 
            $this->excel->getActiveSheet()->getStyle('A3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
    
    
            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:G3')->applyFromArray($styleBorderArray);
    
            $students = $this->latecomer_model->getLatecomerInfoForDownload($term_name,$section->section_name,$late_count,$date_from,$date_to);
            $j=1;
            $excel_row = 4;
            
            foreach($students as $student){
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,$student->date);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,$student->student_id);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,$student->student_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,$student->term_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$student->section_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,$student->intime);
                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':G'.$excel_row)->applyFromArray($styleBorderArray);
                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':C'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('E'.$excel_row.':G'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
            }
            $this->excel->createSheet(); 
            $sheet++;
        }
        $filename='just_some_random_name.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        ob_start();
        $objWriter->save("php://output");
        $xlsData = ob_get_contents();
        ob_end_clean();
    
        $response =  array(
            'op' => 'ok',
            'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
        );
        die(json_encode($response));
         
        }
    }

    //getting single student info for tc
    public function getLatecomerByStudentId()
    {
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            // $checkId = substr($student_id, 0, 2);
            // if ($checkId == '19') {
            //     $term_name = 'I PUC';
            // }else{
            //     $term_name = 'II PUC';
            // }
            if($term_name == 'I PUC'){
                $student_id = '22P'.$student_id;
             //   $data['studentsRecords'] = $this->students_model->getStudentInfoByStudentId_IPUC($student_id);
            }else{
                $student_id = '21P'.$student_id;
                
            }
            $data['studentsRecords'] = $this->students_model->getStudentsInfoByStudentID($student_id); 
            $data['in_time'] = date("h:i A");
            $data['in_time_db'] = date("h:i:s");
            $check_in_compare = new DateTime(date("h:i:s"));
            $check_out_compare = new DateTime('8:30:00');
            $late_time_interval = $check_in_compare->diff($check_out_compare);
            $data['late_time'] = $late_time_interval->format('%H').' Hour '.$late_time_interval->format('%I').' Mins';
            $date_from = date('Y-m-01');
            $date_to  = date('Y-m-t');

            $date_from_year = date('2019-06-01');
            $date_to_year  = date('Y-m-d');
            $data['late_count_month'] = $this->latecomer_model->getTotalNumberOfLateComerMonth($student_id,$date_from,$date_to);
            
            $data['late_count_year'] = $this->latecomer_model->getTotalNumberOfLateComerMonth($student_id,$date_from_year,$date_to_year);
            
            header('Content-type: text/plain'); 
            // set json non IE
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        
    }

    public function confirmLatecomerInfo(){
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $in_time = $this->security->xss_clean($this->input->post('in_time'));
            $late_time = $this->security->xss_clean($this->input->post('late_time'));
            $mobile = $this->security->xss_clean($this->input->post('mobile'));
            $name = $this->security->xss_clean($this->input->post('name'));
            $toa = date("h:i A");
            
            
            // $message = "Dear Parents, Your ward $name has reached the SJPUC campus for offline class at $toa Principal - SJPUCB";
            $message = 'Dear Parent, Your ward '.$name.' has reached the SJPUC campus for offline class at '.$toa.'. Principal -SJPUCB';
            $dateToday = date('Y-m-d');
            
            $checkExist = $this->latecomer_model->checkLatecomerExist($student_id,$dateToday);
            if($checkExist == 0){
                $student_info = array(
                    'date' => $dateToday,
                    'student_id' => $student_id,
                    'intime' => $in_time,
                    'sms_status' => 'sent',
                    'created_date_time' => date('Y-m-d H:i:s'),
                );
                $return_id = $this->latecomer_model->addLatecomerStudentInfo($student_info);
                if($return_id > 0){
                    //$status = $this->sendLateSMS($mobile,$message);
                    $smsLog = array(
                        'date_time' => date('Y-m-d H:i:s'),
                        'student_id' => $student_id,
                        'message' => $message,
                        'status' => 0,
                        'sent_by' => $this->staff_id,
                        'sms_count' => 1,
                        'mobile_number' => $mobile
                    );
                    $this->sms->addNewSMS_Log($smsLog);
                    $data['msg'] = "Latecomer added Successfully!";

                    //FCM////////////
                    $all_users_token = $this->push_notification_model->getSingleStudentsToken($student_id);
                    $tokenBatch = array_chunk($all_users_token,500);
                    for($itr = 0; $itr < count($tokenBatch); $itr++){
                        $this->push_notification_model->sendMessage('Late For Class',$message,$tokenBatch[$itr],"student");
                    }
                    //FCM///////////
                }
            }else{
                $data['msg'] = "EXIST";
            }

            header('Content-type: text/plain'); 
            //set json non IE
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        
    }

    // public function sendLateSMS($mobile,$msg){
    //     // $mobile = '9731870624';
       
    //     $message = rawurlencode($msg);  
    //     $data = "username=".USERNAME_TEXTLOCAL."&hash=".HASH_TEXTLOCAL."&message=".$message."&sender=".SENDERID_TEXTLOCAL."&numbers=".$mobile;
    //     $ch = curl_init('https://api.textlocal.in/send/?');
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $result_sms = curl_exec($ch); // This is the result from the API
        
    //     $json = json_decode($result_sms, true);
    //     // log_message('error', 'JSON='.print_r($json,true) );
    //     $status= $json['status'];
       
    //     // log_message('error', 'RESULT API'.$message);
    //     curl_close($ch);
    //     return $status;
    // }

}