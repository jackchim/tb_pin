<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Connector_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}

	function get_bind_vendor_by_uid( $uid )
	{
		$this->db->select('vendor');
		return $this->db->where('user_id',$uid)->get('tupu_connector')->result();
	}

	function get_bind_connector_by_uid( $uid )
	{
		return $this->db->where('user_id',$uid)->get('tupu_connector')->result();
	}

	function get_bind_by_vendor_and_suid( $vendor, $suid )
	{
		$array = array('social_userid' => $suid, 'vendor' => $vendor);
		return $this->db->where($array)->get('tupu_connector')->row();
	}

	function add_connector($data)
	{
		$this->db->insert('tupu_connector',$data);
	}

	function edit_connector($cid,$data)
	{
		$this->db->where('connect_id',$cid)->update('tupu_connector',$data);
	}

	function del_connector($cid)
	{
		$this->db->where('connect_id',$cid)->delete('tupu_connector');
	}

	function del_connector_by_vendor_uid($vendor,$uid)
	{
		$array = array('user_id' => $uid, 'vendor' => $vendor);
		$this->db->where($array)->delete('tupu_connector');
	}

}