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

#text_message_count{
    font-size: 18px !important;
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
                                    <i class="material-icons">chat</i> SMS Portal
                                </span>
                            </div>
                            <div class="col-lg-5 col-md-5 col-12 text-right">
                                <!-- <a onclick="window.history.back();"
                                    class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a> -->
                                <span class="page-title ">SMS Balance:
                                    <?php echo $sms_balance; ?></span>
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
                        <form method="POST" action="<?php echo base_url() ?>sendBulkSMS" id="formSmsBulk">
                            <div id="errorMsg"></div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="card text-center">
                                        <div class="card-header bg-info h4 text-black m-0">
                                        Choose send options
                                        </div>
                                        <div class="card-body p-0">
                                            <input type="hidden" name="input_sms_option_type" id="sms_option_type" value="sms_option_single"/>
                                            <ul class="nav nav-tabs" id="sms_options_tab" role="tablist">
                                                <li class="nav-item" data-sms_option_type="sms_option_single">
                                                    <a class="nav-link active" id="sms_option_single_tab" data-toggle="tab" href="#sms_option_single_tab_content" role="tab" aria-controls="single" aria-selected="true">Single</a>
                                                </li>
                                                <li class="nav-item" data-sms_option_type="sms_option_std_group">
                                                    <a class="nav-link" id="sms_option_std_group_tab" data-toggle="tab" href="#sms_option_std_group_tab_content" role="tab" aria-controls="std_group" aria-selected="false">Student</a>
                                                </li>
                                                <li class="nav-item" data-sms_option_type="sms_option_staff_group">
                                                    <a class="nav-link" id="sms_option_staff_group_tab" data-toggle="tab" href="#sms_option_staff_group_tab_content" role="tab" aria-controls="staff_group" aria-selected="false">Staff</a>
                                                </li>
                                                <li class="nav-item" data-sms_option_type="sms_option_list">
                                                    <a class="nav-link" id="sms_option_list_tab" data-toggle="tab" href="#sms_option_list_tab_content" role="tab" aria-controls="list" aria-selected="false">List</a>
                                                </li>
                                                <li class="nav-item" data-sms_option_type="sms_option_by_student">
                                                    <a class="nav-link" id="sms_option_by_student" data-toggle="tab" href="#sms_option_by_student_content" role="tab" aria-controls="list" aria-selected="false">By Student</a>
                                                </li>
                                                <!-- <li class="nav-item" data-sms_option_type="sms_option_by_group">
                                                    <a class="nav-link" id="sms_option_by_group" data-toggle="tab" href="#sms_option_by_group_content" role="tab" aria-controls="list" aria-selected="false">By Group</a>
                                                </li> -->
                                            </ul>
                                            <style>
                                                p{
                                                    text-align: start;
                                                }
                                                .sms_option_tab_content.flex_container{
                                                    display: flex;
                                                    flex-direction: column;
                                                }
                                                .sms_option_tab_content.flex_item{
                                                    display: flex;
                                                    width: 100%;
                                                }
                                                .sms_option_tab_content.option_info{
                                                    border: 1px solid black;
                                                }
                                                .sms_option_tab_content.input{
                                                    flex-direction: column;
                                                    align-items: flex-start;
                                                }
                                            </style>
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="sms_option_single_tab_content" role="tabpanel" aria-labelledby="single-tab">
                                                    <div class="sms_option_tab_content flex_container m-3">
                                                        <div class="sms_option_tab_content option_info flex_item p-2">
                                                            <div class="pr-2">
                                                                <i style="font-size: 30px" class="fas fa-info-circle"></i>
                                                            </div>
                                                            <p class="m-0">
                                                                Please enter a valid mobile number.
                                                            </p>
                                                        </div>
                                                        <div class="sms_option_tab_content input flex_item mt-3">
                                                            <input class="form-control" type="text" name="input_single_phone_number" id="single_phone_number" placeholder="Enter the phone number"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="sms_option_std_group_tab_content" role="tabpanel" aria-labelledby="group-tab">
                                                    <div class="sms_option_tab_content flex_container m-3">
                                                        <div class="sms_option_tab_content option_info flex_item p-2">
                                                            <div class="pr-2">
                                                                <i style="font-size: 30px" class="fas fa-info-circle"></i>
                                                            </div>
                                                            <p class="m-0">
                                                                Please select the group.
                                                            </p>
                                                        </div>
                                                        <div class="sms_option_tab_content input flex_item mt-3">
                                                            <label style="float:left" for="">Select By Term</label>
                                                            <select class="form-control" name="term_name" id="term_name_select" required>
                                                                <option value="">Select Term</option>  
                                                                <option value="I PUC">I PUC</option>
                                                                <option value="II PUC">II PUC</option>
                                                            </select>
                                                        </div>
                                                        <div class="sms_option_tab_content input flex_item mt-3">
                                                            <label style="float:left"  for="">Select By Stream</label>
                                                            <select data-live-search="true" class="form-control selectpicker"
                                                                name="stream_name" id="stream_stream_select" multiple required>
                                                                <option value="">Select Stream</option>
                                                                <!-- <option value="ALL">ALL</option> -->
                                                                <?php 
                                                                    if(!empty($streamInfo)){
                                                                        foreach($streamInfo as $stream){
                                                                            echo "<option value='".$stream->stream_name."'>".$stream->stream_name."</option>";
                                                                        }
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="sms_option_tab_content input flex_item mt-3">
                                                            <label style="float:left"  for="">Select By Section</label>
                                                            <select data-live-search="true" class="form-control"
                                                                name="section_name" id="section_select" required>
                                                                <option value="ALL">ALL</option>
                                                                <option value="A">A</option>
                                                                <option value="B">B</option>
                                                                <option value="C">C</option>
                                                                <option value="D">D</option>
                                                                <option value="E">E</option>
                                                                <option value="F">F</option>
                                                                <option value="G">G</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="sms_option_staff_group_tab_content" role="tabpanel" aria-labelledby="group-tab">
                                                    <div class="sms_option_tab_content flex_container m-3">
                                                        <div class="sms_option_tab_content option_info flex_item p-2">
                                                            <div class="pr-2">
                                                                <i style="font-size: 30px" class="fas fa-info-circle"></i>
                                                            </div>
                                                            <p class="m-0">
                                                                Please select the group.
                                                            </p>
                                                        </div>
                                                        <div class="sms_option_tab_content input flex_item mt-3">
                                                            <label style="float:left" for="">Select By Department</label>
                                                            <select class="form-control" name="department" id="department_select" required>                                                                 
                                                                <option value="ALL">ALL</option> 
                                                                <?php 
                                                                    if(!empty($departments)){
                                                                        foreach($departments as $dept){
                                                                            echo "<option value='".$dept->dept_id."'>".$dept->name."</option>";
                                                                        }
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="sms_option_list_tab_content" role="tabpanel" aria-labelledby="list-tab">
                                                    <div class="sms_option_tab_content flex_container m-3">
                                                        <div class="sms_option_tab_content option_info flex_item p-2">
                                                            <div class="pr-2">
                                                                <i style="font-size: 30px" class="fas fa-info-circle"></i>
                                                            </div>
                                                            <p class="m-0">
                                                                Copy and paste a list of mobile numbers in to the bo below. Ensure that you enter one number per line.
                                                                (All duplicates will automatically be removed)
                                                            </p>
                                                        </div>
                                                        <div class="sms_option_tab_content input flex_item mt-3">
                                                            <textarea style="width:100%;" rows="11" id="input_list_phone_number" name="input_list_phone_number"></textarea>
                                                        </div>
                                                    </div>
                                                </div>   
                                                
                                                <div class="tab-pane fade" id="sms_option_by_student_content" role="tabpanel" aria-labelledby="list-tab">
                                                    <div class="sms_option_tab_content flex_container m-3">
                                                        <!-- <div class="sms_option_tab_content option_info flex_item p-2">
                                                            <div class="pr-2">
                                                                <i style="font-size: 30px" class="fas fa-info-circle"></i>
                                                            </div>
                                                            <p class="m-0">
                                                                Copy and paste a list of mobile numbers in to the bo below. Ensure that you enter one number per line.
                                                                (All duplicates will automatically be removed)
                                                            </p>
                                                        </div> -->
                                                        <div class="sms_option_tab_content input flex_item mt-3">
                                                            <label style="float:left" for="">Select By Student</label>
                                                            <select class="form-control selectpicker" name="student" id="student_select" data-live-search="true" required>    
                                                                <option value="">Select Student</option>
                                                                <?php 
                                                                    if(!empty($studentInfo)){
                                                                        foreach($studentInfo as $std){
                                                                            echo "<option value='".$std->student_id."'>".$std->student_id.' '.$std->student_name.' - '.$std->term_name."</option>";
                                                                        }
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="sms_option_tab_content input flex_item mt-3">
                                                            <textarea style="width:100%;" rows="11" id="input_student_phone_number" name="input_student_phone_number"></textarea>
                                                        </div>
                                                        <button class="btn btn-success" id="student_select_button" type="button" class="mt-2">Add</button>
                                                    </div>
                                                </div> 
                                                
                                                <div class="tab-pane fade" id="sms_option_by_group_content" role="tabpanel" aria-labelledby="list-tab">
                                                    <div class="sms_option_tab_content flex_container m-3">
                                                        
                                                        <div class="sms_option_tab_content input flex_item mt-3">
                                                            <label style="float:left" for="">Select By Student</label>
                                                            <select class="form-control selectpicker" name="student[]" id="student_group_select" data-live-search="true" multiple required>    
                                                                <option value="">Select Student</option>
                                                                <?php 
                                                                    if(!empty($studentGroupInfo)){
                                                                        foreach($studentGroupInfo as $std){
                                                                            echo "<option value='".$std->student_id."'>".$std->sms_name.'-'.$std->student_name."</option>";
                                                                            //  log_message('debug','test=='.print_r($std->student_id,true));
                                                                        }
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <!-- <div class="sms_option_tab_content input flex_item mt-3">
                                                            <textarea style="width:100%;" rows="11" id="input_student_phone_number" name="input_student_phone_number"></textarea>
                                                        </div>
                                                        <button class="btn btn-success" id="student_select_button" type="button" class="mt-2">Add</button> -->
                                                    </div>
                                                </div>                  
                                            </div>
                                            <div class="customCheckBox m-3">
                                                <input id="parentsMobile" type="checkbox" value="parentsMobile"
                                                    name="parentsMobile" checked>
                                                <label for="parentsMobile" class="mr-3">Parent's Mobile</label>
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="card text-center">
                                        <div class="card-header bg-info h4 text-black m-0">
                                            Message Details
                                        </div>
                                        <div class="card-body">
                                            <style>
                                                .sms_details.flex_container{
                                                    display: flex;
                                                    flex-direction: column;
                                                }
                                                .sms_details.flex_item{
                                                    display: flex;
                                                    width: 100%;
                                                }
                                                .sms_details.input{
                                                    flex-direction: column;
                                                    align-items: flex-start;
                                                }
                                                .sms_details.info, .sms_details.msg_area{
                                                    border: 1px solid black;
                                                }
                                                .sms_details.msg_area > p{
                                                    font-size: 20px;
                                                    line-height: 2.2rem;
                                                }
                                                span.editableSpan[contenteditable=true]:empty:before{
                                                    content: attr(placeholder);
                                                }
                                                span.editableSpan[contenteditable]{
                                                    font-style: bold;
                                                    color: green;
                                                }
                                                span.multipleEditableText[contenteditable=true]:empty:before{
                                                    content: attr(placeholder);
                                                }
                                                span.multipleEditableText[contenteditable]{
                                                    font-style: bold;
                                                    color: green;
                                                }
                                            </style>
                                            <div class="sms_details flex_container">
                                                <div class="sms_details input flex_item">
                                                    <label>Template</label>
                                                    <select class="form-control form-control-md selectpicker" id="template_id" data-live-search="true" required>
                                                        <?php
                                                            foreach($templates as $tmp){?>
                                                            <option value="<?=$tmp->row_id;?>"><?=$tmp->name;?></option>
                                                        <?php    }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="sms_details input flex_item mt-2">
                                                    <label>Linked Headers</label>
                                                    <input class="form-control" type="text" id="linked_header" value="" disabled/>
                                                </div>
                                                <div class="sms_details input flex_item mt-2">
                                                    <label>Template Registration Number</label>
                                                    <input class="form-control" type="text" id="template_reg_no" value="" disabled/>
                                                </div>
                                                <div class="sms_details info flex_item p-2 mt-3">
                                                    <div class="pr-2">
                                                        <i style="font-size: 30px" class="fas fa-info-circle"></i>
                                                    </div>
                                                    <p class="m-0">
                                                        Please fill out the following to generate the required message.
                                                    </p>
                                                </div>
                                                <div class="sms_details msg_area flex_item p-2 mt-3">
                                                    <p class="m-0" id="msg_body"></p>
                                                </div>
                                                <span id="text_message_count" class="text-dark text-right float-right"></span>
                                                <div class="mt-2">
                                                    <button type="button" onclick="validateSMSForm()" class="btn btn-primary float-right">Submit</button>
                                                </div>
                                            </div>
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
<script>
    const setErrorMessage = err_msg =>{
        if(err_msg){
            $('#errorMsg').html(`<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Error!</strong> ` + err_msg + `</div>`);
        }else $('#errorMsg').html('');
    }
    const getMessage = ()=>{
        let msgStr = $("#msg_body").text();
        // msgStr = msgStr.replace(/\s+/g, " ").trim();
        return msgStr;
    }
    const confirmSMSDelivery = ()=>{
        const smsOpt = $('#sms_option_type').val();
        const message = getMessage();
        const msg_cost = countSmsCost(message.length);
        var tableRows = "";
        if(smsOpt == "sms_option_single"){
            const phoneNumber = $("#single_phone_number").val();
            tableRows += "<tr>" +
                            "<th>Phone Number</th>" +
                            "<td>"+ $("#single_phone_number").val() +"</td>" +
                        "</tr><tr>" +
                            "<th>To</th>" +
                            "<td>Parent's</td>" +
                        "</tr><tr>" +
                            "<th>Message</th>" +
                            "<td>"+ message +"</td>" +
                        "</tr><tr>" +
                            "<th>Per SMS Cost</th>" +
                            "<td>"+ msg_cost +"</td>" +
                        "</tr>";
            $("#smsConfirmModalTable").html(tableRows);
            $('#confirm-submit').modal('show');
            
        }else if(smsOpt == "sms_option_std_group"){
            const termName = $("#term_name_select").val();
            const sectionName = $("#section_select").val();
            const streamName = $("#stream_stream_select").val();
            tableRows += "<tr>" +
                            "<th>Term</th>" +
                            "<td>"+ termName +"</td>" +
                        "</tr><tr>" +
                            "<th>Stream</th>" +
                            "<td>"+ streamName +"</td>" +
                        "</tr>"
                        "<tr>" +
                            "<th>Section</th>" +
                            "<td>"+ sectionName +"</td>" +
                        "</tr><tr>" +
                            "<th>To</th>" +
                            "<td>Parent's</td>" +
                        "</tr><tr>" +
                            "<th>Message</th>" +
                            "<td>"+ message +"</td>" +
                        "</tr><tr>" +
                            "<th>Per SMS Cost</th>" +
                            "<td>"+ msg_cost +"</td>" +
                        "</tr>";
            $("#smsConfirmModalTable").html(tableRows);
            $('#confirm-submit').modal('show');
        }else if(smsOpt == "sms_option_staff_group"){
            const departmentName = $("#department_select option:selected" ).text();
            tableRows += "<tr>" +
                            "<th>Department</th>" +
                            "<td>"+ departmentName +"</td>" +
                        "</tr><tr>" +
                            "<th>To</th>" +
                            "<td>Parent's</td>" +
                        "</tr><tr>" +
                            "<th>Message</th>" +
                            "<td>"+ message +"</td>" +
                        "</tr><tr>" +
                            "<th>Per SMS Cost</th>" +
                            "<td>"+ msg_cost +"</td>" +
                        "</tr>";
            $("#smsConfirmModalTable").html(tableRows);
            $('#confirm-submit').modal('show');

        }else if(smsOpt == "sms_option_by_group"){
            const groupName = $("#student_group_select option:selected" ).text();
            tableRows += "<tr>" +
                            "<th>Group Name</th>" +
                            "<td>"+ groupName +"</td>" +
                        "</tr><tr>" +
                            "<th>To</th>" +
                            "<td>Parent's</td>" +
                        "</tr><tr>" +
                            "<th>Message</th>" +
                            "<td>"+ message +"</td>" +
                        "</tr><tr>" +
                            "<th>Per SMS Cost</th>" +
                            "<td>"+ msg_cost +"</td>" +
                        "</tr>";
            $("#smsConfirmModalTable").html(tableRows);
            $('#confirm-submit').modal('show');

        } else if(smsOpt == "sms_option_list"){
            let phoneNumbers = $("#input_list_phone_number").val().split(',');
            let uniquePhoneNumbers = [...new Set(phoneNumbers)];
            let phnoList = "";
            uniquePhoneNumbers.map((phno,ind)=>{
                if(ind == (uniquePhoneNumbers.length-1)) phnoList += phno;
                else phnoList += phno+", ";
            });
            tableRows += "<tr>" +
                            "<th>Phone Numbers</th>" +
                            "<td>"+ phnoList +"</td>" +
                        "</tr><tr>" +
                            "<th>To</th>" +
                            "<td>Parent's</td>" +
                        "</tr><tr>" +
                            "<th>Message</th>" +
                            "<td>"+ message +"</td>" +
                        "</tr><tr>" +
                            "<th>Per SMS Cost</th>" +
                            "<td>"+ msg_cost +"</td>" +
                        "</tr>";
            $("#smsConfirmModalTable").html(tableRows);
            $('#confirm-submit').modal('show');
        }else if(smsOpt == "sms_option_by_student"){
            let application_no = $("#input_student_phone_number").val().split('\n');
            // let uniquePhoneNumbers = [...new Set(phoneNumbers)];
            // let phnoList = "";
            // uniquePhoneNumbers.map((phno,ind)=>{
            //     if(ind == (uniquePhoneNumbers.length-1)) phnoList += phno;
            //     else phnoList += phno+", ";
            // });
            tableRows += "<tr>" +
                            "<th>Phone Numbers</th>" +
                            "<td>"+ application_no +"</td>" +
                        "</tr><tr>" +
                            "<th>To</th>" +
                            "<td>Parent's</td>" +
                        "</tr><tr>" +
                            "<th>Message</th>" +
                            "<td>"+ message +"</td>" +
                        "</tr><tr>" +
                            "<th>Per SMS Cost</th>" +
                            "<td>"+ msg_cost +"</td>" +
                        "</tr>";
            $("#smsConfirmModalTable").html(tableRows);
            $('#confirm-submit').modal('show');
        }
    }

    const validateSMSForm = ()=>{ 
        const smsOpt = $('#sms_option_type').val();
        if(smsOpt == "sms_option_single"){
            const phoneNumber = $("#single_phone_number").val();
            if(phoneNumber == "" || phoneNumber.length != 10){
                setErrorMessage("Please enter valid mobile number");
                return;
            }else if(! $('#parentsMobile').prop("checked")){
                setErrorMessage("Please choose sms delivery destination");
                return;
            }else{
                setErrorMessage(false);
                confirmSMSDelivery();
            }
        }else if(smsOpt == "sms_option_std_group"){
            if ($('#term_name_select').val() == "") {
                setErrorMessage("Please select Term Name option");
                return;
            } else if ($('#stream_stream_select').val() == "") {
                setErrorMessage("Please select Stream option");
                return;
            }else if(! $('#parentsMobile').prop("checked")){
                setErrorMessage("Please choose sms delivery destination");
                return;
            }else{
                setErrorMessage(false);
                confirmSMSDelivery();
            }
        }else if(smsOpt == "sms_option_staff_group"){
            if(! $('#parentsMobile').prop("checked")){
                setErrorMessage("Please choose sms delivery destination");
                return;
            }else{
                setErrorMessage(false);
                confirmSMSDelivery();
            }
        }else if(smsOpt == "sms_option_by_group"){
            if(! $('#parentsMobile').prop("checked")){
                setErrorMessage("Please choose sms delivery destination");
                return;
            }else{
                setErrorMessage(false);
                confirmSMSDelivery();
            }
        }else if(smsOpt == "sms_option_list"){
            const list = $("#input_list_phone_number").val();
            if(list == ""){
                setErrorMessage("Please enter the list of phone numbers");
                return;
            }else if(! $('#parentsMobile').prop("checked")){
                setErrorMessage("Please choose sms delivery destination");
                return;
            }else{
                setErrorMessage(false);
                confirmSMSDelivery();
            }
        }else if(smsOpt == "sms_option_by_student"){
            const list = $("#input_student_phone_number").val();
            if(list == ""){
                setErrorMessage("Please Select Students");
                return;
            }else if(! $('#parentsMobile').prop("checked")){
                setErrorMessage("Please choose sms delivery destination");
                return;
            }else{
                setErrorMessage(false);
                confirmSMSDelivery();
            }
        }
    }

    const setInitialTemplateView = ()=>{
        const tempID = $("#template_id").val();
        setTemplateView(tempID);
    }
    const setTemplateView = id =>{
        showLoader();
        $.post("<?=base_url()?>getSMSTemplateByID",{template_id: id}).done(res=>{
            hideLoader();
            if(res == 0){
                alert('Something went wrong');
            }else{
                try{
                    let dtls = JSON.parse(res);
                    $("#linked_header").val(dtls.linked_header);
                    $("#template_reg_no").val(dtls.reg_no);
                    $("#msg_body").html(dtls.template);
                    $('#text_message_count').html('0/0');
                }catch(err2){
                    console.log("Error2:",err2);
                }
            }
        }).catch(err1=>{
            hideLoader();
            console.log("Error1:",err1);
        })
    }
    $(document).ready(()=>{
        setInitialTemplateView();
        $("#template_id").on('change',function(){
            const tempID = $(this).val();
            setTemplateView(tempID);
            $('#text_message_count').html('0/0');
        });

        $("#single_phone_number").on('keypress',function(evt){
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if($(this).val().length >= 10){
                return false;
            }
            else if (charCode > 31 && (charCode < 48 || charCode > 57)){
                return false;
            }
            return true;
        });

        $("#input_list_phone_number").on('keypress',function(evt){
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)){
                return false;
            }
            return true;
        });

        // $("#input_list_phone_number").on('paste',function(evt){
        //     const regexp = /^(?: *\d+ *(?:\n|$))+$/;
        //     const copiedText = evt.originalEvent.clipboardData.getData('Text');
        //     if(! regexp.test(copiedText)){
        //         evt.preventDefault();
        //     }
        // });

        $('body').on('keydown paste blur','.editableSpan',function(evt){
            const max = 30;
            if($(this).text().length >= max && evt.which != 8){
                evt.preventDefault();
            }
            
            $('#text_message_count').html($(this).text().length+'/'+max);
        });
        
        $('body').on('keydown paste blur','.multipleEditableText',function(evt){
            const max = 150;
            if($(this).text().length >= max && evt.which != 8){
                evt.preventDefault();
            }
            $('#text_message_count').html($(this).text().length+'/'+max);
        });

        $("#sms_options_tab > li").on('click',function(){
            $('#sms_option_type').val($(this).data('sms_option_type'));
        });
        $("#modalConfirmBtn").click(function(){
            $('#confirm-submit').modal('hide');
            const smsOpt = $('#sms_option_type').val();
            const message = getMessage();
            const msg_cost = countSmsCost(message.length);
            if(smsOpt == "sms_option_single"){
                const phoneNumber = $("#single_phone_number").val();
                let postData = {
                    'message': message,
                    'mobile': phoneNumber,
                    'sms_cost': msg_cost
                };
                showLoader();
                $.post("<?=base_url()?>sendSMSToSingleNumber",{data: JSON.stringify(postData)}).done(res=>{
                    hideLoader();
                    if(res > 0){
                        Swal.fire({
                            icon: 'success',
                            title: "SMS sent successfully",
                            text:"",
                            showConfirmButton: true,
                        }).then(()=>{
                            // showLoader();
                            // location.reload();
                        });
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: "Something went wrong.",
                            text: "Please try later."
                        });
                    }
                }).catch(err1=>{
                    hideLoader();
                    console.log("Error1:",err1);
                });
            }else if(smsOpt == "sms_option_std_group"){
                const termName = $("#term_name_select").val();
                const sectionName = $("#section_select").val();
                const streamName = $("#stream_stream_select").val();
                let postData = {
                    'message': message,
                    'term_name': termName,
                    'stream_name': streamName,
                    'section_name': sectionName,
                    'sms_cost': msg_cost
                };
                showLoader();
                $.post("<?=base_url()?>sendSMSToStudentGroup",{data: JSON.stringify(postData)}).done(res=>{
                    hideLoader();
                    if(res == 1){
                        Swal.fire({
                            icon: 'success',
                            title: "SMS sent successfully",
                            text:"",
                            showConfirmButton: true,
                        }).then(()=>{
                            // showLoader();
                            // location.reload();
                        });
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: "Something went wrong.",
                            text: "Please try later."
                        });
                    }
                }).catch(err1=>{
                    hideLoader();
                    console.log("Error1:",err1);
                });
            }else if(smsOpt == "sms_option_staff_group"){
                const departmentID = $("#department_select").val();
                let postData = {
                    'message': message,
                    'department_id': departmentID,
                    'sms_cost': msg_cost
                };
                showLoader();
                $.post("<?=base_url()?>sendSMSToStaffGroup",{data: JSON.stringify(postData)}).done(res=>{
                    hideLoader();
                    if(res == 1){
                        Swal.fire({
                            icon: 'success',
                            title: "SMS sent successfully",
                            text:"",
                            showConfirmButton: true,
                        }).then(()=>{
                            // showLoader();
                            // location.reload();
                        });
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: "Something went wrong.",
                            text: "Please try later."
                        });
                    }
                }).catch(err1=>{
                    hideLoader();
                    console.log("Error1:",err1);
                });
            }else if(smsOpt == "sms_option_by_group"){
                const studentID = $("#student_group_select").val();
                let postData = {
                    'message': message,
                    'studentID': studentID,
                    'sms_cost': msg_cost
                };
                showLoader();
                $.post("<?=base_url()?>sendSMSToGroup",{data: JSON.stringify(postData)}).done(res=>{
                    hideLoader();
                    if(res == 1){
                        Swal.fire({
                            icon: 'success',
                            title: "SMS sent successfully",
                            text:"",
                            showConfirmButton: true,
                        }).then(()=>{
                            // showLoader();
                            // location.reload();
                        });
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: "Something went wrong.",
                            text: "Please try later."
                        });
                    }
                }).catch(err1=>{
                    hideLoader();
                    console.log("Error1:",err1);
                });
            }else if(smsOpt == "sms_option_list"){
                let phoneNumbers = $("#input_list_phone_number").val().split('\n');
                let uniquePhoneNumbers = [...new Set(phoneNumbers)];
                let postData = {
                    'message': message,
                    'mobile': JSON.stringify(uniquePhoneNumbers),
                    'sms_cost': msg_cost
                };
                showLoader();
                $.post("<?=base_url()?>sendSMSToNumberList",{data: JSON.stringify(postData)}).done(res=>{
                    hideLoader();
                    if(res == 1){
                        Swal.fire({
                            icon: 'success',
                            title: "SMS sent successfully",
                            text:"",
                            showConfirmButton: true,
                        }).then(()=>{
                            // showLoader();
                            // location.reload();
                        });
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: "Something went wrong.",
                            text: "Please try later."
                        });
                    }
                }).catch(err1=>{
                    hideLoader();
                    console.log("Error1:",err1);
                });
            }else if(smsOpt == "sms_option_by_student"){
                let application_no = $("#input_student_phone_number").val().split(', ');
                // let uniquePhoneNumbers = [...new Set(phoneNumbers)];
                let postData = {
                    'message': message,
                    'application_no': JSON.stringify(application_no),
                    'sms_cost': msg_cost
                };
                showLoader();
                $.post("<?=base_url()?>sendSMSByStudentList",{data: JSON.stringify(postData)}).done(res=>{
                    hideLoader();
                    if(res == 1){
                        Swal.fire({
                            icon: 'success',
                            title: "SMS sent successfully",
                            text:"",
                            showConfirmButton: true,
                        }).then(()=>{
                            // showLoader();
                            // location.reload();
                        });
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: "Something went wrong.",
                            text: "Please try later."
                        });
                    }
                }).catch(err1=>{
                    hideLoader();
                    console.log("Error1:",err1);
                });
            }
        });
    });
