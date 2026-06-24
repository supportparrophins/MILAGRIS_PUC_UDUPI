
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

</style>
<!-- <div style="text-align:right"><span style="font-size: 13px;">COLLEGE COPY</span></div> -->
<div class="container-fluid border_full">
    <div class="row">
        <div class="">
            <table class="table text_highlight">
                <tr>
                    <!-- <td style="text-align:center;" width="80">
                        <img height="100" class="mt-2" width="70" height="70" src="<?php echo INSTITUTION_LOGO; ?>" alt="logo">
                    </td> -->
                    <td style="text-align:center;">
                        <!-- <b style="font-size: 16px;margin-bottom: 2px;">KARNATAKA JESUIT EDUCATIONAL SOCIETY</b><br/> -->
                        <b style="font-size: 13px;margin-bottom: 2px;"><?php echo TITLE; ?></b><br/>
                        <span style="font-size: 12px;margin-bottom: 2px;">Vijapura, Karnataka 562106</span><br/>
                        <b style="font-size: 13px;margin-top: 2px;"><u>FEE RECEIPT(Management)</u></b>
                    </td>
                </tr>
            </table>
            <hr class="border_bottom hr_line">
            <table class="table" style="font-size: 12px;">
                <tr>
                    <td>Receipt no.: <?php echo $feeInfo->receipt_number; ?></td>
                    <td>Date : <?php echo date('d-m-Y',strtotime($feeInfo->payment_date)); ?></td>
                </tr>
                <tr>
                    <td>Student Name : <?php echo strtoupper($studentInfo->student_name); ?></td>
                    <td>Father's Name : <?php echo strtoupper($studentInfo->father_name); ?></td>
                </tr>
                <tr>
                    <td>Year/Section/Combination : <?php echo strtoupper($feeInfo->term_name).'/'.$studentInfo->section_name.'/'.$studentInfo->stream_name; ?></td>
                    <td >Payment Received Mode : <?php echo $feeInfo->payment_type; ?></td>
                </tr>
            </table>
            <table class="table table_bordered" style="font-size: 13px;">
                <tr>
                    <th width="40" colspan="1">Sl. No.</th>
                    <th colspan="1">Particulars</th>
                    <th colspan="1">Amount</th>
                </tr>
                <?php
                if (!empty($feeStructure)) {
                $i = 1;
                $available_amt = 0;
                $paidAmount = $feeInfo->paid_amount;
                // $payment_count = 2;
                foreach ($feeStructure as $fee) {
                    if ($paidAmount <= 0) {
                        $paid_amount = 0;
                    } else {
                        if (!empty($fee_previous_paidAmt)) {
                            $rem_amt = $fee_previous_paidAmt - $fee->fee_amount;
                            // 
                            if ($rem_amt < 0) {
                                $current_paid_amt = $paidAmount;
                                $total_rem_amt = $current_paid_amt - abs($rem_amt);
                                if ($total_rem_amt < 0) {
                                    $paid_amount = abs($paidAmount);
                                } else {
                                    $paid_amount = abs($rem_amt);
                                    $current_paid_amt = $total_rem_amt;
                                    $fee_previous_paidAmt = 0;
                                    $available_amt = $paidAmount - abs($rem_amt);
                                }
                            } else {
                                $paid_amount = 0;
                                $fee_previous_paidAmt = $rem_amt;
                            }
                        } else {
                            if ($payment_count > 1) {
                                $available_amt -= $fee->fee_amount;
                                if ($available_amt < 0) {
                                    $paid_amount = abs($available_amt) - $fee->fee_amount;
                                } else {
                                    $paid_amount = $fee->fee_amount;
                                }
                            } else {
                                $paidAmount -= $fee->fee_amount;
                                if ($paidAmount < 0) {
                                    $paid_amount = abs($paidAmount) - $fee->fee_amount;
                                } else {
                                    $paid_amount = $fee->fee_amount;
                                }
                            }
                        }
                    }
                    $paidAmt = abs($paid_amount);
                    if ($paidAmt != 0) {
                        // $total_fee_amt += $paidAmt;
                    ?>
                    <tr>
                        <th colspan="1"><?php echo $i; ?></th>
                        <th colspan="1"><?php echo $fee->fees_type; ?></th>
                        <th><?php echo number_format($paidAmt,2); ?></th>
                    </tr> 
                    <?php
                    $i++;
                    }
                }
            }else{ ?>
                <tr>
                        <th colspan="1"><?php echo 1; ?></th>
                        <th colspan="1"><?php echo "Management Fee"; ?></th>
                        <th><?php echo number_format($feeInfo->paid_amount,2); ?></th>
                    </tr>
            <?php } ?>
                <!-- <tr>
                    <th colspan="1">Pending Amount</th>
                    <th class="border_right_none"><?php echo number_format($feeInfo->pending_balance,2); ?></th>
                </tr> -->
               
                <tr>
                    <th colspan="2" style="text-align:right;">TOTAL</th>
                    <th class="border_right_none"><?php echo number_format($feeInfo->paid_amount,2); ?></th>
                </tr>
                <tr>
                    <td colspan="3"><br>Amount in words: <b><span style="text-transform: capitalize;"><?php echo strtoupper(getIndianCurrency($feeInfo->paid_amount)).' ONLY'; ?></span></b></td>
                </tr>
                <?php if($feeInfo->payment_type != 'CASH'){ ?>
                <!-- <tr style="border:0">
                    <td colspan="2">Cheque No/DD No : <b><?php if($feeInfo->payment_type == 'DD'){ echo $feeInfo->dd_number; }else{ echo $feeInfo->tran_number; } ?></td>
                    <td>Transaction Date : <?php if($feeInfo->payment_type == 'DD'){ echo date('d-m-Y',strtotime($feeInfo->dd_date)); }else{ echo date('d-m-Y',strtotime($feeInfo->trans_date)); } ?></td>
                </tr> -->
                <?php } ?>
            </table>

        </div>
    </div>
  
