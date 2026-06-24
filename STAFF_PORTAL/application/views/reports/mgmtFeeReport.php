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
                    <th style="border: 1px solid black;text-align: center;width: 100px;" colspan="19"><?php echo EXCEL_TITLE; ?></th>
                </tr>
                <tr>
                    <th style="border: 1px solid black;text-align: center;width: 100px;" colspan="19">Management Fee Report - <?php echo $display_year; ?></th>
                </tr>
                <tr>
                    <th style="border: 1px solid black;text-align: center;width: 50px;">SL.No.</th>
                    <!-- <th style="border: 1px solid black;text-align: center;width: 100px;">Receipt No.</th> -->
                    <th style="border: 1px solid black;text-align: center;width: 130px;">Name</th>
                    <th style="border: 1px solid black;text-align: center;width: 80px;">Term</th>
                    <th style="border: 1px solid black;text-align: center;width: 80px;">Stream</th>
                    <th style="border: 1px solid black;text-align: center;width: 80px;">Section</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Application No.</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Receipt No.</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Payment Mode</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Transaction ID</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Transaction Date</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">DD Number</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">DD Date</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Bank Name</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Amount Paid</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Over Payment</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Payment Date</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Settlement Date</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Settlement Status</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Status</th>

                </tr>
                <?php 
                $filter = array();
                $filter = $dt_filter;
                $j=1;
                if($date_from != ''){
                    $filter['date_from'] = date('Y-m-d',strtotime($date_from));
                }else{
                    $filter['date_from'] = '';
                }
                if($date_to != ''){
                    $filter['date_to'] = date('Y-m-d',strtotime($date_to));
                }else{
                    $filter['date_to'] = '';
                }
         
                $filter['year']= $year;
         
                if($payment_type[0] == 'ALL'){
                    $filter['payment_type'] = '';
                }else{
                    $filter['payment_type'] = $payment_type;
                }
                $filter['term_name'] = $term_name;
                if($settlement_type=="ALL"){
                    $filter['settlement_type'] = "";
                }else{
                    $filter['settlement_type'] = $settlement_type;
                }
                   
                    $studentInfo = $fee->getManagementFeeForReport($filter);
                    foreach($studentInfo as $std){
                        $term_name = $std->term_name;
                        $stdInfo = $student->getStudentForFeeReport($std->application_no,$year);
                        $section_name = $stdInfo->section_name;
                       
         
                        if(date('d-m-Y',strtotime($std->transaction_date)) == '30-11--0001' || date('d-m-Y',strtotime($std->transaction_date)) == '01-01-1970' || $std->transaction_date == '0000-00-00'){
                            $transaction_date = '';
                        }else{
                            $transaction_date = date('d-m-Y',strtotime($std->transaction_date));
                        }
        
                        if(date('d-m-Y',strtotime($std->dd_date)) == '30-11--0001'|| date('d-m-Y',strtotime($std->dd_date)) == '01-01-1970'|| $std->dd_date == '0000-00-00'){
                            $dd_date = '';
                        }else{
                            $dd_date = date('d-m-Y',strtotime($std->dd_date));
                        }
                        if(date('d-m-Y',strtotime($std->bank_settlement_date)) == '30-11--0001' || date('d-m-Y',strtotime($std->bank_settlement_date)) == '01-01-1970' || $std->bank_settlement_date == '0000-00-00'){

                            $bank_settlement_date = '';
                        }else{
                            $bank_settlement_date = date('d-m-Y',strtotime($std->bank_settlement_date));
                        }
                        if($stdInfo->discontinued_status == 1 || $stdInfo->is_deleted == 1){
                            $status = 'INACTIVE';
                         }else{
                            $status = 'ACTIVE';
                         }
                         if($std->bank_settlement_status == 1){
                            $settlement_status = 'SETTLED';
                        }else{
                            $settlement_status = 'PENDING';
                        }
                         if($status == $student_type){
        
                ?>  
                <tr>
                        <th style="border: 1px solid black;text-align: center;width: 50px;"><?php echo $j++; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo strtoupper($stdInfo->student_name); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $term_name; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $stdInfo->stream_name; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $section_name; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $stdInfo->application_no; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->receipt_number; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->payment_type; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->transaction_number; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $transaction_date; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->dd_number; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $dd_date; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->bank_name; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($std->paid_amount,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($std->excess_amount,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo date('d-m-Y',strtotime($std->payment_date)); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $bank_settlement_date; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $settlement_status; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $status; ?></th>

                </tr>   
                <?php  }else if($student_type == 'ALL'){?>
                    <tr>
                        <th style="border: 1px solid black;text-align: center;width: 50px;"><?php echo $j++; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo strtoupper($stdInfo->student_name); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $term_name; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $stdInfo->stream_name; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $section_name; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $stdInfo->application_no; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->receipt_number; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->payment_type; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->transaction_number; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $transaction_date; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->dd_number; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $dd_date; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->bank_name; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($std->paid_amount,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($std->excess_amount,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo date('d-m-Y',strtotime($std->payment_date)); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $bank_settlement_date; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $settlement_status; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $status; ?></th>

                </tr>   
                <?php  }?>
                <?php   
                $total_paid_amt += $std->paid_amount;   
                $total_excess_amt += $std->excess_amount;     
                    }
               
                ?>
            
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">TOTAL</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_paid_amt,2); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo number_format($total_excess_amt,2); ?></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </table>
        </div>
    </div>