<?php
/**
 * 用户模块
 */
class Bill_model extends TW_Model{
	public function __construct(){
        parent :: __construct();
    }

	//将POST提交过来的数据插入数据,接受购物车传过来的商品,接受购物车传过来的数量
	public function bill(){
		$a = $this->general->post();
		foreach ($a['num'] as $key => $value) {
			$a_goods[] .= $key;
			$a_num[] .= $value;

		}
		//查询出商品的信息
		$s_field = 'store_id,store_name,goods_id,goods_name,goods_price,goods_image,keywords,have_gift,is_own_shop,goods_freight,goods_promotion_type,goods_promotion_price,deductible_point';
		$a_goods = $this->db->where_in('goods_id', $a_goods)->get('goods', '', $s_field);

		
		$a_str=array();
		$i_goods_amount = 0;
		/*
		* 计算出总价格优惠价格店铺额价格
		* $sum 		  市场价总价格
		* $promotion  优惠价总价格
		* $price  	  店铺总价格
		* $freight    总运费
		*/
		foreach($a_goods as $key => $value){
			$i_goods_amount += 1;
			$s_points += $value['deductible_point'];
			if($value['goods_promotion_type'] == 0 ){
				$price[$value['store_id']] = $price[$value['store_id']] + $a_num[$key] * $value['goods_price'];
				$promotion += $a_num[$key] * $value['goods_price'] ;
				if( ! in_array($value['store_id'],$a_str)){
					array_push($a_str,$value['store_id']);
					$freight += $value['goods_freight'];
				}
			} else {
				$price[$value['store_id']] = $price[$value['store_id']] + $a_num[$key] * $value['goods_promotion_price'];
				$promotion += $a_num[$key] * $value['goods_promotion_price'];
				if( !in_array($value['store_id'],$a_str)){
					array_push($a_str,$value['store_id']);
					$freight += $value['goods_freight'];
				}
			}
			$sum += $a_num[$key] * $value['goods_price'];
		}

		//多少件商品
		$a_res['goods_amount'] = $i_goods_amount;

		//总运费
		$a_res['freight'] = $freight;

		//优惠差价
		$a_res['privilege'] = $sum - $promotion;

		//总价格未加上运费
		$a_res['pricesum'] = $promotion;

		//总价格加上运费
		$a_res['pricesumfre'] = $promotion + $freight;

		//可以使用的积分
		$a_res['deductible_point'] = $s_points;

		// 将数据组装成页面需要输出的格式
		foreach ($a_goods as $key => $value) {
			if($value['have_gift'] == 1){
				$value['gift'] = $this->db->get_row('goods_gift', ['goods_id' => $value['goods_id']], 'gift_goodsid,gift_goodsname,gift_amount');
			}
			$a_res['data'][$value['store_id']]['goods'][] 	= $value;
			$a_res['data'][$value['store_id']]['num'][] 	= $a_num[$key];
			$a_res['data'][$value['store_id']]['store']	 	= $price[$value['store_id']];
			$a_res['data'][$value['store_id']]['store_id']	= $value['store_id'];
		}
		return $a_res;
	}

}

?>
