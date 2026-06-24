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
<?php
        $warning = $this->session->flashdata('warning');
        if ($warning) {
        ?>
<div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <i class="fa fa-check mx-2"></i>
    <strong>warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
</div>
<?php }?>

<div class="row">
    <div class="col-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container px-3 pt-1 overall_content">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row p-0 column_padding_card">
            <div class="col-12 column_padding_card">
                <div class="card card-small p-0 card_heading_title">
                    <div class="card-body p-2 ml-2">
                        <span class="page-title">
                        <i class="material-icons">event_note</i> Edit Section
                        </span>
                        <a href="<?php echo base_url('classStreamDetails'); ?>"
                            onclick="showLoader();"
                            class="btn primary_color mobile-btn float-right text-white border_left_radius">
                                <i class="fa fa-arrow-circle-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if(empty($sectionInfo)){ ?>
    <div class="row form-employee">
        <div class="col-lg-12 col-md-12 col-12 pr-0 text-center">
        <img height="270" src="<?php echo base_url(); ?>assets/images/404.png"/>
        </div>
    </div>
    <?php } else {  ?>
    <div class="row form-employee p-0 column_padding_card">
        <div class="col-12 column_padding_card">
            <div class="card card-small c-border mb-4 p-2">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item p-2">
                        <form role="form" action="<?php echo base_url() ?>updateClassAndSection" method="post" role="form">
                        <input type="hidden" value="<?php echo $sectionInfo->row_id; ?>" name="row_id" id="row_id"/>
                            <div class="row p-0 column_padding_card">
                                <div class="col column_padding_card">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label  for="email ">Select Term<span class="text-danger required_star">*</span></label>
                                            <select name="term_name" id="term_name" class="form-control" data-live-search="true" autocomplete="off" required>
                                             <option value="<?php echo $sectionInfo->term_name; ?>"> Selected: <?php echo $sectionInfo->term_name; ?></option>
                                            <option value="">Select Term</option>
                                            <option value="I PUC">I PUC</option>
                                            <option value="II PUC">II PUC</option>
                                        </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="mobile">Select Stream<span class="text-danger required_star">*</span></label>
                                            <select class="form-control" id="stream_name" name="stream_name" data-live-search="true" autocomplete="off" required>
                                            <option value="<?php echo $sectionInfo->stream_id; ?>">Selected: <?php echo $sectionInfo->stream_name; ?></option>
                                              <option value="">Select Stream</option>
                                                <?php if(!empty($streamInfo)){
                                                    foreach($streamInfo as $stream){ ?>
                                                    <option value="<?php echo $stream->row_id ?>">
                                                        <?php echo $stream->stream_name ?>
                                                    </option>
                                                <?php }  } ?>
                                                <option value="5">
                                                    <?php echo "PCME" ?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="mobile">Select Section<span class="text-danger required_star">*</span></label>
                                            <select class="form-control" id="section" name="section" data-live-search="true" autocomplete="off" required>
                                            <option value="<?php echo $sectionInfo->section_name; ?>">Selected: <?php echo $sectionInfo->section_name; ?></option>
                                                <option value="">By Section</option>
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
                                                <option value="ALL">ALL (No Section)</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="lab">Select Class Teacher</label>
                                            <select class="form-control selectpicker"  id="class_teacher" name="class_teacher" data-live-search="true">
                                               <?php if(!empty($sectionInfo->class_teacher)){ ?>
                                            <option value="<?php echo $sectionInfo->class_teacher; ?>"> Selected:
                                                <?php echo $sectionInfo->name; ?></option>
                                            <?php } ?>
                                             <option value="">Select Staff</option>
                                            <?php if(!empty($staffInfo)){
                                             foreach($staffInfo as $stf){ ?>
                                            <option value="<?php echo $stf->staff_id; ?>"><?php echo $stf->name; ?>
                                            </option>
                                            <?php } } ?>
                                        </select>
                                        </div>
                                    </div>
                                        <div class="mt-3 col-md-12">
                                            <button type="submit" class="btn btn-success float-right"> Update </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <?php } ?>

</div>