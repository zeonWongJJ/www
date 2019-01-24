<?php
/**
 * 用户模块
 */
class Search_model extends TW_Model{
	public function __construct(){
        parent :: __construct();
    }
	
	public function search($s_cate_sec = false){

		$s_url = $this->router->get_url();

		$i_url = substr_count($s_url, '-');

		if($i_url !== 13 && $i_url !== 14){
			$this->error->show_error('输入参数有误请重新数据',$this->router->url('search',['','','','','','','','','','','','','']));
		}

		// 关键字搜索
		$s_keyword = $this->router->get(1);
		//判断是否被编码
		$s_keyword = urldecode(str_replace('+', '-', $s_keyword));
		$a_data['keyword'] = $s_keyword;

		//排序
		$s_order = $this->router->get(3);
		$a_data['order'] = $s_order;

		//获取价格的最小值
		$s_price_min = $this->router->get(4);
		$s_price_min = intval($s_price_min);
		$a_data['price_min'] = $s_price_min;

		//获取价格的最大值
		$s_price_max = $this->router->get(5);
		$s_price_max = intval($s_price_max);
		$a_data['price_max'] = $s_price_max;

		//是否自营
		$s_autotrophy = $this->router->get(6);
		$a_data['autotrophy'] = $s_autotrophy;

		//是否赠品
		$s_gift = $this->router->get(7);
		$a_data['gift'] = $s_gift;

		//是否促销
		$s_promotion = $this->router->get(8);
		$a_data['promotion'] = $s_promotion;

		//是否有积分
		$s_integral = $this->router->get(9);
		$a_data['integral'] = $s_integral;

		//获取第三级级导航
		$s_cate_third = $this->router->get(10);
		$a_data['third'] = $s_cate_third;

		//获取品牌的条件
		$s_cate_brand = $this->router->get(11);
		$a_data['brand'] = $s_cate_brand;

		//获取类型的条件
		$s_cate_type = $this->router->get(12);
		$a_data['type'] = $s_cate_type;

		//获取店铺的条件
		$s_store = $this->router->get(13);
		$a_data['store'] = $s_store;

		$a_where = [];

		// 实例化搜索类
		$this->load->library('search');
		$this->search->project('7dugo');
		$this->search->set_charset('UTF-8');

		
		// 必须在获取匹配总数之前，把所有的条件设置好，如果在获取总数后，再改变查询条件，会影响匹配的总数
		$this->search->query($a_data['keyword']);
		
		// 组合条件，此语句必须在query函数之后
		if (! empty($s_autotrophy)){
			$this->search->range('is_own_shop', 1, 1);
		} else {
			$a_data['autotrophy'] = 0;
		}

		if (! empty($s_store)){
			$this->search->range('store_id', $s_store, $s_store);
		}

		if (! empty($s_gift)){
			$this->search->range('have_gift', 1, 1);
		} else {
			$a_data['gift'] = 0;
		}

		if (! empty($s_promotion)){
			$this->search->range('goods_promotion_type', 1, 2);
		} else {
			$a_data['promotion'] = 0;
		}

		if (! empty($s_integral)){
			
			$this->search->range('goods_feng', 1, 9999);
		} else {
			$a_data['integral'] = 0;
		}

		if (! empty($s_price_min)){
			$s_price_max ? $this->search->range('goods_price', $s_price_min,$s_price_max):$this->search->range('goods_price', $s_price_min, 999999);
		} else {
			$a_data['price_min'] = 0;
		}

		if (! empty($s_price_max)){
			$s_price_min ? $this->search->range('goods_price', $s_price_min,$s_price_max):$this->search->range('goods_price', 0, $s_price_max);
		} else {
			$a_data['price_max'] = 0;
		}

		if (! empty($s_cate_sec)){
			$this->search->range('gc_id_2', $s_cate_sec, $s_cate_sec);
		} 

		if (! empty($s_cate_third)){
			$this->search->range('gc_id_3', $s_cate_third, $s_cate_third);
		} else {
			$a_data['third'] = 0;
		}

		if (! empty($s_cate_type)){
			$this->search->range('type_id', $s_cate_type, $s_cate_type);
		} else {
			$a_data['type'] = 0;
		}

		if (! empty($s_cate_brand)){
			$this->search->range('brand_id', $s_cate_brand, $s_cate_brand);
		} else {
			$a_data['brand'] = 0;
		}
		


		// 第一步，先获取搜索匹配的数据总数
		$i_total = $this->search->count();

		// 第二步，开始用分页类计数出每页的数据偏移量
		//获取参数
		$i_page = $this->router->get(14);
		empty($i_page) ? $i_page = 1 : $i_page;
		//实例化分页类
		$this->load->library('pages');
		//调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, 30);
		
		//排序
		if ( $s_order == '1'){
			$this->search->sort('goods_id', false);
		} else if ($s_order == '2'){
			$this->search->sort('goods_id');
		} else if ($s_order == '3'){
			$this->search->sort('goods_addtime', false);
		} else if ($s_order == '4'){
			$this->search->sort('goods_addtime');
		} else if ($s_order == '5'){
			$this->search->sort('goods_salenum', false);
		} else if ($s_order == '6'){
			$this->search->sort('goods_salenum');
		} else if ($s_order == '7'){
			$this->search->sort('goods_click',false);
		} else if ($s_order == '8'){
			$this->search->sort('goods_click');
		} else if ($s_order == '9'){
			$this->search->sort('goods_price', false);
		} else if ($s_order == '10'){
			$this->search->sort('goods_price');
		} else {
			$this->search->sort('goods_id', false);
			$a_data['order'] = 1;
		}
		/**
		 * 第三步，使用分页类获取到的偏移量，来设置获取数据
		 * 这里必须传入和上面一样的查询关键词，否则会因为前后查询条件不一样，影响分页数据
		 * 或者用另一种语句形式：$this->search->limit(30, $a_pdata['start'])->get();
		 */
		$a_data['res'] = $this->search->limit(30, $a_pdata['start'])->get();
		// var_dump($a_data['res']);
		$a_data['page'] = $this->pages->link_style_one(get_config_item('domain') . '/search-' . 
						$a_data['keyword'] . '-' . 
						$s_cate_sec . '-' . 
						$a_data['order'] . '-' . 
						$a_data['price_min'] . '-' . 
						$a_data['price_max'] . '-' . 
						$a_data['autotrophy'] . '-' . 
						$a_data['gift'] . '-' . 
						$a_data['promotion'] . '-' . 
						$a_data['integral'] . '-' . 
						$a_data['third'] . '-' . 
						$a_data['brand'] . '-' . 
						$a_data['type'] . '-' .
						$a_data['store'] . '-');
		return $a_data;
	}

