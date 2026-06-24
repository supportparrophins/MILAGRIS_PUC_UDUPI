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

                            <div class="col-lg-2 col-md-3 col-sm-4 col-3">

                                <div class="count_heading text-dark" style="font-size: 20px;">Total: <?php echo $classCount; ?> </div>

                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                <form action="<?=base_url() ?>viewClassTeacherClassCompletedInfo" method="POST" id="byFilterMethod">
                                    <div class="d-flex">
                                        <input class="form-control datepicker" type="text" name="date_from" value="<?php if(!empty($date_from)) echo date('d-m-Y', strtotime($date_from)); ?>" style="text-transform: uppercase" placeholder="Date From" autocomplete="off">
                                        <input class="form-control datepicker ml-1" type="text" name="date_to" value="<?php if(!empty($date_to)) echo date('d-m-Y', strtotime($date_to)); ?>" style="text-transform: uppercase" placeholder="Date To" autocomplete="off">
                                        <button type="submit" class="btn btn-success ml-1">Search</button>
                                    </div>
                                <!-- </form> -->
                            </div>
                            <div class="col-lg-1 col-md-3 col-sm-3 col-3">

                                <a onclick="window.history.back();"

                                    class="btn primary_color mobile-btn float-right text-white border_left_radius"

                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>

                                  

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="row p-0 column_padding_card">

            <div class="col-12 column_padding_card">

                <div class="card card-small mb-4">

                    <div class="card-body p-1 pb-2 table-responsive">

                        <table style="width:100%" class="display table  table-bordered table-striped table-hover mb-0">

                            <thead>

                                <tr class="table_row_backgrond text-center">

                                    <th>Date</th>

                                    <th>Term</th>

                                    <th>Stream</th>

                                    <th>Section</th>

                                    <th>Session</th>

                                    <th>Action</th>

                                </tr> <tr class="row_filter">

                                    <form action="<?php echo base_url() ?>viewClassTeacherClassCompletedInfo" method="POST" id="byFilterMethod">

                                        <th style="padding: 1px;"> 

                                            <input type="text" name="classDate"

                                            id="classDate" value="<?php echo $classDate; ?>"

                                            class="form-control input-sm pull-right datepicker"

                                            style="text-transform: uppercase" placeholder="By Date"

                                            autocomplete="off" />

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

                                            <select class="form-control input-sm" id="" name="stream_name">

                                                <?php if($stream_name != ""){ ?>

                                                    <option value="<?php echo $stream_name; ?>" selected><b>Sorted: <?php echo $stream_name; ?></b></option>

                                                <?php } ?>

                                                <option value="">By Stream</option>
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
                                                <option value="ALL">ALL</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                            </select>

                                        </th>

                                        <th>
                                         <select class="form-control input-sm" id="session_name" name="session_name">
                                            <?php if($session_name != ""){ ?>
                                                <option value="<?php echo $session_name; ?>" selected><b>Sorted: <?php echo $session_name; ?></b></option>
                                            <?php } ?>
                                            <option value="">BY SESSION</option>
                                            <option value="Morning Session">Morning Session</option>
                                            <option value="Afternoon Session">Afternoon Session</option>
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

                                        <th width="100" class="text-center"><?php echo date('d-m-Y',strtotime($record->date)) ?></th>

                                        <th width="140" class="text-center"><?php echo $record->term_name; ?></th>

                                        <th width="140" class="text-center"><?php echo $record->stream_name; ?></th>

                                        <th width="140" class="text-center"><?php echo $record->section_name; ?></th>

                                        <th width="140" class="text-center"><?php echo $record->session; ?></th>

                                        <th width="180" class="text-center">

                                            <?php if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN || $role == ROLE_ACADEMIC_INCHARGE || $staffID == 'LCS100' || $staffID == 'LCS87' || $staffID == 'LCS101'){ ?>

                                                <a class="btn btn-xs btn-danger deleteAbsentClassCompleted" href="#" data-row_id="<?php echo $record->row_id; ?>"

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

                                    <th>Term</th>

                                    <th>Stream</th>

                                    <th>Section</th>

                                    <th>Session</th>

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









<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/attendance.js" charset="utf-8"></script>

<script type="text/javascript">

var loader = '<img height="70" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';

jQuery(document).ready(function() {

    // $('select').selectpicker();



    jQuery('ul.pagination li a').click(function(e) {

        e.preventDefault();

        var link = jQuery(this).get(0).href;

        var value = link.substring(link.lastIndexOf('/') + 1);

        jQuery("#byFilterMethod").attr("action", baseURL + "viewClassTeacherClassCompletedInfo/" + value);

        jQuery("#byFilterMethod").submit();

    });



    jQuery('.datepicker').datepicker({

        autoclose: true,

        orientation: "bottom",

        format: "dd-mm-yyyy",

        endDate : "today",



    });





    //checkbox select

    $('#selectAll').click(function() {

        if ($('#selectAll').is(':checked')) {

            $('.singleSelect').prop('checked', true);

        } else {

            $('.singleSelect').prop('checked', false);

        }

    });


    jQuery(document).on("click", ".deleteAbsentClassCompleted", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "deleteAbsentClassCompleted",
			currentRow = $(this);
		var confirmation = confirm("Are you sure to delete this Class Detail?");
		if(confirmation) {
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Class successfully deleted"); }
				else if(data.status = false) { alert("Class deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});


});



</script>