
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
</div>
<div class="main-content-container container-fluid px-4 pt-2">
    <div class="content-wrapper">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12 col-lg-12 padding_left_right_null">
                <div class="card ">
                    <div class="card-header text-white card-content-title p-1 card_head_dashboard">
                        <div class="row ">
                            <div class="col-md-6 col-8 text-black m-auto " style="font-size:22px;"><i class="fas fa-pencil-alt"></i> Edit Exam </span> 
                            </div>
                            <div class="col-md-6 col-4 m-auto"> <a href="#"  onclick="window.history.back();" style="background-color:brown;"
                                    class="btn text-white btn_back float-right mobile-btn "><i
                                        class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Back </a></div>
                        </div>
                    </div>
                    <div class="card-body contents-body">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="updateExamInfo" action="<?php echo base_url() ?>updateExamInfo" method="post" role="form" >
                             <input type="hidden" value="<?php echo $examInfo->row_id; ?>" id="row_id" name="row_id">
                             <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label>Exam Date</label>
                                <input type="text" name="exam_date" id="exam_date1" value="<?php echo date('d-m-Y',strtotime($examInfo->exam_date)); ?>" class="form-control input-sm exam_date1" placeholder="Exam Date" autocomplete="off" required>
                            </div>
                        </div>
                      
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label>Select Term</label>
                                <select class="form-control input-sm" id="class" name="class" data-live-search="true" required>
                                    <option value="">Select Term</option>
                                    <?php if(!empty($examInfo->class)){ ?>
                                          <option value="<?php echo $examInfo->class; ?>" selected>Selected: <?php echo $examInfo->class; ?></option>
                                    <?php } ?>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC</option>
                                </select>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label>Select Stream</label>
                                <select class="form-control input-sm selectpicker" title="Select Stream" id="stream" name="stream" data-live-search="true" required>
                                    <option value="">Select Stream</option>
                                    <?php if(!empty($examInfo->stream)){ ?>
                                          <option value="<?php echo $examInfo->stream; ?>" selected>Selected: <?php echo $examInfo->stream; ?></option>
                                    <?php } ?>
                                    <?php if (!empty($streamInfo)) {
                                        foreach ($streamInfo as $stream) { ?>
                                            <option value="<?php echo $stream->stream_name ?>">
                                                <?php echo $stream->stream_name ?>
                                            </option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label>Select Exam Type</label>
                                <select class="form-control input-sm" id="exam_type" name="exam_type" required>
                                    <option value="">Select Exam Type</option>
                                    <?php if(!empty($examInfo->exam_type)){ ?>
                                          <option value="<?php echo $examInfo->exam_type; ?>" selected>Selected: <?php echo $examInfo->exam_type; ?></option>
                                    <?php } ?>
                                    <?php if (!empty($examTypeInfo)) {
                                            foreach ($examTypeInfo as $examm) { ?>
                                                <option value="<?php echo $examm->exam_type; ?>"><?php echo $examm->exam_type; ?></option>
                                        <?php }
                                        } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label>Select Lab Status</label>
                                <select class="form-control input-sm" id="lab_status" name="lab_status" required>
                                    <option value="">Select Lab Status</option>
                                    <?php if(!empty($examInfo->lab_status)){ ?>
                                          <option value="<?php echo $examInfo->lab_status; ?>" selected>Selected: <?php echo $examInfo->lab_status; ?></option>
                                    <?php } ?>
                                    <option value="YES">YES</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label>Select Subject</label>
                                <select class="form-control input-sm selectpicker" id="subject_name" name="subject_name" data-live-search="true" required>
                                    <option value="">Select Subject</option>
                                    <?php if(!empty($examInfo->name)){ ?>
                                          <option value="<?php echo $examInfo->subject_code; ?>" selected>Selected: <?php echo $examInfo->name; ?></option>
                                    <?php } ?>
                                    <?php if (!empty($subjectInfo)) {
                                        foreach ($subjectInfo as $subject) { ?>
                                            <option value="<?php echo $subject->subject_code; ?>"><?php echo $subject->sub_name; ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        </div>
                        <div class="row min_max_theory">
                         <div class="col-lg-6">
                            <div class="form-group">
                            <label>Min Marks</label>
                                <input type="text" value="<?php echo $examInfo->min_marks; ?>" name="min_marks" id="min_marks" class="form-control input-sm"  onkeypress="return isNumberKey(event)" placeholder="Minimum Marks Theory" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label>Max Marks</label>
                                <input type="text" value="<?php echo $examInfo->max_marks; ?>" name="max_marks" id="max_marks" class="form-control input-sm" onkeypress="return isNumberKey(event)" placeholder="Maximum Marks Theory" autocomplete="off" required>
                            </div>
                        </div>

                    </div>

                    <div class="row min_max_lab">
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label>Min Marks Lab</label>
                                <input type="text" value="<?php echo $examInfo->min_marks_lab; ?>" name="min_marks_lab" id="min_marks_lab" class="form-control input-sm"  onkeypress="return isNumberKey(event)" placeholder="Minimum Marks Lab" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label>Max Marks Lab</label>
                                <input type="text" value="<?php echo $examInfo->max_marks_lab; ?>" name="max_marks_lab" id="max_marks_lab" class="form-control input-sm" onkeypress="return isNumberKey(event)" placeholder="Maximum Marks Lab" autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                    <div class="col-lg-6">
                            <div class="form-group">
                            <label>Hall Ticket Required?</label>
                                <select class="form-control input-sm" id="hall_ticket" name="hall_ticket" required>
                                    <option value="">Hall Ticket Required?</option>
                                    <?php if(!empty($examInfo->hall_ticket)){ ?>
                                          <option value="<?php echo $examInfo->hall_ticket; ?>" selected>Selected: <?php echo $examInfo->hall_ticket; ?></option>
                                    <?php } ?>
                                    <option value="YES">YES</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 hall_ticket">
                            <div class="form-group">
                            <label>Select Session</label>
                                <select class="form-control input-sm" id="time" name="time" data-live-search="true">
                                    <option value="">Select Session</option>
                                    <?php if(!empty($hallTicketInfo->time)){ ?>
                                          <option value="<?php echo $hallTicketInfo->time; ?>" selected>Selected: <?php echo $hallTicketInfo->time; ?></option>
                                    <?php } ?>
                                    <option value="Morning session">Morning session</option>
                                    <option value="Afternoon session">Afternoon session</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 hall_ticket">
                            <div class="form-group">
                            <label>Exam Name</label>
                                <input type="text" value="<?php echo $hallTicketInfo->exam_name; ?>" name="exam_name" id="exam_name" class="form-control input-sm" placeholder="Exam Name" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-lg-6 hall_ticket">
                            <div class="form-group">
                            <label>Select Exam Type (Hall Ticket)</label>
                                <select class="form-control input-sm" id="exam_type_hall" name="exam_type_hall">
                                    <option value="">Select Exam Type (Hall Ticket)</option>
                                    <?php if(!empty($hallTicketInfo->exam_type)){ ?>
                                          <option value="<?php echo $hallTicketInfo->exam_type; ?>" selected>Selected: <?php echo $hallTicketInfo->exam_type; ?></option>
                                    <?php } ?>
                                    <option value="THEORY">THEORY</option>
                                    <option value="LAB">LAB</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-success m-2 float-right" value="Update" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
function GoBackWithRefresh(event) {
    showLoader();
    if ('referrer' in document) {
        window.location = '<?php echo base_url(); ?>examListing';
        /* OR */
        //location.replace(document.referrer);
    } else {
        window.history.back();
    }
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57) )
        return false;
    return true;
}

function isNumber(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 48  && 
        (charCode < 48 || charCode > 57) )
        return false;
    return true;
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#uploadedImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#vImg").change(function() {
    readURL(this);
});

