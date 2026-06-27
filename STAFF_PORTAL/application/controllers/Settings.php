<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Settings extends BaseController {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
        $this->load->model('staff_model','staff');
        $this->load->model('exam_model','exam');
        $this->load->model('settings_model','settings');
        $this->load->model('students_model','student');
        $this->load->model('timetable_model','timetable');
        $this->load->model('admission_model','admission');
        $this->load->model('jobportal_model',"jobportal");
        $this->load->model('Scholarship_model','scholarship');
        $this->load->model('fee_model','fee');
        $this->isLoggedIn();
    }
    public function viewSettings(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {
            

            $data['shiftInfo'] = $this->settings->getAllShiftInfo();
            $data['departmentInfo'] = $this->settings->getAllDepartmentInfo();
            $data['religionInfo'] = $this->settings->getAllReligionInfo();
            $data['deposittypeInfo'] = $this->settings->getAlldeposittypeInfo();
            $data['depositaccountInfo'] = $this->settings->getAlldepositaccountInfo();
            $data['nationalityInfo'] = $this->settings->getAllNationalityInfo();
            $data['casteInfo'] = $this->settings->getAllCasteInfo();
            $data['categoryInfo'] = $this->settings->getAllCategoryInfo();
            $data['streamInfo'] = $this->settings->getStreamInfo();
            $data['weekName'] = $this->timetable->getAllWeekName();
            // $data['sectionInfo'] = $this->settings->getSectionInfo($filter);
            $data['classTimingsInfo'] = $this->settings->getAllClassTimingsInfo();
            $data['timetableShiftInfo'] = $this->settings->getAllTimetableDayShiftingInfo();
            $data['miscellaneousTypeInfo'] = $this->settings->getAllMiscellaneousTypeInfo();
            $data['feeNameInfo'] ="";// $this->settings->getAllFeeNameInfo();
            $data['postInfo'] = "";// $this->settings->getAllPostInfo();
            $data['feeTypeInfo'] = "";//$this->settings->getAllFeeTypeInfo();

            $data['documentTypeInfo'] = $this->settings->getAllDocumentTypeInfo();
            $data['jobPostInfo'] = $this->jobportal->getAllJobPostInfo();
            $data['OTAmountInfo'] = $this->settings->getAllOTAmountInfo();
            $data['remarkNameInfo'] = $this->settings->getStaffRemarkNameInfo();
            $data['remarkNameInfo1'] = $this->settings->getRemarkNameInfo();
            $data['examTypeInfo'] = $this->settings->getExamTypeInfo();

            $data['salaryTypeInfo'] = $this->settings->getAllSalaryTypeInfo();
            $data['taxRegimeTypeInfo'] = $this->settings->getAllTaxRegimeInfo();
            $data['salaryDesignationInfo'] = $this->settings->getAllSalarydesignationInfo();
            $data['scholarshipTypeInfo'] = $this->scholarship->getAllScholarshipTypeInfo();
            $data['scholarshipRecommendedInfo'] = $this->scholarship->getAllScholarshipRecommendedInfo();
            $data['moduleInfo'] = $this->settings->getAllModulesInfo();
            $data['subModuleInfo'] = $this->settings->getAllSubModulesInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Settings';
            $this->loadViews("settings/settingsDashboard", $this->global, $data, null);  
        }
    }

    public function addSalaryType() {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }  else {
            $salary_type =$this->security->xss_clean($this->input->post('salary_type'));
            $calculate_type =$this->security->xss_clean($this->input->post('calculate_type'));
            $salary_category =$this->security->xss_clean($this->input->post('salary_category'));
            $isExist = $this->settings->checkSalaryTypeExists($salary_type,$calculate_type,$salary_category);
            if ($isExist) { // Check if $isExist is truthy
                $this->session->set_flashdata('error', 'Salary Type is already Exist');
                redirect('viewSettings');
            }
            $salaryTypeInfo = array(
                'salary_type'=>strtoupper($salary_type),
                'calculate_type'=>$calculate_type,
                'salary_category'=>$salary_category,
                'created_by'=>$this->staff_id,
                'created_date_time'=>date('Y-m-d H:i:s')
            );
            $result = $this->settings->addSalaryType($salaryTypeInfo);
            if($result > 0){
                $this->session->set_flashdata('success', 'New Salary Type created successfully');
            } else{
                $this->session->set_flashdata('error', 'Salary Type creation failed');
            }
            redirect('viewSettings');
        }
    }

    public function deleteSalaryType(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $salaryTypeInfo = array(
                'is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateSalaryType($salaryTypeInfo, $row_id);
            // log_message('debug','post'.print_r($postInfo));
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function getCalculationType()
    {
        $salaryType = $this->input->post('salary_type');
        $calculateType = '';

        // Assuming you have a model method to get the calculation type for a salary type
        $result = $this->settings->getCalculationTypeBySalaryType($salaryType);

        if ($result) {
            $calculateType = $result->calculate_type;
        }

        echo json_encode(['calculate_type' => $calculateType]);
    }

    public function addSalaryDesignation() {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }  else {
            $salary_designation =$this->security->xss_clean($this->input->post('salary_designation'));
            $isExist = $this->settings->checkSalaryDesignationExists($salary_designation);
            if ($isExist) { // Check if $isExist is truthy
                $this->session->set_flashdata('error', 'Salary Designation is already Exist');
                redirect('viewSettings');
            }
            $salaryDesignationInfo = array(
                'designation'=>$salary_designation,
                'created_by'=>$this->staff_id,
                'created_date_time'=>date('Y-m-d H:i:s')
            );
            $result = $this->settings->addSalaryDesignation($salaryDesignationInfo);
            if($result > 0){
                $this->session->set_flashdata('success', 'New Salary Type created successfully');
            } else{
                $this->session->set_flashdata('error', 'Salary Type creation failed');
            }
            redirect('viewSettings');
        }
    }

    public function deleteSalaryDesignation(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $salaryDesignationInfo = array(
                'is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateSalaryDesignation($salaryDesignationInfo, $row_id);
            // log_message('debug','post'.print_r($postInfo));
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function addTaxRegime() {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }  else {
            $tax_regime =$this->security->xss_clean($this->input->post('tax_regime'));
            $isExist = $this->settings->checkTaxRegimeExists($tax_regime);
            if ($isExist) { // Check if $isExist is truthy
                $this->session->set_flashdata('error', 'Tax Regime Type is already Exist');
                redirect('viewSettings');
            }
            $taxRegimeInfo = array(
                'type'=>$tax_regime,
                'created_by'=>$this->staff_id,
                'created_date_time'=>date('Y-m-d H:i:s')
            );
            $result = $this->settings->addTaxRegimeType($taxRegimeInfo);
            if($result > 0){
                $this->session->set_flashdata('success', 'New Tax Regime Type created successfully');
            } else{
                $this->session->set_flashdata('error', 'Tax Regime Type creation failed');
            }
            redirect('viewSettings');
        }
    }

    public function deleteTaxRegime(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $taxRegimeInfo = array(
                'is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateTaxRegime($taxRegimeInfo, $row_id);
            // log_message('debug','post'.print_r($postInfo));
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    //add Remarks name information
    function addStaffRemarkName(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }  else {
                $remark_name =$this->security->xss_clean($this->input->post('remark_name'));
                $remarkInfo = array(
                    'remark_name'=>$remark_name,
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->settings->addStaffRemarkName($remarkInfo);
                if($result > 0){
                    $this->session->set_flashdata('success', 'New Staff Remark created successfully');
                } else{
                    $this->session->set_flashdata('error', 'Staff Remark creation failed');
                }
                redirect('viewSettings');
        }
        
    }

    function addExamType(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }  else {
                $exam_type =$this->security->xss_clean($this->input->post('exam_type'));
                $remarkInfo = array(
                    'exam_type'=>$exam_type,
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->settings->addExamType($remarkInfo);
                if($result > 0){
                    $this->session->set_flashdata('success', 'Exam Type created successfully');
                } else{
                    $this->session->set_flashdata('error', 'Exam Type creation failed');
                }
                redirect('viewSettings');
        }
        
    }

    public function deleteStaffRemarkName(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $Info = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateStaffRemarksInfo($Info, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function deleteExamType(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $Info = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateExamTypeInfo($Info, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }


    public function addOTAmount(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {
            $ot_amount =ucwords($this->security->xss_clean($this->input->post('ot_amount')));
            $isExist = $this->settings->checkOTAmountExists($ot_amount);
            if($isExist > 0){
                $this->session->set_flashdata('warning', 'Amount already exists!');
            }else{
                $AmountInfo = array(
                    'ot_amount'=>$ot_amount,
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));

                $result = $this->settings->addOTAmount($AmountInfo);
                        
                if($result > 0){
                    $this->session->set_flashdata('success', 'Amount Added successfully');
                } else{
                    $this->session->set_flashdata('error', 'Amount creation failed');
                }
            }
            redirect('viewSettings');
        }
    }
    public function deleteOTAmount(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $Info = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateOTAmountInfo($Info, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
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
                $religionInfo = array('name'=>$religion,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));
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
                $castInfo = array('name'=>$caste,
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
            $nationalityInfo = array('name'=>$nationality,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));
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

    
    // add day shifting info
    public function addTimetableDayShifting() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $week_id = $this->security->xss_clean($this->input->post('week_id'));
            $date = $this->security->xss_clean($this->input->post('date'));
            $shift_date = date('Y-m-d',strtotime($date));

            $isExist = $this->settings->checkTimetableShiftingExists($week_id,$shift_date);
            if($isExist > 0){
                $this->session->set_flashdata('warning', 'Time table day shift already exists!');
                redirect('viewSettings');
            }else{
                $shiftingInfo = array(
                    'week_id'=>$week_id,
                    'date'=> $shift_date,
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));
                $result = $this->settings->addDayShiftingInfo($shiftingInfo);
            }
            if($result > 0){
                $this->session->set_flashdata('success', 'Shifting Info added successfully');
            } else{
                $this->session->set_flashdata('error', 'Shifting Info creation failed');
            }
            redirect('viewSettings');
        }
    }
    public function deleteDayShifting(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $shiftInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateTimetableDayShift($shiftInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    
    public function addFeesName(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {
            $fee_name =ucwords($this->security->xss_clean($this->input->post('fee_name')));

            $isExist = $this->settings->checkFeeNameExists($fee_name);
            if($isExist > 0){
                $this->session->set_flashdata('warning', 'Fee Name already exists!');
            }else{
                $feeInfo = array(
                    'fee_name'=>$fee_name,
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));

                $result = $this->settings->addFeesName($feeInfo);
                        
                if($result > 0){
                    $this->session->set_flashdata('success', 'Fee Name Added successfully');
                } else{
                    $this->session->set_flashdata('error', 'Fee Name creation failed');
                }
            }
            redirect('viewSettings');
        }
    }

    public function deleteFeeName(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $feeInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateFeeNameInfo($feeInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    // election
    function addPost(){
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
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    
    // fee type
    function addFeeType(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE) {
            $this->loadThis();
        }  else {
            $feeType =$this->security->xss_clean($this->input->post('feeType'));
            $feeInfo = array('feeType'=>$feeType,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));
            $result = $this->settings->addFeeType($feeInfo);
            if($result > 0){
                $this->session->set_flashdata('success', 'New Fee Type created successfully');
            } else{
                $this->session->set_flashdata('error', 'Fee Type creation failed');
            }
            redirect('viewSettings');
        }
    }



    public function deleteFeeType(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $feeInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateFeeType($feeInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
    
    public function getNewAdmittedStudentsImport(){
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
        $total_records = 0;
        $highestRow = $objWorksheet->getHighestDataRow(); 
        $highestColumn = $objWorksheet->getHighestDataColumn();
        $total_fields = 2;
        $student_count = 0;
        $studentNotExistCount = 0;
        $student_update_count = 0;
        $app_no = array();
        // $highestRow

        for($i=5;$i<=$highestRow;$i++){
            $student_id = $objWorksheet->getCellByColumnAndRow(1,$i)->getFormattedValue();
            $student_name = $objWorksheet->getCellByColumnAndRow(2,$i)->getFormattedValue();
            $term_name = $objWorksheet->getCellByColumnAndRow(3,$i)->getFormattedValue();
            $stream_name = $objWorksheet->getCellByColumnAndRow(4,$i)->getFormattedValue();
            $program_name = $objWorksheet->getCellByColumnAndRow(5,$i)->getFormattedValue();

            $section = $objWorksheet->getCellByColumnAndRow(6,$i)->getFormattedValue();

            $elective_sub = $objWorksheet->getCellByColumnAndRow(7,$i)->getFormattedValue();

            $application_no = $objWorksheet->getCellByColumnAndRow(8,$i)->getFormattedValue();

            $admission_no = $objWorksheet->getCellByColumnAndRow(9,$i)->getFormattedValue();
            $date_of_admission = $objWorksheet->getCellByColumnAndRow(10,$i)->getFormattedValue();
            $sat_number  = $objWorksheet->getCellByColumnAndRow(11,$i)->getFormattedValue();
            $dob = $objWorksheet->getCellByColumnAndRow(12,$i)->getFormattedValue();
            $gender = $objWorksheet->getCellByColumnAndRow(13,$i)->getFormattedValue();
            $blood_group = $objWorksheet->getCellByColumnAndRow(14,$i)->getFormattedValue();
            $state = $objWorksheet->getCellByColumnAndRow(15,$i)->getFormattedValue();
            $district = $objWorksheet->getCellByColumnAndRow(16,$i)->getFormattedValue();
            $taluk = $objWorksheet->getCellByColumnAndRow(17,$i)->getFormattedValue();
            $pincode = $objWorksheet->getCellByColumnAndRow(18,$i)->getFormattedValue();
            $place_of_birth = $objWorksheet->getCellByColumnAndRow(19,$i)->getFormattedValue();
            $religion = $objWorksheet->getCellByColumnAndRow(20,$i)->getFormattedValue();
            $caste = $objWorksheet->getCellByColumnAndRow(21,$i)->getFormattedValue();
            $category = $objWorksheet->getCellByColumnAndRow(22,$i)->getFormattedValue();
            $mother_tongue = $objWorksheet->getCellByColumnAndRow(23,$i)->getFormattedValue();
            $aadhar_no  = $objWorksheet->getCellByColumnAndRow(24,$i)->getFormattedValue();
            $father_name = $objWorksheet->getCellByColumnAndRow(25,$i)->getFormattedValue();
            $father_mobile = $objWorksheet->getCellByColumnAndRow(26,$i)->getFormattedValue();

            $father_email = $objWorksheet->getCellByColumnAndRow(27,$i)->getFormattedValue();
            
            $mother_name = $objWorksheet->getCellByColumnAndRow(28,$i)->getFormattedValue();
            $mother_mobile = $objWorksheet->getCellByColumnAndRow(29,$i)->getFormattedValue();

            $mother_email = $objWorksheet->getCellByColumnAndRow(30,$i)->getFormattedValue();

            $present_address = $objWorksheet->getCellByColumnAndRow(31,$i)->getFormattedValue();
            $permanent_address = $objWorksheet->getCellByColumnAndRow(32,$i)->getFormattedValue();

            $guardian_name = $objWorksheet->getCellByColumnAndRow(33,$i)->getFormattedValue();
            $guardian_mobile = $objWorksheet->getCellByColumnAndRow(34,$i)->getFormattedValue();
            $guardian_email = $objWorksheet->getCellByColumnAndRow(35,$i)->getFormattedValue();
            $guardian_address = $objWorksheet->getCellByColumnAndRow(36,$i)->getFormattedValue();


            // $dobs = str_replace("/", "-", $dob); 
            // $doa = str_replace("/", "-", $date_of_admission); 
            $dobs = $dob;
            $doa = $date_of_admission;

            if($gender == 'M' || $gender == 'm'){
                $gender = 'MALE';
            }else if($gender == 'F' || $gender == 'f'){ 
                $gender = 'FEMALE';
            }

            if($religion == 'H' || $religion == 'h'){
                $religion = 'HINDU';
            }else if($religion == 'I' || $religion == 'i'){ 
                $religion = 'ISLAM';
            }else if($religion == 'C' || $religion == 'c'){ 
                $religion = 'CHRISTIAN';
            }

            if(!empty($student_id)){
                    $student_info = array(
                    'student_id'=> trim($student_id),
                    'student_name'=> strtoupper($student_name),
                    'term_name' => trim($term_name),
                    'program_name' => trim($program_name),
                    'stream_name'=>trim($stream_name),
                    'section_name' => trim($section),
                    'application_no' => trim($application_no),
                    'admission_no'=> trim($admission_no),
                    'date_of_admission'=>date('Y-m-d',strtotime($doa)),
                    'sat_number'=> trim($sat_number),
                    'dob' => date('Y-m-d',strtotime($dobs)),
                    'gender' => trim($gender),
                    'blood_group' => trim($blood_group),
                    'state' => trim($state),
                    'district' => trim($district),
                    'taluk' => trim($taluk),
                    'pincode' => trim($pincode),
                    'place_of_birth' => trim($place_of_birth),
                    'religion'=> trim($religion), 
                    'caste'=> trim($caste), 
                    'elective_sub' => $elective_sub,
                    'category' => trim($category),
                    'mother_tongue'=> trim($mother_tongue),
                    'aadhar_no' => trim($aadhar_no),
                    'father_name'=> trim($father_name), 
                    'father_mobile'=> trim($father_mobile),
                    'father_email' => trim($father_email),
                    'mother_name'=> trim($mother_name),
                    'mother_mobile' => trim($mother_mobile),
                    'mother_email' => trim($mother_email),
                    'present_address' => $present_address,
                    'permanent_address' => $present_address,
                    'guardian_name' => trim($guardian_name),
                    'guardian_mobile' => trim($guardian_mobile),
                    'guardian_email' => trim($guardian_email),
                    'guardian_address' => trim($guardian_address),
                    'intake_year'=> ADMISSION_INTAKE, 
                    'intake_year_id'=> INTAKE_YEAR, 
                    'is_active' => 1,
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));
               
                  
                    $return = $this->student->addstudentData($student_info);



                    $academic_info = array(
                        'rel_student_row_id' => $return,
                        'student_id'=> trim($student_id),
                        'term_name' => trim($term_name),
                        'program_name' => trim($program_name),
                        'stream_name'=>trim($stream_name),
                        'section_name' => trim($section),
                        'elective_sub' => $elective_sub,
                        'admission_no'=> trim($admission_no),
                        'date_of_admission'=>date('Y-m-d',strtotime($doa)),
                        'is_active' => 1,
                        'is_current' => 1,
                        'created_by'=>$this->staff_id,
                        'created_date_time'=>date('Y-m-d H:i:s'));
                    
                        
                    $return_1 = $this->student->addAcademicData($academic_info);

                    $yearwise_info = array(
                        'stud_row_id' => $return_1,
                        'class' => trim($term_name),
                        'stream'=>trim($stream_name),
                        'section' => trim($section),
                        'intake_year'=> INTAKE_YEAR, 
                        'created_by'=>$this->staff_id,
                        'created_date_time'=>date('Y-m-d H:i:s'));
                    
                        
                    $return_2 = $this->student->addYearWiseData($yearwise_info);
                 
        }
        log_message('debug','inserted record == '.print_r($student_info,true));
    }
    $student_count++;
    log_message('debug','$student_count '.$student_count);
        redirect('viewSettings');
    }




    
    // // update missing fields
    // public function addStudentMissingData(){
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
    //     $total_records = 0;
    //     $highestRow = $objWorksheet->getHighestDataRow(); 
    //     $highestColumn = $objWorksheet->getHighestDataColumn();
    //     $total_fields = 2;
    //     $student_count = 0;
    //     $studentNotExistCount = 0;
    //     $student_update_count = 0;
    //     $app_no = array();

    //     for($i=2;$i<=$highestRow;$i++){
    //         $name = $objWorksheet->getCellByColumnAndRow(2,$i)->getFormattedValue();
    //         $fname = $objWorksheet->getCellByColumnAndRow(3,$i)->getFormattedValue();
    //         $mname = $objWorksheet->getCellByColumnAndRow(4,$i)->getFormattedValue();
    //         $student_id = $objWorksheet->getCellByColumnAndRow(1,$i)->getFormattedValue();
    //         // $sat_no = $objWorksheet->getCellByColumnAndRow(1,$i)->getFormattedValue();
    //         // $application_no = $objWorksheet->getCellByColumnAndRow(0,$i)->getFormattedValue();
    //         // $date_of_admission = $objWorksheet->getCellByColumnAndRow(1,$i)->getFormattedValue();

    //         $date_of_admission = date('d-m-Y',strtotime($date_of_admission));
    //         // log_message('debug','Info = '.print_r($studentInfo,true));
    //         if(!empty($student_id)){
    //             $student_info = array(
    //                 'student_name'=>$name,
    //                 'father_name'=>$fname,
    //                 'mother_name'=>$mname,
    //             // 'date_of_admission'=>$date_of_admission,
    //             // 'sat_number' => $sat_no,
    //             // 'updated_by'=>$this->staff_id,
    //             // 'updated_date_time'=>date('Y-m-d H:i:s')
    //         );
    //                 // log_message('debug','Info std = '.print_r($student_info,true));
    //                 // log_message('debug','student_id std = '.$student_id);
    //                 $result = $this->student->updateStudentInfoBStdId($student_info,$student_id);
    //                 // $result = $this->student->updateStudentInfoApp($student_info,$application_no);
    //                 $student_count++;
    //         }else{
    //             $studentNotExistCount++;
    //             // array_push($app_no,$application_number);
    //         }
    //     }
    //     log_message('debug','Student NOT Count= '.$studentNotExistCount);
    //     log_message('debug','Total Count= '.$student_count);
    //     redirect('viewSettings');
    // }

    
    // // update missing fields
    public function addStudentMissingData(){
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
        $total_records = 0;
        $highestRow = $objWorksheet->getHighestDataRow(); 
        $highestColumn = $objWorksheet->getHighestDataColumn();
        $total_fields = 2;
        $student_count = 0;
        $studentNotExistCount = 0;
        $student_update_count = 0;
        $app_no = array();

        for($i=4;$i<=$highestRow;$i++){
          
           
            $student_id = $objWorksheet->getCellByColumnAndRow(1,$i)->getFormattedValue();
            $elective_sub = $objWorksheet->getCellByColumnAndRow(2,$i)->getFormattedValue();
            // $alumni_status = $objWorksheet->getCellByColumnAndRow(5,$i)->getFormattedValue();
            // $stream_name = $objWorksheet->getCellByColumnAndRow(6,$i)->getFormattedValue();
            //  $program_name = $objWorksheet->getCellByColumnAndRow(7,$i)->getFormattedValue();

            //  if($alumni_status=='TC ISSUED'){
            //     $active = 0;
            //  }else{
            //     $active = 1;
            //  }
            $subject_parts = explode(' - ', $elective_sub);
            $subject_name = end($subject_parts); // Taking the last part after splitting by ' - '
            // $application_no = $objWorksheet->getCellByColumnAndRow(2,$i)->getFormattedValue();
            // $section = $objWorksheet->getCellByColumnAndRow(5,$i)->getFormattedValue();
            // $sat_no = $objWorksheet->getCellByColumnAndRow(3,$i)->getFormattedValue();
            // $application_no = $objWorksheet->getCellByColumnAndRow(0,$i)->getFormattedValue();
            // $date_of_admission = $objWorksheet->getCellByColumnAndRow(1,$i)->getFormattedValue();

            // $date_of_admission = date('d-m-Y',strtotime($date_of_admission));
        
            if(!empty($student_id)){
                $student_info = array(
                    'elective_sub'=>$subject_name,
                    // 'stream_name'=>$stream_name,
                    // 'program_name'=>$program_name,
                    // 'is_active'=>$active,
                    // 'student_id'=>$student_id,
                    //  'section_name' => $section,
                    // 'student_no'=>$student_no,
                    // 'pu_board_number'=>$student_no,
                    // 'sat_number'=>$sat_no,
                // 'date_of_admission'=>$date_of_admission,
                // 'sat_number' => $sat_no,
                'updated_by'=>$this->staff_id,
                'updated_date_time'=>date('Y-m-d H:i:s')
            );
                    // $result = $this->student->updateStudentInfoAdmissionNo($student_info,$application_no);
                    $result = $this->student->updateStudentInfoBStdId($student_info,$student_id);
                log_message('debug','save'.$student_id.'-'.print_r($student_info,true));
                    $student_count++;
            }else{
                $studentNotExistCount++;
                // array_push($app_no,$application_number);
            }
        }
      
        redirect('viewSettings');
    }


    public function getStaffDetailsForImport(){
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
        $count = 0;
        $j = 1;
        // $staff_id = 1024;
    
    
        for($i=2;$i<=$highestRow;$i++){
            $employee_id = $objWorksheet->getCellByColumnAndRow(0,$i)->getFormattedValue();
            $name = $objWorksheet->getCellByColumnAndRow(1,$i)->getFormattedValue();
            $role = $objWorksheet->getCellByColumnAndRow(2,$i)->getFormattedValue();
            $dept = $objWorksheet->getCellByColumnAndRow(3,$i)->getFormattedValue();
            $mobile_no = $objWorksheet->getCellByColumnAndRow(4,$i)->getFormattedValue();

            $email = $objWorksheet->getCellByColumnAndRow(5,$i)->getFormattedValue();
            $address = $objWorksheet->getCellByColumnAndRow(6,$i)->getFormattedValue();
            $dob = $objWorksheet->getCellByColumnAndRow(7,$i)->getFormattedValue();

            $doj = $objWorksheet->getCellByColumnAndRow(8,$i)->getFormattedValue();
            $gender = $objWorksheet->getCellByColumnAndRow(9,$i)->getFormattedValue();
            $aadhar_no = $objWorksheet->getCellByColumnAndRow(10,$i)->getFormattedValue();
            // $pan_no = $objWorksheet->getCellByColumnAndRow(8,$i)->getFormattedValue();
            // $pf_number = $objWorksheet->getCellByColumnAndRow(10,$i)->getFormattedValue();
            // $esi_code = $objWorksheet->getCellByColumnAndRow(11,$i)->getFormattedValue();
            // if ($esi_code == '-') {
            //     $esi_code = '';
            // }

            // $uan_no = $objWorksheet->getCellByColumnAndRow(9,$i)->getFormattedValue();
            // $bank_name = $objWorksheet->getCellByColumnAndRow(12,$i)->getFormattedValue();
            // $branch_name = $objWorksheet->getCellByColumnAndRow(13,$i)->getFormattedValue();
            // $ifsc_code = $objWorksheet->getCellByColumnAndRow(14,$i)->getFormattedValue();
            // $account_no = $objWorksheet->getCellByColumnAndRow(15,$i)->getFormattedValue();
            
            // $basic_salary = $objWorksheet->getCellByColumnAndRow(16,$i)->getFormattedValue();
            // $da_amount = $objWorksheet->getCellByColumnAndRow(17,$i)->getFormattedValue();
            // $da_amount = str_replace('%', '', $da_amount);
            // if ($da_amount == '-') {
            //     $da_amount = '';
            // }
            // $hra_amount = $objWorksheet->getCellByColumnAndRow(18,$i)->getFormattedValue();
            // $hra_amount = str_replace('%', '', $hra_amount);
            // if ($hra_amount == '-') {
            //     $hra_amount = '';
            // }
            // $con = $objWorksheet->getCellByColumnAndRow(19,$i)->getFormattedValue();
            // if ($con == '-') {
            //     $con = '';
            // }
            // $pf = $objWorksheet->getCellByColumnAndRow(20,$i)->getFormattedValue();
            // $other_deduction = $objWorksheet->getCellByColumnAndRow(21,$i)->getFormattedValue();
            // if ($other_deduction == '-') {
            //     $other_deduction = '';
            // }
            // $pt_amount = $objWorksheet->getCellByColumnAndRow(22,$i)->getFormattedValue();
            // $esi = $objWorksheet->getCellByColumnAndRow(23,$i)->getFormattedValue();
            // if ($esi == '-') {
            //     $esi = '';
            // }
            // if(!empty($esi)){
            // $esi = 0.75;
            //     //$management_esi = 3.25;
            // }else{
            //     $esi = 0;
            //     //$management_esi = 0;
            // }
            // $cca = $objWorksheet->getCellByColumnAndRow(24,$i)->getFormattedValue();
            // if ($cca == '-') {
            //     $cca = '';
            // }
            // $other_earnings = $objWorksheet->getCellByColumnAndRow(25,$i)->getFormattedValue();
            // if ($other_earnings == '-') {
            //     $other_earnings = '';
            // }
            // $management_pf = $objWorksheet->getCellByColumnAndRow(26,$i)->getFormattedValue();
            // $management_esi = 0;

            // $department = $objWorksheet->getCellByColumnAndRow(3,$i)->getFormattedValue();
            
            // $email = $objWorksheet->getCellByColumnAndRow(5,$i)->getFormattedValue();
            // $address = $objWorksheet->getCellByColumnAndRow(6,$i)->getFormattedValue();
            
            
            // $gender = $objWorksheet->getCellByColumnAndRow(9,$i)->getFormattedValue();
            
            
            
            //$password = 'lpuvj@123';
    
            // if($department == 'Correspondent' || $department =='Admin Staff' || $department =='System Admin'){
            //     $role_id = 5;
            //     $dept_id = 4;
            // }elseif ($department == 'Head Mistress') {
            //     $role_id = 1;
            //     $dept_id = 5;
            // }elseif ($department == 'Asst. Mistress' || $department == 'Phy Edu Teacher' || $department == 'Music Teacher') {
            //     $role_id = 4;
            //     $dept_id = 44;
            // }elseif ($department == 'Librarian') {
            //     $role_id = 12;
            //     $dept_id = 6;
            // }elseif ($department == 'Supportive Staff') {
            //     $role_id = 8;
            //     $dept_id = 3;
            // }elseif ($department == 'Accountant') {
            //     $role_id = 11;
            //     $dept_id = 2;
            // }else{ lpuvj
            //     $role_id = 4;
            //     $dept_id = 44;
            // }
            // if($designation == 'Principal'){
            //     $role_id = 1;
            //     $dept_id = 4;
            // }else{ 
            //     $role_id = 2;
            //     $dept_id = 4;
            // }
            // $dept ="Teaching";
            // $dept = trim($department);
            $departmentInfo = $this->settings->getStaffDepartmentInfo(strtoupper($dept));

            
            $role_name = trim($role);
            $roleInfo = $this->settings->getStaffRoleInfo($role_name);

            if(!empty($roleInfo)){
                $role_id = $roleInfo->roleId;
            }else{
                $role_id = '';
            }

            if(!empty($departmentInfo)){
                $dept_id = $departmentInfo->dept_id;
            }else{
                $dept_id = '';
            }

            
            
            //$staff_Id = 'LPUC' .$j; // %03d ensures 3 digits with leading zeros

           
    
            if($email == ''){
                $Email = '';
            }else{
                $Email = $email;
            }
            if($mobile_no == ''){
                $Mobile_no = '';
            }else{
                $Mobile_no = trim($mobile_no);
            }
            //  $dateOfBirth = str_replace("/", "-", $dob);
            //  $dateOfJoin = str_replace("/", "-", $doj);

             $dateOfBirth = $dob;
             $dateOfJoin = $doj;

             if($dateOfBirth == ''){
                $DateOfBirth = '';
             }else{
                $DateOfBirth = date('Y-m-d',strtotime($dateOfBirth));
             }

             if($dateOfJoin == ''){
                $DateOfJoin = '';
             }else{
                $DateOfJoin = date('Y-m-d',strtotime($dateOfJoin));
             }
    
            $user_id = 1000 + $count;
            $staff_id = 'MILP'.''.$user_id;

            if(!empty($name)){
                $staffInfo = array(
                    'staff_id' => trim($staff_id),
                    'employee_id' => trim($employee_id),
                    'name' => strtoupper($name),
                    'doj' => $DateOfJoin,
                    'gender' => strtoupper($gender),
                    'mobile' => $Mobile_no,
                    'role' => $role_id,
                    'aadhar_no' => $aadhar_no,
                    // 'pan_no' => $pan_no,
                    // 'pf_number' => $pf_number,
                    // 'esi_code' => $esi_code,
                    'role_name' => $role,
                    // 'uan_no' => $uan_no,
                    //'user_name' => $username,
                    'dob' => $DateOfBirth,
                    // 'father_name' => $father_name,
                    'address' => $address,
                    'email' => $Email,
                    // 'qualification' => $qualification,
                    // 'designation' => $designation,
                    
                    // 'date_of_super_annuation' => date('Y-m-d',strtotime($date_super_annuation)),
                    // 'teaching_experience' => $teaching_exp,
                    // 'articles_published' => $articles,
                    // 'pay_scale' => $pay_scale, 
                    // 'employment_type' => $emp_type,
                    
                    
                    
                    'department_id' => $dept_id,
                    'department' => strtoupper($dept),
                    // 'category' => $category,
                    //'password' => getHashedPassword($password),    
                    //'password_text' => base64_encode($password), 
                    'createdBy' => $this->staff_id,
                    'created_date_time' => date('Y-m-d H:m:s'));
                
                    $result = $this->staff->addNewStaff($staffInfo);
                    $count++;
                    // $staff_id++;
            }
            // if(!empty($staff_id)){ 
            

            //     $bankInfoAdd = array( 
            //         'staff_id' => trim($staff_id), 
            //         'bank_name' => trim($bank_name), 
            //         'branch_name' => trim($branch_name), 
            //         'ifsc_code' => trim($ifsc_code),
            //         'account_no' => trim($account_no),
            //         'created_by'=>$this->staff_id,
            //         'created_date_time'=>date('Y-m-d H:i:s'));

            //     $bankInfoUpdate = array( 
            //         'bank_name' => trim($bank_name), 
            //         'branch_name' => trim($branch_name), 
            //         'ifsc_code' => trim($ifsc_code),
            //         'account_no' => trim($account_no),
            //         'updated_by'=>$this->staff_id,
            //         'updated_date_time'=>date('Y-m-d H:i:s'));
                    
            //     $salary_typeEarnings = array('BASIC','DA','HRA','OTHERS','CON','CCA');
            //     $calculate_typeEarnings = array('AMOUNT','PERCENTAGE','PERCENTAGE','AMOUNT','AMOUNT','AMOUNT');
            //     $value_typeEarnings = array(trim($basic_salary),trim($da_amount),trim($hra_amount),trim($other_earnings),trim($con),trim($cca));
                
            //     $salary_typeDeduction = array('PF','EMPLOYER PF','ESI','EMPLOYER ESI','PT','OTHERS');
            //     $calculate_typeDeduction = array('PERCENTAGE','PERCENTAGE','PERCENTAGE','PERCENTAGE','AMOUNT','AMOUNT');
            //     $value_typeDeduction = array(trim($pf),trim($management_pf),trim($esi),trim($management_esi),trim($pt_amount),trim($other_deduction));

            //     for ($c = 0; $c < count($salary_typeEarnings); $c++) {
            //         $salaryInfoAdd = array( 
            //             'staff_id' => trim($staff_id), 
            //             'salary_type' => $salary_typeEarnings[$c],
            //             'calculate_type' => $calculate_typeEarnings[$c],
            //             'value' => $value_typeEarnings[$c],
            //             'year' => 2025,
            //             'created_by' => $this->staff_id,
            //             'created_date_time' => date('Y-m-d H:i:s')
            //         );
            //         $salaryInfoUpdate = array( 
            //             'staff_id' => trim($staff_id), 
            //             'salary_type' => $salary_typeEarnings[$c],
            //             'calculate_type' => $calculate_typeEarnings[$c],
            //             'value' => $value_typeEarnings[$c],
            //             'year' => 2025,
            //             'updated_by'=>$this->staff_id,
            //             'updated_date_time'=>date('Y-m-d H:i:s')
            //         );

            //         $isSalaryExist = $this->settings->getSalaryDetailsExistEarnings(2025,trim($staff_id),$salary_typeEarnings[$c]);
            //         if(!empty($isSalaryExist)){
            //             $this->settings->updateSalaryEarnings($salaryInfoUpdate,$isSalaryExist->row_id);
            //         }else{
            //             $this->settings->addEarning($salaryInfoAdd);
            //         }
            //     }

            //     for ($j = 0; $j < count($salary_typeDeduction); $j++) {
            //         $salaryInfoAddDeduction = array( 
            //             'staff_id' => trim($staff_id), 
            //             'salary_type' => $salary_typeDeduction[$j],
            //             'calculate_type' => $calculate_typeDeduction[$j],
            //             'value' => $value_typeDeduction[$j],
            //             'year' => 2025,
            //             'created_by' => $this->staff_id,
            //             'created_date_time' => date('Y-m-d H:i:s')
            //         );
            //         $salaryInfoUpdateDeduction = array( 
            //             'staff_id' => trim($staff_id), 
            //             'salary_type' => $salary_typeDeduction[$j],
            //             'calculate_type' => $calculate_typeDeduction[$j],
            //             'value' => $value_typeDeduction[$j],
            //             'year' => 2025,
            //             'updated_by'=>$this->staff_id,
            //             'updated_date_time'=>date('Y-m-d H:i:s')
            //         );

            //         $isSalaryExistDeduction = $this->settings->getSalaryDetailsExistDeduction(2025,trim($staff_id),$salary_typeDeduction[$j]);
            //         if(!empty($isSalaryExistDeduction)){
            //             $this->settings->updateSalaryDeduction($salaryInfoUpdateDeduction,$isSalaryExistDeduction->row_id);
            //         }else{
            //             $this->settings->addDeduction($salaryInfoAddDeduction);
            //         }
            //     }



            //         $result = $this->staff->updateStaffInfoByStaffId($staffInfo,$staff_id);

            //         $isBankExist = $this->staff->checkStaffIdExistsInBankUpdate($staff_id);
            //         if(!empty($isBankExist)){
            //             $this->staff->updateBankInfo($bankInfoUpdate,$isBankExist->row_id);
            //         }else{
            //             $this->staff->addBankInfo($bankInfoAdd);
            //         }


                // }
            $j++;
                log_message('debug','Inserted Record=='.print_r($staffInfo,true));
        }
        redirect('viewSettings');
    }

          public function addAllApprovedStudent(){
         
            $studentInfo = $this->admission->getAllAdmittedStudentInfo();
            
            foreach($studentInfo as $std){  

            $permanent_add = $std->permanent_address_line_1.' '.$std->permanent_address_line_2.' '.$std->permanent_address_district.','.$std->permanent_address_state.','.$std->permanent_address_pincode;
            $present_add = $std->residential_address_line_1.' '.$std->residential_address_line_2.' '.$std->residential_address_district.','.$std->residential_address_state.','.$std->residential_address_pincode;

                           
                $isExists = $this->student->getStudentByApplication_no($std->application_number);
                if(!empty($isExists)){
                    $student_info = array(
                    'student_name'=>$std->name,
                    'blood_group' =>$std->blood_group,
                    'mobile' => $std->student_mobile,
                    'email' => $std->email,
                    'gender' => $std->gender,
                    'residential_address' => $permanent_add,
                    'category' => $std->student_category,
                    'last_board_name' => $std->board_name,
                    'last_percentage' => $std->sslc_percentage,
                    'last_register_number' => $std->register_number,
                    'is_physically_challenged' => $std->physically_challenged,
                    'is_dyslexic' => $std->dyslexia_challenged,
                    'present_address' => $present_add,
                    'mother_tongue'=>$std->mother_tongue,
                    'nationality'=>$std->nationality,  
                    'religion'=>$std->religion, 
                    'caste'=>$std->caste, 
                    'sub_caste' => $std->sub_caste,
                    'father_name'=>$std->father_name, 
                    'father_email' => $std->father_email,
                    'father_mobile' => $std->father_mobile,
                    'father_educational_qualification' => $std->father_qualification,
                    'father_age' => $std->father_age,
                    'father_profession'=>$std->father_profession,
                    'mother_name'=>$std->mother_name,
                    'mother_email' => $std->mother_email,
                    'mother_mobile' => $std->mother_mobile,
                    'mother_educational_qualification' => $std->mother_qualification,
                    'mother_age' => $std->mother_age,
                    'mother_profession' => $std->mother_profession,
                    'father_annual_income'=>$std->father_annual_income,
                    'mother_annual_income'=>$std->mother_annual_income,
                    'guardian_name' => $std->guardian_name,
                    'guardian_mobile' => $std->guardian_mobile,
                    'guardian_address' => $std->guardian_address,
                    'native_place' => $std->native_place,
                    'aadhar_no' => $std->aadhar_no,
                    'dob' => $std->dob,
                    'updated_by'=>$this->staff_id,
                    'updated_date_time'=>date('Y-m-d H:i:s'));

                    $return = $this->student->updateStudentInfoByAppNo($student_info,$std->application_number);
                
            }
        }
        $this->session->set_flashdata('success', 'Updated successfully');
        redirect('viewSettings');
    

}

public function createExamRowIdUpdate(){
         
    ini_set('memory_limit', '1024M');
    ini_set("pcre.backtrack_limit", "5000000");
    ini_set('max_execution_time', -1);
    $exam_type = $this->security->xss_clean($this->input->post('exam_type'));
    
    $examInfo = $this->exam->getAllExamMarkInfoByExamType($exam_type);
   
    if(!empty($examInfo)){
        foreach($examInfo as $exam){ 

            $studentInfo = $this->student->getStudentInfoByStudent_ID($exam->student_id);

            $createExamInfo = $this->exam->getCreateExamDetailsByStudentInfo($exam_type,$studentInfo->term_name,$studentInfo->stream_name,$exam->subject_code);

            $mark_info = array(
                'exam_row_id'=>$createExamInfo->row_id,
                'updated_by'=>$this->staff_id,
                'updated_date_time'=>date('Y-m-d H:i:s')
            );
            $return = $this->exam->updateSchoolInteralMarks($mark_info,$exam->row_id);

        }
    }else{
        $this->session->set_flashdata('error', 'Not Entered Marks To Update');
        redirect('viewSettings');
    }
    
    if($return > 0){
        $this->session->set_flashdata('success', 'Updated Successfully');
    } else{
        $this->session->set_flashdata('error', 'Update Failed');
    }
    redirect('viewSettings');


}


function addMiscellaneousType(){
    if($this->isAdmin() == TRUE) {
        $this->loadThis();
    }  else {
        $miscellaneousType =$this->security->xss_clean($this->input->post('miscellaneousType'));
        $miscellaneousAmount =$this->security->xss_clean($this->input->post('miscellaneousAmount'));
        $miscellaneousInfo = array('miscellaneous_type'=>$miscellaneousType,'miscellaneous_amount'=>$miscellaneousAmount,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));
        $result = $this->settings->addMiscellaneousType($miscellaneousInfo);
        if($result > 0){
            $this->session->set_flashdata('success', 'New Miscellaneous Type created successfully');
        } else{
            $this->session->set_flashdata('error', 'Miscellaneous Type creation failed');
        }
        redirect('viewSettings');
    }
}

public function deleteMiscellaneousType(){
    if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
        $this->loadThis();
    } else {   
        $row_id = $this->input->post('row_id');
        $miscellaneousInfo = array('is_deleted' => 1,
        'updated_date_time' => date('Y-m-d H:i:s'),
        'updated_by' => $this->staff_id
        );
        $result = $this->settings->updateMiscellaneousType($miscellaneousInfo, $row_id);
        // log_message('debug','post'.print_r($postInfo));
        if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
    } 
}


public function employeeIdUpdate() {
    if($this->isAdmin() == TRUE)
    {
        $this->loadThis();
    }  else {
        $employeeIdInfo = $this->settings->getEmployeeId();
        $number_part_15 = 0;
       
        foreach($employeeIdInfo as $info){
            if(!empty($info->doj) && $info->doj!= '0000-00-00'){
            $dateOfJoin = str_replace(".", "-", $info->doj);
         
                $number_part_15++;
                $unitName = "LPUV";
                $number_part_15 = sprintf('%04d',$number_part_15);
                $employee_id = date('Y',strtotime($dateOfJoin)).$unitName.$number_part_15;
               
                $staffInfo = array(
                    'employee_id'   => trim($employee_id));
 
                $result = $this->settings->updateEmployeeIdInfo($staffInfo,trim($info->row_id));
           
          }
        }
        if($result > 0){
            $this->session->set_flashdata('success', 'Updated successfully');
        } else{
            $this->session->set_flashdata('error', 'Update failed');
        }
        redirect('viewSettings');
    }
}

public function addDocName() {
    if($this->isAdmin() == TRUE)
    {
        $this->loadThis();
    }  else {
        $doc_name =$this->security->xss_clean($this->input->post('doc_name'));
        $isExist = $this->settings->checkDocNameExists($doc_name);
        if ($isExist) { // Check if $isExist is truthy
            $this->session->set_flashdata('error', 'Document is already Exist');
            redirect('viewSettings');
        }
        $documentInfo = array('document_name'=>$doc_name,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));
        $result = $this->settings->addDocName($documentInfo);
        if($result > 0){
            $this->session->set_flashdata('success', 'New Document Type created successfully');
        } else{
            $this->session->set_flashdata('error', 'Document Type creation failed');
        }
        redirect('viewSettings');
    }
}

public function deleteDocumentType(){
    if($this->isAdmin() == TRUE){
        $this->loadThis();
    } else {   
        $row_id = $this->input->post('row_id');
        $categoryInfo = array('is_deleted' => 1,
        'updated_date_time' => date('Y-m-d H:i:s'),
        'updated_by' => $this->staff_id
        );
        $result = $this->settings->updateDocumentType($categoryInfo, $row_id);
        if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
    } 
}

// Exam marks import
public function importSalaryInfo(){
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
    $count = 0;


    for($i=4;$i<=$highestRow;$i++){
     
        $staff_id = $objWorksheet->getCellByColumnAndRow(3,$i)->getFormattedValue();
        // $date_of_join = $objWorksheet->getCellByColumnAndRow(3,$i)->getFormattedValue();
        // $aadhar_no = $objWorksheet->getCellByColumnAndRow(5,$i)->getFormattedValue();
        // $pan_no = $objWorksheet->getCellByColumnAndRow(6,$i)->getFormattedValue();
        // $mobile = $objWorksheet->getCellByColumnAndRow(7,$i)->getFormattedValue();
        // $uan_no = $objWorksheet->getCellByColumnAndRow(9,$i)->getFormattedValue();
        // $pf_number = $objWorksheet->getCellByColumnAndRow(10,$i)->getFormattedValue();
        // $esi_code = $objWorksheet->getCellByColumnAndRow(11,$i)->getFormattedValue();
        // $bank_name = $objWorksheet->getCellByColumnAndRow(12,$i)->getFormattedValue();
        // $branch_name = $objWorksheet->getCellByColumnAndRow(13,$i)->getFormattedValue();
        // $ifsc_code = $objWorksheet->getCellByColumnAndRow(14,$i)->getFormattedValue();
        // $account_no = $objWorksheet->getCellByColumnAndRow(15,$i)->getFormattedValue();
        $basic_salary = $objWorksheet->getCellByColumnAndRow(7,$i)->getFormattedValue();
        $da = $objWorksheet->getCellByColumnAndRow(8,$i)->getFormattedValue();
        $hra = $objWorksheet->getCellByColumnAndRow(9,$i)->getFormattedValue();
        $admchrg = $objWorksheet->getCellByColumnAndRow(13,$i)->getFormattedValue();
        $others = $objWorksheet->getCellByColumnAndRow(23,$i)->getFormattedValue();
        $pt = $objWorksheet->getCellByColumnAndRow(19,$i)->getFormattedValue();
        $esi = $objWorksheet->getCellByColumnAndRow(16,$i)->getFormattedValue();

        
        if(!empty($pt)){
            $pt_amount = $pt;
        }else{
            $pt_amount = 0;
        }

        if(!empty($esi)){
            $esi = $objWorksheet->getCellByColumnAndRow(16,$i)->getFormattedValue();
            $management_esi = $objWorksheet->getCellByColumnAndRow(11,$i)->getFormattedValue();
        }else{
            $esi = 0;
            $management_esi = 0;
        }

        $da_amount = $objWorksheet->getCellByColumnAndRow(8,$i)->getFormattedValue();
        $hra_amount = $objWorksheet->getCellByColumnAndRow(9,$i)->getFormattedValue();

        $pf = $objWorksheet->getCellByColumnAndRow(15,$i)->getFormattedValue();
        $management_pf = $objWorksheet->getCellByColumnAndRow(12,$i)->getFormattedValue();

        if(!empty($others)){
            $other_amount = $others;
        }else{
            $other_amount = 0;
        }

        
        $dateOfJoin = str_replace("/", "-", $date_of_join);
        // $dateOfBirth = str_replace(".", "-", $date_of_birth);


        if(!empty($staff_id)){ 
            
            // $staffInfo = array(
            //     'doj' => date('Y-m-d',strtotime($dateOfJoin)), 
            //     'aadhar_no' => trim($aadhar_no), 
            //     'pan_no' => trim($pan_no), 
            //     'mobile_one' => trim($mobile),
            //     'uan_no' => trim($uan_no),
            //     'pf_number' => trim($pf_number), 
            //     'esi_code' => trim($esi_code), 
            //     'updated_by'=>$this->staff_id,
            //     'modified_date_time'=>date('Y-m-d H:i:s'));

            //     $bankInfoAdd = array( 
            //         'staff_id' => trim($staff_id), 
            //         'bank_name' => trim($bank_name), 
            //         'branch_name' => trim($branch_name), 
            //         'ifsc_code' => trim($ifsc_code),
            //         'account_no' => trim($account_no),
            //         'created_by'=>$this->staff_id,
            //         'created_date_time'=>date('Y-m-d H:i:s'));

            //     $bankInfoUpdate = array( 
            //         'bank_name' => trim($bank_name), 
            //         'branch_name' => trim($branch_name), 
            //         'ifsc_code' => trim($ifsc_code),
            //         'account_no' => trim($account_no),
            //         'updated_by'=>$this->staff_id,
            //         'updated_date_time'=>date('Y-m-d H:i:s'));
                    
                $salary_typeEarnings = array('BASIC','DA','HRA','OTHERS');
                $calculate_typeEarnings = array('AMOUNT','PERCENTAGE','PERCENTAGE','AMOUNT');
                $value_typeEarnings = array(trim($basic_salary),trim($da_amount),trim($hra_amount),trim($other_amount));
                
                $salary_typeDeduction = array('PF','EMPLOYER PF','ESI','EMPLOYER ESI','PT','ADM CHRG');
                $calculate_typeDeduction = array('PERCENTAGE','PERCENTAGE','PERCENTAGE','PERCENTAGE','AMOUNT','PERCENTAGE');
                $value_typeDeduction = array(trim($pf),trim($management_pf),trim($esi),trim($management_esi),trim($pt_amount),trim($admchrg));

                for ($c = 0; $c < count($salary_typeEarnings); $c++) {
                    $salaryInfoAdd = array( 
                        'staff_id' => trim($staff_id), 
                        'salary_type' => $salary_typeEarnings[$c],
                        'calculate_type' => $calculate_typeEarnings[$c],
                        'value' => $value_typeEarnings[$c],
                        'year' => 2025,
                        'created_by' => $this->staff_id,
                        'created_date_time' => date('Y-m-d H:i:s')
                    );
                    $salaryInfoUpdate = array( 
                        'staff_id' => trim($staff_id), 
                        'salary_type' => $salary_typeEarnings[$c],
                        'calculate_type' => $calculate_typeEarnings[$c],
                        'value' => $value_typeEarnings[$c],
                        'year' => 2025,
                        'updated_by'=>$this->staff_id,
                        'updated_date_time'=>date('Y-m-d H:i:s')
                    );

                    $isSalaryExist = $this->settings->getSalaryDetailsExistEarnings(2025,trim($staff_id),$salary_typeEarnings[$c]);
                    if(!empty($isSalaryExist)){
                        $this->settings->updateSalaryEarnings($salaryInfoUpdate,$isSalaryExist->row_id);
                    }else{
                        $this->settings->addEarning($salaryInfoAdd);
                    }
                }

                for ($j = 0; $j < count($salary_typeDeduction); $j++) {
                    $salaryInfoAddDeduction = array( 
                        'staff_id' => trim($staff_id), 
                        'salary_type' => $salary_typeDeduction[$j],
                        'calculate_type' => $calculate_typeDeduction[$j],
                        'value' => $value_typeDeduction[$j],
                        'year' => 2025,
                        'created_by' => $this->staff_id,
                        'created_date_time' => date('Y-m-d H:i:s')
                    );
                    $salaryInfoUpdateDeduction = array( 
                        'staff_id' => trim($staff_id), 
                        'salary_type' => $salary_typeDeduction[$j],
                        'calculate_type' => $calculate_typeDeduction[$j],
                        'value' => $value_typeDeduction[$j],
                        'year' => 2025,
                        'updated_by'=>$this->staff_id,
                        'updated_date_time'=>date('Y-m-d H:i:s')
                    );

                    $isSalaryExistDeduction = $this->settings->getSalaryDetailsExistDeduction(2025,trim($staff_id),$salary_typeDeduction[$j]);
                    if(!empty($isSalaryExistDeduction)){
                        $this->settings->updateSalaryDeduction($salaryInfoUpdateDeduction,$isSalaryExistDeduction->row_id);
                    }else{
                        $this->settings->addDeduction($salaryInfoAddDeduction);
                    }
                }



                    // $result = $this->staff->updateStaffInfoByStaffId($staffInfo,$staff_id);

                    // $isBankExist = $this->staff->checkStaffIdExistsInBankUpdate($staff_id);
                    // if(!empty($isBankExist)){
                    //     $this->staff->updateBankInfo($bankInfoUpdate,$isBankExist->row_id);
                    // }else{
                    //     $this->staff->addBankInfo($bankInfoAdd);
                    // }


                }
            
        } 
            redirect('viewSettings');
    }

    public function addYearWise() {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            
            $data_students = $this->settings->getAllstudentInformation();
            foreach($data_students as $student_id){  
                     
                    $yearWiseInfo = array(
                    'stud_row_id' => $student_id->row_id,
                    'class' => $student_id->term_name,
                    'section' => $student_id->section_name,
                    'stream' => $student_id->stream_name,
                    'intake_year' => CURRENT_YEAR);
                $isExists = $this->settings->checkYearWiseExists($student_id->row_id,CURRENT_YEAR);
                if(!empty($isExists)){
                    $this->settings->updateYearWiseInfo($yearWiseInfo,$student_id->row_id,CURRENT_YEAR);  
                }else{
                    $this->settings->addYearWiseInfo($yearWiseInfo);
                }

            }
             $this->session->set_flashdata('success', 'Added Succesfully');
             redirect('viewSettings');
        }
    }

    public function addStaffShiftinfo(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {
            $shift_code = strtoupper(trim($this->security->xss_clean($this->input->post('shift_code'))));
            $name = trim($this->security->xss_clean($this->input->post('name')));
            $start_time = trim($this->security->xss_clean($this->input->post('start_time')));
            $end_time = trim($this->security->xss_clean($this->input->post('end_time')));

            if(empty($shift_code) || empty($name) || empty($start_time) || empty($end_time)){
                $this->session->set_flashdata('error', 'Please enter all staff shift details');
                redirect('viewSettings');
            }

            $isExist = $this->settings->checkStaffShiftExists($shift_code);
            if($isExist > 0){
                $this->session->set_flashdata('warning', 'Staff Shift Code already exists!');
                redirect('viewSettings');
            }

            $shiftInfo = array(
                'shift_code' => $shift_code,
                'name' => $name,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'created_by' => $this->staff_id,
                'created_date_time' => date('Y-m-d H:i:s')
            );

            $result = $this->settings->addStaffShiftinfo($shiftInfo);
            if($result > 0){
                $this->session->set_flashdata('success', 'Staff Shift Info added successfully');
            } else {
                $this->session->set_flashdata('error', 'Staff Shift Info creation failed');
            }
            redirect('viewSettings');
        }
    }

    public function updateTimingsInfo(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('Urow_id');
            $name = $this->input->post('shiftname');
            $class_start = $this->input->post('class_start');
            $class_end = $this->input->post('class_end');
          
            $timingInfo = array(
            'name'  => $name,
            'start_time'  => $class_start,
            'end_time'  => $class_end,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateclassTimingInfo($timingInfo, $row_id);
            if($result  == true){
                $this->session->set_flashdata('success', 'Staff Shift Info updated successfully');
            } else{
                $this->session->set_flashdata('error', 'Staff Shift updation failed');
            }
            redirect('viewSettings');
       
         } 
    }
    public function deleteShiftInfo(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $shiftInfo = array(
                'is_deleted' => 1,
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateshiftinfo($shiftInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
     //add Remarks name information
   function addRemarkName(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }  else {
                $remark_name =$this->security->xss_clean($this->input->post('remark_name'));
                $remarkInfo = array('remark_name'=>$remark_name,
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->settings->addRemarkName($remarkInfo);
                if($result > 0){
                    $this->session->set_flashdata('success', 'New Student Observation created successfully');
                } else{
                    $this->session->set_flashdata('error', 'Student Observation creation failed');
                }
                redirect('viewSettings');
        }
        
    }


    public function deleteRemarkName(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $remarkInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->settings->deleteRemarkName($remarkInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
        public function addModule(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $module_name =$this->security->xss_clean($this->input->post('menu_name'));
            $icon_name =$this->security->xss_clean($this->input->post('icon'));
            $priority =$this->security->xss_clean($this->input->post('priority'));
            $isExist = $this->settings->checkModuleExists($module_name);
            if ($isExist) {
                $this->session->set_flashdata('error', 'Module is already Exist');
                redirect('viewSettings');
            }
            $moduleInfo = array('menu_name'=>$module_name,'icon'=>$icon_name,'priority'=>$priority,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));
            $result = $this->settings->addModule($moduleInfo);
            if($result > 0){
                $this->session->set_flashdata('success', 'New Module created successfully');
            } else{
                $this->session->set_flashdata('error', 'Module creation failed');
            }
            redirect('viewSettings');
        }
    }
    public function updateModule(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $row_id =$this->security->xss_clean($this->input->post('row_id'));
            $module_name =$this->security->xss_clean($this->input->post('menu_name'));
            $priority =$this->security->xss_clean($this->input->post('priority'));
            $moduleInfo = array('menu_name'=>$module_name,'priority'=>$priority);
            $result = $this->settings->updateModule($moduleInfo,$row_id);
            if($result > 0){
                $this->session->set_flashdata('success', 'Module updated successfully');
            } else{
                $this->session->set_flashdata('error', 'Module updation failed');
            }
            redirect('viewSettings');
        }
    }
     public function deleteModule(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $moduleInfo = array('is_deleted' => 1,
            );
            $result = $this->settings->updateModule($moduleInfo, $row_id);
            if($result > 0){
                $this->session->set_flashdata('success', 'Module deleted successfully');
            } else{
                $this->session->set_flashdata('error', 'Module deletion failed');
            }
            redirect('viewSettings');
        }
    }

    public function addSubModule(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $sub_module_name =$this->security->xss_clean($this->input->post('sub_menu_name'));
            $module_id =$this->security->xss_clean($this->input->post('module_id'));
            $link =$this->security->xss_clean($this->input->post('link'));
            $priority =$this->security->xss_clean($this->input->post('priority'));
            $icon_name =$this->security->xss_clean($this->input->post('icon'));
            $isExist = $this->settings->checkSubModuleExists($sub_module_name,$module_id);
            if ($isExist) {
                $this->session->set_flashdata('error', 'Sub Module is already Exist');
                redirect('viewSettings');
            }
            $subModuleInfo = array('menu_name'=>$sub_module_name,'module_id'=>$module_id,'redirect_url'=>$link,'priority'=>$priority,'icon'=>$icon_name,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));
            $result = $this->settings->addSubModule($subModuleInfo);
            if($result > 0){
                $this->session->set_flashdata('success', 'New Sub Module created successfully');
            } else{
                $this->session->set_flashdata('error', 'Sub Module creation failed');
            }
            redirect('viewSettings');
        }
    }
    public function updateSubModule(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $row_id =$this->security->xss_clean($this->input->post('row_id'));
            $sub_module_name =$this->security->xss_clean($this->input->post('sub_menu_name'));
            $link =$this->security->xss_clean($this->input->post('link'));
            $priority =$this->security->xss_clean($this->input->post('priority'));
            $subModuleInfo = array('menu_name'=>$sub_module_name,'redirect_url'=>$link,'priority'=>$priority);
            $result = $this->settings->updateSubModule($subModuleInfo,$row_id);
            if($result > 0){
                $this->session->set_flashdata('success', 'Sub Module updated successfully');
            } else{
                $this->session->set_flashdata('error', 'Sub Module updation failed');
            }
            redirect('viewSettings');
        }
    }
     public function deleteSubModule(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $subModuleInfo = array('is_deleted' => 1,
            );
            $result = $this->settings->updateSubModule($subModuleInfo, $row_id);
            if($result > 0){
                $this->session->set_flashdata('success', 'Sub Module deleted successfully');
            } else{
                $this->session->set_flashdata('error', 'Sub Module deletion failed');
            }
            redirect('viewSettings');
        }
    }

    public function getInactiveStudentsImport(){
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
    
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestDataRow(); 
        $student_update_count = 0;

        for($i=2;$i<=$highestRow;$i++){
            $student_id = $objWorksheet->getCellByColumnAndRow(1,$i)->getFormattedValue();

            if(!empty($student_id)){
                $studentRow = $this->student->getStudentByStudentId(trim($student_id));

                if(!empty($studentRow)){
                    $row_id = $studentRow->row_id;

                    $studentInfo = array(
                        'std_status' => 1,
                        'updated_by' => $this->staff_id,
                        'updated_date_time' => date('Y-m-d H:i:s')
                    );
                    $this->student->updateStudentInfo($studentInfo, $row_id);

                    $yearWiseInfo = array(
                        'discontinued_status' => 1,
                        'updated_by' => $this->staff_id,
                        'updated_date_time' => date('Y-m-d H:i:s')
                    );
                    $this->student->updateStudentActiveInfo($yearWiseInfo, $row_id);

                    $student_update_count++;
                    log_message('debug','updated student_id == '.$student_id.' row_id == '.$row_id);
                } else {
                    log_message('debug','student not found for student_id == '.$student_id);
                }
            }
        }
        log_message('debug','total updated == '.$student_update_count);
        redirect('viewSettings');
    }

}
