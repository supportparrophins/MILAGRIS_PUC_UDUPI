<div class="main-content-container container-fluid px-4 pt-2">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card card-small p-0 card_heading_title">
                    <div class="card-body p-1 card-content-title">
                        <div class="row ">
                            <div class="col-lg-8 col-md-8 col-8 text-black" style="font-size:22px;">
                                <i class="fa fa-users"></i>&nbsp;Detailed View of <?php echo strtoupper($studentInfo->student_name); ?>
                            </div>
                            <div class="col-lg-4 col-md-4 col-4"> 
                                <a href="#" onclick="GoBackWithRefresh();return false;" class="btn text-white primary_color btn-bck float-right mobile-bck ">
                                <i class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Back </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- form start -->
        <!-- Default Light Table -->
        <?php if(empty($studentInfo)){ ?>
        <div class="row form-employee">
            <div class="col-lg-12 col-md-12 col-12 pr-0 text-center">
            <img height="270" src="<?php echo base_url(); ?>assets/images/404.png"/>
            </div>
        </div>
        <?php } else {  ?>
        <div class="row form-employee">
            <div class="col-12">
                <div class="card card-small c-border p-0 mb-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-1">
                            <div class="row">
                                <div class="col profile-head">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="personal-tab" data-toggle="tab"
                                                href="#personal" role="tab" aria-controls="personal"
                                                aria-selected="false">Personal Info</a>
                                        </li>
                                        <?php if($role != ROLE_FINANCE_OFFICER){ ?>
                                        <li class="nav-item">
                                            <a class="nav-link" id="academic-tab" data-toggle="tab" href="#academic"
                                                role="tab" aria-controls="academic" aria-selected="true">Academic
                                                Info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="performance-tab" data-toggle="tab" href="#performance" role="tab" aria-controls="performance" aria-selected="false">Performance</a>
                                        </li>
                                        <!-- <li class="nav-item">
                                            <a class="nav-link" id="first_unit_test-tab" data-toggle="tab" href="#first_unit_test"
                                                role="tab" aria-controls="first_unit_test" aria-selected="true">I Unit Test
                                            </a>
                                        </li> -->
                                        <!-- <li class="nav-item">
                                            <a class="nav-link" id="first_term-tab" data-toggle="tab" href="#first_term"
                                                role="tab" aria-controls="first_term" aria-selected="true">I Term
                                            </a>
                                        </li> -->
                                        <!-- <li class="nav-item">
                                            <a class="nav-link" id="mid_term-tab" data-toggle="tab" href="#mid_term"
                                                role="tab" aria-controls="mid_term" aria-selected="true">MID TERM
                                            </a>
                                        </li> -->
                                        <?php } ?> 
                                         <!-- <li class="nav-item">
                                            <a class="nav-link" id="second_unit_test-tab" data-toggle="tab" href="#second_unit_test"
                                                role="tab" aria-controls="second_unit_test" aria-selected="true">II Unit Test
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="preparatory-tab" data-toggle="tab" href="#preparatory"
                                                role="tab" aria-controls="preparatory" aria-selected="true">Preparatory
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="annual-tab" data-toggle="tab" href="#annual"
                                                role="tab" aria-controls="annual" aria-selected="true">Annual Exam
                                            </a>
                                        </li> -->
                                        <?php if($role != ROLE_OFFICE && $role != ROLE_TEACHING_STAFF){ ?>
                                        <li class="nav-item">
                                            <a class="nav-link" id="paidInfo-tab" data-toggle="tab" href="#paidInfo"
                                                role="tab" aria-controls="paidInfo" aria-selected="true">Fee Paid Info</a>
                                        </li>
                                        <?php } ?>
                                        <?php if($role != ROLE_FINANCE_OFFICER){ ?>
                                        <li class="nav-item">
                                            <a class="nav-link" id="notification-tab" data-toggle="tab" href="#notification"
                                                role="tab" aria-controls="notification" aria-selected="true">Notification</a>
                                        </li>
                                        <?php } ?> 
                                        <li class="nav-item">
                                            <a class="nav-link" id="classInfo-tab" data-toggle="tab" href="#classActiveInfo"
                                            role="tab" aria-controls="paidInfo" aria-selected="true">Year-wise Active/Inactive
                                            Info</a>
                                        </li>
                                        <?php if($role == ROLE_TEACHING_STAFF || $this->staff_id == '123456' || $role == ROLE_SUPER_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR){ ?>
                                        <li class="nav-item">
                                            <a class="nav-link" id="observation-tab" data-toggle="tab" href="#observation"
                                                role="tab" aria-controls="observation" aria-selected="true">Observation</a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                    <div class="tab-content personal-tab" id="myTabContent">
                                        <div class="tab-pane fade show active" id="personal" role="tabpanel"
                                            aria-labelledby="personal-tab">
                                            <div class="table-responsive-sm table-responsive-md table-responsive-xs">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <!-- <td style="background:white" width="160" rowspan="11"
                                                            class="p-0">
                                                            <div class="profile-img">
                                                                <?php  $image_path = $studentInfo->photo_url;
                                                                    if(!empty($image_path)){ ?>
                                                                <img src="<?php echo $image_path; ?>"
                                                                    class="avatar img-thumbnail" alt="Profile Image"
                                                                    id="uploadedImage" />
                                                                <?php } else { ?>
                                                                <img src="<?php echo base_url(); ?>assets/dist/img/user.png"
                                                                    class="avatar img-thumbnail" id="uploadedImage"
                                                                    alt="Profile default">
                                                                <?php } ?>
                                                            </div>
                                                        </td> -->
                                                        <td style="background:white" width="160" rowspan="11" class="p-0">
                                                            <div class="profile-img">
                                                                <?php
                                                                $student_id = $studentInfo->admission_no;
                                                                $image_path = '';
                                                                $extensions = ['jpg', 'jpeg', 'png'];

                                                                foreach ($extensions as $ext) {

                                                                    // Exact file: 12345.jpg
                                                                    $exact_file = FCPATH . 'upload/student_photo/' . $student_id . '.' . $ext;

                                                                    // Old format: 12345 Name.jpg
                                                                    $pattern = FCPATH . 'upload/student_photo/' . $student_id . ' *.' . $ext;

                                                                    if (file_exists($exact_file)) {
                                                                        $image_path = base_url('upload/student_photo/' . $student_id . '.' . $ext) . '?v=' . time();
                                                                        break;
                                                                    } else {
                                                                        $matches = glob($pattern);
                                                                        if (!empty($matches)) {
                                                                            $filename = basename($matches[0]);
                                                                            $image_path = base_url('upload/student_photo/' . $filename) . '?v=' . time();
                                                                            break;
                                                                        }
                                                                    }
                                                                }

                                                                if (!empty($image_path)) {?>
                                                                    <img src="<?php echo $image_path; ?>" class="avatar img-thumbnail" alt="Profile Image" id="uploadedImage">
                                                                <?php } else { ?>
                                                                    <img src="<?php echo base_url('assets/dist/img/user.png'); ?>" class="avatar img-thumbnail" id="uploadedImage" alt="Profile default">
                                                                <?php } ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="tbl-head" width="80">Application No.</th>
                                                        <th class="tbl-head-content" width="120">
                                                            <?php echo $studentInfo->application_no; ?>
                                                        </th>
                                                        <th class="tbl-head text-uppercase" width="140">Full Name</th>
                                                        <th class="tbl-head-content text-uppercase" width="240">
                                                            <?php echo strtoupper($studentInfo->student_name); ?>
                                                        </th>
                                                        <th class="tbl-head" width="140">Date of Birth</th>
                                                        <th class="tbl-head-content" width="120">
                                                            <?php if(empty($studentInfo->dob) || $studentInfo->dob == '0000-00-00'){
                                                                echo "";
                                                            } else{
                                                                echo date('d-m-Y',strtotime($studentInfo->dob));
                                                            } ?>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="tbl-head" width="140">Gender</th>
                                                        <th class="tbl-head-content" width="180">
                                                            <?php echo $studentInfo->gender; ?>
                                                        </th>
                                                        <th class="tbl-head">Blood Group</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->blood_group; ?>
                                                        </th>
                                                        <th class="tbl-head">Nationality</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->nationality; ?>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="tbl-head">Religion</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->religion; ?>
                                                        </th>
                                                        <th class="tbl-head">Caste</th>
                                                        <th class="tbl-head-content"><?php echo $studentInfo->caste; ?></th>
                                                        <th class="tbl-head">Category</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->category; ?>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                    <th class="tbl-head">Sub Caste</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->sub_caste; ?>
                                                        </th>
                                                        <th class="tbl-head">Mother Tongue</th>
                                                        <th class="tbl-head-content text-uppercase">
                                                            <?php echo $studentInfo->mother_tongue; ?>
                                                        </th>
                                                        <th class="tbl-head">Mobile</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->mobile; ?>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                    <th class="tbl-head">Admission Status</th>
                                                    <th class="tbl-head-content">
                                                        <?php if($studentInfo->admission_status == '1'){
                                                            echo "New Admission";}else{
                                                                echo "Regular";
                                                            }; ?>
                                                    </th>
                                                    <th class="tbl-head">Intake Year</th>
                                                    <th class="tbl-head-content">
                                                        <?php echo $studentInfo->intake_year; ?>
                                                    </th>
                                                    <th class="tbl-head">Register No</th>
                                                    <th class="tbl-head-content">
                                                        <?php echo $studentInfo->register_no; ?>
                                                    </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="tbl-head">Aadhar No</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->aadhar_no; ?>
                                                        </th>
                                                        <th class="tbl-head">Transport Route</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->route_name; ?>
                                                        </th>
                                                        <th class="tbl-head">Transport Type</th>
                                                        <th class="tbl-head-content">
                                                            <?php  if($studentInfo->bus_status == 1){echo "PERSONAL TRANSPORT";}elseif($studentInfo->bus_status == 2){echo "SCHOOL BUS";};  ?>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="tbl-head">Place Of Birth</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->place_of_birth; ?>
                                                        </th>
                                                        <th class="tbl-head">Taluk</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->taluk; ?>
                                                        </th>

                                                        <th class="tbl-head">District</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->district; ?>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="tbl-head">State</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->state; ?>
                                                        </th>
                                                        <th class="tbl-head">Pincode</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->pincode; ?>
                                                        </th>
                                                        <th class="tbl-head">Admission No.</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->admission_no; ?>
                                                        </th>
                                                    
                                                  
                                                </table>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="head-title">
                                                            <th colspan="7" class="text-center tbl-head">Family Info</th>
                                                        </tr>
                                                        <tr class="head-title tbl-head">
                                                            <th>Member Name</th>
                                                            <th>Relationship</th>
                                                            <th>Qualification</th>
                                                            <th>Profession</th>
                                                            <th>Annual Income</th>
                                                            <th>Mobile Number</th>
                                                            <th>Email Id</th>
                                                        </tr>
                                                    </thead>
                                                    <tr class="tbl-head-content">
                                                        <th class="text-uppercase"><?php echo $studentInfo->father_name; ?></th>
                                                        <th>Father</th>
                                                        <th><?php echo $studentInfo->father_educational_qualification; ?></th>
                                                        <th><?php echo $studentInfo->father_profession; ?></th>
                                                        <th><?php echo $studentInfo->father_annual_income; ?></th>
                                                        <th><?php echo $studentInfo->father_mobile; ?></th>
                                                        <th><?php echo $studentInfo->father_email; ?></th>
                                                    </tr>
                                                    <tr class="tbl-head-content">
                                                        <th class="text-uppercase"><?php echo $studentInfo->mother_name; ?></th>
                                                        <th>Mother</th>
                                                        <th><?php echo $studentInfo->mother_educational_qualification; ?></th>
                                                        <th><?php echo $studentInfo->mother_profession; ?></th>
                                                        <th><?php echo $studentInfo->mother_annual_income; ?></th>
                                                        <th><?php echo $studentInfo->mother_mobile; ?></th>
                                                        <th><?php echo $studentInfo->mother_email; ?></th>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-12 mb-1">
                                                    <div class="card" style="font-size:16px; font-weight:900">
                                                        <div class="card-header head-title text-center p-1 tbl-head">
                                                            <span style="font-size:16px; font-weight:900">Present Address
                                                            </span></div>
                                                        <div class="card-body p-1 tbl-head-content font-weight-bold">
                                                            <?php echo $studentInfo->present_address; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12 mb-1">
                                                    <div class="card " style="font-size:16px; font-weight:900">
                                                        <div class="card-header head-title text-center p-1 tbl-head">
                                                            <span style="font-size:16px; font-weight:900">Permanent Address</span></div>
                                                        <div class="card-body p-1 tbl-head-content font-weight-bold">
                                                            <?php echo $studentInfo->permanent_address; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive mt-1">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th class="tbl-head" width="250">Physically Challenged</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->Is_physically_challenged; ?> 
                                                        </th>
                                                        <th class="tbl-head" width="250">Dyslexia</th>
                                                        <th class="tbl-head-content">
                                                        <?php echo $studentInfo->is_dyslexic; ?>
                                                        </th>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="performance" role="tabpanel" aria-labelledby="performance-tab">
                                            <ul class="nav nav-tabs" id="examTypeTab" role="tablist">
                                                <?php if (!empty($examTypeInfo)) {
                                                    foreach ($examTypeInfo as $examm) { ?>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="<?php echo $examm->exam_type; ?>-tab" data-toggle="tab" href="#<?php echo $examm->exam_type; ?>" role="tab" aria-controls="<?php echo $examm->exam_type; ?>" aria-selected="false"><?php echo $examm->exam_type; ?></a>
                                                        </li>
                                                    <?php }
                                                } ?>
                                            </ul>

                                            <div class="tab-content" id="examTypeTabContent">
                                                <?php if (!empty($examTypeInfo)) {
                                                    foreach ($examTypeInfo as $examm) { ?>
                                                        <div class="tab-pane fade" id="<?php echo $examm->exam_type; ?>" role="tabpanel" aria-labelledby="<?php echo $examm->exam_type; ?>-tab">
                                                            <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="table-success">
                                                            <th class="text-center">SUBJECTS</th>
                                                            <th class="text-center">Max. Marks</th>
                                                            <th class="text-center">Min. Marks</th>
                                                            <th class="text-center">Obt Theory Mark</th>
                                                            <th class="text-center">Obt Lab Mark</th>
                                                        </tr>
                                                    </thead>
                                                    <?php 
                                               
                                                    $result_subject_fail_status = false;
                                                    $result_fail_status = false;
                                                    $max_mark = 0;
                                                    $min_mark_pass = 0;
                                                    $total_mark_obtained = 0;
                                                    $total_max_mark = 0;
                                                    $total_min_mark = 0;
                                                    $total_theory = 0;
                                                    $total_lab = 0;
                                                    $obtained_TheoryMark = "";
                                                    $obtained_LabMark    = "";
                                                    $result_display_theory = "";
                                                    $result_display_lab =  "";
                                                    $subject_code = $subjectCodes;
                                                    for($i=0;$i<count($subject_code);$i++){
                                                        $examMarkInfo = $examModel->getMarksOfStudentBySubCode($studentInfo->student_id,$subject_code[$i],$examm->exam_type);
                                                        if(strtoupper($examMarkInfo->sub_name) != ''){ 
                                                        $result_display = "";
                                                        $result_subject_fail_status = false;

                                                            $max_mark_theory = $examMarkInfo->max_marks;
                                                            $max_mark_lab    = $examMarkInfo->max_marks_lab;
                                                            $min_mark_pass_theory = $examMarkInfo->min_marks;
                                                            $min_mark_pass_lab    = $examMarkInfo->min_marks_lab;
                                                       
                                                        $total_max_mark += $max_mark_theory + $max_mark_lab;
                                                        $total_min_mark += $min_mark_pass_theory + $min_mark_pass_lab;
                                                        $obtained_TheoryMark = $examMarkInfo->obt_theory_mark;
                                                        $obtained_LabMark    = $examMarkInfo->obt_lab_mark;
                                                        // $obatained_mark = (float)$obtainedMark * 4;
                                                        $obatained_mark = $obtained_TheoryMark;
                                                        if($examMarkInfo->lab_status == "YES"){
                                                            if($obtained_TheoryMark == 'AB' || $obtained_TheoryMark == 'EXEM' || $obtained_TheoryMark == 'MP' || $obtained_TheoryMark == 'SAT'){
                                                                $result_subject_fail_status = true;
                                                                $result_display_theory = $obtained_TheoryMark;
                                                                $result_display_lab = $obtained_LabMark;
                                                                $result_fail_status = true;
                                                            }else if($obtained_LabMark == 'AB' || $obtained_LabMark == 'EXEM' || $obtained_LabMark == 'MP' || $obtained_LabMark == 'SAT'){
                                                                    $result_subject_fail_status = true;
                                                                    $result_display_theory = $obtained_TheoryMark;
                                                                    $result_display_lab = $obtained_LabMark;
                                                                    $result_fail_status = true;
                                                            }else if($min_mark_pass_theory > $obtained_TheoryMark || $min_mark_pass_lab > $obtained_LabMark){
                                                                $result_subject_fail_status = true;
                                                                $result_fail_status = true;
                                                                $total_mark_obtained += $obtained_TheoryMark + $obtained_LabMark;
                                                                $total_theory += $obtained_TheoryMark;
                                                                $total_lab += $obtained_LabMark;
                                                                $result_display_theory = $obtained_TheoryMark .'F';
                                                                $result_display_lab = $obtained_LabMark .'F';
                                                            }else{
                                                                $result_subject_fail_status = false;
                                                                $total_mark_obtained += $obtained_TheoryMark + $obtained_LabMark;
                                                                $total_theory += $obtained_TheoryMark;
                                                                $total_lab += $obtained_LabMark;
                                                                $result_display_theory = $obtained_TheoryMark;
                                                                $result_display_lab = $obtained_LabMark;
                                                            }
                                                        }else{
                                                        if($obtained_TheoryMark == 'AB' || $obtained_TheoryMark == 'EXEM' || $obtained_TheoryMark == 'MP' || $obtained_TheoryMark == 'SAT'){
                                                            $result_subject_fail_status = true;
                                                            $result_display_theory = $obtained_TheoryMark;
                                                            $result_fail_status = true;
                                                        }else if($min_mark_pass_theory > $obtained_TheoryMark){
                                                            $result_subject_fail_status = true;
                                                            $result_fail_status = true;
                                                            $total_mark_obtained += $obtained_TheoryMark;
                                                            $total_theory += $obtained_TheoryMark;                                                        
                                                            $result_display_theory = $obtained_TheoryMark .'F';
                                                        }else{
                                                            $result_subject_fail_status = false;
                                                            $total_mark_obtained += $obtained_TheoryMark;
                                                            $total_theory += $obtained_TheoryMark;
                                                            $result_display_theory = $obtained_TheoryMark;
                                                        }
                                                        }
                                                    ?>
                                                <tr>
                                                    <th>
                                                        <?php echo strtoupper($examMarkInfo->sub_name); ?></th>
                                                    <th class="text-center table_marks_data"><?php echo $max_mark_theory + $max_mark_lab; ?>
                                                    </th>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $min_mark_pass_theory + $min_mark_pass_lab; ?></th>
                                                    <?php if($result_subject_fail_status == true){ ?>
                                                    <th style="background: #f76a7ebf"
                                                        class="text-center table_marks_data">
                                                        <?php echo $result_display_theory; ?></th>
                                                        <th style="background: #f76a7ebf"
                                                        class="text-center table_marks_data">
                                                        <?php echo $result_display_lab; ?></th>
                                                    <?php }else{ ?>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $result_display_theory; ?></th>
                                                        <th class="text-center table_marks_data">
                                                        <?php echo $result_display_lab; ?></th>
                                                    <?php } ?>
                                                </tr>
                                                <?php  } }
                                                       if($total_mark_obtained != 0){
                                                        $total_percentage = ($total_mark_obtained/$total_max_mark)*100; 
                                                        $exam_result = calculateResult($total_mark_obtained);
                                                        ?>
                                                    <tr class="text-center table_row_backgrond">
                                                        <th class="total_row">Total</th>
                                                        <th><?php echo $total_max_mark; ?></th>
                                                        <th><?php echo $total_min_mark; ?></th>
                                                        <th><?php echo $total_theory; ?></th>
                                                        <th><?php echo $total_lab; ?></th>
                                                    </tr>
    
                                                    <tr>
                                                        <th colspan="2" class="total_row">Percentage:
                                                            <?php echo round($total_percentage,2).'%'; ?></th>
                                                        <th>Result:
                                                            <?php if($result_fail_status == true){ ?>
                                                            <span class="text_fail"><?php echo 'FAIL'; ?></span>
                                                            <?php } else { ?>
                                                            <span class="text_pass"><?php echo 'PASS'; ?></span>
                                                            <?php } ?></th>
                                                            <th colspan="2" class="total_row">Total Marks: <?php echo $total_mark_obtained; ?></th>
                                                    </tr>
                                                  <?php } ?>
                                                </table>  
                                                    </div>
                                                </div>
                                            <?php }
                                                } ?>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="academic" role="tabpanel" aria-labelledby="academic-tab">
                                            <table class="table table-bordered">
                                                <tr>
                                                <th class="tbl-head" width="160">Application Number</th>
                                                    <th class="tbl-head-content" width="140"><?php echo $studentInfo->application_no; ?></th>
                                                    <th class="tbl-head" width="160">PU Board No.</th>
                                                    <th class="tbl-head-content" width="140"><?php echo $studentInfo->pu_board_number; ?></th>
                                                    <th class="tbl-head" width="160">Student ID</th>
                                                    <th class="tbl-head-content" width="140"><?php echo $studentInfo->student_id; ?></th>
                                                </tr>
                                                <tr>
                                                    <th class="tbl-head">Elective</th>
                                                    <th class="tbl-head-content"><?php echo $studentInfo->elective_sub; ?></th>
                                                    <th class="tbl-head">Term</th>
                                                    <th class="tbl-head-content"><?php echo strtoupper($studentInfo->term_name); ?></th>
                                                    <th class="tbl-head">Stream</th>
                                                    <th class="tbl-head-content"><?php echo strtoupper($studentInfo->stream_name); ?></th>
                                                   
                                                <tr>
                                                <th class="tbl-head">Section</th>
                                                    <th class="tbl-head-content"><?php echo strtoupper($studentInfo->section_name); ?></th>
                                                    <th class="tbl-head">Hall Ticket No.</th>
                                                    <th class="tbl-head-content"><?php echo strtoupper($studentInfo->hall_ticket_no); ?></th>
                                                    <th class="tbl-head">Date of Admmission</th>
                                                    <th class="tbl-head-content"><?php
                                                        $date = $studentInfo->date_of_admission;
                                                        if (!empty($date) && $date != '0000-00-00' && $date != '1970-01-01') {
                                                            echo date('d-m-Y', strtotime($date));
                                                        } else {
                                                            echo '';
                                                        }
                                                    ?></th>
                                                </tr>
                                                <tr>
                                                <th class="tbl-head">SAT Number</th>
                                                    <th class="tbl-head-content"><?php echo $studentInfo->sat_number; ?></th>
                                                    <th class="tbl-head">Date of Join</th>
                                                    <th class="tbl-head-content"><?php  $date = $studentInfo->doj;
                                                        if (!empty($date) && $date != '0000-00-00' && $date != '1970-01-01') {
                                                            echo date('d-m-Y', strtotime($date));
                                                        } else {
                                                            echo '';
                                                        }
                                                    ?></th>
                                                    <th class="tbl-head">Program</th>
                                                    <th class="tbl-head-content"><?php echo $studentInfo->program_name; ?></th>
                                         
                                                </tr>

                                                <tr>
                                                <th class="tbl-head">Batch</th>
                                                    <th class="tbl-head-content"><?php echo $studentInfo->batch; ?></th>
                                                    <th class="tbl-head">Medium</th>
                                                    <th class="tbl-head-content"><?php echo $studentInfo->medium; ?></th>  
                                         
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="tab-pane fade" id="first_class_test" role="tabpanel" aria-labelledby="first_class_test-tab">
                                            <div class=" table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="table-success">
                                                            <th class="text-center">SUBJECTS</th>
                                                            <th class="text-center">Max. Marks</th>
                                                            <th class="text-center">Min. Marks</th>
                                                            <th class="text-center">Marks Scored</th>
                                                        </tr>
                                                    </thead>
                                                    <?php 
                                               
                                                    $result_subject_fail_status = false;
                                                    $result_fail_status = false;
                                                    $max_mark = 0;
                                                    $min_mark_pass = 0;
                                                    $total_mark_obtained = 0;
                                                    $total_max_mark = 0;
                                                    $total_min_mark = 0;
                                                 
                                                    for($i=0;$i<count($subject_code);$i++){
                                                        if(strtoupper($firstClassTestMarkInfo[$i]->sub_name) != ''){ 
                                                        $result_display = "";
                                                        $result_subject_fail_status = false;
                                                        if($firstClassTestMarkInfo[$i]->lab_status == 'true'){
                                                            $max_mark = 100;
                                                            $min_mark_pass = 35;
                                                        }else{
                                                            $max_mark = 100;
                                                            $min_mark_pass = 35;
                                                        }
                                                        $total_max_mark += $max_mark;
                                                        $total_min_mark += $min_mark_pass;
                                                        $obtainedMark = $firstClassTestMarkInfo[$i]->obt_theory_mark;
                                                        // $obatained_mark = (float)$obtainedMark * 4;
                                                        $obatained_mark = $obtainedMark;

                                                        if($obtainedMark == 'AB' || $obtainedMark == 'EXEM' || $obtainedMark == 'MP' || $obtainedMark == 'SAT'){
                                                            $result_subject_fail_status = true;
                                                            $result_display = $obtainedMark;
                                                            $result_fail_status = true;
                                                        }else if($min_mark_pass > $obatained_mark){
                                                            $result_subject_fail_status = true;
                                                            $result_fail_status = true;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark .'F';
                                                        }else{
                                                            $result_subject_fail_status = false;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark;
                                                        }
                                                    ?>
                                                <tr>
                                                    <th>
                                                        <?php echo strtoupper($firstClassTestMarkInfo[$i]->sub_name); ?></th>
                                                    <th class="text-center table_marks_data"><?php echo $max_mark; ?>
                                                    </th>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $min_mark_pass; ?></th>
                                                    <?php if($result_subject_fail_status == true){ ?>
                                                    <th style="background: #f76a7ebf"
                                                        class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php }else{ ?>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php } ?>
                                                </tr>
                                                <?php  } }
                                                       if($total_mark_obtained != 0){
                                                        $total_percentage = ($total_mark_obtained/$total_max_mark)*100; 
                                                        $exam_result = calculateResult($total_mark_obtained);
                                                        ?>
                                                    <tr class="text-center table_row_backgrond">
                                                        <th class="total_row">Total</th>
                                                        <th><?php echo $total_max_mark; ?></th>
                                                        <th><?php echo $total_min_mark; ?></th>
                                                        <th><?php echo $total_mark_obtained; ?></th>
                                                    </tr>
    
                                                    <tr>
                                                        <th colspan="2" class="total_row">Percentage:
                                                            <?php echo round($total_percentage,2).'%'; ?></th>
                                                        <th colspan="2">Result:
                                                            <?php if($result_fail_status == true){ ?>
                                                            <span class="text_fail"><?php echo 'FAIL'; ?></span>
                                                            <?php } else { ?>
                                                            <span class="text_pass"><?php echo $exam_result; ?></span>
                                                            <?php } ?></th>
                                                    </tr>
                                                  <?php } ?>
                                                </table>  
                                            </div>
                                        </div>




                                <?php if (!empty($examTypeInfo)) {
                                        foreach ($examTypeInfo as $examm) { ?>
                                        <div class="tab-pane fade" id="<?php echo $examm->exam_type; ?>" role="tabpanel" aria-labelledby="first_unit_test-tab">
                                            <div class=" table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="table-success">
                                                            <th class="text-center">SUBJECTS</th>
                                                            <th class="text-center">Max. Marks</th>
                                                            <th class="text-center">Min. Marks</th>
                                                            <th class="text-center">Obt Theory Mark</th>
                                                            <th class="text-center">Obt Lab Mark</th>
                                                        </tr>
                                                    </thead>
                                                    <?php 
                                               
                                                    $result_subject_fail_status = false;
                                                    $result_fail_status = false;
                                                    $max_mark = 0;
                                                    $min_mark_pass = 0;
                                                    $total_mark_obtained = 0;
                                                    $total_max_mark = 0;
                                                    $total_min_mark = 0;
                                                    $total_theory = 0;
                                                    $total_lab = 0;
                                                    $obtained_TheoryMark = "";
                                                    $obtained_LabMark    = "";
                                                    $result_display_theory = "";
                                                    $result_display_lab =  "";
                                                 
                                                    for($i=0;$i<count($subject_code);$i++){
                                                        $examMarkInfo = $examModel->getMarksOfStudentBySubCode($studentInfo->student_id,$subject_code[$i],$examm->exam_type);
                                                        if(strtoupper($examMarkInfo->sub_name) != ''){ 
                                                        $result_display = "";
                                                        $result_subject_fail_status = false;

                                                            $max_mark_theory = $examMarkInfo->max_marks;
                                                            $max_mark_lab    = $examMarkInfo->max_marks_lab;
                                                            $min_mark_pass_theory = $examMarkInfo->min_marks;
                                                            $min_mark_pass_lab    = $examMarkInfo->min_marks_lab;
                                                       
                                                        $total_max_mark += $max_mark_theory + $max_mark_lab;
                                                        $total_min_mark += $min_mark_pass_theory + $min_mark_pass_lab;
                                                        $obtained_TheoryMark = $examMarkInfo->obt_theory_mark;
                                                        $obtained_LabMark    = $examMarkInfo->obt_lab_mark;
                                                        // $obatained_mark = (float)$obtainedMark * 4;
                                                        $obatained_mark = $obtained_TheoryMark;
                                                        if($examMarkInfo->lab_status == "YES"){
                                                            if($obtained_TheoryMark == 'AB' || $obtained_TheoryMark == 'EXEM' || $obtained_TheoryMark == 'MP' || $obtained_TheoryMark == 'SAT'){
                                                                $result_subject_fail_status = true;
                                                                $result_display_theory = $obtained_TheoryMark;
                                                                $result_display_lab = $obtained_LabMark;
                                                                $result_fail_status = true;
                                                            }else if($obtained_LabMark == 'AB' || $obtained_LabMark == 'EXEM' || $obtained_LabMark == 'MP' || $obtained_LabMark == 'SAT'){
                                                                    $result_subject_fail_status = true;
                                                                    $result_display_theory = $obtained_TheoryMark;
                                                                    $result_display_lab = $obtained_LabMark;
                                                                    $result_fail_status = true;
                                                            }else if($min_mark_pass_theory > $obtained_TheoryMark || $min_mark_pass_lab > $obtained_LabMark){
                                                                $result_subject_fail_status = true;
                                                                $result_fail_status = true;
                                                                $total_mark_obtained += $obtained_TheoryMark + $obtained_LabMark;
                                                                $total_theory += $obtained_TheoryMark;
                                                                $total_lab += $obtained_LabMark;
                                                                $result_display_theory = $obtained_TheoryMark .'F';
                                                                $result_display_lab = $obtained_LabMark .'F';
                                                            }else{
                                                                $result_subject_fail_status = false;
                                                                $total_mark_obtained += $obtained_TheoryMark + $obtained_LabMark;
                                                                $total_theory += $obtained_TheoryMark;
                                                                $total_lab += $obtained_LabMark;
                                                                $result_display_theory = $obtained_TheoryMark;
                                                                $result_display_lab = $obtained_LabMark;
                                                            }
                                                        }else{
                                                        if($obtained_TheoryMark == 'AB' || $obtained_TheoryMark == 'EXEM' || $obtained_TheoryMark == 'MP' || $obtained_TheoryMark == 'SAT'){
                                                            $result_subject_fail_status = true;
                                                            $result_display_theory = $obtained_TheoryMark;
                                                            $result_fail_status = true;
                                                        }else if($min_mark_pass_theory > $obtained_TheoryMark){
                                                            $result_subject_fail_status = true;
                                                            $result_fail_status = true;
                                                            $total_mark_obtained += $obtained_TheoryMark;
                                                            $total_theory += $obtained_TheoryMark;                                                        
                                                            $result_display_theory = $obtained_TheoryMark .'F';
                                                        }else{
                                                            $result_subject_fail_status = false;
                                                            $total_mark_obtained += $obtained_TheoryMark;
                                                            $total_theory += $obtained_TheoryMark;
                                                            $result_display_theory = $obtained_TheoryMark;
                                                        }
                                                        }
                                                    ?>
                                                <tr>
                                                    <th>
                                                        <?php echo strtoupper($examMarkInfo->sub_name); ?></th>
                                                    <th class="text-center table_marks_data"><?php echo $max_mark_theory + $max_mark_lab; ?>
                                                    </th>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $min_mark_pass_theory + $min_mark_pass_lab; ?></th>
                                                    <?php if($result_subject_fail_status == true){ ?>
                                                    <th style="background: #f76a7ebf"
                                                        class="text-center table_marks_data">
                                                        <?php echo $result_display_theory; ?></th>
                                                        <th style="background: #f76a7ebf"
                                                        class="text-center table_marks_data">
                                                        <?php echo $result_display_lab; ?></th>
                                                    <?php }else{ ?>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $result_display_theory; ?></th>
                                                        <th class="text-center table_marks_data">
                                                        <?php echo $result_display_lab; ?></th>
                                                    <?php } ?>
                                                </tr>
                                                <?php  } }
                                                       if($total_mark_obtained != 0){
                                                        $total_percentage = ($total_mark_obtained/$total_max_mark)*100; 
                                                        $exam_result = calculateResult($total_mark_obtained);
                                                        ?>
                                                    <tr class="text-center table_row_backgrond">
                                                        <th class="total_row">Total</th>
                                                        <th><?php echo $total_max_mark; ?></th>
                                                        <th><?php echo $total_min_mark; ?></th>
                                                        <th><?php echo $total_theory; ?></th>
                                                        <th><?php echo $total_lab; ?></th>
                                                    </tr>
    
                                                    <tr>
                                                        <th colspan="2" class="total_row">Percentage:
                                                            <?php echo round($total_percentage,2).'%'; ?></th>
                                                        <th>Result:
                                                            <?php if($result_fail_status == true){ ?>
                                                            <span class="text_fail"><?php echo 'FAIL'; ?></span>
                                                            <?php } else { ?>
                                                            <span class="text_pass"><?php echo 'PASS'; ?></span>
                                                            <?php } ?></th>
                                                            <th colspan="2" class="total_row">Total Marks: <?php echo $total_mark_obtained; ?></th>
                                                    </tr>
                                                  <?php } ?>
                                                </table>  
                                            </div>
                                        </div>
                                      <?php }} ?>

<div class="tab-pane fade" id="observation" role="tabpanel"
                                        aria-labelledby="observation-tab">
                                        <button class="btn btn-primary float-right mobile-btn border_right_radius mr-1"
                                                data-toggle="modal" data-target="#addNewDocsModel"><i
                                                    class="fa fa-plus"></i>
                                                Add Observation</button>

                                            <div class="table-responsive pt-1">
                                                <table class="table table-bordered table_edit_student ">
                                                    <tr>
                                                        <th class="tbl-head" width="100">Date</th>
                                                        <!-- <th class="tbl-head" width="100">Semester</th> -->
                                                        <th class="tbl-head" width="100">Type</th>
                                                        <?php if($role == ROLE_TEACHING_STAFF || $this->staff_id == '123456' || $role == ROLE_SUPER_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR){ ?>
                                                        <th class="tbl-head" width="300">Description</th>
                                                        <?php }else{ ?>
                                                        <th class="tbl-head" width="100">Description</th>
                                                        <?php } ?>
                                                       <?php if($role == ROLE_TEACHING_STAFF || $this->staff_id == '123456' || $role == ROLE_SUPER_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR){ ?>
                                                        <th class="tbl-head" width="100">Added By</th>
                                                        <!-- <th class="tbl-head" width="100">Visible To</th> -->
                                                         <th class="tbl-head" width="100">Parent Visible</th>
                                                        <?php } ?>
                                                        <th class="tbl-head" width="100">Action</th>
                                                    </tr>
                                                    <?php foreach($remarksInfo as $records){ ?>
                                                    <tr>
                                                        <td style="color:black">
                                                            <b><?php echo date('d-m-Y', strtotime($records->date)); ?></b>
                                                        </td>
                                                        <!-- <td style="color:black">
                                                            <b><?php echo $records->semester; ?></b></td> -->
                                                        <td style="color:black">
                                                            <b><?php echo $records->remark_name; ?></b>
                                                        </td>
                                                        <td style="color:black">
                                                            <b><?php echo $records->description; ?></b>
                                                        </td>
                                                       <?php if($role == ROLE_TEACHING_STAFF || $this->staff_id == '123456' || $role == ROLE_SUPER_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR){ ?>
                                                        <td style="color:black">
                                                            <b><?php echo $records->name; ?></b>
                                                        </td>
                                                        <!-- <?php if(!empty($records->parent_visibility)){ ?>
                                                        <td style="color:black">
                                                            <b><?php echo $records->visibility_access; ?></b>
                                                        </td>
                                                        <?php }else{ ?>
                                                        <td style="color:black">
                                                            <b><?php echo $records->visibility_access; ?></b>
                                                        </td>
                                                        <?php } ?> -->
                                                        <?php if(!empty($records->parent_visibility) && $records->parent_visibility == 'YES'){ ?>
                                                        <td style="color:black">
                                                            <b>Yes</b>
                                                        </td>
                                                        <?php }else{ ?>
                                                        <td style="color:black">
                                                            <b>No</b>
                                                        </td>
                                                        <?php } ?>
                                                        <?php } ?>

                                                        <td><?php if (!empty($records->file_path)) { ?>
                                                            <a href="<?php echo base_url(); ?><?php echo $records->file_path; ?>"
                                                                download target="_blank" class="btn btn_download p-2"><i
                                                                    class="fa fa-download"></i></a>
                                                            <a href="<?php echo base_url(); ?><?php echo $records->file_path; ?>"
                                                                target="_blank" class="btn btn-primary p-2"><i
                                                                    class="fa fa-eye"></i> View</a>

                                                            <?php } ?>
                                                            <!-- <?php if ($role == ROLE_TEACHING_STAFF) { 
                                                                  if($this->staff_id == $records->created_by){ ?>
                                                                    <a class="btn  btn-sm btn-info" href="#"
                                                                    onclick="openRemarkModel('<?php echo $records->type_id ?>','<?php echo date('d-m-Y',strtotime($records->date)) ?>','<?php echo $records->remark_name ?>','<?php echo $records->description ?>','<?php echo  base_url().$records->file_path ?>','<?php echo $records->student_row_id ?>','<?php echo $records->row_id ?>','<?php echo $records->parent_visibility ?>','<?php echo $records->visibility_access ?>')"
                                                                    title="Edit"><i class="fas fa-edit"></i></i></a>
                                                                  <a class="btn btn-xs btn-danger deleteStudentRemarks" href="#" data-row_id="<?php echo $records->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                                                <?php }}else if ($this->department_id == '5'){ 
                                                                    if($this->staff_id == $records->created_by || $records->role == 4){ ?>
                                                                    <a class="btn  btn-sm btn-info" href="#"
                                                                    onclick="openRemarkModel('<?php echo $records->type_id ?>','<?php echo date('d-m-Y',strtotime($records->date)) ?>','<?php echo $records->remark_name ?>','<?php echo $records->description ?>','<?php echo  base_url().$records->file_path ?>','<?php echo $records->student_row_id ?>','<?php echo $records->row_id ?>','<?php echo $records->parent_visibility ?>','<?php echo $records->visibility_access ?>')"
                                                                    title="Edit"><i class="fas fa-edit"></i></i></a>
                                                                <?php }}else if($this->staff_id == "123456" || $role == ROLE_SUPER_ADMIN){ ?>
                                                                    <a class="btn  btn-sm btn-info" href="#"
                                                                    onclick="openRemarkModel('<?php echo $records->type_id ?>','<?php echo date('d-m-Y',strtotime($records->date)) ?>','<?php echo $records->remark_name ?>','<?php echo $records->description ?>','<?php echo  base_url().$records->file_path ?>','<?php echo $records->student_row_id ?>','<?php echo $records->row_id ?>','<?php echo $records->parent_visibility ?>','<?php echo $records->visibility_access ?>')"
                                                                    title="Edit"><i class="fas fa-edit"></i></i></a>
                                                                <?php } ?>
                                                                <?php if ($this->department_id == '5') { 
                                                                     if($this->staff_id == $records->created_by || $records->role == 4){ ?>
                                                                  <a class="btn btn-xs btn-danger deleteStudentRemarks" href="#" data-row_id="<?php echo $records->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                                                <?php }}else if($this->staff_id == "123456" || $role == ROLE_SUPER_ADMIN){ ?>
                                                                  <a class="btn btn-xs btn-danger deleteStudentRemarks" href="#" data-row_id="<?php echo $records->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                                                  <?php } ?> -->
                                                                  <?php if($role == ROLE_SUPER_ADMIN || $this->staff_id == "123456" || $this->staff_id == $records->created_by) { ?>
                                                                <a class="btn btn-sm btn-info" href="#"
                                                                   onclick="openRemarkModel('<?php echo $records->type_id ?>','<?php echo date('d-m-Y',strtotime($records->date)) ?>','<?php echo $records->remark_name ?>','<?php echo $records->description ?>','<?php echo  base_url().$records->file_path ?>','<?php echo $records->student_row_id ?>','<?php echo $records->row_id ?>','<?php echo $records->parent_visibility ?>','<?php echo $records->visibility_access ?>')"
                                                                   title="Edit"><i class="fas fa-edit"></i></a>
                                                                <a class="btn btn-xs btn-danger deleteStudentRemarks" href="#" data-row_id="<?php echo $records->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>

                                                </table>
                                            </div>
                                    </div>




                                        <div class="tab-pane fade" id="first_unit_test" role="tabpanel" aria-labelledby="first_unit_test-tab">
                                            <div class=" table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="table-success">
                                                            <th class="text-center">SUBJECTS</th>
                                                            <th class="text-center">Max. Marks</th>
                                                            <th class="text-center">Min. Marks</th>
                                                            <th class="text-center">Marks Scored</th>
                                                        </tr>
                                                    </thead>
                                                    <?php 
                                               
                                                    $result_subject_fail_status = false;
                                                    $result_fail_status = false;
                                                    $max_mark = 0;
                                                    $min_mark_pass = 0;
                                                    $total_mark_obtained = 0;
                                                    $total_max_mark = 0;
                                                    $total_min_mark = 0;
                                                 
                                                    for($i=0;$i<count($subject_code);$i++){
                                                        if(strtoupper($firstUnitTestMarkInfo[$i]->sub_name) != ''){ 
                                                        $result_display = "";
                                                        $result_subject_fail_status = false;
                                                        if($firstUnitTestMarkInfo[$i]->lab_status == 'true'){
                                                            $max_mark = 100;
                                                            $min_mark_pass = 35;
                                                        }else{
                                                            $max_mark = 100;
                                                            $min_mark_pass = 35;
                                                        }
                                                        $total_max_mark += $max_mark;
                                                        $total_min_mark += $min_mark_pass;
                                                        $obtainedMark = $firstUnitTestMarkInfo[$i]->obt_theory_mark;
                                                        // $obatained_mark = (float)$obtainedMark * 4;
                                                        $obatained_mark = $obtainedMark;

                                                        if($obtainedMark == 'AB' || $obtainedMark == 'EXEM' || $obtainedMark == 'MP' || $obtainedMark == 'SAT'){
                                                            $result_subject_fail_status = true;
                                                            $result_display = $obtainedMark;
                                                            $result_fail_status = true;
                                                        }else if($min_mark_pass > $obatained_mark){
                                                            $result_subject_fail_status = true;
                                                            $result_fail_status = true;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark .'F';
                                                        }else{
                                                            $result_subject_fail_status = false;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark;
                                                        }
                                                    ?>
                                                <tr>
                                                    <th>
                                                        <?php echo strtoupper($firstUnitTestMarkInfo[$i]->sub_name); ?></th>
                                                    <th class="text-center table_marks_data"><?php echo $max_mark; ?>
                                                    </th>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $min_mark_pass; ?></th>
                                                    <?php if($result_subject_fail_status == true){ ?>
                                                    <th style="background: #f76a7ebf"
                                                        class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php }else{ ?>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php } ?>
                                                </tr>
                                                <?php  } }
                                                       if($total_mark_obtained != 0){
                                                        $total_percentage = ($total_mark_obtained/$total_max_mark)*100; 
                                                        $exam_result = calculateResult($total_mark_obtained);
                                                        ?>
                                                    <tr class="text-center table_row_backgrond">
                                                        <th class="total_row">Total</th>
                                                        <th><?php echo $total_max_mark; ?></th>
                                                        <th><?php echo $total_min_mark; ?></th>
                                                        <th><?php echo $total_mark_obtained; ?></th>
                                                    </tr>
    
                                                    <tr>
                                                        <th colspan="2" class="total_row">Percentage:
                                                            <?php echo round($total_percentage,2).'%'; ?></th>
                                                        <th colspan="2">Result:
                                                            <?php if($result_fail_status == true){ ?>
                                                            <span class="text_fail"><?php echo 'FAIL'; ?></span>
                                                            <?php } else { ?>
                                                            <span class="text_pass"><?php echo $exam_result; ?></span>
                                                            <?php } ?></th>
                                                    </tr>
                                                  <?php } ?>
                                                </table>  
                                            </div>
                                        </div>

                                        <div class="tab-pane fade p-1" id="paidInfo" role="tabpanel" aria-labelledby="paidInfo-tab">
                                            <div class="row">
                                                <div class="col-12 table-responsive">
                                                    <table class="table table-bordered table_edit_student">
                                                        <tr class="text-center table-primary">
                                                            <th>Date</th>
                                                            <th>Application No.</th>
                                                            <th>Term</th>
                                                            <!-- <th>Stream</th> -->
                                                            <th>Receipt No.</th>
                                                            <th>Amount</th>
                                                            <th>Payment Type</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    <?php if(!empty($stdFeePaymentInfo)){
                                                        foreach($stdFeePaymentInfo as $fee){ ?>
                                                        <tr>
                                                            <th class="text-center"><?php echo date('d-m-Y',strtotime($fee->payment_date)); ?></th>
                                                            <th class="text-center"><?php echo $fee->application_no; ?></th>
                                                            <th class="text-center"><?php echo $fee->term_name; ?></th>
                                                            <!-- <th class="text-center"><?php //echo $fee->stream_name; ?></th> -->
                                                            <th class="text-center"><?php echo $fee->receipt_number; ?></th>
                                                            <!-- <th class="text-center"><?php //echo $fee->order_id; ?></th> -->
                                                            <th class="text-center"><?php echo number_format($fee->paid_amount,2); ?></th>
                                                            <?php 
                                                                $feeConcession = $bill_model->getFeeConcessionByAppNoForView($fee->application_no,$fee_year);
                                                            ?>
                                                            <th class="text-center"><?php echo $fee->payment_type; ?></th>
                                                            <th class="text-center">
                                                                <a href="<?php echo base_url(); ?>feePaymentReceiptPrint/<?php echo $fee->row_id; ?>"
                                                                    target="_blank">Receipt</a>
                                                            </th>
                                                        </tr>
                                                        <?php } }else{ ?>
                                                            <tr>
                                                                <th class="text-center" colspan="12">No record found</th>
                                                            </tr>
                                                        <?php } ?>
                                                        <?php if(!empty($deptPaidInfo)){
                                                        foreach($deptPaidInfo as $fee){ ?>
                                                        <tr>
                                                            <th class="text-center"><?php echo date('d-m-Y',strtotime($fee->payment_date)); ?></th>
                                                            <th class="text-center"><?php echo $fee->application_no; ?></th>
                                                            <th class="text-center"><?php echo $fee->term_name; ?></th>
                                                            <!-- <th class="text-center"><?php //echo $fee->stream_name; ?></th> -->
                                                            <th class="text-center"><?php echo $fee->receipt_number; ?></th>
                                                            <!-- <th class="text-center"><?php //echo $fee->order_id; ?></th> -->
                                                            <th class="text-center"><?php echo number_format($fee->paid_amount,2); ?></th>
                                                            <th class="text-center"><?php echo $fee->payment_type; ?></th>
                                                            <th class="text-center">
                                                                <a href="<?php echo base_url(); ?>govtfeePaymentReceiptPrint/<?php echo $fee->row_id; ?>"
                                                                    target="_blank">Receipt</a>
                                                            </th>
                                                        </tr>
                                                        <?php } }?>
                                                    </table>
                                                </div>
                                            </div>
                                            <?php if(!empty($stdFeePaymentInfo)){ $paid_amt =0 ; ?>
                                                <div class="card-body" style="padding:5px;">
                                                    <div class="row">
                                                        <div style="font-size: 18px;" class="col-12 col-lg-3">
                                                            <b>Total Fee: Rs. <?php echo number_format($total_fee,2); ?></b>
                                                        </div>
                                                        <?php $concession=0; foreach($stdFeePaymentInfo as $fee){ 
                                                            $paid_amt += $fee->paid_amount;
                                                        } ?>
                                                        <?php  
                                                        $feeConcession = $bill_model->getFeeConcessionByAppNoForView($fee->application_no,CURRENT_YEAR);
                                                        ?>
                                                        <div style="font-size: 18px;" class="col-12 col-lg-3">
                                                            <b>Concession: Rs. <?php $concession += $feeConcession->amount; if($concession>0){ echo $concession; } else { echo 0; } ?></b>
                                                        </div>
                                                        <div style="font-size: 18px;" class="col-12 col-lg-3">
                                                            <b>Paid Fee Amt.: Rs. <?php echo number_format($paid_amount,2); ?></b>
                                                        </div>
                                                        <div style="font-size: 18px;" class="col-12 col-lg-3">
                                                            <b>Pending Fee Amt.: Rs. <?php if(($total_fee - $paid_amount)>0){ echo number_format($total_fee - $paid_amount - $concession,2); }else{ echo 0; } ?></b>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php }  ?>
                                        </div>


                                      
<!-- II UNIT TEST -->
                                      <div class="tab-pane fade" id="second_unit_test" role="tabpanel" aria-labelledby="second_unit_test-tab">
                                         <div class=" table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="table-success">
                                                            <th class="text-center">SUBJECTS</th>
                                                            <th class="text-center">Max. Marks</th>
                                                            <th class="text-center">Min. Marks</th>
                                                            <th class="text-center">Marks Scored</th>
                                                        </tr>
                                                    </thead>
                                                    <?php 
                                               
                                                    $result_subject_fail_status = false;
                                                    $result_fail_status = false;
                                                    $max_mark = 0;
                                                    $min_mark_pass = 0;
                                                    $total_mark_obtained = 0;
                                                    $total_max_mark = 0;
                                                    $total_min_mark = 0;
                                                 
                                                    for($i=0;$i<count($subject_code);$i++){
                                                        if(strtoupper($secondUnitTestMarkInfo[$i]->name) != ''){ 
                                                        $result_display = "";
                                                        $result_subject_fail_status = false;
                                                        if($secondUnitTestMarkInfo[$i]->lab_status == 'true'){
                                                            $max_mark = 35;
                                                            $min_mark_pass = 12;
                                                        }else{
                                                            $max_mark = 50;
                                                            $min_mark_pass = 18;
                                                        }
                                                        $total_max_mark += $max_mark;
                                                        $total_min_mark += $min_mark_pass;
                                                        $obtainedMark = $secondUnitTestMarkInfo[$i]->obt_theory_mark;
                                                        // if($studentInfo->term_name == 'II PUC'){
                                                        //     $obatained_mark = (float)$obtainedMark * 2;
                                                        // }else{
                                                            $obatained_mark = $obtainedMark;
                                                        // }
                                                        if($obtainedMark == 'AB' || $obtainedMark == 'EXEM' || $obtainedMark == 'MP' || $obtainedMark == 'SAT'){
                                                            $result_subject_fail_status = true;
                                                            $result_display = $obtainedMark;
                                                            $result_fail_status = true;
                                                        }else if($min_mark_pass > $obatained_mark){
                                                            $result_subject_fail_status = true;
                                                            $result_fail_status = true;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark .'F';
                                                        }else{
                                                            $result_subject_fail_status = false;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark;
                                                        }
                                                    ?>
                                                <tr>
                                                    <th>
                                                        <?php echo strtoupper($secondUnitTestMarkInfo[$i]->name); ?></th>
                                                    <th class="text-center table_marks_data"><?php echo $max_mark; ?>
                                                    </th>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $min_mark_pass; ?></th>
                                                    <?php if($result_subject_fail_status == true){ ?>
                                                    <th style="background: #f76a7ebf"
                                                        class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php }else{ ?>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php } ?>
                                                </tr>
                                                <?php  } }
                                                       if($total_mark_obtained != 0){
                                                        $total_percentage = ($total_mark_obtained/$total_max_mark)*100; 
                                                        $exam_result = calculateResult($total_mark_obtained);
                                                        ?>
                                                    <tr class="text-center table_row_backgrond">
                                                        <th class="total_row">Total</th>
                                                        <th><?php echo $total_max_mark; ?></th>
                                                        <th><?php echo $total_min_mark; ?></th>
                                                        <th><?php echo $total_mark_obtained; ?></th>
                                                    </tr>
    
                                                    <tr>
                                                        <th colspan="2" class="total_row">Percentage:
                                                            <?php echo round($total_percentage,2).'%'; ?></th>
                                                        <th colspan="2">Result:
                                                            <?php if($result_fail_status == true){ ?>
                                                            <span class="text_fail"><?php echo 'FAIL'; ?></span>
                                                            <?php } else { ?>
                                                            <span class="text_pass"><?php echo 'PASS'; ?></span>
                                                            <?php } ?></th>
                                                    </tr>
                                                  <?php } ?>
                                                </table>  
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="first_term" role="tabpanel" aria-labelledby="first_term-tab">
                                            <div class=" table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="table-success">
                                                            <th class="text-center">SUBJECTS</th>
                                                            <th class="text-center">Max. Marks</th>
                                                            <th class="text-center">Min. Marks</th>
                                                            <th class="text-center">Marks Scored</th>
                                                        </tr>
                                                    </thead>
                                                    <?php 
                                               
                                                    $result_subject_fail_status = false;
                                                    $result_fail_status = false;
                                                    $max_mark = 0;
                                                    $min_mark_pass = 0;
                                                    $total_mark_obtained = 0;
                                                    $total_max_mark = 0;
                                                    $total_min_mark = 0;
                                                 
                                                    for($i=0;$i<count($subject_code);$i++){
                                                        if(strtoupper($firstTermMarkInfo[$i]->sub_name) != ''){ 
                                                        $result_display = "";
                                                        $result_subject_fail_status = false;
                                                        if($firstTermMarkInfo[$i]->lab_status == 'true'){
                                                            $max_mark = 100;
                                                            $min_mark_pass = 35;
                                                        }else{
                                                            $max_mark = 100;
                                                            $min_mark_pass = 35;
                                                        }
                                                        $total_max_mark += $max_mark;
                                                        $total_min_mark += $min_mark_pass;
                                                        $obtainedMark = $firstTermMarkInfo[$i]->obt_theory_mark;
                                                        if($studentInfo->term_name == 'II PUC'){
                                                            $obatained_mark = (float)$obtainedMark * 2;
                                                        }else{
                                                            $obatained_mark = $obtainedMark;
                                                        }
                                                        if($obtainedMark == 'AB' || $obtainedMark == 'EXEM' || $obtainedMark == 'MP' || $obtainedMark == 'SAT'){
                                                            $result_subject_fail_status = true;
                                                            $result_display = $obtainedMark;
                                                            $result_fail_status = true;
                                                        }else if($min_mark_pass > $obatained_mark){
                                                            $result_subject_fail_status = true;
                                                            $result_fail_status = true;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark .'F';
                                                        }else{
                                                            $result_subject_fail_status = false;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark;
                                                        }
                                                    ?>
                                                <tr>
                                                    <th>
                                                        <?php echo strtoupper($firstTermMarkInfo[$i]->sub_name); ?></th>
                                                    <th class="text-center table_marks_data"><?php echo $max_mark; ?>
                                                    </th>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $min_mark_pass; ?></th>
                                                    <?php if($result_subject_fail_status == true){ ?>
                                                    <th style="background: #f76a7ebf"
                                                        class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php }else{ ?>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php } ?>
                                                </tr>
                                                <?php  } }
                                                       if($total_mark_obtained != 0){
                                                        $total_percentage = ($total_mark_obtained/$total_max_mark)*100; 
                                                        $exam_result = calculateResult($total_mark_obtained);
                                                        ?>
                                                    <tr class="text-center table_row_backgrond">
                                                        <th class="total_row">Total</th>
                                                        <th><?php echo $total_max_mark; ?></th>
                                                        <th><?php echo $total_min_mark; ?></th>
                                                        <th><?php echo $total_mark_obtained; ?></th>
                                                    </tr>
    
                                                    <tr>
                                                        <th colspan="2" class="total_row">Percentage:
                                                            <?php echo round($total_percentage,2).'%'; ?></th>
                                                        <th colspan="2">Result:
                                                            <?php if($result_fail_status == true){ ?>
                                                            <span class="text_fail"><?php echo 'FAIL'; ?></span>
                                                            <?php } else { ?>
                                                            <span class="text_pass"><?php echo $exam_result; ?></span>
                                                            <?php } ?></th>
                                                    </tr>
                                                  <?php } ?>
                                                </table>  
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="mid_term" role="tabpanel" aria-labelledby="mid_term-tab">
                                            <div class=" table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="table-success">
                                                            <th class="text-center">SUBJECTS</th>
                                                            <th class="text-center">Max. Marks</th>
                                                            <th class="text-center">Min. Marks</th>
                                                            <th class="text-center">Lab Min. Marks</th>
                                                            <th class="text-center">THEORY MARKS</th>
                                                            <th class="text-center">LAB MARKS</th>
                                                            <th class="text-center">Marks Scored</th>
                                                        </tr>
                                                    </thead>
                                                    <?php 
                                                        $obtainedLabMark = 0; 

                                                    $result_subject_fail_status = false;
                                                    $result_fail_status = false;
                                                    $max_mark = 0;
                                                    $lab_mark = 0;
                                                    $min_mark_pass = 0;
                                                    $total_mark_obtained = 0;
                                                    $total_max_mark = 0;
                                                    $total_min_mark = 0;
                                                    $total_mark_display = 0;

                                                 
                                                    for($i=0;$i<count($subject_code);$i++){
                                                        if(strtoupper($midTermMarkInfo[$i]->name) != ''){ 
                                                        $result_display = "";
                                                        $result_subject_fail_status = false;
                                                        if($midTermMarkInfo[$i]->lab_status == 'true'){
                                                            $max_mark = 100;
                                                            $min_mark_pass = 21;
                                                            // $total_pass_mark = 35;

                                                            $lab_Pass_mark = 14;
                                                        }else{
                                                            $max_mark = 80;
                                                            $min_mark_pass = 24;
                                                            // $total_pass_mark = 24;

                                                            // $lab_mark = 0;
                                                        }
                                                        $total_max_mark += $max_mark;
                                                        $total_min_mark += $min_mark_pass;
                                                        $obtainedMark = $midTermMarkInfo[$i]->obt_theory_mark;
                                                        // if($studentInfo->term_name == 'II PUC'){
                                                        //     $obatained_mark = (float)$obtainedMark * 2;
                                                        // }else{
                                                            // $obatained_mark = $obtainedMark;
                                                        // }
                                                        // if($obtainedMark == 'AB' || $obtainedMark == 'EXEM' || $obtainedMark == 'MP' || $obtainedMark == 'SAT'){
                                                        //     $result_subject_fail_status = true;
                                                        //     $result_display = $obtainedMark;
                                                        //     $result_fail_status = true;
                                                        // }else if($min_mark_pass > $obatained_mark){
                                                        //     $result_subject_fail_status = true;
                                                        //     $result_fail_status = true;
                                                        //     $total_mark_obtained += $obatained_mark;
                                                        //     $result_display = $obatained_mark .'F';
                                                        // }else{
                                                        //     $result_subject_fail_status = false;
                                                        //     $total_mark_obtained += $obatained_mark;
                                                        //     $result_display = $obatained_mark;
                                                        // }
                                                        if($obtainedMark == 'AB' || $obtainedMark == 'EXEM' || $obtainedMark == 'MP' || $obtainedMark == 'SA' || $obtainedMark == 'ASGN'){
                                                            $result_subject_fail_status = true;
                                                            $result_display = $obtainedMark;
                                                            $result_fail_status = true;
                                                            // $total_mark_display = $obtainedMark;
                                                            if($subject == 12 || $midTermMarkInfo[$i]->lab_status == "true"){
                                                                $obtainedLabMark = $midTermMarkInfo[$i]->obt_lab_mark;
                                                                }else{
                                                                    $obtainedLabMark = '-'; 
                                                                }
                                                                $total_obt_mark = $obtainedMark + $obtainedLabMark;
                                                                $total_mark_obtained += $total_obt_mark;
                                                                $total_mark_display = $total_obt_mark.'F';
                                                        } else if($subject == 12 || $midTermMarkInfo[$i]->lab_status == "true"){
                                                            $obtainedLabMark = $midTermMarkInfo[$i]->obt_lab_mark;
                                                            $total_obt_mark = $obtainedMark + $obtainedLabMark;
                                                              if($min_mark_pass > $obtainedMark || $lab_Pass_mark > $obtainedLabMark){
                                                                $result_subject_fail_status = true;
                                                                $result_fail_status = true;
                                                                $total_mark_obtained += $total_obt_mark;
                                                                $result_display = $obtainedMark.'F';
                                                                $total_mark_display = $total_obt_mark.'F';
                                                              }
                                                            //   else if($total_pass_mark > $total_obt_mark){
                                                            //     $result_subject_fail_status = true;
                                                            //     $result_fail_status = true;
                                                            //     $total_mark_obtained += $total_obt_mark;
                                                            //     $result_display = $obtainedMark;
                                                            //     $total_mark_display = $total_obt_mark.'F';
                                                            //   }
                                                              else{
                                                                $result_subject_fail_status = false;
                                                                // $result_fail_status = false;
                                                                $total_mark_obtained += $total_obt_mark;
                                                                $result_display = $obtainedMark; 
                                                                $obtainedLabMark = $midTermMarkInfo[$i]->obt_lab_mark;
                                                                $total_mark_display = $total_obt_mark;
                                                              }
                                                         } else if($min_mark_pass > $obtainedMark){
                                                            $result_subject_fail_status = true;
                                                            $result_fail_status = true;
                                                            $total_mark_obtained += $obtainedMark;
                                                            $result_display = $obtainedMark.'F';
                                                            $obtainedLabMark = '-';
                                                            $total_mark_display = $obtainedMark.'F';
                                                        }else{
                                                            $result_subject_fail_status = false;
                                                            // $result_fail_status = false;
                                                            $total_mark_obtained += $obtainedMark;
                                                            $result_display = $obtainedMark;
                                                            $obtainedLabMark = '-';
                                                            $total_mark_display = $obtainedMark;
                                                        }
                                                    ?>
                                                <tr>
                                                    <th>
                                                        <?php echo strtoupper($midTermMarkInfo[$i]->name); ?></th>
                                                    <th class="text-center table_marks_data"><?php echo $max_mark; ?>
                                                    </th>
                                                    <th class="text-center table_marks_data">
                                                            <?php echo $min_mark_pass; ?></th>
                                                        
                                                     <?php if($midTermMarkInfo[$i]->lab_status == 'true'){?>
                                                            <th class="text-center table_marks_data">
                                                            <?php echo $lab_Pass_mark; ?></th>
                                                      <?php }else{ ?>
                                                         <th class="text-center table_marks_data">
                                                         <?php echo '-'; ?></th>
                                                 <?php     }  ?>
                                                        <th 
                                                            class="text-center table_marks_data">
                                                            <?php echo $result_display; ?></th>
                                                      
                                                        <th class="text-center table_marks_data"><?php echo $obtainedLabMark; ?></th> 
                                                        <?php if($result_subject_fail_status == true){ ?>
                                                        
                                                        <th style="background: #f76a7ebf" class="text-center table_marks_data"><?php echo $total_mark_display; ?></th>
                                                        <?php }else{ ?>
                                                        <th  class="text-center table_marks_data"><?php echo $total_mark_display; ?></th>
                                                        <?php } ?>
                                                </tr>
                                                <?php  } }
                                                       if($total_mark_obtained != 0){
                                                        $total_percentage = ($total_mark_obtained/$total_max_mark)*100; 
                                                        $exam_result = calculateResult($total_mark_obtained);
                                                        ?>
                                                    <tr class="text-center table_row_backgrond">
                                                        <th class="total_row">Total</th>
                                                        <th><?php echo $total_max_mark; ?></th>
                                                        <th><?php echo $total_min_mark; ?></th>
                                                        <th></th>
                                                        <th></th>
                                                            <th></th>
                                                        <th><?php echo $total_mark_obtained; ?></th>
                                                    </tr>
    
                                                    <tr>
                                                        <th colspan="4" class="total_row">Percentage:
                                                            <?php echo round($total_percentage,2).'%'; ?></th>
                                                        <th colspan="3">Result:
                                                            <?php if($result_fail_status == true){ ?>
                                                            <span class="text_fail"><?php echo 'FAIL'; ?></span>
                                                            <?php } else { ?>
                                                            <span class="text_pass"><?php echo 'PASS'; ?></span>
                                                            <?php } ?></th>
                                                    </tr>
                                                  <?php } ?>
                                                </table>  
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="preparatory" role="tabpanel" aria-labelledby="preparatory-tab">
                                            <div class=" table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="table-success">
                                                            <th class="text-center">SUBJECTS</th>
                                                            <th class="text-center">Max. Marks</th>
                                                            <th class="text-center">Min. Marks</th>
                                                            <th class="text-center">Marks Scored</th>
                                                        </tr>
                                                    </thead>
                                                    <?php 
                                               
                                                    $result_subject_fail_status = false;
                                                    $result_fail_status = false;
                                                    $max_mark = 0;
                                                    $min_mark_pass = 0;
                                                    $total_mark_obtained = 0;
                                                    $total_max_mark = 0;
                                                    $total_min_mark = 0;
                                                 
                                                    for($i=0;$i<count($subject_code);$i++){
                                                        if(strtoupper($firstPreparatoryMarkInfo[$i]->name) != ''){ 
                                                        $result_display = "";
                                                        $result_subject_fail_status = false;
                                                        if($firstPreparatoryMarkInfo[$i]->lab_status == 'true'){
                                                            $max_mark = 70;
                                                            $min_mark_pass = 24;
                                                        }else{
                                                            $max_mark = 100;
                                                            $min_mark_pass = 35;
                                                        }
                                                        $total_max_mark += $max_mark;
                                                        $total_min_mark += $min_mark_pass;
                                                        $obtainedMark = $firstPreparatoryMarkInfo[$i]->obt_theory_mark;
                                                        // if($studentInfo->term_name == 'II PUC'){
                                                        //     $obatained_mark = (float)$obtainedMark * 2;
                                                        // }else{
                                                            $obatained_mark = $obtainedMark;
                                                        // }
                                                        if($obtainedMark == 'AB' || $obtainedMark == 'EXEM' || $obtainedMark == 'MP' || $obtainedMark == 'SAT'){
                                                            $result_subject_fail_status = true;
                                                            $result_display = $obtainedMark;
                                                            $result_fail_status = true;
                                                        }else if($min_mark_pass > $obatained_mark){
                                                            $result_subject_fail_status = true;
                                                            $result_fail_status = true;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark .'F';
                                                        }else{
                                                            $result_subject_fail_status = false;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark;
                                                        }
                                                    ?>
                                                <tr>
                                                    <th>
                                                        <?php echo strtoupper($firstPreparatoryMarkInfo[$i]->name); ?></th>
                                                    <th class="text-center table_marks_data"><?php echo $max_mark; ?>
                                                    </th>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $min_mark_pass; ?></th>
                                                    <?php if($result_subject_fail_status == true){ ?>
                                                    <th style="background: #f76a7ebf"
                                                        class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php }else{ ?>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php } ?>
                                                </tr>
                                                <?php  } }
                                                       if($total_mark_obtained != 0){
                                                        $total_percentage = ($total_mark_obtained/$total_max_mark)*100; 
                                                        $exam_result = calculateResult($total_mark_obtained);
                                                        ?>
                                                    <tr class="text-center table_row_backgrond">
                                                        <th class="total_row">Total</th>
                                                        <th><?php echo $total_max_mark; ?></th>
                                                        <th><?php echo $total_min_mark; ?></th>
                                                        <th><?php echo $total_mark_obtained; ?></th>
                                                    </tr>
    
                                                    <tr>
                                                        <th colspan="2" class="total_row">Percentage:
                                                            <?php echo round($total_percentage,2).'%'; ?></th>
                                                        <th colspan="2">Result:
                                                            <?php if($result_fail_status == true){ ?>
                                                            <span class="text_fail"><?php echo 'FAIL'; ?></span>
                                                            <?php } else { ?>
                                                            <span class="text_pass"><?php echo 'PASS'; ?></span>
                                                            <?php } ?></th>
                                                    </tr>
                                                  <?php } ?>
                                                </table>  
                                            </div>
                                        </div>

                                        <div class="tab-pane fade p-1" id="notification" role="tabpanel" aria-labelledby="notification-tab">
                                            
                                            <div class="row p-0 column_padding_card">
                                                <div class="col column_padding_card">
                                                    <div class="card card-small mb-4">
                                                        <style>
                                                            .load_more_less:hover{
                                                                color : #33cc33 !important;
                                                            }
                                                            .card-flex-container{
                                                                display: flex;
                                                                justify-content: flex-end;
                                                            }
                                                            form{
                                                                display: flex;               
                                                            }
                                                        </style>
                                                        <div class="card-header card-flex-container p-1">                    
                                                            <form action="<?php echo base_url(); ?>viewStudentInfoById/<?php echo $studentInfo->row_id; ?>" method="POST"
                                                                id="byFilterMethod">
                                                                
                                                                <input class="form-control datepicker" type="text" name="date_from" 
                                                                value="<?php  if(!empty($date_from)) echo date('d-m-Y', strtotime($date_from)); ?>"
                                                                style="text-transform: uppercase" placeholder="Date From" autocomplete="off">
                                                                    &emsp;
                                                                <input class="form-control datepicker" type="text" name="date_to" 
                                                                value="<?php  if(!empty($date_to)) echo date('d-m-Y', strtotime($date_to)); ?>"
                                                                style="text-transform: uppercase" placeholder="Date To" autocomplete="off">

                                                                <button type="submit" class="btn btn-success ml-1">Search</button>
                                                            </form>
                                                        </div>
                                                        <style>
                                                            .flex-containers{
                                                            }
                                                            .flex-containers{
                                                                
                                                            }
                                                            .main-flex-container{  
                                                                display: flex;
                                                                flex-direction: column;
                                                                background: #d7e0e2;
                                                                padding: 5px 10px;
                                                                border-radius: 5px;
                                                                font-weight: bold;
                                                                margin-bottom: 3px;
                                                            }
                                                            .head-container{
                                                                display: flex;
                                                                width: 100%;
                                                            }
                                                            .head-container > .title{
                                                                color: #2011ef;
                                                                margin-left: 10px;
                                                            }
                                                            .body-container{
                                                                margin: 5px 0px;
                                                            }
                                                            .body-container > .body{
                                                                color: #383535;
                                                                margin-left: 23px;
                                                            }
                                                            .footer-container{
                                                                display: flex;
                                                                justify-content: space-between;
                                                            }
                                                            .action-buttons{
                                                                align-self: flex-end;
                                                            }
                                                        </style>
                                                        <div class="card-body p-2">
                                                            <div class="flex-containers">
                                                                <?php 
                                                                    if(!empty($notifications)){
                                                                        $segmentID = 0;
                                                                        foreach($notifications as $count=>$notification){
                                                                            if(fmod($count,7) == 0){ 
                                                                                $segmentID++;
                                                                            }?>
                                                                                <div class="main-flex-container notificationSegment_<?=$segmentID;?>">
                                                                                
                                                                                    <div class="head-container">
                                                                                        <span>
                                                                                            <i class="fas fa-bell"></i>
                                                                                        </span>
                                                                                        <span class="title"><?=$notification->student_name;?></span>                   
                                                                                    </div>
                                                                                    <div class="body-container">
                                                                                        <span class="body"><?=$notification->message;?></span>
                                                                                    </div>
                                                                                    <div class="footer-container">
                                                                                        <span class="date">Sent By - <?php 
                                                                                            if(!empty($notification->sent_by)) echo $notification->sent_by;
                                                                                        ?></span>
                                                                                    </div>
                                                                                    <div class="footer-container">
                                                                                        <span class="date"><?php 
                                                                                            if(!empty($notification->active_date)) echo date('d-m-Y h:i:s A', strtotime($notification->active_date));
                                                                                        ?></span>
                                                                                        <?php 
                                                                                            if(!empty($notification->filepath)){?>
                                                                                                <span class="attachment">
                                                                                                    <a class="badge badge-success" target="_blank" href="<?= base_url().$notification->filepath ?>" onclick="">View Attachment</a>
                                                                                                </span>
                                                                                            <?php }
                                                                                        ?>
                                                                                    </div>
                                                                                    <div class="action-buttons mt-1">
                                                                                    <?php 
                                                                                            if(!empty($notification->filepath_two)){?>
                                                                                                <span class="attachment">
                                                                                                    <a class="badge badge-success" target="_blank" href="<?= base_url().$notification->filepath_two ?>" onclick="">View Attachment 2</a>
                                                                                                </span>
                                                                                            <?php } ?>
                                                                                    </div>
                                                                                </div>
                                                                        <?php }
                                                                    }else{ ?>
                                                                            <p class="text-center m-0" style="font-weight: bold;">No Notifications Found..!</p>
                                                                    <?php }
                                                                    ?>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer p-1">          
                                                            <span onclick="loadMoreNotification();" style="user-select:none;font-size:17px;font-weight:bold;cursor:pointer;color:#007bff" class="float-left pt-2 pb-2 pl-2 load_more_less">load more<i class="fas fa-arrow-circle-down pl-1"></i></span>
                                                            <span onclick="showLessNotification();" style="user-select:none;font-size:17px;font-weight:bold;cursor:pointer;color:#007bff" class="float-right pt-2 pb-2 pr-2 load_more_less">show less<i class="fas fa-arrow-circle-up pl-1"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade p-1" id="classActiveInfo" role="tabpanel"
                                        aria-labelledby="classInfo-tab">
                                        <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table class="table table-bordered">
                                                    <tr class="text-center table-primary" >
                                                        <th>Year</th>
                                                        <th>Class</th>
                                                        <th width="200">Stream</th>
                                                        <th width="200">Section</th>
                                                        <th width="200">Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    <?php $i = 0;
                                                    if(!empty($classYearInfo)){
                                                        foreach($classYearInfo as $cls){ ?>
                                                    <tr>
                                                        <th class="text-center"><?php echo $cls->intake_year; ?></th>
                                                        <th class="text-center"><?php echo $cls->class; ?></th>
                                                        <th class="text-center"><?php echo $cls->stream; ?></th>
                                                        <th class="text-center"><?php echo $cls->section; ?></th>
                                                        <th class="text-center">
                                                        <?php if($cls->discontinued_status == '1'){
                                                                echo '<span style="color:red">DISCONTINUED</span>';
                                                              }else {
                                                                echo '<span style="color:green">ACTIVE</span>';
                                                              } ?>
                                                        </th>
                                                        <th class="text-center">
                                                        <?php   if($cls->discontinued_status == '1'){ ?>
                                                            <a class="btn btn-xs btn-danger continueStudent" href="#" data-row_id="<?php echo $cls->row_id; ?>" data-intake_year="<?php echo $cls->intake_year; ?>" data-stud_row_id = "<?php echo $studentInfo->row_id ?>" title="Activate"><i class="fas fa-toggle-off"></i></a>
                                                        <?php }else{ ?>
                                                            <a class="btn btn-xs btn-success discontinueStudent" href="#" data-row_id="<?php echo $cls->row_id; ?>" data-intake_year="<?php echo $cls->intake_year; ?>" data-stud_row_id = "<?php echo $studentInfo->row_id ?>" title="Discontinue"><i class="fas fa-toggle-on"></i></a>
                                                        <?php } ?>
                                                        </th>
                                                    </tr>
                                                    <?php }} ?>
                                                </table>
                                            </div>
                                       </div>
                                    </div>

                                        <div class="tab-pane fade" id="annual" role="tabpanel" aria-labelledby="annual-tab">
                                            <div class=" table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="table-success">
                                                            <th class="text-center">SUBJECTS</th>
                                                            <th class="text-center">Max. Marks</th>
                                                            <th class="text-center">Min. Marks</th>
                                                            <th class="text-center">Marks Scored</th>
                                                        </tr>
                                                    </thead>
                                                    <?php 
                                               
                                                    $result_subject_fail_status = false;
                                                    $result_fail_status = false;
                                                    $max_mark = 0;
                                                    $min_mark_pass = 0;
                                                    $total_mark_obtained = 0;
                                                    $total_max_mark = 0;
                                                    $total_min_mark = 0;
                                                 
                                                    for($i=0;$i<count($subject_code);$i++){
                                                        if(strtoupper($annualMarkInfo[$i]->name) != ''){ 
                                                        $result_display = "";
                                                        $result_subject_fail_status = false;
                                                        if($annualMarkInfo[$i]->lab_status == 'true'){
                                                            $max_mark = 100;
                                                            $min_mark_pass = 35;
                                                        }else{
                                                            $max_mark = 100;
                                                            $min_mark_pass = 35;
                                                        }
                                                        $total_max_mark += $max_mark;
                                                        $total_min_mark += $min_mark_pass;
                                                        $obtainedMarkTheory = $annualMarkInfo[$i]->obt_theory_mark;
                                                        $obtainedMarkLab = $annualMarkInfo[$i]->obt_lab_mark;
                                                        $obtainedMark = $obtainedMarkTheory + $obtainedMarkLab;
                                                        // if($studentInfo->term_name == 'II PUC'){
                                                        //     $obatained_mark = (float)$obtainedMark * 2;
                                                        // }else{
                                                            $obatained_mark = $obtainedMark;
                                                        // }
                                                        if($obtainedMark == 'AB' || $obtainedMark == 'EXEM' || $obtainedMark == 'MP' || $obtainedMark == 'SAT'){
                                                            $result_subject_fail_status = true;
                                                            $result_display = $obtainedMark;
                                                            $result_fail_status = true;
                                                        }else if($min_mark_pass > $obatained_mark){
                                                            $result_subject_fail_status = true;
                                                            $result_fail_status = true;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark .'F';
                                                        }else{
                                                            $result_subject_fail_status = false;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark;
                                                        }
                                                    ?>
                                                <tr>
                                                    <th>
                                                        <?php echo strtoupper($annualMarkInfo[$i]->name); ?></th>
                                                    <th class="text-center table_marks_data"><?php echo $max_mark; ?>
                                                    </th>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $min_mark_pass; ?></th>
                                                    <?php if($result_subject_fail_status == true){ ?>
                                                    <th style="background: #f76a7ebf"
                                                        class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php }else{ ?>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php } ?>
                                                </tr>
                                                <?php  } }
                                                       if($total_mark_obtained != 0){
                                                        $total_percentage = ($total_mark_obtained/$total_max_mark)*100; 
                                                        $exam_result = calculateResult($total_mark_obtained);
                                                        ?>
                                                    <tr class="text-center table_row_backgrond">
                                                        <th class="total_row">Total</th>
                                                        <th><?php echo $total_max_mark; ?></th>
                                                        <th><?php echo $total_min_mark; ?></th>
                                                        <th><?php echo $total_mark_obtained; ?></th>
                                                    </tr>
    
                                                    <tr>
                                                        <th colspan="2" class="total_row">Percentage:
                                                            <?php echo round($total_percentage,2).'%'; ?></th>
                                                        <th colspan="2">Result:
                                                            <?php if($result_fail_status == true){ ?>
                                                            <span class="text_fail"><?php echo 'FAIL'; ?></span>
                                                            <?php } else { ?>
                                                            <span class="text_pass"><?php echo 'PASS'; ?></span>
                                                            <?php } ?></th>
                                                    </tr>
                                                  <?php } ?>
                                                </table>  
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="firstPreparartory" role="tabpanel" aria-labelledby="firstPreparartory-tab">
                                            <div class=" table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="table-success">
                                                            <th class="text-center">SUBJECTS</th>
                                                            <th class="text-center">Max. Marks</th>
                                                            <th class="text-center">Min. Marks</th>
                                                            <th class="text-center">Marks Scored</th>
                                                        </tr>
                                                    </thead>
                                                    <?php 
                                               
                                                    $result_subject_fail_status = false;
                                                    $result_fail_status = false;
                                                    $max_mark = 0;
                                                    $min_mark_pass = 0;
                                                    $total_mark_obtained = 0;
                                                    $total_max_mark = 0;
                                                    $total_min_mark = 0;
                                                 
                                                    for($i=0;$i<count($subject_code);$i++){
                                                        if(strtoupper($firstPreparatoryMarkInfo[$i]->sub_name) != ''){ 
                                                        $result_display = "";
                                                        $result_subject_fail_status = false;
                                                        if($firstPreparatoryMarkInfo[$i]->lab_status == 'true'){
                                                            $max_mark = 100;
                                                            $min_mark_pass = 35;
                                                        }else{
                                                            $max_mark = 100;
                                                            $min_mark_pass = 35;
                                                        }
                                                        $total_max_mark += $max_mark;
                                                        $total_min_mark += $min_mark_pass;
                                                        $obtainedMark = $firstPreparatoryMarkInfo[$i]->obt_theory_mark;
                                                        // if($studentInfo->term_name == 'II PUC'){
                                                        //     $obatained_mark = (float)$obtainedMark * 2;
                                                        // }else{
                                                            $obatained_mark = $obtainedMark;
                                                        // }
                                                        if($obtainedMark == 'AB' || $obtainedMark == 'EXEM' || $obtainedMark == 'MP' || $obtainedMark == 'SAT'){
                                                            $result_subject_fail_status = true;
                                                            $result_display = $obtainedMark;
                                                            $result_fail_status = true;
                                                        }else if($min_mark_pass > $obatained_mark){
                                                            $result_subject_fail_status = true;
                                                            $result_fail_status = true;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark .'F';
                                                        }else{
                                                            $result_subject_fail_status = false;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark;
                                                        }
                                                    ?>
                                                <tr>
                                                    <th>
                                                        <?php echo strtoupper($firstPreparatoryMarkInfo[$i]->sub_name); ?></th>
                                                    <th class="text-center table_marks_data"><?php echo $max_mark; ?>
                                                    </th>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $min_mark_pass; ?></th>
                                                    <?php if($result_subject_fail_status == true){ ?>
                                                    <th style="background: #f76a7ebf"
                                                        class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php }else{ ?>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php } ?>
                                                </tr>
                                                <?php  } }
                                                       if($total_mark_obtained != 0){
                                                        $total_percentage = ($total_mark_obtained/$total_max_mark)*100; 
                                                        $exam_result = calculateResult($total_mark_obtained);
                                                        ?>
                                                    <tr class="text-center table_row_backgrond">
                                                        <th class="total_row">Total</th>
                                                        <th><?php echo $total_max_mark; ?></th>
                                                        <th><?php echo $total_min_mark; ?></th>
                                                        <th><?php echo $total_mark_obtained; ?></th>
                                                    </tr>
    
                                                    <tr>
                                                        <th colspan="2" class="total_row">Percentage:
                                                            <?php echo round($total_percentage,2).'%'; ?></th>
                                                        <th colspan="2">Result:
                                                            <?php if($result_fail_status == true){ ?>
                                                            <span class="text_fail"><?php echo 'FAIL'; ?></span>
                                                            <?php } else { ?>
                                                            <span class="text_pass"><?php echo $exam_result; ?></span>
                                                            <?php } ?></th>
                                                    </tr>
                                                  <?php } ?>
                                                </table>  
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="attendance_info" role="tabpanel" aria-labelledby="attendance_info-tab">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table_info">
                                                    <thead>
                                                        <tr class="table_row_backgrond">
                                                            <th class="text-center">SUBJECTS</th>
                                                            <th class="text-center">Classes Held</th>
                                                            <th class="text-center">Classes Present</th>
                                                            <th class="text-center">Percentage</th>
                                                        </tr>
                                                    </thead>
                                                    <?php for($i=0;$i<count($subject_code);$i++){  ?>
                                                        <tr>
                                                            <th><?php echo $subject_attendance[$subject_code[$i]]['sub_name']->sub_name; ?></th>
                                                            <th class="text-center"><?php echo $subject_attendance[$subject_code[$i]]['class_held']; ?></th>
                                                            <th class="text-center"><?php echo $subject_attendance[$subject_code[$i]]['class_attended']; ?></th>
                                                            <?php if(round($subject_attendance[$subject_code[$i]]['percentage'],2) < 85.00){ ?>
                                                                <th width="300" style="background:#f76a7ebf" class="text-center"><?php echo round($subject_attendance[$subject_code[$i]]['percentage'],2);?></th>
                                                            <?php }else{ ?>
                                                                <th width="300" class="text-center"><?php echo round($subject_attendance[$subject_code[$i]]['percentage'],2);?></th>
                                                            <?php  } ?>
                                                        </tr>
                                                    <?php }  ?>

                                                    <tr>
                                                        <th colspan="4" class="total_row">Total Percentage: 
                                                        <?php if(round($total_attendance_percentage,2) < 85.00){ ?>
                                                            <span colspan="3" class="total_row text_fail"><?php echo round($total_attendance_percentage,2).'%'; ?></span>
                                                        <?php }else{ ?>
                                                            <span colspan="3" class="total_row"><?php echo round($total_attendance_percentage,2).'%'; ?></span>
                                                        <?php  } ?>
                                                        </th>
                                                    </tr>
                                                </table>  
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Default Light Table -->
        
        <?php } ?>
    </div>
</div>
<div class="modal" id="addNewDocsModel">
    <div class="modal-dialog custom-modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Observation Details</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2 m-1">
                <form action="<?php echo base_url() ?>addRemarksInfo" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="row_id" value="<?php echo $studentInfo->row_id ?>">

                    <div class="row">
                        <div class="col-12">
                            <label>Date</label>
                            <div class="form-group">
                                <input type="date" value="<?php echo date('Y-m-d') ?>" 
                                       name="date" class="form-control remarks_date input-sm"
                                       placeholder="Date" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Observation Type</label>
                                <select class="form-control input-sm selectpicker" id="remarks_type_id"
                                        name="remarks_type_id" data-live-search="true" required>
                                    <option value="">Select Observation</option>
                                    <?php if (!empty($remarkNameInfo)) {
                                        foreach ($remarkNameInfo as $obsinfo) { ?>
                                            <option value="<?php echo $obsinfo->row_id; ?>">
                                                <?php echo $obsinfo->remark_name; ?>
                                            </option>
                                    <?php }} ?>
                                </select>
                            </div>
                        </div>

                        <?php if($role == ROLE_TEACHING_STAFF || $this->staff_id == '123456' || $role == ROLE_SUPER_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR){ ?>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Parent Visibility</label>
                                <select class="form-control input-sm selectpicker" id="parent_visibility"
                                        name="parent_visibility" data-live-search="true" required>
                                    <option value="">Select</option>
                                    <option value="YES">YES</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                        <?php } ?>

                        <!-- <?php if($this->department_id == 5 || $this->staff_id == '123456' || $role == ROLE_SUPER_ADMIN){ ?>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Visibility Access</label>
                                <select class="form-control input-sm selectpicker" id="visibility_access"
                                        name="visibility_access[]" multiple data-live-search="true" required>
                                    <option value="PARENTS">PARENTS</option>
                                    <option value="TEACHERS">TEACHERS</option>
                                    <option value="MANAGEMENT">MANAGEMENT</option>
                                </select>
                            </div>
                        </div>
                        <?php } ?> -->

                        <div class="col-12">
                            <div class="form-group">
                                <label>Upload File</label><br>
                                <img src="<?php echo base_url(); ?>assets/dist/img/file_upload.png"
                                     class="avatar rounded img-thumbnail mb-2" width="130" height="130"
                                     id="uploadedImage4" alt="File Preview">
                                <input type="file" class="form-control-file" id="aFile" name="userfile"
                                       accept=".jpg,.jpeg,.png,.pdf">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" id="description" class="form-control"
                                          placeholder="Enter Description" autocomplete="off" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer pt-2 pb-0">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">SAVE</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<div id="remarkssModel" class="modal fade" role="dialog">
    <div class="modal-dialog custom-modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Edit Observation Details</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body m-0">
                <?php $this->load->helper("form"); ?>
                <form id="editRemarkForm" action="<?php echo base_url() ?>updateRemarkInfo" 
                      method="post" enctype="multipart/form-data" role="form">
                    
                    <!-- Hidden Inputs -->
                    <input type="hidden" name="remark_id" id="remark_id" value="" />
                    <input type="hidden" name="row_id" id="student_row_id" value="" />

                    <div class="row">
                        <!-- Date -->
                        <div class="col-12">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" name="date" id="editDate"
                                    class="form-control datepicker_edit input-sm remarks_date"
                                    placeholder="Date" autocomplete="off" required>
                            </div>
                        </div>

                        <!-- Remarks Type -->
                        <div class="col-12">
                            <div class="form-group">
                                <label>Observation Type</label>
                                <select class="form-control input-sm" id="edit_remarks_type_id"
                                    name="remarks_type_id" required>
                                    <?php if (!empty($remarkNameInfo)) {
                                        foreach ($remarkNameInfo as $obsinfo) { ?>
                                            <option value="<?php echo $obsinfo->row_id; ?>">
                                                <?php echo $obsinfo->remark_name; ?>
                                            </option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>

                        <!-- Parent Visibility -->
                       <?php if($role == ROLE_TEACHING_STAFF || $this->staff_id == '123456' || $role == ROLE_SUPER_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR){ ?>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Parent Visibility</label>
                                <select class="form-control input-sm" id="edit_parent_visibility"
                                    name="parent_visibility" required>
                                    <option value="YES">YES</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                        <?php } ?>

                        <!-- Visibility Access -->
                        <!-- <?php if ($this->department_id == 5 || $this->staff_id == '123456' || $role == ROLE_SUPER_ADMIN) { ?>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Visibility Access</label>
                                <select class="form-control input-sm selectpicker" id="edit_visibility_access"
                                    name="visibility_access[]" required multiple data-live-search="true" title="Select">
                                    <option value="PARENTS">PARENTS</option>
                                    <option value="TEACHERS">TEACHERS</option>
                                    <option value="MANAGEMENT">MANAGEMENT</option>
                                </select>
                            </div>
                        </div>
                        <?php } ?> -->

                        <!-- Image Upload -->
                        <div class="col-12">
                            <div class="form-group text-center">
                                <img id="uploadedImage2" src="#" alt="File Preview"
                                    class="avatar rounded-circle img-thumbnail mb-2" width="130" height="130">
                                <input type="file" class="form-control-file" id="editFile1" name="userfile"
                                    accept="image/png, image/jpeg, image/jpg">
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" id="editdescription"
                                    class="form-control" placeholder="Enter Description"
                                    autocomplete="off" required></textarea>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function GoBackWithRefresh(event) {
    showLoader();
    if ('referrer' in document) {
        window.location = document.referrer;
        /* OR */
        //location.replace(document.referrer);
    } else {
        window.history.back();
    }
}

function showLessNotification(){
        if(localStorage.getItem("NSEGID") !=null){
        let curSegmentID = parseInt(localStorage.getItem("NSEGID"));
            if(curSegmentID != 1){
                $(".notificationSegment_"+curSegmentID).hide();
                localStorage.setItem("NSEGID",curSegmentID-1);
            }
        }
    }
    function loadMoreNotification(){
        let nextSegmentID = 1;
        if(localStorage.getItem("NSEGID") !=null){
            nextSegmentID = parseInt(localStorage.getItem("NSEGID")) + 1;
        }
        if($(".notificationSegment_"+nextSegmentID).length == 0){
            alert("There is no more notifications to load..");
        }else{
            localStorage.setItem("NSEGID",nextSegmentID);
            $(".notificationSegment_"+nextSegmentID).show();
        }
    }

    
jQuery(document).ready(function() {

    jQuery('.resetFilters').click(function() {
        $(this).closest('form').find("input[type=text]").val("");
    })

                      // Get the ID of the active tab from local storage
                      var activeTabId = localStorage.getItem('vincentpuTabIdStudview');

                    // If the ID is not null or undefined, activate the corresponding tab
                    if (activeTabId) {
                    $('#myTab a[href="#' + activeTabId + '"]').tab('show');
                    }

                    // Store the ID of the clicked tab in local storage
                    $('#myTab a').on('click', function() {
                        var tabId = $(this).attr('href').substring(1);
                        localStorage.setItem('vincentpuTabIdStudview', tabId);
                    });
});
jQuery(document).on("click", ".discontinueStudent", function(){  			
			var row_id = $(this).data("row_id");
			var stud_row_id = $(this).data("stud_row_id");
			var intake_year = $(this).data("intake_year");
        
				hitURL = baseURL + "discontinueStudent",
				currentRow = $(this);
			
			var confirmation = confirm("Are you sure to Discontinue this Student ?");
			
			if(confirmation)
			{
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { row_id : row_id, intake_year: intake_year,stud_row_id: stud_row_id } 
				}).done(function(data){
						
					// currentRow.parents('tr').remove();
					if(data.status = true) { alert("Student Discontinued successfully");
					location.reload();	
				    }
					else if(data.status = false) { alert("Failed"); }
					else { alert("Access denied..!"); }
				});
			}
		});


        jQuery(document).on("click", ".continueStudent", function(){			
			var row_id = $(this).data("row_id");
			var stud_row_id = $(this).data("stud_row_id");
			var intake_year = $(this).data("intake_year");
          

				hitURL = baseURL + "continueStudent",
				currentRow = $(this);
			
			var confirmation = confirm("Are you sure to Active this Student ?");
			
			if(confirmation)
			{
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { row_id : row_id , intake_year: intake_year,stud_row_id: stud_row_id} 
				}).done(function(data){
						
					// currentRow.parents('tr').remove();
					if(data.status = true) { alert("Student Actived successfully");
					location.reload();	
				    }
					else if(data.status = false) { alert("Failed"); }
					else { alert("Access denied..!"); }
				});
			}
		});
</script>

<?php


function calculateResult($total_marks){
    $percentage = floor(($total_marks / 600) * 100);
    if($percentage >= 85){
        return "Distinction";
    } else if($percentage >= 60 && $percentage <= 84){
        return "I Class";
    } else if($percentage >= 50 && $percentage <= 59){
        return "II Class";
    } else if($percentage >= 35 && $percentage <= 49){
        return "III Class";
    }
}
?>
<script>
    function openRemarkModel(row_id, date, remark_name, description, file_path,studentId,remarkId,parent_visibility,visibility_access) {
    // $('#subject_name_u option').remove();
      var values = visibility_access.split(',');
      $('#editDate').val(date);
      $('#edit_remarks_type_id').val(row_id);
      $("#uploadedImage2").attr("src",file_path);
      $('#editdescription').val(description);
      $('#student_row_id').val(studentId);
      $('#remark_id').val(remarkId);
      $('#edit_parent_visibility').val(parent_visibility);
      $('#edit_visibility_access').val(values);
      $('.selectpicker').selectpicker('refresh');

    // $('#time_row_id_u').val(start_time);
    // $('#staff_id_u').val(staff_id);
    // // $('#subject_name_u').val(subject_code);

    // $("#edit_remarks_type_id").append(new Option(remark_name , staff_sub_row_id));
    $('#remarkssModel').modal('show');

}

document.addEventListener("DOMContentLoaded", function () {

    // For the Add form
    const parentVisibility = document.getElementById("parent_visibility");
    const visibilityAccess = document.getElementById("visibility_access");

    // Set up initial state and change handler
    parentVisibility.addEventListener("change", function () {
        updateParentsOption(parentVisibility.value, visibilityAccess);
    });
    
    // For the Edit form
    $('#edit_parent_visibility').on('change', function () {
        updateParentsOption($(this).val(), document.getElementById("edit_visibility_access"));
    });
    
    // Helper function to update the PARENTS option visibility
    function updateParentsOption(visibilityValue, selectElement) {
        if (!selectElement) return;
        
        // Find the PARENTS option
        const parentOption = $(selectElement).find('option[value="PARENTS"]');
        
        if (parentOption.length > 0) {
            if (visibilityValue === "YES") {
                // If parent visibility is YES, hide PARENTS option
                parentOption.hide();
                parentOption.prop('selected', false);
            } else {
                // If parent visibility is NO or empty, show PARENTS option
                parentOption.show();
            }
            
            // Refresh the selectpicker to apply changes
            $('.selectpicker').selectpicker('refresh');
        }
    }
});

// Initialize the correct state when edit modal is shown
$('#remarkssModel').on('shown.bs.modal', function () {
    const parentVisibility = $('#edit_parent_visibility').val();
    const visibilityAccess = document.getElementById("edit_visibility_access");
    
    // Set initial state of PARENTS option based on parent_visibility value
    if (parentVisibility === "YES") {
        $(visibilityAccess).find('option[value="PARENTS"]').hide();
        $('.selectpicker').selectpicker('refresh');
    }
});


jQuery(document).ready(function() {

    jQuery(document).on("click", ".deleteStudentRemarks", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "deleteStudentRemarks",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Observation ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
					
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Observation successfully deleted"); }
				else if(data.status = false) { alert("Observation deletion failed"); }
				else { alert("Access denied..!"); }
                location.reload();
			});
		}


	
	});
});
</script>