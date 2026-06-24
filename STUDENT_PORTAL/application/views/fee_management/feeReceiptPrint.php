<style>
table { width: 100% !important; }
.border_full   { border: 1px solid black; }
.border_bottom { border-bottom: 1px solid black; }
.hr_line       { margin: 3px 0px; color: black; }
.table_bordered { border-collapse: collapse; }
.table_bordered th,
.table_bordered td {
    border-top: 1px solid black;
    border-right: 1px solid black;
    padding: 2px;
}
.centered-td { text-align: center !important; }
</style>

<?php
/* ── Transaction ID helper ───────────────────────── */
function resolveTransactionId($obj) {
    if ($obj->payment_type == 'DD')
        return $obj->dd_number ?? '-';
    if (in_array($obj->payment_type, ['CARD','BANK','UPI']))
        return $obj->transaction_number ?? '-';
    return $obj->order_id ?? '-';
}

$transaction_id = resolveTransactionId($feeInfo);

/* ── Header ───────────────────────── */
function renderCollegeHeader() { ?>
    <table>
        <tr>
            <td style="text-align:center;" width="12%">
                <img width="55" height="55" src="<?php echo INSTITUTION_LOGO; ?>">
            </td>
            <td width="88%" style="text-align:center;">
                <b style="font-size:16px;"><?php echo FEES_TITLE; ?></b><br/>
                <b style="font-size:11px;"><?php echo FEES_ADDRESS; ?></b><br/>
            </td>
        </tr>
    </table>
    <hr class="border_bottom hr_line"><br>
<?php }
?>

<div class="container-fluid border_full">
<div>

<?php renderCollegeHeader(); ?>

<table style="font-size:11.5px; width:100%;">
<tr>
    <td colspan="6" class="centered-td" style="font-size:15px;">
        <b><u>FEE RECEIPT</u></b>
    </td>
</tr>

<tr>
    <td>Name of Student</td><td>:</td>
    <td><b><?php echo strtoupper($studentInfo->student_name); ?></b></td>

    <td>Date</td><td>:</td>
    <td><b><?php echo date('d-m-Y', strtotime($feeInfo->payment_date)); ?></b></td>
</tr>

<tr>
    <td>Father Name</td><td>:</td>
    <td><b><?php echo $studentInfo->father_name; ?></b></td>

    <!-- <td>Receipt No</td><td>:</td>
    <td><b><?php //echo $feeInfo->receipt_number ?? $feeInfo->row_id; ?></b></td> -->
</tr>

<tr>
    <td>Class & Stream</td><td>:</td>
    <td><b><?php echo strtoupper($feeInfo->term_name . ' ' . $studentInfo->stream_name); ?></b></td>

    <td>App No / ID</td><td>:</td>
    <td><b><?php echo $studentInfo->application_no . ' / ' . $studentInfo->student_id; ?></b></td>
</tr>

<tr>
    <td>Payment Mode</td><td>:</td>
    <td><b><?php echo $feeInfo->payment_type ?? 'ONLINE'; ?></b></td>

    <td>Transaction ID</td><td>:</td>
    <td><b><?php echo $transaction_id; ?></b></td>
</tr>

</table>

<!-- Fee Table -->
<table class="table table_bordered" style="font-size:12px;">
<tr>
    <th width="65%">Particulars</th>
    <th style="text-align:center;">Amount (Rs.)</th>
</tr>

<tr>
    <td style="text-align:center;">
     Course Fee
    </td>
    <td style="text-align:right;">
        <?php echo number_format($feeInfo->paid_amount ?? 0, 2); ?>
    </td>
</tr>

<tr>
    <th>Amount Paid</th>
    <th style="text-align:right;">
        <?php echo number_format($feeInfo->paid_amount ?? 0, 2); ?>
    </th>
</tr>

<tr>
    <th>Amount Pending</th>
    <th style="text-align:right;">
        <?php echo number_format($feeInfo->pending_balance ?? 0, 2); ?>
    </th>
</tr>

<tr>
    <td colspan="2">
        Amount in words :
        <b>
        <?php echo strtoupper($paid_amount_words ?? ''); ?> ONLY
        </b>
    </td>
</tr>

</table>

<!-- Signature -->
<?php if (strtoupper($feeInfo->payment_type) != 'ONLINE'): ?>
<table style="width:100%;margin-top:50px;">
<tr>
    <td style="width:70%;"></td>
    <td style="width:30%;text-align:center;">
        <div style="border:1px solid black;height:60px;"></div>
        (Cashier)
    </td>
</tr>
</table>
<?php else: ?>
<p style="font-size:10px;text-align:center;">
    This is a computer-generated receipt. No signature required.
</p>
<?php endif; ?>

</div>
</div>