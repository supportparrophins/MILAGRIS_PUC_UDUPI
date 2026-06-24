<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
//require APPPATH . '/libraries/BaseController.php';
//require_once APPPATH . "/libraries/PHPExcel.php";
require_once('PHPExcel.php');

class Excel extends PHPExcel
{
	public function __construct()
	{
		parent::__construct();
	}
}


?>