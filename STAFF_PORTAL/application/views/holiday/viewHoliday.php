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







<!-- Content Header (Page header) -->

<div class="main-content-container px-3 pt-1">

    <div class="row">

        <div class="col-md-12">

            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>

        </div>

    </div>

<?php if($_SESSION['loggedIn_type'] !='Mobile'){ ?>

    <div class="row p-0">

        <div class="col column_padding_card">

            <div class="card card-small card_heading_title p-0 m-b-1">

                <div class="card-body p-2">

                    <div class="row c-m-b">

                        <div class="col-lg-4 col-sm-4 col-6">

                            <span class="page-title absent_table_title_mobile">

                                <i class="material-icons">event</i> Holiday Info

                            </span>

                        </div>

                        <div class="text-center col-lg-4 col-sm-3 col-6">

                            <b style="font-size: 20px;">Total Holiday: <?php echo $count_holiday; ?></b>

                        </div>



                        <div class="col-lg-4 col-sm-5 col-12 box-tools">

                            <a onclick="window.history.back();" class="btn btn-secondary border_left_radius mobile-btn float-right text-white pt-2"

                                value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>

                        <?php //if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN) { ?>
                        <?php if($accessInfo->can_add == '1') { ?>

                        <button class="btn btn-md btn-primary mobile-btn float-right mb-1 border_right_radius" data-toggle="modal"

                            data-target="#myModal"><i class="fa fa-plus"></i> Add New</a>

                            <?php } ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <?php } ?>


    <!-- <div class="row form-employee">

        <div class="col-12 column_padding_card">

            <div class="card card-small c-border p-2">

                <form role="form" action="<?php echo base_url(); ?>viewHolidayList" method="POST" id="byFilterMethod">

                    <div class="row">

                        <div class="col-lg-4">

                            <div class="position-relative mb-0">

                                <input class="form-control mobile-width dateBy " value="<?php echo $by_date; ?>"

                                    type="text" name="by_date" id="by_date" value="" class="form-control input-sm"

                                    style="text-transform: uppercase" placeholder="By Date" autocomplete="off">

                            </div>

                        </div>

                        <div class="col-lg-6">

                            <div class="position-relative mb-0">

                                <input class="form-control mobile-width " value="<?php echo $reason; ?>" type="text"

                                    name="reason" id="reason" value="" class="form-control input-sm"

                                    style="text-transform: uppercase" placeholder="By Reason" autocomplete="off">

                            </div>

                        </div>

                        <div class="col-lg-2">

                            <button type="submit" class="btn btn-success btn-block mobile-width">

                                Search</button>

                        </div>

                    </div>

                </form>

                <hr class="mt-1 mb-1">

                <div class="table-responsive-sm">

                    <table class="table table-bordered text-dark">

                        <thead class="text-center">

                            <tr class="table_row_background">

                                <th>Date From</th>

                                <th>Date To</th>

                                <th>Reason</th>

                                <?php if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR) { ?>

                                <th>Students</th>

                                <th>Teaching Staff</th>

                                <th>Non-Teaching staff</th>

                                <th>Support Staff</th>

                                <th>Office Staff</th>

                                <th>Account Staff</th>

                                <?php if($role != ROLE_PRINCIPAL || $role == ROLE_VICE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR){ ?>

                                <th>Action</th>

                                <?php } } ?>

                            </tr>

                            <?php //if(!empty($holidayRecords)){

                                //foreach($holidayRecords as $record){ ?>

                            <tr class="text-dark">

                                <td><?php //echo date('d-m-Y',strtotime($record->holiday_date)); ?></td>

                                <td><?php //if(!empty($record->holiday_date_to)){ echo date('d-m-Y',strtotime($record->holiday_date_to)); } ?>

                                </td>

                                <td><?php //echo $record->reason; ?></td>

                                <?php //if($role == ROLE_ADMIN || $role == ROLE_VICE_PRINCIPAL || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR) { ?>

                                <td><?php

                                // if($record->students_status == 1){

                                //     echo '<i class="material-icons color-green" style="font-size:25px;">check_circle</i>';

                                // }else{

                                //     echo '<i class="material-icons color-red" style="font-size:25px;">highlight_off</i>';

                                // }

                                ?></td>

                                <td><?php

                                // if($record->teaching_staff_status == 1){

                                //     echo '<i class="material-icons color-green" style="font-size:25px;">check_circle</i>';

                                // }else{

                                //     echo '<i class="material-icons color-red" style="font-size:25px;">highlight_off</i>';

                                // }

                                ?></td>

                                <td><?php

                                // if($record->non_teaching_staff_status == 1){

                                //     echo '<i class="material-icons color-green" style="font-size:25px;">check_circle</i>';

                                // }else{

                                //     echo '<i class="material-icons color-red" style="font-size:25px;">highlight_off</i>';

                                // }

                                ?></td>

                                <td><?php

                                // if($record->support_staff_status == 1){

                                //     echo '<i class="material-icons color-green" style="font-size:25px;">check_circle</i>';

                                // }else{

                                //     echo '<i class="material-icons color-red" style="font-size:25px;">highlight_off</i>';

                                // }

                                ?></td>
                                <td><?php
                                // if($record->office_staff_status == 1){
                                //     echo '<i class="material-icons color-green" style="font-size:25px;">check_circle</i>';
                                // }else{
                                //     echo '<i class="material-icons color-red" style="font-size:25px;">highlight_off</i>';
                                // }
                                ?></td>
                                <td><?php
                                // if($record->account_staff_status == 1){
                                //     echo '<i class="material-icons color-green" style="font-size:25px;">check_circle</i>';
                                // }else{
                                //     echo '<i class="material-icons color-red" style="font-size:25px;">highlight_off</i>';
                                // }
                                ?></td>


                                <?php //} if($role == ROLE_ADMIN  || $role == ROLE_VICE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR) { ?>

                                <td>



                                    <a class="btn btn-xs btn-info"

                                        href="<?php //echo base_url().'editHoliday/'.$record->row_id; ?>" title="Edit"><i

                                            class="fas fa-pencil-alt"></i></a>

                                    <a class="btn btn-xs btn-danger deleteHoliday" href="#"

                                        data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i

                                            class="fa fa-trash"></i></a>

                                </td>

                                <?php //} ?>

                            </tr>

                            <?php //} } else { ?>

                            <tr>

                            <td colspan="10" class="text-center card_head_dashboard">Holiday not found</td>

                            </tr>

                            <?php //} ?>

                        </thead>

                    </table>

                </div>

                <div class="row">

                    <div class="col-lg-6 col-md-6 col-sm-12">

                        <?php //echo $this->pagination->create_links(); ?>

                    </div>

                </div>

            </div>

        </div>

    </div> -->

    <div class="row form-employee">
    <div class="col-12 column_padding_card">
        <div class="card card-small c-border p-2">
            <form role="form" action="<?php echo base_url(); ?>viewHolidayList" method="POST" id="byFilterMethod">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="position-relative mb-0">
                            <input class="form-control mobile-width dateBy" value="<?php echo $by_date; ?>"
                                type="text" name="by_date" id="by_date" style="text-transform: uppercase"
                                placeholder="By Date" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="position-relative mb-0">
                            <input class="form-control mobile-width" value="<?php echo $reason; ?>" type="text"
                                name="reason" id="reason" style="text-transform: uppercase" placeholder="By Reason"
                                autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <button type="submit" class="btn btn-success btn-block mobile-width">Search</button>
                    </div>
                </div>
            </form>

            <hr class="mt-1 mb-1">

            <div class="table-responsive-sm">
                <table class="table table-bordered text-dark">
                    <thead class="text-center">
                        <tr class="table_row_background">
                            <th width="100">Date From</th>
                            <th width="100">Date To</th>
                            <th width="100">Reason</th>
                            <?php //if($role == ROLE_ADMIN  || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN) { ?>
                            <?php if($accessInfo->super_access == '1') { ?>

                            <th width="100">Students</th>
                            <th>Roles</th>
                            <?php } ?>

                            <?php //if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN) { ?>
                            <?php if($accessInfo->super_access == '1') { ?>
                                <th>Action</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($holidayRecords)){
                            foreach($holidayRecords as $record){ ?>
                            <tr class="text-dark">
                                <td><?php echo date('d-m-Y',strtotime($record->holiday_date)); ?></td>
                                <td><?php if(!empty($record->holiday_date_to)){ echo date('d-m-Y',strtotime($record->holiday_date_to)); } ?></td>
                                <td><?php echo $record->reason; ?></td>
                                <?php //if($role == ROLE_ADMIN  || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN) { ?>
                                <?php if($accessInfo->super_access == '1') { ?>
                                <td><?php

                                    if($record->students_status == 1){

                                        echo '<i class="material-icons color-green" style="font-size:25px;">check_circle</i>';

                                    }else{

                                        echo '<i class="material-icons color-red" style="font-size:25px;">highlight_off</i>';

                                    }

                                ?></td>

                                <td>
                                    <?php
                                        // Decode the role_status to display the affected roles
                                        $affectedRoles = explode(',', $record->role_status);
                                        foreach($affectedRoles as $roleId) {
                                            $roleName = $holiday_model->getRoleNameById($roleId); // You need to implement this function to get the role name by its ID
                                            echo '<span class="badge badge-primary" style="font-size:10px;">' . strtoupper($roleName) . '</span> ';
                                        }
                                    ?>
                                </td>
                                <?php } ?>

                                <?php //if($role == ROLE_ADMIN  || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN) { ?>
                                <?php if($accessInfo->super_access == '1') { ?>
                                <td>
                                    <a class="btn btn-xs btn-info" href="<?php echo base_url().'editHoliday/'.$record->row_id; ?>" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                    <a class="btn btn-xs btn-danger deleteHoliday" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                </td>
                                <?php } ?>
                            </tr>
                        <?php } } else { ?>
                        <tr>
                            <td colspan="10" class="text-center card_head_dashboard">Holiday not found</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div>
</div>




</div>


<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Add New Holiday</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" action="<?php echo base_url().'addNewHoliday'?>">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="fromDateFrom">Holiday Date From</label>
                                <input name="fromDateFrom" type="text" class="holidayDateFrom form-control" id="fromDateFrom"
                                       placeholder="Select Holiday Date From" required autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="fromDateTo">Holiday Date To</label>
                                <input name="fromDateTo" type="text" class="holidayDateTo form-control" id="fromDateTo"
                                       placeholder="Select Holiday Date To" required autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="reason">Reason</label>
                                <textarea name="reason" class="form-control" id="reason" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="1" class="custom-control-input" id="all" name="all">
                                <label class="custom-control-label" for="all">ALL</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="1" class="custom-control-input" id="only_students" name="only_students">
                                <label class="custom-control-label" for="only_students">Only Students</label>
                            </div>
                            <label>Holiday By Roles:</label>
                            <select multiple class="form-control selectpicker" data-live-search="true" id="roleSelect" name="role_ids[]">
                                <option value="ALL">ALL</option>
                                <?php foreach($designation as $role): ?>
                                    <option value="<?= $role->roleId ?>"><?= strtoupper($role->role) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>

<script type="text/javascript">

jQuery(document).ready(function() {



    //$('select').selectpicker();

    jQuery('.holidayDateFrom,.holidayDateTo,.dateBy').datepicker({

        autoclose: true,

        format: "dd-mm-yyyy",



    });



    jQuery('ul.pagination li a').click(function(e) {

        e.preventDefault();

        var link = jQuery(this).get(0).href;

        var value = link.substring(link.lastIndexOf('/') + 1);

        jQuery("#byFilterMethod").attr("action", baseURL + "overallStudentAttendance/" + value);

        jQuery("#byFilterMethod").submit();

    });

});

</script>