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

                        <span class="page-title absent_table_title_mobile">

                        <i class="material-icons">school</i> Class Absent Report 2023-24

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

                <form action="<?php echo base_url(); ?>overallStudentAttendance" method="POST" id="byFilterMethod">

                    <div class="row">

                        <div  class="col-lg-3 col-md-3 col-12"> 

                            <div class="form-group position-relative mb-1">

                                <input class="form-control mobile-width datepicker" value="<?php echo $searchDate; ?>" type="text" name="by_date" id="date" value="" class="form-control input-sm"  style="text-transform: uppercase" placeholder="By Date" autocomplete="off">

                            </div>

                        </div>

                        <div class="col-lg-3 col-md-3 col-12">  

                            <div class="form-group mb-1">

                                <select class="form-control" id="exampleFormControlSelect1" name="subject_code">

                                <option value="<?php echo $searchSubject; ?>">By Subject Name</option>

                                <?php foreach($subjectInfo as $sub){

                                        if($sub->subject_code == $searchSubject){ ?>

                                             <option value="<?php echo $sub->subject_code; ?>" selected><?php echo 'By '.$sub->name; ?></option>

                                        <?php } ?>

                                

                                <option value="<?php echo $sub->subject_code; ?>"><?php echo $sub->name; ?></option>

                                    <?php } ?>

                                </select>

                            </div>

                        </div>

                        <div class="col-lg-3 col-md-3 col-12"> 

                            <div class="form-group mb-1">

                                <select class="form-control" id="exampleFormControlSelect1" name="time_id">

                                <option value="<?php echo $searchTime; ?>">By Time</option>

                                <?php 

                                    foreach($timeInfo as $time){



                                        if($time->row_id == $searchTime){ ?>

                                            <option value="<?php echo $time->row_id; ?>" selected><?php echo  'By '.$time->start_time.' - '.$time->end_time; ?></option>

                                        <?php } ?>

                                <option value="<?php echo $time->row_id; ?>"><?php echo $time->start_time.' - '.$time->end_time; ?></option>

                                    <?php } ?>

                                </select>

                            </div>

                        </div>

                        <div class="col-lg-3 col-md-3 col-12"><button type="submit"class="btn btn-success btn-block mobile-width"> Search</button></div>

                    </div>

                </form><hr class="mt-1 mb-2">

                    <div class="table-responsive-sm ">

                    <table class="table table-bordered text-dark">

                        <thead class="text-center">

                            <tr class="table_row_background">

                                <th>Date</th>

                                <th>Subject</th>

                                <th>Time</th>

                            </tr>

                            <?php if(!empty($attendanceInfo)){

                                foreach($attendanceInfo as $att){ ?>

                                <tr class="text-dark">

                                <td><?php echo date('d-m-Y',strtotime($att->absent_date)); ?></td>

                                <td><?php echo $att->name; ?></td>

                                <td><?php echo $att->start_time.' - '.$att->end_time; ?></td>

                                </tr>

                            <?php } }else{ ?>

                                <tr>

                                    <td colspan="3" class="text-center">Absent class not found</td>

                                </tr>

                            <?php } ?>

                        </thead>

                    </table>

                    </div>

                    <div class="row">

                        <div class="col-lg-6 col-md-6 col-sm-12">

                            <?php echo $this->pagination->create_links(); ?>

                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">

                            <b class="float-right text-dark font-weight-bold">Total Class Absent:<?php echo $totalAbsent; ?></b>

                        </div>

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

        jQuery("#byFilterMethod").attr("action", baseURL + "overallStudentAttendance/" + value);

        jQuery("#byFilterMethod").submit();

    });

});

</script>