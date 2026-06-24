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
                    <th style="border: 1px solid black;text-align: center;width: 100px;" colspan="6">FEE PAID BRIEF INFO From:-<?php echo (date('d-m-Y',strtotime($date_from)) == '01-01-1970' ? '-' : date('d-m-Y',strtotime($date_from)) ). " To:".(date('d-m-Y',strtotime($date_to)) == '01-01-1970' ? '-' : date('d-m-Y',strtotime($date_to))); ?></th>
                </tr>
                <tr>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Term</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Stream</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Govt Fee</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Non-Govt Fee</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Management Fee</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Total Fee</th>
                </tr>
                <?php 
                    $filter['term'] = "I PUC";
                    $filter['date_from'] = $date_from;
                    $filter['date_to'] = $date_to;
                    $govt_total = $nongovt_total = $management_total = $total_sum= 0;
                    foreach($streamInfo as $stream){
                        $filter['stream'] = $stream->stream_name;
                ?>  
                <tr>
                        <th style="border: 1px solid black;text-align: center;width: 100px;">I PUC</th>
                        <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $filter['stream']; ?></th>
                        <?php
                        $filter['fee_type'] = 'GOVT';
                        $govt = $feemodel->getFeePaymentInfoForBriefReport($filter);
                        $govt_total += $govt;
                        ?>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $govt; ?></th>
                        <?php
                        $filter['fee_type'] = 'NON-GOVT';
                        $nongovt = $feemodel->getFeePaymentInfoForBriefReport($filter);
                        $nongovt_total += $nongovt;
                        ?>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $nongovt; ?></th>
                        <?php
                        $filter['fee_type'] = 'MANAGEMENT';
                        $management = $feemodel->getFeePaymentInfoForBriefReport($filter);
                        $management_total += $management;
                        ?>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $management; ?></th>
                        <?php
                        $total_sum += $management + $govt + $nongovt;
                        ?>
                        <th style="border: 1px solid black;text-align: center;width: 200px;"><?php echo $management + $govt + $nongovt; ?></th>
                </tr>        
                <?php        
                    
                ?>
                    
                <?php
                }
                ?>
                <tr>
                        <th style="border: 1px solid black;text-align: center;width: 100px;" colspan = "2">TOTAL</th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $govt_total ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $nongovt_total ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $management_total ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $total_sum ?></th>
                </tr>
                <tr><td colspan="6"></td></tr>
                <?php 
                    $filter['term'] = "II PUC";
                    $govt_total2 = $nongovt_total2 = $management_total2 = $total_sum2 = 0;
                    foreach($streamInfo as $stream){
                        $filter['stream'] = $stream->stream_name;
                ?>  
                <tr>
                        <th style="border: 1px solid black;text-align: center;width: 100px;">II PUC</th>
                        <th style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $filter['stream']; ?></th>
                        <?php
                        $filter['fee_type'] = 'GOVT';
                        $govt = $feemodel->getFeePaymentInfoForBriefReport($filter);
                        $govt_total2 += $govt;
                        ?>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $govt; ?></th>
                        <?php
                        $filter['fee_type'] = 'NON-GOVT';
                        $nongovt = $feemodel->getFeePaymentInfoForBriefReport($filter);
                        $nongovt_total2 += $nongovt;
                        ?>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $nongovt; ?></th>
                        <?php
                        $filter['fee_type'] = 'MANAGEMENT';
                        $management = $feemodel->getFeePaymentInfoForBriefReport($filter);
                        $management_total2 += $management;
                        ?>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $management; ?></th>
                        <?php
                        $total_sum2 += $management + $govt + $nongovt;
                        ?>
                        <th style="border: 1px solid black;text-align: center;width: 200px;"><?php echo $management + $govt + $nongovt; ?></th>
                </tr>        
                <?php        
                    
                ?>
                    
                <?php
                }
                ?>
                <tr>
                        <th style="border: 1px solid black;text-align: center;width: 100px;" colspan = "2">TOTAL</th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $govt_total2 ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $nongovt_total2 ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $management_total2 ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $total_sum2 ?></th>
                </tr>
                <tr><td colspan="6"></td></tr>
                <tr>
                        <th style="border: 1px solid black;text-align: center;width: 100px;" colspan = "2">GRAND TOTAL</th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $govt_total + $govt_total2 ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $nongovt_total + $nongovt_total2 ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $management_total + $management_total2 ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $total_sum + $total_sum2 ?></th>
                </tr>
            </table>
        </div>
    </div>