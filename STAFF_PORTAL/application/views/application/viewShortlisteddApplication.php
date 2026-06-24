<style>
input[type=checkbox] {
    cursor: pointer;
    font-size: 10px;
    -moz-appearance: initial;
    visibility: hidden;
    position: relative;
    top: 0;
    left: 0;
    transform: scale(1.2);
}

input[type=checkbox]:after {
    content: " ";
    background-color: #fff;
    display: inline-block;
    color: red;
    width: 10px;
    height: 10px;
    visibility: visible;
    border: 1px solid #3c8dbc;
    padding: 2px;
    margin: 1px 0;
    border-radius: 1px;
    box-shadow: 0 0 15px 0 rgba(0, 0, 0, 0.08), 0 0 2px 0 rgba(0, 0, 0, 0.16);
}

input[type=checkbox]:checked:after {
    content: "\2714";
    display: unset;
    font-weight: bold;
    width: 10px;
    height: 10px;
    padding: 2px
}

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
                            <div class=" col-12 col-md-6 col-lg-3 box-tools">
                                <span class="page-title">
                                    <i class="fa fa-file"></i> Shortlisted Application
                                </span>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12">
                                <b class="text-dark" style="font-size: 18px;">Total: <?php echo $studentCount; ?></b>
                            </div>
                            <div class="col-lg-2">
                            <form action="<?php echo base_url() ?>getShortlistedApplication" method="POST" id="byFilterMethod">
                            <div class="input-group mobile-btn float-right student_search">
                                        <select class="p-1 search_select" name="admission_year" id="admission_year">
                                            <?php if(!empty($admission_year)){ ?>
                                                <option value="<?php echo $admission_year; ?>" selected><b>Selected: <?php echo $admission_year; ?></b></option>
                                            <?php } ?>
                                            <option value="<?php echo CURRENT_YEAR?>"><?php echo CURRENT_YEAR?></option>
                                            <option value="2021">2021</option>
                                            
                                        </select>
                                        <div class="input-group-append">
                                        <button type="submit" class="btn btn-success border_radius_none py-0">
                                            <i class="fa fa-search"></i>
                                        </button>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-lg-3">
                                <a onclick="window.history.back();"
                                    class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                <a class="btn btn-md btn-success pull-right mobile-btn border_right_radius" 
                                id="interviewComplete"> <span style="color:white;">Interview Completed</span></a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 ">
            <div class="col-12">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-1 table-responsive">
                        <table style="width:100%" class="display table  table-bordered table-striped table-hover mb-0">
                            <thead>
                                <tr class="table_row_backgrond text-center">
                                    <th width="25"><input type="checkbox" id="selectAll" /></th>
                                    <th>Application No.</th>
                                    <th width="200">Name</th>
                                    <th>%</th>
                                    <th>Category</th>
                                    <th>Stream</th>
                                    <th>Integrated Batch</th>
                                    <th>Board</th>
                                
                                    <th>Admission</th>
                                    <th>Fee Status</th>
                                    <th>List</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                <tr class="row_filter">
                                   
                                        <th></th>
                                        <th style="padding: 1px;"> <input type="text" name="application_number"
                                                id="application_number" value="<?php echo $application_number; ?>"
                                                class="form-control input-sm pull-right"
                                                style="text-transform: uppercase" placeholder="Application Number"
                                                autocomplete="off" />
                                        </th>
                                        <th style="padding: 1px;"> <input type="text" name="student_name"
                                                id="student_name" value="<?php echo $student_name; ?>"
                                                class="form-control input-sm pull-right"
                                                style="text-transform: uppercase" placeholder="Name"
                                                autocomplete="off" />
                                        </th>
                                        <th style="padding: 1px;"> <input type="text" name="sslc_pecentage"
                                                id="sslc_pecentage" value="<?php echo $sslc_pecentage; ?>"
                                                class="form-control input-sm pull-right"
                                                style="text-transform: uppercase" placeholder="SSLC Percentage"
                                                autocomplete="off" />
                                        </th>
                                        <th width="110" style="padding: 1px;">
                                            <select class="form-control input-sm" id="by_category_name" name="by_category_name">
                                                <?php if($by_category_name != ""){ ?>
                                                    <option value="<?php echo $by_category_name; ?>" selected><b>Selected: <?php echo $by_category_name; ?></b></option>
                                                <?php } ?>  
                                                <option value="" >ALL</option>
                                                <?php if(!empty($casteInfo)){
                                                    foreach($casteInfo as $caste){ ?>
                                                    <option value="<?php echo $caste->name; ?>">
                                                        <?php echo $caste->name; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </th>

                                        <th style="padding: 1px;">
                                            <select class="form-control input-sm" id="stream_name" name="stream_name"
                                                autocomplete="off">
                                                <?php if(!empty($stream_name)){ ?>
                                                <option value="<?php echo $stream_name; ?>"><?php echo $stream_name; ?>
                                                </option>
                                                <?php } ?>
                                                <option value="">ALL</option>
                                                <?php if(!empty($streamInfo)){
                                                    foreach($streamInfo as $stream){ ?>
                                                <option value="<?php echo $stream->stream_name; ?>">
                                                    <?php echo $stream->stream_name; ?></option>
                                                <?php } } ?>

                                            </select>
                                        </th>
                                        <th style="padding: 1px;">
                                            <select class="form-control input-sm" id="integrated_batch" name="integrated_batch"
                                                autocomplete="off">
                                                <?php if(!empty($integrated_batch)){ ?>
                                                <option value="<?php echo $integrated_batch; ?>"><?php echo $integrated_batch; ?>
                                                </option>
                                                <?php } ?>
                                                <option value="">Integrated Batch</option>
                                                <option value="JEE">JEE</option>
                                                <option value="NEET">NEET</option>
                                                <option value="CPT">CPT</option>
                                                <option value="CET">CET</option>
                                                <option value="CLAT">CLAT</option>
                                                <option value="NONE">NONE</option>

                                            </select>
                                        </th>
                                        <th>
                                            <select class="form-control input-sm" id="board_name" name="board_name" autocomplete="off">
                                                <?php if(!empty($by_board_name)){ ?>
                                                <option value="<?php echo $by_board_name; ?>">
                                                    <?php echo $by_board_name; ?></option>
                                                <?php } ?><option value="">ALL</option>
                                               

                                                <?php if(!empty($boardInfo)){ 
                                                    foreach($boardInfo as $board){ ?>
                                                    <option value="<?php echo $board->board_name; ?>"><?php echo $board->board_name; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </th>
                                        <th width="110" style="padding: 1px;">
                                            <select class="form-control input-sm" id="sms_status" name="sms_status">
                                                <?php if($sms_status != ""){ ?>
                                                    <option value="<?php echo $sms_status; ?>" selected>Selected: <?php echo $sms_status; ?></option>
                                                <?php } ?>
                                                <option value=""> ALL</option>
                                                <option value="Active" >Active</option>
                                                <option value="Cancelled" >Inactive</option>
                                            </select>
                                        </th>
                                        <th width="110" style="padding: 1px;">
                                            <select class="form-control input-sm" id="admission_status" name="admission_status">
                                                <?php if($admission_status != ""){ ?>
                                                    <option value="<?php echo $admission_status; ?>" selected><?php echo $admission_status; ?></option>
                                                <?php } ?>
                                                <option value=""> ALL</option>
                                                <option value="NOT PAID" >Not Paid</option>
                                                <option value="PAID" >Paid</option>
                                            </select>
                                        </th>
                                        <th width="50" style="padding: 1px;">
                                            <select class="form-control input-sm" id="shortlisted_list_number" name="shortlisted_list_number">
                                                <?php if($shortlisted_list_number != ""){ ?>
                                                    <option value="<?php echo $shortlisted_list_number; ?>" selected><?php echo $shortlisted_list_number; ?></option>
                                                <?php } ?>
                                                <option value=""> ALL</option>
                                                <option value="1" >I</option>
                                                <option value="2" >II</option>
                                                <option value="3" >III</option>
                                                <option value="4" >IV</option>
                                            </select>
                                        </th>


                                    
                                        <th style="padding: 1px;" class="text-center">
                                            <button type="submit" class="btn btn-success btn-md btn-block"><i
                                                    class="fa fa-filter"></i> Filter</button>
                                        </th>
                                    </form>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if(!empty($studentInfo)) {
                                    foreach($studentInfo as $record) {
                                ?> <tr>
                                    <th><input type="checkbox" class="singleSelect"
                                            value="<?php echo $record->application_number; ?>" /></th>
                                    <th class="text-center"><?php echo $record->application_number; ?></th>
                                    <th><?php echo $record->name; ?></th>
                                    <th class="text-center"><?php echo $record->sslc_percentage .' %'; ?> </th>
                                    <th class="text-center"><?php echo $record->student_category; ?></th>
                                    <th class="text-center"><?php echo $record->stream_name; ?></th>
                                    <th class="text-center"><?php echo $record->integrated_batch; ?></th>
                                    <th class="text-center"><?php echo $record->board_name; ?></th>
                                    <td><?php if($record->interview_status == 1){echo "<b style='color:green'>Active</b>";}else{echo "<b style='color:red'>Inactive</b>";} ?></td>
                                    <td><?php if($record->joined_status == 0){echo "<b style='color:red'>Not Paid</b>";}else{echo "<b style='color:green'>Paid</b>";} ?></td>
                                    <td class="text-center"><?php echo $record->shortlisted_list_number; ?></td>
                                    
                                    <th class="text-center">
                                        <a class="btn btn-xs btn-info" title="<?php echo $record->name; ?>" data-toggle="popover" data-placement="left" 
                                            data-content="<b>Student Mobile No.:</b> <?php echo $record->student_mobile; ?><br/><b>Father Mobile No.:</b> <?php echo $record->father_mobile; ?> <br/> <b>Mother Mobile No.:</b> <?php echo $record->mother_mobile; ?> <br/>"
                                            href="#" title="View More"><i class="fa fa-info-circle"></i></a>
                                            <a class="btn btn-xs btn-primary" target="_blank"
                                            href="<?php echo base_url(); ?>editSingleStudentApplications/<?php echo $record->resgisted_tbl_row_id; ?>"
                                            title="View More"><i class="fa fa-eye"></i></a>
                                            <a class="btn btn-xs btn-primary p-2" target="_blank"
                                            href="<?php echo base_url(); ?>viewPrintApplication/<?php echo $record->resgisted_tbl_row_id; ?>"
                                            title="Edit"><i class=""></i> Print</a>
                                        <!-- <a class="btn btn-xs btn-primary p-2" target="_blank"
                                            href="<?php echo base_url(); ?>viewPrintApplication/<?php echo $record->resgisted_tbl_row_id; ?>"
                                            title="Edit"><i class=""></i> Print</a> -->
                                            <!-- <a class="btn btn-xs btn-danger deleteApplication" href="#" data-row_id="<?php echo $record->resgisted_tbl_row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a> -->
                                    </th>
                                </tr>
                                <?php } }else{ ?>
                                <tr>
                                    <td class="text-center" colspan="11">Student Application Not Found</td>
                                </tr>
                                <?php } ?>

                            </tbody>
                            <tfoot>
                                <tr class="table_row_backgrond text-center">
                                    <th width="25"><input type="checkbox" id="selectAll" /></th>
                                    <th>Application No.</th>
                                    <th width="200">Name</th>
                                    <th>%</th>
                                    <th>Category</th>
                                    <th>Stream</th>
                                    <th>Integrated Batch</th>
                                    <th>Board</th>
                                
                                    <th>Admission</th>
                                    <th>Fee Status</th>
                                    <th>List</th>
                                    
                                    <th class="text-center">Actions</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                    <div class="card-footer text-center pt-1 px-1 pb-0">
                        <span class="float-right"><?php echo $this->pagination->create_links(); ?></span>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>


<div class="modal" id="interviewCompletedModel">
    <div class="modal-dialog ">
        <div class="modal-content ">
            <div class="modal-header bg-blue ">
                <h4 class="modal-title">Confirm Interview Completed Students</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>  
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form action="" method="POST" id="searchList">
                    <div class="text-center" id="alertMsg"></div>   
                    <div class="row">
                        <div class="col-lg-6">     
                    <label style="font-size: 18px;" >Total Students Selected: <label id="studentCount"></label></label>
                        </div>
                      
                    </div> 
                    <!-- <hr> -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger font-weight-bold" data-dismiss="modal">Close</button>
                        <button id="addInterviewStatus" type="button" class="btn btn-md btn-primary" > Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/student.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    var loader = '<img height="70" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';
    // $(".reason_unqualified").hide();

    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "getShortlistedApplication/" + value);
        jQuery("#byFilterMethod").submit();
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



    $('#leaving_date, .datepicker').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy"
    });


    $('#interviewComplete').click(function(){
        var students = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student!"); 
            return;
        }else{
            $('#interviewCompletedModel').modal('show');
        }
            $('.singleSelect:checked').each(function(i){
            students.push($(this).val());
        });
        $('#studentCount').html($('.singleSelect:checkbox:checked').length);
    });

      
    $('#addInterviewStatus').click(function(){
        var shortlist_number = $("#shortlist_number").val();
        var students = [];
        $('#alertMsg').html('<span>'+loader+'</span>');
        $('.singleSelect:checked').each(function(i){
            students.push($(this).val());
        });
        $.ajax({
            url: baseURL+'/updatedInterviewCompletedStudents',
            type: 'POST',
            data: { students_appliction_number : JSON.stringify(students), },
            success: function(data) {
            if(data > 0){
                $('#alertMsg').html(`<div class="alert alert-success" role="alert">
                Selected Students Updated Successfully!
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>`);
            }
            setTimeout(function(){ 
                location.reload();
                //$('#shortListModelView').modal('hide');
            }, 2000);
                
            },
            error: function(result){
                alert("Retry Again! Something Went Wrong");
            },
            fail:(function(status) {
                alert("Retry Again! Something Went Wrong");
            }),
            beforeSend:function(d){
                $('#alertMsg').html('<span>'+loader+'</span>');
            }
        });
    });
      

    // popover
    $('[data-toggle="popover"]').popover( { "container":"body", "trigger":"focus", "html":true });
    $('[data-toggle="popover"]').mouseenter(function(){
      $(this).trigger('focus');
    }); 

    	//delete fees structure
	jQuery(document).on("click", ".deleteApplication", function(){
		var reg_no = $(this).data("row_id"),
			hitURL = baseURL + "deleteApplication",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Application?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { reg_no : reg_no } 
			}).done(function(data){
					
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Application successfully deleted"); }
				else if(data.status = false) { alert("Application deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
    });
});
</script>