<?php
namespace model;

/**
 * 用户模块
 */
class IndexModel extends \TW_Model{
	public function __construct(){
        parent :: __construct();
        $this->tw=$this->db->get_prefix();
    }

	//分类递归
	public function gettree($data, $pid = 1210){
		$arr = array();
		foreach($data as $key => $v){
			if ($v['gc_parent_id'] == $pid){
				$v['child'] = $this->gettree($data, $v['gc_id']);
				$arr[] = $v;
			}
		}
		return $arr;
	}

	//查询出分类
	public function category(){
		$a_field = "gc_id,gc_name,gc_parent_id";
		$a_data = $this->db->get('goods_class', '', $a_field);
		$a_data = $this->gettree($a_data);
		return $a_data;
	}

	/*
	* 	1、对分类中第四分类进行数组数组，并将数组装进第三分类中
	*  	2、拼装方式
	*   2.1、命名数组
	*   2.2、在$a_data数组中，键名为第三分类的名称，值为需要装进去的数组
	*/
	public function arr($a_res){
		//二级分类第一个
		$one1 = array(
				'0' => '维生素e',
				'1' => '胶原蛋白',
				'2' => '葡萄籽'
			);
		$one2 = array(
				'0' => '胶原蚕丝蛋白',
				'1' => '天然维生素E'
			);
		$one3 = array(
				'0' => '左旋肉碱',
				'1' => '减肥茶',
				'2' => '膳食纤维'
			);
		$one4 = array(
				'0' => '大豆异黄酮',
				'1' => '维生素E',
				'2' => '胶原蛋白粉'
			);
		$one5 = array(
				'0' => '胶原蛋白',
				'1' => '芦荟软胶囊',
				'2' => '葡萄籽'
			);
		$one6 = array(
				'0' => '叶酸铁片',
				'1' => '维生素'
			);
		$one7 = array(
				'0' => '综合营养片',
				'1' => '大豆异黄酮'
			);

		//二级分类第二个
		$two1 = array(
				'0' => '秘鲁玛咖',
				'1' => '美贝健海狗丸',
				'2' => '澳洲袋鼠精'
			);
		$two2 = array(
				'0' => '卵磷脂颗粒',
				'1' => '奶蓟提取物软胶囊',
				'2' => '解酒软胶囊'
			);
		$two3 = array(
				'0' => '健睡宝褪黑素片',
				'1' => '天麻软胶囊',
				'2' => '缬草根提取物胶囊'
			);
		$two4 = array(
				'0' => '益盛软胶囊',
				'1' => '海狗人参丸',
				'2' => '玛咖酋长'
			);
		$two5 = array(
				'0' => '芦荟软胶囊',
				'1' => '芦荟软胶囊',
				'2' => '膳食纤维营养胶囊'
			);
		$thrid1 = array(
				'0' => 'DHA软胶囊30粒',
				'1' => '磷脂酰丝氨酸软胶囊',
				'2' => '儿童水果口味软糖'
			);
		$thrid2 = array(
				'0' => '果蔬综合营养咀嚼片',
				'1' => '铁锌钙咀嚼片',
				'2' => '柑橘提取物复合片'
			);
		$thrid3 = array(
				'0' => '胡萝卜素软胶囊',
				'1' => '叶黄素浓缩复合胶囊',
				'2' => '儿童鱼油软胶囊'
			);
		$thrid4 = array(
				'0' => '牛初乳咀嚼片',
				'1' => 'DHA软胶囊',
				'2' => '多维多矿颗粒'
			);
		$thrid5 = array(
				'0' => '儿童水果口味咀嚼片',
				'1' => '乳铁蛋白粉',
				'2' => '成长发育咀嚼片'
			);
		$four1 = array(
				'0' => '辅酶Q10',
				'1' => '银螺胶囊',
				'2' => '蓝莓提取物软胶囊'
			);
		$four2 = array(
				'0' => '深海鱼油软胶囊',
				'1' => '无味蒜精软胶囊',
				'2' => '亚麻籽油软胶囊'
			);
		$four3 = array(
				'0' => '奶蓟提取物软胶囊',
				'1' => '小麦胚芽油软胶囊',
				'2' => '深海鱼油胶囊'
			);
		$four4 = array(
				'0' => '铁锌钙咀嚼片',
				'1' => '鱼油软胶囊'
			);
		$four5 = array(
				'0' => '春眠胶囊',
				'1' => '复合氨基酸营养片'
			);
		$five1 = array(
				'0' => '褪黑素片',
				'1' => '春眠胶囊'
			);
		$five2 = array(
				'0' => '蓝莓提取物软胶囊',
				'1' => '胡萝卜素软胶囊'
			);
		$five3 = array(
				'0' => '芦荟软胶囊',
				'1' => '膳食纤维营养胶囊'
			);
		$five4 = array(
				'0' => '螺旋藻片'
			);
		$five5 = array(
				'0' => '泡泡消1号'
			);


		//三级分类下面的数组
		$a_data = array(
			'美白祛斑' => $one1,
			'丰胸美乳' => $one2,
			'减肥瘦身' => $one3,
			'延缓衰老' => $one4,
			'排毒养颜' => $one5,
			'孕期营养' => $one6,
			'补血养血' => $one7,
			'补肾强身' => $two1,
			'解酒护肝' => $two2,
			'熬夜焦虑' => $two3,
			'性腺养护' => $two4,
			'男性护肤' => $two5,
			'益智健脑' => $thrid1,
			'促进发育' => $thrid2,
			'预防近视' => $thrid3,
			'增强免疫力' => $thrid4,
			'儿童维生素' => $thrid5,
			'心脑养护' => $four1,
			'调节三高' => $four2,
			'养肝护肝' => $four3,
			'骨质疏松' => $four4,
			'改善记忆' => $four5,
			'改善睡眠' => $five1,
			'护眼明目' => $five2,
			'润肠通便' => $five3,
			'防辐抗癌' => $five4,
			'缓解疲劳' => $five5
			);

		//将需要数组装进数组中
		foreach($a_res as $key => $value){
			foreach($value['child'] as $k => $v){
				$a_res[$key]['child'][$k]['son'] = $a_data[$v['gc_name']];
			}
		}
		return $a_res;
	}

