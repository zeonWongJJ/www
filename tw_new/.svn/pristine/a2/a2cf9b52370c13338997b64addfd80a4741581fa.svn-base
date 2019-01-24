<?php
defined('BASEPATH') OR exit('禁止访问！');

/**
 * 本配送系统的结构：
 1. 接口访问：Api_ctrl.php
 2. 配送公司订单任务分发：Distribute_model.php
 3. 各个配送公司的业务逻辑处理由各自独立的MODEL来完成，如达达的是：Dada_model.php
 4. 订单的相关处理：Order_model.php
 注意事项：
 1. 增加其他配送公司时，需要注意字段名的转换，以及model中的函数命名需要一致（参考Dada_model.php）
*/

class Home_ctrl extends TW_Controller {
	public function __construct() {
		parent :: __construct();
	}
	
	/**
	添加订单举例，返回json格式
	status_code 添加结果状态码说明：
	10000 订单提交成功
	10001 订单保存失败
	#（这是老版本，请参考下方新版本的说明）10002 订单提交成功，但是发布到第三方配送失败，系统会自动尝试重新发布，请稍后查询（不能保障一定会发布成功）
	10002 订单提交成功，但是发布到第三方配送失败。请检查参数重新提交，老版本计划是在发布失败之后，尝试重新发布，但是我们认为这是不合理的，
	  因为第一次的失败，很可能是因为参数或其他方面存在问题，一味的尝试重新发布，不旦不能解决问题，还会延误问题的发现时机，所以遇到此错误，请立即检查和修正问题，并重新提交订单，重新提交的订单可以保持和之前的订单ID一致。
	*/
	public function add() {
		$a_data = array(
			// 门店编号
			'shop_id'=> '11047059',
			// 订单ID
			'order_id'=> date('Ymd') . rand(100, 999),
			// 订单所在城市的代码，可通过city_list函数获取所有城市代码
			'city_code'=> '020',
			// 订单金额
			'order_price' => '100',
			// 是否需要垫付 1:是 0:否 (垫付订单金额，非运费)
			'is_prepay' => '0',
			// 期望取货时间（1.时间戳,以秒计算时间，即unix-timestamp; 2.该字段的设定，不会影响达达正常取货; 3.订单待接单时,该时间往后推半小时后，会自动被系统取消;4.建议取值为当前时间往后推10~15分钟）
			'expected_fetch_time' => $_SERVER['REQUEST_TIME'] + 600,
			// 	收货人姓名
			'receiver_name' => '老王',
			// 收货人地址
			'receiver_address' => '隔壁',
			// 收货人地址经度（高德坐标系）
			'receiver_longitude' => '113.320906',
			// 收货人地址维度（高德坐标系）
			'receiver_latitude' => '22.967019',
			// 回调地址
			'callback' => $this->router->url('notify'),
			// 收货人手机号（手机号和座机号必填一项）
			'receiver_phone' => '13800000000',
			// 收货人座机号（手机号和座机号必填一项）
			'receiver_tel' => '',
			//=========== 下方为选填项 =============//
			/*// 小费
			'fee' => 0.0,
			// 订单备注
			'message' => '',
			// 订单商品类型：食品小吃-1,饮料-2,鲜花-3,文印票务-8,便利店-9,水果生鲜-13,同城电商-19, 医药-20,蛋糕-21,酒品-24,小商品市场-25,服装-26,汽修零配-27,数码-28,小龙虾-29, 其他-5
			'order_type' => '',
			// 订单重量（单位：Kg）
			'goods_weight' => '',
			// 订单商品数量
			'goods_num' => '',
			// 发票抬头
			'invoice_title' => '',
			// 送货开箱码
			'deliver_locker_code' => '',
			// 取货开箱码
			'pickup_locker_code' => '',
			// 订单来源标示（该字段可以显示在达达app订单详情页面，只支持字母，最大长度为10）
			'order_mark' => '',
			// 订单来源编号（该字段可以显示在达达app订单详情页面，支持字母和数字，最大长度为30）
			'order_mark_no' => '',
			// 商品保价费(当商品出现损坏，可获取一定金额的赔付)保价费分三挡：分别为1元，3元，5元。1元保价：最高可获取100元赔付。3元保价：最高可获取300元赔付。5元保价：最高可获取1000元赔付。
			'insurance_fee' => '',
			// 收货码（0：不需要；1：需要。收货码的作用是：骑手必须输入收货码才能完成订单妥投）
			'is_finish_code_needed' => ''*/
		);
		$s_result = $this->general->request('http://distribution.7dugo.com/add.html', $a_data);
		$a_result = json_decode($s_result, true);
		print_r($a_result);
	}
	
