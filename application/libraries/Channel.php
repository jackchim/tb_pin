<?php if (!defined('BASEPATH')) exit('No direct access allowed.');
class Channel {
	private $ci;

	public function __construct()
	{
		$this->ci =& get_instance();
		log_message('debug', 'Tupu: Channel class initialized.');
	}

	private function get_channelinfo($channel){
		if(isset($channel)){
			$custom =  $this->ci->config->item('custom');
			switch ($channel)
			{
				case 'taobao':
					$channelinfo = array(
							 'APPKEY'=>$custom['api']['Taobao']['APPKEY'],
							 'APPSECRET'=>$custom['api']['Taobao']['APPSECRET'],
							 'PROMOTION_ID'=>$custom['api']['Taobao']['PID']
							 //'PROMOTION_ID'=>'29948364'
					);
					break;
					
				default:
					$channelinfo = null;
			}
			return $channelinfo;
		}
	}


	function get_item_id ($channel , $url){
		$channel_class = 'Channel_'.$channel;
		$channel_class_path = APPPATH.'libraries/channel/'.$channel.'/'.$channel_class.'.php';
		
		if(file_exists($channel_class_path)) {
			include_once $channel_class_path;
			if(class_exists($channel_class)){
				$data = array();
				$info = $this->get_channelinfo($channel); //获取渠道的设置信
				
				$channel_instance = new $channel_class($info);
				$item_id = $channel_instance->get_item_id($url); //执行搜索并返回商品列表
				var_dump($item_id);exit;
				return $item_id;
				
			}else{
				show_error('Class not Found:'.$channel_class);
			}
		}else{
			show_error('File Not Found:'.$channel_class_path);
		}
	}
	/**
	 * fetch_remoteinfo function.
	 * 获取单个商品信息
	 * @access public
	 * @param mixed $channel  商品推广渠道
	 * 
	 * @param mixed $url   抓取商品的HTML页面地址
	 * @return void
	 */
	public function fetch_remoteinfo($channel,$url){
		$channel_class = 'Channel_'.$channel;
		$channel_class_path = APPPATH.'libraries/channel/'.$channel.'/'.$channel_class.'.php';
		if(file_exists($channel_class_path)) {
			include_once $channel_class_path;
			if(class_exists($channel_class)){
				$data = array();
				$info = $this->get_channelinfo($channel);
				$channel_instance = new $channel_class($info);
				if(method_exists($channel_instance, 'fetch_images')){
					$data = $channel_instance->fetch_images($url);
					return $data;
				}
				$item_id = $channel_instance->get_item_id($url);
				$good_info = $channel_instance->fetch_goodinfo($item_id);
				$promotion = $channel_instance->get_promotion_url($item_id);
				if(isset($good_info['orgin_img_url'])){
					//$image_data = $this->save_remote_image($good_info['orgin_img_url']);
					$data = array();
					$data['type'] = 'channel';
					$data['channel'] = $channel;
					$data['item_id'] = $item_id;
					$data['name'] = $good_info['name'];
					$data['price'] = $good_info['price'];
					$data['orgin_url'] = $good_info['orgin_url'];
					$data['orgin_image_url'] = $good_info['orgin_img_url'];
					$data['orgin_image_url_small'] = $good_info['orgin_img_url_small'];
					$data['shop_name'] = $good_info['shop_name'];
					$data['item_imgs'] = $good_info['item_imgs'];
					if($promotion){
						$data['promotion_url'] = $promotion['click_url'];
					}else{
						$data['promotion_url'] = $good_info['orgin_url'];
					}
					return $data;
				}
			}else{
				show_error('Class not Found:'.$channel_class);
			}
		}else{
			show_error('File Not Found:'.$channel_class_path);
		}
	}

	/**
	 * 获取单个商品的信息
	 * */
	public function get_item($channel , $item_id){
		$channel_class = 'Channel_'.$channel;
		$channel_class_path = APPPATH.'libraries/channel/'.$channel.'/'.$channel_class.'.php';
		if(file_exists($channel_class_path)) {
			include_once $channel_class_path;
			if(class_exists($channel_class)){
				$data = array();
				$info = $this->get_channelinfo($channel); //获取渠道的设置信
				
				$channel_instance = new $channel_class($info);
				$item = $channel_instance->fetch_goodinfo($item_id); //执行搜索并返回商品列表
				return $item;
				
			}else{
				show_error('Class not Found:'.$channel_class);
			}
		}else{
			show_error('File Not Found:'.$channel_class_path);
		}
	}
	/**
	 * get_channel_items function.
	 * 查询某推广渠道的商品列表
	 * @access public
	 * @param mixed $channel  推广渠道名称
	 * @param mixed $keyword  商品搜索关键词
	 * @param mixed $category_id  商品的分类ID
	 * @param mixed $page  返回结果的页数
	 * @return array
	 */
	public function get_channel_items($channel,$keyword,$category_id,$page){

		$channel_class = 'Channel_'.$channel;
		$channel_class_path = APPPATH.'libraries/channel/'.$channel.'/'.$channel_class.'.php';
		if(file_exists($channel_class_path)) {
			include_once $channel_class_path;
			if(class_exists($channel_class)){
				$data = array();
				$info = $this->get_channelinfo($channel); //获取渠道的设置信
				
				$channel_instance = new $channel_class($info);
				$items = $channel_instance->get_items_list($keyword,$category_id,$page); //执行搜索并返回商品列表
				return $items;
				
			}else{
				show_error('Class not Found:'.$channel_class);
			}
		}else{
			show_error('File Not Found:'.$channel_class_path);
		}
	}



	/**
	 * get_channel_cats function.
	 * 获取某渠道的商品分类
	 * @access public
	 * @param mixed $channel 	推广渠道名称
	 * @param mixed $parent_id  父商品类目 id，通常0表示根节点, 传输该参数返回所有子类目。
	 * @return object
	 */
	public function get_channel_cats($channel,$parent_id){

		$channel_class = 'Channel_'.$channel;
		$channel_class_path = APPPATH.'libraries/channel/'.$channel.'/'.$channel_class.'.php';
		if(file_exists($channel_class_path)) {
			include_once $channel_class_path;
			if(class_exists($channel_class)){
				$data = array();
				$info = $this->get_channelinfo($channel); //获取渠道的设置信息
				
				$channel_instance = new $channel_class($info);
				$cats = $channel_instance->get_cats_list($parent_id); //执行搜索并返回商品列表
				return $cats;
				
			}else{
				show_error('Class not Found:'.$channel_class);
			}
		}else{
			show_error('File Not Found:'.$channel_class_path);
		}
	}



}