	//获取用户的信息
	public function index_userinfo() {
		$a_where = ['member_id' => $_SESSION['user_id']];
		$s_field = 'member_name, member_avatar, member_time_old_login, member_points, available_predeposit, available_rc_balance, member_email, member_mobile,member_passwd';
		$a_data = $this->db->get_row('member', $a_where, $s_field);

		$i=0;
		if ( $a_data['member_email'] ){
			$i++;
		}
		if ( $a_data['member_mobile'] ){
			$i++;
		}
		if ( $a_data['member_passwd'] ){
			$i++;
		}
		if ( $a_data['member_name'] ){
			$i++;
		}


		$a_data['safe']=$i;
		return $a_data;
	}

	//订单详情
	public function index_order() {
		// unset($_SESSION['user_id']);
		$a_where = [$this->tw.'order.buyer_id' => $_SESSION['user_id']];
		$s_field = 'order_sn, order_amount, order_state,sum(goods_num) as sum, goods_image, evaluation_state, '.$this->tw.'order.order_id, '.$this->tw.'order.store_id';
		$a_order = ['time_create' => 'desc'];
		$a_data = $this->db->from('order')
						->join('order_goods', [$this->tw.'order.order_id' => $this->tw.'order_goods.order_id'],INNER)
						->where($a_where)
						->select($s_field, false)
						->order_by($a_order)
						->limit(0,5)
						->group_by('order_sn')
						->get();
		return $a_data;
	}

	//计算订单状态1、默认(未付款)，2、已付款，3、已发货，4、已收货
	public function index_order_state() {
		$s_fields='order_state,count(1) as num';
		$s_group_by='order_state';
		$a_where=['buyer_id'=>$_SESSION['user_id']];

		$a_data_result=$this->db->from('order')
				 	   ->select($s_fields,false)
				 	   ->group_by($s_group_by)
				       ->get('', $a_where);

		foreach($a_data_result as $key=>$value){
			$a_result[$value['order_state']]=$value['num'];
		}

		$a_data['stateOne'] = isset($a_result['10']) ? intval($a_result['10']) : 0;
		$a_data['stateTwo'] = isset($a_result['20']) ? intval($a_result['20']) : 0;
		$a_data['stateThree'] = isset($a_result['30']) ? intval($a_result['30']) : 0;
		$a_data['stateFour'] = isset($a_result['40']) ? intval($a_result['40']) : 0;

		return $a_data;
	}

	//安全等级
	public function safe($s_email, $s_mobile, $s_passwd) {
		if (! empty($s_email) && ! empty($s_mobile) && ! empty($s_passwd)) {
			return $s_order = '高';
		} else if (( ! empty($s_email) || ! empty($s_mobile))  || ( ! empty($s_mobile) || ! empty($s_passwd)) || ( ! empty($s_email) || ! empty($s_passwd))) {
			return $s_order = '中';
		} else {
			return $s_order = '低';
		}
	}

