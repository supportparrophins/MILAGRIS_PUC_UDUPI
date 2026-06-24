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
                    <th style="border: 1px solid black;text-align: center;width: 100px;" colspan="5">FEE PAID DATEWISE INFO From:-<?php echo (date('d-m-Y',strtotime($date_from)) == '01-01-1970' ? '-' : date('d-m-Y',strtotime($date_from)) ). " To:".(date('d-m-Y',strtotime($date_to)) == '01-01-1970' ? '-' : date('d-m-Y',strtotime($date_to))); ?></th>
                </tr>
                <tr>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Date</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Government Fee</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Non-Government Fee</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Management Fee</th>
                    <th style="border: 1px solid black;text-align: center;width: 100px;">Total Fee</th>
                </tr>
                <?php 
                    foreach ($date_range as $date) {
                        $totalSum = $feemodel->getSumOfFeeByDate($date->format('Y-m-d'));
                        if($totalSum > 0){
                ?>  
                <tr>
                        <td style="border: 1px solid black;text-align: center;width: 130px;"><?php echo $date->format('d-m-Y'); ?></th>
                        <?php
                        $govt = $feemodel->getSumOfFeeByDateType($date->format('Y-m-d'),'GOVT');
                        $govt_total += $govt;
                        ?>
                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $govt; ?></th>
                        <?php
                        $nongovt = $feemodel->getSumOfFeeByDateType($date->format('Y-m-d'),'NON-GOVT');;
                        $nongovt_total += $nongovt;
                        ?>
                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $nongovt; ?></th>
                        <?php
                        $management = $feemodel->getSumOfFeeByDateType($date->format('Y-m-d'),'MANAGEMENT');;
                        $management_total += $management;
                        ?>
                        <td style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $management; ?></th>
                        
                       
                        <?php
                        $total_sum += $totalSum;
                        ?>
                        <td style="border: 1px solid black;text-align: center;width: 200px;"><?php echo $totalSum; ?></th>
                </tr>        
                <?php        
                        }
                }
                ?>
                <tr>
                        <th style="border: 1px solid black;text-align: center;width: 100px;">TOTAL</th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $govt_total ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $nongovt_total ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $management_total ?></th>
                        <th style="border: 1px solid black;text-align: center;width: 100px;"><?php echo $total_sum ?></th>
                </tr>
            </table>
        </div>
    </div>