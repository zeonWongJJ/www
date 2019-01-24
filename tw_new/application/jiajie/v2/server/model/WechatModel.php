<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace Model;

class WechatModel extends BaseModel
{
    const MSG_TYPE_EVENT = 'event'; // 事件消息类型
    const MSG_TYPE_TEXT = 'text'; // 文本消息类型
    const EVENT_SUBSCRIBE = 'subscribe'; // 关注事件

    /**
     * 用于第一次网站url合法性
     * @param string $lock_file
     */
    public function valid($lock_file)
    {
        $echostr = $_GET['echostr'] ?? false;
        if ($echostr) {
            if ($this->_checkSignature()) {
                exit($echostr);
            } else {
                $this->responseMsg();
            }
        }
    }

    /**
     * 检查签名
     * @return bool
     */
    private function _checkSignature()
    {
        $wx_token  = self::getConfigField('wx_token');
        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce     = $_GET['nonce'];
        $tmp_arr   = [$wx_token, $timestamp, $nonce];
        sort($tmp_arr, SORT_STRING);
        $tmp_arr = implode($tmp_arr);
        $tmp_arr = sha1($tmp_arr);
        return $signature == $tmp_arr;

    }

    /**
     * 获取微信配置字段
     * @param $field
     * @return bool
     */
    private static function getConfigField($field)
    {
        include CONFIGPATH . '/config_wxpubpay.php';
        return $a_config_wxpay[$field] ?? false;
    }

    /**
     * @remark 响应消息给用户
     */
    public function responseMsg()
    {
        $xml_str = $GLOBALS['HTTP_RAW_POST_DATA'];
        if (empty($xml_str)) {
            die('');
        }
        libxml_disable_entity_loader(true);
        $request_xml = simplexml_load_string($xml_str, 'SimpleXMLElement', LIBXML_NOCDATA);
        switch ($request_xml->MsgType) {
            case self::MSG_TYPE_EVENT:
                //判断具体的时间类型（关注、取消、点击）
                $event = $request_xml->Event;
                $this->_listenEvent($event);
                break;
            case self::MSG_TYPE_TEXT:
                break;
        }
    }

    /**
     * 事件监听
     * @param $eventName
     */
    private function _listenEvent($eventName)
    {
        switch ($eventName) {
            case self::EVENT_SUBSCRIBE: // 关注事件
                break;
        }
    }
}
