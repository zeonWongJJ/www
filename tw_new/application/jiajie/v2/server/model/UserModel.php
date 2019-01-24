<?php
/**
 * 用户model，用于处理用户逻辑
 * @version 2.0-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace model;

use model\user\login\ILoginAdapter;
use model\user\login\LoginModel;
use utils\Factory;

class UserModel extends BaseModel
{
    /**
     * 获取当前用户id
     */
    public static function getUseID()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return error('user-info-error');
        }
        return $user_info->user_id;
    }

    /**
     * @param integer $ub_money 积分变动多少，单位分
     * @param integer $user_id 用户id
     * @param string $pl_code 订单编号
     * @param string $ub_item 变动项目
     * @param string $ub_description 变动描述
     * @param int $ub_type 变动类型，1 - 入账 2 - 出账
     */
    public static function pointLog($ub_money, $user_id, $pl_code, $ub_item, $ub_description = '', $ub_type = 1)
    {
        $pl_variation = sprintf('%.2f', $ub_money / 100);
        $set_str      = 'user_score ' . ($ub_type ? '+ ' : '- ') . $pl_variation;
        $user_row     = (new self)->db->get_row('user', compact('user_id'), 'user_score, user_name');
        (new self)->db->set('user_score', $set_str, false)->update('user', null, compact('user_id'));
        (new self)->db->insert('points_log', [
            'user_id'        => $user_id,
            'user_name'      => $user_row['user_name'],
            'pl_type'        => $ub_type,
            'pl_variation'   => $pl_variation,
            'pl_score'       => $user_row['user_score'] + $pl_variation,
            'pl_item'        => $ub_item,
            'pl_description' => $ub_description ?: $ub_item,
            'pl_time'        => $_SERVER['REQUEST_TIME'],
            'pl_code'        => $pl_code
        ]);
    }

    /**
     * 用户登录逻辑
     * @return mixed
     * @throws \Exception
     */
    public function login()
    {
        if ('ADMIN' === TokenModel::getSourceSign()) {
            $login_type = 'admin';
        } else {
            $login_type = $this->router->get(1) ?: 'msn';
        }
        $adapter = '\\model\\user\\login\\adapter\\' . ucfirst($login_type) . 'Adapter';
        if (!class_exists($adapter)) {
            return $this->error('登录方式暂不支持');
        }
        /** @var ILoginAdapter $adapter */
        $adapter = new $adapter();
        return $adapter->login();
    }

    /**
     * 用户注册逻辑
     * @param $user_phone
     * @param $verify_code
     * @param $user_password
     * @return mixed
     * @throws \Exception
     */
    public function register($user_phone, $verify_code, $user_password)
    {
        $user_referee = $this->request->post('user_referee', 0, 'intval');
        $had_user     = $this->db->get_total('user', ['user_phone' => $user_phone]);
        if ($had_user) {
            return $this->error('手机号已注册!');
        }

        if (!getenv('APP_DEBUG')) {
            $code = $this->cache('user.code.' . $user_phone);
            if (!$code || $code != $verify_code) {
                return $this->error('验证码未获取或已过期');
            }
            $this->cache('user.code.' . $user_phone, null); // 令验证码失效
        }

        $this->db->set_error_mode();
        $data['user_phone']      = $user_phone;
        $data['user_password']   = md5(md5($user_password));
        $data['user_salt']       = md5(uniqid(microtime(), true));
        $data['role_id']         = 2;
        $data['user_regip']      = $_SERVER['REMOTE_ADDR'];
        $data['user_regtime']    = $_SERVER['REQUEST_TIME'];
        $data['shopman_regtime'] = 0;
        $data['user_position']   = 0;
        $data['update_time']     = 0;

        $login_model = new LoginModel();
        $user_id     = $login_model->insertUser([
            'user_phone'    => $user_phone,
            'user_password' => md5(md5($user_password)),
            'user_salt'     => md5(uniqid(microtime(), true))
        ]);
        $login_model->afterRegisterHook($user_id);
        return $this->error('ips-server-error');
    }

    /**
     * 生成用户邀请码
     * @return string
     * @throws \Exception
     */
    function createInviteCode()
    {
        $code = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rand = $code[random_int(0, 25)]
            . strtoupper(dechex(date('m')))
            . date('d')
            . substr(time(), -5)
            . substr(microtime(), 2, 5)
            . sprintf('%02d', random_int(0, 99));
        for (
            $a = md5($rand, true),
            $s = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            $d = '',
            $f = 0;
            $f < 6;
            $g = \ord($a[$f]),
            $d .= $s[($g ^ \ord($a[$f + 8])) - $g & 0x1F],
            $f++
        ) {
        }

        if ($this->db->get_total(get_table('share_relationship'), ['user_code' => $d])) {
            $this->createInviteCode();
        } else {
            return $d;
        }
    }

    /**
     * 修改用户登录密码
     * @param int $type 修改密码的方式，1为通过旧密码修改，2为通过短信修改
     * @return mixed
     */
    public function updatePwd($type)
    {
        // 通过旧密码方式修改密码
        if (1 === $type) {
            $map['user_phone']    = $data['user_phone'] = $this->request->post('phone', '', 'trim');
            $data['old_password'] = $this->request->post('old_password', '', 'trim');
            $data['new_password'] = $this->request->post('new_password', '', 'trim');

            $this->validate($data, [
                'user_phone'   => 'required|phone',
                'old_password' => 'required',
                'new_password' => 'required'
            ]); // 验证数据

            if ($data['old_password'] === $data['new_password']) {
                return $this->error('新旧密码不能重复!');
            }

            $user = $this->db->get_row('user', $map);
            if (!$user) {
                return $this->error('未知错误!');
            }

            if ($user['user_password'] === md5(md5($data['old_password']))) {
                $this->db->update(
                    'user',
                    ['user_password' => md5(md5($data['new_password']))],
                    $map
                );

                return $this->success(false);
            }

            return $this->error('旧密码不匹配');
        }

        // 通过短信方式修改密码
        if (2 === $type) {
            $map['user_phone']    = $data['user_phone'] = $this->request->post('phone', '', 'trim');
            $data['code']         = $this->request->post('code', '', 'trim');
            $data['new_password'] = $this->request->post('new_password', '', 'trim');

            $this->validate($data, [
                'user_phone'   => 'required|phone',
                'new_password' => 'required',
                'code'         => 'required'
            ]);
            $verification_code = $this->cache('user.code.' . $data['user_phone']);
            if ($verification_code) {

                if (\strlen($data['code']) !== 6) {
                    return $this->error('验证码长度不符!');
                }


                if ($data['code'] != $verification_code) {
                    return $this->error('验证码不正确!');
                }

                $user = $this->db->get_row('user', $map);

                if (!$user) {
                    return $this->error('该手机号码未绑定账号');
                }

                if ($user['user_password'] === md5(md5($data['new_password']))) {
                    $this->error('新旧密码不能重复!');
                }

                $this->db->update('user', ['user_password' => md5(md5($data['new_password']))], $map);
                $this->cache('user.code.' . $data['user_phone'], null); // 删除缓存
                return $this->success(false);
            }
            return $this->error('请先获取验证码!');
        }
    }

    /**
     * 修改用户交易密码
     * @param $type
     * @return mixed
     */
    public function updatePayment($type)
    {
        // 通过旧密码改变交易密码
        if (1 === $type) {
            $data['old_payment'] = $this->request->post('old_payment', '', 'trim');
            $data['new_payment'] = $this->request->post('new_payment', '', 'trim');
            $map['user_phone']   = $data['user_phone'] = $this->request->post('phone', '', 'trim');

            $this->validate($data, [
                'user_phone'  => 'required|phone',
                'old_payment' => 'required',
                'new_payment' => 'required'
            ]);

            if ($data['old_payment'] === $data['new_payment']) {
                return $this->error('交易密码不能重复');
            }

            $user = $this->db->get_row('user', ['user_phone' => $data['user_phone']]);

            if (!$user) {
                return $this->error('未知错误!');
            }

            // 判断旧密码是否正确
            if ($user['payment_code'] === md5(md5($data['old_payment']))) {
                $this->db->update('user', ['payment_code' => md5(md5($data['new_payment']))], $map);
                return $this->success(false);
            }
            return $this->error('旧交易密码不正确');

        }
        // 通过短信验证码修改密码
        if (2 === $type) {
            // key值为 code_update_password_15819943115
            $data['code']        = $this->request->post('code', 0, 'intval');
            $data['new_payment'] = $this->request->post('new_payment', '', 'trim');
            $data['user_phone']  = $this->request->post('phone', '', 'trim');

            $this->validate($data, [
                'user_phone'  => 'required|phone',
                'new_payment' => 'required',
                'code'        => 'required',
            ]);

            if (!getenv('APP_DEBUG')) {
                $code = $this->cache('user.code.' . $data['user_phone']);
                if (!$code || $code != $data['code']) {
                    return $this->error('验证码未获取或已过期');
                }
                $this->cache('user.code.' . $data['user_phone'], null); // 令验证码失效
            }

            $user = $this->db->get_row('user', ['user_phone' => $data['user_phone']]);
            if (!$user) {
                return $this->error('该手机号未绑定账号');
            }
            if ($user['payment_code'] === md5(md5($data['new_payment']))) {
                $this->error('新旧密码不能重复!');
            }

            $this->db->update('user', ['payment_code' => md5(md5($data['new_payment']))], ['user_phone' => $data['user_phone']]);
            return $this->success(false);
        }
    }

    /**
     * 用户提现操作统一封装
     * @param string $withdraw_type 提现方式
     * @return mixed
     * @throws \Exception
     */
    public function withdraw($withdraw_type)
    {
        $withdraw_quantity     = 0;
        $data['payment_code']  = $this->request->post('payment_code', '', 'trim');
        $data['withdraw_type'] = $this->request->post('withdraw_type', '', 'trim'); // 提现方式
        $way_type              = $this->request->post('way_type', '', 'trim'); // 从店铺提现还是从用户钱包
        $withdraw_money        = $this->request->post('withdraw_money', 0, 'float');

        if ($withdraw_type === 'balance') {
            $withdraw_quantity = $data['withdraw_money'] = $this->request->post('withdraw_money', 0, 'float');
        } else if ($withdraw_type === 'score') {
            $withdraw_quantity = $data['withdraw_score'] = $this->request->post('withdraw_score', 0, 'float');
        }

        if (!\in_array($data['withdraw_type'], ['alipay', 'wechat', 'bankcard'])) {
            return $this->error('提现方式不支持');
        }

        $this->validate($data, [
            'withdraw_score' => 'required',
            'payment_code'   => 'required'
        ]);

        if ((float)$withdraw_quantity < 0.1) {
            return $this->error('提现不能小于0.1');
        }

        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        try {
            $this->db->begin();
            $this->db->set_error_mode();

            $map['user_id'] = $user_info->user_id;
            $user           = $this->db->get_row('user', $map);

            // 验证支付密码
            if ($user['payment_code'] != md5(md5($data['payment_code']))) {
                throw new \RuntimeException('提现密码不正确');
            }

            $insert['transfer_way']      = $data['withdraw_type'];
            $insert['transfer_mount']    = $withdraw_quantity * 100;
            $insert['transfer_status']   = 0;
            $insert['transfer_account']  = 'UN_ACCOUNT';
            $insert['transfer_add_at']   = $_SERVER['REQUEST_TIME'];
            $insert['user_id']           = $map['user_id'];
            $insert_id                   = $this->db->insert(get_table('transfer_log'), $insert); // 写入转账记录表
            $insert['transfer_trade_no'] = date('Ymd') . str_pad($insert_id, 3, '0', STR_PAD_LEFT);
            $this->db->update(get_table('transfer_log'), ['id' => $insert_id], ['transfer_trade_no' => $insert['transfer_trade_no']]);
            $result = false;

            if ('store' == $way_type) {
                // 店铺提现走这里
//                $store_info        = $this->db
//                    ->where(['b.user_id' => $user_info->user_id])
//                    ->join([get_table('staff_wallet') => 'a'], ['a.staff_id' => 'b.id'], 'INNER')
//                    ->get_row([get_table('store_user') => 'b']);
                $withdraw_money     *= 100;
                $withdraw_money_fen = $withdraw_money / 100;
                $map['balance >=']  = $withdraw_money;
                $result             = $this->db->set('balance', "balance - {$withdraw_money}", false)
                    ->update(get_table('staff_wallet'), null, $map);
                unset($map['balance >=']);
                $map['user_balance >='] = $withdraw_money_fen;
                $result && $result = $this->db->set('user_balance', "user_balance - {$withdraw_money_fen}", false)
                    ->update('user', null, $map);
                $result && UserModel::userBalanceLog(
                    $withdraw_money_fen,
                    UserModel::getCapitalChangeTerms(2, [OrderModel::getPayWay($data['withdraw_type']), $withdraw_money_fen]),
                    2,
                    $insert['transfer_trade_no'],
                    $map['user_id']
                );
            } else {
                if ($withdraw_type === 'balance') {
                    $map['user_balance >='] = $withdraw_quantity;
                    $result                 = $this->db->set('user_balance', "user_balance - {$withdraw_quantity}", false)
                        ->update('user', null, $map);
                    $result && UserModel::userBalanceLog(
                        $withdraw_quantity,
                        UserModel::getCapitalChangeTerms(2, [OrderModel::getPayWay($data['withdraw_type']), $withdraw_quantity]),
                        2,
                        $insert['transfer_trade_no']
                    );
                }
                if ($withdraw_type === 'score') {
                    $map['user_score >='] = $withdraw_quantity;
                    $result               = $this->db->set('user_score', "user_score - {$withdraw_quantity}", false)
                        ->update('user', null, $map);
                    $pl_item              = UserModel::getCapitalChangeTerms(2, [OrderModel::getPayWay($data['withdraw_type']), $withdraw_quantity]);
                    $result && $this->db->insert('points_log', [
                        'user_id'        => $map['user_id'],
                        'user_name'      => $user_info->user_name,
                        'pl_type'        => 2, // 2代表出账
                        'pl_variation'   => $withdraw_quantity,
                        'pl_score'       => $this->db->get_row('user', ['user_id' => $user_info->user_id], 'user_score')['user_score'],
                        'pl_item'        => $pl_item,
                        'pl_description' => $pl_item,
                        'pl_time'        => $_SERVER['REQUEST_TIME'],
                        'pl_code'        => 3,
                    ]);
                }
            }
            if (!$result) {
                throw new \RuntimeException('提现失败，用户余额不足');
            }
            // 根据不同的转账方式处理
            switch ($data['withdraw_type']) {
                case 'wechat':
                    $openid_row = $this->db->get_row(get_table('user_openid'), ['user_id' => $user_info->user_id]);
                    if (!$openid_row['wx_openid']) {
                        throw new \RuntimeException('暂未绑定微信，提现失败!');
                    }
                    $pay_way          = PayModel::WECHAT;
                    $transfer_info    = [
                        'partner_trade_no' => $insert['transfer_trade_no'],
                        'openid'           => $openid_row['wx_openid'],
                        'check_name'       => 'NO_CHECK',
                        'amount'           => $withdraw_quantity * 100, // 微信以分做单位
                        'desc'             => '帐户提现'
                    ];
                    $transfer_account = $user['wx_openid'];
                    break;

                case 'alipay':
                    if (!$user['alipay_number'] || !$user['alipay_realname']) {
                        throw new \RuntimeException('用户绑定支付宝信息不正确，提现失败!');
                    }
                    $pay_way          = PayModel::ALIPAY;
                    $transfer_info    = [
                        'out_biz_no'      => $insert['transfer_trade_no'],
                        'payee_type'      => 'ALIPAY_LOGONID',
                        'payee_account'   => $user['alipay_number'],
                        'amount'          => $withdraw_quantity,
                        'payee_real_name' => $user['alipay_realname'],
                    ];
                    $transfer_account = $user['alipay_number'];
                    break;

                case 'bankcard':
                    if (!$user['bank_number'] || !$user['bank_realname']) {
                        throw new \RuntimeException('用户绑定银行卡信息不正确，提现失败!');
                    }
                    // 判断余额是否够扣除手续费
                    if ($withdraw_quantity - 1 < 0.1) {
                        throw new \RuntimeException('扣除手续费后不能达到最小提现单位，提现失败！');
                    }

                    $pay_way          = PayModel::BANKCARD;
                    $transfer_info    = [
                        'mer_date'  => date('Ymd'),
                        'mer_seqId' => $insert['transfer_trade_no'],
                        'card_no'   => $user['bank_number'],
                        'usr_name'  => $user['bank_realname'],
                        'open_bank' => $user['bank_name'],
                        'prov'      => $user['bank_province'],
                        'city'      => $user['bank_city'],
                        'trans_amt' => ($withdraw_quantity - 1) * 100, // 此处处理扣除手续费用
                        'purpose'   => '余额提现',
                        'sub_bank'  => $user['sub_bank'],
                        'flag'      => '00',
                        'term_type' => '07',
                        'pay_mode'  => '1'
                    ];
                    $transfer_account = $user['bank_number'];
                    break;

                default:
                    $transfer_info = $transfer_account = $pay_way = false;
            }

            if (!$pay_way) {
                throw new \RuntimeException('支付方式未支持，提现失败！');
            }

            $this->db->update(get_table('transfer_log'), compact('transfer_account'), ['id' => $insert_id]);
            /** @var PayModel $pay_model */
            $pay_model       = Factory::getFactory('pay');
            $transfer_result = $pay_model->setPayWay($pay_way)->transfer($transfer_info);
            if ($transfer_result === true) {
                $this->db->commit(); // 提交事务
                return $this->success(false);
            }
            // 转账失败后
            switch ($data['withdraw_type']) {
                case 'alipay':
                    throw new \RuntimeException($transfer_result['sub_msg']);
                case 'wechat':
                default:
                    throw new \RuntimeException($transfer_result['msg']);
            }
        } catch (\Exception $e) {
            $this->db->roll_back(); // 回滚事务
            return $this->error($e->getMessage());
//            return $this->json('非常抱歉，您的提现没有成功，您的问题我们已经自动记录，马上会有攻城狮进行处理，请在24小时后再试，谢谢您的理解！', 1, $e->getMessage());
        }
    }

    /**
     * 记录资金变动
     * @param float $ub_money 变动金额，单位元
     * @param string $ub_item 变动项目
     * @param int $ub_type 类型 1代表进账 2代表出账
     * @param string $ub_number 订单号
     * @param int $user_id 用户id
     * @param int $is_store_log 是否参与到店员统计
     * @param string $ub_description 变动描述
     * @return int
     */
    public static function userBalanceLog($ub_money, $ub_item, $ub_type, $ub_number, $user_id = 0, $is_store_log = 0, $ub_description = '')
    {
        $self = new static();
        if (!$user_id) {
            $user_id = app('user_info')->user_id;
        }
        if (strpos($ub_number, ':')) {
            list($order_sn, $order_sub_sn) = explode(':', $ub_number);
        } else if (strpos($ub_number, '-')) {
            list($order_sn, $order_sub_sn) = explode('-', $ub_number);
        } else {
            $order_sn     = $ub_number;
            $order_sub_sn = 0;
        }
        $insert = [
            'ub_type'        => $ub_type,
            'ub_money'       => $ub_money,
            'ub_balance'     => $self->db->get_row('user', ['user_id' => $user_id], 'user_balance')['user_balance'],
            'ub_time'        => $_SERVER['REQUEST_TIME'],
            'ub_item'        => $ub_item,
            'user_id'        => $user_id,
            'ub_number'      => $order_sn,
            'order_sub_sn'   => $order_sub_sn,
            'ub_description' => $ub_description ?: $ub_item,
            'is_store_log'   => $is_store_log
        ];
        return $self->db->insert('userbalance', $insert);
    }

    /**
     * 获取资金变化描述
     * @param $key
     * @param $replace
     * @return string
     */
    public static function getCapitalChangeTerms($key, $replace): string
    {
        $terms = [
            '购买服务-[%s] -%.2f',
            '订单收益结算-[%s] + %.2f',
            '[%s]提现 -%.2f',
            '推荐人消费收益-[%s] + %.2f',
            '分享收益-[%s] + %.2f',
            '绩效奖励 + %f',
            '拒绝接单-[%s] -%.2f',
            '[%s]充值 +%.2f',
            '发布需求-[%s] -%.2f',
            '消费返利-[%s] -%.2f',
            '订单[%s]退款 +%.2f'
        ];

        return sprintf($terms[$key], ...$replace);
    }

    /**
     * 获取当前登录用户的后台菜单列表
     * @return mixed
     */
    public function getUserNav()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        $role = $this->db->get_row(get_table('role'), ['role_key' => strtolower($user_info->user_type_key)]);

        $rows = [];
        // 如果是超级管理员，获取所有菜单
        if (TokenModel::isAdminSource()) {
            $count = $this->db->get_total(get_table('rule'), ['is_menu' => 1]);
            $rows  = $this->db->limit(0, $count)
                ->select('rule_name as title, rule_controller, rule_action, id, parent_id')
                ->get(get_table('rule'), ['is_menu' => 1, 'rule_enable' => 1]);
        } else {
//            $count = $this->db->get_total(get_table('role_assign'), ['role_id' => $role['id']]);
//            if ($count > 0) {
//                $rows = $this->db->join([get_table('rule') => 'a'], ['a.id' => 'b.rule_id'])
//                    ->select('a.rule_name as title, a.id, a.rule_controller, a.rule_action, a.parent_id')
//                    ->limit(0, $count)
//                    ->where(['b.role_id' => $role['id']])
//                    ->get([get_table('role_assign') => 'b']);
//            }
        }

        if ($rows) {
            foreach ($rows as &$row) {
                $row['href'] = $row['rule_controller'] . '.' . hump_to_line($row['rule_action']);
                unset($row['rule_controller'], $row['rule_action']);
            }

            $rows = list_to_tree(filter($rows));
        }

        $this->success($rows ?: []);
    }

    /**
     * 余额充值逻辑处理
     */
    public function balanceRecharge()
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        $pay = app('router')->get(1);
        if (!\in_array($pay, ['alipay', 'wechat', 'bankcard'])) {
            return $this->error('支付方式不支持');
        }

        $data['recharge_money']  = $this->request->post('recharge_money', 0, 'float');
        $data['recharge_status'] = 0;
        $data['recharge_money']  = sprintf('%.2f', $data['recharge_money']);
        $data['recharge_money']  *= 100;
        $data['user_id']         = $user_info->user_id;

        $insert_id = $this->db->insert(get_table('recharge'), $data);

        /** @var OrderModel $order_model */
        $order_model = Factory::getFactory('order');
        $order_info  = $order_model->setContact(
            $user_info->user_phone
            , '充值订单，无地址'
            , '充值订单，无门牌号'
            , $user_info->user_name
        )->coumpteDeductible(0)->unifiedOrder(
            OrderModel::ORDER_USER_RECHANGE
            , $insert_id
            , $pay
            , $data['recharge_money']
        );

        // 组装返回的信息
        $return = [
            'order_sn' => $order_info['order_sn']
        ];

        $this->db->update(get_table('recharge'), $return, ['id' => $insert_id]);

        return $order_info;
    }

    /**
     * 用户下单服务逻辑处理
     * @param int $service_id 服务id
     * @return mixed
     */
    public function orderService($service_id)
    {
        if (!$service = $this->db->get_row(get_table('service'), ['id' => $service_id])) {
            return $this->error('要下单的服务已不存在');
        }
        // 判断当前有空闲的清洁师，如果没有则不允许下单
        /** @var StoreModel $store_model */
        $store_model = Factory::getFactory('store');
        $subscribe_id = (int)$this->router->get(1);

        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        $staff_row = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id]);

        if ($staff_row && $service['store_id'] == $staff_row['store_id']) {
            return $this->error('不能下单自己店铺的服务');
        }
        // 写入订单
        $data['order_lal']              = $this->request->post('order_lal', '', 'trim');
        $data['contact_name']           = $this->request->post('contact_name', '', 'trim');
        $data['address_name']           = $this->request->post('address_name', '', 'trim');
        $data['house_number']           = $this->request->post('house_number', '', 'trim');
        $data['telephone']              = $this->request->post('order_phone', '', 'trim');
        $data['contact_appointment_at'] = $this->request->post('contact_appointment_at', '', 'trim');
        $data['service_length']         = $this->request->post('service_length', 1, 'intval'); // 服务时长
        $data['order_message']          = $this->request->post('service_message', '', 'trim'); // 下单留言
        $data['order_deductible_type']  = $this->request->post('order_deductible_type', 0, 'intval'); // 订单抵扣方式 1：余额 2：积分 0：无抵扣
        $data['order_pay_way']          = $this->request->post('service_price_type', '', 'trim'); // 支付订单的方式，alipay：支付宝 wechat: 微信 bankcard：银行卡
        $data['order_package_type']     = $this->request->post('order_package_type', 'fixed_price', 'trim');
        $data['service_item']           = $this->request->post('service_item/a', [], 'trim');
        $data['order_sn']               = $this->request->post('order_sn', '', 'trim'); // 订单号，后台根据预约生成订单时有用

        $rule = [
            'lal_info'               => 'required',
            'address_name'           => 'required',
            'contact_name'           => 'required',
            'telephone'              => 'required|phone',
            'contact_appointment_at' => 'required',
            'service_length'         => 'required'
        ];

        $data['order_sn'] || $rule['order_pay_way'] = 'required';
        if ($service['service_value_unit_id'] == 2 && $data['service_length'] < 2) {
            return $this->error('按时收费的服务，下单限制2小时起步');
        }

        $this->validate($data, $rule);

        // 判断是否经纬度
        if (!preg_match('/^.*,.*$/', $data['order_lal'])) {
            return $this->error('经纬度格式不正确');
        }

        list($lng, $lat) = explode(',', $data['order_lal']);
        $data['order_lng'] = $lng;
        $data['order_lat'] = $lat;

        // 判断支付方式是否支持
        if (!
            $data['order_sn'] && !\in_array($data['order_pay_way'], ['alipay', 'wechat', 'bankcard'])) {
            return $this->error('支付方式不支持');
        }

        $data['service_length']         = ceil($data['service_length']); // 取整
        $data['contact_appointment_at'] = strtotime($data['contact_appointment_at']); // 字符串转时间戳
        $data['house_number']           = $data['house_number'] ?: '无门牌号';

        // 判断是否支付下单方式
