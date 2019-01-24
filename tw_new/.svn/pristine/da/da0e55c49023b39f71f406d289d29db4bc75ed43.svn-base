<?php
/**
 * 服务model
 * @author rusice <liruizhao970302@oulook.com>
 */

namespace model;

use utils\Factory;

class ServiceModel extends BaseModel
{
    /**
     * 格式化数据
     * @param array $row
     * @param bool $is_get_count 是否获取好评数统计
     * @param bool $is_get_detail 是否获取详情
     * @return array
     */
    public function formatRow(array $row, $is_get_count = false, $is_get_detail = false): array
    {
        ksort($row);
        $row['service_remuneration'] = $this->computedRemuneration($row['id']);
        $row['service_remuneration'] = number_format($row['service_remuneration'] / 100, 2);
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

        $is_get_count && $row['comment_count'] = [
            'hp' => (int)$this->db->get_total(get_table('comment'), ['service_id' => $row['id'], 'comment_type_star' => 1]),
            'zp' => (int)$this->db->get_total(get_table('comment'), ['service_id' => $row['id'], 'comment_type_star' => 2]),
            'cp' => (int)$this->db->get_total(get_table('comment'), ['service_id' => $row['id'], 'comment_type_star' => 3]),
            'yt' => (int)$this->db->get_total(get_table('comment'), ['service_id' => $row['id'], 'comment_img_urls <>' => '']),
            'zs' => (int)$this->db->get_total(get_table('comment'), ['service_id' => $row['id']]),
        ];

        $category_id   = [$row['service_level_1'], $row['service_level_2'], $row['service_level_3']];
        $category_rows = $this->db
            ->where_in('id', $category_id)
            ->limit(0, \count($category_id))
            ->get(get_table('category'));

        $categories    = [];
        foreach ($category_rows as $category_row) {
            $categories[$category_row['id']] = filter($category_row);
        }

        $row['service_level_1_name'] = $categories[$row['service_level_1']]['cat_name'] ?? '';
        $row['service_level_2_name'] = $categories[$row['service_level_2']]['cat_name'] ?? '';
        $row['service_level_3_name'] = $categories[$row['service_level_3']]['cat_name'] ?? '';
        $row['pay_way']              = $categories[$row['service_level_2']]['pay_type'] ?? ''; // todo::2.0版本可能不需要付费方式

        if ($row['service_is_show'] != 2) {
            unset($row['no_pass_reason']);
        }

        if ('ADMIN' != TokenModel::getSourceSign()) {
            unset($row['service_update_at'], $row['service_is_show'], $row['no_pass_reason'], $row['examine_at'], $row['service_status'], $row['service_add_at']);
        } else {
            foreach (['service_update_at', 'examine_at', 'service_add_at'] as $field) {
                $row[$field] = date('Y-m-d H:s:i', $row[$field]);
            }
        }

        $row['service_level_1'] = (int)$row['service_level_1'];
        $row['service_level_2'] = (int)$row['service_level_2'];
        $row['service_level_3'] = (int)$row['service_level_3'];
        if ($is_get_detail) {
            $item['row'] = $row;
        } else {
            $item = $row;
        }

        // 获取详情
        if ($is_get_detail) {
            $details = ['service_items', 'service_equipment', 'service_flow', 'service_standards'];
            foreach ($details as $detail) {
                $item_total = $this->db->get_total(get_table($detail), [
                    'service_id' => $row['id']
                ]);
                $service_item          = $this->db->limit(0, $item_total ?: 1)
                    ->get(get_table($detail), ['service_id' => $row['id']]);
                if ($detail == 'service_items') {
                    $item['service_items'] = filter($service_item);
                    foreach ($item['service_items'] as &$s_item) {
                        $s_item['item_change'] = (double)sprintf('%.2f', $s_item['item_change'] / 100);
                    }
                } else {
                    $item['detail'][$detail] = filter($service_item);
                }
            }
        }

        return $item;
    }

    /**
     * 计算服务的收费，根据店铺等级+收费上涨比例得出结果
     * @param int $service_id 服务记录在表中的主键id
     * @return float|int
     */
    public function computedRemuneration($service_id)
    {
        $service_info = $this->db->get_row(get_table('service'), ['id' => $service_id]);
        if (!$service_info) {
            throw new \RuntimeException('服务不存在，请检查');
        }
        $store_info      = $this->db->get_row(get_table('store'), ['id' => $service_info['store_id']], 'store_level'); // 查询店铺信息
        $rate_rise_ratio = $this->db->get_row(get_table('config'), ['config_key' => 'rate_rise_ratio'], 'config_value'); // 查询出收费按照该设置数上涨百分比
        if ($rate_rise_ratio['config_value'] > 0) {
            $rate_rise_ratio = $rate_rise_ratio['config_value'] / 100;
        } else {
            $rate_rise_ratio = $rate_rise_ratio['config_value'] * 1;
        }
        $store_level = $store_info['store_level'] > 0 ? $store_info['store_level'] : 1;
        // 最终收费结果 = 原价 + 原价 * (等级 - 1) * 上涨百分比
        return $service_info['service_remuneration'] + $service_info['service_remuneration'] * ($store_level - 1) * $rate_rise_ratio;
    }

    /**
     * 服务项目写入唯一编号
     * @param integer $item_id 服务项目表自增id
     */
    public function padItemSN($item_id): void
    {
        $this->db->update(get_table('service_items'), [
            'item_sn' => 'BJJ_ITEM_' . str_pad($item_id, 6, '0', STR_PAD_LEFT)
        ], ['id' => $item_id]);
    }
}
