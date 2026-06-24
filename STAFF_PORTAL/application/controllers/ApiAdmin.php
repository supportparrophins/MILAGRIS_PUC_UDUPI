<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ApiAdmin extends CI_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('push_notification_model', 'notifications');
        $this->load->model('Students_model', 'student');
        $this->load->model('staff_model', 'staff');
    }


    public function GetStudentCountApi()
    {
        log_message('debug', 'I HAVE BEEN HIT');
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        $filter = array();
        // $result = $this->staff->getAllSchoolStaffInfo();
        $result = $this->student->getCountOfStudents($filter);
        $data = json_encode($result);
        echo $data;
    }


    public function GetAlumniStudentCountApi()
    {
        log_message('debug', 'I HAVE BEEN HIT');
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);     
        // $result = $this->staff->getAllSchoolStaffInfo();
        $result = $this->student->getTotalAlumniStudents();
        $data = json_encode($result);
        echo $data;
    }


    public function GetStaffCountApi()
    {
        log_message('debug', 'I HAVE BEEN HIT STAFF');
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        $filter = array();
        // $result = $this->staff->getAllSchoolStaffInfo();
        $deptInfo = $this->staff->getStaffDepartment();
        $total_staff = 0;
        foreach ($deptInfo as $dept) {
            $filter['by_dept'] = $dept->dept_id;
            $countStaff = $this->staff->staffListingCount($filter);
            $staffCount[$dept->dept_id] = $countStaff;
            $total_staff += $countStaff;
        }
        $data = json_encode($total_staff);
        echo $data;
    }

    public function GetResignedStaffCountApi()
    {
        log_message('debug', 'I HAVE BEEN HIT');
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);     
        $result = $this->staff->getResignedStaffCount();
        $data = json_encode($result);
        echo $data;
    }



    public function GetPrincipalName()
    {
        log_message('debug', 'I HAVE BEEN HIT STAFF');

        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        $filter = array();
        $filter['role'] = '1';
        $result = $this->staff->getStaffByRole($filter);
        log_message('debug', 'data11' . $result);
        $data = json_encode($result);

        echo $data;
    }

    public function GetPrimaryAdminName()
    {
        log_message('debug', 'I HAVE BEEN HIT STAFF');

        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        $filter = array();
        $filter['role'] = '15';
        $result = $this->staff->getStaffByRole($filter);
        log_message('debug', 'data11' . $result);
        $data = json_encode($result);

        echo $data;
    }

    public function getInstutitionName()
    {
        log_message('debug', 'I HAVE BEEN HIT STAFF');

        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        $baseUrl = base_url();
        $data = json_encode(['baseUrl' => $baseUrl]); // Encode the base URL in a JSON object.
        echo $data;
    }

    public function GetDepartmentList()
    {
        log_message('debug', 'I HAVE BEEN HIT STAFF');

        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        $result = $this->staff->getAllDepartmentInfo();
        log_message('debug', 'data11' . $result);

        $data = json_encode($result);
        echo $data;
    }

    public function GetRoleList()
    {
        log_message('debug', 'I HAVE BEEN HIT STAFF');
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        $result = $this->staff->getRoleList();
        log_message('debug', 'data11' . $result);

        $data = json_encode($result);
        echo $data;
    }


    //saving the notification data for staff database
    public function NotificationforInstutition()
    {
        log_message('debug', 'NotificationforInstution function has been hit.');
        $form_data = file_get_contents('php://input');
        if ($form_data === false) {
            log_message('error', 'Failed to get input: ' . error_get_last()['message']);
        } else if (empty($form_data)) {
            log_message('error', 'No input received');
        } else {
            // log_message('debug', 'Received Form Data: ' . $form_data);
            // Initialize an empty array to store decoded data
            $decoded_data = [];
            parse_str($form_data, $decoded_data);
            if (isset($decoded_data['institution_api'])) {
                $data = [
                    'department' => $decoded_data['department'],
                    'role' => $decoded_data['role'],
                    'subject' => $decoded_data['subject'],
                    'message' => $decoded_data['message'],
                    'filepath' => isset($decoded_data['filepath']) && $decoded_data['filepath'] !== '' ? $decoded_data['institution_api'] . $decoded_data['filepath'] : '',
                    'sent_by' => $decoded_data['sent_by'],
                    'notify_id'=> $decoded_data['notify_id'],
                    'date_time' => $decoded_data['date_time']

                ];
            } else {
                log_message('error', 'Institution API or filepath not found in decoded data');
            }
            $this->notifications->saveManagementNotification($data);
            // log_message('debug', 'dataaaa'.print_r($data, true));

        }
    }


    public function InstitutionTokenApi()
    {
        log_message('debug', 'I HAVE BEEN HIT STAFF');
        $form_data = file_get_contents('php://input');

        if ($form_data === false) {
            log_message('error', 'Failed to get input: ' . error_get_last()['message']);
            return;
        }
        if (empty($form_data)) {
            log_message('error', 'No input received');
            return;
        }
        // log_message('debug', 'Received Form Data: ' . $form_data);
        $decoded_data = [];
        parse_str($form_data, $decoded_data);
        //log_message('debug', 'Decoded Data: ' . print_r($decoded_data, true));
        if (isset($decoded_data['filters']['department']) && isset($decoded_data['filters']['role'])) {
            $filters = [
                'department' => $decoded_data['filters']['department'],
                'role' => $decoded_data['filters']['role']
            ];

            // Fetch staff tokens
            $staff_tokens = $this->notifications->getAllStaffsToken($filters);

            $tokenBatch = array_chunk($staff_tokens, 500);

            for ($itr = 0; $itr < count($tokenBatch); $itr++) {
                $this->notifications->sendStaffMessage($decoded_data['title'], $decoded_data['body'], $tokenBatch[$itr], 'staff');
            }
        } else {
            log_message('error', 'Department or role not found in decoded data');
        }
    }

//delete the notification from the database
    public function DeleteInstitutionNotification()
    {
        log_message('debug', 'I HAVE BEEN HIT STAFF');
        $form_data = file_get_contents('php://input');
        if ($form_data === false) {
            log_message('error', 'Failed to get input: ' . error_get_last()['message']);
            return;
        }
        if (empty($form_data)) {
            log_message('error', 'No input received');
            return;
        }

        $decoded_data = [];
        parse_str($form_data, $decoded_data);
        log_message('debug', 'Decoded Data: ' . print_r($decoded_data, true));

        $notInfo = array(
            'is_deleted' => 1

        );

        $this->notifications->updateInstututionNotification($notInfo, $decoded_data);
    }



    //curl operations for sending and receiving post data
    function httpQuestionPost($api_url, $QuestionData)
    {
        $curl = curl_init($api_url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($QuestionData));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
