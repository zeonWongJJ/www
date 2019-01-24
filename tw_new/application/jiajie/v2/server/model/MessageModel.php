<?php
/**
 * 信息通知模型，处理用于通知用户的相关逻辑
 *
 * @author rusice <liruzihao970302@outlook.com>
 * @version 0.0.1-dev
 * @copyright 广州柒度信息科技有限公司
 */

namespace model;

use JPush\Client as JPush;

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
    protected $message_note_uid;

    public static function jPushLoader($class)
    {
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        $file = ROOT_PATH . 'utils/jpush/src/' . $path . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }

    /**
     * 推送APP消息
     * @param int $note_uid
     * @param string $message_info
     * @param array $config
     */
    public function appPush($note_uid = 0, $message_info = '', array $config = [])
    {
        $note_uid || $note_uid = $this->message_note_uid;
        $message_info || $message_info = $this->message_content;
        try {
            $online = $this->db->get_total(get_table('access_token'), [
                'user_type'   => 'user',
                'expir_at >=' => $_SERVER['REQUEST_TIME'],
                'user_id'     => $note_uid
            ]);
            if ($online) {
                // 安卓推送需要手动指定未读消息条数
                $unread = $this->db->get_total(get_table('message'), [
                    'message_notice_uid' => $note_uid,
                    'message_is_read'   =>  0
                ]);
                spl_autoload_register([$this, 'jPushLoader']);
                include CONFIGPATH . '/config_jpush.php';
                if (isset($config_jpush)) {
                    $client = new JPush($config_jpush['app_key'], $config_jpush['master_secret'], ROOT_PATH . '/runtime/jpush.log');
                    $extra = array_merge([
                        'url'   => trim(getenv('TOUCH_DOMAIN'), '/') . '/#/notice',
                        'route' => 'notice'
                    ], $config);
                    $client->push()
                        ->setPlatform(['ios', 'android'])
                        ->addAlias((string)$note_uid)//androidAlias 别名，到时候直接用用户ID
//                    ->addAllAudience(['alias' => ['qidu']])
                        ->setNotificationAlert($message_info)
                        ->iosNotification($message_info, [
                            'sound'  => 'sound',
                            'badge'  => '+1',
                            'extras' => $extra
                        ])
                        ->androidNotification($message_info, [
                            'extras' => array_merge($extra, [
                                'badge' => $unread
                            ])
                        ])
                        ->options([
                            'apns_production' => !APP_DEBUG
                        ])
                        ->send();
                }
            }
        } catch (\JPush\Exceptions\JPushException $e) {
            file_put_contents(ROOT_PATH . '/runtime/jpush.log', '推送出错!' . $e->getMessage(), FILE_APPEND);
        }
    }

    /**
     * 执行通知用户
     *
     * @param $note_uid
     * @param $message_info
     * @return MessageModel
     */
    public function notifyUser($note_uid, $message_info)
    {
        $this->message_note_uid = $note_uid;
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
     * 微信公众号推送
     */
    public function notifyMP()
    {

    }

    /**
     * 发送验证码
     * @param $phone
     * @return bool|int
     * @throws \Exception
     */
    public function sendVerifyCode($phone)
    {
        $code    = random_int(1000, 9999);
        $message = '您的验证码为 ' . $code . '，5分钟内有效，请及时完成验证。如非本人操作请忽略！';

        if (getenv('APP_DEBUG')) {
            return $code;
        }

        $result = $this->sendMsm($phone, $message, 0);
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
    public function sendMsm($phone, $message = '', $delay = 0): bool
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
            if (!$this->short_message->send($phone, $message, 'authcode', $delay)) {
                $err_msg = $this->short_message->get_error();
                $arr     = explode('，', $err_msg);
                $this->db->insert(get_table('msm_error'), [
                    'error_code' => str_replace('错误码：', '', $arr[0]),
                    'error_msg'  => $err_msg,
                    'error_at'   => $_SERVER['REQUEST_TIME']
                ]);
                return false;
            }
            return true;
        }

        $this->db->insert(get_table('msm_error'), [
            'error_code' => 0,
            'error_msg'  => '短信余额不足',
            'error_at'   => $_SERVER['REQUEST_TIME']
        ]);
        return false;
    }

    /**
     * 异步发送短信，可做延时发送
     * @param string $phone 发送的手机号码
     * @param string $delay 定时发送的日期时间戳
     * @param string $message 短信内容
     * @return bool
     */
    public function asyncSend($phone, $delay, $message = ''): bool
    {
        if (!$message) {
            if (!$this->message_content) {
                throw new \RuntimeException('短信内容不能为空');
            }
            $message = $this->message_content;
        }
        $insert_id = $this->db->insert(get_table('task_send_msm'), [
            'phone_number' => $phone,
            'msm_message'  => $message,
            'appointed_at' => strtotime($delay)
        ]);
        $command   = '/usr/bin/php /www/server/crontab/send_msn.php ' . $insert_id;
        ToolModel::add_crontab_job(
            date('i', $delay),
            date('H', $delay),
            date('d', $delay),
            date('m', $delay),
            date('w', $delay),
            $command
        );
        return true;
    }

    /**
     * 验证验证码是否匹配
     * @param string $phone 手机号码
     * @param string $code 验证码
     * @return mixed
     */
    public function checkVerifyCode($phone, $code)
    {
        if (!getenv('APP_DEBUG')) {
            return true;
        }

        $_code = $this->cache('user.code.' . $phone);
        if (!$_code) {
            return $this->error('验证码以过期或未获取');
        }
        if ($code == $_code) {
            return true;
        }
        return $this->error('验证码不匹配');
    }
}
