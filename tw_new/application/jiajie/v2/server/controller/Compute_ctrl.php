<?php

class Compute_ctrl extends \utils\BaseController
{

    public $_ignore_node = [
        'level'
    ];

    public function level()
    {
        // 初始化数据
        $this->db->update(get_table('service'), ['service_average_score' => 5.00, 'service_sold' => 0, 'service_hp_count' => 0, 'service_zp_count' => 0, 'service_cp_count' => 0]);
        $this->db->update(get_table('store'), ['store_hp_count' => 0, 'store_zp_count' => 0, 'store_cp_count' => 0, 'store_level' => 1, 'store_sold' => 0]);
        $comment_count = $this->db->get_total(get_table('comment'));
        $comment_rows  = $this->db->limit(0, $comment_count)->get(get_table('comment'));

        var_dump($comment_rows);

        // 获取一定好评后升级
        $store_level_section = $this->db->get_row(get_table('config'), ['config_key' => 'store_level_section'], 'config_value');

        foreach ($comment_rows as $row) {
            $store_info   = $this->db->get_row(get_table('store'), ['id' => $row['comment_store_id']]);
            $service_info = $this->db->get_row(get_table('service'), ['id' => $row['service_id']]);
            $this->db->update(get_table('store'), ['store_sold' => $store_info['store_sold'] + 1], ['id' => $store_info['id']]);
            if ($row['comment_type_star'] == 1) {
                $service_update['service_hp_count'] = $service_info['service_hp_count'] + 1;
                $store_update['store_hp_count']     = $store_info['store_hp_count'] + 1;
                if ($store_level_section) {
                    $temp = floor($store_info['store_hp_count'] / $store_level_section['config_value']);
                    $store_update['store_level'] = $temp ?: 1; // 舍去法取整,如果为0则为1
                }
            } else if ($row['comment_type_star'] == 2) {
                $service_update['service_zp_count'] = $service_info['service_zp_count'] + 1;
                $store_update['store_zp_count']     = $store_info['store_zp_count'] + 1;
            } else if ($row['comment_type_star'] == 3) {
                $service_update['service_cp_count'] = $service_info['service_cp_count'] + 1;
                $store_update['store_cp_count']     = $store_info['store_cp_count'] + 1;
            }
            $store_update['store_comment_count'] = $store_info['store_comment_count'] + 1;

            $this->db->update(get_table('service'), $service_update, ['id' => $row['service_id']]);
            $this->db->update(get_table('store'), $store_update, ['id' => $row['comment_store_id']]);

            // 重新计算一次服务的星级
            $comment_service_rows  = $this->db->get_total(get_table('comment'), ['service_id' => $row['service_id']]);
            $all_comments          = $this->db->limit(0, $comment_service_rows)->get(get_table('comment'), ['service_id' => $row['service_id']]);
            $comment_average_score = 0;
            foreach ($all_comments as $comment) {
                $comment_average_score += $comment['comment_average_score'];
            }

            $this->db->update(get_table('service'), [
                'service_average_score' => sprintf('%.2f', $comment_average_score / $comment_service_rows)
                , 'service_sold'        => $service_info['service_sold'] + 1 //完成交易后才结算销量
            ], ['id' => $row['service_id']]);
        }

        echo 'ok';
    }
}
