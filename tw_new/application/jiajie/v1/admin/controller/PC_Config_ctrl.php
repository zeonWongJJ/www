<?php

class PC_Config_ctrl extends \utils\ViewController
{
    public function index()
    {
        $data = [
            'customize_css' => 'config',
            'customize_js'  => [
                'config_index',
            ]
        ];

        $this->view->display('config/index', $data);
    }
}