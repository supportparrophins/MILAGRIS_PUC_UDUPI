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
                    <th style="border: 1px solid black;text-align: center;width: 100px;" colspan="14"><?php echo EXCEL_TITLE; ?></th>
                </tr>
                <tr>
                    <th style="border: 1px solid black;text-align: center;width: 100px;" colspan="14">Datewise Trasnport Fee Report - <?php echo $display_year; ?></th>
                </tr>
                <tr>
                    <th style="border: 1px solid black;text-align: center;width: 50px;">SL.No.</th>
                    <th style="border: 1px solid black;text-align: center;width: 130px;">Name</th>
                    <th style="border: 1px solid black;text-align: center;width: 80px;">Term</th>
                    <th style="border: 1px solid black;text-align: center;width: 80px;">Stream</th>
                    <th style="border: 1px solid black;text-align: center;width: 80px;">Section</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Application No.</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Payment Date</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Receipt No.</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Payment Mode</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Transaction ID</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Amount Paid</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Amount Pending</th>
                    <th style="border: 1px solid black;text-align: center;width: 130px;">Bank Settlement Date</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Settlement Status</th>

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
                if($settlement_type == "ALL"){
                $filter['settlement_type'] = "";
                }else{
                    $filter['settlement_type'] = $settlement_type;
                }
         
                if($payment_type[0] == 'ALL'){
                    $filter['payment_type'] = '';
                }else{
                    $filter['payment_type'] = $payment_type;
                }
                if($stream_name == "ALL"){
                $filter['stream_name'] = "";
                }else{
                    $filter['stream_name'] = $stream_name;
                }
                $filter['term_name'] = $term_name;
                   
                    $studentInfo = $transport->getDatewiseFeeForReport($filter);
                    foreach($studentInfo as $std){
                        if($std->payment_type == 'DD'){
                            $transaction_number = $std->dd_number;
                        }else if($std->payment_type == 'CARD'){
                            $transaction_number = $std->transaction_number;
                        }else if($std->payment_type == 'UPI'){
                            $transaction_number = $std->upi_ref_no;
                        }
                        if(date('d-m-Y',strtotime($std->bank_settlement_date)) == '30-11--0001' || date('d-m-Y',strtotime($std->bank_settlement_date)) == '01-01-1970' || $std->bank_settlement_date == '0000-00-00'){
                            $bank_settlement_date = '';
                        }else{
                            $bank_settlement_date = date('d-m-Y',strtotime($std->bank_settlement_date));
                        }
                        if($std->bank_settlement_status == 1){
                            $settlement_status = 'SETTLED';
                        }else{
                             $settlement_status = 'PENDING';
                        }
                        $term_name = $std->term_name;
                        $stdInfo = $student->getStudentForFeeReport($std->student_id,$year);
                        $section_name = $stdInfo->section_name;
                     ?>  
                <tr>
                        <th style="border: 1px solid black;text-align: center;width: 50px;"><?php echo $j++; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo strtoupper($stdInfo->student_name); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $term_name; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $stdInfo->stream_name; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $section_name; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $stdInfo->application_no; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo date('d-m-Y',strtotime($std->payment_date)); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->receipt_no; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->payment_type; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $transaction_number; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->bus_fees; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $std->pending_balance; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $bank_settlement_date; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $settlement_status; ?></th>
                </tr>   
               
                <?php   
                $total_paid_amt += $std->bus_fees;
                // $total_pending_amt += $std->pending_balance;     
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
                    <th style="border: 1px solid black;text-align: center;width: 100px;">TOTAL</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_paid_amt,2); ?></th>
                    <!-- <th style="border: 1px solid black;text-align: center;width: 100px;"><?php// echo number_format($total_pending_amt,2); ?></th> -->
                    <th></th>
                    <th></th>
                </tr>
            </table>
        </div>
    </div>