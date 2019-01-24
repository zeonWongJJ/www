<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace Model\wechat\action\sendMsg;

use Model\wechat\MsgTemplate;

class RequestTextAction
{
    public function response($to, $form, $content)
    {
        $response = sprintf(
            MsgTemplate::getTextTemplate(), $to, $form, time(), $content
        );
        return $response;
    }
}
