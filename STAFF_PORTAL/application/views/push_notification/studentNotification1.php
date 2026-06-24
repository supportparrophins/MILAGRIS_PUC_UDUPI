<?php
    $this->load->helper('form');
    $error = $this->session->flashdata('error');
    if($error)
    {
?>
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    ?php echo $this->session->flashdata('error'); ?>                    
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
<div class="main-content-container px-3 pt-1">               
<div class="row">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>


 <!-- Content Header (Page header) -->
<div class="row p-0">
    <div class="col column_padding_card">
        <div class="card card-small card_heading_title p-0 m-b-1">
            <div class="card-body p-2">
                <div class="row c-m-b">
                    <div class="col-8 col-sm-4 col-md-5">
                        <span class="page-title absent_table_title_mobile">
                           <i class="material-icons">notifications</i> Student Notifications
                        </span>
                    </div>
                    <div class="col-4 col-sm-4 col-md-3">
                        <div class="text-center text-dark">
                            <b class="pull-left" style="font-size: 20px;">Total : <?php echo $totalCount ?></b>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 col-md-4 box-tools">
                        <a onclick="window.history.back();" class="btn primary_color border_left_radius mobile-btn float-right text-white pt-2"
                            value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>        
                             
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row form-employee">
    <div class="col-12 column_padding_card">
        <div class="card card-small c-border p-1">
            <div class="table-responsive-sm">
                <table class="table table-bordered text-dark">
                    <form action="<?php echo base_url() ?>studentNotifications" method="POST" id="searchList">
                        <tr class="filter_row">
                            <th width="180">
                                <div class="form-group"> 
                                    <input type="text" name="by_date" value="<?php echo $by_date; ?>" class="form-control form-control-md  datepicker pull-right" placeholder="Search by Date" autocomplete="off"/>
                                </div>
                            </th>
                            <th width="100"> 
                                <div class="form-group mb-0">
                                            <select class="form-control" name="by_term" id="by_term">
                                                <?php if(!empty($by_term)){ ?>
                                                    <option value="<?php echo $by_term; ?>" selected><b>Selected: <?php echo $by_term; ?></b></option>
                                                <?php } ?>
                                                <option value="">Search Term</option>
                                                <option value="I PUC">I PUC</option>
                                                <option value="II PUC">II PUC</option>
                                            </select>
                                        
                                </div>
                            </th>
                            <th width="100"><div class="form-group mb-0">
                                            <select class="form-control" name="by_stream" id="by_stream">
                                                <?php if(!empty($by_stream)){ ?>
                                                    <option value="<?php echo $by_stream; ?>" selected><b>Selected: <?php echo $by_stream; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Stream</option>
                                                <option value="ALL">ALL</option>
                                                <?php if(!empty($streamInfo)){
                                                    foreach($streamInfo as $stream){ ?>
                                                <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                            </th>
                            <th width="100">
                            <div class="form-group mb-0">
                                            <select class="form-control" name="by_Section" id="by_Section">
                                                <?php if(!empty($by_Section)){ ?>
                                                    <option value="<?php echo $by_Section; ?>" selected><b>Selected: <?php echo $by_Section; ?></b></option>
                                                <?php } ?>
                                                <option value="">By Section</option>
                                                <option value="ALL">ALL</option>
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
                                     </th>  
                            <th width="150">  
                                <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $by_subject; ?>" name="by_subject" id="by_subject" class="form-control input-sm" placeholder="By Subject" autocomplete="off">
                                </div>
                            </th>
                            <th>
                                 <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $by_message; ?>" name="by_message" id="by_message" class="form-control input-sm" placeholder="By Message" autocomplete="off">
                                </div>  
                            </th>
                             <th>
                                 <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $sent_by; ?>" name="sent_by" id="sent_by" class="form-control input-sm" placeholder="Sent By" autocomplete="off">
                                </div>  
                            </th>
                             <th>
                                <button class="btn btn-block btn-success searchList"><i class="fa fa-filter"></i> Filter </button>
                            </th>
                        </tr>
                    </form>
                        <thead class="text-center">
                            <tr class="table_row_background">
                                <th>Date</th>
                                <th>Term</th>
                                <th>Stream</th>
                                <th>Section</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Sent By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <thead>
                        <?php if(!empty($notifications)) {
                                foreach($notifications as $notification) { ?>
                            <tr>
                                <td class="text-center"><?php echo date('d-m-Y',strtotime($notification->date_time)); ?></td>
                                <td class="text-center"><?php echo $notification->term_name; ?></td>
                                <td class="text-center"><?php echo $notification->stream_name; ?></td>
                                <td class="text-center"><?php echo $notification->section_name; ?></td>
                                <td><?php echo $notification->subject; ?></td>
                                <td><?php echo $notification->message; ?></td>
                                <td class="text-center"><?php echo $notification->sent_by; ?></td>
                                <td class="text-center">
                                                <?php 
                                                    if($notification->filepath !=""){?>
                                                        <a class='btn btn-primary' href='<?= base_url().$notification->filepath ?>' download><i class='fa fa-download'></i> Download</a>
                                                    <?php }
                                                ?>
                                    <?php if($role == ROLE_OFFICE || $role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN) { ?>
                                        <a class="btn btn-xs btn-danger deleteStudentNotification mb-1"
                                                data-row_id="<?php echo $notification->row_id; ?>" href="#" title="Delete">
                                                <i class="fas fa-trash"></i></a>
                                    <?php } ?>
                                   
                                </td>
                            </tr>
                            <?php } }else{ ?>
                            <tr class="table-info">
                                <td class="text-center" colspan="8">
                                    No Notification!.
                                </td>
                            </tr>
                            <?php } ?>
                            </thead>
                        </table>
                    </div>
                    <div class="box-footer clearfix">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div>
            </div>
        </div>
 

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/websiteCommon.js" charset="utf-8"></script>
<script>
jQuery(document).ready(function(){

    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#searchList").attr("action", baseURL + "studentNotifications/" + value);
        jQuery("#searchList").submit();
    });
    
    jQuery('.datepicker').datepicker({
        autoclose: true,
        format : "dd-mm-yyyy",
        startDate : "01-01-2020"
    });

      jQuery(document).on("click", ".deleteStudentNotification", function(){
            var row_id = $(this).data("row_id"),
                hitURL = baseURL + "deleteStudentNotification",
                currentRow = $(this);
            
            var confirmation = confirm("Are you sure delete this Notification ?");
            
            if(confirmation)
            {
                jQuery.ajax({
                type : "POST",
                dataType : "json",
                url : hitURL,
                data : { row_id : row_id } 
                }).done(function(data){
                        
                    currentRow.parents('tr').remove();
                    if(data.status = true) { alert("Notification successfully Deleted"); 
                window.location.reload();}
                    else if(data.status = false) { alert("Failed to delete Notification"); }
                    else { alert("Access denied..!"); }
                });
            }
        });


});
</script>

  
