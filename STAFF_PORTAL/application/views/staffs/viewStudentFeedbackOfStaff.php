<style>
    .table-bordered>thead>tr>th,
    .table-bordered>tbody>tr>th,
    .table-bordered>tfoot>tr>th,
    .table-bordered>thead>tr>td,
    .table-bordered>tbody>tr>td,
    .table-bordered>tfoot>tr>td {
        border: 1px solid #D3D3D3 !important;
        color: black;
        font-size: 16px;
    }
</style>
<style>
label {
    font-weight: 500 !important;
}
</style>
<?php $this->load->helper('form');
$error = $this->session->flashdata('error');
if ($error) { ?>

    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $this->session->flashdata('error'); ?>
    </div>
<?php } ?>

<?php $success = $this->session->flashdata('success');
if ($success) { ?>

    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php } ?>

<div class="row">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container container-fluid px-4 pt-1">
    <div class="content-wrapper">
        <section class="content-header">
            <div class="row mt-1">
                <div class="col-12">
                    <div class="card card-small p-0 card_heading_title">
                        <div class="card-body p-2 ml-2">
                            <span class="page-title absent_table_title_mobile">
                                <i class="material-icons">group</i> Student Feedback of <?php echo $staffInfo->name; ?>
                            </span>

                            <a href="<?php echo base_url(); ?>staffDetails" class="btn primary_color float-right text-white pt-2" value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-small c-border mb-4 p-2">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-2">
                            <div class="row column_padding_card">
                                <div class="col column_padding_card profile-head">
                                    <?php if (!empty($staffInfo)) {
                                        if ($staffInfo->role_id == ROLE_TEACHING_STAFF || $staffInfo->role_id == ROLE_PRINCIPAL || $staffInfo->role_id == ROLE_PRIMARY_ADMINISTRATOR || $staffInfo->role_id == ROLE_ADMIN) { ?>

                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" id="question-tab" href="#question_25" role="tab" aria-controls="questions25" aria-selected="false">
                                                    Questions-25</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#coments_25" data-toggle="tab" id="coments25-tab" role="tab" aria-controls="comments25" aria-selected="false">Comments-25</a>
                                                </li>
                                                 <li class="nav-item">
                                                    <a class="nav-link" id="analytic_info-tab" data-toggle="tab" href="#analytic_info"
                                                        role="tab" aria-controls="analytic_info" aria-selected="true">Analytics
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" id="question-tab" href="#question_23" role="tab" aria-controls="questions23" aria-selected="false">
                                                    Questions-24</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#coments_23" data-toggle="tab" id="coments23-tab" role="tab" aria-controls="comments23" aria-selected="false">Comments-24</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" id="question-tab" href="#question_22" role="tab" aria-controls="questions" aria-selected="false">
                                                    Questions-23</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#coments_22" data-toggle="tab" id="coments-tab" role="tab" aria-controls="comments" aria-selected="false">Comments-23</a>
                                                </li>
                                                
                                            </ul>

                                            <div class="tab-content question-tab" id="myTabContent">
                                                
                                                <div class="tab-pane fade" id="question_22" role="tabpanel"
                                                aria-labelledby="question-tab">  
                                                    <table class="table  table-striped table-bordered text-dark mb-0">
                                                        <thead class="text-center">
                                                            <tr class="table_row_background">
                                                                <th width="70">SL. NO.</th>
                                                                <th width="400">QUESTIONS</th>
                                                                <!-- <th width="400">Type</th> -->
                                                                <th class="text-uppercase text-center">Excellent</th>
                                                                <th class="text-uppercase text-center">Very Good</th>
                                                                <th class="text-uppercase text-center">Good</th>
                                                                <th class="text-uppercase text-center">Satisfactory</th>
                                                                <th class="text-uppercase text-center">Unsatisfactory</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody style="color:black !important;font-weight:bold; font-family:Arial, Helvetica, sans-serif;">
                                                            <?php if (!empty($questions)) {
                                                                foreach ($questions as $q) {
                                                                    $excellent_count = $qCountExcellent[$q->qid];
                                                                    $good_count = $qCountGood[$q->qid];
                                                                    $fairAverage_count = $qCountFairAverage[$q->qid];
                                                                    $notGood_count = $qCountNotGood[$q->qid];
                                                                    $notSatisfactory_count = $qCountNotSatisfactory[$q->qid];
                                                                    // $total_count = $yes_count + $no_count;
                                                                    // $yes_percentage =  floor(($yes_count / $total_count) * 100);
                                                                    // $no_percentage =  floor(($no_count / $total_count) * 100);
                                                            ?>
                                                                    <tr>
                                                                        <td class="text-center"><?php echo $q->qid; ?></td>
                                                                        <td><?php echo $q->question; ?></td>
                                                                        <!-- <td><?php echo $q->type; ?></td> -->
                                                                        <td class="text-center font-weight-bold"><?php echo $excellent_count; ?></td>
                                                                        <td class="text-center font-weight-bold"><?php echo $good_count; ?></td>
                                                                        <td class="text-center font-weight-bold"><?php echo $fairAverage_count; ?></td>
                                                                        <td class="text-center font-weight-bold"><?php echo $notGood_count; ?></td>
                                                                        <td class="text-center font-weight-bold"><?php echo $notSatisfactory_count; ?></td>
                                                                        <!-- <td class="text-center">
                                                                            <span  style="font-weight:bold;"><?php echo $yes_count; ?></span>
                                                                            <div class="text-muted">
                                                                                <div class="container bg-success rounded" >
                                                                                    <span style="font-weight:bold;color:black;"><?php echo $yes_percentage; ?>%</span>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <span style="font-weight:bold;"><?php echo $no_count; ?></span>
                                                                            <div class="text-muted">
                                                                                <div class="container bg-danger rounded" >
                                                                                    <span style="font-weight:bold;color:black;"><?php echo $no_percentage; ?>%</span>
                                                                                </div>
                                                                            </div>
                                                                        </td> -->
                                                                    </tr>
                                                                <?php }
                                                            } else { ?>
                                                                <tr>
                                                                    <th class="text-center" colspan="7">Comments not found!</th>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>

                                                    <form role="form" id="editUser" action="<?php echo base_url() ?>addCommentToFeedbackByPrincipal/<?php echo $staffInfo->row_id; ?>" method="post">
                                                        <input type="hidden" value="2023" name="year" />
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12">
                                                                <div class="form-group">
                                                                    <label for="comment" style="font-weight:bold;color:black;">Comment:</label>
                                                                    <textarea class="form-control" rows="5" name="comment" id="comment" required><?php if (!empty($staffMgtComment)) {
                                                                                                                                                        echo $staffMgtComment->response;
                                                                                                                                                    } ?> </textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12">
                                                                <input style="float:right" type="submit" class="btn btn-success" value="Submit" />
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                    <div class="tab-pane fade" id="analytic_info" role="tabpanel" aria-labelledby="analytic_info-tab">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <h5 class="text-center font-weight-bold">Feedback Analytics</h5>
                                                                <div class="row mb-4">
                                                                    <div class="col-12 mb-2">
                                                                        <h4 class="text-center">Feedback Rating Distribution</h4>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                <h5 class="card-title mb-0">Rating Distribution (Pie Chart)</h5>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <div id="feedbackPieChart" style="height: 300px;"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                <h5 class="card-title mb-0">Rating Distribution (Bar Chart)</h5>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <div id="feedbackBarChart" style="height: 300px;"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- End of Charts Section -->


                                                                <!-- Google Charts implementation for pie and bar charts that match the reference images -->
                                                                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                                                <script type="text/javascript">
                                                                    // Load the Google Charts visualization library
                                                                    google.charts.load('current', {'packages':['corechart']});
                                                                    google.charts.setOnLoadCallback(drawCharts);

                                                                    function drawCharts() {
                                                                        // Initialize counters for each rating category
                                                                        var excellent = 0;
                                                                        var good = 0;
                                                                        var fairAverage = 0;
                                                                        var notGood = 0;
                                                                        var notSatisfactory = 0;

                                                                        // Sum values in each array
                                                                        <?php if(isset($qCountExcellent25)) : ?>
                                                                            <?php foreach($qCountExcellent25 as $qid => $value) : ?>
                                                                                excellent += <?php echo $value; ?>;
                                                                            <?php endforeach; ?>
                                                                        <?php endif; ?>

                                                                        <?php if(isset($qCountGood25)) : ?>
                                                                            <?php foreach($qCountGood25 as $qid => $value) : ?>
                                                                                good += <?php echo $value; ?>;
                                                                            <?php endforeach; ?>
                                                                        <?php endif; ?>

                                                                        <?php if(isset($qCountFairAverage25)) : ?>
                                                                            <?php foreach($qCountFairAverage25 as $qid => $value) : ?>
                                                                                fairAverage += <?php echo $value; ?>;
                                                                            <?php endforeach; ?>
                                                                        <?php endif; ?>

                                                                        <?php if(isset($qCountNotGood25)) : ?>
                                                                            <?php foreach($qCountNotGood25 as $qid => $value) : ?>
                                                                                notGood += <?php echo $value; ?>;
                                                                            <?php endforeach; ?>
                                                                        <?php endif; ?>

                                                                        <?php if(isset($qCountNotSatisfactory25)) : ?>
                                                                            <?php foreach($qCountNotSatisfactory25 as $qid => $value) : ?>
                                                                                notSatisfactory += <?php echo $value; ?>;
                                                                            <?php endforeach; ?>
                                                                        <?php endif; ?>

                                                                        // Create data table for the pie chart
                                                                        var data = google.visualization.arrayToDataTable([
                                                                            ['Rating', 'Count'],
                                                                            ['Excellent', excellent],
                                                                            ['Good', good],
                                                                            ['Fair/Average', fairAverage],
                                                                            ['Not Good', notGood],
                                                                            ['Not Satisfactory', notSatisfactory]
                                                                        ]);
                                                                        
                                                                        // Create data for the bar chart with colors matching the image
                                                                        var feedbackBarData = google.visualization.arrayToDataTable([
                                                                            ['Rating', 'Count', { role: 'style' }],
                                                                            ['Excellent', excellent, '#4285F4'],    // Blue
                                                                            ['Good', good, '#0F9D58'],              // Green
                                                                            ['Fair/Average', fairAverage, '#F4B400'], // Yellow/Orange
                                                                            ['Not Good', notGood, '#DB4437'],       // Red
                                                                            ['Not Satisfactory', notSatisfactory, '#AB47BC'] // Purple
                                                                        ]);

                                                                        // Set options for Pie Chart as a donut chart
                                                                        var pieOptions = {
                                                                            title: 'Feedback Ratings Distribution',
                                                                            pieHole: 0.5,
                                                                            legend: { position: 'right', alignment: 'center' },
                                                                            colors: ['#4285F4', '#0F9D58', '#F4B400', '#DB4437', '#AB47BC'],
                                                                            chartArea: { width: '100%', height: '100%' },
                                                                            pieSliceText: 'percentage',
                                                                            pieSliceTextStyle: {
                                                                                color: 'black',
                                                                                fontSize: 12,
                                                                                bold: true
                                                                            }
                                                                        };

                                                                        // Set options for Bar Chart to match the image
                                                                        var barOptions = {
                                                                            title: '',
                                                                            legend: { position: 'none' },
                                                                            backgroundColor: 'transparent',
                                                                            hAxis: {
                                                                                title: '',
                                                                                minValue: 0,
                                                                                textPosition: 'out',
                                                                                gridlines: {
                                                                                    color: 'transparent'
                                                                                }
                                                                            },
                                                                            vAxis: {
                                                                                title: '',
                                                                                gridlines: {
                                                                                    color: '#e0e0e0'
                                                                                }
                                                                            },
                                                                            bar: { groupWidth: '70%' },
                                                                            chartArea: { width: '85%', height: '85%' }
                                                                        };

                                                                        // Create and draw the donut chart
                                                                        var pieChart = new google.visualization.PieChart(document.getElementById('feedbackPieChart'));
                                                                        pieChart.draw(data, pieOptions);

                                                                        // Create and draw the bar chart
                                                                        var barChart = new google.visualization.ColumnChart(document.getElementById('feedbackBarChart'));
                                                                        barChart.draw(feedbackBarData, barOptions);
                                                                    }

                                                                    // Redraw charts when tab is shown to ensure proper rendering
                                                                    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                                                                        if ($(e.target).attr('href') === '#analytic_info') {
                                                                            drawCharts();
                                                                        }
                                                                    });

                                                                    // Redraw charts when window is resized
                                                                    $(window).resize(function() {
                                                                        drawCharts();
                                                                    });
                                                                </script>
                                                                <div class="form-row">
                                                                    <table class="table  table-striped table-bordered text-dark mb-0">
                                                                        <thead class="text-center">
                                                                            <tr class="table_row_background">
                                                                                <th>Term Name</th>
                                                                                <th>Stream</th>
                                                                                <th>Section</th>
                                                                                <th>Students</th>
                                                                                <th>Feedback Given</th>
                                                                                <th>Feedback Pending</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php if(!empty($staffSectionInfo)){
                                                                                foreach($staffSectionInfo as $staff){ ?>
                                                                            <tr class="text-center">
                                                                                <th><?php echo $staff->term_name; ?></th>
                                                                                <th><?php echo $staff->stream_name; ?></th>
                                                                                <th><?php echo $staff->section_name; ?></th>
                                                                                <th><?php echo $studentCount[$staff->row_id]; ?>
                                                                                </th>
                                                                                <th><?php echo $studentGivenCount[$staff->row_id]; ?>
                                                                                </th>
                                                                                <th><?php echo $studentCount[$staff->row_id] - $studentGivenCount[$staff->row_id]; ?>
                                                                                </th>


                                                                            </tr>
                                                                            <?php } }else{ ?>
                                                                            <tr class="text-center">
                                                                                <th colspan="4"
                                                                                    style="background-color: #83c8ea7d;">Class not
                                                                                    assigned</th>
                                                                            </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12 col-md-6 col-12 mb-2 padding_left_right_null mt-4">

                                                            <div class="mb-1">

                                                                <div class="card-header border-bottom card_head_dashboard settings_card"
                                                                    data-toggle="collapse" data-target="#staff">

                                                                    <a class="float-right mb-0 setting_pointer">Click here </a>

                                                                    <h6 class="mb-0 text-dark">Pending Students</h6>

                                                                </div>

                                                                <div id="staff" class="collapse">

                                                                    <div class="card card-small">

                                                                        <div class="card-body p-0">

                                                                            <div class="table-responsive-sm">

                                                                                <table class="table  table-striped table-bordered text-dark mb-0">

                                                                                    <?php $total = 0;

                                                                          foreach($staffSectionInfo as $sec){
                                                                             foreach($feedbackPendingInfo[$sec->row_id] as $st){?>

                                                                                    <tr>
                                                                                        <th><?php echo $st->student_id; ?></th>
                                                                                        <th><?php echo $st->student_name; ?></th>
                                                                                        <th><?php echo $st->term_name; ?></th>
                                                                                        <th><?php echo $st->stream_name; ?></th>
                                                                                        <th><?php echo $st->section_name; ?></th>
                                                                                    </tr>

                                                                                    <?php 

                                                                                     }} ?>



                                                                                </table>

                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade show active" id="question_25" role="tabpanel"
                                                aria-labelledby="questions25-tab">  
                                                    <table class="table  table-striped table-bordered text-dark mb-0">
                                                        <thead class="text-center">
                                                            <tr class="table_row_background">
                                                                <th width="70">SL NO.</th>
                                                                <th width="400">Question</th>
                                                                <!-- <th width="400">Type</th> -->
                                                                <th class="text-uppercase text-center">Excellent</th>
                                                                <th class="text-uppercase text-center">Good</th>
                                                                <th class="text-uppercase text-center">Fair/Average</th>
                                                                <th class="text-uppercase text-center">Not Good</th>
                                                                <th class="text-uppercase text-center">Not Satisfactory</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody style="color:black !important;font-weight:bold; font-family:Arial, Helvetica, sans-serif;">
                                                            <?php if (!empty($questions25)) {
                                                                $slNo = 1;
                                                                foreach ($questions25 as $q) {
                                                                    $excellent_count = $qCountExcellent25[$q->qid];
                                                                    $good_count = $qCountGood25[$q->qid];
                                                                    $fairAverage_count = $qCountFairAverage25[$q->qid];
                                                                    $notGood_count = $qCountNotGood25[$q->qid];
                                                                    $notSatisfactory_count = $qCountNotSatisfactory25[$q->qid];
                                                                    // $total_count = $yes_count + $no_count;
                                                                    // $yes_percentage =  floor(($yes_count / $total_count) * 100);
                                                                    // $no_percentage =  floor(($no_count / $total_count) * 100);
                                                            ?>
                                                                    <tr>
                                                                        <td class="text-center"><?php echo $slNo++; ?></td>
                                                                        <td><?php echo $q->question; ?></td>
                                                                        <!-- <td><?php echo $q->type; ?></td> -->
                                                                        <td class="text-center font-weight-bold"><?php echo $excellent_count; ?></td>
                                                                        <td class="text-center font-weight-bold"><?php echo $good_count; ?></td>
                                                                        <td class="text-center font-weight-bold"><?php echo $fairAverage_count; ?></td>
                                                                        <td class="text-center font-weight-bold"><?php echo $notGood_count; ?></td>
                                                                        <td class="text-center font-weight-bold"><?php echo $notSatisfactory_count; ?></td>
                                                                        <!-- <td class="text-center">
                                                                            <span  style="font-weight:bold;"><?php echo $yes_count; ?></span>
                                                                            <div class="text-muted">
                                                                                <div class="container bg-success rounded" >
                                                                                    <span style="font-weight:bold;color:black;"><?php echo $yes_percentage; ?>%</span>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <span style="font-weight:bold;"><?php echo $no_count; ?></span>
                                                                            <div class="text-muted">
                                                                                <div class="container bg-danger rounded" >
                                                                                    <span style="font-weight:bold;color:black;"><?php echo $no_percentage; ?>%</span>
                                                                                </div>
                                                                            </div>
                                                                        </td> -->
                                                                    </tr>
                                                                <?php }
                                                            } else { ?>
                                                                <tr>
                                                                    <th class="text-center" colspan="7">Comments not found!</th>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>

                                                    <form role="form" id="editUser" action="<?php echo base_url() ?>addCommentToFeedbackByPrincipal/<?php echo $staffInfo->row_id; ?>" method="post">
                                                        <input type="hidden" value="2025" name="year" />
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12">
                                                                <div class="form-group">
                                                                    <label for="comment" style="font-weight:bold;color:black;">Overall Summary of the Staff :-</label>
                                                                    <textarea class="form-control" rows="5" name="comment" id="comment" required><?php if (!empty($staffMgtComment25)) {
                                                                                                                                                        echo $staffMgtComment25->response;
                                                                                                                                                    } ?> </textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12">
                                                                <input style="float:right" type="submit" class="btn btn-success" value="Submit" />
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                                    <div class="tab-pane fade" id="question_23" role="tabpanel"
                                                aria-labelledby="questions23-tab">  
                                                    <table class="table  table-striped table-bordered text-dark mb-0">
                                                        <thead class="text-center">
                                                            <tr class="table_row_background">
                                                                <th width="70">SL NO.</th>
                                                                <th width="400">Question</th>
                                                                <!-- <th width="400">Type</th> -->
                                                                <th class="text-uppercase text-center">Excellent</th>
                                                                <th class="text-uppercase text-center">Good</th>
                                                                <th class="text-uppercase text-center">Fair/Average</th>
                                                                <th class="text-uppercase text-center">Not Good</th>
                                                                <th class="text-uppercase text-center">Not Satisfactory</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody style="color:black !important;font-weight:bold; font-family:Arial, Helvetica, sans-serif;">
                                                            <?php if (!empty($questions23)) {
                                                                $slNo = 1;
                                                                foreach ($questions23 as $q) {
                                                                    $excellent_count = $qCountExcellent23[$q->qid];
                                                                    $good_count = $qCountGood23[$q->qid];
                                                                    $fairAverage_count = $qCountFairAverage23[$q->qid];
                                                                    $notGood_count = $qCountNotGood23[$q->qid];
                                                                    $notSatisfactory_count = $qCountNotSatisfactory23[$q->qid];
                                                                    // $total_count = $yes_count + $no_count;
                                                                    // $yes_percentage =  floor(($yes_count / $total_count) * 100);
                                                                    // $no_percentage =  floor(($no_count / $total_count) * 100);
                                                            ?>
                                                                    <tr>
                                                                        <td class="text-center"><?php echo $slNo++; ?></td>
                                                                        <td><?php echo $q->question; ?></td>
                                                                        <!-- <td><?php echo $q->type; ?></td> -->
                                                                        <td class="text-center font-weight-bold"><?php echo $excellent_count; ?></td>
                                                                        <td class="text-center font-weight-bold"><?php echo $good_count; ?></td>
                                                                        <td class="text-center font-weight-bold"><?php echo $fairAverage_count; ?></td>
                                                                        <td class="text-center font-weight-bold"><?php echo $notGood_count; ?></td>
                                                                        <td class="text-center font-weight-bold"><?php echo $notSatisfactory_count; ?></td>
                                                                        <!-- <td class="text-center">
                                                                            <span  style="font-weight:bold;"><?php echo $yes_count; ?></span>
                                                                            <div class="text-muted">
                                                                                <div class="container bg-success rounded" >
                                                                                    <span style="font-weight:bold;color:black;"><?php echo $yes_percentage; ?>%</span>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <span style="font-weight:bold;"><?php echo $no_count; ?></span>
                                                                            <div class="text-muted">
                                                                                <div class="container bg-danger rounded" >
                                                                                    <span style="font-weight:bold;color:black;"><?php echo $no_percentage; ?>%</span>
                                                                                </div>
                                                                            </div>
                                                                        </td> -->
                                                                    </tr>
                                                                <?php }
                                                            } else { ?>
                                                                <tr>
                                                                    <th class="text-center" colspan="7">Comments not found!</th>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>

                                                    <form role="form" id="editUser" action="<?php echo base_url() ?>addCommentToFeedbackByPrincipal/<?php echo $staffInfo->row_id; ?>" method="post">
                                                        <input type="hidden" value="2024" name="year" />
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12">
                                                                <div class="form-group">
                                                                    <label for="comment" style="font-weight:bold;color:black;">Comment:</label>
                                                                    <textarea class="form-control" rows="5" name="comment" id="comment" required><?php if (!empty($staffMgtComment23)) {
                                                                                                                                                        echo $staffMgtComment23->response;
                                                                                                                                                    } ?> </textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12">
                                                                <input style="float:right" type="submit" class="btn btn-success" value="Submit" />
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div id="coments_25" class="tab-pane fade" role="tabpanel" aria-labelledby="coments25-tab">
                                                    <table class="table  table-striped table-bordered text-dark mb-0">
                                                        <thead class="text-center">
                                                            <tr class="table_row_background">
                                                                <th width="118">Student ID</th>
                                                                <th>Comments</th>
                                                                <!-- <th>Suggestion for teacher</th>
                                                                <th>About College</th>
                                                                <th>Like about college</th>
                                                                <th>What makes student happy</th>
                                                                <th>Suggestion for college</th> -->
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($stdCommentInfo25)) {
                                                                foreach ($stdCommentInfo25 as $record) {
                                                            ?>
                                                                    <tr style="font-weight: bold; color:black;">
                                                                        <td class="text-left"><?php echo $record->student_id; ?></td>
                                                                        <td width="150"><?php echo $record->comments_impression; ?></td>
                                                                        <!-- <td><?php echo $record->suggestion; ?></td>
                                                                        <td><?php echo $record->opinion; ?></td>
                                                                        <td><?php echo $record->like_about; ?></td>
                                                                        <td><?php echo $record->happy; ?></td>
                                                                        <td><?php echo $record->college_improvement; ?></td> -->
                                                                    </tr>

                                                                <?php }
                                                            } else { ?>
                                                                <tr>
                                                                    <th class="text-center" colspan="7">Comments not found!</th>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                   <div id="coments_23" class="tab-pane fade" role="tabpanel" aria-labelledby="coments23-tab">
                                                    <table class="table  table-striped table-bordered text-dark mb-0">
                                                        <thead class="text-center">
                                                            <tr class="table_row_background">
                                                                <th width="118">Student ID</th>
                                                                <th>Comments</th>
                                                                <!-- <th>Suggestion for teacher</th>
                                                                <th>About College</th>
                                                                <th>Like about college</th>
                                                                <th>What makes student happy</th>
                                                                <th>Suggestion for college</th> -->
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($stdCommentInfo24)) {
                                                                foreach ($stdCommentInfo24 as $record) {
                                                            ?>
                                                                    <tr style="font-weight: bold; color:black;">
                                                                        <td class="text-left"><?php echo $record->student_id; ?></td>
                                                                        <td width="150"><?php echo $record->comments_impression; ?></td>
                                                                        <!-- <td><?php echo $record->suggestion; ?></td>
                                                                        <td><?php echo $record->opinion; ?></td>
                                                                        <td><?php echo $record->like_about; ?></td>
                                                                        <td><?php echo $record->happy; ?></td>
                                                                        <td><?php echo $record->college_improvement; ?></td> -->
                                                                    </tr>

                                                                <?php }
                                                            } else { ?>
                                                                <tr>
                                                                    <th class="text-center" colspan="7">Comments not found!</th>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>




                                                <div id="home" class="tab-pane fade">
                                                    <div class="form-row">
                                                        <table class="table  table-striped table-bordered text-dark mb-0">
                                                            <thead class="text-center">
                                                                <tr class="table_row_background">
                                                                    <th width="70">SL NO.</th>
                                                                    <th width="400">Question</th>
                                                                    <th width="400">Type</th>
                                                                    <th>YES</th>
                                                                    <th>NO</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody style="color:black !important;font-weight:bold; font-family:Arial, Helvetica, sans-serif;">
                                                                <?php if (!empty($questions)) {
                                                                    foreach ($questions as $q) {
                                                                        $yes_count = $qCountYes[$q->qid];
                                                                        $no_count = $qCountNO[$q->qid];
                                                                        // $total_count = $yes_count + $no_count;
                                                                        // $yes_percentage =  floor(($yes_count / $total_count) * 100);
                                                                        // $no_percentage =  floor(($no_count / $total_count) * 100);
                                                                ?>

                                                                        <tr>
                                                                            <td class="text-center"><?php echo $q->qid; ?></td>
                                                                            <td><?php echo $q->question; ?></td>
                                                                            <!-- <td><?php echo $q->type; ?></td> -->
                                                                            <td><?php echo $yes_count; ?></td>
                                                                            <td><?php echo $no_count; ?></td>
                                                                            <!-- <td>
                                                                                <b><?php echo $yes_count; ?></b>
                                                                                <div class="text-muted">
                                                                                    <div class="container bg-success rounded" >
                                                                                        <b style="color:black;"><?php echo $yes_percentage; ?>%</b>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <b><?php echo $no_count; ?><b>
                                                                                        <div class="text-muted">
                                                                                            <div class="container bg-danger rounded" >
                                                                                                <b style="color:black;"><?php echo $no_percentage; ?>%</b>
                                                                                            </div>
                                                                                        </div>
                                                                            </td> -->
                                                                        </tr>
                                                                    <?php }
                                                                } else { ?>
                                                                    <tr>
                                                                        <th class="text-center" colspan="7">Comments not found!</th>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>

                                                        <form role="form" id="editUser" action="<?php echo base_url() ?>addCommentToFeedbackByPrincipal/<?php echo $staffInfo->row_id; ?>" method="post">
                                                            <input type="hidden" value="2022" name="year" />
                                                            <div class="row">
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="comment">Comment:</label>
                                                                        <textarea class="form-control" rows="5" name="comment" id="comment" required><?php
                                                                                                                                                        if (!empty($mgmtComment)) {
                                                                                                                                                            echo $mgmtComment->response;
                                                                                                                                                        } ?>
                                                                        </textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12 col-md-12">
                                                                    <input style="float:right" type="submit" class="btn btn-success" value="Submit" />
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                                <div id="coments_22" class="tab-pane fade" role="tabpanel" aria-labelledby="coments-tab">
                                                    <table class="table  table-striped table-bordered text-dark mb-0">
                                                        <thead class="text-center">
                                                            <tr class="table_row_background">
                                                                <th width="118">Student ID</th>
                                                                <th>Comments</th>
                                                                <!-- <th>Suggestion for teacher</th>
                                                                <th>About College</th>
                                                                <th>Like about college</th>
                                                                <th>What makes student happy</th>
                                                                <th>Suggestion for college</th> -->
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($stdCommentInfo)) {
                                                                foreach ($stdCommentInfo as $record) {
                                                            ?>
                                                                    <tr style="font-weight: bold; color:black;">
                                                                        <td class="text-center"><?php echo $record->student_id; ?></td>
                                                                        <td width="150"><?php echo $record->comments_impression; ?></td>
                                                                        <!-- <td><?php echo $record->suggestion; ?></td>
                                                                        <td><?php echo $record->opinion; ?></td>
                                                                        <td><?php echo $record->like_about; ?></td>
                                                                        <td><?php echo $record->happy; ?></td>
                                                                        <td><?php echo $record->college_improvement; ?></td> -->
                                                                    </tr>

                                                                <?php }
                                                            } else { ?>
                                                                <tr>
                                                                    <th class="text-center" colspan="7">Comments not found!</th>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div id="menu1" class="tab-pane fade">
                                                    <table class="table  table-striped table-bordered text-dark mb-0">
                                                        <thead class="text-center">
                                                            <tr class="table_row_background">
                                                                <th width="118">Student ID</th>
                                                                <th>Comments</th>
                                                                <th>Suggestions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($commentsInfo)) {
                                                                foreach ($commentsInfo as $record) {
                                                            ?>
                                                                    <tr>
                                                                        <td><?php echo $record->student_id; ?></td>
                                                                        <td width="450"><?php echo $record->comments_impression; ?></td>
                                                                        <td><?php echo $record->suggestion; ?></td>
                                                                    </tr>

                                                                <?php }
                                                            } else { ?>
                                                                <tr>
                                                                    <th class="text-center" colspan="7">Comments not found!</th>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            

                                        <?php } else if ($staffInfo->role_id == ROLE_COUNSELOR) { ?>

                                            <table class="table  table-striped table-bordered text-dark mb-0">
                                                <thead class="text-center">
                                                    <tr class="table_row_background">
                                                        <th>Student ID</th>
                                                        <th>Question</th>
                                                        <th>Answer</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($questions)) {
                                                        foreach ($questions as $record) {
                                                    ?>
                                                            <tr>
                                                                <td><b><?php echo $record->student_id; ?></b></td>
                                                                <td width="380"><?php echo $record->question; ?></td>
                                                                <td><?php echo $record->answer; ?></td>
                                                            </tr>
                                                        <?php }
                                                    } else { ?>
                                                        <tr>
                                                            <th class="text-center" colspan="3">feedback not found!</th>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                    <?php }
                                    } ?>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#uploadedImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }


        $("#vImg").change(function() {
            readURL(this);
        });



        function onlyAlphabets(e, t) {
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                } else if (e) {
                    var charCode = e.which;
                } else {
                    return true;
                }
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123))
                    return true;
                else
                    return false;
            } catch (err) {
                alert(err.Description);
            }
        }
    </script>