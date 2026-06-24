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
    <strong>Error!</strong>
    <?php echo $this->session->flashdata('error'); ?>
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
                            <div class="col-12 col-lg-9 box-tools">
                                <span class="page-title">
                                    <i class="fas fa-tachometer-alt"></i> Admission Dashboard
                                </span>
                            </div>
                            <div class="col-lg-3">
                            <form action="<?php echo base_url() ?>admissionDashboard" method="POST" id="byFilterMethod">
                            <div class="input-group mobile-btn float-right student_search">
                                        <select class="p-1 search_select" name="admission_year" id="admission_year">
                                            <?php if(!empty($admission_year)){ ?>
                                                <option value="<?php echo $admission_year; ?>" selected><b>Selected: <?php echo $admission_year; ?></b></option>
                                            <?php } ?>
                                            <option value="<?php echo CURRENT_YEAR?>"><?php echo CURRENT_YEAR?></option>
                                            <option value="2021">2021</option>
                                            
                                        </select>
                                        <div class="input-group-append">
                                        <button type="submit" class="btn btn-success border_radius_none py-0">
                                            <i class="fa fa-search"></i>
                                        </button>
                                        </div>
                                    </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2">
                        <div class="row">
                            <div class="col-md-6 col-12 mb-2">
                                <div class="card card-small">
                                    <div class="card-header border-bottom card_head_dashboard">
                                        <h6 class="m-0 text-dark">Application Quick Info</h6>
                                    </div>
                                    <div class="card-body p-1">
                                        <div class="row">
                                            <div class="col-9 col-sm-9 ">
                                                <div class="autocomplete">
                                                    <input id="application_number" type="text" name="application_number"  class="form-control input-sm pull-right" placeholder="Type Application Number" required autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-3 col-sm-3 pl-0">
                                                <button type="button" id="viewSingleStudent" class="btn btn-success btn-md btn-block" ><i class="fa fa-search"></i> Search</button>
                                            </div>
                                        </div>
                                        <hr class="my-1">
                                        <div class="resultStudent">
                                            <div class="table-info p-2">
                                                <h6 class="text-center mb-0">Search by Student Application Number</h6>
                                            </div>
                                        </div>

                                        <form action="<?php echo base_url() ?>shorlitedStudentPDF_PRINT" method="POST"
                                        id="byFilterMethod">
                                    
                                            <select class="form-control input-sm" id="preference" name="preference"
                                                autocomplete="off">
                                               
                                                <option value="PCMB" >PCMB</option>
                                                <option value="PCMC" >PCMC</option>
                                                <option value="PCME" >PCME</option>
                                                <option value="PCMS" >PCMS</option>
                                                <option value="CEBA" >CEBA</option>
                                                <option value="CSBA" >CSBA</option>
                                                <option value="MEBA" >MEBA</option>
                                                <option value="MSBA" >MSBA</option>
                                                <option value="PEBA" >PEBA</option>
                                                <option value="SEBA" >SEBA</option>
                                                <option value="HEPS" >HEPS</option>

                                            </select>
                                       
                                       
                                       
                                        <th style="padding: 1px;" class="text-center">
                                            <button type="submit" class="btn btn-success btn-md btn-block"><i
                                                    class="fa fa-filter"></i> PDF Download</button>
                                        </th>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <div class="card mb-2">
                                    <div class="card-body p-1">
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-0">
                                                <tr class="table-success">
                                                    <th colspan="2">Quick Info of Admission</th>
                                                </tr>
                                                <tr>
                                                    <th width="200" class="">Registered Students</th>
                                                    <th><?php echo $registeredCount; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Applied Students</th>
                                                    <th><?php echo $appliedCount; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Approved Students</th>
                                                    <th><?php echo $approvedCount; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Rejected Students</th>
                                                    <th><?php echo $rejectedCount; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Shortlisted Students</th>
                                                    <th><?php echo $shortlistedCount; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Interview Completed</th>
                                                    <th><?php echo $interviewCount; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Fee Paid</th>
                                                    <th><?php echo $completedCount; ?></th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <div class="card">
                                    <div class="card-body p-1">
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-0">

                                                <tr class="text-center table-primary">
                                                    <th>Stream</th>
                                                    <th>Approved</th>
                                                    <th>Completed (Fee Paid)</th>
                                                    <th>Rejected</th>
                                                </tr>
                                                <?php for($i=0;$i<count($streamInfo);$i++){ ?>
                                                <tr>
                                                    <th><?php echo $streamInfo[$i]; ?></th>
                                                    <th class="text-center"><?php echo $streamApprovedCount[$i]; ?></th>
                                                    <th class="text-center"><?php echo $streamCompletedCount[$i]; ?>
                                                    </th>
                                                    <th class="text-center"><?php echo $streamRejectedCount[$i]; ?></th>
                                                </tr>
                                                <?php } ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <div class="card">
                                    <div class="card-body p-1">
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-0">
                                                <tr class="table-primary">
                                                    <th colspan="4">Admission Completed Count</th>
                                                </tr>
                                                <tr class="text-center table-primary">
                                                    <th>Stream</th>
                                                    <th>KANNADA</th>
                                                    <th>HINDI</th>
                                                    <th>FRENCH</th>
                                                </tr>
                                                <?php for($i=0;$i<count($streamInfo);$i++){ 
                                                    $stream = $streamInfo[$i]; ?>
                                                <tr>
                                                    <th width="150"><?php echo $streamInfo[$i]; ?></th>
                                                    <?php  for($j=0;$j<count($electiveSubject);$j++){
                                                        $elective = $electiveSubject[$j]; ?>
                                                    <th class="text-center"><?php echo $electiveAdmittedCount[$stream][$elective]; ?></th>
                                                    <?php } ?>
                                                </tr>
                                                <?php } ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12 mb-2">
                                <div class="card">
                                    <div class="card-body p-1">
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-0">
                                            <tr class="table-primary">
                                                    <th colspan="4">Admission Completed Count by stream</th>
                                                </tr>
                                                <tr class="text-center table-primary">
                                                    <th>Stream</th>
                                                    <th>Total Intake</th>
                                                    <th>Completed </th>
                                                    <th>Pending</th>
                                                </tr>
                                                <?php for($i=0;$i<count($streamInfo);$i++){ ?>
                                                <tr>
                                                    <th><?php echo $streamInfo[$i];
                                                    $total_seats = getInTakeCount($streamInfo[$i]);
                                                    ?></th>
                                                    <th class="text-center"><?php echo $total_seats; ?></th>
                                                    <th class="text-center"><?php echo $streamCompletedCount[$i]; ?>
                                                    </th>
                                                    <th class="text-center"><?php echo $total_seats - $streamCompletedCount[$i]; ?></th>
                                                </tr>
                                                <?php } ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-12">
                                <div class="card">
                                    <div class="card-body p-1">
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-0">
                                                <tr class="table-success">
                                                    <th colspan="11">Seat Merit Info I PUC</th>
                                                </tr>
                                                <tr class="text-center table-primary">
                                                    <th>Stream</th>
                                                    <th>ROMAN CATHOLIC</th>
                                                    <th>OTHER CHRISTIANS</th>
                                                    <th>SC</th>
                                                    <th>ST</th>
                                                    <th>CAT-I</th>
                                                    <th>2A</th>
                                                    <th>2B</th>
                                                    <th>3A</th>
                                                    <th>3B</th>
                                                    <th>GM</th>
                                                </tr>
                                                <?php for($i=0;$i<count($streamInfo);$i++){ 
                                                    $stream = $streamInfo[$i]; ?>
                                                <tr>
                                                    <th><?php echo $streamInfo[$i]; ?></th>
                                                    <?php  for($c=0;$c<count($categoryArray);$c++){
                                                        $category = $categoryArray[$c];
                                                        ?>
                                                    <th class="text-center"><?php echo $categoryStreamCount[$stream][$category]; ?></th>
                                                    <?php } ?>

                                                  
                                                </tr>
                                                <?php } ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function(){
        var admission_document_path = "<?php echo ADMISSION_DOCUMENT_PATH; ?>";
        $("#viewSingleStudent").on('click',function(){
            var application_number = $('#application_number').val();
            var admission_year = $('#admission_year').val();

            if(application_number == ""){
                $('.resultStudent').html(`<div class="alert alert-danger" role="alert">Application Number is Empty!!</div>`);
            }else{
                $.ajax({
                url: '<?php echo base_url(); ?>/getStudentInfoByApplicationNumber',
                type: 'POST',
                data: { application_number : application_number,admission_year : admission_year},
                    success: function(data) {
                        if(data.studentInfo == null){
                            $('.resultStudent').html(`<div class="alert alert-info" role="alert">Student Not Found!! 
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>`);
                        }else{
                        if(data.studentInfo.admission_status == 0){
                            var admissionStatus = '<span class="text-danger">Pending</span>';
                        }else if(data.studentInfo.admission_status == 1){
                            var admissionStatus = '<span class="text-success">Accepted</span>';
                        }else{
                            var admissionStatus = '<span class="text-danger">Rejected</span>';
                        }
                        if(data.fee_payment_status == 1){
                            var admissionCompletedStatus = '<span class="text-success">Paid</span>';
                        }else{
                            var admissionCompletedStatus = '<span class="text-danger">Pending</span>';
                        }
                        if(data.studentInfo.application_fee_status == 1){
                            var applicationFeePayment = '<span class="text-success">Paid</span>';
                        }else{
                            var applicationFeePayment = '<span class="text-danger">Pending</span>';
                        }
                        // if(data.stdPhoto.doc_path == null){
                        //     var stdImage = '<img class="text-right" src="assets/dist/img/user.png" height="110" width="110" alt="profile Img">';
                        // }else{
                        //     var stdImage = '<img class="text-right" src="'+admission_document_path+''+data.stdPhoto.doc_path+'" height="110" width="110" alt="profile Img">';
                        // }
                        $('.resultStudent').html(`
                            <div class="row">
                            <div class="col-lg-12">
                                <h5 class="pb-1">Name: <b>`+data.studentInfo.name+`</b></h5>
                                <h5 class="pb-1">Application Number: <b>`+data.studentInfo.application_number+`</b></h5>
                            </div>
                            </div>
                            <div class=" table-responsive">
                            <table class="table table-bordered" style="border-color:red">
                            <tbody>

                                <tr class="table-success">
                                    <td>Category</td>
                                    <th>`+data.studentInfo.caste+`</th>
                                </tr>

                                <tr class="table-info">
                                    <td>Stream Name</td>
                                    <th>`+data.studentInfo.stream_name+`</th>
                                </tr>

                                <tr class="table-success">
                                    <td>Father Name</td>
                                    <th>`+data.studentInfo.father_name+`</th>
                                </tr>
                                
                                <tr class="table-info">
                                    <td>Father Mobile</td>
                                    <th>`+data.studentInfo.father_mobile+`</th>
                                </tr>

                                <tr class="table-success">
                                    <td>Mother Name</td>
                                    <th>`+data.studentInfo.mother_name+`</th>
                                </tr>

                                <tr class="table-info">
                                    <td>Mother Mobile</td>
                                    <th>`+data.studentInfo.mother_mobile+`</th>
                                </tr>
                                <tr class="table-success">
                                    <td>Application Status</td>
                                    <th>`+admissionStatus+`</th>
                                </tr>
                                <tr class="table-success">
                                    <td>Fee Payment</td>
                                    <th>`+admissionCompletedStatus+`</th>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                        `);
                        }
                    },
                    error: function(result){
                        alert("Retry Again! Something Went Wrong");
                    },
                    fail:(function(status) {
                        alert("Retry Again! Something Went Wrong");  
                    }),
                    beforeSend:function(d){
                        // $('.resultStudent').html('<span class="text-center">'+loader+'</span>');
                        
                                // <tr class="table-success">
                                //     <td>Admission Status</td>
                                //     <th>`+admissionCompletedStatus+`</th>
                                // </tr> 
                    }
                });
            }
        });
    });
</script>
<?php 

function getInTakeCount($stream_name){
    $PCMB = 320;
    $PCMC = 160;
    $PCMS = 80;
    $PCME = 80;
    //commarce
    $PEBA = 80;
    $MEBA = 80;
    $MSBA = 160;
    $CSBA = 80;
    $SEBA = 160;
    $CEBA = 160;
    //art
    $HEPS = 80;
    switch ($stream_name) {
        case "PCMB":
                return  $PCMB;
                break;
        case "PCMC":
                return $PCMC;
                break;
        case "PCMS":
                    return $PCMS;
                    break;
        case "PEBA":
                return $PEBA;
                break;
        case "PCME":
                return $PCME;
                break;
        case "MEBA":
                return $MEBA;
                break;
        case "MSBA":
                return $MSBA;
                break;
        case "CSBA":
                return $CSBA;
                break;
        case "SEBA":
                return $SEBA;
                break;
        case "CEBA":
                return $CEBA;
                break;
        case "HEPS":
                return $HEPS;
                break;
    }
}
?>