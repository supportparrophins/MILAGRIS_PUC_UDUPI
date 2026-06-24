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
<!-- <div class="main-content-container container-fluid px-4">
     Content Header (Page header) 
    <section class="content-header">
        <div class="row mt-1 mb-2">
            <div class="col padding_left_right_null">
                <div class="card card-small p-0 card_head_dashboard">
                    <div class="card-body p-2 ml-2">
                        <span class="page-title">
                            <i class="material-icons">description</i> Admission For II PUC
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
                                <form action="<?php echo base_url(); ?>payTmReAdmissionFeeAmount" method="post">

                                    <div class="container h-100">
                                        <div class="row h-100 justify-content-center align-items-center">
                                            <form class="col-12">
                                                <div class="card text-center">
                                                    <div class="card-header bg-info">
                                                        <strong class="text-white" style="font-size: 19px;">II Year Fee
                                                            Payment - 2021-22
                                                        </strong>
                                                    </div>
                                                    <div class="card-body" style="padding:5px;">
                                                        <h6 class="card-title"> Please verify your information.</h6>
                                                        <table class="table table-hover">
                                                           

                                                        </table>

                                                       
                                                        <div class="row ">
                                                            <div class="col-6 ">
                                                                <button type="button"
                                                                    class="btn btn-info btn-sm float-left"
                                                                    data-toggle="modal" data-target="#helpGuidePayment">
                                                                    Help
                                                                    <i class="fa fa-question-circle"
                                                                        aria-hidden="true"></i></button>
                                                            </div>
                                                            <div class="col-6">
                                                             
                                                            </div>
                                                        </div>
                                                    </div>
                                                   
                                                    


                                                </div>
                                            </form>
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
</div> -->



