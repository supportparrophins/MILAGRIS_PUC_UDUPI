<!DOCTYPE html>



<html>



    <head>



      <meta charset="UTF-8">



      <title>SchoolPhins-SJPUCH : Forgot Password</title>



      <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>



      <!-- icons -->



      <link rel="icon"   href="<?php echo base_url(); ?>assets/dist/img/dolphin_logo.png"> 



        <link rel="apple-touch-icon" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">



        <link rel="apple-touch-icon" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">



        <link rel="apple-touch-icon" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">



        <link rel="apple-touch-icon" sizes="57x57" href="images/ico/apple-touch-icon-57-precomposed.png">



        



        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">



        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">



        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">



        <link rel="stylesheet" id="main-stylesheet" data-version="1.0.0" href="<?php echo base_url(); ?>assets/dist/styles/shards-dashboards.1.0.0.min.css">



        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/styles/extras.1.0.0.min.css">



      



        <link href="<?php echo base_url(); ?>assets/dist/css/style.css" rel="stylesheet" type="text/css" />



        



        <script type="text/javascript">



        var baseURL = "<?php echo base_url(); ?>";



        </script>



    </head>



    <body class="login-page">



      <div class="loader">



        <img id="loader_img" src="<?php echo base_url(); ?>assets/dist/img/student.gif" class="img-fluid" alt="loader">



      </div>



      <div class="row margin_left_right_null">



        <div class="card mx-auto forgotPassword_card">



          <div class="card-header pb-0">



            <div class="col-xs-12 text-center">



              <h6><b>Forgot Password</b></h6>



            </div>



          </div>



          <div class="card-body">



            <div class="col-xs-12 text-center">



              <img src="<?php echo base_url(); ?>assets/dist/img/logoSJPUCH.jpg" height="80px">



            </div>



            <div class="col-xs-12 text-center mb-2">



              <span><b style="font-size: 25px;"><span class="title_green">School</span><span class="title_blue">Phins</span> - <span class="title_blue">SJPUC</span></b></span>



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



            <form action="<?php echo base_url(); ?>resetPasswordUser" method="post" id="studentForgotPassword">



              <div class="input-group mb-3">



                <div class="input-group-prepend">



                  <span class="input-group-text material-icons text-dark">person</span>



                </div>



                <input type="text" class="form-control required" style="text-transform: capitalize;" placeholder="Student ID" id="student_id" name="student_id"  autocomplete="off" required/>



              </div>



              <div class="input-group mb-3">



                <div class="input-group-prepend">



                  <span class="input-group-text material-icons text-dark">date_range</span>



                </div>



                <input type="text" class="form-control datepicker required" placeholder="Date of Birth" id="dob" name="dob" autocomplete="off" required/>



              </div>



              <div class="row">



                <div class="col-xs-6 col-sm-6  col-md-12">



                  <input type="submit" class="btn btn_submit btn-block" value="Change" />



                </div>



              </div>



              <div class="row">



                <div class="col-xs-6 col-sm-6 col-md-12">



                  <a href="<?php echo base_url() ?>" class="float-right" style="margin-top: 10px;">Back to Login</a><br>



                </div>



            </div>



            </form>



          </div>



          <div class="card-footer">



            <div class="col-xs-12 text-center">



              <span class="">&copy;<script>document.write(new Date().getFullYear())</script>-24 <a href="" target="_blank"><span class="title_green">School</span><span class="title_blue">Phins</span></a> The Wings of an Education.</span>



            </div>



          </div>



        </div>



      </div>



    </body>



</html>



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



</script>



<script type="text/javascript">



  $(function() {



    $(this).bind("contextmenu", function(e) {



        e.preventDefault();



    });



  }); 



  $(window).on("load", function() {



    preloaderFadeOutTime = 500;



    function hidePreloader() {



      var preloader = $('.loader');



      preloader.fadeOut(preloaderFadeOutTime);



    }



    hidePreloader();



  });



</script>   