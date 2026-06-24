<?php
    $this->load->helper('form');
    $error = $this->session->flashdata('error');
    if($error)
    {
?>
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    ?php echo $this->session->flashdata('error'); ?>                    
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
<div class="main-content-container px-3 pt-1">               
<div class="row">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>


 <div class="main-content-container px-3 pt-1">
    <div class="row p-0">
        <div class="col column_padding_card">
            <div class="card card-small card_heading_title p-0 m-b-1">
                <div class="card-body p-2">
                    <div class="row c-m-b">
                        <div class="col-lg-6 col-sm-6 col-6">
                            <span class="page-title absent_table_title_mobile">
                            <i class="material-icons">web</i> Edit Website Event
                            </span>
                        </div>
                       <div class="col-lg-6 col-sm-6 col-6 box-tools">
                            <a onclick="window.history.back();" class="btn primary_color  mobile-btn float-right text-white pt-2"
                                value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- left column -->
    <div class="row">
        <div class="col-12 column_padding_card">
            <div class="card card-small c-border p-1">
                <div class="col-md-12 col-lg-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header">
                        <!-- <h3 class="box-title">Enter Event Details</h3> -->
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <?php $this->load->helper("form"); ?>
                        <form role="form" action="<?php echo base_url(); ?>updateEvent" method="post"  enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <input  type="hidden" class="form-control required" value="<?php echo $eventInfo->row_id; ?>" id="row_id" name="row_id">
                                <div class="col-md-6">                                
                                    <div class="form-group has-feedback">
                                        <label for="date">Date</label>
                                        <input placeholder="Event Date" type="text" class="form-control required datepicker" value="<?php echo date('d-m-Y', strtotime($eventInfo->date)); ?>" id="date" name="date" autocomplete="off" maxlength="128" required>
                                        <i class="glyphicon glyphicon-calendar form-control-feedback"></i>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="sel1">Select Hours:</label>
                                        <select class="form-control" id="hour" name="hour">
                                            <option value="">Selected : <?php echo date('h', strtotime($eventInfo->time)); ?></option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="minutes">Select Minutes:</label>
                                        <select class="form-control" id="minutes" name="minutes">
                                            <option value="">Selected : <?php echo date('i', strtotime($eventInfo->time)); ?></option>
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="24">24</option>
                                            <option value="25">25</option>
                                            <option value="26">26</option>
                                            <option value="27">27</option>
                                            <option value="28">28</option>
                                            <option value="29">29</option>
                                            <option value="30">30</option>
                                            <option value="31">31</option>
                                            <option value="32">32</option>
                                            <option value="33">33</option>
                                            <option value="34">34</option>
                                            <option value="35">35</option>
                                            <option value="36">36</option>
                                            <option value="37">37</option>
                                            <option value="38">38</option>
                                            <option value="39">39</option>
                                            <option value="40">40</option>
                                            <option value="41">41</option>
                                            <option value="42">42</option>
                                            <option value="43">43</option>
                                            <option value="44">44</option>
                                            <option value="45">45</option>
                                            <option value="46">46</option>
                                            <option value="47">47</option>
                                            <option value="48">48</option>
                                            <option value="49">49</option>
                                            <option value="50">50</option>
                                            <option value="51">51</option>
                                            <option value="52">52</option>
                                            <option value="53">53</option>
                                            <option value="54">54</option>
                                            <option value="55">55</option>
                                            <option value="56">56</option>
                                            <option value="57">57</option>
                                            <option value="58">58</option>
                                            <option value="59">59</option>
                                            <option value="60">60</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="sel1">AM/PM</label>
                                        <select class="form-control" id="select3" name="select3">
                                            <option value="">Selected : <?php echo date('A', strtotime($eventInfo->time)); ?></option>
                                            <option value="AM">AM</option>
                                            <option value="PM">PM</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                          
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="location">Location</label>
                                        <input placeholder="Location" type="text" class="form-control required" id="location" value="<?php echo $eventInfo->location; ?>" name="location" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="description">Description</label>
                                        <textarea rows="4" placeholder="Description" type="text" class="form-control" id="description" name="description" autocomplete="off" required><?php echo $eventInfo->description; ?></textarea>
                                    </div>
                                </div>
                            </div>
                    
                        </div><!-- /.box-body -->
    
                        <div class="box-footer" >
                            <input style="float:right" type="submit" class="btn btn-primary" value="Submit" />
                            <!-- <input style="float:left" type="reset" class="btn btn-default" value="Reset" /> -->
                        </div>
                    </form>
                </div>
            </div>
          
        </div>    
 </div>   
</div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script>
jQuery(document).ready(function(){
  jQuery('.datepicker').datepicker({
    autoclose: true,
    format : "dd-mm-yyyy",
    startDate : "today"
  });
});
</script>