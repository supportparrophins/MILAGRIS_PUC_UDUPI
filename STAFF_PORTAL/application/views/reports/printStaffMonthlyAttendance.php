<?php
 require APPPATH . 'views/includes/db.php'; 
    
 ini_set("pcre.backtrack_limit", "100000000");
 ini_set('memory_limit', '750M')
?>
<style>
    .break {
        page-break-before: always;
    }

    .break_after {
        page-break-before: none;
    }

    table {
        width: 100% !important;
    }

    .text-center {
        text-align: center;
    }
    .text-white {
        color: white;
    }

    .border_full {
        border: 3px solid black;
    }

    .border_bottom {
        border-bottom: 1px solid black;
    }

    .hr_line {
        margin: 0px;
        color: black;
    }

    .table_bordered {
        border-collapse: collapse;
    }

    .table_bordered th,
    .table_bordered td {
        border-top: 1px solid black;
        border-right: 1px solid black;
        padding: 6px;
    }

    .table_bordered th .border_right_none,
    .table_bordered td .border_right_none {
        border-right: 1px solid transparent !important;
    }

    .text_highlight {
        font-family: Arial, sans-serif;
    }

    .mt-2 {
        margin-top: 20px;
    }

    .mt-0 {
        margin-top: 0;
    }

    .logo {
        display: block;
        margin: 0 auto;
    }

    .title {
        font-size: 26px;
        margin: 0;
    }
    .address {
        font-size: 16px;
        margin: 0;
    }

    .empty-cell {
        width: 14.2857%; /* Approximate width for 7 columns */
    }
    /* Add this to your CSS file or within a <style> tag in your view */
    .cell {
        font-size: 13px;
        padding: 8px;
        border: 1px solid black;
    }

    .empty-cell {
        border: 1px solid transparent; /* Ensure empty cells don’t disrupt the border layout */
    }

    .last-row td {
        border-bottom: 1px solid black; /* Apply bottom border for the last row */
    }
</style>

