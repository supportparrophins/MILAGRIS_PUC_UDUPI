<style>
.select2-container .select2-selection--single {
    height: 38px !important;
    width: 360px !important;
}


.form-control {
    border: 1px solid #000000 !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow b {
    margin-top: 3px !important;
    color: black !important;

}

@media screen and (max-width: 480px) {
    .select2-container--default .select2-selection--single .select2-selection__arrow {

        margin-right: 20px !important;
    }

    .select2-container .select2-selection--single {
        width: 270px !important;
    }
}
table td, .table th {
    border-bottom: 1px solid #b3b3b3 !important;
}
</style>
<?php
$this->load->helper('form');
$error = $this->session->flashdata('error');
if ($error) { 
    ?>
<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <i class="fa fa-check mx-2"></i>
    <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
</div>
<?php } ?>
<?php
        $success = $this->session->flashdata('success');
        if ($success) { 
        ?>
<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <i class="fa fa-check mx-2"></i>
    <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
</div>
<?php }?>
<div class="main-content-container px-3 pt-1 overall_content">
    <div class="row column_padding_card">
        <div class="col-md-12">
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class="col-lg-5 col-6 col-md-12 box-tools">
                                <span class="page-title">
                                <i class="material-icons">group</i> Staff Achievement Info
                                </span>
                            </div>
                            <div class="col-lg-4 col-6 col-md-6 col-sm-6">
                                <b class="text-white" style="font-size: 20px;">Total : <?php echo $totalachCount; ?></b>
                            </div>

                            <div class="col-lg-3 col-12 col-md-6 col-sm-6">
                                <a  onclick="window.history.back();" 
                                    class="btn btn_back primary_color mobile-btn float-right text-white border_left_radius btn-backtrack"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                            
                               <div class="dropdown mobile-btn float-right">
                                             <?php if(isset($accessInfo) && $accessInfo->can_add==1){ ?>
                                    <button class="btn btn-primary float-right mobile-btn  mr-1"
                                                data-toggle="modal" data-target="#addNewDocModel"><i
                                                    class="fa fa-plus"></i>
                                                Add Achievement</button>
                                                <?php  } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2 table-responsive">
                        <table class="display table table-bordered table-striped table-hover w-100">
                        <form action="<?php echo base_url(); ?>staffSAchievemntsDocInfo" method="POST" id="byFilterMethod"  enctype="multipart/form-data">
                                <tr class="filter_row" class="text-center">
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $date; ?>" name="date" id="date" class="form-control input-sm datepicker" placeholder="Date" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $title; ?>" name="title" id="title" class="form-control input-sm" placeholder="Title" autocomplete="off">
                                        </div>
                                    </td>
                                  
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $description; ?>" name="description" id="title" class="form-control input-sm" placeholder="Title" autocomplete="off">
                                        </div>
                                    </td>

                                     <td width="90">
                                        <div class="form-group mb-0">
                                            
                                        </div>
                                    </td>
                                    <td>
                                        <button type="submit"class="btn btn-success btn-block mobile-width"><i class="fa fa-filter"></i> Filter</button>
                                    </td>
                                </tr>
                            </form>
                            <thead>
                                <tr class="table_row_background">
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Title</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">File</th>
                                    <th class="text-center">Action</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($achvemtInfo)){
                                    foreach($achvemtInfo as $std){ ?>
                                    <tr>
                                         <th  width="200" class="text-center"><?php  if($std->date == '1970-01-01' || $std->date == '0000-00-00'){  
                                            echo "";
                                        } else{
                                            echo date('d-m-Y',strtotime($std->date));
                                        } ?></th> 
                                        <th width="200"><?php echo strtoupper($std->title); ?></th>
                                        <th width="200" class="text-center"><?php echo strtoupper($std->description); ?></th>
                                        <th width="200" class="text-center"><?php if (!empty($std->file_path)) { ?>
                                         <a href="<?php echo base_url(); ?><?php echo $std->file_path; ?>"
                                         download target="_blank" class="btn btn_download p-2"><i
                                        class="fa fa-download"></i></a>
                                         <a href="<?php echo base_url(); ?><?php echo $std->file_path; ?>"
                                        target="_blank" class="btn btn-primary p-2"><i
                                        class="fa fa-eye"></i> View</a><?php } ?></th>
                                        <th width="200" class="text-center">
                                             <?php if(isset($accessInfo) && $accessInfo->can_delete==1){ ?>
                                            <a class="btn btn-xs btn-danger deleteachievemtInfo" href="#"
                                            data-row_id="<?php echo $std->row_id; ?>" title="Delete"><i
                                                class="fa fa-trash"></i></a>
                                            <?php  } ?>
                                        </th>
                                        
                                    </tr>
                                <?php } }else{  ?>
                                <tr>
                                    <th  width="200"colspan="5" class="text-center">Achievement Record Not Found</th>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="float-right">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal" id="addNewDocModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Achievement Info</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2 m-1">
                <form action="<?php echo base_url() ?>addAchievementInfo" method="POST" role="form"
                    enctype="multipart/form-data">
                    <div class="text-center" id="alertMsg"></div>

                    <div class="row">
                        <div class="col-lg-6">
                            <label>Date</label>
                            <div class="form-group">
                                <input type="text" value="" name="date"
                                    class="form-control datepicker input-sm remarks_date" placeholder="Date" autocomplete="off"
                                    required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" value="" name="title"
                                    class="form-control input-sm" placeholder="Title" autocomplete="off"
                                    required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <img src="<?php echo base_url(); ?>assets/dist/img/file_upload.png"
                                    class="avatar rounded-circle img-thumbnail" width="130" height="130" src="#"
                                    id="uploadedImage3" name="userfile" width="130" height="130" alt="File">
                                <div class="observeFile">
                                    <div class="file btn btn-sm">
                                        <input type="file" class="form-control-sm" id="oFile" name="userfile"
                                            accept="*.jpg,*.png,*.jpeg,,*.pdf">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" id="description" class="form-control"
                                    placeholder="Enter Description" autocomplete="off" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-2 pb-0">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button id="staffInfoDownload" type="submit" class="btn btn-md btn-success"> SAVE</button>
                   
                </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/staff.js" type="text/javascript"></script>
<script type="text/javascript">
    $("form").submit(()=>{
        showLoader();
    });

jQuery(document).ready(function() {
    var loader = '<img height="70" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';
    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "staffSAchievemntsDocInfo/" + value);
        jQuery("#byFilterMethod").submit();
    });

    jQuery('.datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });
    });
</script>

