<style>
.table_search_th {
    padding: .1rem !important;
    vertical-align: top !important;
    border-top: 1px solid #c2c6c7 !important;
}

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
<div class="row column_padding_card">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container px-3 pt-1 overall_content">
    <div class="content-wrapper">
    <form action="<?php echo base_url(); ?>viewDepartmentFeeCancelledInfo" method="POST" id="byFilterMethod">
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class="col-lg-4 col-12 col-md-5 box-tools">
                                <span class="page-title">
                                    <i class="material-icons">book</i>Government Credit Note  Info
                                </span>
                            </div>
                           
                            <div class="col-lg-4 col-12 col-md-5 box-tools">
                                <b class="text-dark" style="font-size: 20px;">Total Receipt: <?php echo $online_pay_count; ?></b>
                                <a href="#" data-toggle="modal" data-target="#filterMoreModel"
                                    class="btn btn_back primary_color mobile-btn float-right text-white"
                                    value=""><i class="fa fa-filter"></i> Filter More
                                </a>
                            </div>
                           
                            <?php //if($by_type == 'Processed'){ ?>
                            <div class="col-lg-4 col-md-3 col-12"> 
                             <?php if($role != ROLE_AUDITOR){ ?>

                                <!-- <a class="btn btn-success mobile-btn float-right border_right_radius" href="#"
                                    id="addBankSettlement"><i class="fa fa-university"></i>
                                    Bank Settlement</a> -->
                                    <?php } ?>           

                                    <!-- <a class="btn btn-danger mobile-btn float-right border_right_radius" href="#"
                                    id="changeReceiptDateModelShow"><i class="fa fa-date"></i>
                                    Date Change</a>
                                    <div class="dropdown mobile-btn float-right">
                                    <button type="button" class="btn btn-success dropdown-toggle border_right_radius" data-toggle="dropdown">
                                        Print
                                    </button> -->
                                    <!-- <div class="dropdown-menu p-0">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#bulkReceiptPrintWord" class="btn btn-md btn-primary">Fee Receipt WORD</a>
                                    </div> -->
                                </div>
                                    <!-- <div class="dropdown mobile-btn float-right">
                                    <button type="button" class="btn btn-primary dropdown-toggle border_radius_none"
                                        data-toggle="dropdown">
                                        Action
                                    </button>
                                    <div class="dropdown-menu p-0">
                                      
                                    <a class="btn btn-success mobile-btn border_right_radius" href="#"
                                    data-toggle="modal" data-target="#feeDetailedPaidReport"><i class="fa fa-plus"></i>
                                    Fee Paid Report</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="btn btn-primary mobile-btn  border_right_radius" href="#"
                                    data-toggle="modal" data-target="#downloadReportStructureWiseII"><i class="fa fa-plus"></i>
                                    Fee Structure Wise Report</a>
                                        <div class="dropdown-divider m-0"></div>
                                        <a class="btn btn-info mobile-btn  border_right_radius" href="#"
                                    data-toggle="modal" data-target="#myReportModal"><i class="fa fa-plus"></i>
                                    Bank Report</a>
                                    </div>
                                </div> -->

                            </div>
                            <?php //} ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-2 text-center table-responsive">
                        <table class="table table-bordered text-dark mb-0">
                            <thead class="text-center">
                                
                                    <tr>
                                        <td class="p-0 table_search_th"></td>
                                        <td class="p-0 table_search_th">
                                            <div class="form-group m-0">
                                                <input type="text" value="<?php echo $date_select;  ?>"
                                                    name="date_select" class="form-control" Placeholder="Select Date"
                                                    id="date_select" autocomplete="off" />
                                            </div>
                                        </td>
                                        <td class="p-0 table_search_th">
                                            <div class="form-group m-0">
                                                <input type="text" value="<?php echo $student_id;  ?>" name="student_id"
                                                    class="form-control" Placeholder="Application No." id="student_id"
                                                    autocomplete="off" />
                                            </div>
                                        </td>
                                        <td class="p-0 table_search_th">
                                            <div class="form-group m-0">
                                                <input type="text" value="<?php echo $student_name;  ?>" name="student_name"
                                                    class="form-control" Placeholder="Student Name" id="student_name"
                                                    maxlength="30" autocomplete="off" />
                                            </div>
                                        </td>
                                        <td class="p-0 table_search_th">
                                        <div class="form-group mb-0">
                                            <select class="form-control" name="by_term" id="by_term">
                                                <?php if(!empty($by_term)){ ?>
                                                    <option value="<?php echo $by_term; ?>" selected><b>Selected: <?php echo $by_term; ?></b></option>
                                                <?php } ?>
                                                <option value="">Search Term</option>
                                                <option value="I PUC">I PUC</option>
                                                <option value="II PUC">II PUC</option>
                                            </select>
                                        </div>
                                    </td>
                                        <td class="p-0 table_search_th">
                                            <div class="form-group m-0">
                                                <input onkeypress="return isNumberKey(event)" type="text"
                                                    value="<?php echo $receipt_number;  ?>" name="receipt_number"
                                                    class="form-control" Placeholder="Receipt Number"
                                                    id="receipt_number" autocomplete="off" />
                                            </div>
                                        </td>
                                        


                                        <td class="p-0 table_search_th">
                                            <div class="form-group m-0">
                                                <input onkeypress="return isNumberKey(event)" type="text"
                                                    value="<?php echo $amount_paid  ?>" name="amount_paid"
                                                    class="form-control" Placeholder="Amount Paid" id="amount_paid"
                                                    autocomplete="off" />
                                            </div>
                                        </td>
                                        <td class="p-0 table_search_th">
                                            <div class="form-group m-0">
                                                <select class="form-control text-dark" id="payment_type"
                                                    name="payment_type" value="<?php echo $payment_type  ?>">
                                                    <option value=""> Payment Type</option>
                                                    <option value="ONLINE">ONLINE</option>
                                                    <option value="CASH">CASH</option>
                                                    <option value="DD">DD</option>
                                                    <option value="CARD">CARD</option>
                                                </select>
                                            </div>
                                        </td>

                                        <!-- <td class="p-0 table_search_th">
                                            <div class="form-group m-0">
                                                <select class="form-control text-dark" id="payment_type"
                                                    name="bank_settlement">
                                                    <option value=""> By Settlement </option>
                                                    <option value="">ALL</option>
                                                    <option value="Pending">Pending</option>
                                                    <option value="Settled">Settled</option>
                                                   
                                                </select>
                                            </div>
                                        </td>
                                        <td class="p-0 table_search_th">
                                            <div class="form-group m-0">
                                                <input type="text" value="<?php echo $by_bank_date;  ?>"
                                                    name="by_bank_date" class="form-control bank_date_search" Placeholder="Select Bank Date"
                                                    id="by_bank_date" autocomplete="off" />
                                            </div>
                                        </td> -->
                                        <td class="p-0 table_search_th">
                                            <div class="form-group m-0">
                                                <select class="form-control text-dark" id="by_year"
                                                    name="by_year">
                                                    <?php if(!empty($year)){ ?>
                                                    <option value="<?php echo $year ?>"><?php echo $year ?></option>
                                                    <?php } ?>
                                                    <?php if(CURRENT_YEAR == '2024'){
                                                        $year = '2024-25';
                                                     }else if(CURRENT_YEAR == '2025'){
                                                        $year = '2025-26';
                                                     }?>
                                                    <option value="2025">2025-26</option>
                                                    <option value="2024">2024-25</option>
                                                    
                                                </select>
                                            </div>
                                        </td>
                                         <td class="p-0 table_search_th">
                                            <div class="form-group m-0">
                                                <input type="text" value="<?php echo $remarks;  ?>"
                                                    name="remarks" class="form-control " Placeholder="Enter Remarks"
                                                    id="remarks" autocomplete="off" />
                                            </div>
                                        </td>
                                        <td class="p-0 table_search_th">
                                            <button id="filterButton" type="submit" class="btn btn-success btn-block mobile-width">
                                                Search</button>
                                        </td>
                                    </tr>
                                </form>
                                <tr class="table_row_background">
                                    <th width="25"><input type="checkbox" id="selectAll" /></th>
                                    <th>Date</th>
                                    <th>Appl No.</th>
                                    <th>Student Name</th>
                                    <th>Term</th>
                                    <th>Receipt No.</th>
                                    <!-- <th>Order ID.</th> -->

                                    <th>Amount</th>
                                    <th>Pay Type</th>
                                    <!-- <th>Bank</th>
                                    <th>Bank Date</th> -->
                                    <th width="85">Year</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                                <?php if(!empty($onlineFeeInfo)){
                                foreach($onlineFeeInfo as $online){ ?>
                                <tr class="text-dark">
                                    <th><input type="checkbox" class="singleSelect"
                                            value="<?php echo $online->row_id; ?>" /></th>
                                    <td><?php echo date('d-m-Y',strtotime($online->payment_date)); ?></td>
                                    <td><?php echo $online->application_no; ?></td>
                                    <td><?php echo strtoupper($online->student_name); ?></td>
                                    <td><?php echo $online->term_name; ?></td>
                                    <td class="text-center"><?php echo $online->receipt_number; ?></td>
                                    <!-- <td><?php echo $online->order_id; ?></td> -->
                                    <td><?php echo $online->paid_amount; ?></td>
                                    <td><?php echo $online->payment_type; ?></td>
                                    <!-- <td><?php if($online->bank_settlement_status == 1){
                                        echo "<b class='color-green'>Settled</b>";
                                    }else{
                                        echo "<b class='color-red'>Pending</b>";
                                    }  ?></td>
                                    <td><?php if(!empty($online->date)){
                                        echo date('d-m-Y',strtotime($online->date)); 
                                    }
                                    ?></td> -->
                                    <?php if($online->payment_year == '2024'){
                                        $payment_year = '2024-25';
                                        }else if($online->payment_year == '2025'){
                                        $payment_year = '2025-26';
                                        }?>
                                    <td><?php echo $payment_year; ?></td>
                                    <td><?php echo $online->remarks; ?></td>
                                    <td width="80">
                                    
                                        <a href="<?php echo base_url(); ?>govtfeePaymentReceiptPrint/<?php echo $online->row_id; ?>"
                                           class="btn btn-xs btn-primary" target="_blank"><i class="fa fa-print"></i>Receipt</a>
                                            <!-- <a class="btn btn-xs btn-danger deleteReceipt" href="#" data-row_id="<?php echo $online->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a> -->
                                       
                                    </td>

                                </tr>
                                <?php } }else{ ?>
                                <tr class="text-dark">
                                    <td colspan="11" style="background-color: #83c8ea7d;">Fee info not found</td>
                                </tr>
                                <?php } ?>
                            </thead>
                        </table>

                        <div class="box-footer clearfix">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
