
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
<?php
        $warning = $this->session->flashdata('warning');
        if ($warning) {
        ?>
<div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <i class="fa fa-check mx-2"></i>
    <strong>warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
</div>
<?php }?>
<div class="row">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container container-fluid px-4 pt-2">
    <div class="content-wrapper">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12 col-lg-12 padding_left_right_null">
                <div class="card ">
                    <div class="card-header text-white card-content-title p-1 card_head_dashboard">
                        <div class="row ">
                            <div class="col-lg-6 col-sm-6 col-6">
                                <span class="page-title absent_table_title_mobile">
                                <i class="fas fa-phone-square-alt"></i> Admission Enquiry
                                </span>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-6 box-tools">
                                <a onclick="GoBackWithRefresh();" class="btn primary_color  mobile-btn float-right text-white pt-2"
                                value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                            </div> 
                        </div>
                    </div>
                    <div class="card-body contents-body">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addAdmission" action="<?php echo base_url() ?>updateAdmission" method="post" role="form" enctype="multipart/form-data">
                        <input type="hidden" value="<?php echo $admissionInfo->row_id; ?>" id="row_id" name="row_id">
                            <div class="row form-contents">
                                 <div class="col-lg-12">
                                    <div class="row">
                                     
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="name">Name<span class="text-danger required_star">*</span></label>
                                            <input type="text" class="form-control required" id="name" value="<?php echo $admissionInfo->name; ?>"   name="name" placeholder="Name" autocomplete="off" required/>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                           <label for="email">Email<span class="text-danger required_star">*</span></label>
                                            <input type="email" class="form-control" id="email" value="<?php echo $admissionInfo->email; ?>"   name="email" placeholder="Email" autocomplete="off" required>
                                      </div>
                                    </div>
                                  
                                     <div class="col-md-4 col-12">
                                         <div class="form-group">
                                            <label for="term_name">Select Term<span class="text-danger required_star">*</span></label>
                                            <select class="form-control"  id="term_name"   name="term_name" required>
                                            <?php if(!empty($admissionInfo->term_name)){ ?>
                                                <option value="<?php echo $admissionInfo->term_name; ?>" selected><b>Selected: <?php echo $admissionInfo->term_name; ?></b></option>
                                            <?php } ?>
                                              <option value="">Select Term</option>
                                                <option value="PU1">PU1</option>
                                                <option value="PU2">PU2</option>
                                             </select>
                                          </div>
                                     </div>

                                     <div class="col-md-4 col-12 ">
                                         <div class="form-group">
                                            <label for="program_name">Select Course<span class="text-danger required_star">*</span></label>
                                            <select class="form-control"  id="selectCourse" name="program_name" required>
                                            <?php if(!empty($admissionInfo->program_name)){ ?>
                                                <option value="<?php echo $admissionInfo->program_name; ?>" selected><b>Selected: <?php echo $admissionInfo->program_name; ?></b></option>
                                            <?php } ?>
                                              <option value="">Select Course</option>
                                              <option  value="Science">Science</option>
                                                <option  value="Commerce">Commerce</option>
                                                <option  value="Arts">Arts</option>
                                             </select>
                                          </div>
                                     </div>
                                     <div class="col-md-4 col-12 streamType">
                                         <div class="form-group">
                                            <label for="stream_name">Select Stream<span class="text-danger required_star">*</span></label>
                                            <select class="form-control"  id="streams" name="stream_name" required>
                                            <?php if(!empty($admissionInfo->stream_name)){ ?>
                                                <option value="<?php echo $admissionInfo->stream_name; ?>" selected><b>Selected: <?php echo $admissionInfo->stream_name; ?></b></option>
                                            <?php } ?>
                                              <option value="">Select Stream</option>
                                             
                                             </select>
                                          </div>
                                     </div>

                                   
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">Mobile Number<span class="text-danger required_star">*</span></label>
                                            <input type="text" class="form-control" id="phone_no"
                                                name="phone_no" placeholder="Phone Number" pattern="[0-9]{10}" value="<?php echo $admissionInfo->phone_no; ?>"
                                                maxlength="10" onkeypress="return isNumberKey(event)"
                                                autocomplete="off" required>
                                        </div>   
                                    </div>

                                    
                                    <div class="col-md-4 col-12">
                                         <div class="form-group">
                                            <label for="term_name">Select Language<span class="text-danger required_star">*</span></label>
                                            <select class="form-control"  id="elective_sub" name="elective_sub" required>
                                            <?php if(!empty($admissionInfo->elective_sub)){ ?>
                                                <option value="<?php echo $admissionInfo->elective_sub; ?>" selected><b>Selected: <?php echo $admissionInfo->elective_sub; ?></b></option>
                                            <?php } ?>
                                              <option value="">Select Language</option>
                                                <option value="Kannada">Kannada</option>
                                                <option value="Hindi">Hindi</option>
                                                <option value="French">French</option>

                                             </select>
                                          </div>
                                     </div>

                                     <div class="col-md-4 col-12">
                                        <div class="form-group">
                                        <label for="hostel_facility">Hostel Facility Required<span class="text-danger required_star">*</span></label>
                                        <select class="form-control"  id="hostel_facility"   name="hostel_facility" required>
                                        <?php if(!empty($admissionInfo->hostel_facility)){ ?>
                                            <option value="<?php echo $admissionInfo->hostel_facility; ?>" selected><b>Selected: <?php echo $admissionInfo->hostel_facility; ?></b></option>
                                        <?php } ?>
                                            <option value="">Select Hostel Facility Required</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                            </select>
                                        </div>
                                     </div>
                                     <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="current_institution_name">Curently Attending which School/College<span class="text-danger required_star">*</span></label>
                                            <input type="text" class="form-control required" id="current_institution_name" value="<?php echo $admissionInfo->current_institution_name; ?>"  name="current_institution_name" placeholder="Curently Attending which School/College" autocomplete="off" required/>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                         <div class="form-group">
                                            <label for="exam_coaching">Do you require coaching for any of the focused competitive exams <span class="text-danger required_star">*</span></label>
                                            <select class="form-control"  id="exam_coaching" name="exam_coaching" required>
                                            <?php if(!empty($admissionInfo->exam_coaching)){ ?>
                                                <option value="<?php echo $admissionInfo->exam_coaching; ?>" selected><b>Selected: <?php echo $admissionInfo->exam_coaching; ?></b></option>
                                            <?php } ?>
                                              <option value="">Select Coaching</option>
                                                <option value="NEET">NEET</option>
                                                <option value="JEE">JEE</option>
                                                <option value="CET">CET</option>
                                                <option value="CA-Foundation/CPT COACHING">CA-Foundation/CPT COACHING</option>
                                                <option value="CS Foundation">CS Foundation</option>
                                                <option value="CSAT">CSAT</option>
                                                <option value="CLAT">CLAT</option>
                                                <option value="Not Applicable">Not Applicable</option>
                                             </select>
                                          </div>
                                     </div>

                                     <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="comment">Any Comments</label>
                                            <textarea type="text" class="form-control required" id="comment"  name="comment" placeholder="Any Comments" autocomplete="off"><?php echo $admissionInfo->comment; ?></textarea>
                                        </div>
                                    </div>


                                    
                                  </div>
                                  
                                  <input type="submit" class="btn btn-success m-2 float-right" value="Update" />
                          </div>
                            
                            
                         </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="<?php echo base_url(); ?>assets/js/staff/student.js" type="text/javascript"></script>
