<?php require APPPATH . 'views/includes/db.php'; ?>
<!-- <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script> -->



<style>

input[type=checkbox] {

    cursor: pointer;

    font-size: 10px;

    -moz-appearance: initial;

    visibility: hidden;

    position: relative;

    top: 0;

    left: 0;

    transform: scale(1.2);

}



input[type=checkbox]:after {

    content: " ";

    background-color: #fff;

    display: inline-block;

    color: red;

    width: 10px;

    height: 10px;

    visibility: visible;

    border: 1px solid #3c8dbc;

    padding: 2px;

    margin: 1px 0;

    border-radius: 1px;

    box-shadow: 0 0 15px 0 rgba(0, 0, 0, 0.08), 0 0 2px 0 rgba(0, 0, 0, 0.16);

}



input[type=checkbox]:checked:after {

    content: "\2714";

    display: unset;

    font-weight: bold;

    width: 10px;

    height: 10px;

    padding: 2px

}

@media (max-width: 767px) {

    /* Fix modal height and make it scrollable */
    #attendanceModel .modal-content {
        max-height: 90vh;
        display: flex;
        flex-direction: column;
    }

    #attendanceModel .modal-body {
        overflow-y: auto;
        flex: 1 1 auto;
    }

    #attendanceModel .modal-header,
    #attendanceModel .modal-footer {
        flex-shrink: 0;
    }

    /* Stack footer vertically with full-width buttons */
    #attendanceModel .modal-footer {
        flex-direction: column !important;
        align-items: stretch !important;
    }

    #attendanceModel .modal-footer .row {
        width: 100%;
        margin: 0;
    }

    #attendanceModel .modal-footer h5 {
        width: 100%;
        margin-bottom: 8px !important;
        text-align: left;
    }

    #attendanceModel .modal-footer .btn {
        width: 100%;
        margin: 0 0 8px 0 !important;
        float: none !important;
    }

    #attendanceModel .modal-footer .col-2,
    #attendanceModel .modal-footer .col-8 {
        max-width: 100%;
        flex: 0 0 100%;
        padding: 0;
    }
}

</style>

<?php

$this->load->helper('form');

$error = $this->session->flashdata('error');

