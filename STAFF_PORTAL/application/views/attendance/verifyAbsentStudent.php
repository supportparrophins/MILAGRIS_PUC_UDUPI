<?php
 require APPPATH . 'views/includes/db.php'; 

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
<div class="row">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<style>
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0; 
}

.loaderScreen {
    display: block;
    visibility: visible;
    position: absolute;
    z-index: 999;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
    background-color: #0a0a0a94;
    vertical-align: bottom;
    padding-top: 20%;
    filter: alpha(opacity=75);
    opacity: 0.75;
    font-size: large;
    color: blue;
    font-style: italic;
    font-weight: 400;

    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
}
</style>
<!-- Content Header (Page header) -->
<div class="main-content-container px-3 pt-1">
    <div class="row p-0">
        <div class="col column_padding_card">
            <div class="card card-small card_heading_title p-0 m-b-1">
                <div class="card-body p-2">
                    <div class="row c-m-b">
                        <div class="col-6">
                            <span class="page-title count_heading">
                                <i class="material-icons">mode_edit</i> Verify Attendance
                            </span>
                        </div>
                        <div class="col-6">
                            <a onclick="window.history.back();"
                                class="btn primary_color mobile-btn float-right text-white pt-2"
                                value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row form-employee">
        <div class="col-12 column_padding_card">
            <div class="card card-small c-border p-2">
                <form role="form" action="<?php echo base_url(); ?>getStudentInfoToVerifyAttendance" method="POST" id="byFilterMethod">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-12">
                            <input id="attendance_date" type="text" name="attendance_date" class="form-control form-control-sm datepicker"
                            placeholder="Date" autocomplete="off" value="<?php echo $attendance_date; ?>" required/>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12">
                            <select required name="term_name" id="term_name" class="form-control" data-live-search="true">
                                <?php if(!empty($term_name)){ ?>
                                    <option value="<?php echo $term_name; ?>">Selected: <?php echo $term_name; ?></option>
                                <?php } ?>
                                <option value="">Select Term</option>
                                <option value="I PUC">I PUC</option>
                                <option value="II PUC">II PUC</option>
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-3 col-12">
                            <select required name="section_name" id="streamName" class="form-control stream_name" data-live-search="true">
                                <?php if(!empty($section_row_id)){ ?>
                                    <option value="<?php echo $section_row_id; ?>">Selected: <?php echo $stream_name.' '.$section_name; ?></option>
                                <?php } ?>
                                <option value="">Select Stream & Section</option>
                                <?php if(!empty($termInfo)){ 
                                    foreach($termInfo as $term){ ?>
                                        <option value="<?php echo $term->row_id; ?>"><?php echo $term->stream_name.' '.$term->section_name; ?></option>
                                <?php  } } ?>
                            </select>
                        </div>
                        
                        <div class="col-lg-3 col-md-3 col-12">
                            <button type="submit" id="searchButton" class="btn btn-success btn-block">
                                Search</button>
                        </div>
                    </div>
                </form>
                <hr class="mt-1 mb-1">
                <div class="table-responsive-sm">
                    <?php if(!empty($studentRecord)){ ?>
                    <div class="row pb-2">
                        <div class="col-lg-3 col-md-3 col-6 mb-1">
                            <span class="badge badge-pill badge-info" style="font-size: 16px;">Stream:
                                <b><?php echo $stream_name; ?></b></span>
                        </div>
                        <div class="col-lg-3 col-md-3 col-6 mb-1">
                            <span class="badge badge-pill badge-info" style="font-size: 16px;">Section:
                                <b><?php echo $section_name; ?></b></span>
                        </div>
                        <div class="col-lg-3 col-md-3 col-6 mb-1">
                            <span class="badge badge-pill badge-info" style="font-size: 16px;">Total Students:
                                <b><?php echo count($studentRecord); ?><b></b></span>
                        </div>
                    </div>
                    <?php } ?>
                    <form action="<?php echo base_url(); ?>confirmStudentVerifyAttendance" method="POST" id="confirmAttendance">
                        <table class="table table-bordered text-dark tblnavigate">
                            <thead class="text-center">
                                <tr class="table_row_background">
                                    <th width="100">Student ID</th>
                                    <th width="200">Name</th>
                                    
                                    <?php if(!empty($classInfo)) {
                                        foreach($classInfo as $class) {
                                            // if($class->staff_subjects_row_id != 0) { ?>
                                                <th><span style="color:black;"><?php echo strtoupper($class->sub_name); ?></span><br>
                                                    <?php echo $class->staff_name; ?><br>
                                                    <span style="color:black;"><?php echo $class->subject_type; ?></span>
                                                    <!-- <span style="color:black;"><?php echo $class->start_time.' '.$class->end_time; ?></span> -->
                                                </th>
                                    <?php } } ?>
                                </tr>
                            </thead>
                            <tbody>
                               
                                <input type="hidden" value="<?php echo $term_name; ?>" name="term_name" />
                               
                                <input type="hidden" value="<?php echo $subject_code; ?>" name="subject_id" />
                                <input type="hidden" value="<?php echo $stream_name; ?>" name="stream_name" />
                                <input type="hidden" value="<?php echo $section_name; ?>" name="section_name" />
                                <input type="hidden" value="<?php echo $section_row_id; ?>" name="section_row_id" />
                                <input type="hidden" value="<?php echo $attendance_date; ?>" name="attendance_date" />


                                
                                <?php if(!empty($studentRecord)){
                                foreach($studentRecord as $record) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $record->student_id; ?></td>
                                    <td width="200"><?php echo $record->student_name; ?></td>
                                    <?php $absentDate = date('Y-m-d',strtotime($attendance_date));
                                        if(!empty($classInfo)){
                                        foreach($classInfo as $class){
                                            // if($class->staff_subjects_row_id != 0) {
                                            // foreach($absentedStudents as $absent){
                                            // if($record->student_id == $absent->student_id && $class->time_row_id == $absent->time_row_id && $class->subject_code == $absent->subject_id){
                                            //     $isAbsent = true;
                                            //     break;
                                            // }else{
                                                // $isAbsent = false;
                                            // }
                                            // }
                                            
                                            $staff_sub_info = getStaffSubjectRowId($con,$class->staff_id,$class->subject_code,$class->subject_type);
                                            $staff_sub_row_id = $staff_sub_info['row_id'];
                                            
                                            $absentData = getAbsentStudentList($con,$record->student_id,$section_row_id,$class->time_id,$absentDate,$class->subject_code);
                                            if(!empty($absentData)){
                                                $isAbsent = true;
                                            }else{
                                                $isAbsent = false;
                                            }
                                            
                                            // = getAbsentStatus($absentedStudents,$record->student_id,$class->subject_code,$class->time_row_id);
                                            if($isAbsent == true){ ?> 
                                                <th class="text-center"><input name="<?php echo $record->student_id.$section_row_id.$class->time_id.$staff_sub_row_id; ?>" type="checkbox" class="singleSelect" value="true" checked /> </th>
                                            <?php }else{ ?> 
                                                <th class="text-center"><input name="<?php echo $record->student_id.$section_row_id.$class->time_id.$staff_sub_row_id; ?>" type="checkbox" class="singleSelect" value="false" /> </th>
                                            <?php } 
                                        } 
                                        // }  
                                    } ?>
                                      
                                </tr>
                                <?php } }else{ ?>
                                    <tr class="table-info">
                                        <th colspan="8" class="text-center">Record not found!</th>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfooter class="text-center">
                                <tr class="table_row_background">
                                    <th width="100">Student ID</th>
                                    <th width="200">Name</th>
                                    
                                    <?php if(!empty($classInfo)) {
                                        foreach($classInfo as $class) {
                                            // if($class->staff_subjects_row_id != 0) { ?>
                                                <th><span style="color:black;"><?php echo strtoupper($class->sub_name); ?></span><br>
                                                    <?php echo $class->staff_name; ?><br>
                                                    <span style="color:black;"><?php echo $class->subject_type; ?></span>
                                                </th>
                                    <?php } } ?>
                                </tr>
                            </tfooter>
                        </table>
                    
                        <?php  if(!empty($classInfo)){ ?>
                            <button style="float:right" type="submit" class="btn btn-success">Confirm</button>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>




</div>



<?php
function getAbsentStudentList($con,$student_id,$section_row_id,$time_row_id,$absentDate,$subject_code){
    $query = "SELECT * FROM tbl_student_attendance_details as attendance 
    WHERE attendance.student_id = '$student_id' AND attendance.class_section_row_id = '$section_row_id' 
    AND attendance.time_row_id = '$time_row_id' AND attendance.absent_date = '$absentDate' 
    AND attendance.subject_code = '$subject_code' AND attendance.year = '2022' AND attendance.is_deleted = 0";
    $pdo_statement = $con->prepare($query);
    $pdo_statement->execute();
    return $pdo_statement->fetch();
}


function getStaffSubjectRowId($con,$staff_id,$subject_code,$subject_type){
    $query = "SELECT * FROM tbl_staff_teaching_subjects as staff 
    WHERE staff.staff_id = '$staff_id' AND staff.subject_code = '$subject_code' 
    AND staff.subject_type = '$subject_type' AND  staff.is_deleted = 0";
    $pdo_statement = $con->prepare($query);
    $pdo_statement->execute();
    return $pdo_statement->fetch();
}
?>
<script type="text/javascript">
var loader = '<img height="70" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';
// var term_name = 'I';


jQuery(document).ready(function() {
    var term = $("#term_name").val();
    var stream = $(".stream_name").val();
    var staf_rowId = $("#staff_subject_row_id").val();
    var examType = $("#exam_type").val();

    $('#streamName').prop('disabled', 'disabled');
    if(stream != ''){
        $('#streamName').prop('required', true); 
        $('#streamName').prop('disabled', false);
        $('.loaderScreen').hide();
    }

    $('.loaderScreen').hide();
    // $('select').selectpicker();
    $(".numberonly").focus(function() {
        $(this).attr("type", "number")
    });
    $(".numberonly").blur(function() {
        $(this).attr("type", "text")
    });

    $("#submitMark").submit(function(e) {
        e.preventDefault();
    });
    

    $("#submitMark,#searchButton").click(function() {
        if(term == ''){
            $('.loaderScreen').hide();
        } else if(examType == ''){
            $('.loaderScreen').hide();
        } else if(stream == ''){
            $('.loaderScreen').hide();
        } else if(staf_rowId == ''){
            $('.loaderScreen').hide();
        } else if ($('#streamName').prop("disabled") == true) {
            alert('cbd');
        } else{
            $('.loaderScreen').show();
        }
    });
    
    // $("#submitMark").click(function() {
    //     var isValid = true;
    //     $('#addInternalMarK input[type=text]').each(function(i,e) {
    //         if(e.value == '') {
    //             $('.loaderScreen').hide();
    //         }else{
    //             $('.loaderScreen').show();
    //         }
    //     });
    // });
    
    jQuery('.datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        dateFormat: "dd-mm-yy",
        maxDate : 0,
        startDate : "01-01-2021",

    });

    $("#term_name").change(function(){
        var term_name = $("#term_name").val()
        if(term_name == 'II PUC'){
            $('#exam_type_two').show();
        }else{
            $('#exam_type_two').hide();
        }
        if(this.value != 0){
            $('#streamName').prop('disabled', false);
            $('#streamName option:not(:first)').remove();
            $.ajax({
            url: '<?php echo base_url(); ?>/getStreamSectionByTerm',
            type: 'POST',
            dataType: "json",
            data: { term_name : term_name },

            success: function(data) {
                //var examObject = JSON.parse(data);
                var examObject = JSON.stringify(data)
                var count = data.result.length;
                if(count != 0){
                    for(var i=0; i<=count; i++){
                        $("#streamName").append(new Option(data.result[i].stream_name +' - '+ data.result[i].section_name, data.result[i].row_id));
                    }
                }else{
                    $('#streamName').prop('disabled', 'disabled');
                }
            }
        });
        }else{
            $('#streamName').prop('disabled', 'disabled');
            $('#streamName option:not(:first)').remove();
        }
    });
});

function isNumberKey(evt) {
    //alert(mark_ent)
    
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode > 64 && charCode < 91 ) && (charCode < 48 || charCode > 57  || charCode.length < 4))
        return false;
    return true;
}

</script>
