<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerFaculty.php';
// require FCPATH . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;


class Reports extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('staff_model', 'staff');
        $this->load->model('Students_model', 'student');
        $this->load->model('subjects_model', 'subject');
        $this->load->model('settings_model', 'settings');
        $this->load->model('admissionEnquiry_model', 'admission');
        $this->load->model('bankDeposit_model','bank');
        $this->load->model('application_model', 'application');
        $this->load->model('leave_model','leave');
        $this->load->model('salary_model','salary');
        $this->load->model('Mun_model', 'mun');
        $this->load->model('fee_model', 'fee');
        $this->load->model('Scholarship_model','scholarship');
        $this->load->model('transport_model','transport');
        $this->load->model('feedback_model');
        $this->load->model('studentAttendance_model','attendance');
        $this->load->model('Access_model', 'access');
        $this->load->library('excel');
        $this->load->library('pdf');
        $this->isLoggedIn();
    }

    public function reportDashboard()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $filter = array();
            $data['deposittypeInfo'] = $this->bank->getAlldeposittypeInfo();
            $data['depositaccountInfo'] = $this->bank->getAlldepositaccountInfo();
            $data['departments'] = $this->staff->getStaffDepartment();
	        $data['termInfo'] = $this->settings->getTermInfo();
            $data['designation'] = $this->staff->getStaffRoles();
            $data['streamInfo'] = $this->student->getAllStreamName();
            $data['subjectInfo'] = $this->subject->getAllSubjectInfo();
            $data['miscellaneousTypeInfo'] = $this->settings->getAllMiscellaneousTypeInfo();
            $data['currentStaffInfo'] = $this->staff->getAllCurrentStaffInfo();
            $data['examTypeInfo'] = $this->settings->getExamTypeInfo();
            $data['leaveYearInfo'] = $this->leave->getStaffLeaveYearInfo();
            $data['salaryYearInfo'] = $this->salary->getStaffSalaryYearInfo();
            $data['scholarshipTypeInfo'] = $this->scholarship->getAllScholarshipTypeInfo();
            $data['studentYearInfo'] = $this->settings->getStudentYearInfo();
            $data['busNoInfo'] = $this->transport->getTransportBusNo();
            $data['attendanceYearInfo'] = $this->attendance->getAttendanceYearInfo();
            $data['yearInfo'] = $this->settings->getStudentIntakeYearInfo();
            $data['accessModel'] = $this->access;
            $accessInfo = $data['accessInfo'] = $this->getCurrentAccess();
            $this->global['pageTitle'] = '' . TAB_TITLE . ' : Reports';
            $this->loadViews("reports/reports", $this->global, $data, NULL);
        }
    }


    public function downloadAdmissionEnquiryExcelReport()
    {
        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            set_time_limit(0);
            $term_name = $this->security->xss_clean($this->input->post('term_name'));

            $filter = array();
            if ($term_name == 'PU1') {
                $term = 'I PUC';
            } else {
                $term = 'II PUC';
            }
            if (!empty($term_name)) {
                $filter['term_name'] = $term_name;
                $data['term_name'] = $term_name;
            }


            $sheet = 0;
            $j = 1;
            $excel_row = 6;
            $section_name = $sections[$sheet];
            $this->excel->setActiveSheetIndex($sheet);

            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:K500');
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', $term_name . '-' . " Admission Enquiry Report 2021-2022");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->getStyle('A1:A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->mergeCells('A1:K1');
            $this->excel->getActiveSheet()->mergeCells('A2:K2');
            // $this->excel->getActiveSheet()->mergeCells('A3:K3');



            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(28);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(25);


            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL. NO.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Email');

            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Term');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Phone No');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Stream');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Course');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('H3', 'Elective');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('I3', 'Current Institution');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('J3', 'Exam Coaching');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('K3', 'Comment');
            $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->getStyle('A3:K3')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $this->excel->getActiveSheet()->getStyle('A3:K3')->getFont()->setBold(true);


            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:K4')->applyFromArray($styleBorderArray);
            $this->excel->getActiveSheet()->getStyle('A5:K999')->applyFromArray($styleBorderArray);
            $filter['term_name'] = $term_name;
            $students = $this->admission->getAdmissionEnquiryInfoForReportDownload($filter);

            $excel_row = 4;
            foreach ($students as $student) {
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $j++);

                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $student->name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $student->email);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $student->term_name);

                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $student->phone_no);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $student->stream_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $student->program_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $student->elective_sub);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row, $student->current_institution_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J' . $excel_row, $student->exam_coaching);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K' . $excel_row, $student->comment);
                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('E' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('D' . $excel_row . ':H' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
            }

            $this->excel->createSheet();

            $filename = $term_name . '_Admission_Enquiry_Report.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            setcookie('isDownLoaded', 1);
            $objWriter->save("php://output");
        }
    }

    // staff leave Reports
    public function downloadStaffLeaveReport(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
            $date_from = $this->security->xss_clean($this->input->post('from_date'));
            $date_to = $this->security->xss_clean($this->input->post('to_date'));
            $leave_type = $this->security->xss_clean($this->input->post('leave_type'));
            $applied_staff_id = $this->security->xss_clean($this->input->post('applied_staff_id'));
            $leave_status = $this->security->xss_clean($this->input->post('leave_status'));
            $sheet = 0;
          //  log_message('debug','sdjhhw='.$leave_type);
            if($leave_type == 'CL'){
                $leave_type_display = "CASUAL LEAVE";
            } else if($leave_type== 'ML'){
                $leave_type_display = 'MEDICAL LEAVE';
            }else if($leave_type == 'MARL'){
                $leave_type_display = 'MARRIAGE LEAVE';
            }else if($leave_type == 'PL'){
                $leave_type_display = 'PATERNITY LEAVE';
            }else if($leave_type == 'MATL'){
                $leave_type_display = 'MATERNITY LEAVE';
            }else if($leave_type == 'EL'){
                $leave_type_display = 'EARNED LEAVE';
            }else if($leave_type == 'OD'){
                $leave_type_display = 'OFFICIAL DUTY';
            }else if($leave_type == 'LOP'){
                $leave_type_display = 'LOSS OF PAY';
            }else{
                $leave_type_display = 'ALL';
            }
           // foreach($department_list as $dept){
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Leave Info');
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');
            //set Title content with some text
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', "STAFF LEAVE INFORMATION - ".$leave_status);
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:I1');
            $this->excel->getActiveSheet()->mergeCells('A2:I2');
            $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
      
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(28);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
    
            $this->excel->getActiveSheet()->setCellValue('A3', "Date From: ".$date_from." Date To: ".$date_to);
            $this->excel->getActiveSheet()->mergeCells('A3:D3');
            $this->excel->getActiveSheet()->setCellValue('E3', "Leave Type: ".$leave_type_display);
            $this->excel->getActiveSheet()->mergeCells('E3:I3');
            $this->excel->getActiveSheet()->getStyle('E3:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A3:I3')->getFont()->setBold(true);
    
    
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A4', 'SL. NO.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B4', 'Date From');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C4', 'Date To');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D4', 'Staff ID');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E4', 'Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F4', 'Leave Type');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G4', 'Leave Status');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('H4', 'Reason');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('I4', 'Total Days');
           
            
            $this->excel->getActiveSheet()->getStyle('A4:I4')->getAlignment()->setWrapText(true); 
            $this->excel->getActiveSheet()->getStyle('A4:I4')->getFont()->setBold(true); 
            $this->excel->getActiveSheet()->getStyle('A4:I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:I4')->applyFromArray($styleBorderArray);
            $start_date = date('Y-m-d',strtotime($date_from)); 
            $end_date = date('Y-m-d',strtotime($date_to)); 
            $staffInfo = $this->leave->getAllStaffLeaveInfoForReport($start_date, $end_date, $applied_staff_id, $leave_type, $leave_status);
            $j=1;
            $excel_row = 5;
            
            if(!empty($staffInfo)){
                foreach($staffInfo as $staff){
                    $leave_type_text = "";
                    if($staff->leave_type == 'CL'){
                        $leave_type_text = "CASUAL LEAVE";
                    } else if($staff->leave_type == 'ML'){
                        $leave_type_text = 'MEDICAL LEAVE';
                    }else if($staff->leave_type == 'MARL'){
                        $leave_type_text = 'MARRIAGE LEAVE';
                    }else if($staff->leave_type == 'PL'){
                        $leave_type_text = 'PATERNITY LEAVE';
                    }else if($staff->leave_type == 'MATL'){
                        $leave_type_text = 'MATERNITY LEAVE';
                    }else if($staff->leave_type == 'EL'){
                        $leave_type_text = 'EARNED LEAVE';
                    }else if($staff->leave_type == 'OD'){
                        $leave_type_text = 'OFFICIAL DUTY';
                    }else if($staff->leave_type == 'LOP'){
                        $leave_type_text = 'LOSS OF PAY';
                    }

                    if($staff->approved_status == '1'){
                        $leave_status_text = "APPROVED";
                    }else if($staff->approved_status == '2'){
                        $leave_status_text = "REJECTED";
                    }else if($staff->approved_status == '0'){
                        $leave_status_text = "PENDING";
                    }
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,date('d-m-Y',strtotime($staff->date_from)));
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,date('d-m-Y',strtotime($staff->date_to)));
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,$staff->staff_id);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,strtoupper($staff->name));
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$leave_type_text);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,$leave_status_text);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row,$staff->leave_reason);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row,$staff->total_days_leave);
                    $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':I'.$excel_row)->applyFromArray($styleBorderArray);
                    $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':I'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel_row++;
                }
            }
          
            $this->excel->createSheet();
            //}
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

    public function downloadStaffLeavePendingReport(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
            setcookie('isDownloading',0);
        } else {
            $applied_staff_id = $this->security->xss_clean($this->input->post('applied_staff_id'));
            $year = $this->security->xss_clean($this->input->post('year'));
            $sheet = 0;
            
            $this->excel->setActiveSheetIndex($sheet);
            $this->excel->getActiveSheet()->setTitle('Leave');
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:R500');
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', "STAFF LEAVE BALANCE INFORMATION - ".$year);
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:X1');
            $this->excel->getActiveSheet()->mergeCells('A2:X2');
            $this->excel->getActiveSheet()->mergeCells('A3:X3');
            $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:X1')->getFont()->setBold(true);
    
            // Adjusting column widths
            $columns = ['A' => 8, 'B' => 18, 'C' => 30];
            for ($col = 'D'; $col <= 'X'; $col++) {
                $columns[$col] = 12;
            }
            foreach ($columns as $col => $width) {
                $this->excel->getActiveSheet()->getColumnDimension($col)->setWidth($width);
            }
    
            // Merging cells for leave types in the first row (Row 4)
            $this->excel->getActiveSheet()->setCellValue('A4', 'SL. NO.');
            $this->excel->getActiveSheet()->setCellValue('B4', 'Staff ID');
            $this->excel->getActiveSheet()->setCellValue('C4', 'Name');
            $this->excel->getActiveSheet()->mergeCells('D4:F4')->setCellValue('D4', 'Casual Leave');
            $this->excel->getActiveSheet()->mergeCells('G4:I4')->setCellValue('G4', 'Medical Leave');
            $this->excel->getActiveSheet()->mergeCells('J4:L4')->setCellValue('J4', 'Marriage Leave');
            $this->excel->getActiveSheet()->mergeCells('M4:O4')->setCellValue('M4', 'Maternity Leave');
            $this->excel->getActiveSheet()->mergeCells('P4:R4')->setCellValue('P4', 'Paternity Leave');
            $this->excel->getActiveSheet()->mergeCells('S4:U4')->setCellValue('S4', 'Earned Leave');
            $this->excel->getActiveSheet()->mergeCells('V4:X4')->setCellValue('V4', 'Official Duty');
            
            $this->excel->getActiveSheet()->mergeCells('A4:A5');
            $this->excel->getActiveSheet()->mergeCells('B4:B5');
            $this->excel->getActiveSheet()->mergeCells('C4:C5');
    
            // Sub-Headers (Row 5)
            $subHeaders = ['Earned', 'Used', 'Remaining'];
            $columnLetters = ['D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W','X'];
            foreach ($columnLetters as $index => $col) {
                $this->excel->getActiveSheet()->setCellValue($col . '5', $subHeaders[$index % 3]);
            }
    
            // Styling headers
            $this->excel->getActiveSheet()->getStyle('A4:X5')->getAlignment()->setWrapText(true); 
            $this->excel->getActiveSheet()->getStyle('A4:X5')->getFont()->setBold(true); 
            $this->excel->getActiveSheet()->getStyle('A4:X5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:X5')->applyFromArray($styleBorderArray);
    
            $staffInfo = $this->leave->getAllStaffLeavePendingInfoForReport($applied_staff_id, $year);
            $j = 1;
            $excel_row = 6;
    
            if (!empty($staffInfo)) {
                foreach ($staffInfo as $staff) {
                    $used_leave_cl = $this->leave->getLeaveUsedSum($staff->staff_id, 'CL', $year);
                    $used_leave_el = $this->leave->getLeaveUsedSum($staff->staff_id, 'EL', $year);
                    $used_leave_ml = $this->leave->getLeaveUsedSum($staff->staff_id, 'ML', $year);
                    $used_leave_marl = $this->leave->getLeaveUsedSum($staff->staff_id, 'MARL', $year);
                    $used_leave_pl = $this->leave->getLeaveUsedSum($staff->staff_id, 'PL', $year);
                    $used_leave_matl = $this->leave->getLeaveUsedSum($staff->staff_id, 'MATL', $year);
                    $used_leave_lop = $this->leave->getLeaveUsedSum($staff->staff_id, 'LOP', $year);
                    $used_leave_od = $this->leave->getLeaveUsedSum($staff->staff_id, 'OD', $year);
                    $used_leave_wfh = $this->leave->getLeaveUsedSum($staff->staff_id,'WFH', $year);
                    $used_leave_mgml = $this->leave->getLeaveUsedSum($staff->staff_id, 'MGML', $year);
    
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, $j++);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, $staff->staff_id);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, strtoupper($staff->name));
                    
                   // Casual Leave
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, $staff->casual_leave_earned);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, empty($used_leave_cl->total_days_leave) ? 0 : $used_leave_cl->total_days_leave);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, $staff->casual_leave_earned - (empty($used_leave_cl->total_days_leave) ? 0 : $used_leave_cl->total_days_leave));
    
                    // Medical Leave
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, $staff->sick_leave_earned);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, empty($used_leave_ml->total_days_leave) ? 0 : $used_leave_ml->total_days_leave);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row, $staff->sick_leave_earned - (empty($used_leave_ml->total_days_leave) ? 0 : $used_leave_ml->total_days_leave));
    
                    // Marriage Leave
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row, $staff->marriage_leave_earned);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row, empty($used_leave_marl->total_days_leave) ? 0 : $used_leave_marl->total_days_leave);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row, $staff->marriage_leave_earned - (empty($used_leave_marl->total_days_leave) ? 0 : $used_leave_marl->total_days_leave));
    
                    // Maternity Leave
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('M'.$excel_row, $staff->maternity_leave_earned);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('N'.$excel_row, empty($used_leave_matl->total_days_leave) ? 0 : $used_leave_matl->total_days_leave);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('O'.$excel_row, $staff->maternity_leave_earned - (empty($used_leave_matl->total_days_leave) ? 0 : $used_leave_matl->total_days_leave));
    
                    // Paternity Leave
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('P'.$excel_row, $staff->paternity_leave_earned);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('Q'.$excel_row, empty($used_leave_pl->total_days_leave) ? 0 : $used_leave_pl->total_days_leave);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('R'.$excel_row, $staff->paternity_leave_earned - (empty($used_leave_pl->total_days_leave) ? 0 : $used_leave_pl->total_days_leave));
    
                    // earned Leave
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('S'.$excel_row, $staff->earned_leave);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('T'.$excel_row, empty($used_leave_el->total_days_leave) ? 0 : $used_leave_el->total_days_leave);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('U'.$excel_row, $staff->earned_leave - empty($used_leave_el->total_days_leave) ? 0 : $used_leave_el->total_days_leave);
    
                     // Official Duty
                     $this->excel->setActiveSheetIndex($sheet)->setCellValue('V'.$excel_row, $staff->official_duty_earned);
                     $this->excel->setActiveSheetIndex($sheet)->setCellValue('W'.$excel_row, empty($used_leave_od->total_days_leave) ? 0 : $used_leave_od->total_days_leave);
                     $this->excel->setActiveSheetIndex($sheet)->setCellValue('X'.$excel_row, $staff->official_duty_earned - empty($used_leave_od->total_days_leave) ? 0 : $used_leave_od->total_days_leave);
    
                    $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':X'.$excel_row)->applyFromArray($styleBorderArray);
                    $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':X'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('C'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $excel_row++;
                }
            }
    
            $this->excel->createSheet();
            $filename =  'Leave_Pending_Report_file.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
            ob_start();
            setcookie('isDownloading',0);
            $objWriter->save("php://output");
        }
    }


    //download fee structure format
    public function downloadDayWiseFeeReport()
    {
        if ($this->isAdmin() == true) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            $filter['term'] = $this->security->xss_clean($this->input->post('term_select'));
            $filter['stream'] = $this->security->xss_clean($this->input->post('stream_select'));

            $date_from = $this->security->xss_clean($this->input->post('date_from'));
            $date_to = $this->security->xss_clean($this->input->post('date_to'));
            $filter['fee_type'] = $this->security->xss_clean($this->input->post('fee_type_select'));
            $reportFormat = $this->security->xss_clean($this->input->post('reportFormat'));

            if($reportFormat == 'VIEW'){
                $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman']);
                $mpdf->AddPage('L','','','','',10,10,10,10,8,8);
                $mpdf->SetTitle('FEE PAID INFO');
                $data['date_from'] = $date_from;
                $data['date_to'] = $date_to;
                $filter['date_from'] = $date_from;
                $filter['date_to'] = $date_to;
                $feeInfo = $this->fee->getAllFeePaymentInfoForReport($filter);
                $data['feeInfo'] = $feeInfo;
                $html = $this->load->view('reports/feePaidReportView',$data,true);
                $mpdf->WriteHTML($html);
                $mpdf->Output('FeePaidInfo.pdf', 'I');
            }else{
                $spreadsheet = new Spreadsheet();
                $headerFontSize = [
                    'font' => [
                        'size' => 16,
                        'bold' => true,
                    ]
                ];
                $font_style_total = [
                    'font' => [
                        'size' => 12,
                        'bold' => true,
                    ]
                ];
                $filter['term_name'] = $term_name;
                //$streamInfo = $this->staff->getStaffSectionByTerm($filter);

                $spreadsheet->getProperties()
                    ->setCreator("SJPUC")
                    ->setLastModifiedBy($this->staff_id)
                    ->setTitle("SJPUC Fee Info")
                    ->setSubject("Fee Structure")
                    ->setDescription(
                        "SJPUC"
                    )
                    ->setKeywords("SJPUC")
                    ->setCategory("Fee");
                $i = 0;

                $spreadsheet->setActiveSheetIndex(0);
                $spreadsheet->getActiveSheet()->setTitle('FEE');
                $spreadsheet->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                $spreadsheet->getActiveSheet()->mergeCells("A1:L1");
                $spreadsheet->getActiveSheet()->getStyle("A1:A1")->applyFromArray($headerFontSize);

                $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
                $spreadsheet->getActiveSheet()->setCellValue('A2', $term_name . " FEES PAID REPORT - From:" .(date('d-m-Y',strtotime($date_from)) == '01-01-1970' ? '-' : date('d-m-Y',strtotime($date_from)) ). " To:".(date('d-m-Y',strtotime($date_to)) == '01-01-1970' ? '-' : date('d-m-Y',strtotime($date_to))) );
                $spreadsheet->getActiveSheet()->mergeCells("A2:L2");
                $spreadsheet->getActiveSheet()->getStyle("A2:A2")->applyFromArray($headerFontSize);
                $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal('center');

                $spreadsheet->getActiveSheet()->setCellValue('A3', 'SL No');
                $spreadsheet->getActiveSheet()->setCellValue('B3', 'Date');
                $spreadsheet->getActiveSheet()->setCellValue('C3', 'Student ID');
                $spreadsheet->getActiveSheet()->setCellValue('D3', 'Name');
                $spreadsheet->getActiveSheet()->setCellValue('E3', 'Term');
                $spreadsheet->getActiveSheet()->setCellValue('F3', 'Stream');
                $spreadsheet->getActiveSheet()->setCellValue('G3', 'Receipt No.');
                $spreadsheet->getActiveSheet()->setCellValue('H3', 'Fee Type');
                $spreadsheet->getActiveSheet()->setCellValue('I3', 'Fee Paid');
                $spreadsheet->getActiveSheet()->setCellValue('J3', 'Fee Pending');
                $spreadsheet->getActiveSheet()->setCellValue('K3', 'Pay Type');
                $spreadsheet->getActiveSheet()->setCellValue('L3', 'Refund Amt');
                // $spreadsheet->getActiveSheet()->setCellValue('L3', 'Pending');
                $spreadsheet->getActiveSheet()->getStyle("A3:L3")->applyFromArray($font_style_total);
                $spreadsheet->getActiveSheet()->getStyle("A3:L3")->applyFromArray($font_style_total);
                $spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
                $spreadsheet->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
                $spreadsheet->getActiveSheet()->getStyle('I3')->getAlignment()->setWrapText(true);
                // $feeTypeInfo = $this->fee->getAllFeeTypesForByStatus(1);

                $spreadsheet->getActiveSheet()->getStyle('A3:E3')->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => Fill::FILL_SOLID,
                            'color' => array('rgb' => 'E5E4E2')
                        ),
                        'font'  => array(
                            'bold'  =>  true
                        )
                    )
                );


                $spreadsheet->getActiveSheet()->getStyle('A:C')->getAlignment()->setHorizontal('center');
                $spreadsheet->getActiveSheet()->getStyle('E:L')->getAlignment()->setHorizontal('center');
                $excel_row = 4;
                $sl_number = 1;
                $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(10);
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(10);
                $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(10);
                $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(15);
                // $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(15);
                $filter['date_from'] = $date_from;
                $filter['date_to'] = $date_to;
                $filter['preference'] = $preference;
                $filter['term_name'] = $term_name;
                // foreach($feeTypeInfo as $type){
                // if ($term_name == 'I PUC') {
                //     $studentInfo = $this->fee->getAllFeePaymentInfoForReport_I_PUC($filter);
                //     // $total_state_fee_by_type = 0;
                //     // $total_cbse_fee_by_type = 0;
                //     // $total_nri_fee_by_type = 0;
                    
                //     if (!empty($studentInfo)) {
                //         foreach ($studentInfo as $std) {
                //             $frenchFeePaid = $this->fee->getFrenchFeePaidByReceipt($std->row_id);
                //             if($frenchFeePaid == ''){
                //                 $frenchFeePaid = 0;
                //             }
                //             $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                //             $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                //             $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  date('d-m-Y', strtotime($std->payment_date)));
                //             $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  "");
                //             $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->application_number);
                //             $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $std->student_name);
                //             $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $std->stream_name);
                //             $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $std->order_id);
                //             $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $frenchFeePaid);
                //             $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $std->paid_amount);
                //             $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $std->payment_type);
                //             $spreadsheet->getActiveSheet()->setCellValue('K' . $excel_row,  $std->pending_balance);

                //             $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);

                //             $sl_number++;
                //             $excel_row++;
                //         }
                //     }
                // } else {

                    $studentInfo = $this->fee->getAllFeePaymentInfoForReport($filter);
                    // $total_state_fee_by_type = 0;
                    // $total_cbse_fee_by_type = 0;
                    // $total_nri_fee_by_type = 0;
                    if (!empty($studentInfo)) {
                        foreach ($studentInfo as $std) {
                            $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                            $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                            $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  date('d-m-Y', strtotime($std->payment_date)));
                            $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->student_id);
                            $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->student_name);
                            $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $std->term_name);
                            $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $std->stream_name);
                            $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $std->receipt_number);
                            $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $std->fee_type);
                            $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $std->paid_amount);
                            $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $std->pending_balance);
                            $spreadsheet->getActiveSheet()->setCellValue('K' . $excel_row,  $std->payment_type);
                            $spreadsheet->getActiveSheet()->setCellValue('L' . $excel_row,  $std->refund_amt);

                            $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);

                            $sl_number++;
                            $excel_row++;
                        }
                    }
                    $spreadsheet->getActiveSheet()->setCellValue('H'.$excel_row,  "TOTAL");
                    $spreadsheet->getActiveSheet()->setCellValue('I'.$excel_row,"=SUM(I4:I".($excel_row-1).")");
                    // $spreadsheet->getActiveSheet()->setCellValue('J'.$excel_row,"=SUM(J4:J".($excel_row-1).")");
                    $spreadsheet->getActiveSheet()->setCellValue('L'.$excel_row,"=SUM(L4:L".($excel_row-1).")");
                    $spreadsheet->getActiveSheet()->getStyle('H'.$excel_row.':L'.$excel_row)->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => Fill::FILL_SOLID,
                                'color' => array('rgb' => 'E5E4E2')
                            ),
                            'font'  => array(
                                'bold'  =>  true
                            )
                        )
                    );

                // }
                // $excel_row++;

                // //$sl_number++;
                // $excel_row++;
                // }
                // $excel_row++;
                // $spreadsheet->getActiveSheet()->setCellValue('A'.$excel_row,  "");
                // $spreadsheet->getActiveSheet()->setCellValue('B'.$excel_row,  'ALL TOTAL');
                // $spreadsheet->getActiveSheet()->setCellValue('C'.$excel_row,  $total_sslc_state_fee);
                // $spreadsheet->getActiveSheet()->setCellValue('D'.$excel_row,  $total_cbse_icse_fee);
                // $spreadsheet->getActiveSheet()->setCellValue('E'.$excel_row,  $total_nri_fee);

                $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row . ":E" . $excel_row)->applyFromArray($font_style_total);
                $spreadsheet->createSheet();
                $i++;
                // $spreadsheet->getActiveSheet()->getStyle('A1:F'.$excel_row)->applyFromArray($styleBorder);
                //getting optional fee info




                $writer = new Xlsx($spreadsheet);
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="fee_paid_report.xlsx"');
                header('Cache-Control: max-age=0');
                setcookie('isDownLoaded', 1);
                $writer->save("php://output");
            }
        }
    }

    public function downloadDateWiseFeeReport()
    {
        if ($this->isAdmin() == true) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            // $term_name = $filter['term'] = $this->security->xss_clean($this->input->post('term_select'));
            // $filter['stream'] = $this->security->xss_clean($this->input->post('stream_select'));

            $date_from = $this->security->xss_clean($this->input->post('date_from'));
            $date_to = $this->security->xss_clean($this->input->post('date_to'));
            $reportFormat = $this->security->xss_clean($this->input->post('reportFormat'));

            if($reportFormat == 'VIEW'){
                $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman']);
                $mpdf->AddPage('L','','','','',10,10,10,10,8,8);
                $mpdf->SetTitle('FEE PAID INFO');
                $data['date_from'] = $date_from;
                $data['date_to'] = $date_to;
                $filter['date_from'] = $date_from;
                $filter['date_to'] = $date_to;
                // $filter['preference'] = $preference;
                // $filter['term_name'] = $term_name;
                // $data['feeInfo'] = $feeInfo;
                $date['filter'] = $filter;
                $data['feemodel'] = $this->fee;
                $data['studentmodel'] = $this->student;
                $html = $this->load->view('reports/dateWiseFeeReportView',$data,true);
                $mpdf->WriteHTML($html);
                $mpdf->Output('FeePaidInfo.pdf', 'I');
            }else{
                $spreadsheet = new Spreadsheet();
                $headerFontSize = [
                    'font' => [
                        'size' => 16,
                        'bold' => true,
                    ]
                ];
                $font_style_total = [
                    'font' => [
                        'size' => 12,
                        'bold' => true,
                    ]
                ];
                //$streamInfo = $this->staff->getStaffSectionByTerm($filter);

                $spreadsheet->getProperties()
                    ->setCreator("SJPUC")
                    ->setLastModifiedBy($this->staff_id)
                    ->setTitle("SJPUC Fee Info")
                    ->setSubject("Fee Structure")
                    ->setDescription(
                        "SJPUC"
                    )
                    ->setKeywords("SJPUC")
                    ->setCategory("Fee");
                $i = 0;

                $spreadsheet->setActiveSheetIndex(0);
                $spreadsheet->getActiveSheet()->setTitle('FEE');
                $spreadsheet->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                $spreadsheet->getActiveSheet()->mergeCells("A1:L1");
                $spreadsheet->getActiveSheet()->getStyle("A1:A1")->applyFromArray($headerFontSize);

                $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
                $spreadsheet->getActiveSheet()->setCellValue('A2', $term_name . " FEES PAID REPORT - From:" .(date('d-m-Y',strtotime($date_from)) == '01-01-1970' ? '-' : date('d-m-Y',strtotime($date_from)) ). " To:".(date('d-m-Y',strtotime($date_to)) == '01-01-1970' ? '-' : date('d-m-Y',strtotime($date_to))) );
                $spreadsheet->getActiveSheet()->mergeCells("A2:L2");
                $spreadsheet->getActiveSheet()->getStyle("A2:A2")->applyFromArray($headerFontSize);
                $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal('center');

                $spreadsheet->getActiveSheet()->setCellValue('A3', 'SL No');
                $spreadsheet->getActiveSheet()->setCellValue('B3', 'Date');
                $spreadsheet->getActiveSheet()->setCellValue('C3', 'Student ID');
                $spreadsheet->getActiveSheet()->setCellValue('D3', 'Name');
                // $spreadsheet->getActiveSheet()->setCellValue('E3', 'Term');
                // $spreadsheet->getActiveSheet()->setCellValue('F3', 'Stream');
                // $spreadsheet->getActiveSheet()->setCellValue('E3', 'MngtRNo.');
                $spreadsheet->getActiveSheet()->setCellValue('E3', 'Govt Paid');
                // $spreadsheet->getActiveSheet()->setCellValue('G3', 'GovtRNo.');
                $spreadsheet->getActiveSheet()->setCellValue('F3', 'Non Govt Paid');
                // $spreadsheet->getActiveSheet()->setCellValue('I3', 'NonGvtRNo.');
                $spreadsheet->getActiveSheet()->setCellValue('G3', 'Mngt Paid');
                $spreadsheet->getActiveSheet()->setCellValue('H3', 'Total Paid');
                // $spreadsheet->getActiveSheet()->setCellValue('N3', 'Fee Pending');
                $spreadsheet->getActiveSheet()->setCellValue('I3', 'Pay Type');
                $spreadsheet->getActiveSheet()->setCellValue('J3', 'Refund Amt');
                // $spreadsheet->getActiveSheet()->setCellValue('L3', 'Pending');
                $spreadsheet->getActiveSheet()->getStyle("A3:O3")->applyFromArray($font_style_total);
                $spreadsheet->getActiveSheet()->getStyle("A3:O3")->applyFromArray($font_style_total);
                $spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
                $spreadsheet->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
                $spreadsheet->getActiveSheet()->getStyle('I3')->getAlignment()->setWrapText(true);
                // $feeTypeInfo = $this->fee->getAllFeeTypesForByStatus(1);

                $spreadsheet->getActiveSheet()->getStyle('A3:E3')->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => Fill::FILL_SOLID,
                            'color' => array('rgb' => 'E5E4E2')
                        ),
                        'font'  => array(
                            'bold'  =>  true
                        )
                    )
                );


                $spreadsheet->getActiveSheet()->getStyle('A:C')->getAlignment()->setHorizontal('center');
                $spreadsheet->getActiveSheet()->getStyle('E:O')->getAlignment()->setHorizontal('center');
                $excel_row = 4;
                $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(10);
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(12);
                $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(15);
                // $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(15);
                // $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(15);
                // $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(15);
                $filter['date_from'] = $date_from;
                $filter['date_to'] = $date_to;


                //I PUC
                $filter['term'] = "I PUC";
                $streamInfo = $this->student->getAllStreamName();
                foreach($streamInfo as $stream){
                    $sl_number = 1;
                    $lastRow = $excel_row;
                    $filter['stream'] = $stream->stream_name;
                    $feeInfo = $this->fee->getAllFeePaymentInfoForReportGroupBy($filter);
                    if (!empty($feeInfo)) {
                        $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  'I PUC - '.$filter['stream']);
                        $spreadsheet->getActiveSheet()->mergeCells("A".$excel_row.":M".$excel_row);
                        $spreadsheet->getActiveSheet()->getStyle("A".$excel_row.":A".$excel_row)->applyFromArray($headerFontSize);
                        $spreadsheet->getActiveSheet()->getStyle('A'.$excel_row)->getAlignment()->setHorizontal('center');
                        $excel_row++;
                        foreach ($feeInfo as $std) {
                            $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                            $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                            $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  date('d-m-Y', strtotime($std->payment_date)));
                            $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->student_id);
                            $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  strtoupper($std->student_name));
                            // $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $std->term_name);
                            // $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $std->stream_name);
                            $paidInfo = $this->fee->getPaidInfoByType($std->application_no,$std->payment_date,'GOVT');
                            // $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $paidInfo->receipt_number);
                            $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $paidInfo->paid_amount);
                            $paidInfo = $this->fee->getPaidInfoByType($std->application_no,$std->payment_date,'NON-GOVT');
                            // $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $paidInfo->receipt_number);
                            $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paidInfo->paid_amount);
                            $paidInfo = $this->fee->getPaidInfoByType($std->application_no,$std->payment_date,'MANAGEMENT');
                           // $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $paidInfo->receipt_number);
                            $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $paidInfo->paid_amount);
                            $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $std->paid_amount);
                            // $spreadsheet->getActiveSheet()->setCellValue('N' . $excel_row,  $std->pending_balance);
                            $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $std->payment_type);
                            $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $std->refund_amt);

                            $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);

                            $sl_number++;
                            $excel_row++;
                        }
                        $spreadsheet->getActiveSheet()->setCellValue('D'.$excel_row,  "TOTAL");
                        $spreadsheet->getActiveSheet()->setCellValue('E'.$excel_row,"=SUM(E".$lastRow.":E".($excel_row-1).")");
                        $spreadsheet->getActiveSheet()->setCellValue('F'.$excel_row,"=SUM(F".$lastRow.":F".($excel_row-1).")");
                        $spreadsheet->getActiveSheet()->setCellValue('G'.$excel_row,"=SUM(G".$lastRow.":G".($excel_row-1).")");
                        $spreadsheet->getActiveSheet()->setCellValue('H'.$excel_row,"=SUM(H".$lastRow.":H".($excel_row-1).")");
                        $spreadsheet->getActiveSheet()->getStyle('E'.$excel_row.':K'.$excel_row)->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => Fill::FILL_SOLID,
                                    'color' => array('rgb' => 'E5E4E2')
                                ),
                                'font'  => array(
                                    'bold'  =>  true
                                )
                            )
                        );

                        $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row . ":E" . $excel_row)->applyFromArray($font_style_total);
                        $excel_row++;
                    }
                }

                //II PUC
                $filter['term'] = "II PUC";
                $streamInfo = $this->student->getAllStreamName();
                foreach($streamInfo as $stream){
                    $sl_number = 1;
                    $lastRow = $excel_row;
                    $filter['stream'] = $stream->stream_name;
                    $feeInfo = $this->fee->getAllFeePaymentInfoForReportGroupBy($filter);
                    if (!empty($feeInfo)) {
                        $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  'II PUC - '.$filter['stream']);
                        $spreadsheet->getActiveSheet()->mergeCells("A".$excel_row.":M".$excel_row);
                        $spreadsheet->getActiveSheet()->getStyle("A".$excel_row.":A".$excel_row)->applyFromArray($headerFontSize);
                        $spreadsheet->getActiveSheet()->getStyle('A'.$excel_row)->getAlignment()->setHorizontal('center');
                        $excel_row++;
                        foreach ($feeInfo as $std) {
                            $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                            $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                            $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  date('d-m-Y', strtotime($std->payment_date)));
                            $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->student_id);
                            $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  strtoupper($std->student_name));
                            // $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $std->term_name);
                            // $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $std->stream_name);
                            $paidInfo = $this->fee->getPaidInfoByType($std->application_no,$std->payment_date,'GOVT');
                            // $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $paidInfo->receipt_number);
                            $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $paidInfo->paid_amount);
                            $paidInfo = $this->fee->getPaidInfoByType($std->application_no,$std->payment_date,'NON-GOVT');
                            // $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $paidInfo->receipt_number);
                            $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paidInfo->paid_amount);
                            $paidInfo = $this->fee->getPaidInfoByType($std->application_no,$std->payment_date,'MANAGEMENT');
                            // $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $paidInfo->receipt_number);
                            $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $paidInfo->paid_amount);
                            $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $std->paid_amount);
                            // $spreadsheet->getActiveSheet()->setCellValue('N' . $excel_row,  $std->pending_balance);
                            $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $std->payment_type);
                            $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $std->refund_amt);

                            $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);

                            $sl_number++;
                            $excel_row++;
                        }
                        $spreadsheet->getActiveSheet()->setCellValue('D'.$excel_row,  "TOTAL");
                        $spreadsheet->getActiveSheet()->setCellValue('E'.$excel_row,"=SUM(E".$lastRow.":E".($excel_row-1).")");
                        $spreadsheet->getActiveSheet()->setCellValue('F'.$excel_row,"=SUM(F".$lastRow.":F".($excel_row-1).")");
                        $spreadsheet->getActiveSheet()->setCellValue('G'.$excel_row,"=SUM(G".$lastRow.":G".($excel_row-1).")");
                        $spreadsheet->getActiveSheet()->setCellValue('H'.$excel_row,"=SUM(H".$lastRow.":H".($excel_row-1).")");
                        $spreadsheet->getActiveSheet()->getStyle('E'.$excel_row.':K'.$excel_row)->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => Fill::FILL_SOLID,
                                    'color' => array('rgb' => 'E5E4E2')
                                ),
                                'font'  => array(
                                    'bold'  =>  true
                                )
                            )
                        );

                        $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row . ":E" . $excel_row)->applyFromArray($font_style_total);
                        $excel_row++;
                    }
                }

                $grandTotalRow = $excel_row + 1;
                $lastTermTotalRow = 0; // Variable to store the last row of each term's total
                
                // Calculate the grand total for each column
                $spreadsheet->getActiveSheet()->setCellValue('D' . $grandTotalRow, 'GRAND TOTAL');
                $spreadsheet->getActiveSheet()->setCellValue('E' . $grandTotalRow, "=SUMIF(A4:A" . ($excel_row - 1) . ", \"<>\", E4:E" . ($excel_row - 1) . ")");
                $spreadsheet->getActiveSheet()->setCellValue('F' . $grandTotalRow, "=SUMIF(A4:A" . ($excel_row - 1) . ", \"<>\", F4:F" . ($excel_row - 1) . ")");
                $spreadsheet->getActiveSheet()->setCellValue('G' . $grandTotalRow, "=SUMIF(A4:A" . ($excel_row - 1) . ", \"<>\", G4:G" . ($excel_row - 1) . ")");
                $spreadsheet->getActiveSheet()->setCellValue('H' . $grandTotalRow, "=SUMIF(A4:A" . ($excel_row - 1) . ", \"<>\", H4:H" . ($excel_row - 1) . ")");
              
                
                // Apply formatting to the grand total row
                $spreadsheet->getActiveSheet()->getStyle('D' . $grandTotalRow . ':J' . $grandTotalRow)->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => Fill::FILL_SOLID,
                            'color' => array('rgb' => 'E5E4E2')
                        ),
                        'font' => array(
                            'bold' => true
                        )
                    )
                );
                
                // Increase the row number for the next section
                $excel_row++;
                
                // Store the last row of each term's total
                $lastTermTotalRow = $excel_row;
                

                    $spreadsheet->createSheet();
                    $i++;
                    $writer = new Xlsx($spreadsheet);
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename="fee_paid_report.xlsx"');
                    header('Cache-Control: max-age=0');
                    setcookie('isDownLoaded', 1);
                    $writer->save("php://output");
            }
        }
    }

    public function downloadByDateReport()
    {
        if ($this->isAdmin() == true) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            // $term_name = $filter['term'] = $this->security->xss_clean($this->input->post('term_select'));
            // $filter['stream'] = $this->security->xss_clean($this->input->post('stream_select'));

            $date_from = $this->security->xss_clean($this->input->post('date_from'));
            $date_to = $this->security->xss_clean($this->input->post('date_to'));
            $reportFormat = $this->security->xss_clean($this->input->post('reportFormat'));

            if($reportFormat == 'VIEW'){
                $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman']);
                $mpdf->AddPage('L','','','','',10,10,10,10,8,8);
                $mpdf->SetTitle('FEE PAID DATEWISE INFO');
                $data['date_from'] = date('Y-m-d',strtotime($date_from));
                $data['date_to'] = date('Y-m-d',strtotime($date_to));
                if(!empty($date_from)){
                    $date_from = date('Y-m-d',strtotime($date_from));
                }
                if(!empty($date_to)){
                    $date_to = date('Y-m-d',strtotime($date_to));
                }
                $interval = new DateInterval('P1D');
                $realEnd = new DateTime($date_to);
                $realEnd->add($interval);
                $data['date_range'] = new DatePeriod(date_create($date_from), $interval, $realEnd);
                $data['feemodel'] = $this->fee;
                $html = $this->load->view('reports/byDateReportView',$data,true);
                $mpdf->WriteHTML($html);
                $mpdf->Output('FeePaidDateWiseInfo.pdf', 'I');
            }else{
                $spreadsheet = new Spreadsheet();
                $headerFontSize = [
                    'font' => [
                        'size' => 16,
                        'bold' => true,
                    ]
                ];
                $font_style_total = [
                    'font' => [
                        'size' => 12,
                        'bold' => true,
                    ]
                ];
                //$streamInfo = $this->staff->getStaffSectionByTerm($filter);

                $spreadsheet->getProperties()
                    ->setCreator("SJPUC")
                    ->setLastModifiedBy($this->staff_id)
                    ->setTitle("SJPUC Fee Info")
                    ->setSubject("Fee Structure")
                    ->setDescription(
                        "SJPUC"
                    )
                    ->setKeywords("SJPUC")
                    ->setCategory("Fee");
                $i = 0;

                $spreadsheet->setActiveSheetIndex(0);
                $spreadsheet->getActiveSheet()->setTitle('FEE');
                $spreadsheet->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                $spreadsheet->getActiveSheet()->mergeCells("A1:E1");
                $spreadsheet->getActiveSheet()->getStyle("A1:E1")->applyFromArray($headerFontSize);

                $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
                $spreadsheet->getActiveSheet()->setCellValue('A2', $term_name . " FEES PAID DATEWISE REPORT - From:" .(date('d-m-Y',strtotime($date_from)) == '01-01-1970' ? '-' : date('d-m-Y',strtotime($date_from)) ). " To:".(date('d-m-Y',strtotime($date_to)) == '01-01-1970' ? '-' : date('d-m-Y',strtotime($date_to))) );
                $spreadsheet->getActiveSheet()->mergeCells("A2:E2");
                $spreadsheet->getActiveSheet()->getStyle("A2:A2")->applyFromArray($headerFontSize);
                $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal('center');

                $spreadsheet->getActiveSheet()->setCellValue('A3', 'Date');
                $spreadsheet->getActiveSheet()->setCellValue('B3', 'Government Fee Paid');
                $spreadsheet->getActiveSheet()->setCellValue('C3', 'Non-Government Fee Paid');
                $spreadsheet->getActiveSheet()->setCellValue('D3', 'Management Fee Paid');
                $spreadsheet->getActiveSheet()->setCellValue('E3', 'Total Paid');
                $spreadsheet->getActiveSheet()->getStyle("A3:E3")->applyFromArray($font_style_total);
                $spreadsheet->getActiveSheet()->getStyle("A3:E3")->applyFromArray($font_style_total);
                $spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
                $spreadsheet->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
                $spreadsheet->getActiveSheet()->getStyle('E3')->getAlignment()->setWrapText(true);
                // $feeTypeInfo = $this->fee->getAllFeeTypesForByStatus(1);

                $spreadsheet->getActiveSheet()->getStyle('A3:E3')->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => Fill::FILL_SOLID,
                            'color' => array('rgb' => 'E5E4E2')
                        ),
                        'font'  => array(
                            'bold'  =>  true
                        )
                    )
                );


                $spreadsheet->getActiveSheet()->getStyle('A:E')->getAlignment()->setHorizontal('center');
                $excel_row = 4;
                $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
                $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(25);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(25);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(25);
                $filter['date_from'] = $date_from;
                $filter['date_to'] = $date_to;

                if(!empty($date_from)){
                    $date_from = date('Y-m-d',strtotime($date_from));
                }
                if(!empty($date_to)){
                    $date_to = date('Y-m-d',strtotime($date_to));
                }
                $interval = new DateInterval('P1D');
                
                $realEnd = new DateTime($date_to);
                $realEnd->add($interval);
                $date_range = new DatePeriod(date_create($date_from), $interval, $realEnd);
                foreach ($date_range as $date) {
                    $totalSum = $this->fee->getSumOfFeeByDate($date->format('Y-m-d'));
                    if($totalSum > 0){
                            $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row, $date->format('d-m-Y'));
                            $paid_amount = $this->fee->getSumOfFeeByDateType($date->format('Y-m-d'),'GOVT');
                            $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $paid_amount);
                            $paid_amount = $this->fee->getSumOfFeeByDateType($date->format('Y-m-d'),'NON-GOVT');
                            $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $paid_amount);
                            $paid_amount = $this->fee->getSumOfFeeByDateType($date->format('Y-m-d'),'MANAGEMENT');
                            $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $paid_amount);
                            $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $totalSum);

                            $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);                        
                        // $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row . ":E" . $excel_row)->applyFromArray($font_style_total);
                        $excel_row++;
                    }

                }
                $spreadsheet->getActiveSheet()->setCellValue('A'.$excel_row,  "TOTAL");
                        $spreadsheet->getActiveSheet()->setCellValue('B'.$excel_row,"=SUM(B4:B".($excel_row-1).")");
                        $spreadsheet->getActiveSheet()->setCellValue('C'.$excel_row,"=SUM(C4:C".($excel_row-1).")");
                        $spreadsheet->getActiveSheet()->setCellValue('D'.$excel_row,"=SUM(D4:D".($excel_row-1).")");
                        $spreadsheet->getActiveSheet()->setCellValue('E'.$excel_row,"=SUM(E4:E".($excel_row-1).")");
                        $spreadsheet->getActiveSheet()->getStyle('A'.$excel_row.':E'.$excel_row)->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => Fill::FILL_SOLID,
                                    'color' => array('rgb' => 'E5E4E2')
                                ),
                                'font'  => array(
                                    'bold'  =>  true
                                )
                            )
                        );
                    $spreadsheet->createSheet();
                    $i++;
                    $writer = new Xlsx($spreadsheet);
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename="fee_paid_report.xlsx"');
                    header('Cache-Control: max-age=0');
                    setcookie('isDownLoaded', 1);
                    $writer->save("php://output");
            }
        }
    }

    public function downloadBriefFeeReport()
    {
        if ($this->isAdmin() == true) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            $filter['term'] = $this->security->xss_clean($this->input->post('term_select'));
            $filter['stream'] = $this->security->xss_clean($this->input->post('stream_select'));

            $date_from = $this->security->xss_clean($this->input->post('date_from'));
            $date_to = $this->security->xss_clean($this->input->post('date_to'));
            $filter['fee_type'] = $this->security->xss_clean($this->input->post('fee_type_select'));
            $reportFormat = $this->security->xss_clean($this->input->post('reportFormat'));

            if($reportFormat == 'VIEW'){
                $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman']);
                $mpdf->AddPage('P','','','','',10,10,10,10,8,8);
                $mpdf->SetTitle('FEE PAID INFO');
                $data['date_from'] = $date_from;
                $data['date_to'] = $date_to;
            
                $date['filter'] = $filter;
                $data['feemodel'] = $this->fee;
                $data['streamInfo'] = $this->student->getAllStreamName();
                $html = $this->load->view('reports/briefFeeReportView',$data,true);
                $mpdf->WriteHTML($html);
                $mpdf->Output('FeePaidBriefInfo.pdf', 'I');
            }else{
                $spreadsheet = new Spreadsheet();
                $headerFontSize = [
                    'font' => [
                        'size' => 16,
                        'bold' => true,
                    ]
                ];
                $font_style_total = [
                    'font' => [
                        'size' => 12,
                        'bold' => true,
                    ]
                ];
                $filter['term_name'] = $term_name;
                //$streamInfo = $this->staff->getStaffSectionByTerm($filter);

                $spreadsheet->getProperties()
                    ->setCreator("SJPUC")
                    ->setLastModifiedBy($this->staff_id)
                    ->setTitle("SJPUC Fee Info")
                    ->setSubject("Fee Structure")
                    ->setDescription(
                        "SJPUC"
                    )
                    ->setKeywords("SJPUC")
                    ->setCategory("Fee");
                $i = 0;

                $spreadsheet->setActiveSheetIndex(0);
                $spreadsheet->getActiveSheet()->setTitle('FEE');
                $spreadsheet->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                $spreadsheet->getActiveSheet()->mergeCells("A1:F1");
                $spreadsheet->getActiveSheet()->getStyle("A1:A1")->applyFromArray($headerFontSize);

                $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
                $spreadsheet->getActiveSheet()->setCellValue('A2', $term_name . " FEES PAID REPORT - From:" .(date('d-m-Y',strtotime($date_from)) == '01-01-1970' ? '-' : date('d-m-Y',strtotime($date_from)) ). " To:".(date('d-m-Y',strtotime($date_to)) == '01-01-1970' ? '-' : date('d-m-Y',strtotime($date_to))) );
                $spreadsheet->getActiveSheet()->mergeCells("A2:F2");
                $spreadsheet->getActiveSheet()->getStyle("A2:A2")->applyFromArray($headerFontSize);
                $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal('center');

                $spreadsheet->getActiveSheet()->setCellValue('A3', 'Term');
                $spreadsheet->getActiveSheet()->setCellValue('B3', 'Stream');
                $spreadsheet->getActiveSheet()->setCellValue('C3', 'Govt Fee');
                $spreadsheet->getActiveSheet()->setCellValue('D3', 'Non Govt Fee');
                $spreadsheet->getActiveSheet()->setCellValue('E3', 'Managment Fee');
                $spreadsheet->getActiveSheet()->setCellValue('F3', 'Total Fee');
                // $spreadsheet->getActiveSheet()->setCellValue('L3', 'Pending');
                $spreadsheet->getActiveSheet()->getStyle("A3:F3")->applyFromArray($font_style_total);
                $spreadsheet->getActiveSheet()->getStyle("A3:F3")->applyFromArray($font_style_total);
                $spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
                $spreadsheet->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
                $spreadsheet->getActiveSheet()->getStyle('E3')->getAlignment()->setWrapText(true);
                // $feeTypeInfo = $this->fee->getAllFeeTypesForByStatus(1);

                $spreadsheet->getActiveSheet()->getStyle('A3:E3')->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => Fill::FILL_SOLID,
                            'color' => array('rgb' => 'E5E4E2')
                        ),
                        'font'  => array(
                            'bold'  =>  true
                        )
                    )
                );


                $spreadsheet->getActiveSheet()->getStyle('A:C')->getAlignment()->setHorizontal('center');
                $spreadsheet->getActiveSheet()->getStyle('E:F')->getAlignment()->setHorizontal('center');
                $excel_row = 4;
                $sl_number = 1;
                $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                $filter['date_from'] = $date_from;
                $filter['date_to'] = $date_to;
                $govt_total = $nongovt_fee_total = $management_fee_total = $total_sum = 0;
                //I PUC
                $filter['term'] = "I PUC";
                $streamInfo = $this->student->getAllStreamName();
                foreach($streamInfo as $stream){
                    $filter['stream'] = $stream->stream_name;
                    $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  'I PUC');
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $filter['stream']);
                    $filter['fee_type'] = 'GOVT';
                    $govt =$this->fee->getFeePaymentInfoForBriefReport($filter);
                    $govt_total += $govt; 
                    $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $govt);
                    $filter['fee_type'] = 'NON-GOVT';
                    $nongovt_fee =$this->fee->getFeePaymentInfoForBriefReport($filter);
                    $nongovt_fee_total += $nongovt_fee;
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $nongovt_fee);
                    $filter['fee_type'] = 'MANAGEMENT';
                    $management_fee =$this->fee->getFeePaymentInfoForBriefReport($filter);
                    $management_fee_total += $management_fee; 
                    $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $management_fee);
                    $total_sum += $management_fee + $govt + $nongovt_fee;
                    $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $management_fee + $govt +$nongovt_fee);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
                    $sl_number++;
                    $excel_row++;
                    
                }
                $spreadsheet->getActiveSheet()->setCellValue('B'.$excel_row,  "TOTAL");
                $spreadsheet->getActiveSheet()->setCellValue('C'.$excel_row,"=SUM(C4:C".($excel_row-1).")");
                $spreadsheet->getActiveSheet()->setCellValue('D'.$excel_row,"=SUM(D4:D".($excel_row-1).")");
                $spreadsheet->getActiveSheet()->setCellValue('E'.$excel_row,"=SUM(E4:E".($excel_row-1).")");
                $spreadsheet->getActiveSheet()->setCellValue('F'.$excel_row,"=SUM(F4:F".($excel_row-1).")");
                $spreadsheet->getActiveSheet()->getStyle('B'.$excel_row.':F'.$excel_row)->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => Fill::FILL_SOLID,
                                'color' => array('rgb' => 'E5E4E2')
                            ),
                            'font'  => array(
                                'bold'  =>  true
                            )
                        )
                    );
                $excel_row++;  
                $excel_row++;    

                //II PUC
                $filter['term'] = "II PUC";
                $streamInfo = $this->student->getAllStreamName();
                foreach($streamInfo as $stream){
                    $filter['stream'] = $stream->stream_name;
                    $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  'II PUC');
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $filter['stream']);
                    $filter['fee_type'] = 'GOVT';
                    $govt =$this->fee->getFeePaymentInfoForBriefReport($filter);
                    $govt_total += $govt; 
                    $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $govt);
                    $filter['fee_type'] = 'NON-GOVT';
                    $nongovt_fee =$this->fee->getFeePaymentInfoForBriefReport($filter);
                    $nongovt_fee_total += $nongovt_fee;
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $nongovt_fee);
                    $filter['fee_type'] = 'MANAGEMENT';
                    $management_fee =$this->fee->getFeePaymentInfoForBriefReport($filter);
                    $management_fee_total += $management_fee; 
                    $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $management_fee);
                    $total_sum += $management_fee + $govt + $nongovt_fee;
                    $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $management_fee + $govt +$nongovt_fee);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
                    $sl_number++;
                    $excel_row++;
                    
                }

                $spreadsheet->getActiveSheet()->setCellValue('B'.$excel_row,  "TOTAL");
                $spreadsheet->getActiveSheet()->setCellValue('C'.$excel_row,"=SUM(C11:C".($excel_row-1).")");
                $spreadsheet->getActiveSheet()->setCellValue('D'.$excel_row,"=SUM(D11:D".($excel_row-1).")");
                $spreadsheet->getActiveSheet()->setCellValue('E'.$excel_row,"=SUM(E11:E".($excel_row-1).")");
                $spreadsheet->getActiveSheet()->setCellValue('F'.$excel_row,"=SUM(F11:F".($excel_row-1).")");
                $spreadsheet->getActiveSheet()->getStyle('B'.$excel_row.':F'.$excel_row)->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => Fill::FILL_SOLID,
                                'color' => array('rgb' => 'E5E4E2')
                            ),
                            'font'  => array(
                                'bold'  =>  true
                            )
                        )
                    );
                $excel_row++;  
                $excel_row++;


                $spreadsheet->getActiveSheet()->setCellValue('B'.$excel_row,  "GRAND TOTAL");
                $spreadsheet->getActiveSheet()->setCellValue('C'.$excel_row,$govt_total);
                $spreadsheet->getActiveSheet()->setCellValue('D'.$excel_row,$nongovt_fee_total);
                $spreadsheet->getActiveSheet()->setCellValue('E'.$excel_row,$management_fee_total);
                $spreadsheet->getActiveSheet()->setCellValue('F'.$excel_row,$total_sum);
                $spreadsheet->getActiveSheet()->getStyle('B'.$excel_row.':F'.$excel_row)->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => Fill::FILL_SOLID,
                                'color' => array('rgb' => 'E5E4E2')
                            ),
                            'font'  => array(
                                'bold'  =>  true
                            )
                        )
                    );
                $excel_row++;  
                $excel_row++;
                    
                $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row . ":E" . $excel_row)->applyFromArray($font_style_total);
                $spreadsheet->createSheet();
                $i++;
                // $spreadsheet->getActiveSheet()->getStyle('A1:F'.$excel_row)->applyFromArray($styleBorder);
                //getting optional fee info




                $writer = new Xlsx($spreadsheet);
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="fee_paid_brief_report.xlsx"');
                header('Cache-Control: max-age=0');
                setcookie('isDownLoaded', 1);
                $writer->save("php://output");
            }
        }
    }

    //download fee structure format
    public function downloadFeePendingReport()
    {
        if ($this->isAdmin() == true) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            // $filter['term'] = $this->security->xss_clean($this->input->post('term_select'));
            // $filter['preference'] = $this->security->xss_clean($this->input->post('stream_select'));

            // $date_from = $this->security->xss_clean($this->input->post('date_from'));
            // $date_to = $this->security->xss_clean($this->input->post('date_to'));
            // $filter['fee_type'] = $this->security->xss_clean($this->input->post('fee_type_select'));
            $year = $this->security->xss_clean($this->input->post('year'));
            $type = $this->security->xss_clean($this->input->post('type'));
            $reportFormat = $this->security->xss_clean($this->input->post('reportFormat'));

            if($reportFormat == 'VIEW'){
                $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman']);
                $mpdf->AddPage('L','','','','',10,10,10,10,8,8);
                $mpdf->SetTitle('FEE PAID INFO');
                // $data['date_from'] = $date_from;
                // $data['date_to'] = $date_to;
                // $filter['date_from'] = $date_from;
                // $filter['date_to'] = $date_to;
                $data['type'] = $type;
                $data['year'] = $year;
                $data['studentmodel'] = $this->student;
                $data['feemodel'] = $this->fee;
                $data['streamInfo'] = $this->student->getAllStreamName();
                $html = $this->load->view('reports/feePendingReportView',$data,true);
                $mpdf->WriteHTML($html);
                $mpdf->Output('FeePaidInfo.pdf', 'I');
            }else{
                $spreadsheet = new Spreadsheet();
                $headerFontSize = [
                    'font' => [
                        'size' => 16,
                        'bold' => true,
                    ]
                ];
                $font_style_total = [
                    'font' => [
                        'size' => 12,
                        'bold' => true,
                    ]
                ];
                $filter['term_name'] = $term_name;
                //$streamInfo = $this->staff->getStaffSectionByTerm($filter);

                $spreadsheet->getProperties()
                    ->setCreator("SJPUC")
                    ->setLastModifiedBy($this->staff_id)
                    ->setTitle("SJPUC Fee Info")
                    ->setSubject("Fee Structure")
                    ->setDescription(
                        "SJPUC"
                    )
                    ->setKeywords("SJPUC")
                    ->setCategory("Fee");
                $i = 0;

                $spreadsheet->setActiveSheetIndex(0);
                $spreadsheet->getActiveSheet()->setTitle('FEE');
                $spreadsheet->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                $spreadsheet->getActiveSheet()->mergeCells("A1:F1");
                $spreadsheet->getActiveSheet()->getStyle("A1:A1")->applyFromArray($headerFontSize);

                $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
                $spreadsheet->getActiveSheet()->setCellValue('A2'," FEES ".$type." REPORT ");
                $spreadsheet->getActiveSheet()->mergeCells("A2:F2");
                $spreadsheet->getActiveSheet()->getStyle("A2:A2")->applyFromArray($headerFontSize);
                $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal('center');

                $spreadsheet->getActiveSheet()->setCellValue('A3', 'SL No');
                $spreadsheet->getActiveSheet()->setCellValue('B3', 'Student ID');
                $spreadsheet->getActiveSheet()->setCellValue('C3', 'Name');
                $spreadsheet->getActiveSheet()->setCellValue('D3', 'Total Fee');
                $spreadsheet->getActiveSheet()->setCellValue('E3', 'Fee Paid');
                $spreadsheet->getActiveSheet()->setCellValue('F3', 'Fee Pending');
                $spreadsheet->getActiveSheet()->getStyle("A3:F3")->applyFromArray($font_style_total);
                $spreadsheet->getActiveSheet()->getStyle("A3:F3")->applyFromArray($font_style_total);
                $spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
                $spreadsheet->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
                $spreadsheet->getActiveSheet()->getStyle('F3')->getAlignment()->setWrapText(true);
                // $feeTypeInfo = $this->fee->getAllFeeTypesForByStatus(1);

                $spreadsheet->getActiveSheet()->getStyle('A3:E3')->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => Fill::FILL_SOLID,
                            'color' => array('rgb' => 'E5E4E2')
                        ),
                        'font'  => array(
                            'bold'  =>  true
                        )
                    )
                );


                $spreadsheet->getActiveSheet()->getStyle('A:B')->getAlignment()->setHorizontal('center');
                $spreadsheet->getActiveSheet()->getStyle('D:F')->getAlignment()->setHorizontal('center');
                $excel_row = 4;
                // $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
                $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $filter['term'] = 'I PUC';
                $filter['term_name'] = 'I PUC';
                $filter['fee_year'] = $year;
                $streamInfo = $this->student->getAllStreamName();
                foreach($streamInfo as $stream){
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row, $filter['term'].'-'.$stream->stream_name);
                    $spreadsheet->getActiveSheet()->mergeCells("A".$excel_row.":F".$excel_row);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$excel_row)->applyFromArray($headerFontSize);
                    $excel_row++;
                    $lastRow = $excel_row;
                    $sl_number = 1;
                    $filter['stream_name'] = $filter['preference'] = $stream->stream_name;
                    $total_fee_obj = $this->fee->getTotalFeeAmount($filter);
                    $total_amount = $total_fee_obj->total_fee;
                    $studentInfo = $this->student->getStudentInfoForReportDownload($filter);
                    if (!empty($studentInfo)) {
                        foreach ($studentInfo as $std) {
                            $total_amount -= $this->fee->getFeeConcessionByAppNo($std->row_id,$filter['term_name']);
                            $total_paid = $this->fee->getTotalFeePaidInfo($std->row_id,$year);
                            $pending = $total_amount - $total_paid;
                            if($type == 'PENDING' && $pending > 0){
                                $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                                $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->student_id);
                                $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
                                $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $total_amount);
                                $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_paid);
                                $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $pending);
                                $sl_number++;
                                $excel_row++;
                            }else if($type == 'PAID' && $pending <= 0){
                                $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                                $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->student_id);
                                $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
                                $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $total_amount);
                                $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_paid);
                                $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $pending);
                                $sl_number++;
                                $excel_row++;
                            }
                            $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
                        }
                    }
                    $spreadsheet->getActiveSheet()->setCellValue('C'.$excel_row,  "TOTAL");
                    $spreadsheet->getActiveSheet()->setCellValue('D'.$excel_row,"=SUM(D".$lastRow.":D".($excel_row-1).")");
                    $spreadsheet->getActiveSheet()->setCellValue('E'.$excel_row,"=SUM(E".$lastRow.":E".($excel_row-1).")");
                    $spreadsheet->getActiveSheet()->setCellValue('F'.$excel_row,"=SUM(F".$lastRow.":F".($excel_row-1).")");
                    $spreadsheet->getActiveSheet()->getStyle('A'.$excel_row.':F'.$excel_row)->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => Fill::FILL_SOLID,
                                'color' => array('rgb' => 'E5E4E2')
                            ),
                            'font'  => array(
                                'bold'  =>  true
                            )
                        )
                    );
                    $excel_row++;
                }

                $filter['term'] = 'II PUC';
                $filter['term_name'] = 'II PUC';
                $filter['fee_year'] = $year;
                $streamInfo = $this->student->getAllStreamName();
                foreach($streamInfo as $stream){
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row, $filter['term'].'-'.$stream->stream_name);
                    $spreadsheet->getActiveSheet()->mergeCells("A".$excel_row.":F".$excel_row);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$excel_row)->applyFromArray($headerFontSize);
                    $excel_row++;
                    $lastRow = $excel_row;
                    $sl_number = 1;
                    $filter['stream_name'] = $filter['preference'] = $stream->stream_name;
                    $total_fee_obj = $this->fee->getTotalFeeAmount($filter);
                    $total_amount = $total_fee_obj->total_fee;
                    $studentInfo = $this->student->getStudentInfoForReportDownload($filter);
                    if (!empty($studentInfo)) {
                        foreach ($studentInfo as $std) {
                            $total_amount -= $this->fee->getFeeConcessionByAppNo($std->row_id,$filter['term_name']);
                            $total_paid = $this->fee->getTotalFeePaidInfo($std->row_id,$year);
                            $pending = $total_amount - $total_paid;
                            if($type == 'PENDING' && $pending > 0){
                                $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                                $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->student_id);
                                $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
                                $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $total_amount);
                                $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_paid);
                                $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $pending);
                                $sl_number++;
                                $excel_row++;
                            }else if($type == 'PAID' && $pending <= 0){
                                $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                                $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->student_id);
                                $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
                                $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $total_amount);
                                $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_paid);
                                $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $pending);
                                $sl_number++;
                                $excel_row++;
                            }
                            $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
                        }
                    }
                    $spreadsheet->getActiveSheet()->setCellValue('C'.$excel_row,  "TOTAL");
                    $spreadsheet->getActiveSheet()->setCellValue('D'.$excel_row,"=SUM(D".$lastRow.":D".($excel_row-1).")");
                    $spreadsheet->getActiveSheet()->setCellValue('E'.$excel_row,"=SUM(E".$lastRow.":E".($excel_row-1).")");
                    $spreadsheet->getActiveSheet()->setCellValue('F'.$excel_row,"=SUM(F".$lastRow.":F".($excel_row-1).")");
                    $spreadsheet->getActiveSheet()->getStyle('A'.$excel_row.':F'.$excel_row)->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => Fill::FILL_SOLID,
                                'color' => array('rgb' => 'E5E4E2')
                            ),
                            'font'  => array(
                                'bold'  =>  true
                            )
                        )
                    );
                    $excel_row++;
                }

                // //$sl_number++;
                // $excel_row++;
                // }
                // $excel_row++;
                // $spreadsheet->getActiveSheet()->setCellValue('A'.$excel_row,  "");
                // $spreadsheet->getActiveSheet()->setCellValue('B'.$excel_row,  'ALL TOTAL');
                // $spreadsheet->getActiveSheet()->setCellValue('C'.$excel_row,  $total_sslc_state_fee);
                // $spreadsheet->getActiveSheet()->setCellValue('D'.$excel_row,  $total_cbse_icse_fee);
                // $spreadsheet->getActiveSheet()->setCellValue('E'.$excel_row,  $total_nri_fee);

                $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row . ":E" . $excel_row)->applyFromArray($font_style_total);
                $spreadsheet->createSheet();
                $i++;
                // $spreadsheet->getActiveSheet()->getStyle('A1:F'.$excel_row)->applyFromArray($styleBorder);
                //getting optional fee info




                $writer = new Xlsx($spreadsheet);
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="fee_paid_report.xlsx"');
                header('Cache-Control: max-age=0');
                setcookie('isDownLoaded', 1);
                $writer->save("php://output");
            }
        }
    }

    //download fee structure format
    public function download_fee_structure_excel()
    {
        if ($this->isAdmin() == true) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            $term_name = $this->security->xss_clean($this->input->post('term_name_select'));
            $year = $this->security->xss_clean($this->input->post('year'));
            $spreadsheet = new Spreadsheet();
            $headerFontSize = [
                'font' => [
                    'size' => 16,
                    'bold' => true,
                ]
            ];
            $font_style_total = [
                'font' => [
                    'size' => 12,
                    'bold' => true,
                ]
            ];
            $filter['term_name'] = $term_name;
            //$streamInfo = $this->staff->getStaffSectionByTerm($filter);

            $spreadsheet->getProperties()
                ->setCreator("SJPUC")
                ->setLastModifiedBy($this->staff_id)
                ->setTitle("SJPUC Fee Info")
                ->setSubject("Fee Structure")
                ->setDescription(
                    "SJPUC"
                )
                ->setKeywords("SJPUC")
                ->setCategory("Fee");
            $i = 0;

            $spreadsheet->setActiveSheetIndex(0);
            $spreadsheet->getActiveSheet()->setTitle('FEE');
            $spreadsheet->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $spreadsheet->getActiveSheet()->mergeCells("A1:K1");
            $spreadsheet->getActiveSheet()->getStyle("A1:A1")->applyFromArray($headerFontSize);

            $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->setCellValue('A2', $term_name . " FEES PAID REPORT -" .$year);
            $spreadsheet->getActiveSheet()->mergeCells("A2:K2");
            $spreadsheet->getActiveSheet()->getStyle("A2:A2")->applyFromArray($headerFontSize);
            $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal('center');

            $spreadsheet->getActiveSheet()->setCellValue('A3', 'SL No');
            $spreadsheet->getActiveSheet()->setCellValue('B3', 'Student ID');
            $spreadsheet->getActiveSheet()->setCellValue('C3', 'Application No');
            $spreadsheet->getActiveSheet()->setCellValue('D3', 'Name');
            $spreadsheet->getActiveSheet()->setCellValue('E3', 'Lang');
            $spreadsheet->getActiveSheet()->setCellValue('F3', 'Stream');
            $spreadsheet->getActiveSheet()->setCellValue('G3', 'SC/ST/CATI');
            $spreadsheet->getActiveSheet()->setCellValue('H3', 'Fee Payable');
            $spreadsheet->getActiveSheet()->setCellValue('I3', 'French Fee');
            $spreadsheet->getActiveSheet()->setCellValue('J3', 'Total Fee Paid');
            $spreadsheet->getActiveSheet()->setCellValue('K3', 'Pending');
            $spreadsheet->getActiveSheet()->getStyle("A3:K3")->applyFromArray($font_style_total);
            $spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('I3')->getAlignment()->setWrapText(true);
            // $feeTypeInfo = $this->fee->getAllFeeTypesForByStatus(1);

            $spreadsheet->getActiveSheet()->getStyle('A3:J3')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'E5E4E2')
                    ),
                    'font'  => array(
                        'bold'  =>  true
                    )
                )
            );


            $spreadsheet->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('A:K')->getAlignment()->setHorizontal('center');
            $excel_row = 4;
            $sl_number = 1;
            $total_sslc_state_fee = 0;
            $total_cbse_icse_fee = 0;
            $total_nri_fee = 0;
            $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(15);

            // foreach($feeTypeInfo as $type){
            if ($term_name == 'I PUC') {

                $studentInfo = $this->application->getAdmissionCompletedStudent($year);
                $total_state_fee_by_type = 0;
                $total_cbse_fee_by_type = 0;
                $total_nri_fee_by_type = 0;
                foreach ($studentInfo as $std) {
                    $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  "");
                    $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_number);
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->name);
                    $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $std->second_language);
                    $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $std->stream_name);
                    $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $std->student_category);
                    $filter['fee_year'] = $year;
                    $filter['term_name'] = 'I PUC';
                    $filter['stream_name'] = $std->stream_name;
                    if (strtoupper($std->second_language) == 'FRENCH') {
                        $filter['lang_fee_status'] = true;
                        $french_fee = 5000;
                    } else {
                        $filter['lang_fee_status'] = false;
                        $french_fee = 0;
                    }

                    $filter['category'] = strtoupper($std->student_category);
                    $boardInfo = $this->application->getStudentRegisteredInfo($std->resgisted_tbl_row_id);
                    $data['board_id'] = $boardInfo->sslc_board_name_id;
                    if ($boardInfo->sslc_board_name_id == 1) {
                        $filter['board_name'] = "SSLC";
                    } else {
                        $filter['board_name'] = "OTHER";
                    }
                    $total_fee = $this->fee->getTotalFeeAmount($filter);
                    $total_fee_amount = $total_fee->total_fee;
                    $total_paid_amount = $this->fee->getSUM_Paid_FeeInfoByReceiptNum_2021_I_PUC($std->application_number,$year);
                    if($total_paid_amount->paid_amount == ''){
                        $paid_amt = 0;
                    }else{
                        $paid_amt = $total_paid_amount->paid_amount;
                    }
                    $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount);
                    $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $french_fee);
                    $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $paid_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('K' . $excel_row,  $total_fee_amount - $total_paid_amount->paid_amount);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);

                    $sl_number++;
                    $excel_row++;
                }
            } else {
                if($year == CURRENT_YEAR ){
                    $yr = $year-1;
                }else{
                    $yr = $year-2;
                }
                $studentInfo = $this->student->getAllStudentInfo_For_Fee_report($term_name,$yr);
                $total_state_fee_by_type = 0;
                $total_cbse_fee_by_type = 0;
                $total_nri_fee_by_type = 0;
                foreach ($studentInfo as $std) {

                    $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->student_id);
                    $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->student_name);
                    $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $std->elective_sub);
                    $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $std->stream_name);
                    $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $std->category);
                    $filter['fee_year'] = $year;
                    $filter['term_name'] = 'II PUC';
                    $filter['stream_name'] = $std->stream_name;
                    if (strtoupper($std->elective_sub) == 'FRENCH') {
                        $filter['lang_fee_status'] = true;
                        $french_fee = 5000;
                    } else {
                        $filter['lang_fee_status'] = false;
                        $french_fee = 0;
                    }

                    $filter['category'] = strtoupper($std->category);

                    $total_fee = $this->fee->getTotalFeeAmount($filter);
                    $total_fee_amount = $total_fee->total_fee;
                    if($year== CURRENT_YEAR){
                        $total_paid_amount = $this->fee->getSUM_Paid_FeeInfoByReceiptNum_2021($std->application_no,$year);
                    }else{
                        $total_paid_amount = $this->fee->getSUM_Paid_FeeInfoIIPucLastYear($application_no);
                    }
                    if($total_paid_amount->paid_amount == ''){
                        $paid_amt = 0;
                    }else{
                        $paid_amt = $total_paid_amount->paid_amount;
                    }
                    $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount);
                    $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $french_fee);
                    $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $paid_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('K' . $excel_row,  $total_fee_amount - $total_paid_amount->paid_amount);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);

                    $sl_number++;
                    $excel_row++;
                }
            }
            // $excel_row++;

            // //$sl_number++;
            // $excel_row++;
            // }
            // $excel_row++;
            // $spreadsheet->getActiveSheet()->setCellValue('A'.$excel_row,  "");
            // $spreadsheet->getActiveSheet()->setCellValue('B'.$excel_row,  'ALL TOTAL');
            // $spreadsheet->getActiveSheet()->setCellValue('C'.$excel_row,  $total_sslc_state_fee);
            // $spreadsheet->getActiveSheet()->setCellValue('D'.$excel_row,  $total_cbse_icse_fee);
            // $spreadsheet->getActiveSheet()->setCellValue('E'.$excel_row,  $total_nri_fee);
            $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row . ":E" . $excel_row)->applyFromArray($font_style_total);
            $spreadsheet->createSheet();
            $i++;
            // $spreadsheet->getActiveSheet()->getStyle('A1:F'.$excel_row)->applyFromArray($styleBorder);
            //getting optional fee info




            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="fee_structure_' . $term_name . '.xlsx"');
            header('Cache-Control: max-age=0');
            setcookie('isDownLoaded', 1);
            $writer->save("php://output");
        }
    }


    public function downloadApplicationStack()
    {
        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {

            $report_type = $this->security->xss_clean($this->input->post('report_type'));
            $preference = $this->security->xss_clean($this->input->post('preference'));
            $board_name = $this->security->xss_clean($this->input->post('by_board'));
            $percentage_from = $this->security->xss_clean($this->input->post('percentage_from'));
            $percentage_to = $this->security->xss_clean($this->input->post('percentage_to'));
            $student_type = $this->security->xss_clean($this->input->post('student_type'));
            $admission_year = $this->security->xss_clean($this->input->post('admission_year')); 
            $category_by = $this->security->xss_clean($this->input->post('by_category'));
            $integrated_batch = $this->security->xss_clean($this->input->post('integrated_batch'));

            if($admission_year ==2022){

                $header = ' LIST 2022-2023';
            }else{
                $header = ' LIST 2021-2022';

            }

            if($report_type == 'APPLICATION_REJECTED'){

                $typee = 'REJECTED';
            }else{
                $typee = ' APPROVED';

            }
            
            $category = array(
                'ROMAN CATHOLIC',
                'OTHER CHRISTIANS',
                'GENERAL MERIT(GM)',
                'SC',
                'ST',
                'CAT-I',
                '2A',
                '3A',
                '2B',
                '3B'
            );
            for ($sheet = 0; $sheet < count($category); $sheet++) {
                $this->excel->setActiveSheetIndex($sheet);
                //name the worksheet

                $this->excel->getActiveSheet()->setTitle($category[$sheet]);
                $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');

                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', "ST JOSEPH'S PRE-UNIVERSITY COLLEGE HASSAN");
                $this->excel->getActiveSheet()->setCellValue('A2', "I PUC " . $typee . $header);
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->mergeCells('A1:L1');
                $this->excel->getActiveSheet()->mergeCells('A2:L2');
                $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);


                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);



                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL. NO.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Application Number');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Board');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Preference');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Category');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Percentage');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H3', 'PH');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I3', 'Dyslexia');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J3', 'NCC');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K3', 'Sports');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L3', 'Integrated Batch');
                $this->excel->getActiveSheet()->getStyle('A3:L3')->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->getStyle('A3:L3')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A3:L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



                $this->excel->getActiveSheet()->mergeCells('A4:L4');
                $this->excel->getActiveSheet()->getStyle('A4:L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->setCellValue('A4', $category[$sheet] . "- LIST");
                $this->excel->getActiveSheet()->getStyle('A4:L4')->getFont()->setBold(true);



                $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                $this->excel->getActiveSheet()->getStyle('A1:L4')->applyFromArray($styleBorderArray);

                $students = $this->application->getApprovedListDetails($preference, $category[$sheet], $board_name, $percentage_from, $percentage_to, $type, $student_type, $report_type,$admission_year,$integrated_batch);
                $j = 1;

                $excel_row = 5;
                if ($student_type == 'NCC') {
                    $student_type_print = 'NCC';
                } else if ($student_type == 'SPORTS') {
                    $student_type_print = 'SPORTS';
                } else if ($student_type == 'DYC') {
                    $student_type_print = 'Dyslexia';
                } else if ($student_type == 'PH') {
                    $student_type_print = 'PH';
                } else {
                    $student_type_print = 'ALL';
                }

                foreach ($students as $student) {
                    if ($student->board_name == 'KARNATAKA STATE BOARD') {
                        $board_name_sheet = 'SSLC';
                    } else if ($student->board_name == 'OTHER') {
                        $board_name_sheet = 'OTHERS';
                    } else {
                        $board_name_sheet = $student->board_name;
                    }

                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $j++);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $student->application_number);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $student->name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $board_name_sheet);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $student->stream_name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $student->student_category);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $student->sslc_percentage);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $student->dyslexia_challenged);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row, $student->physically_challenged);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('J' . $excel_row, $student->ncc_certificate_status);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('K' . $excel_row, $student->national_level_sports_status);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('L' . $excel_row, $student->integrated_batch);
                    $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':L' . $excel_row)->applyFromArray($styleBorderArray);
                    $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('D' . $excel_row . ':L' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel_row++;
                }

                $this->excel->createSheet();
            }
            $filename =  $report_type . '_Application_Report_-' . date('d-m-Y') . '.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            setcookie('isDownLoaded', 1);
            $objWriter->save("php://output");
        }
    }


    public function downloadGeneralReceiptsReport()
    {
        if ($this->isAdmin() == true) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            // $term_name = $filter['term'] = $this->security->xss_clean($this->input->post('term_select'));
            // $filter['stream'] = $this->security->xss_clean($this->input->post('stream_select'));

            $date_from = $this->security->xss_clean($this->input->post('date_from'));
            $date_to = $this->security->xss_clean($this->input->post('date_to'));
            $reportFormat = $this->security->xss_clean($this->input->post('reportFormat'));

            if($reportFormat == 'VIEW'){
                $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman']);
                $mpdf->AddPage('L','','','','',10,10,10,10,8,8);
                $mpdf->SetTitle('GENERAL RECEIPTS INFO');
                $data['date_from'] = date('Y-m-d',strtotime($date_from));
                $data['date_to'] = date('Y-m-d',strtotime($date_to));
                if(!empty($date_from)){
                    $date_from = date('Y-m-d',strtotime($date_from));
                }
                if(!empty($date_to)){
                    $date_to = date('Y-m-d',strtotime($date_to));
                }
                $interval = new DateInterval('P1D');
                $realEnd = new DateTime($date_to);
                $realEnd->add($interval);
                $data['date_range'] = new DatePeriod(date_create($date_from), $interval, $realEnd);
                $data['feemodel'] = $this->fee;
                $html = $this->load->view('reports/generalReceiptReportView',$data,true);
                $mpdf->WriteHTML($html);
                $mpdf->Output('GeneralReceiptsInfo.pdf', 'I');
            }else{
                $spreadsheet = new Spreadsheet();
                $headerFontSize = [
                    'font' => [
                        'size' => 16,
                        'bold' => true,
                    ]
                ];
                $font_style_total = [
                    'font' => [
                        'size' => 12,
                        'bold' => true,
                    ]
                ];
                //$streamInfo = $this->staff->getStaffSectionByTerm($filter);

                $spreadsheet->getProperties()
                    ->setCreator("SJPUC")
                    ->setLastModifiedBy($this->staff_id)
                    ->setTitle("SJPUC Fee Info")
                    ->setSubject("Fee Structure")
                    ->setDescription(
                        "SJPUC"
                    )
                    ->setKeywords("SJPUC")
                    ->setCategory("Fee");
                $i = 0;

                $spreadsheet->setActiveSheetIndex(0);
                $spreadsheet->getActiveSheet()->setTitle('FEE');
                $spreadsheet->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                $spreadsheet->getActiveSheet()->mergeCells("A1:E1");
                $spreadsheet->getActiveSheet()->getStyle("A1:E1")->applyFromArray($headerFontSize);

                $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
                $spreadsheet->getActiveSheet()->setCellValue('A2', $term_name . "GENERAL RECEIPT REPORT - From:" .(date('d-m-Y',strtotime($date_from)) == '01-01-1970' ? '-' : date('d-m-Y',strtotime($date_from)) ). " To:".(date('d-m-Y',strtotime($date_to)) == '01-01-1970' ? '-' : date('d-m-Y',strtotime($date_to))) );
                $spreadsheet->getActiveSheet()->mergeCells("A2:E2");
                $spreadsheet->getActiveSheet()->getStyle("A2:A2")->applyFromArray($headerFontSize);
                $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal('center');

                $spreadsheet->getActiveSheet()->setCellValue('A3', 'Date');
                $spreadsheet->getActiveSheet()->setCellValue('B3', 'Miscellaneous');
                // $miscellaneousTypeInfo = $this->settings->getAllMiscellaneousTypeInfo();
                // $cellName = array('B','C','D','E','F','G','H','I','J','K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
                // $j=0;
                // foreach($miscellaneousTypeInfo as $type){
                //     $spreadsheet->getActiveSheet()->setCellValue($cell_name[$j++].'3', $type->miscellaneous_type);
                // }
                $spreadsheet->getActiveSheet()->setCellValue('C3', 'Tuition Fee');
                $spreadsheet->getActiveSheet()->setCellValue('D3', 'Total');
                $spreadsheet->getActiveSheet()->getStyle("A3:D3")->applyFromArray($font_style_total);
                $spreadsheet->getActiveSheet()->getStyle("A3:D3")->applyFromArray($font_style_total);
                // $spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
                // $spreadsheet->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
                // $spreadsheet->getActiveSheet()->getStyle('E3')->getAlignment()->setWrapText(true);
                // $feeTypeInfo = $this->fee->getAllFeeTypesForByStatus(1);

                $spreadsheet->getActiveSheet()->getStyle('A3:B3')->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => Fill::FILL_SOLID,
                            'color' => array('rgb' => 'E5E4E2')
                        ),
                        'font'  => array(
                            'bold'  =>  true
                        )
                    )
                );


                $spreadsheet->getActiveSheet()->getStyle('A:E')->getAlignment()->setHorizontal('center');
                $excel_row = 4;
                $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
                $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(25);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(25);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(25);
                $filter['date_from'] = $date_from;
                $filter['date_to'] = $date_to;

                if(!empty($date_from)){
                    $date_from = date('Y-m-d',strtotime($date_from));
                }
                if(!empty($date_to)){
                    $date_to = date('Y-m-d',strtotime($date_to));
                }
                $interval = new DateInterval('P1D');
                
                $realEnd = new DateTime($date_to);
                $realEnd->add($interval);
                $date_range = new DatePeriod(date_create($date_from), $interval, $realEnd);
                foreach ($date_range as $date) {
                    $mis_total = $this->fee->getSumOfMisByDate($date->format('Y-m-d'));
                    $tuition_total = $this->fee->getSumOfFeeByDate($date->format('Y-m-d'));
                    $total = $mis_total + $tuition_total;
                    if(($total) > 0){
                        $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row, $date->format('d-m-Y'));
                        // $j=0;
                        // foreach($miscellaneousTypeInfo as $type){
                        $spreadsheet->getActiveSheet()->setCellValue('B'.$excel_row,  $mis_total);
                        // }
                        $spreadsheet->getActiveSheet()->setCellValue('C'.$excel_row,  $tuition_total);
                        $spreadsheet->getActiveSheet()->setCellValue('D'.$excel_row, $total);
                        $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);                        
                        $excel_row++;
                    }
                }
                $spreadsheet->getActiveSheet()->setCellValue('A'.$excel_row,  "TOTAL");
                $spreadsheet->getActiveSheet()->setCellValue('B'.$excel_row,"=SUM(B4:B".($excel_row-1).")");
                $spreadsheet->getActiveSheet()->setCellValue('C'.$excel_row,"=SUM(C4:C".($excel_row-1).")");
                $spreadsheet->getActiveSheet()->setCellValue('D'.$excel_row,"=SUM(D4:D".($excel_row-1).")");
                // $spreadsheet->getActiveSheet()->setCellValue('E'.$excel_row,"=SUM(E4:E".($excel_row-1).")");
                $spreadsheet->getActiveSheet()->getStyle('A'.$excel_row.':E'.$excel_row)->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => Fill::FILL_SOLID,
                                    'color' => array('rgb' => 'E5E4E2')
                                ),
                                'font'  => array(
                                    'bold'  =>  true
                                )
                            )
                        );
                $spreadsheet->createSheet();
                $i++;
                $writer = new Xlsx($spreadsheet);
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="fee_paid_report.xlsx"');
                header('Cache-Control: max-age=0');
                setcookie('isDownLoaded', 1);
                $writer->save("php://output");
            }
        }
    }

    //  public function downloadApplicationStack(){
    //     if($this->isAdmin() == TRUE){
    //         setcookie('isDownLoaded',1); 
    //         $this->loadThis();
    //     } else {    

    //         $report_type = $this->security->xss_clean($this->input->post('report_type'));
    //         $preference = $this->security->xss_clean($this->input->post('preference'));
    //         $board_name = $this->security->xss_clean($this->input->post('by_board'));
    //         $percentage_from = $this->security->xss_clean($this->input->post('percentage_from'));
    //         $percentage_to = $this->security->xss_clean($this->input->post('percentage_to'));
    //         $student_type = $this->security->xss_clean($this->input->post('student_type')); 
    //         $category_by = $this->security->xss_clean($this->input->post('by_category'));
    //         $category = array(
    //             'ROMAN CATHOLIC',
    //             'OTHER CHRISTIANS',
    //             'GENERAL MERIT(GM)',
    //             'SC',
    //             'ST',
    //             'CAT-I',
    //             '2A',
    //             '3A',
    //             '2B',
    //             '3B');
    //         for($sheet = 0; $sheet < count($category);  $sheet++){
    //             $this->excel->setActiveSheetIndex($sheet);
    //             //name the worksheet

    //             $this->excel->getActiveSheet()->setTitle($category[$sheet]);
    //             $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');

    //             //set Title content with some text
    //             $this->excel->getActiveSheet()->setCellValue('A1', "ST JOSEPH'S PRE-UNIVERSITY COLLEGE HASSAN");
    //             $this->excel->getActiveSheet()->setCellValue('A2', "I PUC ".$preference." APPROVED LIST 2021-2022");
    //             $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
    //             $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
    //             $this->excel->getActiveSheet()->mergeCells('A1:G1');
    //             $this->excel->getActiveSheet()->mergeCells('A2:G2');
    //             $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    //             $this->excel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);


    //             $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
    //             $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
    //             $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    //             $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
    //             $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
    //             $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    //             $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);



    //             $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL. NO.');
    //             $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Application Number');
    //             $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Name');
    //             $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Board');
    //             $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Preference');
    //             $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Category');
    //             $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Percentage');
    //             $this->excel->setActiveSheetIndex($sheet)->setCellValue('H3', 'PH');
    //             $this->excel->setActiveSheetIndex($sheet)->setCellValue('I3', 'Dyslexia');
    //             $this->excel->setActiveSheetIndex($sheet)->setCellValue('J3', 'NCC');
    //             $this->excel->setActiveSheetIndex($sheet)->setCellValue('K3', 'Sports');
    //             $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setWrapText(true); 
    //             $this->excel->getActiveSheet()->getStyle('A3:K3')->getFont()->setBold(true); 
    //             $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



    //             $this->excel->getActiveSheet()->mergeCells('A4:K4');
    //             $this->excel->getActiveSheet()->getStyle('A4:K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    //             $this->excel->getActiveSheet()->setCellValue('A4', $category[$sheet]."- LIST");
    //             $this->excel->getActiveSheet()->getStyle('A4:K4')->getFont()->setBold(true);



    //             $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
    //             $this->excel->getActiveSheet()->getStyle('A1:G4')->applyFromArray($styleBorderArray);

    //             $students = $this->application->getApprovedListDetails($preference,$category[$sheet],$board_name,$percentage_from,$percentage_to,$type,$student_type,$report_type);
    //             $j=1;

    //             $excel_row = 5;
    //             if($student_type == 'NCC'){
    //                 $student_type_print = 'NCC';
    //             }else if($student_type == 'SPORTS'){
    //                 $student_type_print = 'SPORTS';
    //             }else if($student_type == 'DYC'){
    //                 $student_type_print = 'Dyslexia';
    //             }else if($student_type == 'PH'){
    //                 $student_type_print = 'PH';
    //             }else{
    //                 $student_type_print = 'ALL';
    //             }

    //             foreach($students as $student){
    //                 if($student->board_name == 'KARNATAKA STATE BOARD'){
    //                     $board_name_sheet = 'SSLC';
    //                 } else if($student->board_name == 'OTHER'){
    //                     $board_name_sheet = 'OTHERS';
    //                 }else{
    //                     $board_name_sheet = $student->board_name;
    //                 }

    //                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
    //                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,$student->application_number);
    //                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,$student->name);
    //                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,$board_name_sheet);
    //                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,$student->stream_name);
    //                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$student->student_category);
    //                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,$student->sslc_percentage);
    //                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row,$student->dyslexia_challenged);
    //                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row,$student->physically_challenged);
    //                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row,$student->ncc_certificate_status);
    //                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row,$student->national_level_sports_status);
    //                 $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':K'.$excel_row)->applyFromArray($styleBorderArray);
    //                 $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':B'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    //                 $this->excel->getActiveSheet()->getStyle('D'.$excel_row.':K'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    //                 $excel_row++;
    //             }

    //             $this->excel->createSheet(); 

    //         }
    //         $filename =  $report_type.'_Application_Report_-'.date('d-m-Y').'.xls'; //save our workbook as this file name
    //         header('Content-Type: application/vnd.ms-excel'); //mime type
    //         header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
    //         header('Cache-Control: max-age=0'); //no cache

    //         //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
    //         //if you want to save it as .XLSX Excel 2007 format
    //         $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
    //         ob_start();
    //         setcookie('isDownLoaded',1);  
    //         $objWriter->save("php://output");
    //     }
    // }


    public function downloadAdmittedStudentInfo()
    {
        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {

            $report_type = $this->security->xss_clean($this->input->post('report_type'));
            $preference = $this->security->xss_clean($this->input->post('stream_name'));
            $board_name = $this->security->xss_clean($this->input->post('by_board'));
            $percentage_from = $this->security->xss_clean($this->input->post('percentage_from'));
            $percentage_to = $this->security->xss_clean($this->input->post('percentage_to'));
            $student_type = $this->security->xss_clean($this->input->post('student_type'));
            $admission_year = $this->security->xss_clean($this->input->post('admission_year'));
            $category_by = $this->security->xss_clean($this->input->post('by_category'));
            $integrated_batch = $this->security->xss_clean($this->input->post('integrated_batch'));

            if($admission_year ==2022){

                $header = ' ADMITTED LIST 2022-2023';
            }else{
                $header = ' ADMITTED LIST 2021-2022';

            }
            $category = array(
                'ROMAN CATHOLIC',
                'OTHER CHRISTIANS',
                'GENERAL MERIT(GM)',
                'SC',
                'ST',
                'CAT-I',
                '2A',
                '3A',
                '2B',
                '3B'
            );
            $sheet = 0;
            //for($sheet = 0; $sheet < count($category);  $sheet++){
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet

            $this->excel->getActiveSheet()->setTitle($preference);
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');

            //set Title content with some text
            $this->excel->getActiveSheet()->setCellValue('A1', "ST JOSEPH'S PRE-UNIVERSITY COLLEGE HASSAN");
            $this->excel->getActiveSheet()->setCellValue('A2', "I PUC " . $preference . $header);
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:K1');
            $this->excel->getActiveSheet()->mergeCells('A2:K2');
            $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);


            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);



            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL. NO.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Application Number');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Board');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Preference');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Category');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Percentage');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('H3', 'Religion');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('I3', 'Elective');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('J3', 'NCC');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('K3', 'Sports');
            $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->getStyle('A3:K3')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



            $this->excel->getActiveSheet()->mergeCells('A4:K4');
            $this->excel->getActiveSheet()->getStyle('A4:K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //$this->excel->getActiveSheet()->setCellValue('A4', $category[$sheet]."- LIST");
            $this->excel->getActiveSheet()->getStyle('A4:K4')->getFont()->setBold(true);



            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:K4')->applyFromArray($styleBorderArray);

            $students = $this->application->getAdmittedListDetails($preference, $board_name, $percentage_from, $percentage_to, $type, $student_type, $report_type,$admission_year,$integrated_batch);
            $j = 1;

            $excel_row = 5;
            if ($student_type == 'NCC') {
                $student_type_print = 'NCC';
            } else if ($student_type == 'SPORTS') {
                $student_type_print = 'SPORTS';
            } else if ($student_type == 'DYC') {
                $student_type_print = 'Dyslexia';
            } else if ($student_type == 'PH') {
                $student_type_print = 'PH';
            } else {
                $student_type_print = 'ALL';
            }

            foreach ($students as $student) {
                if ($student->board_name == 'KARNATAKA STATE BOARD') {
                    $board_name_sheet = 'SSLC';
                } else if ($student->board_name == 'OTHER') {
                    $board_name_sheet = 'OTHERS';
                } else {
                    $board_name_sheet = $student->board_name;
                }

                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $j++);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $student->application_number);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $student->name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $board_name_sheet);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $student->stream_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $student->student_category);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $student->sslc_percentage);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $student->religion);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row, $student->second_language);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J' . $excel_row, $student->ncc_certificate_status);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K' . $excel_row, $student->national_level_sports_status);
                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':K' . $excel_row)->applyFromArray($styleBorderArray);
                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('D' . $excel_row . ':K' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
            }

            $this->excel->createSheet();

            // }
            $filename =  $report_type . '_Application_Report_-' . date('d-m-Y') . '.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            setcookie('isDownLoaded', 1);
            $objWriter->save("php://output");
        }
    }
    public function downloadAdmissionRegisteredStudent()
    {
        if ($this->isAdmin() == true) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            $student = $this->security->xss_clean($this->input->post('by_student'));
            $term = $this->security->xss_clean($this->input->post('term'));
            $report_type = $this->security->xss_clean($this->input->post('report_type'));
            $by_sslc_board = $this->security->xss_clean($this->input->post('by_board'));
            $elective_sub = $this->security->xss_clean($this->input->post('elective_sub'));
            $cellNameByStudentReport = array('G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
            $sheet = 0;
            $this->excel->setActiveSheetIndex($sheet);
            $this->excel->getActiveSheet()->setTitle($sheet);
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:N500');
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', $report_type . " Report");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:N1');
            $this->excel->getActiveSheet()->mergeCells('A2:N2');
            $this->excel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A2:N2')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $excel_row = 3;
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(24);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(28);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(16);

            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(35);
            $this->excel->getActiveSheet()->getStyle('A3:N3')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A3:N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, 'SL No.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, 'Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, 'DOB');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, 'Registration No.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, 'Board Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, 'Mobile');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, 'Email');
            $filter['report_type'] = $report_type;
            // $filter['stream_name']= $stream[$sheet];
            $filter['by_sslc_board'] = $by_sslc_board;

            $filter['term'] = $term;
            $sl = 1;
            $excel_row = 4;
            $studentInfo = $this->application->getAllRegisteredStdInfo($filter);
            foreach ($studentInfo as $std) {
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $sl++);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $std->name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, date('d-m-Y', strtotime($std->dob)));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $std->registration_number);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $std->board_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $std->mobile);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $std->email);
                $this->excel->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C' . $excel_row . ':F' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('I' . $excel_row . ':L' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
            }
            $this->excel->createSheet();
            // }

        }

        $filename =  $report_type . '_Report_-' . date('d-m-Y') . '.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        ob_start();
        setcookie('isDownLoaded', 1);
        $objWriter->save("php://output");
    }


    public function dayWiseStructureFeePayment()
    {
        $filter = array();
        $date_to = $this->security->xss_clean($this->input->post('date_to'));
        $date_from = $this->security->xss_clean($this->input->post('date_from'));


        $cellNameByStudentReport = array('E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF');
        $sheet = 0;
        $this->excel->setActiveSheetIndex($sheet);
        //name the worksheet
        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $this->excel->getActiveSheet()->setTitle('Fee Paid Report By Structure');
        $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');
        //set Title content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
        $this->excel->getActiveSheet()->setCellValue('A2', $term . " Fee Structure Report 2021-22");
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
        // $this->excel->getActiveSheet()->setCellValue('A3', "Account Number : ".$bankAccount->account_no);
        $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->mergeCells('A1:AF1');
        $this->excel->getActiveSheet()->mergeCells('A2:AF2');
        $this->excel->getActiveSheet()->mergeCells('A3:AF3');
        $this->excel->getActiveSheet()->getStyle('A1:AF3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


        $excel_row = 4;
        if (!empty($date_to) && !empty($date_from)) {
            $filter['date_to'] = date('Y-m-d', strtotime($date_to));
            $filter['date_from'] = date('Y-m-d', strtotime($date_from));
        } else {
            $filter['date_to'] = "";
            $filter['date_from'] = "";
        }

        $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, 'Date');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, 'Invoice No.');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, 'Application No');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, 'Name');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, 'Stream');
        $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':Z' . $excel_row)->getFont()->setBold(true);

        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(28);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $cell_name = 1;
        $bank_account_amount = array();
        $fee_structure_total = array();
        $feeStructureInfo = $this->fee->getAllFeeStructureInfoForReport();
        $fee_type_name = "";
        $array_of_fee_type_id = array('');
        $fee_name_row_id = array('1', '2', '9', '4', '7', '3');
        foreach ($fee_name_row_id as $row_id) {
            $feeInfo = $this->fee->getFeeTitleInfoById($row_id);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameByStudentReport[$cell_name] . $excel_row, $feeInfo->fee_name);

            $this->excel->getActiveSheet()->getStyle($cellNameByStudentReport[$cell_name] . $excel_row . ':Z' . $this->excel->getActiveSheet()->getHighestRow())
                ->getAlignment()->setWrapText(true);
            $cell_name++;
        }
        // foreach($feeStructureInfo as $fee){

        //     $fee_structure_total[$fee->row_id] = 0;
        //    // $fee_structure[$fee->row_id] = 0;
        //     // if($fee_type_name != $fee->fees_type){
        //     $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameByStudentReport[$cell_name].$excel_row, $fee->fee_name);

        //     $this->excel->getActiveSheet()->getStyle($cellNameByStudentReport[$cell_name].$excel_row.':Z'.$this->excel->getActiveSheet()->getHighestRow())
        //     ->getAlignment()->setWrapText(true);
        //     $cell_name++;
        //  //  }
        //   // $fee_type_name = $fee->fees_type;
        // }

        $this->excel->getActiveSheet()->getStyle('A4:Z4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameByStudentReport[$cell_name+1].$excel_row, 'Society Fee');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameByStudentReport[$cell_name] . $excel_row, 'Grand Total');
        $excel_row++;
        $grand_total = 0;
        $paidInfo = $this->fee->getFeePaidInfoForReport($date_from, $date_to);

        foreach ($paidInfo as $paid) {
            $cell_name = 1;
            $grand_total_date = 0;
            $fee_type_name = "";
            $amount = 0;
            $total_fee_row = 0;
            $elective = substr($paid->second_language, 0, 1);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, date('d-m-Y', strtotime($paid->payment_date)));
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $paid->row_id);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $paid->application_no);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $paid->name);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $paid->stream_name);

            // foreach($feeStructureInfo as $fee){
            //     $paidAmt = $this->fee->getFeeStructureAmount($paid->receipt_number,$fee->fees_type);
            //     $amount = $paidAmt->paid_amount;
            //     $total_fee_row += $amount;
            //     $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameByStudentReport[$cell_name].$excel_row, $amount);
            //     $cell_name++;
            // }
            $total_amt = array();
            foreach ($fee_name_row_id as $row_id) {
                $paidAmt = $this->fee->getFeeStructureAmount($paid->receipt_number, $row_id);
                if ($row_id == 7) {
                    $mgmtAmt = $this->fee->getMgmtFeePaidInfo($paid->application_no);
                    if (!empty($mgmtAmt)) {
                        $mgmt_amt = $mgmtAmt->amount;
                        $total_fee_row += $mgmtAmt->amount;
                        $total_mgnt_fee += $mgmt_amt;
                    } else {
                        $mgmt_amt = 0;
                    }
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameByStudentReport[$cell_name] . $excel_row, $mgmt_amt);
                    $cell_name++;
                    // log_message('debug','ehue'.$total_fee_row);
                } else {
                    $amount = $paidAmt->paid_amount;
                    $total_fee_row += $amount;
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameByStudentReport[$cell_name] . $excel_row, $amount);
                    $cell_name++;
                }
            }


            // $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameByStudentReport[$cell_name+1].$excel_row, $mgmt_amt);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameByStudentReport[$cell_name] . $excel_row, $total_fee_row);

            $this->excel->getActiveSheet()->getStyle('L' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel_row++;
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, 'Total');
        }
        $this->excel->getActiveSheet()->getStyle('A' . $excel_row)->getFont()->setBold(true);

        $date_from_ = strtotime($date_from); // Convert date to a UNIX timestamp  
        $date_to_ = strtotime($date_to); // Convert date to a UNIX timestamp  

        // Loop from the start date to end date and output all dates inbetween 

        for ($i = $date_from_; $i <= $date_to_; $i += 86400) {

            $date =  date("Y-m-d", $i);
            //  log_message('debug','fghjk='.$date); 



        }


        $this->excel->createSheet();
        $filename =  'Fees_Structure_Report_-' . date('d-m-Y') . '.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // $objWriter->setPreCalculateFormulas(true);  
        ob_start();
        setcookie('isDownLoaded', 1);
        $objWriter->save("php://output");
    }

    // exam mark sheet
    public function downloadExamMarkSheet()
    {
        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            set_time_limit(0);
            ini_set('memory_limit', '256M');
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $section_name = $this->security->xss_clean($this->input->post('section_name'));
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
            $subject_code = $this->security->xss_clean($this->input->post('subject_code'));
            $filter = array();
            $filter['term'] = $term_name;
            $filter['subject_code'] = $subject_code;
            $filter['term_name'] = $term_name;
            $filter['stream_name'] = $stream_name;

            $term = $term_name;
            $cellNameCategory = array('E', 'F', 'G', 'H', 'I', 'J');
            $filter['section_name'] = $section_name;
            if ($section_name != "ALL") {
                $section = $section_name;
            } else {
                $section = '';
            }
            $sections = array($section_name);
            $subjectInfo = $this->subject->getAllSubjectByID($subject_code);
            $sheet = 0;
            $j = 1;
            $excel_row = 6;
            $filter['subject_name'] = $subjectInfo->sub_name;
            $subject_name = $subjectInfo->sub_name;
            // $class_section = $section_name[$sheet];
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle($stream_name);
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:K500');
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', $term . ' ' . $stream_name . ' ' . $section . " MARKS SHEET 2022-23");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:J1');
            $this->excel->getActiveSheet()->mergeCells('A2:J2');
            $this->excel->getActiveSheet()->getStyle('A1:A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->mergeCells('A1:J1');
            $this->excel->getActiveSheet()->mergeCells('A2:J2');
            $this->excel->getActiveSheet()->setCellValue('A3', strtoupper($subjectInfo->sub_name));
            $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A3:J3');


            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);


            if ($subjectInfo->subject_code == 12) {
                $labStatus = 'true';
                $lab_title = 8;
            } else {
                $labStatus = $subjectInfo->lab_status;
                $lab_title = 8;
            }


            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A4', 'SL. NO.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B4', 'REG. No');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C4', 'NAME OF THE STUDENT');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D4', 'PASS MARKS');
            if ($labStatus == 'true') {
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E4', 'LAB');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F4', 'UNIT TEST-1');
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('G4', 'ASSIGNMENT-2');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G4', 'LAB-' . $lab_title);
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('H4', 'INT. ASSMNT');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H4', 'TOTAL MARKS');

                // if($subjectInfo->subject_code != 12){
                //     $this->excel->setActiveSheetIndex($sheet)->setCellValue('H5', 'REC-10');
                // }
            } else {
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('E4', 'ASSIGNMENT-1');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E4', 'UNIT TEST-1');
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('F4', 'ASSIGNMENT-2');
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('F4', 'INT. ASSMNT');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H4', 'TOTAL MARKS');
            }


            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D5', 'THEORY');


            // $this->excel->getActiveSheet()->getStyle('A3:J5')->getAlignment()->setWrapText(true); 
            $this->excel->getActiveSheet()->getStyle('A3:J5')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A3:J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:J5')->applyFromArray($styleBorderArray);

            $students = $this->student->getStudentInfoForInternal($filter);
            // log_message('debug','dnd='.print_r($filter,true));
            $total_mark = 0;
            foreach ($students as $student) {
                $section = $student->section_name;
                $filter['section'] = $section;
                $percentage_active = false;
                $elective_sub = strtoupper($student->elective_sub);

                if ($labStatus == 'true') {
                    if ($subjectInfo->subject_code == 12) {
                        $pass_mark_theory = 18;
                        $pass_mark_lab = 0;
                    } else {
                        $pass_mark_theory = 12;
                        $pass_mark_lab = 0;
                    }
                } else {
                    $pass_mark_theory = 35;
                    $pass_mark_lab = 0;
                }

                $subject_code == $subjectInfo->subject_code;
                $total_class_held_per_std = 0;
                $total_attd_class_std = 0;
                $absentCount = 0;
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $j++);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $student->student_id);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $student->student_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $pass_mark_theory);

                $cellName = 0;
                if ($labStatus == 'true') {
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameCategory[$cellName] . $excel_row, $pass_mark_lab);
                    $cellName++;
                    // $exam_type = array('ASSIGNMENT_I', 'ASSIGNMENT_II');
                    $exam_type = array('I_UNIT_TEST');
                    if ($subjectInfo->subject_code == 12) {
                        $lab_assessment = 8;
                    } else {
                        $lab_assessment = 8;
                    }
                } else {
                    // $exam_type = array('ASSIGNMENT_I', 'ASSIGNMENT_II');
                    $exam_type = array('I_UNIT_TEST');
                    $lab_assessment = 0;
                    // ,'INTERNAL_ASSESSMENT'
                }
                //,'LAB_ASSESSMENT','INTERNAL_ASSESSMENT'

                // if ($student->student_id == '20P5965' || $student->student_id == '20P4140' || $student->student_id == '20P1754') {
                //     $internal_assessment = 1;
                // } else {
                //     $internal_assessment = 5;
                // }
                $mark_obt = 0;
                $total_mark = 0;
                foreach ($exam_type as $exam) {

                    $stdMarkInfo = $this->student->getStudentFinalMarks($student->student_id, $subject_code, $exam);
                    $sub_marks = 0;
                    $mark_obt = 0;
                    // if ($stdMarkInfo->exam_type == 'ASSIGNMENT_I' || $stdMarkInfo->exam_type == 'ASSIGNMENT_II') {
                    //     if ($stdMarkInfo->obt_theory_mark == 'AB' || $stdMarkInfo->obt_theory_mark == 'EXEM' || $stdMarkInfo->obt_theory_mark == 'MP' || $stdMarkInfo->obt_theory_mark ==  'ASGN') {
                    //         $mark_obt = 0;
                    //     } else {
                    //         $sub_marks = $this->getAssessmentMark($stdMarkInfo->obt_theory_mark, $stdMarkInfo->exam_type, $labStatus, $subject_code);
                    //         $mark_obt = $sub_marks;
                    //     }
                    // } else {
                        if ($stdMarkInfo->obt_theory_mark == 'AB' || $stdMarkInfo->obt_theory_mark == 'EXEM' || $stdMarkInfo->obt_theory_mark == 'MP' || $stdMarkInfo->obt_theory_mark ==  'ASGN') {
                            $mark_obt = 0;
                        } else {
                            $mark_obt = $stdMarkInfo->obt_theory_mark;
                        }
                    // }
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameCategory[$cellName] . $excel_row, $mark_obt);
                    $total_mark += $mark_obt;
                    $cellName++;
                }
                if ($labStatus == 'true') {
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameCategory[$cellName] . $excel_row, $lab_assessment);
                    $cellName++;
                }
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameCategory[$cellName] . $excel_row, $internal_assessment);
                $totalMark = $total_mark + $pass_mark_theory + $pass_mark_lab + $lab_assessment;
                $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameCategory[$cellName] . $excel_row, $totalMark);
                $cellName++;

                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':J' . $excel_row)->applyFromArray($styleBorderArray);
                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('D' . $excel_row . ':J' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $excel_row++;
            }

            $this->excel->createSheet();

            $filename =  $term . '_' . $stream_name . '_' . $subject_name . '_EXAM_MARKS_SHEET.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment; filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            setcookie('isDownLoaded', 1);
            $objWriter->save("php://output");
        }
    }


    // combined mark report - assignment exam
    public function downloadAssignmentExamMarkReport()
    {
        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $j = 1;
            $sheet = 0;
            $term_name = $this->input->post("term_name");
            $stream_name = $this->input->post("stream_name");

            // $term_name = 'I PUC';
            $first_cell = array("L", "O", "R", "U");
            $middle_cell = array("M", "P", "S", "V");
            $last_cell = array("N", "Q", "T", "W");
            //$section = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q");
            $streamInfo = $this->student->getAllStreamName();

            if ($stream_name == 'ALL') {
                $stream_name = array(
                    'PCMB',
                    'PCMC',
                    'CEBA',
                    'SEBA',
                    'HESP',
                    'HEBA'
                );
            } else {
                $stream_name = array($stream_name);
            }

            // $term = 'I PUC';

            foreach ($stream_name as $stream) {
                $stream_name = $stream;
                $subjects = $this->getSubjectCodes($stream_name);
                // log_message('debug','subjects '.print_r($subjects,true));


                $this->excel->setActiveSheetIndex($sheet);
                // $sheet++;
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle($stream_name);
                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                $this->excel->getActiveSheet()->setCellValue('A2', "ANNUAL EXAMINATION OF ".$term_name." AUGUST-2022");
                $this->excel->getActiveSheet()->setCellValue('A3', "Abbreviation used in the table");
                $this->excel->getActiveSheet()->setCellValue('A4', "MO: Marks Obtained | IA: Internal Assessment | TH: Theory | PR: Practical | LT: Language Total | ST: Subjects Total | TM: Total Marks");
                $this->excel->getActiveSheet()->setCellValue('A5', $term_name . " - " . $stream_name);

                //change the font size 
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(12);
                $this->excel->getActiveSheet()->getStyle('A4')->getFont()->setSize(11);
                $this->excel->getActiveSheet()->getStyle('A5:Y5')->getFont()->setSize(13);
                $this->excel->getActiveSheet()->getStyle('A1:A5')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->mergeCells('A1:Z1');
                $this->excel->getActiveSheet()->mergeCells('A2:Z2');
                $this->excel->getActiveSheet()->mergeCells('A3:Z3');
                $this->excel->getActiveSheet()->mergeCells('A4:Z4');
                $this->excel->getActiveSheet()->mergeCells('A5:Z5');
                $this->excel->getActiveSheet()->mergeCells('A6:A7');
                $this->excel->getActiveSheet()->mergeCells('C6:C7');
                $this->excel->getActiveSheet()->mergeCells('B6:B7');
                $this->excel->getActiveSheet()->mergeCells('D6:D7');
                $this->excel->getActiveSheet()->mergeCells('E6:E7');
                $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                //settting border style 
                $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                $this->excel->getActiveSheet()->getStyle('A1:Z300')->applyFromArray($styleArray);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A6', 'SL.no');

                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B6', 'SAT No.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C6', 'Student ID');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D6', 'Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E6', 'Lang');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F6', 'Lng');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F7', 'Code');
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(11);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(38);

                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G6', 'Language');
                $this->excel->getActiveSheet()->mergeCells('G6:I6');


                $this->excel->getActiveSheet()->mergeCells('X6:X7');
                $this->excel->getActiveSheet()->mergeCells('Y6:Y7');
                $this->excel->getActiveSheet()->mergeCells('Z6:Z7');

                $this->excel->getActiveSheet()->getStyle('G6:I6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G7', 'TH');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H7', 'IA');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I7', 'MO');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J6', 'English(02)');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J7', 'Marks');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K7', 'LT');

                $this->excel->setActiveSheetIndex($sheet)->setCellValue('X6', 'ST');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('Y6', 'TM');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('Z6', 'Result');

                //$this->excel->getActiveSheet()->mergeCells('K2:M2');
                $excel_row = 7;
                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(4);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(4);
                $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(4);
                $this->excel->getActiveSheet()->getColumnDimension('X')->setWidth(5);
                $this->excel->getActiveSheet()->getColumnDimension('Y')->setWidth(5);
                $this->excel->getActiveSheet()->getColumnDimension('Z')->setWidth(14);
                $this->excel->getActiveSheet()->getStyle('F1:F3')->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->getStyle('E6:Z300')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('I7:I999')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A6:Z7')->getFont()->setBold(true);

                $this->excel->getActiveSheet()->getStyle('J8:J150')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('X8:Z999')->getFont()->setBold(true);
                $this->cellColor('A6:Z7', 'D5DBDB');

                //first subject heading
                for ($i = 0; $i < 4; $i++) {
                    $subjectInfo = $this->subject->getAllSubjectByID($subjects[$i]);
                    $this->excel->getActiveSheet()->getColumnDimension($first_cell[$i])->setWidth(6);
                    $this->excel->getActiveSheet()->getColumnDimension($middle_cell[$i])->setWidth(6);
                    $this->excel->getActiveSheet()->getColumnDimension($last_cell[$i])->setWidth(6);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . '6', $subjectInfo->sub_name . '(' . $subjects[$i] . ')');
                    $this->excel->getActiveSheet()->mergeCells($first_cell[$i] . '6:' . $last_cell[$i] . '6');
                    $this->excel->getActiveSheet()->getStyle($first_cell[$i] . '6:' . $last_cell[$i] . '6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    if ($subjectInfo->lab_status == "true") {
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . '7', 'TH');
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($middle_cell[$i] . '7', 'PR');
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . '7', 'MO');
                    } else {
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . '7', "Marks");
                        $this->excel->getActiveSheet()->mergeCells($first_cell[$i] . '7:' . $last_cell[$i] . '7');
                        $this->excel->getActiveSheet()->getStyle($first_cell[$i] . '7:' . $last_cell[$i] . '7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $this->excel->getActiveSheet()->getColumnDimension($first_cell[$i])->setWidth(5);
                        $this->excel->getActiveSheet()->getColumnDimension($middle_cell[$i])->setWidth(5);
                        $this->excel->getActiveSheet()->getColumnDimension($last_cell[$i])->setWidth(5);
                    }
                }

                $studentInfo = $this->student->getStudentsToAnnualResultReport($term_name, $stream_name);
                $excel_row = 8;
                $k = 1;
                foreach ($studentInfo  as $row) {
                    $subjects_code = array();
                    $elective_sub = strtoupper($row->elective_sub);
                    if ($elective_sub == "KANNADA") {
                        array_push($subjects_code, '01');
                    } else if ($elective_sub == 'HINDI') {
                        array_push($subjects_code, '03');
                    } else if ($elective_sub == 'FRENCH') {
                        array_push($subjects_code, '12');
                    }
                    array_push($subjects_code, '02');
                    $subjects_code = array_merge($subjects_code, $subjects);
                    // log_message('debug','scdcndj'.print_r($subjects_code,true));

                    $first_language_code = '';
                    $first_language_name = '';
                    $total_marks_subjects = 0;
                    $total_marks_all_subjects = 0;
                    $fail_flag = false;
                    $student_status = 0;
                    // $data['studentsMarks'] = $this->exams->getFullMarksOfStudentInternal($row->student_id,$exam_type);

                    // if(!empty($data['studentsMarks']) && $student_status == 0){
                    $first_language_total = 0;
                    $second_lang_mark = 0;
                    $first_lan_TH = 0;
                    $first_lan_IA = 0;
                    $subject_code_from_subjects = 0;
                    foreach ($subjects_code as $subject) {
                        // foreach($data['studentsMarks']  as $mark){
                        $subject_true = false;
                        if ($subject == '01') {
                            $subjectInfo = $this->subject->getAllSubjectByID($subject);
                            $first_language_code = $subject;
                            $first_language_name = "KAN";
                            $theory_mark = $this->getAssignmentExamTheoryTotalMark($row->student_id, $subjectInfo->subject_code, $subjectInfo->lab_status);
                            $lab_mark = $this->getAssignmentExamLabTotalMark($row->student_id, $subjectInfo->subject_code, $subjectInfo->lab_status);
                            $first_lan_TH =  $theory_mark;
                            $first_lan_IA =  $lab_mark;
                            $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;

                            $first_language_total =  $first_language_total;

                            // if($first_language_total < $pass_mark && $first_lan_TH != 'ASGN'){
                            //     // log_message('debug','value==' .$pass_mark);
                            //     $this->cellColor('F'.$excel_row.':H'.$excel_row, 'FFEE58');
                            //     $fail_flag = true;
                            // }
                        } else if ($subject == '03') {
                            $subjectInfo = $this->subject->getAllSubjectByID($subject);
                            $first_language_code = $subject;
                            $first_language_name = "HINDI";
                            $theory_mark = $this->getAssignmentExamTheoryTotalMark($row->student_id, $subjectInfo->subject_code, $subjectInfo->lab_status);
                            $lab_mark = $this->getAssignmentExamLabTotalMark($row->student_id, $subjectInfo->subject_code, $subjectInfo->lab_status);
                            $first_lan_TH =  $theory_mark;
                            $first_lan_IA =  $lab_mark;
                            $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;
                            $first_language_total =  $first_language_total;


                            // if($first_language_total < $pass_mark && $first_lan_TH != 'ASGN'){
                            //     $this->cellColor('F'.$excel_row.':H'.$excel_row, 'FFEE58');
                            //     $fail_flag = true;
                            // }
                        } else if ($subject == '12') {
                            $subjectInfo = $this->subject->getAllSubjectByID($subject);
                            $first_language_code = $subject;
                            $first_language_name = "FRENCH";
                            $theory_mark = $this->getAssignmentExamTheoryTotalMark($row->student_id, $subjectInfo->subject_code, $subjectInfo->lab_status);
                            $lab_mark = $this->getAssignmentExamLabTotalMark($row->student_id, $subjectInfo->subject_code, $subjectInfo->lab_status);
                            $first_lan_TH =  $theory_mark;
                            $first_lan_IA =  $lab_mark;
                            $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;
                            $first_language_total =  $first_language_total;

                            // if($first_lan_TH < $pass_mark && $first_lan_TH != 'ASGN'){
                            //     $this->cellColor('F'.$excel_row.':H'.$excel_row, 'FFEE58');
                            //     $fail_flag = true;
                            // } else if($first_language_total < $pass_mark && $first_lan_TH != 'ASGN'){
                            //     $this->cellColor('F'.$excel_row.':H'.$excel_row, 'FFEE58');
                            //     $fail_flag = true;
                            // }

                        } else if ($subject == '02') {
                            $subjectInfo = $this->subject->getAllSubjectByID($subject);
                            $theory_mark = $this->getAssignmentExamTheoryTotalMark($row->student_id, $subjectInfo->subject_code, $subjectInfo->lab_status);
                            $second_lang_mark =  $theory_mark;

                            // if($second_lang_mark < $pass_mark && $second_lang_mark != 'ASGN'){
                            //     $this->cellColor('I'.$excel_row.':J'.$excel_row, 'FFEE58');
                            //     $fail_flag = true;
                            // }
                        } else {
                            $sub_theory_mark = 0;
                            $sub_lab_mark = 0;
                            for ($i = 0; $i < 4; $i++) {
                                if ($subject == $subjects[$i]) {
                                    $subjectInfo = $this->subject->getAllSubjectByID($subjects[$i]);
                                    $theory_mark = $this->getAssignmentExamTheoryTotalMark($row->student_id, $subjectInfo->subject_code, $subjectInfo->lab_status);
                                    $lab_mark = $this->getAssignmentExamLabTotalMark($row->student_id, $subjectInfo->subject_code, $subjectInfo->lab_status);

                                    if ($subjectInfo->lab_status == 'true') {
                                        $sub_theory_mark = (int)$theory_mark;
                                        $sub_lab_mark = (int)$lab_mark;
                                        $sub_total_mark = $sub_theory_mark + $sub_lab_mark;
                                        $sub_total_mark =  $sub_total_mark;
                                        $sub_theory_mark = $sub_theory_mark;

                                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . $excel_row, $theory_mark);
                                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($middle_cell[$i] . $excel_row, $lab_mark);
                                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . $excel_row,  $sub_total_mark);
                                    } else {
                                        $sub_theory_mark = (int)$theory_mark;
                                        $sub_theory_mark = $sub_theory_mark;

                                        // if($sub_theory_mark < $pass_mark && $theory_mark != 'ASGN'){
                                        //     $fail_flag = true;
                                        //     $this->cellColor($first_cell[$i].$excel_row.':'.$first_cell[$i].$excel_row, 'FFEE58');
                                        // }
                                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . $excel_row, $theory_mark);
                                        $this->excel->getActiveSheet()->mergeCells($first_cell[$i] . $excel_row . ':' . $last_cell[$i] . $excel_row);
                                        $this->excel->getActiveSheet()->getStyle($first_cell[$i] . $excel_row . ':' . $last_cell[$i] . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    }
                                    $total_marks_subjects +=  $sub_theory_mark + $sub_lab_mark;
                                }
                            }
                        }
                    }

                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $k++);
                    //student info
                    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->sat_number);
                    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->student_id);
                    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->student_name);
                    //adding first Language
                    // $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;

                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row,  $first_language_name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row,  $first_language_code);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $first_lan_TH);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row,  $first_lan_IA);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row, $first_language_total);
                    //second Language
                    $total_language_mark = $first_language_total + (int)$second_lang_mark;
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('J' . $excel_row, $second_lang_mark);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('K' . $excel_row, $total_language_mark);

                    $total_marks_all_subjects = $total_marks_subjects + (int)$first_language_total + (int)$second_lang_mark;
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('X' . $excel_row, $total_marks_subjects);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('Y' . $excel_row, $total_marks_all_subjects);

                    $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':C' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    if ($fail_flag == true) {
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('Z' . $excel_row, "Failed");
                    } else {
                        $result = $this->calculateResult($total_marks_all_subjects);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('Z' . $excel_row, $result);
                    }
                    $excel_row++;
                    // }

                }
                $this->excel->createSheet();
                $sheet++;
                // }
            }

            $filename =  $term_name . '_' . $stream_name . '_EXAM_MARKS_SHEET.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment; filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            setcookie('isDownLoaded', 1);
            $objWriter->save("php://output");
        }
    }


    public function cellColor($cells, $color)
    {
        return $this->excel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $color
            )
        ));
    }

    public function getCancelReceiptReport(){
        if ($this->isAdmin() == true ) {
            setcookie('isDownLoaded',1);  
            $this->loadThis();
        } else {
            $filter = array();
           
            $year = $this->security->xss_clean($this->input->post('year'));
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
            $type = $this->security->xss_clean($this->input->post('type'));
            $reportFormat = $this->security->xss_clean($this->input->post('reportFormat'));
            $display_year = $year . '-' . substr($year + 1, 2);
            if($reportFormat == 'VIEW'){
                 setcookie('isDownloading',0);
                 $data['dt_filter'] = $filter;
                 $filter['year']= $year;
                 $data['year'] = $year;
                 $data['type'] = $type;
                 $data['display_year'] = $display_year;
                 $data['fee'] = $this->fee;
                 $this->global['pageTitle'] = ''.TAB_TITLE.' : CREDIT NOTE REPORT';
                 $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman']);
                 $mpdf->AddPage('P','','','','',10,10,10,10,8,8);
                 $mpdf->SetTitle('CREDIT NOTE REPORT');
                 $html = $this->load->view('reports/cancelReceiptReport',$data,true);
                 $mpdf->WriteHTML($html);
                 $mpdf->Output('CAN.pdf', 'I');
             }else{
           if($type == 'Mgmt'){ 
                $cellNameByStudentReport = array('G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
                // $filter['bank_settlement'] = $bank_settlement;
                $sheet = 0;
                    $this->excel->setActiveSheetIndex($sheet);
                    //name the worksheet
                    $this->excel->getActiveSheet()->setTitle("CREDIT NOTE REPORTT");
                    $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:Q500');
                    //set Title content with some text
                    $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                    $this->excel->getActiveSheet()->setCellValue('A2', "Credit Note Report - ".$display_year);
                    $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                    $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                    $this->excel->getActiveSheet()->mergeCells('A1:H1');
                    $this->excel->getActiveSheet()->mergeCells('A2:H2');
                    $this->excel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
                    $this->excel->getActiveSheet()->getStyle('A2:H2')->getFont()->setBold(true);
                    $this->excel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('A1:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    
                    $excel_row = 3;
                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(14);
                    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(28);
                    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                    $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
                    $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
                    $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                    $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
                    
                    $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
                    $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
                    $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(25);
                    $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
                    $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(18);
                    $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(18);
                    $this->excel->getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true);
                    $this->excel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, 'SL No.');
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, 'Date');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, 'Application No.');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, 'Name');
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, 'Gender');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, 'Term');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, 'Stream');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, 'Receipt No.');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, 'Amount');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, 'Remarks');
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row, 'Father Name');
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row, 'Mother Name');
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('M'.$excel_row, 'Father Mobile');
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('N'.$excel_row, 'Mother Mobile');
                    $this->excel->getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true); 
                    $this->excel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
                    $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                    $this->excel->getActiveSheet()->getStyle('A1:H500')->applyFromArray($styleBorderArray);
            
                   
                    $filter['year']= $year;
                    $data['year'] = $year;
    
                    $sl = 1;
                    $excel_row = 4;
    
                    // log_message('debug','refund'.print_r($filter,true));
                    $studentInfo = $this->fee->getCancelReceiptInfoForReport($filter);
                //    log_message('debug','std'.print_r($studentInfo,true));
    
                        foreach($studentInfo as $std){
                          
                           // if($std->refund_amt >0){
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, $sl++);
                                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, date('d-m-Y',strtotime($std->refund_date)));
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, $std->application_no);
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, strtoupper($std->student_name));
                                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, $std->gender);
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, $std->term_name);
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, $std->stream_name);
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, $std->receipt_number);
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, $std->paid_amount);
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, $std->remarks);
                                
                                $this->excel->getActiveSheet()->getStyle('G' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
                                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':B'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $this->excel->getActiveSheet()->getStyle('D'.$excel_row.':I'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $this->excel->getActiveSheet()->getStyle('J'.$excel_row.':N'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $this->excel->getActiveSheet()->getStyle('O'.$excel_row.':R'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $excel_row++;
                                $total_paid_amt += $std->paid_amount;
                        }
                        $this->excel->getActiveSheet()->setCellValue('F'.$excel_row, 'TOTAL');
                        $this->excel->getActiveSheet()->getStyle('E'.$excel_row.':G'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $this->excel->getActiveSheet()->getStyle('E'.$excel_row.':G'.$excel_row)->getFont()->setBold(true);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,$total_paid_amt);
                        $this->excel->getActiveSheet()->getStyle('G' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
                        $this->excel->createSheet(); 
                    
                
                    $filename =  $report_type.'_Credit_Note_Report_-'.date('d-m-Y').'.xls'; //save our workbook as this file name
                    header('Content-Type: application/vnd.ms-excel'); //mime type
                    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                    header('Cache-Control: max-age=0'); //no cache
                                
                    //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                    //if you want to save it as .XLSX Excel 2007 format
                    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
                    ob_start();
                    setcookie('isDownLoaded',1);  
                    $objWriter->save("php://output");
                    }else{
                        $cellNameByStudentReport = array('G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
                // $filter['bank_settlement'] = $bank_settlement;
                $sheet = 0;
                    $this->excel->setActiveSheetIndex($sheet);
                    //name the worksheet
                    $this->excel->getActiveSheet()->setTitle("CREDIT NOTE REPORT");
                    $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:Q500');
                    //set Title content with some text
                    $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                    $this->excel->getActiveSheet()->setCellValue('A2', "Credit Note Report - ".$display_year);
                    $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                    $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                    $this->excel->getActiveSheet()->mergeCells('A1:H1');
                    $this->excel->getActiveSheet()->mergeCells('A2:H2');
                    $this->excel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
                    $this->excel->getActiveSheet()->getStyle('A2:H2')->getFont()->setBold(true);
                    $this->excel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('A1:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    
                    $excel_row = 3;
                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(14);
                    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(28);
                    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                    $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
                    $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
                    $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                    $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
                    
                    $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
                    $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
                    $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(25);
                    $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
                    $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(18);
                    $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(18);
                    $this->excel->getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true);
                    $this->excel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, 'SL No.');
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, 'Date');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, 'Application No.');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, 'Name');
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, 'Gender');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, 'Class');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, 'Stream');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, 'Receipt No.');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, 'Amount');
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, 'Remarks');
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row, 'Father Name');
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row, 'Mother Name');
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('M'.$excel_row, 'Father Mobile');
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('N'.$excel_row, 'Mother Mobile');
                    $this->excel->getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true); 
                    $this->excel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
                    $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                    $this->excel->getActiveSheet()->getStyle('A1:H500')->applyFromArray($styleBorderArray);
            
                   
                    $filter['year']= $year;
                    $data['year'] = $year;
    
                    $sl = 1;
                    $excel_row = 4;
    
                    // log_message('debug','refund'.print_r($filter,true));
                    $studentInfo = $this->fee->getCancelReceiptInfoForReportForGovt($filter);
                //    log_message('debug','std'.print_r($studentInfo,true));
    
                        foreach($studentInfo as $std){
                          
                           // if($std->refund_amt >0){
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, $sl++);
                                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, date('d-m-Y',strtotime($std->refund_date)));
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, $std->application_no);
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, strtoupper($std->student_name));
                                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, $std->gender);
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, $std->term_name);
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, $std->stream_name);
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, $std->receipt_number);
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, $std->paid_amount);
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, $std->remarks);
                                $this->excel->getActiveSheet()->getStyle('G' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
    
                                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':B'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $this->excel->getActiveSheet()->getStyle('D'.$excel_row.':I'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $this->excel->getActiveSheet()->getStyle('J'.$excel_row.':N'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $this->excel->getActiveSheet()->getStyle('O'.$excel_row.':R'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $excel_row++;
                                $total_paid_amt += $std->paid_amount;

                            //}
                        }
                        $this->excel->getActiveSheet()->setCellValue('F'.$excel_row, 'TOTAL');
                        $this->excel->getActiveSheet()->getStyle('E'.$excel_row.':G'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $this->excel->getActiveSheet()->getStyle('E'.$excel_row.':G'.$excel_row)->getFont()->setBold(true);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,$total_paid_amt);
                        $this->excel->getActiveSheet()->getStyle('G' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
                        $this->excel->createSheet(); 
                    
                
                    $filename =  $report_type.'_Credit_Note_Report_-'.date('d-m-Y').'.xls'; //save our workbook as this file name
                    header('Content-Type: application/vnd.ms-excel'); //mime type
                    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                    header('Cache-Control: max-age=0'); //no cache
                                
                    //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                    //if you want to save it as .XLSX Excel 2007 format
                    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
                    ob_start();
                    setcookie('isDownLoaded',1);  
                    $objWriter->save("php://output");
                    }
                    }
    
            }
        }

    public function downloadConcessionFeeReport(){
        if ($this->isAdmin() == true ) {
            setcookie('isDownLoaded',1);
            $this->loadThis();
        } else {
            set_time_limit(0);
            ini_set('memory_limit', '256M');
            $filter = array();
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $year = $this->security->xss_clean($this->input->post('year'));
            $reportFormat = $this->security->xss_clean($this->input->post('reportFormat'));
            $concession_status = $this->security->xss_clean($this->input->post('concession_status'));
            $display_year = $year . '-' . substr($year + 1, 2);
            // $term_name = $this->security->xss_clean($this->input->post('term_name'));
            if($reportFormat == 'VIEW'){
                setcookie('isDownLoaded',1);
                $data['dt_filter'] = $filter;
                $data['term_name']= $term_name;
                $data['year']= $year;
                $data['display_year']= $display_year;
                $data['fee'] = $this->fee;
                $data['student'] = $this->student;
                $data['concession_status']= $concession_status;
                $this->global['pageTitle'] = ''.TAB_TITLE.' : SCHOLARSHIP FEE REPORT';
                $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman']);
                $mpdf->AddPage('P','','','','',10,10,10,10,8,8);
                $mpdf->SetTitle('SCHOLARSHIP FEE REPORT');
                $html = $this->load->view('reports/concessionFeeReport',$data,true);
                $mpdf->WriteHTML($html);
                $mpdf->Output('CAN.pdf', 'I');
            }else{
                $cellNameByStudentReport = array('K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
                $sheet = 0;
                // for($sheet = 0; $sheet < count($stream);  $sheet++){
                $this->excel->setActiveSheetIndex($sheet);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle("SCHOLARSHIP FEE REPORT");
                $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:H500');
                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                $this->excel->getActiveSheet()->setCellValue('A2', "SCHOLARSHIP FEE REPORT - ".$term_name ." - ".$display_year);
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->mergeCells('A1:F1');
                $this->excel->getActiveSheet()->mergeCells('A2:F2');
                $this->excel->getActiveSheet()->getStyle('A1:A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row = 3;
                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(35);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
                // $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, 'SL No.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, 'Date');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, 'Application No.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, 'Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, 'Stream');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, 'Scholarship');
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, 'Order ID');
                $this->excel->getActiveSheet()->getStyle('A3:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                // $filter['date_from']= $date_from;
                // $filter['date_to']= $date_to;
                $filter['term_name']= $term_name;
                $filter['year']= $year;
                $filter['concession_status']= $concession_status;
                // $filter['term_name']= $term_name;
                $sl = 1;
                $excel_row = 4;
                $studentInfo = $this->fee->getConcessionFeeReport($filter);
                $this->excel->getActiveSheet()->getStyle('A1:F3')->getFont()->setBold(true);
                $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                $this->excel->getActiveSheet()->getStyle('A3:F3')->applyFromArray($styleBorderArray);
                foreach($studentInfo as $std){
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, $sl++);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, date('d-m-Y',strtotime($std->date)));
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, $std->application_no);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, strtoupper($std->student_name));
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, $std->stream_name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, $std->fee_amt);
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, $std->order_id);
                    $this->excel->getActiveSheet()->getStyle('F' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
                    $this->excel->getActiveSheet()->getStyle('A4:B'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('C'.$excel_row.':F'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                    $this->excel->getActiveSheet()->getStyle('A4:F'.$excel_row)->applyFromArray($styleBorderArray);
                    $excel_row++;
                    $total_fee_amt += $std->fee_amt;      
                }
                $this->excel->getActiveSheet()->setCellValue('E'.$excel_row, 'TOTAL');
                $this->excel->getActiveSheet()->getStyle('E'.$excel_row.':G'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('E'.$excel_row.':G'.$excel_row)->getFont()->setBold(true);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$total_fee_amt);
                $this->excel->getActiveSheet()->getStyle('F' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
                $this->excel->createSheet(); 
            }
            $filename =  'Scholarship_Fee-Report'.date('d-m-Y').'.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            ob_start();
            setcookie('isDownLoaded',1);
            $objWriter->save("php://output");  
        }          
    }

        public function downloadGovtFeeReport(){
            if ($this->isAdmin() == true ) {
                setcookie('isDownLoaded',1);  
                $this->loadThis();
            } else {
                $filter = array();
                $date_from = $this->security->xss_clean($this->input->post('date_from'));
                $date_to = $this->security->xss_clean($this->input->post('date_to'));
                $year = $this->security->xss_clean($this->input->post('year'));
                $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
                $term_name = $this->security->xss_clean($this->input->post('term_name'));
                $reportFormat = $this->security->xss_clean($this->input->post('reportFormat'));
                $student_type = $this->security->xss_clean($this->input->post('student_type'));
                $settlement_type = $this->security->xss_clean($this->input->post('settlement_type'));
                $display_year = $year . '-' . substr($year + 1, 2);
                // $term_name = $this->security->xss_clean($this->input->post('term_name'));
                if($reportFormat == 'VIEW'){
                    setcookie('isDownLoaded',1);  
                    $data['dt_filter'] = $filter;
                    $data['date_from']= $date_from;
                    $data['settlement_type'] = $settlement_type;
                    $data['date_to']= $date_to;
                    $data['payment_type']= $payment_type;
                    $data['student_type']= $student_type;
                    $data['year']= $year;
                    $data['term_name']= $term_name;
                    $data['display_year']= $display_year;
                    $data['fee'] = $this->fee;
                    $data['student'] = $this->student;
                    $this->global['pageTitle'] = ''.TAB_TITLE.' : GOVERNMENT FEE REPORT';
                    $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman']);
                    $mpdf->AddPage('P','','','','',10,10,10,10,8,8);
                    $mpdf->SetTitle('GOVERNMENT FEE REPORT');
                    $html = $this->load->view('reports/govtFeeReport',$data,true);
                    $mpdf->WriteHTML($html);
                    $mpdf->Output('CAN.pdf', 'D');
                }else{
                $sheet = 0;
                $this->excel->setActiveSheetIndex($sheet);
                //name the worksheet
                // $this->excel->getActiveSheet()->setTitle($stream[$sheet]);
                $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:T500');
                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                $this->excel->getActiveSheet()->setCellValue('A2', "Government Fee Report ". $display_year);
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->mergeCells('A1:S1');
                $this->excel->getActiveSheet()->mergeCells('A2:S2');
                $this->excel->getActiveSheet()->getStyle('A1:S1')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A2:S2')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A1:S1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A1:S2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
               
                $excel_row = 3;
                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
               
                $this->excel->getActiveSheet()->getStyle('A3:S3')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A3:S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, 'SL No.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, 'Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, 'Term');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, 'Stream');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, 'Section');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, 'Application No.');
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, 'Order ID');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, 'Receipt No.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, 'Payment Mode');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row, 'Transaction ID');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row, 'Transaction Date');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row, 'DD Number');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row, 'DD Date');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('M'.$excel_row, 'Bank Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('N'.$excel_row, 'Amount Paid');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('O'.$excel_row, 'Over Payment');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('P'.$excel_row, 'Payment Date');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('Q'.$excel_row, 'Bank Settlement Date');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('R'.$excel_row, 'Settlement Status');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('S'.$excel_row, 'Status');
         
                if($date_from != ''){
                    $filter['date_from'] = date('Y-m-d',strtotime($date_from));
                }else{
                    $filter['date_from'] = '';
                }
                if($date_to != ''){
                    $filter['date_to'] = date('Y-m-d',strtotime($date_to));
                }else{
                    $filter['date_to'] = '';
                }
         
                $filter['year']= $year;
         
                if($payment_type[0] == 'ALL'){
                    $filter['payment_type'] = '';
                }else{
                    $filter['payment_type'] = $payment_type;
                }
                if($settlement_type == "ALL"){
                    $filter['settlement_type'] = "";
                }else{
                    $filter['settlement_type'] = $settlement_type ;
                }
                $filter['term_name'] = $term_name;
                $sl = 1;
                $excelRow=4;
                $excel_row = 4;
                $sl = 1;
                // if($term_name == 'II PUC'){
                //     $filter['term_name'] = 'II PUC';
                //     $studentInfo = $this->payment->getDeptFee($filter);
                // }else if($term_name == 'I PUC'){
                //     $filter['term_name'] = 'I PUC';
                //     $studentInfo = $this->payment->getDeptFeeNew($filter);
                // }else{
                    $feeInfo = $this->fee->getGovtFeeForReport($filter);
                // }
               
                    foreach($feeInfo as $std){
                        $term_name = $std->term_name;
                       
                        $stdInfo = $this->student->getStudentForFeeReport($std->application_no,$year);
                       
                        $section_name = $stdInfo->section_name;
                        if(!empty($std->paid_amount)){
                            $total_fee = $std->paid_amount; //$this->payment->getDepartmentFee($std->stream_name,$term_name);
                        }
         
                        if(date('d-m-Y',strtotime($std->transaction_date)) == '30-11--0001' || date('d-m-Y',strtotime($std->transaction_date)) == '01-01-1970' || $std->transaction_date == '0000-00-00'){
                            $transaction_date = '';
                        }else{
                            $transaction_date = date('d-m-Y',strtotime($std->transaction_date));
                        }
         
                        if(date('d-m-Y',strtotime($std->bank_settlement_date)) == '30-11--0001' || date('d-m-Y',strtotime($std->bank_settlement_date)) == '01-01-1970' || $std->bank_settlement_date == '0000-00-00'){
                            $bank_settlement_date = '';
                        }else{
                            $bank_settlement_date = date('d-m-Y',strtotime($std->bank_settlement_date));
                        }
                        if($std->bank_settlement_status == 1){
                            $settlement_status = 'SETTLED';
                        }else{
                             $settlement_status = 'PENDING';
                        }

                        if(date('d-m-Y',strtotime($std->dd_date)) == '30-11--0001'|| date('d-m-Y',strtotime($std->dd_date)) == '01-01-1970'|| $std->dd_date == '0000-00-00'){
                            $dd_date = '';
                        }else{
                            $dd_date = date('d-m-Y',strtotime($std->dd_date));
                        }
                        if($stdInfo->discontinued_status == 1 || $stdInfo->is_deleted == 1){
                            $status = 'INACTIVE';
                        }else{
                            $status = 'ACTIVE';
                        }
                        if($status == $student_type){

                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, $sl++);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, strtoupper($stdInfo->student_name));
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, $term_name);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, $stdInfo->stream_name);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, $section_name);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, $stdInfo->application_no);
                            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, $std->order_id);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, $std->receipt_number);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, $std->payment_type);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValueExplicit('I'.$excel_row, $std->transaction_number);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row, $transaction_date);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValueExplicit('K'.$excel_row, $std->dd_number,PHPExcel_Cell_DataType::TYPE_STRING);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row, $dd_date);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('M'.$excel_row, $std->bank_name);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('N'.$excel_row, $total_fee);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('O'.$excel_row, $std->excess_amount);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('P'.$excel_row, date('d-m-Y',strtotime($std->payment_date)));
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('Q'.$excel_row, $bank_settlement_date);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('R'.$excel_row, $settlement_status);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('S'.$excel_row, $status);
                            $this->excel->getActiveSheet()->getStyle('N' . $excel_row. ':O' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
                            // $this->excel->getActiveSheet()->mergeCells('E'.$excel_row);
                            $this->excel->getActiveSheet()->getStyle('E'.$excel_row)->getAlignment()->setWrapText(true);
                            $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':A'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $this->excel->getActiveSheet()->getStyle('C'.$excel_row.':N'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $this->excel->getActiveSheet()->getStyle('O'.$excel_row.':S'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $excel_row++;
                            $row_no = $excel_row;
                            $cell_name = 'G';
                            $total_paid_amt += $total_fee;
                            $total_excess_amount += $std->excess_amount;
                        }else if($student_type == 'ALL'){
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, $sl++);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, strtoupper($stdInfo->student_name));
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, $term_name);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, $stdInfo->stream_name);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, $section_name);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, $stdInfo->application_no);
                            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, $std->order_id);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, $std->receipt_number);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, $std->payment_type);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValueExplicit('I'.$excel_row, $std->transaction_number);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row, $transaction_date);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValueExplicit('K'.$excel_row, $std->dd_number,PHPExcel_Cell_DataType::TYPE_STRING);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row, $dd_date);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('M'.$excel_row, $std->bank_name);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('N'.$excel_row, $total_fee);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('O'.$excel_row, $std->excess_amount);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('P'.$excel_row, date('d-m-Y',strtotime($std->payment_date)));
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('Q'.$excel_row, $bank_settlement_date);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('R'.$excel_row, $settlement_status);
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('S'.$excel_row, $status);
                            $this->excel->getActiveSheet()->getStyle('N' . $excel_row. ':O' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
                            // $this->excel->getActiveSheet()->mergeCells('E'.$excel_row);
                            $this->excel->getActiveSheet()->getStyle('E'.$excel_row)->getAlignment()->setWrapText(true);
                            $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':A'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $this->excel->getActiveSheet()->getStyle('C'.$excel_row.':N'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $this->excel->getActiveSheet()->getStyle('O'.$excel_row.':S'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $excel_row++;
                            $row_no = $excel_row;
                            $cell_name = 'G';
                            $total_paid_amt += $total_fee;
                            $total_excess_amount += $std->excess_amount;
                        }
                    }
                    $this->excel->getActiveSheet()->setCellValue('M'.$excel_row, 'TOTAL');
                    $this->excel->getActiveSheet()->getStyle('M'.$excel_row.':P'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('M'.$excel_row.':P'.$excel_row)->getFont()->setBold(true);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('N'.$excel_row,number_format($total_paid_amt,2));
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('O'.$excel_row,number_format($total_excess_amt,2));
                    $this->excel->createSheet();
               
               
                $filename =  'Government_Fee_Report_-'.date('d-m-Y').'.xls'; //save our workbook as this file name
                header('Content-Type: application/vnd.ms-excel'); //mime type
                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache
                           
                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                //if you want to save it as .XLSX Excel 2007 format
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
                ob_start();
                setcookie('isDownLoaded',1);  
                $objWriter->save("php://output");
                }
            }
               
        }

        
public function downloadManagementFeeReport(){
    if ($this->isAdmin() == true ) {
        setcookie('isDownLoaded',1);  
        $this->loadThis();
    } else {
        ini_set('memory_limit', '1024M');
        ini_set("pcre.backtrack_limit", "5000000");
        ini_set('max_execution_time', -1);
        $filter = array();
        $date_from = $this->security->xss_clean($this->input->post('date_from'));
        $date_to = $this->security->xss_clean($this->input->post('date_to'));
        $year = $this->security->xss_clean($this->input->post('year'));
        $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
        $term_name = $this->security->xss_clean($this->input->post('term_name'));
        $reportFormat = $this->security->xss_clean($this->input->post('reportFormat'));
        $student_type = $this->security->xss_clean($this->input->post('student_type'));
        $display_year = $year . '-' . substr($year + 1, 2);
        $settlement_type = $this->security->xss_clean($this->input->post('settlement_type'));
        if($reportFormat == 'VIEW'){
            setcookie('isDownLoaded',1);  
            $data['dt_filter'] = $filter;
            $data['date_from']= $date_from;
            $data['date_to']= $date_to;
            $data['payment_type']= $payment_type;
            $data['student_type'] = $student_type;
            $data['year']= $year;
            $data['term_name']= $term_name;
            $data['display_year']= $display_year;
            $data['fee'] = $this->fee;
            $data['student'] = $this->student;
            $data['settlement_type'] = $settlement_type;
            $this->global['pageTitle'] = ''.TAB_TITLE.' : MANAGEMENT FEE REPORT';
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman']);
            $mpdf->AddPage('P','','','','',10,10,10,10,8,8);
            $mpdf->SetTitle('MANAGEMENT FEE REPORT');
            $html = $this->load->view('reports/mgmtFeeReport',$data,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('CAN.pdf', 'D');
        }else{
        $sheet = 0;
        $this->excel->setActiveSheetIndex($sheet);
        //name the worksheet
        // $this->excel->getActiveSheet()->setTitle($stream[$sheet]);
        $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:T500');
        //set Title content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
        $this->excel->getActiveSheet()->setCellValue('A2', "Management Fee Report - ". $display_year);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
        $this->excel->getActiveSheet()->mergeCells('A1:J1');
        $this->excel->getActiveSheet()->mergeCells('A2:J2');
        $this->excel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2:J2')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A1:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $excel_row = 3;
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(18);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(18);
        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(18);
        $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(15);


        $this->excel->getActiveSheet()->getStyle('A3:S3')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A3:S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, 'SL No.');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, 'Name');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, 'Term');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, 'Stream');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, 'Section');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, 'Application No.');
        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, 'Order ID');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, 'Receipt No.');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, 'Payment Mode');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row, 'Transaction ID');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row, 'Transaction Date');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row, 'DD Number');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row, 'DD Date');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('M'.$excel_row, 'Bank Name');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('N'.$excel_row, 'Amount Paid');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('O'.$excel_row, 'Over Payment');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('P'.$excel_row, 'Payment Date');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('Q'.$excel_row, 'Bank Settlement Date');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('R'.$excel_row, 'Settlement Status');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('S'.$excel_row, 'Status');

        if($date_from != ''){
            $filter['date_from'] = date('Y-m-d',strtotime($date_from));
        }else{
            $filter['date_from'] = '';
        }
        if($date_to != ''){
            $filter['date_to'] = date('Y-m-d',strtotime($date_to));
        }else{
            $filter['date_to'] = '';
        }

        $filter['year']= $year;

        if($payment_type[0] == 'ALL'){
            $filter['payment_type'] = '';
        }else{
            $filter['payment_type'] = $payment_type;
        }
        $filter['term_name'] = $term_name;
        if($filter['settlement_type']=="ALL"){
            $filter['settlement_type'] = "";
        }else{
            $filter['settlement_type'] = $settlement_type;
        }
        $sl = 1;
        $excelRow=4;
        $excel_row = 4;
        $sl = 1;

        // if($term_name == 'II PUC'){
        //     $filter['term_name'] = 'II PUC';
        //     $studentInfo = $this->payment->getManagementFee($filter);
        // }else{
        //    $filter['term_name'] = 'I PUC';
        //     $studentInfo = $this->payment->getManagementFeeNew($filter);
        //    // log_message('debug','as'.print_r($filter,true));
        // }
       
        $studentInfo = $this->fee->getManagementFeeForReport($filter);

            foreach($studentInfo as $std){
                $term_name = $std->term_name;
                $stdInfo = $this->student->getStudentForFeeReport($std->application_no,$year);
               
                $section_name = $stdInfo->section_name;
                

                if(date('d-m-Y',strtotime($std->transaction_date)) == '30-11--0001' || date('d-m-Y',strtotime($std->transaction_date)) == '01-01-1970' || $std->transaction_date == '0000-00-00'){
                    $transaction_date = '';
                }else{
                    $transaction_date = date('d-m-Y',strtotime($std->transaction_date));
                }

                if(date('d-m-Y',strtotime($std->dd_date)) == '30-11--0001'|| date('d-m-Y',strtotime($std->dd_date)) == '01-01-1970'|| $std->dd_date == '0000-00-00'){
                    $dd_date = '';
                }else{
                    $dd_date = date('d-m-Y',strtotime($std->dd_date));
                }

                if(date('d-m-Y',strtotime($std->bank_settlement_date)) == '30-11--0001' || date('d-m-Y',strtotime($std->bank_settlement_date)) == '01-01-1970' || $std->bank_settlement_date == '0000-00-00'){
                    $bank_settlement_date = '';
                }else{
                    $bank_settlement_date = date('d-m-Y',strtotime($std->bank_settlement_date));
                }
                if($std->bank_settlement_status == 1){
                    $settlement_status = 'SETTLED';
                }else{
                    $settlement_status = 'PENDING';
                }
                if($stdInfo->discontinued_status == 1 || $stdInfo->is_deleted == 1){
                    $status = 'INACTIVE';
                 }else{
                    $status = 'ACTIVE';
                 }
            if($status == $student_type){

                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, $sl++);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, strtoupper($stdInfo->student_name));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, $term_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, $stdInfo->stream_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, $section_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, $stdInfo->application_no);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, $std->receipt_number);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, $std->payment_type);
                $this->excel->setActiveSheetIndex($sheet)->setCellValueExplicit('I'.$excel_row, $std->transaction_number);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row, $transaction_date);
                $this->excel->setActiveSheetIndex($sheet)->setCellValueExplicit('K'.$excel_row, $std->dd_number,PHPExcel_Cell_DataType::TYPE_STRING);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row, $dd_date);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('M'.$excel_row, $std->bank_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('N'.$excel_row, $std->paid_amount);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('O'.$excel_row, $std->excess_amount);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('P'.$excel_row, date('d-m-Y',strtotime($std->payment_date)));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('Q'.$excel_row, $bank_settlement_date);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('R'.$excel_row,$settlement_status);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('S'.$excel_row,$status);  
                $this->excel->getActiveSheet()->getStyle('N' . $excel_row. ':O' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
                $this->excel->getActiveSheet()->getStyle('E'.$excel_row)->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':A'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C'.$excel_row.':N'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('O'.$excel_row.':S'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
                $row_no = $excel_row;
                $cell_name = 'G';
                $total_paid_amt += $std->paid_amount;   
                $total_excess_amt += $std->excess_amount; 
            }else if($student_type == 'ALL'){
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, $sl++);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, strtoupper($stdInfo->student_name));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, $term_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, $stdInfo->stream_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, $section_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, $stdInfo->application_no);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, $std->receipt_number);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, $std->payment_type);
                $this->excel->setActiveSheetIndex($sheet)->setCellValueExplicit('I'.$excel_row, $std->transaction_number);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row, $transaction_date);
                $this->excel->setActiveSheetIndex($sheet)->setCellValueExplicit('K'.$excel_row, $std->dd_number,PHPExcel_Cell_DataType::TYPE_STRING);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row, $dd_date);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('M'.$excel_row, $std->bank_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('N'.$excel_row, $std->paid_amount);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('O'.$excel_row, $std->excess_amount);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('P'.$excel_row, date('d-m-Y',strtotime($std->payment_date)));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('Q'.$excel_row, $bank_settlement_date);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('R'.$excel_row,$settlement_status);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('S'.$excel_row,$status); 
                $this->excel->getActiveSheet()->getStyle('N' . $excel_row. ':O' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
                $this->excel->getActiveSheet()->getStyle('E'.$excel_row)->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':A'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C'.$excel_row.':N'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('O'.$excel_row.':S'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
                $row_no = $excel_row;
                $cell_name = 'G';
                $total_paid_amt += $std->paid_amount;   
                $total_excess_amt += $std->excess_amount; 
            }
            }
            $this->excel->getActiveSheet()->setCellValue('M'.$excel_row, 'TOTAL');
            $this->excel->getActiveSheet()->getStyle('M'.$excel_row.':P'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('M'.$excel_row.':P'.$excel_row)->getFont()->setBold(true);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('N'.$excel_row,number_format($total_paid_amt,2));
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('O'.$excel_row,number_format($total_excess_amt,2));
           
            $this->excel->createSheet(); 
        
        
        $filename =  'Management_Fee_Report_-'.date('d-m-Y').'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        ob_start();
        setcookie('isDownLoaded',1);  
        $objWriter->save("php://output");
        }
    }
        
}



public function downloadBankDepositReport(){ 
    if ($this->isAdmin() == true ) {
        setcookie('isDownLoaded',1);  
        $this->loadThis();
    } else {
        $filter = array();
        $date_from = $this->security->xss_clean($this->input->post('date_from'));
        $date_to = $this->security->xss_clean($this->input->post('date_to'));
        $deposit_type = $this->security->xss_clean($this->input->post('deposit_type')); 

        $reportFormat = $this->security->xss_clean($this->input->post('reportFormat'));
        if($reportFormat == 'VIEW'){
            setcookie('isDownLoaded',1);  
            $data['dt_filter'] = $filter;
            $data['date_from']= $date_from;
            $data['date_to']= $date_to;
            $data['deposit_type']= $deposit_type;
            
            $this->global['pageTitle'] = ''.TAB_TITLE.' : BANK DEPOSIT REPORT';
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman']);
            $mpdf->AddPage('P','','','','',10,10,10,10,8,8);
            $mpdf->SetTitle('BANK DEPOSIT REPORT');
            // $html = $this->load->view('reports/bankDeposit',$data,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('CAN.pdf', 'I'); 
        }else{
        $sheet = 0;
        $this->excel->setActiveSheetIndex($sheet);
        //name the worksheet
        // $this->excel->getActiveSheet()->setTitle($stream[$sheet]);
        $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');
        //set Title content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
        $this->excel->getActiveSheet()->setCellValue('A2', "Bank Deposit Report ". EXCEL_YEAR);
        $this->excel->getActiveSheet()->setCellValue(
            'A3',
            "Date From: " . date('d-m-Y', strtotime($date_from)) . "  Date To: " . date('d-m-Y', strtotime($date_to))
        );
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
        $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14);
        $this->excel->getActiveSheet()->mergeCells('A1:G1');
        $this->excel->getActiveSheet()->mergeCells('A2:G2');
        $this->excel->getActiveSheet()->mergeCells('A3:G3');
        $this->excel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2:G2')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A3:G3')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A1:G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A1:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       
        $excel_row = 5;
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        // $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
        $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                    $this->excel->getActiveSheet()->getStyle('A5:G500'.$excel_row)->applyFromArray($styleBorderArray);
       
        $this->excel->getActiveSheet()->getStyle('A5:G5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A5:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, 'SL No.');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, 'Date');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, 'Depositer Name');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, 'Deposit Amount');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, 'Deposit Type');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, 'Deposit Account');
        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, 'Uploded Slip');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, 'Remarks');
 
        if($date_from != ''){
            $filter['date_from'] = date('Y-m-d',strtotime($date_from));
        }else{
            $filter['date_from'] = '';
        }
        if($date_to != ''){
            $filter['date_to'] = date('Y-m-d',strtotime($date_to));
        }else{
            $filter['date_to'] = '';
        }
        
        if (is_array($deposit_type)) {
            if (in_array('ALL', $deposit_type)) {
                // No filtering for ALL
                unset($filter['deposit_type']);
            } else {
                // Filter by selected types
                $filter['deposit_type'] = $deposit_type;
            }
        } else {
            if ($deposit_type === 'ALL') {
                unset($filter['deposit_type']);
            } else {
                $filter['deposit_type'] = [$deposit_type];
            }
        }

        // if (is_array($deposit_account)) {
        //     if (in_array('ALL', $deposit_account)) {
        //         // No filtering for ALL
        //         unset($filter['deposit_account']);
        //     } else {
        //         // Filter by selected types
        //         $filter['deposit_account'] = $deposit_account;
        //     }
        // } else {
        //     if ($deposit_account === 'ALL') {
        //         unset($filter['deposit_account']);
        //     } else {
        //         $filter['deposit_account'] = [$deposit_account];
        //     }
        // }
 
        // $filter['year']= $year;
 
        // if($deposit_type[0] == 'ALL'){
        //     $filter['deposit_type'] = '';
        // }else{
        //     $filter['deposit_type'] = $deposit_type;
        // }
        $filter['depositer_name'] = $depositer_name;
        $sl = 1;
        $excelRow=5;
        $excel_row = 6;
        $sl = 1;
        
        $bankdepositInfo = $this->bank->getBankDepositReport($filter);
       
            foreach($bankdepositInfo as $std){
                $depositer_name = $std->depositer_name;
                if(date('d-m-Y',strtotime($std->date)) == '30-11--0001'|| date('d-m-Y',strtotime($std->date)) == '01-01-1970'|| $std->date == '0000-00-00'){
                    $dd_date = '';
                }else{
                    $dd_date = date('d-m-Y',strtotime($std->date));
                }
                
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, $sl++);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, date('d-m-Y',strtotime($std->date)));
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, strtoupper($std->depositer_name));
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, $std->amount);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, $std->deposit_type);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, $std->deposit_account);
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, $std->document_name_url);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, $std->description);
                    $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':A'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('B'.$excel_row.':G'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel_row++;
                }
            }
            $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':G'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':G'.$excel_row)->getFont()->setBold(true);
            $this->excel->createSheet();
       
       
        $filename =  'Bank_Deposit_Report_-'.date('d-m-Y').'.xls'; 
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); 
        header('Cache-Control: max-age=0'); 
                   
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        ob_start();
        setcookie('isDownLoaded',1);  
        $objWriter->save("php://output");
        }
    }
       


    public function getAllMeritListByApproved()
    {

        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $type = $this->security->xss_clean($this->input->post('type'));
            $preference = $this->security->xss_clean($this->input->post('preference'));
            $board_name = $this->security->xss_clean($this->input->post('board_name'));
            $percentage_from = $this->security->xss_clean($this->input->post('percentage_from'));
            $percentage_to = $this->security->xss_clean($this->input->post('percentage_to'));
            $student_type = $this->security->xss_clean($this->input->post('student_type'));

            $category = array(
                'ROMAN CATHOLIC',
                'OTHER CHRISTIANS',
                'GENERAL MERIT(GM)',
                'SC',
                'ST',
                'CAT-I',
                '2A',
                '3A',
                '2B',
                '3B'
            );



            for ($sheet = 0; $sheet < count($category); $sheet++) {
                $this->excel->setActiveSheetIndex($sheet);
                //name the worksheet

                $this->excel->getActiveSheet()->setTitle($category[$sheet]);
                $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');

                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', "ST JOSEPH'S PRE-UNIVERSITY COLLEGE HASSAN");
                $this->excel->getActiveSheet()->setCellValue('A2', "I PUC " . $preference . " MERIT LIST 2021-2022");
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->mergeCells('A1:G1');
                $this->excel->getActiveSheet()->mergeCells('A2:G2');
                $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);


                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);



                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL. NO.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Application Number');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Board');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Preferences');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Category');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Percentage');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H3', 'PH');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I3', 'Dyslexia');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J3', 'NCC');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K3', 'Sports');
                $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->getStyle('A3:K3')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



                $this->excel->getActiveSheet()->mergeCells('A4:K4');
                $this->excel->getActiveSheet()->getStyle('A4:K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->setCellValue('A4', $category[$sheet] . "- LIST");
                $this->excel->getActiveSheet()->getStyle('A4:K4')->getFont()->setBold(true);



                $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                $this->excel->getActiveSheet()->getStyle('A1:G4')->applyFromArray($styleBorderArray);

                $students = $this->application->getMertListDetailsApproved($preference, $category[$sheet], $board_name, $percentage_from, $percentage_to, $type, $student_type);
                $j = 1;

                $excel_row = 5;
                if ($student_type == 'NCC') {
                    $student_type_print = 'NCC';
                } else if ($student_type == 'SPORTS') {
                    $student_type_print = 'SPORTS';
                } else if ($student_type == 'DYC') {
                    $student_type_print = 'Dyslexia';
                } else if ($student_type == 'PH') {
                    $student_type_print = 'PH';
                } else {
                    $student_type_print = 'ALL';
                }

                foreach ($students as $student) {
                    if ($student->board_name == 'KARNATAKA STATE BOARD') {
                        $board_name_sheet = 'SSLC';
                    } else if ($student->board_name == 'OTHER') {
                        $board_name_sheet = 'OTHERS';
                    } else {
                        $board_name_sheet = $student->board_name;
                    }

                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $j++);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $student->application_number);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $student->name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $board_name_sheet);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $student->stream_name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $student->student_category);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $student->sslc_percentage);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $student->dyslexia_challenged);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row, $student->physically_challenged);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('J' . $excel_row, $student->ncc_certificate_status);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('K' . $excel_row, $student->national_level_sports_status);
                    $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':K' . $excel_row)->applyFromArray($styleBorderArray);
                    $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('D' . $excel_row . ':K' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel_row++;
                }

                $this->excel->createSheet();
            }
            $filename = 'just_some_random_name.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache


            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            $objWriter->save("php://output");
            setcookie('isDownLoaded', 1);
            $xlsData = ob_get_contents();
            ob_end_clean();



            $response =  array(
                'op' => 'ok',
                'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
            );
            die(json_encode($response));
        }
    }


    public function getAllMeritList()
    {
        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {

            $category_by = $this->security->xss_clean($this->input->post('by_category'));

            $type = $this->security->xss_clean($this->input->post('type'));

            $preference = $this->security->xss_clean($this->input->post('preference'));

            $board_name = $this->security->xss_clean($this->input->post('board_name'));

            $percentage_from = $this->security->xss_clean($this->input->post('percentage_from'));

            $percentage_to = $this->security->xss_clean($this->input->post('percentage_to'));

            $student_type = $this->security->xss_clean($this->input->post('student_type'));

            $category = array(

                'ROMAN CATHOLIC',

                'OTHER CHRISTIANS',

                'GENERAL MERIT(GM)',

                'SC',

                'ST',

                'CAT-I',

                '2A',

                '3A',

                '2B',

                '3B'
            );



            $j = 1;

            $excel_row = 5;

            $this->excel->setActiveSheetIndex(0);

            //name the worksheet

            $this->excel->getActiveSheet()->setTitle($preference);

            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');

            $this->excel->getActiveSheet()->setCellValue('A1', "ST JOSEPH'S PRE-UNIVERSITY COLLEGE HASSAN");

            $this->excel->getActiveSheet()->setCellValue('A2', "I PUC " . $preference . " MERIT LIST 2021-2022");

            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);

            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

            $this->excel->getActiveSheet()->mergeCells('A1:G1');

            $this->excel->getActiveSheet()->mergeCells('A2:G2');

            $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $this->excel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);





            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);

            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);

            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);

            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18);

            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);

            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);

            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);



            $this->excel->setActiveSheetIndex(0)->setCellValue('A3', 'SL. NO.');

            $this->excel->setActiveSheetIndex(0)->setCellValue('B3', 'Application Number');

            $this->excel->setActiveSheetIndex(0)->setCellValue('C3', 'Name');

            $this->excel->setActiveSheetIndex(0)->setCellValue('D3', 'Board');

            $this->excel->setActiveSheetIndex(0)->setCellValue('E3', 'Preferences');

            $this->excel->setActiveSheetIndex(0)->setCellValue('F3', 'Category');

            $this->excel->setActiveSheetIndex(0)->setCellValue('G3', 'Percentage');



            $this->excel->setActiveSheetIndex(0)->setCellValue('H3', 'Elective');

            $this->excel->setActiveSheetIndex(0)->setCellValue('I3', 'Religion');

            $this->excel->setActiveSheetIndex(0)->setCellValue('J3', 'Student Id');

            $this->excel->setActiveSheetIndex(0)->setCellValue('K3', 'Section');



            $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setWrapText(true);

            $this->excel->getActiveSheet()->getStyle('A3:K3')->getFont()->setBold(true);

            $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $this->excel->getActiveSheet()->mergeCells('A4:K4');

            $this->excel->getActiveSheet()->getStyle('A4:K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $this->excel->getActiveSheet()->setCellValue('A4', $board_name . "- LIST");

            $this->excel->getActiveSheet()->getStyle('A4:K4')->getFont()->setBold(true);



            if ($student_type == 'NCC') {

                $student_type_print = 'NCC';
            } else if ($student_type == 'SPORTS') {

                $student_type_print = 'SPORTS';
            } else if ($student_type == 'DYC') {

                $student_type_print = 'Dyslexia';
            } else if ($student_type == 'PH') {

                $student_type_print = 'PH';
            } else {

                $student_type_print = 'ALL';
            }

            for ($sheet = 0; $sheet < count($category); $sheet++) {



                //set Title content with some text



                $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

                $this->excel->getActiveSheet()->getStyle('A1:G4')->applyFromArray($styleBorderArray);



                $students = $this->application->getMertListDetails($preference, $category[$sheet], $board_name, $percentage_from, $percentage_to, $type, $student_type);



                foreach ($students as $student) {

                    if ($student->board_name == 'KARNATAKA STATE BOARD') {

                        $board_name_sheet = 'SSLC';
                    } else if ($student->board_name == 'OTHER') {

                        $board_name_sheet = 'OTHERS';
                    } else {

                        $board_name_sheet = $student->board_name;
                    }

                    if ($student->student_category == 'ROMAN CATHOLIC') {

                        $qouta_name = 'RC';
                    } else if ($student->student_category == 'OTHER CHRISTIANS') {

                        $qouta_name = 'CHR';
                    } else if ($student->student_category == 'GENERAL MERIT(GM)') {

                        $qouta_name = 'GM';
                    } else if ($student->student_category == 'SC') {

                        $qouta_name = 'SC';
                    } else if ($student->student_category == 'ST') {

                        $qouta_name = 'ST';
                    } else if ($student->student_category == 'CAT-I') {

                        $qouta_name = 'CAT-I';
                    } else if ($student->student_category == '2A') {

                        $qouta_name = '2A';
                    } else if ($student->student_category == '2B') {

                        $qouta_name = '2B';
                    } else if ($student->student_category == '3A') {

                        $qouta_name = '3A';
                    } else if ($student->student_category == '3B') {

                        $qouta_name = '3B';
                    }

                    $this->excel->setActiveSheetIndex(0)->setCellValue('A' . $excel_row, $j++);

                    $this->excel->setActiveSheetIndex(0)->setCellValue('B' . $excel_row, $student->application_number);

                    $this->excel->setActiveSheetIndex(0)->setCellValue('C' . $excel_row, $student->name);

                    $this->excel->setActiveSheetIndex(0)->setCellValue('D' . $excel_row, $board_name_sheet);

                    $this->excel->setActiveSheetIndex(0)->setCellValue('E' . $excel_row, $student->stream_name);

                    $this->excel->setActiveSheetIndex(0)->setCellValue('F' . $excel_row, $qouta_name);

                    $this->excel->setActiveSheetIndex(0)->setCellValue('G' . $excel_row, $student->sslc_percentage);

                    $this->excel->setActiveSheetIndex(0)->setCellValue('H' . $excel_row, $student->second_language);

                    $this->excel->setActiveSheetIndex(0)->setCellValue('I' . $excel_row, $student->religion);

                    $this->excel->setActiveSheetIndex(0)->setCellValue('J' . $excel_row, "");

                    $this->excel->setActiveSheetIndex(0)->setCellValue('K' . $excel_row, "");

                    $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':K' . $excel_row)->applyFromArray($styleBorderArray);

                    $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $this->excel->getActiveSheet()->getStyle('D' . $excel_row . ':K' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $excel_row++;
                }

                // $this->excel->createSheet(); 

            }

            $filename = 'just_some_random_name.xls'; //save our workbook as this file name

            header('Content-Type: application/vnd.ms-excel'); //mime type

            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name

            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format

            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

            ob_start();

            $objWriter->save("php://output");
            setcookie('isDownLoaded', 1);

            $xlsData = ob_get_contents();

            ob_end_clean();



            $response =  array(

                'op' => 'ok',

                'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)

            );

            die(json_encode($response));
        }
    }

    public function downloadFeePaidReport()
    {
        if ($this->isAdmin() == true) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            $term_name = $this->security->xss_clean($this->input->post('term_name_select'));
            $stream_name = $this->security->xss_clean($this->input->post('preference'));
            $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
            $student_type = $this->security->xss_clean($this->input->post('student_type'));

            $year = $this->security->xss_clean($this->input->post('year'));
            $reportFormat = $this->security->xss_clean($this->input->post('reportFormat'));
            $display_year = $year . '-' . substr($year + 1, 2);
            if($reportFormat == 'VIEW'){
                setcookie('isDownLoaded', 1);
                $data['dt_filter'] = $filter;
                $data['term_name']= $term_name;
                $data['stream_name']= $stream_name;
                $data['payment_type']= $payment_type;
                $data['student_type']= $student_type;
                $data['year']= $year;
                $data['display_year']= $display_year;
                $data['fee'] = $this->fee;
                $data['student'] = $this->student;
                $this->global['pageTitle'] = ''.TAB_TITLE.' : FEE PAID REPORT';
                $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman']);
                $mpdf->AddPage('P','','','','',10,10,10,10,8,8);
                $mpdf->SetTitle(' FEE PAID REPORT');
                $html = $this->load->view('reports/feePaidReportView',$data,true);
                $mpdf->WriteHTML($html);
                $mpdf->Output('CAN.pdf', 'I');
            }else{
            
            // log_message('debug','year'.$year);
            $spreadsheet = new Spreadsheet();
            $headerFontSize = [
                'font' => [
                    'size' => 16,
                    'bold' => true,
                ]
            ];
            $font_style_total = [
                'font' => [
                    'size' => 12,
                    'bold' => true,
                ]
            ];
            $filter['term_name'] = $term_name;
            $filter['payment_type'] = $payment_type;

            //$streamInfo = $this->staff->getStaffSectionByTerm($filter);

            $spreadsheet->getProperties()
                ->setCreator("SJPUC")
                ->setLastModifiedBy($this->staff_id)
                ->setTitle("SJPUC Fee Info")
                ->setSubject("Fee Structure")
                ->setDescription(
                    "SJPUC"
                )
                ->setKeywords("SJPUC")
                ->setCategory("Fee");
            $i = 0;

            $yearDisplay = $year . '-' . substr($year + 1, -2);

            $spreadsheet->setActiveSheetIndex(0);
            $spreadsheet->getActiveSheet()->setTitle('FEE');
            $spreadsheet->getActiveSheet()->setCellValue('A1',EXCEL_TITLE);
            $spreadsheet->getActiveSheet()->mergeCells("A1:K1");
            $spreadsheet->getActiveSheet()->getStyle("A1:A1")->applyFromArray($headerFontSize);

            $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->setCellValue('A2', $term_name . " FEES PAID REPORT " .$yearDisplay);
            $spreadsheet->getActiveSheet()->mergeCells("A2:K2");
            $spreadsheet->getActiveSheet()->getStyle("A2:A2")->applyFromArray($headerFontSize);
            $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal('center');

            $spreadsheet->getActiveSheet()->setCellValue('A3', 'SL No');
            $spreadsheet->getActiveSheet()->setCellValue('B3', 'Application No');
            // $spreadsheet->getActiveSheet()->setCellValue('C3', 'Application No');
            $spreadsheet->getActiveSheet()->setCellValue('C3', 'Name');
            // $spreadsheet->getActiveSheet()->setCellValue('E3', 'Lang');
            $spreadsheet->getActiveSheet()->setCellValue('D3', 'Stream');
            // $spreadsheet->getActiveSheet()->setCellValue('G3', 'SC/ST/CATI');
            $spreadsheet->getActiveSheet()->setCellValue('E3', 'Total Amt.');
            // $spreadsheet->getActiveSheet()->setCellValue('I3', 'French Fee');
            $spreadsheet->getActiveSheet()->setCellValue('F3', 'Total Fee Paid');
            $spreadsheet->getActiveSheet()->setCellValue('G3', 'Concession');
            $spreadsheet->getActiveSheet()->setCellValue('H3', 'Pending');
            $spreadsheet->getActiveSheet()->setCellValue('I3', 'Excess Amt');
            $spreadsheet->getActiveSheet()->setCellValue('J3', 'Status');
            $spreadsheet->getActiveSheet()->getStyle("A3:K3")->applyFromArray($font_style_total);
            $spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('I3')->getAlignment()->setWrapText(true);
            // $feeTypeInfo = $this->fee->getAllFeeTypesForByStatus(1);

            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:I500')->applyFromArray($styleBorderArray);

            $spreadsheet->getActiveSheet()->getStyle('A3:J3')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'E5E4E2')
                    ),
                    'font'  => array(
                        'bold'  =>  true
                    )
                )
            );


            $spreadsheet->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('A:B')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('D:K')->getAlignment()->setHorizontal('center');

            $excel_row = 4;
            $sl_number = 1;
            $total_sslc_state_fee = 0;
            $total_cbse_icse_fee = 0;
            $total_nri_fee = 0;
            $sum_of_total_fee = 0;
            $total_Paid_amt = 0; 
            $total_fee_concession = 0; 
            $total_pending_balance = 0; 
            $total_excess_amount = 0;
            $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);
           
            // foreach($feeTypeInfo as $type){
            if ($term_name == 'I PUC') {

                $studentInfo = $this->student->getAllStudentInfo_For_Fee_report($term_name,$stream_name,$year);
            
                foreach ($studentInfo as $std) {
                    $filter['fee_year'] = $year;
                    $filter['term_name'] = 'I PUC';
                    $filter['stream_name'] = $std->stream_name;
                   
                    $total_fee = $this->fee->getTotalFeeAmountForReport($filter);
                    $total_fee_amount = $total_fee->total_fee;
                    $total_paid_amount = $this->fee->getFeePaidInfoForReport($std->stud_row_id,$year);
                    $total_govt_paid_amount = $this->fee->getGovtFeePaidInfoForReport($std->stud_row_id,$year);

                    if($total_paid_amount->paid_amount == ''){
                        $paid_amt = 0;
                    }else{
                        $paid_amt = $total_paid_amount->paid_amount + $total_govt_paid_amount->paid_amount;
                    }
                    $feeConcession = $this->fee->getStudFeeConcession($std->stud_row_id,$year);
                    $pending_bal = $total_fee_amount - $paid_amt - $feeConcession->fee_amt;
                    if($std->discontinued_status == 1){
                        $status = 'INACTIVE';
                     }else{
                        $status = 'ACTIVE';
                     }
                    if($paid_amt > $total_fee_amount){
                        $excess_paid_amt = abs($paid_amt - $total_fee_amount);
                    }else{
                        $excess_paid_amt = 0;
                    }
             if($status == $student_type){

                    if($payment_type == 'FULL_PAYMENT'){

                        if($pending_bal <= 0){
                            $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                            $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                            $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->application_no);
                            // $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
                            $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
                            $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);
                        
                            $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fee_amount);
                        
                            $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
                            $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $feeConcession->fee_amt);
                            $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount - $paid_amt - $feeConcession->fee_amt);
                            $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $excess_paid_amt);
                            $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $status);

                            $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
                            $spreadsheet->getActiveSheet()->getStyle('E' . $excel_row. ':I' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
                            $total_Paid_amt += $paid_amt; 
                            $total_fee_concession += $feeConcession->fee_amt; 
                            $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                            $sum_of_total_fee += $total_fee_amount;
                            $total_excess_amount += $excess_paid_amt;
                            $sl_number++;
                            $excel_row++;
                        }
                    }else if($payment_type == 'HALF_PAYMENT'){
                        if($pending_bal < $total_fee_amount && $pending_bal > 0){
                                $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                            $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                            $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->application_no);
                            // $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
                            $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
                            $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);
                        
                            $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fee_amount);
                        
                            $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
                            $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $feeConcession->fee_amt);
                            $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount - $paid_amt - $feeConcession->fee_amt);
                            $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $excess_paid_amt);
                            $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $status);

                            $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
                            $spreadsheet->getActiveSheet()->getStyle('E' . $excel_row. ':I' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
                            $total_Paid_amt += $paid_amt; 
                            $total_fee_concession += $feeConcession->fee_amt; 
                            $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                            $sum_of_total_fee += $total_fee_amount;
                            $total_excess_amount += $excess_paid_amt;
                            $sl_number++;
                            $excel_row++;
                        }
                    }else if($payment_type == 'NOT_PAID'){
                    if($paid_amt == 0 && $status == 'ACTIVE'){
                        $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                        $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                        $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->application_no);
                        // $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
                        $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
                        $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);
                    
                        $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fee_amount);
                    
                        $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
                        $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $feeConcession->fee_amt);
                        $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount - $paid_amt - $feeConcession->fee_amt);
                        $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $excess_paid_amt);
                        $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $status);
                        $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
                        $spreadsheet->getActiveSheet()->getStyle('E' . $excel_row. ':I' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
                        $total_Paid_amt += $paid_amt; 
                        $total_fee_concession += $feeConcession->fee_amt; 
                        $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                        $sum_of_total_fee += $total_fee_amount;
                        $total_excess_amount += $excess_paid_amt;
                        $sl_number++;
                        $excel_row++;
                    }
                }else if($payment_type == 'PENDING'){
                    if(($pending_bal < $total_fee_amount && $pending_bal > 0 && $status == 'ACTIVE') || ($paid_amt == 0 && $status == 'ACTIVE')){
                        $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                        $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                        $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->application_no);
                        // $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
                        $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
                        $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);
                    
                        $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fee_amount);
                    
                        $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
                        $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $feeConcession->fee_amt);
                        $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount - $paid_amt - $feeConcession->fee_amt);
                        $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $excess_paid_amt);
                        $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $status);
                        $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
                        $spreadsheet->getActiveSheet()->getStyle('E' . $excel_row. ':I' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
                        $total_Paid_amt += $paid_amt; 
                        $total_fee_concession += $feeConcession->fee_amt; 
                        $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                        $sum_of_total_fee += $total_fee_amount;
                        $total_excess_amount += $excess_paid_amt;
                        $sl_number++;
                        $excel_row++;
                    }
                }else{
                    $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->application_no);
                    // $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
                    $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);
                
                    $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fee_amount);
                
                    $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $feeConcession->fee_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount - $paid_amt - $feeConcession->fee_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $excess_paid_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $status);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
                    $spreadsheet->getActiveSheet()->getStyle('E' . $excel_row. ':I' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');

                    $total_Paid_amt += $paid_amt; 
                    $total_fee_concession += $feeConcession->fee_amt; 
                    $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                    $sum_of_total_fee += $total_fee_amount;
                    $total_excess_amount += $excess_paid_amt;
                    $sl_number++;
                    $excel_row++;
                }
            
            }else if($student_type == 'ALL'){
                if($payment_type == 'FULL_PAYMENT'){

                if($pending_bal <= 0){
                    $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->application_no);
                    // $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
                    $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);
                
                    $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fee_amount);
                
                    $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $feeConcession->fee_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount - $paid_amt - $feeConcession->fee_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $excess_paid_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $status);

                    $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
                    $spreadsheet->getActiveSheet()->getStyle('E' . $excel_row. ':I' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
                    $total_Paid_amt += $paid_amt; 
                    $total_fee_concession += $feeConcession->fee_amt; 
                    $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                    $sum_of_total_fee += $total_fee_amount;
                    $total_excess_amount += $excess_paid_amt;
                    $sl_number++;
                    $excel_row++;
                }
            }else if($payment_type == 'HALF_PAYMENT'){
                if($pending_bal < $total_fee_amount && $pending_bal > 0){
                        $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->application_no);
                    // $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
                    $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);
                
                    $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fee_amount);
                
                    $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $feeConcession->fee_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount - $paid_amt - $feeConcession->fee_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $excess_paid_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $status);

                    $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
                    $spreadsheet->getActiveSheet()->getStyle('E' . $excel_row. ':I' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
                    $total_Paid_amt += $paid_amt; 
                    $total_fee_concession += $feeConcession->fee_amt; 
                    $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                    $sum_of_total_fee += $total_fee_amount;
                    $total_excess_amount += $excess_paid_amt;
                    $sl_number++;
                    $excel_row++;
                }
            }else if($payment_type == 'NOT_PAID'){
            if($paid_amt == 0 && $status == 'ACTIVE'){
                $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->application_no);
                // $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
                $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
                $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);
            
                $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fee_amount);
            
                $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
                $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $feeConcession->fee_amt);
                $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount - $paid_amt - $feeConcession->fee_amt);
                $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $excess_paid_amt);
                $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $status);
                $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
                $spreadsheet->getActiveSheet()->getStyle('E' . $excel_row. ':I' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
                $total_Paid_amt += $paid_amt; 
                $total_fee_concession += $feeConcession->fee_amt; 
                $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                $sum_of_total_fee += $total_fee_amount;
                $total_excess_amount += $excess_paid_amt;
                $sl_number++;
                $excel_row++;
            }
        }else if($payment_type == 'PENDING'){
            if(($pending_bal < $total_fee_amount && $pending_bal > 0 && $status == 'ACTIVE') || ($paid_amt == 0 && $status == 'ACTIVE')){
                $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->application_no);
                // $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
                $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
                $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);
            
                $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fee_amount);
            
                $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
                $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $feeConcession->fee_amt);
                $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount - $paid_amt - $feeConcession->fee_amt);
                $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $excess_paid_amt);
                $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $status);
                $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
                $spreadsheet->getActiveSheet()->getStyle('E' . $excel_row. ':I' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
                $total_Paid_amt += $paid_amt; 
                $total_fee_concession += $feeConcession->fee_amt; 
                $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                $sum_of_total_fee += $total_fee_amount;
                $total_excess_amount += $excess_paid_amt;
                $sl_number++;
                $excel_row++;
                }
            }else{
                $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->application_no);
                // $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
                $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
                $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);
            
                $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fee_amount);
            
                $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
                $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $feeConcession->fee_amt);
                $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount - $paid_amt - $feeConcession->fee_amt);
                $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $excess_paid_amt);
                $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $status);
                $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
                $spreadsheet->getActiveSheet()->getStyle('E' . $excel_row. ':I' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');

                $total_Paid_amt += $paid_amt; 
                $total_fee_concession += $feeConcession->fee_amt; 
                $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                $sum_of_total_fee += $total_fee_amount;
                $total_excess_amount += $excess_paid_amt;
                $sl_number++;
                $excel_row++;
                }
            }
                    
            }
            $spreadsheet->getActiveSheet()->setCellValue('D'.$excel_row, 'TOTAL');
            $spreadsheet->getActiveSheet()->getStyle('C'.$excel_row.':L'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('C'.$excel_row.':L'.$excel_row)->getFont()->setBold(true);
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,"=SUM(G5:G".($excel_row-1).")");
            $spreadsheet->getActiveSheet()->setCellValue('E'.$excel_row,number_format($sum_of_total_fee,2));
            $spreadsheet->getActiveSheet()->setCellValue('F'.$excel_row,number_format($total_Paid_amt,2));
            $spreadsheet->getActiveSheet()->setCellValue('G'.$excel_row,number_format($total_fee_concession,2));
            $spreadsheet->getActiveSheet()->setCellValue('H'.$excel_row,number_format($total_pending_balance,2));
            $spreadsheet->getActiveSheet()->setCellValue('I'.$excel_row,number_format($total_excess_amount,2));

        }
             else {
                // if($year == CURRENT_YEAR ){
                    $yr = $year;
                // }else{
                //     $yr = $year-2;
                // }
                $studentInfo = $this->student->getAllStudentInfo_For_Fee_report($term_name,$stream_name,$yr);

                $total_state_fee_by_type = 0;
                $total_cbse_fee_by_type = 0;
                $total_nri_fee_by_type = 0;
                $sum_of_total_fee = 0;
                $total_Paid_amt = 0; 
                $total_fee_concession = 0; 
                $total_pending_balance = 0; 
                $total_excess_amount = 0;
                foreach ($studentInfo as $std) {
                    $filter['fee_year'] = $year;
                    $filter['term_name'] = 'II PUC';
                    $filter['stream_name'] = $std->stream_name;
                  

                    $filter['category'] = strtoupper($std->category);

                    $total_fee = $this->fee->getTotalFeeAmountForReport($filter);
                    $total_fee_amount = $total_fee->total_fee;
                    
                       
                    $total_paid_amount = $this->fee->getFeePaidInfoForReport($std->stud_row_id,$year);
                    $total_govt_paid_amount = $this->fee->getGovtFeePaidInfoForReport($std->stud_row_id,$year);

                       //  log_message('debug','paid'.print_r($total_paid_amount,true));
                  
                    if($total_paid_amount->paid_amount == ''){
                        $paid_amt = 0;
                    }else{
                        $paid_amt = $total_paid_amount->paid_amount + $total_govt_paid_amount->paid_amount;
                    }
                    $feeConcession = $this->fee->getStudFeeConcession($std->stud_row_id,$year);
                    $pending_bal = $total_fee_amount - $paid_amt - $feeConcession->fee_amt;
                    if($std->discontinued_status == 1){
                        $status = 'INACTIVE';
                     }else{
                        $status = 'ACTIVE';
                     }
                     if($paid_amt > $total_fee_amount){
                        $excess_paid_amt = abs($paid_amt - $total_fee_amount);
                    }else{
                        $excess_paid_amt = 0;
                    }
            if($status == $student_type){

                    if($payment_type == 'FULL_PAYMENT'){
                        if($pending_bal <= 0){
                    $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->application_no);
                    // $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
                    $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);
                    
                  
                    $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fee_amount);
                  
                    $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $feeConcession->fee_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount - $paid_amt - $feeConcession->fee_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $excess_paid_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $status);
                    $spreadsheet->getActiveSheet()->getStyle('E' . $excel_row. ':I' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');

                    $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
                    $this->excel->getActiveSheet()->getStyle('A'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('B'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $this->excel->getActiveSheet()->getStyle('D'.$excel_row.':G'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $total_Paid_amt += $paid_amt; 
                    $total_fee_concession += $feeConcession->fee_amt; 
                    $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                    $sum_of_total_fee += $total_fee_amount;
                    $total_excess_amount += $excess_paid_amt;
                    $sl_number++;
                    $excel_row++;
                }
            }else if($payment_type == 'HALF_PAYMENT'){
                if($pending_bal < $total_fee_amount && $pending_bal > 0){
                    $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->application_no);
                    // $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
                    $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);
                
                    $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fee_amount);
                
                    $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $feeConcession->fee_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount - $paid_amt - $feeConcession->fee_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $excess_paid_amt);
                    $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $status);
                    $spreadsheet->getActiveSheet()->getStyle('E' . $excel_row. ':I' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');

                    $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
                    $total_Paid_amt += $paid_amt; 
                    $total_fee_concession += $feeConcession->fee_amt; 
                    $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                    $sum_of_total_fee += $total_fee_amount;
                    $total_excess_amount += $excess_paid_amt;
                    $sl_number++;
                    $excel_row++;
                }
            }else if($payment_type == 'NOT_PAID'){
            if($paid_amt == 0 && $status == 'ACTIVE'){
                $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->application_no);
                // $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
                $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
                $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);
            
                $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fee_amount);
            
                $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
                $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $feeConcession->fee_amt);
                $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount - $paid_amt - $feeConcession->fee_amt);
                $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $excess_paid_amt);
                $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $status);
                $spreadsheet->getActiveSheet()->getStyle('E' . $excel_row. ':I' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');

                $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
                $total_Paid_amt += $paid_amt; 
                $total_fee_concession += $feeConcession->fee_amt; 
                $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                $sum_of_total_fee += $total_fee_amount;
                $total_excess_amount += $excess_paid_amt;
                $sl_number++;
                $excel_row++;
            }
        }else if($payment_type == 'PENDING'){
            if(($pending_bal < $total_fee_amount && $pending_bal > 0 && $status == 'ACTIVE') || ($paid_amt == 0 && $status == 'ACTIVE')){
                $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->application_no);
                // $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
                $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
                $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);
            
                $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fee_amount);
            
                $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
                $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $feeConcession->fee_amt);
                $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount - $paid_amt - $feeConcession->fee_amt);
                $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $excess_paid_amt);
                $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $status);
                $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
                $spreadsheet->getActiveSheet()->getStyle('E' . $excel_row. ':I' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
                $total_Paid_amt += $paid_amt; 
                $total_fee_concession += $feeConcession->fee_amt; 
                $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                $sum_of_total_fee += $total_fee_amount;
                $total_excess_amount += $excess_paid_amt;
                $sl_number++;
                $excel_row++;
            }
        }else{
            $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
            $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
            $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->application_no);
            // $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
            $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
            $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);
        
            $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fee_amount);
        
            $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
            $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $feeConcession->fee_amt);
            $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount - $paid_amt - $feeConcession->fee_amt);
            $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $excess_paid_amt);
            $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $status);

            $spreadsheet->getActiveSheet()->getStyle('E' . $excel_row. ':I' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
            $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
            $total_Paid_amt += $paid_amt; 
            $total_fee_concession += $feeConcession->fee_amt; 
            $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
            $sum_of_total_fee += $total_fee_amount;
            $total_excess_amount += $excess_paid_amt;
            $sl_number++;
            $excel_row++;
            }
        }else if($student_type == 'ALL'){
            
            if($payment_type == 'FULL_PAYMENT'){
                if($pending_bal <= 0){
            $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
            $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
            $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->application_no);
            // $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
            $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
            $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);
            
        
            $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fee_amount);
        
            $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
            $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $feeConcession->fee_amt);
            $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount - $paid_amt - $feeConcession->fee_amt);
            $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $excess_paid_amt);
            $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $status);
            $spreadsheet->getActiveSheet()->getStyle('E' . $excel_row. ':I' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');

            $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->getStyle('A'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('B'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $this->excel->getActiveSheet()->getStyle('D'.$excel_row.':G'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $total_Paid_amt += $paid_amt; 
            $total_fee_concession += $feeConcession->fee_amt; 
            $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
            $sum_of_total_fee += $total_fee_amount;
            $total_excess_amount += $excess_paid_amt;
            $sl_number++;
            $excel_row++;
        }
    }else if($payment_type == 'HALF_PAYMENT'){
        if($pending_bal < $total_fee_amount && $pending_bal > 0){
            $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
            $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
            $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->application_no);
            // $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
            $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
            $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);
        
            $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fee_amount);
        
            $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
            $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $feeConcession->fee_amt);
            $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount - $paid_amt - $feeConcession->fee_amt);
            $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $excess_paid_amt);
            $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $status);
            $spreadsheet->getActiveSheet()->getStyle('E' . $excel_row. ':I' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');

            $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
            $total_Paid_amt += $paid_amt; 
            $total_fee_concession += $feeConcession->fee_amt; 
            $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
            $sum_of_total_fee += $total_fee_amount;
            $total_excess_amount += $excess_paid_amt;
            $sl_number++;
            $excel_row++;
        }
        }else if($payment_type == 'NOT_PAID'){
        if($paid_amt == 0 && $status == 'ACTIVE'){
            $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
            $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
            $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->application_no);
            // $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
            $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
            $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);

            $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fee_amount);

            $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
            $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $feeConcession->fee_amt);
            $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount - $paid_amt - $feeConcession->fee_amt);
            $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $excess_paid_amt);
            $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $status);
            $spreadsheet->getActiveSheet()->getStyle('E' . $excel_row. ':I' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');

            $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
            $total_Paid_amt += $paid_amt; 
            $total_fee_concession += $feeConcession->fee_amt; 
            $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
            $sum_of_total_fee += $total_fee_amount;
            $total_excess_amount += $excess_paid_amt;
            $sl_number++;
            $excel_row++;
        }
        }else if($payment_type == 'PENDING'){
        if(($pending_bal < $total_fee_amount && $pending_bal > 0 && $status == 'ACTIVE') || ($paid_amt == 0 && $status == 'ACTIVE')){
            $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
            $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
            $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->application_no);
            // $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
            $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
            $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);

            $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fee_amount);

            $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
            $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $feeConcession->fee_amt);
            $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount - $paid_amt - $feeConcession->fee_amt);
            $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $excess_paid_amt);
            $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $status);
            $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('E' . $excel_row. ':I' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
            $total_Paid_amt += $paid_amt; 
            $total_fee_concession += $feeConcession->fee_amt; 
            $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
            $sum_of_total_fee += $total_fee_amount;
            $total_excess_amount += $excess_paid_amt;
            $sl_number++;
            $excel_row++;
        }
        }else{
        $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
        $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->application_no);
        // $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
        $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  strtoupper($std->student_name));
        $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->stream_name);

        $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $total_fee_amount);

        $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $paid_amt);
        $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $feeConcession->fee_amt);
        $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount - $paid_amt - $feeConcession->fee_amt);
        $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $excess_paid_amt);
        $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $status);

        $spreadsheet->getActiveSheet()->getStyle('E' . $excel_row. ':I' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
        $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
        $total_Paid_amt += $paid_amt; 
        $total_fee_concession += $feeConcession->fee_amt; 
        $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
        $sum_of_total_fee += $total_fee_amount;
        $total_excess_amount += $excess_paid_amt;
        $sl_number++;
        $excel_row++;
        }
    }
                }
            $spreadsheet->getActiveSheet()->setCellValue('D'.$excel_row, 'TOTAL');
            $spreadsheet->getActiveSheet()->getStyle('C'.$excel_row.':L'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('C'.$excel_row.':L'.$excel_row)->getFont()->setBold(true);
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,"=SUM(G5:G".($excel_row-1).")");
            $spreadsheet->getActiveSheet()->setCellValue('E'.$excel_row,number_format($sum_of_total_fee,2));
            $spreadsheet->getActiveSheet()->setCellValue('F'.$excel_row,number_format($total_Paid_amt,2));
            $spreadsheet->getActiveSheet()->setCellValue('G'.$excel_row,number_format($total_fee_concession,2));
            $spreadsheet->getActiveSheet()->setCellValue('H'.$excel_row,number_format($total_pending_balance,2));
            $spreadsheet->getActiveSheet()->setCellValue('I'.$excel_row,number_format($total_excess_amount,2));

        }

            // $excel_row++;

            // //$sl_number++;
            // $excel_row++;
            // }
            // $excel_row++;
            // $spreadsheet->getActiveSheet()->setCellValue('A'.$excel_row,  "");
            // $spreadsheet->getActiveSheet()->setCellValue('B'.$excel_row,  'ALL TOTAL');
            // $spreadsheet->getActiveSheet()->setCellValue('C'.$excel_row,  $total_sslc_state_fee);
            // $spreadsheet->getActiveSheet()->setCellValue('D'.$excel_row,  $total_cbse_icse_fee);
            // $spreadsheet->getActiveSheet()->setCellValue('E'.$excel_row,  $total_nri_fee);
            $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row . ":E" . $excel_row)->applyFromArray($font_style_total);
            $spreadsheet->createSheet();
            $i++;
            // $spreadsheet->getActiveSheet()->getStyle('A1:F'.$excel_row)->applyFromArray($styleBorder);
            //getting optional fee info


            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="fee_paid_report' . $term_name . '.xlsx"');
            header('Cache-Control: max-age=0');
            setcookie('isDownLoaded', 1);
            $writer->save("php://output");
        }
        }
    }

    public function getAllShortlistedList()
    {
        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {

            $category_by = $this->security->xss_clean($this->input->post('by_category'));
            $type = $this->security->xss_clean($this->input->post('type'));
            $preference = $this->security->xss_clean($this->input->post('preference'));
            $board_name = $this->security->xss_clean($this->input->post('board_name'));
            $percentage_from = $this->security->xss_clean($this->input->post('percentage_from'));
            $percentage_to = $this->security->xss_clean($this->input->post('percentage_to'));
            $student_type = $this->security->xss_clean($this->input->post('student_type'));
            $admission_year = $this->security->xss_clean($this->input->post('admission_year'));
            $shortlist_number = $this->security->xss_clean($this->input->post('shortlist_number'));    
            $integrated_batch = $this->security->xss_clean($this->input->post('integrated_batch'));    

            if($admission_year ==2022){

                $header = 'SHORTLISTED LIST 2022-2023';
            }else{
                $header = 'SHORTLISTED LIST 2021-2022';

            }


            $category = array(
                'ROMAN CATHOLIC',
                'OTHER CHRISTIANS',
                'GENERAL MERIT(GM)',
                'SC',
                'ST',
                'CAT-I',
                '2A',
                '3A',
                '2B',
                '3B'
            );
            for ($sheet = 0; $sheet < count($category); $sheet++) {
                $this->excel->setActiveSheetIndex($sheet);
                //name the worksheet

                $this->excel->getActiveSheet()->setTitle($category[$sheet]);
                $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');

                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', "ST JOSEPH'S PRE-UNIVERSITY COLLEGE HASSAN");
                $this->excel->getActiveSheet()->setCellValue('A2', "I PUC " . $preference . $header);
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->mergeCells('A1:N1');
                $this->excel->getActiveSheet()->mergeCells('A2:N2');
                $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);


                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);




                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL. NO.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Application Number');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Board');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Preferences');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Category');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Percentage');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H3', 'PH');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I3', 'Dyslexia');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J3', 'NCC');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K3', 'Sports');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L3', 'Father Mobile');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('M3', 'Mother Mobile');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('N3', 'Integrated Batch');
                $this->excel->getActiveSheet()->getStyle('A3:N3')->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->getStyle('A3:N3')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A3:N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



                $this->excel->getActiveSheet()->mergeCells('A4:N4');
                $this->excel->getActiveSheet()->getStyle('A4:N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->setCellValue('A4', $category[$sheet] . "- LIST");
                $this->excel->getActiveSheet()->getStyle('A4:N4')->getFont()->setBold(true);



                $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                $this->excel->getActiveSheet()->getStyle('A1:N4')->applyFromArray($styleBorderArray);

                $students = $this->application->getAllShortlistedList($preference, $category[$sheet], $board_name, $percentage_from, $percentage_to, $type, $student_type,$admission_year,$shortlist_number,$integrated_batch);
                $j = 1;

                $excel_row = 5;
                if ($student_type == 'NCC') {
                    $student_type_print = 'NCC';
                } else if ($student_type == 'SPORTS') {
                    $student_type_print = 'SPORTS';
                } else if ($student_type == 'DYC') {
                    $student_type_print = 'Dyslexia';
                } else if ($student_type == 'PH') {
                    $student_type_print = 'PH';
                } else {
                    $student_type_print = 'ALL';
                }

                foreach ($students as $student) {
                    if ($student->board_name == 'KARNATAKA STATE BOARD') {
                        $board_name_sheet = 'SSLC';
                    } else if ($student->board_name == 'OTHER') {
                        $board_name_sheet = 'OTHERS';
                    } else {
                        $board_name_sheet = $student->board_name;
                    }

                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $j++);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $student->application_number);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $student->name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $board_name_sheet);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $student->stream_name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $student->student_category);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $student->sslc_percentage);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $student->dyslexia_challenged);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row, $student->physically_challenged);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('J' . $excel_row, $student->ncc_certificate_status);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('K' . $excel_row, $student->national_level_sports_status);

                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('L' . $excel_row, $student->father_mobile);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('M' . $excel_row, $student->mother_mobile);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('N' . $excel_row, $student->integrated_batch);
                    $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':N' . $excel_row)->applyFromArray($styleBorderArray);
                    $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('D' . $excel_row . ':N' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel_row++;
                }

                $this->excel->createSheet();
            }
            $filename = 'just_some_random_name.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            $objWriter->save("php://output");
            setcookie('isDownLoaded', 1);
            $xlsData = ob_get_contents();

            ob_end_clean();
            $response =  array(
                'op' => 'ok',
                'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
            );
            die(json_encode($response));
        }
    }

    function getAssessmentMark($totalMark, $exam_type, $labStatus, $subject_code)
    {
        if (is_numeric($totalMark) && !empty($totalMark)) {
            if ($labStatus == 'false') {
                if ($exam_type == 'ASSIGNMENT_I' || $exam_type == 'ASSIGNMENT_II') {
                    if ($totalMark >= 81 && $totalMark <= 100) {
                        return '30';
                    } else if ($totalMark >= 71 && $totalMark <= 80) {
                        return '25';
                    } else if ($totalMark >= 61 && $totalMark <= 70) {
                        return '20';
                    } else if ($totalMark >= 51 && $totalMark <= 60) {
                        return '15';
                    } else if ($totalMark >= 41 && $totalMark <= 50) {
                        return '10';
                    } else {
                        return '5';
                    }
                }
            } else {
                if ($exam_type == 'ASSIGNMENT_I' && $subject_code == '12' || $exam_type == 'ASSIGNMENT_II' && $subject_code == '12') {
                    if ($totalMark >= 26 && $totalMark <= 35) {
                        return '4';
                    } else if ($totalMark >= 36 && $totalMark <= 45) {
                        return '8';
                    } else if ($totalMark >= 46 && $totalMark <= 55) {
                        return '12';
                    } else if ($totalMark >= 56 && $totalMark <= 65) {
                        return '16';
                    } else if ($totalMark >= 66 && $totalMark <= 75) {
                        return '20';
                    } else {
                        return '25';
                    }
                } else if ($exam_type == 'ASSIGNMENT_I' || $exam_type == 'ASSIGNMENT_II') {
                    if ($totalMark >= 1 && $totalMark <= 28) {
                        return '4';
                    } else if ($totalMark >= 29 && $totalMark <= 35) {
                        return '8';
                    } else if ($totalMark >= 36 && $totalMark <= 42) {
                        return '12';
                    } else if ($totalMark >= 43 && $totalMark <= 49) {
                        return '16';
                    } else if ($totalMark >= 50 && $totalMark <= 56) {
                        return '19';
                    } else {
                        return '22';
                    }
                }
            }
        } else {
            return '';
        }
    }


    function getAssignmentExamTheoryTotalMark($student_id, $subject_code, $lab_status)
    {

        if ($subject_code == 12) {
            $labStatus = 'true';
        } else {
            $labStatus = $lab_status;
        }
        if ($labStatus == 'true') {
            if ($subject_code == 12) {
                $pass_mark_theory = 25;
            } else {
                $pass_mark_theory = 21;
            }
        } else {
            $pass_mark_theory = 35;
        }

        if ($student_id == '20P5965' || $student_id == '20P4140' || $student_id == '20P1754') {
            $internal_assessment = 1;
        } else {
            $internal_assessment = 5;
        }
        // $exam_type = array('ASSIGNMENT_I', 'ASSIGNMENT_II');
        // ,'INTERNAL_ASSESSMENT' I_UNIT_TEST
        $exam_type = array('I_UNIT_TEST');
        $total_mark = 0;
        foreach ($exam_type as $exam) {
            $stdMarkInfo = $this->student->getStudentFinalMarks($student_id, $subject_code, $exam);
            $sub_marks = 0;
            $mark_obt = 0;
            // if ($stdMarkInfo->exam_type == 'ASSIGNMENT_I' || $stdMarkInfo->exam_type == 'ASSIGNMENT_II') {
            //     if ($stdMarkInfo->obt_theory_mark == 'AB' || $stdMarkInfo->obt_theory_mark == 'EXEM' || $stdMarkInfo->obt_theory_mark == 'MP' || $stdMarkInfo->obt_theory_mark ==  'ASGN') {
            //         $mark_obt = 0;
            //     } else {
            //         $sub_marks = $this->getAssessmentMark($stdMarkInfo->obt_theory_mark, $stdMarkInfo->exam_type, $labStatus, $subject_code);
            //         $mark_obt = $sub_marks;
            //     }
            // } else {
                if ($stdMarkInfo->obt_theory_mark == 'AB' || $stdMarkInfo->obt_theory_mark == 'EXEM' || $stdMarkInfo->obt_theory_mark == 'MP' || $stdMarkInfo->obt_theory_mark ==  'ASGN') {
                    $mark_obt = 0;
                } else {
                    $mark_obt = $stdMarkInfo->obt_theory_mark;
                }
            // }
            // log_message('debug','bsch'.print_r($mark_obt,true));
            // log_message('debug','student_id '.$student_id);
            $total_mark += $mark_obt;
        }


        $totalMark = $total_mark + $pass_mark_theory + $internal_assessment;
        return $totalMark;
    }


    function getAssignmentExamLabTotalMark($student_id, $subject_code, $lab_status)
    {

        if ($subject_code == 12) {
            $labStatus = 'true';
        } else {
            $labStatus = $lab_status;
        }
        if ($labStatus == 'true') {
            if ($subject_code == 12) {
                $pass_mark_lab = 10;
                $lab_assessment = 10;
            } else {
                $pass_mark_lab = 14;
                $lab_assessment = 16;
            }
        } else {
            $pass_mark_lab = 0;
            $lab_assessment = 0;
        }

        $exam_type = array('LAB_ASSESSMENT');

        // foreach($exam_type as $exam){
        //     $stdMarkInfo = $this->student->getStudentFinalMarks($student_id,$subject_code,$exam);
        //     $sub_marks = 0;
        //     $mark_obt = 0;
        //     if($stdMarkInfo->exam_type == 'ASSIGNMENT_I' || $stdMarkInfo->exam_type == 'ASSIGNMENT_II'){
        //         if($stdMarkInfo->obt_theory_mark == 'AB' || $stdMarkInfo->obt_theory_mark == 'EXEM' || $stdMarkInfo->obt_theory_mark == 'MP' || $stdMarkInfo->obt_theory_mark ==  'ASGN'){
        //             $mark_obt = 0;
        //         }else{
        //             $sub_marks = $this->getAssessmentMark($stdMarkInfo->obt_theory_mark,$stdMarkInfo->exam_type,$labStatus,$subject_code);
        //             $mark_obt = $sub_marks;
        //         }
        //     }else{
        //         if($stdMarkInfo->obt_theory_mark == 'AB' || $stdMarkInfo->obt_theory_mark == 'EXEM' || $stdMarkInfo->obt_theory_mark == 'MP' || $stdMarkInfo->obt_theory_mark ==  'ASGN'){
        //             $mark_obt = 0;
        //         }else{
        //             $mark_obt = $stdMarkInfo->obt_theory_mark;
        //         }
        //     }
        //     $total_mark += $mark_obt;
        // }


        // $totalLabMark = $total_mark + $pass_mark_lab + $lab_assessment;
        $totalLabMark = $pass_mark_lab + $lab_assessment;
        return $totalLabMark;
    }


    public function shorlitedStudentPDF_PRINT()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {

            $preference = $this->security->xss_clean($this->input->post('preference'));
            $this->global['pageTitle'] = '' . TAB_TITLE . ' :PDF';
            // $data['feeInfo'] = $this->fee->getStudentManagementFeeInfoById($row_id);
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf', 'default_font' => 'timesnewroman', 'format' => [190, 236]]);
            $mpdf->AddPage('L', '', '', '', '', 2, 2, 2, 1, 8, 8);
            //$mpdf->AddPage('L','','','','',50,50,50,50,10,10);
            $info = $this->application->getAllShortlistedList_PDF($preference);
            $data['stdInfo'] = $info;
            $data['preference'] = $preference;
            $data_html = $this->load->view('application/printShortlistedPdf', $data, true);

            // $mpdf->WriteHTML('<columns column-count="3" vAlign="J" column-gap="2" />');
            $mpdf->WriteHTML($data_html);
            // $mpdf->WriteHTML($html_college_copy);
            // $mpdf->WriteHTML($html_bank_copy);
            $mpdf->Output($preference . '.pdf', 'I');
        }
    }


    


    //download Staff info
    public function downloadStaffExcelReport()
    {
        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            $staff_role = $this->security->xss_clean($this->input->post('staff_role'));
            $staff_department = $this->security->xss_clean($this->input->post('staff_department'));
            $fields = $this->security->xss_clean($this->input->post('fields'));

            if ($staff_department == 'ALL') {
                $filter['staff_department'] = "";
                $data['staff_department'] = 'ALL';
            } else {
                $filter['staff_department'] = $staff_department;
                $data['staff_department'] = $staff_department;
            }

            if ($staff_role == 'ALL') {
                $filter['staff_role'] = "";
                $data['staff_role'] = 'ALL';
                $stafRoleName = 'ALL';
            } else {
                $filter['staff_role'] = $staff_role;
                $data['staff_role'] = $staff_role;
                $role_name = $this->staff->getStaffRoleByName($filter);
                $stafRoleName = $role_name->role;
            }

            $date = date('Y');
            $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
            $total_fields = count($fields);
            $sheet = 0;

            // for($sheet = 0; $sheet < count($preferences);  $sheet++){
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet
            // $this->excel->getActiveSheet()->setTitle($preferences[$sheet]);
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');
            //set Title content with some text
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', " STAFF INFORMATION - ".EXCEL_YEAR);
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:' . $cellName[$total_fields] . '1');
            $this->excel->getActiveSheet()->mergeCells('A2:' . $cellName[$total_fields] . '2');
            $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:' . $cellName[$total_fields] . '2')->getFont()->setBold(true);



            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);

            $excel_row = 3;
            $cell = 1;
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL No.');

            for ($h = 1; $h <= $total_fields; $h++) {
                $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellName[$h] . $excel_row, $fields[$h - 1]);
            }
            $this->excel->getActiveSheet()->getStyle('A3:' . $cellName[$total_fields] . '3')->getAlignment()->setWrapText(true);
            $this->excel->getActiveSheet()->getStyle('A3:' . $cellName[$total_fields] . '3')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A3:' . $cellName[$total_fields] . '3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:' . $cellName[$total_fields] . $total_fields)->applyFromArray($styleBorderArray);


            $staffs = $this->staff->getStaffInfoForReportDownload($filter);
            $j = 1;
            $excel_row = 4;

            foreach ($staffs as $stf) {
                if (empty($stf->dob) || $stf->dob == '0000-00-00' || $stf->dob == '1970-01-01') {
                    $dob = '';
                } else {
                    $dob = date("d-m-Y", strtotime($stf->dob));
                }

                if (empty($stf->doj) || $stf->doj == '0000-00-00' || $stf->doj == '1970-01-01') {
                    $doj = '';
                } else {
                    $doj = date("d-m-Y", strtotime($stf->doj));
                }


                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $j++);

                for ($c = 1; $c <= $total_fields; $c++) {
                    if ($fields[$c - 1] == 'dob') {
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellName[$c] . $excel_row, $dob);
                    } else if ($fields[$c - 1] == 'doj') {
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellName[$c] . $excel_row, $doj);
                    } else {
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellName[$c] . $excel_row, $stf->{$fields[$c - 1]});
                    }
                }

                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':' . $cellName[$total_fields] . $excel_row)->applyFromArray($styleBorderArray);
                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('D' . $excel_row . ':' . $cellName[$total_fields] . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
            }
            $this->excel->createSheet();
            // }
            $filename =  '_STAFF_Report_' . $stafRoleName . '-' . $date . '.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment; filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            $objWriter->save("php://output");
            setcookie('isDownLoaded', 1);
        }
    }


    //download mun external report
    public function downloadMunExternalReport()
    {
        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            $status = $this->security->xss_clean($this->input->post('status'));
            $register_type = $this->security->xss_clean($this->input->post('register_type'));

            $filter['status'] = $status;
            if ($register_type != 'ALL') {
                $filter['register_type'] = $register_type;
            } else {
                $filter['register_type'] = '';
            }


            $date = date('Y');
            $sheet = 0;

            // for($sheet = 0; $sheet < count($preferences);  $sheet++){
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet
            // $this->excel->getActiveSheet()->setTitle($preferences[$sheet]);
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:K500');
            //set Title content with some text
            $this->excel->getActiveSheet()->setTitle('MUN REGISRTATION');
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', "MUN EXTERNAL REGISTRATION");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:G1');
            $this->excel->getActiveSheet()->mergeCells('A2:G2');
            $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:A2')->getFont()->setBold(true);



            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);


            $excel_row = 3;
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'Register ID');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Date');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'College Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Type');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Mobile');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Email');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Total Students');

            // $this->excel->getActiveSheet()->getStyle('A3:'.$cellName[$total_fields].'3')->getAlignment()->setWrapText(true); 
            $this->excel->getActiveSheet()->getStyle('A3:G3')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:G3')->applyFromArray($styleBorderArray);


            $eventInfo = $this->mun->getExternalMunRegistrationInfo($filter);
            $excel_row = 4;

            foreach ($eventInfo as $evt) {


                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $evt->event_register_id);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, date('d-m-Y', strtotime($evt->created_date_time)));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $evt->college_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $evt->registeration_type);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $evt->mobile);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $evt->email);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $evt->total_students);

                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':' . 'G' . $excel_row)->applyFromArray($styleBorderArray);
                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('E' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('G' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
            }
            $this->excel->createSheet();

            // $sheet = 1;
            // $this->excel->setActiveSheetIndex($sheet);

            // //set Title content with some text
            // $this->excel->getActiveSheet()->setTitle('MUN PARTICIPANTS');
            // $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            // $this->excel->getActiveSheet()->setCellValue('A2', "MUN EXTERNAL PARTICIPANT");
            // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            // $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            // $this->excel->getActiveSheet()->mergeCells('A1:I1');
            // $this->excel->getActiveSheet()->mergeCells('A2:I2');
            // $this->excel->getActiveSheet()->getStyle('A1:I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $this->excel->getActiveSheet()->getStyle('A1:I2')->getFont()->setBold(true);



            // $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
            // $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
            // $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
            // $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
            // $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
            // $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(32);
            // $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
            // $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            // $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
            // // $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
            // // $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(24);
            // // $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(40);

            // $excel_row = 3;
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'Register ID');
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Name');
            // // $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'DOB');
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Class');
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Institution');
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Email');
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Whatsapp No.');
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Country');
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('H3', 'Preferred Allotment');
            // $this->excel->setActiveSheetIndex($sheet)->setCellValue('I3', 'Achievements');

            // // $this->excel->getActiveSheet()->getStyle('A3:'.$cellName[$total_fields].'3')->getAlignment()->setWrapText(true); 
            // $this->excel->getActiveSheet()->getStyle('A3:I3')->getFont()->setBold(true);
            // $this->excel->getActiveSheet()->getStyle('A3:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


            // $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            // $this->excel->getActiveSheet()->getStyle('A1:I3')->applyFromArray($styleBorderArray);


            // $eventInfo = $this->mun->getExternalMunRegistrationInfo($filter);
            // $excel_row = 4;

            // foreach ($eventInfo as $evt) {
            //     $participantInfo = $this->mun->getParticipantInfo($evt->event_register_id);
            //     foreach ($participantInfo as $part) {
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $part->registration_row_id);
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $part->student_name);
            //         // $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, date('d-m-Y', strtotime($part->dob)));
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $part->class);
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $part->institution_name);
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $part->email);
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $part->whatsapp_no);
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $part->country_name);
            //         // $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $part->city);
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $part->preferred_allotments);
            //         // $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row, $part->preferred_allotments_2);
            //         $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row, $part->past_mun_achievements);

            //         $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':' . 'I' . $excel_row)->applyFromArray($styleBorderArray);
            //         $this->excel->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //         $this->excel->getActiveSheet()->getStyle('C' . $excel_row . ':' . 'D' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //         $this->excel->getActiveSheet()->getStyle('F' . $excel_row . ':' . 'H' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //         $excel_row++;
            //     }
            // }
            // $this->excel->createSheet();
            $filename =  'MUN_EXTERNAL_' . $date . '.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment; filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            $objWriter->save("php://output");
            setcookie('isDownLoaded', 1);
        }
    }


    // DOWNLOAD mun internal report
    public function downloadMunInternalReport()
    {
        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            $status = $this->security->xss_clean($this->input->post('status'));

            $filter['status'] = $status;


            $date = date('Y');
            $sheet = 0;

            // for($sheet = 0; $sheet < count($preferences);  $sheet++){
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet
            // $this->excel->getActiveSheet()->setTitle($preferences[$sheet]);
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:H500');
            //set Title content with some text
            $this->excel->getActiveSheet()->setTitle('MUN');
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', "MUN INTERNAL REGISTRATION");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:H1');
            $this->excel->getActiveSheet()->mergeCells('A2:H2');
            $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:A2')->getFont()->setBold(true);



            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(12);

            $excel_row = 3;
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL NO');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Student ID');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Whatsapp No.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Preferred Allotment');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Term');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Stream');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('H3', 'Section');

            // $this->excel->getActiveSheet()->getStyle('A3:'.$cellName[$total_fields].'3')->getAlignment()->setWrapText(true); 
            $this->excel->getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:H3')->applyFromArray($styleBorderArray);


            $eventInfo = $this->mun->downloadMunInternalReport($filter);
            $excel_row = 4;
            $sl_no = 1;

            foreach ($eventInfo as $evt) {


                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $sl_no++);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $evt->student_id);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $evt->student_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $evt->whatsapp_no);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $evt->committee);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $evt->term_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $evt->stream_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $evt->section_name);

                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':' . 'H' . $excel_row)->applyFromArray($styleBorderArray);
                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('D' . $excel_row . ':H' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
            }
            $this->excel->createSheet();

            $filename =  'MUN_INTERNAL_' . $date . '.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment; filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            $objWriter->save("php://output");
            setcookie('isDownLoaded', 1);
        }
    }




    public function downloadApplicationFeePaid()
    {
        if ($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            $status = $this->security->xss_clean($this->input->post('status'));

            $filter['status'] = $status;


            $date = date('Y');
            $sheet = 0;

            // for($sheet = 0; $sheet < count($preferences);  $sheet++){
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet
            // $this->excel->getActiveSheet()->setTitle($preferences[$sheet]);
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:H500');
            //set Title content with some text
            $this->excel->getActiveSheet()->setTitle('MUN');
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', "MUN INTERNAL REGISTRATION");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:H1');
            $this->excel->getActiveSheet()->mergeCells('A2:H2');
            $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:A2')->getFont()->setBold(true);



            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(12);

            $excel_row = 3;
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL NO');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Application No');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Student Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Stream');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Integrated Batch');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Board');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Fee');

            // $this->excel->getActiveSheet()->getStyle('A3:'.$cellName[$total_fields].'3')->getAlignment()->setWrapText(true); 
            $this->excel->getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:H3')->applyFromArray($styleBorderArray);


            $eventInfo = $this->mun->downloadMunInternalReport($filter);
            $excel_row = 4;
            $sl_no = 1;

            foreach ($eventInfo as $evt) {


                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $sl_no++);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $evt->student_id);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $evt->student_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $evt->whatsapp_no);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $evt->committee);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $evt->term_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $evt->stream_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $evt->section_name);

                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':' . 'H' . $excel_row)->applyFromArray($styleBorderArray);
                $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('D' . $excel_row . ':H' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
            }
            $this->excel->createSheet();

            $filename =  'MUN_INTERNAL_' . $date . '.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment; filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
            $objWriter->save("php://output");
            setcookie('isDownLoaded', 1);
        }
    }







     // DOWNLOAD Course internal report
     public function downloadCourseRegistrationReport()
     {
         if ($this->isAdmin() == TRUE) {
             setcookie('isDownLoaded', 1);
             $this->loadThis();
         } else {
             $filter = array();
             $status = $this->security->xss_clean($this->input->post('status'));
 
             $filter['status'] = $status;
 
 
             $date = date('Y');
             $sheet = 0;
 
             // for($sheet = 0; $sheet < count($preferences);  $sheet++){
             $this->excel->setActiveSheetIndex($sheet);
             //name the worksheet
             // $this->excel->getActiveSheet()->setTitle($preferences[$sheet]);
             $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:H500');
             //set Title content with some text
             $this->excel->getActiveSheet()->setTitle('COURSE');
             $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
             $this->excel->getActiveSheet()->setCellValue('A2', "COURSE REGISTRATION");
             $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
             $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
             $this->excel->getActiveSheet()->mergeCells('A1:E1');
             $this->excel->getActiveSheet()->mergeCells('A2:E2');
             $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $this->excel->getActiveSheet()->getStyle('A1:A2')->getFont()->setBold(true);
 
 
 
             $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
             $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
             $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
             $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
             $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
           ;
 
             $excel_row = 3;
             $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL NO');
             $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Student ID');
             $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Name');
             $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Course Name');
             $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Amount');
        
 
             // $this->excel->getActiveSheet()->getStyle('A3:'.$cellName[$total_fields].'3')->getAlignment()->setWrapText(true); 
             $this->excel->getActiveSheet()->getStyle('A3:E3')->getFont()->setBold(true);
             $this->excel->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 
 
             $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
             $this->excel->getActiveSheet()->getStyle('A1:E3')->applyFromArray($styleBorderArray);
 
 
             $courseInfo = $this->student->getAllCourseRegisterInfoForReport();
             $excel_row = 4;
             $sl_no = 1;
 
             foreach ($courseInfo as $course) {
 
 
                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $sl_no++);
                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $course->student_id);
                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, $course->student_name);
                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $course->course_name);
                 $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $course->paid_amount);
          
 
                 $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':' . 'E' . $excel_row)->applyFromArray($styleBorderArray);
                 $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                 $this->excel->getActiveSheet()->getStyle('D' . $excel_row . ':E' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                 $excel_row++;
             }
             $this->excel->createSheet();
 
             $filename =  'COURSE_REGISTRATION.xls'; //save our workbook as this file name
             header('Content-Type: application/vnd.ms-excel'); //mime type
             header('Content-Disposition: attachment; filename="' . $filename . '"'); //tell browser what's the file name
             header('Cache-Control: max-age=0'); //no cache
 
             //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
             //if you want to save it as .XLSX Excel 2007 format
             $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
             ob_start();
             $objWriter->save("php://output");
             setcookie('isDownLoaded', 1);
         }
     }













    //download fee structure format
    public function download_fee_structure_excel_2020()
    {
        if ($this->isAdmin() == true) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            $term_name = $this->security->xss_clean($this->input->post('term_name_select'));
            $spreadsheet = new Spreadsheet();
            $headerFontSize = [
                'font' => [
                    'size' => 16,
                    'bold' => true,
                ]
            ];
            $font_style_total = [
                'font' => [
                    'size' => 12,
                    'bold' => true,
                ]
            ];
            $filter['term_name'] = $term_name;
            //$streamInfo = $this->staff->getStaffSectionByTerm($filter);

            $spreadsheet->getProperties()
                ->setCreator("SJPUC")
                ->setLastModifiedBy($this->staff_id)
                ->setTitle("SJPUC Fee Info")
                ->setSubject("Fee Structure")
                ->setDescription(
                    "SJPUC"
                )
                ->setKeywords("SJPUC")
                ->setCategory("Fee");
            $i = 0;

            $spreadsheet->setActiveSheetIndex(0);
            $spreadsheet->getActiveSheet()->setTitle('FEE');
            $spreadsheet->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $spreadsheet->getActiveSheet()->mergeCells("A1:F1");
            $spreadsheet->getActiveSheet()->getStyle("A1:A1")->applyFromArray($headerFontSize);

            $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->setCellValue('A2', $term_name . " FEE REPORT");
            $spreadsheet->getActiveSheet()->mergeCells("A2:F2");
            $spreadsheet->getActiveSheet()->getStyle("A2:A2")->applyFromArray($headerFontSize);
            $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal('center');

            $spreadsheet->getActiveSheet()->setCellValue('A3', 'SL No');
            $spreadsheet->getActiveSheet()->setCellValue('B3', 'Student ID');
            $spreadsheet->getActiveSheet()->setCellValue('C3', 'Application No');
            $spreadsheet->getActiveSheet()->setCellValue('D3', 'Name');
            $spreadsheet->getActiveSheet()->setCellValue('E3', 'Lang');
            $spreadsheet->getActiveSheet()->setCellValue('F3', 'Stream');
            $spreadsheet->getActiveSheet()->setCellValue('G3', 'SC/ST/CATI');
            $spreadsheet->getActiveSheet()->setCellValue('H3', 'Fee Payable');
            $spreadsheet->getActiveSheet()->setCellValue('I3', 'Fee Paid');
            $spreadsheet->getActiveSheet()->setCellValue('J3', 'Pending');
            $spreadsheet->getActiveSheet()->getStyle("A3:J3")->applyFromArray($font_style_total);
            $spreadsheet->getActiveSheet()->getStyle("A3:J3")->applyFromArray($font_style_total);
            $spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('I3')->getAlignment()->setWrapText(true);
            // $feeTypeInfo = $this->fee->getAllFeeTypesForByStatus(1);

            $spreadsheet->getActiveSheet()->getStyle('A3:E3')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'E5E4E2')
                    ),
                    'font'  => array(
                        'bold'  =>  true
                    )
                )
            );


            $spreadsheet->getActiveSheet()->getStyle('A:C')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('E:F')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('H:J')->getAlignment()->setHorizontal('center');
            $excel_row = 4;
            $sl_number = 1;
            $total_sslc_state_fee = 0;
            $total_cbse_icse_fee = 0;
            $total_nri_fee = 0;
            $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(28);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(17);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(17);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(18);
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(18);
            // foreach($feeTypeInfo as $type){
            if ($term_name == 'I PUC') {
                $studentInfo = $this->fee->getAllFeePendingAmount2020();
                $total_state_fee_by_type = 0;
                $total_cbse_fee_by_type = 0;
                $total_nri_fee_by_type = 0;
                foreach ($studentInfo as $std) {

                    $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->student_id);
                    $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->student_name);
                    $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $std->elective_sub);
                    $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $std->stream_name);
                    $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $std->category);
                    $filter['fee_year'] = '2020';
                    $filter['term_name'] = 'II PUC';
                    $filter['stream_name'] = $std->stream_name;
                    if (strtoupper($std->elective_sub) == 'FRENCH') {
                        $filter['lang_fee_status'] = true;
                    } else {
                        $filter['lang_fee_status'] = false;
                    }
                    $feeYear = '2020';

                    $filter['category'] = strtoupper($std->category);
                    $total_fee = $this->fee->getTotalFeeAmount($filter);
                    // $total_fee_amount = $total_fee->total_fee;
                    $total_fee_amount = $std->total_fee;
                    $total_paid_amount = $this->fee->getSUM_Paid_FeeInfoByReceiptNum_2020($std->application_no);

                    $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount);
                    $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $total_paid_amount->paid_amount);
                    $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $total_fee_amount - $total_paid_amount->paid_amount);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);

                    $sl_number++;
                    $excel_row++;
                }
            } else {
                $studentInfo = $this->fee->getAllFeePendingAmount2019();
                $total_state_fee_by_type = 0;
                $total_cbse_fee_by_type = 0;
                $total_nri_fee_by_type = 0;
                foreach ($studentInfo as $std) {

                    $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                    $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row,  $sl_number);
                    $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row,  $std->student_id);
                    $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row,  $std->application_no);
                    $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row,  $std->student_name);
                    $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row,  $std->elective_sub);
                    $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row,  $std->stream_name);
                    $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row,  $std->category);
                    $filter['fee_year'] = '2020';
                    $filter['term_name'] = 'II PUC';
                    $filter['stream_name'] = $std->stream_name;
                    if (strtoupper($std->elective_sub) == 'FRENCH') {
                        $filter['lang_fee_status'] = true;
                    } else {
                        $filter['lang_fee_status'] = false;
                    }
                    $feeYear = '2019';
                    $filter['category'] = strtoupper($std->category);
                    $total_fee = $this->fee->getTotalFeeAmount($filter);
                    // $total_fee_amount = $total_fee->total_fee;
                    $total_fee_amount = $std->total_fee;
                    $total_paid_amount = $this->fee->getSUM_Paid_FeeInfoByReceiptNum_2020($std->application_no);

                    $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row,  $total_fee_amount);
                    $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row,  $total_paid_amount->paid_amount);
                    $spreadsheet->getActiveSheet()->setCellValue('J' . $excel_row,  $total_fee_amount - $total_paid_amount->paid_amount);
                    $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);

                    $sl_number++;
                    $excel_row++;
                }
            }
            // $excel_row++;

            // //$sl_number++;
            // $excel_row++;
            // }
            // $excel_row++;
            // $spreadsheet->getActiveSheet()->setCellValue('A'.$excel_row,  "");
            // $spreadsheet->getActiveSheet()->setCellValue('B'.$excel_row,  'ALL TOTAL');
            // $spreadsheet->getActiveSheet()->setCellValue('C'.$excel_row,  $total_sslc_state_fee);
            // $spreadsheet->getActiveSheet()->setCellValue('D'.$excel_row,  $total_cbse_icse_fee);
            // $spreadsheet->getActiveSheet()->setCellValue('E'.$excel_row,  $total_nri_fee);
            $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row . ":E" . $excel_row)->applyFromArray($font_style_total);
            $spreadsheet->createSheet();
            $i++;
            // $spreadsheet->getActiveSheet()->getStyle('A1:F'.$excel_row)->applyFromArray($styleBorder);
            //getting optional fee info




            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="fee_paid_' . $feeYear . '_' . $term_name . '.xlsx"');
            header('Cache-Control: max-age=0');
            setcookie('isDownLoaded', 1);
            $writer->save("php://output");
        }
    }

    function getFullMarksOfStudent()
    {
        $type = $this->input->post("type");
        $stream_name = $this->input->post("streamName");
        $sectionName = $this->input->post("sectionName");
        $term_name = 'I PUC';
        if ($stream_name == 'All') {
            $streamName = '';
        }else{
            $streamName =  $stream_name;
        }
        $first_cell = array("N", "Q", "T", "W");
        $middle_cell = array("O", "R", "U", "X");
            $last_cell = array("P", "S", "V", "Y");
            if($stream_name == 'All'){
                $streams = array("PCMB", "PCMC", "CEBA", "HEPS", "HEBA");
            }else{
                $streams = array($stream_name);
            }
        if ($type == 'All') {
            for ($sheet = 0; $sheet < count($streams); $sheet++) {
                $current_stream = $streams[$sheet];
                // $stream_name = $this->student->getStudentsStreamName($section_name, $term_name, $streamName);
                $subjects = $this->getSubjectCodes($current_stream);
                $this->excel->setActiveSheetIndex($sheet);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle($current_stream);
                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                $this->excel->getActiveSheet()->setCellValue('A2', "I PUC  ANNUAL EXAMINATION RESULT ".EXAM_YEAR);
                $this->excel->getActiveSheet()->setCellValue('A3', "Abbreviation used in the table");
                $this->excel->getActiveSheet()->setCellValue('A4', "MO: Marks Obtained | IA: Internal Assessment | TH: Theory | PR: Practical | LT: Language Total | ST: Subjects Total | TM: Total Marks");
                $this->excel->getActiveSheet()->setCellValue('A5', "I PUC " . $current_stream . " SECTION $sectionName");
                //change the font size 
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(12);
                $this->excel->getActiveSheet()->getStyle('A4')->getFont()->setSize(11);
                $this->excel->getActiveSheet()->getStyle('A5:Y5')->getFont()->setSize(13);
                $this->excel->getActiveSheet()->getStyle('A1:AB5')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->mergeCells('A1:AB1');
                $this->excel->getActiveSheet()->mergeCells('A2:AB2');
                $this->excel->getActiveSheet()->mergeCells('A3:AB3');
                $this->excel->getActiveSheet()->mergeCells('A4:AB4');
                $this->excel->getActiveSheet()->mergeCells('A5:AB5');
                $this->excel->getActiveSheet()->mergeCells('A6:A7');
                $this->excel->getActiveSheet()->mergeCells('C6:C7');
                $this->excel->getActiveSheet()->mergeCells('B6:B7');
                $this->excel->getActiveSheet()->mergeCells('D6:D7');
                $this->excel->getActiveSheet()->mergeCells('E6:E7');
                $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                //settting border style 
                $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                $this->excel->getActiveSheet()->getStyle('A1:AB120')->applyFromArray($styleArray);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A6', 'SL.no');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B6', 'Student ID');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C6', 'SAT No.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D6', 'Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E6', 'Lang');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I6', 'Lng');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I7', 'Code');
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(11);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(38);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J6', 'Language');
                $this->excel->getActiveSheet()->mergeCells('F6:H6');
                $this->excel->getActiveSheet()->mergeCells('J6:L6');
                $this->excel->getActiveSheet()->mergeCells('Z6:Z7');
                $this->excel->getActiveSheet()->mergeCells('AA6:AA7');
                $this->excel->getActiveSheet()->mergeCells('AB6:AB7');
                $this->excel->getActiveSheet()->getStyle('G6:I6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F7', 'TH');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G7', 'IA');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H7', 'MO');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F6', 'English(2)');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J7', 'TH');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K7', 'IA');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L7', 'MO');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('M7', 'LT');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('Z6', 'ST');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('AA6', 'TM');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('AB6', 'Result');
                $excel_row = 7;

                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('X')->setWidth(5);
                $this->excel->getActiveSheet()->getColumnDimension('Y')->setWidth(5);
                $this->excel->getActiveSheet()->getStyle('F1:F3')->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->getStyle('E6:AB120')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('I7:I999')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A6:AB7')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('K8:K150')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('V8:AB999')->getFont()->setBold(true);
                $this->cellColor('A6:AB7', 'D5DBDB');
                //first subject heading
                for ($i = 0; $i < 4; $i++) {
                    $subjectInfo = $this->subject->getSubjectsById($subjects[$i]);
                    $this->excel->getActiveSheet()->getColumnDimension($first_cell[$i])->setWidth(6);
                    $this->excel->getActiveSheet()->getColumnDimension($middle_cell[$i])->setWidth(6);
                    $this->excel->getActiveSheet()->getColumnDimension($last_cell[$i])->setWidth(6);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . '6', $subjectInfo->name . '(' . $subjects[$i] . ')');
                    $this->excel->getActiveSheet()->mergeCells($first_cell[$i] . '6:' . $last_cell[$i] . '6');
                    $this->excel->getActiveSheet()->getStyle($first_cell[$i] . '6:' . $last_cell[$i] . '6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    if ($subjectInfo->lab_status == "true") {
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . '7', 'TH');
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($middle_cell[$i] . '7', 'PR');
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . '7', 'MO');
                    }else{
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . '7', 'TH');
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($middle_cell[$i] . '7', 'IA');
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . '7', 'MO');
                    }    
                }
                $data['studentsResult'] = $this->student->getStudentsToAddMark($term_name, $sectionName,$current_stream);
                $excel_row = 8;
                $j = 1;
                foreach ($data['studentsResult']  as $row) {
                    $total_marks_subjects = 0;
                    $total_language_mark = 0;
                    $total_marks_all_subjects = 0;
                    $fail_flag = false;
                    $subject_total = array();
                    $data['studentsMarks'] = $this->student->getFullMarksOfStudent($row->student_id);
                    $student_status = $row->tc_given_status;
                    if (!empty($data['studentsMarks']) && $student_status == 0) {
                        $first_language_total = 0;
                        $second_language_total = 0;
                        $second_lang_mark = 0;
                        $second_lang_mark_lab = 0;
                        $first_lan_TH = 0;
                        $first_lan_IA = 0;
                        $first_language_name = "";
                        $first_language_code = "";
                        $subject_code_from_subjects = 0;
                        $lang_total = 0;
                        foreach ($data['studentsMarks']  as $mark) {
                            $subject_true = false;
                            if ($mark->subject_code == '1') {
                                $first_language_code = $mark->subject_code;
                                $first_language_name = "KAN";
                                $first_lan_TH =  $mark->obt_theory_mark;
                                $first_lan_IA =  $mark->obt_lab_mark;
                                $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;
                                if ($first_lan_TH < 24) {
                                    $this->cellColor('J' . $excel_row . ':L' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                } else if ($first_language_total < 35) {
                                    // $this->cellColor('J' . $excel_row . ':L' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                }
                                $lang_total += $first_language_total;
                            } else if ($mark->subject_code == '3') {
                                $first_language_code = $mark->subject_code;
                                $first_language_name = "HINDI";
                                $first_lan_TH =  $mark->obt_theory_mark;
                                $first_lan_IA =  $mark->obt_lab_mark;
                                $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;
                                if ($first_lan_TH < 24) {
                                    $this->cellColor('J' . $excel_row . ':L' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                } else if ($first_language_total < 35) {
                                    // $this->cellColor('J' . $excel_row . ':L' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                }
                                $lang_total += $first_language_total;
                            } else if ($mark->subject_code == '12') {
                                $first_language_code = $mark->subject_code;
                                $first_language_name = "FRENCH";
                                $first_lan_TH =  $mark->obt_theory_mark;
                                $first_lan_IA =  $mark->obt_lab_mark;
                                $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;
                                if ($first_lan_TH < 24) {
                                    $this->cellColor('J' . $excel_row . ':L' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                } else if ($first_language_total < 35) {
                                    // $this->cellColor('J' . $excel_row . ':L' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                }
                                $lang_total += $first_language_total;
                            } else if ($mark->subject_code == '2') {
                                $second_lang_mark = $mark->obt_theory_mark;
                                $second_lang_mark_lab =  $mark->obt_lab_mark;
                                $second_language_total =  (int)$second_lang_mark + (int)$second_lang_mark_lab;
                                if ($second_lang_mark < 24) {
                                    $this->cellColor('F' . $excel_row . ':H' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                } else if ($second_language_total < 35) {
                                    // $this->cellColor('F' . $excel_row . ':H' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                }
                                $lang_total += $second_language_total;
                            } else {
                                $sub_theory_mark = 0;
                                $sub_lab_mark = 0;
                                for ($i = 0; $i < 4; $i++) {
                                    if ($mark->subject_code == $subjects[$i]) {
                                        if ($mark->lab_status == 'true') {
                                            $sub_theory_mark = (int)$mark->obt_theory_mark;
                                            $sub_lab_mark = (int)$mark->obt_lab_mark;
                                            $subject_total[$i] = $sub_theory_mark + $sub_lab_mark;
                                            if ($sub_theory_mark < 21) {
                                                $this->cellColor($first_cell[$i] . $excel_row . ':' . $last_cell[$i] . $excel_row, 'FFEE58');
                                                $fail_flag = true;
                                            } else if (($sub_theory_mark + $sub_lab_mark) < 35) {
                                                // $this->cellColor($first_cell[$i] . $excel_row . ':' . $last_cell[$i] . $excel_row, 'FFEE58');
                                                $fail_flag = true;
                                            }
                                            $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . $excel_row, $mark->obt_theory_mark);
                                            $this->excel->setActiveSheetIndex($sheet)->setCellValue($middle_cell[$i] . $excel_row, $mark->obt_lab_mark);
                                            if($mark->obt_theory_mark == "AB" || $mark->obt_theory_mark == "MP" || $mark->obt_theory_mark == "SAT"){
                                                if($mark->obt_lab_mark!="AB" && $mark->obt_lab_mark!="MP" && $mark->obt_lab_mark!="SAT"){
                                                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . $excel_row,  $mark->obt_lab_mark);
                                                }else{
                                                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . $excel_row,  $mark->obt_theory_mark);
                                                }
                                            }else{
                                              $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . $excel_row,  $sub_theory_mark + $sub_lab_mark);  
                                            }
                                        } else {
                                            $sub_theory_mark = (int)$mark->obt_theory_mark;
                                            $sub_lab_mark = (int)$mark->obt_lab_mark;
                                            $subject_total[$i] = $sub_theory_mark + $sub_lab_mark;
                                            if ($sub_theory_mark < 24) {
                                                $fail_flag = true;
                                                $this->cellColor($first_cell[$i] . $excel_row . ':' . $last_cell[$i] . $excel_row, 'FFEE58');
                                            } else if (($sub_theory_mark + $sub_lab_mark) < 35) {
                                                // $this->cellColor($first_cell[$i] . $excel_row . ':' . $last_cell[$i] . $excel_row, 'FFEE58');
                                                $fail_flag = true;
                                            }
                                            $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . $excel_row, $mark->obt_theory_mark);
                                            $this->excel->setActiveSheetIndex($sheet)->setCellValue($middle_cell[$i] . $excel_row, $mark->obt_lab_mark);
                                            if($mark->obt_theory_mark == "AB" || $mark->obt_theory_mark == "MP" || $mark->obt_theory_mark == "SAT"){
                                                if($mark->obt_lab_mark!="AB" && $mark->obt_lab_mark!="MP" && $mark->obt_lab_mark!="SAT"){
                                                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . $excel_row,  $mark->obt_lab_mark);
                                                }else{
                                                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . $excel_row,  $mark->obt_theory_mark);
                                                }
                                            }else{
                                                $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . $excel_row,  $sub_theory_mark + $sub_lab_mark);  
                                            }
                                        }
                                        $total_marks_subjects +=  $sub_theory_mark + $sub_lab_mark;
                                    }
                                }
                            }
                        }

                        // if ($fail_flag == true) {
                        //     if($total_marks_subjects >= 140){
                        //         if($subject_total[0] >= 30 && $subject_total[1] >= 30 && $subject_total[2] >= 30 && $subject_total[3] >= 30){
                        //             $fail_flag = false;
                        //         }else{
                        //             $fail_flag = true;
                        //         }

                        //     if ($row->elective_sub != "EXEMPTED") {
                        //         if ($lang_total >= 70) {
                        //             if ($first_language_total >= 30 && $second_language_total >= 30) {
                        //                 $fail_flag = false;
                        //             }else {
                        //                 $fail_flag = true;
                        //             }
                        //         }else {
                        //             $fail_flag = true;
                        //         }
                        //     }
                        //     }
                        // }

                        if($main_fail == true){
                            $fail_flag = true;
                        }else{
                            if ($fail_flag == true) {
                                if ($total_marks_subjects >= 140) {
                                    // Check if any subject has marks less than 30
                                    $subject_failed = false;
                                    foreach ($subject_total as $subject) {
                                        if ($subject < 30) {
                                            $subject_failed = true;
                                            break;
                                        }
                                    }
                            
                                    if (!$subject_failed) {
                                        $fail_flag = false; 
                                    } else {
                                        $fail_flag = true; // Fail if any subject is less than 30
                                    }
                            
                                    if ($row->elective_sub != "EXEMPTED") {
                                        if ($lang_total >= 70) {
                                            if ($first_language_total >= 30 && $second_language_total >= 30) {
                                                if (!$subject_failed) { 
                                                    $fail_flag = false; 
                                                } else {
                                                    $fail_flag = true; // Fail due to subject failure
                                                }
                                            } else {
                                                $fail_flag = true;
                                            }
                                        } else {
                                            $fail_flag = true;
                                        }
                                    }
                                }
                            }
                        }
                        // if($first_language_total >= 35 && (int)$second_lang_mark >= 35){
                        //     if($total_marks_subjects >= 140){
                        //         if($subject_total[0] >= 30 && $subject_total[1] >= 30 && $subject_total[2] >= 30 && $subject_total[3] >= 30){
                        //             $fail_flag = false;
                        //         }else{
                        //             $fail_flag = true;
                        //         }
                        //         // if($first_language_total >= 35){
                        //         //     $fail_flag = false; 
                        //         // }else{
                        //         //     $fail_flag = true;
                        //         // }
        
                        //         // if($second_lang_mark >= 35){
                        //         //     $fail_flag = false; 
                        //         // }else{
                        //         //     $fail_flag = true;
                        //         // }
                                
                        //     }}


                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $j++);
                        //student info
                        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->student_id);
                        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->sat_number);
                        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, strtoupper($row->student_name));
                    $this->excel->getActiveSheet()->getStyle('C'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                        //adding first Language
                        // $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;
                        if($row->elective_sub == "EXEMPTED"){
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, "EXEM");
                        }else{
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row,  $first_language_name);
                        }
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row,  $first_language_code);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('J' . $excel_row, $first_lan_TH);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('K' . $excel_row,  $first_lan_IA);
                        if($first_lan_TH == "AB" || $first_lan_TH == "SAT" || $first_lan_TH == "MP"){
                            if($first_lan_IA!="AB" && $first_lan_IA!="MP" && $first_lan_IA!="SAT"){
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L' . $excel_row, $first_lan_IA);
                            }else{
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L' . $excel_row, $first_lan_TH);
                            }
                        }else{
                          $this->excel->setActiveSheetIndex($sheet)->setCellValue('L' . $excel_row, $first_language_total); 
                        }
                        if($row->elective_sub == "EXEMPTED"){
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('J' . $excel_row, "EX");
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('K' . $excel_row,  "EX");
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('L' . $excel_row, "EX");
                        }
                        //second Language
                        $total_language_mark = $first_language_total + (int)$second_language_total;
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $second_lang_mark);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $second_lang_mark_lab);
                        if($second_lang_mark == "AB" || $second_lang_mark == "SAT" || $second_lang_mark == "MP"){
                            if($second_lang_mark_lab!="AB" && $second_lang_mark_lab!="MP" && $second_lang_mark_lab!="SAT"){
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $second_lang_mark_lab);
                            }else{
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $second_lang_mark);
                            }
                        }else{
                          $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $second_language_total);
                        }
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('M' . $excel_row, $total_language_mark);
                        $total_marks_all_subjects = $total_marks_subjects + (int)$first_language_total + (int)$second_language_total;
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('Z' . $excel_row, $total_marks_subjects);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('AA' . $excel_row, $total_marks_all_subjects);
                        if ($fail_flag == true) {
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('AB' . $excel_row, "Failed");
                        } else {
                            if($row->elective_sub == "EXEMPTED"){
                            $result = $this->calculateResultExem($total_marks_all_subjects);
                            }else{
                            $result = $this->calculateResult($total_marks_all_subjects);
                            }
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('AB' . $excel_row, $result);
                        }
                        $excel_row++;
                    }
                }
                $this->excel->createSheet();
            }
        } else {
            for ($sheet = 0; $sheet < count($streams); $sheet++) {
                $current_stream = $streams[$sheet];
                $subjects = $this->getSubjectCodes($current_stream);
                $this->excel->setActiveSheetIndex($sheet);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle($current_stream);
                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                $this->excel->getActiveSheet()->setCellValue('A2', "I PUC  ANNUAL EXAMINATION FAILED STUDENTS  RESULT ".EXAM_YEAR);
                $this->excel->getActiveSheet()->setCellValue('A3', "Abbreviation used in the table");
                $this->excel->getActiveSheet()->setCellValue('A4', "MO: Marks Obtained | IA: Internal Assessment | TH: Theory | PR: Practical | LT: Language Total | ST: Subjects Total | TM: Total Marks");
                $this->excel->getActiveSheet()->setCellValue('A5', "I PUC " . $current_stream . " SECTION $sectionName");
                //change the font size 
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(12);
                $this->excel->getActiveSheet()->getStyle('A4')->getFont()->setSize(11);
                $this->excel->getActiveSheet()->getStyle('A5:Y5')->getFont()->setSize(13);
                $this->excel->getActiveSheet()->getStyle('A1:AB5')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->mergeCells('A1:AB1');
                $this->excel->getActiveSheet()->mergeCells('A2:AB2');
                $this->excel->getActiveSheet()->mergeCells('A3:AB3');
                $this->excel->getActiveSheet()->mergeCells('A4:AB4');
                // $this->excel->getActiveSheet()->mergeCells('A5:AA5');
                $this->excel->getActiveSheet()->mergeCells('D5:AB5');
                $this->excel->getActiveSheet()->mergeCells('A6:A7');
                $this->excel->getActiveSheet()->mergeCells('C6:C7');
                $this->excel->getActiveSheet()->mergeCells('B6:B7');
                $this->excel->getActiveSheet()->mergeCells('D6:D7');
                $this->excel->getActiveSheet()->mergeCells('E6:E7');
                $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->setCellValue('D5', "Color Abbreviation:- 1 Sub Failed - GREEN | 2 Sub Failed - BLUE | 3 Sub Failed - YELLOW | 4 or More Sub Failed - RED ");
                //settting border style 
                $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                $this->excel->getActiveSheet()->getStyle('A1:AB120')->applyFromArray($styleArray);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A6', 'SL.no');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B6', 'Student ID');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C6', 'SAT No.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D6', 'Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E6', 'Lang');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I6', 'Lng');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I7', 'Code');
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(11);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(38);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J6', 'Language');
                $this->excel->getActiveSheet()->mergeCells('F6:H6');
                $this->excel->getActiveSheet()->mergeCells('J6:L6');
                $this->excel->getActiveSheet()->mergeCells('Z6:Z7');
                $this->excel->getActiveSheet()->mergeCells('AA6:AA7');
                $this->excel->getActiveSheet()->mergeCells('AB6:AB7');
                // $this->excel->getActiveSheet()->mergeCells('Y6:AA7');
                $this->excel->getActiveSheet()->getStyle('G6:I6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F7', 'TH');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G7', 'IA');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H7', 'MO');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F6', 'English(2)');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J7', 'TH');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K7', 'IA');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L7', 'MO');
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('I7', 'Marks');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('M7', 'LT');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('Z6', 'ST');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('AA6', 'TM');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('AB6', 'Result');
                //$this->excel->getActiveSheet()->mergeCells('K2:M2');
                $excel_row = 7;
                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(6);
                $this->excel->getActiveSheet()->getColumnDimension('X')->setWidth(5);
                $this->excel->getActiveSheet()->getColumnDimension('Y')->setWidth(5);
                $this->excel->getActiveSheet()->getStyle('F1:F3')->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->getStyle('E6:AB120')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('I7:I999')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A6:AB7')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('K8:K150')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('X8:AB999')->getFont()->setBold(true);
                $this->cellColor('A6:AB7', 'D5DBDB');
                //first subject heading
                for ($i = 0; $i < 4; $i++) {
                    $subjectInfo = $this->subject->getSubjectsById($subjects[$i]);
                    $this->excel->getActiveSheet()->getColumnDimension($first_cell[$i])->setWidth(6);
                    $this->excel->getActiveSheet()->getColumnDimension($middle_cell[$i])->setWidth(6);
                    $this->excel->getActiveSheet()->getColumnDimension($last_cell[$i])->setWidth(6);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . '6', $subjectInfo->name . '(' . $subjects[$i] . ')');
                    $this->excel->getActiveSheet()->mergeCells($first_cell[$i] . '6:' . $last_cell[$i] . '6');
                    $this->excel->getActiveSheet()->getStyle($first_cell[$i] . '6:' . $last_cell[$i] . '6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    if ($subjectInfo->lab_status == "true") {
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . '7', 'TH');
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($middle_cell[$i] . '7', 'PR');
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . '7', 'MO');
                    } else {
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . '7', "TH");
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($middle_cell[$i] . '7', 'IA');
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . '7', 'MO');
                        // $this->excel->getActiveSheet()->mergeCells($first_cell[$i] . '7:' . $last_cell[$i] . '7');
                        // $this->excel->getActiveSheet()->getStyle($first_cell[$i] . '7:' . $last_cell[$i] . '7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        // $this->excel->getActiveSheet()->getColumnDimension($first_cell[$i])->setWidth(5);
                        // $this->excel->getActiveSheet()->getColumnDimension($middle_cell[$i])->setWidth(5);
                        // $this->excel->getActiveSheet()->getColumnDimension($last_cell[$i])->setWidth(5);
                    }
                }
                $data['studentsResult'] = $this->student->getStudentsToAddMark($term_name, $sectionName,$current_stream);
                $excel_row = 8;
                $sll_no = 1;
                foreach ($data['studentsResult']  as $row) {
                    $total_marks_subjects = 0;
                    $total_marks_all_subjects = 0;
                    $fail_flag = false;
                    $main_fail = false;
                    $first_language_code = "";
                    $first_language_name = "";
                    $total_language_mark = 0;
                    $data['studentsMarks'] = $this->student->getFullMarksOfStudent($row->student_id);

                    if (!empty($data['studentsMarks'])) {
                        $first_language_total = 0;
                        $second_language_total = 0;
                        $second_lang_mark_lab = 0;
                        $second_lang_mark = 0;
                        $first_lan_TH = 0;
                        $first_lan_IA = 0;
                        $subject_code_from_subjects = 0;
                        $failed_subject_codes = array();
                        $lang_total = 0;
                        foreach ($data['studentsMarks']  as $mark) {

                            $subject_true = false;
                            if ($mark->subject_code == '1') {
                                $first_language_code = $mark->subject_code;
                                $first_language_name = "KAN";
                                $first_lan_TH =  $mark->obt_theory_mark;
                                $first_lan_IA =  $mark->obt_lab_mark;
                                $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;
                                if ($first_lan_TH < 24) {
                                    array_push($failed_subject_codes, $first_language_code);
                                    $this->cellColor('J' . $excel_row . ':L' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                    $main_fail = true;
                                } else if ($first_language_total < 35) {
                                    array_push($failed_subject_codes, $first_language_code);
                                    // $this->cellColor('J' . $excel_row . ':L' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                }
                                $lang_total += $first_language_total;
                            } else if ($mark->subject_code == '3') {
                                $first_language_code = $mark->subject_code;
                                $first_language_name = "HINDI";
                                $first_lan_TH =  $mark->obt_theory_mark;
                                $first_lan_IA =  $mark->obt_lab_mark;
                                $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;
                                if ($first_lan_TH < 24) {
                                    array_push($failed_subject_codes, $first_language_code);
                                    $this->cellColor('J' . $excel_row . ':L' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                    $main_fail = true;
                                } else if ($first_language_total < 35) {
                                    array_push($failed_subject_codes, $first_language_code);
                                    // $this->cellColor('J' . $excel_row . ':L' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                }
                                $lang_total += $first_language_total;
                            } else if ($mark->subject_code == '12') {
                                $first_language_code = $mark->subject_code;
                                $first_language_name = "FRENCH";
                                $first_lan_TH =  $mark->obt_theory_mark;
                                $first_lan_IA =  $mark->obt_lab_mark;
                                $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;
                                if ($first_lan_TH < 24) {
                                    array_push($failed_subject_codes, $first_language_code);
                                    $this->cellColor('J' . $excel_row . ':L' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                    $main_fail = true;
                                } else if ($first_language_total < 35) {
                                    array_push($failed_subject_codes, $first_language_code);
                                    // $this->cellColor('J' . $excel_row . ':L' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                }
                                $lang_total += $first_language_total;
                            } else if ($mark->subject_code == '2') {
                                $second_lang_mark = $mark->obt_theory_mark;
                                $second_lang_mark_lab =  $mark->obt_lab_mark;
                                $second_language_total =  (int)$second_lang_mark + (int)$second_lang_mark_lab;
                                // if ($second_language_total < 35) {
                                //     array_push($failed_subject_codes, $mark->subject_code);
                                //     $this->cellColor('E' . $excel_row . ':G' . $excel_row, 'FFEE58');
                                //     $fail_flag = true;
                                // }
                                if ($second_lang_mark < 24) {
                                    array_push($failed_subject_codes, $first_language_code);
                                    $this->cellColor('F' . $excel_row . ':H' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                    $main_fail = true;
                                } else if ($second_language_total < 35) {
                                    array_push($failed_subject_codes, $first_language_code);
                                    // $this->cellColor('F' . $excel_row . ':H' . $excel_row, 'FFEE58');
                                    $fail_flag = true;
                                }
                                $lang_total += $second_language_total;
                            } else {
                                $sub_theory_mark = 0;
                                $sub_lab_mark = 0;
                                for ($i = 0; $i < 4; $i++) {
                                    if ($mark->subject_code == $subjects[$i]) {
                                        if ($mark->lab_status == 'true') {
                                            $sub_theory_mark = (int)$mark->obt_theory_mark;
                                            $sub_lab_mark = (int)$mark->obt_lab_mark;
                                            if ($sub_theory_mark < 21) {
                                                array_push($failed_subject_codes, $mark->subject_code);
                                                $this->cellColor($first_cell[$i] . $excel_row . ':' . $last_cell[$i] . $excel_row, 'FFEE58');
                                                $fail_flag = true;
                                                $main_fail = true;
                                            } else if (($sub_theory_mark + $sub_lab_mark) < 35) {
                                                array_push($failed_subject_codes, $mark->subject_code);
                                                // $this->cellColor($first_cell[$i] . $excel_row . ':' . $last_cell[$i] . $excel_row, 'FFEE58');
                                                $fail_flag = true;
                                            }
                                        } else {
                                            $sub_theory_mark = (int)$mark->obt_theory_mark;
                                            $sub_lab_mark = (int)$mark->obt_lab_mark;
                                            if ($sub_theory_mark < 24) {
                                                array_push($failed_subject_codes, $mark->subject_code);
                                                $fail_flag = true;
                                                $main_fail = true;
                                                $this->cellColor($first_cell[$i] . $excel_row . ':' . $last_cell[$i] . $excel_row, 'FFEE58');
                                            }else  if (($sub_theory_mark + $sub_lab_mark) < 35) {
                                                array_push($failed_subject_codes, $mark->subject_code);
                                                $fail_flag = true;
                                                // $this->cellColor($first_cell[$i] . $excel_row . ':' . $last_cell[$i] . $excel_row, 'FFEE58');
                                            }
                                        }
                                        $total_marks_subjects +=  $sub_theory_mark + $sub_lab_mark;
                                    }
                                }
                            }
                        }

                        // if ($fail_flag == true) {
                        //     if($total_marks_subjects >= 140){
                        //         if($subject_total[0] >= 30 && $subject_total[1] >= 30 && $subject_total[2] >= 30 && $subject_total[3] >= 30){
                        //             $fail_flag = false;
                        //         }else{
                        //             $fail_flag = true;
                        //         }

                        //     if ($row->elective_sub != "EXEMPTED") {
                        //         if ($lang_total >= 70) {
                        //             if ($first_language_total >= 30 && $second_language_total >= 30) {
                        //                 $fail_flag = false;
                        //             }else {
                        //                 $fail_flag = true;
                        //             }
                        //         }else {
                        //             $fail_flag = true;
                        //         }
                        //     }
                        //     }
                        // }

                        if($main_fail == true){
                            $fail_flag = true;
                        }else{
                            if ($fail_flag == true) {
                                if ($total_marks_subjects >= 140) {
                                    // Check if any subject has marks less than 30
                                    $subject_failed = false;
                                    foreach ($subject_total as $subject) {
                                        if ($subject < 30) {
                                            $subject_failed = true;
                                            break;
                                        }
                                    }
                                    if (!$subject_failed) {
                                        $fail_flag = false; 
                                    } else {
                                        $fail_flag = true; // Fail if any subject is less than 30
                                    }
                                    if ($row->elective_sub != "EXEMPTED") {
                                        if ($lang_total >= 70) {
                                            if ($first_language_total >= 30 && $second_language_total >= 30) {
                                                if (!$subject_failed) { 
                                                    $fail_flag = false; 
                                                } else {
                                                    $fail_flag = true; // Fail due to subject failure
                                                }
                                            } else {
                                                $fail_flag = true;
                                            }
                                        } else {
                                            $fail_flag = true;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if ($fail_flag == true) {
                        $data['studentsMarks'] = $this->student->getFullMarksOfStudent($row->student_id);
                        foreach ($data['studentsMarks']  as $mark) {
                            for ($i = 0; $i < 4; $i++) {
                                if ($mark->subject_code == $subjects[$i]) {
                                    $sub_theory_mark = (int)$mark->obt_theory_mark;
                                    $sub_lab_mark = (int)$mark->obt_lab_mark;
                                    if ($mark->lab_status == 'true') {
                                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . $excel_row, $mark->obt_theory_mark);
                                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($middle_cell[$i] . $excel_row, $mark->obt_lab_mark);
                                        if($mark->obt_theory_mark == "AB" || $mark->obt_theory_mark == "MP" || $mark->obt_theory_mark == "SAT"){
                                            if($mark->obt_lab_mark!="AB" && $mark->obt_lab_mark!="MP" && $mark->obt_lab_mark!="SAT"){
                                                $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . $excel_row,  $mark->obt_lab_mark);
                                            }else{
                                                $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . $excel_row,  $mark->obt_theory_mark);
                                            }
                                            // $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . $excel_row, $mark->obt_theory_mark);
                                        }else{
                                            $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . $excel_row,  $sub_theory_mark + $sub_lab_mark);
                                        }
                                    } else {
                                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($first_cell[$i] . $excel_row, $mark->obt_theory_mark);
                                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($middle_cell[$i] . $excel_row, $mark->obt_lab_mark);
                                        if($mark->obt_theory_mark == "AB" || $mark->obt_theory_mark == "MP" || $mark->obt_theory_mark == "SAT"){
                                            if($mark->obt_lab_mark!="AB" && $mark->obt_lab_mark!="MP" && $mark->obt_lab_mark!="SAT"){
                                                $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . $excel_row,  $mark->obt_lab_mark);
                                            }else{
                                                $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . $excel_row,  $mark->obt_theory_mark);
                                            }
                                            // $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . $excel_row, $mark->obt_theory_mark);
                                        }else{
                                            $this->excel->setActiveSheetIndex($sheet)->setCellValue($last_cell[$i] . $excel_row,  $sub_theory_mark + $sub_lab_mark);
                                        }
                                        // $this->excel->getActiveSheet()->mergeCells($first_cell[$i] . $excel_row . ':' . $last_cell[$i] . $excel_row);
                                        // $this->excel->getActiveSheet()->getStyle($first_cell[$i] . $excel_row . ':' . $last_cell[$i] . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    }
                                }
                            }
                        }
                        if (count($failed_subject_codes) >= 4) {
                            for ($i = 0; $i < count($failed_subject_codes); $i++) {
                                if (in_array('1', $failed_subject_codes) || in_array('3', $failed_subject_codes) || in_array('12', $failed_subject_codes)) {
                                    $this->cellColor('J' . $excel_row . ':L' . $excel_row, 'E74C3C');
                                }
                                if (in_array('2', $failed_subject_codes)) {
                                    $this->cellColor('F' . $excel_row . ':H' . $excel_row, 'E74C3C');
                                }
                                for ($j = 0; $j < 4; $j++) {
                                    if (in_array($subjects[$j], $failed_subject_codes)) {
                                        $this->cellColor($first_cell[$j] . $excel_row . ':' . $last_cell[$j] . $excel_row, 'E74C3C');
                                    }
                                }
                            }
                        } else if (count($failed_subject_codes) == 2) {
                            for ($i = 0; $i < count($failed_subject_codes); $i++) {
                                if (in_array('1', $failed_subject_codes) || in_array('3', $failed_subject_codes) || in_array('12', $failed_subject_codes)) {
                                    $this->cellColor('J' . $excel_row . ':L' . $excel_row, '3498DB');
                                }
                                if (in_array('2', $failed_subject_codes)) {
                                    $this->cellColor('F' . $excel_row . ':H' . $excel_row, '3498DB');
                                }
                                for ($j = 0; $j < 4; $j++) {
                                    if (in_array($subjects[$j], $failed_subject_codes)) {
                                        $this->cellColor($first_cell[$j] . $excel_row . ':' . $last_cell[$j] . $excel_row, '3498DB');
                                    }
                                }
                            }
                        } else if (count($failed_subject_codes) == 1) {
                            for ($i = 0; $i < count($failed_subject_codes); $i++) {
                                if (in_array('1', $failed_subject_codes) || in_array('3', $failed_subject_codes) || in_array('12', $failed_subject_codes)) {
                                    $this->cellColor('J' . $excel_row . ':L' . $excel_row, '28B463');
                                }
                                if (in_array('2', $failed_subject_codes)) {
                                    $this->cellColor('F' . $excel_row . ':H' . $excel_row, '28B463');
                                }
                                for ($j = 0; $j < 4; $j++) {
                                    if (in_array($subjects[$j], $failed_subject_codes)) {
                                        $this->cellColor($first_cell[$j] . $excel_row . ':' . $last_cell[$j] . $excel_row, '28B463');
                                    }
                                }
                            }
                        }
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $sll_no);
                        //student info
                        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->student_id);
                        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->sat_number);
                        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, strtoupper($row->student_name));
                    $this->excel->getActiveSheet()->getStyle('C'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        //adding first Language
                        // $first_language_total =  (int)$first_lan_TH + (int)$first_lan_IA;
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row,  $first_language_name);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('I' . $excel_row,  $first_language_code);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('J' . $excel_row, $first_lan_TH);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('K' . $excel_row,  $first_lan_IA);
                        if($first_lan_TH == "AB" || $first_lan_TH == "SAT" || $first_lan_TH == "MP"){
                            if($first_lan_IA!="AB" && $first_lan_IA!="MP" && $first_lan_IA!="SAT"){
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L' . $excel_row, $first_lan_IA);
                            }else{
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L' . $excel_row, $first_lan_TH);
                            }
                          }else{
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('L' . $excel_row, $first_language_total); 
                          }
                        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $first_language_total);
                        //second Language
                        $total_language_mark = $first_language_total + (int)$second_language_total;
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $second_lang_mark);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $second_lang_mark_lab);
                        if($second_lang_mark == "AB" || $second_lang_mark == "SAT" || $second_lang_mark == "MP"){
                            if($second_lang_mark_lab!="AB" && $second_lang_mark_lab!="MP" && $second_lang_mark_lab!="SAT"){
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $second_lang_mark_lab);
                            }else{
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $second_lang_mark);
                            }
                          }else{
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue('H' . $excel_row, $second_language_total);
                          }
                        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('K' . $excel_row, $second_language_total);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('M' . $excel_row, $total_language_mark);
                        $total_marks_all_subjects = $total_marks_subjects + (int)$first_language_total + (int)$second_language_total;
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('Z' . $excel_row, $total_marks_subjects);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('AA' . $excel_row, $total_marks_all_subjects);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('AB' . $excel_row, "Failed");
                        $excel_row++;
                        $sll_no++;
                    }
                }
                $this->excel->createSheet();
            }
        }
        $filename = 'just_some_random_name.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        ob_start();
        $objWriter->save("php://output");
        $xlsData = ob_get_contents();
        ob_end_clean();
        $response =  array(
            'op' => 'ok',
            'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
        );
        die(json_encode($response));
    }
    
    public function downloadMiscellaneousFeePaidReport(){
        if($this->isAdmin() == TRUE) {
            setcookie('isDownLoaded',1);
            $this->loadThis();
        } else {  
            $filter = array();
            $miscellaneous_type = $this->security->xss_clean($this->input->post('miscellaneous_type'));
            $date_from = $this->security->xss_clean($this->input->post('date_from'));
            $date_to = $this->security->xss_clean($this->input->post('date_to'));
            $reportFormat = $this->security->xss_clean($this->input->post('reportFormat'));
            $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
            $misc_year = $this->security->xss_clean($this->input->post('misc_year'));
            $display_year = $misc_year . '-' . substr($misc_year + 1, 2);
            if(!empty($date_from)){
                $filter['date_from'] = date('Y-m-d',strtotime($date_from));
            }else{
                $filter['date_from'] = '';
            }
            if(!empty($date_to)){
                $filter['date_to'] = date('Y-m-d',strtotime($date_to));
            }else{
                $filter['date_to'] = '';
            }
            $filter['misc_year'] = $misc_year;
            if($payment_type[0] == 'ALL'){
                $filter['payment_type'] = '';
                }else{
                $filter['payment_type'] = $payment_type;
            }
            if($miscellaneous_type[0] == 'ALL'){
                $filter['miscellaneous_type'] = '';
            }else{
                $filter['miscellaneous_type'] = $miscellaneous_type;
            }
            if($reportFormat == 'VIEW'){
                setcookie('isDownloading',0);
                $data['dt_filter'] = $filter;
                //$data['miscellaneous'] = $miscellaneous;
                $data['fee'] = $this->fee;
                $data['display_year'] = $display_year;
                $data['misc_year'] = $misc_year;
                $this->global['pageTitle'] = ''.TAB_TITLE.' : MISCELLANEOUS FEE INFO '.$display_year;
                $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman']);
                $mpdf->AddPage('P','','','','',10,10,10,10,8,8);
                $mpdf->SetTitle('MISCELLANEOUS FEE INFO');
                $html = $this->load->view('reports/misView',$data,true);
                $mpdf->WriteHTML($html);
                $mpdf->Output('MIS.pdf', 'I');                                                              
            }else{
                // $filter['miscellaneous_type'] = $miscellaneous_type;
                $report_date = date('d-m-Y');
                $sheet = 0;
                $this->excel->setActiveSheetIndex($sheet);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle("MISCELLANEOUS FEE INFO");
                $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:J500');
                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                $this->excel->getActiveSheet()->setCellValue('A2'," MISCELLANEOUS FEE INFO ".$display_year);
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->mergeCells('A1:M1');
                $this->excel->getActiveSheet()->mergeCells('A2:M2');
                $this->excel->getActiveSheet()->getStyle('A1:M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A1:M1')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(35);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(27);
                $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL. NO.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Paid Date');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Receipt No');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Student Status');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Student Id');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Term');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H3', 'Stream');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I3', 'Miscellaneous Type');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J3', 'Amount');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K3', 'Payment Type');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L3', 'Transaction ID');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('M3', 'Bank Settlemnt date');
                $this->excel->getActiveSheet()->getStyle('A3:M3')->getAlignment()->setWrapText(true); 
                $this->excel->getActiveSheet()->getStyle('A3:M3')->getFont()->setBold(true); 
                $this->excel->getActiveSheet()->getStyle('A3:M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                $this->excel->getActiveSheet()->getStyle('A1:M3')->applyFromArray($styleBorderArray);
                $j=1;
                $excel_row = 4;
                // for($i=0; $i<count($miscellaneous);$i++){
                /// $filter['miscellaneous'] = $miscellaneous[$i];
                    $miscellaneousFeePaidInfo = $this->fee->getMiscellaneousFeesInfoReport($filter);
                    foreach($miscellaneousFeePaidInfo as $fee){
                        if(empty($fee->qnty)){
                            $total_amount =  $fee->amount;   
                        }else {
                            $total_amount = $fee->qnty * $fee->amount;
                        }
                        if(date('d-m-Y',strtotime($fee->bank_settlement_date)) == '30-11--0001' || date('d-m-Y',strtotime($fee->bank_settlement_date)) == '01-01-1970' || $fee->bank_settlement_date == '0000-00-00'){
                            $date = '';
                        }else{
                            $date = date('d-m-Y',strtotime($fee->bank_settlement_date));
                        }
                        if($fee->payment_type == 'NEFT'){ 
                            $transaction_id = $fee->ref_number; 
                        }elseif($fee->payment_type == 'UPI'){ 
                            $transaction_id = $fee->upi_ref_no; 
                        }elseif($fee->payment_type == 'CARD' || $fee->payment_type == 'BANK' || $fee->payment_type == 'UPI'){ 
                            $transaction_id = $fee->transaction_number; 
                        }else{ 
                            $transaction_id = $fee->order_id; 
                        } 
                        if($fee->student_status == 'Active'){
                            $student_status = 'ACTIVE/ALUMNI';
                        }else{
                            $student_status = $fee->student_status;
                        }
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, date('d-m-Y',strtotime($fee->date)));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, $fee->receipt_no);  
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, $student_status);              
                        $this->excel->setActiveSheetIndex($sheet)->setCellValueExplicit('E'.$excel_row, $fee->register_no,PHPExcel_Cell_DataType::TYPE_STRING);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, strtoupper($fee->student_name));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, $fee->term);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, $fee->stream);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row, $fee->miscellaneous_type);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row, $fee->amount);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row, $fee->payment_type);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValueExplicit('L'.$excel_row, $transaction_id,PHPExcel_Cell_DataType::TYPE_STRING);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('M'.$excel_row, $date);
                        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row,  $total_amount);
                        $this->excel->getActiveSheet()->getStyle('J' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
                        $total_misc_amt += $fee->amount;
                        $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':M'.$excel_row)->applyFromArray($styleBorderArray);
                        $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':E'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $this->excel->getActiveSheet()->getStyle('F'.$excel_row.':M'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $excel_row++;
                    }
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row, 'TOTAL');
                    $this->excel->getActiveSheet()->getStyle('G'.$excel_row.':M'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row,$total_misc_amt);
                    $this->excel->getActiveSheet()->getStyle('J' . $excel_row)->getNumberFormat()->setFormatCode('#,##0.00');
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row,"=SUM(K4:K".($excel_row-1).")");
                    $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':M'.$excel_row)->getFont()->setBold(true);
                // }
                $this->excel->createSheet(); 
                $filename ='Miscellaneous_Fee_Report_'.$report_date.'.xls'; //save our workbook as this file name
                header('Content-Type: application/vnd.ms-excel'); //mime type
                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
                ob_start();
                setcookie('isDownLoaded',1);
                $objWriter->save("php://output");
            }
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
        $CEBA = array("41", "22", "27", '30');
        $PEBA = array("29", "22", "27", '30');
        //art
        $HEPP = array("21", "22", "32", '29');
        $MEBA = array("75", "22", "27", '30');
        $MSBA = array("75", "31", "27", '30');
        $HEPS = array("21", "22", "29", '28');
        $HEBA = array("21", "22", "27", "30");

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
            case "EBAS":
                return $EBAS;
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
            case "HEBA":
                return $HEBA;
                break;
        }
    }


    function calculateResult($total_marks)
    {
        $percentage = floor(($total_marks / 600) * 100);
        if ($percentage >= 85) {
            return "Distinction";
        } else if ($percentage >= 60 && $percentage <= 84) {
            return "I Class";
        } else if ($percentage >= 50 && $percentage <= 59) {
            return "II Class";
        } else if ($percentage >= 35 && $percentage <= 49) {
            return "III Class";
        } else {
            return "Fail";
        }
    }

    public function downloadStudentSiblingExcelReport() {
        if($this->isAdmin() == TRUE) {
            setcookie('isDownloading', 0);
            $this->loadThis();
        } else {
            set_time_limit(0);
            ini_set('memory_limit', '256M');
            $filter = array();
            $term = $this->security->xss_clean($this->input->post('term'));
            $section_name = $this->security->xss_clean($this->input->post('section_namee'));
            if (!empty($term)) {
                $filter['term'] = $term;
                $data['term'] = $term;
            }
            
            $filter['section_name'] = $section_name;
            $sectiontitle = ($section_name == "") ? 'ALL' : $section_name;
            $termtitle = ($term == "") ? 'ALL' : $term;
            $sheet = 0;
            $date = date('Y');
            $this->excel->setActiveSheetIndex($sheet);
            $this->excel->getActiveSheet()->setTitle($termtitle);
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:K500');
            // Set general headers
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', "SIBLING REPORT - " . $termtitle . " - " . $sectiontitle);
            $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:H1');
            $this->excel->getActiveSheet()->mergeCells('A2:H2');
            // Adjust column widths
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);  // Name
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);  // Class
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(18);
            // Set main headers
            $this->excel->getActiveSheet()->setCellValue('A4', 'SL. NO.');
            $this->excel->getActiveSheet()->setCellValue('B4', 'APPLICATION NO');
            $this->excel->getActiveSheet()->setCellValue('C4', 'NAME OF THE STUDENT');
            $this->excel->getActiveSheet()->setCellValue('D4', 'CLASS');
            $this->excel->getActiveSheet()->setCellValue('E4', 'SECTION');
            $this->excel->getActiveSheet()->setCellValue('F4', 'FATHER MOB NO.');
            $this->excel->getActiveSheet()->setCellValue('G4', 'MOTHER MOB NO.');
            // Determine max sibling count
            $students = $this->student->getStudentSiblingInfoForReportDownload($filter);
            $maxSiblings = 0;
            usort($students, function($a, $b) {
                // First compare by class (ascending order)
                if ($a->term_name != $b->term_name) {
                    return strcmp($a->term_name, $b->term_name);
                }
                // If classes are the same, compare by name (ascending order)
                return strcmp(strtoupper($a->student_name), strtoupper($b->student_name));
            });
            foreach ($students as $student) {
                $siblingInfo = $this->student->getSiblingsByMobile($student->father_mobile, $student->mother_mobile, $student->row_id);
                $maxSiblings = max($maxSiblings, count($siblingInfo));
            }
            // Create "SIBLINGS" merged header based on max sibling count
            $startColumn = 'H';
            if ($maxSiblings > 0) {
                $endColumn = chr(ord($startColumn) + ($maxSiblings * 4) - 1);
            } else {
                $endColumn = $startColumn;
            }
            // Validate range and set header
            if (ord($endColumn) <= ord('XFD')) {
                $this->excel->getActiveSheet()->mergeCells("H3:{$endColumn}3");
                $this->excel->getActiveSheet()->setCellValue("H3", "SIBLINGS");
            }
            // Generate sibling sub-headers
            $column = 'H';
            for ($i = 1; $i <= $maxSiblings; $i++) {
                $this->excel->getActiveSheet()->mergeCells("{$column}4:" . chr(ord($column) + 3) . "4");
                $this->excel->getActiveSheet()->setCellValue("{$column}4", "Sibling {$i}");
                $this->excel->getActiveSheet()->setCellValue("{$column}5","Appln.No");
                $this->excel->getActiveSheet()->setCellValue(chr(ord($column) + 1) . "5", "Name");
                $this->excel->getActiveSheet()->setCellValue(chr(ord($column) + 2) . "5", "Class");
                $this->excel->getActiveSheet()->setCellValue(chr(ord($column) + 3) . "5", "Section");
                $this->excel->getActiveSheet()->getColumnDimension($column)->setWidth(20);          // Width for "sat no"
                $this->excel->getActiveSheet()->getColumnDimension(chr(ord($column) + 1))->setWidth(20);  // Width for "name"
                $this->excel->getActiveSheet()->getColumnDimension(chr(ord($column) + 2))->setWidth(10);  // Width for "class"
                $this->excel->getActiveSheet()->getColumnDimension(chr(ord($column) + 3))->setWidth(10);  // Width for "section"

                $column = chr(ord($column) + 4);
            }
            // Apply border styling to header cells
            $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle("A3:{$endColumn}5")->applyFromArray($styleArray);
            // Set data alignment and styling for headers
            $this->excel->getActiveSheet()->getStyle("A3:{$endColumn}5")->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle("A3:{$endColumn}5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // Fill student data
            $excel_row = 6;
            $j = 1;
            foreach ($students as $student) {
                $siblingInfo = $this->student->getSiblingsByMobile($student->father_mobile, $student->mother_mobile, $student->row_id);
                // Set main student information
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $j++);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B' . $excel_row, $student->application_no);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C' . $excel_row, strtoupper($student->student_name));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D' . $excel_row, $student->term_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E' . $excel_row, $student->section_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F' . $excel_row, $student->father_mobile);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G' . $excel_row, $student->mother_mobile);
                // Add sibling information
                $column = 'H';
                foreach ($siblingInfo as $sibling) {
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue("{$column}{$excel_row}",$sibling->application_no);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue(chr(ord($column) + 1) . "{$excel_row}",strtoupper($sibling->std_name));
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue(chr(ord($column) + 2) . "{$excel_row}",$sibling->class);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue(chr(ord($column) + 3) . "{$excel_row}", $sibling->section_name);
                    $column = chr(ord($column) + 4);
                }
                $this->excel->getActiveSheet()->getStyle("A{$excel_row}:{$endColumn}{$excel_row}")->applyFromArray($styleArray);
                $excel_row++;
            }
            // Save and download the Excel file
            ob_end_clean();
            $filename = "{$termtitle}_SIBLING_REPORT.xls";
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment; filename=\"{$filename}\"");
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            setcookie('isDownloading', 0);
            $objWriter->save("php://output");
        }
    }

     public function downloadStudentExcelReport_instudentlisting()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
            
        } else {
            $filter = array();
            $fields = $this->security->xss_clean($this->input->post('fields'));
            $student_json = $this->input->post('students2');
            $student_ids = json_decode($student_json, true);
         
           
            $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
            $total_fields = count($fields);

            $curr_year = date('Y');
            $sheet = 0;
        
                $this->excel->setActiveSheetIndex($sheet);
                //name the worksheet
                //$this->excel->getActiveSheet()->setTitle($preferences[$sheet]);
                $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');
                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
               // $this->excel->getActiveSheet()->setCellValue('A2', $term . ' ' . $preferences[$sheet] . ' INFORMATION ' . '-' . $gender . '-' . $religion . '-' . $curr_year);
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->mergeCells('A1:' . $cellName[$total_fields] . '1');
                $this->excel->getActiveSheet()->mergeCells('A2:' . $cellName[$total_fields] . '2');
                $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A1:' . $cellName[$total_fields] . '2')->getFont()->setBold(true);



                // $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
                // $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
                // $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
                // $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
                // $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
                // $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
                // $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
                // $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
                // $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
                // $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
                // $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
                // $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
                // $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
                // $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
                // $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);

                $excel_row = 3;
                $cell = 1;
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL No.');

                for ($h = 1; $h <= $total_fields; $h++) {
                if ($fields[$h - 1] == 'student_name') {
                    $this->excel->getActiveSheet()->getColumnDimension($cellName[$h])->setWidth(30);
                }else{
                    $this->excel->getActiveSheet()->getColumnDimension($cellName[$h])->setWidth(18);
                }
                $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellName[$h] . $excel_row, $fields[$h - 1]);
            }
                $this->excel->getActiveSheet()->getStyle('A3:' . $cellName[$total_fields] . '3')->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->getStyle('A3:' . $cellName[$total_fields] . '3')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A3:' . $cellName[$total_fields] . '3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


                $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                $this->excel->getActiveSheet()->getStyle('A1:' . $cellName[$total_fields] . $total_fields)->applyFromArray($styleBorderArray);

                // $filter[$sheet] = $sheet;
                //$filter['preference'] = $preferences[$sheet];

                 $students = $this->student->getStudentInfoForReportDownloadnew($filter, $student_ids);

                //log_message('debug','test=='.print_r($students,true));
                $j = 1;
                $excel_row = 4;

                foreach ($students as $student) {
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A' . $excel_row, $j++);

                    for ($c = 1; $c <= $total_fields; $c++) {
                        // log_message('error', 'JSON=   ' .$student[$fields[$c-1]]);
                        if ($fields[$c - 1] == 'dob') {
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellName[$c] . $excel_row, date("d-m-Y", strtotime($student->dob)));
                        } else if ($fields[$c - 1] == 'student_name') {
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellName[$c] . $excel_row, strtoupper($student->student_name));
                        } else if ($fields[$c - 1] == 'doj') {
                            if ($student->doj != '1970-01-01' && $student->doj != '0000-00-00' && $student->doj != '') {
                                $doj = date("d-m-Y", strtotime($student->doj));
                            } else {
                                $doj = '';
                            }
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellName[$c] . $excel_row, $doj);
                        } else {
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellName[$c] . $excel_row, $student->{$fields[$c - 1]});
                        }
                    }


                    $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':' . $cellName[$total_fields] . $excel_row)->applyFromArray($styleBorderArray);
                    $this->excel->getActiveSheet()->getStyle('A' . $excel_row . ':B' . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('D' . $excel_row . ':' . $cellName[$total_fields] . $excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel_row++;
                }
                $this->excel->createSheet();
            
            $filename = $term . 'Student_Report_'  . '-' . $date . '.xls'; //save our workbook as this file name
         
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            ob_start();
               
            $objWriter->save("php://output");
            exit;

        }
    }
            public function downloadFeedBackPendingExcelReport(){

            if($this->isAdmin() == TRUE)
    
            {
    
                setcookie('isDownloading',0);
    
                $this->loadThis();
    
            } else
    
            {   
                 ini_set('memory_limit', '256M'); 
                $class_name = $this->security->xss_clean($this->input->post('class_name'));
                $section_name = $this->security->xss_clean($this->input->post('section_name'));
                $staff_type = $this->security->xss_clean($this->input->post('staff_type'));
                $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
                $filter = array();           
    
                if(!empty($class_name)){
    
                    $filter['class_name'] = $class_name;
    
                    $data['class_name'] = $class_name;
                    $class_heading = $class_name;
    
                }else{
                    $class_heading = 'ALL';
                }
    
                if(!empty($section_name)){
        
                    $data['section_name'] = $section_name;
                    if($section_name == 'ALL'){
                        $filter['section_name'] = '';
                       }else{
                        $filter['section_name'] = $section_name; 
                    }
                }  else{
                    $filter['section_name'] = 'ALL';

                }
                if(!empty($stream_name)){
                    $filter['stream_name'] = $stream_name;
                    $data['stream_name'] = $stream_name;
                }

                $sheet = 0;
    
                $j=1;
    
                $excel_row = 6;
    
                // $section_name = $sections[$sheet];
    
                $this->excel->setActiveSheetIndex($sheet);
    
                $staffInfo = $this->feedback_model->getAllSchoolStaffInfo($filter);
    
                $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:H500');
    
                $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
    
                $this->excel->getActiveSheet()->setCellValue('A2', $class_heading.' - '.$stream_name.' - '.$section_name.' - '." Feedback Pending Report", EXCEL_YEAR);
    
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
    
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
    
                $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14);

                $this->excel->getActiveSheet()->getStyle('A1:A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
                $this->excel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
    
                $this->excel->getActiveSheet()->mergeCells('A1:C1');
    
                $this->excel->getActiveSheet()->mergeCells('A2:C2');
    
                $this->excel->getActiveSheet()->mergeCells('A3:C3');
    
                $questions =  $this->feedback_model->getTeachingStaffFeedbackQuestions25();
                // log_message('debug','staffInfo'.print_r($staffInfo,true));
           
                $num1 = 4;
                $num2 = 5;
                $num3 = 6;
                $excel_row = 7;
                $totalStudentsOverall = 0; // Overall total students
                $totalPendingOverall = 0; // Overall pending students

                foreach($staffInfo as $staff){
                $plusCount = 0;

                $isExist = $this->feedback_model->getSectionByStaffIdFeedback($staff->staff_id,$filter);
                if(!empty($isExist)){
                    $sl_no = 1;
                    // $stdCommentInfos = $this->feedback_model->getStudentCommentsAndSug22Report($staff->staff_id,$filter);
                    // $subjectInfo = $this->feedback_model->getAllSchoolSubjectByStaffIdNew($staff->staff_id,$filter['class_name'],$filter['section_name']);
                    // $SubjectArray = '';
                    // foreach($subjectInfo as $sub) {
                    //   $SubjectArray.=  $sub->sub_name.',';
                    // }
                $studentInformation =  $this->feedback_model->getStudentInfoByTerm($filter['class_name'],$section_name,$filter['stream_name']);                  
                
                $this->excel->getActiveSheet()->mergeCells('A'.$num1.':C'.$num1.'');
    
                $this->excel->getActiveSheet()->setCellValue('A'.$num1.'', $staff->name);
                $this->excel->getActiveSheet()->getStyle('A'.$num1.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A'.$num1.'')->getFont()->setSize(15);
    
                $this->excel->getActiveSheet()->mergeCells('B'.$num2.':C'.$num2.'');
                // $this->excel->getActiveSheet()->setCellValue('B'.$num2.'', "NO. OF RESPONDENTS: ".count($stdCommentInfos)."");
                $this->excel->getActiveSheet()->getStyle('B'.$num2.'')->getFont()->setBold(true);
    
                $this->excel->getActiveSheet()->getStyle('B'.$num2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             
    
                $this->excel->getActiveSheet()->getStyle('C'.$num2.':D'.$num2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
               
                $this->excel->getActiveSheet()->setCellValue('A'.$num3.'', "SL. NO.");
                $this->excel->getActiveSheet()->setCellValue('B'.$num3.'', "ROLL NO.");
                $this->excel->getActiveSheet()->getStyle('A'.$num3.'')->getFont()->setBold(true);
    
                $this->excel->getActiveSheet()->getStyle('A'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->setCellValue('C'.$num3.'', "NAME");
                // $this->excel->getActiveSheet()->setCellValue('D'.$num3.'', "COMMENTS");
            
                $this->excel->getActiveSheet()->getStyle('B'.$num3.':D'.$num3.'')->getFont()->setBold(true);
    
    
                $this->excel->getActiveSheet()->getStyle('B'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                // $this->excel->getActiveSheet()->getStyle('D'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $feedbackGivenStudentIds = array();
                $totalStudents = count($studentInformation);
                $totalStudentsOverall += $totalStudents;
                    foreach($studentInformation as $q){
                    $feedBackExist = $this->feedback_model->getIsStudentAddedFeedback($staff->staff_id,$q->student_id); 
             
                    // $feedbackPendingInfo =  $this->feedback_model->getfeedbackPendingInfo($class_name,$section_name,$stream_name,$feedbackGivenStudentIds); 

                    if(empty($feedBackExist)){
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$sl_no);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,$q->application_no);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,$q->student_name);
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,'');
         
    
                    $this->excel->getActiveSheet()->getStyle('A'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('B'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('C'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    // $this->excel->getActiveSheet()->getStyle('D'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    
    
                    $excel_row++;
                    $sl_no++;
                    $plusCount++;
                  }
                }
                $totalPendingOverall += $plusCount; 
                $pendingPercentage = ($plusCount / $totalStudents) * 100;
                $givenCount = $totalStudents - $plusCount;
                $givenPercentage = ($givenCount / $totalStudents) * 100;
                $this->excel->getActiveSheet()->setCellValue('B'.$num2.'', "NO. OF PENDING STUDENTS: ".$plusCount."   PENDING PERCENTAGE: ".number_format($pendingPercentage,2). "%   GIVEN PERCENTAGE: ".number_format($givenPercentage,2). "%");
    
                $this->excel->getActiveSheet()->mergeCells('A'.$excel_row.':C'.$excel_row.'');
               
                $num1+= 4;
                $num2+= 4;
                $num3+= 4;
                $num1+= $plusCount;
                $num2+= $plusCount;
                $num3+= $plusCount;
                $excel_row+= 4;
                }
            }
            // Calculate overall percentages
                $overallPendingPercentage = ($totalPendingOverall / $totalStudentsOverall) * 100;
                $overallGivenPercentage = 100 - $overallPendingPercentage;
            $this->excel->getActiveSheet()->setCellValue(
                'A3',
                "OVERALL PENDING PERCENTAGE: " . number_format($overallPendingPercentage, 2) . "%" .
                "   OVERALL GIVEN PERCENTAGE: " . number_format($overallGivenPercentage, 2) . "%"
            );
            $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
    
                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
    
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
    
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
    
                // $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(100);
    
              
    
                $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
    
                $this->excel->getActiveSheet()->getStyle('A1:C4')->applyFromArray($styleBorderArray);
    
                $this->excel->getActiveSheet()->getStyle('A5:C1500')->applyFromArray($styleBorderArray);
    
               $filter['admission_type'] = $class_name;
       
    
                $this->excel->createSheet(); 
    
        
    
            $filename= $class_name.'Feedback_Pending_Report.xls'; //save our workbook as this file name
    
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

    //marks feedback given
    public function downloadFeedBackExcelReport(){
        if($this->isAdmin() == TRUE)
        {
            setcookie('isDownloading',0);
            $this->loadThis();
        } else
        {   
             $class_name = $this->security->xss_clean($this->input->post('class_name'));
                $section_name = $this->security->xss_clean($this->input->post('section_name'));
                $staff_type = $this->security->xss_clean($this->input->post('staff_type'));
                $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
                $filter = array();           
    
                if(!empty($class_name)){
    
                    $filter['class_name'] = $class_name;
    
                    $data['class_name'] = $class_name;
                    $class_heading = $class_name;
    
                }else{
                    $class_heading = 'ALL';
                }
    
                if(!empty($section_name)){
        
                    $data['section_name'] = $section_name;
                    if($section_name == 'ALL'){
                        $filter['section_name'] = '';
                       }else{
                        $filter['section_name'] = $section_name; 
                    }
                }  else{
                    $filter['section_name'] = 'ALL';

                }
                if(!empty($stream_name)){
                    $filter['stream_name'] = $stream_name;
                    $data['stream_name'] = $stream_name;
                }
             
            
            
        if($staff_type == 'Teaching Staff'){
            $sheet = 0;
            $j=1;
            $excel_row = 6;
            $this->excel->setActiveSheetIndex($sheet);
            $staffInfo = $this->feedback_model->getAllSchoolStaffInfo($filter);
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:H500');
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', $class_heading.' '.$section_name.' - '." Feedback Report");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->getStyle('A1:A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->mergeCells('A1:G1');
            $this->excel->getActiveSheet()->mergeCells('A2:G2');
            $this->excel->getActiveSheet()->mergeCells('A3:G3');
             $questions =  $this->feedback_model->getTeachingStaffFeedbackQuestions25();
            $countQuestions = count($questions);
            $countQuestions+= 4;
       
            $num1 = 4;
            $num2 = 5;
            $num3 = 6;
            $excel_row = 7;
            foreach($staffInfo as $staff){
            $isExist = $this->feedback_model->getSectionByStaffIdFeedback($staff->staff_id,$filter);

            if(!empty($isExist)){
                $sl_no = 1;
                $stdCommentInfos = $this->feedback_model->getStudentCommentsAndSug25($staff->staff_id,$filter);
                $subjectInfo = $this->feedback_model->getAllSchoolSubjectByStaffIdNew($staff->staff_id,$filter['class_name'],$section_name,$stream_name);
                $SubjectArray = '';
                foreach($subjectInfo as $sub) {
                  $SubjectArray.=  $sub->dept_name.',';
                }
                $SubjectArray = rtrim($SubjectArray, ',');

            $this->excel->getActiveSheet()->mergeCells('A'.$num1.':G'.$num1.'');

            $this->excel->getActiveSheet()->setCellValue('A'.$num1.'', $staff->name.' - '.$SubjectArray);
            $this->excel->getActiveSheet()->getStyle('A'.$num1.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A'.$num1.'')->getFont()->setSize(15);
            // $this->excel->getActiveSheet()->mergeCells('A5:C5');

            $this->excel->getActiveSheet()->mergeCells('C'.$num2.':G'.$num2.'');
            $this->excel->getActiveSheet()->setCellValue('B'.$num2.'', "NO. OF RESPONDENTS: ".count($stdCommentInfos)."");
            $this->excel->getActiveSheet()->getStyle('B'.$num2.'')->getFont()->setBold(true);

            $this->excel->getActiveSheet()->getStyle('B'.$num2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('C'.$num2.'', "PERCENTAGE OF RESPONDENTS' IMPRESSION");
            $this->excel->getActiveSheet()->getStyle('C'.$num2.'')->getFont()->setBold(true);

            $this->excel->getActiveSheet()->getStyle('C'.$num2.':G'.$num2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
           
            $this->excel->getActiveSheet()->setCellValue('A'.$num3.'', "SL. NO.");
            $this->excel->getActiveSheet()->setCellValue('B'.$num3.'', "CRITERIA");
            $this->excel->getActiveSheet()->getStyle('A'.$num3.'')->getFont()->setBold(true);

            $this->excel->getActiveSheet()->getStyle('A'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('C'.$num3.'', "EXCELLENT");
            $this->excel->getActiveSheet()->setCellValue('D'.$num3.'', "VERY GOOD");
            $this->excel->getActiveSheet()->setCellValue('E'.$num3.'', "GOOD");
            $this->excel->getActiveSheet()->setCellValue('F'.$num3.'', "SATISFACTORY");
            $this->excel->getActiveSheet()->setCellValue('G'.$num3.'', "UNSATISFACTORY");
            $this->excel->getActiveSheet()->getStyle('B'.$num3.':G'.$num3.'')->getFont()->setBold(true);


            $this->excel->getActiveSheet()->getStyle('B'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('C'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('D'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('E'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('F'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('G'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

           
                foreach($questions as $q){
                    $stdCommentInfo = $this->feedback_model->getStudentCommentsAndSug22Report($staff->staff_id,$filter);
                    $excellent_max_mark = count($stdCommentInfo) * 5;
                    $ver_good_max_mark = count($stdCommentInfo) * 4;
                    $good_max_mark = count($stdCommentInfo) * 3;
                    $average_max_mark = count($stdCommentInfo) * 2;
                    $poor_max_mark = count($stdCommentInfo) * 1;
                        
                    // $stdAnsCountExcellent_22 = $this->feedback_model->getCountOfStdAnswersExcellent_Good_22Report($staff->staff_id, $q->qid, 5,$filter);
                    $finalAnswer = $this->feedback_model->getCountOfStdAnswersExcellent_Good_25_report($staff->staff_id, $q->qid, 5,$filter);

                    $stdAnsCountExcellent_22 = count($finalAnswer) * 5;
                    $excellent_Percentage = ($stdAnsCountExcellent_22 / $excellent_max_mark);
                    $excellent_Percentage = $excellent_max_mark > 0 ? ($stdAnsCountExcellent_22 / $excellent_max_mark)  : 0;
                    $excellent_percentage_d = number_format($excellent_Percentage, 2, '.', '');

                    $finalAnswer = $this->feedback_model->getCountOfStdAnswersExcellent_Good_25_report($staff->staff_id, $q->qid, 4,$filter);
                    $stdAnsCountVeryGood_22 = count($finalAnswer) * 4;
                    $very_good_Percentage = ($stdAnsCountVeryGood_22 / $ver_good_max_mark);
                    $very_good_Percentage = $ver_good_max_mark > 0 ? ($stdAnsCountVeryGood_22 / $ver_good_max_mark)  : 0;
                    $very_good_Percentage_d = number_format($very_good_Percentage, 2, '.', '');

                    $finalAnswer = $this->feedback_model->getCountOfStdAnswersExcellent_Good_25_report($staff->staff_id, $q->qid, 3,$filter);
                    $stdAnsCountGood_22 = count($finalAnswer) * 3;
                    $good_Percentage = ($stdAnsCountGood_22 / $good_max_mark);
                    $good_Percentage = $good_max_mark > 0 ? ($stdAnsCountGood_22 / $good_max_mark)  : 0;
                    $good_Percentage_d = number_format($good_Percentage, 2, '.', '');

                    $finalAnswer = $this->feedback_model->getCountOfStdAnswersExcellent_Good_25_report($staff->staff_id, $q->qid, 2,$filter);
                    $stdAnsCountAvergae_22 = count($finalAnswer) * 2;
                    $average_Percentage = ($stdAnsCountAvergae_22 / $average_max_mark) ;
                    $average_Percentage = $average_max_mark > 0 ? ($stdAnsCountAvergae_22 / $average_max_mark)  : 0;
                    $average_Percentage_d = number_format($average_Percentage, 2, '.', '');


                    $finalAnswer = $this->feedback_model->getCountOfStdAnswersExcellent_Good_25_report($staff->staff_id, $q->qid, 1,$filter);
                    $stdAnsCountPoor_22 = count($finalAnswer) * 1;
                    $poor_percentage = ($stdAnsCountPoor_22 / $poor_max_mark) ;
                    $poor_percentage = $poor_max_mark > 0 ? ($stdAnsCountPoor_22 / $poor_max_mark)  : 0;
                    $poor_percentage_d = number_format($poor_percentage, 2, '.', '');

                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$sl_no);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,$q->question);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,$excellent_percentage_d);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,$very_good_Percentage_d);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,$good_Percentage_d);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$average_Percentage_d);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,$poor_percentage_d);

                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('D'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('E'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('F'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('G'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
                $sl_no++;
            }
            $this->excel->getActiveSheet()->mergeCells('A'.$excel_row.':G'.$excel_row.'');

            $num1+= $countQuestions;
            $num2+= $countQuestions;
            $num3+= $countQuestions;
            $excel_row+= 4;
            }
        }
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(95);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:G4')->applyFromArray($styleBorderArray);
            $this->excel->getActiveSheet()->getStyle('A5:G999')->applyFromArray($styleBorderArray);
            $filter['admission_type'] = $class_name;
            $this->excel->createSheet(); 
        $filename= $class_name.'Feedback_Report.xls'; //save our workbook as this file name
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

    }else{
        
        $sheet = 0;

        $j=1;

        $excel_row = 6;

        // $section_name = $sections[$sheet];

        $this->excel->setActiveSheetIndex($sheet);

       
        $staff = $this->feedback_model->getMyCounsellorStaffInfo();

        $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:H500');

        $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);

        $this->excel->getActiveSheet()->setCellValue('A2', $class_heading.' '.$section_name.' - '." Feedback Report");

        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);

        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

        $this->excel->getActiveSheet()->getStyle('A1:A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $this->excel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);

        $this->excel->getActiveSheet()->mergeCells('A1:F1');

        $this->excel->getActiveSheet()->mergeCells('A2:F2');

        $this->excel->getActiveSheet()->mergeCells('A3:F3');

        $questions =  $this->feedback_model->getCouncellorFeedbackQuestions2024();
        $countQuestions = count($questions);
        $countQuestions+= 4;
   
        $num1 = 4;
        $num2 = 5;
        $num3 = 6;
        $excel_row = 7;
        // foreach($staffInfo as $staff){
        
            $sl_no = 1;
            $stdCommentInfos = $this->feedback_model->getStudentCommentsAndSug24Report($staff->staff_id,$filter);
          

        $this->excel->getActiveSheet()->mergeCells('A'.$num1.':F'.$num1.'');

        $this->excel->getActiveSheet()->setCellValue('A'.$num1.'', $staff->name);
        $this->excel->getActiveSheet()->getStyle('A'.$num1.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A'.$num1.'')->getFont()->setSize(15);
        // $this->excel->getActiveSheet()->mergeCells('A5:C5');

        $this->excel->getActiveSheet()->mergeCells('C'.$num2.':F'.$num2.'');
        $this->excel->getActiveSheet()->setCellValue('B'.$num2.'', "NO. OF RESPONDENTS: ".count($stdCommentInfos)."");
        $this->excel->getActiveSheet()->getStyle('B'.$num2.'')->getFont()->setBold(true);

        $this->excel->getActiveSheet()->getStyle('B'.$num2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->setCellValue('C'.$num2.'', "PERCENTAGE OF RESPONDENTS' IMPRESSION");
        $this->excel->getActiveSheet()->getStyle('C'.$num2.'')->getFont()->setBold(true);

        $this->excel->getActiveSheet()->getStyle('C'.$num2.':F'.$num2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       
        

        // $labels = ["EXCELLENT", "VERY GOOD", "GOOD", "AVERAGE", "POOR"];

        $this->excel->getActiveSheet()->getStyle('A'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // $this->excel->getActiveSheet()->setCellValue('C'.$num3.'', "EXCELLENT");
        // $this->excel->getActiveSheet()->setCellValue('D'.$num3.'', "VERY GOOD");
        // $this->excel->getActiveSheet()->setCellValue('E'.$num3.'', "GOOD");
        // $this->excel->getActiveSheet()->setCellValue('F'.$num3.'', "AVERAGE");
        // $this->excel->getActiveSheet()->setCellValue('G'.$num3.'', "POOR");
        $this->excel->getActiveSheet()->getStyle('B'.$num3.':G'.$num3.'')->getFont()->setBold(true);


        $this->excel->getActiveSheet()->getStyle('B'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('C'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('D'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('E'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('F'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // Initialize flag to show labels for qid 2-9 only once
            $labels_shown = false;
       
            foreach($questions as $q){
                $stdCommentInfo = $this->feedback_model->getStudentCommentsAndSug24Report($staff->staff_id,$filter);
                $excellent_max_mark = count($stdCommentInfo) * 5;
                $ver_good_max_mark = count($stdCommentInfo) * 4;
                $good_max_mark = count($stdCommentInfo) * 3;
                $average_max_mark = count($stdCommentInfo) * 2;
                $poor_max_mark = count($stdCommentInfo) * 1;

                 // Dynamically change labels based on question ID or identifier
                $labels = [];  // Initialize an empty array for labels

                if ($q->qid == 1) {  // For the first question
                    $this->excel->getActiveSheet()->setCellValue('A'.$num3.'', "SL. NO.");
                    $this->excel->getActiveSheet()->setCellValue('B'.$num3.'', "CRITERIA");
                    $this->excel->getActiveSheet()->getStyle('A'.$num3.'')->getFont()->setBold(true);
                    $labels = ["Always Available", "Mostly Available", "Sometimes Available", "Rarely Available"];
                    $this->excel->getActiveSheet()->setCellValue('C'.$num3.'', $labels[0]);
                    $this->excel->getActiveSheet()->setCellValue('D'.$num3.'', $labels[1]);
                    $this->excel->getActiveSheet()->setCellValue('E'.$num3.'', $labels[2]);
                    $this->excel->getActiveSheet()->setCellValue('F'.$num3.'', $labels[3]);
                    $num3 += 2; // Prepare for next question
                } elseif ($q->qid >= 2 && $q->qid <= 9) {  // For the second question
                    if (!$labels_shown) {
                       // $num3++; // Adjust for label row
                        $this->excel->getActiveSheet()->setCellValue('A'.$num3, "SL. NO.");
                        $this->excel->getActiveSheet()->setCellValue('B'.$num3, "CRITERIA");
                        $this->excel->getActiveSheet()->getStyle('A'.$num3.':F'.$num3.'')->getFont()->setBold(true);
                        $this->excel->getActiveSheet()->getStyle('A'.$num3.':F'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $labels = ["Strongly Agree", "Agree", "Neutral", "Disagree"];
                        $this->excel->getActiveSheet()->setCellValue('C'.$num3, $labels[0]);
                        $this->excel->getActiveSheet()->setCellValue('D'.$num3, $labels[1]);
                        $this->excel->getActiveSheet()->setCellValue('E'.$num3, $labels[2]);
                        $this->excel->getActiveSheet()->setCellValue('F'.$num3, $labels[3]);
                        $labels_shown = true;  // Prevents repeating the labels for subsequent questions
                        $num3++; // Move to the next row after labels
                    }
                } elseif ($q->qid == 10) {  // For the second question
                    $num3 = 17;
                    $labels_shown = false; 
                    $this->excel->getActiveSheet()->setCellValue('A'.$num3, "SL. NO.");
                    $this->excel->getActiveSheet()->setCellValue('B'.$num3, "CRITERIA");
                    $this->excel->getActiveSheet()->getStyle('A'.$num3.':F'.$num3)->getFont()->setBold(true);
                    $this->excel->getActiveSheet()->getStyle('A'.$num3.':F'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $labels = ["Very Comfortable", "Somewhat Comfortable", "Neutral", "Uncomfortable"];
                    $this->excel->getActiveSheet()->setCellValue('C'.$num3, $labels[0]);
                    $this->excel->getActiveSheet()->setCellValue('D'.$num3, $labels[1]);
                    $this->excel->getActiveSheet()->setCellValue('E'.$num3, $labels[2]);
                    $this->excel->getActiveSheet()->setCellValue('F'.$num3, $labels[3]);
                    $num3++;  // Move to the next row after labels
                }elseif ($q->qid == 11) {  // For the second question
                    $num3 = 19;
                    $labels_shown = false; 
                    $this->excel->getActiveSheet()->setCellValue('A'.$num3, "SL. NO.");
                    $this->excel->getActiveSheet()->setCellValue('B'.$num3, "CRITERIA");
                    $this->excel->getActiveSheet()->getStyle('A'.$num3.':F'.$num3)->getFont()->setBold(true);
                    $this->excel->getActiveSheet()->getStyle('A'.$num3.':F'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $labels = ["Always Engaged", "Mostly Engaged", "Sometimes Engaged", "Not Engaged"];
                    $this->excel->getActiveSheet()->setCellValue('C'.$num3, $labels[0]);
                    $this->excel->getActiveSheet()->setCellValue('D'.$num3, $labels[1]);
                    $this->excel->getActiveSheet()->setCellValue('E'.$num3, $labels[2]);
                    $this->excel->getActiveSheet()->setCellValue('F'.$num3, $labels[3]);
                    $num3++;  // Move to the next row after labels
                }

                // $stdAnsCountExcellent_22 = $this->feedback_model->getCountOfStdAnswersExcellent_Good_22Report($staff->staff_id, $q->qid, 5,$filter);
                $finalAnswer = $this->feedback_model->getCountOfStdAnswersExcellent_Good_24ReportNew($staff->staff_id, $q->qid, 5,$filter);
                $stdAnsCountExcellent_22 = count($finalAnswer) * 5;
                $excellent_Percentage = ($stdAnsCountExcellent_22 / $excellent_max_mark) ;
                $excellent_percentage_d = number_format($excellent_Percentage, 2, '.', '');

                // $stdAnsCountVeryGood_22 = $this->feedback_model->getCountOfStdAnswersExcellent_Good_22Report($staff->staff_id, $q->qid, 4,$filter);
                $finalAnswer = $this->feedback_model->getCountOfStdAnswersExcellent_Good_24ReportNew($staff->staff_id, $q->qid, 4,$filter);
                $stdAnsCountVeryGood_22 = count($finalAnswer) * 4;
                $very_good_Percentage = ($stdAnsCountVeryGood_22 / $ver_good_max_mark) ;
                $very_good_Percentage_d = number_format($very_good_Percentage, 2, '.', '');

                // $stdAnsCountGood_22 = $this->feedback_model->getCountOfStdAnswersExcellent_Good_22Report($staff->staff_id, $q->qid, 3,$filter);
                $finalAnswer = $this->feedback_model->getCountOfStdAnswersExcellent_Good_24ReportNew($staff->staff_id, $q->qid, 3,$filter);
                $stdAnsCountGood_22 = count($finalAnswer) * 3;
                $good_Percentage = ($stdAnsCountGood_22 / $good_max_mark) ;
                $good_Percentage_d = number_format($good_Percentage, 2, '.', '');

                // $stdAnsCountAvergae_22 = $this->feedback_model->getCountOfStdAnswersExcellent_Good_22Report($staff->staff_id, $q->qid, 2,$filter);
                $finalAnswer = $this->feedback_model->getCountOfStdAnswersExcellent_Good_24ReportNew($staff->staff_id, $q->qid, 2,$filter);
                $stdAnsCountAvergae_22 = count($finalAnswer) * 2;
                $average_Percentage = ($stdAnsCountAvergae_22 / $average_max_mark) ;
                $average_Percentage_d = number_format($average_Percentage, 2, '.', '');

                // $stdAnsCountPoor_22 = $this->feedback_model->getCountOfStdAnswersExcellent_Good_22Report($staff->staff_id, $q->qid, 1,$filter);
                $finalAnswer = $this->feedback_model->getCountOfStdAnswersExcellent_Good_24ReportNew($staff->staff_id, $q->qid, 1,$filter);
                $stdAnsCountPoor_22 = count($finalAnswer) * 1;
                $poor_percentage = ($stdAnsCountPoor_22 / $poor_max_mark) ;
                $poor_percentage_d = number_format($poor_percentage, 2, '.', '');

            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$sl_no);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,$q->question);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,$excellent_percentage_d);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,$very_good_Percentage_d);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,$good_Percentage_d);
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$average_Percentage_d);

            $this->excel->getActiveSheet()->getStyle('A'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('C'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('D'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('E'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('F'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            if ($q->qid >= 2 && $q->qid <= 8) {
                $excel_row++;
            }else{
                $excel_row = $excel_row + 2;

            }

            $sl_no++;
        }
        $this->excel->getActiveSheet()->mergeCells('A'.$excel_row.':F'.$excel_row.'');

        $num1+= $countQuestions;
        $num2+= $countQuestions;
        $num3+= $countQuestions;
        $excel_row+= 4;
        
    // }


        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(7);

        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(95);

        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);

        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);

        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);

        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);

        $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

        $this->excel->getActiveSheet()->getStyle('A1:F4')->applyFromArray($styleBorderArray);

        $this->excel->getActiveSheet()->getStyle('A5:F999')->applyFromArray($styleBorderArray);

       $filter['admission_type'] = $class_name;

        $this->excel->createSheet(); 



    $filename= $class_name.'Feedback_Report.xls'; //save our workbook as this file name

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

    }
     public function downloadFeedBackCommentsExcelReport(){
        if($this->isAdmin() == TRUE)
        {
            setcookie('isDownloading',0);
            $this->loadThis();
        } else
        {   
            $class_name = $this->security->xss_clean($this->input->post('class_name'));
            $section_name = $this->security->xss_clean($this->input->post('section_name'));
            $staff_type = $this->security->xss_clean($this->input->post('staff_type'));       
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
                $filter = array();           
    
                if(!empty($class_name)){
    
                    $filter['class_name'] = $class_name;
    
                    $data['class_name'] = $class_name;
                    $class_heading = $class_name;
    
                }else{
                    $class_heading = 'ALL';
                }
    
                if(!empty($section_name)){
        
                    $data['section_name'] = $section_name;
                    if($section_name == 'ALL'){
                        $filter['section_name'] = '';
                       }else{
                        $filter['section_name'] = $section_name; 
                    }
                }  else{
                    $filter['section_name'] = 'ALL';

                }
                if(!empty($stream_name)){
                    $filter['stream_name'] = $stream_name;
                    $data['stream_name'] = $stream_name;
                }




        if($staff_type == 'Teaching Staff'){
            $sheet = 0;
            $j=1;
            $excel_row = 6;
            $this->excel->setActiveSheetIndex($sheet);
            $staffInfo = $this->feedback_model->getAllSchoolStaffInfo($filter);

            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:F500');

            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);

            $this->excel->getActiveSheet()->setCellValue('A2', $class_heading.''.$section_title.' - '." Feedback Comments Report");

            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);

            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

            $this->excel->getActiveSheet()->getStyle('A1:A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $this->excel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);

            $this->excel->getActiveSheet()->mergeCells('A1:F1');

            $this->excel->getActiveSheet()->mergeCells('A2:F2');

            $this->excel->getActiveSheet()->mergeCells('A3:F3');

            $questions =  $this->feedback_model->getTeachingStaffFeedbackQuestions25();

       
            $num1 = 4;
            $num2 = 5;
            $num3 = 6;
            $excel_row = 7;
            foreach($staffInfo as $staff){
            $isExist = $this->feedback_model->getSectionByStaffIdFeedback($staff->staff_id,$filter);
            if(!empty($isExist)){
                $sl_no = 1;
                $stdCommentInfos = $this->feedback_model->getStudentCommentsAndSug25($staff->staff_id,$filter);
                $subjectInfo = $this->feedback_model->getAllSchoolSubjectByStaffIdNew($staff->staff_id,$filter['class_name'],$section_name,$stream_name);
                $SubjectArray = '';
                foreach($subjectInfo as $sub) {
                  $SubjectArray.=  $sub->dept_name.',';
                }
                $SubjectArray = rtrim($SubjectArray, ',');

            $this->excel->getActiveSheet()->mergeCells('A'.$num1.':F'.$num1.'');

            $this->excel->getActiveSheet()->setCellValue('A'.$num1.'', $staff->name.' - '.$SubjectArray);
            $this->excel->getActiveSheet()->getStyle('A'.$num1.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A'.$num1.'')->getFont()->setSize(15);

            $this->excel->getActiveSheet()->mergeCells('B'.$num2.':F'.$num2.'');
            $this->excel->getActiveSheet()->setCellValue('B'.$num2.'', "NO. OF RESPONDENTS: ".count($stdCommentInfos)."");
            $this->excel->getActiveSheet()->getStyle('B'.$num2.'')->getFont()->setBold(true);

            $this->excel->getActiveSheet()->getStyle('B'.$num2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         

            $this->excel->getActiveSheet()->getStyle('C'.$num2.':D'.$num2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
           
            $this->excel->getActiveSheet()->setCellValue('A'.$num3.'', "SL. NO.");
            $this->excel->getActiveSheet()->setCellValue('B'.$num3.'', "ROLL NO.");
            $this->excel->getActiveSheet()->setCellValue('C'.$num3.'', "CLASS.");
            $this->excel->getActiveSheet()->setCellValue('D'.$num3.'', "SECTION.");
            $this->excel->getActiveSheet()->getStyle('A'.$num3.'')->getFont()->setBold(true);

            $this->excel->getActiveSheet()->getStyle('A'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('E'.$num3.'', "NAME");
            $this->excel->getActiveSheet()->setCellValue('F'.$num3.'', "COMMENTS");
        
            $this->excel->getActiveSheet()->getStyle('B'.$num3.':F'.$num3.'')->getFont()->setBold(true);


            $this->excel->getActiveSheet()->getStyle('B'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('C'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('D'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('E'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('F'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

           
                foreach($stdCommentInfos as $q){
            
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$sl_no);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,$q->sat_number);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,$q->class);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,$q->section);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,$q->student_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$q->comments_impression);
     

                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('B'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $this->excel->getActiveSheet()->getStyle('D'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $this->excel->getActiveSheet()->getStyle('E'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $this->excel->getActiveSheet()->getStyle('F'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);


                $excel_row++;
                $sl_no++;
            }
            $this->excel->getActiveSheet()->mergeCells('A'.$excel_row.':F'.$excel_row.'');
            $num1+= 4;
            $num2+= 4;
            $num3+= 4;
            $num1+= count($stdCommentInfos);
            $num2+= count($stdCommentInfos);
            $num3+= count($stdCommentInfos);
            $excel_row+= 4;
            }
        }


            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(7);

            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);

            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);

            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(100);

          

            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

            $this->excel->getActiveSheet()->getStyle('A1:F4')->applyFromArray($styleBorderArray);

            $this->excel->getActiveSheet()->getStyle('A5:F999')->applyFromArray($styleBorderArray);

           $filter['admission_type'] = $class_name;
   

            $this->excel->createSheet(); 

    

        $filename= $class_name.'Feedback_Report.xls'; //save our workbook as this file name

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

    }else{
            $sheet = 0;

            $j=1;

            $excel_row = 6;

            // $section_name = $sections[$sheet];

            $this->excel->setActiveSheetIndex($sheet);

        
            $staff = $this->feedback_model->getMyCounsellorStaffInfo();

            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:H500');

            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);

            $this->excel->getActiveSheet()->setCellValue('A2', $class_heading.''.$section_name.' - '."Counsellor Feedback Comments Report");

            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);

            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);

            $this->excel->getActiveSheet()->getStyle('A1:A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $this->excel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);

            $this->excel->getActiveSheet()->mergeCells('A1:E1');

            $this->excel->getActiveSheet()->mergeCells('A2:E2');

            $this->excel->getActiveSheet()->mergeCells('A3:E3');

            $questions =  $this->feedback_model->getCouncellorFeedbackQuestions2024();

    
            $num1 = 4;
            $num2 = 5;
            $num3 = 6;
            $excel_row = 7;
        
                $sl_no = 1;
                $stdCommentInfos = $this->feedback_model->getStudentCommentsForCounsellorReport($staff->staff_id,$filter);
                $stdCommentInfosQ13 = $this->feedback_model->getStudentCommentsForCounsellorReportQ13($staff->staff_id,$filter);
               

            $this->excel->getActiveSheet()->mergeCells('A'.$num1.':E'.$num1.'');

            $this->excel->getActiveSheet()->setCellValue('A'.$num1.'', $staff->name);
            $this->excel->getActiveSheet()->getStyle('A'.$num1.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A'.$num1.'')->getFont()->setSize(15);

            $this->excel->getActiveSheet()->mergeCells('B'.$num2.':E'.$num2.'');
            $this->excel->getActiveSheet()->setCellValue('B'.$num2.'', "NO. OF RESPONDENTS: ".count($stdCommentInfos)."");
            $this->excel->getActiveSheet()->getStyle('B'.$num2.'')->getFont()->setBold(true);

            $this->excel->getActiveSheet()->getStyle('B'.$num2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        

            $this->excel->getActiveSheet()->getStyle('C'.$num2.':E'.$num2.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
            $this->excel->getActiveSheet()->setCellValue('A'.$num3.'', "SL. NO.");
            $this->excel->getActiveSheet()->setCellValue('B'.$num3.'', "ROLL NO.");
            $this->excel->getActiveSheet()->getStyle('A'.$num3.'')->getFont()->setBold(true);

            $this->excel->getActiveSheet()->getStyle('A'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue('C'.$num3.'', "NAME");
            $this->excel->getActiveSheet()->setCellValue('D'.$num3.'', "QUESTION");
            $this->excel->getActiveSheet()->setCellValue('E'.$num3.'', "COMMENTS");
        
            $this->excel->getActiveSheet()->getStyle('B'.$num3.':E'.$num3.'')->getFont()->setBold(true);


            $this->excel->getActiveSheet()->getStyle('B'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('C'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('D'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('E'.$num3.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        
                foreach($stdCommentInfos as $q){
            
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$sl_no);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,$q->sat_number);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,strtoupper($q->student_name));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,$q->question);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,$q->answer);
    

                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('B'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $this->excel->getActiveSheet()->getStyle('D'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $this->excel->getActiveSheet()->getStyle('E'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $excel_row++;
                $sl_no++;
            }
            foreach($stdCommentInfosQ13 as $q){
            
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$sl_no);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,$q->sat_number);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,strtoupper($q->student_name));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,$q->question);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,$q->answer);
    

                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('B'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $this->excel->getActiveSheet()->getStyle('D'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $this->excel->getActiveSheet()->getStyle('E'.$excel_row.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);


                $excel_row++;
                $sl_no++;
            }
            $this->excel->getActiveSheet()->mergeCells('A'.$excel_row.':E'.$excel_row.'');
            $num1+= 4;
            $num2+= 4;
            $num3+= 4;
            $num1+= count($stdCommentInfos);
            $num2+= count($stdCommentInfos);
            $num3+= count($stdCommentInfos);
            $excel_row+= 4;
            
 


            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(7);

            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);

            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);

            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(70);

            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(100);
        

            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

            $this->excel->getActiveSheet()->getStyle('A1:E4')->applyFromArray($styleBorderArray);

            $this->excel->getActiveSheet()->getStyle('A5:E999')->applyFromArray($styleBorderArray);

        $filter['admission_type'] = $class_name;


            $this->excel->createSheet(); 



        $filename= $class_name.'Feedback_Report.xls'; //save our workbook as this file name

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

    }

    public function downloadDateWiseFeeReportInfo(){
        if ($this->isAdmin() == true ) {
            setcookie('isDownLoaded',1);  
            $this->loadThis();
        } else {
            $filter = array();
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $year = $this->security->xss_clean($this->input->post('year'));
            $date_from = $this->security->xss_clean($this->input->post('date_from'));
            $date_to = $this->security->xss_clean($this->input->post('date_to'));
            $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
            $stream_name = $this->security->xss_clean($this->input->post('preference'));
            $reportFormat = $this->security->xss_clean($this->input->post('reportFormat'));
            if($reportFormat == 'VIEW'){
                setcookie('isDownLoaded',1);  
                $data['dt_filter'] = $filter;
                $data['date_from']= $date_from;
                $data['date_to']= $date_to;
                $data['term_name']= $term_name;
                $data['stream_name']= $stream_name;
                if($payment_type[0] == 'ALL'){
                    $data['payment_type']= '';
                }else{
                    $data['payment_type']= $payment_type;
                }
                $data['year'] = $year;
                $data['fees_year'] = $year ? $year . '-' . ($year + 1) : EXCEL_YEAR;
                // $data['fee_type'] = $fee_type;
                $data['fee'] = $this->fee;
                $data['student'] = $this->student;
                $this->global['pageTitle'] = ''.TAB_TITLE.' : DATEWISE FEE PAID REPORT';
                // $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf']);
                // $mpdf = $this->getAllFontFile();
                $mpdf = new \Mpdf\Mpdf(['default_font' => 'timesnewroman']);
                $mpdf->AddPage('P','','','','',7,7,7,7,6,6);
                $mpdf->SetTitle('DATEWISE FEE PAID REPORT');
                $html = $this->load->view('reports/dateWiseFeeReport',$data,true);
                $mpdf->WriteHTML($html);
                $mpdf->Output('Fee_paid.pdf', 'I');
            }else{
                $yearDisplay = $year ? $year . '-' . substr($year + 1, -2) : '';
                $sheet = 0;
                $this->excel->setActiveSheetIndex($sheet);
                //name the worksheet
                // $this->excel->getActiveSheet()->setTitle($stream[$sheet]);
                $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:L500');
                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                $this->excel->getActiveSheet()->setCellValue('A2', "DATEWISE FEE PAID REPORT - ".$yearDisplay);
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->mergeCells('A1:K1');
                $this->excel->getActiveSheet()->mergeCells('A2:K2');
                $this->excel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A2:K2')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A1:K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row = 3;
                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                // $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
                // $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
                $this->excel->getActiveSheet()->getStyle('A3:K3')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, 'SL No.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, 'Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, 'Term');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, 'Stream');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, 'Section');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, 'Student Id.');
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, 'Receipt No.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, 'Payment Date');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, 'Payment Mode');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row, 'Transaction ID');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row, 'Transaction Date');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row, 'Amount Paid');
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row, 'Fee Type');
                if($date_from != ''){
                    $filter['date_from'] = date('Y-m-d',strtotime($date_from));
                }else{
                    $filter['date_from'] = '';
                }
                if($date_to != ''){
                    $filter['date_to'] = date('Y-m-d',strtotime($date_to));
                }else{
                    $filter['date_to'] = '';
                }
                $filter['year']= $year;
                if($payment_type[0] == 'ALL'){
                    $filter['payment_type'] = '';
                }else{
                    $filter['payment_type'] = $payment_type;
                }
                $filter['fee_type'] = $fee_type;
                $filter['term_name'] = $term_name;
                $filter['stream_name'] = $stream_name;
                $sl = 1;
                $excelRow=4;
                $excel_row = 4;
                $sl = 1;
                $total_amount_paid = 0;
                $studentInfo = $this->fee->getManagementFeeForDateWiseReport($filter);
                foreach($studentInfo as $std){
                    $term_name = $std->term_name;
                    $stdInfo = $this->student->getStudentInfoByRowId($std->application_no);
                    $section_name = $stdInfo->section_name;
                    if($std->payment_type == 'DD'){
                        $transaction_date = $std->dd_date;
                    }else if($std->payment_type == 'CARD' || $std->payment_type == 'BANK' || $std->payment_type == 'UPI' || $std->payment_type == 'NEFT'){
                        $transaction_date = $std->transaction_date;
                    }else if($std->payment_type == 'ONLINE'){
                        $transaction_date = $std->payment_date;
                    }else{
                        $transaction_date = '';
                    }
                    if($std->payment_type == 'CARD' || $std->payment_type == 'BANK' || $std->payment_type == 'UPI' || $std->payment_type == 'NEFT'){
                        $transaction_id = $std->transaction_number;
                    }else if($std->payment_type == 'DD'){
                        $transaction_id = $std->dd_number;
                    }else if($std->payment_type == 'ONLINE'){
                        $transaction_id = $std->order_id;
                    }else{
                        $transaction_id = ' ';
                    }
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, $sl++);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, strtoupper($stdInfo->student_name));
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, $term_name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, $stdInfo->stream_name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, $section_name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, $stdInfo->student_id);
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, $std->receipt_number);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, date('d-m-Y',strtotime($std->payment_date)));
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, $std->payment_type);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row, $transaction_id);
                    if (!empty($transaction_date) 
                        && $transaction_date != '1970-01-01' 
                        && $transaction_date != '0000-00-00') {
                        $this->excel->setActiveSheetIndex($sheet)
                            ->setCellValue('J'.$excel_row, date('d-m-Y', strtotime($transaction_date)));
                    } else {
                        $this->excel->setActiveSheetIndex($sheet)
                            ->setCellValue('J'.$excel_row, '');
                    }
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row, number_format($std->paid_amount,2));
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row, $std->fee_type);
                    // $this->excel->getActiveSheet()->mergeCells('E'.$excel_row);
                    $this->excel->getActiveSheet()->getStyle('E'.$excel_row)->getAlignment()->setWrapText(true);
                    $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':A'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('C'.$excel_row.':K'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                    $this->excel->getActiveSheet()->getStyle('A4:K'.$excel_row)->applyFromArray($styleBorderArray);
                    $excel_row++;
                    $row_no = $excel_row;
                    $cell_name = 'F';
                    $total_amount_paid  += $std->paid_amount;
                }
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row, 'TOTAL');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row,number_format($total_amount_paid,2));
                $this->excel->getActiveSheet()->getStyle('K'.$excel_row.':K'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':K'.$excel_row)->getFont()->setBold(true);
                $this->excel->createSheet(); 
                $filename =  'Fee_Paid_Report_-'.date('d-m-Y').'.xls'; //save our workbook as this file name
                header('Content-Type: application/vnd.ms-excel'); //mime type
                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache
                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                //if you want to save it as .XLSX Excel 2007 format
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
                ob_start();
                setcookie('isDownLoaded',1);  
                $objWriter->save("php://output");
            }
        }
    }

    public function downloadBankSettlementReport(){
        if ($this->isAdmin() == true ) {
            setcookie('isDownLoaded',1);  
            $this->loadThis();
        } else {
            $filter = array();
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $year = $this->security->xss_clean($this->input->post('year'));
            $date_from = $this->security->xss_clean($this->input->post('date_from'));
            $date_to = $this->security->xss_clean($this->input->post('date_to'));
            $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
            $reportFormat = $this->security->xss_clean($this->input->post('reportFormat'));
            if($reportFormat == 'VIEW'){
                setcookie('isDownLoaded',1);  
                $data['dt_filter'] = $filter;
                $data['date_from']= $date_from;
                $data['date_to']= $date_to;
                $data['term_name']= $term_name;
                if($payment_type[0] == 'ALL'){
                    $data['payment_type']= '';
                }else{
                    $data['payment_type']= $payment_type;
                }
                $data['year'] = $year;
                $data['fees_year'] = $year ? $year . '-' . ($year + 1) : EXCEL_YEAR;
                $data['fee'] = $this->fee;
                $data['student'] = $this->student;
                $this->global['pageTitle'] = ''.TAB_TITLE.' : BANK SETTLEMENT FEE PAID REPORT';
                // $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf']);
                // $mpdf = $this->getAllFontFile();
                $mpdf = new \Mpdf\Mpdf(['default_font' => 'timesnewroman']);
                $mpdf->AddPage('P','','','','',7,7,7,7,6,6);
                $mpdf->SetTitle('BANK SETTLEMENT FEE PAID REPORT');
                $html = $this->load->view('reports/bankSettlementPDFReport',$data,true);
                $mpdf->WriteHTML($html);
                $mpdf->Output('bankSettlementReport.pdf', 'I');
            }else{
                $yearDisplay = $year ? $year . '-' . substr($year + 1, -2) : '';
                $sheet = 0;
                $this->excel->setActiveSheetIndex($sheet);
                //name the worksheet
                // $this->excel->getActiveSheet()->setTitle($stream[$sheet]);
                $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:L500');
                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                $this->excel->getActiveSheet()->setCellValue('A2', "BANK SETTLEMENT FEE PAID REPORT - ".$yearDisplay);
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->mergeCells('A1:L1');
                $this->excel->getActiveSheet()->mergeCells('A2:L2');
                $this->excel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A2:L2')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A1:L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row = 3;
                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                // $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
                // $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
                $this->excel->getActiveSheet()->getStyle('A3:L3')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A3:L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, 'SL No.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, 'Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, 'Term');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, 'Stream');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, 'Section');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, 'Student Id.');
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, 'Receipt No.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, 'Payment Date');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, 'Payment Mode');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row, 'Transaction ID');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row, 'Transaction Date');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row, 'Settlement Date');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row, 'Amount Paid');
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('M'.$excel_row, 'Fee Type');
                if($date_from != ''){
                    $filter['date_from'] = date('Y-m-d',strtotime($date_from));
                }else{
                    $filter['date_from'] = '';
                }
                if($date_to != ''){
                    $filter['date_to'] = date('Y-m-d',strtotime($date_to));
                }else{
                    $filter['date_to'] = '';
                }
                $filter['year']= $year;
                if($payment_type[0] == 'ALL'){
                    $filter['payment_type'] = '';
                }else{
                    $filter['payment_type'] = $payment_type;
                }
                $filter['fee_type'] = $fee_type;
                $filter['term_name'] = $term_name;
                $sl = 1;
                $excelRow=4;
                $excel_row = 4;
                $sl = 1;
                $total_amount_paid = 0;
                $studentInfo = $this->fee->getBankSettlementFeeForReport($filter);
                foreach($studentInfo as $std){
                    $term_name = $std->term_name;
                    $stdInfo = $this->student->getStudentInfoByRowId($std->application_no);
                    $section_name = $stdInfo->section_name;
                    if($std->payment_type == 'DD'){
                        $transaction_date = $std->dd_date;
                    }else if($std->payment_type == 'CARD' || $std->payment_type == 'BANK' || $std->payment_type == 'UPI' || $std->payment_type == 'NEFT'){
                        $transaction_date = $std->transaction_date;
                    }else if($std->payment_type == 'ONLINE'){
                        $transaction_date = $std->payment_date;
                    }else{
                        $transaction_date = '';
                    }
                    if($std->payment_type == 'CARD' || $std->payment_type == 'BANK' || $std->payment_type == 'UPI' || $std->payment_type == 'NEFT'){
                        $transaction_id = $std->transaction_number;
                    }else if($std->payment_type == 'DD'){
                        $transaction_id = $std->dd_number;
                    }else if($std->payment_type == 'ONLINE'){
                        $transaction_id = $std->order_id;
                    }else{
                        $transaction_id = ' ';
                    }
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, $sl++);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, strtoupper($stdInfo->student_name));
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, $term_name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, $stdInfo->stream_name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, $section_name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, $stdInfo->student_id);
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, $std->receipt_number);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, date('d-m-Y',strtotime($std->payment_date)));
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, $std->payment_type);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row, $transaction_id);
                    if (!empty($transaction_date) 
                        && $transaction_date != '1970-01-01' 
                        && $transaction_date != '0000-00-00') {
                        $this->excel->setActiveSheetIndex($sheet)
                            ->setCellValue('J'.$excel_row, date('d-m-Y', strtotime($transaction_date)));
                    } else {
                        $this->excel->setActiveSheetIndex($sheet)
                            ->setCellValue('J'.$excel_row, '');
                    }
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row, date('d-m-Y',strtotime($std->bank_settlement_date)));
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row, number_format($std->paid_amount,2));
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('M'.$excel_row, $std->fee_type);
                    // $this->excel->getActiveSheet()->mergeCells('E'.$excel_row);
                    $this->excel->getActiveSheet()->getStyle('E'.$excel_row)->getAlignment()->setWrapText(true);
                    $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':A'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('C'.$excel_row.':L'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                    $this->excel->getActiveSheet()->getStyle('A4:L'.$excel_row)->applyFromArray($styleBorderArray);
                    $excel_row++;
                    $row_no = $excel_row;
                    $cell_name = 'G';
                    $total_amount_paid  += $std->paid_amount;
                }
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row, 'TOTAL');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row,number_format($total_amount_paid,2));
                $this->excel->getActiveSheet()->getStyle('L'.$excel_row.':L'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':L'.$excel_row)->getFont()->setBold(true);
                $this->excel->createSheet(); 
                $filename =  'Bank_Settlement_Fee_Report_-'.date('d-m-Y').'.xls'; //save our workbook as this file name
                header('Content-Type: application/vnd.ms-excel'); //mime type
                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache
                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                //if you want to save it as .XLSX Excel 2007 format
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
                ob_start();
                setcookie('isDownLoaded',1);  
                $objWriter->save("php://output");
            }
        }
    }

    public function downloadBifurcationReport(){
        if ($this->isAdmin() == true ) {
            setcookie('isDownLoaded',1);  
            $this->loadThis();
        } else {
            $filter = array();
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $year = $this->security->xss_clean($this->input->post('year'));
            $date_from = $this->security->xss_clean($this->input->post('date_from'));
            $date_to = $this->security->xss_clean($this->input->post('date_to'));
            $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
            $fee_type = $this->security->xss_clean($this->input->post('fee_type'));
            $reportFormat = $this->security->xss_clean($this->input->post('reportFormat'));
            if($reportFormat == 'VIEW'){
                setcookie('isDownLoaded',1);  
                $data['dt_filter'] = $filter;
                $data['date_from']= $date_from;
                $data['date_to']= $date_to;
                $data['term_name']= $term_name;
                if($payment_type[0] == 'ALL'){
                    $data['payment_type']= '';
                }else{
                    $data['payment_type']= $payment_type;
                }
                $data['year'] = $year;
                $data['fees_year'] = $year ? $year . '-' . ($year + 1) : EXCEL_YEAR;
                $data['fee_type'] = $fee_type;
                $data['fee'] = $this->fee;
                $data['student'] = $this->student;
                $this->global['pageTitle'] = ''.TAB_TITLE.' : BIFURCATION FEE PAID REPORT';
                // $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf']);
                // $mpdf = $this->getAllFontFile();
                $mpdf = new \Mpdf\Mpdf(['default_font' => 'timesnewroman']);
                $mpdf->AddPage('P','','','','',7,7,7,7,6,6);
                $mpdf->SetTitle('BIFURCATION FEE PAID REPORT');
                $html = $this->load->view('reports/bifurcationReport',$data,true);
                $mpdf->WriteHTML($html);
                $mpdf->Output('Bifurcation_Fee_paid.pdf', 'I');
            }else{
                $yearDisplay = $year ? $year . '-' . substr($year + 1, -2) : '';
                $sheet = 0;
                $this->excel->setActiveSheetIndex($sheet);
                $cellNameByStudentReport = array('L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
                $feeStructureName = $this->fee->getFeeStructureName($fee_type);
                $feeTypeCount = count($feeStructureName); 
                $amountPaidCol = $cellNameByStudentReport[$feeTypeCount];
                $lastHeaderCol = $amountPaidCol;
                //name the worksheet
                // $this->excel->getActiveSheet()->setTitle($stream[$sheet]);
                $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:'.$lastHeaderCol.'500');
                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                $this->excel->getActiveSheet()->setCellValue('A2', $fee_type ." BIFURCATION FEE PAID REPORT - " .$yearDisplay);
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->mergeCells('A1:'.$lastHeaderCol.'1');
                $this->excel->getActiveSheet()->mergeCells('A2:'.$lastHeaderCol.'2');
                $this->excel->getActiveSheet()->getStyle('A1:'.$lastHeaderCol.'1')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A1:'.$lastHeaderCol.'2')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A1:'.$lastHeaderCol.'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A1:'.$lastHeaderCol.'2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row = 3;
                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
                foreach($feeStructureName as $index => $name){
                    if(isset($cellNameByStudentReport[$index])){
                        $this->excel->getActiveSheet()->getColumnDimension($cellNameByStudentReport[$index])->setWidth(20);
                    }
                }
                $this->excel->getActiveSheet()->getColumnDimension($amountPaidCol)->setWidth(20);
                $this->excel->getActiveSheet()->getStyle('A3:'.$lastHeaderCol.'3')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A3:'.$lastHeaderCol.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, 'SL No.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, 'Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, 'Term');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, 'Stream');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, 'Section');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, 'Student Id.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, 'Receipt No.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, 'Payment Date');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row, 'Payment Mode');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row, 'Transaction ID');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row, 'Transaction Date');
                foreach($feeStructureName as $index => $name){
                    if(isset($cellNameByStudentReport[$index])){
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameByStudentReport[$index].$excel_row, $name->fee_name);
                    }
                }
                $this->excel->setActiveSheetIndex($sheet)->setCellValue($amountPaidCol.$excel_row, 'Amount Paid');
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row, 'Fee Type');
                if($date_from != ''){
                    $filter['date_from'] = date('Y-m-d',strtotime($date_from));
                }else{
                    $filter['date_from'] = '';
                }
                if($date_to != ''){
                    $filter['date_to'] = date('Y-m-d',strtotime($date_to));
                }else{
                    $filter['date_to'] = '';
                }
                $filter['year']= $year;
                if($payment_type[0] == 'ALL'){
                    $filter['payment_type'] = '';
                }else{
                    $filter['payment_type'] = $payment_type;
                }
                $filter['fee_type'] = $fee_type;
                $filter['term_name'] = $term_name;
                $sl = 1;
                $excelRow=4;
                $excel_row = 4;
                $sl = 1;
                $totalFeeTypeAmount = array();
                foreach($feeStructureName as $name){
                    $totalFeeTypeAmount[$name->row_id] = 0;
                }
                $total_amount_paid = 0;
                $studentInfo = $this->fee->getManagementFeeForReport($filter);
                foreach($studentInfo as $std){
                    $term_name = $std->term_name;
                    $stdInfo = $this->student->getStudentInfoByRowId($std->application_no);
                    $section_name = $stdInfo->section_name;
                    if($std->payment_type == 'DD'){
                        $transaction_date = $std->dd_date;
                    }else if($std->payment_type == 'CARD' || $std->payment_type == 'BANK' || $std->payment_type == 'UPI' || $std->payment_type == 'NEFT'){
                        $transaction_date = $std->transaction_date;
                    }else if($std->payment_type == 'ONLINE'){
                        $transaction_date = $std->payment_date;
                    }else{
                        $transaction_date = '';
                    }
                    if($std->payment_type == 'CARD' || $std->payment_type == 'BANK' || $std->payment_type == 'UPI' || $std->payment_type == 'NEFT'){
                        $transaction_id = $std->transaction_number;
                    }else if($std->payment_type == 'DD'){
                        $transaction_id = $std->dd_number;
                    }else if($std->payment_type == 'ONLINE'){
                        $transaction_id = $std->order_id;
                    }else{
                        $transaction_id = ' ';
                    }
                    $row_total_amount = 0;
                    $cell_name = 0;
                    $rowFeeTypeAmount = array();
                    foreach($feeStructureName as $name){ 
                        $feePaidStructure = $this->fee->getFeeReceiptPrintInfoReport($std->row_id,$std->application_no,$name->row_id);
                        $paid_amount = 0;
                        if(!empty($feePaidStructure)){
                            foreach($feePaidStructure as $info){ 
                                $paid_amount += (float)$info->paid_amount;
                                $receipt_number = $info->receipt_no;
                            }
                        }
                        $rowFeeTypeAmount[$name->row_id] = abs($paid_amount);
                        $cell_name++;
                        $row_total_amount += abs($paid_amount);
                    }
                    if($fee_type == 'CONTRIBUTION FEE' && $row_total_amount <= 0){
                        continue;
                    }
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, $sl++);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, strtoupper($stdInfo->student_name));
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, $term_name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, $stdInfo->stream_name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, $section_name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, $stdInfo->student_id);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, $receipt_number);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, date('d-m-Y',strtotime($std->payment_date)));
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row, $std->payment_type);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row, $transaction_id);
                    if (!empty($transaction_date) 
                        && $transaction_date != '1970-01-01' 
                        && $transaction_date != '0000-00-00') {
                        $this->excel->setActiveSheetIndex($sheet)
                            ->setCellValue('K'.$excel_row, date('d-m-Y', strtotime($transaction_date)));
                    } else {
                        $this->excel->setActiveSheetIndex($sheet)
                            ->setCellValue('K'.$excel_row, '');
                    }
                    foreach($feeStructureName as $index => $name){
                        if(isset($cellNameByStudentReport[$index])){
                            $paid_amount = isset($rowFeeTypeAmount[$name->row_id]) ? $rowFeeTypeAmount[$name->row_id] : 0;
                            $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameByStudentReport[$index].$excel_row, $paid_amount);
                            $totalFeeTypeAmount[$name->row_id] += $paid_amount;
                        }
                    }
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue($amountPaidCol.$excel_row, number_format($row_total_amount,2));
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row, $std->fee_type);
                    // $this->excel->getActiveSheet()->mergeCells('E'.$excel_row);
                    $this->excel->getActiveSheet()->getStyle('E'.$excel_row)->getAlignment()->setWrapText(true);
                    $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':A'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('C'.$excel_row.':'.$lastHeaderCol.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                    $this->excel->getActiveSheet()->getStyle('A4:'.$lastHeaderCol.$excel_row)->applyFromArray($styleBorderArray);
                    $excel_row++;
                    $row_no = $excel_row;
                    $total_amount_paid  += $row_total_amount;
                }
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row, 'TOTAL');
                $cell_name = 0;
                foreach($feeStructureName as $name){
                    if(isset($cellNameByStudentReport[$cell_name])){
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue($cellNameByStudentReport[$cell_name].$excel_row, number_format($totalFeeTypeAmount[$name->row_id],2));
                    }
                    $cell_name++;
                }
                $this->excel->setActiveSheetIndex($sheet)->setCellValue($amountPaidCol.$excel_row,number_format($total_amount_paid,2));
                $this->excel->getActiveSheet()->getStyle('L'.$excel_row.':'.$lastHeaderCol.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':'.$lastHeaderCol.$excel_row)->getFont()->setBold(true);
                $this->excel->createSheet(); 
                $filename =  $fee_type.'_Bifurcation_Paid_Report_-'.date('d-m-Y').'.xls'; //save our workbook as this file name
                header('Content-Type: application/vnd.ms-excel'); //mime type
                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache
                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                //if you want to save it as .XLSX Excel 2007 format
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
                ob_start();
                setcookie('isDownLoaded',1);  
                $objWriter->save("php://output");
            }
        }
    }

    public function downloadFeeDueReport()
    {
        ini_set('memory_limit', '1024M');
        ini_set("pcre.backtrack_limit", "5000000");
        ini_set('max_execution_time', -1);
        if ($this->isAdmin() == true) {
            setcookie('isDownLoaded', 1);
            $this->loadThis();
        } else {
            $filter = array();
            $term_name   = $this->security->xss_clean($this->input->post('term_name_select'));
            $stream_name = $this->security->xss_clean($this->input->post('preference'));
            $year        = $this->security->xss_clean($this->input->post('year'));
            $reportFormat = $this->security->xss_clean($this->input->post('reportFormat'));
            if (!empty($year)) {
                $fee_year    = $year . '-' . ($year + 1);
                $yearDisplay = $fee_year;
            } else {
                $fee_year    = EXCEL_YEAR;
                $yearDisplay = EXCEL_YEAR;
            }
            if ($reportFormat == 'VIEW') {
                setcookie('isDownLoaded', 1);
                $data['dt_filter']   = $filter;
                $data['term_name']   = $term_name;
                $data['stream_name'] = $stream_name;
                $data['year']        = $year;
                $data['fees_year']   = $fee_year;
                $data['fee']         = $this->fee;
                $data['newfee']      = $this->newfee;
                $data['student']     = $this->student;
                $this->global['pageTitle'] = '' . TAB_TITLE . ' : FEE DUE REPORT';
                $mpdf = new \Mpdf\Mpdf(['default_font' => 'timesnewroman']);
                $mpdf->AddPage('P', '', '', '', '', 10, 10, 10, 10, 8, 8);
                $mpdf->SetTitle('FEE DUE REPORT');
                $html = $this->load->view('reports/feeDueReportView', $data, true);
                $mpdf->WriteHTML($html);
                $mpdf->Output('CAN.pdf', 'I');
            } else {
                // ── Spreadsheet setup ───────────────────────────────────────────
                $spreadsheet = new Spreadsheet();
                $headerFontSize = ['font' => ['size' => 16, 'bold' => true]];
                $font_style_total = ['font' => ['size' => 12, 'bold' => true]];
                $spreadsheet->getProperties()
                    ->setCreator("ANNS COMPOSITE PUC")
                    ->setLastModifiedBy($this->staff_id)
                    ->setTitle("ANNS COMPOSITE PUC Fee Info")
                    ->setSubject("Fee Structure")
                    ->setDescription("ANNS COMPOSITE PUC")
                    ->setKeywords("ANNS COMPOSITE PUC")
                    ->setCategory("Fee");
                $spreadsheet->setActiveSheetIndex(0);
                $spreadsheet->getActiveSheet()->setTitle('FEE');
                // Header rows
                $spreadsheet->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                $spreadsheet->getActiveSheet()->mergeCells("A1:K1");
                $spreadsheet->getActiveSheet()->getStyle("A1")->applyFromArray($headerFontSize);
                $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
                $spreadsheet->getActiveSheet()->setCellValue('A2', $term_name . " FEES DUE REPORT " . $yearDisplay);
                $spreadsheet->getActiveSheet()->mergeCells("A2:K2");
                $spreadsheet->getActiveSheet()->getStyle("A2")->applyFromArray($headerFontSize);
                $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal('center');
                // Column headers
                $spreadsheet->getActiveSheet()->setCellValue('A3', 'SL No');
                $spreadsheet->getActiveSheet()->setCellValue('B3', 'Student ID');
                $spreadsheet->getActiveSheet()->setCellValue('C3', 'Name');
                $spreadsheet->getActiveSheet()->setCellValue('D3', 'Stream');
                $spreadsheet->getActiveSheet()->setCellValue('E3', 'Total Amt.');
                $spreadsheet->getActiveSheet()->setCellValue('F3', 'Total Fee Paid');
                $spreadsheet->getActiveSheet()->setCellValue('G3', 'Concession');
                $spreadsheet->getActiveSheet()->setCellValue('H3', 'Pending');
                $spreadsheet->getActiveSheet()->setCellValue('I3', 'Mobile No');
                $spreadsheet->getActiveSheet()->getStyle("A3:K3")->applyFromArray($font_style_total);
                $spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);
                $spreadsheet->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
                $spreadsheet->getActiveSheet()->getStyle('I3')->getAlignment()->setWrapText(true);
                // Column widths & alignment
                $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
                $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(15);
                $spreadsheet->getActiveSheet()->getStyle('A3:J3')->applyFromArray([
                    'fill' => [
                        'type'  => Fill::FILL_SOLID,
                        'color' => ['rgb' => 'E5E4E2']
                    ],
                    'font' => ['bold' => true]
                ]);
                $spreadsheet->getActiveSheet()->getStyle('A:B')->getAlignment()->setHorizontal('center');
                $spreadsheet->getActiveSheet()->getStyle('D:K')->getAlignment()->setHorizontal('center');
                $excel_row = 4;
                $sl_number = 1;
                $filter['term_name'] = $term_name;
                // ── I PUC ────────────────────────────────────────────────────────
                if ($term_name == 'I PUC') {
                    $studentInfo = $this->student->getAllStudentInfo_For_Fee_report($term_name, $stream_name, $year);
                    foreach ($studentInfo as $std) {
                        $filter['fee_year']     = $year;
                        $filter['term_name']    = 'I PUC';
                        $filter['stream_name']  = $std->stream_name;
                        $filter['gender']       = $std->gender;
                        // ── Total fee: base + govt fee (matches addFeePaymentInfo) ──
                        $total_fee_obj  = $this->fee->getTotalFeeAmount($filter);
                        $depart_fee     = $this->fee->getGovtFeeAmount($filter);
                        $total_fee_amount = (float)$total_fee_obj->total_fee + (float)$depart_fee;
                        // ── Paid amount: sum all receipts for this student & year ──
                        $total_paid_obj      = $this->fee->getFeePaidInfoForReport($std->row_id, $year);
                        $total_govt_paid_obj = $this->fee->getGovtFeePaidInfoForReport($std->row_id, $year);
                        $paid_amt = ($total_paid_obj->paid_amount != '')
                            ? (float)$total_paid_obj->paid_amount + (float)$total_govt_paid_obj->paid_amount
                            : 0;
                        // ── Concession (matches addFeePaymentInfo: getFeeConcessionByAppNo) ──
                        $concession_amt = $this->fee->getFeeConcessionByAppNo($std->row_id, $year);
                        $concession     = ($concession_amt > 0) ? (float)$concession_amt : 0;
                        // ── Pending balance (mirrors addFeePaymentInfo calculation) ──
                        $pending_bal = $total_fee_amount - $paid_amt - $concession;
                        if ($pending_bal > 0) {
                            $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row, $sl_number);
                            $spreadsheet->getActiveSheet()->setCellValue('B' . $excel_row, $std->student_id);
                            $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row, strtoupper($std->student_name));
                            $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row, $std->stream_name);
                            $spreadsheet->getActiveSheet()->setCellValueExplicit('E' . $excel_row, $total_fee_amount, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                            $spreadsheet->getActiveSheet()->setCellValueExplicit('F' . $excel_row, $paid_amt, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                            $spreadsheet->getActiveSheet()->setCellValueExplicit('G' . $excel_row, $display_concession, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                            $spreadsheet->getActiveSheet()->setCellValueExplicit('H' . $excel_row, $pending_bal, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                            $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row, $std->father_mobile);
                            $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
                            $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row . ':I' . $excel_row)
                                ->getBorders()->getAllBorders()
                                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                            $sl_number++;
                            $excel_row++;
                        }
                    }
                // ── II PUC ───────────────────────────────────────────────────────
                } else {
                    $studentInfo = $this->student->getAllStudentInfo_II_PUC_For_Fee_report($term_name, $stream_name, $year);
                    foreach ($studentInfo as $std) {
                        $filter['fee_year']    = $year;
                        $filter['term_name']   = 'II PUC';
                        $filter['stream_name'] = $std->stream_name;
                        $filter['gender']       = $std->gender;

                        $filter['student_fee_type'] = 'REG';

                        if($std->intake_year_id == FEE_YEAR){
                            $filter['student_fee_type'] = 'NEW';
                        }else{
                            $filter['student_fee_type'] = 'REG';
                        }
                        // ── Total fee: base + govt fee (mirrors addFeePaymentInfo) ──
                        $total_fee_obj    = $this->fee->getTotalFeeAmount($filter);
                        $depart_fee       = $this->fee->getGovtFeeAmount($filter);
                        $total_fee_amount = (float)$total_fee_obj->total_fee + (float)$depart_fee;
                        // ── Paid amount using correct fee_year_int ──
                        $total_paid_obj = $this->fee->getFeePaidInfoForReport($std->row_id, $year);
                        $paid_amt = ($total_paid_obj->paid_amount != '')
                            ? (float)$total_paid_obj->paid_amount
                            : 0;
                        // ── Concession ──
                        $concession_amt     = $this->fee->getFeeConcessionByAppNo($std->row_id, $year);
                        $concession         = ($concession_amt > 0) ? (float)$concession_amt : 0;
                        // ── Pending balance ──
                        $pending_bal = $total_fee_amount - $paid_amt - $concession;
                        if ($pending_bal > 0) {
                            $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row)->getFont()->setSize(14);
                            $spreadsheet->getActiveSheet()->setCellValue('A' . $excel_row, $sl_number);
                            $spreadsheet->getActiveSheet()->setCellValueExplicit('B' . $excel_row, $std->student_id, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                            $spreadsheet->getActiveSheet()->setCellValue('C' . $excel_row, strtoupper($std->student_name));
                            $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row, $std->stream_name);
                            $spreadsheet->getActiveSheet()->setCellValueExplicit('E' . $excel_row, $total_fee_amount, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                            $spreadsheet->getActiveSheet()->setCellValueExplicit('F' . $excel_row, $paid_amt, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                            $spreadsheet->getActiveSheet()->setCellValueExplicit('G' . $excel_row, $concession, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                            $spreadsheet->getActiveSheet()->setCellValueExplicit('H' . $excel_row, $pending_bal, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
                            $spreadsheet->getActiveSheet()->setCellValue('I' . $excel_row, $std->father_mobile);
                            $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row)->getAlignment()->setWrapText(true);
                            $spreadsheet->getActiveSheet()->getStyle('A' . $excel_row . ':I' . $excel_row)
                                ->getBorders()->getAllBorders()
                                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                            $sl_number++;
                            $excel_row++;
                        }
                    }
                }
                // ── TOTAL row — written ONCE after both branches ─────────────────
                $spreadsheet->getActiveSheet()->setCellValue('D' . $excel_row, 'TOTAL');
                $spreadsheet->getActiveSheet()->setCellValue('E' . $excel_row, "=SUM(E4:E" . ($excel_row - 1) . ")");
                $spreadsheet->getActiveSheet()->setCellValue('F' . $excel_row, "=SUM(F4:F" . ($excel_row - 1) . ")");
                $spreadsheet->getActiveSheet()->setCellValue('G' . $excel_row, "=SUM(G4:G" . ($excel_row - 1) . ")");
                $spreadsheet->getActiveSheet()->setCellValue('H' . $excel_row, "=SUM(H4:H" . ($excel_row - 1) . ")");
                $spreadsheet->getActiveSheet()->getStyle('A4:H' . $excel_row)
                    ->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $spreadsheet->getActiveSheet()->getStyle("A" . $excel_row . ":H" . $excel_row)
                    ->applyFromArray($font_style_total);
                // ── Output ───────────────────────────────────────────────────────
                $spreadsheet->createSheet();
                $writer = new Xlsx($spreadsheet);
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Fee_Due_' . $term_name . '.xlsx"');
                header('Cache-Control: max-age=0');
                setcookie('isDownLoaded', 1);
                $writer->save("php://output");
            }
        }
    }

    public function specialFeePaymentReport()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $term_name    = $this->input->post('term_name');
            $fee_year     = $this->input->post('fee_year');
            $date_from    = $this->input->post('date_from');
            $date_to      = $this->input->post('date_to');
            $payment_type = $this->input->post('payment_type');
            $stream_name = $this->input->post('preference');

            if (!empty($date_to) && !empty($date_from)) {
                $filter['date_to'] = date('Y-m-d', strtotime($date_to));
                $filter['date_from'] = date('Y-m-d', strtotime($date_from));
            } else {
                $filter['date_to'] = "";
                $filter['date_from'] = "";
            }
            $filter['term_name'] = $term_name;
            $filter['fee_year'] = $fee_year;
            $filter['payment_type'] = $payment_type;
            $filter['stream_name'] = $stream_name;
            // log_message('debug','filter------>'.print_r($filter,true));

            $receipts = $this->fee->getSpecialFeeReceiptsByFilter($filter);
            // log_message('debug','receipts-------->'.print_r($receipts,true));

            $mpdf = new \Mpdf\Mpdf([
                'default_font' => 'timesnewroman',
                'format'       => 'A5',
            ]);
            $mpdf->SetTitle('Special Fee Receipt');

            $isFirstPage = true;

            foreach ($receipts as $receipt) {

                $feeInfo     = $this->fee->getFeeInfoByReceiptNum($receipt->receipt_number);
                $studentInfo = $this->student->getStudentInfoByRowId($feeInfo->application_no);

                if (empty($studentInfo)) continue;

                $term        = $term_name;
                $paid        = $this->fee->getFeePaidInfoForReportForReceipt($feeInfo->application_no, $term, $feeInfo->fee_year);
                $filter['student_fee_type'] = 'ALL';

                if($term == 'II PUC'){
                    if($studentInfo->intake_year_id == FEE_YEAR){
                        $filter['student_fee_type'] = 'NEW';
                    }else{
                        $filter['student_fee_type'] = 'ALL';
                    }

                }
                $spclFeeInfo = $this->fee->getSpecialFeeInfoByYear($term, $feeInfo->payment_year,$filter);

                $stream        = trim($studentInfo->stream_name);
                $total_fee_amt = 0;
                $fee_rows      = [];

                foreach ($spclFeeInfo as $spcl) {
                    if ($stream == 'PCMB') {
                        $amount = $spcl->PCMB;
                    } else if ($stream == 'PCMC') {
                        $amount = $spcl->PCMC;
                    } else if ($stream == 'HEBA') {
                        $amount = $spcl->HEBA;
                    } else if ($stream == 'ESBA') {
                        $amount = $spcl->ESBA;
                    } else if ($stream == 'EBAC') {
                        $amount = $spcl->EBAC;
                    } else if ($stream == 'HEPS') {
                        $amount = $spcl->HEPS;
                    } else {
                        $amount = 0;
                    }

                    if ($amount == 0) continue;

                    $total_fee_amt += $amount;
                    $fee_name       = htmlspecialchars($spcl->fee_name, ENT_QUOTES, 'UTF-8');
                    $fee_rows[]     = ['name' => $fee_name, 'amount' => $amount];
                }

                // if ($term == 'II PUC') {
                //     $student_reg_no = $studentInfo->student_id;
                // } else {
                //     $IPUCstudentID  = $this->student->getStudentInfoBy_AppNo($feeInfo->application_no);
                //     $student_reg_no = !empty($IPUCstudentID->student_id)
                //                         ? $IPUCstudentID->student_id
                //                         : $feeInfo->application_no;
                // }

                // $application_no = ($term == 'II PUC')
                //     ? $student_reg_no . '/' . $feeInfo->application_no
                //     : $student_reg_no;

                $paid_amount_words = $this->getIndianCurrency($total_fee_amt);

                $data = [
                    'feeInfo'           => $feeInfo,
                    'studentInfo'       => $studentInfo,
                    'paid'              => $paid,
                    'term'              => $term,
                    'stream'            => $stream,
                    'fee_rows'          => $fee_rows,
                    'total_fee_amt'     => $total_fee_amt,
                    'paid_amount_words' => $paid_amount_words,
                    'application_no'    => $application_no,
                    'student_reg_no'    => $student_reg_no,
                    'staffName'         => $this->fee->getStaffNameById($feeInfo->created_by),
                ];

                if ($isFirstPage) {
                    $mpdf->AddPage('P', '', '', '', '', 4, 4, 4, 4, 6, 6);
                    $isFirstPage = false;
                } else {
                    $mpdf->AddPage('P', '', '', '', '', 4, 4, 4, 4, 6, 6);
                }

                $html = $this->load->view('fees/specialFeeReceiptPrint', $data, true);
                $mpdf->WriteHTML($html);
            }

            $mpdf->Output('Special_Fee_Report.pdf', 'I');
        }
    }

    function getIndianCurrency(float $number) {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred','thousand','lakh', 'crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
    }
}
