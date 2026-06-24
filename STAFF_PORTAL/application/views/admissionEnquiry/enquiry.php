<?php
            $this->load->helper('form');
            $error = $this->session->flashdata('error');
            if($error)
            {
        ?>
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo $this->session->flashdata('error'); ?>
</div>
<?php } ?>
<?php  
            $success = $this->session->flashdata('success');
            if($success)
            {
        ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo $this->session->flashdata('success'); ?>
</div>
<?php } ?>

<?php  
    $warning = $this->session->flashdata('warning');
    if($warning)
    {
?>
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo $this->session->flashdata('warning'); ?>
</div>
<?php } ?>


 <div class="main-content-container px-3 pt-1">
    <div class="row">
        <div class="col-md-12">
            
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
        </div>
    </div>

     <!-- Content Header (Page header) -->
    <div class="row p-0">
        <div class="col column_padding_card">
            <div class="card card-small card_heading_title p-0 m-b-1">
                <div class="card-body p-2">
                    <div class="row c-m-b">
                    <div class="col-8 col-sm-4 col-md-5">
                            <span class="page-title absent_table_title_mobile">
                            <i class="fas fa-phone-square-alt"></i> Admission Enquiry
                            </span>
                    </div>

                   <div class="col-4 col-sm-4 col-md-3">
                        <div class="text-center text-dark">
                      
                            <b class="pull-left" style="font-size: 20px;">Total : <?php echo $totalCount ?></b>
                        </div>
                    </div> 

                    <div class="col-12 col-sm-4 col-md-4 box-tools">
                        <a onclick="showLoader();window.history.back();" class="btn btn-md primary_color border_left_radius mobile-btn float-right text-white pt-2"
                            value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                               
                        <a class="btn btn-primary mobile-btn float-right border_right_radius"
                            href="<?php echo base_url(); ?>addNewAdmission"><i class="fa fa-plus"></i>Add New</a>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="row form-employee">
        <div class="col-12 column_padding_card">
            <div class="card card-small c-border p-1">
                <div class="table-responsive">
                    <table class="table table-bordered text-dark">
                            
                        <form action="<?php echo base_url() ?>enquiryListing" method="POST" id="searchList">
                       
                           <tr class="filter_row">
                                <th>
                                    <div class="form-group"> 
                                        <input type="text" name="by_name" value="<?php echo $by_name; ?>" class="form-control form-control-md datepicker pull-right" placeholder="By Name" autocomplete="off"/>
                                    </div>
                                </th>
                                <td>
                                    <div class="form-group mb-0">
                                        <select class="form-control" name="by_term_name" id="by_term_name">
                                            <?php if(!empty($by_term_name)){ ?>
                                                <option value="<?php echo $by_term_name; ?>" selected><b>Selected: <?php echo $by_term_name; ?></b></option>
                                            <?php } ?>
                                            <option value="">By Term</option>
                                            <option value="PU1">PU1</option>
                                            <option value="PU2">PU2</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group mb-0">
                                        <select class="form-control" name="by_stream_name" id="by_stream_name">
                                            <?php if(!empty($by_stream)){ ?>
                                                <option value="<?php echo $by_stream_name; ?>" selected><b>Selected: <?php echo $by_stream; ?></b></option>
                                            <?php } ?>
                                            <option value="">By Stream</option>
                                            <?php if(!empty($streamInfo)){
                                                foreach($streamInfo as $stream){ ?>
                                            <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                            <?php } } ?>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group mb-0">
                                        <select class="form-control" name="by_elective_sub" id="by_elective_sub">
                                            <?php if(!empty($by_elective_sub)){ ?>
                                                <option value="<?php echo $by_elective_sub; ?>" selected><b>Selected: <?php echo $by_elective_sub; ?></b></option>
                                            <?php } ?>
                                            <option value="">By Language</option>
                                            <option value="Kannada">Kannada</option>
                                            <option value="Hindi">Hindi</option>
                                            <option value="French">French</option>
                                        </select>
                                    </div>
                                </td>

                                <th>
                                <div class="form-group"> 
                                    <input type="text" name="by_email" value="<?php echo $by_email; ?>" class="form-control form-control-md datepicker pull-right" placeholder="By Email" autocomplete="off"/>
                                </div>
                                </th>
                                <th>
                                <div class="form-group"> 
                                    <input type="text" name="by_phone_no" value="<?php echo $by_phone_no; ?>" class="form-control form-control-md datepicker pull-right" placeholder="By Mobile No" autocomplete="off"/>
                                </div>
                                </th>
                                
                                <th> <button class="btn btn-block btn-success "><i class="fa fa-filter"></i> Filter </button></th>
                           </tr>
                        </form>
                        <thead class="text-center">
                            <tr class="table_row_background">
                                <th width="260">Name</th>
                                <th>Term name</th>
                                <th>Stream name</th>
                                <th>Language</th>
                                <th>Email</th>
                                <th>Mobile No.</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <thead>
                            <?php if(!empty($enquiryInfo)) {
                                foreach($enquiryInfo as $enquiry) { ?>
                            <tr>
                                <td><?php echo $enquiry->name ?></td>
                                <td class="text-center"><?php echo $enquiry->term_name; ?></td>
                                <td class="text-center"><?php echo $enquiry->stream_name; ?></td>
                                <td class="text-center"><?php echo $enquiry->elective_sub; ?></td>
                                <td class="text-center"><?php echo $enquiry->email; ?></td>
                                <td class="text-center"><?php echo $enquiry->phone_no; ?></td>
                                <td class="text-center">
                                <a href="#" class="btn btn-xs btn-success" title="<b><?php echo $enquiry->name ?></b>" data-toggle="popover" data-placement="left"  data-trigger="focus" data-content=" <b>Course : <?php echo $enquiry->program_name; ?></b><br><b>Hostel Facility: <?php echo $enquiry->hostel_facility; ?></b><br/<b>Institution Name: <?php echo $enquiry->current_institution_name; ?><br> </b>
                                                        <b>Exam Coaching : <?php echo $enquiry->exam_coaching; ?></b><br> <b>Any Comments: <?php echo $enquiry->comment; ?></b>"><i class="fa fa-info"></i></a>
                                    <a class="btn btn-xs btn-info" href="<?php echo base_url(); ?>editAdmission/<?php echo $enquiry->row_id; ?>" title="Edit Admission"><i class="fas fa-pencil-alt"></i></a>
                                    <a class="btn btn-xs btn-danger deleteEnquiry" href="#" data-row_id="<?php echo $enquiry->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php } }else{ ?>
                            <tr class="table-info">
                                <td class="text-center" colspan="6">Record Not Found</td>
                            </tr>
                            <?php } ?>
                        </thead>
                    </table>
                 </div>
                <div class="row">
                    <div class="col-12">
                        <span class="float-right"><?php echo $this->pagination->create_links(); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/enquiry.js" charset="utf-8"></script>
<script>
jQuery(document).ready(function(){

jQuery('ul.pagination li a').click(function (e) {
    e.preventDefault();            
    var link = jQuery(this).get(0).href;            
    var value = link.substring(link.lastIndexOf('/') + 1);
    jQuery("#searchList").attr("action", baseURL + "enquiryListing/" + value);
    jQuery("#searchList").submit();
});

$('[data-toggle="popover"]').popover( { "container":"body", "trigger":"focus", "html":true });
      $('[data-toggle="popover"]').mouseenter(function(){
          $(this).trigger('focus');
      });


});
</script>