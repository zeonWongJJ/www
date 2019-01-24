<?php
defined('BASEPATH') or exit('禁止访问！');
class Package_ctrl extends TW_Controller {

	public function __construct() {
		parent :: __construct();
		$this->load->model('package_model');
		$this->load->model('allow_model');
		$this->allow_model->is_login();
		$this->allow_model->is_allow();
	}

/***************************************** 套餐列表 *****************************************/

	public function package_showlist() {
		$a_data = $this->package_model->get_package_page();
		$this->view->display('package_showlist', $a_data);
	}

/***************************************** 添加套餐 *****************************************/

	public function package_add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 接收数据
			$antistop      = trim($this->general->post('antistop'));
			$product_name  = trim($this->general->post('product_name'));
			$order         = trim($this->general->post('order'));
			$pro_details   = trim($this->general->post('pro_details'));
			$pro_img       = trim($this->general->post('mainpic_path'));
			$pro_image     = trim($this->general->post('otherpic_path'));
			$group_product = trim($this->general->post('group_product'));
			$price         = trim($this->general->post('price'));
			$supply_time   = trim($this->general->post('supply_time'));
			// 验证数据
			$a_parameter = [
				'msg'      => '必填项不能为空',
				'url'      => 'package_showlist',
				'log'      => false,
				'wait'     => 2,
			];
			if (empty($product_name) || empty($group_product)) {
				$this->error->show_error($a_parameter);
			}
			$group_product = str_replace('&', ',', $group_product);
			// 验证通过添加数据
			$a_insert_data = [
				'antistop'      => $antistop,
				'product_name'  => $product_name,
				'order'         => $order,
				'pro_details'   => $pro_details,
				'pro_img'       => $pro_img,
				'pro_image'     => $pro_image,
				'group_product' => $group_product,
				'proid_id_1'    => 'i',
				'product_group' => 1,
				'goods_stye'    => 1,
				'supply_time'   => $supply_time
			];
			$i_result = $this->package_model->insert_product($a_insert_data);
			if ($i_result) {
				// 添加价格
				$a_price = [
					'product_id' => $i_result,
					'price'      => $price,
				];
				$i_result = $this->package_model->insert_price($a_price);
				$a_parameter['msg'] = '添加成功';
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '添加失败';
				$this->error->show_error($a_parameter);
			}
		} else {
			// 获取所有的顶级分类
			$a_data['pro'] = $this->package_model->get_pro_top();
			// 获取时间段信息
			$a_data['time'] = $this->package_model->get_time_all();
			$this->view->display('package_add', $a_data);
		}
	}

/***************************************** 修改套餐 *****************************************/

	public function package_update() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// 接收数据
			$product_id    = trim($this->general->post('product_id'));
			$antistop      = trim($this->general->post('antistop'));
			$product_name  = trim($this->general->post('product_name'));
			$order         = trim($this->general->post('order'));
			$pro_details   = trim($this->general->post('pro_details'));
			$pro_img       = trim($this->general->post('mainpic_path'));
			$pro_image     = trim($this->general->post('otherpic_path'));
			$group_product = trim($this->general->post('group_product'));
			$price         = trim($this->general->post('price'));
			$supply_time   = trim($this->general->post('supply_time'));
			// 验证数据
			$a_parameter = [
				'msg'      => '必填项不能为空',
				'url'      => 'package_showlist',
				'log'      => false,
				'wait'     => 2,
			];
			if (empty($product_name) || empty($group_product)) {
				$this->error->show_error($a_parameter);
			}
			$group_product = str_replace('&', ',', $group_product);
			$a_update_where = [
				'product_id' => $product_id
			];
			// 验证通过修改数据
			$a_update_data = [
				'antistop'      => $antistop,
				'product_name'  => $product_name,
				'order'         => $order,
				'pro_details'   => $pro_details,
				'pro_img'       => $pro_img,
				'pro_image'     => $pro_image,
				'group_product' => $group_product,
				'proid_id_1'    => 'i',
				'product_group' => 1,
				'goods_stye'    => 1,
				'update_time'   => time(),
				'supply_time'   => $supply_time
			];
			$i_result = $this->package_model->update_product($a_update_where,$a_update_data);
			if ($i_result) {
				// 修改价格
				$a_price = [
					'price'      => $price,
				];
				$i_result = $this->package_model->update_price($a_update_where, $a_price);
				$a_parameter['msg'] = '修改成功';
				$this->error->show_success($a_parameter);
			} else {
				$a_parameter['msg'] = '修改失败';
				$this->error->show_error($a_parameter);
			}
		} else {
			// 接收数据
			$product_id = $this->router->get(1);
			// 获取一条产品信息
			$a_data['product'] = $this->package_model->get_product_one($product_id);
			// 获取一条价格信息
			$a_data['price'] = $this->package_model->get_price_one($product_id);
			$a_data['pro'] = array();
			$a_data['pid'] = array();
			if (!empty($a_data['product']['group_product'])) {
				$group_product = explode(',', $a_data['product']['group_product']);
				for ($i=0; $i < count($group_product); $i++) {
					$pid_arr = explode('-', $group_product[$i]);
					$a_data['pid'][$i] = $pid_arr;
					// 获取一条产品
					$a_product = $this->package_model->get_product_one($pid_arr[0]);
					$a_data['pro'][] = $a_product['proid_id_1'];
				}
			}
			// 获取所有的顶级分类
			$a_data['top'] = $this->package_model->get_pro_top();
			// 获取相应分类下的产品
			$a_data['topproduct'] = $this->package_model->get_product_bycate($a_data['pro']);
			// 获取时间段信息
			$a_data['time'] = $this->package_model->get_time_all();
			// 展示模板
			$this->view->display('package_update', $a_data);
		}
	}

