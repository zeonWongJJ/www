<?php
defined('BASEPATH') OR exit('禁止访问！');

class Home_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('auth_model');
	}

	public function login()	{
		$this->auth_model->login();
	}

	public function logout() {
		$this->auth_model->logout();
	}
// 默认显示页面
	// public function waits() {
	// 	$this->view->display('wait');
	// }	

	public function index()	{
		$a_data = [];
		// 获取指定的分类
		$a_data['category'] = $this->db->get('pro', ['pro_pid' => '0', 'is_show' => '1']);
		$a_data['i_cate_curr'] = $this->router->get(1);
		if (empty($a_data['i_cate_curr'])) {
			$a_data['i_cate_curr'] = $a_data['category'][0]['pro_id'];
		}

		// 获取默认显示的产品
		if (isset($a_data['category'][0]['pro_id'])) {
			$this->load->model('product_model');

			// 先设置默认从第一页开始
			$i_page = $this->router->get(2);
			if (empty($i_page)) {
				$i_page = 1;
			}
			// 设置每页显示的数据行数
			$i_prow = 8;
			// 加载分页类
			$this->load->library('pages');
			// 获取数据总行数，以产品为例
			$i_total = $this->product_model->display($a_data['i_cate_curr'], true, 0, 9999999);
			// 调用分页运算函数
			$a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
			// 开始获取产品数据
			$a_data['product'] = $this->product_model->display($a_data['i_cate_curr'], false, $a_pdata['start'], $a_pdata['last']);
			// echo $this->db->get_sql();
			// print_r($a_data['product']);
			
			// 这里就是产品数据了，可以在模板里面循环出来
			//print_r($a_data['product']);
			// 这里是在模板输出分页链接，注意这里的URL末尾不能带.html，所以$this->router->url函数用了第四个参数，并且设置为false
			// 还需要注意URL后面会被自动加上分页码，所以需要传入一个参数分隔符“-”
			//echo $this->pages->link_style_one($this->router->url('index-', [], false, false));
		}


		// 加载客流统计接口类
		$this->load->library('passenger_flow');
		$a_data['passenger_flow'] = $this->passenger_flow->get_entity($_SESSION['store']['passenger_openid'], date('Y-m-d', $_SERVER['REQUEST_TIME']), date('Y-m-d', $_SERVER['REQUEST_TIME']));

		// 昨天、今天、本月订单数
		$i_time_yesterday = strtotime(date('Y-m-d', ($_SERVER['REQUEST_TIME'] - 86400)). ' 00:00:00');
		$i_time_today = strtotime(date('Y-m-d', $_SERVER['REQUEST_TIME']). ' 00:00:00');
		$i_time_month = strtotime(date('Y-m', $_SERVER['REQUEST_TIME']). '-01 00:00:00');
		$a_data['i_time_yesterday'] = $this->db->get_total('order', ['order_state >' => '0', 'time_create >' => $i_time_yesterday, 'time_create <' => $i_time_yesterday + 86400]);
		$a_data['i_time_today'] = $this->db->get_total('order', ['order_state >' => '0', 'time_create >' => $i_time_today, 'time_create <' => $i_time_today + 86400]);
		$a_data['i_time_month'] = $this->db->get_total('order', ['order_state >' => '0', 'time_create >' => $i_time_month, 'time_create <' => $_SERVER['REQUEST_TIME']]);

		// 传产品Id
		// 返回产品名称、类型、价格、数量、总价
		// print_r($a_data);exit;
		$this->view->display('index', $a_data);
	}

	public function store_meal() {
		$a_data = [];
		// 获取指定的分类
		$a_data['category'] = $this->db->get('pro', ['pro_pid' => '0', 'is_show' => '1']);
		$a_data['i_cate_curr'] = $this->router->get(1);
		if (empty($a_data['i_cate_curr'])) {
			$a_data['i_cate_curr'] = $a_data['category'][0]['pro_id'];
		}
		$a_goods = $this->router->get(2);
		// 加载客流统计接口类
		$this->load->library('passenger_flow');
		$a_data['passenger_flow'] = $this->passenger_flow->get_entity($_SESSION['store']['passenger_openid'], date('Y-m-d', $_SERVER['REQUEST_TIME']), date('Y-m-d', $_SERVER['REQUEST_TIME']));

		$a_wher = ['prod_show' => 1, 'pro_show' => 1, 'store_id' => $_SESSION['store_id'], 'a.product_id' => $a_goods];
        $a_slse = "b.supply_time,b.product_name,b.pro_details,b.pro_img,a.product_id,a.pro_stock,b.group_product,d.price,d.price_id";
        $a_data['meal'] = $this->db->from('prod_sto as a')
                                    ->join('price as d', ['a.product_id' => 'd.product_id'])
                                    ->join('product as b', ['a.product_id' => 'b.product_id'])
                                    ->get_row('', $a_wher, $a_slse);
        $a_data['prod']  = $this->db->from('product as a')
                                    ->join('comment_product as b', ['a.product_id' => 'b.product_id'])
                                    ->join('product_number as d', ['a.product_id' => 'd.product_id'])
                                    ->get('', ['a.pro_show' => 1], '', '', 0,9999999);
        //查询相对的时间   
        $a_data['time_name'] = $this->db->get('time');
        foreach ($a_data['time_name'] as $time) {
            $checkDayStr = date('Y-m-d',time());
            $startTime = strtotime($checkDayStr.$time['start_time'].":00");
            $endTime = strtotime($checkDayStr.$time['end_tiem'].":00");
            if($startTime <= time() && $endTime > time()) {
                $a_data['time'][] = $time['time_id'];
            }
        }   
        // 获取全部价格
        $a_data['pric'] = $this->db->limit(0, 9999999999)->get('price', ['price >' => 0], '', ['price' => 'asc']);
        //获取产品属性
        $a_data['att']  = $this->db->limit(0, 9999999999)->get('product_att');
        //获取属性
        $a_data['attr'] = $this->db->limit(0, 9999999999)->get('attributive');
		// 昨天、今天、本月订单数
		$i_time_yesterday = strtotime(date('Y-m-d', ($_SERVER['REQUEST_TIME'] - 86400)). ' 00:00:00');
		$i_time_today = strtotime(date('Y-m-d', $_SERVER['REQUEST_TIME']). ' 00:00:00');
		$i_time_month = strtotime(date('Y-m', $_SERVER['REQUEST_TIME']). '-01 00:00:00');
		$a_data['i_time_yesterday'] = $this->db->get_total('order', ['order_state >' => '0', 'time_create >' => $i_time_yesterday, 'time_create <' => $i_time_yesterday + 86400]);
		$a_data['i_time_today'] = $this->db->get_total('order', ['order_state >' => '0', 'time_create >' => $i_time_today, 'time_create <' => $i_time_today + 86400]);
		$a_data['i_time_month'] = $this->db->get_total('order', ['order_state >' => '0', 'time_create >' => $i_time_month, 'time_create <' => $_SERVER['REQUEST_TIME']]);
		$this->view->display('store_meal', $a_data);
	}

	// 验证钱箱密码
	public function moneybox_pswd() {
		$moneybox_pwd = trim($this->general->post('password'));
		$a_where = [
			'store_id' => $_SESSION['store_id']
		];
		$a_data = $this->db->get_row('store', $a_where);
		if ($a_data['moneybox_pwd'] == md5(md5($moneybox_pwd))) {
			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error']);
		}
	}
}
