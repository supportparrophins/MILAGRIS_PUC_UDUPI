<?php
ini_set('memory_limit', '2000M');
$this->load->helper('form');
$error = $this->session->flashdata('error');
if ($error) {
?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $this->session->flashdata('error'); ?>
    </div>
<?php } ?>
<?php
$success = $this->session->flashdata('success');
if ($success) {
?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php } ?>

<?php
$warning = $this->session->flashdata('warning');
if ($warning) {
?>
    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $this->session->flashdata('warning'); ?>
    </div>
<?php } ?>


<div class="main-content-container px-3 pt-1">
    <div class="row">
        <div class="col-md-12">

            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
        </div>
    </div>

    <!-- Content Header (Page header) -->
    <div class="row p-0">
        <div class="col column_padding_card">
            <div class="card card-small card_heading_title p-0 m-b-1">
                <div class="card-body p-2">
                    <div class="row c-m-b">
                        <div class="col-8 col-sm-4 col-md-5">
                            <span class="page-title absent_table_title_mobile">
                                <i class="fa fa-file"></i> SMS Report
                            </span>
                        </div>

                        <div class="col-4 col-sm-4 col-md-3">
                            <div class="text-center text-dark">

                                <b class="pull-left" style="font-size: 20px;"> Total SMS : <?php echo $sms_counts ?></b>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4 col-md-4 box-tools">
                            <a onclick="window.history.back();" class="btn btn-md primary_color mobile-btn float-right text-white pt-2" value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row form-employee">
        <div class="col-12 column_padding_card">
            <div class="card card-small c-border p-1">
                <div class="table-responsive-sm">
                    <table class="table table-bordered text-dark">

                        <form action="<?php echo base_url() ?>openSMSSentReport" method="POST" id="searchList">

                            <tr class="filter_row">
                                <th>
                                    <div class="form-group">
                                        <input type="text" name="date_search" value="<?php echo $date_search; ?>" id="date_search" class="form-control form-control-md date_search" placeholder="Date" autocomplete="off" />
                                    </div>
                                </th>
                                <th>
                                    <div class="form-group">
                                        <input type="text" name="student_id" value="<?php echo $student_id; ?>" class="form-control form-control-md pull-right" placeholder="student ID" autocomplete="off" />
                                    </div>
                                </th>
                                <th>
                                    <div class="form-group">
                                        <input type="text" name="by_name" value="<?php echo $by_name; ?>" class="form-control form-control-md pull-right" placeholder="student Name" autocomplete="off" />
                                    </div>
                                </th>
                                <td>
                                    <div class="form-group mb-0">
                                        <select class="form-control" name="term_name" id="term_name">
                                            <?php if (!empty($term_name)) { ?>
                                                <option value="<?php echo $term_name; ?>" selected><b>Selected: <?php echo $term_name; ?></b></option>
                                            <?php } ?>
                                            <option value="">By Term</option>
                                            <option value="I PUC">I PUC</option>
                                            <option value="II PUC">II PUC</option>
                                        </select>
                                    </div>
                                </td>
                                <th>
                                    <div class="form-group">
                                        <select class="form-control " name="by_stream">
                                            <?php if (!empty($by_stream)) { ?>
                                                <option value="<?php echo $by_stream; ?>" selected><b>Selected: <?php echo $by_stream; ?></b></option>
                                            <?php } ?>
                                            <option value="">select student Stream</option>
                                             <?php 
                                                if(!empty($streamInfo)){
                                                    foreach($streamInfo as $stream){
                                                        echo "<option value='".$stream->stream_name."'>".$stream->stream_name."</option>";
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </th>
                                <th>
                                    <div class="form-group">
                                        <input type="text" name="message" value="<?php echo $message; ?>" class="form-control form-control-md pull-right" placeholder="Message" autocomplete="off" />
                                    </div>
                                </th>
                                <th>
                                    <div class="form-group">
                                        <input type="text" name="mobile" value="<?php echo $mobile; ?>" class="form-control form-control-md pull-right" placeholder="mobile" autocomplete="off" />
                                    </div>
                                </th>
                                <th>
                                    <div class="form-group">
                                        <input type="text" name="sms_count" value="<?php echo $sms_count; ?>" class="form-control form-control-md pull-right" placeholder="Sms Count" autocomplete="off" />
                                    </div>
                                </th>

                                <th> <button class="btn btn-block btn-success "><i class="fa fa-filter"></i> Filter </button></th>
                            </tr>
                        </form>
                        <thead class="text-center">
                            <tr class="table_row_background">
                                <th width="140">Date</th>
                                <th >Student ID</th>
                                <th width="180">Student name</th>
                                <th>Term Name</th>
                                <th>Stream</th>
                                <th>Message</th>
                                <th>Mobile</th>
                                <th>Sms Count</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <thead>
                            <?php if (!empty($accountDetails)) {
                                foreach ($accountDetails as $account) { ?>
                                    <tr>
                                        <td class="text-center"><?php echo date('d-m-Y',strtotime($account->sent_date)); ?></td>
                                        <td><?php echo $account->student_id ?></td>
                                        <td class=""><?php echo strtoupper($account->student_name); ?></td>
                                        <td class="text-center"><?php echo $account->term_name; ?></td>
                                        <td class="text-center"><?php echo $account->stream_name; ?></td>
                                        <td class="text-center"><?php echo $account->message; ?></td>
                                        <td class="text-center"><?php echo $account->mobile; ?></td>
                                        <td class="text-center"><?php echo $account->sms_count; ?></td>
                                        <td class="text-center"><?php echo $account->status; ?></td>
                                        
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr class="table-info">
                                    <td class="text-center" colspan="9">Record Not Found</td>
                                </tr>
                            <?php } ?>
                        </thead>
                        <thead class="text-center">
                            <tr class="table_row_background">
                                <th width="140">Date</th>
                                <th width="120">Student ID</th>
                                <th width="180">Student name</th>
                                <th>Term Name</th>
                                <th>Stream</th>
                                <th width="180">Message</th>
                                <th>Mobile</th>
                                <th>Sms Count</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="row">
                    <div class="col-12">
                        <span class="float-right"><?php echo $this->pagination->create_links(); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/enquiry.js" charset="utf-8"></script>
    <script>
        jQuery(document).ready(function() {

            jQuery('ul.pagination li a').click(function(e) {
                e.preventDefault();
                var link = jQuery(this).get(0).href;
                var value = link.substring(link.lastIndexOf('/') + 1);
                jQuery("#searchList").attr("action", baseURL + "openSMSSentReport/" + value);
                jQuery("#searchList").submit();
            });

            // jQuery('.date_search').datepicker({
            //     autoclose: true,
            //     orientation: "bottom",
            //     format: "dd-mm-yyyy",
            //     startDate: "01-11-2021"

            // });

            jQuery('.date_search').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            endDate: "today"
        });


            $('[data-toggle="popover"]').popover({
                "container": "body",
                "trigger": "focus",
                "html": true
            });
            $('[data-toggle="popover"]').mouseenter(function() {
                $(this).trigger('focus');
            });


        });
    </script>