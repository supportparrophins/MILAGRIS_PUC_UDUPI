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

                    <i class="material-icons">forum</i> My Suggestion

                </span>

                <a onclick="window.history.back(); return false;" class="btn btn-primary float-right text-white pt-2" value="Back" >Back </a>

                </div>

            </div>

            </div>

        </div>

    </section>

    <div class="row form-employee">

        <div class="col-12 padding_left_right_null">

            <div class="card card-small c-border mb-4">

                <div class="suggestion_box panel">

                    <div id="chat" class="chat_box_wrapper chat_box_small chat_box_active" style="opacity: 1; display: block; transform: translateX(0px);">

                        <?php if(!empty($suggestionInfo)){

                            foreach($suggestionInfo as $suggestion){  ?>

                        <div class="chat_box touchscroll chat_box_colors_a">
                        <?php  if(!empty($suggestion->message)){?>
                            <div class="chat_message_wrapper chat_message_right">

                                <div class="chat_user_avatar">

                                    <img alt="Student Image" src="<?php echo $studentInfo->photo_url; ?>" class="md-user-image">

                                </div>

                                <ul class="chat_message">

                                    <li>

                                        <p><?php  echo $suggestion->message; ?>

                                            <span class="chat_message_time"> <span class="text-capitalize"><?php echo $suggestion->msg_from; ?></span> • <?php echo date('d M Y h:i A ', strtotime($suggestion->date)); ?> </span>

                                        </p>

                                    </li>

                                </ul>

                            </div>
                            <?php         } ?>

                            <?php if(!empty($suggestion->management_reply)){ ?>

                            <div class="chat_message_wrapper">

                                <div class="chat_user_avatar">

                                    <img alt="Management Image" src="<?php echo base_url(); ?>assets/dist/img/logoSJPUCH.jpg" class="md-user-image">

                                </div>

                                <ul class="chat_message">

                                    <li>

                                        <p><?php echo $suggestion->management_reply; ?></p>

                                        <span class="chat_message_time"><?php echo date('d M Y h:i A ', strtotime($suggestion->date)); ?> </span>

                                    </li>

                                </ul>

                            </div>

                            <?php } ?>

                        </div>

                        <?php } } ?>

                    </div>

                    <div class="chat_submit_box">

                        <div class="row">

                            <div class="uk-input-group">

                                <form role="form" method="post" action="<?php echo base_url(); ?>suggestionToDB">

                                    <div class="gurdeep-chat-box">

                                        <div class="col-lg-3 col-md-3 col-12 chat_col_padding_right_null">

                                            <div class="form-group">

                                                <select class="form-control" id="select_from" name="select_from" required>

                                                    <option value="">Select From</option>

                                                    <option value="Parent">From Parent</option>

                                                    <option value="Student">From Student</option>

                                                </select>

                                            </div>

                                        </div>

                                        <div class="col-lg-7 col-md-7 col-12 chat_col_padding_null">

                                            <input type="text" placeholder="Type a message" id="submit_message" name="submit_message" class="md-input" required autocomplete="off">

                                        </div>

                                        <div class="col-lg-2 col-md-2 col-12 chat_col_padding_left_null">

                                            <button type="submit" class="btn btn-primary btn-block" id="btn-chat">Send</button>

                                        </div>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    

</div>

<script>

$(function(){

$("#addClass").click(function () {

  $('#sidebar_secondary').addClass('popup-box-on');

    });

  

    $("#removeClass").click(function () {

  $('#sidebar_secondary').removeClass('popup-box-on');

    });

})

</script>