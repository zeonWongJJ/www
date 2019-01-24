<?php

class Order_toview_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

	// 订单追踪
	public function order_tracking($id) {
		$a_data['order'] = $this->db->get('order_tracking', ['order_id' => $id], '', ['id' => 'asc']);
		$a_oret = [
			// 必传，订单ID
			'order_id' => $a_data['order'][0]['order_number'],
			// 'order_id' => '201804261008344482',
			// 可选，地图中心点经度，默认以骑手位置为中心点
			'center_longitude' => 113.33343,
			// 可选，地图中心点纬度，默认以骑手位置为中心点
			'center_latitude' => 22.96336,
			// 可选，骑手图标，图片链接
			'img' => 'http://lbs.amap.com/web/public/dist/avatar_default.01b559.png',
			// 可选，图片宽度
			'img_width' => 50,
			// 可选，图片高度
			'img_height' => 50
		];
		$s_result = $this->general->request('http://distribution.7dugo.com/query.html', $a_oret);
		$a_data['result'] = json_decode($s_result, true);
		return $a_data;
	}

	// 查看退款
	public function refund($id) {
		$a_data['reim']  = $this->db->get('reimburse', ['order_id' => $id], '', ['reimburse_id' => 'desc']);
		$a_data['order'] = $this->db->get_row('order', ['order_id' => $id]);
		// print_r($a_data['order']);
		if ($a_data['order']['payment_code'] == 'offline') {//微信付款
			$a_wei = [
				// 商户订单号和微信订单号必须二选一，同时设置时，优先使用微信订单号
				'out_trade_no' => $a_data['order']['pay_sn'],
				// 微信订单号
				'transaction_id' => '',
				// 微信退款单号，微信生成的退款单号，在申请退款接口有返回
				'refund_id' => ''
			];
			$this->load->library('wxpay_h5', '', [$a_wei]);
			$a_result = $this->wxpay_h5->refund_query();
			if ($a_result['refund_status_0'] == 'SUCCESS') {
				$a_data['tuik'] = $a_result;
			}
		} else if ($a_data['order']['payment_code'] == 'alipay') {//支付宝
			$this->load->library('alipay_wap');
			$a_zhi = [
				// 商户订单号，商户网站订单系统中唯一订单号，必填
				'out_trade_no' => $a_data['order']['pay_sn'],
				// 支付宝交易号，和上面的参数二选一
				// 'trade_no' => '201801181735452855',
				'is_page' => false
			];
			// 显示返回的查询结果
			$a_result = $this->alipay_wap->query($a_zhi);
			if ($a_result['code'] == 10000) {
				$a_data['tuik'] = $a_result;
			}
		} else if ($a_data['order']['payment_code'] == 'unionpay') {//银联网关支付
			$this->load->library('unionpay_geteway');
			$a_param = [
				// 订单号
				'id_order' => $order['pay_sn']
			];
			$a_result = $this->unionpay_geteway->query($a_param);
			if ($this->unionpay_geteway->verify($a_result)) {
				if ($a_result['origRespCode'] == '00') {

				}
			}
			// print_r($a_result);
		}
		return $a_data;
	}
}
?>