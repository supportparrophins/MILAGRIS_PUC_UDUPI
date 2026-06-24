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
                            <div class="col-lg-3 text-black "><span class="page-title">
                                    <i class="fa fa-users"></i> Scholarship Info
                                </span></div>
                            <div class="col-lg-5 text-black " ><span class="page-title" style="font-size:20px;">
                               Scholarship Type : <?php echo $scholarshipInfo->scholarship_type; ?>
                            </span></div>
                            <div class="col-lg-3 text-black " ><span class="page-title" style="font-size:20px;">
                               Society : <?php echo $scholarshipInfo->scholarship_society; ?>
                            </span></div>
                           
                            <div class="col-lg-1"> <a  onclick="window.history.back();" 
                                    class="btn btn_back mobile-btn float-right text-white btn-backtrack"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a></div>
                        </div>
                    </div>

                    <!-- form start -->
                    <div class="card-body contents-body ">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addFamily" action="<?php echo base_url() ?>addScholarshipStudentDetails" method="post" enctype="multipart/form-data"
                            role="form">
                            <!-- Default Light Table -->
                            <div class="row form-contents">
                                <div class="col-lg-12  padding_left_right_null">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-row">
                                             
                                                    
                                                <input type="hidden" name="scholarship_row_id" value="<?php echo $scholarshipInfo->row_id; ?>">
                                                
                                               
                                                <div class="form-group col-md-2">
                                                    <div class="row justify-content-center">
                                                        <img src="<?php echo base_url(); ?>assets/images/user.png"
                                                            class="avatar rounded-circle img-thumbnail" width="70" height="70" src="#"
                                                            id="uploadedImage" name="userfile" alt="avatar">
                                                    </div>

                                                        <div class="profileImg text-center mt-2">
                                                            <div class="file btn btn-sm btn-primary">
                                                                Change
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
                                                
                                                <div class="form-group col-md-2">
                                                    <label for="exampleInputEmail1">Student<span class="text-danger required_star">*</span></label>
                                                    <input type="text" name="student_id" class="form-control" 
                                                    Placeholder="Enter Student Name" id="student_id" autocomplete="off" required>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="exampleInputEmail1">Term<span class="text-danger required_star">*</span></label>
                                                    <select type="text" name="term_name" class="form-control selectpicker"  
                                                    id="term_name" autocomplete="off" required>
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
                                                    <label for="usr">Application Date<span class="text-danger required_star">*</span></label>
                                                    <input type="text" name="application_date" class="form-control datepicker" 
                                                    Placeholder="Enter Application Date" id="application_date" autocomplete="off" required>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="fname">Scholarship Amount<span class="text-danger required_star">*</span></label>
                                                    <input class="form-control" type="text"
                                                        name="scholarship_amount" id="scholarship_amount" value=""
                                                        class="form-control input-sm pull-right " required
                                                         placeholder="Scholarship Amount"  onkeypress="return isNumberKey(event)"
                                                        autocomplete="off">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="fname">Scholarship Code</label>
                                                    <input class="form-control" type="text"
                                                        name="scholarship_code" id="scholarship_code" value=""
                                                        class="form-control input-sm pull-right "
                                                         placeholder="Scholarship Code" 
                                                        autocomplete="off">
                                                </div>

                                               
                                                <div class="form-group col-md-2">
                                                    <label for="fname">Amount Requested</label>
                                                    <input class="form-control" type="text"
                                                        name="amount_requested" id="amount_requested" value=""
                                                        class="form-control input-sm pull-right "
                                                         placeholder="Amount"  onkeypress="return isNumberKey(event)"
                                                        autocomplete="off">
                                                </div>

                                                <div class="form-group col-md-2 neft_info">
                                                    <label for="usr">Payment Date<span class="text-danger required_star">*</span></label>
                                                    <input type="text" name="payment_date" class="form-control datepicker" 
                                                    Placeholder="Enter Payment Date" id="payment_date" autocomplete="off" required>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="fname">Debit A/C No</label>
                                                    <input class="form-control " type="text"
                                                        name="debit_ac_no" id="debit_ac_no" value=""
                                                        class="form-control input-sm pull-right "
                                                         placeholder="Debit A/C No"
                                                        autocomplete="off">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="fname">Credit A/C No</label>
                                                    <input class="form-control " type="text"
                                                        name="credit_ac_no" id="credit_ac_no" value=""
                                                        class="form-control input-sm pull-right "
                                                         placeholder="Credit A/C No"
                                                        autocomplete="off">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="exampleInputEmail1">Recommended By<span class="text-danger required_star">*</span></label>
                                                    <select class="form-control selectpicker" name="recommended_by" id="recommended_by" data-live-search="true" required autocomplete="off">
                                                        <option value="">Select Recommended By</option>
                                                        <?php if(!empty($scholarshipRecommendedInfo)){
                                                            foreach($scholarshipRecommendedInfo as $std){  ?>
                                                            <option value="<?php echo $std->name; ?>"><b><?php echo $std->name; ?></b></option>
                                                        <?php } } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="exampleInputEmail1">Sanctioned By<span class="text-danger required_star">*</span></label>
                                                    <select class="form-control selectpicker" name="sanctioned_by" id="sanctioned_by" data-live-search="true" required autocomplete="off">
                                                        <option value="">Select Sanctioned By</option>
                                                        <?php if(!empty($scholarshipRecommendedInfo)){
                                                            foreach($scholarshipRecommendedInfo as $std){  ?>
                                                            <option value="<?php echo $std->name; ?>"><b><?php echo $std->name; ?></b></option>
                                                        <?php } } ?>
                                                    </select>
                                                </div>

                                                
                                                
                                                <div class="form-group col-md-4">
                                                    <label for="fname">Remarks</label>
                                                    <textarea class="form-control" name="remarks" id="remarks"
                                                        class="form-control input-sm pull-right" rows="3" 
                                                        placeholder="Enter Remarks" autocomplete="off"></textarea>
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
                                                            <tr>
                                                                <td>Application</td>
                                                                <td><input type="checkbox" name="document[application][]" value="0"></td>
                                                                <td><input type="checkbox" name="document[application][]" value="1"></td>
                                                                <td><input type="checkbox" name="document[application][]" value="2"></td>
                                                            </tr>
                                                            
                                                            <!-- Aadhar Card of the Student -->
                                                            <tr>
                                                                <td>Aadhar Card of the Student</td>
                                                                <td><input type="checkbox" name="document[aadhar_student][]" value="0"></td>
                                                                <td><input type="checkbox" name="document[aadhar_student][]" value="1"></td>
                                                                <td><input type="checkbox" name="document[aadhar_student][]" value="2"></td>
                                                            </tr>

                                                            <!-- Aadhar Card of Parents -->
                                                            <tr>
                                                                <td>Aadhar Card of Parents</td>
                                                                <td><input type="checkbox" name="document[aadhar_parents][]" value="0"></td>
                                                                <td><input type="checkbox" name="document[aadhar_parents][]" value="1"></td>
                                                                <td><input type="checkbox" name="document[aadhar_parents][]" value="2"></td>
                                                            </tr>

                                                            <!-- Bank Pass Book -->
                                                            <tr>
                                                                <td>Bank Pass Book</td>
                                                                <td><input type="checkbox" name="document[bank_passbook][]" value="0"></td>
                                                                <td><input type="checkbox" name="document[bank_passbook][]" value="1"></td>
                                                                <td><input type="checkbox" name="document[bank_passbook][]" value="2"></td>
                                                            </tr>

                                                            <!-- Income Caste Certificate -->
                                                            <tr>
                                                                <td>Income Caste Certificate</td>
                                                                <td><input type="checkbox" name="document[income_caste_certificate][]" value="0"></td>
                                                                <td><input type="checkbox" name="document[income_caste_certificate][]" value="1"></td>
                                                                <td><input type="checkbox" name="document[income_caste_certificate][]" value="2"></td>
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
                                                                <td><input type="checkbox" name="document[marks_card][]" value="0"></td>
                                                                <td><input type="checkbox" name="document[marks_card][]" value="1"></td>
                                                                <td><input type="checkbox" name="document[marks_card][]" value="2"></td>
                                                            </tr>

                                                            <!-- Recommendation Letter -->
                                                            <tr>
                                                                <td>Recommendation Letter</td>
                                                                <td><input type="checkbox" name="document[recommendation_letter][]" value="0"></td>
                                                                <td><input type="checkbox" name="document[recommendation_letter][]" value="1"></td>
                                                                <td><input type="checkbox" name="document[recommendation_letter][]" value="2"></td>
                                                            </tr>

                                                            <!-- Fee Payment Receipt -->
                                                            <tr>
                                                                <td>Fee Payment Receipt</td>
                                                                <td><input type="checkbox" name="document[fee_payment_receipt][]" value="0"></td>
                                                                <td><input type="checkbox" name="document[fee_payment_receipt][]" value="1"></td>
                                                                <td><input type="checkbox" name="document[fee_payment_receipt][]" value="2"></td>
                                                            </tr>

                                                            <!-- Passport Size Photo - 2 -->
                                                            <tr>
                                                                <td>Passport Size Photo - 2</td>
                                                                <td><input type="checkbox" name="document[passport_photo][]" value="0"></td>
                                                                <td><input type="checkbox" name="document[passport_photo][]" value="1"></td>
                                                                <td><input type="checkbox" name="document[passport_photo][]" value="2"></td>
                                                            </tr>

                                                            <!-- Institutional Transfer of Scholarship Letter (Optional) -->
                                                            <tr>
                                                                <td>Institutional Transfer of Scholarship Letter</td>
                                                                <td><input type="checkbox" name="document[scholarship_transfer_letter][]" value="0"></td>
                                                                <td><input type="checkbox" name="document[scholarship_transfer_letter][]" value="1"></td>
                                                                <td><input type="checkbox" name="document[scholarship_transfer_letter][]" value="2"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                
                                               
                                                   

                                            </div>
                                            <div class="text-right">
                                                <button type="submit" class="btn btn-success  ml-4"><b>Submit</b></button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form> 
                            
                            
                            
                    </div>
                    <table class=" display table table-bordered table-striped table-hover w-100">
                        <tr class="bg-deafult">
                            <form action="<?php echo base_url() . 'editScholarshipDetailsPageView/' . $scholarshipInfo->row_id; ?>" method="POST" id="byFilterMethod">

                                <th width="150" style="padding: 0px;">
                                        <div class="form-group position-relative mb-0"><input
                                                class="form-control is-valid mobile-width " type="text" name="application_no"
                                                id="" value="<?php echo $application_no ?>"
                                                class="form-control input-sm pull-right"
                                                placeholder="By Application No."
                                                autocomplete="off">
                                        </div>
                                    </th>
                                    <th width="150" style="padding: 0px;">
                                        <div class="form-group position-relative mb-0"><input
                                                class="form-control is-valid mobile-width " type="text" name="student_name"
                                                id="" value="<?php echo $student_name ?>"
                                                class="form-control input-sm pull-right"
                                                placeholder="By Student Name"
                                                autocomplete="off">
                                        </div>
                                    </th>
                                    <th width="150" style="padding: 0px;">
                                        <div class="form-group position-relative mb-0"><input
                                                class="form-control is-valid mobile-width datepicker" type="text" name="application_date"
                                                id="" value="<?php echo $application_date ?>"
                                                class="form-control input-sm pull-right"
                                                style="text-transform: uppercase" placeholder="By Application Date" readonly
                                                autocomplete="off">
                                        </div>
                                    </th>
                                
                                    <th width="150" style="padding: 0px;">
                                        <div class="form-group position-relative mb-0"><input
                                                class="form-control is-valid mobile-width " type="text" name="debit_ac_no_list"
                                                id="" value="<?php echo $debit_ac_no_list ?>"
                                                class="form-control input-sm pull-right"
                                                 placeholder="Debit Ac No"
                                                autocomplete="off">
                                        </div>
                                    </th>
                                    <th width="150" style="padding: 0px;">
                                        <div class="form-group position-relative mb-0"><input
                                                class="form-control is-valid mobile-width " type="text" name="credit_ac_no_list"
                                                id="" value="<?php echo $credit_ac_no_list ?>"
                                                class="form-control input-sm pull-right"
                                                 placeholder="Credit Ac No"
                                                autocomplete="off">
                                        </div>
                                    </th>

                                    <th width="180" class="text-center btn-padding"><button type="submit"
                                            class="btn btn-success btn-block mobile-width"> Search</button></th>
                                </form>
                            </tr>
                            <tr class="text-white bg-primary">
                                <th style="color:black;">Application No.</th>
                                <th style="color:black;">Student Name</th>
                                <th style="color:black;">Application Date</th>
                                <th style="color:black;">Debit A/C No</th>
                                <th style="color:black;">Credit A/C No</th>
                                <th style="color:black;" class="text-center">Actions</th>
                            </tr>
                            <?php
                    if(!empty($scholarshipRecords))
                    {
                        foreach($scholarshipRecords as $record)
                        {
                    ?>
                            <tr class="text-black">
                            <td><?php echo $record->application_number ?></td>
                               <td class="text-left"><?php echo $record->student_row_id ?></td>
                               <td class="text-left"><?php echo date('d-m-Y',strtotime($record->application_date)); ?></td>
                             
                                <td><?php echo $record->debit_ac_no ?></td>
                                <td><?php echo $record->credit_ac_no ?></td>
                                <td class="text-center">
                                   
                                        <a href="<?php echo base_url().'scholarshipStudentPrint/'.$record->row_id; ?>" target="_blank"><i class="fa fa-print"></i>Form</a>
                                        <a class="btn btn-xs btn-info" target="_blank"
                                                href="<?php echo base_url(); ?>editScholarshipInfo/<?php echo $record->row_id; ?>" title="Edit Scholarship"><i
                                                    class="fas fa-pencil-alt"></i></a>
                                    <a class="btn btn-sm btn-danger deleteScholarshipDetail" href="#"
                                        data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i
                                            class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else { ?>
                            <tr>
                                <td class="text-center " colspan="10">
                                    <div style="text-align: center;">
                                        <!-- <img style="max-width: 20%; height: 10%;" src="<?php echo base_url(); ?>assets/images/empty.png" alt="No Data"> -->
                                        <p style="font-weight:bold; margin-bottom:0px;">No data available</p>
                                    </div>
                                </td>
                            </tr>
                            <?php }
                      ?>
                        </table>
                    
                     
                    
                    
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

</script>