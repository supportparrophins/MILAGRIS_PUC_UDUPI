<?php if(!defined('BASEPATH')) exit('No direct script access allowed');



class Admission_model extends CI_Model

{

    public function addFeePaymentLog($paymentInfo){

        $this->db->trans_start();

        $this->db->insert('tbl_worldline_payment_log', $paymentInfo);

        $insert_id = $this->db->insert_id(); 

        $this->db->trans_complete();

        return $insert_id; 

    }



     // add from excel

     public function updatePaymentLog($paymentInfo,$row_id) {

        $this->db->where('row_id', $row_id);

        $this->db->update('tbl_worldline_payment_log',$paymentInfo);

        return TRUE;

    }

    

     // add from excel

     public function updatePaymentLogByOrderId($paymentInfo,$order_id) {

        $this->db->where('order_id', $order_id);

        $this->db->update('tbl_worldline_payment_log',$paymentInfo);

        return TRUE;

    }

    



    public function getAllFeeStructureInfo($filter){

        $this->db->select('

        fee.row_id, 

        fee.fees_type,

        fee.fee_amount_state_board,

        fee.fee_amount_icse_cbse,

        fee.fee_amount_nri');

        $this->db->from('tbl_admission_fee_structure as fee');

        //$this->db->join('tbl_school_account_type as type', 'type.row_id = fee.school_account_id','left');

       // $this->db->join('tbl_fee_receipt_config_info as acct', 'acct.row_id = fee.school_account_id','left');

        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);

        $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);

       // $this->db->where('fee.fee_division_row_id', $type_id);

        $this->db->where('fee.is_deleted', 0);

        //$this->db->where('type.is_deleted', 0); 

        if($filter['lang_fee_status'] == false){

            $this->db->where('fee.lang_fee_status!=', 1); 

        }

        if($filter['category'] == 'SC' || $filter['category'] == 'ST' || $filter['category'] == 'CAT-I'){

            $this->db->where('fee.fee_con_sc_st_cat_first_status !=',1);

        }

       // $this->db->where('acct.is_deleted', 0); 
       $this->db->where('fee.fee_year', CURRENT_YEAR);

        $this->db->order_by('fee.fee_amount_state_board','asc');

        $query = $this->db->get();

