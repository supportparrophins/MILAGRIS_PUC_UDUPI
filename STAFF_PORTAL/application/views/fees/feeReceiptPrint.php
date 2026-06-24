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
.page-break { page-break-before: always; break-before: page; }

@media print {
    .page-break { page-break-before: always; break-before: page; }
}
</style>
<?php
/* ── Transaction ID helper ───────────────────────────────────────── */
function resolveTransactionId($obj) {
    if ($obj->payment_type == 'DD')
        return $obj->dd_number;
    if (in_array($obj->payment_type, ['CARD','BANK','UPI','NEFT']))
        return $obj->transaction_number;
    return $obj->order_id;
}
$transaction_id = resolveTransactionId($feeInfo);
/* ── Shared header block (reused on both pages) ──────────────────── */
function renderCollegeHeader() { ?>
    <table class="table" style="line-height:1.0;">
        <tr>
            <td style="text-align:center;" width="12%">
                <img width="55" height="55" src="<?php echo INSTITUTION_LOGO; ?>" alt="logo">
            </td>
            <td width="88%" style="text-align:center;">
                <b style="font-size:16px;"><?php echo FEES_TITLE; ?></b><br/>
                <b style="font-size:11px;"><?php echo FEES_ADDRESS; ?></b><br/>
                <?php //if (!empty(SCHOOL_CODE)): ?>
                <!-- <b style="font-size:11px;">College Code – <?php //echo SCHOOL_CODE; ?></b><br/> -->
                <?php //endif; ?>
            </td>
        </tr>
    </table>
    <hr class="border_bottom hr_line"><br>
<?php }
?>
<?php
/* ════════════════════════════════════════════════════════════════════
   PAGE 1 — GOVERNMENT / PU BOARD FEES
   Rendered ONLY if the student paid at least one government fee
   in this receipt (filtering already done in controller).
   ════════════════════════════════════════════════════════════════════ */
