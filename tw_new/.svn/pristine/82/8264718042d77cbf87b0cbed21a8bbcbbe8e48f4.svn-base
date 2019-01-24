<?php
defined('BASEPATH') OR exit('禁止访问！');
class Bill_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('bill_model');
		// $this->load->model('login_model');
		session_start();
	}

	//结算页面
	public function bill() {
		// 获取POST数据将其加入订单
		if ( ! empty($_POST)) {
			$a_data['a_cart'] = $this->general->post();
			$_SESSION['post'] = $a_data['a_cart'];
			$goods = $this->general->post('goods');
			$store = $this->general->post('store');
		} else {
			$a_data['a_cart'] = $_SESSION['post'];
			$goods = $_SESSION['post']['goods'];
			$store = $_SESSION['post']['store'];
		}
        // 查询收货地址
        $a_data['memb'] = $this->db->get_row('address', ['is_default' => 1, 'user_id' => $_SESSION['user_id']]);
        //分享人信息
        $a_data['qualifi'] = $this->db->get('qualifi_goods', ['state' => 2], '', '', 0,999999999);
		// 订单输出商品数据
		if(!empty($a_data['a_cart'])) {
			$a_data['user']  = $this->db->get_row('user', ['user_id' => $_SESSION['user_id']]);
			// 判断有没有门店传进来的值
			if ( ! empty($goods)) {
				$a_data['bill'] = $this->bill_model->buy_now();
				$a_data['memb'] = $this->db->get_row('address', ['is_default' => 1, 'user_id' => $_SESSION['user_id']]);
				$a_data['come_type'] = 2;
				// 获取预约的座位信息
				$a_data['store_arr'] = array();
				if (!empty($_SESSION['post']['stuo_id'])) {
					$thisstore = array($_SESSION['post']['stuo_id']);
					// 获取此部分门店信息
					$a_data['store_info'] = $this->bill_model->get_store_info($thisstore);
					// 获取用户预约的座位
					$a_data['appointment'] = $this->bill_model->get_user_seat($_SESSION['user_id'], $thisstore);
					$a_data['store_arr'] = $thisstore;
				}
				$this->view->display('bill', $a_data);
				die;
			} else if ( ! empty($store)) {
				$a_data['bill'] = $this->bill_model->buy_tost();
				if (empty($a_data['bill']['data'])) {
					$this->error->show_error('你没有选择商品', basename($this->router->get_url()), '', 1);
				}
			} else {
				$a_data['bill'] = $this->bill_model->bill();
			}
			$a_data['come_type'] = 1;
			$cart_ids = array();
			$store_arr = array();
			$order_price = 0;
			$freight = 0;
			$goodscount = 0;
			foreach ($a_data['bill']['data'] as $key => $value) {
				$freight = $freight + $value['freight'];
				foreach ($value['goods'] as $k => $v) {
					$cart_ids[] = $v['cart_id'];
					if (!in_array($v['store_id'], $store_arr) && !empty($v['store_id'])) {
						$store_arr[] = $v['store_id'];
					}
					$order_price = $order_price + ($v['prot_count'] * $v['money']);
					$goodscount = $goodscount + $v['prot_count'];
				}
			}
			$a_data['order_price'] = $order_price + $freight;
			$a_data['allfreight'] = $freight;
			$a_data['goodscount'] = $goodscount;
			$a_data['cart_ids'] = implode(',', $cart_ids);
			// 结算的购车中包含的门店
			$a_data['store_arr'] = $store_arr;
			// 获取此部分门店信息
			$a_data['store_info'] = $this->bill_model->get_store_info($store_arr);
			// 获取用户预约的座位
			$a_data['appointment'] = $this->bill_model->get_user_seat($_SESSION['user_id'], $store_arr);
			$this->view->display('bill', $a_data);
		} else {
			$this->error->show_error('你没有选择商品', basename($this->router->get_url()), '', 1);
		}
	}


	public function new_bill() {
		// 获取POST数据将其加入订单
		if ( ! empty($_POST)) {
			$come_type = trim($this->general->post('come_type'));
			$a_data['a_cart'] = $this->general->post();
			$_SESSION['post'] = $a_data['a_cart'];
		} else {
			$a_data['a_cart'] = $_SESSION['post'];
			$come_type = $_SESSION['post']['come_type'];
		}
		// echo "<pre>";
		// var_dump($_SESSION['post']);die;
		$tourl = $this->router->url('new_new_bill');
		if ($come_type == 1 || $come_type == 4) {
			header("location:$tourl");die;
			// 如果是从门店进来则直接获取其该用户在此门店的购物车信息
			if ($come_type == 4) {
				// 接收门店id
				$store_id = trim($this->general->post('store')) ? trim($this->general->post('store')) : $_SESSION['post']['store'];
				// 获取此门店此用户的购物车信息
				$a_cart_ustore = $this->bill_model->get_cart_ustore($store_id, $_SESSION['user_id']);
				$this_store_cart_arr = array();
				if (!empty($a_cart_ustore)) {
					foreach ($a_cart_ustore as $key => $value) {
						$this_store_cart_arr[] = $value['cart_id'];
					}
					$cart_ids = implode(',', $this_store_cart_arr);
				}
			} else {
				// 接收购物车信息
				$cart_ids = $this->general->post('cart_ids') ? $this->general->post('cart_ids') : $_SESSION['post']['cart_ids'];
			}
			// 验证数据
			if (empty($cart_ids)) {
				$a_parameter = [
					'msg'      => '请选择需要结算的商品',
					'url'      => $_GET['oldurl'],
					'log'      => false,
					'wait'     => 2,
				];
				$this->error->show_error($a_parameter);
			}
			$store_arr   = array();
			$share_arr   = array();
			$nostore_arr = array();
			if (!empty($cart_ids)) {
				// 获取一运费设置信息
				$user_order_freight = $this->bill_model->get_set_one('user_order_freight');
				$cart_arr = explode(',', $cart_ids);
				for ($i=0; $i < count($cart_arr); $i++) {
					// 获取一条购物车信息
					$a_cart_row = $this->bill_model->get_cart_one($cart_arr[$i]);
					// 拆分订单
					if (empty($a_cart_row['store_id'])) {
						if (empty($a_cart_row['share_userid'])) {
							$nostore_arr[] = $a_cart_row['cart_id'];
						} else {
							$share_arr[] = $a_cart_row['cart_id'];
						}
					} else {
						if (!in_array($a_cart_row['store_id'], $store_arr)) {
							$store_arr[] = $a_cart_row['store_id'];
						}
					}
				}
				// 统计数据
				$goods_amount_total = 0; // 商品总价
				$goods_count_total = 0; // 商品总数
				$good_freight_total = 0; // 运费总数
				// 生成有门店的数据
				$a_data['goods']['store'] = array();
				if (!empty($store_arr)) {
					for ($i=0; $i < count($store_arr); $i++) {
						// 此门店的运费
						$a_data['goods']['store'][$i]['freight'] = $user_order_freight;
						// 获取此门店的购物车信息
						$a_cart_part = $this->bill_model->get_cart_part($cart_arr, $store_arr[$i]);
						foreach ($a_cart_part as $key => $value) {
							// 重新获取价格
							$a_price_row = $this->bill_model->get_price_one($value['product_id'], $value['spec']);
							$value['new_price'] = $a_price_row['price'];
							$a_data['goods']['store'][$i]['cart'][]     = $value;
							$a_data['goods']['store'][$i]['store_name'] = $value['store_name'];
							$a_data['goods']['store'][$i]['store_id']   = $store_arr[$i];
							$goods_amount_total = $goods_amount_total + ($value['prot_count']*$a_price_row['price']);
							$goods_count_total = $goods_count_total + $value['prot_count'];
						}
						$good_freight_total = $good_freight_total + $user_order_freight;
					}
				}
				// 生成分享者数据
				$a_data['goods']['share'] = array();
				if (!empty($share_arr)) {
					$share_freight = 0;
					$a_cart_share = $this->bill_model->get_cart_share($share_arr);
					foreach ($a_cart_share as $key => $value) {
						$a_price_row = $this->bill_model->get_price_one($value['product_id'], 'share');
						// 获取运费
						$a_qualifi_row = $this->bill_model->get_qualifi_one($value['product_id']);
						$share_freight = $share_freight + $a_qualifi_row['distribution'];
						$value['new_price'] = $a_price_row['price'];
						$a_data['goods']['share']['cart'][] = $value;
						$goods_amount_total = $goods_amount_total + ($value['prot_count']*$a_price_row['price']);
						$goods_count_total = $goods_count_total + $value['prot_count'];
					}
					$a_data['goods']['share']['freight'] = $share_freight;
					$a_data['goods']['share']['name'] = '非自营';
					$good_freight_total = $good_freight_total + $share_freight;
				}
				// 生成无门店数据
				$a_data['goods']['nostore'] = array();
				if (!empty($nostore_arr)) {
					$a_cart_nostore = $this->bill_model->get_cart_share($nostore_arr);
					foreach ($a_cart_nostore as $key => $value) {
						$a_price_row = $this->bill_model->get_price_one($value['product_id'], $value['spec']);
						$value['new_price'] = $a_price_row['price'];
						$a_data['goods']['nostore']['cart'][] = $value;
						$goods_amount_total = $goods_amount_total + ($value['prot_count']*$a_price_row['price']);
						$goods_count_total = $goods_count_total + $value['prot_count'];
					}
					$a_data['goods']['nostore']['freight'] = $user_order_freight;
					$a_data['goods']['nostore']['name'] = '无门店';
					$good_freight_total = $good_freight_total + $user_order_freight;
				}
				// 结算的购车中包含的门店
				$a_data['store_arr'] = $store_arr;
				// 获取此部分门店信息
				$a_data['store_info'] = $this->bill_model->get_store_info($store_arr);
				// 获取用户预约的座位
				$a_data['appointment'] = $this->bill_model->get_user_seat($_SESSION['user_id'], $store_arr);
				$a_data['user'] = $this->bill_model->get_user_one($_SESSION['user_id']);
				$a_data['goods_amount_total'] = $goods_amount_total;
				$a_data['goods_count_total']  = $goods_count_total;
				$a_data['order_price']        = $goods_amount_total + $good_freight_total;
				// 收获地址信息
				$a_data['memb'] = $this->bill_model->get_address_default($_SESSION['user_id']);
				if (!$a_data['memb']) {
					$a_data['memb'] = array();
				}
				$a_data['cart_ids'] = $cart_ids;
				$a_data['come_type'] = 1;
				$a_data['shipping_fee'] = $user_order_freight;
				$this->view->display('new_bill', $a_data);
			}
		} else if ($come_type == 2) {
			// 立即购买
			if ( ! empty($_POST)) {
				$product_id        = trim($this->general->post('goods'));
				$store_id          = trim($this->general->post('stuo_id'));
				$cup_id            = trim($this->general->post('pric'));
				$goods_count_total = trim($this->general->post('num'));
				$shux              = trim($this->general->post('shux'));
			} else {
				$product_id        = $_SESSION['post']['goods'];
				$store_id          = $_SESSION['post']['stuo_id'];
				$cup_id            = $_SESSION['post']['pric'];
				$goods_count_total = $_SESSION['post']['num'];
				$shux              = $_SESSION['post']['shux'];
			}
			// 跳转到最新的结算页面
			header("location:$tourl");die;
			// 获取产品信息
			$a_data['product'] = $this->bill_model->get_product_one($product_id);
			// 验证类型 并获取价格和运费
			$a_data['share_userid'] = 0;
			if ($a_data['product']['goods_stye'] == 1) {
				// 获取价格
				$a_price_row = $this->bill_model->get_price_one($product_id, $cup_id);
				// 获取运费
				$good_freight_total = $this->bill_model->get_set_one('user_order_freight');
			} else if ($a_data['product']['goods_stye'] == 2) {
				// 获取价格
				$a_price_row = $this->bill_model->get_price_one($product_id, 'share');
				// 获取运费
				$a_qualifi_row = $this->bill_model->get_qualifi_one($product_id);
				$good_freight_total = $a_qualifi_row['distribution'];
				$a_data['share_userid'] = $a_qualifi_row['user_id'];
			}
			// 价格
			$a_data['product']['new_price'] = $a_price_row['price'];
			// 运费
			$a_data['product']['freight'] = $good_freight_total;
			// 获取门店信息及预约的座位信息
			$store_arr = array();
			if (!empty($store_id)) {
				$a_store_row = $this->bill_model->get_store_one($store_id);
				$a_data['product']['title']      = $a_store_row['store_name'];
				$a_data['product']['store_name'] = $a_store_row['store_name'];
				$a_data['product']['store_id']   = $a_store_row['store_id'];
				// 获取预约的座位信息
				$store_arr[] = $a_store_row['store_id'];
				$a_data['store_info'] = $this->bill_model->get_store_info($store_arr);
				// 获取用户预约的座位
				$a_data['appointment'] = $this->bill_model->get_user_seat($_SESSION['user_id'], $store_arr);
			} else {
				if ($a_data['product']['goods_stye'] == 1) {
					$a_data['product']['title'] = '无门店';
				} else {
					$a_data['product']['title'] = '非自营';
				}
				$a_data['product']['store_name'] = '';
				$a_data['product']['store_id'] = 0;
			}
			// 用户信息
			$a_data['user'] = $this->bill_model->get_user_one($_SESSION['user_id']);
			$a_data['store_arr'] = $store_arr;
			// 收获地址信息
			$a_data['memb']               = $this->bill_model->get_address_default($_SESSION['user_id']);
			if (!$a_data['memb']) {
				$a_data['memb'] = array();
			}
			$a_data['goods_amount_total'] = $a_price_row['price'] * $goods_count_total;
			$a_data['goods_count_total']  = $goods_count_total;
			$a_data['order_price']        = $a_data['goods_amount_total'] + (float)$good_freight_total;
			$a_data['come_type']          = $come_type;
			$a_data['shux']               = $shux;
			$this->view->display('new_bill', $a_data);
		}
	}

	public function address_default() {
		$a_data = $this->bill_model->get_address_default($_SESSION['user_id']);
		if ($a_data) {
			echo json_encode(array('code'=>200,'data'=>$a_data));
		} else {
			echo json_encode(array('code'=>400,'data'=>''));
		}
	}

