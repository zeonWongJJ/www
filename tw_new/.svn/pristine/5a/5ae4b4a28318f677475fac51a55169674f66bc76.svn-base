<?php
/**
 * 用户需求数据仓库
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace repositories;

use model\DemandModel;
use model\OrderModel;
use model\TokenModel;
use utils\BaseRepository;
use utils\Factory;
use utils\ide\Db;

/**
 * Class DemandRepository
 * @package repositories
 */
class DemandRepository extends BaseRepository
{
    /**
     * 缓存key前缀
     * @var string
     */
    protected $cache_key = 'user.demand.';

    /**
     * 指定查询数据表名，不需要带前缀
     * @return String
     */
    public function getDbTable()
    {
        return get_table('demand');
    }

    /**
     * @param Db $query
     * @return Db
     * @throws \Exception
     */
    public function beforeGetList($query)
    {
        /** @var DemandModel $demand_model */
        $demand_model = Factory::getFactory('demand');
        $demand_model->BeOverdue();

        if ('ADMIN' != TokenModel::getSourceSign()) {
            $config = $this->db->get_row(get_table('config'), ['config_key' => 'open_demand_examine'], 'config_value');

            if ($config && $config['config_value'] == 'true') {
                $this->condition['a.demand_is_show'] = 1; // 开启了审核后，获取列表时只获取已审核的
            } else {
                $this->condition['a.demand_is_show <>'] = 2;
            }
        }

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
        $map             = [
            'b.order_type'            => 2,
            'b.order_state <>'        => 4,
            'b.order_is_pay'          => 1,
            'b.order_belong_store_id' => 0
        ];
        $this->condition = array_merge($this->condition, $map);
        $_query          = $query->join([get_table('order') => 'b'], ['a.order_sn' => 'b.order_sn'], 'INNER')
            ->order_by(['a.demand_post_at' => 'desc'])
            ->select(array_merge(['a.*'], $columns), false);
        return $_query;
    }

    /**
     * 查询数据后调用
     * @param array $rows
     * @return array
     */
    public function afterGetList(array $rows): array
    {
        /** @var DemandModel $demand_model */
        $demand_model = Factory::getFactory('demand');
        $user_lat     = app('request')->post('lat', '', 'trim');
        $user_lng     = app('request')->post('lng', '', 'trim');

        foreach ($rows as &$row) {
            $row = $demand_model->formatRow($row, $user_lat && $user_lng);
        }

        if ($user_lat && $user_lng) {
            $rows = array_sort_by_key($rows, '_distance', 'asc'); // 按照计算出来的距离排序数组
        }
        return $rows;
    }

    /**
     * 查询一条后的处理
     * @param array $row
     * @return array
     */
    public function afterGetOne(array $row): array
    {
        $is_admin = 'admin' == app('router')->get(2);
        if ($row) {
            if ($is_admin) {
                $category_id   = [$row['demand_level_1'], $row['demand_level_2'], $row['demand_level_3']];
                $categories    = $this->db->limit(0, 3)->where_in('id', $category_id)->select('cat_name, id, pay_type')->get(get_table('category'));
                $category_rows = [];
                foreach ($categories as $category) {
                    $category_rows[$category['id']] = $category;
                }

                $row['demand_level_1_name'] = $category_rows[$row['demand_level_1']]['cat_name'];
                $row['demand_level_2_name'] = $category_rows[$row['demand_level_2']]['cat_name'];
                $row['demand_level_3_name'] = $category_rows[$row['demand_level_3']]['cat_name'];
                $row['pay_way']             = $category_rows[$row['demand_level_2']]['pay_type'];

                list($lng, $lat) = explode(',', $row['demand_lal']);
                $row['lat'] = trim($lat);
                $row['lng'] = trim($lng);

                $order_info                           = $this->db->get_row(get_table('order'), ['order_sn' => $row['order_sn']]);
                $order_info['order_actual_amount']    = sprintf('%.2f', $order_info['order_actual_amount'] / 100); // 订单实付款
                $order_info['order_amount']           = sprintf('%.2f', $order_info['order_amount'] / 100); // 订单应付款
                $order_info['order_deductible_count'] = sprintf('%.2f', $order_info['order_deductible_count'] / 100); // 抵扣多少
                $order_info['add_time']               = date('Y-m-d H:i:s', $order_info['add_time']);
                $order_info['pay_time']               = $order_info['pay_time'] ? date('Y-m-d H:i:s', $order_info['pay_time']) : 0;
                $order_info['receipt_at']             = $order_info['receipt_at'] ? date('Y-m-d H:i:s', $order_info['receipt_at']) : 0;
                $row['order_info']                    = filter($order_info);
            } else {
                $cate_info      = $this->db->get_row(get_table('category'), ['id' => $row['demand_level_2']]);
                $row['pay_way'] = $cate_info['pay_type'];
            }

            if ($row['service_store_id']) {
                $store_info               = $this->db->get_row(get_table('store'), ['id' => $row['service_store_id']], 'store_name');
                $row['demand_store_name'] = $store_info['store_name'];
            }

            $row['demand_service_at']   = date('Y-m-d H:i:s', $row['demand_service_at']);
            $row['demand_remuneration'] = number_format($row['demand_remuneration'] / 100, 2);
            $row['demand_img']          = explode(',', $row['demand_img']);

            unset($row['demand_is_show'], $row['no_pass_reason'], $row['demand_pay_type']);
        }
        return $row;
    }

