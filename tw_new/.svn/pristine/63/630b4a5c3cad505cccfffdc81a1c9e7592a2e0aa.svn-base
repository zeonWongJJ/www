<?php
date_default_timezone_set('PRC');

class Home_ctrl extends TW_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('home_model');
    }

    public function index()
    {
        if (empty($_SESSION['admin_id'])) {
            $this->error->show_error('请先登录', 'login', '', 0);
        }
        $a_data                = $this->db->get_row('role', ['role_id' => $_SESSION['role_id']]);
        $_SESSION['role_name'] = $a_data['role_name'];
        //公告
        $a_data['notice'] = $this->db->get('notice', '', '', ['notice_id' => 'desc'], 0, 6);
        //总订单
        $a_data['order'] = $this->home_model->order_total();
        //总销售额
        $a_data['sales'] = $this->home_model->sales();
        //总用户
        $a_data['user'] = $this->db->get_total('user');
        //总门店
        $a_data['store'] = $this->db->get_total('store');
        //总店主
        $a_data['shopman'] = $this->db->get_total('user', ['is_shopman' => 1]);
        // 日销售额和日订单
//		$a_forehead = $this->db->get('consumabel_sales', ['daily_time' => mktime(0,0,0,date('m'),date('d'),date('Y'))]);
        $a_today = $this->home_model->today_order();
//        var_dump($a_today);exit;
//		foreach ($a_forehead as $forehead) {
//			$a_data['daily_order'] += $forehead['daily_order'];
//			$a_data['daily_sales'] += $forehead['daily_sales'];
//		}
        $a_data['daily_order'] = $a_today['order_price'];
        $a_data['daily_sales'] = $a_today['count'];
        $a_data['yue']         = $this->home_model->yuezezhan();
        $this->view->display('index', $a_data);
    }

    // 消息提示数
    public function oute()
    {
        $i_oute = $this->db->get_total('messagess', ['ues' => 1, 'examine' => 1]);
        echo json_encode(['stur' => 50, 'data' => $i_oute]);
        die;
    }

    // 消息查看
    public function messages_showlist()
    {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(1);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 1;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $a_data_count = $this->db->query("SELECT count(*) as total, group_concat(mess_id) as ids, from_unixtime(mess_time,'%Y%m%d') as day from '.$this->db->get_prefix().'messagess WHERE `ues` = '1' group by day order by day desc");
        $i_total      = 0;
        foreach ($a_data_count as $key => $value) {
            $i_total++;
        }
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $a_data['get'] = $this->db->query("SELECT count(*) as total, group_concat(mess_id) as ids, from_unixtime(mess_time,'%Y%m%d') as day from '.$this->db->get_prefix().'messagess WHERE `ues` = '1' group by day order by day desc limit " . ($i_page - 1) * $i_prow . ',' . $i_prow);
        // echo $this->db->get_sql();
        $a_data['messg'] = $this->db->get('messagess', ['ues' => 1], '', ['mess_id' => 'desc'], 0, 9999999999999);
        $a_data['getr']  = $this->db->get_total('messagess', ['ues' => 1]);
        $up_data         = $this->db->update('messagess', ['examine' => 2], ['ues' => 1]);
        $this->view->display('messages_showlist', $a_data);
    }

}
