<?php
if(!empty($studentInfo)){
  $row_id = $studentInfo->row_id;
  $student_id = $studentInfo->student_id;
  $student_name = $studentInfo->student_name;
  $dob = $studentInfo->dob;
  $email = $studentInfo->email;
  $mobile = $studentInfo->mobile;
  $term_name = $studentInfo->term_name;
  $section_name = $studentInfo->section_name;
  $stream_name = $studentInfo->stream_name;
  $program_name = $studentInfo->program_name;
  $application_number = $studentInfo->application_number;
  $date_of_admission = $studentInfo->date_of_admission;
  $elective_sub = $studentInfo->elective_sub;
  $tc_taken_status = $studentInfo->tc_taken_status;
  $nationality = $studentInfo->nationality;
  $caste = $studentInfo->caste;
  $religion = $studentInfo->religion;
  $mother_tongue = $studentInfo->mother_tongue;
  $blood_group = $studentInfo->blood_group;
  $father_name = $studentInfo->father_name;
  $mother_name = $studentInfo->mother_name;
  $father_mobile = $studentInfo->father_mobile;
  $father_email = $studentInfo->father_email;
  $father_educational_qualification = $studentInfo->father_educational_qualification;
  $mother_mobile = $studentInfo->mother_mobile;
  $mother_email = $studentInfo->mother_email;
  $mother_educational_qualification = $studentInfo->mother_educational_qualification;
  $father_age = $studentInfo->father_age;
  $mother_age = $studentInfo->mother_age;
  $father_profession = $studentInfo->father_profession;
  $mother_profession = $studentInfo->mother_profession;
  $aadhar_no = $studentInfo->aadhar_no;
  $present_address = $studentInfo->present_address;
  $residential_address = $studentInfo->residential_address;
  $guardian_name = $studentInfo->guardian_name;
  $guardian_mobile = $studentInfo->guardian_mobile;
  $guardian_address = $studentInfo->guardian_address;
  $is_physically_challenged = $studentInfo->is_physically_challenged;
  $is_dyslexic = $studentInfo->is_dyslexic;
  $last_board_name = $studentInfo->last_board_name;
  $last_percentage = $studentInfo->last_percentage;
}
  $date_of_birth = date("d-m-Y", strtotime($dob));
