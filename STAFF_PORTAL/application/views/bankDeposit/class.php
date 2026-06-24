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
                        <div class="col-lg-4 col-sm-4 col-6">
                            <span class="page-title absent_table_title_mobile">
                                <i class="fa fa-users"></i> Online Class 
                            </span>
                        </div>
                        <div class="text-center col-lg-4 col-sm-3 col-6">
                            <b style="font-size: 20px;">Total Class: <?php echo $classRecordsCount; ?></b>
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
                            <form action="<?php echo base_url() ?>viewOnlineClass" method="POST" id="byFilterMethod">
                                    
                                <th width="90" style="padding: 1px;">
                                    <select class="form-control input-sm" id="term_name" name="term_name" autocomplete="off">
                                        <?php if($term_name != ""){ ?>
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
                                        style="text-transform: uppercase" placeholder="By Stream" autocomplete="off"/></th>
                                <th style="padding: 1px;">
                                    <input type="text" name="section_name" id="section_name"
                                        value="<?php echo $section_name ?>" class="form-control input-sm pull-right"
                                        style="text-transform: uppercase" placeholder="By Section" autocomplete="off" />
                                </th>
                                <th style="padding: 1px;">
                                    <input type="text" name="by_date" id="by_date" value="<?php echo $by_date ?>"
                                        class="form-control input-sm pull-right datepicker" style="text-transform: uppercase"
                                        placeholder="By Date" autocomplete="off"/>
                                </th>
                                <!-- <th style="padding: 1px;">
                                    <input type="text" name="start_time" id="start_time" value="<?php echo $start_time ?>"
                                        class="form-control input-sm pull-right" style="text-transform: uppercase"
                                        placeholder="From Time" autocomplete="off"/>
                                </th>
                                <th style="padding: 1px;">
                                    <input type="text" name="end_time" id="end_time" value="<?php echo $end_time ?>"
                                        class="form-control input-sm pull-right" style="text-transform: uppercase"
                                        placeholder="To Time" autocomplete="off"/>
                                </th> -->

                                <th style="padding: 1px;">
                                    <select class="form-control input-sm" id="subject_name" name="subject_name" required>
                                        <?php if(!empty($subject_name)){ ?>
                                        <option value="<?php echo $subject_name; ?>">Selected: <?php echo $subject_name; ?></option>
                                        <?php } ?>
                                        <option value="">Select Subject</option>
                                        <?php if(!empty($subjectInfo)){ 
                                            foreach($subjectInfo as $subject){ ?>
                                        <option value="<?php echo $subject->sub_name; ?>"><?php echo $subject->sub_name; ?></option>
                                        <?php } } ?>
                                    </select>
                                </th>
                                <th style="padding: 1px;">
                                    <input type="text" name="app_type" id="app_type" value="<?php echo $app_type ?>"
                                        class="form-control input-sm pull-right" style="text-transform: uppercase"
                                        placeholder="Application Type" autocomplete="off"/>
                                </th>
                                <th style="padding: 1px;">
                                    <input type="text" name="description" id="description" value="<?php echo $description ?>"
                                        class="form-control input-sm pull-right" style="text-transform: uppercase"
                                        placeholder="Description" autocomplete="off"/>
                                </th>

                                <th style="padding: 1px;" class="text-center"><button type="submit"
                                                class="btn btn-success btn-md btn-block"><i class="fa fa-filter"></i> Filter</button></th>
                            </form>
                        </tr>
                            <tr class="table_row_background text-center">
                                <th>Term</th>
                                <th>Stream</th>
                                <th>Section</th>
                                <th>Validity Date</th>
                                <th>Subject</th>
                                <th>Application</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                            <?php if(!empty($classRecords)){
                                foreach($classRecords as $record){ ?>
                            <tr class="text-dark">
                                <td class="text-center"><?php echo $record->term_name; ?></td>
                                <td class="text-center"><?php echo $record->stream_name; ?></td>
                                <td class="text-center"><?php echo $record->section_name; ?></td>
                                <td class="text-center"><?php echo date('d-m-Y',strtotime($record->date)); ?></td>
                                <!-- <td class="text-center"><?php echo $record->from_time; ?></td>
                                <td class="text-center"><?php echo $record->to_time; ?></td> -->
                                <td class="text-center"><?php echo $record->subject_name; ?></td>
                                <td class="text-center"><?php echo $record->application_type; ?></td>
                                <td><?php echo $record->description; ?></td>
                                <td class="text-center">
                                    <?php if($role == ROLE_ADMIN || $role == ROLE_LIBRARY || $role == ROLE_TEACHING_STAFF || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_LIBRARY) { ?>
                                    <a class="btn btn-sm btn-success px-2 py-1" href="<?php echo base_url() ?>editOnlineClass/<?php echo $record->row_id; ?>" 
                                    title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                    <a class="btn btn-sm btn-danger deleteOnlineClass px-2 py-1" href="#"
                                        data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i
                                            class="fa fa-trash"></i></a>
                                    <?php } ?>

                                </td>
                            </tr>
                            <?php } } else { ?>
                            <tr class="card_heading_title text-dark">
                                <td colspan="10" class="text-center"> Class Record Not Found!.</td>
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

    
    <!-- The Modal -->
    <div class="modal" id="addNewDocModel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Online Class</h4>
                    <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="modal-body p-2">
                    <form action="<?php echo base_url() ?>addNewOnlineClass" method="POST" role="form"
                        enctype="multipart/form-data">
                        <div class="text-center" id="alertMsg"></div>
                        
                        <div class="row">
                            <div class="col-lg-6">
                                <label>Term</label>
                                <div class="form-group">
                                    <select class="form-control input-sm" id="term_name" name="term_name" autocomplete="off" required>
                                        <option value="">Select Term</option>
                                        <option value="I PUC">I PUC</option>
                                        <option value="II PUC">II PUC</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Stream</label>
                                <div class="form-group">
                                    <select class="form-control input-sm selectpicker" id="stream_name" name="stream_name[]" required multiple>
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
                                <label>Section</label>
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
                                <label>Online Class valid till</label>
                                <div class="form-group">
                                    <input type="text" placeholder="Online Class valid till" id="class_date" class="form-control required datepicker input-sm" name="class_date" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Application</label>
                                <div class="form-group">
                                    <select class="form-control input-sm" id="app_type" name="app_type" autocomplete="off" required>
                                        <option value="">Select Application Type</option>
                                        <option value="Zoom">Zoom</option>
                                        <option value="Google Meeting">Google Meeting</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Subject Name</label>
                                <div class="form-group">
                                    <select class="form-control input-sm" id="subject_name" name="subject_name" autocomplete="off" required>
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
                                <label>Link</label>
                                <div class="form-group">
                                    <textarea class="form-control input-sm" rows="5" placeholder="Class link URL"
                                        id="link_url" name="link_url" autocomplete="off" required></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-md-12">
                                <label>Description</label>
                                <div class="form-group">
                                    <textarea class="form-control input-sm" rows="5" placeholder="Write Description here..."
                                        id="description" name="description" maxlength="300"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer pt-2 pb-0">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-md btn-success float-right"> SAVE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/studyMaterial.js" charset="utf-8"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "viewOnlineClass/" + value);
        jQuery("#byFilterMethod").submit();
    });



    jQuery('.datepicker').datepicker({
        autoclose: true,
        format : "dd-mm-yyyy",
        startDate : "01-01-2019"
    });

});
</script>


