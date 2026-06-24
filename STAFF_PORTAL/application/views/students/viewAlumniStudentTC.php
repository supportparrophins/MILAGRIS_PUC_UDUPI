<style>
input[type=checkbox] {
    cursor: pointer;
    font-size: 10px;
    -moz-appearance: initial;
    visibility: hidden;
    position: relative;
    top: 0;
    left: 0;
    transform: scale(1.1);
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
<div class="row">
    <div class="col-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container px-3 pt-1 overall_content">
    <div class="content-wrapper">
        <div class="row p-0 column_padding_card noprint">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class=" col-12 col-md-4 col-lg-5 box-tools">
                                <span class="page-title">
                                    <i class="material-icons">group</i>Alumni Transfer Certificate
                                </span>
                            </div>
                            <div class="col-lg-4 col-md-2 col-6">
                                <h5 class="mb-0 font-weight-bold text-dark">Total: <?php echo $totalCount; ?></h5>
                            </div>

                             <!-- <div class="col-lg-3 col-md-3 col-3">
                                <form action="<?php echo base_url() ?>getStudentAppliedForTc" method="POST"
                                        id="byFilterMethod">
                                <div class="input-group mobile-btn float-right student_search">
                                        <select class="p-1 search_select" name="admission_year" id="admission_year">
                                            <?php if(!empty($admission_year)){ ?>
                                                <option value="<?php echo $admission_year; ?>" selected><b>Selected: <?php echo $admission_year; ?></b></option>
                                            <?php } ?>
                                            <option value="<?php echo CURRENT_YEAR?>"><?php echo CURRENT_YEAR?></option>
                                            <option value="2021">2021</option>
                                            <option value="2020">2020</option>
                                            
                                        </select>
                                        <div class="input-group-append">
                                        <button type="submit" class="btn btn-success border_radius_none py-0">
                                            <i class="fa fa-search"></i>
                                        </button>
                                        </div>
                                    </div>
                            </div> -->

                            <div class="col-lg-3 col-md-3 col-6">

                                <a onclick="window.history.back();"
                                    class="btn primary_color mobile-btn float-right text-white border_left_radius"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                <div class="dropdown mobile-btn float-right border_right_radius">
                                    <button type="button" class="btn btn-primary dropdown-toggle border_right_radius"
                                        data-toggle="dropdown">
                                        Action
                                    </button>
                                    <div class="dropdown-menu p-0">
                                        <a class="dropdown-item" data-toggle="modal" id="add_certificate" data-target="#myModal" href="#"><i class="fa fa-plus"></i> Add</a>
                                        <a class="dropdown-item"  id="tranfer_certificate" href="#"><i class="fa fa-file"></i> 
                                        Transfer Certificate</a>
                                        <div class="dropdown-divider m-0"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-0 ">
            <div class="col-12">
                <div class="card card-small mb-0">
                    <div class="card-body p-1 pb-2">
                        <div class="table-responsive">
                            <table class="display table  table-bordered table-striped table-hover w-100 mb-0">
                            <form action="<?php echo base_url() ?>getAlumniStudentTc" method="POST"
                                        id="byFilterMethod">
                            <tr class="row_filter">
                                    
                                        <th></th>
                                        <th> <input type="text" value="<?php echo $by_date; ?>" name="by_date" id="by_date" class="form-control input-sm datepicker" style="text-transform: uppercase" placeholder="TC Applied Date" autocomplete="off"></th>

                                         <th style="padding: 1px;"> <input type="text" name="tc_number" id="tc_number"
                                                value="<?php echo $tc_number ?>"
                                                class="form-control input-sm pull-right"
                                                style="text-transform: uppercase" placeholder="TC Number"
                                                autocomplete="off" />
                                        </th>

                                     
                                        <th style="padding: 1px;"> <input type="text" name="name"
                                                id="name" value="<?php echo $name ?>"
                                                class="form-control input-sm pull-right"
                                                style="text-transform: uppercase" placeholder="By Name"
                                                autocomplete="off" />
                                        </th>
                                         
                                        <th style="padding: 1px;">
                                            <select class="form-control input-sm" id="class" name="class"
                                                autocomplete="off">
                                                <option value="<?php echo $class; ?>" selected>
                                                        <?php echo $class; ?></option>
                                                <option value="">By Term</option>
                                                <option value="I PUC">I PUC</option>
                                                <option value="II PUC">II PUC</option>

                                            </select>
                                        </th>

                                        <th style="padding: 1px;"> <input type="text" name="register_no"
                                                id="register_no" value="<?php echo $register_no ?>"
                                                class="form-control input-sm pull-right"
                                                style="text-transform: uppercase" placeholder="By Register No."
                                                autocomplete="off" />
                                        </th>
                                        <th style="padding: 1px;">
                                            <button type="submit"
                                            class="btn btn-success btn-md btn-block"><i class="fa fa-filter"></i>
                                            Filter</button>
                                        </th>



                                    </form>
                                </tr>
                                <thead>
                                    <tr class="table_row_backgrond text-center">
                                        <th width="25">
                                            <input type="checkbox" id="selectAll" />
                                        </th>
                                        <th >TC Applied Date</th>
                                        <th>TC No.</th>                                   
                                        <th>Name</th>
                                        <th>Class</th>                                      
                                        <th>Register No.</th>
                                        <th>Action</th> 
                                    </tr>
                                   
                                </thead>
                                <tbody>

                                    <?php
                                    if(!empty($studentTcInfo)) {
                                        foreach($studentTcInfo as $record) { ?> 
                                    <tr>
                                        <th><input type="checkbox" class="singleSelect"
                                            value="<?php echo $record->row_id; ?>" /></th>
                                        <th class="text-center"><?php echo date('d-m-Y',strtotime($record->created_date_time)); ?></th>
                                        <th class="text-center"><?php echo $record->tc_number; ?></th>
                                       
                                        <th ><?php echo strtoupper($record->name); ?></th>
                                        <th class="text-center"><?php echo $record->class; ?></th>
                                       
                                        <th class="text-center"><?php echo $record->register_no; ?></th>
                                        <th> 
                                            <!-- <a onclick="openModel('<?php echo $record->row_id; ?>')" class="btn btn-xs btn-info mb-1" data-toggle="modal" value="<?php echo $record->row_id; ?>" id="add_certificate" data-target="#updateModal" href="#"><i class="fas fa-pencil-alt"></i> Edit</a> -->
                                        </th> 
                                    </tr>
                                    <?php } }else{  ?>
                                        <tr>
                                            <th class="text-center" colspan="8">Student Record Not Found</th>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer p-1 mb-0">
                        <div class="float-right">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="bulkTcPrint">
    <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Transfer Certificate</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <form role="form" method="post" action="<?php echo base_url(); ?>getBulkStudentTCPrint" target="_blank">
            <div class="modal-body p-1">
                <div class="row">
                    <div class="col-lg-6">   
                        <select class="form-control input-sm" id="term_name" name="term_name" autocomplete="off" required>
                            <option value="">By Term</option>
                            <option value="I PUC">I PUC</option>
                            <option value="II PUC">II PUC</option>
                        </select>
                    </div>     
                    <div class="col-lg-6">   
                        <select class="form-control input-sm" id="stream_name" name="stream_name" autocomplete="off">
                            <option value="">By Stream</option>
                            <?php if(!empty($streamInfo)){
                                foreach($streamInfo as $stream){ ?>
                                <option value="<?php echo $stream->stream_name; ?>"><?php echo $stream->stream_name; ?></option>
                            <?php } } ?>
                        </select>
                    </div>     
                </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <!-- <button</button> -->
                <button id="printTransferCertificate" type="submit" class="btn btn-md btn-primary"><i
                        class="fa fa-print"></i> Print</button>
            </div>

        </form>   

        <!-- Modal footer -->
        </div>
    </div>
</div>



<!-- The Modal -->
<div class="modal" id="updateModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Add Student Details</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
            <input type="hidden" value="<?php echo $studentTcInfo->row_id; ?>" id="row_id" name="row_id">   
                <form method="POST" action="<?php echo base_url() . 'updateAlumniStudentTCInfo' ?>">
                
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="roll_no1">Roll Number*</label>
                                <input name="roll_no1" type="text" class="form-control"  id="roll_no1" placeholder="Enter Roll Number" required autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="name">Name*</label>
                                <input name="name" type="text" class="form-control" onkeydown="return alphaOnly(event)" id="name1" placeholder="Enter Name" required autocomplete="off" onkeydown="return alphaOnly(event)">
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="dob" >Date of Birth*</label>
                                <input type="date" placeholder="Enter Date of Birth" class="form-control" required name="dob" id="dob1">
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="nationality">Nationality*</label>
                                <select class="form-control" id="nationality1" name="nationality" required>
                                    <option value="">Select Nationality</option>
                                    <?php if (!empty($nationalityInfo)) {
                                        foreach ($nationalityInfo as $nationality) { ?>
                                            <option value="<?php echo $nationality->name; ?>"><?php echo $nationality->name; ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="religion">Religion*</label>
                                <select class="form-control" id="religion1" name="religion" required>
                                    <option value="">Select Religion</option>
                                    <?php if (!empty($religionInfo)) {
                                        foreach ($religionInfo as $religion) { ?>
                                            <option value="<?php echo $religion->name; ?>"><?php echo $religion->name; ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="father_name">Father's Name*</label>
                                <input name="father_name" type="text" class="form-control" onkeydown="return alphaOnly(event)" required id="father_name1" placeholder="Enter Father's Name" autocomplete="off" onkeydown="return alphaOnly(event)">
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="mother_name">Mother's Name*</label>
                                <input name="mother_name" type="text" class="form-control" onkeydown="return alphaOnly(event)" required id="mother_name1" placeholder="Enter Mother's Name" autocomplete="off" onkeydown="return alphaOnly(event)">
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="date_of_admission" >Date of Admission*</label>
                                <input type="date" placeholder="Date of Admission" class="form-control" name="date_of_admission" id="date_of_admission1" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="date_of_leaving" >Date of Leaving*</label>
                                <input type="date" placeholder="Date of Leaving" class="form-control" name="date_of_leaving" id="date_of_leaving1" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                            <label for="class">Class at the time of Leaving*</label>
                                <select class="form-control" id="class1" name="class" required>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC </option>
                                </select>
                            </div>
                        </div>
                       
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Subjects Studied : Languages*</label>
                                <select class="form-control input-sm selectpicker" id="language_subject1"  name="language_subject[]" data-live-search="true" required multiple>
                                    <option value="">Select Language Subjects</option>
                                    <option value="ENGLISH">ENGLISH</option>
                                    <option value="KANNADA">KANNADA</option>
                                    <option value="HINDI">HINDI</option>
                                    <option value="FRENCH">FRENCH</option>                                
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Subjects Studied : Optionals*</label>
                                <select class="form-control input-sm selectpicker" id="optional_subject1"  name="optional_subject[]" data-live-search="true" required multiple>
                                    <option value="">Select Optionals Subjects</option>
                                    <option value="PHYSICS">PHYSICS</option>
                                    <option value="CHEMISTRY">CHEMISTRY</option>
                                    <option value="MATHEMATICS">MATHEMATICS</option>
                                    <option value="BIOLOGY">BIOLOGY</option>    
                                    <option value="COMPUTER SCIENCE">COMPUTER SCIENCE</option>
                                    <option value="ELECTRONICS">ELECTRONICS</option>
                                    <option value="BASIC MATHS">BASIC MATHS</option>
                                    <option value="ECONOMICS">ECONOMICS</option>                                  
                                    <option value="BUSINESS STUDIES">BUSINESS STUDIES</option>                                    
                                    <option value="ACCOUNTANCY">ACCOUNTANCY</option>
                                    <option value="STATISTICS">STATISTICS</option>                                  
                                    <option value="HISTORY">HISTORY</option>
                                    <option value="POLITICAL SCIENCE">POLITICAL SCIENCE</option>
                                    <option value="SOCIOLOGY">SOCIOLOGY</option>
                                    <option value="PT">PT</option> 
                                    <option value="HRD">HRD</option> 
                                </select>
                            </div>
                        </div>
                        <!-- <div class="col-lg-6 col-12">
                            <div class="form-group">
                            <label for="medium">Medium of Instruction</label>
                                <select class="form-control required" id="medium" name="medium" >
                                    <option value="ENGLISH">ENGLISH</option>
                                    <option value="KANNADA">KANNADA</option>
                                    <option value="HINDI">HINDI</option>
                                </select>
                            </div>
                        </div> -->
                        <div class="col-lg-6 col-12">
                            <div class="form-group qualified_status">
                                <label for="role">Whether the student is qualified for Promotion?*</label>
                                <select class="form-control" id="qualified_status1" name="qualified_status" required>
                                    <option value="YES" >YES</option>
                                    <option value="NO">NO </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group reason_unqualified">
                                <label for="role">Give reason for Unqualified Promotion?</label>
                                <select class="form-control" id="reason_unqualified1" name="reason_unqualified">
                                    <option value="" >Select One Resaon</option>
                                    <option value="DISCONTINUED" >Discontinued</option>
                                    <option value="ATTENDAANCE SHORTAGE">Attendance Shortage </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="register_no" >Register Number(Exam No.)*</label>
                                <input type="text" placeholder="Register Number(Exam No.)" class="form-control" name="register_no" id="register_no1" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="role">Whether the student is belongs to SC/ST?*</label>
                                <select class="form-control" id="belong_sc_st1" name="belong_sc_st" required>
                                    <option value="NO">NO </option>
                                    <option value="YES" >YES</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="fee_due">whether the student has cleared all the College dues?*</label>
                                <select class="form-control" id="fee_due1" name="fee_due" required>
                                    <option value="NO">NO </option>
                                    <option value="YES" >YES</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="role">Character and Conduct?*</label>
                                <select class="form-control" id="character1" name="character" required>
                                    <option value="GOOD" >GOOD</option>
                                    <option value="VERY GOOD">VERY GOOD </option>
                                    <option value="SATISFIED">SATISFIED </option>
                                </select>
                            </div>
                        </div>           
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="tc_number" >TC Number*</label>
                                <input type="text" placeholder="TC Number" class="form-control" name="tc_number" id="tc_number1" required>
                            </div>
                        </div> 
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="remarks" >Remarks*</label>
                                <input type="text" placeholder="Remarks" class="form-control" name="remarks" id="remarks1" required>
                            </div>
                        </div> 
        </div>

            <!-- Modal footer -->
            <div class="modal-footer" style="padding:5px;">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>



<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Add Student Details</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2">
                <form method="POST" action="<?php echo base_url() . 'addAlumniStudentTCInfo' ?>">
                <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="roll_no">Roll Number*</label>
                                <input name="roll_no" type="text" class="form-control"  id="roll_no" placeholder="Enter Roll Number" required autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="name">Name*</label>
                                <input name="name" type="text" class="form-control" onkeydown="return alphaOnly(event)" id="name" placeholder="Enter Name" required autocomplete="off" onkeydown="return alphaOnly(event)">
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="dob" >Date of Birth*</label>
                                <input type="date" placeholder="Enter Date of Birth" class="form-control" required name="dob" id="dob">
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="nationality">Nationality*</label>
                                <select class="form-control" id="nationality" name="nationality" required>
                                    <option value="">Select Nationality</option>
                                    <?php if (!empty($nationalityInfo)) {
                                        foreach ($nationalityInfo as $nationality) { ?>
                                            <option value="<?php echo $nationality->name; ?>"><?php echo $nationality->name; ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="religion">Religion*</label>
                                <select class="form-control" id="religion" name="religion" required>
                                    <option value="">Select Religion</option>
                                    <?php if (!empty($religionInfo)) {
                                        foreach ($religionInfo as $religion) { ?>
                                            <option value="<?php echo $religion->name; ?>"><?php echo $religion->name; ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="father_name">Father's Name*</label>
                                <input name="father_name" type="text" class="form-control" onkeydown="return alphaOnly(event)" required id="father_name" placeholder="Enter Father's Name" autocomplete="off" onkeydown="return alphaOnly(event)">
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="mother_name">Mother's Name*</label>
                                <input name="mother_name" type="text" class="form-control" onkeydown="return alphaOnly(event)" required id="mother_name" placeholder="Enter Mother's Name" autocomplete="off" onkeydown="return alphaOnly(event)">
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="date_of_admission" >Date of Admission*</label>
                                <input type="date" placeholder="Date of Admission" class="form-control" name="date_of_admission" id="date_of_admission" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="date_of_leaving" >Date of Leaving*</label>
                                <input type="date" placeholder="Date of Leaving" class="form-control" name="date_of_leaving" id="date_of_leaving" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                            <label for="class">Class at the time of Leaving*</label>
                                <select class="form-control" id="class" name="class" required>
                                    <option value="I PUC">I PUC</option>
                                    <option value="II PUC">II PUC </option>
                                </select>
                            </div>
                        </div>
                       
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Subjects Studied : Languages*</label>
                                <select class="form-control input-sm selectpicker" id="language_subject"  name="language_subject[]" data-live-search="true" required multiple>
                                    <option value="">Select Language Subjects</option>
                                    <option value="ENGLISH">ENGLISH</option>
                                    <option value="KANNADA">KANNADA</option>
                                    <option value="HINDI">HINDI</option>   
                                    <option value="FRENCH">FRENCH</option>                              
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Subjects Studied : Optionals*</label>
                                <select class="form-control input-sm selectpicker" id="optional_subject"  name="optional_subject[]" data-live-search="true" required multiple>
                                    <option value="">Select Optionals Subjects</option>
                                    <option value="PHYSICS">PHYSICS</option>
                                    <option value="CHEMISTRY">CHEMISTRY</option>
                                    <option value="MATHEMATICS">MATHEMATICS</option>
                                    <option value="BIOLOGY">BIOLOGY</option>    
                                    <option value="COMPUTER SCIENCE">COMPUTER SCIENCE</option>
                                    <option value="ELECTRONICS">ELECTRONICS</option>
                                    <option value="BASIC MATHS">BASIC MATHS</option>
                                    <option value="ECONOMICS">ECONOMICS</option>                                  
                                    <option value="BUSINESS STUDIES">BUSINESS STUDIES</option>                                    
                                    <option value="ACCOUNTANCY">ACCOUNTANCY</option>
                                    <option value="STATISTICS">STATISTICS</option>                                  
                                    <option value="HISTORY">HISTORY</option>
                                    <option value="POLITICAL SCIENCE">POLITICAL SCIENCE</option>
                                    <option value="SOCIOLOGY">SOCIOLOGY</option>
                                    <option value="PT">PT</option> 
                                    <option value="HRD">HRD</option>                               
                                </select>
                            </div>
                        </div>
                        <!-- <div class="col-lg-6 col-12">
                            <div class="form-group">
                            <label for="medium">Medium of Instruction</label>
                                <select class="form-control required" id="medium" name="medium" >
                                    <option value="ENGLISH">ENGLISH</option>
                                    <option value="KANNADA">KANNADA</option>
                                    <option value="HINDI">HINDI</option>
                                </select>
                            </div>
                        </div> -->
                        <div class="col-lg-6 col-12">
                            <div class="form-group qualified_status">
                                <label for="role">Whether the student is qualified for Promotion?*</label>
                                <select class="form-control" id="qualified_status" name="qualified_status" required>
                                    <option value="YES" >YES</option>
                                    <option value="NO">NO </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group reason_unqualified">
                                <label for="role">Give reason for Unqualified Promotion?</label>
                                <select class="form-control" id="reason_unqualified" name="reason_unqualified">
                                    <option value="" >Select One Resaon</option>
                                    <option value="DISCONTINUED" >Discontinued</option>
                                    <option value="ATTENDAANCE SHORTAGE">Attendance Shortage </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="register_no" >Register Number(Exam No.)*</label>
                                <input type="text" placeholder="Register Number(Exam No.)" class="form-control" name="register_no" id="register_no" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="role">Whether the student is belongs to SC/ST?*</label>
                                <select class="form-control" id="belong_sc_st" name="belong_sc_st" required>
                                    <option value="NO">NO </option>
                                    <option value="YES" >YES</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="fee_due">whether the student has cleared all the College dues?*</label>
                                <select class="form-control" id="fee_due" name="fee_due" required>
                                    <option value="NO">NO </option>
                                    <option value="YES" >YES</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="role">Character and Conduct?*</label>
                                <select class="form-control" id="character" name="character" required>
                                    <option value="GOOD" >GOOD</option>
                                    <option value="VERY GOOD">VERY GOOD </option>
                                    <option value="SATISFIED">SATISFIED </option>
                                </select>
                            </div>
                        </div>           
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="tc_number" >TC Number*</label>
                                <input type="text" placeholder="TC Number" class="form-control" name="tc_number" id="tc_number" required>
                            </div>
                        </div> 
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="remarks" >Remarks*</label>
                                <input type="text" placeholder="Remarks" class="form-control" name="remarks" id="remarks" required>
                            </div>
                        </div> 
        </div>

            <!-- Modal footer -->
            <div class="modal-footer" style="padding:5px;">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>





<script>

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function alphaOnly(event) {
    var key = event.keyCode;
    return ((key >= 65 && key <= 90) || key == 8 || key == 32);
};

$('#qualified_status').click(function() {

var qualified_status = $('#qualified_status').val();
    if(qualified_status == "NO"){
        $('#reason_unqualified').prop('required',true);
        $('.reason_unqualified').show();
    }else{
        $('#reason_unqualified').prop('required',false);
        $('.reason_unqualified').hide();
    }
});

jQuery(document).ready(function() {

    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#byFilterMethod").attr("action", baseURL + "getStudentAppliedForTc/" + value);
        jQuery("#byFilterMethod").submit();
    });

    $('#selectAll').click(function() {
        if ($('#selectAll').is(':checked')) {
            $('.singleSelect').prop('checked', true);
        } else {
            $('.singleSelect').prop('checked', false);
        }
    });

    $('#tranfer_certificate').click(function() {
        var students = [];
        
        if ($('.singleSelect:checkbox:checked').length == 0) {
            alert("Select atleast one Student to print tranfer certificate!");
            return;
        }
        $('.singleSelect:checked').each(function(i) {
            students.push($(this).val());
        });
        var students = JSON.stringify(students);

        window.open('<?php echo base_url(); ?>getAlumniStudentsTcInfoById?row_id=' + btoa(students));

       
    });
   
});

function openModel(row_id) {

        $('.modal-title').html('Transfer Certificate <span class="float-right pl-2">  </span>');
        $.ajax({
            url: '<?php echo base_url(); ?>/getAlumniStudentTcInfo',
            type: 'POST',
            data: {
                row_id: row_id,
            },
          
            success: function(data) {
                var studentTcInfo = JSON.parse(data);
                
                if (studentTcInfo != null) {
                   
                    $('#roll_no1').val(studentTcInfo.roll_no);                   
                    $('#name1').val(studentTcInfo.name);
                    $('#tc_number1').val(studentTcInfo.tc_number);                   
                    $('#dob1').val(studentTcInfo.dob);
                    $('#nationality1').val(studentTcInfo.nationality);                   
                    $('#religion1').val(studentTcInfo.religion);
                    $('#father_name1').val(studentTcInfo.father_name);                   
                    $('#mother_name1').val(studentTcInfo.mother_name);
                    $('#date_of_admission1').val(studentTcInfo.date_of_admission);                   
                    $('#date_of_leaving1').val(studentTcInfo.date_of_leaving);
                    $('#class1').val(studentTcInfo.class);
                    $('#language_subject1').val(studentTcInfo.language_subject);                   
                    $('#optional_subject1').val(studentTcInfo.optional_subject);
                    // $('#medium1').val(studentTcInfo.medium);                   
                    $('#qualified_status1').val(studentTcInfo.qualified_status);
                    $('#reason_unqualified1').val(studentTcInfo.reason_unqualified);                   
                    $('#register_no1').val(studentTcInfo.register_no);

                    $('#belong_sc_st1').val(studentTcInfo.belong_sc_st);                   
                    $('#fee_due1').val(studentTcInfo.fee_due);
                    $('#character1').val(studentTcInfo.conduct_character);                   
                    $('#remarks1').val(studentTcInfo.remarks);
                    
                    // $('#leaving_reason').val(studentTcInfo.leaving_reason);
                    // $('#exam_month_year').val(studentTcInfo.exam_month_year);
                    // $('#character').val(studentTcInfo.character_conduct);
                    // $('#exam_result').val(studentTcInfo.exam_result);
                    // $('#issue_date').val(studentTcInfo.issue_date);
                    // $('#exam_result').val(studentTcInfo.exam_result);
                  
                    // $('#admission_date').val(studentTcInfo.date_of_admission);
                                 
                    
                   
                    // $('#leaving_date').val(appendLeadingZeroes(new Date(leaving_date).getDate()) 
                    // + "-" + appendLeadingZeroes(new Date(leaving_date).getMonth() + 1) 
                    // + "-" + appendLeadingZeroes(new Date(leaving_date).getFullYear()));

                    // $('#admission_date').val(appendLeadingZeroes(new Date(admission_date).getDate()) 
                    // + "-" + appendLeadingZeroes(new Date(admission_date).getMonth() + 1) 
                    // + "-" + appendLeadingZeroes(new Date(admission_date).getFullYear()));
                    // $("#saveTcInfo").text("Update");
                // } else {
                //     $("#saveTcInfo").text("Save");
                //     $(".reason_unqualified").hide();
                //     $('#addTcList')[0].reset();
                }
            },
            error: function(result) {
                $(".modal-title").html("Error");
            },
            fail: (function(status) {
                $(".modal-title").html("Fail");
            }),
            beforeSend: function(d) {
                // $('.modal-title').html('<center> Loading..</center>');
            }
        });

    }

</script>