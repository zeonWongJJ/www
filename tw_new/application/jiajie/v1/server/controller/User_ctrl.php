<?php
/**
 * 用户功能调度
 * @author rusice <liruizhao970302@outlook.com>
 */

/**
 * Class User_ctrl
 * @property \utils\ide\Db db
 */
class User_ctrl extends \utils\BaseController
{
    public $_ignore_node = [
        'login',
        'register',
        'sendCodePhone',
        'updatePayment',
        'updatePwd',
        'checkVerifyCode',
        'getUserShareCount',
        'queryOrder',
    ];

    public $repository = \repositories\UserRepository::class;

    /**
     * 数据获取
     * @param $method
     * @return array
     */
    public function getData($method): array
    {
        $row = [
            'user_name'     => $this->request->post('user_name', '', 'trim'),
            'user_sex'      => $this->request->post('user_sex', 0, 'intval'),
            'user_phone'    => $this->request->post('user_phone', '', 'trim'),
            'user_email'    => $this->request->post('user_email', '', 'trim'),
            'user_password' => $this->request->post('user_password', '', 'trim'),
            'user_score'    => $this->request->post('user_score', 0, 'trim|float'),
            'user_balance'  => $this->request->post('user_balance', 0, 'trim|float'),
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
        $rows = [
            'user_name'  => 'required',
            'user_sex'   => 'required',
            'user_phone' => 'required|phone',
            'user_email' => 'required|email',
        ];

        $valid = [
            'insert' => array_merge($rows, [
                'user_password' => 'required',
            ]),
            'update' => $rows,
        ];

        return $valid[$method] ?? [];
    }

    /**
     * @return array
     */
    public function setField()
    {
        return [
            'name_or_tel'     => '用户名或手机号'
            , 'user_password' => '用户登录密码'
            , 'user_name'     => '用户名'
            , 'user_sex'      => '用户性别'
            , 'user_phone'    => '用户手机号码'
            , 'user_email'    => '用户邮箱地址'
            , 'node_key'      => '权限节点KEY',
        ];
    }

    /**
     * 用户登录控制器调度
     * @route http://server.name/user.login
     * @return mixed
     * @throws Exception
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['name_or_tel']   = $this->request->post('name_or_tel', '', 'trim');
            $data['user_password'] = $this->request->post('user_password', '', 'trim');
            $user_type             = $this->router->get(1);
            $user_type             = $user_type ?: 'user';

            if ($user_type === 'user') {
                $this->validate($data, [
                    'name_or_tel'   => 'required|phone',
                    'user_password' => 'required',
                ]);
            }

            /** @var \model\UserModel $modelModel */
            $modelModel        = \utils\Factory::getFactory('user');
            $data['user_type'] = $user_type;
            return $modelModel->login(...array_values($data));
        }
        return $this->json('isp-invalid-request');
    }

    /**
     * 用户退出登录
     * @route http://server.name/user.logout
     * @return mixed
     */
    public function logout()
    {
        /** @var \model\TokenModel $token_model */
        $token_model = \utils\Factory::getFactory('token');
        $token_model->parseToken('', true);
        return $this->success(false);
    }

    /**
     * 用户注册控制器调度
     * @route http://server.name/user.register
     * @return mixed
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['user_phone']    = $this->request->post('user_phone', '', 'trim');
            $data['verify_code']   = $this->request->post('verify_code', '', 'trim');
            $data['user_password'] = $this->request->post('user_password', '', 'trim');

            $this->validate($data, [
                'user_phone'    => 'required',
                'user_password' => 'required',
            ]);

            /** @var \model\UserModel $user_model */
            $user_model = \utils\Factory::getFactory('user');
            return $user_model->register(...array_values($data));
        }
    }

    /**
     * 获取用户个人信息
     * @route http://server.name/user.info.get
     */
    public function getInfo()
    {
        $user_id = $this->router->get(1);

        if ($user_id) {
            /** @var \model\UserModel $user_model */
            $user_model = \utils\Factory::getFactory('user');
            $user_model->isAdmin();
            $map['user_id'] = $user_id;
        } else {
            $user_info = app('user_info');
            if (!$user_info || !isset($user_info->user_id)) {
                $this->error('user-info-error');
            }
            $map['user_id'] = $user_info->user_id;
        }

        $field                = [
            'user_pic'
            , 'user_phone'
            , 'user_name'
            , 'user_sex'
            , 'user_nickname'
            , 'user_email'
            , 'user_id'
            , 'user_score'
            , 'user_balance'
            , 'user_regtime'
            , 'user_erweima as user_qrcode',
        ];
        $row                  = $this->db->select($field)->get_row('user', $map);
        $row['collect_count'] = $this->db->get_total(get_table('user_collect'), $map);
        $row && $row = filter($row);
        $row['user_regtime'] = date('Y-m-d H:s:i', $row['user_regtime']);
        switch ((int)$row['user_sex']) {
            case 0:
                $row['user_sex'] = '未知';
                break;
            case 1:
                $row['user_sex'] = '男';
                break;
            case 2:
                $row['user_sex'] = '女';
                break;
        }
        if (strpos($row['user_qrcode'], 'http://jiajie-server.7dugo.com/uploadfile') == -1) {
            $row['user_qrcode'] = 'https://vdao-mobile.7dugo.com/' . $row['user_qrcode'];
        }
        return $this->success($row);
    }

    /**
     * 修改用户性别
     * @route http://server.name/user.info.update.gender
     */
    public function updateGender()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_info = app('user_info');
            if (!$user_info || !isset($user_info->user_id)) {
                $this->error('user-info-error');
            }
            $map['user_id'] = $user_info->user_id;

            $data['user_sex'] = $this->request->post('user_sex', 0, 'intval');

            $this->validate($data, [
                'user_sex' => 'required|number',
            ]);

            if (in_array($data['user_sex'], [1, 2], true)) {
                $this->db->update('user', $data, $map);
                return $this->success(false);
            }
        }
        return $this->error('isp-invalid-request');
    }

    /**
     * 修改用户头像
     * @route http://server.name/user.info.update.pic
     */
    public function updatePic()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_info = app('user_info');
            if (!$user_info || !isset($user_info->user_id)) {
                $this->error('user-info-error');
            }
            $map['user_id'] = $user_info->user_id;
            // 头像地址获取
            $data['user_pic'] = $this->request->post('user_pic', '', 'trim');
            $this->validate($data, [
                'user_pic' => 'required',
            ]);
            $this->db->update('user', $data, $map);
            return $this->success(false);
        }
        return $this->error('isp-invalid-request');
    }

    /**
     * 修改用户登录密码
     * @route http://server.name/user.info.update.pwd
     */
    public function updatePwd()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            /** @var \model\UserModel $user_model */
            $user_model = \utils\Factory::getFactory('user');
            return $user_model->updatePwd((int)$this->router->get(1));
        }

        return $this->error('isp-invalid-request');
    }

    /**
     * 修改用户交易密码
     * @route http://server.name/user.info.update.pwd
     */
    public function updatePayment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            /** @var \model\UserModel $user_model */
            $user_model = \utils\Factory::getFactory('user');
            return $user_model->updatePayment((int)$this->router->get(1));
        }

        return $this->error('isp-invalid-request');
    }

    /**
     * 下发一个验证码到指定手机
     * @route http://server.name/user.code.send
     * @throws Exception
     */
    public function sendCodePhone()
    {
        //接收手机号码
        $data['user_phone'] = $user_phone = $this->request->post('user_phone', '', 'trim');

//        $limit = $this->cache('phone.send.code.limit.' . $data['user_phone']);

        //验证手机号码格式是否正确
        $this->validate($data, [
            'user_phone' => 'phone',
        ]);
        /** @var \model\MessageModel $message_model */
        try {
            $message_model = \utils\Factory::getFactory('message');
            if ($code = $message_model->sendVerifyCode($user_phone)) {
                $this->cache('user.code.' . $user_phone, $code, 300);
                return $this->success(false);
            }
        } catch (Exception $e) {
            return $this->error('验证码发送失败' . $e->getMessage());
        }
    }

    /**
     * 校验验证码
     * @route http://server.name/user.code.check
     */
    public function checkVerifyCode()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['code']       = $this->request->post('code', '', 'intval');
            $data['user_phone'] = $this->request->post('user_phone', '', 'trim');

            $this->validate($data, [
                'code'       => 'required',
                'user_phone' => 'required|phone',
            ]);

            $code = $this->cache('user.code.' . $data['user_phone']);
            $code || $this->error('验证码失效!');


            $code == $data['code'] || $this->error('验证码不匹配!');

            $this->cache('user.code.' . $data['user_phone'], null); // 清空缓存
            return $this->success(false);
        }

        return $this->error('isp-invalid-request');
    }

    /**
     * 用户绑定第三方账号
     * @router http://server.name/user.bind
     */
    public function bindAccount()
    {
        $account_type = $this->router->get(1); // 获取绑定的账号类型
        $is_unbind    = $this->router->get(2) === 'unbind'; // 判断是否解绑

        if (!in_array($account_type, ['alipay', 'wechat', 'qq', 'bank'])) {
            return $this->error('为支持的绑定账号类型!');
        }

        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        $map['user_id'] = $user_info->user_id;
        $data           = [];

        if ($account_type === 'alipay') {
            $data['alipay_realname'] = $is_unbind ? '' : $this->request->post('alipay_realname', '', 'trim');
            $data['alipay_number']   = $is_unbind ? '' : $this->request->post('alipay_number', '', 'trim');

            $is_unbind || $this->validate($data, [
                'alipay_realname' => 'required',
                'alipay_number'   => 'required',
            ]);

        } else if ($account_type === 'wechat') {
            $data['wx_nickname'] = $is_unbind ? '' : $this->request->post('wx_nickname', '', 'trim');
            $data['wx_openid']   = $is_unbind ? '' : $this->request->post('wx_openid', '', 'trim');

            $is_unbind || $this->validate($data, [
                'wx_nickname' => 'required',
                'wx_openid'   => 'required',
            ]);
        } else if ($account_type === 'bank') {
            foreach (['bank_realname', 'bank_number', 'bank_name', 'bank_province', 'bank_city', 'sub_bank'] as $key) {
                $data[$key] = $is_unbind ? '' : $this->request->post($key, '', 'trim');
            }

            $is_unbind || $this->validate($data, [
                'bank_realname' => 'required',
                'bank_number'   => 'required',
                'bank_name'     => 'required',
                'bank_province' => 'required',
                'bank_city'     => 'required',
                'sub_bank'      => 'required',
            ]);
        }

        $data['update_time'] = $_SERVER['REQUEST_TIME'];
        if ($account_type == 'wechat') {
            if ($this->db->get_total(get_table('user_openid'), $map)) {
                $this->db->update(get_table('user_openid'), $data, $map);
            } else {
                $this->db->insert(get_table('user_openid'), array_merge($data, $map));
            }
        } else {
            $this->db->update('user', $data, $map);
        }
        return $this->success(false);
    }

    /**
     * 获取用户提现账号列表
     * @router http://server.name/user.withdraw.account
     */
    public function withdrawList()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        $user = $this->db
            ->where(['b.user_id' => $user_info->user_id])
            ->select('b.bank_number, b.bank_name, b.alipay_number, b.bank_realname, b.alipay_realname, b.bank_name, a.wx_openid, a.wx_nickname')
            ->join([get_table('user_openid') => 'a'], ['a.user_id' => 'b.user_id'], 'LEFT')
            ->get_row(['user' => 'b']); // 查询最新的数据

        $data = [];
        // 追加微信提现
        $user['wx_openid'] && $data[] = [
            'withdraw_name'     => '微信',
            'withdraw_type_id'  => 1,
            'withdraw_number'   => $this->secretNumber($user['wx_openid'], 4, 4, 20),
            'withdraw_realname' => $user['wx_nickname'],
        ];
        // 追加支付宝提现
        $user['alipay_number'] && $data[] = [
            'withdraw_name'     => '支付宝',
            'withdraw_type_id'  => 2,
            'withdraw_number'   => $this->secretNumber($user['alipay_number'], 3, 3, 5),
            'withdraw_realname' => $user['alipay_realname'],
        ];
        // 追加银行卡记录
        $user['bank_number'] && $user['bank_name'] && $data[] = [
            'withdraw_name'     => $user['bank_name'],
            'withdraw_type_id'  => 3,
            'withdraw_number'   => $this->secretNumber($user['bank_number'], 4, 4, 8),
            'withdraw_realname' => $user['bank_realname'],
        ];

        return $this->success($data);
    }

    /**
     * 用户账号加*
     * @param $str
     * @param int $first_sub 开头取多少位
     * @param int $end_sub 结尾取多少位
     * @param int $repeat 填充数量
     * @return string
     */
    private function secretNumber($str, $first_sub, $end_sub, $repeat)
    {
        $first = substr($str, 0, $first_sub);
        $end   = substr($str, 0 - $end_sub);

        return $first . str_repeat('*', $repeat) . $end;
    }

    /**
     * 获取用户管理后台菜单
     * @rotuer http://server.name/user.admin.nav.get
     */
    public function getNav()
    {
        if ($this->request->isGet()) {
            /** @var \model\UserModel $user_model */
            $user_model = \utils\Factory::getFactory('user');
            $user_model->getUserNav();
        }
    }

    /**
     * 获取当前登录用户的订单列表
     * @router http://server.name/user.get.order
     */
    public function getOrderList()
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        $map = [
            'user_id'          => $user_info->user_id
            , 'order_user_del' => 0 // 没有删除订单
            , 'order_type <>'  => 3,
        ];
        list($field, $sort, $offset, $limit, $condition) = $this->buildQuery();
        $condition = array_merge($condition, $map);
        $count     = $this->db->where($condition)->get_total(get_table('order'));
        $orders    = $this->db->limit($offset, $limit)
            ->where($condition)
            ->order_by(['add_time' => 'desc'])
            ->get(get_table('order'));

        if ($orders) {
            $orders = filter($orders);
            /** @var \model\OrderModel $order_model */
            $order_model = \utils\Factory::getFactory('order');
            foreach ($orders as &$order) {
//                if ($order['order_type'] == 1) {
//
//                    if ($order['order_is_pay'] == 0 && $order['contact_appointment_at'] < $_SERVER['REQUEST_TIME']) {
//                        $this->db->update('jiajie_order', ['order_state' => 4], ['order_sn' => $order['order_sn']]);
//                        unset($orders[$key]);
//                    }
//                }
                $order = $order_model->formatOrderRow($order);

                $img = $this->cache('_.order.cache.img.' . $order['order_type'] . $order['order_type_id']);
                if (!$img) {
                    if ($order['order_type'] == 1) {
                        $img = $this->db->get_row(get_table('service'), ['id' => $order['order_type_id']], 'service_img');
                        $img = $img['service_img'];
                        $this->cache('_.order.cache.img.' . $order['order_type'] . $order['order_type_id'], $img, 120);
                    } elseif ($order['order_type'] == 2) {
                        $img = $this->db->get_row('jiajie_demand', ['id' => $order['order_type_id']], 'demand_img');
                        $img = $img['demand_img'];
                        $this->cache('_.order.cache.img.' . $order['order_type'] . $order['order_type_id'], $img, 120);
                    }
                }
                $order['order_img'] = explode(',', $img);
            }
        }

        return success($orders ?: [], $count, [
            'sql' => APP_DEBUG ? $this->db->get_sql() : '',
        ]);
    }

    /**
     * 获取当前登录用户的发布列表
     * @router http://server.name/user.get.demand
     */
    public function getDemandList()
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        // 查询订单之前，标记过期并退款
        $map = [
            'b.order_type'              => 2
            , 'b.order_state <>'        => 4
            , 'b.order_is_pay'          => 1
            , 'b.order_refund'          => 0
            , 'b.order_belong_store_id' => 0
            , 'a.demand_service_at <'   => $_SERVER['REQUEST_TIME'],
        ];
        if ($count = $this->db->join([get_table('order') => 'b'], ['a.order_sn' => 'b.order_sn'], 'INNER')
            ->get_total([get_table('demand') => 'a'], $map)) {
            $rows = $this->db->join([get_table('order') => 'b'], ['a.order_sn' => 'b.order_sn'], 'INNER')
                ->where($map)
                ->limit(0, $count)
                ->get([get_table('demand') => 'a']);
            /** @var \model\DemandModel $demand_model */
            $demand_model = \utils\Factory::getFactory('demand');
            foreach ($rows as $row) {
                $demand_model->refundOrder($row);
            }
        }

        list($field, $sort, $offset, $limit, $condition) = $this->buildQuery();

        $condition = array_merge($condition, [
            'b.user_id'      => $user_info->user_id
            , 'b.order_type' => 2,
        ]);

        $count = $this->db->join([get_table('demand') => 'a'], ['a.order_sn' => 'b.order_sn'], 'INNER')
            ->where($condition)
            ->get_total([get_table('order') => 'b']);

        $result  = $this->db->query('SHOW FULL COLUMNS FROM ' . $this->db->get_prefix(get_table('order')));
        $columns = [];
        foreach ($result as $item) {
            if ('id' === $item['Field']) {
                $columns[] = 'b.' . $item['Field'] . ' as order_id';
            } elseif ('order_sn' === $item['Field']) {
                $columns[] = 'b.' . $item['Field'] . ' as order_table_sn';
            } else {
                $columns[] = 'b.' . $item['Field'];
            }
        }
        $rows = $this->db->join([get_table('demand') => 'a'], ['a.order_sn' => 'b.order_sn'], 'INNER')
            ->where($condition)
            ->limit($offset, $limit)
            ->select(array_merge($columns, [
                'a.*',
            ]), false)
            ->order_by(['a.demand_post_at' => 'desc'])
            ->get([get_table('order') => 'b']);

        $rows && $rows = filter($rows);
        foreach ($rows as &$row) {
            $row['demand_img']          = explode(',', $row['demand_img']);
            $row['demand_service']      = date('Y-m-d H:s:i', $row['demand_service_at']);
            $row['demand_remuneration'] = number_format($row['demand_remuneration'] / 100, 2, '.', ',');
            $row['demand_post_at']      = date('Y-m-d H:i:s', $row['demand_post_at']);

            list($lng, $lat) = explode(',', $row['demand_lal']);
            $row['lat'] = trim($lat);
            $row['lng'] = trim($lng);
        }
        return success($rows, $count, [
            'sql' => APP_DEBUG ? $this->db->get_sql() : '',
        ]);
    }

    /**
     * 删除订单
     * @router http://server.name/user.order.delete
     */
    public function deleteOrder()
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        $order_sn = $this->router->get(1);
        if (!$order_sn) {
            return $this->error('没有获取到订单流水号');
        }
        $row = $this->db->get_row('jiajie_order', ['order_sn' => $order_sn]);
        if (!$row) {
            return $this->error('流水号异常');
        }
        if ($row['user_id'] != $user_info->user_id) {
            return $this->error('订单不属于当前用户');
        }

        // 指定订单删除
        /** @var \model\OrderModel $order_model */
        $order_model = \utils\Factory::getFactory('order');
        return $order_model->orderDelete($order_sn)
            ? $this->error('删除订单失败')
            : $this->success(false);
    }

    /**
     * 判断用户店铺状态
     * @router http://server.name/user.store.status
     */
    public function storeStatus()
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error', 401);
        }

        $map['user_id'] = $user_info->user_id;
        $row            = $this->db->get_row(get_table('store'), $map);

        $return = [
            'status'   => $row ? $row['store_status'] : 4
            , 'reason' => $row['store_nopass_reason'],
        ];

        return $this->success($return, 1);
    }

    /**
     * 获取登录用户的评论列表
     * @router http://server.name/user.comment.list
     */
    public function getCommentList()
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        $map['user_id'] = $user_info->user_id;
        list($field, $sort, $offset, $limit, $condition) = $this->buildQuery();
        $fields    = [
            'a.*',
            'b.order_pay_way', // 订单支付方式
            'b.order_name' // 订单标题
        ];
        $count     = $this->db->where($map)->get_total(get_table('comment'));
        $rows      = $this->db->limit($offset, $limit)->where(['a.user_id' => $user_info->user_id])
            ->select($fields, false)
            ->order_by(['a.add_time' => 'desc'])
            ->join([get_table('order') => 'b'], ['a.comment_order_sn' => 'b.order_sn'], 'right')
            ->get([get_table('comment') => 'a']);
        $user_info = $this->db->get_row('user', ['user_id' => $user_info->user_id], 'user_nickname, user_pic');
        if ($rows) {
            $rows = filter($rows);
            foreach ($rows as &$row) {
                $row['comment_img_urls'] = $row['comment_img_urls'] ? explode(',', $row['comment_img_urls']) : [];
                $row['add_time']         = date('Y-m-d H:i:s', $row['add_time']);
//                $repeat                  = mb_strlen($user_info->user_name) - 2 > 0 ? mb_strlen($user_info->user_name) - 2 : 2;
                // 拼接用户信息
                $row['user_info'] = [
                    'user_pic'  => $user_info['user_pic'],
                    'user_name' => $user_info['user_nickname']
//                    'user_name' => $user_info->user_name[0] . str_repeat('*', $repeat) . substr($user_info->user_name, 0, -1),
                ];
            }
        }
        return $this->success($rows, $count);
    }

    /**
     * 用户启用、关闭
     * @router http://server.name/user.enable
     */
    public function enable()
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        if (olower($user_info->user_type_key) === 'admin') {
            if (!$id = $this->router->get(1)) {
                return $this->error('没有获取到id');
            }
            if (!$user_info = $this->db->get_row('user', ['user_id' => $id])) {
                return $this->error('用户不存在');
            }

            if ($user_info['user_state'] == 0) {
                return $this->error('不能开启/暂用未审核的用户');
            }

            $update['user_state'] = $user_info['user_state'] == 1 ? 2 : 1;
            $this->db->update('user', $update, ['user_id' => $id]);
            return $this->success(false);
        }
        return $this->error('非管理员不能操作!');
    }

    /**
     * 检查用户token
     * @router http://server.name/user.check.token
     */
    public function checkToken()
    {
        /** @var \model\TokenModel $token_model */
        $token_model = \utils\Factory::getFactory('token');
        if ($user_info = $token_model->parseToken()) {
            return $this->success(false);
        }
        return $this->error('token-parse-error');
    }

    /**
     * 用户下单服务
     * @router http://server.name/user.buy.service
     */
    public function orderService()
    {
        $service_id = $this->router->get(1);
        if (!$service_id) {
            return $this->error('获取不到下单的服务id');
        }
        /** @var \model\UserModel $user_model */
        $user_model = \utils\Factory::getFactory('user');
        return $user_model->orderService($service_id);
    }

    /**
     * 修改用户资料
     * @router http://server.name/user.info.update
     */
    public function updateInfo()
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            throw new \RuntimeException('user-info-error');
        }

        $map['user_id']        = $user_info->user_id;
        $data['user_pic']      = $this->request->post('user_pic', '', 'trim');
        $data['user_nickname'] = $this->request->post('user_nickname', '', 'trim');
        $data['user_sex']      = $this->request->post('user_sex', 0, 'trim');

        // 去除空值，为空时不修改
        foreach ($data as $key => $value) {
            if ($value === '') {
                unset($data[$key]);
            }
        }

        if ($data['user_pic'] && !file_exists(__DIR__ . '/../web/' . trim($data['user_pic'], '/'))) {
            return $this->error('头像文件不存在');
        }

        $data['user_pic'] = trim($data['user_pic'], '/');
        $this->db->update('user', $data, $map);
        return $this->success(false);
    }

    /**
     * 获取用户订单的统计
     * @router http://server.name/user.order.statistics
     */
    public function getOrderStatistics()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        $map = [
            'user_id'                => $user_info->user_id,
            'order_type <>'          => 3,
            'order_pay_state_dsc <>' => 'PAYING', // 非支付中订单
            'order_user_del'         => 0 // 不查询用户已删除的订单
        ];

        $count['pending_payment'] = $this->db->get_total(get_table('order'), array_merge(['order_state' => 0], $map)); // 待付款
        $count['pending_receipt'] = $this->db->get_total(get_table('order'), array_merge(['order_is_pay' => 1, 'order_belong_store_id' => 0], $map)); // 待接单
        $count['pending_service'] = $this->db->get_total(get_table('order'), array_merge(['order_state' => 2], $map)); // 待服务
        $count['pending_comment'] = $this->db->get_total(get_table('order'), array_merge(['order_state' => 3, 'order_rate' => 1, 'order_comment_id' => 0], $map)); // 待评论
        $count['closed']          = $this->db->get_total(get_table('order'), array_merge(['order_state' => 4], $map)); // 已关闭

