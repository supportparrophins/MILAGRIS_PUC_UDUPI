<?php if (!defined('BASEPATH')) {

    exit('No direct script access allowed');

}



require APPPATH . '/libraries/BaseControllerFaculty.php';



class Settings extends BaseController {

    public function __construct()

    {

        parent::__construct();

       

        //$this->load->library('excel');

        $this->load->model('staff_model','staff');

        $this->load->model('settings_model','settings');

        $this->load->model('students_model','student');

        $this->load->model('timetable_model','timetable');

        $this->load->library('excel');

        $this->isLoggedIn();

    }

    public function viewSettings(){

        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){

            $this->loadThis();

        } else {

            $filter = array();

            // $by_term = $this->security->xss_clean($this->input->post('by_term'));

            // $by_stream = $this->security->xss_clean($this->input->post('by_stream'));

            // $by_section = $this->security->xss_clean($this->input->post('by_section'));

            // if(!empty($by_term)){

            //     $filter['by_term'] = $by_term;

            //     $data['searchTerm'] = $by_term;

            // }else{

            //     $data['searchTerm'] = '';

            // }

            // if(!empty($by_stream)){

            //     $filter['by_stream'] = $by_stream;

            //     $data['searchStream'] = $by_stream;

            // }else{

            //     $data['searchStream'] = '';

            // }

            // if(!empty($by_section)){

            //     $filter['by_section'] = $by_section;

            //     $data['searchSection'] = $by_section;

            // }else{

            //     $data['searchSection'] = '';

            // } 



            $data['shiftInfo'] = $this->settings->getAllShiftInfo();

            $data['departmentInfo'] = $this->settings->getAllDepartmentInfo();

            $data['religionInfo'] = $this->settings->getAllReligionInfo();

            $data['deposittypeInfo'] = $this->settings->getAlldeposittypeInfo();

            $data['depositaccountInfo'] = $this->settings->getAlldepositaccountInfo();

            $data['nationalityInfo'] = $this->settings->getAllNationalityInfo();

            $data['casteInfo'] = $this->settings->getAllCasteInfo();

            $data['categoryInfo'] = $this->settings->getAllCategoryInfo();

            $data['postInfo'] = $this->settings->getAllPostInfo();

            // $data['streamInfo'] = $this->settings->getStreamInfo();

            // $data['sectionInfo'] = $this->settings->getSectionInfo($filter);

            // $data['classTimingsInfo'] = $this->settings->getAllClassTimingsInfo();



            $data['schoolAccountTypeInfo'] = $this->settings->getAllSchoolAccountInfo();

           // $data['feeTypeInfo'] = $this->settings->getAllFeeTypeInfo();

           $data['schoolInfo'] = $this->settings->getSchoolReceiptConfigInfo();

           $data['weekName'] = $this->timetable->getAllWeekName();

            $this->global['pageTitle'] = ''.TAB_TITLE.' : Settings';

            $this->loadViews("settings/settingsDashboard", $this->global, $data, null);  

        }

    }



    function addDepartment()

    {

        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE)

        {

            $this->loadThis();

        }  else {

            $dept_id =$this->security->xss_clean($this->input->post('dept_id'));

            $dept_name =$this->security->xss_clean($this->input->post('dept_name'));

            $isExist = $this->settings->checkDeptIdExists($dept_id);

            if($isExist > 0){

                $this->session->set_flashdata('warning', 'Department ID already exists!');

                redirect('viewSettings');

            }else{

                $departmentInfo = array('dept_id'=>$dept_id,'name'=>$dept_name);

                $result = $this->settings->addDepartment($departmentInfo);

                if($result > 0){

                    $this->session->set_flashdata('success', 'New Department created successfully');

                } else{

                    $this->session->set_flashdata('error', 'Department creation failed');

                }

                redirect('viewSettings');



            }

        }

    }



    /**

     * This function is used to add Religion Details

     */

    function addReligion()

    {

        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE)

        {

            $this->loadThis();

        }  else {

            $religion =$this->security->xss_clean($this->input->post('religion'));

                $religionInfo = array('religion_name'=>$religion,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));

                $result = $this->settings->addReligion($religionInfo);

            if($result > 0){

                $this->session->set_flashdata('success', 'New Religion created successfully');

            } else{

                $this->session->set_flashdata('error', 'Religion creation failed');

            }

            redirect('viewSettings');

        }

        

    }

    function adddeposittype()

    {

        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE)

        {

            $this->loadThis();

        }  else {

            $deposit_type =$this->security->xss_clean($this->input->post('deposit_type')); 

                $deposittypeInfo = array('deposit_type'=>$deposit_type,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));

                $result = $this->settings->adddeposittype($deposittypeInfo);

            if($result > 0){

                $this->session->set_flashdata('success', 'New Bank Deposit Type created successfully');

            } else{

                $this->session->set_flashdata('error', 'Bank Deposit Type creation failed');

            }

            redirect('viewSettings');

        }

        

    }

    
    function adddepositaccount()

    {

        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE)

        {

            $this->loadThis();

        }  else {

            $deposit_account =$this->security->xss_clean($this->input->post('deposit_account')); 

                $depositaccountInfo = array('deposit_account'=>$deposit_account,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));

                $result = $this->settings->adddepositaccount($depositaccountInfo);

            if($result > 0){

                $this->session->set_flashdata('success', 'New Bank Deposit Account created successfully');

            } else{

                $this->session->set_flashdata('error', 'Bank Deposit Account creation failed');

            }

            redirect('viewSettings');

        }

        

    }



      /**

     * This function is used to add Cast Details

     */

    function addCaste()

    {

        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE)

        {

            $this->loadThis();

        }  else {

            $caste =$this->security->xss_clean($this->input->post('caste'));

            $isExist = $this->settings->checkCasteExists($caste);

            if($isExist > 0){

                $this->session->set_flashdata('warning', 'Caste already exists!');

            }else{

                $castInfo = array('caste_name'=>$caste,

                    'created_by'=>$this->staff_id,

                    'created_date_time'=>date('Y-m-d H:i:s'));

                $result = $this->settings->addCaste($castInfo);

                if($result > 0){

                    $this->session->set_flashdata('success', 'New Caste created successfully');

                } else{

                    $this->session->set_flashdata('error', 'Caste creation failed');

                }

            }

            redirect('viewSettings');

        }

    }

    /**

     * This function is used to add Nationality Details

     */

    function addNationality()

    {

        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE)

        {

            $this->loadThis();

        }  else {

                $nationality =$this->security->xss_clean($this->input->post('nationality'));

            $nationalityInfo = array('nationality_name'=>$nationality,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));

            $result = $this->settings->addNationality($nationalityInfo);

            if($result > 0){

                $this->session->set_flashdata('success', 'New Nationality created successfully');

            } else{

                $this->session->set_flashdata('error', 'Nationality creation failed');

            }

            redirect('viewSettings');

        }

    }



     /**

     * This function is used to add Category Details

     */

    function addCategory()

    {

        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE)

        {

            $this->loadThis();

        }  else {

            $category =$this->security->xss_clean($this->input->post('category'));

            $categoryInfo = array('category_name'=>$category,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));

            $result = $this->settings->addCategory($categoryInfo);

            if($result > 0){

                $this->session->set_flashdata('success', 'New Category created successfully');

            } else{

                $this->session->set_flashdata('error', 'Category creation failed');

            }

            redirect('viewSettings');

        }

    }

    

    public function deleteNationality(){

        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){

            $this->loadThis();

        } else {   

            $row_id = $this->input->post('row_id');

            $nationalityInfo = array('is_deleted' => 1,

            'updated_date_time' => date('Y-m-d H:i:s'),

            'updated_by' => $this->staff_id

            );

            $result = $this->settings->updateNationality($nationalityInfo, $row_id);

            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}

        } 

    }



    public function deleteReligion(){

        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){

            $this->loadThis();

        } else {   

            $row_id = $this->input->post('row_id');

            $religionInfo = array('is_deleted' => 1,

            'updated_date_time' => date('Y-m-d H:i:s'),

            'updated_by' => $this->staff_id

            );

            $result = $this->settings->updateReligion($religionInfo, $row_id);

            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}

        } 

    }

    public function deletedeposittype(){

        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){

            $this->loadThis();

        } else {   

            $row_id = $this->input->post('row_id');

            $deposittypeInfo = array('is_deleted' => 1,

            'updated_date_time' => date('Y-m-d H:i:s'),

            'updated_by' => $this->staff_id

            );

            $result = $this->settings->updatedeposittype($deposittypeInfo, $row_id);

            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}

        } 

    }

    public function deletedepositaccount(){

        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){

            $this->loadThis();

        } else {   

            $row_id = $this->input->post('row_id');

            $depositaccountInfo = array('is_deleted' => 1,

            'updated_date_time' => date('Y-m-d H:i:s'),

            'updated_by' => $this->staff_id

            );

            $result = $this->settings->updatedepositaccount($depositaccountInfo, $row_id);

            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}

        } 

    }



    public function deleteCaste(){

        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){

            $this->loadThis();

        } else {   

            $row_id = $this->input->post('row_id');

            $casteInfo = array('is_deleted' => 1,

            'updated_date_time' => date('Y-m-d H:i:s'),

            'updated_by' => $this->staff_id

            );

            $result = $this->settings->updateCaste($casteInfo, $row_id);

            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}

        } 

    }



    public function deleteCategory(){

        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){

            $this->loadThis();

        } else {   

            $row_id = $this->input->post('row_id');

            $categoryInfo = array('is_deleted' => 1,

            'updated_date_time' => date('Y-m-d H:i:s'),

            'updated_by' => $this->staff_id

            );

            $result = $this->settings->updateCategory($categoryInfo, $row_id);

            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}

        } 

    }



    public function deleteDepartment(){

        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){

            $this->loadThis();

        } else {   

            $row_id = $this->input->post('row_id');

            $deptInfo = array('is_deleted' => 1,

            'updated_date_time' => date('Y-m-d H:i:s'),

            'updated_by' => $this->staff_id

            );

            $result = $this->settings->updateDepartment($deptInfo, $row_id);

            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}

        } 

    }



    

    public function addSection(){

        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){

            $this->loadThis();

        } else {

            $stream_id =$this->security->xss_clean($this->input->post('stream'));

            $section =$this->security->xss_clean($this->input->post('section'));

            $isExist = $this->settings->checkSectionExists($section,$stream_id);

            if($isExist > 0){

                $this->session->set_flashdata('warning', 'Section already exists!');

                redirect('viewSettings');

            }else{

                $sectionInfo = array('section_name'=>$section,

                    'stream_id'=>$stream_id,

                    'created_by'=>$this->staff_id,

                    'created_date_time'=>date('Y-m-d H:i:s'));



                $result = $this->settings->addSection($sectionInfo);

                        

                if($result > 0){

                    $this->session->set_flashdata('success', 'New Section Added successfully');

                } else{

                    $this->session->set_flashdata('error', 'Section creation failed');

                }

                redirect('viewSettings');

            }

        }

    }

    public function deleteSection(){

        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){

            $this->loadThis();

        } else {   

            $row_id = $this->input->post('row_id');

            $sectionInfo = array('is_deleted' => 1,

            'updated_date_time' => date('Y-m-d H:i:s'),

            'updated_by' => $this->staff_id

            );

            $result = $this->settings->updateSection($sectionInfo, $row_id);

            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}

        } 

    }



         /**

     * This function is used to add election post Details

     */

    function addPost()

    {

        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE)

        {

            $this->loadThis();

        }  else {

            $post_name =$this->security->xss_clean($this->input->post('post_name'));

            $postInfo = array('post_name'=>$post_name,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));

            $result = $this->settings->addPost($postInfo);

            if($result > 0){

                $this->session->set_flashdata('success', 'New Post created successfully');

            } else{

                $this->session->set_flashdata('error', 'Post creation failed');

            }

            redirect('viewSettings');

        }

    }



        public function deletePost(){

        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){

            $this->loadThis();

        } else {   

            $post_id = $this->input->post('post_id');

            $postInfo = array('is_deleted' => 1,

            'updated_date_time' => date('Y-m-d H:i:s'),

            'updated_by' => $this->staff_id

            );

            $result = $this->settings->updatePost($postInfo, $post_id);

            log_message('debug','post'.print_r($postInfo));

            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}

        } 

    }



    // class timings for time table

    public function addClassTimings(){

        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){

            $this->loadThis();

        } else {

            $start_time_hh =$this->security->xss_clean($this->input->post('start_time_hh'));

            $start_time_mm =$this->security->xss_clean($this->input->post('start_time_mm'));

            $end_time_hh =$this->security->xss_clean($this->input->post('end_time_hh'));

            $end_time_mm =$this->security->xss_clean($this->input->post('end_time_mm'));

            $week_id =$this->security->xss_clean($this->input->post('week_id'));

            $start_time = $start_time_hh.':'.$start_time_mm;

            $end_time = $end_time_hh.':'.$end_time_mm;



            $isExist = $this->settings->checkClassTimingsExists($start_time,$end_time,$week_id);

            if($isExist > 0){

                $this->session->set_flashdata('warning', 'Class Timings already exists!');

            }else{

                $classInfo = array(

                    'start_time'=>$start_time,

                    'end_time'=>$end_time,

                    'week_row_id'=>$week_id,

                    'created_by'=>$this->staff_id,

                    'created_date_time'=>date('Y-m-d H:i:s'));



                $result = $this->settings->addTimings($classInfo);

                        

                if($result > 0){

                    $this->session->set_flashdata('success', 'Class Timings Added successfully');

                } else{

                    $this->session->set_flashdata('error', 'Class Timings creation failed');

                }

            }

            redirect('viewSettings');

        }

    }



    // delete class timings

    public function deleteClassTimings(){

        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){

            $this->loadThis();

        } else {   

            $row_id = $this->input->post('row_id');

            $classInfo = array('is_deleted' => 1,

            'updated_date_time' => date('Y-m-d H:i:s'),

            'updated_by' => $this->staff_id

            );

            $result = $this->settings->updateClassTimings($classInfo, $row_id);

            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}

        } 

    }



    



    // add school account type

    public function addSchoolAccount() {

        if($this->isAdmin() == TRUE) {

            $this->loadThis();

        }  else {

            $school_account_type = $this->security->xss_clean($this->input->post('school_account_type'));

            $schoolInfo = array(

                'school_account_type'=>$school_account_type,

                'created_by'=>$this->staff_id,

                'created_date_time'=>date('Y-m-d H:i:s'));

            $result = $this->settings->addSchoolAccountInfo($schoolInfo);

            if($result > 0){

                $this->session->set_flashdata('success', 'School Account type added successfully');

            } else{

                $this->session->set_flashdata('error', 'School Account type creation failed');

            }

            redirect('viewSettings');

        }

    }

    

    // delete school account type

    public function deleteSchoolAccountType(){

        if($this->isAdmin() == TRUE){

            $this->loadThis();

        } else {   

            $row_id = $this->input->post('row_id');

            $schoolInfo = array('is_deleted' => 1,

            'updated_date_time' => date('Y-m-d H:i:s'),

            'updated_by' => $this->staff_id

            );

            $result = $this->settings->updateSchoolAccountType($schoolInfo, $row_id);

            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}

        } 

    }

    



        // add school title for print

        public function addSchoolName() {

            if($this->isAdmin() == TRUE) {

                $this->loadThis();

            }  else {

                $school_name = ucwords($this->security->xss_clean($this->input->post('school_name')));

                $school_address = $this->security->xss_clean($this->input->post('school_address'));

               // $stream_name = $this->security->xss_clean($this->input->post('stream_name'));

              

                $term_name = $this->security->xss_clean($this->input->post('term_name'));

                $receipt_name = $this->security->xss_clean($this->input->post('receipt_name'));

                $account_type = $this->security->xss_clean($this->input->post('account_type'));

                $schoolInfo = array(

                    'school_name'=>$school_name,

                    'school_address'=>$school_address,

                    'school_place'=>$school_place,

                    'fee_receipt_name'=>$receipt_name,

                    'school_account_row_id'=>$account_type,

                   

                    'term_name'=>$term_name,

                    'created_by'=>$this->staff_id,

                    'created_date_time'=>date('Y-m-d H:i:s'));

                $result = $this->settings->addSchoolReceiptConfigInfo($schoolInfo);

                if($result > 0){

                    $this->session->set_flashdata('success', 'School Receipt Config added successfully');

                } else{

                    $this->session->set_flashdata('error', 'School Receipt Config creation failed');

                }

                redirect('viewSettings');

            }

        }

    

        // delete school title

        public function deleteSchoolInfo(){

            if($this->isAdmin() == TRUE){

                $this->loadThis();

            } else {   

                $row_id = $this->input->post('row_id');

                $schoolInfo = array('is_deleted' => 1,

                'updated_date_time' => date('Y-m-d H:i:s'),

                'updated_by' => $this->staff_id

                );

                $result = $this->settings->updateSchoolTitle($schoolInfo, $row_id);

                if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}

            } 

        }





        public function getStreamNamesByTermSelected(){

            if($this->isAdmin() == TRUE){

                $this->loadThis();

            } else {   

                $term_name = $this->input->post('term_name');

                $data['term_name'] = $this->settings->getStreamNamesByTermSelected($term_name);

                header('Content-type: text/plain');

                header('Content-type: application/json'); 

                echo json_encode($data);

                exit(0);

            }

        }





        // public function updateParentMobile(){

        //     $stdInfo = $this->student->forJob('I PUC');

        //     $count = 0;

        //     foreach($stdInfo as $std){

        //        // log_message('debug','gg=='.$std->application_no);

        //         $info = array(

        //             'mobile_no'=>$std->mobile_one,

        //             'updated_by' => $this->staff_id

        //         );

        //         $this->settings->updateMobileNumberFather($info, $std->application_no);

        //         $info = array(

        //             'mobile_no'=>$std->mobile_two,

        //             'updated_by' => $this->staff_id

        //         );

        //         $this->settings->updateMobileNumberMother($info, $std->application_no);

        //         $count++;

        //     }

        //     log_message('debug','gg=='.$count);

        // }



    // public function getStudentImageByExcel(){
    //     $config=['upload_path' => './upload/',
    //     'allowed_types' => 'xlsx|csv|xls','max_size' => '102400','overwrite' => TRUE,
    //     ];
    //     $this->load->library('upload', $config);
    //     if (!$this->upload->do_upload('excelFile')) {
    //         $error = array('error' => $this->upload->display_errors());
    //     } else { 
    //         $data = array('upload_data' => $this->upload->data());
    //     }
    //    if (!empty($data['upload_data']['file_name'])) {
    //         $import_xls_file = $data['upload_data']['file_name'];
    //     } else {
    //         $import_xls_file = 0;
    //     }
    //     $inputFileName = 'upload/'. $import_xls_file;
    //     try {
    //         $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    //         $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    //         $objPHPExcel = $objReader->load($inputFileName);
    //     } catch (Exception $e) {
    //         die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
    //                 . '": ' . $e->getMessage());
    //     }
    //     $excelValues = array();
    //     $excelValues2 = array();
    //     $sheetCount = $objPHPExcel->getSheetCount();
    //     $sheetNames = $objPHPExcel->getSheet();
    //     $objWorksheet = $objPHPExcel->getActiveSheet($sheetCount);
    //     $row_index = $objWorksheet->getHighestRow(); 
    //     $col_name = $objWorksheet->getHighestColumn();
    //     $headings = array();
    //     $cell_config = array(); 
    //     $row_count = 1;
    //     $highestRow = $objWorksheet->getHighestDataRow(); 
    //     $highestColumn = $objWorksheet->getHighestDataColumn();
    //     $total_fields = 2;

    //      $count_inserted=0;
    //      $count_not=0;
    //      $total=0;
    //     // $studentInfoExcelNames = array();
    //     // $studentInfoExcelReg = array();
    //     // $studentInfoDbNames = array();

    //     for($i=3;$i<=$highestRow;$i++){
    //         $application_no = $objWorksheet->getCellByColumnAndRow(1,$i)->getFormattedValue();
    //         $student_name = $objWorksheet->getCellByColumnAndRow(2,$i)->getFormattedValue();
    //         $mobile_one = $objWorksheet->getCellByColumnAndRow(3,$i)->getFormattedValue();
    //         $dob = $objWorksheet->getCellByColumnAndRow(4,$i)->getFormattedValue();
    //         $mother_name = $objWorksheet->getCellByColumnAndRow(5,$i)->getFormattedValue();
    //         $father_name = $objWorksheet->getCellByColumnAndRow(6,$i)->getFormattedValue();

    //         $dateOfBirth = str_replace("/", "-", $dob);

            
    //        if(!empty($application_no)){
    //             $student_info = array(
    //                 'application_no' => $application_no,
    //                 'student_name' => $student_name,
    //                 'mobile_one' => $mobile_one,
    //                 'dob' => date('Y-m-d',strtotime($dateOfBirth)),
    //                 'intake_year' =>'2019-20',
    //                 'is_active' =>'1',
    //                 'is_admitted' =>'1',
    //                 'is_current' =>'1',
    //                 'created_by' => $this->staff_id,
    //                 'created_date_time' => date('Y-m-d H:m:s'));
    //             $result = $this->student->addStudentDetailsFromExcel($student_info);
    //             log_message('debug','student_info'.print_r($student_info,true));
    //              $count_inserted++;



    //             if($result > 0){
    //                 $academic_info = array(
    //                     'application_no' => $application_no,
    //                     'student_id' => $application_no,
    //                     'term_name' => 'II PUC',
    //                     'stream_name' => 'EBAC',
    //                     'program_name' => 'COMMERCE',
    //                     'is_active' =>'1',
    //                     'created_by' => $this->staff_id,
    //                     'created_date_time' => date('Y-m-d H:m:s'));

    //                 $result_academic = $this->student->addStudentAcademicDetailsFromExcel($academic_info);
    //             log_message('debug','academic_info'.print_r($academic_info,true));

    //            }



    //             if($result > 0){
    //                 $father_info = array(
    //                     'application_no' => $application_no,
    //                     'name' => $father_name,
    //                     'relation_type' => 'FATHER',
    //                     'created_by' => $this->staff_id,
    //                     'created_date_time' => date('Y-m-d H:m:s'));
    //                 $result_father = $this->student->addStudentFatherDetailsFromExcel($father_info);
    //                 log_message('debug','father_info'.print_r($father_info,true));
    //             }

    //             if($result > 0){
    //                 $mother_info = array(
    //                     'application_no' => $application_no,
    //                     'name' => $mother_name,
    //                     'relation_type' => 'MOTHER',
    //                     'created_by' => $this->staff_id,
    //                     'created_date_time' => date('Y-m-d H:m:s'));
    //                 $result_mother = $this->student->addStudentMotherDetailsFromExcel($mother_info);
    //                 log_message('debug','mother_info'.print_r($mother_info,true));
    //                 log_message('debug','count'.$count_inserted);
    //             }

    //           // / $result_one = $this->student->addStudentDetailsFromExcel($student_info,$result->application_no);
    //         //  log_message('debug','Inserted Record=='.$register_no);
    //         //  log_message('debug','Inserted Record=='.$student_id);
    //              // $count_inserted++;
    //         // } else {
    //         //     $count_not++;
    //         //     array_push($studentInfoExcelReg,$register_no);
    //         //     array_push($studentInfoExcelNames,$student_name);
    //         //     array_push($studentInfoDbNames,$student_name);
    //         }else{
    //             $count_not++;

    //         }

    //         // $total++;



    //     }

    //     // for($j=0;$j<$count_not;$j++){

    //     //     log_message('debug', 'Register no =='.$studentInfoExcelReg[$j].' Excel Name - '.$studentInfoExcelNames[$j]);

    //     // }

    //     //  log_message('debug','Inserted Count=='.$count_inserted);

    //     //  log_message('debug','count not fount=='.$count_not);

    //     // log_message('debug','total count=='.$total);



    //     redirect('viewSettings');

    // }


    public function getStudentImageByExcel(){
        $config=['upload_path' => './upload/',
        'allowed_types' => 'xlsx|csv|xls','max_size' => '102400','overwrite' => TRUE,
        ];
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('excelFile')) {
            $error = array('error' => $this->upload->display_errors());
        } else { 
            $data = array('upload_data' => $this->upload->data());
        }
       if (!empty($data['upload_data']['file_name'])) {
            $import_xls_file = $data['upload_data']['file_name'];
        } else {
            $import_xls_file = 0;
        }
        $inputFileName = 'upload/'. $import_xls_file;
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                    . '": ' . $e->getMessage());
        }
        $excelValues = array();
        $excelValues2 = array();
        $sheetCount = $objPHPExcel->getSheetCount();
        $sheetNames = $objPHPExcel->getSheet();
        $objWorksheet = $objPHPExcel->getActiveSheet($sheetCount);
        $row_index = $objWorksheet->getHighestRow(); 
        $col_name = $objWorksheet->getHighestColumn();
        $headings = array();
        $cell_config = array(); 
        $row_count = 1;
        $highestRow = $objWorksheet->getHighestDataRow(); 
        $highestColumn = $objWorksheet->getHighestDataColumn();
        $total_fields = 2;

        $count_updated=0;
         $count_inserted=0;
         $count_not=0;
         $total=0;
        // $studentInfoExcelNames = array();
        // $studentInfoExcelReg = array();
        $studentInfoDbNames = array();

        for($i=1;$i<=$highestRow;$i++){
            $sat_number = $objWorksheet->getCellByColumnAndRow(1,$i)->getFormattedValue();
            $application_no = $objWorksheet->getCellByColumnAndRow(2,$i)->getFormattedValue();
            $student_name = $objWorksheet->getCellByColumnAndRow(3,$i)->getFormattedValue();
            $combination = $objWorksheet->getCellByColumnAndRow(4,$i)->getFormattedValue();
            // $dateOfBirth = $objWorksheet->getCellByColumnAndRow(3,$i)->getFormattedValue();
            // $stream = $objWorksheet->getCellByColumnAndRow(5,$i)->getFormattedValue();

            log_message('debug','sat'.$sat_number);
            log_message('debug','application_no'.$application_no);
            log_message('debug','combination'.$combination);

            // $mother_name = $objWorksheet->getCellByColumnAndRow(3,$i)->getFormattedValue();
            // $father_name = $objWorksheet->getCellByColumnAndRow(4,$i)->getFormattedValue();
            // $stream = $objWorksheet->getCellByColumnAndRow(5,$i)->getFormattedValue();
            // $term = $objWorksheet->getCellByColumnAndRow(4,$i)->getFormattedValue();

            // $dateOfBirth = str_replace("/", "-", $dob);
            // if($elective_sub == 'KAN'){
            //     $elective = 'Kannada';
            // }else if($elective_sub == 'HIN'){
            //     $elective = 'Hindi';
            // }else if($elective_sub == 'FRE'){
            //     $elective = 'French';
            // }else{
            //     $elective = $elective_sub;
            // }

            if($combination == 'S'){
                $program = 'SCIENCE';
            }else if($combination == 'C'){
                $program = 'COMMERCE';
            }else{
                $program = 'ARTS';
            }


            // if($stream == 'PCMB' || $stream == 'PCMC'){
            //     $program = 'SCIENCE';
            // }else if($stream == 'EBAC' || $stream == 'SEBA'){
            //     $program = 'COMMERCE';
            // }else{
            //     $program = 'ARTS';
            // }


            
        
                $isExists = $this->student->checkStudentInfoByApplicationNo($application_no);
                 
                
            $stdInfo = $this->student->getStdInfoByApplicationNo($application_no);

            $stream_name = $stdInfo->stream_name;

              log_message('debug','stream_name'.print_r($stdInfo->stream_name,true));
               // $dateob = $stdInfo->dob;
                 // if(!empty($application_no)){
                if(empty($isExists)){
                  
                    $student_info = array(
                        'application_no' => $application_no,
                        'student_name' => $student_name,
                        // 'mobile_one' => $stdInfo->father_mobile,
                        // 'dob' =>  $dateob,
                         // 'dob' =>  $stdInfo->dob,
                        'intake_year' =>'2021-22',
                        'intake_year_id' =>'2021',
                        'sat_number' =>$sat_number,
                        'is_active' =>'1',
                        'is_admitted' =>'1',
                        'is_current' =>'1',
                        'created_by' => $this->staff_id,
                        'created_date_time' => date('Y-m-d H:m:s'));
                    $result = $this->student->addStudentDetailsFromExcel($student_info);
                    log_message('debug','std info  '.print_r($student_info,true));
                     $count_inserted++;
    
    
    
                    if($result > 0){
                        $academic_info = array(
                            'application_no' => $application_no,
                            'student_id' => $application_no,
                            'term_name' => 'II PUC',
                            'stream_name' =>$stdInfo->stream_name,
                            'program_name' => $program,
                            'elective_sub' => $stdInfo->second_language,
                            'is_active' =>'1',
                            'created_by' => $this->staff_id,
                            'created_date_time' => date('Y-m-d H:m:s'));
    
                        $result_academic = $this->student->addStudentAcademicDetailsFromExcel($academic_info);
                        log_message('debug','std acd  '.print_r($academic_info,true));
    
                    }
    
    
    
                    if($result > 0){
                        $father_info = array(
                            'application_no' => $application_no,
                            'name' => $stdInfo->father_name,
                            'mobile_no' => $stdInfo->father_mobile,
                            'relation_type' => 'FATHER',
                            'created_by' => $this->staff_id,
                            'created_date_time' => date('Y-m-d H:m:s'));
                        $result_father = $this->student->addStudentFatherDetailsFromExcel($father_info);
                         log_message('debug','std father_info  '.print_r($father_info,true));
                    }
    
                    if($result > 0){
                        $mother_info = array(
                            'application_no' => $application_no,
                            'name' => $stdInfo->mother_name,
                            'mobile_no' => $stdInfo->mother_mobile,
                            'relation_type' => 'MOTHER',
                            'created_by' => $this->staff_id,
                            'created_date_time' => date('Y-m-d H:m:s'));
                        $result_mother = $this->student->addStudentMotherDetailsFromExcel($mother_info);
                         log_message('debug','std mother_info  '.print_r($mother_info,true));
                    }

                    // log_message('debug','student_info'.print_r($student_info,true));
                    // log_message('debug','academic_info'.print_r($academic_info,true));
                    // log_message('debug','mother_info'.print_r($mother_info,true));
                    // log_message('debug','father_info'.print_r($father_info,true));
                    // log_message('debug','update academic'.print_r($academicInfo,true));
                    array_push($studentInfoDbNames,$application_no);
                }
            }

        // }



            // }else{
            //     $count_not++;
            // }
            // $total++;

    
        // log_message('debug','count'.$count_inserted);
        // log_message('debug','update'.$count_updated);
        log_message('debug','studentInfoDbNames'.print_r($studentInfoDbNames,true));
        redirect('viewSettings');

    }


}