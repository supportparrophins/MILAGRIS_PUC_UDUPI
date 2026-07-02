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
.editable { min-height: 100px; }
.feedback_profile{
    border-radius: 50%;
    width: 70px;
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
<div class="row column_padding_card">
    <div class="col-12">
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
                            <div class="col-lg-4 col-12 col-md-12 col-sm-12 box-tools">
                                <span class="page-title">
                                    <i class="material-icons">chat</i> Student Portal Suggestions
                                </span>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 col-sm-5">
                                <form action="<?php echo base_url() ?>suggestionListing" method="POST" id="searchList">
                                    <div class="input-group mobile-btn" style="width: 230px !important">
                                        <input type="text" name="searchTextCust" value="<?php echo $searchTextCust ?>"
                                            class="form-control input-md pull-right" style="text-transform: uppercase"
                                            placeholder="Search by Student ID" autocomplete="off" />
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary searchList" style="height: 40px !important"><i
                                                    class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-4 col-md-5 col-12 col-sm-6">
                                <a onclick="showLoader();window.history.back();"
                                    class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>    
                                    <a class="btn btn-primary mobile-btn float-right border_right_radius"
                                onclick="clearFields();"   type="reset" href="#" data-toggle="modal" id="btn_add"
                                    data-target="#portalModal"><i class="fa fa-plus"></i> Add New</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2 ">
                        <?php if(!empty($suggestionInfo)) {
                                foreach($suggestionInfo as $feedback) { 
                                  
                                    if(!empty($feedback->document)){
                                       $img_src =  'data:' . ';base64,' . base64_encode($feedback->document);
                                    } else { 
                                         $img_src = base_url().'assets/dist/img/user.png'; 
                                 } ?>

                        <input type="hidden" value="<?php echo $feedback->row_id; ?>" id="row_id" name="row_id">
                        <div class="card "
                            onclick="openModel('<?php echo $img_src; ?>','<?php echo $feedback->student_id; ?>','<?php echo $studentMessageInfo[$feedback->student_id]['row_id']; ?>')"
                            style="background-color: #1ba0198c;">
                            <div class="card-body" style="padding: 8px;">
                                <div class="row">
                                    <div class="col-lg-1 col-md-2 col-12 col-sm-2 text-center">
                                        <img  src="<?php echo $img_src; ?>" class="feedback_profile"
                                            alt="Student Image" />
                                    </div>
                                    <div class="col-lg-11 col-md-10 col-12 col-sm-10">
                                        <div class="row">
                                            <div class="col-lg-2 col-sm-5 col-5">
                                                <label>ID : <span
                                                        style="color:#0c07a8;"><?php echo $feedback->stud_id ?></span></label>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-7">
                                                <label>Name : <span
                                                        style="color:#0c07a8;"><?php echo strtoupper($feedback->student_name) ?></span></label>
                                            </div>
                                            <div class="col-lg-2 col-sm-5 col-5">
                                                <label>Term & Section : <span
                                                        style="color:#0c07a8;"><?php echo $feedback->term_name ?>
                                                        <?php echo $feedback->section_name ?></span></label>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-7">
                                                <label>Date: <span
                                                        style="color:#0c07a8;"><?php echo date('d-m-Y h:i A',strtotime($studentMessageInfo[$feedback->student_id]['date'])) ?></span></label>
                                            </div>
                                        </div>
                                        <hr class="my-1 mx-1" style="border-top: 1px solid #3c8dbc;">
                                        <div class="row">
                                            <div class="col-lg-10 col-sm-9 col-xs-9 pb-1">
                                                <label><i class="fa fa-envelope"></i>&nbsp; <span
                                                        style="color:#0c07a8;"><?php
                                                            $msg = $studentMessageInfo[$feedback->student_id]['msg'];
                                                            if(strlen($msg) > 120){ ?>
                                                        <span><?php echo substr($msg,0,120); ?>....</span>
                                                        <?php }else{
                                                                echo $msg; 
                                                            } ?></span></label>
                                            </div>
                                            <div class="col-lg-2 col-sm-3 col-xs-3">
                                                <?php //if($role == ROLE_PRINCIPAL || $role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR) { ?>
                                                <?php if($accessInfo->can_edit == '1'){ ?>
                                                <button type="button"
                                                    class="btn btn-block btn-sm btn-primary btn_send pull-right"><i
                                                        class="fa fa-eye "></i> View</button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><br>

                        <?php } }else{ ?>
                        <div class="card" style="background-color: #00a65a7d;">
                            <div class="card-body" style="padding: 8px;">
                                <div class="row text-center">
                                    <div class="col-lg-12 col-xs-12 col-sm-12">
                                        <label>No Suggestions!.<span style="color:#ce1010;"></span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="float-right clearfix">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- replay and more view modal -->
<div id="myModal" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header suggestion_header" style="background-color: #1ba0198c;">
                <h4 class="modal-title"></h4>
                <button type="button" class="close float-right" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-2">
                <div id="msg"></div>
                <div class="suggestion_box ">
                    <div id="chat" class="chat_box_wrapper chat_box_small chat_box_active" style="opacity: 1; display: block; transform: translateX(0px);">
                        <div class="chat_box touchscroll chat_box_colors_a" id="chatBox">
                        
                        
                            
                        </div>
                        <!-- <div class="chat_box touchscroll chat_box_colors_a" id="chatBoxReply">
                                
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="modal-footer suggestion_footer">
                <div class="chat_submit_box">
                    <div class="row">
                        <div class="uk-input-group">
                        <div id="msg_replay"></div>
                                <div class="gurdeep-chat-box">
                                    <div class="col-lg-10 col-md-10 col-xs-12 chat_col_padding_right_null">
                                        <input type="hidden" name="rowID" id="rowID" value="">
                                        <textarea rows="3" placeholder="Type a message" id="submit_message" name="submit_message" class="md-input" required autocomplete="off"></textarea>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-xs-12 chat_col_padding_left_null">
                                        <button type="submit" onclick="sendMessage()" class="btn btn-primary btn-block" id="btn-chat">Send</button>
                                    </div>
                                </div>
                           
                        </div>
                    </div>
                </div>
            </div>
            </div>

        </div>
    </div>

    
    <div id="portalModal" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header suggestion_header" style="background-color: #1ba0198c;">
                <h4 class="modal-title">Send Suggestion</h4>
                <button type="button" class="close float-right" data-dismiss="modal">&times;</button>
            </div>
              <form id="" method="POST" action="<?php echo base_url().'sendMsgByStudentId'?>">
            <div class="modal-body p-2">
                <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                    <label for="role">Select Student</label>
                    <select class="form-control input-sm selectpicker" id="student_id"
                        name="student_id" data-live-search="true" required>
                        <option value="">Select Student </option>
                        <?php
                            if(!empty($studentInfo)) {
                                foreach ($studentInfo as $std) { ?>
                        <option value="<?php echo $std->row_id ?>">
                            <?php echo $std->student_id.' - '.strtoupper($std->student_name) ?></option>
                        <?php  } } ?>
                    </select>
                </div>
            </div>
            </div>
            <div class="modal-footer suggestion_footer">
                <div class="chat_submit_box">
                        <div class="row">
                       
                                <div class="gurdeep-chat-box">
                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 chat_col_padding_right_null">
                                        <input type="hidden" name="rowID" id="rowID" value="">
                                        <textarea rows="3" placeholder="Type a message" id="submit_message" name="send_message" class="md-input" required autocomplete="off"></textarea>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 chat_col_padding_left_null">
                                        <button type="submit" onclick="sendMessage()" class="btn btn-primary btn-block" id="btn-chat">Send</button>
                                    </div>
                                </div>
                       
                           </div>
                       </form>
                  </div>
                  </div>
             </div>
        </div>
    </div>
    <script>
$("#btn-chat").click(function() {
    $('#submit_message').val("");
});
    function openModel(profile_img, student_id,row_id){
        $('#rowID').val(row_id);
        // $('#submit_message').val("");
        $.ajax({
            url: '<?php echo base_url(); ?>/getStudentMessageById',
            type: 'POST',
            data: {
                student_id : student_id,
            },
            success: function(data) {
                var studentInfo = JSON.parse(data);
                var newHtml = "";
                $.each(studentInfo, function(index, value) {
                    var fromDateTime =  value.date;
                    var toDateTime = value.updated_date_time;
                    var fromHour = new Date(fromDateTime).getHours();
                    var ampm = "AM";
                    if(fromHour > 12 ) {
                        fromHour -= 12;
                        ampm = "PM";
                    }
                    var toHour = new Date(toDateTime).getHours();
                    var toampm = "AM";
                    if(toHour > 12 ) {
                        toHour -= 12;
                        toampm = "PM";
                    }
                    $('.modal-title').html('Suggestion From <span style="">Student ID: '+ value.student_id + '</span>');


                    if(value.message != '' || value.message == null){
                    newHtml += '<div class="chat_message_wrapper" id="chatResponse">'
                    newHtml += '<div class="chat_user_avatar">'
                    newHtml += '<span id="imageUser"><img src="'+ profile_img +'" class="md-user-image"  alt="Student Image"/></span>'
                    newHtml += '</div>'
                    newHtml += '<ul class="chat_message">'
                    newHtml += '<li>'
                    newHtml += '<p>'
                    newHtml += '<span id="senderMsg">'+ value.message +'</span>'
                    newHtml += '<span class="chat_message_time"> <span class="text-capitalize" id="response" style="color: red;">'+ value.msg_from +'</span> •  <span id="responseTime">'+ appendLeadingZeroes(new Date(fromDateTime).getDate()) + "-" +  appendLeadingZeroes((new Date(fromDateTime).getMonth() + 1)) 
                                + "-" + new Date(fromDateTime).getFullYear() + " " + appendLeadingZeroes(fromHour) + ":" + appendLeadingZeroes(new Date(fromDateTime).getMinutes()) + " " + ampm +'</span></span>'
                    newHtml += '</p>'
                    newHtml += '</li>'
                    newHtml += '</ul>'
                    newHtml += '</div>'
                    }
                    if(value.management_reply == null || value.management_reply == ""){
                        $('#chatReply').hide();
                    }else{
                        newHtml += '<div class="chat_message_wrapper chat_message_right" id="chatReply'+value.row_id+'">'
                        newHtml += '<div class="chat_user_avatar">'
                        newHtml += '<span id="mngtImage"><img src="'+baseURL+'<?php echo INSTITUTION_LOGO ?>" alt="Management Image" class="md-user-image"/></span>'
                        newHtml += '</div>'
                        newHtml += '<ul class="chat_message">'
                        newHtml += '<li>'
                        newHtml += '<p id="mngtReply">'+ value.management_reply +'</p>'
                        newHtml += '<span class="chat_message_time"> <span class="text-capitalize" style="color: red;" id="reply">'+ value.reply_from +'</span> • <span id="replyTime">'+ appendLeadingZeroes(new Date(toDateTime).getDate()) + "-" +  appendLeadingZeroes((new Date(toDateTime).getMonth() + 1)) 
                                    + "-" + new Date(toDateTime).getFullYear() + " " + appendLeadingZeroes(toHour) + ":" + appendLeadingZeroes(new Date(toDateTime).getMinutes()) + " " + toampm +'</span> </span>'
                        // if(value.is_viewed == 1){
                            // let toHour2 = new Date(value.viewed_date_time).getHours();
                            // let toampm2 = "AM";
                            // if(toHour2 > 12 ) {
                            //     toHour2 -= 12;
                            //     toampm2 = "PM";
                            // }
                            // newHtml += '<span style="font-weight:500;font-size:13px;float:right"> <span style="color: blue;">'+ "read @" +'</span> • <span style="color:grey">'+ appendLeadingZeroes(new Date(value.viewed_date_time).getDate()) + "-" +  appendLeadingZeroes((new Date(value.viewed_date_time).getMonth() + 1)) 
                            //         + "-" + new Date(value.viewed_date_time).getFullYear() + " " + toHour2 + ":" + new Date(value.viewed_date_time).getMinutes()+ " " + (toampm2) +'</span> </span>'
                        // }else{
                            // newHtml += '<span> <span style="color: grey;font-weight:400;float:right">'+ "unread" + '</span></span>';
                        // }
                        newHtml += '</li>'
                        newHtml += '</ul>'
                        newHtml += '</div>'
                        $('#chatReply').show();
                    }
                    $('#myModal').modal('show');
                });
                $("#chatBox").html(newHtml);
            },
            error: function(result){
                alert("Error! Something Went Wrong");
            },
            fail:(function(status) {
                alert("Server Error!!")
            }),
            beforeSend:function(d){
                // $('.modal-title').html('<center> Loading..</center>');
            }
            
        });
    }

function appendLeadingZeroes(n) {
    if (n <= 9) {
        return "0" + n;
    }
    return n;
} 
</script>

<script>
function sendMessage(){
    $('#msg_replay').html('');
    var row_id = $("#rowID").val();
    var message = $("#submit_message").val()
    if(message == ""){
        $('#msg_replay').html(`<div class="alert alert-danger" role="alert">
            Please Enter Message
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        </div>`);
    }else{
        $.ajax({
            url: baseURL+'/updateManagementMsg',
            type: 'POST',
            data: {
                submit_message : message,
                row_id  : row_id
            },
            success: function(data) {
                location.reload();
                // var newHtml = "";
                
                // newHtml += '<div class="chat_message_wrapper chat_message_right" id="chatReplyMngt">'
                // newHtml += '<div class="chat_user_avatar">'
                // newHtml += '<span id="mngtImage"><img src="'+baseURL+'assets/dist/img/logo_sjpuch.jpg" alt="Management Image" class="md-user-image"/></span>'
                // newHtml += '</div>'
                // newHtml += '<ul class="chat_message">'
                // newHtml += '<li>'
                // newHtml += '<p id="mngtReply">'+ message +'</p>'
                // newHtml += '<span class="chat_message_time"> <span class="text-capitalize" style="color: red;" id="reply">Principal</span> • <span id="replyTime"><?php echo date('d-m-y H:i A'); ?></span> </span>'
                // newHtml += '</li>'
                // newHtml += '</ul>'
                // newHtml += '</div>'

                // $('#chatReplyMngt').show();
                // $("#chatBox #chatReply"+row_id).html(newHtml);
                
            },
            error: function(result){
                alert("Error! Something Went Wrong");
            },
            fail:(function(status) {
                alert("Server Error!!")
            }),
            beforeSend:function(d){
                // $('.modal-title').html('<center> Loading..</center>');
            }
        });
    }
}


jQuery(document).ready(function(){
  jQuery('.datepicker').datepicker({
    autoclose: true,
    format : "dd-mm-yyyy"
  });

    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#searchList").attr("action", baseURL + "suggestionListing/" + value);
        jQuery("#searchList").submit();
    });
    
});
</script>