//        if ($service_packages = $this->db->get_row(get_table('service_packages'), ['service_id' => $service_id])) {
//            if (!$service_packages[$data['order_package_type']]) {
//                return $this->error('该服务不支持此下单方式');
//            }

        switch ($service['order_charging']) {
            // 免预约
            case 'NON_RESERVATION':
            default:
                $data['order_actual_amount'] = 0;
                break;
            // 固定价格（一口价）
            case 'FIXED_PRICE':
                $remuneration = 0;
                // 如果下单的是服务项目
                if ($data['service_item']) {
                    foreach ($data['service_item'] as $item) {
                        $service_item = $this->db->get_row(get_table('service_items'), [
                            'id'         => $item['id'],
                            'service_id' => $service_id
                        ]);
                        $remuneration += $service_item['item_change'] * $item['length'];
                    }
                    $data['order_actual_amount'] = $remuneration;
                } else {
                    $data['order_actual_amount'] = $service['service_remuneration'];
                }
                $data['order_actual_amount'] *= $data['service_length'];
                break;
            // 预约金
            case 'HAS_RESERVATION':
                $data['order_actual_amount'] = $service['service_remuneration'];
                break;
        }
        $this->db->begin();
        $this->db->set_error_mode();
        try {
            $order_update = [
                'order_belong_store_id'    => $service['store_id']
                , 'order_message'          => $data['order_message']
                , 'service_length'         => $data['service_length']
                , 'contact_appointment_at' => $data['contact_appointment_at']
                , 'order_lat'              => $data['order_lat']
                , 'order_lng'              => $data['order_lng']
            ];

            if ($data['order_sn']) {
                $order_update = array_merge($order_update, [
                    'telephone'             => $data['telephone'],
                    'address_name'          => $data['address_name'],
                    'house_number'          => $data['house_number'],
                    'contact_name'          => $data['contact_name'],
                    'order_deductible_type' => 0,
                    'order_type'            => 1,
                    'order_type_id'         => $service_id,
                    'order_pay_way'         => 'wechat',
                    'order_actual_amount'   => $data['order_actual_amount']
                ]);
                $this->db->update(get_table('subscribe'), [
                    'subscribe_state' => 'GENERATED_ORDER'
                ], ['id' => $subscribe_id]);
                $order_info = false;
            } else {
                /** @var OrderModel $order_model */
                $order_model      = Factory::getFactory('order');
                $order_info       = $order_model->setContact(
                    $data['telephone']
                    , $data['address_name']
                    , $data['house_number']
                    , $data['contact_name']
                )->coumpteDeductible(
                    $data['order_deductible_type']
                )->unifiedOrder(
                    OrderModel::ORDER_USER_BUY_SERVER
                    , $service_id
                    , $data['order_pay_way']
                    , $data['order_actual_amount']
                );
                $data['order_sn'] = $order_info['order_sn'];
            }
            $this->db->update(get_table('order'), $order_update, ['order_sn' => $data['order_sn']]);
            $store_model->getCanAssignStaff($data['order_sn'], 0);
            $this->db->commit();
            return $this->success($order_info);
        } catch (\Exception $e) {
            $this->db->roll_back();
            return $this->error('下单失败' . $e->getMessage());
        }

