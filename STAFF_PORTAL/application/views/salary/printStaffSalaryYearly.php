
<style>
body {
    font-family: sans-serif;
    font-size: 9px; 
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    page-break-inside: avoid;
}
th, td {
    border: 1px solid #000;
    padding: 3px;
    text-align: right; 
}
th {
    background-color: #f0f0f0; 
    font-weight: bold;
    text-align: center;
}
.title {
    text-align: center;
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 5px;
    text-transform: uppercase;
}
.staff-header {
    font-weight: bold;
    margin-bottom: 5px;
    font-size: 11px;
    text-transform: uppercase;
    text-align: left;
}
.text-center { text-align: center !important; }
</style>

<div class="title">
    ANNUAL SALARY TDS STATEMENT - APRIL <?php echo $salary_year; ?> TO MARCH <?php echo ($salary_year + 1); ?>
</div>

<?php 
if (!empty($staffSalaryInfo)) {
    // Group data by staff_id
    $groupedData = [];
    foreach ($staffSalaryInfo as $row) {
        $groupedData[$row->staff_id][] = $row;
    }

    foreach ($groupedData as $staffId => $records) {
        // Calculate totals for this staff
        $t_basic = 0; $t_da = 0; $t_hra = 0; $t_cca = 0; $t_special = 0;
        $t_earnings = 0; $t_lic = 0; $t_pf = 0; $t_pt = 0; $t_tds = 0; $t_deductions = 0; $t_other_deductions = 0;
        
        $staffName = isset($records[0]->staff_name) ? $records[0]->staff_name : '';
?>
    <div class="staff-header">
        <?php echo $staffName . ' - ' . $staffId; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th width="80">Month</th>
                <th>Basic Salary</th>
                <th>D.A.</th>
                <th>HRA</th>
                <th>CCA</th>
                <th>Special Allowance</th>
                <th>Total Earnings</th>
                <th>LIC</th>
                <th>PF</th>
                <th>P.T.</th>
                <!-- <th>Other Deductions</th> -->
                <th>IncomeTax TDS</th>
                <th>Total Deductions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($records as $row) { 
                // Map columns
                $basic = $row->basic;
                $da = $row->da;
                $hra = isset($row->hr) ? $row->hr : (isset($row->hra) ? $row->hra : 0);
                $cca = $row->cca;
                $special = $row->others; // Mapping 'others' (earnings) to Special Allowance
                $gross = $row->gross_salary;
                
                // Deductions
                $lic = isset($row->lic_deduct) ? $row->lic_deduct : 0; // Assuming LIC deduction
                $pf = $row->pf;
                $pt = $row->pt;
                //log_message('debug','pt VALUE: '.print_r($pt, true));

                $tds = $row->it_deduct;
               // $other_deductions = $row->other_deduct;
                //log_message('debug','TDS VALUE: '.print_r($tds, true));
                // $total_deduct = $row->total_deduction;
                $total_deduct = $lic + $pf + $pt + $tds;

                // Accumulate totals
                $t_basic += $basic;
                $t_da += $da;
                $t_hra += $hra;
                $t_cca += $cca;
                $t_special += $special;
                $t_earnings += $gross;
                $t_lic += $lic;
                $t_pf += $pf;
                $t_pt += $pt;
                $t_tds += $tds;
               // $t_other_deductions += $other_deductions;
                // $t_deductions += $total_deduct;
                $t_deductions = $t_lic + $t_pf + $t_pt + $t_tds;
            ?>
            <tr>
                <td class="text-left" style="text-align: left;"><?php echo $row->month; ?></td>
                <td><?php echo number_format($basic, 0, '.', ''); ?></td>
                <td><?php echo number_format($da, 0, '.', ''); ?></td>
                <td><?php echo number_format($hra, 0, '.', ''); ?></td>
                <td><?php echo number_format($cca, 0, '.', ''); ?></td>
                <td><?php echo number_format($special, 0, '.', ''); ?></td>
                <td><?php echo number_format($gross, 0, '.', ''); ?></td>
                <td><?php echo number_format($lic, 0, '.', ''); ?></td>
                <td><?php echo number_format($pf, 0, '.', ''); ?></td>
                <td><?php echo number_format($pt, 0, '.', ''); ?></td>
                <!-- <td><?php //echo number_format($other_deductions, 0, '.', ''); ?></td> -->
                <td><?php echo ($tds > 0) ? number_format($tds, 0, '.', '') : '-'; ?></td>
                <td><?php echo number_format($total_deduct, 0, '.', ''); ?></td>
            </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr style="font-weight: bold; background-color: #f0f0f0;">
                <td style="text-align: right;"></td>
                <td><b><?php echo number_format($t_basic, 0, '.', ''); ?></b></td>
                <td><b><?php echo number_format($t_da, 0, '.', ''); ?></b></td>
                <td><b><?php echo number_format($t_hra, 0, '.', ''); ?></b></td>
                <td><b><?php echo number_format($t_cca, 0, '.', ''); ?></b></td>
                <td><b><?php echo number_format($t_special, 0, '.', ''); ?></b></td>
                <td><b><?php echo number_format($t_earnings, 0, '.', ''); ?></b></td>
                <td><b><?php echo number_format($t_lic, 0, '.', ''); ?></b></td>
                <td><b><?php echo number_format($t_pf, 0, '.', ''); ?></b></td>
                <td><b><?php echo number_format($t_pt, 0, '.', ''); ?></b></td>
                <!-- <td><?php //echo number_format($t_other_deductions, 0, '.', ''); ?></td> -->
                <td><b><?php echo number_format($t_tds, 0, '.', ''); ?></b></td>
                <td><b><?php echo number_format($t_deductions, 0, '.', ''); ?></b></td>
            </tr>
        </tfoot>
    </table>
    <br/>
<?php 
    } // End foreach group
} else { ?>
    <div style="text-align:center; padding: 20px;">No records found</div>
<?php } ?>

