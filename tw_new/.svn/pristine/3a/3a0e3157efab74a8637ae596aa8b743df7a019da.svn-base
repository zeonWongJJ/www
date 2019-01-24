<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace Model\wechat\action\sendMsg;


abstract  class AbstractSendMsg
{
    /**
     * @return string
     */
    abstract public function response(): ?string;

    /**
     * 事件触发
     */
    public function tigger()
    {
        $reponse_xml_templtae = $this->response();
    }
}
