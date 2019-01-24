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
            'b.store_name'
            , 'b.store_phone'
            , 'b.store_region'
            , 'b.store_level'
            , 'b.store_sold'
//            , 'c.pay_type'
//            , 'c.cat_name'
            , 'a.*'
        ];

        $_query = $query->select($select, false)
            ->order_by(['a.service_add_at' => 'desc', 'a.service_update_at' => 'desc'])
            ->join([get_table('store') => 'b'], ['a.store_id' => 'b.id'], 'INNER');

        $debug_users = [208, 123, 124, 123]; // 开发组用户，数据只显示jiajie店铺（id：20）的数据 锐钊、凯星、江周辉、王进
        $test_users  = [75, 117, 127]; // 测试组用户，数据只显示王进店铺（id：26）的数据 中豪、肥羊、松林

        if (\in_array($user_info->user_id, $debug_users, false)) {
            $_query = $_query->where([
                'b.store_status' => 1,
                'b.id'           => 20
            ]);
        } elseif (\in_array($user_info->user_id, $test_users, false)) {
            $_query = $_query->where([
                'b.store_status' => 1,
                'b.id'           => 26
            ]);
        } else {
            $_query = $_query->where(['b.store_status' => 1, 'b.id' => 22]);
        }

        $_query = $_query->where(['a.service_is_del' => 0]);

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
    public function afterGetList(array $rows)
    {
        /** @var ServiceModel $service_model */
        $service_model = Factory::getFactory('service');
        foreach ($rows as $key => &$row) {
//            $row['service_remuneration'] = number_format($row['service_remuneration'] / 100, 2);
            $row['service_remuneration'] = $service_model->computedRemuneration($row['id']);
            $row['service_remuneration'] = number_format($row['service_remuneration'] / 100, 2);
            $row['service_add_at']       = date('Y-m-d H:i:s', $row['service_add_at']);
            $row['service_img']          = explode(',', $row['service_img']);
            $row['service_info']         = htmlspecialchars_decode($row['service_info']);
            $row['service_info']         = str_replace(['&amp;', '&quot;', '&#039;', '&lt;', '&gt;'], ['&', '"', "'", '<', '>'], $row['service_info']);

            // 获取分类 记录
            $cate_info = cache('cate.cache.' . $row['service_level_2']);
            if (!$cate_info) {
                $cate_info = $this->db->get_row(get_table('category'), ['id' => $row['service_level_2']], 'pay_type, cat_name');
                cache('cate.cache.' . $row['service_level_2'], serialize($cate_info), 'redis', 20); // 20s后过期
            } else {
                $cate_info = unserialize($cate_info);
            }

            $row['pay_type'] = $cate_info['pay_type'];
            $row['cat_name'] = $cate_info['cat_name'];

            list($lng, $lat) = explode(',', $row['service_lal']);
            $row['lat'] = trim($lat);
            $row['lng'] = trim($lng);
        }

        return $rows;
    }

    /**
     * @param array $row
     * @return array
     */
    public function afterGetOne(array $row)
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            throw new \RuntimeException('user-info-error');
        }

        $category_id   = [$row['service_level_1'], $row['service_level_2'], $row['service_level_3']];
        $category_rows = $this->db->where_in('id', $category_id)->limit(0, \count($category_id))->get(get_table('category'));
        $categories    = [];
        foreach ($category_rows as $category_row) {
            $categories[$category_row['id']] = filter($category_row);
        }
        $store_info = $this->db->get_row(get_table('store'), ['id' => $row['store_id']]);
        /** @var ServiceModel $service_model */
        $service_model = Factory::getFactory('service');
        if ($row) {
            $row['service_remuneration'] = $service_model->computedRemuneration($row['id']);
            $row['service_remuneration'] = number_format($row['service_remuneration'] / 100, 2);
            $row['service_add_at']       = date('Y-m-d H:i:s', $row['service_add_at']);
//            $row['examine_at']       = date('Y-m-d H:i:s', $row['examine_at']);
            $row['service_img']          = explode(',', $row['service_img']);
            $row['service_level_1_name'] = $categories[$row['service_level_1']]['cat_name'];
            $row['service_level_2_name'] = $categories[$row['service_level_2']]['cat_name'];
            $row['service_level_3_name'] = $categories[$row['service_level_3']]['cat_name'];
            $row['pay_way']              = $categories[$row['service_level_2']]['pay_type'];
            $row['store_name']           = $store_info['store_name'];
            $row['store_tel']            = $store_info['store_phone'];
            $row['service_info']         = htmlspecialchars_decode($row['service_info']);
            $row['service_info']         = str_replace(['&amp;', '&quot;', '&#039;', '&lt;', '&gt;'], ['&', '"', "'", '<', '>'], $row['service_info']);

            list($lng, $lat) = explode(',', $row['service_lal']);
            $row['lat'] = trim($lat);
            $row['lng'] = trim($lng);


            if ('admin' != app('router')->get(1)) {
                unset($row['service_update_at'], $row['service_is_show'], $row['no_pass_reason'], $row['examine_at'], $row['service_status'], $row['service_add_at']);
            }

            // 获取改服务是否已被收藏
            $row['user_collected'] = $this->db->get_total(get_table('user_collect'), [
                'user_id'      => $user_info->user_id
                , 'service_id' => $row['id']
            ]);

            $row['comment_count'] = [
                'hp'   => (int)$this->db->get_total(get_table('comment'), ['service_id' => $row['id'], 'comment_type_star' => 1])
                , 'zp' => (int)$this->db->get_total(get_table('comment'), ['service_id' => $row['id'], 'comment_type_star' => 2])
                , 'cp' => (int)$this->db->get_total(get_table('comment'), ['service_id' => $row['id'], 'comment_type_star' => 3])
                , 'yt' => (int)$this->db->get_total(get_table('comment'), ['service_id' => $row['id'], 'comment_img_urls <>' => ''])
                , 'zs' => (int)$this->db->get_total(get_table('comment'), ['service_id' => $row['id']])
            ];
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
//        $staff_row = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id]);
//
//        if ($staff_row['user_type'] != 3) {
//            throw new \RuntimeException('非店主不能发布服务');
//        }
        $map['user_id'] = $user_info->user_id;
        $store_id       = app('router')->get(1);
        if (!$store_id) {
            if (!$staff_row = $this->db->get_row(get_table('store_user'), ['user_id' => $user_info->user_id], 'store_id')) {
                throw new \RuntimeException('获取不到发布服务的店铺');
            }
            $store_id = $staff_row['store_id'];
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
//        $this->db->update(get_table('store'), ['store_service_count' => $store['store_service_count'] + 1], ['id' => $store_id]);
        return $this->_dealData($insert);
    }

    /**
     * 处理数据，更新前、添加前
     * @param array $insert
     * @return array
     */
    private function _dealData(array $insert): array
    {
        $insert['service_remuneration'] = 100 * $insert['service_remuneration']; //需求酬金，转换成单位元
        $insert['service_info']         = htmlspecialchars($insert['service_info']);

        if ($insert['service_remuneration'] < 1) {
            throw new \RuntimeException('金额不能小于￥1元');
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
        $insert['id']         = $insert['store_id'];
        $insert['service_id'] = $service_id;
        $store_info           = $this->db->get_row(get_table('store'), ['id' => $insert['store_id']], 'store_service_count');
        $this->db->update(get_table('store'), [
            'store_service_count' => $store_info['store_service_count'] + 1
        ], ['id' => $insert['id']]);
        return $insert;
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
    public function afterDeleteHook($id)
    {
        $this->db->delete(get_table('user_collect'), [
            'service_id' => $id
        ]);
    }
}
