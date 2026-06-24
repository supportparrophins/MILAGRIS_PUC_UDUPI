<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerFaculty.php';

class LibraryManagement extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('library_model','library');
        $this->isLoggedIn();   

         //load library
		$this->load->library('zend');
    }

    function libraryManagementSystem()
    {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $filter = array();
            $access_no = $this->security->xss_clean($this->input->post('access_no'));
            $isbn = $this->security->xss_clean($this->input->post('isbn'));
            $category = $this->security->xss_clean($this->input->post('category'));
            $book_title = $this->security->xss_clean($this->input->post('book_title'));
            $author_name = $this->security->xss_clean($this->input->post('author_name'));
            $publisher_name = $this->security->xss_clean($this->input->post('publisher_name'));
            $shelf_no = $this->security->xss_clean($this->input->post('shelf_no'));
            $bill_date = $this->security->xss_clean($this->input->post('bill_date'));
            $bill_no = $this->security->xss_clean($this->input->post('bill_no'));
            $price = $this->security->xss_clean($this->input->post('price'));
            $no_of_copies = $this->security->xss_clean($this->input->post('no_of_copies'));
            $year = $this->security->xss_clean($this->input->post('year'));
            
            $data['access_no'] = $access_no;
            $data['isbn'] = $isbn;
            $data['category'] = $category;
            $data['book_title'] = $book_title;
            $data['author_name'] = $author_name;
            $data['publisher_name'] = $publisher_name;
            $data['shelf_no'] = $shelf_no;
            $data['bill_no'] = $bill_no;
            $data['price'] = $price;
            $data['no_of_copies'] = $no_of_copies;
            $data['year'] = $year;
            
            
            $filter['access_no'] = $access_no;
            $filter['isbn'] = $isbn;
            $filter['category'] = $category;
            $filter['book_title'] = $book_title;
            $filter['author_name'] = $author_name;
            $filter['publisher_name'] = $publisher_name;
            $filter['shelf_no'] = $shelf_no;
            $filter['bill_no'] = $bill_no;
            $filter['price'] = $price;
            $filter['no_of_copies'] = $no_of_copies;
            $filter['year'] = $year;

            if(!empty($bill_date)){
	            $filter['bill_date'] = date('Y-m-d',strtotime($bill_date));
	            $data['bill_date'] = date('d-m-Y',strtotime($bill_date));
	        }else{
	            $data['bill_date'] = '';
	        }

            $this->load->library('pagination');
            $count = $this->library->getAllLibraryMgmtCount($filter);
            $returns = $this->paginationCompress("libraryManagementSystem/", $count, 100);
            $data['totalLibraryMgmtCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['libraryMgmtInfo'] = $this->library->getAllLibraryMgmtInfo($filter, $returns["page"], $returns["segment"]);
            $data['accessInfo'] = $this->getCurrentAccess();
            
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Library Managment Details';
            $this->loadViews("libraryManagement/manageBook", $this->global, $data, NULL);

        }
    }

    function addLibraryInfo() {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {
            $data['categoryInfo'] = $this->library->getCategoryInfo();
            $data['authorInfo'] = $this->library->getAuthorInfo();
            $data['publisherInfo'] = $this->library->getPublisherInfo();
            $data['shelfInfo'] = $this->library->getShelfInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Add New Book Details';
            $this->loadViews("libraryManagement/addBooks", $this->global,$data, NULL);
        }
    }

    public function addLibraryBookToDB(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
          
            $this->form_validation->set_rules('book_title','book title','required'); 
            $this->form_validation->set_rules('category','category','required');
            $this->form_validation->set_rules('author_name', 'author name', 'trim|required');
            $this->form_validation->set_rules('publisher_name', 'publisher name', 'trim|required');
            //$this->form_validation->set_rules('shelf_no', 'shelf no', 'trim|required');
            $this->form_validation->set_rules('access_code', 'Access code', 'trim|required');
            if($this->form_validation->run() == FALSE) {
                $this->libraryManagementSystem();
            } else {
                $access_code = $this->security->xss_clean($this->input->post('access_code'));   
                $isbn =$this->security->xss_clean($this->input->post('isbn'));
                $book_title =$this->security->xss_clean($this->input->post('book_title'));
                $category = $this->security->xss_clean($this->input->post('category'));
                $author_name = $this->security->xss_clean($this->input->post('author_name'));
                $publisher_name = $this->security->xss_clean($this->input->post('publisher_name'));
                $shelf_no = $this->security->xss_clean($this->input->post('shelf_no'));
                $bill_no = $this->security->xss_clean($this->input->post('bill_no'));
                $bill_date = $this->security->xss_clean($this->input->post('bill_date'));
                $price = $this->security->xss_clean($this->input->post('price'));
                $no_of_copies = $this->security->xss_clean($this->input->post('no_of_copies'));
                $year = $this->security->xss_clean($this->input->post('year'));
                $pages = $this->security->xss_clean($this->input->post('pages'));
              
                
                $isAccessExist = $this->library->checkAccessNumberExists($access_code);
                $image_path="";
                $target_dir="upload/library/";
                if(!file_exists($target_dir)){
                    mkdir($target_dir,0777);
                }
                $config=['upload_path' => $target_dir,
                'allowed_types' => 'pdf|jpeg|jpg|png','overwrite' => TRUE,'max_size' => '2048',
                'overwrite' => TRUE,'file_ext_tolower' => TRUE];
                $this->load->library('upload', $config);
                if($this->upload->do_upload()) {
                    $post=$this->input->post();
                    $data=$this->upload->data();
                    $image_path=$target_dir.$data['raw_name'].$data['file_ext'];
                    $post['image_path']=$image_path;
                }
               
               $books = array();
                //$last_access_no = $this->library->getLastAccessId();
             

                for ($i = 0; $i < $no_of_copies; $i++) {
                $libraryInfo = array(
                    'access_code'=>$access_code + $i,
                    'isbn'=>$isbn,
                    'upload_pdf'=>$image_path,
                    'book_title'=>$book_title,
                    'publisher_name'=>$publisher_name,
                    'author_name'=>$author_name,
                    'category'=>$category,
                    'shelf_no'=>$shelf_no,
                    'bill_no'=>$bill_no,
                    'price'=>$price,
                    'no_of_copies' => $i == 0 ? $no_of_copies : '',
                    'year'=>$year,
                    'no_of_page'=>$pages,
                    'bill_date'=>date('Y-m-d',strtotime($bill_date)),
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));
                    array_push($books, $libraryInfo);
                }
               
                //log_message('debug','lib'.print_r($books,true));
                if($isAccessExist == 0){
                    $returnId = $this->library->addLibraryMgmtInfo($books);
                }
                
                if($returnId > 0 ){
                    $this->session->set_flashdata('success', 'Library Info Added Successfully');
                } else if($isAccessExist > 0) {
                    $this->session->set_flashdata('error', 'Library Access No. already exists');
                }else{
                    $this->session->set_flashdata('error', 'Library Adding  failed');
                } 
                redirect('libraryManagementSystem');  
        
          }
        }
    }

    public function getAccessCode(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $filter = array();
            $accessCode = $this->input->post("accessCode");
            
            $data['result'] = $this->library->getCheckAccessCode($accessCode);
            header('Content-type: text/plain'); 
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        }
    }

    public function editLibrary($row_id = null)
    {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            if ($row_id == null) {
                redirect('libraryManagementSystem');
            }
            $data['libraryInfo'] = $this->library->getLibraryInfoById($row_id);
            $data['categoryInfo'] = $this->library->getCategoryInfo();
            $data['authorInfo'] = $this->library->getAuthorInfo();
            $data['publisherInfo'] = $this->library->getPublisherInfo();
            $data['shelfInfo'] = $this->library->getShelfInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit Library Details';
            $this->loadViews("libraryManagement/editLibraryInfo", $this->global, $data, null);
        }
    }

    public function updateLibrary(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else { 
            $this->load->library('form_validation');

            $this->form_validation->set_rules('access_code', 'Access Code', 'trim|required');
            $this->form_validation->set_rules('book_title','book title','required'); 
          //  $this->form_validation->set_rules('category','category','required');
            $this->form_validation->set_rules('author_name', 'author name', 'trim|required');
            $this->form_validation->set_rules('publisher_name', 'publisher name', 'trim|required');
           // $this->form_validation->set_rules('shelf_no', 'shelf no', 'trim|required');

            $row_id = $this->input->post('row_id');
           
            if($this->form_validation->run() == FALSE){
                $this->editLibrary();
            } else {
                $filter = array();
                $access_code =$this->security->xss_clean($this->input->post('access_code'));
                $isbn =$this->security->xss_clean($this->input->post('isbn'));
                $book_title =$this->security->xss_clean($this->input->post('book_title'));
                $category = $this->security->xss_clean($this->input->post('category'));
                $author_name = $this->security->xss_clean($this->input->post('author_name'));
                $publisher_name = $this->security->xss_clean($this->input->post('publisher_name'));
                $shelf_no = $this->security->xss_clean($this->input->post('shelf_no'));
                $bill_no = $this->security->xss_clean($this->input->post('bill_no'));
                $bill_date = $this->security->xss_clean($this->input->post('bill_date'));
                $price = $this->security->xss_clean($this->input->post('price'));
                $no_of_copies = $this->security->xss_clean($this->input->post('no_of_copies'));
                $year = $this->security->xss_clean($this->input->post('year'));
                $pages = $this->security->xss_clean($this->input->post('pages'));
                $image_path="";
                $target_dir="upload/library/";
                if(!file_exists($target_dir)){
                    mkdir($target_dir,0777);
                }

                $config=['upload_path' => $target_dir,
                'allowed_types' => 'pdf|jpeg|jpg|png','overwrite' => TRUE,'max_size' => '2048',
                'overwrite' => TRUE,'file_ext_tolower' => TRUE];
                $this->load->library('upload', $config);
                if($this->upload->do_upload()) {
                    $post=$this->input->post();
                    $data=$this->upload->data();
                    $image_path=$target_dir.$data['raw_name'].$data['file_ext'];
                    $post['image_path']=$image_path;
                }

                $libraryInfo= array(
                    'access_code'=> $access_code,
                    'isbn'=>$isbn,
                    'book_title'=>$book_title,
                    'publisher_name'=>$publisher_name,
                    'author_name'=>$author_name,
                    'category'=>$category,
                    'shelf_no'=>$shelf_no,
                    'bill_no'=>$bill_no,
                    'bill_date'=>date('Y-m-d',strtotime($bill_date)),
                    'price'=>$price,
                    'no_of_copies'=>$no_of_copies,
                    'year'=>$year,
                    'no_of_page'=>$pages,
                    'updated_by' => $this->staff_id,
                    'updated_date_time' => date('Y-m-d h:i:s'));

                if(!empty($image_path)){
                    $libraryInfo['upload_pdf'] = $image_path;
                }

                $return_id = $this->library->updateBookInfo($row_id,$libraryInfo);
                if($return_id == true){
                    $this->session->set_flashdata('success', 'Library info Updated Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Failed to update ');
                }
                redirect('editLibrary/'.$row_id);
            }
            
        }
    }

    public function deleteLibraryDetails(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $libraryInfo = array('is_deleted' => 1,'updated_by' => $this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->library->updateLibraryInfo($libraryInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function viewIssueBook() {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {
            $data['accessInfo'] = $this->library->getAllAccessInfo();
            $data['studentInfo'] = $this->library->getAllStudentInfo();
            $data['staffInfo'] = $this->library->getAllStaffInfo();
            $data['isbnInfo'] = $this->library->getAllIsbnInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Issue Book';
            $this->loadViews("libraryManagement/issueBook", $this->global, $data, null);  
        }
    }

    public function getAccessData(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{          
            $access_code = $this->security->xss_clean($this->input->post('access_code'));
            $info = $this->library->getAccessData($access_code);
            echo json_encode($info);
            exit(0);
        }
    }

    function viewBarCodeGenerater()
    {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        }else{
            
            $data['barcode_title'] = 'Barcode Generator';
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Barcode generator';
            $this->loadViews("libraryManagement/barcodeGenerator", $this->global, $data, null);
        }
    }

    function generateBarcode()
    {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        }else{
            $generate_barcode =$this->input->post('barcode_text');
            $delete_barcode =$this->input->post('delete_barcode');
            $data['generate_barcode'] = $this->set_barcode($generate_barcode);
            redirect('viewBarCodeGenerater');
        }
    }

    function set_barcode($code)
	{
		//load in folder Zend
		$this->zend->load('Zend/Barcode');
		//generate barcode
		$file = Zend_Barcode::draw('code128', 'image', array('text'=>$code), array());
		    $code = time().$code;
		    $barcodeRealPath = APPPATH. '/cache/'.$code.'.png';
		    $barcodePath = APPPATH.'/cache/';

		    header('Content-Type: image/png');
		    $store_image = imagepng($file,$barcodeRealPath);
		    return $barcodePath.$code.'.png';
	}

    public function viewprintBarcode(){
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            
            $print_barcode =$this->input->post('print_barcode');
            // $data['print_barcode'] = explode(',',$print_barcode);
            $data['print_barcode'] = $print_barcode;

            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman','format' => 'A4-L']);
            $mpdf->AddPage('P','','','','',7,7,7,7,8,8);
            $mpdf->SetTitle('Bar Code');
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Barcode';

            $html = $this->load->view('libraryManagement/viewBarCodePrint',$data,true);
            $mpdf->WriteHTML($html);
           
            $mpdf->Output('BarCode.pdf', 'I'); 
        }
    }
    
    function deleteBarcode()
    {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        }else{
            $files = scandir('application/cache');
            foreach($files as $file) {
                if ($file !== "." && $file !== "..") {
                    unlink("application/cache/$file");
                }
            }
            redirect('viewBarCodeGenerater');
        }
    }

    function viewLibraryDashboard()
    {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        }else{
            $data['bookCount'] = $this->library->getTotalBooks();
            $data['borrowedCount'] = $this->library->getBowrrowedCount();
            $data['fineCount'] = $this->library->getTotalFine();
            $data['studentCount'] = $this->library->getTotalStudent();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Library Dashboard Details';
            $this->loadViews("libraryManagement/libraryDashboard", $this->global, $data, null);
        }
    }

    public function updateIssuedInfo(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else { 
            $this->load->library('form_validation');

            $this->form_validation->set_rules('actual_return_date','actual return date','trim|required');
            $this->form_validation->set_rules('fine_id','fine Id','required'); 
           
            $row_id = $this->input->post('row_id');
            $return_date = $this->input->post('return_date');
            $isbn = $this->input->post('isbn');
            if($this->form_validation->run() == FALSE){
                $this->editLibrary();
            } else {
                $filter = array();
                $actual_return_date =$this->security->xss_clean($this->input->post('actual_return_date'));
                $fine_id =$this->security->xss_clean($this->input->post('fine_id'));
                $remarks =$this->security->xss_clean($this->input->post('remarks'));
                $fine_amt = $this->library->getFineById($fine_id);
                $date1 = date("Y-m-d",strtotime($return_date));           
                $date2 = date("Y-m-d",strtotime($actual_return_date));
                $diff = abs(strtotime($date2) - strtotime($date1));
                $years = floor($diff / (365*60*60*24));
                $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                if($days > 0 &&  $date2 > $date1){
                    $days_delayed = $days;
                    $fine = $days_delayed * $fine_amt->fine_amount;
                }else{
                    $days_delayed = 0;
                    $fine = 0;
                }
                $IssueInfo= array(
                    'actual_return_date	'=>$date2,
                    'days_delayed'=>$days_delayed,
                    'fine'=>$fine,
                    'fine_id'=>$fine_id,
                    'remarks'=>$remarks,
                    'is_issued'=>0,
                    'updated_by' => $this->staff_id,
                    'updated_date_time' => date('Y-m-d h:i:s'));

                $return_id = $this->library->updateBookIssuedInfo($row_id,$IssueInfo);
                
                $libraryInfo = array(
                    'is_available'=>1,
                    'updated_by' => $this->staff_id,
                    'updated_date_time' => date('Y-m-d h:i:s'));

                if($return_id == true){
                    $this->library->updateIsAvailable($libraryInfo,$isbn);
                    $this->session->set_flashdata('success', 'Book Issued info Updated Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Failed to update ');
                }
                redirect('editIssuedInfo/'.$row_id);
            }
            
        }
    }

    public function editIssuedInfo($row_id = null)
    {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            if ($row_id == null) {
                redirect('viewIssuedBooks');
            }
            $data['fineInfo'] = $this->library->getFineInfo();
            $data['libraryInfo'] = $this->library->getIssuedInfoById($row_id);
            $data['fine_amt'] = $this->library->getFineById($data['libraryInfo']->fine_id);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit Issued Details';
            $this->loadViews("libraryManagement/editIssuedInfo", $this->global, $data, null);
        }
    }

    function viewIssuedBooks()
    {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $filter = array();
            $isbn = $this->security->xss_clean($this->input->post('isbn'));
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $student_name = $this->security->xss_clean($this->input->post('student_name'));
            $issue_date = $this->security->xss_clean($this->input->post('issue_date'));
            $return_date = $this->security->xss_clean($this->input->post('return_date'));
            $actual_return_date = $this->security->xss_clean($this->input->post('actual_return_date'));
            $days_delayed = $this->security->xss_clean($this->input->post('days_delayed'));
            $fine = $this->security->xss_clean($this->input->post('fine'));
            $remarks = $this->security->xss_clean($this->input->post('remarks'));
            $access_code = $this->security->xss_clean($this->input->post('access_code'));
            $user_type = $this->security->xss_clean($this->input->post('user_type'));
            $book_title = $this->security->xss_clean($this->input->post('book_title'));
            $renewal_date = $this->security->xss_clean($this->input->post('renewal_date'));
           
            if(!empty($issue_date)){
                $filter['issue_date'] = date('Y-m-d',strtotime($issue_date));
                $data['issue_date'] = date('d-m-Y',strtotime($issue_date));
            }else{
                $data['issue_date'] = '';
            }

            if(!empty($return_date)){
                $filter['return_date'] = date('Y-m-d',strtotime($return_date));
                $data['return_date'] = date('d-m-Y',strtotime($return_date));
            }else{
                $data['return_date'] = '';
            }

            if(!empty($renewal_date)){
                $filter['renewal_date'] = date('Y-m-d',strtotime($renewal_date));
                $data['renewal_date'] = date('d-m-Y',strtotime($renewal_date));
            }else{
                $data['renewal_date'] = '';
            }


            if(!empty($actual_return_date)){
                $filter['actual_return_date'] = date('Y-m-d',strtotime($actual_return_date));
                $data['actual_return_date'] = date('d-m-Y',strtotime($actual_return_date));
            }else{
                $data['actual_return_date'] = '';
            }
            if(empty($user_type)){
                $userType = 'student';
            }else{
                $userType = $user_type;
            }

            $filter['user_type'] = $userType;
            $data['user_type'] = $userType;
            $data['isbn'] = $isbn;
            $data['student_id'] = $student_id;
            $data['student_name'] = $student_name;
            $data['fine'] = $fine;
            $data['days_delayed'] = $days_delayed;
            $data['remarks'] = $remarks;
            $data['access_code'] = $access_code;
            $data['book_title'] = $book_title;
           
            
            $filter['isbn'] = $isbn;
            $filter['student_id'] = $student_id;
            $filter['student_name'] = $student_name;
            $filter['fine'] = $fine;
            $filter['days_delayed'] = $days_delayed;
            $filter['remarks'] = $remarks;
            $filter['access_code'] = $access_code;
            $filter['book_title'] = $book_title;
          
            
            $this->load->library('pagination');
            $count = $this->library->getAllIssuedBookCount($filter);
            $returns = $this->paginationCompress("viewIssuedBooks/", $count, 100);
            $data['totalLibraryIssuedCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['libraryIssuedInfo'] = $this->library->getAllIssuedBookInfo($filter, $returns["page"], $returns["segment"]);
            $data['info'] = $this->library;
            $data['accessInfo'] = $this->getCurrentAccess();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Issued book Details';
            $this->loadViews("libraryManagement/issuedBookInfo", $this->global, $data, NULL);

        }
    }

    public function addLibraryIssueInfo(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
          
            //$this->form_validation->set_rules('student_id','student id','required'); 
            $this->form_validation->set_rules('issue_date','issue date','required');
            $this->form_validation->set_rules('return_date', 'return date', 'trim|required');
           // $this->form_validation->set_rules('remarks', 'remarks', 'trim|required');
            $this->form_validation->set_rules('access_code', 'Access code', 'trim|required');
            if($this->form_validation->run() == FALSE) {
                $this->libraryManagementSystem();
            } else {
                $isbn =$this->security->xss_clean($this->input->post('isbn'));
                $student_id =$this->security->xss_clean($this->input->post('student_id'));
                $issue_date = $this->security->xss_clean($this->input->post('issue_date'));
                $return_date = $this->security->xss_clean($this->input->post('return_date'));
                $remarks = $this->security->xss_clean($this->input->post('remarks'));
                $access_code = $this->security->xss_clean($this->input->post('access_code'));
                $renewal_date = $this->security->xss_clean($this->input->post('renewal_date'));
                $staff_id =$this->security->xss_clean($this->input->post('staff_id'));
                $user_type = $this->security->xss_clean($this->input->post('users_type'));
                
                if($user_type == 'student'){  
                $issedInfo = array(
                    'access_code'=>$access_code,
                    'isbn'=>$isbn,
                    'student_id'=>$student_id,
                    'issue_date'=>date('Y-m-d',strtotime($issue_date)),
                    'return_date'=>date('Y-m-d',strtotime($return_date)),
                    'renewal_date'=>date('Y-m-d',strtotime($renewal_date)),
                    'remarks'=>$remarks,
                    'is_issued'=> 1,
                    'user_type'=> 'student',
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));
                }else {
                    $issedInfo = array(
                        'access_code'=>$access_code,
                        'isbn'=>$isbn,
                        'student_id'=>$staff_id,
                        'issue_date'=>date('Y-m-d',strtotime($issue_date)),
                        'return_date'=>date('Y-m-d',strtotime($return_date)),
                        'renewal_date'=>date('Y-m-d',strtotime($renewal_date)),
                        'remarks'=>$remarks,
                        'is_issued'=> 1,
                        'user_type'=>'staff',  
                        'created_by'=>$this->staff_id,
                        'created_date_time'=>date('Y-m-d H:i:s'));
                    }
               
                $libraryInfo = array(
                    'is_available'=>0,
                    'updated_by' => $this->staff_id,
                    'updated_date_time' => date('Y-m-d h:i:s'));
                $returnId = $this->library->addLibraryMgmtIssueInfo($issedInfo);
                //log_message('debug',print_r($issedInfo,true));
         
                if($returnId > 0 ){
                    $this->library->updateIsAvailable($libraryInfo,$access_code);
                    $this->session->set_flashdata('success', 'Library Issue Info Added Successfully');
                } else {
                    $this->session->set_flashdata('error', 'Library issued info Adding failed');
                } 
                redirect('libraryManagementSystem');  
          }
        }
    }

    public function getIsbnData(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{          
            $isbn = $this->security->xss_clean($this->input->post('isbn'));
            $info = $this->library->getIsbnData($isbn);
            echo json_encode($info);
            exit(0);
        }
    }

    public function viewLibrarySettings() {
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {
            
            $data['categoryInfo'] = $this->library->getCategoryInfo();
            $data['authorInfo'] = $this->library->getAuthorInfo();
            $data['publisherInfo'] = $this->library->getPublisherInfo();
            $data['shelfInfo'] = $this->library->getShelfInfo();
            $data['fineInfo'] = $this->library->getFineInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Settings';
            $this->loadViews("libraryManagement/librarySettings", $this->global, $data, null);  
        }
    }

    public function addBookFine() {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }  else {
            $fine_name =$this->security->xss_clean($this->input->post('fine_name'));
            $fine_amount =$this->security->xss_clean($this->input->post('fine_amount'));
            $fineInfo = array('fine_name'=>$fine_name,'fine_amount'=>$fine_amount,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));
            $result = $this->library->addFineInfo($fineInfo);
            if($result > 0){
                $this->session->set_flashdata('success', 'New fine info created successfully');
            } else{
                $this->session->set_flashdata('error', 'Fine info creation failed');
            }
            redirect('viewLibrarySettings');
        }
    }

    public function deleteBookFine(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $fineInfo = array('is_deleted' => 1,'updated_by' => $this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->library->updateFineInfo($fineInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function addBookShelf() {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }  else {
            $shelf_no =$this->security->xss_clean($this->input->post('shelf_no'));
            $shelfInfo = array('shelf_no'=>$shelf_no,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));
            $result = $this->library->addShelfNo($shelfInfo);
            if($result > 0){
                $this->session->set_flashdata('success', 'New Book author created successfully');
            } else{
                $this->session->set_flashdata('error', 'Author creation failed');
            }
            redirect('viewLibrarySettings');
        }
    }

    public function deleteBookShelf(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $shelfInfo = array('is_deleted' => 1,'updated_by' => $this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->library->updateShelfNo($shelfInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function addBookCategory() {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }  else {
            $category =$this->security->xss_clean($this->input->post('category'));
            $categoryInfo = array('category_name'=>$category,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));
            $result = $this->library->addBookCategory($categoryInfo);
            if($result > 0){
                $this->session->set_flashdata('success', 'New Book Category created successfully');
            } else{
                $this->session->set_flashdata('error', 'Category creation failed');
            }
            redirect('viewLibrarySettings');
        }
    }

    public function deleteBookCategory(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $categoryInfo = array('is_deleted' => 1,'updated_by' => $this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->library->updateCategoryInfo($categoryInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function addBookAuthor() {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }  else {
            $author =$this->security->xss_clean($this->input->post('author'));
            $authorInfo = array('author_name'=>$author,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));
            $result = $this->library->addBookAuthor($authorInfo);
            if($result > 0){
                $this->session->set_flashdata('success', 'New Book author created successfully');
            } else{
                $this->session->set_flashdata('error', 'Author creation failed');
            }
            redirect('viewLibrarySettings');
        }
    }

    public function deleteBookAuthor(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $authorInfo = array('is_deleted' => 1,'updated_by' => $this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->library->updateAuthorInfo($authorInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function addBookPublisher() {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }  else {
            $publisher_name =$this->security->xss_clean($this->input->post('publisher'));
            $publisherInfo = array('publisher_name'=>$publisher_name,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));
            $result = $this->library->addBookPublisher($publisherInfo);
            if($result > 0){
                $this->session->set_flashdata('success', 'New Book author created successfully');
            } else{
                $this->session->set_flashdata('error', 'Author creation failed');
            }
            redirect('viewLibrarySettings');
        }
    }

    public function deleteBookPublisher(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $publisherInfo = array('is_deleted' => 1,'updated_by' => $this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->library->updatePublisherInfo($publisherInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function updateRenewalDate(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $return_date = $this->security->xss_clean($this->input->post('return_date'));
            $renewal_date = $this->security->xss_clean($this->input->post('renewal_date'));
                
                $overallFee = array(
                    'return_date' => date('Y-m-d',strtotime($return_date)),
                    'renewal_date' => date('Y-m-d',strtotime($renewal_date))
                );

            $result = $this->library->updateBookIssuedInfo($row_id,$overallFee);
            if ($result) {
                $this->session->set_flashdata('success', 'Book Issued info Updated Successfully');
            } else {
                $this->session->set_flashdata('error', 'update failed');
            }
        }
    
        redirect('viewIssuedBooks');
    }


    public function generateBarcodeForBook($row_id = null){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            if($row_id == null){
                $row_id = $this->security->xss_clean($this->input->get('row_id'));
                $row_id = base64_decode(urldecode($row_id));
                $row_id = json_decode(stripslashes($row_id));
            }
          
            foreach($row_id as $id){
                
                $roll_number[$id] = $this->library->getBookAccessNo($id);
                // log_message('debug','data'.print_r($roll_number[$id],true));
                // log_message('debug','data'.$roll_number[$id]->student_id);
                $generate_barcode[$id] = $this->set_barcode($roll_number[$id]->access_code);
            }
            $data['generate_barcode'] = $generate_barcode;
           
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman','format' => 'A4-L']);
            $mpdf->AddPage('P','','','','',7,7,7,7,8,8);
            $mpdf->SetTitle('Bar Code');
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Barcode';

            $html = $this->load->view('libraryManagement/viewBarCodePrintForBook',$data,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('BarCode.pdf', 'I'); 

        }
    }


}