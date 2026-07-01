<style>
    .bootstrap-select>.dropdown-toggle.bs-placeholder {
        color: #000;
    }

    .dropdown-menu {
        color: #000;
    }
</style>
<?php
$this->load->helper('form');
$error = $this->session->flashdata('error');
if ($error) {
?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $this->session->flashdata('error'); ?>
    </div>
<?php } ?>
<?php
$success = $this->session->flashdata('success');
if ($success) {
?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php } ?>

<?php
$noMatch = $this->session->flashdata('nomatch');
if ($noMatch) {
?>
    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $this->session->flashdata('nomatch'); ?>
    </div>
<?php } ?>



<!-- Content Header (Page header) -->
<div class="main-content-container px-3 pt-1">
    <div class="row">
        <div class="col-md-12">
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
        </div>
    </div>
    <div class="row p-0">
        <div class="col column_padding_card">
            <div class="card card-small card_heading_title p-0 m-b-1">
                <div class="card-body p-2">
                    <div class="row c-m-b">
                        <div class="col-lg-4 col-sm-4 col-12">
                            <span class="page-title absent_table_title_mobile">
                                <i class="fas fa-pencil-alt"></i> Remarks Info </span>
                            </span>
                        </div>
                        <div class="col-lg-4 col-6 col-sm-4 text-center">
                            <b class="text-dark" style="font-size: 20px;">Total : <?php echo $totalCount; ?></b>
                        </div>
                        <div class="col-lg-4 col-6 col-sm-4">
                            <a class="btn primary_color mobile-btn float-right text-white border_left_radius" value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                            <?php if ($role == ROLE_ADMIN || $role == ROLE_SUPER_ADMIN || $role == ROLE_VICE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_TEACHING_STAFF || $role == ROLE_CLASS_TEACHER) {
                            ?>
                                <button class="btn btn-primary float-right mobile-btn border_right_radius" data-toggle="modal" data-target="#addNewDocModel"><i class="fa fa-plus"></i> Add</button>
                            <?php } ?>
                        </div>
                        <div class="col-lg-4">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row form-employee">
        <div class="col-12 column_padding_card">
            <div class="card card-small c-border p-2">
                <div class="table-responsive-sm">
                    <table class="table table-hover table-bordered mb-2">
                        <tr class="row_filter">
                            <form action="<?php echo base_url() ?>observationListing" method="POST" id="byFilterMethod">
                                <th>
                                    <div class="position-relative mb-0">
                                        <input type="text" value="<?php echo $date; ?>" name="date" id="date" class="form-control input-sm datepicker" placeholder="By Date" autocomplete="off">
                                    </div>
                                </th>
                                <th>
                                    <div class="position-relative mb-0">
                                        <input type="text" value="<?php echo $remarks; ?>" name="remarks" id="remarks" class="form-control input-sm" placeholder="By remarks" autocomplete="off">
                                    </div>
                                </th>
                                <!-- <th>
                                    <div class="position-relative mb-0">
                                        <select class="form-control input-sm" id="observe_type" name="observe_type" data-live-search="true">
                                            <?php if (!empty($observe_type)) { ?>
                                                <option value="<?php echo $observe_type; ?>">Selected: <?php echo $observeName; ?></option>
                                            <?php } ?>
                                            <option value="">Select Type</option>
                                            <?php if (!empty($getObservationId)) {
                                                foreach ($getObservationId as $observe) { ?>
                                                    <option value="<?php echo $observe->row_id; ?>"><?php echo $observe->observation_name; ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                        <input type="text" value="" name="exam_type" id="exam_type" class="form-control input-sm" placeholder="By Exam Type" autocomplete="off">
                                    </div>
                                </th> -->
                                <th>
                                    <div class="position-relative mb-0">
                                        <input type="hidden" id="filter_id" name="filter_id" value="" />
                                        <select class="form-control input-sm selectpicker" id="student_rowId" name="student_rowId" data-live-search="true">
                                            <?php if (!empty($student_rowId)) { ?>
                                                <option value="<?php echo $student_rowId; ?>">Selected: <?php echo $observeStdName; ?></option>
                                            <?php } ?>
                                            <option value="">Select Student</option>
                                            <?php if (!empty($getStudentInfo)) {
                                                foreach ($getStudentInfo as $std) { ?>
                                                    <option value="<?php echo $std->row_id; ?>"><?php echo $std->student_name; ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </th>
                                <th>
                                    <div class="position-relative mb-0">
                                        <select class="form-control " id="term_name" name="term_name" autocomplete="off">
                                            <?php if (!empty($term_name)) { ?>
                                                <option value="<?php echo $term_name; ?>">
                                                    Selected: <?php echo strtoupper($term_name); ?>
                                                <?php } ?>
                                                </option>
                                               <option value="">Search Term</option>
                                                <option value="I PUC">I PUC</option>
                                                <option value="II PUC">II PUC</option>
                                               
                                        </select>
                                    </div>
                                </th>
                                <th>
                                    <div class="position-relative mb-0">
                                            <select class="form-control" name="by_stream" id="by_stream">
                                                <?php if(!empty($by_stream)){ ?>
                                                    <option value="<?php echo $by_stream; ?>" selected><b>Selected: <?php echo $by_stream; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Stream</option>
                                                <?php if(!empty($streamInfo)){
                                                    foreach($streamInfo as $stream){ ?>
                                                <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </th>
                                <!-- <th>
                                    <div class="position-relative mb-0">
                                        <select id="section_name" name="section_name" class="form-control" placeholder="By Section">
                                            <?php if (!empty($section_name)) { ?>
                                                <option value="<?php echo $section_name; ?>" selected>Selected:<?php echo $section_name; ?></option>
                                            <?php } ?>
                                            <option value="">By Section</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="E">E</option>
                                            <option value="F">F</option>
                                            <option value="G">G</option>
                                        </select>
                                    </div>
                                </th> -->
                                <th>
                                    <div class="position-relative mb-0">
                                        <input type="text" value="<?php echo $description; ?>" name="description" id="description" class="form-control input-sm" placeholder="By Description" autocomplete="off">
                                    </div>
                                </th>
                                <th class="text-center"><button type="submit" class="btn btn-success btn-md btn-block"><i class="fa fa-filter"></i> Filter</button>
                                </th>
                            </form>
                        </tr>

                        <tr class="table_row_background text-dark text-center">
                            <th>Date</th>
                            <th>Remarks</th>
                            <th>Student name</th>
                            <th>Term</th>
                            <th>Stream</th>
                            <!-- <th>Section</th> -->
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                        <?php if (!empty($observationInfo)) {
                            foreach ($observationInfo as $record) { ?>
                                <tr>
                                    <td width="150" class="text-center"><?php if ($record->date == '1970-01-01' || $record->exam_date == '0000-00-00') {
                                                                            echo "";
                                                                        } else {
                                                                            echo date('d-m-Y', strtotime($record->date));
                                                                        } ?></td>
                                    <td><?php echo $record->remarks; ?></td>
                                    <td width="300"><?php echo strtoupper($record->student_name); ?></td>
                                    <td><?php echo $record->term_name; ?></td>
                                    <td><?php echo $record->stream_name; ?></td>
                                    <!-- <td><?php echo $record->section_name; ?></td> -->
                                    <td><?php echo $record->description; ?></td>

                                    <td width="150" class="text-center">
                                        <?php if (!empty($record->file_path)) { ?>
                                            <a href="<?php echo $record->file_path; ?>" target="_blank" class="btn btn-xs btn-primary"><i class="fa fa-file"></i></a>
                                        <?php  } ?>
                                        <!-- <a href="#" class="btn btn-xs btn-success px-2 py-1" title="Exam Info" data-placement="left" data-toggle="popover" data-trigger="focus" data-content="<b>Time : <?php echo $record->time; ?> <br>"><i class="fa fa-info"></i></a> -->
                                        <?php //if ($role == ROLE_ADMIN || $role == ROLE_SUPER_ADMIN || $role == ROLE_VICE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_TEACHING_STAFF || $this->role == ROLE_CLASS_TEACHER) { ?>
                                        <?php //if(isset($accessInfo) && $accessInfo->can_edit==1){ ?>
                                            <a class="btn btn-xs btn-info" href="<?php echo base_url(); ?>editObservation/<?php echo $record->row_id; ?>" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                        <?php //} ?>
                                        <?php //if(isset($accessInfo) && $accessInfo->can_delete==1){ ?>
                                            <a class="btn btn-xs btn-danger deleteObservation px-2 py-1" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                        <?php // } ?>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr class="card_heading_title text-dark">
                                <td class="text-center" colspan="10">
                                    Record Not Found!.
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
                <div class="row">
                    <div class="col-12">
                        <span class="float-right"><?php echo $this->pagination->create_links(); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- The Modal -->
<div class="modal" id="addNewDocModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Observation Details</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2 m-1">
                <form action="<?php echo base_url() ?>addObservation" method="POST" role="form" enctype="multipart/form-data">
                    <div class="text-center" id="alertMsg"></div>

                    <div class="row">
                        <div class="col-lg-6">
                            <label>Date</label>
                            <div class="form-group">
                                <input type="text" value="<?php echo date('d-m-Y') ?>" name="date" id="date" class="form-control input-sm observe_date" placeholder="Date" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Student Name</label>
                                <select class="form-control input-sm selectpicker" name="student_rowId" data-live-search="true" required>
                                    <option value="">Select Student</option>
                                    <?php if (!empty($getStudentInfo)) {
                                        foreach ($getStudentInfo as $stdinfo) { ?>
                                            <option value="<?php echo $stdinfo->row_id; ?>"><?php echo $stdinfo->sat_number . ' - ' . strtoupper($stdinfo->student_name) . ' - ' . $stdinfo->term_name . ' - ' . $stdinfo->stream_name?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Remarks Type</label>
                                <textarea name="remarks" id="remarks" class="form-control" placeholder="Enter Remarks" autocomplete="off" required></textarea>
                            </div>
                        </div>


                        <div class="col-lg-6">
                            <div class="form-group">

                                <img src="<?php echo base_url(); ?>assets/dist/img/file_upload.png" class="avatar rounded-circle img-thumbnail" width="130" height="130" src="#" id="uploadedImage" name="userfile" width="130" height="130" alt="File">
                                <div class="observeFile">
                                    <div class="file btn btn-sm">
                                        <input type="file" class="form-control-sm" id="oFile" name="userfile" accept="*.jpg,*.png,*.jpeg,,*.pdf">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" id="description" class="form-control" placeholder="Enter Description" autocomplete="off" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-2 pb-0">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button id="staffInfoDownload" type="submit" class="btn btn-md btn-success"> SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery(document).on("click", ".deleteObservation", function() {
            var row_id = $(this).data("row_id"),
                hitURL = baseURL + "deleteObservation",
                currentRow = $(this);
            showConfirmationAlert('Are you sure delete this Remarks?')
                .then(confirmation => {
                    if (confirmation) {
                        jQuery.ajax({
                            type: "POST",
                            dataType: "json",
                            url: hitURL,
                            data: {
                                row_id: row_id
                            }
                        }).done(function(data) {
                            currentRow.parents('tr').remove();
                            if (data.status = true) {
                                showSuccessAlert("Remarks Details successfully Deleted");
                                window.location.reload();
                            } else if (data.status = false) {
                                showErrorAlert("Failed to delete Remarks Details");
                            } else {
                                showWarningAlert("Access denied..!");
                            }
                        });
                    }
                });
        });
        $('#student_rowId').change(function() {
            student_id = $(this).val();
            $('#filter_id').val(student_id);
        });

        jQuery('ul.pagination li a').click(function(e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#byFilterMethod").attr("action", baseURL + "observationListing/" + value);
            jQuery("#byFilterMethod").submit();
        });

        jQuery('.datepicker, .dateSearch, .observe_date').datepicker({
            autoclose: true,
            orientation: "bottom",
            format: "dd-mm-yyyy",
            startDate: "01-11-2021"

        });

        $('[data-toggle="popover"]').popover({
            "container": "body",
            "trigger": "focus",
            "html": true
        });
        $('[data-toggle="popover"]').mouseenter(function() {
            $(this).trigger('focus');
        });

        

    });
    $('.start_time').datetimepicker({
        format: 'hh:mm A',
        icons: {
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down"
        },
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
    $("#oFile").change(function() {
        readURL(this);
    });

    



    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>