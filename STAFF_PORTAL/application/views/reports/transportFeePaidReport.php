<?php
// ...existing code...
?>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    th, td {
        border: 1px solid #000;
        padding: 6px;
        text-align: center;
    }
    th {
        background: #E5E4E2;
        font-weight: bold;
        font-size: 15px;
    }
    .header-title {
        font-size: 18px;
        font-weight: bold;
        text-align: center;
        padding: 10px 0;
    }
    .sub-title {
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        padding: 6px 0;
    }
</style>
<div class="header-title"><?php echo EXCEL_TITLE; ?></div>
<div class="sub-title"><?php echo $term_name; ?> TRANSPORT FEE PAID REPORT - <?php echo $year; ?></div>
<table>
    <thead>
        <tr>
            <th>SL No</th>
            <th>Application No</th>
            <th>Name</th>
            <th>Stream</th>
            <th>Paid Amt.</th>
            <th>Month</th>
            <th>Route</th>
            <th>Bus No.</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $sl_number = 1;
    if (!empty($student)) {
        foreach ($student as $std) {
            $status = ($std->discontinued_status == 1) ? 'INACTIVE' : 'ACTIVE';
            $months = [
                1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
            ];
            $monthNumber = $std->month;
            $monthName = isset($months[$monthNumber]) ? $months[$monthNumber] : '';
            $route_id = ($term_name == 'II PUC') ? $std->route_id_II : $std->route_id;
            $routeInfo = $transport->getStudentTransportRateInfo($route_id, $year);
            $total_fee_amount = $routeInfo ? $routeInfo->rate : 0;
            $paid_amt = 0;
            $feePaidInfo = $transport->getTransportTotalPaidAmount($std->student_row_id, $year);
            if (!empty($feePaidInfo->paid_amount)) {
                $paid_amt = $feePaidInfo->paid_amount;
            }
            $feeConcession = $transport->getFeeConcessionInfo($std->student_row_id, $year);
            $total_concession = !empty($feeConcession) ? $feeConcession->fee_amt : 0;
            $pending_bal = $total_fee_amount - $paid_amt - $total_concession;
            $show = false;
            if ($payment_type == 'FULL_PAYMENT') {
                if ($pending_bal <= 0) $show = true;
            } else if ($payment_type == 'HALF_PAYMENT') {
                if ($pending_bal < $total_fee_amount && $pending_bal > 0) $show = true;
            } else if ($payment_type == 'NOT_PAID') {
                if ($paid_amt == 0 && $status == 'ACTIVE') $show = true;
            } else if ($payment_type == 'PENDING') {
                if ((($pending_bal < $total_fee_amount && $pending_bal > 0 && $status == 'ACTIVE') || ($paid_amt == 0 && $status == 'ACTIVE'))) $show = true;
            } else {
                $show = true;
            }
            if ($show) {
                echo '<tr>';
                echo '<td>' . $sl_number . '</td>';
                echo '<td>' . htmlspecialchars($std->student_id) . '</td>';
                echo '<td>' . htmlspecialchars($std->student_name) . '</td>';
                echo '<td>' . htmlspecialchars($std->stream_name) . '</td>';
                echo '<td>' . htmlspecialchars($std->amount) . '</td>';
                echo '<td>' . htmlspecialchars($monthName) . '</td>';
                echo '<td>' . ($routeInfo ? htmlspecialchars($routeInfo->pickup_point_name) : '') . '</td>';
                echo '<td>' . ($routeInfo ? htmlspecialchars($routeInfo->route_name) : '') . '</td>';
                echo '<td>' . $status . '</td>';
                echo '</tr>';
                $sl_number++;
            }
        }
    } else {
        echo '<tr><td colspan="9">No data available</td></tr>';
    }
    ?>
    </tbody>
</table>
