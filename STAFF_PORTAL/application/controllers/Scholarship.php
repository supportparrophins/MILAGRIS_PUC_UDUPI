<?php if (!defined('BASEPATH')) {

exit('No direct script access allowed');

}



require APPPATH . '/libraries/BaseControllerFaculty.php';
require_once 'vendor/autoload.php';


class Scholarship extends BaseController {

public function __construct()

{

    parent::__construct();

    $this->load->model('Scholarship_model','scholarship');
    $this->load->model('settings_model','settings');
    $this->load->model('students_model','student');
    $this->load->library('excel');
    $this->isLoggedIn();

}

function scholarshipListing()
{
    if($this->isAdmin() == TRUE)
    {
        $this->loadThis();
    } else {      

        // $devotee_id = $this->security->xss_clean($this->input->post('devotee_id'));
        $scholarship_type = $this->security->xss_clean($this->input->post('scholarship_type'));
        $scholarship_date = $this->security->xss_clean($this->input->post('scholarship_date'));  
        $scholarship_code = $this->security->xss_clean($this->input->post('scholarship_code'));
        $max_amount = $this->security->xss_clean($this->input->post('max_amount'));
        $scholarship_society = $this->security->xss_clean($this->input->post('scholarship_society'));
        $application_no_prefix = $this->security->xss_clean($this->input->post('application_no_prefix'));
        
       
        $data['scholarship_code'] = $scholarship_code;
        $data['max_amount'] = $max_amount;
        $data['scholarship_society'] = $scholarship_society;
        if(!empty($scholarship_date)){
        $data['scholarship_date'] = $scholarship_date;
        }else{
            $data['scholarship_date'] = '';
        }
        $data['scholarship_type'] = $scholarship_type;
        $data['application_no_prefix'] = $application_no_prefix;

        $filter['application_no_prefix'] = $application_no_prefix;
        $filter['scholarship_code'] = $scholarship_code;
        $filter['max_amount'] = $max_amount;
        if(!empty($scholarship_date)){
        $filter['scholarship_date'] = date('Y-m-d',strtotime($scholarship_date));
        }
        $filter['scholarship_type'] = $scholarship_type;
        $filter['scholarship_society'] = $scholarship_society;

        $this->load->library('pagination');
        $count = $this->scholarship->scholarshipListingCount($filter);
        $data['count'] =  $count;
        $returns = $this->paginationCompress ( "scholarshipListing/", $count, 100 );
        $data['scholarshipRecords'] = $this->scholarship->scholarshipListing($filter, $returns["page"], $returns["segment"]);
        $data['Scholarship_model'] = $this->scholarship;
        $data['scholarshipTypeInfo'] = $this->scholarship->getAllScholarshipTypeInfo();
        $data['scholarshipRecommendedInfo'] = $this->scholarship->getAllScholarshipRecommendedInfo();
        $this->global['pageTitle'] = ''.TAB_TITLE.' :Scholarship Details ';
        $this->loadViews("Scholarship/scholarshipList", $this->global, $data, NULL);
    }
}

public function addScholarshipDetails(){
    if($this->isAdmin() == TRUE)
    {
        $this->loadThis();
    }  else {
         
            $scholarship_end_date = $this->security->xss_clean($this->input->post('scholarship_end_date'));
            $scholarship_type = $this->security->xss_clean($this->input->post('scholarship_type'));
            $max_amount = $this->security->xss_clean($this->input->post('max_amount'));
            $scholarship_society = $this->security->xss_clean($this->input->post('scholarship_society'));
            $application_no_prefix = $this->security->xss_clean($this->input->post('application_no_prefix'));
            
            $scholarshipInfo = $this->scholarship->getScholarshipInfoByType($scholarship_type);
            if(empty($scholarshipInfo)){
                $scholarshipInfos = array(
                    'scholarship_end_date'=>date('Y-m-d',strtotime($scholarship_end_date)),
                    'scholarship_id' =>$scholarship_type,
                    'max_amount' =>$max_amount,
                    'scholarship_society' =>$scholarship_society,
                    'application_no_prefix' =>$application_no_prefix,
                    'created_by'=> $this->staff_id, 
                    'created_date_time'=>date('Y-m-d H:i:s'));

                  $return_id = $this->scholarship->addScholarshipInfoToDB($scholarshipInfos);

                if($return_id > 0){
                   
                    $this->session->set_flashdata('success', 'Scholarship added successfully');
                } else{
                    $this->session->set_flashdata('error', 'Scholarship adding failed');
                }   
            }else{
                $this->session->set_flashdata('error', 'Scholarship Already added');
            }
            
            redirect('scholarshipListing');
        
    }
}

function editScholarshipDetailsPageView($row_id = NULL)
{
    if($this->isAdmin() == TRUE) {
        $this->loadThis();
    } else {
        if($row_id == null){
            redirect('scholarshipListing');
        }
        $application_no = $this->security->xss_clean($this->input->post('application_no'));
        $student_name = $this->security->xss_clean($this->input->post('student_name'));
        $application_date = $this->security->xss_clean($this->input->post('application_date'));  
        $debit_ac_no_list = $this->security->xss_clean($this->input->post('debit_ac_no_list'));
        $credit_ac_no_list = $this->security->xss_clean($this->input->post('credit_ac_no_list'));

        if(!empty($application_date)){
            $data['application_date'] = $application_date;
            $filter['application_date'] = date('Y-m-d',strtotime($application_date));
        }else{
            $data['application_date'] = '';
            $filter['application_date'] = '';
        }

        $data['application_no'] = $application_no;
        $data['student_name'] = $student_name;
        $data['debit_ac_no_list'] = $debit_ac_no_list;
        $data['credit_ac_no_list'] = $credit_ac_no_list;

        $filter['application_no'] = $application_no;
        $filter['student_name'] = $student_name;
        $filter['debit_ac_no_list'] = $debit_ac_no_list;
        $filter['credit_ac_no_list'] = $credit_ac_no_list;

        $data['scholarshipInfo'] = $this->scholarship->getScholarshipInfoByEmpId($row_id);
        $data['scholarshipTypeInfo'] = $this->scholarship->getAllScholarshipTypeInfo();
        $data['scholarshipRecommendedInfo'] = $this->scholarship->getAllScholarshipRecommendedInfo();
        $data['scholarshipRecords'] = $this->scholarship->studentSholarshipListing($row_id,$filter);

        $this->global['pageTitle'] = ''.TAB_TITLE.' :View Scholarship Details ';
        $this->loadViews("Scholarship/viewScholarshipInfo", $this->global, $data, NULL);
    }
}

public function addScholarshipStudentDetails(){
    if($this->isAdmin() == TRUE) {
        $this->loadThis();
    } else {
        $student_id = $this->security->xss_clean($this->input->post('student_id'));
        $scholarship_row_id = $this->security->xss_clean($this->input->post('scholarship_row_id'));
        $application_date = $this->security->xss_clean($this->input->post('application_date'));
        $amount_requested = $this->security->xss_clean($this->input->post('amount_requested'));
        $scholarship_amount = $this->security->xss_clean($this->input->post('scholarship_amount'));
        $term_name = $this->security->xss_clean($this->input->post('term_name'));
        $scholarship_code = $this->security->xss_clean($this->input->post('scholarship_code'));
        $payment_date = $this->security->xss_clean($this->input->post('payment_date'));
        $debit_ac_no = $this->security->xss_clean($this->input->post('debit_ac_no'));
        $credit_ac_no = $this->security->xss_clean($this->input->post('credit_ac_no'));
        $recommended_by = $this->security->xss_clean($this->input->post('recommended_by'));
        $sanctioned_by = $this->security->xss_clean($this->input->post('sanctioned_by'));
        $remarks = $this->security->xss_clean($this->input->post('remarks'));
        $uploadPath = 'upload/scholarship/';
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
       

       
        
      
        $document_submission = $this->input->post('document');
        $application_submission = isset($document_submission['application']) 
        ? implode(',', $document_submission['application']) 
        : '';

        $aadhar_student = isset($document_submission['aadhar_student']) 
        ? implode(',', $document_submission['aadhar_student']) 
        : '';

        $aadhar_parents = isset($document_submission['aadhar_parents']) 
        ? implode(',', $document_submission['aadhar_parents']) 
        : '';

        $bank_passbook = isset($document_submission['bank_passbook']) 
        ? implode(',', $document_submission['bank_passbook']) 
        : '';

        $income_caste_certificate = isset($document_submission['income_caste_certificate']) 
        ? implode(',', $document_submission['income_caste_certificate']) 
        : '';

        $marks_card = isset($document_submission['marks_card']) 
        ? implode(',', $document_submission['marks_card']) 
        : '';

        $recommendation_letter = isset($document_submission['recommendation_letter']) 
        ? implode(',', $document_submission['recommendation_letter']) 
        : '';

        $fee_payment_receipt = isset($document_submission['fee_payment_receipt']) 
        ? implode(',', $document_submission['fee_payment_receipt']) 
        : '';

        $passport_photo = isset($document_submission['passport_photo']) 
        ? implode(',', $document_submission['passport_photo']) 
        : '';

        $scholarship_transfer_letter = isset($document_submission['scholarship_transfer_letter']) 
        ? implode(',', $document_submission['scholarship_transfer_letter']) 
        : '';
       

        if (!empty($application_date)) {
            $application_date = date('Y-m-d', strtotime($application_date));
        } else {
            $application_date = "";
        }
        if (!empty($payment_date)) {
            $payment_date = date('Y-m-d', strtotime($payment_date));
        } else {
            $payment_date = "";
        }
        $scholarshipInfo = $this->scholarship->getScholarshipInfoByEmpId($scholarship_row_id);
        $prefix_count = strlen($scholarshipInfo->application_no_prefix);
        
        $lastApplicationNumber = $this->scholarship->getLastApplicationNumberScholarship($scholarship_row_id);
        // Check if this is the first application
        if (empty($lastApplicationNumber)) {
            // Start with '001' if no previous applications
            $newApplicationNumber = $scholarshipInfo->application_no_prefix.'0001';
        } else {
               // Remove the prefix from the last application number to get the numeric part
                $numericPart = substr($lastApplicationNumber, $prefix_count);

                // Increment the numeric part, pad with zeros, and prepend the prefix
                $newApplicationNumber = $scholarshipInfo->application_no_prefix . str_pad(((int)$numericPart + 1), 4, '0', STR_PAD_LEFT);
        }
        $sevaInfo = array(
            'student_row_id' => $student_id,
            'scholarship_row_id' => $scholarship_row_id,
            'application_number' => $newApplicationNumber,
            'application_date' => $application_date,
            'amount_requested' => $amount_requested,
            'scholarship_amount' => $scholarship_amount,
            'term_name' => $term_name,
            'scholarship_code' => $scholarship_code,
            'payment_date' => $payment_date,
            'debit_ac_no' => $debit_ac_no,  // Each row should have qty of 1
            'credit_ac_no' => $credit_ac_no,
            'recommended_by' => $recommended_by,
            'sanctioned_by' => $sanctioned_by,
            'remarks' => $remarks,
            'application' => $application_submission,
            'student_aadhar' => $aadhar_student,
            'parents_aadhar' => $aadhar_parents,
            'bank_pass_book' => $bank_passbook,
            'income_certificate' => $income_caste_certificate,
            'marks_card' => $marks_card,
            'recommendation_letter' => $recommendation_letter,
            'fee_payment_receipt' => $fee_payment_receipt,
            'passport_size_photo' => $passport_photo,
            'institution_transfer_of_scholarship_letter' => $scholarship_transfer_letter,
           
            'created_by' => $this->staff_id,
            'created_date_time' => date('Y-m-d H:i:s')
        );

         

        

        $return_id = $this->scholarship->addScholarshipStudentInfoToDB($sevaInfo);
        $uploadPath = 'upload/scholarship/'.$return_id.'/';
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $captured_image_data = $this->security->xss_clean($this->input->post('captured_image_data'));
        if(!empty($captured_image_data)){

           

            $folderPath = 'upload/scholarship/'.$return_id.'/';

            $image_parts = explode(";base64,", $_POST['captured_image_data']);

            $image_type_aux = explode("upload/", $image_parts[0]);

            $image_type = $image_type_aux[1];

            $image_base64 = base64_decode($image_parts[1]);

            $file = $folderPath . 'student_photo' . '.png';

            file_put_contents($file, $image_base64);

           
        }
        $image_path="";
        $folderPath = 'upload/scholarship/'.$return_id.'/';
        
        $config = [
            'upload_path'   => $folderPath,
            'allowed_types' => 'gif|jpg|png|jpeg',
            'overwrite'     => TRUE,
            'file_name'     => 'student_photo.png' // Set a specific file name
        ];
        
        // Load the upload library
        $this->load->library('upload', $config);
        
        // Specify the file input name (e.g., 'userfile')
        if($this->upload->do_upload('userfile')) // Replace 'userfile' with your input field name
        {
            $post = $this->input->post();
            $data = $this->upload->data();
            $image_path = $folderPath . 'student_photo.png';
            $post['image_path'] = $image_path;
        }
        if(!empty($image_path)){
            $image = $image_path;
        }else if(!empty($file)){
            $image = $file;
        }else {
            $image = '';
        }
         
        $uploadInfo = array(
            'photo_url'=> $image, 
            'updated_by' => $this->staff_id, 
            'updated_date_time' => date('Y-m-d H:i:s'));
            $return_id = $this->scholarship->updateScholarshipStudentDetail($uploadInfo,$return_id);
       
        if ($return_id > 0) {
            $this->session->set_flashdata('success', 'Scholarship student added successfully');
        } else {
            $this->session->set_flashdata('error', 'Scholarship student adding failed');
        }
        
        redirect('editScholarshipDetailsPageView/'.$scholarship_row_id);
       
    }
}

public function updateScholarshipStudentDetails(){
    if($this->isAdmin() == TRUE) {
        $this->loadThis();
    } else {
        $row_id = $this->input->post('scholarship_row_id');
        $student_id = $this->security->xss_clean($this->input->post('student_id'));
        $application_date = $this->security->xss_clean($this->input->post('application_date'));
        $amount_requested = $this->security->xss_clean($this->input->post('amount_requested'));
        $scholarship_code = $this->security->xss_clean($this->input->post('scholarship_code'));
        $scholarship_amount = $this->security->xss_clean($this->input->post('scholarship_amount'));
        $term_name = $this->security->xss_clean($this->input->post('term_name'));
        $payment_date = $this->security->xss_clean($this->input->post('payment_date'));
        $debit_ac_no = $this->security->xss_clean($this->input->post('debit_ac_no'));
        $credit_ac_no = $this->security->xss_clean($this->input->post('credit_ac_no'));
        $recommended_by = $this->security->xss_clean($this->input->post('recommended_by'));
        $sanctioned_by = $this->security->xss_clean($this->input->post('sanctioned_by'));
        $remarks = $this->security->xss_clean($this->input->post('remarks'));

        // $image_path="";
        // $config=['upload_path' => './upload/scholarship/',
        // 'allowed_types' => 'gif|jpg|png|jpeg','overwrite' => TRUE,];
        // $this->load->library('upload', $config);
        // if($this->upload->do_upload())
        // {
        //     $post=$this->input->post();
        //     $data=$this->upload->data();
        //     $image_path= "upload/scholarship/".$data['raw_name'].$data['file_ext'];
        //     $post['image_path']=$image_path;
        // }

        $captured_image_data = $this->security->xss_clean($this->input->post('captured_image_data'));
        if(!empty($captured_image_data)){

            if (is_dir($uploadPath)) {

                $imageFormatsToDelete = ['student_photo.png'];
                $filesToDelete = array_map(function($format) use ($uploadPath) {
                    return $uploadPath . $format;
                }, $imageFormatsToDelete);
               
                foreach ($filesToDelete as $file) {
                    unlink($file); // Delete each file
                }
            }

            $folderPath = 'upload/scholarship/'.$row_id.'/';

            $image_parts = explode(";base64,", $_POST['captured_image_data']);

            $image_type_aux = explode("upload/", $image_parts[0]);

            $image_type = $image_type_aux[1];

            $image_base64 = base64_decode($image_parts[1]);

            $file = $folderPath . 'student_photo' . '.png';

            file_put_contents($file, $image_base64);

           
        }
        $image_path="";
        $folderPath = 'upload/scholarship/'.$row_id.'/';
        
        $config = [
            'upload_path'   => $folderPath,
            'allowed_types' => 'gif|jpg|png|jpeg',
            'overwrite'     => TRUE,
            'file_name'     => 'student_photo.png' // Set a specific file name
        ];
        
        // Load the upload library
        $this->load->library('upload', $config);
        
        // Specify the file input name (e.g., 'userfile')
        if($this->upload->do_upload('userfile')) // Replace 'userfile' with your input field name
        {
            $post = $this->input->post();
            $data = $this->upload->data();
            $image_path = $folderPath . 'student_photo.png';
            $post['image_path'] = $image_path;
        }
        if(!empty($image_path)){
            $image = $image_path;
        }else if(!empty($file)){
            $image = $file;
        }else {
            $image = '';
        }

        $document_submission = $this->input->post('document');
        $application_submission = isset($document_submission['application']) 
        ? implode(',', $document_submission['application']) 
        : '';

        $aadhar_student = isset($document_submission['aadhar_student']) 
        ? implode(',', $document_submission['aadhar_student']) 
        : '';

        $aadhar_parents = isset($document_submission['aadhar_parents']) 
        ? implode(',', $document_submission['aadhar_parents']) 
        : '';

        $bank_passbook = isset($document_submission['bank_passbook']) 
        ? implode(',', $document_submission['bank_passbook']) 
        : '';

        $income_caste_certificate = isset($document_submission['income_caste_certificate']) 
        ? implode(',', $document_submission['income_caste_certificate']) 
        : '';

        $marks_card = isset($document_submission['marks_card']) 
        ? implode(',', $document_submission['marks_card']) 
        : '';

        $recommendation_letter = isset($document_submission['recommendation_letter']) 
        ? implode(',', $document_submission['recommendation_letter']) 
        : '';

        $fee_payment_receipt = isset($document_submission['fee_payment_receipt']) 
        ? implode(',', $document_submission['fee_payment_receipt']) 
        : '';

        $passport_photo = isset($document_submission['passport_photo']) 
        ? implode(',', $document_submission['passport_photo']) 
        : '';

        $scholarship_transfer_letter = isset($document_submission['scholarship_transfer_letter']) 
        ? implode(',', $document_submission['scholarship_transfer_letter']) 
        : '';
       

        if (!empty($application_date)) {
            $application_date = date('Y-m-d', strtotime($application_date));
        } else {
            $application_date = "";
        }
        if (!empty($payment_date)) {
            $payment_date = date('Y-m-d', strtotime($payment_date));
        } else {
            $payment_date = "";
        }
        
     
        
        $sevaInfo = array(
           // 'student_row_id' => $student_id,
           // 'scholarship_row_id' => $scholarship_row_id,
           // 'application_number' => $newApplicationNumber,
            'application_date' => $application_date,
            'amount_requested' => $amount_requested,
            'scholarship_code' => $scholarship_code,
            'scholarship_amount' => $scholarship_amount,
            'term_name' => $term_name,
            'payment_date' => $payment_date,
            'debit_ac_no' => $debit_ac_no,  // Each row should have qty of 1
            'credit_ac_no' => $credit_ac_no,
            'recommended_by' => $recommended_by,
            'sanctioned_by' => $sanctioned_by,
            'remarks' => $remarks,
            'application' => $application_submission,
            'student_aadhar' => $aadhar_student,
            'parents_aadhar' => $aadhar_parents,
            'bank_pass_book' => $bank_passbook,
            'income_certificate' => $income_caste_certificate,
            'marks_card' => $marks_card,
            'recommendation_letter' => $recommendation_letter,
            'fee_payment_receipt' => $fee_payment_receipt,
            'passport_size_photo' => $passport_photo,
            'institution_transfer_of_scholarship_letter' => $scholarship_transfer_letter,
           
            'updated_by' => $this->staff_id,
            'updated_date_time' => date('Y-m-d H:i:s')
        );
        if(!empty($image)){
            $sevaInfo['photo_url'] = $image;
        }

        $return_id = $this->scholarship->updateScholarshipStudentDetail($sevaInfo ,$row_id);


       
        if ($return_id > 0) {
            $this->session->set_flashdata('success', 'Scholarship student updated successfully');
        } else {
            $this->session->set_flashdata('error', 'Scholarship student updation failed');
        }
        
        redirect('editScholarshipInfo/'.$row_id);
       
    }
}
public function deleteScholarshipDetail(){
    if($this->isAdmin() == TRUE){
        $this->loadThis();
    } else {   
        $row_id = $this->input->post('row_id');
        $sevaInfo = array('is_deleted' => 1);
        $result = $this->scholarship->updateScholarshipStudentDetail($sevaInfo, $row_id);
        if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
    } 
}

public function scholarshipStudentPrint($row_id){
    if($this->isAdmin() == TRUE){
        $this->loadThis();
    } else {   
        error_reporting(0); 
       
        $data['scholarshipRecords'] = $this->scholarship->getScholarshipStudentInformationByID($row_id);
        // log_message('debug','scholarshipRecords -->'.print_r($data['scholarshipRecords'],true));
                  
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Scholarship Receipt';
        // $this->loadViews("fees/feeReceiptPrint", $this->global, $data, null); 
        define('_MPDF_TTFONTPATH', __DIR__ . '/fonts');
        $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','format' => 'A4-L']);
        $mpdf->AddPage('P','','','','',10,10,8,8,8,8);
        $mpdf->SetTitle('Student Scholarship');
        $html = $this->load->view('Scholarship/printScholarship',$data,true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('scholarship.pdf', 'I');
    } 
}


public function deleteScholarshipInfo(){
    if($this->isAdmin() == TRUE){
        $this->loadThis();
    } else {   
        $row_id = $this->input->post('row_id');
        $scholarshipInfo = array('is_deleted' => 1,
        'updated_date_time' => date('Y-m-d H:i:s'),
        'updated_by' => $this->staff_id
        );
        $result = $this->scholarship->updateScholarshipInfo($scholarshipInfo, $row_id);
        if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
    } 
}

public function editScholarshipInfo($row_id = null)
{
    if($this->isAdmin() == TRUE ){
        $this->loadThis();
    } else {
        if ($row_id == null) {
            redirect('scholarshipListing');
        }
        $data['scholarshipInfo'] = $this->scholarship->getScholarshipInfoByEmpId($row_id);
        $data['scholarshipTypeInfo'] = $this->scholarship->getAllScholarshipTypeInfo();
        $data['scholarshipRecommendedInfo'] = $this->scholarship->getAllScholarshipRecommendedInfo();
        $data['scholarshipRecords'] = $this->scholarship->getStudentSholarship($row_id);
        log_message('debug','filetyeteyt'.print_r($data['scholarshipRecords'],true));
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit Student Details';
        $this->loadViews("Scholarship/editScholarshipInfo", $this->global, $data, null);
    }
}

public function editScholarship($row_id = null)
{
    if($this->isAdmin() == TRUE ){
        $this->loadThis();
    } else {
        if ($row_id == null) {
            redirect('scholarshipListing');
        }
        $data['scholarshipInfo'] = $this->scholarship->getScholarshipInfoByEmpId($row_id);
        // log_message('debug','scholarshipInfo -->'.print_r($data['scholarshipInfo'],true));
        $data['scholarshipTypeInfo'] = $this->scholarship->getAllScholarshipTypeInfo();
        $data['scholarshipRecommendedInfo'] = $this->scholarship->getAllScholarshipRecommendedInfo();
        $data['scholarshipRecords'] = $this->scholarship->getStudentSholarship($row_id);
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit Student Details';
        $this->loadViews("Scholarship/editScholarship", $this->global, $data, null);
    }
}

public function updateScholarship(){
    if($this->isAdmin() == TRUE)
    {
        $this->loadThis();
    }  else {
            $row_id = $this->security->xss_clean($this->input->post('row_id'));
            $scholarship_end_date = $this->security->xss_clean($this->input->post('scholarship_end_date'));
            $scholarship_type = $this->security->xss_clean($this->input->post('scholarship_type'));
            $prev_scholarship_type = $this->security->xss_clean($this->input->post('prev_scholarship_type'));
            $max_amount = $this->security->xss_clean($this->input->post('max_amount'));
            $scholarship_society = $this->security->xss_clean($this->input->post('scholarship_society'));
           

            if ($scholarship_type != $prev_scholarship_type) {

            $scholarshipInfo = $this->scholarship->getScholarshipInfoByType($scholarship_type);
            if(empty($scholarshipInfo)){
                $scholarshipInfos = array(
                    'scholarship_end_date'=>date('Y-m-d',strtotime($scholarship_end_date)),
                    'scholarship_id' =>$scholarship_type,
                    'scholarship_society' =>$scholarship_society,
                    'max_amount' =>$max_amount,
                    'created_by'=> $this->staff_id, 
                    'created_date_time'=>date('Y-m-d H:i:s'));

                  $return_id = $this->scholarship->updateScholarshipInfo($scholarshipInfos,$row_id);
                
                if($return_id > 0){
                   
                    $this->session->set_flashdata('success', 'Scholarship Added successfully');
                } else{
                    $this->session->set_flashdata('error', 'Scholarship adding failed');
                }   
            }else{
                $this->session->set_flashdata('error', 'Scholarship Already Added');
            }
        } else {
            $scholarshipInfos = array(
                'scholarship_end_date'=>date('Y-m-d',strtotime($scholarship_end_date)),
                'scholarship_id' =>$scholarship_type,
                'max_amount' =>$max_amount,
                'scholarship_society' =>$scholarship_society,
                'created_by'=> $this->staff_id, 
                'created_date_time'=>date('Y-m-d H:i:s'));

              $return_id = $this->scholarship->updateScholarshipInfo($scholarshipInfos,$row_id);

            if($return_id > 0){
               
                $this->session->set_flashdata('success', 'Scholarship Updated successfully');
            } else{
                $this->session->set_flashdata('error', 'Scholarship Updated failed');
            }   
       
        }
            redirect('editScholarship/'.$row_id);
        
    }
}
function addScholarshipType()
{
    if($this->isAdmin() == TRUE)
    {
        $this->loadThis();
    }  else {
            $scholarship_type =$this->security->xss_clean($this->input->post('scholarship_type'));
            
            $isExist = $this->scholarship->isScholarshipTypeAlreadyExist($scholarship_type);
            if(empty($isExist)){
                $religionInfo = array(
                    'scholarship_type'=>$scholarship_type,
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s')
                );
                $result = $this->scholarship->addScholarshipType($religionInfo);
                if($result > 0){
                    $this->session->set_flashdata('success', 'New Scholarship Type created successfully');
                } else{
                    $this->session->set_flashdata('error', 'Scholarship Type creation failed');
                }
            }else{
                $this->session->set_flashdata('error', 'Entered Details already Exist'); 
            }
            redirect('viewSettings');
        }
    
}

public function deleteScholarshipType(){
    if($this->isAdmin() == TRUE){
        $this->loadThis();
    } else {   
        $row_id = $this->input->post('row_id');
        $religionInfo = array('is_deleted' => 1,
        'updated_date_time' => date('Y-m-d H:i:s'),
        'updated_by' => $this->staff_id
        );
        $result = $this->scholarship->updateScholarshipType($religionInfo, $row_id);
        if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
    } 
}

function addScholarshipRecommendedBy()
{
    if($this->isAdmin() == TRUE)
    {
        $this->loadThis();
    }  else {
            $name =$this->security->xss_clean($this->input->post('name'));
            
            $isExist = $this->scholarship->isScholarshipRecommendedAlreadyExist($name);
            if(empty($isExist)){
                $religionInfo = array(
                    'name'=>$name,
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s')
                );
                $result = $this->scholarship->addRecommendedBy($religionInfo);
                if($result > 0){
                    $this->session->set_flashdata('success', 'New Recommended By created successfully');
                } else{
                    $this->session->set_flashdata('error', 'Recommended By creation failed');
                }
            }else{
                $this->session->set_flashdata('error', 'Entered Details already Exist'); 
            }
            redirect('viewSettings');
        }
    
}

public function deleteScholarshipRecommendedBy(){
    if($this->isAdmin() == TRUE){
        $this->loadThis();
    } else {   
        $row_id = $this->input->post('row_id');
        $religionInfo = array('is_deleted' => 1,
        'updated_date_time' => date('Y-m-d H:i:s'),
        'updated_by' => $this->staff_id
        );
        $result = $this->scholarship->updateScholarshipRecommendedBy($religionInfo, $row_id);
        if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
    } 
}
public function downloadScholarshipExcelReport(){
    if($this->isAdmin() == TRUE) {
        setcookie('isDownloading',0);
        $this->loadThis();
    } else {
        $scholarship_type = $this->security->xss_clean($this->input->post('scholarship_type'));
        $reportFormat = $this->security->xss_clean($this->input->post('reportFormat'));
        if($reportFormat == 'VIEW'){
            setcookie('isDownloading',0);
            error_reporting(0);
            $data['scholarship_type'] = $filter;
            $data['scholarship_type'] = $scholarship_type;
            // $data['year'] = $year;
            // $data['fee'] = $this->fee;
            // $data['student'] = $this->student;
            $data['scholarshipInfo'] = $this->scholarship->getScholarshipInfoForReportDownload($scholarship_type);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Scholarship';
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman']);
            $mpdf->AddPage('P','','','','',10,10,10,10,8,8);
            $mpdf->SetTitle('Scholarship');
            $html = $this->load->view('Scholarship/printScholarsipReport',$data,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('CAN.pdf', 'I');
        }else{
            
            $sheet = 0;
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('SCHOLARSHIP INFO');
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:N500');
            //set Title content with some text
            $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
            $this->excel->getActiveSheet()->setCellValue('A2', "Scholarship Info");
            // $this->excel->getActiveSheet()->setCellValue('A2', "Bijapur Mission- Vehicles");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:P1');
            $this->excel->getActiveSheet()->mergeCells('A2:P2');
            $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:P1')->getFont()->setBold(true);

            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(28);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(28);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(28);
            $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(20);


            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL. NO.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Application No.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Scholarship Code');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Society');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Term Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Scholarship Type');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('H3', 'Application Date');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('I3', 'Amount Requested');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('J3', 'Scholarship Amount');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('K3', 'Payment Date');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('L3', 'Debit A/C No.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('M3', 'Credit A/C No.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('N3', 'Recommended By');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('O3', 'Sanctioned By');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('P3', 'Remarks');
            


            $this->excel->getActiveSheet()->getStyle('A3:P3')->getAlignment()->setWrapText(true); 
            $this->excel->getActiveSheet()->getStyle('A3:P3')->getFont()->setBold(true); 
            $this->excel->getActiveSheet()->getStyle('A3:P3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:P3')->applyFromArray($styleBorderArray);
            $scholarshipInfo = $this->scholarship->getScholarshipInfoForReportDownload($scholarship_type);
            $j=1;
            $excel_row = 4;
            $total_amount_req = 0;
            $total_scholarship_amount = 0;
            foreach($scholarshipInfo as $scholarshipRecords){
                
                if($scholarshipRecords->application_date == '0000-00-00' || $scholarshipRecords->application_date == '1970-01-01' ){
                    $application_date = '';
                }
                else{
                    $application_date = date('d-m-Y',strtotime($scholarshipRecords->application_date));
                }

                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,$scholarshipRecords->student_row_id);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,$scholarshipRecords->application_number);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,$scholarshipRecords->scholarship_code);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,$scholarshipRecords->scholarship_society);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$scholarshipRecords->term_name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,$scholarshipRecords->scholarship_type);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row,date('d-m-Y', strtotime($application_date)));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row,number_format($scholarshipRecords->amount_requested,2));
                // $this->excel->getActiveSheet()->getStyle('I'.$excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row, number_format($scholarshipRecords->scholarship_amount, 2));
                // $this->excel->getActiveSheet()->getStyle('J'.$excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row,date('d-m-Y', strtotime($scholarshipRecords->payment_date)));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row,strtoupper($scholarshipRecords->debit_ac_no));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('M'.$excel_row,strtoupper($scholarshipRecords->credit_ac_no));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('N'.$excel_row,strtoupper($scholarshipRecords->recommended_by));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('O'.$excel_row,strtoupper($scholarshipRecords->sanctioned_by));
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('P'.$excel_row,$scholarshipRecords->remarks);
          
                $total_amount_req += $scholarshipRecords->amount_requested;
                $total_scholarship_amount += $scholarshipRecords->scholarship_amount;
                

                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':P'.$excel_row)->applyFromArray($styleBorderArray);
                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':B'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('D'.$excel_row.':P'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                // $this->excel->getActiveSheet()->getStyle(''.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
            }
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, 'TOTAL');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row, number_format($total_amount_req,2));
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row, number_format($total_scholarship_amount,2));
            $this->excel->getActiveSheet()->getStyle('H'.$excel_row.':J'.$excel_row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('H'.$excel_row.':J'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            $this->excel->createSheet(); 
            ob_clean();
            $filename= 'Scholarship_Report.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            ob_start();
            setcookie('isDownloading',0);
            $objWriter->save("php://output");   
            }
        
    }
}
}