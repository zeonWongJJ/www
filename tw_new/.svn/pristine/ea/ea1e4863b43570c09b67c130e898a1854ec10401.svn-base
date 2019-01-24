<?php
/**
 * 发送短信的定时任务
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */

$msm_id = $argv[0] ?? false;
if ($msm_id) {
    list($hostname, $port) = explode(':', getenv('MYSQL_HOST'));
    $dsn = 'mysql:dbname=' . getenv('MYSQL_DB_NAME') . ';host=' . $hostname . ';port=' . $port;
    try {
        $pdo = new PDO($dsn, getenv('MYSQL_USER_NAME'), getenv('MYSQL_USER_PWD'));
        $sql = "SELECT * FROM qq_jiajie_v2_task_send_msm WHERE id = {$msm_id} LIMIT 1";
        $pdo_state = $pdo->query($sql);
        $task = $pdo_state->fetch(PDO::FETCH_ASSOC);
        include '/tw/core/Short_message.php';
        $tw = new TW_Short_message();
        $rs = $tw->send(
            $task['phone_number'],
            $task['msm_message'],
            'notice'
        );
        $tw->get_error();
        if (!$rs) {
            $sql = "INSERT INTO qq_jiajie_v2_msm_error SET error_code = :error_code, error_msg =:error_msg, error_at = :error_at";
            $result = $pdo->prepare($sql);
            $err_msg = $tw->get_error();
            $arr = explode('，', $err_msg);
            $result->execute([
                'error_code'    =>  str_replace('错误码：','',$arr[0]),
                'error_msg'     => $err_msg,
                'error_at'      => $_SERVER['REQUEST_TIME']
            ]);
        }
    } catch (PDOException $e) {

    }
}
