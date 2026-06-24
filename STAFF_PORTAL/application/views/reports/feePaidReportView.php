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
                    <th style="border: 1px solid black;text-align: center;width: 100px;" colspan="15"><?php echo EXCEL_TITLE; ?></th>
                </tr>
                <tr>
                    <th style="border: 1px solid black;text-align: center;width: 100px;" colspan="15">FEE PAID INFO - <?php echo $term_name; ?> - <?php echo  $display_year; ?></th>
                </tr>
                <tr>
                    <th style="border: 1px solid black;text-align: center;width: 80px;">SL.No.</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Application No.</th>
                    <th style="border: 1px solid black;text-align: center;width: 200px;">Name</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Stream</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Total Amt.</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Total Fee Paid</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Concession</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Pending</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Excess Amount</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Status</th>

                </tr>
                <?php 
                
                $j=1;
                   
                if ($term_name == 'I PUC') {

                    $studentInfo = $student->getAllStudentInfo_For_Fee_report($term_name,$stream_name,$year);
                    $sum_of_total_fee = 0;
                    $total_Paid_amt = 0; 
                    $total_fee_concession = 0; 
                    $total_pending_balance = 0; 
                    $total_excess_amount = 0;
                    foreach ($studentInfo as $std) {
                        $filter['fee_year'] = $year;
                        $filter['term_name'] = 'I PUC';
                        $filter['stream_name'] = $std->stream_name;
                    
                        $total_fee = $fee->getTotalFeeAmountForReport($filter);
                        $total_fee_amount = $total_fee->total_fee;
                        $total_paid_amount = $fee->getFeePaidInfoForReport($std->stud_row_id,$year);
                        $total_govt_paid_amount = $fee->getGovtFeePaidInfoForReport($std->stud_row_id,$year);

                        if($total_paid_amount->paid_amount == ''){
                            $paid_amt = 0;
                        }else{
                            $paid_amt = $total_paid_amount->paid_amount + $total_govt_paid_amount->paid_amount;
                        }
                        $feeConcession = $fee->getStudFeeConcession($std->stud_row_id,$year); 
                        $pending_bal = $total_fee_amount - $paid_amt - $feeConcession->fee_amt;
                        if($std->discontinued_status == 1){
                            $status = 'INACTIVE';
                         }else{
                            $status = 'ACTIVE';
                         }
                         if($paid_amt > $total_fee_amount){
                            $excess_paid_amt = abs($paid_amt - $total_fee_amount);
                        }else{
                            $excess_paid_amt = 0;
                        }
                    if($status == $student_type){

                        if($payment_type == 'FULL_PAYMENT'){

                            if($pending_bal <= 0){?>
                                <tr>
                                <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $j++; ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $std->application_no; ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo strtoupper($std->student_name); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->stream_name; ?></th>
                          
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($paid_amt,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($feeConcession->fee_amt,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount - $paid_amt - $feeConcession->fee_amt,2); ?></th>
                                 <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo number_format($excess_paid_amt,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $status; ?></th>

                        </tr> 
                         <?php   
                            $total_Paid_amt += $paid_amt; 
                            $total_fee_concession += $feeConcession->fee_amt; 
                            $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                            $total_excess_amount += $excess_paid_amt;
                            $sum_of_total_fee += $total_fee_amount;
                         }
                        }else if($payment_type == 'HALF_PAYMENT'){

                            if($pending_bal < $total_fee_amount && $pending_bal > 0){
                        ?>
             
                <tr>
                        <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $j++; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $std->application_no; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo strtoupper($std->student_name); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->stream_name; ?></th>
                  
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($paid_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($feeConcession->fee_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount - $paid_amt - $feeConcession->fee_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo number_format($excess_paid_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $status; ?></th>

                </tr>        
                <?php 
                  $total_Paid_amt += $paid_amt; 
                  $total_fee_concession += $feeConcession->fee_amt; 
                  $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                  $total_excess_amount += $excess_paid_amt;
                  $sum_of_total_fee += $total_fee_amount;
                }
            }else if($payment_type == 'NOT_PAID'){
            if($paid_amt == 0 && $status == 'ACTIVE'){?>
            <tr>
                        <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $j++; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $std->application_no; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo strtoupper($std->student_name); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->stream_name; ?></th>
                  
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($paid_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($feeConcession->fee_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount - $paid_amt - $feeConcession->fee_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo number_format($excess_paid_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $status; ?></th>

                </tr>  
                <?php   $total_Paid_amt += $paid_amt; 
                            $total_fee_concession += $feeConcession->fee_amt; 
                            $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                            $total_excess_amount += $excess_paid_amt;
                            $sum_of_total_fee += $total_fee_amount; }
                }else if($payment_type == 'PENDING'){
                    if(($pending_bal < $total_fee_amount && $pending_bal > 0 && $status == 'ACTIVE') || ($paid_amt == 0 && $status == 'ACTIVE')){?>
                    <tr>
                                <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $j++; ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $std->application_no; ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo strtoupper($std->student_name); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->stream_name; ?></th>
                          
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($paid_amt,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($feeConcession->fee_amt,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount - $paid_amt - $feeConcession->fee_amt,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo number_format($excess_paid_amt,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $status; ?></th>
        
                        </tr>  
                        <?php   $total_Paid_amt += $paid_amt; 
                                    $total_fee_concession += $feeConcession->fee_amt; 
                                    $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                                    $total_excess_amount += $excess_paid_amt;
                                    $sum_of_total_fee += $total_fee_amount; 
                    }
                        }else{  ?>
                    <tr>
                        <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $j++; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $std->application_no; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo strtoupper($std->student_name); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->stream_name; ?></th>
                  
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($paid_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($feeConcession->fee_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount - $paid_amt - $feeConcession->fee_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo number_format($excess_paid_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $status; ?></th>

                </tr>    
                 <?php  
                   $total_Paid_amt += $paid_amt; 
                   $total_fee_concession += $feeConcession->fee_amt; 
                   $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                   $total_excess_amount += $excess_paid_amt;
                   $sum_of_total_fee += $total_fee_amount;
                 }}else if($student_type == 'ALL'){ 

                    if($payment_type == 'FULL_PAYMENT'){

                        if($pending_bal <= 0){?>
                            <tr>
                            <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $j++; ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $std->application_no; ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo strtoupper($std->student_name); ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->stream_name; ?></th>
                      
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount,2); ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($paid_amt,2); ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($feeConcession->fee_amt,2); ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount - $paid_amt - $feeConcession->fee_amt,2); ?></th>
                             <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo number_format($excess_paid_amt,2); ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $status; ?></th>

                    </tr> 
                     <?php   
                        $total_Paid_amt += $paid_amt; 
                        $total_fee_concession += $feeConcession->fee_amt; 
                        $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                        $total_excess_amount += $excess_paid_amt;
                        $sum_of_total_fee += $total_fee_amount;
                     }
                    }else if($payment_type == 'HALF_PAYMENT'){

                        if($pending_bal < $total_fee_amount && $pending_bal > 0){
                    ?>
         
            <tr>
                    <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $j++; ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $std->application_no; ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo strtoupper($std->student_name); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->stream_name; ?></th>
              
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount,2); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($paid_amt,2); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($feeConcession->fee_amt,2); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount - $paid_amt - $feeConcession->fee_amt,2); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo number_format($excess_paid_amt,2); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $status; ?></th>

            </tr>        
            <?php 
              $total_Paid_amt += $paid_amt; 
              $total_fee_concession += $feeConcession->fee_amt; 
              $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
              $total_excess_amount += $excess_paid_amt;
              $sum_of_total_fee += $total_fee_amount;
            }
        }else if($payment_type == 'NOT_PAID'){
        if($paid_amt == 0 && $status == 'ACTIVE'){?>
        <tr>
                    <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $j++; ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $std->application_no; ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo strtoupper($std->student_name); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->stream_name; ?></th>
              
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount,2); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($paid_amt,2); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($feeConcession->fee_amt,2); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount - $paid_amt - $feeConcession->fee_amt,2); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo number_format($excess_paid_amt,2); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $status; ?></th>

            </tr>  
            <?php   $total_Paid_amt += $paid_amt; 
                        $total_fee_concession += $feeConcession->fee_amt; 
                        $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                        $total_excess_amount += $excess_paid_amt;
                        $sum_of_total_fee += $total_fee_amount; }
            }else if($payment_type == 'PENDING'){
                if(($pending_bal < $total_fee_amount && $pending_bal > 0 && $status == 'ACTIVE') || ($paid_amt == 0 && $status == 'ACTIVE')){?>
                <tr>
                            <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $j++; ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $std->application_no; ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo strtoupper($std->student_name); ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->stream_name; ?></th>
                      
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount,2); ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($paid_amt,2); ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($feeConcession->fee_amt,2); ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount - $paid_amt - $feeConcession->fee_amt,2); ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo number_format($excess_paid_amt,2); ?></th>
                            <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $status; ?></th>
    
                    </tr>  
                    <?php   $total_Paid_amt += $paid_amt; 
                                $total_fee_concession += $feeConcession->fee_amt; 
                                $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                                $total_excess_amount += $excess_paid_amt;
                                $sum_of_total_fee += $total_fee_amount; 
                }
                    }else{  ?>
                <tr>
                    <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $j++; ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $std->application_no; ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo strtoupper($std->student_name); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->stream_name; ?></th>
              
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount,2); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($paid_amt,2); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($feeConcession->fee_amt,2); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount - $paid_amt - $feeConcession->fee_amt,2); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo number_format($excess_paid_amt,2); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $status; ?></th>

            </tr>    
             <?php  
               $total_Paid_amt += $paid_amt; 
               $total_fee_concession += $feeConcession->fee_amt; 
               $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
               $total_excess_amount += $excess_paid_amt;
               $sum_of_total_fee += $total_fee_amount;
             }
                  } }
                ?>
                   
                <?php
                }else {
                    // if($year == CURRENT_YEAR ){
                        $yr = $year;
                    // }else{
                    //     $yr = $year-2;
                    // }
                    $studentInfo = $this->student->getAllStudentInfo_For_Fee_report($term_name,$stream_name,$yr);
                    foreach ($studentInfo as $std) {
                        $filter['fee_year'] = $year;
                        $filter['term_name'] = 'II PUC';
                        $filter['stream_name'] = $std->stream_name;
                    
                        $total_fee = $fee->getTotalFeeAmountForReport($filter);
                        $total_fee_amount = $total_fee->total_fee;
                        $total_paid_amount = $fee->getFeePaidInfoForReport($std->stud_row_id,$year);
                        $total_govt_paid_amount = $fee->getGovtFeePaidInfoForReport($std->stud_row_id,$year);

                        if($total_paid_amount->paid_amount == ''){
                            $paid_amt = 0;
                        }else{
                            $paid_amt = $total_paid_amount->paid_amount + $total_govt_paid_amount->paid_amount;
                        }
                        $feeConcession = $fee->getStudFeeConcession($std->stud_row_id,$year);
                        $pending_bal = $total_fee_amount - $paid_amt - $feeConcession->fee_amt;
                        if($std->discontinued_status == 1){
                            $status = 'INACTIVE';
                         }else{
                            $status = 'ACTIVE';
                         }
                         if($paid_amt > $total_fee_amount){
                            $excess_paid_amt = abs($paid_amt - $total_fee_amount);
                        }else{
                            $excess_paid_amt = 0;
                        }
                    if($status == $student_type){

                        if($payment_type == 'FULL_PAYMENT'){

                            if($pending_bal <= 0){?>
                                <tr>
                                <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $j++; ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $std->application_no; ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo strtoupper($std->student_name); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->stream_name; ?></th>
                          
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($paid_amt,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($feeConcession->fee_amt,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount - $paid_amt - $feeConcession->fee_amt,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo number_format($excess_paid_amt,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $status; ?></th>

                        </tr> 
                         <?php   
                           $total_Paid_amt += $paid_amt; 
                           $total_fee_concession += $feeConcession->fee_amt; 
                           $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                           $total_excess_amount += $excess_paid_amt;
                           $sum_of_total_fee += $total_fee_amount; }
                        }else if($payment_type == 'HALF_PAYMENT'){
                            if($pending_bal < $total_fee_amount && $pending_bal > 0){?>
             
                <tr>
                        <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $j++; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $std->application_no; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo strtoupper($std->student_name); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->stream_name; ?></th>
                  
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($paid_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($feeConcession->fee_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount - $paid_amt - $feeConcession->fee_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo number_format($excess_paid_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $status; ?></th>

                </tr>        
                <?php 
                  $total_Paid_amt += $paid_amt; 
                  $total_fee_concession += $feeConcession->fee_amt; 
                  $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                  $total_excess_amount += $excess_paid_amt;
                  $sum_of_total_fee += $total_fee_amount;
                }
            }else if($payment_type == 'NOT_PAID'){
            if($paid_amt == 0 && $status == 'ACTIVE'){?>
            <tr>
                        <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $j++; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $std->application_no; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo strtoupper($std->student_name); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->stream_name; ?></th>
                  
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($paid_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($feeConcession->fee_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount - $paid_amt - $feeConcession->fee_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo number_format($excess_paid_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $status; ?></th>

                </tr>  
                <?php 
                  $total_Paid_amt += $paid_amt; 
                  $total_fee_concession += $feeConcession->fee_amt; 
                  $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                  $total_excess_amount += $excess_paid_amt;
                  $sum_of_total_fee += $total_fee_amount;
                }
                }else if($payment_type == 'PENDING'){
                    if(($pending_bal < $total_fee_amount && $pending_bal > 0 && $status == 'ACTIVE') || ($paid_amt == 0 && $status == 'ACTIVE')){?>
                    <tr>
                                <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $j++; ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $std->application_no; ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo strtoupper($std->student_name); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->stream_name; ?></th>
                          
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($paid_amt,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($feeConcession->fee_amt,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount - $paid_amt - $feeConcession->fee_amt,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo number_format($excess_paid_amt,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $status; ?></th>
        
                        </tr>  
                        <?php   $total_Paid_amt += $paid_amt; 
                                    $total_fee_concession += $feeConcession->fee_amt; 
                                    $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                                    $total_excess_amount += $excess_paid_amt;
                                    $sum_of_total_fee += $total_fee_amount; 
                    }
                }else{  ?>
                    <tr>
                        <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $j++; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $std->application_no; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo strtoupper($std->student_name); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->stream_name; ?></th>
                  
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($paid_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($feeConcession->fee_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount - $paid_amt - $feeConcession->fee_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo number_format($excess_paid_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $status; ?></th>

                </tr>  
             
                <?php 
                  $total_Paid_amt += $paid_amt; 
                  $total_fee_concession += $feeConcession->fee_amt; 
                  $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                  $total_excess_amount += $excess_paid_amt;
                  $sum_of_total_fee += $total_fee_amount;       
                    }}else if($student_type == 'ALL'){
                        if($payment_type == 'FULL_PAYMENT'){

                            if($pending_bal <= 0){?>
                                <tr>
                                <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $j++; ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $std->application_no; ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo strtoupper($std->student_name); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->stream_name; ?></th>
                          
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($paid_amt,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($feeConcession->fee_amt,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount - $paid_amt - $feeConcession->fee_amt,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo number_format($excess_paid_amt,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $status; ?></th>

                        </tr> 
                         <?php   
                           $total_Paid_amt += $paid_amt; 
                           $total_fee_concession += $feeConcession->fee_amt; 
                           $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                           $total_excess_amount += $excess_paid_amt;
                           $sum_of_total_fee += $total_fee_amount; }
                        }else if($payment_type == 'HALF_PAYMENT'){
                            if($pending_bal < $total_fee_amount && $pending_bal > 0){?>
             
                <tr>
                        <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $j++; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $std->application_no; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo strtoupper($std->student_name); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->stream_name; ?></th>
                  
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($paid_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($feeConcession->fee_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount - $paid_amt - $feeConcession->fee_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo number_format($excess_paid_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $status; ?></th>

                </tr>        
                <?php 
                  $total_Paid_amt += $paid_amt; 
                  $total_fee_concession += $feeConcession->fee_amt; 
                  $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                  $total_excess_amount += $excess_paid_amt;
                  $sum_of_total_fee += $total_fee_amount;
                }
            }else if($payment_type == 'NOT_PAID'){
            if($paid_amt == 0 && $status == 'ACTIVE'){?>
            <tr>
                        <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $j++; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $std->application_no; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo strtoupper($std->student_name); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->stream_name; ?></th>
                  
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($paid_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($feeConcession->fee_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount - $paid_amt - $feeConcession->fee_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo number_format($excess_paid_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $status; ?></th>

                </tr>  
                <?php 
                  $total_Paid_amt += $paid_amt; 
                  $total_fee_concession += $feeConcession->fee_amt; 
                  $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                  $total_excess_amount += $excess_paid_amt;
                  $sum_of_total_fee += $total_fee_amount;
                }
                }else if($payment_type == 'PENDING'){
                    if(($pending_bal < $total_fee_amount && $pending_bal > 0 && $status == 'ACTIVE') || ($paid_amt == 0 && $status == 'ACTIVE')){?>
                    <tr>
                                <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $j++; ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $std->application_no; ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo strtoupper($std->student_name); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->stream_name; ?></th>
                          
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($paid_amt,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($feeConcession->fee_amt,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount - $paid_amt - $feeConcession->fee_amt,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo number_format($excess_paid_amt,2); ?></th>
                                <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $status; ?></th>
        
                        </tr>  
                        <?php   $total_Paid_amt += $paid_amt; 
                                    $total_fee_concession += $feeConcession->fee_amt; 
                                    $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                                    $total_excess_amount += $excess_paid_amt;
                                    $sum_of_total_fee += $total_fee_amount; 
                    }
                }else{  ?>
                    <tr>
                        <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $j++; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $std->application_no; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo strtoupper($std->student_name); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->stream_name; ?></th>
                  
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($paid_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($feeConcession->fee_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_fee_amount - $paid_amt - $feeConcession->fee_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo number_format($excess_paid_amt,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $status; ?></th>

                </tr>  
             
                <?php 
                  $total_Paid_amt += $paid_amt; 
                  $total_fee_concession += $feeConcession->fee_amt; 
                  $total_pending_balance += ($total_fee_amount - $paid_amt - $feeConcession->fee_amt); 
                  $total_excess_amount += $excess_paid_amt;
                  $sum_of_total_fee += $total_fee_amount;       
                    }
                     }}}
                ?>
                  
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">TOTAL</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($sum_of_total_fee,2); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo number_format($total_Paid_amt,2); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo number_format($total_fee_concession,2); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo number_format($total_pending_balance,2); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo number_format($total_excess_amount,2); ?></th>
                    <th></th>
                    <th></th>
         
                    </tr>
            </table>
        </div>
    </div>