<?php
/**
 *
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

use utils\BaseController;

class Subscribe_ctrl extends BaseController
{
    public $_ignore_node = [
        'insert',
    ];

    public $repository = \repositories\SubscribeRepository::class;

    /**
     * 数据获取
     * @param $method
     * @return array
     */
    public function getData($method): array
    {
        $row = [
            'cate_id' => $this->request->post('cate_id', 0, 'intval'),
        ];

        $data = [
            'insert' => $row,
            'update' => $row,
        ];

        return $data[$method] ?? [];
    }

    /**
     * 验证规则
     * @param $method
     * @return array|mixed
     */
    public function valid($method)
    {
        $row = [
            'cate_id' => 'required|number',
        ];

        $valid = [
            'insert' => $row,
            'update' => $row,
        ];

        return $valid[$method] ?? [];
    }

    /**
     * @return array
     */
    public function setField(): array
    {
        return [
            'cate_id' => '预约分类id',
        ];
    }

    /**
     * 取消预约，用户主动取消与后台客户取消统一走这里
     * @router http://server.name/user.subscribe.cancel
     */
    public function cancel()
    {
        $data['id'] = $this->router->get(1);
        $this->validate($data, [
            'id' => 'required|number',
        ]);

        $user_info = app('user_info');

        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }

        if ('ADMIN' == \model\TokenModel::getSourceSign()) {
            $update['subscribe_state'] = 'NEGOTIATED_CANCEL';

            $this->db->insert(get_table('admin_log'), [
                'log_at' => $_SERVER['REQUEST_TIME'],
                'log_content' => '客户人员与用户协商取消预约号' . $data['id'],
                'admin_uid' => $user_info->user_id,
            ]);
        } else {
            $update['subscribe_state'] = 'ACTIVE_CANCEL';
        }

        $update['cancel_at']   = $_SERVER['REQUEST_TIME'];
        $update['cancel_uid'] = $user_info->user_id;

        $this->db->update(get_table('subscribe'), $update, $data);

        return $this->success(false);
    }
}
