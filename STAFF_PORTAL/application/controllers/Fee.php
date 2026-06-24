<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';
require APPPATH . '/third_party/encdec_paytm.php';

require APPPATH . '/third_party/easebuzz-lib/easebuzz_payment_gateway.php';

// require APPPATH . '/third_party/Kit/AWLMEAPI.php';
class Fee extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('fee_model','fee');
        $this->load->model('students_model','student');
        $this->load->model('account_model','account');
        $this->load->model('admission_model','admission');
        $this->load->model('application_model','application');
        $this->load->model('settings_model','settings');
        $this->load->library('pdf');
        $this->load->library('excel');
        $this->isLoggedIn();
    }
    
    public function viewFeeConcession(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {  
            $filter = array();
            $by_name = $this->security->xss_clean($this->input->post('by_name'));
            $amount = $this->security->xss_clean($this->input->post('amount'));
            $by_date = $this->security->xss_clean($this->input->post('by_date'));
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $data['con_year'] = $filter['con_year'] = $this->security->xss_clean($this->input->post('con_year'));
            $data['by_name'] = $by_name;
            $data['amount'] = $amount;
            $data['student_id'] = $student_id;
            $filter['student_id'] = $student_id;
            $filter['by_name'] = $by_name;
            $filter['amount'] = $amount;
            if(!empty($by_date)){
                $filter['by_date'] = date('Y-m-d',strtotime($by_date));
                $data['by_date'] = date('d-m-Y',strtotime($by_date));
            }else{
                $data['by_date'] = '';
            }
            $this->load->library('pagination');
            $count = $this->fee->getFeeConcessionCount($filter);
            $returns = $this->paginationCompress("viewFeeConcession/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['concessionInfo'] = $this->fee->getFeeConcessionInfo($filter);
            $data['studentInfoSelection'] = $this->student->getAllFirstYearStudent();
            $data['accessInfo'] = $this->getCurrentAccess();
            $data['feeYearInfo'] = $this->fee->getFeeYearInfo();
            // $data['firstYearStudentInfo'] = $this->admission->getFirstYearStudentsInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Fee Scholarship';
            $this->loadViews("feeConcession/concession.php", $this->global, $data, null);
        }
    }

    function getStudentByClassYear(){
        $year = $this->input->post('year');
        $year = (int)$year;
        $data['studentInfo'] = $this->student->getStudentByClassYear($year);
        header('Content-type: text/plain');
        header('Content-type: application/json'); 
        echo json_encode($data);
        exit(0);
    }

    public function getConcessionFeeLimit()
    {
        $student_row_id = $this->security->xss_clean($this->input->post('student_row_id'));
        $con_year = $this->security->xss_clean($this->input->post('con_year'));
        $row_id = $this->security->xss_clean($this->input->post('row_id'));
        if (empty($student_row_id) || empty($con_year)) {
            echo json_encode(array('status' => false, 'message' => 'Required data missing.'));
            exit(0);
        }
        $course_fee = (float)$this->fee->getCourseFeeLimitForConcession($student_row_id, $con_year);
        $pending_balance_raw = $this->fee->getLatestPendingBalanceForConcession($student_row_id, $con_year);
        $pending_balance = $pending_balance_raw === null ? null : (float)$pending_balance_raw;
        $effective_limit = $pending_balance === null ? $course_fee : min($course_fee, $pending_balance);
        $current_total = $this->fee->getStudentConcessionTotal($student_row_id, $con_year, $row_id);
        $remaining = (float)$effective_limit - (float)$current_total;
        echo json_encode(array(
            'status' => true,
            'course_fee' => (float)$course_fee,
            'pending_balance' => $pending_balance,
            'effective_limit' => (float)$effective_limit,
            'current_total' => (float)$current_total,
            'remaining' => $remaining > 0 ? (float)$remaining : 0
        ));
        exit(0);
    }
    
    // public function viewFeeConcessionNewAdmission(){
    //     if ($this->isAdmin() == true ) {
    //         $this->loadThis();
    //     } else {  
    //         $filter = array();
    //         $by_name = $this->security->xss_clean($this->input->post('by_name'));
    //         $amount = $this->security->xss_clean($this->input->post('amount'));
    //         $by_date = $this->security->xss_clean($this->input->post('by_date'));
    //         $application_no = $this->security->xss_clean($this->input->post('application_no'));
    //         $data['by_name'] = $by_name;
    //         $data['amount'] = $amount;
    //         $data['application_no'] = $application_no;
    //         $filter['application_no'] = $application_no;
    //         $filter['by_name'] = $by_name;
    //         $filter['amount'] = $amount;
    //         if(!empty($by_date)){
    //             $filter['by_date'] = date('Y-m-d',strtotime($by_date));
    //             $data['by_date'] = date('d-m-Y',strtotime($by_date));
    //         }else{
    //             $data['by_date'] = '';
    //         }
    //         $this->load->library('pagination');
    //         $count = $this->fee->getFeeConcessionNewAdmCount($filter);
    //         $returns = $this->paginationCompress("viewFeeConcessionNewAdmission/", $count, 100);
    //         $data['totalCount'] = $count;
    //         $filter['page'] = $returns["page"];
    //         $filter['segment'] = $returns["segment"];
    //         $data['concessionInfo'] = $this->fee->getFeeConcessionNewAdmInfo($filter);
    //         $data['studentInfo'] = $this->fee->getStudentNewApplicationForConcession();
    //         $this->global['pageTitle'] = ''.TAB_TITLE.' : New Adm Fee Concession';
    //         $this->loadViews("feeConcession/feeConcessionNewAdmission", $this->global, $data, null);
    //     }
    // }
    
    public function addConcession() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('application_no','Student ID','trim|required');
            $this->form_validation->set_rules('fee_amount','Amount','trim|required|numeric');
            if($this->form_validation->run() == FALSE) {
                $this->viewFeeConcession();
            } else {
                $application_no = $this->security->xss_clean($this->input->post('application_no'));
                $fee_amount = $this->security->xss_clean($this->input->post('fee_amount'));
                $description = $this->security->xss_clean($this->input->post('description'));
                $term = $this->security->xss_clean($this->input->post('term'));
                $date = $this->security->xss_clean($this->input->post('date'));
                $con_year = $this->security->xss_clean($this->input->post('con_year'));
                $course_fee = (float)$this->fee->getCourseFeeLimitForConcession($application_no, $con_year);
                $pending_balance_raw = $this->fee->getLatestPendingBalanceForConcession($application_no, $con_year);
                $pending_balance = $pending_balance_raw === null ? null : (float)$pending_balance_raw;
                $effective_limit = $pending_balance === null ? $course_fee : min($course_fee, $pending_balance);
                $current_total = $this->fee->getStudentConcessionTotal($application_no, $con_year);
                $allowed_amount = (float)$effective_limit - (float)$current_total;
                if ((float)$fee_amount > $allowed_amount) {
                    $this->session->set_flashdata('error', 'Scholarship amount exceeds allowed limit (lower of course fee and latest pending balance). Remaining allowed amount: '.number_format(max($allowed_amount, 0), 2));
                    redirect('viewFeeConcession');
                }
                $isExist = $this->fee->checkStudentIdExistsForConcession($application_no,$con_year);
                if(!empty($isExist)){
                    $this->session->set_flashdata('warning', 'Student Already Exists');
                    redirect('viewFeeConcession');
                }else{ 
                    $feeInfo = array(
                        'application_no'=>$application_no,
                        'fee_amt'=>$fee_amount,
                        'description'=>$description,
                        'date'=>date('Y-m-d H:i:s'), 
                        'approved_status'=>0,
                        'year' => $con_year,
                        // 'term_name' => $term,
                        'created_by'=>$this->staff_id,
                        'created_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->fee->addConcession($feeInfo);
                    if($result > 0){
                        $this->session->set_flashdata('success', 'Scholarship  Added successfully');
                    } else{
                        $this->session->set_flashdata('error', 'Failed to Add Scholarship ');
                    }
                }
                redirect('viewFeeConcession');
            }
        }
    } 
    
    public function editConcession($row_id = null){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            if ($row_id == NULL) {
                redirect('viewFeeStructure');
            }
            $data['feeInfo'] = $this->fee->getFeeConcessionById($row_id);
            $data['studentInfo'] = $this->student->getStudentInfoForConcession();
            $data['feeYearInfo'] = $this->fee->getFeeYearInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Update Scholarship ';
            $this->loadViews("feeConcession/editConcession", $this->global, $data, null);
        }
    }

    public function updateConcession() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $row_id = $this->input->post('row_id');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('application_no','Student ID','trim|required');
            $this->form_validation->set_rules('fee_amount','Amount','trim|required|numeric');
            if($this->form_validation->run() == FALSE) {
                redirect('editConcession/'.$row_id);
            } else {
                $application_no = $this->security->xss_clean($this->input->post('application_no'));
                $fee_amount = $this->security->xss_clean($this->input->post('fee_amount'));
                $description = $this->security->xss_clean($this->input->post('description'));
                $term_name = $this->security->xss_clean($this->input->post('term_name'));
                $con_year = $this->security->xss_clean($this->input->post('con_year'));
                $course_fee = (float)$this->fee->getCourseFeeLimitForConcession($application_no, $con_year);
                $pending_balance_raw = $this->fee->getLatestPendingBalanceForConcession($application_no, $con_year);
                $pending_balance = $pending_balance_raw === null ? null : (float)$pending_balance_raw;
                $effective_limit = $pending_balance === null ? $course_fee : min($course_fee, $pending_balance);
                $current_total = $this->fee->getStudentConcessionTotal($application_no, $con_year, $row_id);
                $allowed_amount = (float)$effective_limit - (float)$current_total;
                if ((float)$fee_amount > $allowed_amount) {
                    $this->session->set_flashdata('error', 'Scholarship amount exceeds allowed limit (lower of course fee and latest pending balance). Remaining allowed amount: '.number_format(max($allowed_amount, 0), 2));
                    redirect('editConcession/'.$row_id);
                }
                $feeInfo = array(
                    'application_no'=>$application_no,
                    'fee_amt'=>$fee_amount,
                    //  'date'=>date('Y-m-d H:i:s'), 
                    //  'term_name'=>$term_name,
                    'year'=>$con_year,
                    'description'=>$description,
                    'updated_by'=>$this->staff_id,
                    'updated_date_time'=>date('Y-m-d H:i:s'));
                $result = $this->fee->updateConcession($feeInfo,$row_id);
                if($result > 0){
                    $this->session->set_flashdata('success', 'Scholarship  Updated successfully');
                } else{
                    $this->session->set_flashdata('error', 'Failed to Update Scholarship ');
                }
                redirect('editConcession/'.$row_id);
            }
        }
    }
    
    public function deleteConcession(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $feeInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id);
            $result = $this->fee->updateConcession($feeInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function approveConcession(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $feeInfo = array('approved_status' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id);
            $result = $this->fee->updateConcession($feeInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
    
    public function rejectConcession(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $feeInfo = array('approved_status' => 2,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id);
            $result = $this->fee->fee->updateConcession($feeInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    //fee payment proceed in portal
    public function newAdmissionFeePayNow(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $data['fee_pending_status'] = false;
        // $data['studentInfoSelection'] = $this->student->getAllStudentsInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Pay Now';
            $this->loadViews("admission/feePaymentPortal", $this->global, $data, null);
        }
    }


    public function feeInstallmentListing(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {  
            $filter = array();
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $student_name = $this->security->xss_clean($this->input->post('student_name'));
            $amount = $this->security->xss_clean($this->input->post('amount'));
            $last_date = $this->security->xss_clean($this->input->post('last_date'));
            $year= $this->security->xss_clean($this->input->post('year'));
            $data['student_id'] = $student_id;
            $data['student_name'] = $student_name;
            $data['amount'] = $amount;
            $data['year'] = $year;
            $filter['student_id'] = $student_id;
            $filter['student_name'] = $student_name;
            $filter['amount'] = $amount;
            $filter['year'] = $year;
            if(!empty($last_date)){
                $filter['last_date'] = date('Y-m-d',strtotime($last_date));
                $data['last_date'] = date('d-m-Y',strtotime($last_date));
            }else{
                $data['last_date'] = '';
            }
            $this->load->library('pagination');
            $count = $this->fee->getFeeInstallmentCount($filter);
            $returns = $this->paginationCompress("feeInstallmentListing/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['installmentInfo'] = $this->fee->getAllFeeInstallmentInfo($filter, $returns["page"], $returns["segment"]);
            $data['studentInfo'] = $this->student->getAllStudentsInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Fee Installment';
            $this->loadViews("feeInstallment/installment", $this->global, $data, null);
        }
    }

    public function addFeeInstallment() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('application_no','Student ID','trim|required');
            $this->form_validation->set_rules('amount','Amount','trim|required|numeric');
            $this->form_validation->set_rules('last_date','Last Date For Payment','trim|required');
            if($this->form_validation->run() == FALSE) {
                $this->feeInstallmentListing();
            } else {
                $application_no = $this->security->xss_clean($this->input->post('application_no'));
                $last_date = $this->security->xss_clean($this->input->post('last_date'));
                $amount = $this->security->xss_clean($this->input->post('amount'));
                $remarks = $this->security->xss_clean($this->input->post('remarks'));
                $year = $this->security->xss_clean($this->input->post('year'));
                $installmentInfo = array(
                    'application_no'=>$application_no,
                    'amount'=>$amount,
                    'last_date' => date('Y-m-d',strtotime($last_date)),
                    'created_by'=>$this->staff_id,
                    'remarks'=>$remarks,
                    'year' => $year,
                    'created_date_time'=>date('Y-m-d H:i:s'));
                $result = $this->fee->addFeeInstallment($installmentInfo);
                if($result > 0){
                    $this->session->set_flashdata('success', 'Fee Instalment added successfully');
                } else{
                    $this->session->set_flashdata('error', 'Failed to Add Fee Instalment');
                }
                redirect('feeInstallmentListing');
            }
        }
    }

    public function editFeeInstallment($row_id = null){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            if ($row_id == NULL) {
                redirect('feeInstallmentListing');
            }
            $data['installmentInfo'] = $this->fee->getFeeInstallmentById($row_id);
            // $data['studentInfo'] = $this->student->getstudentInfo();
            $data['studentInfo'] =$this->student->getAllStudentsInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Update Fee Instalment';
            $this->loadViews("feeInstallment/editFeeInstallment", $this->global, $data, null);
        }
    }

    public function updateFeeInstallment() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $row_id = $this->input->post('row_id');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('application_no','Student ID','trim|required');
            $this->form_validation->set_rules('amount','Amount','trim|required|numeric');
            $this->form_validation->set_rules('last_date','Last Date For Payment','trim|required');
            if($this->form_validation->run() == FALSE) {
                redirect('editFeeInstallment/'.$row_id);
            } else {
                $application_no = $this->security->xss_clean($this->input->post('application_no'));
                $last_date = $this->security->xss_clean($this->input->post('last_date'));
                $amount = $this->security->xss_clean($this->input->post('amount'));
                $remarks = $this->security->xss_clean($this->input->post('remarks'));
                $year = $this->security->xss_clean($this->input->post('year'));
                $installmentInfo = array(
                    'application_no'=>$application_no,
                    'amount'=>$amount,
                    'last_date' => date('Y-m-d',strtotime($last_date)),
                    'remarks'=>$remarks,
                    'year' => $year,
                    'updated_by'=>$this->staff_id,
                    'updated_date_time'=>date('Y-m-d H:i:s'));
                $result = $this->fee->updateFeeInstallment($installmentInfo,$row_id);
                if($result > 0){
                    $this->session->set_flashdata('success', 'Fee Instalment Updated successfully');
                } else{
                    $this->session->set_flashdata('error', 'Failed to Update Fee Instalment');
                }
                redirect('editFeeInstallment/'.$row_id);
            }
        }
    }

    public function deleteFeeInstallment(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $installmentInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id);
            $result = $this->fee->updateFeeInstallment($installmentInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
    
    function getAllFeePaymentInfo()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
            $filter = array();
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $student_name = $this->security->xss_clean($this->input->post('student_name'));
            $application_no = $this->security->xss_clean($this->input->post('application_no'));
            $date_select = $this->security->xss_clean($this->input->post('date_select'));
            $receipt_number = $this->security->xss_clean($this->input->post('receipt_number'));
            $amount_paid = $this->security->xss_clean($this->input->post('amount_paid'));
            $amount_pending = $this->security->xss_clean($this->input->post('amount_pending'));
            $reference_number = $this->security->xss_clean($this->input->post('reference_number'));
            $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
            $fee_type = $this->security->xss_clean($this->input->post('fee_type'));
            $bank_settlement = $this->security->xss_clean($this->input->post('bank_settlement'));
            $by_bank_date = $this->security->xss_clean($this->input->post('by_bank_date'));
            $year = $this->security->xss_clean($this->input->post('year'));
            $created_by = $this->security->xss_clean($this->input->post('created_by'));
            $created_date_time = $this->security->xss_clean($this->input->post('created_date_time'));
            $by_term = $this->security->xss_clean($this->input->post('by_term'));
            $searchText = "";
            if(empty($year)){
                $data['year'] = FEE_YEAR;
                $filter['year'] = FEE_YEAR;
            }else{
                $data['year'] = $intake_year;
                $filter['year'] = $intake_year;
            }
            // $data['year'] = $filter['by_year'] = $year;
            $data['by_term'] = $filter['by_term'] = $by_term;
            if(!empty($application_no)){
                $filter['application_no'] = $application_no;
                $data['application_no'] = $application_no;
            }else{
                $data['application_no'] = '';
            }
            if(!empty($student_id)){
                $filter['student_id'] = $student_id;
                $data['student_id'] = $student_id;
            }else{
                $data['student_id'] = '';
            }
            if(!empty($student_name)){
                $filter['student_name'] = $student_name;
                $data['student_name'] = $student_name;
            }else{
                $data['student_name'] = '';
            }
            if(!empty($date_select)){
                $filter['date_select'] = date('Y-m-d',strtotime($date_select));
                $data['date_select'] = date('d-m-Y',strtotime($date_select));;
            }else{
                $data['date_select'] = '';
            }
            if(!empty($receipt_number)){
                $filter['receipt_number'] = $receipt_number;
                $data['receipt_number'] = $receipt_number;
            }else{
                $data['receipt_number'] = '';
            }
            if(!empty($amount_paid)){
                $filter['amount_paid'] = $amount_paid;
                $data['amount_paid'] = $amount_paid;
            }else{
                $data['amount_paid'] = '';
            }
            if(!empty($amount_pending)){
                $filter['amount_pending'] = $amount_pending;
                $data['amount_pending'] = $amount_pending;
            }else{
                $data['amount_pending'] = '';
            } 
            if(!empty($reference_number)){
                $filter['order_id'] = $reference_number;
                $data['order_id'] = $reference_number;
            }else{
                $data['order_id'] = '';
            } 
            if(!empty($payment_type)){
                $filter['payment_type'] = $payment_type;
                $data['payment_type'] = $payment_type;
            }else{
                $data['payment_type'] = '';
            } 
            if($bank_settlement == 'Pending'){
                $filter['bank_settlement'] = 'Pending';;
                $data['bank_settlement'] = 'Pending';
            }else if($bank_settlement == 'Settled'){
                $data['bank_settlement'] = 'Settled';
                $filter['bank_settlement'] = 'Settled';
            }else{
                $data['bank_settlement'] = 'Settled';
                $filter['bank_settlement'] = 1;
            }
            if(!empty($by_bank_date)){
                $filter['by_bank_date'] = date('Y-m-d',strtotime($by_bank_date));
                $data['by_bank_date'] = date('d-m-Y',strtotime($by_bank_date));;
            }else{
                $data['by_bank_date'] = '';
            }
            if(!empty($created_date_time)){
                $filter['created_date_time'] = date('Y-m-d',strtotime($created_date_time));
                $data['created_date_time'] = date('d-m-Y',strtotime($created_date_time));
            }else{
                $data['created_date_time'] = '';
            }
            $data['created_by'] = $created_by;
            $filter['created_by'] = $created_by;
            $this->load->library('pagination');
            $count = $this->fee->getAllFeePaymentInfoCount($filter);
            $returns = $this->paginationCompress("onlinePaymentInfo/", $count, 100 );
            $data['online_pay_count'] = $count;
            $data['feePaidInfo'] = $this->fee->getAllFeePaymentInfo( $returns["page"], $returns["segment"], $filter);
            // $data['feePaidStdInfo'] = $this->account->getFeePaidStudentInfo();
            // log_message('debug','jbcdbc'.print_r($data['onlineFeeInfo'],true));
            $data['accessInfo'] = $this->getCurrentAccess();
            $this->global['pageTitle'] = ''.TAB_TITLE.' :Fee Paid Details';
            $data['orderIDInfo'] = $this->fee->getReAdmUnProcessedOrderID();
            $data['neworderIDInfo'] = $this->fee->getNewAdmUnProcessedOrderID();
            $data['feeYearInfo'] = $this->fee->getFeeYearInfo();
            $data['accessInfo'] = $this->getCurrentAccess();
            $this->loadViews("fees/getAllFeePaymentInfo", $this->global, $data, NULL);
        }
    }
    
    function getAllFeePaymentInfoNewAdm()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
            $filter = array();
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $application_no = $this->security->xss_clean($this->input->post('application_no'));
            $date_select = $this->security->xss_clean($this->input->post('date_select'));
            $receipt_number = $this->security->xss_clean($this->input->post('receipt_number'));
            $amount_paid = $this->security->xss_clean($this->input->post('amount_paid'));
            $amount_pending = $this->security->xss_clean($this->input->post('amount_pending'));
            $reference_number = $this->security->xss_clean($this->input->post('reference_number'));
            $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
            $bank_settlement = $this->security->xss_clean($this->input->post('bank_settlement'));
            $by_bank_date = $this->security->xss_clean($this->input->post('by_bank_date'));
            $searchText = "";
            if(!empty($application_no)){
                $filter['application_no'] = $application_no;
                $data['application_no'] = $application_no;
            }else{
                $data['application_no'] = '';
            }
            if(!empty($student_id)){
                $filter['student_id'] = $student_id;
                $data['student_id'] = $student_id;
            }else{
                $data['student_id'] = '';
            }
            if(!empty($date_select)){
                $filter['date_select'] = date('Y-m-d',strtotime($date_select));
                $data['date_select'] = date('d-m-Y',strtotime($date_select));;
            }else{
                $data['date_select'] = '';
            }
            if(!empty($receipt_number)){
                $filter['receipt_number'] = $receipt_number;
                $data['receipt_number'] = $receipt_number;
            }else{
                $data['receipt_number'] = '';
            }
            if(!empty($amount_paid)){
                $filter['amount_paid'] = $amount_paid;
                $data['amount_paid'] = $amount_paid;
            }else{
                $data['amount_paid'] = '';
            }
            if(!empty($amount_pending)){
                $filter['amount_pending'] = $amount_pending;
                $data['amount_pending'] = $amount_pending;
            }else{
                $data['amount_pending'] = '';
            } 
            if(!empty($reference_number)){
                $filter['order_id'] = $reference_number;
                $data['order_id'] = $reference_number;
            }else{
                $data['order_id'] = '';
            } 
            if(!empty($payment_type)){
                $filter['payment_type'] = $payment_type;
                $data['payment_type'] = $payment_type;
            }else{
                $data['payment_type'] = '';
            } 
            if($bank_settlement == 'Pending'){
                $filter['bank_settlement'] = 'Pending';;
                $data['bank_settlement'] = 'Pending';
            }else if($bank_settlement == 'Settled'){
                $data['bank_settlement'] = 'Settled';
                $filter['bank_settlement'] = 'Settled';
            }else{
                $data['bank_settlement'] = 'Settled';
                $filter['bank_settlement'] = 1;
            }
            if(!empty($by_bank_date)){
                $filter['by_bank_date'] = date('Y-m-d',strtotime($by_bank_date));
                $data['by_bank_date'] = date('d-m-Y',strtotime($by_bank_date));;
            }else{
                $data['by_bank_date'] = '';
            }
            $this->load->library('pagination');
            $count = $this->fee->getAllFeePaymentInfoCountNewAdm($filter);
            $returns = $this->paginationCompress("getAllFeePaymentInfoNewAdm/", $count, 100 );
            $data['online_pay_count'] = $count;
            $data['feePaidInfo'] = $this->fee->getAllFeePaymentInfoNewAdm( $returns["page"], $returns["segment"], $filter);
            // $data['process'] = $this->fee->getAllFeePaymentInfoNewAdmPROCESS();
            // foreach($data['process'] as $p){
            //     $applicationStatus = array(
            //         'joined_status' => 1,
            //         'admission_status'=> 1,
            //         'updated_date_time' => date('Y-m-d H:i:s'));
            //    $this->admission->updateStudentApplicationStatus($p->application_no,$applicationStatus);
            // }
            // $data['feePaidStdInfo'] = $this->account->getFeePaidStudentInfo();
            // log_message('debug','jbcdbc'.print_r($data['onlineFeeInfo'],true));
            $this->global['pageTitle'] = ''.TAB_TITLE.' :Fee Paid Details';
            $this->loadViews("fees/newAdmFeePaidInfo21", $this->global, $data, NULL);
        }
    }

    public function addGovtBankSettlementSubmit(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $date = $this->input->post('date');
            $receipt_number = json_decode(stripslashes($this->input->post('receipt_number')));
            foreach($receipt_number as $row_id){            
                $feePaidInfo = array(
                    'bank_settlement_date' => date('Y-m-d',strtotime($date)),
                    'bank_settlement_status' => 1,
                    'updated_by'=>$this->staff_id,
                    'updated_date_time'=>date('Y-m-d H:i:s'));
                $return =  $this->fee->updateGovtFeeSettleStatus($feePaidInfo, $row_id);
            }
            if($return){
                echo "success";
                exit;
            }else{
                echo "error";
                exit;
            }
        } 
    }

    public function addBankSettlementSubmitNewAdm(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $date = $this->input->post('date');
            $receipt_number = json_decode(stripslashes($this->input->post('receipt_number')));
            foreach($receipt_number as $receipt){
                $isExist = $this->account->getBankSettlementByReceiptNoNewAdm($receipt);
                if(empty($isExist)){
                    $settleInfo = array(
                        'date' => date('Y-m-d',strtotime($date)),
                        'receipt_number' => $receipt,
                        'created_by'=>$this->staff_id,
                        'created_date_time'=>date('Y-m-d H:i:s'));
                    $return_id = $this->account->addBankSettlementNewAdm($settleInfo);
                }else{
                    $settleInfo = array(
                        'date' => date('Y-m-d',strtotime($date)),
                        'receipt_number' => $receipt,
                        'updated_by'=>$this->staff_id,
                        'is_deleted' => 0,
                        'updated_date_time'=>date('Y-m-d H:i:s'));
                    $return_id = $this->account->updateBankSettlementNewAdm($settleInfo, $receipt);
                }
                $feePaidInfo = array(
                    'receipt_number' => $receipt,
                    'bank_settlement_status' => 1,
                    'updated_by'=>$this->staff_id,
                    'updated_date_time'=>date('Y-m-d H:i:s'));
                $return =  $this->account->updatefeeSettleStatusNewAdm2021($feePaidInfo, $receipt);
            }
            if($return_id > 0){
                echo "success";
                exit;
            }else{
                echo "error";
                exit;
            }
        } 
    }

    public function addBankSettlementSubmit(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $date = $this->input->post('date');
            // log_message('debug','date'.$date);
            $receipt_number = json_decode(stripslashes($this->input->post('receipt_number')));
            foreach($receipt_number as $receipt){            
                $feePaidInfo = array(
                    'bank_settlement_date' => date('Y-m-d',strtotime($date)),
                    'bank_settlement_status' => 1,
                    'updated_by'=>$this->staff_id,
                    'updated_date_time'=>date('Y-m-d H:i:s'));
                $return =  $this->fee->updatefeeSettleStatus($feePaidInfo, $receipt);
            }
            if($return){
                echo "success";
                exit;
            }else{
                echo "error";
                exit;
            }
        } 
    }

    public function addMiscellneousBankSettlementSubmit(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $date = $this->input->post('date');

            $receipt_number = json_decode(stripslashes($this->input->post('receipt_number')));
            // log_message('debug','receipt'.$receipt_number);
            foreach($receipt_number as $receipt){            
                $feePaidInfo = array(
                    'bank_settlement_date' => date('Y-m-d',strtotime($date)),
                    'bank_settlement_status' => 1,
                    'updated_by'=>$this->staff_id,
                    'updated_date_time'=>date('Y-m-d H:i:s'));
                $return =  $this->fee->updateMiscFeeSettleStatus($feePaidInfo, $receipt);
            }
            if($return){
                echo "success";
                exit;
            }else{
                echo "error";
                exit;
            }
        } 
    }

    function govtfeePaidInfo()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
            $filter = array();
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $date_select = $this->security->xss_clean($this->input->post('date_select'));
            $receipt_number = $this->security->xss_clean($this->input->post('receipt_number'));
            $amount_paid = $this->security->xss_clean($this->input->post('amount_paid'));
            $amount_pending = $this->security->xss_clean($this->input->post('amount_pending'));
            $reference_number = $this->security->xss_clean($this->input->post('reference_number'));
            $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
            $bank_settlement = $this->security->xss_clean($this->input->post('bank_settlement'));
            $by_bank_date = $this->security->xss_clean($this->input->post('by_bank_date'));
            $student_name = $this->security->xss_clean($this->input->post('student_name'));
            $created_by = $this->security->xss_clean($this->input->post('created_by'));
            $created_date_time = $this->security->xss_clean($this->input->post('created_date_time'));
            $filter['by_type'] = $data['by_type'] = $type = $this->input->post('by_type');
            $filter['by_term'] = $data['by_term'] = $by_term = $this->input->post('by_term');
            $data['year'] = $filter['by_year'] = $this->security->xss_clean($this->input->post('by_year'));
            $data['created_by'] = $created_by;
            $filter['created_by'] = $created_by;
            if(empty($type)){
                $filter['by_type'] = $data['by_type'] = 'Processed';
            }
            
            $searchText = "";
            if(!empty($student_id)){
                $filter['student_id'] = $student_id;
                $data['student_id'] = $student_id;
            }else{
                $data['student_id'] = '';
            }
            if(!empty($date_select)){
                $filter['date_select'] = date('Y-m-d',strtotime($date_select));
                $data['date_select'] = date('d-m-Y',strtotime($date_select));
            }else{
                $data['date_select'] = '';
            }
            if(!empty($receipt_number)){
                $filter['receipt_number'] = $receipt_number;
                $data['receipt_number'] = $receipt_number;
            }else{
                $data['receipt_number'] = '';
            }
            if(!empty($amount_paid)){
                $filter['amount_paid'] = $amount_paid;
                $data['amount_paid'] = $amount_paid;
            }else{
                $data['amount_paid'] = '';
            }
            if(!empty($amount_pending)){
                $filter['amount_pending'] = $amount_pending;
                $data['amount_pending'] = $amount_pending;
            }else{
                $data['amount_pending'] = '';
            } 
            if(!empty($reference_number)){
                $filter['order_id'] = $reference_number;
                $data['order_id'] = $reference_number;
            }else{
                $data['order_id'] = '';
            } 
            if(!empty($payment_type)){
                $filter['payment_type'] = $payment_type;
                $data['payment_type'] = $payment_type;
            }else{
                $data['payment_type'] = '';
            } 
            if($bank_settlement == 'Pending'){
                $filter['bank_settlement'] = 'Pending';
                $data['bank_settlement'] = 'Pending';
            }else if($bank_settlement == 'Settled'){
                $data['bank_settlement'] = 'Settled';
                $filter['bank_settlement'] = 'Settled';
            }else{
                $data['bank_settlement'] = 'Settled';
                $filter['bank_settlement'] = 1;
            }
            if(!empty($created_date_time)){
                $filter['created_date_time'] = date('Y-m-d',strtotime($created_date_time));
                $data['created_date_time'] = date('d-m-Y',strtotime($created_date_time));
            }else{
                $data['created_date_time'] = '';
            }
            // log_message('debug','fff=='.$filter['bank_settlement']);
            
            if(!empty($by_bank_date)){
                $filter['by_bank_date'] = date('Y-m-d',strtotime($by_bank_date));
                $data['by_bank_date'] = date('d-m-Y',strtotime($by_bank_date));
            }else{
                $data['by_bank_date'] = '';
            }
            if(!empty($student_name)){
                $filter['student_name'] = $student_name;
                $data['student_name'] = $student_name;
            }else{
                $data['student_name'] = '';
            }
            
            $this->load->library('pagination');
            $count = $this->fee->getGovtFeePaymentInfoCount($filter);
            $returns = $this->paginationCompress("govtfeePaidInfo/", $count, 100 );
            $data['online_pay_count'] = $count;
            $data['onlineFeeInfo'] = $this->fee->getGovtFeePaymentInfo( $returns["page"], $returns["segment"], $filter);
            $this->global['pageTitle'] = ''.TAB_TITLE.' :Online Fee Paid Details';
            $this->loadViews("fees/govtPaymentInfo", $this->global, $data, NULL);
        }
    }

    
    // management fee
    public function viewManagementFeeInfo(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {  
            $filter = array();
            $by_name = $this->security->xss_clean($this->input->post('by_name'));
            $amount = $this->security->xss_clean($this->input->post('amount'));
            $by_date = $this->security->xss_clean($this->input->post('by_date'));
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $order_id = $this->security->xss_clean($this->input->post('order_id'));
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));

            $data['by_name'] = $by_name;
            $data['amount'] = $amount;
            $data['student_id'] = $student_id;
            $data['order_id'] = $order_id;
            $data['stream_name'] = $stream_name;

            $filter['student_id'] = $student_id;
            $filter['by_name'] = $by_name;
            $filter['amount'] = $amount;
            $filter['order_id'] = $order_id;
            $filter['stream_name'] = $stream_name;

            if(!empty($by_date)){
                $filter['by_date'] = date('Y-m-d',strtotime($by_date));
                $data['by_date'] = date('d-m-Y',strtotime($by_date));
            }else{
                $data['by_date'] = '';
            }
            
            $this->load->library('pagination');
            $count = $this->fee->getStdMngtFeeInfoInfoCount($filter);
            $returns = $this->paginationCompress("viewManagementFeeInfo/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['mngtFeeInfo'] = $this->fee->getStdMngtFeeInfoInfo($filter);
            $data['studentInfo'] = $this->student->getAllFirstYearStudent();
            $data['mngtfeeSum'] = $this->fee->getSumOfManagementFee();
            $data['streamInfo'] = $this->student->getAllStreamName();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Management Fee';
            $this->loadViews("fees/mngtFeeInfo", $this->global, $data, null);
        }
    }

    public function addManagementFeeInfo() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('application_no','Student ID','trim|required');
            $this->form_validation->set_rules('feeDate','Date','trim|required');
            $this->form_validation->set_rules('fee_amount','Amount','trim|required|greater_than_equal_to[1]|less_than_equal_to[5000]');

            if($this->form_validation->run() == FALSE) {
                $this->viewManagementFeeInfo();
            } else {
                $application_no = $this->security->xss_clean($this->input->post('application_no'));
                $fee_amount = $this->security->xss_clean($this->input->post('fee_amount'));;
                $feeDate = $this->security->xss_clean($this->input->post('feeDate'));
                // $description = $this->security->xss_clean($this->input->post('description'));

                $isExist = $this->fee->checkStudentForMngtFeeExists($application_no); 
                if($isExist > 0){
                    $this->session->set_flashdata('warning', 'Student already exist');
                    redirect('viewManagementFeeInfo');
                }else{
                    $fee_date = date('Y-m-d',strtotime($feeDate));
                    $feeInfo = array(
                        'application_no' => $application_no,
                        'amount' => $fee_amount,
                        'date' => $fee_date,
                        'created_by'=>$this->staff_id,
                        'created_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->fee->addStudentMngtFee($feeInfo);
                }
               
                if($result > 0){
                    $this->session->set_flashdata('success', 'Management Fee Added successfully');
                } else{
                    $this->session->set_flashdata('error', 'Failed to Add Management Fee');
                }
                redirect('viewManagementFeeInfo');
            }
        }
    } 
     
    public function editMngtFee($row_id = null){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            if ($row_id == NULL) {
                redirect('viewFeeStructure');
            }
            $data['feeInfo'] = $this->fee->getStudentManagementFeeInfoById($row_id);
            $data['studentInfo'] = $this->student->getAllFirstYearStudent();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit Management Fee';
            $this->loadViews("fees/editMngtFee", $this->global, $data, null);
        }
    }

    public function updateMngtFee() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $row_id = $this->input->post('row_id');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('application_no','Student ID','trim|required');
            $this->form_validation->set_rules('fee_amount','Amount','trim|required|greater_than_equal_to[1]|less_than_equal_to[5000]');

            if($this->form_validation->run() == FALSE) {
                redirect('editMngtFee/'.$row_id);
            } else {
                $application_no = $this->security->xss_clean($this->input->post('application_no'));
                $fee_amount = $this->security->xss_clean($this->input->post('fee_amount'));;
                $feeDate = $this->security->xss_clean($this->input->post('feeDate'));

                $isExist = $this->fee->checkStudentForMngtFeeExists($application_no,$row_id); 
                if($isExist > 0){
                    $this->session->set_flashdata('warning', 'Student already exist');
                    redirect('viewManagementFeeInfo');
                }else{
                    $feeInfo = array(
                        'application_no' => $application_no,
                        'amount' => $fee_amount,
                        'date' => date('Y-m-d',strtotime($feeDate)),
                        'updated_by'=>$this->staff_id,
                        'updated_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->fee->updateManagementFee($feeInfo,$row_id);
                }

                if($result > 0){
                    $this->session->set_flashdata('success', 'Management Fee Updated successfully');
                } else{
                    $this->session->set_flashdata('error', 'Failed to Update Management Fee');
                }
                redirect('editMngtFee/'.$row_id);
            }
        }
    }

    public function deleteMngtFee(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $feeInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id);
            $result = $this->fee->updateManagementFee($feeInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function printMngtFeeReceipt($row_id){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $filter = array();

            $this->global['pageTitle'] = ''.TAB_TITLE.' : Fee Receipt';
            $data['feeInfo'] = $this->fee->getStudentManagementFeeInfoById($row_id);
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman', 'format' => [130, 140]]);
            $mpdf->AddPage('L','','','','',10,10,10,10,8,8);
            $mpdf->SetTitle('Fee Receipt');
            $html = $this->load->view('fees/printMngtFeeReceipt',$data,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('Fee_Receipt.pdf', 'I');
        } 
    }



    public function download_II_PUC_StudentFeePaidReport(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $filter = array();
            $student = $this->security->xss_clean($this->input->post('by_student'));

            //$by_sslc_board = $this->security->xss_clean($this->input->post('by_board'));
        // $generation_type = $this->security->xss_clean($this->input->post('generation_type'));
            $elective_sub = $this->security->xss_clean($this->input->post('elective_sub'));
            $paid_type = $this->security->xss_clean($this->input->post('payment_type'));
            $stream = array(
                'PCMB',
                'PCMC',
                'CEBA',
                'HEBA',
                'SEBA',
                'HESP'
            );
            $cellNameByStudentReport = array('G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        // $filter['bank_settlement'] = $bank_settlement;
            for($sheet = 0; $sheet < count($stream);  $sheet++){
                $this->excel->setActiveSheetIndex($sheet);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle($stream[$sheet]);
                $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:L500');
                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                $this->excel->getActiveSheet()->setCellValue('A2', 'Fee Paid - '.$stream[$sheet]. " Fee Paid Report 2020-21");
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                
                $excel_row = 3;
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, 'SL No.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, 'Application No.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, 'Student ID');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, 'Name');

                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, 'Elective');

                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, 'Total Fee');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, 'Paid Amt');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, 'Pending Amt');
            // $filter['report_type']= $report_type;
                $filter['stream_name']= $stream[$sheet];
            // $filter['by_sslc_board']= $by_sslc_board;

                $filter['paid_type']= $paid_type;
            
                $filter['generation_type']= $generation_type;
                $filter['elective_sub']= $elective_sub;
                $sl = 1;
                $excel_row = 4;
                $studentInfo = $this->fee->downloadAdmittedStudentFeePaidReport($filter);
                    foreach($studentInfo as $std){
                        $filter['stream_name'] = $std->stream_name;
                        $filter['term_name'] = 'II';
                        if(strtoupper($std->elective_sub) == 'FRENCH'){
                            $filter['lang_fee_status'] = true;
                        }else{
                            $filter['lang_fee_status'] = false;
                        }
                        // $total_fee_obj = $this->admission->getTotalFeeAmount($filter);
                        $total_fee_amount = $total_fee_obj->total_fee;
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, $sl++);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, $std->application_no);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, $std->student_id);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, $std->student_name);
                    
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, $std->elective_sub);

                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, $total_fee_amount);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, $std->paid_amount);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, $std->pending_balance);
                        $excel_row++;
                    }
                    $this->excel->createSheet(); 
                }
                
            }
            
            $filename = 'II_PUC_Fee_Paid_Report_-'.date('d-m-Y').'.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
                        
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            ob_start();
            $objWriter->save("php://output");
            
    }

    // get student data based on term
    public function getStudentInfoByTermForFee(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $term_name = $this->input->post("term_name");
            $filter['term_name'] = $term_name;
            $data['result'] = $this->admission->getStudentDetailsForFeePayment($filter);
            header('Content-type: text/plain'); 
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        }
    }


    // re-admission order id process
    // public function reAdmissionOrderIdProcess(){
    //     $paytmChecksum = "";
    //     $paramList = array();
    //     $isValidChecksum = "FALSE";
    //     $order_id = $this->security->xss_clean($this->input->post('order_id'));
    //     $order_id = strtoupper($order_id);
    //     $paytmInfo = $this->fee->getReadmissionPayTmLogByAppNo($order_id);
    //     if(!empty($paytmInfo)){
           
    //         $application_no = $paytmInfo->student_id;
    //         $studentInfo = $this->student->getStudentsInfoByApplicationNumber($application_no);

    //         $requestParamList = array("MID" => PAYTM_MERCHANT_MID , "ORDERID" => $order_id);  

    //         // $paid_fee_amount = 15000;
    //         $filter = array();
    //         $filter['stream_name'] = $studentInfo->stream_name;
    //         $filter['term_name'] = $studentInfo->term_name;
    //         $filter['fee_year'] = CURRENT_YEAR;
    //         if(strtoupper($studentInfo->elective_sub) == 'FRENCH'){
    //             $filter['lang_fee_status'] = true;
    //         }else{
    //             $filter['lang_fee_status'] = false;
    //         }
    //        // $catInfo = $this->admission_model->getStudentCategoryByApplicationNum($studentInfo->application_no);
    //         $filter['category'] = strtoupper($studentInfo->category);
           
           
    //         $totalFeeObj = $this->fee->getTotalFeeAmount($filter);
    //         $feeStructureInfo = $this->fee->getFeeStructureInfo2021($filter);
    //         $total_fee_pending_to_pay = $totalFeeObj->total_fee;
           
          
    //         $StatusCheckSum = getChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY);
            
    //         $requestParamList['CHECKSUMHASH'] = $StatusCheckSum;
    
    //         // Call the PG's getTxnStatusNew() function for verifying the transaction status.
    //         $_POST = getTxnStatusNew($requestParamList);
          
                
    //         $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
    //         $data['application_applied_status'] = false;
    //         //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
    //         $isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.
    //         $data['isValidChecksum'] = $isValidChecksum;
    //         $data['paramList'] = $paramList;
    //         $data['payment_status'] = false;
    //         $data['payment_done_now'] = false;
    //         // $total_fee_pending_to_pay = $total_fee;
    //         $paid_fee_amount = $_POST['TXNAMOUNT'];
    //         if($isValidChecksum == true){ 
    //             if($_POST['STATUS'] == 'TXN_SUCCESS'){ 
    //                 $isExists = $this->fee->checkReAdmissionOrderIdExists($order_id);
    //                 if(empty($isExists)){
    //                     $totalPaid = $this->fee->getReAdmissionTotalPaidAmount($application_no);
    //                     if($totalPaid->paid_amount != 0){
    //                         $total_fee_pending_to_pay -= $totalPaid->paid_amount;
    //                     }
                        
    //                     $pending_fee_balance = $total_fee_pending_to_pay - $paid_fee_amount;
    //                     if($pending_fee_balance <= 0){
    //                         $fee_excess_amount = abs($pending_fee_balance);
    //                         $fee_pending_status = 0;
    //                     }else if($pending_fee_balance > 0){
    //                         $fee_excess_amount = 0;
    //                         $fee_pending_status = 1;
    //                     }
    //                     $feePaymentInfo = $this->fee->getReadmission_FeePaidDetailsByApplicationNo($studentInfo->application_no);
    //                     if(empty($feePaymentInfo)){
    //                         $paid_count = 1;
    //                     }else{
    //                         $paid_count = $feePaymentInfo->payment_count+1;
    //                     }

    //                     $receipt_no = $this->fee->getLastReceiptNoFromOverall($filter['term_name']);
    //                     if(empty($receipt_no)){
    //                         $receipt_no = 0;
    //                     }
    //                     $receipt_no += 1;
    //                     $receipt_no = sprintf('%04d', $receipt_no);

    //                     $overallFee = array(
    //                         'receipt_number'=> $receipt_no,
    //                         'application_no' => $studentInfo->application_no,
    //                         'payment_type' => 'ONLINE',
    //                         'payment_date' => date('Y-m-d',strtotime($_POST['TXNDATE'])),
    //                         'total_amount' => $total_fee_pending_to_pay,
    //                         'paid_amount' => $paid_fee_amount,
    //                         'excess_amount' => $fee_excess_amount,
    //                         'fee_concession' => 0,
    //                         'payment_year' => CURRENT_YEAR,
    //                         'term_name' => $studentInfo->term_name,
    //                         'pending_balance' => $pending_fee_balance,
    //                         'fee_pending_status' => $fee_pending_status,
    //                         'payment_count' => $paid_count,
    //                         'order_id' => $_POST["ORDERID"],
    //                         'collected_staff_name' => 'schoolphins',
    //                         'created_by' => $studentInfo->application_no,
    //                         'created_date_time' => date('Y-m-d H:i:s'));

    //                     $receipt_number = $this->fee->addReadmission_FeeDetailsInfo($overallFee);
    //                     $installmentAmtExist = $this->fee->checkInstallmentAlreadyExistNew($studentInfo->application_no);
    //                     if(!empty($installmentAmtExist)){
    //                         $instalUpdate = array(
    //                             'payment_status' =>1,
    //                             'amount' => $_POST['TXNAMOUNT'],
    //                             'receipt_number' => $receipt_number,
    //                             'updated_by' => $studentInfo->application_no,
    //                             'updated_date_time' => date('Y-m-d H:i:s')
    //                         );
    //                         $this->fee->updateInstalmentNew($instalUpdate, $studentInfo->application_no);
    //                     }
                    
    //                     $paymentLogUpdate = array(
    //                         'payment_mode' => $_POST['PAYMENTMODE'],
    //                         'reference_number'=>$_POST['TXNID'],
    //                         'payment_status' =>'SUCCESS',
    //                         'receipt_number' =>$receipt_number,
    //                         'amount_pending' =>$pending_fee_balance,
    //                         'fee_amount' => $_POST['TXNAMOUNT'],
    //                         'updated_by' => $studentInfo->application_no,
    //                         'updated_date_time' => date('Y-m-d H:i:s')
    //                     );
    //                         $fee_amount_balance_pending = $paid_fee_amount;
    //                         $remaining_fee_amt = $paid_fee_amount;
    //                         foreach($feeStructureInfo as $fee){
    //                             $db_save_status = false;
    //                             $fee_structure_amt = $fee->fee_amount_state_board;
    //                             $isAlreadyPaid = $this->fee->checkFeeTypeIsAlreadyPaid($studentInfo->application_no,$fee->row_id);
    //                             if($remaining_fee_amt >= 0){
    //                                 if(!empty($isAlreadyPaid)){
    //                                     if($isAlreadyPaid->pending_status == 1){
    //                                         $remaining_fee_amt -= $isAlreadyPaid->pending_amt;
    //                                         if($remaining_fee_amt >= 0){
    //                                             //$pending_amount = 0;
    //                                             $paid_amt = $isAlreadyPaid->pending_amt;
    //                                             $pending_amt = 0;
    //                                             $fee_pending_status = 0;
    //                                         } else {
    //                                             //$dd_amount = 0; 
    //                                             $paid_amt = $isAlreadyPaid->pending_amt - abs($remaining_fee_amt);
    //                                             $pending_amt = $isAlreadyPaid->pending_amt - $paid_amt;
    //                                             $fee_pending_status = 1;
    //                                         } 
    //                                         $db_save_status = true;
    //                                     }
    //                                 }else{
    //                                     $remaining_fee_amt -= $fee_structure_amt;
    //                                     if($remaining_fee_amt >= 0){
    //                                         //$pending_amount = 0;
    //                                         $paid_amt = $fee_structure_amt;
    //                                         $pending_amt = 0;
    //                                         $fee_pending_status = 0;
    //                                     } else {
    //                                         //$dd_amount = 0; 
    //                                         $paid_amt = $fee_structure_amt - abs($remaining_fee_amt);
    //                                         $pending_amt = $fee_structure_amt - $paid_amt;
    //                                         $fee_pending_status = 1;
    //                                     } 
    //                                     $db_save_status = true;
    //                                 }
    //                             }else{
    //                                 if(empty($isAlreadyPaid)){
    //                                 $pending_amt = $fee_structure_amt;
    //                                 $paid_amt = 0;
    //                                 $fee_pending_status = 1;
    //                                 $db_save_status = true;
    //                                 }
    //                             }
    //                             if($db_save_status){
    //                                 $feeReceiptPayment = array(
    //                                     'application_no' => $studentInfo->application_no,
    //                                     'receipt_number' => $receipt_number,
    //                                     'payment_date' => date('Y-m-d',strtotime($_POST['TXNDATE'])), 
    //                                     'fee_type_id' => $fee->row_id,
    //                                     'paid_amount' => $paid_amt,
    //                                     'pending_amt' => $pending_amt,
    //                                     'pending_status' => $fee_pending_status,
    //                                     'school_account_id' => $fee->account_row_id,
    //                                     'created_by' => 'schoolphins',
    //                                     'fee_amount' => $fee_structure_amt,
    //                                     'created_date_time' => date('Y-m-d H:i:s'));
                                        
    //                                 $receipt_return_feeType = $this->fee->addReceiptFeeType2021($feeReceiptPayment);
    //                             }
                            
    //                         }
                                
    //                         $this->session->set_flashdata('success', 'Order ID processed successfully '); 
                        
    //                     }else{
    //                         $paymentLogUpdate = array(
    //                             'payment_mode' => $_POST['PAYMENTMODE'],
    //                             'reference_number'=>$_POST['TXNID'],
    //                             'payment_status' =>'SUCCESS',
    //                             'receipt_number' =>$receipt_number,
    //                             'amount_pending' =>$pending_fee_balance,
    //                             'fee_amount' => $_POST['TXNAMOUNT'],
    //                             'updated_by' => $studentInfo->application_no,
    //                             'updated_date_time' => date('Y-m-d H:i:s'));
    //                         $this->session->set_flashdata('success', 'Order ID already exists'); 
    //                     }
    //                 }else{
    //                     $paymentLogUpdate = array(
    //                         'payment_status' =>'FAILED',
    //                         'fee_amount' => $_POST['TXNAMOUNT'],
    //                         'updated_by' => $studentInfo->application_no,
    //                         'updated_date_time' => date('Y-m-d H:i:s')
    //                     );
    //                     $this->session->set_flashdata('error', 'Payment checksum is failed.'); 
    //                 }
    //                 $this->fee->updateReadmission_PaymentLogByOrderIdPaytm($paymentLogUpdate, $_POST["ORDERID"]);
    //             }
                
    //         }else{
    //             $this->session->set_flashdata('success', 'Order ID already processed'); 
    //         }
    //     redirect('getAllFeePaymentInfo');
    // }

    // // New admissio order id process
    // public function newAdmissionOrderIdProcess(){
    //     $paytmChecksum = "";
    //     $paramList = array();
    //     $isValidChecksum = "FALSE";
    //     $order_id = $this->security->xss_clean($this->input->post('order_id'));
    //     $order_id = strtoupper($order_id);
    //     $paytmInfo = $this->fee->getAdmissionPayTmLogByOrderId($order_id);
    //     if(!empty($paytmInfo)){
           
    //         $application_no = $paytmInfo->student_id;
    //         $studentInfo = $this->admission->getStudentStudentInfo($application_no);
    //         // log_message('debug','tetst'.print_r($studentInfo,true));

    //         $requestParamList = array("MID" => PAYTM_MERCHANT_MID , "ORDERID" => $order_id);  

    //         $filter = array();
    //         $filter['term_name'] = 'I PUC';
    //         $filter['stream_name'] = $studentInfo->stream_name;
        
    //         if(strtoupper($studentInfo->elective_sub) == 'FRENCH'){
    //             $filter['lang_fee_status'] = true;
    //         }else{
    //             $filter['lang_fee_status'] = false;
    //         }
    //         $filter['category'] = strtoupper($studentInfo->category);
    //         $boardInfo = $this->admission->getStudentRegisteredInfo($studentInfo->registered_row_id);
    //         $data['board_id'] = $boardInfo->sslc_board_name_id;
    //         if($boardInfo->sslc_board_name_id == 1){
    //             $filter['board_name'] = "SSLC";
    //         }else{
    //             $filter['board_name'] = "OTHER";
    //         }
          
    //         $StatusCheckSum = getChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY);
            
    //         $requestParamList['CHECKSUMHASH'] = $StatusCheckSum;
    
    //         // Call the PG's getTxnStatusNew() function for verifying the transaction status.
    //         $_POST = getTxnStatusNew($requestParamList);
          
                
    //         $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
    //         $data['application_applied_status'] = false;
    //         //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
    //         $isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.
    //         $data['isValidChecksum'] = $isValidChecksum;
    //         $data['paramList'] = $paramList;
    //         $data['payment_status'] = false;
    //         $data['payment_done_now'] = false;
    //         // $total_fee_pending_to_pay = $total_fee;
    //         $paid_fee_amount = $_POST['TXNAMOUNT'];
    //         if($isValidChecksum == true){ 
    //             if($_POST['STATUS'] == 'TXN_SUCCESS'){ 
    //                 $isExists = $this->fee->checkAdmissionOrderIdExists($order_id);
    //                 if(empty($isExists)){
    //                     $feePaymentInfo = $this->fee->getStdPaidDetailsByApplicationNo_newADM($studentInfo->application_number);
    //                     if(empty($feePaymentInfo)){
    //                         $paid_count = 1;
    //                     }else{
    //                         $paid_count = $feePaymentInfo->payment_count+1;
    //                     }
                    
    //                     $data['feePaidInfo'] = $this->fee->getFeePaidInfo_NewAdm_2021($application_no);
    //                     $filter['fee_year'] = CURRENT_YEAR;
    //                     $data['fee_year'] = CURRENT_YEAR;
    //                     $total_fee = $this->fee->getTotalFeeAmount($filter);
    //                     $feeStructureInfo = $this->fee->getFeeStructureInfo2021($filter);
    //                     $total_fee_to_pay = $total_fee->total_fee;
    //                     $data['total_fee'] = $total_fee->total_fee;
    //                     if(!empty($data['feePaidInfo'])){
    //                         foreach($data['feePaidInfo'] as $fee){
    //                             $total_fee_to_pay = $total_fee_to_pay - $fee->paid_amount;
    //                         }
    //                     }
            
    //                     $pending_fee_balance = $total_fee_to_pay - $paid_fee_amount;
    //                     if($pending_fee_balance <= 0){
    //                         $fee_excess_amount = abs($pending_fee_balance);
    //                         $fee_pending_status = 0;
    //                     }else if($pending_fee_balance > 0){
    //                         $fee_excess_amount = 0;
    //                         $fee_pending_status = 1;
    //                     }

    //                     $receipt_no = $this->fee->getLastReceiptNoFromOverall($filter['term_name']);
    //                     if(empty($receipt_no)){
    //                         $receipt_no = 0;
    //                     }
    //                     $receipt_no += 1;
    //                     $receipt_no = sprintf('%04d', $receipt_no);
                    
    //                     $overallFee = array(
    //                         'receipt_number'=> $receipt_no,
    //                         'application_no' => $studentInfo->application_number,
    //                         'payment_type' => 'ONLINE',
    //                         'payment_date' => date('Y-m-d',strtotime($_POST['TXNDATE'])),
    //                         'total_amount' => $total_fee->total_fee,
    //                         'paid_amount' => $paid_fee_amount,
    //                         'excess_amount' => $fee_excess_amount,
    //                         'fee_concession' => 0,
    //                         'pending_balance' => abs($pending_fee_balance),
    //                         'fee_pending_status' => $fee_pending_status,
    //                         'payment_year' => CURRENT_YEAR,
    //                         'term_name' => 'I PUC',
    //                         'payment_count' => $paid_count,
    //                         'order_id' => $_POST["ORDERID"],
    //                         'created_by' => $this->staff_id,
    //                         'created_date_time' => date('Y-m-d H:i:s'));
    //                         $fee_year= 2022;
    //                         $receipt_number = $this->fee->addFeeDetailsNewAdmission_2021($overallFee);
    //                         // log_message('debug','bcbc'.print_r($overallFee,true));

                            
    //                     $paymentLogUpdate = array(
    //                         'payment_mode' => $_POST['PAYMENTMODE'],
    //                         'reference_number'=>$_POST['TXNID'],
    //                         'payment_status' =>'SUCCESS',
    //                         'receipt_number' =>$receipt_number,
    //                         'amount_pending' =>$pending_fee_balance,
    //                         'fee_amount' => $_POST['TXNAMOUNT'],
    //                         'updated_by' => $studentInfo->application_no,
    //                         'updated_date_time' => date('Y-m-d H:i:s'));
            
    //                         $fee_amount_balance_pending = $paid_fee_amount;
    //                         $remaining_fee_amt = $paid_fee_amount;
    //                         foreach($feeStructureInfo as $fee){
    //                             $db_save_status = false;
    //                             $fee_structure_amt = $fee->fee_amount_state_board;
    //                             $isAlreadyPaid = $this->fee->checkFeeTypeIsAlreadyPaid($studentInfo->application_number,$fee->row_id);
    //                             if($remaining_fee_amt >= 0){
    //                                 if(!empty($isAlreadyPaid)){
    //                                     if($isAlreadyPaid->pending_status == 1){
    //                                         $remaining_fee_amt -= $isAlreadyPaid->pending_amt;
    //                                         if($remaining_fee_amt >= 0){
    //                                             //$pending_amount = 0;
    //                                             $paid_amt = $isAlreadyPaid->pending_amt;
    //                                             $pending_amt = 0;
    //                                             $fee_pending_status = 0;
    //                                         } else {
    //                                             //$dd_amount = 0; 
    //                                             $paid_amt = $isAlreadyPaid->pending_amt - abs($remaining_fee_amt);
    //                                             $pending_amt = $isAlreadyPaid->pending_amt - $paid_amt;
    //                                             $fee_pending_status = 1;
    //                                         } 
    //                                         $db_save_status = true;
    //                                     }
    //                                 }else{
    //                                     $remaining_fee_amt -= $fee_structure_amt;
    //                                     if($remaining_fee_amt >= 0){
    //                                         //$pending_amount = 0;
    //                                         $paid_amt = $fee_structure_amt;
    //                                         $pending_amt = 0;
    //                                         $fee_pending_status = 0;
    //                                     } else {
    //                                         //$dd_amount = 0; 
    //                                         $paid_amt = $fee_structure_amt - abs($remaining_fee_amt);
    //                                         $pending_amt = $fee_structure_amt - $paid_amt;
    //                                         $fee_pending_status = 1;
    //                                     } 
    //                                     $db_save_status = true;
    //                                 }
    //                             }else{
    //                                 if(empty($isAlreadyPaid)){
    //                                 $pending_amt = $fee_structure_amt;
    //                                 $paid_amt = 0;
    //                                 $fee_pending_status = 1;
    //                                 $db_save_status = true;
    //                                 }
    //                             }
    //                             if($db_save_status){
    //                                 $feeReceiptPayment = array(
    //                                     'application_no' => $studentInfo->application_number,
    //                                     'receipt_number' => $receipt_number,
    //                                     'payment_date' => date('Y-m-d',strtotime($_POST['TXNDATE'])), 
    //                                     'fee_type_id' => $fee->row_id,
    //                                     'paid_amount' => $paid_amt,
    //                                     'pending_amt' => $pending_amt,
    //                                     'pending_status' => $fee_pending_status,
    //                                     'school_account_id' => $fee->account_row_id,
    //                                     'created_by' => 'schoolphins',
    //                                     'fee_amount' => $fee_structure_amt,
    //                                     'created_date_time' => date('Y-m-d H:i:s'));
                                        
    //                                 $receipt_return_feeType = $this->fee->addReceiptFeeType($feeReceiptPayment);
    //                             }
                            
    //                         }

    //                         $applicationStatus = array(
    //                             'joined_status' => 1,
    //                             'admission_status'=> 1,
    //                             'updated_date_time' => date('Y-m-d H:i:s'));
    //                         $this->admission->updateStudentApplicationStatus($studentInfo->application_number,$applicationStatus);
                              
    //                         $this->session->set_flashdata('success', 'Order ID processed successfully '); 
    //                     }else{
    //                         $paymentLogUpdate = array(
    //                             'payment_mode' => $_POST['PAYMENTMODE'],
    //                             'reference_number'=>$_POST['TXNID'],
    //                             'payment_status' =>'SUCCESS',
    //                             'receipt_number' =>$receipt_number,
    //                             'amount_pending' =>$pending_fee_balance,
    //                             'fee_amount' => $_POST['TXNAMOUNT'],
    //                             'updated_by' => $studentInfo->application_no,
    //                             'updated_date_time' => date('Y-m-d H:i:s'));
    //                         $this->session->set_flashdata('success', 'Order ID already exists'); 
    //                     }
                    
    //                 }else{
    //                     $paymentLogUpdate = array(
    //                         'payment_status' =>'FAILED',
    //                         'fee_amount' => $_POST['TXNAMOUNT'],
    //                         'updated_by' => $studentInfo->application_no,
    //                         'updated_date_time' => date('Y-m-d H:i:s')
    //                     );
    //                     $this->session->set_flashdata('error', 'Payment checksum is failed.'); 
    //                 }
    //                 $this->fee->updatePaymentLogByOrderId($paymentLogUpdate, $_POST["ORDERID"]);
    //             }
                
    //         }else{
    //             $this->session->set_flashdata('success', 'Order ID already processed'); 
    //         }
    //     redirect('getAllFeePaymentInfo');
    // }

            
    public function newFeePayNow(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $data['fee_pending_status'] = false; 
        //  $data['studentInfoSelection'] = $this->student->getAllFirstYearStudent();
            // $data['newStdInfo'] = $this->admission->getFirstYearStudentsInfo();
            $data['allStudentInfo'] = $this->student->getAllStudentsInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Pay Now';
            $this->loadViews("fees/newPaymentPortal", $this->global, $data, null);
        }
    }

    public function getStudentFeePaymentInfo(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $application_no = $this->security->xss_clean($this->input->post('application_no'));
            //check student exist in student info table(persuing students)
            if(empty($application_no)){
                $application_no = $_SESSION["FEE_STUDENT_ID"];
            }
            $studentInfo =  $this->student->getStudentInfoByRowId($application_no);
            // if(empty($studentInfo)){
            //     //check student exist in new admission info
            //     $studentInfo = $this->admission->getStudentStudentInfo($application_no);
            // }
            $filter['fee_year'] = trim($studentInfo->intake_year_id);
            $filter = array(); 
            //FOR BOARD
            // $studentInfo2 = $this->admission->getStudentStudentInfo($application_no);
            // $boardInfo = $this->admission->getStudentRegisteredInfo($studentInfo2->registered_row_id);
            // $data['board_id'] = $boardInfo->sslc_board_name_id;
            // if($boardInfo->sslc_board_name_id == 1){
            //     $filter['board_name'] = "SSLC";
            // }else{
            //     $filter['board_name'] = "OTHER";
            // }
            if(!empty($studentInfo)){
                $paymentInfo = $this->student->getPaytmPaymentLogFees($application_no);
                if(!empty($paymentInfo)){
                    foreach($paymentInfo as $pay){
                        $ORDER_ID = $pay->order_id;
                        $this->feePaymentReprocess($ORDER_ID,$application_no);
                    }
                }
                $term_name = $studentInfo->term_name;
                $data['application_no'] = $studentInfo->application_no;
                $data['row_id'] = $studentInfo->row_id;
                $data['student_name'] = $studentInfo->student_name;
                $data['term_name'] = $term_name;
                $filter['stream_name'] = $studentInfo->stream_name;
                $filter['gender'] = $studentInfo->gender;
                $filter['student_fee_type'] = 'REG';

                if($term_name == 'I PUC'){
                    $data['text_display_view']  = "I PUC Student info";
                    $filter['term_name'] = $term_name;
                    $filter['fee_year'] = $studentInfo->intake_year_id;
                    $data['management_fee'] = $total_fee_obj = $this->fee->getTotalFeeAmount($filter);
                    $data['govt_fee'] = $govt_fee = $this->fee->getGovtFeeAmount($filter);
                   // log_message('debug', "filter".print_r($filter,true));
                    if(empty($govt_fee)){
                        $data['govt_fee'] = $govt_fee = 0;
                    }
                    $data['total_fee_mgmt'] = $total_fee_obj->total_fee + $govt_fee;
                    $total_fee_amount = $total_fee_obj->total_fee + $govt_fee;
                    $data['total_fee_amount'] = ($total_fee_obj->total_fee + $govt_fee);
                    $data['concession_amount'] = $concession_amt = $this->fee->getFeeConcessionByAppNo($application_no,$filter['fee_year']);
                    $paidFee = $this->fee->getTotalFeePaidInfo($application_no,$filter['fee_year']);
                    $data['management_fee_paid'] = $paidFee;
                    $govtFeePaid = $this->fee->getSumGovtFeePaidInfo($application_no,$filter['fee_year']);
                    $data['feePaidInfo'] = $this->fee->getFeePaidInfo($application_no,$filter['fee_year']);
                    $data['govtPaidInfo'] = $this->fee->getGovtFeePaidInfo($application_no,$filter['fee_year']);
                    $data['paid_amount'] = $paidFee + $govtFeePaid->paid_amount;
                    $govt_fee -= $govtFeePaid->paid_amount;
                    $total_fee_amount -= $paidFee;
                    $data['previousBal'] = $data['first_puc_pending_amount'] = $data['pending_amount'] = $total_fee_amount;
                    $data['I_balance'] = $total_fee_amount- $concession_amt;
                    $data['balance'] = 0;
                    $data['govtFeePaid'] = $govtFeePaid->paid_amount;
                    $data['i_management_fee_pending'] = $data['total_fee_mgmt'] - $paidFee - $concession_amt;
                    $data['govt_balance'] = $govt_fee; //- $deptFeePaid->paid_amount;
                    //CHECK INSTALLMENT
                    // $data['fee_installment'] = $this->fee->checkInstalmentExists($application_no,$filter['fee_year']);
                }else{
                    //$prev_year = trim($studentInfo->intake_year_id)-1;
                    // this will execute if student only II PUC
                    //------ I PUC PENDING START
                    $data['text_display_view']  = "II PUC Student info";
                    $filter['term_name'] = 'I PUC';
                    $filter['fee_year'] = trim($studentInfo->intake_year_id);
                    $data['management_fee'] = $total_fee_obj = $this->fee->getTotalFeeAmount($filter);
                    $data['govt_fee'] = $govt_fee = $this->fee->getGovtFeeAmount($filter);
                    if(empty($govt_fee)){
                        $data['govt_fee'] = $govt_fee = 0;
                    }
                    $data['first_puc_total_fee'] = $first_puc_total_bal = $total_fee_obj->total_fee + $govt_fee;
                    $paidFee = $this->fee->getTotalFeePaidInfo($application_no,$filter['fee_year']);
                    if($studentInfo->intake_year_id == FEE_YEAR){
                        $data['feePaidInfo'] = '';
                    }else{
                        $data['feePaidInfo'] = $this->fee->getFeePaidInfo($application_no,$filter['fee_year']);
                    }
                    $concession = $this->fee->getFeeConcessionByAppNo($application_no,$filter['fee_year']);
                    $year = (int)substr($studentInfo->intake_year, 0, 4);
                    if($year != FEE_YEAR){
                        $data['i_management_fee_pending'] = $data['I_balance'] = $data['previousBal'] = $first_puc_total_bal - $paidFee - $concession;
                    }else{
                        $data['i_management_fee_pending'] = $data['I_balance'] = $data['previousBal'] = 0;
                    }
                    //I PUC PENDING END --------//

                    // II PUC fee calculation start
                    $filter['term_name'] = 'II PUC';
                    //add extra ine year to intake year only (based on clg database data)
                    if($studentInfo->intake_year_id == FEE_YEAR){
                        $filter['student_fee_type'] = 'NEW';
                        $data['fee_year_II'] =  $filter['fee_year'] = trim($studentInfo->intake_year_id);
                    }else{
                        $filter['student_fee_type'] = 'REG';
                        $data['fee_year_II'] =  $filter['fee_year'] = trim($studentInfo->intake_year_id)+1;
                    }
                    // $filter['board_name'] = 'SSLC';
                    log_message('debug','fee filter'.print_r($filter,true));
                    $data['management_fee'] = $total_fee_obj = $this->fee->getTotalFeeAmount($filter);
                    log_message('debug','fee total fee'.print_r($total_fee_obj,true));
                    $data['govt_fee'] = $govt_fee = $this->fee->getGovtFeeAmount($filter);
                    if(empty($govt_fee)){
                        $data['govt_fee'] = $govt_fee = 0;
                    }
                    $data['second_puc_total_fee'] =  $data['total_fee_amount'] =  $total_fee_amount = $total_fee_obj->total_fee + $govt_fee;
                    $data['total_fee_mgmt'] =  $total_fee_obj->total_fee + $govt_fee;
                    $data['concession_amount'] = $concession_amt = $this->fee->getFeeConcessionByAppNo($application_no,$filter['fee_year']);
                    //CHECK INSTALLMENT
                    // $data['fee_installment'] = $this->fee->checkInstalmentExists($application_no,$filter['fee_year']);

                    $paidFee = $this->fee->getTotalFeePaidInfo($application_no,$filter['fee_year']);
                    $data['II_feePaidInfo'] = $this->fee->getFeePaidInfo($application_no,$filter['fee_year']);
                    $total_fee_amount -= $paidFee;
                    $data['management_fee_paid'] = $paidFee;
                    $data['second_puc_pending_amount'] = $data['pending_amount'] = $total_fee_amount;
                    $data['paid_amount'] = $paidFee;
                    $data['ii_management_fee_pending'] = $data['total_fee_mgmt'] - $paidFee - $concession_amt;
                    //get list of payment in II PUC
                    $data['balance'] = $total_fee_amount - $concession_amt; //- $deptFeePaid->paid_amount;
                }
                // $data['balance'] = $total_fee_to_pay;
                $data['studentInfo'] = $studentInfo;
            }else{
                $this->session->set_flashdata('error', 'Sorry!, Student data not found!');
            }
            $data['newStdInfo'] = $this->admission->getFirstYearStudentsInfo();
            $data['allStudentInfo'] = $this->student->getAllStudentsInfo();
            $this->global['pageTitle'] = TAB_TITLE.' : Fee Payment' ;
            $this->loadViews("fees/newPaymentPortal", $this->global, $data, null);
        }
    }

    public function addFeePaymentInfo(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {  
            $filter = array();
            $term_name = $this->security->xss_clean($this->input->post('term_name_selected')); 
            $application_no = $this->security->xss_clean($this->input->post('application_no'));
            $paid_fee_amount = $this->security->xss_clean($this->input->post('paid_fee_amount'));
            $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
            $dd_number = $this->security->xss_clean($this->input->post('dd_number'));
            $dd_date = $this->security->xss_clean($this->input->post('dd_date'));
            $bank_name = $this->security->xss_clean($this->input->post('bank_name'));
            $tran_number = $this->security->xss_clean($this->input->post('tran_number'));
            $tran_date = $this->security->xss_clean($this->input->post('tran_date'));
            $tran_bank_name = $this->security->xss_clean($this->input->post('tran_bank_name'));
            $bank_tran_number = $this->security->xss_clean($this->input->post('bank_tran_number'));
            $bank_tran_date = $this->security->xss_clean($this->input->post('bank_tran_date'));
            $bank_tran_name = $this->security->xss_clean($this->input->post('bank_tran_name'));
            $upi_tran_number = $this->security->xss_clean($this->input->post('upi_tran_number'));
            $upi_tran_date = $this->security->xss_clean($this->input->post('upi_tran_date'));
            $payment_date = $this->security->xss_clean($this->input->post('transaction_date'));
            $excess_amount = $this->security->xss_clean($this->input->post('excess_amount'));
            $ref_number = $this->security->xss_clean($this->input->post('ref_number'));
            $neft_date = $this->security->xss_clean($this->input->post('neft_date'));
            $_SESSION["FEE_STUDENT_ID"] = $application_no;
            $_SESSION["FEE_TERM_NAME"] = $term_name;
            $filter['student_id'] = $student_id;
            $studentInfo =  $this->student->getStudentInfoByRowId($application_no);
            $filter['fee_year'] = $studentInfo->intake_year_id;
            $filter['student_fee_type'] = 'REG';
            if($term_name == 'II PUC'){
                if($studentInfo->intake_year_id == FEE_YEAR){
                    $filter['student_fee_type'] = 'NEW';
                    $filter['fee_year'] = trim($studentInfo->intake_year_id);
                }else{
                    $filter['student_fee_type'] = 'REG';
                    $filter['fee_year'] = trim($studentInfo->intake_year_id)+1;
                }
            }
            $filter['term_name'] = $term_name;
            $filter['stream_name'] = $studentInfo->stream_name;
            $filter['gender'] = $studentInfo->gender;
            $total_fee = $this->fee->getTotalFeeAmount($filter);
            $depart_fee = $this->fee->getGovtFeeAmount($filter);
            // $feeStructureInfo = $this->fee->getFeeStructureInfo($filter);
            $total_fee_to_pay = $total_fee->total_fee + $depart_fee;
            // log_message('debug','total_fee_to_pay='.print_r($total_fee_to_pay,true));
            $data['feePaidInfo'] = $this->fee->getFeePaidInfo($application_no,$filter['fee_year']);
            if(!empty($data['feePaidInfo'])){
                foreach($data['feePaidInfo'] as $fee){
                    $total_fee_to_pay = $total_fee_to_pay - $fee->paid_amount;
                }
            }
            $concession = 0; 
            $concession_amt = $this->fee->getFeeConcessionByAppNo($application_no,$filter['fee_year']);
            if($concession_amt>0){
                $concession = $concession_amt;
                $total_fee_to_pay -= $concession;
            }
            $remaining_fee_amt = $paid_fee_amount;
            $feePaymentInfo = $this->fee->getStdLastPaidDetailsByApplicationNo($application_no,$filter['fee_year']);

            if(empty($feePaymentInfo)){
                $paid_count = 1;
                //$paid_fee_amount -= $depart_fee;
            }else{
                $paid_count = $feePaymentInfo->payment_count+1;
            }

            $pending_fee_balance = $total_fee_to_pay - $paid_fee_amount;
            if($pending_fee_balance <= 0){
                $fee_excess_amount = abs($pending_fee_balance);
                $fee_pending_status = 0;
                $pending_fee_balance = 0;
            }else if($pending_fee_balance > 0){
                $fee_excess_amount = 0;
                $fee_pending_status = 1;
            }
            $lastReceiptInfo = $this->fee->getLastReceiptNoNew($filter['fee_year']);
            if(!empty($lastReceiptInfo->receipt_number)){
                $receipt_no_new = $lastReceiptInfo->receipt_number + 1;
            }else{
                $receipt_no_new = 1;
            }
            $receipt_no_new = sprintf('%04d',$receipt_no_new);
            $receipt_no = substr((string)$filter['fee_year'], -2) . 'T' . $receipt_no_new;
            if($payment_type == 'DD'){
                $dd_date = date('Y-m-d',strtotime($dd_date));
                $bank_name = $bank_name;
                $tran_date = '';
            }else if($payment_type == 'CARD'){
                $tran_number = $tran_number;
                $tran_date = date('Y-m-d',strtotime($tran_date));
                $bank_name = $tran_bank_name;
                $dd_date = '';           
            }else if($payment_type == 'BANK'){
                $tran_number = $bank_tran_number;
                $tran_date = date('Y-m-d',strtotime($bank_tran_date));
                $bank_name = $bank_tran_name;
                $dd_date = '';           
            }else if($payment_type == 'UPI'){
                $tran_number = $upi_tran_number;
                $tran_date = date('Y-m-d',strtotime($upi_tran_date));
                $dd_date = '';           
            }else if($payment_type == 'NEFT'){
                $tran_number = $ref_number;
                $tran_date = date('Y-m-d',strtotime($neft_date));
                $dd_date = '';           
            }else{
                $dd_date = '';
                $bank_name = '';
                $tran_date = '';
                $tran_number = '';
            }
            $overallFee = array(
                'application_no' => $application_no,
                'receipt_number' => $receipt_no_new,
                'payment_type' => $payment_type,
                'payment_date' => date('Y-m-d',strtotime($payment_date)),
                'total_amount' => $total_fee_to_pay,
                'paid_amount' => $paid_fee_amount,
                'excess_amount' => $fee_excess_amount,
                'fee_concession' => $concession,
                'pending_balance' => abs($pending_fee_balance),
                'fee_pending_status' => $fee_pending_status,
                'payment_count' => $paid_count,
                'payment_year' => $filter['fee_year'],
                'term_name' => $term_name,
                'dd_number' => $dd_number,
                'dd_date' => $dd_date,
                'bank_name' => $bank_name,
                'staff_payment' => 1,
                'transaction_number' => $tran_number,
                'transaction_date' => $tran_date,
                'created_by' => $this->staff_id,
                'created_date_time' => date('Y-m-d H:i:s'));
            $fee_year= $filter['fee_year'];
            $overall_row_id = $this->fee->addFeeDetailsNewAdmission($overallFee);
            $remaining_fee_amt = $paid_fee_amount;
            $feeStructureInfo = $this->fee->getAllFeeStructureInfoForReceipt($filter);
            foreach($feeStructureInfo as $fee){
                $db_save_status = false;
                $fee_structure_amt = $fee->fee_amount_state_board;
                //     $isAlreadyPaid = $this->fee->checkFeeTypeIsAlreadyPaid($application_no,$fee->row_id);
                //     if($remaining_fee_amt >= 0){
                //         if(!empty($isAlreadyPaid)){
                //             if($isAlreadyPaid->pending_status == 1){
                //                 $remaining_fee_amt -= $isAlreadyPaid->pending_amt;
                //                 if($remaining_fee_amt >= 0){
                //                     //$pending_amount = 0;
                //                     $paid_amt = $isAlreadyPaid->pending_amt;
                //                     $pending_amt = 0;
                //                     $fee_pending_status = 0;
                //                 } else {
                //                     //$dd_amount = 0; 
                //                     $paid_amt = $isAlreadyPaid->pending_amt - abs($remaining_fee_amt);
                //                     $pending_amt = $isAlreadyPaid->pending_amt - $paid_amt;
                //                     $fee_pending_status = 1;
                //                 } 
                //                 $db_save_status = true;
                //             }
                //         }else{
                //             $remaining_fee_amt -= $fee_structure_amt;
                //             if($remaining_fee_amt >= 0){
                //                 //$pending_amount = 0;
                //                 $paid_amt = $fee_structure_amt;
                //                 $pending_amt = 0;
                //                 $fee_pending_status = 0;
                //             } else {
                //                 //$dd_amount = 0; 
                //                 $paid_amt = $fee_structure_amt - abs($remaining_fee_amt);
                //                 $pending_amt = $fee_structure_amt - $paid_amt;
                //                 $fee_pending_status = 1;
                //             } 
                //             $db_save_status = true;
                //         }
                //     }else{
                //         if(empty($isAlreadyPaid)){
                //         $pending_amt = $fee_structure_amt;
                //         $paid_amt = 0;
                //         $fee_pending_status = 1;
                //         $db_save_status = true;
                //         }
                //     }

                // $structure_total = (float)$fee->fee_amount_state_board;
                // if($structure_total < 0) $structure_total = 0;
                // $isAlreadyPaid = $this->fee->checkFeeTypeIsAlreadyPaid($application_no, $fee->fee_division_id);
                // // initialize values
                // $paid_amt = 0;
                // $pending_amt = 0;
                // $fee_pending_status = 1; // default pending

                // // 1) If there's an existing paid record with pending > 0, pay that pending first
                // if(!empty($isAlreadyPaid) && (float)$isAlreadyPaid->pending_amt > 0){
                //     $existing_pending = (float)$isAlreadyPaid->pending_amt;
                //     // pay as much as available
                //     $to_pay = min($remaining_fee_amt, $existing_pending);
                //     $paid_amt = $to_pay;
                //     $pending_after = $existing_pending - $to_pay;
                //     $pending_amt = $pending_after;
                //     $fee_pending_status = ($pending_after > 0) ? 1 : 0;
                //     // decrease remaining amount available to allocate
                //     $remaining_fee_amt -= $to_pay;
                //     // Save/update record (we insert a new row for this receipt allocation)
                //     $db_save_status = true;
                // }

                // // 2) If there's no existing pending (or after clearing existing pending we still have money), apply to whole structure amount
                // if($remaining_fee_amt > 0){
                //     $isAlreadyPaidTotal = $this->fee->checkFeeTypeTotalPaid($application_no, $fee->fee_division_id);
                //     // Need to compute how much of structure_total is already paid historically (if any)
                //     $already_paid_total = (!empty($isAlreadyPaid)) ? (float)$isAlreadyPaidTotal->total_paid : 0;
                //     // Remaining due for this fee structure = structure_total - already_paid_total
                //     $due_for_structure = $structure_total - $already_paid_total;
                //     if($due_for_structure < 0) $due_for_structure = 0;
                //     if($due_for_structure > 0){
                //         $to_pay2 = min($remaining_fee_amt, $due_for_structure);
                //         // If we already set $paid_amt above (clearing existing pending), add to it; else set it.
                //         $paid_amt = isset($paid_amt) ? ($paid_amt + $to_pay2) : $to_pay2;
                //         $pending_after_structure = $due_for_structure - $to_pay2;
                //         // total pending for this fee should consider any leftover pending from earlier + structure pending
                //         // But since above we cleared existing pending first, now pending_after_structure is final pending
                //         $pending_amt = $pending_after_structure;
                //         $fee_pending_status = ($pending_after_structure > 0) ? 1 : 0;
                //         $remaining_fee_amt -= $to_pay2;
                //         $db_save_status = true;
                //     } else {
                //         // nothing due left for structure (already fully paid historically)
                //         // if no prior pending and no due, do nothing
                //         // $paid_amt remains whatever was set earlier (maybe 0)
                //     }
                // }

                $structure_total = (float)$fee->fee_amount_state_board;
                if($structure_total < 0){
                    $structure_total = 0;
                }
                // initialize values
                $paid_amt = 0;
                $pending_amt = 0;
                $fee_pending_status = 1;
                $db_save_status = false;
                // already paid info
                $AlreadyPaidInfo = $this->fee->checkFeeTypeTotalPaid($application_no, $fee->fee_division_id);
                if(!empty($AlreadyPaidInfo->total_paid)){
                    $already_paid_total =  (float)$AlreadyPaidInfo->total_paid; 
                }else{
                    $already_paid_total =  0; 
                }
                // calculate actual pending
                $pending_balance = $structure_total - $already_paid_total;

                if($pending_balance < 0){
                    $pending_balance = 0;
                }
                if($remaining_fee_amt > 0 && $pending_balance > 0){
                    // amount to pay now
                    $paid_amt = min($remaining_fee_amt, $pending_balance);
                    // remaining pending after this payment
                    $pending_amt = $pending_balance - $paid_amt;
                    // pending status
                    if(!empty($pending_amt > 0)){
                        $fee_pending_status =  1; 
                    }else{
                        $fee_pending_status =  0; 
                    }
                    // reduce remaining amount
                    $remaining_fee_amt -= $paid_amt;
                    $db_save_status = true;
                }
                if($db_save_status){
                    $receipt_number_for_fee = $receipt_no;
                    if((int)$fee->fee_division_id === 1){
                        $receipt_number_for_fee = $this->fee->getLastReceiptNoByFeeType($filter['fee_year'], $fee->fee_division_id);
                    }
                    $feeReceiptPayment = array(
                        'application_no' => $application_no,
                        'receipt_number' => $overall_row_id,
                        'receipt_no' => $receipt_number_for_fee, 
                        'payment_date' => date('Y-m-d',strtotime($payment_date)), 
                        'fee_type_id' => $fee->fee_division_id,
                        'fee_structure_id' => $fee->row_id,
                        'paid_amount' => $paid_amt,
                        'pending_amt' => $pending_amt,
                        'payment_year' => $filter['fee_year'],
                        'pending_status' => $fee_pending_status,
                        'school_account_id' => $fee->account_row_id,
                        'created_by' => 'schoolphins',
                        'fee_amount' => $fee_structure_amt,
                        'created_date_time' => date('Y-m-d H:i:s'));
                    $receipt_return_feeType = $this->fee->addReceiptFeeType($feeReceiptPayment);
                }
            }  
            if(!empty($overall_row_id)){
                $concessionAmt =  $this->fee->checkConsessionExists($application_no,$fee_year);
                if(!empty($concessionAmt)){
                    $concessionInfo = array(
                        'payment_status'=>1,
                        // 'instalment_status'=>1,
                        'updated_by'=>$this->staff_id,
                        'updated_date_time'=>date('Y-m-d H:i:s'));
                    $this->fee->updateConcessionById($concessionInfo, $concessionAmt->row_id);
                }
            }else{
                $this->session->set_flashdata('error', 'Fee Payment Failed!');
            }
            redirect('getStudentFeePaymentInfo'); 
        }
    }

    public function addGovtFeePaymentInfo(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {  
            $filter = array();
            $term_name = $this->security->xss_clean($this->input->post('govtterm_name_selected')); 
            $application_no = $this->security->xss_clean($this->input->post('govtapplication_no'));
            $paid_fee_amount = $this->security->xss_clean($this->input->post('govtpaid_fee_amount'));
            $payment_type = $this->security->xss_clean($this->input->post('govtpayment_type'));
            $dd_number = $this->security->xss_clean($this->input->post('govtdd_number'));
            $dd_date = $this->security->xss_clean($this->input->post('govtdd_date'));
            $bank_name = $this->security->xss_clean($this->input->post('govtbank_name'));
            $tran_number = $this->security->xss_clean($this->input->post('govttran_number'));
            $tran_date = $this->security->xss_clean($this->input->post('govttran_date'));
            $tran_bank_name = $this->security->xss_clean($this->input->post('govttran_bank_name'));
            $bank_tran_number = $this->security->xss_clean($this->input->post('govtbank_tran_number'));
            $bank_tran_date = $this->security->xss_clean($this->input->post('govtbank_tran_date'));
            $bank_tran_name = $this->security->xss_clean($this->input->post('govtbank_tran_name'));
            $upi_tran_number = $this->security->xss_clean($this->input->post('govtupi_tran_number'));
            $upi_tran_date = $this->security->xss_clean($this->input->post('govtupi_tran_date'));
            $payment_date = $this->security->xss_clean($this->input->post('govttransaction_date'));
            $excess_amount = $this->security->xss_clean($this->input->post('govtexcess_amount'));
            $_SESSION["FEE_STUDENT_ID"] = $application_no;
            $_SESSION["FEE_TERM_NAME"] = $term_name;
            $filter['student_id'] = $student_id;
            $studentInfo =  $this->student->getStudentInfoByRowId($application_no);
            $filter['fee_year'] = $studentInfo->intake_year_id;
            $remaining_fee_amt = $paid_fee_amount;
            if($term_name == 'II PUC'){
                if($studentInfo->intake_year_id == FEE_YEAR){
                    $filter['fee_year'] = trim($studentInfo->intake_year_id);
                }else{
                    $filter['fee_year'] = trim($studentInfo->intake_year_id)+1;
                }
            }else{
                $filter['fee_year'] = FEE_YEAR;
            }
            $filter['term_name'] = $term_name;
            $filter['stream_name'] = $studentInfo->stream_name;
            $filter['gender'] = $studentInfo->gender;
            // log_message('debug','filter='.print_r($filter,true));
            // $total_fee = $this->fee->getTotalFeeAmount($filter);
            $total_fee_to_pay = $this->fee->getGovtFeeAmount($filter);
            $data['govtfeePaidInfo'] = $this->fee->getGovtFeePaidInfo($application_no,$filter['fee_year']);
            if(!empty($data['govtfeePaidInfo'])){
                foreach($data['govtfeePaidInfo'] as $fee){
                    $total_fee_to_pay = $total_fee_to_pay - $fee->paid_amount;
                }
            }
            $pending_fee_balance = $total_fee_to_pay - $paid_fee_amount;
            if($pending_fee_balance <= 0){
                $fee_excess_amount = abs($pending_fee_balance);
                $fee_pending_status = 0;
            }else if($pending_fee_balance > 0){
                $fee_excess_amount = 0;
                $fee_pending_status = 1;
            }
            //DEPARTMENT FEE----
            $lastGovtReceiptInfo = $this->fee->getLastGovtReceiptNo($filter['fee_year']);
            if(!empty($lastGovtReceiptInfo->receipt_number)){
                $govt_receipt_no = $lastGovtReceiptInfo->receipt_number + 1;
            }else{
                $govt_receipt_no = 1;
            }
            $govt_receipt_no = sprintf('%04d',$govt_receipt_no);
            if($payment_type == 'DD'){
                $dd_date = date('Y-m-d',strtotime($dd_date));
                $bank_name = $bank_name;
                $tran_date = '';
            }else if($payment_type == 'CARD'){
                $tran_date = date('Y-m-d',strtotime($tran_date));
                $bank_name = $tran_bank_name;
                $dd_date = '';           
            }else if($payment_type == 'BANK'){
                $tran_number = $bank_tran_number;
                $tran_date = date('Y-m-d',strtotime($bank_tran_date));
                $bank_name = $bank_tran_name;
                $dd_date = '';           
            }else if($payment_type == 'UPI'){
                $tran_number = $upi_tran_number;
                $tran_date = date('Y-m-d',strtotime($upi_tran_date));
                $dd_date = '';           
            }else{
                $dd_date = '';
                $bank_name = '';
                $tran_date = '';
                $tran_number = '';
            }
            $deptFeeInfo = array(
                'application_no' => $application_no,
                'receipt_number' => $govt_receipt_no,
                'payment_type' => $payment_type,
                'payment_date' => date('Y-m-d',strtotime($payment_date)),
                'paid_amount' => $paid_fee_amount,
                'payment_year' => $filter['fee_year'],
                'term_name' => $term_name,
                'pending_balance' => abs($pending_fee_balance),
                'excess_amount' => $fee_excess_amount,
                'dd_number' => $dd_number,
                'dd_date' => $dd_date,
                'bank_name' => $bank_name,
                'transaction_number' => $tran_number,
                'transaction_date' => $tran_date,
                'created_by' => $this->staff_id,
                'created_date_time' => date('Y-m-d H:i:s'));
            $govt_row_id = $this->fee->addGovtFeeDetail($deptFeeInfo);                    
            //----DEPARTMENT FEE  
            $feeStructureInfo = $this->fee->getFeeStructureInfo($filter);
            foreach($feeStructureInfo as $fee){
                $db_save_status = false;
                $fee_structure_amt = $fee->fee_amount_state_board;
                $isAlreadyPaid = $this->fee->checkFeeTypeIsAlreadyPaid($application_no,$fee->row_id);
                if($remaining_fee_amt >= 0){
                    if(!empty($isAlreadyPaid)){
                        if($isAlreadyPaid->pending_status == 1){
                            $remaining_fee_amt -= $isAlreadyPaid->pending_amt;
                            if($remaining_fee_amt >= 0){
                                //$pending_amount = 0;
                                $paid_amt = $isAlreadyPaid->pending_amt;
                                $pending_amt = 0;
                                $fee_pending_status = 0;
                            } else {
                                //$dd_amount = 0; 
                                $paid_amt = $isAlreadyPaid->pending_amt - abs($remaining_fee_amt);
                                $pending_amt = $isAlreadyPaid->pending_amt - $paid_amt;
                                $fee_pending_status = 1;
                            } 
                            $db_save_status = true;
                        }
                    }else{
                        $remaining_fee_amt -= $fee_structure_amt;
                        if($remaining_fee_amt >= 0){
                            //$pending_amount = 0;
                            $paid_amt = $fee_structure_amt;
                            $pending_amt = 0;
                            $fee_pending_status = 0;
                        } else {
                            //$dd_amount = 0; 
                            $paid_amt = $fee_structure_amt - abs($remaining_fee_amt);
                            $pending_amt = $fee_structure_amt - $paid_amt;
                            $fee_pending_status = 1;
                        } 
                        $db_save_status = true;
                    }
                }else{
                    if(empty($isAlreadyPaid)){
                    $pending_amt = $fee_structure_amt;
                    $paid_amt = 0;
                    $fee_pending_status = 1;
                    $db_save_status = true;
                    }
                }
                if($db_save_status){
                    $feeReceiptPayment = array(
                        'application_no' => $application_no,
                        'receipt_number' => $govt_row_id,
                        'payment_date' => date('Y-m-d',strtotime($payment_date)), 
                        'fee_type_id' => $fee->row_id,
                        'paid_amount' => $paid_amt,
                        'pending_amt' => $pending_amt,
                        'payment_year' => $filter['fee_year'],
                        'pending_status' => $fee_pending_status,
                        'school_account_id' => $fee->account_row_id,
                        'created_by' => 'schoolphins',
                        'fee_amount' => $fee_structure_amt,
                        'created_date_time' => date('Y-m-d H:i:s'));
                    $receipt_return_feeType = $this->fee->addReceiptFeeType($feeReceiptPayment);
                }
            } 
            if(!empty($govt_row_id)){
                $this->session->set_flashdata('success', 'Government Fee Paid Successfully'); 
            }else{
                $this->session->set_flashdata('error', 'Government Fee Payment Failed!');
            }
            redirect('getStudentFeePaymentInfo'); 
        }
    }

    public function govtfeePaymentReceiptPrint($row_id){
        $filter = array();
        $data['govtFeeInfo'] = $this->fee->getGovtFeeInfoByReceiptNum($row_id);
        $studentInfo =  $this->student->getStudentInfoByRowId($data['govtFeeInfo']->application_no);
        $data['govtAmt'] = $this->fee->getGovernmentFee($studentInfo->stream_name,$studentInfo->term_name);
        $filter['stream_name'] = $studentInfo->stream_name;
        $filter['term_name'] = $studentInfo->term_name;
        $filter['fee_year'] = $data['govtFeeInfo']->payment_year;
        $data['govt_fee'] = $govt_fee = $this->fee->getGovtFeeAmount($filter);
        if(empty($govt_fee)){
            $data['govt_fee'] = $govt_fee = 0;
        }
        $data['feeGovtStructureInfo'] = $this->fee->getGovtFeeStructureInfoReceipt($filter);
        $data['feePaidInfo'] = $this->fee->getAdmissionFeePaidInfoById($row_id,$data['govtFeeInfo']->application_no);
        // $data['previousFeePaidInfo'] = $this->fee->getGovtPreviousFeePaidInfo($row_id,$data['govtFeeInfo']->application_no, $data['govtFeeInfo']->payment_year);
        $filter['fee_year'] = $data['govtFeeInfo']->application_no;
        $data['studentInfo'] = $studentInfo;
        $data['paid_amount'] = $data['govtFeeInfo']->paid_amount;
        $data['staffName']  = $this->fee->getStaffNameById($data['govtFeeInfo']->created_by);
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Fee Receipt';
        $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman', 'format' => [148, 210]]);
        $mpdf->AddPage('P','','','','',5,5,10,8,8,8);
        $mpdf->SetTitle('Fee Receipt');
        // $html = $this->load->view('fees/govtfeeReceiptPrint',$data,true);
        // $mpdf->WriteHTML($html);
        $data['paid_amount_words'] = $this->getIndianCurrency(floatval($data['paid_amount']));
        $data['name_count'] = 0;
        $html_student_copy = $this->load->view('fees/govtfeeReceiptPrint',$data,true);
        $data['name_count'] = 1;
        $html_office_copy = $this->load->view('fees/govtfeeReceiptPrint',$data,true);
        $mpdf->WriteHTML('<columns column-count="2" vAlign="J" column-gap="4" />');
        $mpdf->WriteHTML($html_student_copy);
        $mpdf->WriteHTML($html_office_copy);
        $mpdf->Output('Govt_Fee_Receipt.pdf', 'I');
    }
   
    // public function feePaymentReceiptPrint($row_id){
    //     $filter = array();
    //     $data['feeInfo'] = $this->fee->getFeeInfoByReceiptNum($row_id);
    //     $studentInfo =  $this->student->getStudentInfoByRowId($data['feeInfo']->application_no);
    //     $filter['fee_year'] = $data['feeInfo']->payment_year;
    //     $filter['stream_name'] = $studentInfo->stream_name;
    //     $filter['term_name'] = $data['feeInfo']->term_name;
    //     // $data['previousFeePaidInfo'] = $this->fee->getPreviousFeePaidInfo($row_id,$data['feeInfo']->application_no, $data['feeInfo']->payment_year);
    //     // log_message('debug','filter='.print_r($filter,true));
    //     $data['feeStructureInfo'] = $this->fee->getMgmtFeeStructureInfo($filter);
    //     $data['concession_amount'] = $this->fee->getFeeConcessionByAppNo($data['feeInfo']->application_no,$filter['fee_year']);
    //     //log_message('debug','feeStruct='.print_r($data['feeStructureInfo'],true));
    //     // $concession = $this->fee->getStudentFeeConcessionInfo($data['feeInfo']->rel_stud_row_id);
    //     $data['paidFeeSum'] = $this->fee->getSumOfFeesPaid($data['feeInfo']->application_no,$data['feeInfo']->payment_year);
    //     // $data['fee_concession'] = $concession->fee_amt;
    //     $data['studentInfo'] = $studentInfo;
    //     $data['staffName']  = $this->fee->getStaffNameById($data['feeInfo']->created_by);
    //     $data['paid_amount'] = $data['feeInfo']->paid_amount;
    //     $this->global['pageTitle'] = ''.TAB_TITLE.' : Fee Receipt';
    //     $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman', 'format' => [148, 210]]);
    //     $mpdf->AddPage('P','','','','',5,5,15,20,8,8);
    //     $mpdf->SetTitle('Fee Receipt');$data['paid_amount'] = $data['feeInfo']->paid_amount;
    //     // $html = $this->load->view('fees/feeReceiptPrint',$data,true);
    //     $data['paid_amount_words'] = $this->getIndianCurrency(floatval($data['paid_amount']));
    //     $data['name_count'] = 0;
    //     $html_student_copy = $this->load->view('fees/feeReceiptPrint',$data,true);
    //     $data['name_count'] = 1;
    //     $html_office_copy = $this->load->view('fees/feeReceiptPrint',$data,true);
    //     $mpdf->WriteHTML('<columns column-count="2" vAlign="J" column-gap="4" />');
    //     $mpdf->WriteHTML($html_student_copy);
    //     $mpdf->WriteHTML($html_office_copy);
    //     $mpdf->Output('Fee_Receipt.pdf', 'I');
    // }

    // public function feePaymentReceiptPrint($row_id){
    //     $filter = array();
    //     $data['feeInfo'] = $this->fee->getFeeInfoByReceiptNum($row_id);
    //     $studentInfo =  $this->student->getStudentInfoByRowId($data['feeInfo']->application_no);
    //     $filter['fee_year'] = $data['feeInfo']->payment_year;
    //     $filter['stream_name'] = $studentInfo->stream_name;
    //     $filter['term_name'] = $data['feeInfo']->term_name;
    //     // $data['previousFeePaidInfo'] = $this->fee->getPreviousFeePaidInfo($row_id,$data['feeInfo']->application_no, $data['feeInfo']->payment_year);
    //     // log_message('debug','filter='.print_r($filter,true));
    //     $data['feeStructureInfo'] = $this->fee->getMgmtFeeStructureInfo($filter);
    //     $data['concession_amount'] = $this->fee->getFeeConcessionByAppNo($data['feeInfo']->application_no,$filter['fee_year']);
    //     // $concession = $this->fee->getStudentFeeConcessionInfo($data['feeInfo']->rel_stud_row_id);
    //     $data['paidFeeSum'] = $this->fee->getSumOfFeesPaid($data['feeInfo']->application_no,$data['feeInfo']->payment_year);
    //     // $data['fee_concession'] = $concession->fee_amt;
    //     $data['studentInfo'] = $studentInfo;
    //     $data['staffName']  = $this->fee->getStaffNameById($data['feeInfo']->created_by);
    //     $data['paid_amount_words'] = $this->getIndianCurrency(floatval($data['feeInfo']->paid_amount));
    //     $data['previousFeePaidInfo'] = $this->fee->getPreviousFeesPaidInfo($row_id,$data['feeInfo']->application_no, $data['feeInfo']->payment_year);
    //     $this->global['pageTitle'] = ''.TAB_TITLE.' : Fee Receipt';
    //     $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman', 'format' => 'A4']);
    //     $mpdf->AddPage('P','','','','',7,7,7,7,8,8);
    //     $mpdf->SetTitle('Fee Receipt');
    //     $html = $this->load->view('fees/feeReceiptPrint',$data,true);
    //     $mpdf->WriteHTML($html);
    //     $mpdf->Output('Fee_Receipt.pdf', 'I');
    // }

    public function feePaymentReceiptPrint($row_id) {
        $filter = [];
        $data['feeInfo']  = $this->fee->getFeeInfoByReceiptNum($row_id);
        $studentInfo      = $this->student->getStudentInfoByRowId($data['feeInfo']->application_no);
        $filter['fee_year']    = $data['feeInfo']->payment_year;
        $filter['stream_name'] = $studentInfo->stream_name;
        $filter['term_name']   = $data['feeInfo']->term_name;
        $filter['gender'] = $studentInfo->gender;

        $filter['student_fee_type'] = 'REG';

        if($filter['term_name'] == 'II PUC'){
            if($studentInfo->intake_year_id == FEE_YEAR){
                $filter['student_fee_type'] = 'NEW';
            }else{
                $filter['student_fee_type'] = 'REG';
            }
        }
        /* ── Government fees ──────────────────────────────────────────── */
        $allGovFees      = $this->fee->getGovrnmentFeeStructureInfo($filter);
        $govTotal        = 0.0;
        $govPaidAmount   = 0.0;
        $govFeesWithPaid = [];          // only fees that were actually paid
        foreach ($allGovFees as $fee) {
            // Sum the full structure total regardless of payment
            $govTotal += floatval($fee->fee_amount_state_board);
            $paid = $this->fee->getFeeReceiptPrintNameInfo(
                $fee->type_id,
                $row_id,
                $data['feeInfo']->application_no
            );
            if (!empty($paid)) {
                $govPaidAmount      += floatval($paid->paid_amount);
                $govReceiptNo        = $paid->receipt_no;
                $govFeesWithPaid[]   = $fee;   // keep only paid rows for the view
            }
        }
        $showGovPage = $govPaidAmount > 0;
        /* ── Management fees ──────────────────────────────────────────── */
        log_message('debug', 'Getting management fee structure with filter: ' . print_r($filter, true));
        $allMgmtFees      = $this->fee->getMgmtFeeStructureInfo($filter);
        log_message('debug', 'All Mgmt Fees: ' . print_r($allMgmtFees, true));
        $mgmtTotal        = 0.0;
        $mgmtPaidAmount   = 0.0;
        $mgmtFeesWithPaid = [];         // only fees that were actually paid
        foreach ($allMgmtFees as $fee) {
            $mgmtTotal += floatval($fee->fee_amount_state_board);
            $paid = $this->fee->getFeeReceiptPrintNameInfo(
                $fee->type_id,
                $row_id,
                $data['feeInfo']->application_no
            );
            if (!empty($paid)) {
                $mgmtPaidAmount     += floatval($paid->paid_amount);
                $mgmtReceiptNo       = $paid->receipt_no;
                $mgmtFeesWithPaid[]  = $fee;
            }
        }
        $showMgmtPage = $mgmtPaidAmount > 0;
        /* ── Pending & grand total ────────────────────────────────────── */
        $govPending  = $govTotal  - $govPaidAmount;
        $mgmtPending = $mgmtTotal - $mgmtPaidAmount;
        $grandTotal  = $govPaidAmount + $mgmtPaidAmount;
        /* ── Pack data for the view ───────────────────────────────────── */
        $data['showGovPage']  = $showGovPage;
        $data['showMgmtPage'] = $showMgmtPage;
        $data['fee_model'] = $this->fee;
        // Pass ONLY the paid fee rows so the view loops over paid items only
        $data['governmentFeeStructureInfo'] = $govFeesWithPaid;
        $data['managementFeeStructureInfo'] = $mgmtFeesWithPaid;
        $data['govTotal']       = $govTotal;
        $data['govPaidAmount']  = $govPaidAmount;
        $data['govPending']     = $govPending;
        $data['govReceiptNo']   = $govReceiptNo;
        $data['mgmtTotal']      = $mgmtTotal;
        $data['mgmtPaidAmount'] = $mgmtPaidAmount;
        $data['mgmtPending']    = $mgmtPending;
        $data['mgmtReceiptNo']  = $mgmtReceiptNo;
        $data['grandTotal']     = $grandTotal;
        $data['row_id']         = $row_id;
        $data['studentInfo']    = $studentInfo;
        $data['concession_amount'] = $this->fee->getFeeConcessionByAppNo(
            $data['feeInfo']->application_no,
            $filter['fee_year']
        );
        $data['paidFeeSum'] = $this->fee->getSumOfFeesPaid(
            $data['feeInfo']->application_no,
            $data['feeInfo']->payment_year
        );
        $data['staffName'] = $this->fee->getStaffNameById($data['feeInfo']->created_by);
        $data['paid_amount_words_management'] = $this->getIndianCurrency($mgmtPaidAmount);
        $data['paid_amount_words_government'] = $this->getIndianCurrency($govPaidAmount);
        $data['paid_amount_words'] = $this->getIndianCurrency($grandTotal);
        $data['previousFeePaidInfo'] = $this->fee->getPreviousFeesPaidInfo(
            $row_id,
            $data['feeInfo']->application_no,
            $data['feeInfo']->payment_year
        );
        /* ── Generate PDF ─────────────────────────────────────────────── */
        $this->global['pageTitle'] = TAB_TITLE . ' : Fee Receipt';
        $mpdf = new \Mpdf\Mpdf([
            'default_font' => 'timesnewroman',
            'format'       => 'A5',
        ]);
        $mpdf->AddPage('P', '', '', '', '', 4, 4, 4, 4, 6, 6);
        $mpdf->SetTitle('Fee Receipt');
        $html = $this->load->view('fees/feeReceiptPrint', $data, true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Fee_Receipt.pdf', 'I');
    }

    public function deleteMgmtFeeReceipt(){
        if ($this->isAdmin() == true) {
            echo (json_encode(array('status' => 'access')));
        } else {
            $row_id = $this->input->post('row_id');
            $remark = $this->input->post('remark');
            $receiptInfo = array('is_deleted' => 1,
            'remarks' => $remark,
            'updated_by' => $this->staff_id,
            'updated_date_time' => date('Y-m-d h:i:s'));
            $Info =  array('is_deleted' => 1,
            'updated_by' => $this->staff_id,
            'updated_date_time' => date('Y-m-d h:i:s'));
            $this->fee->updateReceiptTable($row_id, $Info);
            $result = $this->fee->updateMgmtReceiptNo($row_id, $receiptInfo);
            if ($result > 0) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        }
    }
    
    public function deleteFeesReceipt(){
        if ($this->isAdmin() == true) {
            echo (json_encode(array('status' => 'access')));
        } else {
            $row_id = $this->input->post('row_id');
            $remark = $this->input->post('remark');
            $receiptInfo = array('is_deleted' => 1,
            'remarks' => $remark,
            'updated_by' => $this->staff_id,
            'updated_date_time' => date('Y-m-d h:i:s'));
            $result = $this->fee->updateReceiptNo($row_id, $receiptInfo);
            if($result > 0){
                $receipttblInfo = array('is_deleted' => 1,
                'updated_by' => $this->staff_id,
                'updated_date_time' => date('Y-m-d h:i:s'));
                $results = $this->fee->updateReceiptTable($row_id, $receipttblInfo);
            }
            if ($result > 0) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        }
    }

    public function updateFeeReceipt(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $pay_date = $this->security->xss_clean($this->input->post('pay_date'));
            $feeInfo = $this->fee->getFeeInfoByReceiptNum($row_id);
            $student_row_id = $feeInfo->application_no;
            $year = $feeInfo->payment_year;
            $overallFee = array(
                'payment_date' => date('Y-m-d',strtotime($pay_date)),
                'updated_by' => $this->staff_id,
                'updated_date_time' => date('Y-m-d H:i:s'));
            $receipt_number = $this->fee->updateReceiptNumber($overallFee,$row_id);
            if (!empty($receipt_number)) {
                $this->session->set_flashdata('success', 'Date updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Date update failed');
            }
        }
        $_SESSION["FEE_STUDENT_ID"] = $feeInfo->application_no;
        redirect('getStudentFeePaymentInfo');
    }

    public function updateDeptFeeReceipt(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('dept_row_id');
            $pay_date = $this->security->xss_clean($this->input->post('pay_dept_date'));
            $feeInfo = $this->fee->getFeeInfoByGovtReceiptNum($row_id);
            $student_row_id = $feeInfo->application_no;
            $year = $feeInfo->payment_year;
            $overallFee = array(
                'payment_date' => date('Y-m-d',strtotime($pay_date)),
                'updated_by' => $this->staff_id,
                'updated_date_time' => date('Y-m-d H:i:s'));
            $receipt_number = $this->fee->updateGovtReceiptNumber($overallFee,$row_id);
            $overallFee = array(
                'payment_date' => date('Y-m-d',strtotime($pay_date)),
                'updated_by' => $this->staff_id,
                'updated_date_time' => date('Y-m-d H:i:s'));
            $receipt_number = $this->fee->updateReceiptTable($row_id,$overallFee);
            if (!empty($receipt_number)) {
                $this->session->set_flashdata('success', 'Date updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Date update failed');
            }
        }
        $_SESSION["FEE_STUDENT_ID"] = $feeInfo->application_no;
        redirect('getStudentFeePaymentInfo');
    }

    public function miscellaneousFeeListing(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $intake_year = $this->security->xss_clean($this->input->post('intake_year'));
            $data['studentInfo'] = $this->student->getAllStudentsInfo();
            if(empty($intake_year)){
                $data['intake_year'] = CURRENT_YEAR;
                $filter['intake_year'] = CURRENT_YEAR;
            }else{
                $data['intake_year'] = $intake_year;
                $filter['intake_year'] = $intake_year;
            }
            $data['miscellaneousTypeInfo'] = $this->settings->getAllMiscellaneousTypeInfo();
            $data['feeYearInfo'] = $this->fee->getFeeYearInfo();
            // $data['streamInfo'] = $this->application->getStreamNames();
            $data['accessInfo'] = $this->getCurrentAccess();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Miscellaneous Fee';
            $this->loadViews("fees/miscellaneousFee.php", $this->global, $data, null);
        }
    }

   
