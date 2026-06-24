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

<div class="main-content-container container-fluid px-4 pt-1 content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mt-1">
            <div class="col-12">
                <div class="card card-small p-0 card_heading_title">
                    <div class="card-body p-2 ml-2">
                        <span class="page-title absent_table_title_mobile">
                            <i class="material-icons">group</i> Student Feedback of <?php echo $staffInfo->name; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-small c-border mb-4 p-2">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-2">
                            <div class="row column_padding_card">
                                <div class="col column_padding_card profile-head">
                                    <?php if (!empty($staffInfo)) {
                                        if ($staffInfo->role_id == ROLE_TEACHING_STAFF || $staffInfo->role_id == ROLE_VICE_PRINCIPAL) { ?>

                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" id="question-tab" href="#question_23">Questions-23</a></li>
                                                <li class="nav-item"><a data-toggle="tab" id="coments-tab" class="nav-link" href="#coments_23" role="tab" aria-controls="comments" aria-selected="false">Comments-23</a></li>
                                                <li class="nav-item"><a class="nav-link" data-toggle="tab" id="question-tab" href="#question_22">Questions-22</a></li>
                                                <li class="nav-item"><a data-toggle="tab" id="coments-tab" class="nav-link" href="#coments_22" role="tab" aria-controls="comments" aria-selected="false">Comments-22</a></li>
                                                <li class="nav-item"><a class="nav-link" data-toggle="tab" id="question-tab" href="#question_21">Questions-21</a></li>
                                                <li class="nav-item"><a data-toggle="tab" id="coments-tab" class="nav-link" href="#coments_21" role="tab" aria-controls="comments" aria-selected="false">Comments-21</a></li>
                                            </ul>

                                            <div class="tab-content question-tab" id="myTabContent">
                                            <div id="question_23" class="tab-pane fade show active" role="tabpanel" aria-labelledby="question-tab">
                                                    <table class="table table-bordered text-dark mb-0">
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
                                                                    $yes_count = $qStdCountYes23[$q->qid];
                                                                    $no_count = $qStdCountNo23[$q->qid];
                                                                    $total_count = $yes_count + $no_count;
                                                                    $yes_percentage =  floor(($yes_count / $total_count) * 100);
                                                                    $no_percentage =  floor(($no_count / $total_count) * 100);
                                                            ?>

                                                                    <tr>
                                                                        <td class="text-center"><?php echo $q->qid; ?></td>
                                                                        <td><?php echo $q->question; ?></td>
                                                                        <td><?php echo $q->type; ?></td>
                                                                        <td class="text-center">
                                                                            <span style="font-weight:bold;"><?php echo $yes_count; ?></span>
                                                                            <div class="text-muted">
                                                                                <div class="container bg-success rounded">
                                                                                    <span style="font-weight:bold;color:black;"><?php echo $yes_percentage; ?>%</span>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <span style="font-weight:bold;"><?php echo $no_count; ?></span>
                                                                            <div class="text-muted">
                                                                                <div class="container bg-danger rounded">
                                                                                    <span style="font-weight:bold;color:black;"><?php echo $no_percentage; ?>%</span>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php }
                                                            } else { ?>
                                                                <tr>
                                                                    <th class="text-center" colspan="3">Comments not found!</th>
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
                                                                    <textarea class="form-control" rows="5" name="comment" id="comment" required><?php if (!empty($staffMgtComment23)) { echo $staffMgtComment23->response;} ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="comment">Suggestion:</label>
                                                            <textarea class="form-control" rows="5" name="suggestion" id="" required><?php if (!empty($staffMgtComment23)) { echo $staffMgtComment23->suggestion; } ?></textarea>
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
                                                <div id="question_22" class="tab-pane fade " role="tabpanel" aria-labelledby="question-tab">
                                                    <table class="table table-bordered text-dark mb-0">
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
                                                                    $yes_count = $qStdCountYes22[$q->qid];
                                                                    $no_count = $qStdCountNo22[$q->qid];
                                                                    $total_count = $yes_count + $no_count;
                                                                    $yes_percentage =  floor(($yes_count / $total_count) * 100);
                                                                    $no_percentage =  floor(($no_count / $total_count) * 100);
                                                            ?>

                                                                    <tr>
                                                                        <td class="text-center"><?php echo $q->qid; ?></td>
                                                                        <td><?php echo $q->question; ?></td>
                                                                        <td><?php echo $q->type; ?></td>
                                                                        <td class="text-center">
                                                                            <span style="font-weight:bold;"><?php echo $yes_count; ?></span>
                                                                            <div class="text-muted">
                                                                                <div class="container bg-success rounded">
                                                                                    <span style="font-weight:bold;color:black;"><?php echo $yes_percentage; ?>%</span>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <span style="font-weight:bold;"><?php echo $no_count; ?></span>
                                                                            <div class="text-muted">
                                                                                <div class="container bg-danger rounded">
                                                                                    <span style="font-weight:bold;color:black;"><?php echo $no_percentage; ?>%</span>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php }
                                                            } else { ?>
                                                                <tr>
                                                                    <th class="text-center" colspan="3">Comments not found!</th>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>

                                                    <form role="form" id="editUser" action="<?php echo base_url() ?>addCommentToFeedbackByPrincipal/<?php echo $staffInfo->row_id; ?>" method="post">
                                                        <input type="hidden" value="2022" name="year" />
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12">
                                                                <div class="form-group">
                                                                    <label for="comment" style="font-weight:bold;color:black;">Comment:</label>
                                                                    <textarea class="form-control" rows="5" name="comment" id="comment" required><?php if (!empty($staffMgtComment22)) {
                                                                                                                                                        echo $staffMgtComment22->response;
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
                                                <div id="home" class="tab-pane fade">
                                                    <table class="table table-bordered text-dark mb-0">
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
                                                                    $total_count = $yes_count + $no_count;
                                                                    $yes_percentage =  floor(($yes_count / $total_count) * 100);
                                                                    $no_percentage =  floor(($no_count / $total_count) * 100);
                                                            ?>

                                                                    <tr>
                                                                        <td class="text-center"><?php echo $q->qid; ?></td>
                                                                        <td><?php echo $q->question; ?></td>
                                                                        <td><?php echo $q->type; ?></td>
                                                                        <td>
                                                                            <b><?php echo $yes_count; ?></b>
                                                                            <div class="text-muted">
                                                                                <div class="container bg-success rounded">
                                                                                    <b style="color:black;"><?php echo $yes_percentage; ?>%</b>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <b><?php echo $no_count; ?><b>
                                                                                    <div class="text-muted">
                                                                                        <div class="container bg-danger rounded">
                                                                                            <b style="color:black;"><?php echo $no_percentage; ?>%</b>
                                                                                        </div>
                                                                                    </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php }
                                                            } else { ?>
                                                                <tr>
                                                                    <th class="text-center" colspan="3">Comments not found!</th>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>

                                                    <form role="form" id="editUser" action="<?php echo base_url() ?>addCommentToFeedbackByPrincipal/<?php echo $staffInfo->row_id; ?>" method="post">
                                                        <input type="hidden" value="2019" name="year" />
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

                                                <div id="coments_23" class="tab-pane fade" role="tabpanel" aria-labelledby="coments-tab">
                                                    <table class="table table-bordered text-dark mb-0">
                                                        <thead class="text-center">
                                                            <tr class="table_row_background">
                                                                <th width="118">Student ID</th>
                                                                <th>Comments</th>
                                                                <th>Suggestions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($stdCommentInfo23)) {
                                                                foreach ($stdCommentInfo23 as $record) {
                                                            ?>
                                                                    <tr style="font-weight: bold; color:black;">
                                                                        <td><?php echo $record->student_id; ?></td>
                                                                        <td width="450"><?php echo $record->comments_impression; ?></td>
                                                                        <td><?php echo $record->suggestion; ?></td>
                                                                    </tr>

                                                                <?php }
                                                            } else { ?>
                                                                <tr>
                                                                    <th class="text-center" colspan="3">Comments not found!</th>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div id="coments_22" class="tab-pane fade" role="tabpanel" aria-labelledby="coments-tab">
                                                    <table class="table table-bordered text-dark mb-0">
                                                        <thead class="text-center">
                                                            <tr class="table_row_background">
                                                                <th width="118">Student ID</th>
                                                                <th>Comments</th>
                                                                <th>Suggestions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($stdCommentInfo22)) {
                                                                foreach ($stdCommentInfo22 as $record) {
                                                            ?>
                                                                    <tr style="font-weight: bold; color:black;">
                                                                        <td><?php echo $record->student_id; ?></td>
                                                                        <td width="450"><?php echo $record->comments_impression; ?></td>
                                                                        <td><?php echo $record->suggestion; ?></td>
                                                                    </tr>

                                                                <?php }
                                                            } else { ?>
                                                                <tr>
                                                                    <th class="text-center" colspan="3">Comments not found!</th>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div id="question_21" class="tab-pane fade show" role="tabpanel" aria-labelledby="question-tab">
                                                    <table class="table table-bordered text-dark mb-0">
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
                                                                    $yes_count = $qStdCountYes[$q->qid];
                                                                    $no_count = $qStdCountNo[$q->qid];
                                                                    $total_count = $yes_count + $no_count;
                                                                    $yes_percentage =  floor(($yes_count / $total_count) * 100);
                                                                    $no_percentage =  floor(($no_count / $total_count) * 100);
                                                            ?>

                                                                    <tr>
                                                                        <td class="text-center"><?php echo $q->qid; ?></td>
                                                                        <td><?php echo $q->question; ?></td>
                                                                        <td><?php echo $q->type; ?></td>
                                                                        <td class="text-center">
                                                                            <span style="font-weight:bold;"><?php echo $yes_count; ?></span>
                                                                            <div class="text-muted">
                                                                                <div class="container bg-success rounded">
                                                                                    <span style="font-weight:bold;color:black;"><?php echo $yes_percentage; ?>%</span>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <span style="font-weight:bold;"><?php echo $no_count; ?></span>
                                                                            <div class="text-muted">
                                                                                <div class="container bg-danger rounded">
                                                                                    <span style="font-weight:bold;color:black;"><?php echo $no_percentage; ?>%</span>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php }
                                                            } else { ?>
                                                                <tr>
                                                                    <th class="text-center" colspan="3">Comments not found!</th>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>

                                                    <form role="form" id="editUser" action="<?php echo base_url() ?>addCommentToFeedbackByPrincipal/<?php echo $staffInfo->row_id; ?>" method="post">
                                                        <input type="hidden" value="2021" name="year" />
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
                                                <div id="home" class="tab-pane fade">
                                                    <table class="table table-bordered text-dark mb-0">
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
                                                                    $total_count = $yes_count + $no_count;
                                                                    $yes_percentage =  floor(($yes_count / $total_count) * 100);
                                                                    $no_percentage =  floor(($no_count / $total_count) * 100);
                                                            ?>

                                                                    <tr>
                                                                        <td class="text-center"><?php echo $q->qid; ?></td>
                                                                        <td><?php echo $q->question; ?></td>
                                                                        <td><?php echo $q->type; ?></td>
                                                                        <td>
                                                                            <b><?php echo $yes_count; ?></b>
                                                                            <div class="text-muted">
                                                                                <div class="container bg-success rounded">
                                                                                    <b style="color:black;"><?php echo $yes_percentage; ?>%</b>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <b><?php echo $no_count; ?><b>
                                                                                    <div class="text-muted">
                                                                                        <div class="container bg-danger rounded">
                                                                                            <b style="color:black;"><?php echo $no_percentage; ?>%</b>
                                                                                        </div>
                                                                                    </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php }
                                                            } else { ?>
                                                                <tr>
                                                                    <th class="text-center" colspan="3">Comments not found!</th>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>

                                                    <form role="form" id="editUser" action="<?php echo base_url() ?>addCommentToFeedbackByPrincipal/<?php echo $staffInfo->row_id; ?>" method="post">
                                                        <input type="hidden" value="2019" name="year" />
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

                                                <div id="coments_21" class="tab-pane fade" role="tabpanel" aria-labelledby="coments-tab">
                                                    <table class="table table-bordered text-dark mb-0">
                                                        <thead class="text-center">
                                                            <tr class="table_row_background">
                                                                <th width="118">Student ID</th>
                                                                <th>Comments</th>
                                                                <th>Suggestions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($stdCommentInfo)) {
                                                                foreach ($stdCommentInfo as $record) {
                                                            ?>
                                                                    <tr style="font-weight: bold; color:black;">
                                                                        <td><?php echo $record->student_id; ?></td>
                                                                        <td width="450"><?php echo $record->comments_impression; ?></td>
                                                                        <td><?php echo $record->suggestion; ?></td>
                                                                    </tr>

                                                                <?php }
                                                            } else { ?>
                                                                <tr>
                                                                    <th class="text-center" colspan="3">Comments not found!</th>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div id="menu1" class="tab-pane fade">
                                                    <table class="table table-bordered text-dark mb-0">
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
                                                                    <th class="text-center" colspan="3">Comments not found!</th>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        <?php } else if ($staffInfo->role_id == ROLE_COUNSELOR) { ?>

                                            <table class="table table-bordered text-dark mb-0">
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

                                            <form role="form" id="editUser" action="<?php echo base_url() ?>addCommentToFeedbackByPrincipal/<?php echo $staffInfo->row_id; ?>" method="post">
                                                <input type="hidden" value="2023" name="year" />
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="comment">Comment:</label>
                                                            <textarea class="form-control" rows="5" name="comment"  id="comment" required><?php if (!empty($princiComment)) { echo $princiComment->response; } ?></textarea>
                                                        </div>
                                                    </div>



                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="comment">Suggestion:</label>
                                                            <textarea class="form-control" rows="5" name="suggestion" id="" required><?php if (!empty($princiComment)) { echo $princiComment->suggestion; } ?> </textarea>
                                                        </div>
                                                    </div>
                                                 
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <input style="float:right" type="submit" class="btn btn-success" value="Submit" />
                                                    </div>
                                                </div>
                                            </form>
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