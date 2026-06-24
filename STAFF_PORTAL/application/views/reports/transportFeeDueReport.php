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
<div class="sub-title"><?php echo $term_name; ?> TRANSPORT FEE DUE REPORT - <?php echo $year; ?></div>
<table>
    <thead>
        <tr>
            <th>SL No</th>
            <th>Application No</th>
            <th>Name</th>
            <th>Stream</th>
            <th>Total Amt.</th>
            <th>Paid Amt.</th>
            <th>Pending Amt.</th>
            <th>Concession</th>
            <th>Route</th>
            <th>Bus No.</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $sl_number = 1;
    if (!empty($student)) {
        foreach ($student as $std) {
            if($term_name == 'II PUC'){
                $routeInfo = $transport->getStudentTransportRateInfoForReport($std->route_id_II, $year, $bus_no);
            } else {
                $routeInfo = $transport->getStudentTransportRateInfoForReport($std->route_id, $year, $bus_no);
            }
            $total_fee = $routeInfo ? $routeInfo->rate : 0;
            $feePaidInfo = $transport->getTransportTotalPaidAmount($std->row_id, $year);
            $paid_amt = !empty($feePaidInfo->paid_amount) ? $feePaidInfo->paid_amount : 0;
            $pending_bal = $total_fee - $paid_amt;
            $BusfeeConcession = $transport->getFeeConcessionInfo($std->row_id, $year);
            $concession_amt = !empty($BusfeeConcession->fee_amt) ? $BusfeeConcession->fee_amt : 0;
            $pending_bal -= $concession_amt;
            echo '<tr>';
            echo '<td>' . $sl_number . '</td>';
            echo '<td>' . htmlspecialchars($std->student_id) . '</td>';
            echo '<td>' . htmlspecialchars($std->student_name) . '</td>';
            echo '<td>' . htmlspecialchars($std->stream_name) . '</td>';
            echo '<td>' . htmlspecialchars($total_fee) . '</td>';
            echo '<td>' . htmlspecialchars($paid_amt) . '</td>';
            echo '<td>' . htmlspecialchars($pending_bal) . '</td>';
            echo '<td>' . htmlspecialchars($concession_amt) . '</td>';
            echo '<td>' . ($routeInfo ? htmlspecialchars($routeInfo->pickup_point_name) : '') . '</td>';
            echo '<td>' . ($routeInfo ? htmlspecialchars($routeInfo->route_name) : '') . '</td>';
            echo '</tr>';
            $sl_number++;
        }
    } else {
        echo '<tr><td colspan="10">No data available</td></tr>';
    }
    ?>
    </tbody>
</table>