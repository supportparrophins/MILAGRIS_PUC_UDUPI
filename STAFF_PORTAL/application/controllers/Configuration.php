<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Configuration extends BaseController {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('configuration_model', 'configuration');
        $this->isLoggedIn();
        $this->load->helper('file');
    }

    public function configureMenuAccess()
    {
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {
            $data['configInfo'] = $this->configuration->getAllConfigInfo();
            $this->global['pageTitle'] = 'Configure Menu Access';
            $this->loadViews("configuration/configureMenuAccess", $this->global, $data, NULL);
        }
    }

    public function updateBulkConfig()
    {
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->session->set_flashdata('error', 'Unauthorized access');
            redirect('configuration/configureMenuAccess');
            return;
        }
        
        $configs = $this->input->post('configs');
        
        if(empty($configs)){
            $this->session->set_flashdata('error', 'No configuration data to update');
            redirect('configuration/configureMenuAccess');
            return;
        }

        $updateCount = 0;
        $errorCount = 0;

        $upload_path = './assets/dist/img/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $config_upload = array(
            'upload_path'   => $upload_path,
            'allowed_types' => 'png|jpg|jpeg|gif',
            'max_size'      => 5120,
            'encrypt_name'  => TRUE
        );

        $this->load->library('upload', $config_upload);

        foreach($configs as $index => $configData){
            $updateData = array(
                'config_value' => $configData['config_value'],
                'updated_by' => $this->staff_id,
                'updated_at' => date('Y-m-d H:i:s')
            );

            if(isset($_FILES['configs']['name'][$index]['image_file']) && 
               !empty($_FILES['configs']['name'][$index]['image_file'])){
                
                $_FILES['single_file']['name'] = $_FILES['configs']['name'][$index]['image_file'];
                $_FILES['single_file']['type'] = $_FILES['configs']['type'][$index]['image_file'];
                $_FILES['single_file']['tmp_name'] = $_FILES['configs']['tmp_name'][$index]['image_file'];
                $_FILES['single_file']['error'] = $_FILES['configs']['error'][$index]['image_file'];
                $_FILES['single_file']['size'] = $_FILES['configs']['size'][$index]['image_file'];

                if($this->upload->do_upload('single_file')){
                    $upload_data = $this->upload->data();
                    $new_image_path = 'assets/dist/img/' . $upload_data['file_name'];
                    
                    $old_value = $configData['config_value'];
                    if(file_exists($old_value) && strpos($old_value, 'assets/dist/img/') !== false){
                        @unlink($old_value);
                    }
                    
                    $updateData['config_value'] = $new_image_path;
                } else {
                    $errorCount++;
                    continue;
                }
            }

            $result = $this->configuration->updateConfig($configData['row_id'], $updateData);
            
            if($result){
                $updateCount++;
            } else {
                $errorCount++;
            }
        }

        if($updateCount > 0){
            $this->session->set_flashdata('success', $updateCount . ' configuration(s) updated successfully');
        }
        
        if($errorCount > 0){
            $this->session->set_flashdata('warning', $errorCount . ' configuration(s) failed to update');
        }

        redirect('configuration/configureMenuAccess');
    }

    public function addNewConfig()
    {
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->session->set_flashdata('error', 'Unauthorized access');
            redirect('configuration/configureMenuAccess');
            return;
        }
        
        $config_key = trim($this->input->post('config_key'));
        $config_type = $this->input->post('config_type');
        
        if(empty($config_key) || empty($config_type)){
            $this->session->set_flashdata('error', 'Configuration key and type are required');
            redirect('configuration/configureMenuAccess');
            return;
        }
        
        // Check if config key exists (including soft-deleted ones)
        $existingConfig = $this->configuration->getConfigByKeyIncludingDeleted($config_key);
        
        if($existingConfig && $existingConfig->is_deleted == 0){
            $this->session->set_flashdata('error', 'Configuration key "' . htmlspecialchars($config_key) . '" already exists.');
            redirect('configuration/configureMenuAccess');
            return;
        }
        
        $config_value = '';
        
        if($config_type === 'plain_text'){
            $config_value = $this->input->post('config_value_text');
            if(empty($config_value)){
                $this->session->set_flashdata('error', 'Configuration value is required');
                redirect('configuration/configureMenuAccess');
                return;
            }
        } else if($config_type === 'image'){
            if(empty($_FILES['config_value_image']['name'])){
                $this->session->set_flashdata('error', 'Image file is required');
                redirect('configuration/configureMenuAccess');
                return;
            }
            
            $upload_path = './assets/dist/img/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }
            
            $config_upload = array(
                'upload_path'   => $upload_path,
                'allowed_types' => 'png|jpg|jpeg|gif',
                'max_size'      => 5120,
                'encrypt_name'  => TRUE
            );
            
            $this->load->library('upload', $config_upload);
            
            if($this->upload->do_upload('config_value_image')){
                $upload_data = $this->upload->data();
                $config_value = 'assets/dist/img/' . $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('error', 'Image upload failed: ' . $this->upload->display_errors('', ''));
                redirect('configuration/configureMenuAccess');
                return;
            }
        }
        
        // If exists and is soft-deleted, restore it with new value
        if($existingConfig && $existingConfig->is_deleted == 1){
            $updateData = array(
                'config_value' => $config_value,
                'is_deleted' => 0,
                'updated_by' => $this->staff_id,
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            $result = $this->configuration->restoreConfig($existingConfig->row_id, $updateData);
            
            if($result){
                $this->session->set_flashdata('success', 'Configuration restored and updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to restore configuration');
            }
        } else {
            // Insert new configuration
            $insertData = array(
                'config_key' => $config_key,
                'config_value' => $config_value,
                'created_by' => $this->staff_id,
                'created_at' => date('Y-m-d H:i:s')
            );
            
            $result = $this->configuration->addConfig($insertData);
            
            if($result){
                $this->session->set_flashdata('success', 'Configuration added successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to add configuration');
            }
        }
        
        redirect('configuration/configureMenuAccess');
    }

    public function deleteConfig($rowId = null)
    {
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->session->set_flashdata('error', 'Unauthorized access');
            redirect('configuration/configureMenuAccess');
            return;
        }
        
        if(empty($rowId)){
            $this->session->set_flashdata('error', 'Invalid configuration ID');
            redirect('configuration/configureMenuAccess');
            return;
        }
        
        $configData = $this->configuration->getConfigById($rowId);
        
        if(!$configData){
            $this->session->set_flashdata('error', 'Configuration not found');
            redirect('configuration/configureMenuAccess');
            return;
        }
        
        $deleteData = array(
            'is_deleted' => 1,
            'updated_by' => $this->staff_id,
            'updated_at' => date('Y-m-d H:i:s')
        );
        
        $result = $this->configuration->softDeleteConfig($rowId, $deleteData);
        
        if($result){
            $this->session->set_flashdata('success', 'Configuration "' . htmlspecialchars($configData->config_key) . '" deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete configuration');
        }
        
        redirect('configuration/configureMenuAccess');
    }
}
