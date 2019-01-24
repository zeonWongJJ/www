<?php
/**
 * 数据仓库
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace repositories;

use model\ServiceModel;
use model\StoreModel;
use model\TokenModel;
use utils\BaseRepository;
use utils\Factory;
use utils\ide\Db;

/**
 * Class ServiceRepository
 * @package repositories
 */
class ServiceRepository extends BaseRepository
{
    /**
     * 指定查询数据表名，不需要带前缀
     * @return String
     */
    public function getDbTable()
    {
        return get_table('service');
    }

    /**
     * @param Db $query
     * @return Db
     */
    public function beforeGetList($query)
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            throw new \RuntimeException('user-info-error');
        }

        $visit_source = app('router')->get(1);
        if (!$visit_source) {
            // 检查是否开启审核
            $config = $this->db->get_row(get_table('config'), ['config_key' => 'open_service_examine'], 'config_value');

            if ($config && $config['config_value'] == 'true') {
                $this->condition['a.service_is_show'] = 1; // 开启了审核后，获取列表时只获取已审核的
            }
        }

        $select = [
            'b.store_name',
            'b.store_phone',
            'b.store_region',
            'b.store_level',
            'b.store_sold',
            'a.*',
        ];

        $_query = $query->select($select, false)
            ->order_by(['a.service_add_at' => 'desc', 'a.service_update_at' => 'desc'])
            ->join([get_table('store') => 'b'], ['a.store_id' => 'b.id'], 'INNER');

