<?php

class Home_ctrl extends TW_Controller
{

    public function __construct()
    {
        parent:: __construct();
        $this->load->model('home_model');
        $this->load->model('allow_model');
        $this->load->model('modetr_model');
        $this->allow_model->is_login();
        $this->allow_model->is_allow();
    }

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $store_id = $_SESSION['store_id'];
            // 获取门店信息
            $a_data['store'] = $this->home_model->get_store_one($store_id);
            // 获取当前门店办公室总数
            $a_data['office_total'] = $this->home_model->get_office_total($store_id);
            // 获取正在使用中的办公室
            $a_appointment                = $this->home_model->get_appointment_store($store_id);
            $office_arr                   = [];
            $a_data['appointment_state1'] = 0;
            $a_data['appointment_state2'] = 0;
            $a_data['appointment_state3'] = 0;
            foreach ($a_appointment as $key => $value) {
                if (!in_array($value['office_id'], $office_arr)) {
                    $office_arr[] = $value['office_id'];
                }
                if ($value['appointment_state'] == 1) {
                    $a_data['appointment_state1'] = $a_data['appointment_state1'] + 1;
                }
                if ($value['appointment_state'] == 2) {
                    $a_data['appointment_state2'] = $a_data['appointment_state2'] + 1;
                }
                if ($value['appointment_state'] == 3) {
                    $a_data['appointment_state3'] = $a_data['appointment_state3'] + 1;
                }
            }
            $a_data['office_useing'] = count($office_arr);
            // 停用的办公室数量
            $a_data['office_stop'] = $this->home_model->get_office_stop($store_id);
            $a_data['office_free'] = $a_data['office_total'] - $a_data['office_useing'] - $a_data['office_stop'];
            // 获取月咖啡销售额
            $a_coffee               = $this->home_model->get_coffee_month();
            $todaystart             = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            $a_data['coffee_today'] = 0;
            $a_data['coffee_month'] = 0;
            $a_data['coffee_cup']   = 0;
            foreach ($a_coffee as $key => $value) {
                if ($value['order_time'] >= $todaystart) {
                    $a_data['coffee_today'] = $a_data['coffee_today'] + $value['goods_amount'];
                    $a_data['coffee_cup']   = $a_data['coffee_cup'] + $value['order_count'];
                }
                $a_data['coffee_month'] = $a_data['coffee_month'] + $value['goods_amount'];
            }
            // 获取门店所有评论
            $a_comment         = $this->home_model->get_comment_all($store_id);
            $good_comment      = 0;
            $goods_score_all   = 0;
            $service_score_all = 0;
            if (!empty($a_comment)) {
                foreach ($a_comment as $key => $value) {
                    if ($value['comment_cate'] == 1) {
                        $good_comment = $good_comment + 1;
                    }
                    $goods_score_all   = $goods_score_all + $value['goods_score'];
                    $service_score_all = $service_score_all + $value['service_score'];
                }
                $a_data['goods_score']   = round($goods_score_all / count($a_comment), 1);
                $a_data['service_score'] = round($service_score_all / count($a_comment), 1);
                $a_data['good_ratio']    = round($good_comment / count($a_comment) * 100);
            } else {
                $a_data['goods_score']   = 0;
                $a_data['service_score'] = 0;
                $a_data['good_ratio']    = 0;
            }
            // 最近评论
            $a_data['comment_recently'] = $this->home_model->get_comment_recently($store_id);
            // 根据状态获取咖啡订单数量
            $a_data['order_waitsong'] = $this->home_model->get_order_state(25);
            $a_data['order_waiting']  = $this->home_model->get_order_state(30);
            $a_data['order_jiedan']   = $this->home_model->get_order_state(20);
            // 获取客流量
            $this->load->library('passenger_flow');
            $a_data['passenger_day'] = $this->passenger_flow->get_entity($a_data['store']['passenger_openid'], date('Y-m-d', time() - 3600 * 24 * 30), date('Y-m-d', time()));
            if (!empty($a_data['passenger_day']['content'])) {
                foreach ($a_data['passenger_day']['content'] as $key => $value) {
                    if ($value['time'] == date('Y-m-d', time())) {
                        $a_data['todaypassenger'] = $value['in'];
                    }
                }
            } else {
                $a_data['todaypassenger'] = 0;
            }
            // 实体详情
            $a_shiti_detail = $this->passenger_flow->get_entity_detail($a_data['store']['passenger_openid']);
            // 实体第一个设备的openid
            $deviceopenId    = $a_shiti_detail['content']['passageways'][0]['devices'][0]['openId'];
            $a_passenger_min = $this->passenger_flow->get_device($deviceopenId, date('Y-m-d', time()), date('Y-m-d', time()));
            // echo "<pre>";
            // var_dump($a_data['passenger_min']);die;
            $hourtime_arr  = [];
            $hourtime_data = [];
            if (!empty($a_passenger_min['content'])) {
                foreach ($a_passenger_min['content'] as $key => $value) {
                    $newtime  = strtotime($value['time']);
                    $hourtime = date('h', $newtime);
                    if (!in_array($hourtime, $hourtime_arr)) {
                        $hourtime_arr[]  = $hourtime;
                        $value['hour']   = $hourtime;
                        $hourtime_data[] = $value;
                    } else {
                        foreach ($hourtime_data as $k => $v) {
                            if ($hourtime == $v['hour']) {
                                $v['batchIn']    = $v['batchIn'] + $value['batchIn'];
                                $v['batchOut']   = $v['batchOut'] + $value['batchOut'];
                                $v['in']         = $v['in'] + $value['in'];
                                $v['out']        = $v['out'] + $value['out'];
                                $hourtime_data[] = $v;
                                unset($hourtime_data[$k]);
                            }
                        }
                    }
                }
                $a_data['passenger_min'] = $hourtime_data;
            } else {
                $a_data['passenger_min'] = [];
            }
            // 未读消数
            $_SESSION['oute'] = $this->db->get_total('messagess', ['ues' => 2, 'ues_id' => $_SESSION['store_id'], 'examine' => 1]);
            $this->view->display('index2', $a_data);
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // 此处为修改管理员密码
            $old_password      = trim($this->general->post('old_password'));
            $manager_password  = trim($this->general->post('manager_password'));
            $manager_password2 = trim($this->general->post('manager_password2'));
            // 验证数据合法性
            $a_parameter = [
                'msg'  => '必填项不能为空',
                'url'  => 'index',
                'log'  => false,
                'wait' => 2,
            ];
            if (empty($old_password) || empty($manager_password) || empty($manager_password2)) {
                $this->error->show_error($a_parameter);
            }
            if ($manager_password != $manager_password2) {
                $a_parameter['msg'] = '两次密码输入不一致';
                $this->error->show_error($a_parameter);
            }
            // 验证密码是否含有特殊字符
            $special_character = ['!', '@', '$', '%', '^', '&', '*', '(', ')', '+', '=', '~', '·', '<', '>', ',', '.', '。', '，', '?', '/', '\\', '|', ':', ';', '[', ']', '【', '】', '{', '}', '"', "'", '`'];
            //将密码拆分为数组并循环匹配
            for ($i = 0; $i < strlen($manager_password); $i++) {
                $name_array[] = $manager_password[$i];
            }
            for ($i = 0; $i < count($name_array); $i++) {
                if (in_array($name_array[$i], $special_character)) {
                    $a_parameter['msg'] = '密码不能含有特殊符号';
                    $this->error->show_error($a_parameter);
                }
            }
            // 获取密码强度
            $manager_safe = $this->manager_safe($manager_password);
            // 验证旧密码是否正确
            $a_data = $this->home_model->get_manager_one($_SESSION['manager_id']);
            if (md5(md5($old_password)) != $a_data['manager_password']) {
                $a_parameter['msg'] = '旧密码输入不正确';
                $this->error->show_error($a_parameter);
            }
            // 验证通过则保存新密码
            $a_uwhere = [
                'manager_id' => $_SESSION['manager_id'],
            ];
            $a_udata  = [
                'manager_password' => md5(md5($manager_password)),
                'manager_safe'     => $manager_safe,
                'update_time'      => $_SERVER['REQUEST_TIME'],
            ];
            $i_result = $this->home_model->update_manager($a_uwhere, $a_udata);
            if ($i_result) {
                $a_parameter['msg'] = '修改成功';
                $this->error->show_success($a_parameter);
            } else {
                $a_parameter['msg'] = '修改失败';
                $this->error->show_error($a_parameter);
            }
        }
    }

    /**************************************** 账号安全等级 ****************************************/

    public function manager_safe($str)
    {
        $score = 0;
        if (preg_match("/[0-9]+/", $str)) {
            $score++;
        }
        if (preg_match("/[0-9]{3,}/", $str)) {
            $score++;
        }
        if (preg_match("/[a-z]+/", $str)) {
            $score++;
        }
        if (preg_match("/[a-z]{3,}/", $str)) {
            $score++;
        }
        if (preg_match("/[A-Z]+/", $str)) {
            $score++;
        }
        if (preg_match("/[A-Z]{3,}/", $str)) {
            $score++;
        }
        if (preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]+/", $str)) {
            $score += 2;
        }
        if (preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]{3,}/", $str)) {
            $score++;
        }
        if (strlen($str) >= 10) {
            $score++;
        }
        return $score;
    }

    /*********************************************************************************************/

    // 未读消数
    public function oute()
    {
        $this->modetr_model->modert();
        $i_oute = $this->db->get_total('messagess', ['ues' => 2, 'ues_id' => $_SESSION['store_id'], 'examine' => 1]);
        echo json_encode(['stur' => 50, 'data' => $i_oute]);
        die;
    }

    //消息管理
    public function message()
    {
        // 先设置默认从第一页开始
        $i_page = $this->router->get(1);
        if (empty($i_page)) {
            $i_page = 1;
        }
        // 设置每页显示的数据行数
        $i_prow = 1;
        // 加载分页类
        $this->load->library('pages');
        // 获取数据总行数
        $a_data_count = $this->db->query("SELECT count(*) as total, group_concat(mess_id) as ids, from_unixtime(mess_time,'%Y%m%d') as day from '.$this->db->get_prefix().'messagess WHERE `ues` = '2' AND `ues_id` = {$_SESSION['store_id']} group by day order by day desc");
        $i_total      = 0;
        foreach ($a_data_count as $key => $value) {
            $i_total++;
        }
        // 调用分页运算函数
        $a_pdata = $this->pages->get($i_total, $i_page, $i_prow);
        // 开始获取产品数据
        $this->db->limit($a_pdata['start'], $a_pdata['last']);

        $a_data['get']   = $this->db->query("SELECT count(*) as total, group_concat(mess_id) as ids, from_unixtime(mess_time,'%Y%m%d') as day from '.$this->db->get_prefix().'messagess WHERE `ues` = '2' AND `ues_id` = {$_SESSION['store_id']} group by day order by day desc limit " . ($i_page - 1) * $i_prow . ',' . $i_prow);
        $a_data['messg'] = $this->db->get('messagess', ['ues' => 2, 'ues_id' => $_SESSION['store_id']], '', ['mess_id' => 'desc'], 0, 9999999999999);
        // echo $this->db->get_sql();
        $a_data['getr'] = $this->db->get_total('messagess', ['ues' => 2, 'ues_id' => $_SESSION['store_id']]);
        $up_data        = $this->db->update('messagess', ['examine' => 2], ['ues' => 2, 'ues_id' => $_SESSION['store_id']]);
        // 未读消都变已读
        $_SESSION['oute'] = $this->db->get_total('messagess', ['ues' => 2, 'ues_id' => $_SESSION['store_id'], 'examine' => 1]);
        $this->view->display('message', $a_data);
    }

}