if ($error) { ?>

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

if ($success) {  ?>

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

                                    <i class="material-icons">format_list_bulleted</i> Take Attendance

                                </span>

                            </div>

                            <div class="col-lg-5 col-md-5 col-12">

                                <a onclick="GoBackWithRefresh();return false;" class="btn btn_back mobile-btn float-right text-white"

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

                <div class="card-body p-1 pb-2">

                        <div class="card text-dark mb-3" style="background-color: #7bd78fa8;">



                            <form method="POST" role="form" action="<?php echo base_url(); ?>getClassTeacherStudentsForAttendance">



                                <div class="card-body p-2">

                                    <div class="row">

                                        <div class="col-12">

                                            <div class="row">

                                               <div class="col-lg-4 col-md-4 col-sm-6 col-12">

                                                    <div class="form-group mb-0">

                                                        <label>Term</label>

                                                         <select class="form-control form-control-sm" id="term_name" name="term_name" required>
                                                            <?php if(!empty($termName)){ ?>
                                                                <option value="<?php echo $termName; ?>">Selected: <?php echo $termName; ?></option>
                                                            <?php } ?>
                                                            <option value="">Select Term</option>
                                                            <?php if(!empty($termInfo)){ 
                                                                foreach($termInfo as $term){ ?>
                                                                    <option value="<?php echo $term->row_id; ?>">
                                                                        <?php echo $term->term_name.' - '.$term->stream_name.' - '.$term->section_name; ?>
                                                                    </option>
                                                            <?php } } ?>
                                                        </select>


                                                    </div>

                                                </div>

                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">

                                                    <div class="form-group mb-0">

                                                        <label>Date</label>

                                                        <input id="attendance_date" type="text" name="attendance_date" class="form-control form-control-sm datepicker" value="<?php echo date('d-m-Y', strtotime($attendance_date)); ?>" placeholder="Attendance Date" autocomplete="off" required />

                                                    </div>

                                                </div>

                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                    <div class="form-group mb-0">
                                                        <label>Session</label>
                                                        <select class="form-control form-control-sm" id="session" name="session" required>
                                                            <?php if(!empty($session)){ ?>
                                                                <option value="<?php echo $session; ?>">Selected: <?php echo $session; ?></option>
                                                            <?php } ?>
                                                            <option value="">Select Session</option>
                                                            <option value="Morning Session">Morning Session</option>
                                                            <option value="Afternoon Session">Afternoon Session</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr class="m-1" style="border-top: 1px solid #3c8dbc;">

                                            <div class="row">

                                                <div class="col-lg-4 col-sm-4 col-md-4 col-12">


                                                </div>

                                                <div class="col-lg-6 col-md-4">

                                                </div>

                                                <div class="col-lg-2 col-sm-4 col-md-4 col-12">

                                                    <?php if ($role == ROLE_PRINCIPAL || $role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_TEACHING_STAFF || $role == ROLE_SUPER_ADMIN || $role == ROLE_ACADEMIC_INCHARGE || $staffID == 'LCS100' || $staffID == 'LCS87' || $staffID == 'LCS101' || $staffID == 'LCS122' || $staffID == 'LCS89') { ?>

                                                        <button type="submit" class="btn btn-block btn-sm btn-primary btn_send pull-right"> Take Attendance</button>

                                                    <?php } ?>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>

                    <div class="row p-1">


                        <div class="col-lg-2 col-sm-6 col-5">

                            <h6 class="mb-0">Date : <span class="font-weight-bold"><?php echo $attendance_date; ?></span></h6>

                        </div>

                        <div class="col-lg-2 col-sm-6 col-7">

                            <h6 class="mb-0">Term  : <span class="font-weight-bold"><?php echo $term_name; ?></span></h6>

                        </div>

                        <div class="col-lg-2 col-sm-6 col-7">

                            <h6 class="mb-0">Stream  : <span class="font-weight-bold"><?php echo $stream_name; ?></span></h6>

                        </div>

                        <div class="col-lg-2 col-sm-6 col-5">

                            <h6 class="mb-0">Section : <span class="font-weight-bold"><?php echo $section_name; ?></span></h6>

                        </div>

                        <div class="col-lg-3 col-sm-6 col-5">

                        <h6 class="mb-0">Session : <span class="font-weight-bold"><?php echo $session; ?></span></h6>

                        </div>

                    </div>

                    <div class="card-body p-1 pb-2 table-responsive">

                        <form action="#" method="POST" id="selectedAbsentStudents"> 

                            <table class="table table-hover table-bordered text-dark mb-0">

                                <thead>

                                    <input type="hidden" name="term_name" value="<?php echo $term_name; ?>" />

                                    <input type="hidden" name="attendance_date" value="<?php echo $attendance_date; ?>" />

                                    <input type="hidden" name="section_name" value="<?php echo $section_name; ?>" />

                                    <input type="hidden" name="stream_name" value="<?php echo $stream_name; ?>" />

                                    <input type="hidden" name="session" value="<?php echo $session; ?>" />

                                    <tr class="table_row_background text-center">

                                        <th>Student ID</th>

                                        <th>Name</th>

                                        <th>Action</th>

                                    </tr>

                                    <?php if(!empty($studentRecord)){

                                        foreach($studentRecord as $std){ 

                                            $absentDate = date('Y-m-d',strtotime($attendance_date));

                                            $absentData = getAbsentStudentList($con,$std->row_id,$term_name,$section_name,$stream_name,$absentDate,$session);

                                            if(!empty($absentData)){

                                                $isAbsent = true;

                                            }else{

                                                $isAbsent = false;

                                            }

                                        ?>

                                        <tr>

                                            <td class="text-center"><?php echo $std->student_id; ?></td>

                                            <td><?php echo $std->student_name; ?></td>

                                            <th class="text-center">

                                                <?php if($isAbsent == 'true'){ ?>

                                                    <input type="checkbox" class="singleSelect" checked data-toggle="toggle" data-size="xs" name="<?php echo $std->row_id; ?>" value="true" data-off="Present" data-on="Absent"  data-onstyle="danger" data-offstyle="success" checked>

                                                    <!-- <input name="<?php //echo $std->row_id; ?>" type="checkbox" class="singleSelect" value="true" checked /> -->

                                                <?php }else{ ?>

                                                    <input type="checkbox" class="singleSelect" data-toggle="toggle" data-size="xs" name="<?php echo $std->row_id; ?>" value="true" data-off="Present" data-on="Absent"  data-onstyle="danger" data-offstyle="success">

                                                    <!-- <input name="<?php //echo $std->row_id; ?>" type="checkbox" class="singleSelect" value="true" /> -->

                                                <?php } ?>

                                            </td>

                                        </tr>

                                    <?php } } ?>

                                </thead>

                            </table>

                            <div class="msgAlert"></div>
                                <?php if($role != ROLE_PRIMARY_ADMINISTRATOR){ ?>
                                    <?php if($classCompletedInfo->staff_updated_status == 1){ ?>
                                        <span style="color:red;" class=" float-right mt-1">Attendance Already Taken</span>
                                    <?php }else{ ?>
                                        <button onclick="confirmAbsentedStudents()" type="button" class="btn btn-success float-right mt-1">Confirm</button>
                                <?php } ?>
                                <?php }else{ ?>
                                    <button onclick="confirmAbsentedStudents()" type="button" class="btn btn-success float-right mt-1">Confirm</button>
                               <?php } ?>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>





<div class="modal" id="attendanceModel">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title">Confirm Absented Students</h4>

                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <div class="modal-body p-2">

                <div id="msg"></div>

                <form action="#" method="POST" id="searchList">

                <div class="row">

                    <div class="col-lg-3 col-xs-5 col-sm-4 col-6">

                        <label>Date: <b style="color:green" id="attendanceDateConfirm"></b></label>

                    </div>

                    <div class="col-lg-2 col-xs-4 col-sm-4 col-6">

                        <label>Term: <b id="term_nameConfirm"></b></label>

                    </div>

                    <div class="col-lg-2 col-xs-4 col-sm-4 col-6">

                        <label>Stream: <b id="stream_nameConfirm"></b></label>

                    </div>

                    <div class="col-lg-2 col-xs-3 col-sm-4 col-6">

                        <label>Section: <b id="section_nameConfirm"></b></label>

                    </div>

                    <div class="col-lg-3 col-xs-3 col-sm-4 col-6">

                    <label>Session: <b id="sessionConfirm"></b></label>

                    </div>

                </div>

                

                <table class="table table-hover table-bordered">

                    <tr class="table-primary">

                        <th width="90">Student ID</th>
                        <th width="90">Student Name</th>
                        <th width="50">Attendance</th>

                    </tr>

                    <tbody class="absentList">

                    </tbody>

                </table>

                    

            </div>

            <div class="modal-footer p-1">

                <div class="row w-100 ml-0">

                    <div class="col-8 pl-0">

                        <div class="float-left">

                            <h5 class="mb-0"><b>Total Absent Students : </b><span class="text-danger" id="countAbsent"></span></h5>

                        </div>

                    </div>

                    <div class="col-2 pr-0">

                        <button type="button" class="btn btn-sm btn-danger float-right" data-dismiss="modal">Close</button>

                    </div>

                    <div class="col-2 pl-0">

                        <button id="confirmToSubmitAbsentedStudents" type="button" class="btn btn-md btn-primary float-right" ><i class="fa fa-save"></i> Confirm</button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



<script type="text/javascript">

function GoBackWithRefresh(event) {

    if ('referrer' in document) {

        window.location = document.referrer;

        /* OR */

        //location.replace(document.referrer);

    } else {

        window.history.back();

    }

}



var loader = '<img height="70" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';

jQuery(document).ready(function() {

    jQuery('.datepicker, .dateSearch').datepicker({

        autoclose: true,

        orientation: "bottom",

        format: "dd-mm-yyyy"



    });



    $('#selectAll').click(function(){

        if ($('#selectAll').is(':checked')) {

            $('.singleSelect').prop('checked', true);          

        } else {

            $('.singleSelect').prop('checked', false);

        }

    });



    

    $('#confirmToSubmitAbsentedStudents').click(function(){

        var formData = $('#selectedAbsentStudents').serializeArray();

    

        $.ajax({

            url: '<?php echo base_url(); ?>/addClassTeacherAttendanceByStaff',

            type: 'POST',

            

            data: {

                attInfo : JSON.stringify(formData),

            },

            success: function(data) { 

                $('.msgAlert').html('');

                if(data == 'true'){

                    $('#attendanceModel').modal('hide');
                    location.reload();

                    $('.msgAlert').html(`

                    <div class="alert alert-success alert-dismissable">

                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                    Attendance Added Successfully!

                    </div>

                    `);

                }else{

                    $('.msgAlert').html(`

                    <div class="alert alert-danger alert-dismissable">

                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                    Nothing changes applied in attendance..

                    </div>`);

                    $('#attendanceModel').modal('hide');

                }

            },

            error: function(result)

            {

                alert("Network Server Error!!  Failed");

            },

            fail:(function(status) {

                alert("Server Error!!  Failed");

            }),

            beforeSend:function(d){

                $('.msgAlert').html(loader);

                $("#confirmToSubmitAbsentedStudents").prop('disabled', true);

            }

        });

    });



});



function confirmAbsentedStudents(){

    var total_absent_count = 0;

    $("#confirmToSubmitAbsentedStudents").prop('disabled', false);

    $(".absentList").html('');

    var formData = $('#selectedAbsentStudents').serializeArray();

    $.each(formData, async function(i, field){

        if(field.name == "term_name"){

        $("#term_nameConfirm").html(field.value); 

        }else if(field.name == "stream_name"){

        $("#stream_nameConfirm").html(field.value);

        }else if(field.name == "section_name"){

        $("#section_nameConfirm").html(field.value);

        }else if(field.name == "attendance_date"){

        $('#attendanceDateConfirm').html(field.value);

        }else if(field.name == "session"){

        $("#sessionConfirm").html(field.value);

        }else if(field.value == 'true'){

        total_absent_count++;
        var str = field.name;  
        var rel_std_id = str.split(" ",1);
        var name = str.split(" /").pop(); 
        // alert(name)
        let std_name = "";
        try{
            std_name = await getNameByAdmissionNo(rel_std_id[0]);
        }catch(err){
            std_name = "";
        }
        let admission_no = "";
        try{
            admission_no = await getSatNumberByRowId(rel_std_id[0]);
        }catch(err){
            admission_no = "";
        }
        // $(".absentList").append("<tr><td>" + field.name + "</td>" + "<td style='color:red'> Absent </td></tr>");
        $(".absentList > tr.all-present").remove()
        $(".absentList").append("<tr><td>" + admission_no + "</td><td>" + std_name + "</td>" + "<td style='color:red'> Absent </td></tr>");

        }

    });

    $("#countAbsent").html(total_absent_count);

    if($('.absentList').text() == ""){

        $(".absentList").html("<tr class='text-center all-present'> <td colspan='2' style='color:green'> All student are present? </td></tr>");

    }

    $('#attendanceModel').modal('show');

}

</script>

<script>
    const getNameByAdmissionNo = rel_std_id =>{
        return new Promise((resolve, reject)=>{
            try{
                $.post('<?=base_url()?>getStudentNameById', { rel_std_id })
                .then(result=>{
                    if(result === '0'){
                        reject('404');
                    }else{
                        resolve(result);
                    }
                }).catch(err2=>{
                    reject(err2);
                });;
            }catch(err){
                reject(err);
            }
        });
    }
    const getSatNumberByRowId = rel_std_id =>{
        return new Promise((resolve, reject)=>{
            try{
                $.post('<?=base_url()?>getSatNumberByRowId', { rel_std_id })
                .then(result=>{
                    if(result === '0'){
                        reject('404');
                    }else{
                        resolve(result);
                    }
                }).catch(err2=>{
                    reject(err2);
                });;
            }catch(err){
                reject(err);
            }
        });
    }
</script>

<?php

function getAbsentStudentList($con,$rel_std_id,$term_name,$section_name,$stream_name,$absentDate,$session){

    $query = "SELECT * FROM tbl_class_teacher_attendance_details as attendance 

    -- WHERE attendance.student_id = '$student_id' AND attendance.term_name = '$term_name' 

    WHERE attendance.student_id = '$rel_std_id' AND attendance.term_name = '$term_name' 

    AND attendance.section_name = '$section_name' AND attendance.stream_name = '$stream_name' AND attendance.absent_date = '$absentDate' AND attendance.session = '$session' 

    AND attendance.is_deleted = 0";

    $pdo_statement = $con->prepare($query);

    $pdo_statement->execute();

    return $pdo_statement->fetch();

}

?>