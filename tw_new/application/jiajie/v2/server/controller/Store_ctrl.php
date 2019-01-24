<?php
/**
 * 店铺控制器
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

use Controller\Application;
use model\OrderModel;

/**
 * Class Store_ctrl
 */
class Store_ctrl extends Application
{
    protected $repository = \repositories\StoreRepository::class;

    /**
     * @return array
     */
    public function setField(): array
    {
        return [
            'store_name'           => '店铺名字',
            'store_director'       => '店铺负责人名称',
            'staff_cert_pic_zm'    => '店员资质证正面',
            'staff_cert_pic_bm'    => '店员资质证背面',
            'staff_id_card_pic_zm' => '店员身份证正面',
            'staff_id_card_pic_bm' => '店员身份证背面',
            'store_phone'          => '店铺负责人联系电话',
            'store_range'          => '店铺服务范围',
            'store_region'         => '店铺所在地区',
            'staff_address_info'   => '店铺详细地址',
            'store_pic'            => '店铺图片',
            'store_info'           => '店铺描述',
            'staff_id_card_number' => '店铺负责人身份证号码',
            'order_sn'             => '订单流水号',
            'appointed_uid'        => '指派用户id',
            'staff_id'             => '店员id'
        ];
    }

    /**
     * 数据获取
     * @param $method
     * @return array
     */
    public function getData($method): array
    {
        $row = [
            'store_name'             => $this->request->post('store_name', '', 'trim'),
            'store_director'         => $this->request->post('store_director', '', 'trim'),
            'store_phone'            => $this->request->post('store_phone', '', 'trim'),
            'store_id_card_positive' => $this->request->post('store_id_card_positive', '', 'trim'), // 身份证正面
            'store_id_card_opposite' => $this->request->post('store_id_card_opposite', '', 'trim'), // 身份证反面
            'store_range'            => $this->request->post('store_range', '', 'trim'),
            'store_region'           => $this->request->post('store_region', '', 'trim'),
            'store_address'          => $this->request->post('store_address', '', 'trim'),
            'store_pic'              => $this->request->post('store_pic/a', [], 'trim'),
            'store_id_card'          => $this->request->post('store_id_card', '', 'trim'),
            'store_info'             => $this->request->post('store_info', '', 'trim')
        ];

        $data = [
            'insert' => $row,
            'update' => $row
        ];

        return $data[$method] ?? [];
    }

    // - 更多方法定义

    /**
     * 验证定义
     * @param $method
     * @return array
     */
    public function valid($method): array
    {
        $rows = [
            'store_name'             => 'required',
            'store_director'         => 'required',
            'store_id_card_positive' => 'required',
            'store_id_card_opposite' => 'required',
            'store_phone'            => 'required|phone',
            'store_range'            => 'required|number',
            'store_region'           => 'required',
            'store_address'          => 'required',
            'store_pic'              => 'required',
            'store_info'             => 'required',
            'store_type'             => 'required',
            'store_id_card'          => 'required|length:18'
        ];

        if ('ADMIN' === \model\TokenModel::getSourceSign()) {
            unset($rows['store_range'], $rows['store_region'], $rows['store_info']);
        }

        $valid = [
            'insert' => $rows,
            'update' => $rows
        ];

        return $valid[$method] ?? [];
    }

    /**
     * 获取店铺下的所有服务列表
     * @RequestMapping('/store.get.services-{store_id}-{lavel_1}')
     */
    public function getServers()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        $store_id        = $this->router->get(1);
        $service_level_1 = $this->router->get(2);
        list($field, $sort, $offset, $limit, $condition) = $this->buildQuery();
        if ($service_level_1) {
            $condition['service_level_1'] = $service_level_1;
        }
        if (!$store_id) {
            $staff_row = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id], 'store_id');
            $store_id  = $staff_row['store_id'];
        }

        $condition = array_merge($condition, ['store_id' => $store_id, 'service_is_del' => 0]);
        $rows      = $this->db->limit($offset, $limit)
            ->where($condition)
            ->order_by(['service_add_at' => 'desc'])
            ->get(get_table('service'));

        $store_info = $this->db->get_row(get_table('store'), ['id' => $store_id]);
        if ($rows) {
            $rows = filter($rows);
            /** @var \model\ServiceModel $service_model */
            $service_model = \utils\Factory::getFactory('service');
            foreach ($rows as &$row) {
                $row['service_remuneration'] = $service_model->computedRemuneration($row['id']);
                $row['service_remuneration'] = number_format($row['service_remuneration'] / 100, 2);
                $row['service_add_at']       = date('Y-m-d H:i:s', $row['service_add_at']);
                $row['service_img'] && $row['service_img'] = explode(',', $row['service_img']);
                $row['store_level'] = $store_info['store_level']; // 店铺等级
                $cate_info          = $this->cache('cate.info.by.id.' . $row['service_level_2']);
                if (!$cate_info) {
                    $cate_info = $this->db->get_row(get_table('category'), ['id' => $row['service_level_2']]);
                    if ($cate_info) {
                        $this->cache('cate.info.by.id.' . $row['service_level_2'], filter($cate_info), 20); // 加20秒的缓存，优化数据过多时重复查询
                    }
                }
                $row['pay_way']      = $cate_info['pay_type'] ?? 2;
                $row['service_info'] = htmlspecialchars_decode($row['service_info']);
                $row['service_info'] = str_replace(['&amp;', '&quot;', '&#039;', '&lt;', '&gt;'], ['&', '"', "'", '<', '>'], $row['service_info']);
                unset($row['examine_at'], $row['no_pass_reason'], $row['service_is_show']);
            }
        }
        return $this->success($rows);
    }

    /**
     * 获取店铺今日交易列表
     * @router http://server.name/store.today.order
     */
    public function get_today_order()
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            throw $this->error('user-info-error');
        }

        $begintime = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
        $endtime   = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1);

