
<div class="main-content-container container-fluid px-4 pt-2">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card card-small p-0 card_heading_title">
                    <div class="card-body p-1 card-content-title">
                        <div class="row ">
                            <div class="col-lg-8 col-md-8 col-8 text-black" style="font-size:22px;">
                                <i class="fa fa-users"></i>&nbsp; Mun Event Details
                            </div>
                            <div class="col-lg-4 col-md-4 col-4"> 
                                <!-- <a href="#" onclick="GoBackWithRefresh();return false;" class="btn text-white primary_color btn-bck float-right mobile-bck ">
                                <i class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Back </a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row form-employee">
            <div class="col-12">
                <div class="card card-small c-border p-0 mb-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-1">
                            <div class="row">
                                <div class="col profile-head">
                                    <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="personal-tab" data-toggle="tab"
                                                href="#personal" role="tab" aria-controls="personal"
                                                aria-selected="false">Personal Info</a>
                                        </li>
                                    </ul> -->
                                    <div class="tab-content personal-tab" id="myTabContent">
                                        <div class="tab-pane fade show active" id="personal" role="tabpanel"
                                            aria-labelledby="personal-tab">
                                            <div class="row">
                                                <div class="col-12 col-lg-6 col-md-6 mb-2">
                                                    <div class="table-responsive">
                                                        <table class="table text-dark">
                                                            <tr>
                                                                <th>College Name : <?php echo $registerInfo->college_name; ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th>Registration Type : <?php echo $eventReg->registeration_type; ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th>Mobile No. : <?php echo $registerInfo->mobile; ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th>Email : <?php echo $registerInfo->email; ?></th>
                                                            </tr>
                                                            <?php if($eventReg->total_students != 1){ ?>
                                                            <tr>
                                                                <th>Total Students : <?php echo $eventReg->total_students; ?></th>
                                                            </tr>
                                                            <?php } ?>
                                                        </table>
                                                    </div>
                                                </div>

                                                <?php if($eventReg->registeration_type == 'INSTITUTION Delegation' || $eventReg->registeration_type == 'PRIVATE Delegation'){ 
                                                    if(!empty($inchargeInfo)){ ?>
                                                    <div class="col-12 col-lg-6 col-md-6 mb-2">
                                                        <div class="mb-1">
                                                            <div class="card p-2 font-weight-bold" style="background: #b8ebf4;">Incharge Details</div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header text-center p-1">
                                                                <img src="<?php echo MUN_EVENT_PATH.$inchargeInfo->id_url; ?>" width="200" height="150"/>
                                                            </div>
                                                            <div class="card-footer p-1 text-dark">
                                                                <p class="mb-0 font-weight-bold">Name : <?php echo $inchargeInfo->incharge_name; ?></p>
                                                                <p class="mb-0 font-weight-bold">Class : <?php echo $inchargeInfo->mobile_no; ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } } ?>
                                            </div>
                                            
                                            <?php if(!empty($participantInfo)){ ?>
                                            <div class="row">
                                                <div class="col-12 mb-1">
                                                    <div class="card p-2 font-weight-bold" style="background: #b8ebf4;">Participant Details</div>
                                                </div>
                                                <?php foreach($participantInfo as $part){ ?>
                                                    <div class="col-12 col-lg-4 col-md-4 mb-2">
                                                        <div class="card">
                                                            <div class="card-header text-center p-1">
                                                                <img src="<?php echo MUN_EVENT_PATH.$part->student_id_url; ?>" style="width: 100%;" height="180"/>
                                                            </div>
                                                            <div class="card-footer p-1 text-dark">
                                                                <p class="mb-0 font-weight-bold">Name : <?php echo $part->student_name; ?></p>
                                                                <p class="mb-0 font-weight-bold">Class : <?php echo $part->class; ?></p>
                                                                <p class="mb-0 font-weight-bold">Institution : <?php echo $part->institution_name; ?></p>
                                                                <!-- <p class="mb-0 font-weight-bold">DOB : <?php echo date('d-m-Y',strtotime($part->dob)); ?></p> -->
                                                                <p class="mb-0 font-weight-bold">Email : <?php echo $part->email; ?></p>
                                                                <p class="mb-0 font-weight-bold">whatsapp No. : <?php echo $part->whatsapp_no; ?></p>
                                                                <p class="mb-0 font-weight-bold">Country : <?php echo $part->country_name; ?></p>
                                                                <p class="mb-0 font-weight-bold">Preferred Allotment First : <?php echo $part->preferred_allotments; ?></p>
                                                                <!-- <p class="mb-0 font-weight-bold">Preferred Allotment Second : <?php echo $part->preferred_allotments_2; ?></p> -->
                                                                <p class="mb-0 font-weight-bold">Achievements : <?php echo $part->past_mun_achievements; ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <?php } ?>
                                            
                                        </div>

                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Default Light Table -->
        
    </div>
</div>
<script type="text/javascript">
function GoBackWithRefresh(event) {
    showLoader();
    if ('referrer' in document) {
        window.location = document.referrer;
        /* OR */
        //location.replace(document.referrer);
    } else {
        window.history.back();
    }
}
jQuery(document).ready(function() {

    jQuery('.resetFilters').click(function() {
        $(this).closest('form').find("input[type=text]").val("");
    })
});
</script>
