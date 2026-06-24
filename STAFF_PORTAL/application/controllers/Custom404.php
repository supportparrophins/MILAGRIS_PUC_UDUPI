<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Custom404 extends CI_Controller {
    public function index() {
        // Redirect to a specific function
        $role = $this->session->userdata('role');
        if($role == ROLE_SUPER_ADMIN){
            redirect('adminDashboard');
        }else{
            redirect('dashboard');
        }
    }
}

?>