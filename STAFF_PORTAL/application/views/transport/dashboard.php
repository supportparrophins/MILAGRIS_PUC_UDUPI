<!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->
<style>
.nf_load_more:hover {
    color: #33cc33 !important;
}

.secondary_color{
  background-color: #223d8fdb;
  border-color: #223d8fdb;
  color: white;
}
</style>
<?php
$this->load->helper('form');
$error = $this->session->flashdata('error');
if ($error) { 
    ?>
<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <i class="fa fa-check mx-2"></i>
    <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
</div>
<?php } ?>
<?php
        $success = $this->session->flashdata('success');
        if ($success) { 
        ?>
<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <i class="fa fa-check mx-2"></i>
    <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
</div>
<?php }?>
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
<div class="main-content-container px-3">
    <div class="row column_padding_card">
        <div class="col-md-12">
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
        </div>
    </div>
    <!-- Page Header -->
    <div class="row mt-1 mb-1 ">
        <div class="col padding_left_right_null">
            <div class="card card_heading_title card-small p-0">
                <div class="card-body p-2 ml-2">
                    <span class="page-title">
                        <i class="fas fa-tachometer-alt"></i> Dashboard / Overview
                    </span>
                    <!-- <img class="float-right" height="35"
                        src="<?php echo base_url(); ?><?php echo DASHBOARD_IMAGE; ?>" /> -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Header -->
    <!-- Small Stats Blocks -->



    <div class="row">
        <?php if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE) { ?>


        <?php } if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_TRASPORT_MANAGER || $role == ROLE_OFFICE || $role == ROLE_MAINTENANCE || $role == ROLE_SUPER_ADMIN) { ?>
        <div class="col-lg-3 col-6 mb-1 column_padding_card">
            <div class="card card-small dash-card secondary_color">
                <a href="<?php echo base_url(); ?>viewBusListing" onclick="showLoader()">
                    <div class="card-body pt-1 pb-1">
                        <span class="stats-small__label text-uppercase text-dark text-center">Bus
                            <?php echo $totalBusCount; ?></span>
                        <h6 class="stats-small__value count text-dark"></h6>
                        <div class="icon pull-right">
                            <i class="fa fa-bus dash-icons"></i>
                        </div>
                    </div>
                    <div class="card-footer text-center dash-footer p-1">
                        <a class="more-info text-dark" href="#"><span class="text-center">View Bus</span></a>
                    </div>
                </a>
            </div>
        </div>
        <!--<div class="col-lg-3 col-6 mb-1 column_padding_card">
            <div class="card card-small dash-card secondary_color">
                <a href="https://peptrack.com/login" onclick="showLoader()">
                    <div class="card-body pt-1 pb-1">
                        <span class="stats-small__label text-uppercase text-dark text-center">Peptrack</span>
                        <h6 class="stats-small__value count text-dark"></h6>
                        <div class="icon pull-right">
                            <i class="fa fa-bus dash-icons"></i>
                        </div>
                    </div>-->
                   <!-- <div class="card-footer text-center dash-footer p-1">
                        <a class="more-info text-dark" href="#"><span class="text-center">View login</span></a>
                    </div>
                </a>
            </div>
        </div>-->
    <?php } ?>

    </div>




    <!-- 6 BUS card -->
    <div class="row">
        <?php if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE) { ?>


        <?php } if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_TRASPORT_MANAGER || $role == ROLE_OFFICE || $role == ROLE_MAINTENANCE || $role == ROLE_SUPER_ADMIN) { ?>
            <?php foreach($BusInfo as $bus){ ?>
       <div class="col-lg-3 col-6 mb-1 column_padding_card">
            <div class="card card-small dash-card " style="background-color: #ADD8E6;">
            <a class="more-info text-dark" href="javascript:void(0);" onclick="openBusCardModel('<?php echo $bus->route_id ?>','<?php echo $bus->row_id ?>','<?php echo $bus->vehicle_number ?>')">
                    <div class="card-body pt-1 pb-1">
                        
                        <span class="stats-small__label text-uppercase text-dark text-center" style="font-size: 22px"><?php echo $bus->bus_no; ?>
                            <!-- <//?php echo $totalBusCount; ?> -->
                        </span>
                        <br>
                        <span class="stats-small__label text-uppercase text-dark text-center"><?php echo $bus->vehicle_number; ?>
                            <!-- <//?php echo $totalBusCount; ?> -->
                        </span>
                        
                        <h6 class="stats-small__value count text-dark"></h6>
                        <div class="icon pull-right">
                            <i class="fa fa-bus dash-icons"></i>
                        </div>
                    </div>
         
            </a>
            </div>
        </div>


       
      
    
        
    <?php } ?>




                
    <?php } ?>


    </div>


    <div class="row">
        
        <div class="col-lg-7 col-md-7 col-12 mb-2 mt-2   padding_left_right_null">
            <div class="card card-small">
            <div class="card-header border-bottom p-2  card_head_dashboard">
                    <h6 class="mb-0 text-dark"><b>Bus Document Expiry Notification</b></h6>
                </div>
            
                <div class="card-body p-0">
                    <ul class="list-group list-group-small list-group-flush">
                        <?php
                if(!empty($insuranceNotification)){
                foreach($insuranceNotification as $notification){ 
                    $count++; 
                ?>
                        <table class="table table-padding mb-0">
                            <tbody>
                                <tr>
                                    <th width="30%" class="text-black"><?php echo $notification->vehicle_number; ?><span
                                            class="float-right">:</span></th>
                                    <td>This Vehicle Insurance will be lapse on
                                        <?php echo date('d-m-Y',strtotime($notification->insurance_expiry_date)); ?>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        <?php }  } ?>
                        <?php 
                if(!empty($roadTaxNotification)){
                foreach($roadTaxNotification as $notification){ 
                    $count++;
                ?>
                        <table class="table table-padding mb-0">
                            <tbody>
                                <tr>
                                    <th width="30%" class="text-black"><?php echo $notification->vehicle_number; ?><span
                                            class="float-right">:</span></th>
                                    <td>This Vehicle Tax will be lapse on
                                        <?php echo date('d-m-Y',strtotime($notification->tax_expiry_date)); ?></td>
                                </tr>

                            </tbody>
                        </table>
                        <?php }  } ?>

                        <?php 
                if(!empty($fcNotification)){
                foreach($fcNotification as $notification){ 
                    $count++;
                ?>
                        <table class="table table-padding mb-0">
                            <tbody>
                                <tr>
                                    <th width="30%" class="text-black"><?php echo $notification->vehicle_number; ?><span
                                            class="float-right">:</span></th>
                                    <td>This Vehicle FC will be lapse on
                                        <?php echo date('d-m-Y',strtotime($notification->fitness_certificate_expiry_date)); ?>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        <?php }  } ?>

                        <?php 
                if(!empty($karnatakaPermitNotification)){
                foreach($karnatakaPermitNotification as $notification){ 
                    $count++;
                ?>
                        <table class="table table-padding mb-0">
                            <tbody>
                                <tr>
                                    <th width="30%" class="text-black"><?php echo $notification->vehicle_number; ?><span
                                            class="float-right">:</span></th>
                                    <td>This Vehicle Permit will be lapse on
                                        <?php echo date('d-m-Y',strtotime($notification->permit_date)); ?></td>
                                </tr>

                            </tbody>
                        </table>
                        <?php }  } ?>
                        <?php 
                if(!empty($emissionNotification)){
                foreach($emissionNotification as $notification){ 
                    $count++;
                ?>
                        <table class="table table-padding mb-0">
                            <tbody>
                                <tr>
                                    <th width="30%" class="text-black"><?php echo $notification->vehicle_number; ?><span
                                            class="float-right">:</span></th>
                                    <td>This Vehicle Emission Date will be lapse on
                                        <?php echo date('d-m-Y',strtotime($notification->emission_expiry_date)); ?></td>
                                </tr>

                            </tbody>
                        </table>
                        <?php }  } ?>
                    </ul>
                </div>
            </div>
        </div>


    </div>


