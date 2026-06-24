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
<div class="main-content-container px-3 pt-1">
    <div class="content-wrapper">
        <div class="row p-0">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                                <span class="page-title">
                                    <i class="material-icons">alarm_off</i> Permision
                                </span>
                            </div>

                            <div class="col-lg-9 col-md-9 col-sm-12 col-12">
                                <div class="btn-group pull-right" role="group" aria-label="New Action">
                                    <?php if($role == ROLE_ADMIN || $role ==ROLE_PRIMARY_ADMINISTRATOR) { ?>
                                    <!-- <button data-toggle="modal" data-target="#downloadPermissionReport" type="button"
                                        class="btn btn-info"><i class="material-icons">cloud_download</i>
                                        Report</button> -->
                                    <button data-toggle="modal" data-target="#applyNewPermissionByAdmin" type="button"
                                        class="btn btn-danger"><i class="material-icons">alarm_off</i>
                                        Apply New By Admin</button>

                                    <?php } ?>
                                    <?php if($role != ROLE_PRINCIPAL) { ?>
                                    <button data-toggle="modal" data-target="#applyNewPermission" type="button"
                                        class="btn btn-success"><i class="material-icons">alarm_off</i> Apply
                                        New</button>
                                    <?php } ?>
                                    <a onclick="showLoader();window.history.back();" type="button"
                                        class="btn primary_color text-white"><i class="fa fa-arrow-circle-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col column_padding_card">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2 text-center table-responsive">
                        <table id="leave-list" style="width:100%"
                            class="display nowrap table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Date From</th>
                                    <th>Date To</th>
                                    <th>Name</th>
                                    <th>Out Time</th>
                                    <th>Return Time</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th width="100">Action</th>
                                </tr>
                            </thead>
                            <tbody>


                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Date From</th>
                                    <th>Date To</th>
                                    <th>Name</th>
                                    <th>Out Time</th>
                                    <th>Return Time</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th width="100">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<!-- The leave view Modal -->
