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
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class="col-lg-5 col-6 col-md-4 col-sm-4 box-tools">
                                <span class="page-title">
                                    <i class="fas fa-clock"></i> Latecomer
                                </span>
                            </div>
                            <div class="col-lg-3 col-6 col-md-4 col-sm-4">
                                <b class="text-dark" style="font-size: 20px;">Total:
                                    <?php echo $lateComerCount; ?></b>
                            </div>
                            <div class="col-lg-4 col-12 col-md-4 col-sm-4">
                                <a onclick="showLoader();window.history.back();"
                                    class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-clock-o"></i> Back </a>
                                <!-- <a class="btn btn-primary pull-right mobile-btn border_right_radius" href="#"
                                    data-toggle="modal" data-target="#concessionModal">
                                    <i class="fa fa-plus"></i> Add</a> -->

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
                            <form action="<?php echo base_url(); ?>viewLatecomerInfo" method="POST" id="byFilterMethod">
                                <tr class="filter_row" class="text-center">
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" name="by_date" id="lateDate" value="<?php echo $by_date ?>" class="form-control input-sm pull-right"  
                                            style="text-transform: uppercase" placeholder="By Date"/>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" name="student_id" id="student_id" value="<?php echo $student_id ?>" class="form-control input-sm pull-right"  
                                            style="text-transform: uppercase" placeholder="By Student ID"/>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" name="student_name" id="student_name" value="<?php echo $student_name ?>" 
                                            class="form-control input-sm pull-right"  style="text-transform: uppercase" placeholder="By Name"/>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <select class="form-control  input-sm" id="section_name" name="section_name" >
                                                <?php if(!empty($section_name)){ ?>
                                                    <option value="<?php echo $section_name; ?>" selected>Selected: <?php echo $section_name; ?></option>
                                                <?php } ?>
                                                <option value="" >Select Section</option>
                                                <option value="A" >A</option>
                                                <option value="B" >B</option>
                                                <option value="C" >C</option>
                                                <option value="D" >D</option>
                                                <option value="E" >E</option>
                                                <option value="F" >F</option>
                                                <option value="G" >G</option>
                                                <option value="H" >H</option>
                                                <option value="I" >I</option>
                                                <option value="J" >J</option>
                                                <option value="K" >K</option>
                                                <option value="L" >L</option>
                                                <option value="M" >M</option>
                                                <option value="N" >N</option>
                                                <option value="O" >O</option>
                                                <option value="P" >P</option>
                                                <option value="Q" >Q</option>
                                                <option value="R" >R</option>
                                                <option value="S" >S</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <select class="form-control input-sm" id="by_term" name="by_term">
                                                <?php if($by_term != ""){ ?>
                                                    <option value="<?php echo $by_term; ?>" selected><b>Sorted: <?php echo $by_term; ?></b></option>
                                                <?php } ?>
                                                <option value="" >By Term</option>
                                                <option value="I PUC" >I PUC</option>
                                                <option value="II PUC" >II PUC</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" name="by_intime" id="by_intime" value="<?php echo $by_intime ?>" 
                                            class="form-control input-sm pull-right"  style="text-transform: uppercase" placeholder="By In-Time"/>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-success btn-block mobile-width"><i
                                                class="fa fa-filter"></i> Filter</button>
                                    </td>
                                </tr>
                            </form>
                            <thead>
                                <tr class="text-center table_row_background">
                                    <th>Date</th>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Section</th>
                                    <th>Term</th>
                                    <th>In Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($lateComerRecords)){
                                    foreach($lateComerRecords as $record){ ?>
                                <tr>
                                    <th class="text-center" width="180"><?php echo date("d-m-Y", strtotime($record->date))?></th>
                                    <th width="330"><?php echo $record->student_id ?></th>
                                    <th width="330"><?php echo strtoupper($record->student_name) ?></th>
                                    <th class="text-center" width="150"><?php echo $record->section_name ?></th>
                                    <th class="text-center" width="150"><?php echo $record->term_name ?></th>
                                    <th><?php echo $record->intime ?></th>
                                    <th width="180" class="text-center">
                                        <?php if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR) { ?>
                                            <a class="btn btn-sm btn-danger deleteLatecomer" href="#" data-row_id="<?php echo $record->id; ?>" title="Delete">
                                            <i class="fa fa-trash"></i></a>
                                        <?php } ?>
                                    </th>
                                </tr>
                                <?php } }else{  ?>
                                <tr>
                                    <th colspan="8" class="text-center">Fee Concession Record Not Found</th>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="float-right">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="concessionModal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="padding: 7px 15px;">
                    <h4 class="modal-title">Add New Concession</h4>
                    <button type="button" class="close float-right" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body p-2">
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addConcessionInfo" action="<?php echo base_url() ?>addConcession"
                        method="post" role="form">
                        <div class="row form-contents">
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label>Select Student <span class="text-danger">*</span></label>
                                    <select class="form-control selectpicker" data-live-search="true"
                                        name="application_no" id="student_row_id" required autocomplete="off">
                                        <option value="">Select Student</option>
                                        <?php if(!empty($studentInfo)){
                                            foreach($studentInfo as $std){  ?>
                                        <option value="<?php echo $std->application_no; ?>">
                                            <b><?php echo $std->student_id.' - '.$std->student_name; ?></b></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-2">
                                    <label>Enter Concession Amount <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control " id="fee_amount" name="fee_amount"
                                        placeholder="Enter Concession Amount" onkeypress="return isNumberKey(event)"
                                        required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-0">
                                    <label>Enter Description <span class="text-danger">*</span></label>
                                    <textarea type="text" class="form-control" id="description" name="description"
                                        rows="5" placeholder="Enter Description" required autocomplete="off"
                                        maxlength="1500"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer" style="padding: 7px 15px;">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" form="addConcessionInfo" class="btn btn-success pull-right" value="Save" />
                </div>

            </div>
        </div>
    </div>


</div>


<!-- The Modal -->
<div class="modal" id="downloadLatecomerInfo">
  <div class="modal-dialog ">
    <div class="modal-content ">

      <!-- Modal Header -->
      <div class="modal-header bg-blue ">
      <div class="row">
      <div class="col-lg-11">
      <h4 class="modal-title">Download Latecomer Info</h4>
      </div>
      <div class="col-lg-1">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      </div>    
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <form action="" method="POST" id="searchList">
      <div class="text-center" id="alertMsg"></div>        
      <div class="row">
        <div class="col-lg-6">
        <label for="role">Date From</label>
            <input type="text" name="date_from" id="date_from"  class="form-control from-date"  style="text-transform: uppercase" placeholder="Date From"/>
        </div>

        <div class="col-lg-6">
        <label for="role">Date To</label>
            <input type="text" name="date_to" id="date_to"  class="form-control to-date"  style="text-transform: uppercase" placeholder="Date From"/>
        </div>
     </div>

     <div class="row">
        <div class="col-lg-6">
        <label for="role">Total Late Count</label>
            <input type="text" name="late_count" id="late_count"  class="form-control"  style="text-transform: uppercase" placeholder="Total Late count (eg:2)"/>
        </div>

        <div class="col-lg-6">
        <label for="role">Term Name</label>
        <select class="form-control " id="term_name" name="term_name">
                  <option value="I PUC" >I PUC</option>
                  <option value="II PUC" >II PUC</option>
            </select>
        </div>
     </div>
     
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><span aria-hidden="true">&times;</span> Close</button>
        <button id="latecomerInfoDownload" type="button" class="btn btn-md btn-primary" ><i class="fa fa-download"></i> Download</button>
      </div>
      </form>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/fee.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "viewLatecomerInfo/" + value);
        jQuery("#byFilterMethod").submit();
    });

    jQuery('.datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy",
        startDate: "01-11-2020",
        endDate: "today"
    });

    //checkbox select
    $('#selectAll').click(function() {
        if ($('#selectAll').is(':checked')) {
            $('.singleSelect').prop('checked', true);
        } else {
            $('.singleSelect').prop('checked', false);
        }
    });

    
	jQuery(document).on("click", ".deleteLatecomer", function(){
        var row_id = $(this).data("row_id"),
        hitURL = baseURL + "deleteLatecomer",
        currentRow = $(this);
        var confirmation = confirm("Are you sure to delete this record ?");
        if(confirmation) {
            jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : { 
                row_id : row_id, 
            } 
            }).done(function(data){
                //  $('#tr'+application_number).html('<b id="tr'+application_number+'" style="color:green">Approved</b>');
                if(data.status = true) { 
                    alert("Record Deleted Successfully."); 
                    window.location.reload();  }
                else if(data.status = false) { alert("Failed to delete"); }
                else { alert("Access denied..!"); }
            });
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
</script>