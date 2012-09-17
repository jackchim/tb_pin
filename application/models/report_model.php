<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class report_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}
	function insert_report($data=array()){
		if (!empty($data)) {
			if($this->db->insert("tupu_report",$data))
			return true;
			return false;
		}
		return false;
	}
	
	

}