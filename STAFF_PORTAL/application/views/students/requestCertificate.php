<style>
    .form-control {
        border: 1px solid #000000 !important;
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
<?php } ?>
<div class="row column_padding_card">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container px-3 pt-1 overall_content">
    <div class="content-wrapper">
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class=" col-12 col-md-6 box-tools">
                                <span class="page-title">
                                    <i class="material-icons">group</i> Issued Certificate Details
                                </span>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12 text-black" style="font-size: 20px;">
                                Total: <?php echo $RecordsCount; ?>

                                <a onclick="window.history.back();" class="btn primary_color mobile-btn float-right text-white border_left_radius" value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                <div class="dropdown mobile-btn float-right">
                                    <?php if($accessInfo->super_access =='1'){ ?>
                                    <button type="button" class="btn btn-danger dropdown-toggle border_right_radius" data-toggle="dropdown">
                                        Action
                                    </button>
                                    <div class="dropdown-menu p-0">
                                        <a class="dropdown-item" data-toggle="modal" data-target="#myModal" href="#"><i class="fa fa-plus"></i> Add</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <!-- <a class="dropdown-item " id="print_certificate" href="#"><i class="fa fa-print"></i> Print Certificate</a>
                                        <div class="dropdown-divider m-0"></div> -->
                                        <a class="dropdown-item" href="#" id="print_certificate" class="btn btn-md"><i class="material-icons text-dark">description</i> Print Certificate</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <!-- <a class="dropdown-item " id="request_form" href="#"><i class="fa fa-print"></i> Print Request Form</a>
                                        <div class="dropdown-divider m-0"></div> -->
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 ">
            <div class="col-12">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2 table-responsive">
                        <table style="width:100%" class="display table  table-bordered table-striped table-hover mb-0">
                            <thead>
                                <tr class="table_row_backgrond text-center">
                                    <th><input type="checkbox" id="selectAll" /></th>
                                    <th>Register No.</th>
                                    <th>Student Name</th>
                                    <th>Subject</th>
                                    <th>Certificate Name</th>
                                    <th>Message</th>
                                    <th>Filter</th>
                                </tr>
                                <tr class="row_filter">
                                    <form action="<?php echo base_url() ?>getCertificate" method="POST" id="byFilterMethod">
                                        <th></th>
                                        <th style="padding: 1px;">
                                            <input type="text" name="enrolment_no" id="enrolment_no" value="<?php echo $enrolment_no ?>" class="form-control" placeholder="Register No." autocomplete="off" />
                                        </th>
                                        <th style="padding: 1px;">
                                            <input type="text" name="student_name" id="student_name" value="<?php echo $student_name ?>" class="form-control" placeholder="By Name" autocomplete="off" />

                                        </th>
                                        <th style="padding: 1px;">
                                            <input type="text" name="request_sub" id="request_sub" value="<?php echo $request_sub ?>" class="form-control" placeholder="Search Subject" autocomplete="off" />
                                        </th>
                                        <th style="padding: 1px;">
                                            <select id="request_certificate" name="request_certificate" class="form-control is-valid" placeholder="By Certificate Name">
                                                <?php if (!empty($request_certificate)) { ?>
                                                    <option value="<?php echo $request_certificate; ?>" selected>Selected:<?php echo $certificateData->certificate_name; ?></option>
                                                <?php } ?>
                                                <option value="">Select Certificate</option>
                                                <?php if (!empty($certificateInfo)) {
                                                    foreach ($certificateInfo as $student) { ?>
                                                        <option value="<?php echo $student->row_id; ?>"><?php echo $student->certificate_name; ?></option>
                                                <?php }
                                                } ?>
                                            </select>

                                        </th>

                                        <th style="padding: 1px;"> <input type="text" name="request_issue" id="request_issue" value="<?php echo $request_issue ?>" class="form-control input-sm" placeholder="Search Message" autocomplete="off" />
                                        </th>
                                        <th style="padding: 1px;" class="text-center"><button type="submit" class="btn btn-success btn-md btn-block"><i class="fa fa-filter"></i>
                                                Filter</button></th>
                                    </form>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($studentRecords)) {
                                    foreach ($studentRecords as $record) {
                                ?> <tr>
                                            <th class="text-center"><input type="checkbox" class="singleSelect" value="<?php echo $record->row_id; ?>" /></th>
                                            <th class="text-center"><?php echo $record->register_no; ?></th>
                                            <th class="text-left"><?php echo strtoupper($record->student_name); ?></th>
                                            <th class="text-left"><?php echo $record->request_sub ?></th>
                                            <th class="text-left"><?php echo $record->certificate_name ?></th>
                                            <th class="text-left"><?php echo $record->issue; ?></th>
                                            <th class="text-center">
                                                <!-- <a class="btn btn-xs btn-info" target="_blank" href="<?php echo base_url(); ?>viewStudentReceipt/<?php echo $record->row_id; ?>"
                                    title="view fee receipt"><i class="fas fa-file"></i></a> -->
                                                <!--  <a class="btn btn-xs btn-info" href="<?php echo base_url(); ?>editStudentElection/<?php echo $record->row_id; ?>"
                                            title="Edit Student Election"><i class="fas fa-pencil-alt"></i></a> -->
                                                <a class="btn btn-xs btn-danger deleteStudentRequestDetails" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                            </th>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <th colspan="7" class="text-center">Record not found</th>
                                    </tr>
                                <?php } ?>

                            </tbody>
                            <tfoot>
                                <tr class="table_row_backgrond text-center">
                                    <th><input type="checkbox" id="selectAll" /></th>
                                    <th>Register No.</th>
                                    <th>Student Name</th>
                                    <th>Subject</th>
                                    <th>Certificate Name</th>
                                    <th>Message</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                    <div class="card-footer text-center p-1">
                        <span class="float-right"><?php echo $this->pagination->create_links(); ?></span>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>


<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Add Issue Details</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form method="POST" action="<?php echo base_url() . 'addStudentRequestForm' ?>">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="student_row_id">Register No.</label>
                                <select class="form-control selectpicker" id="student_row_id" name="student_row_id" data-live-search="true" required>
                                    <option value="">Select Student ID</option>
                                    <?php if (!empty($studentInfo)) {
                                        foreach ($studentInfo as $std) { ?>
                                            <option value="<?php echo $std->row_id; ?>"><?php echo $std->register_no. ' - ' . strtoupper($std->student_name); ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="request_certificate">Certificate Name</label>
                                <select class="form-control" id="certificate_name" name="request_certificate" required>
                                    <option value="">Select Certificate</option>
                                    <?php if (!empty($certificateInfo)) {
                                        foreach ($certificateInfo as $student) { ?>
                                            <option value="<?php echo $student->row_id; ?>"><?php echo $student->certificate_name; ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="request_sub">Issue Subject</label>
                                <input name="request_sub" type="text" class="form-control" id="request_sub" placeholder="Enter subject" required autocomplete="off">
                            </div>
                        </div>

                        <div class="col-lg-12 col-12">
                            <div class="form-group">
                                <label for="request_issue">Enter the reason</label><br>
                                <textarea class="w-100" id="request_issue" name="request_issue" rows="3" required autocomplete="off"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="college_from">Studied Classes From</label>
                                <input name="college_from" type="text" class="form-control" id="college_from" placeholder="Enter Studied Classes from" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="college_to">Studied Classes To</label>
                                <input name="college_to" type="text" class="form-control" id="college_to" placeholder="Enter Studied Classes to" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="classes_from">Duration From</label>
                                <input name="classes_from" type="text" class="form-control" id="classes_from" placeholder="Enter Duration from" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="classes_to">Duration To</label>
                                <input name="classes_to" type="text" class="form-control" id="classes_to" placeholder="Enter Duration to" autocomplete="off">
                            </div>
                        </div>
                        <!-- <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="progress">Student Progress</label>
                                <input name="progress" type="text" class="form-control" id="progress" placeholder="Enter student progress" autocomplete="off">
                            </div>
                        </div> -->
                    </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer" style="padding:5px;">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/common.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        // $(".reason_unqualified").hide();

        jQuery('ul.pagination li a').click(function(e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#byFilterMethod").attr("action", baseURL + "electionDetails/" + value);
            jQuery("#byFilterMethod").submit();
        });

        jQuery('.electionDate,.dateBy').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",

        })
        //checkbox select
        $('#selectAll').click(function() {
            if ($('#selectAll').is(':checked')) {
                $('.singleSelect').prop('checked', true);
            } else {
                $('.singleSelect').prop('chcertificate_nameecked', false);
            }
        });



        $('#print_certificate').click(function() {
            var std = [];
            var certificate_names = [];
            if ($('.singleSelect:checkbox:checked').length == 0) {
                alert("Select atleast one Student to print certificate!");
                return;
            }
            $('.singleSelect:checked').each(function(i) {
                std.push($(this).val());
            });
            $.ajax({
                url: '<?php echo base_url(); ?>/checkCertificateName',
                type: 'POST',
                data: {
                    student_id: JSON.stringify(std),
                },
                
                success: function(data) {
                    var certificateCount = data.certificateName.length;
                    var studentid = [];
                    var i = 0;
                    for (i = 0; i < certificateCount; i++) {
                        certificate_names[i] = data.certificateName[i].certificate_name;
                        $('.singleSelect:checked').each(function(i) {
                            studentid.push($(this).val());
                        });
                        if (certificate_names[i] == 'STUDY CERTIFICATE') {
                            var students = JSON.stringify(studentid);
                            window.open('<?php echo base_url(); ?>generateStudyCertificate?student_id=' + btoa(students));
                        }
                        if (certificate_names[i] == 'CONDUCT CERTIFICATE') {
                            var students = JSON.stringify(studentid);
                            window.open('<?php echo base_url(); ?>generateConductCertificate?student_id=' + btoa(students));

                        }
                    }

                },
                error: function(result) {
                    alert("Retry Again! Something Went Wrong");
                },
                fail: (function(status) {
                    alert("Retry Again! Something Went Wrong");
                }),
            });


        });
           
    // $('#print_certificate').click(function(){
    //     var students = [];
    //     if ($('.singleSelect:checkbox:checked').length == 0) {
    //         alert("Select atleast one Student to print certificate"); 
    //         return;
    //     }
    //     $('.singleSelect:checked').each(function(i){
    //         students.push($(this).val());
    //     });
    //     var students = JSON.stringify(students);
    //     window.open('<?php echo base_url(); ?>generateStudyCertificate?student_id='+btoa(students));
    // });


        $(".conductInfo").hide();
        $("#certificate_name").change(function() {
            if (this.value == 2) {
                $(".conductInfo").show();
            } else {
                $(".conductInfo").hide();
            }
        });
        //request form
        // $('#request_form').click(function() {
        //     var students = [];
        //     if ($('.singleSelect:checkbox:checked').length == 0) {
        //         alert("Select atleast one Student to print request form!");
        //         return;
        //     } else{
        //         $('.singleSelect:checked').each(function(i) {
        //             students.push($(this).val());
        //         });
        //         var students = JSON.stringify(students);
        //         window.open('<?php echo base_url(); ?>getRequestForm?student_id=' + btoa(students));
        //     }


        // });
    });
</script>