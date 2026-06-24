<?php
    if($by_date != '01-01-1970'){
        $byDate = date('d-m-Y',strtotime($by_date));
    }else{
        $byDate = '';
    }
?>


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



<!-- Content Header (Page header) -->
<div class="main-content-container px-3 pt-1">
    <div class="row">
        <div class="col-md-12">
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
        </div>
    </div>
    <div class="row p-0">
        <div class="col column_padding_card">
            <div class="card card-small card_heading_title p-0 m-b-1">
                <div class="card-body p-2">
                    <div class="row c-m-b">
                        <div class="col-lg-4 col-sm-4 col-6">
                            <span class="page-title absent_table_title_mobile">
                                <i class="material-icons">event</i> Youtube </span>
                            <small>Management</small>
                            </span>
                        </div>

                        <div class="col-lg-2">
                            <?php if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_TEACHING_STAFF || $role == ROLE_PRINCIPAL || $role == VICE_PRINCIPAL || $role == ROLE_SUPER_ADMIN) {
            ?>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addNewDocModel"><i
                                    class="fa fa-plus"></i> Add New</button>
                            <?php } ?>
                        </div>
                        <div class="col-lg-2">

                        </div>
                        <div class="col-lg-4 text-center">
                            <b style="font-size: 20px; color: #3c8dbc;">Total Materials:
                                <?php echo $videoRecordsCount; ?></b>
                        </div>
                        <div class="col-lg-4">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row form-employee">
        <div class="col-12 column_padding_card">
            <div class="card card-small c-border p-2">

                <div class="table-responsive-sm">
                <table class="table table-hover table-bordered">
                            <tr class="bg-deafult">
                                <form action="<?php echo base_url() ?>viewYoutube" method="POST" id="byFilterMethod">

                                    <th width="80" style="padding: 1px;">
                                        <input type="text" name="by_date" id="by_date" value="<?php echo $byDate; ?>"
                                            class="form-control input-sm pull-right datepicker"
                                            style="text-transform: uppercase" placeholder="By Date"
                                            autocomplete="off" />
                                    </th>
                                    <th width="80" style="padding: 1px;">
                                        <input type="text" name="video_name" id="video_name"
                                            value="<?php echo $video_name ?>" class="form-control input-sm pull-right"
                                            style="text-transform: uppercase" placeholder="By Name"
                                            autocomplete="off" />
                                    </th>
                                    <th width="110" style="padding: 1px;">
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
                                    <th style="padding: 1px;"> <input type="text" name="stream_name" id="stream_name"
                                            value="<?php echo $stream_name ?>" class="form-control input-sm pull-right"
                                            style="text-transform: uppercase" placeholder="By Stream"
                                            autocomplete="off" /></th>
                                    <th style="padding: 1px;">
                                        <input type="text" name="subject_name" id="subject_name"
                                            value="<?php echo $subject_name ?>" class="form-control input-sm pull-right"
                                            style="text-transform: uppercase" placeholder="By Subject"
                                            autocomplete="off" />
                                    </th>
                                    <th style="padding: 1px;"></th>


                                    <th style="padding: 1px;" class="text-center"><button type="submit"
                                            class="btn btn-info btn-md btn-block"> Search</button></th>
                                </form>
                            </tr>

                            <tr class="bg-primary">
                                <th class="text-center">Date</th>
                                <th width="200" class="text-center">Name</th>
                                <th class="text-center">Term</th>
                                <th width="100" class="text-center">Stream</th>
                                <th class="text-center">Subject</th>
                                <th class="text-center">Link</th>
                                <th class="text-center">Actions</th>
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
                                <td class="text-center">

                                    <a class="btn btn-xs btn-info"
                                        href="<?php echo base_url() ?>editYoutube/<?php echo $record->row_id; ?>"
                                        title="Edit"><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-xs btn-danger deleteYoutube" href="#"
                                        data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i
                                            class="fa fa-trash"></i></a>

                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#videoModal" onclick="openModel('<?php echo $url; ?>')">Play <i
                                            class="fa fa-play"></i></button>
                                </td>
                            </tr>
                            <?php
                        }
                    }else{ ?>
                            <tr class="bg-info">
                                <td class="text-center" colspan="8">
                                    Video not found!.
                                </td>
                            </tr>
                            <?php }
                        ?>

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
            <div class="modal-header bg-blue ">
                <div class="row">
                    <div class="col-lg-11">
                        <h4 class="modal-title">Play Video</h4>
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
            <div class="modal-header bg-blue ">
                <div class="row">
                    <div class="col-lg-11">
                        <h4 class="modal-title">Add New Link</h4>
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
                                <select class="form-control input-sm selectpicker" id="stream_name" name="stream_name[]"
                                    required multiple>
                                    <option value="">Sort Stream</option>
                                    <option value="ALL">ALL</option>
                                    <option value="PCMB">PCMB</option>
                                    <option value="PCMC">PCMC</option>
                                    <option value="PCME">PCME</option>
                                    <option value="CEBA">CEBA</option>
                                    <option value="CSBA">CSBA</option>
                                    <option value="MEBA">MEBA</option>
                                    <option value="MSBA">MSBA</option>
                                    <option value="PEBA">PEBA</option>
                                    <option value="SEBA">SEBA</option>
                                    <option value="HEPS">HEPS</option>
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
                                    <option value="E">E</option>
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
                                    <option value="S">S</option>
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
                    <div class="modal-footer">
                        <button type="submit" id="staffInfoDownload" class="btn btn-md btn-primary"><i
                                class="fa fa-save"></i> ADD</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span> Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/youtube.js" charset="utf-8"></script>
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