<div class="main-content-container container-fluid px-4 ">
    <div class="row mt-1 mb-2">
        <div class="col padding_left_right_null">
            <div class="card card-small p-0 card_head_dashboard" style="background: #40c4ff;">
                <div class="card-body p-2 ml-2">
                    <span class="page-title">
                        <i class="material-icons">description</i> I PUC Fee Payment - <?php echo CURRENT_YEAR ?>
                       
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-6">
            <div class="row">
                <div class="col-lg-6 col-12 mb-4">
                    <div class="card border-success mb-2">
                        <div class="card-header p-1  border-success" style="background: #C1E1C1;">
                         Admission to II PUC, Fee Info
                    </div>
                    <form action="<?php echo base_url(); ?>payTmReAdmissionFeeAmount" method="post">
                        <div class="card-body p-1">
                            <table class="table table-hover">
                            <thead>
                            <tr class="table-primary">
                                    <th class="text-left" scope="col">Name</th>
                                    <th class="text-left" scope="col">
                                        <?php echo strtoupper($studentInfo->student_name); ?>
                                    </th>
                                </tr>                       
                                <tr class="table-primary">
                                    <th class="text-left" scope="col">Application No.</th>
                                    <th class="text-left" scope="col">
                                        <?php echo $studentInfo->application_no; ?>
                                    </th>
                                </tr>
                                <tr class="table-success">
                                    <th class="text-left" scope="col">Student ID</th>
                                    <th class="text-left" scope="col">
                                        <?php echo $studentInfo->student_id; ?></th>
                                </tr>
                              
                                <tr class="table-success">
                                    <th class="text-left" scope="col">Stream</th>
                                    <th class="text-left" scope="col">
                                        <?php echo $studentInfo->stream_name .' '.$studentInfo->section_name; ?>
                                    </th>
                                </tr>
                                <tr class="bg-info text-white">
                                    <th class="text-left" scope="col">Elective</th>
                                    <th class="text-left" scope="col">
                                        <?php echo strtoupper($studentInfo->elective_sub); ?>
                                    </th>
                                </tr>
                              
                                    <tr class="bg-primary text-white">
                                    <th class="text-left" scope="col">Category</th>
                                    <th class="text-left" scope="col">
                                        <?php echo strtoupper($studentInfo->category); ?>
                                    </th>
                                </tr>
                              

                                <tr class="bg-primary text-white">
                                    <th class="text-left" scope="col">Total Fee Amt</th>
                                    <th class="text-left" scope="col">
                                        <?php echo $total_fee; ?>
                                    </th>
                                </tr>
                                <?php if(!empty($installmentAmtExist)){ ?>
                                    <tr class="bg-info text-white">
                                    <th class="text-left" scope="col">Instalment</th>
                                    <th class="text-left" scope="col">
                                        <?php echo $installmentAmtExist->amount; ?>
                                    </th>
                                </tr>
                                    <?php } ?>
                           
                                    <tr class="bg-success text-white">
                                        <th class="text-left" scope="col">Paid Fee</th>
                                        <th class="text-left" scope="col">
                                            <?php echo number_format($paid_fee,2); ?>
                                        </th>
                                    </tr>
                                    <tr class="bg-danger text-white">
                                        <th class="text-left" scope="col">Pending Fee</th>
                                        <th class="text-left" scope="col">
                                            <?php echo number_format($total_fee_to_pay,2); ?>
                                        </th>
                                    </tr>

                                </thead>

                            </table>
                            <?php if ($total_fee_to_pay > 0) { ?>
                                <?php if(!empty($installmentAmtExist)){ ?>
                                        <div class="form-group position-relative mb-1">
                                            <input class="form-control mobile-width"
                                                value="<?php echo $installmentAmtExist->amount; ?>" type="hidden"
                                                id="name" name="amount" autocomplete="off">
                                        </div>
                                        <div class="card-footer text-muted" style="padding:1px;">
                                        <button type="submit" name="CHECKOUT"
                                            class="btn btn-success btn-block"> <i
                                                class="fas fa-rupee-sign"></i> <strong>Pay <?php echo $installmentAmtExist->amount; ?>
                                                </strong></button>

                                    </div>
                                <?php } else { ?>
                                    <div class="form-group position-relative mb-1">
                                            <input class="form-control mobile-width"
                                                value="<?php echo $total_fee_to_pay; ?>" type="hidden"
                                                id="name" name="amount" autocomplete="off">
                                        </div>
                                    <div class="card-footer text-muted" style="padding:1px;">
                                        <button type="submit" name="CHECKOUT"
                                            class="btn btn-success btn-block"> <i
                                                class="fas fa-rupee-sign"></i> <strong>Pay
                                                Now</strong></button>

                                    </div>
                                <?php  } ?>
                            <?php }else{ ?>
                                <h5 class="text-center">Fee Cleared</h5>
                          <?php  } ?>
                        </div>
                            </form>

                    </div>
                </div>



                <div class="col-lg-6 col-12  mb-4">

                    <div class="">
                        <div class="card border-success mb-3">
                            <div class="card-header p-1  border-success" style="background: #C1E1C1;">Payment Info</div>
                            <div class="card-body px-1 py-1">
                                <table class="table">
                                    <thead>
                                        <tr class="table-primary">
                                            <th scope="col">Date</th>
                                            <th scope="col">Receipt No.</th>
                                            <th scope="col">Paid Amt.</th>
                                            <th scope="col"> Mode</th>
                                            <th scope="col">Status</th>
                                            <!-- <th scope="col">Action</th> -->

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($feePaidInfo)) {
                                            foreach ($feePaidInfo as $fee) { ?>
                                                <tr class="text-dark">
                                                    <th class="text-center">
                                                        <?php echo date('d-m-Y', strtotime($fee->payment_date)); ?></th>
                                                    <th class="text-center"><?php echo $fee->receipt_number; ?></th>
                                                    <th class="text-center"><?php echo $fee->paid_amount; ?></th>
                                                    <th class="text-center"><?php echo $fee->payment_type; ?></th>
                                                    <th class="text-center text-success">SUCCESS</th>
                                                    <!-- <a class="btn btn-primary btn-xs"
                                                    href="<?php echo base_url(); ?>feePaymentReceiptPrint/<?php echo $fee->row_id; ?>"
                                                    target="_blank"> <i class="fa fa-file"></i></a> -->
                                                </tr>
                                            <?php }
                                        } else {  ?>

                                            <tr>
                                                <th class="text-center" colspan="6">Fee Paid info not found.
                                            </tr>


                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

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
          
                    <p style="color:red"> Principal must be approve your request for installment. After approval of request, you will get SMS remainder for installment payment.<br>
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
<div class="modal fade" id="helpGuidePayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel"><strong>Important Note:</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <iframe style="border:2px solid #00b8d8;" src="<?php echo base_url(); ?>assets/images/ST_JOSEPH’S_PU_COLLEGE_II_PUC payment_of_fees.pdf" width="100%" height="800px"></iframe>
            
                <!-- <h6 class="text-center"><b>II PUC Fee Structure - 2020</b></h6> -->

                <!-- <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Combination</th>
                            <th scope="col">Fee Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="col">PCMB</th>
                            <th scope="col">46300.00</th>
                        </tr>
                        <tr>
                            <th scope="col">PCMC</th>
                            <th scope="col">51560.00</th>
                        </tr>
                        <tr>
                            <th scope="col">SEBA</th>
                            <th scope="col">36380.00</th>
                        </tr>
                        <tr>
                            <th scope="col">HEBA</th>
                            <th scope="col">36880.00</th>
                        </tr>
                        <tr>
                            <th scope="col">CEBA</th>
                            <th scope="col">47890.00</th>
                        </tr>
                        <tr>
                            <th scope="col">HESP</th>
                            <th scope="col">33880.00</th>
                        </tr>
                    </tbody>
                </table> -->
                <!-- <ul>
                    <li style="color:green">Payment of fees for the II PUC (2020-21 BATCH), (fees once paid will not
                        refunded)</li>

                    <li style="color:red">Students who have taken French as their Second Language must add extra
                        Rs.5000/- as
                        Language Fees to the Fee Amount. </li>
                    <li style="color:red">Extra charges will be applicable on all the Net banking & Credit Card
                        transactions. </li>
                    <li style="color:green">All grievances, and requests are to be sent to admissionsjpuc@yahoo.com</li>
                    <li style="color:green">II PUC Admission related queries, clarifications : @ 9071004373 (Call,
                        WhatsApp)</li>

                </ul> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
  //  $('#helpGuidePayment').modal('show');
});
</script>