//        } else {
//            $this->error('服务收费方式未配置');
//        }
    }

    /**
     * 判断是否管理员用户
     * @return bool|mixed
     */
    public function isAdmin()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        if ('admin' === strtolower($user_info->user_type_key)) {
            return $user_info;
        }
        return false;
    }

    /**
     * 获取当前登录用户的店铺信息
     * @return array|bool|mixed
     */
    public function userStoreInfo()
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        $store_info = $this->db->get_row(get_table('store'), ['user_id' => $user_info->user_id]);

        return [$store_info, filter($user_info)];
    }

    /**
     * @remark 生成用户二维码
     * @param int $user_id 用户id
     * @return string
     */
    public function generalUserQrcode($user_id): string
    {
        if (!is_dir(__ROOT__ . '/uploadfile/user/')) {
            mkdir(__ROOT__ . '/uploadfile/user/', 0666, true);
        }
        $user_erweima_path = __ROOT__ . '/uploadfile/user/qrcode_' . $user_id . '.png';
        $user_erweima_path = str_replace('//', '/', $user_erweima_path);
        $this->load->library('phpqrcode');
        $this->phpqrcode->qrcode([
            // 要生成二维码的数据，必填
            'data'      => $user_id,
            // 二维码文件生成路径，选填，不设置将直接浏览器输出，设置此参数，二维码将不直接输出，而是生成文件
            'file_name' => $user_erweima_path,
            // 二维码图片大小，选填，默认4
            'size'      => 10,
            // 二维码错误修正级别L/M/Q/H，选填，默认“L”。L水平 7% 的字码可被修正，M水平 15% 的字码可被修正，Q水平 25% 的字码可被修正，H水平 30% 的字码可被修正
            'level'     => 'L',
        ]);
        $this->db->update('user', [
            'user_erweima' => str_replace(__ROOT__, '', $user_erweima_path)
        ], ['user_id' => $user_id]);
        return $user_erweima_path;
    }

    /**
     * 获取用户钱包，并加锁
     * @param $user_id
     * @param int $balance
     * @return int|mixed
     */
    public function getUserBalanceLock($user_id, $balance = 1)
    {
        $select = $balance == 1 ? 'user_balance' : 'user_score';
        $sql    = <<<EOF
SELECT {$select} FROM {$this->db->get_prefix('user')} WHERE user_id = {$user_id} FOR UPDATE;
EOF;
        /** @var \PDOStatement $pdo_state */
        $pdo_state = $this->db->query($sql);
        $user_info = $pdo_state ? $pdo_state->fetch(\PDO::FETCH_ASSOC) : [];
        return $user_info[$select] ?? 0;
    }
}
