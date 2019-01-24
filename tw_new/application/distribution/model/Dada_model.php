<?php
defined('BASEPATH') or exit('禁止访问！');

/**
 * 本类负责达达配送相关的逻辑处理
 */
class Dada_model extends TW_Model {
	// 回调网址
	private $_callback;
	
	public function __construct() {
		parent :: __construct();
		$this->load->library('distribution_dada');
		$this->load->model('order_model');
		$this->_callback = $this->router->url('notify_dada');
	}
	
	// 达达配送的通知处理
	public function notify($s_data) {
		$this->load->model('notify_model');
		$a_data = json_decode($s_data, true);
		$s_sign = $this->distribution_dada->signature($a_data);
		
		if ($a_data['code'] != 0 || $a_data['status'] == 'fail') {
			return false;
		}
		
		if (isset($a_data['order_id'])) {
			if ($a_data['signature'] == $s_sign) {
				$a_notify_data = $this->notify_model->get_row($a_data['order_id'], 'dada');
				//print_r($a_notify_data);
				
				// 转换状态
				$s_status = $this->status_conversion($a_data['order_status']);
				
				if ( ! $this->notify_model->save($a_data, 'dada', $s_status) ) {
					$this->log->record('保存“dada”订单通知失败！订单号：' . $a_data['order_id'] . $s_data, 11);
				}
				
				if ($a_data['update_time'] > $a_notify_data['notify_time'] && $a_data['order_status'] != $a_notify_data['notify_status']) {
					// 更新状态及接单的配送公司
					$this->update_order_status($a_data['order_id'], $s_status, 'dada');
					// 接单之后的流程，都要更新配送信息
					if ($a_data['order_status'] > 1) {
						$this->update_distribution_data($a_data['order_id']);
					}
					// 订单过期
					if ($a_data['order_status'] == 7) {
						$this->expire($a_data['order_id']);
					}
				}
			} else {
				$this->log->record('“dada”签名验证失败：' . $s_data, 11);
			}
		}
	}
	
	// 提交新订单
	public function add(&$a_post) {
		$a_data = $this->_field_conversion($a_post);
		$a_data['callback'] = $this->_callback;
		return $this->distribution_dada->add_order($a_data);
	}
	
	// 获取执行结果
	public function get_result(&$a_post) {
		return $this->distribution_dada->get_result();
	}
	
	// 订单过期后，重新提交
	public function expire($i_id_order) {
		$a_result = $this->order_model->get_row($i_id_order);
		$a_post = json_decode($a_result['trade_param'], true);
		// 期望取货时间，因为已经等待超时了，所以无需再加上推迟时间
		if ($a_post['expected_fetch_time'] < $_SERVER['REQUEST_TIME']) {
			$a_post['expected_fetch_time'] = $_SERVER['REQUEST_TIME'];
		}
		$a_post = $this->_field_conversion($a_post);
		$a_post['callback'] = $this->_callback;
		if ($this->distribution_dada->readd_order($a_post)) {
			if ( ! $this->update_order_status($i_id_order, 10, 'dada') ) {
				$this->log->record("重新提交“dada”订单后更新订单状态失败！订单号：{$i_id_order}", 11);
			}
		} else {
			$this->order_model->update_company_success($i_id_order, 'dada');
			$this->log->record("重新提交“dada”订单失败！订单号：{$i_id_order}，返回信息：" . json_encode($this->distribution_dada->get_result()), 11);
		}
	}
	
	// 把达达的订单状态转换成系统的状态标识
	public function status_conversion($s_status) {
		$a_status = [
			1000 => 0,
			1 => 10,
			2 => 20,
			3 => 30,
			4 => 40,
			5 => 50,
			
			7 => 60,
			8 => 80,
			9 => 85
		];
		return $a_status[$s_status];
	}
	
	// 更新订单状态
	public function update_order_status($i_id_order, $s_status, $s_company = '') {
		if ( ! $this->order_model->update_status($i_id_order, $s_status, $s_company) ) {
			$this->log->record("更新“dada”订单状态失败！订单号：{$i_id_order}，订单状态：{$s_status}", 11);
		} elseif ($s_status >= 20) {
			// 已有人接单，把其他平台的订单取消，避免重复接单
			$this->order_model->cancel_other($i_id_order);
		}
	}
	
