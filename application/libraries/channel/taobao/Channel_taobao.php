<?php if (!defined('BASEPATH')) exit('No direct access allowed.');

include_once APPPATH.'libraries/channel/taobao/sdk/TopClient.php';

class Channel_taobao
{
	private $channel='taobao';
	protected $info;
	protected $client;
	protected $item_get_request;

	function __construct($info)
	{
		$this->info = $info;
		$this->client = new TopClient();
		$this->client->appkey = $this->info['APPKEY'];
		$this->client->secretKey = $this->info['APPSECRET'];
	}



	/**
	 * fetch_goodinfo function.
	 * http://api.taobao.com/apidoc/api.htm?path=cid:4-apiId:20
	 * 获取淘宝单个商品的详细信息
	 * @access public
	 * @param mixed $item_id
	 * @return array
	 */
	public function fetch_goodinfo($item_id){

		include_once APPPATH.'libraries/channel/taobao/sdk/request/ItemGetRequest.php';
		include_once APPPATH.'libraries/channel/taobao/sdk/request/ShopGetRequest.php';

		$req = new ItemGetRequest();
		$req->setFields("detail_url,title,nick,pic_url,price,shop_name,item_img.url");
		//$req->setFields("title,detail_url,nick,item_img.url,pic_url");
		$req->setNumIid($item_id);
		$item_resp = $this->client->execute($req);
		if(!isset($item_resp->item))
		return false;
		
		$item = (array)$item_resp->item;
		
		$item['item_imgs'] = (array) $item['item_imgs'];
		$item['item_imgs']['item_img'] = (array) $item['item_imgs']['item_img'];
		$images = array();
		if (count($item['item_imgs']['item_img']) > 0){
			foreach ($item['item_imgs']['item_img'] as $key => $xml_item){
				$array_item = (array)$xml_item;
				if ($array_item['url']) {
					$images[] = $array_item['url'];
				}
			}
		}
		
		$result = array();
		//$result['id'] = $key;
		
		$result['name'] = $item['title'];
		$result['price'] = $item['price'];
		$result['orgin_img_url_small'] = $item['pic_url'].'_200x200.jpg';
		$result['orgin_img_url'] = $item['pic_url'];
		$result['orgin_url'] = $item['detail_url'];
		$result['shop_name'] = $item['nick'];
		$result['item_imgs'] = $images;//多图
		
		unset($item);
		return $result;
	}


	/**
	 * get_items_list function.
	 * 通过淘宝API,搜索推广商品，返回商品列表
	 * http://api.taobao.com/apidoc/api.htm?path=cid:38-apiId:114
	 * @access public
	 * @param mixed $keyword   商品搜索关键词
	 * @param mixed $category_id  商品分类ID
	 * @param mixed $page  返回结果的页数
	 * @return object
	 */
	public function get_items_list($keyword,$category_id,$page){

		include_once APPPATH.'libraries/channel/taobao/sdk/request/TaobaokeItemsGetRequest.php';

		if($this->info['PROMOTION_ID'])
		{

			$this->client->format = 'json';
			$req = new TaobaokeItemsGetRequest();
						
			//设置要返回的字段
			$req->setFields("num_iid,title,nick,pic_url,price,click_url,commission,commission_rate,commission_volume,commission_num");
			//设置推广PID
			$req->setPid($this->info['PROMOTION_ID']);
			//设置搜索关键词
			$req->setKeyword($keyword);
			//设置商品分类ID
			if($category_id != 0) $req->setCid($category_id);
			//设置一次返回数据的数量
			$req->setPageSize(15);
			//设置返回结果的页数
			$req->setPageNo($page);
			
			$items_resp = $this->client->execute($req);
			
			$items = $items_resp->taobaoke_items;
			$items->total_results = $items_resp->total_results;
			
			return $items;
		}
		
	}


	/**
	 * get_cats_list function.
	 * http://api.taobao.com/apidoc/api.htm?path=categoryId:3-apiId:122
	 * 获取淘宝商品类目
	 * @access public
	 * @param mixed $parent_id   父商品类目 id，0表示根节点, 传输该参数返回所有子类目。 
	 * @return object
	 */
	public function get_cats_list($parent_id){

		include_once APPPATH.'libraries/channel/taobao/sdk/request/ItemcatsGetRequest.php';

		$this->client->format = 'json';

		$req = new ItemcatsGetRequest();
		$req->setFields("cid,parent_cid,name,is_parent");
		$req->setParentCid($parent_id);
		
		$cats_resp = $this->client->execute($req);
		
		$cats = $cats_resp->item_cats;
		$cats->total_results = $cats_resp->item_cats;
		
		return $cats;
		
	}




	/**
	 * get_promotion_url function.
	 * http://api.taobao.com/apidoc/api.htm?path=cid:38-apiId:339
	 * 获取淘宝某商品的推广链接
	 * @access public
	 * @param mixed $item_id   淘宝商品原始ID
	 * @return array
	 */
	public function get_promotion_url($item_id){
	
		include_once APPPATH.'libraries/channel/taobao/sdk/request/TaobaokeItemsDetailGetRequest.php';

		if($this->info['PROMOTION_ID'])
		{
			$req = new TaobaokeItemsDetailGetRequest();
			$req->setFields("click_url,shop_click_url");
			$req->setNumIids($item_id);
			$req->setPid($this->info['PROMOTION_ID']);
			$resp = $this->client->execute($req);

			if(isset($resp->taobaoke_item_details))
			{
				$promotion = (array)$resp->taobaoke_item_details->taobaoke_item_detail;
				return $promotion;
			}
		}
	}

	public function get_item_id($url)
	{
		$url_parse = parse_url($url);
		
		if(isset($url_parse['query']))
		{
			parse_str($url_parse['query'],$params);
			if(isset($params['id']))
			$item_id = $params['id'];
			elseif(isset($params['item_id']))
			$item_id = $params['item_id'];
		}
		return $item_id;
	}
}
