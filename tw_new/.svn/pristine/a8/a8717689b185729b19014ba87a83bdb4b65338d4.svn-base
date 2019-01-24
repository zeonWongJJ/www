<?php
/**
 * 店铺控制器
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

use Controller\Application;

/**
 * Class Store_ctrl
 */
class Store_ctrl extends Application
{
    protected $repository = \repositories\StoreRepository::class;

    public function setField()
    {
        return [
            'store_name'               => '店铺名字'
            , 'store_director'         => '店铺负责人名称'
            , 'store_id_card_positive' => '店铺负责人身份证正面图片'
            , 'store_id_card_opposite' => '店铺负责人身份证背面图片'
            , 'store_zizhi_positive'   => '店铺资质正面图片'
            , 'store_zizhi_opposite'   => '店铺资质反面图片'
            , 'store_phone'            => '店铺负责人联系电话'
            , 'store_range'            => '店铺服务范围'
            , 'store_region'           => '店铺所在地区'
            , 'store_address'          => '店铺详细地址'
            , 'store_pic'              => '店铺图片'
            , 'store_info'             => '店铺描述'
            , 'store_id_card'          => '店铺负责人身份证号码'
            , 'order_sn'               => '订单流水号'
            , 'appointed_uid'          => '指派用户id'
            , 'staff_id'               => '店员id'
        ];
    }

