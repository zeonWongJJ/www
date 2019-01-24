<?php
/**
 * 评论控制器
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

class Comment_ctrl extends \utils\BaseController
{

    protected $repository = \repositories\CommentRepository::class;

    /**
     * 数据获取
     * @param $method
     * @return array
     */
    public function getData($method): array
    {
        $rows = [
            'comment_order_sn'      => $this->request->post('comment_order_sn', '', 'trim'), // 评论的订单流水号
            'comment_order_sub_sn'  => $this->request->post('comment_order_sub_sn', 0, 'intval'), // 评论的订单子编号
            'comment_type_star'     => $this->request->post('comment_type_star', 0, 'intval'), // 好评星级级别，默认好评，1好评2中评3差评
            'comment_content'       => $this->request->post('comment_content', '', 'trim'), //评论的内容
            'product_comment_score' => $this->request->post('product_comment_score', 0, 'float'), // 商品(服务)被评论的分数(星级)
            'comment_img_urls'      => $this->request->post('comment_img_urls/a', [], 'trim'), // 评论图片地址
            'skill_star'            => $this->request->post('skill_star', 0, 'float'), // 技能星级
            'attitude_star'         => $this->request->post('attitude_star', 0, 'float'), // 服务态度星级
            'time_efficiency_star'  => $this->request->post('time_efficiency_star', 0, 'float'), //时间效率星级
        ];
        $data = [
            'insert' => $rows,
            'update' => $rows
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
        $rows  = [
            'comment_order_sn'  => 'required|length:23',
            'comment_type_star' => 'required|number',
            'comment_content'   => 'required'
        ];
        $valid = [
            'insert' => $rows,
            'update' => $rows
        ];

        return $valid[$method] ?? [];
    }

    /**
     * @return array
     */
    public function setField(): array
    {
        return [
            'comment_order_sn'     => '评论的订单号',
            'comment_order_sub_sn' => '评论的订单子编号',
            'comment_type_star'    => '评价类型',
            'comment_content'      => '评论内容'
        ];
    }

    // - 更多方法定义
    public function auditing()
    {
        $id = $this->router->get(1);
        if (!$id) {
            $id = $this->request->post('id/a', [], 'trim');
        }
        if (!$id) {
            return $this->error('获取不到指定的id');
        }

        $query = $this->db;

        if (is_array($id)) {
            $query = $query->where_in('comment_id', $id);
        } else {
            $query = $query->where(['comment_id' => $id]);
        }
        $query->update(get_table('comment'), ['auditing_status' => 1]);

        return $this->success(false);
    }

    /**
     * 检查当前评论是否可以操作
     * @router http://server.name/comment.check.canIdo
     * @return mixed
     */
    public function checkHasComment()
    {
        $order_sn  = $this->router->get(1);
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        if (!$order_info = $this->db->get_row(get_table('order'), ['order_sn' => $order_sn])) {
            throw new \RuntimeException('评论的订单不存在');
        }

        if ($order_info['user_id'] != $user_info->user_id) {
            throw new \RuntimeException('订单不属于自己，不能评论');
        }

        if ($this->db->get_total(get_table('comment'), [
            'user_id'               => $user_info->user_id
            , '$user_info->user_id' => $order_sn
        ])) {
            return $this->error('您已经评价此订单');
        }
        return $this->success(false);
    }

    /**
     * 获取指定服务的评论列表
     * @router http://server.name/service.comment.list-{service_id}
     */
    public function ServiceCommentList()
    {
        $service_id = $this->router->get(1);
        list($field, $sort, $offset, $limit, $condition) = $this->buildQuery();

        if (!$service_id) {
            return $this->error('服务id必须');
        }

        $condition = array_merge(['service_id' => $service_id], $condition);

        $count = $this->db->get_total(get_table('comment'), $condition);
        $rows  = $this->db->limit($offset, $limit)->get(get_table('comment'), $condition);

        $rows = filter($rows);
        foreach ($rows as &$row) {
            $row['comment_img_urls'] && $row['comment_img_urls'] = explode(',', $row['comment_img_urls']);
        }

        return success($rows, $count, [
            'sql' => APP_DEBUG ? $this->db->get_sql() : ''
        ]);
    }
}
