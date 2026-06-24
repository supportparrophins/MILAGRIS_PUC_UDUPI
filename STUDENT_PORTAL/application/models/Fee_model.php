<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Fee_model extends CI_Model
{

    
    public function getFeeConcessionInfo($filter='') {
        $this->db->select('std.student_id,fee.row_id,fee.fee_amt,fee.approved_status,fee.date,fee.description,std.application_no,
        fee.payment_status,std.student_name,fee.year');
        $this->db->from('tbl_student_fee_concession as fee');
        $this->db->join('tbl_students_info as std','std.row_id = fee.application_no'); 
        // $this->db->join('tbl_student_academic_info as academic', 'academic.application_no = std.application_no','left');
        
        if(!empty($filter['by_name'])) {
            $likeCriteria = "(std.student_name LIKE '%".$filter['by_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['amount'])){
            $this->db->where('fee.fee_amt', $filter['amount']);
        } 
        if(!empty($filter['student_id'])){
            $this->db->where('std.application_no', $filter['student_id']);
        } 
        if(!empty($filter['by_date'])){
            $likeCriteria = "(fee.date LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        } 
        if(!empty($filter['con_year'])){
            $this->db->where('fee.year', $filter['con_year']);
        }else{
            $this->db->where('fee.year', CURRENT_YEAR);
        } 
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $this->db->order_by('fee.row_id','DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }
    public function getFeeConcessionCount($filter='') {
        $this->db->select('std.student_id,fee.row_id,fee.fee_amt,fee.approved_status,fee.date,fee.description,fee.application_no,
        fee.payment_status,std.student_name');
        $this->db->from('tbl_student_fee_concession as fee');
        $this->db->join('tbl_students_info as std','std.row_id = fee.application_no'); 
        // $this->db->join('tbl_student_academic_info as academic', 'academic.application_no = std.application_no','left');
        
        if(!empty($filter['by_name'])) {
            $likeCriteria = "(std.student_name LIKE '%".$filter['by_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['amount'])){
            $this->db->where('fee.fee_amt', $filter['amount']);
        } 
         if(!empty($filter['student_id'])){
            $this->db->where('std.application_no', $filter['student_id']);
        } 
        if(!empty($filter['by_date'])){
            $likeCriteria = "(fee.date LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        } 
        if(!empty($filter['con_year'])){
            $this->db->where('fee.year', $filter['con_year']);
        }else{
            $this->db->where('fee.year', CURRENT_YEAR);
        } 
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    // admission 
    public function getFeeConcessionNewAdmCount($filter='') {
        
        $this->db->from('tbl_new_admission_fee_concession as fee');
        $this->db->join('tbl_student_personal_details as std','std.application_number = fee.application_no');
        if(!empty($filter['by_name'])) {
            $likeCriteria = "(fee.student_name LIKE '%".$filter['by_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['amount'])){
            $this->db->where('fee.fee_amt', $filter['amount']);
        } 
        if(!empty($filter['application_no'])){
            $this->db->where('std.application_number', $filter['application_no']);
        } 
        if(!empty($filter['by_date'])){
            $likeCriteria = "(fee.date LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        } 
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function getFeeConcessionNewAdmInfo($filter='') {
        $this->db->select('fee.row_id,fee.fee_amt,fee.approved_status,fee.date,fee.description,fee.application_no,
        fee.payment_status,std.name as student_name');
        $this->db->from('tbl_new_admission_fee_concession as fee');
        $this->db->join('tbl_student_personal_details as std','std.application_number = fee.application_no');
        if(!empty($filter['by_name'])) {
            $likeCriteria = "(fee.student_name LIKE '%".$filter['by_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['amount'])){
            $this->db->where('fee.fee_amt', $filter['amount']);
        } 
        if(!empty($filter['application_no'])){
            $this->db->where('std.application_number', $filter['application_no']);
        } 
        if(!empty($filter['by_date'])){
            $likeCriteria = "(fee.date LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        } 
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $this->db->order_by('fee.row_id','DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }




    
    public function getFeeConcessionById($row_id) {
        $this->db->select('fee.row_id,fee.fee_amt,fee.approved_status,fee.date,fee.description,fee.application_no,
        fee.payment_status,std.student_name,fee.year');
        $this->db->from('tbl_student_fee_concession as fee');
        $this->db->join('tbl_students_info as std','std.row_id = fee.application_no'); 
        $this->db->where('fee.row_id', $row_id);
        $this->db->where('fee.is_deleted', 0); 
        $query = $this->db->get();
        return $query->row();
    }
   
    public function addConcession($feeInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_student_fee_concession', $feeInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function addNewAdmFeeConcession($feeInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_new_admission_fee_concession', $feeInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }


    
    public function updateConcession($feeInfo, $row_id) {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_student_fee_concession', $feeInfo);
        return TRUE;
    }

    public function getFeeInfoByReceiptNum($receipt_number){
        $this->db->from('tbl_new_admission_overall_fee_payment_info as fee');
        //$this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.row_id', $receipt_number);
        $query = $this->db->get();
        return $query->row();
    }

    public function updateReceiptNumber($feePayment,$row_id) {
        $this->db->where_in('row_id', $row_id);
        $this->db->update('tbl_new_admission_overall_fee_payment_info', $feePayment);
        return TRUE;
    }

    public function getFeeInfoByGovtReceiptNum($receipt_number){
        $this->db->from('tbl_govt_fee_paid_info as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.row_id', $receipt_number);
        $query = $this->db->get();
        return $query->row();
    }

    public function updateGovtReceiptNumber($feePayment,$row_id) {
        $this->db->where_in('row_id', $row_id);
        $this->db->update('tbl_govt_fee_paid_info', $feePayment);
        return TRUE;
    }

    public function getAllFeePaidInfo($receipt_number){
        $this->db->select('
        fee.row_id, 
        fee.fees_type,
        paid.paid_amount,
        paid.application_no,
        paid.pending_amt,
        name.fee_name,');
        $this->db->from('tbl_fees_paid_by_receipt as paid');
        $this->db->join('tbl_admission_fee_structure as fee', 'fee.row_id = paid.fee_type_id','left');
        $this->db->join('tbl_fee_required_type as type', 'type.fee_structure_row_id = fee.row_id','right');
        $this->db->join('tbl_fees_name as name', 'name.row_id = fee.fees_type','left');
        $this->db->where('paid.is_deleted', 0);
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('paid.receipt_number', $receipt_number);
        // $this->db->order_by('paid.paid_amount','ASC');
        $this->db->group_by('paid.fee_type_id');
        $query = $this->db->get();
        return $query->result();
    }


    public function addDDInfo($ddInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_fee_payment_dd_info', $ddInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function addBankInfo($bankInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_fee_payment_bank_info', $bankInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }









    

     //get students fetails lates update
     public function downloadAdmittedStudentFeePaidReport($filter){ 
        $this->db->select('std.row_id,
        std.application_no,
        std.student_name,
        ac.stream_name,
        ac.elective_sub,
        ac.student_id,
        fee.paid_amount,
        fee.pending_balance,
        ');
        $this->db->from('tbl_students_info as std');
        $this->db->join('tbl_student_academic_info as ac', 'ac.application_no = std.application_no','left');
        $this->db->join('tbl_students_overall_fee_payment_info as fee', 'fee.application_no = std.application_no','left');
        if(!empty($filter['stream_name'])){
            $this->db->where('ac.stream_name', $filter['stream_name']);
        }
        if(!empty($filter['elective_sub'])){
            $this->db->where('ac.elective_sub',strtoupper($filter['elective_sub']));
        }
        
      
        if($filter['paid_type'] == 'HALF'){
            $this->db->where('fee.fee_pending_status', 1);
        }else if($filter['paid_type'] == 'FULL'){
            $this->db->where('fee.fee_pending_status', 0);
        }

        $this->db->where('std.intake_year_id', 2019);
    
       // $this->db->where('std.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $this->db->where('ac.is_deleted', 0);
        $this->db->order_by('ac.student_id', 'DESC');
       
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    
    public function getAllFeeInstallmentInfo($filter, $page, $segment){
        $this->db->select('feeInsta.row_id, feeInsta.application_no, feeInsta.last_date,feeInsta.remarks, feeInsta.amount,
        feeInsta.payment_status,std.student_name,std.student_id');
        $this->db->from('tbl_student_fee_installment_info as feeInsta'); 
        $this->db->join('tbl_students_info as std','std.application_no = feeInsta.application_no'); 
        //$this->db->join('tbl_student_academic_info as academic', 'academic.application_no = std.application_no','left');
        if(!empty($filter['student_name'])){
            $likeCriteria = "(std.student_name  LIKE '%" . $filter['student_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('std.student_id', $filter['student_id']);
        }
        if(!empty($filter['last_date'])){
            $this->db->where('feeInsta.last_date', $filter['last_date']);
        }
        if(!empty($filter['amount'])){
            $likeCriteria = "(feeInsta.amount  LIKE '%" . $filter['amount'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['year'])){
            $this->db->where('feeInsta.year', $filter['year']);
        }else{
            $this->db->where('feeInsta.year', CURRENT_YEAR);
        }
        $this->db->where('feeInsta.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $this->db->order_by('feeInsta.row_id','DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }

    public function getFeeInstallmentCount($filter=''){
        $this->db->from('tbl_student_fee_installment_info as feeInsta'); 
        $this->db->join('tbl_students_info as std','std.application_no = feeInsta.application_no'); 
       // $this->db->join('tbl_student_academic_info as academic', 'academic.application_no = std.application_no','left');
        if(!empty($filter['student_name'])){
            $likeCriteria = "(std.student_name  LIKE '%" . $filter['student_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('std.student_id', $filter['student_id']);
        }
        if(!empty($filter['last_date'])){
            $this->db->where('feeInsta.last_date', $filter['last_date']);
        }
        if(!empty($filter['amount'])){
            $likeCriteria = "(feeInsta.amount  LIKE '%" . $filter['amount'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['year'])){
            $this->db->where('feeInsta.year', $filter['year']);
        }else{
            $this->db->where('feeInsta.year', CURRENT_YEAR);
        }
        $this->db->where('std.is_deleted', 0);
        $this->db->where('feeInsta.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function addFeeInstallment($installmentInfo){
            $this->db->trans_start();
            $this->db->insert('tbl_student_fee_installment_info', $installmentInfo);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            return $insert_id;
        }

   public function getFeeInstallmentById($row_id) {
        $this->db->select('feeInstall.row_id,feeInstall.amount,feeInstall.last_date,feeInstall.remarks,
        feeInstall.application_no,feeInstall.payment_status,feeInstall.year,std.student_name,std.student_id');
        $this->db->from('tbl_student_fee_installment_info as feeInstall');
        $this->db->join('tbl_students_info as std','std.application_no = feeInstall.application_no'); 
       // $this->db->join('tbl_student_academic_info as academic', 'academic.application_no = std.application_no','left');
        $this->db->where('feeInstall.row_id', $row_id);
        $this->db->where('feeInstall.is_deleted', 0); 
        $query = $this->db->get();
        return $query->row();
        }

    function updateFeeInstallment($installmentInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_student_fee_installment_info', $installmentInfo);
        return TRUE;
    }

    
    public function addStudentMngtFee($feeInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_student_management_fee_info', $feeInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    
    public function getStdMngtFeeInfoInfo($filter='') {
        $this->db->select('fee.row_id,fee.application_no,fee.amount,fee.date,personal.name,log.order_id,stream.stream_name');
        $this->db->from('tbl_student_management_fee_info as fee');
        $this->db->join('tbl_paytm_fee_payment_log as log', 'log.application_no = fee.application_no','left');
        $this->db->join('tbl_admission_students_status_temp as std', 'std.application_number = fee.application_no','left');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'personal.application_number = std.application_number','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as stream', 'stream.registred_row_id = personal.resgisted_tbl_row_id','left');
        
        if(!empty($filter['by_name'])) {
            $likeCriteria = "(personal.name LIKE '%".$filter['by_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['amount'])){
            $this->db->where('fee.amount', $filter['amount']);
        } 
        if(!empty($filter['order_id'])){
            $this->db->where('log.order_id', $filter['order_id']);
        } 
         if(!empty($filter['student_id'])){
            $this->db->where('fee.application_no', $filter['student_id']);
        } 
        if(!empty($filter['by_date'])){
            $likeCriteria = "(fee.date LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        } 
        if(!empty($filter['stream_name'])){
            $this->db->where('stream.stream_name', $filter['stream_name']);
        } 
        $this->db->where('log.remarks', 'Agnes Admission Mgmt Fee');
        $this->db->where('log.payment_status', 'TXN_SUCCESS');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $this->db->order_by('fee.row_id','DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }
    public function getStdMngtFeeInfoInfoCount($filter='') {
        $this->db->from('tbl_student_management_fee_info as fee');
        $this->db->join('tbl_paytm_fee_payment_log as log', 'log.application_no = fee.application_no','left');
        $this->db->join('tbl_admission_students_status_temp as std', 'std.application_number = fee.application_no','left');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'personal.application_number = std.application_number','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as stream', 'stream.registred_row_id = personal.resgisted_tbl_row_id','left');
        
        if(!empty($filter['by_name'])) {
            $likeCriteria = "(personal.name LIKE '%".$filter['by_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['amount'])){
            $this->db->where('fee.amount', $filter['amount']);
        } 
        if(!empty($filter['order_id'])){
            $this->db->where('log.order_id', $filter['order_id']);
        } 
        if(!empty($filter['student_id'])){
            $this->db->where('fee.application_no', $filter['student_id']);
        } 
        if(!empty($filter['stream_name'])){
            $this->db->where('stream.stream_name', $filter['stream_name']);
        } 
        if(!empty($filter['by_date'])){
            $likeCriteria = "(fee.date LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        } 
        $this->db->where('log.remarks', 'Agnes Admission Mgmt Fee');
        $this->db->where('log.payment_status', 'TXN_SUCCESS');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getStudentManagementFeeInfoById($row_id) {
        $this->db->select('fee.row_id,fee.application_no,fee.amount,fee.date,personal.name,personal.father_name,
        personal.permanent_address,stream.stream_name,stream.second_language');
        $this->db->from('tbl_student_management_fee_info as fee');
        $this->db->join('tbl_admission_students_status_temp as std', 'std.application_number = fee.application_no','left');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'personal.application_number = std.application_number','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as stream', 'stream.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->where('fee.row_id', $row_id);
        $this->db->where('fee.is_deleted', 0); 
        $query = $this->db->get();
        return $query->row();
    }

    
    public function getSumOfManagementFee() {
        $this->db->select('SUM(fee.amount) as total_amount');
        $this->db->from('tbl_student_management_fee_info as fee');
        $this->db->where('fee.is_deleted', 0); 
        $query = $this->db->get();
        return $query->row();
    }

    
    public function updateManagementFee($feeInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_student_management_fee_info', $feeInfo);
        return TRUE;
    }

    public function checkStudentForMngtFeeExists($application_no,$row_id='') {
        $this->db->from('tbl_student_management_fee_info as fee');
        $this->db->where('fee.application_no', $application_no);
        if(!empty($row_id)){
            $this->db->where('fee.row_id !=', $row_id);
        }
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getFeePendingAmount2021($student_id){
        $this->db->from('tbl_fee_pending_info_2021 as student'); 
        $this->db->where('student.student_id', $student_id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    //old fee info update
    public function addFeeDetails2020IPUC($feeInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_admission_students_overall_fee_payment_info', $feeInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }

    public function getLastReceiptNo2021(){
        $this->db->select('fee.receipt_number');
        $this->db->from('tbl_admission_students_overall_fee_payment_info as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->order_by('fee.row_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    public function addReceiptFeeTypeOld($paymentInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_fees_paid_by_receipt', $paymentInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }

    public function checkFeeTypeIsAlreadyPaid2021($application_no,$fee_id){
        $this->db->from('tbl_fees_paid_by_receipt as paid');
        $this->db->where('paid.is_deleted', 0);
        $this->db->where('paid.application_no', $application_no);
        $this->db->where('paid.fee_type_id', $fee_id);
        $this->db->order_by('paid.receipt_number', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    public function getFeePaidInfo2019($application_no){
        $this->db->from('tbl_students_overall_fee_payment_info as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function addFeePending2019($feeInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_students_overall_fee_payment_info', $feeInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }

    public function addFeePending_FeeDetailsInfo($feeInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_students_overall_fee_payment_info_2020', $feeInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }

    public function updatePendingFeeOld($paymentInfo, $application_number) {
        $this->db->where('application_no', $application_number);
        $this->db->update('tbl_fee_pending_info_2021', $paymentInfo);
        return TRUE;
    }

    
    public function getFeePaidInfo2021($application_no){
        $this->db->from('tbl_students_overall_fee_payment_info_2021 as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    public function getFeePaidInfo2020($application_no){
        $this->db->from('tbl_admission_students_overall_fee_payment_info as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function getFeeDDInfo($receipt_number){
        $this->db->from('tbl_fee_payment_dd_info as student'); 
        $this->db->where('student.receipt_number', $receipt_number);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
    public function getFeeCardInfo($receipt_number){
        $this->db->from('tbl_fee_payment_bank_info as student'); 
        $this->db->where('student.receipt_number', $receipt_number);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function getFeeInfoByReceiptNum_2020($receipt_number){
        $this->db->from('tbl_students_overall_fee_payment_info_2020 as fee'); 
        $this->db->where('fee.receipt_number', $receipt_number);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function getFeeInfoByReceiptNum_2020old($receipt_number){
        $this->db->from('tbl_admission_students_overall_fee_payment_info as fee'); 
        $this->db->where('fee.receipt_number', $receipt_number);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function getFeeInfoByReceiptNum_2019old($receipt_number){
        $this->db->from('tbl_students_overall_fee_payment_info as fee'); 
        $this->db->where('fee.receipt_number', $receipt_number);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
    

    //total fee for readmission
    public function getTotalFeeAmount($filter){
        $this->db->select('SUM(fee.fee_amount_state_board) as total_fee');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
        $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);
        $this->db->where_in('fee.gender', [$filter['gender'],'ALL']);
        $this->db->where('fee.fee_year', $filter['fee_year']);
        $this->db->where_in('fee.fee_student_type', [$filter['student_fee_type'],'ALL']);
        $this->db->where('fee.is_deleted', 0);
        $this->db->where_not_in('fee.fees_type', ['1']);
        $query = $this->db->get();
        return $query->row();
    }

     public function getGovtFeeAmount($filter){
        $this->db->select('SUM(fee.fee_amount_state_board) as total_fee');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
        $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);
        $this->db->where_in('fee.gender', [$filter['gender'],'ALL']);
        $this->db->where('fee.fee_year', $filter['fee_year']);
        $this->db->where('fee.is_deleted', 0);
        $this->db->where_in('fee.fees_type', ['1']);
        $query = $this->db->get();
        return $query->row()->total_fee;
    }

     public function getAllFeeStructureInfoForReceipt($filter){
        $this->db->select('
        type.priority, 
        fee.row_id, 
        fee.fees_type,
        fee.fee_amount_state_board,
        fee.account_row_id,
        fee.bank_account_row_id_two,
        type.row_id as fee_division_id,
        type.fee_name as fee_type_name');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->join('tbl_fees_name as type', 'type.row_id = fee.fees_type','left');
        $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);
        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
        $this->db->where_in('fee.gender', [$filter['gender'],'ALL']);
        $this->db->where_in('fee.fee_student_type', [$filter['student_fee_type'],'ALL']);
        if(!empty($filter['fee_year'])){
            $this->db->where('fee.fee_year', $filter['fee_year']);
        }
        $this->db->where('fee.is_deleted', 0);
        $this->db->order_by('type.priority','asc');
        $query = $this->db->get();
        return $query->result();
    }
    public function getTotalFeeAccountAmount($filter){
        $this->db->select('
        type.priority, 
        fee.row_id, 
        fee.fees_type,
        fee.fee_amount_state_board,
        fee.account_row_id,
        fee.bank_account_row_id_two,
        type.row_id as fee_division_id,
        type.fee_name as fee_type_name');
         $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->join('tbl_fees_name as type', 'type.row_id = fee.fees_type','left');
        $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);
        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
        $this->db->where_in('fee.gender', [$filter['gender'],'ALL']);
        $this->db->where_in('fee.fee_student_type', [$filter['student_fee_type'],'ALL']);
        if(!empty($filter['fee_year'])){
            $this->db->where('fee.fee_year', $filter['fee_year']);
        }
        $this->db->where('fee.is_deleted', 0);
        $this->db->order_by('type.priority','asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function getTotalFeeAmountForReport($filter){
 
        $this->db->select('SUM(fee.fee_amount_state_board) as total_fee');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
        $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);
        $this->db->where('fee.fee_year', $filter['fee_year']);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getStudFeeConcession($student_row_id,$year){
        $this->db->select('SUM(fee.fee_amt) as fee_amt');
        $this->db->from('tbl_student_fee_concession as fee');
        $this->db->where('fee.application_no', $student_row_id);
        $this->db->where('fee.approved_status', 1);
        $this->db->where('fee.year', $year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getFeePaidInfoForReport($application_no,$payment_year){
        $this->db->select('SUM(fee.paid_amount) as paid_amount');
        $this->db->from('tbl_new_admission_overall_fee_payment_info as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year',$payment_year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
   
    public function getGovtFeePaidInfoForReport($application_no,$payment_year){
        $this->db->select('SUM(fee.paid_amount) as paid_amount');
        $this->db->from('tbl_govt_fee_paid_info as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year',$payment_year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function getLastGovtReceiptNo($year){
        $this->db->select('fee.receipt_number');
        $this->db->from('tbl_govt_fee_paid_info as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.payment_year', $year);
        $this->db->order_by('fee.row_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    public function addGovtFeeDetail($deptInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_govt_fee_paid_info', $deptInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getFeeConcessionByAppNo($application_no,$year) {
        $this->db->select('fee.fee_amt as amount');
        $this->db->from('tbl_student_fee_concession as fee');
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.year', $year);
        $this->db->where('fee.approved_status', 1); 
        $this->db->where('fee.is_deleted', 0); 
        $query = $this->db->get();
        return $query->row()->amount;
    }


    
    public function getGovtFeeOverallInfo() {
        $this->db->from('tbl_govt_fee_paid_info as fee'); 
        $this->db->where('fee.is_deleted', 0); 
        $query = $this->db->get();
        return $query->result();
    }
    
    public function updateMgmtReceiptNo($row_id,$feePayment) {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_new_admission_overall_fee_payment_info', $feePayment);
        return TRUE;
    }

    
    public function updateReceiptNo($row_id,$feePayment) {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_govt_fee_paid_info', $feePayment);
        return TRUE;
    }

    public function getSumOfFeesPaid($application_no,$year){
        $this->db->select('SUM(fee.paid_amount) as paid_amount');
        $this->db->from('tbl_new_admission_overall_fee_payment_info as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year', $year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
    public function getTotalFeeAmountByType($filter,$type){
 
        $this->db->select('SUM(fee.fee_amount) as total_fee');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
        $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);
        $this->db->where('fee.fee_year', $filter['fee_year']);
        $this->db->where('fee.type', $type);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row()->total_fee;
    }
    
    public function addFeeDetailsNewAdmission($feeInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_new_admission_overall_fee_payment_info', $feeInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }
    public function getStdPaidDetailsByApplicationNo($application_no){
        $this->db->select('fee.paid_amount,fee.payment_count');
        $this->db->from('tbl_students_overall_fee_payment_info_2021 as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.application_no', $application_no);
        $this->db->order_by('fee.receipt_number', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    public function getFeeInfoByReceiptNum_2021($receipt_number){
        $this->db->from('tbl_students_overall_fee_payment_info as fee'); 
        $this->db->where('fee.row_id', $receipt_number);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function getFeeInfoByReceiptNumOld($receipt_number){
        $this->db->from('tbl_students_overall_fee_payment_info_2021 as fee'); 
        $this->db->where('fee.receipt_number', $receipt_number);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function getFeeStructureInfo($filter){
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
        $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);
        $this->db->where('fee.fee_year', $filter['fee_year']);
        $this->db->where('fee.is_deleted', 0);
        $this->db->where_not_in('fee.fees_type', ['Tution Fees','Development fees']);
        $this->db->order_by('fee.fee_amount_state_board', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

   public function getMgmtFeeStructureInfo($filter){
        $this->db->select('fee.*,type.fee_name,type.row_id as type_id');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->join('tbl_fees_name as type', 'type.row_id = fee.fees_type','left');
        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
        $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);
        $this->db->where_in('fee.gender', [$filter['gender'],'ALL']);
        $this->db->where('fee.fee_year', $filter['fee_year']);
        $this->db->where('fee.is_deleted', 0);
        $this->db->where_not_in('fee.fees_type', ['1']);
        $this->db->order_by('type.priority', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

     public function getGovrnmentFeeStructureInfo($filter){
        $this->db->select('fee.*,type.fee_name,type.row_id as type_id');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->join('tbl_fees_name as type', 'type.row_id = fee.fees_type','left');
        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
        $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);
        $this->db->where_in('fee.gender', [$filter['gender'],'ALL']);
        $this->db->where('fee.fee_year', $filter['fee_year']);
        $this->db->where('fee.is_deleted', 0);
        $this->db->where_in('fee.fees_type', ['1']);
        $this->db->order_by('type.priority', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function getFeeReceiptPrintNameInfo($fee_type_id,$receipt_number,$application_no){
        $this->db->select('
        fee.payment_date,fee.receipt_no,
        fee.receipt_number,
        fee.application_no,
        fee.paid_amount');
        $this->db->from('tbl_fees_paid_by_receipt_v2 as fee'); 
        // $this->db->join('tbl_admission_fee_structure as stru', 'stru.row_id = fee.fee_type_id','left');
        // $this->db->join('tbl_fees_name as type', 'type.row_id = stru.fees_type','left');
        $this->db->where('fee.receipt_number', $receipt_number);
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.fee_type_id', $fee_type_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getAdmissionFeePaidInfoById($receipt_number,$application_no){
        $this->db->select('
        fee.row_id, 
        fee.fees_type,
        paid.paid_amount,
        paid.application_no,
        fee.fees_type as fee_name');
        $this->db->from('tbl_fees_paid_by_receipt_v2 as paid');
        $this->db->join('tbl_admission_fee_structure as fee', 'fee.row_id = paid.fee_type_id','left');
        $this->db->where('paid.is_deleted', 0);
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('paid.receipt_number', $receipt_number);
        $this->db->where('paid.application_no', $application_no);
        $this->db->order_by('paid.paid_amount','ASC');
        $this->db->group_by('paid.fee_type_id');
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
        if($filter['board_name'] == "SSLC"){
            $this->db->where('fee.fees_type!=', 'ELIGIBILITY FEES'); 
        }
       // $this->db->where('acct.is_deleted', 0); 
        $this->db->order_by('fee.fee_amount_state_board','asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function getSUM_Paid_FeeInfoByReceiptNum_2021($application_no,$year){
        $this->db->select('SUM(fee.paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year', $year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
    public function getSUM_Paid_FeeInfoIIPucLastYear($application_no){
        $this->db->select('SUM(fee.paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info_2021 as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
    public function getSUM_Paid_FeeInfoByReceiptNum_2021_I_PUC($application_no,$year){
        $this->db->select('SUM(fee.paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.term_name', 'I PUC');
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    
    public function updateGovtFeeSettleStatus($feeInfo, $row_id) {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_govt_fee_paid_info', $feeInfo);
        return TRUE;
    }
    
    
    public function getCancelReceiptInfoForReport($filter){
        $this->db->select('fee.payment_date, fee.payment_type,fee.paid_amount,fee.pending_balance, fee.total_amount,
        fee.row_id,fee.receipt_number,student.application_no,student.student_name,student.term_name,student.stream_name,
        fee.payment_year,fee.remarks');
        $this->db->from('tbl_new_admission_overall_fee_payment_info as fee');
        $this->db->join('tbl_students_info as student', 'student.row_id = fee.application_no','left');
      //  $this->db->join('tbl_student_academic_info as academic', 'academic.application_no = student.application_no','left');

        
         if(!empty($filter['year'])){
            $this->db->where('fee.payment_year', $filter['year']);
        }
          
        $this->db->order_by('fee.row_id','ASC');
        $this->db->where('fee.is_deleted', 1);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getCancelReceiptInfoForReportForGovt($filter){
        $this->db->select('fee.payment_date, fee.payment_type,fee.paid_amount, 
        fee.row_id,fee.receipt_number,student.application_no,student.student_name,student.term_name,student.stream_name,
        fee.payment_year,fee.remarks');
        $this->db->from('tbl_govt_fee_paid_info as fee');
        $this->db->join('tbl_students_info as student', 'student.row_id = fee.application_no','left');
       // $this->db->join('tbl_student_academic_info as academic', 'academic.application_no = student.application_no','left');

        
         if(!empty($filter['year'])){
            $this->db->where('fee.payment_year', $filter['year']);
        }
          
        $this->db->order_by('fee.row_id','ASC');
        $this->db->where('fee.is_deleted', 1);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getConcessionFeeReport($filter='')
    {
        $this->db->select('student.row_id, student.student_name,student.student_id,student.term_name,
        student.section_name,student.stream_name,student.register_no,student.application_no,
        fee.fee_amt,fee.date,fee.description,fee.year');
        
        $this->db->from('tbl_student_fee_concession as fee');
       // $this->db->join('tbl_student_academic_info as academic', 'academic.application_no = fee.application_no','left');
        $this->db->join('tbl_students_info as student', 'student.row_id = fee.application_no','left');
        
       
        if(!empty($filter['year'])){
            $this->db->where('fee.year', $filter['year']);
        }
        if(!empty($filter['term_name'])){
            $this->db->where('student.term_name', $filter['term_name']);
        }
        if($filter['concession_status'] == 'APPROVED'){
            $this->db->where('fee.approved_status',1);
        }else if($filter['concession_status'] == 'REJECTED'){
            $this->db->where('fee.approved_status',2);
        }else if($filter['concession_status'] == 'PENDING'){
            $this->db->where('fee.approved_status',0);
        }
        $this->db->order_by('fee.row_id', 'ASC');
        $this->db->where('fee.is_deleted', 0);
        // $this->db->where('academic.stream_name', 'PCMB');
        $query = $this->db->get();
        return $query->result();
    }

    
    public function getGovtFeeForReport($filter='')
    {
        
        $this->db->from('tbl_govt_fee_paid_info as fee');
        if(!empty($filter['date_from'])){
            $this->db->where('fee.payment_date>=', $filter['date_from']);
        }
        if(!empty($filter['date_to'])){
            $this->db->where('fee.payment_date<=', $filter['date_to']);
        }

        if(!empty($filter['year'])){
            $this->db->where('fee.payment_year', $filter['year']);
        }

        if(!empty($filter['payment_type'])){
            $this->db->where_in('fee.payment_type', $filter['payment_type']);
        }
        if(!empty($filter['term_name'])){
            $this->db->where('fee.term_name', $filter['term_name']);
        }
        if(!empty($filter['settlement_type']) && $filter['settlement_type'] =="SETTLED" ){
            $this->db->where('fee.bank_settlement_status', 1);
        }else if($filter['settlement_type'] =="PENDING"){
             $this->db->where('fee.bank_settlement_status', 0);
        }
        
        $this->db->order_by('fee.row_id', 'ASC');
        $this->db->order_by('fee.receipt_number', 'ASC');
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getManagementFeeForReport($filter='')
    {
         
        $this->db->from('tbl_new_admission_overall_fee_payment_info as fee');
        
        if(!empty($filter['date_from'])){
            $this->db->where('fee.payment_date>=', $filter['date_from']);
        }
        if(!empty($filter['date_to'])){
            $this->db->where('fee.payment_date<=', $filter['date_to']);
        }
        if(!empty($filter['year'])){
            $this->db->where('fee.payment_year', $filter['year']);
        }
        if(!empty($filter['payment_type'])){
            $this->db->where_in('fee.payment_type', $filter['payment_type']);
        }
        if(!empty($filter['term_name'])){
            $this->db->where('fee.term_name', $filter['term_name']);
        }
        if(!empty($filter['term_name'])){
            $this->db->where('fee.term_name', $filter['term_name']);
        }
        if(!empty($filter['settlement_type']) && $filter['settlement_type'] =="SETTLED" ){
            $this->db->where('fee.bank_settlement_status', 1);
        }else if($filter['settlement_type'] =="PENDING"){
             $this->db->where('fee.bank_settlement_status', 0);
        }

        $this->db->order_by('fee.row_id', 'ASC');
        $this->db->order_by('fee.receipt_number', 'ASC');
        $this->db->where('fee.is_deleted !=', 1);
        $query = $this->db->get();
        return $query->result();
    }
    //get all fee payment info

    //get students fetails lates update
    public function getAllFeePaymentInfoCount($filter='')
    {
        $this->db->from('tbl_new_admission_overall_fee_payment_info as fee');
        $this->db->join('tbl_students_info as std', 'std.row_id = fee.application_no','left');
      //  $this->db->join('tbl_fee_payment_bank_settlement as bank', 'bank.receipt_number = fee.row_id','left');
    

        if(!empty($filter['application_no'])){
            $this->db->where('std.application_no', $filter['application_no']);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('std.application_no', $filter['student_id']);
        }
        if(!empty($filter['date_select'])){
         $this->db->where('fee.payment_date', $filter['date_select']);
        }
        if(!empty($filter['receipt_number'])){
         $this->db->where('fee.receipt_number', $filter['receipt_number']);
        }
        if(!empty($filter['amount_paid'])){
         $this->db->where('fee.paid_amount', $filter['amount_paid']);
        }
        if(!empty($filter['amount_pending'])){
         $this->db->where('fee.pending_balance', $filter['amount_pending']);
        }
        if(!empty($filter['order_id'])){
         $this->db->where('fee.order_id', $filter['order_id']);
        }
        if(!empty($filter['student_name'])){
            $likeCriteria = "(std.student_name  LIKE '%" . $filter['student_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['payment_type'])){
         $this->db->where('fee.payment_type', $filter['payment_type']);
        }
        if(!empty($filter['fee_type'])){
            $this->db->where('fee.fee_type', $filter['fee_type']);
           }
        if(!empty($filter['by_term'])){
            $this->db->where('fee.term_name', $filter['by_term']);
        }
        if($filter['bank_settlement'] == 'Settled'){
         $this->db->where('fee.bank_settlement_status', 1);
        }else if($filter['bank_settlement'] == 'Pending'){
         $this->db->where('fee.bank_settlement_status', 0);
        }
        if(!empty($filter['by_bank_date'])){
         $this->db->where('fee.bank_settlement_date', $filter['by_bank_date']);
        }
        if(!empty($filter['by_year'])){
            $this->db->where('fee.payment_year', $filter['by_year']);
           }else{
              $this->db->where('fee.payment_year', CURRENT_YEAR);
           }
           if(!empty($filter['created_by'])){
            $this->db->where('fee.created_by', $filter['created_by']); 
        }
        if(!empty($filter['created_date_time'])){
            $this->db->where('DATE(fee.created_date_time)', $filter['created_date_time']);
        }
       $this->db->where('fee.is_deleted', 0);
       $query = $this->db->get();
       return $query->num_rows();
   }
 
       //get students fetails lates update
       public function getAllFeePaymentInfo($page, $segment, $filter='')
       {
             $this->db->select('fee.payment_date,fee.row_id,std.student_id,std.student_name,std.application_no,
             fee.receipt_number,fee.order_id,fee.paid_amount, fee.pending_balance,
             fee.payment_type, fee.bank_settlement_status,fee.term_name,fee.bank_settlement_date as date');
             $this->db->from('tbl_new_admission_overall_fee_payment_info as fee');
             $this->db->join('tbl_students_info as std', 'std.row_id = fee.application_no','left');
           //  $this->db->join('tbl_fee_payment_bank_settlement as bank', 'bank.receipt_number = fee.row_id','left');
             if(!empty($filter['application_no'])){
                $this->db->where('std.application_no', $filter['application_no']);
            }
             if(!empty($filter['student_id'])){
                 $this->db->where('std.application_no', $filter['student_id']);
             }
             if(!empty($filter['student_name'])){
                $likeCriteria = "(std.student_name  LIKE '%" . $filter['student_name'] . "%')";
                $this->db->where($likeCriteria);
            }
             if(!empty($filter['date_select'])){
              $this->db->where('fee.payment_date', $filter['date_select']);
             }
             if(!empty($filter['receipt_number'])){
              $this->db->where('fee.receipt_number', $filter['receipt_number']);
             }
             if(!empty($filter['amount_paid'])){
              $this->db->where('fee.paid_amount', $filter['amount_paid']);
             }
             if(!empty($filter['amount_pending'])){
              $this->db->where('fee.pending_balance', $filter['amount_pending']);
             }
             if(!empty($filter['order_id'])){
              $this->db->where('fee.order_id', $filter['order_id']);
             }
      
             if(!empty($filter['payment_type'])){
              $this->db->where('fee.payment_type', $filter['payment_type']);
             }
             if(!empty($filter['by_term'])){
                $this->db->where('fee.term_name', $filter['by_term']);
            }
           
        
             if($filter['bank_settlement'] == 'Settled'){
              $this->db->where('fee.bank_settlement_status', 1);
             }else if($filter['bank_settlement'] == 'Pending'){
              $this->db->where('fee.bank_settlement_status', 0);
             }
             if(!empty($filter['by_bank_date'])){
              $this->db->where('fee.bank_settlement_date', $filter['by_bank_date']);
             }
             if(!empty($filter['by_year'])){
              $this->db->where('fee.payment_year', $filter['by_year']);
            //  $this->db->where('bank.fee_year', $filter['by_year']);
             }else{
                $this->db->where('fee.payment_year', CURRENT_YEAR);
             //   $this->db->where('bank.fee_year', CURRENT_YEAR);
             }
             if(!empty($filter['created_by'])){
                $this->db->where('fee.created_by', $filter['created_by']); 
            }
            if(!empty($filter['created_date_time'])){
                $this->db->where('DATE(fee.created_date_time)', $filter['created_date_time']);
            }
            $this->db->where('fee.is_deleted', 0);
           $this->db->order_by('fee.receipt_number', 'DESC');
           $this->db->limit($page, $segment);
           $query = $this->db->get();
           return $query->result();
           
       }


       public function updatefeeSettleStatus($feeInfo, $receipt_number) {
        $this->db->where('row_id', $receipt_number);
        $this->db->update('tbl_new_admission_overall_fee_payment_info', $feeInfo);
        return TRUE;
    }

    public function updateMiscFeeSettleStatus($feeInfo, $receipt_number) {
        $this->db->where('row_id', $receipt_number);
        $this->db->update('tbl_miscellaneous_fee', $feeInfo);
        return TRUE;
    }
       //second PUC batch 2019
       public function getFeePendingAmount2019($student_id){
        $this->db->from('tbl_fee_pending_ii_2021 as student'); 
        $this->db->where('student.student_id', $student_id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

 

    
    public function updatePendingFee2019($paymentInfo, $student_id) {
        $this->db->where('student_id', $student_id);
        $this->db->update('tbl_fee_pending_ii_2021', $paymentInfo);
        return TRUE;
    }

    //second PUC batch 2019
    public function checkFeeAlreadyReceiptProcessed($receipt_number){
        $this->db->from('tbl_fees_paid_by_receipt_v2 as fee'); 
        $this->db->where('fee.receipt_number', $receipt_number);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

  

    public function getFeePaidInfo2021_ALL(){
        $this->db->from('tbl_students_overall_fee_payment_info_2021 as fee'); 
        $this->db->order_by('fee.payment_count', 'ASC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function addReceiptFeeType($paymentInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_fees_paid_by_receipt_v2', $paymentInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
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

    public function getFeeReceiptPrintInfo_2021($receipt_number,$fee_type){
        $this->db->select('
        stru.fees_type,
        stru.school_account_id,
        fee.payment_date,
        fee.receipt_number,
        fee.application_no,
        fee.paid_amount');
        $this->db->from('tbl_fees_paid_by_receipt_v2 as fee'); 
        $this->db->join('tbl_admission_fee_structure as stru', 'stru.row_id = fee.fee_type_id','left');
        $this->db->where('fee.receipt_number', $receipt_number);
        $this->db->where('stru.school_account_id', $fee_type);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getFeePaidInfo_NewAdm_2021($application_no){
        $this->db->from('tbl_students_overall_fee_payment_info as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }


    public function getStdPaidDetailsByApplicationNo_newADM($application_no){
        $this->db->select('fee.paid_amount,fee.payment_count');
        $this->db->from('tbl_students_overall_fee_payment_info as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.application_no', $application_no);
        $this->db->order_by('fee.receipt_number', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }
      

    public function addFeeDetailsNewAdmission_2021($feeInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_students_overall_fee_payment_info', $feeInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }

    public function getAllFeePaymentInfoCountNewAdm($filter='')
    {
        $this->db->from('tbl_students_overall_fee_payment_info as fee');
        $this->db->join('tbl_admission_students_status_temp as std', 'std.application_number  = fee.application_no','left');
        $this->db->join('tbl_fee_payment_bank_settlement_new_adm as bank', 'bank.receipt_number = fee.receipt_number','left');

        if(!empty($filter['application_no'])){
            $this->db->where('fee.application_no', $filter['application_no']);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('fee.application_no', $filter['student_id']);
        }
        if(!empty($filter['date_select'])){
         $this->db->where('fee.payment_date', $filter['date_select']);
        }
        if(!empty($filter['receipt_number'])){
         $this->db->where('fee.receipt_number', $filter['receipt_number']);
        }
        if(!empty($filter['amount_paid'])){
         $this->db->where('fee.paid_amount', $filter['amount_paid']);
        }
        if(!empty($filter['amount_pending'])){
         $this->db->where('fee.pending_balance', $filter['amount_pending']);
        }
        if(!empty($filter['order_id'])){
         $this->db->where('fee.order_id', $filter['order_id']);
        }
 
        if(!empty($filter['payment_type'])){
         $this->db->where('fee.payment_type', $filter['payment_type']);
        }
 
        if($filter['bank_settlement'] == 'Settled'){
         $this->db->where('fee.bank_settlement_status', 1);
        }else if($filter['bank_settlement'] == 'Pending'){
         $this->db->where('fee.bank_settlement_status', 0);
        }
        if(!empty($filter['by_bank_date'])){
         $this->db->where('bank.date', $filter['by_bank_date']);
        }
       $this->db->where('fee.is_deleted', 0);
       $this->db->where('fee.is_deleted', 0);
       $query = $this->db->get();
       return $query->num_rows();
   }
 
       //get students fetails lates update
       public function getAllFeePaymentInfoNewAdm($page, $segment, $filter='')
       {
             $this->db->select('fee.payment_date,
             std.application_number,
             fee.receipt_number,
             fee.order_id,
             fee.application_no,
             fee.paid_amount,
             fee.pending_balance,
             fee.payment_type, 
             fee.bank_settlement_status,
             bank.date');
             $this->db->from('tbl_students_overall_fee_payment_info as fee');
             $this->db->join('tbl_admission_students_status_temp as std', 'std.application_number  = fee.application_no','left');
             $this->db->join('tbl_fee_payment_bank_settlement_new_adm as bank', 'bank.receipt_number = fee.receipt_number','left');
             if(!empty($filter['application_no'])){
                $this->db->where('fee.application_no', $filter['application_no']);
            }
             if(!empty($filter['student_id'])){
                 $this->db->where('fee.application_no', $filter['student_id']);
             }
             if(!empty($filter['date_select'])){
              $this->db->where('fee.payment_date', $filter['date_select']);
             }
             if(!empty($filter['receipt_number'])){
              $this->db->where('fee.receipt_number', $filter['receipt_number']);
             }
             if(!empty($filter['amount_paid'])){
              $this->db->where('fee.paid_amount', $filter['amount_paid']);
             }
             if(!empty($filter['amount_pending'])){
              $this->db->where('fee.pending_balance', $filter['amount_pending']);
             }
             if(!empty($filter['order_id'])){
              $this->db->where('fee.order_id', $filter['order_id']);
             }
      
             if(!empty($filter['payment_type'])){
              $this->db->where('fee.payment_type', $filter['payment_type']);
             }
      
             if($filter['bank_settlement'] == 'Settled'){
              $this->db->where('fee.bank_settlement_status', 1);
             }else if($filter['bank_settlement'] == 'Pending'){
              $this->db->where('fee.bank_settlement_status', 0);
             }
             if(!empty($filter['by_bank_date'])){
              $this->db->where('bank.date', $filter['by_bank_date']);
             }
            $this->db->where('fee.is_deleted', 0);
            $this->db->where('fee.is_deleted', 0);
           $this->db->order_by('fee.receipt_number', 'ASC');
           $this->db->limit($page, $segment);
           $query = $this->db->get();
           return $query->result();
           
       }
       public function getAllFeePaymentInfoNewAdmPROCESS()
       {
             $this->db->from('tbl_students_overall_fee_payment_info as fee');
            
             $this->db->where('fee.is_deleted', 0);
            // $this->db->where('fee.is_deleted', 0);
           $query = $this->db->get();
           return $query->result();
           
       }
       public function getFeeInfoByReceiptNum_2021_newAdm($receipt_number){
        $this->db->from('tbl_students_overall_fee_payment_info as fee'); 
        $this->db->where('fee.row_id', $receipt_number);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
    

    public function getFeeDDInfoNewAdm($receipt_number,$application_no){
        $this->db->from('tbl_fee_payment_dd_info as student'); 
        $this->db->where('student.receipt_number', $receipt_number);
        // $this->db->where('student.application_no', $application_no);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
    public function getFeeCardInfoNewAdm($receipt_number,$application_no){
        $this->db->from('tbl_fee_payment_bank_info as student'); 
        $this->db->where('student.receipt_number', $receipt_number);
        // $this->db->where('student.application_no', $application_no);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function getFeeReceiptPrintInfo_2021_I_PUC($receipt_number,$fee_type,$application_no){
        $this->db->select('
        stru.fees_type,
        stru.school_account_id,
        fee.payment_date,
        fee.receipt_number,
        fee.application_no,
        fee.paid_amount');
        $this->db->from('tbl_fees_paid_by_receipt_v2 as fee'); 
        $this->db->join('tbl_admission_fee_structure as stru', 'stru.row_id = fee.fee_type_id','left');
        $this->db->where('fee.receipt_number', $receipt_number);
        $this->db->where('stru.school_account_id', $fee_type);
        $this->db->where('fee.application_no', $application_no);
        
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }


         //get students fetails lates update
         public function getAllFeePaymentInfoForReport($filter)
         {
               $this->db->select('fee.payment_date,fee.row_id,
               std.student_id,
               std.student_name,
               std.stream_name,
               fee.term_name,
               fee.receipt_number,
               fee.order_id,
               fee.application_no,
               fee.paid_amount,
               fee.pending_balance,
               fee.fee_type, 
               fee.payment_type,
               fee.refund_amt,
               fee.bank_settlement_status,
               fee.bank_settlement_date');
               $this->db->from('tbl_students_overall_fee_payment_info as fee');
               $this->db->join('tbl_students_info as std', 'std.row_id = fee.application_no','left');
            //    $this->db->join('tbl_fee_payment_bank_settlement as bank', 'bank.receipt_number = fee.receipt_number','left');
            //    if(!empty($filter['application_no'])){
            //       $this->db->where('fee.application_no', $filter['application_no']);
            //   }
            //    if(!empty($filter['student_id'])){
            //        $this->db->where('std.student_id', $filter['student_id']);
            //    }
               if(!empty($filter['date_from'])){
                $this->db->where('fee.payment_date>=', date('Y-m-d', strtotime($filter['date_from'])));
                $this->db->where('fee.payment_date<=', date('Y-m-d', strtotime($filter['date_to'])));
               }
               if(!empty($filter['stream'])){
                $this->db->where('std.stream_name', $filter['stream']);
               }
               if(!empty($filter['term'])){
                $this->db->where('fee.term_name', $filter['term']);
               }
            //    if(!empty($filter['receipt_number'])){
            //     $this->db->where('fee.receipt_number', $filter['receipt_number']);
            //    }
            //    if(!empty($filter['amount_paid'])){
            //     $this->db->where('fee.paid_amount', $filter['amount_paid']);
            //    }
            //    if(!empty($filter['amount_pending'])){
            //     $this->db->where('fee.pending_balance', $filter['amount_pending']);
            //    }
            //    if(!empty($filter['order_id'])){
            //     $this->db->where('fee.order_id', $filter['order_id']);
            //    }
        
               if(!empty($filter['fee_type'])){
                $this->db->where('fee.fee_type', $filter['fee_type']);
               }
        
            //    if($filter['bank_settlement'] == 'Settled'){
            //     $this->db->where('fee.bank_settlement_status', 1);
            //    }else if($filter['bank_settlement'] == 'Pending'){
            //     $this->db->where('fee.bank_settlement_status', 0);
            //    }
            //    if(!empty($filter['by_bank_date'])){
            //     $this->db->where('bank.date', $filter['by_bank_date']);
            //    }
              $this->db->where('fee.is_deleted', 0);
             $this->db->order_by('fee.payment_date', 'ASC');
             $query = $this->db->get();
             return $query->result();
             
         }

         public function getFeePaymentInfoForBriefReport($filter){
               $this->db->select('SUM(fee.paid_amount) as amount');
               $this->db->from('tbl_students_overall_fee_payment_info as fee');
               $this->db->join('tbl_students_info as std', 'std.row_id = fee.application_no','left');
               if(!empty($filter['date_from'])){
                $this->db->where('fee.payment_date>=', date('Y-m-d', strtotime($filter['date_from'])));
                $this->db->where('fee.payment_date<=', date('Y-m-d', strtotime($filter['date_to'])));
               }
               if(!empty($filter['stream'])){
                $this->db->where('std.stream_name', $filter['stream']);
               }
               if(!empty($filter['term'])){
                $this->db->where('fee.term_name', $filter['term']);
               }
               if(!empty($filter['fee_type'])){
                $this->db->where('fee.fee_type', $filter['fee_type']);
               }
              $this->db->where('fee.is_deleted', 0);
             $this->db->order_by('fee.payment_date', 'ASC');
             $query = $this->db->get();
             return $query->row()->amount;
             
         }

         public function getAllFeePaymentInfoForReport_I_PUC($filter)
         {
            $this->db->select('fee.payment_date,fee.row_id,
            std.application_number,
            fee.receipt_number,
            fee.order_id,
            fee.application_no,
            fee.paid_amount,
            fee.pending_balance,
            fee.payment_type, 
            fee.bank_settlement_status,
            personal.name as student_name,
            sjpuc.stream_name,
            bank.date');
            $this->db->from('tbl_students_overall_fee_payment_info as fee');
            $this->db->join('tbl_admission_students_status_temp as std', 'std.application_number  = fee.application_no','left');
            
            $this->db->join('tbl_fee_payment_bank_settlement as bank', 'bank.receipt_number = fee.row_id','left');
            $this->db->join('tbl_admission_student_personal_details_temp as personal', 'personal.resgisted_tbl_row_id = std.registered_row_id','left');
            $this->db->join('tbl_admission_school_and_examination_deatils_temp as exam', 'exam.registred_row_id = personal.resgisted_tbl_row_id','left');
            $this->db->join('tbl_admission_combination_language_opted_temp as sjpuc', 'sjpuc.registred_row_id = personal.resgisted_tbl_row_id','left'); 
            if(!empty($filter['date_from'])){
                $this->db->where('fee.payment_date>=', $filter['date_from']);
                $this->db->where('fee.payment_date<=', $filter['date_to']);
               }
               if(!empty($filter['preference'])){
                $this->db->where('sjpuc.stream_name', $filter['preference']);
               }
            //    if(!empty($filter['amount_paid'])){
            //     $this->db->where('fee.paid_amount', $filter['amount_paid']);
            //    }
            //    if(!empty($filter['amount_pending'])){
            //     $this->db->where('fee.pending_balance', $filter['amount_pending']);
            //    }
            //    if(!empty($filter['order_id'])){
            //     $this->db->where('fee.order_id', $filter['order_id']);
            //    }
        
            //    if(!empty($filter['payment_type'])){
            //     $this->db->where('fee.payment_type', $filter['payment_type']);
            //    }
        
            //    if($filter['bank_settlement'] == 'Settled'){
            //     $this->db->where('fee.bank_settlement_status', 1);
            //    }else if($filter['bank_settlement'] == 'Pending'){
            //     $this->db->where('fee.bank_settlement_status', 0);
            //    }
            //    if(!empty($filter['by_bank_date'])){
            //     $this->db->where('bank.date', $filter['by_bank_date']);
            //    }
            $this->db->where('fee.term_name', 'I PUC');
            $this->db->where('fee.is_deleted', 0);
             $this->db->order_by('fee.receipt_number', 'ASC');
             $this->db->limit($page, $segment);
             $query = $this->db->get();
             return $query->result();
             
         }

    // order id process - readmission -----------------------------------------------
    public function getReadmissionPayTmLogByAppNo($order_id){
        $this->db->from('tbl_readmission_paytm_fee_payment_log as fee');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function getReAdmissionTotalPaidAmount($application_no){
        $this->db->select('SUM(fee.paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year', CURRENT_YEAR);
        $query = $this->db->get();
        return $query->row();
    }

    public function getReadmission_FeePaidDetailsByApplicationNo($application_no){
        $this->db->select('fee.paid_amount,fee.payment_count');
        $this->db->from('tbl_students_overall_fee_payment_info_2021 as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year', CURRENT_YEAR);
        $this->db->order_by('fee.receipt_number', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    public function getLastReceiptNoFromOverall($term){
        $this->db->from('tbl_students_overall_fee_payment_info as std');
        $this->db->where('std.payment_year', CURRENT_YEAR);
        $this->db->where('std.term_name', $term);
        $this->db->where('std.is_deleted', 0);
        $this->db->order_by('std.row_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row()->receipt_number;
    }

    // add overall fees detail - readmission
    public function addReadmission_FeeDetailsInfo($feeInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_students_overall_fee_payment_info', $feeInfo);
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
    // add paid amoumt for print
    public function addReceiptFeeType2021($paymentInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_fees_paid_by_receipt_v2', $paymentInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }
    
    public function updateReadmission_PaymentLogByOrderIdPaytm($paymentInfo,$order_id) {
        $this->db->where('order_id', $order_id);
        $this->db->update('tbl_readmission_paytm_fee_payment_log',$paymentInfo);
        return TRUE;
    }
    public function checkReAdmissionOrderIdExists($order_id){
        $this->db->from('tbl_students_overall_fee_payment_info as fee');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getReAdmUnProcessedOrderID(){
        $this->db->from('tbl_readmission_paytm_fee_payment_log');
        $this->db->where('payment_status!=', 'SUCCESS');
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getNewAdmUnProcessedOrderID(){
        $this->db->from('tbl_paytm_fee_payment_log');
        $this->db->where('payment_status!=', 'SUCCESS');
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    
    // order id process - new admission -----------------------------------------------
    public function getAdmissionPayTmLogByOrderId($order_id){
        $this->db->from('tbl_paytm_fee_payment_log as fee');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        return $query->row();
    }
    public function updatePaymentLogByOrderId($paymentInfo,$order_id) {
       $this->db->where('order_id', $order_id);
       $this->db->update('tbl_paytm_fee_payment_log',$paymentInfo);
       return TRUE;
    }

    public function checkAdmissionOrderIdExists($order_id){
        $this->db->from('tbl_students_overall_fee_payment_info as fee');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        return $query->row();
    }

    
    // get 2020 fee pending amount list
    public function getAllFeePendingAmount2020(){
        $this->db->from('tbl_fee_pending_info_2021 as fee');
        $this->db->join('tbl_students_info as std', 'std.student_id = fee.student_id','left'); 
        $this->db->order_by('fee.student_id','ASC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    
    public function getSUM_Paid_FeeInfoByReceiptNum_2020($application_no){
        $this->db->select('SUM(fee.paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info_2020 as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    
    public function getAllFeePendingAmount2019(){
        $this->db->from('tbl_fee_pending_ii_2021 as fee');
        $this->db->join('tbl_students_info as std', 'std.student_id = fee.student_id','left'); 
        $this->db->order_by('fee.student_id','ASC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getFeePaidInfo($application_no,$payment_year){
        $this->db->from('tbl_new_admission_overall_fee_payment_info as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year',$payment_year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }


    public function getGovtFeePaidInfo($application_no,$payment_year){
        $this->db->from('tbl_govt_fee_paid_info as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year',$payment_year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getTotalFeePaidInfo($application_no,$payment_year){
        $this->db->select('SUM(paid_amount) as paid_amount');
        $this->db->from('tbl_new_admission_overall_fee_payment_info as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year',$payment_year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result->paid_amount;
    }

    public function getGovtFeeInfoByReceiptNum($row_id){
        $this->db->from('tbl_govt_fee_paid_info as fee');
        //$this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.row_id', $row_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getGovernmentFee($stream,$term_name){
        $this->db->select('SUM(fee.fee_amount_state_board) as total_fee');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->where_in('fee.stream_name',[$stream,'ALL']);
        $this->db->where_in('fee.term_name', [$term_name,'ALL']);
        $this->db->where('fee.fee_year', CURRENT_YEAR);
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.fees_type', 'Government Fees');
        $query = $this->db->get();
        return $query->row()->total_fee;
    }


    public function getGovtFeeStructureInfoReceipt($filter){
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
        $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);
        $this->db->where('fee.fee_year', CURRENT_YEAR);
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.fee_amount_state_board!=', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getSumGovtFeePaidInfo($application_no,$payment_year){
        $this->db->select('SUM(fee.paid_amount) as paid_amount');
        $this->db->from('tbl_govt_fee_paid_info as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year',$payment_year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

   
    public function getGovtFeePaymentInfoCount($filter='')
    {
        $this->db->from('tbl_govt_fee_paid_info as fee');
        $this->db->join('tbl_students_info as std', 'std.row_id = fee.application_no','left');
      //  $this->db->join('tbl_fee_payment_bank_settlement as bank', 'bank.receipt_number = fee.row_id','left');
    

        if(!empty($filter['application_no'])){
            $this->db->where('std.application_no', $filter['application_no']);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('std.application_no', $filter['student_id']);
        }
        if(!empty($filter['date_select'])){
         $this->db->where('fee.payment_date', $filter['date_select']);
        }
        if(!empty($filter['receipt_number'])){
         $this->db->where('fee.receipt_number', $filter['receipt_number']);
        }
        if(!empty($filter['amount_paid'])){
         $this->db->where('fee.paid_amount', $filter['amount_paid']);
        }
        if(!empty($filter['amount_pending'])){
         $this->db->where('fee.pending_balance', $filter['amount_pending']);
        }
        if(!empty($filter['order_id'])){
         $this->db->where('fee.order_id', $filter['order_id']);
        }
        if(!empty($filter['student_name'])){
            $likeCriteria = "(std.student_name  LIKE '%" . $filter['student_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['payment_type'])){
         $this->db->where('fee.payment_type', $filter['payment_type']);
        }
        if(!empty($filter['by_term'])){
            $this->db->where('fee.term_name', $filter['by_term']);
        }
        if($filter['bank_settlement'] == 'Settled'){
         $this->db->where('fee.bank_settlement_status', 1);
        }else if($filter['bank_settlement'] == 'Pending'){
         $this->db->where('fee.bank_settlement_status', 0);
        }
        if(!empty($filter['by_bank_date'])){
         $this->db->where('fee.bank_settlement_date', $filter['by_bank_date']);
        }
        if(!empty($filter['by_year'])){
            $this->db->where('fee.payment_year', $filter['by_year']);
           }else{
              $this->db->where('fee.payment_year', CURRENT_YEAR);
           }
        
        if($filter['by_type'] == 'Cancelled'){
            $this->db->where('fee.is_cancelled', 1);
        }else{
            $this->db->where('fee.is_cancelled', 0);
        }
        if(!empty($filter['created_date_time'])){
            $this->db->where('DATE(fee.created_date_time)', $filter['created_date_time']);
        }
        if(!empty($filter['created_by'])){
            $this->db->where('fee.created_by', $filter['created_by']); 
        }
       $this->db->where('fee.is_deleted', 0);
       $query = $this->db->get();
       return $query->num_rows();
    }
 
       //get students fetails lates update
    public function getGovtFeePaymentInfo($page, $segment, $filter='')
    {
        $this->db->select('fee.payment_date,
             fee.row_id,
             fee.receipt_number,
             fee.order_id,
             std.application_no,std.student_name,
             fee.paid_amount,
             fee.payment_type, 
             fee.bank_settlement_status,
             fee.term_name,
             fee.payment_year,
             fee.bank_settlement_date as date');
        $this->db->from('tbl_govt_fee_paid_info as fee');
             $this->db->join('tbl_students_info as std', 'std.row_id = fee.application_no','left');
           //  $this->db->join('tbl_fee_payment_bank_settlement as bank', 'bank.receipt_number = fee.row_id','left');
        if(!empty($filter['application_no'])){
            $this->db->where('std.application_no', $filter['application_no']);
        }
        if(!empty($filter['student_name'])){
            $likeCriteria = "(std.student_name  LIKE '%" . $filter['student_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('std.application_no', $filter['student_id']);
        }
        if(!empty($filter['date_select'])){
            $this->db->where('fee.payment_date', $filter['date_select']);
        }
        if(!empty($filter['receipt_number'])){
            $this->db->where('fee.receipt_number', $filter['receipt_number']);
        }
        if(!empty($filter['amount_paid'])){
            $this->db->where('fee.paid_amount', $filter['amount_paid']);
        }
        if(!empty($filter['amount_pending'])){
            $this->db->where('fee.pending_balance', $filter['amount_pending']);
        }
        if(!empty($filter['by_term'])){
            $this->db->where('fee.term_name', $filter['by_term']);
        }
             if(!empty($filter['order_id'])){
              $this->db->where('fee.order_id', $filter['order_id']);
             }
      
             if(!empty($filter['payment_type'])){
              $this->db->where('fee.payment_type', $filter['payment_type']);
             }
      
             if($filter['bank_settlement'] == 'Settled'){
              $this->db->where('fee.bank_settlement_status', 1);
             }else if($filter['bank_settlement'] == 'Pending'){
              $this->db->where('fee.bank_settlement_status', 0);
             }
             if(!empty($filter['by_bank_date'])){
              $this->db->where('fee.bank_settlement_date', $filter['by_bank_date']);
             }
             if(!empty($filter['by_year'])){
              $this->db->where('fee.payment_year', $filter['by_year']);
             }else{
                $this->db->where('fee.payment_year', CURRENT_YEAR);
             }

            if($filter['by_type'] == 'Cancelled'){
                $this->db->where('fee.is_cancelled', 1);
            }else{
                $this->db->where('fee.is_cancelled', 0);
            }
            if(!empty($filter['created_date_time'])){
                $this->db->where('DATE(fee.created_date_time)', $filter['created_date_time']);
            }
            if(!empty($filter['created_by'])){
                $this->db->where('fee.created_by', $filter['created_by']); 
            }
            $this->db->where('fee.is_deleted', 0);
           $this->db->order_by('fee.receipt_number', 'DESC');
           $this->db->limit($page, $segment);
           $query = $this->db->get();
           return $query->result();
           
    }
    public function getTotalFeePaidInfoByType($application_no,$payment_year,$type){
        $this->db->select('SUM(paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year',$payment_year);
        $this->db->where('fee.fee_type',$type);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result->paid_amount;
    }

    public function getStdLastPaidDetailsByApplicationNo($application_no,$year){
        $this->db->select('fee.paid_amount,fee.payment_count,fee.pending_balance');
        $this->db->from('tbl_students_overall_fee_payment_info as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year', $year);
        $this->db->order_by('fee.row_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    public function getLastReceiptNo($year){
        $this->db->select('fee.receipt_number');
        $this->db->from('tbl_new_admission_overall_fee_payment_info as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.payment_year', $year);
        $this->db->order_by('fee.row_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    public function getFrenchFeePaidByReceipt($receipt_number){
        $this->db->select('fee.paid_amount');
        $this->db->from('tbl_fees_paid_by_receipt_v2 as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.receipt_number', $receipt_number);
        $this->db->where_in('fee.fee_type_id', [83,128,129,297,298]);
        $query = $this->db->get();
        return $query->row()->paid_amount;
    }

    public function getFeeInfoByRowId($row_id){
        $this->db->from('tbl_students_overall_fee_payment_info as fee');
        $this->db->where('row_id', $row_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getFeeStructureByType($filter,$type){
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
        $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);
        $this->db->where('fee.fee_year', $filter['fee_year']);
        $this->db->where('fee.type', $type);
        $this->db->order_by('fee.fee_amount');
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getTotalFeePaidInfoByTypeLastPay($application_no,$payment_year,$type,$row_id){
        $this->db->select('SUM(paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year',$payment_year);
        $this->db->where('fee.fee_type',$type);
        $this->db->where('fee.row_id <',$row_id);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result->paid_amount;
    }

    public function getFeeCountByType($application_no,$payment_year,$type,$row_id){
        $this->db->from('tbl_students_overall_fee_payment_info as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year',$payment_year);
        $this->db->where('fee.fee_type',$type);
        $this->db->where('fee.row_id <=',$row_id);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    }

    public function updatedOverallPayment($feeInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_students_overall_fee_payment_info', $feeInfo);
        return TRUE;
    }

    function getDueFeeByStudent($std_row_id){
        $this->db->from('tbl_fee_due_student as fee'); 
        $this->db->where('fee.std_row_id', $std_row_id);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result->pending_balance;
    }

    public function addMiscellaneousPayment($miscellaneousInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_miscellaneous_fee', $miscellaneousInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id; 
    }

    public function getFeeByMiscId($row_id){
        $this->db->select('SUM(fee.miscellaneous_amount) as miscellaneous_amount');
        $this->db->from('tbl_miscellaneous_type as fee'); 
        $this->db->where_in('fee.row_id', $row_id);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }


    public function getFeeByMiscAmt($row_id){
        $this->db->select('fee.miscellaneous_amount,fee.miscellaneous_type');
        $this->db->from('tbl_miscellaneous_type as fee'); 
        $this->db->where_in('fee.row_id', $row_id);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getMiscellaneousFeesInfo($filter)
    {
        $this->db->select('fee.row_id,fee.register_no,fee.qnty,fee.student_name ,fee.term,type.miscellaneous_type,type.miscellaneous_amount,fee.receipt_no,fee.year,
        fee.payment_type,fee.created_by,fee.amount, fee.date, fee.payment_status,fee.bank_settlement_date,fee.bank_settlement_status');
        $this->db->from('tbl_miscellaneous_fee as fee'); 
        $this->db->join('tbl_miscellaneous_type as type', 'type.row_id = fee.miscellaneous_type','left');
        if(!empty($filter['intake_year'])){
            $this->db->where('fee.year', $filter['intake_year']);
        }
        $this->db->where('fee.is_deleted', 0);
        $this->db->order_by('fee.date', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getStaffNameById($row_id) {
        $this->db->from('tbl_staff as staff'); 
        $this->db->where('staff.staff_id', $row_id);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();  
    }

    public function updateMiscellaneousFee($miscellaneousInfo, $row_id){
        $this->db->where('row_id',$row_id);
        $this->db->update('tbl_miscellaneous_fee', $miscellaneousInfo);
        return true;
    }

    
    public function getMiscellaneousFeesInfoById($row_id)
    {
        $this->db->select('fee.row_id,fee.qnty,fee.register_no,fee.date,fee.student_name,fee.created_date_time,fee.payment_type,fee.receipt_no,
        type.miscellaneous_type,fee.created_by,fee.section_name,fee.term,fee.student_status,fee.stream,
        fee.amount, fee.date,fee.year,fee.course,fee.upi_ref_no,fee.ref_number');
        $this->db->from('tbl_miscellaneous_fee as fee'); 
        $this->db->join('tbl_miscellaneous_type as type', 'type.row_id = fee.miscellaneous_type','left');
        $this->db->where('fee.row_id', $row_id);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    
    public function getMiscellaneousFeesInfoReport($filter='')
    {
        $this->db->select('fee.row_id,fee.qnty,fee.register_no,fee.upi_ref_no,fee.bank_settlement_date,fee.receipt_no,fee.section_name,fee.payment_type,fee.student_name ,fee.term,fee.amount, fee.date, type.miscellaneous_type,fee.semester,fee.course,fee.year,fee.stream,fee.student_status,fee.ref_number');
        $this->db->from('tbl_miscellaneous_fee as fee'); 
        $this->db->join('tbl_miscellaneous_type as type', 'type.row_id = fee.miscellaneous_type','left');

        if(!empty($filter['date_from']) && !empty($filter['date_to'])){
            $this->db->where('fee.date >=', $filter['date_from']);
            $this->db->where('fee.date <=', $filter['date_to']);
        }else if(!empty($filter['date_from'])){
            $this->db->where('fee.date >=', $filter['date_from']);
        }else if(!empty($filter['date_to'])){
            $this->db->where('fee.date <=', $filter['date_to']);
        }
        if(!empty($filter['misc_year'])){
            $this->db->where_in('fee.year',$filter['misc_year']);
        }

        if(!empty($filter['payment_type'])){
            $this->db->where_in('fee.payment_type',$filter['payment_type']);
        }
        if(!empty($filter['miscellaneous_type'])){
            $this->db->where_in('fee.miscellaneous_type',$filter['miscellaneous_type']);
        }
       

        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getTotalFeePaidInfoForUpdate($application_no,$payment_year,$row_id){
        $this->db->select('SUM(paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year',$payment_year);
        $this->db->where('fee.row_id !=',$row_id);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result->paid_amount;
    }

    function addRefundInfo($feeInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_refund_info', $feeInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function getRefundInfoByRowId($row_id){
        $this->db->from('tbl_refund_info as fee'); 
        $this->db->where('fee.row_id',$row_id);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    function getRefundInfoByStd($std_id){
        $this->db->from('tbl_refund_info as fee'); 
        $this->db->where('fee.std_row_id',$std_id);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function updateRefundInfo($feeInfo,$row_id){
        $this->db->where('row_id',$row_id);
        $this->db->update('tbl_refund_info', $feeInfo);
        return true;
    }

    public function getAllFeePaymentInfoForReportGroupBy($filter)
         {
            $term = $filter['term'];
            $stream = $filter['stream'];
            if(!empty($filter['date_from'])){
                $date_from = date('Y-m-d',strtotime($filter['date_from']));
                $date_to = date('Y-m-d',strtotime($filter['date_to']));
                $sql = "SELECT fee.payment_date, fee.application_no, fee.payment_type, fee.term_name,SUM(fee.paid_amount) as paid_amount,fee.pending_balance,SUM(fee.refund_amt) as refund_amt, std.student_name, std.student_id, std.stream_name FROM tbl_students_overall_fee_payment_info as fee, tbl_students_info as std WHERE std.row_id = fee.application_no AND fee.term_name = '$term' AND std.stream_name = '$stream' AND fee.payment_date BETWEEN '$date_from' AND '$date_to' GROUP BY application_no,payment_date ORDER BY payment_date";
            }else{
                $sql = "SELECT fee.payment_date, fee.application_no, fee.payment_type, fee.term_name,SUM(fee.paid_amount) as paid_amount,fee.pending_balance,SUM(fee.refund_amt) as refund_amt, std.student_name, std.student_id, std.stream_name FROM tbl_students_overall_fee_payment_info as fee, tbl_students_info as std WHERE std.row_id = fee.application_no AND fee.term_name = '$term' AND std.stream_name = '$stream' GROUP BY application_no,payment_date ORDER BY payment_date";
            }
            $query = $this->db->query($sql);
             return $query->result();
         }

         public function getPaidInfoByType($application_no,$payment_date,$type){
            $this->db->select('fee.receipt_number,SUM(fee.paid_amount) as paid_amount');
            $this->db->from('tbl_students_overall_fee_payment_info as fee');
            $this->db->where('fee.is_deleted', 0);
            $this->db->where('fee.application_no', $application_no);
            $this->db->where('fee.payment_date', $payment_date);
            $this->db->where('fee.fee_type', $type);
            $query = $this->db->get();
            return $query->row();
         }

    public function getSumOfFeeByDate($date){
        $this->db->select('SUM(fee.paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info as fee'); 
        $this->db->where('fee.payment_date',$date);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result->paid_amount;
    }
    public function getSumOfFeeByDateType($date,$type){
        $this->db->select('SUM(paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info as fee'); 
        $this->db->where('fee.payment_date',$date);
        $this->db->where('fee.fee_type', $type);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result->paid_amount;
    }

    public function getSumOfMisByDate($date){
        $this->db->select('SUM(fee.total) as total');
        $this->db->from('tbl_miscellaneous_fee as fee'); 
        $this->db->where('fee.date',$date);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result->total;
    }

    public function getStudentOverallFeePaymentInfo($row_id,$year){
        $this->db->select('fee.row_id,fee.receipt_number,student.stream_name,
        fee.application_no,fee.fee_account_row_id,fee.payment_date,fee.payment_type,
        fee.total_amount,fee.paid_amount,fee.excess_amount,fee.fee_concession,
        fee.fee_pending_status,fee.pending_balance,student.admission_no,fee.term_name,
        fee.bank_settlement_status,fee.collected_staff_name,fee.payment_year,fee.bank_settlement_date as date,
        fee.order_id,student.student_id,student.student_name, fee.term_name,student.section_name');
        $this->db->from('tbl_new_admission_overall_fee_payment_info as fee');
        $this->db->join('tbl_students_info as student', 'student.row_id = fee.application_no','left'); 
       // $this->db->join('tbl_student_academic_info as academic', 'academic.rel_student_row_id = student.row_id','left');
        // $this->db->join('tbl_fee_payment_bank_settlement as bank', 'bank.receipt_number = fee.receipt_number','left');
        $this->db->where('fee.application_no', $row_id);
        $this->db->where('fee.payment_year', $year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getGovernmentFeeAmount($filter){
        $this->db->select('SUM(fee.fee_amount_state_board) as total_fee');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
        $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);
        $this->db->where('fee.fee_year', $filter['fee_year']);
        $this->db->where('fee.is_deleted', 0); 
        $this->db->where_not_in('fee.fees_type', ['Tution Fees','Development fees']);
        $query = $this->db->get();
        return $query->row()->total_fee;
    }

    public function getFeeConcessionByAppNoForView($application_no,$year) {
        $this->db->select('fee.fee_amt as amount');
        $this->db->from('tbl_student_fee_concession as fee');
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.year', $year);
        $this->db->where('fee.approved_status', 1); 
        $this->db->where('fee.is_deleted', 0); 
        $query = $this->db->get();
        return $query->row();
    }

    public function getPreviousFeePaidInfo($row_id,$application_no,$payment_year){
        $this->db->from('tbl_new_admission_overall_fee_payment_info as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year',$payment_year);
        $this->db->where('fee.row_id <', $row_id);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getGovtPreviousFeePaidInfo($row_id,$application_no,$payment_year){
        $this->db->from('tbl_govt_fee_paid_info as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year',$payment_year);
        $this->db->where('fee.row_id <', $row_id);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function updateReceiptTable($row_id,$feePayment) {
        $this->db->where('receipt_number', $row_id);
        $this->db->update('tbl_fees_paid_by_receipt_v2', $feePayment);
        return TRUE;
    }

    public function checkConsessionExists($student_id,$year){
        $this->db->from('tbl_student_fee_concession as fee');
        $this->db->where('fee.application_no', $student_id);
        $this->db->where('fee.payment_status', 0);
        $this->db->where('fee.approved_status', 1);  
        $this->db->where('fee.year', $year);   
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();

    }

    public function updateConcessionById($concessionInfo,$row_id) {
        $this->db->where_in('row_id', $row_id);
        $this->db->update('tbl_student_fee_concession', $concessionInfo);
        return TRUE;

    }

    public function getLastMisReceipt($year){
        $this->db->select('fee.receipt_no');
        $this->db->from('tbl_miscellaneous_fee as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.year', $year);
        $this->db->order_by('fee.row_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row()->receipt_no;
    }

    public function getAllFeePaymentInfoForDueReport($filter)
    {
       $this->db->select('fee.payment_date,fee.row_id,
       fee.receipt_number,
       fee.order_id,
       fee.application_no,
       fee.paid_amount,
       fee.pending_balance,
       fee.payment_type, fee.total_amount,
       fee.bank_settlement_status,
       student.student_name,student.student_id,student.stream_name,student.row_id');
       $this->db->from('tbl_new_admission_overall_fee_payment_info as fee');
       $this->db->join('tbl_students_info as student','student.row_id = fee.application_no','left');
       if(!empty($filter['date_from'])){
           $this->db->where('fee.payment_date>=', $filter['date_from']);
           $this->db->where('fee.payment_date<=', $filter['date_to']);
          }
          if(($filter['preference']!= 'ALL')){
           $this->db->where('student.stream_name', $filter['preference']);
          }
          if(!empty($filter['term_name'])){
           $this->db->where('fee.term_name', $filter['term_name']);
          }
          if(!empty($filter['year'])){
           $this->db->where('fee.payment_year', $filter['year']);
          }
      

       $this->db->where('fee.is_deleted', 0);

       $this->db->order_by('student.student_id ASC, fee.payment_date ASC,fee.receipt_number ASC');

       
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        return $query->result();
        
    }

    public function getMiscFeeInfoByReceiptNum($row_id){
        $this->db->from('tbl_miscellaneous_fee as fee');
        $this->db->where('fee.row_id', $row_id);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function updateMiscReceiptNumber($feePayment,$row_id) {
        $this->db->where_in('row_id', $row_id);
        $this->db->update('tbl_miscellaneous_fee', $feePayment);
        return TRUE;
    }
    public function getPreviousFeesPaidInfo($row_id,$application_no,$payment_year){
        $this->db->from('tbl_new_admission_overall_fee_payment_info as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year',$payment_year);
        $this->db->where('fee.row_id <', $row_id);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getPreviousFeesPaidSum($row_id, $application_no, $payment_year) {
        $this->db->select_sum('paid_amount');
        $this->db->from('tbl_new_admission_overall_fee_payment_info as fee');
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year', $payment_year);
        $this->db->where('fee.row_id <', $row_id);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result ? floatval($result->paid_amount) : 0.0;
    }

    //get students fetails lates update
    public function getAllFeePaymentInfoCountnew($filter='')
    {
        $this->db->from('tbl_new_admission_overall_fee_payment_info as fee');
        $this->db->join('tbl_students_info as std', 'std.row_id = fee.application_no','left');
      //  $this->db->join('tbl_fee_payment_bank_settlement as bank', 'bank.receipt_number = fee.row_id','left');
    

        if(!empty($filter['application_no'])){
            $this->db->where('std.application_no', $filter['application_no']);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('std.application_no', $filter['student_id']);
        }
        if(!empty($filter['remarks'])){
            $this->db->where('fee.remarks', $filter['remarks']);
        }
        if(!empty($filter['date_select'])){
         $this->db->where('fee.payment_date', $filter['date_select']);
        }
        if(!empty($filter['receipt_number'])){
         $this->db->where('fee.receipt_number', $filter['receipt_number']);
        }
        if(!empty($filter['amount_paid'])){
         $this->db->where('fee.paid_amount', $filter['amount_paid']);
        }
        if(!empty($filter['amount_pending'])){
         $this->db->where('fee.pending_balance', $filter['amount_pending']);
        }
        if(!empty($filter['order_id'])){
         $this->db->where('fee.order_id', $filter['order_id']);
        }
        if(!empty($filter['student_name'])){
            $likeCriteria = "(std.student_name  LIKE '%" . $filter['student_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['payment_type'])){
         $this->db->where('fee.payment_type', $filter['payment_type']);
        }
        if(!empty($filter['fee_type'])){
            $this->db->where('fee.fee_type', $filter['fee_type']);
           }
        if(!empty($filter['by_term'])){
            $this->db->where('fee.term_name', $filter['by_term']);
        }
        if($filter['bank_settlement'] == 'Settled'){
         $this->db->where('fee.bank_settlement_status', 1);
        }else if($filter['bank_settlement'] == 'Pending'){
         $this->db->where('fee.bank_settlement_status', 0);
        }
        if(!empty($filter['by_bank_date'])){
         $this->db->where('fee.bank_settlement_date', $filter['by_bank_date']);
        }
        if(!empty($filter['by_year'])){
            $this->db->where('fee.payment_year', $filter['by_year']);
           }else{
              $this->db->where('fee.payment_year', CURRENT_YEAR);
           }
           if(!empty($filter['created_by'])){
            $this->db->where('fee.created_by', $filter['created_by']); 
        }
        if(!empty($filter['created_date_time'])){
            $this->db->where('DATE(fee.created_date_time)', $filter['created_date_time']);
        }
       $this->db->where('fee.is_deleted', 1);
       $query = $this->db->get();
       return $query->num_rows();
   }
 
       //get students fetails lates update
       public function getAllFeePaymentInfonew($page, $segment, $filter='')
       {
             $this->db->select('fee.payment_date,fee.row_id,std.student_id,std.student_name,std.application_no,
             fee.receipt_number,fee.order_id,fee.paid_amount, fee.pending_balance,fee.remarks,
             fee.payment_type, fee.bank_settlement_status,fee.term_name,fee.bank_settlement_date as date');
             $this->db->from('tbl_new_admission_overall_fee_payment_info as fee');
             $this->db->join('tbl_students_info as std', 'std.row_id = fee.application_no','left');
           //  $this->db->join('tbl_fee_payment_bank_settlement as bank', 'bank.receipt_number = fee.row_id','left');
             if(!empty($filter['application_no'])){
                $this->db->where('std.application_no', $filter['application_no']);
            }
             if(!empty($filter['student_id'])){
                 $this->db->where('std.application_no', $filter['student_id']);
             }
              if(!empty($filter['remarks'])){
            $this->db->where('fee.remarks', $filter['remarks']);
            }
             if(!empty($filter['student_name'])){
                $likeCriteria = "(std.student_name  LIKE '%" . $filter['student_name'] . "%')";
                $this->db->where($likeCriteria);
            }
             if(!empty($filter['date_select'])){
              $this->db->where('fee.payment_date', $filter['date_select']);
             }
             if(!empty($filter['receipt_number'])){
              $this->db->where('fee.receipt_number', $filter['receipt_number']);
             }
             if(!empty($filter['amount_paid'])){
              $this->db->where('fee.paid_amount', $filter['amount_paid']);
             }
             if(!empty($filter['amount_pending'])){
              $this->db->where('fee.pending_balance', $filter['amount_pending']);
             }
             if(!empty($filter['order_id'])){
              $this->db->where('fee.order_id', $filter['order_id']);
             }
      
             if(!empty($filter['payment_type'])){
              $this->db->where('fee.payment_type', $filter['payment_type']);
             }
             if(!empty($filter['by_term'])){
                $this->db->where('fee.term_name', $filter['by_term']);
            }
           
        
             if($filter['bank_settlement'] == 'Settled'){
              $this->db->where('fee.bank_settlement_status', 1);
             }else if($filter['bank_settlement'] == 'Pending'){
              $this->db->where('fee.bank_settlement_status', 0);
             }
             if(!empty($filter['by_bank_date'])){
              $this->db->where('fee.bank_settlement_date', $filter['by_bank_date']);
             }
             if(!empty($filter['by_year'])){
              $this->db->where('fee.payment_year', $filter['by_year']);
            //  $this->db->where('bank.fee_year', $filter['by_year']);
             }else{
                $this->db->where('fee.payment_year', CURRENT_YEAR);
             //   $this->db->where('bank.fee_year', CURRENT_YEAR);
             }
             if(!empty($filter['created_by'])){
                $this->db->where('fee.created_by', $filter['created_by']); 
            }
            if(!empty($filter['created_date_time'])){
                $this->db->where('DATE(fee.created_date_time)', $filter['created_date_time']);
            }
            $this->db->where('fee.is_deleted', 1);
           $this->db->order_by('fee.receipt_number', 'DESC');
           $this->db->limit($page, $segment);
           $query = $this->db->get();
           return $query->result();
           
       }

        public function getGovtFeePaymentInfoCountnew($filter='')
    {
        $this->db->from('tbl_govt_fee_paid_info as fee');
        $this->db->join('tbl_students_info as std', 'std.row_id = fee.application_no','left');
      //  $this->db->join('tbl_fee_payment_bank_settlement as bank', 'bank.receipt_number = fee.row_id','left');
    

        if(!empty($filter['application_no'])){
            $this->db->where('std.application_no', $filter['application_no']);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('std.application_no', $filter['student_id']);
        }
        if(!empty($filter['date_select'])){
         $this->db->where('fee.payment_date', $filter['date_select']);
        }
        if(!empty($filter['remarks'])){
            $this->db->where('fee.remarks', $filter['remarks']);
        }
        if(!empty($filter['receipt_number'])){
         $this->db->where('fee.receipt_number', $filter['receipt_number']);
        }
        if(!empty($filter['amount_paid'])){
         $this->db->where('fee.paid_amount', $filter['amount_paid']);
        }
        if(!empty($filter['amount_pending'])){
         $this->db->where('fee.pending_balance', $filter['amount_pending']);
        }
        if(!empty($filter['order_id'])){
         $this->db->where('fee.order_id', $filter['order_id']);
        }
        if(!empty($filter['student_name'])){
            $likeCriteria = "(std.student_name  LIKE '%" . $filter['student_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['payment_type'])){
         $this->db->where('fee.payment_type', $filter['payment_type']);
        }
        if(!empty($filter['by_term'])){
            $this->db->where('fee.term_name', $filter['by_term']);
        }
        if($filter['bank_settlement'] == 'Settled'){
         $this->db->where('fee.bank_settlement_status', 1);
        }else if($filter['bank_settlement'] == 'Pending'){
         $this->db->where('fee.bank_settlement_status', 0);
        }
        if(!empty($filter['by_bank_date'])){
         $this->db->where('fee.bank_settlement_date', $filter['by_bank_date']);
        }
        if(!empty($filter['by_year'])){
            $this->db->where('fee.payment_year', $filter['by_year']);
           }else{
              $this->db->where('fee.payment_year', CURRENT_YEAR);
           }
        
        if($filter['by_type'] == 'Cancelled'){
            $this->db->where('fee.is_cancelled', 1);
        }else{
            $this->db->where('fee.is_cancelled', 0);
        }
        if(!empty($filter['created_date_time'])){
            $this->db->where('DATE(fee.created_date_time)', $filter['created_date_time']);
        }
        if(!empty($filter['created_by'])){
            $this->db->where('fee.created_by', $filter['created_by']); 
        }
       $this->db->where('fee.is_deleted', 1);
       $query = $this->db->get();
       return $query->num_rows();
    }
 
       //get students fetails lates update
    public function getGovtFeePaymentInfonew($page, $segment, $filter='')
    {
        $this->db->select('fee.payment_date,
             fee.row_id,
             fee.remarks,
             fee.receipt_number,
             fee.order_id,
             std.application_no,std.student_name,
             fee.paid_amount,
             fee.payment_type, 
             fee.bank_settlement_status,
             fee.term_name,
             fee.payment_year,
             fee.bank_settlement_date as date');
        $this->db->from('tbl_govt_fee_paid_info as fee');
             $this->db->join('tbl_students_info as std', 'std.row_id = fee.application_no','left');
           //  $this->db->join('tbl_fee_payment_bank_settlement as bank', 'bank.receipt_number = fee.row_id','left');
        if(!empty($filter['application_no'])){
            $this->db->where('std.application_no', $filter['application_no']);
        }
        if(!empty($filter['student_name'])){
            $likeCriteria = "(std.student_name  LIKE '%" . $filter['student_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['remarks'])){
            $this->db->where('fee.remarks', $filter['remarks']);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('std.application_no', $filter['student_id']);
        }
        if(!empty($filter['date_select'])){
            $this->db->where('fee.payment_date', $filter['date_select']);
        }
        if(!empty($filter['receipt_number'])){
            $this->db->where('fee.receipt_number', $filter['receipt_number']);
        }
        if(!empty($filter['amount_paid'])){
            $this->db->where('fee.paid_amount', $filter['amount_paid']);
        }
        if(!empty($filter['amount_pending'])){
            $this->db->where('fee.pending_balance', $filter['amount_pending']);
        }
        if(!empty($filter['by_term'])){
            $this->db->where('fee.term_name', $filter['by_term']);
        }
             if(!empty($filter['order_id'])){
              $this->db->where('fee.order_id', $filter['order_id']);
             }
      
             if(!empty($filter['payment_type'])){
              $this->db->where('fee.payment_type', $filter['payment_type']);
             }
      
             if($filter['bank_settlement'] == 'Settled'){
              $this->db->where('fee.bank_settlement_status', 1);
             }else if($filter['bank_settlement'] == 'Pending'){
              $this->db->where('fee.bank_settlement_status', 0);
             }
             if(!empty($filter['by_bank_date'])){
              $this->db->where('fee.bank_settlement_date', $filter['by_bank_date']);
             }
             if(!empty($filter['by_year'])){
              $this->db->where('fee.payment_year', $filter['by_year']);
             }else{
                $this->db->where('fee.payment_year', CURRENT_YEAR);
             }

            if($filter['by_type'] == 'Cancelled'){
                $this->db->where('fee.is_cancelled', 1);
            }else{
                $this->db->where('fee.is_cancelled', 0);
            }
            if(!empty($filter['created_date_time'])){
                $this->db->where('DATE(fee.created_date_time)', $filter['created_date_time']);
            }
            if(!empty($filter['created_by'])){
                $this->db->where('fee.created_by', $filter['created_by']); 
            }
            $this->db->where('fee.is_deleted', 1);
           $this->db->order_by('fee.receipt_number', 'DESC');
           $this->db->limit($page, $segment);
           $query = $this->db->get();
           return $query->result();
           
    }

    function getFeeYear(){
        $this->db->from('tbl_year_info as fee');
        $this->db->where('fee.fee_status', 1);
        $this->db->order_by('fee.year', 'DESC');
        $query = $this->db->get();
        return $query->result();   
    }

    public function checkInstalmentExists($student_id){
        $this->db->from('tbl_student_fee_installment_info as fee');
        $this->db->where('fee.application_no', $student_id);
        $this->db->where('fee.payment_status', 0);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
      public function updateInstalmentById($instllInfo,$row_id) {
        $this->db->where_in('row_id', $row_id);
        $this->db->update('tbl_student_fee_installment_info', $instllInfo);
        return TRUE;
    }
     function addFeePaymentLog($payInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_admission_payment_log_paytm', $payInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id;
    }
    function updateFeePaymentLog($row_id,$payInfo){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_admission_payment_log_paytm', $payInfo);
        return $this->db->affected_rows();
    }
    public function checkOrderIdExistsInFeePayment($order_id){
        $this->db->from('tbl_new_admission_overall_fee_payment_info as fee');
        $this->db->where('fee.order_id', $order_id);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    public function updateFeePaymentLogOrderID($order_id,$payInfo){
        $this->db->where('order_id', $order_id);
        $this->db->update('tbl_admission_payment_log_paytm', $payInfo);
        return $this->db->affected_rows();
    }
    public function getLogDetails($application_no)
    {
        $cutoffTime = date('Y-m-d H:i:s', strtotime('-3 days'));

        $this->db->select('
            logF.order_id,
            logF.payment_status,
            logF.created_date_time,
            logF.amount,
            logF.phone,
            logF.email
        ');
        $this->db->from('tbl_admission_payment_log_paytm as logF');
        $this->db->where('logF.registered_tbl_row_id', $application_no);
        $this->db->where('logF.is_deleted', 0);

        // ---- Conditional status logic ----
        $this->db->group_start()
            ->where('logF.payment_status', 'PENDING')   // always fetch
            ->or_group_start()
                ->where('logF.payment_status', 'FAILED')
                ->where('logF.created_date_time >=', $cutoffTime)
            ->group_end()
        ->group_end();

        $query = $this->db->get();
        return $query->result();
    }
    public function getLogDetailsCronJob(){
        $cutoffTime = date('Y-m-d H:i:s', strtotime('-16 minutes'));
        $this->db->select('
            logF.order_id,
            logF.payment_status,
            logF.created_date_time,
            logF.amount,
            logF.phone,
            logF.email,
            logF.registered_tbl_row_id
        ');
        $this->db->from('tbl_admission_payment_log_paytm as logF');
        $this->db->where('logF.is_deleted',0);
        // $this->db->where('logF.year',FEE_YEAR);
        $this->db->group_start();
        // Always check for PENDING or blank status
        $this->db->where_in('logF.payment_status', ['PENDING', ' ']);
            // OR failed payments from the last 3 days
            $this->db->or_group_start();
                $this->db->where('logF.payment_status', 'FAILED');
                $this->db->where('logF.created_date_time >=', date('Y-m-d 00:00:00', strtotime('-3 days')));
                $this->db->where('logF.created_date_time <=', date('Y-m-d 23:59:59'));
            $this->db->group_end();
        $this->db->group_end();
        $this->db->where("logF.created_date_time <", $cutoffTime);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
     public function getFeePaidStudentInfoForReport($filter=''){
        $this->db->select('fee.*, student.application_no,student.student_name,student.category,student.father_name,student.mother_name,student.stream_name');
        $this->db->from('tbl_new_admission_overall_fee_payment_info as fee');
        $this->db->join('tbl_students_info as student', 'student.row_id = fee.application_no','left'); 
       
        if(!empty($filter['date_from']) && !empty($filter['date_to'])){
            $this->db->where('fee.bank_settlement_date >=', $filter['date_from']);
            $this->db->where('fee.bank_settlement_date <=', $filter['date_to']);
        }
        
        // $this->db->where('student.is_deleted', 0);
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.bank_settlement_status', 1);
        $this->db->group_by('fee.receipt_number');
        $this->db->order_by('fee.row_id', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getStudentFeePaidInfoByStructure($receipt_number){
        $this->db->select('fee_paid.row_id,
        fee_paid.paid_amount,
        fee_paid.fee_type_id,
        str.fees_type,
        fee_paid.account_id_two as bank_2_row_id, 
        fee_paid.school_account_id as bank_1_row_id');
        $this->db->from('tbl_fees_paid_by_receipt_v2 as fee_paid');
        $this->db->join('tbl_admission_fee_structure as str','fee_paid.fee_structure_id = str.row_id','left');
        $this->db->where('fee_paid.receipt_number', $receipt_number);
        // $fee_year = array('2024');
        // $this->db->where_in('str.fee_year', $fee_year);
        $this->db->where('fee_paid.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getReceiptsBetween($from, $to, $year){
        $this->db->from('tbl_new_admission_overall_fee_payment_info');
        $this->db->where('receipt_number >=', $from);
        $this->db->where('receipt_number <=', $to);
        $this->db->where('is_deleted', 0);
        $this->db->where('payment_year', $year);
        $this->db->where('bank_settlement_status !=', 1);
        return $this->db->get()->result();
    }

    public function getTuitionFeeAmountByStructure($term_name,$stream_name,$payment_year){
        $this->db->from('tbl_student_fee_structure as fee');
        $this->db->where('fee.stream_name', $stream_name);
        $this->db->where('fee.term_name', $term_name);
        $this->db->where('fee.year', $payment_year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    public function getCategoryFeeAmount($filter){
        $this->db->select('SUM(fee.fee_amount_state_board) as total_fee');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
        $this->db->where_in('fee.term_name', $filter['term_name']);
        $this->db->where('fee.fee_year', $filter['fee_year']);
        $this->db->where('fee.is_deleted', 0);
        // Category-based condition
        if(!empty($filter['student_category'])){
            if(in_array($filter['student_category'], ['Outside India','Other State/IGCSE Board'])){
                $this->db->where('fee.fees_type', '20');
            } else if(in_array($filter['student_category'], ['Non-Karnataka'])){
                $this->db->where('fee.fees_type', '21');
            }
        }

        $query = $this->db->get();
        return $query->row()->total_fee;
    }

     public function getCategoryFeeName($filter){
        $this->db->select('type.fee_name as fee_type_name');
        $this->db->from('tbl_admission_fee_structure as fee');
         $this->db->join('tbl_fees_name as type', 'type.row_id = fee.fees_type','left');
        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
        $this->db->where_in('fee.term_name', $filter['term_name']);
        $this->db->where('fee.fee_year', $filter['fee_year']);
        $this->db->where('fee.is_deleted', 0);
        // Category-based condition
        if(!empty($filter['student_category'])){
            if(in_array($filter['student_category'], ['Outside India','Other State/IGCSE Board'])){
                $this->db->where('fee.fees_type', '20');
            } else if(in_array($filter['student_category'], ['Non-Karnataka'])){
                $this->db->where('fee.fees_type', '21');
            }
        }

        $query = $this->db->get();
        return $query->row();
    }
    public function updateStudentInfoByID($studentInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_students_info', $studentInfo);
        return TRUE;
    }
    public function getLastReceiptNoByFeeType($year, $feeTypeId){
        $this->db->select('paid.receipt_no');
        $this->db->from('tbl_fees_paid_by_receipt_v2 as paid');
        $this->db->where('paid.is_deleted', 0);
        $this->db->where('paid.payment_year', $year);
        $this->db->where('paid.fee_type_id', $feeTypeId);
        $this->db->like('paid.receipt_no', substr((string)$year, -2) . 'C', 'after');
        $this->db->order_by('paid.row_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $lastReceiptInfo = $query->row();
        return $this->formatReceiptNumber($year, 'C', !empty($lastReceiptInfo) ? $lastReceiptInfo->receipt_no : '');
    }
    private function formatReceiptNumber($year, $receiptTypePrefix, $lastReceiptNumber = ''){
        $yearPrefix = substr((string)$year, -2) . $receiptTypePrefix;
        $sequenceNumber = 1;
        if(!empty($lastReceiptNumber)){
            $lastReceiptNumber = strtoupper((string)$lastReceiptNumber);
            if(preg_match('/(\d+)$/', $lastReceiptNumber, $matches)){
                $sequenceNumber = ((int)$matches[1]) + 1;
            }
        }
        return $yearPrefix . sprintf('%04d', $sequenceNumber);
    }
    public function checkFeeTypeTotalPaid($application_no, $fee_id)
    {
        $this->db->select('SUM(paid.paid_amount) as total_paid');
        $this->db->from('tbl_fees_paid_by_receipt_v2 as paid');
        $this->db->where('paid.is_deleted', 0);
        $this->db->where('paid.application_no', $application_no);
        $this->db->where('paid.fee_type_id', $fee_id);
        $query = $this->db->get();
        return $query->row();
    }
}
?>