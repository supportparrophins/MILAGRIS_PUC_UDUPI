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
                  <i class="material-icons">settings</i> Configure Menu Access
                </span>
              </div>
              <div class="col-lg-3 col-sm-3 col-3 box-tools">
             
                <a onclick="showLoader();window.history.back();" class="btn primary_color mobile-btn float-right text-white pt-2"
                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                       <button type="button" class="btn btn-success mobile-btn float-right text-white pt-2 mr-2" data-toggle="modal" data-target="#addConfigModal">
                  <i class="fa fa-plus"></i> Add
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
    <div class="col-md-12">
        <div class="card card-small mb-4">
            <div class="card-header border-bottom">
                <h6 class="m-0">Configuration Settings</h6>
            </div>
            <div class="card-body">
                <?php echo form_open_multipart('configuration/updateBulkConfig'); ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-secondary">
                            <tr>
                                <th width="5%">#</th>
                                <th width="25%">Configuration Key</th>
                                <th width="60%">Configuration Value</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($configInfo)): ?>
                                <?php foreach($configInfo as $index => $config): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($config->config_key); ?></strong>
                                            <input type="hidden" name="configs[<?php echo $index; ?>][row_id]" value="<?php echo $config->row_id; ?>">
                                            <input type="hidden" name="configs[<?php echo $index; ?>][config_key]" value="<?php echo htmlspecialchars($config->config_key); ?>">
                                        </td>
                                        <td>
                                            <?php if($config->config_key == 'PASSWORD'): ?>
                                                <input type="text" class="form-control" name="configs[<?php echo $index; ?>][config_value]" value="<?php echo htmlspecialchars($config->config_value); ?>">
                                            <?php elseif(strlen($config->config_value) > 100): ?>
                                                <textarea class="form-control" name="configs[<?php echo $index; ?>][config_value]" rows="3"><?php echo htmlspecialchars($config->config_value); ?></textarea>
                                            <?php else: ?>
                                                <input type="text" class="form-control" name="configs[<?php echo $index; ?>][config_value]" value="<?php echo htmlspecialchars($config->config_value); ?>" id="config_value_<?php echo $index; ?>">
                                            <?php endif; ?>
                                            
                                            <?php if(strpos($config->config_value, 'assets/dist/img/') !== false): ?>
                                                <div class="mt-2">
                                                    <img src="<?php echo base_url(htmlspecialchars($config->config_value)); ?>" 
                                                         alt="Thumbnail" 
                                                         class="img-thumbnail" 
                                                         style="max-width: 150px; max-height: 150px; cursor: pointer; object-fit: contain;"
                                                         onclick="window.open('<?php echo base_url(htmlspecialchars($config->config_value)); ?>', '_blank')"
                                                         id="preview_<?php echo $index; ?>"
                                                         onerror="this.onerror=null; this.src='<?php echo base_url('assets/dist/img/placeholder.png'); ?>';">
                                                    <!-- <small class="text-muted d-block">Click to view full size (supports PNG, JPG, JPEG, GIF)</small> -->
                                                </div>
                                                <div class="mt-2">
                                                    <label class="btn btn-sm btn-primary">
                                                        <i class="fa fa-upload"></i> Change Image
                                                        <input type="file" 
                                                               name="configs[<?php echo $index; ?>][image_file]" 
                                                               accept=".png,.jpg,.jpeg,.gif,image/png,image/jpeg,image/gif" 
                                                               style="display: none;"
                                                               onchange="previewImage(this, <?php echo $index; ?>)">
                                                    </label>
                                                    <small class="text-muted d-block">Upload new image (PNG, JPG, JPEG, GIF only)</small>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteConfig(<?php echo $config->row_id; ?>, '<?php echo htmlspecialchars($config->config_key, ENT_QUOTES); ?>')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No configuration data found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if(!empty($configInfo)): ?>
                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Update All Configurations
                        </button>
                    </div>
                <?php endif; ?>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Add Configuration Modal -->