</div>


<div class="modal" id="studentInfo_modal">
    <div class="modal-dialog model-lg" style="max-width:800px">
        
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">Student Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-1" style="max-height:600px;overflow-y:scroll;">
          <form  data-download_form="true" action="<?php echo base_url() ?>downloadRouteWiseReport" method="POST">
        <input type="hidden" id="hidden_route_id_second" name="route_id">
          
          <!-- Tabs content -->

                <div class="tab-content" id="ex1-content">
                    <div class="tab-pane fade show active" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">
                        <table class="table table-bordered ">
                            <thead class="table-info text-center">
                                <tr>
                                    <th>Student Name</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Route</th>
                                    <th>Pickup Point</th>
                                    <th>Blood Group</th>
                                    <th>Guardian Contact</th>
                                </tr>
                            </thead>
                            <tbody id="tab1" class="text-center">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <!--  <button type="submit"  class="btn btn-primary">Export</button>-->
            </div>
        </div>
    </form>
    
    </div>
</div>




<!-- 6 bus card -->

<div class="modal" id="busCard_modal">
    <div class="modal-dialog model-lg" style="max-width:800px">
            <div class="modal-content" >
                <div class="modal-header">
                <h5 class="modal-title" style=" font-weight: bold;">Driver & Conductor Info   </h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <h5 class="modal-title" style=" font-weight: bold;">Vehicle Number :&nbsp;<span id= "vehicle_num"></span>  </h5>
                   
               
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body p-1" >
                 
                    <div class="tab-content" id="ex1-content">
                        <div class="tab-pane fade show active" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">
                            <div class="row">
                     
                                <div class="col-md-6">
                                    <h6 style="font-weight:bold;">Driver</h6>
                                    <img src="" class="img-fluid mb-2" style= "height:70px" alt="Driver Image" id="driver_photo">
                                    <h6 >Name :<span id="driver_name"></span> </h6>
                               
                                    <h6 >Contact Number :<span id= "driver_contact"></span></h6>
                                  
                                    
                                </div>

                              
                                <div class="col-md-6">
                                    <h6 style="font-weight:bold;">Conductor</h6>
                                    <img src="" class="img-fluid mb-2" style= "height:70px" alt="Conductor Image" id="conductor_photo">
                                    <h6 >Name :<span id="conductor_name"></span> </h6>
                                 
                                    <h6>Contact Number:<span id= "conductor_contact" ></h6>
                                  
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal-content ">
           <!-- <div class="modal-header">-->
          <form data-download_form="true" action="<?php echo base_url() ?>downloadRouteWiseReport" method="POST">
             <input type="hidden" id="route_id_hidden" name="route_id">
                
         <!-- <h5 class="modal-title" style=" font-weight: bold;">Student Info&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 

                Total Students :&nbsp;<span id= "total_std_count"></span></h5>-->
               
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>-->

                <!-- Tabs content -->

              <!--  <div class="tab-content" id="ex1-content">
                    <div class="tab-pane fade show active" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">
                        <table class="table table-bordered ">
                            <thead class="table-info text-center" >
                                <tr>
                                    <th>Student Photo</th>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Admission Number</th>
                                    <th>Blood Group</th>
                                    <th>Father Contact</th>
                                    <th>Mother Contact</th>
                                    <th>Guardian Contact</th>
                                </tr>
                            </thead>
                            <tbody id="tab2" class="text-center">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">-->
              <!--  <button type="submit" class="btn btn-primary">Export</button>-->
             <!--   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
        
       </form>
        </div>
            </div>      
    </div>
