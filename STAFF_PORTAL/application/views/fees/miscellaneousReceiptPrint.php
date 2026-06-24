
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
 if(empty($miscellaneousInfo->qnty)){

    $amount = $miscellaneousInfo->amount;
}else{

    $amount = $miscellaneousInfo->qnty * $miscellaneousInfo->amount;

}
        $copy_name = ['STUDENT COPY','OFFICE COPY'] ?>
<div class="container-fluid border_full">
    <div class="row">
        <div class="">
            <table class="table text_highlight" >
                <tr>
                    <td style="text-align:center;" width="80">
                        <img height="100" class="mt-1" width="70" height="70" src="<?php echo INSTITUTION_LOGO; ?>" alt="logo">
                    </td>
                    <td width="300" style="text-align:center;">
                        <b style="font-size: 15px;margin-bottom: 2px;"><?php echo TITLE; ?></b><br/>
                        <b style="font-size: 15px;margin-bottom: 2px;"><?php echo ADDRESS; ?></b>
                        <!-- <b style="font-size: 12px;margin-bottom: 2px;">Near Shivagiri, Ukkali Road, Vijayapur - 586104 </b>
                        <b style="font-size: 12px;margin-bottom: 2px;">Dise Code : 29031401417 </b><br>
                        <b style="font-size: 12px;margin-bottom: 2px;">Collge Code : EE0272 </b> -->


                    </td>
                </tr>
            </table>
            <hr class="border_bottom hr_line">
            <table class="table" style="font-size: 13px;margin-bottom:4px;margin-top:4px;line-height: 1.5;">
                <tr>
                    <td class="centered-td"><b>Fee Receipt (<?php echo $copy_name[$name_count]; ?>)</b></td>
                </tr>
            </table>
            <table class="table" style="font-size: 17px;line-height: 1.5;">
                <tr>
                    <td>Name of the child : <b><?php echo strtoupper($miscellaneousInfo->student_name); ?></b></td>
                </tr>
                <tr>
                    <td>Date : <b><?php echo date('d-m-Y',strtotime($miscellaneousInfo->date)); ?></b></td>
                </tr>
              
              
                <tr>
                    <td>Receipt no.: <b><?php echo $miscellaneousInfo->receipt_no; ?></b></td>
                </tr>
                <tr>
                    <td width="300">Class & Stream : <b><?php echo strtoupper($miscellaneousInfo->term.' '.$miscellaneousInfo->stream); ?></b></td>
                </tr>
                <tr>
                    <td >Payment Received Mode : <b><?php if(!empty($miscellaneousInfo->payment_type)){ echo $miscellaneousInfo->payment_type; }else{ echo 'Online'; } ?></b></td>
                </tr>
               
                <tr>
                    <?php if($miscellaneousInfo->payment_type != 'CASH'){?>
                    <td>Transaction Id : <b><?php if($miscellaneousInfo->payment_type == 'NEFT'){ echo $miscellaneousInfo->ref_number; }elseif($miscellaneousInfo->payment_type == 'UPI'){ echo $miscellaneousInfo->upi_ref_no; }elseif($miscellaneousInfo->payment_type == 'CARD' || $miscellaneousInfo->payment_type == 'BANK' || $miscellaneousInfo->payment_type == 'UPI'){ echo $miscellaneousInfo->transaction_number; }else{ echo $miscellaneousInfo->order_id; } ?></b></td>
                    <?php } ?>
                </tr>
            </table>
            <table class="table table_bordered" style="font-size: 13px;margin-top:5px;margin-bottom:4px;line-height: 1.5;">
                <tr>
                    <th>Particulars</th>
                    <th style="border-right:none;">Amount</th>
                </tr> 
                <tr>
                     <th colspan="1"><?php echo strtoupper($miscellaneousInfo->miscellaneous_type); ?></th>
                     <th class="border_right_none" style="text-align: center;border-right:none;"><?php echo number_format($amount,2); ?></th>
                 </tr>
               
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
                    <td style="font-size: 11px;"><?php echo date('d-m-Y h:i:s A', strtotime($miscellaneousInfo->created_date_time)); ?></td>
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td style="font-size: 11px;">GENERATED BY: <b><?php echo strtoupper($staffName->name); ?></td>
                </tr>
                <tr><td></td></tr>
            </table>
        </div>
    </div>
  
</div>
