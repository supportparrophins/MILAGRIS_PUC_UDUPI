<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Stock extends BaseController
{
 public function __construct()
    {
        parent::__construct();
        $this->load->model('stock_model','stock');
        // $this->load->model('wallet_model','wallet');
        $this->isLoggedIn();   
    }

    // stock settings
    public function viewStockSettings(){

      	 $data['stockNameInfo'] = $this->stock->getStockNameInfo();
      	 $data['stockTypeInfo'] = $this->stock->getStockTypeInfo();
      	 $data['stockDepartmentInfo'] = $this->stock->getStockDepartmentInfo();
         $data['stockProductInfo'] = $this->stock->getStockProductInfo();
         $data['stockScaleInfo'] = $this->stock->getStockScaleInfo();
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Stock Settings' ;
        $this->loadViews("stock/stockSettings", $this->global, $data, null);
    }

    //add stock name information

    function addStockName()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }  else {
                $stock_name =$this->security->xss_clean($this->input->post('stock_name'));
                $type_id =$this->security->xss_clean($this->input->post('type_id'));
                $scale_id =$this->security->xss_clean($this->input->post('scale_id'));
                $item_code =$this->security->xss_clean($this->input->post('item_code'));
                $product_id =$this->security->xss_clean($this->input->post('product_id'));
                 $isExist = $this->stock->checkItemCodeExists($item_code);
                 if(!empty($isExist)){
                    $this->session->set_flashdata('warning', 'Item Code Already Exists');
                    redirect('viewStockSettings');
                    }else{
                        $stockInfo = array(
                        'stock_name'=>$stock_name,
                        'type_id'=>$type_id,
                        'scale_id'=>$scale_id,
                        'product_id'=>$product_id,
                        'item_code'=>$item_code,
                        'created_by'=>$this->staff_id,
                        'created_date_time'=>date('Y-m-d H:i:s'));
                        $result = $this->stock->addStockName($stockInfo);
                    if($result > 0){
                        $this->session->set_flashdata('success', 'New Stock Name created successfully');
                    } else{
                        $this->session->set_flashdata('error', 'Stock Name creation failed');
                    }
                }
                redirect('viewStockSettings');
            }
        
    }
    public function deleteStockName(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $stock_id = $this->input->post('stock_id');
            $stockInfo = array(
            'is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->stock->deleteStockName($stockInfo, $stock_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    //add stock type information

    function addStockType()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }  else {
                $stock_type =$this->security->xss_clean($this->input->post('stock_type'));
                    $stockInfo = array(
                    'stock_type'=>$stock_type,
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->stock->addStockType($stockInfo);
                if($result > 0){
                    $this->session->set_flashdata('success', 'New Stock Type created successfully');
                } else{
                    $this->session->set_flashdata('error', 'Stock Type creation failed');
                }
                redirect('viewStockSettings');
            }
        
    }
    public function deleteStockType(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $stockInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->stock->deleteStockType($stockInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    //add stock department information

    function addStockDepartment()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }  else {
                $stock_department =$this->security->xss_clean($this->input->post('stock_department'));
                    $stockInfo = array(
                    'stock_department'=>$stock_department,
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->stock->addStockDepartment($stockInfo);
                if($result > 0){
                    $this->session->set_flashdata('success', 'New Stock Department created successfully');
                } else{
                    $this->session->set_flashdata('error', 'Stock Department creation failed');
                }
                redirect('viewStockSettings');
            }
        
    }
    public function deleteStockDepartment(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $stockInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->stock->deleteStockDepartment($stockInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

      //add product information

    function addStockProduct()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }  else {
                $product_name =$this->security->xss_clean($this->input->post('product_name'));
                    $stockInfo = array(
                    'product_name'=>$product_name,
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->stock->addStockProduct($stockInfo);
                if($result > 0){
                    $this->session->set_flashdata('success', 'New Product  created successfully');
                } else{
                    $this->session->set_flashdata('error', 'Stock Product creation failed');
                }
                redirect('viewStockSettings');
            }
        
    }
    public function deleteStockProduct(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $stockInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->stock->deleteStockProduct($stockInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

  
    // Stock In View
    // stock settings
    public function viewStockInListing(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $filter = array();
            $quantity_sum = array();
            $in_date = $this->security->xss_clean($this->input->post('in_date'));
            $expiry_date = $this->security->xss_clean($this->input->post('expiry_date'));
            $stock_name = $this->security->xss_clean($this->input->post('stock_name'));
            $stock_type = $this->security->xss_clean($this->input->post('stock_type'));
            $item_code = $this->security->xss_clean($this->input->post('item_code'));
            $sale_rate = $this->security->xss_clean($this->input->post('sale_rate'));
            $stock_scale = $this->security->xss_clean($this->input->post('stock_scale'));
            $quantity = $this->security->xss_clean($this->input->post('quantity'));
            $rate = $this->security->xss_clean($this->input->post('rate'));
            $size = $this->security->xss_clean($this->input->post('size'));
            $product_name = $this->security->xss_clean($this->input->post('product_name'));

            $data['stock_name'] = $stock_name;
            $data['product_name'] = $product_name;
            $data['stock_type'] = $stock_type;
            $data['stock_scale'] = $stock_scale;
            $data['item_code'] = $item_code;
            $data['sale_rate'] = $sale_rate;
            $data['quantity'] = $quantity;
            $data['rate'] = $rate;

            $filter['stock_name'] = $stock_name;
            $filter['product_name'] = $product_name;
            $filter['stock_type'] = $stock_type;
            $filter['stock_scale'] = $stock_scale;
            $filter['item_code'] = $item_code;
            $filter['sale_rate'] = $sale_rate;
            $filter['quantity'] = $quantity;
            $filter['rate'] = $rate;

            if(!empty($in_date)){
                $filter['in_date'] = date('Y-m-d',strtotime($in_date));
                $data['in_date'] = date('d-m-Y',strtotime($in_date));
            }else{
                $data['in_date'] = '';
            }

            if(!empty($expiry_date)){
                $filter['expiry_date'] = date('Y-m-d',strtotime($expiry_date));
                $data['expiry_date'] = date('d-m-Y',strtotime($expiry_date));
            }else{
                $data['expiry_date'] = '';
            }
            $this->load->library('pagination');
            $count = $this->stock->getAllStockCount($filter);
            $returns = $this->paginationCompress("viewStockInListing/", $count, 100);
            $data['totalStockCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $stockInInfo = $this->stock->getAllStockInInfo($filter, $returns["page"], $returns["segment"]);
            $data['stockNameInfo'] = $this->stock->getStockNameInfo();
            $data['stockTypeInfo'] = $this->stock->getStockTypeInfo();
            $data['stockDepartmentInfo'] = $this->stock->getStockDepartmentInfo();
             $data['stockProductInfo'] = $this->stock->getStockProductInfo();
            $data['stockScaleInfo'] = $this->stock->getStockScaleInfo();
            foreach ($stockInInfo as $stock) {
                    $stockValue =$this->stock->getSumOfStockOut($stock->row_id);
                    $remaining_stock = $stock->quantity - $stockValue->rem_quantity;
                    $quantity_sum[$stock->row_id] = $remaining_stock;
                }

            $data['stockInInfo'] = $stockInInfo;
            $data['sumOfQuantity'] = $quantity_sum;
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Stock In Listing' ;
            $this->loadViews("stock/stockIn", $this->global, $data, null);
        }
    }

    public function addStockIn() {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
        	$this->load->library('form_validation');
        	$this->form_validation->set_rules('in_date','In Date','trim|required');
            // $this->form_validation->set_rules('expiry_date','Expiry Date','trim|required');
             $this->form_validation->set_rules('stock_name_id','Stock Name','trim|required');
            // $this->form_validation->set_rules('stock_type_id','Stock Type','trim|required');
            $this->form_validation->set_rules('quantity','Quantity','trim|required');
            $this->form_validation->set_rules('price','Purchase Price','trim|required');
            // $this->form_validation->set_rules('sale_rate','Sale Price','trim|required');
            if ($this->form_validation->run() == false) {
                $this->viewStockInListing();
            } else {
        		$in_date = $this->security->xss_clean($this->input->post('in_date'));
        		$expiry_date = $this->security->xss_clean($this->input->post('expiry_date'));
                $stock_name_id = $this->security->xss_clean($this->input->post('stock_name_id'));
                // $stock_type_id = $this->security->xss_clean($this->input->post('stock_type_id'));  
                $quantity = $this->security->xss_clean($this->input->post('quantity'));
                $price = $this->security->xss_clean($this->input->post('price'));
                $sale_rate = $this->security->xss_clean($this->input->post('sale_rate'));
                $comments = $this->security->xss_clean($this->input->post('comments'));
                
                    $stockInInfo = array(
	                  'stock_name_id'=>$stock_name_id,
	                  // 'stock_type_id'=>$stock_type_id,
	                  'in_date'=>date('Y-m-d',strtotime($in_date)),
	                  'expiry_date'=>date('Y-m-d',strtotime($expiry_date)),
	                  'quantity'=>$quantity,
	                  'rate'=>$price,
                      'sale_rate'=>$sale_rate,
	                  'comments'=>$comments, 
	                  'created_by' => $this->staff_id, 
	                  'created_date_time' => date('Y-m-d H:i:s'));
                    $result = $this->stock->addNewStockIn($stockInInfo);
                    if ($result > 0) {
                        $this->session->set_flashdata('success', 'Stock In Info Added successfully');
                    } else {
                        $this->session->set_flashdata('error', 'Stock In Info Add failed');
                    }
                 
                 
                redirect('viewStockInListing');
            }
        }
    }

      function editStockInView($row_id = NULL)
    {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            if($row_id == null){
                redirect('viewStockInListing');
            }
            $data['stockNameInfo'] = $this->stock->getStockNameInfo();
      	    $data['stockTypeInfo'] = $this->stock->getStockTypeInfo();
      	    $data['stockDepartmentInfo'] = $this->stock->getStockDepartmentInfo();
      	    $data['stockInInfo'] = $this->stock->getStockInInfoById($row_id);
             $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit Stock In' ;
            $this->loadViews("stock/editStockIn", $this->global, $data, NULL);
        }
    }

     public function updateStockIn(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
             $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
           $this->form_validation->set_rules('in_date','In Date','trim|required');
            // $this->form_validation->set_rules('expiry_date','Expiry Date','trim|required');
             $this->form_validation->set_rules('stock_name_id','Stock Name','trim|required');
            // $this->form_validation->set_rules('stock_type_id','Stock Type','trim|required');
            $this->form_validation->set_rules('quantity','Quantity','trim|required');
            $this->form_validation->set_rules('price','Purchase Price','trim|required');
            //   $this->form_validation->set_rules('sale_rate','Sale Price','trim|required');
            if($this->form_validation->run() == FALSE) {
                $this->editStockInView();
            } else {

             $in_date = $this->security->xss_clean($this->input->post('in_date'));
        	 $expiry_date = $this->security->xss_clean($this->input->post('expiry_date'));
             $stock_name_id = $this->security->xss_clean($this->input->post('stock_name_id'));
             // $stock_type_id = $this->security->xss_clean($this->input->post('stock_type_id'));  
             $quantity = $this->security->xss_clean($this->input->post('quantity'));
             $price = $this->security->xss_clean($this->input->post('price'));
             $sale_rate = $this->security->xss_clean($this->input->post('sale_rate'));
             $comments = $this->security->xss_clean($this->input->post('comments'));

                    $stockInInfo = array(
                    'stock_name_id'=>$stock_name_id,
	                // 'stock_type_id'=>$stock_type_id,
	                'in_date'=>date('Y-m-d',strtotime($in_date)),
	                'expiry_date'=>date('Y-m-d',strtotime($expiry_date)),
	                'quantity'=>$quantity,
	                'rate'=>$price,
                    'sale_rate'=>$sale_rate,
	                'comments'=>$comments,
                    'updated_by' => $this->staff_id,
                    'updated_date_time' =>date('Y-m-d H:i:s'));

                $return_id = $this->stock->updateStockIn($stockInInfo,$row_id);
                if($return_id){
                    $this->session->set_flashdata('success', 'Stock In Info Updated Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Stock In Info Update failed');
                }
                redirect('editStockInView/'.$row_id);
            }
        }
    }

    public function deleteStockIn(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $stockInInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->stock->updateStockIn($stockInInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function addStockOut() {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
        	$this->load->library('form_validation');
        	$row_id = $this->input->post('row_id');
            $this->form_validation->set_rules('out_date','Out Date','trim|required');
            $this->form_validation->set_rules('new_quantity','Quantity','trim|required');
            if ($this->form_validation->run() == false) {
                $this->viewStockInListing();
            } else {
        		$out_date = $this->security->xss_clean($this->input->post('out_date'));
                $new_quantity = $this->security->xss_clean($this->input->post('new_quantity'));
                $sales_price = $this->security->xss_clean($this->input->post('sales_price'));
                $comments = $this->security->xss_clean($this->input->post('comments'));
                
                    $stockOutInfo = array(
                      'relation_row_id' => $row_id,
	                  'out_date'=>date('Y-m-d',strtotime($out_date)),
	                  'quantity'=>$new_quantity,
	                  'sales_price'=>$sales_price,
	                  'comments'=>$comments, 
	                  'created_by' => $this->staff_id, 
	                  'created_date_time' => date('Y-m-d H:i:s'));
                    $result = $this->stock->addStockOut($stockOutInfo);
                    if ($result > 0) {
                        $this->session->set_flashdata('success', 'Stock Out Info Added successfully');
                    } else {
                        $this->session->set_flashdata('error', 'Stock Out Info Add failed');
                    }
                 
                 
                redirect('viewStockInListing');
            }
        }
    }

    // Stock Out View
    public function viewStockOutListing(){
        $filter = array();
        $quantity_sum = array();
        $out_date = $this->security->xss_clean($this->input->post('out_date'));
        $expiry_date = $this->security->xss_clean($this->input->post('expiry_date'));
        $stock_name = $this->security->xss_clean($this->input->post('stock_name'));
        $stock_type = $this->security->xss_clean($this->input->post('stock_type'));
         $item_code = $this->security->xss_clean($this->input->post('item_code'));
        $sale_rate = $this->security->xss_clean($this->input->post('sale_rate'));
         $stock_scale = $this->security->xss_clean($this->input->post('stock_scale'));
        $quantity = $this->security->xss_clean($this->input->post('quantity'));
        $sales_price = $this->security->xss_clean($this->input->post('sales_price'));

        $data['stock_name'] = $stock_name;
        $data['stock_type'] = $stock_type;
        $data['item_code'] = $item_code;
        $data['sale_rate'] = $sale_rate;
        $data['stock_scale'] = $stock_scale;
        $data['quantity'] = $quantity;
        $data['sales_price'] = $sales_price;

        $filter['stock_name'] = $stock_name;
        $filter['stock_type'] = $stock_type;
        $filter['item_code'] = $item_code;
        $filter['sale_rate'] = $sale_rate;
        $filter['stock_scale'] = $stock_scale;
        $filter['quantity'] = $quantity;
        $filter['sales_price'] = $sales_price;

        if(!empty($out_date)){
              $filter['out_date'] = date('Y-m-d',strtotime($out_date));
              $data['out_date'] = date('d-m-Y',strtotime($out_date));
          }else{
              $data['out_date'] = '';
          }

          if(!empty($expiry_date)){
              $filter['expiry_date'] = date('Y-m-d',strtotime($expiry_date));
              $data['expiry_date'] = date('d-m-Y',strtotime($expiry_date));
          }else{
              $data['expiry_date'] = '';
          }
        $this->load->library('pagination');
        $count = $this->stock->getAllStockOutCount($filter);
        $returns = $this->paginationCompress("viewStockOutListing/", $count, 100);
        $data['totalStockCount'] = $count;
        $filter['page'] = $returns["page"];
        $filter['segment'] = $returns["segment"];
        $data['stockOutInfo'] = $this->stock->getAllStockOutInfo($filter, $returns["page"], $returns["segment"]);
        $data['stockNameInfo'] = $this->stock->getStockNameInfo();
      	$data['stockTypeInfo'] = $this->stock->getStockTypeInfo();
      	$data['stockDepartmentInfo'] = $this->stock->getStockDepartmentInfo();
        $data['stockScaleInfo'] = $this->stock->getStockScaleInfo();
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Stock Out Listing' ;
        $this->loadViews("stock/stockOut", $this->global, $data, null);
    }


     function editStockOutView($row_id = NULL)
    {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            if($row_id == null){
                redirect('viewStockOutListing');
            }
            $data['stockNameInfo'] = $this->stock->getStockNameInfo();
      	    $data['stockTypeInfo'] = $this->stock->getStockTypeInfo();
      	    $data['stockDepartmentInfo'] = $this->stock->getStockDepartmentInfo();

      	    $data['stockOutInfo'] = $this->stock->getStockOutInfoById($row_id);
      	     $stockin_id = $data['stockOutInfo']->relation_row_id;
      	     $data['stockInInfo'] = $this->stock->getStockInInfoById($stockin_id);
            $stockin_quantity = $data['stockInInfo']->quantity;
            $stockout_quantity = $this->stock->getSumOfStockOut($stockin_id);
            $data['remainingQuantity'] = $stockin_quantity - $stockout_quantity->rem_quantity;
             $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit Stock Out' ;
            $this->loadViews("stock/editStockOut", $this->global, $data, NULL);
        }
    }

     public function updateStockOut(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
             $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
           $this->form_validation->set_rules('out_date','Out Date','trim|required');
            $this->form_validation->set_rules('quantity','Quantity','trim|required');
            if($this->form_validation->run() == FALSE) {
                $this->editStockOutView();
            } else {

            $out_date = $this->security->xss_clean($this->input->post('out_date'));
            $quantity = $this->security->xss_clean($this->input->post('quantity'));
            $sales_price = $this->security->xss_clean($this->input->post('sales_price'));
            $comments = $this->security->xss_clean($this->input->post('comments'));

                    $stockOutInfo = array(
                    'out_date'=>date('Y-m-d',strtotime($out_date)),
	                'quantity'=>$quantity,
	                'sales_price'=>$sales_price,
	                'comments'=>$comments,
                    'updated_by' => $this->staff_id,
                    'updated_date_time' =>date('Y-m-d H:i:s'));

                $return_id = $this->stock->updateStockOut($stockOutInfo,$row_id);
                if($return_id){
                    $this->session->set_flashdata('success', 'Stock Out Info Updated Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Stock Out Info Update failed');
                }
                redirect('editStockOutView/'.$row_id);
            }
        }
    }
  public function deleteStockOut(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $stockOutInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->stock->updateStockOut($stockOutInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

     // stock canteen settings
    public function viewCanteenStockSettings(){

      	 $data['stockNameInfo'] = $this->stock->getStockCanteenInfo();
      	 $data['stockTypeInfo'] = $this->stock->getStockCanteenType();
      	 $data['stockDepartmentInfo'] = $this->stock->getStockCanteenDepartment();
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Stock Canteen Settings' ;
        $this->loadViews("stock/stockCanteenSettings", $this->global, $data, null);
    }

    //add stock canteen name information
    function addStockCanteenInfo()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }  else {
                $stock_name =$this->security->xss_clean($this->input->post('stock_name'));
                $type_id =$this->security->xss_clean($this->input->post('type_id'));
                $item_code =$this->security->xss_clean($this->input->post('item_code'));
                $isExist = $this->stock->checkCanteenItemCodeExists($item_code);
                 if(!empty($isExist)){
                    $this->session->set_flashdata('warning', 'Item Code Already Exists');
                    redirect('viewCanteenStockSettings');
                    }else{
                    $stockInfo = array(
                    'stock_name'=>$stock_name,
                    'type_id'=>$type_id,
                    'item_code'=>$item_code,
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->stock->addStockCanteenName($stockInfo);
                    if($result > 0){
                        $this->session->set_flashdata('success', 'New Stock Info created successfully');
                    } else{
                        $this->session->set_flashdata('error', 'Stock creation failed');
                    }
                }
                redirect('viewCanteenStockSettings');
            }
        
    }
    public function deleteStockCanteenInfo(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $stockInfo = array(
            'is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->stock->deleteStockCanteenInfo($stockInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    function addStockCanteenTypeInfo()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }  else {
                $stock_type =$this->security->xss_clean($this->input->post('stock_type'));
                 $scale =$this->security->xss_clean($this->input->post('scale'));
                    $stockInfo = array(
                    'stock_type'=>$stock_type,
                    'scale'=>$scale,
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->stock->addStockCanteenType($stockInfo);
                if($result > 0){
                    $this->session->set_flashdata('success', 'New Stock Type Info created successfully');
                } else{
                    $this->session->set_flashdata('error', 'Stock Type creation failed');
                }
                redirect('viewCanteenStockSettings');
            }
        
    }
    public function deleteStockCanteenType(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $stockInfo = array(
            'is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->stock->deleteStockCanteenType($stockInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    //add stock canteen department
    function addStockCanteenDepartment()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }  else {
                $stock_department =$this->security->xss_clean($this->input->post('stock_department'));
                    $stockInfo = array('stock_department'=>$stock_department,
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->stock->addStockCanteenDepartment($stockInfo);
                if($result > 0){
                    $this->session->set_flashdata('success', 'New Stock Department Info created successfully');
                } else{
                    $this->session->set_flashdata('error', 'Stock Department creation failed');
                }
                redirect('viewCanteenStockSettings');
            }
        
    }
    public function deleteStockCanteenDepartment(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $stockInfo = array(
            'is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->stock->deleteStockCanteenDepartment($stockInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    } 
   
   // canteen stock In
 
     public function viewCanteenStockIn(){
        $filter = array();
        $quantity_sum = array();
        $in_date = $this->security->xss_clean($this->input->post('in_date'));
        $expiry_date = $this->security->xss_clean($this->input->post('expiry_date'));
        $stock_name = $this->security->xss_clean($this->input->post('stock_name'));
        $item_code = $this->security->xss_clean($this->input->post('item_code'));
        $stock_type = $this->security->xss_clean($this->input->post('stock_type'));
        $stock_department = $this->security->xss_clean($this->input->post('stock_department'));
        $quantity = $this->security->xss_clean($this->input->post('quantity'));
        $rate = $this->security->xss_clean($this->input->post('rate'));
        $size = $this->security->xss_clean($this->input->post('size'));

        $data['item_code'] = $item_code;
        $data['stock_name'] = $stock_name;
        $data['stock_type'] = $stock_type;
        $data['stock_department'] = $stock_department;
        $data['quantity'] = $quantity;
        $data['rate'] = $rate;

        $filter['item_code'] = $item_code;
        $filter['stock_name'] = $stock_name;
        $filter['stock_type'] = $stock_type;
        $filter['stock_department'] = $stock_department;
        $filter['quantity'] = $quantity;
        $filter['rate'] = $rate;

        if(!empty($in_date)){
              $filter['in_date'] = date('Y-m-d',strtotime($in_date));
              $data['in_date'] = date('d-m-Y',strtotime($in_date));
          }else{
              $data['in_date'] = '';
          }

          if(!empty($expiry_date)){
              $filter['expiry_date'] = date('Y-m-d',strtotime($expiry_date));
              $data['expiry_date'] = date('d-m-Y',strtotime($expiry_date));
          }else{
              $data['expiry_date'] = '';
          }
        $this->load->library('pagination');
        $count = $this->stock->getAllCanteenStockCount($filter);
        $returns = $this->paginationCompress("viewCanteenStockIn/", $count, 100);
        $data['totalStockCount'] = $count;
        $filter['page'] = $returns["page"];
        $filter['segment'] = $returns["segment"];
        $stockInInfo = $this->stock->getAllCanteenStockInInfo($filter, $returns["page"], $returns["segment"]);
       $data['stockNameInfo'] = $this->stock->getStockCanteenInfo();
      	 $data['stockTypeInfo'] = $this->stock->getStockCanteenType();
      	 $data['stockDepartmentInfo'] = $this->stock->getStockCanteenDepartment();
      	foreach ($stockInInfo as $stock) {
                $stockValue =$this->stock->getSumOfCanteenStockOut($stock->row_id);
                $remaining_stock = $stock->quantity - $stockValue->rem_quantity;
                $quantity_sum[$stock->row_id] = $remaining_stock;
            }

        $data['stockInInfo'] = $stockInInfo;
        $data['sumOfQuantity'] = $quantity_sum;
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Canteen Stock In Listing' ;
        $this->loadViews("stock/canteenStockIn", $this->global, $data, null);
    }

    public function addCanteenStockIn() {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
        	$this->load->library('form_validation');
        	$this->form_validation->set_rules('in_date','In Date','trim|required');
            $this->form_validation->set_rules('expiry_date','Expiry Date','trim|required');
             $this->form_validation->set_rules('stock_name_id','Stock Name','trim|required');
            // $this->form_validation->set_rules('stock_type_id','Stock Type','trim|required');
            $this->form_validation->set_rules('stock_department_id','Stock Department','trim|required');
            $this->form_validation->set_rules('quantity','Quantity','trim|required');
            $this->form_validation->set_rules('price','Price','trim|required');
            if ($this->form_validation->run() == false) {
                $this->viewCanteenStockOut();
            } else {
        		$in_date = $this->security->xss_clean($this->input->post('in_date'));
        		$expiry_date = $this->security->xss_clean($this->input->post('expiry_date'));
                $stock_name_id = $this->security->xss_clean($this->input->post('stock_name_id'));
                // $stock_type_id = $this->security->xss_clean($this->input->post('stock_type_id'));  
                $stock_department_id = $this->security->xss_clean($this->input->post('stock_department_id'));
                $quantity = $this->security->xss_clean($this->input->post('quantity'));
                $price = $this->security->xss_clean($this->input->post('price'));
                $comments = $this->security->xss_clean($this->input->post('comments'));
                
                    $stockInInfo = array(
	                  'stock_name_id'=>$stock_name_id,
	                  // 'stock_type_id'=>$stock_type_id,
	                  'stock_department_id'=>$stock_department_id,
	                  'in_date'=>date('Y-m-d',strtotime($in_date)),
	                  'expiry_date'=>date('Y-m-d',strtotime($expiry_date)),
	                  'quantity'=>$quantity,
	                  'rate'=>$price,
	                  'comments'=>$comments, 
	                  'created_by' => $this->staff_id, 
	                  'created_date_time' => date('Y-m-d H:i:s'));
                    $result = $this->stock->addNewCanteenStockIn($stockInInfo);
                    if ($result > 0) {
                        $this->session->set_flashdata('success', 'Stock In Info Added successfully');
                    } else {
                        $this->session->set_flashdata('error', 'Stock In Info Add failed');
                    }
                 
                 
                redirect('viewCanteenStockIn');
            }
        }
    }

      function editCanteenStockIn($row_id = NULL)
    {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            if($row_id == null){
                redirect('viewCanteenStockIn');
            }
            $data['stockNameInfo'] = $this->stock->getStockCanteenInfo();
         	$data['stockTypeInfo'] = $this->stock->getStockCanteenType();
         	$data['stockDepartmentInfo'] = $this->stock->getStockCanteenDepartment();
      	    $data['stockInInfo'] = $this->stock->getCanteenStockInInfoById($row_id);
             $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit Stock In' ;
            $this->loadViews("stock/editCanteenStockIn", $this->global, $data, NULL);
        }
    }

     public function updateCanteenStockIn(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
             $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
           $this->form_validation->set_rules('in_date','In Date','trim|required');
            // $this->form_validation->set_rules('expiry_date','Expiry Date','trim|required');
             $this->form_validation->set_rules('stock_name_id','Stock Name','trim|required');
            // $this->form_validation->set_rules('stock_type_id','Stock Type','trim|required');
            $this->form_validation->set_rules('stock_department_id','Stock Department','trim|required');
            $this->form_validation->set_rules('quantity','Quantity','trim|required');
            $this->form_validation->set_rules('price','Price','trim|required');
            if($this->form_validation->run() == FALSE) {
                $this->editCanteenStockIn();
            } else {

             $in_date = $this->security->xss_clean($this->input->post('in_date'));
        	 $expiry_date = $this->security->xss_clean($this->input->post('expiry_date'));
             $stock_name_id = $this->security->xss_clean($this->input->post('stock_name_id'));
             // $stock_type_id = $this->security->xss_clean($this->input->post('stock_type_id'));  
             $stock_department_id = $this->security->xss_clean($this->input->post('stock_department_id'));
             $quantity = $this->security->xss_clean($this->input->post('quantity'));
             $price = $this->security->xss_clean($this->input->post('price'));
             $comments = $this->security->xss_clean($this->input->post('comments'));

                    $stockInInfo = array(
                    'stock_name_id'=>$stock_name_id,
	                // 'stock_type_id'=>$stock_type_id,
	                'stock_department_id'=>$stock_department_id,
	                'in_date'=>date('Y-m-d',strtotime($in_date)),
	                'expiry_date'=>date('Y-m-d',strtotime($expiry_date)),
	                'quantity'=>$quantity,
	                'rate'=>$price,
	                'comments'=>$comments,
                    'updated_by' => $this->staff_id,
                    'updated_date_time' =>date('Y-m-d H:i:s'));

                $return_id = $this->stock->updateCanteenStockIn($stockInInfo,$row_id);
                if($return_id){
                    $this->session->set_flashdata('success', 'Canteen Stock In Info Updated Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Canteen Stock In Info Update failed');
                }
                redirect('editCanteenStockIn/'.$row_id);
            }
        }
    }

    public function deleteCanteenStockIn(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $stockInInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->stock->updateCanteenStockIn($stockInInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    // canteen stock out

      public function addCanteenStockOut() {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
        	$this->load->library('form_validation');
        	$row_id = $this->input->post('row_id');
            $this->form_validation->set_rules('out_date','Out Date','trim|required');
            $this->form_validation->set_rules('new_quantity','Quantity','trim|required');
            if ($this->form_validation->run() == false) {
                $this->viewCanteenStockIn();
            } else {
        		$out_date = $this->security->xss_clean($this->input->post('out_date'));
                $new_quantity = $this->security->xss_clean($this->input->post('new_quantity'));
                $sales_price = $this->security->xss_clean($this->input->post('sales_price'));
                $comments = $this->security->xss_clean($this->input->post('comments'));
                
                    $stockOutInfo = array(
                      'relation_row_id' => $row_id,
	                  'out_date'=>date('Y-m-d',strtotime($out_date)),
	                  'quantity'=>$new_quantity,
	                  'sales_price'=>$sales_price,
	                  'comments'=>$comments, 
	                  'created_by' => $this->staff_id, 
	                  'created_date_time' => date('Y-m-d H:i:s'));
                    $result = $this->stock->addCanteenStockOut($stockOutInfo);
                    if ($result > 0) {
                        $this->session->set_flashdata('success', 'Stock Out Info Added successfully');
                    } else {
                        $this->session->set_flashdata('error', 'Stock Out Info Add failed');
                    }
                 
                 
                redirect('viewCanteenStockIn');
            }
        }
    }

    // Stock Out View
    public function viewCanteenStockOut(){
        $filter = array();
        $quantity_sum = array();
        $out_date = $this->security->xss_clean($this->input->post('out_date'));
        $expiry_date = $this->security->xss_clean($this->input->post('expiry_date'));
        $stock_name = $this->security->xss_clean($this->input->post('stock_name'));
        $item_code = $this->security->xss_clean($this->input->post('item_code'));
        $stock_type = $this->security->xss_clean($this->input->post('stock_type'));
        $stock_department = $this->security->xss_clean($this->input->post('stock_department'));
        $quantity = $this->security->xss_clean($this->input->post('quantity'));
        $sales_price = $this->security->xss_clean($this->input->post('sales_price'));

        $data['stock_name'] = $stock_name;
        $data['item_code'] = $item_code;
        $data['stock_type'] = $stock_type;
        $data['stock_department'] = $stock_department;
        $data['quantity'] = $quantity;
        $data['sales_price'] = $sales_price;

        $filter['stock_name'] = $stock_name;
        $filter['item_code'] = $item_code;
        $filter['stock_type'] = $stock_type;
        $filter['stock_department'] = $stock_department;
        $filter['quantity'] = $quantity;
        $filter['sales_price'] = $sales_price;

        if(!empty($out_date)){
              $filter['out_date'] = date('Y-m-d',strtotime($out_date));
              $data['out_date'] = date('d-m-Y',strtotime($out_date));
          }else{
              $data['out_date'] = '';
          }

          if(!empty($expiry_date)){
              $filter['expiry_date'] = date('Y-m-d',strtotime($expiry_date));
              $data['expiry_date'] = date('d-m-Y',strtotime($expiry_date));
          }else{
              $data['expiry_date'] = '';
          }
        $this->load->library('pagination');
        $count = $this->stock->getAllCanteenStockOutCount($filter);
        $returns = $this->paginationCompress("viewCanteenStockOut/", $count, 100);
        $data['totalStockCount'] = $count;
        $filter['page'] = $returns["page"];
        $filter['segment'] = $returns["segment"];
        $data['stockOutInfo'] = $this->stock->getAllCanteenStockOutInfo($filter, $returns["page"], $returns["segment"]);
        $data['stockNameInfo'] = $this->stock->getStockCanteenInfo();
      	$data['stockTypeInfo'] = $this->stock->getStockCanteenType();
      	$data['stockDepartmentInfo'] = $this->stock->getStockCanteenDepartment();
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Stock Out Listing' ;
        $this->loadViews("stock/canteenStockOut", $this->global, $data, null);
    }


     function editCanteenStockOut($row_id = NULL)
    {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            if($row_id == null){
                redirect('viewCanteenStockOut');
            }
	        $data['stockNameInfo'] = $this->stock->getStockCanteenInfo();
	      	$data['stockTypeInfo'] = $this->stock->getStockCanteenType();
	      	$data['stockDepartmentInfo'] = $this->stock->getStockCanteenDepartment();

      	    $data['stockOutInfo'] = $this->stock->getCanteenStockOutInfoById($row_id);
      	     $stockin_id = $data['stockOutInfo']->relation_row_id;
      	     $data['stockInInfo'] = $this->stock->getCanteenStockInInfoById($stockin_id);
            $stockin_quantity = $data['stockInInfo']->quantity;
            $stockout_quantity = $this->stock->getSumOfCanteenStockOut($stockin_id);
            $data['remainingQuantity'] = $stockin_quantity - $stockout_quantity->rem_quantity;
             $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit Stock Out' ;
            $this->loadViews("stock/editCanteenStockOut", $this->global, $data, NULL);
        }
    }

     public function updateCanteenStockOut(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
             $this->load->library('form_validation');
            $row_id = $this->input->post('row_id');
           $this->form_validation->set_rules('out_date','Out Date','trim|required');
            $this->form_validation->set_rules('quantity','Quantity','trim|required');
            if($this->form_validation->run() == FALSE) {
                $this->editCanteenStockOut();
            } else {

            $out_date = $this->security->xss_clean($this->input->post('out_date'));
            $quantity = $this->security->xss_clean($this->input->post('quantity'));
            $sales_price = $this->security->xss_clean($this->input->post('sales_price'));
            $comments = $this->security->xss_clean($this->input->post('comments'));

                    $stockOutInfo = array(
                    'out_date'=>date('Y-m-d',strtotime($out_date)),
	                'quantity'=>$quantity,
	                'sales_price'=>$sales_price,
	                'comments'=>$comments,
                    'updated_by' => $this->staff_id,
                    'updated_date_time' =>date('Y-m-d H:i:s'));

                $return_id = $this->stock->updateCanteenStockOut($stockOutInfo,$row_id);
                if($return_id){
                    $this->session->set_flashdata('success', 'Stock Out Info Updated Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Stock Out Info Update failed');
                }
                redirect('editCanteenStockOut/'.$row_id);
            }
        }
    }
  public function deleteCanteenStockOut(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $stockOutInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->stock->updateCanteenStockOut($stockOutInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }




    public function viewStockSales(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $filter = array();
            $quantity_sum = array();
            $date_filter = $this->security->xss_clean($this->input->post('date_filter'));
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $student_name = $this->security->xss_clean($this->input->post('student_name'));
            $total_amount = $this->security->xss_clean($this->input->post('total_amount'));
           

            $data['date_filter'] = $date_filter;
            $data['student_id'] = $student_id;
            $data['student_name'] = $student_name;
            $data['total_amount'] = $total_amount;
            

            $filter['date_filter'] = $date_filter;
            $filter['student_id'] = $student_id;
            $filter['student_name'] = $student_name;
            $filter['total_amount'] = $total_amount;
           

            if(!empty($date_filter)){
                $filter['date_filter'] = date('Y-m-d',strtotime($date_filter));
                $data['date_filter'] = date('d-m-Y',strtotime($date_filter));
            }else{
                $data['date_filter'] = '';
            }

            $this->load->library('pagination');
            $count = $this->stock->getAllSalesCount($filter);
            $returns = $this->paginationCompress("viewStockSales/", $count, 100);
            $data['totalSalesCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $salesInfo = $this->stock->getAllSalesInfo($filter, $returns["page"], $returns["segment"]);
            $data['stockNameInfo'] = $this->stock->getAllStockInInfoForSale();
            $data['stockTypeInfo'] = $this->stock->getStockTypeInfo();
            $data['stockDepartmentInfo'] = $this->stock->getStockDepartmentInfo();
             $data['stockProductInfo'] = $this->stock->getStockProductInfo();
            $data['stockScaleInfo'] = $this->stock->getStockScaleInfo();

            $data['studentInfo']  = $this->stock->getStudentId();
            $data['salesInfo'] = $salesInfo;
            $data['sumOfQuantity'] = $quantity_sum;
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Stock Usage Listing' ;
            $this->loadViews("stock/stockSale", $this->global, $data, null);
        }
    }



    public function addSalesToDB(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }  else {
             
                $in_date = $this->security->xss_clean($this->input->post('in_date'));
                $student_id = $this->security->xss_clean($this->input->post('student_id'));
                $comments = $this->security->xss_clean($this->input->post('comments'));
                $items = $this->security->xss_clean($this->input->post('items'));
                $qty = $this->security->xss_clean($this->input->post('qty'));

              

               
                $salesInfo = array(
                    'date'=>date('Y-m-d',strtotime($in_date)),
                    'student_id'=>$student_id,
                    'remarks' => $comments,
                    'created_by'=>$this->staff_id, 
                    'created_date_time'=>date('Y-m-d H:i:s'));

                   
                    $return_id = $this->stock->addSalesToDB($salesInfo);
                    
                if($return_id > 0){
                    for($i=0;$i<count($items);$i++){
                        $salesDetailInfo = array(
                            'sales_row_id' => $return_id,
                            'stock_in_row_id' => $items[$i],
                            'quantity' => $qty[$i],
                            'created_by'=>$this->staff_id, 
                            'created_date_time'=>date('Y-m-d H:i:s')
                        );
                        $this->stock->addSalesDetailToDB($salesDetailInfo);

                        $stockOutInfo = array(
                            'relation_row_id' =>  $items[$i],
                            'out_date'=>date('Y-m-d',strtotime($in_date)),
                            'quantity'=> $qty[$i],
                            'comments'=>$comments, 
                            'created_by' => $this->staff_id, 
                            'created_date_time' => date('Y-m-d H:i:s'));
                          $result = $this->stock->addStockOut($stockOutInfo);
                    }

                  

                } else{
                    $this->session->set_flashdata('error', 'Usage adding failed');
                }

                    
                if($result > 0){

                    $this->session->set_flashdata('success', 'Usage added successfully');
                } else{
                    $this->session->set_flashdata('error', 'Usage adding failed');
                }   
                redirect('viewStockSales');
            
        }
    }


    public function getItemAmountInfoByID(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $stock_in_id = $this->input->post("stock_id");
            $data['result'] = $this->stock->getStockPriceById($stock_in_id);
            header('Content-type: text/plain'); 
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        }
    }





}

?>