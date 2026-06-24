<style>
.select2-container .select2-selection--single {
    height: 38px !important;
    width: 360px !important;
}


.form-control {
    border: 1px solid #000000 !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow b {
    margin-top: 3px !important;
    color: black !important;

}

@media screen and (max-width: 480px) {
    .select2-container--default .select2-selection--single .select2-selection__arrow {

        margin-right: 20px !important;
    }

    .select2-container .select2-selection--single {
        width: 270px !important;
    }
}
.switch {
  position: relative;
  display: inline-block;
  width: 40px;
  height: 20px;
}
.switch input {display:none;}
.slider {
  position: absolute;
  cursor: pointer;
  top: 0; left: 0; right: 0; bottom: 0;
  background-color: #ccc;
  transition: .4s;
  border-radius: 20px;
}
.slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  left: 2px;
  bottom: 2px;
  background-color: white;
  transition: .4s;
  border-radius: 50%;
}
input:checked + .slider {
  background-color: #28a745;
}
input:checked + .slider:before {
  transform: translateX(20px);
}
/* Tooltip styles */
.switch .slider::after {
  content: attr(data-tooltip);
  position: absolute;
  left: 50%;
  bottom: 125%;
  transform: translateX(-50%);
  background: #333;
  color: #fff;
  padding: 2px 8px;
  border-radius: 4px;
  font-size: 12px;
  white-space: nowrap;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.2s;
  z-index: 10;
}
.switch:hover .slider::after {
  opacity: 1;
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
                            <div class="col-lg-6 col-12 col-md-7 box-tools">
                                <span class="page-title">
                                    <i class="material-icons">book</i> Stream & Section Management
                                </span>
                            </div>
                            <div class="col-lg-6 col-md-5 col-12">
                                <a onclick="showLoader();window.history.back();" class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                    
                                <?php //if($role == ROLE_ADMIN || $role == ROLE_OFFICE || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN) { ?>
                                <?php if($accessInfo->super_access == 1) { ?>
                                    <!-- <a class="btn btn-success btn-sm" id="enableFeedbackBtn" href="#">
                                        <i class="fa fa-check-circle"></i> Feedback Enable</a>
                                    <a class="btn btn-danger btn-sm mx-2" id="disableFeedbackBtn" href="#">
                                        <i class="fa fa-ban"></i> Feedback Disable</a> -->
                                <a class="btn btn-primary mobile-btn float-right border_right_radius"
                                    href="#" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>
                                    Add New</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2 text-center table-responsive">
                        <table class="table table-bordered text-dark mb-0">
                            <thead class="text-center">
                            <form action="<?php echo base_url(); ?>classStreamDetails" method="POST" id="byFilterMethod">
                                <tr> 
                                    <td></td>
                                <td class="p-0">
                                    <select class="form-control" id="exampleFormControlSelect1" name="by_term" id="by_term">
                                    <?php if(!empty($searchTerm)){ ?>
                                        <option value="<?php echo $searchTerm ?>" selected><b>Selected: <?php echo $searchTerm ?></b></option>
                                    <?php } ?>
                                    <option value="">By Term Name</option>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                    </select>
                                </td>
                                <td class="p-0">
                                    <div class="form-group m-0">
                                    <select class="form-control" id="exampleFormControlSelect1" name="by_stream" id="by_stream">
                                        <?php if(!empty($searchStream)){ ?>
                                            <option value="<?php echo $searchStream ?>" selected><b>Selected: <?php echo $searchStream ?></b></option>
                                        <?php } ?>
                                        <option value="">By Stream Name</option>
                                        <?php if(!empty($streamInfo)){
                                            foreach($streamInfo as $stream){ ?>
                                            <option value="<?php echo $stream->stream_name ?>">
                                                <?php echo $stream->stream_name ?>
                                            </option>
                                        <?php }  } ?>
                                        <option value="5">
                                            <?php echo "PCME" ?>
                                        </option>
                                    </select>
                                    </select>
                                    </div>
                                </td>
                                <td class="p-0">
                                    <div class="form-group m-0">
                                    <select class="form-control" id="exampleFormControlSelect1" name="by_section" id="by_section">
                                        <?php if(!empty($searchSection)){ ?>
                                            <option value="<?php echo $searchSection ?>" selected><b>Selected: <?php echo $searchSection ?></b></option>
                                        <?php } ?>
                                        <option value="">By Section</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <!-- <option value="E">E</option>
                                        <option value="F">F</option>
                                        <option value="G">G</option>
                                        <option value="H">H</option>
                                        <option value="I">I</option>
                                        <option value="J">J</option>
                                        <option value="K">K</option>
                                        <option value="L">L</option>
                                        <option value="M">M</option>
                                        <option value="ALL">ALL (No Section)</option> -->
                                    </select>
                                    </div>
                                </td>
                                <!-- <td>
                                    <select class="form-control" id="by_class_type" name="by_class_type" readonly>
                                        <?php //if(!empty($by_class_type)){ ?>
                                            <option value="<?php //echo $by_class_type; ?>"><?php //echo $by_class_type; ?></option>
                                        <?php //} ?>
                                        <option value="">Select Class Type</option> -->
                                        <!-- <option value="Aided">Aided</option>
                                        <option value="Unaided" selected>Unaided</option> -->
                                    <!-- </select> -->
                                <!-- </td>  -->
                                <td class="p-0">
                                <div class="form-group m-0">
                                    <select class="form-control" data-live-search="true" id="by_class_teacher" name="by_class_teacher">
                                        <?php if(!empty($by_class_teacher)){ ?>
                                            <option value="<?php echo $by_class_teacher; ?>"><?php echo $by_class_teacher; ?></option>
                                        <?php } ?>
                                        <option value="">Select Class Teacher</option>
                                        <?php if(!empty($staffInfo)){
                                            foreach($staffInfo as $staff){  ?>
                                                <option value="<?php echo $staff->staff_id; ?>"><?php echo $staff->name; ?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                                </td>
                                <td class="p-0">    
                                    <button type="submit"class="btn btn-success btn-block mobile-width"> Search</button>
                                </td>
                                </tr>
                            </form>
                            <tr class="table_row_background">
                                <th><input type="checkbox" id="selectAll"/></th>
                                <th>Term</th>
                                <th>Stream</th>
                                <th>Section</th>
                                <!-- <th>Class Type</th> -->
                                <th>Class Teacher</th>
                                <th>Action</th>
                            </tr>
                            <?php if(!empty($sectionInfo)){
                                foreach($sectionInfo as $section){ ?>
                            <tr class="text-dark">
                                 <td><input type="checkbox" class="sectionCheckbox" name="selected_sections[]" value="<?php echo $section->row_id; ?>"/></td>
                                <td><?php echo $section->term_name; ?></td>
                                <td><?php echo $section->stream_name; ?></td>
                                <td class="text-center"><?php echo $section->section_name; ?></td>
                                <!-- <td><?php //echo $section->class_type; ?></td> -->
                                <td><?php echo $section->name; ?></td>
                                <td class="text-center">  
                                    <?php //if($accessInfo->super_access == 1) { ?>
                                      <!-- <label class="switch" style="vertical-align:middle; margin-right:8px;">
                                        <input type="checkbox" class="feedbackToggle" data-row_id="<?php //echo $section->row_id; ?>" <?php //echo ($section->feedback_status == 1) ? 'checked' : ''; ?>>
                                        <span class="slider round" data-tooltip="<?php //echo ($section->feedback_status == 1) ? 'Disable Feedback' : 'Enable Feedback'; ?>"></span>
                                    </label> -->
                                <?php if($accessInfo->can_edit == '1'){ ?>
                                <a class="btn btn-xs btn-info" target="_blank" href="<?php echo base_url(); ?>editClassSection/<?php log_message('debug','sectin row id--->'.print_r($section->row_id,true)); echo $section->row_id; ?>" title="Edit Class & Batch"><i
                                    class="fas fa-pencil-alt"></i></a>  
                                <?php } ?>    
                                <?php if($accessInfo->can_delete == '1'){ ?>
                                <a class="btn btn-xs btn-danger deleteSection" href="#" data-row_id="<?php echo $section->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                <?php } ?>
                                </td>
                            </tr>
                            <?php } }else{ ?>
                                <tr class="text-dark">
                                <td colspan="6" style="background-color: #e3cfff;">Stream & Section Not Found</td>
                                </tr>
                            <?php } ?>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Section</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body p-2">
                    <form role="form" action="<?php echo base_url() ?>addSection" method="post" id="modelForm">
                        <div class="row form-contents">
                            <div class="col-6 pr-1">
                                <div class="form-group">
                                    <select class="form-control" id="term_name" name="term_name" data-live-search="true" autocomplete="off" required>
                                        <option value="">Select Term</option>
                                        <option value="I PUC">I PUC</option>
                                        <option value="II PUC">II PUC</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 pl-1">
                                <div class="form-group">
                                    <select name="stream" id="stream" class="form-control" data-live-search="true" autocomplete="off" required>
                                    <option value="">Select Stream</option>
                                    <?php if(!empty($streamInfo)){
                                        foreach($streamInfo as $stream){ ?>
                                        <option value="<?php echo $stream->row_id ?>">
                                            <?php echo $stream->stream_name ?>
                                        </option>

                                      
                                    <?php }  } ?>
                                    <option value="5">
                                            <?php echo "PCME" ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 pr-1">
                                <div class="form-group">
                                    <select class="form-control" id="section" name="section" data-live-search="true" autocomplete="off" required>
                                        <option value="">Select Section</option>
                                        <option value="A">A</option>
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
                                        <option value="S">S</option>
                                        <option value="ALL">ALL (No Section)</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-6 pl-1"> 
                                <select class="form-control required selectpicker" id="class_type" name="class_type" readonly>
                                    <option value="Unaided">Unaided</option>
                                    <option value="Aided">Aided</option>
                                    <option value="Unaided">Unaided</option>
                                </select>
                            </div> -->
                            <div class="col-6 pl-1">
                                <select class="form-control required selectpicker" data-live-search="true" id="class_teacher" name="class_teacher">
                                    <option value="">Select Class Teacher</option>
                                    <?php if(!empty($staffInfo)){
                                        foreach($staffInfo as $staff){  ?>
                                            <option value="<?php echo $staff->staff_id; ?>"><?php echo $staff->name; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success font-weight-bold" value="Add" form="modelForm"/>
                    <button type="button" class="btn btn-danger font-weight-bold" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

    $('#item-list thead tr').clone(true).appendTo('#item-list thead');
    $('#item-list thead tr:eq(1) th').each(function(i) {
        var title = $(this).text();
        if (title == 'Date') {
            var newClassupdate = 'disabled';
        } else {
            var newClassupdate = '';
        }
        $(this).html(
            '<div class="form-group position-relative mb-0 mt-0" style="margin-top: -5px !important; margin-bottom: -5px !important;" ><input style="border: 1px solid #75787b !important;" type="text" class="form-control input-sm" placeholder="Search ' +
            title + '" ' +
            newClassupdate + ' /> </div>');

        $('input', this).on('keyup change', function() {
            if (table.column(i).search() !== this.value) {
                table
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });


    var table = $('#item-list').DataTable({
        columnDefs: [
            // { className: "my_class", targets: "_all" },
            {
                className: "text-left",
                targets: 1,

            }
        ],
        lengthMenu: [
            [200, 150, 100, 50, 20, 10],
            [200, 150, 100, 50, 20, 10]
        ],
        processing: true,
        orderCellsTop: true,
        fixedHeader: true,
        responsive: true,
        language: {
            "info": "Showing _START_ to _END_ of _TOTAL_ Stream",
            "infoFiltered": "(filtered from _MAX_ total Stream)",
            "search": "",
            searchPlaceholder: "Search Class And Stream",
            "lengthMenu": "Show _MENU_ Stream",
            "infoEmpty": "Showing 0 to 0 of 0 Stream",
            //processing: '<img src="'+baseURL+'assets/images/loader.gif" width="150"  alt="loader">'
        },

        "ajax": {
            url: '<?php echo base_url(); ?>/ get_stream',
            type: 'POST',

            // dataType: 'json',
        },

    });



    jQuery('.datepicker, .dateSearch').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });
           // Select all checkboxes

    $("#selectAll").on("click", function() {

        $(".sectionCheckbox").prop("checked", $(this).prop("checked"));

    });



    // Enable feedback button click handler

    $("#enableFeedbackBtn").on("click", function() {

        if($(".sectionCheckbox:checked").length > 0) {

            if(!confirm("Are you sure you want to enable feedback for the selected sections?")) return false;

            var form = $("<form>", {

                "method": "post",

                "action": baseURL + "enableFeedback"

            });

            $(".sectionCheckbox:checked").each(function() {

                form.append($("<input>", {

                    "type": "hidden",

                    "name": "section_ids[]",

                    "value": $(this).val()

                }));

            });

            $("body").append(form);

            form.submit();

        } else {

            alert("Please select at least one section to enable feedback.");

        }

    });



    // Disable feedback button click handler

    $("#disableFeedbackBtn").on("click", function() {

        if($(".sectionCheckbox:checked").length > 0) {

            if(!confirm("Are you sure you want to disable feedback for the selected sections?")) return false;

            var form = $("<form>", {

                "method": "post",

                "action": baseURL + "disableFeedback"

            });

            $(".sectionCheckbox:checked").each(function() {

                form.append($("<input>", {

                    "type": "hidden",

                    "name": "section_ids[]",

                    "value": $(this).val()

                }));

            });

            $("body").append(form);

            form.submit();

        } else {

            alert("Please select at least one section to disable feedback.");

        }

    });



    // Enable/Disable feedback toggle per row
    $(document).on('change', '.feedbackToggle', function() {
        var row_id = $(this).data('row_id');
        var checked = $(this).is(':checked');
        var form = $('<form>', {
            'method': 'post',
            'action': baseURL + (checked ? 'enableFeedback' : 'disableFeedback')
        });
        form.append($('<input>', {
            'type': 'hidden',
            'name': 'row_id',
            'value': row_id
        }));
        $('body').append(form);
        form.submit();
    });
});
</script>