//        $store = $this->db->get_row(get_table('store'), ['user_id' => $user_info->user_id]);
        $staff_row = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id]);

        if (!$staff_row) {
            return $this->error('当前用户没有开通店铺');
        }

        $store_info = $this->db->get_row(get_table('store'), ['user_id' => $user_info->user_id]);

        list($field, $sort, $offset, $limit, $condition) = $this->buildQuery();

        if ($store_info['store_parent_id'] == 0) {
            $map       = [
                'add_time >='           => strtotime($begintime),
                'add_time <='           => strtotime($endtime),
                'order_belong_store_id' => $staff_row['store_id']
            ];
            $condition = array_merge($condition, $map);
            $count     = $this->db->get_total(get_table('order'), $map);
            $orders    = $this->db->limit($offset, $limit)
                ->order_by(['add_time' => 'desc'])
                ->where($condition)
                ->get(get_table('order'));
        } else {
            $map    = [
                'a.add_time >='   => strtotime($begintime),
                'a.add_time <='   => strtotime($endtime),
                'b.appointed_uid' => $user_info->user_id,
            ];
            $count  = $this->db
                ->where($map)
                ->join([get_table('order_appointed') => 'b'], ['a.order_sn' => 'b.order_sn'], 'INNER')
                ->get_total([get_table('order') => 'a']);
            $orders = $this->db
                ->where($map)
                ->limit($offset, $limit)
                ->join([get_table('order_appointed') => 'b'], ['a.order_sn' => 'b.order_sn'], 'INNER')
                ->get([get_table('order') => 'a']);
        }
        if ($orders) {
            $orders = filter($orders);
            /** @var \model\OrderModel $order_model */
            $order_model = \utils\Factory::getFactory('order');
            foreach ($orders as &$order) {
                $order = $order_model->formatOrderRow($order);
            }
        }

        return $this->success($orders, $count);
    }

    /**
     * 店铺启用/暂用
     * @router http://server.name/store.auditing
     */
    public function updateStoreAuditing()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        if (!$id = (int)$this->router->get(1)) {
            return $this->error('没有获取到店铺/店员id');
        }
        if (!\model\TokenModel::isAdminSource()) {
            // 非后台操作，则判断是否店铺管理员以上的级别
            $store_row = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id]);

            if ($store_row['user_type'] == 1) {
                return $this->error('非管理员不能执行此操作');
            }
        }
        if (!$store_info = $this->db->get_row(get_table('store'), ['id' => $id])) {
            return $this->error('店铺不存在,操作失败');
        }

        if ($store_info['store_status'] == 0) {
            return $this->error('店铺未审核，操作失败');
        }

        $data['store_status'] = $store_info['store_status'] == 1 ? 2 : 1;
        $this->db->update(get_table('store'), $data, compact('id'));
        return $this->success(false);
    }

    /**
     * 获取店铺订单统计信息
     * @RequestMapping('/store.order.statistics')
     */
    public function getStoreOrderStatistics()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        $map['user_id'] = $user_info->user_id;
        $store_info     = $this->db
            ->select('a.*')
            ->join([get_table('store') => 'a'], ['a.id' => 'b.store_id'], 'INNER')
            ->get_row([get_table('store_user') => 'b'], ['b.user_id' => $user_info->user_id]);
        if (!$store_info) {
            return $this->error('您还未开通店铺!');
        }

        $map['order_belong_store_id'] = $store_info['id'];

        $count = [];
        foreach ([
                     'PENDING_ORDER', // 待接单
                     'PENDING_DOOR', // 待上门
                     'IN_SERVICE',// 服务中
                     'CLOSED', // 已关闭
                     'PENDING_ASSIGN', // 待接单
                     'PENDING_EVALUATE', // 待评价
                     'PENDING_PAY' // 待付款
                 ] as $_map) {
            $count[strtolower($_map)] = $this->db->get_total(get_table('order'), array_merge(['order_pay_state_dsc' => $_map], $map));
        }

        return $this->success($count, 1);
    }

    /**
     * 获取店铺的订单列表
     * @router http://server.name/store.order.list
     */
    public function getOrderList()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        $store_info = $this->db
            ->select('b.*', false)
            ->join([get_table('store') => 'b'], ['a.store_id' => 'b.id'], 'INNER')
            ->get_row([get_table('store_user') => 'a'], ['a.user_id' => $user_info->user_id]);
        if (!$store_info) {
            return $this->error('您还没有开通店铺!');
        }

        if ($store_info['store_status'] != 1) {
            return $this->error('店铺当前不可用');
        }
        list($field, $sort, $offset, $limit, $condition) = $this->buildQuery();
        $condition = array_merge($condition, [
            'order_belong_store_id' => $store_info['id'],
            'order_store_del'       => 0
        ]);
        /** @var \model\OrderModel $order_model */
        $order_model               = \utils\Factory::getFactory('order');
        $condition['order_sub_sn'] = 0; // 只显示一级订单，子订单不显示
        $count                     = $this->db->limit($offset, $limit)->where($condition)->get_total(get_table('order'));
        $orders                    = $this->db->limit($offset, $limit)->where($condition)->order_by(['add_time' => 'desc'])->get(get_table('order'));
        if ($orders) {
            $orders = filter($orders);
            foreach ($orders as &$order) {
                $order = $order_model->formatOrderRow($order, true);
            }
        }
        return success($orders, $count);
    }

    /**
     * @remark 审核店铺
     * @router http://server.name/store.shenhe-{id}
     */
    public function shenHe()
    {
        $id             = (int)$this->router->get(1);
        $data['pass']   = $this->request->post('pass', 0, 'trim');
        $data['reason'] = $this->request->post('reason', '', 'trim');

        if (!$data['pass']) {
            return $this->error('未知错误!');
        }

        $store_info = $this->db->get_row(get_table('store'), ['id' => $id]);
        if (!$store_info) {
            return $this->error('店铺不存在');
        }

        if ($store_info['store_status'] != 0) {
            return $this->error('当前状态不能执行审核');
        }

        if ($data['pass'] == 2) {
            $data['store_status']        = -1;
            $data['store_nopass_reason'] = $data['reason'];
        } else {
            $data['store_status'] = 1;
            $this->db->update(get_table('store_user'), [
                'staff_pass'     => 1,
                'staff_allow_at' => $_SERVER['REQUEST_TIME']
            ], ['user_id' => $store_info['user_id']]);
        }
        unset($data['pass'], $data['reason']);
        $this->db->update(get_table('store'), $data, ['id' => $id]);
        $dian_zhu_role_id = $this->db->get_row(get_table('role'), ['role_key' => 'dian_zhu'], 'id');
        $this->db->update('user', [
            'role_id' => $dian_zhu_role_id['id']
        ], ['user_id' => $store_info['user_id']]);
        return $this->success(false);
    }

    /**
     * 指派订单到指定店员
     * @RequestMapping('/appointed.order-{order_sn}')
     * @return mixed
     */
    public function appointedOrder()
    {
        try {
            $this->db->begin();
            $this->db->set_error_mode();
            $user_info = app('user_info');

            if (!$user_info || !isset($user_info->user_id)) {
                return $this->error('user-info-error');
            }

            $data['order_sn']      = $order_sn = $this->router->get(1);
            $data['order_sub_id']  = $this->router->get(2) ?: 0;
            $data['appointed_uid'] = $this->request->post('appointed_uid/a', [], 'trim'); // 新的分配，可以分配到多个服务员

            $this->validate($data, [
                'order_sn' => 'required'
            ]);
            if (!$order_info = $this->db->get_row(get_table('order'), ['order_sn' => $order_sn])) {
                return $this->error('订单号' . $order_info . '不存在');
            }
            // 原分配的店员服务总数-1
            $appointed_uid = explode('-', $order_info['appointed_uid']);
            if ($appointed_uid && $appointed_uid[0]) {
                /** @var PDOStatement $pdo_state */
                $pdo_state = $this->db->query(\model\dao\StaffDAO::getStaffByUserID($appointed_uid));
                $staff_ids = $pdo_state ? $pdo_state->fetchAll(PDO::FETCH_ASSOC) : [];
                foreach ($staff_ids as $staff_id) {
                    $this->db->set('staff_all_services', 'staff_all_services - 1', false)
                        ->update(get_table('store_staff_info'), null, ['staff_id' => $staff_id['id']]);
                }
            }
            array_multisort($data['appointed_uid'], SORT_ASC, SORT_NUMERIC);
            $appointed_uid_implode = implode('-', $data['appointed_uid']);
            if ($appointed_uid_implode == $order_info['appointed_uid']) {
                return $this->error('分配没有改动');
            }
            if ($order_info['order_pay_state_dsc'] != 'PAY_SUCCESS') {
                return $this->error('未支付订单不允许指派');
            }
            if (!in_array($order_info['order_state'], [1, 2], false)) {
                return $this->error('订单当前状态不允许指派,只有待确认与待服务的订单才能指派店员');
            }
            $appointed_user_ids = []; // 将要分配的用户id
            if (!$data['order_sub_id']) {
                $this->db->delete(get_table('order_appointed'), [
                    'order_sn' => $order_sn
                ]); // 删除旧的指派记录
            } else {
                $this->db->delete(get_table('order_appointed'), [
                    'order_sn'     => $order_sn,
                    'order_sub_id' => $data['order_sub_id']
                ]); // 删除旧的指派记录
                $this->db->update(get_table('order'), [
                    'order_bis_state_dsc' => 'PENDING_ASSIGN'
                ], [
                    'order_sub_sn' => $data['order_sub_id'],
                    'order_sn'     => $order_sn, // 分配的订单号
                ]);
            }
            $appointed_user_ids_explode = '';
            if (!$data['appointed_uid']) {
                $appointed_user_ids_explode = '';
            } else {
                /** @var \model\StoreModel $store_model */
                $store_model = \utils\Factory::getFactory('store');
                list($all_staffs, $can_assign_staff) = $store_model->getCanAssignStaff($data['order_sn'], $data['order_sub_id']);
                if ($can_assign_staff) {
                    $can_assign_staff = array_keys(array_flip($can_assign_staff));
                    /** @var PDOStatement $pdo_s */
                    $pdo_s              = $this->db->query(\model\dao\StaffDAO::getUserByStaffID($data['appointed_uid']));
                    $appointed_user_ids = $pdo_s ? $pdo_s->fetchAll(PDO::FETCH_ASSOC) : [];
                    if ($appointed_user_ids) {
                        $_appointed_user_ids = [];
                        foreach ($appointed_user_ids as $user_id) {
                            $_appointed_user_ids[] = $user_id['user_id'];
                        }
                        $appointed_user_ids = array_intersect($can_assign_staff, $_appointed_user_ids);
                        $appointed_user_ids && array_multisort($appointed_user_ids, SORT_ASC, SORT_NUMERIC);
                        $appointed_user_ids_explode = implode('-', $appointed_user_ids);
                    }
                } else {
                    throw new RuntimeException('无可指派店员');
                }
            }
            $where = ['order_sn' => $order_sn];
            if ($data['order_sub_id']) {
                $where['order_sub_sn'] = $data['order_sub_id'];
            }
            $this->db->update(get_table('order'), [
                'appointed_uid'       => $appointed_user_ids_explode,
                'order_bis_state_dsc' => $data['appointed_uid'] ? 'PENDING_DOOR' : 'PENDING_ASSIGN'
            ], $where);
            $insert_appointed = [];
            foreach ($appointed_user_ids as $user_id) {
//                $insert_appointed[] = [
//                    'order_sub_id'  => $data['order_sub_id'],
//                    'order_sn'      => $order_sn, // 分配的订单号
//                    'appointed_uid' => $user_id, // 受分配的用户id
//                    'appointed_at'  => $_SERVER['REQUEST_TIME'], // 分配订单的时间
//                    'appointer_id'  => $user_info->user_id // 执行分配的用户
//                ];
                $this->db->update(get_table('store_user'), [
                    'staff_current_order_sn'     => $data['order_sn'],
                    'staff_current_order_sub_id' => $data['order_sub_id']
                ], compact('user_id'));
            }
            if (!$data['order_sub_id']) {
                $count        = $this->db->get_total(get_table('order'), [
                    'order_sn'     => $data['order_sn'],
                    'is_sys_order' => 0
                ]);
                $order_sub_sn = $this->db->limit(0, $count)->get(get_table('order'), [
                    'order_sn'     => $data['order_sn'],
                    'is_sys_order' => 0
                ], 'order_sub_sn');
                foreach ($order_sub_sn as $sub_sn) {
                    $this->db->update(get_table('order'), [
                        'order_bis_state_dsc' => 'PENDING_DOOR'
                    ], [
                        'order_sub_sn' => $sub_sn['order_sub_sn'],
                        'order_sn'     => $order_sn, // 分配的订单号
                    ]);
                    foreach ($appointed_user_ids as $user_id) {
                        $insert_appointed[] = [
                            'order_sub_id'  => $sub_sn['order_sub_sn'],
                            'order_sn'      => $order_sn, // 分配的订单号
                            'appointed_uid' => $user_id, // 受分配的用户id
                            'appointed_at'  => $_SERVER['REQUEST_TIME'], // 分配订单的时间
                            'appointer_id'  => $user_info->user_id, // 执行分配的用户
                            'store_id'  =>  $order_info['order_belong_store_id'],
                            'order_begin_at'    =>  $order_info['contact_appointment_at'],
                            'order_end_at' => $order_info['contact_appointment_at'] + $order_info['service_length']
                        ];
                    }
                }
            }
            if ($insert_appointed) {
                $this->db->inserts(get_table('order_appointed'), $insert_appointed); //写入指派表
                // 新分配的店员服务总数+1
                /** @var PDOStatement $pdo_state */
                $pdo_state = $this->db->query(\model\dao\StaffDAO::getStaffByUserID($appointed_user_ids));
                $staff_ids = $pdo_state ? $pdo_state->fetchAll(PDO::FETCH_ASSOC) : [];
                foreach ($staff_ids as $staff_id) {
                    $this->db->set('staff_all_services', 'staff_all_services + 1', false)
                        ->update(get_table('store_staff_info'), null, ['staff_id' => $staff_id['id']]);
                }
            }
            $this->db->commit();
            return $this->success(false);
        } catch (PDOException $e) {
            $this->db->roll_back();
            echo $e;
            return $this->error('指派失败' . $e->getMessage());
        }
    }

    /**
     * 获取店铺操作规则列表
     * @router http://server.name/store.rule.list
     */
    public function storeRuleList()
    {
        $count = $this->db->get_total(get_table('rule'), ['rule_controller' => 'Store']);
        $rules = $this->db->limit(0, $count)->select(get_table('rule'), ['rule_controller' => 'Store']);
        return $this->success(filter($rules), $count);
    }

    /**
     * 店铺收益列表
     * @router http://server.name/store.income.log-{$staff_id}
     */
    public function incomeLog()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        list($field, $sort, $offset, $limit, $condition) = $this->buildQuery();

        $table_name = 'userbalance';
        if (\model\TokenModel::isAdminSource()) {
            if (!$user_id = $this->router->get(1)) {
                return $this->success([]);
            }
        } else {
            if (!$store_info = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id])) {
                return $this->error('您还未开通或加入店铺');
            }
            $user_id = $store_info['user_id'];
        }
        $where = ['user_id' => $user_id, 'is_store_log' => 1];
        $where = array_merge($condition, $where);
        $count = $this->db->get_total($table_name, $where);
        $rows  = $this->db->order_by(['ub_time' => 'desc'])->limit($offset, $limit)->get($table_name, $where);
        foreach ($rows as &$row) {
            $row['ub_money']   = sprintf('%.2f', $row['ub_money']);
            $row['ub_balance'] = sprintf('%.2f', $row['ub_balance']);
            $row['ub_time']    = date('Y-m-d H:i:s', $row['ub_time']);
        }
        return $this->success(filter($rows), $count);
    }

    /**
     * @router http://server.name/get.income.log
     * @return mixed@
     */
    public function getInComeLog()
    {
        $id         = (int)$this->router->get(1);
        $scene      = $this->request->post('scene', 'user', 'trim');
        $table_name = $scene == 'user' ? get_table('points_log') : get_table('store_wallet_log');
        $row        = $this->db->get_row($table_name, [
            'id' => $id
        ]);

        $row['log_at']          = date('Y-m-d H:i:s', $row['log_at']);
        $row['current_balance'] = sprintf('%.2f', $row['current_balance']);
        $row['wallet_change']   = sprintf('%.2f', $row['wallet_change']);

        return $this->success(filter($row));
    }

    /**
     * 获取店铺类型，1为最一级店铺 2为加盟的店铺
     * @router http://server.name/store.nature
     * @return mixed
     */
    public function getStoreNature()
    {
        /** @var \model\UserModel $user_model */
        $user_model = \utils\Factory::getFactory('user');
        list($store_info, $user_info) = $user_model->userStoreInfo();

        if (!$store_info) {
            return $this->error('用户未申请店铺');
        }

        $nature = $store_info['parent_id'] == 0 ? 1 : 2;
        return $this->success(compact('nature'));
    }

    /**
     * 店铺自动接单开关切换
     * @router http://server.name/store.receipt.toggle
     */
    public function toggleReceipt()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        $store_row = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id]);
        if (!$store_row) {
            return $this->error('用户未申请店铺');
        }

        if ($store_row['user_type'] == 1 || $store_row['user_type_key'] == 'SERVER') {
            return $this->error('店员无权操作');
        }

        if (!$store_info = $this->db->get_row(get_table('store'), ['user_id' => $store_row['store_id']])) {
            return $this->error('用户未申请店铺');
        }

        $this->db->update(get_table('store'), [
            'store_auto_receipt' => $store_info['store_auto_receipt'] == 1 ? 0 : 1
        ], [
            'id' => $store_info['id']
        ]);
        return $this->success(false);
    }

    /**
     * 获取店铺店员列表
     * @RequestMapping('/store.clerk.list')
     */
    public function getStoreClerkList()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        $data['distributable'] = $this->request->post('distributable', 0, 'intval');
        $data['order_sn']      = $this->request->post('order_sn', '', 'trim');
        $table_name            = get_table('store_user');
        $select                = '';
        $columns               = $this->db->query("select COLUMN_NAME from INFORMATION_SCHEMA.Columns where table_name='{$this->db->get_prefix(get_table('store_staff_info'))}'");
        foreach ($columns as $column) {
            if ($column['COLUMN_NAME'] == 'id' || $column['COLUMN_NAME'] == 'staff_id') {
                continue;
            }
            $select .= 'c.' . $column['COLUMN_NAME'] . ',';
        }

        list($field, $sort, $offset, $limit, $condition) = $this->buildQuery();
        if (\model\TokenModel::isAdminSource()) {
            $store_id = (int)$this->router->get(1);
        } else {
            $store_row = $this->db->get_row($table_name, ['user_id' => $user_info->user_id], 'store_id, user_type');
            $store_id  = $store_row['store_id'];
        }
        $condition = array_merge($condition, [
            'user_type <>' => 3,
            'staff_status' => 1,
            'store_id'     => $store_id
        ]);

        if (\model\TokenModel::isAdminSource()) {
            unset($condition['user_type <>']);
        }
        $count = $this->db->get_total($table_name, $condition);

        $rows = $this->db
            ->where($condition)
            ->limit($offset, $limit)
            ->select('a.*, b.user_pic,' . trim($select, ','), false)
            ->join([$table_name => 'a'], ['a.user_id' => 'b.user_id'], 'INNER')
            ->join([get_table('store_staff_info') => 'c'], ['c.staff_id' => 'a.id'], 'INNER')
            ->order_by(['a.user_type' => 'DESC', 'staff_add_at' => 'desc'])
            ->get(['user' => 'b']);

        foreach ($rows as &$row) {
            $row['staff_add_at']   = date('Y-m-d H:i', $row['staff_add_at']);
            $row['staff_allow_at'] = date('Y-m-d H:i', $row['staff_allow_at']);
        }
        return $this->success(array_merge(filter($rows), []), $count);
    }

    /**
     * 修改店员信息
     * @router http://server.name/staff.update-{staff_id}
     */
    public function updateStaffInfo()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        if (!$staff_id = (int)$this->router->get(1)) {
            return $this->error('店员ID不能为空');
        }
        $store_row = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id]);
        if (!$store_row) {
            return $this->error('您还未申请店铺');
        }
        $data['staff_tel'] = $this->request->post('store_phone', '', 'trim');

        $this->validate($data, [
            'store_phone' => 'required|phone'
        ]);

        if ($staff_row = $this->db->get_row(get_table('store_user'), ['user_id' => $staff_id])) {
            return $this->error('店员记录不存在');
        }

        if ($staff_row['store_id'] != $store_row['store_id']) {
            return $this->error('该店员不属于您的店铺，不允许修改');
        }
        $this->db->update(get_table('store'), $data, ['user_id' => $staff_id]);
        return $this->success(false);
    }

    /**
     * 获取指定店员的信息
     * @RequestMapping('/store.staff.info.get-{staff_id}')
     */
    public function getStaffInfo()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        $staff_id          = (int)$this->router->get(1);
        $user_belong_store = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id]);
        if (!$user_belong_store) {
            return $this->error('您暂无店铺记录');
        }
        if (!$staff_row = $this->db->get_row(get_table('store_user'), ['id' => $staff_id])) {
            return $this->error('店员记录不存在');
        }

        if ($user_belong_store['store_id'] != $staff_row['store_id']) {
            return $this->error('该店员不属于您的店铺');
        }
        $select  = '';
        $columns = $this->db->query("select COLUMN_NAME from INFORMATION_SCHEMA.Columns where table_name='{$this->db->get_prefix(get_table('store_staff_info'))}'");
        foreach ($columns as $column) {
            if ($column['COLUMN_NAME'] == 'id' || $column['COLUMN_NAME'] == 'staff_id') {
                continue;
            }
            $select .= 'b.' . $column['COLUMN_NAME'] . ',';
        }
        $staff_store_info = $this->db
            ->select('a.*, c.user_pic,' . trim($select, ','), false)
            ->join([get_table('store_staff_info') => 'b'], ['a.id' => 'b.staff_id'], 'INNER')
            ->join(['user' => 'c'], ['a.user_id' => 'c.user_id'], 'LEFT')
            ->get_row([get_table('store_user') => 'a'], ['a.id' => $staff_id]);

        $staff_store_info['staff_add_at']   = date('Y-m-d H:s', $staff_store_info['staff_add_at']);
        $staff_store_info['staff_allow_at'] = date('Y-m-d H:s', $staff_store_info['staff_allow_at']);
        return $this->success(filter($staff_store_info));
    }

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
                'id'       => $staff_id,
                'store_id' => $store_row['store_id']
            ]
        );
        return $this->success(false);
    }

    /**
     * @remark 查看指定店员的服务记录;
     * @RequestMapping('/staff.service.record-{staff_id}')
     */
    public function getStaffServiceRecord()
    {
        // 1 获取已完成 0 获取未完成
        $data['list_state'] = $this->request->post('state', 0, 'intval');
        if (!in_array($data['list_state'], [0, 1], false)) {
            return $this->error('状态未定义');
        }
        if (!$staff_id = (int)$this->router->get(1)) {
            return $this->error('店员id必须');
        }
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        $store_user_table  = get_table('store_user');
        $current_staff_row = $this->db->get_row($store_user_table, ['user_id' => $user_info->user_id]);

        if ($current_staff_row['user_type'] == 3) {
            // 店主统计店铺所有订单
            $where = ['a.order_belong_store_id' => $current_staff_row['store_id'], 'b.completed' => $data['list_state'], 'a.order_sub_sn' => 0];
        } else {
            $staff_row = $this->db->get_row(get_table('store_user'), ['user_id' => $staff_id], 'store_id');
            if (!\model\TokenModel::isAdminSource() && $staff_row['store_id'] != $current_staff_row['store_id']) {
                return $this->error('该店员不属于您的店铺');
            }
            $where = ['b.appointed_uid' => $staff_id, 'a.order_belong_store_id' => $staff_row['store_id'], 'b.completed' => $data['list_state'], 'a.order_sub_sn' => 0];
        }

        if (\model\TokenModel::isAdminSource()) {
            unset($where['b.completed']);
        }

        $count = $this->db
            ->where($where)
            ->join([get_table('order_appointed') => 'b'], ['a.order_sn' => 'b.order_sn', 'a.order_sub_sn' => 'b.order_sub_id'], 'INNER')
            ->get_total([get_table('order') => 'a']);

        $orders = [];
        if ($count) {
            list($field, $sort, $offset, $limit, $condition) = $this->buildQuery();
            $where = ['a.order_belong_store_id' => $current_staff_row['store_id'], 'a.order_rate' => $data['list_state'], 'a.order_sub_sn' => 0];
            if ($current_staff_row['user_type'] != 3) {
                $where['b.appointed_uid'] = $staff_id;
            }

            if (\model\TokenModel::isAdminSource()) {
                unset($where['a.order_rate']);
            }

            $where['a.order_sub_sn'] = 0;
            $orders                  = $this->db
                ->order_by(['a.add_time' => 'desc'])
                ->limit($offset, $limit)
                ->where($where)
                ->select('a.*', false)
                ->join([get_table('order_appointed') => 'b'], ['a.order_sn' => 'b.order_sn', 'a.order_sub_sn' => 'b.order_sub_id'], 'INNER')
                ->get([get_table('order') => 'a']);

            /** @var \model\OrderModel $order_model */
            $order_model = \utils\Factory::getFactory('order');
            foreach ($orders as &$order) {
                $order = $order_model->formatOrderRow($order, true);
            }
        }
        return $this->success($orders, $count);
    }

    /**
     * 移除指定店员
     * @router http://server.name/store.staff.remove-{staff_id}
     */
    public function removeStoreStaff()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        $data['staff_id'] = (int)$this->router->get(1);
        $this->validate($data, [
            'staff_id' => 'required|number'
        ]);
        $current_store_row = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id]);
        if (!$staff_row = $this->db->get_row(get_table('store_user'), ['id' => $data['staff_id']])) {
            return $this->error('无记录');
        }

        if ($staff_row['store_id'] != $current_store_row['store_id']) {
            return $this->error('该店员不属于您的店铺');
        }
        try {
            $this->db->begin();
            $this->db->set_error_mode();
            // 获取该店员是否已有分配的订单
            $order_appointed = $this->db
                ->get_total(get_table('order_appointed'), ['appointed_uid' => $data['staff_id']]);
            if ($order_appointed) {
                return $this->error('该店员当前存在未完成订单');
            }
            //todo::软删除
            $this->db->delete(get_table('store_user'), ['id' => $staff_row['id']]);
            $this->db->delete(get_table('order_appointed'), ['appointed_uid' => $staff_row['id']]);
            $this->db->commit();
            return $this->success('移除店员成功');
        } catch (Exception $e) {
            $this->db->roll_back();
            return $this->error('移除失败!' . $e->getMessage());
        }
    }

    /**
     * 更新订单状态
     * @router http://server.name/order.change.status-receipt 接单，更新为待确认；既待上门
     * @router http://server.name/order.change.status-begin 开始服务，更新为服务中
     * @router http://server.name/order.change.status-completed 服务商主动完成，更新为已完成
     */
    public function changeOrderStatus()
    {
        $target_status = $this->router->get(1);

        if (!in_array($target_status, ['receipt', 'begin', 'completed'])) {
            return $this->error('更新状态未定义');
        }

        $order_sn     = $this->router->get(2);
        $order_sub_sn = $this->router->get(3) ?: 0;
        if (!$order_sn) {
            return $this->error('订单流水号必须');
        }

        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            throw new \RuntimeException('user-info-error');
        }

        $staff_row = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id]);
        if (!$store_info = $this->db->get_row(get_table('store'), ['id' => $staff_row['store_id']])) {
            return $this->error('您还未开通店铺!');
        }


        if ($store_info['store_status'] != 1) {
            return $this->error('店铺当前不可用!');
        }

        $order_info = $this->db->get_row(get_table('order'), ['order_sn' => $order_sn, 'order_sub_sn' => $order_sub_sn]);
        if (!$order_info) {
            return $this->error('订单不存在或已关闭');
        }

        $result = false;
        /** @var \model\MessageModel $message_model */
        $message_model = \utils\Factory::getFactory('message');

        /** @var PDOStatement $pdo_state */
        $pdo_state   = $this->db->query(\model\dao\StaffDAO::getOrderAappointed($order_sn, $order_sub_sn));
        $captain_row = $pdo_state ? $pdo_state->fetch(PDO::FETCH_ASSOC) : [];

        try {
            $this->db->begin();
            // 接单逻辑
            if ('receipt' === $target_status) {
                if ($order_info['order_pay_state_dsc'] != 'PAY_SUCCESS') {
                    return $this->error('未支付的订单不能接单');
                }

                if ($order_info['order_type'] == 1 && $order_info['order_belong_store_id'] != $store_info['id']) {
                    return $this->error('该订单不属于您的店铺，不能执行此操作');
                }
                $result = $this->db->update(get_table('order'), [
                    'order_state'         => 2,
                    'order_bis_state_dsc' => 'PENDING_ASSIGN', // 接单后更新订单业务状态为待分配
                    'receipt_at'          => $_SERVER['REQUEST_TIME']
                ], compact('order_sn'));

                $message_model->notifyUser($order_info['user_id'], '您的订单已经接单啦，为了保障服务质量请保持与服务人员保持沟通');
                OrderModel::orderLogger("{$order_info['order_sn']}-{$order_sub_sn}", $staff_row['id'], "订单已接单成功，接单店铺:{$store_info['store_name']}", 'SERVER');
            }

            // 开始订单逻辑
            if ('begin' === $target_status) {

                if (!$captain_row) {
                    return $this->error('订单没有指派人员');
                }

                // 第一个接受的服务员才能点已完成订单
                if ($captain_row['appointed_uid'] != $user_info->user_id) {
                    return $this->error('您无权执行此操作，需要小队长才能操作');
                }

                if ($order_info['order_belong_store_id'] != $staff_row['store_id']) {
                    return $this->error('该订单不属于您的店铺，不能执行此操作');
                }

                if ($order_info['order_bis_state_dsc'] != 'PENDING_DOOR') {
                    return $this->error('订单当前状态不允许开始服务');
                }

                // 判断当前时间是否在预约时间之后
                if ($order_info['order_type'] == 1 && !APP_DEBUG) {
                    if ($order_info['contact_appointment_at'] > $_SERVER['REQUEST_TIME']) {
                        return $this->error('未到预约时间');
                    }
                }
                $result = $this->db->update(get_table('order'), [
                    'order_state'         => 3,
                    'order_bis_state_dsc' => 'IN_SERVICE',
                    'order_sm_at'         => $_SERVER['REQUEST_TIME']
                ], compact('order_sn', 'order_sub_sn'));
                $message_model->notifyUser($order_info['user_id'], '您的订单已经开始服务啦！')->appPush();
                OrderModel::orderLogger("{$order_info['order_sn']}-{$order_sub_sn}", $staff_row['id'], "订单已经开始服务，服务人员:{$staff_row['staff_name']}", 'SERVER');
            }
            // 服务商主动完成订单
            if ('completed' === $target_status) {

                if (!$captain_row) {
                    return $this->error('订单没有指派人员');
                }

//                if ($order_info['order_bis_state_dsc'] != 'IN_SERVICE') {
//                    return $this->error('订单状态不为服务中，不可结束!');
//                }

                // 第一个接受的服务员才能点已完成订单
                if ($captain_row['appointed_uid'] != $user_info->user_id) {
                    return $this->error('您无权执行此操作，需要小队长才能操作');
                }

                if ($order_info['order_belong_store_id'] != $staff_row['store_id']) {
                    return $this->error('该订单不属于您的店铺，不能执行此操作');
                }

                if ($_SERVER['REQUEST_TIME'] < $order_info['contact_appointment_at'] + $order_info['service_length'] * 3600) {
                    return $this->error('未到订单可完成时间');
                }

                $this->db->set_error_mode();
                $result = $this->db->update(get_table('order'), [
                    'order_rate'          => 1,
                    'order_bis_state_dsc' => 'PENDING_EVALUATE',
                    'complete_at'         => $_SERVER['REQUEST_TIME']
                ], compact('order_sn', 'order_sub_sn'));
                $this->db->update(get_table('order_appointed'), ['completed' => 1], [
                    'order_sn'     => $order_sn,
                    'order_sub_id' => $order_sub_sn
                ]);
                $this->db->update(get_table('store_user'), [
                    'staff_current_order_sn'     => '',
                    'staff_current_order_sub_id' => 0
                ], ['user_id' => $user_info->user_id]);
                // 累计总服务时长、总服务平方数
                if ($order_info['order_type'] == 1) {
                    $service_info = $this->db
                        ->get_row(get_table('service'), ['id' => $order_info['order_type_id']]);
                    if ($service_info['service_value_unit_id'] == 4) {
                        // 按平方收费，统计到平方数
                        $this->db->set('staff_all_pf', "staff_all_pf + {$order_info['service_length']}", false)
                            ->update(get_table('store_user'), null, ['user_id' => $user_info->user_id]);
                    } elseif ($service_info['service_value_unit_id'] == 2) {
                        // 按时收费类型计算到服务时长
                        $service_length = $_SERVER['REQUEST_TIME'] - $order_info['order_sm_at'];
                        $this->db->set('staff_all_order_time', "staff_all_order_time + {$service_length}", false)
                            ->update(get_table('store_user'), null, ['user_id' => $user_info->user_id]);
                    }
                }
                $message_model->notifyUser($order_info['user_id'], '您的订单已经完成啦，如果有问题请及时与服务人员沟通。不要忘记评价订单以便服务人员获得订单佣金哦！')->appPush();
                $appointed_uid = explode('-', $order_info['appointed_uid']);
                /** @var PDOStatement $pdo_steam */
                $pdo_steam = $this->db->query(\model\dao\StaffDAO::getStaffByUserID($appointed_uid));
                $staff_ids = $pdo_steam ? $pdo_steam->fetchAll(\PDO::FETCH_ASSOC) : [];
                foreach ($staff_ids as $staff_id) {
                    $this->db->set('staff_total_services', 'staff_total_services + 1', false)
                        ->update(get_table('store_staff_info'), null, ['staff_id' => $staff_id['id']]);
                }
                OrderModel::orderLogger("{$order_info['order_sn']}-{$order_sub_sn}", $staff_row['id'], "订单已经服务完成，服务人员:{$staff_row['staff_name']}", 'SERVER');
            }
            if ($result) {
                $this->db->commit();
                return $this->success(false);
            }
            throw new RuntimeException('更新订单信息错误');
        } catch (Exception $e) {
            $this->db->roll_back();
            return $this->error($e->getMessage());
        }
    }

    /**
     * 店铺删除订单，软删除
     * @router http://server.name/store.delete.order-{order_sn}
     */
    public function deleteOrder()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        if (!$order_sn = $this->router->get(1)) {
            return $this->error('订单号必须');
        }
        $order_info = $this->db->get_row(get_table('order'), compact('order_sn'));
        if (!$staff_row = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id])) {
            return $this->error('无店员记录');
        }

        if ($order_info['order_belong_store_id'] != $staff_row['store_id']) {
            return $this->error('该订单不属于您的店铺');
        }
        $this->db->update(get_table('order'), ['order_store_del' => 1], compact('order_sn'));
        $this->db->insert(get_table('order_log'), [
            'order_sn' => $order_sn,
            'log_at'   => $_SERVER['REQUEST_TIME'],
            'log'      => '订单解除与店铺的绑定',
            'uid'      => $user_info->user_id,
        ]);
        return $this->success(false);
    }

    /**
     * 获取、修改店铺订单分配策略
     * @RequestMapping('/store.get.customize-{store_id}')
     */
    public function getStoreCustomize()
    {
        if ($store_id = (int)$this->router->get(1)) {
            if (!$store_info = $this->db->get_total(get_table('store'), ['id' => $store_id])) {
                return $this->error('店铺不存在');
            }
        } else {
            return $this->error('店铺id必须');
        }
        // GET请求下获取的时该店铺的结算策略
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // 读取默认策略
            $default_config_map  = [
                'default_star_rated_return'  // 默认各星级对应的订单结算策略
                , 'default_service_remuneration' // 默认服务员劳务报酬
                , 'default_shop_division' // 默认店铺分成
                , 'default_platform_actual_income' // 默认平台所得
            ];
            $default_setting_row = [];
            foreach ($default_config_map as $map) {
                $_map                       = str_replace('default_', '', $map);
                $config_value               = $this->db->get_row(get_table('config'), ['config_key' => $map], 'config_value');
                $default_setting_row[$_map] = $config_value ? $config_value['config_value'] : false;
            }
            $customize_setting_row = $this->db->get_row(get_table('store_settlement_setting'), ['store_id' => $store_id]);
            // 整合默认策略
            if (!$customize_setting_row) {
                $customize_setting_row = $default_setting_row;
            } else {
                $customize_setting_row = array_merge($default_setting_row, $customize_setting_row);
            }
            // 格式化星级对应的订单结算策略
            foreach (explode('-', $customize_setting_row['star_rated_return']) as $key => $item) {
                $customize_setting_row['star_rated_return_' . $key] = $item;
            }
            unset($customize_setting_row['star_rated_return']);
            return $this->success(filter($customize_setting_row));
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // POST则为更新该店铺的订单分配策略
            $data['service_remuneration']   = $this->request->post('service_remuneration', 0, 'trim'); // 服务员劳务报酬
            $data['shop_division']          = $this->request->post('shop_division', 0, 'trim'); // 店铺分成
            $data['platform_actual_income'] = $this->request->post('platform_actual_income', 0, 'trim'); // 平台实际所得
            $data['star_rated_return']      = $this->request->post('star_rated_return', '', 'trim'); // 店铺各星级对应的订单结算分配策略

            $_count = 0;
            foreach ($data as $key => $value) {
                $_count += $value;
            }
            if ($_count > 100) {
                return $this->error('总分配策略不能超过100%');
            }
            if ($_count < 100) {
                // 如果加起来不够的100的话，平台的收入等于100 - 阿姨的收入 - 店铺的收入
                $data['platform_actual_income'] = 100 - ($data['shop_division'] + $data['service_remuneration']);
            }

            $data['star_rated_return'] = explode('-', $data['star_rated_return']);
            $_count                    = count($data['star_rated_return']);
            if ($_count < 6) {
                $default_star_rated_return = $this->db->get_row(get_table('config'), ['config_key' => 'default_star_rated_return'], 'config_value');
                if ($default_star_rated_return && $default_star_rated_return['config_value']) {
                    $default_star_rated_return = explode('-', $default_star_rated_return['config_value']); // 获取默认各星级对应的订单结算策略
                }

                for ($i = 0; $i < $_count; $i++) {
                    array_shift($default_star_rated_return);
                }

                $data['star_rated_return'] = array_merge($data['star_rated_return'], $default_star_rated_return); // 合并到一起
            }
            sort($data['star_rated_return']);
            if (end($data['star_rated_return']) > $data['service_remuneration']) {
                return $this->error('五星的分配百分比超过最大的分配策略');
            }
            $data['star_rated_return'] = implode('-', $data['star_rated_return']);

            $has_row = $this->db->get_total(get_table('store_settlement_setting'), compact('store_id'));
            if ($has_row) {
                $this->db->update(get_table('store_settlement_setting'), $data, compact('store_id'));
            } else {
                $data['store_id'] = $store_id;
                $this->db->insert(get_table('store_settlement_setting'), $data);
            }

            return $this->success(false);
        }
    }

    /**
     * @param $method
     * @return mixed|string
     */
    public function getMethodRouterParams($method)
    {
        $router_params = explode('-', $this->router->get_parse_url()['path']);
        $params        = [
            'changeOrderStatus' => function () use ($router_params) {
                return $router_params[1];
            }
        ];
        return $params[$method] ?? '';
    }
}