	//获取余额记录
	public function balance($s_while=null) {
		$s_while = $this->router->get(1) ? $this->router->get(1) : 0;

		//获取收入支出时间
		if ($s_while == 1) {
			$s_while_start = strtotime('2017-1-1');
			$s_while_end   = $_SERVER['REQUEST_TIME'];
		} else if ($s_while == 2) {
			$s_while_start = strtotime('2016-1-1');
			$s_while_end   = strtotime('2017-1-1');
		} else if ($s_while == 3) {
			$s_while_start = strtotime('2015-1-1');
			$s_while_end   = strtotime('2016-1-1');
		} else if ($s_while == 4) {
			$s_while_start = strtotime('2014-1-1');
			$s_while_end   = strtotime('2015-1-1');
		} else if ($s_while == 5) {
			$s_while_start = strtotime('1970-1-1');
			$s_while_end   = strtotime('2014-1-1');
		}

		// 获取三个月前时间戳
		if( ! empty($s_while_start) && ! empty($s_while_start)) {
			$a_where = ['lg_member_id' => $_SESSION['user_id'], 'lg_add_time >' => $s_while_start, 'lg_add_time <' => $s_while_end];
		} else {
			// $i_stamp = $_SERVER['REQUEST_TIME'] - 7776000;
			$a_where = ['lg_member_id' => $_SESSION['user_id'], 'lg_add_time <' => $_SERVER['REQUEST_TIME']];
		}
		//查询出预存表中消费的内容
		$a_where_in = ['lg_type' => 'order_pay', 'lg_type' => 'recharge', 'lg_type' => 'cash_pay'];
		$s_field = 'lg_desc, lg_av_amount, lg_add_time, lg_type';
		$a_order = ['lg_add_time' => 'desc'];

		//获取参数
		$i_page = $this->router->get(2);
		empty($i_page) ? $i_page = 1 : $i_page;

		//实例化分页类
		$this->load->library('pages');

		//获取数据的总函数
		$i_total = $this->db->where($a_where)
                            ->group_start('AND')
                            ->where_in('lg_type',['order_pay', 'recharge', 'cash_pay'])
                            ->group_end()
						    ->get_total('pd_log');

		//调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, 10);
		$this->db->limit($a_pdata['start'], $a_pdata['last']);

		//显示数据
		$a_pd_log_data['thre'] = $this->db->where($a_where)
		                          ->group_start('AND')
		                          ->where_in('lg_type', ['order_pay', 'recharge', 'cash_pay'])
		                          ->group_end()
		                          ->get('pd_log', NULL, '', $a_order);
	     // echo $this->db->get_sql();
		//分页
		$a_pd_log_data['page'] = $this->pages->link_style_one($this->router->url('money-' . $s_while . '-', [], false,false));
		// 主要用来查出描述字段的订单号
		$s_order_field = 'order_sn, goods_name, order_state, evaluation_state';
		foreach ($a_pd_log_data['thre'] as $key => $s_value) {
			$s_value = substr_replace($s_value['lg_desc'],  '', 0, -16);
			$a_data = $this->db->from('order')
					 ->join('order_goods', [$this->tw.'order.order_id' => $this->tw.'order_goods.order_id'])
					 ->get('', ['order_sn' => $s_value],$s_order_field);
	   		$a_pd_log_data['thre'][$key]['order_sn']=$a_data[$key]['order_sn'];
	   		$a_pd_log_data['thre'][$key]['goods_name']=$a_data[$key]['goods_name'];
	   		$a_pd_log_data['thre'][$key]['order_state']=$a_data[$key]['order_state'];
		}
		return $a_pd_log_data;
	}

