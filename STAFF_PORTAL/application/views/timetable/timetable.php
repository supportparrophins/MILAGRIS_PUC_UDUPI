<style>
.select2-container .select2-selection--single {
    height: 38px !important;
    width: 360px !important;
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
                            <div class="col-lg-7 col-12 col-md-7 box-tools">
                                <span class="page-title">
                                    <i class="material-icons">access_time</i> Time Table
                                </span>
                            </div>
                            <div class="col-lg-5 col-md-5 col-12">
                                <a onclick="showLoader();window.history.back();" class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                    
                                <?php //if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE) { ?>
                                    <!-- <a class="btn btn-success mobile-btn float-right text-white border_right_radius" href="#" data-toggle="modal" data-target="#multiTimeTable">
                                    <i class="material-icons">access_time</i> Multiple Time Table</a> -->
                                <?php //} ?>
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
                        <table id="item-list" style="width:100%" class="display table  table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Term Name</th>
                                    <th>Stream Name</th>
                                    <th>Section Name</th>
                                    <!-- <th>Class Type</th>
                                    <th>Class Teacher</th> -->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>


                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Term Name</th>
                                    <th>Stream Name</th>
                                    <th>Section Name</th>
                                    <!-- <th>Class Type</th>
                                    <th>Class Teacher</th> -->
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- The Modal -->
    <div class="modal fade" id="timeTableReport">
        <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Download Time Table</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form action="<?php echo base_url() ?>downloadTimeTableExcelReport" method="POST">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Select Term</label>
                                <select class="form-control input-sm selectpicker" id="term" name="term" required>
                                    <option value="">Select Term</option>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Select Preference</label>
                                <select class="form-control input-sm selectpicker" id="preference" name="preference" required>
                                    <option value="">Select One Preference</option>
                                    <option value="ALL">ALL</option>
                                    <?php if(!empty($streamDetail)){
                                        foreach($streamDetail as $stream){ ?>
                                        <option value="<?php echo $stream->stream_name ?>">
                                            <?php echo $stream->stream_name ?>
                                        </option>
                                    <?php }  } ?>
                                
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Select Academic Year
                                <select class="form-control input-sm selectpicker" id="section_name" name="section_name" required>
                                    <option value="">Select Section</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                    <option value="G">G</option>
                                    <option value="ALL">ALL (No Section)</option>
                                </select>
                            </div>
                        </div>
                    </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button id="downloadReportExcel" type="submit" class="btn btn-md btn-primary float-right"><i
                        class="fa fa-download"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="multiTimeTable">
        <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Multiple Class Time Table</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form action="<?php echo base_url() ?>addMultipleTimeTable" method="POST">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Select Term</label>
                                <select class="form-control input-sm selectpicker" id="term" name="term" required>
                                    <option value="">Select Term</option>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                    </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-md btn-primary float-right"> Submit</button>
            </div> 
            </form>
            </div>
        </div>
    </div>
</div>

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
                className: "text-center",
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
            "info": "Showing _START_ to _END_ of _TOTAL_ Time Table",
            "infoFiltered": "(filtered from _MAX_ total Time Table)",
            "search": "",
            searchPlaceholder: "Search Time Table",
            "lengthMenu": "Show _MENU_ Time Table",
            "infoEmpty": "Showing 0 to 0 of 0 Time Table",
            //processing: '<img src="'+baseURL+'assets/images/loader.gif" width="150"  alt="loader">'
        },

        "ajax": {
            url: '<?php echo base_url(); ?>/get_class',
            type: 'POST',

            // dataType: 'json',
        },

    });



    jQuery('.datepicker, .dateSearch').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });
});
</script>