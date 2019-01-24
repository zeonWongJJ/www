<?php
defined('BASEPATH') or exit('禁止访问！');

class Home_ctrl extends TW_Controller
{

    public function __construct()
    {
        parent:: __construct();
    }

    public function index()
    {
        $a_data = $this->db->get('notice', ['notice_state' => 1], '', ['notice_id' => 'desc'], 0, 5);
        $this->view->display('index', $a_data);
    }

    //新闻查看
    public function new_list()
    {
        $id     = $this->general->post('id');
        $a_data = $this->db->get_row('notice', ['notice_id' => $id]);
        echo json_encode(['code' => 200, 'data' => $a_data]);
        die;
    }

    public function download()
    {

        $this->view->display('download');
    }

    public function message()
    {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(1);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数，以产品为例
        $i_total = $this->db->get_total('notice', ['notice_state' => 1]);
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);
        $a_data['product'] = $this->db->get('notice', ['notice_state' => 1], '', ['notice_id' => 'desc']);
        $a_data['pages']   = $this->pages->link_style_one($this->router->url('message-', [], false, false));
        $this->view->display('message', $a_data);
    }

    public function serivecenter()
    {

        $this->view->display('seriveCenter');
    }
}
