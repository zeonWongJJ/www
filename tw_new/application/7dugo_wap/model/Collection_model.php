<?php
class Collection_model extends TW_Model {
	public function __construct() {
        parent :: __construct();
    }
	
	//查询收藏主页面
	public function collection() {
		$a_where = ['member_id' => $_SESSION['user_id'] ];
		$s_field = 'goods_name, fav_id, goods_state, goods_image, goods_price, store_id'; 
		$a_order = ['fav_time' => 'desc'];
		$a_data  = $this->db->from('favorites')
							->join('goods',['tw_favorites.fav_id' => 'tw_goods.goods_id'])
						 	->get('', $a_where, $s_field);
						 	// print_r(array_column($a_data, "fav_id"));
		return $a_data;
	}

	//取消关注
	public function del($s_pid){
		$a_where = ['member_id' => $_SESSION['user_id'], 'fav_id' => $s_pid];
		$this->db->delete('favorites', $a_where);
		header('location:' . $this->router->url('collection') );
	}

	//加入购物车
	public function cart($s_ptt){
		$a_goods = $this->db->get('goods', ['goods_id' => $s_ptt, 'goods_state' => 1]);
		if (empty($a_goods)) {			
			$this->error->show_error('加入购物车失败！物品已下架！');
		} else {
			$a_nuan = $this->db->get('cart', ['buyer_id' => $_SESSION['user_id'], 'goods_id' => $s_ptt]);
			if (empty($a_nuan)) {
				$a_insert = [
					'buyer_id' => $_SESSION['user_id'],
					'store_id' => $a_goods[0]['store_id'],
					'store_name' => $a_goods[0]['store_name'],
					'goods_id' => $a_goods[0]['goods_id'],
					'goods_name' => $a_goods[0]['goods_name'],
					'goods_price' => $a_goods[0]['goods_price'],
					'goods_num' => 1,
					'goods_image' => $a_goods[0]['goods_image']
				];
				$a_cart = $this->db->insert('cart', $a_insert);
			} else {
				$count = $a_nuan[0]['goods_num'];
				$i = 1;
				$count += $i;
				$a_cart = $this->db->update('cart', ['goods_num' => $count], ['buyer_id' => $_SESSION['user_id'], 'goods_id' => $s_ptt]);
			}			
				$this->error->show_success('加入购物车成功！');
		}
	}

	//插入新的关注数据（先进行删除，然后再次插入）
	public function insert($a_coll){
		//删除这个人之前选的收藏
		$a_where = ['member_id' => $_SESSION['user_id']];
		$this->db->delete('favorites', $a_where);
		//插入这个人收藏的ID
		foreach ($a_coll as $value) {
			if($value != ''){
				$a_upwhere = ['member_id' => $_SESSION['user_id'], 'fav_id' => $value, 'fav_time' => $_SERVER['REQUEST_TIME']];
				$this->db->insert('favorites', $a_upwhere);
			}
		}
		return 'collection';
	}

	//搜索收藏的数据
	public function search($s_collection){
		$a_where = ['member_id' => $_SESSION['user_id'], 'goods_name LIKE' => "%{$s_collection}%"];
		$s_field = 'goods_name,fav_id,goods_image,goods_price,store_id'; 
		$a_order = ['fav_time' => 'desc'];
		$a_data  =	$this->db 	->from('favorites')
							 	->join('goods', ['tw_favorites.fav_id' => 'tw_goods.goods_id'])
						 	 	->get('', $a_where, $s_field);
 		return $a_data;
	}
}
?>