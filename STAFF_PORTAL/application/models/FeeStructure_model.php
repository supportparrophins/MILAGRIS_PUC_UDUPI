<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class FeeStructure_model extends CI_Model
{
    //getting fee structure info
    public function getAllFeesInfo($filter) {
        $this->db->select('fee.row_id,fee.fees_type,fee.stream_name,fee.fee_type,name.fee_name,fee.lang_fee_status,
        fee.term_name,fee.fee_amount_state_board,fee.fee_amount_icse_cbse,feeType.feeType,
        fee.fee_amount_nri,account.bank_name,account.branch_name,account.account_no,type.fee_required_type,fee.fee_student_type,
        account.ifsc_code,fee.account_row_id');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->join('tbl_bank_account as account', 'account.row_id = fee.account_row_id','right');
        $this->db->join('tbl_fee_required_type as type', 'type.fee_structure_row_id = fee.row_id','right');
        $this->db->join('tbl_fees_name as name', 'name.row_id = fee.fees_type','left');
        $this->db->join('tbl_fee_structure_type as feeType', 'feeType.row_id = fee.fee_type','left');
        if(!empty($filter['fee_name'])){
            $this->db->where('name.fee_name', $filter['fee_name']);
        }
        if(!empty($filter['sslc_board_amt'])){
            $this->db->where('fee_amount_state_board', $filter['sslc_board_amt']);
        }
        if(!empty($filter['cbse_board_amt'])){
            $this->db->where('fee.fee_amount_icse_cbse', $filter['cbse_board_amt']);
        }
        if(!empty($filter['nri_fee_amt'])){
            $this->db->where('fee.fee_amount_nri', $filter['nri_fee_amt']);
        }
        if(!empty($filter['by_term'])){
            $this->db->where('fee.term_name', $filter['by_term']);
        }
        if(!empty($filter['by_stream'])){
            $this->db->where('fee.stream_name', $filter['by_stream']);
        }
        if(!empty($filter['by_Section'])){
            $this->db->where('account.account_no', $filter['by_Section']);
        }
        if(!empty($filter['by_fee_type'])){
            $this->db->where('feeType.feeType', $filter['by_fee_type']);
        }
        if(!empty($filter['fee_student_type'])){
            $this->db->where('fee.fee_student_type', $filter['fee_student_type']);
        }
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('account.is_deleted', 0); 
        $this->db->where('type.is_deleted', 0); 
        $this->db->order_by('fee.row_id', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllFeesCount($filter) {
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->join('tbl_bank_account as account', 'account.row_id = fee.account_row_id','right');
        $this->db->join('tbl_fee_required_type as type', 'type.fee_structure_row_id = fee.row_id','right');
        $this->db->join('tbl_fees_name as name', 'name.row_id = fee.fees_type','left');
        $this->db->join('tbl_fee_structure_type as feeType', 'feeType.row_id = fee.fee_type','left');
        if(!empty($filter['fee_name'])){
            $this->db->where('name.fee_name', $filter['fee_name']);
        }
        if(!empty($filter['sslc_board_amt'])){
            $this->db->where('fee_amount_state_board', $filter['sslc_board_amt']);
        }
        if(!empty($filter['cbse_board_amt'])){
            $this->db->where('fee.fee_amount_icse_cbse', $filter['cbse_board_amt']);
        }
        if(!empty($filter['nri_fee_amt'])){
            $this->db->where('fee.fee_amount_nri', $filter['nri_fee_amt']);
        }
        if(!empty($filter['by_term'])){
            $this->db->where('fee.term_name', $filter['by_term']);
        }
        if(!empty($filter['by_stream'])){
            $this->db->where('fee.stream_name', $filter['by_stream']);
        }
        if(!empty($filter['by_Section'])){
            $this->db->where('account.account_no', $filter['by_Section']);
        }
        if(!empty($filter['by_fee_type'])){
            $this->db->where('feeType.feeType', $filter['by_fee_type']);
        }
        if(!empty($filter['fee_student_type'])){
            $this->db->where('fee.fee_student_type', $filter['fee_student_type']);
        }
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('account.is_deleted', 0); 
        $this->db->where('type.is_deleted', 0); 
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getFeesTypeInfoById($row_id) {
        $this->db->select('fee.row_id,
        fee.fees_type,
        fee.fee_amount_state_board,
        fee.fee_amount_icse_cbse,
        fee.fee_amount_nri,
        fee.term_name,
        fee.stream_name,
        account.bank_name,
        account.branch_name,
        fee.lang_fee_status,
        fee.fee_type,
        name.fee_name,
        feeType.feeType,
        feeType.row_id as feeType_id,
        fee.fee_student_type,
        type.fee_required_type,
        account.account_no,account.ifsc_code,fee.account_row_id');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->join('tbl_bank_account as account', 'account.row_id = fee.account_row_id','left');
        $this->db->join('tbl_fee_required_type as type', 'type.fee_structure_row_id = fee.row_id','left');
        $this->db->join('tbl_fees_name as name', 'name.row_id = fee.fees_type','left');
        $this->db->join('tbl_fee_structure_type as feeType', 'feeType.row_id = fee.fee_type','left');
        $this->db->where('fee.row_id', $row_id);
        $this->db->where('fee.is_deleted', 0);
      
        $this->db->where('account.is_deleted', 0); 
        $query = $this->db->get();
        return $query->row();
    }

    public function updateFeeStructure($feesInfo, $row_id) {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_admission_fee_structure', $feesInfo);
        return TRUE;
    }
    public function updateFeeSRequiredtype($feeTypeInfo, $row_id) {
        $this->db->where('fee_structure_row_id', $row_id);
        $this->db->update('tbl_fee_required_type', $feeTypeInfo);
        return TRUE;
    }

    public function checkFeeStructureExists($fees_type,$term_name,$stream_name) {
        $this->db->from('tbl_admission_fee_structure as fees');
        $this->db->join('tbl_fees_name as name', 'name.row_id = fees.fees_type','right');
        $this->db->where('fees.fees_type', $fees_type);
        $this->db->where('fees.term_name', $term_name);
        $this->db->where('fees.stream_name', $stream_name);
        $this->db->where('fees.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function addFeeStructure($feesInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_admission_fee_structure', $feesInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function addFeeType($feeTypeInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_fee_required_type', $feeTypeInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }






    public function getAllFeeTypesForByStatus($term_name,$stream_name,$stream_one){
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->where('fee.term_name', $term_name);
        $this->db->where_in('fee.stream_name',array($stream_name, $stream_one));
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllFeeStructureInfo($term_name, $stream_name){
        $this->db->select('fee.row_id,
        fee.fees_type,
        fee.fee_amount_state_board,
        fee.fee_amount_icse_cbse,
        fee.fee_amount_nri,
        fee.term_name,
        fee.stream_name,
        account.bank_name,
        account.branch_name,
        fee.lang_fee_status,
        fee.fee_type,
        name.fee_name,
        feeType.feeType,
        feeType.row_id as feeType_id,
        fee.fee_student_type,
        type.fee_required_type,
        account.account_no,account.ifsc_code,fee.account_row_id');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->join('tbl_bank_account as account', 'account.row_id = fee.account_row_id','left');
        $this->db->join('tbl_fee_required_type as type', 'type.fee_structure_row_id = fee.row_id','left');
        $this->db->join('tbl_fees_name as name', 'name.row_id = fee.fees_type','left');
        $this->db->join('tbl_fee_structure_type as feeType', 'feeType.row_id = fee.fee_type','left');
        $this->db->where_in('fee.stream_name', [$stream_name,'ALL']);
        $this->db->where_in('fee.term_name', [$term_name,'ALL']);
        // $this->db->where('fee.fee_division_row_id', $type_id);
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('type.is_deleted', 0); 
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllFeeStructureInfoForReport(){
        $this->db->select('fee.row_id,
        fee.fees_type,
        fee.term_name,
        fee.stream_name,
     
        fee.lang_fee_status,
        fee.fee_type,
        name.fee_name');
        $this->db->from('tbl_admission_fee_structure as fee'); 
        $this->db->join('tbl_fees_name as name', 'name.row_id = fee.fees_type','left');
     
        $this->db->where('fee.is_deleted', 0);
       // $this->db->where('fee.term_name', 'II');
        $this->db->group_by('fee.fees_type');
        $query = $this->db->get();
        return $query->result();
    }

    public function getFeeTitleInfoById($row_id){
        $this->db->from('tbl_fees_name as name');
        $this->db->where('name.row_id', $row_id);
        $this->db->where('name.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

        //get date from fee paid

        public function getFeePaidInfoForReport($date_from, $date_to){
            $this->db->select('
            fee.payment_date,
            fee.row_id,
            fee.receipt_number,
            fee.application_no,
            per.name,
            com.stream_name,
            com.second_language,
           ');
            $this->db->from('tbl_students_overall_fee_payment_info as fee');
            $this->db->join('tbl_admission_student_personal_details_temp as per', 'per.application_number = fee.application_no','left');
            $this->db->join('tbl_admission_combination_language_opted_temp as com', 'com.registred_row_id = per.resgisted_tbl_row_id','left');
            $this->db->where('fee.payment_date >=',date('Y-m-d',strtotime($date_from)));
            $this->db->where('fee.payment_date <=',date('Y-m-d',strtotime($date_to)));
            $this->db->where('fee.is_deleted', 0);
            $query = $this->db->get();
            return $query->result();
        }

        public function getFeeStructureAmount($invoice_no, $fee_type_name_id){
            // $this->db->from('tbl_fees_paid_by_receipt as fee');
            // $this->db->where('fee.receipt_number', $invoice_no);
            // $this->db->where('fee.fee_type_id', $fee_type_id);
            // $this->db->where('fee.is_deleted', 0);
            // $query = $this->db->get();
            // return $query->row();


            $this->db->select('
            paid.paid_amount,
           ');
            $this->db->from('tbl_fees_paid_by_receipt as paid'); 
            $this->db->join('tbl_admission_fee_structure as fee', 'fee.row_id = paid.fee_type_id','left');
            $this->db->join('tbl_fees_name as name', 'name.row_id = fee.fees_type','left');
            $this->db->where('paid.receipt_number', $invoice_no);
            $this->db->where('name.row_id', $fee_type_name_id);
            $this->db->where('paid.is_deleted', 0);
           // $this->db->where('fee.term_name', 'II');
           // $this->db->group_by('fee.fees_type');
            $query = $this->db->get();
            return $query->row();
        }

        
        public function getMgmtFeePaidInfo($application_no){
            $this->db->from('tbl_student_management_fee_info as fee');
            $this->db->where('fee.application_no', $application_no);
          
            $this->db->where('fee.is_deleted', 0);
            $query = $this->db->get();
            return $query->row();
        }
}
?>