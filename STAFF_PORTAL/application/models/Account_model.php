<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends CI_Model {

    public function getAllAccountDetails() {
        $this->db->from('tbl_bank_account as bank');
        $this->db->where('bank.is_deleted', 0);
        $this->db->order_by('bank.row_id','ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function addAccountInfo($accountInf0){
        $this->db->trans_start();
        $this->db->insert('tbl_bank_account', $accountInf0);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }

    public function getAccountInfoById($row_id) {
        $this->db->from('tbl_bank_account as bank');
        $this->db->where('bank.row_id', $row_id);
        $this->db->where('bank.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function updateAccountDeatils($accountInfo, $row_id) {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_bank_account', $accountInfo);
        return TRUE;
    }

   
 
       public function addBankSettlement($settleInfo){
         $this->db->trans_start();
         $this->db->insert('tbl_fee_payment_bank_settlement', $settleInfo);
         $insert_id = $this->db->insert_id(); 
         $this->db->trans_complete();
         return $insert_id; 
     }
 
     public function getBankSettlementByReceiptNo($receipt_no) {
         $this->db->from('tbl_fee_payment_bank_settlement as bank');
         $this->db->where('bank.receipt_number', $receipt_no);
         //$this->db->where('bank.is_deleted', 0);
         $query = $this->db->get();
         return $query->row();
     }
 
     public function updateBankSettlement($settleInfo, $receipt_number) {
         $this->db->where('receipt_number', $receipt_number);
         $this->db->update('tbl_fee_payment_bank_settlement', $settleInfo);
         return TRUE;
     }
 
     public function updatefeeSettleStatus($feeInfo, $receipt_number) {
         $this->db->where('row_id', $receipt_number);
         $this->db->update('tbl_students_overall_fee_payment_info', $feeInfo);
         return TRUE;
     }

   

    // public function getFeePaidStudentInfo($filter=''){
    //     $this->db->select('student.row_id, 
    //     student.name as student_name, 
    //     student.application_number as application_no,
    //     fee.payment_date,
    //     com.stream_name,
    //     fee.receipt_number,
    //     fee.payment_type,
    //     fee.bank_settlement_status,
    //     ');
    //     $this->db->from('tbl_student_personal_details as student');
         
    //     $this->db->join('tbl_admission_combination_language_opted as com', 'com.registred_row_id = student.resgisted_tbl_row_id','left');
      
    //     $this->db->join('tbl_new_admission_overall_fee_payment_info as fee', 'fee.application_no = student.application_number','right');
     
    //     if(!empty($filter['date_from']) && !empty($filter['date_to'])){
    //         $this->db->where('fee.payment_date >=', $filter['date_from']);
    //         $this->db->where('fee.payment_date <=', $filter['date_to']);
    //     }
    //     $this->db->where('student.is_deleted', 0);
    //     $this->db->where('fee.is_deleted', 0);
    //     $this->db->order_by('fee.payment_date', 'ASC');
    //     $query = $this->db->get();
    //     return $query->result();
    // }



    
    public function updatefeeSettleStatusNewAdm($feeInfo, $receipt_number) {
        $this->db->where('receipt_number', $receipt_number);
        $this->db->update('tbl_new_admission_overall_fee_payment_info', $feeInfo);
        return TRUE;
    }

    public function addBankSettlementNewAdm($settleInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_fee_payment_bank_settlement_new_adm', $settleInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }

    public function getBankSettlementByReceiptNoNewAdm($receipt_no) {
        $this->db->from('tbl_fee_payment_bank_settlement_new_adm as bank');
        $this->db->where('bank.receipt_number', $receipt_no);
        //$this->db->where('bank.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function updateBankSettlementNewAdm($settleInfo, $receipt_number) {
        $this->db->where('receipt_number', $receipt_number);
        $this->db->update('tbl_fee_payment_bank_settlement_new_adm', $settleInfo);
        return TRUE;
    }

    public function updatefeeSettleStatusNewAdm2021($feeInfo, $receipt_number) {
        $this->db->where('receipt_number', $receipt_number);
        $this->db->update('tbl_students_overall_fee_payment_info_i_puc_2021', $feeInfo);
        return TRUE;
    }
}
?>