<div class="modal fade-scale" id="filterMoreModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header bg-blue ">
                <h4 class="modal-title">Filter More</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form action="<?php echo base_url() ?>viewDepartmentFeeCancelledInfo" role="form" method="post">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Generated By (Staff ID)</label>
                                <input type="text" class="form-control required" value="<?php echo $created_by ?>"
                                    id="" name="created_by"
                                    placeholder="Generated By (Staff ID)" autocomplete="off" />
                            </div>
                        </div>
                       
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Generated Date</label>
                                <input type="text" class="form-control datepicker" value="<?php echo $created_date_time ?>" 
                                    id="" name="created_date_time" 
                                    placeholder="Generated Date" autocomplete="off" />
                            </div>
                        </div>
                              
                    </div>
                    <!-- <hr class="mt-1 mb-2"> -->

                    <div class="modal-footer pb-0 px-2">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span> Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- The Modal for bank settlement-->
<div class="modal" id="bankSettlementModel">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Fee Bank Settlement</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
               
                    <div class="row">
                    
                        <div class="col-lg-12">
                        <span id="alertMsg"></span>
                        <b>Total Receipts Selected: <span id="totalReceipt"></span></b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                           
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Settlement Date</label>
                                <input readonly type="text" id="settle_date_bank" name="settle_date" class="form-control" value="<?php echo date('d-m-Y'); ?>"
                                    required></input>
                            </div>
                        </div>
                    </div>


                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="addBankSettlementSubmit" class="btn btn-success">Send</button>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    $('#alertMsg').html('');
    $('.dateSearchShow').hide();
    $('.dateSearchShowStructure').hide();
    jQuery('ul.pagination li a').click(function(e) {
        $('.loaderScreen').show();
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "viewDepartmentFeeCancelledInfo/" + value);
        jQuery("#byFilterMethod").submit();
    });

    $('#receiptSubmit, #receiptSubmitWord').click(function() {
        $(".custom_loader").hide();
        $("#custom_loader_text").css('display','none');
    });

    $("#report_type").on('change', function() {
        var report_type = $('#report_type').val();
        if (report_type == 'DATEWISE' ) {
            $('.dateSearchShow').show();
        } else {
            $('.dateSearchShow').hide();
        }
    });

    $("#report_type_structure").on('change', function() {
        var report_type = $('#report_type_structure').val();
        if (report_type == 'DATEWISE' ) {
            $('.dateSearchShowStructure').show();
        } else {
            $('.dateSearchShowStructure').hide();
        }
    });

    

    jQuery('#change_date, #date_select, .dateSearch, #date_from, #date_to, #settle_date_bank, .bank_date_search,.datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });
    $('#filterButton').click(function() {
        $('.loaderScreen').show();
    });
    $('#selectAll').click(function() {
        if ($('#selectAll').is(':checked')) {
            $('.singleSelect').prop('checked', true);
        } else {
            $('.singleSelect').prop('checked', false);
        }
    });


    

    $('#addBankSettlement').click(function() {
        var receipt_number = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select Minimum one Fee payment for Bank settlement!");
            return;
        } else {
            $('#totalReceipt').html($('.singleSelect:checkbox:checked').length);
            $('#bankSettlementModel').modal('show');
        }
        $('.singleSelect:checked').each(function(i) {
            receipt_number.push($(this).val());
        });
        
    });


    $('#changeReceiptDateModelShow').click(function() {
        var receipt_number = [];
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select Minimum one Fee payment for change date!");
            return;
        } else {
            $('#totalReceiptChangeDate').html($('.singleSelect:checkbox:checked').length);
            $('#changeReceiptDateModel').modal('show');
        }
        $('.singleSelect:checked').each(function(i) {
            receipt_number.push($(this).val());
        });
        
    });


    $('#addBankSettlementSubmit').click(function() {
      
        var receipt_number = [];
        if ($('#settle_date_bank').val() == "") {
            $('#alertMsg').html(`<div class="alert alert-danger" role="alert">
            Please select Settlement date !
            </div>`);
        } else {
            $('#alertMsg').html('Please wait..');
            $('.singleSelect:checked').each(function(i) {
                receipt_number.push($(this).val());
            });

            $.ajax({
                url: baseURL + '/addGovtBankSettlementSubmit',
                type: 'POST',
                data: {
                    receipt_number: JSON.stringify(receipt_number),
                    date: $('#settle_date_bank').val(),
                },
                success: function(data) {
                    if(data == 'success'){
                        $('#alertMsg').html(`<div class="alert alert-success" role="alert">
                  Bank Settled Successfully!
                  </div>`);
                  setTimeout(function() {
                    $('#bankSettlementModel').modal('hide');
                    location.reload();//refresh the page
                    }, 1000);
                    }else{
                        $('#alertMsg').html(`<div class="alert alert-error" role="alert">
                  Problem in bank Settlement!
                  </div>`);
                    }
                 
                },
                error: function(result) {
                    $('#alertMsg').html('');
                    alert("Retry Again! Something Went Wrong");
                },
                fail: (function(status) {
                    $('#alertMsg').html('');
                    alert("Retry Again! Something Went Wrong");
                }),
                beforeSend: function(d) {
                    $('#alertMsg').html('Loading..');
                }
            });
        }
    });



    $('#changeReceiptDate').click(function() {
      var receipt_number = [];
      if ($('#change_date') == "") {
          $('#alertMsgchangeDate').html(`<div class="alert alert-danger" role="alert">
        Please select new date !
      </div>`);
      } else {
          $('#alertMsgchangeDate').html('Please wait..');
          //$('#shortListModelView').modal('show');
          $('.singleSelect:checked').each(function(i) {
              receipt_number.push($(this).val());
          });

          $.ajax({
              url: baseURL + '/changeReceiptDate',
              type: 'POST',
              data: {
                  receipt_number: JSON.stringify(receipt_number),
                  date: $('#change_date').val(),
              },
              success: function(data) {
                  if(data == 'success'){
                      $('#alertMsgchangeDate').html(`<div class="alert alert-success" role="alert">
                Date Changed Successfully!
                </div>`);
                  }else{
                      $('#alertMsgchangeDate').html(`<div class="alert alert-error" role="alert">
                Problem in Date change!
                </div>`);
                  }
               
              },
              error: function(result) {
                  $('#alertMsgchangeDate').html('');
                  alert("Retry Again! Something Went Wrong");
              },
              fail: (function(status) {
                  $('#alertMsgchangeDate').html('');
                  alert("Retry Again! Something Went Wrong");
              }),
              beforeSend: function(d) {
                  $('#alertMsgchangeDate').html('Loading..');
              }
          });
      }
  });



  jQuery(document).on("click", ".deleteReceipt", function(){
			var row_id = $(this).data("row_id"),
				hitURL = baseURL + "deleteReceipt",
				currentRow = $(this);

			var confirmation = confirm("Are you sure to delete selected receipt ?");

			if(confirmation)
			{
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { row_id : row_id } 
				}).done(function(data){

					currentRow.parents('tr').remove();
					if(data.status = true) { alert("Receipt successfully deleted"); }
					else if(data.status = false) { alert("Receipt delete failed"); }
					else { alert("Access denied..!"); }
				});
			}

		});
});
</script>