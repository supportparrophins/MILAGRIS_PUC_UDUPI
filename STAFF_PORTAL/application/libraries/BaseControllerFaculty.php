<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' ); 

class BaseController extends CI_Controller {
	public function __construct() {
        parent:: __construct();   
		$this->load->model('staff_model','staff');
		$this->load->model('push_notification_model');
		$this->load->model('Access_model', 'access');
    }
	protected $role = '';
	protected $vendorId = '';
	protected $name = '';
	protected $roleText = '';
	protected $global = array ();
	protected $lastLogin = '';
	protected $email_address = '';
	protected $mobile = '';
	protected $manager_id='';
	protected $team_lead_id='';
	protected $director_id='';
	protected $profileImg='';
	
	
	/**
	 * Takes mixed data and optionally a status code, then creates the response
	 *
	 * @access public
	 * @param array|NULL $data
	 *        	Data to output to the user
	 *        	running the script; otherwise, exit
	 */
	public function response($data = NULL) {
		$this->output->set_status_header ( 200 )->set_content_type ( 'application/json', 'utf-8' )->set_output ( json_encode ( $data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) )->_display ();
		exit ();
	}
	

	/**
	 * This function used to check the user is logged in or not
	 */
	function isLoggedIn() {
		$isLoggedIn = $this->session->userdata ( 'isLoggedIn' );
		if (! isset ( $isLoggedIn ) || $isLoggedIn != TRUE) {
			redirect ( 'login' );
		} else {
			$this->role = $this->session->userdata ('role');
			$this->vendorId = $this->session->userdata ('staff_id');
			$this->staff_id = $this->session->userdata ('staff_id');
			$this->name = $this->session->userdata ('name');
			$this->roleText = $this->session->userdata ('roleText');
			$this->lastLogin = $this->session->userdata ('lastLogin');
			$this->mobile = $this->session->userdata ('mobile');
			$this->staffType = $this->session->userdata ('type');
			$this->department_id = $this->session->userdata ('dept_id');
			$this->profileImg = $this->session->userdata ('photo_url');
			$this->current_module_id = $this->session->userdata('current_module_id');
			$this->global ['name'] = $this->name;
			$this->global ['current_module_id'] = $this->current_module_id;
			$this->global ['role'] = $this->role;
			$this->global ['staffID'] = $this->staff_id;
			$this->global ['role_text'] = $this->roleText;
			$this->global ['last_login'] = $this->lastLogin;
			$this->global ['staffType'] = $this->staffType;
			$this->global ['profileImg'] = $this->profileImg;
			$staffRoleInfo = $this->staff->getStaffRole($this->staff_id);
			$this->global ['leave_approved_status'] = $staffRoleInfo->leave_approved_status;
			if($this->staff_id != '123456' && $this->staff_id != 'lsvj123'){
				$this->role = $staffRoleInfo->roleId;
				$this->roleText = $staffRoleInfo->role;
				$this->global ['role'] = $this->role;
				$this->global ['role_text'] = $this->roleText;
			}
			if($staffRoleInfo->retirement_status == 1 || $staffRoleInfo->resignation_status == 1){
				$this->logout();
			}
			
		}
	}
	
	/**
	 * This function is used to check the access
	 */
	function isAdmin() {
		if ($this->role == ROLE_ADMIN || $this->role == ROLE_PRINCIPAL || $this->role == ROLE_TEACHING_STAFF || $this->role == EXAM_COMMITTEE || $this->role == ROLE_ATTENDAR || $this->role == ROLE_AUDITOR ||
		$this->role == ROLE_NON_TEACHING_STAFF || $this->role == ROLE_OFFICE ||  $this->role == ROLE_COUNSELOR || $this->role == ROLE_ERROR_COMMITTEE || $this->role == ROLE_PE ||
		$this->role == ROLE_APPROVE_COMMITTEE || $this->role == ROLE_RECTOR || $this->role == ROLE_ACCOUNT ||  $this->role == ROLE_LIBRARY ||  $this->role == ROLE_FINANCE_OFFICER || 
		$this->role == ROLE_VICE_PRINCIPAL || $this->role == ROLE_RECEPTION || $this->role == ROLE_PRIMARY_ADMINISTRATOR || $this->role == ROLE_SUPER_ADMIN || $this->role == ROLE_SUPPORT_STAFF || $this->role == ROLE_LECTURER || $this->role == ROLE_LECTURER_OR_VICE_PRINCIPAL || $this->role == ROLE_LECTURER_OR_DEAN
		|| $this->role == ROLE_PART_TIME_LECTURER || $this->role == ROLE_PHYSICAL_DIRECTER || $this->role == ROLE_LIBRARIAN || $this->role == ROLE_PUBLIC_RELATION_OFFICER || $this->role == ROLE_SYSTEM_ADMINISTRATOR || $this->role == ROLE_CLERK || $this->role == ROLE_LIBRARY_ASSISTANT || $this->role == ROLE_COMPUTER_LAB_INSTRUCTOR
		|| $this->role == ROLE_MAINTENANCE_OFFICER || $this->role == ROLE_ATTENDER || $this->role == ROLE_DRIVER || $this->role == ROLE_PEON || $this->role == ROLE_CAMPUS_MINSISTER_AND_LECTURER || $this->role == ROLE_CLERK_OR_OFFICE_SUPERINTENDENT) {
			return false;
		} else {
			return false;
		}
	}

