<?php

class PC_Demand_ctrl extends \utils\ViewController
{
    public function review()
    {
        $data = [
            'customize_css' => 'review',
            'customize_js'  => [
                'demand_review',
            ]
        ];

        $this->view->display('demand/review', $data);
    }
}