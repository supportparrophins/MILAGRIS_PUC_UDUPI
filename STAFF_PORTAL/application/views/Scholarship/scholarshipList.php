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
<div class="main-content-container container-fluid px-4 pt-2">
    <div class="content-wrapper">
        <div class="row p-0">
            <div class="col  padding_left_right_null">
                <div class="card card-small  p-0 m-b-1 card_heading_title">
                    <div class="card-body p-1">
                        <div class="row">
                            <div class="col-4">
                                <span class="page-title">
                                    <i class="fa fa-users"></i> Scholarship Info
                                </span>
                            </div>
                            <div class="col-3 page-title">
                                <span class="page-sub-title page-title">Total Scholarship: <?php echo $count; ?></span>
                            </div>
                            <!-- <div class="col-3">
                            
                            </div> -->
                            <div class="col-lg-5 col-md-5 col-12">
                                <a  onclick="window.history.back();" 
                                    class="btn btn_back mobile-btn float-right text-white border_left_radius btn-backtrack"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                <a class="btn btn-primary mobile-btn float-right border_right_radius" href="" data-toggle="modal"
                                data-target="#Modal"><i class="fa fa-plus"></i>
                                    Add New</a>
                            </div>
                          
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col  padding_left_right_null">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-3 text-center table-responsive">
                        <table class=" display table table-bordered table-striped table-hover w-100">
                            <tr class="bg-deafult">
                                <form action="<?php echo base_url() ?>scholarshipListing" method="POST" id="byFilterMethod">
                                
                                    <th width="50"></th>
                                    <th width="150" style="padding: 0px;">
                                        <div class="form-group position-relative mb-0"><input
                                                class="form-control is-valid mobile-width datepicker" type="text" name="scholarship_date"
                                                id="" value="<?php echo $scholarship_date ?>"
                                                class="form-control input-sm pull-right"
                                                placeholder="By Scholarship End Date"
                                                autocomplete="off">
                                        </div>
                                    </th>
                                   
                                    <th width="150" style="padding: 0px;">
                                        <div class="form-group position-relative mb-0">
                                            <select class="form-control" name="scholarship_type" id="scholarship_type">
                                                <?php if(!empty($scholarship_type)){ ?>
                                                    <option value="<?php echo $scholarship_type; ?>" selected><b>Selected: <?php echo $scholarship_type; ?></b></option>
                                                <?php } ?>
                                                <option value="">Search Scholarship Type</option>
                                                <?php if(!empty($scholarshipTypeInfo)){
                                                    foreach($scholarshipTypeInfo as $scholarship){ ?>
                                                        <option value="<?php echo $scholarship->scholarship_type ?>"><?php echo $scholarship->scholarship_type?></option>
                                                <?php  } } ?>
                                            </select>
                                        </div>
                                    </th>
                                   
                               
                                    <th width="150" style="padding: 0px;">
                                        <div class="form-group position-relative mb-0">
                                            <select class="form-control" name="scholarship_society" id="scholarship_society">
                                                <?php if(!empty($scholarship_society)){ ?>
                                                    <option value="<?php echo $scholarship_society; ?>" selected><b>Selected: <?php echo $scholarship_society; ?></b></option>
                                                <?php } ?>
                                                <option value="">Search Society</option>
                                                <option value="BJECS">BJECS</option>
                                                <option value="KJES">KJES</option>
                                            </select>
                                        </div>
                                    </th>
                                    <th></th>
                                    <th width="150" style="padding: 0px;">
                                        <div class="form-group position-relative mb-0"><input
                                                class="form-control is-valid mobile-width" type="text" name="application_no_prefix"
                                                id="" value="<?php echo $application_no_prefix ?>" onkeypress="return alphaOnly(event)"
                                                class="form-control input-sm pull-right"
                                                placeholder="By Application No. Prefix"
                                                autocomplete="off">
                                        </div>
                                    </th>
                                     <th width="150" style="padding: 0px;">
                                        <div class="form-group position-relative mb-0"><input
                                                class="form-control is-valid mobile-width" type="text" name="max_amount"
                                                id="" value="<?php echo $max_amount ?>" onkeypress="return isNumberKey(event)"
                                                class="form-control input-sm pull-right"
                                                placeholder="By Max Amount"
                                                autocomplete="off">
                                        </div>
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th width="180" class="text-center btn-padding"><button type="submit"
                                            class="btn btn-success btn-block mobile-width"> Search</button></th>
                                </form>
                            </tr>
                            <tr class=" text-white card_heading_title ">
                                <th style="color:black;" width="50">SL No.</th>
                                <th style="color:black;" width="120">Scholarship End date</th>
                                <th style="color:black;" width="120">Scholarship Type</th>
                                <!-- <th style="color:black;" width="120">Scholarship code</th> -->
                                <th style="color:black;" width="120">Society</th>
                                <th style="color:black;" width="120">Total Student</th>
                                <th style="color:black;" width="120">Application No. Prefix</th>
                                <th style="color:black;" width="120">Max Amount</th>
                                <th style="color:black;" width="120">Sanctioned  Amount</th>
                                <th style="color:black;" width="120">Remaining  Amount</th>
                                <th style="color:black;" width="120" class="text-center">Actions</th>
                            </tr>
                            <?php
                    if(!empty($scholarshipRecords))
                    {
                        $slno = 1;
                        foreach($scholarshipRecords as $record)
                        {
                        $total_student_info = $Scholarship_model->getTotalStudentCount($record->row_id);
                        $sanctioned_amount = $Scholarship_model->getTotalStudentSanctionedAmount($record->row_id);
                       

                        if(!empty($record->max_amount)){
                            $remaining_amount = $record->max_amount - $sanctioned_amount->total_san;
                        }else{
                            $remaining_amount = '';
                        }
                    ?>
                            <tr class="text-black">
                            <!-- <form role="form" action="<?php echo base_url() ?>updateAgeluInfo" method="post" role="form"> -->

                                <td><?php echo $slno ?></td>
                                <input type="hidden" class="form-control" name="agelu_row_id" value="<?php echo $record->row_id ?>">
                                <td><?php echo date('d-m-Y',strtotime($record->scholarship_end_date)); ?></td>
                                <!-- <input type="text" class="form-control datepicker" name="agelu_date" value="<?php //echo date('Y-m-d',strtotime($record->scholarship_end_date)); ?>"> -->
                                <td><?php echo $record->scholarship_type ?></td>
                                <!-- <input type="text" class="form-control" name="agelu_amount" value="<?php //echo $record->scholarship_type ?>"> -->
                                <td><?php echo $record->scholarship_society ?></td>
                                <td><?php echo $total_student_info ?></td>
                                <td><?php echo $record->application_no_prefix ?></td>
                                <td><?php echo number_format($record->max_amount,2) ?></td>
                                <td><?php echo number_format($sanctioned_amount->total_san,2); ?></td>
                                <td><?php echo number_format($remaining_amount,2); ?></td>
                                <td class="text-center">
                                    <!-- <button type="submit" class="btn btn-sm btn-success"><b>Update</b></button> -->

                                    <a class="btn  btn-sm btn-primary"
                                        href="<?php echo base_url().'editScholarshipDetailsPageView/'.$record->row_id; ?>"
                                        title="View"><i class="fas fa-plus"></i> <b>Add Student</b></a>
                                        <a class="btn btn-xs btn-info" target="_blank"
                                                href="<?php echo base_url(); ?>editScholarship/<?php echo $record->row_id; ?>" title="Edit Scholarship"><i
                                                    class="fas fa-pencil-alt"></i></a>
                                    <a class="btn btn-xs btn-danger deleteScholarshipInfo" href="#"
                                        data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i
                                            class="fas fa-trash"></i></a>
                                </td>
                            <!-- </form> -->

                            </tr>
                            <?php
                            $slno++;
                        }
                    } else { ?>
                            <tr>
                                <td class="text-center " colspan="10">
                                    <div style="text-align: center;">
                                        <!-- <img style="max-width: 20%; height: 10%;" src="<?php echo base_url(); ?>assets/images/empty.png" alt="No Data"> -->
                                        <p style="font-weight:bold; margin-bottom:0px;">No data available</p>
                                    </div>
                                </td>
                            </tr>
                            <?php }
                      ?>
                        </table>
                        <div>
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div id="Modal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg ">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header modal-call-report p-2">
                        <div class=" col-md-10 col-10">
                            <span class="text-black mobile-title" style="font-size : 20px">Add Scholarship Details </span>
                        </div>
                        <div class=" col-md-2 col-2">
                            <button type="button" class="text-black close" data-dismiss="modal">&times;</button>
                        </div>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body p-3">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addFamily" action="<?php echo base_url() ?>addScholarshipDetails" method="post"
                            role="form">
                            <!-- Default Light Table -->
                            <div class="row form-contents">
                                <div class="col-lg-12  padding_left_right_null">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="fname">Scholarship End Date<span class="text-danger required_star">*</span></label>
                                                    
                                                    <input id="dob" type="text" name="scholarship_end_date"
                                                        class="form-control datepicker date-col-3"
                                                        placeholder="Enter Scholarship End Date"  autocomplete="off"  required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="fname">Scholarship Type<span class="text-danger required_star">*</span></label>
                                                    
                                                    <select id="dob" type="text" name="scholarship_type"
                                                        class="form-control selectpicker" data-live-search="true" required>
                                                        <option value="">Select Scholarship Type</option>
                                                        <?php if(!empty($scholarshipTypeInfo)){
                                                            foreach($scholarshipTypeInfo as $scholarship){ ?>
                                                                <option value="<?php echo $scholarship->row_id ?>"><?php echo $scholarship->scholarship_type?></option>
                                                          <?php  } } ?>
                                                   
                                                    </select>
                                                </div>
                                               
                                               
                                                <div class="form-group col-md-6">
                                                    <label for="fname">Society<span class="text-danger required_star">*</span></label>
                                                    <select class="form-control " type="text"
                                                        name="scholarship_society" id="scholarship_society" value=""
                                                        class="form-control selectpicker" required>
                                                        <option value="">Select Society</option>
                                                        <option value="BJECS">BJECS</option>
                                                        <option value="KJES">KJES</option>
                                                    </select>
                                                </div>
                                                 <div class="form-group col-md-6">
                                                    <label for="fname">Max Amount</label>
                                                    
                                                    <input id="max_amount" type="text" name="max_amount" onkeypress="return isNumberKey(event)"
                                                        class="form-control"
                                                        placeholder="Enter Max Amount"  autocomplete="off" >
                                                </div>
                                                <div class="form-group col-md-7">
                                                    <label for="fname">Application Number Prefix (e.g., ABC will start as ABC0001)<span class="text-danger required_star">*</span></label>
                                                    
                                                    <input id="application_no_prefix" type="text" name="application_no_prefix" onkeypress="return alphaOnly(event)" required
                                                        class="form-control"
                                                        placeholder="Enter Application Number Prefix"  autocomplete="off" >
                                                </div>
                                            </div>

                                            <div class="text-right">
                                                <button type="submit" class="btn btn-success mt-2"><b>Add</b></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form> <!-- form end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->


