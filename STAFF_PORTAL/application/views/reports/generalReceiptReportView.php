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
                    <th style="border: 1px solid black;text-align: center;width: 100px;" colspan="4">FEE PAID DATEWISE INFO From:-<?php echo (date('d-m-Y',strtotime($date_from)) == '01-01-1970' ? '-' : date('d-m-Y',strtotime($date_from)) ). " To:".(date('d-m-Y',strtotime($date_to)) == '01-01-1970' ? '-' : date('d-m-Y',strtotime($date_to))); ?></th>
                </tr>
                <tr>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Date</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Miscellaneous</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Tuition Fee</th>
                    <!-- <th style="border: 1px solid black;text-align: center;width: 100px;">Non-Government Fee</th> -->
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Total Fee</th>
                </tr>
                <?php 
                $mis_grand_total = $tuition_grand_total = $grand_total = 0;
                    foreach ($date_range as $date) {
                        $mis_grand_total += $mis_total = $feemodel->getSumOfMisByDate($date->format('Y-m-d'));
                        $tuition_grand_total += $tuition_total = $feemodel->getSumOfFeeByDate($date->format('Y-m-d'));
                        $grand_total += $total = $mis_total + $tuition_total;
                    if(($total) > 0){
                ?>  
                <tr>
                        <td style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $date->format('d-m-Y'); ?></th>
                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $mis_total; ?></th>
                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $tuition_total; ?></th>
                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $total; ?></th>
                </tr>        
                <?php        
                        }
                }
                ?>
                <tr>
                        <th style="border: 1px solid black;text-align: center;width: 100px;">TOTAL</th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $mis_grand_total ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $tuition_grand_total ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $grand_total ?></th>
                </tr>
            </table>
        </div>
    </div>