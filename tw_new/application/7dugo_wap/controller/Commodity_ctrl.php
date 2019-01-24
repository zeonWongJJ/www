<?php
defined('BASEPATH') OR exit('禁止访问！');
header('content-type:text/html;charset=utf-8;');
date_default_timezone_set('PRC');
class Commodity_ctrl extends TW_Controller {
	
	public function __construct() {
		parent :: __construct();
		$this->prefix = $this->db->get_prefix();
		
	}

	//商品分类
	public function goods_list() {
		$i_id = $this->router->get(1);
		$a_data = $this->db->get('goods_class',['gc_parent_id' => 1210]);
		$a_data['goods'] = $this->db->get('goods_class',['gc_parent_id' => $i_id]);
		$this->view->display('goods_list', $a_data);
	}

	//商品
	public function search() {
		$i_id = $this->router->get(1) ? $this->router->get(1) : '';
		$i_goods_id = $this->router->get(2) ? $this->router->get(2) : '';
		$a_where = "`goods_state` = 1";
		
		if ( ! empty($i_id)) {
			$a_where .= ($a_where ? ' AND ' : '') . "`gc_id_2` = $i_id";
		}
		if ( ! empty($i_goods_id)) {
			$a_where .= ($a_where ? ' AND ' : '') . "`gc_id_3` = $i_goods_id";
		}
		$a_select = "goods_name, goods_marketprice, goods_price, goods_promotion_type, goods_promotion_price, goods_marketprice, store_id, goods_image, goods_id";		

		// 加载分页类
		require_once PROJECTPATH . '/libraries/Pages.php';
		$this->pages = new TW_Pages();
		//页面数据显示和条件
		$i_canshu = $this->router->get(3) ? $this->router->get(3) : '1';
		// 获取数据总行数，以产品为例
		$i_total = $this->db->get_total('goods', $a_where, $a_select);			
   		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_canshu, 7);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		//数据
		$a_data['order'] = $this->db->get('goods', $a_where, $a_select);
		// echo $this->db->get_sql();
		// var_dump($a_data['order']); 
		
		//显示页
		$a_data['page'] = $this->pages->link_style_one($this->router->url("search-" . $i_id . "-" . $i_goods_id . "-", [], false, false), 3);
		$a_data['name'] = $this->db->get('goods_class', ['gc_id' => $i_goods_id]);