if(!empty($date_of_admission)){
  $admission_date = date("d-m-Y", strtotime($date_of_admission));
}else{
  $admission_date = "";
}
?>

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
              <span class="page-title">
                <i class="fa fa-user-circle"></i> My Profile
              </span>
            <a onclick="showLoader();window.history.back();" class="btn btn-primary float-right text-white pt-2" value="Back" >Back </a>
            </div>
          </div>
        </div>
      </div>
  </section>
  <div class="row form-employee">
    <div class="col-lg-3 col-md-3 col-sm-3 pr-0 padding_left_right_null">
      <div class="card card-small c-border mb-4 p-1">
        <div class="card-header text-center profile-img">
          <img  src="http://sjpuchassan.schoolphins.com/assets/images/PHOTOS_19_21_ALL/<?php echo $student_id; ?>.png"  class="avatar rounded-circle img-thumbnail" width="130" height="130" alt="User Image" >  
        </div>
        <div class="card-body text-center profile_sidebar pt-0 pl-0 pr-0 mt-1">
          <div class="p-1">
            <i class="fa fa-id-card"></i>
            <span style="color: #1e64b9;"><?php echo $student_id?></span>
          </div><hr class="mt-1 mb-1">
          <div class="p-1">
            <i class="far fa-calendar-alt"></i>
            <span> <?php echo $date_of_birth?></span>
          </div><hr class="mt-1 mb-1">
          <div class="p-1">
            <i class="fas fa-mobile-alt"></i>
              <?php if($mobile == ""){ ?>
              <span class="text-danger">Not Updated</span>
              <?php } else { ?>
              <span> <?php echo $mobile?></span>
              <?php } ?>
          </div><hr class="mt-1 mb-1">
          <div class="p-1">
            <i class="fas fa-envelope"></i>
            <span> <?php echo $email?></span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-9 col-sm-9 padding_left_right_null">
      <div class="card card-small c-border mb-4">
        <ul class="list-group list-group-flush">
          <li class="list-group-item p-3">
            <div class="row">
              <div class="col profile-head">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Personal</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="family-tab" data-toggle="tab" href="#family" role="tab" aria-controls="family" aria-selected="true">Family</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Academic</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="password-tab" data-toggle="tab" href="#changePassword" role="tab" aria-controls="password" aria-selected="false">Change Password</a>
                  </li>
                </ul>
                <div class="tab-content profile-tab" id="myTabContent">
                  <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <table class="table profile_table">
                      <tbody>
                        <tr>
                          <th>Name<span class="float-right">:</span></th>
                          <td><?php echo $student_name?></td>
                        </tr>      
                        <tr>
                          <th>Blood Group<span class="float-right">:</span> </th>
                          <td><?php echo $blood_group?></td>
                        </tr>  
                        <tr>
                          <th>Nationality<span class="float-right">:</span></th>
                          <td><?php echo $nationality?></td>
                        </tr>  
                        <tr>
                          <th>Caste<span class="float-right">:</span></th>
                          <td><?php echo $caste?></td>
                        </tr>  
                        <tr>
                          <th>Religion<span class="float-right">:</span></th>
                          <td><?php echo $religion?></td>
                        </tr>  
                        <tr>
                          <th>Mother Tongue<span class="float-right">:</span></th>
                          <td><?php echo $mother_tongue?></td>
                        </tr>  
                        <tr>
                          <th width="190">Physically Challenged<span class="float-right">:</span></th>
                          <td><?php echo $is_physically_challenged?></td>
                        </tr>
                        <tr>
                          <th>Dyslexic<span class="float-right">:</span></th>
                          <td><?php echo $is_dyslexic?></td>
                        </tr>
                        <tr>
                          <th>Presesnt Address<span class="float-right">:</span></th>
                          <td><?php echo $present_address?></td>
                        </tr>
                        <tr>
                          <th>Permanent Address<span class="float-right">:</span></th>
                          <td><?php echo $residential_address?></td>
                        </tr>
                      </tbody>
                    </table>    
                  </div>
                  <div class="tab-pane fade" id="family" role="tabpanel" aria-labelledby="family-tab">
                    <table class="table profile_table">
                      <tbody>
                        <tr>
                          <th>Father's Name<span class="float-right">:</span></th>
                          <td><?php echo $father_name?></td>
                        </tr>      
                        <tr>
                          <th>Mother's Name<span class="float-right">:</span></th>
                          <td><?php echo $mother_name?></td>
                        </tr>  
                        <tr>
                          <th>Father's Age<span class="float-right">:</span></th>
                          <td><?php echo $father_age?></td>
                        </tr>  
                        <tr>
                          <th>Mother's Age<span class="float-right">:</span></th>
                          <td><?php echo $mother_age?></td>
                        </tr>  
                        <tr>
                          <th width="290">Father's Educational Qualification<span class="float-right">:</span></th>
                          <td><?php echo $father_educational_qualification?></td>
                        </tr>  
                        <tr>
                          <th>Mother's Educational Qualification<span class="float-right">:</span></th>
                          <td><?php echo $mother_educational_qualification?></td>
                        </tr>  
                        <tr>
                          <th>Father's Profession<span class="float-right">:</span></th>
                            <?php if($father_profession == ""){ ?>
                            <td class="text-danger">Not Updated</td>
                            <?php } else { ?>
                            <td><?php echo $father_profession?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                          <th>Mother's Profession<span class="float-right">:</span></th>
                            <?php if($mother_profession == ""){ ?>
                            <td class="text-danger">Not Updated</td>
                            <?php } else { ?>
                            <td><?php echo $mother_profession?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                          <th>Father's Mobile No.<span class="float-right">:</span></th>
                            <?php if($father_mobile == ""){ ?>
                            <td class="text-danger">Not Updated</td>
                            <?php } else { ?>
                            <td><?php echo $father_mobile?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                          <th>Mother's Mobile No.<span class="float-right">:</span></th>
                            <?php if($mother_mobile == ""){ ?>
                            <td class="text-danger">Not Updated</td>
                            <?php } else { ?>
                            <td><?php echo $mother_mobile?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                          <th>Father's Email ID<span class="float-right">:</span></th>
                            <?php if($father_email == ""){ ?>
                            <td class="text-danger">Not Updated</td>
                            <?php } else { ?>
                            <td><?php echo strtolower($father_email)?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                          <th>Mother's Email ID<span class="float-right">:</span></th>
                            <?php if($mother_email == ""){ ?>
                            <td class="text-danger">Not Updated</td>
                            <?php } else { ?>
                            <td><?php echo strtolower($mother_email)?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                          <th>Guardian's Name<span class="float-right">:</span></th>
                          <td><?php echo $guardian_name?></td>
                        </tr>
                        <tr>
                          <th>Guardian's Mobile No.<span class="float-right">:</span></th>
                          <td><?php echo $guardian_mobile?></td>
                        </tr>
                        <tr>
                          <th>Guardian's Address<span class="float-right">:</span></th>
                          <td><?php echo $guardian_address?></td>
                        </tr>
                      </tbody>
                    </table>  
                  </div>
                  <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <table class="table profile_table">
                      <tbody>
                        <tr>
                          <th>Application No.<span class="float-right">:</span></th>
                          <td><?php echo $application_number?></td>
                        </tr>      
                        <tr>
                          <th>Date of Admission<span class="float-right">:</span></th>
                          <td><?php echo $admission_date?></td>
                        </tr>  
                        <tr>
                          <th>Term & Stream<span class="float-right">:</span></th>
                          <td><?php echo $term_name?> <?php echo $stream_name?></td>
                        </tr>  
                        <tr>
                          <th>Section<span class="float-right">:</span></th>
                          <td><?php echo $section_name?></td>
                        </tr>  
                        <tr>
                          <th>Program<span class="float-right">:</span></th>
                          <td><?php echo $program_name?></td>
                        </tr>  
                        <tr>
                          <th>Elective Subject<span class="float-right">:</span></th>
                          <td><?php echo $elective_sub?></td>
                        </tr>
                        <tr>
                          <th width="200">Last Board Name<span class="float-right">:</span></th>
                          <td><?php echo $last_board_name?></td>
                        </tr>
                        <tr>
                          <th>Last Board Percentage<span class="float-right">:</span></th>
                          <td><?php echo $last_percentage?></td>
                        </tr>
                        <tr>
                          <th>TC Taken Status<span class="float-right">:</span></th>
                            <?php if($tc_taken_status == 0){ ?>
                            <td style="color: red;">Not Collected</td>
                            <?php } else { ?>
                            <td class="text-success"> Collected</td>
                            <?php } ?>
                        </tr>
                      </tbody>
                    </table> 
                  </div>
                  <div class="<?= ($active == "changepass")? "active" : "" ?> tab-pane fade mx-auto" id="changePassword" role="tabpanel" aria-labelledby="password-tab">
                    <form role="form" method="post" action="<?php echo base_url() ?>changePassword">
                      <div class="input-group mb-2 profile_changePassword">
                        <div class="input-group-prepend">
                          <span class="input-group-text material-icons">lock</span>
                        </div>
                        <input type="password" class="form-control" placeholder="Old password" id="oldPassword" name="oldPassword" autocomplete="off" required/>
                      </div>
                      <div class="input-group mb-2 profile_changePassword">
                        <div class="input-group-prepend">
                          <span class="input-group-text material-icons">lock</span>
                        </div>
                        <input type="password" class="form-control" placeholder="New Password" id="password" name="password" autocomplete="off" required/>
                      </div>
                      <div class="input-group mb-2 profile_changePassword">
                        <div class="input-group-prepend">
                          <span class="input-group-text material-icons">lock</span>
                        </div>
                        <input type="password" class="form-control equalTo" placeholder="Re-Type Password" id="cpassword" name="cpassword" autocomplete="off" required/>
                      </div>
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary ">Update</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <p class="note_profile mb-0">Note: For any queries contact college office</p>
          </li>
        </ul>
      </div>
    </div>
        </div>  
</div>
<script>
$(function() {
            $(this).bind("contextmenu", function(e) {
                e.preventDefault();
            });
        }); 
</script>