	function isSuperAdmin() {
		if ($this->role == ROLE_PRIMARY_ADMINISTRATOR || $this->role == ROLE_ADMIN || $this->role == ROLE_PRINCIPAL || $this->role == ROLE_ACCOUNT ||
		$this->role == ROLE_VICE_PRINCIPAL || $this->role == ROLE_OFFICE || $this->role == ROLE_SUPER_ADMIN) {
			return true;
		} else {
			return true;
		}
	}
	
	/**
	 * This function is used to check the access
	 */
	function isTicketter() {
		if ($this->role != ROLE_ADMIN || $this->role == ROLE_TEACHING_STAFF) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * This function is used to load the set of views
	 */
	function loadThis() {
		$this->global ['pageTitle'] = 'Schoolphins : Access Denied';
		$this->load->view ('includes/header', $this->global );
		$this->load->view ('access' );
		$this->load->view ('includes/footer' );
	}
	
	/**
	 * This function is used to logged out user from system
	 */
	function logout() {
		$this->session->sess_destroy ();
		
		redirect ( 'login' );
	}

	/**
     * This function used to load views
     * @param {string} $viewName : This is view name
     * @param {mixed} $headerInfo : This is array of header information
     * @param {mixed} $pageInfo : This is array of page information
     * @param {mixed} $footerInfo : This is array of footer information
     * @return {null} $result : null
     */
    function loadViews($viewName = "", $headerInfo = NULL, $pageInfo = NULL, $footerInfo = NULL){
		$headerInfo['notifications'] = $this->push_notification_model->getStaffNotificationswithLimit($this->role,$this->department_id);
		$headerInfo['institutionList'] = $this->staff->getAllInstitutionInfo();
		$headerInfo['ModuleInfo'] = $this->staff->getAllModuleInfo();
		$headerInfo['staffModel'] = $this->staff;
        $this->load->view('includes/header_menu_access', $headerInfo);
        $this->load->view($viewName, $pageInfo);
        $this->load->view('includes/footer', $footerInfo);
    }
	
	function paginationCompress($link, $count, $perPage = 100, $segment = SEGMENT) {
		$this->load->library ( 'pagination' );

		$config ['base_url'] = base_url () . $link;
		$config ['total_rows'] = $count;
		$config ['uri_segment'] = $segment;
		$config ['per_page'] = $perPage;
		$config ['num_links'] = 5;
		$config ['full_tag_open'] = '<nav><ul class="pagination">';
		$config ['full_tag_close'] = '</ul></nav>';
		$config ['first_tag_open'] = '<li class="arrow">';
		$config ['first_link'] = 'First';
		$config ['first_tag_close'] = '</li>';
		$config ['prev_link'] = 'Previous';
		$config ['prev_tag_open'] = '<li class="arrow">';
		$config ['prev_tag_close'] = '</li>';
		$config ['next_link'] = 'Next';
		$config ['next_tag_open'] = '<li class="arrow">';
		$config ['next_tag_close'] = '</li>';
		$config ['cur_tag_open'] = '<li class="active"><a href="#">';
		$config ['cur_tag_close'] = '</a></li>';
		$config ['num_tag_open'] = '<li>';
		$config ['num_tag_close'] = '</li>';
		$config ['last_tag_open'] = '<li class="arrow">';
		$config ['last_link'] = 'Last';
		$config ['last_tag_close'] = '</li>';

		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
		// $config['next_tag_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close']  = '</span></li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close'] = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']  = '</span></li>';
		$this->pagination->initialize ( $config );
		$page = $config ['per_page'];
		$segment = $this->uri->segment ( $segment );
	
		return array (
				"page" => $page,
				"segment" => $segment
		);
	}

	function checkSMSBalance(){
		$apiKey = urlencode(API_KEY);
		// Prepare data for POST request
		$data = array('apikey' => $apiKey);
		// Send the POST request with cURL
		$ch = curl_init('https://api.textlocal.in/balance/');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		$json = json_decode($response, true);
		// Process your response here
		//log_message('error', 'JSON='.print_r($json['balance']['sms'],true));
		return  $json['balance']['sms'];
	   // return $json;
 
	}

	function pushNotification($token,$title,$body,$key_name){
		$data = [
		"tokens" => $token,
		"title" => $title,
		"body" => $body,
		"keyName" => $key_name,
		"dataPayload" => [
			"key1" => "value1",
			"key2" => "value2"
		]
	];
	
	// Convert data to JSON
	$jsonData = json_encode($data);
	$url = "http://node.parrophins.com/send-notification/";
	
	// Initialize cURL session
	$ch = curl_init($url);
	
	// Set cURL options
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Content-Type: application/json',
		'Content-Length: ' . strlen($jsonData)
	]);
	
	$response = curl_exec($ch);
	curl_close($ch);
	}
		public function getCurrentAccess()
    {
		// log_message('debug', 'Inside getCurrentAccess()');
        $role_id = $this->session->userdata('role');
        $sub_module_id = $this->session->userdata('current_module_id');
		// log_message('debug', 'role_id: '.$role_id.', sub_module_id: '.$sub_module_id);
		 $staff_id = $this->session->userdata ('staff_id');
		if(empty($sub_module_id)){
			$sub_module_id = "1";
		}
        if (empty($role_id) || empty($sub_module_id)) {
            return null;
        }
	
        $access = $this->access->getRoleAccessByStaffID($staff_id, $sub_module_id);

		// If no staff-specific access found, check role-based access
		if (!$access) {
			$access = $this->access->getRoleAccess($role_id, $sub_module_id);
		}

		return $access;
    }
}