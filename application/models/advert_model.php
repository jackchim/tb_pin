<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @todo 后台广告管理模型类，用于
 * 对广告进行处理
 *
 */
class Advert_model extends CI_Model{

	/**
	 * @todo 构造函数，无意义
	 *
	 */
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * @todo 增加一条广告，用于首页广告轮播
	 *
	 * @param array $data 插入数据库的数据数组
	 * @return boolean true|false
	 */
	function addNewAdv($data=array()){
		if (!empty($data)) {
			return $this->db->insert('tupu_advert',$data);//插入数据库
		}
		return false;
	}
	/**
	 * @todo 取得广告列表，暂时未考虑搜索，
	 * 以后若有需求课增加搜索条件
	 *
	 * @param int $start 开始pos
	 * @param 取得的最大条数 $num
	 */
	function getAdvByIndex($start=0,$num=20,$condition=array("ad_id > 0")){
		$advs=array();//初始化
		$exper='';
		if(!empty($condition)){
			$exper=implode(' AND ',$condition);
		}
		$this->db->select("*")->from('tupu_advert')->where($exper)->order_by('display_order','desc')->order_by('ad_id','desc')->limit($num,$start);
		$advs=$this->db->get()->result();
		return empty($advs)?array():$advs;
	}
	
	/**
	 * @todo 后台管理页面广告上移和下移
	 *
	 * @param int $cur_id 要移动的广告id
	 * @param int $other_id 要替换掉的广告id
	 * @return bool true|false
	 */
	public function move_advs($cur_id,$other_id){
			$cur_adv=$this->db->select("display_order")->from("tupu_advert")->where(array('ad_id'=>$cur_id))->get()->result();
			$cur_data=$cur_adv[0];
			$other_adv=$this->db->select("display_order")->from("tupu_advert")->where(array('ad_id'=>$other_id))->get()->result();//转换的
			$other_data=$other_adv[0];
			if($this->db->where('ad_id',$cur_id)->update('tupu_advert',array('display_order'=>$other_data->display_order))&&$this->db->where('ad_id',$other_id)->update('tupu_advert',array('display_order'=>$cur_data->display_order)))
			return true;
			return false;
	}
}