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

<div class="main-content-container px-3 pt-1">
    <div class="row column_padding_card">
        <div class="col-md-12">
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
        </div>
    </div>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="row p-0 column_padding_card">
                <div class="col column_padding_card">
                    <div class="card card-small p-0 card_heading_title">
                        <div class="card-body p-2 ml-2">
                            <span class="page-title absent_table_title_mobile">
                                <i class="material-icons">poll</i> Edit Candidate Info
                            </span>

                           <a href="#" onclick="GoBackWithRefresh();return false;" class="btn text-white primary_color btn-bck pull-right mobile-bck "><i class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Back </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- form start -->
        <div class="row form-contents column_padding_card">
            <div class="col-lg-12 col-12 column_padding_card">
                <form role="form" id="editStudentElection" action="<?php echo base_url() ?>updateStudentElection" method="post" enctype="multipart/form-data">
                    <!-- Default Light Table -->
                    <input type="hidden" value="<?php echo $electionInfo->row_id; ?>" name="row_id" />
                    <div class="card card-header column_padding_card">

                        <div class="row p-0">
                            <div class="col-lg-3 text-center">
                                <div class="text-center">
                                <label for="fname">Profile Image</label>
                            </div>
                                <div class="profile-img">
                                <?php
                                    $profileImg = $electionInfo->photo_url;
                                        if(!empty($profileImg)){ ?>
                                    <img src="<?php echo base_url(); ?><?php echo $profileImg; ?>" class="img-thumbnail"
                                     alt="Profile Image" id="uploadedImage" name="userfile">
                                    <?php } else { ?>
                                    <img src="<?php echo base_url(); ?>assets/dist/img/user.png" class="img-thumbnail"
                                     id="uploadedImage" name="userfile" alt="Profile default">
                                    <?php } ?>
                                <div class="file btn btn-sm btn-primary">
                                    Change Photo
                                    <input type="file" class="form-control-sm" id="vImg" name="userfile">
                                </div>
                            </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="application_no">Student ID</label>
                                    <select class="form-control selectpicker" data-live-search="true" id="application_no" name="application_no" required>
                                       <?php if(!empty($electionInfo->application_no)){ ?>
                                        <option value="<?php echo $electionInfo->application_no; ?>">Selected:
                                            <?php echo $electionInfo->application_no; ?></option>
                                        <?php } ?>
                                        <?php if(!empty($studentInfo)){
                                         foreach($studentInfo as $std){ ?>
                                        <option value="<?php echo $std->student_id; ?>"><?php echo $std->student_id.' - '.$std->student_name; ?>
                                        </option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="post_name">Post Name</label>
                                     <select class="form-control"  id="post_name" name="post_name" >
                                      <?php if(!empty($electionInfo->post_name)){ ?>
                                        <option value="<?php echo $electionInfo->post_id; ?>" selected>Selected: <?php echo $electionInfo->post_name; ?></option>
                                        <?php } ?>
                                        <option value="">Select Post Name</option>
                                        <?php if(!empty($postInfo)){
                                         foreach ($postInfo as $post){ ?>
                                       <option value="<?php echo $post->post_id; ?>"><?php echo $post->post_name; ?></option>
                                        <?php } 
                                    } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="program_name">Course</label>
                                        <select class="form-control"  id="program_name" name="program_name" required>
                                            <?php if(!empty($electionInfo->program_name)){ ?>
                                                <option value="<?php echo $electionInfo->program_name; ?>" selected>Selected: <?php echo $electionInfo->program_name; ?></option>
                                            <?php } ?>
                                            <option value="">Select Course</option>
                                            <option value="ALL">ALL</option>
                                            <option value="SCIENCE">SCIENCE</option>
                                            <option value="COMMERCE">COMMERCE</option>
                                            <option value="ARTS">ARTS</option>
                                        </select> 
                                    
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="election_date">Election Date</label>
                                    <input type="text" class="form-control electionDate" id="election_date"  
                                    name="election_date" value="<?php echo date('d-m-Y',strtotime($electionInfo->election_date)); ?>" p
                                    laceholder="Election Date" autocomplete="off">
                                </div>
                            </div>
                        </div>
                       </div>
                        </div>
                         <div class="row">
                            <div class="col-lg-12 col-12">
                                <button style="float:right" type="submit" class="btn btn-success">Update</button>
                            </div>
                        </div>

                     </div>

                    </div>
                </form> <!-- form end -->
            </div>
        </div>
        <!-- End Default Light Table -->
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/staff.js" charset="utf-8"></script>
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

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;
    return true;
}

jQuery(document).ready(function() {


    // $('select').selectpicker();
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

      jQuery('.electionDate,.dateBy').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",

    })



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