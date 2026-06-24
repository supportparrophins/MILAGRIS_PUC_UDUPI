
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
    height: 100% !important;
     box-sizing: border-box;
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

<!-- RECEIPT 1 -->
<?php 
        $copy_name = ['STUDENT COPY','OFFICE COPY'] ?>
<?php //if(!empty($deptFeeInfo)){ ?>
  
<div class="container-fluid border_full">
    <div class="row">
        <div class="">
            <table class="table text_highlight">
                <tr>
                    <td style="text-align:center;" width="80">
                        <img height="100" class="mt-2" width="70" height="70" src="<?php echo INSTITUTION_LOGO; ?>" alt="logo">
                    </td>
                    <td width="300" style="text-align:center;">
                        <b style="font-size: 15px;margin-bottom: 2px;"><?php echo TITLE; ?></b><br/>
                        <b style="font-size: 12px;margin-bottom: 2px;">Near Shivagiri, Ukkali Road, Vijayapur - 586104 </b>
                        <b style="font-size: 12px;margin-bottom: 2px;">Dise Code : 29031401417 </b><br>
                        <b style="font-size: 12px;margin-bottom: 2px;">Collge Code : EE0272 </b>
                        <!-- <b style="font-size: 12px;margin-bottom: 2px;">Bengaluru – 560 001</b><br/> -->
                    </td>
                </tr>
            </table>
            <hr class="border_bottom hr_line">
            <table class="table" style="font-size: 12px;line-height: 1.3;">
                <tr>
                    <td class="centered-td"><b>Fee Receipt (<?php echo $copy_name[$name_count]; ?>)</b></td>
                </tr>
            </table>
            <table class="table" style="font-size: 13px;line-height: 1.3;">
                <tr>
                    <td>Name of the child : <b><?php echo strtoupper($studentInfo->student_name); ?></b></td>
                </tr>
                <tr>
                    <td>Application/Regi no. : <b><?php if(!empty($studentInfo->register_number) && $studentInfo->term_name == 'II PUC'){ echo $studentInfo->register_number; }else{ echo $studentInfo->application_no; } ?></b></td>
                </tr>
                <tr>
                    <td>Name of the father : <b><?php echo $studentInfo->father_name; ?></b></td>
                </tr>
                <tr>
                    <td>Date : <b><?php echo date('d-m-Y',strtotime($govtFeeInfo->payment_date)); ?></b></td>
                </tr>
                <tr>
                    <td>Receipt no.: <b><?php echo $govtFeeInfo->receipt_number; ?></b></td>
                </tr>
                <tr>
                    <td >Payment Received Mode : <b><?php if(!empty($govtFeeInfo->payment_type)){ echo $govtFeeInfo->payment_type; }else{ echo 'Online'; } ?></b></td>
                </tr>
                <tr>
                    <td width="300">Class & Stream : <b><?php echo strtoupper($govtFeeInfo->term_name.' '.$studentInfo->stream_name); ?></b></td>
                </tr>
                <tr>
                    <?php if($govtFeeInfo->payment_type != 'CASH'){?>
                    <td>Transaction Id : <?php if($govtFeeInfo->payment_type == 'DD'){ echo $govtFeeInfo->dd_number; }elseif($govtFeeInfo->payment_type == 'CARD' || $govtFeeInfo->payment_type == 'BANK' || $govtFeeInfo->payment_type == 'UPI'){ echo $govtFeeInfo->transaction_number; }else{ echo $govtFeeInfo->order_id; } ?></td>
                    <?php } ?>
                </tr>
            </table>
            <table class="table table_bordered" style="font-size: 10px;">
                <tr>
                    <th width="75%">Particulars</th>
                    <th style="border-right:none;">Amount</th>
                </tr> 
               
                   
                   
                <?php foreach($feePaidInfo as $fee){ 
                        if($fee->paid_amount != 0){
                                            ?>
                    <tr>
                        <th style="text-align: left;font: weight 200px;"><?php echo $fee->fee_name; ?></th>
                        <td style="text-align: right;border-right:none;">
                            <?php 
                                $total_fee_amt += $fee->paid_amount;
                                echo '₹'.number_format($fee->paid_amount,2); ?></td>
                    </tr>
                <?php } } ?>
               
                <!-- <tr>
                    <th colspan="1">Total Fee</th>
                    <th class="border_right_none" style="text-align: right;"><?php echo number_format($govtFeeInfo->paid_amount,2); ?></th>
                </tr> -->
                <tr>
                    <th colspan="1">Amount Paid</th>
                    <th class="border_right_none" style="text-align: right;border-right:none;"><?php echo '₹'.number_format($govtFeeInfo->paid_amount,2); ?></th>
                </tr>
                <?php $balance = $govtAmt - $govtFeeInfo->paid_amount;  
                    if($balance > 0){
                ?>
                <!-- <tr>
                    <th colspan="1">Balance</th>
                    <th class="border_right_none" style="text-align: right;"><?php echo number_format($govtFeeInfo->pending_balance,2); ?></th>
                </tr> -->
                <?php } ?>
                <tr>
                    <td colspan="2" style="border-bottom:1px solid black;font-size: 11px;">Paid amount in words: <b><span style="text-transform: capitalize;border-right:none;"><?php echo strtoupper(($paid_amount_words)).' ONLY'; ?></span></b></td>
                </tr>   
            </table>
        
            <table class="table table_bordered_none" style="font-size: 11px;">
                <tr>
                    <td>All fees paid are not transferable or refundable.</td>
                </tr>
                <tr>
                    <td>This is an online generated fee Receipt no seal and signature is required.</td>
                </tr>
                <tr>
                    <td style="font-size: 10px;"><?php echo date('d-m-Y h:i:s A', strtotime($govtFeeInfo->created_date_time)); ?></td>
                </tr>
                <tr>
                    <td style="font-size: 10px;">GENERATED BY: <b><?php echo strtoupper($staffName->name); ?></td>
                </tr>
            </table>
        </div>
    </div>
  
</div>