	// 处理浏览历史
	public function displayHistory(){
		//获取地址栏中的ID
		$s_goods_id = $this->general->get('goods_id');

		//判断是否登录,登录信息插入数据库，不登录将信息存在COOKIE中
		if ( ! empty($_SESSION['id'])){
			//获取当前时间
			$s_browsetime = $_SERVER['REQUEST_TIME'];

			//判断是否有获取到商品ID
			if ( ! empty($s_goods_id)){
				//条件
				$a_where	  = ['goods_id' => $s_goods_id,'member_id' => $_SESSION['id'], 'browsetime' => $s_browsetime];

				//插入数据
				$this->db->insert('goods_browse', $a_where);
			}
			
			//查询会员浏览过的ID
			$a_field = "goods_id";
			$a_data = $this->db->get('goods_browse', ['member_id' => $_SESSION['id']], $a_field);

			//组合出商品的格式
			foreach ($a_data as $key => $value) {
				$a_res[$key] = $value['goods_id'];
			}

			//获取会员浏览过的商品
			$a_good = "gc_id,goods_image,goods_name";
			$a_data = $this	->db
							->where_in('goods_id', $a_res)
							->get('goods', '', $a_good);

			echo json_encode($a_data);
		} else {
			//判断是否有商品传过来
			if ( ! empty($s_goods_id) ){
				// 先从COOKIE中取出浏览历史的ID数组
				$data = isset($_COOKIE['display_history']) ? unserialize($_COOKIE['display_history']) : array();
				
				// 把最新浏览的这件商品放到数组中的第一个位置上
				array_unshift($data, $s_goods_id);
				
				// 去重
				$data =	array_unique($data);
				
				// 只取数组中前6个
				if (count($data) > 6)
					$data = array_slice($data, 0, 6);
				
				// 数组存回COOKIE
				setcookie('display_history', serialize($data), time() + 30 * 86400, '/');
				
				// 再根据商品的ID取出商品的详细信息
				$a_field = "gc_id,goods_image,goods_name";
				$a_data = $this	->db
								->where_in('goods_id', $data)
								->get('goods', '', $a_field);
				echo json_encode($a_data);
			}
			
		}
	}

