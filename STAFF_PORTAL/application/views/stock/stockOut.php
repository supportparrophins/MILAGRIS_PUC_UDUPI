
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
                            <div class="col-lg-5 col-5 col-md-4 col-sm-4 box-tools">
                                <span class="page-title">
                                <i class="fas fa-sign-out-alt"></i> Stock Out
                                </span>
                            </div>
                            <div class="col-lg-3 col-5 col-md-4 col-sm-4">
                                <b class="text-dark" style="font-size: 20px;">Total Stock: <?php echo $totalStockCount; ?></b>
                            </div>
                            <div class="col-lg-4 col-2 col-md-4 col-sm-4">

                                <a onclick="window.history.back();"
                                    class="btn btn_back mobile-btn float-right text-white" style="background-color:brown;"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
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
                        <form action="<?php echo base_url(); ?>viewStockOutListing" method="POST" id="byFilterMethod">
                                <tr class="filter_row" class="text-center">
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $out_date; ?>" name="out_date" id="out_date" class="form-control input-sm dateSearch" placeholder="Search Stock Out Date" autocomplete="off">
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
                                             <select class="form-control input-sm" id="stock_scale" name="stock_scale"
                                            autocomplete="off">
                                            <?php if($stock_scale != ""){ ?>
                                            <option value="<?php echo $stock_scale; ?>" selected><b>Sorted:
                                                    <?php echo $stock_scale; ?></b></option>

                                            <?php } ?>
                                            <option value="">By Stock Type</option>
                                            <?php if(!empty($stockScaleInfo)){ 
                                            foreach($stockScaleInfo as $stock){ ?>
                                            <option value="<?php echo $stock->stock_scale; ?>">
                                                <?php echo $stock->stock_scale; ?></option>
                                            <?php } } ?>

                                        </select>
                                        </div>
                                    </td>
                                    <!-- <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $sale_rate; ?>" name="sale_rate" id="sale_rate" class="form-control input-sm" placeholder="By Sale Price" autocomplete="off">
                                        </div>
                                    </td> -->
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $quantity; ?>" name="quantity" id="quantity" class="form-control input-sm" placeholder="By Quantity" autocomplete="off">
                                        </div>
                                    </td>
                                    <!-- <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $sales_price; ?>" name="sales_price" id="sales_price" class="form-control input-sm" placeholder="By Price" autocomplete="off">
                                        </div>
                                    </td> -->
                                   
                                    <td>
                                        <button type="submit"class="btn btn-success btn-block mobile-width"><i class="fa fa-filter"></i> Filter</button>
                                    </td>
                            </form>
                            <thead>
                                <tr class="table_row_background text-center">
                                  
                                    <th>Out Date</th>
                                    <th>Item Code</th>
                                    <th>Stock Name</th>
                                    <th>Stock Type</th>
                                    <th>Stock Scale</th>
                                    <!-- <th>Stock In Sale Price</th> -->
                                    <th>Quantity</th>
                                    <!-- <th>Sales Price</th> -->
                                    <!-- <th>Total</th> -->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($stockOutInfo)){
                                    foreach($stockOutInfo as $stockOut){ ?>
                                    <tr>
                            
                                        <th class="text-center"><?php echo date('d-m-Y',strtotime($stockOut->out_date)); ?></th>
                                        <th class="text-center"><?php echo $stockOut->item_code; ?></th>
                                        <th><?php echo $stockOut->stock_name; ?></th>
                                        <th><?php echo $stockOut->stock_type; ?></th>
                                         <th class="text-center"><?php echo $stockOut->stock_scale; ?></th>
                                         <!-- <th class="text-center"><?php //echo $stockOut->sale_rate; ?></th> -->
                                        <th class="text-center"><?php echo $stockOut->quantity; ?></th>
                                        <!-- <th class="text-center"><?php //echo //$stockOut->sales_price; ?></th> -->
                                        <?php //echo (($stockOut->quantity)*($stockOut->sales_price)); ?>
                                        
                                        <th class="text-center" width="180">
                                            <a href="#" class="btn btn-xs btn-success" title="<b>Stock Info:</b>" data-toggle="popover" data-placement="left"  data-trigger="focus" data-content="<b>Company: <?php echo $stockOut->product_name; ?><br>Comments: <?php echo $stockOut->comments; ?></b>"><i class="fa fa-info"></i></a>
                                            <?php if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_CANTEEN){ ?>
                                             <a class="btn btn-xs btn-info" href="<?php echo base_url().'editStockOutView/'.$stockOut->row_id; ?>" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                             <?php } if( $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_CANTEEN){ ?>
 
                                             <a class="btn btn-xs btn-danger deleteStockOut" href="#" data-row_id="<?php echo $stockOut->row_id; ?>" title="Delete Stock"><i class="fa fa-trash"></i></a>
                                            <?php } ?>
                                        </th>
                                    </tr>
                                <?php } }else{  ?>
                                <tr>
                                    <th colspan="11" class="text-center">Stock Out Not Found</th>
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
</div>

<script src="<?php echo base_url(); ?>assets/js/stock.js" type="text/javascript"></script>
<script type="text/javascript">

jQuery(document).ready(function() {

    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "viewStockOutListing/" + value);
        jQuery("#byFilterMethod").submit();
    });

    jQuery('.datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        startDate: new Date(),
        format: "dd-mm-yyyy"
    });

    jQuery('.dateSearch').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"
    });

$('.btn_plus').click(function(ee){
    try{
        let maxValue = parseInt($("#quantity-input").attr('max'));
        let currValue = parseInt($("#quantity-input").val());
        if(!isNaN(maxValue) && !isNaN(currValue)){
            if(currValue < maxValue ){
                $("#quantity-input").val(currValue + 1);
            }else{
                alert('Sorry, the maximum value was reached');
            }
        }else{
            $("#quantity-input").val(0)
        }
    }catch(er){
        $("#quantity-input").val(0)
    }
});

$('.btn_minus').click(function(ee){
    try{
        let currValue = parseInt($("#quantity-input").val());
        if(!isNaN(currValue)){
            if(currValue > 0){
                $("#quantity-input").val(currValue - 1);
            }else{
                alert('Sorry, the minimum value was reached');
            }
        }else{
            $("#quantity-input").val(0)
        }
    }catch(er){
        $("#quantity-input").val(0)
    }
});

$(".input-number").keypress(function(ee){
    ee.preventDefault();
    let prevVal = $(this).val();
    if(event.charCode >= 48 && event.charCode <= 57){
        try{
            let numstr = $(this).val() + ee.key;
            let currValue = parseInt(numstr);
            let maxValue = parseInt($(this).attr('max'));
            if(!isNaN(maxValue) && !isNaN(currValue)){
                if(currValue <= maxValue ){
                    $("#quantity-input").val(currValue);
                }else{
                    alert('Sorry, the maximum value was reached, Available quantity:'+maxValue);
                }
            }else{
                $(this).val(prevVal)
            }
        }catch(err){
            $(this).val(prevVal)
        }
    }
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



 });  

 
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;
    return true;
}

//popover for info
// $(document).ready(function(){
  
//     $('[data-toggle="popover"]').popover({"html":true});
// });

</script>