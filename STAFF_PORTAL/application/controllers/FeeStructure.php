<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';
class FeeStructure extends BaseController {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('feeStructure_model','fee');
        $this->load->model('account_model','account');
        $this->load->model('settings_model','settings');
        $this->load->model('staff_model','staff');
        $this->load->library('pagination');
        $this->load->library('excel');
        $this->isLoggedIn();
    }

    public function viewFeeStructure(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $filter = array();
            $fee_name = $this->security->xss_clean($this->input->post('fee_name'));
            $sslc_board_amt = $this->security->xss_clean($this->input->post('sslc_board_amt'));
            $cbse_board_amt = $this->security->xss_clean($this->input->post('cbse_board_amt'));
            $nri_fee_amt = $this->security->xss_clean($this->input->post('nri_fee_amt'));
            $by_term = $this->security->xss_clean($this->input->post('by_term'));
            $by_stream = $this->security->xss_clean($this->input->post('by_stream'));
            $by_Section = $this->security->xss_clean($this->input->post('by_Section'));
            $by_fee_type = $this->input->post('by_fee_type');
            $fee_student_type = $this->input->post('fee_student_type');
            
            $data['fee_name'] = $fee_name;
            $data['sslc_board_amt'] = $sslc_board_amt;
            $data['cbse_board_amt'] = $cbse_board_amt;
            $data['nri_fee_amt'] = $nri_fee_amt;
            $data['by_term'] = $by_term;
            $data['by_stream'] = $by_stream;
            $data['by_Section'] = $by_Section;
            $data['by_fee_type'] = $by_fee_type;
            $data['fee_student_type'] = $fee_student_type;

            $filter['fee_name'] = $fee_name;
            $filter['sslc_board_amt'] = $sslc_board_amt;
            $filter['cbse_board_amt'] = $cbse_board_amt;
            $filter['nri_fee_amt'] = $nri_fee_amt;
            $filter['by_term'] = $by_term;
            $filter['by_stream'] = $by_stream;
            $filter['by_Section'] = $by_Section;
            $filter['by_fee_type'] = $by_fee_type;
            $filter['fee_student_type'] = $fee_student_type;

            $data['streamInfo'] = $this->settings->getStreamInfo();
            $data['feeTypeInfo'] = $this->settings->getAllFeeTypeInfo();
            $data['accountDetails'] = $this->account->getAllAccountDetails();
            $count = $this->fee->getAllFeesCount($filter);
            $returns = $this->paginationCompress("viewFeeStructure/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['feeInfo'] = $this->fee->getAllFeesInfo($filter);
            $data['feeNameInfo'] = $this->settings->getAllFeeNameInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Fee Structure';
            $this->loadViews("feeStructure/fee.php", $this->global, $data, null);
        }
    }

   
    public function addNewFeeStructure(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $data['feeTypeInfo'] = $this->settings->getAllFeeTypeInfo();
            $data['classInfo'] = $this->settings->getStreamInfo();
            $data['accountDetails'] = $this->account->getAllAccountDetails();
            $data['feeNameInfo'] = $this->settings->getAllFeeNameInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Add Fee Structure';
            $this->loadViews("feeStructure/addFeeStructure.php", $this->global, $data, null);
        }
    }

    // add fee structure
    public function addFeeStructure() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('fee_name','Fee Name','trim|required');
            $this->form_validation->set_rules('fee_amount_state_board','SSLC Fees Amount','trim|required');
            $this->form_validation->set_rules('fee_amount_icse_cbse_board','ISCE/CBSE Fees Amount','trim|required');
            $this->form_validation->set_rules('nri_amount_state_board','NRI Fees Amount','trim|required');
            $this->form_validation->set_rules('term_name', 'Term Name', 'trim|required');
            $this->form_validation->set_rules('stream_name', 'Stream Name', 'trim|required');
            $this->form_validation->set_rules('account_row_id', 'Bank Name', 'trim|required');
            $this->form_validation->set_rules('school_account_type', 'Fee Account Type', 'trim|required');

            if($this->form_validation->run() == FALSE) {
                $this->addNewFeeStructure();
            } else {
                $fee_name = ucwords($this->security->xss_clean($this->input->post('fee_name')));
                $fee_amount_state_board = $this->security->xss_clean($this->input->post('fee_amount_state_board'));
                $fee_amount_icse_cbse_board = $this->security->xss_clean($this->input->post('fee_amount_icse_cbse_board'));
                $nri_amount_state_board = $this->security->xss_clean($this->input->post('nri_amount_state_board'));
               
                
                $term_name = $this->security->xss_clean($this->input->post('term_name'));
                $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
                $account_row_id = $this->security->xss_clean($this->input->post('account_row_id'));
                // $account_row_id_two = $this->security->xss_clean($this->input->post('account_row_id_two'));
                $fee_Required_status = $this->security->xss_clean($this->input->post('fee_Required_status'));
                $language_fees = $this->security->xss_clean($this->input->post('language_fees'));
                $fee_student_type = $this->security->xss_clean($this->input->post('fee_student_type'));
                
               
                $school_account_type = $this->security->xss_clean($this->input->post('school_account_type'));
                $is_Exists = $this->fee->checkFeeStructureExists($fee_name,$term_name,$stream_name);
               // log_message('debug','d='.$is_Exists);
                // if($is_Exists > 0){
                //     $this->session->set_flashdata('warning', 'Fee already exists!');
                // } else { 
                    $feesInfo = array(
                        'fees_type'=>$fee_name,
                        'fee_amount_state_board'=>$fee_amount_state_board,
                        'fee_amount_icse_cbse'=>$fee_amount_icse_cbse_board,
                        'fee_amount_nri'=>$nri_amount_state_board,
                        'lang_fee_status'=>$language_fees,
                        'term_name'=>$term_name,
                        'stream_name'=>$stream_name,
                        'fee_student_type'=>$fee_student_type,
                        'account_row_id'=>$account_row_id,
                        'fee_type' => $school_account_type,
                        'created_by'=>$this->staff_id,
                        'created_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->fee->addFeeStructure($feesInfo);

                    if($result > 0){
                        $feeTypeInfo = array(
                            'fee_structure_row_id' => $result,
                            'fee_required_type' => $fee_Required_status,
                            'created_by' => $this->staff_id,
                            'created_date_time' => date('Y-m-d H:i:s'));
                        $this->fee->addFeeType($feeTypeInfo);
                    }
                    if($result > 0){
                        $this->session->set_flashdata('success', 'Fee Structure Added successfully');
                    } else{
                        $this->session->set_flashdata('error', 'Failed to Add Fee Structure');
                    }
                // }
                redirect('viewFeeStructure');
            }
        }
    }

  
    
    public function editFeeStructure($row_id = null){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            if ($row_id == NULL) {
                redirect('viewFeeStructure');
            }
            $data['feeTypeInfo'] = $this->settings->getAllFeeTypeInfo();
            $data['classInfo'] = $this->settings->getStreamInfo();
            $data['accountDetails'] = $this->account->getAllAccountDetails();
            $data['feeInfo'] = $this->fee->getFeesTypeInfoById($row_id);
            $data['feeNameInfo'] = $this->settings->getAllFeeNameInfo();
           
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Update Fee Structure';
            $this->loadViews("feeStructure/editFeeStructure.php", $this->global, $data, null);
        }
    }

    public function updateFeeStructure() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $row_id = $this->input->post('row_id');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('fees_type','Fees Type Name','trim|required');
            $this->form_validation->set_rules('fee_amount_state_board','SSLC Fees Amount','trim|required');
            $this->form_validation->set_rules('fee_amount_icse_cbse_board','ISCE/CBSE Fees Amount','trim|required');
            $this->form_validation->set_rules('nri_amount_state_board','NRI Fees Amount','trim|required');
            $this->form_validation->set_rules('term_name', 'Term Name', 'trim|required');
            $this->form_validation->set_rules('stream_name', 'Stream Name', 'trim|required');
            $this->form_validation->set_rules('account_row_id', 'Bank Name', 'trim|required');
            $this->form_validation->set_rules('school_account_type', 'Fee Account Type', 'trim|required');

            if($this->form_validation->run() == FALSE) {
                redirect('editFeeStructure/'.$row_id);  
            } else {
                $fees_type = ucwords($this->security->xss_clean($this->input->post('fees_type')));
                $fee_amount_state_board = $this->security->xss_clean($this->input->post('fee_amount_state_board'));
                $fee_amount_icse_cbse_board = $this->security->xss_clean($this->input->post('fee_amount_icse_cbse_board'));
                $nri_amount_state_board = $this->security->xss_clean($this->input->post('nri_amount_state_board'));
               
                $term_name = $this->security->xss_clean($this->input->post('term_name'));
                $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
                $account_row_id = $this->security->xss_clean($this->input->post('account_row_id'));
                $school_account_type = $this->security->xss_clean($this->input->post('school_account_type'));
                $fee_Required_status = $this->security->xss_clean($this->input->post('fee_Required_status'));
                $language_fees = $this->security->xss_clean($this->input->post('language_fees'));
                $fee_student_type = $this->security->xss_clean($this->input->post('fee_student_type'));
               
                // if(empty($account_row_id_two)){
                //     $account_row_id_two = $account_row_id;
                // }
                $feesInfo = array(
                    'fees_type'=>$fees_type,
                    'fee_amount_state_board'=>$fee_amount_state_board,
                    'fee_amount_icse_cbse'=>$fee_amount_icse_cbse_board,
                    'fee_amount_nri'=>$nri_amount_state_board,
                    'stream_name'=>$stream_name,
                    'term_name'=>$term_name,
                    'lang_fee_status'=>$language_fees,
                    'account_row_id'=>$account_row_id,
                    'fee_type' => $school_account_type,
                    'fee_student_type'=>$fee_student_type,
                    'updated_by'=>$this->staff_id,
                    'updated_date_time'=>date('Y-m-d H:i:s'));
                $result = $this->fee->updateFeeStructure($feesInfo, $row_id);
                
                if($result > 0){
                    $feeTypeInfo = array(
                        'fee_required_type' => $fee_Required_status,
                        'updated_by' => $this->staff_id,
                        'updated_date_time' => date('Y-m-d H:i:s'));
                    $this->fee->updateFeeSRequiredtype($feeTypeInfo, $row_id);
                }
                if($result > 0){
                    $this->session->set_flashdata('success', 'Fee Structure Updated successfully');
                } else{
                    $this->session->set_flashdata('error', 'Failed to Update Fee Structure');
                }
                redirect('editFeeStructure/'.$row_id);
            }
        }
    }

    // delete fees
    public function deleteFeeStrtucture(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $feesInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id);
            $result = $this->fee->updateFeeStructure($feesInfo, $row_id);
            if ($result == true) {
                $feeTypeInfo = array('is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id);
                $result = $this->fee->updateFeeSRequiredtype($feeTypeInfo, $row_id);
                echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function getStreamByTerm(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $filter = array();
            $term_name = $this->input->post("term_name");
            $filter['term_name'] = $term_name;
            $data['result'] = $this->staff->getStaffSectionByTerm($filter);
            header('Content-type: text/plain'); 
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        }
    }
    
    //download fee structure format
}
?>