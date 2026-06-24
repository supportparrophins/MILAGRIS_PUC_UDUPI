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
                                <i class="material-icons">event</i> Study Materials </span>
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
                                <?php echo $studyRecordsCount; ?></b>
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
                    <table class="table table-hover ">
                        <tr class="bg-deafult">
                            <form action="<?php echo base_url() ?>viewStudyMaterials" method="POST" id="byFilterMethod">

                                <th width="110" style="padding: 1px;">
                                    <select class="form-control input-sm" id="term_name" name="term_name">
                                        <?php if($term_name != ""){ ?>
                                        <option value="<?php echo $term_name; ?>" selected><b>Sorted:
                                                <?php echo $term_name; ?></b></option>

                                        <?php }
                              ?>
                                        <option value="">By Term</option>
                                        <option value="I PUC">I PUC</option>
                                        <option value="II PUC">II PUC</option>

                                    </select>
                                </th>
                                <th style="padding: 1px;"> <input type="text" name="stream_name" id="stream_name"
                                        value="<?php echo $stream_name ?>" class="form-control input-sm pull-right"
                                        style="text-transform: uppercase" placeholder="By Stream" /></th>
                                <th style="padding: 1px;">
                                    <input type="text" name="type" id="type" value="<?php echo $type ?>"
                                        class="form-control input-sm pull-right" style="text-transform: uppercase"
                                        placeholder="By Type" />
                                </th>

                                <th width="80" style="padding: 1px;">
                                    <input type="text" name="section_name" id="section_name"
                                        value="<?php echo $section_name ?>" class="form-control input-sm pull-right"
                                        style="text-transform: uppercase" placeholder="By Section" />
                                </th>


                                <th style="padding: 1px;">
                                    <input type="text" name="doc_name" id="doc_name" value="<?php echo $doc_name ?>"
                                        class="form-control input-sm pull-right" style="text-transform: uppercase"
                                        placeholder="By Document" />
                                </th>

                                <th width="110" style="padding: 1px;">

                                </th>

                                <th style="padding: 1px;" class="text-center"><button type="submit"
                                        class="btn btn-info btn-md btn-block"> Search</button></th>
                            </form>
                        </tr>

                        <tr class="bg-primary">

                            <th>Term</th>
                            <th>Stream</th>
                            <th>Type</th>
                            <th>Section</th>
                            <th>Document</th>
                            <th>Description</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        <?php
                    if(!empty($studyRecords))
                    {
                        foreach($studyRecords as $record)
                        {
                    ?>
                        <tr>

                            <td><?php echo $record->term_name; ?></td>
                            <td><?php echo $record->stream_name; ?></td>
                            <td><?php echo $record->type; ?></td>
                            <td><?php echo $record->section_name; ?></td>
                            <td><a href="<?php echo base_url().$record->document_name_url; ?>" download>Download</a>
                            </td>
                            <td><?php echo $record->description; ?></td>
                            <td class="text-center">
                                <?php if($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_TEACHING_STAFF || $role == ROLE_SUPER_ADMIN) { ?>
                                <a class="btn btn-sm btn-danger deleteStudy" href="#"
                                    data-row_id="<?php echo $record->row_id; ?>" title="Delete Staff"><i
                                        class="fa fa-trash"></i></a>
                                <?php } ?>

                            </td>
                        </tr>
                        <?php
                        }
                    }else{ ?>
                        <tr class="bg-info">
                            <td class="text-center" colspan="8">
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
            <div class="modal-header bg-blue ">
                <div class="row">
                    <div class="col-lg-11">
                        <h4 class="modal-title">Add New Study Material</h4>
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
                <form action="<?php echo base_url() ?>addNewStudyMaterials" method="POST" role="form"
                    enctype="multipart/form-data">
                    <div class="text-center" id="alertMsg"></div>
                    <div class="row">
                        <div class="col-lg-12 ">
                            <div class="form-group">
                                <img src="<?php echo base_url(); ?>assets/images/file.png" class="avatar  img-thumbnail"
                                    width="50" height="10" src="#" id="uploadedImage" name="userfile" width="80"
                                    height="80" alt="avatar">
                                <label for="fname">Select a Document(Study Material)</label>
                                <input type="file" class="form-control" id="doc_path" name="doc_path" required>
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

                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <select class="form-control input-sm" id="doc_type" name="doc_type" required>
                                    <option value="">Select Doc Type</option>
                                    <option value="Question Paper">Question Paper</option>
                                    <option value="E-Book">E-Book</option>
                                    <option value="Notes">Notes</option>
                                    <option value="Other">Other</option>
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
                    <div class="modal-footer">
                        <button id="staffInfoDownload" type="submit" class="btn btn-md btn-primary"><i
                                class="fa fa-save"></i> ADD</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span> Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

    $('#selectAll').click(function() {
        if ($('#selectAll').is(':checked')) {
            $('.singleSelect').prop('checked', true);
        } else {
            $('.singleSelect').prop('checked', false);
        }
    });

    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#searchList").attr("action", baseURL + "viewStudyMaterials/" + value);
        jQuery("#searchList").submit();
    });




});
</script>