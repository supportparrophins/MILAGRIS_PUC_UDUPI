<div class="main-content-container container-fluid px-4">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mt-1 mb-2">
            <div class="col padding_left_right_null">
                <div class="card card-small p-0">
                    <div class="card-body p-2 ml-2">
                        <span class="page-title">
                        <i class="material-icons">notifications</i> Notifications
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
                <form action="<?php echo base_url(); ?>studentNotificationReport" method="POST" id="byFilterDate">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-12 my-auto">
                                <b class="font-weight-bold" style="font-size: 16px;">Notifications : <?php echo $totalNotification; ?></b>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12 ml-auto">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker" value="<?php echo $dateSearch; ?>" name="by_date" placeholder="By Date" aria-label="date" aria-describedby="basic-addon2" autocomplete="off">
                                <div class="input-group-append">
                                    <button class="input-group-btn btn btn-success" id="basic-addon2">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form><hr class="mt-1 mb-1 text-dark">
                <div class="table-responsive-sm">
                    <table class="table table-bordered text-dark">
                        <thead class="text-center">
                            <tr class="table_row_background">
                                <th>Date</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <?php if(!empty($studentNotification)){
                            foreach($studentNotification as $notify){ ?>
                            <tr>
                                <td width="150" class="text-center"><?php echo date('d-m-Y',strtotime($notify->date_time)); ?></td>
                                <td><?php echo str_replace('%n', '', $notify->message); ?></td>
                            </tr>
                        <?php } }else{?>
                            <tr>
                                <td class="text-center" colspan="2">Notification Not Found </td>
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
        jQuery("#byFilterDate").attr("action", baseURL + "studentNotificationReport/" + value);
        jQuery("#byFilterDate").submit();
    });
});
</script>