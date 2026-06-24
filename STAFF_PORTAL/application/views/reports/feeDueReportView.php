<?php
ini_set('memory_limit', '1024M');
ini_set("pcre.backtrack_limit", "5000000");
ini_set('max_execution_time', -1);
?><style>
.break { page-break-before: always; } 
.break_after { page-break-before: none; } 
table{ width: 100% !important; }
u {    
    border-bottom: 2px dotted #00000;
    text-decoration: none;
    font-weight: bold;
    font-size:16px;
}
.border_full{ border: 1px solid black; }
.border_bottom{ border-bottom: 1px solid black; }
.hr_line{ margin: 0px; color: black; }
.table_bordered{ border-collapse: collapse; }
.table_bordered th,.table_bordered td{
    border-top: 1px solid black;
    border-right: 1px solid black;
    padding: 3px;
}
</style>
<div class="container-fluid border_full" style="padding-right:0px; padding-left:0px;">
    <div class="row">
        <table style="width: 100%;border-collapse: collapse;">
            <tr>
                <th style="border: 1px solid black;text-align: center;" colspan="9"><?php echo EXCEL_TITLE; ?></th>
            </tr>
            <tr>
                <th style="border: 1px solid black;text-align: center;" colspan="9">
                    FEE DUE INFO - <?php echo $term_name; ?> - <?php echo $fees_year; ?>
                </th>
            </tr>
            <tr>
                <th style="border: 1px solid black;text-align: center;width: 80px;">SL.No.</th>
                <th style="border: 1px solid black;text-align: center;width: 100px;">Student ID</th>
                <th style="border: 1px solid black;text-align: center;width: 200px;">Name</th>
                <th style="border: 1px solid black;text-align: center;width: 100px;">Stream</th>
                <th style="border: 1px solid black;text-align: center;width: 100px;">Total Amt.</th>
                <th style="border: 1px solid black;text-align: center;width: 100px;">Total Fee Paid</th>
                <th style="border: 1px solid black;text-align: center;width: 100px;">Concession</th>
                <th style="border: 1px solid black;text-align: center;width: 100px;">Pending</th>
                <th style="border: 1px solid black;text-align: center;width: 150px;">Mobile No</th>
            </tr>
            <?php
            $j            = 1;
            $Total_Amt    = 0;
            $Total_Fee_Paid = 0;
            $total_concession = 0;
            $pending_total  = 0;
            if ($term_name == 'I PUC') {
                $studentInfo = $student->getAllStudentInfo_For_Fee_report($term_name, $stream_name, $year);
                foreach ($studentInfo as $std) {
                    $filter['fee_year']    = $year;
                    $filter['term_name']   = 'I PUC';
                    $filter['stream_name'] = $std->stream_name;
                    $filter['gender']       = $std->gender;
                    // Total fee: base + govt fee
                    $total_fee_obj    = $fee->getTotalFeeAmount($filter);
                    $depart_fee       = $fee->getGovtFeeAmount($filter);
                    $total_fee_amount = (float)$total_fee_obj->total_fee + (float)$depart_fee;
                    // Paid amount
                    $total_paid_obj      = $fee->getFeePaidInfoForReport($std->row_id, $year);
                    $total_govt_paid_obj = $fee->getGovtFeePaidInfoForReport($std->row_id, $year);
                    $paid_amt = ($total_paid_obj->paid_amount != '')
                        ? (float)$total_paid_obj->paid_amount + (float)$total_govt_paid_obj->paid_amount
                        : 0;
                    // Concession
                    $concession_amt   = $fee->getFeeConcessionByAppNo($std->row_id, $year);
                    $display_concession = ($concession_amt > 0) ? (float)$concession_amt : 0;
                    // Pending balance
                    $pending_bal = $total_fee_amount - $paid_amt - $display_concession;
                    if ($pending_bal > 0) {
                        // Accumulate totals only for students with pending balance
                        $Total_Amt        += $total_fee_amount;
                        $Total_Fee_Paid   += $paid_amt;
                        $total_concession += $display_concession;
                        $pending_total    += $pending_bal;
                    ?>
                        <tr>
                            <td style="border: 1px solid black;text-align: center;"><?php echo $j++; ?></td>
                            <td style="border: 1px solid black;text-align: center;"><?php echo $std->student_id; ?></td>
                            <td style="border: 1px solid black;text-align: center;"><?php echo strtoupper($std->student_name); ?></td>
                            <td style="border: 1px solid black;text-align: center;"><?php echo $std->stream_name; ?></td>
                            <td style="border: 1px solid black;text-align: center;"><?php echo number_format($total_fee_amount, 2); ?></td>
                            <td style="border: 1px solid black;text-align: center;"><?php echo number_format($paid_amt, 2); ?></td>
                            <td style="border: 1px solid black;text-align: center;"><?php echo number_format($display_concession, 2); ?></td>
                            <td style="border: 1px solid black;text-align: center;"><?php echo number_format($pending_bal, 2); ?></td>
                            <td style="border: 1px solid black;text-align: center;"><?php echo $std->father_mobile; ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            <?php } else {
                $studentInfo = $student->getAllStudentInfo_II_PUC_For_Fee_report($term_name, $stream_name, $year);
                foreach ($studentInfo as $std) {
                    $filter['fee_year']    = $year;
                    $filter['term_name']   = 'II PUC';
                    $filter['stream_name'] = $std->stream_name;
                    $filter['gender']       = $std->gender;
                    // Total fee: base + govt fee

                    $filter['student_fee_type'] = 'REG';

                    if($std->intake_year_id == FEE_YEAR){
                        $filter['student_fee_type'] = 'NEW';
                    }else{
                        $filter['student_fee_type'] = 'REG';
                    }
                    
                    $total_fee_obj    = $fee->getTotalFeeAmount($filter);
                    $depart_fee       = $fee->getGovtFeeAmount($filter);
                    $total_fee_amount = (float)$total_fee_obj->total_fee + (float)$depart_fee;
                    // Paid amount
                    $total_paid_obj = $fee->getFeePaidInfoForReport($std->row_id, $year);
                    $paid_amt = ($total_paid_obj->paid_amount != '')
                        ? (float)$total_paid_obj->paid_amount
                        : 0;
                    // Concession
                    $concession_amt     = $fee->getFeeConcessionByAppNo($std->row_id, $year);
                    $display_concession = ($concession_amt > 0) ? (float)$concession_amt : 0;
                    // Pending balance
                    $pending_bal = $total_fee_amount - $paid_amt - $display_concession;
                    if ($pending_bal > 0) {
                        // Accumulate totals only for students with pending balance
                        $Total_Amt        += $total_fee_amount;
                        $Total_Fee_Paid   += $paid_amt;
                        $total_concession += $display_concession;
                        $pending_total    += $pending_bal;
                    ?>
                        <tr>
                            <td style="border: 1px solid black;text-align: center;"><?php echo $j++; ?></td>
                            <td style="border: 1px solid black;text-align: center;"><?php echo $std->student_id; ?></td>
                            <td style="border: 1px solid black;text-align: center;"><?php echo strtoupper($std->student_name); ?></td>
                            <td style="border: 1px solid black;text-align: center;"><?php echo $std->stream_name; ?></td>
                            <td style="border: 1px solid black;text-align: center;"><?php echo number_format($total_fee_amount, 2); ?></td>
                            <td style="border: 1px solid black;text-align: center;"><?php echo number_format($paid_amt, 2); ?></td>
                            <td style="border: 1px solid black;text-align: center;"><?php echo number_format($display_concession, 2); ?></td>
                            <td style="border: 1px solid black;text-align: center;"><?php echo number_format($pending_bal, 2); ?></td>
                            <td style="border: 1px solid black;text-align: center;"><?php echo $std->father_mobile; ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <!-- TOTAL row -->
            <tr>
                <td style="border: 1px solid black;"></td>
                <td style="border: 1px solid black;"></td>
                <td style="border: 1px solid black;"></td>
                <td style="border: 1px solid black;text-align: center;"><b>TOTAL</b></td>
                <td style="border: 1px solid black;text-align: center;"><b><?php echo number_format($Total_Amt, 2); ?></b></td>
                <td style="border: 1px solid black;text-align: center;"><b><?php echo number_format($Total_Fee_Paid, 2); ?></b></td>
                <td style="border: 1px solid black;text-align: center;"><b><?php echo number_format($total_concession, 2); ?></b></td>
                <td style="border: 1px solid black;text-align: center;"><b><?php echo number_format($pending_total, 2); ?></b></td>
                <td style="border: 1px solid black;"></td>
            </tr>
        </table>
    </div>
</div>