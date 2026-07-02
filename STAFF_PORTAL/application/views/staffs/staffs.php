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
    <strong>Error!</strong> 
    <?php echo $this->session->flashdata('error'); ?>
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

<div class="main-content-container px-3 pt-1 overall_content">
    <div class="row column_padding_card">
        <div class="col-md-12">
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
        </div>
    </div>
    <div class="content-wrapper">
    <?php if($_SESSION['loggedIn_type']!='Mobile'){ ?>
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <span class="page-title">
                                    <i class="material-icons">group</i> Staff Management
                                </span>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12 box-tools">
                                    <a onclick="showLoader();window.history.back();" class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                    <?php // if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN){ ?>
                                  <?php if(isset($accessInfo) && $accessInfo->can_add==1 || $this->staff_id=='MILP1004'){ ?>
                                <div class="dropdown mobile-btn float-right">
                                    <button type="button" class="btn btn-success dropdown-toggle border_radius_none" data-toggle="dropdown">
                                        Action
                                    </button>
                                        <div class="dropdown-menu p-0">

                                    <!-- <a class="btn btn-primary mobile-btn float-right border_right_radius"
                                        href="<?php echo base_url(); ?>addNewStaff"><i class="fa fa-plus"></i>
                                        Add New</a> -->
                                        <a class="dropdown-item" href="<?php echo base_url(); ?>addNewStaff"><i class="fa fa-plus"></i> Add New</a>
                                    <a class="dropdown-item" id="sendNotification" href="#"> <i class="material-icons text-dark">send</i> Send Notification</a>
                                        <!-- <a class="dropdown-item" href="#" data-toggle="modal"
                                            data-target="#downloadFeedbackReport"><i class="fa fa-file"></i> Feedback
                                            Report</a>
                                            <a class="dropdown-item" href="#" data-toggle="modal"
                                            data-target="#downloadFeedbackReport2"><i class="fa fa-file"></i> Feedback Pending
                                            </a> -->

                                </div>
                                
                                    <!-- <div class="dropdown-menu p-0">
                                        <a class="dropdown-item disabled" href="#"><i class="fa fa-download"></i> Download</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="dropdown-item disabled" href="#"><i class="fa fa-mobile"></i> Send SMS</a>
                                    </div> -->
                                </div>
                                <?php } ?>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="row ">
            <div class="col column_padding_card">
                <div class="card card-small mb-4 column_padding_card">
                    <div class="card-body p-1 pb-2 table-responsive">
                        <table id="item-list" style="width:100%"
                            class="display table table-bordered table-striped table-responsive table-hover text-center">
                            <thead>
                                <tr>
                                    <th width="25"><input type="checkbox" id="selectAll" /></th>
                                    <th>Staff ID</th>
                                    <th>Machine ID</th>
                                    <th class="text-left" width="230">Name</th>
                                    <th>Department</th>
                                    <th>Role</th>
                                    <th>Mobile</th>
                                    <th width="140">Action</th>
                                </tr>
                            </thead>
                            <tbody>


                            </tbody>
                            <tfoot>
                                <tr>
                                    <th width="25"><input type="checkbox" id="selectAll" /></th>
                                    <th>Staff ID</th>
                                    <th>Machine ID</th>
                                    <th class="text-left" width="200">Name</th>
                                    <th>Department</th>
                                    <th>Role</th>
                                    <th>Mobile</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal send sms  -->
<div class="modal fade-scale" id="sendNotificationView">
    <div class="modal-dialog ">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header bg-blue ">
                <h4 class="modal-title">Send Notifiation to Staffs</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2"> 
                <form  action="<?php echo base_url() ?>sendStaffIndividualNotification" role="form" method="post" id="sendNotification"  enctype="multipart/form-data">
                    <input type="hidden" name="staff_id" id="staffs1">
                    <div class="text-center" id="alertMsg"></div>
                       <div class="form-group">
                            <label for="exampleInputEmail1">Date</label>
                           <input type="text" class="form-control required datepicker" id="date"  name="date" value="<?php echo date('d-m-Y'); ?>"  placeholder="Date Date" autocomplete="off"/>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Subject</label>
                           <input type="text" class="form-control" id="msg_subject"  name="msg_subject"   placeholder="Write Subject here" autocomplete="off"/>
                        </div>
                    
                    <hr class="mt-1 mb-2">
                    <div class="form-group">
                        <textarea type="text" class="w-100" name="message" id="messageValue" rows="6" placeholder="Type Message Here..."></textarea>
                    </div>
                    <div class="col-12">
                       <div class="form-group" id="msg_file">
                                <label for="fname">File </label>
                                <input type="file" class="form-control" id="msg_file" name="msg_file" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg">
                        </div>
                    </div>

                    <div class="modal-footer pb-0 px-2">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span> Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="downloadFeedbackReport">

    <div class="modal-dialog">

        <div class="modal-content">



            <!-- Modal Header -->

            <div class="modal-header exportModel">

                <h4 class="modal-title">Download Feedback Details</h4>

                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>



            <!-- Modal body -->

            <div class="modal-body p-2">

                <div class="row">

                    <div class="col-lg-6">

                        <div class="form-group mt-1">

                            <label>Select Class</label>

                            <select class="form-control required" name="term_name" id="class_name1" required>
                                <option value="">Select Term</option>
                                <option value="I PUC">I PUC</option>
                                <option  value="II PUC">II PUC</option>
                            </select>

                        </div>

                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mt-1">
                            <label>Select Stream</label>
                            <select class="form-control input-sm selectpicker" name="stream_name" id="stream_name1">
                                <option value="">Select Stream</option>
                                <?php if(!empty($streamInfo)){
                                    foreach($streamInfo as $stream){ ?>
                                    <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6">

                        <div class="form-group mt-1">

                            <label>Select Section</label>

                            <select class="form-control input-sm selectpicker" name="section_name" id="section_name1">

                                <option value="ALL">Select Section</option>
                                <option value="ALL">ALL(No Section)</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>

                            </select>

                        </div>

                    </div>

                    <div class="col-lg-6">

                        <div class="form-group mt-1">

                            <label>Select Type</label>

                            <select class="form-control input-sm selectpicker" name="report_type" id="report_type">

                                <option value="Analytics">Marks</option>
                                <option value="Comments">Comments</option>
                            </select>

                        </div>

                    </div>

                    <div class="col-lg-6">

                        <div class="form-group mt-1">

                            <label>Select Type</label>

                            <select class="form-control input-sm selectpicker" name="staff_type" id="staff_type1">

                                <option value="Teaching Staff">Teaching Staff</option>
                                <!-- <option value="Counsellor">Counsellor</option> -->
                            </select>

                        </div>

                    </div>

                </div>

            </div>



            <!-- Modal footer -->

            <div class="modal-footer">

                <button id="downloadReportExcel2" onclick="downloadFeedbackReport()" type="submit"
                    class="btn btn-md btn-primary float-right"><i class="fa fa-download"></i> Download</button>

                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

            </div>

        </div>

    </div>

</div>
<div class="modal fade" id="downloadFeedbackReport2">

    <div class="modal-dialog">

        <div class="modal-content">



            <!-- Modal Header -->

            <div class="modal-header exportModel">

                <h4 class="modal-title">Download Feedback Details</h4>

                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>



            <!-- Modal body -->

            <div class="modal-body p-2">

                <div class="row">

                    <div class="col-lg-6">

                        <div class="form-group mt-1">

                            <label>Select Class</label>

                            <select class="form-control required" name="term_name" id="class_name2" required>
                                <option value="">Select Term</option>
                                <option value="I PUC">I PUC</option>
                                <option  value="II PUC">II PUC</option>
                            </select>

                        </div>

                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mt-1">
                            <label>Select Stream</label>
                            <select class="form-control input-sm selectpicker" name="stream_name" id="stream_name2">
                                <option value="">Select Stream</option>
                                <?php if(!empty($streamInfo)){
                                    foreach($streamInfo as $stream){ ?>
                                    <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6">

                        <div class="form-group mt-1">

                            <label>Select Section</label>

                            <select class="form-control input-sm selectpicker" name="section_name" id="section_name2">

                                <option value="ALL">Select Section</option>
                                <option value="ALL">ALL(No Section)</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>

                        </div>

                    </div>

                  

                    <div class="col-lg-6">

                        <div class="form-group mt-1">

                            <label>Select Type</label>

                            <select class="form-control input-sm selectpicker" name="staff_type" id="staff_type2">

                                <option value="Teaching Staff">Teaching Staff</option>
                                <!-- <option value="Counsellor">Counsellor</option> -->
                            </select>

                        </div>

                    </div>

                </div>

            </div>



            <!-- Modal footer -->

            <div class="modal-footer">

                <button id="downloadReportExcel2" onclick="downloadFeedbackReport2()" type="submit"
                    class="btn btn-md btn-primary float-right"><i class="fa fa-download"></i> Download</button>

                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

            </div>

        </div>

    </div>

</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/staff.js" charset="utf-8"></script>
<script type="text/javascript">
function downloadFeedbackReport2() {
    var section_name = $('#section_name2').val();
    var class_name = $('#class_name2').val();
    var staff_type = $('#staff_type2').val();
    var stream_name = $('#stream_name2').val();

    $.ajax({
        url: '<?php echo base_url(); ?>/downloadFeedBackPendingExcelReport',
        type: 'POST',
        dataType: 'json',
        data: {
            section_name: section_name,
            class_name: class_name,
            staff_type: staff_type,
            stream_name: stream_name,

        },

        success: function(data) {
            hideLoader();
            var $a = $("<a>");
            $a.attr("href", data.file);
            $("body").append($a);
            $a.attr("download", class_name + "_" + section_name +
                "_FEEDBACK_PENDING_REPORT.xls");
            $a[0].click();
            $a.remove();
        },
        error: function(result) {
            hideLoader();
            alert("Search Error!!  Failed");
        },
        fail: (function(status) {
            hideLoader();
            alert("Server Error!!  Failed");
        }),
        beforeSend: function(d) {
            showLoader();
            // $("#loader").html(loader);
        }
    });

}
function downloadFeedbackReport() {
    var section_name = $('#section_name1').val();
    var class_name = $('#class_name1').val();
    var report_type = $('#report_type').val();
    var staff_type = $('#staff_type1').val();
    var stream_name = $('#stream_name1').val();

   if(report_type== 'Analytics'){

    $.ajax({
        url: '<?php echo base_url(); ?>/downloadFeedBackExcelReport',
        type: 'POST',
        dataType: 'json',
        data: {
            section_name: section_name,
            class_name: class_name,
            staff_type: staff_type,
            stream_name: stream_name

        },

        success: function(data) {
            hideLoader();
            var $a = $("<a>");
            $a.attr("href", data.file);
            $("body").append($a);
            $a.attr("download", class_name + "_" + section_name +
                "_FEEDBACK_REPORT.xls");
            $a[0].click();
            $a.remove();
        },
        error: function(result) {
            hideLoader();
            alert("Search Error!!  Failed");
        },
        fail: (function(status) {
            hideLoader();
            alert("Server Error!!  Failed");
        }),
        beforeSend: function(d) {
            showLoader();
            // $("#loader").html(loader);
        }
    });
}else if(report_type== 'Comments'){


    $.ajax({
        url: '<?php echo base_url(); ?>/downloadFeedBackCommentsExcelReport',
        type: 'POST',
        dataType: 'json',
        data: {
            section_name: section_name,
            class_name: class_name,
            staff_type: staff_type,
            stream_name: stream_name

        },

        success: function(data) {
            hideLoader();
            var $a = $("<a>");
            $a.attr("href", data.file);
            $("body").append($a);
            $a.attr("download", class_name + "_" + section_name +
                "_FEEDBACK_REPORT.xls");
            $a[0].click();
            $a.remove();
        },
        error: function(result) {
            hideLoader();
            alert("Search Error!!  Failed");
        },
        fail: (function(status) {
            hideLoader();
            alert("Server Error!!  Failed");
        }),
        beforeSend: function(d) {
            showLoader();
            // $("#loader").html(loader);
        }
    });

}else if(report_type== 'Pending'){

$.ajax({
    url: '<?php echo base_url(); ?>/downloadFeedBackPendingExcelReport',
    type: 'POST',
    dataType: 'json',
    data: {
        section_name: section_name,
        class_name: class_name,
    },

    success: function(data) {
        hideLoader();
        var $a = $("<a>");
        $a.attr("href", data.file);
        $("body").append($a);
        $a.attr("download", class_name + "_" + section_name +
            "_FEEDBACK_REPORT.xls");
        $a[0].click();
        $a.remove();
    },
    error: function(result) {
        hideLoader();
        alert("Search Error!!  Failed");
    },
    fail: (function(status) {
        hideLoader();
        alert("Server Error!!  Failed");
    }),
    beforeSend: function(d) {
        showLoader();
        // $("#loader").html(loader);
    }
});

}

}
jQuery(document).ready(function() {

    var staffs = [];

    $('#item-list thead tr').clone(true).appendTo('#item-list thead');
    $('#item-list thead tr:eq(1) th').each(function(i) {
        var title = $(this).text();
        if (title == 'Date') {
            var displayStatus = false;
            var newClassupdate = 'disabled';
        } else {
            var displayStatus = true;
            var newClassupdate = '';
        }
        if (title == '') {
            var displayStatus = false;
            var newClassupdate = 'disabled';
        } else {
            var displayStatus = true;
            var newClassupdate = '';
        }

        if(displayStatus == true){
            $(this).html(
            '<div class="form-group position-relative mb-0 mt-0" style="margin-top: -5px !important; margin-bottom: -5px !important;" ><input style="border: 1px solid #75787b !important;" type="text" class="form-control input-sm" placeholder="Search ' +
            title + '" ' +
            newClassupdate + ' /> </div>');
        }else{
            $(this).html('');
        }

        $('input', this).on('keyup change', function() {
            if (table.column(i).search() !== this.value) {
                table
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });

    jQuery.fn.dataTable.ext.order['last-four-digits'] = function(settings, col) {
            return this.api().column(col, {
                order: 'index'
            }).nodes().map(function(td, i) {
                // Extract the last four digits
                var text = $(td).text().trim();
                var lastFourDigits = text.substr(-4);

                // If empty or non-numeric, return a very high value
                if (lastFourDigits === "" || isNaN(lastFourDigits)) {
                    return 'zzzz'; // A string that will push empty values to the end when sorting
                }
                return lastFourDigits;
            });
        };


    var table = $('#item-list').DataTable({
        columnDefs: [
            // { className: "my_class", targets: "_all" },
            {
                className: "text-left",
                targets: 2,

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
        order: [[1, 'asc']],
        language: {
            "info": "Showing _START_ to _END_ of _TOTAL_ Staff",
            "infoFiltered": "(filtered from _MAX_ total staff)",
            "search": "",
            searchPlaceholder: "Search Staff",
            "lengthMenu": "Show _MENU_ Staff",
            "infoEmpty": "Showing 0 to 0 of 0 Staff",
            //processing: '<img src="'+baseURL+'assets/images/loader.gif" width="150"  alt="loader">'
        },

        "ajax": {
            url: '<?php echo base_url(); ?>/get_staffs ',
            type: 'POST',

            // dataType: 'json',
        },

    });


    $('#sendNotification').click(function() {
        
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Staff to send notification!");
            return;
        } else {
            
            // alert(students.length);
            $('#sendNotificationView').modal('show');
              $('.singleSelect:checked').each(function(i) {
                staffs.push($(this).val());
          
            //  students = JSON.stringify(students);

        });
            $('#staffs1').val(JSON.stringify(staffs));
            // alert($('#students').val());
        }
        $('.singleSelect:checked').each(function(i) {
            staffs.push($(this).val());
           
            //  students = JSON.stringify(students);

        });
        $('#countStudents').html($('.singleSelect:checkbox:checked').length);
    });




    jQuery('.datepicker, .dateSearch').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });

    //checkbox select
    $('#selectAll').click(function() {
        if ($('#selectAll').is(':checked')) {
            $('.singleSelect').prop('checked', true);
        } else {
            $('.singleSelect').prop('checked', false);
        }
    });
});
</script>