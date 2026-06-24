<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Account extends BaseController {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Account_model','account');
         $this->load->model('students_model','student');
         $this->load->library('excel');
        $this->isLoggedIn();
    }
    
    public function viewAccount(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Account Details';
            $this->loadViews("account/bankAccount.php", $this->global, null, null);
        }
    }
    
    public function get_account(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE )
        {
            $this->loadThis();
        } else {
            $draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));
            $data_array_new = [];
            $accountDetails = $this->account->getAllAccountDetails();
            foreach($accountDetails as $account) {
                $editButton = "";
                $deleteButton = "";
            
                if($this->role == ROLE_ADMIN || $this->role == ROLE_PRIMARY_ADMINISTRATOR){
                    $deleteButton = '<a class="btn btn-xs btn-danger deleteAccount" href="#"
                    data-row_id="'.$account->row_id.'" title="Delete"><i
                        class="fa fa-trash"></i></a>';
                    $editButton = '<a class="btn btn-xs btn-primary"
                    href="'.base_url().'editAccount/'.$account->row_id.'" title="Edit "><i
                        class="fas fa-pencil-alt"></i></a>';
                }

                $data_array_new[] = array(
                    $account->bank_name,
                    $account->branch_name,
                    $account->account_no,
                    $account->ifsc_code,
                    $editButton.' '.$deleteButton
                );
            }
            $count = count($accountDetails);
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

    public function addNewAccount() {
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Add Account Details';
            $this->loadViews("account/addAccount.php", $this->global, null, null);
        }
    }

    
    // add bank account info
    public function addAccountDetails() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('bank_name','Bank Name','trim|required');
            $this->form_validation->set_rules('branch_name','Branch Name','trim|required');
            $this->form_validation->set_rules('account_no', 'Account Number', 'trim|required|numeric|max_length[18]');
            $this->form_validation->set_rules('ifsc_code', 'IFSC Code', 'trim|required');
            // $this->form_validation->set_rules('department', 'Department', 'trim|required|numeric');

            if($this->form_validation->run() == FALSE) {
                $this->addNewAccount();
            } else {
                $bank_name = ucwords($this->security->xss_clean($this->input->post('bank_name')));
                $branch_name = $this->security->xss_clean($this->input->post('branch_name'));
                $account_no = $this->security->xss_clean($this->input->post('account_no'));
                $ifsc_code = $this->security->xss_clean($this->input->post('ifsc_code'));
                    $accountInfo = array(
                        'bank_name' => $bank_name,
                        'branch_name' => $branch_name,
                        'account_no' => $account_no,
                        'ifsc_code' => $ifsc_code,
                        'created_by'=>$this->staff_id,
                        'created_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->account->addAccountInfo($accountInfo);
                    if($result > 0){
                        $this->session->set_flashdata('success', 'Bank Details Added successfully');
                    } else{
                        $this->session->set_flashdata('error', 'Failed to Add Bank Deatils');
                    }
                redirect('viewAccount');
            }
        }
    }

    
    public function editAccount($row_id = null){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            if ($row_id == NULL) {
                redirect('viewAccount');
            }
            $data['accountInfo'] = $this->account->getAccountInfoById($row_id);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Update Fee Structure';
            $this->loadViews("account/editAccount", $this->global, $data, null);
        }
    }

    
    public function updateAccount() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $row_id = $this->input->post('row_id');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('bank_name','Bank Name','trim|required');
            $this->form_validation->set_rules('branch_name','Branch Name','trim|required');
            $this->form_validation->set_rules('account_no', 'Account Number', 'trim|required|numeric|max_length[18]');
            $this->form_validation->set_rules('ifsc_code', 'IFSC Code', 'trim|required');
            // $this->form_validation->set_rules('department', 'Department', 'trim|required|numeric');

            if($this->form_validation->run() == FALSE) {
                redirect('editAccount/'.$row_id);  
            } else {
                $bank_name = ucwords($this->security->xss_clean($this->input->post('bank_name')));
                $branch_name = $this->security->xss_clean($this->input->post('branch_name'));
                $account_no = $this->security->xss_clean($this->input->post('account_no'));
                $ifsc_code = $this->security->xss_clean($this->input->post('ifsc_code'));
                
                $accountInfo = array(
                    'bank_name' => $bank_name,
                    'branch_name' => $branch_name,
                    'account_no' => $account_no,
                    'ifsc_code' => $ifsc_code,
                    'updated_by'=>$this->staff_id,
                    'updated_date_time'=>date('Y-m-d H:i:s'));
                $result = $this->account->updateAccountDeatils($accountInfo, $row_id);
                if($result > 0){
                    $this->session->set_flashdata('success', 'Account Info Updated successfully');
                } else{
                    $this->session->set_flashdata('error', 'Failed to Update Account Info');
                }
                redirect('editAccount/'.$row_id);  
            }
        }
    }

    public function deleteAccount(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $accountInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id);
            $result = $this->account->updateAccountDeatils($accountInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }


    function onlineFeePaidInfo()
    {
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE)
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

            
            
            $searchText = "";
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
            // log_message('debug','fff=='.$filter['bank_settlement']);
            
            if(!empty($by_bank_date)){
                $filter['by_bank_date'] = date('Y-m-d',strtotime($by_bank_date));
                $data['by_bank_date'] = date('d-m-Y',strtotime($by_bank_date));;
            }else{
                $data['by_bank_date'] = '';
            }

            
            $this->load->library('pagination');
            $count = $this->account->getOnlinePaidCount($filter);
            $returns = $this->paginationCompress("onlinePaymentInfo/", $count, 100 );
            $data['online_pay_count'] = $count;
            $data['onlineFeeInfo'] = $this->account->getOnlinePaidInfo( $returns["page"], $returns["segment"], $filter);
            $data['bankAccInfo'] = $this->account->getAllAccountDetails();
            $data['feePaidStdInfo'] = $this->account->getFeePaidStudentInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' :Online Fee Paid Details';
            $this->loadViews("fees/onlinePaymentInfo", $this->global, $data, NULL);
        }
    }

    

    
    public function addBankSettlementSubmit(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $date = $this->input->post('date');
            $receipt_number = json_decode(stripslashes($this->input->post('receipt_number')));
            foreach($receipt_number as $receipt){
               // $isExist = $this->account->getBankSettlementByReceiptNo($receipt);
                // if(empty($isExist)){
                  
                //     $settleInfo = array(
                //         'date' => date('Y-m-d',strtotime($date)),
                //         'receipt_number' => $receipt,
                //         'created_by'=>$this->staff_id,
                //         'created_date_time'=>date('Y-m-d H:i:s'));
                //     $return_id = $this->account->addBankSettlement($settleInfo);
                // }else{
                //     $settleInfo = array(
                //         'date' => date('Y-m-d',strtotime($date)),
                //         'receipt_number' => $receipt,
                //         'updated_by'=>$this->staff_id,
                //         'is_deleted' => 0,
                //         'updated_date_time'=>date('Y-m-d H:i:s'));
                //     $return_id = $this->account->updateBankSettlement($settleInfo, $receipt);
                // }
                $feePaidInfo = array(
                    'bank_settlement_date' => date('Y-m-d',strtotime($date)),
                    'bank_settlement_status' => 1,
                    'updated_by'=>$this->staff_id,
                    'updated_date_time'=>date('Y-m-d H:i:s'));
                $return =  $this->account->updatefeeSettleStatus($feePaidInfo, $receipt);
               
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


    //new admission
    public function addBankSettlementSubmitNewAdmission(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $date = $this->input->post('date');
            $receipt_number = json_decode(stripslashes($this->input->post('receipt_number')));
            foreach($receipt_number as $receipt){
                $isExist = $this->account->getBankSettlementByReceiptNo($receipt);
                if(empty($isExist)){
                    $settleInfo = array(
                        'date' => date('Y-m-d',strtotime($date)),
                        'receipt_number' => $receipt,
                        'created_by'=>$this->staff_id,
                        'created_date_time'=>date('Y-m-d H:i:s'));
                    $return_id = $this->account->addBankSettlement($settleInfo);
                }else{
                    $settleInfo = array(
                        'date' => date('Y-m-d',strtotime($date)),
                        'receipt_number' => $receipt,
                        'updated_by'=>$this->staff_id,
                        'is_deleted' => 0,
                        'updated_date_time'=>date('Y-m-d H:i:s'));
                    $return_id = $this->account->updateBankSettlement($settleInfo, $receipt);
                }
                $feePaidInfo = array(
                    'receipt_number' => $receipt,
                    'bank_settlement_status' => 1,
                    'updated_by'=>$this->staff_id,
                    'updated_date_time'=>date('Y-m-d H:i:s'));
                $return =  $this->account->updatefeeSettleStatusNewAdm($feePaidInfo, $receipt);
               
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
    





}
?>