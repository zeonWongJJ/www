<?php
/**
 * 控制器
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

class Demand_ctrl extends \utils\BaseController
{
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
        $row  = [
            'demand_level_1'      => $this->request->post('demand_level_1', 0, 'intval'), // 需求服务的顶级id
            'demand_level_2'      => $this->request->post('demand_level_2', 0, 'intval'), // 需求服务的二级id
            'demand_level_3'      => $this->request->post('demand_level_3', 0, 'intval'), // 需求服务的三级id

            //            'demand_pay_type'     => $this->request->post('demand_pay_type', '', 'trim'), // 需求酬金支付方式
            'demand_remuneration' => $this->request->post('demand_remuneration', 0, 'float'), // 需求酬金
            'subject_title'       => $this->request->post('subject_title', '', 'trim'), // 需求标题
            'demand_info'         => $this->request->post('demand_info', '', 'trim'), // 需求详细内容
            'demand_service_at'   => $this->request->post('demand_service_at', '', 'trim'), // 需求可服务时间，时间戳
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
            'demand_level_1' => 'required|number', // 需求服务的顶级id
            'demand_level_2' => 'required|number', // 需求服务的二级id
            'demand_level_3' => 'required|number', // 需求服务的三级id

            'demand_pay_type'     => 'required', // 需求酬金支付方式
            'demand_remuneration' => 'required|number', // 需求酬金
            'subject_title'       => 'required|length:15', // 需求标题
            'demand_info'         => 'required|length:500', // 需求详细内容
            'demand_service_at'   => 'required', // 需求可服务时间
            'demand_contact_name' => 'required', // 需求联系人姓名
            'demand_gender'       => 'required', // 需求联系人性别 1男 2女
            'demand_telephone'    => 'required|phone', // 发需求的联系人电话
            'demand_address_name' => 'required', // 需求服务地址名称，如：长华创意谷
            'demand_house_number' => 'required', // 需求服务的门牌号
            'demand_lal'          => 'required', // 需求服务的经纬度
            'demand_price_type'   => 'required', // 酬金支付的方式

//            'order_deductible_type' => 'required'
        ];

        $valid = [
            'insert' => $row,
            'update' => $row
        ];

        return $valid[$method] ?? [];
    }

    /**
     * @return array
     */
    public function setField(): array
    {
        return [
            'demand_level_1'        => '一级分类'
            , 'demand_level_2'      => '二级分类'
            , 'demand_level_3'      => '三级分类'
            , 'demand_pay_type'     => '需求酬金支付方式'
            , 'demand_remuneration' => '需求酬金'
            , 'subject_title'       => '需求标题'
            , 'demand_info'         => '需求详细内容'
            , 'demand_service_at'   => '预约服务时间'
            , 'demand_contact_name' => '需求联系人姓名'
            , 'demand_gender'       => '需求联系人性别'
            , 'demand_telephone'    => '联系人电话'
            , 'demand_address_name' => '需求服务地址名称'
            , 'demand_house_number' => '需求服务的门牌号'
            , 'demand_lal'          => '需求服务的经纬度'
            , 'demand_price_type'   => '酬金支付的方式'
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
            'id' => 'required|number'
        ]);

        $demand = $this->db->get_row('jiajie_demand', $map);

        if ($demand && $demand['demand_is_show'] == 0) {

            if ($demand_is_show == 2) { // 审核不通过
                $result = $this->db->update('jiajie_demand', [
                    'demand_is_show' => $demand_is_show,
                    'no_pass_reason' => $no_pass_reason
                ], $map);
            } elseif ($demand_is_show == 1) {
                $result = $this->db->update('jiajie_demand', [
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
            'demand_id' => 'required|number'
        ]);

        if ($lock = $this->cache('demand.lock.' . $data['demand_id'])) {
            $this->error('需求已有人接单');
        }

        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        $store_info = $this->db->get_row(get_table('store'), ['user_id' => $user_info->user_id]);
        if (!$store_info) {
            return $this->error('您还没有开通店铺，不能接单');
        }

        if ($store_info['store_status'] != 1) {
            return $this->error('您的店铺暂时不可用哦~');
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
//        $order_info = $this->db->get_row('jiajie_order', ['order_sn' => $demand_info['order_sn']]);

        if ($demand_info['order_state'] != 0 && $demand_info['order_belong_store_id'] && $demand_info['receipt_at']) {
            return $this->error('该需求已经被别人接单了~');
        }

        $current_order_sn = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id], 'current_order_sn');
        if ($current_order_sn['current_order_sn'] || $this->cache('appointed.uid.lock.' . $user_info->user_id)) {
            return $this->error('您当前处于繁忙状态');
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
                'appointed_uid'         => $user_info->user_id
            ];
            if (!$row = $this->db->update(get_table('order'), $update, [
                'order_sn' => $demand_info['order_sn']
            ])) {
                throw new RuntimeException('更新订单表失败');
            }
            $this->db->update(get_table('store_user'), ['current_order_sn' => $demand_info['order_sn']], ['user_id' => $user_info->user_id]);
            $this->db->insert(get_table('order_appointed'), [
                'order_sn'      => $demand_info['order_sn'],
                'appointed_uid' => $user_info->user_id,
                'appointed_at'  => $_SERVER['REQUEST_TIME'],
                'appointer_id'  => $user_info->user_id
            ]);
            $this->cache('appointed.uid.lock.' . $user_info->user_id, $demand_info['order_sn']);
            $this->cache('demand.release.' . $data['demand_id'], null); // 出队列
            $this->cache('demand.lock.' . $data['demand_id'], null); // 解锁
            // 通知发单人
            $message_template_send_receipt_demand = $this->db->get_row(get_table('config'), ['config_key' => 'message_template_send_receipt_demand'], 'config_value');
            if ($message_template_send_receipt_demand && $message_template_send_receipt_demand['config_value']) {
                $temp = $message_template_send_receipt_demand['config_value'];
            } else {
                $temp = '您发布的需求#demand_name#有人接单了';
            }
            $message_content = str_replace('#demand_name#', $demand_info['subject_title'], $temp);
            $this->db->insert(get_table('message'), [
                'message_content'      => $message_content
                , 'message_post_at'    => $_SERVER['REQUEST_TIME']
                , 'message_notice_uid' => $demand_info['demand_user_id']
            ]);

            if ($demand_info['demand_telephone']) {
                //加载发送短信的类
                app('load')->library('short_message');
                //获取剩余短信条数
                if ($this->short_message->balance() == 0) {
                    $this->db->insert(get_table('short_message_log'), [
                        'log_title'          => '剩余短信条数不足'
                        , 'log_at'           => $_SERVER['REQUEST_TIME']
                        , 'log_phone_numner' => $demand_info['demand_telephone']
                    ]);
                } else {
                    // 检验通过之后发送验证码
                    $this->short_message->send($demand_info['demand_telephone'], $message_content, 'authcode');
                }
            }
            $this->db->commit();
            return $this->success(false);
        } catch (Exception $e) {
            $this->db->roll_back();
            return $this->error('接单失败!');
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
            'id' => 'required|number'
        ]);
        $demand_info = $this->db->get_row('jiajie_demand', $map, 'demand_is_show, no_pass_reason');


        if ($demand_info['demand_is_show'] != 2) {
            return $this->error('需求未被拒绝!');
        }

        return $this->success(['reason' => $demand_info['no_pass_reason']]);
    }
}