	//获取消费记录
	public function consume() {
		//获取参数
		$s_while = $this->router->get(1) ? $this->router->get(1) : 0;
		//获取收入支出时间
		if ($s_while == 1) {
			$s_while_start = strtotime('2017-1-1');
			$s_while_end   = $_SERVER['REQUEST_TIME'];
		} else if ($s_while == 2) {
			$s_while_start = strtotime('2016-1-1');
			$s_while_end   = strtotime('2017-1-1');
		} else if ($s_while == 3) {
			$s_while_start = strtotime('2015-1-1');
			$s_while_end   = strtotime('2016-1-1');
		} else if ($s_while == 4) {
			$s_while_start = strtotime('2014-1-1');
			$s_while_end   = strtotime('2015-1-1');
		} else if ($s_while == 5) {
			$s_while_start = strtotime('1970-1-1');
			$s_while_end   = strtotime('2014-1-1');
		}

		// 获取三个月前时间戳
		if( ! empty($s_while_start) && ! empty($s_while_start)) {
			$a_where = ['lg_member_id' => $_SESSION['user_id'], 'lg_add_time >' => $s_while_start, 'lg_add_time <' => $s_while_end, 'lg_type' => 'order_pay'];
		} else {
			// $i_stamp = $_SERVER['REQUEST_TIME'] - 7776000;
			$a_where = ['lg_member_id' => $_SESSION['user_id'], 'lg_add_time <' => $_SERVER['REQUEST_TIME'], 'lg_type' => 'order_pay'];
		}

		//查询出预存表中消费的内容
		$s_field = 'lg_desc, lg_av_amount, lg_add_time';
		$a_order = ['lg_add_time' => 'desc'];

		//获取参数
		$i_page = $this->router->get(2);
		empty($i_page)?$i_page = 1:$i_page;

		//实例化分页类
		$this->load->library('pages');

		//获取数据的总函数
		$i_total = $this->db->get_total('pd_log', $a_where);

		//调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, 10);
		$this->db->limit($a_pdata['start'], $a_pdata['last']);

		//显示数据
		$a_pd_log_data['thre'] = $this->db->get('pd_log', $a_where, $s_field, $a_order);
		// echo $this->db->get_sql();

		//分页
		$a_pd_log_data['page'] = $this->pages->link_style_one($this->router->url('consume-' . $s_while . '-', [], false,false));

		$s_order_field = 'order_sn, goods_name, order_state, evaluation_state';
		foreach ($a_pd_log_data['thre'] as $key => $s_value) {
			$s_value = substr_replace($s_value['lg_desc'],  '', 0, -16);
			$a_data = $this->db->from('order')
					 ->join('order_goods', [$this->tw.'order.order_id' => $this->tw.'order_goods.order_id'])
					 ->get('', ['order_sn' => $s_value], $s_order_field);
	   		$a_pd_log_data['thre'][$key]['order_sn']=$a_data[$key]['order_sn'];
	   		$a_pd_log_data['thre'][$key]['goods_name']=$a_data[$key]['goods_name'];
	   		$a_pd_log_data['thre'][$key]['order_state']=$a_data[$key]['order_state'];
		}
		return $a_pd_log_data;
	}

	//获取充值记录
	public function recharge() {
		//获取参数
		$s_while = $this->router->get(1) ? $this->router->get(1) : 0;

		//获取收入支出时间
		if ($s_while == 1) {
			$s_while_start = strtotime('2017-1-1');
			$s_while_end   = $_SERVER['REQUEST_TIME'];
		} else if ($s_while == 2) {
			$s_while_start = strtotime('2016-1-1');
			$s_while_end   = strtotime('2017-1-1');
		} else if ($s_while == 3) {
			$s_while_start = strtotime('2015-1-1');
			$s_while_end   = strtotime('2016-1-1');
		} else if ($s_while == 4) {
			$s_while_start = strtotime('2014-1-1');
			$s_while_end   = strtotime('2015-1-1');
		} else if ($s_while == 5) {
			$s_while_start = strtotime('1970-1-1');
			$s_while_end   = strtotime('2014-1-1');
		}

		// 获取三个月前时间戳
		if( ! empty($s_while_start) && ! empty($s_while_start)) {
			$a_where = ['pdr_member_id' => $_SESSION['user_id'], 'pdr_add_time >' => $s_while_start, 'pdr_add_time <' => $s_while_end];
		} else {
			// $i_stamp = $_SERVER['REQUEST_TIME'] - 7776000;
			$a_where = ['pdr_member_id' => $_SESSION['user_id'], 'pdr_add_time <' => $_SERVER['REQUEST_TIME']];
		}

		$s_field = 'pdr_amount, pdr_payment_name, pdr_add_time, pdr_payment_time, pdr_payment_state';
		$a_order = ['pdr_add_time' => 'desc'];



		//获取参数
		$i_page = $this->router->get(2);
		empty($i_page) ? $i_page = 1 : $i_page;

		//实例化分页类
		$this->load->library('pages');

		//获取数据的总函数
		$i_total = $this->db->get_total('pd_recharge', $a_where);

		//调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, 10);
		$this->db->limit($a_pdata['start'], $a_pdata['last']);

		//显示数据
		$a_data['thre'] = $a_data = $this->db->get('pd_recharge', $a_where, $s_field, $a_order);
		//分页
		$a_data['page'] = $this->pages->link_style_one($this->router->url('recharge-' . $s_while . '-', [], false, false));
		return $a_data;
	}

