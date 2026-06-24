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
                    <th style="border: 1px solid black;text-align: center;width: 100px;" colspan="13">CREDIT NOTE INFO - <?php echo $display_year; ?></th>
                </tr>
                <tr>
                    <th style="border: 1px solid black;text-align: center;width: 80px;">SL.No.</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Application No.</th>
                    <th style="border: 1px solid black;text-align: center;width: 160px;">Name</th>
                    <th style="border: 1px solid black;text-align: center;width: 80px;">Class</th>
                    <th style="border: 1px solid black;text-align: center;width: 80px;">Stream</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Receipt No.</th>
                    <th style="border: 1px solid black;text-align: center;width: 80px;">Amount</th>
                    <th style="border: 1px solid black;text-align: center;width: 150px;">Remarks</th>
                </tr>
                <?php 
                $filter = array();
                $filter = $dt_filter;
                $j=1;
                $filter['year']= $year;
                if($type == 'Mgmt'){
                    $studentInfo = $fee->getCancelReceiptInfoForReport($filter);
                }else{
                    $studentInfo = $fee->getCancelReceiptInfoForReportForGovt($filter);
                }
                    foreach($studentInfo as $fee){
                       
                ?>  
                <tr>
                        <th style="border: 1px solid black;text-align: center;width: 90px;"><?php echo $j++; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $fee->application_no; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo strtoupper($fee->student_name); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $fee->term_name; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo $fee->stream_name; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $fee->receipt_number; ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 80px;"><?php echo number_format($fee->paid_amount,2); ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 150px;"><?php echo $fee->remarks; ?></th>

                       
                </tr>        
                <?php 
                    $total_paid_amt += $fee->paid_amount;
                    }
                ?>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">TOTAL</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_paid_amt,2); ?></th>
                    <th></th>
                    <th></th>
         
                </tr>
            </table>
        </div>
    </div>