    /**
     * 新增店铺
     * @router http://server.name/store.add
     * @return mixed
     */
    public function insert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['store_parent_id']) || !$_POST['store_parent_id']) {
                $data = $this->getData('insert');
            } else {
                $data = $this->getData('league');
            }
            return $this->repository->insert($data);
        }
        return $this->error('isp-invalid-request');
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
            'store_info'             => $this->request->post('store_info', '', 'trim'),
            'store_zizhi_positive'   => $this->request->post('store_zizhi_positive', '', 'trim'), // 资质正面
            'store_zizhi_opposite'   => $this->request->post('store_zizhi_opposite', '', 'trim'), // 资质反面
        ];

        $data = [
            'insert' => $row,
            'update' => $row,
            'league' => [
                'store_director'           => $this->request->post('store_director', '', 'trim')
                , 'store_id_card_positive' => $this->request->post('store_id_card_positive', '', 'trim')
                , 'store_id_card_opposite' => $this->request->post('store_id_card_opposite', '', 'trim')
                , 'store_parent_id'        => $this->request->post('store_parent_id', 0, 'intval')
                , 'store_id_card'          => $this->request->post('store_id_card', '', 'trim')
                , 'store_zizhi_positive'   => $this->request->post('store_zizhi_positive', '', 'trim') // 资质正面
                , 'store_zizhi_opposite'   => $this->request->post('store_zizhi_opposite', '', 'trim') // 资质反面
                , 'store_phone'            => $this->request->post('store_phone', '', 'trim')
            ]
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
        $rows = [
            'store_name'             => 'required',
            'store_director'         => 'required',
            'store_id_card_positive' => 'required',
            'store_id_card_opposite' => 'required',
//            'store_zizhi_positive'   => 'required',
//            'store_zizhi_opposite'   => 'required',
            'store_phone'            => 'required|phone',
            'store_range'            => 'required|number',
            'store_region'           => 'required',
            'store_address'          => 'required',
            'store_pic'              => 'required',
            'store_info'             => 'required',
            'store_type'             => 'required',
            'store_id_card'          => 'required|length:18'
        ];

        if ('admin' === $this->router->get(1)) {
            unset($rows['store_range'], $rows['store_region'], $rows['store_info']);
        }

        $valid = [
            'insert' => $rows,
            'update' => $rows,
            'league' => [
                'store_director'           => 'required'
                , 'store_id_card_positive' => 'required'
                , 'store_id_card_opposite' => 'required'
                , 'store_phone'            => 'required|phone'
                , 'store_parent_id'        => 'required|number'
            ]
        ];

        return $valid[$method] ?? [];
    }

    // - 更多方法定义

    /**
     * 店铺修改接口
     * @router http://server.name/store.update-{store_id}
     * @return mixed
     */
    public function update()
    {
        if (!(int)$id = $this->router->get(1)) {
            return $this->error('店铺/店员id为空!');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['store_parent_id']) || !$_POST['store_parent_id']) {
                $data = $this->getData('update');
                $this->validate($data, $this->valid('update'));
            } else {
                $data = $this->getData('league');
                $this->validate($data, $this->valid('league'));
            }
            return $this->repository->update($data, $id);
        }
        return $this->error('isp-invalid-request');
    }

    /**
     * 获取店铺下的所有服务列表
     * @router http://server.name/store.get.servers-{store_id}
     */
    public function getServers()
    {
        $store_id = $this->router->get(1);
        list($field, $sort, $offset, $limit, $condition) = $this->buildQuery();
        $rows       = $this->db->limit($offset, $limit)
            ->where(['store_id' => $store_id, 'service_is_del' => 0])
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
                $row['service_img']          = explode(',', $row['service_img']);
                $row['store_level']          = $store_info['store_level']; // 店铺等级

                $cate_info = $this->cache('cate.info.by.id.' . $row['service_level_2']);
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

        return $this->success($rows ?: []);
    }

    /**
     * 获取店铺下的所有评论
     * @router http://sever.name/store.get.comment
     */
    public function getComment()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        $staff_row = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id]);
        if (!$staff_row) {
            return $this->error('当前用户没有开通店铺，不能请求该接口');
        }
        $map['comment_store_id'] = $staff_row['store_id'];
        list($field, $sort, $offset, $limit, $condition) = $this->buildQuery();
        $count = $this->db->where($map)->get_total(get_table('comment'));
        $rows  = $this->db->where($map)->limit($offset, $limit)->get(get_table('comment'));
        return $this->success($rows, $count);
    }

    /**
     * 获取当前用户的店铺的统计数据
     * @router http://server.name/user.store.statistics
     */
    public function getMyStoreCount()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        $map['user_id'] = $user_info->user_id;
        $count          = $this->db->get_row(get_table('store'), $map, 'store_service_count, store_comment_count, id, store_total_income, store_parent_id');
        // 获取当日的店铺订单
        $count['pay_count'] = 0;
        // 获取当天零点
        $t     = time();
        $start = mktime(0, 0, 0, date('m', $t), date('d', $t), date('Y', $t));
        $end   = mktime(23, 59, 59, date('m', $t), date('d', $t), date('Y', $t));

        if (0 == $count['store_parent_id']) {
            $count_order_map      = [
                'add_time >='           => $start,
                'add_time <='           => $end,
                'order_belong_store_id' => $count['id']
            ];
            $count['order_count'] = $this->db->where($count_order_map)->get_total(get_table('order')); // 今日订单
            $orders               = $this->db->limit(0, $count['order_count'])->get(get_table('order'), $count_order_map);  // 获取当日的交易额
        } else {
            $count_order_map      = [
                'a.add_time >='   => $start,
                'a.add_time <='   => $end,
                'b.appointed_uid' => $user_info->user_id
            ];
            $count['order_count'] = $this->db->where($count_order_map)
                ->join([get_table('order_appointed') => 'b'], ['a.order_sn' => 'b.order_sn'], 'INNER')
                ->get_total([get_table('order') => 'a']);
            $orders               = $this->db->limit(0, $count['order_count'])->where($count_order_map)->join([get_table('order_appointed') => 'b'], ['a.order_sn' => 'b.order_sn'], 'INNER')->get([get_table('order') => 'a']);
        }

        foreach ($orders as $order) {
            if ($order['order_state'] == 5) {
                $count['pay_count'] += $order['order_amount'];
            }
        }
