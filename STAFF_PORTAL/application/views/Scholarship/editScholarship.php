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
    <div class="col-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container container-fluid px-4 pt-2">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row p-0 column_padding_card">
            <div class="col-12 column_padding_card">
                <div class="card card-small p-0 card_heading_title">
                    <div class="card-body p-2 ml-2">
                        <span class="page-title">
                        <i class="material-icons">book</i> Edit Scholarship
                        </span>
                        <a  onclick="window.history.back();" href="<?php echo base_url(); ?>/scholarshipListing" class="btn btn_back float-right text-white pt-2 btn-backtrack"
                            value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if(empty($scholarshipInfo)){ ?>
    <div class="row form-employee">
        <div class="col-lg-12 col-md-12 col-12 pr-0 text-center">
        <img height="270" src="<?php echo base_url(); ?>assets/images/404.png"/>
        </div>
    </div>
    <?php } else {  ?>
    <div class="row form-employee p-0 column_padding_card">
        <div class="col-12 column_padding_card">
            <div class="card card-small c-border mb-4 p-2">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item p-2">
                        <form role="form" action="<?php echo base_url() ?>updateScholarship" method="post" role="form">
                        <input type="hidden" value="<?php echo $scholarshipInfo->row_id; ?>" name="row_id" id="row_id"/>
                        <input type="hidden" value="<?php echo $scholarshipInfo->scholarship_id; ?>" id="prev_scholarship_type" name="prev_scholarship_type">

                            <div class="row p-0 column_padding_card">
                                <div class="col column_padding_card">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="mobile">Scholarship End Date<span class="text-danger required_star">*</span></label>
                                            <input type="text" class="form-control datepicker required"
                                                id="scholarship_end_date" name="scholarship_end_date"
                                                placeholder="Scholarship End Date" value="<?php if(empty($scholarshipInfo->scholarship_end_date) || $scholarshipInfo->scholarship_end_date == '1970-01-01' || $scholarshipInfo->scholarship_end_date == '0000-00-00' || $scholarshipInfo->scholarship_end_date == '30-11--0001' ) {
                                                        echo ""; } else{
                                                        echo date('d-m-Y',strtotime($scholarshipInfo->scholarship_end_date));
                                                        } ?>"autocomplete="off" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label  for="email ">Scholarship Type<span class="text-danger required_star">*</span></label>
                                            <select class="form-control" name="scholarship_type" id="scholarship_type">
                                            <?php if(!empty($scholarshipInfo->scholarship_type)){ ?>
                                                    <option value="<?php echo $scholarshipInfo->scholarship_id; ?>" selected><b>Selected: <?php echo $scholarshipInfo->scholarship_type; ?></b></option>
                                                <?php } ?>
                                            <option value="">Search Scholarship Type</option>
                                                <?php if(!empty($scholarshipTypeInfo)){
                                                    foreach($scholarshipTypeInfo as $scholarship){ ?>
                                                        <option value="<?php echo $scholarship->row_id ?>"><?php echo $scholarship->scholarship_type?></option>
                                                <?php  } } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        
                                        <div class="form-group col-md-6">
                                            <label for="role">Society<span class="text-danger required_star">*</span></label>
                                            <select class="form-control" name="scholarship_society" id="scholarship_society">
                                            <?php if(!empty($scholarshipInfo->scholarship_society)){ ?>
                                                    <option value="<?php echo $scholarshipInfo->scholarship_society; ?>" selected><b>Selected: <?php echo $scholarshipInfo->scholarship_society; ?></b></option>
                                                <?php } ?>
                                            <option value="">Search Society</option>
                                            <option value="BJECS">BJECS</option>
                                            <option value="KJES">KJES</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="lab">Max Amount</label>
                                            <input
                                                class="form-control is-valid mobile-width" type="text" name="max_amount" onkeypress="return isNumberKey(event)"
                                                id="max_amount" value="<?php echo $scholarshipInfo->max_amount; ?>"
                                                class="form-control input-sm pull-right"
                                                placeholder="By Max Amount"
                                                autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="fname">Application Number Prefix (e.g., ABC will start as ABC0001)<span class="text-danger required_star">*</span></label>
                                            <input id="application_no_prefix" type="text" name="application_no_prefix" onkeypress="return alphaOnly(event)" readonly required value="<?php echo $scholarshipInfo->application_no_prefix; ?>"
                                                            class="form-control" placeholder="Enter Application Number Prefix"  autocomplete="off" >
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                       
                                           
                                        </div>
                                        <div class="mt-3 col-md-12">
                                            <button type="submit" class="btn btn-success float-right"> Update </button>
                                        </div>
                                </div>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <?php } ?>

</div>
<script type="text/javascript">

jQuery(document).ready(function() {
jQuery('.datepicker').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy" // Correct format for '06 Aug 2024'
    });
        
});

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>
