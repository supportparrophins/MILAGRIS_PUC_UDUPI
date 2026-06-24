<?php if (!defined('BASEPATH')) {
exit('No direct script access allowed');
}
require APPPATH . '/libraries/BaseControllerFaculty.php';
class FeeDashboard extends BaseController {
public function __construct()
{
    parent::__construct();
    $this->load->model('user_model');
    $this->load->model('feeDashboard_model','fee');
    $this->load->model('Students_model','student');
    $this->isLoggedIn();
}

public function viewFeeDashboard()
{
    $fee_year = $this->security->xss_clean($this->input->post('fee_year'));
    if($fee_year == '') {
        $fee_year = FEE_YEAR;
    }else {
        $fee_year  = $fee_year;
    }
    $data['fee_year'] =  $fee_year;
    $todayDate = date('Y-m-d');
    $filter = array();
    $by_class = array();
    $studentCount = array();
    $totalStudent = 0;
    $term = ['I PUC', 'II PUC'];
    $by_class[0] = 'I PUC';
    $by_class[1] = 'II PUC';
    $by_stream = $this->fee->getStreamInfo();
    $by_gender = $this->fee->getGenderInfo();
    $filter['fee_year'] =  $fee_year;
    for($i=0;$i<count($by_class);$i++){
        $class = $filter['by_class'] = $by_class[$i];
        for($j=0;$j<count($by_stream);$j++){
            $streamName = $by_stream[$j];
            $stream = $streamName->stream_name;
            $filter['term_name'] = $class;
            $filter['stream_name'] = $stream;
            for($k=0;$k<count($by_gender);$k++){
                $gender = $by_gender[$k]->gender;
                $filter['gender'] = $gender;
                $totalFeeAmount = $this->fee->getTotalFeeAmount($filter);
                $totalClgFee = $totalFeeAmount->total_fee;
                $studentPUCount[$stream][$class][$gender] = $this->fee->getTotalPUStudentsCount($class,$stream,$fee_year,$gender);
                $studentPUCFeePaid[$stream][$class][$gender] = $this->fee->getSumOfPUCFeesPaidClassWise($class,$stream,$fee_year,$gender); 
                $studentPUCGovtFeePaid[$stream][$class][$gender] = $this->fee->getSumOfPUCGovtFeesPaidClassWise($class,$stream,$fee_year,$gender); 
                $feeConcessionPUC[$stream][$class][$gender] = $this->fee->getSumOfPUCFeesConcession($class,$stream,$fee_year,$gender); 
                $studentPUCCount = $this->fee->getTotalPUStudentsCount($class,$stream,$fee_year,$gender);
                $totalFeeAmountPUC[$stream][$class][$gender] = $studentPUCCount * $totalClgFee;
            }
        }
    }
    $data['className'] = $by_class;
    $data['studentCount']=$studentPUCount;
    $data['totalStudentCount'] = $studentPUCount;
    $data['feePaidCount'] = $studentPUCFeePaid ;
    $data['studentPUCGovtFeePaid'] = $studentPUCGovtFeePaid ;
    $data['feeConcessionCount'] = $feeConcessionPUC;
    $data['totalStdFee'] = $totalFeeAmountPUC;
    $data['streamName'] = $by_stream;
    $data['genderName'] = $by_gender;
    $data['feePaidInfo'] = $this->fee->getCancelledReceiptInfo($fee_year);
    $data['inactiveStdFeePaidInfo'] = $this->fee->getInactiveStdFeePaidInfo($fee_year);
    //fees
    $data['from_date'] = $from_date = $this->security->xss_clean($this->input->post('from_date'));
    $data['to_date'] = $to_date = $this->security->xss_clean($this->input->post('to_date'));
    if(empty($from_date)){
        $from_date = date('Y-m-d');
        $to_date = date('Y-m-d');
    }
    $data['from_date'] = $from_date;
    $data['to_date'] = $to_date;
    $data['getFeePaidInfo'] = $this->fee->getFeePaidInfoOverall($from_date,$to_date,$fee_year);
    $data['getDeptFeePaidInfo'] = $this->fee->getDeptFeePaidInfoOverall($from_date,$to_date,$fee_year);
    //mis 
    $data['mis_from_date'] = $mis_from_date = $this->security->xss_clean($this->input->post('mis_from_date'));
    $data['mis_to_date'] = $mis_to_date = $this->security->xss_clean($this->input->post('mis_to_date'));
    if(empty($mis_from_date)){
        $mis_from_date = date('Y-m-d');
        $mis_to_date = date('Y-m-d');
    }
    $data['mis_from_date'] = $mis_from_date;
    $data['mis_to_date'] = $mis_to_date;
    $data['getMiscFeePaidInfo'] = $this->fee->getMiscFeePaidInfoOverall($mis_from_date,$mis_to_date,$fee_year);
    $data['feeModel'] = $this->fee;
    $data['display_type_c'] = "feeDashboard";
    $data['feesYearInfo'] = $this->fee->getFeesYearInfo();
    $this->global['pageTitle'] = ''.TAB_TITLE.' : Fees Dashboard';
    $this->loadViews("feeDashboard", $this->global, $data, null);
}
}?>