<?php
/**
 * 控制器
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

class Collect_ctrl extends \utils\BaseController
{

    protected $repository = \repositories\CollectRepository::class;

    /**
     * 数据获取
     * @param $method
     * @return array
     */
    public function getData($method): array
    {
        $data = [
            'insert' => [
                // 写入操作时需要获取的字段 例子:
                'service_id' => $this->request->post('service_id', 0, 'intval')
            ],
            'update' => [
                // 更新操作时需要获取的字段 例子:
                // 'role_name' =>  $this->request->post('role_name', '', 'trim'),
            ]
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
        $valid = [
            'insert' => [
                // 写入时的数据验证如：
                'service_id' => 'required|number'
            ],
            'update' => [
                // 更新时的数据验证如：
                // 'role_name' =>  'required'
            ]
        ];

        return $valid[$method] ?? [];
    }

    public function setField()
    {
        return [
            'service_id' => '服务id'
        ];
    }

    // - 更多方法定义

    /**
     * 重写父类的删除方法，支持批量删除
     * @return mixed
     */
    public function delete()
    {
        $id = (int)$this->router->get(1);
        if (!$id) {
            $id = $this->request->post('id/a', [], 'trim');
            $id = is_string($id) ? explode(',', trim($id, ',')) : $id;
        }
        if (!$id) {
            return $this->error('没有获取到需要取消的收藏id');
        }
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        $query = $this->db->where(['user_id' => $user_info->user_id]);
        if (is_array($id)) {
            $query = $query->where_in('service_id', $id);
//            $this->db->where(['user_id' => $user_info->user_id])->where_in('id', $id)->delete(get_table('user_collect'));
        } else {
            $query = $query->where(['service_id' => $id]);
        }
        $query->delete(get_table('user_collect'));
        return $this->success(false);
    }
}