//        $count['pending_payment'] = $this->db->get_total(get_table('order'), array_merge(['order_pay_state_dsc' => 'PENDING_PAY'], $map)); // 待付款
//        $count['pending_receipt'] = $this->db->get_total(get_table('order'), array_merge(['order_bis_state_dsc' => 'PENDING_ORDER'], $map)); // 待接单
//        $count['pending_service'] = $this->db->get_total(get_table('order'), array_merge(['order_bis_state_dsc' => 'PENDING_DOOR'], $map)); // 待服务
//        $count['pending_comment'] = $this->db->get_total(get_table('order'), array_merge(['order_bis_state_dsc' => 'PENDING_EVALUATE'], $map)); // 待评论
//        $count['closed']          = $this->db->get_total(get_table('order'), array_merge(['order_bis_state_dsc' => 'CLOSED'], $map)); // 已关闭

        return $this->success($count);
    }

    /**
     * 用户余额充值
     * @router http://server.name/user.balance.recharge
     */
    public function recharge()
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        /** @var \model\UserModel $user_model */
        $user_model = \utils\Factory::getFactory('user');
        $order_info = $user_model->balanceRecharge();
        return $this->success($order_info);
    }

    /**
     * 检测用户是否设置支付密码
     * @router http://server.name/userpayment.code.check
     */
    public function fuck_check_payment_pwd()
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        $user_info = $this->db->get_row('user', ['user_id' => $user_info->user_id], 'payment_code');
        if ($user_info['payment_code']) {
            return $this->success(false);
        }
        return $this->error();
    }

    /**
     * 设置支付密码
     * @router http://server.name/userpayment.init
     * @return mixed
     */
    public function fuck_set_payment()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        $data['payment_code'] = $this->request->post('payment_code', '', 'trim');
        $this->validate($data, [
            'payment_code' => 'required',
        ]);
        $user_row = $this->db->get_row('user', ['user_id' => $user_info->user_id], 'payment_code');

        if ('' == $user_row['payment_code']) {
            $this->db->update('user', ['payment_code' => md5(md5($data['payment_code']))], ['user_id' => $user_info->user_id]);
            return $this->success(false);
        }
        return $this->error('已设置过支付密码，不能初始化');
    }

    /**
     * 用户主动取消订单
     * @router http://server.name/user.cancel.order-{$order_sn}
     */
    public function cancelOrder()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        $map['order_sn'] = $this->router->get(1);
        $this->validate($map, [
            'order_sn' => 'required',
        ]);
        /** @var \model\OrderModel $order_model */
        // 判断订单流水号是否存在 && 判断订单是否属于当前用户
        if (!$order_info = $this->db->get_row(get_table('order'), $map)) {
            return $this->error('订单不存在');
        }

        if ($order_info['user_id'] != $user_info->user_id) {
            return $this->error('订单不属于您，不能取消');
        }
        if (!in_array($order_info['order_state'], [0, 1, 2], false)) {
            return $this->error('订单当前状态不允许取消');
        }
        /** @var \model\OrderModel $order_model */
        $order_model = \utils\Factory::getFactory('order');
        try {
            $this->db->begin();
            $this->db->set_error_mode();
            $order_info['order_state'] != 0 && $order_model->orderRefund($order_info['order_sn'], true); // 已支付则退款
            $this->db->delete(get_table('order_appointed'), ['order_sn' => $order_info['order_sn']]); // 清空指派表
            $this->db->update(get_table('order'), [
                'order_state'         => 4,
                'order_bis_state_dsc' => 'CLOSED',
                'order_rate'          => -1,
                'cancel_reason'       => '用户主动取消订单',
            ], $map);
            // 恢复店员的接手订单状态
            $this->db->update(get_table('store_user'), [
                'current_order_sn' => 0,
            ], ['user_id' => $order_info['appointed_uid']]);
            $this->db->insert(get_table('order_log'), [
                'order_sn' => $map['order_sn'],
                'log_at'   => $_SERVER['REQUEST_TIME'],
                'log'      => '订单' . $map['order_sn'] . '被用户主动主动取消',
                'uid'      => $user_info->user_id,
            ]);
            $this->db->commit();

            if ($order_info['appointed_uid']) {
                $appointed_uid = explode('-', $order_info['appointed_uid']);

                foreach ($appointed_uid as $uid) {
                    $this->cache('appointed.uid.lock.' . $uid, null); // 解锁
                }
            }

            return $this->success(false);
        } catch (Exception $e) {
            $this->db->roll_back();
            return $this->error('取消订单失败' . $e->getMessage());
        }
    }

    /**
     * 用户提现
     * @router http://server.name/user.withdraw
     * @throws Exception
     */
    public function withdraw()
    {
        $withdraw = $this->router->get(1); // 提现目标从url中获取
        $this->validate(compact('withdraw'), [
            'withdraw' => 'required',
        ]);
        if (!in_array($withdraw, ['balance', 'score'])) {
            return $this->error('提现类型不支持');
        }

        /** @var \model\UserModel $user_model */
        $user_model = \utils\Factory::getFactory('user');
        return $user_model->withdraw($withdraw);
    }

    /**
     * 获取用户的推荐人数总数
     * @router http://server.name/user.get.share.count-{user_id}
     * @return mixed
     */
    public function getUserShareCount()
    {
        if (!$user_id = (int)$this->router->get(1)) {
            return $this->error('用户id必须');
        }
        $_count = $this->db->get_row(get_table('share_relationship'), ['user_id' => $user_id], 'share_count');
        return $this->success(['_count' => $_count['share_count']]);
    }

    /**
     * 判断用户是否可以操作某个节点
     * @router http://server.name/user.canuse
     */
    public function canuse()
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        $data['node_key'] = $this->request->post('node_key', '', 'trim');
        $this->validate($data, [
            'node_key' => 'required',
        ]);

        list($rule_controller, $rule_action, $rule_router_param) = explode('.', $data['node_key']);
        $rule_action || $rule_action = '#';
        $rule_router_param || $rule_router_param = '';

        $rule_row = $this->db->get_row(get_table('rule'), compact('rule_controller', 'rule_action', 'rule_router_param'), 'id');

        if (!$rule_row) {
            return $this->error('权限节点不存在');
        }

        $role_id = false;
        // 检查是否店员
        $staff_row = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id], 'user_type');
        if ($staff_row) {
            $staff_role_map = [1 => 'pu_tong_dian_yuan', 2 => 'dian_pu_guan_li_yuan', 3 => 'dian_zhu'];
            $role_id        = $staff_role_map[$staff_row['user_type']] ?? false;

            if ($role_id) {
                if (!$role_row = $this->db->get_row(get_table('role'), ['role_key' => $role_id], 'id')) {
                    $role_id = false;
                } else {
                    $role_id = $role_row['id'];
                }
            }
        }

        if ($role_id) {
            $role_row = $this->db->join(['user' => 'a'], ['a.role_id' => 'b.id'], 'INNER')
                ->select('b.id')
                ->where(['a.user_id' => $user_info->user_id])
                ->get_row([get_table('role') => 'b']);
            $role_id  = $role_row ? $role_row['id'] : false;
        }

        if (!$role_id) {
            return $this->error('角色不存在');
        }

        $assign = $this->db->get_total(get_table('role_assign'), ['role_id' => $role_id, 'rule_id' => $rule_row['id']]);
        if (!$assign) {
            return $this->error('您的用户id:' . $role_id . '没有权限');
        }
        return $this->success(false);
    }

    public function queryOrder()
    {
        $order_sn = $this->request->get('order_sn', '', 'trim');
        if (!$order_sn) {
            return $this->error('订单号必须');
        }

        $order_info = $this->db->get_row(get_table('order'), compact('order_sn'));
        if (!$order_info) {
            return $this->error('订单不存在');
        }

        $info = [];

        if ($order_info['order_pay_way'] == 'alipay') {
            $this->load->library('alipay_wap');
            $info = $this->alipay_wap->query(['out_trade_no' => $order_sn]);
        } elseif ($order_info['order_pay_way'] == 'wechat') {
            $this->load->library('wxpay_h5', '', [['out_trade_no' => $order_sn]]);
            $info = $this->wxpay_h5->query();
        }

        $this->success($info);
    }
}