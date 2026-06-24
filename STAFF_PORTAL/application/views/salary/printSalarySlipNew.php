<style>
.break {
    page-break-before: always;
}

.break_after {
    page-break-before: none;
}



table {

    width: 100% !important;

}



/*.border{

    border: 2px solid black;

}*/

.text-center {
    text-align: center;
}
.text-white {
    color: white;
}


.border_full {

    border: 1px solid black;

    /* height: 90% !important; */

}

.border_bottom {

    border-bottom: 1px solid black;

}

.hr_line {

    margin: 0px;

    color: black;

}



.table_bordered {

    border-collapse: collapse;

}

.table_bordered th,
.table_bordered td {

    border-top: 1px solid black;

    border-right: 1px solid black;

    padding: 6px;

}



.table_bordered th .border_right_none,
.table_bordered td .border_right_none {

    border-right: 1px solid transparent !important;

}
.table {
    width: 100%;
    border-collapse: collapse;
}
.text_highlight {
    font-family: Arial, sans-serif;
}
.mt-2 {
    margin-top: 20px;
}

.mt-0 {
    margin-top: 0;
}
.logo {
    display: block;
    margin: 0 auto;
}
.title {
    font-size: 26px;
    margin: 0;
}
.address {
    font-size: 16px;
    margin: 0;
}
.address {
    text-align: center;          /* or left if you want */
    line-height: 1.6;
}

.address-row {
    display: flex;
    justify-content: center;     /* space-between if full width */
    gap: 40px;                   /* controls spacing */
    font-weight: 500;
}

</style>

