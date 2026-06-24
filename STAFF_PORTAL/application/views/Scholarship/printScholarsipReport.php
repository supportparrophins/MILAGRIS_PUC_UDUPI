<?php
    ini_set('memory_limit', '1024M');
    ini_set("pcre.backtrack_limit", "5000000");
    ini_set('max_execution_time', -1);?>
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
                    <th style="border: 1px solid black;text-align: center;width: 100px;" colspan="20"><?php echo EXCEL_TITLE; ?></th>
                </tr>
                <tr>
                    <th style="border: 1px solid black;text-align: center;width: 100px;" colspan="20">SCHOLARSHIP REPORT</th>
                </tr>
                <tr>
                    <th style="border: 1px solid black;text-align: center;width: 90px;">SL.No.</th>
                    <th style="border: 1px solid black;text-align: center;width: 90px;">Name</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Application No.</th>
                    <th style="border: 1px solid black;text-align: center;width: 150px;">Scholarship Code</th>
                    <th style="border: 1px solid black;text-align: center;width: 150px;">Society</th>
                    <th style="border: 1px solid black;text-align: center;width: 80px;">Term Name</th>
                    <th style="border: 1px solid black;text-align: center;width: 80px;">Scholarship Type</th>
                    <th style="border: 1px solid black;text-align: center;width: 80px;">Application Date</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Amount Requested</th>
                    <th style="border: 1px solid black;text-align: center;width: 80px;">Scholarship Amount</th>
                    <th style="border: 1px solid black;text-align: center;width: 80px;">Payment Date</th>
                    <th style="border: 1px solid black;text-align: center;width: 80px;">Debit A/C No.</th>
                    <th style="border: 1px solid black;text-align: center;width: 150px;">Credit A/C No.</th>
                    <th style="border: 1px solid black;text-align: center;width: 150px;">Recommended By</th>
                    <th style="border: 1px solid black;text-align: center;width: 150px;">Sanctioned By</th>
                    <th style="border: 1px solid black;text-align: center;width: 150px;">Remarks</th>

                </tr>
                <?php 
                $filter = array();
                $filter = $dt_filter;
                $j=1;
                $total_amount_request = 0;
                $total_scholarship_amount = 0;
            
                    foreach($scholarshipInfo as $scholarshipRecords){
                      
                        if(date('d-m-Y',strtotime($scholarshipRecords->application_date)) == '30-11--0001'|| date('d-m-Y',strtotime($scholarshipRecords->application_date)) == '01-01-1970'|| $scholarshipRecords->application_date == '0000-00-00'){
                            $application_date = '';
                        }else{
                            $application_date = date('d-m-Y',strtotime($scholarshipRecords->application_date));
                        }
                      
                ?>  
                <tr>
                        <th style="border: 1px solid black;text-align: center;width: 90px;"><?php echo $j++; ?></th>
                        <th style="border: 1px solid black; text-align: center; width: 90px;"><?php echo $scholarshipRecords->student_row_id; ?></th>
                        <th style="border: 1px solid black; text-align: center; width: 100px;"><?php echo $scholarshipRecords->application_number; ?></th> <!-- Match application number -->
                        <th style="border: 1px solid black; text-align: center; width: 150px;"><?php echo strtoupper($scholarshipRecords->scholarship_code); ?></th>
                        <th style="border: 1px solid black; text-align: center; width: 150px;"><?php echo strtoupper($scholarshipRecords->scholarship_society); ?></th>
                        <th style="border: 1px solid black; text-align: center; width: 150px;"><?php echo strtoupper($scholarshipRecords->term_name); ?></th>
                        <th style="border: 1px solid black; text-align: center; width: 150px;"><?php echo strtoupper($scholarshipRecords->scholarship_type); ?></th>
                        <th style="border: 1px solid black; text-align: center; width: 100px;"><?php echo date('d-m-Y', strtotime($application_date)); ?></th>
                        <th style="border: 1px solid black; text-align: center; width: 120px;"><?php echo number_format($scholarshipRecords->amount_requested,2); ?></th>
                        <th style="border: 1px solid black; text-align: center; width: 120px;"><?php echo number_format($scholarshipRecords->scholarship_amount, 2); ?></th>
                        <th style="border: 1px solid black; text-align: center; width: 100px;"><?php echo date('d-m-Y', strtotime($scholarshipRecords->payment_date)); ?></th>
                        <th style="border: 1px solid black; text-align: center; width: 150px;"><?php echo strtoupper($scholarshipRecords->debit_ac_no); ?></th>
                        <th style="border: 1px solid black; text-align: center; width: 150px;"><?php echo strtoupper($scholarshipRecords->credit_ac_no); ?></th>
                        <th style="border: 1px solid black; text-align: center; width: 150px;"><?php echo strtoupper($scholarshipRecords->recommended_by); ?></th>
                        <th style="border: 1px solid black; text-align: center; width: 150px;"><?php echo strtoupper($scholarshipRecords->sanctioned_by); ?></th>
                        <th style="border: 1px solid black; text-align: center; width: 200px;"><?php echo $scholarshipRecords->remarks; ?></th>


                       
                </tr>        
                <?php 
               
                    $total_amount_request += $scholarshipRecords->amount_requested; 
                    $total_scholarship_amount += $scholarshipRecords->scholarship_amount; 

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
                    <th style="border: 1px solid black;text-align: center;width: 100px;">TOTAL</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_amount_request,2); ?></th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo number_format($total_scholarship_amount,2); ?></th>
                
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
         
                </tr>
               
                
            </table>
        </div>
    </div>