	//搜索页面中导航栏的分类
	public function category( $s_second = false ){
		//如果第二个参数没有值，默认将二级分类选择第一个值
		if($s_second == false){
			$a_cate = $this->db->get_row('goods_class', ['gc_parent_id' => 0], 'gc_id');
			$a_cate_id = $this->db->get_row('goods_class', ['gc_parent_id' => $a_cate['gc_id']], 'gc_id,gc_name');
			$s_second = $a_cate_id['gc_id'];
		}

		//本来判断第一级分类然后获取写死第二级分类
		$a_data['second'] = $this->db->get('goods_class', ['gc_parent_id' => 1210], 'gc_parent_id,gc_name,gc_id');

		//第三级分类
		$a_data['third'] = $this->db->get('goods_class', ['gc_parent_id' => $s_second], 'gc_parent_id,gc_name,gc_id,type_name,type_id');

		if (! empty($a_data['third'])){
			//类型
			foreach ($a_data['third'] as $key => $value) {
				$a_data['type_id'][$key] = $value['type_id'];
				$a_data['type_name'][$key] = $value['type_name'];
				$a_data['type_id'] = array_unique($a_data['type_id']);
				$a_data['type_name'] = array_unique($a_data['type_name']);
				$a_brand_where[$key] = $value['gc_id'];
			}

			// 类型
			// $a_data['type'] = $this ->db
			// 						->where_in('class_id', $a_data['type_id'])
			// 						->get('type', [], 'type_name,type_id');

			//品牌
			$a_data['brand'] = $this->db
									->where_in('class_id', $a_brand_where)
									->get('brand', [], 'brand_name,brand_id');
		}
		return $a_data;
	}

	// 列表页面加入购物车
	public function goodshop($s_goodshop, $s_goodsnum){

		$a_res = $this->db->get_row('cart', ['buyer_id' => $_SESSION['user_id'], 'goods_id' => $s_goodshop], 'goods_num');
		//查询购物车表中是否已经存在了改商品，如果存在更新跟购物车该字段的数量,如果不存在查询出商品插入到购物车中
		if($a_res == false){
			$i_goodsnum = $s_goodsnum;
			$a_data = $this->db->get_row('goods', ['goods_id' => $s_goodshop], 'goods_id,goods_name,store_id,store_name,goods_price,goods_image');
			$a_where = ['goods_id' => $a_data['goods_id'], 
						'goods_name' => $a_data['goods_name'],
						'store_id' => $a_data['store_id'],
						'store_name' => $a_data['store_name'],
						'goods_price' => $a_data['goods_price'],
						'goods_image' => $a_data['goods_image'],
						'buyer_id' => $_SESSION['user_id'],
						'goods_num' => $i_goodsnum];
			$s_data = $this->db->insert('cart',$a_where);
		} else {
			$i_goodsnum = $a_res['goods_num'] + $s_goodsnum;
			$s_data = $this->db->update('cart', ['goods_num' => $i_goodsnum], ['buyer_id' => $_SESSION['user_id'], 'goods_id' => $s_goodshop]);
		}
		
		if($s_data != false){
			return 1;
		} else {
			return 0;
		}
	}

	//列表页面加入收藏
	public function cellgood($s_cellgood){
		$this->db->delete('favorites', ['member_id' => $_SESSION['user_id'], 'fav_id' => $s_cellgood]);

		$s_data = $this->db->insert('favorites', ['member_id' => $_SESSION['user_id'], 'fav_id' => $s_cellgood, 'fav_type' => 'goods', 'fav_time' => $_SERVER['REQUEST_TIME']]);
		$s_res  = $this->db->get_count();
		if($s_res != false){
			return 1;
		} else {
			return 0;
		}
	}
}
?>