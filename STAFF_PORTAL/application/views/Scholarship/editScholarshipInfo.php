<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.24/webcam.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/webcamjs/webcam.min.js"></script>
<style>
    .mt-6{
        margin-top: 1.8rem;
    }
</style>
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
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container container-fluid px-4 pt-2">
    <div class="content-wrapper">
        <div class="row ">
            <div class="col-md-12 col-lg-12  padding_left_right_null">
                <div class="card ">
                    <div class="card-header text-black card_heading_title p-1">
                        <div class="row ">
                            <div class="col-lg-6 text-black "><span class="page-title">
                                    <i class="fa fa-users"></i> Edit Scholarship Info  <?php echo strtoupper($scholarshipRecords->student_row_id); ?>
                                </span></div>
                            
                            <div class="col-lg-6"><a href="#" onclick="GoBackWithRefresh();return false;"
                             href="<?php echo base_url(); ?>/scholarshipListing"
                                    class="btn text-white btn-primary btn-bck float-right mobile-btn "><i
                                        class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Back </a></div>
                        </div>
                    </div>

                    <!-- form start -->
                    <div class="card-body contents-body ">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addFamily" action="<?php echo base_url() ?>updateScholarshipStudentDetails" method="post" enctype="multipart/form-data"
                            role="form">
                            <!-- Default Light Table -->
                            <div class="row form-contents">
                                <div class="col-lg-12  padding_left_right_null">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-row">
                                             
                                                    
                                                <input type="hidden" name="scholarship_row_id" value="<?php echo $scholarshipRecords->row_id; ?>">
                                                <div class="form-group col-md-2">
                                                    <div class="profile-img">
                                                    <?php
                                                            $profileImg = $scholarshipRecords->photo_url;
                                                                if(!empty($profileImg)){ ?>
                                                            <img src="<?php echo base_url(); ?><?php echo $profileImg; ?>" class="img-thumbnail"
                                                            alt="Profile Image" id="uploadedImage" name="userfile">
                                                            <?php } else { ?>
                                                            <img src="<?php echo base_url(); ?>assets/dist/img/user.png" class="img-thumbnail"
                                                            id="uploadedImage" name="userfile" alt="Profile default">
                                                            <?php } ?>
                                                        <div class="file btn btn-sm btn-primary">
                                                            Change Photo
                                                            <input type="file" class="form-control-sm" id="vImg" name="userfile" accept=".png,.jpg,.jpeg">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-2">

                                                     
                                                        <div style="width:60px;height:80px" class="clearfix" id="my_camera"
                                                            name="image"><img style="width: 200px;" class="after_capture_frame"
                                                                src="image_placeholder.jpg" />
                                                        </div>
                                                        <input type="hidden" name="captured_image_data" id="captured_image_data">
                                                        <button type="button" class="btn btn-info" onClick="take_snapshot()"><i
                                                                class="fa fa-camera fa-fw"></i>Capture</button>
                                                        <button type="button" class="btn btn-primary mr-0" id="clear_snapshot"
                                                            style="background-color:rgb(22, 22, 208);color:rgb(255, 255, 255);float: left;"> Clear</button>
                                        
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="usr">Application Date<span class="text-danger required_star">*</span></label>
                                                    <input type="text" name="application_date" class="form-control datepicker" value="<?php if(empty($scholarshipRecords->application_date) || $scholarshipRecords->application_date == '1970-01-01' || $scholarshipRecords->application_date == '0000-00-00' || $scholarshipRecords->application_date == '30-11--0001' ) {
                                                        echo ""; } else{
                                                        echo date('d-m-Y',strtotime($scholarshipRecords->application_date));
                                                        } ?>"
                                                    Placeholder="Enter Application Date" id="application_date" autocomplete="off" required>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="exampleInputEmail1">Term<span class="text-danger required_star">*</span></label>
                                                    <select type="text" name="term_name" class="form-control selectpicker"  
                                                    id="term_name" autocomplete="off" required>
                                                    <?php
                                                                if(!empty($scholarshipRecords->term_name)){ ?>
                                                        <option value="<?php  echo $scholarshipRecords->term_name; ?>"><?php  echo $scholarshipRecords->term_name; ?></option>
                                                           <?php } ?>


                                                        <option value="">Select Term</option>
                                                        <option value="PRE-KG">PRE-KG</option>
                                                        <option value="LKG">LKG</option>
                                                        <option value="UKG">UKG</option>
                                                        <option value="I">I</option>
                                                        <option value="II">II</option>
                                                        <option value="III">III</option>
                                                        <option value="IV">IV</option>
                                                        <option value="V">V</option>
                                                        <option value="VI">VI</option>
                                                        <option value="VII">VII</option>
                                                        <option value="VIII">VIII</option>
                                                        <option value="IX">IX</option>
                                                        <option value="X">X</option>
                                                        <option value="XI">XI</option>
                                                        <option value="XII">XII</option>
                                                        <option value="I YEAR DEGREE">I YEAR DEGREE</option>
                                                        <option value="II YEAR DEGREE">II YEAR DEGREE</option>
                                                        <option value="III YEAR DEGREE">III YEAR DEGREE</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="fname">Scholarship Amount<span class="text-danger required_star">*</span></label>
                                                    <input class="form-control" type="text"
                                                        name="scholarship_amount" id="scholarship_amount" value="<?php echo $scholarshipRecords->scholarship_amount?>"
                                                        class="form-control input-sm pull-right " required
                                                         placeholder="Scholarship Amount"  onkeypress="return isNumberKey(event)"
                                                        autocomplete="off">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="fname">Scholarship Code</label>
                                                    <input class="form-control" type="text"
                                                        name="scholarship_code" id="scholarship_code" value="<?php echo $scholarshipRecords->scholarship_code?>"
                                                        class="form-control input-sm pull-right "
                                                         placeholder="Scholarship Code" 
                                                        autocomplete="off">
                                                </div>

                                               
                                                <div class="form-group col-md-3">
                                                    <label for="fname">Amount Requested</label>
                                                    <input class="form-control" type="text"
                                                        name="amount_requested" id="amount_requested" value="<?php echo $scholarshipRecords->amount_requested; ?>"
                                                        class="form-control input-sm pull-right "
                                                         placeholder="Amount"  onkeypress="return isNumberKey(event)"
                                                        autocomplete="off">
                                                </div>
                                                <div class="form-group col-md-3 neft_info">
                                                    <label for="usr">Payment Date<span class="text-danger required_star">*</span></label>
                                                    <input type="text" name="payment_date" class="form-control datepicker" value="<?php if(empty($scholarshipRecords->payment_date) || $scholarshipRecords->payment_date == '1970-01-01' || $scholarshipRecords->payment_date == '0000-00-00' || $scholarshipRecords->payment_date == '30-11--0001' ) {
                                                        echo ""; } else{
                                                        echo date('d-m-Y',strtotime($scholarshipRecords->payment_date));
                                                        } ?>"
                                                    Placeholder="Enter Payment Date" id="payment_date" autocomplete="off" required>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="fname">Debit A/C No</label>
                                                    <input class="form-control " type="text"
                                                        name="debit_ac_no" id="debit_ac_no" value="<?php echo $scholarshipRecords->debit_ac_no; ?>"
                                                        class="form-control input-sm pull-right "
                                                         placeholder="Debit A/C No"
                                                        autocomplete="off">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="fname">Credit A/C No</label>
                                                    <input class="form-control " type="text"
                                                        name="credit_ac_no" id="credit_ac_no" value="<?php echo $scholarshipRecords->credit_ac_no; ?>"
                                                        class="form-control input-sm pull-right "
                                                         placeholder="Credit A/C No"
                                                        autocomplete="off">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="exampleInputEmail1">Recommended By<span class="text-danger required_star">*</span></label>
                                                    <select class="form-control selectpicker" name="recommended_by" id="recommended_by" data-live-search="true" required autocomplete="off">
                                                    <?php if(!empty($scholarshipRecords->recommended_by)){ ?>
                                                        <option value="<?php echo $scholarshipRecords->recommended_by; ?>" >
                                                            Selected: <?php echo $scholarshipRecords->recommended_by; ?>
                                                        </option>
                                                        <?php } ?>
                                                        <option value="">Select Recommended By</option>
                                                        <?php if(!empty($scholarshipRecommendedInfo)){
                                                            foreach($scholarshipRecommendedInfo as $std){  ?>
                                                            <option value="<?php echo $std->name; ?>"><b><?php echo $std->name; ?></b></option>
                                                        <?php } } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="exampleInputEmail1">Sanctioned By<span class="text-danger required_star">*</span></label>
                                                    <select class="form-control selectpicker" name="sanctioned_by" id="sanctioned_by" data-live-search="true" required autocomplete="off">
                                                    <?php if(!empty($scholarshipRecords->sanctioned_by)){ ?>
                                                        <option value="<?php echo $scholarshipRecords->sanctioned_by; ?>" >
                                                            Selected: <?php echo $scholarshipRecords->sanctioned_by; ?>
                                                        </option>
                                                        <?php } ?>
                                                        <option value="">Select Sanctioned By</option>
                                                        <?php if(!empty($scholarshipRecommendedInfo)){
                                                            foreach($scholarshipRecommendedInfo as $std){  ?>
                                                            <option value="<?php echo $std->name; ?>"><b><?php echo $std->name; ?></b></option>
                                                        <?php } } ?>
                                                    </select>
                                                </div>

                                                
                                                
                                                <div class="form-group col-md-3">
                                                    <label for="fname">Remarks</label>
                                                    <textarea class="form-control" type="text"
                                                        name="remarks" id="remarks" value=""
                                                        class="form-control input-sm pull-right "
                                                         placeholder="Remarks" rows="2"
                                                        autocomplete="off"> <?php echo $scholarshipRecords->remarks; ?></textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <table class="table table-bordered">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>Document Name</th>
                                                                <th>Yes</th>
                                                                <th>No</th>
                                                                <th>NA</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- Application -->
                                                            <?php if (strpos($scholarshipRecords->application, ',') !== false) {
                                                                $application = explode(',', $scholarshipRecords->application);
                                                            } else {
                                                                $application = $scholarshipRecords->application;
                                                            } 
                                                             // If $application is not an array, make it one
                                                            if (!is_array($application)) {
                                                                $application = explode(',', $application);  // Convert it to an array if it's a string
                                                            }
                                                            if (strpos($scholarshipRecords->student_aadhar, ',') !== false) {
                                                                $student_aadhar = explode(',', $scholarshipRecords->student_aadhar);
                                                            } else {
                                                                $student_aadhar = $scholarshipRecords->student_aadhar;
                                                            }
                                                            // If $application is not an array, make it one
                                                            if (!is_array($student_aadhar)) {
                                                                $student_aadhar = explode(',', $student_aadhar);  // Convert it to an array if it's a string
                                                            }
                                            
                                                            if (strpos($scholarshipRecords->parents_aadhar, ',') !== false) {
                                                                $parents_aadhar = explode(',', $scholarshipRecords->parents_aadhar);
                                                            } else {
                                                                $parents_aadhar = $scholarshipRecords->parents_aadhar;
                                                            }
                                                            // If $application is not an array, make it one
                                                            if (!is_array($parents_aadhar)) {
                                                                $parents_aadhar = explode(',', $parents_aadhar);  // Convert it to an array if it's a string
                                                            }
                                            
                                                            if (strpos($scholarshipRecords->bank_pass_book, ',') !== false) {
                                                                $bank_pass_book = explode(',', $scholarshipRecords->bank_pass_book);
                                                            } else {
                                                                $bank_pass_book = $scholarshipRecords->bank_pass_book;
                                                            }
                                                            // If $application is not an array, make it one
                                                            if (!is_array($bank_pass_book)) {
                                                                $bank_pass_book = explode(',', $bank_pass_book);  // Convert it to an array if it's a string
                                                            }
                                            
                                                            if (strpos($scholarshipRecords->income_certificate, ',') !== false) {
                                                                $income_certificate = explode(',', $scholarshipRecords->income_certificate);
                                                            } else {
                                                                $income_certificate = $scholarshipRecords->income_certificate;
                                                            }
                                                            // If $application is not an array, make it one
                                                            if (!is_array($income_certificate)) {
                                                                $income_certificate = explode(',', $income_certificate);  // Convert it to an array if it's a string
                                                            }
                                            
                                                            if (strpos($scholarshipRecords->marks_card, ',') !== false) {
                                                                $marks_card = explode(',', $scholarshipRecords->marks_card);
                                                            } else {
                                                                $marks_card = $scholarshipRecords->marks_card;
                                                            }
                                                            // If $application is not an array, make it one
                                                            if (!is_array($marks_card)) {
                                                                $marks_card = explode(',', $marks_card);  // Convert it to an array if it's a string
                                                            }
                                            
                                                            if (strpos($scholarshipRecords->recommendation_letter, ',') !== false) {
                                                                $recommendation_letter = explode(',', $scholarshipRecords->recommendation_letter);
                                                            } else {
                                                                $recommendation_letter = $scholarshipRecords->recommendation_letter;
                                                            }
                                                            // If $application is not an array, make it one
                                                            if (!is_array($recommendation_letter)) {
                                                                $recommendation_letter = explode(',', $recommendation_letter);  // Convert it to an array if it's a string
                                                            }
                                            
                                                            if (strpos($scholarshipRecords->fee_payment_receipt, ',') !== false) {
                                                                $fee_payment_receipt = explode(',', $scholarshipRecords->fee_payment_receipt);
                                                            } else {
                                                                $fee_payment_receipt = $scholarshipRecords->fee_payment_receipt;
                                                            }
                                                            // If $application is not an array, make it one
                                                            if (!is_array($fee_payment_receipt)) {
                                                                $fee_payment_receipt = explode(',', $fee_payment_receipt);  // Convert it to an array if it's a string
                                                            }
                                            
                                                            if (strpos($scholarshipRecords->passport_size_photo, ',') !== false) {
                                                                $passport_size_photo = explode(',', $scholarshipRecords->passport_size_photo);
                                                            } else {
                                                                $passport_size_photo = $scholarshipRecords->passport_size_photo;
                                                            }
                                                            // If $application is not an array, make it one
                                                            if (!is_array($passport_size_photo)) {
                                                                $passport_size_photo = explode(',', $passport_size_photo);  // Convert it to an array if it's a string
                                                            }
                                            
                                                            if (strpos($scholarshipRecords->institution_transfer_of_scholarship_letter, ',') !== false) {
                                                                $institution_transfer_of_scholarship_letter = explode(',', $scholarshipRecords->institution_transfer_of_scholarship_letter);
                                                            } else {
                                                                $institution_transfer_of_scholarship_letter = $scholarshipRecords->institution_transfer_of_scholarship_letter;
                                                            }
                                                            // If $application is not an array, make it one
                                                            if (!is_array($institution_transfer_of_scholarship_letter)) {
                                                                $institution_transfer_of_scholarship_letter = explode(',', $institution_transfer_of_scholarship_letter);  // Convert it to an array if it's a string
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td>Application</td>
                                                                <td><input type="checkbox" name="document[application][]" value="0" <?php if (in_array("0", $application)) echo "checked"; ?>></td>
                                                                <td><input type="checkbox" name="document[application][]" value="1" <?php if (in_array("1", $application)) echo "checked"; ?>></td>
                                                                <td><input type="checkbox" name="document[application][]" value="2" <?php if (in_array("2", $application)) echo "checked"; ?>></td>
                                                            </tr>
                                                            
                                                            <!-- Aadhar Card of the Student -->
                                                            <tr>
                                                                <td>Aadhar Card of the Student</td>
                                                                <td><input type="checkbox" name="document[aadhar_student][]" value="0" <?php if (in_array("0", $student_aadhar)) echo "checked"; ?>></td>
                                                                <td><input type="checkbox" name="document[aadhar_student][]" value="1" <?php if (in_array("1", $student_aadhar)) echo "checked"; ?>></td>
                                                                <td><input type="checkbox" name="document[aadhar_student][]" value="2" <?php if (in_array("2", $student_aadhar)) echo "checked"; ?>></td>
                                                            </tr>

                                                            <!-- Aadhar Card of Parents -->
                                                            <tr>
                                                                <td>Aadhar Card of Parents</td>
                                                                <td><input type="checkbox" name="document[aadhar_parents][]" value="0"  <?php if (in_array("0", $parents_aadhar)) echo "checked"; ?>></td>
                                                                <td><input type="checkbox" name="document[aadhar_parents][]" value="1" <?php if (in_array("1", $parents_aadhar)) echo "checked"; ?>></td>
                                                                <td><input type="checkbox" name="document[aadhar_parents][]" value="2" <?php if (in_array("2", $parents_aadhar)) echo "checked"; ?>></td>
                                                            </tr>

                                                            <!-- Bank Pass Book -->
                                                            <tr>
                                                                <td>Bank Pass Book</td>
                                                                <td><input type="checkbox" name="document[bank_passbook][]" value="0" <?php if (in_array("0", $bank_pass_book)) echo "checked"; ?>></td>
                                                                <td><input type="checkbox" name="document[bank_passbook][]" value="1" <?php if (in_array("1", $bank_pass_book)) echo "checked"; ?>></td>
                                                                <td><input type="checkbox" name="document[bank_passbook][]" value="2" <?php if (in_array("2", $bank_pass_book)) echo "checked"; ?>></td>
                                                            </tr>

                                                            <!-- Income Caste Certificate -->
                                                            <tr>
                                                                <td>Income Caste Certificate</td>
                                                                <td><input type="checkbox" name="document[income_caste_certificate][]" value="0" <?php if (in_array("0", $income_certificate)) echo "checked"; ?>></td>
                                                                <td><input type="checkbox" name="document[income_caste_certificate][]" value="1" <?php if (in_array("1", $income_certificate)) echo "checked"; ?>></td>
                                                                <td><input type="checkbox" name="document[income_caste_certificate][]" value="2" <?php if (in_array("2", $income_certificate)) echo "checked"; ?>></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- Second Section (Next 5 Documents) -->
                                                <div class="col-md-6">
                                                    <table class="table table-bordered">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>Document Name</th>
                                                                <th>Yes</th>
                                                                <th>No</th>
                                                                <th>NA</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- Marks Card -->
                                                            <tr>
                                                                <td>Marks Card</td>
                                                                <td><input type="checkbox" name="document[marks_card][]" value="0" <?php if (in_array("0", $marks_card)) echo "checked"; ?>></td>
                                                                <td><input type="checkbox" name="document[marks_card][]" value="1" <?php if (in_array("1", $marks_card)) echo "checked"; ?>></td>
                                                                <td><input type="checkbox" name="document[marks_card][]" value="2" <?php if (in_array("2", $marks_card)) echo "checked"; ?>></td>
                                                            </tr>

                                                            <!-- Recommendation Letter -->
                                                            <tr>
                                                                <td>Recommendation Letter</td>
                                                                <td><input type="checkbox" name="document[recommendation_letter][]" value="0" <?php if (in_array("0", $recommendation_letter)) echo "checked"; ?>></td>
                                                                <td><input type="checkbox" name="document[recommendation_letter][]" value="1"  <?php if (in_array("1", $recommendation_letter)) echo "checked"; ?>></td>
                                                                <td><input type="checkbox" name="document[recommendation_letter][]" value="2" <?php if (in_array("2", $recommendation_letter)) echo "checked"; ?>></td>
                                                            </tr>

                                                            <!-- Fee Payment Receipt -->
                                                            <tr>
                                                                <td>Fee Payment Receipt</td>
                                                                <td><input type="checkbox" name="document[fee_payment_receipt][]" value="0" <?php if (in_array("0", $fee_payment_receipt)) echo "checked"; ?>></td>
                                                                <td><input type="checkbox" name="document[fee_payment_receipt][]" value="1" <?php if (in_array("1", $fee_payment_receipt)) echo "checked"; ?>></td>
                                                                <td><input type="checkbox" name="document[fee_payment_receipt][]" value="2" <?php if (in_array("2", $fee_payment_receipt)) echo "checked"; ?>></td>
                                                            </tr>

                                                            <!-- Passport Size Photo - 2 -->
                                                            <tr>
                                                                <td>Passport Size Photo - 2</td>
                                                                <td><input type="checkbox" name="document[passport_photo][]" value="0" <?php if (in_array("0", $passport_size_photo)) echo "checked"; ?>></td>
                                                                <td><input type="checkbox" name="document[passport_photo][]" value="1" <?php if (in_array("1", $passport_size_photo)) echo "checked"; ?>></td>
                                                                <td><input type="checkbox" name="document[passport_photo][]" value="2" <?php if (in_array("2", $passport_size_photo)) echo "checked"; ?>></td>
                                                            </tr>

                                                            <!-- Institutional Transfer of Scholarship Letter (Optional) -->
                                                            <tr>
                                                                <td>Institutional Transfer of Scholarship Letter</td>
                                                                <td><input type="checkbox" name="document[scholarship_transfer_letter][]" value="0" <?php if (in_array("0", $institution_transfer_of_scholarship_letter)) echo "checked"; ?>></td>
                                                                <td><input type="checkbox" name="document[scholarship_transfer_letter][]" value="1" <?php if (in_array("1", $institution_transfer_of_scholarship_letter)) echo "checked"; ?>></td>
                                                                <td><input type="checkbox" name="document[scholarship_transfer_letter][]" value="2" <?php if (in_array("2", $institution_transfer_of_scholarship_letter)) echo "checked"; ?>></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                
                                               
                                                   

                                            </div>
                                            <div class="text-right">
                                                <button type="submit" class="btn btn-success  ml-4"><b>Submit</b></button>
                                            </div>


                                           


                                            <!-- <div class="text-right">
                                                
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form> 
                            
                            
                            
                    </div>
                    
                </div>
            </div>


        </div>
    </div>
</div>
<!-- form end -->
<!-- End Default Light Table -->


<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8">
</script>
<script type="text/javascript">
function GoBackWithRefresh(event) {
    if ('referrer' in document) {
        window.location = '<?php echo base_url(); ?>scholarshipListing';
        /* OR */
        //location.replace(document.referrer);
    } else {
        window.history.back();
    }
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;
    return true;
}

jQuery(document).ready(function() {

    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        jQuery("#searchList").attr("action", link);
        jQuery("#searchList").submit();
    });
    jQuery('.resetFilters').click(function() {
        $(this).closest('form').find("input[type=text]").val("");
    })
    // Prepare the preview for profile picture
    $("#wizard-picture").change(function() {
        readURL(this);
    });
    jQuery('.datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

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
Webcam.set({
    width: 180,
    height: 100,
    image_format: 'jpeg',
    jpeg_quality: 90
});

Webcam.attach('#my_camera');

function take_snapshot() {

    Webcam.snap(function(data_uri) {

        document.getElementById('my_camera').innerHTML =
            '<img class="after_capture_frame" src="' + data_uri + '" width="180" height="100"/>';
        $("#captured_image_data").val(data_uri);
    });
}

$('#clear_snapshot').click(function() {
    $("#captured_image_data").val('');
    document.getElementById('my_camera').innerHTML = '';
    Webcam.attach('#my_camera');

});


$('#clear_all').click(function() {
    document.getElementById('my_camera').innerHTML = '';
    Webcam.attach('#my_camera');
    $("#captured_image_data").val('');
    $('.selectpicker').selectpicker('refresh');

});
</script>