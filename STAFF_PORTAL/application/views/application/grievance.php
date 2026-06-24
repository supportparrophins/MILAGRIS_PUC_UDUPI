


<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery('ul.pagination li a').click(function (e) {
        e.preventDefault();            
        var link = jQuery(this).get(0).href;            
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "admissionGrievance/" + value);
        jQuery("#byFilterMethod").submit();
    });
    
    $(".datepicker").datepicker({
        format: 'dd-mm-yyyy',
        changeMonth: true,
        changeYear: true,
        autoclose: true,
        startDate: '01-01-2020',
        constrainInput: false
    });
});

</script>


<style>
input[type=checkbox] {
    cursor: pointer;
    font-size: 10px;
    -moz-appearance: initial;
    visibility: hidden;
    position: relative;
    top: 0;
    left: 0;
    transform: scale(1.2);
}

input[type=checkbox]:after {
    content: " ";
    background-color: #fff;
    display: inline-block;
    color: red;
    width: 10px;
    height: 10px;
    visibility: visible;
    border: 1px solid #3c8dbc;
    padding: 2px;
    margin: 1px 0;
    border-radius: 1px;
    box-shadow: 0 0 15px 0 rgba(0, 0, 0, 0.08), 0 0 2px 0 rgba(0, 0, 0, 0.16);
}

input[type=checkbox]:checked:after {
    content: "\2714";
    display: unset;
    font-weight: bold;
    width: 10px;
    height: 10px;
    padding: 2px
}

.select2-container .select2-selection--single {
    height: 38px !important;
    width: 360px !important;
}


.form-control {
    border: 1px solid #000000 !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow b {
    margin-top: 3px !important;
    color: black !important;

}

@media screen and (max-width: 480px) {
    .select2-container--default .select2-selection--single .select2-selection__arrow {

        margin-right: 20px !important;
    }

    .select2-container .select2-selection--single {
        width: 270px !important;
    }
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
<div class="row column_padding_card">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container px-3 pt-1 overall_content">
    <div class="content-wrapper">
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class=" col-12 col-md-6 box-tools">
                                <span class="page-title">
                                    <i class="fa fa-file"></i> Grievance
                                </span>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <b class="text-dark" style="font-size: 18px;">Total: <?php echo $countMessage; ?></b>

                                <a onclick="window.history.back();"
                                    class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 ">
            <div class="col-12">
                <div class="card card-small mb-4">
                    <div class="card-body p-1 pb-1 table-responsive">
                        <table style="width:100%" class="display table  table-bordered table-striped table-hover mb-0">
                            <thead>
                                <tr class="table_row_backgrond text-center">
                                <th class="text-center" width="100">Date</th>
                                        <th class="text-center" width="100">Register ID</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center" width="110">Student Mobile No.</th>
                                        <th class="text-center" width="110">Father Mobile No.</th>
                                        <th class="text-center">Subject</th>
                                        <th class="text-center" width="230">Message</th>
                                        <th class="text-center" width="30">Action</th>
                                </tr>
                                <tr class="row_filter">
                                <form action="<?php echo base_url(); ?>admissionGrievance" role="form" method="post" id="byFilterMethod">
                                        <tr class="filter_row">
                                            <th> 
                                                <input type="text" name="by_date" id="by_date" value="<?php echo $by_date; ?>" class="form-control input-sm pull-right datepicker"  style="text-transform: uppercase" placeholder="By Date" autocomplete="off"/>
                                            </th>
                                            <th> 
                                                <input type="text" name="register_row_id" id="register_row_id" value="<?php echo $register_row_id; ?>" class="form-control input-sm pull-right"  style="text-transform: uppercase" placeholder="By ID" autocomplete="off"/>
                                            </th>
                                            <th> 
                                                <input type="text" name="student_name" id="student_name" value="<?php echo $student_name; ?>" class="form-control input-sm pull-right"  style="text-transform: uppercase" placeholder="By Name" autocomplete="off"/>
                                            </th>
                                            <th> 
                                                <input type="text" name="student_mobile_no" id="student_mobile_no" value="<?php echo $student_mobile_no; ?>" class="form-control input-sm pull-right"  style="text-transform: uppercase" placeholder="Student Mobile Number" autocomplete="off"/>
                                            </th>
                                            <th> 
                                                <input type="text" name="father_mobile_no" id="father_mobile_no" value="<?php echo $father_mobile_no; ?>" class="form-control input-sm pull-right"  style="text-transform: uppercase" placeholder="Father Mobile Number" autocomplete="off"/>
                                            </th>
                                            <th></th>
                                            <th></th>
                                            <th><button type="submit" class="btn btn-info btn-md btn-block"><i class="fa fa-filter"></i> Filter</button></th>
                                        </tr>
                                    </form>
                                </tr>
                            </thead>
                            <tbody>
                                        <?php if(!empty($supportInfo)) {
                                            foreach($supportInfo as $support) { ?>
                                                <tr>
                                                    <th class="text-center"><?php echo date('d-m-Y',strtotime($support->created_date_time)); ?></th>
                                                    <th class="text-center"><?php echo $support->registered_row_id; ?></th>
                                                    <th><?php echo $support->name; ?></th>
                                                    <th class="text-center"><?php echo $support->student_mobile; ?></th>
                                                    <th class="text-center"><?php echo $support->father_mobile; ?></th>
                                                    <th><?php echo $support->subject; ?></th>
                                                    <th><?php echo $support->message; ?></th>
                                                    <th class="text-center"></th>
                                                </tr>
                                        <?php } }else{ ?>
                                            <tr style="background-color: #00a65a7d;">
                                                <th class="text-center" colspan="9">No Messages!.</th>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                            <tfoot>
                                <tr class="table_row_backgrond text-center">
                                <th class="text-center" width="100">Register ID</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center" width="160">Student Mobile No.</th>
                                        <th class="text-center" width="160">Father Mobile No.</th>
                                        <th class="text-center">Subject</th>
                                        <th class="text-center">Message</th>
                                        <th class="text-center" width="100">Action</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                    <div class="card-footer text-center pt-1 px-1 pb-0">
                        <span class="float-right"><?php echo $this->pagination->create_links(); ?></span>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>



<script src="<?php echo base_url(); ?>assets/js/student.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    // $(".reason_unqualified").hide();

    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "admissionGrievance/" + value);
        jQuery("#byFilterMethod").submit();
    });

    jQuery('.datepicker, .dateSearch').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });

    //checkbox select
    $('#selectAll').click(function() {
        if ($('#selectAll').is(':checked')) {
            $('.singleSelect').prop('checked', true);
        } else {
            $('.singleSelect').prop('checked', false);
        }
    });



    $('#leaving_date, .datepicker').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy"
    });

});
</script>