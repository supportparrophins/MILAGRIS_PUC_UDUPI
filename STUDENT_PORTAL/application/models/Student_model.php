<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Student_model extends CI_Model
{
    public function getStudentInfoById($student_id,$term_name){
        $this->db->from('tbl_students_info as std');
        $this->db->where('std.student_id', $student_id);
        $this->db->where('std.term_name', $term_name);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getStudentAppInfoById($student_id,$term_name){
        $this->db->from('tbl_student_app_registration as student');
        $this->db->where('student.student_id', $student_id);
        // $this->db->where('student.profile_update_status', 0);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function updateOtp($student_id, $usersData)
    {
        $this->db->where('is_deleted', 0);
        $this->db->group_start();
        $this->db->where('father_mobile',$student_id);
        $this->db->or_where('mother_mobile',$student_id);
        $this->db->group_end();
        $this->db->update('tbl_students_info', $usersData);
        return $this->db->affected_rows();
    }

    function checkOtpIsExist($mbl,$otp) {
        $this->db->from('tbl_students_info as student'); 
        $this->db->where('student.is_deleted', 0);
        $this->db->group_start();
        $this->db->where('student.father_mobile',$mbl);
        $this->db->or_where('student.mother_mobile',$mbl);
        $this->db->group_end();
        $this->db->where('student.last_otp',$otp);
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * This function is used to match student password for change password
     * @param number $row_id : This is row id
     */
    function matchOldPassword($student_id, $oldPassword)
    {
        $this->db->select('student_id, password');
        $this->db->where('student_id', $student_id);        
        $this->db->where('is_deleted', 0);
        $query = $this->db->get('tbl_students_info');
        
        $user = $query->result();

        if(!empty($user)){
            if(verifyHashedPassword($oldPassword, $user[0]->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
    /**
     * This function is used to change student password
     * @param number $row_id : This is row id
     * @param array $studentInfo : This is user updation info
     */
    function changePassword($student_id, $usersData)
    {
        $this->db->where('student_id', $student_id);
        $this->db->where('is_deleted', 0);
        $this->db->update('tbl_students_info', $usersData);
        return $this->db->affected_rows();
    }

    public function sendFeedbackMessage($feedbackMessage){
        $this->db->trans_start();
        $this->db->insert('tbl_student_feedback_for_management', $feedbackMessage);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getStudentNotification($student_id,$date){
        $date = date('Y-m-d');
        $this->db->from('tbl_student_bulk_sms_log as notify');
        $this->db->where('notify.student_id', $student_id);
        $this->db->where('notify.date_time',$date);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

     // function to get attendance info
     public function getAttendanceReport($filter){
        // $this->db->select('attendance.absent_date,sub.name as sub_name,time.start_time,time.end_time');
        $this->db->from('tbl_student_attendance_details as attendance');
        $this->db->join('tbl_subjects as sub','sub.subject_code = attendance.subject_code');
        $this->db->join('tbl_class_timings as time','time.row_id = attendance.time_row_id');
        $this->db->where('attendance.student_id', $filter['student_id']);
        if(!empty($filter['date'])){
            $this->db->where('attendance.absent_date', $filter['date']);
        }
        if(!empty($filter['sub_code'])){
            $this->db->where('attendance.subject_code', $filter['sub_code']);
        }
        if(!empty($filter['time_id'])){
            $this->db->where('attendance.time_row_id', $filter['time_id']);
        }
        $this->db->where('attendance.is_deleted',0);
        // $this->db->where('attendance.office_verified_status',1);
        $this->db->order_by('attendance.absent_date', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    // function to get attendance count 
    public function getAttendanceReportCount($filter){
        // $this->db->select('attendance.absent_date,sub.name as sub_name,time.start_time,time.end_time');
        $this->db->from('tbl_student_attendance_details as attendance');
        $this->db->join('tbl_subjects as sub','sub.subject_code = attendance.subject_code');
        $this->db->join('tbl_class_timings as time','time.row_id = attendance.time_row_id');
        $this->db->where('attendance.student_id', $filter['student_id']);
        if(!empty($filter['date'])){
            $this->db->where('attendance.absent_date', $filter['date']);
        }
        if(!empty($filter['sub_code'])){
            $this->db->where('attendance.subject_code', $filter['sub_code']);
        }
        if(!empty($filter['time_id'])){
            $this->db->where('attendance.time_row_id', $filter['time_id']);
        }
        $this->db->where('attendance.is_deleted',0);
        // $this->db->where('attendance.office_verified_status',1);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    // getting student subjects
    public function getStudentSubjectInfo($subject_code){
        $this->db->from('tbl_subjects as sub');
        $this->db->where_in('sub.subject_code', $subject_code);
        $this->db->where('sub.is_deleted',0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    // getting student subjects
    public function getStudentSubject(){
        $this->db->from('tbl_subjects as sub');
        // $this->db->where_in('sub.subject_code', $subject_code);
        $this->db->where('sub.is_deleted',0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    // getting class time
    public function getAllTimeInfo(){
        $this->db->from('tbl_class_timings_info as time');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    public function getGalleryInfo(){
        $this->db->from('tbl_gallery_info as gallery');
        $this->db->where('gallery.is_deleted',0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function galleryInfoImages($row_id){
        $this->db->from('tbl_photo_gallery as gallery');
        $this->db->where('gallery.is_deleted',0);
        $this->db->where('gallery.photo_id',$row_id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;

    }



    // getting class student late days
    public function getLateComerReport($filter){
        $this->db->from('tbl_latecomer_info as late');
        $this->db->where('late.student_id', $filter['student_id']);
        if(!empty($filter['date'])){
            $this->db->where('late.date', $filter['date']);
        }
        $this->db->where('late.is_deleted',0);
        $this->db->order_by('late.date', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    // getting class student late days count pagination
    public function getLateComerReportCount($filter){
        $this->db->from('tbl_latecomer_info as late');
        $this->db->where('late.student_id', $filter['student_id']);
        if(!empty($filter['date'])){
            $this->db->where('late.date', $filter['date']);
        }
        $this->db->where('late.is_deleted',0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    // getting class student notification date and message
    public function getNotificationReport($filter){
        $this->db->from('tbl_student_bulk_sms_log as msg');
        $this->db->where('msg.student_id', $filter['student_id']);
        if(!empty($filter['date'])){
            
            $this->db->where("msg.date_time LIKE '%".$filter['date']."%'");
        }
        $this->db->order_by('msg.date_time', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    // getting class student notification count
    public function getNotificationReportCount($filter){
        $this->db->from('tbl_student_bulk_sms_log as msg');
        $this->db->where('msg.student_id', $filter['student_id']);
        if(!empty($filter['date'])){
            
            $this->db->where("msg.date_time LIKE '%".$filter['date']."%'");
        }
        $this->db->order_by('msg.date_time', 'DESC');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getSuggestionInfoById($student_id){
        $this->db->from('tbl_student_feedback_for_management as feedback');
        $this->db->where('feedback.student_id', $student_id);
        $this->db->where('feedback.is_deleted', 0);
        $this->db->where('feedback.status', 0);
        $query = $this->db->get();
        return $query->result();
    }

    // suggestion page  
    function suggestionToDB($suggestionInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_student_feedback_for_management', $suggestionInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    
    
    function addFamilyInfo($familyInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_student_family_info', $familyInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    } 

    function addSiblingInfo($sibInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_studnts_siblings_info', $sibInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    } 

    function updateStudentInfoStatus($student_id, $usersData)
    {
        $this->db->where('student_id', $student_id);
        $this->db->update('tbl_student_app_registration', $usersData);
        return $this->db->affected_rows();
    }

    public function getWorldlinePaymentLogByStudentId($student_id){
        $this->db->from('tbl_worldline_payment_log as fee');
        $this->db->where('fee.student_id', $student_id);
        $this->db->where('fee.payment_status', 'SUCCESS');
        $this->db->where('fee.remarks !=', 'SJPUC Supplementary Exam Fee - 2020');
        
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function getOnlineClassCredentialsInfo($student_id){
        $this->db->from('db_online_class_credentials');
        $this->db->where('student_id', $student_id);
        $query = $this->db->get();
        return $query->row();
    }

// function to get attendance info
public function supplyStudentInfo($filter){
    $this->db->select('supp.student_id,
    supp.supply_fee,
    std.student_name,
    std.stream_name,
    std.section_name,
    std.pu_board_number,
    supp.row_id,
    ');
    $this->db->from('tbl_supplementary_students_info as supp');
    $this->db->join('tbl_first_puc_students_info as std','std.student_id = supp.student_id');
    //$this->db->join('tbl_class_timings_info as time','time.row_id = attendance.time_row_id');
    $this->db->where('supp.student_id', $filter['student_id']);
    $this->db->where('supp.payment_status', 0);

    
    $this->db->where('std.is_deleted', 0);
    $query = $this->db->get();
    $result = $query->row();
    return $result;
}
   

function updateStudentSupplyInfo($row_id, $info)
{
    $this->db->where('row_id', $row_id);
    $this->db->update('tbl_supplementary_students_info', $info);
    return $this->db->affected_rows();
}

// function to get attendance info
public function getSupplyStudentInfoByStatus($filter){
    $this->db->select('supp.student_id,
    supp.supply_fee,
    std.student_name,
    std.stream_name,
    std.section_name,
    std.pu_board_number,
    supp.row_id,
    supp.payment_status,
    ');
    $this->db->from('tbl_supplementary_students_info as supp');
    $this->db->join('tbl_first_puc_students_info as std','std.student_id = supp.student_id');
    //$this->db->join('tbl_class_timings_info as time','time.row_id = attendance.time_row_id');
    $this->db->where('supp.student_id', $filter['student_id']);
    $this->db->where('std.is_deleted', 0);
    $query = $this->db->get();
    $result = $query->row();
    return $result;
}



// public function addMunFeePaymentLog($paymentInfo){
//     $this->db->trans_start();
//     $this->db->insert('tbl_paytm_mun_registration_fee_payment_log', $paymentInfo);
//     $insert_id = $this->db->insert_id(); 
//     $this->db->trans_complete();
//     return $insert_id; 
// }

//  // add from excel
//  public function updateMunPaymentLog($paymentInfo,$row_id) {
//     $this->db->where('row_id', $row_id);
//     $this->db->update('tbl_paytm_mun_registration_fee_payment_log',$paymentInfo);
//     return TRUE;
// }

//  // add from excel
//  public function updateMunPaymentLogByOrderId($paymentInfo,$order_id) {
//     $this->db->where('order_id', $order_id);
//     $this->db->update('tbl_paytm_mun_registration_fee_payment_log',$paymentInfo);
//     return TRUE;
// }
// public function getAllFeeMunPaymentLogByApplicationNo($student_id){
//     $this->db->from('tbl_paytm_mun_registration_fee_payment_log as fee');
//     $this->db->where('student_id', $student_id);
//     $this->db->where('is_deleted', 0);
//     $query = $this->db->get();
//     return $query->result();
// }

public function getInfoMUN_Register($student_id){
    $this->db->from('tbl_mun_internal_students_reg as mun');
    $this->db->where('mun.student_id', $student_id);

    $this->db->where('mun.is_deleted', 0);
    $query = $this->db->get();
    return $query->row();
}

public function addMunRegister($stdInfo){
    $this->db->trans_start();
    $this->db->insert('tbl_mun_internal_students_reg', $stdInfo);
    $insert_id = $this->db->insert_id(); 
    $this->db->trans_complete();
    return $insert_id; 
}

// public function updateMunRegister($stdInfo,$student_id) {
//     $this->db->where('student_id', $student_id);
//     $this->db->update('tbl_mun_internal_students_reg',$stdInfo);
//     return TRUE;
// }








public function addRGDFeePaymentLog($paymentInfo){
    $this->db->trans_start();
    $this->db->insert('tbl_paytm_rgd_registration_fee_payment_log', $paymentInfo);
    $insert_id = $this->db->insert_id(); 
    $this->db->trans_complete();
    return $insert_id; 
}

 // add from excel
 public function updateRGDPaymentLog($paymentInfo,$row_id) {
    $this->db->where('row_id', $row_id);
    $this->db->update('tbl_paytm_rgd_registration_fee_payment_log',$paymentInfo);
    return TRUE;
}

 // add from excel
 public function updateRGDPaymentLogByOrderId($paymentInfo,$order_id) {
    $this->db->where('order_id', $order_id);
    $this->db->update('tbl_paytm_rgd_registration_fee_payment_log',$paymentInfo);
    return TRUE;
}
public function getAllFeeRGDPaymentLogByApplicationNo($student_id){
    $this->db->from('tbl_paytm_rgd_registration_fee_payment_log as fee');
    $this->db->where('student_id', $student_id);
    $this->db->where('is_deleted', 0);
    $query = $this->db->get();
    return $query->result();
}

public function getInfoRGD_Register($student_id){
    $this->db->from('tbl_rgd_internal_students_reg as rgd');
    $this->db->where('rgd.student_id', $student_id);

    $this->db->where('rgd.is_deleted', 0);
    $query = $this->db->get();
    return $query->row();
}

public function addRGDRegister($stdInfo){
    $this->db->trans_start();
    $this->db->insert('tbl_rgd_internal_students_reg', $stdInfo);
    $insert_id = $this->db->insert_id(); 
    $this->db->trans_complete();
    return $insert_id; 
}

public function updateRGDRegister($stdInfo,$student_id) {
    $this->db->where('student_id', $student_id);
    $this->db->update('tbl_rgd_internal_students_reg',$stdInfo);
    return TRUE;
}


//admission project model

public function getStudentStudentInfo($registered_row_id){
    $this->db->select('personal.application_number,
    personal.name as student_name,
    personal.caste,
    personal.father_name,
    personal.father_mobile,
    personal.mother_name,
    personal.mother_mobile,
    language.stream_name,
    language.second_language as elective_sub,
    application.admission_status,
    application.student_category,
    doc.doc_path,
    application.sslc_percentage');
    $this->db->from('tbl_admission_student_personal_details_temp as personal');
    $this->db->join('tbl_admission_combination_language_opted_temp as language', 'language.registred_row_id = personal.resgisted_tbl_row_id','left');
    $this->db->join('tbl_admission_students_status_temp as application', 'application.application_number = personal.application_number','left');
    $this->db->join('tbl_admission_document_details_temp as doc', 'doc.registred_row_id = personal.resgisted_tbl_row_id','left');
    $this->db->where('application.registered_row_id', $registered_row_id);
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

// check admission status
public function checkStudentAdmissionStatus($registered_row_id){
    $this->db->from('tbl_admission_students_status_temp as std');
    $this->db->where('std.registered_row_id', $registered_row_id);
    $this->db->where('std.is_deleted', 0);
    $query = $this->db->get();
    return $query->row();
}
function updateStudentApplicationStatus($registered_row_id,$applicationStatus){
    $this->db->where('registered_row_id', $registered_row_id);
    $this->db->update('tbl_admission_students_status_temp', $applicationStatus);
    return $this->db->affected_rows();
}

function getStudentMarksSheetByStudentId($student_id){
    $this->db->from('tbl_students_info as std');
    $this->db->where_in('std.student_id', $student_id);
    $this->db->where('std.is_deleted', 0);
    $query = $this->db->get();
    $result = $query->row();        
    return $result;
}

public function getStudentInfoByStudentId($student_id){
    $this->db->from('tbl_students_info as std');
    $this->db->where('std.row_id', $student_id);
    $this->db->where('std.is_deleted', 0);
    $this->db->where('std.is_active', 1);
    $query = $this->db->get();
    return $query->row();
}




public function getStudentLateInfo($student_id){
    $this->db->from('tbl_latecomer_info as late');
    $this->db->where('late.student_id', $student_id);
    $this->db->where('late.is_deleted', 0);
    $query = $this->db->get();
    return $query->result();
}



public function addCourseRegistrationFeePaymentLog($paymentInfo){
    $this->db->trans_start();
    $this->db->insert('tbl_paytm_course_registration_fee_payment_log', $paymentInfo);
    $insert_id = $this->db->insert_id(); 
    $this->db->trans_complete();
    return $insert_id; 
}

public function updateCoursePaymentLogByRowId($paymentInfo,$order_id) {
        $this->db->where('row_id', $order_id);
        $this->db->update('tbl_paytm_course_registration_fee_payment_log',$paymentInfo);
        return TRUE;
    }

    public function updateCoursePaymentLogByOrderId($paymentInfo,$order_id) {
        $this->db->where('order_id', $order_id);
        $this->db->update('tbl_paytm_course_registration_fee_payment_log',$paymentInfo);
        return TRUE;
    }


    public function getInfoCourse_Register($student_id,$course_name){
        $this->db->from('tbl_course_students_reg as course');
        $this->db->where('course.student_id', $student_id);
        $this->db->where('course.course_name', $course_name);
        $this->db->where('course.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function addCourseRegister($stdInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_course_students_reg', $stdInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }

    public function updateCourseRegister($stdInfo,$student_id,$course) {
            $this->db->where('student_id', $student_id);
            $this->db->where('course_name', $course);
            $this->db->update('tbl_course_students_reg',$stdInfo);
            return TRUE;
        }

        public function getAllCourseRegisterInfo($student_id){
            $this->db->from('tbl_course_students_reg as course');
            $this->db->where('course.student_id', $student_id);
            $this->db->where('course.is_deleted', 0);
            $query = $this->db->get();
            return $query->result();
        }


          public function getAllFeeCoursePaymentLogByStudentId($student_id){
          $this->db->from('tbl_paytm_course_registration_fee_payment_log as fee');
          $this->db->where('student_id', $student_id);
          $this->db->where('is_deleted', 0);
          $query = $this->db->get();
          return $query->result();
        }

        public function getStudentNotifications($term_name,$section_name,$stream_name){
            $this->db->from('tbl_student_notifications as notification');
            if(!empty($term_name)){
                $this->db->where_in('notification.term_name',array($term_name,"ALL"));
            }else{
                $this->db->where('notification.term_name',"ALL");
            }
            if(!empty($stream_name)){
                $this->db->where_in('notification.stream_name',array($stream_name,"ALL"));
            }else{
                $this->db->where('notification.stream_name',"ALL");
            }
            if(!empty($section_name)){
                $this->db->where_in('notification.section_name',array($section_name,"ALL"));
            }else{
                $this->db->where('notification.section_name',"ALL");
            }
            $this->db->where('notification.is_deleted', 0);
            $this->db->order_by("date_time","DESC");
            $this->db->limit(50);
            $query = $this->db->get(); 
            return $query->result();
        }

        public function getStudentfeedNotifications($term_name,$section_name,$stream_name){
            $this->db->from('tbl_student_notifications as notification');
            if(!empty($term_name)){
                $this->db->where_in('notification.term_name',array($term_name,"ALL"));
            }else{
                $this->db->where('notification.term_name',"ALL");
            }
            if(!empty($stream_name)){
                $this->db->where_in('notification.stream_name',array($stream_name,"ALL"));
            }else{
                $this->db->where('notification.stream_name',"ALL");
            }
            if(!empty($section_name)){
                $this->db->where_in('notification.section_name',array($section_name,"ALL",''));
            }else{
                $this->db->where('notification.section_name',"ALL");
            }
            $this->db->where('notification.is_deleted', 0);
            $this->db->where('DATE(notification.date_time)',date('Y-m-d'));
            $this->db->order_by("date_time","DESC");
            $query = $this->db->get(); 
            return $query->result();
        }


        public function updateSuggestionInfoById($row_id,$data){
            $this->db->where('row_id', $row_id);
            $this->db->where('is_deleted', 0);
            $this->db->update('tbl_student_feedback_for_management', $data);
            return $this->db->affected_rows();
        }

        

        public function getStudentInfoByRowId($row_id){
            $this->db->from('tbl_students_info as std');
            $this->db->where('std.row_id', $row_id);
            $this->db->where('std.is_deleted', 0);
            $this->db->where('std.is_active', 1);
            $query = $this->db->get();
            return $query->row();
        }
        public function getStudentsInfoById($row_id,$term_name){
            $this->db->select('student.row_id,student.blood_group,student.student_no,student.application_no,student.register_no, 
            student.student_id,student.hall_ticket_no,student.student_name,student.elective_sub,student.dob,student.mobile,student.email,
            student.date_of_admission,student.roll_number,student.gender,student.student_status,student.residential_address,student.nationality,student.mother_educational_qualification,student.mother_annual_income,
            student.pu_board_number,student.category,student.last_board_name,student.present_address,student.permanent_address,student.religion,student.father_email,student.mother_profession,student.mother_email,
            student.father_name,student.father_mobile,student.mother_name,student.mother_mobile,student.program_name,student.stream_name,student.father_profession,student.father_annual_income,
            student.route_id,route.row_id as route_row_id,route.name as route_name,route.rate,route.bus_no,student.caste,student.sub_caste,student.mother_tongue,student.is_dyslexic,student.father_educational_qualification,
            student.intake_year,student.term_name,student.section_name');
            $this->db->from('tbl_students_info as student'); 
            if($term_name=='I PUC'){
                $this->db->join('tbl_student_transport_rate_info as route', 'route.row_id = student.route_id','left');
            }else{
                $this->db->join('tbl_student_transport_rate_info as route', 'route.row_id = student.route_id_II','left');
            }
            $this->db->where('student.row_id', $row_id);
            $this->db->where('student.is_deleted', 0);
            $query = $this->db->get();
            return $query->row();
        }
        public function getTransportFeefromStructure($id){
            $this->db->from('tbl_student_transport_fee_structure as fee');
            $this->db->where('fee.is_deleted', 0);
            $this->db->where('fee.pickup_point_id',$id);
            $this->db->where('fee.year',CURRENT_YEAR);
            $query = $this->db->get();
            return $query->row();
        }
        public function getTransportTotalPaidAmount($stud_id,$year){
            $this->db->select('SUM(fee.bus_fees) as paid_amount');
            $this->db->from('tbl_student_bus_management_details as fee');
            $this->db->where('fee.is_deleted', 0);
            $this->db->where('fee.student_id', $stud_id);
            $this->db->where('fee.intake_year',$year);
            $query = $this->db->get();
            return $query->row();
        }
        public function getFeeConcessionInfo($student_row_id,$year){
            $this->db->select('SUM(fee.fee_amt) as fee_amt');
            $this->db->from('tbl_student_bus_fee_concession as fee');
            $this->db->where('fee.student_id', $student_row_id);
            $this->db->where('fee.con_year', $year);
            $this->db->where('fee.is_deleted', 0);
            $this->db->where('fee.approved_status', 1);
            $query = $this->db->get();
            return $query->row();
        }
        public function getStudentOverallTransFeePaymentInfo($stud_id,$year){
            $this->db->from('tbl_student_bus_management_details as fee');
            $this->db->where('fee.is_deleted', 0);
            $this->db->where('fee.student_id', $stud_id);
            $this->db->where('fee.intake_year',$year);
            $query = $this->db->get();
            return $query->result();
        }
        public function getStudentYearWise($stud_id){
            $this->db->from('tbl_student_class_year_wise as year');
            $this->db->where('year.is_deleted', 0);
            $this->db->where('year.stud_row_id', $stud_id);
            $this->db->where('year.intake_year',CURRENT_YEAR);
            $query = $this->db->get();
            return $query->row();
        }
        // public function getStudentOverallTransFeePaymentInfo($stud_id,$year){
        //     $this->db->from('tbl_student_bus_management_details as fee');
        //     $this->db->where('fee.is_deleted', 0);
        //     $this->db->where('fee.student_id', $stud_id);
        //     $this->db->where('fee.intake_year',$year);
        //     $query = $this->db->get();
        //     return $query->result();
        // }
        public function getStudentTransportInfoById($row_id) {
            $this->db->select('stdbus.row_id, stdbus.bus_number,student.intake_year_id,student.route_id,student.route_id_II,end_route.name as bus_no, stdbus.receipt_no,stdbus.payment_date, stdbus.bus_fees, stdbus.route_from,student.admission_no,stdbus.upi_ref_no,stdbus.transaction_number,stdbus.dd_number,student.register_no,student.application_no,stdbus.ref_receipt_no,stdbus.month,
            stdbus.route_to, stdbus.from_date, stdbus.to_date, bus.vehicle_number,student.row_id as std_row_id,student.sat_number,student.student_name,student.father_name,stdbus.intake_year,stdbus.payment_type,stdbus.payment_status,stdbus.term_name,stdbus.created_date_time,student.student_id,rate.name as route_name');
            $this->db->from('tbl_student_bus_management_details as stdbus');
            $this->db->join('tbl_bus_management_details as bus', 'bus.vehicle_number = stdbus.bus_number','left');
            $this->db->join('tbl_students_info as student', 'student.row_id = stdbus.student_id','left');
            $this->db->join('tbl_student_transport_rate_info as rate', 'rate.row_id = student.route_id','left');
            $this->db->join('tbl_end_route_info as end_route', 'end_route.row_id = rate.route_id','left');
            $this->db->where('stdbus.row_id', $row_id);
            $this->db->where('stdbus.is_deleted', 0);
            $query = $this->db->get();
            return $query->row();
        }
        public function getStudentTransportRateInfo($pickup_point_id,$year) {

            $this->db->select('fee.row_id,route.name as route_name,pickup_point.name as pickup_point_name,fee.rate,fee.year');
            $this->db->from('tbl_end_route_info as route');
            $this->db->join('tbl_student_transport_rate_info as pickup_point', 'route.row_id = pickup_point.route_id','left');
            $this->db->join('tbl_student_transport_fee_structure as fee', 'pickup_point.row_id = fee.pickup_point_id','left');
            $this->db->where('route.is_deleted', 0);
            $this->db->where('fee.is_deleted', 0);
            $this->db->where('fee.year', $year);
            $this->db->where('pickup_point.row_id', $pickup_point_id);
            $this->db->where('pickup_point.is_deleted', 0);
            $query = $this->db->get();
            return $query->row();
        }
        public function getHolidayInfo(){
            $this->db->select('holiday.reason as title,holiday.holiday_date as start,holiday.holiday_date_to  as  end,holiday.students_status as all_day ');
            $this->db->from('tbl_college_holiday_info as holiday');
            $this->db->where('holiday.students_status',1);
            $this->db->where('holiday.is_deleted',0);
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }

        public function getswitchMobile($row_id,$mobile_no){
            $this->db->select('stud.student_id,stud.student_name,stud.term_name,stud.section_name,stud.row_id');
            $this->db->from('tbl_students_info as stud');
            $this->db->where('stud.is_deleted', 0);
            $this->db->where('stud.row_id!=',$row_id);
            $this->db->group_start();
            $this->db->where('stud.father_mobile',$mobile_no);
            $this->db->or_where('stud.mother_mobile',$mobile_no);
            $this->db->group_end();
            $query = $this->db->get();
            return $query->result();
        }

        public function getStudentInfoByRowIdApp($row_id){
            $this->db->from('tbl_students_info as std');
            $this->db->group_start();
            $this->db->where('std.father_mobile',$row_id);
            $this->db->or_where('std.mother_mobile',$row_id);
            $this->db->or_where('std.row_id', $row_id); 
            $this->db->group_end();
            $this->db->where('std.is_deleted', 0);
            $this->db->where('std.is_active', 1);
            $query = $this->db->get();
            return $query->row();
        }

        function updateRegistration($student_id,$info){
            $this->db->where("student_id", $student_id); 
            $this->db->update("tbl_student_app_registration", $info);
            return 1;
        }

        public function getEvents(){
            $this->db->from('tbl_website_event as event');
            $this->db->where('event.is_deleted',0);
            $this->db->where('event.date >=',date('Y-m-d'));
            $this->db->order_by('event.date', 'DESC');
            $this->db->where('event.status',0);
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }

        public function getCalender(){
            $this->db->from('tbl_calendar_event_manager as calender');
            $this->db->where('calender.is_deleted',0);
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }

        public function getabsentDetails($student_id){
            $this->db->select('attendance.absent_date,sub.name as sub_name,time.start_time,time.end_time');
            $this->db->from('tbl_student_attendance_details as attendance');
            $this->db->join('tbl_subjects as sub','sub.subject_code = attendance.subject_code');
            $this->db->join('tbl_class_timings as time','time.row_id = attendance.time_row_id');
            $this->db->where('attendance.student_id', $student_id);
            $this->db->where('attendance.year',CURRENT_YEAR);
            $this->db->where('attendance.is_deleted',0);
            // $this->db->where('attendance.office_verified_status',1);
            $this->db->order_by('attendance.absent_date', 'DESC');
            $query = $this->db->get();
            $result = $query->result() ;
            return $result;
        }

        public function getabsentfeedDetails($student_id){
            $this->db->select('attendance.absent_date,sub.name,time.start_time,time.end_time');
            $this->db->from('tbl_student_attendance_details as attendance');
            $this->db->join('tbl_subjects as sub','sub.subject_code = attendance.subject_code');
            $this->db->join('tbl_class_timings as time','time.row_id = attendance.time_row_id');
            $this->db->where('attendance.student_id', $student_id);
            $this->db->where('attendance.year',CURRENT_YEAR);
            $this->db->where('attendance.is_deleted',0);
            // $this->db->where('attendance.office_verified_status',1);
            $this->db->where('DATE(attendance.absent_date)',date('Y-m-d'));
            $this->db->order_by('attendance.absent_date', 'DESC');
            $query = $this->db->get();
            $result = $query->result() ;
            return $result;
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

     // dashboard news feed
     public function getNewsFeed($filter) {
        $this->db->select('news.row_id,news.subject,news.description,news.term_name,news.date,news.stream_name,
        news.photo_url');
        $this->db->from('tbl_news_feed as news'); 
        $this->db->join('tbl_news_feed_role_mngt as role', 'role.rel_news_row_id = news.row_id','right');
        if(!empty($filter['term_name'])){
            $this->db->where_in('news.term_name',array($filter['term_name'], '','ALL'));
        }
        if(!empty($filter['role']) || !empty($filter['role_one'])){
            $this->db->where_in('role.visible_type',array($filter['role'], $filter['role_one']));
        }
        $this->db->where('news.is_deleted', 0);
        $this->db->where('role.is_deleted', 0);
        $this->db->order_by('news.date', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        //return $this->db->last_query();
        return $query->result();
    }
    public function getNewsFeedApi($filter) {
        $this->db->select('news.row_id,news.subject,news.description,news.term_name,news.date,news.stream_name,
        news.photo_url');
        $this->db->from('tbl_news_feed as news'); 
        $this->db->join('tbl_news_feed_role_mngt as role', 'role.rel_news_row_id = news.row_id','right');
        if(!empty($filter['term_name'])){
            $this->db->where_in('news.term_name',array($filter['term_name'], '','ALL'));
        }
        if(!empty($filter['role']) || !empty($filter['role_one'])){
            $this->db->where_in('role.visible_type',array($filter['role'], $filter['role_one']));
        }
        $this->db->where('news.is_deleted', 0);
        $this->db->where('role.is_deleted', 0);
        $this->db->order_by('news.date', 'DESC');
        // $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        //return $this->db->last_query();
        return $query->result();
    }

    public function deleteToken($id){
        $this->db->where('device_id', $id);
        $this->db->delete('tbl_token');
        return true;
    }

    // get first internal exam mark
    public function getFirstInternaltMark($student_id,$subjects_code){
        $this->db->select('exam.student_id,exam.subject_code,exam.obt_theory_mark,exam.obt_lab_mark,exam.exam_type,sub.name as sub_name,
        sub.sub_type,sub.lab_status	');
        $this->db->join('tbl_subjects as sub','sub.subject_code = exam.subject_code');
        $this->db->from('tbl_college_internal_exam_marks as exam');
        $this->db->where('exam.student_id', $student_id);
        $this->db->where('exam.subject_code', $subjects_code);
        $this->db->where('exam.exam_type', 'I_UNIT_TEST');
        $this->db->where('exam.exam_year', '2023-24');
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

     // get second internal exam mark
     public function getSecondInternalMark($student_id,$subjects_code){
        $this->db->select('exam.student_id,exam.subject_code,exam.obt_theory_mark,exam.obt_lab_mark,exam.exam_type,sub.name,
        sub.sub_type,sub.lab_status	');
        $this->db->join('tbl_subjects as sub','sub.subject_code = exam.subject_code');
        $this->db->from('tbl_college_internal_exam_marks as exam');
        $this->db->where('exam.student_id', $student_id);
        $this->db->where('exam.subject_code', $subjects_code);
        $this->db->where('exam.exam_type', 'II_UNIT_TEST');
        $this->db->where('exam.exam_year', '2022-23');
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    // get first internal exam mark
    public function getFirstTermMark($student_id,$subjects_code){
        $this->db->select('exam.student_id,exam.subject_code,exam.obt_theory_mark,exam.obt_lab_mark,exam.exam_type,sub.sub_name,
        sub.sub_type,sub.lab_status	');
        $this->db->join('tbl_subjects as sub','sub.subject_code = exam.subject_code');
        $this->db->from('tbl_college_internal_exam_marks as exam');
        $this->db->where('exam.student_id', $student_id);
        $this->db->where('exam.subject_code', $subjects_code);
        $this->db->where('exam.exam_type', 'I_TERM');
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    // get mid term exam mark
    public function getMidTermMark($student_id,$subjects_code){
        $this->db->select('exam.student_id,exam.subject_code,exam.obt_theory_mark,exam.obt_lab_mark,exam.exam_type,sub.name,
        sub.sub_type,sub.lab_status	');
        $this->db->join('tbl_subjects as sub','sub.subject_code = exam.subject_code');
        $this->db->from('tbl_college_internal_exam_marks as exam');
        $this->db->where('exam.student_id', $student_id);
        $this->db->where('exam.subject_code', $subjects_code);
        $this->db->where('exam.exam_type', 'MID_TERM');
        $this->db->where('exam.exam_year', '2023-24');
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

     // get mid term exam mark
     public function getFirstPreparatoryMark($student_id,$subjects_code){
        $this->db->select('exam.student_id,exam.subject_code,exam.obt_theory_mark,exam.obt_lab_mark,exam.exam_type,sub.name,
        sub.sub_type,sub.lab_status	');
        $this->db->join('tbl_subjects as sub','sub.subject_code = exam.subject_code');
        $this->db->from('tbl_college_internal_exam_marks as exam');
        $this->db->where('exam.student_id', $student_id);
        $this->db->where('exam.subject_code', $subjects_code);
        $this->db->where('exam.exam_type', 'I_PREPARATORY');
        $this->db->where('exam.exam_year', '2022-23');
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getAnnualExamMark($student_id,$subjects_code){
        $this->db->select('exam.student_id,exam.subject_code,exam.obt_theory_mark,exam.obt_lab_mark,exam.exam_type,sub.name,
        sub.sub_type,sub.lab_status	');
        $this->db->join('tbl_subjects as sub','sub.subject_code = exam.subject_code');
        $this->db->from('tbl_college_internal_exam_marks as exam');
        $this->db->where('exam.student_id', $student_id);
        $this->db->where('exam.subject_code', $subjects_code);
        $this->db->where('exam.exam_type', 'ANNUAL EXAM');
        $this->db->where('exam.exam_year', '2022-23');
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

      // get first internal Class exam mark
      public function getFirstClassTesttMark($student_id,$subjects_code){
        $this->db->select('exam.student_id,exam.subject_code,exam.obt_theory_mark,exam.obt_lab_mark,exam.exam_type,sub.name as sub_name,
        sub.sub_type,sub.lab_status	');
        $this->db->join('tbl_subjects as sub','sub.subject_code = exam.subject_code');
        $this->db->from('tbl_college_internal_exam_marks as exam');
        $this->db->where('exam.student_id', $student_id);
        $this->db->where('exam.subject_code', $subjects_code);
        $this->db->where('exam.exam_type', 'I_CLASS_TEST');
        $this->db->where('exam.exam_year', '2023-24');
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
  public function getRemarkInfoApi($stud_id){
        $this->db->select('remark.student_id,remark.date,remark.type_id,remark.file_path,remark.year,remark.description,remark.term_name,
        type.remark_name,remark.created_date_time');
        $this->db->from('tbl_student_all_remark_info as remark');
        $this->db->join('tbl_student_remarks_type as type','type.row_id = remark.type_id','left');
        $this->db->where('remark.student_id', $stud_id);
        $this->db->group_start();
        $this->db->where('remark.parent_visibility', 'YES');
        $this->db->or_where('FIND_IN_SET("PARENTS", remark.visibility_access) > 0');
        $this->db->group_end();
        $this->db->where('remark.is_deleted',0);
        $this->db->order_by('remark.created_date_time', 'DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
 
    function getFullMarksOfStudentInternal($student_id,$exam_type){
        $this->db->select('tbl_marks.exam_type,tbl_marks.student_id, 
        tbl_marks.obt_theory_mark,tbl_marks.obt_lab_mark, 
        sub.name as subject_name, sub.subject_code, sub.lab_status');
        $this->db->from('tbl_college_internal_exam_marks as tbl_marks');  
        $this->db->join('tbl_subjects as sub', 'sub.subject_code = tbl_marks.subject_code');
        $this->db->where('tbl_marks.is_deleted', 0);
        $this->db->where('tbl_marks.exam_year', EXAM_YEAR);
        $this->db->where('tbl_marks.student_id', $student_id);
        $this->db->where_in('tbl_marks.exam_type', $exam_type);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getExamSubjectInfo($subjects_code){   
        $this->db->from('tbl_subjects as sub');
        $this->db->where('sub.subject_code', $subjects_code);
        $this->db->where('sub.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    function getSubjectInfo($subject_id){
        $this->db->select('sub.name as sub_name');
        $this->db->from("tbl_subjects as sub");
        $this->db->where('sub.subject_code',$subject_id);
        $this->db->where('sub.is_deleted',0);
        $query = $this->db->get();
        return $query->row();
    }
}
?>