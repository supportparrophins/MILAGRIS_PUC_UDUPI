<?php
$this->load->helper('form');
$error = $this->session->flashdata('error');
if ($error) { 
    ?>
<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <i class="fa fa-check mx-2"></i>
    <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
</div>
<?php } ?>
<?php
        $success = $this->session->flashdata('success');
        if ($success) {
        ?>
<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <i class="fa fa-check mx-2"></i>
    <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
</div>
<?php }?>
<div class="row">
    <div class="col-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container container-fluid px-4 pt-2">
    <div class="content-wrapper">
        <div class="row ">
            <div class="col ">
                <div class="card card-small p-0 card_heading_title">
                    <div class="card-body p-1 card-content-title">
                        <div class="row ">
                            <div class="col-md-8 col-8 text-black  " style="font-size:22px;"><i
                                    class="fa fa-users"></i>&nbsp;Edit Student <span class="text-uppercase"><?php echo strtoupper($studentInfo->student_name); ?></span></div>
                            <div class="col-md-4 col-4"> 
                                <a href="#" onclick="GoBackWithRefresh();return false;" class="btn text-white primary_color btn-bck pull-right mobile-bck ">
                                <i class="fa fa-arrow-circle-left"></i> Back </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- form start -->
        <!-- Default Light Table -->
        <div class="row form-contents">
            <div class="col-lg-12 col-12">
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
                                        <li class="nav-item">
                                            <a class="nav-link" id="academic-tab" data-toggle="tab" href="#academic"
                                                role="tab" aria-controls="academic" aria-selected="true">Academic
                                                Info</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content personal-tab" id="myTabContent">
                                        <div class="tab-pane fade show active" id="personal" role="tabpanel"
                                            aria-labelledby="personal-tab">
                                            
                                            <form role="form" id="updateStudent" action="<?php echo base_url() ?>updateStudent" method="post" enctype="multipart/form-data">
                                                <input type="hidden" value="<?php echo $studentInfo->row_id; ?>" id="row_id" name="row_id">
                                                <input type="hidden" value="<?php echo $studentInfo->application_no; ?>" id="application_no" name="application_no">
                                                <input type="hidden" value="<?php echo $studentInfo->admission_no; ?>" id="admission_no" name="admission_no">
                                                <div class="table-responsive-sm table-responsive-md table-responsive-xs">
                                                    <table class="table table-bordered table-striped table_edit_student">
                                                         <tr>
                                                            <td style="background:white" width="100" rowspan="11"
                                                                class="p-0">
                                                                <div class="profile-img">
                                                                    <!-- <?php 
                                                                    $image_path = $studentInfo->photo_url;
                                                                    if(!empty($image_path)){ ?>
                                                                    <img src="<?php echo $image_path; ?>"
                                                                        class="img-thumbnail" alt="Profile Image"
                                                                        id="uploadedImage" name="userfile">
                                                                    <?php } else { ?>
                                                                    <img src="<?php echo base_url(); ?>assets/dist/img/user.png"
                                                                        class="img-thumbnail" id="uploadedImage"
                                                                        name="userfile" alt="Profile default">
                                                                    <?php } ?> -->

                                                                    <!-- <?php
                                                                        $profileImg = $studentInfo->photo_url;
                                                                        if (!empty($profileImg)) { ?>
                                                                            <img src="<?php echo $profileImg; ?>" class="img-thumbnail"
                                                                                alt="Profile Image" id="uploadedImage">
                                                                            <input type="hidden" name="existing_image" value="<?php echo $profileImg; ?>">
                                                                        <?php } else { ?>
                                                                            <img src="<?php echo base_url(); ?>assets/dist/img/user.png" class="img-thumbnail"
                                                                                id="uploadedImage" alt="Profile default">
                                                                            <input type="hidden" name="existing_image" value="">
                                                                    <?php } ?>
                                                                    <div class="file btn btn-sm btn-primary">
                                                                        Change Photo
                                                                        <input type="file" class="form-control-sm"
                                                                            id="vImg" name="userfile">
                                                                    </div> -->
                                                                    <!-- <?php
                                                                        // $student_id = $studentInfo->admission_no; // or application_no, whichever is your student ID
                                                                        // $image_path = '';
                                                                        // $extensions = ['jpg', 'jpeg', 'png'];
                                                                        // foreach ($extensions as $ext) {
                                                                        //     $file = FCPATH . 'upload/student_photo/' . $student_id . '.' . $ext;
                                                                        //     if (file_exists($file)) {
                                                                        //         $image_path = base_url('upload/student_photo/' . $student_id . '.' . $ext) . '?v=' . time();
                                                                        //         break;
                                                                        //     }
                                                                        // }
                                                                    ?> -->
                                                                    <?php
                                                                        $student_id = $studentInfo->admission_no;
                                                                        $image_path = '';
                                                                        $extensions = ['jpg', 'jpeg', 'png'];
                                                                        
                                                                        foreach ($extensions as $ext) {
                                                                            // Match exact: 12344.jpg
                                                                            $exact_file = FCPATH . 'upload/student_photo/' . $student_id . '.' . $ext;
                                                                            // Match old format: 12344 name.jpg (anything after space)
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
                                                                    ?>

                                                                    <div class="profile-img">
                                                                        <?php if (!empty($image_path)) { ?>
                                                                            <img src="<?php echo $image_path; ?>" class="img-thumbnail"
                                                                                alt="Profile Image" id="uploadedImage">
                                                                        <?php } else { ?>
                                                                            <img src="<?php echo base_url(); ?>assets/dist/img/user.png"
                                                                                class="img-thumbnail" id="uploadedImage" alt="Profile default">
                                                                        <?php } ?>

                                                                        <div class="file btn btn-sm btn-primary">
                                                                            Change Photo
                                                                            <input type="file" class="form-control-sm" id="vImg" name="userfile">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="tbl-head mobile_input_width" width="120">Application No.</th>
                                                            <th width="240">
                                                                <div class="form-group form-group-sm mb-0 mobile_input_width">
                                                                    <input value="<?php echo $studentInfo->application_no; ?>" type="text" 
                                                                    class="form-control required" style="text-transform: uppercase;" placeholder=" Application Number" 
                                                                    id="application_no" name="application_no" maxlength="128" autocomplete="off">
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head mobile_input_width" width="140">Full Name</th>
                                                            <th width="240">
                                                                <div class="form-group form-group-sm mb-0 mobile_input_width">
                                                                    <input value="<?php echo strtoupper($studentInfo->student_name); ?>" type="text" 
                                                                    class="form-control required" style="text-transform: uppercase;" placeholder="Student Name" 
                                                                    id="student_name" name="student_name" maxlength="128" autocomplete="off">
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head mobile_input_width" width="140">Date of Birth</th>
                                                            <th width="170">
                                                                <div class="input-group mb-0 mobile_input_width">
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text material-icons date-icon p-2">date_range</span>
                                                                    </div>
                                                                    <input id="dob" type="text" name="dob" class="form-control datepicker emp-dob required "
                                                                        value="<?php if(empty($studentInfo->dob) || $studentInfo->dob == '0000-00-00'){
                                                                                echo "";
                                                                            } else{
                                                                                echo date('d-m-Y',strtotime($studentInfo->dob));
                                                                            } ?>" placeholder="Date of Birth" autocomplete="off" />
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="tbl-head" width="140">Gender</th>
                                                            <th width="180">
                                                                <div class="form-group mb-0 mobile_input_width">
                                                                    <select class="form-control" id="gender" name="gender">
                                                                        <option value="<?php echo $studentInfo->gender; ?>" >
                                                                            Selected: <?php echo $studentInfo->gender; ?>
                                                                        </option>
                                                                        <option value="MALE">MALE</option>
                                                                        <option value="FEMALE">FEMALE</option>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                            
                                                            <th class="tbl-head">Blood Group</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <select class="form-control" id="blood_group" name="blood_group" data-live-search="true">
                                                                        <option value="<?php echo $studentInfo->blood_group; ?>" >
                                                                            Selected: <?php echo $studentInfo->blood_group; ?>
                                                                        </option>
                                                                        <option value="A+"> A+</option>
                                                                        <option value="O+">O+</option>
                                                                        <option value="B+">B+</option>
                                                                        <option value="AB+">AB+</option>
                                                                        <option value="A-">A-</option>
                                                                        <option value="B-">B-</option>
                                                                        <option value="AB-">AB-</option>
                                                                        <option value="O-">O-</option>

                                                                    </select>
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head">Nationality</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <select name="nationality" id="nationality" class="form-control" data-live-search="true">
                                                                        <option value="<?php echo $studentInfo->nationality; ?>"selected>
                                                                            Selected: <?php echo $studentInfo->nationality; ?>
                                                                        </option>
                                                                        <?php if(!empty($nationalityInfo)){ 
                                                                            foreach ($nationalityInfo as $nationality) { ?>
                                                                                <option value="<?php echo $nationality->name ?>">
                                                                                    <?php echo $nationality->name ?>
                                                                                </option>
                                                                            <?php   } 
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="tbl-head">Religion</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <select name="religion" id="religion" class="form-control" data-live-search="true">
                                                                        <option value="<?php echo $studentInfo->religion; ?>"selected>
                                                                            Selected: <?php echo $studentInfo->religion; ?>
                                                                        </option>
                                                                        <?php if(!empty($religionInfo)){ 
                                                                            foreach ($religionInfo as $religion) { ?>
                                                                                <option value="<?php echo $religion->name ?>">
                                                                                    <?php echo $religion->name ?>
                                                                                </option>
                                                                            <?php   } 
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head">Caste</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <input value="<?php echo $studentInfo->caste; ?>" type="text" 
                                                                    class="form-control required" style="text-transform: uppercase;" placeholder="Caste" 
                                                                    id="caste" name="caste" maxlength="128" autocomplete="off">
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head">Category</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <select name="category" id="category" class="form-control" data-live-search="true">
                                                                        <option value="<?php echo $studentInfo->category; ?>"selected>
                                                                            Selected: <?php echo $studentInfo->category; ?>
                                                                        </option>
                                                                        <?php if(!empty($categoryInfo)){ 
                                                                            foreach ($categoryInfo as $category) { ?>
                                                                                <option value="<?php echo $category->category_name ?>">
                                                                                    <?php echo $category->category_name ?>
                                                                                </option>
                                                                            <?php   } 
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="tbl-head">Sub caste</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <input value="<?php echo $studentInfo->sub_caste; ?>" type="text" 
                                                                    class="form-control required" placeholder="Sub Caste" 
                                                                    id="sub_caste" name="sub_caste" autocomplete="off"/>
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head">Mother Tongue</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <div class="form-group mb-0">
                                                                        <input value="<?php echo $studentInfo->mother_tongue; ?>" type="text" 
                                                                        class="form-control required" placeholder="Mother Tongue" 
                                                                        id="mother_tongue" name="mother_tongue" maxlength="280" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head">Mobile</th>
                                                            <th>
                                                            <div class="form-group mb-0">
                                                                    <div class="form-group mb-0">
                                                                        <input value="<?php echo $studentInfo->mobile; ?>" type="text" 
                                                                        class="form-control required" placeholder="Mobile" 
                                                                        id="mobile" name="mobile" maxlength="10" minlength="10" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="tbl-head">Admission Status</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <select class="form-control" id="admission_status" name="admission_status" data-live-search="true">
                                                                        
                                                                                <option value="<?php echo $studentInfo->admission_status; ?>" >
                                                                                    Selected: <?php if($studentInfo->admission_status == '1'){
                                                                                echo "New Admission";}else{
                                                                                    echo "Regular";
                                                                                }; ?>
                                                                                </option>
                                                                        
                                                                        <option value="">Select Admission Status</option>
                                                                        <option value="1">New Admission</option>
                                                                        <option value="0">Regular</option> 
                                                                    </select>
                                                                </div>
                                                            </th>

                                                            <th class="tbl-head">Intake Year</th>
                                                            <th>
                                                                <div class="form-group mb-0 intakeInfo">
                                                                    <select class="form-control" id="intake_year" name="intake_year" data-live-search="true">
                                                                        <?php if(!empty($studentInfo->intake_year)){ ?>
                                                                            <option value="<?php echo $studentInfo->intake_year; ?>" >
                                                                                Selected: <?php echo $studentInfo->intake_year; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                        <?php if(!empty($intakeYearInfo)) {
                                                                            foreach($intakeYearInfo as $year){ ?>
                                                                                <option value="<?php echo $year->display_year; ?>">
                                                                                    <?php echo $year->display_year; ?>
                                                                                </option>
                                                                        <?php } } ?>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head">Register No</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <input value="<?php echo $studentInfo->register_no; ?>" type="text" 
                                                                    class="form-control required" style="text-transform: uppercase;" placeholder="Register No." 
                                                                    id="register_no" name="register_no" maxlength="128" autocomplete="off">
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="tbl-head">Aadhar No</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <input value="<?php echo $studentInfo->aadhar_no; ?>" type="text" 
                                                                    class="form-control required" style="text-transform: uppercase;" placeholder="Aadhar No" 
                                                                    id="aadhar_no" name="aadhar_no" maxlength="12" minlength="12" autocomplete="off">
                                                                </div>
                                                            </th>

                                                             <?php $RouteName = $transport->getStudentPickUpInfo($studentInfo->route_id);?>
                                                            <th class="tbl-head" >I PUC Route</th>
                                                            <th width="240">
                                                                <div class="form-group mb-0 input_mobile_width">
                                                                    <select class="form-control " id="route" name="route" autocomplete="off">
                                                                        <?php if (!empty($studentInfo->route_id)) { ?>
                                                                            <option value="<?php echo $studentInfo->route_id; ?>">
                                                                                Selected: <?php echo $RouteName->pickup_point_name; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                        <option value="">Select Transport Route</option>
                                                                        <?php foreach($routeInfo as $route){ ?>
                                                                            <option value="<?php echo $route->row_id; ?>"><?php echo $route->pickup_point; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head">Place Of Birth</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <input value="<?php echo $studentInfo->place_of_birth; ?>" type="text" 
                                                                    class="form-control required" style="text-transform: uppercase;" placeholder="Place Of Birth" 
                                                                    id="native_place" name="native_place" autocomplete="off" onkeypress="return alphaOnly(event)">
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="tbl-head">District</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <input value="<?php echo $studentInfo->district; ?>" type="text" 
                                                                    class="form-control required" style="text-transform: uppercase;" placeholder="District" 
                                                                    id="district" name="district" autocomplete="off" onkeypress="return alphaOnly(event)">
                                                                </div>
                                                            </th>

                                                            <th class="tbl-head">Taluk</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <input value="<?php echo $studentInfo->taluk; ?>" type="text" 
                                                                    class="form-control required" style="text-transform: uppercase;" placeholder="Taluk" 
                                                                    id="taluk" name="taluk" autocomplete="off" onkeypress="return alphaOnly(event)">
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head">State</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <input value="<?php echo $studentInfo->state; ?>" type="text" 
                                                                    class="form-control required" style="text-transform: uppercase;" placeholder="State" 
                                                                    id="state" name="state" maxlength="128" autocomplete="off" onkeypress="return alphaOnly(event)">
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="tbl-head">Pincode</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <input value="<?php echo $studentInfo->pincode; ?>" type="text" 
                                                                    class="form-control required" style="text-transform: uppercase;" placeholder="Pincode" 
                                                                    id="pincode" name="pincode" autocomplete="off">
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head">Admission no.</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <input value="<?php echo $studentInfo->admission_no; ?>" type="text" 
                                                                    class="form-control required" style="text-transform: uppercase;" placeholder="Admission no." 
                                                                    id="admission_no" name="admission_no" autocomplete="off">
                                                                </div>
                                                            </th>
                                                            <?php if ($studentInfo->term_name == 'II PUC') { ?>
                                                            <?php $RouteNameII = $transport->getStudentPickUpInfo($studentInfo->route_id_II);?>
                                                            <th class="tbl-head" >II PUC Route</th>
                                                            <th width="240">
                                                                <div class="form-group mb-0 input_mobile_width">
                                                                    <select class="form-control " id="routeII" name="routeII" autocomplete="off">
                                                                        <?php if (!empty($studentInfo->route_id_II)) { ?>
                                                                            <option value="<?php echo $studentInfo->route_id_II; ?>">
                                                                                Selected: <?php echo $RouteNameII->pickup_point_name; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                        <option value="">Select Transport Route</option>
                                                                        <?php foreach($routeInfo as $route){ ?>
                                                                            <option value="<?php echo $route->row_id; ?>"><?php echo $route->pickup_point; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                            <?php } ?>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="table-responsive mt-1">
                                                    <table class="table table-bordered table_edit_student ">
                                                        <tr>
                                                            <th class="tbl-head" width="250">Physically Challenged</th>
                                                            <th width="250">
                                                                <select class="form-control mobile_input_width" id="is_handicapped" name="is_handicapped" data-live-search="true">
                                                                    <option value="<?php echo $studentInfo->Is_physically_challenged; ?>" >
                                                                        Selected: <?php echo $studentInfo->Is_physically_challenged ;  ?>
                                                                    </option>
                                                                    <option value="No" >No</option>
                                                                    <option value="Yes" >Yes</option>
                                                                </select>
                                                            </th>
                                                            <th class="tbl-head" width="250">Dyslexia</th>
                                                            <th>
                                                                <select class="form-control mobile_input_width" id="is_dyslexic" name="is_dyslexic" data-live-search="true">
                                                                    <option value="<?php echo $studentInfo->is_dyslexic; ?>">
                                                                        Selected: <?php echo $studentInfo->is_dyslexic; ?>
                                                                    </option>
                                                                    <option value="No" >No</option>
                                                                    <option value="Yes" >Yes</option>
                                                                </select>
                                                            </th>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-12">
                                                        <div class="card" style="font-size:16px; font-weight:900">
                                                            <div class="card-header head-title text-center p-1 tbl-head">
                                                                <span style="font-size:16px; font-weight:900">Present Address</span></div>
                                                            <div class="card-body p-1">
                                                                <textarea type="text" rows="4" class="form-control required p-1" placeholder="Present Address" id="present_address" 
                                                                name="present_address"autocomplete="off"><?php echo $studentInfo->present_address; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-12">
                                                        <div class="card " style="font-size:16px; font-weight:900">
                                                            <div class="card-header head-title text-center p-1 tbl-head">
                                                                <span style="font-size:16px; font-weight:900">Permanent Address</span></div>
                                                            <div class="card-body p-1">
                                                            <div class="form-group mb-0">
                                                                <textarea type="text" rows="4" class="form-control required p-1" placeholder="Permanent Address" id="permanent_address"
                                                                 name="permanent_address"autocomplete="off"><?php echo $studentInfo->permanent_address; ?></textarea>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>  
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mt-2">
                                                        <thead>
                                                            <tr class="head-title">
                                                                <th colspan="8" class="text-center tbl-head">Family Info</th>
                                                            </tr>
                                                            <tr class="head-title tbl-head">
                                                                <th class="text-center">Member Name</th>
                                                                <th class="text-center">Relationship</th>
                                                                <th class="text-center">Qualification</th>
                                                                <th class="text-center">Profession</th>
                                                                <th class="text-center">Annual Income</th>
                                                                <th class="text-center">Mobile Number</th>
                                                                <th class="text-center">Email Id</th>
                                                            </tr>
                                                        </thead>
                                                        <tr>
                                                            <th><input value="<?php echo $studentInfo->father_name; ?>" type="text"
                                                                    class="form-control required mobile_input_width" placeholder="Name" 
                                                                    id="father_name" name="father_name" maxlength="250" autocomplete="off" required/></th>
                                                            <th width="190">
                                                                <input type="text"
                                                                    class="form-control required mobile_input_width" placeholder="Relation Type" 
                                                                    value="FATHER" autocomplete="off" readonly/>
                                                            </th>
                                                            <th><input value="<?php echo $studentInfo->father_educational_qualification; ?>" type="text" 
                                                                    class="form-control required mobile_input_width" placeholder="Qualification" 
                                                                    id="father_educational_qualification" name="father_educational_qualification" autocomplete="off"/></th>
                                                            <th><input value="<?php echo $studentInfo->father_profession; ?>" type="text" 
                                                                    class="form-control required mobile_input_width" placeholder="Profession" 
                                                                    id="father_profession" name="father_profession" autocomplete="off"/></th>
                                                            <th><input value="<?php echo $studentInfo->father_annual_income; ?>" type="text" 
                                                                    class="form-control required mobile_input_width" placeholder="Annual Income" 
                                                                    id="father_annual_income" name="father_annual_income" maxlength="15" autocomplete="off"/></th>
                                                            <th><input value="<?php echo $studentInfo->father_mobile; ?>" type="text" 
                                                                    class="form-control required mobile_input_width" placeholder="Mobile Number" 
                                                                    id="father_mobile" name="father_mobile" maxlength="10" minlength="10" autocomplete="off"/></th>
                                                            <th><input value="<?php echo $studentInfo->father_email; ?>" type="email" 
                                                                    class="form-control required mobile_input_width" placeholder="Email" 
                                                                    id="father_email" name="father_email" autocomplete="off"/></th>
                                                        </tr>
                                                        <tr>
                                                            <th><input value="<?php echo $studentInfo->mother_name; ?>" type="text"
                                                                    class="form-control required mobile_input_width" placeholder="Name" 
                                                                    id="mother_name" name="mother_name" maxlength="250" autocomplete="off" required/></th>
                                                            <th width="190">
                                                                <input type="text"
                                                                    class="form-control required mobile_input_width" placeholder="Relation Type" 
                                                                    value="MOTHER" autocomplete="off" readonly/>
                                                            </th>
                                                            <th><input value="<?php echo $studentInfo->mother_educational_qualification; ?>" type="text" 
                                                                    class="form-control required mobile_input_width" placeholder="Qualification" 
                                                                    id="mother_educational_qualification" name="mother_educational_qualification" autocomplete="off"/></th>
                                                            <th><input value="<?php echo $studentInfo->mother_profession; ?>" type="text" 
                                                                    class="form-control required mobile_input_width" placeholder="Profession" 
                                                                    id="mother_profession" name="mother_profession" autocomplete="off"/></th>
                                                            <th><input value="<?php echo $studentInfo->mother_annual_income; ?>" type="text" 
                                                                    class="form-control required mobile_input_width" placeholder="Annual Income" 
                                                                    id="mother_annual_income" name="mother_annual_income" maxlength="15" autocomplete="off"/></th>
                                                            <th><input value="<?php echo $studentInfo->mother_mobile; ?>" type="text" 
                                                                    class="form-control required mobile_input_width" placeholder="Mobile Number" 
                                                                    id="mother_mobile" name="mother_mobile" maxlength="10" minlength="10" autocomplete="off"/></th>
                                                            <th><input value="<?php echo $studentInfo->mother_email; ?>" type="email" 
                                                                    class="form-control required mobile_input_width" placeholder="Email" 
                                                                    id="mother_email" name="mother_email" autocomplete="off"/></th>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <input type="submit" class="btn btn-success m-2 float-right" value="Update" />
                                            </form>
                                          
                                        </div>
                                        <div class="tab-pane fade" id="academic" role="tabpanel"
                                            aria-labelledby="academic-tab">
                                            <form role="form" action="<?php echo base_url() ?>updateStudentAcademicInfo" method="post" role="form">
                                                <input type="hidden" value="<?php echo $studentInfo->row_id; ?>" id="row_id" name="row_id">
                                                <input type="hidden" value="<?php echo $studentInfo->application_no; ?>" id="application_no" name="application_no">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table_edit_student ">
                                                        <tr>
                                                            <th class="tbl-head" width="160">Application Number</th>
                                                            <th width="140"><input value="<?php echo $studentInfo->application_no; ?>" type="text" 
                                                                    class="form-control required text-uppercase" placeholder="Application Number" 
                                                                    id="application_number" name="application_number" autocomplete="off"/></th>
                                                            <th class="tbl-head" width="160">PU Board No.</th>
                                                            <th width="140"><input value="<?php echo $studentInfo->pu_board_number; ?>" type="text" 
                                                                    class="form-control required text-uppercase" placeholder="Register Number" 
                                                                    id="register_no" name="register_no" autocomplete="off"/></th>
                                                            <th class="tbl-head" width="120">Student ID</th>
                                                            <th width="140"><input value="<?php echo $studentInfo->student_id; ?>" type="text" 
                                                                    class="form-control required text-uppercase" placeholder="Student ID" 
                                                                    id="student_id" name="student_id" autocomplete="off" readonly/></th>
                                                        </tr>
                                                        <tr>
                                                            <th class="tbl-head" width="150">Elective</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <select class="form-control" id="elective_sub" name="elective_sub" required>
                                                                        <option value="<?php echo $studentInfo->elective_sub; ?>" selected:>
                                                                            Selected: <?php echo $studentInfo->elective_sub; ?>
                                                                        </option>
                                                                        <option value="Kannada">Kannada</option>
                                                                        <option value="Hindi">Hindi</option>
                                                                        <!-- <option value="French">French</option>
                                                                        <option value="Urdu">Urdu</option> -->
                                                                        <option value="Exempted">Exempted</option>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head">Term</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <select class="form-control " id="term_name" name="term_name" autocomplete="off" required>
                                                                        <option value="<?php echo $studentInfo->term_name; ?>">
                                                                            Selected: <?php echo strtoupper($studentInfo->term_name); ?>
                                                                        </option>
                                                                        <option value="">Select Term</option>
                                                                        <option value="I PUC">I PUC</option>
                                                                        <option value="II PUC">II PUC</option>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head">Stream</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <select class="form-control " id="stream_name" name="stream_name" autocomplete="off" required>
                                                                        <option value="<?php echo $studentInfo->stream_name; ?>">
                                                                            Selected: <?php echo strtoupper($studentInfo->stream_name); ?>
                                                                        </option>
                                                                        <option value="">Select Stream</option>
                                                                        <?php if(!empty($streamInfo)){
                                                                            foreach($streamInfo as $stream){ ?>
                                                                        <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                                                        <?php } } ?>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="tbl-head">Section</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <select class="form-control " id="section_name" name="section_name" autocomplete="off">
                                                                        <?php if(!empty($studentInfo->section_name)){ ?>
                                                                        <option value="<?php echo $studentInfo->section_name; ?>">
                                                                            Selected: <?php echo strtoupper($studentInfo->section_name); ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                        <option value="">Select Section</option>
                                                                        <!-- <option value="A">A</option>
                                                                        <option value="B">B</option>
                                                                        <option value="C">C</option>
                                                                        <option value="D">D</option>
                                                                        <option value="E">E</option>
                                                                        <option value="F">F</option>
                                                                        <option value="G">G</option>
                                                                        <option value="H">H</option>
                                                                        <option value="I">I</option>
                                                                        <option value="J">J</option>
                                                                        <option value="K">K</option>
                                                                        <option value="L">L</option>
                                                                        <option value="M">M</option>
                                                                        <option value="N">N</option>
                                                                        <option value="O">O</option>
                                                                        <option value="P">P</option>
                                                                        <option value="Q">Q</option>
                                                                        <option value="R">R</option>
                                                                        <option value="S">S</option> -->
                                                                        <option value="ALL">ALL</option>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                            <th class="tbl-head" width="160">Hall Ticket No.</th>
                                                            <th width="140"><input value="<?php echo $studentInfo->hall_ticket_no; ?>" type="text" 
                                                                    class="form-control required text-uppercase" placeholder="Hall Ticket Number" 
                                                                    id="hall_ticket_no" name="hall_ticket_no" autocomplete="off"/></th>
                                                            <th class="tbl-head" width="160">Date of Admmission</th>
                                                            <th width="140"><input value="<?php if(!empty($studentInfo->date_of_admission) &&  $studentInfo->date_of_admission != '0000-00-00' && $studentInfo->date_of_admission != '1970-01-01'){
                                                                echo date('d-m-Y',strtotime($studentInfo->date_of_admission));
                                                            } ?>" type="text" 
                                                                    class="form-control required text-uppercase datepicker" placeholder="Admission Date" 
                                                                    id="date_of_admission" name="date_of_admission" autocomplete="off"/></th>
                                                        </tr>
                                                        <tr>
                                                            <th class="tbl-head">SAT Number</th>
                                                            <th>
                                                            <input value="<?php echo $studentInfo->sat_number;?>" type="text" 
                                                                    class="form-control required text-uppercase" placeholder="SAT Number" 
                                                                    id="sat_number" name="sat_number" autocomplete="off"/>
                                                            </th>
                                                            <th class="tbl-head" width="160">Date of Join</th>
                                                            <th width="140"><input value="<?php if(!empty($studentInfo->doj) && $studentInfo->doj != '0000-00-00' && $studentInfo->doj != '1970-01-01'){
                                                                echo date('d-m-Y',strtotime($studentInfo->doj));
                                                            } ?>" type="text" 
                                                                    class="form-control required text-uppercase datepicker" placeholder="Date of Join" 
                                                                    id="doj" name="doj" autocomplete="off"/></th>
                                                            
                                                            <th class="tbl-head">Program</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <select class="form-control " id="program_name" name="program_name" autocomplete="off" required>
                                                                        <option value="<?php echo $studentInfo->program_name; ?>">
                                                                            Selected: <?php echo strtoupper($studentInfo->program_name); ?>
                                                                        </option>
                                                                        <option value="">Select Program</option>
                                                                        <option value="SCIENCE">SCIENCE</option>
                                                                        <option value="COMMERCE">COMMERCE</option>
                                                                        <option value="ARTS">ARTS</option>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="tbl-head">Medium</th>
                                                            <th>
                                                                <div class="form-group mb-0">
                                                                    <select class="form-control " id="medium" name="medium" autocomplete="off" required>
                                                                        <?php if(!empty($studentInfo->medium)){ ?>
                                                                        <option value="<?php echo $studentInfo->medium; ?>">
                                                                            Selected: <?php echo strtoupper($studentInfo->medium); ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                        <option value="">Select Medium</option>
                                                                        <option value="ENGLISH">ENGLISH</option>
                                                                        <option value="KANNADA">KANNADA</option>
                                                                    </select>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <input type="submit" class="btn btn-success m-2 float-right" value="Update" />
                                            </form>
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
    </div>
</div>
<script type="text/javascript">
function GoBackWithRefresh(event) {
    showLoader();
    if ('referrer' in document) {
        window.location = document.referrer;
        window.location = '<?php echo base_url(); ?>/studentDetails';
        /* OR */
        //location.replace(document.referrer);
    } else {
        window.history.back();
    }
}
jQuery(document).ready(function() {

    jQuery('.resetFilters').click(function() {
        $(this).closest('form').find("input[type=text]").val("");
    })
    
    jQuery('.datepicker , .datepicker_doj').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        endDate: "today"
    });

                // Get the ID of the active tab from local storage
                var activeTabId = localStorage.getItem('vincentpuTabIdStudE');

                // If the ID is not null or undefined, activate the corresponding tab
                if (activeTabId) {
                $('#myTab a[href="#' + activeTabId + '"]').tab('show');
                }

                // Store the ID of the clicked tab in local storage
                $('#myTab a').on('click', function() {
                    var tabId = $(this).attr('href').substring(1);
                    localStorage.setItem('vincentpuTabIdStudE', tabId);
                });
});


function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#uploadedImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#vImg").change(function() {
    readURL(this);
});
</script>