<?php 
    // require APPPATH . 'views/includes/db.php';
    $totalStaffCount = count($staffData);
    foreach($staffData as $std){

        $totalStaffCount--;

?>

<div class="container border_full">

    <div class="row">

    <table class="table text_highlight mt-0">
        <tr>
            <td class="text-center" width="20%">
                <img class="mt-0 logo" width="100" height="100" src="<?php echo INSTITUTION_LOGO; ?>" alt="logo">
            </td>
            <td width="80%" class="text-left">
                <div class="header-content">
                    <b class="title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo TITLE; ?></b><br>
                    <!-- <p class="address">P.B. No. 720, KODIALBAIL POST, MANGALURU - 575 003 <br>
                                        Phone: (0824) 2449716, 2449717 <br>
                                        e-mail: staloysiuspuc@gmail.com &emsp;Website:www.staloysiuspuc.in
                       <?php //echo SALARY_ADDRESS; ?> <br> Dise Code : <?php //echo SALARY_DISE_CODE; ?> &emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;College Code : <?php //echo SALARY_ADDRESS_NEW; ?>
                    </p> -->
                    <p class="address">
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ADDRESS; ?>
                    </p>

                </div>
            </td>
        </tr>
    </table>
          
        <table class="table_bordered text_highlight">
             <colgroup>
                <col style="width:20%"> 
                <col style="width:30%">  
                <col style="width:20%"> 
                <col style="width:30%">  
            </colgroup>
            <tr> 
                <td colspan="4" class="text-center text-black" style="background-color: #e7e2f9; padding: 8px; font-size: 17px;font-weight: 900;"><b>PAYSLIP FOR <?php echo strtoupper($std->month); ?> <?php echo $std->year ?></b></td>
            </tr>
            <tr>
                <td style="background-color: #e7e2f9; font-size:13px;" width="25%"><b>NAME</b></td>
                <td style="font-size:13px;"><b><?php echo strtoupper($std->name) ?></b></td>
                <td style="background-color: #e7e2f9; font-size:13px;" width="25%"><b>PAN</b></td>
                <!-- <td width="25%" style="font-size:13px;"><?php echo strtoupper($std->pan_no);?></td> -->
                <td style="font-size:13px;">
                    <?php
                        $panNo = $std->pan_no;
                        $maskedPanNo = str_repeat('X', max(0, strlen($panNo) - 3)) . substr($panNo, -3);
                        echo $maskedPanNo;
                    ?>
                </td>
            </tr>
            <tr>
                <!-- <td style="background-color: #e7e2f9; font-size:13px;" width="25%"><b>EMPLOYEE CODE</b></td>
                <td style="font-size:13px;"><?php //echo $std->employee_id ?></td> -->
                <td style="background-color: #e7e2f9; font-size:13px;" width="25%"><b>GENDER</b></td>
                <td style="font-size:13px;"><?php echo ucfirst($std->gender); ?></td>
            <td style="background-color: #e7e2f9; font-size:13px;" width="25%"><b>DESIGNATION</b></td>
                <td style="font-size:13px;"><?php echo strtoupper($std->role) ?></td>
            </tr>
            <tr>
                <!-- <td style="background-color: #e7e2f9; font-size:13px;" width="25%"><b>DESIGNATION</b></td>
                <td style="font-size:13px;"><?php //echo strtoupper($std->designation) ?></td> -->
                <td style="background-color: #e7e2f9; font-size:13px;" width="25%"><b>BANK ACCOUNT NUMBER</b></td>
                <!-- <td style="font-size:13px;"><?php echo $std->account_no; ?></td> -->
                <td style="font-size:13px;">
                    <?php
                        $accNo = $std->account_no;
                        $maskedAccNo = str_repeat('X', max(0, strlen($accNo) - 3)) . substr($accNo, -3);
                        echo $maskedAccNo;
                    ?>
                </td>
                <td style="background-color: #e7e2f9; font-size:13px;" width="25%"><b>CONTACT NO.</b></td>
                <td style="font-size:13px;"><?php echo strtoupper($std->mobile_one) ?></td>
            </tr>
            <tr>
                <!-- <td style="background-color: #e7e2f9; font-size:13px;" width="25%"><b>CONTACT NO.</b></td>
                <td style="font-size:13px;"><?php //echo strtoupper($std->mobile_one) ?></td> -->
                <td style="background-color: #e7e2f9; font-size:13px;" width="35%"><b>PF ACCOUNT NUMBER</b></td>
                <td style="font-size:13px;"><?php echo $std->pf_number; ?></td>
                <td style="background-color: #e7e2f9; font-size:13px;" width="15%"><b>DATE OF JOINING</b></td>
                <td style="font-size:13px;"><?php echo date('d-m-Y',strtotime($std->doj)); ?></td>
            </tr>
            <tr>
                <!-- <td style="background-color: #e7e2f9; font-size:13px;" width="25%"><b>DATE OF JOINING</b></td>
                <td style="font-size:13px;"><?php //echo date('d-m-Y',strtotime($std->doj)); ?></td> -->
                <td style="background-color: #e7e2f9;border-bottom: 1px solid black; font-size:13px;" width="25%"><b>PF UAN</b></td>
                <td style="border-bottom: 1px solid black; font-size:13px;"><?php echo $std->uan_no; ?></td>
                <?php if(!empty($std->esi_code)){
                    $esi_code = $std->esi_code;
                }else{
                    $esi_code = 'NA';
                } ?>
                <td style="background-color: #e7e2f9; border-bottom: 1px solid black; font-size:13px;" width="25%"><b>ESI CODE</b></td>
                <td style="border-bottom: 1px solid black; font-size:13px;"><?php echo $esi_code; ?></td>
            </tr>
            
            
            <!-- <tr>
                <?php //if(!empty($std->esi_code)){
                //     $esi_code = $std->esi_code;
                // }else{
                //     $esi_code = 'NA';
                //} ?> -->
                <!-- <td style="background-color: #e7e2f9; border-bottom: 1px solid black; font-size:13px;" width="25%"><b>TAX REGIME</b></td>
                <td style="border-bottom: 1px solid black; font-size:13px;"><?php //echo $std->tax_regime; ?></td> -->
                <!-- <td style="background-color: #e7e2f9; border-bottom: 1px solid black; font-size:13px;" width="25%"><b>ESI CODE</b></td>
                <td style="border-bottom: 1px solid black; font-size:13px;"><?php //echo $esi_code; ?></td>
                <td style="background-color: #e7e2f9; border-bottom: 1px solid black; font-size:13px;" width="25%"></td>
                <td style="border-bottom: 1px solid black; font-size:13px;"></td>
            </tr> -->


        </table>
        <br>

        <table class="table_bordered text_highlight">
            <tr>
                <td class="text-center text-black" style="background-color: #e7e2f9; padding: 6px; font-size: 15px;" width="35%"><b>TOTAL DAYS</b></td>
                <td class="text-center text-black" style="background-color: #e7e2f9; padding: 6px; font-size: 15px;" width="35%"><b>WORKING DAYS</b></td>
                <td class="text-center text-black" style="background-color: #e7e2f9; padding: 6px; font-size: 15px;" width="35%"><b>LOP DAYS</b></td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid black; padding: 6px;" class="text-center"><?php echo $std->total_days; ?></td>
                <td style="border-bottom: 1px solid black; padding: 6px;" class="text-center"><?php echo $std->working_day; ?></td>
                <td style="border-bottom: 1px solid black; padding: 6px;" class="text-center"><?php echo $std->total_days - $std->working_day; ?></td>
            </tr>
        </table>

        <table>
            <tr>
                <td width="50%" style="vertical-align: top;">
                    <br>
                    <table class="table_bordered text_highlight">
                        <tr>
                            <td colspan="2" class="text-center text-black" style="border-left: 1px solid black; padding: 6px; background-color: #e7e2f9; font-size: 15px;" width="100%"> <b>EARNINGS (INR)</b></td>
                        </tr>
                        <tr>
                            <td style="border-left: 1px solid black; padding: 6px; background-color: #e7e2f9; font-size:13px;" width="25%"><b>COMPONENTS</b></td>
                            <!-- <td style="background-color: #e7e2f9; font-size:13px;"  width="25%"><b>RATE</b></td> -->
                            <td style="background-color: #e7e2f9; font-size:13px; text-align: center;"  width="25%"><b>AMOUNT</b></td>
                        </tr>
                        <?php 
                        if($std->year == STAFF_SALARY_YEAR){
                            $staff_salary_year = $std->year ;
                        }else{
                            $staff_salary_year = STAFF_SALARY_YEAR ;
                        }
                         $basicInfo = $salaryModel->getEarningInfo($std->staff_id,$staff_salary_year,'BASIC');
                         $conInfo = $salaryModel->getEarningInfo($std->staff_id,$staff_salary_year,'CON');
                         $ccaInfo = $salaryModel->getEarningInfo($std->staff_id,$staff_salary_year,'CCA');
                         $licInfo = $salaryModel->getEarningInfo($std->staff_id,$staff_salary_year,'LIC');

                         $daInfo = $salaryModel->getEarningInfo($std->staff_id,$staff_salary_year,'DA');
                         $hraInfo = $salaryModel->getEarningInfo($std->staff_id,$staff_salary_year,'HRA');
                         $othersInfo = $salaryModel->getEarningInfo($std->staff_id,$staff_salary_year,'OTHERS');
                         
                         $pfInfo = $salaryModel->getdeductionInfo($std->staff_id,$staff_salary_year,'PF');
                         $esiInfo = $salaryModel->getdeductionInfo($std->staff_id,$staff_salary_year,'ESI');
                         $ptInfo = $salaryModel->getdeductionInfo($std->staff_id,$staff_salary_year,'PROF.TAX');
                         $otherInfo = $salaryModel->getdeductionInfo($std->staff_id,$staff_salary_year,'OTHERS');
                         $licDeduction = $salaryModel->getdeductionInfo($std->staff_id,$staff_salary_year,'LIC');
                         $admchrgInfo = $salaryModel->getdeductionInfo($std->staff_id,$staff_salary_year,'ADM CHRG');
                         $itInfo = $salaryModel->getdeductionInfo($std->staff_id,$staff_salary_year,'IT');
                        ?>
                        <?php if(!empty($basicInfo)){ ?>
                        <tr>
                            <td style="border-left: 1px solid black; padding: 6px; background-color: #e7e2f9; font-size:13px;"><b>BASIC</b></td>
                            <td style="text-align: right;"><?php echo number_format($std->basic,2) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <?php } ?>
                        <?php if(!empty($daInfo)){ ?>
                        <tr>
                            <td style="border-left: 1px solid black; padding: 6px; background-color: #e7e2f9; font-size:13px;"><b>DA(<?php echo $daInfo->value.'%' ?>)</b></td>
                            <td style="text-align: right;"><?php echo number_format($std->da,2) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <?php } ?>
                        <?php if(!empty($hraInfo)){ ?>
                        <tr>
                            <td style="border-left: 1px solid black; padding: 6px; background-color: #e7e2f9; font-size:13px;"><b>HRA(<?php echo $hraInfo->value.'%' ?>)</b></td>
                            <td style="text-align: right;"><?php echo number_format($std->hr,2) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <?php } ?>
                        <!-- <?php if(!empty($conInfo)){ ?>
                        <tr>
                            <td style="border-left: 1px solid black; padding: 6px; background-color: #e7e2f9; font-size:13px;"><b>CONVEYANCE</b></td>
                            <td><?php echo number_format($std->con,2) ?></td>
                        </tr>
                        <?php } ?> -->
                        <?php if(!empty($ccaInfo)){ ?>
                        <tr>
                            <td style="border-left: 1px solid black; padding: 6px; background-color: #e7e2f9; font-size:13px;"><b>CCA</b></td>
                            <td style="text-align: right;"><?php echo number_format($std->cca,2) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <?php } ?>
                        <?php if(!empty($licInfo)){ ?>
                        <tr>
                            <td style="border-left: 1px solid black; padding: 6px; background-color: #e7e2f9; font-size:13px;"><b>LIC</b></td>
                            <td style="text-align: right;"><?php echo number_format($std->lic,2) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <?php } ?>
                        
                        <?php //if(!empty($othersInfo)){ ?>
                            <?php if($std->others != 0){ ?>
                            <tr>
                                <td style="border-left: 1px solid black; padding: 6px; background-color: #e7e2f9; font-size:13px;"><b>OTHER ALLOWANCE</b></td>
                                <td style="text-align: right;"><?php echo number_format($std->others,2) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>
                            <?php } ?>
                        <?php //} ?>
                        
                        <?php if($std->ot_amount != 0){ ?>
                        <tr>
                            <td style="border-left: 1px solid black; padding: 6px; background-color: #e7e2f9; font-size:13px;"><b>OT</b></td>
                            <td style="text-align: right;"><?php echo number_format($std->ot_amount,2) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <?php } ?>
                        <tr>
                        <?php $total_salary = $std->basic + $std->da + $std->con + $std->cca + $std->lic + $std->hr  + $std->others + $std->ot_amount; ?>

                            <td style="border-bottom: 1px solid black; padding: 6px; border-left: 1px solid black; background-color: #e7e2f9; font-size:13px;"><b>TOTAL EARNINGS</b></td>
                            <td style="border-bottom: 1px solid black; padding: 6px; text-align: right;"><b><?php echo number_format($total_salary,2) ?></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                    </table>
                </td>
               
                <td width="50%" style="vertical-align: top;">
                    <br>
                    <table class="table_bordered text_highlight">
                        <tr>
                            <td colspan="2" style="border-left: 1px solid black; padding: 6px; background-color: #e7e2f9; font-size: 15px;" class="text-center text-black"><b>DEDUCTIONS(INR)</b></td>
                        </tr>
                        <tr>
                            <td style="border-left: 1px solid black; padding: 6px; background-color: #e7e2f9; font-size:13px;" width="50%"><b>COMPONENTS</b></td>
                            <td style="background-color: #e7e2f9; font-size:13px; text-align: center;" width="50%"><b>AMOUNT</b></td>
                        </tr>
                        <?php if(!empty($pfInfo)){ ?>
                        <tr>
                            <td style="border-left: 1px solid black; padding: 6px; background-color: #e7e2f9; font-size:13px;" width="50%"><b>EMPLOYEE PF(<?php //echo $pfInfo->value.'%' ?>12%)</b></td>
                            <td width="50%" style="text-align: right;"><?php echo number_format($std->pf,2) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <?php } ?>
                        <?php if(!empty($esiInfo)){ ?>
                        <tr>
                            <td style="border-left: 1px solid black; padding: 6px; background-color: #e7e2f9; font-size:13px;" width="50%"><b>EMPLOYEE ESI(<?php //echo $esiInfo->value.'%' ?>0.75%)</b></td>
                            <td width="50%" style="text-align: right;"><?php echo number_format($std->esi,2) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <?php } ?>
                        <?php if(!empty($ptInfo)){ ?>
                        <tr>
                            <td style="border-left: 1px solid black; padding: 6px; background-color: #e7e2f9; font-size:13px;" width="50%"><b>PROFESSIONAL TAX</b></td>
                            <td width="50%" style="text-align: right;"><?php echo number_format($std->pt,2) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <?php } ?>
                        <?php if(!empty($admchrgInfo)){ ?>
                        <tr>
                            <td style="border-left: 1px solid black; padding: 6px; background-color: #e7e2f9; font-size:13px;" width="50%"><b>ADM CHRG(<?php echo $admchrgInfo->value.'%' ?>)</b></td>
                            <td width="50%" style="text-align: right;"><?php echo number_format($std->admchrg,2) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <?php } ?>
                        <?php if(!empty($otherInfo)){ ?>
                        <tr>
                            <td style="border-left: 1px solid black; padding: 6px; background-color: #e7e2f9; font-size:13px;" width="50%"><b>OTHERS</b></td>
                            <td width="50%" style="text-align: right;"><?php echo number_format($std->other_deduct,2) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <?php } ?>
                         <?php if(!empty($licDeduction)){ ?>
                        <tr>
                            <td style="border-left: 1px solid black; padding: 6px; background-color: #e7e2f9; font-size:13px;" width="50%"><b>LIC</b></td>
                            <td width="50%" style="text-align: right;"><?php echo number_format($std->lic_deduct,2) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <?php } ?>
                        <?php if(!empty($itInfo)){ ?>
                        <tr>
                            <td style="border-left: 1px solid black; padding: 6px; background-color: #e7e2f9; font-size:13px;" width="50%"><b>IT</b></td>
                            <td width="50%" style="text-align: right;"><?php echo number_format($std->it_deduct,2) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <?php } ?>
                        <?php if($std->advance_salary != 0 && (!empty($std->advance_salary))){ ?>
                        <tr>
                            <td style="border-left: 1px solid black; padding: 6px; background-color: #e7e2f9; font-size:12px;" width="50%"><b>ADVANCE SALARY</b></td>
                            <td width="50%" style="text-align: right;"><?php echo number_format($std->advance_salary,2) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <?php } ?>
                        <?php if($std->lop != 0){ ?>
                        <tr>
                            <td style="border-left: 1px solid black; padding: 6px; background-color: #e7e2f9; font-size:13px;" width="50%"><b>LOP</b></td>
                            <td width="50%" style="text-align: right;"><?php echo number_format($std->lop,2) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <?php } ?>

                        <tr>
                            <?php $total_deduction = $std->pf + $std->esi + $std->pt + $std->lop + $std->other_deduct + $std->lic_deduct + $std->admchrg + $std->it_deduct + $std->advance_salary; ?>
                            <td style="border-bottom: 1px solid black; padding: 6px; border-left: 1px solid black; background-color: #e7e2f9; font-size:13px;" width="50%"><b>TOTAL DEDUCTIONS</b></td>
                            <td style="border-bottom: 1px solid black; padding: 6px; text-align: right;" width="50%" ><b><?php echo number_format($total_deduction,2) ?></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>
        <br>
        <table class="table_bordered text_highlight">
            <tr>
                <td style="border-left: 1px solid black; padding: 6px; background-color: #e7e2f9; font-size:13px;"  width="30%"><b>NET PAY (INR)</b></td>
                <td><b><?php echo number_format($std->net_amount,2) ?></b></td>
                
            </tr>
            <tr>
                <td style="border-left: 1px solid black; padding: 6px; background-color: #e7e2f9; border-bottom: 1px solid black; font-size:13px;"  width="30%"><b>NET PAY IN WORDS</b></td>
                <td style="border-bottom: 1px solid black;"><b><?php echo getIndianCurrency(floatval($std->net_amount)).' Only'; ?></b></td>
                
            </tr>
        </table>
        <br>

        

    </div>


</div>
<!-- <span  style="display: block; text-align: center;" class="text_highlight">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <b>Note:</b> This is a system generated payslip, does not require any signature</span> -->
<?php
        if($totalStaffCount != 0){
            echo '<div class="break"></div>';
        }else{
            echo '<div class="break_after"></div>';
        }

 } ?>
<?php 

function getIndianCurrency(float $number) {
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? '' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
}

?>