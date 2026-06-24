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
                                <i class="fas fa-sign-out-alt"></i> Usage
                                </span>
                            </div>
                            <div class="col-lg-3 col-6 col-md-4 col-sm-4">
                                <b class="text-dark" style="font-size: 20px;">Total Usage:
                                    <?php echo $totalSalesCount; ?></b>
                            </div>
                            <div class="col-lg-4 col-12 col-md-4 col-sm-4">

                                <a onclick="window.history.back();"
                                    class="btn btn_back mobile-btn float-right text-white border_left_radius" style="background-color:brown;"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                <?php if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_CANTEEN){ ?>

                                <a class="btn btn-primary mobile-btn float-right border_right_radius"
                                    onclick="clearFields();" type="reset" href="#" data-toggle="modal" id="btn_add"
                                    data-target="#myModal"><i class="fa fa-plus"></i>
                                    Add New</a>
                                <?php } ?>

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
                            <form action="<?php echo base_url(); ?>viewStockSales" method="POST" id="byFilterMethod">
                                <tr class="filter_row" class="text-center">
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $in_date; ?>" name="date_filter"
                                                id="in_date" class="form-control input-sm datepicker"
                                                placeholder="Search In Date" autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $quantity; ?>" name="student_id" id=""
                                                class="form-control input-sm" placeholder="By Student Id"
                                                autocomplete="off">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $quantity; ?>" name="student_name"
                                                id="" class="form-control input-sm" placeholder="By Student Name"
                                                autocomplete="off">
                                        </div>
                                    </td>
                                    <!-- <td>
                                        <div class="form-group mb-0">
                                            <input type="text" value="<?php echo $quantity; ?>" name="total_amount"
                                                id="" class="form-control input-sm" placeholder="By Total Amount"
                                                autocomplete="off">
                                        </div>
                                    </td> -->

                                    <td>
                                        <button type="submit" class="btn btn-success btn-block mobile-width"><i
                                                class="fa fa-filter"></i> Filter</button>
                                    </td>
                                </tr>
                            </form>
                            <thead>
                                <tr class="table_row_background text-center">
                                    <th width="100">Date</th>
                                    <th>Student Id</th>
                                    <th>Student Name</th>
                                    <!-- <th>Total Amount</th> -->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($salesInfo)) {
                                    $i = 0;
                                    foreach($salesInfo as $sales) { ?>
                                <tr data-toggle="collapse" data-target="#demo_<?php echo $i; ?>"
                                    class="accordion-toggle">
                                    <th class="text-center"><?php echo date('d-m-Y',strtotime($sales->date)); ?></th>
                                    <th class="text-center"><?php echo $sales->student_id; ?></th>
                                    <th class="text-center"><?php echo $sales->student_name; ?></th>
                                    <!-- <th class="text-center"><?php //echo $sales->total_amount; ?></th> -->



                                </tr>
                                <?php $i++; }} ?>

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
                    <h6 class="modal-title">Add Usage Details</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body" style="padding: 10px;">
                    <form role="form" id="addSalesToDB" action="<?php echo base_url() ?>addSalesToDB" method="post"
                        role="form">
                        <div class="row">

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date<span
                                            class="text-danger required_star">*</span></label>
                                    <input type="text" value="<?php echo Date('d-m-Y'); ?>" class="form-control required inDate " id="in_date" name="in_date"
                                        placeholder="Date" autocomplete="off" required />
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="student_id">Student Id<span
                                        class="text-danger required_star">*</span></label>
                                <select class="form-control selectpicker" id="student_id" name="student_id"
                                    data-live-search="true" required>
                                    <option value="">Select Student Id</option>
                                    <?php if(!empty($studentInfo)){
                                        foreach($studentInfo as $std){ ?>
                                    <option value="<?php echo $std->student_id; ?>">
                                        <?php echo $std->student_id.'- '.strtoupper($std->student_name); ?></option>
                                    <?php } } ?>
                                </select>
                            </div>

                          
                            <!-- <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Stock Name<span
                                            class="text-danger required_star">*</span></label>
                                    <select id="stock_name_id" name="stock_name_id"
                                        class="form-control required selectpicker" data-live-search="true"
                                        autocomplete="off" required>
                                        <option value="">Select Stock Name</option>
                                        <?php if(!empty($stockNameInfo)){
                                        foreach($stockNameInfo as $record){ ?>
                                        <option value="<?php echo $record->stock_id; ?>">
                                            <?php echo $record->item_code.' - '.$record->stock_name.' - '.$record->stock_type.' - '.$record->product_name.' - '.$record->stock_scale; ?>
                                        </option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div> -->
                        </div>
                        <!-- <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Expiry Date</label>
                                    <input type="text" class="form-control required expiryDate " id="expiry_date"
                                        name="expiry_date" placeholder="Expiry Date" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Purchase Price<span
                                            class="text-danger required_star">*</span></label>
                                    <input type="text" class="form-control required" name="price" id="price"
                                        placeholder="Purchase Price" onkeypress="return isNumberKey(event)"
                                        autocomplete="off" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-12">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Sale Price<span
                                            class="text-danger required_star">*</span></label>
                                    <input type="text" class="form-control required" name="sale_rate" id="sale_rate"
                                        placeholder="Sale Price" onkeypress="return isNumberKey(event)"
                                        autocomplete="off" required />
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <label for="exampleInputEmail1">Quantity</label>
                                <div class="input-group plus-minus-input">
                                    <span class="input-group-button">
                                        <button type="button" class="button btn_minus btn-danger btn-default btn-number"
                                            data-quantity="minus" data-field="quantity" data-type="minus">
                                            <span class="fa fa-minus"></span>
                                        </button>
                                    </span>
                                    <input class="input-group-field form-control input-number" type="number"
                                        name="quantity" value="1" min="1" max="999" required>
                                    <span class="input-group-button">
                                        <button type="button" class="button  btn-default btn_plus btn-success"
                                            data-quantity="plus" data-field="quantity">
                                            <span class="fa fa-plus"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>



                        </div> -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Remarks</label>
                                    <textarea name="comments" class="form-control" id="exampleFormControlTextarea1"
                                        rows="3" placeholder="Any Remarks"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="m-0">
                            <div class="table-responsive row1">
                                <table class="table table-striped table-borderless border-0 border-b-2 brc-default-l1">
                                    <thead class="bg-none bgc-default-tp1" style="background: #ffb11f94;">
                                        <tr class="text-black">
                                            <th width="70">#</th>
                                            <th width="420">Item</th>
                                             <th width="400">Rate</th> 
                                            <th width="400">Qty</th>
                                            <th width="140">Amount</th> 
                                        </tr>
                                    </thead>

                                    <tbody class="text-95 text-secondary-d3">

                                        <tr class="inv_row">
                                            <td><input id="slno" type="text" name="slno[]" class="form-control"
                                                    placeholder="1" autocomplete="off" disabled></td>

                                                    <td class="text-secondary-d2"><input type="text" name="items[]" id="items"
                                                        class="form-control itemrate items" placeholder="Rate"
                                                         autocomplete="off"
                                                        required></td> 
                                            <td> <select id="items" name="items[]" class="form-control required "
                                                    autocomplete="off" required>
                                                    <option value="">Select Stock Name</option>
                                                    <?php if(!empty($stockNameInfo)){
                                                        foreach($stockNameInfo as $record){ ?>
                                                    <option value="<?php echo $record->stock_id; ?>">
                                                        <?php echo $record->item_code.' - '.$record->stock_name.' - '.$record->stock_type.' - '.$record->product_name.' - '.$record->stock_scale; ?>
                                                    </option>
                                                    <?php } } ?>
                                                </select> 
                                            </td> 
                                             <td class="text-secondary-d2"><input type="text" name="rate[]" id="rate_j"
                                                        class="form-control itemrate" placeholder="Rate"
                                                        onkeypress="return isNumberKey(event)" autocomplete="off"
                                                        required></td> 
                                            <td class="text-secondary-d2"><input type="text" name="qty[]"
                                                    id="itemquantity" class="form-control itemquantity"
                                                    placeholder="Qty" value="" onkeypress="return isNumberKey(event)"
                                                    autocomplete="off" required></td>
                                             <td class="text-secondary-d2"><input type="text" name="amount[]"
                                                        id="amount" class="form-control amount" placeholder="Amount"
                                                        autocomplete="off" readonly required></td> 
                                        </tr>
                                        <p id='newrow'></p>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row ">
                                <div class="col-12 text-right">
                                    <input type='button' class="add align-right btn" id='add' value='+' />
                                    <input type='button' class="sub align-right btn" id='sub' value='-' />
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-12 text-right">
                                    Total Amount:&nbsp;<i class="fa fa-rupee-sign"></i>&nbsp;<input type="text"
                                        name="totalAmount" class="text-150 border-0 w-25 totalAmt" placeholder="0"
                                        autocomplete="off" required readonly>
                                </div>
                            </div>
                        </div> -->

                        <div class="form-row">
                            <div class="col-10">
                                <label for="role">Add Usage Info</label>
                            </div>
                          
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4 col-lg-6">
                                <select id="items"  class="form-control required selectpicker" autocomplete="off"
                                data-live-search="true"  required>
                                    <option value="">Select Stock Name</option>
                                    <?php if(!empty($stockNameInfo)){
                                                        foreach($stockNameInfo as $record){ ?>
                                    <option value="<?php echo $record->row_id.'/'.$record->stock_name; ?>">
                                        <?php echo $record->item_code.' - '.$record->stock_name.' - '.$record->stock_type.' - '.$record->product_name.' - '.$record->stock_scale; ?>
                                    </option>
                                    <?php } } ?>
                                </select>
                            </div>
                            <!-- <div class="form-group col-md-2">
                                <input type="text"  id="rate_j" class="form-control itemrate"
                                    placeholder="Rate" onkeypress="return isNumberKey(event)" autocomplete="off"
                                    required>
                            </div> -->

                            <div class="form-group col-md-2 col-lg-4">
                                <input type="number"  id="itemquantity" class="form-control itemquantity"
                                    placeholder="Qty" value="1" onkeypress="return isNumberKey(event)" autocomplete="off"
                                    required>
                            </div>

                            <!-- <div class="form-group col-md-2">
                                <input type="text"  id="amount" class="form-control amount"
                                    placeholder="Amount" autocomplete="off" readonly required>
                            </div> -->
                            <div class="col-2 text-right mb-1 col-lg-2">
                                <input type="button" class="btn btn-primary" id="btnClone" value="+Add Item" />
                            </div>
                        </div>
                        <div class="form-row">
                            <table class="col-12 ml-2 mr-4 table-bordered text-center" id="addMember">
                                <tr>
                                    <th width="250">Name</th>
                                    <!-- <th>Rate</th> -->
                                    <th>Quantity</th>
                                    <!-- <th>Amount</th> -->
                                    <th>Action</th>
                                </tr>
                            </table>
                        </div>

                        <!-- <div class="row mt-1">
                                <div class="col-12 text-right">
                                    Total Amount:&nbsp;<i class="fa fa-rupee-sign"></i>&nbsp;<input type="text"
                                        name="totalAmount" id="totalAmount" class="text-150 border-0 w-25 totalAmt" placeholder="0"
                                        autocomplete="off" required readonly>
                                </div>
                            </div> -->



                        <!-- Modal footer -->
                        <div class="modal-footer" style="padding:5px;">
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
<script>
$(document).on("click", ".add", function() {
    var n = $('.inv_row').length + 1;
    console.log(n);
    var temp = $('.inv_row:first').clone()
    temp.find('input').val('');
    $('input:first').attr('value', n)
    $('.inv_row:last').after(temp);
});

  i=0;
$(function() {
    $("#btnClone").bind("click", function() {
        var ddl1 = $("#items option:selected").val();
        if(ddl1==''){
        alert('please select Stock');
        }else{
        var qty = $("#itemquantity").val();
        var t = 0;
    $('.amount').each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $('.totalAmt').val(t);

        var arr = ddl1.split('/');
        i++;
        $('#addMember').append('<tr id="row'+i+'"><td><input type="hidden" class="" name="items[]" value="'+arr[0]+'"/>'+arr[1]+'</td><td><input type="hidden" class="itemquantity" name="qty[]" value="'+qty+'"/>'+qty+'</td><td><button type="button" name="remove" id="'+i+'" class="btn-sm btn-danger btn_remove">X</button></td></tr>');

}
    });
});

$(document).on('click','.btn_remove',function(){
 
    var btn_id = $(this).attr('id');
    $('#row'+btn_id).remove();
    
});

$(document).on("click", ".sub", function() {
    var n = $('.inv_row').length;
    if (n > 1) {
        $('.inv_row:last').remove();
    }
});

// $('#itemquantity').change(function() {
//     calculateAmount(); 
// });

// $('form').delegate('.itemquantity,.itemrate', 'keyup', function() {
//     calculateAmount();
//     // totalAmount();
// });



function calculateAmount() {
    $(".amount").each(function() {
        var tr = $(this).parent().parent();

        var quantity = tr.find('.itemquantity').val();
        var rate = tr.find('.itemrate').val();
        if (quantity != "" && rate != "") {
            var total = quantity * rate;
        }
        tr.find('.amount').val(total);
    });
}

function totalAmount() {
    var t = 0;
    $('.amount').each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $('.totalAmt').val(t);
}

function totalAmounttest() {
    var t = 0;
    $('.amtest').each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $('.totalAmt').val(t);
}
</script>
<script type="text/javascript">
jQuery(document).ready(function() {

    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "viewStockInListing/" + value);
        jQuery("#byFilterMethod").submit();
    });

    jQuery('.datepicker,.inDate,.expiryDate').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });

    $('[data-toggle="popover"]').popover({
        "container": "body",
        "trigger": "focus",
        "html": true
    });
    $('[data-toggle="popover"]').mouseenter(function() {
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

    $('#num').html(parseInt($('#num').html()) + 1);

    $('[data-quantity="plus"]').click(function(e) {
        try {
            let inputTag = $(this).parent().parent().find('input.input-number');
            let currValue = parseInt($(inputTag).val());
            $(inputTag).val(currValue + 1);
        } catch (err) {
            $(inputTag).val(0);
        }
    });
    // This button will decrement the value till 0
    $('[data-quantity="minus"]').click(function(e) {
        try {
            let inputTag = $(this).parent().parent().find('input.input-number');
            let currValue = parseInt($(inputTag).val());
            if (currValue > 1) {
                $(inputTag).val(currValue - 1);
            }
        } catch (err) {
            $(inputTag).val(0);
        }
    });

    $('[data-quantity="plus_one"]').click(function(e) {
        try {
            let inputTag = $(this).parent().parent().find('input.input-number-one');
            let maxValue = parseInt($(inputTag).attr("max"));
            let currValue = parseInt($(inputTag).val());
            if (!isNaN(maxValue) && !isNaN(currValue)) {
                if (currValue < maxValue) {
                    $(inputTag).val(currValue + 1);
                } else {
                    alert('Sorry, the maximum value was reached. Available quantity:' + maxValue);
                }
            } else {
                $(inputTag).val(0)
            }
        } catch (err) {
            $(inputTag).val(0)
        }
    });

    $(".input-number-one").keypress(function(ee) {
        ee.preventDefault();
        let prevVal = $(this).val();
        if (event.charCode >= 48 && event.charCode <= 57) {
            try {
                let numstr = $(this).val() + ee.key;
                let currValue = parseInt(numstr);
                let maxValue = parseInt($(this).attr('max'));
                if (!isNaN(maxValue) && !isNaN(currValue)) {
                    if (currValue <= maxValue) {
                        $(this).val(currValue);
                    } else {
                        alert('Sorry, the maximum value was reached. Available quantity:' + maxValue);
                    }
                } else {
                    $(this).val(prevVal)
                }
            } catch (err) {
                $(this).val(0)
            }
        }
    });


    $(".input-number").keyup(function(ee) {
        try {
            let curVal = parseFloat($(this).val());
            let minVal = parseFloat($(this).attr('min'));
            let maxVal = parseFloat($(this).attr('max'));
            if (!isNaN(curVal)) {
                if (curVal < minVal) {
                    alert('Sorry, the minimum value was reached');
                    $(this).val(minVal);
                } else if (curVal > maxVal) {
                    alert('Sorry, the maximum value was reached');
                    $(this).val(maxVal);
                }
            } else if (ee.keyCode == 69) {
                $(this).val('');
            }
        } catch (err) {
            $(this).val(1);
        }
    });

    $('[data-quantity="minus_one"]').click(function(e) {
        try {
            let inputTag = $(this).parent().parent().find('input.input-number-one');
            let currValue = parseInt($(inputTag).val());
            if (!isNaN(currValue)) {
                if (currValue > 0) {
                    $(inputTag).val(currValue - 1);
                }
            } else {
                $(inputTag).val(0)
            }
        } catch (err) {
            $(inputTag).val(0)
        }
    });







    // $("#items").change(function() {
    //     var stock_id = $("#items").val();
    //     var arr = stock_id.split('/');

    //     var stocks_id = arr[0];

    //     $.ajax({
    //         url: '<?php //echo base_url(); ?>/getItemAmountInfoByID',
    //         type: 'POST',
    //         dataType: "json",
    //         data: {
    //             stock_id: stocks_id
    //         },

    //         success: function(data) {
    //             //var examObject = JSON.parse(data);
    //             var examObject = JSON.stringify(data)
    //             // alert(data.result.total_amt);
    //             var amount = data.result.sale_rate;
    //             // var paidAmt = data.expenseInfo.paidAmt;
    //             // var balance = total_amt - paidAmt;
    //             $("#rate_j").val(amount);
    //             calculateAmount();
    //             // $("#walletMoney").show();

    //         }
    //     });

    // });




});

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>