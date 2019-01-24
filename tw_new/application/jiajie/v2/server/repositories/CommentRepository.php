<?php
/**
 * 数据仓库
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace repositories;

use model\JifenModel;
use model\OrderModel;
use model\StoreModel;
use model\ToolModel;
use utils\BaseRepository;
use utils\Factory;
use utils\ide\Db;

/**
 * Class CommentRepository
 * @package repositories
 */
class CommentRepository extends BaseRepository
{

    protected $pk_id = 'comment_id';

    /**
     * 指定查询数据表名，不需要带前缀
     * @return String
     */
    public function getDbTable()
    {
        return get_table('comment');
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
     * @return
     */
    //    public function customizeGetter($id, $build_query, $cache_key)
    //    {
    //
    //    }

    /**
     * @param Db $query
     * @return Db
     */
    public function beforeGetOne($query)
    {
        $_query = $query->join(['user' => 'b'], ['b.user_id' => 'a.user_id'], 'INNER')
            ->select('b.user_pic, b.user_name, a.*', false);
        return $_query;
    }

    /**
     * @param array $row
     * @return mixed
     */
    public function afterGetOne($row)
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            throw new \RuntimeException('user-info-error');
        }

        if ($row) {
            $row['comment_img_urls'] = $row['comment_img_urls'] ? explode(',', $row['comment_img_urls']) : [];
            $row['add_time']         = date('Y-m-d H:i:s', $row['add_time']);

            if ($order_info = $this->db->get_row(get_table('order'), ['order_sn' => $row['comment_order_sn']], 'order_pay_way, order_name')) {
                $row['order_pay_way'] = $order_info['order_pay_way'];
                $row['order_name']    = $order_info['order_name'];
            }
        }

