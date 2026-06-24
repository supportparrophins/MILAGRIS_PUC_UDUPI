<?php 
    ini_set('memory_limit', '4024M');
    ini_set('max_execution_time', -1);
    ini_set('pcre.backtrack_limit', '5000000');
?>
<style>
table {
    width: 100% !important;
}
.border_full {
    border: 1px solid black;
}
.border_bottom {
    border-bottom: 1px solid black;
}
.hr_line {
    margin: 5px 0px;
    color: black;
}
.table_bordered {
    border-collapse: collapse;
}
.table_bordered th, .table_bordered td {
    border-top: 1px solid black;
    border-right: 1px solid black;
    padding: 3px;
}
.table_border {
    border: 2px solid black;
    margin: 4px !important;
    padding: 4px !important;
}
.table_bordered th .border_right_none, .table_bordered td .border_right_none {
    border-right: 1px solid transparent !important;
}
u {
    border-bottom: 2px dotted #00000;
    text-decoration: none;
    font-family: timesnewroman;
    text-underline-offset: 18px;
    font-size: 14px;
}
.underline {
    flex-grow: 1;
    border-bottom: 2px dotted #00000;
    margin-left: 8px;
}
.small-photo {
    width: 120px;
    height: 120px;
    object-fit: cover;
}
</style>


<table style="width: 100%; border-collapse: collapse;">
<?php 
    $totalStudentCount = count($studentsRecords);
    $index = 0;
    foreach ($studentsRecords as $record) {
        $index++;
        $total_fee_amount = 0;  
                    if($record->term_name == 'I PUC'){
                        $year = trim($record->intake_year_id);
                        $RateInfo = $transModel->getStudentTransportRateInfo($record->route_id,$year);

                    }else{
                        $year = trim($record->intake_year_id) + 1;
                        $RateInfo = $transModel->getStudentTransportRateInfo($record->route_id_II,$year);
                    }
                    $total_fee = $total_fee_amount = $RateInfo->rate;

                    $feePaidInfo = $transModel->getTransportTotalPaidAmount($record->row_id,$year);

                    if(!empty($feePaidInfo->paid_amount)){
                        $total_fee_amount -= $feePaidInfo->paid_amount;
                    }
                    $feeConcession = $transModel->getFeeConcessionInfo($record->row_id,$year); 
                    if(!empty($feeConcession)){
                        $total_fee_amount -= $feeConcession->fee_amt;
                    }
                    $stdFeePaymentInfo = $transModel->getStudentOverallTransFeePaymentInfo($record->row_id,$year);
                    
                    $fee_amount = $total_fee_amount;

?>
    <tr>
        <td style="border: 2px solid black; box-sizing: border-box;">
            <!-- Bus Pass Content -->
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td colspan="2" style="border-bottom: 1px solid black;">
                        <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
    <tr>
        <!-- Left: Institution Name and Address -->
        <td style="text-align: center; width: 85%; vertical-align: middle;">
            <div>
               <span style="font-size: 23px; font-family: Arial, sans-serif; letter-spacing: 1px; font-weight: bold;">LOYOLA INSTITUTIONS</span><br>
<span style="font-size: 18px; font-family: Arial, sans-serif; letter-spacing: 0.5px; display: inline-block; margin-top: 5px;">
    LOYOLA INSTITUTIONS, VIJAYAPURA DISTRICT
</span>

            </div>
        </td>

        <!-- Right: Logo -->
        <td style="text-align: center; width: 15%; vertical-align: middle;">
            <img src="<?php echo INSTITUTION_LOGO ?>" alt="Logo" height="80" style="display: inline-block;" />
        </td>
    </tr>
</table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center; border-bottom: 1px solid black; padding: 5px 0;">
                        <b style="font-size: 16px; font-family: Arial, sans-serif;">BUS PASS</b>
                    </td>
                </tr>
            </table>

            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 30%; vertical-align: top; padding: 5px;">
                        <!-- Student photo -->
                        <div class="profile-img">
                            <?php $image_path = $record->photo_url; ?>
                            <?php if (!empty($image_path)) { ?>
                                <img src="<?php echo $image_path; ?>" class="avatar img-thumbnail small-photo" alt="Profile Image" />
                            <?php } else { ?>
                                <img src="<?php echo base_url(); ?>assets/dist/img/user.png" class="avatar img-thumbnail small-photo" alt="Default Image" />
                            <?php } ?>
                        </div>
                    </td>
                <td style="width: 80%; padding: 5px;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="font-size: 14px; font-family: Arial, sans-serif; padding: 4px 0 8px 0;">
                <b>Student UID:</b> <?php echo $record->student_id; ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 14px; font-family: Arial, sans-serif; padding: 4px 0 8px 0;">
                <b>Name:</b> <?php echo $record->student_name; ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 14px; font-family: Arial, sans-serif; padding: 4px 0 8px 0;">
                <b>Institute:</b> <?php echo BUS_PASS_INSTITUTE ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 14px; font-family: Arial, sans-serif; padding: 4px 0 8px 0;">
                <b>Class/Course:</b> <?php echo $record->term_name . ' ' . $record->stream_name; ?> &nbsp;&nbsp;&nbsp;&nbsp;
                <b>Shift:</b> <?php echo BUS_PASS_SHIFT ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 14px; font-family: Arial, sans-serif; padding: 4px 0 8px 0;">
                <b>Parents Name:</b> <?php echo $record->father_name; ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 14px; font-family: Arial, sans-serif; padding: 4px 0 8px 0;">
                <b>Route:</b> <?php echo $RateInfo->route_name;?> , <?php echo $RateInfo->pickup_point_name;?>
            </td>
        </tr>
    </table>
</td>

                </tr>
            </table>

         <table style="width: 100%; border-collapse: collapse; border-top: 1px solid black; margin-top: 10px; margin-bottom: 10px;">
    <tr>
        <td style="font-size: 14px; font-family: Arial, sans-serif; padding: 8px 15px;">
            <b>Fare:</b> Rs.<?php echo  $total_fee ?>
        </td>
        <td style="font-size: 14px; font-family: Arial, sans-serif; padding: 8px 15px; text-align: right;">
            <b>Pending Amount:</b>
           <?php if($cancel_status->fee_cancel_bus_status == 1){echo number_format(0,2); }else{echo number_format($fee_amount,2); }?>
        </td>
    </tr>
</table>


        </td>
    </tr>

    <!-- Space between bus passes -->
    <?php if ($index < $totalStudentCount) { ?>
        <tr><td style="height: 20px;"></td></tr>
    <?php } ?>

<?php 
    } // end foreach
?>
</table>

<script>
function checkAmount() {
   var amount = document.getElementById("paid_amount").value;
   var pending = '<?php echo $fee_amount; ?>';

   // Convert the amount and the pending to numbers
   amount = Number(amount);
   pending = Number(pending);
   
   // Compare the amount and the pending using numeric comparison
   if (amount > pending) {
       alert("The paid amount cannot be greater than the pending amount");
       // Clear the value of the amount element
       document.getElementById("paid_amount").value = '';
   }
}
</script>