</script>


<!-- Model alert -->
<div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white">
                Confirm Before Send
            </div>
            <div class="modal-body" style="padding:2px;">
                Are you sure you want to send the SMS?

                <!-- We display the details entered by the user here -->
                <table class="table" id="smsConfirmModalTable">
                    
                </table>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <a href="#" id="modalConfirmBtn" class="btn btn-success success">Confirm</a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
    $('#errorMsg').html('');

    // $("#term_name_select").on('change', function() {
    //     $('#stream_stream_select option:not(:first)').remove();
    //     var term_name = this.value;

    //     if (term_name == "") {
    //         $('#stream_stream_select').attr('disabled', true);
    //     } else {
    //         $.ajax({
    //             url: '<?php echo base_url(); ?>/getStreamNamesByTermSelected',
    //             type: 'POST',
    //             data: {
    //                 term_name: term_name
    //             },
    //             success: function(data) {
    //                 $("#stream_stream_select").append(new Option("ALL", "ALL"));
    //                 $('#stream_stream_select').attr('disabled', false);
    //                 var count = data.term_name.length;
    //                 for (var i = 0; i < count; i++) {

    //                     $("#stream_stream_select").append(new Option(data.term_name[i]
    //                         .stream_name, data.term_name[i].stream_name));
    //                 }
    //             },
    //             error: function(result) {
    //                 alert("Retry Again! Something Went Wrong");
    //             },
    //             fail: (function(status) {
    //                 alert("Retry Again! Something Went Wrong");
    //             }),
    //             beforeSend: function(d) {
    //                 // $("#loaderDiv").html(loader);
    //             }
    //         });
    //     }

    // });

    jQuery('.datepicker, .dateSearch').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });

    $(function() {
        $('[data-toggle="popover"]').popover()
    })

    $("#parentsMobile").attr("checked", true);
});

