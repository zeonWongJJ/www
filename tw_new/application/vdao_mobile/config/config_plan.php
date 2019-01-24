<?php
// 在控制器实例化之后立即执行，控制器的任何方法都还尚未调用（除构造函数）
$a_config_plan['pre_controller'] = [
    function () {
        $user_auto_login = $_COOKIE[md5('https://vdao-mobile.7dugo.com/')] ?? false;
        if ($user_auto_login) {
            $o_tw = get_instance();
            // 验证cookie
            $a_auto_login = unserialize(base64_decode($user_auto_login));
//            dump($a_auto_login);
            // 验证UA
            if (md5($_SERVER['HTTP_USER_AGENT']) == $a_auto_login['ua']) {
                $row = $o_tw->db->get_row('user_auto_login', ['user_id' => $a_auto_login['user_id']]);
                if ($row) {
                    if ($row['user_salt'] === $a_auto_login['user_salt']) {
                        $user = $o_tw->db->get_row('user', ['user_id' => $a_auto_login['user_id']], 'user_state, user_name');
                        if ($user && $user['user_state'] != 2) {
                            $_SESSION['user_id']   = $a_auto_login['user_id'];
                            $_SESSION['user_name'] = $user['user_name'];
                        }
                    }
                }
            }
        }
    },
];
