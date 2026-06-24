<?php
    $this->load->helper('form');
    $error = $this->session->flashdata('error');
    if($error){ ?>
    <div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<?php echo $this->session->flashdata('error'); ?>
    </div>
<?php } ?>
<?php  
    $success = $this->session->flashdata('success');
    if($success) { ?>
    <div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<?php echo $this->session->flashdata('success'); ?>
    </div>
<?php } ?>

<?php  
    $warning = $this->session->flashdata('warning');
    if($warning) { ?>
    <div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<?php echo $this->session->flashdata('warning'); ?>
    </div>
<?php } ?>

<div class="row">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>

<?php
    if($by_date != '01-01-1970'){
        $byDate = date('d-m-Y',strtotime($by_date));
    }else{
        $byDate = '';
    }
?>
<div class="main-content-container px-3 pt-1">
    <div class="row p-0">
        <div class="col column_padding_card">
            <div class="card card-small card_heading_title p-0 m-b-1">
                <div class="card-body p-2">
                    <div class="row c-m-b">
                        <div class="col-lg-4 col-sm-4 col-6">
                            <span class="page-title absent_table_title_mobile">
                                <i class="fab fa-youtube"></i> Video
                            </span>
                        </div>
                        <div class="text-center col-lg-4 col-sm-3 col-6">
                            <b style="font-size: 20px;color: black;">Total Links: <?php echo $videoRecordsCount; ?></b>
                        </div>

                        <div class="col-lg-4 col-sm-5 col-12 box-tools"> 
                            <a onclick="showLoader();window.history.back();" class="btn primary_color border_left_radius mobile-btn float-right text-white pt-2"
                                value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                            <?php if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_TEACHING_STAFF || $role == ROLE_LIBRARY || $role == ROLE_PRINCIPAL || $role == VICE_PRINCIPAL || $role == ROLE_SUPER_ADMIN) { ?>
                                <button class="btn btn-md btn-primary mobile-btn float-right mb-1 border_right_radius" data-toggle="modal" 
                                data-target="#addNewDocModel"><i class="fa fa-plus"></i> Add New</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row form-employee">
        <div class="col-12 column_padding_card">
            <div class="card card-small c-border p-2">
                <div class="table-responsive">
                    <table class="table table-bordered text-dark mb-0">
                        <tr class="row_filter">
                            <form action="<?php echo base_url() ?>viewYoutube" method="POST" id="byFilterMethod">
                                <th>
                                    <input type="text" name="by_date" id="by_date" value="<?php echo $byDate; ?>"
                                        class="form-control input-sm pull-right datepicker"
                                        style="text-transform: uppercase" placeholder="By Date"
                                        autocomplete="off" />
                                </th>
                                <th>
                                    <input type="text" name="video_name" id="video_name"
                                        value="<?php echo $video_name ?>" class="form-control input-sm pull-right"
                                        style="text-transform: uppercase" placeholder="By Name"
                                        autocomplete="off" />
                                </th>
                                <th>
                                    <select class="form-control input-sm" id="term_name" name="term_name"
                                        autocomplete="off">
                                        <?php if(!empty($term_name)){ ?>
                                        <option value="<?php echo $term_name; ?>" selected><b>Sorted:
                                                <?php echo $term_name; ?></b></option>
                                        <?php } ?>
                                        <option value="">By Term</option>
                                        <option value="I PUC">I PUC</option>
                                        <option value="II PUC">II PUC</option>
                                    </select>
                                </th>
                                <th> <input type="text" name="stream_name" id="stream_name"
                                        value="<?php echo $stream_name ?>" class="form-control input-sm pull-right"
                                        style="text-transform: uppercase" placeholder="By Stream"
                                        autocomplete="off" /></th>
                                <th>
                                    <select class="form-control input-sm" id="subject_name" name="subject_name" required>
                                        <?php if(!empty($subject_name)){ ?>
                                        <option value="<?php echo $subject_name; ?>">Selected: <?php echo $subject_name; ?></option>
                                        <?php } ?>
                                        <option value="">Select Subject</option>
                                        <?php if(!empty($subjectInfo)){ 
                                            foreach($subjectInfo as $subject){ ?>
                                        <option value="<?php echo $subject->name; ?>"><?php echo $subject->name; ?></option>
                                        <?php } } ?>
                                    </select>
                                </th>
                                <th></th>


                                <th class="text-center"><button type="submit"
                                    class="btn btn-success btn-md btn-block"><i class="fa fa-filter"></i> Filter</button></th>
                            </form>
                        </tr>
                            <tr class="table_row_background text-center">
                                <th>Date</th>
                                <th>Name</th>
                                <th>Term</th>
                                <th>Stream</th>
                                <th>Subject</th>
                                <th>Link</th>
                                <th>Actions</th>
                            </tr>
                            <?php if(!empty($videoInfo)) {
                                foreach($videoInfo as $record) { 
                                    $url = str_replace('watch?v=','embed/', $record->link);
                                        if (strpos($record->link, 'https://youtu.be/') !== false) {
                                            $url = str_replace('https://youtu.be/','https://www.youtube.com/embed/', $record->link);
                                        }
                                        if (strpos($url, '?autoplay=1') == false) {
                                            $url = $url.'?autoplay=1';
                                        }
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo date('d-m-Y',strtotime($record->date)); ?></td>
                                    <td><?php echo $record->video_name; ?></td>
                                    <td class="text-center"><?php echo $record->term_name; ?></td>
                                    <td class="text-center"><?php echo $record->stream_name; ?></td>
                                    <td class="text-center"><?php echo $record->subject_name; ?></td>
                                    <td><?php echo $url; ?></td>
                                    <td class="text-center" width="140">

                                        <a class="btn btn-sm btn-info px-2 py-1 mb-1"
                                            href="<?php echo base_url() ?>editYoutube/<?php echo $record->row_id; ?>"
                                            title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                        <a class="btn btn-sm btn-danger deleteYoutube px-2 py-1 mb-1" href="#"
                                            data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i
                                                class="fa fa-trash"></i></a>

                                        <button type="button" class="btn btn-primary btn-sm px-2 py-1 mb-1" data-toggle="modal"
                                            data-target="#videoModal" onclick="openModel('<?php echo $url; ?>')">Play <i
                                                class="fa fa-play"></i></button>
                                    </td>
                                </tr>
                            <?php } } else { ?>
                            <tr class="card_heading_title text-dark">
                                <td colspan="7" class="text-center"> Video not found!</td>
                            </tr>
                            <?php } ?>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="videoModal">
    <div class="modal-dialog ">
        <div class="modal-content ">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Play Video</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-1">
                <div class="modal-video">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item video_link" src="" webkitallowfullscreen mozallowfullscreen
                            allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- The Modal -->
<div class="modal" id="addNewDocModel">
    <div class="modal-dialog ">
        <div class="modal-content ">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add New Link</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form action="<?php echo base_url() ?>addYoutubeToDB" method="post" role="form">
                    <div class="text-center" id="alertMsg"></div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" placeholder="Video Name" id="video_name"
                                    class="form-control required " name="video_name" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input class="form-control" placeholder="Date" value="<?php echo date('d-m-Y'); ?>"
                                    id="date" name="date" autocomplete="off" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <select class="form-control input-sm" id="term_name" name="term_name" required>
                                    <option value="">Select Term</option>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <select class="form-control input-sm selectpicker" id="stream_name" name="stream_name[]" multiple required>
                                    <option value="">Select Stream</option>
                                    <option value="ALL">ALL</option>

                                    <?php if(!empty($streamInfo)){ 
                                        foreach($streamInfo as $stream){ ?>
                                    <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                    <?php } } ?>
                               
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <select class="form-control input-sm" id="section_name" name="section_name">
                                    <option value="">Select Section (OPTIONAL)</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <!-- <option value="E">E</option>
                                    <option value="F">F</option>
                                    <option value="G">G</option>
                                    <option value="H">H</option>
                                    <option value="I">I</option>
                                    <option value="J">J</option>
                                    <option value="K">K</option>
                                    <option value="L">L</option>
                                    <option value="M">M</option>
                                    <option value="N">N</option>
                                    <option value="O">O</option>
                                    <option value="P">P</option>
                                    <option value="Q">Q</option>
                                    <option value="R">R</option>
                                    <option value="S">S</option> -->
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <select class="form-control input-sm" id="subject_name" name="subject_name" required>
                                    <option value="">Select Subject</option>
                                    <?php if(!empty($subjectInfo)){ 
                                        foreach($subjectInfo as $subject){ ?>
                                    <option value="<?php echo $subject->name; ?>"><?php echo $subject->name; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="form-group">
                                <input type="text" placeholder="Video link" id="link" class="form-control required "
                                    name="link" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <textarea class="form-control" rows="5" placeholder="Write Description here..."
                                    id="description" name="description" maxlength="500"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer  pt-2 pb-0">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" id="staffInfoDownload" class="btn btn-md btn-success">SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/studyMaterial.js" charset="utf-8"></script>
<script type="text/javascript">
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
    $('#videoModal').on('hidden.bs.modal', function() {
        $("#videoModal iframe").attr("src", $("#videoModal iframe").attr("src"));
    });
    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "viewYoutube/" + value);
        jQuery("#byFilterMethod").submit();
    });

    jQuery('.datepicker').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        startDate: "01-01-2020"
    });
});
</script>










