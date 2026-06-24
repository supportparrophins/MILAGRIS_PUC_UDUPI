
<style>
table{
    width: 100% !important;
}

.break{
    page-break-after
}
.break_b{
    page-break-before: always;
}

/*.border{
    border: 2px solid black;
}*/
.border_full{
    border: 1px solid black;
    /* height: 90% !important; */
}
.border_bottom{
    border-bottom: 1px solid black;
}
.hr_line{
    margin: 5px 0px;
    color: black;
}

.table_bordered{
    border-collapse: collapse;
}
.table_bordered th{
    border-top: 1px solid black;
    border-right: 1px solid black;
    padding: 3px;
}

.table_bordered td{
    border-top: 1px solid black;
    /* border-right: 1px solid black; */
    padding: 3px;
}

.table_bordered th .border_right_none,.table_bordered td .border_right_none{
    border-right: 1px solid transparent !important;
}

.centered-td {
        text-align: center !important;
    }



</style>


<?php 
        $copy_name = ['STUDENT COPY','OFFICE COPY'] ?>
<div class="container-fluid border_full">
    <div class="row">
        <div class="">
            <table class="table text_highlight">
                <tr>
                    <td style="text-align:center;" width="80">
                        <img height="100" class="mt-1" width="70" height="70" src="<?php echo INSTITUTION_LOGO; ?>" alt="logo">
                    </td>
                    <td width="300" style="text-align:center;">
                        <b style="font-size: 15px;margin-bottom: 2px;"><?php echo TITLE; ?></b><br/>
                        <b style="font-size: 12px;margin-bottom: 2px;">Near Shivagiri, Ukkali Road, Vijayapur - 586104</b>
                        <b style="font-size: 12px;margin-bottom: 2px;">Dise Code : 29031401417 </b><br>
                        <b style="font-size: 12px;margin-bottom: 2px;">Collge Code : EE0272 </b>
                    </td>
                </tr>
            </table>
            <hr class="border_bottom hr_line">
            <table class="table" style="font-size: 13px;margin-bottom:4px;margin-top:4px;">
                <tr>
                    <td class="centered-td"><b>Fee Receipt (<?php echo $copy_name[$name_count]; ?>)</b></td>
                </tr>
            </table>
            <table class="table" style="font-size: 15px;line-height: 1.5;">
                <tr>
                    <td>Name of the child : <b><?php echo strtoupper($studentInfo->student_name); ?></b></td>
                </tr>
                <tr>
                    <td>Date : <b><?php echo date('d-m-Y',strtotime($feeInfo->payment_date)); ?></b></td>
                </tr>
                <tr>
                    <td>Application/Regi no. : <b><?php if(!empty($studentInfo->register_number) && $studentInfo->term_name == 'II PUC'){ echo $studentInfo->register_number; }else{ echo $studentInfo->application_no; } ?></b></td>
                </tr>
                <tr>
                    <td>Name of the father : <b><?php echo $studentInfo->father_name; ?></b></td>
                </tr>
              
                <tr>
                    <td>Receipt no.: <b><?php echo $feeInfo->receipt_number; ?></b></td>
                </tr>
                <tr>
                    <td width="300">Class & Stream : <b><?php echo strtoupper($feeInfo->term_name.' '.$studentInfo->stream_name); ?></b></td>
                </tr>
                <tr>
                    <td >Payment Received Mode : <b><?php if(!empty($feeInfo->payment_type)){ echo $feeInfo->payment_type; }else{ echo 'Online'; } ?></b></td>
                </tr>
               
                <tr>
                    <?php if($feeInfo->payment_type != 'CASH'){?>
                    <td>Transaction Id : <b><?php if($feeInfo->payment_type == 'DD'){ echo $feeInfo->dd_number; }elseif($feeInfo->payment_type == 'CARD' || $feeInfo->payment_type == 'BANK' || $feeInfo->payment_type == 'UPI'){ echo $feeInfo->transaction_number; }else{ echo $feeInfo->order_id; } ?></b></td>
                    <?php } ?>
                </tr>
            </table>
            <table class="table table_bordered" style="font-size: 13px;margin-top:5px;margin-bottom:4px;line-height: 1.5;">
                <!-- <tr>
                    <th>Particulars</th>
                    <th style="border-right:none;">Amount</th>
                </tr>  -->
                <?php if(!empty($feeStructureInfo)) {
                    $i=1; $total_fee_amt=0;
                    foreach($feeStructureInfo as $fee){ 
                        if($fee->fees_type != 'Government Fees' && $fee->fees_type != 'Eligibility Fee'){
                        $total_fee_amt +=  $fee->fee_amount_state_board;
                ?>
                     <!-- <tr>
                        <th style="text-align: center;"><?php echo strtoupper($fee->fees_type); ?></th>
                        <th style="text-align: right;border-right:none;"><?php echo '₹'.number_format($fee->fee_amount_state_board,2); ?></th>
                    </tr> -->
                   
                <?php $i++; }else{
                    $dept_fee = $fee->fee_amount_state_board;
                } } } ?>  

                
            
                <!-- <tr>
                    <th colspan="1">Total Fee</th>
                    <th class="border_right_none" style="text-align: right;"><?php echo number_format($total_fee_amt,2); ?></th>
                </tr> -->
                <?php if($fee_concession != 0){ ?>
                <!-- <tr>
                    <th colspan="1">Fee Concession(-)</th>
                    <th class="border_right_none" style="text-align: right;"><?php echo number_format($fee_concession,2); ?></th>
                </tr> -->
                <?php } ?>
                <tr>
                    <th colspan="1">Amount Paid</th>
                    <th class="border_right_none" style="text-align: right;border-right:none;"><?php if($feeInfo->payment_count == 1){ $paidAmt = $feeInfo->paid_amount; }else{ $paidAmt =$feeInfo->paid_amount; } echo '₹'.number_format($paidAmt,2); ?></th>
                </tr>
                <!-- <tr>
                    <th colspan="1">Amount Pending</th>
                    <th class="border_right_none" style="text-align: right;"><?php echo number_format($feeInfo->pending_balance,2); ?></th>
                </tr> -->
                <tr>
                <td colspan="2" style="font-size: 14px;border-bottom:1px solid black;">Paid amount in words:  <br><b><span style="text-transform: capitalize;"><?php echo strtoupper($paid_amount_words).' ONLY'; ?></span></b></td>
                </tr>   
            </table>
           

            <table class="table table_bordered_none" style="font-size: 13px;">
                <tr><td></td></tr>
                <tr>
                    <td>All fees paid are not transferable or refundable.</td>
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td>This is an online generated fee Receipt no seal and signature is required.</td>
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td style="font-size: 11px;"><?php echo date('d-m-Y h:i:s A', strtotime($feeInfo->created_date_time)); ?></td>
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td style="font-size: 11px;">GENERATED BY: <b><?php echo strtoupper($staffName->name); ?></td>
                </tr>
            </table>
        </div>
    </div>
  
</div>
<!-- <b style="font-size: 11px;">All fees paid are not transferable or refundable.</b><br/> -->
<!-- <b style="font-size: 11px;">This is an online generated fee Receipt no seal and signature is required.</b> -->
<br>

<!-- <p style="font-size: 12px;"><b><?php echo date('d-m-Y h:i:s A', strtotime($feeInfo->created_date_time)); ?></b> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Generated By: <b><?php echo $staffName->name; ?></p> -->
<?php 


?>