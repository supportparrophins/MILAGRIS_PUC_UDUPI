<?php
$this->load->helper('form');
$error = $this->session->flashdata('error');
if ($error) {
?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $this->session->flashdata('error'); ?>
    </div>
<?php } ?>
<?php
$success = $this->session->flashdata('success');
if ($success) {
?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php } ?>

<?php
$noMatch = $this->session->flashdata('nomatch');
if ($noMatch) {
?>
    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $this->session->flashdata('nomatch'); ?>
    </div>
<?php } ?>

<div class="row">
    <div class="col-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container px-3 pt-1 overall_content">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row p-0 column_padding_card">
            <div class="col-12 column_padding_card">
                <div class="card card-small p-0 card_heading_title">
                    <div class="card-body p-2 ml-2">
                        <span class="page-title">
                            <i class="material-icons">directions_bus</i> Edit Bus Detail
                        </span>
                        <a onclick="window.history.back();" class="btn primary_color mobile-btn float-right text-white"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if (empty($busInfo)) { ?>
        <div class="row form-employee">
            <div class="col-lg-12 col-md-12 col-12 pr-0 text-center">
                <img height="270" src="<?php echo base_url(); ?>assets/images/404.png" />
            </div>
        </div>
    <?php } else {  ?>
        <!-- form start -->

        <!-- Default Light Table -->
        <div class="row form-employee">
            <div class="col-lg-12">
                <div class="card card-small c-border mb-4 ">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-2">
                            <div class="row">
                                <div class="col profile-head">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="bus-tab" data-toggle="tab" href="#bus" role="tab" aria-controls="bus" aria-selected="false">Bus Info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="service-tab" data-toggle="tab" href="#service" role="tab" aria-controls="service" aria-selected="false">Service Info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="tyre-tab" data-toggle="tab" href="#tyre" role="tab" aria-controls="tyre" aria-selected="false">Tyre Info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="spare-tab" data-toggle="tab" href="#spare" role="tab" aria-controls="spare" aria-selected="false">Spare Info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="fuel-tab" data-toggle="tab" href="#fuel" role="tab" aria-controls="fuel" aria-selected="false">Fuel Info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="trip-tab" data-toggle="tab" href="#trip" role="tab" aria-controls="trip" aria-selected="false">Trip Info</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content bus-tab" id="myTabContent">
                                        <div class="tab-pane fade show active" id="bus" role="tabpanel" aria-labelledby="bus-tab">
                                            <form role="form" action="<?php echo base_url() ?>updateBus" method="post" role="form">
                                                <input type="hidden" value="<?php echo $busInfo->row_id; ?>" name="row_id" id="row_id" />
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="card card-small c-border">
                                                            <div class="card-header p-2">
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label class="vehicle_number mdc-text-field mdc-text-field--filled">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="vehicle_number" id="vehicle_number" class="mdc-text-field__input" type="text" aria-labelledby="my-label-id" value="<?php echo $busInfo->vehicle_number; ?>" autocomplete="off" maxlength="228" required>
                                                                            <span class="mdc-floating-label" id="my-label-id">Vehicle Number</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="insurance_expiry_date mdc-text-field mdc-text-field--filled ">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="insurance_expiry_date" id="insurance_expiry_date" class="mdc-text-field__input insurance" type="text" aria-labelledby="my-label-id" value="<?php if (empty($busInfo->insurance_expiry_date) || $busInfo->insurance_expiry_date == '0000-00-00') {
                                                                                                                                                                                                                                        echo "";
                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                        echo date('d-m-Y', strtotime($busInfo->insurance_expiry_date));
                                                                                                                                                                                                                                    } ?>" autocomplete="off" required>
                                                                            <span class="mdc-floating-label" id="my-label-id">Insurance Expiry Date</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label class="emission_expiry_date mdc-text-field mdc-text-field--filled ">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="emission_expiry_date" id="emission_expiry_date" class="mdc-text-field__input service" type="text" aria-labelledby="my-label-id" value="<?php if (empty($busInfo->emission_expiry_date) || $busInfo->emission_expiry_date == '0000-00-00') {
                                                                                                                                                                                                                                    echo "";
                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                    echo date('d-m-Y', strtotime($busInfo->emission_expiry_date));
                                                                                                                                                                                                                                } ?>" autocomplete="off" required>
                                                                            <span class="mdc-floating-label" id="my-label-id">Emission Expiry Date</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="permit_date mdc-text-field mdc-text-field--filled ">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="permit_date" id="permit_date" class="mdc-text-field__input permit" type="text" aria-labelledby="my-label-id" value="<?php if (empty($busInfo->permit_date) || $busInfo->permit_date == '0000-00-00' || $busInfo->permit_date == '1970-01-01') {
                                                                                                                                                                                                                    echo "";
                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                    echo date('d-m-Y', strtotime($busInfo->permit_date));
                                                                                                                                                                                                                } ?>" autocomplete="off">
                                                                            <span class="mdc-floating-label" id="my-label-id">Permit Expiry Date</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label class="tax_expiry_date mdc-text-field mdc-text-field--filled ">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="tax_expiry_date" id="tax_expiry_date" class="mdc-text-field__input tax" type="text" aria-labelledby="my-label-id" value="<?php if (empty($busInfo->tax_expiry_date) || $busInfo->tax_expiry_date == '0000-00-00') {
                                                                                                                                                                                                                        echo "";
                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                        echo date('d-m-Y', strtotime($busInfo->tax_expiry_date));
                                                                                                                                                                                                                    } ?>" autocomplete="off" required>
                                                                            <span class="mdc-floating-label" id="my-label-id">Tax Expiry Date</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="fitness_certificate_expiry_date mdc-text-field mdc-text-field--filled ">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="fitness_certificate_expiry_date" id="fitness_certificate_expiry_date" class="mdc-text-field__input fitness" type="text" aria-labelledby="my-label-id" value="<?php if (empty($busInfo->fitness_certificate_expiry_date) || $busInfo->fitness_certificate_expiry_date == '0000-00-00' || $busInfo->fitness_certificate_expiry_date == '1970-01-01') {
                                                                                                                                                                                                                                                            echo "";
                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                            echo date('d-m-Y', strtotime($busInfo->fitness_certificate_expiry_date));
                                                                                                                                                                                                                                                        } ?>" autocomplete="off" required>
                                                                            <span class="mdc-floating-label" id="my-label-id">Fitness Certificate Expiry Date</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label class="driver_name mdc-text-field mdc-text-field--filled">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="driver_name" id="driver_name" class="mdc-text-field__input" value="<?php echo $busInfo->driver_name; ?>" type="text" maxlength="128" autocomplete="off" required>
                                                                            <span class="mdc-floating-label" id="my-label-id">Driver Name</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="driver_mobile mdc-text-field mdc-text-field--filled">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="driver_mobile" id="driver_mobile" class="mdc-text-field__input digits" value="<?php echo $busInfo->driver_mobile; ?>" type="text" maxlength="10" pattern="[0-9]{10}" onkeypress="return isNumberKey(event)" autocomplete="off" required>
                                                                            <span class="mdc-floating-label" id="my-label-id">Driver Mobile</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <!-- <label class="route mdc-text-field mdc-text-field--filled">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="route" id="route" class="mdc-text-field__input" value="<?php echo $busInfo->route; ?>" type="text" autocomplete="off" required>
                                                                            <span class="mdc-floating-label" id="my-label-id">Route</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label> -->
                                                                        <div class="mdc-select mdc-select-routeInfo form-group mb-0">
                                                                            <div class="mdc-select__anchor demo-width-class" aria-required="true">
                                                                                <span class="mdc-select__ripple"></span>
                                                                                <input type="text" class="mdc-select__selected-text" name="route" id="route" value="" required>
                                                                                <i class="mdc-select__dropdown-icon"></i>
                                                                                <span class="mdc-floating-label">Select Route</span>
                                                                                <span class="mdc-line-ripple"></span>
                                                                            </div>
                                                                            <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                                <ul class="mdc-list">
                                                                                <?php if(!empty($busInfo->route)){ ?>
                                                                                    <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $busInfo->route; ?>" aria-selected="true"><?php echo $busInfo->route; ?></li>
                                                                                <?php } ?>
                                                                                <?php   if(!empty($routeInfo)) {
                                                                                    foreach ($routeInfo as $rl) { ?>
                                                                                    <li class="mdc-list-item" data-value="<?php echo $rl->name ?>">
                                                                                        <span class="mdc-list-item__text">
                                                                                        <?php echo $rl->name ?>
                                                                                        </span>
                                                                                    </li>
                                                                                <?php } } ?>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                     
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="total_seat_capacity mdc-text-field mdc-text-field--filled">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="total_seat_capacity" id="total_seat_capacity" class="mdc-text-field__input digits" value="<?php echo $busInfo->total_seat_capacity; ?>" type="text" onkeypress="return isNumberKey(event)" maxlength="3" autocomplete="off" required>
                                                                            <span class="mdc-floating-label" id="my-label-id">Total Seat Capacity</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <button type="submit" class="btn btn-success float-right"> Update </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form> <!-- form end -->
                                        </div>
                                        <div class="tab-pane fade" id="service" role="tabpanel" aria-labelledby="service-tab">
                                            <form role="form" action="<?php echo base_url() ?>addServiceInfo" method="post" role="form">
                                                <input type="hidden" value="<?php echo $busInfo->row_id; ?>" name="row_id" id="row_id" />
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="card card-small c-border">
                                                            <div class="card-header p-2">
                                                                <div class="form-row">

                                                                    <div class="form-group col-md-6">
                                                                        <label class="service_date mdc-text-field mdc-text-field--filled ">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="service_date" id="service_date" class="mdc-text-field__input purchase" type="text" aria-labelledby="my-label-id" value="" autocomplete="off" required />
                                                                            <span class="mdc-floating-label" id="my-label-id">Service Date</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="serviceAmount mdc-text-field mdc-text-field--filled">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="amount" id="amount" class="mdc-text-field__input digits" type="text" pattern="[0-9]*" onkeypress="return isNumberKey(event)" autocomplete="off" required>
                                                                            <span class="mdc-floating-label" id="my-label-id">Service Amount</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label class="nextServiceKilometer mdc-text-field mdc-text-field--filled">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="next_service_kilometer" id="next_service_kilometer" class="mdc-text-field__input " type="text" onkeypress="return isNumberKey(event)" autocomplete="off" required>
                                                                            <span class="mdc-floating-label" id="my-label-id">Next Service Kilometer</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="serviceComments mdc-text-field mdc-text-field--filled">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="comments" id="comments" class="mdc-text-field__input" type="text" aria-labelledby="my-label-id" value="" autocomplete="off">
                                                                            <span class="mdc-floating-label" id="my-label-id">Comments(Optional)</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <button type="submit" class="btn btn-success float-right"> Add </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form> <!-- form end -->
                                            <div class="row p-0 column_padding_card">
                                                <div class="col column_padding_card">
                                                    <div class="card card-small mb-4">
                                                        <div class="card-body p-1 pb-2 table-responsive">
                                                            <table class="display table table-bordered table-striped table-hover w-100">
                                                                <thead>
                                                                    <tr class="table_row_background">
                                                                        <th class="text-center">Service Date</th>
                                                                        <th class="text-center">Service Amount</th>
                                                                        <th class="text-center">Next Service Kilometer</th>
                                                                        <th class="text-center">Comments</th>
                                                                        <th class="text-center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php if (!empty($serviceInfo)) {
                                                                        foreach ($serviceInfo as $service) { ?>
                                                                            <tr>

                                                                                <th class="text-center"><?php echo date('d-m-Y', strtotime($service->service_date)); ?></th>
                                                                                <th class="text-center"><?php echo $service->amount; ?></th>
                                                                                <th class="text-center"><?php echo $service->next_service_kilometer; ?></th>
                                                                                <th><?php echo $service->comments; ?></th>
                                                                                <th class="text-center">

                                                                                    <?php if ($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE || $role == ROLE_TRANSPORT_MANAGER) { ?>
                                                                                        <a class="btn btn-xs btn-danger deleteService" href="#" data-row_id="<?php echo $service->row_id; ?>" title="Delete Service"><i class="fa fa-trash"></i></a>
                                                                                    <?php } ?>
                                                                                </th>
                                                                            </tr>
                                                                        <?php }
                                                                    } else {  ?>
                                                                        <tr>
                                                                            <th colspan="5" class="text-center">Service Record Not Found</th>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="tyre" role="tabpanel" aria-labelledby="tyre-tab">
                                            <form role="form" action="<?php echo base_url() ?>addTyreInfo" method="post" role="form">
                                                <input type="hidden" value="<?php echo $busInfo->row_id; ?>" name="row_id" id="row_id" />
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="card card-small c-border">
                                                            <div class="card-header p-2">
                                                                <div class="form-row">

                                                                    <div class="form-group col-md-6">
                                                                        <label class="purchase_date mdc-text-field mdc-text-field--filled ">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="purchase_date" id="purchase_date" class="mdc-text-field__input purchase" type="text" aria-labelledby="my-label-id" value="" autocomplete="off" required />
                                                                            <span class="mdc-floating-label" id="my-label-id">Date</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>

                                                                    <div class="form-group col-md-6">
                                                                        <label class="amount mdc-text-field mdc-text-field--filled">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="amount" id="amount" class="mdc-text-field__input digits" type="text" pattern="[0-9]*" onkeypress="return isNumberKey(event)" autocomplete="off" required>
                                                                            <span class="mdc-floating-label" id="my-label-id">Amount</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label class="kilometer_drivenTyre mdc-text-field mdc-text-field--filled">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="kilometer_driven" id="kilometer_driven" class="mdc-text-field__input " type="text" onkeypress="return isNumberKey(event)" autocomplete="off" required>
                                                                            <span class="mdc-floating-label" id="my-label-id">Kilometer Driven</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <div class="mdc-select mdc-select-tyreType form-group mb-0">
                                                                            <div class="mdc-select__anchor demo-width-class" aria-required="true">
                                                                                <span class="mdc-select__ripple"></span>
                                                                                <input type="text" class="mdc-select__selected-text" name="tyre_type" id="tyre_type" value="" required>
                                                                                <i class="mdc-select__dropdown-icon"></i>
                                                                                <span class="mdc-floating-label">Select Tyre Type</span>
                                                                                <span class="mdc-line-ripple"></span>
                                                                            </div>
                                                                            <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                                                                <ul class="mdc-list">
                                                                                    <li class="mdc-list-item" data-value="Resole">
                                                                                        <span class="mdc-list-item__text">
                                                                                            Resole
                                                                                        </span>
                                                                                    </li>
                                                                                    <li class="mdc-list-item" data-value="New">
                                                                                        <span class="mdc-list-item__text">
                                                                                            New
                                                                                        </span>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="comments mdc-text-field mdc-text-field--filled">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="comments" id="comments" class="mdc-text-field__input" type="text" aria-labelledby="my-label-id" value="" autocomplete="off">
                                                                            <span class="mdc-floating-label" id="my-label-id">Comments(Optional)</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <button type="submit" class="btn btn-success float-right"> Add </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form> <!-- form end -->
                                            <div class="row p-0 column_padding_card">
                                                <div class="col column_padding_card">
                                                    <div class="card card-small mb-4">
                                                        <div class="card-body p-1 pb-2 table-responsive">
                                                            <table class="display table table-bordered table-striped table-hover w-100">
                                                                <thead>
                                                                    <tr class="table_row_background">
                                                                        <th class="text-center">Date</th>
                                                                        <th class="text-center">Amount</th>
                                                                        <th class="text-center">Kilometer Driven</th>
                                                                        <th class="text-center">Tyre Type</th>
                                                                        <th class="text-center">Comments</th>
                                                                        <th class="text-center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php if (!empty($tyreInfo)) {
                                                                        foreach ($tyreInfo as $tyre) { ?>
                                                                            <tr>

                                                                                <th class="text-center"><?php echo date('d-m-Y', strtotime($tyre->purchase_date)); ?></th>
                                                                                <th class="text-center"><?php echo $tyre->amount; ?></th>
                                                                                <th class="text-center"><?php echo $tyre->kilometer_driven; ?></th>
                                                                                <th class="text-center"><?php echo $tyre->tyre_type; ?></th>
                                                                                <th><?php echo $tyre->comments; ?></th>
                                                                                <th class="text-center">

                                                                                    <?php if ($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE || $role == ROLE_TRANSPORT_MANAGER) { ?>
                                                                                        <a class="btn btn-xs btn-danger deleteTyre" href="#" data-row_id="<?php echo $tyre->row_id; ?>" title="Delete Tyre"><i class="fa fa-trash"></i></a>
                                                                                    <?php } ?>
                                                                                </th>
                                                                            </tr>
                                                                        <?php }
                                                                    } else {  ?>
                                                                        <tr>
                                                                            <th colspan="6" class="text-center">Tyre Record Not Found</th>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="spare" role="tabpanel" aria-labelledby="spare-tab">
                                            <form role="form" action="<?php echo base_url() ?>addSpareInfo" method="post" role="form">
                                                <input type="hidden" value="<?php echo $busInfo->row_id; ?>" name="row_id" id="row_id" />
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="card card-small c-border">
                                                            <div class="card-header p-2">
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label class="spare_name mdc-text-field mdc-text-field--filled ">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="spare_name" id="spare_name" class="mdc-text-field__input" type="text" aria-labelledby="my-label-id" value="" autocomplete="off" required />
                                                                            <span class="mdc-floating-label" id="my-label-id">Spare Name</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                    <!-- <div class="form-group col-md-6">
                                                                        <label class="purchaseDateSpare mdc-text-field mdc-text-field--filled ">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="purchase_date" id="purchase_date" class="mdc-text-field__input " type="date" aria-labelledby="my-label-id" value="" autocomplete="off" required />
                                                                            <span class="mdc-floating-label" id="my-label-id">Purchase Date</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div> -->
                                                                    <div class="form-group col-md-6">
                                                                        <label class="kilometer_driven mdc-text-field mdc-text-field--filled">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="kilometer_driven" id="kilometer_driven" class="mdc-text-field__input digits" type="text" onkeypress="return isNumberKey(event)" autocomplete="off" required>
                                                                            <span class="mdc-floating-label" id="my-label-id">Kilometer Driven</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    
                                                                    <div class="form-group col-md-6">
                                                                        <label class="amountSpare mdc-text-field mdc-text-field--filled">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="amount" id="amount" class="mdc-text-field__input digits" type="text" pattern="[0-9]*" onkeypress="return isNumberKey(event)" autocomplete="off" required>
                                                                            <span class="mdc-floating-label" id="my-label-id">Amount</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="commentsSpare mdc-text-field mdc-text-field--filled">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="comments" id="comments" class="mdc-text-field__input" type="text" aria-labelledby="my-label-id" value="" autocomplete="off">
                                                                            <span class="mdc-floating-label" id="my-label-id">Comments(Optional)</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                              
                                                                <button type="submit" class="btn btn-success float-right"> Add </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form> <!-- form end -->
                                            <div class="row p-0 column_padding_card">
                                                <div class="col column_padding_card">
                                                    <div class="card card-small mb-4">
                                                        <div class="card-body p-1 pb-2 table-responsive">
                                                            <table class="display table table-bordered table-striped table-hover w-100">
                                                                <thead>
                                                                    <tr class="table_row_background">
                                                                        <th class="text-center">Spare Name</th>
                                                                        <!-- <th class="text-center">Purchase Date</th> -->
                                                                        <th class="text-center">Kilometer Driven</th>
                                                                        <th class="text-center">Amount</th>
                                                                        <th>Comments</th>
                                                                        <th class="text-center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php if (!empty($spareInfo)) {
                                                                        foreach ($spareInfo as $spare) { ?>
                                                                            <tr>

                                                                                <th class="text-center"><?php echo $spare->spare_name; ?></th>
                                                                                <!-- <th class="text-center"><?php echo date('d-m-Y', strtotime($spare->purchase_date)); ?></th> -->
                                                                                <th class="text-center"><?php echo $spare->kilometer_driven; ?></th>
                                                                                <th class="text-center"><?php echo $spare->amount; ?></th>
                                                                                <th><?php echo $spare->comments; ?></th>
                                                                                <th class="text-center">

                                                                                    <?php if ($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE || $role == ROLE_TRANSPORT_MANAGER) { ?>
                                                                                        <a class="btn btn-xs btn-danger deleteSpare" href="#" data-row_id="<?php echo $spare->row_id; ?>" title="Delete Spare"><i class="fa fa-trash"></i></a>
                                                                                    <?php } ?>
                                                                                </th>
                                                                            </tr>
                                                                        <?php }
                                                                    } else {  ?>
                                                                        <tr>
                                                                            <th colspan="6" class="text-center">Spare Record Not Found</th>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="tab-pane fade" id="fuel" role="tabpanel" aria-labelledby="fuel-tab">
                                            <form role="form" action="<?php echo base_url() ?>addFuelInfo" method="post" role="form">
                                                <input type="hidden" value="<?php echo $busInfo->row_id; ?>" name="row_id" id="row_id" />
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="card card-small c-border">
                                                            <div class="card-header p-2">
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label class="fuelDate mdc-text-field mdc-text-field--filled ">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="fuel_date" id="fuel_date" class="mdc-text-field__input fuel_date" type="text" aria-labelledby="my-label-id" value="" autocomplete="off" required />
                                                                            <span class="mdc-floating-label" id="my-label-id">Date</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="bill_number mdc-text-field mdc-text-field--filled ">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="bill_number" id="bill_number" class="mdc-text-field__input" type="text" aria-labelledby="my-label-id" value="" autocomplete="off" required />
                                                                            <span class="mdc-floating-label" id="my-label-id">Bill Number</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label class="liter mdc-text-field mdc-text-field--filled">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="liter" id="liter" class="mdc-text-field__input digits" type="text" onkeypress="return isNumberKey(event)" autocomplete="off" required>
                                                                            <span class="mdc-floating-label" id="my-label-id">Liter</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="liter_per_rate mdc-text-field mdc-text-field--filled">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="liter_per_rate" id="liter_per_rate" class="mdc-text-field__input digits" onkeypress="return isNumberKey(event)" type="text" autocomplete="off" required>
                                                                            <span class="mdc-floating-label" id="my-label-id">Liter/Rate</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label class="fuel_kilometer mdc-text-field mdc-text-field--filled">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="fuel_kilometer" id="fuel_kilometer" class="mdc-text-field__input digits" type="text" onkeypress="return isNumberKey(event)" autocomplete="off" required>
                                                                            <span class="mdc-floating-label" id="my-label-id">Kilometer Driven</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="amountFuel mdc-text-field mdc-text-field--filled">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="amount" id="amount" class="mdc-text-field__input digits" type="text" onkeypress="return isNumberKey(event)" autocomplete="off" required>
                                                                            <span class="mdc-floating-label" id="my-label-id">Amount</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>

                                                                </div>
                                                                <button type="submit" class="btn btn-success float-right"> Add </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form> <!-- form end -->
                                            <div class="row p-0 column_padding_card">
                                                <div class="col column_padding_card">
                                                    <div class="card card-small mb-4">
                                                        <div class="card-body p-1 pb-2 table-responsive">
                                                            <table class="display table table-bordered table-striped table-hover w-100">
                                                                <thead>
                                                                    <tr class="table_row_background">
                                                                        <th class="text-center">Date</th>
                                                                        <th class="text-center">Bill Number</th>
                                                                        <th class="text-center">Liter</th>
                                                                        <th class="text-center">Liter/Rate</th>
                                                                        <th class="text-center">Kilometer Driven</th>
                                                                        <th class="text-center">Amount</th>
                                                                        <th class="text-center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php if (!empty($fuelInfo)) {
                                                                        foreach ($fuelInfo as $fuel) { ?>
                                                                            <tr>

                                                                                <th class="text-center"><?php echo date('d-m-Y', strtotime($fuel->fuel_date)); ?></th>
                                                                                <th class="text-center"><?php echo $fuel->bill_number; ?></th>
                                                                                <th class="text-center"><?php echo $fuel->liter; ?></th>
                                                                                <th class="text-center"><?php echo $fuel->liter_per_rate; ?></th>
                                                                                <th class="text-center"><?php echo $fuel->fuel_kilometer; ?></th>
                                                                                <th class="text-center"><?php echo $fuel->amount; ?></th>
                                                                                <th class="text-center">
                                                                                    <?php if ($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE || $role == ROLE_TRANSPORT_MANAGER) { ?>
                                                                                        <a class="btn btn-xs btn-danger deleteFuel" href="#" data-row_id="<?php echo $fuel->row_id; ?>" title="Delete Fuel"><i class="fa fa-trash"></i></a>
                                                                                    <?php } ?>
                                                                                </th>
                                                                            </tr>
                                                                        <?php }
                                                                    } else {  ?>
                                                                        <tr>
                                                                            <th colspan="6" class="text-center">Fuel Record Not Found</th>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="tab-pane fade" id="trip" role="tabpanel" aria-labelledby="trip-tab">
                                            <form role="form" action="<?php echo base_url() ?>addTripInfo" method="post" role="form">
                                                <input type="hidden" value="<?php echo $busInfo->row_id; ?>" name="row_id" id="row_id" />
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="card card-small c-border">
                                                            <div class="card-header p-2">
                                                                <div class="form-row">

                                                                    <div class="form-group col-md-6">
                                                                        <label class="trip_date mdc-text-field mdc-text-field--filled ">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="trip_date" id="trip_date" class="mdc-text-field__input purchase" type="text" aria-labelledby="my-label-id" value="" autocomplete="off" required />
                                                                            <span class="mdc-floating-label" id="my-label-id">Trip Date</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="start_meter mdc-text-field mdc-text-field--filled">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="start_meter" id="start_meter" class="mdc-text-field__input " type="text" onkeypress="return isNumberKey(event)" autocomplete="off" required>
                                                                            <span class="mdc-floating-label" id="my-label-id">Start Meter</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="end_meter mdc-text-field mdc-text-field--filled">
                                                                            <span class="mdc-text-field__ripple"></span>
                                                                            <input name="end_meter" id="end_meter" class="mdc-text-field__input " type="text" onkeypress="return isNumberKey(event)" autocomplete="off" required>
                                                                            <span class="mdc-floating-label" id="my-label-id">End Meter</span>
                                                                            <span class="mdc-line-ripple"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <button type="submit" class="btn btn-success float-right"> Add </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form> <!-- form end -->
                                            <div class="row p-0 column_padding_card">
                                                <div class="col column_padding_card">
                                                    <div class="card card-small mb-4">
                                                        <div class="card-body p-1 pb-2 table-responsive">
                                                            <table class="display table table-bordered table-striped table-hover w-100">
                                                                <thead>
                                                                    <tr class="table_row_background">
                                                                        <th class="text-center">Trip Date</th>
                                                                        <th class="text-center">Start Meter</th>
                                                                        <th class="text-center">End Meter</th>
                                                                        <th class="text-center">Total Kilometres</th>
                                                                        <th class="text-center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php if (!empty($tripInfo)) {
                                                                        foreach ($tripInfo as $trip) { ?>
                                                                            <tr>

                                                                                <th class="text-center"><?php echo date('d-m-Y', strtotime($trip->trip_date)); ?></th>
                                                                                <th class="text-center"><?php echo $trip->start_meter; ?></th>
                                                                                <th class="text-center"><?php echo $trip->end_meter; ?></th>
                                                                                <th class="text-center"><?php if ($trip->start_meter > $trip->end_meter) {
                                                                                                            echo (($trip->start_meter) - ($trip->end_meter));
                                                                                                        } else {
                                                                                                            echo (($trip->end_meter) - ($trip->start_meter));
                                                                                                        } ?></th>
                                                                                <th class="text-center">

                                                                                    <?php if ($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE || $role == ROLE_TRANSPORT_MANAGER) { ?>
                                                                                        <a class="btn btn-xs btn-danger deleteTrip" href="#" data-row_id="<?php echo $trip->row_id; ?>" title="Delete Trip"><i class="fa fa-trash"></i></a>
                                                                                    <?php } ?>
                                                                                </th>
                                                                            </tr>
                                                                        <?php }
                                                                    } else {  ?>
                                                                        <tr>
                                                                            <th colspan="5" class="text-center">Trip Record Not Found</th>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>



                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    <?php } ?>
    <!-- End Default Light Table -->
