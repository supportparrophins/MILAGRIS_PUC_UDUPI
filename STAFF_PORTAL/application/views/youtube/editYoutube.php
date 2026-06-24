<style>
hr {
    margin-bottom: 5px !important;
    margin-top: 0px !important;
    border-top: 1px solid #3c8dbc;
}

td,
th {
    border-bottom: 1px solid grey !important;
    font-weight: 800;
}

.box-header {
    padding: 7px !important;
}

.form-control {
    font-weight: 600 !important;
}


.editable-wrapper {
    border: 1px #ccc solid;
}

.label,
.editable {
    padding: 7px;
}

.label {
    float: left;
    font-weight: bold;
    padding-bottom: 0;
    pointer-events: none;
}

.editable {
    min-height: 100px;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-lg-6">
                <h4>
                    <i class="fa fa-youtube-play"></i> <span style="font-size: 23px;font-weight: 600;">Youtube </span>
                    <small>Management</small>
                </h4>
            </div>
            <div class="col-lg-6">
                <input class="btn btn-primary pull-right" type="button" value="Back" onclick="window.history.back()" />
            </div>
        </div>
        <hr>
        <div class="row" style="margin-bottom: -10px;">
            <div class="col-lg-2">
            </div>
            <div class="col-lg-2">

            </div>
            <div class="col-lg-4 text-center">
            </div>
            <div class="col-lg-4">

            </div>
        </div>
    </section>

    <section class="content">
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

            <div class="col-md-12">
                <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
            </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <form action="<?php echo base_url() ?>updateYoutube" method="post" role="form">
                            <div class="text-center" id="alertMsg"></div>
                            <input type="hidden" name="row_id" id="row_id" value="<?php echo $youtubeInfo->row_id; ?>" />
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="Video Name" id="video_name" value="<?php echo $youtubeInfo->video_name; ?>" class="form-control required " name="video_name" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                    <input class="form-control" placeholder="Date" value="<?php echo date('d-m-Y',strtotime($youtubeInfo->date)); ?>" 
                                            id="date" name="date" autocomplete="off"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <select class="form-control input-sm" id="term_name" name="term_name" required>
                                            <?php if(!empty($youtubeInfo->term_name)){ ?>
                                                <option value="<?php echo $youtubeInfo->term_name; ?>">Selected: <?php echo $youtubeInfo->term_name; ?></option>
                                            <?php } ?>
                                            <option value="">Select Term</option>
                                            <option value="I PUC">I PUC</option>
                                            <option value="II PUC">II PUC</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <select class="form-control input-sm" id="stream_name" name="stream_name" required>
                                            <?php if(!empty($youtubeInfo->stream_name)){ ?>
                                                <option value="<?php echo $youtubeInfo->stream_name; ?>">Selected: <?php echo $youtubeInfo->stream_name; ?></option>
                                            <?php } ?>
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
                                            <?php if(!empty($youtubeInfo->section_name)){ ?>
                                                <option value="<?php echo $youtubeInfo->section_name; ?>">Selected: <?php echo $youtubeInfo->section_name; ?></option>
                                            <?php } ?>
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
                                            <?php if(!empty($youtubeInfo->subject_name)){ ?>
                                                <option value="<?php echo $youtubeInfo->subject_name; ?>">Selected: <?php echo $youtubeInfo->subject_name; ?></option>
                                            <?php } ?>
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
                                    <input type="text" placeholder="Video link" id="link" class="form-control required" value="<?php echo $youtubeInfo->link; ?>" name="link" autocomplete="off" required>
                                </div>
                            </div>
                                <div class="col-lg-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5" placeholder="Write Description here..."
                                            id="description" name="description"><?php echo $youtubeInfo->description; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-md btn-primary"><i
                                        class="fa fa-save"></i> ADD</button>
                            </div>
                        </form>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>