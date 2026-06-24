<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class FeeDashboard_model extends CI_Model {

    public function getFeePaidInfoOverall($from_date,$to_date,$year){
        $this->db->from('tbl_new_admission_overall_fee_payment_info as fee');
        $this->db->where('fee.payment_date >=', date('Y-m-d',strtotime($from_date)));
        $this->db->where('fee.payment_date <=', date('Y-m-d',strtotime($to_date)));
        $this->db->where('fee.payment_year', $year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getDeptFeePaidInfoOverall($from_date,$to_date,$year){
        $this->db->from('tbl_govt_fee_paid_info as fee');
        $this->db->where('fee.payment_year', $year);
        $this->db->where('fee.payment_date >=', date('Y-m-d',strtotime($from_date)));
        $this->db->where('fee.payment_date <=', date('Y-m-d',strtotime($to_date)));
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getMiscFeePaidInfoOverall($from_date,$to_date,$fee_year){
        $this->db->from('tbl_miscellaneous_fee as fee');
        $this->db->where('fee.date >=', date('Y-m-d',strtotime($from_date)));
        $this->db->where('fee.date <=', date('Y-m-d',strtotime($to_date)));
        $this->db->where('fee.year', $fee_year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getSumOfFeesPaidClassWise($class,$year){
        $this->db->select('SUM(paid_amount) as paid_amount');
        $this->db->from('tbl_new_admission_overall_fee_payment_info as fee');
        $this->db->join('tbl_students_info as std', 'std.row_id = fee.rel_stud_row_id','left');
      //  $this->db->join('tbl_student_class_year_wise as year', 'year.stud_row_id = std.row_id');
        $this->db->where('fee.term_name', $class);
       // $this->db->where('year.intake_year', $year);
        $this->db->where('fee.payment_year', $year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row()->paid_amount;
    }

    public function getSumOfFeeconcession($class,$year){
        $this->db->select('SUM(fee_amt) as fee_amt');
        $this->db->from('tbl_student_fee_concession as fee');
        $this->db->join('tbl_students_info as std','std.application_no = fee.application_no','left');
        $this->db->where('std.term_name', $class);
        $this->db->where('fee.year', $year);
        $this->db->where('fee.approved_status', 1);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row()->fee_amt;
    }

    

    public function getCountOfTotalStudentsForFee($class,$year){
        $this->db->from('tbl_students_info as student'); 
       // $this->db->join('tbl_student_class_year_wise as year', 'year.stud_row_id = student.row_id');
        $this->db->where('year.class', $class);
        $this->db->where('year.intake_year', $year);
        $query = $this->db->get();
        return $query->num_rows();
    }

   
   

    public function getNewAdmissionFee(){
        $this->db->select('SUM(fee.fee_amount) as fee_amount');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where_in('fee.fee_type', ['NEW','ALL']);
        $this->db->where('fee.fee_year',FEE_YEAR);
        $query = $this->db->get();
        return $query->row();
    }

    public function getRegAdmissionFee(){
        $this->db->select('SUM(fee.fee_amount) as fee_amount');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where_in('fee.fee_type', ['REGULAR','ALL']);
        $this->db->where('fee.fee_year',FEE_YEAR);
        $query = $this->db->get();
        return $query->row();
    }

    public function getCancelledReceiptInfo($year) {
        $this->db->select('fee.row_id,fee.receipt_number,fee.application_no,fee.fee_account_row_id,fee.payment_date,fee.payment_type,
        fee.total_amount,fee.paid_amount,fee.excess_amount,fee.fee_concession,fee.fee_pending_status,fee.pending_balance,fee.updated_by,
        fee.bank_settlement_status,student.sat_number,fee.payment_year,fee.remarks');
        $this->db->from('tbl_new_admission_overall_fee_payment_info as fee');
        $this->db->join('tbl_students_info as student', 'student.row_id = fee.application_no','left'); 
        $this->db->where('fee.payment_year', $year);

        $this->db->where('fee.is_deleted', 1);
        $this->db->group_by('fee.row_id');
        // $this->db->where('student.is_deleted', 0);
        $this->db->order_by('fee.payment_date', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getTotalPUStudentsCount($class,$stream,$fee_year,$gender = null)
    {
        $this->db->from('tbl_students_info as student');
        $this->db->join('tbl_student_class_year_wise as year', 'year.stud_row_id = student.row_id');
        $this->db->where('year.stream',$stream);
        $this->db->where('year.class',$class);
        if(!empty($gender)){
            $this->db->where('UPPER(student.gender)', strtoupper($gender));
        }
        $this->db->where('year.intake_year', $fee_year);
        $this->db->where('year.discontinued_status', 0);
        $this->db->where('year.is_deleted',0);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getSumOfPUCFeesPaidClassWise($class,$stream,$fee_year,$gender = null){
        $this->db->select('SUM(paid_amount) as paid_amount');
        $this->db->from('tbl_new_admission_overall_fee_payment_info as fee');
        $this->db->join('tbl_students_info as std', 'std.row_id = fee.application_no','left'); 
        $this->db->join('tbl_student_class_year_wise as year', 'year.stud_row_id = std.row_id');
        $this->db->where('year.class', $class);
        $this->db->where('year.stream', $stream);
        if(!empty($gender)){
            $this->db->where('UPPER(std.gender)', strtoupper($gender));
        }
        $this->db->where('fee.payment_year', $fee_year);
        $this->db->where('year.intake_year', $fee_year);
        $this->db->where('year.discontinued_status', 0);
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $this->db->where('year.is_deleted', 0);
        $query = $this->db->get();
        return $query->row()->paid_amount;
    }

    public function getSumOfPUCGovtFeesPaidClassWise($class,$stream,$fee_year,$gender = null){
        $this->db->select('SUM(paid_amount) as paid_amount');
        $this->db->from('tbl_govt_fee_paid_info as fee');
        $this->db->join('tbl_students_info as std', 'std.row_id = fee.application_no','left'); 
        $this->db->join('tbl_student_class_year_wise as year', 'year.stud_row_id = std.row_id');
        $this->db->where('fee.term_name', $class);
        $this->db->where('std.stream_name', $stream);
        if(!empty($gender)){
            $this->db->where('UPPER(std.gender)', strtoupper($gender));
        }
        $this->db->where('fee.payment_year', $fee_year);
        $this->db->where('year.intake_year', $fee_year);
        $this->db->where('year.discontinued_status', 0);
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $this->db->where('year.is_deleted', 0);
        $query = $this->db->get();
        return $query->row()->paid_amount;
    }

    public function getSumOfIPUCFeesPaidClassWise($class,$stream,$fee_year){
        $this->db->select('SUM(paid_amount) as paid_amount');
        $this->db->from('tbl_new_admission_overall_fee_payment_info as fee');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'personal.application_number = fee.application_no','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as language', 'language.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->where('fee.term_name', $class);
        $this->db->where('language.stream_name', $stream);
        $this->db->where('fee.payment_year', $fee_year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row()->paid_amount;
    }

  
    public function getSumOfPUCFeesConcession($class,$stream,$fee_year,$gender = null){
        $this->db->select('SUM(fee_amt) as fee_amt');
        $this->db->from('tbl_student_fee_concession as fee');
        $this->db->join('tbl_students_info as std', 'std.row_id = fee.application_no','left'); 
        $this->db->join('tbl_student_class_year_wise as year', 'year.stud_row_id = std.row_id');
        $this->db->where('year.class', $class);
        $this->db->where('year.stream', $stream);
        if(!empty($gender)){
            $this->db->where('UPPER(std.gender)', strtoupper($gender));
        }
        $this->db->where('year.intake_year', $fee_year);
        $this->db->where('fee.year', $fee_year);
        $this->db->where('year.discontinued_status', 0);
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->row()->fee_amt;
    }

    public function getGenderInfo(){
        $this->db->select('TRIM(UPPER(student.gender)) as gender', false);
        $this->db->from('tbl_students_info as student');
        $this->db->where('student.is_deleted', 0);
        $this->db->where('student.gender IS NOT NULL', null, false);
        $this->db->where('TRIM(student.gender) !=', '');
        $this->db->distinct();
        $this->db->order_by('gender', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getSumOfIPUCFeesConcession($class,$stream){
        $this->db->select('SUM(fee_amt) as fee_amt');
        $this->db->from('tbl_student_fee_concession as fee');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'personal.application_number = fee.application_no','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as language', 'language.registred_row_id = personal.resgisted_tbl_row_id','left'); 
        $this->db->where('language.term_name', $class);
        $this->db->where('language.stream_name', $stream);
        $this->db->where('fee.year', $fee_year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row()->fee_amt;
    }

    public function getTotalFeeAmount($filter){
        $this->db->select('SUM(fee.fee_amount_state_board) as total_fee');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
        $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);
        $this->db->where_in('fee.gender', [$filter['gender'],'ALL']);
        $this->db->where('fee.fee_year', $filter['fee_year']);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getDepartmentFeeAmount($filter){
        $this->db->select('SUM(fee.fee_amount_state_board) as total_fee');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
        $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);
        $this->db->where('fee.fee_year', $filter['fee_year']);
        $this->db->where('fee.is_deleted', 0);
        if($filter['term_name'] == 'I PUC'){
            $fee_type = array('College Dept Fee');
            $this->db->where_in('fee.fees_type', $fee_type);
        }else{
            $this->db->where('fee.fees_type', 'College Dept Fee');
        }
     
        $query = $this->db->get();
        return $query->row()->total_fee;
    }

    function getStreamInfo(){
        $this->db->select('term.stream_name');
       $this->db->from('tbl_program_stream_info as term');
       $this->db->where('term.is_deleted', 0);
       $query = $this->db->get();
       $result = $query->result();        
       return $result;
   }

   public function getInactiveStdFeePaidInfo($year) {
    $this->db->select('fee.row_id,fee.receipt_number,fee.application_no,fee.fee_account_row_id,fee.payment_date,fee.payment_type,student.admission_no,
    fee.total_amount,fee.paid_amount,fee.excess_amount,fee.fee_concession,fee.fee_pending_status,fee.pending_balance,fee.updated_by,student.student_name,
    fee.bank_settlement_status,student.sat_number,fee.dd_number,fee.transaction_number,fee.payment_year,fee.remarks,year.stream,year.class,year.section');
    $this->db->from('tbl_new_admission_overall_fee_payment_info as fee');
    $this->db->join('tbl_students_info as student', 'student.row_id = fee.application_no','left'); 
    $this->db->join('tbl_student_class_year_wise as year', 'year.stud_row_id = student.row_id');
    $this->db->where('fee.payment_year', $year);
    $this->db->where('year.intake_year', $year);
    $this->db->group_start();
    $this->db->where('year.discontinued_status', 1);
    $this->db->or_where('student.is_deleted', 1);
    $this->db->or_where('year.is_deleted', 1);
    $this->db->group_end(); 
    $this->db->where('fee.is_deleted', 0);
    $this->db->order_by('fee.payment_date', 'DESC');
    $query = $this->db->get();
    return $query->result();
    }

    public function getStaffNameById($staff_id) {
        $this->db->from('tbl_staff as staff'); 
        $this->db->where('staff.staff_id', $staff_id);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();  
    }

    function getFeesYearInfo(){
        $this->db->from('tbl_year_info as att');
        $this->db->where('att.fee_status', 1);
        $this->db->order_by('att.year', 'DESC');
        $query = $this->db->get();
        return $query->result();   
    }
}?>