public function addMiscellaneousPayment(){
    if($this->isAdmin() == TRUE)
    {
        $this->loadThis();
    } else {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('miscellaneous_type', 'MISCELLANEOUS', 'trim|required');
        if($this->form_validation->run() == FALSE)
        {
            redirect('miscellaneousFeeListing');  
        } else {
            $student_row_id = $this->security->xss_clean($this->input->post('stud_row_id'));
            $date = $this->security->xss_clean($this->input->post('date'));
            $miscellaneous_type = $this->security->xss_clean($this->input->post('miscellaneous_type'));
            $student_name = $this->security->xss_clean($this->input->post('student_name'));
            $course = $this->security->xss_clean($this->input->post('course'));
            $semester = $this->security->xss_clean($this->input->post('semester'));
            $student_status = $this->security->xss_clean($this->input->post('student_status'));
            $register_no = $this->security->xss_clean($this->input->post('register_no'));
            $quantity = $this->security->xss_clean($this->input->post('quantity'));
            $status = $this->security->xss_clean($this->input->post('status'));
            $amount = $this->security->xss_clean($this->input->post('amount'));
            $type = $this->security->xss_clean($this->input->post('type'));
            $ref_no = $this->security->xss_clean($this->input->post('ref_no'));
            $neft_ref_no = $this->security->xss_clean($this->input->post('neft_ref_no'));


             if($student_status == 'Active')
             {
                $studentDetails = $this->student->getStudentInfoById($student_row_id);
                //log_message('debug','student'.print_r($studentDetails,true));
                $stud_name = $studentDetails->student_name;
                $class  =   $studentDetails->term_name;
                $register_no =   $studentDetails->student_id;
                $section =   $studentDetails->section_name;
                $stream = $studentDetails->stream_name;

            }

            else   if($student_status == 'OLD')
            {
                $stud_name = $student_name;
                // $semester_name  =   $semester;
                // $course_name =   $course;
                // $register_no =   $register_no;
                // $section_name = '';
            }
            $lastReceiptNumber = $this->fee->getLastMisReceipt(CURRENT_YEAR);

            if(!empty($lastReceiptNumber)){
                $receipt_no = $lastReceiptNumber + 1;
            }else{
                $receipt_no = 1;
            }
            $receipt_no = sprintf("%04d",$receipt_no);

            // $amount = $this->fee->getFeeByMiscId($miscellaneous_type);
             
            $miscellaneousInfo = array(
                'receipt_no' => $receipt_no,
                'student_name' => $stud_name,
                'date'=> date('Y-m-d',strtotime($date)), 
                'created_by' => $this->staff_id, 
                'miscellaneous_type' => $miscellaneous_type,
                'amount'  => $amount,
                'year' => CURRENT_YEAR,
                'register_no' =>$register_no,
                'student_row_id' => $student_row_id,
                'student_status' =>$student_status,
                'qnty'       =>$quantity,
                'term' => $class,
                'stream' => $stream,
                'section_name' => $section,
                'total' => $amount * $quantity,
                'payment_status' => $status,
                'payment_type' => $type,
                'upi_ref_no' => $ref_no,
                'ref_number' => $neft_ref_no,
                // 'intake_year' => $intake_year,
                'created_date_time' => date('Y-m-d H:i:s'));
      
            $result = $this->fee->addMiscellaneousPayment($miscellaneousInfo);
        
            if($result>0){
                $this->session->set_flashdata('success', 'Added Miscellaneous Fee payment Successfully');
                redirect('miscellaneousFeeListing');
            } else {
                $this->session->set_flashdata('error', 'Failed to add Miscellaneous Fee payment');
                redirect('miscellaneousFeeListing');
            }
            
        }
    }
}

    
    public function getMiscellaneousFeeAmount(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $type_id = $this->input->post('type_id');
            //log_message('debug','id'.print_r($type_id,true));
            $amount = $this->fee->getFeeByMiscId($type_id);
            echo (json_encode(array('amount' => $amount->miscellaneous_amount)));
        }
    }



    public function getMiscellaneousFeeInfo(){
        if($this->isAdmin() == TRUE )
        {
            $this->loadThis();
        } else {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $data_array_new = [];
        $filter['intake_year'] = $this->security->xss_clean($this->input->post('intake_year'));
        $miscellaneousFeeInfo = $this->fee->getMiscellaneousFeesInfo($filter);
       // log_message('debug','mis'.print_r($miscellaneousFeeInfo,true));
        foreach($miscellaneousFeeInfo as $fee) {
            $checkbox="";
            $editButton = "";
            $infoButton = "";
            $deleteButton = "";
            $receipt= "";
            $approve="";
            $payButton="";
            if(empty($fee->qnty)){
                $total_amount =  $fee->amount;   
            }else {
            $total_amount = $fee->qnty * $fee->amount;
            }
            if($fee->bank_settlement_status == 1){
                $settlement = "<span style='color: green;'>Settled</span>";
            }else{
                $settlement = "<span style='color: red;'>Pending</span>";
            }
            
            if(date('d-m-Y',strtotime($fee->bank_settlement_date)) == '30-11--0001' || date('d-m-Y',strtotime($fee->bank_settlement_date)) == '01-01-1970' || $fee->bank_settlement_date == '0000-00-00'){
                $date = '';
            }else{
                $date = date('d-m-Y',strtotime($fee->bank_settlement_date));
            }
            $staffName = $this->fee->getStaffNameById($fee->created_by);
            $checkbox = '<input type="checkbox" class="singleSelect" value="'.$fee->row_id.'" />';
    
            // $infoButton = '<span><a href="#" title="Cashier Info : '. $staffName->name.'" data-toggle="popover" data-content="Name: '. $staffName->name.'"><span class="badge badge-primary"> <i class="fa fa-info-circle"></i></span></a></span>'; 
    
                    // $approve = '<a class="btn btn-xs p-2 btn-success approvePayment" href="#"
                    // data-row_id="'.$hostel->row_id.'" title="Approve"><i class="fas fa-thumbs-up"></i></a>';
                   if($this->role == ROLE_PRIMARY_ADMINISTRATOR || $this->role == ROLE_SUPER_ADMIN ||  $this->role == ROLE_ACCOUNT || $this->staff_id == '2034'){
                    $deleteButton = '<a class="btn btn-xs btn-danger deleteMiscellaneousFee" href="#"
                    data-row_id="'.$fee->row_id.'" title="Delete"><i class="fa fa-trash"></i></a>';
                   }
                    // $editButton = '<a class="btn btn-xs btn-primary"
                    // href="'.base_url().'editHostelPayment/'.$hostel->row_id.'" title="Edit"><i
                    // class="fas fa-pencil-alt"></i></a>';
                if($this->role != ROLE_AUDITOR ){
                  
                    $editButton = ' <a class="btn btn-xs btn-secondary" onclick="openModel('.$fee->row_id.',/'.date('d-m-Y', strtotime($fee->date)).'/)" title="Edit" href="#"><i class="fas fa-edit"></i>Edit</a>';
                }
            
                // $editButton = '<a class="btn btn-xs btn-primary"
                // href="'.base_url().'editHostelPayment/'.$hostel->row_id.'" title="Edit"><i
                // class="fas fa-pencil-alt"></i></a>';
               
                    $receipt = '<a class="btn btn-xs btn-primary" 
                    href="'.base_url().'miscellaneousReceiptPrint/'.$fee->row_id.'"
                            target="_blank" title="Receipt"><i class="material-icons">receipt</i></a>';
               
            $receipt_no = $fee->receipt_no;
                        
            
            $data_array_new[] = array(
               $checkbox,
                date('d-m-Y',strtotime($fee->date)),
                $fee->register_no,
                $receipt_no,
                strtoupper($fee->student_name),
                strtoupper($fee->miscellaneous_type),
                // $fee->amount,
                // $fee->qnty,
                $total_amount,
                $fee->payment_type,
                $settlement,
                $date,
                $deleteButton.' '.$editButton.' '.$approve.' '.$receipt.' '.$payButton 
                );
            }
        $count = count($miscellaneousFeeInfo);
            $result = array(
                "draw" => $draw,
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                "data" => $data_array_new
            );
        echo json_encode($result);
        exit();
        }
    }

    public function updateMiscFeeReceipt(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $pay_date = $this->security->xss_clean($this->input->post('pay_date'));
            $feeInfo = $this->fee->getMiscFeeInfoByReceiptNum($row_id);
            $student_row_id = $feeInfo->student_row_id;
            $year = $feeInfo->year;
            $overallFee = array(
                'date' => date('Y-m-d',strtotime($pay_date)),
                'updated_by' => $this->staff_id,
                'updated_date_time' => date('Y-m-d H:i:s'));

        $receipt_number = $this->fee->updateMiscReceiptNumber($overallFee,$row_id);
            if (!empty($receipt_number)) {
                $this->session->set_flashdata('success', 'Miscellaneous Fee updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Miscellaneous Fee update failed');
            }
        }
     
        redirect('miscellaneousFeeListing');
    }

    public function deleteMiscellaneousFee(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $miscellaneousInfo = array('is_deleted' => 1,'updated_date_time' => date('Y-m-d H:i:s'),'updated_by'=>$this->staff_id);
            $result = $this->fee->updateMiscellaneousFee($miscellaneousInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        }
    }

    public function miscellaneousReceiptPrint($row_id){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            error_reporting(0);
            $filter = array();
            $data['miscellaneousInfo'] = $this->fee->getMiscellaneousFeesInfoById($row_id);
            $data['staffName']  = $this->fee->getStaffNameById($data['miscellaneousInfo']->created_by);

            $this->global['pageTitle'] = ''.TAB_TITLE.' : Fee Receipt';
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman', 'format' => [148, 210]]);
            $mpdf->AddPage('P','','','','',10,10,13,35,8,8);
            // $mpdf->SetTitle('Fee Receipt');
            // $html = $this->load->view('fees/miscellaneousReceiptPrint',$data,true);
            // $mpdf->WriteHTML($html);
            // $mpdf->Output('Fee_Receipt.pdf', 'I');

            $mpdf->SetTitle('Fee Receipt');$data['paid_amount'] = $data['miscellaneousInfo']->amount;
            // $html = $this->load->view('fees/feeReceiptPrint',$data,true);
            $data['paid_amount_words'] = $this->getIndianCurrency(floatval($data['paid_amount']));
            $data['name_count'] = 0;
            $html_student_copy = $this->load->view('fees/miscellaneousReceiptPrint',$data,true);
            $data['name_count'] = 1;
            $html_office_copy = $this->load->view('fees/miscellaneousReceiptPrint',$data,true);
           
            
            $mpdf->WriteHTML('<columns column-count="2" vAlign="J" column-gap="4" />');
            $mpdf->WriteHTML($html_student_copy);
            $mpdf->WriteHTML($html_office_copy);
           
            $mpdf->Output('Fee_Receipt.pdf', 'I');
        } 
    }

    public function refundReceiptPrint($row_id){
        $filter = array();
        $data['feeInfo'] = $this->fee->getRefundInfoByRowId($row_id);
        $data['studentInfo'] = $studentInfo = $this->student->getStudentInfoByRowId($data['feeInfo']->std_row_id);
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Fee Receipt';
        $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman', 'format' => 'A5-L']);
        $mpdf->AddPage('L','','','','',10,10,8,8,8,8);
        $mpdf->SetTitle('Fee Receipt');
        $html = $this->load->view('fees/refundReceiptPrint',$data,true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Fee_Receipt.pdf', 'I');
    }


    public function refundFeeReceipt(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $refund_amt = $this->security->xss_clean($this->input->post('refund_amt'));
            $feeInfo = $this->fee->getFeeInfoByRowId($row_id);
            
            $overallFee = array(
                'refund_amt' => $refund_amt    
            );
            $this->fee->updatedOverallPayment($overallFee,$row_id);
            
            $refundFee = array(
                'overall_id' => $row_id,
                'refund_amt' => $refund_amt,
                'std_row_id' => $feeInfo->application_no,
                'payment_year' => $feeInfo->payment_year,
                'refund_recptno' => $feeInfo->receipt_number,
                'created_date_time' => date('Y-m-d H:i:s'),
                'created_by' => $this->staff_id);
            
            $result = $this->fee->addRefundInfo($refundFee);
            if ($result) {
                $stdInfo = array(
                    'is_active' => 0,
                    'updated_by' => $this->staff_id,
                    'updated_date_time' => date('Y-m-d H:i:s')
                ); 
                $this->student->updateStudentInfo($stdInfo,$feeInfo->application_no);
                $this->session->set_flashdata('success', 'Refund added successfully');
            } else {
                $this->session->set_flashdata('error', 'Refund failed');
            }
        }
        $_SESSION["FEE_STUDENT_ID"] = $feeInfo->application_no;
        redirect('getNewStudentFeePaymentInfo');
    }

    public function deleteRefund(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $refInfo = $this->fee->getRefundInfoByRowId($row_id);
            $overallFee = array(
                'refund_amt' => 0,
            );
            $res = $this->fee->updatedOverallPayment($overallFee,$refInfo->overall_id);
            $upInfo = array(
                'is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id,
            );
            $result = $this->fee->updateRefundInfo($upInfo,$row_id);
            if ($result == true) {
                echo (json_encode(array('status' => true)));
            } else {
                echo (json_encode(array('status' => false)));
            }
        } 
    }

    public function payNowRedirect($student_row_id){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $filter = array();
            $_SESSION["FEE_STUDENT_ID"] = $student_row_id;
            redirect('getStudentFeePaymentInfo');
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


    
    function viewManagementFeeCancelledInfo()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
            $filter = array();
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $student_name = $this->security->xss_clean($this->input->post('student_name'));
            $application_no = $this->security->xss_clean($this->input->post('application_no'));
            $date_select = $this->security->xss_clean($this->input->post('date_select'));
            $receipt_number = $this->security->xss_clean($this->input->post('receipt_number'));
            $amount_paid = $this->security->xss_clean($this->input->post('amount_paid'));
            $amount_pending = $this->security->xss_clean($this->input->post('amount_pending'));
            $reference_number = $this->security->xss_clean($this->input->post('reference_number'));
            $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
            $fee_type = $this->security->xss_clean($this->input->post('fee_type'));
            $bank_settlement = $this->security->xss_clean($this->input->post('bank_settlement'));
            $by_bank_date = $this->security->xss_clean($this->input->post('by_bank_date'));
            $year = $this->security->xss_clean($this->input->post('year'));
            $remarks = $this->security->xss_clean($this->input->post('remarks'));
            $created_by = $this->security->xss_clean($this->input->post('created_by'));
            $created_date_time = $this->security->xss_clean($this->input->post('created_date_time'));
            $by_term = $this->security->xss_clean($this->input->post('by_term'));
            $searchText = "";

            if($year == '2024'){
                $data['year'] = '2024-25';
                $filter['by_year'] = $year;
            }else if($year == '2025'){
                $data['year'] = '2025-26';
                $filter['by_year'] = $year;
            }
            // $data['year'] = $filter['by_year'] = $year;
            $data['by_term'] = $filter['by_term'] = $by_term;
            if(!empty($application_no)){
                $filter['application_no'] = $application_no;
                $data['application_no'] = $application_no;
            }else{
                $data['application_no'] = '';
            }
            if(!empty($student_id)){
                $filter['student_id'] = $student_id;
                $data['student_id'] = $student_id;
            }else{
                $data['student_id'] = '';
            }
            if(!empty($student_name)){
                $filter['student_name'] = $student_name;
                $data['student_name'] = $student_name;
            }else{
                $data['student_name'] = '';
            }
            if(!empty($remarks)){
                $filter['remarks'] = $remarks;
                $data['remarks'] = $remarks;
            }else{
                $data['remarks'] = '';
            }
            if(!empty($date_select)){
                $filter['date_select'] = date('Y-m-d',strtotime($date_select));
                $data['date_select'] = date('d-m-Y',strtotime($date_select));;
            }else{
                $data['date_select'] = '';
            }
            if(!empty($receipt_number)){
                $filter['receipt_number'] = $receipt_number;
                $data['receipt_number'] = $receipt_number;
            }else{
                $data['receipt_number'] = '';
            }
            if(!empty($amount_paid)){
                $filter['amount_paid'] = $amount_paid;
                $data['amount_paid'] = $amount_paid;
            }else{
                $data['amount_paid'] = '';
            }
            if(!empty($amount_pending)){
                $filter['amount_pending'] = $amount_pending;
                $data['amount_pending'] = $amount_pending;
            }else{
                $data['amount_pending'] = '';
            } 
            if(!empty($reference_number)){
                $filter['order_id'] = $reference_number;
                $data['order_id'] = $reference_number;
            }else{
                $data['order_id'] = '';
            } 
            if(!empty($payment_type)){
                $filter['payment_type'] = $payment_type;
                $data['payment_type'] = $payment_type;
            }else{
                $data['payment_type'] = '';
            } 
         
      
            if($bank_settlement == 'Pending'){
                $filter['bank_settlement'] = 'Pending';;
                $data['bank_settlement'] = 'Pending';
            }else if($bank_settlement == 'Settled'){
                $data['bank_settlement'] = 'Settled';
                $filter['bank_settlement'] = 'Settled';
            }else{
                $data['bank_settlement'] = 'Settled';
                $filter['bank_settlement'] = 1;
            }
            // log_message('debug','fff=='.print_r($feeStructure,true));
            
            if(!empty($by_bank_date)){
                $filter['by_bank_date'] = date('Y-m-d',strtotime($by_bank_date));
                $data['by_bank_date'] = date('d-m-Y',strtotime($by_bank_date));;
            }else{
                $data['by_bank_date'] = '';
            }
            if(!empty($created_date_time)){
                $filter['created_date_time'] = date('Y-m-d',strtotime($created_date_time));
                $data['created_date_time'] = date('d-m-Y',strtotime($created_date_time));
            }else{
                $data['created_date_time'] = '';
            }
            $data['created_by'] = $created_by;
            $filter['created_by'] = $created_by;

            
            $this->load->library('pagination');
            $count = $this->fee->getAllFeePaymentInfoCountnew($filter);
            $returns = $this->paginationCompress("ManagementFeeCancelledInfo/", $count, 100 );
            $data['online_pay_count'] = $count;
            $data['feePaidInfo'] = $this->fee->getAllFeePaymentInfonew( $returns["page"], $returns["segment"], $filter);
            
            // $data['feePaidStdInfo'] = $this->account->getFeePaidStudentInfo();
            // log_message('debug','jbcdbc'.print_r($data['onlineFeeInfo'],true));
            $this->global['pageTitle'] = ''.TAB_TITLE.' :Fee Paid Details';
            $data['orderIDInfo'] = $this->fee->getReAdmUnProcessedOrderID();
            $data['neworderIDInfo'] = $this->fee->getNewAdmUnProcessedOrderID();
            $this->loadViews("fees/ManagementFeeCancelledInfo", $this->global, $data, NULL);
        }
    }

    
    function viewDepartmentFeeCancelledInfo()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
            $filter = array();
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $date_select = $this->security->xss_clean($this->input->post('date_select'));
            $receipt_number = $this->security->xss_clean($this->input->post('receipt_number'));
            $amount_paid = $this->security->xss_clean($this->input->post('amount_paid'));
            $amount_pending = $this->security->xss_clean($this->input->post('amount_pending'));
            $reference_number = $this->security->xss_clean($this->input->post('reference_number'));
            $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
            $bank_settlement = $this->security->xss_clean($this->input->post('bank_settlement'));
            $by_bank_date = $this->security->xss_clean($this->input->post('by_bank_date'));
            $student_name = $this->security->xss_clean($this->input->post('student_name'));
            $remarks = $this->security->xss_clean($this->input->post('remarks'));
            $created_by = $this->security->xss_clean($this->input->post('created_by'));
            $created_date_time = $this->security->xss_clean($this->input->post('created_date_time'));
            $filter['by_type'] = $data['by_type'] = $type = $this->input->post('by_type');
            $filter['by_term'] = $data['by_term'] = $by_term = $this->input->post('by_term');
            $data['year'] = $filter['by_year'] = $this->security->xss_clean($this->input->post('by_year'));
            $data['created_by'] = $created_by;
            $filter['created_by'] = $created_by;
            if(empty($type)){
                $filter['by_type'] = $data['by_type'] = 'Processed';
            }
            
            $searchText = "";
            if(!empty($student_id)){
                $filter['student_id'] = $student_id;
                $data['student_id'] = $student_id;
            }else{
                $data['student_id'] = '';
            }
            if(!empty($date_select)){
                $filter['date_select'] = date('Y-m-d',strtotime($date_select));
                $data['date_select'] = date('d-m-Y',strtotime($date_select));
            }else{
                $data['date_select'] = '';
            }
            if(!empty($receipt_number)){
                $filter['receipt_number'] = $receipt_number;
                $data['receipt_number'] = $receipt_number;
            }else{
                $data['receipt_number'] = '';
            }
            if(!empty($remarks)){
                $filter['remarks'] = $remarks;
                $data['remarks'] = $remarks;
            }else{
                $data['remarks'] = '';
            }
            if(!empty($amount_paid)){
                $filter['amount_paid'] = $amount_paid;
                $data['amount_paid'] = $amount_paid;
            }else{
                $data['amount_paid'] = '';
            }
            if(!empty($amount_pending)){
                $filter['amount_pending'] = $amount_pending;
                $data['amount_pending'] = $amount_pending;
            }else{
                $data['amount_pending'] = '';
            } 
            if(!empty($reference_number)){
                $filter['order_id'] = $reference_number;
                $data['order_id'] = $reference_number;
            }else{
                $data['order_id'] = '';
            } 
            if(!empty($payment_type)){
                $filter['payment_type'] = $payment_type;
                $data['payment_type'] = $payment_type;
            }else{
                $data['payment_type'] = '';
            } 
            if($bank_settlement == 'Pending'){
                $filter['bank_settlement'] = 'Pending';
                $data['bank_settlement'] = 'Pending';
            }else if($bank_settlement == 'Settled'){
                $data['bank_settlement'] = 'Settled';
                $filter['bank_settlement'] = 'Settled';
            }else{
                $data['bank_settlement'] = 'Settled';
                $filter['bank_settlement'] = 1;
            }
            if(!empty($created_date_time)){
                $filter['created_date_time'] = date('Y-m-d',strtotime($created_date_time));
                $data['created_date_time'] = date('d-m-Y',strtotime($created_date_time));
            }else{
                $data['created_date_time'] = '';
            }
            // log_message('debug','fff=='.$filter['bank_settlement']);
            
            if(!empty($by_bank_date)){
                $filter['by_bank_date'] = date('Y-m-d',strtotime($by_bank_date));
                $data['by_bank_date'] = date('d-m-Y',strtotime($by_bank_date));
            }else{
                $data['by_bank_date'] = '';
            }
            if(!empty($student_name)){
                $filter['student_name'] = $student_name;
                $data['student_name'] = $student_name;
            }else{
                $data['student_name'] = '';
            }

             
            
            $this->load->library('pagination');
            $count = $this->fee->getGovtFeePaymentInfoCountnew($filter);
            $returns = $this->paginationCompress("DepartmentFeeCancelledInfo/", $count, 100 );
            $data['online_pay_count'] = $count;
            $data['onlineFeeInfo'] = $this->fee->getGovtFeePaymentInfonew( $returns["page"], $returns["segment"], $filter);
            $this->global['pageTitle'] = ''.TAB_TITLE.' :Online Fee Paid Details';
            $this->loadViews("fees/DepartmentFeeCancelledInfo", $this->global, $data, NULL);
        }
    }
    
    public function newSpecialFeePaymentReceiptPrint($receipt_number)
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $term_name = str_replace('_', ' ', $term_name);

            $feeInfo     = $this->fee->getFeeInfoByReceiptNum($receipt_number);
            $studentInfo = $this->student->getStudentInfoByRowId($feeInfo->application_no);

            $term        = $studentInfo->term_name;
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

            $stream = trim($studentInfo->stream_name);
            // log_message('debug','spclFeeInfo----->'.print_r($spclFeeInfo,true));
            // log_message('debug','stream----->'.print_r($stream,true));

            // ── Aided logic (kept — needed to pick PCMB_A vs PCMB column) ────
            // if ($studentInfo->second_language == 'KANNADA' && $stream == 'PCMB') {
            //     $aided = 'YES';
            // } else if (in_array($stream, ['HEPP', 'BEBA', 'HsEPP'])) {
            //     $aided = 'YES';
            // } else if (!empty($studentInfo->aided) && $studentInfo->aided == 'YES') {
            //     $aided = 'YES';
            // } else {
            //     $aided = 'NO';
            // }

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

                $fee_name =  $spcl->fee_name;
                $fee_name = htmlspecialchars($fee_name, ENT_QUOTES, 'UTF-8');

                $fee_rows[] = [
                    'name'   => $fee_name,
                    'amount' => $amount,
                ];
            }

            // // ── REG/APP NO ────────────────────────────────────────────────────
            // if ($term == 'II PUC') {
            //     $student_reg_no = $studentInfo->student_id;
            // } else {
            //     $IPUCstudentID  = $this->student->getStudentInfoBy_AppNo($feeInfo->application_no);
            //     $student_reg_no = $IPUCstudentID->student_id;
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
                'aided'             => $aided,
                'fee_rows'          => $fee_rows,
                'total_fee_amt'     => $total_fee_amt,
                'paid_amount_words' => $paid_amount_words,
                'application_no'    => $application_no,
                'student_reg_no'    => $student_reg_no,
                'staffName'         => $this->fee->getStaffNameById($feeInfo->created_by),
            ];

            $this->global['pageTitle'] = TAB_TITLE . ' : Special Fee Receipt';
            $mpdf = new \Mpdf\Mpdf([
                'default_font' => 'timesnewroman',
                'format'       => 'A5',
            ]);
            $mpdf->AddPage('P', '', '', '', '', 4, 4, 4, 4, 6, 6);
            $mpdf->SetTitle('Special Fee Receipt');
            $html = $this->load->view('fees/specialFeeReceiptPrint', $data, true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('Special_Fee_Receipt.pdf', 'I');
        }
    }

    public function annualFeesPayment(){

        $student_id = $this->security->xss_clean($this->input->post('student_id'));
        $pay_amount = $this->security->xss_clean($this->input->post('pay_amount'));
        $filter = array(); 
        
        $remarks = 'Fees '.$event_year;

        $studentInfo = $this->student->getStudentInfoByRowId($student_id);

        $filter['fee_year'] = trim($studentInfo->intake_year_id);
        $term_name = $studentInfo->term_name;

        $filter['stream_name'] = $studentInfo->stream_name;
        $filter['gender'] = $studentInfo->gender;

        $application_no = $student_id;
        $TXN_AMOUNT = $pay_amount.'.00';


            if($term_name == 'I PUC'){

                $filter['term_name'] = $term_name;
                $filter['fee_year'] = $studentInfo->intake_year_id;
                $filter['student_fee_type'] = 'REG';
                //  if(empty($studentInfo->student_category)){
                //     $filter['student_category'] = 'Regular';
                // } else {
                //     $filter['student_category'] = $studentInfo->student_category;
                // }
                $total_fee_obj = $this->fee->getTotalFeeAmount($filter);
                $govt_fee = $this->fee->getGovtFeeAmount($filter);
                $category_fee = 0;

                // if($filter['student_category'] != 'Regular'){
                //     $category_fee = $this->fee->getCategoryFeeAmount($filter);
                // }
                $total_fee_amount = $total_fee_obj->total_fee + $govt_fee + $category_fee;
                $concession_amt = $this->fee->getFeeConcessionByAppNo($application_no,$filter['fee_year']);
                $paidFee = $this->fee->getTotalFeePaidInfo($application_no,$filter['fee_year']);
                $total_fee_amount -= $paidFee;
                $total_fee = $total_fee_amount - $concession_amt;

                
            }else{                
                        
                $filter['stream_name'] = $studentInfo->stream_name;
                $filter['term_name'] = 'II PUC';
                if($studentInfo->intake_year_id == FEE_YEAR){
                    $filter['fee_year'] = trim($studentInfo->intake_year_id);
                }else{
                    $filter['fee_year'] = trim($studentInfo->intake_year_id)+1;
                }
                if($studentInfo->intake_year_id == FEE_YEAR){
                    $filter['student_fee_type'] = 'NEW';
                }else{
                    $filter['student_fee_type'] = 'REG';
                }
                $total_fee_obj = $this->fee->getTotalFeeAmount($filter);
                $govt_fee = $this->fee->getGovtFeeAmount($filter);
                $total_fee_amount = $total_fee_obj->total_fee + $govt_fee;

                $concession_amt = $this->fee->getFeeConcessionByAppNo($application_no,$filter['fee_year']);
                $paidFee = $this->fee->getTotalFeePaidInfo($application_no,$filter['fee_year']);
                $total_fee_amount -= $paidFee;
                $total_fee = $total_fee_amount - $concession_amt;

            }

            log_message('debug','total_fee_amount--->'.print_r($total_fee,true));
                 
                
       
            $total_fee_amount_pending = $total_fee;
        
     //log_message('debug','studentInfo--->'.print_r($studentInfo,true));
        $fee_amount = $total_fee_amount_pending;

        $paramList = array();
        $TXN_AMOUNT = $pay_amount;
        $CONTRIBUTION_FEE = 0;
        $SCHOOL_AMOUNT = 0;
        $feeStructInfo = $this->fee->getTotalFeeAccountAmount($filter);
            $remaining_fee_amt = $TXN_AMOUNT;
            $fee_names = [];
            foreach($feeStructInfo as $fee){
                        $db_save_status = false;
                        $fee_structure_amt = $fee->fee_amount_state_board;

                        // $structure_total = (float)$fee->fee_amount_state_board;
                        // if($structure_total < 0) $structure_total = 0;
                        // $isAlreadyPaid = $this->fee->checkFeeTypeIsAlreadyPaid($application_no, $fee->fee_division_id);
                        // // initialize values
                        // $paid_amt = 0;
                        // $pending_amt = 0;
                        // $fee_pending_status = 1; // default pending

                        // // 1) If there's an existing paid record with pending > 0, pay that pending first
                        // if(!empty($isAlreadyPaid) && (float)$isAlreadyPaid->pending_amt > 0){
                        //     $existing_pending = (float)$isAlreadyPaid->pending_amt;
                        //     // pay as much as available
                        //     $to_pay = min($remaining_fee_amt, $existing_pending);
                        //     $paid_amt = $to_pay;
                        //     $pending_after = $existing_pending - $to_pay;
                        //     $pending_amt = $pending_after;
                        //     $fee_pending_status = ($pending_after > 0) ? 1 : 0;
                        //     // decrease remaining amount available to allocate
                        //     $remaining_fee_amt -= $to_pay;
                        //     // Save/update record (we insert a new row for this receipt allocation)
                        //     $db_save_status = true;
                        // }

                        // // 2) If there's no existing pending (or after clearing existing pending we still have money), apply to whole structure amount
                        // if($remaining_fee_amt > 0){
                        //     $isAlreadyPaidTotal = $this->fee->checkFeeTypeTotalPaid($application_no, $fee->fee_division_id);

                        //     // Need to compute how much of structure_total is already paid historically (if any)
                        //     $already_paid_total = (!empty($isAlreadyPaid)) ? (float)$isAlreadyPaidTotal->total_paid : 0;
                        //     // Remaining due for this fee structure = structure_total - already_paid_total
                        //     $due_for_structure = $structure_total - $already_paid_total;
                        //     if($due_for_structure < 0) $due_for_structure = 0;
                        //     if($due_for_structure > 0){
                        //         $to_pay2 = min($remaining_fee_amt, $due_for_structure);
                        //         // If we already set $paid_amt above (clearing existing pending), add to it; else set it.
                        //         $paid_amt = isset($paid_amt) ? ($paid_amt + $to_pay2) : $to_pay2;
                        //         $pending_after_structure = $due_for_structure - $to_pay2;
                        //         // total pending for this fee should consider any leftover pending from earlier + structure pending
                        //         // But since above we cleared existing pending first, now pending_after_structure is final pending
                        //         $pending_amt = $pending_after_structure;
                        //         $fee_pending_status = ($pending_after_structure > 0) ? 1 : 0;
                        //         $remaining_fee_amt -= $to_pay2;
                        //         $db_save_status = true;
                        //     } else {
                        //         // nothing due left for structure (already fully paid historically)
                        //         // if no prior pending and no due, do nothing
                        //         // $paid_amt remains whatever was set earlier (maybe 0)
                        //     }
                        // }

                        $structure_total = (float)$fee->fee_amount_state_board;
                        if($structure_total < 0){
                            $structure_total = 0;
                        }
                        // initialize values
                        $paid_amt = 0;
                        $pending_amt = 0;
                        $fee_pending_status = 1;
                        $db_save_status = false;
                        // already paid info
                        $AlreadyPaidInfo = $this->fee->checkFeeTypeTotalPaid($application_no, $fee->fee_division_id);
                        if(!empty($AlreadyPaidInfo->total_paid)){
                            $already_paid_total =  (float)$AlreadyPaidInfo->total_paid; 
                        }else{
                            $already_paid_total =  0; 
                        }
                        // calculate actual pending
                        $pending_balance = $structure_total - $already_paid_total;

                        if($pending_balance < 0){
                            $pending_balance = 0;
                        }
                        if($remaining_fee_amt > 0 && $pending_balance > 0){
                            // amount to pay now
                            $paid_amt = min($remaining_fee_amt, $pending_balance);
                            // remaining pending after this payment
                            $pending_amt = $pending_balance - $paid_amt;
                            // pending status
                            if(!empty($pending_amt > 0)){
                                $fee_pending_status =  1; 
                            }else{
                                $fee_pending_status =  0; 
                            }
                            // reduce remaining amount
                            $remaining_fee_amt -= $paid_amt;
                            $db_save_status = true;
                        }

                // if (!in_array($fee->fee_name, $fee_names)) {
                //     $fee_names[] = $fee->fee_name;
                // }

                if (trim($fee->fee_type_name) == 'Contribution Fees') {
                    // log_message('debug', 'Annual Day Charges: ' . $paid_amt);
                    $CONTRIBUTION_FEE += $paid_amt;
                    // $SCHOOL_AMOUNT += $paid_amt;
                } else {
                    $SCHOOL_AMOUNT += $paid_amt;
                }
            }
       
         
        
         if (!empty($studentInfo->father_mobile)) {
            $phone = $studentInfo->father_mobile;
        } else if(!empty($studentInfo->mother_mobile)) {
            $phone = $studentInfo->mother_mobile;
        }else{
            $phone = '9999999999';
        }

        
            $cleaned_student_name = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $studentInfo->student_name));
            $email = $cleaned_student_name . '@annes.com';
        
            $payInfo = array(
                'm_id' =>EB_MERCHANT_KEY,
                'registered_tbl_row_id' => $student_id,
                'amount' => $pay_amount,
                'application_no' => $student_id,
                'payment_year' => $filter['fee_year'],
                'created_by' => $studentInfo->row_id,
                'phone' =>$phone,
                'email' =>$email,
                //  'pickup_id' => $pickup_id,
                'created_date_time' => date('Y-m-d H:i:s')
            );

          $response = $this->fee->addFeePaymentLog($payInfo);
        if($response > 0){

            $microtime = microtime(true);
            $currentDate = date('Ymd'); // Format current date as YYYYMMDD
            // Extract minutes, seconds, and milliseconds
            $minutes = (int)date('i', $microtime);
            $seconds = (int)date('s', $microtime);
            $milliseconds = (int)(($microtime - floor($microtime)) * 1000);
            // Combine current date, minutes, seconds, and milliseconds into a single string
            $timeString = sprintf('%s%02d%02d%03d', $currentDate, $minutes, $seconds, $milliseconds);
            $ORDER_ID = '26FEE_'.$timeString.$response;
            $payInfo = array('order_id' =>$ORDER_ID);
            $this->fee->updateFeePaymentLog($response, $payInfo);
            $_SESSION['order_id'] = $ORDER_ID;

            if (!empty($studentInfo->father_mobile)) {
                $phone = $studentInfo->father_mobile;
            } else if(!empty($studentInfo->mother_mobile)) {
                $phone = $studentInfo->mother_mobile;
            }else{
                $phone = '9999999999';
            }
 
            // if(!empty($studentInfo->email)){
            //     $email=$studentInfo->email;
            // }else{
            $cleaned_student_name = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $studentInfo->student_name));
            // Create email using the cleaned student name
            $email = $cleaned_student_name . '@annes.com';


            $TXN_AMOUNT = number_format($pay_amount, 2, '.', '');
        
            $paramList["txnid"] = $ORDER_ID;
            $paramList["amount"] =$TXN_AMOUNT;
            $paramList["firstname"] = $cleaned_student_name;
            $paramList["email"] = $email;
            $paramList["phone"] = $phone;
            $paramList["productinfo"] = 'ANNUAL PAYMENT';
        
            $paramList["surl"] = base_url()."annualFeeResponse";
            $paramList["furl"] = base_url()."annualFeeResponse";
            $paramList["udf1"] = $cleaned_student_name;
            $paramList["udf2"] = $studentInfo->term_name;
            $paramList["udf3"] = $student_id;
            $paramList["udf4"] = $filter['fee_year'];

            log_message('debug','CONTRIBUTION_FEE=='.print_r($CONTRIBUTION_FEE,true));
            log_message('debug','SCHOOL_AMOUNT=='.print_r($SCHOOL_AMOUNT,true));
            $splitPayments = array(
                'SOCIETY ACCOUNT' => $CONTRIBUTION_FEE, //COLLEGE FEE uKNZpbCB039682090340
                'COLLEGE ACCOUNT' => $SCHOOL_AMOUNT, //COLLEGE FEE uKNZpbCB039682090340
            );
            

            if(EB_ENV == 'prod'){
                $paramList["split_payments"] = json_encode($splitPayments);
            }
            $data['paramList'] = $paramList;
            log_message('debug', 'Easebuzz API Request Params: ' . print_r($paramList, true));
        
            $easebuzzObj = new Easebuzz(EB_MERCHANT_KEY, EB_SALT, EB_ENV);
            $result = $easebuzzObj->initiatePaymentAPI($paramList);
            log_message('debug', 'Easebuzz API Response: ' . print_r($result, true));
            easebuzzAPIResponse($result);
            }
       
     }
    public function annualFeeResponse(){

        $row_id = $_POST['udf3'] ?? '';
        $year = $_POST['udf4'] ?? '';

        $filter = array();
        $studentInfo = $this->student->getStudentInfoByRowId($row_id);
       
        $application_no = $row_id;
            
        $paid_fee_amount = $_POST['amount'];

        if($_POST['status'] == 'success'){

            $isExistOrderID = $this->fee->checkOrderIdExistsInFeePayment($_POST['txnid']);
            if(empty($isExistOrderID)){ 
            $paid_fee_amount = $_POST['amount'];
            
            $filter['fee_year'] = $studentInfo->intake_year_id;
            $term_name = $studentInfo->term_name;
           

            if($term_name == 'II PUC'){
                if($studentInfo->intake_year_id == FEE_YEAR){
                    $filter['fee_year'] = trim($studentInfo->intake_year_id);
                    $filter['student_fee_type'] = 'NEW';
                }else{
                    $filter['fee_year'] = trim($studentInfo->intake_year_id)+1;
                    $filter['student_fee_type'] = 'REG';

                }
            }else{
                $filter['student_fee_type'] = 'REG';
            }
            $filter['term_name'] = $term_name;
            $filter['stream_name'] = $studentInfo->stream_name;
            $filter['gender'] = $studentInfo->gender;
            
            $total_fee = $this->fee->getTotalFeeAmount($filter);
            $depart_fee = $this->fee->getGovtFeeAmount($filter);
            $category_fee = 0;

            // if($filter['student_category'] != 'Regular'){
            //     $category_fee = $this->fee->getCategoryFeeAmount($filter);
            //     // $data['category_fee'] = $category_fee;
            // }
            // $feeStructureInfo = $this->fee->getFeeStructureInfo($filter);
            $total_fee_to_pay = $total_fee->total_fee + $depart_fee + $category_fee; //- $depart_fee;
            // log_message('debug','total_fee_to_pay='.print_r($total_fee_to_pay,true));
            $data['feePaidInfo'] = $this->fee->getFeePaidInfo($application_no,$filter['fee_year']);
            if(!empty($data['feePaidInfo'])){
                foreach($data['feePaidInfo'] as $fee){
                    $total_fee_to_pay = $total_fee_to_pay - $fee->paid_amount;
                }
            }
            $concession = 0; 
            $concession_amt = $this->fee->getFeeConcessionByAppNo($application_no,$filter['fee_year']);
            if($concession_amt>0){
                $concession = $concession_amt;
                $total_fee_to_pay -= $concession;
            }

            $remaining_fee_amt = $paid_fee_amount;
            $feePaymentInfo = $this->fee->getStdLastPaidDetailsByApplicationNo($application_no,$filter['fee_year']);
            if(empty($feePaymentInfo)){
                $paid_count = 1;
                //$paid_fee_amount -= $depart_fee;
            }else{
                $paid_count = $feePaymentInfo->payment_count+1;
            }

            $pending_fee_balance = $total_fee_to_pay - $paid_fee_amount;
            if($pending_fee_balance <= 0){
                $fee_excess_amount = abs($pending_fee_balance);
                $fee_pending_status = 0;
                $pending_fee_balance = 0;
            }else if($pending_fee_balance > 0){
                $fee_excess_amount = 0;
                $fee_pending_status = 1;
            }

            $lastReceiptInfo = $this->fee->getLastReceiptNoNew($filter['fee_year']);
            if(!empty($lastReceiptInfo->receipt_number)){
                $receipt_no_new = $lastReceiptInfo->receipt_number + 1;
            }else{
                $receipt_no_new = 1;
            }
            $receipt_no_new = sprintf('%04d',$receipt_no_new);
            $receipt_no = substr((string)$filter['fee_year'], -2) . 'T' . $receipt_no_new;


            $isExistOrderID = $this->fee->checkOrderIdExistsInFeePayment($_POST['txnid']);
            if(empty($isExistOrderID)){ 

                $overallFee = array(
                    'application_no' => $row_id,
                    'payment_type' => 'ONLINE',
                    'payment_date' => date('Y-m-d',strtotime($_POST['addedon'])),
                    'total_amount' => $total_fee_to_pay,
                    'paid_amount' => $paid_fee_amount,
                    'excess_amount' => $fee_excess_amount,
                    'fee_concession' => $concession,
                    'pending_balance' => $pending_fee_balance,
                    'fee_pending_status' => $fee_pending_status,
                    'payment_year' => $year,
                    'payment_count' => $paid_count,
                    'order_id' => $_POST['txnid'],
                    'receipt_number' => $receipt_no_new,
                    'term_name' => $term_name,
                    'staff_payment' => 1,
                    'collected_staff_name' => 'parrophins',
                    'created_by' => 'schoolphins Staff side',
                    'created_date_time' => date('Y-m-d H:i:s'));
           
                    $overall_row_id = $this->fee->addFeeDetailsNewAdmission($overallFee);

                    $remaining_fee_amt = $paid_fee_amount;

                    $feeStructureInfo = $this->fee->getAllFeeStructureInfoForReceipt($filter);
                    foreach($feeStructureInfo as $fee){
                        $db_save_status = false;
                        $fee_structure_amt = $fee->fee_amount_state_board;
                        
                        // $structure_total = (float)$fee->fee_amount_state_board;
                        // if($structure_total < 0) $structure_total = 0;
                        // $isAlreadyPaid = $this->fee->checkFeeTypeIsAlreadyPaid($application_no, $fee->fee_division_id);
                        // // initialize values
                        // $paid_amt = 0;
                        // $pending_amt = 0;
                        // $fee_pending_status = 1; // default pending

                        // // 1) If there's an existing paid record with pending > 0, pay that pending first
                        // if(!empty($isAlreadyPaid) && (float)$isAlreadyPaid->pending_amt > 0){
                        //     $existing_pending = (float)$isAlreadyPaid->pending_amt;
                        //     // pay as much as available
                        //     $to_pay = min($remaining_fee_amt, $existing_pending);
                        //     $paid_amt = $to_pay;
                        //     $pending_after = $existing_pending - $to_pay;
                        //     $pending_amt = $pending_after;
                        //     $fee_pending_status = ($pending_after > 0) ? 1 : 0;
                        //     // decrease remaining amount available to allocate
                        //     $remaining_fee_amt -= $to_pay;
                        //     // Save/update record (we insert a new row for this receipt allocation)
                        //     $db_save_status = true;
                        // }

                        // // 2) If there's no existing pending (or after clearing existing pending we still have money), apply to whole structure amount
                        // if($remaining_fee_amt > 0){
                        //     $isAlreadyPaidTotal = $this->fee->checkFeeTypeTotalPaid($application_no, $fee->fee_division_id);
                        //     // Need to compute how much of structure_total is already paid historically (if any)
                        //     $already_paid_total = (!empty($isAlreadyPaid)) ? (float)$isAlreadyPaidTotal->total_paid : 0;
                        //     // Remaining due for this fee structure = structure_total - already_paid_total
                        //     $due_for_structure = $structure_total - $already_paid_total;
                        //     if($due_for_structure < 0) $due_for_structure = 0;
                        //     if($due_for_structure > 0){
                        //         $to_pay2 = min($remaining_fee_amt, $due_for_structure);
                        //         // If we already set $paid_amt above (clearing existing pending), add to it; else set it.
                        //         $paid_amt = isset($paid_amt) ? ($paid_amt + $to_pay2) : $to_pay2;
                        //         $pending_after_structure = $due_for_structure - $to_pay2;
                        //         // total pending for this fee should consider any leftover pending from earlier + structure pending
                        //         // But since above we cleared existing pending first, now pending_after_structure is final pending
                        //         $pending_amt = $pending_after_structure;
                        //         $fee_pending_status = ($pending_after_structure > 0) ? 1 : 0;
                        //         $remaining_fee_amt -= $to_pay2;
                        //         $db_save_status = true;
                        //     } else {
                        //         // nothing due left for structure (already fully paid historically)
                        //         // if no prior pending and no due, do nothing
                        //         // $paid_amt remains whatever was set earlier (maybe 0)
                        //     }
                        // }

                        $structure_total = (float)$fee->fee_amount_state_board;
                        if($structure_total < 0){
                            $structure_total = 0;
                        }
                        // initialize values
                        $paid_amt = 0;
                        $pending_amt = 0;
                        $fee_pending_status = 1;
                        $db_save_status = false;
                        // already paid info
                        $AlreadyPaidInfo = $this->fee->checkFeeTypeTotalPaid($application_no, $fee->fee_division_id);
                        if(!empty($AlreadyPaidInfo->total_paid)){
                            $already_paid_total =  (float)$AlreadyPaidInfo->total_paid; 
                        }else{
                            $already_paid_total =  0; 
                        }
                        // calculate actual pending
                        $pending_balance = $structure_total - $already_paid_total;

                        if($pending_balance < 0){
                            $pending_balance = 0;
                        }
                        if($remaining_fee_amt > 0 && $pending_balance > 0){
                            // amount to pay now
                            $paid_amt = min($remaining_fee_amt, $pending_balance);
                            // remaining pending after this payment
                            $pending_amt = $pending_balance - $paid_amt;
                            // pending status
                            if(!empty($pending_amt > 0)){
                                $fee_pending_status =  1; 
                            }else{
                                $fee_pending_status =  0; 
                            }
                            // reduce remaining amount
                            $remaining_fee_amt -= $paid_amt;
                            $db_save_status = true;
                        }

                        if($db_save_status){
                            $receipt_number_for_fee = $receipt_no;
                            if((int)$fee->fee_division_id === 1){
                                $receipt_number_for_fee = $this->fee->getLastReceiptNoByFeeType($filter['fee_year'], $fee->fee_division_id);
                                // log_message('debug','receipt_number_for_fee='.print_r($receipt_number_for_fee,true));

                            }

                            $feeReceiptPayment = array(
                                'application_no' => $row_id,
                                'receipt_number' => $overall_row_id,
                                'receipt_no' => $receipt_number_for_fee, 
                                'payment_date' => date('Y-m-d',strtotime($_POST['addedon'])), 
                                'fee_type_id' => $fee->fee_division_id,
                                'fee_structure_id' => $fee->row_id,
                                'paid_amount' => $paid_amt,
                                'pending_amt' => $pending_amt,
                                'payment_year' => $filter['fee_year'],
                                'pending_status' => $fee_pending_status,
                                'school_account_id' => $fee->account_row_id,
                                'created_by' => 'schoolphins',
                                'fee_amount' => $fee_structure_amt,
                                'created_date_time' => date('Y-m-d H:i:s'));
                            $receipt_return_feeType = $this->fee->addReceiptFeeType($feeReceiptPayment);
                        }
                    }  
            
                if(!empty($overall_row_id)){
                    $concessionAmt =  $this->fee->checkConsessionExists($row_id,$fee_year);
                    if(!empty($concessionAmt)){
                        $concessionInfo = array(
                            'payment_status'=>1,
                            // 'instalment_status'=>1,
                            'updated_by'=>$row_idrow_id,
                            'updated_date_time'=>date('Y-m-d H:i:s'));
                        $this->fee->updateConcessionById($concessionInfo, $concessionAmt->row_id);
                    }
                
                
                    // $installmentAmt =  $this->fee->checkInstalmentExists($row_id);
                    // if(!empty($installmentAmt)){
                    //     $instllInfo = array(
                    //         'payment_status'=>1,
                    //         'receipt_number' => $receipt_no,
                    //         'updated_by'=>$row_id,
                    //         'updated_date_time'=>date('Y-m-d H:i:s'));
                    //     $this->fee->updateInstalmentById($instllInfo, $installmentAmt->row_id);
                    // }
                  
                }
                
                $payInfo = array(
                    'pay_status' => 1,
                    'payment_mode' => 'ONLINE',
                    'tran_date' => date('Y-m-d',strtotime($_POST['addedon'])),
                    'payment_status' =>'SUCCESS',
                    'receipt_number' =>$receipt_no,
                    'tran_id' =>$_POST['txnid'],
                    'updated_by' => 'Schoolphins - Staff Side',
                    'updated_date_time' => date('Y-m-d H:i:s')
                );
            }
        
                   
            }else{
                $payInfo = array(
                        'payment_mode' => 'ONLINE',
                        'tran_date' => date('Y-m-d',strtotime($_POST['addedon'])),
                        'payment_status' =>'PENDING',
                        'receipt_number' =>$isExistOrderID->receipt_number,
                        'tran_id' =>$_POST['txnid'],
                        'updated_by' => 'Schoolphins - Staff Side',
                        'updated_date_time' => date('Y-m-d H:i:s')
                    );
            }
                

                
        } else {
            $payInfo = array(
                'pay_status' => 0,
                'payment_mode' => 'ONLINE',
                'payment_status' =>'PENDING',
                'tran_id' =>$_POST['txnid'],
                'tran_date' => date('Y-m-d',strtotime($_POST['addedon'])),
                'updated_by' => 'Schoolphins - Staff Side',
                'updated_date_time' => date('Y-m-d H:i:s')
            );
        }
        $this->fee->updateFeePaymentLogOrderID($_POST['txnid'],$payInfo);

           

         $data['studentData'] = $studentInfo;
       $_SESSION["FEE_STUDENT_ID"] = $row_id;
        // $_SESSION["FEE_TERM_NAME"] = $term_name;
        if(!empty($overall_row_id)){
            $this->session->set_flashdata('success', 'Fee Paid Successfully');
            redirect('getStudentFeePaymentInfo');
        }else{
            $this->session->set_flashdata('error', 'Fee Payment Failed!');
            redirect('getStudentFeePaymentInfo'); 
        }
    }
    function feePaymentReprocess($order_id, $student_row_id){
        $filter = array();
        $row_id = $student_row_id;                
        $application_no = $student_row_id;
        $filter = array();
        $studentInfo = $this->student->getStudentInfoByRowId($application_no);
        $pay = $this->fee->checkOrderIdExistsInFeesPaymentLog($order_id);
        log_message('debug','feePaymentReprocess - pay -->'.print_r($pay,true));
        $ORDER_ID = $order_id;
        $student_email =  $pay->email;
        $mobile_no = $pay->phone;
       
        $easebuzzObj = new Easebuzz(EB_MERCHANT_KEY, EB_SALT, EB_ENV);
                
        $concatenated_string = EB_MERCHANT_KEY . "|" . $ORDER_ID. "|" . $pay->amount. "|" . $student_email . "|" . $mobile_no . "|" . EB_SALT;
        log_message('debug','feePaymentReprocess - concatenated_string -->'.print_r($concatenated_string,true));
    
        $hashed_value = hash('sha512', $concatenated_string);
        $postData = array ( 
            "txnid" => $ORDER_ID,
            "amount" => $pay->amount,
            "email" => $student_email,
            "phone" => $mobile_no,
            "hash" => $hashed_value,
          );


        $responseParamList = $easebuzzObj->transactionAPI($postData);
        $_POST = json_decode($responseParamList, true);
       log_message('debug','$_POST -->'.print_r($_POST,true));


        $paid_fee_amount = $_POST['msg']['amount'];            

        if($_POST['msg']['status'] == 'success'){

            $isExistOrderID = $this->fee->checkOrderIdExistsInFeePayment($_POST['msg']['txnid']);
            if(empty($isExistOrderID)){ 
            $paid_fee_amount = $_POST['msg']['amount'];
            
            $filter['fee_year'] = $studentInfo->intake_year_id;
            $term_name = $studentInfo->term_name;
           

            if($term_name == 'II PUC'){
                if($studentInfo->intake_year_id == FEE_YEAR){
                    $filter['fee_year'] = trim($studentInfo->intake_year_id);
                    $filter['student_fee_type'] = 'NEW';
                }else{
                    $filter['fee_year'] = trim($studentInfo->intake_year_id)+1;
                    $filter['student_fee_type'] = 'REG';

                }
            }else{
                $filter['student_fee_type'] = 'REG';
            }
            $filter['term_name'] = $term_name;
            $filter['stream_name'] = $studentInfo->stream_name;
            $filter['gender'] = $studentInfo->gender;
            
            $total_fee = $this->fee->getTotalFeeAmount($filter);
            $depart_fee = $this->fee->getGovtFeeAmount($filter);
            $category_fee = 0;

            $total_fee_to_pay = $total_fee->total_fee + $depart_fee + $category_fee; //- $depart_fee;
            $data['feePaidInfo'] = $this->fee->getFeePaidInfo($application_no,$filter['fee_year']);
            if(!empty($data['feePaidInfo'])){
                foreach($data['feePaidInfo'] as $fee){
                    $total_fee_to_pay = $total_fee_to_pay - $fee->paid_amount;
                }
            }
            $concession = 0; 
            $concession_amt = $this->fee->getFeeConcessionByAppNo($application_no,$filter['fee_year']);
            if($concession_amt>0){
                $concession = $concession_amt;
                $total_fee_to_pay -= $concession;
            }
            $remaining_fee_amt = $paid_fee_amount;
            $feePaymentInfo = $this->fee->getStdLastPaidDetailsByApplicationNo($application_no,$filter['fee_year']);
            if(empty($feePaymentInfo)){
                $paid_count = 1;
            }else{
                $paid_count = $feePaymentInfo->payment_count+1;
            }
            $pending_fee_balance = $total_fee_to_pay - $paid_fee_amount;
            if($pending_fee_balance <= 0){
                $fee_excess_amount = abs($pending_fee_balance);
                $fee_pending_status = 0;
                $pending_fee_balance = 0;
            }else if($pending_fee_balance > 0){
                $fee_excess_amount = 0;
                $fee_pending_status = 1;
            }
            $lastReceiptInfo = $this->fee->getLastReceiptNoNew($filter['fee_year']);
            if(!empty($lastReceiptInfo->receipt_number)){
                $receipt_no_new = $lastReceiptInfo->receipt_number + 1;
            }else{
                $receipt_no_new = 1;
            }
            $receipt_no_new = sprintf('%04d',$receipt_no_new);
            $receipt_no = substr((string)$filter['fee_year'], -2) . 'T' . $receipt_no_new;

            $isExistOrderID = $this->fee->checkOrderIdExistsInFeePayment($_POST['msg']['txnid']);
            if(empty($isExistOrderID)){ 

                $overallFee = array(
                    'application_no' => $row_id,
                    'payment_type' => 'ONLINE',
                    'payment_date' => date('Y-m-d',strtotime($_POST['msg']['addedon'])),
                    'total_amount' => $total_fee_to_pay,
                    'paid_amount' => $paid_fee_amount,
                    'excess_amount' => $fee_excess_amount,
                    'fee_concession' => $concession,
                    'pending_balance' => $pending_fee_balance,
                    'fee_pending_status' => $fee_pending_status,
                    'payment_year' => $filter['fee_year'],
                    'payment_count' => $paid_count,
                    'order_id' => $_POST['msg']['txnid'],
                    'receipt_number' => $receipt_no_new,
                    'term_name' => $term_name,
                    'staff_payment' => 1,
                    'collected_staff_name' => 'parrophins',
                    'created_by' => 'schoolphins Staff Reprocess',
                    'created_date_time' => date('Y-m-d H:i:s'));

                    $overall_row_id = $this->fee->addFeeDetailsNewAdmission($overallFee);
                    $remaining_fee_amt = $paid_fee_amount;
                    $feeStructureInfo = $this->fee->getAllFeeStructureInfoForReceipt($filter);
                    foreach($feeStructureInfo as $fee){
                        $db_save_status = false;
                        $fee_structure_amt = $fee->fee_amount_state_board;
                        // $structure_total = (float)$fee->fee_amount_state_board;
                        // if($structure_total < 0) $structure_total = 0;
                        // $isAlreadyPaid = $this->fee->checkFeeTypeIsAlreadyPaid($application_no, $fee->fee_division_id);
                        // // initialize values
                        // $paid_amt = 0;
                        // $pending_amt = 0;
                        // $fee_pending_status = 1; // default pending

                        // // 1) If there's an existing paid record with pending > 0, pay that pending first
                        // if(!empty($isAlreadyPaid) && (float)$isAlreadyPaid->pending_amt > 0){
                        //     $existing_pending = (float)$isAlreadyPaid->pending_amt;
                        //     // pay as much as available
                        //     $to_pay = min($remaining_fee_amt, $existing_pending);
                        //     $paid_amt = $to_pay;
                        //     $pending_after = $existing_pending - $to_pay;
                        //     $pending_amt = $pending_after;
                        //     $fee_pending_status = ($pending_after > 0) ? 1 : 0;
                        //     // decrease remaining amount available to allocate
                        //     $remaining_fee_amt -= $to_pay;
                        //     // Save/update record (we insert a new row for this receipt allocation)
                        //     $db_save_status = true;
                        // }

                        // // 2) If there's no existing pending (or after clearing existing pending we still have money), apply to whole structure amount
                        // if($remaining_fee_amt > 0){
                        //     $isAlreadyPaidTotal = $this->fee->checkFeeTypeTotalPaid($application_no, $fee->fee_division_id);
                        //     // Need to compute how much of structure_total is already paid historically (if any)
                        //     $already_paid_total = (!empty($isAlreadyPaid)) ? (float)$isAlreadyPaidTotal->total_paid : 0;
                        //     // Remaining due for this fee structure = structure_total - already_paid_total
                        //     $due_for_structure = $structure_total - $already_paid_total;
                        //     if($due_for_structure < 0) $due_for_structure = 0;
                        //     if($due_for_structure > 0){
                        //         $to_pay2 = min($remaining_fee_amt, $due_for_structure);
                        //         // If we already set $paid_amt above (clearing existing pending), add to it; else set it.
                        //         $paid_amt = isset($paid_amt) ? ($paid_amt + $to_pay2) : $to_pay2;
                        //         $pending_after_structure = $due_for_structure - $to_pay2;
                        //         // total pending for this fee should consider any leftover pending from earlier + structure pending
                        //         // But since above we cleared existing pending first, now pending_after_structure is final pending
                        //         $pending_amt = $pending_after_structure;
                        //         $fee_pending_status = ($pending_after_structure > 0) ? 1 : 0;
                        //         $remaining_fee_amt -= $to_pay2;
                        //         $db_save_status = true;
                        //     } else {
                        //         // nothing due left for structure (already fully paid historically)
                        //         // if no prior pending and no due, do nothing
                        //         // $paid_amt remains whatever was set earlier (maybe 0)
                        //     }
                        // }

                        $structure_total = (float)$fee->fee_amount_state_board;
                        if($structure_total < 0){
                            $structure_total = 0;
                        }
                        // initialize values
                        $paid_amt = 0;
                        $pending_amt = 0;
                        $fee_pending_status = 1;
                        $db_save_status = false;
                        // already paid info
                        $AlreadyPaidInfo = $this->fee->checkFeeTypeTotalPaid($application_no, $fee->fee_division_id);
                        if(!empty($AlreadyPaidInfo->total_paid)){
                            $already_paid_total =  (float)$AlreadyPaidInfo->total_paid; 
                        }else{
                            $already_paid_total =  0; 
                        }
                        // calculate actual pending
                        $pending_balance = $structure_total - $already_paid_total;

                        if($pending_balance < 0){
                            $pending_balance = 0;
                        }
                        if($remaining_fee_amt > 0 && $pending_balance > 0){
                            // amount to pay now
                            $paid_amt = min($remaining_fee_amt, $pending_balance);
                            // remaining pending after this payment
                            $pending_amt = $pending_balance - $paid_amt;
                            // pending status
                            if(!empty($pending_amt > 0)){
                                $fee_pending_status =  1; 
                            }else{
                                $fee_pending_status =  0; 
                            }
                            // reduce remaining amount
                            $remaining_fee_amt -= $paid_amt;
                            $db_save_status = true;
                        }

                        if($db_save_status){
                            $receipt_number_for_fee = $receipt_no;
                            if((int)$fee->fee_division_id === 1){
                                $receipt_number_for_fee = $this->fee->getLastReceiptNoByFeeType($filter['fee_year'], $fee->fee_division_id);
                            }
                            $feeReceiptPayment = array(
                                'application_no' => $row_id,
                                'receipt_number' => $overall_row_id,
                                'receipt_no' => $receipt_number_for_fee, 
                                'payment_date' => date('Y-m-d',strtotime($_POST['msg']['addedon'])), 
                                'fee_type_id' => $fee->fee_division_id,
                                'fee_structure_id' => $fee->row_id,
                                'paid_amount' => $paid_amt,
                                'pending_amt' => $pending_amt,
                                'payment_year' => $filter['fee_year'],
                                'pending_status' => $fee_pending_status,
                                'school_account_id' => $fee->account_row_id,
                                'created_by' => 'schoolphins',
                                'fee_amount' => $fee_structure_amt,
                                'created_date_time' => date('Y-m-d H:i:s'));
                            $receipt_return_feeType = $this->fee->addReceiptFeeType($feeReceiptPayment);
                        }
                    }  
                if(!empty($overall_row_id)){
                    $concessionAmt =  $this->fee->checkConsessionExists($row_id,$fee_year);
                    if(!empty($concessionAmt)){
                        $concessionInfo = array(
                            'payment_status'=>1,
                            // 'instalment_status'=>1,
                            'updated_by'=>$row_idrow_id,
                            'updated_date_time'=>date('Y-m-d H:i:s'));
                        $this->fee->updateConcessionById($concessionInfo, $concessionAmt->row_id);
                    }
                }
                $payInfo = array(
                    'pay_status' => 1,
                    'payment_mode' => 'ONLINE',
                    'tran_date' => date('Y-m-d',strtotime($_POST['msg']['addedon'])),
                    'payment_status' =>'SUCCESS',
                    'receipt_number' =>$receipt_no,
                    'tran_id' =>$_POST['msg']['txnid'],
                    'updated_by' => 'Schoolphins - Staff Reprocess',
                    'updated_date_time' => date('Y-m-d H:i:s')
                );
            }      
            }else{
                $payInfo = array(
                        'payment_mode' => 'ONLINE',
                        'tran_date' => date('Y-m-d',strtotime($_POST['msg']['addedon'])),
                        'payment_status' =>'PENDING',
                        'receipt_number' =>$isExistOrderID->receipt_number,
                        'tran_id' =>$_POST['msg']['txnid'],
                        'updated_by' => 'Schoolphins - Staff Reprocess',
                        'updated_date_time' => date('Y-m-d H:i:s')
                    );
            }   
        } else {
            $payInfo = array(
                'pay_status' => 0,
                'payment_mode' => 'ONLINE',
                'payment_status' =>'PENDING',
                'tran_id' =>$_POST['msg']['txnid'],
                'tran_date' => date('Y-m-d',strtotime($_POST['msg']['addedon'])),
                'updated_by' => 'Schoolphins - Staff Reprocess',
                'updated_date_time' => date('Y-m-d H:i:s')
            );
        }
        $this->fee->updateFeePaymentLogOrderID($_POST['msg']['txnid'],$payInfo);
        return true;     
    }


}
?>