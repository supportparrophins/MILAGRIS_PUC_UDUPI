<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class SMS_model extends CI_Model
{

    public function getSMSSentReport($filter) {
        $this->db->select('std.term_name, 
        std.stream_name, 
            std.student_id,
            std.student_name,
            log.application_no,
            log.mobile_number as mobile,
            log.sms_count,
            log.sent_date, 
            log.message, 
            log.status');
        $this->db->from('tbl_student_bulk_sms_log as log');
         $this->db->join('tbl_students_info as std', 'std.row_id = log.application_no','left');
        //$this->db->join('tbl_student_academic_info as acdmic', 'acdmic.application_no = std.application_no','left');
        if(!empty($filter['term_name'])){
            $this->db->where('std.term_name', $filter['term_name']);
        }
        if(!empty($filter['date_search'])){
            $this->db->where('log.sent_date', $filter['date_search']);
        }
        if(!empty($filter['mobile'])){
            $this->db->where('log.mobile_number', $filter['mobile']);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('std.student_id', $filter['student_id']);
        }
        if(!empty($filter['by_name'])){
            $this->db->where('std.student_name', $filter['by_name']);
        }

        if(!empty($filter['by_stream'])){
            $this->db->where('std.stream_name', $filter['by_stream']);
        }

        if(!empty($filter['sms_count'])){
            $this->db->where('log.sms_count', $filter['sms_count']);
        }

        if(!empty($filter['message'])){
            $this->db->where('log.message', $filter['message']);
        }
        //$this->db->where('acdmic.is_deleted', 0);
        $this->db->where('std.is_active', 1);
       // $this->db->where('acdmic.is_current', 1);
        $this->db->where('std.is_deleted', 0);
        $this->db->order_by('log.sent_date','ASC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }

    public function getSMSSentReportCount($filter) {
       
        $this->db->from('tbl_student_bulk_sms_log as log');
        $this->db->join('tbl_students_info as std', 'std.row_id = log.application_no','left');
       // $this->db->join('tbl_student_academic_info as acdmic', 'acdmic.application_no = std.application_no','left');
        if(!empty($filter['term_name'])){
            $this->db->where('std.term_name', $filter['term_name']);
        }
        if(!empty($filter['date_search'])){
            $this->db->where('log.sent_date', $filter['date_search']);
        }
        if(!empty($filter['mobile'])){
            $this->db->where('log.mobile_number', $filter['mobile']);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('std.student_id', $filter['student_id']);
        }
        if(!empty($filter['by_name'])){
            $this->db->where('std.student_name', $filter['by_name']);
        }

        if(!empty($filter['by_stream'])){
            $this->db->where('std.stream_name', $filter['by_stream']);
        }

        if(!empty($filter['sms_count'])){
            $this->db->where('log.sms_count', $filter['sms_count']);
        }

        if(!empty($filter['message'])){
            $this->db->where('log.message', $filter['message']);
        }
       // $this->db->where('acdmic.is_deleted', 0);
        $this->db->where('std.is_active', 1);
        //$this->db->where('acdmic.is_current', 1);
        $this->db->where('std.is_deleted', 0);
        $this->db->order_by('log.sent_date','ASC');
        $query = $this->db->get();
        return $query->num_rows();
    }
    

        public function getMobileNumberForSendBulkSMS($term_name,$stream_name,$mobile_type){
            if($mobile_type == 'onlyStudent'){
                $this->db->select('std.mobile_one as mobile, std.application_no');
                $this->db->from('tbl_student_info as std');
                $this->db->join('tbl_student_academic_info as acdmic', 'acdmic.application_no = std.application_no','left');
             
                if($term_name == 'I PUC'){
                    $this->db->where('acdmic.term_name', 'I PUC');
                    $this->db->where('std.intake_year_id', 2020);
                }else{
                    $this->db->where('acdmic.term_name', 'II PUC');
                    $this->db->where('std.intake_year_id', 2019);
                }
                if($stream_name != 'ALL'){
                    $this->db->where('acdmic.stream_name', $stream_name);
                }
               // $this->db->where('std.mobile_one is NOT NULL', NULL, FALSE);
               
                $this->db->where('std.is_deleted', 0);
                $this->db->group_by('std.mobile_one');
                $query = $this->db->get();
                return $query->result();
            }else{
                $this->db->select('family.mobile_no as mobile, acdmic.application_no');
                $this->db->from('tbl_student_family_info as family');
                $this->db->join('tbl_student_info as std', 'std.application_no = family.application_no','left');
                $this->db->join('tbl_student_academic_info as acdmic', 'acdmic.application_no = family.application_no','left');
                // if($mobile_type == "onlyGuardian"){
                //     $this->db->where('family.relation_type', "GUARDIAN"); 
                // }
                if($term_name == 'I PUC'){
                    $this->db->where('acdmic.term_name', 'I PUC');
                    $this->db->where('std.intake_year_id', 2020);
                }else{
                    $this->db->where('acdmic.term_name', 'II PUC');
                    $this->db->where('std.intake_year_id', 2019);
                }
                if($stream_name != 'ALL'){
                    $this->db->where('acdmic.stream_name', $stream_name);
                }
                //$this->db->where('family.mobile_no!=',"");
                //$this->db->where(array("family.mobile_no!=" => "", "family.mobile_no IS NOT NULL" => null));
               // $this->db->where('std.intake_year_id', 2019);
              
                $this->db->where('acdmic.is_deleted', 0);
               // $this->db->where('std.is_current', 1);
                //$this->db->where('family.mobile_no!=','NULL');
                $this->db->group_by('family.mobile_no');
                $query = $this->db->get();
                
                return $query->result();
            }
        


        }


    // sms template 
    function getSMSTemplates(){
        $this->db->select('template.row_id, template.name');
        $this->db->from('tbl_sms_templates as template');
        $this->db->where('template.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    function getSMSTemplateByID($id){
        $this->db->select('template.row_id, template.linked_header, template.name, template.reg_no, template.content');
        $this->db->from('tbl_sms_templates as template');
        $this->db->where('template.is_deleted', 0);
        $this->db->where('template.row_id', $id);
        return $this->db->get()->row();
    }

    // save sms log
    function saveSMSLog($msg){
        $this->db->trans_start();
        $this->db->insert('tbl_student_bulk_sms_log', $msg);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function totalSMSSentCount() {
        $this->db->select('SUM(sms_count) as total_sent_sms');
        $this->db->from('tbl_student_bulk_sms_log as log');
        $query = $this->db->get();
        return $query->row();
    }
    
       


        public function getNewAdmittedStudentMobileNumber($term_name,$stream_name,$mobile_type){
            $this->db->select('personal.application_number,personal.father_mobile,
            personal.mother_mobile,personal.student_mobile');
            $this->db->from('tbl_student_personal_details as personal');
            $this->db->join('tbl_admission_students_status as application', 'application.application_number = personal.application_number','left');
            $this->db->where('application.application_number !=', "");
            $this->db->where('application.admission_status', 1);
            $this->db->where('application.fee_payment_status', 1);
            $this->db->where('application.is_deleted', 0);
            $this->db->group_by('application.application_number');
            $query = $this->db->get();
            return $query->result();
        }



    public function getStudentInfoForSMS($term_name,$stream_name,$section_name){
        $this->db->select(' std.father_mobile, std.mother_mobile,std.row_id,
        std.stream_name,std.student_name');
        $this->db->from('tbl_students_info as std');
       // $this->db->join('tbl_student_academic_info as acdmic', 'acdmic.application_no = std.application_no','left');
        
        $this->db->where_in('std.term_name', $term_name);
        if($stream_name != 'ALL'){
            $this->db->where_in('std.stream_name', $stream_name);
        }
        
        if($section_name != 'ALL'){
            $this->db->where_in('std.section_name', $section_name);
        }
       // $this->db->where('std.intake_year','2023-24');
        $this->db->where('std.is_active', 1);
       // $this->db->where('acdmic.is_current', 1);
        $this->db->where('std.is_deleted', 0);
       // $this->db->where('acdmic.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
            
    }

    // primary contact info
    public function getParentContactInfo($application_no,$relation_type){
        $this->db->from('tbl_student_family_info as family');
        $this->db->where('family.application_no', $application_no);
        $this->db->where('family.relation_type', $relation_type);
        $this->db->where('family.is_deleted', 0);
        // $this->db->group_by('family.mobile_no');
        $query = $this->db->get();
        return $query->row();
    }

    function getAllStaffInfoForSMSByDepartment($deptID){
        $this->db->select('staff.user_name, 
            staff.type, 
            staff.row_id,
            staff.staff_id,
            staff.mobile');
        $this->db->from('tbl_staff as staff'); 
        if(strtoupper($deptID) != "ALL"){
            $this->db->where('staff.department_id', $deptID);
        }
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    function getAllStudentInfoByGroup($studentID){
        $this->db->select('student.row_id, student.student_name, student.dob, student.gender, student.mobile_one, student.email,
        student.admission_status, student.aided,
        student.blood_group, student.application_no,student.intake_year,academic.student_id,academic.term_name,academic.section_name,
        academic.stream_name,academic.elective_sub,student.nri_status');
        $this->db->from('tbl_student_info as student'); 
        $this->db->join('tbl_student_academic_info as academic', 'academic.application_no = student.application_no');
        $this->db->where_in('academic.student_id', $studentID);
        $this->db->where('student.is_deleted', 0);
        $this->db->where('academic.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getStudentParentsNumberByAppNo($app_no){
        $this->db->from('tbl_student_family_info as family');
        $this->db->where_in('family.application_no', $app_no);
        $this->db->where('family.is_deleted', 0);
        // $this->db->where('std.is_current', 1);
        //$this->db->where('family.mobile_no!=','NULL');
        $this->db->group_by('family.mobile_no');
        $query = $this->db->get();
        return $query->result();
    }

    

    public function getStudentListForSMS($student_id){
        $this->db->select('std.row_id,std.admission_no,std.student_name,std.dob,std.application_no,std.term_name,
        std.stream_name,std.section_name,std.caste,std.father_mobile,std.mother_mobile,
        std.student_id,std.email,std.intake_year,std.permanent_address');
        $this->db->from('tbl_students_info as std');
       // $this->db->join('tbl_student_academic_info as academic','std.application_no = academic.application_no','left');
        $this->db->where_in('std.student_id', $student_id);
        $this->db->where('std.is_active', 1);
        //$this->db->where('academic.is_current', 1);
        //$this->db->where('academic.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
        
    }

    public function smsListingCount($filter) {
        $this->db->from('tbl_sms_group_info as smsInfo');
        $this->db->join('tbl_student_info as student', 'student.row_id = smsInfo.student_row_id');
        $this->db->join('tbl_student_academic_info as academic', 'academic.row_id = smsInfo.student_row_id');
        $this->db->join('tbl_sms_group as sms','sms.row_id = smsInfo.student_row_id','left');
        if(!empty($filter['by_stdId'])) {
            $this->db->where('academic.student_id', $filter['by_stdId']);
        }
        if(!empty($filter['by_name'])) {
            $this->db->where('student.student_name', $filter['by_name']);
        }
        if(!empty($filter['by_term'])) {
            $this->db->where('academic.term_name', $filter['by_term']);
        }
        if(!empty($filter['smsGroupName'])) {
            $this->db->where('sms.sms_name', $filter['smsGroupName']);
        }
        
        
        $this->db->where('student.is_deleted', 0);
        $this->db->where('smsInfo.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function smsListing($filter)  {
        $this->db->select('student.row_id,academic.term_name,academic.student_id,student.student_name,
        smsInfo.student_row_id,smsInfo.row_id as smsInfoId, smsInfo.sms_id,sms.sms_name,sms.row_id as smsId');
        $this->db->from('tbl_sms_group_info as smsInfo');
        $this->db->join('tbl_student_info as student', 'student.row_id = smsInfo.student_row_id');
        $this->db->join('tbl_student_academic_info as academic', 'academic.application_no = student.application_no');
        $this->db->join('tbl_sms_group as sms','sms.row_id = smsInfo.sms_id','left'); 
        if(!empty($filter['by_stdId'])) {
            $this->db->where('academic.student_id', $filter['by_stdId']);
        }
        if(!empty($filter['by_name'])) {
            $this->db->where('student.student_name', $filter['by_name']);
        }
        if(!empty($filter['by_term'])) {
            $this->db->where('academic.term_name', $filter['by_term']);
        }
        if(!empty($filter['smsGroupName'])) {
            $this->db->where('sms.sms_name', $filter['smsGroupName']);
        }
        $this->db->where('student.is_deleted', 0);
        $this->db->where('smsInfo.is_deleted', 0);
        $this->db->where('student.is_active', 1);
        $this->db->order_by('smsInfo.created_date_time', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllSMSName() {
        $this->db->from('tbl_sms_group as sms'); 
        $this->db->group_by('sms_name');
        $this->db->where('sms.is_deleted', 0);
        $this->db->order_by('sms.row_id');
        $query = $this->db->get();
        return $query->result();
    }

    public function studentSMSInfo(){
        $this->db->select('student.row_id,academic.term_name,academic.stream_name,
        academic.student_id,student.student_name');
        $this->db->from('tbl_student_info as student'); 
        $this->db->join('tbl_student_academic_info as academic', 'academic.application_no = student.application_no','left');
        
       $this->db->where('student.is_active', 1);
        $this->db->where('academic.is_current', 1);
        $this->db->where('student.is_deleted', 0);
        $this->db->where('academic.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    function addSms($smsInfo) {
        $this->db->trans_start();
       $this->db->insert('tbl_sms_group_info', $smsInfo);
       $insert_id = $this->db->insert_id();
       $this->db->trans_complete();
       return $insert_id;
   }

    public function updateSmsInfo($smsInfo,$row_id) {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_sms_group_info', $smsInfo);
        return TRUE;
    }

    function addMultipleSmsGroup($smsInfo) {
        $this->db->trans_start();
       $this->db->insert('tbl_sms_group_info', $smsInfo);
       $insert_id = $this->db->insert_id();
       $this->db->trans_complete();
       return $insert_id;
   }

   function addAbsentSMSInfo($absentInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_absent_sms_info', $absentInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function smsAbsentListingCount($filter) {
        $this->db->from('tbl_absent_sms_info as absentInfo');
        $this->db->join('tbl_student_academic_info as academic', 'academic.student_id = absentInfo.student_id');
        $this->db->join('tbl_student_info as student', 'student.row_id = academic.row_id');
        
        if(!empty($filter['student_id'])) {
            $this->db->where('absentInfo.student_id', $filter['student_id']);
        }
        if(!empty($filter['by_name'])) {
            $likeCriteria = "(student.student_name  LIKE '%" . $filter['by_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_term'])) {
            $this->db->where('academic.term_name', $filter['by_term']);
        }
        if(!empty($filter['by_date'])) {
            $this->db->where('absentInfo.date', $filter['by_date']);
        }
        if(!empty($filter['by_session'])) {
            $this->db->where('absentInfo.session_type', $filter['by_session']);
        }

        if(!empty($filter['by_stream'])) {
            $this->db->where('academic.stream_name', $filter['by_stream']);
        }
        
        $this->db->where('academic.is_deleted', 0);
        $this->db->where('student.is_deleted', 0);
        $this->db->where('absentInfo.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function smsAbsentListing($filter)  {
        $this->db->select('student.row_id,academic.term_name,student.student_name,academic.stream_name,
        absentInfo.student_id,absentInfo.date,absentInfo.session_type');
        $this->db->from('tbl_absent_sms_info as absentInfo');
        $this->db->join('tbl_student_academic_info as academic', 'academic.student_id = absentInfo.student_id');
        $this->db->join('tbl_student_info as student', 'student.row_id = academic.row_id');
        
        if(!empty($filter['student_id'])) {
            $this->db->where('absentInfo.student_id', $filter['student_id']);
        }
        if(!empty($filter['by_name'])) {
            $likeCriteria = "(student.student_name  LIKE '%" . $filter['by_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_term'])) {
            $this->db->where('academic.term_name', $filter['by_term']);
        }
        if(!empty($filter['by_stream'])) {
            $this->db->where('academic.stream_name', $filter['by_stream']);
        }
        if(!empty($filter['by_date'])) {
            $this->db->where('absentInfo.date', $filter['by_date']);
        }
        if(!empty($filter['by_session'])) {
            $this->db->where('absentInfo.session_type', $filter['by_session']);
        }
        
        $this->db->where('academic.is_deleted', 0);
        $this->db->where('student.is_deleted', 0);
        $this->db->where('absentInfo.is_deleted', 0);
        $this->db->where('student.is_active', 1);
        $this->db->order_by('absentInfo.created_date_time', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }

    public function updateAbsentSmsInfo($absentSmsInfo,$row_id) {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_absent_sms_info', $absentSmsInfo);
        return TRUE;
    }

    public function getSMSReport($filter = '') {
        $this->db->select('acdmic.term_name, 
            acdmic.stream_name, 
            acdmic.student_id,
            std.student_name,
            log.application_no,
            log.mobile_number as mobile,
            log.sms_count,
            log.sent_date, 
            log.message, 
            log.status');
        $this->db->from('tbl_student_bulk_sms_log as log');
        $this->db->join('tbl_student_info as std', 'std.application_no = log.application_no','left');
        $this->db->join('tbl_student_academic_info as acdmic', 'acdmic.application_no = std.application_no','left');
        if (!empty($filter['date_from'])) {
            $this->db->where('log.sent_date >=', $filter['date_from']);
        }
        if (!empty($filter['date_to'])) {
            $this->db->where('log.sent_date <=', $filter['date_to']);
        }
        $this->db->where('std.is_deleted', 0);
        $this->db->where('acdmic.is_active', 1);
        $this->db->where('acdmic.is_current', 1);
        $this->db->where('acdmic.is_deleted', 0);
        $this->db->order_by('log.sent_date','ASC');
        $query = $this->db->get();
        return $query->result();

        // $this->db->select('personal.application_number,personal.father_mobile,
        // personal.mother_mobile,personal.student_mobile,language.stream_name,log.application_no,
        // log.mobile_number as mobile,
        // log.sms_count,
        // log.sent_date, 
        // log.message, 
        // log.status');
        // $this->db->from('tbl_student_bulk_sms_log as log');
        // $this->db->from('tbl_admission_student_personal_details_temp as personal','personal.application_number = log.application_no','left');
        // $this->db->join('tbl_admission_combination_language_opted_temp as language', 'language.registred_row_id = personal.resgisted_tbl_row_id','left');
        // if (!empty($filter['date_from'])) {
        //     $this->db->where('log.sent_date >=', $filter['date_from']);
        // }
        // if (!empty($filter['date_to'])) {
        //     $this->db->where('log.sent_date <=', $filter['date_to']);
        // }
        
        // $this->db->order_by('log.sent_date','ASC');
        // $query = $this->db->get();
        // return $query->result();
    }

    public function getSMSListReport($filter = '') {
        $this->db->select('log.application_no,
            log.mobile_number as mobile,
            log.sms_count,
            log.sent_date, 
            log.message, 
            log.status');
        $this->db->from('tbl_student_bulk_sms_log as log');
        
        if (!empty($filter['date_from'])) {
            $this->db->where('log.sent_date >=', $filter['date_from']);
        }
        if (!empty($filter['date_to'])) {
            $this->db->where('log.sent_date <=', $filter['date_to']);
        }
        $this->db->where('log.application_no', ' ');
        $this->db->order_by('log.sent_date','ASC');
        $query = $this->db->get();
        return $query->result();

    
    }

    // function isSMSAlreadyAdded($date,$sub_code,$student_id,$subject_type){
    //     $this->db->from('tbl_absent_sms_info as ab');
    //     $this->db->where('ab.date', $date);
    //     $this->db->where('ab.subject_code', $sub_code);
    //     $this->db->where('ab.student_id', $student_id);
    //     $this->db->where('ab.subject_type', $subject_type);
    //     $this->db->where('ab.is_deleted', 0);
    //     $query = $this->db->get();
    //     return $query->row();
    // }
    function isSMSAlreadyAdded($student_id,$class_row_id){
        $this->db->from('tbl_absent_sms_info as ab');
        $this->db->where('ab.student_id', $student_id);
        $this->db->where('ab.class_row_id', $class_row_id);
        $this->db->where('ab.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    
}
?>