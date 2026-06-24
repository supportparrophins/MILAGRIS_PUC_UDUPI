<style>

.break { page-break-before: always; } 
.break_after { page-break-before: none; } 

table{
    width: 100% !important;
}

/*.border{
    border: 2px solid black;
}*/
.border_full{
    border: 1.5px solid black;
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
    border-left: 1px solid black;
    border-bottom: 1px solid black;
    padding: 6px;
}

.table_bordered th .border_right_none,.table_bordered td .border_right_none{
    border-right: 1px solid transparent !important;
}
.table_bordered_none th,.table_bordered_none td{
    border-top: none;
    border-right: none;
    border-left: none;
    border-bottom: none;
    padding: 6px;
}

</style>
<div class="container-fluid" style="margin-right:15px; margin-left:15px;">
    <div class="row">
            <table class="table text_highlight border_full">
                <tr>
                    <td style="text-align:center;" width="10%">
                            <img  class=""  width="75" height="75" src="<?php echo INSTITUTION_LOGO; ?>" alt="logo">
                    </td>
                    <td width="90%" style="text-align:center;line-height: 1.3;">
                        <br />
                        <b style="font-size: 24px;margin-bottom: 2px;text-align:right;color: black;"><?php echo TITLE; ?></b><br />
                        <b style="font-size: 15px;margin-bottom: 2px;text-align:right;color: black;">&emsp;<?php echo SCHOLARSHIP_ADDRESS; ?><br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</b><br /><br>
                    </td>
                </tr>
            </table>
            <table  class="table table_bordered border_full" style="font-family:timesnewroman;font-size: 13px;line-height:1.3;border-top:none;margin-top:4px">
                <tr>
                    <td colspan="4" style="text-align:center;color: black;font-size: 16px;"><b>EVENT DETAILS</b></td>
                </tr>
                <tr>
                        <td width="20%" style="text-align:left;border-top:none;border-right:none;"><b>DATE</b></td>
                        <td width="80%" style="text-align:left;border-top:none;border-right:none;"><b><?php echo date('d-m-Y',strtotime($EventInfo->date)); ?></b></td>
                </tr>
                <tr>
                        <td width="20%" style="text-align:left;border-top:none;border-right:none;"><b>TITLE</b></td>
                        <td width="80%" style="text-align:left;border-top:none;border-right:none;"><b><?php echo strtoupper($EventInfo->subject) ?></b></td>
                </tr>
                <tr>
                        <td width="20%" style="text-align:left;border-top:none;border-right:none;"><b>LOCATION</b></td>
                        <td width="80%" style="text-align:left;border-top:none;border-right:none;"><b><?php echo strtoupper($EventInfo->location) ?></b></td>
                </tr>
                <tr>
                        <td width="20%" style="text-align:left;border-top:none;border-right:none;"><b>DESCRIPTION</b></td>
                        <td width="80%" style="text-align:left;border-top:none;border-right:none;"><b><?php echo strtoupper(html_entity_decode($EventInfo->description)) ?></b></td>
                </tr>
            </table>
            <div class="break"></div>
            <table  class="table" style="font-family:timesnewroman;font-size: 13px;line-height:1.3;border-top:none;margin-top:3px">
            <tr>
                    <td colspan="2"><?php if(!empty($EventInfo->image_path)){ ?>
                                        <img height="300" width="350" src="<?php echo base_url() ?>/assets/<?php echo $EventInfo->image_path; ?>"> 
                                    <?php } ?>
                                    <?php if(!empty($EventInfo->image_sub1)){ ?>
                                        <img height="300" width="350" src="<?php echo base_url() ?>/assets/<?php echo $EventInfo->image_sub1; ?>"> 
                                    <?php } ?>
                                    <?php if(!empty($EventInfo->image_sub2)){ ?>
                                        <img height="300" width="350" src="<?php echo base_url() ?>/assets/<?php echo $EventInfo->image_sub2; ?>"> 
                                    <?php } ?>
                                    <?php if(!empty($EventInfo->image_sub3)){ ?>
                                        <img height="300" width="350" src="<?php echo base_url() ?>/assets/<?php echo $EventInfo->image_sub3; ?>"> 
                                    <?php } ?>
                                    <?php if(!empty($EventInfo->image_sub4)){ ?>
                                        <img height="300" width="350" src="<?php echo base_url() ?>/assets/<?php echo $EventInfo->image_sub4; ?>"> 
                                    <?php } ?>
                    </td> 
                 </tr> 
            </table>
        </div>
    </div>
</div>
