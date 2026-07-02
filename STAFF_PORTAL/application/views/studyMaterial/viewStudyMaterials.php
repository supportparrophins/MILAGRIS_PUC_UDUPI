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
    <?php //if($_SESSION['loggedIn_type']!='Mobile'){ ?>
    <div class="row p-0">
        <div class="col column_padding_card">
            <div class="card card-small card_heading_title p-0 m-b-1">
                <div class="card-body p-2">
                    <div class="row c-m-b">
                        <div class="col-lg-4 col-sm-4 col-12">
                            <span class="page-title absent_table_title_mobile">
                                <i class="fa fa-book"></i> Materials </span>
                            </span>
                        </div>
                        <div class="col-lg-4 col-6 col-sm-4 text-center">
                            <b class="text-dark" style="font-size: 20px;">Total Materials: <?php echo $studyRecordsCount; ?></b>
                        </div>
                        <div class="col-lg-4 col-6 col-sm-4">
                            <?php if($_SESSION['loggedIn_type']!='Mobile'){ ?>
                            <a onclick="showLoader();window.history.back();" class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                            <?php } ?>
                            <?php //if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_TEACHING_STAFF || $role == ROLE_LIBRARY || $role == ROLE_PRINCIPAL || $role == VICE_PRINCIPAL || $role == ROLE_OFFICE || $role == ROLE_SUPER_ADMIN) {
                               if($accessInfo->can_add == 1) {
                               ?>
                            <button class="btn btn-primary float-right mobile-btn border_right_radius" data-toggle="modal" data-target="#addNewDocModel"><i
                                    class="fa fa-plus"></i> Add New</button>
                            <?php } ?>
                        </div>
                        <div class="col-lg-4">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php //} ?>
    <div class="row form-employee">
        <div class="col-12 column_padding_card">
            <div class="card card-small c-border p-2">

                <div class="table-responsive-sm">
                    <table class="table table-hover table-bordered mb-0">
                        <tr class="row_filter">
                            <form action="<?php echo base_url() ?>viewStudyMaterials" method="POST" id="byFilterMethod">

                                <th>
                                    <input type="text" name="by_date" id="by_date" value="<?php echo $by_date ?>"
                                        class="form-control input-sm pull-right datepicker"
                                        placeholder="By Date" autocomplete="off"/>
                                </th>
                                <th>
                                    <select class="form-control input-sm" id="by_term" name="by_term">
                                        <?php if($by_term != ""){ ?>
                                        <option value="<?php echo $by_term; ?>" selected><b>Sorted:
                                                <?php echo $by_term; ?></b></option>

                                        <?php }
                              ?>
                                        <option value="">By Term</option>
                                        <option value="I PUC">I PUC</option>
                                        <option value="II PUC">II PUC</option>

                                    </select>
                                </th>
                                <th> 
                                    <select class="form-control input-sm" id="by_stream_name" name="by_stream_name">
                                        <?php if($by_stream_name != ""){ ?>
                                        <option value="<?php echo $by_stream_name; ?>" selected><b>Selected:
                                                <?php echo $by_stream_name; ?></b></option>

                                        <?php } ?>
                                        <option value="">By Stream</option>
                                        <option value="ALL">ALL</option>

                                        <?php if(!empty($streamInfo)){ 
                                            foreach($streamInfo as $stream){ ?>
                                        <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                        <?php } } ?>
                               
                                    </select>
                                </th>
                                <th>
                                    <select class="form-control input-sm" id="type" name="type">
                                        <?php if($type != ""){ ?>
                                        <option value="<?php echo $type; ?>" selected><b>Sorted:
                                                <?php echo $type; ?></b></option>

                                        <?php } ?>

                                        <option value="">By Type</option>
                                        <option value="Question Paper">Question Paper</option>
                                        <option value="E-Book">E-Book</option>
                                        <option value="Notes">Notes</option>
                                        <option value="Other">Other</option>

                                    </select>
                                </th>

                                <th>
                                <select class="form-control input-sm" id="section_name" name="section_name">
                                        <?php if($section_name != ""){ ?>
                                        <option value="<?php echo $section_name; ?>" selected><b>Sorted:
                                        <?php echo $section_name; ?></b></option>

                                        <?php } ?>

                                        <option value="">By Section</option>
                                        <option value="ALL">ALL</option>
                                        <!-- <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option> -->
                                        <!-- <option value="E">E</option>
                                        <option value="F">F</option>
                                        <option value="G">G</option>
                                        <option value="H">H</option>
                                        <option value="I">I</option>
                                        <option value="J">J</option>
                                        <option value="K">K</option>
                                        <option value="L">L</option>
                                        <option value="M">M</option>
                                        <option value="N">N</option> -->
                                  </select>
                                </th>
                                <th>
                                    <select class="form-control input-sm" id="by_subject" name="by_subject">
                                        <?php if(!empty($by_subject)){ ?>
                                        <option value="<?php echo $by_subject; ?>">Selected: <?php echo $by_subject; ?></option>
                                        <?php } ?>
                                        <option value="">Select Subject</option>
                                        <?php if(!empty($subjectInfo)){ 
                                            foreach($subjectInfo as $subject){ ?>
                                        <option value="<?php echo $subject->name; ?>"><?php echo $subject->name; ?></option>
                                        <?php } } ?>
                                    </select>
                                </th>

                                <th>
                                    <input type="text" name="doc_name" id="doc_name" value="<?php echo $doc_name ?>"
                                        class="form-control input-sm pull-right" style="text-transform: uppercase"
                                        placeholder="By Document" />
                                </th>

                                <th>

                                </th>

                                <th class="text-center"><button type="submit"
                                        class="btn btn-success btn-md btn-block"><i class="fa fa-filter"></i> Filter</button></th>
                            </form>
                        </tr>

                        <tr class="table_row_background text-dark text-center">

                            <th width="100">Date</th>
                            <th>Term</th>
                            <th width="100">Stream</th>
                            <th>Type</th>
                            <th>Section</th>
                            <th>Subject</th>
                            <th>Document</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                        <?php
                    if(!empty($studyRecords))
                    {
                        foreach($studyRecords as $record)
                        {
                    ?>
                        <tr>

                            <td class="text-center"><?php echo date('d-m-Y',strtotime($record->created_date_time)); ?></td>
                            <td class="text-center"><?php echo $record->term_name; ?></td>
                            <td class="text-center"><?php echo $record->stream_name; ?></td>
                            <td><?php echo $record->type; ?></td>
                            <td class="text-center"><?php echo $record->section_name; ?></td>
                            <td class="text-center"><?php echo $record->subject_name; ?></td>
                            <td class="text-center"><a href="<?php echo base_url().$record->document_name_url; ?>" download>Download</a>
                            </td>
                            <td><?php echo $record->description; ?></td>
                            <td class="text-center">
                                <?php //if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_TEACHING_STAFF || $role == ROLE_LIBRARY || $role == ROLE_OFFICE || $role == ROLE_SUPER_ADMIN) { ?>
                                <?php if($accessInfo->can_delete == 1) { ?>
                                <a class="btn btn-sm btn-danger deleteStudy px-2 py-1" href="#"
                                    data-row_id="<?php echo $record->row_id; ?>" title="Delete Staff"><i
                                        class="fa fa-trash"></i></a>
                                <?php } ?>

                            </td>
                        </tr>
                        <?php
                        }
                    }else{ ?>
                        <tr class="card_heading_title text-dark">
                            <td class="text-center" colspan="9">
                                Study Materials not found!.
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

<!-- The Modal -->
<div class="modal" id="addNewDocModel">
    <div class="modal-dialog ">
        <div class="modal-content ">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add New Study Material</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form action="<?php echo base_url() ?>addNewStudyMaterials" method="POST" role="form"
                    enctype="multipart/form-data">
                    <div class="text-center" id="alertMsg"></div>
                    <div class="row">
                        <div class="col-lg-12 ">
                            <div class="form-group">
                                <img src="<?php echo base_url(); ?>assets/images/file.png" class="avatar"
                                    width="30" height="40" src="#" id="uploadedImage" name="userfile" width="80"
                                    height="80" alt="avatar">
                                <label for="fname">Select a Document(Study Material)</label>
                                <input type="file" class="form-control" id="doc_path" name="doc_path" accept=".pdf,.doc,.docx,.xlsx,.csv,.xls,.ppt,.pptx" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <select class="form-control input-sm" id="term_name" name="term_name" required autocomplete="off">
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
                                    <!-- <option value="PCMB">PCMB</option>
                                    <option value="PCMC">PCMC</option>
                                    <option value="PCMS">PCMS</option>
                                    <option value="CEBA">CEBA</option>
                                    <option value="CSBA">CSBA</option>
                                    <option value="MEBA">MEBA</option>
                                    <option value="MSBA">MSBA</option>
                                    <option value="PEBA">PEBA</option>
                                    <option value="SEBA">SEBA</option>
                                    <option value="HEPS">HEPS</option> -->
                              


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
                                    <option value="ALL">ALL</option>
                                    <!-- <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option> -->
                                    <!-- <option value="E">E</option>
                                    <option value="F">F</option>
                                    <option value="G">G</option>
                                    <option value="H">H</option>
                                    <option value="I">I</option>
                                    <option value="J">J</option>
                                    <option value="K">K</option>
                                    <option value="L">L</option>
                                    <option value="M">M</option>
                                    <option value="N">N</option> -->
                                   
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <select class="form-control input-sm " id="doc_type" name="doc_type" required>
                                    <option value="">Select Doc Type</option>
                                    <option value="Question Paper">Question Paper</option>
                                    <option value="E-Book">E-Book</option>
                                    <option value="Notes">Notes</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <select class="form-control input-sm " id="subject_name" name="subject_name" required>
                                    <option value="">Select Subject</option>
                                    <?php if(!empty($subjectInfo)){ 
                                        foreach($subjectInfo as $subject){ ?>
                                    <option value="<?php echo $subject->name; ?>"><?php echo $subject->name; ?></option>
                                    <?php } } ?>
                                    <!-- <option value="Hall Ticket">Hall Ticket</option> -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <textarea class="form-control" rows="5" placeholder="Write Description here..."
                                    id="description" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-2 pb-0">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button id="staffInfoDownload" type="submit" class="btn btn-md btn-success"> SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/studyMaterial.js" charset="utf-8"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    $('.selectpicker').selectpicker('refresh');

    $('#selectAll').click(function() {
        if ($('#selectAll').is(':checked')) {
            $('.singleSelect').prop('checked', true);
        } else {
            $('.singleSelect').prop('checked', false);
        }
    });

    
    $('.datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        dateFormat: "dd-mm-yy",
        maxDate : 0,
        startDate : "01-03-2020",
    });

    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#searchList").attr("action", baseURL + "viewStudyMaterials/" + value);
        jQuery("#searchList").submit();
    });

    // $("#term_name").change(function(){
    //     var term_name = $("#term_name").val();
    //     if(this.value != 0){
    //         // $('#addMarkButton').prop('disabled', 'disabled');
    //         $('#stream_name').prop('disabled', false);
    //         $('#stream_name option:not(:first)').remove();
    //         $.ajax({
    //         url: '<?php echo base_url(); ?>/getStreamNameByTermName',
    //         type: 'POST',
    //         dataType: "json",
    //         data: { term_name : term_name },

    //         success: function(data) {
    //             //var examObject = JSON.parse(data);
    //             var examObject = JSON.stringify(data)
    //             var count = data.result.length;
                
    //             for(var i=0; i<=count; i++){
    //                 $("#stream_name").append(new Option(data.result[i].stream_name+' - '+data.result[i].section_name, data.result[i].stream_name));
    //             }
    //         }
    //     });
    //     }else{
    //         $('#stream_name').prop('disabled', 'disabled');
    //         $('#stream_name option:not(:first)').remove();
    //         // $('#addMarkButton').prop('disabled', 'disabled');
    //     }
    // });


});
</script>