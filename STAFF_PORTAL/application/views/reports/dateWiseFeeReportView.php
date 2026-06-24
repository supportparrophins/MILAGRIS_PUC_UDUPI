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
        <div class="row" >
            <table style="width: 100%;border-collapse: collapse;">
                <tr>
                    <th style="border: 1px solid black;text-align: center;width: 100px;" colspan="15">FEE PAID INFO From:-<?php echo (date('d-m-Y',strtotime($date_from)) == '01-01-1970' ? '-' : date('d-m-Y',strtotime($date_from)) ). " To:".(date('d-m-Y',strtotime($date_to)) == '01-01-1970' ? '-' : date('d-m-Y',strtotime($date_to))); ?></th>
                </tr>
                <tr>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">SL.No.</th>
                    <th style="border: 1px solid black;text-align: center;width: 130px;">Date</th>
                    <th style="border: 1px solid black;text-align: center;width: 200px;">Student ID</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Name</th>
                    <!-- <th style="border: 1px solid black;text-align: center;width: 100px;">Term</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Stream</th> -->
                    <!-- <th style="border: 1px solid black;text-align: center;width: 100px;">MngtRNo.</th> -->
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Govt Paid</th>
                    <!-- <th style="border: 1px solid black;text-align: center;width: 100px;">GovtRNo.</th> -->
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Non Govt Paid</th>
                    <!-- <th style="border: 1px solid black;text-align: center;width: 100px;">NonGvtRNo.</th> -->
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Mngt Paid</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Total Paid</th>
                    <!-- <th style="border: 1px solid black;text-align: center;width: 100px;">Fee Pending</th> -->
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Pay Type</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Refund Amt</th>

                </tr>
                <?php 

                $grandTotalGovt = $grandTotalNonGovt = $grandTotalMngt = $$grandTotalPaid = $grandTotalRefund = 0;
                 $filter['term'] = "I PUC";
                 $filter['date_from'] = $date_from;
                 $filter['date_to'] = $date_to;
                 $streamInfo = $studentmodel->getAllStreamName();
                 foreach($streamInfo as $stream){
                     $sl_number = 1;
                     $filter['stream'] = $stream->stream_name;
                    $feeInfo = $feemodel->getAllFeePaymentInfoForReportGroupBy($filter);
                    if (!empty($feeInfo)) {
                        $mngt_total=$govt_total=$nongovt_total=$ttl_total=$refund_ttl=0;
                        $grandTotalGovt = $grandTotalNonGovt = $grandTotalMngt = $$grandTotalPaid = $grandTotalRefund = 0;
                        $j=1;
                    ?>
                    <tr>
                        <th style="border: 1px solid black;text-align: center;width: 100px;" colspan="13"><?php echo 'I PUC - '.$filter['stream']; ?></th>
                    </tr>
                    <?php
                        foreach ($feeInfo as $std) {
                    ?>  
                    <tr>
                            <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $j++; ?></th>
                            <td style="border: 1px solid black;text-align: center;width: 130px;"><?php echo date('d-m-Y',strtotime($std->payment_date)); ?></th>
                            <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->student_id; ?></th>
                            <td style="border: 1px solid black;text-align: left;width: 200px;"><?php echo strtoupper($std->student_name); ?></th>
                            <!-- <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->term_name; ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->stream_name; ?></th> -->
                            <?php $paidInfo = $feemodel->getPaidInfoByType($std->application_no,$std->payment_date,'GOVT'); $govt_total += $paidInfo->paid_amount; ?>
                            <!-- <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $paidInfo->receipt_number; ?></th> -->
                            <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $paidInfo->paid_amount; ?></th>
                            <?php $paidInfo = $feemodel->getPaidInfoByType($std->application_no,$std->payment_date,'NON-GOVT'); $nongovt_total += $paidInfo->paid_amount; ?>
                            <!-- <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $paidInfo->receipt_number; ?></th> -->
                            <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $paidInfo->paid_amount; ?></th>
                            <?php $paidInfo = $feemodel->getPaidInfoByType($std->application_no,$std->payment_date,'MANAGEMENT'); $mngt_total += $paidInfo->paid_amount; ?>
                            <!-- <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $paidInfo->receipt_number; ?></th> -->
                            <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $paidInfo->paid_amount; ?></th>
                            <td style="border: 1px solid black;text-align: center;width: 100px;"><?php $ttl_total += $std->paid_amount; echo $std->paid_amount; ?></th>
                            <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->payment_type; ?></th>
                            <td style="border: 1px solid black;text-align: center;width: 100px;"><?php $refund_ttl += $std->refund_amt; echo $std->refund_amt; ?></th>
                    </tr>        
                    <?php        
                        }
                    ?>
                        <tr>
                            <th style="border: 1px solid black;text-align: center;width: 100px;" colspan = "4">TOTAL</th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $govt_total ?></th>
                            <!-- <th style="border: 1px solid black;text-align: center;width: 100px;"></th> -->
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $nongovt_total ?></th>
                            <!-- <th style="border: 1px solid black;text-align: center;width: 100px;"></th> -->
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $mngt_total ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $ttl_total ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"></th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $refund_ttl ?></th>
                        <tr>

                    <?php

                    $grandTotalGovt += $govt_total;
                    $grandTotalNonGovt += $nongovt_total;
                    $grandTotalMngt += $mngt_total;
                    $grandTotalPaid += $ttl_total;
                    $grandTotalRefund += $refund_ttl;
                    }
                }
                    ?>
                <?php 
                 $filter['term'] = "II PUC";
                 $streamInfo = $studentmodel->getAllStreamName();
                 foreach($streamInfo as $stream){
                     $sl_number = 1;
                     $filter['stream'] = $stream->stream_name;
                    $feeInfo = $feemodel->getAllFeePaymentInfoForReportGroupBy($filter);
                    if (!empty($feeInfo)) {
                        $mngt_total=$govt_total=$nongovt_total=$ttl_total=$refund_ttl=0;
                        
                       

                        $j=1;
                    ?>
                    <tr>
                        <th style="border: 1px solid black;text-align: center;width: 100px;" colspan="13"><?php echo 'II PUC - '.$filter['stream']; ?></th>
                    </tr>
                    <?php
                        foreach ($feeInfo as $std) {
                    ?>  
                    <tr>
                            <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $j++; ?></th>
                            <td style="border: 1px solid black;text-align: center;width: 130px;"><?php echo date('d-m-Y',strtotime($std->payment_date)); ?></th>
                            <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->student_id; ?></th>
                            <td style="border: 1px solid black;text-align: left;width: 200px;"><?php echo strtoupper($std->student_name); ?></th>
                            <!-- <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->term_name; ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->stream_name; ?></th> -->
                            <?php $paidInfo = $feemodel->getPaidInfoByType($std->application_no,$std->payment_date,'GOVT'); $govt_total += $paidInfo->paid_amount; ?>
                         
                            <!-- <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $paidInfo->receipt_number; ?></th> -->
                            <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $paidInfo->paid_amount; ?></th>
                            <?php $paidInfo = $feemodel->getPaidInfoByType($std->application_no,$std->payment_date,'NON-GOVT'); $nongovt_total += $paidInfo->paid_amount; ?>
                            <!-- <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $paidInfo->receipt_number; ?></th> -->
                            <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $paidInfo->paid_amount; ?></th>
                            <?php $paidInfo = $feemodel->getPaidInfoByType($std->application_no,$std->payment_date,'MANAGEMENT'); $mngt_total += $paidInfo->paid_amount; ?>
                            <!-- <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $paidInfo->receipt_number; ?></th> -->
                            <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $paidInfo->paid_amount; ?></th>
                            <td style="border: 1px solid black;text-align: center;width: 100px;"><?php $ttl_total += $std->paid_amount; echo $std->paid_amount; ?></th>
                            <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->payment_type; ?></th>
                            <td style="border: 1px solid black;text-align: center;width: 100px;"><?php $refund_ttl += $std->refund_amt; echo $std->refund_amt; ?></th>
                    </tr>        
                    <?php        
                        }
                    ?>
                        <tr>
                            <th style="border: 1px solid black;text-align: center;width: 100px;" colspan = "4">TOTAL</th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $govt_total ?></th>
                            <!-- <th style="border: 1px solid black;text-align: center;width: 100px;"></th> -->
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $nongovt_total ?></th>
                            <!-- <th style="border: 1px solid black;text-align: center;width: 100px;"></th> -->
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $mngt_total ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $ttl_total ?></th>
                            <!-- <th style="border: 1px solid black;text-align: center;width: 100px;"></th> -->
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $refund_ttl ?></th>
                        <tr>
                    <?php

        
                    $grandTotalGovt += $govt_total;
                    $grandTotalNonGovt += $nongovt_total;
                    $grandTotalMngt += $mngt_total;
                    $grandTotalPaid += $ttl_total;
                    $grandTotalRefund += $refund_ttl;
                    }
                } ?>

                <tr>
                    <th style="border: 1px solid black;text-align: center;width: 100px;" colspan="4">GRAND TOTAL</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $grandTotalGovt; ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $grandTotalNonGovt; ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $grandTotalMngt; ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $grandTotalPaid; ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $grandTotalRefund; ?></th>
                </tr>
                   
            </table>
        </div>
    </div>