</div>
<script src="<?php echo base_url(); ?>assets/js/transport.js" type="text/javascript"></script>
<script type="text/javascript">
    function GoBackWithRefresh(event) {
    if ('referrer' in document) {
        window.location = document.referrer;
        /* OR */
        //location.replace(document.referrer);
    } else {
        window.history.back();
    }
}

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    jQuery(document).ready(function() {

        jQuery('.insurance,.service,.permit,.purchase,.purchaseSpare,.fuel_date,.tax,.fitness').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",

        });
        mdc.textField.MDCTextField.attachTo(document.querySelector('.vehicle_number'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.service_date'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.emission_expiry_date'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.insurance_expiry_date'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.permit_date'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.tax_expiry_date'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.fitness_certificate_expiry_date'));
        // mdc.textField.MDCTextField.attachTo(document.querySelector('.route'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.driver_name'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.driver_mobile'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.total_seat_capacity'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.purchase_date'));
       
        mdc.textField.MDCTextField.attachTo(document.querySelector('.amount'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.comments'));
       // mdc.textField.MDCTextField.attachTo(document.querySelector('.purchaseDateSpare'));
        mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-tyreType'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.spare_name'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.kilometer_driven'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.kilometer_drivenTyre'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.amountSpare'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.commentsSpare'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.serviceAmount'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.serviceComments'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.nextServiceKilometer'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.fuelDate'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.bill_number'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.fuel_kilometer'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.liter'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.liter_per_rate'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.amountFuel'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.trip_date'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.start_meter'));
        mdc.textField.MDCTextField.attachTo(document.querySelector('.end_meter'));
        mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-routeInfo'));
        
    });
</script>