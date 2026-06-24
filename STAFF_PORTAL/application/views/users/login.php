<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Schoolphins-SJPUC | Student/Parent Log in</title>
    <!-- icons -->
    <link rel="icon" href="<?php echo INSTITUTION_LOGO ?>"> 
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.0.0" href="<?php echo base_url(); ?>assets/dist/styles/shards-dashboards.1.0.0.min.css">
    <link rel="stylesheet" href="styles/extras.1.0.0.min.css">
    <link href="<?php echo base_url(); ?>assets/dist/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";
    </script>
  </head>
  <body class="hold-transition login-page">
      <div class="row margin_left_right_null">
        <div class="card mx-auto login_card">
          <div class="card-header pb-0">
            <div class="col-xs-12">
              <h6><b>Sign In</b></h6>
            </div>
          </div>
          <div class="card-body">
            <div class="col-xs-12 text-center">
              <img src="<?php echo INSTITUTION_LOGO ?>" height="80px">
            </div>
            <div class="col-xs-12 mb-2">
              <span><b style="font-size: 25px;"><span class="title_green">School</span><span class="title_blue">phins</span> - <span class="title_blue">SJPUC</span></b></span>
            </div>
            <?php $this->load->helper('form'); ?>
            <div class="row">
                <div class="col-md-12">
                    <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                </div>
            </div>
              <?php
              $this->load->helper('form');
              $error = $this->session->flashdata('error');
              if($error)
              { ?>
                  <div class="alert alert-danger alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <?php echo $error; ?>                    
                  </div>
              <?php }
              $success = $this->session->flashdata('success');
              if($success){
                  ?>
                  <div class="alert alert-success alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <?php echo $success; ?>                    
                  </div>
              <?php } ?>
            <form action="<?php echo base_url(); ?>loginMe" method="post" id="login">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text material-icons text-dark">person</span>
                </div>
                <input type="text" class="form-control input_type" placeholder="Username (Student ID)" name="username" autocomplete="off" required/>
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text material-icons text-dark">lock</span>
                </div>
                <input type="password" class="form-control input_type" placeholder="Password" name="password" autocomplete="off" required/>
              </div>
              <button type="submit" class="btn btn-log btn-block">Sign In</button>
              <a href="<?php echo base_url() ?>userRegistration" class="btn btn_submit btn-block" value="Registration" style="margin-top:10px;">New Registration</a>
            </form>
            <div class="row">
                <div class="col-sm-6 col-md-6">
                  <a target="_blank" href="<?php echo base_url() ?>assets/downloads/student_sjpuch_UserGuide.pdf" class="float-left" style="margin-top: 10px;">Click here to help <i class="far fa-question-circle"></i></a><br>
                </div>
                <div class="col-sm-6 col-md-6">
                  <a class="float-right" style="margin-top: 10px;" href="<?php echo base_url() ?>forgotPassword">Forgot Password</a>
              </div>
              </div>
          </div>
          <div class="card-footer">
            <div class="col-xs-12 text-center">
              <span class="">&copy;<script>document.write(new Date().getFullYear())</script>-20 <a href="http://schoolphins.com/" target="_blank"><span class="title_green">School</span><span class="title_blue">phins</span></a> The Wings of an Education.</span>
            </div>
          </div>
        </div>
      </div>
  </body>
</html>
    <!-- <script src="<?php echo base_url(); ?>assets/js/login/login.js" type="text/javascript"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.9.0/additional-methods.js" integrity="sha256-PxEJjwsgsA8v2qW3s/uSv5J00Yw6DQozL54XRIHcGmY=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
    <script src="<?php echo base_url(); ?>scripts/extras.1.0.0.min.js"></script>
    <script src="<?php echo base_url(); ?>scripts/shards-dashboards.1.0.0.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/validation.js" type="text/javascript"></script>
    <script>

$(function() {
            $(this).bind("contextmenu", function(e) {
                e.preventDefault();
            });
        }); 
        </script>