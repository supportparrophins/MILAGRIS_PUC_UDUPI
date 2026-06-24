<style>


.form-control {
    border: 1px solid #000000 !important;
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
                            <div class=" col-12 col-md-6 box-tools">
                                <span class="page-title">
                                <i class="material-icons">poll</i> Election 2020-21
                                </span>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12" style="font-size: 20px;">
                                Total: <?php echo $electionRecordsCount; ?>

                                <a onclick="showLoader();window.history.back();"
                                    class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                    <a class="btn btn-md btn-primary mobile-btn float-right mb-1 border_right_radius text-white" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Add New</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 ">
            <div class="col-12">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2 table-responsive">
                        <table style="width:100%" class="display table  table-bordered table-striped table-hover mb-0">
                            <thead>
                                <tr class="table_row_backgrond text-center">
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Post Name</th>
                                    <th>Course</th>
                                    <th>Election Date</th>
                                    <th>Vote</th>
                                    <th>Action</th>
                                </tr>
                                <tr class="row_filter">
                                    <form action="<?php echo base_url() ?>electionDetails" method="POST"
                                        id="byFilterMethod">
                                       
                                       
                                        <th style="padding: 1px;"> 
                                            <select id="application_no" name="application_no" class="form-control" placeholder="By Student ID" data-live-search="true" utocomplete="off">
                                            <?php if(!empty($application_no)){?>
                                            <option value="<?php echo $application_no; ?>" selected>Selected:<?php echo $application_no; ?></option>     
                                            <?php }?>
                                             <option value="">Select Student ID</option>
                                                            <?php if(!empty($studentInfo)){
                                                        foreach($studentInfo as $std){ ?>
                                                    <option value="<?php echo $std->student_id; ?>"><?php echo $std->student_id; ?></option>
                                                    <?php } } ?>
                                            </select>

                                        </th>
                                        <th style="padding: 1px;"> 
                                        </th>
                                         <th style="padding: 1px;">
                                         <select id="post_name" name="post_name" class="form-control is-valid" placeholder="By Post Name">
                                                <?php if(!empty($post_name)){?>
                                                <option value="<?php echo $post_name; ?>" selected>Selected:<?php echo $post_name; ?></option>     
                                                    <?php }?>
                                                <option value="">Select Post Name</option>
                                                      <?php if(!empty($postInfo)){
                                                        foreach($postInfo as $post){ ?>
                                                 <option value="<?php echo $post->post_name; ?>"><?php echo $post->post_name; ?></option>
                                                                <?php } } ?>
                                            </select>

                                        </th>
                                        <th style="padding: 1px;">
                                            <select id="program_name" name="program_name" class="form-control is-valid" placeholder="By Post Name">
                                                <?php if(!empty($program_name)){?>
                                                <option value="<?php echo $program_name; ?>" selected>Selected:<?php echo $program_name; ?></option>     
                                                    <?php }?>
                                                <option value="">Select Course</option>
                                                <option value="ALL">ALL</option>
                                                <option value="SCIENCE">SCIENCE</option>
                                                <option value="COMMERCE">COMMERCE</option>
                                                <option value="ARTS">ARTS</option>
                                            </select> 

                                        </th>

                                        <th style="padding: 1px;"> <input type="text" name="election_date"
                                                id="election_date" value="<?php echo $election_date ?>"
                                                class="form-control input-sm pull-right dateBy" placeholder="Search Date" autocomplete="off" />
                                        </th>


                                                            <th></th>
                                        <th style="padding: 1px;" class="text-center"><button type="submit"
                                                class="btn btn-success btn-md btn-block"><i class="fa fa-filter"></i>
                                                Filter</button></th>
                                    </form>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if(!empty($studentElectionRecords)) {
                                    foreach($studentElectionRecords as $record) {
                                ?> <tr>
                                    
                                    <th class="text-center"><?php echo $record->application_no; ?></th>
                                    <th class="text-left"><?php echo $record->student_name ?></th>
                                    <th class="text-left"><?php echo $record->post_name ?></th>
                                    <th class="text-center"><?php echo $record->program_name ?></th>
                                    <th class="text-center"><?php echo date('d-m-Y',strtotime($record->election_date)); ?></th>
                                    <th class="text-center"><?php echo $voteCount[$record->row_id] ?></th>
                                    <th class="text-center">
                                       
                                        <a class="btn btn-xs btn-info" href="<?php echo base_url(); ?>editStudentElection/<?php echo $record->row_id; ?>"
                                            title="Edit Student Election"><i class="fas fa-pencil-alt"></i></a>
                                    <a class="btn btn-xs btn-danger deleteStudentElection" href="#"
                                        data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i
                                            class="fa fa-trash"></i></a>
                                    </th>
                                </tr>
                                <?php }
                                 }  else { ?>
                            <tr>
                                <th colspan="7" class="text-center">Candidate not found</th>
                            </tr>
                            <?php } ?>

                            </tbody>
                            <tfoot>
                                <tr class="table_row_backgrond text-center">
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Post Name</th>
                                    <th>Course</th>
                                    <th>Election Date</th>
                                    <th>Vote</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                    <div class="card-footer text-center p-1">
                        <span class="float-right"><?php echo $this->pagination->create_links(); ?></span>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>


<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Add New Candidate</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form method="POST" action="<?php echo base_url().'addNewStudentElection'?>">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="application_no">Student ID</label>
                                <select class="form-control selectpicker"  id="application_no" name="application_no" data-live-search="true" required>
                                <option value="">Select Student ID</option>
                                        <?php if(!empty($studentInfo)){
                                    foreach($studentInfo as $std){ ?>
                                <option value="<?php echo $std->student_id; ?>"><?php echo $std->student_id.' - '.$std->student_name; ?></option>
                                <?php } } ?>
                             </select> 
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="post_name">Post Name</label>
                                 <select class="form-control"  id="post_name" name="post_name" required>
                                        <option value="">Select Post Name</option>
                                                <?php if(!empty($postInfo)){
                                            foreach($postInfo as $post){ ?>
                                        <option value="<?php echo $post->post_id; ?>"><?php echo $post->post_name; ?></option>
                                        <?php } } ?>
                                </select> 
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="program_name">Course</label>
                                 <select class="form-control"  id="program_name" name="program_name" required>
                                        <option value="">Select Course</option>
                                        <option value="ALL">ALL</option>
                                        <option value="SCIENCE">SCIENCE</option>
                                        <option value="COMMERCE">COMMERCE</option>
                                        <option value="ARTS">ARTS</option>
                                </select> 
                                
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Election Date</label>
                                <input name="election_date" type="text" class="electionDate form-control" id="election_date" placeholder="Select Election Date" required autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer" style="padding:5px;">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>assets/js/common.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    // $(".reason_unqualified").hide();

    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "electionDetails/" + value);
        jQuery("#byFilterMethod").submit();
    });

   jQuery('.electionDate,.dateBy').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",

    })

    
});


</script>