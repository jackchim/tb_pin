<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}

	function get_full_user_by_email( $email = '' )
	{
		return $this->db->where('email',$email)->get('tupu_user')->row();
	}

	function search_user($start=0,$num=20, $conditions=array() )
	{
		$this->init_search_condition($conditions);
		$this->db->limit($num,$start);
		return $this->db->get('tupu_user')->result();
	}

	function init_search_condition($conditions=array()){
		if(isset($conditions['nickname'])){
			$this->db->like('tupu_user.nickname',$conditions['nickname']);
		}

		if(isset($conditions['is_active'])&&$conditions['is_active']!=FALSE){
			$this->db->where('tupu_user.is_active',$conditions['is_active']);
		}
		$this->db->where('tupu_user.is_deleted',0);
	}

	function count_user($conditions=array())
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('tupu_user');
		$this->init_search_condition($conditions);
		return $this->db->get()->row()->total;
	}

	function get_user_by_uid($uid = 0)
	{
		return $this->db->where('user_id',$uid)->get('tupu_user')->row();
	}

	function get_user_by_domain($domain = '')
	{
		return $this->db->where('domain',$domain)->get('tupu_user')->row();
	}

	function get_user_by_nickname($nickname)
	{
		return $this->db->where('nickname',$nickname)->get('tupu_user')->row();
	}

	function get_user_by_password_key($password_key)
	{
		if($password_key){
			return $this->db->where('lost_password_key',$password_key)->get('tupu_user')->row();
		}
		return false;
	}
	
	function get_user_friend_recommend($user_id){
		$this -> db -> select('is_friend_recommend');
		$this -> db -> where('user_id' , $user_id);
		return $this -> db ->  get('tupu_user') -> row() -> is_friend_recommend;
	}
	/**
	 * 更新个人主页的访问记录
	 *
	 * @param int $u_id  个人主页主人的用户id
	 * @param array $view_data 访问者的数据 user_id , user_name , view_time
	 */
	function update_view($uid , $view_data){
		//var_dump($view_data);exit;
		$this -> db -> set('total_view', "total_view+1", FALSE);//访问次数+1
		//获取view_detail值
		$user = $this -> db -> select('view_detail') -> where('user_id',$uid) -> get ('tupu_user') -> row();
		$view_array = unserialize($user -> view_detail);
		//var_dump($view_array);exit;
		if (!$view_array || empty($view_array)) {
			$view_array[0] = $view_data;
		}else {
			//查找适合有访问者的访问记录
			//$return = array_search($view_data['nickname'] , $view_array);
			foreach ($view_array as $k => $v){
				if ($v['nickname'] == $view_data['nickname']) {
					unset($view_array[$k]);
				}
			}
			if (count($view_array) == 30) {
				array_pop($view_array);
			}
			array_unshift($view_array,$view_data);
		}
		$view_detail = "'".serialize($view_array)."'";
		$this->db->set('view_detail', $view_detail, FALSE);
		return $this->db->where('user_id',$uid)->update('tupu_user');
	}
	/**
	 * step更新更新或数字修改更新
	 * 更新用户分享统计
	 */
	function update_total_shares($uid , $step = 1 , $type = 'step')
	{		
		if ($type == 'step') {
			$this->db->set('total_shares', "total_shares+{$step}", FALSE);
		}elseif ($type == 'total'){
			$this->db->set('total_shares', $step , FALSE);
		}
		return $this->db->where('user_id',$uid)->update('tupu_user');
	}

	function update_user_password($uid,$new_password)
	{
		$data['passwd'] = md5($new_password);
		return $this->db->where('user_id',$uid)->update('tupu_user', $data);
	}

	function update_password_key($email,$password_key,$password_expire)
	{
		$data['lost_password_key'] = $password_key;
		$data['lost_password_expire'] = $password_expire;
		return $this->db->where('email',$email)->update('tupu_user', $data);
	}

	function get_users()
	{
		return $this->db->get('tupu_user')->result();
	}

	function add_user($data)
	{
		if($this->db->insert('tupu_user',$data)){
			$uid = $this->db->insert_id();
			
			$this->load->model('album_model');
			$this->album_model->create_default_album($uid , $data['nickname']);
			$this->load->model('follow_model');
			$this->follow_model->add_follow($uid,$uid);
		}
		return $uid;
	}

	function edit_user($uid,$data)
	{
		return $this->db->where('user_id',$uid)->update('tupu_user',$data);
	}

	function flag_user_del($user_id)
	{
		if(!$user_id)
		return false;
		return $this->db->where('user_id',$user_id)->update('tupu_user',array('is_deleted'=>1));
	}

	function del_user($uid)
	{
		$this->db->where('user_id',$uid)->delete('tupu_user');
	}

	// Usually for AJAX
	function check_email_exists( $email = '' )
	{
		return $this->db->select('user_id')->where('email',$email)->get('tupu_user')->row();
	}
	// Usually for AJAX
	function check_nickname_exists($nickname)
	{
		return $this->db->select('user_id')->where('nickname',$nickname)->get('tupu_user')->row();
	}

	// Usually for AJAX
	function check_domain_exists($domain)
	{
		return $this->db->select('user_id')->where('domain',$domain)->get('tupu_user')->row();
	}

	function refresh_usersession(){
		$user_session = $this->get_usersession();
		if ($user_session) {
			$user = $this->get_user_by_uid($user_session['uid']);
			$this->set_usersession($user);
		}
	}

	function set_usersession($user,$is_remember=FALSE){
		$avatar_info = $this->get_avatarinfo($user->user_id);
		switch ($user->gender) {
			case 'male':
				$gender = '男';
				break;
			case 'female':
				$gender = '女';
				break;
			default:
				$gender = '保密';
				break;
		}

		$local_user_info = array(
								'uid'=>$user->user_id,
								'nickname'=>$user->nickname,
								'province'=>$user->province,
								'city'=>$user->city,
								'email'=>$user->email,
								'gender'=>$gender,
								'total_follows'=>$user->total_follows,
								'total_followers'=>$user->total_followers,
								'total_shares'=>$user->total_shares,
								'bio'=>$user->bio,
								'total_albums'=>$user->total_albums,
								'user_type'=>$user->user_type,
								'album_number'=>count($albums),
								'is_social'=>$user->is_social,
								'avatar_local'=>$avatar_info['dir'].$avatar_info['filename'],
								'avatar_large'=>$avatar_info['dir'].$avatar_info['large'],
								'avatar_middle'=>$avatar_info['dir'].$avatar_info['middle'],
								'avatar_small'=>$avatar_info['dir'].$avatar_info['small']
		);
		$this->session->set_userdata('local_user_info',$local_user_info);
		//var_dump($local_user_info);exit;
		if($is_remember){
			$this->input->set_cookie('local_user_info',serialize($local_user_info),604800);
		}
	}

	function remove_usersession(){
		$this->session->set_userdata('local_user_info','');
		$this->load->helper('cookie');
		delete_cookie('local_user_info');
	}

	function get_usersession(){
		//$this -> set_usersession();
		//var_dump($this->session->userdata('local_user_info'));exit;
		if($this->session->userdata('local_user_info')){
			return $this->session->userdata('local_user_info');
		}elseif($this->input->cookie('local_user_info', TRUE)){
			$this->session->set_userdata('local_user_info', unserialize($this->input->cookie('local_user_info', TRUE)));
			return $this->session->userdata('local_user_info');
		}else{
			return false;
		}
	}

	public function get_avatarinfo($uid){
		$uid = abs(intval($uid));
		$uid = sprintf("%09d", $uid);
		$dir1 = substr($uid, 0, 3);
		$dir2 = substr($uid, 3, 2);
		$dir3 = substr($uid, 5, 2);
		$info = array();
		$dir = 'data/avatars/'.$dir1.'/'.$dir2.'/'.$dir3.'/';
		$filename = substr($uid, -2).'_avatar';
		$info['dir'] = $dir;
		$info['filename'] = $filename;
		$info['orgin'] = $filename.'.jpg';
		$info['large'] = $filename.'_large.jpg';
		$info['middle'] = $filename.'_middle.jpg';
		$info['small'] = $filename.'_small.jpg';
		return $info;
	}

	public function create_default_avatar($uid){
		$avatar_info = $this->get_avatarinfo($uid);
		$avatar_dir = FCPATH.$avatar_info['dir'];
		(!is_dir($avatar_dir))&&@mkdir($avatar_dir,0777,true);

		file_exists($avatar_dir.$avatar_info['orgin']) && unlink($avatar_dir.$avatar_info['orgin']);
		file_exists($avatar_dir.$avatar_info['large']) && unlink($avatar_dir.$avatar_info['large']);
		file_exists($avatar_dir.$avatar_info['middle']) && unlink($avatar_dir.$avatar_info['middle']);
		file_exists($avatar_dir.$avatar_info['small']) && unlink($avatar_dir.$avatar_info['small']);

		$default_source_small = FCPATH.'data/images/avatar_small.jpg';
		$default_source_middle = FCPATH.'data/images/avatar_middle.jpg';
		$default_source_large = FCPATH.'data/images/avatar_large.jpg';
		$default_source_orgin = FCPATH.'data/images/avatar_large.jpg';

		@copy($default_source_orgin, $avatar_dir.$avatar_info['orgin']);
		@copy($default_source_small, $avatar_dir.$avatar_info['small']);
		@copy($default_source_middle, $avatar_dir.$avatar_info['middle']);
		@copy($default_source_large, $avatar_dir.$avatar_info['large']);

		return $avatar_info['dir'].$avatar_info['filename'];
	}

	/**
	 * 统计全站注册用户数量
	 *
	 */
	public function count_user_sub(){
		return $this->db->count_all_results("tupu_user");
	}
	/**
	 * @todo 统计文件系统的大小
	 *
	 * @param string  $dir 目录名或文件名
	 * @return int 文件大小
	 */
	public function count_dir_size($dir="./"){
		$count_size=0;//文件总大小，静态处理
		if(!file_exists($dir)){
			return 0;
		}
		if (is_dir($dir)) {
			$dir=ltrim($dir,'/');
			$dp=opendir($dir);
			while ($file=readdir($dp)) {
				if ($file=='.'||$file=="..") {
					continue;
				}
				if (is_dir($dir.'/'.$file)) {
					$count_size+=$this->count_dir_size($dir.'/'.$file);//统计目录
				}else{
					$count_size+=filesize($dir.'/'.$file);	
				}
			}
			
		}else{
			$count_size+=filesize($dir);//直接统计文件
		}
		//$count_size = $this->exchange_byte($count_size);
		return $count_size;
	}
	/**
	 * @todo 根据传入的字节自动转换单位
	 * 
	 * @param int $size 文件字节数
	 * @return string 返回的文件大小统计包括单位信息
	 */
	public function exchange_byte($size=0){
		$byte="B";
		$filesize=0;
		if($size/pow(1024,1)<1){
			$filesize=$size;
			$byte="B";
		}elseif ($size/pow(1024,1)<1024&&$size/pow(1024,1)>1) {
			$byte="KB";
			$filesize=$size/pow(1024,1);
		}elseif ($size/pow(1024,2)<=1024){
			$filesize=$size/pow(1024,2);
			$byte='MB';
		}elseif ($size/pow(1024,3)){
			$filesize=$size/pow(1024,3);
			$byte="GB";
		}
		$filesize=round($filesize,2);
	return $filesize.$byte;
	}
	
	/**
	 * @todo 用户禁言
	 * 用于后台管理
	 * 只能对用户是未禁言状态
	 * 且当对用户实施禁言时要查看用户是否已经是过了期限的
	 *
	 * @param int $user_id
	 * @param unknown_type $type
	 * @return unknown
	 */
	public function user_forbidden($user_id=0,$type=0){
		if (empty($user_id)) {
			return false;//user_id不能为空
		}
		$check_array=array(0,1,2);
		if (!in_array($type,$check_array)) {
			return false;
		}
		if (!$this->can_forbidden_user($user_id)) {
			return false;
		}
		$this->can_forbidden_user($user_id);
		$set=array();//禁言设置
		$where=array();//禁言条件
		if ($type==1) {
			//禁言48小时，需要有禁言时间参照点
			$time=time();//取出当前时间为禁言时间参照点
			$set=array('is_forbidden'=>$type,'forbiden_time'=>$time);
			$where=array('user_id'=>$user_id);
		}else{
			$set=array('is_forbidden'=>$type);//永久禁言
			$where=array('user_id'=>$user_id);
		}
		return $this->db->update('tupu_user',$set,$where);	
	}
	/**
	 * @todo 检测是否可以对用户禁言
	 * 一般是后台管理员已经对用户实施永久禁言的情况下
	 *
	 * @param unknown_type $user_id
	 */
	public function can_forbidden_user($user_id){
		$result=$this->get_user_by_uid($user_id);
		if(intval($result->is_forbidden)==2){
			return false;
		}
		return true;
	}
	/**
	 * @todo 检查用户是否被禁言
	 * true 为没有禁言
	 * false 被禁言
	 * @param int $user_id
	 * @return bool true|false;
	 */
	public function check_forbidden($user_id=0){
		if (empty($user_id)) {
			$user_info=$this->get_usersession();
			$user_id=$user_info['uid'];
			
		}
		
		$user=$this->get_user_by_uid($user_id);
		if($user->is_forbidden==0){
			return false;//不禁止
		}elseif ($user->is_forbidden==1){
			 $now=time();
			 $forbiden_time=$user->forbiden_time;
			  $hours=($now-($user->forbiden_time))/(3600);//禁言的时间长度值以小时为最小值
				if($hours>=48){
					$data=array('is_forbidden'=>0);
					$this->edit_user($user_id,$data);//超过48小时
					return false;//不禁止
		}else{
			return true;//禁止
		}
		}
		return true;//禁止
	}
	
	/**
	 * 同步用户活跃数
	 *
	 * @param array  $active
	 * @return boolean
	 */
	public function insert_active($active = array()){
			if(!empty($active)){
				$this->db->insert("tupu_active_user",$active);
				return true;
			}
			return false;
	}
	
	/**
	 * 统计每天新增用户数
	 * 以当天零点时间计时
	 *
	 */
	public function count_new_register_user(){
		$pre_time = strtotime('-24 hour');
		$current_date = date('Y-m-d H:i:s' , $pre_time);//当前日期
		$count = $this-> db -> where('create_time >',$current_date)->count_all_results('tupu_user');//是当天注册的。
		return $count;
	}
	
	/**
	 * 统计24小时内用户活跃数
	 * 以当前日期为准
	 */
	public function count_active_user(){
		$pre_time = strtotime('-24 hour');
		//24小时登录的。
		$count = $this->db->where("login_time > ",$pre_time)->count_all_results('tupu_active_user');
		return $count;
	}
	
	/**
	 * 注册用户总数
	 * 
	 */
	public function count_total_user(){
		$count = $this->db->where("user_id > ",0)->count_all_results('tupu_user');
		return $count;
	}
	//
	function top_users($limit = 5){
		$this -> db -> select('*');
		$this -> db -> from('tupu_user');
		$this -> db -> where(array('is_deleted' => 0 , 'is_active' => 1));
		$this -> db -> order_by('total_favorite_shares desc , total_shares desc , total_followers desc');
		$this->db->limit($limit);
		return $users = $this->db->get()->result();
	}
	
	function get_recommend_friends($u_id , $num = 10){
		$sql = "select * from {$this->db->dbprefix}tupu_user
				 where user_id not in 
				 (select friend_id from {$this->db->dbprefix}tupu_follow where user_id = {$u_id})
				 order by total_favorite_shares desc , total_shares desc , total_followers desc
				 limit {$num}";
		$query = $this -> db -> query($sql);
		return $query -> result();
	}
	
	function disable_friend_recommend($uid)
	{		
		$this->db->set('is_friend_recommend', 1, FALSE);
		return $this->db->where('user_id',$uid)->update('tupu_user');
	}
	


}