if ($showGovPage): ?>
<div class="container-fluid border_full">
  <div class="row"><div class="">
    <?php renderCollegeHeader(); ?>
    <?php $isCash = ($feeInfo->payment_type === 'CASH'); $os = $isCash ? 0 : 0; ?>
    <table style="font-size:11.5px;line-height:1.1;margin-top:2px;width:100%;table-layout:auto;">
    <tr>
        <td colspan="9" class="centered-td" style="font-size:15px;">
            <b><u>FEE RECEIPT</u></b>
        </td>
    </tr>
    <tr>
        <td style="white-space:nowrap;">1. Name of the Student</td>
        <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td style="white-space:nowrap;padding-right:100px;"><b><?php echo strtoupper($studentInfo->student_name); ?></b></td>
        <td style="white-space:nowrap;"><?php echo (5+$os); ?>. Payment Received Date</td>
        <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td><b><?php echo date('d-m-Y', strtotime($feeInfo->payment_date)); ?></b></td>
    </tr>
    <tr>
        <td style="white-space:nowrap;">2. Father Name</td>
        <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td style="white-space:nowrap;padding-right:100px;"><b><?php echo $studentInfo->father_name; ?></b></td>
        <td style="white-space:nowrap;"><?php echo (6+$os); ?>. Receipt No.</td>
        <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td><b><?php echo $govReceiptNo; ?></b></td>
    </tr>
    <tr>
        <!-- <td style="white-space:nowrap;">3. Mother Name</td>
        <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td style="white-space:nowrap;padding-right:100px;"><b><?php //echo $studentInfo->mother_name; ?></b></td> -->
        <td style="white-space:nowrap;">3. Class &amp; Stream</td>
        <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td style="white-space:nowrap;padding-right:100px;"><b><?php echo strtoupper($feeInfo->term_name . ' ' . $studentInfo->stream_name); ?></b></td>
        <td style="white-space:nowrap;"><?php echo (7+$os); ?>. App No. / Stud Id.</td>
        <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td><b><?php echo $studentInfo->application_no . ' / ' . $studentInfo->student_id; ?></b></td>
    </tr>
    <?php if (!$isCash): ?>
    <tr>
        <td style="white-space:nowrap;">4. Payment Mode</td>
        <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td><b><?php echo !empty($feeInfo->payment_type) ? $feeInfo->payment_type : 'Online'; ?></b></td>
        <!-- <td style="white-space:nowrap;">5. Gender</td>
        <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td style="white-space:nowrap;padding-right:100px;"><b><?php //echo $studentInfo->gender; ?></b></td> -->
        <td style="white-space:nowrap;"><?php echo (8+$os); ?>. Transaction Id</td>
        <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td><b><?php echo $transaction_id; ?></b></td>
    </tr>
    <?php else: ?>
    <tr>
        <td style="white-space:nowrap;">4. Payment Mode</td>
        <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td><b><?php echo !empty($feeInfo->payment_type) ? $feeInfo->payment_type : 'Online'; ?></b></td>
        <!-- <td style="white-space:nowrap;">5. Gender</td>
        <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td style="white-space:nowrap;padding-right:100px;"><b><?php //echo $studentInfo->gender; ?></b></td> -->
        <td colspan="3"></td>
    </tr>
    <?php endif; ?>
    </table>
    <!-- Fee rows — already filtered to paid-only by controller -->
    <table class="table table_bordered" style="font-size:12px;line-height:1.2;">
        <tr>
            <th width="65%" style="font-size:12px;">Particulars</th>
            <th style="border-right:none;font-size:12px;text-align:center;">Amount (Rs.)</th>
        </tr>
        <?php foreach ($governmentFeeStructureInfo as $fee): 
            $FeeAmount = $fee_model->getFeeReceiptPrintNameInfo($fee->type_id,$row_id,$feeInfo->application_no);
            if($FeeAmount->paid_amount != 0){
            ?>
        <tr>
            <td><?php echo $fee->fee_name; ?></td>
            <td style="text-align:right;border-right:none;"><?php echo sprintf('%0.2f',$FeeAmount->paid_amount); ?></td>
        </tr>
        <?php } ?>
        <?php endforeach; ?>
        <tr>
            <th style="font-size:12px;">Total Receipt</th>
            <th style="text-align:right;border-right:none;"><?php echo number_format($govPaidAmount, 2); ?></th>
        </tr>
        <!-- <tr>
            <th style="font-size:12px;">Amount Paid</th>
            <th style="text-align:right;border-right:none;"><?php //echo number_format($govPaidAmount, 2); ?></th>
        </tr>
        <tr>
            <th style="font-size:12px;">Amount Pending</th>
            <th style="text-align:right;border-right:none;"><?php //echo number_format($govPending, 2); ?></th>
        </tr> -->
        <tr>
            <td colspan="2" style="border-right:none;font-size:12px;"><br>
                Amount in words : <b><?php echo strtoupper($paid_amount_words_government); ?> ONLY</b>
            </td>
        </tr>
        <!-- <tr>
            <td colspan="2" style="border-right:none;border-top:none;font-size:10px;">
                Date &amp; Time : <?php //echo date('d-m-Y h:i:s A', strtotime($feeInfo->created_date_time)); ?>
            </td>
        </tr> -->
    </table>
  </div></div>
</div>
<!-- <b style="font-size:9px;">All fees paid are not transferable or refundable.</b><br/>
<?php //if (strtoupper($feeInfo->payment_type) == 'ONLINE'){ ?>
<b style="font-size:9px;">This is a computer-generated receipt. No signature is required.</b>
<?php //} ?> -->
<!-- <?php //if ($feeInfo->payment_type == 'Online') { ?>
    <b style="font-size:9px;">
        This is an online generated fee Receipt — no seal and signature required.
    </b>
<?php //} else { ?>
    <b style="font-size:9px;">
        This is a computer-generated receipt. Cash payments require cashier seal and signature.
    </b>