        return $query->result();

    }

    public function getAllFeeStructureInfoIPuc($filter){
        $this->db->select('
        fee.account_row_id,
        fee.row_id, 
        fee.fees_type,
        fee.fee_amount_state_board,
        fee.fee_amount_icse_cbse,
        fee.fee_amount_nri');
        $this->db->from('tbl_admission_fee_structure as fee');
        //$this->db->join('tbl_school_account_type as type', 'type.row_id = fee.school_account_id','left');
       // $this->db->join('tbl_fee_receipt_config_info as acct', 'acct.row_id = fee.school_account_id','left');
       $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
       $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);
      // $this->db->where('fee.fee_division_row_id', $type_id);
       $this->db->where('fee.is_deleted', 0);
       //$this->db->where('type.is_deleted', 0); 
       if($filter['lang_fee_status'] == false){
           $this->db->where('fee.lang_fee_status!=', 1); 
       }
       if($filter['board_name'] == "SSLC"){
           $this->db->where('fee.fees_type!=', 'ELIGIBILITY FEES'); 
       }
       if($filter['category'] == 'SC' || $filter['category'] == 'ST' || $filter['category'] == 'CAT-I'){
           $this->db->where('fee.fee_con_sc_st_cat_first_status',1);
       }else{
           $this->db->where('fee.fee_con_sc_st_cat_first_status',0);
       }
       $this->db->where('fee.fee_year', CURRENT_YEAR);
       // $this->db->where('acct.is_deleted', 0); 
        $this->db->order_by('fee.fee_amount_state_board','asc');
        $query = $this->db->get();
        return $query->result();
    }



    public function getTotalFeeAmount($filter){

 

        $this->db->select('SUM(fee.fee_amount_state_board) as total_fee');

        $this->db->from('tbl_admission_fee_structure as fee');

        //$this->db->join('tbl_school_account_type as type', 'type.row_id = fee.school_account_id','left');

       // $this->db->join('tbl_fee_receipt_config_info as acct', 'acct.row_id = fee.school_account_id','left');

        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);

        $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);

       // $this->db->where('fee.fee_division_row_id', $type_id);

        $this->db->where('fee.fee_year', CURRENT_YEAR);

        $this->db->where('fee.is_deleted', 0);

        //$this->db->where('type.is_deleted', 0); 

        if($filter['lang_fee_status'] == false){

            $this->db->where('fee.lang_fee_status!=', 1); 

        }

        if($filter['category'] == 'SC' || $filter['category'] == 'ST' || $filter['category'] == 'CAT-I'){

            $this->db->where('fee.fee_con_sc_st_cat_first_status',1);

        }else{

            $this->db->where('fee.fee_con_sc_st_cat_first_status',0);

        }
        
        $this->db->where('fee.fees_type !=', 'Eligibility Fees'); 
        

       // $this->db->where('acct.is_deleted', 0); 

        $this->db->order_by('fee.fee_amount_state_board','asc');

        $query = $this->db->get();

        return $query->row();

    }

    //check fee paid already

    

    public function getFeePaidInfo($application_no){

        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');

        $this->db->where('fee.is_deleted', 0);

        $this->db->where('fee.payment_year', CURRENT_YEAR);

        $this->db->where('fee.application_no', $application_no);

        $query = $this->db->get();

        return $query->result();

    }



      // add overall fees detail

      public function addFeeDetailsInfo($feeInfo){

        $this->db->trans_start();

        $this->db->insert('tbl_students_overall_fee_payment_info', $feeInfo);

        $insert_id = $this->db->insert_id(); 

        $this->db->trans_complete();

        return $insert_id; 

    }



      // add structure fees detail

      public function addFeePaymentByStructure($feeInfo){

        $this->db->trans_start();

        $this->db->insert('tbl_student_fee_payment_by_structure', $feeInfo);

        $insert_id = $this->db->insert_id(); 

        $this->db->trans_complete();

        return $insert_id; 

    }



    //check and get fee structure paid or not

    public function checkFeeStructurePaidExist($application_no,$fee_type_id){

        $this->db->from('tbl_student_fee_payment_by_structure as structure');

        $this->db->where('structure.is_deleted', 0);

        $this->db->where('structure.application_no', $application_no);

        $this->db->where('structure.fee_type_id', $fee_type_id);

        $query = $this->db->get();

        return $query->row();

    }



       // add paid amoumt for print

       public function addReceiptFeeType($paymentInfo){

        $this->db->trans_start();

        $this->db->insert('tbl_fees_paid_by_receipt', $paymentInfo);

        $insert_id = $this->db->insert_id(); 

        $this->db->trans_complete();

        return $insert_id; 

    }



    //update fee structure payment 

       // update fees type payment info

    public function updateFeesStructurePayment($feePayment,$row_id) {

        $this->db->where_in('row_id', $row_id);

        $this->db->update('tbl_student_fee_payment_by_structure', $feePayment);

        return TRUE;

    }





    //check fee paid already

    

    public function getWorldlinePaymentLogByOrderID($order_id){

        $this->db->from('tbl_worldline_payment_log as fee');

        $this->db->where('fee.order_id', $order_id);

        $query = $this->db->get();

        return $query->row();

    }



    // public function promoteStudent($stdInfo,$application_no) {

    //     $this->db->where_in('application_no', $application_no);

    //     $this->db->update('tbl_student_academic_info', $stdInfo);

    //     return TRUE;

    // }



      //check fee paid already

    

      public function getStudentTotalPaidAmount($application_no){

        $this->db->select('SUM(fee.paid_amount) as paid_amount');

        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');

        $this->db->where('fee.is_deleted', 0);

        $this->db->where('fee.application_no', $application_no);

        $query = $this->db->get();

        return $query->row();

    }



    //get Fee Installment

    public function getInstalmentByStudentId($student_id){

        $this->db->from('tbl_fee_installment as payment');

        $this->db->where('payment.student_id', $student_id);

        $this->db->where('payment.payment_status', 0); 

        $this->db->where('payment.approved_status', 1); 

        $this->db->where('payment.is_deleted', 0);

        $query = $this->db->get();

        return $query->row();

    }



    public function checkInstallmentAlreadyExist($student_id){

        $this->db->from('tbl_fee_installment as payment');

        $this->db->where('payment.student_id', $student_id);

        //$this->db->where('payment.payment_status', 0); 

        //$this->db->where('payment.approved_status', 2); 

        $this->db->where('payment.is_deleted', 0);

        $query = $this->db->get();

        return $query->row();

    }



    public function addInstalmentRequest($feeInfo) {

        $this->db->trans_start();

        $this->db->insert('tbl_fee_installment', $feeInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;

    }



    public function updateInstalment($paymentInfo, $student_id) {

        $this->db->where('student_id', $student_id);

        $this->db->update('tbl_fee_installment', $paymentInfo);

        return TRUE;

    }



    //get student category

    public function getStudentCategoryByApplicationNum($application_number){

        $this->db->from('tbl_admission_students_status as adm');

        $this->db->where('adm.application_number', $application_number);

        //$this->db->where('payment.payment_status', 0); 

        //$this->db->where('payment.approved_status', 2); 

        $this->db->where('adm.is_deleted', 0);

        $query = $this->db->get();

        return $query->row();

    }

    



//admission project model

public function addFeePaymentLogPaytm($paymentInfo){

    $this->db->trans_start();

    $this->db->insert('tbl_paytm_fee_payment_log', $paymentInfo);

    $insert_id = $this->db->insert_id(); 

    $this->db->trans_complete();

    return $insert_id; 

}



 // add from excel

 public function updatePaymentLogPaytm($paymentInfo,$row_id) {

    $this->db->where('row_id', $row_id);

    $this->db->update('tbl_paytm_fee_payment_log',$paymentInfo);

    return TRUE;

}



 // add from excel

 public function updatePaymentLogByOrderIdPaytm($paymentInfo,$order_id) {

    $this->db->where('order_id', $order_id);

    $this->db->update('tbl_paytm_fee_payment_log',$paymentInfo);

    return TRUE;

}

public function getAllFeePaymentLogByApplicationNoPaytm($application_number){

    $this->db->from('tbl_paytm_fee_payment_log as fee');

    $this->db->where('student_id', $application_number);

    $query = $this->db->get();

    return $query->result();

}



public function getReadmissionPayTmLogByAppNo($application_number){

    $this->db->from('tbl_readmission_paytm_fee_payment_log as fee');

    $this->db->where('student_id', $application_number);

    $this->db->where('payment_year', CURRENT_YEAR);

    

    $query = $this->db->get();

    return $query->result();

}





  //get Fee Installment

  public function getInstalmentByApplicationNo($app_no){

    $this->db->from('tbl_new_admission_fee_installment as payment');

    $this->db->where('payment.application_number', $app_no);

    $this->db->where('payment.payment_status', 0); 

    $this->db->where('payment.approved_status', 1); 

    $this->db->where('payment.is_deleted', 0);

    $query = $this->db->get();

    return $query->row();

}



//I PUC

public function getFeePaidInfo_I_PUC($application_no){

    $this->db->from('tbl_admission_students_overall_fee_payment_info as fee');

    $this->db->where('fee.is_deleted', 0);

    //$this->db->where('fee.payment_year', CURRENT_YEAR);

    $this->db->where('fee.application_no', $application_no);

    $query = $this->db->get();

    return $query->result();

}



public function getStudentTotalPaidAmount_I_PUC($application_no){

    $this->db->select('SUM(fee.paid_amount) as paid_amount');

    $this->db->from('tbl_admission_students_overall_fee_payment_info as fee');

    $this->db->where('fee.is_deleted', 0);

    $this->db->where('fee.application_no', $application_no);

    $query = $this->db->get();

    return $query->row();

}

  // add overall fees detail

  public function addFeeDetailsInfo_I_PUC($feeInfo){

    $this->db->trans_start();

    $this->db->insert('tbl_admission_students_overall_fee_payment_info', $feeInfo);

    $insert_id = $this->db->insert_id(); 

    $this->db->trans_complete();

    return $insert_id; 

}



  //get Fee Installment

  public function getInstalmentByApplicationNo_I_PUC($app_no){

    $this->db->from('tbl_new_admission_fee_installment as payment');

    $this->db->where('payment.application_number', $app_no);

    $this->db->where('payment.payment_status', 0); 

    $this->db->where('payment.approved_status', 1); 

    $this->db->where('payment.is_deleted', 0);

    $query = $this->db->get();

    return $query->row();

}



public function getPaymentLogByOrderID($order_id){

    $this->db->from('tbl_paytm_fee_payment_log as fee');

    $this->db->where('fee.order_id', $order_id);

    $query = $this->db->get();

    return $query->row();

}



public function updateFeesOverallPayment($feePayment,$row_id) {

    $this->db->where_in('row_id', $row_id);

    $this->db->update('tbl_admission_students_overall_fee_payment_info', $feePayment);

    return TRUE;

}

public function updateNewAdmInstalment($paymentInfo, $application_number) {

    $this->db->where('application_number', $application_number);

    $this->db->update('tbl_new_admission_fee_installment', $paymentInfo);

    return TRUE;

}





//re admission II PUC Logic



public function getReAdmissionTotalPaidAmount($application_no){

    $this->db->select('SUM(fee.paid_amount) as paid_amount');

    $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');

    $this->db->where('fee.is_deleted', 0);

    $this->db->where('fee.application_no', $application_no);

    $this->db->where('fee.payment_year', CURRENT_YEAR);

    $query = $this->db->get();

    return $query->row();

}



public function getReadmission_FeePaidDetailsByApplicationNo($application_no){

    $this->db->select('fee.paid_amount,fee.payment_count');

    $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');

    $this->db->where('fee.is_deleted', 0);

    $this->db->where('fee.application_no', $application_no);

    $this->db->where('fee.payment_year', CURRENT_YEAR);

    $this->db->order_by('fee.receipt_number', 'DESC');

    $this->db->limit(1);

    $query = $this->db->get();

    return $query->row();

}





public function getReAdmission_PaymentByOrderId($order_id){

    $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');

    $this->db->where('fee.is_deleted', 0);

    $this->db->where('fee.order_id', $order_id);

    $query = $this->db->get();

    return $query->row();

}





//for fee pending amount display and payment 2020

public function getFeePendingAmount($application_no){

    $this->db->from('tbl_fee_pending_info_2021 as fee');

   

    $this->db->where('fee.application_no', $application_no);

    $query = $this->db->get();

    return $query->row();

}

 // add overall fees detail

 public function addReadmission_FeeDetailsInfo($feeInfo){

    $this->db->trans_start();

    $this->db->insert('tbl_students_overall_fee_payment_info_i_puc_2021', $feeInfo);

    $insert_id = $this->db->insert_id(); 

    $this->db->trans_complete();

    return $insert_id; 

}

public function addFeePaymentLogPaytmReadmission($paymentInfo){

    $this->db->trans_start();

    $this->db->insert('tbl_readmission_paytm_fee_payment_log', $paymentInfo);

    $insert_id = $this->db->insert_id(); 

    $this->db->trans_complete();

    return $insert_id; 

}



public function updateReadmission_PaymentLogByOrderIdPaytm($paymentInfo,$order_id) {

    $this->db->where('order_id', $order_id);

    $this->db->update('tbl_readmission_paytm_fee_payment_log',$paymentInfo);

    return TRUE;

}

public function ReAdmission_getFeePaidInfo($application_no){

    $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');

    $this->db->where('fee.is_deleted', 0);

    $this->db->where('fee.payment_year', CURRENT_YEAR);

    $this->db->where('fee.application_no', $application_no);

    $query = $this->db->get();

    return $query->result();

}





 // add from excel

 public function updateFeePaymentLogPaytmReadmission($paymentInfo,$row_id) {

    $this->db->where('row_id', $row_id);

    $this->db->update('tbl_readmission_paytm_fee_payment_log',$paymentInfo);

    return TRUE;

}





//fee pending 2020 I PUC



public function feePendingOld_PaymentByOrderId($order_id){

   

    $this->db->from('tbl_students_overall_fee_payment_info_2020 as fee');

    $this->db->where('fee.is_deleted', 0);

    $this->db->where('fee.order_id', $order_id);

    $query = $this->db->get();

    return $query->row();

}

public function feePendingOld_getFeePendingInfoByStdId($student_id){

    $this->db->from('tbl_fee_pending_info_2021 as fee');

  

    $this->db->where('fee.student_id', $student_id);

    $query = $this->db->get();

    return $query->row();

}



public function addFeePending_FeeDetailsInfo($feeInfo){

    $this->db->trans_start();

    $this->db->insert('tbl_students_overall_fee_payment_info_2020', $feeInfo);

    $insert_id = $this->db->insert_id(); 

    $this->db->trans_complete();

    return $insert_id; 

}



public function feePendingOld_getFeePaidInfo($application_no){

    $this->db->from('tbl_students_overall_fee_payment_info_2020 as fee');

    $this->db->where('fee.is_deleted', 0);

    $this->db->where('fee.application_no', $application_no);

    $query = $this->db->get();

    return $query->result();

}





public function updatePendingFeeOld($paymentInfo, $application_number) {

    $this->db->where('application_no', $application_number);

    $this->db->update('tbl_fee_pending_info_2021', $paymentInfo);

    return TRUE;

}



public function getAllFeePaymentLogByApplicationNoPaytmFeePending($application_number){

    $this->db->from('tbl_paytm_fee_payment_log as fee');

    $this->db->where('remarks', 'FEEPENDING2020');

    $this->db->where('student_id', $application_number);

    $query = $this->db->get();

    return $query->result();

}



public function getFeeStructureInfo2021($filter){

 

    // $this->db->select('SUM(fee.fee_amount_state_board) as total_fee');

    $this->db->from('tbl_admission_fee_structure as fee');

    //$this->db->join('tbl_school_account_type as type', 'type.row_id = fee.school_account_id','left');

   // $this->db->join('tbl_fee_receipt_config_info as acct', 'acct.row_id = fee.school_account_id','left');

    $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);

    $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);

   // $this->db->where('fee.fee_division_row_id', $type_id);

    $this->db->where('fee.fee_year', $filter['fee_year']);

    $this->db->where('fee.is_deleted', 0);

    //$this->db->where('type.is_deleted', 0); 

    if($filter['lang_fee_status'] == false){

        $this->db->where('fee.lang_fee_status!=', 1); 

    }

    if($filter['category'] == 'SC' || $filter['category'] == 'ST' || $filter['category'] == 'CAT-I'){

        $this->db->where('fee.fee_con_sc_st_cat_first_status',1);

    }else{

        $this->db->where('fee.fee_con_sc_st_cat_first_status',0);

    }

    $this->db->where('fee.fees_type !=', 'Eligibility Fees'); 

   // $this->db->where('acct.is_deleted', 0); 

   

    $this->db->order_by('fee.fee_amount_state_board','asc');

    $query = $this->db->get();

    return $query->result();

}

