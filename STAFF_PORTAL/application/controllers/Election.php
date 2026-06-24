<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Election extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('students_model','student');
        $this->load->model('election_model','election');
        $this->load->model('settings_model','settings');
        
        // $this->load->library('excel');
        $this->load->library('pagination');
        // $this->load->library('pdf');
        $this->isLoggedIn();   
    } 

    function electionDetails()
    {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {
            $filter = array();
            $voteCount = array();
            $application_no = $this->security->xss_clean($this->input->post('application_no'));
            $post_name = $this->security->xss_clean($this->input->post('post_name'));
            $election_date = $this->security->xss_clean($this->input->post('election_date'));
            $program_name = $this->security->xss_clean($this->input->post('program_name'));
            
            $data['application_no'] = $filter['application_no'] = $application_no;
            $data['post_name']  = $filter['post_name'] = $post_name;
            $data['election_date']  = $filter['election_date'] = $election_date;
            $data['program_name']  = $filter['program_name'] = $program_name;

            $count = $this->election->getAllStudentElectionInfoCount($filter);
            $returns = $this->paginationCompress("electionDetails/", $count, 100);
            $data['electionRecordsCount'] = $count;
            $data['studentElectionRecords'] = $this->election->getAllStudentElectionInfo($filter,$returns["page"], $returns["segment"]);
            foreach($data['studentElectionRecords'] as $cand){
                $voteCount[$cand->row_id] = $this->election->getTotalVotesGain($cand->row_id);
            }
            $data['voteCount'] = $voteCount;
            $data['studentInfo'] = $this->student->getStudentInfoByApplicationNumber();
            $data['postInfo'] = $this->settings->getAllPostInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Election Details';
            $this->loadViews("election/election", $this->global,$data, NULL);

        }
    }

    public function addNewStudentElection(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('application_no','Application Number','trim|required');
            $this->form_validation->set_rules('post_name','Post Name','trim|required');
            if($this->form_validation->run() == FALSE) {
                $this->viewHolidayList();
            } else {
                $application_no = $this->security->xss_clean($this->input->post('application_no'));
                $post_name = $this->security->xss_clean($this->input->post('post_name'));
                $election_date = $this->security->xss_clean($this->input->post('election_date'));
                $winning_status = $this->security->xss_clean($this->input->post('winning_status'));
                $program_name = $this->security->xss_clean($this->input->post('program_name'));
                
                $electionInfo = array(
                    'election_date' => date('Y-m-d',strtotime($election_date)),
                    'application_no' => $application_no,
                    'post_name' => $post_name,
                    'program_name' => $program_name,
                    'winning_status' =>$winning_status,
                    'created_by' => $this->staff_id,
                    'created_date_time' =>date('Y-m-d H:i:s')
                );
                $return_id = $this->election->addNewStudentElection($electionInfo);
                if($return_id > 0){
                    $this->session->set_flashdata('success', 'New Election Candidate Added Successfully');
                }else{
                    $this->session->set_flashdata('error', 'New Election Candidate failed to add');
                }
                redirect('electionDetails');
            }
        }
    }


    public function editStudentElection($row_id = null)
    {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            if ($row_id == null) {
                redirect('electionDetails');
            }
            $data['studentInfo'] = $this->student->getStudentInfoByApplicationNumber();
            $data['postInfo'] = $this->settings->getAllPostInfo();
            $data['electionInfo'] = $this->election->getStudentElectionInfoById($row_id);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit Student Election Details';
            $this->loadViews("election/editStudentElection", $this->global, $data, null);
        }
    }

    public function updateStudentElection(){
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
            $this->form_validation->set_rules('application_no','Application Number','trim|required');
            //$this->form_validation->set_rules('post_name','Post Name','trim|required');
            if($this->form_validation->run() == FALSE) {
                redirect('editStudentElection/'.$row_id);  
            } else {
                    $image_path="";
                    $config=['upload_path' => './upload/',
                    'allowed_types' => 'gif|jpg|png|jpeg','overwrite' => TRUE,];
                    $this->load->library('upload', $config);
                    if($this->upload->do_upload()){
                        $post=$this->input->post();
                        $data=$this->upload->data();
                        $image_path= "upload/".$data['raw_name'].$data['file_ext'];
                        $post['image_path']=$image_path;
                    }

                    $application_no = $this->security->xss_clean($this->input->post('application_no'));
                   $program_name = $this->security->xss_clean($this->input->post('program_name'));
                    $election_date = $this->security->xss_clean($this->input->post('election_date'));
                    $post_name = $this->security->xss_clean($this->input->post('post_name'));
                    $winning_status = $this->security->xss_clean($this->input->post('winning_status'));
               
                    $electionInfo = array(
                 //   'election_date' => date('Y-m-d',strtotime($election_date)),
                    'application_no' => $application_no,
                    'program_name' => $program_name,
                    'post_name' => $post_name,
                  //  'winning_status' =>$winning_status,
                    'updated_by'=>$this->staff_id,
                    'updated_date_time'=>date('Y-m-d H:i:s'));
                     if(!empty($image_path)){
                        $electionInfo['photo_url'] = $image_path;
                    }
                $result = $this->election->updateStudentElection($electionInfo, $row_id);

                if($result > 0) {
                    $this->session->set_flashdata('success', 'Candidate Info Updated Successfully');
                } else {
                    $this->session->set_flashdata('error', 'Candidate Info Update failed');
                }
                redirect('editStudentElection/'.$row_id);  
            }
        }
    }

    public function deleteStudentElection(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $electionInfo = array('is_deleted' => 1,'updated_by'=>$this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->election->updateStudentElection($electionInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

}
?>