<?php
/**
 * 用户模块
 */
class Cart_model extends TW_Model{
	public function __construct(){
        parent :: __construct();
    }

    //推荐商品取10条
    public function commend(){
    	$a_data = $this->db->get('goods',['goods_commend' => 1], 'goods_id,goods_name,goods_price,goods_promotion_price,goods_promotion_type,goods_image,store_id',[
	'goods_time_create' => 'desc'] , 0, 10);
    	return $a_data;
    }
	

	//查询购物车页面输出的数据
	public function cart(){
		// 查询显示数据
		$s_field = "cart_id ,tw_cart.store_id,tw_cart.store_name,tw_cart.goods_id,tw_cart.goods_name,tw_cart.goods_price,tw_cart.goods_image,bl_id,tw_goods.keywords,goods_num,goods_freight,have_gift,is_own_shop,goods_promotion_type,goods_promotion_price,goods_state";
		$a_where = ['buyer_id' => $_SESSION['user_id'],'goods_verify' => 1];
		$a_data  = $this->db->from('cart')
							->join('goods',[$this->db->get_prefix() . 'cart.goods_id' => $this->db->get_prefix() . 'goods.goods_id'])
						 	->get('', $a_where, $s_field);
		$a_res = [];
		// 处理数据将每个店铺的数据进行分类
		// 判断语句用于查询如果有赠品的话查询赠品的数据出来
		foreach ($a_data as $key => $value) {
			if($value['have_gift'] == 1){
				$value['gift'] = $this->db->get_row('goods_gift', ['goods_id' => $value['goods_id']], 'gift_goodsid,gift_goodsname,gift_amount');
			}
			$a_res[$value['store_id']][] = $value;
		}
		return $a_res;	
	}

	//重新购买
	public function repurchase($repurchase){
		$a_goods_id = $this->db->get('order_goods', ['buyer_id' => $_SESSION['user_id'], 'order_id' => $repurchase], 'goods_id,goods_num');
		foreach ($a_goods_id as $key => $value) {
			$goods_id[] 	= $value['goods_id'];
			$goods_num[] 	= $value['goods_num'];
		}
		$s_goods_id = implode(",",$goods_id);
		$this->db->where_in('goods_id', $goods_id)->delete('cart');
		$a_goods = $this->db->where_in('goods_id',$goods_id)->get('goods','','store_id,store_name,goods_id,goods_name,goods_price,goods_image');
		foreach ($a_goods as $key => $value) {
			$a_data = ['buyer_id' 	=> 	$_SESSION['user_id'],
					   'store_id'	=>	$value['store_id'],
					   'store_name'	=>	$value['store_name'],
					   'goods_id'	=>	$value['goods_id'],
					   'goods_name'	=>	$value['goods_name'],
					   'goods_price'=>	$value['goods_price'],
					   'goods_num'	=> 	$goods_num[$key],
					   'goods_image'=>	$value['goods_image']];
			$this->db->insert('cart',$a_data);
		}
		return $s_goods_id;
	}

	//删除购物车某个商品
	public function del($del){
		$a_del = explode(',', $del);
		$this->db->where_in('goods_id', $a_del)->delete('cart', ['buyer_id' => $_SESSION['user_id']]);
	}

	// 买家收藏
	public function fav(){
		$fav = explode(',', $fav);
		foreach ($fav as $key => $value) {
			$this->db->insert('favorites', ['buyer_id ' => $_SESSION['user_id'], 'fav_id ' => $value]);
		}
	}


}

?>
