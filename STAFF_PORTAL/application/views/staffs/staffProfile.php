<?php
if(!empty($staffInfo)){
  $row_id = $staffInfo->row_id;
  $staff_id = $staffInfo->staff_id;
  $staff_name = $staffInfo->name;
  $date_of_birth = $staffInfo->dob;
  $email = $staffInfo->email;
  $profileImg = $staffInfo->photo_url;
}else{
    $staff_name = "Not Found! ";
}
if(empty($dob) || $date_of_birth == '0000-00-00'){
    $date_of_birth = '<span class="text-danger">Not Updated</span>';
} else {
    $date_of_birth = date('d-m-Y',strtotime($date_of_birth));
}
?>


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
<div class="main-content-container container-fluid px-4">

    <!-- Content Header (Page header) -->
    <section class="content-header pt-1">
        <div class="row">
            <div class="col-12">
                <div class="card card-small p-0 card_heading_title">
                    <div class="card-body p-2 ml-2">
                        <span class="page-title">
                            <i class="fa fa-user-circle"></i> <?php echo $staff_name; ?> Profile
                        </span>
                        <a onclick="showLoader();window.history.back();" class="btn primary_color float-right text-white pt-2"
                            value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if(empty($staffInfo)){ ?>
    <div class="row form-employee">
        <div class="col-lg-12 col-md-12 col-12 pr-0 text-center">
        <img height="270" src="<?php echo base_url(); ?>assets/images/404.png"/>
        </div>
    </div>
    <?php } else {  ?>
    <div class="row form-employee">
        <div class="col-lg-4 col-md-3 col-sm-3 ">
            <div class="card card-small c-border mb-4 p-1">
                <div class="card-header text-center profile-img">
                    <?php if(!empty($profileImg)){ ?>
                    <img src="<?php echo $profileImg; ?>" class="avatar rounded-circle img-thumbnail" width="130"
                        height="130" alt="Profile Image">
                    <?php } else { ?>
                    <img src="<?php echo base_url(); ?>assets/images/user.png"
                        class="avatar rounded-circle img-thumbnail" width="130" height="130" src="#" id="uploadedImage"
                        name="userfile" width="130" height="130" alt="Profile default">
                    <?php } ?>

                </div>
                <div class="card-body profile_sidebar pt-0 pl-0 pr-0 mt-1">
                    <table class="table profile_table mb-0">
                        <tbody>
                            <tr>
                                <th><i class="fa fa-id-card"></i> ID<span class="float-right">:</span></th>
                                <td><?php echo $staffInfo->staff_id; ?></td>
                            </tr>
                            <tr>
                                <th><i class="far fa-calendar-alt"></i> DOB<span class="float-right">:</span></th>
                                <td><?php echo $staffInfo->dob; ?></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-mobile-alt"></i> MOB.<span class="float-right">:</span></th>
                                <td>
                                    <?php if(empty($staffInfo->mobile)){ 
                                        echo '<span class="text-danger">Not Updated</span>';
                                    } else{ 
                                        echo $staffInfo->mobile;
                                    } ?>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-envelope"></i> EMAIL<span class="float-right">:</span></th>
                                <td>
                                    <?php if(empty($staffInfo->email)){ 
                                        echo '<span class="text-danger">Not Updated</span>';
                                    } else{ 
                                        echo $staffInfo->email;
                                    } ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <hr class="mt-1 mb-1">
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-9">
            <div class="card card-small c-border mb-4">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item p-2">
                        <div class="row">
                            <div class="col profile-head">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile"
                                            role="tab" aria-controls="profile" aria-selected="false">Personal</a>
                                    </li>
                                    <?php if($role == ROLE_ADMIN){ ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="password-tab" data-toggle="tab" href="#changePassword"
                                            role="tab" aria-controls="password" aria-selected="false">Change
                                            Password</a>
                                    </li>
                                    <?php } ?>
                                </ul>
                                <div class="tab-content profile-tab" id="myTabContent">
                                    <div class="tab-pane fade show active" id="profile" role="tabpanel"
                                        aria-labelledby="profile-tab">
                                        <table class="table profile_table">
                                            <tbody>
                                                <tr>
                                                    <th>Name<span class="float-right">:</span></th>
                                                    <td><?php echo $staff_name; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Designation<span class="float-right">:</span> </th>
                                                    <td><?php  if(empty($staffInfo->role)){
                                                        echo '<span class="text-danger">Not Updated</span>';
                                                    } else{
                                                        echo $staffInfo->role;
                                                    } ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Department<span class="float-right">:</span> </th>
                                                    <td><?php  if(empty($staffInfo->department)){
                                                        echo '<span class="text-danger">Not Updated</span>';
                                                    } else{
                                                        echo $staffInfo->department;
                                                    } ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Gender<span class="float-right">:</span> </th>
                                                    <td><?php  if(empty($staffInfo->gender)){
                                                        echo '<span class="text-danger">Not Updated</span>';
                                                    } else{
                                                        echo strtoupper($staffInfo->gender);
                                                    } ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Date of Join<span class="float-right">:</span> </th>
                                                    <td><?php  if($staffInfo->doj == '0000-00-00'){
                                                        echo '<span class="text-danger">Not Updated</span>';
                                                    } else{
                                                        echo date('d-m-Y',strtotime($staffInfo->doj));
                                                    } ?></td>
                                                </tr>
                                                <!-- <tr>
                                                    <th>Blood Group<span class="float-right">:</span> </th>
                                                    <td><?php  if(empty($staffInfo->blood_group)){
                                                        echo '<span class="text-danger">Not Updated</span>';
                                                    } else{
                                                        echo $staffInfo->blood_group;
                                                    } ?></td>
                                                </tr> -->
                                                <tr>
                                                    <th>Address<span class="float-right">:</span></th>
                                                    <td><?php  if(empty($staffInfo->address)){
                                                        echo '<span class="text-danger">Not Updated</span>';
                                                    } else{
                                                        echo $staffInfo->address;
                                                    } ?></td>
                                                </tr>
                                                <!-- <tr>
                                                    <th>Mobile Two<span class="float-right">:</span></th>
                                                    <td><?php  if(empty($staffInfo->mobile_two)){
                                                        echo '<span class="text-danger">Not Updated</span>';
                                                    } else{
                                                        echo $staffInfo->mobile_two;
                                                    } ?></td>
                                                </tr> -->
                                                <tr>
                                                    <th>Aadhar No.<span class="float-right">:</span></th>
                                                    <td><?php  if(empty($staffInfo->aadhar_no)){
                                                        echo '<span class="text-danger">Not Updated</span>';
                                                    } else{
                                                        echo $staffInfo->aadhar_no;
                                                    } ?></td>
                                                </tr>
                                                <tr>
                                                    <th>PAN Number<span class="float-right">:</span></th>
                                                    <td><?php  if(empty($staffInfo->pan_no)){
                                                        echo '<span class="text-danger">Not Updated</span>';
                                                    } else{
                                                        echo $staffInfo->pan_no;
                                                    } ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Voter ID<span class="float-right">:</span></th>
                                                    <td><?php  if(empty($staffInfo->voter_no)){
                                                        echo '<span class="text-danger">Not Updated</span>';
                                                    } else{
                                                        echo $staffInfo->voter_no;
                                                    } ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php if($role == ROLE_ADMIN){ ?>
                                    <div class="<?= ($active == "changepass")? "active" : "" ?> tab-pane fade mx-auto"
                                        id="changePassword" role="tabpanel" aria-labelledby="password-tab">
                                        <form role="form" method="post"
                                            action="<?php echo base_url().'changePasswordAdmin/'.$staffInfo->row_id; ?>">
                                            <div class="input-group mb-2 profile_changePassword">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text material-icons">lock</span>
                                                </div>
                                                <input type="password" class="form-control" placeholder="New Password"
                                                    id="password" name="newPassword" autocomplete="off" required />
                                            </div>
                                            <div class="input-group mb-2 profile_changePassword">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text material-icons">lock</span>
                                                </div>
                                                <input type="password" class="form-control equalTo"
                                                    placeholder="Re-Type Password" id="cNewPassword" name="cNewPassword"
                                                    autocomplete="off" required />
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary ">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                    </li>
                </ul>



            </div>
        </div>
    </div>

    <?php } ?>

</div>