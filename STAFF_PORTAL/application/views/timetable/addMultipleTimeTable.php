<?php require APPPATH . 'views/includes/db.php'; ?>
<style>
label{
    font-weight: 500 !important;
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
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
    
    <div id="msg_reply"></div>
</div>
<div class="main-content-container container-fluid px-4 pt-1">
    <div class="content-wrapper">
        <section class="content-header">
            <div class="row ">
                <div class="col">
                    <div class="card card-small p-0 card_heading_title">
                        <div class="card-body p-2 ml-2">
                            <span class="page-title absent_table_title_mobile">
                                <i class="material-icons">access_time</i> Time Table
                            </span>

                            <a onclick="showLoader();window.history.back();" class="btn primary_color float-right text-white pt-2 border_left_radius"
                                value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                <a class="btn btn-primary mobile-btn float-right text-white border_right_radius" href="#" data-toggle="modal" data-target="#addClassInfo">
                                    <i class="fa fa-plus"></i> Add New</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- form start -->
            <!-- Default Light Table -->
            <div class="row form-employee">
            <?php if(!empty($streamData)){ 
                foreach($streamData as $stream){ ?>
                <div class="col-12">
                    <div class="card card-small c-border mb-1 mb-3">
                        <div class="row text-center py-1 ml-0 mr-0 table_row_background">
                            <div class="col-4"><h5 class="mb-0 text-dark timetable_heading">Term : <span class="font-weight-bold text-dark term_name"><?php echo $stream->term_name; ?></span></h5></div>
                            <div class="col-4"><h5 class="mb-0 text-dark timetable_heading">Stream : <span class="font-weight-bold text-dark"><?php echo $stream->stream_name; ?></span></h5></div>
                            <div class="col-4"><h5 class="mb-0 text-dark timetable_heading">Section : <span class="font-weight-bold text-dark"><?php echo $stream->section_name; ?></span></h5></div>
                        </div>
                        <hr class="mt-0 mb-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table_time_table mb-0">
                                <tr class="text-center" style="background-color: #b0d7ff;">
                                    <th width="50">Week Name</th>
                                    <?php if(!empty($classTimingsInfo)){
                                        foreach($classTimingsInfo as $class) { ?>
                                        <th width="150"><?php echo $class->start_time .'-'. $class->end_time ?></th>
                                    <?php } } ?>
                                </tr>
                                <?php foreach($weekName as $week) {?>
                                    <tr>
                                        <th class="text-center" width="80" style="background-color: cornsilk;"><?php echo $week->week_name; ?></th>
                                        <?php foreach($classTimingsInfo as $class) {  ?>
                                                <td>
                                                    <?php
                                                    $timeTableInfo = getSubjectAndStaffDeatils($con,$class->row_id,$week->row_id,$stream->row_id);
                                                    if(!empty($timeTableInfo)){ 
                                                        foreach($timeTableInfo as $time){ ?>
                                                    <div class="row ml-0 mr-0">
                                                        <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                                                            <a tabindex="0" class="p-0" role="button" data-toggle="popover" data-trigger="focus" title="<?php echo $time['sub_name']; ?>" data-html="true" data-content="<?php echo $time['subject_type']; ?><br /> <?php echo $time['name']; ?>">
                                                                <p class="text-center text-dark mb-1 font-weight-bold"><?php echo $time['sub_name']; ?> - <span class="text-success"><?php echo $time['subject_type']; ?></span></p>
                                                            </a>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                                            <a href="#" class="btn btn-sm btn-danger deleteClassInfo py-1 px-2 float-right mb-1" data-row_id="<?php echo $time['row_id']; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </div>
                                                    <hr class="mb-1 mt-0">
                                                    <?php } } ?>
                                                </td>
                                            
                                        <?php } ?>
                                    </tr>
                                <?php } ?>

                                <tr class="text-center" style="background-color: #b0d7ff;">
                                    <th width="50"></th>
                                    <?php if(!empty($timingsInfo)){
                                        foreach($timingsInfo as $class) { ?>
                                        <th width="150"><?php echo $class->start_time .'-'. $class->end_time ?></th>
                                    <?php } } ?>
                                </tr>
                                <?php foreach($weekInfo as $week) {?>
                                    <tr>
                                        <th class="text-center" width="80" style="background-color: cornsilk;"><?php echo $week->week_name; ?></th>
                                        <?php foreach($timingsInfo as $class) {  ?>
                                                <td>
                                                    <?php
                                                    $timeTableInfo = getSubjectAndStaffDeatils($con,$class->row_id,$week->row_id,$stream->row_id);
                                                    if(!empty($timeTableInfo)){ 
                                                        foreach($timeTableInfo as $time){ ?>
                                                    <div class="row ml-0 mr-0">
                                                        <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                                                            <a tabindex="0" class="p-0 subject_popover" role="button" data-toggle="popover" data-trigger="focus" title="<?php echo $time['sub_name']; ?>" data-html="true" data-content="<?php echo $time['subject_type']; ?><br /> <?php echo $time['name']; ?>">
                                                                <p class="text-center text-dark mb-1 font-weight-bold"><?php echo $time['sub_name']; ?> - <span class="text-success"><?php echo $time['subject_type']; ?></span></p>
                                                            </a>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                                            <a href="#" class="btn btn-sm btn-danger deleteClassInfo py-1 px-2 float-right mb-1" data-row_id="<?php echo $time['row_id']; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </div>
                                                    <hr class="mb-1 mt-0">
                                                    <?php } } ?>
                                                </td>
                                            
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                                
                            </table>
                        </div>
                    </div>
                </div>
                <?php } } ?>
            </div>
    </div>

    <div class="modal" id="addClassInfo">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Subject</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body p-2">
                    <div id="msg"></div>
                    <!-- <div class=""> -->
                        <div class="row">
                            <div class="col-12">
                                <select class="form-control "  name="staff_id" id="staff_id" required>
                                    <option value="">Select Staff</option>
                                    <?php if(!empty($staffInfo)){
                                        foreach($staffInfo as $staff){  ?>
                                    <option value="<?php echo $staff->staff_id; ?>"><?php echo $staff->name; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                            <div class="col-12 mt-2">
                                <select class="form-control"  name="subject_type_row_id" id="subject_name" required>
                                    <option value="">Select Subject</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered mt-4 text-center">
                                <tr class="table-info">
                                    <th>Term</th>
                                    <th>Stream</th>
                                    <th>Section</th>
                                    <th>Week Name</th>
                                    <th>Time</th>
                                    <th>Subject</th>   
                                    <th>Action</th>          
                                </tr>
                                <tbody id="staffSubjectContent">
                                
                                </tbody>
                                <tr id="staffMessage">
                                    <th colspan="7">Record Not Found</th>
                                </tr>
                            </table>
                        </div>
                        <table class="table table_timetable_subject">
                        <input type="hidden" value="<?php echo $stream->term_name; ?>" name="term" id="term"/>
                            <thead>
                                <tr class="table-success">
                                    <th width="180">Term<span class="float-right">:</span></th>
                                    <th><?php echo $stream->term_name; ?></th>
                                </tr>
                                <tr>
                                    <th>Stream & Section<span class="float-right">:</span></th>
                                    <th>
                                        <select class="form-control selectpicker select_mobile" data-live-search="true" id="stream_section_id" name="stream_section_id[]" required multiple>
                                            <option value="">Select Stream And Section</option>
                                            <?php if(!empty($streamData)){
                                                foreach($streamData as $stream){ ?>
                                                <option value="<?php echo $stream->row_id ?>">
                                                    <?php echo $stream->stream_name ?> - <?php echo $stream->section_name ?>
                                                </option>
                                            <?php }  } ?>
                                        </select>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Week Name<span class="float-right">:</span></th>
                                    <th class="weekName">
                                        <select class="form-control " id="week_name_id" name="week_name_id" required>
                                            <option value="">Select Week Name</option>
                                            <?php if(!empty($allWeekName)){
                                                foreach($allWeekName as $week){ ?>
                                                <option value="<?php echo $week->row_id ?>">
                                                    <?php echo $week->week_name ?>
                                                </option>
                                            <?php }  } ?>
                                        </select>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Time<span class="float-right">:</span></th>
                                    <th class="classTimings">
                                        <select class="form-control" id="class_time" name="class_time" required>
                                            <option value="">Select Class Timings</option>
                                            
                                        </select>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    <!-- </div> -->
                </div>
                <div class="modal-footer p-1">
                    <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
                    <button type="submit" form="addTimeTable" class="btn btn-sm btn-success float-right" id="btn_submit">Add</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/timeTable.js" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();  
});

</script>
<script type="text/javascript">
function GoBackWithRefresh(event) {
    if ('referrer' in document) {
        window.location = document.referrer;
    } else {
        window.history.back();
    }
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;
    return true;
}

jQuery(document).ready(function() {
    $('#subject_name').prop('disabled', 'disabled');
    $('#subject_type').prop('disabled', 'disabled');

    $("#staff_id").change(function(){
        var staff_id = $("#staff_id").val()
        if(this.value != 0){
            // $('#addMarkButton').prop('disabled', 'disabled');
            $('#subject_name').prop('disabled', false);
            $('#subject_name option:not(:first)').remove();
            $.ajax({
            url: '<?php echo base_url(); ?>/getAssignedSubjects',
            type: 'POST',
            dataType: "json",
            data: { staff_id : staff_id },

            success: function(data) {
                //var examObject = JSON.parse(data);
                var examObject = JSON.stringify(data)
                var count = data.result.length;
                
                for(var i=0; i<=count; i++){
                    // $('#subject_name').prop('disabled', false);
                    $("#subject_name").append(new Option(data.result[i].sub_name +' - '+ data.result[i].subject_type, data.result[i].row_id));
                }
                // $('#subject_name').prop('disabled', false);
            }
        });
        }else{
            $('#subject_name').prop('disabled', 'disabled');
            $('#subject_name option:not(:first)').remove();
            // $('#addMarkButton').prop('disabled', 'disabled');
        }

        
        $.ajax({
            url: '<?php echo base_url(); ?>/getStaffSubjectInfo',
            type: 'POST',
            dataType: "json",
            data: { staff_id : staff_id },

            success: function(data) {
                var examObject = JSON.stringify(data)
                var classResult = data.result;
                var newHtml = "";
                    $.each(classResult, function(index, value) {
                        // alert(value.name);
                        var subject_name = value.sub_name +' - '+ value.subject_type;
                        var class_time = value.start_time +' - '+ value.end_time;

                        newHtml += '<tr>';
                        newHtml += '<th>'+ value.term_name +'</th>'
                        newHtml += '<th>'+ value.stream_name +'</th>'
                        newHtml += '<th>'+ value.section_name +'</th>'
                        newHtml += '<th>'+ value.week_name +'</th>'
                        newHtml += '<th>'+ class_time +'</th>'
                        newHtml += '<th>'+ subject_name +'</th>'
                        newHtml += '<th><a href="#" class="btn btn-sm btn-danger deleteClassInfo py-1 px-2 mb-1" data-row_id="'+ value.row_id +'" title="Delete"><i class="fa fa-trash"></i></a></th>'
                        newHtml += '</tr>';
                        $("#staffMessage").hide();
                    });
                $("#staffSubjectContent").html(newHtml);
            },
            error: function(result){
                // alert("Retry Again! Something Went Wrong");
            },
            fail:(function(status) {
                alert("Retry Again! Something Went Wrong");  
            }),
            beforeSend:function(d){
                // alert("Retry Again! Something Went Wrong");  
            }
        });
    });

    
    $("#week_name_id").change(function(){
        var week_id = $("#week_name_id").val()
        if(this.value != 0){
            // $('#addMarkButton').prop('disabled', 'disabled');
            $('#class_time').prop('disabled', false);
            $('#class_time option:not(:first)').remove();
            $.ajax({
            url: '<?php echo base_url(); ?>/getClassTimimgsByWeekId',
            type: 'POST',
            dataType: "json",
            data: { week_id : week_id },

            success: function(data) {
                //var examObject = JSON.parse(data);
                var examObject = JSON.stringify(data)
                var count = data.result.length;
                
                for(var i=0; i<=count; i++){
                    $("#class_time").append(new Option(data.result[i].start_time +' - '+ data.result[i].end_time, data.result[i].row_id));
                }
            }
        });
        }else{
            $('#class_time').prop('disabled', 'disabled');
            $('#class_time option:not(:first)').remove();
            // $('#addMarkButton').prop('disabled', 'disabled');
        }
    });

    $("#btn_submit").click(function(){
        $('#msg').html('');
        var week_name_id = $("#week_name_id").val()
        var time_id = $("#class_time").val()
        var subject_name = $("#subject_name").val()
        var term = $("#term").val()
        var stream_section_id = $("#stream_section_id").val()
        if(subject_name == ""){
            $('#msg').html(`<div class="alert alert-danger" role="alert">
                Please Select Subject Name
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </div>`);
        }else if(stream_section_id == ""){
            $('#msg').html(`<div class="alert alert-danger" role="alert">
                Please Select Stream & Section
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </div>`);
        }else if(week_name_id == ""){
            $('#msg').html(`<div class="alert alert-danger" role="alert">
                Please Select Week Name
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </div>`);
        }else if(time_id == ""){
            $('#msg').html(`<div class="alert alert-danger" role="alert">
                Please Select Class Time
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </div>`);
        }else{
            $.ajax({
                url: '<?php echo base_url(); ?>/addMultipleTimeTableToDB',
                type: 'POST',
                // dataType: "json",
                data: { week_name_id : week_name_id,
                    time_id : time_id,
                    subject_name : subject_name,
                    term : term,
                    stream_section_id : stream_section_id,
                },

                success: function(data) {
                    window.location.reload();
                },
                error: function(result){
                    // alert("Retry Again! Something Went Wrong");
                },
                fail:(function(status) {
                    alert("Retry Again! Something Went Wrong");  
                }),
                beforeSend:function(d){
                    // alert("Retry Again! Something Went Wrong");  
                }
            });
        }
    });

    // $('select').selectpicker();

    jQuery('.datepicker , .datepicker_doj').datepicker({
        autoclose: true,
        format : "dd-mm-yyyy",
        endDate : "today"
    });

  
});
</script>

<?php
function getSubjectAndStaffDeatils($con,$time_row_id,$week_row_id,$section_row_id){
    $query = "SELECT timeTable.row_id,sub.name,staff.name,staffSubject.subject_type FROM tbl_time_table_info as timeTable 
    LEFT JOIN tbl_staff_teaching_subjects as staffSubject ON timeTable.staff_subjects_row_id = staffSubject.row_id
    LEFT JOIN tbl_staff as staff ON staff.staff_id = staffSubject.staff_id 
    LEFT JOIN tbl_subjects as sub ON sub.subject_code = staffSubject.subject_code 
    WHERE timeTable.week_name = '$week_row_id'
    AND timeTable.class_section_row_id = '$section_row_id' AND timeTable.time_row_id = '$time_row_id'
    AND timeTable.is_deleted = 0 AND staff.is_deleted = 0 AND staffSubject.is_deleted = 0 AND sub.is_deleted = 0";
    $pdo_statement = $con->prepare($query);
    $pdo_statement->execute();
    return $pdo_statement->fetchALL();
}
?>