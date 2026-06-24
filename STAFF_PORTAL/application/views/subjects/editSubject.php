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
        $warning = $this->session->flashdata('warning');
        if ($warning) { 
        ?>
        <div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <i class="fa fa-check mx-2"></i>
            <strong>warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
        </div>
    <?php }?>

    <div class="row">
        <div class="col-md-12">
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
        </div>
    </div>
</div>
<div class="main-content-container container-fluid px-4">

    <!-- Content Header (Page header) -->
    <section class="content-header pt-1">
        <div class="row">
            <div class="col-12">
                <div class="card card-small p-0 card_heading_title">
                    <div class="card-body p-2 ml-2">
                        <span class="page-title"> <i class="fa fa-book"></i> Edit Subject </span>
                        <a onclick="showLoader();window.history.back();" class="btn primary_color float-right text-white pt-2"
                            value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if(empty($subjectInfo)){ ?>
    <div class="row form-employee">
        <div class="col-lg-12 col-md-12 col-12 pr-0 text-center">
        <img height="270" src="<?php echo base_url(); ?>assets/images/404.png"/>
        </div>
    </div>
    <?php } else {  ?>
    <form role="form" action="<?php echo base_url() ?>updateSubject" method="post" role="form">
    <div class="row form-employee">
        <div class="col-12">
            <form class="card card-small c-border mb-4 ">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item p-2">
                        <input type="hidden" value="<?php echo $subjectInfo->row_id; ?>" name="row_id" id="row_id"/>
                            <div class="row">
                                <div class="col">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label  for="email ">Subject Name</label>
                                            <input type="text" class="form-control required" id="sub_name"
                                                value="<?php echo $subjectInfo->sub_name; ?>" name="sub_name"
                                                maxlength="228" placeholder="Subject Name"
                                                autocomplete="off" required/>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="mobile">Subject Code</label>
                                            <input type="text" class="form-control required"
                                                id="sub_code" value="<?php echo $subjectInfo->subject_code; ?>" name="sub_code"
                                                placeholder="Subject Code" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="lab">Subject Lab Status</label>
                                            <select required class="form-control required selectpicker" id="lab_status" name="lab_status" required>
                                                <option value="<?php echo $subjectInfo->lab_status; ?>">Selected: <?php echo $subjectInfo->lab_status; ?></option>
                                                <option value="">Select Lab Status</option>
                                                <option value="true">Yes</option>
                                                <option value="false">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="role">Subject Type</label>
                                            <select required class="form-control required selectpicker" id="subject_type" name="subject_type" required>
                                                <option value="<?php echo $subjectInfo->sub_type; ?>">Selected: <?php echo $subjectInfo->sub_type; ?></option>
                                                <option value="">Select Subject Type</option>
                                                <option value="LANGUAGE">LANGUAGE</option>
                                                <option value="SCIENCE">SCIENCE</option>
                                                <option value="COMMERCE">COMMERCE</option>
                                                <option value="ARTS">ARTS</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="team_id">Select Department</label>
                                            <select required name="department" id="department" class="form-control required selectpicker" required>
                                                <option value="<?php echo $subjectInfo->department_id; ?>">Selected: <?php echo $subjectInfo->name; ?></option>
                                                <option value="">Select Department</option>
                                                <?php
                                                    if(!empty($departments))
                                                    {
                                                        foreach ($departments as $rl)
                                                        {
                                                            ?>
                                                            <option value="<?php echo $rl->dept_id ?>" <?php if($rl->id == set_value('role')) {echo "selected=selected";} ?>><?php echo $rl->name; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                        <div class="mt-3 col-md-6">
                                            <button type="submit" class="btn btn-success float-right"> Update </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>

    <?php } ?>

</div>