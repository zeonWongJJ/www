<?php
/**
 * 控制器
 * @notice 命令行自动构建 by rusice <liruizhao970302@outlook.com>
 *
 * @copyright 柒度信息科技有限公司
 * @author rusice <liruizhao970302@outlook.com>
 */

class Message_ctrl extends \utils\BaseController
{
    /**
     * 缓存key前缀
     * @var string
     */
    protected $cache_key = 'message.';

    protected $repository = \repositories\MessageRepository::class;

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
                'message_content' => $this->request->post('message_content', '', 'trim')
            ],
            'update' => [
                // 更新操作时需要获取的字段 例子:
                // 'role_name' =>  $this->request->post('role_name', '', 'trim'),
            ]
        ];

        return $data[$method] ?? [];
    }

    public function setField()
    {
        return [
            'message_content' => '信息内容'
        ];
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
                'message_content' => 'required'
            ],
            'update' => [
                // 更新时的数据验证如：
                // 'role_name' =>  'required'
            ]
        ];

        return $valid[$method] ?? [];
    }

    // - 更多方法定义
    public function getUnReadCount()
    {
        $user_info = app('user_info');
        if (!$user_info || !isset($user_info->user_id)) {
            return $this->error('user-info-error');
        }
        $map = [
            'message_is_read'    => 0,
            'message_notice_uid' => $user_info->user_id
        ];
        $count = $this->db->get_total(get_table('message'), $map);
        return $this->success(['unread' => $count]);
    }
}
