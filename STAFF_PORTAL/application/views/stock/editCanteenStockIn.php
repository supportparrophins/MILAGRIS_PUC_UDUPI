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
<div class="main-content-container px-3 pt-1 overall_content">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row p-0 column_padding_card">
            <div class="col-12 column_padding_card">
                <div class="card card-small p-0 card_heading_title">
                    <div class="card-body p-2 ml-2">
                        <span class="page-title">
                         <i class="fas fa-sign-in-alt"></i> Edit Canteen Stock In
                        </span>
                        <a onclick="window.history.back();" class="btn btn_back float-right text-white pt-2"
                            value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if(empty($stockInInfo)){ ?>
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
                        <form role="form" action="<?php echo base_url() ?>updateCanteenStockIn" method="post" role="form">
                        <input type="hidden" value="<?php echo $stockInInfo->row_id; ?>" name="row_id" id="row_id"/>
                            <div class="row p-0 column_padding_card">
                                <div class="col column_padding_card">
                                    <div class="form-row">
        
                                        <div class="form-group col-md-6">
                                            <label for="in_date">In Date</label>
                                            <input type="text" class="form-control required inDate "
                                                id="in_date"  name="in_date" value="<?php echo date('d-m-Y',strtotime($stockInInfo->in_date)); ?>" placeholder="In Date" required autocomplete="off"/>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="stock_name_id">Stock Name<span class="text-danger required_star">*</span></label>
                                            <select class="form-control"  id="stock_name_id" name="stock_name_id" required>
                                               <?php if(!empty($stockInInfo->stock_name_id)){ ?>
                                            <option value="<?php echo $stockInInfo->stock_name_id; ?>">Selected:
                                                <?php echo $stockInInfo->item_code.' - '.$stockInInfo->stock_name.' - '.$stockInInfo->stock_type; ?></option>
                                            <?php } ?>
                                            <option value="">Select Stock Name</option>
                                            <?php if(!empty($stockNameInfo)){
                                             foreach($stockNameInfo as $stk){ ?>
                                            <option value="<?php echo $stk->row_id; ?>"><?php echo $stk->item_code.' - '.$stk->stock_name.' - '.$stk->stock_type; ?>
                                            </option>
                                            <?php } } ?>
                                        </select>
                                    </div>
                                </div>
                                       
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                            <label for="stock_department_id">Stock Department<span class="text-danger required_star">*</span></label>
                                            <select class="form-control"  id="stock_department_id" name="stock_department_id">
                                               <?php if(!empty($stockInInfo->stock_department_id)){ ?>
                                            <option value="<?php echo $stockInInfo->stock_department_id; ?>">Selected:
                                                <?php echo $stockInInfo->stock_department; ?></option>
                                            <?php } ?>
                                             <option value="">Select Stock Department</option>
                                            <?php if(!empty($stockDepartmentInfo)){
                                             foreach($stockDepartmentInfo as $record){ ?>
                                            <option value="<?php echo $record->row_id; ?>"><?php echo $record->stock_department; ?>
                                            </option>
                                            <?php } } ?>
                                        </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="expiry_date">Expiry Date</label>
                                            <input type="text" class="form-control required inDate "
                                                id="expiry_date"  name="expiry_date" value="<?php if($stockInInfo->expiry_date != '1970-01-01'){ echo date('d-m-Y',strtotime($stockInInfo->expiry_date)); } ?>" placeholder="Expiry Date" autocomplete="off"/>
                                        </div>
                                    </div>
                               
                                     <div class="form-row">
                                         <div class="form-group col-md-6">
                                            <label  for="quantity">Quantity</label>
                                            <input type="text" class="form-control required" name="quantity" id="quantity" value="<?php echo $stockInInfo->quantity; ?>"  min="1" max="999" onkeypress="return isNumberKey(event)"placeholder="Quantity" autocomplete="off" required/>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label  for="price ">Price</label>
                                            <input type="text" class="form-control required" name="price" id="price" value="<?php echo $stockInInfo->rate; ?>" onkeypress="return isNumberKey(event)"placeholder="Price" autocomplete="off" required/>
                                        </div>
                                    </div>
                                  
                                    <div class="form-row">
                                        <label for="comments">Comments</label>
                                        <textarea placeholder="Enter Comments" type="text" class="form-control required" id="comments" name="comments" autocomplete="off" required><?php echo $stockInInfo->comments; ?></textarea>
                                     </div>
                                    <button type="submit" class="btn btn-md btn-success float-right mt-1">Update</button>
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

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;
    return true;
}



jQuery(document).ready(function() {
   
     jQuery('.inDate,.service,.permit').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",

    });

  
});

    $("#quantity").keyup(function(ee){
        try{
            let curVal = parseFloat($(this).val());
            let minVal = parseFloat($(this).attr('min'));
            let maxVal = parseFloat($(this).attr('max'));
            if(! isNaN(curVal)){
                if(curVal < minVal){
                    alert('Sorry, the minimum value was reached');
                    $(this).val(minVal);
                }else if(curVal > maxVal){
                    alert('Sorry, the maximum value was reached');
                    $(this).val(maxVal);
                }
            }else if(ee.keyCode == 69){
                $(this).val('');
            }
        }catch(err){
            $(this).val(1);
        }
    });
</script>
