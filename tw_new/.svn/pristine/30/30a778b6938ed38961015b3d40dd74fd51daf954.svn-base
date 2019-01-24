<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 0.1-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

use \utils\BaseController;
use \utils\Captcha;

class Captcha_ctrl extends BaseController
{
    public function startServlet()
    {
        $user_sign = $this->request->get('user_sign', '', 'trim');
        $captcha   = new Captcha(get_config_item('captcha_id'), get_config_item('private_key'));
        $response = $captcha->startServlet($user_sign);
        return $this->success($response);
    }
}