/***************************************** 删除套餐 *****************************************/

	public function package_delete() {
		// 接收数据
		$product_id = trim($this->general->post('product_id'));
		$i_result = $this->package_model->delete_product($product_id);
		if ($i_result) {
			// 删除成功后删除价格
			$i_result = $this->package_model->delete_price($product_id);
			echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
		}
	}

/***************************************** 套餐开关 *****************************************/

	public function package_switch() {
		$product_id = trim($this->general->post('product_id'));
		// 获取一条产品
		$a_product = $this->package_model->get_product_one($product_id);
		if ($a_product['pro_show'] == 1) {
			$a_data = [
				'pro_show' => 2
			];
		} else {
			$a_data = [
				'pro_show' => 1
			];
		}
		$a_where = [
			'product_id' => $product_id
		];
		$i_result = $this->package_model->update_product($a_where, $a_data);
		if ($i_result) {
			echo json_encode(array('code'=>200,'msg'=>'设置成功'));
		} else {
			echo json_encode(array('code'=>400,'msg'=>'设置失败'));
		}
	}

/***************************************** 获取产品 *****************************************/

	public function package_product() {
		// 接收数据
		$pro_id = trim($this->general->post('pro_id'));
		if (empty($pro_id)) {
			echo json_encode(array('code'=>400, 'msg'=>'获取失败'));
			die;
		}
		$a_product = $this->package_model->get_product_bypro($pro_id);
		if (!empty($a_product)) {
			echo json_encode(array('code'=>200, 'msg'=>'获取成功','data'=>$a_product));
		} else {
			echo json_encode(array('code'=>400, 'msg'=>'获取失败'));
		}
	}

/*********************************** 删除临时图片 ***********************************/

    public function packagetem_delete() {
        $image_path = trim($this->general->post('image_path'));
        $dtype      = trim($this->general->post('dtype'));
        $record_id  = trim($this->general->post('record_id'));
        $b_result 	= unlink($image_path);
        if ($b_result) {
            if ($dtype == 2) {
                // 删除数据中记录的图片路径
                $a_product = $this->package_model->get_product_one($record_id);
                $pro_img = $a_product['pro_img'];
                $pro_image = $a_product['pro_image'];
                $a_update_where = [
                    'product_id' => $record_id
                ];
                if ($pro_img == $image_path) {
                    $a_update_data = [
                        'update_time'  => $_SERVER['REQUEST_TIME'],
                        'pro_img' => '',
                    ];
                    $this->package_model->update_product($a_update_where, $a_update_data);
                }
                // 将其余图片拆分成数组匹配
                $img_arr = explode(',', $pro_image);
                for ($i=0; $i<count($img_arr); $i++) {
                    if ($img_arr[$i] == $image_path) {
                        unset($img_arr[$i]);
                    }
                }
                $a_update_data = [
					'update_time'   => $_SERVER['REQUEST_TIME'],
					'pro_image' => implode(',', $img_arr),
                ];
                $this->package_model->update_product($a_update_where, $a_update_data);
            }
            echo json_encode(array('code'=>200, 'msg'=>'删除成功'));
        } else {
            echo json_encode(array('code'=>400, 'msg'=>'删除失败'));
        }
    }

/********************************************************************************************/

}

?>