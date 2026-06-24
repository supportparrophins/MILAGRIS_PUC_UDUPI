<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class  Mun_model extends CI_Model
{
    public function getMunRegisteredInfoCount($filter)
    {
        $this->db->from('tbl_student_event_registration as std'); 
        $this->db->join('tbl_mun_external_registration_details as evt','evt.event_register_row_id = std.row_id','left'); 
      
        if(!empty($filter['name'])){
            $likeCriteria = "(std.college_name  LIKE '%" . $filter['name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['mobile_no'])){
            $this->db->where('std.mobile', $filter['mobile_no']);
        }
        if(!empty($filter['registeration_type'])){
            $this->db->where('evt.registeration_type', $filter['registeration_type']);
        } 
        if(!empty($filter['amount'])){
            $this->db->where('evt.paid_amount', $filter['amount']);
        } 
        if(!empty($filter['status'])){
            if($filter['status'] == 'Paid'){
                $this->db->where('evt.payment_status', 1);
            }else{
                $this->db->where('evt.payment_status', 0);
            }
        } 
        // if(!empty($filter['order_id'])){
        //     $this->db->where('pay.order_id', $filter['order_id']);
        // } 


        // if(!empty($filter['date'])){
        //     $this->db->where('pay.payment_date', $filter['date']);
        // } 

        // $this->db->where('evt.payment_status', 1);
        $this->db->where('evt.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getMunRegisteredInfo($filter) {
        $this->db->select('std.row_id,std.college_name,std.mobile,std.email,evt.event_register_row_id,evt.registeration_type,
        evt.total_students,evt.paid_amount,evt.payment_status'); 
        $this->db->from('tbl_student_event_registration as std'); 
        $this->db->join('tbl_mun_external_registration_details as evt','evt.event_register_row_id = std.row_id','left'); 
      
        if(!empty($filter['name'])){
            $likeCriteria = "(std.college_name  LIKE '%" . $filter['name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['mobile_no'])){
            $this->db->where('std.mobile', $filter['mobile_no']);
        }
        if(!empty($filter['registeration_type'])){
            $this->db->where('evt.registeration_type', $filter['registeration_type']);
        } 
        if(!empty($filter['amount'])){
            $this->db->where('evt.paid_amount', $filter['amount']);
        } 
        if(!empty($filter['status'])){
            if($filter['status'] == 'Paid'){
                $this->db->where('evt.payment_status', 1);
            }else{
                $this->db->where('evt.payment_status', 0);
            }
        } 
        // if(!empty($filter['order_id'])){
        //     $this->db->where('pay.order_id', $filter['order_id']);
        // } 

        // if(!empty($filter['date'])){
        //     $this->db->where('pay.payment_date', $filter['date']);
        // } 

        // $this->db->where('evt.payment_status', 1);
        $this->db->where('evt.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    public function updateEventInfo($eventInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_student_event_registration', $eventInfo);
        return TRUE;
    }

    
    public function getParticipantInfo($row_id){
        $this->db->from('tbl_mun_external_participant_info as part');
        $this->db->where('part.registration_row_id', $row_id);
        $this->db->where('part.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
        
    }
    
    
    public function getRegistrationInfo($row_id){
        $this->db->from('tbl_student_event_registration as reg');
        $this->db->where('reg.row_id', $row_id);
        $this->db->where('reg.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
        
    }
    public function getEventRegistrationInfo($row_id){
        $this->db->from('tbl_mun_external_registration_details as reg');
        $this->db->where('reg.event_register_row_id', $row_id);
        $this->db->where('reg.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
        
    }

    public function getInchargeInfo($row_id){
        $this->db->from('tbl_mun_incharge_details as incharge');
        $this->db->where('incharge.event_register_row_id', $row_id);
        $this->db->where('incharge.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
        
    }

    // internal
    public function getInternalRegistrationCount($filter) {
        $this->db->from('tbl_mun_internal_students_reg as reg'); 
        $this->db->join('tbl_students_info as std','std.student_id = reg.student_id','left'); 
      
        if(!empty($filter['name'])){
            $likeCriteria = "(std.student_name  LIKE '%" . $filter['name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['mobile_no'])){
            $this->db->where('reg.whatsapp_no', $filter['mobile_no']);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('std.student_id', $filter['student_id']);
        } 
        if(!empty($filter['term'])){
            $this->db->where('std.term_name', $filter['term']);
        } 
        if(!empty($filter['stream'])){
            $this->db->where('std.stream_name', $filter['stream']);
        } 
        if(!empty($filter['committee'])){
            $this->db->where('reg.committee', $filter['committee']);
        } 
        // if(!empty($filter['status'])){
        //     if($filter['status'] == 'Paid'){
        //         $this->db->where('evt.payment_status', 1);
        //     }else{
        //         $this->db->where('evt.payment_status', 0);
        //     }
        // } 
        // if(!empty($filter['order_id'])){
        //     $this->db->where('pay.order_id', $filter['order_id']);
        // } 


        // if(!empty($filter['date'])){
        //     $this->db->where('pay.payment_date', $filter['date']);
        // } 

        // $this->db->where('evt.payment_status', 1);
        $this->db->where('reg.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getInternalRegistrationInfo($filter) {
        $this->db->select('reg.row_id,reg.whatsapp_no,std.student_id,std.student_name,std.term_name,std.stream_name,
        std.section_name,reg.committee'); 
        $this->db->from('tbl_mun_internal_students_reg as reg'); 
        $this->db->join('tbl_students_info as std','std.student_id = reg.student_id','left'); 
      
        if(!empty($filter['name'])){
            $likeCriteria = "(std.student_name  LIKE '%" . $filter['name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['mobile_no'])){
            $this->db->where('reg.whatsapp_no', $filter['mobile_no']);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('std.student_id', $filter['student_id']);
        } 
        if(!empty($filter['term'])){
            $this->db->where('std.term_name', $filter['term']);
        } 
        if(!empty($filter['stream'])){
            $this->db->where('std.stream_name', $filter['stream']);
        } 
        if(!empty($filter['committee'])){
            $this->db->where('reg.committee', $filter['committee']);
        } 
        $this->db->where('reg.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }
    
    public function updateInternalRegistrationEventInfo($eventInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_mun_internal_students_reg', $eventInfo);
        return TRUE;
    }

    // Download external registrtaion info
    public function getExternalMunRegistrationInfo($filter){
        
        $this->db->select('std.row_id,std.college_name,std.mobile,std.email,evt.event_register_row_id,evt.registeration_type,
        evt.total_students,evt.paid_amount,evt.payment_status,evt.row_id as event_register_id,std.created_date_time'); 
        $this->db->from('tbl_student_event_registration as std'); 
        $this->db->join('tbl_mun_external_registration_details as evt','evt.event_register_row_id = std.row_id','left'); 
      
        if(!empty($filter['status'])){
            if($filter['status'] == 'Paid'){
                $this->db->where('evt.payment_status', 1);
            }else{
                $this->db->where('evt.payment_status', 0);
            }
        } 
        
        if(!empty($filter['register_type'])){
            $this->db->where('evt.registeration_type', $filter['register_type']);
        } 
        // $this->db->where('evt.payment_status', 1);
        $this->db->where('evt.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $this->db->where('std.year', '2022');
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    public function downloadMunInternalReport($filter){
        
        $this->db->select('reg.row_id,reg.whatsapp_no,std.student_id,std.student_name,std.term_name,std.stream_name,
        std.section_name,reg.committee'); 
        $this->db->from('tbl_mun_internal_students_reg as reg'); 
        $this->db->join('tbl_students_info as std','std.student_id = reg.student_id','left'); 
        $this->db->where('reg.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();         
        return $result;  
    }

}
?>