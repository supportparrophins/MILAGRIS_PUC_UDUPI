<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Permission extends BaseController {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
        $this->load->model('staff_model','staff');
        $this->load->model('permission_model','permission');
        $this->load->model('settings_model','settings');
        $this->isLoggedIn();
    }

    function viewPermissions()
    {
        if($this->isAdmin() == TRUE )
        {
            $this->loadThis();
        }else{        
            $data['staffInfo'] = $this->staff->getAllStaffInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Staffs Permission Info';
            $this->loadViews("permission/view_permission", $this->global, $data , NULL);
        }
    }

    public function get_applied_permission_info(){
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $data_array_new = [];
       $filter = array();
        if($this->role == ROLE_ADMIN || $this->role == ROLE_PRINCIPAL || $this->role == ROLE_PRIMARY_ADMINISTRATOR || $this->role == ROLE_MANAGEMENT){
            
            $filter['by_date'] = date('Y-m-d');
            // if($this->role == ROLE_SECURITY){
            //     $permissionInfo = $this->permission->getAllStaffPermissionInfo($filter);
            // }else{
                $permissionInfo = $this->permission->getAllStaffPermissionInfo();
            // }
        }else{
            $filter['staff_id'] = $this->staff_id;
            $permissionInfo = $this->permission->getAllStaffPermissionInfo($filter);
        }
        foreach($permissionInfo as $per) {
            $deleteButton = "";
            $updateButton = "";
            $viewMore = "";
            $editButton = "";
            $permission_status = "";
            $viewMore = '<button class="btn btn-xs btn-primary" onclick="viewMoreInfo('.$per->row_id.')"
            title="View More"><i class="fa fa-eye"></i> View</button>';

            if($this->role == ROLE_ADMIN || $this->role == ROLE_PRIMARY_ADMINISTRATOR){
                $deleteButton = '<a class="btn btn-xs btn-danger " href="#"
                data-row_id="'.$per->row_id.'" id="deleteStaffPermission" title="Delete Attendance"><i
                    class="fa fa-trash"></i></a>';
             
            }
            if( $per->approved_status == 0 && $this->role != ROLE_MANAGEMENT){
                $editButton = '<button onclick="editPermissionInfo('.$per->row_id.')" class="btn btn-xs btn-info"
                title="Edit Attendance"><i
                    class="fas fa-pencil-alt"></i></button>';
                $permission_status = '<b id="tr'.$per->row_id.'" style="color:#B7950B">Pending</b>';
            }else if($per->approved_status == 1){
                $permission_status = '<b id="tr'.$per->row_id.'" style="color:green">Approved</b>';
            }else{
                $permission_status = '<b id="tr'.$per->row_id.'" style="color:Red">Rejected</b>'; 
            }

            $data_array_new[] = array(
                date('d-m-Y',strtotime($per->permission_date_from)),
                date('d-m-Y',strtotime($per->permission_date_to)),
                $per->staff_name,
                $per->out_time,
                $per->return_time,
                $per->permission_type,
                $permission_status,
                $viewMore.' '.$editButton.' '.$deleteButton,
           );
        }
        $count = count($permissionInfo);
        $result = array(
             "draw" => $draw,
              "recordsTotal" => $count,
              "recordsFiltered" => $count,
              "data" => $data_array_new
         );
    echo json_encode($result);
    exit();
    }

    public function applyNewPermission(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('fromDate','Date From','trim|required');
            $this->form_validation->set_rules('toDate','Date To','trim|required');
            $this->form_validation->set_rules('permission_type', 'Permission Type', 'trim|required');
            $this->form_validation->set_rules('out_time_hh', 'Out Time', 'required');
            $this->form_validation->set_rules('return_time_hh', 'Return Time', 'required');
            $this->form_validation->set_rules('permission_reason', 'Permission Reason', 'required');
            if($this->form_validation->run() == FALSE){
                redirect('viewPermissions');  
            }else{
              
                $fromDate =$this->security->xss_clean($this->input->post('fromDate')); 
                $toDate =$this->security->xss_clean($this->input->post('toDate')); 
                $permission_type =$this->security->xss_clean($this->input->post('permission_type')); 
                $out_time_hh =$this->security->xss_clean($this->input->post('out_time_hh')); 
                $out_time_mm =$this->security->xss_clean($this->input->post('out_time_mm')); 
                $return_time_hh =$this->security->xss_clean($this->input->post('return_time_hh'));
                $return_time_mm =$this->security->xss_clean($this->input->post('return_time_mm'));  
                $permission_reason =$this->security->xss_clean($this->input->post('permission_reason')); 
                
                $out_time = $out_time_hh.':'.$out_time_mm;
                $return_time = $return_time_hh.':'.$return_time_mm;

                $permissionInfo = array(
                    'staff_id' => $this->staff_id,
                    'permission_date_from' => date('Y-m-d',strtotime($fromDate)),
                    'permission_date_to' => date('Y-m-d',strtotime($toDate)),
                    'out_time' => $out_time,
                    'return_time' => $return_time,
                    'reason' => $permission_reason,
                    'permission_type' => $permission_type,
                    'created_by' => $this->staff_id,
                    'created_date_time' => date('Y-m-d H:i:s'),
                );
                $result = $this->permission->addNewPermissionInfo($permissionInfo);
               
                if($result > 0){
                    $this->session->set_flashdata('success', 'New Permission Applied successfully');
                }else{
                    $this->session->set_flashdata('error', 'New Permission failed to apply');
                }
                redirect('viewPermissions');  
            }
        }
    }

