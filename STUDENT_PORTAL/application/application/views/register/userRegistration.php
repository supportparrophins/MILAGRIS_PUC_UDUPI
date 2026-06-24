<!DOCTYPE html>


<html>


    <head>


      <meta charset="UTF-8">


      <title>Schoolphins - SJPUCH : New Registration</title>


      <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>


      <!-- icons -->


      


      <link rel="icon" href="<?php echo base_url(); ?>assets/dist/img/dolphin_logo.png"> 


        <link rel="apple-touch-icon" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">


        <link rel="apple-touch-icon" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">


        <link rel="apple-touch-icon" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">


        <link rel="apple-touch-icon" sizes="57x57" href="images/ico/apple-touch-icon-57-precomposed.png">


        


        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">


        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


        <link rel="stylesheet" id="main-stylesheet" data-version="1.0.0" href="<?php echo base_url(); ?>assets/dist/styles/shards-dashboards.1.0.0.min.css">


        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/styles/extras.1.0.0.min.css">


      


        <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />


        <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>


        <link href="<?php echo base_url(); ?>assets/dist/css/style.css" rel="stylesheet" type="text/css" />


        <!-- FontAwesome 4.3.0 -->


        <link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />


        


        <script type="text/javascript">


        var baseURL = "<?php echo base_url(); ?>";


        </script>


    </head>


    <body class="login-page">


      <div class="row margin_left_right_null">


        <div class="card mx-auto registration_card">


          <div class="card-header pb-0">


            <div class="col-xs-12 text-center">


              <h6><b>Student Registration</b></h6>


            </div>


          </div>


          <div class="card-body">


            <div class="col-xs-12 text-center">


              <img src="<?php echo base_url(); ?>assets/dist/img/logoSJPUCH.jpg" height="80px">


            </div>


            <div class="col-xs-12 text-center mb-2">


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


            $warning = $this->session->flashdata('warning');


            $error = $this->session->flashdata('error');


            $send = $this->session->flashdata('send');


            $notsend = $this->session->flashdata('notsend');


            $unable = $this->session->flashdata('unable');


            $invalid = $this->session->flashdata('invalid');


            if($warning)


            {


                ?>


                <div class="alert alert-warning alert-dismissable">


                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>


                    <?php echo $this->session->flashdata('warning'); ?>                    


                </div>


            <?php }


            else if($error)


            {


                ?>


                <div class="alert alert-danger alert-dismissable">


                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>


                    <?php echo $this->session->flashdata('error'); ?>                    


                </div>


            <?php }





            if($send)


            {


                ?>


                <div class="alert alert-success alert-dismissable">


                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>


                    <?php echo $send; ?>                    


                </div>


            <?php }





            if($notsend)


            {


                ?>


                <div class="alert alert-danger alert-dismissable">


                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>


                    <?php echo $notsend; ?>                    


                </div>


            <?php }


            


            if($unable)


            {


                ?>


                <div class="alert alert-danger alert-dismissable">


                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>


                    <?php echo $unable; ?>                    


                </div>


            <?php }





            if($invalid)


            {


                ?>


                <div class="alert alert-warning alert-dismissable">


                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>


                    <?php echo $invalid; ?>                     


                </div>


            <?php } ?>


            <form action="<?php echo base_url(); ?>userRegisterDB" method="post" id="newUserRegistration">


      


            <div class="form-group">


                <label class="regiter_label">Student ID</label>


                <div class="input-group mb-3">


                  <div class="input-group-prepend">


                    <span class="input-group-text material-icons text-dark">person</span>


                  </div>


                  <input type="text" style="text-transform: uppercase;" class="text-capitalize form-control required" placeholder="Student ID" id="student_id" name="student_id" autocomplete="off" required/>


                </div>


              </div>


            


              <div class="form-group">


                <label class="regiter_label">Date of Birth</label>


                <div class="input-group mb-3">


                  <div class="input-group-prepend">


                    <span class="input-group-text material-icons text-dark">date_range</span>


                  </div>


                  <input type="text" class="form-control required datepicker" placeholder="Date of Birth" id="dob" name="dob" autocomplete="off" required/>


                </div>


              </div>


              <div class="form-group">


                <label class="regiter_label">Password</label>


                <div class="input-group mb-3">


                  <div class="input-group-prepend">


                    <span class="input-group-text material-icons text-dark">lock</span>


                  </div>


                  <input type="password" class="form-control required" placeholder="New Password" id="password" name="password" onkeyup="checkPass(); return false;" autocomplete="off"/>


                </div>


              </div>


              <div class="form-group">


                <label class="regiter_label">Confirm Password</label>


                <div class="input-group mb-3">


                  <div class="input-group-prepend">


                    <span class="input-group-text material-icons text-dark">lock</span>


                  </div>


                  <input type="password" class="form-control required equalTo" placeholder="Re-Type Password" id="cpassword" name="cpassword"  autocomplete="off" required/>


                </div>


              </div>


              <div class="row">


                <div class="col-sm-6  col-md-12">


                  <input type="submit" class="btn btn_submit btn-block" value="Register" />


                </div>


              </div>


              <div class="row">


              <div class="col-sm-6 col-md-6">


                  <a target="_blank" href="<?php echo base_url() ?>assets/downloads/student_SJPUC_UserGuide.pdf" class="float-left" style="margin-top: 10px;">Click here to help <i class="far fa-question-circle"></i></a><br>


                </div>


                <div class="col-sm-6 col-md-6">


                  <a href="<?php echo base_url() ?>" class="float-right" style="margin-top: 10px;">Back to Login</a><br>


                </div>


            </div>


            </form>


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


    <script src="<?php echo base_url(); ?>assets/js/forgotPassword.js" type="text/javascript"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.9.0/additional-methods.js" integrity="sha256-PxEJjwsgsA8v2qW3s/uSv5J00Yw6DQozL54XRIHcGmY=" crossorigin="anonymous"></script>


    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>


    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    <script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>


    <script src="<?php echo base_url(); ?>assets/dist/scripts/extras.1.0.0.min.js"></script>


    <script src="<?php echo base_url(); ?>assets/dist/scripts/shards-dashboards.1.0.0.min.js"></script>


    <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js" type="text/javascript"></script>


    <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js" type="text/javascript"></script>


    <script src="<?php echo base_url(); ?>assets/js/validation.js" type="text/javascript"></script>


<script>


jQuery(document).ready(function(){


  jQuery('.datepicker').datepicker({


    autoclose: true,


    format : "dd-mm-yyyy"


  });


});





$(function() {


            $(this).bind("contextmenu", function(e) {


                e.preventDefault();


            });


        }); 


</script>