        return $row;
    }


    /**
     * 查询列表前操作
     * @param Db $query
     * @return Db
     */
    public function beforeGetList($query)
    {
        $_query = $query->join(['user' => 'b'], ['a.user_id' => 'b.user_id'], 'INNER')
            ->join([get_table('service') => 'c'], ['c.id' => 'a.service_id'], 'INNER')
            ->select('b.user_nickname as user_name, b.user_pic, a.*, c.service_name, a.add_time as comment_add_time', false);

        $data['get_order'] = app('request')->post('get_order', 0, 'intval');
        if ($data['get_order']) {
            $_query = $_query->join([get_table('order') => 'd'], ['a.comment_order_sn' => 'd.order_sn', 'a.comment_order_sub_sn' => 'd.order_sub_sn'], 'INNER')
                ->select('d.*', false);
        }

        return $_query;
    }

    /**
     * 查询列表后操作
     * @param array $rows
     * @return array
     */
    public function afterGetList(array $rows): array
    {
        /** @var OrderModel $order_model */
        $order_model = Factory::getFactory('order');
        $data['get_order'] = app('request')->post('get_order', 0, 'intval');

        foreach ($rows as &$row) {
            $row['comment_add_time'] = date('Y-m-d H:i:s', $row['comment_add_time']);
            $row['comment_img_urls'] = $row['comment_img_urls'] ? explode(',', $row['comment_img_urls']) : [];
            $data['get_order'] && $row['belong_order'] = $order_model->formatOrderRow($row);
        }

        if ($data['get_order']) {
            $keys  = array_keys($rows[0]);
            $fields = ToolModel::queryField('order');
            $remove_keys = array_intersect($fields, $keys);
            foreach ($rows as &$value) {
                foreach ($value as $key => $v) {
                    if (\in_array($key, $remove_keys, false)) {
                        unset($value[$key]);
                    }
                }
            }
        }

        return $rows;
    }

    /**
     * 新增前调用
     * @param array $insert 新增的数据
     * @return array
     */
    public function beforeInsertHook(array $insert): array
    {
        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            throw new \RuntimeException('user-info-error');
        }

        $order_info = $this->db->get_row(get_table('order'), ['order_sn' => $insert['comment_order_sn']]);
        if (!$order_info) {
            throw new \RuntimeException('评论的订单不存在');
        }

        if ($order_info['user_id'] != $user_info->user_id) {
            throw new \RuntimeException('订单不属于自己，不能评论');
        }

        if ($this->db->get_total($this->table, [
            'user_id'            => $user_info->user_id
            , 'comment_order_sn' => $insert['comment_order_sn']
        ])) {
            throw new \RuntimeException('您已经评价此订单');
        }


        if ($order_info['order_type'] == 1) {
            $server_info = $this->db->get_row(get_table('service'), ['id' => $order_info['order_type_id']]);
            if (!$server_info) {
                throw new \RuntimeException('订单所属的服务不存在，请检查!');
            }
            $insert['comment_store_id'] = $server_info['store_id'];
        } elseif ($order_info['order_type'] == 2) {
            $insert['comment_store_id'] = $order_info['order_belong_store_id'];
        }

        if ($order_info['order_type'] == 1) {
            $insert['service_id'] = $order_info['order_type_id'];
        } else {
            $insert['service_id'] = 0;
        }

        $insert['user_id']               = $user_info->user_id;
        $insert['add_time']              = $_SERVER['REQUEST_TIME'];
        $insert['auditing_status']       = 0; //默认未通过审核
        $insert['comment_average_score'] = sprintf('%.2f', ($insert['skill_star'] + $insert['time_efficiency_star'] + $insert['attitude_star']) / 3); // 计算平均得分

        $insert['comment_img_urls'] = \is_array($insert['comment_img_urls'])
            ? implode(',', $insert['comment_img_urls'])
            : trim($insert['comment_img_urls'], ',');

        return $insert;
    }

    /**
     * @remark 新增后调用
     * @param array $insert
     */
    public function afterInsertHook(array $insert)
    {
        /** @var OrderModel $order_model */
        $order_model = Factory::getFactory('order');
        /** @var StoreModel $store_model */
//        $store_model = Factory::getFactory('store');

        $order_store = $this->db
            ->join([get_table('store') => 'a'], ['a.id' => 'b.order_belong_store_id'])
            ->get_row([get_table('order') => 'b'], ['b.order_sn' => $insert['comment_order_sn']]);

        if (3 != $order_store['order_type']) {
            if (1 == $order_store['order_type']) { // 只在支付的是服务时计算好评+等级
                $service_info = $this->db->get_row(get_table('service'), ['id' => $insert['service_id']]);

                if (1 == $insert['comment_type_star']) { // 好评
                    $evaluate_update['store_hp_count']     = $order_store['store_hp_count'] + 1;
                    $service_pj_update['service_hp_count'] = $service_info['service_hp_count'] + 1;
                } elseif (2 == $insert['comment_type_star']) { // 中评
                    $evaluate_update['store_zp_count']     = $order_store['store_zp_count'] + 1;
                    $service_pj_update['service_zp_count'] = $service_info['service_zp_count'] + 1;
                } else { // 差评
                    $evaluate_update['store_cp_count']     = $order_store['store_cp_count'] + 1;
                    $service_pj_update['service_cp_count'] = $service_info['service_cp_count'] + 1;
                }

                $this->db->update(get_table('store'), $evaluate_update, ['id' => $service_info['store_id']]); // 更新店铺总好评/中评/差评数
                $this->db->update(get_table('service'), $service_pj_update, ['id' => $insert['service_id']]); // 更新服务总好评/中评/差评数

//                $store_model->upStoreLevel($service_info['store_id']); // 计算一次店铺等级

                // 重新计算一次服务的星级
//                $service_update                          = [
//                    'service_comment_count' => $service_info['service_comment_count'] + 1, // 总评价数
//                    'service_score_count'   => $service_info['service_score_count'] + $insert['comment_average_score'], // 总得分数
//                    'service_sold'          => $service_info['service_sold'] + 1
//                ];
                $this->db->set('service_comment_count', 'service_comment_count + 1', false) // 总评价数
                    ->set('service_score_count', 'service_score_count + 1', false) // 总得分数
                    ->set('service_sold', 'service_sold + 1', false) // 销量
                    ->set('service_average_score', 'FORMAT(service_score_count / service_comment_count, 2)', false) // 计算平均得分
                    ->update(get_table('service'), null, ['id' => $service_info['id']]);
            }

             $order_model->orderSettlement($insert['comment_order_sn'], $insert['comment_order_sub_sn']); // 结算订单
             $order_model->reward($insert['comment_order_sn']); // 上级获得回佣
            // 返还积分
            /** @var JifenModel $jifen_model */
            $jifen_model = Factory::getFactory('jifen');
            $jifen_model->restore($insert['comment_order_sn'], $insert['comment_order_sub_sn']); // 执行积分返还

            // 记录订单日志
            $this->db->insert(get_table('order_log'), [
                'order_sn'     => $insert['comment_order_sn'],
                'order_sub_sn' => $insert['comment_order_sub_sn'],
                'log_at'       => $_SERVER['REQUEST_TIME'],
                'log'          => '用户已给出评价，订单完成并结算',
                'uid'          => $insert['user_id']
            ]);
            $order_update = [
                'order_bis_state_dsc' => 'COMPLETED',
                'order_comment_id' => $insert['id'],
                'order_state'      => 5
            ];
            $this->db->update(get_table('order'), $order_update, [
                'order_sn'     => $insert['comment_order_sn'],
                'order_sub_sn' => $insert['comment_order_sub_sn']
            ]);
            // 通知服务人员
        } else {
            throw new \RuntimeException('充值订单不允许评价');
        }
    }

    /**
     * 新增后调用
     * @param array $insert 新增的数据
     */
    //    public function afterInsertHook(array $insert)
    //    {
    //
    //    }

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