/*
|----------------------------------------------------------------------------------------------
| 最新结算
|----------------------------------------------------------------------------------------------
 */

	public function new_new_bill() {
		// 获取POST数据将其加入订单
		if ( ! empty($_POST)) {
			$come_type = trim($this->general->post('come_type'));
			$a_data['a_cart'] = $this->general->post();
			$_SESSION['post'] = $a_data['a_cart'];
		} else {
			$a_data['a_cart'] = $_SESSION['post'];
			$come_type = $_SESSION['post']['come_type'];
		}
		if ($come_type == 1 || $come_type == 4) {
			// 如果是从门店进来则直接获取其该用户在此门店的购物车信息
			if ($come_type == 4) {
				// 接收门店id
				$store_id = trim($this->general->post('store')) ? trim($this->general->post('store')) : $_SESSION['post']['store'];
				// 获取此门店此用户的购物车信息
				$a_cart_ustore = $this->bill_model->get_cart_ustore($store_id, $_SESSION['user_id']);
				$this_store_cart_arr = array();
				if (!empty($a_cart_ustore)) {
					foreach ($a_cart_ustore as $key => $value) {
						$this_store_cart_arr[] = $value['cart_id'];
					}
					$cart_ids = implode(',', $this_store_cart_arr);
				}
			} else {
				// 接收购物车信息
				$cart_ids = $this->general->post('cart_ids') ? $this->general->post('cart_ids') : $_SESSION['post']['cart_ids'];
			}
			// 验证数据
			if (empty($cart_ids)) {
				sleep(2); // 停留两秒
				$tourl = $this->router->url('goods_order');
				header("location:$tourl");die;
				$a_parameter = [
					'msg'      => '请选择需要结算的商品',
					'url'      => $_GET['oldurl'],
					'log'      => false,
					'wait'     => 2,
				];
				$this->error->show_error($a_parameter);
			}
			$store_arr   = array();
			$share_arr   = array();
			$nostore_arr = array();
			if (!empty($cart_ids)) {
				// 获取一运费设置信息
				$user_order_freight = $this->bill_model->get_set_one('user_order_freight');
				$cart_arr = explode(',', $cart_ids);
				for ($i=0; $i < count($cart_arr); $i++) {
					// 获取一条购物车信息
					$a_cart_row = $this->bill_model->get_cart_one($cart_arr[$i]);
					if (!$a_cart_row) {
						sleep(2); // 停留两秒
						$tourl = $this->router->url('goods_order');
						header("location:$tourl");die;
					}
					// 拆分订单
					if (empty($a_cart_row['store_id'])) {
						if (empty($a_cart_row['share_userid'])) {
							$nostore_arr[] = $a_cart_row['cart_id'];
						} else {
							$share_arr[] = $a_cart_row['cart_id'];
						}
					} else {
						if (!in_array($a_cart_row['store_id'], $store_arr)) {
							$store_arr[] = $a_cart_row['store_id'];
						}
					}
				}
				// 统计数据
				$goods_amount_total = 0; // 商品总价
				$goods_count_total = 0; // 商品总数
				$good_freight_total = 0; // 运费总数
				// 生成有门店的数据
				$a_data['goods']['store'] = array();
				if (!empty($store_arr)) {
					for ($i=0; $i < count($store_arr); $i++) {
						// 此门店的运费
						$a_data['goods']['store'][$i]['freight'] = $user_order_freight;
						// 获取此门店的购物车信息
						$a_cart_part = $this->bill_model->get_cart_part($cart_arr, $store_arr[$i]);
						foreach ($a_cart_part as $key => $value) {
							// 重新获取价格
							$a_price_row = $this->bill_model->get_price_one($value['product_id'], $value['spec']);
							$value['new_price'] = $a_price_row['price'];
							$a_data['goods']['store'][$i]['cart'][]     = $value;
							$a_data['goods']['store'][$i]['store_name'] = $value['store_name'];
							$a_data['goods']['store'][$i]['store_id']   = $store_arr[$i];
							$goods_amount_total = $goods_amount_total + ($value['prot_count']*$a_price_row['price']);
							$goods_count_total = $goods_count_total + $value['prot_count'];
						}
						$good_freight_total = $good_freight_total + $user_order_freight;
					}
				}
				// 生成分享者数据
				$a_data['goods']['share'] = array();
				if (!empty($share_arr)) {
					$share_freight = 0;
					$a_cart_share = $this->bill_model->get_cart_share($share_arr);
					foreach ($a_cart_share as $key => $value) {
						$a_price_row = $this->bill_model->get_price_one($value['product_id'], 'share');
						// 获取运费
						$a_qualifi_row = $this->bill_model->get_qualifi_one($value['product_id']);
						$share_freight = $share_freight + $a_qualifi_row['distribution'];
						$value['new_price'] = $a_price_row['price'];
						$a_data['goods']['share']['cart'][] = $value;
						$goods_amount_total = $goods_amount_total + ($value['prot_count']*$a_price_row['price']);
						$goods_count_total = $goods_count_total + $value['prot_count'];
					}
					$a_data['goods']['share']['freight'] = $share_freight;
					$a_data['goods']['share']['name'] = '非自营';
					$good_freight_total = $good_freight_total + $share_freight;
				}
				// 生成无门店数据
				$a_data['goods']['nostore'] = array();
				if (!empty($nostore_arr)) {
					$a_cart_nostore = $this->bill_model->get_cart_share($nostore_arr);
					foreach ($a_cart_nostore as $key => $value) {
						$a_price_row = $this->bill_model->get_price_one($value['product_id'], $value['spec']);
						$value['new_price'] = $a_price_row['price'];
						$a_data['goods']['nostore']['cart'][] = $value;
						$goods_amount_total = $goods_amount_total + ($value['prot_count']*$a_price_row['price']);
						$goods_count_total = $goods_count_total + $value['prot_count'];
					}
					$a_data['goods']['nostore']['freight'] = $user_order_freight;
					$a_data['goods']['nostore']['name'] = '无门店';
					$good_freight_total = $good_freight_total + $user_order_freight;
				}
				// 结算的购车中包含的门店
				$a_data['store_arr'] = $store_arr;
				// 获取此部分门店信息
				$a_data['store_info'] = $this->bill_model->get_store_info($store_arr);
				// 获取用户预约的座位
				$a_data['appointment'] = $this->bill_model->get_user_seat($_SESSION['user_id'], $store_arr);
				$a_data['user'] = $this->bill_model->get_user_one($_SESSION['user_id']);
				$a_data['goods_amount_total'] = $goods_amount_total;
				$a_data['goods_count_total']  = $goods_count_total;
				$a_data['order_price']        = $goods_amount_total + $good_freight_total;
				// 收获地址信息
				$a_data['memb'] = $this->bill_model->get_address_default($_SESSION['user_id']);
				if (!$a_data['memb']) {
					$a_data['memb'] = array();
				}
				$a_data['cart_ids'] = $cart_ids;
				$a_data['come_type'] = 1;
				$a_data['shipping_fee'] = $user_order_freight;
				$this->view->display('new_bill', $a_data);
			}
		} else if ($come_type == 2) {
			// 立即购买
			if ( ! empty($_POST)) {
				$product_id        = trim($this->general->post('goods'));
				$store_id          = trim($this->general->post('stuo_id'));
				$cup_id            = trim($this->general->post('pric'));
				$goods_count_total = trim($this->general->post('num'));
				$shux              = trim($this->general->post('shux'));
			} else {
				$product_id        = $_SESSION['post']['goods'];
				$store_id          = $_SESSION['post']['stuo_id'];
				$cup_id            = $_SESSION['post']['pric'];
				$goods_count_total = $_SESSION['post']['num'];
				$shux              = $_SESSION['post']['shux'];
			}
			// 获取产品信息
			$a_data['product'] = $this->bill_model->get_product_one($product_id);
			// 验证类型 并获取价格和运费
			$a_data['share_userid'] = 0;
			if ($a_data['product']['goods_stye'] == 1) {
				// 获取价格
				$a_price_row = $this->bill_model->get_price_one($product_id, $cup_id);
				// 获取运费
				$good_freight_total = $this->bill_model->get_set_one('user_order_freight');
			} else if ($a_data['product']['goods_stye'] == 2) {
				// 获取价格
				$a_price_row = $this->bill_model->get_price_one($product_id, 'share');
				// 获取运费
				$a_qualifi_row = $this->bill_model->get_qualifi_one($product_id);
				$good_freight_total = $a_qualifi_row['distribution'];
				$a_data['share_userid'] = $a_qualifi_row['user_id'];
			}
			// 价格
			$a_data['product']['new_price'] = $a_price_row['price'];
			// 运费
			$a_data['product']['freight'] = $good_freight_total;
			// 获取门店信息及预约的座位信息
			$store_arr = array();
			if ($store_id != 'i') {
				$a_store_row = $this->bill_model->get_store_one($store_id);
				$a_data['product']['title']      = $a_store_row['store_name'];
				$a_data['product']['store_name'] = $a_store_row['store_name'];
				$a_data['product']['store_id']   = $a_store_row['store_id'];
				// 获取预约的座位信息
				$store_arr[] = $a_store_row['store_id'];
				$a_data['store_info'] = $this->bill_model->get_store_info($store_arr);
				// 获取用户预约的座位
				$a_data['appointment'] = $this->bill_model->get_user_seat($_SESSION['user_id'], $store_arr);
			} else {
				if ($a_data['product']['goods_stye'] == 1) {
					$a_data['product']['title'] = '无门店';
				} else {
					$a_data['product']['title'] = '非自营';
				}
				$a_data['product']['store_name'] = '';
				$a_data['product']['store_id'] = 0;
			}
			// 用户信息
			$a_data['user'] = $this->bill_model->get_user_one($_SESSION['user_id']);
			$a_data['store_arr'] = $store_arr;
			// 收获地址信息
			$a_data['memb']               = $this->bill_model->get_address_default($_SESSION['user_id']);
			if (!$a_data['memb']) {
				$a_data['memb'] = array();
			}
			$a_data['goods_amount_total'] = $a_price_row['price'] * $goods_count_total;
			$a_data['goods_count_total']  = $goods_count_total;
			$a_data['order_price']        = $a_data['goods_amount_total'] + (float)$good_freight_total;
			$a_data['come_type']          = $come_type;
			$a_data['shux']               = $shux;
			$this->view->display('new_bill', $a_data);
		}
	}

}