<div class="modal fade" id="addConfigModal" tabindex="-1" role="dialog" aria-labelledby="addConfigModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addConfigModalLabel">Add New Configuration</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo form_open_multipart('configuration/addNewConfig', array('id' => 'addConfigForm')); ?>
      <div class="modal-body">
        <div class="form-group">
          <label for="config_key">Configuration Key <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="config_key" name="config_key" required placeholder="Enter configuration key">
        </div>
        
        <div class="form-group">
          <label for="config_type">Configuration Type <span class="text-danger">*</span></label>
          <select class="form-control" id="config_type" name="config_type" required onchange="toggleConfigValueField()">
            <option value="">Select Type</option>
            <option value="plain_text">Plain Text</option>
            <option value="image">Image</option>
          </select>
        </div>
        
        <div class="form-group" id="plain_text_field" style="display: none;">
          <label for="config_value_text">Configuration Value <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="config_value_text" name="config_value_text" placeholder="Enter configuration value">
        </div>
        
        <div class="form-group" id="image_field" style="display: none;">
          <label for="config_value_image">Upload Image <span class="text-danger">*</span></label>
          <input type="file" class="form-control" id="config_value_image" name="config_value_image" accept=".png,.jpg,.jpeg,.gif,image/png,image/jpeg,image/gif" onchange="previewNewImage(this)">
          <small class="text-muted">Allowed formats: PNG, JPG, JPEG, GIF (Max 5MB)</small>
          <div id="new_image_preview" class="mt-2" style="display: none;">
            <img id="new_preview_img" src="" alt="Preview" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Configuration</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<script>
function deleteConfig(rowId, configKey) {
    if (confirm('Are you sure you want to delete the configuration "' + configKey + '"?\n\nThis action cannot be undone.')) {
        // Show loader if available
        if (typeof showLoader === 'function') {
            showLoader();
        }
        
        // Redirect to delete URL
        window.location.href = '<?php echo base_url("configuration/deleteConfig/"); ?>' + rowId;
    }
}

function toggleConfigValueField() {
    var configType = document.getElementById('config_type').value;
    var plainTextField = document.getElementById('plain_text_field');
    var imageField = document.getElementById('image_field');
    var textInput = document.getElementById('config_value_text');
    var imageInput = document.getElementById('config_value_image');
    
    if (configType === 'plain_text') {
        plainTextField.style.display = 'block';
        imageField.style.display = 'none';
        textInput.required = true;
        imageInput.required = false;
        imageInput.value = '';
        document.getElementById('new_image_preview').style.display = 'none';
    } else if (configType === 'image') {
        plainTextField.style.display = 'none';
        imageField.style.display = 'block';
        textInput.required = false;
        imageInput.required = true;
        textInput.value = '';
    } else {
        plainTextField.style.display = 'none';
        imageField.style.display = 'none';
        textInput.required = false;
        imageInput.required = false;
    }
}

function previewNewImage(input) {
    if (input.files && input.files[0]) {
        var file = input.files[0];
        
        // Validate file type
        var validTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
        if (!validTypes.includes(file.type)) {
            alert('Please select only PNG, JPG, JPEG, or GIF images');
            input.value = '';
            document.getElementById('new_image_preview').style.display = 'none';
            return;
        }
        
        // Validate file size (5MB)
        if (file.size > 5242880) {
            alert('File size must be less than 5MB');
            input.value = '';
            document.getElementById('new_image_preview').style.display = 'none';
            return;
        }
        
        // Preview the image
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('new_preview_img').src = e.target.result;
            document.getElementById('new_image_preview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}

function previewImage(input, index) {
    if (input.files && input.files[0]) {
        var file = input.files[0];
        
        // Validate file type
        var validTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
        if (!validTypes.includes(file.type)) {
            alert('Please select only PNG, JPG, JPEG, or GIF images');
            input.value = '';
            return;
        }
        
        // Update the text input field with new filename
        var configInput = document.getElementById('config_value_' + index);
        if (configInput) {
            // Keep the path structure and just change the filename
            var currentPath = configInput.value;
            var pathParts = currentPath.split('/');
            pathParts[pathParts.length - 1] = file.name;
            configInput.value = pathParts.join('/');
        }
        
        // Preview the image
        var reader = new FileReader();
        reader.onload = function(e) {
            var preview = document.getElementById('preview_' + index);
            if (preview) {
                preview.src = e.target.result;
            }
        }
        reader.readAsDataURL(file);
    }
}
</script>