</div>
<!-- <b style="font-size: 11px;">All fees paid are not transferable or refundable.</b><br/>
<b style="font-size: 11px;">This is an online generated fee Receipt no seal and signature is required.</b> -->
<br><br><br>
    <div style="text-align:right"><span style="font-size: 13px;">for St. Joseph's PU College</span></div>

<!-- <br><br><br><br><br><br><br><br><br>
<div class="container-fluid border_full">
    <div class="row">
        <div class="">
            <table class="table text_highlight">
                <tr>
                    <td style="text-align:center;">
                        <b style="font-size: 16px;margin-bottom: 2px;">KARNATAKA JESUIT EDUCATIONAL SOCIETY</b><br/>
                        <b style="font-size: 13px;margin-bottom: 2px;"><?php echo TITLE; ?></b><br/>
                        <span style="font-size: 12px;margin-bottom: 2px;">Salgame Road,Saraswathi Puran, Hassan - 573201</span><br/>
                        <b style="font-size: 13px;margin-top: 2px;"><u>FEE RECEIPT(Management)</u></b>
                    </td>
                </tr>
            </table>
            <hr class="border_bottom hr_line">
            <table class="table" style="font-size: 12px;">
                <tr>
                    <td>Receipt no.: <?php echo $feeInfo->receipt_number; ?></td>
                    <td>Date : <?php echo date('d-m-Y',strtotime($feeInfo->payment_date)); ?></td>
                </tr>
                <tr>
                    <td>Student Name : <?php echo strtoupper($studentInfo->student_name); ?></td>
                    <td>Father's Name : <?php echo strtoupper($studentInfo->father_name); ?></td>
                </tr>
                <tr>
                    <td>Year/Section/Combination : <?php echo strtoupper($feeInfo->term_name).'/'.$studentInfo->section_name.'/'.$studentInfo->stream_name; ?></td>
                    <td >Payment Received Mode : <?php echo $feeInfo->payment_type; ?></td>
                </tr>
            </table>
            <table class="table table_bordered" style="font-size: 13px;">
                <tr>
                    <th colspan="1">Sl. No.</th>
                    <th colspan="1">Particulars</th>
                    <th colspan="1">Amount</th>
                </tr>
                <?php
                if (!empty($feeStructure)) {
                $i = 1;
                $available_amt = 0;
                $paidAmount = $feeInfo->paid_amount;
                // $payment_count = 2;
                foreach ($feeStructure as $fee) {
                    if ($paidAmount <= 0) {
                        $paid_amount = 0;
                    } else {
                        if (!empty($fee_previous_paidAmt2)) {
                            $rem_amt = $fee_previous_paidAmt2 - $fee->fee_amount;
                            // 
                            if ($rem_amt < 0) {
                                $current_paid_amt = $paidAmount;
                                $total_rem_amt = $current_paid_amt - abs($rem_amt);
                                if ($total_rem_amt < 0) {
                                    $paid_amount = abs($paidAmount);
                                } else {
                                    $paid_amount = abs($rem_amt);
                                    $current_paid_amt = $total_rem_amt;
                                    $fee_previous_paidAmt2 = 0;
                                    $available_amt = $paidAmount - abs($rem_amt);
                                }
                            } else {
                                $paid_amount = 0;
                                $fee_previous_paidAmt2 = $rem_amt;
                            }
                        } else {
                            if ($payment_count > 1) {
                                $available_amt -= $fee->fee_amount;
                                if ($available_amt < 0) {
                                    $paid_amount = abs($available_amt) - $fee->fee_amount;
                                } else {
                                    $paid_amount = $fee->fee_amount;
                                }
                            } else {
                                $paidAmount -= $fee->fee_amount;
                                if ($paidAmount < 0) {
                                    $paid_amount = abs($paidAmount) - $fee->fee_amount;
                                } else {
                                    $paid_amount = $fee->fee_amount;
                                }
                            }
                        }
                    }
                    $paidAmt = abs($paid_amount);
                    if ($paidAmt != 0) {
                        // $total_fee_amt += $paidAmt;
                    ?>
                    <tr>
                        <th colspan="1"><?php echo $i; ?></th>
                        <th colspan="1"><?php echo $fee->fees_type; ?></th>
                        <th><?php echo number_format($paidAmt,2); ?></th>
                    </tr> 
                    <?php
                    $i++;
                    }
                }
            }else{ ?>
                <tr>
                        <th colspan="1"><?php echo 1; ?></th>
                        <th colspan="1"><?php echo "Management Fee"; ?></th>
                        <th><?php echo number_format($feeInfo->paid_amount,2); ?></th>
                    </tr>
            <?php } ?>
               
                <tr>
                    <th colspan="2" style="text-align:right;">TOTAL</th>
                    <th class="border_right_none"><?php echo number_format($feeInfo->paid_amount,2); ?></th>
                </tr>
                <tr>
                    <td colspan="3"><br>Amount in words: <b><span style="text-transform: capitalize;"><?php echo strtoupper(getIndianCurrency($feeInfo->paid_amount)).' ONLY'; ?></span></b></td>
                </tr>
            </table>

        </div>
    </div>
  
</div>
<br><br><br>
    <div style="text-align:right"><span style="font-size: 13px;">for St. Joseph's PU College</span></div> -->

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