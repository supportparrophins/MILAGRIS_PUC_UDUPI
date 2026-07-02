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
<div class="row column_padding_card">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container px-3 pt-1 overall_content">
    <div class="content-wrapper">
    <?php if($_SESSION['loggedIn_type']!='Mobile'){ ?>
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class="col-lg-5 col-6 col-md-6 col-sm-5 box-tools">
                                <span class="page-title">
                                    <i class="material-icons">group</i> Class Completed
                                </span>
                            </div>
                            <div class="col-lg-5 col-md-3 col-sm-4 col-3">
                                <div class="count_heading">Total: <?php echo $classCount; ?> </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-3 col-3">
                                <a onclick="showLoader();window.history.back();"
                                    class="btn primary_color mobile-btn float-right text-white"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="row p-0 column_padding_card">
            <div class="col-12 column_padding_card">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2 table-responsive">
                        <table style="width:100%" class="display table  table-bordered table-striped table-hover mb-0">
                            <thead>
                                <tr class="table_row_backgrond text-center">
                                    <th>Date</th>
                                    <th>Staff ID</th>
                                    <th>Subject</th>
                                    <th>Type</th>
                                    <th>Time</th>
                                    <th>Term</th>
                                    <th>Stream</th>
                                    <th>Section</th>
                                    <th>Action</th>
                                </tr> <tr class="row_filter">
                                    <form action="<?php echo base_url() ?>viewClassCompletedInfo" method="POST" id="byFilterMethod">
                                        <th style="padding: 1px;"> 
                                            <input type="text" name="classDate"
                                            id="classDate" value="<?php echo $classDate; ?>"
                                            class="form-control input-sm pull-right datepicker"
                                            style="text-transform: uppercase" placeholder="By Date"
                                            autocomplete="off" />
                                        </th>
                                        <th style="padding: 1px;"> 
                                            <input type="text" name="staff_id" id="staff_id"
                                            value="<?php echo $staff_id; ?>"
                                            class="form-control input-sm pull-right"
                                            style="text-transform: uppercase" placeholder="Staff ID"
                                            autocomplete="off" />
                                        </th>
                                        <th width="90" style="padding: 1px;">
                                            <select class="form-control input-sm" id="subject_code" name="subject_code">
                                                <?php if(!empty($subject_code)){ ?>
                                                    <option value="<?php echo $subject_code; ?>" selected><b>Sorted: <?php echo $subject_code; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Subject</option>
                                                <option value="">ALL</option>
                                                <?php if(!empty($subjectInfo)){
                                                    foreach($subjectInfo as $sub){ ?>
                                                        <option value="<?php echo $sub->subject_code; ?>"><?php echo $sub->sub_name; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </th>

                                        <th style="padding: 1px;">
                                            <select class="form-control input-sm" id="subject_type" name="subject_type">
                                                <?php if(!empty($subject_type)){ ?>
                                                    <option value="<?php echo $subject_type; ?>" selected><b>Sorted: <?php echo $subject_type; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Type</option>
                                                <option value="">ALL</option>
                                                <option value="THEORY">THEORY</option>
                                                <option value="LAB">LAB</option>
                                                
                                            </select>
                                        </th>

                                        <th style="padding: 1px;">
                                            <select class="form-control input-sm" id="time" name="time">
                                                <?php if(!empty($time)){ ?>
                                                    <option value="<?php echo $time; ?>" selected><b>Sorted: <?php echo $time; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Time</option>
                                                <option value="">ALL</option>
                                                <?php if(!empty($timingsInfo)){
                                                    foreach($timingsInfo as $time){ ?>
                                                        <option value="<?php echo $time->row_id; ?>"><?php echo $time->start_time.'-',$time->end_time; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </th>
                                        <th>
                                            <select class="form-control input-sm" id="by_term" name="by_term">
                                                <?php if($by_term != ""){ ?>
                                                    <option value="<?php echo $by_term; ?>" selected><b>Sorted: <?php echo $by_term; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Term</option>
                                                <option value="I PUC">I PUC</option>
                                                <option value="II PUC">II PUC</option>
                                            </select>
                                        </th>
                                        <th>
                                            <select class="form-control input-sm" id="stream_name" name="stream_name">
                                                <?php if(!empty($stream_name)){ ?>
                                                    <option value="<?php echo $stream_name; ?>" selected><b>Sorted: <?php echo $stream_name; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Stream</option>
                                                <option value="">ALL</option>
                                                <?php if(!empty($streamInfo)){
                                                    foreach($streamInfo as $stream){ ?>
                                                        <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </th>
                                        <th>
                                            <select class="form-control input-sm" id="section_name" name="section_name">
                                                <?php if(!empty($section_name)){ ?>
                                                    <option value="<?php echo $section_name; ?>" selected><b>Sorted: <?php echo $section_name; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Section</option>
                                                <option value="">ALL</option>
                                                <!-- <option value="A">A</option>
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
                                                <option value="M">M</option> -->
                                            </select>
                                        </th>
                                        <th style="padding: 1px;" class="text-center">
                                            <button type="submit" class="btn btn-success btn-md btn-block"><i class="fa fa-filter"></i> Filter</button>
                                        </th>
                                    </form>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($classRecord)) {
                                    foreach($classRecord as $record) { ?> 
                                    <tr>
                                        <th width="100"><?php echo date('d-m-Y',strtotime($record->date)) ?></th>
                                        <th width="150" class="text-center"><?php echo $record->staff_id ?></th>
                                        <th width="150" class="text-center"><?php echo $record->sub_name; ?></th>
                                        <th width="150" class="text-center"><?php echo $record->subject_type; ?></th>
                                        <th width="120" class="text-center"><?php echo $record->start_time.'-'.$record->end_time; ?></th>
                                        <th width="140" class="text-center"><?php echo $record->term_name; ?></th>
                                        <th class="text-center"><?php echo $record->stream_name; ?></th>
                                        <th class="text-center"><?php echo $record->section_name; ?></th>
                                        <th class="text-center">
                                            <?php //if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE || $role == ROLE_SUPER_ADMIN){ ?>
                                            <?php if($accessInfo->can_delete == 1){ ?>
                                                <a class="btn btn-xs btn-danger deleteClassCompleted" href="#" data-row_id="<?php echo $record->row_id; ?>"
                                                title="Delete"><i class="fa fa-trash"></i></a>
                                            <?php } ?>
                                        </th>
                                    </tr>
                                <?php } }else{ ?>
                                    <tr>
                                        <th class="text-center" colspan="9">Class completed record not found</th>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr class="table_row_backgrond text-center">
                                    <th>Date</th>
                                    <th>Staff ID</th>
                                    <th>Subject</th>
                                    <th>Type</th>
                                    <th>Time</th>
                                    <th>Term</th>
                                    <th>Stream</th>
                                    <th>Section</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                    <div class="card-footer p-1">
                        <span class="float-right"><?php echo $this->pagination->create_links(); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script src="<?php echo base_url(); ?>assets/js/attendance.js" type="text/javascript"></script>
<script type="text/javascript">
var loader = '<img height="70" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';
jQuery(document).ready(function() {
    // $('select').selectpicker();

    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "viewClassCompletedInfo/" + value);
        jQuery("#byFilterMethod").submit();
    });

    jQuery('.datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        dateFormat: "dd-mm-yy",
        maxDate : 0,

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