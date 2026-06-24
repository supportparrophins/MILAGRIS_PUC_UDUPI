<?php require APPPATH . 'views/includes/db.php'; ?>
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
                            <i class="fa fa-youtube-play"></i> Youtube
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
                                <form action="<?php echo base_url(); ?>viewYoutubeVideos" method="POST" id="byFilterMethod">
                                    <div class="row px-0">
                                        <div class="col-lg-3 col-sm-12 col-md-3">
                                            <div class="form-group position-relative mb-0">
                                                <input class="form-control mobile-width datepicker" value="<?php echo $by_date; ?>" type="text" name="by_date" id="by_date" class="form-control input-sm"  style="text-transform: uppercase" placeholder=" Date" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-12 col-md-3">
                                            <div class="form-group position-relative mb-0">
                                                <input class="form-control mobile-width" value="<?php echo $by_name; ?>" type="text" name="by_name" id="by_name" class="form-control input-sm"  style="text-transform: uppercase" placeholder=" Name" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-12 col-md-3">
                                            <div class="form-group mb-0">
                                                <input class="form-control mobile-width" value="<?php echo $subject_name; ?>" type="text" name="subject_name" id="subject_name" class="form-control input-sm"  style="text-transform: uppercase" placeholder="Subject Name" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-12 col-md-3">
                                            <button type="submit"class="btn btn-success btn-block mobile-width"> Search</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="table-responsive table-bordered table_youtube mb-2">
                                        <table class="table mb-0">
                                            <tr class="text-center table_row_backgrond">
                                                <th width="200">Date</th>
                                                <th>Name</th>
                                                <th>Subject</th>
                                                <th>Action</th>
                                            </tr>
                                            <?php if(!empty($videoInfo)){
                                            foreach($videoInfo as $video){ 
                                                $url = str_replace('watch?v=','embed/', $video->link);
            
                                    
                                                if (strpos($video->link, 'https://youtu.be/') !== false) {
                                                    $url = str_replace('https://youtu.be/','https://www.youtube.com/embed/', $video->link);
                                                
                                                }
                                                if (strpos($url, '?autoplay=1') == false) {
                                                    $url = $url.'?autoplay=1';
                                                }
                                                ?>
                                                <tbody>
                                                    <th class="text-center"><?php echo date('d-m-Y',strtotime($video->date)); ?></th>
                                                    <th><?php echo $video->video_name; ?></th>
                                                    <th class="text-center"><?php echo $video->subject_name; ?></th>
                                                    <th class="text-center"><button type="button" class="btn btn-primary p-2" data-toggle="modal" data-target="#videoModal" onclick="openModel('<?php echo $url; ?>')"><i class="fa fa-eye"></i></button></th>
                                                </tbody>
                                            <?php } } ?> 
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


    <div class="modal fade" id="videoModal">
        <div class="modal-dialog modal-lg" role="document">
                <button type="button" class="close btn-round btn-primary" data-dismiss="modal" aria-label="Close" style="font-size: 45px;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="modal-video">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item video_link" src=""
                                        webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
$(document).ready(function() {
    $('#videoModal').on('hidden.bs.modal', function () {
        $("#videoModal iframe").attr("src", $("#videoModal iframe").attr("src"));
    });
});


function openModel(video_link){
    $('.modal-body .video_link').attr('src', video_link);
    // $('#addClassInfo').modal('show');
}

jQuery(document).ready(function(){
    jQuery('.datepicker').datepicker({
        autoclose: true,
        format : "dd-mm-yyyy",
        endDate : "today"
    });
    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "viewYoutubeVideos/" + value);
        jQuery("#byFilterMethod").submit();
    });
});
</script>