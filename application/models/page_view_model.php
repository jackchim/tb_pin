<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_view_model extends CI_Model{

	/**
	 * @todo 构造函数，无意义
	 *
	 */
	function __construct()
	{
		parent::__construct();
	}
	
	function addRecord($data){
		$this -> db -> insert('tupu_page_view' , $data);
		return true;
	}
	
	function count_day_views(){
		$pre_time = strtotime('-24 hour');
		$data = array();
		$data['page_count'] = $this->db->where('view_time >',$pre_time)->count_all_results('tupu_page_view');
		$data['ip_count'] = $this -> db -> select("count(distinct(client_ip)) as total") -> where('view_time >',$pre_time)-> get('tupu_page_view')->row() -> total;
		$data['page_count_total']=$this->db->where('id >',0)->count_all_results('tupu_page_view');
		$data['ip_count_total'] = $this -> db -> select("count(distinct(client_ip)) as total") -> where('id >',0)-> get('tupu_page_view')->row() -> total;
		
		return $data;
	}
	
}