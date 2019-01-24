<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 0.1-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace utils;


class Captcha
{
    public $gt_sdk;

    public function __construct($captcha_id, $private_key)
    {
        $this->gt_sdk = new GeetestLib($captcha_id, $private_key);
    }

    /**
     * 使用Get的方式返回：challenge和capthca_id 此方式以实现前后端完全分离的开发模式 专门实现failback
     * @param $uid
     * @param string $client_type
     * @param string $id_addr
     * @return mixed
     */
    public function startServlet($uid, $client_type = 'web', $id_addr = '')
    {
        $id_addr || $id_addr = get_client_ip();
        $data = [
            'user_id'     => $uid,
            'client_type' => $client_type,
            'ip_address'  => $id_addr,
        ];

        $status = $this->gt_sdk->pre_process($data, 1);
        cache('gt.server.' . $uid, $status);
        return $this->gt_sdk->get_response();
    }
}