public function checkFeeTypeIsAlreadyPaid($application_no,$fee_id){

    $this->db->from('tbl_fees_paid_by_receipt_v2 as paid');

    $this->db->where('paid.is_deleted', 0);

    $this->db->where('paid.application_no', $application_no);

    $this->db->where('paid.fee_type_id', $fee_id);

    $this->db->order_by('paid.receipt_number', 'DESC');

    $this->db->limit(1);

    $query = $this->db->get();

    return $query->row();

}



   // add paid amoumt for print

   public function addReceiptFeeType2021($paymentInfo){

    $this->db->trans_start();

    $this->db->insert('tbl_fees_paid_by_receipt_v2', $paymentInfo);

    $insert_id = $this->db->insert_id(); 

    $this->db->trans_complete();

    return $insert_id; 

}



public function checkInstallmentAlreadyExistNew($student_id){

    $this->db->from('tbl_student_fee_installment_info as payment');

    $this->db->where('payment.application_no', $student_id);

    $this->db->where('payment.payment_status', 0); 

    $this->db->where('payment.year', CURRENT_YEAR); 

    $this->db->where('payment.is_deleted', 0);

    $query = $this->db->get();

    return $query->row();

}



public function updateInstalmentNew($paymentInfo, $application_no) {

    $this->db->where('application_no', $application_no);

    $this->db->update('tbl_student_fee_installment_info', $paymentInfo);

    return TRUE;

}