//        unset($count['id']);
        $count['pay_count']     = number_format($count['pay_count'] / 100, '4', '.', ',');
        $count['_30days_count'] = 0;
        $all_30_days_orders     = $this->db->get(get_table('order'), [
            'order_belong_store_id' => $count['id']
            , 'order_state <>'      => 4
//            , 'order_comment_id <>' => 0
            , 'pay_time >='         => strtotime('-30 day')
            , 'pay_time <='         => $_SERVER['REQUEST_TIME']
        ], 'order_amount');
        if ($all_30_days_orders) {
            foreach ($all_30_days_orders as $order) {
                $count['_30days_count'] += $order['order_amount'];
            }
        }
        $count['_30days_count'] = sprintf('%.4f', $count['_30days_count'] / 100);
        return $this->success(filter($count));
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
            throw new \RuntimeException('user-info-error');
        }
        if (!$id = (int)$this->router->get(1)) {
            return $this->error('没有获取到店铺/店员id');
        }
        /** @var \model\UserModel $user_model */
        $user_model = \utils\Factory::getFactory('user');
        if (!$user_model->isAdmin()) {
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
     * @router http://server.name/store.order.statistics
     */
    public function getStoreOrderStatistics()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        $map['user_id'] = $user_info->user_id;
        $store_info     = $this->db->get_row('jiajie_store', $map);
        if (!$store_info) {
            return $this->error('您还未开通店铺!');
        }

        $count['pending_order']   = $this->db->get_total('jiajie_order', [
            'order_belong_store_id' => $store_info['id']
            , 'order_state'         => 0
        ]);
        $count['pending_service'] = $this->db->get_total('jiajie_order', [
            'order_belong_store_id' => $store_info['id']
            , 'order_state'         => 2
        ]);
        $count['servicing']       = $this->db->get_total('jiajie_order', [
            'order_belong_store_id' => $store_info['id']
            , 'order_state'         => 3
            , 'order_rate'          => 0
        ]);
        $count['closed']          = $this->db->get_total('jiajie_order', [
            'order_belong_store_id' => $store_info['id']
            , 'order_state'         => 4
        ]);
        $count['pending_receipt'] = $this->db->get_total('jiajie_order', [
            'order_type'              => 1
            , 'order_belong_store_id' => $store_info['id']
            , 'order_state'           => 1
        ]);

        $this->success($count);
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
        $order_model = \utils\Factory::getFactory('order');
        $count       = $this->db->limit($offset, $limit)->where($condition)->get_total(get_table('order'));
        $orders      = $this->db->limit($offset, $limit)->where($condition)->order_by(['add_time' => 'desc'])->get(get_table('order'));
        if ($orders) {
            $orders = filter($orders);
            foreach ($orders as &$order) {
                $order = $order_model->formatOrderRow($order, true);
            }
        }
        return success($orders, $count);
    }


    /**
     * 审核店铺
     * @router http://server.name/store.shenhe-{id}
     */
    public function shenHe()
    {
        $id             = (int)$this->router->get(1);
        $data['pass']   = $this->request->post('pass', 0, 'intval');
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
     * @router http://server.name/appointed.order-{order_sn}
     * @return mixed
     */
    public function appointedOrder()
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        $data['order_sn'] = $order_sn = $this->router->get(1);
//        $data['appointed_uid'] = $this->request->post('appointed_uid', 0, 'intval'); // 旧分分配方式只分配到一个服务员
        $data['appointed_uid'] = $this->request->post('appointed_uid/a', [], 'trim'); // 新的分配，可以分配到多个服务员

        if (!$data['appointed_uid']) {
            $this->db->update(get_table('order'), ['order_bis_state_dsc' => 'PENDING_ASSIGN'], compact('order_sn'));
        }

        $this->validate($data, [
            'order_sn' => 'required'
        ]);

        if (!$order_info = $this->db->get_row(get_table('order'), ['order_sn' => $order_sn])) {
            return $this->error('订单号' . $order_info . '不存在');
        }

        array_multisort($data['appointed_uid'], SORT_ASC, SORT_NUMERIC);
        $appointed_uid_implode = implode('-', $data['appointed_uid']);
        if ($appointed_uid_implode == $order_info['appointed_uid']) {
            return $this->error('分配没有改动');
        }

        if ($order_info['order_pay_state_dsc'] != 'PAY_SUCCESS') {
            return $this->error('未支付订单不允许指派');
        }

        if ($order_info['order_belong_store_id'] == 20) {
            if ($order_info['order_pay_state_dsc'] == 'PAY_SUCCESS' && !in_array($order_info['order_bis_state_dsc'], ['PENDING_ASSIGN', 'PENDING_DOOR'])) {
                return $this->error('订单当前状态不允许指派');
            }
        } else {
            if (!in_array($order_info['order_state'], [1, 2], false)) {
                return $this->error('订单当前状态不允许指派,只有待确认与待服务的订单才能指派店员');
            }
        }

        $current_user = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id]);
        $message_rows = $appointed_user_ids = []; // 将要分配的用户id

        foreach ($data['appointed_uid'] as $appointed_uid) {
            $clerk_row = $this->db
                ->select('b.*, a.store_director', false)
                ->join([get_table('store') => 'a'], ['a.user_id' => 'b.user_id'], 'INNER')
                ->get_row([get_table('store_user') => 'b'], ['b.user_id' => $appointed_uid, 'b.store_id' => $current_user['store_id']]);

            if (!$clerk_row) {
                $message_rows[] = 'ID' . $appointed_uid . '无店员记录';
            }

            if ($clerk_row['store_id'] != $order_info['order_belong_store_id']) {
                $message_rows[] = '指派的店员ID' . $appointed_uid . '不在该订单所属于的店铺下';
            }

            if ($clerk_row['current_order_sn'] != $order_sn && $clerk_row['current_order_sn'] != 0) {
                $message_rows[] = '店员ID' . $appointed_uid . '当前已有订单,不能指派';
            }

            $lock = $this->cache('appointed.uid.lock.' . $appointed_uid);
            if ($lock && $lock != $order_sn) {
                $message_rows[] = '店员ID' . $appointed_uid . '处于上锁中,不能指派';
            }

            $this->cache('appointed.uid.lock.' . $appointed_uid, $order_sn); // 上锁
            $appointed_user_ids[] = $appointed_uid;
        }

        if ($message_rows) {
            return $this->error($message_rows);
        }

        $appointed_user_ids && array_multisort($appointed_user_ids, SORT_ASC, SORT_NUMERIC);
        $appointed_user_ids_explode = implode('-', $appointed_user_ids);

        try {
            $this->db->begin();
            $this->db->set_error_mode();
            // 订单已经分配了店员的情况下，取消原有的店员
            if ($order_info['appointed_uid']) {
                $appointed_uid = explode('-', $order_info['appointed_uid']);
                if (count($appointed_uid)) {
                    $this->db->where(['user_id' => $appointed_uid[0]])->update(get_table('store_user'), ['current_order_sn' => 0]);
                } else {
                    $this->db->where_in('user_id', $appointed_uid)->update(get_table('store_user'), ['current_order_sn' => 0]);
                }
                foreach ($appointed_uid as $_appointed_uid) {
                    $this->cache('appointed.uid.lock.' . $_appointed_uid, null); // 解锁
                }
            }

            $this->db->delete(get_table('order_appointed'), ['order_sn' => $order_sn]); // 删除旧的指派记录
            $this->db->update(get_table('order'), [
                'appointed_uid'       => $appointed_user_ids_explode,
                'order_bis_state_dsc' => 'PENDING_DOOR' // 更新订单业务状态为：待上门
            ], ['order_sn' => $order_sn]);
            $insert_appointed = [];
            foreach ($appointed_user_ids as $user_id) {
                $insert_appointed[] = [
                    'order_sn'      => $order_sn, // 分配的订单号
                    'appointed_uid' => $user_id, // 受分配的用户id
                    'appointed_at'  => $_SERVER['REQUEST_TIME'], // 分配订单的时间
                    'appointer_id'  => $user_info->user_id // 执行分配的用户
                ];
                $this->db->update(get_table('store_user'), ['current_order_sn' => $order_sn], compact('user_id'));
            }
            $insert_appointed && $this->db->inserts(get_table('order_appointed'), $insert_appointed); //写入指派表
            $this->db->commit();
            return $this->success(false);
        } catch (Exception $e) {
            $this->db->roll_back();
            foreach ($data['appointed_uid'] as $appointed_uid) {
                $this->cache('appointed.uid.lock.' . $appointed_uid, null); // 解锁
            }
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
     * @router http://server.name/store.income.log
     */
    public function incomeLog()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        list($field, $sort, $offset, $limit, $condition) = $this->buildQuery();
        if (!$store_info = $this->db->get_row(get_table('store'), ['user_id' => $user_info->user_id])) {
            return $this->error('您还未开通后入驻店铺');
        }
//        $store      = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id]);
        $table_name = get_table('store_wallet_log');
        $count      = $this->db->get_total($table_name, ['store_id' => $store_info['id']]);
        $rows       = $this->db->order_by(['log_at' => 'desc'])
            ->limit($offset, $limit)
            ->get($table_name, ['store_id' => $store_info['id']]);
        $rows = filter($rows);
        foreach ($rows as &$row) {
            $row['wallet_change'] = sprintf('%.2f', $row['wallet_change']);
            $row['current_balance'] = sprintf('%.2f', $row['current_balance']);
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

        $row['log_at'] = date('Y-m-d H:i:s', $row['log_at']);
        $row['current_balance'] = sprintf('%.2f', $row['current_balance']);
        $row['wallet_change'] = sprintf('%.2f', $row['wallet_change']);

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
     * 获取当前登录用户的店铺信息
     * http://server.name/user.store.info.get-{$user_id}
     */
    public function getOwnStore()
    {
        $user_id = $this->router->get(1);
        if (!$user_id) {
            $user_info = app('user_info');
            if (!$user_info || !isset($user_info->user_id)) {
                return $this->error('user-info-error');
            }
            $user_id = $user_info->user_id;
        }

        if (!$store_info = $this->db
            ->select('a.*, b.user_pic', false)
            ->join(['user' => 'b'], ['b.user_id' => 'a.user_id'], 'inner')
            ->get_row([get_table('store') => 'a'], ['a.user_id' => $user_id])) {
            return $this->error('用户没有开通店铺');
        }
        $store_info['store_total_income'] = sprintf('%.2f', $store_info['store_total_income']);
        $store_info['store_wallet'] = sprintf('%.2f', $store_info['store_wallet']);

        $staff_row = $this->db->get_row([get_table('store_user')], ['user_id' => $user_id]);

        $superior                         = $staff_row['user_type'] == 3 ? [] : $this->db
            ->select('a.*, b.user_pic', false)
            ->join(['user' => 'b'], ['b.user_id' => 'a.user_id'], 'inner')
            ->get_row([get_table('store') => 'a'], ['a.id' => $staff_row['store_id']]);
        $combin                           = [
            'own_store'   => filter($store_info)
            , 'superior'  => filter($superior)
            , 'staff_row' => filter($staff_row)
        ];
        $combin['own_store']['store_pic'] = explode(',', trim($combin['own_store']['store_pic']));
        $combin['superior'] && $combin['superior']['store_pic'] = explode(',', trim($combin['superior']['store_pic']));

        // 在这个接口处执行订单自动评价
        /** @var \model\OrderModel $order_model */
        $order_model = \utils\Factory::getFactory('order');
        $order_model->autoCommentOrders($staff_row['store_id']); // 执行自动评价订单

        return $this->success($combin);
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


        if ($store_row['user_type'] == 1) {
            return $this->error('店员无权操作');
        }

        if (!$store_info = $this->db->get_row(get_table('store'), ['user_id' => $user_info->user_id])) {
            return $this->error('用户未申请店铺');
        }


        $update['store_auto_receipt'] = $store_info['store_auto_receipt'] == 1 ? 0 : 1;
        $this->db->update(get_table('store'), $update, [
            'id' => $store_info['id']
        ]);
        return $this->success(false);
    }

    /**
     * 获取店铺店员列表
     * @router http://server.name/store.clerk.list
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
        $store_row             = $this->db->get_row($table_name, ['user_id' => $user_info->user_id], 'store_id, user_type');
        list($field, $sort, $offset, $limit, $condition) = $this->buildQuery();
        $count = $this->db->get_total($table_name, ['store_id' => $store_row['store_id'], 'user_type <>' => 3]);

        $condition = array_merge($condition, ['a.store_id' => $store_row['store_id'], 'a.user_type <>' => 3, 'b.store_status <>' => -1, 'a.user_no_part' => 0]);

        $rows = $this->db
            ->limit($offset, $limit)
            ->where($condition)
            ->order_by(['b.store_add_at' => 'desc'])
            ->select('a.*, b.store_level, c.user_pic, b.store_status, b.store_level, b.store_director, b.store_order_count, a.current_order_sn', false)
            ->join([get_table('store') => 'b'], ['a.user_id' => 'b.user_id'], 'INNER')
            ->join(['user' => 'c'], ['a.user_id' => 'c.user_id'])
            ->get([get_table('store_user') => 'a']);

        if ($data['distributable']) {
            if (!$data['order_sn']) {
                return $this->error('订单号必须');
            }
            $count           = $this->db->get_total(get_table('order_appointed'), ['order_sn' => $data['order_sn']]);
            $order_appointed = $this->db->limit(0, $count)->get(get_table('order_appointed'), ['order_sn' => $data['order_sn']], 'appointed_uid'); // 已分配的记录

            $all_appointed = [];
            foreach ($order_appointed as $user_id) {
                $all_appointed[] = $user_id['appointed_uid'];
            }

            $rows = filter($rows);
            foreach ($rows as $key => $row) {
                if ($row['current_order_sn'] && $row['current_order_sn'] != $data['order_sn']) {
                    unset($rows[$key]);
                } else {
                    $rows[$key]['_appointed'] = $row['current_order_sn'] == $data['order_sn'];
                }
            }
        }

        return $this->success(array_merge($rows, []), $count);
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
        $data['store_phone'] = $this->request->post('store_phone', '', 'trim');

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
     * @RequestMapping('/store.staff.info.get-{$staff_id}')
     */
    public function getStaffInfo()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        $staff_id          = (int)$this->router->get(1);
//        $user_belong_store = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id]);
        // 判断要查看的店员是否属于店铺
        if (!$staff_row = $this->db->get_row(get_table('store_user'), ['user_id' => $staff_id])) {
            return $this->error('店员记录不存在');
        }

        $fields           = [
            'b.id'
            , 'b.store_director'
            , 'b.store_id_card_positive'
            , 'b.store_id_card_opposite'
            , 'b.store_zizhi_positive'
            , 'b.store_zizhi_opposite'
            , 'b.store_id_card'
            , 'b.store_phone'
            , 'b.store_status'
            , 'a.user_pic'
            , 'b.store_status'
            , 'b.store_add_at'
        ];
        $staff_store_info = $this->db
            ->join(['user' => 'a'], ['a.user_id' => 'b.user_id'], 'inner')
            ->get_row([get_table('store') => 'b'], ['b.user_id' => $staff_id], $fields);


        if ($staff_store_info['store_status'] == -1) {
            return $this->error('店员已被禁用');
        }

        $staff_store_info['user_type']    = $staff_row['user_type'];
        $staff_store_info['store_add_at'] = date('Y-m-d H:s', $staff_store_info['store_add_at']);
        return $this->success(filter($staff_store_info));
    }

    /**
     * 设置店员为管理员
     * @router http://server.name/staff.set.admin-{staff_id}
     */
    public function setStaffAdmin()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        $staff_id = (int)$this->router->get(1);
        if (!$staff_row = $this->db->get_row(get_table('store_user'), ['user_id' => $staff_id])) {
            return $this->error('无店员记录');
        }
        $store_row = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id]);

        if ($store_row['store_id'] != $staff_row['store_id']) {
            return $this->error('该店员不属于您的店铺');
        }

        $update['user_type'] = $staff_row['user_type'] == 2 ? 1 : 2;
        $this->db->update(get_table('store_user'), $update, ['user_id' => $staff_id, 'store_id' => $store_row['store_id']]);
        return $this->success(false);
    }

    /**
     * 查看指定店员的服务记录
     * 只有已完成、未完成两种状态
     * @router http://server.name/staff.service.record-{staff_id}
     */
    public function getStaffServiceRecord()
    {
        $data['list_state'] = $this->request->post('state', 1, 'intval');
        // 1 获取已完成 0 获取未完成
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
//
//        if ($current_staff_row['user_type'] == 1) {
//            return $this->error('无权调用');
//        }
        if (!$staff_row = $this->db->get_row(get_table('store_user'), ['user_id' => $staff_id], 'store_id')) {
            return $this->error('无店员记录');
        }

        if ($staff_row['store_id'] != $current_staff_row['store_id']) {
            return $this->error('该店员不属于您的店铺');
        }
        $order_table = get_table('order');
        $map         = [
            'appointed_uid'         => $staff_id,
            'order_belong_store_id' => $staff_row['store_id'],
            'order_rate'            => $data['list_state']
        ];
        $count       = $this->db
            ->where(['b.appointed_uid' => $user_info->user_id, 'a.order_belong_store_id' => $staff_row['store_id'], 'b.completed' => $data['list_state']])
            ->join([get_table('order_appointed') => 'b'], ['a.order_sn' => 'b.order_sn'], 'INNER')
            ->get_total([get_table('order') => 'a']);

        $orders = [];
        if ($count) {
            list($field, $sort, $offset, $limit, $condition) = $this->buildQuery();
            $query = $this->db
                ->order_by(['a.add_time' => 'desc'])
                ->limit($offset, $limit)
                ->where(['b.appointed_uid' => $user_info->user_id, 'a.order_belong_store_id' => $staff_row['store_id']]);

            if ($data['list_state']) {
                $query = $query->where(['a.order_state' => 5]); // 已完成
            } else {
                $query = $query->where(['a.order_state <>' => 5]); // 未完成
            }

            $orders = $query->where(['a.order_state <>' => 4])
                ->select('a.*', false)
                ->join([get_table('order_appointed') => 'b'], ['a.order_sn' => 'b.order_sn'], 'INNER')
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
        if (!$staff_row = $this->db->get_row(get_table('store_user'), ['user_id' => $data['staff_id']])) {
            return $this->error('无记录');
        }

        if ($staff_row['store_id'] != $current_store_row['store_id']) {
            return $this->error('该店员不属于您的店铺');
        }
        try {
            $this->db->begin();
            $this->db->set_error_mode();
            // 获取该店员是否已有分配的订单
            $has_appointed_map   = [
                'appointed_uid' => $data['staff_id']
                , 'order_rate'  => 0
            ];
            $has_appointed_count = $this->db->get_total(get_table('order'), $has_appointed_map);
            if ($has_appointed_count) {
                $has_appointed_orders = $this->db->limit(0, $has_appointed_count)->get(get_table('order'), $has_appointed_map);
                /** @var \model\OrderModel $order_model */
                $order_model = \utils\Factory::getFactory('order');
                foreach ($has_appointed_orders as $order) {
                    $order_model->autoAssignStaff($order['order_sn']);
                }
            }
            $this->db->delete(get_table('store_user'), ['id' => $staff_row['id']]);
            $this->db->delete(get_table('store'), ['user_id' => $staff_row['user_id']]);
            $this->db->commit();
            return $this->success('移除店员成功');
        } catch (RuntimeException $e) {
            $this->db->roll_back();
            return $this->error('移除失败!' . $e->getMessage());
        }
    }

    /**
     * 取消指定订单,通过流水号
     * 如果是店铺管理员以上拒绝，则直接退款给用户
     * 如果是服务员操作，则指派给下一个服务员
     * @router http://server.name/order.cancel-{order_sn}
     */
    public function cancelOrder()
    {
        $order_sn              = $this->router->get(1);
        $data['cancel_reason'] = $this->request->post('cancel_reason', '', 'trim');
        if (mb_strlen($data['cancel_reason']) > 150) {
            return $this->error('理由过长');
        }
        $this->validate(compact('order_sn'), [
            'order_sn' => 'required|length:23'
        ]);

        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        /** @var \model\OrderModel $order_model */
        $order_model = \utils\Factory::getFactory('order');
        // 判断订单流水号是否存在 && 判断订单是否属于当前用户
        if ($order_info = $order_model->checkSnHas($order_sn)) {
            if ($order_info['user_id'] != $user_info->user_id) {
                $user_info = $order_model->checkOrderBelongUser($order_sn);
            }
        }

        if ($order_info['order_pay_state_dsc'] == 'PAYING') {
            return $this->error('订单交易处理中，不能取消');
        }

        if (!in_array($order_info['order_state'], [0, 1, 2], false)) {
            return $this->error('订单当前状态不允许取消');
        }

        $staff_row = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id], 'user_type');
        if ($staff_row['user_type'] == 1) {
            try {
                $this->db->begin();
                $this->db->set_error_mode();
                // +--------------------------------------------------------------------------------------
                // | 新的取消流程，指派给下一个有空的店员，如果没有有空店员或连续三次取消则停止
                // +--------------------------------------------------------------------------------------
                $order_model->rejecteOrder($order_sn, $data['cancel_reason'], $user_info->user_id);
                $this->db->commit();
                $this->cache('appointed.uid.lock.' . $user_info->user_id, null); // 解锁
                return $this->success(false);
            } catch (Exception $e) {
                $this->db->roll_back();
                return $this->error('取消订单失败' . $e->getMessage());
            }
        } else {
            try {
                $this->db->begin();
                $this->db->set_error_mode();
                // 管理员取消订单，直接取消
                $this->db->update(get_table('order'), [
                    'order_state'   => 5,
                    'order_rate'    => -1,
                    'cancel_reason' => $data['cancel_reason']
                ], ['order_sn' => $order_sn]);
                $order_model->orderRefund($order_sn, true);
                if ($order_info['appointed_uid']) {
                    $this->db->update(get_table('order'), ['appointed_uid' => ''], compact('order_sn'));
                    $this->db->delete(get_table('order_appointed'), compact('order_sn'));
                    // 删除锁
                    $appointed_uid = explode('-', $order_info['appointed_uid']);
                    foreach ($appointed_uid as $uid) {
                        $this->db->update(get_table('store_user'), ['current_order_sn' => 0], ['user_id' => $uid]);
                        $this->cache('appointed.uid.lock.' . $uid, null);
                    }
                }
                $this->db->commit();
                return $this->success(false);
            } catch (Exception $e) {
                $this->db->roll_back();
                if ($order_info['appointed_uid']) {
                    $appointed_uid = explode('-', $order_info['appointed_uid']);
                    foreach ($appointed_uid as $uid) {
                        $this->cache('appointed.uid.lock.' . $uid, $order_sn); // 重新写入锁
                    }
                }
                return $this->error('订单取消失败,原因：' . $e->getMessage());
            }
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

        $order_sn = $this->router->get(2);
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

        $order_info = $this->db->get_row(get_table('order'), ['order_sn' => $order_sn]);
        if (!$order_info) {
            return $this->error('订单不存在或已关闭');
        }

        $order_info = $this->db->get_row(get_table('order'), ['order_sn' => $order_sn]);
        if (!$order_info) {
            return $this->error('订单不存在或已关闭');
        }
        $result = false;
        /** @var \model\MessageModel $message_model */
        $message_model = \utils\Factory::getFactory('message');

        $captain_row = $this->db->order_by(['id' => 'asc'])->get_row(get_table('order_appointed'), compact('order_sn'), 'appointed_uid');

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

//            if (2 != $order_info['order_state']) {
//                return $this->error('订单状态不为待服务，不可开始服务!');
//            }

            if ($order_info['order_bis_state_dsc'] != 'PENDING_DOOR') {
                return $this->error('订单当前状态不允许开始服务');
            }

            // 判断当前时间是否在预约时间之后
            if ($order_info['order_type'] == 1 && !\in_array($order_info['order_belong_store_id'], [20, 26], false)) {
                if ($order_info['contact_appointment_at'] > $_SERVER['REQUEST_TIME']) {
                    return $this->error('未到预约时间');
                }
            }
            $result = $this->db->update(get_table('order'), [
                'order_state'         => 3,
                'order_bis_state_dsc' => 'IN_SERVICE',
                'order_sm_at'         => $_SERVER['REQUEST_TIME']
            ], compact('order_sn'));
            $message_model->notifyUser($order_info['user_id'], '您的订单已经开始服务啦！');
        }
        // 服务商主动完成订单
        if ('completed' === $target_status) {

            if (!$captain_row) {
                return $this->error('订单没有指派人员');
            }

//            if (3 != $order_info['order_state']) {
//                return $this->error('订单状态不为服务中，不可结束!');
//            }

            if ($order_info['order_bis_state_dsc'] != 'IN_SERVICE') {
                return $this->error('订单状态不为服务中，不可结束!');
            }

            // 第一个接受的服务员才能点已完成订单
            if ($captain_row['appointed_uid'] != $user_info->user_id) {
                return $this->error('您无权执行此操作，需要小队长才能操作');
            }

            if ($order_info['order_belong_store_id'] != $staff_row['store_id']) {
                return $this->error('该订单不属于您的店铺，不能执行此操作');
            }

            $this->db->set_error_mode();
            $result = $this->db->update(get_table('order'), [
                'order_rate'          => 1,
                'order_bis_state_dsc' => 'PENDING_EVALUATE',
                'complete_at'         => $_SERVER['REQUEST_TIME']
            ], compact('order_sn'));
            if ($result) {
                $appointed_uid = explode('-', $order_info['appointed_uid']);
                foreach ($appointed_uid as $uid) {
                    $this->cache('appointed.uid.lock.' . $uid, null); // 解锁
                    $this->db->update(get_table('store_user'), ['current_order_sn' => 0], ['user_id' => $uid, 'store_id' => $staff_row['store_id']]);
                }

//                $this->db->update(get_table('store_user'), [
//                    'current_order_sn' => 0
//                ], ['user_id' => $order_info['appointed_uid']]);

                $message_model->notifyUser($order_info['user_id'], '您的订单已经完成啦，如果有问题请及时与服务人员沟通。不要忘记评价订单以便服务人员获得订单佣金哦！');
            } else {
                return $this->error('修改订单状态出错');
            }
        }

        return $result ? $this->success(false) : $this->error(APP_DEBUG ? $this->db->get_sql() : '更新订单信息错误');
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
            'order_sn' => $order_sn
            , 'log_at' => $_SERVER['REQUEST_TIME']
            , 'log'    => '订单接触与店铺的绑定'
            , 'uid'    => $user_info->user_id
        ]);
        return $this->success(false);
    }

    /**
     * 获取、修改店铺订单分配策略
     * @router http://server.name/store.get.customize-{store_id}
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
            sort($data['star_rated_return']); // 避免恶意设值，令数组进行一次升序排序
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
}
