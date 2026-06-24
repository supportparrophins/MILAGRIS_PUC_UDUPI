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
                            <i class="material-icons">description</i> II PUC Fee Payment Info
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

                <div class="row">
                    <div class="col profile-head">
                        <?php $pending_amt = 0; ?>
                        <table class="table">
                            <thead>
                                <tr class="table-primary">
                                    <th scope="col">Date</th>
                                    <th scope="col">Receipt No.</th>
                                    <th scope="col">Paid Amt.</th>
                                    <th scope="col">Pending Amt.</th>
                                    <th scope="col">Payment Mode</th>
                                    <th scope="col">Status</th>
                                </tr>
                          
                                <?php $pending_amt_readm = 0;
                              if($term_name == 'I PUC'){
                                    if(!empty($feeInfoNew)){ 
                                        foreach($feeInfoNew as $fee){ 
                                    $pending_amt_readm =  $fee->pending_balance; ?>
                                    <tr class="table-success">
                                    <th><?php echo date('d-m-Y',strtotime($fee->payment_date)); ?></th>
                                    <th><?php echo $fee->receipt_number; ?></th>
                                    <th><?php echo $fee->paid_amount; ?></th>
                                    <th><?php echo $fee->pending_balance; ?></th>
                                    <th><?php echo $fee->payment_type; ?></th>
                                    <th><?php echo "<b style='color:green'>SUCCESS</b>"; ?></th>
                                    </tr>
                                    <?php } } else { ?>
                                    <tr>
                                    <th class="text-center" colspan="6">II PUC Admission Fee payment info not found!
                                    </th>
                                    </tr>
                                    <tr>

                                    <?php } 
                                } ?>
                                </thead>
                           
                        </table>
                        <?php if(!empty($feePending)){
                            if($feePending->balance <= 0){ ?>
<a class="btn btn-block btn-success" 
                                        type="button"  href="<?php echo base_url(); ?>reAdmissionForIIPUC">CLICK HERE TO II PUC ADMISSION</a>
                          <?php  } else{ ?>

                            <h4 class="text-center" style="color:red">Please pay the I PUC pending fee amount</h4>
                            <a class="btn btn-block btn-danger" 
                                        type="button"  href="<?php echo base_url(); ?>getFeePaymentInfo">CLICK HERE TO PAY PENDING BALANCE</a>

                            
                        <?php  }
                        } ?>
                        
                      
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

