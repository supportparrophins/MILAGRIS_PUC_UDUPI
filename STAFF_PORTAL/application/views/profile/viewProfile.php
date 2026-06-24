<?php
if(!empty($staffInfo)){
  $row_id = $staffInfo->row_id;
  $staff_id = $staffInfo->staff_id;
  $staff_name = $staffInfo->name;
  $date_of_birth = $staffInfo->dob;
  $email = $staffInfo->email;
  $mobile = $staffInfo->mobile;
  $profileImg = $staffInfo->photo_url;
}


if(empty($dob) || $date_of_birth == '0000-00-00'){
    $date_of_birth = '<span class="text-danger">Not Updated</span>';
} else {
    $date_of_birth = date('d-m-Y',strtotime($date_of_birth));
}
?>
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



<div class="main-content-container px-3">
    <div class="row">
        <div class="col-md-12">
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
        </div>
    </div>
    <!-- Content Header (Page header) -->
    <section class="content-header pt-1">
        <div class="row">
            <div class="col padding_left_right_null">
                <div class="card card-small p-0 card_heading_title">
                    <div class="card-body p-2 ml-2">
                        <span class="page-title">
                            <i class="fa fa-user-circle"></i> My Profile
                        </span>
                        <a onclick="showLoader();window.history.back();" class="btn primary_color float-right text-white pt-2"
                            value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="row form-employee">
        <div class="col-lg-3 col-md-3 col-sm-3 pr-0 padding_left_right_null">
            <form role="form" action="<?php echo base_url() ?>updateProfileImage" method="post"
            enctype="multipart/form-data">
            <input type="hidden" value="<?php echo $staffInfo->row_id; ?>" id="row_id" name="row_id">
            <div class="card card-small c-border mb-4 p-1">
                <div class="card-header text-center ">
                    <?php if(!empty($profileImg)){ ?>
                            <img src="<?php echo $profileImg; ?>" class="avatar rounded-circle img-thumbnail"
                                width="130" height="130" alt="Profile Image" id="uploadedImage">
                            <?php } else { ?>
                            <img src="<?php echo base_url(); ?>assets/images/user.png" class="avatar rounded-circle img-thumbnail"
                                width="130" height="130" id="uploadedImage" alt="Profile default">
                        <?php } ?>
                    <div class="profileImg">
                        <div class="file btn btn-sm btn-primary">
                            Change
                            <input type="file" class="form-control-sm" id="vImg" name="userfile">
                        </div>
                    </div>
                    <span class="text-danger">(The Image maximum size is 2MB)</span>
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
                <button type="submit" class="btn btn-success ">Update</button>
            </div>
            </form>
        </div>
        <div class="col-lg-9 col-sm-9 padding_left_right_null">
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
                                    <!-- <li class="nav-item">
                                        <a class="nav-link" id="password-tab" data-toggle="tab" href="#changePassword"
                                            role="tab" aria-controls="password" aria-selected="false">Change
                                            Password</a>
                                    </li> -->
                                </ul>
                                <div class="tab-content profile-tab" id="myTabContent">
                                    <div class="tab-pane fade show active" id="profile" role="tabpanel"
                                        aria-labelledby="profile-tab">
                                        <table class="table profile_table mb-0">
                                            <tbody>
                                                <tr>
                                                    <th>Name<span class="float-right">:</span></th>
                                                    <td><?php echo $staff_name; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Role<span class="float-right">:</span> </th>
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
                                                    <td><?php  if(empty($staffInfo->doj) || $staffInfo->doj == "0000-00-00"){
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
                                                    <td><?php echo $staffInfo->address; ?></td>
                                                </tr>



                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade mx-auto" id="changePassword" role="tabpanel"
                                        aria-labelledby="password-tab">
                                        <form role="form" method="post"
                                            action="<?php echo base_url().'changePassword'; ?>">
                                            <div class="input-group mb-2 profile_changePassword">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text material-icons">lock</span>
                                                </div>
                                                <input type="password" class="form-control" placeholder="Old password"
                                                    id="oldPassword" name="oldPassword" autocomplete="off" required />
                                            </div>
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
                                                <button type="submit" class="btn btn-success ">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
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
</script>