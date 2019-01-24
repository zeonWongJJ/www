<?php

$resource = \utils\Router::admin('demand', 'demand');

$routers = [
    'demand.review' => [
        'class'  => 'PC_Demand',
        'method' => 'review'
    ]
];

return array_merge($resource, $routers);
