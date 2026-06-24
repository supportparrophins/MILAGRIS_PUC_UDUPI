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
                    <th style="border: 1px solid black;text-align: center;width: 100px;" colspan="13"><?php echo EXCEL_TITLE; ?></th>
                </tr>
                <tr>
                    <th style="border: 1px solid black;text-align: center;width: 100px;" colspan="13">MISCELLANEOUS FEE INFO - <?php echo $display_year; ?></th>
                </tr>
                <tr>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">SL.No.</th>
                    <th style="border: 1px solid black;text-align: center;width: 130px;">Paid Date</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Receipt No.</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Student Status</th>
                    <th style="border: 1px solid black;text-align: center;width: 200px;">Student ID</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Name</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Term</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Stream</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Miscellaneous Type</th>
                    <!-- <th style="border: 1px solid black;text-align: center;width: 100px;">Quantity</th> -->
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Amount</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Payment Type</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Transaction ID</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Bank Settlement Date</th>

                    <!-- <th style="border: 1px solid black;text-align: center;width: 100px;">Total Amount</th> -->
                </tr>
                <?php 
                $filter = array();
                $filter = $dt_filter;
                $j=1;
                // for($i=0; $i<count($miscellaneous);$i++){  
                    // $filter['miscellaneous'] = $miscellaneous[$i];
                    $miscellaneousFeePaidInfo = $fee->getMiscellaneousFeesInfoReport($filter);
                    foreach($miscellaneousFeePaidInfo as $fee){
                        if(empty($fee->qnty)){
                            $total_amount =  $fee->amount;   
                        }else {
                            $total_amount = $fee->qnty * $fee->amount;
                        }
                        if(date('d-m-Y',strtotime($fee->bank_settlement_date)) == '30-11--0001' || date('d-m-Y',strtotime($fee->bank_settlement_date)) == '01-01-1970' || $fee->bank_settlement_date == '0000-00-00'){
                            $date = '';
                        }else{
                            $date = date('d-m-Y',strtotime($fee->bank_settlement_date));
                        }
                        if($fee->payment_type == 'NEFT'){ 
                            $transaction_id = $fee->ref_number; }
                        elseif($fee->payment_type == 'UPI'){ 
                            $transaction_id = $fee->upi_ref_no; 
                        }elseif($fee->payment_type == 'CARD' || $fee->payment_type == 'BANK' || $fee->payment_type == 'UPI'){ 
                            $transaction_id = $fee->transaction_number; 
                        }else{ 
                            $transaction_id = $fee->order_id; 
                        } 
                        if($fee->student_status == 'Active'){
                            $student_status = 'ACTIVE/ALUMNI';
                        }else{
                            $student_status = $fee->student_status;
                        }
                ?>  
                <tr>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $j++; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo date('d-m-Y',strtotime($fee->date)); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $fee->receipt_no; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $student_status; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $fee->register_no; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 200px;"><?php echo strtoupper($fee->student_name); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $fee->term; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $fee->stream; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $fee->miscellaneous_type; ?></th>
                        <!-- <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $fee->qnty; ?></th> -->
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($fee->amount,2); ?></th>
                        <!-- <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $total_amount; ?></th> -->
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $fee->payment_type; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $transaction_id; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $date; ?></th>
                        </tr>        
                <?php 
                $total_paid_amt += $fee->amount;       
                    }
                // }
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
                    <th style="border: 1px solid black;text-align: center;width: 100px;">TOTAL</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_paid_amt,2); ?></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </table>
        </div>
    </div>