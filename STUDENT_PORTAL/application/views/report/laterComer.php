<div class="main-content-container container-fluid px-4">
    <div class="col-md-12">
        <?php
            $this->load->helper('form');
            $error = $this->session->flashdata('error');
            if($error)
            {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $this->session->flashdata('error'); ?>                    
        </div>
        <?php } ?>
        <?php  
            $success = $this->session->flashdata('success');
            if($success)
            {
        ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $this->session->flashdata('success'); ?>
        </div>
        <?php } ?>

        <?php  
            $noMatch = $this->session->flashdata('nomatch');
            if($noMatch)
            {
        ?>
        <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $this->session->flashdata('nomatch'); ?>
        </div>
        <?php } ?>
        
        <div class="row">
            <div class="col-md-12">
                <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
            </div>
        </div>
    </div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mt-1 mb-2">
            <div class="col padding_left_right_null">
                <div class="card card-small p-0">
                    <div class="card-body p-2 ml-2">
                        <span class="page-title">
                        <i class="fa fa-clock-o"></i> Latecomer Report
                        </span>
                        <a onclick="window.history.back();" class="btn btn-primary float-right text-white pt-2" value="Back" >Back </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="row form-employee">
        <div class="col-12 padding_left_right_null">
            <div class="card card-small c-border p-2">
                <form action="<?php echo base_url(); ?>studentLaterComer" method="POST" id="byDateFilter">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-12 my-auto">
                                <b class="font-weight-bold" style="font-size: 16px;">No. of late days : <?php echo $totalLate; ?></b>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12 ml-auto">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" value="<?php echo $searchDate; ?>" name="by_date" placeholder="By Date" aria-label="date" aria-describedby="basic-addon2" autocomplete="off">
                                <div class="input-group-append">
                                    <button class="input-group-btn btn btn-success" id="basic-addon2">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form><hr class="mt-1 mb-1 text-dark">
                <div class="table-responsive-sm">
                    <table class="table table-bordered text-dark text-center"> 
                        <thead>
                            <tr class="table_row_background">
                                <th>Date</th>
                                <th>In Time</th>
                                <th>Time Difference</th>
                            </tr>
                        </thead>
                        <?php if(!empty($lateComerInfo)){
                            foreach($lateComerInfo as $late){ 
                            $start_time = new DateTime($late->intime);
                            $time_diff = $start_time->diff(new DateTime('08:30:00'));
                            ?>
                            <tr>
                                <td width="350"><?php echo date('d-m-Y',strtotime($late->date)); ?></td>
                                <td width="350"><?php echo $late->intime; ?></td>
                                <td width="350"><?php echo $time_diff->format('%h') .' Hour '.$time_diff->format('%I').' Mins'; ?></td>
                            </tr>
                        <?php } }else{?>
                            <tr>
                                <td colspan="3">Late info not found</td>
                            </tr>
                        <?php } ?>
                    </table>
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div>  
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery('.datepicker').datepicker({
        autoclose: true,
        format : "dd-mm-yyyy",
        endDate : "today"
    });

    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byDateFilter").attr("action", baseURL + "studentLaterComer/" + value);
        jQuery("#byDateFilter").submit();
    });
});
</script>