	// 配送信息组装
	public function distribution_dada(&$a_post, &$a_param) {
		$a_order_data = json_decode($a_param['distribution_dada'], true);
		$a_distribution_dada = $a_order_data['result'];
		$a_data = $this->_field_conversion($a_distribution_dada, false);
		
		// 地图代码
		if ($a_data['rider_longitude'] && $a_data['rider_latitude']) {
			$a_map = [
				// 地图中心点经度
				'center_longitude' => isset($a_post['center_longitude']) ? $a_post['center_longitude'] : $a_distribution_dada['transporterLng'],
				// 地图中心点纬度
				'center_latitude' => isset($a_post['center_latitude']) ? $a_post['center_latitude'] : $a_distribution_dada['transporterLat'],
				// 骑手经度
				'rider_longitude' => $a_distribution_dada['transporterLng'],
				// 骑手纬度
				'rider_latitude' => $a_distribution_dada['transporterLat'],
				// 图片链接
				'img' => isset($a_post['img']) ? $a_post['img'] : '',
				// 图片宽度
				'img_width' => isset($a_post['img_width']) ? $a_post['img_width'] : '',
				// 图片高度
				'img_height' => isset($a_post['img_height']) ? $a_post['img_height'] : ''
			];
			$this->load->model('map_model');
			$a_html = $this->map_model->location($a_map);
			// 地图代码，放在html的head部分
			$a_data['map_code_head'] = $a_html['map_code_head'];
			// 地图代码，放在html的body部分
			$a_data['map_code_body'] = $a_html['map_code_body'];
		}
		return $a_data;
	}
	
	// 查询订单信息
	public function query($i_id_order) {
		$a_param = ['order_id' => $i_id_order];
		$a_result = $this->distribution_dada->query($a_param);

		return $a_result;
	}
	
	// 更新配送信息
	public function update_distribution_data($i_id_order, $a_distribution_dada = '') {
		if (empty($a_distribution_dada)) {
			$a_distribution_dada = $this->query($i_id_order);
		}
		// 保存配送信息
		if (isset($a_distribution_dada['status']) && $a_distribution_dada['status'] == 'success') {
			
			$s_distribution_dada = json_encode($a_distribution_dada);
			// 转换状态
			$s_status = $this->status_conversion($a_distribution_dada['result']['statusCode']);
			$this->update_order_status($i_id_order, $s_status, 'dada');
			$this->order_model->update_distribution_dada($i_id_order, $s_distribution_dada, 'dada');
		}
	}
	
	// 取消订单
	public function cancel($i_id_order, $i_id_reason) {
		$a_reason = [
			// 没有配送员接单
			10 => 1,
			// 配送员没来取货
			20 => 2,
			// 配送员态度太差
			30 => 3,
			// 顾客取消订单
			40 => 4,
			// 订单填写错误
			50 => 5,
			// 配送员让我取消此单
			110 => 34,
			// 配送员不愿上门取货
			120 => 35,
			// 我不需要配送了
			130 => 36,
			// 配送员以各种理由表示无法完成订单
			140 => 37,
			// 其他
			210 => 10000
		];
		$a_data = [
			// 订单id
			'order_id' => $i_id_order,
			// 取消原因id
			'cancel_reason_id' => $a_reason[$i_id_reason]
		];
		if ($this->distribution_dada->cancel($a_data)) {
			// 取消订单成功
			return true;
		}
		// 记录取消失败的原因
		$this->log->record("取消“dada”订单失败！订单号：{$i_id_order}，返回信息：" . json_encode($this->distribution_dada->get_result()), 11);
		
		return false;
	}
	
	/**
	 * 字段转换，
	 * $b_positive为true时表示正向转换 ['shop_id' => 'aaa'] 
	 * $b_positive为false逆向转换 ['shop_no' => 'aaa'] 会转换成 ['shop_id' => 'aaa']
	 */
	private function _field_conversion($a_param, $b_positive = true) {
		$a_field = [
			// 提交订单的参数转换
			'shop_id' => 'shop_no',
			'order_id' => 'origin_id',
			'order_price' => 'cargo_price',
			'receiver_longitude' => 'receiver_lng',
			'receiver_latitude' => 'receiver_lat',
			'fee' => 'tips',
			'message' => 'info',
			'order_type' => 'cargo_type',
			'goods_weight' => 'cargo_weight',
			'goods_num' => 'cargo_num',
			'order_mark' => 'origin_mark',
			'order_mark_no' => 'origin_mark_no',
			
			// 下面是回调返回参数转换
			// 骑手经度
			'rider_longitude' => 'transporterLng',
			// 骑手纬度
			'rider_latitude' => 'transporterLat',
			// 骑手姓名
			'rider_name' => 'transporterName',
			// 骑手电话
			'rider_phone' => 'transporterPhone',
			// 配送费,单位为元
			'freight' => 'deliveryFee',
			// 小费,单位为元
			'fee' => 'tips',
			// 发单时间
			'time_create' => 'createTime',
			// 接单时间
			'time_receive' => 'acceptTime',
			// 取货时间
			'time_fetch' => 'fetchTime',
			// 送达时间
			'time_arrive' => 'finishTime',
			// 取消时间
			'time_cancel' => 'cancelTime',
		];
		$a_data = [];
		if ($b_positive) {
			foreach ($a_param as $s_key => $u_val) {
				if (isset($a_field[$s_key])) {
					$a_data[$a_field[$s_key]] = $u_val;
				} else {
					$a_data[$s_key] = $u_val;
				}
			}
		} else {
			foreach ($a_param as $s_key => $u_val) {
				foreach ($a_field as $s_k => $s_v) {
					if ($s_key == $s_v) {
						$a_data[$s_k] = $u_val;
					} else {
						$a_data[$s_key] = $u_val;
					}
				}
			}
		}
		return $a_data;
	}
}
?>