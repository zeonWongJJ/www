<?php
/**
 * 需求控制器控制器
 * @version 2.0-dev
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

use model\DemandModel;
use utils\BaseController;
use utils\Factory;

class Demand_ctrl extends BaseController
{
    public $_ignore_node = [
        'fastSubscribe',
    ];

    /**
     * 缓存key前缀
     * @var string
     */
    protected $cache_key = 'user.demand.';

    protected $repository = \repositories\DemandRepository::class;

    /**
     * 数据获取
     * @param $method
     * @return array
     */
    public function getData($method): array
    {
        $row = [
            'demand_cate_id'      => $this->request->post('demand_cate_id', 0, 'intval'), // 需求服务id
            'demand_remuneration' => $this->request->post('demand_remuneration', 0, 'floatval'), // 需求酬金
            'demand_info'         => $this->request->post('demand_info', '', 'trim'), // 需求详细内容
            'demand_contact_name' => $this->request->post('demand_contact_name', '', 'trim'), // 需求联系人姓名
            'demand_gender'       => $this->request->post('demand_gender', '', 'trim'), // 需求联系人性别 1男 2女
            'demand_telephone'    => $this->request->post('demand_telephone', '', 'trim'), // 发需求的联系人电话
            'demand_address_name' => $this->request->post('demand_address_name', '', 'trim'), // 需求服务地址名称，如：长华创意谷
            'demand_house_number' => $this->request->post('demand_house_number', '', 'trim'), // 需求服务的门牌号
            'demand_lal'          => $this->request->post('demand_lal', '', 'trim'), // 需求服务的经纬度
            'demand_img'          => $this->request->post('demand_img', [], 'trim'), // 需求图片，可以是数组或者，隔开的字
            'demand_price_type'   => $this->request->post('demand_price_type', '', 'trim'), // 酬金支付的方式
        ];

        $data = [
            'insert' => $row,
            'update' => $row,
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
            'demand_cate_id'      => 'required|number', // 分类id
            'demand_remuneration' => 'required|number', // 需求酬金
            'demand_info'         => 'required|length:500', // 需求详细内容
            'demand_contact_name' => 'required', // 需求联系人姓名
            'demand_gender'       => 'required', // 需求联系人性别 1男 2女
            'demand_telephone'    => 'required|phone', // 发需求的联系人电话
            'demand_address_name' => 'required', // 需求服务地址名称，如：长华创意谷
            'demand_house_number' => 'required', // 需求服务的门牌号
            'demand_lal'          => 'required', // 需求服务的经纬度
            'demand_price_type'   => 'required', // 酬金支付的方式
        ];

        $valid = [
            'insert' => $row,
            'update' => $row,
        ];

        return $valid[$method] ?? [];
    }

    /**
     * @return array
     */
    public function setField(): array
    {
        return [
            'demand_cate_id'      => '分类名称',
            'demand_remuneration' => '需求酬金',
            'subject_title'       => '需求标题',
            'demand_info'         => '需求详细内容',
            'demand_contact_name' => '需求联系人姓名',
            'demand_gender'       => '需求联系人性别',
            'demand_telephone'    => '联系人电话',
            'demand_address_name' => '需求服务地址名称',
            'demand_house_number' => '需求服务的门牌号',
            'demand_lal'          => '需求服务的经纬度',
            'demand_price_type'   => '酬金支付的方式',
            'locate_info'         => '当前定位信息'
        ];
    }

    // - 更多方法定义

    /**
     * 需求审核
     * @router http://server.name/demand.examine
     */
    public function examine()
    {
        $map['id'] = (int)$this->router->get(1);

        $no_pass_reason = $this->request->post('reason', '', 'trim');
        $demand_is_show = $this->request->post('pass', 0, 'intval');

        $this->validate($map, [
            'id' => 'required|number',
        ]);

        if ($demand = $this->db->get_row(get_table('demand'), $map)) {
            if ($demand_is_show == 2) { // 审核不通过
                $result = $this->db->update(get_table('demand'), [
                    'demand_is_show' => $demand_is_show,
                    'no_pass_reason' => $no_pass_reason,
                ], $map);
            } elseif ($demand_is_show == 1) {
                $result = $this->db->update(get_table('demand'), [
                    'demand_is_show' => $demand_is_show,
                ], $map);
            } else {
                return $this->error('审核类型不合法');
            }
            return $result ? $this->success(false) : $this->error('修改失败' . $this->db->get_sql());
        }
        return $this->error('该需求审核状态不允许修改!');
    }

    /**
     * 服务商接单接口
     * @router http://server.name/demand.receipt-{demand_id}
     */
    public function receipt()
    {
        $data['demand_id'] = $this->router->get(1);
        $this->validate($data, [
            'demand_id' => 'required|number',
        ]);

        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        $store_info = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id]);
        if (!$store_info) {
            return $this->error('您还没有开通店铺，不能接单');
        }

        if ($store_info['staff_pass'] != 1 || $store_info['staff_status'] != 1) {
            return $this->error('您的员工账号暂时不可用哦~');
        }
        $staff_row   = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id]);
        $demand_info = $this->db->join([get_table('order') => 'b'], ['a.order_sn' => 'b.order_sn'], 'INNER')
            ->get_row([get_table('demand') => 'a'], ['a.id' => $data['demand_id']]);

        if (!$demand_info) {
            return $this->error('需求不存在');
        }


        if ($demand_info['demand_user_id'] == $user_info->user_id) {
            return $this->error('自己发布的需求不能接单哦!');
        }

        $open_demand_examine = $this->db->get_row(get_table('config'), ['config_key' => 'open_demand_examine'], 'config_value');

        if ($open_demand_examine['config_value'] == 'true' && $demand_info['demand_is_show'] != 1) {
            return $this->error('该需求没有审核通过或审核中。请稍后再来!');
        }

        // 检测是否已被接单
