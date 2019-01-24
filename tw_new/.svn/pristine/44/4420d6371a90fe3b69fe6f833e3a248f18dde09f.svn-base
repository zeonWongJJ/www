<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */
date_default_timezone_set('PRC');

$temp_timestamp = strtotime('+1 day'); // 测试变量 1天后

function checkIsBetweenTime($start, $end, $timestamp)
{
    $date          = date('H:i', $timestamp);
    $cur_time      = strtotime($date);
    $assign_time_1 = strtotime($start);
    $assign_time_2 = strtotime($end);
    return $cur_time > $assign_time_1 && $cur_time < $assign_time_2;
}

var_dump(checkIsBetweenTime('19:00', '21:00', $temp_timestamp));