jQuery(document).ready(function() {

        $('.min_max_theory').hide();
        $('.min_max_lab').hide();
        $('.hall_ticket').hide();

        //oncahnge  result type
        $("#lab_status").on('change',function(){
            var resutTyps = $("#lab_status").val();
            if(resutTyps == 'YES'){
                $('.min_max_lab').show();
                $('.min_max_theory').show();
                $('#min_marks').prop('required', true);
                $('#max_marks').prop('required', true);
                $('#min_marks_lab').prop('required', true);
                $('#max_marks_lab').prop('required', true);
            }else{
                $('.min_max_lab').hide();
                $('.min_max_theory').show();
                $('#min_marks').prop('required', true);
                $('#max_marks').prop('required', true);
                $('#min_marks_lab').prop('required', false);
                $('#max_marks_lab').prop('required', false);
            }
            
        });


        $("#hall_ticket").on('change',function(){
            var hall_ticket = $("#hall_ticket").val();
            if(hall_ticket == 'YES'){
                $('.hall_ticket').show();
                $('#time').prop('required', true);
                $('#exam_name').prop('required', true);
                $('#exam_type_hall').prop('required', true);
            }else{
                $('.hall_ticket').hide();
                $('#time').prop('required', false);
                $('#exam_name').prop('required', false);
                $('#exam_type_hall').prop('required', false);
            }
            
        });

        var resutTyps = $("#lab_status").val();
          if(resutTyps!= ""){
            if(resutTyps == 'YES'){
                $('.min_max_lab').show();
                $('.min_max_theory').show();
                $('#min_marks').prop('required', true);
                $('#max_marks').prop('required', true);
                $('#min_marks_lab').prop('required', true);
                $('#max_marks_lab').prop('required', true);
            }else{
                $('.min_max_lab').hide();
                $('.min_max_theory').show();
                $('#min_marks').prop('required', true);
                $('#max_marks').prop('required', true);
                $('#min_marks_lab').prop('required', false);
                $('#max_marks_lab').prop('required', false);
            }
        }

        var hall_ticket = $("#hall_ticket").val();
        if(hall_ticket!= ""){
            if(hall_ticket == 'YES'){
                $('.hall_ticket').show();
                $('#time').prop('required', true);
                $('#exam_name').prop('required', true);
                $('#exam_type_hall').prop('required', true);
            }else{
                $('.hall_ticket').hide();
                $('#time').prop('required', false);
                $('#exam_name').prop('required', false);
                $('#exam_type_hall').prop('required', false);
            }
          }

 
    jQuery('.datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy",
        startDate : "01-01-2021"

    });

});
        
            

$('.start_time').datetimepicker(
        {

          format: 'hh:mm A',
          icons: {
                    up: "fa fa-chevron-up",
                  down: "fa fa-chevron-down"
                 }

       });




</script>