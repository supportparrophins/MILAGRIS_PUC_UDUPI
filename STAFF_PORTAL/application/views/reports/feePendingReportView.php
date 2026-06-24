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
                    <th style="border: 1px solid black;text-align: center;width: 100px;" colspan="6">FEE <?php echo $type; ?> INFO </th>
                </tr>
                <tr>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">SL.No.</th>
                    <th style="border: 1px solid black;text-align: center;width: 200px;">Student ID</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Name</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Total Fee</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Fee Paid</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Fee Pending</th>

                </tr>
                <?php
                    $filter['term'] = 'I PUC';
                    $filter['term_name'] = 'I PUC';
                    $filter['fee_year'] = $year;
                    foreach($streamInfo as $stream){ ?>
                        <tr><th style="border: 1px solid black;text-align: center;width: 100px;" colspan="6"><?php echo $filter['term'].'-'.$stream->stream_name; ?></th></tr>
                        <?php
                    
                        $fee_ttl=$paid_ttl=$pending_ttl=0;
                        $j=1;
                        $filter['stream_name'] = $filter['preference'] = $stream->stream_name;
                        $total_fee_obj = $feemodel->getTotalFeeAmount($filter);
                        $total_amount = $total_fee_obj->total_fee;
                        $studentInfo = $studentmodel->getStudentInfoForReportDownload($filter);
                        if (!empty($studentInfo)) {
                            foreach ($studentInfo as $std) {
                                $total_amount -= $feemodel->getFeeConcessionByAppNo($std->row_id,$filter['term_name']);
                                $total_paid = $feemodel->getTotalFeePaidInfo($std->row_id,$year);
                                $pending = $total_amount - $total_paid;
                                if($type == 'PENDING' && $pending > 0){
                                ?>  
                                <tr>
                                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $j++; ?></td>
                                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->student_id; ?></td>
                                        <td style="border: 1px solid black;text-align: left;width: 200px;"><?php echo strtoupper($std->student_name); ?></td>
                                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php $fee_ttl += $total_amount; echo $total_amount; ?></th>
                                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php $paid_ttl += $total_paid; echo $total_paid; ?></th>
                                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php $pending_ttl += $pending; echo $pending; ?></th>
                                </tr>        
                                <?php        
                                }else if($type == 'PAID' && $pending <= 0){ ?>
                                <tr>
                                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $j++; ?></th>
                                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->student_id; ?></th>
                                        <td style="border: 1px solid black;text-align: left;width: 200px;"><?php echo strtoupper($std->student_name); ?></th>
                                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php $fee_ttl += $total_amount; echo $total_amount; ?></th>
                                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php $paid_ttl += $total_paid; echo $total_paid; ?></th>
                                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php $pending_ttl += $pending; echo $pending; ?></th>
                                </tr>

                        <?php } } } ?>
                        <tr>
                            <th style="border: 1px solid black;text-align: center;width: 100px;" colspan = "3">TOTAL</th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $fee_ttl; ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $paid_ttl; ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $pending_ttl; ?></th>
                        </tr>
                    <?php } ?>
                
                    <?php 
                    $filter['term'] = 'II PUC';
                    $filter['term_name'] = 'II PUC';
                    $filter['fee_year'] = $year;
                    foreach($streamInfo as $stream){ ?>
                        <tr><th style="border: 1px solid black;text-align: center;width: 100px;" colspan="6"><?php echo $filter['term'].'-'.$stream->stream_name; ?></th></tr>
                        <?php
                    
                        $fee_ttl=$paid_ttl=$pending_ttl=0;
                        $j=1;
                        $filter['stream_name'] = $filter['preference'] = $stream->stream_name;
                        $total_fee_obj = $feemodel->getTotalFeeAmount($filter);
                        $total_amount = $total_fee_obj->total_fee;
                        $studentInfo = $studentmodel->getStudentInfoForReportDownload($filter);
                        if (!empty($studentInfo)) {
                            foreach ($studentInfo as $std) {
                                $total_amount -= $feemodel->getFeeConcessionByAppNo($std->row_id,$filter['term_name']);
                                $total_paid = $feemodel->getTotalFeePaidInfo($std->row_id,$year);
                                $pending = $total_amount - $total_paid;
                                if($type == 'PENDING' && $pending > 0){
                                ?>  
                                <tr>
                                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $j++; ?></td>
                                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->student_id; ?></td>
                                        <td style="border: 1px solid black;text-align: left;width: 200px;"><?php echo strtoupper($std->student_name); ?></td>
                                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php $fee_ttl += $total_amount; echo $total_amount; ?></th>
                                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php $paid_ttl += $total_paid; echo $total_paid; ?></th>
                                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php $pending_ttl += $pending; echo $pending; ?></th>
                                </tr>        
                                <?php        
                                }else if($type == 'PAID' && $pending <= 0){ ?>
                                <tr>
                                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $j++; ?></th>
                                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->student_id; ?></th>
                                        <td style="border: 1px solid black;text-align: left;width: 200px;"><?php echo strtoupper($std->student_name); ?></th>
                                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php $fee_ttl += $total_amount; echo $total_amount; ?></th>
                                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php $paid_ttl += $total_paid; echo $total_paid; ?></th>
                                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php $pending_ttl += $pending; echo $pending; ?></th>
                                </tr>

                        <?php } } } ?>
                        <tr>
                            <th style="border: 1px solid black;text-align: center;width: 100px;" colspan = "3">TOTAL</th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $fee_ttl; ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $paid_ttl; ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $pending_ttl; ?></th>
                        </tr>
                    <?php } ?>
                    
            </table>
        </div>
    </div>