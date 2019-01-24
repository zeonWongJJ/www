<?php

class Product_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}
	
	// 获取产品的基本信息（结果：一个产品只出现一次，多个类型不同价格，默认出现的价格为最低价格）
	public function display($i_cate_id, $b_is_total = false, $i_start = 0, $i_last = 0) {
		// $s_prefix = $this->db->get_prefix();
		$where_product = ['proid_id_1' => $i_cate_id, 'pro_show' => '1', 'prod_show' => 1, 'store_id' => $_SESSION['store_id']];
        $a_slse = "b.supply_time,b.product_name,b.pro_details,b.pro_img,a.product_id,a.pro_stock";
		if ($i_start || $i_last) {
			$this->db->limit($i_start, $i_last);
		}
		if ($b_is_total) {
			$i_total = $this->db->from('prod_sto as a')
                                ->join('product as b', ['a.product_id' => 'b.product_id'])
								->get_total('', $where_product);
			return $i_total;
		} else {
			$a_product = $this->db->from('prod_sto as a')
                                ->join('product as b', ['a.product_id' => 'b.product_id'])
								->get('', $where_product, $a_slse, ['order' => 'asc']);
		}
        // 当日起始时间戳
        $today_start = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

		// 获取产品的价格，拿最便宜的类型价格（如小杯），获取属性
		foreach ($a_product as $i_key => $a_val) {
			$a_where = [
                'store_id'   => $_SESSION['store_id'],
                'product_id' => $a_val['product_id'],
                'stock_time' => $today_start
            ];
            $a_stock_row = $this->db->get_row('stock', $a_where);
            if (empty($a_stock_row)) {
                $a_product[$i_key]['today_stock'] = $a_val['pro_stock'];
            } else {
                $a_product[$i_key]['today_stock'] = $a_stock_row['product_stock'];
            }
			$a_type = $this->db->get('price', ['product_id' => $a_val['product_id']], NULL, ['price' => 'asc']);
			$a_product[$i_key]['price_id'] = $a_type[0]['price_id'];
			$a_product[$i_key]['price'] = $a_type[0]['price'];
			$a_product[$i_key]['type'] = $a_type;
			$a_attr = $this->db->get('product_att', ['product_id' => $a_val['product_id']]);
			$i_count = count($a_attr);
			for ($i_i = 0; $i_i < $i_count; $i_i++) {
				$a_tmp = $this->db->get_row('attributive', ['attri_id' => $a_attr[$i_i]['stye']]);
				$a_attr[$i_i]['attri_name'] = $a_tmp['attri_name'];
				$shuc[$i_i]  = explode(",", $a_attr[$i_i]['attri_id']);
				$i_shuc[$i_i] = count($shuc[$i_i]);
				for ($i_t = 0; $i_t < $i_shuc[$i_i]; $i_t++) {
					$a_ttr = $this->db->get_row('attributive', ['attri_id' => $shuc[$i_i][$i_t]]);
					$shux[$i_i][$i_t]['attri_id']   = $a_ttr['attri_id'];
					$shux[$i_i][$i_t]['attri_name'] = $a_ttr['attri_name'];
				}
			}
			$a_product[$i_key]['attr'] = $a_attr;
			$a_product[$i_key]['shux'] = $shux;
		}

		//查询相对的时间   
        $time_name = $this->db->get('time');   
		foreach ($time_name as $time) {
            $checkDayStr = date('Y-m-d',time());
            $startTime = strtotime($checkDayStr.$time['start_time'].":00");
            $endTime = strtotime($checkDayStr.$time['end_tiem'].":00");
            if($startTime <= time() && $endTime > time()) {
                $a_data['time'][] = $time['time_id'];
            }
        } 

        foreach($a_product as $ttp => $prod) {
			if (!empty($prod['supply_time'])) {
                foreach (explode(",", $prod['supply_time']) as $time) {
                   if ( !empty($a_data['time']) && in_array($time, $a_data['time'])) {
                    if ($prod['today_stock'] != 0) {
           				$a_productpp[$ttp] = $prod;
            	} } }
        	} else {
                $a_productpp[$ttp] = $prod;
            }
        }

		return $a_productpp;
		
	}
	
	// 把产品的基本信息，以及价格、类型、属性等全部组合起来（结果：每个价格相当于一个产品的形式出现）
	public function encapsulation($i_cate_id, $b_is_total = false, $i_start = 0, $i_last = 0) {
		$s_prefix = $this->db->get_prefix();
		$where_product = [$s_prefix . 'product.proid_id_1' => $i_cate_id, $s_prefix . 'product.pro_show' => '1'];
		$where_price = [$s_prefix . 'price.product_id' => $s_prefix . 'product.product_id'];
		$where_cup = [$s_prefix . 'cup.cup_id' => $s_prefix . 'price.cup_id'];
		if ($i_start || $i_last) {
			$this->db->limit($i_start, $i_last);
		}
		if ($b_is_total) {
			$i_total = $this->db->join('product', $where_price)->join('cup', $where_cup)->get_total('price', $where_product);
			return $i_total;
		} else {
			$a_product = $this->db->join('product', $where_price)->join('cup', $where_cup)->get('price', $where_product);
		}
		// 获取属性
		if (is_array($a_product)) {
			foreach ($a_product as $s_key => $a_val) {
				$a_product[$s_key]['attr'] = $this->db->get('product_att', ['product_id' => $a_val['product_id']]);
			}
		}
		return $a_product;
	}
	
	// 把产品的基本信息，以及价格、类型、属性等全部组合起来
	public function add_cart($i_product_id) {
		$s_prefix = $this->db->get_prefix();
		$where_product = [$s_prefix . 'product.proid_id_1' => $i_cate_id, $s_prefix . 'product.pro_show' => '1'];
		$where_price = [$s_prefix . 'price.product_id' => $s_prefix . 'product.product_id'];
		$where_cup = [$s_prefix . 'cup.cup_id' => $s_prefix . 'price.cup_id'];
		
		$a_product = $this->db->join('product', $where_price)->join('cup', $where_cup)->get('price', $where_product);
	}
}

?>