<?php //} ?> -->
<?php if (strtoupper($feeInfo->payment_type) != 'ONLINE'): ?>
<table style="width:100%;margin-top:50px;font-size:11px;">
  <tr>
    <td style="width:70%;"></td>
    <td style="width:30%;text-align:center;">
      <div style="border:1px solid black;height:60px;width:100%;"></div>
      (Cashier)
    </td>
  </tr>
</table>
<?php endif; ?>
<?php endif; /* end showGovPage */ ?>
<br>
<?php /* Page break only when both pages are being printed */
if ($showGovPage && $showMgmtPage): ?>
<div class="page-break"></div>
<?php endif; ?>
<br>
<?php
/* ════════════════════════════════════════════════════════════════════
   PAGE 2 — MANAGEMENT / COLLEGE FEES
   Rendered ONLY if the student paid at least one management fee
   in this receipt (filtering already done in controller).
   ════════════════════════════════════════════════════════════════════ */
if ($showMgmtPage): ?>
<div class="container-fluid border_full">
  <div class="row"><div class="">
    <?php renderCollegeHeader(); ?>
    <!-- Student info -->
    <?php $isCash = ($feeInfo->payment_type === 'CASH'); $os = $isCash ? 0 : 0; ?>
    <table style="font-size:11.5px;line-height:1.1;margin-top:2px;width:100%;table-layout:auto;">
    <tr>
        <td colspan="9" class="centered-td" style="font-size:15px;">
            <b><u>FEE RECEIPT</u></b>
        </td>
    </tr>
    <tr>
        <td style="white-space:nowrap;">1. Name of the Student</td>
        <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td style="white-space:nowrap;padding-right:100px;"><b><?php echo strtoupper($studentInfo->student_name); ?></b></td>
        <td style="white-space:nowrap;"><?php echo (5+$os); ?>. Payment Received Date</td>
        <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td><b><?php echo date('d-m-Y', strtotime($feeInfo->payment_date)); ?></b></td>
    </tr>
    <tr>
        <td style="white-space:nowrap;">2. Father Name</td>
        <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td style="white-space:nowrap;padding-right:100px;"><b><?php echo $studentInfo->father_name; ?></b></td>
        <td style="white-space:nowrap;"><?php echo (6+$os); ?>. Receipt No.</td>
        <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td><b><?php echo $mgmtReceiptNo; ?></b></td>
    </tr>
    <tr>
        <!-- <td style="white-space:nowrap;">3. Mother Name</td> -->
        <!-- <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td style="white-space:nowrap;padding-right:100px;"><b><?php //echo $studentInfo->mother_name; ?></b></td> -->
        <td style="white-space:nowrap;">3. Class &amp; Stream</td>
        <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td style="white-space:nowrap;padding-right:100px;"><b><?php echo strtoupper($feeInfo->term_name . ' ' . $studentInfo->stream_name); ?></b></td>
        <td style="white-space:nowrap;"><?php echo (7+$os); ?>. App No. / Stud Id.</td>
        <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td><b><?php echo $studentInfo->application_no . ' / ' . $studentInfo->student_id; ?></b></td>
    </tr>
    <?php if (!$isCash): ?>
    <tr>
        <td style="white-space:nowrap;">4. Payment Mode</td>
        <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td><b><?php echo !empty($feeInfo->payment_type) ? $feeInfo->payment_type : 'Online'; ?></b></td>
        <!-- <td style="white-space:nowrap;">5. Gender</td>
        <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td style="white-space:nowrap;padding-right:100px;"><b><?php //echo $studentInfo->gender; ?></b></td> -->
        <td style="white-space:nowrap;"><?php echo (8+$os); ?>. Transaction Id</td>
        <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td><b><?php echo $transaction_id; ?></b></td>
    </tr>
    <?php else: ?>
    <tr>
        <td style="white-space:nowrap;">4. Payment Mode</td>
        <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td><b><?php echo !empty($feeInfo->payment_type) ? $feeInfo->payment_type : 'Online'; ?></b></td>
        <!-- <td style="white-space:nowrap;">5. Gender</td>
        <td style="white-space:nowrap;padding:0 4px;">:</td>
        <td style="white-space:nowrap;padding-right:100px;"><b><?php //echo $studentInfo->gender; ?></b></td> -->
        <td colspan="3"></td>
    </tr>
    <?php endif; ?>
    </table>
    <!-- Fee rows — already filtered to paid-only by controller -->
    <table class="table table_bordered" style="font-size:11px;line-height:1.2;">
        <tr>
            <th width="65%" style="font-size:12px;">Particulars</th>
            <th style="border-right:none;font-size:12px;text-align:center;">Amount (Rs.)</th>
        </tr>
        <?php foreach ($managementFeeStructureInfo as $fee): 
            $FeeAmount = $fee_model->getFeeReceiptPrintNameInfo($fee->type_id,$row_id,$feeInfo->application_no);
            ?>
        <tr>
            <td><?php echo $fee->fee_name; ?></td>
            <td style="text-align:right;border-right:none;"><?php echo sprintf('%0.2f',$FeeAmount->paid_amount); ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <th style="font-size:12px;">Total Receipt</th>
            <th style="text-align:right;border-right:none;"><?php echo number_format($mgmtPaidAmount, 2); ?></th>
        </tr>
        <!-- <tr>
            <th style="font-size:12px;">Amount Paid</th>
            <th style="text-align:right;border-right:none;"><?php //echo number_format($mgmtPaidAmount, 2); ?></th>
        </tr>
        <tr>
            <th style="font-size:12px;">Amount Pending</th>
            <th style="text-align:right;border-right:none;"><?php //echo number_format($mgmtPending, 2); ?></th>
        </tr> -->
        <?php if ($showGovPage && $showMgmtPage): ?>
        <tr>
            <th style="font-size:12px;">Grand Total (Receipt 1 + 2)</th>
            <th style="text-align:right;border-right:none;"><?php echo number_format($grandTotal, 2); ?></th>
        </tr>
        <?php endif; ?>
        <tr>
            <td colspan="2" style="border-right:none;font-size:12px;"><br>
                Amount in words : <b><?php echo strtoupper($paid_amount_words_management); ?> ONLY</b>
            </td>
        </tr>
        <!-- <tr>
            <td colspan="2" style="border-right:none;border-top:none;font-size:10px;"> -->
                <!-- Generated By : <b><?php //echo strtoupper($staffName->name); ?></b> -->
                <!-- Date &amp; Time : <?php //echo date('d-m-Y h:i:s A', strtotime($feeInfo->created_date_time)); ?>
            </td>
        </tr> -->
    </table>
  </div></div>
</div>
<!-- <b style="font-size:9px;">All fees paid are not transferable or refundable.</b><br/>
<?php //if (strtoupper($feeInfo->payment_type) == 'ONLINE'){ ?>
<b style="font-size:9px;">This is a computer-generated receipt. No signature is required.</b>
<?php // ?> -->
<!-- <?php //if ($feeInfo->payment_type == 'Online') { ?>
    <b style="font-size:9px;">
        This is an online generated fee Receipt — no seal and signature required.
    </b>
<?php //} else { ?>
    <b style="font-size:9px;">
        This is a computer-generated receipt. Cash payments require cashier seal and signature.
    </b>
<?php //} ?> -->
<?php if (strtoupper($feeInfo->payment_type) != 'ONLINE'): ?>
<table style="width:100%;margin-top:50px;font-size:11px;">
  <tr>
    <td style="width:70%;"></td>
    <td style="width:30%;text-align:center;">
      <div style="border:1px solid black;height:60px;width:100%;"></div>
      (Cashier)
    </td>
  </tr>
</table>
<?php endif; ?>
<?php endif; /* end showMgmtPage */ ?>