<?php 
    setcookie('isDownloading', 0);
    $totalStaffCount = count($staffData);
    foreach($staffData as $std){
        $totalLateMinutes = 0;
        $totalStaffCount--;
        $first_day_of_month = date('w', strtotime("$year-$month-01")); // Day of week for the 1st of the month
        $days_in_month = date('t', strtotime("$year-$month-01")); // Total days in the month

        $attendance_array = [];

        $lc_count = 0;
        $holiday_count = 0;
        $woking_days_count = 0;
        $nop_count = 0;
        $absent_count = 0;
        $sunday_count = 0;
        $leave_count = 0;

        // Loop through each day of the month to populate attendance data
        for ($day = 1; $day <= $days_in_month; $day++) {
            $date_today = date('Y-m-d', strtotime("{$year}-{$month}-{$day}"));
            $attendance_info = getSingleStaffAttendanceInfo($con, $std->staff_id, $date_today);
            $leaveInfo = getAllLeaveTakenInfoByStaff($con, $std->staff_id, $date_today, $date_today);
            $holiday = $holiday_model->getHolidayInfoByRoleByDay($std->role_id, $date_today, $date_today);

            $actual_in_time = $attendance_info['start_time'] ?? '00:00:00';
            $in_time = $attendance_info['in_time'] ?? '-';
            $out_time = $attendance_info['out_time'] ?? '-';
            $in_time_status = 'on_time'; // Default status

            if ($in_time > $actual_in_time) {
                $in_time_status = 'late';
            }
            $per_day_leave = 0;
            $leave_type = '-';

            if (!empty($leaveInfo)) {
                foreach ($leaveInfo as $leaveRecord) {
                    $total_days = floatval($leaveRecord['total_days_leave']);
                    $leave_start = strtotime($leaveRecord['date_from']);
                    $leave_end = strtotime($leaveRecord['date_to']);
                    $days_span = ($leave_end - $leave_start) / (60*60*24) + 1;

                    // Divide leave evenly per day
                    $per_day_leave += $total_days / $days_span;
                    $leave_type = $leaveRecord['leave_type'] ?? $leave_type;
                }
            }


            if (!empty($holiday)) {
                $attendance_array[$day] = [
                    'status' => 0, // Holiday
                    'in_time' => '-',
                    'actual_in_time' => '-',
                    'out_time' => '-',
                    'in_time_status' => 'holiday'
                ];
            } else if (!empty($leaveInfo) && is_array($leaveInfo) && isset($leaveInfo[0])) {
                $leaveInfoRecord = $leaveInfo[0]; // Get the first record
                $leave_type = '';
                if(strpos((string)$leaveInfoRecord['total_days_leave'], '.5') !== false){
                    $half_leave = '('.$leaveInfoRecord['total_days_leave'].')';
                    // Display the leave information
                }else{
                    $half_leave = '';
                }
            
                switch ($leaveInfoRecord['leave_type']) {
                    case 'LOP':
                        $leave_type = "LOSS OF PAY".$half_leave;
                        break;
                    case 'CL':
                        $leave_type = "CASUAL LEAVE".$half_leave;
                        break;
                    case 'MARL':
                        $leave_type = "MARRIAGE LEAVE".$half_leave;
                        break;
                    case 'PL':
                        $leave_type = "PATERNITY LEAVE".$half_leave;
                        break;
                    case 'MATL':
                        $leave_type = "MATERNITY LEAVE".$half_leave;
                        break;
                    case 'ML':
                        $leave_type = "MEDICAL LEAVE".$half_leave;
                        break;
                    case 'EL':
                        $leave_type = "EARNED LEAVE".$half_leave;
                        break;
                    case 'OD':
                        $leave_type = "OFFICIAL DUTY".$half_leave;
                        break;
                    default:
                        $leave_type = "UNKNOWN LEAVE".$half_leave;
                        break;
                }
                $attendance_array[$day] = [
                    'status' => 0, // Absent due to leave
                    'in_time' => '-',
                    'actual_in_time' => '-',
                    'out_time' => '-',
                    'in_time_status' => 'leave',
                    'leave_status' => $leave_type,
                    'leave_days' => $per_day_leave,
                ];
            } elseif ($attendance_info) {
                $attendance_array[$day] = [
                    'status' => 1, // Present
                    'in_time' => $in_time,
                    'actual_in_time' => $actual_in_time,
                    'out_time' => $out_time,
                    'in_time_status' => $in_time_status
                ];
            } else {
                $attendance_array[$day] = [
                    'status' => 0, // Absent
                    'in_time' => '-',
                    'actual_in_time' => '-',
                    'out_time' => '-',
                    'in_time_status' => 'absent'
                ];
            }
        }
?>


<div class="container border_full">

    <div class="row">
        <table class="table text_highlight mt-0">
            <tr>
                <td class="text-center" width="20%">
                    <img class="mt-0 logo" width="100" height="100" src="<?php echo INSTITUTION_LOGO; ?>" alt="logo">
                </td>
                <td width="80%">
                    <div class="header-content">
                        <b class="title"><?php echo TITLE; ?></b><br>
                        <p class="address">Near Shivagiri, Ukkali Road, Vijayapur - 586104 Dise Code : 29031401417 <br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Collge Code : EE0272</p>
                    </div>
                </td>
            </tr>
        </table>

        <table class="table_bordered text_highlight">
            <tr> 
                <td colspan="4" class="text-center text-black" style="background-color: #a287f2; padding: 8px; font-size: 17px;"><b>MONTHLY ATTENDANCE</b></td>
            </tr>
            <tr>
                <td style="background-color: #e7e2f9; font-size:13px;" width="25%"><b>NAME</b></td>
                <td width="25%" style="font-size:13px;"><?php echo strtoupper($std->name) ?></td>
                <td style="background-color: #e7e2f9; font-size:13px;" width="25%"><b>EMPLOYEE CODE</b></td>
                <td style="font-size:13px;"><?php echo $std->employee_id ?></td>
            </tr>
            <tr>
                <td style="background-color: #e7e2f9; font-size:13px;" width="25%"><b>ROLE</b></td>
                <td width="25%" style="font-size:13px;"><?php echo strtoupper($std->role) ?></td>
                <td style="background-color: #e7e2f9; font-size:13px;" width="25%"><b>DEPARTMENT</b></td>
                <td style="font-size:13px;"><?php echo $std->department ?></td>
            </tr>
            <tr>
                <td style="background-color: #e7e2f9; font-size:13px;;" width="25%"><b>GENDER</b></td>
                <td style="font-size:13px;"><?php echo $std->gender; ?></td>
                <td style="background-color: #e7e2f9; font-size:13px; border-bottom: 1px solid black;" width="25%"><b>CONTACT NO.</b></td>
                <td style="font-size:13px; border-bottom: 1px solid black;"><?php echo strtoupper($std->mobile_one) ?></td>
            </tr>
            <tr>
                
                <td style="background-color: #e7e2f9; font-size:13px; border-bottom: 1px solid black;" width="25%"><b>SHIFT</b></td>
                <td style="font-size:13px; border-bottom: 1px solid black;" colspan="3"><?php echo strtoupper($std->shift_name).' - '. date('H:i',strtotime($std->start_time)).' To '.date('H:i',strtotime($std->end_time)); ?></td>
            </tr>
        </table>
        <br>
        <br>

        <!-- <table class="table_bordered text_highlight">
            <tr>
                <td class="text-center text-black" style="background-color: #a287f2; padding: 6px; font-size: 15px;" width="35%"><b>TOTAL DAYS</b></td>
                <td class="text-center text-black" style="background-color: #a287f2; padding: 6px; font-size: 15px;" width="35%"><b>WORKING DAYS</b></td>
                <td class="text-center text-black" style="background-color: #a287f2; padding: 6px; font-size: 15px;" width="35%"><b>LOP DAYS</b></td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid black; padding: 6px;" class="text-center"><?php echo $std->total_days; ?></td>
                <td style="border-bottom: 1px solid black; padding: 6px;" class="text-center"><?php echo $std->working_day; ?></td>
                <td style="border-bottom: 1px solid black; padding: 6px;" class="text-center"><?php echo $std->total_days - $std->working_day; ?></td>
            </tr>
        </table> -->
        <table class="table_bordered text_highlight" style="width: 100%; border-collapse: collapse;">
    <tr>
        <td colspan="7" class=" text-black"><strong><span style="color:red;"> Note:-</span></strong> HH - HOLIDAY, LC - LATE COUNT, NOP - NO OUT PUNCH, WD - WORKING DAYS, AB - ABSENT</td>
    </tr>
    <tr>
        <td colspan="7" class="text-center text-black" style="background-color: #a287f2; padding: 8px; font-size: 17px;">
            <b>ATTENDANCE OF <?php echo strtoupper(date('F', mktime(0, 0, 0, $month, 10))); ?> <?php echo $year; ?></b>
        </td>
    </tr>
    <tr>
        <th class="cell" style="background-color: #e7e2f9;">Sun</th>
        <th class="cell" style="background-color: #e7e2f9;">Mon</th>
        <th class="cell" style="background-color: #e7e2f9;">Tue</th>
        <th class="cell" style="background-color: #e7e2f9;">Wed</th>
        <th class="cell" style="background-color: #e7e2f9;">Thu</th>
        <th class="cell" style="background-color: #e7e2f9;">Fri</th>
        <th class="cell" style="background-color: #e7e2f9;">Sat</th>
    </tr>
    <tr>
        <?php
        // Empty cells before the first day of the month
        for ($i = 0; $i < $first_day_of_month; $i++) {
            echo "<td class='empty-cell'></td>";
        }

        // Print days and attendance
        for ($day = 1; $day <= $days_in_month; $day++) {
            $day_of_week = date('w', strtotime("$year-$month-$day"));
            $attendance = $attendance_array[$day] ?? null;

            if ($attendance && $attendance['status'] == 1) {
                // Format in_time and out_time to show only hours and minutes
                $in_time = date('H:i', strtotime($attendance['in_time']));
                $out_time = date('H:i', strtotime($attendance['out_time']));
                $actual_in_time = $attendance['actual_in_time'];
                $check_in_compare_test = new DateTime(date("H:i:s",strtotime($attendance['in_time'])));
                $in_time_rule = new DateTime(date("H:i:s",strtotime($actual_in_time)));

                $in_time_style = '';
                $time_diff = $check_in_compare_test->diff($in_time_rule);

                if ($in_time > $actual_in_time) {
                    $in_time_style = "color: #f72738;";  // Light red color for late arrivals
                    $lc_count++;
                    $lateMinutes = abs($time_diff->format('%h') * 60 + $time_diff->format('%i'));
                    $totalLateMinutes += $lateMinutes;

                }

                if ($out_time == '00:00') {
                    $out_time = '<span style="color: #f00;">NOP</span>';
                $nop_count++;
                }

                echo "<td class='cell'>
                        {$day}<br>
                        In: <span style='{$in_time_style}'>{$in_time}</span><br>
                        Out: {$out_time}
                    </td>";
                $woking_days_count++;
            } else {
                if ($attendance && $attendance['in_time_status'] == 'holiday') {
                    echo "<td class='cell'>
                            {$day}<br>
                            <span style='color: purple;'><strong>HH</strong></span>
                            <br>
                            <span>&nbsp;</span>
                        </td>";
                $holiday_count++;
                } elseif ($attendance && $attendance['in_time_status'] == 'leave') {
                    echo "<td class='cell'>
                            {$day}<br>
                            <span style='color: blue;'><strong>{$attendance['leave_status']}</strong></span>
                            <br>
                            <span>&nbsp;</span>
                        </td>";
               $leave_count += $attendance['leave_days'];
                } else {
                    // Check if the day is a Sunday
                    if ($day_of_week == 0) {
                        // Display "SUN" in green
                        echo "<td class='cell'>
                                {$day}<br>
                                <span style='color: green;'><strong>SUN</strong></span>
                                <br>
                                <span>&nbsp;</span>
                            </td>";
                            $sunday_count++;
                    } else {
                        // Display "AB" in red for other absent days
                        echo "<td class='cell'>
                                {$day}<br>
                                <span style='color: red;'><strong>AB</strong></span>
                                <br>
                                <span>&nbsp;</span>
                            </td>";
                        $absent_count++;

                    }
                }
            }

            // Break row after Saturday
            if (($day + $first_day_of_month) % 7 == 0) {
                echo "</tr><tr>";
            }
        }
         $absent_count = $absent_count + $leave_count;

        // Fill in empty cells for the last week if needed
        $remaining_days = 7 - (($days_in_month + $first_day_of_month) % 7);
        if ($remaining_days < 7 && $remaining_days > 0) {
            for ($i = 0; $i < $remaining_days; $i++) {
                echo "<td class='empty-cell'></td>";
            }
        }
        ?>
    </tr>
</table>
<br>

<table class="table_bordered text_highlight" style="width: 100%; border-collapse: collapse;">
    <tr>
        <td colspan="4" class="text-center text-black" style="background-color: #a287f2; padding: 8px; font-size: 17px;">
            <b>ATTENDANCE SUMMARY FOR <?php echo strtoupper(date('F', mktime(0, 0, 0, $month, 10))); ?> <?php echo $year; ?></b>
        </td>
    </tr>
    <tr>
        <td style="background-color: #e7e2f9; font-size: 14px; padding:10px;" width="25%"><b>Late Count (LC)</b></td>
        <td width="25%" style="font-size: 14px; padding:10px;"><b><?php echo $lc_count; ?></b></td>
        <td style="background-color: #e7e2f9; font-size: 14px; padding:10px;" width="25%"><b>Holiday</b></td>
        <td width="25%" style="font-size: 14px; padding:10px;"><b><?php echo $holiday_count; ?></b></td>
    </tr>
    <tr>
        <td style="background-color: #e7e2f9; font-size: 14px; padding:10px;" width="25%"><b>Working Days</b></td>
        <td width="25%" style="font-size: 14px; padding:10px;"><b><?php echo $woking_days_count; ?></b></td>
        <td style="background-color: #e7e2f9; font-size: 14px; padding:10px;" width="25%"><b>No Out Punch (NOP)</b></td>
        <td width="25%" style="font-size: 14px; padding:10px;"><b><?php echo $nop_count; ?></b></td>
    </tr>
    <tr>
        <td style="background-color: #e7e2f9; font-size: 14px; padding:10px;" width="25%"><b>Absent</b></td>
        <td width="25%" style="font-size: 14px; padding:10px;"><b><?php echo $absent_count; ?></b></td>
        <td style="background-color: #e7e2f9; font-size: 14px; padding:10px; border-bottom: 1px solid black;" width="25%"><b>Leave</b></td>
        <td width="25%" style="font-size: 14px; padding:10px; border-bottom: 1px solid black;"><b><?php echo $leave_count; ?></b></td>
    </tr>
    <tr>
        <td style="background-color: #e7e2f9; font-size: 14px; padding:10px;border-bottom: 1px solid black;" width="25%"><b>Total Late</b></td>
        <td width="25%" style="font-size: 14px; padding:10px;border-bottom: 1px solid black;" colspan="3"><b><?php echo  $totalLateMinutes ?> Minutes</b></td>
    </tr>
</table>















        <br>
    </div>

    <?php if ($totalStaffCount > 0) { ?>
        <div class="break"></div>
    <?php } ?>

</div>
<?php } ?>
<?php 
function getAllLeaveTakenInfoByStaff($con,$staff_id,$date_from, $date_to){
    
    if (!empty($date_to)) {
        $query = "SELECT * FROM tbl_staff_applied_leave
        WHERE staff_id = '$staff_id'
        AND (
            (date_from BETWEEN '$date_from' AND '$date_to')
            OR
            (date_to BETWEEN '$date_from' AND '$date_to')
            OR
            (date_from <= '$date_from' AND date_to >= '$date_to')
        )
        AND approved_status = 1 AND is_deleted = 0";
    }    
    else{
        $query = "SELECT * FROM tbl_staff_applied_leave
        WHERE staff_id = '$staff_id'
        AND date_from >= '$date_from'
        AND approved_status = 1 AND is_deleted = 0";
    }
    $result = $con->prepare($query); 
    $result->execute(); 
    return $result->fetchAll();
}
function getSingleStaffAttendanceInfo($con,$staff_id,$date_today){

    $query = "SELECT sa.punch_time as in_time, sa.punch_out_time as out_time, staff.staff_id,
        sa.punch_date, sa.punch_time, staff.type, staff.row_id, staff.name,dept.name as department, staff.mobile_one, role_.role, role_.roleId,
         shift.start_time, shift.end_time, shift.name, shift.shift_code
        FROM
        tbl_staff_attendance_info as sa, tbl_staff as staff, tbl_roles as role_,
        tbl_department as dept,
        tbl_staff_shift_info as shift
        WHERE
        staff.shift_code = shift.shift_code AND
        staff.staff_id = sa.staff_id AND
        role_.roleId = staff.role AND
        dept.dept_id = staff.department_id AND staff.is_deleted = 0 AND
        sa.staff_id = '$staff_id' AND
        sa.punch_date = '$date_today'";
        // return $query->row();
    $result = $con->prepare($query); 
    $result->execute(); 
    return $result->fetch();
}
?>
