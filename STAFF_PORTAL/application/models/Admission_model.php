<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Admission_model extends CI_Model
{
    
    public function getAllFeeStructureInfo($filter){
        $this->db->select('
        fee.row_id, 
        fee.fees_type,
        fee.fee_amount_state_board,
        fee.fee_amount_icse_cbse,
        fee.fee_amount_nri,
        type.fee_name,
        fee.account_row_id');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->join('tbl_fees_name as type', 'type.row_id = fee.fees_type','left');
        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
        $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);
        if($filter['lang_fee_status'] == false){
            $this->db->where('type.row_id!=', 4); 
        }
        if($filter['nri_fee_status'] == false){
            $this->db->where('type.row_id!=', 11); 
        }
        if($filter['other_state_fee_status'] == false){
            $this->db->where('type.row_id!=', 12); 
        }
        $this->db->where('fee.fee_student_type', 'Unaided');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('type.is_deleted', 0);
        $this->db->order_by('type.priority', 'ASC');
        $this->db->order_by('fee.fee_amount_state_board','asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function getTotalFeeAmount($filter){
        $this->db->select('SUM(fee.fee_amount_state_board) as total_fee');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->join('tbl_fees_name as type', 'type.row_id = fee.fees_type','left');
        $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);
        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
        if($filter['lang_fee_status'] == false){
            $this->db->where('type.row_id!=', 4); 
        }
        $this->db->where('fee.fee_student_type', 'Unaided');
       // $this->db->where('fee.fee_division_row_id', $type_id);
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('type.is_deleted', 0);
        $this->db->order_by('fee.fee_amount_state_board','asc');
        $query = $this->db->get();
        return $query->row();
    }

    
    public function getNewAdmissionTotalFeeAmount($filter){
        
        if($filter['board_name'] == 'KARNATAKA STATE BOARD'){ 
            $this->db->select('SUM(fee.fee_amount_state_board) as total_fee');
        }else if($filter['board_name'] == 'CBSE' || $filter['board_name'] == 'ICSE'|| $filter['board_name'] == 'OTHER'){
            $this->db->select('SUM(fee.fee_amount_icse_cbse) as total_fee');
        }else{
            $this->db->select('SUM(fee.fee_amount_nri) as total_fee');
        }
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->join('tbl_fees_name as type', 'type.row_id = fee.fees_type','left');
        $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);
        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
        if($filter['lang_fee_status'] == false){
            $this->db->where('type.row_id!=', 4); 
        }
        if($filter['nri_fee_status'] == false){
            $this->db->where('type.row_id!=', 11); 
        }
        if($filter['other_state_fee_status'] == false){
            $this->db->where('type.row_id!=', 12); 
        }
        $this->db->where('fee.fee_student_type', 'Unaided');
       // $this->db->where('fee.fee_division_row_id', $type_id);
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('type.is_deleted', 0);
        $this->db->order_by('fee.fee_amount_state_board','asc');
        $query = $this->db->get();
        return $query->row();
    }



    //check fee paid already
    
    public function getFeePaidInfo($application_no){
        $this->db->from('tbl_students_overall_fee_payment_info as fee');
        $this->db->where('fee.is_deleted', 0);
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
   
    public function promoteStudent($stdInfo,$application_no) {
        $this->db->where_in('application_no', $application_no);
        $this->db->update('tbl_student_academic_info', $stdInfo);
        return TRUE;
    }

      //check fee paid already
    
      public function getStudentTotalPaidAmount($application_no){
        $this->db->select('SUM(fee.paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.application_no', $application_no);
        $query = $this->db->get();
        return $query->row();
    }

    
    public function getStdPaidDetailsByApplicationNo($application_no){
        $this->db->select('fee.paid_amount,fee.payment_count');
        $this->db->from('tbl_students_overall_fee_payment_info as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.application_no', $application_no);
        $this->db->order_by('fee.receipt_number', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    //fee concession
    public function getStudentFeeConcessionInfo($application_no){
        $this->db->from('tbl_student_fee_concession as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.approved_status', 1);
        //$this->db->where('fee.payment_status', 0);
        $this->db->where('fee.application_no', $application_no);
        $query = $this->db->get();
        return $query->row();
    }
    public function getStdFeeInstalmentInfo($application_no){
        $this->db->select('SUM(fee.amount) as paidAmount');
        $this->db->from('tbl_student_fee_installment_info as fee');
        $this->db->where('fee.is_deleted', 0);
        // $this->db->where('fee.approved_status', 1);
        //$this->db->where('fee.payment_status', 0);
        $this->db->where('fee.application_no', $application_no);
        $query = $this->db->get();
        return $query->row();
    }

    public function getStudentNewAdmFeeConcessionInfo($application_no){
        $this->db->from('tbl_new_admission_fee_concession as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.approved_status', 1);
       // $this->db->where('fee.payment_status', 0);
        $this->db->where('fee.application_no', $application_no);
        $query = $this->db->get();
        return $query->row();
    }
    public function updateNewAdmFeeConcessionInfo($feePayment,$application_no) {
        $this->db->where_in('application_no', $application_no);
        $this->db->where('approved_status', 1);
        $this->db->update('tbl_new_admission_fee_concession', $feePayment);
        return TRUE;
    }



    public function updateFeeConcessionInfo($feePayment,$application_no) {
        $this->db->where_in('application_no', $application_no);
        $this->db->where('approved_status', 1);
        $this->db->update('tbl_student_fee_concession', $feePayment);
        return TRUE;
    }


     //check fee paid already
    
   //fee concession
    public function getStudentFeeConcessionInfoForReceipt($application_no){
        $this->db->from('tbl_student_fee_concession as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.approved_status', 1);
        $this->db->where('fee.application_no', $application_no);
        $query = $this->db->get();
        return $query->row();
    }

    public function getStudentDetailsForFeePayment($filter){
        if($filter['term_name'] == 'II PUC'){
            $this->db->select('student.row_id,student.student_name,student.application_no,student.caste_others,academic.student_id,
            academic.term_name, academic.stream_name, academic.section_name, academic.elective_sub');
            $this->db->from('tbl_students_info as student'); 
            $this->db->join('tbl_student_academic_info as academic', 'academic.application_no = student.application_no','left');
            $this->db->where('academic.term_name', 'I PUC');
            $this->db->where('student.is_active', 1);
        }else{
            $this->db->select('student.row_id,student.name as student_name,std.application_number as application_no,std.application_number as student_id');
            $this->db->from('tbl_admission_student_personal_details_temp as student');
            $this->db->join('tbl_admission_students_status_temp as std', 'std.application_number = student.application_number','left');
            $this->db->where_in('std.admission_status', 1);
            $this->db->where('std.is_deleted', 0);
        }
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    

    public function getFirstYearStudentsInfo(){
        $this->db->select('student.row_id,student.name as student_name,student.application_number as application_no,
        student.application_number as student_id');
        $this->db->from('tbl_admission_student_personal_details_temp as student');
        $this->db->join('tbl_admission_students_status_temp as std', 'std.application_number = student.application_number','left');
        $this->db->where('std.admission_status', 1);
        $this->db->where('std.interview_status', 1);
        $this->db->where('std.shortlisted_status', 1);
        $this->db->where('std.adm_year', CURRENT_YEAR);
        $this->db->where('std.is_deleted', 0);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }


    public function checkFeeTypeIsAlreadyPaid($application_no,$fee_id){
        $this->db->from('tbl_fees_paid_by_receipt as paid');
        $this->db->where('paid.is_deleted', 0);
        $this->db->where('paid.application_no', $application_no);
        $this->db->where('paid.fee_type_id', $fee_id);
        $this->db->order_by('paid.receipt_number', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    public function updatePendingFeeOld($paymentInfo, $application_number) {
        $this->db->where('application_no', $application_number);
        $this->db->update('tbl_fee_pending_info_2021', $paymentInfo);
        return TRUE;
    }

    
    public function getStudentStudentInfo($application_number){
        $this->db->select('
        application.registered_row_id,
        application.application_number,
        personal.name as student_name,
        personal.caste,
        personal.father_name,
        personal.father_mobile,
        personal.mother_name,
        personal.mother_mobile,
        language.stream_name,
        language.term_name,
        language.second_language as elective_sub,
        application.admission_status,
        application.student_category as category,
        doc.doc_path,
        application.sslc_percentage');
        $this->db->from('tbl_admission_student_personal_details_temp as personal');
        $this->db->join('tbl_admission_combination_language_opted_temp as language', 'language.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_students_status_temp as application', 'application.registered_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_document_details_temp as doc', 'doc.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->where('application.application_number', $application_number);
        //$this->db->where('doc.doc_name', 'student_photo');
        $this->db->where('personal.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();   
    }

     // student registration info
    function getStudentRegisteredInfo($row_id){
        $this->db->from('tbl_admission_registered_student_temp as stud');
        $this->db->where('stud.row_id', $row_id);
        $this->db->where('stud.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function updateStudentApplicationStatus($application_number,$info) {
        $this->db->where('application_number', $application_number);
        $this->db->update('tbl_admission_students_status_temp', $info);
        return TRUE;
    }


    // admitted List
    public function getNewAdmittedStudentInfo($application_num) {
        $this->db->select('
        reg.sslc_board_name_id,
        reg.email,
        personal.resgisted_tbl_row_id,
        approved.application_number, 
        personal.blood_group,
        personal.student_mobile,
        personal.name,
        personal.religion,
        personal.dob,
        personal.residential_address,
        personal.physically_challenged,
        personal.dyslexia_challenged,
        personal.permanent_address,
        personal.mother_tongue,
        personal.nationality,
        personal.gender,
        personal.native_place,
        personal.aadhar_no,

        personal.father_name,
        personal.father_mobile,
        personal.father_qualification,
        personal.father_profession,
        personal.father_email,
        personal.father_age,
        personal.father_annual_income,

        personal.mother_name,
        personal.mother_mobile,
        personal.mother_qualification,
        personal.mother_profession,
        personal.mother_email,
        personal.mother_age,
        personal.mother_annual_income,

        personal.guardian_name,
        personal.guardian_mobile,
        personal.guardian_address,

        personal.permanent_address_line_1,
        personal.permanent_address_line_2,
        personal.permanent_address_district,
        personal.permanent_address_state,
        personal.permanent_address_pincode,

        personal.residential_address_line_1,
        personal.residential_address_line_2,
        personal.residential_address_district,
        personal.residential_address_state,
        personal.residential_address_pincode,

        personal.caste,
        personal.sub_caste,
        sjpuc.program_name,
        sjpuc.stream_name,

        board.board_name,
        approved.sslc_percentage,
        approved.student_category,
        approved.shortlisted_status,
        sjpuc.second_language,
    
        exam.register_number,
        reg.password,
        reg.password_text');
        $this->db->from('tbl_admission_students_status_temp as approved');
        
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'approved.registered_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_registered_student_temp as reg', 'reg.row_id = personal.resgisted_tbl_row_id','left');
        //$this->db->join('tbl_students_fee_payment_info as fee', 'fee.application_number = approved.application_number','left');
        $this->db->join('tbl_admission_school_and_examination_deatils_temp as exam', 'exam.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as sjpuc', 'sjpuc.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_sslc_board_name as board', 'board.row_id = reg.sslc_board_name_id','left');
    
        $this->db->where('approved.application_number', $application_num);
        $this->db->where('approved.is_deleted', 0);
        $this->db->where('approved.interview_status', 1);
        $this->db->where('approved.shortlisted_status', 1);
    // $this->db->where('approved.admission_status', 1);
        $query = $this->db->get();
        return $query->row(); 
    }



    public function getAllAdmittedStudentInfo() {
        $this->db->select('
        reg.sslc_board_name_id,
        reg.email,
        personal.resgisted_tbl_row_id,
        approved.application_number, 
        personal.blood_group,
        personal.student_mobile,
        personal.name,
        personal.religion,
        personal.dob,
        personal.residential_address,
        personal.physically_challenged,
        personal.dyslexia_challenged,
        personal.permanent_address,
        personal.mother_tongue,
        personal.nationality,
        personal.gender,
        personal.native_place,
        personal.aadhar_no,

        personal.father_name,
        personal.father_mobile,
        personal.father_qualification,
        personal.father_profession,
        personal.father_email,
        personal.father_age,
        personal.father_annual_income,

        personal.mother_name,
        personal.mother_mobile,
        personal.mother_qualification,
        personal.mother_profession,
        personal.mother_email,
        personal.mother_age,
        personal.mother_annual_income,

        personal.guardian_name,
        personal.guardian_mobile,
        personal.guardian_address,

        personal.permanent_address_line_1,
        personal.permanent_address_line_2,
        personal.permanent_address_district,
        personal.permanent_address_state,
        personal.permanent_address_pincode,

        personal.residential_address_line_1,
        personal.residential_address_line_2,
        personal.residential_address_district,
        personal.residential_address_state,
        personal.residential_address_pincode,

        personal.caste,
        personal.sub_caste,
        sjpuc.program_name,
        sjpuc.stream_name,

        board.board_name,
        approved.sslc_percentage,
        approved.student_category,
        approved.shortlisted_status,
        sjpuc.second_language,
    
        exam.register_number,
        reg.password,
        reg.password_text');
        $this->db->from('tbl_admission_students_status_temp as approved');
        
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'approved.registered_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_registered_student_temp as reg', 'reg.row_id = personal.resgisted_tbl_row_id','left');
        //$this->db->join('tbl_students_fee_payment_info as fee', 'fee.application_number = approved.application_number','left');
        $this->db->join('tbl_admission_school_and_examination_deatils_temp as exam', 'exam.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as sjpuc', 'sjpuc.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_sslc_board_name as board', 'board.row_id = reg.sslc_board_name_id','left');
            $this->db->where('approved.is_deleted', 0);
        $this->db->where('approved.interview_status', 1);
        $this->db->where('approved.shortlisted_status', 1);
        $this->db->where('approved.adm_year', 2022);
    // $this->db->where('approved.admission_status', 1);
        $query = $this->db->get();
        return $query->result(); 
    }




}

 