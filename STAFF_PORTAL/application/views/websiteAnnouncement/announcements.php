
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
                        <div class="row c-m-b">
                            <div class="col-lg-5 col-12 col-md-12 box-tools">
                                <span class="page-title">
                                <i class="fa fa-bell"></i> Announcement
                                </span>
                            </div>
                            <div class="col-lg-3 col-6 col-md-6 col-sm-6">
                                <b class="text-dark" style="font-size: 20px;">Total : <?php echo $count_announcement ?></b>
                            </div>
                            <div class="col-lg-4 col-6 col-md-6 col-sm-6">

                                <a
                                    class="btn primary_color mobile-btn float-right text-white border_left_radius btn-backtrack"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                            
                                <a class="btn btn-primary mobile-btn float-right border_right_radius"
                                href="<?php echo base_url(); ?>addNewMessage"><i class="fa fa-plus"></i>
                                Add New</a>
                                
                            </div>
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
                        <form action="<?php echo base_url(); ?>announcementListing" method="POST" id="byFilterMethod">
                                <tr class="filter_row" class="text-center">
                                
                                    <td width="180">
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $by_date; ?>" name="by_date" id="by_date" class="form-control input-sm datepicker" placeholder=" Date" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                    </td>
                                   
                                    <td>
                                    </td>
                                  

                                    
                                    <td>
                                        <button type="submit"class="btn btn-success btn-block mobile-width"><i class="fa fa-filter"></i> Filter</button>
                                    </td>
                                </tr>
                            </form>
                            <thead>
                                <tr class="table_row_background text-center">
                                    <th width="180">Date</th>
                                    <th>Message</th>
                                    <th>Link</th>
                                    <th width="180">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($announcementInfo)){
                                    foreach($announcementInfo as $record){ ?>
                                    <tr>
                                        <th width="180" class="text-center"><?php echo date('d-m-Y',strtotime($record->date)); ?></th>
                                        <th class="text-left"><?php echo $record->message; ?></th>
                                        <th class="text-left"><?php echo $record->link; ?></th>
                                      
                                     
                                        <th class="text-center">
                                           
                                            
                                                    <a class="btn btn-xs btn-info"
                                                href="<?php echo base_url(); ?>editMessage/<?php echo $record->row_id; ?>" title="Edit"><i
                                                    class="fas fa-pencil-alt"></i></a>
                                                    <?php if($record->status == 1){ ?>
                                                        <a class="btn btn-xs btn-danger disableAnnouncement" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Disable"><i class="fa fa-ban"></i></a>
                                                    <?php }else{ ?>
                                                        <a class="btn btn-xs btn-success enableAnnouncement" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Enable"><i class="fa fa-check"></i></a>
                                                    <?php }  ?>
                                        </th>
                                    </tr>
                                <?php } }else{  ?>
                                <tr>
                                    <th colspan="10" class="text-center">Announcement Not Found</th>
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
</div>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/websiteCommon.js" charset="utf-8"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "announcementListing/" + value);
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

   
});
</script>