//apply permission by admin

public function applyNewPermissionByAdmin(){
    if($this->isAdmin() == TRUE)
    {
        $this->loadThis();
    } else {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('fromDate','Date From','trim|required');
        $this->form_validation->set_rules('toDate','Date To','trim|required');
        $this->form_validation->set_rules('permission_type', 'Permission Type', 'trim|required');
        $this->form_validation->set_rules('out_time_hh', 'Out Time', 'required');
        $this->form_validation->set_rules('return_time_hh', 'Return Time', 'required');
        $this->form_validation->set_rules('permission_reason', 'Permission Reason', 'required');
        if($this->form_validation->run() == FALSE){
            redirect('viewPermissions');  
        }else{
            $staff_id =$this->security->xss_clean($this->input->post('applied_staff_id')); 
            $fromDate =$this->security->xss_clean($this->input->post('fromDate')); 
            $toDate =$this->security->xss_clean($this->input->post('toDate')); 
            $permission_type =$this->security->xss_clean($this->input->post('permission_type')); 
            $out_time_hh =$this->security->xss_clean($this->input->post('out_time_hh')); 
            $out_time_mm =$this->security->xss_clean($this->input->post('out_time_mm')); 
            $return_time_hh =$this->security->xss_clean($this->input->post('return_time_hh'));
            $return_time_mm =$this->security->xss_clean($this->input->post('return_time_mm')); 
            $permission_reason =$this->security->xss_clean($this->input->post('permission_reason')); 
            
            $out_time = $out_time_hh.':'.$out_time_mm;
            $return_time = $return_time_hh.':'.$return_time_mm;
            $permissionInfo = array(
                'staff_id' => $staff_id,
                'permission_date_from' => date('Y-m-d',strtotime($fromDate)),
                'permission_date_to' => date('Y-m-d',strtotime($toDate)),
                'out_time' => $out_time,
                'return_time' => $return_time,
                'reason' => $permission_reason,
                'permission_type' => $permission_type,
                'created_by' => $this->staff_id,
                'created_date_time' => date('Y-m-d H:i:s'),
            );
            $result = $this->permission->addNewPermissionInfo($permissionInfo);
           
            if($result > 0){
                $this->session->set_flashdata('success', 'New Permission Applied successfully');
            }else{
                $this->session->set_flashdata('error', 'New Permission failed to apply');
            }
            redirect('viewPermissions');  
        }
    }  
}



    //update permission info