<script type="text/javascript">
function GoBackWithRefresh(event) {
    showLoader();
    if ('referrer' in document) {
        window.location = '<?php echo base_url(); ?>enquiryListing';
        /* OR */
        //location.replace(document.referrer);
    } else {
        window.history.back();
    }
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57) )
        return false;
    return true;
}

jQuery(document).ready(function() {
    $('#selectCourse').prop('required');
  
    // $('.commerceType').hide();
    // $('.artsType').hide();
           //oncahnge stock type
         $("#selectCourse").on('change',function(){

            $('#streams option:not(:first)').remove();
             if(this.value == "Science"){
               
                $('.streamType').show();
                $('#streams').append('<option value="PCMB">PCMB</option><option value="PCMC">PCMC</option><option value="PCMS">PCMS</option><option value="PCME">PCME</option><option value="PCBH">PCBH</option>');
            
            }else if(this.value == "Commerce"){
                $('.streamType').show();
                $('#streams').append('<option value="CEBA">CEBA</option><option value="CSBA">CSBA</option><option value="SEBA">SEBA</option><option value="BEBA">BEBA</option><option value="BSBA">BSBA</option>');

            }else if(this.value == "Arts"){
               
                $('.streamType').show();
                $('#streams').append('<option value="HEPP">HEPP</option>');
            }

         });
});

</script>