</div>
</div>
<!-- End Modal -->
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8">
</script>
<script type="text/javascript">
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function alphaOnly(event) {
    var key = event.keyCode;
    return ((key >= 65 && key <= 90) || key == 8 || key == 32);
};

jQuery(document).ready(function() {

     // Retrieve the date value from the input field
     var currentDate = $('#dob').val();
    
    $.ajax({
        url: '<?php echo base_url(); ?>/getNextTokenNumber',
        type: 'POST',
        data: {date: currentDate},
        dataType: 'json',
        success: function(response) {
            $('#token_no').val(response); // Set the next token number in the input field
        }
    });
    $('#dob').change(function() {
        var date = $(this).val();  // Get selected payment type
        $.ajax({
            url: '<?php echo base_url(); ?>/getNextTokenNumber',
            type: 'POST',
            data: {date: date},
            dataType: 'json',
            success: function(response) {
                $('#token_no').val(response); // Set the next token number in the input field
            }
        });
    });
    
    $('.dd_info').hide();
    $('.card_info').hide();
    $('.bank_info').hide();
    $('.neft_info').hide();
    $('.upi_info').hide();

    $('#payment_type').change(function() {
            var payment_type = $(this).val();  // Get selected payment type
            
            if (payment_type == "DD") {
                $('.dd_info').show();
                $('.card_info').hide();
                $('.bank_info').hide();
                $('.neft_info').hide();
                $('.upi_info').hide();
            } else if (payment_type == "CHEQUE") {
                $('.dd_info').hide();
                $('.card_info').hide();
                $('.bank_info').show();
                $('.neft_info').hide();
                $('.upi_info').hide();
            } else if (payment_type == "CASH") {
                $('.dd_info').hide();
                $('.card_info').hide();
                $('.bank_info').hide();
                $('.neft_info').hide();
                $('.upi_info').hide();
            } else if (payment_type == "CARD") {
                $('.dd_info').hide();
                $('.card_info').show();
                $('.bank_info').hide();
                $('.neft_info').hide();
                $('.upi_info').hide();
            } else if (payment_type == "NEFT") {
                $('.dd_info').hide();
                $('.card_info').hide();
                $('.bank_info').hide();
                $('.neft_info').show();
                $('.upi_info').hide();
            } else if (payment_type == "UPI") {
                $('.dd_info').hide();
                $('.card_info').hide();
                $('.bank_info').hide();
                $('.neft_info').hide();
                $('.upi_info').show();
            } else {
                // Default case when no matching option
                $('.dd_info').hide();
                $('.card_info').hide();
                $('.bank_info').hide();
                $('.neft_info').hide();
                $('.upi_info').hide();
            }
        });

      

    i = 0;
    $("#btnClone").bind("click", function() {
        var ddl1 = $("#sevas option:selected").val();
        if(ddl1 ==''){
            alert('Please Select Seva Name');
        }else{
        var rate = $("#rate_seva").val();
        var qty = $("#sevaquantity").val();
        var amount = $("#amount").val();
        var t = 0;
        $('.amount').each(function(i, e) {
            var amt = $(this).val() - 0;
            t += amt;
        });
        $('.totalAmt').val(t);

        var arr = ddl1.split('/');
        i++;
        $('#addMember').append('<tr id="row' + i +
            '"><td><input type="hidden" class="" name="sevas[]" value="' + arr[0] + '"/>' + arr[1] +
            '</td><td><input type="hidden" name="rate[]" class="rate_seva" value="' + rate + '"/>' +
            rate + '</td><td><input type="hidden" class="sevaquantity" name="qty[]" value="' + qty +
            '"/>' + qty +
            '</td><td><input type="hidden" class="amount amtest" name="amount[]" value="' + amount +
            '"/>' + amount + '</td><td><button type="button" name="remove" id="' + i +
            '" class="btn-sm btn-danger btn_remove">X</button></td></tr>');
    }

    });


    $(document).on('click', '.btn_remove', function() {
    var btn_id = $(this).attr('id');
    $('#row' + btn_id).remove();
    calculateAmount();
    totalAmounttest();
});

$(document).on("click", ".sub", function() {
    var n = $('.inv_row').length;
    if (n > 1) {
        $('.inv_row:last').remove();
    }
});

$('#sevaquantity').change(function() {
    calculateAmount();
});

$('form').delegate('.sevaquantity,.rate_seva', 'keyup', function() {
    calculateAmount();
    // totalAmount();
});


    function calculateAmount() {
    $(".amount").each(function() {
        var tr = $(this).parent().parent();

        var quantity = tr.find('.sevaquantity').val();
        var rate = tr.find('.rate_seva').val();
        if (quantity != "" && rate != "") {
            var total = quantity * rate;
        }
        tr.find('.amount').val(total);
    });
}



function totalAmounttest() {
    var t = 0;
    $('.amtest').each(function(i, e) {
        var amt = $(this).val() - 0;
        t += amt;
    });
    $('.totalAmt').val(t);
}




    $("#sevas").change(function() {
        var seva_id = $("#sevas").val();
        var arr = seva_id.split('/');

        var sevas_id = arr[0];

        $.ajax({
            url: '<?php echo base_url(); ?>/getSevaAmountInfoByID',
            type: 'POST',
            dataType: "json",
            data: {
                seva_id: sevas_id
            },

            success: function(data) {
                //var examObject = JSON.parse(data);
                var examObject = JSON.stringify(data)
                // alert(data.result.total_amt);
                var amount = data.result.amount;
                // var paidAmt = data.expenseInfo.paidAmt;
                // var balance = total_amt - paidAmt;
                $("#rate_seva").val(amount);
                calculateAmount();
                // $("#walletMoney").show();

            }
        });

    });





    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#searchList").attr("action", baseURL + "ageluListing/" + value);
        jQuery("#searchList").submit();
    });
    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "ageluListing/" + value);
        jQuery("#byFilterMethod").submit();
    });
    jQuery('.datepicker').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy" // Correct format for '06 Aug 2024'
    });


    
});


function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#uploadedImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#vImg").change(function() {
    readURL(this);
});
</script>