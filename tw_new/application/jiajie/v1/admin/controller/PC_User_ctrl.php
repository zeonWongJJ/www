<?php

class PC_User_ctrl extends \utils\ViewController
{
    /**
     * 用户登录
     * @router http://server.name/user.login
     * @return mixed
     */
    public function login()
    {
        $data = [
            'customize_css' => 'login',
            'customize_js'  => 'login'
        ];
        return $this->view->display('user/login', $data);
    }

    public function show_jifen_list()
    {
        $data = [
            'customize_css' => 'user_jifen',
            'customize_js'  => 'user_jifen_list'
        ];
        return $this->view->display('user/user_jifen_list', $data);
    }

    public function show_balance_list()
    {
        $data = [
            'customize_css' => 'user_jifen',
            'customize_js'  => 'user_balance_list'
        ];

        return $this->view->display('user/show_balance_list', $data);
    }
}