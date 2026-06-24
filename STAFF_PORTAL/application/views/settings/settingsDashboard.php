<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

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
  <strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
</div>
<?php }?>
<div class="row column_padding_card">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container  px-3">

    <div class="row mt-1 mb-2">
      <div class="col column_padding_card">
        <div class="card card_heading_title card-small p-0">
          <div class="card-body p-2 ml-2">
            <div class="row c-m-b">
              <div class="col-lg-9 col-sm-9 col-9">
                <span class="page-title absent_table_title_mobile">
                  <i class="material-icons">settings</i>Admin Settings
                </span>
              </div>
              <div class="col-lg-3 col-sm-3 col-3 box-tools">
                <a onclick="showLoader();window.history.back();" class="btn primary_color mobile-btn float-right text-white pt-2"
                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



    <div class="row ">
      <?php if($staffID == '123456'){
      ?>
      <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#moduleManagement">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Module Management</h6>
        </div>
        <div id="moduleManagement" class="collapse">
          <div class="card card-small h-100">
        <div class="card-body d-flex flex-column p-1">
          <?php $this->load->helper("form"); ?>
          <form role="form" id="addModule" action="<?php echo base_url() ?>addModule" method="post" role="form">
        <div class="row form-contents">
          <div class="col-6">
        <div class="form-group mb-0">
          <input type="text" class="form-control" id="menu_name" name="menu_name" placeholder="Enter Module Name" autocomplete="off" required>
        </div>
          </div>
            <div class="col-6  mb-1">
        <div class="form-group mb-0">
          <input type="number" class="form-control" id="priority" name="priority" placeholder="Priority" autocomplete="off" required>
        </div>
          </div>
          <div class="col-6  mb-1">
        <div class="form-group mb-0">
          <input type="text" class="form-control" id="icon" name="icon" placeholder="Enter Icon HTML" autocomplete="off" required>
        </div>
          </div>
        
          <div class="col-6 mb-1">
        <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
          </div>
        </div>
          </form>
          <div class="row mx-0">
        <div class="col-lg-12 col-12 p-0 mt-0">
          <table class="table table-bordered text-dark mb-0">
        <thead class="text-center">
          <tr class="table_row_background">
        <th>Module Name</th>
        <th>Icon</th>
        <th>Priority</th>
        <th>Action</th>
          </tr>
          <?php if(!empty($moduleInfo)){
        foreach($moduleInfo as $module){ ?>
          <tr class="text-dark">
        <td><input type="text" class="form-control module-name-input" value="<?php echo $module->menu_name; ?>" data-module-id="<?php echo $module->row_id; ?>"></td>
        <td><?php echo $module->icon; ?></td>
        <td><input type="number" class="form-control module-priority-input" style="width: 80px;" value="<?php echo $module->priority; ?>" data-module-id="<?php echo $module->row_id; ?>"></td>
        <td>
          <a class="btn btn-xs btn-success updateModule" href="#" data-row_id="<?php echo $module->row_id; ?>" title="Update"><i class="fa fa-save"></i></a>
          <a class="btn btn-xs btn-danger deleteModule" href="#" data-row_id="<?php echo $module->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
        </td>
          </tr>
          <?php } }else{ ?>
        <tr>
          <td colspan="4" style="background-color: #e3cfff;">No Modules Found</td>
        </tr>
          <?php } ?>
        </thead>
          </table>
        </div>
          </div>
        </div>
          </div> <!-- Card End -->
        </div> <!--collapse End -->
      </div>
        <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#subModuleManagement">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Sub Module Management</h6>
        </div>
        <div id="subModuleManagement" class="collapse">
          <div class="card card-small h-100">
        <div class="card-body d-flex flex-column p-1">
          <?php $this->load->helper("form"); ?>
          <form role="form" id="addSubModule" action="<?php echo base_url() ?>addSubModule" method="post" role="form">
        <div class="row form-contents">
          <div class="col-6 mb-1">
        <div class="form-group mb-0">
          <select class="form-control selectpicker" id="module_id" name="module_id" data-live-search="true" required>
        <option value="">Select Module</option>
        <?php if(!empty($moduleInfo)){
          foreach($moduleInfo as $module){ ?>
        <option value="<?php echo $module->row_id; ?>"><?php echo $module->menu_name; ?></option>
        <?php } } ?>
          </select>
        </div>
          </div>
          <div class="col-6">
        <div class="form-group mb-0">
          <input type="text" class="form-control" id="sub_menu_name" name="sub_menu_name" placeholder="Enter Sub Module Name" autocomplete="off" required>
        </div>
          </div>
          <div class="col-6 mb-1">
        <div class="form-group mb-0">
            <input type="text" class="form-control" id="icon" name="icon" placeholder="Enter Icon HTML" autocomplete="off" required>
        </div>
          </div>
          <div class="col-6 mb-1">
        <div class="form-group mb-0">
          <input type="text" class="form-control" id="link" name="link" placeholder="Enter Link URL" autocomplete="off" required>
        </div>
          </div>
        <div class="col-6 mb-1">
        <div class="form-group mb-0">
          <input type="number" class="form-control" id="priority" name="priority" placeholder="Priority" autocomplete="off" required>
        </div>
          </div>
          <div class="col-6 mb-1">
        <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add Sub Module" />
          </div>
        </div>
          </form>
          <div class="row mx-0">
        <div class="col-lg-12 col-12 p-0 mt-0">
          <div class="form-group">
        <select class="form-control selectpicker" id="filter_module" data-dropup-auto="false" data-live-search="true" name="filter_module">
          <option value="">Show All Sub Modules</option>
          <?php if(!empty($moduleInfo)){
        foreach($moduleInfo as $module){ ?>
          <option value="<?php echo $module->row_id; ?>"><?php echo $module->menu_name; ?></option>
          <?php } } ?>
        </select>
          </div>
          <table class="table table-bordered text-dark mb-0" id="subModuleTable">
        <thead class="text-center">
          <tr class="table_row_background">
        <th>Sub Module Name</th>
        <th>Icon</th>
        <th>Link</th>
        <th>Priority</th>
        <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if(!empty($subModuleInfo)){
        foreach($subModuleInfo as $subModule){ 
          $moduleName = "";
          foreach($moduleInfo as $module){
        if($module->row_id == $subModule->module_id){
          $moduleName = $module->menu_name;
          break;
        }
          }
        ?>
          <tr class="text-dark" data-module-id="<?php echo $subModule->module_id; ?>">
        <td><input type="text" class="form-control submodule-name-input" value="<?php echo $subModule->menu_name; ?>" data-submodule-id="<?php echo $subModule->row_id; ?>"></td>
         <td><?php echo $subModule->icon; ?></td>
        <td><input type="text" class="form-control submodule-link-input" value="<?php echo $subModule->redirect_url; ?>" data-submodule-id="<?php echo $subModule->row_id; ?>"></td>
        <td><input type="number" class="form-control submodule-priority-input" style="width: 60px;" value="<?php echo $subModule->priority; ?>" data-submodule-id="<?php echo $subModule->row_id; ?>"></td>
        <td>
          <a class="btn btn-xs btn-success updateSubModule" href="#" data-row_id="<?php echo $subModule->row_id; ?>" title="Update"><i class="fa fa-save"></i></a>
          <a class="btn btn-xs btn-danger deleteSubModule" href="#" data-row_id="<?php echo $subModule->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
        </td>
          </tr>
          <?php } }else{ ?>
        <tr>
          <td colspan="5" style="background-color: #e3cfff;">No Sub Modules Found</td>
        </tr>
          <?php } ?>
        </tbody>
          </table>
        </div>
          </div>
        </div>
          </div> <!-- Card End -->
        </div> <!--collapse End -->
      </div>

         <?php } ?>
      <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#caste">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Caste Info</h6>
        </div>
        <div id="caste" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="addCast" action="<?php echo base_url() ?>addCaste" method="post" role="form">
                <div class="row form-contents">
                  <div class="col-8">
                    <div class="form-group mb-0">
                      <input type="text" class="form-control" id="caste" name="caste" placeholder="Enter Caste" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-4 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                      <tr class="table_row_background">
                        <th>Caste</th>
                        <th>Action</th>
                      </tr>
                      <?php if(!empty($casteInfo)){
                        foreach($casteInfo as $caste){ ?>
                      <tr class="text-dark">
                        <td><?php echo $caste->name; ?></td>
                        <td>
                          <a class="btn btn-xs btn-danger deleteCaste" href="#" data-row_id="<?php echo $caste->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                      <?php } }else{ ?>
                        <td colspan="2" style="background-color: #e3cfff;">Caste Not Found</td>
                      <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div> <!-- Card End -->
        </div> <!--collapse End -->
      </div>
      <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#religion">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Religion Info</h6>
        </div>
        <div id="religion" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="addReligion" action="<?php echo base_url() ?>addReligion" method="post" role="form">
                <div class="row form-contents">
                  <div class="col-8">
                    <div class="form-group mb-0">
                      <input type="text" class="form-control" id="religion" name="religion" placeholder="Enter Religion" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-4 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                      <tr class="table_row_background">
                        <th>Religion</th>
                        <th>Action</th>
                      </tr>
                      <?php if(!empty($religionInfo)){
                        foreach($religionInfo as $record){ ?>
                      <tr class="text-dark">
                        <td><?php echo $record->name; ?></td>
                        <td>
                          <a class="btn btn-xs btn-danger deleteReligion" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                      <?php } }else{ ?>
                        <td colspan="2" style="background-color: #e3cfff;">Religion Not Found</td>
                      <?php } ?>
                    </thead>
                  </table>
                </div>   
              </div>
            </div>
          </div>
        </div>
        <!-- End Quick Post -->
      </div>
      <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#nationality">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Nationality Info</h6>
        </div>
        <div id="nationality" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
                <?php $this->load->helper("form"); ?>
                <form role="form" id="addNationality" action="<?php echo base_url() ?>addNationality" method="post" role="form">
                    <div class="row form-contents">
                        <div class="col-8">
                            <div class="form-group mb-0">
                                <input type="text" class="form-control" id="nationality" name="nationality" placeholder="Enter Nationality" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-4 mb-1">
                            <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                        </div>
                    </div>
                </form>
                <div class="row mx-0">
                  <div class="col-lg-12 col-12 p-0 mt-0 ">
                    <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                        <tr class="table_row_background">
                            <th>Nationality</th>
                            <th>Action</th>
                        </tr>
                        <?php if(!empty($nationalityInfo)){
                            foreach($nationalityInfo as $record){ ?>
                        <tr class="text-dark">
                            <td><?php echo $record->name; ?></td>
                            <td>
                                <a class="btn btn-xs btn-danger deleteNationality" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php } }else{ ?>
                          <td colspan="2" style="background-color: #e3cfff;">Nationality Not Found</td>
                        <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#department">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Department Info</h6>
        </div>
        <div id="department" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" action="<?php echo base_url() ?>addDepartment" method="post" role="form">
                <div class="row form-contents">
                  <div class="col-4 col-lg-3 pr-1">
                    <div class="form-group mb-0">
                      <input type="text" class="form-control" id="dept_id" name="dept_id"
                      placeholder="Dept. ID" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-4 col-lg-5 pl-1 pr-1">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" id="dept_name" name="dept_name" placeholder="Department Name" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-4 mb-1 col-lg-4 pl-1">
                      <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                      <tr class="table_row_background">
                        <th>Dept. ID</th>
                        <th>Dept. Name</th>
                        <th>Action</th>
                      </tr>
                      <?php if(!empty($departmentInfo)){
                          foreach($departmentInfo as $dept){ ?>
                      <tr class="text-dark">
                        <td><?php echo $dept->dept_id; ?></td>
                        <td><?php echo $dept->name; ?></td>
                        <td>
                          <a class="btn btn-xs btn-danger deleteDepartment" href="#" data-row_id="<?php echo $dept->id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                      <?php } }else{ ?>
                        <td colspan="3" style="background-color: #e3cfff;">Department Not Found</td>
                      <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Top Notification Section -->
      <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#category">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Category Info</h6>
        </div>
        <div id="category" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="addCategory" action="<?php echo base_url() ?>addCategory" method="post" role="form">
                <div class="row form-contents">
                  <div class="col-8">
                    <div class="form-group mb-0">
                      <input type="text" class="form-control" id="category" name="category" placeholder="Enter Category" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-4 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                        <tr class="table_row_background">
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                        <?php if(!empty($categoryInfo)){
                            foreach($categoryInfo as $record){ ?>
                        <tr class="text-dark">
                          <td><?php echo $record->category_name; ?></td>
                          <td>
                            <a class="btn btn-xs btn-danger deleteCategory" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                        <?php } }else{ ?>
                          <tr class="text-dark">
                            <td colspan="2" style="background-color: #e3cfff;">Category Not Found</td>
                          </tr>
                        <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#classTimings">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Class Timings Info</h6>
        </div>
        <div id="classTimings" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="addClassTimings" action="<?php echo base_url() ?>addClassTimings" method="post" role="form">
                <div class="row form-contents">
                  <div class="col-6 pr-1">
                    <div class="form-group mb-2">
                      <select name="week_id" id="week_id" class="form-control" data-live-search="true" autocomplete="off" required>
                        <option value="">Select Week Name</option>
                        <?php if(!empty($weekName)){
                          foreach($weekName as $record){ ?>
                            <option value="<?php echo $record->row_id ?>">
                              <?php echo $record->week_name ?> 
                            </option>
                        <?php }  } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-6 pr-1 mb-2">
                    <div class="input-group mb-0">
                      <select required id="start_time_hh" name="start_time_hh" class="form-control" >
                        <?php if(!empty($leaveInfo->departureTime)){ ?>
                            <option value="<?php echo date('h',strtotime($leaveInfo->departureTime)); ?>"><?php echo date('h',strtotime($leaveInfo->departureTime)); ?></option>
                        <?php } ?>
                        <option value="">Select Hour</option>
                        <?php for($i=1; $i<13; $i++){ ?>
                          <option value="<?php echo sprintf('%02d',$i); ?>"><?php echo sprintf('%02d',$i); ?></option>
                        <?php } ?>
                      </select>
                      <select required id="start_time_mm" name="start_time_mm" class="form-control" >
                        <?php if(!empty($leaveInfo->departureTime)){ ?>
                            <option value="<?php echo date('i',strtotime($leaveInfo->departureTime)); ?>"><?php echo date('i',strtotime($leaveInfo->departureTime)); ?></option>
                        <?php } ?>
                        <option value="">Select Minute</option>
                        <?php for($i=0; $i<60; $i++){ ?>
                        <option value="<?php echo sprintf('%02d',$i); ?>"><?php echo sprintf('%02d',$i); ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-6 pr-2">
                    <div class="input-group">
                      <select required id="end_time_hh" name="end_time_hh" class="form-control">
                        <?php if(!empty($leaveInfo->arrivalTime)){ ?>
                            <option value="<?php echo date('h',strtotime($leaveInfo->arrivalTime)); ?>"><?php echo date('h',strtotime($leaveInfo->arrivalTime)); ?></option>
                        <?php } ?>
                        <option value="">Select Hour</option>
                        <?php for($i=1; $i<13; $i++){ ?>
                        <option value="<?php echo sprintf('%02d',$i); ?>"><?php echo sprintf('%02d',$i); ?></option>
                        <?php } ?>
                      </select>
                      <select required id="end_time_mm" name="end_time_mm" class="form-control" >
                        <?php if(!empty($leaveInfo->arrivalTime)){ ?>
                            <option value="<?php echo date('i',strtotime($leaveInfo->arrivalTime)); ?>"><?php echo date('i',strtotime($leaveInfo->arrivalTime)); ?></option>
                        <?php } ?>
                        <option value="">Select Minute</option>
                        <?php for($i=0; $i<60; $i++){ ?>
                        <option value="<?php echo sprintf('%02d',$i); ?>"><?php echo sprintf('%02d',$i); ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-6 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                        <tr class="table_row_background">
                            <th>Week Name</th>
                            <th>Class Start</th>
                            <th>Class End</th>
                            <!-- <th>Action</th> -->
                        </tr>
                        <?php if(!empty($classTimingsInfo)){
                            foreach($classTimingsInfo as $record){ ?>
                        <tr class="text-dark">
                          <td><?php echo $record->week_name; ?></td>
                          <td><?php echo $record->start_time; ?></td>
                          <td><?php echo $record->end_time; ?></td>
                          <!-- <td>
                            <a class="btn btn-xs btn-danger deleteClassTimings" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                          </td> -->
                        </tr>
                        <?php } }else{ ?>
                          <tr class="text-dark">
                            <td colspan="4" style="background-color: #e3cfff;">Class Timings Not Found</td>
                          </tr>
                        <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#timetableDayShifting">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Time table day shifting</h6>
        </div>
        <div id="timetableDayShifting" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="addClassTimings" action="<?php echo base_url() ?>addTimetableDayShifting" method="post" role="form">
                <div class="row form-contents">
                  <div class="col-4 pr-1">
                    <div class="form-group mb-2">
                      <select name="week_id" id="week_id" class="form-control" data-live-search="true" autocomplete="off" required>
                        <option value="">Select Week Name</option>
                        <?php if(!empty($weekName)){
                          foreach($weekName as $record){ ?>
                            <option value="<?php echo $record->row_id ?>">
                              <?php echo $record->week_name ?> 
                            </option>
                        <?php }  } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-4 pr-1 mb-2">
                    <div class="form-group mb-0">
                      <input type="text" class="form-control" id="datepicker" name="date" placeholder="Date" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-4 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                        <tr class="table_row_background">
                            <th>Week Name</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        <?php if(!empty($timetableShiftInfo)){
                            foreach($timetableShiftInfo as $record){ ?>
                        <tr class="text-dark">
                          <td><?php echo $record->week_name; ?></td>
                          <td><?php echo date('d-m-Y',strtotime($record->date)); ?></td>
                          <td>
                            <a class="btn btn-xs btn-danger deleteDayShifting" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                        <?php } }else{ ?>
                          <tr class="text-dark">
                            <td colspan="4" style="background-color: #e3cfff;">Record Not Found</td>
                          </tr>
                        <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->
    
      <!-- <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#feeName">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Fee Name</h6>
        </div>
        <div id="feeName" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="addCategory" action="<?php echo base_url() ?>addFeesName" method="post">
                <div class="row form-contents">
                  <div class="col-8">
                    <div class="form-group mb-0">
                      <input type="text" class="form-control text-capitalize" id="fee_name" name="fee_name" 
                      placeholder="Enter Fee Name" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-4 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                        <tr class="table_row_background">
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        <?php if(!empty($feeNameInfo)){
                            foreach($feeNameInfo as $record){ ?>
                        <tr class="text-dark">
                          <td><?php echo $record->fee_name; ?></td>
                          <td>
                            <a class="btn btn-xs btn-danger deleteFeeName" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                        <?php } }else{ ?>
                          <tr class="text-dark">
                            <td colspan="2" style="background-color: #e3cfff;">Fee Name Not Found</td>
                          </tr>
                        <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->
      

      <!-- <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#postName">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Post Info</h6>
        </div>
        <div id="postName" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="addPost" action="<?php echo base_url() ?>addPost" method="post" role="form">
                <div class="row form-contents">
                  <div class="col-8">
                    <div class="form-group mb-0">
                      <input type="text" class="form-control" id="post_name" name="post_name" placeholder="Enter Post" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-4 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                        <tr class="table_row_background">
                            <th>Post</th>
                            <th>Action</th>
                        </tr>
                        <?php if(!empty($postInfo)){
                            foreach($postInfo as $post){ ?>
                        <tr class="text-dark">
                          <td><?php echo $post->post_name; ?></td>
                          <td>
                            <a class="btn btn-xs btn-danger deletePost" href="#" data-post_id="<?php echo $post->post_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                        <?php } }else{ ?>
                          <tr class="text-dark">
                            <td colspan="2" style="background-color: #e3cfff;">Post Info Not Found</td>
                          </tr>
                        <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->

      

      <!-- <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#feeType">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Fee Type Info</h6>
        </div>
        <div id="feeType" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="addPost" action="<?php echo base_url() ?>addFeeType" method="post" role="form">
                <div class="row form-contents">
                  <div class="col-8">
                    <div class="form-group mb-0">
                      <input type="text" class="form-control text-capitalize" id="feeType" name="feeType" placeholder="Enter Fee Type" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-4 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                        <tr class="table_row_background">
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                        <?php if(!empty($feeTypeInfo)){
                            foreach($feeTypeInfo as $fee){ ?>
                        <tr class="text-dark">
                          <td><?php echo $fee->feeType; ?></td>
                          <td>
                            <a class="btn btn-xs btn-danger deleteFeeType" href="#" data-row_id="<?php echo $fee->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                        <?php } }else{ ?>
                          <tr class="text-dark">
                            <td colspan="2" style="background-color: #e3cfff;">Fee Info Not Found</td>
                          </tr>
                        <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->

      <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#miscellaneousType">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Miscellaneous Fee Info</h6>
        </div>
        <div id="miscellaneousType" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="addPost" action="<?php echo base_url() ?>addMiscellaneousType" method="post" role="form">
                <div class="row form-contents">
                <div class="col-4 col-lg-4 pr-1">
                    <div class="form-group mb-0">
                      <input type="text" class="form-control text-capitalize" id="miscellaneousType" name="miscellaneousType" placeholder=" Miscellaneous Type" autocomplete="off" required>
                    </div>
                </div>
                <div class="col-4 col-lg-4 pr-1">
                    <div class="form-group mb-0">
                      <input type="text" class="form-control text-capitalize" id="miscellaneousType" name="miscellaneousAmount" placeholder=" Miscellaneous Amount" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-4 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                        <tr class="table_row_background">
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                        <?php if(!empty($miscellaneousTypeInfo)){
                            foreach($miscellaneousTypeInfo as $fee){ ?>
                        <tr class="text-dark">
                          <td><?php echo $fee->miscellaneous_type; ?></td>
                          <td><?php echo $fee->miscellaneous_amount; ?></td>

                          <td>
                          <?php if($role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN){ ?>
                            <a class="btn btn-xs btn-danger deleteMiscellaneousType" href="#" data-row_id="<?php echo $fee->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                            <?php } ?>
                          </td>
                        </tr>
                        <?php } }else{ ?>
                          <tr class="text-dark">
                            <td colspan="2" style="background-color: #83c8ea7d;">Miscellaneous Info Not Found</td>
                          </tr>
                        <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#deposit_type">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Bank Deposit Type Info</h6>
        </div>
        <div id="deposit_type" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="adddeposittype" action="<?php echo base_url() ?>adddeposittype" method="post" role="form">
                <div class="row form-contents">
                  <div class="col-8">
                    <div class="form-group mb-0">
                      <input type="text" class="form-control" id="deposit_type" name="deposit_type" placeholder="Enter Deposit Type" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-4 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                      <tr class="table_row_background">
                        <th>Deposit Type</th>
                        <th>Action</th>
                      </tr>
                      <?php if(!empty($deposittypeInfo)){
                        foreach($deposittypeInfo as $record){ ?>
                      <tr class="text-dark">
                        <td><?php echo $record->deposit_type; ?></td>
                        <td>
                          <a class="btn btn-xs btn-danger deletedeposittype" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                      <?php } }else{ ?>
                        <td colspan="2" style="background-color: #e3cfff;">Bank Deposit Type Not Found</td>
                      <?php } ?>
                    </thead>
                  </table>
                </div>   
              </div>
            </div>
          </div>
        </div>
        <!-- End Quick Post -->
      </div>

      <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#deposit_account">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Bank Deposit Account Info</h6>
        </div>
        <div id="deposit_account" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="adddepositaccount" action="<?php echo base_url() ?>adddepositaccount" method="post" role="form">
                <div class="row form-contents">
                  <div class="col-8">
                    <div class="form-group mb-0">
                      <input type="text" class="form-control" id="deposit_account" name="deposit_account" placeholder="Enter Deposit Account" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-4 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                      <tr class="table_row_background">
                        <th>Deposit Account</th>
                        <th>Action</th>
                      </tr>
                      <?php if(!empty($depositaccountInfo)){
                        foreach($depositaccountInfo as $record){ ?>
                      <tr class="text-dark">
                        <td><?php echo $record->deposit_account; ?></td>
                        <td>
                          <a class="btn btn-xs btn-danger deletedepositaccount" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                      <?php } }else{ ?>
                        <td colspan="2" style="background-color: #e3cfff;">Bank Deposit Account Not Found</td>
                      <?php } ?>
                    </thead>
                  </table>
                </div>   
              </div>
            </div>
          </div>
        </div>
        <!-- End Quick Post -->
      </div>
      
      <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#document1">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Document Info</h6>
        </div>
        <div id="document1" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="" action="<?php echo base_url() ?>addDocName" method="post" role="form">
                <div class="row form-contents">
                  <div class="col-8">
                    <div class="form-group mb-0">
                      <input type="text" class="form-control" id="" name="doc_name" placeholder="Enter Type" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-4 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                        <tr class="table_row_background">
                            <th>Document Type</th>
                            <th>Action</th>
                        </tr>
                        <?php if(!empty($documentTypeInfo)){
                            foreach($documentTypeInfo as $record){ ?>
                        <tr class="text-dark">
                          <td><?php echo $record->document_name; ?></td>
                          <td>
                            <a class="btn btn-xs btn-danger deleteDocumentType" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                        <?php } }else{ ?>
                          <td colspan="2" style="background-color: #83c8ea7d;">Document Type Not Found</td>
                        <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php if($staffID == '123456'){
      ?>
    <div class="col-lg-6 col-md-6 col-12 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#salaryType">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Salary Type</h6>
        </div>
        <div id="salaryType" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="addPost" action="<?php echo base_url() ?>addSalaryType" method="post" role="form">
                <div class="row form-contents">
                  <div class="col-3 col-lg-4 pr-1">
                      <div class="form-group mb-0">
                        <input type="text" class="form-control" id="salary_type" name="salary_type" placeholder="Enter Salary Type" autocomplete="off" required>
                      </div>
                  </div>
                  <div class="col-3 col-lg-3 pr-1">
                      <div class="form-group mb-0">
                      <select  class="form-control " id="calculate_type" name="calculate_type" required>
                        <option value="">Select Calculate Type</option>
                        <option value="AMOUNT">AMOUNT</option>
                        <option value="PERCENTAGE">PERCENTAGE</option>
                     </select>
                      </div>
                  </div>
                  <div class="col-3 col-lg-3 pr-1">
                      <div class="form-group mb-0">
                      <select  class="form-control " id="salary_category" name="salary_category" required>
                        <option value="">Select Salary Category</option>
                        <option value="EARNINGS">EARNINGS</option>
                        <option value="DEDUCTION">DEDUCTION</option>
                     </select>
                      </div>
                  </div>
              
                  <div class="col-3 col-lg-2 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                        <tr class="table_row_background">
                            <th>Salary Type</th>
                            <th>Calculate Type</th>
                            <th>Salary Category</th>
                            <th>Action</th>
                        </tr>
                        <?php if(!empty($salaryTypeInfo)){
                            foreach($salaryTypeInfo as $type){ ?>
                        <tr class="text-dark">
                          <td><?php echo $type->salary_type; ?></td>
                          <td><?php echo $type->calculate_type; ?></td>
                          <td><?php echo $type->salary_category; ?></td>
                        
                          <td>
                          <?php if ($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN){ ?>
                            <a class="btn btn-xs btn-danger deleteSalaryType" href="#" data-row_id="<?php echo $type->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                          <?php } ?>
                          </td>
                        </tr>
                        <?php } }else{ ?>
                          <tr class="text-dark">
                            <td colspan="4" style="background-color: #83c8ea7d;">Salary Type Not Found</td>
                          </tr>
                        <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>

      <div class="col-lg-6 col-md-6 col-12 column_padding_card mb-2">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#salaryDesignation">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Salary Designation Info</h6>
        </div>
        <div id="salaryDesignation" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="" action="<?php echo base_url() ?>addSalaryDesignation" method="post" role="form">
                <div class="row form-contents">
                  <div class="col-6 col-lg-8 pr-1">
                      <div class="form-group mb-0">
                        <input type="text" class="form-control" id="salary_designation" name="salary_designation" placeholder="Enter Salary Designation" autocomplete="off" required>
                      </div>
                  </div>
                 
              
                  <div class="col-4 col-lg-4 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                        <tr class="table_row_background">
                            <th>Salary Designation</th>
                            <th>Action</th>
                        </tr>
                        <?php if(!empty($salaryDesignationInfo)){
                            foreach($salaryDesignationInfo as $type){ ?>
                        <tr class="text-dark">
                          <td><?php echo $type->designation; ?></td>
                          <td>
                          <?php if ($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN){ ?>
                            <a class="btn btn-xs btn-danger deleteSalaryDesignation" href="#" data-row_id="<?php echo $type->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                          <?php } ?>
                          </td>
                        </tr>
                        <?php } }else{ ?>
                          <tr class="text-dark">
                            <td colspan="4" style="background-color: #83c8ea7d;">Salary Type Not Found</td>
                          </tr>
                        <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-6 col-12 column_padding_card mb-2">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#taxRegimeType">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Tax Regime Type Info</h6>
        </div>
        <div id="taxRegimeType" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="" action="<?php echo base_url() ?>addTaxRegime" method="post" role="form">
                <div class="row form-contents">
                  <div class="col-6 col-lg-8 pr-1">
                      <div class="form-group mb-0">
                        <input type="text" class="form-control" id="tax_regime" name="tax_regime" placeholder="Enter Tax Regime" autocomplete="off" required>
                      </div>
                  </div>
                 
              
                  <div class="col-4 col-lg-4 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                        <tr class="table_row_background">
                            <th>Tax Regime</th>
                            <th>Action</th>
                        </tr>
                        <?php if(!empty($taxRegimeTypeInfo)){
                            foreach($taxRegimeTypeInfo as $type){ ?>
                        <tr class="text-dark">
                          <td><?php echo $type->type; ?></td>
                          <td>
                          <?php if ($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN){ ?>
                            <a class="btn btn-xs btn-danger deleteTaxRegime" href="#" data-row_id="<?php echo $type->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                          <?php } ?>
                          </td>
                        </tr>
                        <?php } }else{ ?>
                          <tr class="text-dark">
                            <td colspan="4" style="background-color: #83c8ea7d;">Salary Type Not Found</td>
                          </tr>
                        <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card mb-2">
              <div class="card-header border-bottom card_head_dashboard settings_card" style="padding: 10px !important;" data-toggle="collapse"
                data-target="#semesterInfo">
                <a class="float-right mb-0 setting_pointer">Click here </a>
                <h6 class="m-0 text-dark">Job Post Info</h6>
            </div>
            <div id="semesterInfo" class="collapse">
                <div class="card card-small h-100">
                    <div class="card-body d-flex flex-column p-1">
                    <?php $this->load->helper("form"); ?>
                      <form role="form" id="addCategory" action="<?php echo base_url() ?>addJobPost" method="post">
                        <div class="row form-contents">
                          <div class="col-10">
                            <div class="form-group mb-0">
                              <input type="text" class="form-control text-capitalize" id="job_post" name="job_post" 
                              placeholder="Enter Job Post" autocomplete="off" required>
                            </div>
                          </div>
                          <div class="col-2 mb-1">
                            <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                          </div>
                        </div>
                      </form>

                        <div class="col-lg-12 col-12 p-0 mt-0 ">
                            <table class="table table-bordered text-dark mb-0">
                                <thead class="text-center">
                                    <tr class="table_row_background">
                                        <th>Job Post</th>
                                        <th>Active/Inactive</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php if(!empty($jobPostInfo)){
                                        foreach($jobPostInfo as $job){ ?>
                                    <tr class="text-dark">
                                        <td><?php echo $job->job_post; ?></td>
                                        <td>
                                            <?php if($job->is_active == '1'){ ?>
                                            <a class="btn btn-xs btn-danger activeJobPost" href="#"
                                                data-row_id="<?php echo $job->row_id; ?>" title="Inactive Job Post"><i
                                                    class="fas fa-toggle-off"></i></a>
                                            <?php } else { ?>
                                            <a class="btn btn-xs btn-success inactiveJobPost" href="#"
                                                data-row_id="<?php echo $job->row_id; ?>" title="Active Job Post"><i
                                                    class="fas fa-toggle-on"></i></a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                          <a class="btn btn-xs btn-danger deleteJobPost" href="#" data-row_id="<?php echo $job->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php } }else{ ?>
                                    <tr class="text-dark card_head_dashboard">
                                        <td colspan="3">Job Post Info Not Found!</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Quick Post  -->
        </div>
        <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card mb-2">
            <div class="card-header border-bottom card_head_dashboard settings_card" style="padding: 10px !important;"
                data-toggle="collapse" data-target="#OverTime">
                <a class="float-right mb-0 setting_pointer">Click here </a>
                <h6 class="m-0 text-dark">OT Amount</h6>
            </div>
            <div id="OverTime" class="collapse">
                <div class="card card-small h-100">
                    <div class="card-body d-flex flex-column p-1">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addCategory" action="<?php echo base_url() ?>addOTAmount" method="post">
                            <div class="row form-contents">
                                <div class="col-10">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control text-capitalize" id="ot_amount"
                                            name="ot_amount" onkeypress="return isNumberKey(event)"
                                            placeholder="Enter OT Amount Per Hour" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-2 mb-1">
                                    <input style="float:right;" type="submit" class="btn btn-block btn-success"
                                        value="Add" />
                                </div>
                            </div>
                        </form>
                        <div class="row mx-0">
                            <div class="col-lg-12 col-12 p-0 mt-0 ">
                                <table class="table table-bordered text-dark mb-0">
                                    <thead class="text-center">
                                        <tr class="table_row_background">
                                            <th>OT Amount</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php if(!empty($OTAmountInfo)){
                                  foreach($OTAmountInfo as $record){ ?>
                                        <tr class="text-dark">
                                            <td><?php echo $record->ot_amount; ?></td>
                                            <td>
                                                <a class="btn btn-xs btn-danger deleteOTAmount" href="#"
                                                    data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php } }else{ ?>
                                        <tr class="text-dark">
                                            <td colspan="2" style="background-color: #83c8ea7d;">Amount Not Found</td>
                                        </tr>
                                        <?php } ?>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <!-- Student Remark info -->
        <div class="col-lg-6 col-md-6 col-12 mb-2 padding_left_right_null">
            <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse"
                data-target="#addRemarkName1">
                <a class="float-right mb-0 setting_pointer">Click here </a>
                <h6 class="m-0 text-dark">Observation Type Info</h6>
            </div>
            <div id="addRemarkName1" class="collapse">
                <div class="card card-small h-100">
                    <div class="card-body d-flex flex-column p-1">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addRemarkName" action="<?php echo base_url() ?>addRemarkName"
                            method="post">
                            <div class="row form-contents">
                                <div class="col-8">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" id="remark_name" name="remark_name"
                                            placeholder="Enter Observation Name" autocomplete="off" required>
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
                                        <th>Observation Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php if(!empty($remarkNameInfo1)){
                                        foreach($remarkNameInfo1 as $remark){ ?>
                                    <tr class="text-dark">
                                        <td><?php echo $remark->remark_name; ?></td>
                                        <td>
                                            <a class="btn btn-xs btn-danger deleteRemarkName" href="#"
                                                data-row_id="<?php echo $remark->row_id; ?>" title="Delete"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php } }else{ ?>
                                    <tr class="text-dark card_head_dashboard">
                                        <td colspan="2">Observation Info Not Found!</td>
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
          <!-- Student Remark info -->
      <div class="col-lg-6 col-md-6 col-12 mb-2 padding_left_right_null">
            <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse"
                data-target="#addRemarkName2">
                <a class="float-right mb-0 setting_pointer">Click here </a>
                <h6 class="m-0 text-dark">Staff Remarks Type Info</h6>
            </div>
            <div id="addRemarkName2" class="collapse">
                <div class="card card-small h-100">
                    <div class="card-body d-flex flex-column p-1">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addRemarkName" action="<?php echo base_url() ?>addStaffRemarkName"
                            method="post">
                            <div class="row form-contents">
                                <div class="col-8">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" id="remark_name" name="remark_name"
                                            placeholder="Enter Remark Name" autocomplete="off" required>
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
                                        <th>Remarks Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php if(!empty($remarkNameInfo)){
                                        foreach($remarkNameInfo as $remark){ ?>
                                    <tr class="text-dark">
                                        <td><?php echo $remark->remark_name; ?></td>
                                        <td>
                                            <a class="btn btn-xs btn-danger deleteStaffRemarkName" href="#"
                                                data-row_id="<?php echo $remark->row_id; ?>" title="Delete"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php } }else{ ?>
                                    <tr class="text-dark card_head_dashboard">
                                        <td colspan="2">Staff Remarks Info Not Found!</td>
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
                data-target="#examTypeListing">
                <a class="float-right mb-0 setting_pointer">Click here </a>
                <h6 class="m-0 text-dark">Exam Type Info</h6>
            </div>
            <div id="examTypeListing" class="collapse">
                <div class="card card-small h-100">
                    <div class="card-body d-flex flex-column p-1">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addRemarkName" action="<?php echo base_url() ?>addExamType"
                            method="post">
                            <div class="row form-contents">
                                <div class="col-8">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" id="" name="exam_type"
                                            placeholder="Enter Exam Type" autocomplete="off" required>
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
                                        <th>Exam type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php if(!empty($examTypeInfo)){
                                        foreach($examTypeInfo as $remark){ ?>
                                    <tr class="text-dark">
                                        <td><?php echo $remark->exam_type; ?></td>
                                        <td>
                                            <a class="btn btn-xs btn-danger deleteExamType" href="#"
                                                data-row_id="<?php echo $remark->row_id; ?>" title="Delete"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php } }else{ ?>
                                    <tr class="text-dark card_head_dashboard">
                                        <td colspan="2">Exam Type Info Not Found!</td>
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
        <!-- <div class="col-lg-6 col-md-6 col-12 mb-4 column_padding_card">
            <div class="card card-small">
                <div class="card-header border-bottom card_head_dashboard">
                    <h6 class="mb-0 text-dark">Staff Shift Settings</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered text-dark">
                        <thead class="text-center">
                            <tr class="table_row_background">
                                <th>Shift Code</th>
                                <th>Name</th>
                                <th>Start</th>
                                <th>End</th>
                            </tr>
                            <?php if (!empty($shiftInfo)) {
                                foreach ($shiftInfo as $record) { ?>
                                    <tr class="text-dark">
                                        <td><?php echo $record->shift_code; ?></td>
                                        <td><?php echo $record->name; ?></td>
                                        <td><?php echo $record->start_time; ?></td>
                                        <td><?php echo $record->end_time; ?></td>


                                    </tr>
                            <?php }
                            } ?>
                        </thead>
                    </table>
                </div>
            </div>
        </div> -->
        <div class="col-lg-6 col-md-6 col-12 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#shiftstaff">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Staff Shift Settings</h6>
        </div>
        <div id="shiftstaff" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="addPost" action="<?php echo base_url() ?>addStaffShiftinfo" method="post" role="form">

                <div class="row form-contents">
                  <div class="col-3 col-lg-3 pr-1">
                      <div class="form-group mb-0">
                        <input type="text" class="form-control" id="shift_code" name="shift_code" placeholder="Enter Shift Code" autocomplete="off" required>
                      </div>
                  </div>
                  <div class="col-3 col-lg-2 pr-1">
                  <div class="form-group mb-0">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" autocomplete="off" required>
                      </div>
                  </div>
                  <div class="col-3 col-lg-2 pr-1">
                  <div class="form-group mb-0">
                        <input type="text" class="form-control" id="start_time" name="start_time" placeholder="Enter Start Time" autocomplete="off" required>
                      </div>
                  </div>
                  <div class="col-3 col-lg-2 pr-1">
                  <div class="form-group mb-0">
                        <input type="text" class="form-control" id="end_time" name="end_time" placeholder="Enter End Time" autocomplete="off" required>
                      </div>
                  </div>
              
                  <div class="col-3 col-lg-3 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                    <tr class="table_row_background">
                                <th>Shift Code</th>
                                <th>Name</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Action</th>
                            </tr>
                        <?php if(!empty($shiftInfo)){
                            foreach($shiftInfo as $record){ ?>
                        <tr class="text-dark">
                          <td><?php echo $record->shift_code; ?></td>
                          <td><?php echo $record->name; ?></td>
                          <td><?php echo  $record->start_time; ?></td>
                          <td><?php echo  $record->end_time; ?></td>
                        
                          <td>
                          <?php if ($role == ROLE_ADMIN || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_SUPER_ADMIN){ ?>
                            <a class="btn btn-xs btn-danger deleteShiftInfo" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                            <a class=" btn-sm btn-info" href="#" onclick="openModel(<?php echo $record->row_id ?>,'<?php echo $record->name ?>', '<?php echo $record->start_time ?>','<?php echo $record->end_time ?>')" title="Edit"><i class="fas fa-edit"></i></i></a>
                          <?php } ?>
                          </td>
                        </tr>
                        <?php } }else{ ?>
                          <tr class="text-dark">
                            <td colspan="5" style="background-color: #83c8ea7d;">Staff Shift Info Not Found</td>
                          </tr>
                        <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        <div class="col-lg-6 col-md-6 col-6 mb-2 padding_left_right_null">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse"
            data-target="#scolarship_type">
            <a class="float-right mb-0 setting_pointer">Click here </a>
            <h6 class="m-0 text-dark">Scholarship Type</h6>
        </div>
        <div id="scolarship_type" class="collapse">
            <div class="card card-small h-100">
                <div class="card-body d-flex flex-column p-1">
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addExecutiveRoom" action="<?php echo base_url() ?>addScholarshipType" method="post">
                        <div class="row form-contents">
                            <div class="col-8">
                                <div class="form-group mb-0 mr-0">
                                    <input type="text" class="form-control" id="scholarship_type" name="scholarship_type"
                                        placeholder="Scholarship Type" autocomplete="off" required>
                                </div>
                            </div>
                            
                            
                            
                            
                            <div class="col-4 mb-1">
                                <input type="submit" class="btn btn-block btn-success float-right" value="Save" />
                            </div>
                        </div>
                    </form>
                    <div class="col-lg-12 col-12 p-0 mt-0 ">
                        <table class="display table table-bordered table-striped table-hover w-100">
                            <thead class="text-center">
                                <tr class="table_row_background">
                                    <th>Scholarship Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php if(!empty($scholarshipTypeInfo)){
                                    foreach($scholarshipTypeInfo as $record){ ?>
                                <tr class="text-dark">
                                    <td><?php echo $record->scholarship_type; ?></td>
                                   
                                    <td>
                                        <a class="btn btn-xs btn-danger deleteScholarshipType" href="#"
                                            data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php } }else{ ?>
                                <tr class="text-dark card_head_dashboard">
                                    <td colspan="6">Scholarship Type is not updated</td>
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

    <div class="col-lg-6 col-md-6 col-6 mb-2 padding_left_right_null">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse"
            data-target="#scolarship_recommended_by">
            <a class="float-right mb-0 setting_pointer">Click here </a>
            <h6 class="m-0 text-dark">Scholarship Recommended By</h6>
        </div>
        <div id="scolarship_recommended_by" class="collapse">
            <div class="card card-small h-100">
                <div class="card-body d-flex flex-column p-1">
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addScholarshipRecommendedBy" action="<?php echo base_url() ?>addScholarshipRecommendedBy" method="post">
                        <div class="row form-contents">
                            <div class="col-8">
                                <div class="form-group mb-0 mr-0">
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter Name" autocomplete="off" required>
                                </div>
                            </div>
                            
                            
                            
                            
                            <div class="col-4 mb-1">
                                <input type="submit" class="btn btn-block btn-success float-right" value="Save" />
                            </div>
                        </div>
                    </form>
                    <div class="col-lg-12 col-12 p-0 mt-0 ">
                        <table class="display table table-bordered table-striped table-hover w-100">
                            <thead class="text-center">
                                <tr class="table_row_background">
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php if(!empty($scholarshipRecommendedInfo)){
                                    foreach($scholarshipRecommendedInfo as $record){ ?>
                                <tr class="text-dark">
                                    <td><?php echo $record->name; ?></td>
                                   
                                    <td>
                                        <a class="btn btn-xs btn-danger deleteScholarshipRecommendedBy" href="#"
                                            data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php } }else{ ?>
                                <tr class="text-dark card_head_dashboard">
                                    <td colspan="6">Recommended By Info is not updated</td>
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
        <?php if($staffID == "123456"){ ?>
          <div class="col-lg-6 col-md-6 col-12 mb-2">
        <div class="card card-small h-100">
          <div class="card-header border-bottom card_head_dashboard">
            <h6 class="m-0 text-dark">Add Year Wise Details</h6>
          </div>
          <div class="card-body d-flex flex-column p-1">
            <?php $this->load->helper("form"); ?>
            <form role="form" action="<?php echo base_url() ?>addYearWise" method="POST" role="form" enctype="multipart/form-data">
              <div class="row">
                            
                <div class="col-6">
                  <input type="submit" class="btn btn-success btn-block" value="Submit" />
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
        <div class="col-lg-6 col-md-6 col-12 mb-2">
        <div class="card card-small">
          <div class="card-header border-bottom card_head_dashboard">
            <h6 class="m-0 text-dark">Staff Salary Import</h6>
          </div>
          <div class="card-body d-flex flex-column p-1">
          <?php $this->load->helper("form"); ?>
            <form role="form" action="<?php echo base_url() ?>importSalaryInfo" method="POST" role="form" enctype="multipart/form-data" >
              <div class="row">
                <div class="col-6">
                  <input type="file" class="form-control" id="excelFile" name="excelFile" >
                  <label for="fname">Select a Excel File</label>
                  <img src="<?php echo base_url(); ?>assets/dist/img/excel.png"  class="avatar  img-thumbnail" width="50"  height="10" src="#" id="uploadedImage" name="userfile" width="130" height="130" alt="avatar" >     
                </div>
                <div class="col-6">
                  <input  type="submit" class="btn btn-success btn-block" value="Submit" />
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <?php } ?>


      <?php if($role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_ADMIN){ ?>
      <div class="col-lg-6 col-md-6 col-12 mb-2">
        <div class="card card-small">
          <div class="card-header border-bottom card_head_dashboard">
            <h6 class="m-0 text-dark">Staff Excels</h6>
          </div>
          <div class="card-body d-flex flex-column p-1">
          <?php $this->load->helper("form"); ?>
            <form role="form" action="<?php echo base_url() ?>getStaffDetailsForImport" method="POST" role="form" enctype="multipart/form-data" >
              <div class="row">
                <div class="col-6">
                  <input type="file" class="form-control" id="excelFile" name="excelFile" >
                  <label for="fname">Select a Excel File</label>
                  <img src="<?php echo base_url(); ?>assets/dist/img/excel.png"  class="avatar  img-thumbnail" width="50"  height="10" src="#" id="uploadedImage" name="userfile" width="130" height="130" alt="avatar" >     
                </div>
                <div class="col-6">
                  <input  type="submit" class="btn btn-success btn-block" value="Submit" />
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
       <div class="col-lg-6 col-md-6 col-12 mb-2">
        <div class="card card-small">
          <div class="card-header border-bottom card_head_dashboard">
            <h6 class="m-0 text-dark">Miss Excel</h6>
          </div>
          <div class="card-body d-flex flex-column p-1">
          <?php $this->load->helper("form"); ?>
            <form role="form" action="<?php echo base_url() ?>addStudentMissingData" method="POST" role="form" enctype="multipart/form-data" >
              <div class="row">
                <div class="col-6">
                  <input type="file" class="form-control" id="excelFile" name="excelFile" >
                  <label for="fname">Select a Excel File</label>
                  <img src="<?php echo base_url(); ?>assets/dist/img/excel.png"  class="avatar  img-thumbnail" width="50"  height="10" src="#" id="uploadedImage" name="userfile" width="130" height="130" alt="avatar" >     
                </div>
                <div class="col-6">
                  <input  type="submit" class="btn btn-success btn-block" value="Submit" />
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-6 col-12 mb-2">
        <div class="card card-small">
          <div class="card-header border-bottom card_head_dashboard">
            <h6 class="m-0 text-dark">Student Excel</h6>
          </div>
          <div class="card-body d-flex flex-column p-1">
          <?php $this->load->helper("form"); ?>
            <form role="form" action="<?php echo base_url() ?>getNewAdmittedStudentsImport" method="POST" role="form" enctype="multipart/form-data" >
              <div class="row">
                <div class="col-6">
                  <input type="file" class="form-control" id="excelFile" name="excelFile" >
                  <label for="fname">Select a Excel File</label>
                  <img src="<?php echo base_url(); ?>assets/dist/img/excel.png"  class="avatar  img-thumbnail" width="50"  height="10" src="#" id="uploadedImage" name="userfile" width="130" height="130" alt="avatar" >     
                </div>
                <div class="col-6">
                  <input  type="submit" class="btn btn-success btn-block" value="Submit" />
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-6 col-12 mb-2">
        <div class="card card-small">
          <div class="card-header border-bottom card_head_dashboard">
            <h6 class="m-0 text-dark">Inactive Student Import</h6>
          </div>
          <div class="card-body d-flex flex-column p-1">
          <?php $this->load->helper("form"); ?>
            <form role="form" action="<?php echo base_url() ?>getInactiveStudentsImport" method="POST" role="form" enctype="multipart/form-data" >
              <div class="row">
                <div class="col-6">
                  <input type="file" class="form-control" id="excelFile" name="excelFile" >
                  <label for="fname">Select a Excel File</label>
                  <img src="<?php echo base_url(); ?>assets/dist/img/excel.png"  class="avatar  img-thumbnail" width="50"  height="10" src="#" id="uploadedImage" name="userfile" width="130" height="130" alt="avatar" >     
                </div>
                <div class="col-6">
                  <input  type="submit" class="btn btn-success btn-block" value="Submit" />
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <?php if($this->staff_id == "123456"){ ?>
      <div class="col-lg-6 col-md-6 col-12 mb-2">

        <div class="card card-small h-100">

          <div class="card-header border-bottom card_head_dashboard">

            <h6 class="m-0 text-dark">Employee Id</h6>

          </div>

          <div class="card-body d-flex flex-column p-1">

          <?php $this->load->helper("form"); ?>

            <form role="form" action="<?php echo base_url() ?>employeeIdUpdate" method="POST" role="form" enctype="multipart/form-data" >

              <div class="row">

                <!-- <div class="col-6">

                  <input type="file" class="form-control" id="excelFile" name="excelFile" >

                  <label for="fname">Select a Excel File New Adm</label>

                  <img src="<?php echo base_url(); ?>assets/dist/img/excel.png"  class="avatar  img-thumbnail" width="50"  height="10" src="#" id="uploadedImage" name="userfile" width="130" height="130" alt="avatar" >     

                </div> -->

                <div class="col-6">

                  <input  type="submit" class="btn btn-success btn-block" value="Submit" />

                </div>

              </div>

            </form>

          </div>

        </div>

      </div>
      <?php } ?>
      
      <div class="col-lg-6 col-md-6 col-12 mb-2">
            <div class="card card-small h-100">
                <div class="card-header border-bottom card_head_dashboard">
                    <h6 class="m-0 text-dark">Update All Admitted Students</h6>
                </div>
                <div class="card-body d-flex flex-column p-1">
                    <?php $this->load->helper("form"); ?>
                    <form role="form" action="<?php echo base_url() ?>addAllApprovedStudent" method="POST" role="form"
                        enctype="multipart/form-data">
                        <!-- <div class="row">
                            <div class="col-6">
                                 <select class="form-control" id="year" name="year" data-live-search="true"
                                    autocomplete="off" required>
                                    <option value="">Year</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                </select>
                               
                            </div> -->
                            <div class="col-6">
                                <input type="submit" class="btn btn-success btn-block" value="Submit" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php if($staffID == "123456"){ ?>
            <div class="col-lg-6 col-md-6 col-12 mb-2">

              <div class="card card-small h-100">

                <div class="card-header border-bottom card_head_dashboard">

                  <h6 class="m-0 text-dark">Create exam Row ID Update</h6>

                </div>

                <div class="card-body d-flex flex-column p-1">

                <?php $this->load->helper("form"); ?>

                  <form role="form" action="<?php echo base_url() ?>createExamRowIdUpdate" method="POST" role="form" enctype="multipart/form-data" >

                    <div class="row">

                          <div class="col-6">
                                 <select class="form-control" id="" name="exam_type" data-live-search="true"
                                    autocomplete="off" required>
                                    <option value="">Select Exam Type</option>
                                    <?php if(!empty($examTypeInfo)){
                                        foreach($examTypeInfo as $remark){ ?>
                                            <option value="<?php echo $remark->exam_type?>"><?php echo $remark->exam_type?></option>


                                    <?php } ?>
                                    <?php } ?>

                                </select>
                               
                            </div> 

                      <div class="col-6">

                        <input  type="submit" class="btn btn-success btn-block" value="Submit" />

                      </div>

                    </div>

                  </form>

                </div>

              </div>

            </div>
          <?php } ?>
        </div> 
        
      <?php } ?>
          
    </div>
  </div>
</div>
<div id="timingsinfo" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md ">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header modal-call-report p-2">
                <div class=" col-md-10 col-10">
                    <span class="text-white mobile-title" style="font-size : 20px">Staff Shift Info</span>
                </div>
                <div class=" col-md-2  col-2">
                    <button type="button" class="text-white close" data-dismiss="modal">&times;</button>
                </div>
            </div>
            <!-- Modal body -->
            <div class="modal-body m-0">
                <?php $this->load->helper("form"); ?>
                <form role="form" id="updateTimingsInfo" action="<?php echo base_url() ?>updateTimingsInfo"
                    method="post" role="form">
                    <input type="hidden" name="Urow_id" id="Urow_id" value="" />
                    <div class="row">
                        <div class="col-lg-4 col-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" id="shiftname" name="shiftname"  autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="form-group">
                                <label> Start</label>
                                <input type="text" class="form-control" id="class_start" name="class_start"  autocomplete="off">
                            </div>
                        </div>
                       
                        <div class="col-lg-4 col-12">
                            <div class="form-group">
                                <label> End</label>
                                <input type="text" class="form-control " id="class_end" name="class_end" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input style="float:right;" type="submit" class="btn btn-primary" value="Update" />
                    </div>
                </form>
            </div>
        </div>
    </div>

   

</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>

<script>
    function openModel(row_id,name,class_start,class_end) {
    $('#Urow_id').val(row_id);
    $('#shiftname').val(name);
    $('#class_start').val(class_start);
    $('#class_end').val(class_end);
    $('#timingsinfo').modal('show');
   }
jQuery(document).ready(function() {
    jQuery('#datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy",
    });
});

jQuery(document).on("click", ".deleteMiscellaneousType", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "deleteMiscellaneousType",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Miscellaneous Type Info ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
					
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Miscellaneous Type Info successfully deleted"); 
				window.location.reload() }
				else if(data.status = false) { alert("Miscellaneous Type Info deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});

  jQuery(document).on("click", ".deletedeposittype", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "deletedeposittype",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Bank Deposit Type Info ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
					
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Bank Deposit Type Info successfully deleted"); 
				window.location.reload() }
				else if(data.status = false) { alert("Bank Deposit Type Info deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});

  jQuery(document).on("click", ".deletedepositaccount", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "deletedepositaccount",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Bank Deposit Account Info ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
					
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Bank Deposit Account Info successfully deleted"); 
				window.location.reload() }
				else if(data.status = false) { alert("Bank Deposit Account Info deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
  jQuery(document).on("click", ".deleteDocumentType", function(){
        var row_id = $(this).data("row_id"),
            hitURL = baseURL + "deleteDocumentType",
            currentRow = $(this);
        
        var confirmation = confirm("Are you sure to delete this Document Type?");
        
        if(confirmation)
        {
            jQuery.ajax({
            type : "POST",
            dataType : "json",
            url : hitURL,
            data : { row_id : row_id } 
            }).done(function(data){
                currentRow.parents('tr').remove();
                if(data.status = true) { alert("Document Type successfully deleted"); }
                else if(data.status = false) { alert("Document Type deletion failed"); }
                else { alert("Access denied..!"); }
            });
        }
    });

    function isNumberKey(evt) {
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode != 46 && charCode > 31 &&
          (charCode < 48 || charCode > 57))
          return false;
      return true;
  }
  jQuery(document).on("click", ".deleteRemarkName", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "deleteRemarkName",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Observation Name ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
					
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Observation Name successfully deleted"); }
				else if(data.status = false) { alert("Observation Name deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
        $(document).ready(function() {
        // Hide all sub module rows initially when page loads
        $('#subModuleTable tbody tr').hide();
        // Show a message row indicating how to display sub modules
        $('#subModuleTable tbody').prepend('<tr id="no-filter-message"><td colspan="5" style="background-color: #f8f9fa;">Please select a module from the dropdown to view its sub modules, or select "Show All Sub Modules" to view all.</td></tr>');
        
        // Filter sub modules based on selected module
        $('#filter_module').change(function() {
          var moduleId = $(this).val();
          
          // Remove the message row if it exists
          $('#no-filter-message').remove();
          
          if(moduleId === '') {
        // Show all sub modules
        $('#subModuleTable tbody tr').show();
          } else {
        // Hide all then show only rows with matching module ID
        $('#subModuleTable tbody tr').hide();
        $('#subModuleTable tbody tr[data-module-id="' + moduleId + '"]').show();
          }
        });
        
        // Handle update button click
        $(document).on('click', '.updateSubModule', function(e) {
          e.preventDefault();
          
          var row_id = $(this).data('row_id');
          var confirmation = confirm("Are you sure you want to update this sub module?");
          
          if(confirmation) {
        var row = $(this).closest('tr');
        var subModuleName = row.find('.submodule-name-input').val();
        var subModuleLink = row.find('.submodule-link-input').val();
        var subModulePriority = row.find('.submodule-priority-input').val();
        
        // Create form and submit
        var form = $('<form>', {
          'method': 'POST',
          'action': baseURL + 'updateSubModule'
        });
        
        form.append($('<input>', {
          'type': 'hidden',
          'name': 'row_id',
          'value': row_id
        }));
        
        form.append($('<input>', {
          'type': 'hidden',
          'name': 'sub_menu_name',
          'value': subModuleName
        }));
        
        form.append($('<input>', {
          'type': 'hidden',
          'name': 'link',
          'value': subModuleLink
        }));
        
        form.append($('<input>', {
          'type': 'hidden',
          'name': 'priority',
          'value': subModulePriority
        }));
        
        form.appendTo('body').submit();
          }
        });
        
        // Handle delete button click
        $(document).on('click', '.deleteSubModule', function(e) {
          e.preventDefault();
          
          var row_id = $(this).data('row_id');
          var confirmation = confirm("Are you sure you want to delete this sub module?");
          
          if(confirmation) {
        var form = $('<form>', {
          'method': 'POST',
          'action': baseURL + 'deleteSubModule'
        });
        
        form.append($('<input>', {
          'type': 'hidden',
          'name': 'row_id',
          'value': row_id
        }));
        
        form.appendTo('body').submit();
          }
        });
      });
      document.addEventListener('DOMContentLoaded', function() {
    // Find all elements with the "updateModule" class
    document.querySelectorAll('.updateModule').forEach(function(element) {
        element.addEventListener('click', function(e) {
            e.preventDefault();
            
            var row_id = this.getAttribute('data-row_id');
            var confirmation = confirm("Are you sure you want to update this module?");
            
            if(confirmation) {
                // Get the updated values
                var row = this.closest('tr');
                var moduleName = row.querySelector('.module-name-input').value;
                var modulePriority = row.querySelector('.module-priority-input').value;
                
                // Create a form dynamically and submit it
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = baseURL + 'updateModule';
                
                // Add hidden fields
                var rowIdField = document.createElement('input');
                rowIdField.type = 'hidden';
                rowIdField.name = 'row_id';
                rowIdField.value = row_id;
                form.appendChild(rowIdField);
                
                var nameField = document.createElement('input');
                nameField.type = 'hidden';
                nameField.name = 'menu_name';
                nameField.value = moduleName;
                form.appendChild(nameField);
                
                var priorityField = document.createElement('input');
                priorityField.type = 'hidden';
                priorityField.name = 'priority';
                priorityField.value = modulePriority;
                form.appendChild(priorityField);
                
                // Add the form to the body and submit it
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
     document.querySelectorAll('.deleteModule').forEach(function(element) {
        element.addEventListener('click', function(e) {
            e.preventDefault();
            var row_id = this.getAttribute('data-row_id');
            var confirmation = confirm("Are you sure you want to delete this module?");
            if(confirmation) {
                // Create a form dynamically and submit it
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = baseURL + 'deleteModule';
                // Add hidden fields
                var rowIdField = document.createElement('input');
                rowIdField.type = 'hidden';
                rowIdField.name = 'row_id';
                rowIdField.value = row_id;
                form.appendChild(rowIdField);
                // Add the form to the body and submit it
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
  });
</script>