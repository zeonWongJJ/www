<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace model;

use model\dao\AddressDAO;

class AddressModel extends BaseModel
{
    /**
     * 根据服务过滤不可服务的地址
     * @param int $service_id 服务id
     * @return array
     */
    public function filterByService($service_id): array
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            throw new \RuntimeException('user-info-error');
        }
        $service_info = $this->db
            ->select('a.store_range, b.service_lal')
            ->where(['b.id' => $service_id])
            ->join([get_table('service') => 'b'], ['b.store_id' => 'a.id'], 'INNER')
            ->get_row([get_table('store') => 'a']);

        $store_range = $service_info['store_range'] * 1000; // 数据库存的是千米单位，下面SQL语句查询出来的是米
        list($lng, $lat) = explode(',', $service_info['service_lal']);
        $total        = $this->db->get_total(get_table('user_address'), ['user_id' => $user_info->user_id]);
        /** @var \PDOStatement $pdo_ret */
        $pdo_ret      = $this->db->query(AddressDAO::selectAddressWithDistance($lat, $lng, $total));
        $address_rows = $pdo_ret ? $pdo_ret->fetchAll(\PDO::FETCH_ASSOC) : [];
        $addresses = [
            'within' => [],
            'notin'  => []
        ];
        foreach ($address_rows as $row) {
            if ($row['juli'] <= $store_range) {
                $addresses['within'][] = $row;
            } else {
                $addresses['notin'][] = $row;
            }
        }

        return [$addresses, $total];
    }
}
