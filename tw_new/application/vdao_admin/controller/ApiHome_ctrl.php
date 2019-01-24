<?php
date_default_timezone_set('PRC');
class ApiHome_ctrl extends TW_Controller {
	public function __construct() {
		parent :: __construct();
        $this->load->model('apiToken_model');
        $is_allow=$this->apiToken_model->is_allow();
        if(!$is_allow){
            echo json_encode($this->apiToken_model->token_no_allow());
            exit;
        }
		$this->load->model('apiHome_model');
	}

	//首页统计数据
	public function statistics() {
        if($_SERVER['REQUEST_METHOD']=='POST'){
            /*$admin_id = trim($this->general->post('admin_id'));
            //$role_id = trim($this->general->post('role_id'));
            if (empty($admin_id)) {
                $result = array(
                    'code' => 200,
                    'msg' => "请先登录",
                    'data' => '',
                );
                echo json_encode($result);
                exit;
            }*/

            //$a_data = $this->db->get_row('role', ['role_id' => $role_id]);
            //公告
            //$a_data['notice'] = $this->db->get('notice', '', '', ['notice_id' => 'desc'], 0,6);
            //oute()
            //总订单
            $a_data['order'] = $this->apiHome_model->order();
            //总销售额
            $a_data['sales'] = $this->apiHome_model->sales();
            //总用户
            $a_data['userCount'] = $this->apiHome_model->getAllUserCount();
            //总门店
            $a_data['storeCount'] = $this->apiHome_model->getAllStoreCount();
            //总店主
            $a_data['shopkeepersCount'] = $this->apiHome_model->getShopkeepersCount();
            // 日销售额和日订单
            $a_forehead = $this->apiHome_model->getOrderSalesAndOrderCountByDay();
            foreach ($a_forehead as $forehead) {
                $a_data['daily_order'] += $forehead['daily_order'];
                $a_data['daily_sales'] += $forehead['daily_sales'];
            }
            $a_data['yue'] = $this->apiHome_model->yuezezhan();
            $result = array(
                'code' => 200,
                'msg' => "",
                'data' => $a_data,
            );
            echo json_encode($result);
            exit;
        }
	}



}

?>