function allowNumbersOnly(e) {
    var code = (e.which) ? e.which : e.keyCode;
    if (code > 31 && (code < 48 || code > 57)) {
        e.preventDefault();
    }
}

$('#submitBtn').click(function() {

    var error_msg = "";
    var to_send = "";

    if ($('#message').val() == "") {
        error_msg = "Please Write valid message";
    }
    if ($('#term_name_select').val() == "") {
        error_msg = "Please select Term Name option";
    }
    if ($('#stream_stream_select').val() == "") {
        error_msg = "Please select Stream option";
    }

    var invalid_destination = true;
    if ($('#parentsMobile').prop("checked")) {
        invalid_destination = false;
        to_send += " Parent's ";
    }
    // if ($('#onlyStudent').prop("checked")) {
    //     invalid_destination = false;
    //     to_send += " Student ";
    // }
    // if ($('#onlyGuardian').prop("checked")) {
    //     invalid_destination = false;
    //     to_send += " Guardian ";
    // }

    if (invalid_destination == true) {
        error_msg = "Please choose sms delivery destination";
    }

    if (error_msg == "") {
        $('#errorMsg').html();
        $('#sms_to_checked').text(to_send);
        /* when the button in the form, display the entered values in the modal */
        $('#written_msg').text($('#message').val());
        $('#term_name_selected').text($('#term_name_select').val());
        $('#section_select').text($('#section_select').val());
        $('#stream_stream_select').text($('#stream_stream_select').val());

        
        var msg_count = $('#message').val().length;
        //var msg_cost = Math.ceil(msg_count/160);

        var msg_cost = countSmsCost(msg_count);
        $('#per_sms_cost').val(msg_cost);

        $('#sms_cost').text(msg_cost);
        $('#confirm-submit').modal('show');
    } else {
        $('#errorMsg').html(`<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Error!</strong> ` + error_msg + `</div>`);
        return;
    }


});

$('#student_select_button').click(function() {
    var currentVal = $("#student_select option:selected").val();
    // alert(currentVal);
    $('#input_student_phone_number').append(currentVal + ", "); 
});



function countSmsCost(len) {

    if (len <= 160) {
        return 1;
    } else if (len >= 161 && len <= 306) {
        return 2;
    } else if (len >= 306 && len <= 459) {
        return 3;
    } else if (len >= 459 && len <= 612) {
        return 4;
    } else if (len >= 612 && len <= 765) {
        return 5;
    } else if (len >= 765 && len <= 918) {
        return 6;
    } else if (len >= 918 && len <= 1071) {
        return 7;
    } else if (len >= 1071 && len <= 1224) {
        return 8;
    } else if (len >= 1224 && len <= 1377) {
        return 9;
    } else if (len >= 1377 && len <= 1530) {
        return 10;
    } else {
        return 11;
    }

}
</script>