</div>



<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $('.end_route').change(function() {
        var end_route = $(this).val();
        var targetInputId = 'bus_no_' + $(this).data('value'); // Construct the target input field's id
        //alert(end_route);

        $.ajax({
            url: '<?php echo base_url(); ?>/busNoCheck',
            type: 'POST',
            data: {
                'route_name': end_route,
            },
            success: function(response) {
                var data = JSON.parse(response);
                console.log(data.bus_no);
                $('#' + targetInputId).html(data.bus_no); // Update the correct input field
            },
            error: function(xhr, status, error) {
                console.error("An error occurred: " + status + " " + error);
            }
        });
    });
});

var loader = '<img height="70" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';

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













function openBusCardModel(route_id,row_id,vehicle_num) {

    $("#vehicle_num").text(vehicle_num);
   
   jQuery.ajax({

     type: "POST",

     dataType: "json",

     url: baseURL + "getDriverConductorInfo",

     data: {
      route_id: route_id,
      row_id: row_id,
     }

 }).done(function(data) {

     console.log(data);
     
     var driverPhotoUrl = data.driverInfo ? (data.driverInfo.photo_url ? data.driverInfo.photo_url : 
     '<?php echo base_url(); ?>assets/dist/img/user.png') : '<?php echo base_url(); ?>assets/dist/img/user.png';

        var driverContact = data.driverInfo ? (data.driverInfo.mobile_one ? data.driverInfo.mobile_one : '') : '';
        var driverName = data.driverInfo ? (data.driverInfo.name ? data.driverInfo.name : '') : '';


        var conductorPhotoUrl = data.conductorInfo ? (data.conductorInfo.photo_url ? data.conductorInfo.photo_url : 
        '<?php echo base_url(); ?>assets/dist/img/user.png') : '<?php echo base_url(); ?>assets/dist/img/user.png';




      var conductorContact = data.conductorInfo ? (data.conductorInfo.mobile_one ? data.conductorInfo.mobile_one : '') : '';
      var conductorName = data.conductorInfo ? (data.conductorInfo.name ? data.conductorInfo.name : '') : '';
    

      
       

        $("#driver_photo").attr("src", driverPhotoUrl);
        $("#conductor_photo").attr("src", conductorPhotoUrl);


        $("#conductor_contact").html("<strong>" + conductorContact + "</strong>");
        $("#driver_contact").html("<strong>" + driverContact + "</strong>");





        $("#driver_name").html("<strong>" + driverName + "</strong>");
        $("#conductor_name").html("<strong>" + conductorName + "</strong>");
        // alert("vehicle_num");




// console.log(vehicleNum);






     count = data.studentInfo.length;
     var tab2 = "";


        

     for (i = 0; i < count; i++) {
        tab2 += '<tr>';

        
        tab2 += "<td><img src='" + (data.studentInfo[i].photo_url != null && data.studentInfo[i].photo_url.trim() !== '' ? data.studentInfo[i].photo_url :
         '<?php echo base_url(); ?>assets/dist/img/user.png') + "' style='height: 50px;' class='img-fluid' alt='Student Photo'></td>";


            tab2 += '<td>' + (data.studentInfo[i].student_name != null ? data.studentInfo[i].student_name : '') + '</td>';
            tab2 += '<td>' + (data.studentInfo[i].term_name != null ? data.studentInfo[i].term_name : '') + '</td>';
            tab2 += '<td>' + (data.studentInfo[i].section_name != null ? data.studentInfo[i].section_name : '') + '</td>';
            tab2 += '<td>' + (data.studentInfo[i].admission_no != null ? data.studentInfo[i].admission_no : '') + '</td>';
            tab2 += '<td>' + (data.studentInfo[i].blood_group != null ? data.studentInfo[i].blood_group : '') + '</td>';
            tab2 += '<td>' + (data.studentInfo[i].father_mobile_one != null ? data.studentInfo[i].father_mobile_one : '') + '</td>';
            tab2 += '<td>' + (data.studentInfo[i].mother_mobile_one != null ? data.studentInfo[i].mother_mobile_one : '') + '</td>';
            tab2 += '<td>' + (data.studentInfo[i].guardian_mobile_no != null ? data.studentInfo[i].guardian_mobile_no : '') + '</td>';
            tab2 += '</tr>';

}
  if (count != 0) {
    $("#tab2").html(tab2);
  //   $("#subName").html(data[0].sub_name);
  } else {
    $("#tab2").html(tab2);
  //   $("#subName").html("");
   }

 
   $("#total_std_count").text(count);
   
   $("#route_id_hidden").val(route_id);

  $('#busCard_modal').modal('show'); 

  });

 }


