
<?php require APPPATH . 'views/includes/db.php'; ?>

<style>
     #myChart {
        height:500px; /* Adjust the height as needed */
        width: 500px; /* Optionally adjust the width */
        align-items: center;
    }
     .text_highlight {
            font-family: Arial, sans-serif;
        }
</style>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<div class="main-content-container px-3">

    <!-- Page Header -->

    <div class="row mt-1 mb-1 ">

        <div class="col padding_left_right_null">

            <div class="card fee_heading_title card-small p-0">

                <div class="card-body p-2 ml-2">
                   <div class="row c-m-b">
                       <div class="col-lg-4 col-md-12 col-sm-6 box-tools">
                           <span class="page-title">
                               <i class="fas fa-money-bill"></i> Salary Dashboard / Overview
                           </span>
                       </div>
                       <div class="col-lg-8 col-md-12 col-sm-6">
                           <form action="<?php echo base_url() ?>viewSalaryDashboard" method="POST" id="byFilterMethod" class="float-right">
                               <div class="input-group mobile-btn student_search">
                                   <select class="form-control selectpicker "  name="month" id="month">
                                       <?php if(!empty($month)){?>
                                           <option value="<?php echo $month; ?>" selected><b> <?php echo $month; ?></b></option>
                                       <?php } ?>
                                       <option value='JANUARY'>JANUARY</option>
                                        <option value='FEBRUARY'>FEBRUARY</option>
                                        <option value='MARCH'>MARCH</option>
                                        <option value='APRIL'>APRIL</option>
                                        <option value='MAY'>MAY</option>
                                        <option value='JUNE'>JUNE</option>
                                        <option value='JULY'>JULY</option>
                                        <option value='AUGUST'>AUGUST</option>
                                        <option value='SEPTEMBER'>SEPTEMBER</option>
                                        <option value='OCTOBER'>OCTOBER</option>
                                        <option value='NOVEMBER'>NOVEMBER</option>
                                        <option value='DECEMBER'>DECEMBER</option>
                                   </select>                                  
                               </div>
                           </form>
                       </div>
                   </div>
                   
                </div>

            </div>

        </div>

    </div>

    <!-- End Page Header -->

    <!-- Small Stats Blocks -->


    <div class="row justify-content-center">
        <div class="col-md-6 col-12 mb-2">
            <div class="card card-small">
                <div class="card-header border-bottom fee_head_dashboard">
                    <h6 class="m-0 text-dark">Staff Count By Department</h6>
                </div>
                <div class="card-body p-1">
                    <div class="card card-small h-100">
                        <div class="card-body d-flex flex-column p-1 align-items-center">
                            <div class="row mx-0">
                                <div class="col-lg-5">
                                    <!-- pie chart -->
                                    <canvas id="myChart" ></canvas>
                                    <div id="departmentInfo" ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12 mb-2">
            <div id="chartmarkFinal" style="height: 300px; width: 99%;"></div>
            <?php 
                $dataPoints_Pie = array();
                $totalbasic = 0;
             if(!empty($getSalarySlipInfo)){
                foreach($getSalarySlipInfo as $salary){
                    $totalbasic += $salary->basic;
                    $basic_da = round(($salary->basic * $salary->basic_da)/100);
                    $basic_hr = round(($salary->basic * $salary->basic_hr)/100);
                    $totallop += $salary->lop;
                    $totalda += $salary->da;
                    $totalbasicda += $basic_da;
                    $totalbasichr += $basic_hr;
                    $totalhr += $salary->hr;
                    $totalcon += $salary->con;
                    $totalothers += $salary->others;
                    $totalbasic_deduction += $salary->basic_deduction;
                    $totalmanagement_pf += $salary->management_pf;
                    $totalmanagement_esi += $salary->management_esi;
                    $totalOT_amount += $salary->ot_amount;
                    $totalSalary += $salary->net_amount;
                    $totalpf += $salary->pf;
                    $totalesi += $salary->esi;
                    $totalpt += $salary->pt;
                    $totalOtherDeduct += $salary->other_deduct;
                    $totalITDeduct += $salary->it_deduct;
                    $totalAdvanceSalary += $salary->advance_salary;
                    $totalRate = $totalbasic + $totalda + $totalcon + $totalhr  + $totalothers + $totalOT_amount;
                                                    
                }
            }
            $monthly = $totalbasic - $totallop;
            $total_deduction = $totalpf + $totalesi + $totalOtherDeduct + $totalITDeduct + $totalpt + $totalAdvanceSalary + $totallop; 
            array_push($dataPoints_Pie, array("label"=> 'TOTAL SALARY', "y"=> ($totalRate)));
            array_push($dataPoints_Pie, array("label"=> 'TOTAL PAID', "y"=> ($totalSalary)));
            array_push($dataPoints_Pie, array("label"=> 'TOTAL DEDUCTION', "y"=> ($total_deduction)));
            array_push($dataPoints_Pie, array("label"=> 'TOTAL PF CONTRIBUTION', "y"=> ($totalpf)));
            array_push($dataPoints_Pie, array("label"=> 'TOTAL ESI CONTRIBUTION', "y"=> ($totalesi)));?>
            <script>
                function loadGraph() {
                    var chart = new CanvasJS.Chart("chartmarkFinal", {
                        animationEnabled: true,
                        title: {
                            text: ""
                        },
                            data: [{
                            type: "pie",
                            startAngle: 240,
                            yValueFormatString: "##0\"\"",
                            indexLabel: "{label} {y}",
                            dataPoints: <?php echo json_encode($dataPoints_Pie); ?>
                        }]
                    });
                    chart.render();
                } 

                <?php echo "loadGraph();"; ?>
            </script>
          
        </div>
        <div class="col-md-6 col-12 mb-2">
            <div class="card card-small">
                <div class="card-header border-bottom fee_head_dashboard">
                    <h6 class="m-0 text-dark">EARNINGS (INR)</h6>
                </div>
                <div class="card-body p-1">
                                
                    <div class="card card-small h-100">
                        <div class="card-body d-flex flex-column p-1">
                            <div class="row mx-0">
                                <div class="col-lg-12 col-12 p-0 mt-0 table-responsive">
                                    <table class="table table-bordered text-dark mb-0 text_highlight">
                                        <tr class="table-success text-center">
                                            <th width="25%">COMPONENTS</th>
                                            <th width="25%">MONTHLY</th>
                                        </tr>
                                        <?php if(!empty($basicInfo)){ ?>
                                     
                                        <tr>
                                            <th style=" padding: 6px; background-color: #d7d3d3; font-size:13px;">BASIC</th>
                                            <td><?php echo number_format($totalbasic,2) ?></td>
                                        </tr>
                                        <?php } ?>
                                        <?php if(!empty($daInfo)){ ?>
                                        <tr>
                                            <th style=" padding: 6px; background-color: #d7d3d3; font-size:13px;">DA(<?php echo $daInfo->value.'%' ?>)</th>
                                            <td><?php echo number_format($totalda,2) ?></td>
                                        </tr>
                                        <?php } ?>
                                        <?php if(!empty($hraInfo)){ ?>
                                        <tr>
                                            <th style=" padding: 6px; background-color: #d7d3d3; font-size:13px;">HRA(<?php echo $hraInfo->value.'%' ?>)</th>
                                            <td><?php echo number_format($totalhr,2) ?></td>
                                        </tr> 
                                        <?php } ?>
                                        <?php if(!empty($conInfo)){ ?>
                                        <tr>
                                            <th style=" padding: 6px; background-color: #d7d3d3; font-size:13px;">CONVEYANCE</th>
                                            <td><?php echo number_format($totalcon,2) ?></td>
                                        </tr> 
                                        <?php } ?>
                                        <?php if($totalothers != 0){ ?>
                                        <tr>
                                            <th style=" padding: 6px; background-color: #d7d3d3; font-size:13px;">OTHERS</th>
                                            <td><?php echo number_format($totalothers,2) ?></td>
                                        </tr>
                                        <?php } ?>
                                        <?php if($totalOT_amount != 0){ ?>
                                        <tr>
                                            <th style=" padding: 6px; background-color: #d7d3d3; font-size:13px;">OT</th>
                                            <td><?php echo number_format($totalothers,2) ?></td>
                                        </tr>
                                        <?php } ?>
                                       
                                        <tr>
                                            <th style=" padding: 6px; background-color: #d7d3d3; font-size:13px;">TOTAL EARNINGS</th>
                                            <th style=" padding: 6px;"><?php echo number_format($totalRate,2) ?></th>
                                        </tr>    
                                    </table>
                                </div>
                                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
        <div class="col-md-6 col-12 mb-2">
            <div class="card card-small">
                <div class="card-header border-bottom fee_head_dashboard">
                    <h6 class="m-0 text-dark">DEDUCTIONS (INR)</h6>
                </div>
                <div class="card-body p-1">
                                
                    <div class="card card-small h-100">
                        <div class="card-body d-flex flex-column p-1">
                            <div class="row mx-0">
                                <div class="col-lg-12 col-12 p-0 mt-0 table-responsive">
                                    <table class="table table-bordered text-dark mb-0 text_highlight">
                                        <tr class="table-success text-center">
                                            <th width="120">COMPONENTS</th>
                                            <th>TOTAL</th>
                                        </tr>
                                       
                                        <?php if(!empty($pfInfo)){ ?>
                                        <tr>
                                            <th style=" padding: 6px; background-color: #d7d3d3; font-size:13px;" width="50%">EMPLOYEE PF(<?php echo $pfInfo->value.'%' ?>)</th>
                                            <td width="50%"><?php echo number_format($totalpf,2) ?></td>
                                        </tr>
                                        <?php } ?>
                                        <?php if(!empty($esiInfo)){ ?>
                                        <tr>
                                            <th style=" padding: 6px; background-color: #d7d3d3; font-size:13px;" width="50%">EMPLOYEE ESI(<?php echo $esiInfo->value.'%' ?>)</th>
                                            <td width="50%"><?php echo number_format($totalesi,2) ?></td>
                                        </tr>
                                        <?php } ?>
                                        <?php if(!empty($ptInfo)){ ?>
                                        <tr>
                                            <th style=" padding: 6px; background-color: #d7d3d3; font-size:13px;" width="50%">PT</td>
                                            <td width="50%"><?php echo number_format($totalpt,2) ?></td>
                                        </tr>
                                        <?php } ?>
                                        <?php if(!empty($otherInfo)){ ?>
                                        <tr>
                                            <th style=" padding: 6px; background-color: #d7d3d3; font-size:13px;" width="50%">OTHERS</th>
                                            <td width="50%"><?php echo number_format($totalOtherDeduct,2) ?></td>
                                        </tr>
                                        <?php } ?>
                                        <?php if(!empty($itInfo)){ ?>
                                        <tr>
                                            <th style=" padding: 6px; background-color: #d7d3d3; font-size:13px;" width="50%">IT</th>
                                            <td width="50%"><?php echo number_format($totalITDeduct,2) ?></td>
                                        </tr>
                                        <?php } ?>
                                        <?php if($totalAdvanceSalary != 0 && (!empty($totalAdvanceSalary))){ ?>
                                        <tr>
                                            <th style=" padding: 6px; background-color: #d7d3d3; font-size:13px;" width="50%">ADVANCE SALARY</th>
                                            <td width="50%"><?php echo number_format($totalAdvanceSalary,2) ?></td>
                                        </tr>
                                        <?php } ?>
                                        <?php if($totallop != 0){ ?>
                                        <tr>
                                            <th style=" padding: 6px; background-color: #d7d3d3; font-size:13px;" width="50%">LOP</th>
                                            <td width="50%"><?php echo number_format($totallop,2) ?></td>
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <?php $total_deduction = $totalpf + $totalesi + $totalOtherDeduct + $totalITDeduct + $totalpt + $totalAdvanceSalary + $totallop; ?>
                                            <th style=" padding: 6px;  background-color: #d7d3d3; font-size:13px;" width="50%">TOTAL DEDUCTIONS</th>
                                            <th style=" padding: 6px;" width="50%"><?php echo number_format($total_deduction,2) ?></th>
                                        </tr>   
                                    </table>
                                </div>
                                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="col-md-12 col-12 mb-2">
            <div class="card card-small">
                <div class="card-header border-bottom fee_head_dashboard">
                    <h6 class="m-0 text-dark">LEAVE INFO</h6>
                </div>
                <div class="card-body p-1">
                                
                    <div class="card card-small h-100">
                        <div class="card-body d-flex flex-column p-1">
                            <div class="row mx-0">
                                <div class="col-lg-12 col-12 p-0 mt-0 table-responsive">
                                    <table class="table table-bordered text-dark mb-0">
                                        <tr class="table-success text-center">
                                            <th width="120">Casual Leave</th>
                                            <th>Medical Leave</th>
                                            <th>Paternity Leave</th>
                                            <th>Marriage Leave</th>
                                            <th>Maternity Leave</th>
                                            <th>Earned Leave</th>
                                            <th>Official Duty</th>
                                            <th>Loss of Pay</th>

                                        </tr>
                                        <?php
                                            $year = CURRENT_YEAR;
                                            // Convert month name to month number
                                            $month_number = date('n', strtotime($month));

                                            // Get the first day of the month
                                            $dateFrom = sprintf('%02d-%02d-%d', 1, $month_number, $year);
                                            $date_from = date('Y-m-d', strtotime($dateFrom));
                                            // Get the last day of the month
                                            $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month_number, $year);
                                            $dateTo = sprintf('%02d-%02d-%d', $days_in_month, $month_number, $year);
                                            $date_to = date('Y-m-d', strtotime($dateTo));

                                            $used_leave_cl = $salaryModel->getLeaveUsedSum('CL', $date_from,$date_to);
                                            $used_leave_el = $salaryModel->getLeaveUsedSum('EL', $date_from,$date_to);
                                            $used_leave_ml = $salaryModel->getLeaveUsedSum('ML', $date_from,$date_to);
                                            $used_leave_marl = $salaryModel->getLeaveUsedSum('MARL', $date_from,$date_to);
                                            $used_leave_pl = $salaryModel->getLeaveUsedSum('PL', $date_from,$date_to);
                                            $used_leave_matl = $salaryModel->getLeaveUsedSum('MATL', $date_from,$date_to);
                                            $used_leave_lop = $salaryModel->getLeaveUsedSum('LOP', $date_from,$date_to);
                                            $used_leave_od = $salaryModel->getLeaveUsedSum('OD', $date_from,$date_to);
                                            $used_leave_wfh = $salaryModel->getLeaveUsedSum( 'WFH', $date_from,$date_to);
                                            $used_leave_mgml = $salaryModel->getLeaveUsedSum('MGML', $date_from,$date_to);
                                        ?>
                                        <tr>
                                            <td style=" padding: 6px;" class="text-center"><?php echo $used_leave_cl->total_days_leave; ?></td>
                                            <td style=" padding: 6px;" class="text-center"><?php echo $used_leave_ml->total_days_leave; ?></td>
                                            <td style=" padding: 6px;" class="text-center"><?php echo $used_leave_pl->total_days_leave; ?></td>
                                            <td style=" padding: 6px;" class="text-center"><?php echo $used_leave_marl->total_days_leave; ?></td>
                                            <td style=" padding: 6px;" class="text-center"><?php echo $used_leave_matl->total_days_leave; ?></td>
                                            <td style=" padding: 6px;" class="text-center"><?php echo $used_leave_el->total_days_leave; ?></td>
                                            <td style=" padding: 6px;" class="text-center"><?php echo $used_leave_od->total_days_leave; ?></td>
                                            <td style=" padding: 6px;" class="text-center"><?php echo $used_leave_lop->total_days_leave; ?></td>

                                        </tr>
                                          
                                    </table>
                                </div>
                                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>      
    </div>
    
        <!-- </div> -->
        <?php //} ?>
        <?php if ($role == ROLE_SUPER_ADMIN) { ?>
    </div>
    <?php } ?>