public function getLastReceiptNoFromOverall(){

    $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as std');

    $this->db->where('std.payment_year', CURRENT_YEAR);
    
    $this->db->where('std.term_name', 'II PUC');

    $this->db->where('std.is_deleted', 0);

    $this->db->order_by('std.row_id', 'DESC');

    $this->db->limit(1);

    $query = $this->db->get();

    return $query->row()->receipt_number;

}

public function isOrderIDExist($order_id){
    $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
    $this->db->where('fee.is_deleted', 0);
    $this->db->where('fee.order_id', $order_id);
    $query = $this->db->get();
    return $query->row();
}


public function getLastReceiptNoFromOverallI(){
    $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as std');
    $this->db->where('std.payment_year', CURRENT_YEAR);
    $this->db->where('std.term_name', 'I PUC');
    $this->db->where('std.is_deleted', 0);
    $this->db->order_by('std.row_id', 'DESC');
    $this->db->limit(1);
    $query = $this->db->get();
    return $query->row()->receipt_number;
}

public function getTotalFeeAmountIPuc($filter){
    // $this->db->select('fee.row_id');
    // $this->db->from('tbl_admission_fee_structure as fee');
    // $this->db->join('tbl_school_account_type as type', 'type.row_id = fee.school_account_id','left');
    // $this->db->where('type.row_id', 2);
    // $this->db->where('fee.fees_type', 'TUTION FEE');
    // $where_clause = $this->db->get_compiled_select();

    if($filter['board_name'] == 'SSLC'){
        $this->db->select('SUM(fee.fee_amount_state_board) as total_fee'); 
    }else{
        $this->db->select('SUM(fee.fee_amount_icse_cbse) as total_fee');
    }

    $this->db->from('tbl_admission_fee_structure as fee');
    //$this->db->join('tbl_school_account_type as type', 'type.row_id = fee.school_account_id','left');
   // $this->db->join('tbl_fee_receipt_config_info as acct', 'acct.row_id = fee.school_account_id','left');
    $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
    $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);
    $this->db->where('fee.fee_year', CURRENT_YEAR);
    $this->db->where('fee.is_deleted', 0);
    //$this->db->where('type.is_deleted', 0); 
    if($filter['lang_fee_status'] == false){
        $this->db->where('fee.lang_fee_status!=', 1); 
    }
    if($filter['board_name'] == "SSLC"){
        $this->db->where('fee.fees_type!=', 'ELIGIBILITY FEES'); 
    }
    if($filter['category'] == 'SC' || $filter['category'] == 'ST' || $filter['category'] == 'CAT-I'){
        $this->db->where('fee.fee_con_sc_st_cat_first_status',1);
    }else{
        $this->db->where('fee.fee_con_sc_st_cat_first_status',0);
    }
   // $this->db->where('acct.is_deleted', 0); 
  //$this->db->order_by('fee.fee_amount_state_board','asc');
    $query = $this->db->get();
    return $query->row();
}



}