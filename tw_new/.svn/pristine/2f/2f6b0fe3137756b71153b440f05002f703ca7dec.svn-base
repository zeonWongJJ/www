<?php
defined('BASEPATH') or exit('禁止访问！');
class Ad_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('ad_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/************************************* 广告列表 *************************************/

	public function ad_showlist() {
		// 获取广告数据
		$a_data = $this->ad_model->get_ad_page();
		$this->view->display('ad_showlist', $a_data);
	}

/************************************* 添加广告 *************************************/

	public function ad_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 接收参数
			$ad_title = trim($this->general->post('ad_title'));
			$ad_order = trim($this->general->post('ad_order'));
			$ad_link  = trim($this->general->post('ad_link'));
			$ad_pic   = trim($this->general->post('otherpic_path'));
			$a_parameter = [
				'msg'      => '必填项不能为空',
				'url'      => 'ad_showlist',
				'log'      => false,
				'wait'     => 2,
			];
			if (empty($ad_pic) || empty($ad_title)) {
				$this->error->show_error($a_parameter);
			}
			// 验证通过后插入数据
			$a_insert_data = [
				'ad_title' => $ad_title,
				'ad_order' => $ad_order,
				// 'ad_link'  => $ad_link,
				'ad_pic'   => $ad_pic
			];
			$i_result = $this->ad_model->insert_ad($a_insert_data);
			if ($i_result) {
				$a_parameter['msg'] = '添加成功';
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '添加失败';
				$this->error->show_error($a_parameter);
			}
		} else {
			$this->view->display('ad_add');
		}
	}

/************************************* 删除广告 *************************************/

	public function ad_delete() {
		// 接收需要删除的id
		$ad_id = trim($this->general->post('ad_id'));
		$i_result = $this->ad_model->delete_ad($ad_id);
		if ($i_result) {
			echo json_encode(array('code'=>200,'msg'=>'删除成功'));
		} else {
			echo json_encode(array('code'=>400,'msg'=>'删除失败'));
		}
	}

/************************************* 修改广告 *************************************/

	public function ad_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 接收参数
			$ad_id    = trim($this->general->post('ad_id'));
			$ad_title = trim($this->general->post('ad_title'));
			$ad_order = trim($this->general->post('ad_order'));
			$ad_link  = trim($this->general->post('ad_link'));
			$ad_pic   = trim($this->general->post('otherpic_path'));
			$a_parameter = [
				'msg'      => '必填项不能为空',
				'url'      => 'ad_showlist',
				'log'      => false,
				'wait'     => 2,
			];
			if (empty($ad_pic) || empty($ad_title)) {
				$this->error->show_error($a_parameter);
			}
			// 验证通过后插入数据
			$a_update_where = [
				'ad_id' => $ad_id
			];
			$a_update_data = [
				'ad_title' => $ad_title,
				'ad_order' => $ad_order,
				'ad_link'  => $ad_link,
				'ad_pic'   => $ad_pic
			];
			$i_result = $this->ad_model->update_ad($a_update_where, $a_update_data);
			if ($i_result) {
				$a_parameter['msg'] = '修改成功';
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '修改失败';
				$this->error->show_error($a_parameter);
			}
		} else {
			$ad_id = $this->router->get(1);
			// 获取一条数据并分配到模板
			$a_data = $this->ad_model->get_ad_one($ad_id);
			$this->view->display('ad_update', $a_data);
		}
	}

/*********************************** 删除临时图片 ***********************************/

    public function adtem_delete() {
        $image_path = trim($this->general->post('image_path'));
        $dtype      = trim($this->general->post('dtype'));
        $record_id  = trim($this->general->post('record_id'));
        $b_result 	= unlink($image_path);
        if ($b_result) {
            if ($dtype == 2) {
                $a_where = [
                	'ad_id' => $record_id
                ];
                $a_data = [
					'ad_pic'  => '',
					'ad_time' => time()
                ];
                $i_result = $this->ad_model->update_ad($a_where, $a_data);
            }
            echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
        } else {
            echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
        }
    }

/************************************************************************************/

}