function openTransportModel(route_id,row_id) { 
   
   jQuery.ajax({

     type: "POST",

     dataType: "json",

     url: baseURL + "getStudentInfoByRoute",

     data: {
      route_id: route_id,
      row_id: row_id,
     }

 }).done(function(data) {

     console.log(data);
     count = data.length;

    
     var tab1 = "";
     for (i = 0; i < count; i++) {
        
  tab1 += '<tr>'
  tab1 += '<td>' + (data[i].student_name != null ? data[i].student_name : '') + '</td>'
  tab1 += '<td>' + (data[i].term_name != null ? data[i].term_name : '') + '</td>'
  tab1 += '<td>' + (data[i].section_name != null ? data[i].section_name : '') + '</td>'
  tab1 += '<td>' + (data[i].route_name != null ? data[i].route_name : '') + '</td>'
  tab1 += '<td>' + (data[i].pickup_point != null ? data[i].pickup_point : '') + '</td>'
  tab1 += '<td>' + (data[i].admission_no != null ? data[i].blood_group : '') + '</td>'
  tab1 += '<td>' + (data[i].admission_no != null ? data[i].guardian_mobile_no : '') + '</td>'
  tab1 += '</tr>'
}
  if (count != 0) {
    $("#tab1").html(tab1);
  //   $("#subName").html(data[0].sub_name);
  } else {
    $("#tab1").html(tab1);
  //   $("#subName").html("");
   }
   $('#hidden_route_id_second').val(route_id);
  $('#studentInfo_modal').modal('show');

  });

 }


 var links = document.querySelectorAll('.preventDefault');

// Iterate through each anchor tag and attach an event listener
links.forEach(function(link) {
    link.addEventListener('click', function(e) {
        e.preventDefault(); // Prevents the default behavior of the anchor tag
        // Additional code here if needed
    });
});


</script>