//        $debug_users = [208, 123, 124, 123]; // 开发组用户，数据只显示jiajie店铺（id：20）的数据 锐钊、凯星、江周辉、王进
//        $test_users  = [75, 117, 127]; // 测试组用户，数据只显示王进店铺（id：26）的数据 中豪、肥羊、松林
//
//        if (\in_array($user_info->user_id, $debug_users, false)) {
//            $_query = $_query->where([
//                'b.store_status' => 1,
//                'b.id'           => 20,
//            ]);
//        } elseif (\in_array($user_info->user_id, $test_users, false)) {
//            $_query = $_query->where([
//                'b.store_status' => 1,
//                'b.id'           => 26,
//            ]);
//        } else {
//            $_query = $_query->where(['b.store_status' => 1]);
//        }

        $_query = $_query->where(['a.service_is_del' => 0, 'b.store_status' => 1]);

        return $_query;
    }

    /**
     * 查询指定前置操作
     * @param Db $query
     * @param int $id
     * @return Db
     */
    public function beforeGetOne($query, $id)
    {
        // 查询是否开启审核
        $open_service_examine = $this->db->get_row(get_table('config'), ['config_key' => 'open_service_examine'], 'config_value'); // 获取是否开启服务发布需要后台验证

        if ($open_service_examine == 'true') {
            $this->condition['a.service_is_show'] = 1;
        }

        return $query;
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
     * @param array $rows
     * @return array
     */
    public function afterGetList(array $rows): array
    {
        /** @var ServiceModel $service_model */
        $service_model = Factory::getFactory('service');
        foreach ($rows as &$row) {
            $row = $service_model->formatRow($row);
        }

        return $rows;
    }

    /**
     * @remark 获取一条数据后调用
     * @param array $row 服务数据
     * @return array
     */
    public function afterGetOne(array $row): array
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            throw new \RuntimeException('user-info-error');
        }

        if ($row) {
            /** @var ServiceModel $service_model */
            $service_model = Factory::getFactory('service');
            /** @var StoreModel $store_model */
            $store_model = Factory::getFactory('store');
            $row         = $service_model->formatRow($row, true, true);
            // 获取店铺信息
            $get_store_info = app('request')->post('get_store_info', 0, 'intval');
            if ($get_store_info) {
                $store_info        = $this->db->get_row(get_table('store'), [
                    'id' => $row['row']['store_id']
                ], 'store_name, store_hp_count, store_comment_count
                    , store_address, store_region, store_sold, store_phone
                    , store_service_count, store_pic, store_type, store_lal');
                $row['store_info'] = $store_model->formatRow($store_info);
            }
            // 店铺是否被收藏
            $row['store_collected'] = (boolean)$this->db->get_total(get_table('user_collect'), [
                'collect_type' => 'STORE',
                'item_id'      => $row['row']['store_id'],
                'user_id'      => $user_info->user_id,
            ]);
            // 服务是否被收藏
            $row['service_collected'] = (boolean)$this->db->get_total(get_table('user_collect'), [
                'collect_type' => 'SERVICE',
                'item_id'      => $row['row']['id'],
                'user_id'      => $user_info->user_id,
            ]);
            // 判断是否有子项目，如果有的话取出最低价
            $checp_item = $this->db->order_by(['item_change' => 'asc'])
                ->get_row(get_table('service_items'), [
                    'service_id' => $row['row']['id'],
                    'is_show'    => 1
                ], 'item_change');
            if ($checp_item) {
                $row['row']['service_remuneration'] = (double)sprintf('%.2f', $checp_item['item_change'] / 100);
            }
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
        $map['user_id'] = $user_info->user_id;
        $store_id       = app('router')->get(1) ?: false;
        if (!$store_id) {
            if ('ADMIN' === TokenModel::getSourceSign()) {
                $store_id = 1;
            } else {
                $staff_row = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id], 'store_id');
                $store_id  = $staff_row['store_id'];
            }
        }

        $store_info = $this->db->get_row(get_table('store'), ['id' => $store_id]);
        $category = $this->db->get_row(get_table('category'), ['id' => $insert['service_cate_id']], 'is_self_support');
        if ($category['is_self_support'] && $store_info['store_type'] != 'SELF_SUPPORT') {
            throw new \RuntimeException('自营服务必须自营店铺才能发布');
        }

        if (false === $store_id) {
            throw new \RuntimeException('获取不到发布服务的店铺');
        }

        $insert['store_id']       = $store_id; // 店铺id
        $insert['service_add_at'] = $_SERVER['REQUEST_TIME'];
        // 检查是否开启审核
        $config = $this->db->get_row(get_table('config'), ['config_key' => 'open_service_examine'], 'config_value');

        if ($config && $config['config_value'] == 'false') {
            $insert['service_is_show'] = 1;
            $insert['examine_at']      = $_SERVER['REQUEST_TIME'];
        } else {
            $insert['service_is_show'] = 0;
        }
        $insert['service_average_score'] = 5.00; // 默认评分5星
        return $this->_dealData($insert);
    }

    /**
     * 处理数据，更新前、添加前
     * @param array $insert
     * @return array
     */
    private function _dealData(array $insert): array
    {
        if ($insert['order_charging'] == 'NON_RESERVATION') {
            $insert['service_remuneration'] = 0;
        } else {
            $insert['service_remuneration'] = 100 * $insert['service_remuneration']; //需求酬金，转换成单位元
            if ($insert['service_remuneration'] < 1) {
                throw new \RuntimeException('金额不能小于1元');
            }
        }

        $insert['service_info'] = htmlspecialchars($insert['service_info']);
        if (!\in_array($insert['order_charging'], ['NON_RESERVATION', 'FIXED_PRICE', 'HAS_RESERVATION'])) {
            throw new \RuntimeException('收费方式不支持');
        }

        // 处理计价单位，如果是一口价/免预约金，不需要单位
        if (!$this->db->get_total(get_table('value_unit'), ['id' => $insert['service_value_unit_id']])) {
            throw new \RuntimeException('计价单位不支持');
        }

        // 处理图片
        if ($insert['service_img']) {
            if (\is_array($insert['service_img'])) {
                $images_array          = $insert['service_img'];
                $insert['service_img'] = implode(',', $insert['service_img']);
            } else {
                $images_array = explode(',', trim($insert['service_img'], ','));
            }

            if (\count($images_array) > 12) {
                throw new \RuntimeException('上传图片不能超过12张');
            }
        } else {
            $insert['service_img'] = '';
        }

        //        // 处理支付途径，当支付方式为[price][deposit]必须传递demand_price_type
        //        if (!\in_array($insert['service_pay_way'], ['price', 'deposit', 'free'])) {
        //            throw new \RuntimeException('非法支付方式!');
        //        }

        // 判断是否经额度
        preg_match('/^.*,.*$/', $insert['service_lal'], $match);

        if (!$match) {
            throw new \RuntimeException('经纬度格式不正确');
        }

        // 处理分类id
        $insert['service_level_1'] = $insert['service_level_2'] = $insert['service_level_3'] = $insert['service_cate_id'];

        unset($insert['service_cate_id']);
        return $insert;
    }

    /**
     * 新增后调用
     * @param array $insert 新增的数据
     * @return array
     */
    public function afterInsertHook(array $insert)
    {
        $service_id           = $insert['id'];
        $insert['service_id'] = $service_id;
        $store_info           = $this->db->get_row(get_table('store'), ['id' => $insert['store_id']], 'store_service_count');
        $this->db->update(get_table('store'), [
            'store_service_count' => $store_info['store_service_count'] + 1,
        ], ['id' => $insert['id']]);

        $append['service_sn'] = 'BJJ' . str_pad(0, 12, $insert['id'], STR_PAD_LEFT);
        $this->db->update($this->table, $append, ['id' => $insert['id']]);

        $this->_dealOtherItem($insert['id']);

        return $insert;
    }

    /**
     * 写入其他关联内容
     * @param integer $service_id 服务id
     */
    private function _dealOtherItem($service_id)
    {
        // 写入服务项目
        $item_arr = app('request')->post('item_arr/a', [], 'trim');
        /** @var ServiceModel $service_model */
        $service_model = Factory::getFactory('service');
        if ($item_arr) {
            $item_inserts = [];
            foreach ($item_arr as $item) {
                $item_inserts[] = [
                    'item_change' => $item['item_change'] * 100,// 项目收费，单位分
                    'item_desc'   => trim($item['item_desc']),
                    'item_name'   => trim($item['item_name']),
                    'service_id'  => $service_id,
                    'is_show'     => $item['is_show'] ? 1 : 0,
                    'item_add_at' => $_SERVER['REQUEST_TIME']
                ];
            }
            $this->db->inserts(get_table('service_items'), $item_inserts);
        }
        $item_inserted = $this->db->limit(0, \count($item_arr))->get(get_table('service_items'), [
            'service_id'  => $service_id,
            'item_add_at' => $_SERVER['REQUEST_TIME']
        ], 'id');
        unset($item_arr);
        foreach ($item_inserted as $inserted) {
            $service_model->padItemSN($inserted['id']);
        }

        // 写入服务专业设备
        $equipment_arr = app('request')->post('service_equipment/a', [], 'trim');
        if ($equipment_arr) {
            $equipment_arr_inserts = [];
            foreach ($equipment_arr as $equipment) {
                $equipment_arr_inserts[] = [
                    'equipment_name'    => trim($equipment['equipment_name']),
                    'equipment_img'     => trim($equipment['equipment_img']),
                    'equipment_content' => trim($equipment['equipment_content']),
                    'equipment_add_at'  => $_SERVER['REQUEST_TIME'],
                    'equipment_sort'    => (int)$equipment['equipment_sort'],
                    'service_id'        => $service_id
                ];
            }
            $this->db->inserts(get_table('service_equipment'), $equipment_arr_inserts);
            unset($equipment_arr);
        }

        // 写入服务标准
        $standard_arr = app('request')->post('service_standards/a', [], 'trim');
        if ($standard_arr) {
            $standard_arr_inserts = [];
            foreach ($standard_arr as $standard) {
                $standard_arr_inserts[] = [
                    'standards_desc'   => trim($standard['standards_desc']),
                    'standards_cover'  => trim($standard['standards_cover']),
                    'service_id'       => $service_id,
                    'standards_sort'   => (int)$standard['standards_sort'],
                    'standards_add_at' => $_SERVER['REQUEST_TIME']
                ];
            }
            $this->db->inserts(get_table('service_standards'), $standard_arr_inserts);
        }
        unset($standard_arr);
    }

    /**
     * 更新前调用
     * @param array $update 传入的更新数据
     * @param int $id 要更新的id
     * @return array
     */
    public function beforeUpdateHook(array $update, $id): array
    {
        $update['service_update_at'] = $_SERVER['REQUEST_TIME'];
        $update['service_info']      = htmlspecialchars($update['service_info']);

        return $this->_dealData($update);
    }
}