</div>

<script type="text/javascript">
var loader = '<img height="70" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';

document.addEventListener('DOMContentLoaded', function() {
    var staffCounts = <?php echo json_encode($staff_counts); ?>;
    var chartData = [];
    var colors = [
        "#4caf50", "#ffeb3b", "#f44336", "#2196f3", "#9c27b0", "#00bcd4", "#ff9800",
        "#e91e63", "#795548", "#8bc34a", "#cddc39", "#ff5722", "#607d8b", "#3f51b5",
        "#673ab7", "#00e676", "#00acc1", "#ffd600", "#d32f2f", "#9e9e9e"
    ];

    var index = 0;
    var totalStaffCount = 0;
            for (var department in staffCounts) {
                chartData.push({
                    value: staffCounts[department],
                    color: colors[index % colors.length],
                    highlight: colors[index % colors.length],
                    label: department
                });
                totalStaffCount += staffCounts[department];
                index++;
            }
    var totalStaff = chartData.reduce((acc, data) => acc + data.value, 0);

    Chart.types.Doughnut.extend({
       name: "DoughnutTextInside",
       showTooltip: function() {
           this.chart.ctx.save();
           Chart.types.Doughnut.prototype.showTooltip.apply(this, arguments);
           this.chart.ctx.restore();
       },
       draw: function() {
           Chart.types.Doughnut.prototype.draw.apply(this, arguments);

           var width = this.chart.width,
               height = this.chart.height;

           var fontSize = (height / 140).toFixed(2);
           this.chart.ctx.font = fontSize + "em Verdana";
           this.chart.ctx.textBaseline = "middle";

           var text = totalStaffCount + " Staff",
            textX = Math.round((width - this.chart.ctx.measureText(text).width) / 2),
            textY = height / 2;

            this.chart.ctx.fillStyle = "#b20000";

            this.chart.ctx.fillText(text, textX, textY);
  
       }
   });

   var ctx = document.getElementById('myChart').getContext('2d');
    new Chart(ctx).DoughnutTextInside(chartData, {
        responsive: true,
        onClick: function(evt) {
            var activePoints = myDoughnutChart.getSegmentsAtEvent(evt);
            if (activePoints.length > 0) {
                var clickedSegment = activePoints[0];
                document.getElementById('departmentInfo').innerText = "Department: " + clickedSegment.label + "\nCount: " + clickedSegment.value;
            }
        }
    });
   
});
jQuery(document).ready(function() {
   jQuery('.datepicker').datepicker({
           autoclose: true,
           orientation: "bottom",
           format: "dd-mm-yyyy"
       });
});
function autocomplete(inp, student_names, student_id) {

   /*the autocomplete function takes two arguments,

   the text field element and an array of possible autocompleted values:*/

   var currentFocus;

   /*execute a function when someone writes in the text field:*/

   inp.addEventListener("input", function(e) {

       var a, b, i, val = this.value;

       /*close any already open lists of autocompleted values*/

       closeAllLists();

       if (!val) {
           return false;
       }

       currentFocus = -1;

       /*create a DIV element that will contain the items (values):*/

       a = document.createElement("DIV");

       a.setAttribute("id", this.id + "autocomplete-list");

       a.setAttribute("class", "autocomplete-items");

       /*append the DIV element as a child of the autocomplete container:*/

       this.parentNode.appendChild(a);

       for (i = 0; i < student_names.length; i++) {

           /*check if the item starts with the same letters as the text field value:*/

           if (student_names[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {

               /*create a DIV element for each matching element:*/

               b = document.createElement("DIV");

               /*make the matching letters bold:*/

               b.innerHTML = "<strong>" + student_names[i].substr(0, val.length) + "</strong>";

               b.innerHTML += student_names[i].substr(val.length);

               /*insert a input field that will hold the current array item's value:*/

               b.innerHTML += "<input type='hidden' value='" + student_id[i] + "'>";

               /*execute a function when someone clicks on the item value (DIV element):*/

               b.addEventListener("click", function(e) {

                   /*insert the value for the autocomplete text field:*/

                   inp.value = this.getElementsByTagName("input")[0].value;

                   /*close the list of autocompleted values,

                   (or any other open lists of autocompleted values:*/

                   closeAllLists();

               });

               a.appendChild(b);

           }

       }

       /*for each item in the array...*/



   });

   /*execute a function presses a key on the keyboard:*/

   inp.addEventListener("keydown", function(e) {

       var x = document.getElementById(this.id + "autocomplete-list");

       if (x) x = x.getElementsByTagName("div");

       if (e.keyCode == 40) {

           /*If the arrow DOWN key is pressed,

           increase the currentFocus variable:*/

           currentFocus++;

           /*and and make the current item more visible:*/

           addActive(x);

       } else if (e.keyCode == 38) { //up

           /*If the arrow UP key is pressed,

           decrease the currentFocus variable:*/

           currentFocus--;

           /*and and make the current item more visible:*/

           addActive(x);

       } else if (e.keyCode == 13) {

           /*If the ENTER key is pressed, prevent the form from being submitted,*/

           e.preventDefault();

           if (currentFocus > -1) {

               /*and simulate a click on the "active" item:*/

               if (x) x[currentFocus].click();

           }

       }

   });

   function addActive(x) {

       /*a function to classify an item as "active":*/

       if (!x) return false;

       /*start by removing the "active" class on all items:*/

       removeActive(x);

       if (currentFocus >= x.length) currentFocus = 0;

       if (currentFocus < 0) currentFocus = (x.length - 1);

       /*add class "autocomplete-active":*/

       x[currentFocus].classList.add("autocomplete-active");

   }

   function removeActive(x) {

       /*a function to remove the "active" class from all autocomplete items:*/

       for (var i = 0; i < x.length; i++) {

           x[i].classList.remove("autocomplete-active");

       }

   }

   function closeAllLists(elmnt) {

       /*close all autocomplete lists in the document,

       except the one passed as an argument:*/

       var x = document.getElementsByClassName("autocomplete-items");

       for (var i = 0; i < x.length; i++) {

           if (elmnt != x[i] && elmnt != inp) {

               x[i].parentNode.removeChild(x[i]);

           }

       }

   }

   /*execute a function when someone clicks in the document:*/

   document.addEventListener("click", function(e) {

       closeAllLists(e.target);

   });

}

</script>

<script>
document.addEventListener('DOMContentLoaded', function() {

   document.getElementById('myform').addEventListener('submit', function(event) {
       // Show the loader when the form is submitted
       hideLoader();
   });
});
</script>
<script>
// Wait for the DOM to be fully loaded
document.addEventListener("DOMContentLoaded", function() {
   // Get the select element
   var selectElement = document.getElementById("month");

   // Add an event listener for change event
   selectElement.addEventListener("change", function() {
       // Submit the form when the select value changes
       document.getElementById("byFilterMethod").submit();
       showLoader();
   });
});
</script>
