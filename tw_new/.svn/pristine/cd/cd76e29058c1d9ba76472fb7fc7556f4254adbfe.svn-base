<?php

class Shop_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

	//重新购买
	public function repurchase($repurchase){
	 	$a_goods_id = $this->db->get('order_goods', ['user_id' => $_SESSION['user_id'], 'order_id' => $repurchase]);
        foreach ($a_goods_id as $key => $value) {
            $product_id[]  = $value['product_id'];
        }
        $s_product_id = implode(",",$product_id);
        $this->db->where_in('product_id', $product_id)->delete('cart');
        foreach ($a_goods_id as $goods) {
            $a_data = [
                'user_id'      => $_SESSION['user_id'],
                'store_id'     => $goods['store_id'],
                'product_id'   => $goods['product_id'],
                'product_name' => $goods['product_name'],
                'shux_name'    => $goods['spec'],
                'spec'         => $goods['cup_id'],
                'money'        => $goods['money'],
                'prot_count'   => $goods['goods_num'],
                'pro_img'      => $goods['pro_img'],
            ];
           $goods_id[] = $this->db->insert('cart', $a_data);
        }
        // $i_cart = implode(",",$goods_id);
		return $goods_id;
	}
}

?>