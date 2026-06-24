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
                        <div class="col-lg-6 col-sm-6 col-6">
                            <span class="page-title absent_table_title_mobile">
                                <i class="fab fa-youtube"></i> Video
                            </span>
                        </div>

                        <div class="col-lg-6 col-sm-6 col-12 box-tools"> 
                            <a onclick="showLoader();window.history.back();" class="btn primary_color float-right text-white pt-2 "
                                value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row form-employee">
        <div class="col-12 column_padding_card">
            <div class="card card-small c-border p-2">
                <form action="<?php echo base_url() ?>updateYoutube" method="post" role="form">
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
                                            <option value="<?php echo $subject->sub_name; ?>"><?php echo $subject->sub_name; ?></option>
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
                        <div class=" col-12">
                            <button type="submit" class="btn btn-md btn-success float-right"> UPDATE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
