<?php if(!defined('BASEPATH')) exit('No direct script access allowed');



require APPPATH . '/libraries/BaseController.php';
require APPPATH . '/third_party/encdec_paytm.php';





class Course extends BaseController

{

    /**

     * This is default constructor of the class

     */

    public function __construct()

    {

        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('student_model');


        $this->isLoggedIn();   

    }

    



    /**

     * This function used to show login history

     * @param number $userId : This is user id

     */




    public function courseRegistrationFeeProcess(){
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0");
        $checkSum = "";
        $paramList = array();
        $remarks = 'Course registration FEE 2020';
        $studentInfo = $this->student_model->getStudentInfoById($this->student_id,$this->term_name);
        $course_name = $this->input->post('course_name');

        $isExistCourse = $this->student_model->getInfoCourse_Register($studentInfo->student_id,$course_name);
        if(!empty($isExistCourse)){
            if($isExistCourse->payment_status == 1){
                $this->session->set_flashdata('error', 'Course Already Registered');
                redirect('dashboard');
            }
        }

         $_SESSION['course_name'] =  $course_name; 

        if($course_name == 'Stock Market'){
            $fee_amount = '1250';
        }else if($course_name == 'Tally'){
            $fee_amount = '3000';
        }else if($course_name == 'Advance Excell'){
            $fee_amount = '3000';
        }
        $paymentLog = array(
            'mid'=>PAYTM_MERCHANT_MID,
            'student_id' =>$studentInfo->student_id,
            'remarks' =>$remarks,
            'fee_amount' => $fee_amount,
            'course_name' => $course_name,
            'payment_status' =>'PENDING',
            'payment_date' => date('Y-m-d'),
            'payment_time' => date('h:i:s'),
            'created_by' => $studentInfo->student_id,
            'created_date_time' => date('Y-m-d H:i:s')
        );
        $response = $this->student_model->addCourseRegistrationFeePaymentLog($paymentLog);

        $CUST_ID = "MUNNEW".$studentInfo->application_no;
        $INDUSTRY_TYPE_ID = "Retail";
        $CHANNEL_ID = "WEB";
        $TXN_AMOUNT = $fee_amount;
        if($response > 0){
            $ORDER_ID = 'RN1_'.$response;
            $payInfo = array('order_id' =>$ORDER_ID);
            $this->student_model->updateCoursePaymentLogByRowId($payInfo, $response);
            $_SESSION['order_id'] = $ORDER_ID;
        }
        $stdCourseInfo = array(
            'student_id' => $studentInfo->student_id,
            'course_name' => $course_name,
            'year'      =>2022,
            // 'paytm_order_id' => $ORDER_ID,
            'paid_amount' => $fee_amount,
        );
        $isExistCourse = $this->student_model->getInfoCourse_Register($studentInfo->student_id,$course_name);
        if(empty($isExistCourse)){
            $this->student_model->addCourseRegister($stdCourseInfo);
        
        }
    //     // Create an array having all required parameters for creating checksum.
        $paramList["MID"] = PAYTM_MERCHANT_MID;
        $paramList["ORDER_ID"] = $ORDER_ID;
        $paramList["CUST_ID"] = $CUST_ID;
        $paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
        $paramList["CHANNEL_ID"] = $CHANNEL_ID;
        $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
        $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;


        $paramList["CALLBACK_URL"] = base_url()."payTmCourseRegFeePaymentResponse";
        /*$paramList["MSISDN"] = $MSISDN; //Mobile number of customer
        $paramList["EMAIL"] = $EMAIL; //Email ID of customer
        $paramList["VERIFIED_BY"] = "EMAIL"; //
        $paramList["IS_USER_VERIFIED"] = "YES"; //
        */

        //Here checksum string will return by getChecksumFromArray() function.
        $checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);
        $data['checkSum'] = $checkSum;
        $data['paramList'] = $paramList;
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Course Reg Payment';
        $this->loadViews("course_registration/paytm_payment_process", $this->global , $data ,NULL);
             
    }
    


    

    function payTmCourseRegFeePaymentResponse(){
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0");

        $paytmChecksum = "";
        $paramList = array();
        $isValidChecksum = "FALSE";
        
        $paramList = $_POST;
        $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
        $data['application_applied_status'] = false;
        //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
        $isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.
        if($isValidChecksum == true){ 
            if($_POST['STATUS'] == 'TXN_SUCCESS'){
                $stdCourseInfo = array(
                    'paytm_order_id' => $_POST['ORDERID'],
                    'payment_status' => 1
                ); 
                    $payInfo = array(
                        'payment_mode' => $_POST['PAYMENTMODE'],
                        'reference_number'=>$_POST['TXNID'],
                        'payment_status' =>'SUCCESS',
                        'fee_amount' => $_POST['TXNAMOUNT']);
                        $this->session->set_flashdata('success', 'Thank You! Course registration payment paid');
            } else {
                $stdCourseInfo = array(
                    'paytm_order_id' => $_POST['ORDERID'],
                    'payment_status' => 0
                );
                $payInfo = array(
                    'payment_mode' => $_POST['PAYMENTMODE'],
                    'reference_number'=>$_POST['TXNID'],
                    'payment_status' =>'FAILED',
                    'fee_amount' => $_POST['TXNAMOUNT']);
                    $this->session->set_flashdata('error', 'Course registration payment failed! Try Again');
            }
           
        }

        $this->student_model->updateCourseRegister($stdCourseInfo,$this->student_id,$_SESSION['course_name']);
        $this->student_model->updateCoursePaymentLogByOrderId($payInfo,$_POST['ORDERID']);
      
        redirect("dashboard");

    }


    


}



?>