<div class="modal" id="leaveInfoModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header ">
                <h4 class="modal-title">Permision Info of <span id="staff_name_view"></span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding:0px;">
                <div class="card-body contents-body">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr class="table-danger">
                                        <td width="200">Date From</td>
                                        <td id="date_from_view"></td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td>Date To</td>
                                        <td id="date_to_view"></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td>Out Time</td>
                                        <td id="out_time_view"></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td>Return Time</td>
                                        <td id="return_time_view"></td>
                                    </tr>
                                    <tr class="table-info">
                                        <td>Pass Type</td>
                                        <td id="permission_type_view"></td>
                                    </tr>
                                    <tr class="table-danger">
                                        <td>Approved Staff Id</td>
                                        <td id="approved_by"></td>
                                    </tr>
                                    <tr class="table-danger">
                                        <td>Rejected Staff Id</td>
                                        <td id="rejected_by"></td>
                                    </tr>
                                    <tr class="table-info">
                                        <td>Reason</td>
                                        <td id="reason_view"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr class="table-danger">
                                        <td width="300">Permision in this Month</td>
                                        <td id="month_count"></td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td>Total Permision Taken</td>
                                        <td id="year_count"></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>


                    </div>
                    <hr class="mt-1 mb-1">
                    <?php if($role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_ADMIN){ ?>
                    <!-- Modal footer -->
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-12">
                            <span id="rejectButton"></span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12 text-center">
                            <?php if($role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR){ ?>
                            <span class="text-center" id="specialPermissionButton"></span>
                            <?php } ?>
                        </div>
                        <div class="col-lg-4 col-md-4 col-12">
                            <span id="approveButton"></span>

                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- The leave view Modal -->
<div class="modal" id="applyNewPermission">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header ">
                <h4 class="modal-title">Apply for new Permision</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="padding:0px;">
                <div class="card-body contents-body">
                    <form id="" method="POST" action="<?php echo base_url().'applyNewPermission'?>">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date From</label>
                                    <input type="text" class="dateFrom form-control" name="fromDate" id="fromDate"
                                        value="<?php echo date('d-m-Y'); ?>" placeholder="Date From" required
                                        autocomplete="off">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date To</label>
                                    <input type="text" class="dateTo form-control" name="toDate" id="toDate"
                                        value="<?php echo date('d-m-Y'); ?>" placeholder="Date To" required
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="form-group ">
                                    <label for="team_id">Pass Type</label>
                                    <select required id="permission_type" name="permission_type" class="form-control">
                                        <option value="">Select Type</option>
                                        <option value="personal">Personal</option>
                                        <option value="official">Official Duty </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <label for="exampleInputEmail1">Out Time (24 Hour Format)</label>
                                <div class="input-group">

                                    <select required id="out_time_hh" name="out_time_hh" class="form-control" required>
                                        <option value="">Select Hour</option>
                                        <?php for($i=1; $i<25; $i++){ ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                    <select required id="out_time_mm" name="out_time_mm" class="form-control" required>
                                        <option value="">Select Minute</option>
                                        <?php for($i=0; $i<60; $i++){ ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>


                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <label for="exampleInputEmail1">Return Time (24 Hour Format)</label>
                                <div class="input-group">

                                    <select required id="return_time_hh" name="return_time_hh" class="form-control"
                                        required>
                                        <option value="">Select Hour</option>
                                        <?php for($i=1; $i<25; $i++){ ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                    <select required id="return_time_mm" name="return_time_mm" class="form-control"
                                        required>
                                        <option value="">Select Minute</option>
                                        <?php for($i=0; $i<60; $i++){ ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>



                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Reason for Permision</label>
                                    <textarea placeholder="Write Your Reason Here.." name="permission_reason"
                                        class="form-control" id="exampleFormControlTextarea1" rows="3"
                                        required></textarea>
                                </div>
                            </div>
                        </div>
                        <hr class="mt-1 mb-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <div id="loader"></div>
                                <button type="submit" class="btn pull-right btn-primary text-white"
                                    id="downloadReportButton" name="add">Apply</button>
                                <button type="button" class="btn btn-danger pull-left"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                    <!-- Modal footer -->
                </div>
            </div>
        </div>
    </div>
</div>



<!-- The leave view Modal -->
<div class="modal" id="editPermissionInfo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header ">
                <h4 class="modal-title">Edit Permision</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="padding:0px;">
                <div class="card-body contents-body">
                    <form id="" method="POST" action="<?php echo base_url().'updatePermissionInfoByStaff'?>">
                        <input type="hidden" id="row_id_edit" value="" name="row_id" />
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date From</label>
                                    <input type="text" class="dateFrom form-control" name="fromDate" id="fromDate_edit"
                                        value="<?php echo date('d-m-Y'); ?>" placeholder="Date From" required
                                        autocomplete="off">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date To</label>
                                    <input type="text" class="dateTo form-control" name="toDate" id="toDate_edit"
                                        value="<?php echo date('d-m-Y'); ?>" placeholder="Date To" required
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="form-group ">
                                    <label for="team_id">Pass Type</label>
                                    <select required id="permission_type_edit" name="permission_type"
                                        class="form-control">
                                        <option value="">Select Type</option>
                                        <option value="personal">Personal</option>
                                        <option value="official">Official Duty </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <label for="exampleInputEmail1">Out Time(24 Hr Format1)</label>
                                <div class="input-group">
                                    <select required id="outTime_hh" name="out_time_hh" class="form-control" required>
                                        <option value="">Select Hour</option>
                                        <?php for($i=1; $i<25; $i++){ ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                    <select required id="outTime_mm" name="out_time_mm" class="form-control" required>
                                        <option value="">Select Minute</option>
                                        <?php for($i=0; $i<60; $i++){ ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>



                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <label for="exampleInputEmail1">Return Time (24 Hr Format)</label>
                                <div class="input-group">
                                    <select required id="returnTime_hh" name="return_time_hh" class="form-control"
                                        required>
                                        <option value="">Select Hour</option>
                                        <?php for($i=1; $i<25; $i++){ ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                    <select required id="returnTime_mm" name="return_time_mm" class="form-control"
                                        required>
                                        <option value="">Select Minute</option>
                                        <?php for($i=0; $i<60; $i++){ ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>


                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Reason for Permision</label>
                                    <textarea placeholder="Write Your Reason Here.." name="permission_reason"
                                        class="form-control" id="reason_edit" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                        <hr class="mt-1 mb-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <div id="loader"></div>
                                <button type="submit" class="btn pull-right btn-primary text-white"
                                    id="downloadReportButton" name="add">Update</button>
                                <button type="button" class="btn btn-danger pull-left"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                    <!-- Modal footer -->
                </div>
            </div>
        </div>
    </div>
</div>



<!-- apply new permission by admin -->
<div class="modal" id="applyNewPermissionByAdmin">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header ">
                <h4 class="modal-title">Apply for New Permision by Administrator</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="padding:0px;">
                <div class="card-body contents-body">
                    <form id="" method="POST" action="<?php echo base_url().'applyNewPermissionByAdmin'?>">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <label for="role">Select Applied Staff</label>
                                <select class="form-control input-sm selectpicker" id="applied_staff_id"
                                    name="applied_staff_id" data-live-search="true" required>
                                    <option value="">Select Staff </option>
                                    <?php
                                        if(!empty($staffInfo))
                                        {
                                            foreach ($staffInfo as $rl)
                                            {
                                                ?>
                                    <option value="<?php echo $rl->staff_id ?>">
                                        <?php echo $rl->name ?></option>
                                    <?php
                                                }
                                            }
                                        ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date From</label>
                                    <input type="text" class="dateFrom form-control" name="fromDate" id="fromDate" readonly
                                        value="<?php echo date('d-m-Y'); ?>" placeholder="Date From" required
                                        autocomplete="off">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date To</label>
                                    <input type="text" class="dateTo form-control" name="toDate" id="toDate" readonly
                                        value="<?php echo date('d-m-Y'); ?>" placeholder="Date To" required
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="form-group ">
                                    <label for="team_id">Pass Type</label>
                                    <select required id="permission_type" name="permission_type" class="form-control">
                                        <option value="">Select Type</option>
                                        <option value="personal">Personal</option>
                                        <option value="official">Official Duty </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <label for="exampleInputEmail1">Out Time(24 hr format)</label>
                                <div class="input-group">
                                    <select required id="out_time_hh" name="out_time_hh" class="form-control" required>
                                        <option value="">Select Hour</option>
                                        <?php for($i=1; $i<25; $i++){ ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                    <select required id="out_time_mm" name="out_time_mm" class="form-control" required>
                                        <option value="">Select Minute</option>
                                        <?php for($i=0; $i<60; $i++){ ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <label for="exampleInputEmail1">Return Time (24 Hr format)</label>
                                <div class="input-group">
                                    <select required id="return_time_hh" name="return_time_hh" class="form-control"
                                        required>
                                        <option value="">Select Hour</option>
                                        <?php for($i=1; $i<25; $i++){ ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                    <select required id="return_time_mm" name="return_time_mm" class="form-control"
                                        required>
                                        <option value="">Select Minute</option>
                                        <?php for($i=0; $i<60; $i++){ ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Reason for Permision</label>
                                    <textarea placeholder="Write Your Reason Here.." name="permission_reason"
                                        class="form-control" id="exampleFormControlTextarea1" rows="3"
                                        required></textarea>
                                </div>
                            </div>
                        </div>
                        <hr class="mt-1 mb-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <div id="loader"></div>
                                <button type="submit" class="btn pull-right btn-primary text-white"
                                    id="downloadReportButton" name="add">Apply</button>
                                <button type="button" class="btn btn-danger pull-left"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                    <!-- Modal footer -->
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/permission.js" charset="utf-8"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

    $('#leave-list thead tr').clone(true).appendTo('#leave-list thead');
    $('#leave-list thead tr:eq(1) th').each(function(i) {
        var title = $(this).text();
        var newClassupdate = '';
        if (title == 'Date From') {
            var newClassupdate = 'datepicker_from';
        }
        if (title == 'Date To') {
            var newClassupdate = 'datepicker_to';
        }
        if (title == 'Status') {
            $(this).html(`<div class="form-group position-relative mb-0 mt-0" style="margin-top: -5px !important; margin-bottom: -5px !important;" >
            <input placeholder="Total Number of Leave" class=" form-control"
           type="text" list="leaves" required />
            <datalist id="leaves">
                <option>Approved</option>
                <option>Pending</option>
                <option>Rejected</option>
              
            </datalist>
            </div>`);
        } else {
            $(this).html(
                '<div class="form-group position-relative mb-0 mt-0" style="margin-top: -5px !important; margin-bottom: -5px !important;" ><input style="border: 1px solid #75787b !important;" type="text" class="form-control input-sm ' +
                newClassupdate + '" placeholder="Search ' +
                title + '" /> </div>');
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


    var table = $('#leave-list').DataTable({
        columnDefs: [

            // { className: "my_class", targets: "_all" },
            // {
            //     className: "text-left",
            //     targets: 1,

            // }
        ],
        lengthMenu: [
            [200, 150, 100, 50, 20, 10],
            [200, 150, 100, 50, 20, 10]
        ],
        // pageLength: 200,
        //bFilter: false,
        "order": [
            [6, "desc"]
        ],
        processing: true,
        orderCellsTop: true,
        fixedHeader: true,
        language: {
            "info": "Showing _START_ to _END_ of _TOTAL_  Permision",
            "infoFiltered": "(filtered from _MAX_ total staff Permision)",
            "search": "",
            searchPlaceholder: "Search Permision",
            "lengthMenu": "Show _MENU_ Permision",
            "infoEmpty": "Showing 0 to 0 of 0 Permision",
            //processing: '<img src="'+baseURL+'assets/images/loader.gif" width="150"  alt="loader">'
        },

        "ajax": {
            url: '<?php echo base_url(); ?>/get_applied_permission_info ',
            type: 'POST',

            // dataType: 'json',
        },

    });

    jQuery(
            '#fromDate_report, #toDate_report, #fromDate_edit, #toDate_edit, .datepicker, .datepicker_from, .datepicker_to, #dateAssigned'
        )
        .datepicker({
            autoclose: true,
            orientation: "bottom",
            format: "dd-mm-yyyy"
        });


        jQuery(
            '#fromDate_edit, #toDate_edit,  #fromDate, #toDate'
        )
        .datepicker({
            autoclose: true,
            orientation: "bottom",
            format: "dd-mm-yyyy",
            startDate: new Date('2020-06-01'),
            endDate: new Date('2021-06-01')
        });

});
</script>
<script type="text/javascript">
function viewMoreInfo(row_id) {
    $("#staffAssignTable tbody").html("");
    $.ajax({
        url: '<?php echo base_url(); ?>/getPermissionInfoByRowId',
        type: 'POST',
        dataType: 'json',
        data: {
            row_id: row_id,
        },
        success: function(data) {
            //format date as per indian standard
            let current_datetime = new Date(data.permissionInfo.permission_date_from);
            let formatted_date_from_date = appendLeadingZeroes(current_datetime.getDate()) + "-" +
                appendLeadingZeroes((current_datetime.getMonth() + 1)) +
                "-" + current_datetime.getFullYear();

            let current_datetime_to = new Date(data.permissionInfo.permission_date_to);
            let formatted_date_to_date = appendLeadingZeroes(current_datetime_to.getDate()) + "-" +
                appendLeadingZeroes((current_datetime_to.getMonth() + 1)) +
                "-" + current_datetime_to.getFullYear();
            var permission_type = "";
            if (data.permissionInfo.permission_type == 'personal') {
                permission_type = "PERSONAL";
            } else if (data.permissionInfo.permission_type == 'official') {
                permission_type = "OFFICIAL DUTY";
            }

            $("#staff_name_view").html(data.permissionInfo.staff_name);
            $("#date_from_view").html(formatted_date_from_date);
            $("#date_to_view").html(formatted_date_to_date);


            $("#out_time_view").html(data.permissionInfo.out_time);
            $("#return_time_view").html(data.permissionInfo.return_time);

            $("#permission_type_view").html(permission_type);
            $("#reason_view").html(data.permissionInfo.reason);

            $("#approved_by").html(data.permissionInfo.approved_by);
            $("#rejected_by").html(data.permissionInfo.rejected_by);

            var approveButton = "";
            var rejectButton = "";
            var specialPermissionButton = "";
            if (data.permissionInfo.approved_status != 1) {
                approveButton = `<button type="button" class="btn pull-right btn-success text-white" id="approveStaffPermission" name="add"
            data-row_id="` + row_id + `">Approve</button> `;
                specialPermissionButton = ` <button type="button" class="btn btn-primary text-white" id="approveSpecialPermission" name="add"
            data-row_id="` + row_id + `">Special Approve</button>`;
            } else {
                approveButton = "<b class='pull-right' style='color:green;'>Approved</b>";
            }

            rejectButton = `<button type="button" class="btn pull-left btn-danger text-white" id="rejectStaffPermission" name="add"
            data-row_id="` + row_id + `">Reject</button>`;



            $("#approveButton").html(approveButton);
            $("#rejectButton").html(rejectButton);
            $("#specialPermissionButton").html(specialPermissionButton);


            $("#month_count").html(data.month_count);
            $("#year_count").html(data.year_count);

            $('#leaveInfoModel').modal('show');
        },
        error: function(result) {
            alert("Network Server Error!!  Failed");
        },
        fail: (function(status) {
            alert("Server Error!!  Failed");
        }),
        beforeSend: function(d) {

        }
    });
}

function editPermissionInfo(row_id) {
    $.ajax({
        url: '<?php echo base_url(); ?>/getPermissionInfoByRowId',
        type: 'POST',
        dataType: 'json',
        data: {
            row_id: row_id,
        },
        success: function(data) {
            //format date as per indian standard
            let current_datetime = new Date(data.permissionInfo.permission_date_from);
            let formatted_date_from_date = appendLeadingZeroes(current_datetime.getDate()) + "-" +
                appendLeadingZeroes((current_datetime.getMonth() + 1)) +
                "-" + current_datetime.getFullYear();

            let current_datetime_to = new Date(data.permissionInfo.permission_date_to);
            let formatted_date_to_date = appendLeadingZeroes(current_datetime_to.getDate()) + "-" +
                appendLeadingZeroes((current_datetime_to.getMonth() + 1)) +
                "-" + current_datetime_to.getFullYear();

            $("#row_id_edit").val(row_id);


            $("#fromDate_edit").html(formatted_date_from_date);
            $("#toDate_edit").html(formatted_date_to_date);

            var out_time = data.permissionInfo.out_time.split(':');
            var return_time = data.permissionInfo.return_time.split(':');

            // $("#out_time_hh").val(out_time[0]);
            // $("#out_time_mm").val(out_time[1]);
            // $("#return_time_hh").val(return_time[0]);
            // $("#return_time_mm").val(return_time[1]);
            $("#outTime_hh").append('<option value="' + out_time[0] +
                '" selected>' + out_time[0] + '</option>');
            $("#outTime_mm").append('<option value="' + out_time[1] +
                '" selected>' + out_time[1] + '</option>');
            $("#returnTime_hh").append('<option value="' + return_time[0] +
                '" selected>' + return_time[0] + '</option>');
            $("#returnTime_mm").append('<option value="' + return_time[1] +
                '" selected>' + return_time[1] + '</option>');

            $("#permission_type_edit").append('<option value="' + data.permissionInfo.permission_type +
                '" selected>' + data.permissionInfo.permission_type + '</option>');
            $("#reason_edit").html(data.permissionInfo.reason);

            $('#editPermissionInfo').modal('show');
        },
        error: function(result) {
            alert("Network Server Error!!  Failed");
        },
        fail: (function(status) {
            alert("Server Error!!  Failed");
        }),
        beforeSend: function(d) {

        }
    });
}

function appendLeadingZeroes(n) {
    if (n <= 9) {
        return "0" + n;
    }
    return n;
}
</script>