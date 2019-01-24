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
		if ( ! empty($POST)) {
			$a = $this->general->post();
		} else  {
			$a = $_SESSION['post'];
		}
		foreach ($a['num'] as $key => $value) {
			//购物车的ID
			$a_goods[] .= $key;
			$a_num[]   .= $value;

		}
		//查询出购物车的信息
		$a_goods = $this->db->where_in('cart_id', $a_goods)->get('cart');
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
			$a_mout = $this->db->get_row('price', ['product_id' => $value['product_id'], 'cup_id' => $value['spec']]);
			$i_goods_amount += 1;
			$price[$value['store_id']] = $price[$value['store_id']] + $a_num[$key] * $a_mout['price'];			
			$sum += $a_num[$key] * $value['money'];

		}

		//多少件商品
		$a_res['goods_amount'] = $i_goods_amount;

		//总运费
		$freight = $this->db->get('set');
		$a_res['freight'] = $freight[7]['set_parameter'];

		//可以使用的积分
		$a_res['deductible_point'] = $freight[5]['set_parameter'];

		// 将数据组装成页面需要输出的格式$a_cart = 
		foreach ($a_goods as $key => $value) {
			if ($value['goods_stye'] == 1) {
				$a_mout = $this->db->get_row('price', ['product_id' => $value['product_id'], 'cup_id' => $value['spec']]);
			} else {
				$a_mout = $this->db->get_row('price', ['product_id' => $value['product_id']]);
			}
			$this->db->update('cart', ['money' => $a_mout['price']], ['cart_id' => $value['cart_id']]);
			$a_res['data'][$value['store_id']]['money'][]    = $a_mout['price'];
			$a_res['data'][$value['store_id']]['goods'][] 	= $value;
			$a_res['data'][$value['store_id']]['num'][] 	= $a_num[$key];
			$a_res['data'][$value['store_id']]['store']	 	= $price[$value['store_id']];
			$a_res['data'][$value['store_id']]['store_id']	= $value['store_id'];
			$a_res['data'][$value['store_id']]['store_name'] = $value['store_name'];
			$a_res['data'][$value['store_id']]['freight'] = $a_res['freight'];
		}
		return $a_res;
	}

	//获取立即购买的信息
	public function buy_now() {
		if ( ! empty($_POST)) {
			$i_store = $this->general->post('stuo_id');
			$i_name = $this->general->post('stuo_name');
			$a_shux = $this->general->post('shux');
			$i_pric = $this->general->post('pric');
			$i_goods = $this->general->post('goods');
			$a_gname = $this->general->post('gname');
			$i_num  = $this->general->post('num');
			$i_imge = $this->general->post('imge');
			$money  = $this->general->post('money');
		} else {
			$i_store = $_SESSION['post']['stuo_id'];
			$i_name  = $_SESSION['post']['stuo_name'];
			$a_shux  = $_SESSION['post']['shux'];
			$i_pric  = $_SESSION['post']['pric'];
			$i_goods = $_SESSION['post']['goods'];
			$a_gname = $_SESSION['post']['gname'];
			$i_num   = $_SESSION['post']['num'];
			$i_imge  = $_SESSION['post']['imge'];
			$money   = $_SESSION['post']['money'];
		}
		
		//总运费
		$freight = $this->db->get('set');
		$a_res['freight'] = $freight[7]['set_parameter'];
		// 产品价格
		$a_mout = $this->db->get_row('price', ['product_id' => $i_goods, 'cup_id' => $i_pric]);
		$a_res['data'][$i_store]['money'][]  = $a_mout['price'];
		$a_res['data'][$i_store]['goods'][]  = array('user_id' => $_SESSION['user_id'], 'product_name' => $a_gname, 'product_id' => $i_goods, 'shux_name' => $a_shux, 'pro_img' => $i_imge, 'prot_count' => $i_num, 'money' => $money);
		$a_res['data'][$i_store]['num'][] 	 = $i_num;
		$a_res['data'][$i_store]['store_id'] = $i_store;
		$a_res['data'][$i_store]['store_name'] = $i_name;
		$a_res['data'][$i_store]['freight'] = $a_res['freight'];
		return $a_res;
	}

	//获取一个门店产品购买的信息
	public function buy_tost() {
		if ( ! empty($_POST)) {
			$i_store = $this->general->post('store');			
		} else {
			$i_store = $_SESSION['post']['store'];
		}
		//查询出购物车的信息
		if ($i_store == -1) {
			$a_goods = $this->db->get('cart', ['user_id' => $_SESSION['user_id'], 'store_id' => 0]);
		} else {
			$a_goods = $this->db->get('cart', ['user_id' => $_SESSION['user_id'], 'store_id' => $i_store]);
		}
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
			if ($value['goods_stye'] == 1) {
				$a_mout = $this->db->get_row('price', ['product_id' => $value['product_id'], 'cup_id' => $value['spec']]);
			} else {
				$a_mout = $this->db->get_row('price', ['product_id' => $value['product_id']]);
			}
			$i_goods_amount += 1;
			$price[$value['store_id']] = $price[$value['store_id']] + $value['prot_count'] * $a_mout['price'];			
			$sum += $value['prot_count'] * $value['money'];

		}

		//多少件商品
		$a_res['goods_amount'] = $i_goods_amount;

		//总运费
		$freight = $this->db->get('set');
		$a_res['freight'] = $freight[7]['set_parameter'];

		//可以使用的积分
		$a_res['deductible_point'] = $freight[5]['set_parameter'];

		// 将数据组装成页面需要输出的格式$a_cart = 
		foreach ($a_goods as $key => $value) {
			$a_mout = $this->db->get_row('price', ['product_id' => $value['product_id'], 'cup_id' => $value['spec']]);
			$this->db->update('cart', ['money' => $a_mout['price']], ['cart_id' => $value['cart_id']]);
			$a_res['data'][$value['store_id']]['goods'][]    = $value;
			$a_res['data'][$value['store_id']]['money'][]    = $a_mout['price'];
			$a_res['data'][$value['store_id']]['num'][] 	 = $value['prot_count'];
			$a_res['data'][$value['store_id']]['store']	 	 = $price[$value['store_id']];
			$a_res['data'][$value['store_id']]['store_id']	 = $value['store_id'];
			$a_res['data'][$value['store_id']]['store_name'] = $value['store_name'];
			$a_res['data'][$value['store_id']]['freight']    = $a_res['freight'];
		}
		return $a_res;
	}


	// 获取预约的座位信息
	public function get_user_seat($user_id, $store_arr) {
		$a_where = [
			'user_id'           => $user_id,
			'appointment_type'  => 2,
			'appointment_state >' => 1,
			'appointment_state <' => 4
		];
		$s_field = 'appointment_id,store_id,office_seatname,appointment_price';
		$a_order = [
			'appointment_id' => 'desc'
		];
		$a_data = $this->db->where_in('store_id', $store_arr)
						   ->get('appointment', $a_where, $s_field, $a_order, 0, 99999999);
		return $a_data;
	}


	public function get_store_info($store_arr) {
		$s_field = 'store_id, store_name';
		$a_order = [
			'store_id' => 'desc'
		];
		$a_data = $this->db->where_in('store_id', $store_arr)
						   ->get('store', [], $s_field, $a_order, 0, 999999999);
		return $a_data;
	}



	public function get_cart_one($cart_id) {
		$a_where = [
			'cart_id' => $cart_id
		];
		$a_data = $this->db->get_row('cart', $a_where);
		return $a_data;
	}


	public function get_price_one($product_id, $cup_id) {
		if ($cup_id == 'share') {
			$a_where = [
				'product_id' => $product_id,
			];
		} else {
			$a_where = [
				'product_id' => $product_id,
				'cup_id'     => $cup_id,
			];
		}
		$a_data = $this->db->get_row('price', $a_where);
		return $a_data;
	}


	public function get_qualifi_one($product_id) {
		$a_where = [
			'product_id' => $product_id
		];
		$a_data = $this->db->get_row('qualifi_goods', $a_where);
		return $a_data;
	}

	public function get_set_one($set_name) {
		$a_where = [
			'set_name' => $set_name
		];
		$a_data = $this->db->get_row('set', $a_where);
		return $a_data['set_parameter'];
	}

	public function get_cart_part($cart_arr, $store_id) {
		$a_where = [
			'store_id' => $store_id
		];
		$s_field = '';
		$a_order = [
			'cart_id' => 'desc'
		];
		$a_data = $this->db->where_in('cart_id', $cart_arr)
					   ->get('cart', $a_where, $s_field, $a_order, 0, 999999999);
		return $a_data;
	}


	public function get_cart_share($cart_arr) {
		$a_where = [];
		$s_field = '';
		$a_order = [
			'cart_id' => 'desc'
		];
		$a_data = $this->db->where_in('cart_id', $cart_arr)
						   ->get('cart', $a_where, $s_field, $a_order, 0, 999999999);
		return $a_data;
	}


	public function get_user_one($user_id) {
		$a_where = [
			'user_id' => $user_id
		];
		$a_data = $this->db->get_row('user', $a_where);
		return $a_data;
	}


	public function get_address_default($user_id) {
		$a_where = [
			'user_id'    => $user_id,
			'is_default' => 1,
		];
		$a_data = $this->db->get_row('address', $a_where);
		return $a_data;
	}

	public function get_cart_ustore($store_id, $user_id) {
		$a_where = [
			'store_id' => $store_id,
			'user_id'  => $user_id,
		];
		$s_field = '';
		$a_order = [
			'cart_id' => 'desc'
		];
		$a_data = $this->db->get('cart', $a_where, $s_field, $a_order, 0, 999999999);
		return $a_data;
	}

	public function get_product_one($product_id) {
		$a_where = [
			'product_id' => $product_id
		];
		$a_data = $this->db->get_row('product', $a_where);
		return $a_data;
	}

	public function get_store_one($store_id) {
		$a_where = [
			'store_id' => $store_id
		];
		$a_data = $this->db->get_row('store', $a_where);
		return $a_data;
	}


}

?>
