<?php
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
$noMatch = $this->session->flashdata('nomatch');
if ($noMatch) {
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
<div class="main-content-container container-fluid px-4">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mt-1 mb-2">
            <div class="col padding_left_right_null">
                <div class="card card-small p-0 card_head_dashboard">
                    <div class="card-body p-2 ml-2">
                        <span class="page-title">
                            <i class="material-icons">circle_notifications</i> My Notifications
                        </span>
                        <a onclick="window.history.back(); return false;" class="btn btn-primary border_left_radius float-right text-white pt-2" value="Back">Back </a>
                        <!-- <a class="btn btn-danger  float-right border_right_radius" href="<?= base_url() ?>myBulkNotification"> <i class="fa fa-bullhorn" aria-hidden="true"></i></a> -->

                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="row form-employee">
        <div class="col-12 padding_left_right_null">
            <div class="card card-small c-border mb-4">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table_row_backgrond">
                            <tr>
                                <th>Date</th>
                                <th>Term Name</th>
                                <th>Stream</th>
                                <!-- <th>Section</th> -->
                                <th>Subject</th>
                                <th>Message</th>
                                <th class="text-center">Attachment</th>
                                <!-- <th>Sent By</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($notifications)) {
                                foreach ($notifications as $notification) { ?>
                                    <tr>
                                        <td width="100"><?= date('d-m-Y', strtotime($notification->date_time)) ?></td>
                                        <td><?= $notification->term_name ?></td>
                                        <td><?= $notification->stream_name ?></td>
                                        
                                        <td><?= $notification->subject ?></td>
                                        <td><?= $notification->message ?></td>
                                        <td class="text-center">
                                            <?php
                                            if ($notification->filepath != "") { ?>
                                                <a class='btn btn-sm btn-primary' href='<?php echo ADMIN_PATH; ?><?php echo $notification->filepath; ?>' download><i class='fa fa-download'></i> Download</a>
                                            <?php }
                                            ?>
                                        </td>
                                        <!-- <td><?= $notification->sent_by ?></td> -->
                                    </tr>
                            <?php }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
</script>