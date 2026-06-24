<style>
.select2-container .select2-selection--single {
    height: 38px !important;
    width: 360px !important;
}


.form-control {
    border: 1px solid #000000 !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow b {
    margin-top: 3px !important;
    color: black !important;

}

@media screen and (max-width: 480px) {
    .select2-container--default .select2-selection--single .select2-selection__arrow {

        margin-right: 20px !important;
    }

    .select2-container .select2-selection--single {
        width: 270px !important;
    }
}
</style>
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
                            <div class="col-lg-5 col-6 col-md-4 col-sm-4 box-tools">
                                <span class="page-title">
                                 <i class="fas fa-sign-in-alt"></i> Canteen Stock In
                                </span>
                            </div>
                            <div class="col-lg-3 col-6 col-md-4 col-sm-4">
                                <b class="text-dark" style="font-size: 20px;">Total Stock: <?php echo $totalStockCount; ?></b>
                            </div>
                            <div class="col-lg-4 col-12 col-md-4 col-sm-4">

                                <a onclick="window.history.back();"
                                    class="btn btn_back mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                            
                                <div class="dropdown mobile-btn float-right">
                                <button type="button" class="btn btn-primary dropdown-toggle border_right_radius"
                                    data-toggle="dropdown">
                                    Action
                                </button>
                                <div class="dropdown-menu p-0">
                                     <a class="dropdown-item" onclick="clearFields();"   type="reset" href="#" data-toggle="modal" id="btn_add"
                                    data-target="#myModal"><i class="fa fa-plus"></i> Add New</a>
                                </div>
                              </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2 table-responsive">
                        <table class="display table table-bordered table-striped table-hover w-100">
                        <form action="<?php echo base_url(); ?>viewCanteenStockIn" method="POST" id="byFilterMethod">
                                <tr class="filter_row" class="text-center">
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $in_date; ?>" name="in_date" id="in_date" class="form-control input-sm datepicker" placeholder="Search In Date" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                             <select class="form-control input-sm" id="item_code" name="item_code"
                                            autocomplete="off">
                                            <?php if($item_code != ""){ ?>
                                            <option value="<?php echo $item_code; ?>" selected><b>Sorted:
                                                    <?php echo $item_code; ?></b></option>

                                            <?php } ?>
                                            <option value="">By Item Code</option>
                                            <?php if(!empty($stockNameInfo)){ 
                                            foreach($stockNameInfo as $stock){ ?>
                                            <option value="<?php echo $stock->item_code; ?>">
                                                <?php echo $stock->item_code; ?></option>
                                            <?php } } ?>

                                        </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                             <select class="form-control input-sm" id="stock_name" name="stock_name"
                                            autocomplete="off">
                                            <?php if($stock_name != ""){ ?>
                                            <option value="<?php echo $stock_name; ?>" selected><b>Sorted:
                                                    <?php echo $stock_name; ?></b></option>

                                            <?php } ?>
                                            <option value="">By Stock Name</option>
                                            <?php if(!empty($stockNameInfo)){ 
                                            foreach($stockNameInfo as $stock){ ?>
                                            <option value="<?php echo $stock->stock_name; ?>">
                                                <?php echo $stock->stock_name; ?></option>
                                            <?php } } ?>

                                        </select>
                                        </div>
                                    </td>
                                     <td>
                                        <div class="form-group mb-0">
                                             <select class="form-control input-sm" id="stock_type" name="stock_type"
                                            autocomplete="off">
                                            <?php if($stock_type != ""){ ?>
                                            <option value="<?php echo $stock_type; ?>" selected><b>Sorted:
                                                    <?php echo $stock_type; ?></b></option>

                                            <?php } ?>
                                            <option value="">By Stock Type</option>
                                            <?php if(!empty($stockTypeInfo)){ 
                                            foreach($stockTypeInfo as $stock){ ?>
                                            <option value="<?php echo $stock->stock_type; ?>">
                                                <?php echo $stock->stock_type; ?></option>
                                            <?php } } ?>

                                        </select>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group mb-0">
                                             <select class="form-control input-sm" id="stock_department" name="stock_department"
                                            autocomplete="off">
                                            <?php if($stock_department != ""){ ?>
                                            <option value="<?php echo $stock_department; ?>" selected><b>Sorted:
                                                    <?php echo $stock_department; ?></b></option>

                                            <?php } ?>
                                            <option value="">By Stock Department</option>
                                            <?php if(!empty($stockDepartmentInfo)){ 
                                            foreach($stockDepartmentInfo as $stock){ ?>
                                            <option value="<?php echo $stock->stock_department; ?>">
                                                <?php echo $stock->stock_department; ?></option>
                                            <?php } } ?>

                                        </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $expiry_date; ?>" name="expiry_date" id="expiry_date" class="form-control input-sm datepicker" placeholder="Search Expiry Date" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $quantity; ?>" name="quantity" id="quantity" class="form-control input-sm" placeholder="By Quantity" autocomplete="off">
                                        </div>
                                    </td>

                                    </td>
                                     <td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $rate; ?>" name="rate" id="rate" class="form-control input-sm" placeholder="By Price" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                        <button type="submit"class="btn btn-success btn-block mobile-width"><i class="fa fa-filter"></i> Filter</button>
                                    </td>
                                </tr>
                            </form>
                            <thead>
                                <tr class="table_row_background text-center">
                                    <th>In Date</th>
                                    <th>Item Code</th>
                                    <th>Stock Name</th>
                                    <th>Stock Type</th>
                                    <th>Stock Department</th>
                                    <th>Expiry Date</th>
                                    <th>Quantity</th>
                                    <th>Remaining Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($stockInInfo)) {
                                    $i = 0;
                                    foreach($stockInInfo as $stockIn) { ?> 
                                    <tr data-toggle="collapse" data-target="#demo_<?php echo $i; ?>" class="accordion-toggle">
                                        <th class="text-center"><?php echo date('d-m-Y',strtotime($stockIn->in_date)); ?></th>
                                         <th class="text-center"><?php echo $stockIn->item_code; ?></th>
                                        <th><?php echo $stockIn->stock_name; ?></th>
                                        <th><?php echo $stockIn->stock_type; ?></th>
                                        <th><?php echo $stockIn->stock_department; ?></th>
                                        <th class="text-center"><?php if($stockIn->expiry_date != '1970-01-01'){ echo date('d-m-Y',strtotime($stockIn->expiry_date)); }?></th>
                                         <th class="text-center"><?php echo $stockIn->quantity; ?></th>
                                        <th class="text-center"><?php echo $sumOfQuantity[$stockIn->row_id]; ?></th>
                                        <th class="text-center"><?php echo $stockIn->rate; ?></th>
                                        <th class="text-center"><?php echo (($stockIn->quantity)*($stockIn->rate)); ?></th>
                                        <th class="text-center">
                                            <a href="#" class="btn btn-xs btn-success" title="<b>Comments:</b>" data-toggle="popover" data-placement="left"  data-trigger="focus" data-content="<b><?php echo $stockIn->comments; ?></b>"><i class="fa fa-info"></i></a>

                                            <a class="btn btn-xs btn-info" data-toggle="collapse" data-target="#demo_<?php echo $i; ?>"
                                            href="#" title="View "><i class="fa fa-plus"></i></a>
                                        </th>
                                    </tr>
                                    <tr class="row_collapse table-primary" data-parent="#myGroup">
                                       <td class="hiddenRow" colspan="11">
                                        <div class="accordian-body collapse p-2 stock_content_collapse" id="demo_<?php echo $i; ?>">
                                            <form role="form" id="addCanteenStockOut" action="<?php echo base_url() ?>addCanteenStockOut"
                                            method="post" role="form">
                                            <input type="hidden" name="row_id" id="row_id" value="<?php echo $stockIn->row_id; ?>"/>
                                            <input type="hidden" name="quantity" id="row_id" value="<?php echo $stockIn->quantity; ?>"/>
                                            <div class="row"> 
                                                <div class="col-lg-6 col-6 col-sm-6">
                                                    <div class="form-group text-left">
                                                        <label for="out_date">Out Date</label>
                                                        <input type="text" class="form-control datepicker" id="out_date" name="out_date"
                                                            placeholder="Enter Out Date" autocomplete="off" required>
                                                    </div>
                                                </div>
                                               
                                                <div class="col-lg-6 col-6 col-sm-6">
                                                    <div class="form-group text-left">
                                                      <label for="quantity">Quantity</label>
                                                        <input type="text" class="form-control input-number-one" id="quantityVal" name="new_quantity" min="1" max="<?php echo $sumOfQuantity[$stockIn->row_id]; ?>"
                                                            placeholder="Enter Quantity" onkeypress="return isNumberKey(event)" autocomplete="off" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-12 col-sm-6">
                                                    <div class="form-group">
                                                    <label for="exampleInputEmail1">Sales Price</label>
                                                    <input type="text" class="form-control required" name="sales_price" id="sales_price" placeholder="Price" onkeypress="return isNumberKey(event)" autocomplete="off"/>
                                                </div>
                                                </div>
                                                <div class="col-lg-12 col-12 col-sm-12">
                                                    <div class="form-group text-left">
                                                        <label for="comments">Comments</label>
                                                    <textarea class="form-control required"
                                                        name="comments" id="comments" rows="4"
                                                        placeholder="Comments" autocomplete="off"></textarea>
                                                    </div>
                                                    <input style="float:right;" type="submit" class="btn btn-primary" value="SELL" />
                                                </div>
                                                
                                              </form>
                                           
                                           <div class="row">
                                             
                                            <div class="col-lg-6 col-md-6 col-2 col-sm-6 mb-1">
                                             
                                                <a class="btn btn-md btn-info" href="<?php echo base_url().'editCanteenStockIn/'.$stockIn->row_id; ?>" title="Edit"><i
                                                class="fas fa-pencil-alt"></i> <span class="text-white">EDIT</span></a>
                                            </div>
                                             
                                            <div class="col-lg-6 col-md-6 col-2 col-sm-6 mb-1">
                                               
                                               <a class="btn btn-md btn-danger deleteCanteenStockIn" href="#"
                                            data-row_id="<?php echo $stockIn->row_id; ?>" title="Delete"><i
                                                class="fa fa-trash"></i> <span class="text-white">DELETE </span></a>
                                            </div>
                                         </div>
                                         </div>
                                       </td> 
                                    </tr>
                                 <?php $i++; } } else {  ?>
                                        <tr>
                                            <td colspan="11" class="text-center">Stock In not found</td>
                                        </tr>
                                    <?php } ?>
                            </tbody>
                        </table>
                        <div class="float-right">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <div class="modal" id="myModal">
        <div class="modal-dialog modal-lg mx-auto">
            <div class="modal-content">
        <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Add Stock In Details</h6>
                <button type="button" class="close"  data-dismiss="modal">&times;</button>
            </div>
                <!-- Modal body -->
            <div class="modal-body"   style="padding: 10px;">
              <form role="form" id="addStockIn" action="<?php echo base_url() ?>addCanteenStockIn" method="post" role="form">
                    <div class="row">

                       <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">In Date<span class="text-danger required_star">*</span></label>
                                <input type="text" class="form-control required inDate "
                                id="in_date"  name="in_date"
                                placeholder="In Date" autocomplete="off" required/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Expiry Date</label>
                                <input type="text" class="form-control required expiryDate "
                                id="expiry_date"  name="expiry_date"
                                placeholder="Expiry Date" autocomplete="off"/>
                            </div>
                        </div>
                     </div>
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Stock Name<span class="text-danger required_star">*</span></label>
                                <select id="stock_name_id" name="stock_name_id" class="form-control required" autocomplete="off" required>
                                    <option value="">By Item Code</option>
                                    <?php if(!empty($stockNameInfo)){
                                        foreach($stockNameInfo as $record){ ?>
                                    <option value="<?php echo $record->row_id; ?>"><?php echo $record->item_code.' - '.$record->stock_name.' - '.$record->stock_type; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Stock Department<span class="text-danger required_star">*</span></label>
                                <select id="stock_department_id" name="stock_department_id" class="form-control required" autocomplete="off" required>
                                    <option value="">Select Stock Department</option>
                                    <?php if(!empty($stockDepartmentInfo)){
                                        foreach($stockDepartmentInfo as $record){ ?>
                                    <option value="<?php echo $record->row_id; ?>"><?php echo $record->stock_department; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        
                       <div class="col-lg-6 col-12">
                           <div class="form-group">
                                <label for="exampleInputEmail1">Quantity<span class="text-danger required_star">*</span></label>
                                <input type="text" class="form-control required quantity digits" name="quantity" min="1" max="999" id="quantity" placeholder="Quantity" onkeypress="return isNumberKey(event)" autocomplete="off" required/>
                            </div>
                        </div> 
                     
                         <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Price<span class="text-danger required_star">*</span></label>
                                <input type="text" class="form-control required" name="price" id="price" placeholder="Price" onkeypress="return isNumberKey(event)" autocomplete="off" required/>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Comments</label>
                                <textarea name="comments" class="form-control" id="exampleFormControlTextarea1" rows="3"
                                    placeholder="Any Comments"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12"> 
                                <button type="button" class="btn btn-danger"  data-dismiss="modal" >Close</button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

</div>




<script src="<?php echo base_url(); ?>assets/js/stock.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "viewCanteenStockIn/" + value);
        jQuery("#byFilterMethod").submit();
    });

    jQuery('.datepicker,.inDate,.expiryDate').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });

$('[data-toggle="popover"]').popover( { "container":"body", "trigger":"focus", "html":true });
    $('[data-toggle="popover"]').mouseenter(function(){
        $(this).trigger('focus');
    });

    //checkbox select
    $('#selectAll').click(function() {
        if ($('#selectAll').is(':checked')) {
            $('.singleSelect').prop('checked', true);
        } else {
            $('.singleSelect').prop('checked', false);
        }
    });


 $(".input-number-one").keyup(function(ee){
        try{
            let curVal = parseFloat($(this).val());
            let minVal = parseFloat($(this).attr('min'));
            let maxVal = parseFloat($(this).attr('max'));
            if(isNaN(curVal)){
                if(ee.keyCode == 69){
                    $(this).val(minVal);
                }
            }else{
                if(curVal < minVal){
                    alert('Sorry, the minimum value was reached');
                    $(this).val(minVal);
                }else if(curVal > maxVal){
                    alert('Sorry, the maximum value was reached. Available quantity:'+maxVal);
                    $(this).val(maxVal);
                }
            }
        }catch(err){
            $(this).val(minVal);
        }
    });


    $(".quantity").keyup(function(ee){
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


   

   
});
 function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;
    return true;
}

</script>