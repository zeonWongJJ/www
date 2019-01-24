<?php
class List_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
	}

	//产品列表
	public function list() {
		$a_data = $this->db->get('product', [], '', [], 0, 10);
		$this->view->display('list', $a_data);
	}

	//获取更多
	public function list_up() {
        // 先设置默认从第一页开始
        $i_page = $this->general->post('page');
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 10;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $i_total = $this->db->get_total('product');
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);
        //总页数
        $page_total = ceil($i_total/$i_prow);
        //判断是否超过总页数
        if ($i_page > $page_total) {
        	// $a_data = array('state' => 0);
        	echo json_encode(0);
        }
		$a_data = $this->db->get('product');
		echo json_encode($a_data);
	}
}
?>