public function updatePermissionInfoByStaff(){
    if($this->isAdmin() == TRUE)
    {
        $this->loadThis();
    } else {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('fromDate','Date From','trim|required');
        $this->form_validation->set_rules('toDate','Date To','trim|required');
        $this->form_validation->set_rules('permission_type', 'Permission Type', 'trim|required');
        $this->form_validation->set_rules('out_time_hh', 'Out Time', 'required');
        $this->form_validation->set_rules('return_time_hh', 'Return Time', 'required');
        $this->form_validation->set_rules('permission_reason', 'Permission Reason', 'required');
        if($this->form_validation->run() == FALSE){
            redirect('viewPermissions');  
        }else{
            $row_id =$this->security->xss_clean($this->input->post('row_id')); 
            $fromDate =$this->security->xss_clean($this->input->post('fromDate')); 
            $toDate =$this->security->xss_clean($this->input->post('toDate')); 
            $permission_type =$this->security->xss_clean($this->input->post('permission_type')); 
            $out_time_hh =$this->security->xss_clean($this->input->post('out_time_hh')); 
            $out_time_mm =$this->security->xss_clean($this->input->post('out_time_mm')); 
            $return_time_hh =$this->security->xss_clean($this->input->post('return_time_hh'));
            $return_time_mm =$this->security->xss_clean($this->input->post('return_time_mm')); 
            $permission_reason =$this->security->xss_clean($this->input->post('permission_reason')); 
            
            $out_time = $out_time_hh.':'.$out_time_mm;
            $return_time = $return_time_hh.':'.$return_time_mm;

            $permissionInfo = array(
                'permission_date_from' => date('Y-m-d',strtotime($fromDate)),
                'permission_date_to' => date('Y-m-d',strtotime($toDate)),
                'out_time' => $out_time,
                'return_time' => $return_time,
                'reason' => $permission_reason,
                'permission_type' => $permission_type,
                'updated_by' => $this->staff_id,
                'updated_date_time' => date('Y-m-d H:i:s'),
            );
            $result = $this->permission->updateStaffAppliedPermissionInfo($permissionInfo,$row_id);
            if($result > 0){
                $this->session->set_flashdata('success', 'Permission Updated successfully');
            }else{
                $this->session->set_flashdata('error', 'Permission update failed');
            }
            redirect('viewPermissions');  
        }
    }
}

    public function getPermissionInfoByRowId(){
        if ($this->isAdmin() == true) {
             $this->loadThis();
        } else {
            $date_from_month = date('Y-m-01');
            $date_to_today  = date('Y-m-d');
            $date_from_year = date('Y-01-01');
            $row_id = $this->security->xss_clean($this->input->post('row_id'));
            $data['permissionInfo'] = $this->permission->getPermissionInfoByRowId($row_id);
            $data['month_count'] = $this->permission->getPermissionCountByDate($date_from_month,$date_to_today,$data['permissionInfo']->staff_id);
            $data['year_count'] = $this->permission->getPermissionCountByDate($date_from_year,$date_to_today,$data['permissionInfo']->staff_id);

            echo json_encode($data);
            exit();
        }
       }

          //this update method for approve, reject staff leave 
   public function updateStaffPermissionInfo(){
    if($this->isAdmin() == TRUE){
        $this->loadThis();
    } else {   
        $row_id = $this->input->post('row_id');
        $type = $this->input->post('type');
        $AppliedPermissionInfo = $this->permission->getPermissionInfoByRowId($row_id);
        if($type == 'Approve'){
            $permissionInfo = array('approved_status' => 1,
            'approved_by' => $this->staff_id,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id,
        );
        
        }else if($type == 'Special_Approve'){
            $permissionInfo = array('approved_status' => 1,
            'special_permission_status' => 1,
            'approved_by' => $this->staff_id,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id,
        );
        }else if($type == 'Reject'){
            $permissionInfo = array('approved_status' => 2,
            'special_permission_status' => 0,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'rejected_by' => $this->staff_id,
            'updated_by' => $this->staff_id,
        );
        }else if($type == 'Delete'){
            $permissionInfo = array(
            'approved_status' => 0,
            'special_permission_status' => 0,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'is_deleted' => 1,
            'updated_by' => $this->staff_id,);
        }
       
        $result = $this->permission->updateStaffAppliedPermissionInfo($permissionInfo, $row_id);
        if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
    } 
}

