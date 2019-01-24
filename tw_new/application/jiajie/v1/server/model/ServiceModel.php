<?php
/**
 * 服务model
 * @author rusice <liruizhao970302@oulook.com>
 */

namespace model;

use utils\BaseModel;

class ServiceModel extends BaseModel
{
    /**
     * 计算服务的收费，根据店铺等级+收费上涨比例得出结果
     * @param int $service_id 服务记录在表中的主键id
     * @return float|int
     */
    public function computedRemuneration($service_id)
    {
        $service_info = $this->db->get_row('jiajie_service', ['id' => $service_id]);
        if (!$service_info) {
            throw new \RuntimeException('服务不存在，请检查');
        }
        $store_info      = $this->db->get_row('jiajie_store', ['id' => $service_info['store_id']], 'store_level'); // 查询店铺信息
        $rate_rise_ratio = $this->db->get_row('jiajie_config', ['config_key' => 'rate_rise_ratio'], 'config_value'); // 查询出收费按照该设置数上涨百分比
        if ($rate_rise_ratio['config_value'] > 0) {
            $rate_rise_ratio = $rate_rise_ratio['config_value'] / 100;
        } else {
            $rate_rise_ratio = $rate_rise_ratio['config_value'] * 1;
        }
        $store_level = $store_info['store_level'] > 0 ? $store_info['store_level'] : 1;
        // 最终收费结果 = 原价 + 原价 * (等级 - 1) * 上涨百分比
        return $service_info['service_remuneration'] + $service_info['service_remuneration'] * ($store_level - 1) * $rate_rise_ratio;
    }
}