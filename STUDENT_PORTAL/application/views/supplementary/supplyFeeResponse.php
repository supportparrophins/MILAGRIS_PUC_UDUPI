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
<style>
@media print {
 .noprint {display:none;}
 ::-webkit-scrollbar {
    display: none;
}
 .enable-print { display: block !important; }
}
</style>
<div class="row">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container container-fluid px-4">
    <!-- Content Header (Page header) -->
    <section class="content-header noprint">
        <div class="row mt-1 mb-2">
            <div class="col padding_left_right_null">
                <div class="card card-small p-0 card_head_dashboard">
                    <div class="card-body p-2 ml-2">
                        <span class="page-title">
                            <i class="material-icons">description</i> Payment Summary
                        </span>
                        <a onclick="<?php echo base_url().'dashboard' ?>"
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

                                <?php if($response->getStatusCode() == "S"){ ?>
                                <div class="container h-100">
                                    <div class="row h-100 justify-content-center align-items-center">
                                        <form class="col-12">
                                            <div class="card text-center">
                                                <div class="card-header bg-info ">
                                                    <strong class="text-white" style="font-size: 19px;">Payment Summary
                                                    </strong>
                                                </div>
                                                <div class="card-body" style="padding:5px;">
                                                <img width="100" src="<?php echo base_url() ?>assets/images/payment_sucess.png" alt="Payment Success">
                                                    <h6 class="card-title"> Your Supplementary Exam Fee Payment has been successfully processed.</h6>
                                                    <table class="table table-hover">
                                                        <thead>
                                                         
                                                            <tr>
                                                                <th class="text-left" scope="col">Order No</th>
                                                                <th class="text-left" scope="col">
                                                                    <?php echo $response->getOrderId(); ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-left" scope="col">Receipt No.</th>
                                                                <th class="text-left" scope="col">
                                                                    <?php echo 'SJPUC'.$receipt_number; ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-left" scope="col">Date</th>
                                                                <th class="text-left" scope="col">
                                                                    <?php echo date('d-m-Y'); ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-left" scope="col">Paid Amt</th>
                                                                <th class="text-left" scope="col">
                                                                    <?php echo $response->getTrnAmt()/100; ?></th>
                                                            </tr>
                                                           
                                                        </thead>

                                                    </table>


                                                    <div class="row noprint">
                                                        <div class="col-6 ">
                                                            <button type="button"
                                                                class="btn btn-info btn-sm float-left"> Save
                                                                <i class="fa fa-print" onClick="window.print()" aria-hidden="true"></i></button>
                                                        </div>
                                                        <div class="col-6">
                                                            <a type="button" href="<?php echo base_url() ?>getFeePaymentInfo"
                                                                class="btn btn-info btn-sm float-right"> Payment Info
                                                                <i class="fa fa-rupee"
                                                                    aria-hidden="true"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer ed bg-info color-white" style="padding:4px;">
                                                    <strong>Thank You</strong>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <?php } else { ?>
                                    
                                    <div class="container h-100">
                                    <div class="row h-100 justify-content-center align-items-center">
                                        <form class="col-12">
                                            <div class="card text-center">
                                                <div class="card-header bg-info">
                                                    <strong class="text-white" style="font-size: 19px;">Payment Summary
                                                    </strong>
                                                </div>
                                                <div class="card-body" style="padding:5px;">
                                                <img width="100" src="<?php echo base_url() ?>assets/images/payment_fail.png" alt="Payment Success">
                                                    <h6 class="card-title text-red"> Supplementary  Exam Payment Failed!</h6>
                                                    <table class="table table-hover">
                                                        <thead>
                                                         
                                                            <tr>
                                                                <th class="text-left" scope="col">Order No</th>
                                                                <th class="text-left" scope="col">
                                                                    <?php echo $response->getOrderId(); ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-left" scope="col">Date</th>
                                                                <th class="text-left" scope="col">
                                                                    <?php echo date('d-m-Y'); ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-left" scope="col">Transaction Amt</th>
                                                                <th class="text-left" scope="col">
                                                                    <?php echo $response->getTrnAmt()/100; ?></th>
                                                            </tr>
                                                           
                                                        </thead>

                                                    </table>

                                                    
                                                    <div class="row ">
                                                       
                                                        <div class="col-12">
                                                            <a type="button" href="<?php echo base_url() ?>dashboard"
                                                                class="btn btn-success btn-sm btn-block text-center"> Try Again
                                                                <i class="fa fa-question-circle"
                                                                    aria-hidden="true"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer text-muted bg-info" style="padding:1px;">
                                                    <h5><b> Try Again</b></h5>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                               <?php } ?>
                                <!-- if payment is success -->






                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>