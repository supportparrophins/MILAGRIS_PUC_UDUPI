<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class Stock_model extends CI_Model
{
 
 // stock name
public function getStockNameInfo(){
        $this->db->from('tbl_stock_info as stock');
        $this->db->join('tbl_stock_type_info as type', 'type.row_id = stock.type_id','left');
        $this->db->join('tbl_stock_measurement_info as scale', 'scale.row_id = stock.scale_id','left');
        $this->db->join('tbl_stock_product_info as product', 'product.row_id = stock.product_id','left');
        $this->db->where('stock.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function addStockName($stockInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_stock_info', $stockInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

     function checkItemCodeExists($item_code){
            $this->db->from('tbl_stock_info as stock');
            $this->db->or_where('stock.item_code', $item_code);
            $this->db->where('stock.is_deleted', 0);
            $query = $this->db->get();
            return $query->num_rows();
    }

    function deleteStockName($stockInfo, $stock_id){
        $this->db->where('stock_id', $stock_id);
        $this->db->update('tbl_stock_info', $stockInfo);
        return TRUE;

    }

  // stock type
    public function getStockTypeInfo(){
        $this->db->from('tbl_stock_type_info as stock');
        $this->db->where('stock.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function addStockType($stockInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_stock_type_info', $stockInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function deleteStockType($stockInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_stock_type_info', $stockInfo);
        return TRUE;

    }

    // stock department
    public function getStockDepartmentInfo(){
        $this->db->from('tbl_stock_department_info as stock');
        $this->db->where('stock.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function addStockDepartment($stockInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_stock_department_info', $stockInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function deleteStockDepartment($stockInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_stock_department_info', $stockInfo);
        return TRUE;

    }

    // stock scale
    public function getStockScaleInfo(){
        $this->db->from('tbl_stock_measurement_info as stock');
        $this->db->where('stock.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    // product
    public function getStockProductInfo(){
        $this->db->from('tbl_stock_product_info as stock');
        $this->db->where('stock.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function addStockProduct($stockInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_stock_product_info', $stockInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function deleteStockProduct($stockInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_stock_product_info', $stockInfo);
        return TRUE;

    }
    

    public function getAllStockInInfo($filter=''){
        $this->db->select('stockIn.row_id,stockIn.in_date,stockIn.expiry_date,stockIn.stock_name_id,stockIn.stock_type_id,stockIn.stock_department_id,stockIn.quantity, stockIn.rate, stockIn.comments,stockName.stock_name,stockName.item_code,stockType.stock_type,stockDept.stock_department,scale.stock_scale,stockIn.sale_rate,product.product_name');
        $this->db->from('tbl_stock_in_info as stockIn');
        $this->db->join('tbl_stock_info as stockName', 'stockName.stock_id = stockIn.stock_name_id','left'); 
        $this->db->join('tbl_stock_type_info as stockType', 'stockType.row_id = stockName.type_id','left');
        $this->db->join('tbl_stock_department_info as stockDept', 'stockDept.row_id = stockIn.stock_department_id','left'); 
        $this->db->join('tbl_stock_measurement_info as scale', 'scale.row_id = stockName.scale_id','left'); 
        $this->db->join('tbl_stock_product_info as product', 'product.row_id = stockName.product_id','left');
        if(!empty($filter['in_date'])){
            $this->db->where('stockIn.in_date', $filter['in_date']);
        }
         if(!empty($filter['expiry_date'])){
            $this->db->where('stockIn.expiry_date', $filter['expiry_date']);
        }
        if(!empty($filter['expiry_date'])){
            $this->db->where('stockIn.expiry_date', $filter['expiry_date']);
        }
        if(!empty($filter['stock_name'])){
            $this->db->where('stockName.stock_name', $filter['stock_name']);
        }
        if(!empty($filter['item_code'])){
            $this->db->where('stockName.item_code', $filter['item_code']);
        }
        if(!empty($filter['stock_type'])){
            $this->db->where('stockType.stock_type', $filter['stock_type']);
        }
        if(!empty($filter['stock_department'])){
            $this->db->where('stockDept.stock_department', $filter['stock_department']);
        }
         if(!empty($filter['stock_scale'])){
            $this->db->where('scale.stock_scale', $filter['stock_scale']);
        }
        if(!empty($filter['quantity'])){
            $likeCriteria = "(stockIn.quantity  LIKE '%" . $filter['quantity'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['rate'])){
            $likeCriteria = "(stockIn.rate  LIKE '%" . $filter['rate'] . "%')";
            $this->db->where($likeCriteria);
        }
         if(!empty($filter['sale_rate'])){
            $likeCriteria = "(stockIn.sale_rate  LIKE '%" . $filter['sale_rate'] . "%')";
            $this->db->where($likeCriteria);
        }
          if(!empty($filter['product_name'])){
            $this->db->where('product.product_name', $filter['product_name']);
        }
        
        $this->db->where('stockIn.is_deleted', 0); 
        $this->db->order_by('stockIn.created_date_time', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllStockCount($filter=''){
       $this->db->select('stockIn.row_id,stockIn.in_date,stockIn.expiry_date,stockIn.stock_name_id,stockIn.stock_type_id,stockIn.stock_department_id,stockIn.quantity, stockIn.rate, stockIn.comments,stockName.stock_name,stockName.item_code,stockType.stock_type,stockDept.stock_department,scale.stock_scale,stockIn.sale_rate,product.product_name');
        $this->db->from('tbl_stock_in_info as stockIn');
        $this->db->join('tbl_stock_info as stockName', 'stockName.stock_id = stockIn.stock_name_id','left'); 
        $this->db->join('tbl_stock_type_info as stockType', 'stockType.row_id = stockName.type_id','left');
        $this->db->join('tbl_stock_department_info as stockDept', 'stockDept.row_id = stockIn.stock_department_id','left'); 
        $this->db->join('tbl_stock_measurement_info as scale', 'scale.row_id = stockName.scale_id','left'); 
        $this->db->join('tbl_stock_product_info as product', 'product.row_id = stockName.product_id','left');

        if(!empty($filter['in_date'])){
            $this->db->where('stockIn.in_date', $filter['in_date']);
        }
         if(!empty($filter['expiry_date'])){
            $this->db->where('stockIn.expiry_date', $filter['expiry_date']);
        }
        if(!empty($filter['expiry_date'])){
            $this->db->where('stockIn.expiry_date', $filter['expiry_date']);
        }
        if(!empty($filter['stock_name'])){
            $this->db->where('stockName.stock_name', $filter['stock_name']);
        }
         if(!empty($filter['item_code'])){
            $this->db->where('stockName.item_code', $filter['item_code']);
        }
        if(!empty($filter['stock_type'])){
            $this->db->where('stockType.stock_type', $filter['stock_type']);
        }
        if(!empty($filter['stock_department'])){
            $this->db->where('stockDept.stock_department', $filter['stock_department']);
        }
         if(!empty($filter['stock_scale'])){
            $this->db->where('scale.stock_scale', $filter['stock_scale']);
        }
        if(!empty($filter['quantity'])){
            $likeCriteria = "(stockIn.quantity  LIKE '%" . $filter['quantity'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['rate'])){
            $likeCriteria = "(stockIn.rate  LIKE '%" . $filter['rate'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['sale_rate'])){
            $likeCriteria = "(stockIn.sale_rate  LIKE '%" . $filter['sale_rate'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['product_name'])){
            $this->db->where('product.product_name', $filter['product_name']);
        }
        $this->db->where('stockIn.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

      // to get remaning quantity value
        function getSumOfStockOut($row_id){ 
        $this->db->select('SUM(quantity) as rem_quantity');
        $this->db->from('tbl_stock_out_info');
        $this->db->where('relation_row_id', $row_id);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();        
        return $result;
    }

    function addNewStockIn($stockInInfo){
            $this->db->trans_start();
            $this->db->insert('tbl_stock_in_info', $stockInInfo);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            return $insert_id;
        }


    function getStockInInfoById($row_id){ 
        $this->db->select('stock.row_id,stock.in_date,stock.quantity,stock.rate,stockName.stock_id,stockName.stock_name,stock.expiry_date,stock.stock_type_id,stock.comments,stock.stock_name_id,stock.stock_department_id,stockName.stock_name,stockName.item_code,stockType.stock_type,stockDept.stock_department,scale.stock_scale,stock.sale_rate,product.product_name');
        $this->db->from('tbl_stock_in_info as stock');
        $this->db->join('tbl_stock_info as stockName', 'stockName.stock_id = stock.stock_name_id','left');
         $this->db->join('tbl_stock_type_info as stockType', 'stockType.row_id = stockName.type_id','left');
        $this->db->join('tbl_stock_department_info as stockDept', 'stockDept.row_id = stock.stock_department_id','left'); 
        $this->db->join('tbl_stock_measurement_info as scale', 'scale.row_id = stockName.scale_id','left');
        $this->db->join('tbl_stock_product_info as product', 'product.row_id = stockName.product_id','left'); 
        $this->db->where('stock.row_id', $row_id);
        $this->db->where('stock.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function updateStockIn($stockInInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_stock_in_info', $stockInInfo);
        return TRUE;
    }

    function addStockOut($stockOutInfo){
            $this->db->trans_start();
            $this->db->insert('tbl_stock_out_info', $stockOutInfo);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            return $insert_id;
        }


    public function getAllStockOutInfo($filter=''){
        $this->db->select('stockOut.row_id,stockOut.out_date,stockIn.expiry_date,stockIn.stock_name_id,stockIn.stock_type_id,stockIn.stock_department_id,stockOut.quantity, stockOut.sales_price, stockOut.comments,stockName.stock_name,stockName.item_code,stockType.stock_type,stockDept.stock_department,scale.stock_scale,stockIn.sale_rate,product.product_name');
        $this->db->from('tbl_stock_out_info as stockOut');
        $this->db->join('tbl_stock_in_info as stockIn', 'stockIn.row_id = stockOut.relation_row_id','left');
        $this->db->join('tbl_stock_info as stockName', 'stockName.stock_id = stockIn.stock_name_id','left'); 
        $this->db->join('tbl_stock_type_info as stockType', 'stockType.row_id = stockName.type_id','left');
        $this->db->join('tbl_stock_department_info as stockDept', 'stockDept.row_id = stockIn.stock_department_id','left'); 
        $this->db->join('tbl_stock_measurement_info as scale', 'scale.row_id = stockName.scale_id','left'); 
        $this->db->join('tbl_stock_product_info as product', 'product.row_id = stockName.product_id','left'); 
        if(!empty($filter['out_date'])){
            $this->db->where('stockOut.out_date', $filter['out_date']);
        }
         if(!empty($filter['expiry_date'])){
            $this->db->where('stockIn.expiry_date', $filter['expiry_date']);
        }
        if(!empty($filter['stock_name'])){
            $this->db->where('stockName.stock_name', $filter['stock_name']);
        }
         if(!empty($filter['item_code'])){
            $this->db->where('stockName.item_code', $filter['item_code']);
        }
        if(!empty($filter['stock_type'])){
            $this->db->where('stockType.stock_type', $filter['stock_type']);
        }
        if(!empty($filter['stock_department'])){
            $this->db->where('stockDept.stock_department', $filter['stock_department']);
        }
         if(!empty($filter['stock_scale'])){
            $this->db->where('scale.stock_scale', $filter['stock_scale']);
        }
        if(!empty($filter['quantity'])){
            $likeCriteria = "(stockOut.quantity  LIKE '%" . $filter['quantity'] . "%')";
            $this->db->where($likeCriteria);
        }
          if(!empty($filter['sale_rate'])){
            $likeCriteria = "(stockIn.sale_rate  LIKE '%" . $filter['sale_rate'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['sales_price'])){
            $likeCriteria = "(stockOut.sales_price  LIKE '%" . $filter['sales_price'] . "%')";
            $this->db->where($likeCriteria);
        }
        
        $this->db->where('stockOut.is_deleted', 0);
        $this->db->order_by('stockOut.created_date_time', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllStockOutCount($filter=''){
       $this->db->select('stockOut.row_id,stockOut.out_date,stockIn.expiry_date,stockIn.stock_name_id,stockIn.stock_type_id,stockIn.stock_department_id,stockOut.quantity, stockOut.sales_price, stockOut.comments,stockName.stock_name,stockName.item_code,stockType.stock_type,stockDept.stock_department,scale.stock_scale,stockIn.sale_rate,product.product_name');
        $this->db->from('tbl_stock_out_info as stockOut');
        $this->db->join('tbl_stock_in_info as stockIn', 'stockIn.row_id = stockOut.relation_row_id','left');
        $this->db->join('tbl_stock_info as stockName', 'stockName.stock_id = stockIn.stock_name_id','left'); 
        $this->db->join('tbl_stock_type_info as stockType', 'stockType.row_id = stockName.type_id','left');
        $this->db->join('tbl_stock_department_info as stockDept', 'stockDept.row_id = stockIn.stock_department_id','left'); 
        $this->db->join('tbl_stock_measurement_info as scale', 'scale.row_id = stockName.scale_id','left'); 
        $this->db->join('tbl_stock_product_info as product', 'product.row_id = stockName.product_id','left'); 
        if(!empty($filter['out_date'])){
            $this->db->where('stockOut.out_date', $filter['out_date']);
        }
         if(!empty($filter['expiry_date'])){
            $this->db->where('stockIn.expiry_date', $filter['expiry_date']);
        }
        if(!empty($filter['stock_name'])){
            $this->db->where('stockName.stock_name', $filter['stock_name']);
        }
         if(!empty($filter['item_code'])){
            $this->db->where('stockName.item_code', $filter['item_code']);
        }
        if(!empty($filter['stock_type'])){
            $this->db->where('stockType.stock_type', $filter['stock_type']);
        }
        if(!empty($filter['stock_department'])){
            $this->db->where('stockDept.stock_department', $filter['stock_department']);
        }
         if(!empty($filter['stock_scale'])){
            $this->db->where('scale.stock_scale', $filter['stock_scale']);
        }
        if(!empty($filter['quantity'])){
            $likeCriteria = "(stockOut.quantity  LIKE '%" . $filter['quantity'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['sale_rate'])){
            $likeCriteria = "(stockIn.sale_rate  LIKE '%" . $filter['sale_rate'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['sales_price'])){
            $likeCriteria = "(stockOut.sales_price  LIKE '%" . $filter['sales_price'] . "%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('stockOut.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function getStockOutInfoById($row_id){ 
        $this->db->select('stock.row_id,stock.relation_row_id,stock.out_date,stock.quantity,stock.sales_price,stock.comments');
        $this->db->from('tbl_stock_out_info as stock'); 
        $this->db->where('stock.row_id', $row_id);
        $this->db->where('stock.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function updateStockOut($stockOutInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_stock_out_info', $stockOutInfo);
        return TRUE;
    }

    // stock Canteen name
	public function getStockCanteenInfo(){
        $this->db->from('tbl_canteen_stock_info as stock');
         $this->db->join('tbl_canteen_stock_type_info as type', 'type.row_id = stock.type_id','left');
        $this->db->where('stock.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
	    
	    public function addStockCanteenName($stockInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_canteen_stock_info', $stockInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function checkCanteenItemCodeExists($item_code){
            $this->db->from('tbl_canteen_stock_info as stock');
            $this->db->or_where('stock.item_code', $item_code);
            $this->db->where('stock.is_deleted', 0);
            $query = $this->db->get();
            return $query->num_rows();
    }

	    function deleteStockCanteenInfo($stockInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_canteen_stock_info', $stockInfo);
        return TRUE;

    }

	      // stock Canteen Type
	public function getStockCanteenType(){
        $this->db->from('tbl_canteen_stock_type_info as stock');
        $this->db->where('stock.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
	    
	    public function addStockCanteenType($stockInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_canteen_stock_type_info', $stockInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

	    function deleteStockCanteenType($stockInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_canteen_stock_type_info', $stockInfo);
        return TRUE;

    }

        // stock Canteen Department
	public function getStockCanteenDepartment(){
        $this->db->from('tbl_canteen_stock_department_info as stock');
        $this->db->where('stock.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
	    
	    public function addStockCanteenDepartment($stockInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_canteen_stock_department_info', $stockInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

	    function deleteStockCanteenDepartment($stockInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_canteen_stock_department_info', $stockInfo);
        return TRUE;

    }

    public function getAllCanteenStockInInfo($filter=''){
        $this->db->select('stockIn.row_id,stockIn.in_date,stockIn.expiry_date,stockIn.stock_name_id,stockIn.stock_type_id,stockIn.stock_department_id,stockIn.quantity, stockIn.rate, stockIn.comments,stockName.stock_name,stockName.item_code,stockType.stock_type,stockType.scale,stockDept.stock_department,scale.stock_scale');
        $this->db->from('tbl_canteen_stock_in_info as stockIn');
        $this->db->join('tbl_canteen_stock_info as stockName', 'stockName.row_id = stockIn.stock_name_id','left'); 
        $this->db->join('tbl_canteen_stock_type_info as stockType', 'stockType.row_id = stockName.type_id','left');
        $this->db->join('tbl_canteen_stock_department_info as stockDept', 'stockDept.row_id = stockIn.stock_department_id','left'); 
      
        if(!empty($filter['in_date'])){
            $this->db->where('stockIn.in_date', $filter['in_date']);
        }
         if(!empty($filter['expiry_date'])){
            $this->db->where('stockIn.expiry_date', $filter['expiry_date']);
        }
        if(!empty($filter['expiry_date'])){
            $this->db->where('stockIn.expiry_date', $filter['expiry_date']);
        }
        if(!empty($filter['stock_name'])){
            $this->db->where('stockName.stock_name', $filter['stock_name']);
        }
         if(!empty($filter['item_code'])){
            $this->db->where('stockName.item_code', $filter['item_code']);
        }

        if(!empty($filter['stock_type'])){
            $this->db->where('stockType.stock_type', $filter['stock_type']);
        }
        if(!empty($filter['stock_department'])){
            $this->db->where('stockDept.stock_department', $filter['stock_department']);
        }
        if(!empty($filter['quantity'])){
            $likeCriteria = "(stockIn.quantity  LIKE '%" . $filter['quantity'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['rate'])){
            $likeCriteria = "(stockIn.rate  LIKE '%" . $filter['rate'] . "%')";
            $this->db->where($likeCriteria);
        }
        
        $this->db->where('stockIn.is_deleted', 0);
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllCanteenStockCount($filter=''){
        $this->db->select('stockIn.row_id,stockIn.in_date,stockIn.expiry_date,stockIn.stock_name_id,stockIn.stock_type_id,stockIn.stock_department_id,stockIn.quantity, stockIn.rate, stockIn.comments,stockName.stock_name,stockName.item_code,stockType.stock_type,stockType.scale,stockDept.stock_department');
        $this->db->from('tbl_canteen_stock_in_info as stockIn');
        $this->db->join('tbl_canteen_stock_info as stockName', 'stockName.row_id = stockIn.stock_name_id','left'); 
        $this->db->join('tbl_canteen_stock_type_info as stockType', 'stockType.row_id = stockName.type_id','left');
        $this->db->join('tbl_canteen_stock_department_info as stockDept', 'stockDept.row_id = stockIn.stock_department_id','left'); 
      
        if(!empty($filter['in_date'])){
            $this->db->where('stockIn.in_date', $filter['in_date']);
        }
         if(!empty($filter['expiry_date'])){
            $this->db->where('stockIn.expiry_date', $filter['expiry_date']);
        }
        if(!empty($filter['expiry_date'])){
            $this->db->where('stockIn.expiry_date', $filter['expiry_date']);
        }
        if(!empty($filter['stock_name'])){
            $this->db->where('stockName.stock_name', $filter['stock_name']);
        }
         if(!empty($filter['item_code'])){
            $this->db->where('stockName.item_code', $filter['item_code']);
        }
        if(!empty($filter['stock_type'])){
            $this->db->where('stockType.stock_type', $filter['stock_type']);
        }
        if(!empty($filter['stock_department'])){
            $this->db->where('stockDept.stock_department', $filter['stock_department']);
        }
        if(!empty($filter['quantity'])){
            $likeCriteria = "(stockIn.quantity  LIKE '%" . $filter['quantity'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['rate'])){
            $likeCriteria = "(stockIn.rate  LIKE '%" . $filter['rate'] . "%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('stockIn.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

      // to get remaning quantity value
        function getSumOfCanteenStockOut($row_id){ 
        $this->db->select('SUM(quantity) as rem_quantity');
        $this->db->from('tbl_canteen_stock_out_info');
        $this->db->where('relation_row_id', $row_id);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();        
        return $result;
    }

      function addNewCanteenStockIn($stockInInfo){
            $this->db->trans_start();
            $this->db->insert('tbl_canteen_stock_in_info', $stockInInfo);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            return $insert_id;
        }

      function getCanteenStockInInfoById($row_id){ 
        $this->db->select('stock.row_id,stock.in_date,stock.quantity,stock.rate,stockName.stock_name,stock.expiry_date,stock.stock_type_id,stock.comments,stock.stock_name_id,stock.stock_department_id,stockName.stock_name,stockName.item_code,stockType.stock_type,stockType.scale,stockDept.stock_department');
        $this->db->from('tbl_canteen_stock_in_info as stock');
        $this->db->join('tbl_canteen_stock_info as stockName', 'stockName.row_id = stock.stock_name_id','left');
        $this->db->join('tbl_canteen_stock_type_info as stockType', 'stockType.row_id = stockName.type_id','left');
        $this->db->join('tbl_canteen_stock_department_info as stockDept', 'stockDept.row_id = stock.stock_department_id','left'); 
        $this->db->where('stock.row_id', $row_id);
        $this->db->where('stock.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function updateCanteenStockIn($stockInInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_canteen_stock_in_info', $stockInInfo);
        return TRUE;
    }


    function addCanteenStockOut($stockOutInfo){
            $this->db->trans_start();
            $this->db->insert('tbl_canteen_stock_out_info', $stockOutInfo);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            return $insert_id;
        }


         public function getAllCanteenStockOutInfo($filter=''){
        $this->db->select('stockOut.row_id,stockOut.out_date,stockIn.expiry_date,stockIn.stock_name_id,stockIn.stock_type_id,stockIn.stock_department_id,stockOut.quantity, stockOut.sales_price, stockOut.comments,stockName.stock_name,stockName.item_code,stockType.stock_type,stockType.scale,stockDept.stock_department');
        $this->db->from('tbl_canteen_stock_out_info as stockOut');
        $this->db->join('tbl_canteen_stock_in_info as stockIn', 'stockIn.row_id = stockOut.relation_row_id','left');
        $this->db->join('tbl_canteen_stock_info as stockName', 'stockName.row_id = stockIn.stock_name_id','left'); 
        $this->db->join('tbl_canteen_stock_type_info as stockType', 'stockType.row_id = stockName.type_id','left');
        $this->db->join('tbl_canteen_stock_department_info as stockDept', 'stockDept.row_id = stockIn.stock_department_id','left'); 
      
        if(!empty($filter['out_date'])){
            $this->db->where('stockOut.out_date', $filter['out_date']);
        }
         if(!empty($filter['expiry_date'])){
            $this->db->where('stockIn.expiry_date', $filter['expiry_date']);
        }
        if(!empty($filter['stock_name'])){
            $this->db->where('stockName.stock_name', $filter['stock_name']);
        }
        if(!empty($filter['item_code'])){
            $this->db->where('stockName.item_code', $filter['item_code']);
        }
        if(!empty($filter['stock_type'])){
            $this->db->where('stockType.stock_type', $filter['stock_type']);
        }
        if(!empty($filter['stock_department'])){
            $this->db->where('stockDept.stock_department', $filter['stock_department']);
        }
        if(!empty($filter['quantity'])){
            $likeCriteria = "(stockOut.quantity  LIKE '%" . $filter['quantity'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['sales_price'])){
            $likeCriteria = "(stockOut.sales_price  LIKE '%" . $filter['sales_price'] . "%')";
            $this->db->where($likeCriteria);
        }
        
        $this->db->where('stockOut.is_deleted', 0);
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllCanteenStockOutCount($filter=''){
      $this->db->select('stockOut.row_id,stockOut.out_date,stockIn.expiry_date,stockIn.stock_name_id,stockIn.stock_type_id,stockIn.stock_department_id,stockOut.quantity, stockOut.sales_price, stockOut.comments,stockName.stock_name,stockName.item_code,stockType.stock_type,stockType.scale,stockDept.stock_department');
        $this->db->from('tbl_canteen_stock_out_info as stockOut');
        $this->db->join('tbl_canteen_stock_in_info as stockIn', 'stockIn.row_id = stockOut.relation_row_id','left');
        $this->db->join('tbl_canteen_stock_info as stockName', 'stockName.row_id = stockIn.stock_name_id','left'); 
        $this->db->join('tbl_canteen_stock_type_info as stockType', 'stockType.row_id = stockName.type_id','left');
        $this->db->join('tbl_canteen_stock_department_info as stockDept', 'stockDept.row_id = stockIn.stock_department_id','left'); 
      
        if(!empty($filter['out_date'])){
            $this->db->where('stockOut.out_date', $filter['out_date']);
        }
         if(!empty($filter['expiry_date'])){
            $this->db->where('stockIn.expiry_date', $filter['expiry_date']);
        }
        if(!empty($filter['stock_name'])){
            $this->db->where('stockName.stock_name', $filter['stock_name']);
        }
         if(!empty($filter['item_code'])){
            $this->db->where('stockName.item_code', $filter['item_code']);
        }
        if(!empty($filter['stock_type'])){
            $this->db->where('stockType.stock_type', $filter['stock_type']);
        }
        if(!empty($filter['stock_department'])){
            $this->db->where('stockDept.stock_department', $filter['stock_department']);
        }
        if(!empty($filter['quantity'])){
            $likeCriteria = "(stockOut.quantity  LIKE '%" . $filter['quantity'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['sales_price'])){
            $likeCriteria = "(stockOut.sales_price  LIKE '%" . $filter['sales_price'] . "%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('stockOut.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function getCanteenStockOutInfoById($row_id){ 
        $this->db->select('stock.row_id,stock.relation_row_id,stock.out_date,stock.quantity,stock.sales_price,stock.comments');
        $this->db->from('tbl_canteen_stock_out_info as stock'); 
        $this->db->where('stock.row_id', $row_id);
        $this->db->where('stock.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function updateCanteenStockOut($stockOutInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_canteen_stock_out_info', $stockOutInfo);
        return TRUE;
    }


    
    // function (){
    //     $this->db->from('tbl_student_academic_info as academic');
    //     $this->db->join('tbl_student_info as std', 'std.row_id =  academic.rel_student_row_id');
    //     $this->db->where('academic.is_current', 1);
    //     $this->db->where('academic.is_active', 1);
    //     $this->db->where('academic.is_deleted', 0);
    //     $this->db->where('std.is_deleted', 0);
    //     $query = $this->db->get();
    //     $result = $query->result();        
    //     return $result;
    // }



    public function getStudentId(){
        $this->db->select('student.row_id,student.blood_group,student.student_no,student.application_no,student.register_no, 
        student.student_id,student.hall_ticket_no,student.student_name,student.elective_sub,student.dob,student.mobile,student.email,
        student.date_of_admission,student.roll_number,student.gender,student.student_status,student.residential_address,
        student.pu_board_number,student.category,student.last_board_name,student.present_address,student.permanent_address,
        student.father_name,student.father_mobile,student.mother_name,student.mother_mobile,student.program_name,student.stream_name,
        student.intake_year,student.term_name,student.section_name');
        $this->db->from('tbl_students_info as student'); 
            
        $this->db->where('student.is_deleted', 0);
        $this->db->where('student.is_active', 1);
        $this->db->order_by('student.student_id', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }


    function addSalesToDB($salesInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_sales', $salesInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function addSalesDetailToDB($billDetailInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_sales_detail', $billDetailInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getStockPriceById($stock_id){
        $this->db->from('tbl_stock_in_info as stock');
        $this->db->where('stock.row_id', $stock_id);
        $this->db->where('stock.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }


    public function getAllSalesInfo($filter=''){
        $this->db->select('sales.date,sales.student_id,student.student_name,sales.total_amount');
        $this->db->from('tbl_sales as sales');
        $this->db->join('tbl_students_info as student', 'student.student_id = sales.student_id','left'); 
        if(!empty($filter['date_filter'])){
            $this->db->where('sales.date', $filter['date_filter']);
        }
         if(!empty($filter['student_id'])){
            $this->db->where('sales.student_id', $filter['student_id']);
        }
        
        if(!empty($filter['student_name'])){
            $this->db->where('student.student_name', $filter['student_name']);
        }
         if(!empty($filter['total_amount'])){
            $this->db->where('sales.total_amount', $filter['total_amount']);
        }
        
        
        $this->db->where('sales.is_deleted', 0); 
        $this->db->order_by('sales.created_date_time', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }


    public function getAllSalesCount($filter=''){
        $this->db->select('sales.date,sales.student_id,student.student_name,sales.total_amount');
        $this->db->from('tbl_sales as sales');
        $this->db->join('tbl_students_info as student', 'student.student_id = sales.student_id','left'); 

        if(!empty($filter['date_filter'])){
            $this->db->where('sales.date', $filter['date_filter']);
        }
         if(!empty($filter['student_id'])){
            $this->db->where('sales.student_id', $filter['student_id']);
        }
        
        if(!empty($filter['student_name'])){
            $this->db->where('student.student_name', $filter['student_name']);
        }
         if(!empty($filter['total_amount'])){
            $this->db->where('sales.total_amount', $filter['total_amount']);
        }

         $this->db->where('sales.is_deleted', 0); 
         $query = $this->db->get();
         return $query->num_rows();
     }



     public function getAllStockInInfoForSale(){
        $this->db->select('stockIn.row_id,stockIn.in_date,stockIn.expiry_date,stockIn.stock_name_id,stockIn.stock_type_id,stockIn.stock_department_id,stockIn.quantity, stockIn.rate, stockIn.comments,stockName.stock_name,stockName.item_code,stockType.stock_type,stockDept.stock_department,scale.stock_scale,stockIn.sale_rate,product.product_name');
        $this->db->from('tbl_stock_in_info as stockIn');
        $this->db->join('tbl_stock_info as stockName', 'stockName.stock_id = stockIn.stock_name_id','left'); 
        $this->db->join('tbl_stock_type_info as stockType', 'stockType.row_id = stockName.type_id','left');
        $this->db->join('tbl_stock_department_info as stockDept', 'stockDept.row_id = stockIn.stock_department_id','left'); 
        $this->db->join('tbl_stock_measurement_info as scale', 'scale.row_id = stockName.scale_id','left'); 
        $this->db->join('tbl_stock_product_info as product', 'product.row_id = stockName.product_id','left');
       
        
        $this->db->where('stockIn.is_deleted', 0); 
        $this->db->order_by('stockIn.created_date_time', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }
 

}

?>