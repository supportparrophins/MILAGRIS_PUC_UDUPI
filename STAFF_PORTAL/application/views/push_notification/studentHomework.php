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

<div class="main-content-container px-3 pt-1 overall_content">
    <div class="row column_padding_card">
        <div class="col-md-12">
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                <div class="card-body p-2">
                        <div class="row">
                            <div class="col-5">
                                <span class="page-title">
                                    <i class="material-icons">menu_book</i> Homework
                                </span>
                            </div>
                            <div class="col-4">
                                <b class="text-dark" style="font-size: 20px;">Total Homework: <?php echo $homeworkInfoCount; ?></b>
                            </div>
                            <!-- <div class="col-4">
                                <form action="<? //=base_url() ?>getStudentHomework" method="POST" id="byFilterMethod">
                                    <div class="d-flex">
                                        <input class="form-control datepicker" type="text" name="date_from" value="<?php //if(!empty($date_from)) echo date('d-m-Y', strtotime($date_from)); ?>" style="text-transform: uppercase" placeholder="Date From" autocomplete="off">
                                        <input class="form-control datepicker ml-1" type="text" name="date_to" value="<?php //if(!empty($date_to)) echo date('d-m-Y', strtotime($date_to)); ?>" style="text-transform: uppercase" placeholder="Date To" autocomplete="off">
                                        <button type="submit" class="btn btn-success ml-1">Search</button>
                                    </div>
                                </form>
                            </div> -->
                            <div class="col-3 text-right">
                               <a onclick="showLoader();window.history.back();" class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                    <?php if($accessInfo->can_add == 1) { ?>
                                    <a class="btn btn-primary mobile-btn float-right border_right_radius" onclick="clearFields();"   type="reset" 
                                    data-toggle="modal" data-target="#addHomework"
                                        href="#" href="#"><i class="fa fa-plus"></i>
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
                    <div class="card-body p-1 pb-2 table-responsive">
                        <table class="display table table-bordered table-striped table-hover w-100">
                        <form action="<?php echo base_url(); ?>getStudentHomework" method="POST" id="byFilterMethod">
                                <tr class="filter_row" class="text-center">
                                   
                                    <td>
                                        <div class="form-group mb-0">
                                        <input type="text" value="<?php echo  $date ?>" name="date" id="date" class="form-control input-sm datepicker" placeholder="Search By Date" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <select class="form-control" name="term" id="term">
                                                <?php if(!empty($term)){ ?>
                                                    <option value="<?php echo $term; ?>" selected><b>Selected: <?php echo $term; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Term Name</option>
                                                <option value="I PUC">I PUC</option>
                                                <option value="II PUC">II PUC</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                        <select class="form-control input-sm" id="stream_name" name="stream_names">
                                         <?php if(!empty($stream_name)){ ?>
                                                    <option value="<?php echo $stream_name; ?>" selected><b>Selected: <?php echo $stream_name; ?></b></option>
                                                <?php } ?>
                                                 <option value="">By Stream</option>
                                           <?php if(!empty($streams)){
                                                foreach($streams as $stream){ ?>

                                               <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                                  <?php } } ?>
                                            </select>
                                           
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                           <select class="form-control input-sm" id="section_name" name="section_names">
                                        <?php if($section_name != ""){ ?>
                                            <option value="<?php echo $section_name; ?>" selected><b>Sorted:
                                            <?php echo $section_name; ?></b></option>
                                        <?php } ?>
                                            <option value="">By Section</option>
                                            <option value="ALL">ALL</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $subject; ?>" name="subject" id="subject" class="form-control input-sm" placeholder="By Subject" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <!-- <input type="text" value="" name="fitness_certificate_expiry_date" id="fitness_certificate_expiry_date" class="form-control input-sm datepicker" placeholder="Search Fitness Expiry Date" autocomplete="off"> -->
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $satff; ?>" name="satff" id="satff" class="form-control input-sm" placeholder="By Staff" autocomplete="off">
                                        </div>
                                    </td>
                                  
                                    <td>
                                        <button type="submit"class="btn btn-success btn-block mobile-width"><i class="fa fa-filter"></i> Filter</button>
                                    </td>
                                </tr>
                            </form>
                            <thead>
                                <tr class="table_row_background">
                                <th>Date</th>
                                <th class="text-center">Term Name</th>
                                <th class="text-center">Stream</th>
                                <th class="text-center">Section</th>
                                <th>Subject</th>
                                <th>Attachment</th>
                                <th>Staff</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                if(!empty($homeworkInfo)){
                                    foreach($homeworkInfo as $record){ ?>
                                        <tr>
                                            <td><?=date('d-m-Y',strtotime($record->submission_date))?> <?php echo date('g:i:s A', strtotime($record->date_time)); ?></td>
                                            <td class="text-center"><?=$record->term_name?></td>
                                            <td class="text-center"><?=$record->stream_name?></td>
                                            <td class="text-center"><?=$record->section_name?></td>
                                            <td><?=strtoupper($record->subject)?></td>
                                            <td class="text-center">
                                                <?php 
                                                    if($record->filepath !=""){?>
                                                        <a class='btn btn-md btn-primary' href='<?= base_url().$record->filepath ?>' download><i class='fa fa-download'></i> Download</a>
                                                    <?php }
                                                ?>
                                            </td>
                                            <td><?=strtoupper($record->sent_by)?></td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-xs btn-success" title="<b>Homework Desription:</b>" data-toggle="popover" data-placement="left"  data-trigger="focus" data-content="<b><?php echo $record->homework_discription; ?></b>"><i class="fa fa-info"></i></a>
                                                <?php //if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_TEACHING_STAFF || $role == ROLE_SUPER_ADMIN) { ?>
                                                <?php if($accessInfo->can_delete == 1) { ?>
                                                <a class="btn btn-xs btn-danger deleteStudentHomework px-2 py-1" href="#"  
                                                data-row_id="<?=$record->row_id?>" title="Delete"><i class="fa fa-trash"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php }
                                }
                            ?>
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade-scale" id="addHomework">
    <div class="modal-dialog modal-xl" style="max-width:800px">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header bg-blue ">
                <h4 class="modal-title">Send Homework to Students</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2"> 
                <?php echo form_open_multipart('pushNotification/sendHomework');?>
                        <form method="POST" enctype="multipart/form-data">
                            <div id="errorMsg"></div>
                     <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card text-center">
                                        <div class="card-header bg-info h5 text-black m-0 p-0">
                                        Choose send options
                                        </div>
                                        <div class="card-body" style="padding-bottom:1px;">
                                            <div class="row">
                                                <div class="form-group col-lg-6 col-md-12 col-sm-12 for-student">
                                                      <label style="float:left">Date</label>
                                                        <input type="text" class="form-control required datepicker" id="home_work_date"  name="date"   placeholder="Date" value="<?php echo date('d-m-Y'); ?>" autocomplete="off"/ required>
                                                </div> 
                                                <div class="form-group col-lg-6 col-md-12 col-sm-12 for-student student-term">
                                                    <label style="float:left"  for="term_name_select">Select Term*</label>
                                                    <select data-live-search="true" class="form-control" required
                                                        name="term_name" id="term_name_select">
                                                        <option value="">Select Term</option>
                                                        <option value="I PUC">I PUC</option>
                                                        <option value="II PUC">II PUC</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-6 col-md-12 col-sm-12 for-student">
                                                    <label style="float:left"  for="stream_name_select">Select Stream*</label>
                                                    <select  class="form-control " required
                                                        name="stream_name[]" id="streamName" >
                                                       <!-- <option value="">Select Stream</option> 
                                                        <?php 
                                                            if(!empty($streams)){
                                                                foreach ($streams as $stream)
                                                                {
                                                                    echo "<option value='".$stream->stream_name."'>".$stream->stream_name."</option>";
                                                                }
                                                            }
                                                        ?> -->
                                                    </select>
                                                </div>     
                                                
                                                 <div class="form-group col-lg-6 col-md-12 col-sm-12 for-student student-section">
                                                    <label style="float:left"  for="section_name_select">Select Section*</label>
                                                    <select data-live-search="true" class="form-control" required
                                                        name="section_name" id="section_name_select">
                                                        <option value="">Select Section</option>
                                                        <?php 
                                                            if(!empty($SectionInfo)){
                                                                foreach($SectionInfo as $section){
                                                                    echo "<option value='".$section->section_name."'>".$section->section_name."</option>";
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card text-center">
                                        <div class="card-header bg-info h5 text-black m-0 p-0">
                                            Homework Info
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                    <label style="float:left" for="term_name_select">Select Subject*</label>
                                                    <select class="form-control" name="subject[]" id="subject" required>   
                                                        <option value="">Select Subject</option>
                                                        <?php 
                                                            if(!empty($staffSubjectInfo)){
                                                                foreach($staffSubjectInfo as $subject){
                                                                    echo "<option value='".$subject->sub_name."'>".$subject->sub_name."</option>";
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">  
                                                <label style="float:left" for="message">Homework Description*</label>                                                           
                                                <textarea class="form-control" rows="6"
                                                    placeholder="Homework Description"
                                                    id="message" name="message[]" required ><?= set_value('message') ?></textarea>
                                            </div>
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label style="float:left" for="msg_subject">Upload a File (optional)</label>
                                                <input class="form-control" type="file"  accept=".pdf,.doc,.docx,.png,.jpg,.jpeg" name="msg_file[]" id="msg_file" > 
                                            </div>  

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                    <label style="float:left" for="term_name_select">Select Subject</label>
                                                    <select class="form-control" name="subject[]" id="subject">   
                                                        <option value="">Select Subject</option>
                                                        <?php 
                                                            if(!empty($staffSubjectInfo)){
                                                                foreach($staffSubjectInfo as $subject){
                                                                    echo "<option value='".$subject->sub_name."'>".$subject->sub_name."</option>";
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                           
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">  
                                                <label style="float:left" for="message_two">Homework Description</label>                                                           
                                                <textarea class="form-control" rows="6"
                                                    placeholder="Homework Description"
                                                    id="message_two" name="message[]" ><?= set_value('message') ?></textarea>
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label style="float:left" for="msg_subject">Upload a File (optional)</label>
                                                <input class="form-control" type="file"  accept=".pdf,.doc,.docx,.png,.jpg,.jpeg" name="msg_file[]" id="msg_file" > 
                                            </div>  

                                            <input  type="submit" class="btn btn-success font-weight-bold btn-block" value="Send" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                </form>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pushNotification.js" charset="utf-8"></script>
<script type="text/javascript">
$(".student-stream").hide();
const showStream = ()=>{
        $(".student-stream").show();
    }
    const hideStream = ()=>{
        $(".student-stream").hide();
    }
    const showSection = ()=>{
        $(".student-section").show();
    }
    const hideSection = ()=>{
        $(".student-section").hide();
    }
jQuery(document).ready(function() {

    

    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "viewBusListing/" + value);
        jQuery("#byFilterMethod").submit();
    });

    jQuery('.datepicker,.dateSearch,.insurance,.service,.permit,.tax,.fitness').datepicker({
        autoclose: true,
        orientation: "bottom",
        dateFormat: "dd-mm-yy"

    });

    $('[data-toggle="popover"]').popover( { "container":"body", "trigger":"focus", "html":true });
      $('[data-toggle="popover"]').mouseenter(function(){
          $(this).trigger('focus');
      });

      $("#term_name_select").change(function(){
        var term_name = $("#term_name_select").val()
        $('#streamName').prop('disabled', false);
        $('#streamName option:not(:first)').remove();
        $('#streamName option:selected').remove();
        $('#streamName').append('<option value="">Select Stream</option>');
        // $('#exam_type option:selected').remove();
     
        if(this.value != 0){
            $('#streamName').prop('disabled', false);
            $('#streamName option:not(:first)').remove();
            $.ajax({
            url: '<?php echo base_url(); ?>/getStreamSectionByTerm',
            type: 'POST',
            dataType: "json",
            data: { term_name : term_name },

            success: function(data) {
                //var examObject = JSON.parse(data);
                var examObject = JSON.stringify(data)
                var count = data.result.length;
                if(count != 0){
                    for(var i=0; i<=count; i++){
                        $("#streamName").append(new Option(data.result[i].stream_name , data.result[i].stream_name));
                    }
                }else{
                    $('#streamName').prop('disabled', 'disabled');
                }
            }
        });
        }else{
            $('#streamName').prop('disabled', 'disabled');
            $('#streamName option:not(:first)').remove();
            $('#streamName option:selected').remove();
            $('#streamName').append('<option value="">Select Stream & Section</option>');
            // $('#exam_type option:selected').remove();
        }
    });

      $("#term_name_select").on('change',function(){
            let term = $(this).val().toUpperCase();
            if(term =="LKG" || term =="UKG"){
                hideStream();
                hideSection();
            }else if (term =="XI" || term =="XII"){
                showStream();            
            }
            else{
                hideStream();
                showSection();
            }
        });

 
});
 function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;
    return true;
}

jQuery(document).on("click", ".deleteStudentHomework", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "deleteStudentHomework",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Homework ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
					
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Homework successfully deleted"); }
				else if(data.status = false) { alert("Failed to delete Homework"); }
				else { alert("Access denied..!"); }
			});
		}
	});
</script>