		$this->view->display('search', $a_data);
	}

	//商品详情
	public function item() {
		$i_id = $this->router->get(1);
		$i_goods_id = $this->router->get(2);
		$a_select = ['a.goods_id', 'a.goods_state', 'a.gc_id_2', 'a.store_id', 'a.goods_image', 'a.gc_id_3', 'a.goods_commonid', 'a.goods_name', 'a.goods_jingle', 'a.goods_promotion_type', 'a.goods_promotion_price', 'a.goods_price', 'a.goods_feng', $this->prefix.'goods_common.mobile_body', $this->prefix.'goods_common.goods_body', $this->prefix.'goods_common.gc_name', $this->prefix.'goods_common.brand_name', $this->prefix.'goods_common.goods_commonid'];
		$a_data = $this->db->from('goods as a')
					->join('goods_common', ['a.goods_commonid' => $this->prefix.'goods_common.goods_commonid'])
					->get('', ['a.goods_id' => $i_id], $a_select);
		$a_where = ['geval_goodsid' => $i_id];
		$a_select = "geval_frommembername, geval_scores, geval_content, geval_time_create";
		// 加载分页类
		require_once PROJECTPATH . '/libraries/Pages.php';
		$this->pages = new TW_Pages();
		//页面数据显示和条件
		$i_canshu = $this->router->get(3) ? $this->router->get(3) : '1';
		// 获取数据总行数，以产品为例
		$i_total = $this->db->get_total('evaluate_goods', $a_where, $a_select);			
   		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_canshu, 7);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		//数据
		$a_data['evaluate_goods'] = $this->db->get('evaluate_goods', $a_where, $a_select);
		// echo $this->db->get_sql();
		// var_dump($a_data['evaluate_goods']); 
		
		//显示页
		$a_data['page'] = $this->pages->link_style_one($this->router->url("item-" . $i_id . "-" . $i_goods_id . "-", [], false, false), 4);
		$a = $this->db->get('goods_class', '',['gc_id', 'gc_name']);
		$a_data['name'] = array_column($a, 'gc_name','gc_id');
		
		$this->view->display('item', $a_data);
	}

	//分类
	public function classify() {
		$this->view->display('classify');
	}

	//商品搜索
	public function hunt() {
		$s_name = $this->general->post('name') ? $this->general->post('name') : $this->general->base64_convert($this->router->get('1'), true);
		$i_gc = $this->router->get('2') ? $this->router->get('2') : 0; 
		$i_create = $this->router->get('3') ? $this->router->get('3') : 0; 
		$i_sales = $this->router->get('4') ? $this->router->get('4') : 0; 
		$i_click = $this->router->get('5') ? $this->router->get('5') : 0; 
		$i_price = $this->router->get('6') ? $this->router->get('6') : 0; 
		$i_shop = $this->router->get('7') ? $this->router->get('7') : 0;
		$s_present = $this->router->get('8') ? $this->router->get('8') : 0;
		$i_promotion = $this->router->get('9') ? $this->router->get('9') : 0;
		$i_feng = $this->router->get('10') ? $this->router->get('10') : 0;		
		$a_data = array(
			's_name' => $s_name,
			'i_gc' => $i_gc,
			'i_create' => $i_create,
			'i_sales' => $i_sales,
			'i_click' => $i_click,  
			'i_price' => $i_price,	
			'i_shop' => $i_shop,       
			's_present' => $s_present,       
			'i_promotion' => $i_promotion,       
			'i_feng' => $i_feng,       
			'i_pag' => $i_pag       
      	); 
		$a_select = "goods_id,goods_name, goods_marketprice, goods_promotion_type, goods_promotion_price, goods_price,goods_jingle,evaluation_count,goods_image,store_id";
		// $a_where = '';
		//分类
		if ( ! empty($i_gc)) {
			$a_where .=($a_where ? ' AND ' : '') . "`gc_id_2` = $i_gc";
		}
		//积分
		if ( ! empty($i_feng)) {
			$a_where .=($a_where ? ' AND ' : '') . "`goods_feng` >= 1";
		}
		//搜索
		if ( ! empty($s_name)) {
			$a_where .= ($a_where ? ' AND ' : '') . "`goods_name` LIKE  '%$s_name%'";
		}
		
		//赠品
		if ( ! empty($s_present)) {
			$a_where .= ($a_where ? ' AND ' : '') . "`have_gift` >=1 ";
		}
		//促销
		if ( ! empty($i_promotion)) {
			$a_where .= ($a_where ? ' AND ' : '') . "`goods_promotion_type` >= 1";
		}
		//7度自营
		if ( ! empty($i_shop)) {
			$a_where .=($a_where ? ' AND' : '') . "`is_own_shop` = 1";
		}
		// 加载分页类
		require_once PROJECTPATH . '/libraries/Pages.php';
		$this->pages = new TW_Pages();
		//页面数据显示和条件
		$i_canshu = $this->router->get(11) ? $this->router->get(11) : '1';
		// 获取数据总行数，以产品为例
		$i_total = $this->db->get_total('goods', $a_where);
   		// 调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_canshu, 7);
		// 开始获取产品数据
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		//新品
		if($i_create == 1) {
	        $this->db->order_by(['goods_time_create' => 'asc']);
	    } else if($i_create == 2) {
	        $this->db->order_by(['goods_time_create' => 'desc']);
	    }
		//人气
		if($i_click == 1) {
	        $this->db->order_by(['goods_click' => 'asc']);
	    } else if($i_click == 2) {
	        $this->db->order_by(['goods_click' => 'desc']);
	    }
		//销量
		if($i_sales == 1) {
	        $this->db->order_by(['goods_salenum' => 'asc']);
	    } else if($i_sales == 2) {
	        $this->db->order_by(['goods_salenum' => 'desc']);
	    }
	    //价格
		if($i_price == 1) {
	        $this->db->order_by(['goods_price' => 'asc']);
	    } else if($i_price == 2) {
	        $this->db->order_by(['goods_price' => 'desc']);
	    }
		//数据		
		$a_data['goods'] = $this->db->get('goods', $a_where, $a_select, $a_order);
		// echo $this->db->get_sql(); 		
		//显示页
		$a_data['page'] = $this->pages->link_style_goods($this->router->url("hunt-" . $this->general->base64_convert($s_name) . "-" . $i_gc . "-". $i_create . "-" . $i_sales . "-" . $i_click . "-" . $i_price . "-" . $i_shop . "-" . $s_present . "-" . $i_promotion . "-" . $i_feng . "-", [], false, false), 4);
		
		$this->view->display('hunt', $a_data);
	}
}
