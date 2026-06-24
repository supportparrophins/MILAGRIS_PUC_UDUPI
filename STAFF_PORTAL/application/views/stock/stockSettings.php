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
<div class="row">
    <div class="col-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container  px-3">
    <!-- Page Header -->
    <!-- Page Header -->

    <div class="row mt-1 mb-2">
      <div class="col column_padding_card">
        <div class="card card_heading_title card-small p-0">
          <div class="card-body p-2 ml-2">
            <div class="row c-m-b">
              <div class="col-lg-9 col-sm-9 col-9">
                <span class="page-title absent_table_title_mobile">
                  <i class="material-icons">settings</i> Stock Setting
                </span>
              </div>
              <div class="col-lg-3 col-sm-3 col-3 box-tools">
                <a onclick="window.history.back();" class="btn btn_back mobile-btn float-right text-white pt-2" style="background-color:brown;"
                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
       <div class="col-lg-12 col-md-12 col-12 mb-2 padding_left_right_null">
            <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse"
                data-target="#addStockName">
                <a class="float-right mb-0 setting_pointer">Click here </a>
                <h6 class="m-0 text-dark">Stock Name Info</h6>
            </div>
            <div id="addStockName" class="">
                <div class="card card-small h-100">
                    <div class="card-body d-flex flex-column p-1">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addStockName" action="<?php echo base_url() ?>addStockName"
                            method="post">
                            <div class="row form-contents">
                               
                                <div class="col-2">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" id="item_code" name="item_code"
                                            placeholder="Item Code" autocomplete="off" autofocus required>
                                        </div>
                                     </div>
                                      <div class="col-2">
                                    <div class="form-group mb-1">
                                        <input type="text" class="form-control" id="addStockName" name="stock_name"
                                            placeholder="Name" autocomplete="off" required>
                                    </div>
                                   </div>
                                    
                                <div class="col-2">
                                  <div class="form-group mb-0">
                                    <select id="type_id" name="type_id" class="form-control required "  required autocomplete="off">
                                     <option value="">Select Stock Type</option>
                                    <?php if(!empty($stockTypeInfo)){
                                        foreach($stockTypeInfo as $record){ ?>
                                    <option value="<?php echo $record->row_id; ?>"><?php echo $record->stock_type; ?></option>
                                    <?php } } ?>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-2">
                                  <div class="form-group mb-0">
                                    <select id="product_id" name="product_id" class="form-control required "  required autocomplete="off">
                                     <option value="">Select Company</option>
                                    <?php if(!empty($stockProductInfo)){
                                        foreach($stockProductInfo as $record){ ?>
                                    <option value="<?php echo $record->row_id; ?>"><?php echo $record->product_name; ?></option>
                                    <?php } } ?>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-2">
                                  <div class="form-group mb-0">
                                    <select id="scale_id" name="scale_id" class="form-control required "  required autocomplete="off">
                                     <option value="">Select Stock Scale</option>
                                    <?php if(!empty($stockScaleInfo)){
                                        foreach($stockScaleInfo as $record){ ?>
                                    <option value="<?php echo $record->row_id; ?>"><?php echo $record->stock_scale; ?></option>
                                    <?php } } ?>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-2 mb-1">
                                    <input type="submit" class="btn btn-block btn-sm btn-success float-right" value="Save" />
                                </div>
                            </div>
                        </form>
                        <div class="col-lg-12 col-12 p-0 mt-0 ">
                            <table class="table table-bordered text-dark mb-0">
                                <thead class="text-center">
                                    <tr class="table_row_background">
                                        <th>Item Code</th>
                                        <th>Stock Name</th>
                                        <th>Stock Type</th>
                                        <th>Company Name</th>
                                        <th>Stock Scale</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php if(!empty($stockNameInfo)){
                                        foreach($stockNameInfo as $record){ ?>
                                    <tr class="text-dark">
                                        <td><?php echo $record->item_code; ?></td>
                                        <td><?php echo $record->stock_name; ?></td>
                                        <td><?php echo $record->stock_type; ?></td>
                                        <td><?php echo $record->product_name; ?></td>
                                        <td><?php echo $record->stock_scale; ?></td>
                                        <td>
                                            <a class="btn btn-xs btn-danger deleteStockName" href="#"
                                                data-stock_id="<?php echo $record->stock_id; ?>" title="Delete"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php } }else{ ?>
                                    <tr class="text-dark card_head_dashboard">
                                        <td colspan="6">Stock Name Record Not Found!</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
                <!-- End Quick Post -->
        </div>

        <div class="col-lg-6 col-md-6 col-12 mb-2 padding_left_right_null">
            <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse"
                data-target="#addStockType">
                <a class="float-right mb-0 setting_pointer">Click here </a>
                <h6 class="m-0 text-dark">Stock Type Info</h6>
            </div>
            <div id="addStockType" class="collapse">
                <div class="card card-small h-100">
                    <div class="card-body d-flex flex-column p-1">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addStockType" action="<?php echo base_url() ?>addStockType"
                            method="post">
                            <div class="row form-contents">
                                <div class="col-8">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" id="addStockType" name="stock_type"
                                            placeholder="Enter Stock Type" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-4 mb-1">
                                    <input type="submit" class="btn btn-block btn-success float-right" value="Save" />
                                </div>
                            </div>
                        </form>
                        <div class="col-lg-12 col-12 p-0 mt-0 ">
                            <table class="table table-bordered text-dark mb-0">
                                <thead class="text-center">
                                    <tr class="table_row_background">
                                        <th>Stock Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php if(!empty($stockTypeInfo)){
                                        foreach($stockTypeInfo as $record){ ?>
                                    <tr class="text-dark">
                                        <td><?php echo $record->stock_type; ?></td>
                                        <td>
                                            <a class="btn btn-xs btn-danger deleteStockType" href="#"
                                                data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php } }else{ ?>
                                    <tr class="text-dark card_head_dashboard">
                                        <td colspan="2">Stock Type Record Not Found!</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
                <!-- End Quick Post -->
        </div>

       

        <div class="col-lg-6 col-md-6 col-12 mb-2 padding_left_right_null">
            <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse"
                data-target="#addStockDepartment">
                <a class="float-right mb-0 setting_pointer">Click here </a>
                <h6 class="m-0 text-dark">Stock Department Info</h6>
            </div>
            <div id="addStockDepartment" class="collapse">
                <div class="card card-small h-100">
                    <div class="card-body d-flex flex-column p-1">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addStockDepartment" action="<?php echo base_url() ?>addStockDepartment"
                            method="post">
                            <div class="row form-contents">
                                <div class="col-8">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" id="stock_department" name="stock_department"
                                            placeholder="Enter Stock Department" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-4 mb-1">
                                    <input type="submit" class="btn btn-block btn-success float-right" value="Save" />
                                </div>
                            </div>
                        </form>
                        <div class="col-lg-12 col-12 p-0 mt-0 ">
                            <table class="table table-bordered text-dark mb-0">
                                <thead class="text-center">
                                    <tr class="table_row_background">
                                        <th>Stock Department</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php if(!empty($stockDepartmentInfo)){
                                        foreach($stockDepartmentInfo as $record){ ?>
                                    <tr class="text-dark">
                                        <td><?php echo $record->stock_department; ?></td>
                                        <td>
                                            <a class="btn btn-xs btn-danger deleteStockDepartment" href="#"
                                                data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php } }else{ ?>
                                    <tr class="text-dark card_head_dashboard">
                                        <td colspan="2">Stock Department Record Not Found!</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
                <!-- End Quick Post -->
        </div>

        <div class="col-lg-6 col-md-6 col-12 mb-2 padding_left_right_null">
            <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse"
                data-target="#addStockProduct">
                <a class="float-right mb-0 setting_pointer">Click here </a>
                <h6 class="m-0 text-dark">Company Name Info</h6>
            </div>
            <div id="addStockProduct" class="collapse">
                <div class="card card-small h-100">
                    <div class="card-body d-flex flex-column p-1">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addStockProduct" action="<?php echo base_url() ?>addStockProduct"
                            method="post">
                            <div class="row form-contents">
                                <div class="col-8">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" id="product_name" name="product_name"
                                            placeholder="Enter Stock Company" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-4 mb-1">
                                    <input type="submit" class="btn btn-block btn-success float-right" value="Save" />
                                </div>
                            </div>
                        </form>
                        <div class="col-lg-12 col-12 p-0 mt-0 ">
                            <table class="table table-bordered text-dark mb-0">
                                <thead class="text-center">
                                    <tr class="table_row_background">
                                        <th>Stock Company</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php if(!empty($stockProductInfo)){
                                        foreach($stockProductInfo as $record){ ?>
                                    <tr class="text-dark">
                                        <td><?php echo $record->product_name; ?></td>
                                        <td>
                                            <a class="btn btn-xs btn-danger deleteStockProduct" href="#"
                                                data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php } }else{ ?>
                                    <tr class="text-dark card_head_dashboard">
                                        <td colspan="2">Company Name Record Not Found!</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
                <!-- End Quick Post -->
        </div>

    </div>
 </div>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/stock.js" charset="utf-8"></script>
<script>
function isNumberKey(evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 &&
      (charCode < 48 || charCode > 57))
      return false;
  return true;
}

jQuery(document).ready(function() {
    $('select').selectpicker();
});
</script>