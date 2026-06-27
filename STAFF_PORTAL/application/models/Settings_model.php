<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Settings_model extends CI_Model{
    //getting shift info
    public function getAllShiftInfo(){
        $this->db->from('tbl_staff_shift_info as shift');
        $this->db->where('shift.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    //getting department Info
    public function getAllDepartmentInfo(){
        $this->db->from('tbl_department as dept');
        $this->db->where('dept.is_deleted', 0);
        $this->db->order_by('dept.dept_id','asc');
        $query = $this->db->get();
        return $query->result();
    }
     public function getExpenseInfo(){
        $this->db->from('tbl_expense_type as expense');
        $this->db->where('expense.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    //getting category info
    public function getAllCategoryInfo(){
        $this->db->from('tbl_category as category');
        $this->db->where('category.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    //getting religion info
    public function getAllReligionInfo(){
        $this->db->from('tbl_religion_details as religion');
        $this->db->where('religion.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

      //getting religion info
      public function getAlldeposittypeInfo(){
        $this->db->from('tbl_bank_deposit_type as deposittype');
        $this->db->where('deposittype.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAlldepositaccountInfo(){
        $this->db->from('tbl_bank_deposit_account as depositaccount');
        $this->db->where('depositaccount.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    //getting cast info
    public function getAllCasteInfo(){
        $this->db->from('tbl_caste_details as caste');
        $this->db->where('caste.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    //getting nationality info
    public function getAllNationalityInfo(){
        $this->db->from('tbl_nationality as nationality');
        $this->db->where('nationality.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    /* This function is used to add department */
    public function addDepartment($departmentInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_department', $departmentInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    
     /**
     * This function is used to add college details
     */
    public function addReligion($religionInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_religion_details', $religionInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function adddeposittype($deposittypeInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_bank_deposit_type', $deposittypeInfo); 
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function adddepositaccount($depositaccountInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_bank_deposit_account', $depositaccountInfo); 
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
   /**
     * This function is used to add college details
     */
    public function addCaste($castInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_caste_details', $castInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function checkCasteExists($caste_name){
        $this->db->from('tbl_caste_details as caste');
        $this->db->where('caste_name', $caste_name);
        $this->db->where('caste.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

     /**
     * This function is used to add nationalityInfo details
     */
    public function addNationality($nationalityInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_nationality', $nationalityInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

     /**
     * This function is used to add category  details
     */
    public function addCategory($categoryInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_category', $categoryInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function updateReligion($religionInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_religion_details', $religionInfo);
        return TRUE;
    }

    public function updatedeposittype($deposittypeInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_bank_deposit_type', $deposittypeInfo);
        return TRUE;
    }

    public function updatedepositaccount($depositaccountInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_bank_deposit_account', $depositaccountInfo);
        return TRUE;
    }

    
    public function updateCaste($casteInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_caste_details', $casteInfo);
        return TRUE;
    }

    public function updateNationality($nationalityInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_nationality', $nationalityInfo);
        return TRUE;
    }

    public function updateCategory($categoryInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_category', $categoryInfo);
        return TRUE;
    }
    public function updateDepartment($deptInfo, $row_id){
        $this->db->where('id', $row_id);
        $this->db->update('tbl_department', $deptInfo);
        return TRUE;
    }

    public function checkDeptIdExists($dept_id){
        $this->db->from('tbl_department as dept');
        $this->db->where('dept_id', $dept_id);
        $this->db->where('dept.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getStreamInfo(){
        $this->db->from('tbl_program_stream_info as stream');
        $this->db->where('stream.is_deleted', 0);
        // $this->db->order_by('stream.term_name','asc');
        // $this->db->order_by('stream.stream_name','asc');
        $query = $this->db->get();
        return $query->result();
    }
    public function getDistinctStreamInfo(){
        $this->db->from('tbl_stream_info as stream');
        $this->db->where('stream.is_deleted', 0);
        $this->db->order_by('stream.row_id','asc');
        $this->db->group_by('stream.stream_name');
        $query = $this->db->get();
        return $query->result();
    }

    function addSection($sectionInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_section_info', $sectionInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getSectionInfo($filter=''){
        $this->db->select('section.row_id,section.stream_id,stream.stream_name,section.section_name,section.class_type,
        section.class_teacher,staff.staff_id,staff.name,section.term_name,section.feedback_status');
        $this->db->from('tbl_section_info as section');
        $this->db->join('tbl_stream_info as stream', 'stream.row_id = section.stream_id','left');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = section.class_teacher','left'); 
        if(!empty($filter['by_term'])){
            $this->db->where('section.term_name', $filter['by_term']);
        }
        if(!empty($filter['by_stream'])){
            $this->db->where('stream.stream_name', $filter['by_stream']);
        }
        if(!empty($filter['by_section'])){
            $this->db->where('section.section_name', $filter['by_section']);
        }
        if(!empty($filter['by_class_type'])){
            $this->db->where('section.class_type', $filter['by_class_type']);
        }
        if(!empty($filter['by_class_teacher'])){
            $this->db->where('staff.staff_id', $filter['by_class_teacher']);
        }
       // $this->db->where('section.year', CURRENT_YEAR);
        $this->db->where('section.is_deleted', 0);
        $this->db->where('stream.is_deleted', 0);
        $this->db->order_by('section.term_name','asc');
        $this->db->order_by('stream.row_id','asc');
        $query = $this->db->get();
        return $query->result();
    }
    function updateSection($sectionInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_section_info', $sectionInfo);
        return TRUE;
    }
    function checkSectionExists($section,$stream_id,$term_name) {
        $this->db->from('tbl_section_info as section');
        $this->db->where('section.stream_id', $stream_id);
        $this->db->where('section.section_name', $section);
        $this->db->where('section.term_name', $term_name);
        // $this->db->where('section.year', 2021);
        $this->db->where('section.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    // class timings
    public function addTimings($classInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_class_timings', $classInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    
    function checkClassTimingsExists($start_time,$end_time,$week_id) {
        $this->db->from('tbl_class_timings as class');
        $this->db->join('tbl_weekname as week', 'week.row_id = class.week_row_id','left');
        $this->db->where('class.start_time', $start_time);
        $this->db->where('class.end_time', $end_time);
        $this->db->where('class.week_row_id', $week_id);
        $this->db->where('class.is_deleted', 0);
        $this->db->where('week.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    // get all class timings
    public function getAllClassTimingsInfo(){
        $this->db->select('class.row_id,week.row_id as week_id,class.start_time,class.end_time,week.week_name');
        $this->db->from('tbl_class_timings as class');
        $this->db->join('tbl_weekname as week', 'week.row_id = class.week_row_id','left');
        $this->db->where('class.is_deleted', 0);
        $this->db->where('week.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function updateClassTimings($classInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_class_timings', $classInfo);
        return TRUE;
    }

    
    // time table shifting info
    public function addDayShiftingInfo($shiftingInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_timetable_day_shifting', $shiftingInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function getAllTimetableDayShiftingInfo() {
        $this->db->select('shift.row_id,week.week_name,shift.date,shift.week_id');
        $this->db->from('tbl_timetable_day_shifting as shift');
        $this->db->join('tbl_weekname as week', 'week.row_id = shift.week_id');
        $this->db->where('shift.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    public function updateTimetableDayShift($shiftInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_timetable_day_shifting', $shiftInfo);
        return TRUE;
    }
    function checkTimetableShiftingExists($week_id,$date) {
        $this->db->from('tbl_timetable_day_shifting as shift');
        $this->db->where('shift.week_id', $week_id);
        $this->db->where('shift.date', $date);
        $this->db->where('shift.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

       // class timings
       public function addFeesName($feeInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_fees_name', $feeInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    
    function checkFeeNameExists($fee_name) {
        $this->db->from('tbl_fees_name as fee');
        $this->db->where('fee.fee_name', $fee_name);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    // get all class timings
    public function getAllFeeNameInfo(){
        $this->db->from('tbl_fees_name as fee');
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function updateFeeNameInfo($feeInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_fees_name', $feeInfo);
        return TRUE;
    }

    

    // election Details
    public function updatePost($postInfo, $post_id){
        $this->db->where('post_id', $post_id);
        $this->db->update('tbl_student_election_post_info', $postInfo);
        return TRUE;

    }
    public function addPost($postInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_student_election_post_info', $postInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function getAllPostInfo(){
        $this->db->from('tbl_student_election_post_info as post');
        $this->db->where('post.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    // fee type
    public function updateFeeType($feeInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_fee_structure_type', $feeInfo);
        return TRUE;

    }
    public function addFeeType($feeInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_fee_structure_type', $feeInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function getAllFeeTypeInfo(){
        $this->db->from('tbl_fee_structure_type as fee');
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    
    public function addRelegionInfo($relInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_admission_religion_info', $relInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function updatedStudentInfo($student_info,$student_id){
        $this->db->where('student_id', $student_id);
        $this->db->update('tbl_students_info', $student_info);
        return TRUE;
    }

    public function getAllMiscellaneousTypeInfo(){
        $this->db->from('tbl_miscellaneous_type as fee');
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function addMiscellaneousType($miscellaneousInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_miscellaneous_type', $miscellaneousInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function updateMiscellaneousType($miscellaneousInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_miscellaneous_type', $miscellaneousInfo);
        return TRUE;

    }

    public function updateStudent($staffInfo,$register_no){
        $this->db->where('register_no', $register_no);
        $this->db->update('tbl_students_info',$staffInfo);
        return TRUE;
    }

    public function getStaffDepartmentInfo($dept){
        $this->db->from('tbl_department as dept');
        $this->db->where('dept.is_deleted', 0);
        $this->db->where('dept.name',$dept);
        $query = $this->db->get();
        return $query->row();
    }

    public function getStaffRoleInfo($role){
        $this->db->from('tbl_roles as role');
        $this->db->where('role.role',$role);
        $query = $this->db->get();
        return $query->row();
    }
    public function getAllDocumentTypeInfo() {
        $this->db->from('tbl_document_type_info as doc');
        $this->db->where('doc.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    function checkDocNameExists($doc_name) {
        $this->db->from('tbl_document_type_info as doc');
        $this->db->where('doc.document_name', $doc_name);
        $this->db->where('doc.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function addDocName($villageInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_document_type_info', $villageInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function updateDocumentType($categoryInfo, $row_id) {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_document_type_info', $categoryInfo);
        return TRUE;
    }

    function getEmployeeId() {
        $this->db->from('tbl_staff');
        $this->db->where('staff_id!=','123456');
        $this->db->where('role!=','50');
        $this->db->where('role!=','51');
        $query = $this->db->get();
        return $query->result();
    }
 
 
    public function updateEmployeeIdInfo($idInfo, $staff_id) {  
        $this->db->where('row_id', $staff_id);
        $this->db->update('tbl_staff', $idInfo);
        return TRUE;
 
    }

    public function getAllOTAmountInfo(){
        $this->db->from('tbl_ot_amount as ot');
        $this->db->where('ot.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    function checkOTAmountExists($ot_amount) {
        $this->db->from('tbl_ot_amount as ot');
        $this->db->where('ot.ot_amount', $ot_amount);
        $this->db->where('ot.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function addOTAmount($AmountInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_ot_amount', $AmountInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function updateOTAmountInfo($Info, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_ot_amount', $Info);
        return TRUE;
    }

    public function addStaffRemarkName($remarkInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_staff_remarks_type', $remarkInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

       // Remarks
       public function getStaffRemarkNameInfo()
       {
           $this->db->from('tbl_staff_remarks_type as remark');
           $this->db->where('remark.is_deleted', 0);
           $query = $this->db->get();
           return $query->result();
       }

       public function updateStaffRemarksInfo($Info, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff_remarks_type', $Info);
        return TRUE;
    }

    public function addExamType($remarkInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_exam_type', $remarkInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getExamTypeInfo()
    {
        $this->db->from('tbl_exam_type as remark');
        $this->db->where('remark.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function updateExamTypeInfo($Info, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_exam_type', $Info);
        return TRUE;
    }

    function checkSalaryTypeExists($salary_type,$calculate_type,$salary_category) {
        $this->db->from('tbl_salary_type as type');
        $this->db->where('type.salary_type', $salary_type);
        $this->db->where('type.calculate_type', $calculate_type);
        $this->db->where('type.salary_category', $salary_category);
        $this->db->where('type.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function addSalaryType($salaryTypeInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_salary_type', $salaryTypeInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getAllSalaryTypeInfo(){
        $this->db->from('tbl_salary_type as type');
        $this->db->where('type.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllSalaryEarningTypeInfo(){
        $this->db->from('tbl_salary_type as type');
        $this->db->where('type.salary_category', 'EARNINGS');
        $this->db->where('type.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllSalaryDeductionTypeInfo(){
        $this->db->from('tbl_salary_type as type');
        $this->db->where('type.salary_category', 'DEDUCTION');
        $this->db->where('type.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function updateSalaryType($salaryTypeInfo, $row_id) {   
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_salary_type', $salaryTypeInfo);
        return TRUE;

    }

    function getCalculationTypeBySalaryType($salary_type) {
        $this->db->from('tbl_salary_type as type');
        $this->db->where('type.salary_type', $salary_type);
        $this->db->where('type.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function checkSalaryDesignationExists($designation) {
        $this->db->from('tbl_salary_designation_details as type');
        $this->db->where('type.designation', $designation);
        $this->db->where('type.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function addSalaryDesignation($designation) {
        $this->db->trans_start();
        $this->db->insert('tbl_salary_designation_details', $designation);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getAllSalarydesignationInfo(){
        $this->db->from('tbl_salary_designation_details as type');
        $this->db->where('type.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function updateSalaryDesignation($salaryTypeInfo, $row_id) {   
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_salary_designation_details', $salaryTypeInfo);
        return TRUE;

    }

    
    public function updateSalaryEarnings($salaryTypeInfo, $row_id) {   
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff_earning_details', $salaryTypeInfo);
        return TRUE;

    }

    public function updateSalaryDeduction($salaryTypeInfo, $row_id) {   
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff_deduction_details', $salaryTypeInfo);
        return TRUE;

    }

    function checkTaxRegimeExists($tax_regime) {
        $this->db->from('tbl_tax_regime_type as type');
        $this->db->where('type.type', $tax_regime);
        $this->db->where('type.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function addTaxRegimeType($tax_regime) {
        $this->db->trans_start();
        $this->db->insert('tbl_tax_regime_type', $tax_regime);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getAllTaxRegimeInfo(){
        $this->db->from('tbl_tax_regime_type as type');
        $this->db->where('type.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function updateTaxRegime($tax_regime, $row_id) {   
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_tax_regime_type', $tax_regime);
        return TRUE;

    }

    function getSalaryDetailsExistEarnings($year,$staff_id,$salary_type) {
        $this->db->from('tbl_staff_earning_details as earning');
        $this->db->where('earning.year', $year);
        $this->db->where('earning.staff_id', $staff_id);
        $this->db->where('earning.salary_type', $salary_type);
        $this->db->where('earning.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function addEarning($earning_data){
        $this->db->trans_start();
        $this->db->insert('tbl_staff_earning_details', $earning_data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    function getSalaryDetailsExistDeduction($year,$staff_id,$salary_type) {
        $this->db->from('tbl_staff_deduction_details as deduction');
        $this->db->where('deduction.year', $year);
        $this->db->where('deduction.staff_id', $staff_id);
        $this->db->where('deduction.salary_type', $salary_type);
        $this->db->where('deduction.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function addDeduction($deduction_data){
        $this->db->trans_start();
        $this->db->insert('tbl_staff_deduction_details', $deduction_data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getAllstudentInformation() {
        $this->db->select('std.row_id,std.section_name,std.term_name,std.stream_name');
        $this->db->from('tbl_students_info as std');        
        $this->db->order_by('std.row_id', 'ASC');
        $this->db->where('std.is_active', 1);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    function checkYearWiseExists($row_id,$year) {
        $this->db->from('tbl_student_class_year_wise as sem');
        $this->db->where('sem.stud_row_id', $row_id);
        $this->db->where('sem.intake_year', $year);
        $this->db->where('sem.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function updateYearWiseInfo($yearWiseInfo,$row_id,$year){
        $this->db->where('stud_row_id', $row_id);
        $this->db->where('intake_year', $year);
        $this->db->where('is_deleted', 0);
        $this->db->update('tbl_student_class_year_wise', $yearWiseInfo); 
        return TRUE;
    }

    public function addYearWiseInfo($yearWiseInfo){
        $this->db->insert('tbl_student_class_year_wise', $yearWiseInfo);
        return TRUE;
    }
    public function getTermInfo(){
        $this->db->from('tbl_term_name as stream');
        $this->db->where('stream.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    function updateclassTimingInfo($timingInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff_shift_info', $timingInfo);
        return TRUE;
    }

    public function addStaffShiftinfo($shiftInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_staff_shift_info', $shiftInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function checkStaffShiftExists($shift_code){
        $this->db->from('tbl_staff_shift_info as shift');
        $this->db->where('shift.shift_code', $shift_code);
        $this->db->where('shift.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function updateshiftinfo($salaryTypeInfo, $row_id) {   
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff_shift_info', $salaryTypeInfo);
        return TRUE;

    }

    public function getStudentYearInfo()
    {
        $this->db->from('tbl_year_info as year');
        $this->db->where('year.is_deleted', 0);
        $this->db->where('year.fee_status', 1);
        $this->db->order_by('year.year','desc');
        $query = $this->db->get();
        return $query->result();
    }
    public function getExamYearInfo()
    {
        $this->db->from('tbl_year_info as year');
        $this->db->where('year.is_deleted', 0);
        $this->db->where('year.exam_status', 1);
        $this->db->order_by('year.exam_year','desc');
        $query = $this->db->get();
        return $query->result();
    }
  // Remarks
      public function getRemarkNameInfo()
    {
        $this->db->from('tbl_student_remarks_type as remark');
        $this->db->where('remark.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function addRemarkName($remarkInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_student_remarks_type', $remarkInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function deleteRemarkName($remarkInfo, $row_id)
    {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_student_remarks_type', $remarkInfo);
        return TRUE;
    }
    public function getAllRoleInfoById($roleId){
        $this->db->from('tbl_roles as role');
        if(!empty($roleId)){
            $this->db->where('role.roleId',$roleId);
        }else{
            $this->db->where('role.roleId',1);
        }
        $query = $this->db->get();
        return $query->row();
    }
    public function getAllRoleInfo(){
        $this->db->from('tbl_roles as role');
        $this->db->order_by('role.roleId','asc');
        $query = $this->db->get();
        return $query->result();
    }
     public function getAllModulesInfo(){
        $this->db->from('tbl_modules as model');
        $this->db->where('model.is_deleted', 0);
        $this->db->order_by('model.priority','asc');
        $query = $this->db->get();
        return $query->result();
    }
    public function checkModuleExists($module_name){
        $this->db->from('tbl_modules as model');
        $this->db->where('model.menu_name', $module_name);
        $this->db->where('model.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function addModule($moduleInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_modules', $moduleInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function updateModule($moduleInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_modules', $moduleInfo);
        return TRUE;
    }
    public function getAllSubModulesInfo(){
        $this->db->select('sub.row_id,sub.module_id,mod.menu_name,sub.menu_name,sub.icon,sub.priority,sub.redirect_url');
        $this->db->from('tbl_sub_modules as sub');
        $this->db->join('tbl_modules as mod', 'mod.row_id = sub.module_id','left');
        $this->db->where('sub.is_deleted', 0);
        $this->db->where('mod.is_deleted', 0);
        $this->db->order_by('mod.priority','asc');
        $this->db->order_by('sub.priority','asc');
        $query = $this->db->get();
        return $query->result();
    }
    public function checkSubModuleExists($module_id,$sub_module_name){
        $this->db->from('tbl_sub_modules as sub');
        $this->db->where('sub.module_id', $module_id);
        $this->db->where('sub.menu_name', $sub_module_name);
        $this->db->where('sub.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function addSubModule($subModuleInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_sub_modules', $subModuleInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function updateSubModule($subModuleInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_sub_modules', $subModuleInfo);
        return TRUE;
    }

    public function getStudentIntakeYearInfo()
    {
        $this->db->from('tbl_year_info as year');
        $this->db->where('year.is_deleted', 0);
        $this->db->where('year.intake_year_status', 1);
        $this->db->order_by('year.year','desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function getStudentAllYearInfo()
    {
        $this->db->from('tbl_year_info as year');
        $this->db->where('year.is_deleted', 0);
        $this->db->order_by('year.year','desc');
        $query = $this->db->get();
        return $query->result();
    }
}
