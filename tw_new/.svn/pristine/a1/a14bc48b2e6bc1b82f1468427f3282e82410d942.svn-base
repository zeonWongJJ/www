<?php
/**
 * 店铺模型类
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace model;

class StoreModel extends \utils\BaseModel
{
    /**
     * 升级店铺等级
     * @param $store_id
     * @return bool
     */
    public function upStoreLevel($store_id)
    {
        $store_info = $this->db->get_row('jiajie_store', ['id' => $store_id]);
        if (!$store_info) {
            throw new \RuntimeException('店铺不存在，请检查');
        }
        // 获取升级区间
        $store_level_section = $this->db->get_row('jiajie_config', ['config_key' => 'store_level_section'], 'config_value');
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
        $row = $this->db->get_row('jiajie_store', ['store_id' => $id]);
        if (!$row) {
            return $this->error('no-data');
        }
        if ($row['store_state'] == 0) {
            return $this->error('店铺未审核');
        }
        $result = $this->db->update('jiajie_store', ['store_state' => $state], ['store_id' => $id]);
        if ($result) {
            return $this->success(false);
        }
        return $this->error('开启店铺失败');
    }

    /**
     * todo::统计收益
     * @param $order_sn
     * @return bool
     */
    public function income($order_sn)
    {
        return true;
    }
}