	/**
	查询订单举例，返回json格式
	map_code_head 为地图代码，需要放到模板html代码的head位置
	map_code_body 为地图代码，需要放到模板html代码的body位置
	
	status 订单状态码说明：
	#（这是老版本，请参考下方新版本的说明）0 表示订单发布失败（也就是没能成功在第三方配送平台发布），系统会自动尝试重新发布，请稍后查询（不能保障一定会发布成功）
	0 表示订单发布失败，请检查参数重新提交，老版本计划是在发布失败之后，尝试重新发布，但是我们认为这是不合理的，
	  因为第一次的失败，很可能是因为参数或其他方面存在问题，一味的尝试重新发布，不旦不能解决问题，还会延误问题的发现时机，所以遇到此错误，请立即检查和修正问题，并重新提交订单，重新提交的订单可以保持和之前的订单ID一致。
	10 表示订单提单成功
	20 表示订单已被接
	30 表示订单配送中（已有配送员接单）
	40 表示订单已送达
	50 表示已取消
	60 表示已过期，系统会自动尝试重新发布，请稍后查询
	70 表示指派单
	80 表示送货失败，物品返回中
	85 表示送货失败，物品返回成功
	
	status_code 查询结果状态码说明：
	20000 数据成功返回
	20001 订单不存在
	*/
	public function query() {
		$a_data = [
			// 必传，订单ID
			'order_id' => 20180117483,
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
		$s_result = $this->general->request('http://distribution.7dugo.com/query.html', $a_data);
		$a_result = json_decode($s_result, true);
		print_r($a_result);
	}
	
	/**
	查询订单举例，返回json格式
	
	reason_id参数，取消原因ID说明：
	10 没有配送员接单
	20 配送员没来取货
	30 配送员态度太差
	40 顾客取消订单
	50 订单填写错误
	110 配送员让我取消此单
	120 配送员不愿上门取货
	130 我不需要配送了
	140 配送员以各种理由表示无法完成订单
	210 其他原因
	
	status_code 取消结果状态码说明：
	30000 订单取消成功
	30001 订单不存在
	30002 订单未提交成功，不需要取消
	30003 订单已经取消，不需要重复取消
	30004 订单已经开始配送
	30005 订单取消失败。比如此订单在10个配送平台发布了订单，取消订单时，只有5个配送平台成功取消订单，也会返回此状态码
	30006 此订单当前没有在第三方配送平台提交配送订单
	*/
	public function cancel() {
		$a_data = ['order_id' => 20180110919, 'reason_id' => 10];
		$s_result = $this->general->request('http://distribution.7dugo.com/cancel.html', $a_data);
		$a_result = json_decode($s_result, true);
		print_r($a_result);
	}
	
	// 调试用
	public function index() {
		$s_sing = '{"order_status":2,"cancel_reason":"","update_time":1516331580,"cancel_from":0,"dm_id":666,"signature":"1dfd0d4618b7ab150c9bd0145014854e","dm_name":"测试达达","order_id":"2017121816661513585532","client_id":"271530126481159","dm_mobile":"13546670420"}';
		$this->load->library('distribution_dada');

print_r($this->distribution_dada->signature($s_sing));
exit;
		/*$this->load->library('distribution_dada');
		$this->load->model('dada_model');
		$this->dada_model->expire(20180115880);
		$a_result = $this->distribution_dada->get_result();
		print_r($a_result);exit;
		$a_data = $this->db->get_row('order', ['id_trade' => 20180115880]);
		$a_post = json_decode($a_data['trade_param'], true);
		
		$a_post = $this->dada_model->_field_conversion($a_post);
		$this->distribution_dada->readd_order($a_post);
		$a_result = $this->distribution_dada->get_result();
		print_r($a_result);
		exit;*/

		$this->load->library('distribution_dada');
		// analog_receive analog_fetch analog_finish analog_cancel analog_expire
		echo $this->distribution_dada->analog_receive(['order_id' => '2017121816661513585532', 'reason' => '可选参数，取消原因说明']) ? '成功' : '失败';
		//print_r($this->distribution_dada->query(['order_id' => '20180118659']));
		//$this->query();
		
		exit;
		/*$a = $this->general->request('http://www.7dugo.com');
		print_r($a);
		$a_data = ['order_id' => '2018010403'];
		$this->load->library('distribution_dada');
		$a_result = $this->distribution_dada->query($a_data);
		$a_result['result']['transporterLng'] = 113.33343;
		$a_result['result']['transporterLat'] = 22.96336;
		$a_result['result']['transporterName'] = '张三';
		$a_result['result']['transporterPhone'] = '12345678901';
		//print_r($a_result);
		$a = json_encode($a_result);
		//echo $this->db->update('order', ['distribution_dada' => $a], ['id_trade' => '2018010403']);
		//echo $this->db->get_sql();*/
		//exit;
		
		$a_data = array(
			// 门店编号
			'shop_id'=> '11047059',
			// 订单ID
			'order_id'=> date('Ymd') . rand(100, 999),
			// 订单所在城市的代码，可通过city_list函数获取所有城市代码
			'city_code'=> '020',
			// 订单金额
			'order_price' => '97',
			// 是否需要垫付 1:是 0:否 (垫付订单金额，非运费)
			'is_prepay' => '0',
			// 期望取货时间（1.时间戳,以秒计算时间，即unix-timestamp; 2.该字段的设定，不会影响达达正常取货; 3.订单待接单时,该时间往后推半小时后，会自动被系统取消;4.建议取值为当前时间往后推10~15分钟）
			'expected_fetch_time' => $_SERVER['REQUEST_TIME'] + 600,
			// 	收货人姓名
			'receiver_name' => '老王',
			// 收货人地址
			'receiver_address' => '隔壁',
			// 收货人地址经度（高德坐标系）
			'receiver_longitude' => '113.320906',
			// 收货人地址维度（高德坐标系）
			'receiver_latitude' => '22.967019',
			// 回调地址
			'callback' => 'http://distribution.7dugo.com/notify_dada.html',
			// 收货人手机号（手机号和座机号必填一项）
			'receiver_phone' => '13800000000',
			// 收货人座机号（手机号和座机号必填一项）
			'receiver_tel' => '',
			//=========== 下方为选填项 =============//
			/*// 小费
			'fee' => 0.0,
			// 订单备注
			'message' => '',
			// 订单商品类型：食品小吃-1,饮料-2,鲜花-3,文印票务-8,便利店-9,水果生鲜-13,同城电商-19, 医药-20,蛋糕-21,酒品-24,小商品市场-25,服装-26,汽修零配-27,数码-28,小龙虾-29, 其他-5
			'order_type' => '',
			// 订单重量（单位：Kg）
			'goods_weight' => '',
			// 订单商品数量
			'goods_num' => '',
			// 发票抬头
			'invoice_title' => '',
			// 送货开箱码
			'deliver_locker_code' => '',
			// 取货开箱码
			'pickup_locker_code' => '',
			// 订单来源标示（该字段可以显示在达达app订单详情页面，只支持字母，最大长度为10）
			'order_mark' => '',
			// 订单来源编号（该字段可以显示在达达app订单详情页面，支持字母和数字，最大长度为30）
			'order_mark_no' => '',
			// 商品保价费(当商品出现损坏，可获取一定金额的赔付)保价费分三挡：分别为1元，3元，5元。1元保价：最高可获取100元赔付。3元保价：最高可获取300元赔付。5元保价：最高可获取1000元赔付。
			'insurance_fee' => '',
			// 收货码（0：不需要；1：需要。收货码的作用是：骑手必须输入收货码才能完成订单妥投）
			'is_finish_code_needed' => ''*/
		);
		//$this->load->model('dada_model');
		//$this->dada_model->add($a_data);
		//exit();
		$s_result = $this->general->request('http://distribution.7dugo.com/add.html', $a_data);
		$a_result = json_decode($s_result, true);
		print_r($a_result);
	}
}