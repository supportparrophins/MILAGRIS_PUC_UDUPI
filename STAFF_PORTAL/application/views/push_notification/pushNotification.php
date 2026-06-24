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
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous"></script>
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
<div class="row column_padding_card">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container px-3 pt-1 overall_content">
    <div class="content-wrapper">
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class="col-lg-7 col-12 col-md-7 box-tools">
                                <span class="page-title">
                                    <i class="material-icons">send</i> Notification
                                </span>
                            </div>
                            <div class="col-lg-5 col-md-5 col-12 text-right">
                             <a onclick="showLoader();" href="<?=base_url();?>dashboard"
                                    class="btn primary_color mobile-btn float-right text-white"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>                     
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2 text-center ">
                        <?php echo form_open_multipart('push_notification/sendNotification')?>
                            <div id="errorMsg"></div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="card text-center">
                                        <div class="card-header bg-info h4 text-black">
                                        Choose send options
                                        </div>
                                        <div class="card-body" style="padding-bottom:10px;">
                                            <div class="row">
                                                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                                    <label style="float:left" for="user_name_select">Select By User</label>
                                                    <select class="form-control" name="user_name" id="user_name_select"
                                                        required>                                                       
                                                        <option value="student" selected>Student</option>
                                                        <?php if($role != ROLE_TEACHING_STAFF){ ?>
                                                            <option value="staff">Staff</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-6 col-md-12 col-sm-12 for-student">
                                                    <label style="float:left" for="term_name_select">Select By Term</label>
                                                    <select class="form-control" name="term_name" id="term_name_select">    
                                                         <?php if($role != ROLE_TEACHING_STAFF){ ?>
                                                            <option value="ALL">ALL</option>                                                       
                                                        <?php } ?>            
                                                        <option value="I PUC">I PUC</option>
                                                        <option value="II PUC">II PUC</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group col-lg-6 col-md-12 col-sm-12 for-student">
                                                    <label style="float:left"  for="stream_name_select">Select Stream*</label>
                                                    <select  class="form-control " required
                                                        name="stream_name" id="streamName" >
                                                         
                                                       <!-- <option value="">Select Stream</option> 
                                                        <?php 
                                                            if(!empty($streams)){
                                                                foreach ($streams as $stream)
                                                                {
                                                                    echo "<option value='".$stream->stream_name."'>".$stream->stream_name."</option>";
                                                                }
                                                            }
                                                        ?> -->
                                                    </select>
                                                </div>                                            
                                                <div class="form-group col-lg-6 col-md-12 col-sm-12 for-student">
                                                    <label style="float:left"  for="section_name_select">Select By Section Name</label>
                                                    <select data-live-search="true" class="form-control"
                                                        name="section_name" id="section_name_select">
                                                       
                                                        <?php 
                                                            if(!empty($sections)){
                                                                foreach ($sections as $section)
                                                                {
                                                                    echo "<option value='".$section->section_name."'>".$section->section_name."</option>";
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="form-group col-lg-6 col-md-12 col-sm-12 for-staff">
                                                <label style="float:left" for="role">Role<span class="text-danger"></span></label>
                                                <select name="role" class="form-control required selectpicker" id="role_id" data-live-search="true">
                                                    <option value="ALL">ALL</option>
                                                    <?php   if(!empty($designation))
                                                {
                                                    foreach ($designation as $rl)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $rl->roleId ?>" <?php if($rl->roleId == set_value('role')) {echo "selected=selected";} ?>><?php echo $rl->role ?></option>
                                                        <?php
                                                    }
                                                } ?>
                                                </select>
                                            </div>

                                            <div class="form-group col-lg-6 col-md-12 col-sm-12 for-staff">
                                                <label style="float:left" for="team_id">Department<span class="text-danger"></span></label>
                                                <select name="department" class="form-control required selectpicker"  data-live-search="true">
                                                    <option value="ALL">ALL</option>
                                                    <?php
                                                        if(!empty($departments))
                                                        {
                                                            foreach ($departments as $rl)
                                                            {
                                                                ?>
                                                                <option value="<?php echo $rl->dept_id ?>" <?php if($rl->id == set_value('role')) {echo "selected=selected";} ?>><?php echo $rl->name; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                </select>
                                            </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="card text-center">
                                        <div class="card-header bg-info h4 text-black">
                                            Message
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label style="float:left" for="msg_subject">Subject</label>
                                                <input class="form-control" name="msg_subject" id="msg_subject" autocomplete="off" placeholder="Write subject here" value="<?= set_value('msg_subject') ?>" required> 
                                            </div>  
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">  
                                                <label style="float:left" for="message">Message</label>                                                           
                                                <textarea class="form-control" rows="6"
                                                    placeholder="Write messages here...(Messages above 159 characters will be sent as 2 texts)"
                                                    id="message" name="message" required ><?= set_value('message') ?></textarea>
                                            </div>
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label style="float:left" for="msg_subject">Upload a File</label>
                                                <input class="form-control" type="file"  accept=".pdf,.doc,.docx,.png,.jpg,.jpeg" name="msg_file" id="msg_file" > 
                                            </div> 
                                            <!-- <div class="form-group col-lg-12 col-md-12 col-sm-12" style="padding-bottom:30px;">
                                                <div class="form-check">
                                                    <input style="float:left" type="checkbox" class="form-check-input" id="send_email_option" name="send_email_option">
                                                    <label style="float:left" class="form-check-label" for="send_email_option">Send email also</label>
                                                </div>
                                            </div> -->
                                            <input  type="submit" class="btn btn-success font-weight-bold btn-block" value="Send" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.for-staff').hide();
function studentSetUp(){
    $('.for-student').show();
    $('.for-staff').hide();
    $("#term_name_select").prop('required',true);
}
function clearStudentSetUp(){
    $('.for-student').hide();
    $("#term_name_select").prop('required',false);
    $("#term_name_select").val("ALL");
    $("#stream_name_select").val("ALL");
    $("#section_name_select").val("ALL");
    $('.for-staff').show();
}
    jQuery(document).ready(function() {
        if($("#user_name_select").val()=="staff"){
            clearStudentSetUp();
        }        
        $("#user_name_select").on('change', function() {
            if($(this).val()==="staff"){
                clearStudentSetUp();
            }else{
                studentSetUp();
            }
        });  
        $("#term_name_select").change(function(){
            var term_name = $(this).val();
            $("#streamName").prop('disabled', false);
            $("#streamName").empty().append('<option value="">Select Stream</option>');
            $("#section_name_select").prop('disabled', true);
            if(term_name != ''){
                $.ajax({
                    url: '<?php echo base_url(); ?>getStreamSectionByTermforNotification',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        term_name: term_name
                    },
                    success: function(data){
                        <?php if($role != ROLE_TEACHING_STAFF){ ?>
                            $("#streamName").append(
                                new Option('ALL', 'ALL')
                            );
                        <?php } ?>
                        var count = data.result.length;
                        if(count > 0){
                            for(var i = 0; i < count; i++){
                                $("#streamName").append(
                                    new Option(
                                        data.result[i].stream_name,
                                        data.result[i].stream_name
                                    )
                                );
                            }
                        }else{
                            $("#streamName").prop('disabled', true);
                        }
                    }
                });
            }else{
                $("#streamName").prop('disabled', true);
                $("#section_name_select").prop('disabled', true);
            }
        });
        var term_name = $("#term_name_select").val();;

            $("#streamName").prop('disabled', false);
            $("#streamName").empty().append('<option value="">Select Stream</option>');

            if(term_name != ''){

                $.ajax({
                    url: '<?php echo base_url(); ?>getStreamSectionByTermforNotification',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        term_name: term_name
                    },

                    success: function(data){

                        <?php if($role != ROLE_TEACHING_STAFF){ ?>
                            $("#streamName").append(
                                new Option('ALL', 'ALL')
                            );
                        <?php } ?>

                        var count = data.result.length;

                        if(count > 0){

                            for(var i = 0; i < count; i++){

                                $("#streamName").append(
                                    new Option(
                                        data.result[i].stream_name,
                                        data.result[i].stream_name
                                    )
                                );
                            }

                        }else{
                            $("#streamName").prop('disabled', true);
                        }
                    }
                });

            }else{
                $("#streamName").prop('disabled', true);
            }
            $("#streamName").change(function(){
                var term_name  = $("#term_name_select").val();
                var stream_name = $(this).val();
                $("#section_name_select").prop('disabled', false);
                $("#section_name_select").empty()
                                        .append('<option value="">Select Section</option>');
                $.ajax({
                    url: '<?php echo base_url(); ?>getSectionByTermforNotification',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        term_name: term_name,
                        stream_name: stream_name
                    },
                    success: function(data){
                        var count = data.section.length;
                        if(count > 0){
                            for(var i = 0; i < count; i++){
                                $("#section_name_select").append(
                                    new Option(
                                        data.section[i].section_name,
                                        data.section[i].section_name
                                    )
                                );
                            }
                        }else{
                            $("#section_name_select").prop('disabled', true);
                        }
                    }
                });
            });
            var term_name  = $("#term_name_select").val();
            var stream_name = $("#streamName").val();
            $("#section_name_select").prop('disabled', false);
            $("#section_name_select").empty()
                                        .append('<option value="">Select Section</option>');
            $.ajax({
                url: '<?php echo base_url(); ?>getSectionByTermforNotification',
                type: 'POST',
                dataType: 'json',
                data: {
                    term_name: term_name,
                    stream_name: stream_name
                },
                success: function(data){
                    var count = data.section.length;
                    if(count > 0){
                        for(var i = 0; i < count; i++){
                            $("#section_name_select").append(
                                new Option(
                                    data.section[i].section_name,
                                    data.section[i].section_name
                                )
                            );
                        }
                    }else{
                        $("#section_name_select").prop('disabled', true);
                    }
                }
            });
    });
</script>