	//获取提现记录
	public function deposit() {
		//获取参数
		$s_while = $this->router->get(1) ? $this->router->get(1) : 0;

		//获取收入支出时间
		if ($s_while == 1) {
			$s_while_start = strtotime('2017-1-1');
			$s_while_end   = $_SERVER['REQUEST_TIME'];
		} else if ($s_while == 2) {
			$s_while_start = strtotime('2016-1-1');
			$s_while_end   = strtotime('2017-1-1');
		} else if ($s_while == 3) {
			$s_while_start = strtotime('2015-1-1');
			$s_while_end   = strtotime('2016-1-1');
		} else if ($s_while == 4) {
			$s_while_start = strtotime('2014-1-1');
			$s_while_end   = strtotime('2015-1-1');
		} else if ($s_while == 5) {
			$s_while_start = strtotime('1970-1-1');
			$s_while_end   = strtotime('2014-1-1');
		}

		// 获取三个月前时间戳
		if( ! empty($s_while_start) && ! empty($s_while_start)) {
			$a_where = ['pdc_member_id' => $_SESSION['user_id'], 'pdc_time_create >' => $s_while_start, 'pdc_time_create <' => $s_while_end];
		} else {
			// $i_stamp = $_SERVER['REQUEST_TIME'] - 7776000;
			// $a_where = ['pdc_member_id' => $_SESSION['user_id'], 'pdc_time_create >' => $i_stamp];
			$a_where = ['pdc_member_id' => $_SESSION['user_id'], 'pdc_time_create <' => $_SERVER['REQUEST_TIME']];
		}

		//条件
		$s_field = 'pdc_amount, pdc_time_create, pdc_payment_time, pdc_payment_state, pdc_bank_name';
		$a_order = ['pdc_time_create' => 'desc'];

		//获取参数
		$i_page = $this->router->get(2);
		empty($i_page) ? $i_page = 1 : $i_page;

		//实例化分页类
		$this->load->library('pages');

		//获取数据的总函数
		$i_total = $this->db->get_total('pd_cash', $a_where);

		//调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, 10);
		$this->db->limit($a_pdata['start'], $a_pdata['last']);

		//显示数据
		$a_data['thre'] = $a_data = $this->db->get('pd_cash', $a_where, $s_field, $a_order);

		//分页
		$a_data['page'] = $this->pages->link_style_one($this->router->url('deposit-' . $s_while . '-', [], false, false));
		return $a_data;
	}

	//获取代金券总数
	public function voucher() {
		$a_where = ['voucher_owner_id' => $_SESSION['user_id']];
		$a_data = $this->db->get_total('voucher', $a_where);
		return $a_data;
	}

	//获取评价的信息
	public function evaluate() {
		//条件
		$a_where = ['geval_frommemberid' => $_SESSION['user_id']];
		$s_field = 'geval_goodsimage, geval_scores, geval_image, geval_content, geval_time_create, geval_storename, geval_storeid, geval_remark, store_label, geval_goodsid';
		$a_order = ['geval_time_create' => 'desc'];

		//获取参数
		$i_page = $this->router->get(1);
		empty($i_page)?$i_page = 1:$i_page;

		//实例化分页类
		$this->load->library('pages');

		//获取数据的总函数
		$i_total = $this->db->from('evaluate_goods')
						   ->join('store', [$this->tw.'evaluate_goods.geval_storeid' => $this->tw.'store.store_id'])
						   ->get_total('', $a_where);

		//调用分页运算函数
		$a_pdata = $this->pages->get($i_total, $i_page, 5);
		$this->db->limit($a_pdata['start'], $a_pdata['last']);
		$a_data['thre'] = $this->db->from('evaluate_goods')
								   ->join('store', [$this->tw.'evaluate_goods.geval_storeid' => $this->tw.'store.store_id'])
								   ->get('', $a_where, $s_field, $a_order);

		//处理图片
		foreach ($a_data['thre'] as $key => $value) {
			$a_data['thre'][$key]['geval_image'] = explode(',', $value['geval_image']);
		}
		$a_data['page'] = $this->pages->link_style_one($this->router->url('evaluation-', [], false, false));
		return $a_data;
	}

}

?>
