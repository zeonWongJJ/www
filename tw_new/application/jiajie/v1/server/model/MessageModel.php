<?php
/**
 * 信息通知模型，处理用于通知用户的相关逻辑
 *
 * @author rusice <liruzihao970302@outlook.com>
 * @version 0.0.1-dev
 * @copyright 广州柒度信息科技有限公司
 */

namespace model;

use utils\BaseModel;

/**
 * Class MessageModel
 * @package model
 */
class MessageModel extends BaseModel
{
    /**
     * 通知的内容
     * @var string
     */
    protected $message_content;

    /**
     * 执行通知用户
     *
     * @param $note_uid
     * @param $message_info
     * @return MessageModel
     */
    public function notifyUser($note_uid, $message_info)
    {
        $this->message_content = $message_info;
        $this->db->insert(get_table('message'), [
            'message_content'    => $message_info,
            'message_post_at'    => $_SERVER['REQUEST_TIME'],
            'message_notice_uid' => $note_uid,
            'message_info_id'    => 0,
        ]);

        return $this;
    }

    /**
     * 发送验证码
     * @param $phone
     * @return bool|int
     * @throws \Exception
     */
    public function sendVerifyCode($phone)
    {
        $code    = random_int(0, 999999);
        $message = '您的验证码为 ' . $code . '，5分钟内有效，请及时完成验证。如非本人操作请忽略！';
        $result  = $this->sendMsm($phone, $message, 0);

        return $result ? $code : false;
    }

    /**
     * 执行发送短信，并非同步发送，写入任务表队列延迟执行
     *
     * @param string|array $phone 手机号码
     * @param string $message 短信内容
     * @param int $delay 延迟多少秒发送
     * @return bool
     * @throws \Exception
     */
    public function sendMsm($phone, $message = '', $delay = 0)
    {

        if (!$message) {
            if (!$this->message_content) {
                throw new \RuntimeException('短信内容不能为空');
            }
            $message = $this->message_content;
        }

        $this->load->library('short_message'); //加载发送短信的类
        $i_surplus = $this->short_message->balance();
        if ($i_surplus) {
            $this->short_message->send($phone, $message, 'authcode', $delay);
            return true;
        }
        return false;
    }
}
