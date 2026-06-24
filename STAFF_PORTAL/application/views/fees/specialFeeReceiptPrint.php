<style>
    table { width: 100% !important; border-collapse: collapse; }
    .border_full { border: 1px solid black; }
    th, td { padding: 3px; font-size: 12px; }
</style>

<?php
$isCash = (strtoupper($feeInfo->payment_type) === 'CASH');

if (!function_exists('resolveTransactionId')) {
    function resolveTransactionId($obj) {
        if ($obj->payment_type == 'DD' && !empty($obj->dd_number))
            return $obj->dd_number;

        if (in_array($obj->payment_type, ['CARD', 'BANK', 'UPI','NEFT']) && !empty($obj->transaction_number))
            return $obj->transaction_number;

        return !empty($obj->order_id) ? $obj->order_id : '';
    }
}
$transaction_id = resolveTransactionId($feeInfo);
?>

<div class="border_full">

    <!-- HEADER -->
    <table>
        <tr>
            <td width="12%" style="text-align:center;">
                <img width="30" src="<?php echo INSTITUTION_LOGO; ?>">
            </td>
            <td width="88%" style="text-align:center;">
                <b><?php echo FEES_TITLE; ?></b><br>
                <b><?php echo FEES_ADDRESS; ?></b>
            </td>
        </tr>
    </table>

    <!-- RECEIPT INFO -->
    <table>
        <tr>
            <th style="border-top:1px solid black; text-align:left;">
                &nbsp;Receipt No : 
            </th>
            <th style="border-top:1px solid black; text-align:left;">
                Date : 
            </th>
        </tr>
        <tr>
            <th style="text-align:left;">
                &nbsp;Student : <?php echo strtoupper($studentInfo->student_name ?? ''); ?>
            </th>
            <th style="text-align:left;">
                Class : <?php echo ($term == 'II PUC') ? 'II PUC' : 'I PUC'; ?>
            </th>
        </tr>
        <tr>
            <th style="text-align:left;">
                &nbsp;App No. / Stud Id. : <?php echo $studentInfo->application_no . ' / ' . $studentInfo->student_id; ?>
            </th>
            <th style="text-align:left;">
                Stream : <?php 
                    $comb = strtoupper($studentInfo->stream_name);
                    echo $comb;
                ?>
            </th>
        </tr>
        <tr>
            <th style="text-align:left;">
                &nbsp;Payment Mode : <?php echo strtoupper($feeInfo->payment_type); ?>
            </th>
            <th style="text-align:left;">
                <?php if (!$isCash): ?>
                    Transaction Id : <?php echo $transaction_id; ?>
                <?php endif; ?>
            </th>
        </tr>
    </table>

    <!-- SPECIAL FEES TABLE -->
    <table>
        <thead>
            <tr>
                <th width="10%" style="text-align:center; border-top:1px solid black;">Sl.No.</th>
                <th width="70%" style="text-align:center; border-top:1px solid black;">Particulars of Fees</th>
                <th width="20%" style="text-align:center; border-top:1px solid black;">Rs.</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($fee_rows)): ?>
                <?php $i = 1; foreach ($fee_rows as $row): ?>
                <tr>
                    <td style="text-align:center;"><?php echo $i++; ?></td>
                    <td>&nbsp;<?php echo $row['name']; ?></td>
                    <td style="text-align:right;">&nbsp;<?php echo number_format($row['amount'], 2); ?>&nbsp;</td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="text-align:center;">No fee records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" style="text-align:center; border-top:1px solid black;">Total</th>
                <th style="text-align:right; border-top:1px solid black;">
                    <?php echo number_format($total_fee_amt, 2); ?>&nbsp;
                </th>
            </tr>
            <tr>
                <td colspan="2" style="text-align:left; padding-top:20px;">
                    Amount in words :
                    <strong><?php echo strtoupper($paid_amount_words); ?> ONLY</strong>
                </td>
                <td style="text-align:center; padding-top:50px;">&nbsp;&nbsp;&nbsp;&nbsp;Signature</td>
            </tr>
        </tfoot>
    </table>

</div>