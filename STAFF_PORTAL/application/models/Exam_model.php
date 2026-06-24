<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
    class Exam_model extends CI_Model {
        
        // get marks infor for internal exam
        public function getInternalExamSubjectMarkByID($subject_id,$student_id,$exam_type,$exam_year){
            $this->db->from('tbl_college_internal_exam_marks as exam');
            $this->db->where('exam.subject_code', $subject_id);
            $this->db->where('exam.student_id', $student_id);
            $this->db->where('exam.exam_type', $exam_type);
             $this->db->where('exam.exam_year', $exam_year);
            $this->db->where('exam.is_deleted', 0);
            $query = $this->db->get();
            return $query->row();
        }
        
        //add internal marks
        public function addStudentInternalMark($examInfo) {
            $this->db->trans_start();
            $this->db->insert('tbl_college_internal_exam_marks', $examInfo);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            return $insert_id;
        }
        public function updateStudentInternalMark($subject_id,$student_id,$exam_type,$markInfo,$exam_year){
            $this->db->where('subject_code', $subject_id);
            $this->db->where('student_id', $student_id);
            $this->db->where('exam_type', $exam_type);
            $this->db->where('exam_year', $exam_year);
            $this->db->update('tbl_college_internal_exam_marks', $markInfo);
            return true;
        }
        
        function getFullMarksOfStudentInternal($student_id,$exam_type){
            $this->db->select('tbl_marks.student_id, tbl_marks.obt_theory_mark,tbl_marks.obt_lab_mark,tbl_marks.exam_type, sub.name as sub_name, sub.subject_code,tbl_marks.min_marks,tbl_marks.max_marks,tbl_marks.min_marks_lab,tbl_marks.max_marks_lab, tbl_marks.lab_status');
            $this->db->from('tbl_college_internal_exam_marks as tbl_marks');  
            $this->db->join('tbl_subjects as sub', 'sub.subject_code = tbl_marks.subject_code');
            $this->db->where_in('tbl_marks.student_id', $student_id);
            $this->db->where('tbl_marks.exam_type', $exam_type);
            $this->db->where('tbl_marks.exam_year', EXAM_YEAR);
            $this->db->where('tbl_marks.is_deleted', 0);
            $this->db->where('sub.is_deleted', 0);
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }

        // function getMarksOfStudentBySubCode($student_id,$subject_code,$exam_type){
        //     $this->db->select('tbl_marks.student_id, tbl_marks.obt_theory_mark,tbl_marks.obt_lab_mark,tbl_marks.exam_type, sub.name as sub_name, sub.subject_code,tbl_marks.min_marks,tbl_marks.max_marks,tbl_marks.min_marks_lab,tbl_marks.max_marks_lab, tbl_marks.lab_status');
        //     $this->db->from('tbl_college_internal_exam_marks as tbl_marks');  
        //     $this->db->join('tbl_subjects as sub', 'sub.subject_code = tbl_marks.subject_code');
        //     $this->db->where_in('tbl_marks.student_id', $student_id);
        //     $this->db->where('tbl_marks.exam_type', $exam_type);
        //     $this->db->where('tbl_marks.subject_code', $subject_code);
        //     $this->db->where('tbl_marks.exam_year', '2024-25');
        //     $this->db->where('tbl_marks.is_deleted', 0);
        //     $this->db->where('sub.is_deleted', 0);
        //     $query = $this->db->get();
        //     $result = $query->row();
        //     return $result;
        // }

        public function getExamCount($filter){
            $this->db->from('tbl_exam_info as exam'); 
            $this->db->join('tbl_subjects as sub', 'sub.subject_code = exam.subject_code');
           if(!empty($filter['by_class'])){
                $this->db->where('exam.class', $filter['by_class']);
            }
            if(!empty($filter['by_stream'])){
                $this->db->where('exam.stream', $filter['by_stream']);
            }
            if(!empty($filter['min_marks'])){
                $this->db->where('exam.min_marks', $filter['min_marks']);
            } 
            if(!empty($filter['max_marks'])){
                $this->db->where('exam.max_marks', $filter['max_marks']);
            } 
            if(!empty($filter['subject_name'])){
                $this->db->where('sub.name', $filter['subject_name']);
            } 
            if(!empty($filter['exam_type'])){
                $this->db->where('exam.exam_type', $filter['exam_type']);
            } 
            if(!empty($filter['exam_name'])){
                $this->db->where('exam.exam_name', $filter['exam_name']);
            }
            if(!empty($filter['exam_date'])){
                $this->db->where('exam.exam_date', $filter['exam_date']);
            }
            if(!empty($filter['time'])){
                $this->db->where('exam.time', $filter['time']);
            }
            if(!empty($filter['year'])){
                $this->db->where('exam.exam_year', $filter['year']);
            }
            $this->db->where('exam.is_deleted', 0);
            $this->db->where('sub.is_deleted', 0);
            $this->db->order_by('exam.row_id', 'DESC');
            $query = $this->db->get();
            return $query->num_rows();
        }

        public function getExamInfo($filter, $page, $segment){
            $this->db->select('exam.row_id,exam.class,exam.exam_name,exam.exam_date,exam.exam_type,exam.time,sub.name,exam.subject_code,exam.exam_status,exam.stream');
            $this->db->from('tbl_exam_info as exam'); 
            $this->db->join('tbl_subjects as sub', 'sub.subject_code = exam.subject_code');
           if(!empty($filter['by_class'])){
                $this->db->where('exam.class', $filter['by_class']);
            }
            if(!empty($filter['by_stream'])){
                $this->db->where('exam.stream', $filter['by_stream']);
            }
            if(!empty($filter['min_marks'])){
                $this->db->where('exam.min_marks', $filter['min_marks']);
            } 
            if(!empty($filter['max_marks'])){
                $this->db->where('exam.max_marks', $filter['max_marks']);
            } 
            if(!empty($filter['subject_name'])){
                $this->db->where('sub.name', $filter['subject_name']);
            } 
            if(!empty($filter['exam_type'])){
                $this->db->where('exam.exam_type', $filter['exam_type']);
            } 
            if(!empty($filter['exam_name'])){
                $this->db->where('exam.exam_name', $filter['exam_name']);
            }
            if(!empty($filter['exam_date'])){
                $this->db->where('exam.exam_date', $filter['exam_date']);
            }
            if(!empty($filter['time'])){
                $this->db->where('exam.time', $filter['time']);
            }
            if(!empty($filter['year'])){
                $this->db->where('exam.exam_year', $filter['year']);
            }
            $this->db->order_by('exam.class', 'ASC');
            $this->db->order_by('exam.subject_code', 'ASC');
            $this->db->where('exam.is_deleted', 0);
            $this->db->where('sub.is_deleted', 0);
            $this->db->order_by('exam.row_id', 'DESC');
            // $this->db->order_by('exam.section_name', 'ASC');
            $this->db->limit($page, $segment);
            $query = $this->db->get();
            $result = $query->result();        
            return $result;
        }

        public function getCreatedExamInfo($filter, $page, $segment){
            $this->db->select('exam.row_id,exam.class,exam.exam_name,exam.exam_date,exam.exam_type,exam.time,sub.name,exam.subject_code,exam.exam_status,exam.stream');
            $this->db->from('tbl_create_exam as exam'); 
            $this->db->join('tbl_subjects as sub', 'sub.subject_code = exam.subject_code');
           if(!empty($filter['by_class'])){
                $this->db->where('exam.class', $filter['by_class']);
            }
            if(!empty($filter['by_stream'])){
                $this->db->where('exam.stream', $filter['by_stream']);
            }
            if(!empty($filter['min_marks'])){
                $this->db->where('exam.min_marks', $filter['min_marks']);
            } 
            if(!empty($filter['max_marks'])){
                $this->db->where('exam.max_marks', $filter['max_marks']);
            } 
            if(!empty($filter['subject_name'])){
                $this->db->where('sub.name', $filter['subject_name']);
            } 
            if(!empty($filter['exam_type'])){
                $this->db->where('exam.exam_type', $filter['exam_type']);
            } 
            if(!empty($filter['exam_name'])){
                $this->db->where('exam.exam_name', $filter['exam_name']);
            }
            if(!empty($filter['exam_date'])){
                $this->db->where('exam.exam_date', $filter['exam_date']);
            }
            if(!empty($filter['time'])){
                $this->db->where('exam.time', $filter['time']);
            } 
            if(!empty($filter['year'])){
                $this->db->where('exam.exam_year', $filter['year']);
            }
            $this->db->order_by('exam.class', 'ASC');
            $this->db->order_by('exam.subject_code', 'ASC');
            $this->db->where('exam.is_deleted', 0);
            $this->db->where('sub.is_deleted', 0);
            $this->db->order_by('exam.row_id', 'DESC');
            // $this->db->order_by('exam.section_name', 'ASC');
            $this->db->limit($page, $segment);
            $query = $this->db->get();
            $result = $query->result();        
            return $result;
        }


        public function getCreatedExamCount($filter){
            $this->db->from('tbl_create_exam as exam'); 
            $this->db->join('tbl_subjects as sub', 'sub.subject_code = exam.subject_code');
           if(!empty($filter['by_class'])){
                $this->db->where('exam.class', $filter['by_class']);
            }
            if(!empty($filter['by_stream'])){
                $this->db->where('exam.stream', $filter['by_stream']);
            }
            if(!empty($filter['min_marks'])){
                $this->db->where('exam.min_marks', $filter['min_marks']);
            } 
            if(!empty($filter['max_marks'])){
                $this->db->where('exam.max_marks', $filter['max_marks']);
            } 
            if(!empty($filter['subject_name'])){
                $this->db->where('sub.name', $filter['subject_name']);
            } 
            if(!empty($filter['exam_type'])){
                $this->db->where('exam.exam_type', $filter['exam_type']);
            } 
            if(!empty($filter['exam_name'])){
                $this->db->where('exam.exam_name', $filter['exam_name']);
            }
            if(!empty($filter['exam_date'])){
                $this->db->where('exam.exam_date', $filter['exam_date']);
            }
            if(!empty($filter['time'])){
                $this->db->where('exam.time', $filter['time']);
            } 
            if(!empty($filter['year'])){
                $this->db->where('exam.exam_year', $filter['year']);
            }
            $this->db->where('exam.is_deleted', 0);
            $this->db->where('sub.is_deleted', 0);
            $this->db->order_by('exam.row_id', 'DESC');
            $query = $this->db->get();
            return $query->num_rows();
        }

        // add Exam
        function addExam($examInfo){
            $this->db->trans_start();
            $this->db->insert('tbl_exam_info', $examInfo);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            return $insert_id;
        }

        function updateExam($row_id, $examInfo){
            $this->db->where('row_id', $row_id);
            $this->db->update('tbl_exam_info', $examInfo);
            return $this->db->affected_rows();
        }

           // add Exam
           function createNewExam($examInfo){
            $this->db->trans_start();
            $this->db->insert('tbl_create_exam', $examInfo);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            return $insert_id;
        }

        function isExamAlreadyCreated($class,$stream,$subject_name,$exam_type){
            $this->db->from('tbl_create_exam as exam');  
            $this->db->where('exam.class', $class);
            $this->db->where('exam.stream', $stream);
            $this->db->where('exam.subject_code', $subject_name);
            $this->db->where('exam.exam_type', $exam_type);
            $this->db->where('exam.exam_year', CURRENT_YEAR);
            $this->db->where('exam.is_deleted', 0);
            $query = $this->db->get();
            $result = $query->row();
            return $result;
        }

        function updateCreatedExam($row_id, $examInfo){
            $this->db->where('row_id', $row_id);
            $this->db->update('tbl_create_exam', $examInfo);
            return $this->db->affected_rows();
        }

        public function getExamTypeById($term_id,$subject_code){
            $this->db->select('exam.row_id,exam.subject_code,exam.min_marks_lab,exam.max_marks_lab,exam.class,exam.exam_name,exam.min_marks,exam.max_marks,exam.exam_type');
            $this->db->from('tbl_create_exam as exam');
            $this->db->join('tbl_subjects as sub', 'sub.subject_code = exam.subject_code','left');
            $this->db->where('exam.class', $term_id);
            $this->db->where('sub.subject_code', $subject_code);
            $this->db->where('exam.is_deleted', 0);
            $this->db->where('exam.exam_status', 0);
            $this->db->where('sub.is_deleted', 0);
            $query = $this->db->get();
            return $query->result();
        }

        public function getExamNameInfo($exam_row_id){
            $this->db->from('tbl_create_exam as exam'); 
            $this->db->where('exam.row_id', $exam_row_id);
            $this->db->where('exam.is_deleted', 0);
            $query = $this->db->get();
            return $query->row();
        }

        public function getExamInfoById($row_id)
        {
            $this->db->select('exam.row_id,sub.name,exam.hall_ticket,exam.exam_date,exam.stream,exam.subject_code,exam.min_marks_lab,exam.max_marks_lab,exam.class,exam.exam_name,exam.min_marks,exam.max_marks,exam.exam_type,exam.lab_status');
            $this->db->from('tbl_create_exam as exam');
            $this->db->join('tbl_subjects as sub', 'sub.subject_code = exam.subject_code','left');
            $this->db->where('exam.row_id', $row_id);
            $this->db->where('exam.is_deleted', 0);
            $query = $this->db->get();
            return $query->row();
        }

        public function getExamInfoByExamId($row_id)
        {
            $this->db->from('tbl_exam_info as exam');
            $this->db->where('exam.exam_row_id', $row_id);
            $this->db->where('exam.is_deleted', 0);
            $query = $this->db->get();
            return $query->row();
        }

        function updateCreatedHallTicket($row_id, $examInfo){
            $this->db->where('exam_row_id', $row_id);
            $this->db->update('tbl_exam_info', $examInfo);
            return $this->db->affected_rows();
        }
        public function getStreamInfoById($stream_name){
            $this->db->select('stream.stream_name');
            $this->db->from('tbl_section_info as section'); 
            $this->db->join('tbl_stream_info as stream', 'stream.row_id = section.stream_id ','left');
            $this->db->where('section.row_id', $stream_name);
            $this->db->where('section.is_deleted', 0);
            $query = $this->db->get();
            return $query->row();
        }

        public function getExamTypeByRow_Id($term_id,$subject_code,$stream_name){
            $this->db->select('exam.row_id,exam.subject_code,exam.min_marks_lab,exam.max_marks_lab,exam.class,exam.exam_name,exam.min_marks,exam.max_marks,exam.exam_type');
            $this->db->from('tbl_create_exam as exam');
            $this->db->join('tbl_subjects as sub', 'sub.subject_code = exam.subject_code','left');
            $this->db->where('exam.class', $term_id);
            $this->db->where('exam.stream', $stream_name);
            $this->db->where('sub.subject_code', $subject_code);
            $this->db->where('exam.is_deleted', 0);
            $this->db->where('exam.exam_status', 0);
            $this->db->where('sub.is_deleted', 0);
            $query = $this->db->get();
            return $query->result();
        }

        function getAllExamMarkInfoByExamType($exam_type){
            $this->db->from('tbl_college_internal_exam_marks as tbl_marks');  
            $this->db->where('tbl_marks.exam_type', $exam_type);
            $this->db->where('tbl_marks.exam_year', EXAM_YEAR);
            $this->db->where('tbl_marks.is_deleted', 0);
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }

        public function getCreateExamDetailsByStudentInfo($exam_type,$term_name,$stream_name,$subject_code){
            $this->db->from('tbl_create_exam as exam');
            $this->db->where('exam.exam_type', $exam_type);
            $this->db->where('exam.class', $term_name);
            $this->db->where('exam.stream', $stream_name);
            $this->db->where('exam.subject_code', $subject_code);
            $this->db->where('exam.is_deleted', 0);
            $query = $this->db->get();
            return $query->row();
        }

        public function updateSchoolInteralMarks($mark_info,$row_id){
            $this->db->where('row_id', $row_id);
            $this->db->update('tbl_college_internal_exam_marks',$mark_info);
            return TRUE;
        }
        
        function getMarksOfStudentBySubCode($student_id,$subject_code,$exam_type){
            $this->db->select('tbl_marks.student_id, tbl_marks.obt_theory_mark,tbl_marks.obt_lab_mark,tbl_marks.exam_type, sub.name as sub_name, sub.subject_code,tbl_marks.min_marks,tbl_marks.max_marks,tbl_marks.min_marks_lab,tbl_marks.max_marks_lab, tbl_marks.lab_status');
            $this->db->from('tbl_college_internal_exam_marks as tbl_marks');  
            $this->db->join('tbl_subjects as sub', 'sub.subject_code = tbl_marks.subject_code');
            $this->db->where_in('tbl_marks.student_id', $student_id);
            $this->db->where('tbl_marks.exam_type', $exam_type);
            $this->db->where('tbl_marks.subject_code', $subject_code);
            $this->db->where('tbl_marks.exam_year', EXAM_YEAR);
            $this->db->where('tbl_marks.is_deleted', 0);
            $this->db->where('sub.is_deleted', 0);
            $query = $this->db->get();
            $result = $query->row();
            return $result;
        }

    }
?>