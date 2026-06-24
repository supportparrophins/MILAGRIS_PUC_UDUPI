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
                                <form action="<?php echo base_url(); ?>paySupplementaryFee" method="post">

                                    <div class="container h-100">
                                        <div class="row h-100 justify-content-center align-items-center">
                                            <form class="col-12">
                                                <div class="card text-center">
                                                <?php if(!empty($studentInfo)){ ?>
                                                    <div class="card-header bg-info">
                                                        <strong class="text-white" style="font-size: 19px;">Supplementary Exam Fee
                                                            Payment - 2020-21
                                                        </strong>
                                                    </div>
                                                    <div class="card-body" style="padding:5px;">
                                                 
                                                        <h6 class="card-title"> Please verify your information.</h6>
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <tr class="table-success">
                                                                    <th class="text-left" scope="col">Name</th>
                                                                    <th class="text-left" scope="col">
                                                                        <?php echo $student_name; ?></th>
                                                                </tr>
                                                                <tr class="table-primary">
                                                                    <th class="text-left" scope="col">Register No.</th>
                                                                    <th class="text-left" scope="col">
                                                                        <?php echo $studentInfo->pu_board_number; ?>
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
                                                                <tr class="table-primary">
                                                                    <th class="text-left" scope="col">Total Subjects</th>
                                                                    <th class="text-left" scope="col"><?php echo $_SESSION['failed_sub_count']; ?></th>
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
                                                                    <th class="text-left" scope="col">Rs. 
                                                                        <?php echo $studentInfo->supply_fee; ?>
                                                                    </th>
                                                                </tr>

                                                            </thead>

                                                        </table>

                                                     
                                                     
                                                    </div>

                                                    <div class="card-footer text-muted" style="padding:1px;">
                                                        <button type="submit" name="CHECKOUT"
                                                            class="btn btn-success btn-block"> <i
                                                                class="fas fa-rupee-sign"></i> <strong>Pay
                                                                Now</strong></button>

                                                    </div>
                                                                <?php } else { ?>
                                                                    <h4>Exam Payment Already Paid</h4>
                                                             <?php   } ?>

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