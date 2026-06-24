<?php require APPPATH . 'views/includes/db.php'; ?>
<?php
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
<div class="main-content-container container-fluid px-4">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mt-1 mb-2">
            <div class="col padding_left_right_null">
                <div class="card card-small p-0 card_head_dashboard">
                    <div class="card-body p-2 ml-2">
                        <span class="page-title">
                            <i class="material-icons">description</i>  I PUC Admission
                        </span>
                        <a onclick="window.history.back(); return false;"
                            class="btn btn-primary float-right text-white pt-2" value="Back">Back </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="row form-employee">
        <div class="col-12 padding_left_right_null">
            <div class="card card-small c-border mb-4">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col profile-head">
                                <form action="<?php echo base_url(); ?>admissionFeeProcess_I_PUC" method="post">
                                    <div class="container h-100">
                                        <div class="row h-100 justify-content-center">
                                            <div class="col-6">
                                                <div class="card text-center">
                                                    <div class="card-header bg-info">
                                                        <strong class="text-white" style="font-size: 19px;">I PUC Fee
                                                            Payment - 2022-23
                                                        </strong>
                                                    </div>
                                                    <div class="card-body" style="padding:5px;">
                                                        <h6 class="card-title"> Please verify your information.</h6>
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <tr class="table-success">
                                                                    <th class="text-left" scope="col">Name</th>
                                                                    <th class="text-left" scope="col">
                                                                        <?php echo $studentInfo->student_name; ?></th>
                                                                </tr>
                                                                <tr class="table-primary">
                                                                    <th class="text-left" scope="col">Application No.
                                                                    </th>
                                                                    <th class="text-left" scope="col">
                                                                        <?php echo $studentInfo->application_no; ?>
                                                                    </th>
                                                                </tr>
                                                                <tr class="table-success">
                                                                    <th class="text-left" scope="col">Category</th>
                                                                    <th class="text-left" scope="col">
                                                                        <?php echo $studentInfo->category; ?>
                                                                    </th>
                                                                </tr>
                                                                <tr class="table-primary">
                                                                    <th class="text-left" scope="col">Term</th>
                                                                    <th class="text-left" scope="col">I PUC</th>
                                                                </tr>
                                                                <tr class="table-success">
                                                                    <th class="text-left" scope="col">Stream</th>
                                                                    <th class="text-left" scope="col">
                                                                        <?php echo $studentInfo->stream_name; ?>
                                                                    </th>
                                                                </tr>
                                                                <tr class="table-success">
                                                                    <th class="text-left" scope="col">Elective</th>
                                                                    <th class="text-left" scope="col">
                                                                        <?php echo $studentInfo->elective_sub; ?>
                                                                    </th>
                                                                </tr>
                                                                <!-- <?php //if($langFeeInfo['lang_status']){ ?>
                                                                    <tr class="bg-primary text-white">
                                                                    <th class="text-left" scope="col">Elective Sub Fee</th>
                                                                    <th class="text-left" scope="col">
                                                                        <?php //echo $langFeeInfo['lang_amt']; ?>
                                                                    </th>
                                                                </tr>
                                                                <?php // } ?> -->
                                                                <tr class="bg-primary text-white">
                                                                    <th class="text-left" scope="col">Total Fee Amt</th>
                                                                    <th class="text-left" scope="col">
                                                                        <?php echo number_format($total_fee_amount,2); ?>
                                                                    </th>
                                                                </tr>
                                                                <tr class="bg-success text-white">
                                                                    <th class="text-left" scope="col">Fee Paid Amt</th>
                                                                    <th class="text-left" scope="col">
                                                                        <?php echo number_format($total_fee_paid,2); ?>
                                                                    </th>
                                                                </tr>
                                                                <?php if(!empty($instalment_amt)){ ?>
                                                                <tr class="bg-info text-white">
                                                                    <th class="text-left" scope="col">Instalment Amt</th>
                                                                    <th class="text-left" scope="col">
                                                                        <?php echo number_format($instalment_amt,2); ?>
                                                                    </th>
                                                                </tr>
                                                                <?php } ?>
                                                                <tr class="bg-danger text-white">
                                                                    <th class="text-left" scope="col">Pending Fee Amt</th>
                                                                    <th class="text-left" scope="col">
                                                                        <?php echo number_format($pending_amount,2); ?>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                        <div class="form-group position-relative mb-1">
                                                            <input class="form-control mobile-width"
                                                                value="<?php echo $fee_amount; ?>" type="hidden"
                                                                id="name" name="amount" autocomplete="off">
                                                        </div>
                                                        <!-- <div class="row ">
                                                            <div class="col-6 ">
                                                                <button type="button"
                                                                    class="btn btn-info btn-sm float-left"
                                                                    data-toggle="modal" data-target="#helpGuidePayment">
                                                                    UNDERTAKING
                                                                   </button>
                                                            </div>
                                                            <div class="col-6">
                                                            </div>
                                                        </div> -->
                                                        <!-- <div class="row text-left ">                                            
                                                        <div class="col-12">
                                                            <ul>
                                                            <b>You are provisionally selected for admission to sjpuc.</b>
                                                         <li class="text-black">Last date to pay the fees : <b>08-09-2020</b> by 10 AM </li>
                                                            <li class="text-black">Fees includes annual academic expenses only.</li>
                                                            <li class="text-black">Uniform and Books not included in the fees.</li>
                                                            <li class="text-black">Payment of fees confirms your admission.</li>
                                                            <li class="text-black">CANCELLATION OF ADMISSION IS NOT ENCOURAGED</li>
                                                            <li class="text-black">Fee once paid will not be refunded</li>
                                                            <p><b>You will receive the payment details via SMS. Receipt copy will be given later</b></p>
                                                            </ul>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <?php if($pending_amount>0){ ?>
                                                    <div class="card-footer text-muted" style="padding:1px;">
                                                        <button type="submit" name="CHECKOUT"
                                                            class="btn btn-success btn-block"> <i
                                                                class="fas fa-rupee-sign"></i> <strong>Pay
                                                                Now</strong></button>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="card border-success mb-3">
                                                    <div class="card-header bg-transparent border-success">Payment Info</div>
                                                        <div class="card-body">
                                                            <?php if(!empty($feePaidInfo)){ ?>
                                                            <table class="table table-hover">
                                                            <thead>
                                                            <tr class="table-success">
                                                                    <th class="text-left" scope="col" width="80">Date</th>
                                                                    <th class="text-left" scope="col" width="80">Receipt No</th>
                                                                    <th class="text-left" scope="col" width="120">Order ID</th>
                                                                    <th class="text-left" scope="col" width="80">Amount</th>
                                                            </tr>
                                                            
                                                            <?php foreach($feePaidInfo as $fee){ ?>
                                                            <tr class="table-info">
                                                                <th class="text-left" scope="col" width="140"> <?php echo date('d-m-Y',strtotime($fee->payment_date)); ?></th>
                                                                <th class="text-left" scope="col" width="80"><?php echo $fee->receipt_number; ?></th>
                                                                <th class="text-left" scope="col" width="120"><?php echo $fee->order_id; ?></th>
                                                                <th class="text-left" scope="col" width="80"><?php echo $fee->paid_amount; ?></th>
                                                                
                                                            </tr>
                                                            <?php } ?>
                                                            </thead>
                                                            </table>    
                                                            <?php }else{ ?>
                                                                <div>No Payment Details.</div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Installement Modal -->
<div class="modal fade" id="instalmtRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel"><strong>Installment Request</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo base_url(); ?>requestToInstallment">
                <div class="modal-body">
                    <p style="color:red"> Principal must be approve your request for installment. After approval of
                        request, you will get SMS remainder for installment payment.<br>
                        <b>Date of paying second installment : 01-08-2020</b>
                    </p>
                    <!-- <h4><b>Rules for admission:</b></h4>
                    <ul>
                        <li>Payment of fees for the II PUC (2020-21 BATCH), (fees once paid will not refunded)</li>
                        <li>All grievances, and requests are to be sent to admissionsjpuc@yahoo.com</li>
                        <li>II PUC Admission related queries, clarifications : @ 9071004373 (Call, WhatsApp)</li>
                    </ul> -->
                    <table class="table table-hover">
                        <thead>
                            <tr class="table-success">
                                <th class="text-left" scope="col">First Installment</th>
                                <th class="text-left" scope="col">
                                    <?php echo $installment_amt; ?></th>
                            </tr>
                            <tr class="table-primary">
                                <th class="text-left" scope="col">Second Installment</th>
                                <th class="text-left" scope="col">
                                    <?php echo $installment_amt; ?>
                                </th>
                            </tr>
                    </table>
                    <input class="form-control mobile-width" value="<?php echo $installment_amt; ?>" type="hidden"
                        id="name" name="installment_amt" autocomplete="off">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Request to Pay First Installment</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Installement Modal -->
<div class="modal fade" id="helpGuidePayment" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel"><strong>UNDERTAKING</strong></h5>
             
            </div>
            <div class="modal-body" >
                <h6 class="text-center"><b> LETTER OF UNDERTAKING BY PARENT/S AND/OR LOCAL GUARDIAN FOR STUDENTS OF
                        ST. JOSEPH'S PRE-UNIVERSITY COLLEGE, BENGALURU – 25</b>
                </h6>
                <p >
                    I/We the undersigned as parent/s or guardian
                    of <b><?php echo $studentInfo->student_name; ?></b>
                    hereby confirm that I/we as (a) parent/s have read and studied the conditions of acceptance
                    (given
                    along with the admission form) for I & II PUC and I/we related to the contents thereof. I/We as (a)
                    parent/s declare our willingness to abide by the terms and conditions of acceptance as well as the
                    rules
                    and regulations of the Institution, code of conduct (punctuality & good behaviour), rules of
                    discipline,
                    dress code (College Uniform on the prescribed days & formal dress on Saturdays, short haircut, clean
                    shaven and no colouring of hair. Students are not permitted to grow hair/beard and wear ear studs
                    citing
                    religious reasons), code of attendance (85% of attendance in each subject at any given time) and all
                    College practices (spiritual, physical & human development activities). As (a) parent/s I/We am/are
                    (a)
                    collaborator/s in the education of my/our son and I/we will attend all the Parent Teacher Interface
                    (PTI)
                    programmes without fail. I/We will also ensure that my/our son does not carry a cell phone/any
                    electronic
                    gadget to College and if the cell phone/gadget is confiscated I/we promise that I/we will never
                    harass the
                    College authorities to return the same. If my/our ward does not pass the First Year PU final exams,
                    I/we
                    will not seek influence of the PU Board officials or any other official and pressurize the College
                    authorities. I/we undertake to face the disciplinary action that is extended to my/our son if he
                    indulges in
                    malpractices during the tests and examinations conducted by the College. I/we understand that if
                    my/our
                    son engages in physical fights inside/outside the College campus and if he is found intoxicated or
                    in
                    possession of narcotic substances he will be dismissed from the Institution. I/We will respect the
                    decision
                    of the Institution in forbidding students to use geared motor vehicles. I/we will respect all
                    structures of
                    authority of St. Joseph's Pre-University College.
                </p>
                <p>
                    I/we as parent/s have not paid donation to any person to get admission. I/we will abide by the rules
                    to
                    diligently pay all College fees on time.
                </p>
                <p>
                    I/we accept that once a student leaves the campus with / without the written permission from the
                    College
                    Authorities, the College Management, Principal or any authorized individual of St. Joseph's PU
                    College
                    will not be held responsible in case of any unforeseen occurrence outside the campus.
                </p>
                <p>
                    I/We as parent/s accept that all activities / College educational outings (NCC, trekking, village
                    exposure
                    camp and sports) is undertaken at the student's own risk and that the College, Principal, Teachers,
                    any
                    authorized individual of St. Joseph's PU College will not be held liable for any claims and / or
                    accountability that will arise from any loss, damages and injuries to the student or his property
                    during any
                    above mentioned activities.
                </p>
                <p>
                    If my / our son fails to live up to the standards of the St. Joseph's Pre-University College &
                    Pre-University
                    Board, I/we will voluntarily take the Transfer Certificate (TC) and will not mount pressure on the
                    College
                    authorities. This letter of undertaking is binding on me/us, and the student. I/We readily agree to
                    be
                    collaborators in the educational endeavour of my/our son.
                </p>
                <h6>FATHER'S/GUARDIAN'S SIGNATURE: ..............................................................</h6>
                <h6>NAME: <b><?php echo $studentInfo->father_name; ?></b></h6>
                <h6>MOTHER'S/GUARDIAN'S SIGNATURE: ..............................................................</h6>
                <h6>NAME: <b><?php echo $studentInfo->mother_name; ?></b></h6>
                <h6>APPLICATION NO: <b><?php echo $studentInfo->application_no; ?></b></h6>
                <h6>SECTION : ....................................................ROLL NO :
                    ........................................</h6>
                <h6>PLACE: <b>BANGALORE</b></h6>
                <h6>PLACE: <b><?php echo date('d-m-Y'); ?></b></h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">I Accept</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    // $('#helpGuidePayment').modal('show');
});
</script>