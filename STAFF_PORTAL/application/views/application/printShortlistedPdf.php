<style>
    
.border_full{
    border-style: solid;
    padding: 7px;
    border-color: black;
    border-width: 1px;
  }
  .boredr_top{
    border-top: solid;
    padding: 7px;
    border-color: black;
    border-width: 1px;
    }
  .boredr_left{
  border-left: solid;
  padding: 7px;
  border-color: black;
  border-width: 1px;
  }
  .boredr_right{
  border-right: solid;
  padding: 7px;
  border-color: black;
  border-width: 1px;
  }
  .boredr_left_right{
  border-right: solid;
  border-left: solid;
  padding: 7px;
  border-color: black;
  border-width: 1px;
  }
  .boredr_only_bottom{
  border-bottom: solid;
  padding: 7px;
  border-color: black;
  border-width: 1px;
  }
  .text_style_2{
    margin-left: -12px;
    font-weight: bold;
    float: left;
    margin-top: -8px;
  }
.copy_text {
    font-size: 17px;
    font-weight: 600;
    margin-bottom: -5px;
}

td {
    font-weight: inherit;
}

.description {
    font-size: 15px;
    margin-bottom: 0px;
    margin-top: -0px;
    padding: 19px;
}

.panel-primary {
    border-color: #337ab700;
}

.college_title {
    font-size: 20px;
    font-weight: 600;
    margin-top: 0px;
}

@media print {

    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        padding: 3px !important;
        line-height: 1.5 !important;
        vertical-align: top !important;
        border-width: thin;
        border: 0.002em solid grey !important;

    }

    .pagebreak {
        page-break-before: always;
    }

    .main-footer {
        display: none;
    }

    .wizard-inner,
    .card-header,
    .card-footer {
        display: none;
    }

    .noprint {
        display: none;
    }

    ::-webkit-scrollbar {
        display: none;
    }

    @page {
        size: A4 landscape;
        margin: 2in;
        margin: 1;
    }

    .page_break {
        page-break-before: always;
    }

    .enable-print {
        display: block !important;
    }
}

.address_title {
    font-size: 16px;
  
    font-weight: 600;
}
table, td, th {
  border: 1px solid black;
  font-size: 18px !important;
}

table {
  width: 100%;
  border-collapse: collapse;
}
</style>
<?php  $copy_name = ['STUDENT COPY','COLLEGE COPY','BANK COPY'];
$title = ["HASSAN JESUIT EDUCATIONAL SOCIETY","ST JOSEPH'S PRE-UNIVERSITY COLLEGE"];
$re_address = ['Residency Road, HASSAN-560 025'];
?>

    <div class="col-lg-12">
        <div class="card card-primary">
           
           
                <div class="row enable-print">
                    
                    <div class="col-lg-12 col-md-12">
                        <div class="border_full">
                            <h2 style="text-align:center" class="text-center college_title"><b><?php echo TITLE ?></b></h2>
                             <p  class="text-center" style="text-align:center;margin-top:-95px;"><?php echo ADDRESS ?></p>
                           <p style="text-align:center; margin-top: -39px;" class="text-center address_title ">
                            <b> MERIT LIST OF PROVISIONALLY SELECTED CANDIDATES</b></p> 
                            <h6 style="text-align:center; color:red" class="text-center college_title"><b><?php echo $preference; ?></b></h6>
                            <table>
                            <tr style="font-size:22px;">
                            <?php 
                                     $count = 0;
                                    foreach($stdInfo as $std){
                                        $count++;
                                        
                                        if($count < 9){ 
                                           
                                            ?>
                                     
                                            <th style="font-size:15px;"><?php echo $std->application_number; ?></th>
                                         
                                       <?php } else {
                                            $count = 0;
                                           ?>
                                        <tr >
                                            <th style="font-size:15px;"><?php echo $std->application_number; ?></th>
                                            </tr>
                                      <?php }?>
                                    
                                <?php } ?>
                            </table>

                         
                           
                           
                            
                         
                        
                        </div>
                    </div>
                  
                    <!-- <div class="pagebreak"> </div> -->

                   
                </div>


        </div>
    </div>
