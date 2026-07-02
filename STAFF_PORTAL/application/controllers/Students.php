<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerFaculty.php';
use PhpOffice\PhpSpreadsheet\Cell\DataType;

ini_set('max_execution_time', 0);
class Students extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('students_model','student');
        $this->load->model('settings_model','settings');
        $this->load->model('subjects_model','subject');
        $this->load->model('staff_model','staff');
        $this->load->model('push_notification_model');
        $this->load->model('fee_model','pay');
        $this->load->model('exam_model','exams');
        $this->load->library('pagination');
        $this->load->model('transport_model', 'transport');
        $this->load->library('excel');
        $this->isLoggedIn();   
    }

    function studentDetails() {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $filter = array();
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $by_name = $this->security->xss_clean($this->input->post('by_name'));
            $application_no = $this->security->xss_clean($this->input->post('application_no'));
            $by_dob = $this->security->xss_clean($this->input->post('by_dob'));
            $by_term = $this->security->xss_clean($this->input->post('by_term'));
            $by_stream = $this->security->xss_clean($this->input->post('by_stream'));
            $by_Section = $this->security->xss_clean($this->input->post('by_Section'));
            $by_elective = $this->security->xss_clean($this->input->post('by_elective'));
            $year = $this->input->post('admission_year');
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
            $father_mobile = $this->security->xss_clean($this->input->post('father_mobile'));
            $mother_mobile = $this->security->xss_clean($this->input->post('mother_mobile'));
            $father_name = $this->security->xss_clean($this->input->post('father_name'));
            $mother_name = $this->security->xss_clean($this->input->post('mother_name'));
            $religionName = $this->security->xss_clean($this->input->post('religionName'));
            $categoryName = $this->security->xss_clean($this->input->post('categoryName'));

            $data['student_id'] = $student_id;
            $data['application_no'] = $application_no;
            $data['by_name'] = $by_name;
            $data['by_term'] = $by_term;
            $data['by_stream'] = $by_stream;
            $data['by_Section'] = $by_Section;
            $data['by_elective'] = $by_elective;
            $data['stream_name'] = $stream_name;
            $data['father_mobile'] = $father_mobile;
            $data['mother_mobile'] = $mother_mobile;
            $data['father_name'] = $father_name;
            $data['mother_name'] = $mother_name;
            $data['religionName'] = $religionName;
            $data['categoryName'] = $categoryName;

            $filter['student_id'] = $student_id;
            $filter['application_no'] = $application_no;
            $filter['by_name'] = $by_name;
            $filter['by_term'] = $by_term;
            $filter['by_stream'] = $by_stream;
            $filter['by_Section'] = $by_Section;
            $filter['by_elective'] = $by_elective;
            $filter['year'] = $year;
            $filter['stream_name'] = $stream_name;
            $filter['father_mobile'] = $father_mobile;
            $filter['mother_mobile'] = $mother_mobile;
            $filter['father_name'] = $father_name;
            $filter['mother_name'] = $mother_name;
            $filter['religionName'] = $religionName;
            $filter['categoryName'] = $categoryName;

            if(!empty($by_dob)){
                $filter['by_dob'] = date('Y-m-d',strtotime($by_dob));
                $data['by_dob'] = date('d-m-Y',strtotime($by_dob));
            }else{
                $data['by_dob'] = '';
            }

            // TEACHING STAFF
            $class_name = array();
            $section = array(); 
            $studentData = array(); 
            $student_row_id = array();
            $filter['class'] = '';
            $i = 0;
            if($this->role == ROLE_TEACHING_STAFF){
                $staffClassInfo = $this->staff->getSectionByStaffId($this->staff_id);
                foreach($staffClassInfo as $class){
                     if($class->section_name == 'ALL'){
                       $sectionName = '';
                       }else{
                       $sectionName = $class->section_name;  
                    }
          
                    $filter['by_term_T'] = $class->term_name;
            
                    $filter['by_stream_T'] = $class->stream_name;
                    
                $filter['by_Section_T'] = $sectionName;
                $studentInfo = $this->student->getAllstudentInfoRowId($filter);
                array_push($studentData,$studentInfo);
                    
                }
              
                 $studentData=array_merge(...$studentData);
                 $j=0;
                 foreach($studentData as $std){
                  $student_row_id[$j] = $std->row_id;
                  $j++;
                 }
                }

            $data['religionInfo'] = $this->settings->getAllReligionInfo();
            $data['categoryInfo'] = $this->settings->getAllCategoryInfo();

            $data['streamInfo'] = $this->student->getAllStreamName();
            $data['examTypeInfo'] = $this->settings->getExamTypeInfo();
            $count = $this->student->getAllstudentInfoCount($filter,$student_row_id);
            $returns = $this->paginationCompress("studentDetails/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['studentInfo'] = $this->student->getAllstudentInfo($filter,$student_row_id);
            $data['accessInfo'] = $this->getCurrentAccess();
            // log_message('debug', 'sdfedf... to student id'.print_r($data['accessInfo'],true));
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Student Details';
            $this->loadViews("students/students", $this->global,$data, NULL);

        }
    }

    public function get_students(){
        if($this->isAdmin() == TRUE  ){
            $this->loadThis();
        } else {
            $draw = intval($this->input->post("draw"));
            $start = intval($this->input->post("start"));
            $length = intval($this->input->post("length"));
            $data_array_new = [];
            $year = $this->input->post('admission_year');
            $studentInfo = $this->student->getAllstudentInfo($year);
            $accessInfo = $this->getCurrentAccess();
            foreach($studentInfo as $student) {
                $editButton = "";
                $deleteButton = "";
                $checkbox = '<input type="checkbox" class="singleSelect" value="<?php echo .$student->student_id; ?>" />';
                    $studentViewMore = '<a class="btn btn-xs btn-primary" target="_blank"
                    href="'.base_url().'viewStudentInfoById/'.$student->row_id.'"
                    title="View More"><i class="fa fa-eye"></i></a>';
                
                
                // if($this->role == ROLE_ADMIN || $this->role == ROLE_PRIMARY_ADMINISTRATOR|| $this->role == ROLE_OFFICE || $this->role == ROLE_SUPER_ADMIN){
               if($accessInfo->can_edit==1){ 
                    $editButton = '<a class="btn btn-xs btn-info" target="_blank"
                    href="'.base_url().'editStudent/'.$student->row_id.'" title="Edit Student"><i
                        class="fas fa-pencil-alt"></i></a>';
                }
                        
                // if($this->role == ROLE_PRIMARY_ADMINISTRATOR || $this->role == ROLE_SUPER_ADMIN){
                if($accessInfo->can_delete==1){
                    $deleteButton = '<a class="btn btn-xs btn-danger deleteStudent"
                    data-row_id="'.$student->application_no.'" href="#" title="Delete">
                    <i class="fas fa-trash"></i></a>';
                        
                }
                    $data_array_new[] = array(
                    $checkbox,
                    $student->student_id,
                    $student->application_no,
                    $student->student_name,
                    $student->term_name,
                    $student->stream_name,
                    $student->section_name,
                    $studentViewMore.' '.$editButton.' '.$deleteButton
                    );
                }
            $count = count($studentInfo);
            $result = array(
                "draw" => $draw,
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                "data" => $data_array_new
            );
            echo json_encode($result);
            exit();
        }
    } 

    public function viewStudentInfoById($row_id = null) {
        if($this->isAdmin() == TRUE  ){
            $this->loadThis();
        } else {
            if($row_id == null) {
                redirect('studentDetails');
            }
            $filter = array();
            $exam_mark_first_test = array();
            $exam_mark_second_test = array();
            $exam_mark_first_term = array();
            $exam_mark_mid_term = array();
            $exam_mark_first_preparatory = array();
            $subject_attendance = array();
            $total_class_held = 0;
            $total_class_attended = 0;
            $total_attendance_percentage = 0;
            $student = $this->student->getStudentInfoById($row_id);
            // $data['subjects'] = $this->student->getSubjectsByStreamAndYear($student->stream_name, $student->term_name);
            // $data['subjectCodes'] = array_column($data['subjects'], 'subject_code');
            $filter['stream_name'] = $student->stream_name;
            if($student->section_name != ''){
                $filter['section_name'] = $student->section_name;
            }else{
                $filter['section_name'] = 'ALL';
            }
            $filter['subject_type'] = 'THEORY';
            $filter['term_name'] = $student->term_name; 
            $filter['gender'] = $student->gender; 

            $filter['student_fee_type'] = 'REG';

            if($student->term_name == 'II PUC'){
                if($student->intake_year_id == FEE_YEAR){
                    $filter['student_fee_type'] = 'NEW';
                }else{
                    $filter['student_fee_type'] = 'REG';
                }
            }
            $filter['fee_year'] = FEE_YEAR;
            $data['govt_fee'] = $govt_fee = $this->pay->getGovtFeeAmount($filter);
            $total_fee_obj = $this->pay->getTotalFeeAmount($filter);
            $total_fee_amount = $total_fee_obj->total_fee;
            $data['total_fee'] = $total_fee_amount + $govt_fee;
            $data['bill_model'] = $this->pay;
            $paidFee = $this->pay->getTotalFeePaidInfo($student->row_id,FEE_YEAR);
            $govtFeePaid = $this->pay->getSumGovtFeePaidInfo($student->row_id,FEE_YEAR);
            $data['paid_amount'] = $paidFee + $govtFeePaid->paid_amount;
            $subjects_code = array();
            $elective_sub = strtoupper($student->elective_sub);
            if($elective_sub == "KANNADA"){
                array_push($subjects_code, '1');
            }else if($elective_sub == 'HINDI'){
                array_push($subjects_code, '3');
            } else if($elective_sub == 'FRENCH'){
                array_push($subjects_code, '12');
            }else if($elective_sub == 'URDU'){
                array_push($subjects_code, '8');
            }else{
                array_push($subject_mark_chart,0);
                array_push($subject_names, 'EXM');
            }
            array_push($subjects_code, '2');
            $subjects = $this->getSubjectCodes($student->stream_name);
            $subjects_code = array_merge($subjects_code,$subjects);
            $data['subjectCodes'] = $subjects_code;
            for($i=0;$i<count($subjects_code);$i++){
                $getMarkOfFirstUnitTest = $this->student->getFirstInternaltMark($student->student_id,$subjects_code[$i]);
                $exam_mark_first_test[$i] = $getMarkOfFirstUnitTest;
                $getMarkOfFirstClassTest = $this->student->getFirstClassTesttMark($student->student_id,$subjects_code[$i]);
                $exam_mark_first_class_test[$i] = $getMarkOfFirstClassTest;
                // $getMarkOfFirstTermExam = $this->student->getFirstTermMark($student->student_id,$subjects_code[$i]);
                // $exam_mark_first_term[$i] = $getMarkOfFirstTermExam;
                $getMarkOfmidTermExam = $this->student->getMidTermMark($student->student_id,$subjects_code[$i]); 
                $exam_mark_mid_term[$i] = $getMarkOfmidTermExam;
                $getMarkOfSecondUnitTest = $this->student->getSecondInternalMark($student->student_id,$subjects_code[$i]);
                $exam_mark_second_test[$i] = $getMarkOfSecondUnitTest;
                $getFirstPreparatoryMark = $this->student->getFirstPreparatoryMark($student->student_id,$subjects_code[$i]); 
                $exam_mark_first_preparatory[$i] = $getFirstPreparatoryMark;
                $getAnnuakMark = $this->student->getAnnualExamMark($student->student_id,$subjects_code[$i]); 
                $exam_mark_annual[$i] = $getAnnuakMark;
                $subject_attendance[$subjects_code[$i]]['sub_name'] = $this->subject->getSubjectInfoById($subjects_code[$i]);
                $subject_attendance[$subjects_code[$i]]['class_held'] = $this->student->getClassHeldInfo($filter,$subjects_code[$i]);
                $class_absent = $this->student->getStudentAbsentInfo($student->student_id,$subjects_code[$i]);
                $subject_attendance[$subjects_code[$i]]['class_attended'] = $subject_attendance[$subjects_code[$i]]['class_held'] - $class_absent;
                if($subject_attendance[$subjects_code[$i]]['class_held'] == 0){
                    $subject_attendance[$subjects_code[$i]]['percentage'] = 0;
                }else{
                    $subject_attendance[$subjects_code[$i]]['percentage'] = ($subject_attendance[$subjects_code[$i]]['class_attended'] / $subject_attendance[$subjects_code[$i]]['class_held']) * 100;
                }
                $total_class_held += $subject_attendance[$subjects_code[$i]]['class_held'];
                $total_class_attended += $subject_attendance[$subjects_code[$i]]['class_attended'];
            }
            if($total_class_held == 0){
                $total_attendance_percentage = 0;
            }else{
                $total_attendance_percentage = ($total_class_attended/$total_class_held)*100;
            }
            $data['firstUnitTestMarkInfo'] = $exam_mark_first_test;
            $data['firstClassTestMarkInfo'] = $exam_mark_first_class_test;
            // $data['firstTermMarkInfo'] = $exam_mark_first_term;
            $data['midTermMarkInfo'] = $exam_mark_mid_term;
            $data['secondUnitTestMarkInfo'] = $exam_mark_second_test;
            //  log_message('debug', 'sdfedf... to student id'.print_r($data['secondUnitTestMarkInfo'],true));
            $data['firstPreparatoryMarkInfo'] = $exam_mark_first_preparatory;
            $data['annualMarkInfo'] = $exam_mark_annual;
            $data['total_attendance_percentage'] = $total_attendance_percentage;
            $data['subject_attendance'] = $subject_attendance;
            $data['subject_code'] = $subjects_code;
            $data['studentInfo'] = $student;
            // $data['studentFamilyInfo'] = $this->student->getStudentFamilyInfoById($row_id);
            // $data['studentImage'] = $this->student->getStudentImageById($row_id);
            $date_to = $this->input->post('date_to');
            $date_from = $this->input->post('date_from');
            $data['remarksInfo'] = $this->student->getRemarksDataSingle($row_id,$filter);
            $data['remarkNameInfo'] = $this->settings->getRemarkNameInfo();
            if($this->role == ROLE_TEACHING_STAFF){
                $filter['staff_id'] = $this->staff_id;
            }
            if (empty($date_from)){
                $filter['date_from'] = date('Y-m-d', strtotime('2024-06-01'));
                $data['date_from'] = date('d-m-Y', strtotime('01-06-2024'));
            }else {
                $filter['date_from'] = date('Y-m-d', strtotime($date_from));
                $data['date_from'] = date('d-m-Y', strtotime($date_from));
            }
            if (!empty($date_to)) {
                $filter['date_to'] = date('Y-m-d', strtotime($date_to .' +1 day'));
                $data['date_to'] = date('d-m-Y', strtotime($date_to));
            }
            $data['notifications'] = $this->push_notification_model->getStudentIndividualNotificationsforView($filter,$row_id);
            $data['stdFeePaymentInfo'] = $this->pay->getStudentOverallFeePaymentInfo($student->row_id,CURRENT_YEAR);
            $data['bill_model'] = $this->pay;
            $data['deptPaidInfo'] = $this->pay->getGovtFeePaidInfo($student->row_id,CURRENT_YEAR);
            $data['classYearInfo'] = $this->student->getStudentClassYearInfo($row_id);
            $data['active'] = '';
            $data['examTypeInfo'] = $this->settings->getExamTypeInfo();
            $data['examModel'] = $this->exams;
            $this->global['pageTitle'] = ''.TAB_TITLE.' : View Student Details';
            $this->loadViews("students/viewStudent", $this->global, $data, null);
        }
    }

    public function editStudent($row_id = null) {
        if($this->isAdmin() == TRUE  ){
            $this->loadThis();
        } else {
            if ($row_id == null) {
                redirect('studentDetails');
            }
            $data['studentInfo'] = $this->student->getStudentInfoById($row_id);
            $data['religionInfo'] = $this->settings->getAllReligionInfo();
            $data['nationalityInfo'] = $this->settings->getAllNationalityInfo();
            // $data['stateInfo'] = $this->student_model->getStateInfo();
            $data['casteInfo'] = $this->settings->getAllCasteInfo();
            $data['categoryInfo'] = $this->settings->getAllCategoryInfo();
            // $data['motherTongueInfo'] = $this->student->getMotherTongueInfo();
            $data['streamInfo'] = $this->student->getAllStreamName();
            $data['routeInfo'] = $this->transport->getTransportNameInfo();
            $data['transport'] = $this->transport;
            $data['intakeYearInfo'] = $this->student->getIntakeYearInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit Student Details';
            $this->loadViews("students/editStudent", $this->global, $data, null);
        }
    }

    public function updateStudent(){
        if($this->isAdmin() == TRUE  ){
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('student_name','Student Name','trim|required');
            // $this->form_validation->set_rules('dob','DOB','trim|required');
            // $this->form_validation->set_rules('nationality','Nationality','trim|required');
            // $this->form_validation->set_rules('gender','Gender','trim|required');
            // $this->form_validation->set_rules('permanent_address','Permanent Address','trim|required');
            $row_id = $this->input->post('row_id');
            $application_no = $this->input->post('application_no');
            $family_id = $this->input->post('family_id');
            if($this->form_validation->run() == FALSE) {
                redirect('editStudent/'.$row_id);  
            } else {
            //    $image_path = "";
            //     $config = [
            //         'upload_path' => './upload/',
            //         'allowed_types' => 'jpg|png|jpeg',
            //         'max_size' => '2048',
            //         'overwrite' => TRUE,
            //         'file_ext_tolower' => TRUE
            //     ];
            //     $this->load->library('upload', $config);
            //     if ($this->upload->do_upload()) {
            //         $post = $this->input->post();
            //         $data = $this->upload->data();
            //         $image_path = base_url("upload/" . $data['raw_name'] . $data['file_ext']);
            //         $post['image_path'] = $image_path;
            //         $imgdata = file_get_contents($image_path);
            //     }


            //  $image_path = '';
            // $config = [
            //     'upload_path' => './upload/',
            //     'allowed_types' => 'jpg|png|jpeg',
            //     'max_size' => '5120',
            //     'overwrite' => TRUE,
            //     'file_ext_tolower' => TRUE
            // ];

            // $this->load->library('upload', $config);

            // if ($this->upload->do_upload('userfile')) {
            //     $data = $this->upload->data();
            //     $image_path = base_url("upload/" . $data['raw_name'] . $data['file_ext']);
            // } else {
            //     // Use existing image if new one is not uploaded
            //     $image_path = $this->input->post('existing_image');
            // }
            //     // $post = $this->input->post();
            //     $post['photo_url'] = $image_path;

           $image_path = '';
            $student_id = $this->input->post('admission_no'); // or your student_id field

            if (!is_dir('./upload/student_photo/')) {
                mkdir('./upload/student_photo/', 0755, TRUE);
            }

            $config = [
                'upload_path'       => './upload/student_photo/',
                'allowed_types'     => 'jpg|png|jpeg',
                'max_size'          => '5120',
                'overwrite'         => TRUE,
                'file_ext_tolower'  => TRUE,
                'file_name'         => $student_id  // renames file to student_id
            ];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('userfile')) {
                $data = $this->upload->data();
                $image_path = base_url("upload/student_photo/" . $data['raw_name'] . $data['file_ext']);
            } else {
                // Try to find existing photo by student_id in folder
                $extensions = ['jpg', 'jpeg', 'png'];
                foreach ($extensions as $ext) {
                    $file = './upload/student_photo/' . $student_id . '.' . $ext;
                    if (file_exists($file)) {
                        $image_path = base_url("upload/student_photo/" . $student_id . '.' . $ext);
                        break;
                    }
                }
            }

                $student_name = ucwords(strtolower($this->security->xss_clean($this->input->post('student_name'))));
               $application_no = $this->security->xss_clean($this->input->post('application_no'));
                $gender = $this->security->xss_clean($this->input->post('gender'));
                $nationality = $this->security->xss_clean($this->input->post('nationality'));
                $religion = $this->security->xss_clean($this->input->post('religion'));
                $category = $this->security->xss_clean($this->input->post('category'));
                $mother_tongue = $this->security->xss_clean($this->input->post('mother_tongue'));
                $blood_group = $this->security->xss_clean($this->input->post('blood_group'));
                $present_address = $this->security->xss_clean($this->input->post('present_address'));
                $permanent_address = $this->security->xss_clean($this->input->post('permanent_address'));
                $caste = $this->security->xss_clean($this->input->post('caste'));
                $is_handicapped = $this->security->xss_clean($this->input->post('is_handicapped'));
                $is_dyslexic = $this->security->xss_clean($this->input->post('is_dyslexic'));
                $dob = $this->security->xss_clean($this->input->post('dob'));
                $sub_caste = $this->security->xss_clean($this->input->post('sub_caste'));
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                $route = $this->input->post('route');
                $routeII = $this->input->post('routeII');
                
                $father_name = $this->security->xss_clean($this->input->post('father_name'));
                $father_educational_qualification = $this->security->xss_clean($this->input->post('father_educational_qualification'));
                $father_profession = $this->security->xss_clean($this->input->post('father_profession'));
                $father_annual_income = $this->security->xss_clean($this->input->post('father_annual_income'));
                $father_mobile = $this->security->xss_clean($this->input->post('father_mobile'));
                $father_email = $this->security->xss_clean($this->input->post('father_email'));
                $admission_status =$this->security->xss_clean($this->input->post('admission_status'));
                $intake_year =$this->security->xss_clean($this->input->post('intake_year'));
                $register_no =$this->security->xss_clean($this->input->post('register_no'));
                $aadhar_no =$this->security->xss_clean($this->input->post('aadhar_no'));

                
                $mother_name = $this->security->xss_clean($this->input->post('mother_name'));
                $mother_educational_qualification = $this->security->xss_clean($this->input->post('mother_educational_qualification'));
                $mother_profession = $this->security->xss_clean($this->input->post('mother_profession'));
                $mother_annual_income = $this->security->xss_clean($this->input->post('mother_annual_income'));
                $mother_mobile = $this->security->xss_clean($this->input->post('mother_mobile'));
                $mother_email = $this->security->xss_clean($this->input->post('mother_email'));
                $district = $this->security->xss_clean($this->input->post('district'));
                $taluk = $this->security->xss_clean($this->input->post('taluk'));
                $state = $this->security->xss_clean($this->input->post('state'));
                $native_place =$this->security->xss_clean($this->input->post('native_place'));
                $pincode =$this->security->xss_clean($this->input->post('pincode'));
                $pincode =$this->security->xss_clean($this->input->post('pincode'));
                $admission_no =$this->security->xss_clean($this->input->post('admission_no'));

                if(!empty($dob)) {
                    $dob = date('Y-m-d',strtotime($dob));
                } else {
                    $dob = "";
                }
                if(!empty($image_path)){
                    $studentInfo['photo_url'] = $image_path;

                }
              
                $studentInfo = array(
                    'student_name' => $student_name,
                    'application_no' => $application_no,
                    'admission_no' => $admission_no,
                    'dob' => $dob,
                    'gender' => $gender,
                    'register_no' => $register_no,
                    'aadhar_no' => $aadhar_no,
                    'nationality' => $nationality,
                    'religion' => $religion, 
                    'category' => $category,
                    'caste' => $caste,
                    'mother_tongue' => $mother_tongue, 
                    'sub_caste' => $sub_caste, 
                    'blood_group'=> $blood_group,
                    'present_address'=> $present_address,
                    'permanent_address' => $permanent_address,
                    'Is_physically_challenged' => $is_handicapped,
                    'is_dyslexic' => $is_dyslexic,
                    'father_name' => $father_name,
                    'father_educational_qualification'=> $father_educational_qualification,
                    'father_profession'=> $father_profession,
                    'father_annual_income' => $father_annual_income,
                    'father_mobile' => $father_mobile,
                    'father_email' => $father_email,
                    'mother_name' => $mother_name,
                    'mother_educational_qualification'=> $mother_educational_qualification,
                    'mother_profession'=> $mother_profession,
                    'mother_annual_income' => $mother_annual_income,
                    'mother_mobile' => $mother_mobile,
                    'mother_email' => $mother_email,
                    'mobile' => $mobile,
                    'place_of_birth' => $native_place,
                    'district' => $district,
                    'state' => $state,
                    'taluk' => $taluk,
                    'pincode' => $pincode,
                    'route_id' => $route,
                    // 'student_id' => $application_no,
                    'route_id_II' => $routeII,
                    'admission_status' =>$admission_status,
                    'intake_year' =>$intake_year,
                    'updated_by'=>$this->staff_id, 
                    'updated_date_time'=>date('Y-m-d H:i:s'),
                    'photo_url' => $image_path
                );

                // if(!empty($application_no)){
                //     $studentInfo['student_id'] = $application_no;
                // }
                    // if(!empty($image_path)){
                    //     $studentInfo['photo_url'] = $image_path;
    
                    // }

                  //  log_message('debug','as'.print_r($studentInfo['photo_url'],true));

                $result = $this->student->updateStudentInfo($studentInfo,$row_id);
               
                $studentAcademicInfo = array(
                    'application_no' => $application_no,
                    // 'student_id' => $application_no,
                    'admission_no' => $admission_no,
                    'updated_by'=>$this->staff_id, 
                    'updated_date_time'=>date('Y-m-d H:i:s'));
                
                if(!empty($application_no)){
                    $studentAcademicInfo['student_id'] = $application_no;
                }
                
                $result_1 = $this->student->updateAcademicInfo($studentAcademicInfo,$row_id);
                

                if($result > 0) {
                    $this->session->set_flashdata('success', 'Student Updated Successfully');
                } else {
                    $this->session->set_flashdata('error', 'Student Update failed');
                }
                redirect('editStudent/'.$row_id);  
            }
        }
    }

    public function updateStudentAcademicInfo(){
        if($this->isAdmin() == TRUE  ){
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
            $application_no = $this->input->post('application_no');
            $this->form_validation->set_rules('term_name','Term','trim|required');
            $this->form_validation->set_rules('elective_sub', 'Elective Subject', 'trim|required');
            if($this->form_validation->run() == FALSE) {
                redirect('editStudent/'.$row_id);  
            } else {
               $student_id = $this->security->xss_clean($this->input->post('student_id'));
                $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
                $program_name = $this->security->xss_clean($this->input->post('program_name'));
                $term_name = $this->security->xss_clean($this->input->post('term_name'));
                $elective_sub = strtoupper($this->security->xss_clean($this->input->post('elective_sub')));
                $section_name = $this->security->xss_clean($this->input->post('section_name'));
                $register_no = $this->security->xss_clean($this->input->post('register_no'));
                $hall_ticket_no = $this->security->xss_clean($this->input->post('hall_ticket_no'));
                $date_of_admission = $this->security->xss_clean($this->input->post('date_of_admission'));
                $doj = $this->security->xss_clean($this->input->post('doj'));
                $sat_number = $this->security->xss_clean($this->input->post('sat_number'));
                $medium = $this->security->xss_clean($this->input->post('medium'));
                $application_number = $this->security->xss_clean($this->input->post('application_number'));
                
                if(!empty($date_of_admission)) {
                    $date_of_admission = date('Y-m-d',strtotime($date_of_admission));
                } else {
                    $date_of_admission = "";
                }

                if(!empty($doj)) {
                    $doj = date('Y-m-d',strtotime($doj));
                } else {
                    $doj = "";
                }

                
                $studentStudentInfo = array(
                    'application_no' => $application_number,
                    'elective_sub' => $elective_sub,
                    // 'student_id' => $application_number,
                    'section_name' => $section_name,
                    'pu_board_number' => $register_no,
                    'term_name' => $term_name,
                    'stream_name' => $stream_name,
                    'hall_ticket_no' => $hall_ticket_no,
                    'date_of_admission' => $date_of_admission,
                    'doj' => $doj,
                    'sat_number' => $sat_number,
                    'program_name' => $program_name,
                    'medium' => $medium,
                    'updated_by'=>$this->staff_id, 
                    'updated_date_time'=>date('Y-m-d H:i:s'));

                    if(!empty($application_number)){
                        $studentStudentInfo['student_id'] = $application_number;
                    }

                    $result = $this->student->updateStudentInfo($studentStudentInfo,$row_id);

                $studentAcademicInfo = array(
                    'application_no' => $application_number,
                    // 'student_id' => $application_number,
                    'term_name' => $term_name,
                    'stream_name' => $stream_name,
                    'section_name' => $section_name,
                    'program_name' => $program_name,
                    'elective_sub' => $elective_sub,
                    'updated_by'=>$this->staff_id, 
                    'updated_date_time'=>date('Y-m-d H:i:s'));

                    if(!empty($application_number)){
                        $studentAcademicInfo['student_id'] = $application_number;
                    }
                
                $result_1 = $this->student->updateAcademicInfo($studentAcademicInfo,$row_id);
                

                if($result > 0) {
                    $yearwiseInfo = array(
                        'class' => $term_name,
                        'section' => $section_name,
                        'stream' => $stream_name,
                        'updated_by' => $this->staff_id, 
                        'updated_date_time' =>date('Y-m-d H:i:s'));
        
                    $this->student->updateStudentInfoYearWise($yearwiseInfo,$row_id);
                    $this->session->set_flashdata('success', 'Student Academic Info Updated Successfully');
                } else {
                    $this->session->set_flashdata('error', 'Student Update failed');
                }
                redirect('editStudent/'.$row_id);  
            }
        }
    }

    public function deleteStudent(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $studentInfo = array('is_deleted' => 1,'updated_by'=>$this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->student->updateStudentInfo($studentInfo, $row_id);
            // log_message('debug','data'.$result);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function restoreStudent(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $studentInfo = array('is_deleted' => 0,'updated_by'=>$this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->student->updateStudentInfo($studentInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

      //student Promotion
    public function promoteStudent(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $filter = array();
            $students = json_decode(stripslashes($this->input->post('student_id')));
       
            foreach($students as $student_id){  
                $data_students = $this->student->getStudentById($student_id);
                $studentId = $data_students->row_id;
                $studentInfo = array(
                    'intake_year_id' => '2021',
                    'term_name' => 'II PUC',
                    'updated_by'=>$this->staff_id, 
                    'updated_date_time'=>date('Y-m-d H:i:s'));
              
                $result = $this->student->updateStudentInfo($studentInfo,$studentId);
            }
            if ($result > 0) {
                $this->session->set_flashdata('success', 'Student Promoted successfully');
            } else {
                $this->session->set_flashdata('error', 'Promotion failed');
            }
            redirect('studentDetails');
        }
    }

    
    function studentAlumniInfo() {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $filter = array();
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $by_name = $this->security->xss_clean($this->input->post('by_name'));
            $application_no = $this->security->xss_clean($this->input->post('application_no'));
            $by_dob = $this->security->xss_clean($this->input->post('by_dob'));
            $by_term = $this->security->xss_clean($this->input->post('by_term'));
            $by_stream = $this->security->xss_clean($this->input->post('by_stream'));
            $by_Section = $this->security->xss_clean($this->input->post('by_Section'));
            $year = $this->input->post('admission_year');

            $data['student_id'] = $student_id;
            $data['application_no'] = $application_no;
            $data['by_name'] = $by_name;
            $data['by_term'] = $by_term;
            $data['by_stream'] = $by_stream;
            $data['by_Section'] = $by_Section;

            $filter['student_id'] = $student_id;
            $filter['application_no'] = $application_no;
            $filter['by_name'] = $by_name;
            $filter['by_term'] = $by_term;
            $filter['by_stream'] = $by_stream;
            $filter['by_Section'] = $by_Section;
            $filter['year'] = $year;

            if(!empty($by_dob)){
                $filter['by_dob'] = date('Y-m-d',strtotime($by_dob));
                $data['by_dob'] = date('d-m-Y',strtotime($by_dob));
            }else{
                $data['by_dob'] = '';
            }
            $data['streamInfo'] = $this->student->getAllStreamName();
            $count = $this->student->getAlumniStudentCount($filter);
            $returns = $this->paginationCompress("studentAlumniInfo/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['studentInfo'] = $this->student->getAlumniStudentInfo($filter);
            $data['accessInfo'] = $this->getCurrentAccess();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Alumni Student';
            $this->loadViews("students/studentAlumni", $this->global,$data, NULL);

        }
    }
    function studentInactiveInfo() {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $filter = array();
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $by_name = $this->security->xss_clean($this->input->post('by_name'));
            $application_no = $this->security->xss_clean($this->input->post('application_no'));
            $by_dob = $this->security->xss_clean($this->input->post('by_dob'));
            $by_term = $this->security->xss_clean($this->input->post('by_term'));
            $by_stream = $this->security->xss_clean($this->input->post('by_stream'));
            $by_Section = $this->security->xss_clean($this->input->post('by_Section'));
            $year = $this->input->post('admission_year');

            $data['student_id'] = $student_id;
            $data['application_no'] = $application_no;
            $data['by_name'] = $by_name;
            $data['by_term'] = $by_term;
            $data['by_stream'] = $by_stream;
            $data['by_Section'] = $by_Section;

            $filter['student_id'] = $student_id;
            $filter['application_no'] = $application_no;
            $filter['by_name'] = $by_name;
            $filter['by_term'] = $by_term;
            $filter['by_stream'] = $by_stream;
            $filter['by_Section'] = $by_Section;
            $filter['year'] = $year;

            if(!empty($by_dob)){
                $filter['by_dob'] = date('Y-m-d',strtotime($by_dob));
                $data['by_dob'] = date('d-m-Y',strtotime($by_dob));
            }else{
                $data['by_dob'] = '';
            }
            $data['streamInfo'] = $this->student->getAllStreamName();
            $count = $this->student->getInactiveStudentCount($filter);
            $returns = $this->paginationCompress("studentInactiveInfo/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['studentInfo'] = $this->student->getInactiveStudentInfo($filter);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Inactive Student';
            $this->loadViews("students/studentInactive", $this->global,$data, NULL);

        }
    }

    //getting single student info for tc
    public function getStudentById() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }else{        
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $studentInfo = $this->student->getStudentById($student_id);
            echo json_encode($studentInfo);
            exit(0);
        }
    }

    //add tc information from office staff
    public function addNewTcInfo(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }else{
            $this->load->library('form_validation');
            $this->form_validation->set_rules('leaving_date','Leaving Date','trim|required');
            $this->form_validation->set_rules('qualified_status','Qualified Status','trim|required');
            // $this->form_validation->set_rules('reason_unqualified','Reason Unqualified','trim|required');
            $this->form_validation->set_rules('belong_sc_st','Belong SC or ST','trim|required');
            // $this->form_validation->set_rules('college_due_status','College Due Status','required');
            $this->form_validation->set_rules('character','Character and Conduct','trim|required');
            //$this->form_validation->set_rules('last_studied','College Last studied','trim|required');  
        }

        // if($this->form_validation->run() == FALSE) {
        //     $this->getAllstudents();
        // } else {
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $leaving_date = $this->security->xss_clean($this->input->post('leaving_date'));
            $qualified_status = $this->security->xss_clean($this->input->post('qualified_status'));
            $reason_unqualified = $this->security->xss_clean($this->input->post('reason_unqualified'));
            $belong_sc_st = $this->security->xss_clean($this->input->post('belong_sc_st'));
          //  $last_studied = $this->security->xss_clean($this->input->post('last_studied'));
            $admission_date = $this->security->xss_clean($this->input->post('admission_date'));
            $caste = $this->security->xss_clean($this->input->post('caste'));
            $college_due_status = "YES";
            $character = $this->security->xss_clean($this->input->post('character'));
            $leaving_date = date("Y-m-d", strtotime($leaving_date));
            // $appliedYear =  date('Y');
            $appliedYear =  CURRENT_YEAR;
            $admissionDate = date("Y-m-d", strtotime($admission_date));

            $isExists = $this->student->checkTCNumberExists($student_id,$appliedYear);
            if($isExists == 0){ 
                $appliedID = $this->student->getStudentTCAppliedLastRowId($appliedYear);
                if(empty($appliedID)){
                    $tc_id = 0;
                    $tcNumber = sprintf("%04d", ++$tc_id);
                    $tc_number = TC_NAME.'/'.$appliedYear.'/'.$tcNumber;
                }else{
                    $tc_id = array_pop(explode('/', $appliedID->tc_number));
                    $tcNumber = sprintf("%04d", ++$tc_id);
                    $tc_number = TC_NAME.'/'.$appliedYear.'/'.$tcNumber;
                }
            }else{
                $tc_number = $isExists->tc_number;
            }
            $status = $this->student->checkStudentTCAppliedStatus($student_id);
            $tcInfo = array('student_id'=> $student_id,
                'leaving_date'=>$leaving_date,
                'is_promoted'=>$qualified_status,
                'is_belongs_sc_st'=>$belong_sc_st,
              //  'last_studied'=>$last_studied,
                'is_cleared_college_due'=>$college_due_status,
                'character_conduct'=>$character,
                'tc_number'=>$tc_number,
                'applied_year'=>$appliedYear,
                'created_by'=>$this->staff_id,
                'updated_by'=>$this->staff_id,
                'reason_unqualified'=>$reason_unqualified,
                'updated_date_time'=>date('Y-m-d H:i:s'),
                'created_date_time'=>date('Y-m-d H:i:s'));

        
            $studentInfo = array('student_id'=> $student_id,
                'date_of_admission'=>$admissionDate,
                'caste'=>$caste,
                'tc_taken_status'=> 1,
                'is_active'=> 0,
                'updated_date_time'=>date('Y-m-d H:i:s'),
                'created_date_time'=>date('Y-m-d H:i:s'));

            if($status == 1){
                $result = $this->student->updateTcInfo($tcInfo, $student_id);
                $studentsInfo = $this->student->getStudentByStudentId($student_id);
                $result_one = $this->student->updateStudentTcStatusInfo($studentInfo, $student_id);
                $yearWiseInfo = array('discontinued_status' => 1,'updated_by'=>$this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
                $this->student->updateStudentActiveInfo($yearWiseInfo, $studentsInfo->row_id);
                if($result == TRUE){
                    echo 'Successfully Updated student TC Information';
                }else{
                    echo 'Update Failed';
                }
            }else{
                $studentsInfo = $this->student->getStudentByStudentId($student_id);
                $result = $this->student->addStudentTcInfo($tcInfo);
                $result_one = $this->student->updateStudentTcStatusInfo($studentInfo, $student_id);
                $yearWiseInfo = array('discontinued_status' => 1,'updated_by'=>$this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
                $this->student->updateStudentActiveInfo($yearWiseInfo, $studentsInfo->row_id);
                if($result > 0) {
                    echo 'Successfully Added student TC Information';
                } else {
                    echo 'Failed to add TC info';
                } 
            }
        // }
    }
    public function getStudentTcInfo(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }else{        
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $studentTcInfo = $this->student->getStudentTcInfoById($student_id);
            echo json_encode($studentTcInfo);
            exit(0);
        }
    }

    //student applied tc list  
    function getStudentAppliedForTc() {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $filter = array();
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $student_name = $this->security->xss_clean($this->input->post('student_name'));
            $application_no = $this->security->xss_clean($this->input->post('application_no'));
            $by_dob = $this->security->xss_clean($this->input->post('by_dob'));
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
            $section_name = $this->security->xss_clean($this->input->post('section_name'));
            $register_no = $this->security->xss_clean($this->input->post('register_no'));
            $tc_number = $this->security->xss_clean($this->input->post('tc_number'));
            $year = $this->input->post('admission_year');
            $by_date = $this->security->xss_clean($this->input->post('by_date'));

            $data['student_id'] = $student_id;
            $data['application_no'] = $application_no;
            $data['student_name'] = $student_name;
            $data['term_name'] = $term_name;
            $data['stream_name'] = $stream_name;
            $data['section_name'] = $section_name;
            $data['register_no'] = $register_no;
            $data['tc_number'] = $tc_number;

            $filter['student_id'] = $student_id;
            $filter['application_no'] = $application_no;
            $filter['student_name'] = $student_name;
            $filter['term_name'] = $term_name;
            $filter['stream_name'] = $stream_name;
            $filter['section_name'] = $section_name;
            $filter['register_no'] = $register_no;
            $filter['tc_number'] = $tc_number;
            // $filter['year'] = $year;

            //   if(!empty($year)){
            //     $filter['year'] = $year;
               
            // }else{
            //      $data['year'] = CURRENT_YEAR;
            //      $filter['year'] = CURRENT_YEAR;
            // }

            if(empty($year)) {
                $filter['year'] = CURRENT_YEAR;
                 $data['year'] = CURRENT_YEAR;
            }else {
                $filter['year']  = $year;
                 $data['year'] = $year;

            }

            if(!empty($by_date)){
                $filter['by_date'] = date('Y-m-d',strtotime($by_date));
                $data['by_date'] = date('d-m-Y',strtotime($by_date));
            }else{
                $data['by_date'] = '';
            }
            $data['streamInfo'] = $this->student->getAllStreamName();
            $count = $this->student->getStudentsDetailsForTcCount($filter);
            $returns = $this->paginationCompress("getStudentAppliedForTc/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['studentTcInfo'] = $this->student->getStudentsDetailsForTC($filter);
            $data['accessInfo'] = $this->getCurrentAccess();
            $data['TcYear'] = $this->student->getTcYear();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Student Details';
            $this->loadViews("students/viewAppliedStudentTC", $this->global,$data, NULL);

        }
    }

    // get student info for TC Print
    public function getStudentsTcInfoById(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }else{     
            $filter = array();
            $student_id = $this->security->xss_clean($this->input->get('student_id'));
            $student_id = base64_decode(urldecode($student_id));
            $student_id = json_decode(stripslashes($student_id));
            $filter['student_id'] = $student_id;
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Transfer Certificate';
            $data['studentInfo'] = $this->student->getStudentsTcInfoById($filter);
            $mpdf = new \Mpdf\Mpdf(['default_font' => 'timesnewroman', 'format' => 'A4-L']);
            $mpdf->AddPage('P','','','','',10,10,8,8,8,8);
            $mpdf->SetTitle('Transfer Certificate');
            $html = $this->load->view('students/viewStdTC',$data,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('Transfer_Certificate.pdf', 'I');
            $tcOrignalInfo = array('is_original' => 1,'updated_by'=>$this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->student->updatePDFTcToOriginal($student_id,$tcOrignalInfo);
        }
    } 

    // study certificate
    public function generateStudyCertificate($student_id = null){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            if($student_id == null){
                $student_id = $this->security->xss_clean($this->input->get('student_id'));
                $student_id = base64_decode(urldecode($student_id));
                $student_id = json_decode(stripslashes($student_id));
            }
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Student Study Certificate';
            $data['studentsRecords'] = $this->student->getStudentMarksSheetByStudentId($student_id);
            $this->loadViews("students/generateStudyCertificate", $this->global, $data, null);
        }
    }

    // conduct certificate
    public function generateConductCertificate($student_id = null){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            if($student_id == null){
                $student_id = $this->security->xss_clean($this->input->get('student_id'));
                $student_id = base64_decode(urldecode($student_id));
                $student_id = json_decode(stripslashes($student_id));
            }
            $data['studentsRecords'] = $this->student->getStudentMarksSheetByStudentId($student_id);
            // log_message('debug', 'sdfedf... to student id'.print_r($data['studentsRecords'],true));
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Conduct Certificate';
            $this->loadViews("students/generateConductCertificate", $this->global, $data, null);
        }
    }

    // mark card assignment
    public function getMarkCardToPrint($student_id = null){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            if($student_id == null){
            $student_id = $this->security->xss_clean($this->input->get('student_id'));
            $student_id = base64_decode(urldecode($student_id));
            $student_id = json_decode(stripslashes($student_id));
            $exam_year = $this->input->get("exam_year");
            $data['exam_year'] = $exam_year;
            //log_message('debug', 'sql query fail in... to student id'.$student_id);
            }
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Students Marks Card To Print';
            $data['studentsRecords'] = $this->student->getStudentMarksSheetByStudentId($student_id);

            // $this->loadViews("students/generateMarkCard", $this->global, $data, null);
            
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'serif']);         
            $mpdf->curlAllowUnsafeSslRequests = true;
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->AddPage('P','','','','',10,10,12,12,15,15);
            $mpdf->SetTitle('Mark Card');
            $html = $this->load->view('students/generateMarkCard',$data,true);
            $stylesheet = file_get_contents('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');
            $mpdf->WriteHTML($stylesheet, 1); // CSS Script goes here.
            // $mpdf->SetAutoFont('kozgopromedium', '', 11, true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('Mark_Card.pdf', 'I');
        }
    }

    // UNIT TEST EXAM REPORT CARD
    public function generateUnitTestExamReportCard($student_id = null){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            if($student_id == null){
            $student_id = $this->security->xss_clean($this->input->get('student_id'));
            $student_id = base64_decode(urldecode($student_id));
            $student_id = json_decode(stripslashes($student_id));
            // $exam_year = $this->input->get("exam_year");
                $exam_type = $this->input->get("exam_type");
                $data['exam_type'] = $exam_type;
            }
            $data['studentsRecords'] = $this->student->getStudentMarksSheetByStudentId($student_id);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Students Marks Card';
            $this->loadViews("students/generateUnitTestMarkCard", $this->global, $data, null);

        }
    }



        // MID TERM REPORT CARD
        public function generateMidTermExamReportCard($student_id = null){
            if($this->isAdmin() == TRUE){
                $this->loadThis();
            }else{
                if($student_id == null){
                $student_id = $this->security->xss_clean($this->input->get('student_id'));
                $student_id = base64_decode(urldecode($student_id));
                $student_id = json_decode(stripslashes($student_id));
                // $exam_year = $this->input->get("exam_year");
                    $exam_type = $this->input->get("exam_type");
                    $data['exam_type'] = $exam_type;
                }
                $data['studentsRecords'] = $this->student->getStudentMarksSheetByStudentId($student_id);
                $this->global['pageTitle'] = ''.TAB_TITLE.' : Students Marks Card';
                $this->loadViews("students/generateMidTermMarkCard", $this->global, $data, null);
    
            }
        }
        public function generatePreparatoryExamReportCard($student_id = null){
            if($this->isAdmin() == TRUE){
                $this->loadThis();
            }else{
                if($student_id == null){
                $student_id = $this->security->xss_clean($this->input->get('student_id'));
                $student_id = base64_decode(urldecode($student_id));
                $student_id = json_decode(stripslashes($student_id));
                // $exam_year = $this->input->get("exam_year");
                    $exam_type = $this->input->get("exam_type");
                    $data['exam_type'] = $exam_type;
                }
                $data['studentsRecords'] = $this->student->getStudentMarksSheetByStudentId($student_id);
                $this->global['pageTitle'] = ''.TAB_TITLE.' : Students Marks Card';
                $this->loadViews("students/generatePreparatoryMarkCard", $this->global, $data, null);
    
            }
        }


        // mark card assignment annual depromoted 
    public function getAnnualMarkCardToPrint($student_id = null){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            if($student_id == null){
            $student_id = $this->security->xss_clean($this->input->get('student_id'));
            $student_id = base64_decode(urldecode($student_id));
            $student_id = json_decode(stripslashes($student_id));
            $exam_year = $this->input->get("exam_year");
            $data['exam_year'] = $exam_year;
            //log_message('debug', 'sql query fail in... to student id'.$student_id);
            }
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Students Detained Marks Card To Print';
            $data['studentsRecords'] = $this->student->getStudentMarksSheetByStudentId($student_id);

            // $this->loadViews("students/generateMarkCard", $this->global, $data, null);
            
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'serif']);         
            $mpdf->curlAllowUnsafeSslRequests = true;
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->AddPage('P','','','','',10,10,12,12,15,15);
            $mpdf->SetTitle('DETAINED MARKS CARD');
            $html = $this->load->view('examReport22/generateAnnualMarkCardDetained',$data,true);
            $stylesheet = file_get_contents('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');
            $mpdf->WriteHTML($stylesheet, 1); // CSS Script goes here.
            // $mpdf->SetAutoFont('kozgopromedium', '', 11, true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('DETAINED_MARKS_CARD.pdf', 'I');
        }
    }

        // mark card assignment annual depromoted 
    public function getAnnualMarkCardToPrint2022($student_id = null){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            if($student_id == null){
            $student_id = $this->security->xss_clean($this->input->get('student_id'));
            $student_id = base64_decode(urldecode($student_id));
            $student_id = json_decode(stripslashes($student_id));
            $exam_year = $this->input->get("exam_year");
            $data['exam_year'] = $exam_year;
            //log_message('debug', 'sql query fail in... to student id'.$student_id);
            }
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Students Detained Marks Card To Print';
            $data['studentsRecords'] = $this->student->getStudentMarksSheetByStudentId($student_id);

            // $this->loadViews("students/generateMarkCard", $this->global, $data, null);
            
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'serif']);         
            $mpdf->curlAllowUnsafeSslRequests = true;
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->AddPage('P','','','','',6,6,6,8,15,15);
            $mpdf->SetTitle('ANNUAL MARKS CARD');
            $html = $this->load->view('examReport22/generateAnnualMarkCard',$data,true);
            $stylesheet = file_get_contents('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');
            $mpdf->WriteHTML($stylesheet, 1); // CSS Script goes here.
            // $mpdf->SetAutoFont('kozgopromedium', '', 11, true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('ANNUAL_MARKS_CARD.pdf', 'I');
        }
    }

    
    // update student batch
    public function updateStudentBatch(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $student_id = json_decode(stripslashes($this->input->post('student_id')));
            $class_batch = $this->security->xss_clean($this->input->post('class_batch'));
            
            foreach($student_id as $std_id){           
                $std_info = array(
                    'batch'=> $class_batch,
                    'updated_by' => $this->staff_id,
                    'updated_date_time'=>date('Y-m-d H:i:s'),
                );
                $return_id = $this->student->updateStudentInfoBStdId($std_info,$std_id);
            }

            header('Content-type: text/plain'); 
            header('Content-type: application/json'); 
            echo json_encode($return_id);
            exit(0); 
        }
    }
    

    public function downloadStudentExcelReport(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
            setcookie('isDownLoaded',1);  
        }else{
            $filter = array();
            $preference = $this->security->xss_clean($this->input->post('preference'));
            $term = $this->security->xss_clean($this->input->post('term'));
            $academic_year = $this->security->xss_clean($this->input->post('academic_year'));
            $gender = $this->security->xss_clean($this->input->post('gender'));
            $religion = $this->security->xss_clean($this->input->post('religion'));
            $fields = $this->security->xss_clean($this->input->post('fields'));
            $status = $this->security->xss_clean($this->input->post('status'));
            $report_type = $this->security->xss_clean($this->input->post('report_type'));

            if(!empty($term)){
                $filter['term'] = $term;
                $data['term'] = $term;
            }
            if(!empty($academic_year)){
                $filter['academic_year'] = $academic_year;
                $data['academic_year'] = $academic_year;
            }
            if($gender == 'ALL'){
                $filter['gender'] = "";
                $data['gender'] = 'ALL';
                $gender_name = 'ALL';
            }else{
                $filter['gender'] = $gender;
                $data['gender'] = $gender;
                $gender_name = $gender;
            }
            if($religion == 'ALL'){
                $filter['religion'] = "";
                $data['religion'] = 'ALL';
                $religion_name = 'ALL';
            }else{
                $filter['religion'] = $religion;
                $data['religion'] = $religion;
                $religion_name = $religion;
            }

            $date = date('Y');
            if($preference == 'ALL'){
                $preferences = array('PCMB','PCMC','EBAC','HEPS','HEBA','ESBA');
            }else{
                $preferences = array($preference);   
            }

            
            $total_fields = count($fields);
            $curr_year = date('Y');
            if($report_type == "VIEW"){
            // Build data for the view
            $allSheets = [];
            foreach($preferences as $pref){
                $filter['preference'] = $pref;
                $filter['status'] = $status;
                $students = $this->student->getStudentInfoForReportDownload($filter);
                $allSheets[] = [
                    'term' => $term,
                    'preference' => $pref,
                    'gender' => $gender_name,
                    'religion' => $religion_name,
                    'curr_year' => $curr_year,
                    'fields' => $fields,
                    'students' => $students
                ];
            }
            $data['allSheets'] = $allSheets;
            $data['excel_title'] = defined('EXCEL_TITLE') ? EXCEL_TITLE : 'Student Report';

            // Render view as HTML
            $html = $this->load->view('students/student_excel_report_view', $data, true);
            setcookie('isDownLoaded',1);
            // Output as PDF using mPDF
            $mpdf = new \Mpdf\Mpdf(['default_font' => 'serif']);
            $mpdf->SetTitle('Student Report Preview');
            $mpdf->WriteHTML($html);
            $mpdf->Output('Student_Report_Preview.pdf', 'I'); // Preview in browser
        }else{
            $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        
            for($sheet = 0; $sheet < count($preferences); $sheet++){
                $this->excel->setActiveSheetIndex($sheet);
                $activeSheet = $this->excel->getActiveSheet();

                // Name the worksheet
                $activeSheet->setTitle($preferences[$sheet]);
                $activeSheet->getPageSetup()->setPrintArea('A1:G500');
                $activeSheet->setCellValue('A1', EXCEL_TITLE);
                $activeSheet->setCellValue('A2', $term.' '.$preferences[$sheet].' INFORMATION '.'-'.$gender.'-'.$religion.'-'.$curr_year);
                $activeSheet->getColumnDimension('A')->setAutoSize(true);

                $activeSheet->getStyle('A1')->getFont()->setSize(18);
                $activeSheet->getStyle('A2')->getFont()->setSize(14);
                $activeSheet->mergeCells('A1:'.$cellName[$total_fields].'1');
                $activeSheet->mergeCells('A2:'.$cellName[$total_fields].'2');
                $activeSheet->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $activeSheet->getStyle('A1:'.$cellName[$total_fields].'2')->getFont()->setBold(true);

                $activeSheet->getColumnDimension('C')->setWidth(18);
                $activeSheet->getColumnDimension('E')->setWidth(25);
                $activeSheet->getColumnDimension('F')->setWidth(25);
                $activeSheet->getColumnDimension('G')->setWidth(25);
                $activeSheet->getColumnDimension('H')->setWidth(10);
                $activeSheet->getColumnDimension('I')->setWidth(10);
                $activeSheet->getColumnDimension('J')->setWidth(10);
                $activeSheet->getColumnDimension('K')->setWidth(20);
                $activeSheet->getColumnDimension('L')->setWidth(20);
                $activeSheet->getColumnDimension('M')->setWidth(10);
                $activeSheet->getColumnDimension('N')->setWidth(10);
                $activeSheet->getColumnDimension('O')->setWidth(10);
                $activeSheet->getColumnDimension('P')->setWidth(10);
                $activeSheet->getColumnDimension('Q')->setWidth(10);

                $excel_row = 3;
                $activeSheet->setCellValue('A3', 'SL No.');

                for($h = 1; $h <= $total_fields; $h++){
                    $activeSheet->setCellValue($cellName[$h].$excel_row, $fields[$h-1]);   
                }
                $activeSheet->getStyle('A3:'.$cellName[$total_fields].'3')->getAlignment()->setWrapText(true); 
                $activeSheet->getStyle('A3:'.$cellName[$total_fields].'3')->getFont()->setBold(true); 
                $activeSheet->getStyle('A3:'.$cellName[$total_fields].'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                $activeSheet->getStyle('A1:'.$cellName[$total_fields].$total_fields)->applyFromArray($styleBorderArray);

                $filter['preference'] = $preferences[$sheet];
                $filter['status'] = $status;
                $students = $this->student->getStudentInfoForReportDownload($filter);

                $j = 1;
                $excel_row = 4;

                foreach($students as $student){
                    $activeSheet->setCellValue('A'.$excel_row, $j++);
                    for($c = 1; $c <= $total_fields; $c++){
                        if($fields[$c-1] == 'dob'){
                            $activeSheet->setCellValue($cellName[$c].$excel_row, date("d-m-Y", strtotime($student->dob)));
                        }else if($fields[$c-1] == 'student_name'){
                            $activeSheet->setCellValue($cellName[$c].$excel_row, strtoupper($student->student_name));
                        }else if($fields[$c-1] == 'doj'){
                            if($student->doj != '1970-01-01' && $student->doj != '0000-00-00' && $student->doj != ''){
                                $doj = date("d-m-Y", strtotime($student->doj));
                            }else{
                                $doj = '';
                            }
                            $activeSheet->setCellValue($cellName[$c].$excel_row, $doj);
                        }else{
                            $activeSheet->setCellValueExplicit($cellName[$c].$excel_row, $student->{$fields[$c-1]}, PHPExcel_Cell_DataType::TYPE_STRING);
                        } 
                    }
                    $activeSheet->getStyle('A'.$excel_row.':'.$cellName[$total_fields].$excel_row)->applyFromArray($styleBorderArray);
                    $activeSheet->getStyle('A'.$excel_row.':B'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $activeSheet->getStyle('D'.$excel_row.':'.$cellName[$total_fields].$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel_row++;
                }

                // Loop through all columns
               foreach (range('A', $activeSheet->getHighestColumn()) as $col) {
                    $activeSheet->getColumnDimension($col)->setAutoSize(true);
                }

                // Auto row height
                $activeSheet->getDefaultRowDimension()->setRowHeight(-1);

                $this->excel->createSheet(); 
            }
            $filename =  $term.'_Report_'.$preference.'-'.$date.'.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            ob_start();
            setcookie('isDownLoaded',1);  
            $objWriter->save("php://output");
         }
        }
    }  

   
// public function downloadStudentExcelReport(){
//     if($this->isAdmin() == TRUE){
//         $this->loadThis();
//         setcookie('isDownLoaded',1);  
//     }else{
//         $filter = array();
//         $preference = $this->security->xss_clean($this->input->post('preference'));
//         $term = $this->security->xss_clean($this->input->post('term'));
//         $academic_year = $this->security->xss_clean($this->input->post('academic_year'));
//         $gender = $this->security->xss_clean($this->input->post('gender'));
//         $religion = $this->security->xss_clean($this->input->post('religion'));
//         $fields = $this->security->xss_clean($this->input->post('fields'));
//         $status = $this->security->xss_clean($this->input->post('status'));
//         $report_type = $this->security->xss_clean($this->input->post('report_type'));

//         // ... your filter logic as before ...
//             if(!empty($term)){
//                 $filter['term'] = $term;
//                 $data['term'] = $term;
//             }
//             if(!empty($academic_year)){
//                 $filter['academic_year'] = $academic_year;
//                 $data['academic_year'] = $academic_year;
//             }
//             if($gender == 'ALL'){
//                 $filter['gender'] = "";
//                 $data['gender'] = 'ALL';
//                 $gender_name = 'ALL';
//             }else{
//                 $filter['gender'] = $gender;
//                 $data['gender'] = $gender;
//                 $gender_name = $gender;
//             }
//             if($religion == 'ALL'){
//                 $filter['religion'] = "";
//                 $data['religion'] = 'ALL';
//                 $religion_name = 'ALL';
//             }else{
//                 $filter['religion'] = $religion;
//                 $data['religion'] = $religion;
//                 $religion_name = $religion;
//             }

//         $date = date('Y');
//         if($preference == 'ALL'){
//             $preferences = array('PCMB','PCMC','EBAC','HEPS','HEBA','EBAS');
//         }else{
//             $preferences = array($preference);   
//         }

//         $total_fields = count($fields);
//         $curr_year = date('Y');

//         // Build the HTML table for PDF preview
//         $html = '';
//         if($report_type == "VIEW"){
//             $html .= '<h2 style="text-align:center;">'.EXCEL_TITLE.'</h2>';
//         }

//         for($sheet = 0; $sheet < count($preferences); $sheet++){
//             $filter['preference'] = $preferences[$sheet];
//             $filter['status'] = $status;
//             $students = $this->student->getStudentInfoForReportDownload($filter);

//             if($report_type == "VIEW"){
//                 $html .= '<h3 style="text-align:center;">'.$term.' '.$preferences[$sheet].' INFORMATION - '.$gender.'-'.$religion.'-'.$curr_year.'</h3>';
//                 $html .= '<table border="1" cellpadding="5" cellspacing="0" style="width:100%;border-collapse:collapse;">';
//                 $html .= '<tr><th>SL No.</th>';
//                 foreach($fields as $field){
//                     $html .= '<th>'.htmlspecialchars($field).'</th>';
//                 }
//                 $html .= '</tr>';
//                 $j = 1;
//                 foreach($students as $student){
//                     $html .= '<tr>';
//                     $html .= '<td style="text-align:center;">'.$j++.'</td>';
//                     foreach($fields as $field){
//                         $value = '';
//                         if($field == 'dob' && !empty($student->dob)){
//                             $value = date("d-m-Y", strtotime($student->dob));
//                         }else if($field == 'student_name'){
//                             $value = strtoupper($student->student_name);
//                         }else if($field == 'doj'){
//                             if($student->doj != '1970-01-01' && $student->doj != '0000-00-00' && $student->doj != ''){
//                                 $value = date("d-m-Y", strtotime($student->doj));
//                             }
//                         }else{
//                             $value = isset($student->{$field}) ? $student->{$field} : '';
//                         }
//                         $html .= '<td style="text-align:center;">'.htmlspecialchars($value).'</td>';
//                     }
//                     $html .= '</tr>';
//                 }
//                 $html .= '</table><br><br>';
//             } else {
//                 // Excel logic as before
//                 $this->excel->setActiveSheetIndex($sheet);
//                 $activeSheet = $this->excel->getActiveSheet();
//                 $activeSheet->setTitle($preferences[$sheet]);
//                 $activeSheet->setCellValue('A1', EXCEL_TITLE);
//                 $activeSheet->setCellValue('A2', $term.' '.$preferences[$sheet].' INFORMATION '.'-'.$gender.'-'.$religion.'-'.$curr_year);
//                 $activeSheet->getStyle('A1')->getFont()->setSize(18);
//                 $activeSheet->getStyle('A2')->getFont()->setSize(14);
//                 $activeSheet->mergeCells('A1:' . PHPExcel_Cell::stringFromColumnIndex($total_fields) . '1');
//                 $activeSheet->mergeCells('A2:' . PHPExcel_Cell::stringFromColumnIndex($total_fields) . '2');
//                 $activeSheet->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                 $activeSheet->getStyle('A1:' . PHPExcel_Cell::stringFromColumnIndex($total_fields) . '2')->getFont()->setBold(true);

//                 $excel_row = 3;
//                 $activeSheet->setCellValue('A3', 'SL No.');
//                 for($h = 1; $h <= $total_fields; $h++){
//                     $colName = PHPExcel_Cell::stringFromColumnIndex($h);
//                     $activeSheet->setCellValue($colName . $excel_row, $fields[$h-1]);   
//                 }
//                 $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
//                 $activeSheet->getStyle('A1:' . PHPExcel_Cell::stringFromColumnIndex($total_fields) . $total_fields)->applyFromArray($styleBorderArray);

//                 $j = 1;
//                 $excel_row = 4;
//                 foreach($students as $student){
//                     $activeSheet->setCellValue('A'.$excel_row, $j++);
//                     for($c = 1; $c <= $total_fields; $c++){
//                         $colName = PHPExcel_Cell::stringFromColumnIndex($c);
//                         if($fields[$c-1] == 'dob'){
//                             $activeSheet->setCellValue($colName . $excel_row, date("d-m-Y", strtotime($student->dob)));
//                         }else if($fields[$c-1] == 'student_name'){
//                             $activeSheet->setCellValue($colName . $excel_row, strtoupper($student->student_name));
//                         }else if($fields[$c-1] == 'doj'){
//                             if($student->doj != '1970-01-01' && $student->doj != '0000-00-00' && $student->doj != ''){
//                                 $doj = date("d-m-Y", strtotime($student->doj));
//                             }else{
//                                 $doj = '';
//                             }
//                             $activeSheet->setCellValue($colName . $excel_row, $doj);
//                         }else{
//                             $activeSheet->setCellValueExplicit($colName . $excel_row, $student->{$fields[$c-1]}, PHPExcel_Cell_DataType::TYPE_STRING);
//                         } 
//                     }
//                     $excel_row++;
//                 }
//                 // Auto-size columns
//                 for($col = 0; $col <= $total_fields; $col++){
//                     $colName = PHPExcel_Cell::stringFromColumnIndex($col);
//                     $activeSheet->getColumnDimension($colName)->setAutoSize(true);
//                 }
//                 $activeSheet->getDefaultRowDimension()->setRowHeight(-1);
//                 $this->excel->createSheet(); 
//             }
//         }

//         if($report_type == "VIEW"){
//             // Output as PDF using mPDF
//             $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'serif']);
//             $mpdf->curlAllowUnsafeSslRequests = true;
//             $mpdf->autoScriptToLang = true;
//             $mpdf->autoLangToFont = true;
//             $mpdf->SetTitle('Student Report Preview');
//             $mpdf->WriteHTML($html);
//             $mpdf->Output('Student_Report_Preview.pdf', 'D'); // Preview in browser
//         } else {
//             $filename =  $term.'_Report_'.$preference.'-'.$date.'.xls';
//             header('Content-Type: application/vnd.ms-excel');
//             header('Content-Disposition: attachment;filename="'.$filename.'"');
//             header('Cache-Control: max-age=0');
//             $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
//             ob_start();
//             setcookie('isDownLoaded',1);  
//             $objWriter->save("php://output");
//         }
//     }
// }

    // get student quick info

    public function getAllCurrentStudents(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $data['studentInfo'] = $this->student->getAllStudentsInfo();
            // log_message('debug','dne=='.print_r($data['studentInfo'],true));
            header('Content-type: text/plain'); 
            // set json non IE
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        }
    }

    // Student hall ticket - first puc
    // public function getFirstYearStudentHallTicket($student_id = null,$exam_name = null){
    //     if($this->isAdmin() == TRUE){
    //         $this->loadThis();
    //     }else{
    //         $filter = array();
    //         if($student_id == null){
    //             $student_id = $this->security->xss_clean($this->input->get('student_id'));
    //             $examType = base64_decode($this->input->get('exam_name'));
    //             $student_id = base64_decode(urldecode($student_id));
    //             $student_id = json_decode(stripslashes($student_id));
    //             $filter['student_id'] = $student_id;
    //         }
    //         $examType = base64_decode($this->input->get('exam_name'));
    //         $students = $this->student->getStdInfoByStudentId($filter);
    //         $data['examData'] = $this->student;
              
    //         $data['examType'] = $examType;
    //         $data['studentsRecords'] = $students;
    //         // log_message('debug','students-->'.print_r($students,true));

    //         $this->global['pageTitle'] = ''.TAB_TITLE.' : Hall Ticket';
    //         $this->loadViews("office/firstYearHallTicket", $this->global, $data, null);
    //     }
    // }


    public function getFirstYearStudentHallTicket($student_id = null, $exam_name = null)
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $filter = [];

            if ($student_id == null) {
                $student_id = $this->security->xss_clean($this->input->get('student_id'));
                $examType = base64_decode($this->input->get('exam_name'));

                $student_id = base64_decode(urldecode($student_id));
                $student_id = json_decode(stripslashes($student_id));

                $filter['student_id'] = $student_id;
            }

            $examType = base64_decode($this->input->get('exam_name'));
            $students = $this->student->getStdInfoByStudentId($filter);

            $data['examData'] = $this->student;
            $data['examType'] = $examType;
            $data['studentsRecords'] = $students;

           $mpdf = new \Mpdf\Mpdf([
                'format' => 'A5',
                'orientation' => 'P',
                'default_font' => 'timesnewroman',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10,
                'tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf'
            ]);
            $mpdf->SetTitle('Hall Ticket');

            // Render view
            $html = $this->load->view('office/firstYearHallTicket', $data, true);

            $mpdf->WriteHTML($html);
            $mpdf->Output('Hall_Ticket.pdf', \Mpdf\Output\Destination::INLINE);
        }
    }

    // Student hall ticket - second puc
    public function getSecondYearStudentHallTicket(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $student_id = $this->security->xss_clean($this->input->get('student_id'));
            $examType = $this->security->xss_clean($this->input->get('examType'));
            $student_id = base64_decode(urldecode($student_id));
            $student_id = json_decode(stripslashes($student_id));
            $students= $this->student->getStudentsInfoForPrintMarkCard($student_id,'II_PUC');
            // $students= $this->students_model->getSecondYearStudentInfoByStudentIdBioData($student_id);

            $subjects = $this->getSubjectCodes($students[0]->stream_name);
            $data['studentsRecords'] = $students;
            $data['labSubjects'] = $this->student->getSubjectsForHallTicketPrint($subjects);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Hall Ticket';
            $this->loadViews("office/secondYearHallTicket", $this->global, $data, null);
        }
    }

    public function generateExcellenciaCertificate($student_id = null){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            if($student_id == null){
                $student_id = $this->security->xss_clean($this->input->get('student_id'));
                $student_id = base64_decode(urldecode($student_id));
                $student_id = json_decode(stripslashes($student_id));
            }
            $data['studentsRecords'] = $this->student->getStudentMarksSheetByStudentId($student_id);
            $this->global['pageTitle'] = 'SchoolPhins-LPUC : Students Excellence Certificate To Print';
            $this->loadViews("students/generateExcellenciaCertificate", $this->global, $data, null);
        }
    }

    public function getStudentBiodata(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
          
            $student_id = $this->security->xss_clean($this->input->get('student_id'));
            $student_id = base64_decode(urldecode($student_id));
            $student_id = json_decode(stripslashes($student_id));
            
            $this->global['pageTitle'] = 'SchoolPhins-LPUC : Students Bio-Data To Print';
            $data['studentsRecords'] = $this->student->getStudentMarksSheetByStudentId($student_id);
            $this->loadViews("students/getStudentBiodata", $this->global, $data, null);
        }
    }


           // mark card assignment annual depromoted 
    public function getSupplementaryMarkPrint2022($student_id = null){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            if($student_id == null){
            $student_id = $this->security->xss_clean($this->input->get('student_id'));
            $student_id = base64_decode(urldecode($student_id));
            $student_id = json_decode(stripslashes($student_id));
            $exam_year = $this->input->get("exam_year");
            $data['exam_year'] = $exam_year;
            //log_message('debug', 'sql query fail in... to student id'.$student_id);
            }
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Students Detained Marks Card To Print';
            $data['studentsRecords'] = $this->student->getStudentMarksSheetByStudentId($student_id);

            // $this->loadViews("students/generateMarkCard", $this->global, $data, null);
            
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'serif']);         
            $mpdf->curlAllowUnsafeSslRequests = true;
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->AddPage('P','','','','',6,6,6,8,15,15);
            $mpdf->SetTitle('SUPPLEMENTARY MARKS CARD');
            $html = $this->load->view('examReport22/generateSupplementaryMarkCard',$data,true);
            $stylesheet = file_get_contents('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');
            $mpdf->WriteHTML($stylesheet, 1); // CSS Script goes here.
            // $mpdf->SetAutoFont('kozgopromedium', '', 11, true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('SUPPLEMENTARY_MARKS_CARD.pdf', 'I');
        }
    }


     //Course Register Listing



     public function getAllCourseRegisterInfo(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $filter = array();
            $student_id = $this->input->post('student_id');
            $student_name = $this->security->xss_clean($this->input->post('student_name'));
            $course_name = $this->security->xss_clean($this->input->post('course_name'));
            $amount = $this->security->xss_clean($this->input->post('amount'));
              
            $data['by_student_id'] = $student_id;
            $data['student_name'] = $student_name;
            $data['course_name'] = $course_name;
            $data['amount'] = $amount;
             
            $filter['by_student_id']= $student_id;
            $filter['student_name']= $student_name;
            $filter['course_name']= $course_name;
            $filter['amount']= $amount;
           
            $this->load->library('pagination');
            $count = $this->student->getAllCourseRegisterInfoCount($filter);
            $returns = $this->paginationCompress("getAllCourseRegisterInfo/", $count, 100);
            $data['studentCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['courseRegisterInfo'] = $this->student->getAllCourseRegisterInfo($filter);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Payment Pending Application';
            $this->loadViews("students/courseRegisterListing", $this->global, $data, null);
        }
    }
    

    public function getSubjectCodes($stream_name){
        //science
        $PCMB = array("33", "34", "35", '36');
        $PCMC = array("33", "34", "35", '41');
        $PCME = array("33", "34", "35", '40');
        $PCMS = array("33", "34", "35", '31');
        //commarce
        $BEBA = array("75", "22", "27", '30');
        $BSBA = array("75", "31", "27", '30');
        $CSBA = array("41", "31", "27", '30');
        $SEBA = array("31", "22", "27", '30');
        $CEBA = array("41", "22", "27", '30');
        $PEBA = array("29", "22", "27", '30');
        //art
        $HEPP = array("21", "22", "32", '29');
        $MEBA = array("75", "22", "27", '30');
        $MSBA = array("75", "31", "27", '30');
        $HEPS = array("21", "22", "29", '28');
        $EBAC = array("22", "27", "30", '41');
        $HEBA = array("21", "22", "27", '30');

        switch ($stream_name) {
            case "PCMB":
                return  $PCMB;
                break;
            case "PCMC":
                return $PCMC;
                break;
            case "PCME":
                return $PCME;
                break;
            case "PCMS":
                return $PCMS;
                break;
            case "PEBA":
                return $PEBA;
                break;
            case "BEBA":
                return $BEBA;
                break;
            case "BSBA":
                return $BSBA;
                break;
            case "CSBA":
                return $CSBA;
                break;
            case "SEBA":
                return $SEBA;
                break;
            case "CEBA":
                return $CEBA;
                break;
            case "HEPP":
                return $HEPP;
                break;
            case "HEPS":
                return $HEPS;
                break;
            case "MEBA":
                return $MEBA;
                break;
            case "MSBA":
                return $MSBA;
                break;
            case "EBAC":
                return $EBAC;
                break;
            case "HEBA":
                return $HEBA;
                break;
        }
    }

        //Alumni student tc list  
        function getAlumniStudentTc() {
            if($this->isAdmin() == TRUE ){
                $this->loadThis();
            } else {
                $filter = array();
                $name = $this->security->xss_clean($this->input->post('name'));
                $class = $this->security->xss_clean($this->input->post('class'));
                $register_no = $this->security->xss_clean($this->input->post('register_no'));
                $tc_number = $this->security->xss_clean($this->input->post('tc_number'));
                $by_date = $this->security->xss_clean($this->input->post('by_date'));
    
               
                $data['name'] = $name;
                $data['class'] = $class;              
                $data['register_no'] = $register_no;
                $data['tc_number'] = $tc_number;
    
                
                $filter['name'] = $name;
                $filter['class'] = $class;               
                $filter['register_no'] = $register_no;
                $filter['tc_number'] = $tc_number;
                
                
                if(!empty($by_date)){
                    $filter['by_date'] = date('Y-m-d',strtotime($by_date));
                    $data['by_date'] = date('d-m-Y',strtotime($by_date));
                }else{
                    $data['by_date'] = '';
                }
                
                $count = $this->student->getStudentsDetailsForAlumniTcCount($filter);
                $returns = $this->paginationCompress("getAlumniStudentTc/", $count, 100);
                $data['nationalityInfo'] = $this->settings->getAllNationalityInfo();
                $data['religionInfo'] = $this->settings->getAllReligionInfo();
                $data['totalCount'] = $count;
                $filter['page'] = $returns["page"];
                $filter['segment'] = $returns["segment"];
                $data['studentTcInfo'] = $this->student->getAluminiStudentsDetailsForTC($filter);
                $this->global['pageTitle'] = ''.TAB_TITLE.' : Student Details';
                $this->loadViews("students/viewAlumniStudentTC", $this->global,$data, NULL);
    
            }
        }


        public function addAlumniStudentTCInfo(){
            if($this->isAdmin() == TRUE  ){
                $this->loadThis();
            } else {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('name','Student Name','trim|required');
                $this->form_validation->set_rules('dob','DOB','trim|required');
               
                if($this->form_validation->run() == FALSE) {
                    redirect('getAlumniStudentTc/');  
                } else {
                    
                    
                    $roll_no = $this->security->xss_clean($this->input->post('roll_no'));
                    $nationality = $this->security->xss_clean($this->input->post('nationality'));
                    $religion = $this->security->xss_clean($this->input->post('religion'));
                    $name = $this->security->xss_clean($this->input->post('name'));
                    $dob = $this->security->xss_clean($this->input->post('dob'));
                    $mother_name = $this->security->xss_clean($this->input->post('mother_name'));

                    $father_name = $this->security->xss_clean($this->input->post('father_name'));
                    $date_of_admission = $this->security->xss_clean($this->input->post('date_of_admission'));
                    $date_of_leaving = $this->security->xss_clean($this->input->post('date_of_leaving'));
                    $class = $this->security->xss_clean($this->input->post('class'));
                    $language_subject = $this->security->xss_clean($this->input->post('language_subject'));
                    $optional_subject = $this->security->xss_clean($this->input->post('optional_subject'));
                    $medium = $this->security->xss_clean($this->input->post('medium'));

                    $qualified_status = $this->security->xss_clean($this->input->post('qualified_status'));
                    $reason_unqualified = $this->security->xss_clean($this->input->post('reason_unqualified'));                    

                    $register_no = $this->security->xss_clean($this->input->post('register_no'));
                    $belong_sc_st = $this->security->xss_clean($this->input->post('belong_sc_st'));
                    $fee_due = $this->security->xss_clean($this->input->post('fee_due'));
                    $character = $this->security->xss_clean($this->input->post('character'));   
                    $tc_number = $this->security->xss_clean($this->input->post('tc_number'));        
                    $remarks = $this->security->xss_clean($this->input->post('remarks'));           
                    $appliedYear =  CURRENT_YEAR;
                    
                    if(!empty($dob)) {
                        $dob = date('Y-m-d',strtotime($dob));
                    } else {
                        $dob = "";
                    }
                    for($i=0;$i<count($optional_subject);$i++){
                        $subjects.= $optional_subject[$i].',';
                    }
                    for($i=0;$i<count($language_subject);$i++){
                        $language.= $language_subject[$i].',';
                    }
                 
                           
                    // $isExists = $this->student->checkAlumniTCNumberExists($roll_no,$appliedYear);
                    // if($isExists == 0){ 
                    //     $appliedID = $this->student->getAlumniStudentTCAppliedLastRowId($appliedYear);
                    //     if(empty($appliedID)){
                    //         $tc_id = 0;
                    //         $tcNumber = sprintf("%04d", ++$tc_id);
                    //         $tc_number = 'LPUC/'.$appliedYear.'/'.$tcNumber;
                    //     }else{
                    //         $tc_id = array_pop(explode('/', $appliedID->tc_number));
                    //         $tcNumber = sprintf("%04d", ++$tc_id);
                    //         $tc_number = 'LPUC/'.$appliedYear.'/'.$tcNumber;
                    //     }
                    // }else{
                    //     $tc_number = $isExists->tc_number;
                    // }
                    $studentInfo = array(
                        'tc_number'=>$tc_number,
                        'roll_no' => $roll_no,
                        'name' => $name,
                        'dob' => $dob,
                        'nationality' => $nationality,
                        'religion' => $religion, 
                        'father_name' => $father_name,
                        'mother_name' => $mother_name,
                        'date_of_admission' => $date_of_admission, 
                        'date_of_leaving' => $date_of_leaving, 
                        'class'=> $class,
                        'language_subject'=> $language,
                        'optional_subject' => $subjects,
                        'medium' => $medium,
                        'qualified_status' => $qualified_status,
                        'reason_unqualified'=>$reason_unqualified,
                        'register_no' => $register_no,
                        'belong_sc_st'=> $belong_sc_st,
                        'fee_due'=> $fee_due,
                        'conduct_character' => $character,
                        'applied_year'=>$appliedYear,
                        'remarks'=>$remarks,
                        'updated_by'=>$this->staff_id, 
                        'created_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->student->AddAluminiStudentTCInfo($studentInfo);
                    
                    if($result > 0) {
                        $this->session->set_flashdata('success', 'Student Details Successfully');
                    } else {
                        $this->session->set_flashdata('error', 'Student Update failed');
                    }
                    redirect('getAlumniStudentTc/');  
                }
            }
        }


            // get student info for TC Print
    public function getAlumniStudentsTcInfoById(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }else{     
            $row_id = $this->security->xss_clean($this->input->get('row_id'));
            $row_id = base64_decode(urldecode($row_id));
            $row_id = json_decode(stripslashes($row_id));
            $data['studentInfo'] = $this->student->getAlumniStudentsTcInfoById($row_id); 
            log_message('debug','dadaaa--'.print_r($data['studentInfo'],true));
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Transfer Certificate'; 
            $this->loadViews("students/viewAlumniStudentTCprint", $this->global,$data, NULL);
           
        }
    } 

    public function getAlumniStudentTcInfo(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{          
            $row_id = $this->security->xss_clean($this->input->post('row_id'));
            $studentTcInfo = $this->student->getAlumniStudentsTcInfoById($row_id);
            log_message('debug','dataa'.print_r($studentTcInfo ,true));
            echo json_encode($studentTcInfo);
            exit(0);
        }
    }
    

    function getCertificate()
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {
            $filter = array();
           
            $request_sub = $this->security->xss_clean($this->input->post('request_sub'));
            $request_issue = $this->security->xss_clean($this->input->post('request_issue'));
            $request_certificate = $this->security->xss_clean($this->input->post('request_certificate'));
            $student_row_id = $this->security->xss_clean($this->input->post('student_row_id'));
            $enrolment_no = $this->security->xss_clean($this->input->post('enrolment_no'));
            $student_name = $this->security->xss_clean($this->input->post('student_name'));
            
            $data['student_row_id'] = $filter['student_row_id'] = $student_row_id;
            $data['student_name'] = $filter['student_name'] = $student_name;
            $data['enrolment_no'] = $filter['enrolment_no'] = $enrolment_no;
            $data['request_sub']  = $filter['request_sub'] = $request_sub;
            $data['request_issue']  = $filter['request_issue'] = $request_issue;
            $data['request_certificate']  = $filter['request_certificate'] = $request_certificate;
            $data['certificateData'] = $this->student->getCertificateInfo($request_certificate);
            
            $count = $this->student->getAllRequestFormInfoCount($filter);
            $returns = $this->paginationCompress("getCertificate/", $count, 100);
            $data['RecordsCount'] = $count;
            $data['studentRecords'] = $this->student->getAllRequestFormInfo($filter,$returns["page"], $returns["segment"]);
            $data['studentInfo'] = $this->student->studentData();
            $data['certificateInfo'] = $this->student->certificateNames();
            $data['accessInfo'] = $this->getCurrentAccess();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Request Form Details';
            $this->loadViews("students/requestCertificate", $this->global,$data, NULL);

        }
    }

    public function addStudentRequestForm(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('request_sub','Request Subject','trim|required');
            $this->form_validation->set_rules('request_certificate','Request Certificate Number','trim|required');
            $this->form_validation->set_rules('request_issue','Request Issue','trim|required');
            $this->form_validation->set_rules('student_row_id','student row id','trim|required');
            if($this->form_validation->run() == FALSE) {
                $this->getCertificate();
            } else {
                $request_sub = $this->security->xss_clean($this->input->post('request_sub'));
                $request_certificate = $this->security->xss_clean($this->input->post('request_certificate'));
                $request_issue = $this->security->xss_clean($this->input->post('request_issue'));
                $student_row_id = $this->security->xss_clean($this->input->post('student_row_id'));
                $college_from = $this->security->xss_clean($this->input->post('college_from'));
                $college_to = $this->security->xss_clean($this->input->post('college_to'));
                $classes_from = $this->security->xss_clean($this->input->post('classes_from'));
                $classes_to = $this->security->xss_clean($this->input->post('classes_to'));
                $progress = $this->security->xss_clean($this->input->post('progress'));
                if($request_certificate == 2){
                    $requestInfo = array(
                        'student_row_id' => $student_row_id,
                        'request_sub' => $request_sub,
                        'certificate_Id' => $request_certificate,
                        'issue' => $request_issue,
                        'college_from' => $college_from,
                        'college_to' => $college_to,
                        'classes_from' => $classes_from,
                        'classes_to' => $classes_to,
                        'progress' => $progress,
                        'created_by' => $this->staff_id,
                        'created_date_time' =>date('Y-m-d H:i:s')
                    );
                    $return_id = $this->student->addStudentRequestForm($requestInfo);
                }else{
                    $requestInfo = array(
                        'student_row_id' => $student_row_id,
                        'request_sub' => $request_sub,
                        'certificate_Id' => $request_certificate,
                        'issue' => $request_issue,
                        'created_by' => $this->staff_id,
                        'created_date_time' =>date('Y-m-d H:i:s')
                    );
                    $return_id = $this->student->addStudentRequestForm($requestInfo);
                }
                
                if($return_id > 0){
                    $this->session->set_flashdata('success', 'New Request Data Added Successfully');
                }else{
                    $this->session->set_flashdata('error', 'New Request Data failed to add');
                }
                redirect('getCertificate');
            }
        }
    }

    public function checkCertificateName(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }else{        
            $student_id = json_decode(stripslashes($this->input->post('student_id')));
            $data['certificateName'] = $this->student->getInfoForCertificate($student_id);
          
            header('Content-type: text/plain'); 
            // set json non IE
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        }
    }


    function addNewStudent() {
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE ){
            $this->loadThis();
        } else {
           // $data['termInfo'] = $this->student->getTermInfo();
             $data['religionInfo'] = $this->settings->getAllReligionInfo();
            $data['nationalityInfo'] = $this->settings->getAllNationalityInfo();
            $data['casteInfo'] = $this->settings->getAllCasteInfo();
            $data['categoryInfo'] = $this->settings->getAllCategoryInfo();
            $data['streamInfo'] = $this->student->getAllStreamName();
            $data['yearInfo'] = $this->settings->getStudentIntakeYearInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Add New Student';
            $this->loadViews("students/addStudentNew", $this->global,$data, NULL);
        }
    }


    public function addStudentInfoToDB(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
            $this->form_validation->set_rules('student_name','Student Name','trim|required');
            // $this->form_validation->set_rules('dob','DOB','required'); 
            $this->form_validation->set_rules('gender','Gender','required');
            $this->form_validation->set_rules('term_name','Term Name','trim|required');
            //$this->form_validation->set_rules('date_of_admission','Date of Admission','required');
            // $this->form_validation->set_rules('admission_no','Admission No','required'); 
            $this->form_validation->set_rules('father_name', 'Father Name', 'trim|required');
            $this->form_validation->set_rules('mother_name', 'Mother Name', 'trim|required');
            $this->form_validation->set_rules('father_mobile_one','Father Mobile','required|numeric|min_length[10]');
            $this->form_validation->set_rules('mother_mobile_one','Mother Mobile','required|numeric|min_length[10]');
            // $this->form_validation->set_rules('permanent_address', 'Permanent Address', 'trim|required');
            // $this->form_validation->set_rules('present_address', 'Present Address', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $this->studentDetails();
            } else {
                $image_path = "";
                $config = [
                    'upload_path' => './upload/',
                    'allowed_types' => 'gif|jpg|png',
                    'overwrite' => TRUE,
                ];
                $this->load->library('upload', $config);
                if ($this->upload->do_upload()) {
                    $post = $this->input->post();
                    $data = $this->upload->data();
                    $image_path = base_url("upload/" . $data['raw_name'] . $data['file_ext']);
                    $post['image_path'] = $image_path;
                }  
                $student_name = ucwords(strtolower($this->security->xss_clean($this->input->post('student_name'))));
                $term_name =$this->security->xss_clean($this->input->post('term_name'));
                $application_no =$this->security->xss_clean($this->input->post('application_no'));
                $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
                $gender = $this->security->xss_clean($this->input->post('gender'));
                $father_name = $this->security->xss_clean($this->input->post('father_name'));
                $father_mobile_one = $this->security->xss_clean($this->input->post('father_mobile_one'));
                $mother_name = $this->security->xss_clean($this->input->post('mother_name'));
                $mother_mobile_one = $this->security->xss_clean($this->input->post('mother_mobile_one'));
                $intake_year =$this->security->xss_clean($this->input->post('intake_year'));
                $elective_sub =$this->security->xss_clean($this->input->post('elective_sub'));
                // $section_name =$this->security->xss_clean($this->input->post('section_name'));
                // $sat_number =$this->security->xss_clean($this->input->post('sat_number'));
                // $student_id =$this->security->xss_clean($this->input->post('student_id'));
                // $admission_no =$this->security->xss_clean($this->input->post('admission_no'));
                // $date_of_admission =$this->security->xss_clean($this->input->post('date_of_admission'));
                // $nationality = $this->security->xss_clean($this->input->post('nationality_name'));
                // $religion_name = $this->security->xss_clean($this->input->post('religion_name'));
                // $category_name = $this->security->xss_clean($this->input->post('category_name'));
                // $mother_tongue = $this->security->xss_clean($this->input->post('mother_tongue'));
                // $present_address = $this->security->xss_clean($this->input->post('present_address'));
                // $permanent_address = $this->security->xss_clean($this->input->post('permanent_address'));
                // $dob = $this->security->xss_clean($this->input->post('dob'));
                // $father_email = $this->security->xss_clean($this->input->post('father_email'));
                // $father_aadhar = $this->security->xss_clean($this->input->post('father_aadhar'));
                // $father_profession = $this->security->xss_clean($this->input->post('father_profession'));
                // $mother_email = $this->security->xss_clean($this->input->post('mother_email'));
                // $mother_aadhar = $this->security->xss_clean($this->input->post('mother_aadhar'));
                // $mother_profession = $this->security->xss_clean($this->input->post('mother_profession'));
                // $blood_group = $this->security->xss_clean($this->input->post('blood_group'));
                // $email = $this->security->xss_clean($this->input->post('email'));
                // $aadhar_no = $this->security->xss_clean($this->input->post('aadhar_no'));
                // $house_name_id = $this->security->xss_clean($this->input->post('house_name_id'));
                // $previous_class = $this->security->xss_clean($this->input->post('previous_class'));
                // $caste = $this->security->xss_clean($this->input->post('caste'));
                // $sub_caste = $this->security->xss_clean($this->input->post('sub_caste'));
                // $guardian_name = $this->security->xss_clean($this->input->post('guardian_name'));
                // $guardian_mobile_no = $this->security->xss_clean($this->input->post('guardian_mobile_no'));
                // $guardian_email = $this->security->xss_clean($this->input->post('guardian_email'));
                // $doctor_name = $this->security->xss_clean($this->input->post('doctor_name'));
                // $doctor_mobile = $this->security->xss_clean($this->input->post('doctor_mobile'));
                // $allergies = $this->security->xss_clean($this->input->post('allergies'));
                // $chronic_ailment = $this->security->xss_clean($this->input->post('chronic_ailment'));
                // $history_of_surgeries = $this->security->xss_clean($this->input->post('history_of_surgeries'));
                // $other_health_issues = $this->security->xss_clean($this->input->post('other_health_issues'));
                // $name_for_emergency = $this->security->xss_clean($this->input->post('name_for_emergency'));
                // $emergency_mobile = $this->security->xss_clean($this->input->post('emergency_mobile'));
                // $relation_type = $this->security->xss_clean($this->input->post('relation_type'));
                // $place_of_birth =$this->security->xss_clean($this->input->post('place_of_birth'));
                // $district =$this->security->xss_clean($this->input->post('district'));
                // $taluk =$this->security->xss_clean($this->input->post('taluk'));
                // $state =$this->security->xss_clean($this->input->post('state'));
                // $bank_name =$this->security->xss_clean($this->input->post('bank_name'));
                // $bank_account_no =$this->security->xss_clean($this->input->post('bank_account_no'));
                // $branch_name =$this->security->xss_clean($this->input->post('branch_name'));
                // $ifsc_code =$this->security->xss_clean($this->input->post('ifsc_code'));
                // $parent_annual_income = $this->security->xss_clean($this->input->post('parent_annual_income'));
                // $no_of_dependent = $this->security->xss_clean($this->input->post('no_of_dependent'));
                // $previous_school = $this->security->xss_clean($this->input->post('previous_school'));
                // $previous_class = $this->security->xss_clean($this->input->post('previous_class'));
                // $previous_tc_no = $this->security->xss_clean($this->input->post('previous_tc_no'));
                // $tc_date = $this->security->xss_clean($this->input->post('tc_date'));
                // $village_name = $this->security->xss_clean($this->input->post('village_name'));
                // $pu_board_number =$this->security->xss_clean($this->input->post('pu_board_number'));
                // $hall_ticket_number =$this->security->xss_clean($this->input->post('hall_ticket_number'));
                // $father_annual_income =$this->security->xss_clean($this->input->post('father_annual_income'));
                // $mother_annual_income =$this->security->xss_clean($this->input->post('mother_annual_income'));
                // $father_qualification = $this->security->xss_clean($this->input->post('father_qualification'));
                // $mother_qualification = $this->security->xss_clean($this->input->post('mother_qualification'));
                // $is_handicapped = $this->security->xss_clean($this->input->post('is_handicapped'));
                // $is_dyslexic = $this->security->xss_clean($this->input->post('is_dyslexic'));
                // $type = $this->input->post('type');
                // $admission_status =$this->security->xss_clean($this->input->post('admission_status'));
                // $program_name =$this->security->xss_clean($this->input->post('program_name'));
                // $register_no =$this->security->xss_clean($this->input->post('register_no'));
                // if($admission_status == 1){
                //     $intake_year = '2025-26';
                // }
                // if($term_name == 'I PUC'){
                //     $intake_year_id = '2025';
                // }else{
                //     $intake_year_id = '2024';
                // }
                $programInfo = $this->student->getProgramNameByStream($stream_name);
                $program_name = $programInfo->program_name;
                if (!empty($intake_year)) {
                    $parts = explode('-', $intake_year);
                    $intake_year_id = $parts[0];
                } else {
                    $intake_year_id = null;
                }
                //     $exist = $this->student->isStudentIDExists($student_id);
                //     if(!empty($exist)){
                //         $this->session->set_flashdata('error', 'Student ID already exists!');
                //         redirect('addNewStudent');
                //     }
                // else{
                $studentInfo = array(
                    'student_name'=>$student_name,
                    'term_name'=>$term_name,
                    'stream_name' => $stream_name,
                    'gender'=>$gender,
                    'application_no'=>$application_no,
                    'student_id'=>$application_no,
                    'father_name'=>$father_name,
                    'father_mobile'=>$father_mobile_one,
                    'mother_name'=>$mother_name,
                    'mother_mobile'=>$mother_mobile_one,
                    // 'dob' => date('Y-m-d',strtotime($dob)),
                    // 'student_id' =>$student_id,
                    // 'date_of_admission' =>date('Y-m-d',strtotime($date_of_admission)),
                    // 'admission_no'=>$admission_no,
                    // 'sat_number'=>$sat_number,
                    // 'section_name'=>$section_name,
                    // 'blood_group'=>$blood_group,
                    // 'email'=>$email,
                    // 'aadhar_no'=>$aadhar_no,
                    // 'caste' =>$caste,
                    // 'sub_caste' =>$sub_caste,
                    // 'nationality' =>$nationality,
                    // 'category' =>$category_name,
                    // 'religion' => $religion_name,
                    // 'mother_tongue' => $mother_tongue,
                    // 'father_email'=>$father_email,
                    // 'father_profession'=>$father_profession,
                    // 'mother_email'=>$mother_email,
                    // 'mother_profession'=>$mother_profession,
                    // 'guardian_name'=>$guardian_name,
                    // 'guardian_email'=>$guardian_email,
                    // 'permanent_address'=>$permanent_address,
                    // 'present_address'=>$present_address,
                    // 'register_no'=>$register_no,
                    // 'place_of_birth'=>$place_of_birth,
                    // 'district'=>$district,
                    // 'taluk'=>$taluk,
                    // 'district'=>$district,
                    // 'state'=>$state,
                    // 'hall_ticket_no'=>$hall_ticket_number,
                    // 'pu_board_number' =>$pu_board_number,
                    // 'father_annual_income' =>$father_annual_income,
                    // 'mother_annual_income' =>$mother_annual_income,
                    // 'father_educational_qualification' =>$father_qualification,
                    // 'mother_educational_qualification' =>$mother_qualification,
                    // 'Is_physically_challenged' =>$is_handicapped,
                    // 'is_dyslexic' =>$is_dyslexic,
                    // 'is_admitted' => $type,
                    'is_active' =>1,
                    'intake_year_id' => $intake_year_id,
                    'intake_year' =>$intake_year,
                    'program_name' =>$program_name,
                    // 'admission_status' =>$admission_status,
                    'elective_sub' =>$elective_sub,
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));
                    if(!empty($image_path)){
                        $studentInfo['photo_url'] = $image_path;
                    }  
                $result = $this->student->addStudentInfo($studentInfo);


                if($result > 0){
                    $academic_info = array(
                        'rel_student_row_id' => $result,
                        'student_id'=> $application_no,
                        'term_name' => $term_name,
                        'program_name' => $program_name,
                        'stream_name'=>$stream_name,
                        // 'section_name' => $section,
                        'elective_sub' => $elective_sub,
                        // 'admission_no'=> trim($admission_no),
                        // 'date_of_admission'=>date('Y-m-d',strtotime($doa)),
                        'is_active' => 1,
                        'is_current' => 1,
                        'created_by'=>$this->staff_id,
                        'created_date_time'=>date('Y-m-d H:i:s'));
                    
                        
                    $return_1 = $this->student->addAcademicData($academic_info);

                    $yearWiseInfo = array(
                        'stud_row_id' => $result,
                        'class' => $term_name,
                        // 'section' => $section_name,
                        'stream' => $stream_name,
                        'intake_year' => CURRENT_YEAR,
                        'created_by'=>$this->staff_id,
                        'created_date_time'=>date('Y-m-d H:i:s')
                    );
                $this->settings->addYearWiseInfo($yearWiseInfo);
                $this->session->set_flashdata('success', 'Student Info Added Successfully');
                } else {
                    $this->session->set_flashdata('error', 'Student Adding  failed');
                } 
                redirect('addNewStudent');  
            // }
            }
        }
    }

    // public function inactiveStudent(){
    //     if($this->isAdmin() == TRUE){
    //         $this->loadThis();
    //     } else {   
    //         $row_id = $this->input->post('row_id');
    //         $studentInfo = array('std_status' => 1,'updated_by'=>$this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
    //         $result = $this->student->updateStudentInfo($studentInfo, $row_id);
    //         if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
    //         $studentInfo = array('std_status' => 1,'tc_taken_status' => 1,'updated_by'=>$this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
    //         $result2 = $this->student->updateStudentInfo($studentInfo, $row_id);
    //         $yearWiseInfo = array('discontinued_status' => 1,'updated_by'=>$this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
    //         $this->student->updateStudentActiveInfo($yearWiseInfo, $row_id);
    //     } 
    // }

    public function inactiveStudent(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');

            // Update student info
            $studentInfo = array(
                'std_status' => 1,
                'updated_by' => $this->staff_id,
                'updated_date_time' => date('Y-m-d H:i:s')
            );

            $result = $this->student->updateStudentInfo($studentInfo, $row_id);

            // Update year-wise student info
            $yearWiseInfo = array(
                'discontinued_status' => 1,
                'updated_by' => $this->staff_id,
                'updated_date_time' => date('Y-m-d H:i:s')
            );

            $this->student->updateStudentActiveInfo($yearWiseInfo, $row_id);

            if ($result == true) {
                echo json_encode(array('status' => true));
            } else {
                echo json_encode(array('status' => false));
            }
        } 
    }
    

    // public function activeStudent(){
    //     if($this->isAdmin() == TRUE){
    //         $this->loadThis();
    //     } else {   
    //         $row_id = $this->input->post('row_id');
    //         $studentInfo = array('std_status' => 0,'updated_by'=>$this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
    //         $result = $this->student->updateStudentInfo($studentInfo, $row_id);
    //         if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
    //         $studentInfo = array('std_status' => 0,'tc_taken_status' => 0,'updated_by'=>$this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
    //         $result2 = $this->student->updateStudentInfo($studentInfo, $row_id);
    //         $yearWiseInfo = array('discontinued_status' => 0,'updated_by'=>$this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
    //         $this->student->updateStudentActiveInfo($yearWiseInfo, $row_id);
    //     } 
    // }

    public function activeStudent(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            // Update student info
            $studentInfo = array(
                'std_status' => 0,
                'updated_by' => $this->staff_id,
                'updated_date_time' => date('Y-m-d H:i:s')
            );
            $result = $this->student->updateStudentInfo($studentInfo, $row_id);
            // Update year-wise student info
            $yearWiseInfo = array(
                'discontinued_status' => 0,
                'updated_by' => $this->staff_id,
                'updated_date_time' => date('Y-m-d H:i:s')
            );
            $this->student->updateStudentActiveInfo($yearWiseInfo, $row_id);

            if ($result == true) {
                echo json_encode(array('status' => true));
            } else {
                echo json_encode(array('status' => false));
            }
        } 
    }



    public function deleteStudentRequestDetails(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $requestInfo = array('is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
            );
            $result = $this->student->updateRequestCertificate($requestInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }


    function viewDeletedStudents() {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $filter = array();
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $by_name = $this->security->xss_clean($this->input->post('by_name'));
            $application_no = $this->security->xss_clean($this->input->post('application_no'));
            $by_dob = $this->security->xss_clean($this->input->post('by_dob'));
            $by_term = $this->security->xss_clean($this->input->post('by_term'));
            $by_stream = $this->security->xss_clean($this->input->post('by_stream'));
            $by_Section = $this->security->xss_clean($this->input->post('by_Section'));
            $year = $this->input->post('admission_year');

            $data['student_id'] = $student_id;
            $data['application_no'] = $application_no;
            $data['by_name'] = $by_name;
            $data['by_term'] = $by_term;
            $data['by_stream'] = $by_stream;
            $data['by_Section'] = $by_Section;

            $filter['student_id'] = $student_id;
            $filter['application_no'] = $application_no;
            $filter['by_name'] = $by_name;
            $filter['by_term'] = $by_term;
            $filter['by_stream'] = $by_stream;
            $filter['by_Section'] = $by_Section;
            $filter['year'] = $year;

            if(!empty($by_dob)){
                $filter['by_dob'] = date('Y-m-d',strtotime($by_dob));
                $data['by_dob'] = date('d-m-Y',strtotime($by_dob));
            }else{
                $data['by_dob'] = '';
            }
            $data['streamInfo'] = $this->student->getAllStreamName();
            $count = $this->student->getDeletedStudentCount($filter);
            $returns = $this->paginationCompress("viewDeletedStudents/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['studentInfo'] = $this->student->getDeletedStudent($filter);
            $data['accessInfo'] = $this->getCurrentAccess();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Student Details';
            $this->loadViews("students/deletedStudents", $this->global,$data, NULL);

        }
    }

    public function getNameByStudentNumber(){
        $student_id = trim($this->input->post('student_id'));

        $filter['student_id'] =  $student_id;
        if(!empty($student_id)){
            $result = $this->student->getStudentInfoByStudentId($filter);
            if(!empty($result)) echo $result->student_name;
            // log_message('debug','info'.print_r($result->student_name,true));}
            else echo 0;
        }else echo 0;
    }

    public function getSatNumberByRowId(){
        $student_id = trim($this->input->post('rel_std_id'));
        $filter['student_id'] =  $student_id;
        if(!empty($student_id)){
            $result = $this->student->getStudentInfoByStudentIdAttendance($student_id);
            if(!empty($result)) echo $result->student_id;
            else echo 0;
        }else echo 0;
    }

    public function getStudentNameById(){
        $student_id = trim($this->input->post('rel_std_id'));
        $filter['student_id'] =  $student_id;
        if(!empty($student_id)){
            $result = $this->student->getStudentInfoByStudentIdAttendance($student_id);
            if(!empty($result)) echo $result->student_name;
            else echo 0;
        }else echo 0;
    }
    
    public function redirectStudentView(){
        $std_row_id = $this->security->xss_clean($this->input->post('std_row_id'));
        redirect('viewStudentInfoById/'.$std_row_id);
    }

    public function orginalTC(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
           
            $tcInfo = array('is_original' => 0,'updated_by'=>$this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->student->updateTcToOriginal($row_id,$tcInfo);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 

    }

    public function discontinueStudent(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $intake_year = $this->input->post('intake_year');
            $stud_row_id = $this->input->post('stud_row_id');

            $studInfo = array('discontinued_status' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            if($intake_year == CURRENT_YEAR){
              $studentInfo = array('is_active' => 0, 'updated_by'=>$this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
              $result_one = $this->student->updateStudentInfo($studentInfo,$stud_row_id);
            }
            $result = $this->student->updateStudentActiveInfoByID($studInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function continueStudent(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $intake_year = $this->input->post('intake_year');
            $stud_row_id = $this->input->post('stud_row_id');
            
            $studInfo = array('discontinued_status' => 0,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
             );
             if($intake_year == CURRENT_YEAR){
                // log_message('debug','oooooo');
                $studentInfo = array('is_active' => 1, 'updated_by'=>$this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
                $result_one = $this->student->updateStudentInfo($studentInfo,$stud_row_id);
              }
            $result = $this->student->updateStudentActiveInfoByID($studInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function getAnnualMarkCardToPrint25($student_id = null){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            if($student_id == null){
            $student_id = $this->security->xss_clean($this->input->get('student_id'));
            $student_id = base64_decode(urldecode($student_id));
            $student_id = json_decode(stripslashes($student_id));
            $exam_year = $this->input->get("exam_year");
            $data['exam_year'] = $exam_year;
            //log_message('debug', 'sql query fail in... to student id'.$student_id);
            }
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Students Annual Marks Card To Print';
            $data['studentsRecords'] = $this->student->getStudentforReportCard($student_id);
            $data['cancel_status'] = $this->transport->getStudentInformationByIdForFee($student_row_id,$year);


            // $this->loadViews("students/generateMarkCard", $this->global, $data, null);
            
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'serif']);         
            $mpdf->curlAllowUnsafeSslRequests = true;
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->AddPage('P','','','','',6,6,6,8,15,15);
            $mpdf->SetTitle('ANNUAL MARKS CARD');
            $html = $this->load->view('examReport24/generateAnnualMarkCard25',$data,true);
            $stylesheet = file_get_contents('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');
            $mpdf->WriteHTML($stylesheet, 1); // CSS Script goes here.
            // $mpdf->SetAutoFont('kozgopromedium', '', 11, true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('ANNUAL_MARKS_CARD.pdf', 'I');
        }
    }
   public function generateBusPassPDF($student_id = null)
{
    if ($this->isAdmin() == TRUE) {
        $this->loadThis();
    } else {
        if ($student_id == null) {
            $student_id = $this->security->xss_clean($this->input->get('student_id'));
            $student_id = base64_decode(urldecode($student_id));
            $student_id = json_decode(stripslashes($student_id));
            $exam_year = $this->input->get("exam_year");
            $data['exam_year'] = $exam_year;
        }

        $this->global['pageTitle'] = ''.TAB_TITLE.' : Students Detained Marks Card To Print';
        $data['studentsRecords'] = $this->student->getStudentsForBusPass($student_id);
        $data['transModel'] = $this->transport;
        $data['cancel_status'] = $this->transport->getStudentInformationByIdForFee($student_row_id, $year);

           $mpdf = new \Mpdf\Mpdf([
            'format' => A5, // A5 size in mm: width x height (landscape manually defined)
            'orientation' => 'L',   // Landscape
            'default_font' => 'timesnewroman',
            'tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf'
        ]);

        $mpdf->SetTitle('BUS PASS');

        // For each student, print on a new page
        // foreach ($data['studentsRecords'] as $record) {
            // $data['singleRecord'] = $record;

            $html = $this->load->view('transport/busPass', $data, true);
            $mpdf->AddPage('L');
            $mpdf->WriteHTML($html);
        // }

        $mpdf->Output('Bus_Pass.pdf', \Mpdf\Output\Destination::INLINE);
    }
}

     public function addRemarksInfo(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else { 

                
                $filter = array();
                $student_Id = $this->security->xss_clean($this->input->post('row_id'));
                $remarks_type_id = $this->security->xss_clean($this->input->post('remarks_type_id'));
                $date = $this->security->xss_clean($this->input->post('date'));
                $description = $this->security->xss_clean($this->input->post('description'));
                $parent_visibility = $this->security->xss_clean($this->input->post('parent_visibility'));
                $visibility_access = $this->security->xss_clean($this->input->post('visibility_access'));
                if(!empty($visibility_access)){
                  $converted_string = implode(",", $visibility_access);
                }else{
                  $converted_string = "";
                }
                $image_path="";
                $target_dir="upload/remarks/";
                if(!file_exists($target_dir)){
                    mkdir($target_dir,0777);
                }
                $config=['upload_path' => $target_dir,
                'allowed_types' => 'pdf|jpeg|jpg|png','overwrite' => TRUE,'max_size' => '2048',
                'overwrite' => TRUE,'file_ext_tolower' => TRUE];
                $this->load->library('upload', $config);
                if($this->upload->do_upload()) {
                    $post=$this->input->post();
                    $data=$this->upload->data();
                    $image_path=$target_dir.$data['raw_name'].$data['file_ext'];
                    $post['image_path'] = $image_path;
                }
                
                // $studSemInfo = $this->student->getStudentInfoByStdRowId($student_Id);
                $student = $this->student->getStudentInfoById($student_Id);

                $remarksInfo= array(
                    'student_id' => $student_Id,
                    'type_id' => $remarks_type_id,
                    'date' =>date('Y-m-d',strtotime($date)),
                    'year' => date('Y'),
                    'term_name' => $student->term_name,
                    'parent_visibility' => $parent_visibility,
                    'visibility_access' => $converted_string,
                    'file_path' => $image_path,
                    'description' => $description,
                    'created_by' => $this->staff_id,
                    'created_date_time' => date('Y-m-d H:i:s'));

                $return_id = $this->student->addRemarksInfo($remarksInfo);
                log_message('debug','remark'.print_r($remarksInfo,true));
                    
                if($return_id > 0){
                    $studInfo = $this->student->getStudentInfoById($student_Id);
                    // $this->sendNotificationForRemark($studInfo->sat_number);
                    $this->session->set_flashdata('success', 'Remarks Added Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Failed to add ');
                }
                redirect('viewStudentInfoById/'.$student_Id);  
            
            
        }
    }
    public function updateRemarkInfo(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else { 

                
                $filter = array();
                $remark_id = $this->security->xss_clean($this->input->post('remark_id'));
                $student_Id = $this->security->xss_clean($this->input->post('row_id'));
                $remarks_type_id = $this->security->xss_clean($this->input->post('remarks_type_id'));
                $date = $this->security->xss_clean($this->input->post('date'));
                $description = $this->security->xss_clean($this->input->post('description'));
                $parent_visibility = $this->security->xss_clean($this->input->post('parent_visibility'));
                $visibility_access = $this->security->xss_clean($this->input->post('visibility_access'));
                if(!empty($visibility_access)){
                    $converted_string = implode(",", $visibility_access);
                  }else{
                    $converted_string = "";
                  }

                $image_path="";
                $target_dir="upload/remarks/";
                if(!file_exists($target_dir)){
                    mkdir($target_dir,0777);
                }
                $config=['upload_path' => $target_dir,
                'allowed_types' => 'pdf|jpeg|jpg|png','overwrite' => TRUE,'max_size' => '2048',
                'overwrite' => TRUE,'file_ext_tolower' => TRUE];
                $this->load->library('upload', $config);
                if($this->upload->do_upload()) {
                    $post=$this->input->post();
                    $data=$this->upload->data();
                    $image_path=$target_dir.$data['raw_name'].$data['file_ext'];
                    $post['image_path'] = $image_path;
                }
                // $studSemInfo = $this->student->getStudentInfoByStdRowId($student_Id);
                $student = $this->student->getStudentInfoById($student_Id);
               if(!empty($image_path)){
                $remarksInfo= array(
                    'student_id' => $student_Id,
                    'type_id' => $remarks_type_id,
                    'date' =>date('Y-m-d',strtotime($date)),
                    'year' => date('Y'),
                    'file_path' => $image_path,
                    'description' => $description,
                    'parent_visibility' => $parent_visibility,
                    'visibility_access' => $converted_string,
                    'created_by' => $this->staff_id,
                    'created_date_time' => date('Y-m-d h:i:s'));
                }else{
                    $remarksInfo= array(
                        'student_id' => $student_Id,
                        'type_id' => $remarks_type_id,
                        'date' =>date('Y-m-d',strtotime($date)),
                        'year' => date('Y'),
                        'description' => $description,
                        'parent_visibility' => $parent_visibility,
                        'visibility_access' => $converted_string,
                        'created_by' => $this->staff_id,
                        'created_date_time' => date('Y-m-d h:i:s')); 
                }

                $return_id = $this->student->updateRemarkInfo($remarksInfo,$remark_id);
                    
                if($return_id > 0){
                    $studInfo = $this->student->getStudentInfoById($student_Id);
                    // $this->sendNotificationForRemark($studInfo->sat_number);
                    $this->session->set_flashdata('success', 'Remarks Updated Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Failed to Update Remarks');
                }
                redirect('viewStudentInfoById/'.$student_Id);  
        }
    }
     public function deleteStudentRemarks(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $studentInfo = array('is_deleted' => 1,'updated_by'=>$this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->student->updateRemarkInfo($studentInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
}
?>
