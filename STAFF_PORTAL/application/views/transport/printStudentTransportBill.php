
<style>
table{
    width: 100% !important;
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
.table_bordered th,.table_bordered td{
    border-top: 1px solid black;
    border-right: 1px solid black;
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
    if(!empty($feeConcession)){
        $concessionAmt = $feeConcession->fee_amt;
    }else{
        $concessionAmt = 0;
    }
    $transaction_id = '';

    if(!empty($studentTransportInfo->order_id)) {
    $transaction_id =  $studentTransportInfo->order_id;
    }
    if(!empty($studentTransportInfo->dd_number)) {
        $transaction_id =  $studentTransportInfo->dd_number;
    }
    if(!empty($studentTransportInfo->transaction_number)) {
        $transaction_id =  $studentTransportInfo->transaction_number;
     }
     if(!empty($studentTransportInfo->upi_ref_no)) {
        $transaction_id =  $studentTransportInfo->upi_ref_no;
     }
      if($studentTransportInfo->term_name == 'I PUC'){
                        $year = trim($studentTransportInfo->intake_year_id);
                        $RateInfo = $transModel->getStudentTransportRateInfo($studentTransportInfo->route_id,$year);
                    }else{
                        $year = trim($studentTransportInfo->intake_year_id) + 1;
                        $RateInfo = $transModel->getStudentTransportRateInfo($studentTransportInfo->route_id_II,$year);
                    }
                    $total_fee = $RateInfo->rate;
     
?>
<!--  -->
<div class="container-fluid border_full">
    <div class="row">
        <div class="">
              <table class="table text_highlight" style="line-height:1.5;">
                <tr>
                    <td style="text-align:center;" width="10%">
                        <img height="100" class="mt-2" width="70" height="70" src="<?php echo INSTITUTION_LOGO; ?>" alt="logo">
                    </td>
                    <td width="90%" style="text-align:center;">
                        <b style="font-size: 22px;margin-bottom: 2px;"><?php echo TITLE; ?></b><br/>
                        <b style="font-size: 15px;margin-bottom: 2px;"><?php echo FEES_ADDRESS; ?></b><br/>
                        <?php if(!empty(SCHOOL_CODE)){ ?>
                        <b style="font-size: 15px;margin-bottom: 2px;">College Code – <?php echo SCHOOL_CODE ?></b><br/>
                        <?php } ?>
                    </td>
                </tr>
            </table>
            <hr class="border_bottom hr_line">
              <table class="table" style="font-size: 15px;line-height:1.6;">
                <tr >
                    <td colspan="2" class="centered-td" style="font-size: 20px;"><b>Fee Receipt</b></td>
                </tr>
                <tr>
                    <td>Name of the student : <b><?php echo strtoupper($studentTransportInfo->student_name); ?></b></td>
                    <td>Student ID : <b><?php echo $studentTransportInfo->student_id; ?></b></td>
                </tr>
                <tr>
                    <td>Name of the father : <b><?php echo $studentTransportInfo->father_name; ?></b></td>
                    <td>Payment Received Date : <b><?php echo date('d-m-Y',strtotime($studentTransportInfo->payment_date)); ?></b></td>
                </tr>
                <tr>
                    <td>Class & Section : <b><?php echo strtoupper($studentTransportInfo->term_name.' '.$studentTransportInfo->section_name); ?></b></td>
                    <td>Receipt No. : <b><?php echo $studentTransportInfo->receipt_no; ?></b></td>
                </tr>
                <tr>
                    <td>Bus Pick Point : <b><?php echo $RateInfo->pickup_point_name;?></b></td>
                    <td>Bus No. : <b><?php echo $studentTransportInfo->bus_no;?></b></td>
                </tr>
                <tr>
                    <td>Month From: <b><?php echo date('M-Y',strtotime($studentTransportInfo->from_date));?></b></td>
                    <td>Month To: <b><?php echo date('M-Y',strtotime($studentTransportInfo->to_date));?></b></td>
                </tr>
                <tr>
                    <td >Payment Received Mode : <b><?php if(!empty($studentTransportInfo->payment_type)){ echo $studentTransportInfo->payment_type; }else{ echo 'Online'; } ?></b></td>
                    <?php if($studentTransportInfo->payment_type != 'CASH'){ ?>
                    <td>Transaction Id : <b><?php echo $transaction_id; ?></b></td>
                    <?php } ?>
                </tr>
            </table>
                <table class="table table_bordered" style="font-size: 13px;line-height:1.7;">
                 <tr>
                    <th width="60%" style="font-size: 15px;line-height:1.7;">Particulars </th>
                    <th style="border-right:none;font-size: 15px;line-height:1.7;">Amount</th>
                </tr> 
                 <tr>
                    <th style="text-align: center;">TRANSPORT FEE&nbsp;
                    </th>
                     
                    <th style="text-align: center;border-right:none;"><?php echo number_format($total_fee,2); ?></th>
                </tr>
                <tr>
                    <th style="text-align: center;">TOTAL FEE PAID&nbsp;
                    </th>
                     <?php  $paid_amount = $studentTransportInfo->bus_fees; ?>
                    <th style="text-align: center;border-right:none;"><?php echo sprintf('%0.2f', $paid_amount); ?></th>
                </tr>
                <tr>
                    <th style="text-align: center;">AMOUNT PENDING&nbsp;
                    </th>
                     <?php  $transport_pending = $studentTransportInfo->pending_balance;  ?>
                    <th style="text-align: center;border-right:none;"><?php echo sprintf('%0.2f', $transport_pending); ?></th>
                </tr>
              
                <tr>
                    <td colspan="2" style="font-size: 13px;border-right:none;"><br><b>Amount in words: <span style="text-transform: none;"><?php echo getIndianCurrency($transport_rate).' only'; ?></span></b></td>
                </tr>
            </table>
            <!-- <table class="table table_bordered" style="font-size: 13px;line-height:1.7;">
                <tr>
                    <th width="60%" style="font-size: 15px;line-height:1.7;">Particulars </th>
                    <th style="border-right:none;font-size: 15px;line-height:1.7;">Amount</th>
                </tr> 
              
                <tr>
                    <td style="text-align: center;">TRANSPORT FEE&nbsp;
                    </td>
                     <?php  $transport_rate = $studentTransportInfo->bus_fees; ?>
                    <td style="text-align: center;border-right:none;"><?php echo sprintf('%0.2f', $transport_rate); ?></td>
                </tr>
                 <tr>
                    <th>Grand Total</th>
                    <th style="text-align: center;border-right:none;"><?php echo sprintf('%0.2f', $transport_rate); ?></th>
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 13px;border-right:none;"><br><b>Amount in words: <span style="text-transform: none;"><?php echo getIndianCurrency($transport_rate).' only'; ?></span></b></td>
                </tr>
            </table> -->
        </div>
    </div>
  
</div>
<b style="font-size: 11px;">All fees paid are not transferable or refundable.</b><br/>
<b style="font-size: 11px;">This is an online generated fee Receipt no seal and signature is required.</b>

<?php 
function getIndianCurrency(float $number) {
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? '' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
}

?>