public function downloadStaffPermissionReport(){
    if($this->isAdmin() == TRUE)
    {
        $this->loadThis();
    } else {
        $date_from = $this->security->xss_clean($this->input->post('from_date'));
        $date_to = $this->security->xss_clean($this->input->post('to_date'));
        $permission_type = $this->security->xss_clean($this->input->post('permission_type'));
        $applied_staff_id = $this->security->xss_clean($this->input->post('applied_staff_id'));
       
        $sheet = 0;
 
       // foreach($department_list as $dept){
        $this->excel->setActiveSheetIndex($sheet);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Leave Info');
        $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');
        //set Title content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', "SHAKTHI RESIDENTIAL SCHOOL, MANGALORE");
        $this->excel->getActiveSheet()->setCellValue('A2', "STAFF LEAVE INFORMATION");
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
        $this->excel->getActiveSheet()->mergeCells('A1:I1');
        $this->excel->getActiveSheet()->mergeCells('A2:I2');
        $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
  
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(28);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(18);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(18);
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(18);

        $this->excel->getActiveSheet()->setCellValue('A3', "Date From: ".$date_from." Date To: ".$date_to);
        $this->excel->getActiveSheet()->mergeCells('A3:D3');
        $this->excel->getActiveSheet()->setCellValue('E3', "Leave Type: ".$permission_type);
        $this->excel->getActiveSheet()->mergeCells('E3:I3');
        $this->excel->getActiveSheet()->getStyle('E3:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A3:I3')->getFont()->setBold(true);


        $this->excel->setActiveSheetIndex($sheet)->setCellValue('A4', 'SL. NO.');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('B4', 'Permission Date');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('C4', 'Staff ID');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('D4', 'Name');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('E4', 'Reason');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('F4', 'Permission Type');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('G4', 'Out Time');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('H4', 'Return Time');
        $this->excel->setActiveSheetIndex($sheet)->setCellValue('I4', 'Total Time');
       
        
        $this->excel->getActiveSheet()->getStyle('A4:I4')->getAlignment()->setWrapText(true); 
        $this->excel->getActiveSheet()->getStyle('A4:I4')->getFont()->setBold(true); 
        $this->excel->getActiveSheet()->getStyle('A4:I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
        $this->excel->getActiveSheet()->getStyle('A1:I4')->applyFromArray($styleBorderArray);
        $start_date = date('Y-m-d',strtotime($date_from)); 
        $end_date = date('Y-m-d',strtotime($date_to)); 
        $staffInfo = $this->permission->getAllStaffPermissionForReport($start_date, $end_date, $applied_staff_id, $permission_type);
        // log_message('debug','stfperm'.print_r($staffInfo,true));
        $j=1;
        $excel_row = 5;
        if(!empty($staffInfo)){
            foreach($staffInfo as $staff){
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,date('d-m-Y',strtotime($staff->permission_date_from)));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,$staff->staff_id);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,$staff->staff_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,$staff->reason);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$staff->permission_type);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,$staff->out_time);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row,$staff->return_time);
                $time1 = new DateTime($staff->out_time);
                $time2 = new DateTime($staff->return_time);
                $interval = $time1->diff($time2);
                $total_hour = $interval->format('%H:%I:%S');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row,$total_hour);
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

// function sum_the_time($time1, $time2) {
//     $times = array($time1, $time2);
//     $seconds = 0;
//     foreach ($times as $time)
//     {
//       list($hour,$minute,$second) = explode(':', $time);
//       $seconds += $hour*3600;
//       $seconds += $minute*60;
//       $seconds += $second;
//     }
//     $hours = floor($seconds/3600);
//     $seconds -= $hours*3600;
//     $minutes  = floor($seconds/60);
//     $seconds -= $minutes*60;
//     // return "{$hours}:{$minutes}:{$seconds}";
//     return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
//   }
}