//        $order_info = $this->db->get_row(get_table('order'), ['order_sn' => $demand_info['order_sn']]);

        if ($demand_info['order_state'] != 0 && $demand_info['order_belong_store_id'] && $demand_info['receipt_at']) {
            return $this->error('该需求已经被别人接单了~');
        }

        $current_order_sn = $this->db->get_row(get_table('store_user'),
            ['user_id' => $user_info->user_id],
            'staff_current_order_sn, staff_current_order_sub_id');
        if ($current_order_sn['staff_current_order_sn']) {
            return $this->error('您目前已经有一笔订单处于服务中');
        }

        try {
            $this->cache('demand.lock.' . $data['demand_id'], $data['demand_id']); // 加锁
            $this->db->begin();
            $this->db->set_error_mode();
            $update = [
                'order_state'           => 2, // 服务商接单后为待服务状态
                'order_bis_state_dsc'   => 'PENDING_DOOR',
                'receipt_at'            => $_SERVER['REQUEST_TIME'],
                'order_belong_store_id' => $staff_row['store_id'],
                'appointed_uid'         => $user_info->user_id,
            ];
            if (!$row = $this->db->update(get_table('order'), $update, [
                'order_sn' => $demand_info['order_sn'],
            ])) {
                throw new RuntimeException('更新订单表失败');
            }
            $this->db->update(get_table('store_user'),
                ['staff_current_order_sn' => $demand_info['order_sn'], 'staff_current_order_sub_id' => 0],
                ['user_id' => $user_info->user_id]
            );
            $this->db->insert(get_table('order_appointed'), [
                'order_sn'      => $demand_info['order_sn'],
                'appointed_uid' => $user_info->user_id,
                'appointed_at'  => $_SERVER['REQUEST_TIME'],
                'appointer_id'  => $user_info->user_id,
            ]);
            $this->db->set('staff_all_services', 'staff_all_services + 1', false)
                ->set('staff_total_services', 'staff_total_services + 1', false)
                ->update(get_table('store_staff_info'), null, ['staff_id' => $store_info['id']]);
            // 通知发单人
            $temp                                 = '您发布的需求#demand_name#有人接单了';
            $message_template_send_receipt_demand = $this->db->get_row(get_table('config'), ['config_key' => 'message_template_send_receipt_demand'], 'config_value');
            if ($message_template_send_receipt_demand && $message_template_send_receipt_demand['config_value']) {
                $temp = $message_template_send_receipt_demand['config_value'];
            }
            $message_content = str_replace('#demand_name#', $demand_info['subject_title'], $temp);

            /** @var \model\MessageModel $message_model */
            $message_model = \utils\Factory::getFactory('message');
            $message_model->notifyUser($demand_info['demand_user_id'], $message_content)
                ->sendMsm($demand_info['demand_telephone'], $message_content);
            $this->db->commit();
            return $this->success(false);
        } catch (Exception $e) {
            $this->db->roll_back();
            return $this->error('接单失败!' . $e->getMessage());
        }
    }

    /**
     * 获取审核不通过的理由
     * @router http://server.name/demand.get.reason
     */
    public function getNoPassReason()
    {
        $map['id'] = $this->router->get(1);
        $this->validate($map, [
            'id' => 'required|number',
        ]);
        $demand_info = $this->db->get_row(get_table('demand'), $map, 'demand_is_show, no_pass_reason');


        if ($demand_info['demand_is_show'] != 2) {
            return $this->error('需求未被拒绝!');
        }

        return $this->success(['reason' => $demand_info['no_pass_reason']]);
    }

    /**
     * @remark 取消预约
     * @RequestMapping('/cancel.subscribe')
     */
    public function cancelSubscribe()
    {
        $user_info    = app('user_info');
        $subscribe_id = (int)$this->router->get(1);
        if ($subscribe_id) {
            $subscribe = $this->db->get_row(get_table('subscribe'), ['id' => $subscribe_id]);
            if ($subscribe['subscribe_phone'] != $user_info->user_phone) {
                return $this->error('当前绑定的手机号码与预约号码不一致');
            }
            $this->db->update(get_table('subscribe'), [
                'subscribe_state' => 'ACTIVE_CANCEL'
            ], ['id' => $subscribe_id]);
        }
        return $this->success(false);
    }

    /**
     * 快速预约服务
     * @router http://server.name/fast.subscribe
     */
    public function fastSubscribe()
    {
        $data['cate_id']     = $this->request->post('cate_id', 0, 'intval');
        $user_id             = 0;
        $data['verify_code'] = false;

        /** @var \model\MessageModel $message_model */
        $message_model = \utils\Factory::getFactory('message');
        $token         = $_SERVER['HTTP_X_TOKEN'] ?? '';
        if ($token) {
            /** @var \model\TokenModel $token_model */
            $token_model = \utils\Factory::getFactory('token');
            $user_info   = $token_model->parseToken();

            $user_row                = $this->db->get_row('user', ['user_id' => $user_info['user_id']], 'user_phone, user_id');
            $data['subscribe_phone'] = $user_row['user_phone'];
            $user_id                 = $user_row['user_id'];
        } else {
            $data['subscribe_phone'] = $this->request->post('subscribe_phone', '', 'trim');
            $data['verify_code']     = $this->request->post('verify_code', '', 'trim');
            $message_model->checkVerifyCode($data['subscribe_phone'], $data['verify_code']);
        }

        $this->validate($data, [
            'cate_id'         => 'required',
            'subscribe_phone' => 'required',
        ]);

        // 判断是否有已预约的记录
        $subscribed = $this->db->get_total(get_table('subscribe'), [
            'subscribe_phone' => $data['subscribe_phone'],
            'subscribe_state' => 'PENDING'
        ]);

        if ($subscribed) {
            return $this->error('您已经预约，稍后会由客服与您联系');
        }

        $has_cate = $this->db->get_total(get_table('category'), [
            'id' => $data['cate_id'],
        ]);

        if (!$has_cate) {
            return $this->error('预约的分类不存在');
        }

        $this->db->begin();
        try {
            $insert_id = $this->db->insert(get_table('subscribe'), [
                'subscribe_phone' => $data['subscribe_phone'],
                'cate_id'         => $data['cate_id'],
                'sub_at'          => $_SERVER['REQUEST_TIME'],
                'belong_order_sn' => '',
                'subscribe_state' => 'PENDING',
                'user_id'         => $user_id,
            ]);
            /** @var \model\OrderModel $order_model */
            $order_model = Factory::getFactory('order');
            $order_info  = $order_model->setContact(
                $data['subscribe_phone'],
                '未确认地址',
                '未确认门牌号',
                '未确认联系人信息'
            )->coumpteDeductible(0)->unifiedOrder(\model\OrderModel::ORDER_USER_SUBSCRIBE, $insert_id, 'wechat', 0);
            $this->db->update(get_table('order'), ['order_bis_state_dsc' => 'PENDING_CONTACT'], [
                'order_sn' => $order_info['order_sn']
            ]);
            $this->db->update(get_table('subscribe'), [
                'belong_order_sn' => $order_info['order_sn'],
            ], ['id' => $insert_id]);
            $this->db->commit();
            $cate_info = $this->db->get_row(get_table('category'), ['id' => $data['cate_id']], 'cat_name');
            $message_model->notifyUser($user_id, '您已经预约一个' . $cate_info['cat_name'] . '的服务，稍后会由客服与您联系');
            return $this->success(false);
        } catch (Exception $e) {
            $this->db->roll_back();
            return $this->error('预约失败' . $e->getMessage());
        }
    }

    /**
     * @RequestMapping('/demand.list.lal')
     * @remark 根据距离获取需求列表
     */
    public function getListByLaL()
    {
        $data['locate_info'] = $this->request->post('locate_info', '', 'trim');
        $this->validate($data, [
            'locate_info' => 'required|lal'
        ]);
        /** @var DemandModel $demand_model */
        $demand_model = Factory::getFactory('demand');
        $demand_list  = $demand_model->getDemandListByLocal($data['locate_info']);
        return $this->success($demand_list);
    }
}
