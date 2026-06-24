<?php require APPPATH . 'views/includes/db.php'; ?>
<style>
.popover-header {
    padding: 10px 15px;
    font-size: 0.9rem !important;
    color: black !important;
    line-height: 14px;
    background-color: #c2efa4 !important;
    border-bottom: 1px solid #c2efa4;
    border-top-left-radius: calc(.5rem - 1px);
    border-top-right-radius: calc(.5rem - 1px);
}
.popover-body {
    padding: 10px 10px;
    color: #000000 !important;
    font-size: 14px !important;
    background: #bcdef0 !important;
}
</style>
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
    $noMatch = $this->session->flashdata('nomatch');
    if($noMatch)
    {
?>
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo $this->session->flashdata('nomatch'); ?>
</div>
<?php } ?>

<div class="row">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container container-fluid px-4">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mt-1 mb-2">
            <div class="col padding_left_right_null">
                <div class="card card-small p-0 card_head_dashboard">
                    <div class="card-body p-2 ml-2">
                        <span class="page-title">
                            <i class="fa fa-youtube-play"></i> Online Class
                        </span>
                        <a onclick="window.history.back(); return false;"
                            class="btn btn-primary float-right text-white pt-2" value="Back">Back </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="row form-employee">
        <div class="col-12 padding_left_right_null">
            <div class="card card-small c-border mb-4 px-3 py-2">
                <div class="row">
                    <div class="col profile-head">
                   
                        <div class="row">
                            <div class="table-responsive table-bordered table_youtube mb-2">
                                <table class="table mb-0">
                                    <tr class="text-center table_row_backgrond">
                                      
                                        <th>Subject</th>
                                        <th>Staff</th>
                                        <th>Application</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                    <?php if(!empty($onlineClassInfo)){
                                            foreach($onlineClassInfo as $on){ 
                                        
                                                ?>
                                    <tbody>
                                       
                                        <th class="text-center"><?php echo $on->subject_name; ?></th>
                                        <th class="text-center"><?php echo $on->name; ?></th>
                                        <th class="text-center"><?php echo $on->application_type; ?></th>
                                        <th>
                                            <a  title="Class Description" href="#" data-container="body"
                                            data-toggle="popover" data-trigger="focus" data-placement="left"
                                                data-content="<?php echo $on->description; ?>">
                                                Click Here..
                                            </a>

                                        </th>

                                        <th class="text-center"><a type="button" class="btn btn-primary p-2"
                                                target="_blank" href="<?php echo $on->class_link; ?>"><i
                                                    class="fa fa-eye"></i> Join </a></th>
                                    </tbody>
                                    <?php } }else{ ?>
                                    <tr>
                                        <th colspan="8" class="text-center"> Online Class not found!</th>
                                    </tr>
                                    <?php } ?>
                                </table>
                            </div>
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                </div>
                </ul>
            </div>
        </div>
    </div>


</div>
<script>
$(document).ready(function() {
    $('#videoModal').on('hidden.bs.modal', function() {
        $("#videoModal iframe").attr("src", $("#videoModal iframe").attr("src"));
    });
});


function openModel(video_link) {
    $('.modal-body .video_link').attr('src', video_link);
    // $('#addClassInfo').modal('show');
}

jQuery(document).ready(function() {
    jQuery('.datepicker').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        //endDate : "today"
    });
    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "viewYoutubeVideos/" + value);
        jQuery("#byFilterMethod").submit();
    });
    $(function() {
        $('[data-toggle="popover"]').popover()
    })
});
</script>