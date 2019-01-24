<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */

use utils\BaseController;

class Staff_ctrl extends BaseController
{
    public $_ignore_node = [
        'insert'
    ];
    protected $repository = \repositories\StaffRepository::class;

    /**
     * 数据获取
     * @param $method
     * @return array
     */
    public function getData($method): array
    {
        $row = [
            'staff_name'           => $this->request->post('staff_name', '', 'trim'),           // 店员名称
            'store_id'             => $this->request->post('store_id', 0, 'intval'),            // 加入的店铺ID
            'store_user_lat'       => $this->request->post('store_user_lat', '', 'intval'),     // 店员绑定的经度
            'store_user_lng'       => $this->request->post('store_user_lng', '', 'trim'),       // 店员绑定的纬度
            'store_address_info'   => $this->request->post('staff_address_info', '', 'trim'),   // 店员的位置信息
            'staff_id_card_pic_zm' => $this->request->post('staff_id_card_pic_zm', '', 'trim'), // 店员身份证正面
            'staff_id_card_pic_bm' => $this->request->post('staff_id_card_pic_bm', '', 'trim'), // 店员身份证背面
            'staff_cert_pic_zm'    => $this->request->post('staff_cert_pic_zm', '', 'trim'),    // 店员资质证正面
            'staff_cert_pic_bm'    => $this->request->post('staff_cert_pic_bm', '', 'trim'),    // 店员资质证背面
            'staff_address_info'   => $this->request->post('staff_address_info', '', 'trim'),   // 店员位置信息描述
            'staff_tel'            => $this->request->post('staff_tel', '', 'trim'),            // 店员联系手机号码
            'staff_id_card_number' => $this->request->post('staff_id_card_number', '', 'trim'), // 店员身份证号码
        ];

        $data = [
            'insert' => $row,
            'update' => $row
        ];

        return $data[$method] ?? [];
    }


    /**
     * 验证定义
     * @param $method
     * @return array
     */
    public function valid($method): array
    {
        $row = [
            'staff_name'           => 'required|length:3,6',
            'store_id'             => 'required|number',
            'store_user_lat'       => 'required',
            'store_user_lng'       => 'required',
            'store_address_info'   => 'required',
            'staff_id_card_pic_zm' => 'required',
            'staff_id_card_pic_bm' => 'required',
            //            'staff_cert_pic_zm'    => 'required',
            //            'staff_cert_pic_bm'    => 'required',
            'staff_address_info'   => 'required',
            'staff_tel'            => 'required|phone',
            'staff_id_card_number' => 'required',
        ];

        $valid = [
            'insert' => $row,
            'update' => $row
        ];

        return $valid[$method] ?? [];
    }

    /**
     * 字段定义
     * @return array
     */
    public function setField(): array
    {
        return [
            'staff_name'           => '真实姓名',
            'store_id'             => '店铺ID',
            'store_user_lat'       => '纬度',
            'store_user_lng'       => '经度',
            'store_address_info'   => '店员位置信息描述',
            'staff_id_card_pic_zm' => '店员身份证正面',
            'staff_id_card_pic_bm' => '店员身份证背面',
            'staff_cert_pic_zm'    => '店员资质证正面',
            'staff_cert_pic_bm'    => '店员资质证背面',
            'staff_address_info'   => '店员位置信息描述',
            'staff_tel'            => '店员联系手机号码',
            'staff_id_card_number' => '店员身份证号码',
            'reason'               => '拒绝理由'
        ];
    }
    // - 更多方法定义

