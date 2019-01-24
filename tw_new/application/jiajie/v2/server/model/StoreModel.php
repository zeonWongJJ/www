<?php
/**
 * 店铺模型类
 * @version 2.0-dev
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace model;

use model\dao\StaffDAO;

class StoreModel extends BaseModel
{
    const STAFF_LIST = 'store.staff.list.';
    const STORE_INFO = 'store.info.';

    /**
     * 获取多少天内的收益
     * @param int $user_type 统计类型
     * @param $id
     * @param int $days 天数
     * @return string
     */
    public static function incomeDays($user_type, $id, $days = 1): string
    {
        $count = 0;
        if ($user_type == 3) {
            // 店长统计店铺的总收益
            $where       = [
                'order_belong_store_id' => $id,
                'order_state <>'        => 4,
                'order_comment_id <>'   => 0,
                'pay_time >='           => strtotime("-{$days} days"),
                'pay_time <='           => $_SERVER['REQUEST_TIME']
            ];
            $order_count = (new static)->db->get_total(get_table('order'), $where);
            $all_orders  = (new static)->db
                ->limit(0, $order_count)
                ->get(get_table('order'), $where, 'order_amount');
        } else {
            $user_info = app('user_info');
            // 非店长统计自己的收益
            $where       = [
                'a.appointed_uid'         => $user_info->user_id,
                'b.order_belong_store_id' => $id,
                'b.order_state <>'        => 4,
                'b.pay_time >='           => strtotime("-{$days} days")
            ];
            $order_count = $query = (new static)->db
                ->join([get_table('order_appointed') => 'a'], ['a.order_sn' => 'b.order_sn', 'a.order_sub_id' => 'b.order_sub_sn'], 'INNER')
                ->get_total([get_table('order') => 'b'], $where);
            $all_orders  = $order_count = $query = (new static)->db
                ->join([get_table('order_appointed') => 'a'], ['a.order_sn' => 'b.order_sn', 'a.order_sub_id' => 'b.order_sub_sn'], 'INNER')
                ->limit(0, $order_count)->get([get_table('order') => 'b'], $where);
        }
        if ($all_orders) {
            foreach ($all_orders as $order) {
                $count += $order['order_amount'];
            }
        }
        return sprintf('%.2f', $count / 100);
    }

    /**
     * 获取订单当天收入额
     * @return float
     */
    public static function todayIncome(): float
    {
        $income = 0;
        foreach (self::todayOrders() as $order) {
            if ($order['order_state'] == 5) {
                $income += $order['order_amount'];
            }
        }

        return (double)sprintf('%.2f', $income / 100);
    }

    /**
     * @remark 获取店铺当天的订单
     * @return array
     */
    public static function todayOrders(): array
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return error('user-info-error');
        }
        $self      = new static;
        $staff_row = $self->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id], 'store_id');
        list($start, $end) = ToolModel::getTodayBeginAndEnd();
        $map         = [
            'add_time >='           => $start,
            'add_time <='           => $end,
            'order_belong_store_id' => $staff_row['store_id']
        ];
        $order_total = $self->db->get_total(get_table('order'), $map);
        $orders      = $self->db
            ->limit(0, $order_total)
            ->get(get_table('order'), $map);  // 获取当日的订单
        $orders      = filter($orders);
        return $orders;
    }

    /**
     * 升级店铺等级
     * @param $store_id
     * @return bool
     */
    public function upStoreLevel($store_id)
    {
        $store_info = $this->db->get_row(get_table('store'), ['id' => $store_id]);
        if (!$store_info) {
            throw new \RuntimeException('店铺不存在，请检查');
        }
        // 获取升级区间
        $store_level_section = $this->db->get_row(get_table('config'), ['config_key' => 'store_level_section'], 'config_value');
        $store_level_section = ceil((int)$store_level_section['config_value']); // 进一法取整，避免设置小数问题

        $update['store_level'] = floor($store_info['store_hp_count'] / $store_level_section); // 舍去法取整
        $this->db->update(get_table('store'), $update, ['id' => $store_id]);
        return true;
    }

    /**
     * 修改店铺状态
     * @param $id
     * @param int $state
     * @return mixed
     */
    public function storeChangeStatus($id, $state = 1)
    {
        if (!\in_array($state, [1, 2], true)) {
            return $this->error('状态不明');
        }
        $row = $this->db->get_row(get_table('store'), ['store_id' => $id]);
        if (!$row) {
            return $this->error('no-data');
        }
        if ($row['store_state'] == 0) {
            return $this->error('店铺未审核');
        }
        $result = $this->db->update(get_table('store'), ['store_state' => $state], ['store_id' => $id]);
        if ($result) {
            return $this->success(false);
        }
        return $this->error('开启店铺失败');
    }

    /**
     * @param string $join_alias
     * @return array
     */
    public function setQuerySelect($join_alias = ''): array
    {
        $fields = $this->getAllFields('store');
        $ignore = ['store_auto_receipt', 'store_parent_id', 'store_wallet', 'store_total_income']; // 所有场景下都不查询的字段

        if (!TokenModel::isAdminSource()) {
            $ignore = array_merge($ignore, ['store_add_at', 'store_id_card', 'wallet_lock', 'user_id', 'store_director']); // 非后台查询另外排除这些字段
        }

        $diff = array_diff($fields, $ignore);
        if ($join_alias) {
            foreach ($diff as $key) {
                $diff[] = $join_alias . '.' . $key;
                unset($diff[$key]);
            }
        }

        return $diff;
    }

    /**
     * 格式化数据
     * @param array $row
     * @return array
     */
    public function formatRow(array $row): array
    {
        if (isset($row['store_nopass_reason']) && $row['store_nopass_reason'] && $row['store_status'] != -1) {
            unset($row['store_nopass_reason']);
        }
        (isset($row['store_pic']) && $row['store_pic']) && $row['store_pic'] = explode(',', $row['store_pic']);
        unset($row['store_auto_receipt'], $row['store_parent_id'], $row['store_wallet'], $row['store_total_income']);
        if (TokenModel::isAdminSource()) {
            $row['store_add_at'] = date('Y-m-d H:s:i', $row['store_add_at']);
        } else {
            unset($row['store_add_at'], $row['store_id_card'], $row['wallet_lock'], $row['user_id'], $row['store_director']);
        }
        $row['favorable_rate'] = $row['store_hp_count'] / ($row['store_comment_count'] ?: 1);
        $row['favorable_rate'] = 100 * sprintf('%.2f', $row['favorable_rate']); // 好评率百分比
        return $row;
    }

    /**
     * 判断店铺管理员是否有接手订单权限
     * @return bool
     */
    public function storeAdminReceiptPermission(): bool
    {
        $role_row  = $this->db->get_row(get_table('role'), [
            'role_key' => 'dian_pu_guan_li_yuan'
        ]);
        $role_auth = explode(PHP_EOL, $role_row['role_auth']);
        return \in_array('/Store/changeOrderStatus/receipt', $role_auth, false);
    }

    /**
     * @remark 生成店铺入驻二维码
     * @param integer $store_id 店铺id
     * @return string 生成的二维码
     */
    public function generalInductedQrcode($store_id): string
    {
        if (!is_dir(__ROOT__ . '/uploadfile/store_qrcode/inducted/')) {
            mkdir(__ROOT__ . '/uploadfile/store_qrcode/inducted/', 0666, true);
        }
        $store_inducted_qrcode_path = __ROOT__ . '/uploadfile/store_qrcode/inducted/' . $store_id . '.png';
        include BASEPATH . '/libraries/Phpqrcode.php';
        $tw_phpqrcode = new \TW_phpqrcode();
        $touch_domain = getenv('TOUCH_DOMAIN') ?: 'http://jiajie-touch.7dugo.com';
        $tw_phpqrcode->qrcode([
            // 要生成二维码的数据，必填
            'data'      => $touch_domain . '/#/storeApply?store_id=' . $store_id,
            // 二维码文件生成路径，选填，不设置将直接浏览器输出，设置此参数，二维码将不直接输出，而是生成文件
            'file_name' => $store_inducted_qrcode_path,
            // 二维码图片大小，选填，默认4
            'size'      => 10,
            // 二维码错误修正级别L/M/Q/H，选填，默认“L”。L水平 7% 的字码可被修正，M水平 15% 的字码可被修正，Q水平 25% 的字码可被修正，H水平 30% 的字码可被修正
            'level'     => 'L'
        ]);
        $this->db->update(get_table('store'), [
            'store_inducted_qrcode' => str_replace(__ROOT__, '', $store_inducted_qrcode_path)
        ], ['id' => $store_id]);
        return $store_inducted_qrcode_path;
    }

    /**
     * @param $start_day
     * @param $service_length
     * @param $store_id
     * @return array|bool
     */
    public function getCanAssignStaffByDay($start_day, $service_length, $store_id)
    {
        list($start, $end) = ToolModel::getTodayBeginAndEnd($start_day); // 当日的开始与结束时间
        if ($start_day < $_SERVER['REQUEST_TIME']) {
            return false;
        }
        $all_staff_count = $this->db->get_total(get_table('store_user'), compact('store_id'));
        if ($all_staff_count) {
            $all_assigned_uid   = $all_store_staff_uid = [];
            $all_assigned_count = $this->db->get_total(get_table('order_appointed'), [
                'store_id'          => $store_id,
                'completed'         => 0,
                'order_begin_at >=' => $start,
                'order_end_at <='   => $end,
            ]);
            if (!$all_assigned_count) {
                return true;
            }
            $all_assigned_rows = $this->db->limit(0, $all_assigned_count)->get(get_table('order_appointed'), [
                'store_id'  => $store_id,
                'completed' => 0
            ], 'order_begin_at, order_end_at, appointed_uid');

            $interval = ConfigModel::getItem('order_interval_time'); // 小时单位

            foreach ($all_assigned_rows as $row) {
                // 判断指派记录是否发生在当日
                if (ToolModel::isTimeCross($row['order_begin_at'], $row['order_end_at'], $start_day, $start_day + ($service_length + $interval) * 3600)) {
                    $all_assigned_uid[] = $row['appointed_uid'];
                }
            }
            if (!$all_assigned_uid) {
                return false;
            }
            $all_staff_rows = $this->db->limit(0, $all_staff_count)->get(get_table('store_user'), compact('store_id'), 'user_id');
            foreach ($all_staff_rows as $all_staff_row) {
                $all_store_staff_uid[] = $all_staff_row['user_id'];
            }
            $all_assigned_uid && $all_assigned_uid = array_keys(array_flip($all_assigned_uid)); // 去重
            return array_diff($all_assigned_uid, $all_store_staff_uid);
        }
        return false;
    }

    /**
     * @remark 获取店铺可分配店员列表
     * @param string $order_sn 订单编号
     * @param int int $order_sub_sn 订单子编号
     * @param array $all_staffs 是否传入所有店员数组，如果是则不需要查询
     * @return array|mixed
     */
    public function getCanAssignStaff($order_sn, $order_sub_sn = 0, array $all_staffs = [])
    {
        $can_assign_staff  = [];
        $where['order_sn'] = $order_sn;
        if ($order_sub_sn) {
            $where['order_sub_sn'] = $order_sub_sn;
        }

        if (!$order_info = $this->db
            ->select('order_state, order_pay_state_dsc, order_bis_state_dsc, contact_appointment_at, service_length, order_belong_store_id, appointed_uid')
            ->get_row(get_table('order'), $where)) {
            throw new \RuntimeException('获取订单数据失败');
        }
        // 先判断该店员是否无分配
        $appointed      = $this->db->get_total(get_table('order_appointed'), [
            'store_id'  => $order_info['order_belong_store_id'],
            'completed' => 0
        ]);
        $appointed_list = $appointed_uid = []; // 所有指派信息
        if ($appointed) {
            $appointed_rows = $this->db->limit(0, $appointed)->get(get_table('order_appointed'), [
                'store_id'  => $order_info['order_belong_store_id'],
                'completed' => 0
            ]);
            foreach ($appointed_rows as $row) {
                $appointed_uid[]                       = $row['appointed_uid'];
                $appointed_list[$row['appointed_uid']] = $row;
            }
        }

        if (!$all_staffs) {
            /** @var \PDOStatement $pdo_statement */
            $pdo_statement = $this->db
                ->query(StaffDAO::selectStaffList($order_info['order_belong_store_id'], true));
            $all_staffs    = $pdo_statement ? $pdo_statement->fetchAll(\PDO::FETCH_ASSOC) : [];
        }
        foreach ($all_staffs as $key => &$staff) {
            // 如果店员设置了不参与分配
            if ($staff['user_no_part'] || $staff['staff_pass'] != 1 || $staff['staff_status'] != 1) {
                unset($all_staffs[$key]);
                continue;
            }
            $staff['staff_assigned'] = \in_array($staff['user_id'], explode('-', $order_info['appointed_uid']), false);
            $staff['can_assign']     = $staff['staff_assigned'] ? true : false; // 本来在指派列表中，可以显示出来
            // 不在指派表中有记录，认为是直接可以分配的
            if (!\in_array($staff['user_id'], $appointed_uid, false)) {
                $can_assign_staff[]  = $staff['user_id'];
                $staff['can_assign'] = true;
            } else {
                if ($appointed_list[$staff['user_id']]) {
                    foreach ($appointed_list as $apo_order) {
                        $order_start = $order_info['contact_appointment_at'];
                        $order_end   = $order_info['contact_appointment_at'] + $order_info['service_length'] * 3600;
                        $apo_start   = $apo_order['contact_appointment_at'];
                        $apo_end     = $apo_order['contact_appointment_at'] + $apo_order['service_length'] * 3600;
                        // 新功能：订单与订单之后有时间间隔，把间隔算进去当前指派订单的结束时间
                        $interval = ConfigModel::getItem('order_interval_time'); // 小时单位
                        $interval && $apo_end += $interval * 3600;

                        if (ToolModel::isTimeCross($order_start, $order_end, $apo_start, $apo_end)) {
                            continue;
                        }
                        $can_assign_staff[]  = $staff['user_id'];
                        $staff['can_assign'] = true;
                    }
                } else {
                    $can_assign_staff[]  = $staff['user_id'];
                    $staff['can_assign'] = true;
                }
            }
        }
        // 去重数组
        $can_assign_staff && $can_assign_staff = array_keys(array_flip($can_assign_staff));
        return [$all_staffs, $can_assign_staff];
    }

    /**
     * 获取店铺信息
     * @param integer $store_id 店铺id
     * @param bool $get_waiter 是否获取服务员列表
     * @return array|bool|false|mixed|string
     */
    public function getStoreInfo($store_id, $get_waiter = false)
    {
        if ($store_info = $this->db->get_row(get_table('store'), ['id' => $store_id])) {
            $store_info = json_encode(filter($store_info));
        }
        $store_info               = json_decode($store_info, true);
        $store_info['staff_list'] = [];
        if ($store_info && $get_waiter) {
            $store_info['staff_list'] = $this->getStoreWaiters($store_id);
        }

        return $store_info;
    }

    /**
     * 获取指定店铺的店员信息
     * @param integer $store_id 店铺ID
     * @return array
     */
    public function getStoreWaiters($store_id): array
    {
        $staff_rows = [];
        /** @var \PDOStatement $pdo_ret */
        $pdo_ret     = $this->db->query(StaffDAO::selectStaffList($store_id, true));
        $_staff_rows = $pdo_ret ? $pdo_ret->fetchAll(\PDO::FETCH_ASSOC) : [];
        // 以用户id作为下标
        foreach ($_staff_rows as $staff_row) {
            if ($staff_row['user_type'] == 3) {
                continue;
            }
            $staff_rows[$staff_row['user_id']] = $staff_row;
        }
        return $staff_rows;
    }

    /**
     * @remark 获取当前用户的店铺信息
     * @param bool $get_wallet 是否获取钱包记录
     * @return array|bool|mixed
     */
    public function getMyStoreInfo($get_wallet = false)
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        $select = 'tb_store.id, tb_staff.staff_name, tb_staff.user_type, tb_staff.staff_pass, tb_staff.staff_status';
        $get_wallet && $select .= ',tb_wallet.balance, tb_wallet.total_income';
        $this->db
            ->select($select, false)
            ->join([get_table('store_user') => 'tb_staff'], ['tb_staff.store_id' => 'tb_store.id'], 'INNER');
        if ($get_wallet) {
            $this->db->join([get_table('staff_wallet') => 'tb_wallet'], ['tb_wallet.staff_id' => 'tb_staff.id'], 'INNER');
        }
        $store_staff = $this->db->get_row([get_table('store') => 'tb_store'], [
            'tb_staff.user_id' => $user_info->user_id
        ]);
        return $store_staff;
    }

    /**
     * 判断当前是否有空闲的清洁师可分配
     * @param int $store_id 店铺id
     * @return int
     */
    public function hasFreeStaff($store_id): int
    {
        return $this->db->join([get_table('store_user') => 'a'], ['a.user_id' => 'b.appointed_uid'], 'INNER')
            ->get_total([get_table('order_appointed') => 'b'], ['a.store_id' => $store_id, 'b.completed' => 1]);
    }
}
