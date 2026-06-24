<?php
ini_set('memory_limit', '1024M');
ini_set("pcre.backtrack_limit", "5000000");
ini_set('max_execution_time', -1);
?>
<style>
.break { page-break-before: always; } 
.break_after { page-break-before: none; } 
table{
    width: 100% !important;
}
u {    
    border-bottom: 2px dotted #00000;
    text-decoration: none;
    font-weight: bold;
    font-family:timesnewroman;
    font-size:16px;
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
    margin: 0px;
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
    <div class="container-fluid border_full" style="padding-right:0px; padding-left:0px;">
    <div class="row">
        <table style="width:100%;border-collapse:collapse;font-size:10px;">
                <?php
                    $reportFeeType = strtoupper(trim((string)$fee_type));
                    $feeStructureName = $fee->getFeeStructureName($reportFeeType);
                    $tableColspan = 12 + count($feeStructureName);
                    $totalFeeTypeAmount = array();
                    foreach ($feeStructureName as $name) {
                        $totalFeeTypeAmount[$name->row_id] = 0;
                    }
                ?>
            <tr>
                <th style="border:1px solid black;text-align:center;" colspan="<?php echo $tableColspan; ?>"><?php echo EXCEL_TITLE; ?></th>
            </tr>
            <tr>
                <th style="border:1px solid black;text-align:center;" colspan="<?php echo $tableColspan; ?>"><?php echo $reportFeeType; ?> Bifurcation Fee Report - <?php echo $fees_year; ?></th>
            </tr>
            <tr>
                <!-- A --> <th style="border:1px solid black;text-align:center;">SL No.</th>
                <!-- B --> <th style="border:1px solid black;text-align:center;">Name</th>
                <!-- C --> <th style="border:1px solid black;text-align:center;">Term</th>
                <!-- D --> <th style="border:1px solid black;text-align:center;">Stream</th>
                <!-- E --> <th style="border:1px solid black;text-align:center;">Section</th>
                <!-- F --> <th style="border:1px solid black;text-align:center;">Student Id.</th>
                <!-- G --> <th style="border:1px solid black;text-align:center;">Receipt No.</th>
                <!-- H --> <th style="border:1px solid black;text-align:center;">Payment Date</th>
                <!-- I --> <th style="border:1px solid black;text-align:center;">Payment Mode</th>
                <!-- J --> <th style="border:1px solid black;text-align:center;">Transaction ID</th>
                <!-- K --> <th style="border:1px solid black;text-align:center;">Transaction Date</th>
                <?php foreach ($feeStructureName as $name) { ?>
                <th style="border:1px solid black;text-align:center;"><?php echo $name->fee_name; ?></th>
                <?php } ?>
                <!-- L --> <th style="border:1px solid black;text-align:center;">Amount Paid</th>
            </tr>
            <?php
            $filter = array();
            $j = 1;
            if ($date_from != '') {
                $filter['date_from'] = date('Y-m-d', strtotime($date_from));
            } else {
                $filter['date_from'] = '';
            }
            if ($date_to != '') {
                $filter['date_to'] = date('Y-m-d', strtotime($date_to));
            } else {
                $filter['date_to'] = '';
            }
            $filter['year'] = $year;
            if ($payment_type[0] == 'ALL') {
                $filter['payment_type'] = '';
            } else {
                $filter['payment_type'] = $payment_type;
            }
            $filter['term_name'] = $term_name;
            $total_amount_paid = 0;
            $studentInfo = $fee->getManagementFeeForReport($filter);
            foreach ($studentInfo as $std) {
                $term_name    = $std->term_name;
                $stdInfo      = $student->getStudentInfoByRowId($std->application_no);
                $section_name = $stdInfo->section_name;
                // Transaction Date — same logic as Excel controller
                if ($std->payment_type == 'DD') {
                    $transaction_date = $std->dd_date;
                } else if (in_array($std->payment_type, ['CARD', 'BANK', 'UPI', 'NEFT'])) {
                    $transaction_date = $std->transaction_date;
                } else if ($std->payment_type == 'ONLINE') {
                    $transaction_date = $std->payment_date;
                } else {
                    $transaction_date = '';
                }
                if (!empty($transaction_date) && $transaction_date != '1970-01-01' && $transaction_date != '0000-00-00') {
                    $transaction_date = date('d-m-Y', strtotime($transaction_date));
                } else {
                    $transaction_date = '';
                }
                // Transaction ID — same logic as Excel controller
                if (in_array($std->payment_type, ['CARD', 'BANK', 'UPI', 'NEFT'])) {
                    $transaction_id = $std->transaction_number;
                } else if ($std->payment_type == 'DD') {
                    $transaction_id = $std->dd_number;
                } else if ($std->payment_type == 'ONLINE') {
                    $transaction_id = $std->order_id;
                } else {
                    $transaction_id = '';
                }
                $row_total_amount = 0;
                $rowFeeTypeAmount = array();
                $receipt_number = $std->receipt_number;
                foreach ($feeStructureName as $name) {
                    $feePaidStructure = $fee->getFeeReceiptPrintInfoReport($std->row_id, $std->application_no, $name->row_id);
                    $paid_amount = 0;
                    if (!empty($feePaidStructure)) {
                        foreach ($feePaidStructure as $info) {
                            $paid_amount += (float)$info->paid_amount;
                            if (!empty($info->receipt_no)) {
                                $receipt_number = $info->receipt_no;
                            }
                        }
                    }
                    $rowFeeTypeAmount[$name->row_id] = abs($paid_amount);
                    $row_total_amount += abs($paid_amount);
                }
                if ($reportFeeType == 'CONTRIBUTION FEE' && $row_total_amount <= 0) {
                    continue;
                }
            ?>
            <tr>
                <!-- A --> <td style="border:1px solid black;text-align:center;"><?php echo $j++; ?></td>
                <!-- B --> <td style="border:1px solid black;text-align:center;"><?php echo strtoupper($stdInfo->student_name); ?></td>
                <!-- C --> <td style="border:1px solid black;text-align:center;"><?php echo $term_name; ?></td>
                <!-- D --> <td style="border:1px solid black;text-align:center;"><?php echo $stdInfo->stream_name; ?></td>
                <!-- E --> <td style="border:1px solid black;text-align:center;"><?php echo $section_name; ?></td>
                <!-- F --> <td style="border:1px solid black;text-align:center;"><?php echo $stdInfo->student_id; ?></td>
                <!-- G --> <td style="border:1px solid black;text-align:center;"><?php echo $receipt_number; ?></td>
                <!-- H --> <td style="border:1px solid black;text-align:center;"><?php echo date('d-m-Y', strtotime($std->payment_date)); ?></td>
                <!-- I --> <td style="border:1px solid black;text-align:center;"><?php echo $std->payment_type; ?></td>
                <!-- J --> <td style="border:1px solid black;text-align:center;"><?php echo $transaction_id; ?></td>
                <!-- K --> <td style="border:1px solid black;text-align:center;"><?php echo $transaction_date; ?></td>
                <?php
                    foreach ($feeStructureName as $name) {
                        $paid_amount = isset($rowFeeTypeAmount[$name->row_id]) ? $rowFeeTypeAmount[$name->row_id] : 0;
                        $totalFeeTypeAmount[$name->row_id] += $paid_amount;
                ?>
                <td style="border:1px solid black;text-align:center;"><?php echo number_format($paid_amount, 2); ?></td>
                <?php } ?>
                <!-- L --> <td style="border:1px solid black;text-align:center;"><?php echo number_format($row_total_amount, 2); ?></td>
            </tr>
            <?php
                $total_amount_paid += $row_total_amount;
            }
            ?>
            <!-- Totals Row — same as Excel: TOTAL in K, amount in L -->
            <tr>
                <td colspan="11" style="border:1px solid black;text-align:right;font-weight:bold;padding:3px;">TOTAL</td>
                <?php foreach ($feeStructureName as $name) { ?>
                <td style="border:1px solid black;text-align:center;font-weight:bold;"><?php echo number_format(isset($totalFeeTypeAmount[$name->row_id]) ? $totalFeeTypeAmount[$name->row_id] : 0, 2); ?></td>
                <?php } ?>
                <td style="border:1px solid black;text-align:center;font-weight:bold;"><?php echo number_format($total_amount_paid, 2); ?></td>
            </tr>
        </table>
    </div>
</div>