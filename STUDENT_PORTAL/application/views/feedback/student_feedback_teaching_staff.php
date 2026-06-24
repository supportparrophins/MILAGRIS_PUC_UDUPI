<?php require APPPATH . 'views/includes/db.php'; ?>

<style>
    .custom-radio .custom-control-label::after {
        top: 9px !important;
        left: 6px !important;
    }
    .table-responsive-sm {
    max-height: 60vh; /* or adjust as needed */
    overflow-y: auto;
}
</style>
<style>
.custom-radio-icon {
    position: relative;
    width: 25px;
    height: 25px;
    cursor: pointer;
    display: inline-block;
}
.custom-radio-icon input[type="radio"] {
    opacity: 0;
    position: absolute;
    width: 100%;
    height: 100%;
    margin: 0;
    cursor: pointer;
    z-index: 2;
    top: 0;
    left: 0;
}
.custom-radio-icon .icon {
    width: 100%;
    height: 100%;
    background-color: white;
    border-radius: 50%;
    border: 2px solid #999;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: white;
    transition: all 0.2s ease;
}
.custom-radio-icon input[type="radio"]:checked ~ .icon {
    background-color: green;
    border-color: green;
    color: white;
}
.custom-radio-icon input[type="radio"]:checked ~ .icon::before {
       content: "✓"; /* Use a unicode check mark to avoid Font Awesome dependency */
    font-size: 14px;
    line-height: 1;
}
</style>
<div class="main-content-container container-fluid px-4">
    <div class="col-md-12">
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
    </div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mt-1 mb-2">
            <div class="col padding_left_right_null">
            <div class="card card-small p-0 card_head_dashboard">
                <div class="card-body p-2 ml-2">
                    <?php if($_SESSION['loggedIn_type']!='Mobile'){ ?>
                <span class="page-title">
                    <i class="fa fa-clock-o"></i> Student Feedback For Teaching Staff
                </span>
                
                <a onclick="window.history.back(); return false;" class="btn btn-primary float-right text-white pt-2" value="Back" >Back </a>
                <?php } ?>
                </div>
            </div>
            </div>
        </div>
    </section>
    <div class="row form-employee">
        <div class="col-12 padding_left_right_null">
            <div class="card card-small c-border p-2">
                <hr class="mt-1 mb-1 text-dark">
                <div class="table-responsive-sm">
                    <table class="table table-bordered table-striped table-hover text-dark">
                        <thead>
                            <tr>
                                <th>Staff Name</th>
                                <th>Department</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <?php
                        if (!empty($feedbackStaffInfo)) {
                            foreach ($feedbackStaffInfo as $staff) {
                        ?>
                                <tr>
                                    <td><?php echo strtoupper($staff->name); ?></td>
                                    <td><?php echo strtoupper($staff->dept_name); ?></td>
                                    <?php
                                    $feed_back_submitted = false;
                                    $isExist = checkStudentAlreadyGivenFeedback($con, $staff->staff_id, $student_id);
                                    if (!empty($isExist)) {
                                        $feed_back_submitted = true;
                                    } ?>
                                    <?php if ($feed_back_submitted == true) { ?>
                                        <td class="text-center"><b style="color:purple">Feedback Sent!</b></td>
                                    <?php  } else { ?>
                                        <td class="text-center"><button style="padding: .25rem .5rem !important;" type="button" onclick="giveFeedbackOpenModal('<?php echo addslashes($staff->name); ?>','<?php echo $staff->staff_id; ?>')" class="btn btn-primary btn-sm">
                                                Give Feedback
                                            </button></td>
                                    <?php  } ?>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="3">Staff Not Found!</td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- The Modal -->
<div class="modal fade" id="giveFeedbackModal" tabindex="-1" role="dialog" aria-labelledby="giveFeedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" style="background-color:#ADD8E6">
                <h4 class="modal-title" id="giveFeedbackModalLabel">Feedback to <span id="staff_name_display"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body" style="padding: 0.875rem 2.1875rem;">
                <form style="padding-left: 20px;padding-right: 20px;color: black;" action="<?php echo base_url(); ?>saveMyFeedback" method="post" id="studentFamilyform">
                    <input type="hidden" id="staff_id" name="staff_id" />
                    <ul style="color: red;" class="mt-0">
                        <li>Kindly answer the questions with sincerity, seriousness and responsibility.</li>
                        <li>Information provided is strictly confidential and will be used for teacher evaluation only.</li>
                        <li>Tick your choice in the applicable column using the key below.</li>
                        <li>All questions are compulsory.</li>
                    </ul>
                    <div class="table-responsive-sm">
                       <style>
                        .black-bordered th,
                        .black-bordered td,
                        .black-bordered thead tr th{
                            border: 1px solid black !important;
                        }
                        .black-bordered {
                            border: 1px solid black !important;
                        }
                    </style>
                        <table class="table table-bordered black-bordered">
                           <thead style="position: sticky; top: 0; z-index: 10; background: #97aeba;">
                                <tr class="text-center" style="color: black;">
                                    <th width="60">SL. No.</th>
                                    <th width="500">Question</th>
                                    <th width="60">Excellent</th>
                                    <th width="80">Very Good</th>
                                    <th width="60">Good</th>
                                    <th width="90">Satisfactory</th>
                                    <th width="110">Unsatisfactory</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($feedbacQuestions)) {
                                    $i = 1;
                                    foreach ($feedbacQuestions as $q) {
                                        $qid = $q->qid;
                                ?>
                                    <tr style="color: black;">
                                        <td class="text-center"><?php echo $i++; ?></td>
                                        <td><?php echo $q->question; ?></td>
                                        <?php for ($val = 5; $val >= 1; $val--) {
                                            $label_text = ['5' => 'Excellent', '4' => 'Very Good', '3' => 'Good', '2' => 'Satisfactory', '1' => 'Unsatisfactory'][$val];
                                        ?>
                                         <td style="background-color:#ADD8E6; text-align: center; vertical-align: middle;">
                                        <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
                                            <label class="custom-radio-icon">
                                                <input type="radio"
                                                    name="answer_<?php echo $qid; ?>"
                                                    id="radio_<?php echo $qid . '_' . $val; ?>"
                                                    value="<?php echo $val; ?>" required>
                                                <div class="icon"></div>
                                            </label>
                                        </div>
                                    </td>
                                        <?php } ?>
                                    </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <hr class="mt-3 mb-3 text-dark">
                    <div class="form-group">
                        <label for="impression" style="color: green;"><b>Strengths of the Teacher</b></label>
                        <textarea name="impression" class="form-control" id="impression" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="suggestions" style="color: green;"><b>Areas for Improvement for the Teacher</b></label>
                        <textarea name="suggestions" class="form-control" id="suggestions" rows="3" required></textarea>
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="submit" id="submitBtn" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('.datepicker').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            endDate: "today"
        });
        jQuery('ul.pagination li a').click(function(e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#byDateFilter").attr("action", baseURL + "studentLaterComer/" + value);
            jQuery("#byDateFilter").submit();
        });
         // Reset form when modal is closed
        $('#giveFeedbackModal').on('hidden.bs.modal', function () {
            document.getElementById("studentFamilyform").reset();
        });
    });
    function giveFeedbackOpenModal(staff_name, staff_id) {
         document.getElementById("studentFamilyform").reset();
        $("#staff_id").val(staff_id);
        $('#staff_name_display').html(staff_name);
        $('#giveFeedbackModal').modal('show');
    }
</script>
<?php
function checkStudentAlreadyGivenFeedback($con, $staff_id, $student_id)
{
    $query = "SELECT * FROM tbl_student_feedback_teaching_staff as feed\n    WHERE feed.staff_id = '$staff_id' AND feed.student_id = '$student_id' AND feed.feedback_year = '2025'";
    $pdo_statement = $con->prepare($query);
    $pdo_statement->execute();
    return $pdo_statement->fetch();
}
?>