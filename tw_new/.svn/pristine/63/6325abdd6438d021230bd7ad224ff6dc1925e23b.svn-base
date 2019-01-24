<?php
/**
 * 数据库的操作 @See https://gitee.com/cqcqphper/taskPHP/blob/master/src/docs/db.md
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace task;

use model\MessageModel;
use model\OrderModel;
use utils\Db;

class CheckAssign
{
    /**
     * 自动派单后，5分钟内清洁师没有“确认接单”，系统自动短信+公众号通知清洁师和平台客服人员比如微信通知阿姨，10分钟依然没接单，系统自动当作拒单处理
     */
    public function run()
    {
        $now_time        = time();
        $message_model   = new MessageModel();
        $order_model     = new OrderModel();
        $no_accept_count = Db::getInstance()->getDB()->get_total(get_table('order_appointed'), [
            'is_accepted' => 0
        ]);
        $no_accept_rows  = Db::getInstance()->getDB()->limit(0, $no_accept_count)->get(get_table('order_appointed'), [
            get_table('order_appointed')
        ]);
        foreach ($no_accept_rows as $accept_row) {
            $cache_key_5m  = 'notify.staff.accept.5min.' . $accept_row['order_sn'] . $accept_row['appointed_uid'];
            $cache_key_10m = 'notify.staff.accept.10min.' . $accept_row['order_sn'] . $accept_row['appointed_uid'];
            if ($now_time - $accept_row['appointed_at'] && !cache($cache_key_5m)) { // 指派记录在5分钟内并且没有通知过
                // 5分钟内清洁师没有“确认接单”，系统自动短信+公众号通知清洁师和平台客服人员比如微信通知阿姨
                cache($cache_key_5m, true, 300);
                $message_model->notifyUser($accept_row['appointed_uid'], '请马上处理');
            } elseif ($now_time - $accept_row['appointed_at'] <= 600 && !cache($cache_key_10m)) {
                // 10分钟依然没接单，系统自动当作拒单处理
                cache($cache_key_10m, true, 600);
                $order_model->rejecteOrder($accept_row['order_sn'], '', $accept_row['appointed_uid'], $accept_row['order_sub_id'], false);
                $message_model->notifyUser($accept_row['appointed_uid'], '由于您10分钟内不做出确认接单操作，已视为拒单处理');
            }
        }
    }
}
