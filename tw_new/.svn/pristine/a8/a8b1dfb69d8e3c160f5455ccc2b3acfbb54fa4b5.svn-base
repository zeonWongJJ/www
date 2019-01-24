<?php

class User_ctrl extends TW_Controller
{

    public function __construct()
    {
        parent:: __construct();
        $this->load->model('user_model');
        $this->load->model('allow_model');
        if ('upload.qrcode' != $this->router->get_index()) {
            $this->allow_model->is_login();
        }
    }

    /************************************* 我的评价 *************************************/

    public function user_comment()
    {
        // var_dump($this->db->get_row("test", ['order_id' =>981]));exit;
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // 获取一条用户信息
            $a_data['user'] = $this->user_model->get_user_one($_SESSION['user_id']);
            // 获取用户的评价
            $a_data['comment'] = $this->user_model->get_user_comment($_SESSION['user_id'], 1);
            $this->view->display('user_comment', $a_data);
        }
    }

    /************************************* 个人信息 *************************************/
    public function user_mine()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            //获取用户的信息
            $a_data['user'] = $this->user_model->get_user_one($_SESSION['user_id']);
            $this->view->display('user_mine', $a_data);
        }
    }

    /************************************* 修改头像 *************************************/
    public function update_user_pic()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_FILES['user_pic']) && !empty($_FILES['user_pic'])) {
                $s_file_name = time() . $_FILES['user_pic']['name'];
                $result      = move_uploaded_file($_FILES['user_pic']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/upload/user/' . $s_file_name);
                if ($result) {
                    // 保存数据库
                    $this->user_model->update_user(['user_id' => $_SESSION['user_id']], ['user_pic' => '/upload/user/' . $s_file_name]);
                    echo json_encode(['code' => 200, 'msg' => '上传成功']);
                } else {
                    echo json_encode(['code' => 400, 'msg' => '上传失败']);
                }
            }
        }
    }

    /************************************* 设置匿名 *************************************/

    public function comment_anonymous()
    {
        $comment_id = trim($this->general->post('comment_id'));
        // 查询一条评论
        $a_comment = $this->user_model->get_comment_one($comment_id);
        if ($a_comment['is_anonymous'] == 0) {
            $a_data = [
                'is_anonymous' => 1
            ];
        } else {
            $a_data = [
                'is_anonymous' => 0
            ];
        }
        $a_where  = [
            'comment_id' => $comment_id
        ];
        $i_result = $this->user_model->update_comment($a_where, $a_data);
        if ($i_result) {
            echo json_encode(array('code' => 200, 'msg' => '设置成功'));
        } else {
            echo json_encode(array('code' => 400, 'msg' => '设置失败'));
        }
    }

    /*********************************** 删除一条评论 ***********************************/

    public function comment_delete()
    {
        $comment_id = trim($this->general->post('comment_id'));
        // 获取一条评论信息
        $a_comment   = $this->user_model->get_comment_one($comment_id);
        $comtag_type = $a_comment['comment_type'];
        if (!empty($a_comment['comment_tags'])) {
            $tag_arr = explode(',', $a_comment['comment_tags']);
            for ($i = 0; $i < count($tag_arr); $i++) {
                $a_comtag = $this->user_model->get_tag_one($a_comment['store_id'], $tag_arr[$i], $comtag_type);
                $a_uwhere = [
                    'comtag_id' => $a_comtag['comtag_id'],
                ];
                $a_udata  = [
                    'comment_count' => $a_comtag['comment_count'] - 1,
                ];
                $this->user_model->update_comtag($a_uwhere, $a_udata);
            }
        }
        $i_result = $this->user_model->delete_comment($comment_id);
        if ($i_result) {
            echo json_encode(array('code' => 200, 'msg' => '删除成功'));
        } else {
            echo json_encode(array('code' => 400, 'msg' => '删除失败'));
        }
    }

    /*********************************** 获取更多评论 ***********************************/

    public function comment_getmore()
    {
        // 接收页码
        $page = trim($this->general->post('page'));
        // 获取一条用户信息
        $a_data['user'] = $this->user_model->get_user_one($_SESSION['user_id']);
        // 获取用户的评价
        $a_data['comment'] = $this->user_model->get_user_comment($_SESSION['user_id'], $page);
        if (!empty($a_data['comment'])) {
            foreach ($a_data['comment'] as $key => $value) {
                $value['comment_time'] = date('Y-m-d H:i:s', $value['comment_time']);
                $value['comment_tags'] = str_replace(',', '、', $value['comment_tags']);
                if (!empty($value['store_touxiang'])) {
                    $value['store_touxiang'] = '<img src="' . get_config_item('store_touxiang') . $value['store_touxiang'] . '">';
                } else {
                    $value['store_touxiang'] = '<img src="static/style_default/images/pingjia_07.png"/>';
                }
                if (!empty($value['store_introduction'])) {
                    $value['store_introduction'] = substr($value['store_introduction'], 0, 36);
                }
                $new_data[] = $value;
            }
            $a_data['comment'] = $new_data;
            echo json_encode(array('code' => 200, 'msg' => '获取成功', 'data' => $a_data));
        } else {
            echo json_encode(array('code' => 400, 'msg' => '没有更多数据了', 'data' => ''));
        }
    }

    /************************************* 邀请好友 *************************************/

    public function user_invitation()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // 获取一条用户信息
            $a_data = $this->user_model->get_user_one($_SESSION['user_id']);
            $this->view->display('user_invitation', $a_data);
        }
    }

    /************************************* 设置中心 *************************************/

    public function user_set()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //获取用户的信息分配到模板
            $a_data = $this->user_model->get_user_one($_SESSION['user_id']);
            $this->view->display('user_set', $a_data);
        }
    }

    /************************************* 是否推送 *************************************/

    public function user_ispush()
    {
        $thisstate = trim($this->general->post('thisstate'));
        $a_where   = [
            'user_id' => $_SESSION['user_id'],
        ];
        if ($thisstate == 1) {
            $a_data = [
                'user_ispush' => 2,
            ];
        } else {
            $a_data = [
                'user_ispush' => 1,
            ];
        }
        $i_result = $this->user_model->update_user($a_where, $a_data);
        if ($i_result) {
            echo json_encode(array('code' => 200, 'msg' => '设置成功'));
        } else {
            echo json_encode(array('code' => 400, 'msg' => '设置失败'));
        }
    }

    /************************************* 意见反馈 *************************************/

    public function user_feedback()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // 接收信息
            $feedback_content = trim($this->general->post('feedback_content'));
            // 验证数据
            $a_parameter = [
                'msg'  => '这是提示信息',
                'url'  => 'user_set',
                'code' => 400,
            ];
            // 验证是否为空
            if (empty($feedback_content)) {
                $a_parameter['msg'] = '必填项不能为空';
                exit(json_encode($a_parameter));
            }
            // 组装数据
            $a_data   = [
                'user_id'          => $_SESSION['user_id'],
                'feedback_content' => $feedback_content,
                'feedback_time'    => $_SERVER['REQUEST_TIME'],
            ];
            $i_result = $this->user_model->insert_feedback($a_data);
            if ($i_result) {
                $a_parameter['msg']  = '提交成功，感谢您的反馈';
                $a_parameter['code'] = 200;
                exit(json_encode($a_parameter));
            } else {
                $a_parameter['msg'] = '提交失败';
                exit(json_encode($a_parameter));
            }
        } else {
            $this->view->display('user_feedback');
        }
    }

    /************************************* 关于我们 *************************************/

    public function about_our()
    {
        $this->view->display('about_our');
    }

    /************************************* 修改资料 *************************************/

    public function user_update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //获取用户的信息
            $a_data['user'] = $this->user_model->get_user_one($_SESSION['user_id']);

            $this->view->display('user_update2', $a_data);
        }
    }

    /************************************ 我的二维码 ************************************/

    public function user_erweima()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // 获取用户信息
            $a_data = $this->user_model->get_user_one($_SESSION['user_id']);
            if (empty($a_data['user_erweima'])) {
                // 生成二维码文件
                $this->load->library('phpqrcode');
                $a_param = [
                    // 要生成二维码的数据，必填
                    'data'      => $_SESSION['user_id'],
                    // 二维码文件生成路径，选填，不设置将直接浏览器输出，设置此参数，二维码将不直接输出，而是生成文件
                    'file_name' => './upload/user/qrcode_' . $_SESSION['user_id'] . '.png',
                    // 二维码图片大小，选填，默认4
                    'size'      => 10,
                    // 二维码错误修正级别L/M/Q/H，选填，默认“L”。L水平 7% 的字码可被修正，M水平 15% 的字码可被修正，Q水平 25% 的字码可被修正，H水平 30% 的字码可被修正
                    'level'     => 'L'
                ];
                $this->phpqrcode->qrcode($a_param);
                // 更新用户信息
                $a_where = [
                    'user_id' => $_SESSION['user_id'],
                ];
                $a_data  = [
                    'user_erweima' => 'upload/user/qrcode_' . $_SESSION['user_id'] . '.png',
                ];
                $this->user_model->update_user($a_where, $a_data);
                $a_data = $this->user_model->get_user_one($_SESSION['user_id']);
            }
            $this->view->display('user_erweima', $a_data);
        }
    }

    /************************************* 修改性别 *************************************/

    public function update_sex()
    {
        $user_sex = trim($this->general->post('user_sex'));
        $b_result = in_array($user_sex, [0, 1, 2]);
        if (!$b_result) {
            $user_sex = 0;
        }
        $a_where  = [
            'user_id' => $_SESSION['user_id'],
        ];
        $a_data   = [
            'user_sex'    => $user_sex,
            'update_time' => $_SERVER['REQUEST_TIME'],
        ];
        $i_result = $this->user_model->update_user($a_where, $a_data);
        if ($i_result) {
            echo json_encode(array('code' => 200, 'msg' => '修改成功'));
        } else {
            echo json_encode(array('code' => 400, 'msg' => '修改失败'));
        }
    }

    /************************************* 解除绑定 *************************************/

    public function user_unbind()
    {
        $type    = trim($this->general->post('type'));
        $a_where = [
            'user_id' => $_SESSION['user_id'],
        ];
        // type值为2表示解除QQ 为1表示解除微信
        if ($type == 2) {
            $a_data = [
                'qq_openid'   => '',
                'qq_nickname' => '',
                'update_time' => $_SERVER['REQUEST_TIME'],
            ];
        } else {
            $a_data = [
                'weixin_openid' => '',
                'update_time'   => $_SERVER['REQUEST_TIME'],
            ];
        }
        $i_result = $this->user_model->update_user($a_where, $a_data);
        if ($i_result) {
            echo json_encode(array('code' => 200, 'msg' => '解除成功'));
        } else {
            echo json_encode(array('code' => 400, 'msg' => '解除失败'));
        }
    }

    /************************************* 修改昵称 *************************************/

    public function update_nickname()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $a_data['user'] = $this->user_model->get_user_one($_SESSION['user_id']);
            $this->view->display('update_nickname', $a_data);
        } else {
            $user_nickname = trim($this->general->post('user_nickname'));
            $a_where       = [
                'user_id' => $_SESSION['user_id'],
            ];
            $a_data        = [
                'user_nickname' => $user_nickname
            ];
            $i_result      = $this->user_model->update_user($a_where, $a_data);
            if ($i_result) {
                echo json_encode(array('code' => 200, 'msg' => '修改成功'));
            } else {
                echo json_encode(array('code' => 400, 'msg' => '修改失败'));
            }
        }
    }

    /*********************************** 换绑手机号码 ***********************************/

    public function user_phone()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //接收用户信息
            $user_phone = trim($this->general->post('user_phone'));
            $user_code  = trim($this->general->post('user_code'));
            // $user_password = trim($this->general->post('user_password'));
            $a_parameter = [
                'msg'  => '验证码不正确',
                'url'  => 'user_phone',
                'log'  => false,
                'code' => 400,

            ];
            // 验证验证码是否正确
            if (intval($user_code) != $_SESSION['code']) {
                exit(json_encode($a_parameter));
            }
            // 验证手机号码是否和接收验证码的手机一致
            if ($user_phone != $_SESSION['user_phone']) {
                $a_parameter['msg'] = '请输入正确的手机号码';
                exit (json_encode($a_parameter));
            }
            // 获取账号信息
            $a_data = $this->user_model->get_user_one($_SESSION['user_id']);
            // 验证手机号码是否与旧号码一致
            if (!empty($a_data['user_phone'])) {
                if ($a_data['user_phone'] == $user_phone) {
                    $a_parameter['msg']  = '绑定成功';
                    $a_parameter['code'] = 200;
                    $a_parameter['url']  = 'user_update';
                    exit (json_encode($a_parameter));
                }
            }
            // 验证手机号码是否被占用
            $a_uphone = $this->user_model->get_user_byphone($user_phone);
            if ($a_uphone) {
                $a_parameter['msg'] = '手机号码已被占用';
                exit(json_encode($a_parameter));
            }
            // 验证通过后更新字段
            $a_where  = [
                'user_id' => $_SESSION['user_id'],
            ];
            $a_udata  = [
                'user_phone' => $user_phone
            ];
            $i_result = $this->user_model->update_user($a_where, $a_udata);
            if ($i_result) {
                $a_parameter['msg']  = '绑定成功';
                $a_parameter['code'] = 200;
                $a_parameter['url']  = 'user_update';
                exit(json_encode($a_parameter));
            } else {
                $a_parameter['msg'] = '绑定失败';
                exit(json_encode($a_parameter));
            }
        } else {
            $this->view->display('user_phone2');
        }
    }

    /*********************************** 修改登录密码 ***********************************/

    public function user_password()
    {
        // type值为1代表通过旧密码方式找回 type值为2代表通过手机方式找回
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $type              = trim($this->general->post('type'));
            $a_parameter       = [
                'msg'  => '旧密码不正确',
                'url'  => 'user_update',
                'log'  => false,
                'wait' => 2,
            ];
            $special_character = array('!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '+', '=', '~', '·', '<', '>', ',', '.', '。', '，', '?', '/', '\\', '|', ':', ';', '[', ']', '【', '】', '{', '}', '"', "'", '`');
            $a_where           = [
                'user_id' => $_SESSION['user_id']
            ];
            if ($type == 1) {
                //接收数据
                $password_old = trim($this->general->post('password_old'));
                $password_new = trim($this->general->post('password_new'));
                // 验证数据是否为空
                if (empty($password_old) || empty($password_new)) {
                    $a_parameter['msg'] = '必填项不能为空';
                    $this->error->show_error($a_parameter);
                }
                // 验证新密码是否含有特殊字符串
                for ($i = 0; $i < strlen($password_new); $i++) {
                    $name_array[] = $password_new[$i];
                }
                for ($i = 0; $i < count($name_array); $i++) {
                    if (in_array($name_array[$i], $special_character)) {
                        $a_parameter['msg'] = '密码不能含有特殊符号';
                        $this->error->show_error($a_parameter);
                    }
                }
                // 获取原数据
                $a_data = $this->user_model->get_user_one($_SESSION['user_id']);
                // 验证旧密码与新密码是否一致 如果一致则直接通过
                if ($a_data['user_password'] == md5(md5($password_new))) {
                    $a_parameter['msg'] = '修改密码成功';
                    $this->error->show_success($a_parameter);
                }
                // 验证旧密码是否正确
                if ($a_data['user_password'] == md5(md5($password_old))) {
                    // 旧密码验证通过之后 组装数据保存到数据库
                    $a_password = [
                        'user_password' => md5(md5($password_new)),
                    ];
                    $i_result   = $this->user_model->update_user($a_where, $a_password);
                    if ($i_result) {
                        $a_parameter['msg'] = '修改密码成功';
                        $this->error->show_success($a_parameter);
                    } else {
                        $a_parameter['msg'] = '修改密码失败';
                        $this->error->show_error($a_parameter);
                    }
                } else {
                    $a_parameter['msg'] = '旧密码不正确';
                    $this->error->show_error($a_parameter);
                }
            } else {
                // type值为2代表通过手机验证方式找回
                // 接收数据
                $user_phone    = trim($this->general->post('user_phone'));
                $user_password = trim($this->general->post('user_password'));
                $user_code     = trim($this->general->post('user_code'));
                // 验证数据是否为空
                if (empty($user_phone) || empty($user_password) || empty($user_code)) {
                    $a_parameter['msg'] = '必填项不能为空';
                    $this->error->show_error($a_parameter);
                }
                // 验证验证码是否正确
                if ($user_code != $_SESSION['code']) {
                    $a_parameter['msg'] = '验证码不正确';
                    $this->error->show_error($a_parameter);
                }
                // 验证手机号码是否和接收验证码的手机一致
                if ($user_phone != $_SESSION['user_phone']) {
                    $a_parameter['mag'] = '请输入正确的手机号码';
                    $this->error->show_error($a_parameter);
                }
                // 验证新密码是否含有特殊字符串
                for ($i = 0; $i < strlen($user_password); $i++) {
                    $name_array[] = $user_password[$i];
                }
                for ($i = 0; $i < count($name_array); $i++) {
                    if (in_array($name_array[$i], $special_character)) {
                        $a_parameter['msg'] = '密码不能含有特殊符号';
                        $this->error->show_error($a_parameter);
                    }
                }
                // 验证账号是否一致
                $a_data = $this->user_model->get_user_one($_SESSION['user_id']);
                if ($a_data['user_phone'] != $user_phone) {
                    $a_parameter['msg'] = '请输入本账号绑定的手机号码';
                }
                // 验证通过将新数据保存到数据库
                $a_password = [
                    'user_password' => md5(md5($user_password)),
                    'update_time'   => $_SERVER['REQUEST_TIME'],
                ];
                $i_result   = $this->user_model->update_user($a_where, $a_password);
                if ($i_result) {
                    $a_parameter['msg'] = '修改密码成功';
                    $this->error->show_success($a_parameter);
                } else {
                    $a_parameter['msg'] = '修改密码失败';
                    $this->error->show_error($a_parameter);
                }
            }
        } else {
            $type = $this->router->get(1);
            if ($type == 1) {
                $this->view->display('password_old2');
            } else {
                // 获取用户信息
                $a_data = $this->user_model->get_user_one($_SESSION['user_id']);
                $this->view->display('password_phone2', $a_data);
            }
        }
    }

    /*********************************** 设置支付密码 ***********************************/

    public function user_payment()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_phone    = trim($this->general->post('user_phone'));
            $user_code     = trim($this->general->post('user_code'));
            $payment_code  = trim($this->general->post('payment_code'));
            $payment_code2 = trim($this->general->post('payment_code2'));
            //验证数据合法性
            $a_parameter = [
                'msg'  => '验证码不正确',
                'url'  => 'user_update',
                'log'  => false,
                'wait' => 2,
            ];
            // 验证验证码是否正确
            if (empty($user_phone) || empty($user_code) || empty($payment_code) || empty($payment_code2)) {
                $a_parameter['msg'] = '必填项不能为空';
                $this->error->show_error($a_parameter);
            }
            // 验证验证码是否正确
            if ($user_code != $_SESSION['code']) {
                $a_parameter['msg'] = '验证码不正确';
                $this->error->show_error($a_parameter);
            }
            // 验证手机号码是否一致
            if ($user_phone != $_SESSION['user_phone']) {
                $a_parameter['msg'] = '手机号码有误';
                $this->error->show_error($a_parameter);
            }
            // 验证两次支付密码是否一致
            if ($payment_code != $payment_code2) {
                $a_parameter['msg'] = '两次支付密码输入不一致';
                $this->error->show_error($a_parameter);
            }
            // 验证支付密码位数
            if (strlen($payment_code) != 6) {
                $a_parameter['msg'] = '支付密码只能是六位纯数字';
                $this->error->show_error($a_parameter);
            }
            $a_data = $this->user_model->get_user_one($_SESSION['user_id']);
            // 验证手机号码是否是之前绑定的手机号码
            if (!empty($a_data['user_phone'])) {
                if ($user_phone != $a_data['user_phone']) {
                    $a_parameter['msg'] = '请使用当前账号绑定的手机号码进行操作';
                    $this->error->show_error($a_parameter);
                }
            } else {
                // 验证手机号码是否被占用
                $a_uphone = $this->user_model->get_user_byphone($user_phone);
                if ($a_uphone) {
                    $a_parameter['msg'] = '当前手机号码已经被占用';
                    $this->error->show_error($a_parameter);
                }
            }
            // 验证之前是否和之前的支付密码一致 如果一致则跳过下方操作
            if (!empty($a_data['payment_code']) && ($a_data['payment_code'] == md5(md5($payment_code)))) {
                $a_parameter['msg'] = '设置成功';
                $this->error->show_success($a_parameter);
            }
            // 验证通过后将数据保存到数据库
            $a_where = [
                'user_id' => $_SESSION['user_id']
            ];
            if (empty($a_data['user_phone'])) {
                $a_data = [
                    'payment_code' => md5(md5($payment_code)),
                    'user_phone'   => $user_phone,
                ];
            } else {
                $a_data = [
                    'payment_code' => md5(md5($payment_code)),
                ];
            }
            $i_result = $this->user_model->update_user($a_where, $a_data);
            if ($i_result) {
                $a_parameter['msg'] = '设置成功';
                $this->error->show_success($a_parameter);
            } else {
                $a_parameter['msg'] = '设置失败';
                $this->error->show_error($a_parameter);
            }
        } else {
            $this->view->display('user_payment2');
        }
    }

    /**
     * 远程生成二维码，用于帮家洁项目生成用户二维码
     * @router http://server.name/upload.qrcode
     */
    public function remote_update_qrcode()
    {
        $user_id = (int)$this->router->get(1);
        // 获取用户信息
        $a_data = $this->user_model->get_user_one($user_id);
        if (!$a_data['user_erweima']) {
            // 生成二维码文件
            $this->load->library('phpqrcode');
            $a_param = [
                // 要生成二维码的数据，必填
                'data'      => $user_id,
                // 二维码文件生成路径，选填，不设置将直接浏览器输出，设置此参数，二维码将不直接输出，而是生成文件
                'file_name' => './upload/user/qrcode_' . $user_id . '.png',
                // 二维码图片大小，选填，默认4
                'size'      => 10,
                // 二维码错误修正级别L/M/Q/H，选填，默认“L”。L水平 7% 的字码可被修正，M水平 15% 的字码可被修正，Q水平 25% 的字码可被修正，H水平 30% 的字码可被修正
                'level'     => 'L'
            ];
            $this->phpqrcode->qrcode($a_param);
            // 更新用户信息
            $this->user_model->update_user(compact('user_id'), ['user_erweima' => 'upload/user/qrcode_' . $user_id . '.png']);
        }
    }

    /*********************************** 修改支付密码 ***********************************/

    public function update_payment()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // 接收数据
            $old1         = trim($this->general->post('old1'));
            $old2         = trim($this->general->post('old2'));
            $old3         = trim($this->general->post('old3'));
            $old4         = trim($this->general->post('old4'));
            $old5         = trim($this->general->post('old5'));
            $old6         = trim($this->general->post('old6'));
            $newone1      = trim($this->general->post('newone1'));
            $newone2      = trim($this->general->post('newone2'));
            $newone3      = trim($this->general->post('newone3'));
            $newone4      = trim($this->general->post('newone4'));
            $newone5      = trim($this->general->post('newone5'));
            $newone6      = trim($this->general->post('newone6'));
            $newtwo1      = trim($this->general->post('newtwo1'));
            $newtwo2      = trim($this->general->post('newtwo2'));
            $newtwo3      = trim($this->general->post('newtwo3'));
            $newtwo4      = trim($this->general->post('newtwo4'));
            $newtwo5      = trim($this->general->post('newtwo5'));
            $newtwo6      = trim($this->general->post('newtwo6'));
            $old_payment  = $old1 . $old2 . $old3 . $old4 . $old5 . $old6;
            $new_payment1 = $newone1 . $newone2 . $newone3 . $newone4 . $newone5 . $newone6;
            $new_payment2 = $newtwo1 . $newtwo2 . $newtwo3 . $newtwo4 . $newtwo5 . $newtwo6;
            // 验证数据
            $a_parameter = [
                'msg'  => '这是提示信息',
                'url'  => 'user_update',
                'log'  => false,
                'wait' => 2,
            ];
            // 验证两次密码输入是否一致
            if ($new_payment1 != $new_payment2) {
                $a_parameter['msg'] = '两次支付密码输入不一致';
                $this->error->show_error($a_parameter);
            }
            // 验证旧密码是否正确
            $a_user = $this->user_model->get_user_one($_SESSION['user_id']);
            if (md5(md5($old_payment)) != $a_user['payment_code']) {
                $a_parameter['msg'] = '旧密码输入错误';
                $this->error->show_error($a_parameter);
            }
            // 验证通过则保存新密码
            $a_where  = [
                'user_id' => $_SESSION['user_id'],
            ];
            $a_data   = [
                'payment_code' => md5(md5($new_payment1)),
                'update_time'  => $_SERVER['REQUEST_TIME'],
            ];
            $i_result = $this->user_model->update_user($a_where, $a_data);
            if ($i_result) {
                $a_parameter['msg'] = '修改成功';
                $this->error->show_success($a_parameter);
            } else {
                $a_parameter['msg'] = '修改失败';
                $this->error->show_error($a_parameter);
            }
        } else {
            $this->view->display('update_payment');
        }
    }

    /*********************************** 重置支付密码 ***********************************/

    public function reset_payment()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_code    = trim($this->general->post('user_code'));
            $newone1      = trim($this->general->post('newone1'));
            $newone2      = trim($this->general->post('newone2'));
            $newone3      = trim($this->general->post('newone3'));
            $newone4      = trim($this->general->post('newone4'));
            $newone5      = trim($this->general->post('newone5'));
            $newone6      = trim($this->general->post('newone6'));
            $newtwo1      = trim($this->general->post('newtwo1'));
            $newtwo2      = trim($this->general->post('newtwo2'));
            $newtwo3      = trim($this->general->post('newtwo3'));
            $newtwo4      = trim($this->general->post('newtwo4'));
            $newtwo5      = trim($this->general->post('newtwo5'));
            $newtwo6      = trim($this->general->post('newtwo6'));
            $new_payment1 = $newone1 . $newone2 . $newone3 . $newone4 . $newone5 . $newone6;
            $new_payment2 = $newtwo1 . $newtwo2 . $newtwo3 . $newtwo4 . $newtwo5 . $newtwo6;
            // 验证数据合法性
            $a_parameter = [
                'msg'  => '这是提示信息',
                'url'  => 'user_update',
                'log'  => false,
                'wait' => 2,
            ];
            // 验证必填项是否为空
            if (empty($user_code) || strlen($new_payment1) != 6 || strlen($new_payment2) != 6) {
                $a_parameter['msg'] = '必填项不能为空';
                $this->error->show_error($a_parameter);
            }
            // 验证验证码是否正确
            if ($user_code != $_SESSION['code']) {
                $a_parameter['msg'] = '验证码不正确';
                $this->error->show_error($a_parameter);
            }
            // 验证两次密码是否一致
            if ($new_payment1 != $new_payment2) {
                $a_parameter['msg'] = '两次支付密码输入不一致';
                $this->error->show_error($a_parameter);
            }
            // 验证通过后将新密码保存到数据库
            $a_where  = [
                'user_id' => $_SESSION['user_id'],
            ];
            $a_data   = [
                'payment_code' => md5(md5($new_payment1)),
                'update_time'  => $_SERVER['REQUEST_TIME'],
            ];
            $i_result = $this->user_model->update_user($a_where, $a_data);
            if ($i_result) {
                $a_parameter['msg'] = '修改成功';
                $this->error->show_success($a_parameter);
            } else {
                $a_parameter['msg'] = '修改失败';
                $this->error->show_error($a_parameter);
            }
        } else {
            // 获取用户信息
            $a_data = $this->user_model->get_user_one($_SESSION['user_id']);
            $this->view->display('reset_payment2', $a_data);
        }
    }

    /*********************************** 申请移动店主 ***********************************/

    public function apply_shopman()
    {
        // 获取一条用户信息
        $a_user = $this->user_model->get_user_one($_SESSION['user_id']);
        if ($a_user['is_shopman'] == 0) {
            $a_where  = [
                'user_id' => $_SESSION['user_id'],
            ];
            $a_data   = [
                'is_shopman'      => 2,
                'shopman_regtime' => $_SERVER['REQUEST_TIME'],
            ];
            $i_result = $this->user_model->update_user($a_where, $a_data);
            if ($i_result) {
                // 申请成功则插入一条消息记录
                $a_data = [
                    'ues'       => 1,
                    'ues_id'    => $_SESSION['user_id'],
                    'ues_name'  => $_SESSION['user_name'],
                    'content'   => '移动店主申请',
                    'examine'   => 1,
                    'mess_time' => $_SERVER['REQUEST_TIME']
                ];
                $this->user_model->insert_messagess($a_data);
                echo json_encode(array('code' => 200, 'msg' => '申请成功'));
            } else {
                echo json_encode(array('code' => 400, 'msg' => '申请失败'));
            }
        } elseif ($a_user['is_shopman'] == 2) {
            echo json_encode(array('code' => 300, 'msg' => '申请已提交，请等待管理员的审核！'));
        } else {
            $i_result = false;
        }

    }

    /*********************************** 移动店主详情 ***********************************/

    public function shopman_detail()
    {
        $todaystart = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $user_id    = $_SESSION['user_id'];
        // 验证移动店主状态
        $a_user      = $this->user_model->get_user_one($user_id);
        $today_mony  = 0;
        $month_mony  = 0;
        $month_score = 0;
        if ($a_user['is_shopman'] == 1) {
            // 获取当月的统计
            $beginThismonth = mktime(0, 0, 0, date('m'), 1, date('Y'));
            $a_statistic    = $this->user_model->get_statistic_one($user_id, $beginThismonth);
            if ($a_statistic && !empty($a_statistic['user_otherorder'])) {
                $order_ids = explode(',', $a_statistic['user_otherorder']);
                $a_order   = $this->user_model->get_order_referee($order_ids);
                foreach ($a_order as $key => $value) {
                    if ($value['time_create'] > $todaystart) {
                        $today_mony = $today_mony + $value['goods_amount'];
                    }
                    $month_mony  = $month_mony + $value['goods_amount'];
                    $month_score = $month_score + $value['order_commission'];
                }
                $a_data['order'] = $a_order;
            } else {
                $a_data['order'] = array();
            }
            $a_data['today_mony']  = $today_mony;
            $a_data['month_mony']  = $month_mony;
            $a_data['month_score'] = $month_score;
            $this->view->display('shopman_detail2', $a_data);
        }
    }

    /*********************************** 月度收支明细 ***********************************/

    public function shopman_income()
    {
        $beginThismonth = $this->router->get(1);
        $user_id        = $_SESSION['user_id'];
        $month_mony     = 0;
        $month_score    = 0;
        // 获取当月的统计
        $a_statistic = $this->user_model->get_statistic_one($user_id, $beginThismonth);
        if ($a_statistic && !empty($a_statistic['user_otherorder'])) {
            $order_ids = explode(',', $a_statistic['user_otherorder']);
            $a_order   = $this->user_model->get_order_referee($order_ids);
            foreach ($a_order as $key => $value) {
                $month_mony  = $month_mony + $value['goods_amount'];
                $month_score = $month_score + $value['order_commission'];
            }
            $a_data['order'] = $a_order;
        } else {
            $a_data['order'] = array();
        }
        $a_data['month_mony']  = $month_mony;
        $a_data['month_score'] = $month_score;
        $a_data['time']        = $beginThismonth;
        $this->view->display('shopman_income', $a_data);
    }

    /********************************** 我的推荐人列表 **********************************/

    public function user_referee()
    {
        $a_data = $this->user_model->get_myreferees($_SESSION['user_id']);
        $this->view->display('user_referee2', $a_data);
    }

    /************************************ 推荐人搜索 ************************************/

    public function referee_search()
    {
        $keywords = $this->general->post('keywords');
        if (empty($keywords)) {
            $a_data = $this->user_model->get_myreferees($_SESSION['user_id']);
        } else {
            $a_data = $this->user_model->get_referee_search($keywords);
        }
        if (empty($a_data)) {
            echo json_encode(array('code' => 400, 'msg' => '未搜索到任何内容', 'data' => ''));
        } else {
            echo json_encode(array('code' => 200, 'msg' => '获取成功', 'data' => $a_data));
        }
    }

    /************************************* 我的动态 *************************************/

    public function user_mood()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //获取用户的基本信息
            $a_data['user'] = $this->user_model->get_user_one($_SESSION['user_id']);
            //获取用户发表的动态信息
            $a_data['mood'] = $this->user_model->get_user_mood($_SESSION['user_id'], 1);
            if (!empty($a_data['mood'])) {
                foreach ($a_data['mood'] as $key => $value) {
                    if ($value['mood_type'] == 2) {
                        // 获取转发的那条动态
                        $a_mood_row           = $this->user_model->get_mood_one($value['relay_mood']);
                        $a_user_row           = $this->user_model->get_user_one($a_mood_row['user_id']);
                        $value['relay_uname'] = $a_user_row['user_name'];
                        $value['replay_upic'] = $a_user_row['user_pic'];
                        $value['replay_mcon'] = $a_mood_row['mood_content'];
                        $value['replay_mid']  = $a_mood_row['mood_id'];
                    }
                    $new_data[] = $value;
                }
                $a_data['mood'] = $new_data;
            } else {
                $a_data['mood'] = array();
            }
            // 查询新消息条数
            $a_data['msgcount'] = $this->user_model->get_newmsg_count($_SESSION['user_id']);
            $this->view->display('user_mood2', $a_data);
        }
    }

    /************************************* 删除动态 *************************************/

    public function mood_delete()
    {
        $mood_id  = trim($this->general->post('mood_id'));
        $i_result = $this->user_model->delete_mood($mood_id);
        if ($i_result) {
            echo json_encode(array('code' => 200, 'msg' => '删除成功'));
        } else {
            echo json_encode(array('code' => 400, 'msg' => '删除失败'));
        }
    }

    /*********************************** 获取更多动态 ***********************************/

    public function mood_getmore()
    {
        // 接收需要加载的页码
        $page = trim($this->general->post('page'));
        //获取用户发表的动态信息
        $a_data = $this->user_model->get_user_mood($_SESSION['user_id'], $page);
        if (empty($a_data)) {
            echo json_encode(array('code' => 400, 'msg' => '没有更多数据了'));
        } else {
            foreach ($a_data as $key => $value) {
                if ($value['mood_type'] == 2) {
                    // 获取转发的那条动态
                    $a_mood_row           = $this->user_model->get_mood_one($value['relay_mood']);
                    $a_user_row           = $this->user_model->get_user_one($a_mood_row['user_id']);
                    $value['relay_uname'] = $a_user_row['user_name'];
                    $value['replay_upic'] = $a_user_row['user_pic'];
                    $value['replay_mcon'] = $a_mood_row['mood_content'];
                    $value['replay_mid']  = $a_mood_row['mood_id'];
                }
                $value['mood_time'] = date('m-d', $value['mood_time']);
                $new_data[]         = $value;
            }
            echo json_encode(array('code' => 200, 'msg' => '获取成功', 'data' => $new_data));
        }
    }

    /************************************* 动态详情 *************************************/

    public function umood_detail()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // 接收动态id
            $mood_id = $this->router->get(1);
            // 获取详情
            $a_data['mood'] = $this->user_model->get_mood_one($mood_id);
            // 判断是否是转发的
            if ($a_data['mood']['mood_type'] == 2) {
                // 获取转发的那条动态
                $a_mood_row                    = $this->user_model->get_mood_one($a_data['mood']['relay_mood']);
                $a_user_row                    = $this->user_model->get_user_one($a_mood_row['user_id']);
                $a_data['mood']['relay_uname'] = $a_user_row['user_name'];
                $a_data['mood']['replay_upic'] = $a_user_row['user_pic'];
                $a_data['mood']['replay_mcon'] = $a_mood_row['mood_content'];
                $a_data['mood']['replay_mid']  = $a_mood_row['mood_id'];
            }
            // 获取点赞数据
            $a_data['like'] = $this->user_model->get_mood_like($mood_id);
            // 获取转发数据
            $a_data['relay'] = $this->user_model->get_mood_relay($mood_id);
            // 获取用户信息
            $a_data['user'] = $this->user_model->get_user_one($a_data['mood']['user_id']);
            // 获取动态的父级评论
            $a_data['discuss_p'] = $this->user_model->get_discuss_parent($mood_id);
            // 获取动态的子级评论
            $a_data['discuss_s'] = $this->user_model->get_discuss_son($mood_id);
            $this->view->display('umood_detail', $a_data);
        }
    }

    /************************************* 动态消息 *************************************/

    public function user_moodmsg()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            //获取动态消息
            $a_data['msg'] = $this->user_model->get_user_moodmsg($_SESSION['user_id'], 1);
            // 将全部消息设为已读
            $a_uwhere = [
                'user_id' => $_SESSION['user_id']
            ];
            $a_udata  = [
                'msg_view' => 2
            ];
            $this->user_model->update_moodmsg($a_uwhere, $a_udata);
            $this->view->display('user_moodmsg2', $a_data);
        }
    }

    /********************************** 获取更多动态消息 ********************************/

    public function user_moodmsgmore()
    {
        $page   = trim($this->general->post('page'));
        $a_data = $this->user_model->get_user_moodmsg($_SESSION['user_id'], $page);
        if (!empty($a_data)) {
            foreach ($a_data as $key => $value) {
                $value['msg_time'] = date('Y-m-d H:i:s', $value['msg_time']);
                $new_data[]        = $value;
            }
            echo json_encode(array('code' => 200, 'msg' => '获取成功', 'data' => $new_data));
        } else {
            echo json_encode(array('code' => 400, 'msg' => '没有更多数据了'));
        }
    }

    /************************************* 清空消息 *************************************/

    public function moodmsg_clear()
    {
        $user_id  = $_SESSION['user_id'];
        $i_result = $this->user_model->delete_moodmsg($user_id);
        if ($i_result) {
            echo json_encode(array('code' => 200, 'msg' => '已清空'));
        } else {
            echo json_encode(array('code' => 400, 'msg' => '清空失败'));
        }
    }

    /*********************************** 文件上传 ***********************************/

    /**
     * [upload_img 上传文件函数]
     * @param  [array]  $file           [上传文件的信息]
     * @param  [array]  $allow          [允许的文件上传类型]
     * @param  [string] &$error         [引用传递，用来记录错误信息]
     * @param  [string] $path           [文件上传目录]
     * @param  [int]    $maxsize        [1024*1024 允许文件上传的最大大小]
     * @return [string] $target|false   [成功则返回新文件路径 失败返回false]
     */
    public function upload_img($file, $allow, &$error, $path, $maxsize)
    {

        switch ($file['error']) {
            case 1 :
                $error = '超出了上传限制大小';
                return false;
            case 2 :
                $error = '超出了浏览器表单允许的大小';
                return false;
            case 3 :
                $error = '文件上传不完整';
                return false;
            case 4 :
                $error = '请先选择需要上传的文件';
                return false;
            case 7 :
                $error = '服务器繁忙，稍后再试';
                return false;
        }

        // 判断文件大小
        if ($file['size'] > $maxsize) {
            //超出了规定大小
            $error = '上传错误，超出了上传限制大小';
            return false;
        }

        // 判断文件类型
        if (!in_array($file['type'], $allow)) {
            $error = '上传的文件类型不正确';
            return false;
        }

        // 判断文件夹是否存在 不存在则创建
        if (!file_exists($path)) {
            mkdir($path);
        }

        // 拼接新的文件名
        $newname = date('Ymdhis', time()) . rand(111, 999) . strrchr($file['name'], '.');
        $target  = $path . '/' . $newname;

        // 移动临时文件
        $result = move_uploaded_file($file['tmp_name'], $target);
        if ($result) {
            // 移动成功则返回新的文件名
            return $target;
        } else {
            $error = "发生未知错误，上传失败！";
            return false;
        }
    }


}

?>