    /**
     * 新增前调用
     * @param array $insert 新增的数据
     * @return mixed
     */
    public function beforeInsertHook(array $insert)
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            throw new \RuntimeException('user-info-error');
        }

        $insert['demand_level_1'] = $insert['demand_level_2'] = $insert['demand_level_3'] = $insert['demand_cate_id'];
        unset($insert['demand_cate_id']);

        $insert['demand_service_at']   = $insert['demand_post_at'] = $_SERVER['REQUEST_TIME'];
        $insert['demand_remuneration'] = 100 * $insert['demand_remuneration']; //需求酬金，单位分
        $insert['demand_user_id']      = $user_info->user_id;

        if (!APP_DEBUG && $insert['demand_remuneration'] < 100) {
            throw new \RuntimeException('需求金额最小单位为1');
        }

        // 处理图片
        if ($insert['demand_img']) {
            if (\is_array($insert['demand_img'])) {
                $images_array         = $insert['demand_img'];
                $insert['demand_img'] = implode(',', $insert['demand_img']);
            } else {
                $insert['demand_img'] = trim($insert['demand_img'], ',');
                $images_array         = explode(',', $insert['demand_img']);
            }

            if (\count($images_array) > 9) {
                throw new \RuntimeException('上传图片不能超过9张');
            }
        } else {
            $insert['demand_img'] = '';
        }

        if (!\in_array($insert['demand_price_type'], ['alipay', 'wechat', 'bankcard'])) {
            throw new \RuntimeException('支付方式未被支持!');
        }

        // 判断是否经额度
        if (!preg_match('/^.*,.*$/', $insert['demand_lal'])) {
            throw new \RuntimeException('经纬度格式不正确');
        }

        list($lng, $lat) = explode(',', $insert['demand_lal']);
        $insert['demand_lat'] = $lat;
        $insert['demand_lng'] = $lng;

        $insert['demand_is_show'] = 0;

//        $today_timestamp            = strtotime(date('Y-m-d 00:00:00')); // 今天0点时间戳
//        $insert['demand_start_day'] = strtotime($insert['demand_start_day']); // 需求开始时间戳
//        $insert['demand_is_show']   = strtotime($insert['demand_end_day']);// 需求结束时间戳
//
//        if ($insert['demand_start_day'] < $today_timestamp) {
//            throw new \RuntimeException('开始时间不能在当天之前');
//        }
//
//        if ($insert['demand_is_show'] < $insert['demand_start_day']) {
//            throw new \RuntimeException('结束时间不能小于开始时间');
//        }
//
//        $time_diff = $insert['demand_is_show'] - $insert['demand_start_day'];

//        $insert['demand_days']    = (int)ceil($time_diff / 86400); // 向上取整天数

        return $insert;
    }

    /**
     * 自定义列表查询方法
     * 当需要join等非单表查询时可以调用此方法
     * @param array $build_query 查询构建数组，前端传入的排序、字段等
     * @param string $data_set 返回数据集类型
     */
    //    public function customizeListGetter(array $build_query, $data_set)
    //    {
    //
    //    }


    /**
     * 自定义单条查询方法
     * 当需要join等非单表查询时可以调用此方法
     * @param int $id 单条获取的id
     * @param array $build_query 查询构建数组，前端传入的排序、字段等
     * @param string $cache_key cache的key
     */
    //    public function customizeGetter($id, $build_query, $cache_key)
    //    {
    //
    //    }
    /**
     * 新增后调用,用于写入订单
     * @param array $insert 新增的数据
     * @return array
     */
    public function afterInsertHook(array $insert): array
    {
        $request                         = app('request');
        $insert['order_deductible_type'] = $request->post('order_deductible_type', 0, 'intval'); //  抵扣方式，0无递归，1抵扣余额，2抵扣积分
        /** @var OrderModel $order_model */
        $order_model = Factory::getFactory('order');
        $order_info  = $order_model->setContact(
            $insert['demand_telephone']
            , $insert['demand_address_name']
            , $insert['demand_house_number']
            , $insert['demand_contact_name']
        )->coumpteDeductible(
            $insert['order_deductible_type']
        )->unifiedOrder(
            OrderModel::ORDER_USRE_DEMAND,
            $insert['id'],
            $insert['demand_price_type'],
            $insert['demand_remuneration']
        );
        list($lat, $lng) = explode(',', $insert['demand_lal']);
        $this->db->update($this->table, ['order_sn' => $order_info['order_sn']], ['id' => $insert['id']]); // 更新写入订单流水号
        $this->db->update(get_table('order'), [
            'contact_appointment_at' => $insert['demand_service_at'],
            'order_lat'              => $lat,
            'order_lng'              => $lng,
        ], ['order_sn' => $order_info['order_sn']]);
        OrderModel::orderLogger($order_info['order_sn'],$insert['demand_user_id'],'创建订单');
        return $order_info;
    }

    /**
     * 更新前调用
     * @param array $update 传入的更新数据
     * @param int $id 要更新的id
     * @return array
     */
    //    public function beforeUpdateHook(array $update, $id): array
    //    {
    //
    //    }

    /**
     * 更新后调用
     * @param int $id 要更新的id
     */
    //    public function afterUpdateHook($id)
    //    {
    //
    //    }

    /**
     * 删除前调用
     * @param int $id 删除的id
     */
    //    public function beforeDeleteHook($id)
    //    {
    //
    //    }

    /**
     * 删除后调用
     * @param int $id 要删除的id
     */
    //    public function afterDeleteHook($id)
    //    {
    //
    //    }

}