    /**
     * 设置店员为管理员
     * @RequestMapping('/staff.set.admin-{staff_id}')
     */
    public function setStaffAdmin()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        $staff_id = (int)$this->router->get(1);
        if (!$staff_row = $this->db->get_row(get_table('store_user'), ['id' => $staff_id])) {
            return $this->error('无记录');
        }
        $store_row = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id]);

        if ($store_row && $store_row['store_id'] != $staff_row['store_id']) {
            return $this->error('该店员不属于您的店铺');
        }

        $update['user_type']     = $staff_row['user_type'] == 2 ? 1 : 2;
        $update['user_type_key'] = $staff_row['user_type_key'] == 'KIPPER' ? 'SERVER' : 'KIPPER';
        $this->db->update(get_table('store_user'), $update, [
                'user_id'  => $staff_id,
                'store_id' => $store_row['store_id']
            ]
        );
        return $this->success(false);
    }

    /**
     * @remark 执行店员审核
     * @RequestMapping('/staff.shenhe-${staff_id}')
     * @return mixed
     */
    public function shenhe()
    {
        $data['pass']   = $this->request->post('pass', 1, 'trim');
        $data['reason'] = $this->request->post('reason', '', 'trim');

        if ($data['pass'] == -1) {
            $this->validate($data, [
                'reason' => 'required'
            ]);
        }

        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        $staff_id = (int)$this->router->get(1);
        if (!$staff_id) {
            return $this->error('店员ID不能为空');
        }
        $staff_info = $this->db->get_row(get_table('store_user'), [
            'id' => $staff_id
        ]);
        if (!$staff_info) {
            return $this->error('店员不存在');
        }
        $my_staff_row = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id], 'store_id');
        if ($my_staff_row['store_id'] != $staff_info['store_id']) {
            return $this->error('店员不属于您的店铺');
        }

        if ($data['pass'] == 1) {
            $update = [
                'staff_allow_at' => $_SERVER['REQUEST_TIME']
            ];
        } else {
            $update = [
                'staff_no_pass_reponse' => $data['reason']
            ];
        }

        $this->db->update(get_table('store_user'), array_merge(
            $update,
            ['staff_pass' => $data['pass']]
        ), ['id' => $staff_id]);

        return $this->success(false);
    }

    /**
     * @remark 根据订单获取可分配的店员
     * @RequestMapping('/staff.get.allocation-${order_sn}')
     */
    public function getAllocationList()
    {
        $data['order_sn']     = $this->router->get(1);
        $data['order_sub_id'] = $this->router->get(2) ?: 0;
        $this->validate($data, [
            'order_sn' => 'required'
        ]);

        try {
            $this->db->begin();
            /** @var \model\StoreModel $store_model */
            $store_model = \utils\Factory::getFactory('store');
            list($all_staffs, $can_assign_staff) = $store_model->getCanAssignStaff($data['order_sn'], $data['order_sub_id']);
            return $this->success($all_staffs);
        } catch (Exception $e) {
            $this->db->roll_back();
            return $this->error('获取失败' . $e->getMessage());
        }
    }

    /**
     * @remark 店员总览
     * @RequestMapping('/staff.overview-{staff_id}')
     */
    public function staffOverview()
    {
        // 总订单数，已完成订单数，未完成订单数、好评率
        // 总服务时长、总服务平方数
        // 本月服务时长、本月服务平方数
        // 店员信息：等级、是否管理员
        // 收入明细，总收入、本月收入、本月未结算、本月已提现
        $staff_id    = (int)$this->router->get(1);
        $overview    = [];
        $user_info   = $this->db
            ->join([get_table('store_staff_info') => 'a'], ['a.staff_id' => 'b.id'])
            ->get_total([get_table('store_use') => 'b'], ['b.id' => $staff_id]);
        $overview['order']['all_order'] = $all_order = $user_info['staff_all_services']; // 店员所有订单数
        $overview['order']['todo_count'] = $todo_order_count = $this->db
            ->get_total(get_table('order_appointed'), [
                'appointed_uid' => $user_info['staff_id'],
                'completed'     => 0
            ]); // 未完成订单数
        if (!$all_order) {
            $overview['order']['hp_rate'] = ($user_info['staff_hp_count'] / $user_info['staff_total_services']) * 100; // 好评率
            $overview['order']['cp_rate'] = ($user_info['staff_cp_count'] / $user_info['staff_total_services']) * 100; // 差评率
            $overview['order']['zp_rate'] = ($user_info['staff_zp_count'] / $user_info['staff_total_services']) * 100; // 中评率
        }
        $overview['user_info'] = $user_info;

        return $this->success($overview);
    }
}
